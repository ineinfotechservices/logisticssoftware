<?php 
namespace App\Helpers;

class Helper
{
    public static function getCountries($id = 0) {
        if($id > 0) {
            $countries = \DB::table('countries')->where('status',1)->where('id',$id)->first();
        }else{
            $countries = \DB::table('countries')->where('status',1)->get();
        }
        return $countries;
    }

    public static function getStates($id = 0) {
        if($id > 0) {
            $states = \DB::table('states')->where('status',1)->where('countries_id',$id)->get();
        }else{
            $states = \DB::table('states')->where('status',1)->get();
        }
        return $states;
    }

    public static function getIndiaCountry() {
        return \DB::table('countries')->whereRaw('LOWER(title) = "india"')->where('status',1)->first();
    }

    public static function getStatesbyID($id = 0) {
        $states = \DB::table('states')->where('status',1)->where('id',$id)->first();
        return $states;
    }

    
    public static function getCities($id = 0) {
        if($id > 0) {
            $cities = \DB::table('cities')->where('status',1)->where('state_id',$id)->get();
        }else{
            $cities = \DB::table('cities')->where('status',1)->get();
        }
        return $cities;
    }
    

    public static function fileUpload($file, $folder='') {
        $fileName = uniqid().'_'.$file->getClientOriginalName();
        $folderpath = 'uploads/'.$folder.'/';
        $file->move($folderpath, $fileName);
        $filepath = url($folderpath.$fileName);
        return $filepath;
    }
    
    public static function getFileTypeAction() {
        return [
            'aadhar_file'=>'Aadhar Card Copy',
            'electricity_bill_file'=>'Electricity Copy',
            'gst_file'=>'GST Copy',
            'iec_file'=>'IEC Copy',
            'pan_file'=>'PAN Copy',
            'telephone_file'=>'Telephone Copy',
        ];
    }
    
    public static function generateDocumentUploadHTMLforAdd() {
        $types = self::getFileTypeAction();
        $get_session = session()->get('filesobj');
        $html = '';
        if(is_array($get_session) && sizeof($get_session)) {
            foreach($get_session as $key=>$val) {
                $actualtypename = isset($types[$key]) ? $types[$key] : '';
                $html.='
                 <tr>
                        <td>'.$actualtypename.'</td>
                        <td><a target="_blank" href="'.$val.'">View File</a></td>
                        <td><a href="javascript:void(0)" class="btn mini black" onclick=deletetmpFile("'.$key.'")><i class="icon-trash"></i> Delete</a></td>
                 </tr>
                ';
            }
        }else{
            $html.='
            <tr>
                   <td colspan=3>No File yet</td>
            </tr>
           ';
        }

        return $html;
    }

    public static function generateDocumentUploadHTMLforUpdate($object) {
        $types = self::getFileTypeAction();
        
        $html = '';
        $id = isset($object->id) ? $object->id : 0;
        if(is_array($types) && sizeof($types)) {
            foreach($types as $key=>$type) {
                $objectValue = isset($object->$key) ? $object->$key : '';
                if($objectValue!='') {
                    $html.='
                 <tr>
                        <td>'.$type.'</td>
                        <td><a target="_blank" href="'.$objectValue.'">View File</a></td>
                        <td><a href="javascript:void(0)" class="btn mini black" onclick=deleteRealEditDoc("'.$key.'","'.$id.'")><i class="icon-trash"></i> Delete</a></td>
                 </tr>
                ';
                }
                
            }
        }else{
            $html.='
            <tr>
                   <td colspan=3>No File yet</td>
            </tr>
           ';
        }

        return $html;
    }

    public static function get_exporter() {
        return \DB::table('ms_exporter')->where('status','!=',0)->get();
    }

    public static function get_incoterm() {
        return \DB::table('ms_incoterm')->where('status','!=',0)->get();
    }

    public static function ms_currencies() {
        return \DB::table('ms_currencies')->where('status','!=',0)->get();
    }

    public static function ms_equipment_types() {
        return \DB::table('ms_equipment_type')->where('status','!=',0)->get();
    }

    public static function ms_port_of_loading() {
        return \DB::table('ms_port_of_loading')
                ->select('ms_port_of_loading.*','countries.title as country_name')    
                ->leftjoin('countries','countries.id','=','ms_port_of_loading.country_id')
                ->where('ms_port_of_loading.status','!=',0)->get();
    }

    public static function ms_port_of_destination() {
        return \DB::table('ms_port_of_destination')
                ->select('ms_port_of_destination.*','countries.title as country_name')    
                ->leftjoin('countries','countries.id','=','ms_port_of_destination.country_id')
                ->where('ms_port_of_destination.status','!=',0)->get();
    }

