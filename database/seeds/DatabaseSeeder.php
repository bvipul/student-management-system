<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
    	$this->call(CoursesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
    	$this->call(SemestersTableSeeder::class);
        $this->call(SubjectTableSeeder::class);
        $this->call(MarksTableSeeder::class);
    }
}
