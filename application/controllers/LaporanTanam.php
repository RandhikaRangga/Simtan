<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require FCPATH . 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

class LaporanTanam  extends CI_Controller {

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

    // ============================== View Admin ========================================
    public function view_admin(){
        $this->check_role('admin');

        // Ambil filter dari input GET
        $bulan = $this->input->get('bulan') ? $this->input->get('bulan') : date('m');
        $tahun = $this->input->get('tahun') ? $this->input->get('tahun') : date('Y');
        $kecamatan = $this->input->get('kecamatan') ? $this->input->get('kecamatan') : 'all';
        $desa = $this->input->get('desa') ? $this->input->get('desa') : 'all';
    
        // Ambil daftar kecamatan dan desa
        $kecamatan_list = $this->Tanam_model->get_kecamatan();
        $desa_list = ($kecamatan != 'all') ? $this->db->get_where('desa', ['kecamatan_id' => $kecamatan])->result() : [];
    
        // Ambil daftar komoditas
        $komoditas = $this->Tanam_model->get_komoditas();

        // Ambil data tanam berdasarkan filter
        $data_tanam = $this->Tanam_model->get_data_tanam($bulan, $tahun, $kecamatan, $desa);
    
        // Kirim data ke view
        $data = [
            'komoditas' => $komoditas,
            'data_tanam' => $data_tanam,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'kecamatan' => $kecamatan_list,
            'desa' => $desa_list,
            'selected_kecamatan' => $kecamatan,
            'selected_desa' => $desa,
        ];
        $data['username'] = $this->session->userdata('username');
    
        $this->load->view('admin/template-admin/header');
        $this->load->view('admin/template-admin/sidebar', $data);
        $this->load->view('admin/laporan_tanam', $data);
        $this->load->view('admin/template-admin/footer');
    }

