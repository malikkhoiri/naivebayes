<?php

namespace App\Http\Controllers;

use App\DataTraining;
use App\Imports\DataTrainingImport;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Sheet;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

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
        try {
            $this->validate($request, [
                'csvFile' => 'required|mimes:csv'
            ]);
        } catch (ValidationException $e) {
        }

        DataTraining::query()->delete();

        $file = $request->file('csvFile');
        $filename = 'datatraining.'.$file->getClientOriginalExtension();
        $path = $file->storeAs('public/data', $filename);

        // import data
        Excel::import(new DataTrainingImport(), storage_path('app/'.$path));

        return redirect('/training');
    }
}
