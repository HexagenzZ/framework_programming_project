<?php /* app/Views/admin/dashboard.php */ ?>
<?php ob_start(); ?>

<h2 class="fw-bold mb-4">Dashboard</h2>

<div class="row g-4 mb-5">
    <div class="col-md-3">
        <div class="card p-4 text-center">
            <div class="fs-2 fw-medium text-dark mb-1"><?= esc($total_posts ?? 0) ?></div>
            <div class="text-muted small text-uppercase">Total Berita</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-4 text-center">
            <div class="fs-2 fw-medium text-dark mb-1"><?= esc($total_projects ?? 0) ?></div>
            <div class="text-muted small text-uppercase">Total Project</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-4 text-center">
            <div class="fs-2 fw-medium text-warning mb-1"><?= esc($pending_projects ?? 0) ?></div>
            <div class="text-muted small text-uppercase">Pending Approval</div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card p-4 text-center">
            <div class="fs-2 fw-medium text-info mb-1"><?= esc($total_users ?? 0) ?></div>
            <div class="text-muted small text-uppercase">Total User</div>
        </div>
    </div>
</div>

<h6 class="section-heading mb-3">Project Menunggu Persetujuan</h6>
<div class="card p-0 overflow-hidden">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light text-muted">
                <tr>
                    <th class="ps-4 py-3">Judul Project</th>
                    <th>Mahasiswa</th>
                    <th>Mata Kuliah (SMT)</th>
                    <th class="pe-4 text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($pending_list)): ?>
                    <tr>
                        <td colspan="4" class="text-center py-4 text-muted">Tidak ada project yang pending.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($pending_list as $p): ?>
                        <tr>
                            <td class="ps-4 fw-medium"><?= esc($p['title']) ?></td>
                            <td><?= esc($p['full_name']) ?></td>
                            <td><?= esc($p['mata_kuliah']) ?> (<?= esc($p['semester']) ?>)</td>
                            <td class="pe-4 text-end">
                                <a href="<?= base_url('admin/project/'.$p['id'].'/approve') ?>" class="btn btn-sm btn-success rounded-pill px-3">Approve</a>
                                <a href="<?= base_url('admin/project/'.$p['id'].'/reject') ?>" class="btn btn-sm btn-outline-danger rounded-pill px-3 ms-1">Reject</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php 
$content = ob_get_clean(); 
echo view('admin/layout', ['content' => $content]); 
?>
