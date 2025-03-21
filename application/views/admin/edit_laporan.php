<!--begin::Row-->
<div class="row">
    <div class="col-sm-6">
        <h3 class="mb-0">Edit Data Laporan Tanaman</h3>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="Admin">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="Admin-InputLaporan">Data Laporan</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Data Laporan</li>
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
        <div class="card-header">
            <div class="card-title" style="text-align:right">Laporan Harian</div>
        </div>

        <form action="<?= base_url('inputlaporan/simpan_data') ?>" method="post">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mt-2">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-tittle text-center">Edit Data</div>
                            </div>
                            <div class="card-body">
                                <input type="hidden" name="batch_id"
                                    value="<?= isset($laporan['tanam'][0]->batch_id) ? $laporan['tanam'][0]->batch_id : '' ?>">

                                <label>Tanggal:</label>
                                <input type="date" name="tanggal" class="form-control"
                                    value="<?= isset($laporan['tanam'][0]->tgl_tanam) ? $laporan['tanam'][0]->tgl_tanam : '' ?>"
                                    required><br>

                                <label>Kecamatan:</label>
                                <select name="kecamatan_id" id="kecamatan" class="form-control" required>
                                    <option value="">-- Pilih Kecamatan --</option>
                                    <?php foreach ($kecamatan as $k): ?>
                                    <option value="<?= $k->id ?>"
                                        <?= isset($laporan['tanam'][0]->kecamatan_id) && $laporan['tanam'][0]->kecamatan_id == $k->id ? 'selected' : '' ?>>
                                        <?= $k->kecamatan ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select><br>

                                <label>Desa:</label>
                                <select name="desa_id" id="desa" class="form-control" required>
                                    <option value="">-- Pilih Desa --</option>
                                    <?php foreach ($desa as $d): ?>
                                    <option value="<?= $d->id ?>"
                                        <?= isset($laporan['tanam'][0]->desa_id) && $laporan['tanam'][0]->desa_id == $d->id ? 'selected' : '' ?>>
                                        <?= $d->desa ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="text-end mt-3">
                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            <a href="<?= base_url('Admin-InputLaporan') ?>" class="btn btn-secondary">Batal</a>
                        </div>
                    </div>

                    <div class="col-md-8 mt-2">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-tittle">Data Laporan</div>
                            </div>
                            <div class="card-body">
                                <table class="table table-hover table-bordered">
                                    <tr>
                                        <th>No</th>
                                        <th>Komoditas</th>
                                        <th>Tanam (ha)</th>
                                        <th>Panen (ha)</th>
                                        <th>Produksi (ton)</th>
                                    </tr>
                                    <?php $no = 1; foreach ($komoditas as $k): ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= $k->komoditas ?></td>
                                        <td><input type="text" name="tanam_<?= $k->id ?>" value="<?php 
                                            $luas_tanam = ''; 
                                            foreach ($laporan['tanam'] as $t) {
                                                if ($t->komoditas_id == $k->id) {
                                                    $luas_tanam = $t->luas;
                                                    break;
                                                }
                                            }
                                            echo $luas_tanam;
                                            ?>">
                                        </td>

                                        <td><input type="text" name="panen_<?= $k->id ?>" value="<?php 
                                                $luas_panen = ''; 
                                                foreach ($laporan['panen'] as $p) {
                                                    if ($p->komoditas_id == $k->id) {
                                                        $luas_panen = $p->luas;
                                                        break;
                                                    }
                                                }
                                                echo $luas_panen;
                                            ?>">
                                        </td>

                                        <td><input type="text" name="produksi_<?= $k->id ?>" value="<?php 
                                                $berat_produksi = ''; 
                                                foreach ($laporan['produksi'] as $pr) {
                                                    if ($pr->komoditas_id == $k->id) {
                                                        $berat_produksi = $pr->berat;
                                                        break;
                                                    }
                                                }
                                                echo $berat_produksi;
                                            ?>">
                                        </td>

                                    </tr>
                                    <?php endforeach; ?>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>

    </div>
</div>

<script>
$(document).ready(function() {
    $('#kecamatan').change(function() {
        var kecamatan_id = $(this).val();
        if (kecamatan_id) {
            $.ajax({
                url: "<?= base_url('inputlaporan/get_desa_by_kecamatan') ?>",
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