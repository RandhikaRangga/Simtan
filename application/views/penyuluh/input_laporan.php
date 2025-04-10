<!--begin::Row-->
<div class="row">
    <div class="col-sm-6">
        <h3 class="mb-0">Input Laporan Harian Pertanian Kabupaten Tegal</h3>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="Penyuluh">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Input Laporan</li>
        </ol>
    </div>
</div>
<!--end::Row-->
</div>
<!--end::Container-->
</div>
<!--end::App Content Header-->
<div class="col-md-12 p-3">
    <div class="card mb-4">
        <div class="card">
            <div class="p-3 d-md-flex flex-wrap gap-2 justify-content-md-start justify-content-center">
                <a href="<?= base_url('Penyuluh-TambahLaporan'); ?>" class="col-12 col-md-auto mb-8">
                    <button type="button" class="btn btn-primary w-100 w-md-auto">
                        <i class="fa-solid fa-plus"></i> Tambah Laporan Harian
                    </button>
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="tanam" class="table table-hover table-bordered">
                        <thead>
                            <tr class="table-primary">
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Kecamatan</th>
                                <th>Desa</th>
                                <th>Penyuluh</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $no = 1;
                            foreach ($laporan as $row):
                            ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= $row->tgl_tanam ?></td>
                                <td><?= $row->nama_kecamatan ?></td>
                                <td><?= $row->nama_desa ?></td>
                                <td><?= $row->penyuluh ?></td>
                                <td>
                                    <a class="d-block d-md-inline-block mb-2 mb-md-0">
                                        <button type="button" class="btn btn-info btn-detail"
                                            data-id="<?= $row->batch_id; ?>" data-bs-toggle="modal"
                                            data-bs-target="#modalDetailData">
                                            <i class="fa-solid fa-circle-info"></i> Detail Data
                                        </button>
                                    </a>
                                    <a href="<?= site_url('Penyuluh-EditLaporan/' . $row->batch_id) ?>"
                                        class="d-block d-md-inline-block mb-2 mb-md-0">
                                        <button type="button" class="btn btn-warning w-100 w-md-auto">
                                            <i class="fa-solid fa-pen-to-square"></i> Edit
                                        </button>
                                    </a>

                                    <a href="<?= site_url('Penyuluh-HapusLaporan/' . $row->batch_id); ?>"
                                        class="d-block d-md-inline-block mb-2 mb-md-0">
                                        <button type="button" class="btn btn-danger w-100 w-md-auto btn-delete">
                                            <i class="fa-solid fa-trash"></i> Hapus
                                        </button>
                                    </a>

                                </td>
                            </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- /.card-body -->
</div>

<div class=" modal fade" id="modalDetailData" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Data Laporan Harian</h5>
            </div>
            <div class="modal-body">
                <form>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mt-2">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="card-tittle">Periode</div>
                                    </div>
                                    <div class="card-body">
                                        <label>Penyuluh:</label>
                                        <input type="text" name="penyuluh" class="form-control" id="penyuluh"
                                            readonly><br>

                                        <label>Tanggal:</label>
                                        <input type="text" name="tanggal" class="form-control" id="tanggal"
                                            readonly><br>

                                        <label>Kecamatan:</label>
                                        <input type="text" name="kecamatan" class="form-control" id="kecamatan"
                                            readonly><br>

                                        <label>Desa:</label>
                                        <input type="text" name="desa" class="form-control" id="desa" readonly><br>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-8 mt-2">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="card-tittle">Data Laporan</div>
                                    </div>
                                    <div class="card-body">
                                        <table class="table">
                                            <thead class="table-primary">
                                                <tr>
                                                    <th>No</th>
                                                    <th>Komoditas</th>
                                                    <th>Tanam (ha)</th>
                                                    <th>Panen (ha)</th>
                                                    <th>Produksi (ton)</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tablebody">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
    $(".btn-detail").click(function() {
        var batch_id = $(this).attr("data-id");
        var tableBody = $("#tablebody");
        tableBody.empty();

        $.ajax({
            url: "<?= site_url('InputLaporan/get_data_tanam') ?>",
            type: "POST",
            data: {
                batch_id: batch_id
            },
            dataType: "json",
            success: function(response) {
                if (response.laporan.length > 0) {
                    // Isi informasi umum batch
                    $("#penyuluh").val(response.batch_info.penyuluh);
                    $("#tanggal").val(response.batch_info.tgl_tanam);
                    $("#kecamatan").val(response.batch_info.nama_kecamatan);
                    $("#desa").val(response.batch_info.nama_desa);

                    // Isi tabel komoditas
                    $.each(response.laporan, function(index, item) {
                        var row = "<tr>" +
                            "<td>" + (index + 1) + "</td>" +
                            "<td>" + item.komoditas + "</td>" +
                            "<td>" + formatNumber(item.luas_tanam) + "</td>" +
                            "<td>" + formatNumber(item.luas_panen) + "</td>" +
                            "<td>" + formatNumber(item.berat_produksi) + "</td>" +
                            "</tr>";
                        tableBody.append(row);

                        // Blur
                        $('.modal-backdrop').addClass('blur');

                        $('#modalDetail').on('hidden.bs.modal',
                            function() {
                                $('.modal-backdrop')
                                    .removeClass('blur');
                            });
                        $('#modalDetail').modal('show');
                    });
                } else {
                    tableBody.append(
                        "<tr><td colspan='5' class='text-center'>Data tidak ditemukan</td></tr>"
                    );
                }
            },
            error: function(xhr, status, error) {
                console.error("Terjadi kesalahan:", error);
            }
        });
    });
});

// Notifikasi SweetAlert2 (Tambah, Edit, Hapus)
document.addEventListener("DOMContentLoaded", function() {
    <?php foreach (['success_tambah', 'error_tambah', 'success_edit', 'error_edit', 'success', 'error'] as $flash) : ?>
    <?php if ($this->session->flashdata($flash)) : ?>
    Swal.fire({
        icon: '<?= strpos($flash, 'success') !== false ? 'success' : 'error' ?>',
        title: '<?= strpos($flash, 'success') !== false ? 'Sukses!' : 'Gagal!' ?>',
        text: "<?= $this->session->flashdata($flash) ?>",
        showConfirmButton: false,
        timer: 2000
    });
    <?php endif; ?>
    <?php endforeach; ?>

    document.querySelectorAll(".btn-delete").forEach(button => {
        button.addEventListener("click", function(e) {
            e.preventDefault();
            let url = this.closest("a").getAttribute("href");
            Swal.fire({
                title: "Apakah Anda yakin?",
                text: "Data yang dihapus tidak bisa dikembalikan!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#d33",
                cancelButtonColor: "#3085d6",
                confirmButtonText: "Ya, Hapus!",
                cancelButtonText: "Batal"
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = url;
                }
            });
        });
    });
});

function formatNumber(num) {
    if (!num || isNaN(num)) return '-';
    return new Intl.NumberFormat('id-ID', {
        minimumFractionDigits: 0,
        maximumFractionDigits: 2
    }).format(num);
}
</script>