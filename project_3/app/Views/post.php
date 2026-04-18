<!DOCTYPE html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog - MyBlog</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <div class="container">
        <a class="navbar-brand" href="<?= base_url() ?>">MyBlog</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="<?= base_url() ?>">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url('about') ?>">About</a></li>
                <li class="nav-item"><a class="nav-link active" href="<?= base_url('post') ?>">Blog</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url('contact') ?>">Contact</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url('faqs') ?>">FAQ</a></li>
            </ul>
        </div>
    </div>
</nav>

<div style="padding-top:70px;">
    <div class="p-5 mb-4 bg-light rounded-3">
        <div class="container py-5">
            <h1 class="display-5 fw-bold">Blog</h1>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <?php foreach ($posts as $post) : ?>
            <div class="col-md-12 my-2 card">
                <div class="card-body">
                    <h5 class="h5">
                        <a href="/post/<?= $post['slug'] ?>"><?= $post['title'] ?></a>
                    </h5>
                    <p><?= substr($post['content'], 0, 120) ?></p>
                </div>
            </div>
            <?php endforeach ?>
        </div>
    </div>

    <div class="container py-4">
        <footer class="pt-3 mt-4 text-muted border-top">
            <div class="container">&copy; <?= Date('Y') ?></div>
        </footer>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
