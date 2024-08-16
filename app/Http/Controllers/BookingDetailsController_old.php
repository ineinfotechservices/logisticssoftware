<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PDF;

class BookingDetailsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $booking_details = \DB::table('trans_booking_details')->where('status', '!=', 0)->get();
        $data['booking_details'] = $booking_details;
        $countries = \Helper::getCountries();
        $data['countries'] = $countries;
        return view('bookingdetails.index', $data);
    }

    public function add()
    {

        if (\Helper::isCustomerService() || \Helper::isDocument()) {

            session()->flash('error', 'You are not authorised for this');
            return redirect(route('master.booking.index'));
        }

        $exporter = \Helper::get_exporter();
        $incoterm = \Helper::get_incoterm();
        $curencies = \Helper::ms_currencies();
        $equipment_types = \Helper::ms_equipment_types();
        $port_of_loading = \Helper::ms_port_of_loading();
        $port_of_destination = \Helper::ms_port_of_destination();
        $generate_booking_detail_job_number = \Helper::generate_booking_detail_job_number();

        $data['exporter'] = $exporter;
        $data['incoterm'] = $incoterm;
        $data['curencies'] = $curencies;
        $data['equipment_types'] = $equipment_types;
        $data['port_of_loading'] = $port_of_loading;
        $data['port_of_destination'] = $port_of_destination;
        $data['generate_booking_detail_job_number'] = $generate_booking_detail_job_number;
        return view('bookingdetails.add', $data);
    }

    public function save(Request $request)
    {

        if (\Helper::isCustomerService()) {
            session()->flash('error', 'You are not authorised for this');
            return redirect(route('master.booking.index'));
        }

        $validator = Validator::make(
            $request->all(),
            [
                //'job_number' => 'required|unique:trans_booking_details',
                'shipper_name' => 'required',
                'booking_received_from' => 'required',
                'ms_incoterm_id' => 'required|numeric',
                'selling_rate' => 'required|numeric',
                'ms_currencies_id' => 'required|numeric',
                'other_charges' => 'required',
                'shipping_line_rate' => 'required|numeric',
                'ms_equipment_type_id' => 'required|numeric',
                'no_of_container' => 'required|numeric',
                'ms_port_of_loading_id' => 'required|numeric',
                'pickup_location' => 'required',
                'ms_port_of_destination' => 'required|numeric',
                'final_place_of_delivery' => 'required',
            ]
        );

        if ($validator->fails()) {
            //return redirect()->back()->withErrors($validator)->withInput();
            return response()->json(['status' => false, 'msg' => $validator->messages()]);

        }

        $last_id = \DB::table('trans_booking_details')->insertGetId([
            'job_number' => \Helper::generate_booking_detail_job_number(),
            'shipper_name' => $request->shipper_name,
            'booking_received_from' => $request->booking_received_from,
            'ms_incoterm_id' => $request->ms_incoterm_id,
            'selling_rate' => $request->selling_rate,
            'ms_currencies_id' => $request->ms_currencies_id,
            'other_charges' => $request->other_charges,
            'shipping_line_rate' => $request->shipping_line_rate,
            'ms_equipment_type_id' => $request->ms_equipment_type_id,
            'no_of_container' => $request->no_of_container,
            'ms_port_of_loading_id' => $request->ms_port_of_loading_id,
            'pickup_location' => isset($request->pickup_location) ? $request->pickup_location : '',
            'ms_port_of_destination' => isset($request->ms_port_of_destination) ? $request->ms_port_of_destination : '',
            'final_place_of_delivery' => isset($request->final_place_of_delivery) ? $request->final_place_of_delivery : '',
            'booking_detail_remark' => isset($request->booking_detail_remark) ? $request->booking_detail_remark : NULL,
            'user_id' => auth()->user()->id,
        ]);

        if(isset($request->no_of_container) && $request->no_of_container > 0) {
            $no_of_container = $request->no_of_container;
            for($a=0; $a<$no_of_container; $a++) {
                \DB::table('booking_moment_details')->insertGetId([
                    'trans_booking_details_id'=>$last_id
                ]);
            }

        }

        return response()->json(['status' => true, 'msg' => 'Booking Detail created successfully']);
        // session()->flash('success', 'Exporter Created successfully.');
        // return redirect(route('master.bookingdetails.index'));
    }

    public function edit($id)
    {

        $booking_details = \DB::table('trans_booking_details')->where('id', $id)->where('status', '!=', 0)->first();
        if ($booking_details == null) {
            session()->flash('error', 'Invalid Request.');
            return redirect(route('master.booking.index'));
        }
        $exporter = \Helper::get_exporter();
        $incoterm = \Helper::get_incoterm();
        $curencies = \Helper::ms_currencies();
        $equipment_types = \Helper::ms_equipment_types();
        $port_of_loading = \Helper::ms_port_of_loading();
        $port_of_destination = \Helper::ms_port_of_destination();


        $data['exporter'] = $exporter;
        $data['incoterm'] = $incoterm;
        $data['curencies'] = $curencies;
        $data['equipment_types'] = $equipment_types;
        $data['port_of_loading'] = $port_of_loading;
        $data['port_of_destination'] = $port_of_destination;
        $data['booking_detail'] = $booking_details;
        $data['id'] = $booking_details->id ?? 0;

        $booking_moment_details = \Helper::getBookingMomentDetails($booking_details->id ?? 0);
        $data['booking_detail_moment_detail'] = $booking_moment_details;

        $booking_vessel_history = \Helper::getBookingVesselHistory($booking_details->id ?? 0);
        $data['booking_vessel_history_detail'] = $booking_vessel_history;

        $booking_transhipment_details = \DB::table('booking_transhipment_details')
            ->select('booking_transhipment_details.*', 'ms_port_of_destination.title as transhipment_title')
            ->leftjoin('ms_port_of_destination', 'ms_port_of_destination.id', '=', 'booking_transhipment_details.transhipment_port')
            ->where('booking_transhipment_details.trans_booking_details_id', $id)->where('booking_transhipment_details.status', '!=', 0)->get();
        $data['booking_transhipment_details'] = $booking_transhipment_details;
        return view('bookingdetails.edit', $data);
    }

    public function view($id)
    {

        $booking_details = \DB::table('trans_booking_details')->where('id', $id)->where('status', '!=', 0)->first();
        if ($booking_details == null) {
            session()->flash('error', 'Invalid Request.');
            return redirect(route('master.booking.index'));
        }
        $exporter = \Helper::get_exporter();
        $incoterm = \Helper::get_incoterm();
        $curencies = \Helper::ms_currencies();
        $equipment_types = \Helper::ms_equipment_types();
        $port_of_loading = \Helper::ms_port_of_loading();
        $port_of_destination = \Helper::ms_port_of_destination();


        $data['exporter'] = $exporter;
        $data['incoterm'] = $incoterm;
        $data['curencies'] = $curencies;
        $data['equipment_types'] = $equipment_types;
        $data['port_of_loading'] = $port_of_loading;
        $data['port_of_destination'] = $port_of_destination;
        $data['booking_detail'] = $booking_details;
        $data['id'] = $booking_details->id ?? 0;
        return view('bookingdetails.view', $data);
    }

    public function update($id, Request $request)
    {

        $ms_shippingline = \DB::table('trans_booking_details')->where('id', $id)->where('status', '!=', 0)->first();
        if ($ms_shippingline == null) {
            return response()->json(['status' => false, 'msg' => ['ivalid' => ['Invalid Request']]]);
        }

        $validator = Validator::make(
            $request->all(),
            [
                'shipper_name' => 'required',
                'booking_received_from' => 'required',
                'ms_incoterm_id' => 'required|numeric',
                'selling_rate' => 'required|numeric',
                'ms_currencies_id' => 'required|numeric',
                'other_charges' => 'required',
                'shipping_line_rate' => 'required|numeric',
                'ms_equipment_type_id' => 'required|numeric',
                'no_of_container' => 'required|numeric',
                'ms_port_of_loading_id' => 'required|numeric',
                'pickup_location' => 'required',
                'ms_port_of_destination' => 'required|numeric',
                'final_place_of_delivery' => 'required',
                'stuffing' => 'required',
            ]
        );

        if ($validator->fails()) {
            //return redirect()->back()->withErrors($validator)->withInput();
            return response()->json(['status' => false, 'msg' => $validator->messages()]);
        }
        $booking_number = isset($request->booking_number) ? $request->booking_number : '';

        $status = isset($ms_shippingline->status) ? $ms_shippingline->status : 0;
        $pre_no_of_container = isset($ms_shippingline->no_of_container) ? $ms_shippingline->no_of_container : 0;
        $new_no_of_container = isset($request->no_of_container) ? $request->no_of_container : 0;
        if (\Helper::isCustomerService()) {
            $status = 2;
        }

        $common = [
            'shipper_name' => $request->shipper_name,
            'booking_received_from' => $request->booking_received_from,
            'ms_incoterm_id' => $request->ms_incoterm_id,
            'selling_rate' => $request->selling_rate,
            'ms_currencies_id' => $request->ms_currencies_id,
            'other_charges' => $request->other_charges,
            'shipping_line_rate' => $request->shipping_line_rate,
            'ms_equipment_type_id' => $request->ms_equipment_type_id,
            'no_of_container' => $request->no_of_container,
            'ms_port_of_loading_id' => $request->ms_port_of_loading_id,
            'pickup_location' => isset($request->pickup_location) ? $request->pickup_location : '',
            'ms_port_of_destination' => isset($request->ms_port_of_destination) ? $request->ms_port_of_destination : '',
            'final_place_of_delivery' => isset($request->final_place_of_delivery) ? $request->final_place_of_delivery : '',
            'user_id' => auth()->user()->id,
            'status' => $status,
            'booking_detail_remark' => isset($request->booking_detail_remark) ? $request->booking_detail_remark : NULL,
        ];

        $customer_service_dates = [
            'ms_exporter_id' => (isset($request->ms_exporter_id) ? $request->ms_exporter_id : 0),
            'ramp_cut_off_datetime' => (isset($request->ramp_cut_off_datetime) ? \Helper::converdatetime2db($request->ramp_cut_off_datetime) : NULL),
            'earlist_receiving_datetime' => (isset($request->earlist_receiving_datetime) ? \Helper::converdatetime2db($request->earlist_receiving_datetime) : NULL),
            'vgm_cut_off_datetime' => (isset($request->vgm_cut_off_datetime) ? \Helper::converdatetime2db($request->vgm_cut_off_datetime) : NULL),
            'vessel_voy' => (isset($request->vessel_voy) ? $request->vessel_voy : NULL),
            'terminal_datetime' => (isset($request->terminal_datetime) ? \Helper::converdatetime2db($request->terminal_datetime) : NULL),
            'etd_datetime' => (isset($request->etd_datetime) ? \Helper::converdatetime2db($request->etd_datetime) : NULL),
            'eta_datetime' => (isset($request->eta_datetime) ? \Helper::converdatetime2db($request->eta_datetime) : NULL),
            'eqp_available_datetime' => (isset($request->eqp_available_datetime) ? \Helper::converdatetime2db($request->eqp_available_datetime) : NULL),
            'booking_number' => (isset($request->booking_number) ? $request->booking_number : NULL),
            'si_cut_off_date_time' => (isset($request->si_cut_off_date_time) ? \Helper::converdatetime2db($request->si_cut_off_date_time) : NULL),
            'document_cut_off_date_time' => (isset($request->document_cut_off_date_time) ? \Helper::converdatetime2db($request->document_cut_off_date_time) : NULL),
            'stuffing' => (isset($request->stuffing) ? $request->stuffing : 0)
        ];

        if ($request->hasFile('booking_file')) {
            $booking_file_URL = \Helper::fileUpload($request->file('booking_file'), 'booking_file', 'booking_file');
            $customer_service_dates['booking_file_url'] = $booking_file_URL;
        }

        if (\Helper::isCustomerService() || \Helper::isAdmin()) {
            $final = array_merge($common, $customer_service_dates);
        } else {
            $final = $common;
        }

        
        $last_id = \DB::table('trans_booking_details')->where('id', $id)->update($final);
        
        
        
        if ((int)$new_no_of_container != (int)$pre_no_of_container) {

                \DB::table('booking_moment_details')->where('trans_booking_details_id',$id)->delete();
                for($a=0; $a<$new_no_of_container; $a++) {
                    
                    \DB::table('booking_moment_details')->insertGetId([
                        'trans_booking_details_id'=>$id
                    ]);
                }

            if (\Helper::isAdmin()) {
                //\Helper::addVesselHistorybyBookingID($id, $ms_shippingline);
                \DB::table('unlock_line_seal_numbers')->where('trans_booking_details_id', $id)->delete();
            }
        }
        

        if (\Helper::isCustomerService() || \Helper::isAdmin()) {
            return response()->json(['status' => true, 'msg' => 'Booking Detail updated successfully', 'data' => 'moment_detail']);
        } else {
            return response()->json(['status' => true, 'msg' => 'Booking Detail updated successfully', 'data' => 'landing_page']);
        }

    }

    public function delete($id)
    {
        $ms_consignee = \DB::table('trans_booking_details')->where('id', $id)->where('status', '!=', 0)->first();
        if ($ms_consignee == null) {
            session()->flash('error', 'Invalid Request.');
            return redirect(route('master.booking.index', ['id' => $id]));
        }

        \DB::table('trans_booking_details')->where('id', $id)->update(['status' => 0]);
        \DB::table('booking_moment_details')->where('trans_booking_details_id', $id)->update(['status' => 0]);
        session()->flash('success', 'Booking Detail Deleted successfully.');
        return redirect(route('master.booking.index'));
    }

    public function moment_detail_update($id, Request $request)
    {
        $ms_shippingline = \DB::table('trans_booking_details')->where('id', $id)->where('status', '!=', 0)->first();
        if ($ms_shippingline == null) {
            return response()->json(['status' => false, 'msg' => ['ivalid' => ['Invalid Request']]]);
        }

        $no_of_container = isset($ms_shippingline->no_of_container) ? $ms_shippingline->no_of_container : 0;
        $stuffing = isset($ms_shippingline->stuffing) ? $ms_shippingline->stuffing : 0;
        $container_number = isset($request->container_number) ? $request->container_number : [];
        $custom_seal_no = isset($request->custom_seal_no) ? $request->custom_seal_no : [];
        $a_seal_no = isset($request->a_seal_no) ? $request->a_seal_no : [];
        $vehicle_no = isset($request->vehicle_no) ? $request->vehicle_no : [];
        $container_number_count = is_array($container_number) ? sizeof($container_number) : 0;
        $def_id = isset($request->def_id) ? $request->def_id : [];
        $factory_in = isset($request->factory_in) ? $request->factory_in : [];
        $factory_out = isset($request->factory_out) ? $request->factory_out : [];
        $cfs_date = isset($request->cfs_date) ? $request->cfs_date : [];
        if ($container_number_count != $no_of_container) {
            return response()->json(['status' => false, 'msg' => ['ivalid' => ['Please fill all fields']]]);
        }

        if (sizeof($custom_seal_no) == 0) {
            return response()->json(['status' => false, 'msg' => ['ivalid' => ['Please fill all fields']]]);
        }
        if (sizeof($a_seal_no) == 0) {
            return response()->json(['status' => false, 'msg' => ['ivalid' => ['Please fill all fields']]]);
        }
        if ($stuffing == 1) {
            if (sizeof($vehicle_no) == 0) {
                return response()->json(['status' => false, 'msg' => ['ivalid' => ['Please fill all fields']]]);
            }
        }


        $is_null = 0;
        if (sizeof($container_number) > 0) {
            foreach ($container_number as $key => $val) {

                if ($request->container_number[$key] == null) {
                    $is_null = 1;
                }
                // if ($request->custom_seal_no[$key] == null) {
                //     $is_null = 1;
                // }
                // if ($request->a_seal_no[$key] == null) {
                //     $is_null = 1;
                // }
                if ($stuffing == 1) {
                    if ($request->vehicle_no[$key] == null) {
                        $is_null = 1;
                    }
                }

            }

            if ($is_null == 1) {
                return response()->json(['status' => false, 'msg' => ['ivalid' => ['Please fill all fields']]]);
            }
        } else {
            return response()->json(['status' => false, 'msg' => ['ivalid' => ['Please fill all number of contianer']]]);
        }



        //\DB::table('booking_moment_details')->where('trans_booking_details_id',$id)->delete();
        foreach ($container_number as $key => $val) {
            $def_type_id = isset($def_id[$key]) ? $def_id[$key] : 0;
            $cond = [
                'trans_booking_details_id' => $id,
                'user_id' => \Auth::id(),
                'container_number' => $request->container_number[$key],
                'custom_seal_no' => $request->custom_seal_no[$key],
                'a_seal_no' => $request->a_seal_no[$key],
            ];

            if ($stuffing == 1) {
                $cond['factory_in'] = isset($factory_in[$key]) ? $factory_in[$key] : NULL;
                $cond['factory_out'] = isset($factory_out[$key]) ? $factory_out[$key] : NULL;
            }

            if ($stuffing == 2) {
                $cond['cfs_date'] = isset($cfs_date[$key]) ? $cfs_date[$key] : NULL;
            }


            if (isset($request->vehicle_no[$key])) {
                $cond['vehicle_no'] = $request->vehicle_no[$key];
            }
            if ($def_type_id > 0) {
                \DB::table('booking_moment_details')->where('id', $def_type_id)->update($cond);
            } else {
                \DB::table('booking_moment_details')->insert($cond);
            }

        }

        return response()->json(['status' => true, 'msg' => 'Moment Details updated successfully']);
    }

    public function addvesselhistory($id, Request $request)
    {
        $ms_booking_detail = \DB::table('trans_booking_details')->where('id', $id)->where('status', '!=', 0)->first();
        if ($ms_booking_detail == null) {
            return response()->json(['status' => false, 'msg' => ['ivalid' => ['Invalid Request']]]);
        }

        \Helper::addVesselHistorybyBookingID($id, $ms_booking_detail);
        return response()->json(['status' => true, 'msg' => 'Booking History updated successfully']);
    }

    public function unlockseal(Request $request)
    {
        $id = isset($request->sealID) ? $request->sealID : 0;
        $check = \DB::table('booking_moment_details')->where('id', $id)->where('status', '!=', 0)->first();
        if ($check == null) {
            return response()->json(['status' => false, 'msg' => 'Invalid ID provided']);
        }

        \DB::table('unlock_line_seal_numbers')->insert([
            'trans_booking_details_id' => $check->trans_booking_details_id,
            'booking_moment_details_id' => $check->id,
            'line_seal_number' => $check->a_seal_no ?? 0,
            'container_number' => $check->container_number ?? 0,
            'custom_seal_number' => $check->custom_seal_no ?? 0,
            'vehicle_number' => $check->vehicle_no ?? 0,
            'user_id' => \Auth::id(),
        ]);

        $check = \DB::table('booking_moment_details')->where('id', $id)->update(['a_seal_no' => '']);
        return response()->json(['status' => true, 'msg' => 'Moment Seal Break successfully']);
    }

    public function transhipment_save($id, Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                //'job_number' => 'required|unique:trans_booking_details',
                'transhipment_port' => 'required',
                'transhipment_eta' => 'required',
                'transhipment_etd' => 'required',
            ]
        );

        if ($validator->fails()) {
            //return redirect()->back()->withErrors($validator)->withInput();
            return response()->json(['status' => false, 'msg' => $validator->messages()]);

        }
        \DB::table('booking_transhipment_details')->insert([
            'trans_booking_details_id' => $id,
            'transhipment_port' => $request->transhipment_port,
            'transhipment_eta' => \Helper::converdatetime2db($request->transhipment_eta),
            'transhipment_etd' => \Helper::converdatetime2db($request->transhipment_etd),
            'transhipment_remark' => isset($request->transhipment_remark) ? $request->transhipment_remark : NULL,
            'user_id' => \Auth::id()
        ]);
        return response()->json(['status' => true, 'msg' => 'Transhipment Details Saved Successfully']);
    }

    public function get_transportment_details($id, Request $request)
    {
        $idx = isset($request->idx) ? $request->idx : 0;
        $booking_transhipment_details = \DB::table('booking_transhipment_details')->where('trans_booking_details_id', $id)->where('id', $idx)->where('status', '!=', 0)->first();
        if ($booking_transhipment_details == null) {
            return response()->json(['status' => false, 'msg' => 'Invalid Transhipment Details Request']);
        }
        return response()->json(['status' => true, 'msg' => '', 'data' => $booking_transhipment_details]);
    }

    public function update_transportment($id, Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'transhipment_id' => 'required|numeric',
                'transhipment_port' => 'required',
                'transhipment_eta' => 'required',
                'transhipment_etd' => 'required',
            ]
        );

        if ($validator->fails()) {
            //return redirect()->back()->withErrors($validator)->withInput();
            return response()->json(['status' => false, 'msg' => $validator->messages()]);
        }

        $booking_transhipment_details = \DB::table('booking_transhipment_details')->where('id', $request->transhipment_id)->where('trans_booking_details_id', $id)->where('status', '!=', 0)->first();
        if ($booking_transhipment_details == null) {
            return response()->json(['status' => false, 'msg' => 'Booking Transhipment Details is not valid']);
        }

        \DB::table('booking_transhipment_details')->where('id', $request->transhipment_id)->where('trans_booking_details_id', $id)->update([
            'transhipment_port' => $request->transhipment_port,
            'transhipment_eta' => $request->transhipment_eta,
            'transhipment_etd' => $request->transhipment_etd,
            'transhipment_remark' => isset($request->transhipment_remark) ? $request->transhipment_remark : NULL,
            'user_id' => \Auth::id()
        ]);
        return response()->json(['status' => true, 'msg' => 'Transhipment Details Updated Successfully']);

    }

    public function delete_transhpment($id, Request $request)
    {
        $transhipment_detail_id = isset($request->transhipment_detail_id) ? $request->transhipment_detail_id : 0;
        $booking_transhipment_details = \DB::table('booking_transhipment_details')->where('id', $transhipment_detail_id)->where('trans_booking_details_id', $id)->where('status', '!=', 0)->first();
        if ($booking_transhipment_details == null) {
            return response()->json(['status' => false, 'msg' => 'Booking Transhipment Details is not valid']);
        }
        \DB::table('booking_transhipment_details')->where('id', $transhipment_detail_id)->where('trans_booking_details_id', $id)->update(['status' => 0]);
        return response()->json(['status' => true, 'msg' => 'Transhipment Detail Deleted successfully']);

    }

    public function documentedit($id)
    {

        $booking_details = \DB::table('trans_booking_details')->where('id', $id)->where('status', '!=', 0)->first();
        if ($booking_details == null) {
            session()->flash('error', 'Invalid Request.');
            return redirect(route('master.booking.index'));
        }
        $exporter = \Helper::get_exporter();
        $getConsigneeList = \Helper::getConsigneeList();
        $ms_get_notify_user = \Helper::ms_get_notify_user();
        $data['ms_get_notify_user'] = $ms_get_notify_user;

        $ms_get_delivery_agent = \Helper::ms_get_delivery_agent();
        $data['ms_get_delivery_agent'] = $ms_get_delivery_agent;

        $ms_port_of_loading = \Helper::ms_port_of_loading();
        $data['ms_port_of_loading'] = $ms_port_of_loading;

        $ms_port_of_destination = \Helper::ms_port_of_destination();
        $data['ms_port_of_destination'] = $ms_port_of_destination;

        $data['exporter'] = $exporter;
        $data['consignee_list'] = $getConsigneeList;
        $data['booking_detail'] = $booking_details;
        $data['id'] = $booking_details->id ?? 0;

        $booking_moment_details = \Helper::getBookingMomentDetails($booking_details->id ?? 0);
        $data['booking_detail_moment_detail'] = $booking_moment_details;

        return view('bookingdetails.documentedit', $data);
    }


    public function documentfilesedit($id)
    {

        $booking_details = \DB::table('trans_booking_details')->where('id', $id)->where('status', '!=', 0)->first();
        if ($booking_details == null) {
            session()->flash('error', 'Invalid Request.');
            return redirect(route('master.booking.index'));
        }
        $exporter = \Helper::get_exporter();
        $getConsigneeList = \Helper::getConsigneeList();
        $ms_get_notify_user = \Helper::ms_get_notify_user();
        $data['ms_get_notify_user'] = $ms_get_notify_user;

        $ms_get_delivery_agent = \Helper::ms_get_delivery_agent();
        $data['ms_get_delivery_agent'] = $ms_get_delivery_agent;

        $ms_port_of_loading = \Helper::ms_port_of_loading();
        $data['ms_port_of_loading'] = $ms_port_of_loading;

        $ms_port_of_destination = \Helper::ms_port_of_destination();
        $data['ms_port_of_destination'] = $ms_port_of_destination;

        $data['exporter'] = $exporter;
        $data['consignee_list'] = $getConsigneeList;
        $data['booking_detail'] = $booking_details;
        $data['id'] = $booking_details->id ?? 0;

        $booking_moment_details = \Helper::getBookingMomentDetails($booking_details->id ?? 0);
        $data['booking_detail_moment_detail'] = $booking_moment_details;

        $data['booking_other_files']=\Helper::getBookingOtherFiles($id);

        return view('bookingdetails.documentfilesedit', $data);
    }
    

    public function documentupdate($id, Request $request) {
        $ms_shippingline = \DB::table('trans_booking_details')->where('id', $id)->where('status', '!=', 0)->first();
        if ($ms_shippingline == null) {
            return response()->json(['status' => false, 'msg' => ['ivalid' => ['Invalid Request']]]);
        }

        $validator = Validator::make(
            $request->all(),
            [
                'ms_exporter_id' => 'required|numeric',
                'ms_consignee_id' => 'required|numeric',
                'notify_user1' => 'required|numeric',
                'notify_user2' => 'nullable|numeric',
                'notify_user3' => 'nullable|numeric',
                'delivery_agent_id'=>'required|numeric',
                'document_remark'=>'nullable',
                'bl_number'=>'nullable'
            ]
        );

        if ($validator->fails()) {
            return response()->json(['status' => false, 'msg' => $validator->messages()]);
        }

        
        $final=[
            'ms_exporter_id'=>$request->ms_exporter_id,
            'ms_consignee_id'=>$request->ms_consignee_id,
            'same_as_consignee'=>isset($request->same_as_consignee) ? $request->same_as_consignee : 0,
            'notify_user1'=>$request->notify_user1,
            'notify_user2'=>isset($request->notify_user2) ? $request->notify_user2 : 0,
            'notify_user3'=>isset($request->notify_user3) ? $request->notify_user3 : 0,
            'delivery_agent_id'=>$request->delivery_agent_id,
            'document_remark'=>isset($request->document_remark) ? $request->document_remark : '',
            'bl_number'=>$request->bl_number,
        ];

        // if ($request->hasFile('shipping_bill')) {
        //     $shipping_bill_url = \Helper::fileUpload($request->file('shipping_bill'), 'shipping_bill', 'shipping_bill');
        //     $final['shipping_bill_url'] = $shipping_bill_url;
        // }

        // if ($request->hasFile('gate_pass')) {
        //     $gate_pass_url = \Helper::fileUpload($request->file('gate_pass'), 'gate_pass', 'gate_pass');
        //     $final['gate_pass_url'] = $gate_pass_url;
        // }

        // if ($request->hasFile('invoice_copy')) {
        //     $invoice_copy_url = \Helper::fileUpload($request->file('invoice_copy'), 'invoice_copy', 'invoice_copy');
        //     $final['invoice_copy_url'] = $invoice_copy_url;
        // }

        // if ($request->hasFile('packing_list')) {
        //     $packing_list_url = \Helper::fileUpload($request->file('packing_list'), 'packing_list', 'packing_list');
        //     $final['packing_list_url'] = $packing_list_url;
        // }

        // if ($request->hasFile('vgm_copy')) {
        //     $vgm_copy_url = \Helper::fileUpload($request->file('vgm_copy'), 'vgm_copy', 'vgm_copy');
        //     $final['vgm_copy_url'] = $vgm_copy_url;
        // }

        // if ($request->hasFile('booking_copy')) {
        //     $booking_copy_url = \Helper::fileUpload($request->file('booking_copy'), 'booking_copy', 'booking_copy');
        //     $final['booking_copy_url'] = $booking_copy_url;
        // }

        // if ($request->hasFile('other_file')) {
        //     $other_file_url = \Helper::fileUpload($request->file('other_file'), 'other_file', 'other_file');
        //     $final['other_file_url'] = $other_file_url;
        // }

        $last_id = \DB::table('trans_booking_details')->where('id', $id)->update($final);

        if (\Helper::isDocument() || \Helper::isAdmin()) {
            return response()->json(['status' => true, 'msg' => 'Booking Detail updated successfully', 'data' => 'moment_detail']);
        } else {
            return response()->json(['status' => true, 'msg' => 'You are not authorised for this', 'data' => 'landing_page']);
        }
    }
    

    public function documentfileupdate($id, Request $request) {
        $ms_shippingline = \DB::table('trans_booking_details')->where('id', $id)->where('status', '!=', 0)->first();
        if ($ms_shippingline == null) {
            return response()->json(['status' => false, 'msg' => ['ivalid' => ['Invalid Request']]]);
        }

        $posts = $request->all();

        if(isset($posts) && is_array($posts) && sizeof($posts) > 0) {
            foreach($posts as $key=>$filepost) {
                    switch(strtolower($key)) {
                        case "shipping_bill":
                        case "gate_pass":
                        case "invoice_copy":
                        case "packing_list":
                        case "vgm_copy":
                        case "booking_copy":
                        case "other_file":
                            if(isset($filepost) && is_array($filepost) && sizeof($filepost)) {
                                foreach($filepost as $mainpost) {
                                    $main_file_url = \Helper::fileUpload($mainpost, strtolower($key), strtolower($key));
                                    \DB::table('booking_other_files')->insert([
                                        'trans_booking_details_id'=>$id,
                                        'other_file_types'=>strtolower($key),
                                        'other_file_url'=>$main_file_url,
                                        'user_id'=>\Auth::id(),
                                    ]);
                                }
                            }
                        break;
                    }

            }
        }

        // $validator = Validator::make(
        //     $request->all(),
        //     [
        //         'ms_exporter_id' => 'required|numeric',
        //         'ms_consignee_id' => 'required|numeric',
        //         'notify_user1' => 'required|numeric',
        //         'notify_user2' => 'nullable|numeric',
        //         'notify_user3' => 'nullable|numeric',
        //         'delivery_agent_id'=>'required|numeric',
        //         'document_remark'=>'nullable',
        //         'bl_number'=>'required'
        //     ]
        // );

        // if ($validator->fails()) {
        //     return response()->json(['status' => false, 'msg' => $validator->messages()]);
        // }

        
        // $final=[];

        // if ($request->hasFile('shipping_bill')) {
            
        //     $shipping_bill_url = \Helper::fileUpload($request->file('shipping_bill'), 'shipping_bill', 'shipping_bill');
        //     $final['shipping_bill_url'] = $shipping_bill_url;
        // }

        // if ($request->hasFile('gate_pass')) {
        //     $gate_pass_url = \Helper::fileUpload($request->file('gate_pass'), 'gate_pass', 'gate_pass');
        //     $final['gate_pass_url'] = $gate_pass_url;
        // }

        // if ($request->hasFile('invoice_copy')) {
        //     $invoice_copy_url = \Helper::fileUpload($request->file('invoice_copy'), 'invoice_copy', 'invoice_copy');
        //     $final['invoice_copy_url'] = $invoice_copy_url;
        // }

        // if ($request->hasFile('packing_list')) {
        //     $packing_list_url = \Helper::fileUpload($request->file('packing_list'), 'packing_list', 'packing_list');
        //     $final['packing_list_url'] = $packing_list_url;
        // }

        // if ($request->hasFile('vgm_copy')) {
        //     $vgm_copy_url = \Helper::fileUpload($request->file('vgm_copy'), 'vgm_copy', 'vgm_copy');
        //     $final['vgm_copy_url'] = $vgm_copy_url;
        // }

        // if ($request->hasFile('booking_copy')) {
        //     $booking_copy_url = \Helper::fileUpload($request->file('booking_copy'), 'booking_copy', 'booking_copy');
        //     $final['booking_copy_url'] = $booking_copy_url;
        // }

        // if ($request->hasFile('other_file')) {
        //     $other_file_url = \Helper::fileUpload($request->file('other_file'), 'other_file', 'other_file');
        //     $final['other_file_url'] = $other_file_url;
        // }

        // $last_id = \DB::table('trans_booking_details')->where('id', $id)->update($final);

        if (\Helper::isDocument() || \Helper::isAdmin()) {
            return response()->json(['status' => true, 'msg' => 'Booking Detail updated successfully', 'data' => 'moment_detail']);
        } else {
            return response()->json(['status' => true, 'msg' => 'You are not authorised for this', 'data' => 'landing_page']);
        }
    }
    

    public function documentmoemntupdate($id, Request $request) {
        $ms_shippingline = \DB::table('trans_booking_details')->where('id', $id)->where('status', '!=', 0)->first();
        if ($ms_shippingline == null) {
            return response()->json(['status' => false, 'msg' => ['ivalid' => ['Invalid Request']]]);
        }
        $def_id = isset($request->def_id) ? $request->def_id : [];
        $document_gross_weight = isset($request->document_gross_weight) ? $request->document_gross_weight : [];
        foreach ($document_gross_weight as $key => $val) {
            $def_type_id = isset($def_id[$key]) ? $def_id[$key] : 0;
            $cond = [
                'document_update_user_id' => \Auth::id(),
                'document_gross_weight' => isset($request->document_gross_weight[$key]) ? $request->document_gross_weight[$key] : NULL,
                'document_kind_of_package' => isset($request->show_kind_of_packages[$key]) ? $request->show_kind_of_packages[$key] : NULL,
                'document_no_of_package' => isset($request->show_no_of_packages[$key]) ? $request->show_no_of_packages[$key] : NULL,
                'document_vgm_weight' => isset($request->document_vgm_weight[$key]) ? $request->document_vgm_weight[$key] : NULL,
                'document_net_weight' => isset($request->document_net_weight[$key]) ? $request->document_net_weight[$key] : NULL,
            ];
            if ($def_type_id > 0) {
                \DB::table('booking_moment_details')->where('id', $def_type_id)->update($cond);
            }
        }
        return response()->json(['status' => true, 'msg' => 'Details updated successfully']);        
    }

    public function getshipperinfo($id, Request $request) {
        $shipperIdx = isset($request->shipperIdx) ? $request->shipperIdx : 0;
        $html = \Helper::getShipperDetailBL($shipperIdx);
        return response()->json(['status' => true, 'msg' => '','data'=>$html]);
    }

    public function consignee_data($id, Request $request) {
        $consigneeIdx = isset($request->consigneeIdx) ? $request->consigneeIdx : 0;
        $html = \Helper::getConsigneeDetailBL($consigneeIdx);
        return response()->json(['status' => true, 'msg' => '','data'=>$html]);    
    }

    public function documentvesseldetail($id, Request $request) {
        $ms_shippingline = \DB::table('trans_booking_details')->where('id', $id)->where('status', '!=', 0)->first();
        if ($ms_shippingline == null) {
            return response()->json(['status' => false, 'msg' => ['ivalid' => ['Invalid Request']]]);
        }
        
        
        $express_bl = isset($request->express_bl) ?$request->express_bl : 0;
        $required_obl = isset($request->required_obl) ?$request->required_obl : 0;
        if($express_bl == 0 && $required_obl ==0) {
            return response()->json(['status' => false, 'msg' => ['ivalid' => ['Please select atleast one BL']]]);
        }

        
        $validator = Validator::make(
            $request->all(),
            [
                'ms_port_of_loading_id' => 'required|numeric',
                'ms_port_of_destination' => 'required|numeric',
                'freight_payble_at' => 'required|numeric',
                'final_place_of_delivery' => 'required',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['status' => false, 'msg' => $validator->messages()]);
        }

        
        $final=[
            'ms_port_of_loading_id'=>$request->ms_port_of_loading_id,
            'ms_port_of_destination'=>$request->ms_port_of_destination,
            'freight_payble_at'=>$request->freight_payble_at,
            'final_place_of_delivery'=>$request->final_place_of_delivery,
            'required_obl'=>isset($request->required_obl) ? $request->required_obl : 0,
            'express_bl'=>isset($request->express_bl) ? $request->express_bl : 0,
            'no_of_original_bills_of_loading'=>isset($request->no_of_original_bills_of_loading) ? $request->no_of_original_bills_of_loading : 0,
            'no_of_negotiable_copy'=>isset($request->no_of_negotiable_copy) ? $request->no_of_negotiable_copy : 0,
            'no_of_express_obj'=>isset($request->no_of_express_obj) ? $request->no_of_express_obj : 0,
            'no_of_express_negotiable_copy'=>isset($request->no_of_express_negotiable_copy) ? $request->no_of_express_negotiable_copy : 0,
        ];
        
        $last_id = \DB::table('trans_booking_details')->where('id', $id)->update($final);
        return response()->json(['status' => true, 'msg' => 'Booking Detail updated successfully', 'data' => 'cargo_detail']);
        
    }

    public function cargo_details($id, Request $request) {
        
        $ms_shippingline = \DB::table('trans_booking_details')->where('id', $id)->where('status', '!=', 0)->first();
        if ($ms_shippingline == null) {
            return response()->json(['status' => false, 'msg' => ['ivalid' => ['Invalid Request']]]);
        }
        
        $validator = Validator::make(
            $request->all(),
            [
                'document_hsc_code' => 'required',
                'document_marks'=>'nullable',
                'document_description'=>'required',
                'document_gross_weight'=>'nullable',
                'document_measurement'=>'nullable',
                
            ]
        );

        if ($validator->fails()) {
            return response()->json(['status' => false, 'msg' => $validator->messages()]);
        }

        
        $final=[
            'document_hsc_code'=>$request->document_hsc_code,
            'document_marks'=>$request->document_marks,
            'document_description'=>$request->document_description,
            'document_gross_weight'=>$request->document_gross_weight,
            'document_measurement'=>$request->document_measurement,
        ];
        
        // $def_id = isset($request->def_id) ? $request->def_id : [];
        // $document_marks = isset($request->document_marks) ? $request->document_marks : [];
        // $document_description = isset($request->document_description) ? $request->document_description : [];
        // foreach ($document_marks as $key => $val) {
        //     $def_type_id = isset($def_id[$key]) ? $def_id[$key] : 0;
        //     $cond = [
        //         'document_update_user_id' => \Auth::id(),
        //         'document_marks' => isset($request->document_marks[$key]) ? $request->document_marks[$key] : NULL,
        //         'document_description' => isset($request->document_description[$key]) ? $request->document_description[$key] : NULL,
        //         'document_no_of_package'=>isset($request->document_no_of_package[$key]) ? $request->document_no_of_package[$key] : NULL,
        //         'document_kind_of_package'=>isset($request->document_kind_of_package[$key]) ? $request->document_kind_of_package[$key] : NULL,
        //         'document_measurement'=>isset($request->document_measurement[$key]) ? $request->document_measurement[$key] : NULL,
        //     ];
        //     if ($def_type_id > 0) {
        //         \DB::table('booking_moment_details')->where('id', $def_type_id)->update($cond);
        //     }
        // }
        
        $last_id = \DB::table('trans_booking_details')->where('id', $id)->update($final);
        return response()->json(['status' => true, 'msg' => 'Booking Detail updated successfully', 'data' => 'container_detail']);
    }

    public function documentinvoice($id, Request $request) {
        $trans_booking_details = \DB::table('trans_booking_details')->where('id',$id)->where('status','!=',0)->first();
        $data['bookingdata'] = $trans_booking_details;

        $booking_moment_details = \Helper::getBookingMomentDetails($trans_booking_details->id ?? 0);
        $data['booking_detail_moment_detail'] = $booking_moment_details;
        
        $pdf = \App::make('dompdf.wrapper');
        $html = view('bookingdetails.invoice_pdf',$data)->render();
        // echo $html;die;
        $pdf->loadHTML($html)->setPaper('a4');

        //$pdf = PDF::loadView('bookingdetails.invoice_pdf',$data)->setPaper('a4');
        $rand = rand(10,500);
        return $pdf->download('ine-bl'.$rand.'.pdf');
    }

    public function deleteotherdocumenfile($id, Request $request) {
        $mainid = isset($request->mainid) ? $request->mainid : 0;
        $booking_other_files = \DB::table('booking_other_files')->where('id',$mainid)->where('status','!=',0)->first();
        if($booking_other_files==null) {
            return response()->json(['status' => false, 'msg' => 'Invalid File', 'data' => '']);
        }
        \DB::table('booking_other_files')->where('id',$mainid)->update(['status'=>0]);
        return response()->json(['status' => true, 'msg' => 'File Removed successfully', 'data' => '']);
    }
}