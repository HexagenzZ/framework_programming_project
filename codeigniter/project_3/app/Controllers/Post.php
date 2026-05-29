<?php
namespace App\Controllers;

use App\Models\PostModel;
use App\Models\CategoryModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Post extends BaseController
{
    public function index()
    {
        $post = new PostModel();
        $category = new CategoryModel();
        
        $data['categories'] = $category->findAll();
        
        // Cek jika ada filter kategori
        $categoryId = $this->request->getGet('category');
        
        $post->select('posts.*, categories.name as category_name')
             ->join('categories', 'categories.id = posts.category_id', 'left')
             ->where('posts.status', 'published');
             
        if ($categoryId) {
            $post->where('posts.category_id', $categoryId);
        }
        
        $data['posts'] = $post->orderBy('posts.created_at', 'DESC')->findAll();
        echo view('post', $data);
    }

    public function viewPost($slug)
    {
        $post = new PostModel();
        $data['post'] = $post->select('posts.*, categories.name as category_name')
             ->join('categories', 'categories.id = posts.category_id', 'left')
             ->where([
            'posts.slug'   => $slug,
            'posts.status' => 'published'
        ])->first();

        if (!$data['post']) {
            throw PageNotFoundException::forPageNotFound();
        }

        echo view('post_detail', $data);
    }
}
