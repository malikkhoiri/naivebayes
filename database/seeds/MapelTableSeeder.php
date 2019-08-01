<?php

use Illuminate\Database\Seeder;

class MapelTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('mapels')->insert([
            array('name' => 'Matematika'),
            array('name' => 'Biologi'),
            array('name' => 'Fisika'),
            array('name' => 'Bahasa Inggris'),
            array('name' => 'Bahasa Indonesia'),
        ]);
    }
}
