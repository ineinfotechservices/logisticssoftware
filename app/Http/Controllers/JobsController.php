<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class JobsController extends Controller
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
        if(!\Helper::isAdmin()) return \Helper::invalidUserRedirect();
        $shippingline = \DB::table('ms_exporter')->where('status',1)->get();
        $data['states'] = $shippingline;
        $countries = \Helper::getCountries();
        $data['countries'] = $countries;
        return view('jobs.index',$data);
    }

    public function add() {
        if(!\Helper::isAdmin()) return \Helper::invalidUserRedirect();
        $states = \Helper::getStates(1);
        $data['states'] = $states;
        $cities = \Helper::getCities(1);
        $data['cities'] = $cities;
        
        return view('jobs.add',$data);
    }

    public function save(Request $request) {
        
        if(!\Helper::isAdmin()) return \Helper::invalidUserRedirect();
        
        $validator = Validator::make($request->all(),
            [
                'name' => 'required',
                'email' => 'required|email',
                'phone' => 'required|numeric',
                'address' => 'required',
                'state_id' => 'required|numeric',
                'city_id' => 'required|numeric',
                'pincode' => 'required|numeric',
                'gst_number' => 'required',
                'gst_file' => 'required|file',
                'gst_address' => 'required',
                'iec_number' => 'required|numeric',
                'iec_file' => 'required|file',
                'pan_number' => 'required',
                'pan_file' => 'required|file',
                'aadhar_number' => 'required',
                'aadhar_file' => 'required|file',
                'electricity_bill_number'=>'required_without:telephone_number|numeric',
                'electricity_bill_file'=>'required_without:telephone_file|file',
                'telephone_number'=>'required_without:electricity_bill_number|numeric',
                'telephone_file'=>'required_without:electricity_bill_file|file'
            ]
        );

        if ($validator->fails()) {
            //return redirect()->back()->withErrors($validator)->withInput();
            return response()->json(['status'=>false,'msg'=> $validator->messages()]);

        }

        $state_id = $request->state_id;
        $check_state = \Helper::getStates($state_id);
        if($check_state == null) {
            return response()->json(['status'=>false,'msg'=> ['ivalid'=>['Invalid Request']]]);
        }

        $check_ = \DB::table('ms_exporter')->where('email',$request->email)->where('status',1)->first();
        if($check_ != null) {
            return response()->json(['status'=>false,'msg'=> ['alreay'=>['Exporter Email already been used']]]);
        }
        
        $electricityfileurl = $electricity_bill_file_url = $telephone_file_url = $gst_file_url = $pan_file_url = $aadhar_file_url = $iec_file_url = '';

        if($request->hasFile('electricity_bill_file')) {
            $electricity_bill_file_url = \Helper::fileUpload($request->file('electricity_bill_file'),'electricity_bill_file','exporters');
        }

        if($request->hasFile('telephone_file')) {
            $telephone_file_url = \Helper::fileUpload($request->file('telephone_file'),'telephone_file');
        }

        if($request->hasFile('gst_file')) {
            $gst_file_url = \Helper::fileUpload($request->file('gst_file'),'gst_file');
        }

        if($request->hasFile('pan_file')) {
            $pan_file_url = \Helper::fileUpload($request->file('pan_file'),'pan_file');
        }

        if($request->hasFile('aadhar_file')) {
            $aadhar_file_url = \Helper::fileUpload($request->file('aadhar_file'),'aadhar_file');
        }

        if($request->hasFile('iec_file')) {
            $iec_file_url = \Helper::fileUpload($request->file('iec_file'),'iec_file');
        }
        

        $last_id = \DB::table('ms_exporter')->insertGetId([
            'name'=>$request->name,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'address'=>$request->address,
            'city_id'=>$request->city_id,
            'pincode'=>$request->pincode,
            'gst_number'=>$request->gst_number,
            'gst_address'=>$request->gst_address,
            'iec_number'=>$request->iec_number,
            'pan_number'=>$request->pan_number,
            'aadhar_number'=>$request->aadhar_number,
            'electricity_bill_number'=>isset($request->electricity_bill_number) ? $request->electricity_bill_number : '',
            'telephone_number'=>isset($request->telephone_number) ? $request->telephone_number : '',
            'state_id'=>$state_id,
            'gst_file'=>$gst_file_url,
            'iec_file'=>$iec_file_url,
            'pan_file'=>$pan_file_url,
            'aadhar_file'=>$aadhar_file_url,
            'electricity_bill_file'=>$electricity_bill_file_url,
            'telephone_file'=>$telephone_file_url,
            'user_id'=>auth()->user()->id,
        ]);

        return response()->json(['status'=>true,'msg'=> 'Exporter created successfully']);
        // session()->flash('success', 'Exporter Created successfully.');
        // return redirect(route('master.jobs.index'));
    }

    public function edit($id) {
        if(!\Helper::isAdmin()) return \Helper::invalidUserRedirect();
        $ms_consignee = \DB::table('ms_exporter')->where('id',$id)->where('status',1)->first();
        if($ms_consignee==null) {
            session()->flash('error', 'Invalid Request.');
            return redirect(route('master.jobs.index',['id'=>$id]));
        }
        $data['exporter'] = $ms_consignee;
        
        $states = \Helper::getStates(1);
        $data['states'] = $states;
        $cities = \Helper::getCities(1);
        $data['cities'] = $cities;

        return view('jobs.edit',$data);
    }

    public function update($id, Request $request) {
        if(!\Helper::isAdmin()) return \Helper::invalidUserRedirect();
        $ms_shippingline = \DB::table('ms_exporter')->where('id',$id)->where('status',1)->first();
        if($ms_shippingline==null) {
            return response()->json(['status'=>false,'msg'=> ['ivalid'=>['Invalid Request']]]);
        }


        $validator = Validator::make($request->all(),
            [
                'name' => 'required',
                'email' => 'required|email',
                'phone' => 'required|numeric',
                'address' => 'required',
                'state_id' => 'required|numeric',
                'city_id' => 'required|numeric',
                'pincode' => 'required|numeric',
                'gst_number' => 'required',
                'gst_file' => 'required|file',
                'gst_address' => 'required',
                'iec_number' => 'required|numeric',
                'iec_file' => 'required|file',
                'pan_number' => 'required',
                'pan_file' => 'required|file',
                'aadhar_number' => 'required',
                'aadhar_file' => 'required|file',
                'electricity_bill_number'=>'required_without:telephone_number|numeric',
                'electricity_bill_file'=>'required_without:telephone_file|file',
                'telephone_number'=>'required_without:electricity_bill_number|numeric',
                'telephone_file'=>'required_without:electricity_bill_file|file'
            ]
        );

        if ($validator->fails()) {
            //return redirect()->back()->withErrors($validator)->withInput();
            return response()->json(['status'=>false,'msg'=> $validator->messages()]);

        }

        $state_id = $request->state_id;
        $check_state = \Helper::getStates($state_id);
        if($check_state == null) {
            return response()->json(['status'=>false,'msg'=> ['ivalid'=>['Invalid Request']]]);
        }

        $check_ = \DB::table('ms_exporter')->where('email',$request->email)->where('id','!=',$id)->where('status',1)->first();
        if($check_ != null) {
            return response()->json(['status'=>false,'msg'=> ['alreay'=>['Exporter Email already been used']]]);
        }
        
        $electricityfileurl = $electricity_bill_file_url = $telephone_file_url = $gst_file_url = $pan_file_url = $aadhar_file_url = $iec_file_url = '';

        if($request->hasFile('electricity_bill_file')) {
            $electricity_bill_file_url = \Helper::fileUpload($request->file('electricity_bill_file'),'electricity_bill_file','exporters');
        }

        if($request->hasFile('telephone_file')) {
            $telephone_file_url = \Helper::fileUpload($request->file('telephone_file'),'telephone_file');
        }

        if($request->hasFile('gst_file')) {
            $gst_file_url = \Helper::fileUpload($request->file('gst_file'),'gst_file');
        }

        if($request->hasFile('pan_file')) {
            $pan_file_url = \Helper::fileUpload($request->file('pan_file'),'pan_file');
        }

        if($request->hasFile('aadhar_file')) {
            $aadhar_file_url = \Helper::fileUpload($request->file('aadhar_file'),'aadhar_file');
        }

        if($request->hasFile('iec_file')) {
            $iec_file_url = \Helper::fileUpload($request->file('iec_file'),'iec_file');
        }
        

        $last_id = \DB::table('ms_exporter')->where('id',$id)->update([
            'name'=>$request->name,
            'email'=>$request->email,
            'phone'=>$request->phone,
            'address'=>$request->address,
            'city_id'=>$request->city_id,
            'pincode'=>$request->pincode,
            'gst_number'=>$request->gst_number,
            'gst_address'=>$request->gst_address,
            'iec_number'=>$request->iec_number,
            'pan_number'=>$request->pan_number,
            'aadhar_number'=>$request->aadhar_number,
            'electricity_bill_number'=>isset($request->electricity_bill_number) ? $request->electricity_bill_number : '',
            'telephone_number'=>isset($request->telephone_number) ? $request->telephone_number : '',
            'state_id'=>$state_id,
            'gst_file'=>$gst_file_url,
            'iec_file'=>$iec_file_url,
            'pan_file'=>$pan_file_url,
            'aadhar_file'=>$aadhar_file_url,
            'electricity_bill_file'=>$electricity_bill_file_url,
            'telephone_file'=>$telephone_file_url,
            'user_id'=>auth()->user()->id,
        ]);

        return response()->json(['status'=>true,'msg'=> 'Exporter updated successfully']);
    } 

    public function delete($id) {
        if(!\Helper::isAdmin()) return \Helper::invalidUserRedirect();
        $ms_consignee = \DB::table('ms_exporter')->where('id',$id)->where('status',1)->first();
        if($ms_consignee==null) {
            session()->flash('error', 'Invalid Request.');
            return redirect(route('master.jobs.index',['id'=>$id]));
        }
        
        \DB::table('ms_exporter')->where('id',$id)->update(['status'=>0]);
        session()->flash('success', 'Exporter Deleted successfully.');
        return redirect(route('master.jobs.index'));
    }
}