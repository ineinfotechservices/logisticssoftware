<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DeliveryAgentController extends Controller
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
        $shippingline = \DB::table('delivery_agent')->where('status',1)->get();
        $data['shippingline'] = $shippingline;
        return view('deliveryagent.index',$data);
    }

    public function add() {
        if(!\Helper::isAdmin()) return \Helper::invalidUserRedirect();
        $countries = \Helper::getCountries();
        $data['countries'] = $countries;
        return view('deliveryagent.add',$data);
    }

    public function save(Request $request) {

        if(!\Helper::isAdmin()) return \Helper::invalidUserRedirect();
        $validator = Validator::make($request->all(),
            [
                'title' => 'required|unique:delivery_agent',
                'email' => 'required|email|unique:delivery_agent',
                'mobile' => 'required|numeric|unique:delivery_agent',
                'country' => 'required|numeric',
                'pincode' => 'required|numeric',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['status'=>false,'msg'=> $validator->messages()]);
        }

        
        if(strlen($request->mobile) != 10) {
            return response()->json(['status'=>false,'msg'=>['mob'=>['Please provide valid mobile number']]]);
        }

        
        
        $last_id = \DB::table('delivery_agent')->insertGetId([
            'title'=>$request->title,
            'email'=>$request->email,
            'mobile'=>$request->mobile,
            'country'=>isset($request->country) ? $request->country : '',
            'pincode'=>isset($request->pincode) ? $request->pincode : '',
            'address'=>isset($request->address) ? $request->address : '',
            'address2'=>isset($request->address2) ? $request->address2 : '',
            'address3'=>isset($request->address3) ? $request->address3 : '',
            'state_id'=>isset($request->state_id) ? $request->state_id : 0,
            'city_id'=>isset($request->city_id) ? $request->city_id : 0,
            'user_id'=>auth()->user()->id,
        ]);

        session()->flash('success', 'Delivery Agent User Created successfully.');
        return response()->json(['status'=>true,'msg'=> 'Saved successfully']);
    }

    public function edit($id) {

        if(!\Helper::isAdmin()) return \Helper::invalidUserRedirect();
        $ms_consignee = \DB::table('delivery_agent')->where('id',$id)->where('status',1)->first();
        if($ms_consignee==null) {
            session()->flash('error', 'Invalid Request.');
            return redirect(route('master.deliveryagent.index',['id'=>$id]));
        }

        $data['shippingline'] = $ms_consignee;
        $countries = \Helper::getCountries();
        $data['countries'] = $countries;
        return view('deliveryagent.edit',$data);
    }

    public function update($id, Request $request) {

        if(!\Helper::isAdmin()) return \Helper::invalidUserRedirect();

        $ms_shippingline = \DB::table('delivery_agent')->where('id',$id)->where('status',1)->first();
        if($ms_shippingline==null) {
            session()->flash('error', 'Invalid Request.');
            return redirect(route('master.deliveryagent.index',['id'=>$id]));
        }


        $validator = Validator::make($request->all(),
        [
            'title' => 'required',
            'email' => 'required|email',
            'mobile' => 'required|numeric',
            'country' => 'required|numeric',
            'pincode' => 'required|numeric',
        ]
        );

        if ($validator->fails()) {
            return response()->json(['status'=>false,'msg'=> $validator->messages()]);
        }
        if(strlen($request->mobile) != 10) {
            return response()->json(['status'=>false,'msg'=>['mob'=>['Please provide valid mobile number']]]);
        }

        $email_validte = \DB::table('delivery_agent')->where('email',$request->email)->where('status','!=',0)->where('id','!=',$id)->first();
        if($email_validte!=null) {
            return response()->json(['status'=>false,'msg'=>['mob'=>['Email already been used']]]);
        }

        $mobile_validte = \DB::table('delivery_agent')->where('mobile',$request->mobile)->where('status','!=',0)->where('id','!=',$id)->first();
        if($mobile_validte!=null) {
            return response()->json(['status'=>false,'msg'=>['mob'=>['Mobile already been used']]]);
        }

        \DB::table('delivery_agent')->where('id',$id)->update([
            'title'=>$request->title,
            'email'=>$request->email,
            'mobile'=>$request->mobile,
            'user_id'=>auth()->user()->id,
            'country'=>isset($request->country) ? $request->country : 0,
            'state_id'=>isset($request->state_id) ? $request->state_id : 0,
            'city_id'=>isset($request->city_id) ? $request->city_id : 0,
            'pincode'=>isset($request->pincode) ? $request->pincode : '',
            'address'=>isset($request->address) ? $request->address : '',
            'address2'=>isset($request->address2) ? $request->address2 : '',
            'address3'=>isset($request->address3) ? $request->address3 : '',
        ]);

        session()->flash('success', 'Delivery Agent User Updated successfully.');
        return response()->json(['status'=>true,'msg'=> 'Saved successfully']);
    } 

    public function delete($id) {

        if(!\Helper::isAdmin()) return \Helper::invalidUserRedirect();
        $ms_consignee = \DB::table('delivery_agent')->where('id',$id)->where('status',1)->first();
        if($ms_consignee==null) {
            session()->flash('error', 'Invalid Request.');
            return redirect(route('master.deliveryagent.index',['id'=>$id]));
        }
        
        \DB::table('delivery_agent')->where('id',$id)->update(['status'=>0]);
        session()->flash('success', 'Notify User Deleted successfully.');
        return redirect(route('master.deliveryagent.index'));
    }
    public function delivery_agent_data($id, Request $request) {
        $consigneeIdx = isset($request->consigneeIdx) ? $request->consigneeIdx : 0;
        $html = \Helper::getDeliveryAgentDetailBL($consigneeIdx);
        return response()->json(['status' => true, 'msg' => '','data'=>$html]);    
    }
}