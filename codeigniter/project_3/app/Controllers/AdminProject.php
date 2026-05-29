<?php

namespace App\Controllers;

use App\Models\ProjectModel;

class AdminProject extends BaseController
{
  public function index()
  {
    $projectModel = new ProjectModel();

    // Fetch all projects, perhaps join with users table to get username
    $data['projects'] = $projectModel->select('projects.*, users.username, users.email')
      ->join('users', 'users.id = projects.user_id', 'left')
      ->orderBy('projects.created_at', 'DESC')
      ->findAll();

    return view('admin/project_approval', $data);
  }

  public function approve($id)
  {
    $projectModel = new ProjectModel();
    $projectModel->update($id, [
      'status' => 'approved',
      'rejection_reason' => null
    ]);
    return redirect()->back()->with('message', 'Project berhasil di-approve.');
  }

  public function reject($id)
  {
    $projectModel = new ProjectModel();
    $reason = $this->request->getPost('rejection_reason');

    $projectModel->update($id, [
      'status' => 'rejected',
      'rejection_reason' => $reason
    ]);
    return redirect()->back()->with('message', 'Project dikembalikan untuk revisi.');
  }
}
