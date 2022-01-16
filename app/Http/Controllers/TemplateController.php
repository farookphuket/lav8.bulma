<?php

namespace App\Http\Controllers;

use App\Models\Template;
use Illuminate\Http\Request;

use Auth;

class TemplateController extends Controller
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

    public function getTemplate(){
        $tm = Template::with('user')
                ->orderBy('created_at','DESC')
                ->paginate(2);
        

        return response()->json([
            "template" => $tm
        ]);
    }

    public function mGetTemplate(){
        $tm = Template::with('user')
                ->where('is_default_template',"!=",0)
                ->orWhere("user_id",Auth::user()->id)
                ->get();
        return response()->json([
            "template" => $tm
        ]);
    }
    public function aGetTemplate(){

        $tm = Template::with('user')
                ->get();
        return response()->json([
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
    public function store()
    {
        $valid = request()->validate([
            "t_title" => ["required","min:8"],
            "t_method" => ["required"],
            "t_excerpt" => ["required"] 
        ],
        [
            "t_title.required" => "Error! title is required",
            "t_title.min" => "Error! title is must be greather than 8 chars",
        ]);

        // preparing data
        $valid["user_id"] = Auth::user()->id;
        $valid["t_title"] = xx_clean(request()->t_title);
        $valid["t_method"] = xx_clean(request()->t_method);
        $valid["t_excerpt"] = xx_clean(request()->t_excerpt);
        $valid["t_body"] = xx_clean(request()->t_body);

        // create template
        Template::create($valid);

        // get the last insert row
        $t = Template::latest()->first();

        // make a backup to file 
        Template::backupTemplate($t->id,"insert");

        $msg = "<span class=\"tag is-medium is-success\">
Success : Template has been created! </span>";
        return response()->json([
            "msg" => $msg
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Template  $template
     * @return \Illuminate\Http\Response
     */
    public function show(Template $template)
    {
        $tm = Template::with('user')
                    ->where('id',$template->id)
                    ->first();

        return response()->json([
            "template" => $tm
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Template  $template
     * @return \Illuminate\Http\Response
     */
    public function edit(Template $template)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Template  $template
     * @return \Illuminate\Http\Response
     */
    public function update(Template $template)
    {
        $tm = Template::find($template->id);

        $valid = request()->validate([
            "t_title" => ["required","min:8"]
        ],
        [
            "t_title.required" => "Error! title is required",
            "t_title.min" => "Error! title is must be greather than 8 chars",
        ]);

        // preparing data

        $valid["t_title"] = xx_clean(request()->t_title);
        $valid["t_method"] = xx_clean(request()->t_method);
        $valid["t_excerpt"] = xx_clean(request()->t_excerpt);
        $valid["t_body"] = xx_clean(request()->t_body);
        $valid["updated_at"] = now();

        // update template
        Template::where("id",$template->id)
                ->update($valid);


        // make a backup to file 
        Template::backupTemplate($tm->id,"edit");

        $msg = "<span class=\"tag is-medium is-success\">
Success : id {$template->id} has been updated! </span>";
        return response()->json([
            "msg" => $msg
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Template  $template
     * @return \Illuminate\Http\Response
     */
    public function destroy(Template $template)
    {
        $tm = Template::find($template->id);
        
        $tm->delete();

        $msg = "<span class=\"tag is-medium is-success\">
Success : id {$template->id} has been deleted! </span>";
        return response()->json([
            "msg" => $msg
        ]);
    }
}
