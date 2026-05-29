<?php /* app/Views/auth/login.php */ ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Kampus Portal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root, [data-bs-theme="light"] {
            --bg-color: #F0F8FF;
            --card-bg: #ffffff;
            --border-color: #E1F5FE;
            --accent-color: #0288D1;
            --accent-hover: #01579B;
            --text-main: #333333;
            --text-muted: #6c757d;
        }
        [data-bs-theme="dark"] {
            --bg-color: #121212;
            --card-bg: #1E1E1E;
            --border-color: #333333;
            --accent-color: #00BFA5;
            --accent-hover: #00897B;
            --text-main: #E0E0E0;
            --text-muted: #AAAAAA;
        }
        
        body { background-color: var(--bg-color); color: var(--text-main); font-size: 14px; font-family: system-ui, -apple-system, sans-serif; display: flex; align-items: center; justify-content: center; min-height: 100vh; position: relative; }
        .text-accent { color: var(--accent-color) !important; }
        .btn-primary { background-color: var(--accent-color); border-color: var(--accent-color); padding: 10px; font-weight: 500; color: white; }
        .btn-primary:hover { background-color: var(--accent-hover); border-color: var(--accent-hover); color: white; }
        .card { background-color: var(--card-bg); border: 1px solid var(--border-color); border-radius: 12px; box-shadow: none; width: 100%; max-width: 400px; padding: 20px; color: var(--text-main); }
        
        [data-bs-theme="dark"] .form-control { background-color: #2D2D2D; border-color: var(--border-color); color: var(--text-main); }
        [data-bs-theme="dark"] .form-control:focus { background-color: #2D2D2D; color: var(--text-main); border-color: var(--accent-color); }
        [data-bs-theme="dark"] .text-muted { color: var(--text-muted) !important; }
    </style>
    <script>
        const savedTheme = localStorage.getItem('theme') || 'light';
        document.documentElement.setAttribute('data-bs-theme', savedTheme);
        function toggleTheme() {
            const current = document.documentElement.getAttribute('data-bs-theme');
            const next = current === 'light' ? 'dark' : 'light';
            document.documentElement.setAttribute('data-bs-theme', next);
            localStorage.setItem('theme', next);
        }
    </script>
</head>
<body>
<button onclick="toggleTheme()" class="btn btn-sm btn-outline-secondary rounded-circle" style="position: absolute; top: 20px; right: 20px; width: 40px; height: 40px; padding: 0; display:flex; align-items:center; justify-content:center;">
    <span style="font-size: 18px;">🌓</span>
</button>
<div class="card">
    <h3 class="text-center fw-bold text-accent mb-4">Kampus Portal</h3>
    
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= esc($error) ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= esc(session()->getFlashdata('error')) ?></div>
    <?php endif; ?>
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"><?= esc(session()->getFlashdata('success')) ?></div>
    <?php endif; ?>

    <form action="<?= base_url('auth/login') ?>" method="post">
        <div class="mb-3">
            <label class="form-label text-muted">Email</label>
            <input type="email" name="email" class="form-control" placeholder="contoh@kampus.ac.id" required>
        </div>
        <div class="mb-4">
            <label class="form-label text-muted">Password</label>
            <input type="password" name="password" class="form-control" placeholder="••••••••" required>
        </div>
        <button type="submit" class="btn btn-primary w-100 mb-3">Masuk</button>
    </form>
    
    <div class="text-center">
        <span class="text-muted">Belum punya akun?</span> <a href="<?= base_url('auth/register') ?>" class="text-accent text-decoration-none fw-bold">Daftar di sini</a>
    </div>
</div>
</body>
</html>
