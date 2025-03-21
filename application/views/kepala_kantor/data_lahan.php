<style>
.container {
    display: flex;
    gap: 10px;
}

.text-wrap {
    word-wrap: break-word;
    /* Memaksa teks panjang terpotong */
    word-break: break-word;
    /* Memutus kata jika terlalu panjang */
    white-space: normal;
    /* Membungkus teks */
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
</div>
<!--end::Container-->
</div>
<!--end::App Content Header-->
<div class="container">
    <div id="mapid" style="height: 600px; width: 1000px;"></div>

    <div class="card" style="width: 18rem;">
        <img src="assets/foto/lahan.png" class="card-img-top" alt="...">
        <!-- <div class="card-body">
            <h5 class="card-title">Card title</h5>
        </div> -->
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
            <!-- <li class="list-group-item">Luas : </li>
            <li class="list-group-item">Kecamatan : </li>
            <li class="list-group-item">A third item</li> -->
        </ul>
    </div>
</div>

<script>
var mymap = L.map('mapid').setView([-6.96583703966854, 109.14216457919316], 12);

L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, ' +
        'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
    id: 'mapbox/streets-v11',

}).addTo(mymap);
</script>