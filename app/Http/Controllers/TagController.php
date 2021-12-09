<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Post;
use Illuminate\Http\Request;
use Auth;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tag_all = Tag::all();
        $tag_with_post = Post::with('tag')
                                ->get();

        return response()->json([
            "tag_all" => $tag_all,
            "tag_with_post" => $tag_with_post
        ]);
    }

    public function getTag(){
        
        // since the non-login is read only 
        $tag_all = Tag::all();
        $tag_with_post = Post::with('tag')
                                ->get();

        return response()->json([
            "tag_all" => $tag_all,
            "tag_with_post" => $tag_with_post
        ]);
    }


    public function mGetTag(){
        // get by admin

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
        //
        $valid = request()->validate([
            "new_tag" => ["string","nullable","min:4","max:10","unique:tags,tag_name"]
        ],[
            "new_tag.string" => "Error! new Tag field allow text only!",
            "new_tag.unique" => "Error! This Tag has existed"
        ]);

        // prepare data 
        $valid["tag_name"] = request()->new_tag;

        // unset new_tag 
        unset($valid["new_tag"]);

        // created new tag 
        Tag::create($valid);

        // get the last tag 
        $ta = Tag::latest()->first();

        // make backup 
        Tag::backupTag($ta->id,"insert");

        // return response 
        $msg = "<span class=\"tag is-medium is-success\">
            Success : new tag has created</span>";
        return response()->json([
            "msg" => $msg
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $tag)
    {
        $ta = Tag::find($tag->id);

        return response()->json([
            "tag" => $ta
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function edit(Tag $tag)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(Tag $tag)
    {

        //
        $valid = request()->validate([
            "new_tag" => ["string","nullable","min:4","max:10","unique:tags,tag_name,".$tag->id]
        ],[
            "new_tag.string" => "Error! new Tag field allow text only!",
            "new_tag.unique" => "Error! This Tag has existed"
        ]);

        // prepare data 
        $valid["tag_name"] = request()->new_tag;

        // unset new_tag 
        unset($valid["new_tag"]);

        // created new tag 
        Tag::where("id",$tag->id)
            ->update($valid);

        // get the last tag 
        $ta = Tag::find($tag->id);

        // make backup 
        Tag::backupTag($ta->id,"edit");

        // return response 
        $msg = "<span class=\"tag is-medium is-success\">
            Success : tag id {$ta->id} has been updated</span>";
        return response()->json([
            "msg" => $msg
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        $ta = Tag::find($tag->id);
        $ta->delete();

        // return response 
        $msg = "<span class=\"tag is-medium is-success\">
            Success : tag id {$ta->id} has been deleted</span>";
        return response()->json([
            "msg" => $msg
        ]);
    }
}
