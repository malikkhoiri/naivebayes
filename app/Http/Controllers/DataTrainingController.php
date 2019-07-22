<?php

namespace App\Http\Controllers;

use App\DataTraining;
use App\Imports\DataTrainingImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;

class DataTrainingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = DataTraining::all();
        return view('pages.training', ['data' => $data]);
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
     * @param  \App\DataTraining  $dataTraining
     * @return \Illuminate\Http\Response
     */
    public function show(DataTraining $dataTraining)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DataTraining  $dataTraining
     * @return \Illuminate\Http\Response
     */
    public function edit(DataTraining $dataTraining)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DataTraining  $dataTraining
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DataTraining $dataTraining)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DataTraining  $dataTraining
     * @return \Illuminate\Http\Response
     */
    public function destroy(DataTraining $dataTraining)
    {
        //
    }

    public function import_csv(Request $request)
    {
        // validasi
        try {
            $this->validate($request, [
                'csvFile' => 'required|mimes:csv'
            ]);
        } catch (ValidationException $e) {
        }

        DataTraining::query()->delete();

        $path = storage_path('app/public/data/');

        if(!File::exists($path))
            File::makeDirectory($path);

        // menangkap file excel
        $file = $request->file('csvFile');

        // membuat nama file unik
        $file_name = 'datatraining.'.$file->getClientOriginalExtension();

        // upload ke folder
        $file->move($path, $file_name);

        // import data
        Excel::import(new DataTrainingImport(), $path.$file_name);

        // notifikasi dengan session
        //Session::flash('sukses','Data Siswa Berhasil Diimport!');

        // alihkan halaman kembali
        return redirect('/training');
    }
}
