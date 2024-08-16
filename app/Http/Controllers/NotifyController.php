<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NotifyController extends Controller
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
        $shippingline = \DB::table('notify_users')->where('status',1)->get();
        $data['shippingline'] = $shippingline;
        return view('notify.index',$data);
    }

    public function add() {
        if(!\Helper::isAdmin()) return \Helper::invalidUserRedirect();
        return view('notify.add');
    }

    public function save(Request $request) {
        if(!\Helper::isAdmin()) return \Helper::invalidUserRedirect();
        $validator = Validator::make($request->all(),
            [
                'title' => 'required|unique:notify_users',
                'email' => 'required|email|unique:notify_users',
                'mobile' => 'required|numeric|unique:notify_users',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        
        if(strlen($request->mobile) != 10) {
            return redirect()->back()->withErrors(['mob'=>['Please provide valid mobile number']])->withInput();
        }
        
        $last_id = \DB::table('notify_users')->insertGetId([
            'title'=>$request->title,
            'email'=>$request->email,
            'mobile'=>$request->mobile,
            'user_id'=>auth()->user()->id,
        ]);

        session()->flash('success', 'Notify User Created successfully.');
        return redirect(route('master.notify.index'));
    }

    public function edit($id) {

        if(!\Helper::isAdmin()) return \Helper::invalidUserRedirect();
        $ms_consignee = \DB::table('notify_users')->where('id',$id)->where('status',1)->first();
        if($ms_consignee==null) {
            session()->flash('error', 'Invalid Request.');
            return redirect(route('master.notify.index',['id'=>$id]));
        }

        $data['shippingline'] = $ms_consignee;
        return view('notify.edit',$data);
    }

    public function update($id, Request $request) {

        if(!\Helper::isAdmin()) return \Helper::invalidUserRedirect();

        $ms_shippingline = \DB::table('notify_users')->where('id',$id)->where('status',1)->first();
        if($ms_shippingline==null) {
            session()->flash('error', 'Invalid Request.');
            return redirect(route('master.notify.index',['id'=>$id]));
        }


        $validator = Validator::make($request->all(),
        [
            'title' => 'required',
            'email' => 'required|email',
            'mobile' => 'required|numeric',
        ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        if(strlen($request->mobile) != 10) {
            return redirect()->back()->withErrors(['mob'=>['Please provide valid mobile number']])->withInput();
        }

        $email_validte = \DB::table('notify_users')->where('email',$request->email)->where('status','!=',0)->where('id','!=',$id)->first();
        if($email_validte!=null) {
            return redirect()->back()->withErrors(['sdf'=>['Email already been used']])->withInput();
        }

        $mobile_validte = \DB::table('notify_users')->where('mobile',$request->mobile)->where('status','!=',0)->where('id','!=',$id)->first();
        if($mobile_validte!=null) {
            return redirect()->back()->withErrors(['sdf'=>['Mobile already been used']])->withInput();
        }

        \DB::table('notify_users')->where('id',$id)->update([
            'title'=>$request->title,
            'email'=>$request->email,
            'mobile'=>$request->mobile,
            'user_id'=>auth()->user()->id,
        ]);

        session()->flash('success', 'Notify User Updated successfully.');
        return redirect(route('master.notify.index'));
    } 

    public function delete($id) {

        if(!\Helper::isAdmin()) return \Helper::invalidUserRedirect();
        $ms_consignee = \DB::table('notify_users')->where('id',$id)->where('status',1)->first();
        if($ms_consignee==null) {
            session()->flash('error', 'Invalid Request.');
            return redirect(route('master.notify.index',['id'=>$id]));
        }
        
        \DB::table('notify_users')->where('id',$id)->update(['status'=>0]);
        session()->flash('success', 'Notify User Deleted successfully.');
        return redirect(route('master.notify.index'));
    }
}