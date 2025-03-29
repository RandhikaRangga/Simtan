<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lahan extends CI_Controller {

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
		$this->load->model('Lahan_model');

        if (!$this->session->userdata('logged_in') || $this->session->userdata('role') != 'admin') {
            redirect('auth');
        }
    }

    public function index() {
        $data['username'] = $this->session->userdata('username');
        $data['lahan'] = $this->Lahan_model->get_viewData();

		$this->load->view('admin/template-admin/header');
		$this->load->view('admin/template-admin/sidebar', $data);
		$this->load->view('admin/lahan', $data);
		$this->load->view('admin/template-admin/footer');
    }

	// Mengambil data berdasarkan id
    public function getDetail() {
		$id = $this->input->post('id', TRUE);
	
		if (!$id) {
			echo json_encode(['error' => 'ID tidak valid']);
			return;
		}
	
		$lahan = $this->Lahan_model->getDataModal($id);
	
		if ($lahan) {
			// header('Content-Type: application/json');
			echo json_encode($lahan); 
		} else {
			echo json_encode(['error' => 'Data tidak ditemukan']);
		}
	}
	

    // Insert
	public function tambah_lahan() {
        $data['username'] = $this->session->userdata('username');
        $data['kecamatan'] = $this->Lahan_model->get_kecamatan();
        $data['desa'] = $this->Lahan_model->get_desa();

        if ($this->input->post()) {
            $insert_data = [
                'kecamatan_id' => $this->input->post('kecamatan_id'),
                'desa_id' => $this->input->post('desa_id'),
                'lahan' => $this->input->post('lahan'),
                'luas' => $this->input->post('luas'),
                'koordinat' => $this->input->post('koordinat'), // Data GeoJSON
                'irigasi' => $this->input->post('irigasi'),
                'kondisi' => $this->input->post('kondisi')
            ];

            if ($this->Lahan_model->insert_data($insert_data)) {
                $this->session->set_flashdata('success_tambah', 'Data Lahan Berhasil Ditambahkan');
            } else {
                $this->session->set_flashdata('error_tambah', 'Data Gagal Ditambahkan');
            }
            redirect('Admin-Lahan');
        }

        $this->load->view('admin/template-admin/header');
        $this->load->view('admin/template-admin/sidebar', $data);
        $this->load->view('admin/tambah_lahan');
        $this->load->view('admin/template-admin/footer');
    }

    // Edit
	public function edit_lahan($id) {
		$data['username'] = $this->session->userdata('username');
		$data['record'] = $this->Lahan_model->get_data_by_id($id);
		$data['kecamatan'] = $this->Lahan_model->get_kecamatan();
		$data['desa'] = $this->Lahan_model->get_desa();

		if ($this->input->post()) {
			$update_data = [
				'kecamatan_id' => $this->input->post('kecamatan_id'),
                'desa_id' => $this->input->post('desa_id'),
                'lahan' => $this->input->post('lahan'),
                'luas' => $this->input->post('luas'),
                'koordinat' => $this->input->post('koordinat'),
                'irigasi' => $this->input->post('irigasi'),
                'kondisi' => $this->input->post('kondisi')
			];
			if ($this->Lahan_model->update_data($id, $update_data)) {
				$this->session->set_flashdata('success_edit','Data Desa Berhasil Diubah');
			} else {
				$this->session->set_flashdata('error_tambah','Data Gagal Ditambahkan');
			}
			redirect('Admin-Lahan');
		}

		$this->load->view('admin/template-admin/header');
		$this->load->view('admin/template-admin/sidebar', $data);
		$this->load->view('admin/edit_lahan', $data);
		$this->load->view('admin/template-admin/footer');
	}

	// Delete
	public function hapus_lahan($id) {
		if ($this->Lahan_model->delete_data($id)) {
			$this->session->set_flashdata('success','Data Desa Berhasil Dihapus');
		} else {
			$this->session->set_flashdata('error','Data Gagal Dihapus');
		}	
		redirect(base_url('Admin-Lahan'));
	}

	// ============== MAP ======================
	public function map_admin() {
		$data['username'] = $this->session->userdata('username');

		$this->load->view('admin/template-admin/header');
		$this->load->view('admin/template-admin/sidebar', $data);
		$this->load->view('admin/map');
		$this->load->view('admin/template-admin/footer');
	}

	public function getPoligon() {
		$data = $this->Lahan_model->get_lahan();
		header('Content-Type: application/json');
		echo json_encode($data);
	}

	public function getTotalProduksi($kecamatan_id){
        $data = $this->Lahan_model->getTotalProduksi($kecamatan_id);
        echo json_encode($data);
    }

}