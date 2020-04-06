<?php

namespace App\Http\Controllers;

use App\Log;
use DB;
use App\Antrian;
use http\Env\Response;
use Illuminate\Http\Request;

class AntrianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index_navigator()
    {
        date_default_timezone_set('Asia/Jakarta');
        $antrian = DB::table('antrians')->orderBy('nomor_antrian','DESC')->first();
        $log = DB::table('logs')->orderBy('id','DESC')->first();

        return view('app.menu.navigator.index')->with('antrian', $antrian)->with('log',$log);
    }

    public function index_ambassador()
    {
        date_default_timezone_set('Asia/Jakarta');
        $antrian = DB::table('antrians')->orderBy('nomor_antrian','ASC')->first();


        return view('app.menu.ambassador.index')->with('antrian', $antrian);
    }

    public function current_user(Request $request)
    {
        $current = DB::table('antrians')
            ->where('serving',1)
            ->where('ambassador',$request->ambassador)
            ->count();

        if($current >= 1){
            $current2 = DB::table('antrians')
                ->where('serving',1)
                ->where('ambassador',$request->ambassador)
                ->first();
            return response()->json($current2,201);
        }


    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return void
     */
    public function create(Request $request)
    {
        date_default_timezone_set('Asia/Jakarta');
        $antrian = DB::table('antrians')
            ->where('dipanggil','00:00:00')
            ->orderBy('nomor_antrian','ASC')->first();

        $antrian2 = DB::table('antrians')
                    ->where('nomor_antrian',$antrian->nomor_antrian)
                    ->where('dipanggil','00:00:00')
                    ->update(['dipanggil' => date('H:i:s'), 'ambassador'=> $request->ambassador, 'serving'=>1]);

        return response()->json($antrian, 201);

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
        if($request->action == "add") {
            $antrian = Antrian::create([
                'nomor_antrian' => $request->antrian,
                'issued' => date('H:i:s'),
                'nama'      => $request->nama,
                'keluhan'   => $request->keluhan,
                'msisdn_1'  => $request->msisdn1,
                'msisdn_2'  => $request->msisdn2,
                'msisdn_3'  => $request->msisdn3,
                'navigator' => $request->navigator,
            ]);
        }

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        //insert data ke log, hapus data di tabel antrian

       $log =  $request->nomor_antrian;
        date_default_timezone_set('Asia/Jakarta');

       $antrian = DB::table('antrians')->where('nomor_antrian',$log)->first();

        $logs = Log::create([
            'nomor_antrian' => $antrian->nomor_antrian,
            'nama'      => $antrian->nama,
            'keluhan'   => $antrian->keluhan,
            'msisdn_1'  => $antrian->msisdn_1,
            'msisdn_2'  => $antrian->msisdn_2,
            'msisdn_3'  => $antrian->msisdn_3,
            'navigator' => $antrian->navigator,
            'ambassador' =>$antrian->ambassador,
            'issued' =>$antrian->issued,
            'dipanggil' => $antrian->dipanggil,
            'selesai' => date('H:i:s')
        ]);

    $delete = Antrian::find($antrian->id);
    $delete->delete();

    }

    public function skip(Request $request)
    {
        $log =  $request->nomor_antrian;
        date_default_timezone_set('Asia/Jakarta');

        $antrian = DB::table('antrians')->where('nomor_antrian',$log)->first();

        $logs = Log::create([
            'nomor_antrian' => $antrian->nomor_antrian,
            'nama'      => $antrian->nama,
            'issued' => $antrian->issued,
            'keluhan'   => $antrian->keluhan,
            'msisdn_1'  => $antrian->msisdn_1,
            'msisdn_2'  => $antrian->msisdn_2,
            'msisdn_3'  => $antrian->msisdn_3,
            'navigator' => $antrian->navigator,
            'ambassador' =>$antrian->ambassador,
            'dipanggil' => $antrian->dipanggil,
            'keterangan' => $request->keterangan
        ]);

        $delete = Antrian::find($antrian->id);
        $delete->delete();
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
