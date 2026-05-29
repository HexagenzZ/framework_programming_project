<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= isset($project) ? 'Edit Project' : 'Submit Project' ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-expand-md navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand" href="#">Mahasiswa Area</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav me-auto">
                <li class="nav-item"><a class="nav-link" href="<?= base_url() ?>">Home Portal</a></li>
                <li class="nav-item"><a class="nav-link" href="<?= base_url('student/projects') ?>">My Projects</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4><?= isset($project) ? 'Revisi Project (Resubmit)' : 'Submit New Project' ?></h4>
                </div>
                <div class="card-body">
                    <?php if (session()->getFlashdata('errors')) : ?>
                        <div class="alert alert-danger">
                            <ul>
                            <?php foreach (session()->getFlashdata('errors') as $error) : ?>
                                <li><?= $error ?></li>
                            <?php endforeach ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form action="<?= isset($project) ? base_url('student/projects/update/'.$project['id']) : base_url('student/projects/store') ?>" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label">Judul Project</label>
                            <input type="text" name="title" class="form-control" value="<?= old('title', $project['title'] ?? '') ?>" required>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Mata Kuliah</label>
                                <input type="text" name="mata_kuliah" class="form-control" value="<?= old('mata_kuliah', $project['mata_kuliah'] ?? '') ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Semester</label>
                                <input type="text" name="semester" class="form-control" value="<?= old('semester', $project['semester'] ?? '') ?>" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Anggota Tim (Pisahkan dengan koma jika kelompok)</label>
                            <input type="text" name="anggota_tim" class="form-control" value="<?= old('anggota_tim', $project['anggota_tim'] ?? '') ?>">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tech Stack (contoh: PHP, CodeIgniter 4, MySQL)</label>
                            <input type="text" name="tech_stack" class="form-control" value="<?= old('tech_stack', $project['tech_stack'] ?? '') ?>">
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">GitHub URL</label>
                                <input type="url" name="github_url" class="form-control" value="<?= old('github_url', $project['github_url'] ?? '') ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Demo URL (Opsional)</label>
                                <input type="url" name="demo_url" class="form-control" value="<?= old('demo_url', $project['demo_url'] ?? '') ?>">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Deskripsi Project</label>
                            <textarea name="description" class="form-control" rows="5" required><?= old('description', $project['description'] ?? '') ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Thumbnail / Screenshot Project (Wajib <?= isset($project) ? 'diisi ulang jika ingin ganti' : '' ?>)</label>
                            <input type="file" name="thumbnail" class="form-control" <?= isset($project) ? '' : 'required' ?>>
                        </div>
                        <button type="submit" class="btn btn-primary w-100"><?= isset($project) ? 'Resubmit Project' : 'Submit Project' ?></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
