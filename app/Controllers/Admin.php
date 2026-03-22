<?php

namespace App\Controllers;

use App\Models\AdminUserModel;
use App\Models\ViewerUserModel;

class Admin extends BaseController
{
    public function login()
    {
        // If already logged in as admin or viewer, go to portfolio
        if (session()->get('isAdminLoggedIn') || session()->get('isViewerLoggedIn')) {
            return redirect()->to('/');
        }
        
        return view('admin_login');
    }
    
    public function attemptLogin()
    {
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $remember = $this->request->getPost('remember') ? true : false;
        
        // First try to find as admin (by username)
        $adminModel = new AdminUserModel();
        $admin = $adminModel->where('username', $username)
                            ->where('is_active', 1)
                            ->first();
        
        if ($admin && password_verify($password, $admin['password_hash'])) {
            // Admin login successful
            $adminModel->update($admin['id'], ['last_login' => date('Y-m-d H:i:s')]);
            
            session()->set([
                'isAdminLoggedIn' => true,
                'adminId' => $admin['id'],
                'adminUsername' => $admin['username'],
                'adminName' => $admin['full_name'],
                'adminRole' => $admin['role']
            ]);
            
            if ($remember) {
                $this->response->setCookie('remember_admin', 'true', 86400 * 30);
            }
            
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Welcome back, Admin!',
                'redirect' => '/'
            ]);
        }
        
        // If not admin, try as viewer (by USERNAME instead of email)
        $viewerModel = new ViewerUserModel();
        $viewer = $viewerModel->where('username', $username)
                              ->where('is_active', 1)
                              ->first();
        
        if ($viewer && password_verify($password, $viewer['password_hash'])) {
            // Viewer login successful
            $viewerModel->update($viewer['id'], ['last_login' => date('Y-m-d H:i:s')]);
            
            session()->set([
                'isViewerLoggedIn' => true,
                'viewerId' => $viewer['id'],
                'viewerName' => $viewer['full_name'] ?: $viewer['username'],
                'viewerEmail' => $viewer['email'],
                'viewerUsername' => $viewer['username']
            ]);
            
            if ($remember) {
                $this->response->setCookie('remember_viewer', 'true', 86400 * 30);
            }
            
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Welcome back, ' . ($viewer['full_name'] ?: $viewer['username']) . '!',
                'redirect' => '/'
            ]);
        }
        
        // If neither found
        return $this->response->setJSON([
            'status' => 'error',
            'message' => 'Invalid credentials'
        ]);
    }
    
    public function guestLogin()
    {
        session()->set([
            'isGuest' => true,
            'guestLoginTime' => time()
        ]);
        
        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Continuing as guest...',
            'redirect' => '/guest'
        ]);
    }
    
    public function logout()
    {
        session()->destroy();
        $this->response->deleteCookie('remember_admin');
        $this->response->deleteCookie('remember_viewer');
        return redirect()->to('/admin/login');
    }
    
    /**
     * Get certification data for editing (AJAX endpoint)
     * 
     * @param int $id Certification ID
     * @return \CodeIgniter\HTTP\Response
     */
    public function getCertification($id)
    {
        // Check if admin is logged in
        if (!session()->get('isAdminLoggedIn')) {
            return $this->response->setJSON([
                'error' => 'Unauthorized access'
            ])->setStatusCode(403);
        }
        
        $db = \Config\Database::connect();
        $builder = $db->table('certifications');
        $cert = $builder->where('id', $id)->get()->getRowArray();
        
        if (!$cert) {
            return $this->response->setJSON([
                'error' => 'Certification not found'
            ])->setStatusCode(404);
        }
        
        // Map database columns to what the frontend expects
        $cert['issue_date'] = $cert['date_released'];
        $cert['credential_id'] = $cert['examinee_no'];
        
        return $this->response->setJSON($cert);
    }
    
    /**
     * Save certification (add or update)
     */
    public function saveCertification()
    {
        // Check if admin is logged in
        if (!session()->get('isAdminLoggedIn')) {
            return redirect()->back()->with('error', 'Unauthorized access');
        }
        
        $certId = $this->request->getPost('cert_id');
        $db = \Config\Database::connect();
        $builder = $db->table('certifications');
        
        // Handle file upload
        $pdfPath = $this->request->getPost('existing_pdf') ?? '';
        $file = $this->request->getFile('pdf_file');
        
        if ($file && $file->isValid() && !$file->hasMoved()) {
            // Validate file type
            if ($file->getExtension() === 'pdf') {
                // Generate unique filename
                $newName = $file->getRandomName();
                
                // Upload directory
                $uploadPath = FCPATH . 'assets/uploads/certifications/';
                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }
                
                // Move file
                if ($file->move($uploadPath, $newName)) {
                    // Delete old file if exists
                    if (!empty($pdfPath)) {
                        $oldFilePath = FCPATH . $pdfPath;
                        if (file_exists($oldFilePath)) {
                            unlink($oldFilePath);
                        }
                    }
                    
                    $pdfPath = '/assets/uploads/certifications/' . $newName;
                }
            } else {
                return redirect()->back()->with('error', 'Only PDF files are allowed.');
            }
        }
        
        // Prepare data for database - USING YOUR ACTUAL COLUMN NAMES
        $data = [
            'title' => $this->request->getPost('title'),
            'issuer' => $this->request->getPost('issuer'),
            'date_released' => !empty($this->request->getPost('date_released')) ? $this->request->getPost('date_released') : null,
            'examinee_no' => $this->request->getPost('examinee_no') ?? null,
            'rating' => $this->request->getPost('rating') ?? null,
            'pdf_path' => $pdfPath,
            'description' => $this->request->getPost('description') ?? null,
            'display_order' => $this->request->getPost('display_order') ?? 0
        ];
        
        if ($certId) {
            // Update existing
            $builder->where('id', $certId)->update($data);
            return redirect()->back()->with('success', 'Certificate updated successfully!');
        } else {
            // Insert new
            $builder->insert($data);
            return redirect()->back()->with('success', 'Certificate added successfully!');
        }
    }
    
    /**
     * Delete certification
     */
    public function deleteCertification()
    {
        // Check if admin is logged in
        if (!session()->get('isAdminLoggedIn')) {
            return redirect()->back()->with('error', 'Unauthorized access');
        }
        
        $certId = $this->request->getPost('cert_id');
        
        if (!$certId) {
            return redirect()->back()->with('error', 'No certificate specified');
        }
        
        $db = \Config\Database::connect();
        $builder = $db->table('certifications');
        
        // Get PDF path to delete file
        $cert = $builder->select('pdf_path')->where('id', $certId)->get()->getRowArray();
        
        if ($cert && !empty($cert['pdf_path'])) {
            $pdfPath = FCPATH . $cert['pdf_path'];
            if (file_exists($pdfPath)) {
                unlink($pdfPath); // Delete the file
            }
        }
        
        // Delete from database
        $builder->delete(['id' => $certId]);
        
        return redirect()->back()->with('success', 'Certificate deleted successfully!');
    }
    
    /**
     * Upload PDF for certification (alternative method for AJAX uploads)
     */
    public function uploadCertificationPdf()
    {
        // Check if admin is logged in
        if (!session()->get('isAdminLoggedIn')) {
            return $this->response->setJSON([
                'error' => 'Unauthorized access'
            ])->setStatusCode(403);
        }
        
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