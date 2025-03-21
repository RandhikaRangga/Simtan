<!--begin::Row-->
<div class="row">
    <div class="col-md-6 col-sm-12">
        <h3 class="mb-0">Data Tanam Kabupaten Tegal</h3>
    </div>
    <div class="col-md-6 col-sm-12">
        <ol class="breadcrumb float-md-end float-sm-start">
            <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data Tanam</li>
        </ol>
    </div>
</div>
<!--end::Row-->

<div class="col-12" style="padding: 15px;">
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0">Kelola Data</h5>
            <button id="btnTambahData" type="button" class="btn btn-primary">
                <i class="fa-solid fa-plus"></i> Tambah Data Tanam
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="tanam" class="table table-hover table-bordered display nowrap">
                    <thead>
                        <tr class="table-primary text-center">
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Kategori</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Padi</td>
                            <td>Pangan</td>
                            <td>12</td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-warning btn-sm">
                                        <i class="fa-solid fa-pen-to-square"></i> Edit
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm">
                                        <i class="fa-solid fa-trash-can"></i> Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Beras</td>
                            <td>Pangan</td>
                            <td>12</td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-warning btn-sm">
                                        <i class="fa-solid fa-pen-to-square"></i> Edit
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm">
                                        <i class="fa-solid fa-trash-can"></i> Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>Kapuk</td>
                            <td>Pangan</td>
                            <td>12</td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-warning btn-sm">
                                        <i class="fa-solid fa-pen-to-square"></i> Edit
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm">
                                        <i class="fa-solid fa-trash-can"></i> Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>