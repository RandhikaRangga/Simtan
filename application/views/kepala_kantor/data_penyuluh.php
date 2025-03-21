<!--begin::Row-->
<div class="row">
    <div class="col-sm-6">
        <h3 class="mb-0">Data Penyuluh Kabupaten Tegal</h3>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data Penyuluh</li>
        </ol>
    </div>
</div>
<!--end::Row-->
</div>
<!--end::Container-->
</div>
<!--end::App Content Header-->
<div class="col-md-12" style="padding: 15px;">
    <div class="card mb-4">
        <div class="card">
            <div style="padding: 10px; display:flex; justify-content:flex-start;">
                <!-- <button type="button" class="btn btn-primary" style="width: 300px; margin-right: 15px"><i
                        class="fa-solid fa-plus"></i>
                    Tambah
                    Data
                    Penyuluh</button> -->
                <button type="button" class="btn btn-success" style="width: 300px; color:white"><i
                        class="fa-solid fa-file-export"></i>
                    Cetak
                    Data
                    Penyuluh</button>
            </div>
            <div class="card-body">
                <table id="tanam" class="table table-hover table-bordered">
                    <thead>
                        <tr class="table-primary">
                            <th>No</th>
                            <th>Nama</th>
                            <th>Role</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = $this->uri->segment(3) + 1;
                        foreach ($penyuluh as $row) : ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $row->username; ?></td>
                            <td><?= $row->role; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <!-- /.card-body -->
</div>