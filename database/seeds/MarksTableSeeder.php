<?php

use Illuminate\Database\Seeder;

class MarksTableSeeder extends Seeder
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
        DB::table('marks')->truncate();
        $data = [];
        $c = 1;
        for($i = 1; $i <= 8; $i++) {
            for($j = 0; $j < 5; $j++) {
                $d = [
                    'course_id'     => 1,
                    'student_id'    => 2,
                    'semester_id'   => $i,
                    'subject_id'    => $c,
                    'marks'         => rand(30, 100),
                    'created_at'    => $now,
                    'updated_at'    => $now,
                ];
                array_push($data, $d);
                $c++;
            }
        }
        DB::table('marks')->insert($data);
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
