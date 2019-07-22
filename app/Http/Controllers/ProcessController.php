<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Phpml\Classification\NaiveBayes;

class ProcessController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pages.process');
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

    public function testing(Request $request)
    {
        $kesukaran = strtolower($request->input('kesukaran'));
        $pembeda = strtolower($request->input('pembeda'));

        $samples = [
            ['diterima', 'diterima'], ['diterima', 'direvisi'], ['diterima', 'ditolak'],
            ['direvisi', 'diterima'], ['direvisi', 'direvisi'], ['direvisi', 'ditolak'],
            ['ditolak', 'diterima'], ['ditolak', 'direvisi'], ['ditolak', 'ditolak']
        ];
        $labels = [
            'diterima', 'direvisi', 'ditolak',
            'direvisi', 'direvisi', 'ditolak',
            'ditolak', 'ditolak', 'ditolak'
        ];

        $classifier = new NaiveBayes();
        $classifier->train($samples, $labels);
        $output = $classifier->predict([$kesukaran, $pembeda]);

        return redirect('/process')->with('output', $output)->with('input', ['kesukaran' => $kesukaran, 'pembeda' => $pembeda]);
    }
}
