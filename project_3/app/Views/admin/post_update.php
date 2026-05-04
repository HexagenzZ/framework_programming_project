<?php /* app/Views/admin/post_update.php */ ?>
<?php ob_start(); ?>

<div class="mb-4">
    <a href="<?= base_url('admin/post') ?>" class="text-decoration-none text-muted d-inline-block mb-2">&larr; Kembali</a>
    <h2 class="fw-bold mb-0">Edit Berita</h2>
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

    <form action="<?= base_url('admin/post/'.$post['id'].'/edit') ?>" method="post" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= esc($post['id']) ?>">
        
        <div class="row">
            <div class="col-md-8">
                <div class="mb-3">
                    <label class="form-label text-muted fw-medium">Judul Berita</label>
                    <input type="text" name="title" class="form-control" value="<?= old('title', $post['title']) ?>" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label text-muted fw-medium">Konten Berita</label>
                    <textarea name="content" class="form-control" rows="10" required><?= old('content', $post['content']) ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted fw-medium">Sumber Berita (Opsional)</label>
                    <input type="text" name="sumber_berita" class="form-control" value="<?= old('sumber_berita', $post['sumber_berita']) ?>">
                </div>
            </div>

            <div class="col-md-4">
                <div class="card bg-light border-0 p-3 mb-4">
                    <div class="mb-3">
                        <label class="form-label text-muted fw-medium">Kategori</label>
                        <select name="category_id" class="form-select" required>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?= $cat['id'] ?>" <?= (old('category_id', $post['category_id']) == $cat['id']) ? 'selected' : '' ?>><?= esc($cat['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-muted fw-medium">Gambar Utama</label>
                        <?php if (!empty($post['image'])): ?>
                            <div class="mb-2">
                                <img src="<?= base_url('uploads/'.$post['image']) ?>" class="img-thumbnail" style="height: 100px; width: 100%; object-fit: cover;">
                            </div>
                        <?php endif; ?>
                        <input type="file" name="image" class="form-control" accept="image/*">
                        <div class="form-text">Kosongkan jika tidak ingin mengganti gambar.</div>
                    </div>

                    <div class="form-check mb-4 mt-3">
                        <input class="form-check-input" type="checkbox" name="is_featured" value="1" id="isFeatured" <?= old('is_featured', $post['is_featured']) == 1 ? 'checked' : '' ?>>
                        <label class="form-check-label fw-medium text-dark" for="isFeatured">
                            Jadikan berita unggulan di homepage
                        </label>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" name="status" value="published" class="btn btn-primary">Publish Perubahan</button>
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
