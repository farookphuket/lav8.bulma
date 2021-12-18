<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;


use DB;

class RegisterController extends Controller
{

    protected $confirm_table = "personal_access_tokens";
    protected $reset_user_table = "password_resets";
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            "name" => ["required","unique:users,name"],
            "email" => ["required","email","unique:users,email"],
            "password" => ["required","min:4"]
        ]);

        $passwd = Hash::make(request()->password);
        $valid["password"] = $passwd;
        // create user 
        User::create($valid);

        $user = User::latest()->first();
        //create user token 
        $token = $user->createToken('auth_token')->plainTextToken;
        $token_type = "Bearer";

        // make role default to member 
        $user->role()->attach(2);

        //sent email to this user 
        $this->sentUserConfirm();

        $msg = "<span class=\"tag is-medium is-success\">
           Success : user has been created! 
            <span>";
        return response()->json([
            "msg" => $msg,
            "token" => $token
        ]);
    }





    public function sentUserConfirm(){

        $get = User::where("email",request()->email)->first();

        $str = Str::random(60);  
        $link = URL::to("/userHasConfirmed/{$str}"); 
        $website = request()->getHttpHost();

        // --- add data 
        DB::table($this->reset_user_table)->insert([
            "email" => $get->email,
            "token" => $str,
            "created_at" => now()
        ]);
        $data = array(
            "name" => $get['name'],
            "title" => 'Please DO-NOT-REPLY!',
            "link" => $link,
            "website" => $website
        );
        Mail::send('mail.user-confirmation-email',$data,function($msg) use ($get){
            $msg->from('no-reply@'.request()->getHttpHost());
            $msg->to($get['email'],'no-reply-back')->subject("Dear 
            {$get['name']} thank you for join us!
            ");
        });
    }

    public function userHasConfirmed($token){

        $get = DB::table($this->reset_user_table)
                ->whereDate('created_at',date("Y-m-d"))
                ->where("token",$token)->first();
        if(isset($get->email)):
            // update email confirm for this user 
            User::where("email",$get->email)
            ->update([
                "email_verified_at" => now()
            ]);

            

            $url = '/user-has-confirmed';
            // make a backup for this new user 
            $u = User::where('email',$get->email)
                        ->first();
            User::backupUser($u->id,'insert');

        else:

            $url = '/user-confirmation-fail';
        endif;

        // then load the response page for the user
        return redirect($url);
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
    public function destroy(User $user)
    {
        //
    }
}
