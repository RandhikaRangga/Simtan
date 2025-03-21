<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kecamatan extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */

	public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
		$this->load->model('Kecamatan_model');

        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') != 'admin') {
            redirect('auth');
        }
    }

    public function index() {
        $data['username'] = $this->session->userdata('username');
        $tabel['kecamatan'] = $this->Kecamatan_model->get_all_data();

		$this->load->view('admin/template-admin/header');
		$this->load->view('admin/template-admin/sidebar', $data);
		$this->load->view('admin/kecamatan', $tabel);
		$this->load->view('admin/template-admin/footer');
    }

    // Insert
    public function tambah_kecamatan() {
        $data['username'] = $this->session->userdata('username');
        if ($this->input->post()) {
			$insert_data = [
				'kecamatan' => $this->input->post('kecamatan')
			];
			if ($this->Kecamatan_model->insert_data($insert_data)) {
				$this->session->set_flashdata('success_tambah','Data Kecamatan Berhasil Ditambahkan');
			} else {
				$this->session->set_flashdata('error_tambah','Data Gagal Ditambahkan');
			}
			redirect('Admin-Kecamatan');
		}

        $this->load->view('admin/template-admin/header');
		$this->load->view('admin/template-admin/sidebar', $data);
		$this->load->view('admin/tambah_kecamatan');
		$this->load->view('admin/template-admin/footer');
    }

    // Edit
	public function edit_kecamatan($id) {
		$data['username'] = $this->session->userdata('username');
		$data['record'] = $this->Kecamatan_model->get_data_by_id($id);

		if ($this->input->post()) {
			$update_data = [
				'kecamatan' => $this->input->post('kecamatan')
			];
			if ($this->Kecamatan_model->update_data($id, $update_data)) {
				$this->session->set_flashdata('success_edit','Data Kecamatan Berhasil Diubah');
			} else {
				$this->session->set_flashdata('error_tambah','Data Gagal Ditambahkan');
			}
			redirect('Admin-Kecamatan');
		}

		$this->load->view('admin/template-admin/header');
		$this->load->view('admin/template-admin/sidebar', $data);
		$this->load->view('admin/edit_kecamatan', $data);
		$this->load->view('admin/template-admin/footer');
	}

	// Delete
	public function hapus_kecamatan($id) {
		if ($this->Kecamatan_model->delete_data($id)) {
			$this->session->set_flashdata('success','Data Kecamatan Berhasil Dihapus');
		} else {
			$this->session->set_flashdata('error','Data Gagal Dihapus');
		}	
		redirect(base_url('Admin-Kecamatan'));
	}
}