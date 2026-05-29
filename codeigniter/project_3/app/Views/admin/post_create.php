<?php /* app/Views/admin/post_create.php */ ?>
<?php ob_start(); ?>

<div class="mb-4">
    <a href="<?= base_url('admin/post') ?>" class="text-decoration-none text-muted d-inline-block mb-2">&larr; Kembali</a>
    <h2 class="fw-bold mb-0">Tulis Berita Baru</h2>
</div>

<div class="card p-4">
    <?php if (session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger">
            <ul class="mb-0 ps-3">
            <?php foreach (session()->getFlashdata('errors') as $err): ?>
                <li><?= esc($err) ?></li>
            <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('admin/post/new') ?>" method="post" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-8">
                <div class="mb-3">
                    <label class="form-label text-muted fw-medium">Judul Berita</label>
                    <input type="text" name="title" class="form-control" value="<?= old('title') ?>" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label text-muted fw-medium">Konten Berita</label>
                    <textarea name="content" class="form-control" rows="10" required><?= old('content') ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted fw-medium">Sumber Berita (Opsional)</label>
                    <input type="text" name="sumber_berita" class="form-control" placeholder="Nama penulis atau sumber eksternal" value="<?= old('sumber_berita') ?>">
                </div>
            </div>

            <div class="col-md-4">
                <div class="card bg-light border-0 p-3 mb-4">
                    <div class="mb-3">
                        <label class="form-label text-muted fw-medium">Kategori</label>
                        <select name="category_id" class="form-select" required>
                            <option value="">Pilih Kategori...</option>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?= $cat['id'] ?>" <?= old('category_id') == $cat['id'] ? 'selected' : '' ?>><?= esc($cat['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-muted fw-medium">Gambar Utama</label>
                        <input type="file" name="image" class="form-control" accept="image/*">
                    </div>

                    <div class="form-check mb-4 mt-3">
                        <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="isFeatured" <?= old('is_featured') ? 'checked' : '' ?>>
                        <label class="form-check-label fw-medium text-dark" for="isFeatured">
                            Jadikan berita unggulan di homepage
                        </label>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" name="status" value="published" class="btn btn-primary">Publish</button>
                        <button type="submit" name="status" value="draft" class="btn btn-outline-secondary bg-white">Simpan Draft</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<?php 
$content = ob_get_clean(); 
echo view('admin/layout', ['content' => $content]); 
?>
