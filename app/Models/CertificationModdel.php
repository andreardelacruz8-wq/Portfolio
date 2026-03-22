<?php

namespace App\Models;

use CodeIgniter\Model;

class CertificationModel extends Model
{
    protected $table = 'certifications';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'title',
        'issuer',
        'issue_date',
        'expiry_date',
        'credential_id',
        'rating',
        'pdf_path',
        'icon',
        'description',
        'display_order'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    // Validation
    protected $validationRules = [
        'title' => 'required|min_length[3]|max_length[255]',
        'issuer' => 'required|min_length[3]|max_length[255]',
        'issue_date' => 'permit_empty|valid_date',
        'expiry_date' => 'permit_empty|valid_date',
        'credential_id' => 'permit_empty|max_length[100]',
        'rating' => 'permit_empty|max_length[50]',
        'pdf_path' => 'permit_empty|max_length[500]',
        'icon' => 'permit_empty|max_length[50]',
        'description' => 'permit_empty',
        'display_order' => 'permit_empty|integer'
    ];
    
    protected $validationMessages = [];
    protected $skipValidation = false;

    /**
     * Get certifications ordered by display order and issue date
     */
    public function getOrderedCertifications()
    {
        return $this->orderBy('display_order ASC, issue_date DESC')->findAll();
    }

    /**
     * Get certification with PDF path
     */
    public function getWithPdf($id)
    {
        return $this->select('id, title, issuer, issue_date, expiry_date, credential_id, rating, pdf_path, icon, description, display_order')
                    ->find($id);
    }

    /**
     * Delete certification and return PDF path
     */
    public function deleteWithPdf($id)
    {
        // Get PDF path before deleting
        $cert = $this->select('pdf_path')->find($id);
        $pdfPath = $cert ? $cert['pdf_path'] : null;
        
        // Delete the record
        $this->delete($id);
        
        return $pdfPath;
    }

    /**
     * Count certifications by issuer
     */
    public function countByIssuer($issuer)
    {
        return $this->where('issuer', $issuer)->countAllResults();
    }

    /**
     * Search certifications by title or issuer
     */
    public function search($keyword)
    {
        return $this->like('title', $keyword)
                    ->orLike('issuer', $keyword)
                    ->orLike('description', $keyword)
                    ->orderBy('display_order ASC, issue_date DESC')
                    ->findAll();
    }
}