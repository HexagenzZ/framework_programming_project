<?php /* app/Views/admin/post_list.php */ ?>
<?php ob_start(); ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="fw-bold mb-0">Kelola Berita</h2>
    <a href="<?= base_url('admin/post/new') ?>" class="btn btn-primary rounded-pill px-4">+ Berita Baru</a>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success rounded-3 mb-4"><?= esc(session()->getFlashdata('success')) ?></div>
<?php endif; ?>

<div class="card overflow-hidden">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light text-muted">
                <tr>
                    <th class="ps-4 py-3" style="width: 80px;">Image</th>
                    <th>Judul Berita</th>
                    <th>Kategori</th>
                    <th>Status</th>
                    <th class="pe-4 text-end">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($posts)): ?>
                    <tr>
                        <td colspan="5" class="text-center py-4 text-muted">Belum ada berita.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($posts as $post): ?>
                        <tr>
                            <td class="ps-4 py-3">
                                <?php if (!empty($post['image'])): ?>
                                    <img src="<?= base_url('uploads/'.$post['image']) ?>" class="rounded" style="width: 48px; height: 48px; object-fit: cover;">
                                <?php else: ?>
                                    <div class="rounded bg-light border d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                        <span class="text-muted" style="font-size: 10px;">IMG</span>
                                    </div>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="fw-medium text-dark"><?= esc($post['title']) ?> <?php if($post['is_featured']) echo '<span class="badge bg-danger ms-1" style="font-size: 10px;">Unggulan</span>'; ?></div>
                                <div class="text-muted" style="font-size: 12px;"><?= date('d M Y', strtotime($post['created_at'])) ?></div>
                            </td>
                            <td><span class="badge bg-light text-dark border"><?= esc($post['category_name']) ?></span></td>
                            <td>
                                <?php if ($post['status'] === 'published'): ?>
                                    <span class="text-success"><span style="font-size: 20px; line-height: 0; vertical-align: middle;">•</span> Published</span>
                                <?php else: ?>
                                    <span class="text-muted"><span style="font-size: 20px; line-height: 0; vertical-align: middle;">•</span> Draft</span>
                                <?php endif; ?>
                            </td>
                            <td class="pe-4 text-end">
                                <a href="<?= base_url('berita/'.$post['slug']) ?>" target="_blank" class="btn btn-sm btn-outline-secondary">Preview</a>
                                <a href="<?= base_url('admin/post/'.$post['id'].'/edit') ?>" class="btn btn-sm btn-outline-primary ms-1">Edit</a>
                                <a href="<?= base_url('admin/post/'.$post['id'].'/delete') ?>" class="btn btn-sm btn-outline-danger ms-1" onclick="return confirm('Yakin ingin menghapus berita ini?')">Hapus</a>
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
