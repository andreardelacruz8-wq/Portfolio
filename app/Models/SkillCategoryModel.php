<?php

namespace App\Models;

use CodeIgniter\Model;

class SkillCategoryModel extends Model
{
    protected $table = 'skill_categories';
    protected $primaryKey = 'id';
    protected $allowedFields = ['name', 'display_order'];
}