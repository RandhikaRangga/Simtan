<style>
#map {
    height: 400px;
    width: 100%;
    margin-top: 10px;
}
</style>

<!--begin::Row-->
<div class="row">
    <div class="col-sm-6">
        <h3 class="mb-0">Tambah Data Lahan Kabupaten Tegal</h3>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="Admin">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="Admin-Lahan">Data Lahan</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tambah Data Lahan</li>
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
            <div class="card-title">Tambah Data Lahan</div>
        </div>
        <!--end::Header-->
        <!--begin::Form-->
        <div class="card-body">
            <div class="row">
                <!-- Kolom Form -->
                <div class="col-md-6">
                    <form method="POST" action="">
                        <label>Nama Lahan:</label>
                        <input type="text" name="lahan" class="form-control" required><br>

                        <label>Kecamatan:</label>
                        <select name="kecamatan_id" id="kecamatan" class="form-control" required>
                            <option value="">-- Pilih Kecamatan --</option>
                            <?php foreach ($kecamatan as $k): ?>
                            <option value="<?= $k->id ?>"><?= $k->kecamatan ?></option>
                            <?php endforeach; ?>
                        </select><br>

                        <label>Desa:</label>
                        <select name="desa_id" id="desa" class="form-control" required>
                            <option value="">-- Pilih Desa --</option>
                        </select><br>

                        <label>Luas:</label>
                        <input type="text" name="luas" class="form-control" required><br>

                        <label>Irigasi:</label>
                        <input type="text" name="irigasi" class="form-control" required><br>

                        <label>Kondisi:</label>
                        <select name="kondisi" class="form-control" required>
                            <option value="">-- Pilih Kondisi --</option>
                            <option value="Baik">Baik</option>
                            <option value="Buruk">Buruk</option>
                        </select><br>

                        <label>Koordinat (Lat, Lng):</label>
                        <textarea id="koordinat" name="koordinat" rows="4" class="form-control" required></textarea><br>
                </div>

                <!-- Kolom Peta -->
                <div class="col-md-6">
                    <div id="map"></div><br>

                    <input type="hidden" id="geojson" name="geojson">
                    <button type="button" id="preview" class="btn btn-primary">Preview</button>
                    <a href="Admin-Lahan"><button type="button" class="btn btn-danger">Kembali</button></a>
                    <button type="submit" class="btn btn-success">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    let map = L.map('map').setView([-6.9, 109.1], 10);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

    let polygonLayer;

    document.getElementById("preview").addEventListener("click", function() {
        let inputText = document.getElementById("koordinat").value.trim();
        let lines = inputText.split("\n");
        let coordinates = [];

        lines.forEach(line => {
            let point = line.split(",");
            if (point.length === 2) {
                let lat = parseFloat(point[0].trim());
                let lng = parseFloat(point[1].trim());
                if (!isNaN(lat) && !isNaN(lng)) {
                    coordinates.push([lng, lat]); // GeoJSON format (lng, lat)
                }
            }
        });

        if (coordinates.length < 3) {
            alert("Minimal 3 titik untuk membentuk poligon!");
            return;
        }

        // Pastikan poligon tertutup
        coordinates.push(coordinates[0]);

        let geoJsonData = {
            "type": "Polygon",
            "coordinates": [coordinates]
        };

        // Hapus poligon lama jika ada
        if (polygonLayer) {
            map.removeLayer(polygonLayer);
        }

        // Tambahkan poligon baru
        polygonLayer = L.geoJSON(geoJsonData).addTo(map);
        map.fitBounds(polygonLayer.getBounds());

        // Simpan GeoJSON ke input hidden
        document.getElementById("geojson").value = JSON.stringify(geoJsonData);
    });
});

$(document).ready(function() {
    $('#kecamatan').change(function() {
        var kecamatan_id = $(this).val(); // Ambil ID Kecamatan

        // Jika kecamatan dipilih
        if (kecamatan_id) {
            $.ajax({
                url: "<?= base_url('inputlaporan/get_desa_by_kecamatan') ?>", // Panggil Controller
                type: "POST",
                data: {
                    kecamatan_id: kecamatan_id
                },
                dataType: "json",
                success: function(data) {
                    $('#desa').html('<option value="">-- Pilih Desa --</option>');
                    $.each(data, function(key, value) {
                        $('#desa').append('<option value="' + value.id + '">' +
                            value.desa + '</option>');
                    });
                }
            });
        } else {
            $('#desa').html('<option value="">-- Pilih Desa --</option>');
        }
    });
});
</script>