<?php

namespace App\Http\Controllers;

use App\Libur;
use DB;
use Illuminate\Http\Request;

class LiburController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $libur = DB::table('liburs')
            ->get();

        return view('app.menu.libur.index')->with('libur',$libur);
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
        $libur = Libur::create([
            'date'      => $request->date,

        ]);

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Libur  $libur
     * @return \Illuminate\Http\Response
     */
    public function show(Libur $libur)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Libur  $libur
     * @return \Illuminate\Http\Response
     */
    public function edit(Libur $libur)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Libur  $libur
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Libur $libur)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Libur  $libur
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Libur::find($id)->delete();

        return redirect()->back();
    }
}
