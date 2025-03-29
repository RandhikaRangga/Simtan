<body class="layout-fixed sidebar-expand-lg sidebar-mini sidebar-collapse bg-body-tertiary">
    <style>
    .dropdown-menu {
        position: absolute;
        top: 100%;
        left: 0;
        z-index: 1050;
        overflow: visible;
    }

    /* Tambahkan scroll internal jika dropdown terlalu panjang */
    .dropdown-menu {
        max-height: 300px;
        /* Batasi tinggi */
        overflow-y: auto;
        /* Scroll hanya di dalam dropdown */
    }
    </style>

    <!--begin::App Wrapper-->
    <div class="app-wrapper">
        <!--begin::Header-->
        <nav class="app-header navbar navbar-expand bg-body">
            <!--begin::Container-->
            <div class="container-fluid">
                <!--begin::Start Navbar Links-->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button">
                            <i class="bi bi-list"></i>
                        </a>
                    </li>
                </ul>
                <!--end::Start Navbar Links-->
                <!--begin::End Navbar Links-->
                <ul class="navbar-nav ms-auto">
                    <!--begin::User Menu Dropdown-->
                    <div class="dropdown">
                        <div class="account" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fa-solid fa-user"></i> <?php echo $username; ?>
                        </div>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="<?php echo site_url('auth/logout'); ?>"><i
                                        class="fa-solid fa-power-off"></i> Logout</a>
                            </li>
                        </ul>
                    </div>
                    <!--end::User Menu Dropdown-->
                </ul>
                <!--end::End Navbar Links-->
            </div>
            <!--end::Container-->
        </nav>
        <!--end::Header-->
        <!--begin::Sidebar-->
        <aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
            <!--begin::Sidebar Brand-->
            <div class="sidebar-brand">
                <!--begin::Brand Link-->
                <a href="<?= site_url('Admin') ?>" class="brand-link">
                    <!--begin::Brand Image-->
                    <img src="<?= site_url('assets/Foto/logo.png') ?>" alt="Logo" class="brand-image opacity-75 shadow"
                        style="margin-right: 10px;" />
                    <!--end::Brand Image-->
                    <!--begin::Brand Text-->
                    <span class="brand-text fw-light"
                        style="margin: 0 !important; padding: 0 !important; line-height: 1 !important;">
                        Dinas Pertanian
                        <span
                            style="font-size: small; margin: 0 !important; padding: 0 !important; display: block; line-height: 1 !important;">
                            Kabupaten Tegal
                        </span>
                    </span>
                    <!--end::Brand Text-->
                </a>
                <!--end::Brand Link-->
            </div>
            <!--end::Sidebar Brand-->
            <!--begin::Sidebar Wrapper-->
            <div class="sidebar-wrapper">
                <nav class="mt-2">
                    <!--begin::Sidebar Menu-->
                    <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu"
                        data-accordion="false">
                        <li class="nav-item">
                            <a href="<?= site_url('Admin') ?>" class="nav-link">
                                <i class="nav-icon bi bi-speedometer"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>

                        <!-- DATA PERTANIAN -->
                        <li class="nav-header">PERTANIAN</li>

                        <li class="nav-item">
                            <a href="<?= site_url('Admin-InputLaporan') ?>" class="nav-link">
                                <i class="nav-icon fa-solid fa-file-pen"></i>
                                <p>Input Laporan</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="<?= site_url('Admin-Tanam') ?>" class="nav-link">
                                <i class="nav-icon fa-solid fa-seedling"></i>
                                <p>Tabel Data Tanam</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="<?= site_url('Admin-Panen') ?>" class="nav-link">
                                <i class="nav-icon fa-solid fa-tractor"></i>
                                <p>Tabel Data Panen</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="<?= site_url('Admin-Produksi') ?>" class="nav-link">
                                <i class="nav-icon fa-solid fa-boxes-stacked"></i>
                                <p>Tabel Data Produksi</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="<?= site_url('Admin-LaporanTanam') ?>" class="nav-link">
                                <i class="nav-icon fa-solid fa-clipboard-list"></i>
                                <p>Laporan Tanam</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="<?= site_url('Admin-LaporanPanen') ?>" class="nav-link">
                                <i class="nav-icon fa-solid fa-clipboard-list"></i>
                                <p>Laporan Panen</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="<?= site_url('Admin-LaporanProduksi') ?>" class="nav-link">
                                <i class="nav-icon fa-solid fa-clipboard-list"></i>
                                <p>Laporan Produksi</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="<?= site_url('Admin-Komoditas') ?>" class="nav-link">
                                <i class="nav-icon fa-solid fa-leaf"></i>
                                <p> Data Komoditas</p>
                            </a>
                        </li>
                        <!-- DATA PERTANIAN END -->

                        <!-- DATA PENGGUNA -->
                        <li class="nav-header">PENGGUNA</li>

                        <li class="nav-item">
                            <a href="<?= site_url('Admin-Pengguna') ?>" class="nav-link">
                                <i class="nav-icon fa-solid fa-person"></i>
                                <p>Data Pengguna</p>
                            </a>
                        </li>
                        <!-- DATA PENGGUNA END -->

                        <!-- DATA Wilayah -->
                        <li class="nav-header">WILAYAH</li>

                        <li class="nav-item">
                            <a href="<?= site_url('Admin-Lahan') ?>" class="nav-link">
                                <i class="nav-icon fa-solid fa-map"></i>
                                <p>Data Lahan</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="<?= site_url('Admin-Map') ?>" class="nav-link">
                                <i class="nav-icon fa-solid fa-map-location-dot"></i>
                                <p>Map Lahan</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="<?= site_url('Admin-Kecamatan') ?>" class="nav-link">
                                <i class="nav-icon fa-solid fa-building"></i>
                                <p>Data Kecamatan</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="<?= site_url('Admin-Desa') ?>" class="nav-link">
                                <i class="nav-icon fa-solid fa-house-chimney"></i>
                                <p>Data Desa</p>
                            </a>
                        </li>
                        <!-- DATA WILAYAH END -->
                </nav>
            </div>
            <!--end::Sidebar Wrapper-->
        </aside>
        <!--end::Sidebar-->
        <!--begin::App Main-->
        <main class="app-main">
            <!--begin::App Content Header-->
            <div class="app-content-header">
                <!--begin::Container-->
                <div class="container-fluid">