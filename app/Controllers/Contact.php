<?php

namespace App\Controllers;

use App\Models\ContactModel;

class Contact extends BaseController
{
    public function send()
    {
        try {
            // Get the POST data
            $name = $this->request->getPost('name');
            $email = $this->request->getPost('email');
            $message = $this->request->getPost('message');
            
            // Check if data is received
            if (!$name || !$email || !$message) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'All fields are required'
                ]);
            }
            
            // Save to database
            $model = new ContactModel();
            
            $dataToSave = [
                'name' => $name,
                'email' => $email,
                'message' => $message,
                'ipaddress' => $this->request->getIPAddress()
            ];
            
            if ($model->save($dataToSave)) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Thank you! Message sent ✦'
                ]);
            } else {
                // Get the actual error
                $errors = $model->errors();
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Database error: ' . json_encode($errors)
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }
}