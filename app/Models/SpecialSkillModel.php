<?php

namespace App\Models;

use CodeIgniter\Model;

class SpecialSkillModel extends Model
{
    protected $table = 'special_skills';
    protected $primaryKey = 'id';
    protected $allowedFields = ['title', 'icon', 'description', 'details', 'display_order', 'is_active'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
}