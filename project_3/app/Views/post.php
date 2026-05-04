<?php /* app/Views/post.php */ ?>
<?= view('partials/navbar', ['title' => 'Daftar Berita - Kampus Portal']) ?>

<div class="container mt-5 mb-5">
    <div class="mb-4">
        <h1 class="fw-bold mb-2">Berita Kampus</h1>
        <p class="text-muted">Informasi terbaru seputar kegiatan dan prestasi kampus.</p>
    </div>

    <div class="mb-4 border-bottom pb-3">
        <a href="<?= base_url('berita') ?>" class="pill-chip <?= empty($_GET['category']) ? 'active' : '' ?>">Semua</a>
        <?php foreach ($categories as $cat): ?>
            <a href="<?= base_url('berita?category='.$cat['id']) ?>" class="pill-chip <?= (isset($_GET['category']) && $_GET['category'] == $cat['id']) ? 'active' : '' ?>"><?= esc($cat['name']) ?></a>
        <?php endforeach; ?>
    </div>

    <div class="row g-4">
        <?php if (empty($posts)): ?>
            <div class="col-12 text-center py-5">
                <p class="text-muted">Belum ada berita di kategori ini.</p>
            </div>
        <?php else: ?>
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
        <?php endif; ?>
    </div>
</div>

<?= view('partials/footer') ?>
