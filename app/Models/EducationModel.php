<?php

namespace App\Models;

use CodeIgniter\Model;

class EducationModel extends Model
{
    protected $table = 'education';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'degree', 'school', 'location', 'start_date', 
        'end_date', 'gpa', 'description', 'display_order'
    ];
    protected $useTimestamps = false;
    protected $createdField = 'created_at';
    protected $updatedField = '';
    protected $dateFormat = 'datetime';
}