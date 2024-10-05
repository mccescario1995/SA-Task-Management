<?php

namespace Database\Seeders;

use App\Models\SaProfile;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Offense; // Assuming you have an Offense model
use App\Models\StudentGrade;
use Log;

class OffenseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get all users with the 'student_assistant' role
        $probationStudent = StudentGrade::where('final_grade', '=', '0.0')->first();
        // dd($probationStudent);
        // Seed offenses for each user
        Offense::create(
            [
                'user_id' => $probationStudent->student_profile_id,
                'type' => 'major',
                'description' => 'Theft',
                'status' => 'probation',
                'date_started' => '2024-11-11',
                'date_ended' => '2024-11-15',
            ]
        );

        $majorOffense = SaProfile::inRandomOrder()->take(5)->get();
        // dd($majorOffense);
        $offenseTypes = ['grade', 'major'];  // Possible offense types
        $offenseDescriptions = ['Bullying', 'Cheating', 'Harassment', 'Disrespect', 'Theft'];  // List of random offenses

        foreach ($majorOffense as $sa) {
            // Check if SA exists and has necessary data before creating an offense
            $offenseType = $offenseTypes[array_rand($offenseTypes)];  // Random type: 'grade' or 'major'

            // Determine description based on offense type
            if ($offenseType == 'grade') {
                $description = '0.0';
            } elseif ($offenseType == 'major') {
                $description = $offenseDescriptions[array_rand($offenseDescriptions)]; // Random major offense description
            }

            Offense::create([
                'user_id'      => $sa->user_id,  // Ensure correct field mapping
                'type'         => $offenseType,  // Random type: 'grade' or 'major'
                'description'  => $description,  // Determined based on offense type
                'status'       => 'pending',     // Static status
                'date_started' => now()->format('Y-m-d'),  // Use current date for date_started
                'date_ended'   => now()->addDays(rand(5, 20))->format('Y-m-d'),  // Random end date between 5-20 days
            ]);

            // Update user profile status
            $user = SaProfile::where('user_id', $sa->user_id)->first();
            if ($user) {
                $user->status = 'pending';
                $user->save();
            }
        }
    }
}
