<!--begin::Row-->
<div class="row">
    <div class="col-sm-8">
        <h3 class="mb-0">Sistem Manajemen Tanam Dinas Pertanian Kabupaten Tegal</h3>
    </div>
    <!-- <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Small Box</li>
        </ol>
    </div> -->
</div>
<!--end::Row-->
</div>
<!--end::Container-->
</div>
<!--end::App Content Header-->
<!--begin::App Content-->
<div class="app-content">
    <!--begin::Container-->
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- Tabel Laporan Hari Ini -->
                    <div class="col-md-6">
                        <div class="card mt-3 mb-3">
                            <div class="card-body">
                                <h3 class="card-title mb-3">LAPORAN HARI INI</h3>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr class="table-primary">
                                            <th>No</th>
                                            <th>Komoditas</th>
                                            <th>Tanam (Ha)</th>
                                            <th>Panen (Ha)</th>
                                            <th>Produksi (Ton)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $no = 1;
                                        foreach ($rekap_harian as $row) : ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $row['komoditas'] ?></td>
                                            <td><?= $row['total_tanam'] ?></td>
                                            <td><?= $row['total_panen'] ?></td>
                                            <td><?= $row['total_produksi'] ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Tabel Laporan Bulan Ini -->
                    <div class="col-md-6">
                        <div class="card mt-3 mb-3">
                            <div class="card-body">
                                <h3 class="card-title mb-3">LAPORAN BULAN INI</h3>
                                <table class="table table-hover table-bordered">
                                    <thead>
                                        <tr class="table-primary">
                                            <th>No</th>
                                            <th>Komoditas</th>
                                            <th>Tanam (Ha)</th>
                                            <th>Panen (Ha)</th>
                                            <th>Produksi (Ton)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $no = 1;
                                        foreach ($rekap_bulanan as $row) : ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $row['komoditas'] ?></td>
                                            <td><?= $row['total_tanam'] ?></td>
                                            <td><?= $row['total_panen'] ?></td>
                                            <td><?= $row['total_produksi'] ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabel Laporan Tahun Ini -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card mt-3 mb-3">
                            <div class="card-body">
                                <h3 class="card-title mb-3">LAPORAN TAHUN INI</h3>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr class="table-primary">
                                            <th>No</th>
                                            <th>Komoditas</th>
                                            <th>Tanam (Ha)</th>
                                            <th>Panen (Ha)</th>
                                            <th>Produksi (Ton)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $no = 1;
                                        foreach ($rekap_tahunan as $row) : ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $row['komoditas'] ?></td>
                                            <td><?= $row['total_tanam'] ?></td>
                                            <td><?= $row['total_panen'] ?></td>
                                            <td><?= $row['total_produksi'] ?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!--end::Container-->
</div>
<!--end::App Content-->
</main>
<!--end::App Main-->