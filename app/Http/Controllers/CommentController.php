<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\Reply;
use App\Models\User;
use Illuminate\Http\Request;

use Auth;
use DB;

class CommentController extends Controller
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


    public function getPostComment(){
        $post = Post::find(request()->post_id);

        $cm = $post->comment()
                   ->with(["reply" => fn($q) => $q
                   ->with("user") 
                   ->latest()])
                ->with("user")
                ->paginate(2);


        return response()->json([
            "comment" => $cm,

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
            "c_title" => ["required"],
            "c_body" => ["required"]
        ],
        [
            "c_title.required" => "Error! the Title is required ,min 18 , max 80"
        ]);

        $post_id = request()->post_id;

        $valid["user_id"] = Auth::user()->id;
        $valid["c_title"] = xx_clean(request()->c_title);
        $valid["c_body"] = xx_clean(request()->c_body);

        // create the comment
        Comment::create($valid);

        // get the last insert row
        $cm = Comment::latest()->first();

        // link the post and comment 
        $cm->post()->attach($post_id);

        $msg = "<span class=\"tag is-medium is-success\">
            Success : your comment {$post_id} has been created!</span>";
        return response()->json([
            "msg" => $msg
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function edit(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Comment  $comment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Comment $comment)
    {
        //
    }
}
