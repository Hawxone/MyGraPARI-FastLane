<?php

namespace App\Http\Controllers;

use DB;
use App\Log;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MonitorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        date_default_timezone_set('Asia/Jakarta');

        $issued = DB::table('logs')
            ->whereDate('created_at',Carbon::today())
            ->get();

        $issued_waiting = DB::table('antrians')
            ->get();
        $iw = $issued_waiting->count();
        $count = $issued->count();
        $it = $iw + $count;

        $waiting = DB::table('antrians')
            ->where('dipanggil','00:00:00')
            ->where('serving',0)
            ->get();
        $waiting_count = $waiting->count();

        $serving = DB::table('antrians')
            ->where('serving',1)
            ->get();
        $serving_count = $serving->count();

        $served = DB::table('logs')
            ->where('selesai','!=','00:00:00')
            ->whereDate('created_at',Carbon::today())
            ->get();
        $served_count = $served->count();

        $unserved = DB::table('logs')
            ->where('selesai','=','00:00:00')
            ->whereDate('created_at',Carbon::today())
            ->get();
        $unserved_count = $unserved->count();

        $time = DB::table('logs')
            ->selectRaw('avg(selesai - dipanggil) as interval')
            ->where('selesai','!=','00:00:00')
            ->whereDate('created_at',Carbon::today())
            ->pluck('interval');

        $clean_time = substr( $time,2,-2);

        $wt = DB::table('logs')
            ->selectRaw('avg(dipanggil-issued) as interval')
            ->where('selesai','!=','00:00:00')
            ->whereDate('created_at',Carbon::today())
            ->pluck('interval');

        $clean_wt = substr($wt,2,-2);

        $data = array();
        $data['issued'] = $it;
        $data['waiting'] = $waiting_count;
        $data['serving'] = $serving_count;
        $data['served'] = $served_count;
        $data['unserved'] = $unserved_count;
        $data['time'] = $clean_time;
        $data['wt'] = $clean_wt;


        return view('app.menu.monitoring.index', compact('data'));
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
