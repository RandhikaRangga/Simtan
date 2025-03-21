<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tanam extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->model('Tanam_model');

        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }
    }
    public function view_admin() {
        // Ambil filter dari input GET
        $bulan = $this->input->get('bulan') ? $this->input->get('bulan') : date('m');
        $tahun = $this->input->get('tahun') ? $this->input->get('tahun') : date('Y');
        $kecamatan = $this->input->get('kecamatan') ? $this->input->get('kecamatan') : 'all';
        $desa = $this->input->get('desa') ? $this->input->get('desa') : 'all';
        $penyuluh = $this->input->get('penyuluh') ? $this->input->get('penyuluh') : 'all';
    
        // Ambil daftar kecamatan dan desa
        $kecamatan_list = $this->Tanam_model->get_kecamatan();
        $desa_list = ($kecamatan != 'all') ? $this->db->get_where('desa', ['kecamatan_id' => $kecamatan])->result() : [];
    
        // Ambil daftar komoditas
        $komoditas = $this->Tanam_model->get_komoditas();

        // Ambil daftar penyuluh
        $penyuluh_list = $this->Tanam_model->get_penyuluh();
    
        // Ambil data tanam berdasarkan filter
        $data_tanam = $this->Tanam_model->get_data_tanam($bulan, $tahun, $kecamatan, $desa, $penyuluh);
    
        // Kirim data ke view
        $data = [
            'komoditas' => $komoditas,
            'data_tanam' => $data_tanam,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'kecamatan' => $kecamatan_list,
            'desa' => $desa_list,
            'penyuluh' => $penyuluh_list,
            'selected_kecamatan' => $kecamatan,
            'selected_desa' => $desa,
            'selected_penyuluh' => $penyuluh
        ];
        $data['username'] = $this->session->userdata('username');
    
        $this->load->view('admin/template-admin/header');
        $this->load->view('admin/template-admin/sidebar', $data);
        $this->load->view('admin/tanam', $data);
        $this->load->view('admin/template-admin/footer');
    }

    public function get_desa_by_kecamatan() {
        $kecamatan_id = $this->input->post('kecamatan_id');
        
        if ($kecamatan_id == 'all') {
            $desa = $this->db->get('desa')->result();
        } else {
            $desa = $this->db->get_where('desa', ['kecamatan_id' => $kecamatan_id])->result();
        }
    
        echo json_encode($desa);
    }
}