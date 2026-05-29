<?php

namespace App\Models;

use CodeIgniter\Model;

class ProjectModel extends Model
{
    protected $table            = 'projects';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'user_id', 'title', 'slug', 'description', 'thumbnail', 
        'github_url', 'demo_url', 'tech_stack', 'mata_kuliah', 
        'semester', 'status'
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getApproved()
    {
        return $this->select('projects.*, custom_users.full_name, custom_users.username')
                    ->join('custom_users', 'custom_users.id = projects.user_id')
                    ->where('projects.status', 'approved');
    }
}
