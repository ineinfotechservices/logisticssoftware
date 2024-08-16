<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ShippinglineController extends Controller
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
        $shippingline = \DB::table('ms_shippingline')->where('status',1)->get();
        $data['shippingline'] = $shippingline;
        return view('shippingline.index',$data);
    }

    public function add() {

        if(!\Helper::isAdmin()) return \Helper::invalidUserRedirect();
        return view('shippingline.add');
    }

    public function save(Request $request) {

        if(!\Helper::isAdmin()) return \Helper::invalidUserRedirect();
        $validator = Validator::make($request->all(),
            [
                'full_name' => 'required',
                'address' => 'required',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $last_id = \DB::table('ms_shippingline')->insertGetId([
            'full_name'=>$request->full_name,
            'created_by'=>auth()->user()->id,
            'address'=>$request->address
        ]);

        session()->flash('success', 'Shipping Line Created successfully.');
        return redirect(route('master.shippingline.index'));
    }

    public function edit($id) {

        if(!\Helper::isAdmin()) return \Helper::invalidUserRedirect();
        $ms_consignee = \DB::table('ms_shippingline')->where('id',$id)->where('status',1)->first();
        if($ms_consignee==null) {
            session()->flash('error', 'Invalid Request.');
            return redirect(route('master.shippingline.index',['id'=>$id]));
        }

        $data['shippingline'] = $ms_consignee;
        return view('shippingline.edit',$data);
    }

    public function update($id, Request $request) {

        if(!\Helper::isAdmin()) return \Helper::invalidUserRedirect();
        $ms_shippingline = \DB::table('ms_shippingline')->where('id',$id)->where('status',1)->first();
        if($ms_shippingline==null) {
            session()->flash('error', 'Invalid Request.');
            return redirect(route('master.shippingline.index',['id'=>$id]));
        }


        $validator = Validator::make($request->all(),
        [
            'full_name' => 'required',
            'address' => 'required',
        ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        \DB::table('ms_shippingline')->where('id',$id)->update([
            'full_name'=>$request->full_name,
            'address'=>isset($request->address) ? $request->address : '',
        ]);

        session()->flash('success', 'Shipping Line Updated successfully.');
        return redirect(route('master.shippingline.index'));
    } 

    public function delete($id) {

        if(!\Helper::isAdmin()) return \Helper::invalidUserRedirect();
        $ms_consignee = \DB::table('ms_shippingline')->where('id',$id)->where('status',1)->first();
        if($ms_consignee==null) {
            session()->flash('error', 'Invalid Request.');
            return redirect(route('master.consignee.index',['id'=>$id]));
        }
        
        \DB::table('ms_shippingline')->where('id',$id)->update(['status'=>0]);
        session()->flash('success', 'Shipping Line Deleted successfully.');
        return redirect(route('master.shippingline.index'));
    }
}