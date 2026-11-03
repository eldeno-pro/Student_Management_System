<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $lecturerBashir = User::where('email', 'bmutebi@mubs.ac.ug')->first();
        $lecturerJoy = User::where('email', 'jtiko@mubs.ac.ug')->first();
        $lecturerMoshin = User::where('email', 'mgyagenda@mubs.ac.ug')->first();

        $courses = [
            [
                'code' => 'BUC3131',
                'title' => 'Advanced Web Application Development',
                'description' => 'Architectural design, MVC frameworks, security, Eloquent ORM, RESTful APIs, and full-stack web applications using Laravel.',
                'credit_units' => 4,
                'year_of_study' => 3,
                'semester' => 1,
                'lecturer_id' => $lecturerBashir?->id,
            ],
            [
                'code' => 'BUC3132',
                'title' => 'Database Management Systems II',
                'description' => 'Relational database administration, normalization, indexing, transaction management, and query optimization with MySQL/PostgreSQL.',
                'credit_units' => 4,
                'year_of_study' => 3,
                'semester' => 1,
                'lecturer_id' => $lecturerJoy?->id,
            ],
            [
                'code' => 'BUC3133',
                'title' => 'Cloud Computing & Enterprise Architecture',
                'description' => 'Deployment architectures, containerization, virtual servers, cloud infrastructure, and modern deployment pipelines.',
                'credit_units' => 3,
                'year_of_study' => 3,
                'semester' => 1,
                'lecturer_id' => $lecturerMoshin?->id,
            ],
            [
                'code' => 'BUC3134',
                'title' => 'E-Business Strategy & Systems',
                'description' => 'Strategic business computing, e-commerce architectures, electronic payment gateways, and enterprise integration.',
                'credit_units' => 3,
                'year_of_study' => 3,
                'semester' => 1,
                'lecturer_id' => $lecturerBashir?->id,
            ],
            [
                'code' => 'BUC3135',
                'title' => 'Systems Analysis & Design',
                'description' => 'Software lifecycle development, requirements elicitation, UML modeling, and object-oriented analysis.',
                'credit_units' => 4,
                'year_of_study' => 3,
                'semester' => 1,
                'lecturer_id' => $lecturerJoy?->id,
            ],
        ];

        foreach ($courses as $courseData) {
            Course::updateOrCreate(
                ['code' => $courseData['code']],
                $courseData
            );
        }
    }
}
