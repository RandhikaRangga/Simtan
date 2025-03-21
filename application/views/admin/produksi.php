<!--begin::Row-->
<div class="row">
    <div class="col-sm-6">
        <h3 class="mb-0">Tabel Produksi Kabupaten Tegal</h3>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="Admin">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tabel Produksi</li>
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
            <div class="card-body">
                <!-- Filter -->
                <form method="GET" action="<?= base_url('produksi/view_admin') ?>" class="mb-3">
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
                                    <?= $k->kecamatan ?>
                                </option>
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
                                    <?= $d->desa ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="penyuluh">Penyuluh:</label>
                            <select name="penyuluh" id="penyuluh" class="form-select">
                                <option value="all" <?= ($selected_penyuluh == 'all') ? 'selected' : '' ?>>Semua
                                    Penyuluh
                                </option>
                                <?php foreach ($penyuluh as $p) : ?>
                                <option value="<?= $p->id ?>" <?= ($p->id == $selected_penyuluh) ? 'selected' : '' ?>>
                                    <?= $p->nama ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary">Filter</button>
                        </div>
                    </div>
                </form>
                <hr>

                <!-- Tabel -->
                <table class="table table-hover table-bordered" style="text-align: center; vertical-align:middle">
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
                    $berat_produksi = 0;

                    foreach ($data_produksi as $dt) {
                        if ($dt->komoditas == $k->komoditas && $dt->tanggal == $i) {
                            $berat_produksi = $dt->berat_produksi;
                            $total += $berat_produksi;
                        }
                    }

                    echo "<td>$berat_produksi</td>";
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

    <!-- AJAX untuk Menampilkan Desa berdasarkan Kecamatan -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {
        function loadDesa(kecamatan_id) {
            $.ajax({
                url: "<?= base_url('produksi/get_desa_by_kecamatan') ?>",
                type: "POST",
                data: {
                    kecamatan_id: kecamatan_id
                },
                dataType: "json",
                success: function(data) {
                    $("#desa").html('<option value="all">Semua Desa</option>');

                    $.each(data, function(index, desa) {
                        var selected = (desa.id == selected_desa) ? 'selected' : '';
                        $("#desa").append('<option value="' + desa.id + '" ' + selected +
                            '>' +
                            desa.desa + '</option>');
                    });
                }
            });
        }

        // Saat kecamatan diubah
        $("#kecamatan").change(function() {
            var kecamatan_id = $(this).val();
            loadDesa(kecamatan_id);
        });

        // Load desa berdasarkan kecamatan yang sudah dipilih sebelumnya
        var selected_kecamatan = $("#kecamatan").val();
        var selected_desa = "<?= $selected_desa ?>";
        loadDesa(selected_kecamatan);
    });
    </script>