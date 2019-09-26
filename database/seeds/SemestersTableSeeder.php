<?php

use Illuminate\Database\Seeder;

class SemestersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$now = \Carbon\Carbon::now();

    	DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('semesters')->truncate();

        DB::table('semesters')->insert([
        	[
        		'name' => 'Semester I',
        		'created_at' => $now,
        		'updated_at' => $now
        	],
        	[
        		'name' => 'Semester II',
        		'created_at' => $now,
        		'updated_at' => $now
        	],
        	[
        		'name' => 'Semester III',
        		'created_at' => $now,
        		'updated_at' => $now
        	],
        	[
        		'name' => 'Semester IV',
        		'created_at' => $now,
        		'updated_at' => $now
        	],
        	[
        		'name' => 'Semester V',
        		'created_at' => $now,
        		'updated_at' => $now
        	],
        	[
        		'name' => 'Semester VI',
        		'created_at' => $now,
        		'updated_at' => $now
        	],
        	[
        		'name' => 'Semester VII',
        		'created_at' => $now,
        		'updated_at' => $now
        	],
        	[
        		'name' => 'Semester VIII',
        		'created_at' => $now,
        		'updated_at' => $now
        	]
        ]);
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
