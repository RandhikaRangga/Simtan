<style>
#mapid {
    height: 600px;
    /* Default tinggi peta */
    width: 100%;
    /* Sesuaikan lebar peta dengan container */
}

.text-wrap {
    word-wrap: break-word;
    word-break: break-word;
    white-space: normal;
}

/* Media query untuk memastikan jarak antar elemen tetap nyaman */
@media (max-width: 576px) {
    #mapid {
        height: 300px;
        /* Tinggi peta disesuaikan untuk layar kecil */
    }
}
</style>

<!--begin::Row-->
<div class="row">
    <div class="col-sm-6">
        <h3 class="mb-0">Pemetaan Data Lahan Pertanian</h3>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="dashboard">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data Lahan</li>
        </ol>
    </div>
</div>
<!--end::Row-->

<div class="row mt-4">
    <!-- Map Section -->
    <div class="col-lg-8 col-md-7 col-12">
        <div id="mapid"></div>
    </div>

    <!-- Card Section -->
    <div class="col-lg-4 col-md-5 col-12">
        <div class="card">
            <img src="assets/foto/lahan.png" class="card-img-top" alt="...">
            <ul class="list-group list-group-flush">
                <table class="table">
                    <tbody>
                        <tr>
                            <td>Luas</td>
                            <td>:</td>
                            <td>1000 Hektar</td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td>:</td>
                            <td class="text-wrap">aaaaaaaaaaaaaaaaaaaaaaaaaaaaaa</td>
                        </tr>
                        <tr>
                            <td>Desa</td>
                            <td>:</td>
                            <td>Ujungrusi</td>
                        </tr>
                        <tr>
                            <td>Kecamatan</td>
                            <td>:</td>
                            <td>Ujungrusi</td>
                        </tr>
                        <tr>
                            <td>Status</td>
                            <td>:</td>
                            <td>Siap Pakai</td>
                        </tr>
                    </tbody>
                </table>
            </ul>
        </div>
    </div>
</div>

<script>
var mymap = L.map('mapid').setView([-6.96583703966854, 109.14216457919316], 12);

L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, ' +
        'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>'
}).addTo(mymap);
</script>