<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SaScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $schedules = [
            [
                'student_id' => 115, // Alexander Reyes
                'subject_offering_id' => 1,
                'term_id' => '2024-Fall',
                'subject_code' => 'CS101',
                'enrollment_status_id' => 1,
                'date_reference' => Carbon::now(),
                'remarks' => null,
                'confirmed_at' => Carbon::now()->addDay(),
                'enrolled_at' => Carbon::now()->subDay(),
            ],
            [
                'student_id' => 115, // Alexander Reyes
                'subject_offering_id' => 2,
                'term_id' => '2024-Fall',
                'subject_code' => 'CS102',
                'enrollment_status_id' => 1,
                'date_reference' => Carbon::now(),
                'remarks' => null,
                'confirmed_at' => Carbon::now()->addDay(),
                'enrolled_at' => Carbon::now()->subDay(),
            ],
            [
                'student_id' => 115, // Alexander Reyes
                'subject_offering_id' => 3,
                'term_id' => '2024-Fall',
                'subject_code' => 'CS103',
                'enrollment_status_id' => 1,
                'date_reference' => Carbon::now(),
                'remarks' => null,
                'confirmed_at' => Carbon::now()->addDay(),
                'enrolled_at' => Carbon::now()->subDay(),
            ],
            [
                'student_id' => 116, // Emily Villanueva
                'subject_offering_id' => 4,
                'term_id' => '2024-Fall',
                'subject_code' => 'IT201',
                'enrollment_status_id' => 1,
                'date_reference' => Carbon::now(),
                'remarks' => 'Needs special approval',
                'confirmed_at' => Carbon::now()->addDay(),
                'enrolled_at' => Carbon::now()->subDay(),
            ],
            [
                'student_id' => 116, // Emily Villanueva
                'subject_offering_id' => 5,
                'term_id' => '2024-Fall',
                'subject_code' => 'IT202',
                'enrollment_status_id' => 1,
                'date_reference' => Carbon::now(),
                'remarks' => null,
                'confirmed_at' => Carbon::now()->addDay(),
                'enrolled_at' => Carbon::now()->subDay(),
            ],
            [
                'student_id' => 116, // Emily Villanueva
                'subject_offering_id' => 6,
                'term_id' => '2024-Fall',
                'subject_code' => 'IT203',
                'enrollment_status_id' => 1,
                'date_reference' => Carbon::now(),
                'remarks' => null,
                'confirmed_at' => Carbon::now()->addDay(),
                'enrolled_at' => Carbon::now()->subDay(),
            ],
            [
                'student_id' => 117, // John Smith
                'subject_offering_id' => 7,
                'term_id' => '2024-Fall',
                'subject_code' => 'ENG101',
                'enrollment_status_id' => 1,
                'date_reference' => Carbon::now(),
                'remarks' => 'Confirmed with advisor',
                'confirmed_at' => Carbon::now()->addDay(),
                'enrolled_at' => Carbon::now()->subDay(),
            ],
            [
                'student_id' => 117, // John Smith
                'subject_offering_id' => 8,
                'term_id' => '2024-Fall',
                'subject_code' => 'ENG102',
                'enrollment_status_id' => 1,
                'date_reference' => Carbon::now(),
                'remarks' => null,
                'confirmed_at' => Carbon::now()->addDay(),
                'enrolled_at' => Carbon::now()->subDay(),
            ],
            [
                'student_id' => 117, // John Smith
                'subject_offering_id' => 9,
                'term_id' => '2024-Fall',
                'subject_code' => 'ENG103',
                'enrollment_status_id' => 1,
                'date_reference' => Carbon::now(),
                'remarks' => null,
                'confirmed_at' => Carbon::now()->addDay(),
                'enrolled_at' => Carbon::now()->subDay(),
            ],
        ];

        DB::table('student_schedules')->insert($schedules);
    }
}
