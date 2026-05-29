<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends BaseController
{
  public function login()
  {
    if (strtolower($this->request->getMethod()) === 'post') {
      $userModel = new UserModel();
      $email = $this->request->getPost('email');
      $password = $this->request->getPost('password');

      $user = $userModel->where('email', $email)->first();

      if ($user && password_verify((string)$password, $user['password_hash'])) {
        session()->set([
          'user_id' => $user['id'],
          'role' => $user['role'],
          'full_name' => $user['full_name'],
          'nim' => $user['nim']
        ]);

        if ($user['role'] === 'admin') {
          return redirect()->to('/admin/dashboard');
        } elseif ($user['role'] === 'mahasiswa') {
          return redirect()->to('/project');
        } else {
          return redirect()->to('/');
        }
      }

      return redirect()->back()->with('error', 'Email atau password salah.');
    }

    return view('auth/login');
  }

  public function register()
  {
    if (strtolower($this->request->getMethod()) === 'post') {
      $userModel = new UserModel();

      $validation = \Config\Services::validation();
      $validation->setRules([
        'username' => 'required|is_unique[custom_users.username]',
        'email' => 'required|valid_email|is_unique[custom_users.email]',
        'password' => 'required|min_length[6]',
        'full_name' => 'required'
      ]);

      if (!$validation->withRequest($this->request)->run()) {
        return redirect()->back()->withInput()->with('errors', $validation->getErrors());
      }

      $userModel->insert([
        'username' => $this->request->getPost('username'),
        'email' => $this->request->getPost('email'),
        'password_hash' => password_hash((string)$this->request->getPost('password'), PASSWORD_BCRYPT),
        'role' => 'mahasiswa',
        'full_name' => $this->request->getPost('full_name'),
        'nim' => $this->request->getPost('nim')
      ]);

      return redirect()->to('/auth/login')->with('success', 'Registrasi berhasil. Silakan login.');
    }

    return view('auth/register');
  }

  public function logout()
  {
    session()->destroy();
    return redirect()->to('/');
  }
}
