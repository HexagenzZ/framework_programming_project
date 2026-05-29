<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Projects</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-expand-md navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="#">Mahasiswa Area</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="<?= base_url() ?>">Home Portal</a></li>
                <li class="nav-item"><a class="nav-link active" href="<?= base_url('student/projects') ?>">My Projects</a></li>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="<?= base_url('logout') ?>">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>My Submitted Projects</h2>
        <a href="<?= base_url('student/projects/create') ?>" class="btn btn-primary">Submit New Project</a>
    </div>

    <?php if (session()->getFlashdata('message')) : ?>
        <div class="alert alert-success"><?= session()->getFlashdata('message') ?></div>
    <?php endif; ?>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Title</th>
                <th>Mata Kuliah</th>
                <th>Status</th>
                <th>Catatan Admin</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php if(empty($projects)): ?>
                <tr><td colspan="6" class="text-center">Belum ada project yang disubmit.</td></tr>
            <?php else: ?>
                <?php $i=1; foreach($projects as $p): ?>
                <tr>
                    <td><?= $i++ ?></td>
                    <td><?= $p['title'] ?></td>
                    <td><?= $p['mata_kuliah'] ?> (SMT <?= $p['semester'] ?>)</td>
                    <td>
                        <?php if($p['status'] == 'pending'): ?>
                            <span class="badge bg-warning">Pending</span>
                        <?php elseif($p['status'] == 'approved'): ?>
                            <span class="badge bg-success">Approved</span>
                        <?php else: ?>
                            <span class="badge bg-danger">Rejected</span>
                        <?php endif; ?>
                    </td>
                    <td><?= $p['rejection_reason'] ?? '-' ?></td>
                    <td>
                        <?php if($p['status'] == 'rejected'): ?>
                            <a href="<?= base_url('student/projects/edit/' . $p['id']) ?>" class="btn btn-sm btn-warning">Revisi</a>
                        <?php endif; ?>
                        <button class="btn btn-sm btn-info">Detail</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>
