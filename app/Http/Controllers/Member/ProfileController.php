<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!Auth::user()):

            return redirect('/');
            exit;
        endif;
        
            return Auth::user();
    }

    public function checkConfirmKey(){
        $key = request()->conf_pass;
        $valid = request()->validate([
            "conf_pass" => ["required"]
        ]);

        $user = User::where("id",Auth::user()->id)
                        ->first();
        $msg = "";
        $error = 0;
        $nkey = Hash::make($key);
        if(!Hash::check($key,Auth::user()->password)):


            $msg = "<span class=\"tag is-medium is-danger\">
            Error : Wrong password!</span>";
            $error = 1;
            else:

            $msg = "<span class=\"tag is-medium is-success\">
            Success : Confirmed</span>";
        endif;
         
        return response()->json([
            "msg" => $msg,
            "error" => $error
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show($user_id)
    {
        $u = User::find($user_id);
        $role = User::where('id',Auth::user()->id)
                    ->first()->role;
        return response()->json([
            "user" => $u,
            "role" => $role
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $u = User::find($id);
            
        $valid = request()->validate([
            "name" => ["required","unique:users,name,".Auth::user()->id],
            "email" => ["required","email","unique:users,email,".Auth::user()->id]
        ],
        [
            "name.unique" => "Error! cannot use this name",
            "email.unique" => "Error! cannot use this email",
        ] 
        );

        $msg = "";
        $pass = '';
        if(isset(request()->new_pass) && request()->new_pass != ''):
            $pass = Hash::make(request()->new_pass);
            $valid["password"] = $pass; 
        endif;
        
        // unset conf_pass 
        unset($valid["conf_pass"]);
        
        $valid["updated_at"] = now(); 
        // update user 
        User::where('id',Auth::user()->id)
            ->update($valid);

        $msg = "<span class=\"tag is-success\">
            Success : profile save.</span>";
        return response()->json([
            "msg" => $msg
        ]);
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}
