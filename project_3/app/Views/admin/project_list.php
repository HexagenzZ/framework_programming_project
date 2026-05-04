<?php /* app/Views/admin/project_list.php */ ?>
<?php ob_start(); ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0">Kelola Project Mahasiswa</h2>
</div>

<div class="mb-4 border-bottom pb-2">
    <a href="<?= base_url('admin/project') ?>" class="pill-chip <?= empty($_GET['status']) ? 'active' : '' ?>">Semua</a>
    <a href="<?= base_url('admin/project?status=pending') ?>" class="pill-chip <?= (isset($_GET['status']) && $_GET['status'] == 'pending') ? 'active' : '' ?>">Pending</a>
    <a href="<?= base_url('admin/project?status=approved') ?>" class="pill-chip <?= (isset($_GET['status']) && $_GET['status'] == 'approved') ? 'active' : '' ?>">Approved</a>
    <a href="<?= base_url('admin/project?status=rejected') ?>" class="pill-chip <?= (isset($_GET['status']) && $_GET['status'] == 'rejected') ? 'active' : '' ?>">Rejected</a>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success rounded-3 mb-4"><?= esc(session()->getFlashdata('success')) ?></div>
<?php endif; ?>

<div class="card overflow-hidden">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light text-muted">
                <tr>
                    <th class="ps-4 py-3" style="width: 70px;">Image</th>
                    <th>Project & Matkul</th>
                    <th>Mahasiswa</th>
                    <th>Semester</th>
                    <th>Status</th>
                    <th class="pe-4 text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($projects)): ?>
                    <tr>
                        <td colspan="6" class="text-center py-4 text-muted">Tidak ada data project.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($projects as $project): ?>
                        <tr>
                            <td class="ps-4 py-3">
                                <?php if (!empty($project['thumbnail'])): ?>
                                    <img src="<?= base_url('uploads/projects/'.$project['thumbnail']) ?>" class="rounded border" style="width: 48px; height: 48px; object-fit: cover;">
                                <?php else: ?>
                                    <div class="rounded bg-light border d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                        <span class="text-muted" style="font-size: 10px;">NO</span>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="fw-bold text-dark">
                                    <a href="<?= base_url('project/'.$project['slug']) ?>" target="_blank" class="text-decoration-none text-dark"><?= esc($project['title']) ?></a>
                                </div>
                                <div class="text-muted small"><?= esc($project['mata_kuliah']) ?></div>
                            </td>
                            <td><?= esc($project['username']) ?></td>
                            <td>SMT <?= esc($project['semester']) ?></td>
                            <td>
                                <?php if ($project['status'] === 'approved'): ?>
                                    <span class="badge" style="background: #E1F5EE; color: #085041;">Approved</span>
                                <?php elseif ($project['status'] === 'pending'): ?>
                                    <span class="badge" style="background: #FAEEDA; color: #633806;">Pending</span>
                                <?php else: ?>
                                    <span class="badge" style="background: #FCEBEB; color: #A32D2D;">Rejected</span>
                                <?php endif; ?>
                            </td>
                            <td class="pe-4 text-end">
                                <?php if ($project['status'] !== 'approved'): ?>
                                    <a href="<?= base_url('admin/project/'.$project['id'].'/approve') ?>" class="btn btn-sm text-success fw-bold p-1">Approve</a>
                                <?php endif; ?>
                                
                                <?php if ($project['status'] !== 'rejected'): ?>
                                    <a href="<?= base_url('admin/project/'.$project['id'].'/reject') ?>" class="btn btn-sm text-danger fw-bold p-1 ms-1">Reject</a>
                                <?php endif; ?>
                                
                                <span class="text-muted mx-1">|</span>
                                
                                <a href="<?= base_url('admin/project/'.$project['id'].'/delete') ?>" class="btn btn-sm btn-outline-danger ms-1" onclick="return confirm('Hapus project ini beserta datanya secara permanen?')">Hapus</a>
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
