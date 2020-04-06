<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;


use DB;
use App\Revenue;


class RevenueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($username)
    {
        //

        $revenue = DB::table('revenues')
            ->where('username',$username)
            ->whereDate('created_at', Carbon::Today())
            ->orderBy('id','DESC')
            ->get();

        $join = DB::table('revenues')
        ->join('users','users.username','=','revenues.username')
        ->select('revenues.created_at as created','revenues.nama as nigga','revenues.msisdn as msisdn','revenues.reason as reason','users.name as nama','revenues.revenue','revenues.notes as notes')
            ->where('revenues.username',$username)
            ->whereDate('revenues.created_at', Carbon::Today())
            ->get();


        $data = array();
        $data['revenues'] = $revenue;
        $data['join'] = $join;


        return view('app.menu.revenue.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
            $report = DB::table('revenues')
                ->where('username', $request->username)
                ->whereYear('created_at','=',$request->tahun)
                ->whereMonth('created_at','=',$request->bulan)
                ->get();

        $join2 = DB::table('revenues')
            ->join('users','users.username','=','revenues.username')
            ->select('revenues.created_at as created','revenues.nama as nigga','revenues.msisdn as msisdn','revenues.reason as reason','users.name as nama','revenues.revenue','revenues.notes as notes')
            ->where('revenues.username',$request->username)
            ->whereYear('revenues.created_at','=',$request->tahun)
            ->whereMonth('revenues.created_at','=',$request->bulan)
            ->get();



            return response()->json($join2);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        if($request->msisdn[0] == '0' ){
            $cut = ltrim($request->msisdn,$request->msisdn[0]);
            $finish=substr_replace($cut,'62',0,0);

            $revenue = Revenue::create([
                'nama'      => $request->nama,
                'msisdn'    => $finish,
                'reason'    => $request->reason,
                'revenue'   => $request->revenue,
                'username'  => $request->username,
                'notes' =>$request->notes
            ]);

            return redirect()->back();

        } else if ($request->msisdn[0] == '8'){
            $finish=substr_replace($request->msisdn,'62',0,0);

            $revenue = Revenue::create([
                'nama'      => $request->nama,
                'msisdn'    => $finish,
                'reason'    => $request->reason,
                'revenue'   => $request->revenue,
                'username'  => $request->username,
                'notes' =>$request->notes
            ]);
            return redirect()->back();
        }else if($request->msisdn[0] == '6'){
            $revenue = Revenue::create([
                'nama'      => $request->nama,
                'msisdn'    => $request->msisdn,
                'reason'    => $request->reason,
                'revenue'   => $request->revenue,
                'username'  => $request->username,
                'notes' =>$request->notes
            ]);
            return redirect()->back();
        }


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($username)
    {
        date_default_timezone_set('Asia/Jakarta');
        $join = DB::table('revenues')
            ->join('users','users.username','=','revenues.username')
            ->select('revenues.created_at as created','revenues.nama as nigga','revenues.msisdn as msisdn','revenues.reason as reason','users.name as nama','revenues.revenue','revenues.notes as notes')
            ->where('revenues.username',$username)
            ->get();

        $sum_revenue = DB::table('revenues')
            ->where('username',$username)
            ->whereMonth('created_at', date('m'))
            ->get('revenue');

        $today_sum_revenue = DB::table('revenues')
            ->where('username',$username)
            ->whereDate('created_at', Carbon::Today())
            ->get('revenue');

        $total = $sum_revenue->sum('revenue');
        $today = $today_sum_revenue->sum('revenue');
        $count = $sum_revenue->count();
        $today_count = $today_sum_revenue->count();

        $first_day = date('01-m-Y');
        $last_day = date('Y-m-t');

        $start = new \DateTime($first_day);
        $end = new \DateTime($last_day);
// otherwise the  end date is excluded (bug?)
        $end->modify('+1 day');

        $interval = $end->diff($start);

// total days
        $days = $interval->days;

// create an iterateable period of date (P1D equates to 1 day)
        $period = new \DatePeriod($start, new \DateInterval('P1D'), $end);

// best stored as array, so you can add more than one
        $holidays = array();

        foreach($period as $dt) {
            $curr = $dt->format('D');

            // substract if Saturday or Sunday
            if ( $curr == 'Sun') {
                $days--;
            }

            // (optional) for the updated question
            elseif (in_array($dt->format('Y-m-d'), $holidays)) {
                $days--;
            }
        }



        // pemisah kontol

        $first_day2 = date('01-m-Y');
        $last_day2 = Carbon::Today();

        $start2 = new \DateTime($first_day2);
        $end2 = new \DateTime($last_day2);
// otherwise the  end date is excluded (bug?)
        $end2->modify('+1 day');

        $interval2 = $end2->diff($start2);

// total days
        $days2 = $interval2->days;

// create an iterateable period of date (P1D equates to 1 day)
        $period2 = new \DatePeriod($start, new \DateInterval('P1D'), $end2);

// best stored as array, so you can add more than one
        $holidays2 = array();

        foreach($period2 as $dt2) {
            $curr2 = $dt2->format('D');

            // substract if Saturday or Sunday
            if ( $curr2 == 'Sun') {
                $days2--;
            }

            // (optional) for the updated question
            elseif (in_array($dt2->format('Y-m-d'), $holidays2)) {
                $days2--;
            }
        }





        $outlook = $total/$days2*$days;



        $data = array();
        $data['revenues'] = $join;
        $data['total'] = $total;
        $data['count'] = $count;
        $data['today'] = $today;
        $data['count2'] = $today_count;
        $data['outlook'] = $outlook;



        return view('app.menu.revenue.report', compact('data'));
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
