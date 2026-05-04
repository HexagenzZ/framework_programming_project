<?php /* app/Views/admin/layout.php */ ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - Kampus Portal</title>
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
            --pill-bg: #E1F5FE;
            --pill-text: #0288D1;
        }
        [data-bs-theme="dark"] {
            --bg-color: #121212;
            --card-bg: #1E1E1E;
            --border-color: #333333;
            --accent-color: #00BFA5;
            --accent-hover: #00897B;
            --text-main: #E0E0E0;
            --text-muted: #AAAAAA;
            --pill-bg: #004D40;
            --pill-text: #64FFDA;
        }
        
        body { background-color: var(--bg-color); color: var(--text-main); font-size: 14px; font-family: system-ui, -apple-system, sans-serif; display: flex; min-height: 100vh; }
        .text-accent { color: var(--accent-color) !important; }
        .bg-accent { background-color: var(--accent-color) !important; color: white; }
        .btn-primary { background-color: var(--accent-color); border-color: var(--accent-color); color: white; }
        .btn-primary:hover { background-color: var(--accent-hover); border-color: var(--accent-hover); color: white; }
        .card { background-color: var(--card-bg); border: 1px solid var(--border-color); border-radius: 12px; box-shadow: none; color: var(--text-main); }
        
        .sidebar { width: 220px; background: var(--card-bg); border-right: 1px solid var(--border-color); flex-shrink: 0; display: flex; flex-direction: column; }
        .sidebar .nav-link { color: var(--text-main); font-weight: 500; padding: 12px 20px; border-radius: 0; border-left: 3px solid transparent; }
        .sidebar .nav-link:hover { background: var(--bg-color); color: var(--accent-color); }
        .sidebar .nav-link.active { background: var(--pill-bg); color: var(--accent-color); border-left-color: var(--accent-color); }
        
        .main-content { flex-grow: 1; padding: 28px; background: var(--bg-color); }
        .section-heading { font-size: 13px; text-transform: uppercase; letter-spacing: 1px; font-weight: 600; color: var(--text-muted); }
        
        /* Dark Mode Overrides */
        [data-bs-theme="dark"] .bg-white { background-color: var(--card-bg) !important; }
        [data-bs-theme="dark"] .text-dark { color: var(--text-main) !important; }
        [data-bs-theme="dark"] .text-muted { color: var(--text-muted) !important; }
        [data-bs-theme="dark"] .bg-light { background-color: #2D2D2D !important; }
        [data-bs-theme="dark"] .border-bottom, [data-bs-theme="dark"] .border-top, [data-bs-theme="dark"] .border { border-color: var(--border-color) !important; }
        [data-bs-theme="dark"] .table { --bs-table-bg: transparent; --bs-table-color: var(--text-main); border-color: var(--border-color); }
        [data-bs-theme="dark"] .table-light { --bs-table-bg: #2D2D2D; --bs-table-color: var(--text-main); border-bottom-color: var(--border-color); }
        [data-bs-theme="dark"] .table-light th { color: var(--text-muted) !important; }
        [data-bs-theme="dark"] .form-control, [data-bs-theme="dark"] .form-select { background-color: #2D2D2D; border-color: var(--border-color); color: var(--text-main); }
        [data-bs-theme="dark"] .form-control:focus, [data-bs-theme="dark"] .form-select:focus { background-color: #2D2D2D; color: var(--text-main); border-color: var(--accent-color); }
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

<div class="sidebar">
    <div class="p-3 mb-3 border-bottom text-center">
        <a href="<?= base_url() ?>" class="fs-5 fw-bold text-accent text-decoration-none">Nuansa</a>
        <div class="small text-muted mt-1">Admin Panel</div>
        <button onclick="toggleTheme()" class="btn btn-sm btn-outline-secondary mt-3 rounded-pill w-100">Toggle Theme 🌓</button>
    </div>
    
    <nav class="nav flex-column mb-auto">
        <a href="<?= base_url('admin/dashboard') ?>" class="nav-link <?= strpos(current_url(), base_url('admin/dashboard')) === 0 || current_url() == base_url('admin') ? 'active' : '' ?>">Dashboard</a>
        <a href="<?= base_url('admin/post') ?>" class="nav-link <?= strpos(current_url(), base_url('admin/post')) === 0 ? 'active' : '' ?>">Kelola Berita</a>
        <a href="<?= base_url('admin/project') ?>" class="nav-link <?= strpos(current_url(), base_url('admin/project')) === 0 ? 'active' : '' ?>">Kelola Project</a>
    </nav>
    
    <div class="p-3 border-top mt-auto">
        <div class="fw-medium mb-2"><?= esc(current_user()['full_name'] ?? 'Admin') ?></div>
        <a href="<?= base_url('auth/logout') ?>" class="btn btn-sm btn-outline-danger w-100">Logout</a>
    </div>
</div>

<div class="main-content">
    <?= $content ?? '' ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
