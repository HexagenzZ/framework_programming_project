<?php

namespace App\Controllers;

use App\Models\ProjectModel;
use App\Models\ProjectMemberModel;

class ProjectController extends BaseController
{
    private function _ensureDb()
    {
        $db = \Config\Database::connect();
        $forge = \Config\Database::forge();
        
        // Jika tabel ada tapi format lama (tanpa slug), drop paksa
        if ($db->tableExists('projects') && !$db->fieldExists('slug', 'projects')) {
            $db->query('SET FOREIGN_KEY_CHECKS=0');
            if ($db->tableExists('project_members')) {
                $db->query('DROP TABLE project_members');
            }
            $db->query('DROP TABLE projects');
            $db->query('SET FOREIGN_KEY_CHECKS=1');
        }
        
        // Cek jika tabel tidak ada, langsung paksa buat dari file migration
        if (!$db->tableExists('projects')) {
            require_once APPPATH . 'Database/Migrations/2026-05-03-192720_CreateProjectsNew.php';
            $mig1 = new \App\Database\Migrations\CreateProjectsNew($forge);
            $mig1->up();
        }
        
        if (!$db->tableExists('project_members')) {
            require_once APPPATH . 'Database/Migrations/2026-05-03-192804_CreateProjectMembers.php';
            $mig2 = new \App\Database\Migrations\CreateProjectMembers($forge);
            $mig2->up();
        }
    }

    public function index()
    {
        $this->_ensureDb();
        $projectModel = new ProjectModel();
        
        $query = $projectModel->getApproved();
        
        if ($tech = $this->request->getGet('tech')) {
            $query->like('tech_stack', $tech);
        }
        
        if ($semester = $this->request->getGet('semester')) {
            $query->where('semester', $semester);
        }
        
        $data['projects'] = $query->orderBy('projects.created_at', 'DESC')->findAll();
        
        return view('project/index', $data);
    }

    public function detail($slug)
    {
        $this->_ensureDb();
        $projectModel = new ProjectModel();
        $memberModel = new ProjectMemberModel();
        
        $project = $projectModel->select('projects.*, custom_users.full_name, custom_users.username')
                                ->join('custom_users', 'custom_users.id = projects.user_id')
                                ->where('slug', $slug)
                                ->first();
                                
        if (!$project) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
        
        $data['project'] = $project;
        $data['members'] = $memberModel->where('project_id', $project['id'])->findAll();
        
        return view('project/detail', $data);
    }

    public function myProjects()
    {
        $this->_ensureDb();
        $projectModel = new ProjectModel();
        $data['projects'] = $projectModel->where('user_id', session()->get('user_id'))
                                         ->orderBy('created_at', 'DESC')
                                         ->findAll();
                                         
        return view('project/my_projects', $data);
    }

    public function submit()
    {
        $this->_ensureDb();
        
        if (strtolower($this->request->getMethod()) === 'post') {
            $validation = \Config\Services::validation();
            $validation->setRules([
                'title'       => 'required',
                'description' => 'required',
                'mata_kuliah' => 'required',
                'semester'    => 'required|numeric',
                'thumbnail'   => 'uploaded[thumbnail]|max_size[thumbnail,2048]|is_image[thumbnail]|mime_in[thumbnail,image/jpg,image/jpeg,image/png]'
            ]);

            if (!$validation->withRequest($this->request)->run()) {
                return redirect()->back()->withInput()->with('errors', $validation->getErrors());
            }

            $file = $this->request->getFile('thumbnail');
            $fileName = $file->getRandomName();
            $file->move('uploads/projects', $fileName);

            $projectModel = new ProjectModel();
            
            $slug = url_title($this->request->getPost('title'), '-', true);
            // Ensure unique slug
            $existing = $projectModel->where('slug', $slug)->first();
            if ($existing) {
                $slug = $slug . '-' . time();
            }

            $projectId = $projectModel->insert([
                'user_id'     => session()->get('user_id'),
                'title'       => $this->request->getPost('title'),
                'slug'        => $slug,
                'description' => $this->request->getPost('description'),
                'github_url'  => $this->request->getPost('github_url'),
                'demo_url'    => $this->request->getPost('demo_url'),
                'tech_stack'  => $this->request->getPost('tech_stack'),
                'mata_kuliah' => $this->request->getPost('mata_kuliah'),
                'semester'    => $this->request->getPost('semester'),
                'thumbnail'   => $fileName,
                'status'      => 'pending'
            ]);

            // Save members if any
            $membersName = $this->request->getPost('members_name');
            $membersNim = $this->request->getPost('members_nim');
            $membersRole = $this->request->getPost('members_role');

            if (is_array($membersName)) {
                $memberModel = new ProjectMemberModel();
                foreach ($membersName as $index => $name) {
                    if (!empty($name)) {
                        $memberModel->insert([
                            'project_id'   => $projectId,
                            'name'         => $name,
                            'nim'          => $membersNim[$index] ?? null,
                            'role_in_team' => $membersRole[$index] ?? null
                        ]);
                    }
                }
            }

            return redirect()->to('/project/mine')->with('success', 'Project berhasil disubmit dan menunggu approval.');
        }

        return view('project/submit');
    }
}
