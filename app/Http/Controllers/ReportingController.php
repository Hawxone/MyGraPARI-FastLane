<?php

namespace App\Http\Controllers;
use App\Exports\UsersExport;
use App\Exports\UnservedExport;
use Maatwebsite\Excel\Facades\Excel;
use DB;
use Illuminate\Http\Request;

class ReportingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('app.menu.reporting.index');
    }

    public function unservedindex()
    {
        return view('app.menu.reporting.unserved');
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
        $waiting = DB::table('antrians')
            ->where('serving',0)
            ->get();
        return response()->json($waiting);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        if($request->date2 == $request->date1){
            $report = DB::table('logs')
                ->where('selesai','!=','00:00:00')
                ->whereDate('created_at',$request->date1)
                ->get();
            return response()->json($report);
        }else{
            $report = DB::table('logs')
                ->where('selesai','!=','00:00:00')
                ->where('created_at','>=',$request->date1,'and','created_at','<',$request->date2)
                ->get();
            return response()->json($report);
        }



    }

    public function export(Request $request)
    {
        return (new UsersExport($request->date,$request->date2))->download('served.xlsx');
    }

    public function exportunserved(Request $request)
    {
        return (new UnservedExport($request->date,$request->date2))->download('unserved.xlsx');
    }

    public function showunserved(Request $request)
    {
        if($request->date1 == $request->date2){
            $report = DB::table('logs')
                ->where('selesai','00:00:00')
                ->whereDate('created_at',$request->date1)
                ->get();
            return response()->json($report);
        } else{
            $report = DB::table('logs')
                ->where('selesai','00:00:00')
                ->where('created_at','>=',$request->date1,'and','created_at','<=',$request->date2)
                ->get();
            return response()->json($report);
        }

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
