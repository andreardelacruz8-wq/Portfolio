<?php

namespace App\Models;

use CodeIgniter\Model;

class AchievementModel extends Model
{
    protected $table = 'achievements';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'education_id', 'achievement_icon', 
        'achievement_title', 'achievement_year', 'achievement_description'
    ];
    
    protected $useTimestamps = false;
}