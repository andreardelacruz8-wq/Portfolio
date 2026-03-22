<?php

namespace App\Models;

use CodeIgniter\Model;

class SoftSkillModel extends Model
{
    protected $table = 'soft_skills';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'title', 'icon', 'description', 'examples', 'display_order'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = ''; // No updated_at column
    protected $dateFormat = 'datetime';
}