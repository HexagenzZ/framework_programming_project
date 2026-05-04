<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Approval Projects - Admin</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-expand-md navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="#">Admin Area</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="<?= base_url('admin/post') ?>">Berita Kampus</a></li>
                <li class="nav-item"><a class="nav-link active" href="<?= base_url('admin/projects') ?>">Approval Project</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container-fluid px-5">
    <h2>Approval Project Mahasiswa</h2>
    <?php if (session()->getFlashdata('message')) : ?>
        <div class="alert alert-success"><?= session()->getFlashdata('message') ?></div>
    <?php endif; ?>

    <div class="table-responsive">
        <table class="table table-bordered table-striped mt-3">
            <thead>
                <tr>
                    <th>Waktu Submit</th>
                    <th>Mahasiswa</th>
                    <th>Judul Project</th>
                    <th>Mata Kuliah (SMT)</th>
                    <th>Tech Stack</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if(empty($projects)): ?>
                    <tr><td colspan="7" class="text-center">Belum ada project.</td></tr>
                <?php else: ?>
                    <?php foreach($projects as $p): ?>
                    <tr>
                        <td><?= date('d M Y H:i', strtotime($p['created_at'])) ?></td>
                        <td><?= $p['username'] ?> (<?= $p['email'] ?>)</td>
                        <td>
                            <strong><?= $p['title'] ?></strong><br>
                            <small><a href="<?= $p['github_url'] ?>" target="_blank">GitHub</a> | <a href="<?= $p['demo_url'] ?>" target="_blank">Demo</a></small>
                        </td>
                        <td><?= $p['mata_kuliah'] ?> (<?= $p['semester'] ?>)</td>
                        <td><?= $p['tech_stack'] ?></td>
                        <td>
                            <?php if($p['status'] == 'pending'): ?>
                                <span class="badge bg-warning">Pending</span>
                            <?php elseif($p['status'] == 'approved'): ?>
                                <span class="badge bg-success">Approved</span>
                            <?php else: ?>
                                <span class="badge bg-danger">Rejected</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if($p['status'] == 'pending' || $p['status'] == 'rejected'): ?>
                                <a href="<?= base_url('admin/projects/approve/' . $p['id']) ?>" class="btn btn-sm btn-success mb-1">Approve</a>
                            <?php endif; ?>
                            
                            <?php if($p['status'] == 'pending' || $p['status'] == 'approved'): ?>
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn-sm btn-danger mb-1" data-bs-toggle="modal" data-bs-target="#rejectModal<?= $p['id'] ?>">
                                  Reject / Revisi
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="rejectModal<?= $p['id'] ?>" tabindex="-1">
                                  <div class="modal-dialog">
                                    <div class="modal-content">
                                      <form action="<?= base_url('admin/projects/reject/' . $p['id']) ?>" method="POST">
                                          <div class="modal-header">
                                            <h5 class="modal-title">Alasan Penolakan / Revisi</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                          </div>
                                          <div class="modal-body">
                                            <div class="mb-3">
                                                <label>Catatan untuk mahasiswa:</label>
                                                <textarea name="rejection_reason" class="form-control" rows="3" required></textarea>
                                            </div>
                                          </div>
                                          <div class="modal-footer">
                                            <button type="submit" class="btn btn-danger">Kirim Catatan Revisi</button>
                                          </div>
                                      </form>
                                    </div>
                                  </div>
                                </div>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
