<!--begin::Row-->
<div class="row">
    <div class="col-sm-6">
        <h3 class="mb-0">Edit Data Kecamatan Kabupaten Tegal</h3>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="<?= site_url('Admin') ?>">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="<?= site_url('Admin-Kecamatan') ?>">Data Kecamatan</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Data Kecamatan</li>
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
            <div class="card-title">Edit Data Kecamatan</div>
        </div>
        <!--end::Header-->
        <!--begin::Form-->
        <form method="post" action="">
            <!--begin::Body-->
            <div class="card-body">
                <div class="row mb-3">
                    <label for="inputKecamatanl3" class="col-sm-2 col-form-label">Kecamatan</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="kecamatan" id="inputKecamatan3"
                            value="<?= $record->kecamatan; ?>" />
                    </div>
                </div>
            </div>
            <!--end::Body-->
            <!--begin::Footer-->
            <div class="card-footer">
                <a href="<?= site_url('Admin-Kecamatan') ?>"><button type="button"
                        class="btn btn-danger">Kembali</button></a>
                <button type="submit" class="btn float-end btn-primary">Update Data</button>
            </div>
            <!--end::Footer-->
        </form>
        <!--end::Form-->
    </div>
</div>