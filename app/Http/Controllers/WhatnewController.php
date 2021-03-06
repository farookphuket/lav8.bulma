<?php

namespace App\Http\Controllers;

use App\Models\Whatnew;
use Illuminate\Http\Request;

use Auth;

class WhatnewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Auth::user();
    }


    public function getWhatnew(){
        $wn = Whatnew::with('user')
                        ->where('is_public',"!=",0)
                        ->orderBy("created_at","DESC")
                        ->paginate(4);

        $meta_title = Whatnew::where('is_public','!=',0)
                                ->latest()
                                ->first();

        return response()->json([
            "whatnew" => $wn,
            "meta_title" => $meta_title->wn_title
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
            "wn_title" => ["required","min:8"],
            "wn_body" => ["required","min:40"]
        ],[
            "wn_title.required" => "Error! title is required minimum is 8 letters!",
            "wn_body.required" => "Error! body text is required minimum is 40 letters!",
        ]);


        $is_public = !request()->is_public?0:1;

        $valid["wn_title"] = xx_clean(request()->wn_title);
        $valid["wn_body"] = xx_clean(request()->wn_body);
        $valid["is_public"] = $is_public;
        $valid["user_id"] = Auth::user()->id;

        // create whatnew
        Whatnew::create($valid);

        // get the last row for backup
        $wn = Whatnew::latest()->first();

        // make a backup 
        Whatnew::backupWhatnew($wn->id,"insert");


        $msg = "<span class=\"tag is-medium is-success\">
            Success : data has been created</span>";
        
        return response()->json([
            "msg" => $msg
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Whatnew  $whatnew
     * @return \Illuminate\Http\Response
     */
    public function show(Whatnew $whatnew)
    {
        $wn = Whatnew::where('id',$whatnew->id)
                        ->with('user')
                        ->first();


        return response()->json([
            "whatnew" => $wn
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Whatnew  $whatnew
     * @return \Illuminate\Http\Response
     */
    public function edit(Whatnew $whatnew)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Whatnew  $whatnew
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {

        $valid = request()->validate([
            "wn_title" => ["required","min:8"],
            "wn_body" => ["required","min:40"]
        ],[
            "wn_title.required" => "Error! title is required minimum is 8 letters!",
            "wn_body.required" => "Error! body text is required minimum is 40 letters!",
        ]);


        $is_public = !request()->is_public?0:1;

        $valid["wn_title"] = xx_clean(request()->wn_title);
        $valid["wn_body"] = xx_clean(request()->wn_body);
        $valid["is_public"] = $is_public;
        $valid["updated_at"] = now();

        // update data 
        Whatnew::where("id",$id)
                    ->update($valid);

        // back up 
        Whatnew::backupWhatnew($id,"edit");


        $msg = "<span class=\"tag is-medium is-success\">
            Success : item id {$id} has been updated</span>";
        
        return response()->json([
            "msg" => $msg
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Whatnew  $whatnew
     * @return \Illuminate\Http\Response
     */
    public function destroy(Whatnew $whatnew)
    {
        $wn = Whatnew::find($whatnew->id);

        // make backup 
        Whatnew::backupWhatnew($whatnew->id);

        // delete 
        $wn->delete();


        $msg = "<span class=\"tag is-medium is-success\">
                Success : The item id {$wn->id} has been deleted!</span>";
        return response()->json([
            "msg" => $msg
        ]);
    }
}
