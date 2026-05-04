<?php

namespace App\Controllers;

use App\Models\PostModel;
use App\Models\ProjectModel;
use App\Models\UserModel;

class AdminDashboard extends BaseController
{
  public function index()
  {
    $postModel = new PostModel();
    $projectModel = new ProjectModel();
    $userModel = new UserModel();

    $data = [
      'total_posts'      => $postModel->countAllResults(),
      'total_projects'   => $projectModel->countAllResults(),
      'total_users'      => $userModel->countAllResults(),
      'pending_projects' => $projectModel->where('status', 'pending')->countAllResults(),
      'pending_list'     => $projectModel->select('projects.*, custom_users.full_name, custom_users.username')
        ->join('custom_users', 'custom_users.id = projects.user_id')
        ->where('projects.status', 'pending')
        ->orderBy('projects.created_at', 'ASC')
        ->limit(10)
        ->find()
    ];

    return view('admin/dashboard', $data);
  }
}
