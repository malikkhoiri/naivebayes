<?php

use Illuminate\Database\Seeder;

class ClassesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('classes')->insert([
            array('class' => 'VII'),
            array('class' => 'VIII'),
            array('class' => 'IX')
        ]);
    }
}
