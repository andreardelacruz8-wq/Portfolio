<?php

namespace App\Models;

use CodeIgniter\Model;

class WorkExperienceModel extends Model
{
    protected $table = 'work_experience';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'position', 'company', 'location', 'start_date', 
        'end_date', 'current_job', 'description', 'technologies', 'display_order'
    ];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = ''; // No updated_at column
    protected $dateFormat = 'datetime';
}