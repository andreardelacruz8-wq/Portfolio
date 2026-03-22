<?php

namespace App\Models;

use CodeIgniter\Model;

class HobbyModel extends Model
{
    protected $table = 'hobbies';
    protected $primaryKey = 'id';
    protected $allowedFields = ['title', 'icon', 'description', 'favorite', 'display_order', 'is_active'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
}