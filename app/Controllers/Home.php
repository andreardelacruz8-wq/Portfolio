<?php

namespace App\Controllers;

use App\Models\ContactModel;
use App\Models\HobbyModel;
use App\Models\ProjectModel;
use App\Models\SpecialSkillModel;
use App\Models\SkillCategoryModel;
use App\Models\EducationModel;
use App\Models\WorkExperienceModel;
use App\Models\SoftSkillModel;

class Home extends BaseController
{
    public function index()
    {
        // Check login status
        $isAdmin = session()->get('isAdminLoggedIn') ? true : false;
        $isViewer = session()->get('isViewerLoggedIn') ? true : false;
        $isGuest = session()->get('isGuest') ? true : false;
        
        // Load data from database - including new sections
        $data = [
            'hobbies' => model(HobbyModel::class)->orderBy('display_order', 'ASC')->findAll(),
            'projects' => model(ProjectModel::class)->orderBy('display_order', 'ASC')->findAll(),
            'special_skills' => model(SpecialSkillModel::class)->orderBy('display_order', 'ASC')->findAll(),
            'education' => model(EducationModel::class)->orderBy('display_order', 'ASC')->findAll(),
            'work_experience' => model(WorkExperienceModel::class)->orderBy('display_order', 'ASC')->findAll(),
            'soft_skills' => model(SoftSkillModel::class)->orderBy('display_order', 'ASC')->findAll(),
            'isAdmin' => $isAdmin,
            'isViewer' => $isViewer,
            'isGuest' => $isGuest
        ];
        
        // Load certifications from database
        $db = db_connect();
        $builder = $db->table('certifications');
        $data['certifications'] = $builder->orderBy('display_order ASC, date_released DESC')->get()->getResultArray();
        
        // Load skill categories with their skills and skill IDs
        $query = $db->query("
            SELECT sc.*, 
                   GROUP_CONCAT(s.name ORDER BY s.display_order SEPARATOR '||') as skills,
                   GROUP_CONCAT(s.id ORDER BY s.display_order SEPARATOR '||') as skill_ids
            FROM skill_categories sc
            LEFT JOIN skills s ON s.category_id = sc.id
            GROUP BY sc.id
            ORDER BY sc.display_order
        ");
        $data['skill_categories'] = $query->getResultArray();
        
        // For admin - also load messages
        if ($isAdmin) {
            $data['messages'] = model(ContactModel::class)->orderBy('created_at', 'DESC')->findAll();
            return view('portfolio_admin', $data);
        }
        
        // For viewers and guests
        return view('portfolio_direct', $data);
    }
    
    public function guest()
    {
        // Set guest session if coming from guest login
        if (!session()->get('isGuest')) {
            session()->set('isGuest', true);
        }
        
        // Load public data - including new sections
        $data = [
            'hobbies' => model(HobbyModel::class)->orderBy('display_order', 'ASC')->findAll(),
            'projects' => model(ProjectModel::class)->orderBy('display_order', 'ASC')->findAll(),
            'special_skills' => model(SpecialSkillModel::class)->orderBy('display_order', 'ASC')->findAll(),
            'education' => model(EducationModel::class)->orderBy('display_order', 'ASC')->findAll(),
            'work_experience' => model(WorkExperienceModel::class)->orderBy('display_order', 'ASC')->findAll(),
            'soft_skills' => model(SoftSkillModel::class)->orderBy('display_order', 'ASC')->findAll()
        ];
        
        // Load certifications from database
        $db = db_connect();
        $builder = $db->table('certifications');
        $data['certifications'] = $builder->orderBy('display_order ASC, date_released DESC')->get()->getResultArray();
        
        // Load skill categories with IDs
        $query = $db->query("
            SELECT sc.*, 
                   GROUP_CONCAT(s.name ORDER BY s.display_order SEPARATOR '||') as skills,
                   GROUP_CONCAT(s.id ORDER BY s.display_order SEPARATOR '||') as skill_ids
            FROM skill_categories sc
            LEFT JOIN skills s ON s.category_id = sc.id
            GROUP BY sc.id
            ORDER BY sc.display_order
        ");
        $data['skill_categories'] = $query->getResultArray();
        
        return view('portfolio_direct', $data);
    }
}