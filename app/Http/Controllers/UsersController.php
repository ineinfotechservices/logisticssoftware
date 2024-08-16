<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
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
    public function dashboard()
    {
        

        $notifications = \Helper::getNotifications();
        $data['notifications'] = $notifications;
        return view('users.dashboard',$data);
    }

    public function index()
    {

        $users = \DB::table('users')->where('status',1)->get();
        $data['users'] = $users;
        $roles = \Helper::get_roles();
        $list_roles = [];
        if(isset($roles) && is_object($roles) && $roles->count()) {
            foreach($roles as $role) {
                $list_roles[$role->id] = $role->role_name;
            }
        }

        $data['role_name'] = $list_roles;
        $data['roles'] = $roles;
        return view('users.index',$data);
    }

    public function add() {
        if(!\Helper::isAdmin()) return \Helper::invalidUserRedirect();
        $roles = \Helper::get_roles();
        $data['roles'] = $roles;
        return view('users.add',$data);
    }

    public function save(Request $request) {
        if(!\Helper::isAdmin()) return \Helper::invalidUserRedirect();

        
        $validator = Validator::make($request->all(),
            [
                //'job_number' => 'required|unique:trans_booking_details',
                'name' => 'required',
                'email' => 'required|unique:users',
                'password' => 'required',
                'confirm_password' => 'required|same:password',
                'roles_id' => 'required|numeric',
            ]
        );

        if ($validator->fails()) {
            //return redirect()->back()->withErrors($validator)->withInput();
            return response()->json(['status'=>false,'msg'=> $validator->messages()]);

        }

        $last_id = \DB::table('users')->insertGetId([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'roles_id'=>$request->roles_id,
            'user_id'=>auth()->user()->id,
        ]);

        return response()->json(['status'=>true,'msg'=> 'Users created successfully']);
        // session()->flash('success', 'Exporter Created successfully.');
        // return redirect(route('master.users.index'));
    }

    public function edit($id) {

        if(!\Helper::isAdmin()) return \Helper::invalidUserRedirect();
        $rec_info = \DB::table('users')->where('id',$id)->where('status','!=',0)->first();
        if($rec_info==null) {
            session()->flash('error', 'Invalid Request.');
            return redirect(route('master.users.index'));
        }
        
        $roles = \Helper::get_roles();
        $data['roles'] = $roles;
        $data['id'] = $rec_info->id ?? 0;
        $data['info'] = $rec_info;
        return view('users.edit',$data);
    }

    public function update($id, Request $request) {

        if(!\Helper::isAdmin()) return \Helper::invalidUserRedirect();
        $rec_info = \DB::table('users')->where('id',$id)->where('status','!=',0)->first();
        if($rec_info==null) {
            session()->flash('error', 'Invalid Request.');
            return response()->json(['status'=>false,'msg'=> ['ivalid'=>['Invalid Request']]]);
        }

        $validator = Validator::make($request->all(),
        [
            'name' => 'required',
            'email' => 'required',
            'roles_id' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json(['status'=>false,'msg'=> $validator->messages()]);
        }
        
        \DB::table('users')->where('id',$id)->update([
            'name'=>$request->name,
            'email'=>$request->email,
            'roles_id'=>$request->roles_id,
            'user_id'=>auth()->user()->id,
        ]);

        if(isset($request->password) && isset($request->confirm_password)) {
            if($request->password !== $request->confirm_password) {
                return response()->json(['status'=>false,'msg'=> ['ff'=>['Password and confirm password does not match']]]);        
            }

            \DB::table('users')->where('id',$id)->update([
                'password'=>Hash::make($request->password),
            ]); 
        }
        return response()->json(['status'=>true,'msg'=> 'User Details updated successfully']);
    } 

    public function update1($id, Request $request) {

        if(!\Helper::isAdmin()) return \Helper::invalidUserRedirect();
        $ms_shippingline = \DB::table('trans_booking_details')->where('id',$id)->where('status',1)->first();
        if($ms_shippingline==null) {
            return response()->json(['status'=>false,'msg'=> ['ivalid'=>['Invalid Request']]]);
        }

        

        $validator = Validator::make($request->all(),
        [
            'ms_exporter_id' => 'required|numeric',
            'booking_received_from' => 'required',
            'ms_incoterm_id' => 'required|numeric',
            'selling_rate' => 'required|numeric',
            'ms_currencies_id' => 'required|numeric',
            'other_charges' => 'required',
            'shipping_line_rate' => 'required|numeric',
            'ms_equipment_type_id' => 'required|numeric',
            'no_of_container' => 'required|numeric',
            'ms_port_of_loading_id' => 'required|numeric',
            'pickup_location' => 'required',
            'ms_port_of_destination' => 'required|numeric',
            'final_place_of_delivery' => 'required',
        ]
        );

        if ($validator->fails()) {
            //return redirect()->back()->withErrors($validator)->withInput();
            return response()->json(['status'=>false,'msg'=> $validator->messages()]);

        }

        $last_id = \DB::table('trans_booking_details')->where('id',$id)->update([
            'ms_exporter_id'=>$request->ms_exporter_id,
            'booking_received_from'=>$request->booking_received_from,
            'ms_incoterm_id'=>$request->ms_incoterm_id,
            'selling_rate'=>$request->selling_rate,
            'ms_currencies_id'=>$request->ms_currencies_id,
            'other_charges'=>$request->other_charges,
            'shipping_line_rate'=>$request->shipping_line_rate,
            'ms_equipment_type_id'=>$request->ms_equipment_type_id,
            'no_of_container'=>$request->no_of_container,
            'ms_port_of_loading_id'=>$request->ms_port_of_loading_id,
            'pickup_location'=>isset($request->pickup_location) ? $request->pickup_location : '',
            'ms_port_of_destination'=>isset($request->ms_port_of_destination) ? $request->ms_port_of_destination : '',
            'final_place_of_delivery'=>isset($request->final_place_of_delivery) ? $request->final_place_of_delivery : '',
            'user_id'=>auth()->user()->id,
        ]);


        return response()->json(['status'=>true,'msg'=> 'Booking Detail updated successfully']);
    } 

    public function delete($id) {
        if(!\Helper::isAdmin()) return \Helper::invalidUserRedirect();
        $ms_consignee = \DB::table('users')->where('id',$id)->where('status',1)->first();
        if($ms_consignee==null) {
            session()->flash('error', 'Invalid Request.');
            return redirect(route('master.users.index',['id'=>$id]));
        }
        
        \DB::table('users')->where('id',$id)->update(['status'=>0]);
        session()->flash('success', 'User Deleted successfully.');
        return redirect(route('master.users.index'));
    }


    public function profile() {


        $id = \Auth::id();
        $rec_info = \DB::table('users')->where('id',$id)->where('status','!=',0)->first();
        if($rec_info==null) {
            session()->flash('error', 'Invalid Request.');
            return redirect(route('master.users.index'));
        }
        
        $roles = \Helper::get_roles();
        $data['roles'] = $roles;
        $data['info'] = $rec_info;
        $data['id'] = $rec_info->id ?? 0;
        return view('users.profile',$data);
    }

    public function profile_update(Request $request) {
        $id = \Auth::id();
        $ms_shippingline = \DB::table('trans_booking_details')->where('id',$id)->where('status',1)->first();
        if($ms_shippingline==null) {
            return response()->json(['status'=>false,'msg'=> ['ivalid'=>['Invalid Request']]]);
        }

        $validator = Validator::make($request->all(),
        [
            'name' => 'required',
            'password' => 'nullable',
            'confirm_password' => 'required_with:password|same:password',
        ]
        );

        if ($validator->fails()) {
            //return redirect()->back()->withErrors($validator)->withInput();
            return response()->json(['status'=>false,'msg'=> $validator->messages()]);
        }

        $condition = [
            'name'=>$request->name,
        ];
        if(isset($request->password) && $request->password!='') {
            $condition = [
                'name'=>$request->name,
                'password'=>Hash::make($request->password),
            ];
        }
        \DB::table('users')->where('id',$id)->update($condition);
        return response()->json(['status'=>true,'msg'=>'Profile updated successfully']);
    }

    public function logout() {
        $chk = \DB::table('user_logs')->where('user_id',\Auth::id())->orderBy('id','desc')->first();
        if($chk!==null) \DB::table('user_logs')->where('id',$chk->id)->update(['logout_time'=>\DB::raw('NOW()')]);
        Session::flush();
        
        Auth::logout();

        return redirect('login');
    }
}