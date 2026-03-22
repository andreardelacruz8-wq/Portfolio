<?php

namespace App\Models;

use CodeIgniter\Model;

class CourseworkModel extends Model
{
    protected $table = 'coursework';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = ['education_id', 'course_name'];
    
    protected $useTimestamps = false;
}