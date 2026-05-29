<?php /* app/Views/post_detail.php */ ?>
<?= view('partials/navbar', ['title' => esc($post['title']) . ' - Kampus Portal']) ?>

<div class="container mt-5 mb-5" style="max-width: 760px;">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb" style="font-size: 13px;">
            <li class="breadcrumb-item"><a href="<?= base_url() ?>" class="text-decoration-none text-muted">Beranda</a></li>
            <li class="breadcrumb-item"><a href="<?= base_url('berita') ?>" class="text-decoration-none text-muted">Berita</a></li>
            <li class="breadcrumb-item active text-dark fw-bold" aria-current="page"><?= esc($post['title']) ?></li>
        </ol>
    </nav>

    <div class="mb-4">
        <span class="badge bg-accent mb-3 px-3 py-2 rounded-pill"><?= esc($post['category_name']) ?></span>
        <h1 class="fw-bold mb-3 lh-sm"><?= esc($post['title']) ?></h1>
        <div class="text-muted d-flex align-items-center" style="font-size: 13px;">
            <span class="fw-medium text-dark">Oleh: <?= esc($post['author']) ?></span>
            <span class="mx-2">•</span>
            <span><?= date('d M Y', strtotime($post['created_at'])) ?></span>
            <?php if (!empty($post['sumber_berita'])): ?>
                <span class="mx-2">•</span>
                <span>Sumber: <?= esc($post['sumber_berita']) ?></span>
            <?php endif; ?>
        </div>
    </div>

    <?php if (!empty($post['image'])): ?>
        <img src="<?= base_url('uploads/'.$post['image']) ?>" class="img-fluid w-100 mb-5" style="border-radius: 12px; object-fit: cover; max-height: 400px;" alt="<?= esc($post['title']) ?>">
    <?php endif; ?>

    <div class="content" style="line-height: 1.8; font-size: 16px; color: #333;">
        <?= nl2br(esc($post['content'])) ?>
    </div>

    <div class="mt-5 pt-4 border-top">
        <a href="<?= base_url('berita') ?>" class="btn btn-outline-secondary rounded-pill px-4">&larr; Kembali ke Daftar Berita</a>
    </div>
</div>

<?= view('partials/footer') ?>
