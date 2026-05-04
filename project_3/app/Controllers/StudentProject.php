<?php

namespace App\Controllers;

use App\Models\ProjectModel;

class StudentProject extends BaseController
{
    public function index()
    {
        $projectModel = new ProjectModel();
        // Assume user is logged in via MythAuth
        $userId = user_id(); 
        
        $data['projects'] = $projectModel->where('user_id', $userId)->findAll();
        
        return view('student/project_list', $data);
    }

    public function create()
    {
        return view('student/project_form');
    }

    public function store()
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'title'       => 'required',
            'description' => 'required',
            'thumbnail'   => 'uploaded[thumbnail]|max_size[thumbnail,2048]|is_image[thumbnail]|mime_in[thumbnail,image/jpg,image/jpeg,image/png]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $file = $this->request->getFile('thumbnail');
        $fileName = $file->getRandomName();
        $file->move('uploads/projects', $fileName);

        $projectModel = new ProjectModel();
        $projectModel->insert([
            'user_id'     => user_id(),
            'title'       => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'github_url'  => $this->request->getPost('github_url'),
            'demo_url'    => $this->request->getPost('demo_url'),
            'tech_stack'  => $this->request->getPost('tech_stack'),
            'anggota_tim' => $this->request->getPost('anggota_tim'),
            'semester'    => $this->request->getPost('semester'),
            'mata_kuliah' => $this->request->getPost('mata_kuliah'),
            'thumbnail'   => $fileName,
            'status'      => 'pending' // default status
        ]);

        return redirect()->to('/student/projects')->with('message', 'Project berhasil disubmit dan menunggu persetujuan admin.');
    }

    public function edit($id)
    {
        $projectModel = new ProjectModel();
        $data['project'] = $projectModel->where(['id' => $id, 'user_id' => user_id()])->first();

        if (!$data['project']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view('student/project_form', $data);
    }

    public function update($id)
    {
        $projectModel = new ProjectModel();
        $project = $projectModel->where(['id' => $id, 'user_id' => user_id()])->first();

        if (!$project) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $validation = \Config\Services::validation();
        $rules = [
            'title'       => 'required',
            'description' => 'required',
        ];

        $file = $this->request->getFile('thumbnail');
        if ($file->isValid() && !$file->hasMoved()) {
             $rules['thumbnail'] = 'max_size[thumbnail,2048]|is_image[thumbnail]|mime_in[thumbnail,image/jpg,image/jpeg,image/png]';
        }

        if (!$validation->withRequest($this->request)->run($rules)) {
            return redirect()->back()->withInput()->with('errors', $validation->getErrors());
        }

        $updateData = [
            'title'       => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'github_url'  => $this->request->getPost('github_url'),
            'demo_url'    => $this->request->getPost('demo_url'),
            'tech_stack'  => $this->request->getPost('tech_stack'),
            'anggota_tim' => $this->request->getPost('anggota_tim'),
            'semester'    => $this->request->getPost('semester'),
            'mata_kuliah' => $this->request->getPost('mata_kuliah'),
            'status'      => 'pending' // Reset to pending after edit
        ];

        if ($file->isValid() && !$file->hasMoved()) {
            $fileName = $file->getRandomName();
            $file->move('uploads/projects', $fileName);
            $updateData['thumbnail'] = $fileName;
        }

        $projectModel->update($id, $updateData);

        return redirect()->to('/student/projects')->with('message', 'Project berhasil diperbarui dan disubmit ulang.');
    }
}
