<!--begin::Row-->
<div class="row">
    <div class="col-sm-6">
        <h3 class="mb-0">Data Penyakit Kabupaten Tegal</h3>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data Penyakit</li>
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
                <button type="button" class="btn btn-primary" style="width: 300px; margin-right: 15px"><i
                        class="fa-solid fa-plus"></i>
                    Tambah
                    Data
                    Penyakit</button>
                <button type="button" class="btn btn-success" style="width: 300px; color:white"><i
                        class="fa-solid fa-file-export"></i>
                    Cetak
                    Data
                    Penyakit</button>
            </div>
            <div class="card-body">
                <table id="tanam" class="table table-hover table-bordered">
                    <thead>
                        <tr class="table-primary">
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
                            <td><a href=""><button type="button" class="btn btn-warning" style="width: 100px"><i
                                            class="fa-solid fa-pen-to-square"></i>
                                        Edit</button></a>
                                <a href=""><button type="button" class="btn btn-danger" style="width: 100px"><i
                                            class="fa-solid fa-trash-can"></i>
                                        Hapus</button></a>
                            </td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>beras</td>
                            <td>Pangan</td>
                            <td>12</td>
                            <td><a href=""><button type="button" class="btn btn-warning" style="width: 100px"><i
                                            class="fa-solid fa-pen-to-square"></i> Edit</button></a>
                                <a href=""><button type="button" class="btn btn-danger" style="width: 100px"><i
                                            class="fa-solid fa-trash-can"></i> Hapus</button></a>
                            </td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>kapuk</td>
                            <td>Pangan</td>
                            <td>12</td>
                            <td><a href=""><button type="button" class="btn btn-warning" style="width: 100px"><i
                                            class="fa-solid fa-pen-to-square"></i> Edit</button></a>
                                <a href=""><button type="button" class="btn btn-danger" style="width: 100px"><i
                                            class="fa-solid fa-trash-can"></i> Hapus</button></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <!-- /.card-body -->
</div>