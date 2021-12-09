<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    
    }

    public function getCategory(){
        $c = Category::latest()->get();

        return response()->json([
            "category" => $c
        ]);
    }

    public function aGetCategory(){
        $c = Category::latest()
                        ->paginate(4);
        return response()->json([
            "category" => $c
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
            "cat_name" => ["required","min:4","max:15"]
        ],
        [
            "cat_name.required" => "Error! Category Name is Required!",
            "cat_name.max" => "Error! Category Name is too long!",
        ]);

        // lower case for method
        $valid["cat_method"] = rtrim(request()->cat_method,"-");
        // create category 
        Category::create($valid);

        // get the last row 
        $c = Category::latest()->first();

        Category::backupCategory($c->id,"insert"); 
        


        $msg = "<span class=\"tag is-medium is-success\">
            Success : category has created!</span>";

        return response()->json([
            "msg" => $msg
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        $ca = Category::find($category->id);

        return response()->json([
            "category" => $ca
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Category $category)
    {
        //
        $ca = Category::find($category->id);

        
        $valid = request()->validate([
            "cat_name" => ["required","min:4","max:15"]
        ],
        [
            "cat_name.required" => "Error! Category Name is Required!",
            "cat_name.max" => "Error! Category Name is too long!",
        ]);


        // lower case for method
        $valid["cat_method"] = rtrim(request()->cat_method,"-");
        $valid["updated_at"] = now();
        // update category 
        Category::where("id",$category->id)
                    ->update($valid);


        Category::backupCategory($ca->id,"edit"); 
        

        $msg = "<span class=\"tag is-medium is-success\">
            Success : category id '{$category->id}' has updated!</span>";

        return response()->json([
            "msg" => $msg
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //

        $msg = "<span class=\"tag is-medium is-success\">
            Success : category id '{$category->id}' has deleted!</span>";

        return response()->json([
            "msg" => $msg
        ]);
    }
}
