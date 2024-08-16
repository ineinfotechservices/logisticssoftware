<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FollowupController extends Controller
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

    public function index()
    {

        $records = \DB::table('trans_followup')->where('status','!=',0)->get();
        $data['records'] = $records;
        $roles = \Helper::get_roles();
        $list_roles = [];
        if(isset($roles) && is_object($roles) && $roles->count()) {
            foreach($roles as $role) {
                $list_roles[$role->id] = $role->role_name;
            }
        }

        $data['role_name'] = $list_roles;
        $data['roles'] = $roles;
        return view('followup.index',$data);
    }

    public function add() {
        if(!\Helper::isAdmin()) return \Helper::invalidUserRedirect();
        $role_users = \Helper::getFollowupUsers();
        $data['role_users'] = $role_users;
        return view('followup.add',$data);
    }

    public function add_save(Request $request) {
        if(!\Helper::isAdmin()) return \Helper::invalidUserRedirect();
        $validator = Validator::make($request->all(),
            [
                //'job_number' => 'required|unique:trans_booking_details',
                'title' => 'required',
                'assign_user_id' => 'required|numeric',
                'next_followup' => [
                    'date_format:d/m/Y H:i',// format without hours, minutes and seconds.
                    'after_or_equal:' . date('d/m/Y H:i'), // not 'now' string
                ],
            ]
        );

        if ($validator->fails()) {
            //return redirect()->back()->withErrors($validator)->withInput();
            return response()->json(['status'=>false,'msg'=> $validator->messages()]);

        }

        $last_id = \DB::table('trans_followup')->insertGetId([
            'title'=>$request->title,
            'user_id'=>auth()->user()->id,
        ]);

        $last_id = \DB::table('trans_followup_details')->insertGetId([
            'trans_followup_id'=>$last_id,
            'description'=>isset($request->description) ? $request->description : '',
            'next_followup_date'=>isset($request->next_followup) ? \Helper::converdatetime2db($request->next_followup) : NULL,
            'assign_user_id'=>isset($request->assign_user_id) ? $request->assign_user_id : 0,
            'user_id'=>auth()->user()->id,
        ]);

        

        return response()->json(['status'=>true,'msg'=> 'Folloup created successfully']);
        // session()->flash('success', 'Exporter Created successfully.');
        // return redirect(route('master.followup.index'));
    }

    
    public function addnext($id, Request $request) {
        $rows = \DB::table('trans_followup')->where('id',$id)->where('status','!=',0)->first();
        if($rows==null) {
            return redirect()->back()->with('error', 'Invalid Folowup Request');   
        }
        $data['id']  = $id;
        $data['row'] = $rows;
        $role_users = \Helper::getFollowupUsers();
        $data['role_users'] = $role_users;
        $FollowupStatus = \Helper::FollowupStatus();
        $data['FollowupStatus'] = $FollowupStatus;
        return view('followup.addnext',$data);
    }

    public function add_next_followup($id, Request $request) {
        $rows = \DB::table('trans_followup')->where('id',$id)->where('status','!=',0)->first();
        if($rows==null) {
            return response()->json(['status'=>false,'msg'=> ['unique'=>['Record not matched']]]);
        }

        $validator = Validator::make($request->all(),
        [
            'description' => 'required',
            'assign_user_id' => 'required|numeric',
            'followup_status' => 'required|numeric',
            'next_followup' => [
                'date_format:d/m/Y H:i',// format without hours, minutes and seconds.
                'after_or_equal:' . date('d/m/Y H:i'), // not 'now' string
            ],
        ]
        );

        if ($validator->fails()) {
            return response()->json(['status'=>false,'msg'=> $validator->messages()]);
        }
        
        \DB::table('trans_followup_details')->insert([
            'trans_followup_id'=>$id,
            'description'=>$request->description,
            'next_followup_date'=>isset($request->next_followup) ? \Helper::converdatetime2db($request->next_followup) : NULL,
            'assign_user_id'=>$request->assign_user_id,
            'status'=>$request->followup_status,
            'user_id'=>\Auth::id()
        ]);

        if(isset($request->followup_status) && $request->followup_status==4) {
            \DB::table('trans_followup')->where('id',$id)->update(['status'=>$request->followup_status]);
        }
        return response()->json(['status'=>true,'msg'=> 'Follow-up has been saved successfully.']);
    }

    public function delete_followups($id) {
        $rows = \DB::table('trans_followup')->where('id',$id)->where('status','!=',0)->first();
        if($rows==null) {
            return redirect()->back()->with('error', 'Invalid Folowup Request');   
        }

        \DB::table('trans_followup_details')->where('trans_followup_id',$id)->update(['status'=>0]);
        \DB::table('trans_followup')->where('id',$id)->update(['status'=>0]);
        return redirect()->back()->with('success', 'Followup removed successfully');   
    }

    public function view_followups($id) {
        $rows = \DB::table('trans_followup')->where('id',$id)->where('status','!=',0)->first();
        if($rows==null) {
            return redirect()->back()->with('error', 'Invalid Folowup Request');   
        }
        $data['id']  = $id;
        $data['row'] = $rows;

        $trans_followup_details = \DB::table('trans_followup_details')->where('trans_followup_id',$id)->where('status','!=',0)->get();
        $data['trans_followup_details'] = $trans_followup_details;
        return view('followup.view',$data);       
    }
}
