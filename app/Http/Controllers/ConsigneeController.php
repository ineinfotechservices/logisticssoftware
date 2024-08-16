<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ConsigneeController extends Controller
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
        
        if(!\Helper::isDocument() || !\Helper::isAdmin()) return \Helper::invalidUserRedirect();
        
        $consignee = \DB::table('ms_consignee')->where('status',1)->get();
        $data['consignee'] = $consignee;
        return view('consignee.index',$data);
    }

    public function add() {
        if(!\Helper::isAdmin()) return \Helper::invalidUserRedirect();
        $countries = \Helper::getCountries();
        $data['countries'] = $countries;
        
        return view('consignee.add',$data);
    }

    public function save(Request $request) {
        if(!\Helper::isAdmin()) return \Helper::invalidUserRedirect();
        $validator = Validator::make($request->all(),
        [
            'full_name' => 'required',
            'email_address' => 'required|email',
            'contact_number' => 'required|numeric',
            'country' => 'required|numeric',
            'pincode' => 'required|numeric',
            'tax_id' => 'required|numeric',
        ]
        );

        if ($validator->fails()) {
            return response()->json(['status'=>false,'msg'=> $validator->messages()]);
            //return redirect()->back()->withErrors($validator)->withInput();
        }

        //dd($request->all());
        

        $last_id = \DB::table('ms_consignee')->insertGetId([
            'full_name'=>$request->full_name,
            'email_address'=>isset($request->email_address) ? $request->email_address : '',
            'contact_number'=>isset($request->contact_number) ? $request->contact_number : '',
            'country'=>isset($request->country) ? $request->country : '',
            'pincode'=>isset($request->pincode) ? $request->pincode : '',
            'address'=>isset($request->address) ? $request->address : '',
            'address2'=>isset($request->address2) ? $request->address2 : '',
            'address3'=>isset($request->address3) ? $request->address3 : '',
            'state_id'=>isset($request->state_id) ? $request->state_id : 0,
            'city_id'=>isset($request->city_id) ? $request->city_id : 0,
            'tax_id'=>isset($request->tax_id) ? $request->tax_id : '',
            'created_by'=>auth()->user()->id,
        ]);

        session()->flash('success', 'Consignee Created successfully.');
        return response()->json(['status'=>true,'msg'=> 'Saved successfully']);
//        return redirect(route('master.consignee.index'));
    }

    public function edit($id) {
        if(!\Helper::isAdmin()) return \Helper::invalidUserRedirect();
        $ms_consignee = \DB::table('ms_consignee')->where('id',$id)->where('status',1)->first();
        if($ms_consignee==null) {
            session()->flash('error', 'Invalid Request.');
            return redirect(route('master.consignee.index',['id'=>$id]));
        }

        $data['consignee'] = $ms_consignee;
        $countries = \Helper::getCountries();
        $data['countries'] = $countries;
        return view('consignee.edit',$data);
    }

    public function update($id, Request $request) {
        if(!\Helper::isAdmin()) return \Helper::invalidUserRedirect();
        $ms_consignee = \DB::table('ms_consignee')->where('id',$id)->where('status',1)->first();
        if($ms_consignee==null) {
            session()->flash('error', 'Invalid Request.');
            return response()->json(['status'=>false,'msg'=> 'Invalid List']);
        }


        $validator = Validator::make($request->all(),
        [
            'full_name' => 'required',
            'email_address' => 'required|email',
            'contact_number' => 'required|numeric',
            'country' => 'required|numeric',
            'pincode' => 'required|numeric',
            'tax_id' => 'required|numeric',
        ]
        );

        if ($validator->fails()) {
            return response()->json(['status'=>false,'msg'=> $validator->messages()]);
        }

        \DB::table('ms_consignee')->where('id',$id)->update([
            'full_name'=>$request->full_name,
            'email_address'=>isset($request->email_address) ? $request->email_address : '',
            'contact_number'=>isset($request->contact_number) ? $request->contact_number : '',
            'country'=>isset($request->country) ? $request->country : 0,
            'state_id'=>isset($request->state_id) ? $request->state_id : 0,
            'city_id'=>isset($request->city_id) ? $request->city_id : 0,
            'pincode'=>isset($request->pincode) ? $request->pincode : '',
            'address'=>isset($request->address) ? $request->address : '',
            'address2'=>isset($request->address2) ? $request->address2 : '',
            'address3'=>isset($request->address3) ? $request->address3 : '',
            'tax_id'=>isset($request->tax_id) ? $request->tax_id : '',
        ]);

        session()->flash('success', 'Consignee Updated successfully.');
        //return redirect(route('master.consignee.index'));
        return response()->json(['status'=>true,'msg'=> 'Saved successfully']);
    } 

    public function delete($id) {
        if(!\Helper::isAdmin()) return \Helper::invalidUserRedirect();
        $ms_consignee = \DB::table('ms_consignee')->where('id',$id)->where('status',1)->first();
        if($ms_consignee==null) {
            session()->flash('error', 'Invalid Request.');
            return redirect(route('master.consignee.index',['id'=>$id]));
        }
        
        \DB::table('ms_consignee')->where('id',$id)->update(['status'=>0]);
        session()->flash('success', 'Consignee Deleted successfully.');
        return redirect(route('master.consignee.index'));
    }
}