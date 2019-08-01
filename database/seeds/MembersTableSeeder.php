<?php

use Illuminate\Database\Seeder;

class MembersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('members')->insert([
            array('member' => 'A'),
            array('member' => 'B'),
            array('member' => 'C'),
            array('member' => 'D'),
            array('member' => 'E'),
            array('member' => 'F'),
            array('member' => 'G'),
            array('member' => 'H')
        ]);
    }
}
