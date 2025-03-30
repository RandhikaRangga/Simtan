<?php
function labelRole($role)
{
    $roleUser = [
        'admin' => 'Admin',
        'kantor' => 'Petugas Kantor',
        'penyuluh' => 'Petugas Penyuluh'
    ];
    return $roleUser[$role] ?? 'Role Tidak Diketahui';
}
?>

<div class="row">
    <div class="col-sm-6">
        <h3 class="mb-0">Data Pengguna Simtan</h3>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="Admin">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data Pengguna</li>
        </ol>
    </div>
</div>
</div>
</div>
<div class="col-md-10 p-3">
    <div class="card mb-4">
        <div class="card">
            <div class="p-3 d-md-flex flex-wrap gap-2 justify-content-md-start justify-content-center">
                <a href="<?= base_url('Admin-TambahPengguna'); ?>" class="col-6 col-md-auto mb-4">
                    <button type="button" class="btn btn-primary w-100 w-md-auto">
                        <i class="fa-solid fa-plus"></i> Tambah Data Pengguna
                    </button>
                </a>
            </div>
            <div class="card-body">
                <table id="datatableNormal" class="table table-hover table-bordered">
                    <thead>
                        <tr class="table-primary">
                            <th>No</th>
                            <th>Nama</th>
                            <th>Username</th>
                            <th>Role</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = $this->uri->segment(3) + 1;
                        foreach ($pengguna as $row) : ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $row->nama ?></td>
                            <td><?= $row->username ?></td>
                            <td><?= $row->role_label ?></td>
                            <td>
                                <a class="d-block d-md-inline-block mb-2 mb-md-0">
                                    <button type="button" class="btn btn-info w-100 w-md-auto btn-detail"
                                        data-id="<?= $row->id; ?>" data-bs-toggle="modal" data-bs-target="#modalDetail">
                                        <i class="fa-solid fa-circle-info"></i> Detail Data
                                    </button>
                                </a>
                                <a href="<?= site_url('Admin-EditPengguna/' . $row->id) ?>"
                                    class="d-block d-md-inline-block mb-2 mb-md-0">
                                    <button type="button" class="btn btn-warning w-100 w-md-auto">
                                        <i class="fa-solid fa-pen-to-square"></i> Edit
                                    </button>
                                </a>
                                <a href="<?= site_url('Admin-HapusPengguna/' . $row->id) ?>"
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
</div>

<div class="modal fade" id="modalDetail" tabindex="-1" aria-labelledby="modalDetailLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDetailLabel">Detail Pengguna</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-borderless">
                    <tbody>
                        <tr>
                            <td class="pe-2"><strong>Nama:</strong></td>
                            <td id="nama"></td>
                        </tr>
                        <tr>
                            <td class="pe-2"><strong>Username:</strong></td>
                            <td id="username"></td>
                        </tr>
                        <tr>
                            <td class="pe-2"><strong>Password:</strong></td>
                            <td id="password"></td>
                        </tr>
                        <tr>
                            <td class="pe-2"><strong>Role:</strong></td>
                            <td id="role"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<script>
$(document).ready(function() {
    $('.btn-detail').click(function() {
        var id = $(this).data('id');
        $.ajax({
            url: '<?= base_url('Pengguna/getDetail'); ?>',
            type: 'POST',
            data: {
                id: id
            },
            dataType: 'json',
            success: function(response) {
                if (response) {
                    $('#nama').text(response.nama);
                    $('#username').text(response.username);
                    $('#password').text(response.password);
                    $('#role').text(response.role_label);

                    // Blur
                    $('.modal-backdrop').addClass('blur');

                    $('#modalDetail').on('hidden.bs.modal', function() {
                        $('.modal-backdrop').removeClass('blur');
                    });
                    $('#modalDetail').modal('show');
                } else {
                    alert('Data tidak ditemukan.');
                }
            }
        });
    });
});

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