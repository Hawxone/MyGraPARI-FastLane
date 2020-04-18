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
    public function revenue()
    {
        date_default_timezone_set('Asia/Jakarta');
        $sum_revenue = DB::table('revenues')
            ->select(DB::raw("EXTRACT(day from created_at ) as date"),DB::raw('sum(revenue) as sum'))
            ->groupBy(DB::raw("EXTRACT(day from created_at )"))
            ->whereMonth('created_at', date('m'))
            ->get();

        $first_day = date('01-m-Y');
        $last_day = date('Y-m-t');

        foreach ($sum_revenue as $row ){
            $int[] = (int)$row->date;
        }

        $start = new \DateTime($first_day);
        $end = new \DateTime($last_day);

        $interval = $end->diff($start);
        $days = $interval->days+2;
        $array = array();
        $i = 1;
        $x = 0;
        while($i < $days){
            if( in_array($i, $int)){

                array_push($array,['date'=>$sum_revenue[$x]->date,'sum'=>$sum_revenue[$x]->sum]);
                $x++;
            }else{
                array_push($array,['date'=>$i,'sum'=>0]);
            }
            $i++;
        }

        return response()->json($array);

    }

    public function revenue2()
    {
        $sum_revenue = DB::table('revenues')
            ->select('reason',DB::raw('count(reason) as re'))
            ->groupBy('reason')
            ->whereMonth('created_at', date('m'))
            ->get();

        return response()->json($sum_revenue);

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