    public static function get_roles() {
        return \DB::table('roles')->where('status','!=',0)->get();
    }

    public static function generate_booking_detail_job_number($increment=1) {
        $ms_port_of_destination =  \DB::table('trans_booking_details')->where('status','!=',0)->orderBy('id','desc')->first();
        $company = env('COMPANY_CODE');
        $idx = $ms_port_of_destination->id ?? 0;
        $idnew = $idx + $increment;
        $code = date('Y').'/'.$idnew;
        $new_code = $company.'/'.$code;
        $new_code_check = \DB::table('trans_booking_details')->where('status','!=',0)->where('job_number',$new_code)->count();
        if($new_code_check > 0) {
            $tmpid = $increment+1;
            return self::generate_booking_detail_job_number($tmpid);
        }
        return $new_code;
        
    }

    public static function isAdmin() {
        $role = isset(\Auth::user()->roles_id) ? \Auth::user()->roles_id : 0;
        return ($role == 1) ? true : false;
    }

    public static function isSales() {
        $role = isset(\Auth::user()->roles_id) ? \Auth::user()->roles_id : 0;
        return ($role == 2) ? true : false;
    }

    public static function isCustomerService() {
        $role = isset(\Auth::user()->roles_id) ? \Auth::user()->roles_id : 0;
        return ($role == 3) ? true : false;
    }

    public static function isDocument() {
        $role = isset(\Auth::user()->roles_id) ? \Auth::user()->roles_id : 0;
        return ($role == 4) ? true : false;
    }

    public static function invalidUserRedirect() {
        session()->flash('error', 'You are not authorised user for this');
        return redirect(route('users.dashboard'));
    }
    

    public static function getUserRoleId() {
        return isset(\Auth::user()->roles_id) ? \Auth::user()->roles_id : 0;
    }

    public static function get_stuffing() {
        return [
            1=>"Factory",
            2=>'Doc-CFS'
        ];
    }

    public static function getBookingMomentDetails($idx) {
        return \DB::table('booking_moment_details')->where('trans_booking_details_id',$idx)->where('status','!=',0)->get();
    }

    public static function getBookingVesselHistory($idx) {
        return \DB::table('booking_vessel_history')
                ->select('booking_vessel_history.*','ms_exporter.name as exporter_name','users.name as user_name')
                ->leftjoin('ms_exporter','ms_exporter.id','=','booking_vessel_history.ms_exporter_id')
                ->leftjoin('users','users.id','=','booking_vessel_history.user_id')
                ->where('booking_vessel_history.trans_booking_details_id',$idx)->where('booking_vessel_history.status','!=',0)->get();
    }

    public static function VessenHistoryShowDateTime($datetimedb) {
        if($datetimedb == '') {
            return '';
        }
        return date('d/m/Y H:i',strtotime($datetimedb));
    }

    public static function addVesselHistorybyBookingID($id,$ms_booking_detail) {
        \DB::table('booking_vessel_history')->insert([
            'trans_booking_details_id'=>$id,
            'ms_exporter_id'=>isset($ms_booking_detail->ms_exporter_id) ? $ms_booking_detail->ms_exporter_id : 0,
            'ramp_cut_off_datetime'=>isset($ms_booking_detail->ramp_cut_off_datetime) ? $ms_booking_detail->ramp_cut_off_datetime : NULL,
            'earlist_receiving_datetime'=>isset($ms_booking_detail->earlist_receiving_datetime) ? $ms_booking_detail->earlist_receiving_datetime : NULL,
            'vgm_cut_off_datetime'=>isset($ms_booking_detail->vgm_cut_off_datetime) ? $ms_booking_detail->vgm_cut_off_datetime : NULL,
            'terminal_datetime'=>isset($ms_booking_detail->terminal_datetime) ? $ms_booking_detail->terminal_datetime : NULL,
            'eta_datetime'=>isset($ms_booking_detail->eta_datetime) ? $ms_booking_detail->eta_datetime : NULL,
            'etd_datetime'=>isset($ms_booking_detail->etd_datetime) ? $ms_booking_detail->etd_datetime : NULL,
            'booking_number'=>isset($ms_booking_detail->booking_number) ? $ms_booking_detail->booking_number : NULL,
            'document_cut_off_date_time'=>isset($ms_booking_detail->document_cut_off_date_time) ? $ms_booking_detail->document_cut_off_date_time : NULL,
            'stuffing'=>isset($ms_booking_detail->stuffing) ? $ms_booking_detail->stuffing : 0,
            'si_cut_off_date_time'=>isset($ms_booking_detail->si_cut_off_date_time) ? $ms_booking_detail->si_cut_off_date_time : NULL,
            'eqp_available_datetime'=>isset($ms_booking_detail->eqp_available_datetime) ? $ms_booking_detail->eqp_available_datetime : NULL,
            'booking_file_url'=>isset($ms_booking_detail->booking_file_url) ? $ms_booking_detail->booking_file_url : NULL,
            'booking_detail_remark'=>isset($ms_booking_detail->booking_detail_remark) ? $ms_booking_detail->booking_detail_remark : NULL,
            'vessel_voy'=>isset($ms_booking_detail->vessel_voy) ? $ms_booking_detail->vessel_voy : NULL,
            'user_id'=>\Auth::id(),
        ]);

        \DB::table('trans_booking_details')->where('id',$id)->update([
            'ms_exporter_id'=>0,
            'ramp_cut_off_datetime'=>NULL,
            'earlist_receiving_datetime'=>NULL,
            'vgm_cut_off_datetime'=>NULL,
            'terminal_datetime'=>NULL,
            'eta_datetime'=>NULL,
            'etd_datetime'=>NULL,
            'booking_number'=>NULL,
            'document_cut_off_date_time'=>NULL,
            'stuffing'=>0,
            'si_cut_off_date_time'=>NULL,
            'eqp_available_datetime'=>NULL,
            'booking_file_url'=>NULL,
            'booking_detail_remark'=>NULL,
            'vessel_voy'=>NULL            
        ]);
    }

