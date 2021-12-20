<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use App\Models\Post;
use App\Models\Comment;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class ReplyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function getCommentReply(){
        $comment = Comment::find(request()->comment_id);

        $rp = $comment->reply()
                        ->latest()
                        ->get();

        return response()->json([
            "reply" => $rp
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
            "r_title" => ["required"],
            "r_body" => ["required"]
        ],
        [
            "r_title.required" => "Error! the title is required",
            "r_body.required" => "Error! Content cannot be empty",
        ]);

        $post_id = request()->post_id;
        $comment_id = request()->comment_id;

        // prepare data 
//        $valid["comment_id"] = $comment_id;
        $valid["r_title"] = xx_clean(request()->r_title);
        $valid["r_body"] = xx_clean(request()->r_body);
        $valid["user_id"] = Auth::user()->id;
        // create reply 
        Reply::create($valid);

        // get reply 
        $re = Reply::latest()->first();
        $re->comment()->attach($comment_id);


        // get post link
        $po = Post::find($post_id);
        $re->post()->attach($po);

        // make a backup for reply 
        Reply::backupReply($re->id,"insert");

        $msg = "<span class=\"tag is-medium is-success\">
            Success : reply to {$post_id} save!</span>";
        return response()->json([
            "msg" => $msg
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function show(Reply $reply)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function edit(Reply $reply)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Reply $reply)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Reply  $reply
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reply $reply)
    {
        //
    }
}
