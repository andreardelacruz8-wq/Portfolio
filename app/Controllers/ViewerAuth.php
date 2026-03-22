<?php

namespace App\Controllers;

use App\Models\ViewerUserModel;

class ViewerAuth extends BaseController
{
    public function login()
    {
        // If already logged in as viewer, go to portfolio
        if (session()->get('isViewerLoggedIn')) {
            return redirect()->to('/');
        }
        
        return view('viewer_login');
    }
    
    public function attemptLogin()
    {
        $email = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $remember = $this->request->getPost('remember') ? true : false;
        
        $userModel = new ViewerUserModel();
        $user = $userModel->where('email', $email)
                          ->where('is_active', 1)
                          ->first();
        
        if ($user && $userModel->verifyPassword($password, $user['password_hash'])) {
            
            // Update last login
            $userModel->update($user['id'], ['last_login' => date('Y-m-d H:i:s')]);
            
            // Set viewer session
            session()->set([
                'isViewerLoggedIn' => true,
                'viewerId' => $user['id'],
                'viewerName' => $user['full_name'] ?: $user['username'],
                'viewerEmail' => $user['email'],
                'viewerLoginTime' => time()
            ]);
            
            // Set remember me cookie if checked
            if ($remember) {
                $this->response->setCookie('remember_viewer', 'true', 86400 * 30);
            }
            
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Welcome back, ' . ($user['full_name'] ?: $user['username']) . '!',
                'redirect' => '/'
            ]);
            
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Invalid email or password'
            ]);
        }
    }
    
    public function register()
    {
        return view('viewer_register');
    }
    
    public function attemptRegister()
    {
        $rules = [
            'username' => 'required|min_length[3]|is_unique[viewer_users.username]',
            'email' => 'required|valid_email|is_unique[viewer_users.email]',
            'password' => 'required|min_length[6]',
            'confirm_password' => 'required|matches[password]'
        ];
        
        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => 'error',
                'messages' => $this->validator->getErrors()
            ]);
        }
        
        $userModel = new ViewerUserModel();
        
        $data = [
            'username' => $this->request->getPost('username'),
            'email' => $this->request->getPost('email'),
            'password_hash' => $this->request->getPost('password'),
            'full_name' => $this->request->getPost('full_name')
        ];
        
        if ($userModel->save($data)) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Registration successful! Please login.',
                'redirect' => '/viewer/login'
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Registration failed. Please try again.'
            ]);
        }
    }
    
    public function logout()
    {
        session()->remove('isViewerLoggedIn');
        session()->remove('viewerId');
        session()->remove('viewerName');
        session()->remove('viewerEmail');
        $this->response->deleteCookie('remember_viewer');
        return redirect()->to('/');
    }
    
    public function profile()
    {
        if (!session()->get('isViewerLoggedIn')) {
            return redirect()->to('/viewer/login');
        }
        
        $userModel = new ViewerUserModel();
        $user = $userModel->find(session()->get('viewerId'));
        
        return view('viewer_profile', ['user' => $user]);
    }
    
    public function updateProfile()
    {
        if (!session()->get('isViewerLoggedIn')) {
            return redirect()->to('/viewer/login');
        }
        
        $userId = session()->get('viewerId');
        $userModel = new ViewerUserModel();
        
        $data = [
            'full_name' => $this->request->getPost('full_name'),
            'bio' => $this->request->getPost('bio')
        ];
        
        if ($this->request->getPost('password')) {
            $data['password_hash'] = $this->request->getPost('password');
        }
        
        if ($userModel->update($userId, $data)) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Profile updated successfully!'
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Update failed'
            ]);
        }
    }
}