<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CoursesTableSeeder extends Seeder
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
    	DB::table('courses')->truncate();

        DB::table('courses')->insert([
        	[
        		'name' => 'Computer Engineering',
        		'created_at' => $now,
        		'updated_at' => $now
        	],
        	[
        		'name' => 'Civil Engineering',
        		'created_at' => $now,
        		'updated_at' => $now
        	],
        	[
        		'name' => 'Mechanical Engineering',
        		'created_at' => $now,
        		'updated_at' => $now
        	],
        	[
        		'name' => 'Information And Technology',
        		'created_at' => $now,
        		'updated_at' => $now
        	],
        	[
        		'name' => 'Civil Engineering',
        		'created_at' => $now,
        		'updated_at' => $now
        	],
        	[
        		'name' => 'Automobile Engineering',
        		'created_at' => $now,
        		'updated_at' => $now
        	]
        ]);

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
