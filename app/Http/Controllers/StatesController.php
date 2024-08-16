<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StatesController extends Controller
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
        $shippingline = \DB::table('states')->where('status',1)->get();
        $data['states'] = $shippingline;
        $countries = \Helper::getCountries();
        $data['countries'] = $countries;
        return view('state.index',$data);
    }

    public function add() {

        if(!\Helper::isAdmin()) return \Helper::invalidUserRedirect();
        $countries = \Helper::getCountries();
        $data['countries'] = $countries;
        return view('state.add',$data);
    }

    public function save(Request $request) {
        $validator = Validator::make($request->all(),
            [
                'title' => 'required',
                'country_id' => 'required|numeric',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $country_id = $request->country_id;
        $check_country = \Helper::getCountries($country_id);
        if($check_country == null) {
            return redirect()->back()->withErrors('Invalid Country');
        }

        $last_id = \DB::table('states')->insertGetId([
            'title'=>$request->title,
            'countries_id'=>$country_id,
            'user_id'=>auth()->user()->id,
        ]);

        session()->flash('success', 'State Created successfully.');
        return redirect(route('master.state.index'));
    }

    public function edit($id) {

        if(!\Helper::isAdmin()) return \Helper::invalidUserRedirect();
        $ms_consignee = \DB::table('states')->where('id',$id)->where('status',1)->first();
        if($ms_consignee==null) {
            session()->flash('error', 'Invalid Request.');
            return redirect(route('master.state.index',['id'=>$id]));
        }

        $countries = \Helper::getCountries();
        $data['countries'] = $countries;

        $data['shippingline'] = $ms_consignee;
        return view('state.edit',$data);
    }

    public function update($id, Request $request) {

        if(!\Helper::isAdmin()) return \Helper::invalidUserRedirect();
        $ms_shippingline = \DB::table('states')->where('id',$id)->where('status',1)->first();
        if($ms_shippingline==null) {
            session()->flash('error', 'Invalid Request.');
            return redirect(route('master.state.index',['id'=>$id]));
        }


        $validator = Validator::make($request->all(),
        [
            'title' => 'required',
            'country_id' => 'required|numeric',
        ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $country_id = $request->country_id;
        $check_country = \Helper::getCountries($country_id);
        if($check_country == null) {
            return redirect()->back()->withErrors('Invalid Country');
        }

        \DB::table('states')->where('id',$id)->update([
            'title'=>$request->title,
            'countries_id'=>$request->country_id,
        ]);

        session()->flash('success', 'State Updated successfully.');
        return redirect(route('master.state.index'));
    } 

    public function delete($id) {
        if(!\Helper::isAdmin()) return \Helper::invalidUserRedirect();
        $ms_consignee = \DB::table('states')->where('id',$id)->where('status',1)->first();
        if($ms_consignee==null) {
            session()->flash('error', 'Invalid Request.');
            return redirect(route('master.state.index',['id'=>$id]));
        }
        
        \DB::table('states')->where('id',$id)->update(['status'=>0]);
        session()->flash('success', 'State Deleted successfully.');
        return redirect(route('master.state.index'));
    }

    public function fetch_states(Request $request) {

        
        $country_id = isset($request->country_id) ?$request->country_id : 0;
        if($country_id == 0) {
            return response()->json(['status'=>true,'msg'=> '','data'=>[]]);
        }
        $getStates = \Helper::getStates($country_id);
        return response()->json(['status'=>true,'msg'=> '','data'=>$getStates]);
    }
}