    public static function ms_get_notify_user() {
        return \DB::table('notify_users')->where('status','!=',0)->get();
    }

    public static function ms_get_delivery_agent() {
        return \DB::table('delivery_agent')->where('status','!=',0)->get();
    }

    public static function getShipperDetailBL($shipperIdx) {
        if($shipperIdx == 0) {
            return 'No Shipper Detail Found...';
        }
        $ms_exporter = \DB::table('ms_exporter')->where('id',$shipperIdx)->where('status','!=',0)->first();
        if($ms_exporter==null) {
            return response()->json(['status' => false, 'msg' => 'No shipper found']);           
        }
        $shipper_name = isset($ms_exporter->name) ? $ms_exporter->name : '';
        $address1 = isset($ms_exporter->address) ? $ms_exporter->address : '';
        $address2 = isset($ms_exporter->address2) ? $ms_exporter->address2 : '';
        $address3 = isset($ms_exporter->address3) ? $ms_exporter->address3 : '';
        $pincode = isset($ms_exporter->pincode) ? $ms_exporter->pincode : '';
        $city_id = isset($ms_exporter->pincode) ? $ms_exporter->pincode : 0;
        $coutry_id = isset($ms_exporter->country) ? $ms_exporter->country : 0;
        $state_id = isset($ms_exporter->state_id) ? $ms_exporter->state_id :0;

        $cities_obj = \DB::table('cities')->where('status','!=',1)->where('id',$city_id)->first();
        $city_name = isset($cities_obj->title) ? $cities_obj->title : '';

        $state_obj = \DB::table('states')->where('status','!=',1)->where('id',$state_id)->first();
        $state_name = isset($state_obj->title) ? $state_obj->title : '';

        $coutry_obj = \DB::table('countries')->where('status','!=',1)->where('id',$coutry_id)->first();
        $country_name = isset($coutry_obj->title) ? $coutry_obj->title : '';

        $html='<div>';
                $html.='<p><strong>'.$shipper_name.'</strong></p>';
                $html.='<p>'.$address1.'</p>';
                $html.='<p>'.$address2.'</p>';
                $html.='<p>'.$address3.'</p>';
                $html.='<p>'.$city_name.'</p>';
                $html.='<p>'.$state_name.'</p>';
                $html.='<p>'.$country_name.'</p>';
                $html.='<p>'.$pincode.'</p>';
        $html.='</div>';

        return $html;
    }

    public static function getConsigneeList() {
        return \DB::table('ms_consignee')->where('status',1)->get();
    }

    public static function getConsigneeById($id) {
        return  \DB::table('ms_consignee')->where('status',1)->where('id',$id)->get();
    }

