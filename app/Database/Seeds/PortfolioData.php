<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PortfolioData extends Seeder
{
    public function run()
    {
        // Clear existing data
        $this->db->table('coursework')->truncate();
        $this->db->table('achievements')->truncate();
        $this->db->table('work_experience')->truncate();
        $this->db->table('soft_skills')->truncate();
        $this->db->table('education')->truncate();

        // Insert education
        $this->db->table('education')->insert([
            'degree' => 'Bachelor of Science in Computer Science',
            'school' => 'University of the Philippines',
            'location' => 'Los Baños, Laguna',
            'start_date' => '2021-08-01',
            'end_date' => '2025-05-01',
            'gpa' => '3.7/4.0',
            'description' => 'Focused on software development, machine learning, and human-computer interaction.',
            'display_order' => 1
        ]);
        
        $educationId = $this->db->insertID();

        // Insert coursework
        $coursework = [
            ['education_id' => $educationId, 'course_name' => 'Data Structures & Algorithms'],
            ['education_id' => $educationId, 'course_name' => 'Machine Learning Fundamentals'],
            ['education_id' => $educationId, 'course_name' => 'Database Management Systems'],
            ['education_id' => $educationId, 'course_name' => 'Web Development'],
            ['education_id' => $educationId, 'course_name' => 'Computer Vision'],
            ['education_id' => $educationId, 'course_name' => 'Software Engineering'],
            ['education_id' => $educationId, 'course_name' => 'Cybersecurity Basics'],
            ['education_id' => $educationId, 'course_name' => 'Human-Computer Interaction'],
        ];
        $this->db->table('coursework')->insertBatch($coursework);

        // Insert achievements
        $achievements = [
            [
                'education_id' => $educationId,
                'achievement_icon' => '🥇',
                'achievement_title' => "Dean's Lister",
                'achievement_year' => '2022 - 2024',
                'achievement_description' => 'Consistent inclusion in Dean\'s List for 5 consecutive semesters'
            ],
            [
                'education_id' => $educationId,
                'achievement_icon' => '🏅',
                'achievement_title' => 'Best Thesis Award',
                'achievement_year' => '2025',
                'achievement_description' => '"KUMPAS: A Real-Time Sign Language Translation System"'
            ],
            [
                'education_id' => $educationId,
                'achievement_icon' => '💻',
                'achievement_title' => 'Hackathon Finalist',
                'achievement_year' => '2024',
                'achievement_description' => 'Google Developer Student Clubs - Solution Challenge'
            ]
        ];
        $this->db->table('achievements')->insertBatch($achievements);

        // Insert work experience
        $workExperiences = [
            [
                'position' => 'Software Engineering Intern',
                'company' => 'TechSolutions Inc.',
                'location' => 'Remote',
                'start_date' => '2024-01-01',
                'end_date' => null,
                'current_job' => 1,
                'description' => "• Developed and maintained RESTful APIs using Python/Flask, serving 10k+ daily requests\n• Collaborated with senior developers to optimize database queries, reducing response time by 30%\n• Participated in agile ceremonies including daily stand-ups and sprint planning\n• Created comprehensive API documentation using Swagger for team reference",
                'technologies' => 'Python||Flask||MySQL||Git||Jira',
                'display_order' => 1
            ],
            [
                'position' => 'Teaching Assistant',
                'company' => 'University of the Philippines',
                'location' => 'Los Baños, Laguna',
                'start_date' => '2023-06-01',
                'end_date' => '2024-03-01',
                'current_job' => 0,
                'description' => "• Assisted in teaching \"Introduction to Programming\" course with 50+ students\n• Conducted weekly lab sessions and graded 100+ programming assignments\n• Held office hours to help students debug code and understand core concepts\n• Developed supplementary learning materials and practice exercises",
                'technologies' => 'Java||Python||Teaching||Mentoring',
                'display_order' => 2
            ],
            [
                'position' => 'Freelance Web Developer',
                'company' => 'Self-employed',
                'location' => 'Remote',
                'start_date' => '2022-01-01',
                'end_date' => '2023-12-01',
                'current_job' => 0,
                'description' => "• Designed and built responsive websites for 3 local small businesses\n• Managed client communications and translated requirements into technical specifications\n• Delivered projects on time and within budget, receiving 5-star client satisfaction\n• Implemented SEO best practices, improving client visibility by 40%",
                'technologies' => 'HTML/CSS||JavaScript||React||WordPress||Client Management',
                'display_order' => 3
            ]
        ];
        $this->db->table('work_experience')->insertBatch($workExperiences);

        // Insert soft skills
        $softSkills = [
            [
                'icon' => '🗣️',
                'title' => 'Communication',
                'description' => 'Presented technical concepts to non-technical audiences as a teaching assistant. Wrote clear documentation and client-friendly emails.',
                'examples' => 'TA experience||client communication||technical writing',
                'display_order' => 1
            ],
            [
                'icon' => '🤲',
                'title' => 'Team Collaboration',
                'description' => 'Worked effectively in agile teams during internship. Collaborated with 5+ developers on group projects and hackathons.',
                'examples' => 'agile/scrum||pair programming||code reviews',
                'display_order' => 2
            ],
            [
                'icon' => '🧩',
                'title' => 'Problem Solving',
                'description' => 'Debugged complex issues in real-time systems. Optimized database queries reducing response time by 30% during internship.',
                'examples' => 'critical thinking||debugging||optimization',
                'display_order' => 3
            ],
            [
                'icon' => '🔄',
                'title' => 'Adaptability',
                'description' => 'Quickly learned new frameworks and tools for client projects. Transitioned between frontend and backend tasks seamlessly.',
                'examples' => 'fast learner||flexible||versatile',
                'display_order' => 4
            ],
            [
                'icon' => '🌟',
                'title' => 'Leadership',
                'description' => 'Led a team of 3 for thesis project. Mentored junior students as teaching assistant. Organized study groups.',
                'examples' => 'mentoring||project lead||initiative',
                'display_order' => 5
            ],
            [
                'icon' => '⏰',
                'title' => 'Time Management',
                'description' => 'Balanced academics, internship, and freelance work. Delivered all projects before deadlines with quality results.',
                'examples' => 'deadline-driven||organized||prioritization',
                'display_order' => 6
            ]
        ];
        $this->db->table('soft_skills')->insertBatch($softSkills);
    }
}