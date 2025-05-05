<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class InputLaporan extends CI_Controller {

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
		$this->load->model('Tanam_model');
		$this->load->model('Panen_model');
		$this->load->model('Produksi_model');
		$this->load->model('Komoditas_model');
		$this->load->model('Laporan_model');
		$this->load->model('Kecamatan_model');
		$this->load->model('Desa_model');
		$this->load->helper(['url', 'form']);

        if (!$this->session->userdata('logged_in')) {
            redirect('auth');
        }
    }

	// Check Role
	private function check_role($role_required) {
		$role = $this->session->userdata('role');
		
		if ($role !== $role_required) {
			redirect('auth/forbidden');
		}
	}

    public function view_admin(){
		$this->check_role('admin');

        $data['username'] = $this->session->userdata('username');
		$data['laporan'] = $this->Laporan_model->getGroupedData();
		$data['komoditas'] = $this->Komoditas_model->get_all_data(); 

        $this->load->view('admin/template-admin/header');
		$this->load->view('admin/template-admin/sidebar', $data);
		$this->load->view('admin/input_laporan', $data);
		$this->load->view('admin/template-admin/footer');
    }

	public function view_penyuluh(){
		$this->check_role('penyuluh');

        $data['username'] = $this->session->userdata('username');
		$data['laporan'] = $this->Laporan_model->getGroupedDataP();
		$data['komoditas'] = $this->Komoditas_model->get_all_data(); 

        $this->load->view('penyuluh/template-penyuluh/header');
		$this->load->view('penyuluh/template-penyuluh/sidebar', $data);
		$this->load->view('penyuluh/input_laporan', $data);
		$this->load->view('penyuluh/template-penyuluh/footer');
    }

	// Untuk Modal
	public function get_data_tanam() {
		$batch_id = $this->input->post('batch_id');
		$laporan = $this->Laporan_model->getDetailByBatch($batch_id);
		$batch_info = $this->Laporan_model->getBatchInfo($batch_id);
	
		$data = array(
			'laporan' => $laporan,
			'batch_info' => $batch_info
		);
	
		header('Content-Type: application/json');
		echo json_encode($data);
	}

	public function tambah_laporan_admin() {
		$this->check_role('admin');
		$this->load->helper('form');

		$data['username'] = $this->session->userdata('username');
		$data['komoditas'] = $this->Komoditas_model->get_all_data();
		$data['kecamatan'] = $this->db->get('kecamatan')->result();
		$data['old_input'] = $this->session->flashdata('old_input');
		
		$this->load->view('admin/template-admin/header');
		$this->load->view('admin/template-admin/sidebar', $data);
		$this->load->view('admin/tambah_laporan', $data);
		$this->load->view('admin/template-admin/footer');
	}

	public function tambah_laporan_penyuluh() {
		$this->check_role('penyuluh');

		$data['username'] = $this->session->userdata('username');
		$data['komoditas'] = $this->Komoditas_model->get_all_data();
		$data['kecamatan'] = $this->db->get('kecamatan')->result();
		
		$this->load->view('penyuluh/template-penyuluh/header');
		$this->load->view('penyuluh/template-penyuluh/sidebar', $data);
		$this->load->view('penyuluh/tambah_laporan', $data);
		$this->load->view('penyuluh/template-penyuluh/footer');
	}

	public function simpan_data() {
		$this->load->library('session');
		$user_id = $this->session->userdata('user_id');
	
		$tanggal = $this->input->post('tanggal');
		$kecamatan_id = $this->input->post('kecamatan_id');
		$desa_id = $this->input->post('desa_id');
		$batch_id = $this->input->post('batch_id');
	
		if (empty($batch_id)) {
			$batch_id = date('YmdHis') . rand(1000, 9999);
		} else {
			// Jika edit, hapus data lama dulu
			$this->Tanam_model->deleteByBatch($batch_id);
			$this->Panen_model->deleteByBatch($batch_id);
			$this->Produksi_model->deleteByBatch($batch_id);
		}
	
		$komoditas = $this->Komoditas_model->get_all_data();
		$data_tanam = [];
		$data_panen = [];
		$data_produksi = [];
	
		foreach ($komoditas as $komoditas) {
			$tanam = $this->input->post('tanam_' . $komoditas->id);
			$panen = $this->input->post('panen_' . $komoditas->id);
			$produksi = $this->input->post('produksi_' . $komoditas->id);

			$errors = [];

			if (!empty($tanam) && !preg_match('/^[0-9.,]+$/', $tanam)) {
				$errors[] = 'Input luas tanam tidak valid!';
			}
			if (!empty($panen) && !preg_match('/^[0-9.,]+$/', $panen)) {
				$errors[] = 'Input luas panen tidak valid!';
			}
			if (!empty($produksi) && !preg_match('/^[0-9.,]+$/', $produksi)) {
				$errors[] = 'Input berat produksi tidak valid!';
			}

			if (!empty($errors)) {
				$this->session->set_flashdata('error_tambah', implode('<br>', $errors));
				$this->session->set_flashdata('old_input', $this->input->post());
				redirect(!empty($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : base_url('halaman-fallback'));
				return;
			}
			
			
			// Konversi angka ke format yang benar untuk database
			$tanam = !empty($tanam) ? str_replace(',', '.', str_replace('.', '', $tanam)) : null;
			$panen = !empty($panen) ? str_replace(',', '.', str_replace('.', '', $panen)) : null;
			$produksi = !empty($produksi) ? str_replace(',', '.', str_replace('.', '', $produksi)) : null;
	
			if (!empty($tanam)) {
				$data_tanam[] = [
					'batch_id' => $batch_id,
					'user_id' => $user_id,
					'tgl_tanam' => $tanggal,
					'kecamatan_id' => $kecamatan_id,
					'desa_id' => $desa_id,
					'komoditas_id' => $komoditas->id,
					'luas' => $tanam
				];
			}
	
			if (!empty($panen)) {
				$data_panen[] = [
					'batch_id' => $batch_id,
					'user_id' => $user_id,
					'tgl_panen' => $tanggal,
					'kecamatan_id' => $kecamatan_id,
					'desa_id' => $desa_id,
					'komoditas_id' => $komoditas->id,
					'luas' => $panen
				];
			}
	
			if (!empty($produksi)) {
				$data_produksi[] = [
					'batch_id' => $batch_id,
					'user_id' => $user_id,
					'tgl_produksi' => $tanggal,
					'kecamatan_id' => $kecamatan_id,
					'desa_id' => $desa_id,
					'komoditas_id' => $komoditas->id,
					'berat' => $produksi
				];
			}
		}
	
		// Simpan data jika tidak kosong
		$insert_tanam = !empty($data_tanam) ? $this->Tanam_model->saveBatch($data_tanam) : true;
		$insert_panen = !empty($data_panen) ? $this->Panen_model->saveBatch($data_panen) : true;
		$insert_produksi = !empty($data_produksi) ? $this->Produksi_model->saveBatch($data_produksi) : true;
	
		if (
			($insert_tanam !== false || empty($data_tanam)) &&
			($insert_panen !== false || empty($data_panen)) &&
			($insert_produksi !== false || empty($data_produksi))
		) {
			$this->session->set_flashdata('success', 'Data berhasil disimpan.');
		} else {
			$this->session->set_flashdata('error_tambah', 'Terjadi kesalahan saat menyimpan data.');
		}
	
		$role = $this->session->userdata('role');

		// Redirect ke halaman input laporan
		if ($role == 'admin') {
			redirect('Admin-InputLaporan');
		} elseif ($role == 'penyuluh') {
			redirect('Penyuluh-InputLaporan');
		}
		exit;
	}

	public function get_desa_by_kecamatan(){
    $kecamatan_id = $this->input->post('kecamatan_id');
    $desa = $this->db->get_where('desa', ['kecamatan_id' => $kecamatan_id])->result();
    echo json_encode($desa);
	}

	public function edit_laporan_admin($batch_id) {
		$this->check_role('admin');
		
        $data['batch_id'] = $batch_id;
		$data['kecamatan'] = $this->Kecamatan_model->get_all_data();
		$data['desa'] = $this->Desa_model->get_desa();
		$data['komoditas'] = $this->Komoditas_model->get_all_data();
		$data['username'] = $this->session->userdata('username');

    // Ambil data laporan berdasarkan batch_id
		$data['laporan'] = [
			'tanam' => $this->Laporan_model->get_tanam_by_batch($batch_id),
			'panen' => $this->Laporan_model->get_panen_by_batch($batch_id),
			'produksi' => $this->Laporan_model->get_produksi_by_batch($batch_id)
		];
        
		$this->load->view('admin/template-admin/header');
		$this->load->view('admin/template-admin/sidebar', $data);
		$this->load->view('admin/edit_laporan', $data);
		$this->load->view('admin/template-admin/footer');
    }

	public function edit_laporan_penyuluh($batch_id) {
		$this->check_role('penyuluh');

        $data['batch_id'] = $batch_id;
		$data['kecamatan'] = $this->Kecamatan_model->get_all_data();
		$data['desa'] = $this->Desa_model->get_desa();
		$data['komoditas'] = $this->Komoditas_model->get_all_data();
		$data['username'] = $this->session->userdata('username');

    // Ambil data laporan berdasarkan batch_id
		$data['laporan'] = [
			'tanam' => $this->Laporan_model->get_tanam_by_batch($batch_id),
			'panen' => $this->Laporan_model->get_panen_by_batch($batch_id),
			'produksi' => $this->Laporan_model->get_produksi_by_batch($batch_id)
		];
        
		$this->load->view('penyuluh/template-penyuluh/header');
		$this->load->view('penyuluh/template-penyuluh/sidebar', $data);
		$this->load->view('penyuluh/edit_laporan', $data);
		$this->load->view('penyuluh/template-penyuluh/footer');
    }

	public function hapus_batch($batch_id) {
		$role = $this->session->userdata('role');

		if (!$batch_id) {
			$this->session->set_flashdata('error', 'Batch ID tidak ditemukan.');
			if($role == 'admin'){
				redirect('Admin-InputLaporan');
			} elseif($role == 'penyuluh') {
				redirect('Penyuluh-InputLaporan');
			}
		}
	
		if ($this->Laporan_model->hapus_batch($batch_id)) {
			$this->session->set_flashdata('success', 'Data berhasil dihapus.');
		} else {
			$this->session->set_flashdata('error', 'Gagal menghapus data. Pastikan semua data bisa dihapus.');
		}
	
		if($role == 'admin') {
			redirect('Admin-InputLaporan');
		} elseif($role == 'penyuluh') {
			redirect('Penyuluh-InputLaporan');
		}
	}
}