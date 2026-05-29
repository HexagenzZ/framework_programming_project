<?php

namespace App\Controllers;

use App\Models\PostModel;
use App\Models\CategoryModel;

class Home extends BaseController
{
  public function index()
  {
    $postModel = new PostModel();
    $categoryModel = new CategoryModel();

    $data['categories'] = $categoryModel->findAll();

    // Featured Post
    $data['featured'] = $postModel->select('posts.*, categories.name as category_name')
      ->join('categories', 'categories.id = posts.category_id', 'left')
      ->where('posts.status', 'published')
      ->where('posts.is_featured', 1)
      ->orderBy('posts.created_at', 'DESC')
      ->first();

    // Regular Posts
    $query = $postModel->select('posts.*, categories.name as category_name')
      ->join('categories', 'categories.id = posts.category_id', 'left')
      ->where('posts.status', 'published');

    if ($data['featured']) {
      $query->where('posts.id !=', $data['featured']['id']);
    }

    if ($category = $this->request->getGet('category')) {
      $query->where('posts.category_id', $category);
    }

    $data['posts'] = $query->orderBy('posts.created_at', 'DESC')->findAll(6);

    return view('home', $data);
  }
}
