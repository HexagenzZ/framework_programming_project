<!-- app/Views/partials/navbar.php -->
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= esc($title ?? 'Kampus Portal') ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    :root,
    [data-bs-theme="light"] {
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

    body {
      background-color: var(--bg-color);
      color: var(--text-main);
      font-size: 14px;
      font-family: system-ui, -apple-system, sans-serif;
    }

    .text-accent {
      color: var(--accent-color) !important;
    }

    .bg-accent {
      background-color: var(--accent-color) !important;
      color: white;
    }

    .btn-primary {
      background-color: var(--accent-color);
      border-color: var(--accent-color);
      color: white;
    }

    .btn-primary:hover {
      background-color: var(--accent-hover);
      border-color: var(--accent-hover);
      color: white;
    }

    .card {
      background-color: var(--card-bg);
      border: 1px solid var(--border-color);
      border-radius: 12px;
      box-shadow: none;
      color: var(--text-main);
    }

    .section-heading {
      font-size: 13px;
      text-transform: uppercase;
      letter-spacing: 1px;
      font-weight: 600;
      color: var(--text-muted);
    }

    .pill-chip {
      display: inline-block;
      padding: 6px 16px;
      border-radius: 50px;
      background: var(--card-bg);
      border: 1px solid var(--border-color);
      color: var(--text-main);
      text-decoration: none;
      margin-right: 8px;
      margin-bottom: 8px;
    }

    .pill-chip.active {
      background: var(--accent-color);
      color: white;
      border-color: var(--accent-color);
    }

    .pill-stack {
      background: var(--pill-bg);
      color: var(--pill-text);
      padding: 4px 12px;
      border-radius: 50px;
      font-size: 12px;
      display: inline-block;
      margin-right: 4px;
      margin-bottom: 4px;
    }

    /* Dark Mode Overrides */
    [data-bs-theme="dark"] .bg-white {
      background-color: var(--card-bg) !important;
    }

    [data-bs-theme="dark"] .text-dark {
      color: var(--text-main) !important;
    }

    [data-bs-theme="dark"] .text-muted {
      color: var(--text-muted) !important;
    }

    [data-bs-theme="dark"] .bg-light {
      background-color: #2D2D2D !important;
    }

    [data-bs-theme="dark"] .border-bottom,
    [data-bs-theme="dark"] .border-top,
    [data-bs-theme="dark"] .border {
      border-color: var(--border-color) !important;
    }

    [data-bs-theme="dark"] .table {
      --bs-table-bg: transparent;
      --bs-table-color: var(--text-main);
      border-color: var(--border-color);
    }

    [data-bs-theme="dark"] .table-light {
      --bs-table-bg: #2D2D2D;
      --bs-table-color: var(--text-main);
    }

    [data-bs-theme="dark"] .form-control,
    [data-bs-theme="dark"] .form-select {
      background-color: #2D2D2D;
      border-color: var(--border-color);
      color: var(--text-main);
    }

    [data-bs-theme="dark"] .form-control:focus,
    [data-bs-theme="dark"] .form-select:focus {
      background-color: #2D2D2D;
      color: var(--text-main);
      border-color: var(--accent-color);
    }

    [data-bs-theme="dark"] .navbar {
      background-color: var(--card-bg) !important;
      border-bottom: 1px solid var(--border-color) !important;
    }

    [data-bs-theme="dark"] .dropdown-menu {
      background-color: var(--card-bg);
      border-color: var(--border-color);
    }

    [data-bs-theme="dark"] .dropdown-item {
      color: var(--text-main);
    }

    [data-bs-theme="dark"] .dropdown-item:hover {
      background-color: var(--border-color);
    }
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
  <nav class="navbar navbar-expand-lg bg-white border-bottom py-3">
    <div class="container">
      <a class="navbar-brand fw-bold text-accent" href="<?= base_url() ?>">Nuansa</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navMenu">
        <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
          <li class="nav-item">
            <a class="nav-link <?= current_url() == base_url() ? 'active fw-bold text-accent' : '' ?>" href="<?= base_url() ?>">Beranda</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= strpos(current_url(), base_url('berita')) === 0 ? 'active fw-bold text-accent' : '' ?>" href="<?= base_url('berita') ?>">Berita</a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= strpos(current_url(), base_url('project')) === 0 ? 'active fw-bold text-accent' : '' ?>" href="<?= base_url('project') ?>">Project</a>
          </li>
        </ul>
        <div class="d-flex align-items-center">
          <button onclick="toggleTheme()" class="btn btn-outline-secondary rounded-circle me-3 d-flex align-items-center justify-content-center" style="width: 34px; height: 34px; padding: 0; border-color: var(--border-color); color: var(--text-main);">
            <span style="font-size: 16px; line-height: 1; margin-top: -2px;">🌓</span>
          </button>
          <?php if (logged_in()): ?>
            <div class="nav-item dropdown d-flex align-items-center">
              <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" style="padding: 0; color: var(--text-main);">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16" style="margin-right: 4px;">
                  <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
                  <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z" />
                </svg>
              </a>
              <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2">
                <li class="px-3 py-2 border-bottom mb-2">
                  <div class="small text-muted">Login sebagai</div>
                  <div class="fw-bold" style="color: var(--text-main);"><?= esc(current_user()['full_name']) ?></div>
                </li>
                <?php if (has_role('admin')): ?>
                  <li><a class="dropdown-item" href="<?= base_url('admin/post') ?>">Admin Panel</a></li>
                <?php elseif (has_role('mahasiswa')): ?>
                  <li><a class="dropdown-item" href="<?= base_url('project/mine') ?>">My Projects</a></li>
                <?php endif; ?>
                <li>
                  <hr class="dropdown-divider">
                </li>
                <li><a class="dropdown-item text-danger" href="<?= base_url('auth/logout') ?>">Logout</a></li>
              </ul>
            </div>
          <?php else: ?>
            <a href="<?= base_url('auth/login') ?>" class="btn btn-outline-secondary me-2">Login</a>
            <a href="<?= base_url('auth/register') ?>" class="btn btn-primary">Daftar</a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </nav>
