<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;

use Auth;
use DB;

class LoginController extends Controller
{
    protected $user_token_table = 'personal_access_tokens';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function checkPassSport(){
        $user = Auth::check();
        $user_has_confirm_email = false;
        if($user):
            $user_has_confirm_email = User::where('id',Auth::user()->id)
                                ->where('email_verified_at','!=',null)
                                ->first();
        endif;
        return response()->json([
            "user" => $user,
            "user_has_confirm_email" => $user_has_confirm_email
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
            "email" => ["required","email"],
            "password" => ["required"]
        ]);

        $msg = '';
        $url = '';
        $error = false;
        $token = '';

        //check user 
        if(!Auth::attempt($valid)):
            
            $msg = "<span class=\"tag is-medium is-danger\">
                Sorry! account not found!
            </span>";
            $error = true;
            $url = '/login';
        else:
            $role = User::where('id',Auth::user()->id)
                ->first()
                ->role;
            
            if(Auth::user()->is_admin == 1):
                $url = '/admin/home';
            else:
                $url = '/member/home';
            endif;
            $name = Auth::user()->name;
            $msg = "<span class=\"tag is-medium is-success\">
                Welcome {$name}
            </span>";
            $token = Auth::user()->createToken('auth_token')->plainTextToken;
        endif;

        
        return response()->json([
            "msg" => $msg,
            "role" => $role,
            'url' => $url,
            'error' => $error,
            'token' => $token
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
        //
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
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        $u_token = DB::table($this->user_token_table)
            ->where('tokenable_id',Auth::user()->id)
            ->get();
        foreach($u_token as $arr):
            DB::table($this->user_token_table)
                ->delete($arr->id);
        endforeach;
        request()->session()->flush();
        $url = '/login';
        return response()->json([
            'url' => $url
        ]);
    }
}