    // ============================== View Petugas Kantor ========================================
    public function view_petugaskantor(){
        $this->check_role('kantor');

        // Ambil filter dari input GET
        $bulan = $this->input->get('bulan') ? $this->input->get('bulan') : date('m');
        $tahun = $this->input->get('tahun') ? $this->input->get('tahun') : date('Y');
        $kecamatan = $this->input->get('kecamatan') ? $this->input->get('kecamatan') : 'all';
        $desa = $this->input->get('desa') ? $this->input->get('desa') : 'all';
    
        // Ambil daftar kecamatan dan desa
        $kecamatan_list = $this->Tanam_model->get_kecamatan();
        $desa_list = ($kecamatan != 'all') ? $this->db->get_where('desa', ['kecamatan_id' => $kecamatan])->result() : [];
    
        // Ambil daftar komoditas
        $komoditas = $this->Tanam_model->get_komoditas();

        // Ambil data tanam berdasarkan filter
        $data_tanam = $this->Tanam_model->get_data_tanam($bulan, $tahun, $kecamatan, $desa);
    
        // Kirim data ke view
        $data = [
            'komoditas' => $komoditas,
            'data_tanam' => $data_tanam,
            'bulan' => $bulan,
            'tahun' => $tahun,
            'kecamatan' => $kecamatan_list,
            'desa' => $desa_list,
            'selected_kecamatan' => $kecamatan,
            'selected_desa' => $desa,
        ];
        $data['username'] = $this->session->userdata('username');
    
        $this->load->view('petugas_kantor/template-pk/header');
        $this->load->view('petugas_kantor/template-pk/sidebar', $data);
        $this->load->view('petugas_kantor/laporan_tanam', $data);
        $this->load->view('petugas_kantor/template-pk/footer');
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

    // ================================ Fungsi Convert Excel =====================================
    public function convert_excel() {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Terima data filter dari form
        $bulan = $this->input->post('bulan');
        $tahun = $this->input->post('tahun');
        $kecamatan = $this->input->post('kecamatan');
        $desa = $this->input->post('desa');

        // Sesuaikan informasi di atas tabel
        $sheet->setCellValue('A1', 'Bulan:');
        $sheet->setCellValue('B1', $this->get_nama_bulan($bulan));
        $sheet->setCellValue('A2', 'Tahun:');
        $sheet->setCellValue('B2', $tahun);
        $sheet->setCellValue('A3', 'Kecamatan:');
        $sheet->setCellValue('B3', ($kecamatan == 'all' ? 'Semua Kecamatan' : $this->get_nama_kecamatan($kecamatan)));
        $sheet->setCellValue('A4', 'Desa:');
        $sheet->setCellValue('B4', ($desa == 'all' ? 'Semua Desa' : $this->get_nama_desa($desa)));

        // Header tabel
        $sheet->setCellValue('A6', 'No');
        $sheet->setCellValue('B6', 'Komoditas');
        $sheet->mergeCells('A6:A7');
        $sheet->mergeCells('B6:B7');
        $sheet->setCellValue('C6', 'Tanggal');

        // Dapatkan jumlah hari dalam bulan
        $jumlah_hari = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);

        // Set header tanggal (1-jumlah_hari)
        $last_col = Coordinate::stringFromColumnIndex($jumlah_hari + 2);
        $sheet->mergeCells('C6:' . $last_col . '6');
        for ($i = 1; $i <= $jumlah_hari; $i++) {
            $col = Coordinate::stringFromColumnIndex($i + 2);
            $sheet->setCellValue($col . '7', $i);
        }

        // Tambahkan kolom jumlah
        $jumlahCol = Coordinate::stringFromColumnIndex($jumlah_hari + 3);
        $sheet->setCellValue($jumlahCol . '6', 'Jml');
        $sheet->mergeCells($jumlahCol . '6:' . $jumlahCol . '7');

        // Ambil semua komoditas
        $komoditas_list = $this->Tanam_model->get_komoditas();

        // Ambil data dari model
        $data = $this->Tanam_model->get_data_tanam($bulan, $tahun, $kecamatan, $desa);

        // Olah data tanam berdasarkan komoditas
        $data_tanam = [];
        foreach ($data as $item) {
            $data_tanam[$item->komoditas][$item->tanggal] = $item->luas_tanam;
        }

        // Menulis data ke dalam sheet
        $row = 8;
        $no = 1;
        foreach ($komoditas_list as $komoditas_item) {
            $komoditas = $komoditas_item->komoditas;
            $sheet->setCellValue('A' . $row, $no++);
            $sheet->setCellValue('B' . $row, $komoditas);

            $total = 0;
            for ($i = 1; $i <= $jumlah_hari; $i++) {
                $luas = isset($data_tanam[$komoditas][$i]) ? $data_tanam[$komoditas][$i] : 0;
                $col = Coordinate::stringFromColumnIndex($i + 2);
                $sheet->setCellValue($col . $row, $luas);
                $total += $luas;
            }

            $sheet->setCellValue($jumlahCol . $row, $total);
            $row++;
        }

        // Format agar teks rata tengah
        $sheet->getStyle('A6:' . $jumlahCol . ($row - 1))->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A6:' . $jumlahCol . ($row - 1))->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);

        // Set border tabel
        $sheet->getStyle('A6:' . $jumlahCol . ($row - 1))->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN);

        // Atur ukuran kolom manual
        $sheet->getColumnDimension('A')->setWidth(10.5); // Kolom No
        $sheet->getColumnDimension('B')->setWidth(18.57); // Kolom Komoditas
        $jumlah_hari = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
        for ($i = 1; $i <= $jumlah_hari; $i++) {
            $col = Coordinate::stringFromColumnIndex($i + 2);
            $sheet->getColumnDimension($col)->setWidth(5); // Kolom Tanggal (1-31)
        }
        $jumlahCol = Coordinate::stringFromColumnIndex($jumlah_hari + 3);
        $sheet->getColumnDimension($jumlahCol)->setWidth(10); // Kolom Jml

        // Buat file Excel
        $writer = new Xlsx($spreadsheet);
        $filename = 'Data_Tanam_' . date('Ymd') . '.xlsx';

        ob_end_clean();

        // Header untuk download file
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }


    // Fungsi untuk mengambil nama kecamatan
    private function get_nama_kecamatan($kecamatan_id) {
        $kecamatan = $this->Tanam_model->get_kecamatan_by_id($kecamatan_id);
        return $kecamatan ? $kecamatan->kecamatan : '';
    }

    // Fungsi untuk mengambil nama desa
    private function get_nama_desa($desa_id) {
        $desa = $this->Tanam_model->get_desa_by_id($desa_id);
        return $desa ? $desa->desa : '';
    }

    // Fungsi untuk mengonversi nomor bulan menjadi nama bulan
    private function get_nama_bulan($bulan) {
        $bulan_arr = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni',
            7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];

        if (is_numeric($bulan) && isset($bulan_arr[(int)$bulan])) {
            return $bulan_arr[(int)$bulan];
        } else {
            return '';
        }
    }
}