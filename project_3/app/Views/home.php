<?php /* app/Views/home.php */ ?>
<?= view('partials/navbar', ['title' => 'Portal Berita & Project']) ?>

<div class="bg-white py-5 mb-5 border-bottom">
    <div class="container text-center py-4">
        <h1 class="fw-bold mb-3">Portal Mahasiswa & Berita Kampus</h1>
        <p class="text-muted mb-4 fs-5">Wadah publikasi karya ilmiah, project akhir, dan informasi terkini seputar kampus.</p>
        <div>
            <a href="<?= base_url('project') ?>" class="btn btn-primary btn-lg px-4 rounded-pill me-2">Jelajahi Project &rarr;</a>
            <a href="<?= base_url('berita') ?>" class="btn btn-outline-secondary btn-lg px-4 rounded-pill">Baca Berita</a>
        </div>
    </div>
</div>

<div class="container mb-5">
    <?php if (!empty($featured)): ?>
    <h6 class="section-heading mb-4">Highlight Kampus</h6>
    <div class="card overflow-hidden mb-5">
        <div class="row g-0">
            <div class="col-md-4">
                <img src="<?= base_url('uploads/'.$featured['image']) ?>" alt="<?= esc($featured['title']) ?>" class="img-fluid w-100" style="height: 100%; min-height: 250px; object-fit: cover;">
            </div>
            <div class="col-md-8 d-flex flex-column justify-content-center p-4">
                <div>
                    <span class="badge bg-accent mb-2">UNGGULAN</span>
                    <h2 class="fw-bold mb-3"><?= esc($featured['title']) ?></h2>
                    <p class="text-muted mb-4"><?= esc(mb_substr(strip_tags($featured['content']), 0, 150)) ?>...</p>
                    <div class="d-flex align-items-center justify-content-between">
                        <a href="<?= base_url('berita/'.$featured['slug']) ?>" class="btn btn-outline-primary rounded-pill px-4">Baca Selengkapnya</a>
                        <?php if (!empty($featured['sumber_berita'])): ?>
                            <small class="text-muted">Sumber: <?= esc($featured['sumber_berita']) ?></small>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <div class="d-flex justify-content-between align-items-end mb-4">
        <h6 class="section-heading mb-0">Berita Terbaru</h6>
    </div>

    <div class="mb-4">
        <a href="<?= base_url() ?>" class="pill-chip <?= empty($_GET['category']) ? 'active' : '' ?>">Semua</a>
        <?php foreach ($categories as $cat): ?>
            <a href="<?= base_url('?category='.$cat['id']) ?>" class="pill-chip <?= (isset($_GET['category']) && $_GET['category'] == $cat['id']) ? 'active' : '' ?>"><?= esc($cat['name']) ?></a>
        <?php endforeach; ?>
    </div>

    <div class="row g-4">
        <?php foreach ($posts as $post): ?>
        <div class="col-md-4">
            <div class="card h-100">
                <?php if (!empty($post['image'])): ?>
                    <img src="<?= base_url('uploads/'.$post['image']) ?>" class="card-img-top" alt="Thumbnail" style="height: 160px; object-fit: cover;">
                <?php else: ?>
                    <div class="card-img-top d-flex align-items-center justify-content-center" style="height: 160px; background-color: #EEEDFE;">
                        <span class="text-accent opacity-50">No Image</span>
                    </div>
                <?php endif; ?>
                <div class="card-body">
                    <span class="badge bg-light text-dark border mb-2"><?= esc($post['category_name']) ?></span>
                    <h5 class="card-title fw-bold">
                        <a href="<?= base_url('berita/'.$post['slug']) ?>" class="text-decoration-none text-dark"><?= esc($post['title']) ?></a>
                    </h5>
                    <p class="card-text text-muted mb-3" style="font-size: 13px;"><?= esc(mb_substr(strip_tags($post['content']), 0, 80)) ?>...</p>
                </div>
                <div class="card-footer bg-transparent border-top-0 pt-0">
                    <small class="text-muted"><?= date('d M Y', strtotime($post['created_at'])) ?></small>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<?= view('partials/footer') ?>
