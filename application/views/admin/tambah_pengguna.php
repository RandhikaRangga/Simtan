<!--begin::Row-->
<div class="row">
    <div class="col-sm-6">
        <h3 class="mb-0">Tambah Data Pengguna Simtan</h3>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="Admin">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="Admin-Pengguna">Data Pengguna</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tambah Data Pengguna</li>
        </ol>
    </div>
</div>
<!--end::Row-->
</div>
<!--end::Container-->
</div>
<!--end::App Content Header-->
<div class="col-md-12 px-4">
    <div class="card card-primary card-outline mb-4">
        <!--begin::Header-->
        <div class="card-header">
            <div class="card-title">Tambah Data Pengguna</div>
        </div>
        <!--end::Header-->
        <!--begin::Form-->
        <form method="post" action="">
            <!--begin::Body-->
            <div class="card-body">
                <div class="row mb-3">
                    <label for="inputNamal3" class="col-sm-2 col-form-label">Nama</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="nama" id="inputNama3" required />
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="inputUsernamel3" class="col-sm-2 col-form-label">Username</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="username" id="inputUsername3" required />
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="inputPasswordl3" class="col-sm-2 col-form-label">Password</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="password" id="inputPassword3" required />
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="inputRole3" class="col-sm-2 col-form-label">Role</label>
                    <div class="col-sm-10">
                        <select class="form-select" id="validationCustom04" name="role" required>
                            <option value="">-- Pilih Role --</option>
                            <option value="kantor">Petugas Kantor</option>
                            <option value="penyuluh">Petugas Penyuluh</option>
                        </select>
                    </div>
                </div>
            </div>
            <!--end::Body-->
            <!--begin::Footer-->
            <div class="card-footer">
                <a href="Admin-Pengguna"><button type="button" class="btn btn-danger">Kembali</button></a>
                <button type="submit" class="btn float-end btn-primary">Tambah Data</button>
            </div>
            <!--end::Footer-->
        </form>
        <!--end::Form-->
    </div>
</div>