<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyBlog</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?= base_url('css/bootstrap.min.css') ?>" />
</head>
<body>
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <div class="container">
            <a class="navbar-brand" href="<?= base_url() ?>">MyBlog</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarNav" aria-controls="navbarNav"
                aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-between" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('admin/post') ?>">Blog</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a href="<?= base_url('admin/post/new') ?>"
                           class="btn btn-primary mr-3">New Post</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('admin/setting') ?>">Setting</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('auth/logout') ?>">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="p-5 mb-4 bg-light rounded-3">
        <div class="container py-5">
            <h1 class="display-5 fw-bold">Blog > Admin</h1>
        </div>
    </div>

    
<div class="container">
    <form action="" method="post" id="text-editor" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $post['id'] ?>" />
        <div class="form-group mb-2">
            <label for="title">Title / Nama Karya</label>
            <input type="text" name="title" class="form-control"
                   placeholder="Post title" value="<?= $post['title'] ?>" required>
        </div>
        <div class="form-group mb-2">
            <label for="category_id">Kategori</label>
            <select name="category_id" id="category_id" class="form-control" required>
                <option value="">-- Pilih Kategori --</option>
                <?php foreach($categories as $cat): ?>
                    <option value="<?= $cat['id'] ?>" <?= ($post['category_id'] == $cat['id']) ? 'selected' : '' ?>><?= $cat['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group mb-2">
            <label for="image">Upload Thumbnail/Gambar (Kosongkan jika tidak ingin ganti)</label>
            <?php if(!empty($post['image'])): ?>
                <div class="mb-2">
                    <img src="<?= base_url('uploads/'.$post['image']) ?>" width="150" alt="Current Image">
                </div>
            <?php endif; ?>
            <input type="file" name="image" class="form-control">
        </div>
        <div class="form-group mb-2">
            <label for="sumber_berita">Sumber Berita (Opsional)</label>
            <input type="text" name="sumber_berita" class="form-control" placeholder="Contoh: Humas Kampus" value="<?= $post['sumber_berita'] ?? '' ?>">
        </div>
        <div class="form-group mb-2 form-check">
            <input type="checkbox" name="is_featured" value="1" class="form-check-input" id="is_featured" <?= (isset($post['is_featured']) && $post['is_featured'] == 1) ? 'checked' : '' ?>>
            <label class="form-check-label" for="is_featured">Jadikan Berita Unggulan (Tampil di atas)</label>
        </div>
        <div class="form-group mb-2">
            <label for="content">Deskripsi / Isi Berita</label>
            <textarea name="content" class="form-control" cols="30" rows="10"
                      placeholder="Write a great description!"><?= $post['content'] ?></textarea>
        </div>
        <div class="form-group mb-2">
            <button type="submit" name="status" value="published"
                    class="btn btn-primary">Publish</button>
            <button type="submit" name="status" value="draft"
                    class="btn btn-secondary">Save to Draft</button>
        </div>
    </form>
</div>


    <div class="container py-4">
        <footer class="pt-3 mt-4 text-muted border-top">
            <div class="container">
                &copy; <?= Date('Y') ?>
            </div>
        </footer>
    </div>

    <!-- jQuery dan Bootstrap JS -->
    <script src="<?= base_url('js/jquery.min.js') ?>"></script>
    <script src="<?= base_url('js/bootstrap.bundle.min.js') ?>"></script>

</body>
</html>

