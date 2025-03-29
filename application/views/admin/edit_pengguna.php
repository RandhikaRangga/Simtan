<!--begin::Row-->
<div class="row">
    <div class="col-sm-6">
        <h3 class="mb-0">Edit Data Pengguna Simtan</h3>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="<?= site_url('Admin') ?>">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="<?= site_url('Admin-Pengguna') ?>">Data Pengguna</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Data Pengguna</li>
        </ol>
    </div>
</div>
<!--end::Row-->
</div>
<!--end::Container-->
</div>
<!--end::App Content Header-->
<div class="col-md-12" style="padding: 15px;">
    <div class="card card-primary card-outline mb-4">
        <!--begin::Header-->
        <div class="card-header">
            <div class="card-title">Edit Data Pengguna</div>
        </div>
        <!--end::Header-->
        <!--begin::Form-->
        <form method="post" action="">
            <!--begin::Body-->
            <div class="card-body">
                <div class="row mb-3">
                    <label for="inputNamal3" class="col-sm-2 col-form-label">Nama</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="nama" id="inputNama3"
                            value="<?= $record->nama; ?>" />
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="inputUsernamel3" class="col-sm-2 col-form-label">Username</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="username" id="inputUsername3"
                            value="<?= $record->username; ?>" />
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="inputPasswordl3" class="col-sm-2 col-form-label">Password</label>
                    <div class="col-sm-10">
                        <div class="input-group">
                            <input type="password" class="form-control" name="Password" id="inputPassword3"
                                value="<?= $record->password; ?>" />
                            <span class="input-group-text" onclick="togglePassword()" style="cursor: pointer;">
                                <i id="eyeIcon" class="fas fa-eye-slash"></i>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="inputRole3" class="col-sm-2 col-form-label">Role</label>
                    <div class="col-sm-10">
                        <select class="form-select" id="validationCustom04" name="role" required>
                            <option value="">-- Pilih Role --</option>
                            <?php foreach ($roles as $role => $label) : ?>
                            <option value="<?= $role; ?>" <?= ($role == $record->role) ? 'selected' : ''; ?>>
                                <?= $label; ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
            <!--end::Body-->
            <!--begin::Footer-->
            <div class="card-footer">
                <a href="<?= site_url('Admin-Pengguna') ?>"><button type="button"
                        class="btn btn-danger">Kembali</button></a>
                <button type="submit" class="btn float-end btn-primary">Update Data</button>
            </div>
            <!--end::Footer-->
        </form>
        <!--end::Form-->
    </div>
</div>

<script>
function togglePassword() {
    var pass = document.getElementById("inputPassword3");
    var eyeIcon = document.getElementById("eyeIcon");

    if (pass.type === "password") {
        pass.type = "text";
        eyeIcon.classList.remove("fa-eye-slash");
        eyeIcon.classList.add("fa-eye");
    } else {
        pass.type = "password";
        eyeIcon.classList.remove("fa-eye");
        eyeIcon.classList.add("fa-eye-slash");
    }
}
</script>