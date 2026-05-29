<?php /* app/Views/project/my_projects.php */ ?>
<?= view('partials/navbar', ['title' => 'Project Saya - Kampus Portal']) ?>

<div class="container mt-5 mb-5" style="max-width: 800px;">
    <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
        <div>
            <h1 class="fw-bold mb-1">Project Saya</h1>
            <p class="text-muted mb-0">Atas nama: <?= esc(current_user()['full_name']) ?></p>
        </div>
        <a href="<?= base_url('project/submit') ?>" class="btn btn-primary rounded-pill px-4">+ Submit Project Baru</a>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success rounded-3 mb-4"><?= esc(session()->getFlashdata('success')) ?></div>
    <?php endif; ?>

    <?php if (empty($projects)): ?>
        <div class="text-center py-5 bg-white card border-0" style="border: 1px dashed #ccc !important;">
            <div class="fs-1 mb-3">&#128193;</div>
            <h5 class="fw-bold text-dark">Belum ada project</h5>
            <p class="text-muted">Kamu belum mempublikasikan karya apapun.</p>
            <a href="<?= base_url('project/submit') ?>" class="btn btn-outline-primary rounded-pill px-4 mt-2">Mulai Submit Sekarang</a>
        </div>
    <?php else: ?>
        <div class="d-flex flex-column gap-3">
            <?php foreach ($projects as $project): ?>
            <div class="card p-3 flex-md-row gap-3">
                <?php if (!empty($project['thumbnail'])): ?>
                    <img src="<?= base_url('uploads/projects/'.$project['thumbnail']) ?>" class="rounded" style="width: 120px; height: 120px; object-fit: cover;">
                <?php else: ?>
                    <div class="rounded d-flex align-items-center justify-content-center" style="width: 120px; height: 120px; background: #EEEDFE;">
                        <span class="text-accent opacity-50 small">No Image</span>
                    </div>
                <?php endif; ?>
                
                <div class="flex-grow-1 d-flex flex-column justify-content-center">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h5 class="fw-bold mb-0"><?= esc($project['title']) ?></h5>
                        <?php if ($project['status'] === 'approved'): ?>
                            <span class="badge" style="background: #E1F5EE; color: #085041;">Approved</span>
                        <?php elseif ($project['status'] === 'pending'): ?>
                            <span class="badge" style="background: #FAEEDA; color: #633806;">Pending</span>
                        <?php else: ?>
                            <span class="badge" style="background: #FCEBEB; color: #A32D2D;">Rejected</span>
                        <?php endif; ?>
                    </div>
                    <p class="text-muted mb-2" style="font-size: 13px;"><?= esc(mb_substr(strip_tags($project['description']), 0, 100)) ?>...</p>
                    <div class="d-flex justify-content-between align-items-center mt-auto">
                        <div class="text-muted" style="font-size: 12px;">
                            <?= esc($project['mata_kuliah']) ?> · Semester <?= esc($project['semester']) ?>
                        </div>
                        <a href="<?= base_url('project/'.$project['slug']) ?>" class="btn btn-sm btn-outline-secondary rounded-pill px-3">Lihat Detail</a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?= view('partials/footer') ?>
