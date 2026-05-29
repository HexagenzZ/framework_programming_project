<?php /* app/Views/project/index.php */ ?>
<?= view('partials/navbar', ['title' => 'Project Mahasiswa - Kampus Portal']) ?>

<div class="container mt-5 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="fw-bold mb-1">Project Mahasiswa</h1>
            <p class="text-muted">Katalog karya dan project akhir mahasiswa.</p>
        </div>
        <?php if (logged_in() && (has_role('mahasiswa') || has_role('admin'))): ?>
            <a href="<?= base_url('project/submit') ?>" class="btn btn-primary rounded-pill px-4">+ Submit Project</a>
        <?php endif; ?>
    </div>

    <div class="mb-4">
        <form action="<?= base_url('project') ?>" method="get" class="row g-2 align-items-center">
            <div class="col-auto">
                <input type="text" name="tech" class="form-control rounded-pill px-3" placeholder="Filter Tech Stack" value="<?= esc($_GET['tech'] ?? '') ?>">
            </div>
            <div class="col-auto">
                <input type="number" name="semester" class="form-control rounded-pill px-3" placeholder="Semester" value="<?= esc($_GET['semester'] ?? '') ?>">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-outline-secondary rounded-pill px-4">Cari</button>
            </div>
        </form>
    </div>

    <div class="row g-4">
        <?php if (empty($projects)): ?>
            <div class="col-12 text-center py-5">
                <p class="text-muted">Belum ada project yang dipublikasikan.</p>
            </div>
        <?php else: ?>
            <?php foreach ($projects as $project): ?>
            <div class="col-md-6">
                <div class="card h-100">
                    <?php if (!empty($project['thumbnail'])): ?>
                        <img src="<?= base_url('uploads/projects/'.$project['thumbnail']) ?>" class="card-img-top" style="height: 180px; object-fit: cover;">
                    <?php else: ?>
                        <div class="card-img-top d-flex align-items-center justify-content-center" style="height: 180px; background: linear-gradient(135deg, #EEEDFE, #AFA9EC);">
                            <span class="text-white opacity-75 fw-bold">NO IMAGE</span>
                        </div>
                    <?php endif; ?>
                    
                    <div class="card-body">
                        <?php if (has_role('admin')): ?>
                            <div class="mb-2">
                                <?php if ($project['status'] === 'approved'): ?>
                                    <span class="badge bg-success">Approved</span>
                                <?php elseif ($project['status'] === 'pending'): ?>
                                    <span class="badge bg-warning text-dark">Pending</span>
                                <?php else: ?>
                                    <span class="badge bg-danger">Rejected</span>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                        <h5 class="card-title fw-bold mb-2"><?= esc($project['title']) ?></h5>
                        <p class="card-text text-muted mb-3" style="font-size: 13px;"><?= esc(mb_substr(strip_tags($project['description']), 0, 100)) ?>...</p>
                        
                        <div class="mb-3">
                            <?php 
                            if (!empty($project['tech_stack'])): 
                                $techs = array_map('trim', explode(',', $project['tech_stack']));
                                foreach ($techs as $tech): 
                            ?>
                                <span class="pill-stack"><?= esc($tech) ?></span>
                            <?php 
                                endforeach; 
                            endif; 
                            ?>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="small text-muted">
                                Semester <?= esc($project['semester']) ?> · <?= esc($project['mata_kuliah']) ?><br>
                                oleh <span class="fw-medium text-dark"><?= esc($project['full_name']) ?></span>
                            </div>
                            <a href="<?= base_url('project/'.$project['slug']) ?>" class="btn btn-sm btn-outline-primary rounded-pill px-3">Lihat Detail</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<?= view('partials/footer') ?>
