<?php

namespace App\Controllers;

use App\Models\ProjectModel;
use App\Models\ProjectMemberModel;

class ProjectAdminController extends BaseController
{
    public function index()
    {
        $projectModel = new ProjectModel();
        
        $query = $projectModel->select('projects.*, custom_users.username, custom_users.email')
                              ->join('custom_users', 'custom_users.id = projects.user_id');
                              
        if ($status = $this->request->getGet('status')) {
            $query->where('projects.status', $status);
        }
        
        $data['projects'] = $query->orderBy('projects.created_at', 'DESC')->findAll();
        
        return view('admin/project_list', $data);
    }

    public function approve($id)
    {
        $projectModel = new ProjectModel();
        $projectModel->update($id, ['status' => 'approved']);
        return redirect()->back()->with('success', 'Project berhasil di-approve.');
    }

    public function reject($id)
    {
        $projectModel = new ProjectModel();
        $projectModel->update($id, ['status' => 'rejected']);
        return redirect()->back()->with('success', 'Project berhasil di-reject.');
    }

    public function delete($id)
    {
        $projectModel = new ProjectModel();
        $project = $projectModel->find($id);
        
        if ($project) {
            // Delete file
            if (!empty($project['thumbnail']) && file_exists('uploads/projects/' . $project['thumbnail'])) {
                unlink('uploads/projects/' . $project['thumbnail']);
            }
            
            // Delete project (members will be deleted via cascade FK)
            $projectModel->delete($id);
            return redirect()->back()->with('success', 'Project berhasil dihapus.');
        }
        
        return redirect()->back()->with('error', 'Project tidak ditemukan.');
    }
}
