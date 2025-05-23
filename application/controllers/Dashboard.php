<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->model('Tanam_model');
        $this->load->model('Panen_model');
        $this->load->model('Produksi_model');
        $this->load->model('Komoditas_model');
        $this->load->helper(['url', 'form', 'my_helper']);

        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }
    }

    private function check_role($role_required) {
		$role = $this->session->userdata('role');
		
		if ($role !== $role_required) {
			redirect('auth/forbidden');
		}
	}

    // ============================ Admin ==============================
    public function view_admin(){
        $this->check_role('admin');

        $tanggal = date('Y-m-d');
        $bulan = date('m');
        $tahun = date('Y');
    
        $komoditas = $this->Komoditas_model->get_all_data();
    
        // Ambil data per tanggal
        $tanam_harian = $this->Tanam_model->getTotalTanamByDate($tanggal);
        $panen_harian = $this->Panen_model->getTotalPanenByDate($tanggal);
        $produksi_harian = $this->Produksi_model->getTotalProduksiByDate($tanggal);
    
        // Ambil data per bulan
        $tanam_bulanan = $this->Tanam_model->getTotalTanamByMonth($bulan, $tahun);
        $panen_bulanan = $this->Panen_model->getTotalPanenByMonth($bulan, $tahun);
        $produksi_bulanan = $this->Produksi_model->getTotalProduksiByMonth($bulan, $tahun);
    
        // Ambil data per tahun
        $tanam_tahunan = $this->Tanam_model->getTotalTanamByYear($tahun);
        $panen_tahunan = $this->Panen_model->getTotalPanenByYear($tahun);
        $produksi_tahunan = $this->Produksi_model->getTotalProduksiByYear($tahun);
    
        // Inisialisasi array untuk rekap data
        $data_rekap_harian = [];
        $data_rekap_bulanan = [];
        $data_rekap_tahunan = [];
    
        // Array komoditas
        foreach ($komoditas as $k) {
            $id = $k->id;
            $default = [
                'komoditas' => $k->komoditas,
                'total_tanam' => 0,
                'total_panen' => 0,
                'total_produksi' => 0
            ];
            $data_rekap_harian[$id] = $default;
            $data_rekap_bulanan[$id] = $default;
            $data_rekap_tahunan[$id] = $default;
        }
    
        // Mengisi data harian
        foreach ($tanam_harian as $t) {
            $id = $t->komoditas_id;
            if (isset($data_rekap_harian[$id])) {
                $data_rekap_harian[$id]['total_tanam'] = $t->total_tanam;
            }
        }
        foreach ($panen_harian as $p) {
            $id = $p->komoditas_id;
            if (isset($data_rekap_harian[$id])) {
                $data_rekap_harian[$id]['total_panen'] = $p->total_panen;
            }
        }
        foreach ($produksi_harian as $pr) {
            $id = $pr->komoditas_id;
            if (isset($data_rekap_harian[$id])) {
                $data_rekap_harian[$id]['total_produksi'] = $pr->total_produksi;
            }
        }
    
        // Mengisi data bulanan
        foreach ($tanam_bulanan as $t) {
            $id = $t->komoditas_id;
            if (isset($data_rekap_bulanan[$id])) {
                $data_rekap_bulanan[$id]['total_tanam'] = $t->total_tanam;
            }
        }
        foreach ($panen_bulanan as $p) {
            $id = $p->komoditas_id;
            if (isset($data_rekap_bulanan[$id])) {
                $data_rekap_bulanan[$id]['total_panen'] = $p->total_panen;
            }
        }
        foreach ($produksi_bulanan as $pr) {
            $id = $pr->komoditas_id;
            if (isset($data_rekap_bulanan[$id])) {
                $data_rekap_bulanan[$id]['total_produksi'] = $pr->total_produksi;
            }
        }
    
        // Mengisi data tahunan
        foreach ($tanam_tahunan as $t) {
            $id = $t->komoditas_id;
            if (isset($data_rekap_tahunan[$id])) {
                $data_rekap_tahunan[$id]['total_tanam'] = $t->total_tanam;
            }
        }
        foreach ($panen_tahunan as $p) {
            $id = $p->komoditas_id;
            if (isset($data_rekap_tahunan[$id])) {
                $data_rekap_tahunan[$id]['total_panen'] = $p->total_panen;
            }
        }
        foreach ($produksi_tahunan as $pr) {
            $id = $pr->komoditas_id;
            if (isset($data_rekap_tahunan[$id])) {
                $data_rekap_tahunan[$id]['total_produksi'] = $pr->total_produksi;
            }
        }
    
        // Kirim data ke view
        $data['rekap_harian'] = $data_rekap_harian;
        $data['rekap_bulanan'] = $data_rekap_bulanan;
        $data['rekap_tahunan'] = $data_rekap_tahunan;
        $data['username'] = $this->session->userdata('username');
    
        $this->load->view('admin/template-admin/header');
        $this->load->view('admin/template-admin/sidebar', $data);
        $this->load->view('admin/dashboard', $data);
        $this->load->view('admin/template-admin/footer');
    }
    
    // ============================ Penyuluh ==============================
    public function view_penyuluh(){
        $this->check_role('penyuluh');

        $tanggal = date('Y-m-d');
        $bulan = date('m');
        $tahun = date('Y');
    
        $komoditas = $this->Komoditas_model->get_all_data();
    
        // Ambil data per tanggal
        $tanam_harian = $this->Tanam_model->getTotalTanamByDate($tanggal);
        $panen_harian = $this->Panen_model->getTotalPanenByDate($tanggal);
        $produksi_harian = $this->Produksi_model->getTotalProduksiByDate($tanggal);
    
        // Ambil data per bulan
        $tanam_bulanan = $this->Tanam_model->getTotalTanamByMonth($bulan, $tahun);
        $panen_bulanan = $this->Panen_model->getTotalPanenByMonth($bulan, $tahun);
        $produksi_bulanan = $this->Produksi_model->getTotalProduksiByMonth($bulan, $tahun);
    
        // Ambil data per tahun
        $tanam_tahunan = $this->Tanam_model->getTotalTanamByYear($tahun);
        $panen_tahunan = $this->Panen_model->getTotalPanenByYear($tahun);
        $produksi_tahunan = $this->Produksi_model->getTotalProduksiByYear($tahun);
    
        // Inisialisasi array untuk rekap data
        $data_rekap_harian = [];
        $data_rekap_bulanan = [];
        $data_rekap_tahunan = [];
    
        // Array komoditas
        foreach ($komoditas as $k) {
            $id = $k->id;
            $default = [
                'komoditas' => $k->komoditas,
                'total_tanam' => 0,
                'total_panen' => 0,
                'total_produksi' => 0
            ];
            $data_rekap_harian[$id] = $default;
            $data_rekap_bulanan[$id] = $default;
            $data_rekap_tahunan[$id] = $default;
        }
    
        // Mengisi data harian
        foreach ($tanam_harian as $t) {
            $id = $t->komoditas_id;
            if (isset($data_rekap_harian[$id])) {
                $data_rekap_harian[$id]['total_tanam'] = $t->total_tanam;
            }
        }
        foreach ($panen_harian as $p) {
            $id = $p->komoditas_id;
            if (isset($data_rekap_harian[$id])) {
                $data_rekap_harian[$id]['total_panen'] = $p->total_panen;
            }
        }
        foreach ($produksi_harian as $pr) {
            $id = $pr->komoditas_id;
            if (isset($data_rekap_harian[$id])) {
                $data_rekap_harian[$id]['total_produksi'] = $pr->total_produksi;
            }
        }
    
        // Mengisi data bulanan
        foreach ($tanam_bulanan as $t) {
            $id = $t->komoditas_id;
            if (isset($data_rekap_bulanan[$id])) {
                $data_rekap_bulanan[$id]['total_tanam'] = $t->total_tanam;
            }
        }
        foreach ($panen_bulanan as $p) {
            $id = $p->komoditas_id;
            if (isset($data_rekap_bulanan[$id])) {
                $data_rekap_bulanan[$id]['total_panen'] = $p->total_panen;
            }
        }
        foreach ($produksi_bulanan as $pr) {
            $id = $pr->komoditas_id;
            if (isset($data_rekap_bulanan[$id])) {
                $data_rekap_bulanan[$id]['total_produksi'] = $pr->total_produksi;
            }
        }
    
        // Mengisi data tahunan
        foreach ($tanam_tahunan as $t) {
            $id = $t->komoditas_id;
            if (isset($data_rekap_tahunan[$id])) {
                $data_rekap_tahunan[$id]['total_tanam'] = $t->total_tanam;
            }
        }
        foreach ($panen_tahunan as $p) {
            $id = $p->komoditas_id;
            if (isset($data_rekap_tahunan[$id])) {
                $data_rekap_tahunan[$id]['total_panen'] = $p->total_panen;
            }
        }
        foreach ($produksi_tahunan as $pr) {
            $id = $pr->komoditas_id;
            if (isset($data_rekap_tahunan[$id])) {
                $data_rekap_tahunan[$id]['total_produksi'] = $pr->total_produksi;
            }
        }
    
        // Kirim data ke view
        $data['rekap_harian'] = $data_rekap_harian;
        $data['rekap_bulanan'] = $data_rekap_bulanan;
        $data['rekap_tahunan'] = $data_rekap_tahunan;
        $data['username'] = $this->session->userdata('username');
    
        $this->load->view('penyuluh/template-penyuluh/header');
        $this->load->view('penyuluh/template-penyuluh/sidebar', $data);
        $this->load->view('penyuluh/dashboard', $data);
        $this->load->view('penyuluh/template-penyuluh/footer');
    }

    // ============================ Petugas Kantor ==============================
    public function view_petugaskantor(){
        $this->check_role('kantor');

        $tanggal = date('Y-m-d');
        $bulan = date('m');
        $tahun = date('Y');
    
        $komoditas = $this->Komoditas_model->get_all_data();
    
        // Ambil data per tanggal
        $tanam_harian = $this->Tanam_model->getTotalTanamByDate($tanggal);
        $panen_harian = $this->Panen_model->getTotalPanenByDate($tanggal);
        $produksi_harian = $this->Produksi_model->getTotalProduksiByDate($tanggal);
    
        // Ambil data per bulan
        $tanam_bulanan = $this->Tanam_model->getTotalTanamByMonth($bulan, $tahun);
        $panen_bulanan = $this->Panen_model->getTotalPanenByMonth($bulan, $tahun);
        $produksi_bulanan = $this->Produksi_model->getTotalProduksiByMonth($bulan, $tahun);
    
        // Ambil data per tahun
        $tanam_tahunan = $this->Tanam_model->getTotalTanamByYear($tahun);
        $panen_tahunan = $this->Panen_model->getTotalPanenByYear($tahun);
        $produksi_tahunan = $this->Produksi_model->getTotalProduksiByYear($tahun);
    
        // Inisialisasi array untuk rekap data
        $data_rekap_harian = [];
        $data_rekap_bulanan = [];
        $data_rekap_tahunan = [];
    
        // Array komoditas
        foreach ($komoditas as $k) {
            $id = $k->id;
            $default = [
                'komoditas' => $k->komoditas,
                'total_tanam' => 0,
                'total_panen' => 0,
                'total_produksi' => 0
            ];
            $data_rekap_harian[$id] = $default;
            $data_rekap_bulanan[$id] = $default;
            $data_rekap_tahunan[$id] = $default;
        }
    
        // Mengisi data harian
        foreach ($tanam_harian as $t) {
            $id = $t->komoditas_id;
            if (isset($data_rekap_harian[$id])) {
                $data_rekap_harian[$id]['total_tanam'] = $t->total_tanam;
            }
        }
        foreach ($panen_harian as $p) {
            $id = $p->komoditas_id;
            if (isset($data_rekap_harian[$id])) {
                $data_rekap_harian[$id]['total_panen'] = $p->total_panen;
            }
        }
        foreach ($produksi_harian as $pr) {
            $id = $pr->komoditas_id;
            if (isset($data_rekap_harian[$id])) {
                $data_rekap_harian[$id]['total_produksi'] = $pr->total_produksi;
            }
        }
    
        // Mengisi data bulanan
        foreach ($tanam_bulanan as $t) {
            $id = $t->komoditas_id;
            if (isset($data_rekap_bulanan[$id])) {
                $data_rekap_bulanan[$id]['total_tanam'] = $t->total_tanam;
            }
        }
        foreach ($panen_bulanan as $p) {
            $id = $p->komoditas_id;
            if (isset($data_rekap_bulanan[$id])) {
                $data_rekap_bulanan[$id]['total_panen'] = $p->total_panen;
            }
        }
        foreach ($produksi_bulanan as $pr) {
            $id = $pr->komoditas_id;
            if (isset($data_rekap_bulanan[$id])) {
                $data_rekap_bulanan[$id]['total_produksi'] = $pr->total_produksi;
            }
        }
    
        // Mengisi data tahunan
        foreach ($tanam_tahunan as $t) {
            $id = $t->komoditas_id;
            if (isset($data_rekap_tahunan[$id])) {
                $data_rekap_tahunan[$id]['total_tanam'] = $t->total_tanam;
            }
        }
        foreach ($panen_tahunan as $p) {
            $id = $p->komoditas_id;
            if (isset($data_rekap_tahunan[$id])) {
                $data_rekap_tahunan[$id]['total_panen'] = $p->total_panen;
            }
        }
        foreach ($produksi_tahunan as $pr) {
            $id = $pr->komoditas_id;
            if (isset($data_rekap_tahunan[$id])) {
                $data_rekap_tahunan[$id]['total_produksi'] = $pr->total_produksi;
            }
        }
    
        // Kirim data ke view
        $data['rekap_harian'] = $data_rekap_harian;
        $data['rekap_bulanan'] = $data_rekap_bulanan;
        $data['rekap_tahunan'] = $data_rekap_tahunan;
        $data['username'] = $this->session->userdata('username');
    
        $this->load->view('petugas_kantor/template-pk/header');
        $this->load->view('petugas_kantor/template-pk/sidebar', $data);
        $this->load->view('petugas_kantor/dashboard', $data);
        $this->load->view('petugas_kantor/template-pk/footer');
    }
}