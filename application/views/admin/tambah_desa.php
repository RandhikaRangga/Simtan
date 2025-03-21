<!--begin::Row-->
<div class="row">
    <div class="col-sm-6">
        <h3 class="mb-0">Tambah Data Desa Kabupaten Tegal</h3>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="Admin">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="Admin-Desa">Data Desa</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tambah Data Desa</li>
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
            <div class="card-title">Tambah Data Desa</div>
        </div>
        <!--end::Header-->
        <!--begin::Form-->
        <form method="post" action="">
            <!--begin::Body-->
            <div class="card-body">
                <div class="row mb-3">
                    <label for="inputKecamatan3" class="col-sm-2 col-form-label">Kecamatan</label>
                    <div class="col-sm-10">
                        <select class="form-select" id="validationCustom04" name="kecamatan_id" required>
                            <option value="">-- Pilih Kecamatan --</option>
                            <?php foreach ($kecamatan as $kec) { ?>
                            <option value="<?= $kec->id ?>"><?= $kec->kecamatan ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="inputDesal3" class="col-sm-2 col-form-label">Desa</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="desa" id="inputDesa3" />
                    </div>
                </div>
            </div>
            <!--end::Body-->
            <!--begin::Footer-->
            <div class="card-footer">
                <a href="Admin-Desa"><button type="button" class="btn btn-danger">Kembali</button></a>
                <button type="submit" class="btn float-end btn-primary">Tambah Data</button>
            </div>
            <!--end::Footer-->
        </form>
        <!--end::Form-->
    </div>
</div>