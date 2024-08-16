<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EquipmentTypeController extends Controller
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
        $shippingline = \DB::table('ms_equipment_type')->where('status',1)->get();
        $data['shippingline'] = $shippingline;
        return view('equipmenttype.index',$data);
    }

    public function add() {
        if(!\Helper::isAdmin()) return \Helper::invalidUserRedirect();
        return view('equipmenttype.add');
    }

    public function save(Request $request) {
        if(!\Helper::isAdmin()) return \Helper::invalidUserRedirect();
        $validator = Validator::make($request->all(),
            [
                'title' => 'required',
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $last_id = \DB::table('ms_equipment_type')->insertGetId([
            'title'=>$request->title,
            'created_by'=>auth()->user()->id,
        ]);

        session()->flash('success', 'Equipment Type Created successfully.');
        return redirect(route('master.equipmenttype.index'));
    }

    public function edit($id) {
        if(!\Helper::isAdmin()) return \Helper::invalidUserRedirect();
        $ms_consignee = \DB::table('ms_equipment_type')->where('id',$id)->where('status',1)->first();
        if($ms_consignee==null) {
            session()->flash('error', 'Invalid Request.');
            return redirect(route('master.equipmenttype.index',['id'=>$id]));
        }

        $data['shippingline'] = $ms_consignee;
        return view('equipmenttype.edit',$data);
    }

    public function update($id, Request $request) {
        if(!\Helper::isAdmin()) return \Helper::invalidUserRedirect();
        $ms_shippingline = \DB::table('ms_equipment_type')->where('id',$id)->where('status',1)->first();
        if($ms_shippingline==null) {
            session()->flash('error', 'Invalid Request.');
            return redirect(route('master.equipmenttype.index',['id'=>$id]));
        }


        $validator = Validator::make($request->all(),
        [
            'title' => 'required',
        ]
        );

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        \DB::table('ms_equipment_type')->where('id',$id)->update([
            'title'=>$request->title,
        ]);

        session()->flash('success', 'Equipment Type Updated successfully.');
        return redirect(route('master.equipmenttype.index'));
    } 

    public function delete($id) {
        if(!\Helper::isAdmin()) return \Helper::invalidUserRedirect();
        $ms_consignee = \DB::table('ms_equipment_type')->where('id',$id)->where('status',1)->first();
        if($ms_consignee==null) {
            session()->flash('error', 'Invalid Request.');
            return redirect(route('master.equipmenttype.index',['id'=>$id]));
        }
        
        \DB::table('ms_equipment_type')->where('id',$id)->update(['status'=>0]);
        session()->flash('success', 'Equipment type Deleted successfully.');
        return redirect(route('master.equipmenttype.index'));
    }
}