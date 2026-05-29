<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Katalog Project Mahasiswa</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        .card-img-top {
            height: 200px;
            object-fit: cover;
        }
    </style>
</head>
<body>
<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <div class="container">
        <a class="navbar-brand" href="<?= base_url() ?>">CampusPortal</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="<?= base_url() ?>">Berita Kampus</a></li>
                <li class="nav-item"><a class="nav-link active" href="<?= base_url('projects') ?>">Katalog Project Mahasiswa</a></li>
            </ul>
            <ul class="navbar-nav">
                <?php if(logged_in()): ?>
                    <?php if(in_groups('admin')): ?>
                        <li class="nav-item"><a class="nav-link" href="<?= base_url('admin/post') ?>">Admin Area</a></li>
                    <?php elseif(in_groups('mahasiswa')): ?>
                        <li class="nav-item"><a class="nav-link" href="<?= base_url('student/projects') ?>">My Projects</a></li>
                    <?php endif; ?>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('logout') ?>">Logout</a></li>
                <?php else: ?>
                    <li class="nav-item"><a class="nav-link" href="<?= base_url('login') ?>">Login</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<div style="padding-top:70px;">
    <div class="p-5 mb-4 bg-light rounded-3 text-center">
        <div class="container py-5">
            <h1 class="display-5 fw-bold">Katalog Project Mahasiswa</h1>
            <p class="fs-4">Kumpulan karya dan tugas besar terbaik dari mahasiswa.</p>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <?php if(empty($projects)): ?>
                <div class="col-12 text-center"><p>Belum ada project yang dipublikasikan.</p></div>
            <?php else: ?>
                <?php foreach ($projects as $p) : ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm border-0">
                        <?php if(!empty($p['thumbnail'])): ?>
                            <img src="<?= base_url('uploads/projects/'.$p['thumbnail']) ?>" class="card-img-top" alt="<?= $p['title'] ?>">
                        <?php else: ?>
                            <img src="https://via.placeholder.com/400x200?text=No+Thumbnail" class="card-img-top" alt="No Thumbnail">
                        <?php endif; ?>
                        
                        <div class="card-body">
                            <span class="badge bg-primary mb-2"><?= $p['mata_kuliah'] ?></span>
                            <span class="badge bg-secondary mb-2">SMT <?= $p['semester'] ?></span>
                            <h5 class="card-title"><?= $p['title'] ?></h5>
                            <p class="text-muted small mb-2">Oleh: <?= $p['anggota_tim'] ?: $p['username'] ?></p>
                            <p class="card-text text-muted" style="font-size:0.9rem;"><?= substr(strip_tags($p['description']), 0, 100) ?>...</p>
                            <div class="mt-2">
                                <small class="text-muted fw-bold">Tech Stack:</small><br>
                                <small><?= $p['tech_stack'] ?: '-' ?></small>
                            </div>
                        </div>
                        <div class="card-footer bg-white border-top-0 d-flex justify-content-between align-items-center">
                            <div>
                                <?php if(!empty($p['github_url'])): ?>
                                    <a href="<?= $p['github_url'] ?>" target="_blank" class="btn btn-sm btn-outline-dark">GitHub</a>
                                <?php endif; ?>
                                <?php if(!empty($p['demo_url'])): ?>
                                    <a href="<?= $p['demo_url'] ?>" target="_blank" class="btn btn-sm btn-outline-success">Demo</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach ?>
            <?php endif; ?>
        </div>
    </div>

    <div class="container py-4">
        <footer class="pt-3 mt-4 text-muted border-top text-center">
            <div class="container">&copy; <?= Date('Y') ?> Portal Kampus</div>
        </footer>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