    public static function getConsigneeDetailBL($dbidx) {
        if($dbidx == 0) {
            return 'No Consignee Detail Found...';
        }
        $ms_db_obj = \DB::table('ms_consignee')->where('id',$dbidx)->where('status','!=',0)->first();
        if($ms_db_obj==null) {
            return response()->json(['status' => false, 'msg' => 'No shipper found']);           
        }
        $full_name = isset($ms_db_obj->full_name) ? $ms_db_obj->full_name : '';
        $address1 = isset($ms_db_obj->address) ? $ms_db_obj->address : '';
        $address2 = isset($ms_db_obj->address2) ? $ms_db_obj->address2 : '';
        $address3 = isset($ms_db_obj->address3) ? $ms_db_obj->address3 : '';
        $pincode = isset($ms_db_obj->pincode) ? $ms_db_obj->pincode : '';
        $city_id = isset($ms_db_obj->pincode) ? $ms_db_obj->pincode : 0;
        $coutry_id = isset($ms_db_obj->country) ? $ms_db_obj->country : 0;
        $state_id = isset($ms_db_obj->state_id) ? $ms_db_obj->state_id :0;

        $cities_obj = \DB::table('cities')->where('status','!=',1)->where('id',$city_id)->first();
        $city_name = isset($cities_obj->title) ? $cities_obj->title : '';

        $state_obj = \DB::table('states')->where('status','!=',1)->where('id',$state_id)->first();
        $state_name = isset($state_obj->title) ? $state_obj->title : '';

        $coutry_obj = \DB::table('countries')->where('status','!=',1)->where('id',$coutry_id)->first();
        $country_name = isset($coutry_obj->title) ? $coutry_obj->title : '';

        $html='<div>';
                $html.='<p><strong>'.$full_name.'</strong></p>';
                $html.='<p>'.$address1.'</p>';
                $html.='<p>'.$address2.'</p>';
                $html.='<p>'.$address3.'</p>';
                $html.='<p>'.$city_name.'</p>';
                $html.='<p>'.$state_name.'</p>';
                $html.='<p>'.$country_name.'</p>';
                $html.='<p>'.$pincode.'</p>';
        $html.='</div>';

        return $html;
    }

    public static function getDeliveryAgentDetailBL($dbidx) {
        if($dbidx == 0) {
            return 'No Delivery Agent Detail Found...';
        }
        $ms_db_obj = \DB::table('delivery_agent')->where('id',$dbidx)->where('status','!=',0)->first();
        if($ms_db_obj==null) {
            return response()->json(['status' => false, 'msg' => 'No shipper found']);           
        }
        $full_name = isset($ms_db_obj->title) ? $ms_db_obj->title : '';
        $address1 = isset($ms_db_obj->address) ? $ms_db_obj->address : '';
        $address2 = isset($ms_db_obj->address2) ? $ms_db_obj->address2 : '';
        $address3 = isset($ms_db_obj->address3) ? $ms_db_obj->address3 : '';
        $pincode = isset($ms_db_obj->pincode) ? $ms_db_obj->pincode : '';
        $city_id = isset($ms_db_obj->pincode) ? $ms_db_obj->pincode : 0;
        $coutry_id = isset($ms_db_obj->country) ? $ms_db_obj->country : 0;
        $state_id = isset($ms_db_obj->state_id) ? $ms_db_obj->state_id :0;

        $cities_obj = \DB::table('cities')->where('status','!=',1)->where('id',$city_id)->first();
        $city_name = isset($cities_obj->title) ? $cities_obj->title : '';

        $state_obj = \DB::table('states')->where('status','!=',1)->where('id',$state_id)->first();
        $state_name = isset($state_obj->title) ? $state_obj->title : '';

        $coutry_obj = \DB::table('countries')->where('status','!=',1)->where('id',$coutry_id)->first();
        $country_name = isset($coutry_obj->title) ? $coutry_obj->title : '';

        $html='<div>';
                $html.='<p><strong>'.$full_name.'</strong></p>';
                $html.='<p>'.$address1.'</p>';
                $html.='<p>'.$address2.'</p>';
                $html.='<p>'.$address3.'</p>';
                $html.='<p>'.$city_name.'</p>';
                $html.='<p>'.$state_name.'</p>';
                $html.='<p>'.$country_name.'</p>';
                $html.='<p>'.$pincode.'</p>';
        $html.='</div>';

        return $html;
    }

    public static function invoice_get_shipper_by_id($id) {
        return \DB::table('ms_exporter')->where('id',$id)->where('status','!=',0)->first();
    }

    public static function invoice_get_consignee_by_id($id) {
        return \DB::table('ms_consignee')->where('id',$id)->where('status','!=',0)->first();
    }

