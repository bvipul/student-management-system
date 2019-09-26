<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('users')->truncate();

        // Admin
        DB::table('users')->insert([
        	'name' => 'Admin',
        	'email' => 'admin@admin.com',
        	'password' => bcrypt('password'),
        	'is_admin' => 1,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);

        // Student
        DB::table('users')->insert([
            'name' => 'Student',
            'email' => 'student@student.com',
            'password' => bcrypt('password'),
            'is_admin' => 0,
            'course_id' => 1,
            'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()
        ]);
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
