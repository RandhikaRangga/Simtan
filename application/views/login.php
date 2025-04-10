<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Sistam</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?php echo base_url('assets/template/dist/css/adminlte.css'); ?>" />
    <link rel="icon" href="<?= base_url('assets/Foto/logo.png') ?>" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
    .card-header {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 15px;
    }

    .card-header img {
        margin-right: 10px;
    }

    .card-header h1 {
        font-size: 1.5rem;
        margin: 0;
    }

    .card-header h2 {
        font-size: 1.2rem;
        margin: 0;
    }

    .invalid-feedback {
        display: block;
        width: 100%;
        margin-top: 0.25rem;
        font-size: 0.875em;
        color: #dc3545;
    }
    </style>
</head>

<body class="login-page bg-body-secondary">
    <div class="login-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center d-flex align-items-center">
                <img src="<?php echo base_url('assets/foto/logo.png'); ?>" style="width: 45px; margin-right: 10px;">
                <div>
                    <h1 class="mb-0">Dinas Pertanian</h1>
                    <h2 class="text-muted mb-0">Kabupaten Tegal</h2>
                </div>
            </div>

            <div class="card-body login-card-body">

                <!-- Flash Message Error -->
                <?php if ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></div>
                <?php endif; ?>

                <form action="<?php echo site_url('auth/login'); ?>" method="post">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <div class="input-group">
                            <input name="username" id="username" type="text"
                                class="form-control <?php echo (form_error('username')) ? 'is-invalid' : ''; ?>"
                                value="<?php echo set_value('username'); ?>" placeholder="Masukkan username" required />
                            <?php if (form_error('username')): ?>
                            <div class="invalid-feedback"><?php echo form_error('username'); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <input name="password" id="password" type="password"
                                class="form-control <?php echo (form_error('password')) ? 'is-invalid' : ''; ?>"
                                placeholder="Masukkan password" required />
                            <span class="input-group-text" onclick="togglePassword()" style="cursor: pointer;">
                                <i id="eyeIcon" class="fas fa-eye-slash"></i>
                            </span>
                            <?php if (form_error('password')): ?>
                            <div class="invalid-feedback"><?php echo form_error('password'); ?></div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary w-100">Sign In</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    function togglePassword() {
        var pass = document.getElementById("password");
        var eyeIcon = document.getElementById("eyeIcon");

        if (pass.type === "password") {
            pass.type = "text";
            eyeIcon.classList.remove("fa-eye-slash");
            eyeIcon.classList.add("fa-eye");
        } else {
            pass.type = "password";
            eyeIcon.classList.remove("fa-eye");
            eyeIcon.classList.add("fa-eye-slash");
        }
    }
    </script>
</body>

</html>