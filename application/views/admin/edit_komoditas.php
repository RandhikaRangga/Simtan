<!--begin::Row-->
<div class="row">
    <div class="col-sm-6">
        <h3 class="mb-0">Edit Data Komoditas Tanaman</h3>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="<?= site_url('Admin') ?>">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="<?= site_url('Admin-Komoditas') ?>">Data Komoditas</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Data Komoditas</li>
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
            <div class="card-title">Edit Data Komoditas</div>
        </div>
        <!--end::Header-->
        <!--begin::Form-->
        <form method="post" action="">
            <!--begin::Body-->
            <div class="card-body">
                <div class="row mb-3">
                    <label for="inputKomoditasl3" class="col-sm-2 col-form-label">Komoditas</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="komoditas" id="inputKomoditas3"
                            value="<?= $record->komoditas; ?>" />
                    </div>
                </div>
            </div>
            <!--end::Body-->
            <!--begin::Footer-->
            <div class="card-footer">
                <a href="<?= site_url('Admin-Komoditas') ?>"><button type="button"
                        class="btn btn-danger">Kembali</button></a>
                <button type="submit" class="btn float-end btn-primary">Update Data</button>
            </div>
            <!--end::Footer-->
        </form>
        <!--end::Form-->
    </div>
</div>