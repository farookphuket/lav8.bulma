<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Auth;

class AboutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ab = Post::where('p_title','about')
                        ->first();
        return response()->json([
            "about" => $ab
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
            "p_title" => ["required","unique:posts,p_title"],
            "p_body" => ["required","min:50"]
        ],
        [
            "p_body.required" => "Error! the Body text cannot be empty!!",
            "p_title.unique" => "Error ! please click the Edit or Delete button!"
        ]);


        $valid["user_id"] = Auth::user()->id;
        $valid["slug"] = 'about';
        $valid["p_title"] = 'about';
        $valid["p_is_public"] = 1;
        $valid["p_excerpt"] = xx_clean(request()->p_body);
        $valid["p_body"] = xx_clean(request()->p_body);

        Post::create($valid);

        $po = Post::latest()->first();
        Post::backupPost($po->id,"insert");

        $msg = "<span class=\"tag is-medium is-success\">
            Success : About has been save";
        return response()->json([
            "msg" => $msg
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Post $post)
    {
        $valid = request()->validate([
            "p_title" => ["required"],
            "p_body" => ["required","min:50"]
        ],
        [
            "p_body.required" => "Error! the Body text cannot be empty!!"
        ]);


        $valid["p_excerpt"] = xx_clean(request()->p_body);
        $valid["p_body"] = xx_clean(request()->p_body);

        Post::where("id",$post->id)
            ->update($valid);

        $po = Post::find($post->id);
        Post::backupPost($po->id,"edit");

        $msg = "<span class=\"tag is-medium is-success\">
            Success : About has been Updated";
        return response()->json([
            "msg" => $msg
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $po = Post::find($post->id);
        $po->delete();

        $msg = "<span class=\"tag is-medium is-success\">
            Success : About has been deleted";
        return response()->json([
            "msg" => $msg
        ]);
    }
}
