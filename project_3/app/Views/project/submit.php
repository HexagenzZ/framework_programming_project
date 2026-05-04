<?php /* app/Views/project/submit.php */ ?>
<?= view('partials/navbar', ['title' => 'Submit Project Baru - Kampus Portal']) ?>

<div class="container mt-5 mb-5" style="max-width: 720px;">
    <div class="mb-4 text-center">
        <h1 class="fw-bold mb-2">Submit Project Baru</h1>
        <p class="text-muted">Kirimkan hasil karya atau project akhir mata kuliah kamu.</p>
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

        <form action="<?= base_url('project/submit') ?>" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label text-muted fw-medium">Judul Project <span class="text-danger">*</span></label>
                <input type="text" name="title" class="form-control" value="<?= old('title') ?>" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label text-muted fw-medium">Deskripsi Lengkap <span class="text-danger">*</span></label>
                <textarea name="description" class="form-control" rows="6" required><?= old('description') ?></textarea>
            </div>

            <div class="row mb-3">
                <div class="col-md-8">
                    <label class="form-label text-muted fw-medium">Mata Kuliah <span class="text-danger">*</span></label>
                    <input type="text" name="mata_kuliah" class="form-control" value="<?= old('mata_kuliah') ?>" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label text-muted fw-medium">Semester <span class="text-danger">*</span></label>
                    <select name="semester" class="form-select" required>
                        <option value="">Pilih...</option>
                        <?php for($i=1; $i<=8; $i++): ?>
                            <option value="<?= $i ?>" <?= old('semester') == $i ? 'selected' : '' ?>><?= $i ?></option>
                        <?php endfor; ?>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label text-muted fw-medium">Tech Stack <span class="text-danger">*</span></label>
                <input type="text" name="tech_stack" class="form-control" placeholder="Laravel, MySQL, Bootstrap (pisahkan koma)" value="<?= old('tech_stack') ?>" required>
            </div>

            <div class="mb-3 border rounded p-3 bg-light">
                <label class="form-label text-muted fw-medium mb-1">Thumbnail / Gambar Project <span class="text-danger">*</span></label>
                <div class="text-muted small mb-2">Format: JPG, JPEG, PNG. Maksimal 2MB.</div>
                <input type="file" name="thumbnail" class="form-control bg-white" accept="image/jpg,image/jpeg,image/png" required>
            </div>

            <div class="row mb-4">
                <div class="col-md-6">
                    <label class="form-label text-muted fw-medium">URL Repository GitHub</label>
                    <input type="url" name="github_url" class="form-control" placeholder="https://github.com/..." value="<?= old('github_url') ?>">
                </div>
                <div class="col-md-6">
                    <label class="form-label text-muted fw-medium">URL Live Demo</label>
                    <input type="url" name="demo_url" class="form-control" placeholder="https://..." value="<?= old('demo_url') ?>">
                </div>
            </div>

            <hr class="mb-4">
            
            <div class="mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="section-heading mb-0">Anggota Tim</h6>
                    <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill" onclick="addMember()">+ Tambah Anggota</button>
                </div>
                <div class="table-responsive">
                    <table class="table table-borderless align-middle" id="membersTable">
                        <thead>
                            <tr class="text-muted small">
                                <th>Nama Lengkap</th>
                                <th>NIM</th>
                                <th>Peran (Role)</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><input type="text" name="members_name[]" class="form-control" placeholder="Nama"></td>
                                <td><input type="text" name="members_nim[]" class="form-control" placeholder="NIM"></td>
                                <td><input type="text" name="members_role[]" class="form-control" placeholder="Role"></td>
                                <td><button type="button" class="btn btn-sm btn-light text-danger" onclick="this.closest('tr').remove()">&times;</button></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="d-flex gap-2 justify-content-end pt-3 border-top">
                <a href="<?= base_url('project') ?>" class="btn btn-outline-secondary rounded-pill px-4">Batal</a>
                <button type="submit" class="btn btn-primary rounded-pill px-4">Submit Project</button>
            </div>
        </form>
    </div>
</div>

<script>
function addMember() {
    const tbody = document.querySelector('#membersTable tbody');
    const tr = document.createElement('tr');
    tr.innerHTML = `
        <td><input type="text" name="members_name[]" class="form-control" placeholder="Nama"></td>
        <td><input type="text" name="members_nim[]" class="form-control" placeholder="NIM"></td>
        <td><input type="text" name="members_role[]" class="form-control" placeholder="Role"></td>
        <td><button type="button" class="btn btn-sm btn-light text-danger" onclick="this.closest('tr').remove()">&times;</button></td>
    `;
    tbody.appendChild(tr);
}
</script>
<?= view('partials/footer') ?>
