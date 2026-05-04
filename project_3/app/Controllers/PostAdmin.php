<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\PostModel;
use App\Models\CategoryModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class PostAdmin extends BaseController
{
    public function index()
    {
        $post = new PostModel();
        // Join with categories to get category name
        $data['posts'] = $post->select('posts.*, categories.name as category_name')
                              ->join('categories', 'categories.id = posts.category_id', 'left')
                              ->findAll();
        echo view('admin/post_list', $data);
    }

    //--------------------------------------------------------------

    public function preview($id)
    {
        $post = new PostModel();
        $data['post'] = $post->select('posts.*, categories.name as category_name')
                             ->join('categories', 'categories.id = posts.category_id', 'left')
                             ->where('posts.id', $id)->first();

        if(!$data['post']){
            throw PageNotFoundException::forPageNotFound();
        }
        echo view('post_detail', $data);
    }

    //--------------------------------------------------------------

    public function create()
    {
        $categoryModel = new CategoryModel();
        $data['categories'] = $categoryModel->findAll();

        // lakukan validasi
        $validation =  \Config\Services::validation();
        $validation->setRules([
            'title' => 'required',
            'category_id' => 'required|integer',
            'image' => 'uploaded[image]|max_size[image,1024]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png]'
        ]);
        $isDataValid = $validation->withRequest($this->request)->run();

        // jika data valid, simpan ke database
        if($isDataValid){
            $file = $this->request->getFile('image');
            $fileName = $file->getRandomName();
            $file->move('uploads', $fileName); // moves to public/uploads

            $post = new PostModel();
            $post->insert([
                "title" => $this->request->getPost('title'),
                "content" => $this->request->getPost('content'),
                "status" => $this->request->getPost('status'),
                "slug" => url_title($this->request->getPost('title'), '-', TRUE),
                "category_id" => $this->request->getPost('category_id'),
                "image" => $fileName,
                "sumber_berita" => $this->request->getPost('sumber_berita'),
                "is_featured" => $this->request->getPost('is_featured') ? 1 : 0
            ]);
            return redirect('admin/post');
        }

        // tampilkan form create
        echo view('admin/post_create', $data);
    }

    //--------------------------------------------------------------

    public function edit($id)
    {
        // ambil artikel yang akan diedit
        $post = new PostModel();
        $data['post'] = $post->where('id', $id)->first();

        $categoryModel = new CategoryModel();
        $data['categories'] = $categoryModel->findAll();

        // lakukan validasi data artikel
        $validation =  \Config\Services::validation();
        $validation->setRules([
            'id' => 'required',
            'title' => 'required',
            'category_id' => 'required|integer',
            'image' => 'max_size[image,1024]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png]'
        ]);
        $isDataValid = $validation->withRequest($this->request)->run();

        // jika data valid, simpan ke database
        if($isDataValid){
            $updateData = [
                "title" => $this->request->getPost('title'),
                "content" => $this->request->getPost('content'),
                "status" => $this->request->getPost('status'),
                "category_id" => $this->request->getPost('category_id'),
                "sumber_berita" => $this->request->getPost('sumber_berita'),
                "is_featured" => $this->request->getPost('is_featured') ? 1 : 0
            ];

            // cek jika ada file yang diupload
            $file = $this->request->getFile('image');
            if ($file->isValid() && !$file->hasMoved()) {
                $fileName = $file->getRandomName();
                $file->move('uploads', $fileName);
                $updateData['image'] = $fileName;
                
                // Optional: Delete old image
                // if (!empty($data['post']['image']) && file_exists('uploads/' . $data['post']['image'])) {
                //     unlink('uploads/' . $data['post']['image']);
                // }
            }

            $post->update($id, $updateData);
            return redirect('admin/post');
        }

        // tampilkan form edit
        echo view('admin/post_update', $data);
    }

    //--------------------------------------------------------------

    public function delete($id)
    {
        $post = new PostModel();
        $postData = $post->find($id);
        
        // delete old image
        if ($postData && !empty($postData['image']) && file_exists('uploads/' . $postData['image'])) {
            unlink('uploads/' . $postData['image']);
        }

        $post->delete($id);
        return redirect('admin/post');
    }
}
