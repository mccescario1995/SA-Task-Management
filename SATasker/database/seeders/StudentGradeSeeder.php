<?php

namespace Database\Seeders;

use Illuminate\Auth\Events\Failed;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudentGradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        $students = [
            [
                'id_number' => 111,
                'subject_code_id' => 'EE133',
                'midterm_grade' => '85',
                'midterm_absences' => '2',
                'endterm_grade' => '90',
                'endterm_absences' => '3',
                'final_grade' => '87.5'
            ],
            [
                'id_number' => 115,
                'subject_code_id' => 'CS101',
                'midterm_grade' => '80',
                'midterm_absences' => '1',
                'endterm_grade' => '85',
                'endterm_absences' => '2',
                'final_grade' => '82.5'
            ],
            [
                'id_number' => 115,
                'subject_code_id' => 'CS102',
                'midterm_grade' => '80',
                'midterm_absences' => '1',
                'endterm_grade' => '85',
                'endterm_absences' => '2',
                'final_grade' => '82.5'
            ],
            [
                'id_number' => 116,
                'subject_code_id' => 'IT101',
                'midterm_grade' => '75',
                'midterm_absences' => '4',
                'endterm_grade' => '78',
                'endterm_absences' => '5',
                'final_grade' => '76.5'
            ],
            [
                'id_number' => 116,
                'subject_code_id' => 'IT102',
                'midterm_grade' => '70',
                'midterm_absences' => '4',
                'endterm_grade' => '71',
                'endterm_absences' => '5',
                'final_grade' => '0.0'
            ],
        ];

        foreach ($students as $student) {
            DB::table('student_grades')->insert([
                'student_profile_id' => $student['id_number'], // Assuming 'id_number' is used as the profile identifier
                'subject_code_id' => $student['subject_code_id'],
                'midterm_grade' => $student['midterm_grade'],
                'midterm_absences' => $student['midterm_absences'],
                'endterm_grade' => $student['endterm_grade'],
                'endterm_absences' => $student['endterm_absences'],
                'remarks' => $student['final_grade'] === '0.0' ? 'Failed': 'Passed',
                'final_grade' => $student['final_grade'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Generate a random passing grade between 75 and 100.
     *
     * @return string
     */
    private function generateRandomPassingGrade()
    {
        return (string) rand(75, 100); // Adjust the range for passing grades as needed
    }
}
