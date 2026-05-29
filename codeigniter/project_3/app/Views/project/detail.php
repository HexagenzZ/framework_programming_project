<?php /* app/Views/project/detail.php */ ?>
<?= view('partials/navbar', ['title' => esc($project['title']) . ' - Project Mahasiswa']) ?>

<div class="container mt-5 mb-5" style="max-width: 900px;">
    <div class="mb-4">
        <a href="<?= base_url('project') ?>" class="text-decoration-none text-muted mb-3 d-inline-block">&larr; Kembali ke Daftar Project</a>
        <h1 class="fw-bold mb-3"><?= esc($project['title']) ?></h1>
        <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
            <?php if (has_role('admin')): ?>
                <?php if ($project['status'] === 'approved'): ?>
                    <span class="badge bg-success px-3 py-2 rounded-pill">Approved</span>
                <?php elseif ($project['status'] === 'pending'): ?>
                    <span class="badge bg-warning text-dark px-3 py-2 rounded-pill">Pending</span>
                <?php else: ?>
                    <span class="badge bg-danger px-3 py-2 rounded-pill">Rejected</span>
                <?php endif; ?>
            <?php endif; ?>
            
            <?php 
            if (!empty($project['tech_stack'])): 
                $techs = array_map('trim', explode(',', $project['tech_stack']));
                foreach ($techs as $tech): 
            ?>
                <span class="pill-stack" style="font-size: 13px; padding: 6px 14px;"><?= esc($tech) ?></span>
            <?php 
                endforeach; 
            endif; 
            ?>
        </div>
        
        <div class="text-muted" style="font-size: 14px;">
            Semester <?= esc($project['semester']) ?> · <?= esc($project['mata_kuliah']) ?> <br>
            Diunggah oleh <span class="text-dark fw-medium"><?= esc($project['full_name']) ?></span> pada <?= date('d M Y', strtotime($project['created_at'])) ?>
        </div>
    </div>

    <?php if (!empty($project['thumbnail'])): ?>
        <img src="<?= base_url('uploads/projects/'.$project['thumbnail']) ?>" class="img-fluid w-100 mb-5 border" style="border-radius: 12px; height: 300px; object-fit: cover;">
    <?php else: ?>
        <div class="w-100 mb-5 d-flex align-items-center justify-content-center border" style="border-radius: 12px; height: 300px; background: linear-gradient(135deg, #EEEDFE, #AFA9EC);">
             <span class="text-white opacity-75 fw-bold fs-4">NO IMAGE</span>
        </div>
    <?php endif; ?>

    <div class="card p-4 mb-5 border-0 bg-white" style="border: 1px solid #E8E8E4 !important;">
        <h6 class="section-heading text-muted mb-3">Deskripsi Project</h6>
        <div style="line-height: 1.8; font-size: 15px; color: #333;">
            <?= nl2br(esc($project['description'])) ?>
        </div>
        
        <div class="mt-4 pt-3 border-top d-flex gap-2">
            <?php if (!empty($project['github_url'])): ?>
                <a href="<?= esc($project['github_url']) ?>" target="_blank" class="btn btn-dark rounded-pill px-4">Lihat di GitHub</a>
            <?php endif; ?>
            <?php if (!empty($project['demo_url'])): ?>
                <a href="<?= esc($project['demo_url']) ?>" target="_blank" class="btn btn-primary rounded-pill px-4">Coba Demo</a>
            <?php endif; ?>
        </div>
    </div>

    <?php if (!empty($members)): ?>
    <h6 class="section-heading text-muted mb-3">Anggota Tim</h6>
    <div class="row g-3">
        <?php foreach ($members as $member): ?>
        <div class="col-md-6">
            <div class="card p-3 d-flex flex-row align-items-center gap-3 border-0 bg-white" style="border: 1px solid #E8E8E4 !important;">
                <div class="rounded-circle bg-accent text-white d-flex align-items-center justify-content-center fw-bold fs-5" style="width: 48px; height: 48px;">
                    <?= strtoupper(substr($member['name'], 0, 1)) ?>
                </div>
                <div>
                    <h6 class="mb-0 fw-bold"><?= esc($member['name']) ?></h6>
                    <small class="text-muted"><?= esc($member['nim']) ?> • <?= esc($member['role_in_team']) ?></small>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>

<?= view('partials/footer') ?>
