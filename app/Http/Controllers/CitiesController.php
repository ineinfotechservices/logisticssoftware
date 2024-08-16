<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CitiesController extends Controller
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

        $shippingline = \DB::table('cities')->where('status',1)->get();
        $data['states'] = $shippingline;
        $countries = \Helper::getCountries();
        $data['countries'] = $countries;
        return view('city.index',$data);
    }

    public function add() {

        $states = \Helper::getStates();
        $data['states'] = $states;
        return view('city.add',$data);
    }

    public function save(Request $request) {
        $validator = Validator::make($request->all(),
            [
                'title' => 'required',
                'state_id' => 'required|numeric',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $state_id = $request->state_id;
        $check_state = \Helper::getStates($state_id);
        if($check_state == null) {
            return redirect()->back()->withErrors('Invalid State');
        }

        $last_id = \DB::table('cities')->insertGetId([
            'title'=>$request->title,
            'state_id'=>$state_id,
            'user_id'=>auth()->user()->id,
        ]);

        session()->flash('success', 'City Created successfully.');
        return redirect(route('master.city.index'));
    }

    public function edit($id) {

        $ms_consignee = \DB::table('cities')->where('id',$id)->where('status',1)->first();
        if($ms_consignee==null) {
            session()->flash('error', 'Invalid Request.');
            return redirect(route('master.state.index',['id'=>$id]));
        }

        $states = \Helper::getStates();
        $data['states'] = $states;

        $data['shippingline'] = $ms_consignee;
        return view('city.edit',$data);
    }

    public function update($id, Request $request) {

        $ms_shippingline = \DB::table('cities')->where('id',$id)->where('status',1)->first();
        if($ms_shippingline==null) {
            session()->flash('error', 'Invalid Request.');
            return redirect(route('master.city.index',['id'=>$id]));
        }


        $validator = Validator::make($request->all(),
        [
            'title' => 'required',
            'state_id' => 'required|numeric',
        ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $state_id = $request->state_id;
        $check_country = \Helper::getStates($state_id);
        if($check_country == null) {
            return redirect()->back()->withErrors('Invalid Country');
        }

        

        \DB::table('cities')->where('id',$id)->update([
            'title'=>$request->title,
            'state_id'=>$request->state_id,
        ]);

        session()->flash('success', 'City Updated successfully.');
        return redirect(route('master.city.index'));
    } 

    public function delete($id) {
        $ms_consignee = \DB::table('cities')->where('id',$id)->where('status',1)->first();
        if($ms_consignee==null) {
            session()->flash('error', 'Invalid Request.');
            return redirect(route('master.city.index',['id'=>$id]));
        }
        
        \DB::table('cities')->where('id',$id)->update(['status'=>0]);
        session()->flash('success', 'City Deleted successfully.');
        return redirect(route('master.city.index'));
    }

    public function fetch_cities(Request $request) {
        $state_id = isset($request->state_id) ?$request->state_id : 0;
        if($state_id == 0) {
            return response()->json(['status'=>true,'msg'=> '','data'=>[]]);
        }
        $getCities = \Helper::getCities($state_id);
        return response()->json(['status'=>true,'msg'=> '','data'=>$getCities]);
    }

    
}