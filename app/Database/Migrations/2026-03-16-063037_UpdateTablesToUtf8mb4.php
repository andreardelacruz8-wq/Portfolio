<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateTablesToUtf8mb4 extends Migration
{
    public function up()
    {
        // Update database character set
        $this->db->query("ALTER DATABASE `cozy_portfolio` CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci");
        
        // Update existing tables
        $tables = ['education', 'coursework', 'achievements', 'work_experience', 'soft_skills'];
        
        foreach ($tables as $table) {
            $this->db->query("ALTER TABLE `{$table}` CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        }
        
        // Update specific columns for emoji support
        $this->db->query("ALTER TABLE `achievements` MODIFY `achievement_icon` VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        $this->db->query("ALTER TABLE `soft_skills` MODIFY `icon` VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    }

    public function down()
    {
        // Revert back to utf8 (if needed)
        $this->db->query("ALTER DATABASE `cozy_portfolio` CHARACTER SET = utf8 COLLATE = utf8_general_ci");
        
        $tables = ['education', 'coursework', 'achievements', 'work_experience', 'soft_skills'];
        
        foreach ($tables as $table) {
            $this->db->query("ALTER TABLE `{$table}` CONVERT TO CHARACTER SET utf8 COLLATE utf8_general_ci");
        }
    }
}