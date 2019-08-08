<?php

use App\Imports\DataTrainingImport;
use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;

class DataTrainingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Excel::import(new DataTrainingImport(), base_path('test.csv'));
    }
}
