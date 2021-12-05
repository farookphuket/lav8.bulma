<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

use Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!Auth::user()->is_admin):
            exit;
        endif;
        return Auth::user();
    }


    public function getUser(){
        $u = User::with('role')
                    ->latest()
                    ->paginate(4);

        $role = Role::all();

        return response()->json([
            "user" => $u,
            "role" => $role
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
    public function store()
    {
        $valid = request()->validate([
            "name" => ["required","min:4"],
            "email" => ["required","email"],
            "password" => ["required","min:4"]
        ]);


        // unset user_roles from valid 
        unset($valid["user_roles"]);

        $user_roles = request()->user_roles;
        // password 
        $valid["password"] = Hash::make(request()->password);
        $valid["email_verified_at"] = now();

        // create user 
        User::create($valid);

        // save user role 
        $u = User::latest()->first();
        $u->role()->attach($user_roles);

        // backup 
        User::backupUser($u->id,"insert");

        $msg = "<span class=\"tag is-success is-medium\">
            Success : user has been created!</span>";
        return response()->json([
            "msg" => $msg
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $u = User::with('role')
                    ->where('id',$user->id)
                    ->first();
        return response()->json([
            "user" => $u
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
    public function update(User $user)
    {
        //
        $u = User::find($user->id);

        $user_roles = request()->user_roles;

        $valid = request()->validate([
            "name" => ["required","min:4"],
            "email" => ["required","email"]
        ]);

        $valid["updated_at"] = now();

        // create user 
        User::where('id',$user->id)
                    ->update($valid);

        // update user role 
        $u->role()->sync($user_roles);

        // backup 
        User::backupUser($u->id,"insert");


        $msg = "<span class=\"tag is-medium is-success\">
            Success : user id {$user->id} has been updated!</span>";
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
        $u = User::with('role')->find($user->id);
        $u->role()->detach();
        $u->delete();


        $msg = "<span class=\"tag is-medium is-success\">
            Success : user id {$user->id} has been deleted!</span>";
        return response()->json([
            "msg" => $msg
        ]);
    }
}
