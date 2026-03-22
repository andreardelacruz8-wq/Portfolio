<?php

namespace App\Controllers;

use App\Models\HobbyModel;
use App\Models\ProjectModel;
use App\Models\SpecialSkillModel;
use App\Models\SkillModel;
use App\Models\EducationModel;
use App\Models\WorkExperienceModel;
use App\Models\SoftSkillModel;

class AdminCMS extends BaseController
{
    private function checkAuth()
    {
        if (!session()->get('isAdminLoggedIn')) {
            return $this->response->setJSON(['error' => 'Unauthorized'])->setStatusCode(401);
        }
        return null;
    }

    // ========== HOBBY API ENDPOINTS ==========
    
    public function getHobbies()
    {
        if ($response = $this->checkAuth()) return $response;
        
        $model = new HobbyModel();
        $hobbies = $model->orderBy('display_order', 'ASC')->findAll();
        
        return $this->response->setJSON($hobbies);
    }
    
    public function addHobby()
    {
        if ($response = $this->checkAuth()) return $response;
        
        $model = new HobbyModel();
        
        $data = [
            'title' => $this->request->getPost('title'),
            'icon' => $this->request->getPost('icon') ?: '🧶',
            'description' => $this->request->getPost('description'),
            'favorite' => $this->request->getPost('favorite') ?: '',
            'display_order' => $this->request->getPost('display_order') ?: 99
        ];
        
        if ($model->save($data)) {
            $data['id'] = $model->insertID();
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Hobby added successfully!',
                'data' => $data
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Failed to add hobby'
            ]);
        }
    }
    
    public function updateHobby($id)
    {
        if ($response = $this->checkAuth()) return $response;
        
        $model = new HobbyModel();
        
        $data = [
            'title' => $this->request->getPost('title'),
            'icon' => $this->request->getPost('icon'),
            'description' => $this->request->getPost('description'),
            'favorite' => $this->request->getPost('favorite')
        ];
        
        if ($model->update($id, $data)) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Hobby updated successfully!'
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Failed to update hobby'
            ]);
        }
    }
    
    public function deleteHobby($id)
    {
        if ($response = $this->checkAuth()) return $response;
        
        $model = new HobbyModel();
        
        if ($model->delete($id)) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Hobby deleted successfully!'
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Failed to delete hobby'
            ]);
        }
    }
    
    // ========== PROJECT API ENDPOINTS ==========
    
    public function getProjects()
    {
        if ($response = $this->checkAuth()) return $response;
        
        $model = new ProjectModel();
        $projects = $model->orderBy('display_order', 'ASC')->findAll();
        
        return $this->response->setJSON($projects);
    }
    
    public function addProject()
    {
        if ($response = $this->checkAuth()) return $response;
        
        $model = new ProjectModel();
        
        $data = [
            'title' => $this->request->getPost('title'),
            'tags' => $this->request->getPost('tags') ?: 'New Project',
            'description' => $this->request->getPost('description'),
            'challenge' => $this->request->getPost('challenge') ?: '',
            'code_link' => $this->request->getPost('code_link') ?: '#',
            'demo_link' => $this->request->getPost('demo_link') ?: '#',
            'color' => $this->request->getPost('color') ?: '#cbc3e3',
            'display_order' => $this->request->getPost('display_order') ?: 99
        ];
        
        if ($model->save($data)) {
            $data['id'] = $model->insertID();
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Project added successfully!',
                'data' => $data
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Failed to add project'
            ]);
        }
    }
    
    public function updateProject($id)
    {
        if ($response = $this->checkAuth()) return $response;
        
        $model = new ProjectModel();
        
        $data = [
            'title' => $this->request->getPost('title'),
            'tags' => $this->request->getPost('tags'),
            'description' => $this->request->getPost('description'),
            'challenge' => $this->request->getPost('challenge'),
            'code_link' => $this->request->getPost('code_link'),
            'demo_link' => $this->request->getPost('demo_link'),
            'color' => $this->request->getPost('color')
        ];
        
        if ($model->update($id, $data)) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Project updated successfully!'
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Failed to update project'
            ]);
        }
    }
    
    public function deleteProject($id)
    {
        if ($response = $this->checkAuth()) return $response;
        
        $model = new ProjectModel();
        
        if ($model->delete($id)) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Project deleted successfully!'
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Failed to delete project'
            ]);
        }
    }
    
    // ========== SPECIAL SKILLS API ENDPOINTS ==========
    
    public function getSpecialSkills()
    {
        if ($response = $this->checkAuth()) return $response;
        
        $model = new SpecialSkillModel();
        $skills = $model->orderBy('display_order', 'ASC')->findAll();
        
        return $this->response->setJSON($skills);
    }
    
    public function addSpecialSkill()
    {
        if ($response = $this->checkAuth()) return $response;
        
        $model = new SpecialSkillModel();
        
        $data = [
            'title' => $this->request->getPost('title'),
            'icon' => $this->request->getPost('icon') ?: '🧠',
            'description' => $this->request->getPost('description'),
            'details' => $this->request->getPost('details') ?: '',
            'display_order' => $this->request->getPost('display_order') ?: 99
        ];
        
        if ($model->save($data)) {
            $data['id'] = $model->insertID();
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Special skill added successfully!',
                'data' => $data
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Failed to add special skill'
            ]);
        }
    }
    
    public function updateSpecialSkill($id)
    {
        if ($response = $this->checkAuth()) return $response;
        
        $model = new SpecialSkillModel();
        
        $data = [
            'title' => $this->request->getPost('title'),
            'icon' => $this->request->getPost('icon'),
            'description' => $this->request->getPost('description'),
            'details' => $this->request->getPost('details')
        ];
        
        if ($model->update($id, $data)) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Special skill updated successfully!'
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Failed to update special skill'
            ]);
        }
    }
    
    public function deleteSpecialSkill($id)
    {
        if ($response = $this->checkAuth()) return $response;
        
        $model = new SpecialSkillModel();
        
        if ($model->delete($id)) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Special skill deleted successfully!'
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Failed to delete special skill'
            ]);
        }
    }
    
    // ========== SKILLS API ENDPOINTS ==========
    
    public function addSkill()
    {
        if ($response = $this->checkAuth()) return $response;
        
        $model = new SkillModel();
        
        $data = [
            'category_id' => $this->request->getPost('category_id'),
            'name' => $this->request->getPost('name'),
            'display_order' => $this->request->getPost('display_order') ?: 99
        ];
        
        if ($model->save($data)) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Skill added successfully!',
                'id' => $model->insertID()
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Failed to add skill'
            ]);
        }
    }
    
    public function updateSkill($id)
    {
        if ($response = $this->checkAuth()) return $response;
        
        $model = new SkillModel();
        
        $data = [
            'name' => $this->request->getPost('name')
        ];
        
        if ($model->update($id, $data)) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Skill updated successfully!'
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Failed to update skill'
            ]);
        }
    }
    
    public function deleteSkill($id)
    {
        if ($response = $this->checkAuth()) return $response;
        
        $model = new SkillModel();
        
        if ($model->delete($id)) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Skill deleted successfully!'
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Failed to delete skill'
            ]);
        }
    }
    
    // ========== EDUCATION API ENDPOINTS ==========
    
    public function getEducation()
    {
        if ($response = $this->checkAuth()) return $response;
        
        $model = new EducationModel();
        $education = $model->orderBy('display_order', 'ASC')->findAll();
        
        return $this->response->setJSON($education);
    }
    
    public function addEducation()
    {
        if ($response = $this->checkAuth()) return $response;
        
        $model = new EducationModel();
        
        $data = [
            'degree' => $this->request->getPost('degree'),
            'school' => $this->request->getPost('school'),
            'location' => $this->request->getPost('location') ?: '',
            'start_date' => $this->request->getPost('start_date'),
            'end_date' => $this->request->getPost('end_date') ?: null,
            'gpa' => $this->request->getPost('gpa') ?: '',
            'description' => $this->request->getPost('description') ?: '',
            'display_order' => $this->request->getPost('display_order') ?: 99
        ];
        
        if ($model->save($data)) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Education added successfully!',
                'id' => $model->insertID()
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Failed to add education'
            ]);
        }
    }
    
    public function updateEducation($id)
    {
        if ($response = $this->checkAuth()) return $response;
        
        $model = new EducationModel();
        
        $data = [
            'degree' => $this->request->getPost('degree'),
            'school' => $this->request->getPost('school'),
            'location' => $this->request->getPost('location'),
            'start_date' => $this->request->getPost('start_date'),
            'end_date' => $this->request->getPost('end_date'),
            'gpa' => $this->request->getPost('gpa'),
            'description' => $this->request->getPost('description')
        ];
        
        if ($model->update($id, $data)) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Education updated successfully!'
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Failed to update education'
            ]);
        }
    }
    
    public function deleteEducation($id)
    {
        if ($response = $this->checkAuth()) return $response;
        
        $model = new EducationModel();
        
        if ($model->delete($id)) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Education deleted successfully!'
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Failed to delete education'
            ]);
        }
    }
    
    // ========== WORK EXPERIENCE API ENDPOINTS ==========
    
    public function getWorkExperience()
    {
        if ($response = $this->checkAuth()) return $response;
        
        $model = new WorkExperienceModel();
        $experience = $model->orderBy('display_order', 'ASC')->findAll();
        
        return $this->response->setJSON($experience);
    }
    
    public function addWorkExperience()
    {
        if ($response = $this->checkAuth()) return $response;
        
        $model = new WorkExperienceModel();
        
        $data = [
            'position' => $this->request->getPost('position'),
            'company' => $this->request->getPost('company'),
            'location' => $this->request->getPost('location') ?: '',
            'start_date' => $this->request->getPost('start_date'),
            'end_date' => $this->request->getPost('end_date') ?: null,
            'description' => $this->request->getPost('description'),
            'display_order' => $this->request->getPost('display_order') ?: 99
        ];
        
        if ($model->save($data)) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Work experience added successfully!',
                'id' => $model->insertID()
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Failed to add work experience'
            ]);
        }
    }
    
    public function updateWorkExperience($id)
    {
        if ($response = $this->checkAuth()) return $response;
        
        $model = new WorkExperienceModel();
        
        $data = [
            'position' => $this->request->getPost('position'),
            'company' => $this->request->getPost('company'),
            'location' => $this->request->getPost('location'),
            'start_date' => $this->request->getPost('start_date'),
            'end_date' => $this->request->getPost('end_date'),
            'description' => $this->request->getPost('description')
        ];
        
        if ($model->update($id, $data)) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Work experience updated successfully!'
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Failed to update work experience'
            ]);
        }
    }
    
    public function deleteWorkExperience($id)
    {
        if ($response = $this->checkAuth()) return $response;
        
        $model = new WorkExperienceModel();
        
        if ($model->delete($id)) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Work experience deleted successfully!'
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Failed to delete work experience'
            ]);
        }
    }
    
    // ========== SOFT SKILLS API ENDPOINTS ==========
    
    public function getSoftSkills()
    {
        if ($response = $this->checkAuth()) return $response;
        
        $model = new SoftSkillModel();
        $skills = $model->orderBy('display_order', 'ASC')->findAll();
        
        return $this->response->setJSON($skills);
    }
    
    public function addSoftSkill()
    {
        if ($response = $this->checkAuth()) return $response;
        
        $model = new SoftSkillModel();
        
        $data = [
            'title' => $this->request->getPost('title'),
            'icon' => $this->request->getPost('icon') ?: '🤝',
            'description' => $this->request->getPost('description') ?: '',
            'display_order' => $this->request->getPost('display_order') ?: 99
        ];
        
        if ($model->save($data)) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Soft skill added successfully!',
                'id' => $model->insertID()
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Failed to add soft skill'
            ]);
        }
    }
    
    public function updateSoftSkill($id)
    {
        if ($response = $this->checkAuth()) return $response;
        
        $model = new SoftSkillModel();
        
        $data = [
            'title' => $this->request->getPost('title'),
            'icon' => $this->request->getPost('icon'),
            'description' => $this->request->getPost('description')
        ];
        
        if ($model->update($id, $data)) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Soft skill updated successfully!'
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Failed to update soft skill'
            ]);
        }
    }
    
    public function deleteSoftSkill($id)
    {
        if ($response = $this->checkAuth()) return $response;
        
        $model = new SoftSkillModel();
        
        if ($model->delete($id)) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Soft skill deleted successfully!'
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Failed to delete soft skill'
            ]);
        }
    }

    // ========== CERTIFICATIONS API ENDPOINTS ==========
    
    /**
     * Get all certifications
     */
    public function getCertifications()
    {
        if ($response = $this->checkAuth()) return $response;
        
        $db = db_connect();
        $builder = $db->table('certifications');
        $certifications = $builder->orderBy('display_order ASC, date_released DESC')->get()->getResultArray();
        
        return $this->response->setJSON([
            'status' => 'success',
            'data' => $certifications
        ]);
    }
    
    /**
     * Add new certification
     */
    public function addCertification()
    {
        if ($response = $this->checkAuth()) return $response;
        
        $db = db_connect();
        $builder = $db->table('certifications');
        
        $data = [
            'title' => $this->request->getPost('title'),
            'issuer' => $this->request->getPost('issuer'),
            'date_released' => $this->request->getPost('date_released'),
            'examinee_no' => $this->request->getPost('examinee_no'),
            'rating' => $this->request->getPost('rating'),
            'pdf_path' => $this->request->getPost('pdf_path'),
            'description' => $this->request->getPost('description'),
            'display_order' => $this->request->getPost('display_order') ?? 0
        ];
        
        // Remove empty values
        foreach ($data as $key => $value) {
            if ($value === '' || $value === null) {
                unset($data[$key]);
            }
        }
        
        if ($builder->insert($data)) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Certification added successfully',
                'id' => $db->insertID()
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Failed to add certification'
            ])->setStatusCode(400);
        }
    }
    
    /**
     * Update certification
     */
    public function updateCertification($id)
    {
        if ($response = $this->checkAuth()) return $response;
        
        $db = db_connect();
        $builder = $db->table('certifications');
        
        $data = [
            'title' => $this->request->getPost('title'),
            'issuer' => $this->request->getPost('issuer'),
            'date_released' => $this->request->getPost('date_released'),
            'examinee_no' => $this->request->getPost('examinee_no'),
            'rating' => $this->request->getPost('rating'),
            'pdf_path' => $this->request->getPost('pdf_path'),
            'description' => $this->request->getPost('description'),
            'display_order' => $this->request->getPost('display_order') ?? 0
        ];
        
        // Remove empty values
        foreach ($data as $key => $value) {
            if ($value === '' || $value === null) {
                unset($data[$key]);
            }
        }
        
        if ($builder->where('id', $id)->update($data)) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Certification updated successfully'
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Failed to update certification'
            ])->setStatusCode(400);
        }
    }
    
    /**
     * Delete certification
     */
    public function deleteCertification($id)
    {
        if ($response = $this->checkAuth()) return $response;
        
        $db = db_connect();
        $builder = $db->table('certifications');
        
        // Get PDF path to delete file
        $cert = $builder->select('pdf_path')->where('id', $id)->get()->getRowArray();
        
        if ($cert && !empty($cert['pdf_path'])) {
            $pdfPath = FCPATH . $cert['pdf_path'];
            if (file_exists($pdfPath)) {
                unlink($pdfPath);
            }
        }
        
        if ($builder->where('id', $id)->delete()) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Certification deleted successfully'
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Failed to delete certification'
            ])->setStatusCode(400);
        }
    }
    
    /**
     * Upload certification PDF (API version)
     */
    public function uploadCertificationPdf()
    {
        if ($response = $this->checkAuth()) return $response;
        
        $file = $this->request->getFile('pdf_file');
        
        if (!$file || !$file->isValid() || $file->hasMoved()) {
            return $this->response->setJSON([
                'error' => 'Invalid file upload'
            ])->setStatusCode(400);
        }
        
        // Validate file type
        if ($file->getExtension() !== 'pdf') {
            return $this->response->setJSON([
                'error' => 'Only PDF files are allowed'
            ])->setStatusCode(400);
        }
        
        // Generate unique filename
        $newName = $file->getRandomName();
        
        // Upload directory
        $uploadPath = FCPATH . 'assets/uploads/certifications/';
        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }
        
        // Move file
        if ($file->move($uploadPath, $newName)) {
            return $this->response->setJSON([
                'success' => true,
                'file_path' => '/assets/uploads/certifications/' . $newName,
                'file_name' => $file->getClientName()
            ]);
        } else {
            return $this->response->setJSON([
                'error' => 'Failed to upload file'
            ])->setStatusCode(500);
        }
    }
}