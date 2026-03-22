<?php

namespace App\Models;

use CodeIgniter\Model;

class ViewerUserModel extends Model
{
    protected $table = 'viewer_users';  // Changed to match your database
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'username',
        'email',
        'password_hash',
        'full_name',
        'bio',
        'avatar',
        'last_login',
        'is_active'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Hash password before saving
    protected $beforeInsert = ['hashPassword'];
    protected $beforeUpdate = ['hashPassword'];

    protected function hashPassword(array $data)
    {
        if (isset($data['data']['password_hash'])) {
            $data['data']['password_hash'] = password_hash($data['data']['password_hash'], PASSWORD_DEFAULT);
        }
        return $data;
    }

    // Verify password
    public function verifyPassword($password, $hash)
    {
        return password_verify($password, $hash);
    }
}