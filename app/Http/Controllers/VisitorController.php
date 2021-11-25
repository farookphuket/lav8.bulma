<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use Illuminate\Http\Request;

class VisitorController extends Controller
{
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->isNewVisitor();

        $visited_today = $this->hasVisitedToday();
        $visit_this_month = $this->hasVisitedMonth();
        $visit_this_year = $this->hasVisitedYear();
        $visit_all_time = Visitor::all()->count();

        $msg =  ""; 
    }

    /* this method will check if the user this ip 
     * has been visit
     * */
    public function isNewVisitor(){
        
        $visit_today = Visitor::where('ip',getUserIp())
                            ->whereDate('visited_at',"=",date("Y-m-d"))     
                            ->orWhere('created_at',date("Y-m-d"))
                            ->first();

        $v_data = '';
        // not found create one
        if(!$visit_today || $visit_today == 0):
            $v_data = [
                "ip" => getUserIp(),
                "os" => getUserOs(),
                "browser" => getUserBrowser(),
                "device" => getUserDevice(),
                "visited_at" => now()
            ]; 
            Visitor::create($v_data);
            return true;
        endif;
        return false;
    }

    public function hasVisitedToday(){
        $get = Visitor::whereDate("created_at","=",date("Y-m-d"))
                        ->get();
        // return the number of row
        return count($get);
    }

    public function hasVisitedMonth(){
        $get = Visitor::whereDate("created_at","=",date("Y-m"))
                        ->get();
        // return the number of row
        return count($get);
    }

    public function hasVisitedYear(){
        $get = Visitor::whereDate("created_at","=",date("Y"))
                        ->get();
        // return the number of row
        return count($get);
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Visitor  $visitor
     * @return \Illuminate\Http\Response
     */
    public function show(Visitor $visitor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Visitor  $visitor
     * @return \Illuminate\Http\Response
     */
    public function edit(Visitor $visitor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Visitor  $visitor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Visitor $visitor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Visitor  $visitor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Visitor $visitor)
    {
        //
    }
}
