<style>
.only-print {
    display: none !important;
}
</style>

<!--begin::Row-->
<div class="row">
    <div class="col-sm-6">
        <h3 class="mb-0">Laporan Data Tanam Kabupaten Tegal</h3>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="<?= base_url('admin'); ?>">Dashboard</a></li>
            <li class="breadcrumb-item active">Laporan Data Tanam</li>
        </ol>
    </div>
</div>
<!--end::Row-->
<div class="col-md-12 p-3">
    <div class="card mb-4">
        <div class="card-body">
            <!-- Filter Data -->
            <div class="no-print">
                <form method="GET" action="<?= base_url('laporantanam/view_admin') ?>" class="mb-3">
                    <div class="row align-items-end">
                        <div class="col-md-2">
                            <label for="bulan">Bulan:</label>
                            <select name="bulan" id="bulan" class="form-select">
                                <?php
                                $bulan_arr = [
                                    'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                                    'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
                                ];
                                foreach ($bulan_arr as $key => $b) :
                                    $selected = ($key + 1 == $bulan) ? 'selected' : '';
                                    echo "<option value='" . ($key + 1) . "' $selected>$b</option>";
                                endforeach;
                            ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="tahun">Tahun:</label>
                            <input type="text" class="form-control" name="tahun" value="<?= $tahun ?>" />
                        </div>
                        <div class="col-md-2">
                            <label for="kecamatan">Kecamatan:</label>
                            <select name="kecamatan" id="kecamatan" class="form-select">
                                <option value="all" <?= ($selected_kecamatan == 'all') ? 'selected' : '' ?>>Semua
                                    Kecamatan
                                </option>
                                <?php foreach ($kecamatan as $k) : ?>
                                <option value="<?= $k->id ?>" <?= ($k->id == $selected_kecamatan) ? 'selected' : '' ?>>
                                    <?= $k->kecamatan ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="desa">Desa:</label>
                            <select name="desa" id="desa" class="form-select">
                                <option value="all" <?= ($selected_desa == 'all') ? 'selected' : '' ?>>Pilih Desa
                                </option>
                                <?php foreach ($desa as $d) : ?>
                                <option value="<?= $d->id ?>" <?= ($d->id == $selected_desa) ? 'selected' : '' ?>>
                                    <?= $d->desa ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </div>
                    </div>
                </form>

                <!-- Tombol Ekspor & Print -->
                <div class="mb-3">
                    <form method="POST" action="<?= base_url('laporantanam/convert_excel') ?>" class="d-inline">
                        <input type="hidden" name="bulan" value="<?= $bulan ?>">
                        <input type="hidden" name="tahun" value="<?= $tahun ?>">
                        <input type="hidden" name="kecamatan" value="<?= $selected_kecamatan ?>">
                        <input type="hidden" name="desa" value="<?= $selected_desa ?>">
                        <button type="submit" class="btn btn-success"><i class="fa-solid fa-file-excel"></i> Export
                            Excel</button>
                    </form>

                    <button class="btn btn-danger" onclick="printWithHeader()"><i class="fa-solid fa-file-pdf"></i>
                        Export PDF</button>
                </div>
                <hr>
            </div>
            <div id="area_cetak">
                <div class="only-print">
                    <h3 style="text-align: center;">Laporan Data Tanam Kabupaten Tegal</h3>
                    <div class="print-row">
                        <div class="print-item">
                            <label>Bulan:</label>
                            <span><?= isset($bulan) ? htmlspecialchars($bulan_arr[$bulan - 1]) : ''; ?></span>
                        </div>
                        <div class="print-item">
                            <label>Tahun:</label>
                            <span><?= $tahun ?></span>
                        </div>
                        <div class="print-item">
                            <label>Kecamatan:</label>
                            <span>
                                <?php
                                    $nama_kecamatan = ($selected_kecamatan == 'all') ? 'Semua Kecamatan' : '';
                                    foreach ($kecamatan as $k) {
                                        if ($k->id == $selected_kecamatan) {
                                            $nama_kecamatan = $k->kecamatan;
                                            break;
                                        }
                                    }
                                    echo htmlspecialchars($nama_kecamatan);
                                    ?>
                            </span>
                        </div>
                        <div class="print-item">
                            <label>Desa:</label>
                            <span>
                                <?php
                                    $nama_desa = ($selected_desa == 'all') ? 'Semua Desa' : '';
                                    foreach ($desa as $d) {
                                        if ($d->id == $selected_desa) {
                                            $nama_desa = $d->desa;
                                            break;
                                        }
                                    }
                                    echo htmlspecialchars($nama_desa);
                                    ?>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Tabel Data Tanam -->
                <table id="laporanTable" class="table table-hover table-bordered"
                    style="text-align: center; vertical-align:middle">
                    <thead>
                        <tr class="table-primary">
                            <th rowspan="2">No</th>
                            <th rowspan="2">Komoditas</th>
                            <th colspan="<?= date('t', strtotime("$tahun-$bulan-01")) ?>">Tanggal</th>
                            <th rowspan="2">Total</th>
                        </tr>
                        <tr>
                            <?php for ($i = 1; $i <= date('t', strtotime("$tahun-$bulan-01")); $i++) { ?>
                            <th><?= $i ?></th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                    $no = 1;
                    foreach ($komoditas as $k) {
                        echo "<tr>";
                        echo "<td>$no</td>";
                        echo "<td>{$k->komoditas}</td>";

                        $total = 0;
                        for ($i = 1; $i <= date('t', strtotime("$tahun-$bulan-01")); $i++) {
                            $luas_tanam = 0;
                            foreach ($data_tanam as $dt) {
                                if ($dt->komoditas == $k->komoditas && $dt->tanggal == $i) {
                                    $luas_tanam = $dt->luas_tanam;
                                    $total += $luas_tanam;
                                }
                            }
                            echo "<td>$luas_tanam</td>";
                        }

                        echo "<td><strong>$total</strong></td>";
                        echo "</tr>";
                        $no++;
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- AJAX untuk Menampilkan Desa Berdasarkan Kecamatan -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
function printWithHeader() {
    var kopSuratHTML = `
        <div style="display: flex; align-items: center; justify-content: center; margin-bottom: 10px;">
            <img id="logoCetak" src="<?= base_url('assets/Foto/logo.png') ?>" style="width: 60px; margin-right: 15px;">
            <div style="text-align: left;">
                <h3 style="margin: 2px 0;">PEMERINTAH KABUPATEN TEGAL</h3>
                <h4 style="margin: 2px 0;">DINAS PERTANIAN DAN KETAHANAN PANGAN</h4>
                <p style="margin: 2px 0;">Jl. A. Yani 17 A Procot, Slawi, Kabupaten Tegal, Jawa Tengah</p>
            </div>
        </div>
        <hr>`;

    // Ambil area cetak
    var contentToPrint = document.getElementById('area_cetak').cloneNode(true);

    // Sembunyikan elemen yang tidak perlu saat cetak
    var elementsToHide = contentToPrint.querySelectorAll("select, button");
    elementsToHide.forEach(el => el.classList.add("no-print"));

    var style = `
        <style>
        @media print {
            img { display: block !important; visibility: visible !important; }
            .no-print { display: none !important; } /* Sembunyikan elemen tertentu saat cetak */
            .only-print { display: block !important; justify-content: space-between; align-items: flex-end; gap: 20px; } /* Tampilkan elemen hanya saat cetak */
            .print-row { display: flex; justify-content: space-between; align-items: center; gap: 10px; }
            .print-item { display: flex; align-items: center; gap: 5px;}
            .print-item label { font-weight: bold;} 
            .print-item span {border: 1px solid #000; padding: 3px 10px; display: inline-block; min-width: 100px; text-align: center; }
        }
        table { 
            width: 100%; 
            border-collapse: collapse;
            margin-top: 20px; 
        }
        th, td { 
            border: 1px solid black; 
            padding: 5px; 
            text-align: center; 
        }
        </style>`;

    // Buat iframe tersembunyi
    var iframe = document.createElement('iframe');
    iframe.style.position = "absolute";
    iframe.style.width = "0px";
    iframe.style.height = "0px";
    iframe.style.border = "none";
    document.body.appendChild(iframe);

    var doc = iframe.contentWindow.document;
    doc.open();
    doc.write('<html><head><title>Cetak</title>' + style + '</head><body>');
    doc.write(kopSuratHTML);
    doc.write(contentToPrint.outerHTML);
    doc.write('</body></html>');
    doc.close();

    // Tunggu agar gambar termuat sebelum cetak
    iframe.contentWindow.onload = function() {
        setTimeout(() => {
            iframe.contentWindow.focus();
            iframe.contentWindow.print();
            setTimeout(() => document.body.removeChild(iframe), 1000); // Hapus iframe setelah cetak
        }, 500);
    };
}
</script>
<script>
$(document).ready(function() {
    function loadDesa(kecamatan_id) {
        $.ajax({
            url: "<?= base_url('tanam/get_desa_by_kecamatan') ?>",
            type: "POST",
            data: {
                kecamatan_id: kecamatan_id
            },
            dataType: "json",
            success: function(data) {
                $("#desa").html('<option value="all">Semua Desa</option>');
                $.each(data, function(index, desa) {
                    $("#desa").append('<option value="' + desa.id + '">' + desa.desa +
                        '</option>');
                });
            }
        });
    }

    $("#kecamatan").change(function() {
        loadDesa($(this).val());
    });

    loadDesa($("#kecamatan").val());
});
</script>