    public static function invoice_get_notify_user_by_id($id) {
        return \DB::table('notify_users')->where('id',$id)->where('status','!=',0)->first();
    }
    public static function getCitybyID($id = 0) {
        $states = \DB::table('cities')->where('status',1)->where('id',$id)->first();
        return $states;
    }
    public static function invoice_get_port_of_loading_by_id($id) {
        return \DB::table('ms_port_of_loading')->where('id',$id)->where('status','!=',0)->first();
    }

    public static function invoice_get_port_of_destination_by_id($id) {
        return \DB::table('ms_port_of_destination')->where('id',$id)->where('status','!=',0)->first();
    }

    public static function getCountrybyID($id = 0) {
        $states = \DB::table('countries')->where('status',1)->where('id',$id)->first();
        return $states;
    }

    public static function getLimitValueByNumber($text, $number) {
        $olddata = explode('<br />',nl2br($text));
        $htmlText = '';
        $startNmber = (($number * 10) - 9);
        if($startNmber == 1) {
            $newdata = array_slice($olddata,0,11,true);
        }else{
            $newdata = array_slice($olddata,$startNmber,10,true);
        }
        
        
        
        if(is_array($newdata) && sizeof($newdata)) {
            foreach($newdata as $dd) {
                $htmlText.=$dd.'<br />';
            }
        }

        return $htmlText;
    }

    public static function checkdate($date) {
        $row = \DB::select("SELECT CURDATE() AS curtime");
        $todayDate = isset($row[0]->curtime) ? $row[0]->curtime : '';
        
    }

    public static function getNotifications() {
        $loops = [];
        $today = date('Y-m-d H:i:s');
        $nextdate = date('Y-m-d H:i:s', strtotime($today. ' + 1 days'));
        
        
            $user_id = \Auth::id();
            $trans_booking_details = \DB::table('trans_booking_details')->where('status','!=',0)->orderBy('id','desc')->get();
            if(is_object($trans_booking_details) && $trans_booking_details->count() > 0) {
                foreach($trans_booking_details as $detail) {
                    if(self::checkdate($detail->etd_datetime)) {
                        $loops['bookings'][] = $detail;
                    }                    
                }
            }

            $trans_followup = \DB::table('trans_followup_details')
                ->leftjoin('trans_followup','trans_followup.id','=','trans_followup_details.trans_followup_id')
                ->whereNotIn('trans_followup.status',[0,4,3])->whereBetween('trans_followup_details.next_followup_date',[$today, $nextdate])->whereIn('trans_followup_details.assign_user_id',[$user_id])->get();
             if(isset($trans_followup) && is_object($trans_followup) && $trans_followup->count()) {
                foreach($trans_followup as $followup) {
                    $loops['followup'][] = $followup;
                }
             }   
        

        return $loops;
    }

    public static function converdatetime2db($date) {
        if($date=='' || $date=='0') return null;
        $datetime = explode(" ",$date);
        $datenew = isset($datetime[0]) ?$datetime[0] : '';
        $timenew = isset($datetime[1]) ? $datetime[1] : '00';
        $dateinfo = explode("/",$datenew);
        $newDateYear = isset($dateinfo[2]) ? $dateinfo[2] : '0000';
        $newDateMonth = isset($dateinfo[1]) ? $dateinfo[1] : '00';
        $newDateDay = isset($dateinfo[0]) ? $dateinfo[0] : '00'; 
        $newdate = $newDateYear.'-'.$newDateMonth.'-'.$newDateDay;
        $newdatetime = $newdate.' '.$timenew;
        return $newdatetime;
    }

    public static function converdb2datetime($date) {
        if($date=='' || $date=='0') return null;
        $newdate = date('d/m/Y H:i',strtotime($date));
        return $newdate;
    }

    public static function getBookingOtherFiles($idx,$type='shipping_bill') {
        $booking_other_files = \DB::table('booking_other_files')->where('other_file_types',strtolower($type))->where('trans_booking_details_id',$idx)->where('status','!=',0)->get();
        return $booking_other_files;
    }

    public static function getFollowupUsers() {
        return \DB::table('users')->where('status','!=',0)->whereIn('roles_id',[1,2])->get();
    }

    public static function FollowupStatus() {
        return [
            1=>'Pending',
            2=>'InProgress',
            3=>'Rejected',
            4=>'Finished'
        ];
    }

    public static function getFollowupStatusbyID($status=0) {
        $followup = self::FollowupStatus();   
        if($status > 0) 
            return isset($followup[$status]) ? $followup[$status] : '';
    } 

    public static function getUserbyId($id) {
        $row = \DB::table('users')->where('id',$id)->where('status','!=',0)->first();
        if($row==null) {
            return '';
        }
        return $row;
    }
}
