<?php

namespace App\Http\Controllers;

use DB;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function issuedindex()
    {
        $issued = DB::table('logs')
            ->whereDate('created_at',Carbon::today())
            ->get();

        return view('app.menu.monitoring.issued')->with('issued',$issued);
    }

    public function waitingindex()
    {
        $waiting = DB::table('antrians')
            ->where('serving',0)
            ->get();

        return view('app.menu.monitoring.waiting')->with('waiting',$waiting);
    }

    public function servingindex()
    {
        $serving = DB::table('antrians')
            ->where('serving',1)
            ->get();

        return view('app.menu.monitoring.serving')->with('serving',$serving);
    }

    public function servedindex()
    {
        $served = DB::table('logs')
            ->where('selesai','!=','00:00:00')
            ->whereDate('created_at',Carbon::today())
            ->orderBy('nomor_antrian','DESC')
            ->get();

        return view('app.menu.monitoring.served')->with('served',$served);
    }

    public function unservedindex()
    {
        $unserved = DB::table('logs')
            ->where('selesai','00:00:00')
            ->whereDate('created_at',Carbon::today())
            ->get();

        return view('app.menu.monitoring.unserved')->with('unserved',$unserved);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
