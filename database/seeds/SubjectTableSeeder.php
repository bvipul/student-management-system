<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubjectTableSeeder extends Seeder
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
    	DB::table('subjects')->truncate();

        DB::table('subjects')->insert([
            // Semester 1
        	[
                'course_id'       => 1,
                'semester_id'     => 1,
        		'name'            => 'Computer Programming and Utilization',
        		'created_at'      => $now,
        		'updated_at'      => $now
        	],
            [
                'course_id'       => 1,
                'semester_id'     => 1,
                'name'            => 'Elements of Civil Engineering',
                'created_at'      => $now,
                'updated_at'      => $now
            ],
            [
                'course_id'       => 1,
                'semester_id'     => 1,
                'name'            => 'Elements of Electrical Engineering',
                'created_at'      => $now,
                'updated_at'      => $now
            ],
            [
                'course_id'       => 1,
                'semester_id'     => 1,
                'name'            => 'Elements of Mechanical Engineering',
                'created_at'      => $now,
                'updated_at'      => $now
            ],
            [
                'course_id'       => 1,
                'semester_id'     => 1,
                'name'            => 'Engineering Graphics',
                'created_at'      => $now,
                'updated_at'      => $now
            ],

            // Semester II
            [
                'course_id'       => 1,
                'semester_id'     => 2,
                'name'            => 'Environmental Studies',
                'created_at'      => $now,
                'updated_at'      => $now
            ],
            [
                'course_id'       => 1,
                'semester_id'     => 2,
                'name'            => 'Physics',
                'created_at'      => $now,
                'updated_at'      => $now
            ],
            [
                'course_id'       => 1,
                'semester_id'     => 2,
                'name'            => 'Communication Skills',
                'created_at'      => $now,
                'updated_at'      => $now
            ],
            [
                'course_id'       => 1,
                'semester_id'     => 2,
                'name'            => 'Calculus',
                'created_at'      => $now,
                'updated_at'      => $now
            ],
            [
                'course_id'       => 1,
                'semester_id'     => 2,
                'name'            => 'Basic Electronics',
                'created_at'      => $now,
                'updated_at'      => $now
            ],

            // Semester III
            [
                'course_id'       => 1,
                'semester_id'     => 3,
                'name'            => 'Advanced Engineering Mathematics',
                'created_at'      => $now,
                'updated_at'      => $now
            ],
            [
                'course_id'       => 1,
                'semester_id'     => 3,
                'name'            => 'Engineering Economics and Management',
                'created_at'      => $now,
                'updated_at'      => $now
            ],
            [
                'course_id'       => 1,
                'semester_id'     => 3,
                'name'            => 'Design Engineering - I',
                'created_at'      => $now,
                'updated_at'      => $now
            ],
            [
                'course_id'       => 1,
                'semester_id'     => 3,
                'name'            => 'Data Structures',
                'created_at'      => $now,
                'updated_at'      => $now
            ],
            [
                'course_id'       => 1,
                'semester_id'     => 3,
                'name'            => 'Database Management Systems',
                'created_at'      => $now,
                'updated_at'      => $now
            ],

            // Semester IV
            [
                'course_id'       => 1,
                'semester_id'     => 4,
                'name'            => 'Design Engineering - I B',
                'created_at'      => $now,
                'updated_at'      => $now
            ],
            [
                'course_id'       => 1,
                'semester_id'     => 4,
                'name'            => 'Operating System',
                'created_at'      => $now,
                'updated_at'      => $now
            ],
            [
                'course_id'       => 1,
                'semester_id'     => 4,
                'name'            => 'Object Oriented Programming With C++',
                'created_at'      => $now,
                'updated_at'      => $now
            ],
            [
                'course_id'       => 1,
                'semester_id'     => 4,
                'name'            => 'Computer Organization',
                'created_at'      => $now,
                'updated_at'      => $now
            ],
            [
                'course_id'       => 1,
                'semester_id'     => 4,
                'name'            => 'Computer Networks',
                'created_at'      => $now,
                'updated_at'      => $now
            ],

            // Semester V
            [
                'course_id'       => 1,
                'semester_id'     => 5,
                'name'            => 'Analysis and Design of Algorithms',
                'created_at'      => $now,
                'updated_at'      => $now
            ],
            [
                'course_id'       => 1,
                'semester_id'     => 5,
                'name'            => 'Object Oriented Programming using JAVA',
                'created_at'      => $now,
                'updated_at'      => $now
            ],
            [
                'course_id'       => 1,
                'semester_id'     => 5,
                'name'            => 'Microprocessor and Interfacing',
                'created_at'      => $now,
                'updated_at'      => $now
            ],
            [
                'course_id'       => 1,
                'semester_id'     => 5,
                'name'            => 'System Programming',
                'created_at'      => $now,
                'updated_at'      => $now
            ],
            [
                'course_id'       => 1,
                'semester_id'     => 5,
                'name'            => 'Cyber Security',
                'created_at'      => $now,
                'updated_at'      => $now
            ],

            // Semester VI
            [
                'course_id'       => 1,
                'semester_id'     => 6,
                'name'            => 'Software Engineering',
                'created_at'      => $now,
                'updated_at'      => $now
            ],
            [
                'course_id'       => 1,
                'semester_id'     => 6,
                'name'            => 'Theory of Computation',
                'created_at'      => $now,
                'updated_at'      => $now
            ],
            [
                'course_id'       => 1,
                'semester_id'     => 6,
                'name'            => 'Advanced Java',
                'created_at'      => $now,
                'updated_at'      => $now
            ],
            [
                'course_id'       => 1,
                'semester_id'     => 6,
                'name'            => 'Web Technology',
                'created_at'      => $now,
                'updated_at'      => $now
            ],
            [
                'course_id'       => 1,
                'semester_id'     => 6,
                'name'            => 'Distributed Operating System',
                'created_at'      => $now,
                'updated_at'      => $now
            ],

            // Semester VII
            [
                'course_id'       => 1,
                'semester_id'     => 7,
                'name'            => 'Complier Design',
                'created_at'      => $now,
                'updated_at'      => $now
            ],
            [
                'course_id'       => 1,
                'semester_id'     => 7,
                'name'            => 'Information and Network Security',
                'created_at'      => $now,
                'updated_at'      => $now
            ],
            [
                'course_id'       => 1,
                'semester_id'     => 7,
                'name'            => 'Mobile Computing and Wireless Communication',
                'created_at'      => $now,
                'updated_at'      => $now
            ],
            [
                'course_id'       => 1,
                'semester_id'     => 7,
                'name'            => 'Image Processing',
                'created_at'      => $now,
                'updated_at'      => $now
            ],
            [
                'course_id'       => 1,
                'semester_id'     => 7,
                'name'            => 'Service Oriented Computing',
                'created_at'      => $now,
                'updated_at'      => $now
            ],

            // Semester VIII
            [
                'course_id'       => 1,
                'semester_id'     => 8,
                'name'            => 'Artificial Intelligence',
                'created_at'      => $now,
                'updated_at'      => $now
            ],
            [
                'course_id'       => 1,
                'semester_id'     => 8,
                'name'            => 'IOT and Applications',
                'created_at'      => $now,
                'updated_at'      => $now
            ],
            [
                'course_id'       => 1,
                'semester_id'     => 8,
                'name'            => 'Big Data Analytics',
                'created_at'      => $now,
                'updated_at'      => $now
            ],
            [
                'course_id'       => 1,
                'semester_id'     => 8,
                'name'            => 'Python',
                'created_at'      => $now,
                'updated_at'      => $now
            ],
            [
                'course_id'       => 1,
                'semester_id'     => 8,
                'name'            => 'Cloud Infrastructure',
                'created_at'      => $now,
                'updated_at'      => $now
            ],
        ]);

        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
