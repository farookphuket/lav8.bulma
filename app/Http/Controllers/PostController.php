<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Tag;
use App\Models\Template;
use App\Models\Category;

use Illuminate\Http\Request;

use Auth;

class PostController extends Controller
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

    public function getPost(){
        // return json data 
        $po = Post::where("p_is_public","!=",0)
                    ->where('p_title','!=','about')
                    ->with('user')
                    ->with('tag')
                    ->with('category')
                    ->with('read')
                    ->orderBy('created_at','DESC')
                    ->paginate(15);

        $cat_with_post = Post::has('category')
                                ->where('p_title','!=','about')
                                ->where('p_is_public','!=',0)
                                ->with('category')
                                ->latest()
                                ->paginate(15);
        $cp = Category::has('post')
                        ->with('post')
                        ->get();

        $ta = Tag::has('post')
                    ->with('post')
                    ->get();

        $t = Post::where("p_is_public","!=",0)
                    ->where('p_title','!=','about')
                    ->latest()
                    ->first();
        $meta_title = $t->p_title;

        return response()->json([
            "post" => $po,
            "post_with_category" => $cat_with_post,
            "meta_title" => $meta_title,
            "cp" => $cp,
            "ta" => $ta
        ]);
    }

    public function postByTag(){
        /*
         * code from https://dev.to/othmane_nemli/laravel-wherehas-and-with-550o 
         * on 11 Dec 2021
         * */
        $ta = Tag::with(['post' =>fn($query) => 
            $query->where('p_is_public','!=',0)
            ->where('p_title','!=','about')
            ])
            ->where('id',request()->tag_id)
            ->paginate(6);
        return response()->json([
            "ta" => $ta
        ]);
    }

    public function postByCat(){
        $ca = Category::where("id",request()->cat_id)
            ->with(["post" => fn($query) => 
            $query->where("p_is_public","!=",0)
            ->where("p_title","!=","about")
            ])
                ->paginate(5);


        return response()->json([
            "category" => $ca
        ]);
    }

    public function getAbout(){
        $ab = Post::where('p_title','about')
                        ->first();

        return response()->json([
            "about" => $ab
        ]);
    }

    public function mGetPost(){
        $p = Post::where('p_is_public','!=',0)
                    ->where('p_title','!=','about')
                    ->orWhere('user_id',Auth::user()->id)
                    ->with('tag')
                    ->with('user')
                    ->with('read')
                    ->with('category')
                    ->latest()
                    ->paginate(8);


        $cat_with_post = Post::where("p_is_public","!=",0)
                                ->where('p_title','!=','about')
                                ->orWhere("user_id",Auth::user()->id)
                                ->has('category')
                                ->with('category')
                                ->latest()
                                ->get();

        $cp = Category::has('post')
                        ->with('post')
                        ->get();

        $ta = Tag::has('post')
                    ->with('post')
                    ->get();

        $t = Post::where('p_is_public','!=',0)
                    ->where('p_title','!=','about')
                    ->orWhere("user_id",Auth::user()->id)
                    ->latest()
                    ->first();
        $tem = Template::with('user')
                    ->where("t_method","post")
                    ->where("is_default_template","!=",0)
                    ->orWhere("user_id",Auth::user()->id)
                    ->get();

        return response()->json([
            "post" => $p,
            "meta_title" => $t->p_title,
            "post_with_category" => $cat_with_post,
            "cp" => $cp,
            "ta" => $ta,
            "template" => $tem
        ]);
    }

    public function aGetPost(){

        $post = Post::with('user')
                    ->with('tag')
                    ->orderBy('created_at','DESC')
                    ->paginate(8);
        $tm = Template::all();
        // return json data
        return response()->json([
            "post" => $post,
            "template" => $tm
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
        $valid = request()->validate([
            "p_title" => ["required","min:8","string","max:80"],
            "p_excerpt" => ["required","min:40"],
        ],
        [
            "p_title.required" => "Error! the title is required min 8 max 80 
            characters please",
        ] 
        );

        // prepare data 
        $valid["user_id"] = Auth::user()->id;
        $valid["p_is_public"] = !request()->p_is_public?0:1;
        $valid["p_title"] = xx_clean(request()->p_title);

        // just to make sure there will be no - at the end of field
        $valid["slug"] = rtrim(request()->slug,"-"); 
        
        $valid["p_excerpt"] = xx_clean(request()->p_excerpt);
        $valid["p_body"] = xx_clean(request()->p_body);
        
        // create post 
        Post::create($valid);

        // get the last row 
        $p = Post::latest()->first();

        // create tag link
        $tags = request()->tags;
        $p->tag()->attach($tags);

        // category 
        $cat = request()->category;
        $p->category()->attach($cat);

        // make a backup 
        Post::backupPost($p->id,"insert");


        $msg = "<span class=\"tag is-medium is-success\">
            Success : your post has been created!</span>";
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
        $po = Post::with('user')
                    ->with("tag")
                    ->with("category")
                    ->with('read')
                    ->where("slug",$post->slug)
                    ->first();

        Post::postHasRead($po->id);

        return response()->json([
            "post" => $po
        ]);
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
        //
        $valid = request()->validate([
            "p_title" => ["required","min:8","string","max:80"],
            "p_excerpt" => ["required","min:40"],
        ],
        [
            "p_title.required" => "Error! the title is required min 8 max 80 
            characters please",
        ] 
        );

        // prepare data 
        $valid["p_is_public"] = !request()->p_is_public?0:1;
        $valid["p_title"] = xx_clean(request()->p_title);

        // just to make sure there will be no - at the end of field
        $valid["slug"] = rtrim(request()->slug,"-"); 
        
        $valid["p_excerpt"] = xx_clean(request()->p_excerpt);
        $valid["p_body"] = xx_clean(request()->p_body);
        
        // create post 
        Post::where("id",$post->id)
            ->update($valid);

        // get the last row 
        $p = Post::find($post->id);

        // create tag link
        $tags = request()->tags;
        $p->tag()->sync($tags);


        // category 
        $cat = request()->category;
        $p->category()->sync($cat);

        // make a backup 
        Post::backupPost($p->id,"edit");


        $msg = "<span class=\"tag is-medium is-success\">
            Success : your post id {$post->id} has been updated!</span>";
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
        //
        $p = Post::find($post->id);

        //unlink tag
        $p->tag()->detach();

        $p->delete();

        $msg = "<span class=\"tag is-medium is-success\">
            Success : your post id {$post->id} has been deleted!</span>";
        return response()->json([
            "msg" => $msg
        ]);
    }
}
