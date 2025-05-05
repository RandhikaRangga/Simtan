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
                <p><strong>Total Tanam <span id="bulan-tanam">-</span>:</strong> <span id="info-total-tanam">-</span>
                </p>
                <p><strong>Total Panen <span id="bulan-panen">-</span>:</strong> <span id="info-total-panen">-</span>
                </p>
                <p><strong>Total Produksi <span id="bulan-produksi">-</span>:</strong> <span
                        id="info-total-produksi">-</span></p>
            </div>
        </div>
    </div>
</div>

<script>
// Inisialisasi peta
var map = L.map('map').setView([-6.8797, 109.1256], 12);

// Tambahkan layer peta
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; OpenStreetMap contributors'
}).addTo(map);

// Variabel untuk menyimpan layer yang aktif
var activeLayer = null;

function getColor(kondisi) {
    return kondisi === "Baik" ? "#87CEFA" :
        kondisi === "Buruk" ? "gray" :
        "green";
}

// Fungsi untuk mereset style layer sebelumnya
function resetActiveLayer() {
    if (activeLayer) {
        activeLayer.setStyle({
            fillOpacity: 0.7,
            weight: 1
        });
    }
}

$.getJSON("<?= base_url('lahan/getPoligon') ?>", function(geojsonData) {
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
            layer.on('click', function(e) {
                // Reset layer sebelumnya
                resetActiveLayer();

                // Set layer aktif yang baru
                activeLayer = e.target;
                activeLayer.setStyle({
                    weight: 3,
                    fillOpacity: 0.9
                });

                // Update informasi
                updateInfoPanel(feature.properties);

                // Tampilkan panel info
                $("#info-column").removeClass("d-none");
                $("#map-column").removeClass("col-md-12").addClass("col-md-8");
            });
        }
    }).addTo(map);
});

// Fungsi untuk memperbarui panel info
function updateInfoPanel(props) {
    $("#info-lahan").text(props.lahan || '-');
    $("#info-kecamatan").text(props.kecamatan || '-');
    $("#info-desa").text(props.desa || '-');
    $("#info-luas").text(props.luas || '-');
    $("#info-irigasi").text(props.irigasi || '-');
    $("#info-kondisi").text(props.kondisi || '-');

    if (props.kecamatan_id) {
        loadTotalProduksi(props.kecamatan_id);
    } else {
        resetProductionInfo();
    }
}

// Fungsi untuk memuat data produksi
function loadTotalProduksi(kecamatan_id) {
    $.getJSON("<?= base_url('lahan/getTotalProduksi') ?>/" + kecamatan_id)
        .done(function(data) {
            function formatNumber(num) {
                return num ? (Number.isInteger(num) ? num : parseFloat(num).toFixed(2)) : '0';
            }

            $('#info-total-tanam').text(formatNumber(data.total_tanam) + " ha");
            $('#info-total-panen').text(formatNumber(data.total_panen) + " ha");
            $('#info-total-produksi').text(formatNumber(data.total_produksi) + " ton");
        })
        .fail(function() {
            resetProductionInfo();
            console.error("Gagal memuat data produksi");
        });
}

// Fungsi untuk mereset info produksi
function resetProductionInfo() {
    $('#info-total-tanam').text('0 ha');
    $('#info-total-panen').text('0 ha');
    $('#info-total-produksi').text('0 ton');
}

// Event untuk menutup panel info
$('#close-info').click(function() {
    resetActiveLayer();
    $("#info-column").addClass("d-none");
    $("#map-column").removeClass("col-md-8").addClass("col-md-12");
});

// Set bulan
const bulan = new Date().toLocaleString('id-ID', {
    month: 'long',
    year: 'numeric'
});
$("#bulan-tanam, #bulan-panen, #bulan-produksi").text(bulan);
</script>