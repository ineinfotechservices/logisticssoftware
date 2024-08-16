<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PlaceofReceiptController extends Controller
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
        $shippingline = \DB::table('ms_place_of_receipt')->where('status',1)->get();
        $data['shippingline'] = $shippingline;
        return view('placeofreceipt.index',$data);
    }

    public function add() {
        if(!\Helper::isAdmin()) return \Helper::invalidUserRedirect();
        $data['country_list'] = \Helper::getCountries();
        return view('placeofreceipt.add',$data);
    }

    public function save(Request $request) {
        if(!\Helper::isAdmin()) return \Helper::invalidUserRedirect();
        $validator = Validator::make($request->all(),
            [
                'title' => 'required|unique:ms_port_of_destination',
                'country_id' => 'required',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $last_id = \DB::table('ms_place_of_receipt')->insertGetId([
            'title'=>$request->title,
            'country_id'=>$request->country_id,
            'created_by'=>auth()->user()->id,
        ]);

        session()->flash('success', 'Place of Receipt Created successfully.');
        return redirect(route('master.placeofreceipt.index'));
    }

    public function edit($id) {

        if(!\Helper::isAdmin()) return \Helper::invalidUserRedirect();
        $ms_consignee = \DB::table('ms_place_of_receipt')->where('id',$id)->where('status',1)->first();
        if($ms_consignee==null) {
            session()->flash('error', 'Invalid Request.');
            return redirect(route('master.placeofreceipt.index',['id'=>$id]));
        }

        $data['shippingline'] = $ms_consignee;
        $data['country_list'] = \Helper::getCountries();
        return view('placeofreceipt.edit',$data);
    }

    public function update($id, Request $request) {

        if(!\Helper::isAdmin()) return \Helper::invalidUserRedirect();

        $ms_shippingline = \DB::table('ms_place_of_receipt')->where('id',$id)->where('status',1)->first();
        if($ms_shippingline==null) {
            session()->flash('error', 'Invalid Request.');
            return redirect(route('master.placeofreceipt.index',['id'=>$id]));
        }


        $validator = Validator::make($request->all(),
        [
            'title' => 'required|unique:ms_port_of_destination,title,'.$id,
            'country_id' => 'required',
        ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        \DB::table('ms_place_of_receipt')->where('id',$id)->update([
            'title'=>$request->title,
            'country_id'=>$request->country_id,
            
        ]);

        session()->flash('success', 'Equipment Type Updated successfully.');
        return redirect(route('master.placeofreceipt.index'));
    } 

    public function delete($id) {

        if(!\Helper::isAdmin()) return \Helper::invalidUserRedirect();
        $ms_consignee = \DB::table('ms_place_of_receipt')->where('id',$id)->where('status',1)->first();
        if($ms_consignee==null) {
            session()->flash('error', 'Invalid Request.');
            return redirect(route('master.placeofreceipt.index',['id'=>$id]));
        }
        
        \DB::table('ms_place_of_receipt')->where('id',$id)->update(['status'=>0]);
        session()->flash('success', 'Equipment type Deleted successfully.');
        return redirect(route('master.placeofreceipt.index'));
    }
}