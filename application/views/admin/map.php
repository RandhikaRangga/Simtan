<!--begin::Row-->
<div class="row">
    <div class="col-sm-6">
        <h3 class="mb-0">Map Lahan Kabupaten Tegal</h3>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="Admin">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Map Lahan</li>
        </ol>
    </div>
</div>
<!--end::Row-->
</div>
<!--end::Container-->
</div>
<!--end::App Content Header-->

<div class="row" id="map-container">
    <!-- Kolom Peta (Awalnya Full) -->
    <div class="col-md-12 p-3" id="map-column">
        <div class="card mb-4">
            <div class="card-body">
                <div id="map" style="height: 550px;"></div>
            </div>
        </div>
    </div>

    <!-- Kolom Informasi Lahan (Hidden Awal) -->
    <div class="col-md-4 p-3 d-none" id="info-column">
        <div class="card">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Informasi Lahan</h5>
                <button class="btn btn-sm btn-danger ms-auto" id="close-info">&times;</button>
            </div>
            <div class="card-body">
                <p><strong>Lahan:</strong> <span id="info-lahan">-</span></p>
                <p><strong>Kecamatan:</strong> <span id="info-kecamatan">-</span></p>
                <p><strong>Desa:</strong> <span id="info-desa">-</span></p>
                <p><strong>Luas:</strong> <span id="info-luas">-</span> ha</p>
                <p><strong>Irigasi:</strong> <span id="info-irigasi">-</span></p>
                <p><strong>Kondisi:</strong> <span id="info-kondisi">-</span></p>
                <p><strong>Total Tanam Bulan Ini:</strong> <span id="info-total-tanam">-</span></p>
                <p><strong>Total Panen Bulan Ini:</strong> <span id="info-total-panen">-</span></p>
                <p><strong>Total Produksi Bulan Ini:</strong> <span id="info-total-produksi">-</span></p>
            </div>
        </div>
    </div>
</div>

<script>
// Inisialisasi peta
var map = L.map('map').setView([-6.8797, 109.1256], 12); // Koordinat default (Tegal)

// Tambahkan layer peta dari OpenStreetMap
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors'
}).addTo(map);

function getColor(kondisi) {
    return kondisi === "Baik" ? "#87CEFA" :
        kondisi === "Buruk" ? "gray" :
        "green"; // Default warna jika tidak ada kondisi yang cocok
}

$.getJSON("<?= base_url('lahan/getPoligon') ?>", function(geojsonData) {
    console.log(geojsonData); // pastikan terlihat FeatureCollection di console
    L.geoJSON(geojsonData, {
        style: function(feature) {
            return {
                color: 'black',
                weight: 1,
                opacity: 0.7,
                fillColor: getColor(feature.properties.kondisi),
                fillOpacity: 0.7
            };
        },
        onEachFeature: function(feature, layer) {
            // Buat closure untuk mengakses properti fitur saat ini
            (function(featureProps) {
                layer.on('click', function() {
                    $("#info-lahan").text(featureProps.lahan);
                    $("#info-kecamatan").text(featureProps.kecamatan);
                    $("#info-desa").text(featureProps.desa);
                    $("#info-luas").text(featureProps.luas);
                    $("#info-irigasi").text(featureProps.irigasi);
                    $("#info-kondisi").text(featureProps.kondisi);

                    loadTotalProduksi(featureProps.kecamatan_id);

                    $("#info-column").removeClass("d-none");
                    $("#map-column").removeClass("col-md-12").addClass("col-md-8");
                });
            })(feature.properties); // Segera panggil fungsi dengan feature.properties saat ini
        }
    }).addTo(map);
});

function loadTotalProduksi(kecamatan_id) {
    console.log("Mengambil data untuk kecamatan_id:", kecamatan_id); // Debugging

    $.getJSON("<?= base_url('lahan/getTotalProduksi') ?>/" + kecamatan_id)
        .done(function(data) {
            console.log("Data diterima:", data); // Debugging

            // Pastikan data tidak undefined
            if (data) {
                function formatNumber(num) {
                    return Number.isInteger(num) ? num : parseFloat(num).toFixed(2).replace(/\.?0+$/, '');
                }

                $('#info-total-tanam').text(formatNumber(data.total_tanam || 0) + " ha");
                $('#info-total-panen').text(formatNumber(data.total_panen || 0) + " ha");
                $('#info-total-produksi').text(formatNumber(data.total_produksi || 0) + " ton");
            } else {
                console.log("Data kosong atau format tidak sesuai");
            }
        })
        .fail(function(jqXHR, textStatus, errorThrown) {
            console.error("Error AJAX:", textStatus, errorThrown);
        });
}

// Event untuk menutup informasi lahan dan mengembalikan peta penuh
document.getElementById('close-info').addEventListener('click', function() {
    document.getElementById('info-column').classList.add('d-none'); // Sembunyikan card
    document.getElementById('map-column').classList.replace('col-md-8', 'col-md-12'); // Kembalikan peta full
});
</script>