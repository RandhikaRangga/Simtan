<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengguna extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');

        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') != 'admin') {
            redirect('auth');
        }
    }

    public function index() {
        $data['username'] = $this->session->userdata('username');
        $data['pengguna'] = $this->User_model->get_all_data();

        foreach ($data['pengguna'] as $key => $row) {
            $data['pengguna'][$key]->role_label = $this->labelRole($row->role);
        }

        $this->load->view('admin/template-admin/header');
        $this->load->view('admin/template-admin/sidebar', $data);
        $this->load->view('admin/pengguna', $data);
        $this->load->view('admin/template-admin/footer');
    }

    private function labelRole($role) {
        $roleUser = [
            'admin' => 'Admin',
            'kantor' => 'Petugas Kantor',
            'penyuluh' => 'Petugas Penyuluh'
        ];
        return $roleUser[$role] ?? 'Role Tidak Diketahui';
    }

    // Mengambil data berdasarkan id
    public function getDetail() {
        $id = $this->input->post('id');
        $user = $this->User_model->getDataModal($id);
    
        if ($user) {
            $user['role_label'] = $this->labelRole($user['role']); // Pastikan ini ditambahkan
            echo json_encode($user);
        } else {
            echo json_encode(null);
        }
    }

    // Insert
    public function tambah_pengguna() {
        $data['username'] = $this->session->userdata('username');
        if ($this->input->post()) {
            $insert_data = [
                'nama' => $this->input->post('nama'),
                'username' => $this->input->post('username'),
                'password' => $this->input->post('password'),
                'role' => $this->input->post('role')
            ];
            if ($this->User_model->insert_data($insert_data)) {
                $this->session->set_flashdata('success_tambah','Data Pengguna Berhasil Ditambahkan');
            } else {
                $this->session->set_flashdata('error_tambah','Data Gagal Ditambahkan');
            }
            redirect('Admin-Pengguna');
        }

        $this->load->view('admin/template-admin/header');
        $this->load->view('admin/template-admin/sidebar', $data);
        $this->load->view('admin/tambah_pengguna');
        $this->load->view('admin/template-admin/footer');
    }

    // Edit
    public function edit_pengguna($id) {
        $data['username'] = $this->session->userdata('username');
        $data['record'] = $this->User_model->get_data_by_id($id);
        $data['roles'] = ['kantor' => 'Petugas Kantor','penyuluh' => 'Petugas Penyuluh'];

        if ($this->input->post()) {
            $update_data = [
                'nama' => $this->input->post('nama'),
                'username' => $this->input->post('username'),
                'password' => $this->input->post('password'),
                'role' => $this->input->post('role')
            ];
            if ($this->User_model->update_data($id, $update_data)) {
                $this->session->set_flashdata('success_edit','Data Pengguna Berhasil Diubah');
            } else {
                $this->session->set_flashdata('error_tambah','Data Gagal Ditambahkan');
            }
            redirect('Admin-Pengguna');
        }

        $this->load->view('admin/template-admin/header');
        $this->load->view('admin/template-admin/sidebar', $data);
        $this->load->view('admin/edit_pengguna', $data);
        $this->load->view('admin/template-admin/footer');
    }

    // Delete
    public function hapus_pengguna($id) {
        if ($this->User_model->delete_data($id)) {
            $this->session->set_flashdata('success','Data Pengguna Berhasil Dihapus');
        } else {
            $this->session->set_flashdata('error','Data Gagal Dihapus');
        }   
        redirect(base_url('Admin-Pengguna'));
    }
}