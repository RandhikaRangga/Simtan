<style>
#mapDetail {
    width: 100%;
    /* Atau ukuran piksel tertentu, misalnya 400px */
    height: 400px;
    /* Atau ukuran piksel tertentu */
}
</style>

<!--begin::Row-->
<div class="row">
    <div class="col-sm-6">
        <h3 class="mb-0">Data Lahan Kabupaten Tegal</h3>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="Admin">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data Lahan</li>
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
                <a href="<?= base_url('Admin-TambahLahan'); ?>" class="col-6 col-md-auto mb-4">
                    <button type="button" class="btn btn-primary w-100 w-md-auto">
                        <i class="fa-solid fa-plus"></i> Tambah Data Lahan
                    </button>
                </a>
            </div>
            <div class="card-body">
                <table id="datatableNormal" class="table table-hover table-bordered">
                    <thead>
                        <tr class="table-primary">
                            <th>No</th>
                            <th>Kecamatan</th>
                            <th>Desa</th>
                            <th>Nama Lahan</th>
                            <th>Luas (Ha)</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = $this->uri->segment(3) + 1;
                        foreach ($lahan as $row) : ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $row->kecamatan ?></td>
                            <td><?= $row->desa ?></td>
                            <td><?= $row->lahan ?></td>
                            <td><?= number_format($row->luas, 0, ',', '.') ?></td>
                            <td>
                                <a class="d-block d-md-inline-block mb-2 mb-md-0">
                                    <button type="button" class="btn btn-info w-100 w-md-auto btn-detail"
                                        data-id="<?= $row->id; ?>" data-bs-toggle="modal" data-bs-target="#modalDetail">
                                        <i class="fa-solid fa-circle-info"></i> Detail Data
                                    </button>
                                </a>
                                <a href="<?= site_url('Admin-EditLahan/' .$row->id) ?>"
                                    class="d-block d-md-inline-block mb-2 mb-md-0">
                                    <button type="button" class="btn btn-warning w-100 w-md-auto">
                                        <i class="fa-solid fa-pen-to-square"></i> Edit
                                    </button>
                                </a>
                                <a href="<?= site_url('Admin-HapusLahan/' .$row->id) ?>"
                                    class="d-block d-md-inline-block">
                                    <button type="button" class="btn btn-delete btn-danger w-100 w-md-auto">
                                        <i class="fa-solid fa-trash-can"></i> Hapus
                                    </button>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- /.card-body -->
</div>

<div class="modal fade" id="modalDetail" tabindex="-1" aria-labelledby="modalDetailLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDetailLabel">Detail Lahan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card-body">
                    <div class="row">
                        <!-- Kolom Kiri: Form -->
                        <div class="col-md-6">
                            <label>Nama Lahan:</label>
                            <input type="text" name="lahan" class="form-control" id="lahan" readonly><br>

                            <label>Kecamatan:</label>
                            <input type="text" name="kecamatan" class="form-control" id="nama_kecamatan" readonly><br>

                            <label>Desa:</label>
                            <input type="text" name="desa" class="form-control" id="nama_desa" readonly><br>

                            <label>Luas:</label>
                            <input type="text" name="luas" class="form-control" id="luas" readonly><br>

                            <label>Irigasi:</label>
                            <input type="text" name="irigasi" class="form-control" id="irigasi" readonly><br>

                            <label>Kondisi:</label>
                            <input type="text" name="kondisi" class="form-control" id="kondisi" readonly><br>

                            <label>Koordinat (Lat, Lng):</label>
                            <textarea id="koordinat" name="koordinat" rows="4" class="form-control" data-id="koordinat"
                                readonly></textarea><br>
                        </div>

                        <!-- Kolom Kanan: Peta -->
                        <div class="col-md-6">
                            <div id="mapDetail" style="width: 100%; height: 300px; border: 1px solid #ccc;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
$(document).ready(function() {
    $('.btn-detail').click(function() {
        var id = $(this).data('id');
        $.ajax({
            url: '<?= base_url('Lahan/getDetail'); ?>',
            type: 'POST',
            data: {
                id: id
            },
            dataType: 'json',
            success: function(response) {
                if (response) {
                    $('#lahan').val(response.lahan);
                    $('#nama_kecamatan').val(response.nama_kecamatan);
                    $('#nama_desa').val(response.nama_desa);
                    $('#luas').val(response.luas);
                    $('#irigasi').val(response.irigasi);
                    $('#kondisi').val(response.kondisi);
                    $('#koordinat').val(response.koordinat);

                    console.log("Data koordinat dari server:", response.koordinat);

                    // Tampilkan modal
                    $('#modalDetail').modal('show');

                    // Tunggu hingga modal terbuka, lalu tampilkan peta
                    $('#modalDetail').on('shown.bs.modal', function() {
                        setTimeout(function() {
                            initMap(response.koordinat);
                        }, 300);
                    });
                } else {
                    alert('Data tidak ditemukan.');
                }
            },
            error: function(xhr, status, error) {
                console.error("Kesalahan AJAX:", status, error);
                alert('Terjadi kesalahan saat mengambil data.');
            }
        });
    });
});

var mapDetail; // Variabel global untuk menyimpan peta

function initMap(koordinat) {
    if (mapDetail) {
        mapDetail.remove(); // Hapus peta lama sebelum membuat yang baru
    }

    mapDetail = L.map('mapDetail', {
        center: [-6.98240, 109.06349], // Koordinat default jika tidak ada data
        zoom: 15
    });

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; OpenStreetMap contributors'
    }).addTo(mapDetail);

    if (koordinat && koordinat.trim() !== "") {
        try {
            let coords = koordinat
                .trim() // Hilangkan spasi ekstra
                .split("\n") // Pisahkan berdasarkan baris baru
                .map(coord => coord.trim().split(",").map(num => parseFloat(num.trim()))); // Parsing angka

            let reversedCoords = coords.map(coord => [coord[1], coord[0]]); // Leaflet butuh [lat, lng]

            let geojsonData = {
                "type": "Feature",
                "geometry": {
                    "type": "Polygon",
                    "coordinates": [reversedCoords]
                }
            };

            console.log("GeoJSON Data:", geojsonData);

            let polygon = L.geoJSON(geojsonData, {
                style: {
                    color: "blue",
                    weight: 2,
                    opacity: 0.7,
                    fillColor: "blue",
                    fillOpacity: 0.2
                }
            }).addTo(mapDetail);

            // Menyesuaikan tampilan peta agar sesuai dengan poligon
            mapDetail.fitBounds(polygon.getBounds());

            setTimeout(function() {
                mapDetail.invalidateSize();
            }, 300);
        } catch (e) {
            console.error("Error parsing koordinat:", e);
            alert("Format koordinat tidak valid. Periksa apakah datanya menggunakan format desimal dengan titik.");
        }
    } else {
        console.error("Koordinat Kosong");
        alert("Koordinat Kosong");
    }
}

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
</script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>