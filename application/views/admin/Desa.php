<!--begin::Row-->
<div class="row">
    <div class="col-sm-6">
        <h3 class="mb-0">Data Desa Kabupaten Tegal</h3>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="Admin">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data Desa</li>
        </ol>
    </div>
</div>
<!--end::Row-->
</div>
<!--end::Container-->
</div>
<!--end::App Content Header-->
<div class="col-md-10 p-3">
    <div class="card mb-4">
        <div class="card">
            <div class="p-3 d-md-flex flex-wrap gap-2 justify-content-md-start justify-content-center">
                <a href="<?= base_url('Admin-TambahDesa'); ?>" class="col-6 col-md-auto mb-4">
                    <button type="button" class="btn btn-primary w-100 w-md-auto">
                        <i class="fa-solid fa-plus"></i> Tambah Data Desa
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
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = $this->uri->segment(3) + 1;
                        foreach ($desa as $row) : ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $row->kecamatan ?></td>
                            <td><?= $row->desa ?></td>
                            <td>
                                <a href="<?= site_url('Admin-EditDesa/' .$row->id) ?>"
                                    class="d-block d-md-inline-block mb-2 mb-md-0">
                                    <button type="button" class="btn btn-warning w-100 w-md-auto">
                                        <i class="fa-solid fa-pen-to-square"></i> Edit
                                    </button>
                                </a>
                                <a href="<?= site_url('Admin-HapusDesa/' .$row->id) ?>"
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

<script>
// Notifikasi Tambah
document.addEventListener("DOMContentLoaded", function() {
    <?php if ($this->session->flashdata('success_tambah')) : ?>
    Swal.fire({
        icon: 'success',
        title: 'Sukses!',
        text: "<?= $this->session->flashdata('success_tambah') ?>",
        showConfirmButton: false,
        timer: 2000
    });
    <?php elseif ($this->session->flashdata('error_tambah')) : ?>
    Swal.fire({
        icon: 'error',
        title: 'Gagal!',
        text: "<?= $this->session->flashdata('error_tambah') ?>",
        showConfirmButton: false,
        timer: 2000
    });
    <?php endif; ?>
});

// Notifikasi Edit
document.addEventListener("DOMContentLoaded", function() {
    <?php if ($this->session->flashdata('success_edit')) : ?>
    Swal.fire({
        icon: 'success',
        title: 'Sukses!',
        text: "<?= $this->session->flashdata('success_edit') ?>",
        showConfirmButton: false,
        timer: 2000
    });
    <?php elseif ($this->session->flashdata('error_edit')) : ?>
    Swal.fire({
        icon: 'error',
        title: 'Gagal!',
        text: "<?= $this->session->flashdata('error_edit') ?>",
        showConfirmButton: false,
        timer: 2000
    });
    <?php endif; ?>
});

// Notifikasi Peringatan Hapus
document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll(".btn-delete").forEach(button => {
        button.addEventListener("click", function(e) {
            e.preventDefault(); // Mencegah langsung menghapus data
            let url = this.closest("a").getAttribute("href"); // Ambil URL dari tombol

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
                    window.location.href = url; // Redirect jika dikonfirmasi
                }
            });
        });
    });
});

// Notifikasi Berhasil Dihapus
document.addEventListener("DOMContentLoaded", function() {
    <?php if ($this->session->flashdata('success')) : ?>
    Swal.fire({
        icon: 'success',
        title: 'Sukses!',
        text: "<?= $this->session->flashdata('success') ?>",
        showConfirmButton: false,
        timer: 2000
    });
    <?php elseif ($this->session->flashdata('error')) : ?>
    Swal.fire({
        icon: 'error',
        title: 'Gagal!',
        text: "<?= $this->session->flashdata('error') ?>",
        showConfirmButton: false,
        timer: 2000
    });
    <?php endif; ?>
});
</script>