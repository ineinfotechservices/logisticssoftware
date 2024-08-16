<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ExporterController extends Controller
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
        if(!\Helper::isAdmin() && !\Helper::isCustomerService()) return \Helper::invalidUserRedirect();
        $shippingline = \DB::table('ms_exporter')->where('status', 1)->get();
        $data['states'] = $shippingline;
        $countries = \Helper::getCountries();
        $data['countries'] = $countries;
        return view('exporter.index', $data);
    }

    public function add()
    {
        if(!\Helper::isAdmin()) return \Helper::invalidUserRedirect();
        $indiaCountry = \Helper::getIndiaCountry();
        $indiaID = isset($indiaCountry->id) ? $indiaCountry->id : 0;
        $states = \Helper::getStates($indiaID);
        $data['states'] = $states;
        $cities = \Helper::getCities(1);
        $data['cities'] = $cities;
        $countries = \Helper::getCountries();
        $data['countries'] = $countries;
        session()->put('filesobj', []);
        return view('exporter.add', $data);
    }

    public function save(Request $request)
    {
        if(!\Helper::isAdmin()) return \Helper::invalidUserRedirect();
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|unique:ms_exporter',
                'email' => 'required|email',
                'phone' => 'nullable|numeric',
                'address' => 'nullable',
                'country' => 'nullable|numeric',
                'state_id' => 'nullable|numeric',
                'city_id' => 'nullable|numeric',
                'pincode' => 'nullable|numeric',
                'gst_number' => 'required',
                //'gst_file' => 'required|file',
                'gst_address' => 'nullable',
                'iec_number' => 'nullable|numeric',
                'pan_number' => 'nullable',
            ]
        );

        if ($validator->fails()) {
            //return redirect()->back()->withErrors($validator)->withInput();
            return response()->json(['status' => false, 'msg' => $validator->messages()]);
        }
        $get_session = session()->get('filesobj');
        $tmp_get_session = $get_session;
        $checkNumber = 2;
        if(isset($tmp_get_session['gst_file'])) {
            unset($tmp_get_session['gst_file']);
            $checkNumber = 1;
        }
        if (is_array($tmp_get_session) && sizeof($tmp_get_session) < (int)$checkNumber) {
            return response()->json(['status' => false, 'msg' => [['Minimum 1 document File need to upload, with GST']]]);
        }

        $state_id = $request->state_id;
        $check_state = \Helper::getStates($state_id);
        if ($check_state == null) {
            return response()->json(['status' => false, 'msg' => ['ivalid' => ['Invalid Request']]]);
        }

        $check_ = \DB::table('ms_exporter')->where('email', $request->email)->where('status', 1)->first();
        if ($check_ != null) {
            return response()->json(['status' => false, 'msg' => ['alreay' => ['Exporter Email already been used']]]);
        }

        $electricityfileurl = $electricity_bill_file_url = $telephone_file_url = $gst_file_url = $pan_file_url = $aadhar_file_url = $iec_file_url = '';
        if (isset($get_session['aadhar_file'])) {
            $aadhar_file_url = $get_session['aadhar_file'];
        }
        if (isset($get_session['iec_file'])) {
            $iec_file_url = $get_session['iec_file'];
        }
        if (isset($get_session['telephone_file'])) {
            $telephone_file_url = $get_session['telephone_file'];
        }
        if (isset($get_session['pan_file'])) {
            $pan_file_url = $get_session['pan_file'];
        }
        if (isset($get_session['electricity_bill_file'])) {
            $electricity_bill_file_url = $get_session['electricity_bill_file'];
        }
        if (isset($get_session['gst_file'])) {
            $gst_file_url = $get_session['gst_file'];
        }

        // if($request->hasFile('electricity_bill_file')) {
        //     $electricity_bill_file_url = \Helper::fileUpload($request->file('electricity_bill_file'),'electricity_bill_file','exporters');
        // }

        // if($request->hasFile('telephone_file')) {
        //     $telephone_file_url = \Helper::fileUpload($request->file('telephone_file'),'telephone_file');
        // }

        // if($request->hasFile('gst_file')) {
        //     $gst_file_url = \Helper::fileUpload($request->file('gst_file'),'gst_file');
        // }

        // if($request->hasFile('pan_file')) {
        //     $pan_file_url = \Helper::fileUpload($request->file('pan_file'),'pan_file');
        // }

        // if($request->hasFile('aadhar_file')) {
        //     $aadhar_file_url = \Helper::fileUpload($request->file('aadhar_file'),'aadhar_file');
        // }

        // if($request->hasFile('iec_file')) {
        //     $iec_file_url = \Helper::fileUpload($request->file('iec_file'),'iec_file');
        // }


        $last_id = \DB::table('ms_exporter')->insertGetId([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'address2' => isset($request->address2) ? $request->address2 : '',
            'address3' => isset($request->address3) ? $request->address3 : '',
            'country' => $request->country,
            'city_id' => $request->city_id,
            'pincode' => $request->pincode,
            'gst_number' => $request->gst_number,
            'gst_address' => $request->gst_address,
            'iec_number' => $request->iec_number,
            'pan_number' => $request->pan_number,
            //'aadhar_number' => $request->aadhar_number,
            //'electricity_bill_number' => isset($request->electricity_bill_number) ? $request->electricity_bill_number : '',
            'telephone_number' => isset($request->telephone_number) ? $request->telephone_number : '',
            'state_id' => $state_id,
            'gst_file' => $gst_file_url,
            'iec_file' => $iec_file_url,
            'pan_file' => $pan_file_url,
            'aadhar_file' => $aadhar_file_url,
            'electricity_bill_file' => $electricity_bill_file_url,
            'telephone_file' => $telephone_file_url,
            'user_id' => auth()->user()->id,
        ]);

        return response()->json(['status' => true, 'msg' => 'Exporter created successfully']);
        // session()->flash('success', 'Exporter Created successfully.');
        // return redirect(route('master.exporter.index'));
    }

    public function edit($id)
    {
        if(!\Helper::isAdmin()) return \Helper::invalidUserRedirect();
        $ms_consignee = \DB::table('ms_exporter')->where('id', $id)->where('status', 1)->first();
        if ($ms_consignee == null) {
            session()->flash('error', 'Invalid Request.');
            return redirect(route('master.exporter.index', ['id' => $id]));
        }
        $data['exporter'] = $ms_consignee;

        $states = \Helper::getStates(1);
        $data['states'] = $states;
        $cities = \Helper::getCities(1);
        $data['cities'] = $cities;
        $countries = \Helper::getCountries();
        $data['countries'] = $countries;

        return view('exporter.edit', $data);
    }

    public function update($id, Request $request)
    {
        if(!\Helper::isAdmin()) return \Helper::invalidUserRedirect();
        $ms_shippingline = \DB::table('ms_exporter')->where('id', $id)->where('status', 1)->first();
        if ($ms_shippingline == null) {
            return response()->json(['status' => false, 'msg' => ['ivalid' => ['Invalid Request']]]);
        }


        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|unique:ms_exporter,name, '.$id,
                'email' => 'required|email',
                'phone' => 'nullable|numeric',
                'address' => 'nullable',
                'state_id' => 'nullable|numeric',
                'city_id' => 'nullable|numeric',
                'country' => 'nullable|numeric',
                'pincode' => 'nullable|numeric',
                'gst_number' => 'required',
                //'gst_file' => 'required|file',
                'gst_address' => 'nullable',
                'iec_number' => 'nullable|numeric',
                'iec_file' => 'nullable|file',
                'pan_number' => 'nullable',
                'pan_file' => 'nullable|file',
                'aadhar_file' => 'nullable|file',
            ]
        );

        if ($validator->fails()) {
            //return redirect()->back()->withErrors($validator)->withInput();
            return response()->json(['status' => false, 'msg' => $validator->messages()]);

        }

        $state_id = $request->state_id;
        $check_state = \Helper::getStates($state_id);
        if ($check_state == null) {
            return response()->json(['status' => false, 'msg' => ['ivalid' => ['Invalid Request']]]);
        }

        $check_ = \DB::table('ms_exporter')->where('email', $request->email)->where('id', '!=', $id)->where('status', 1)->first();
        if ($check_ != null) {
            return response()->json(['status' => false, 'msg' => ['alreay' => ['Exporter Email already been used']]]);
        }

        $electricityfileurl = $electricity_bill_file_url = $telephone_file_url = $gst_file_url = $pan_file_url = $aadhar_file_url = $iec_file_url = '';

        if ($request->hasFile('electricity_bill_file')) {
            $electricity_bill_file_url = \Helper::fileUpload($request->file('electricity_bill_file'), 'electricity_bill_file', 'exporters');
        }

        if ($request->hasFile('telephone_file')) {
            $telephone_file_url = \Helper::fileUpload($request->file('telephone_file'), 'telephone_file');
        }

        if ($request->hasFile('gst_file')) {
            $gst_file_url = \Helper::fileUpload($request->file('gst_file'), 'gst_file');
        }

        if ($request->hasFile('pan_file')) {
            $pan_file_url = \Helper::fileUpload($request->file('pan_file'), 'pan_file');
        }

        if ($request->hasFile('aadhar_file')) {
            $aadhar_file_url = \Helper::fileUpload($request->file('aadhar_file'), 'aadhar_file');
        }

        if ($request->hasFile('iec_file')) {
            $iec_file_url = \Helper::fileUpload($request->file('iec_file'), 'iec_file');
        }

        //dd($request->all());

        $last_id = \DB::table('ms_exporter')->where('id', $id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'address2' => isset($request->address2) ? $request->address2 : '',
            'address3' => isset($request->address3) ? $request->address3 : '',
            'city_id' => $request->city_id,
            'country' => $request->country,
            'pincode' => $request->pincode,
            'gst_number' => $request->gst_number,
            'gst_address' => $request->gst_address,
            'iec_number' => $request->iec_number,
            'pan_number' => $request->pan_number,
            //'aadhar_number' => $request->aadhar_number,
            //'electricity_bill_number' => isset($request->electricity_bill_number) ? $request->electricity_bill_number : '',
            'telephone_number' => isset($request->telephone_number) ? $request->telephone_number : '',
            'state_id' => $state_id,
            'gst_file' => $gst_file_url,
            'iec_file' => $iec_file_url,
            'pan_file' => $pan_file_url,
            'aadhar_file' => $aadhar_file_url,
            'electricity_bill_file' => $electricity_bill_file_url,
            'telephone_file' => $telephone_file_url,
            'user_id' => auth()->user()->id,
        ]);

        return response()->json(['status' => true, 'msg' => 'Exporter updated successfully']);
    }

    public function delete($id)
    {
        if(!\Helper::isAdmin()) return \Helper::invalidUserRedirect();
        $ms_consignee = \DB::table('ms_exporter')->where('id', $id)->where('status', 1)->first();
        if ($ms_consignee == null) {
            session()->flash('error', 'Invalid Request.');
            return redirect(route('master.exporter.index', ['id' => $id]));
        }

        \DB::table('ms_exporter')->where('id', $id)->update(['status' => 0]);
        session()->flash('success', 'Exporter Deleted successfully.');
        return redirect(route('master.exporter.index'));
    }

    public function document_save(Request $request)
    {
        if(!\Helper::isAdmin()) return \Helper::invalidUserRedirect();
        $validator = Validator::make(
            $request->all(),
            [
                'file_upload' => 'required|file',
                'filetypeselection' => 'required',
            ]
        );

        if ($validator->fails()) {
            //return redirect()->back()->withErrors($validator)->withInput();
            return response()->json(['status' => false, 'msg' => $validator->messages()]);
        }
        $electricity_bill_file_url = \Helper::fileUpload($request->file('file_upload'), $request->filetypeselection, 'exporters');

        $get_session = session()->get('filesobj');

        $filesData = [
            'filetypeselection' => $request->filetypeselection,
            'file_upload' => $electricity_bill_file_url,
        ];
        $final_array = [];
        if (is_array($get_session) && sizeof($get_session)) {
            foreach ($get_session as $get_key => $get_value) {
                $final_array[$get_key] = $get_value;
            }
        }
        $final_array[$filesData['filetypeselection']] = $filesData['file_upload'];
        session()->put('filesobj', $final_array);
        $htmlfile = \Helper::generateDocumentUploadHTMLforAdd();
        return response()->json(['status' => true, 'msg' => 'File Saved', 'data' => $htmlfile]);

    }

    public function document_delete_tmp(Request $request)
    {
        if(!\Helper::isAdmin()) return \Helper::invalidUserRedirect();
        $filetype = isset($request->filetype) ? strtolower($request->filetype) : '';
        if ($filetype == '') {
            return response()->json(['status' => false, 'msg' => [['Invalid File type']]]);
        }
        $get_session = session()->get('filesobj');
        if (is_array($get_session) && sizeof($get_session)) {
            foreach ($get_session as $tk => $tv) {
                if ($filetype == $tk) {
                    unset($get_session[$tk]);
                }
            }
        }
        session()->put('filesobj', $get_session);
        $htmlfile = \Helper::generateDocumentUploadHTMLforAdd();
        return response()->json(['status' => true, 'msg' => 'File Removed successfully', 'data' => $htmlfile]);
    }

    public function document_delete_edit(Request $request)
    {
        if(!\Helper::isAdmin()) return \Helper::invalidUserRedirect();
        $filetype = isset($request->filetype) ? strtolower($request->filetype) : '';
        if ($filetype == '') {
            return response()->json(['status' => false, 'msg' => [['Invalid File type']]]);
        }

        $fileid = isset($request->fileid) ? strtolower($request->fileid) : 0;
        if ($fileid == '') {
            return response()->json(['status' => false, 'msg' => [['Invalid Request ID']]]);
        }

        $checkdat = \DB::table('ms_exporter')->where('id', $fileid)->where('status', '!=', 0)->first();
        if ($checkdat == null) {
            return response()->json(['status' => false, 'msg' => [['Invalid Request']]]);
        }

        \DB::table('ms_exporter')->where('id', $fileid)->update([$filetype => '']);

        $checkdat = \DB::table('ms_exporter')->where('id', $fileid)->where('status', '!=', 0)->first();

        $htmlfile = \Helper::generateDocumentUploadHTMLforUpdate($checkdat);
        return response()->json(['status' => true, 'msg' => 'File Removed successfully', 'data' => $htmlfile]);
    }

    public function document_save_edit(Request $request)
    {
        if(!\Helper::isAdmin()) return \Helper::invalidUserRedirect();
        $validator = Validator::make(
            $request->all(),
            [
                'file_upload' => 'required|file',
                'filetypeselection' => 'required',
                'fileid' => 'required|numeric',
            ]
        );

        if ($validator->fails()) {
            //return redirect()->back()->withErrors($validator)->withInput();
            return response()->json(['status' => false, 'msg' => $validator->messages()]);
        }

        $fileid = $request->fileid;
        $exporter_data = \DB::table('ms_exporter')->where('id',$fileid)->where('status','!=',0)->first();
        if($exporter_data == null) {
            return response()->json(['status' => false, 'msg' => [['Invalid File ID provided']]]);
        }

        $db_key= $request->filetypeselection;

        $file_url = \Helper::fileUpload($request->file('file_upload'), $request->filetypeselection, 'exporters');

        \DB::table('ms_exporter')->where('id',$fileid)->update([$db_key=>$file_url]);
        $exporter_data = \DB::table('ms_exporter')->where('id',$fileid)->where('status','!=',0)->first();
        
        $htmlfile = \Helper::generateDocumentUploadHTMLforUpdate($exporter_data);
        
        return response()->json(['status' => true, 'msg' => 'File Saved', 'data' => $htmlfile]);
    }
}