<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tanam_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function get_komoditas() {
        return $this->db->get('komoditas')->result();
    }

    public function get_kecamatan(){
        return $this->db->get('kecamatan')->result();
    }

    // Fungsi untuk mengambil kecamatan berdasarkan ID
    public function get_kecamatan_by_id($kecamatan_id) {
        return $this->db->get_where('kecamatan', ['id' => $kecamatan_id])->row();
    }

    // Fungsi untuk mengambil desa berdasarkan ID
    public function get_desa_by_id($desa_id) {
        return $this->db->get_where('desa', ['id' => $desa_id])->row();
    }
    
    public function get_desa_by_kecamatan($kecamatan_id) {
        $this->db->where('kecamatan_id', $kecamatan_id);
        return $this->db->get('desa')->result(); // Ambil data desa berdasarkan kecamatan
    }

    public function get_penyuluh() {
        return $this->db->get_where('user', ['role' => 'penyuluh'])->result();
    }

    public function get_data_tanam($bulan, $tahun, $kecamatan = null, $desa = null, $penyuluh = null) {
        $this->db->select('komoditas.komoditas AS komoditas, DAY(tanam.tgl_tanam) AS tanggal, COALESCE(SUM(tanam.luas), 0) AS luas_tanam');
        $this->db->from('komoditas'); 
        $this->db->join('tanam', 'tanam.komoditas_id = komoditas.id', 'LEFT'); 
    
        // Pisahkan kondisi bulan dan tahun di bagian WHERE, bukan di JOIN
        $this->db->where('MONTH(tanam.tgl_tanam)', $bulan);
        $this->db->where('YEAR(tanam.tgl_tanam)', $tahun);
    
        // Filter kecamatan jika dipilih
        if ($kecamatan && $kecamatan != 'all') {
            $this->db->where('tanam.kecamatan_id', $kecamatan);
        }
    
        // Filter desa jika dipilih
        if ($desa && $desa != 'all') {
            $this->db->where('tanam.desa_id', $desa);
        }
    
        // Filter penyuluh jika dipilih
        if ($penyuluh && $penyuluh != 'all') {
            $this->db->where('tanam.user_id', $penyuluh);
        }
    
        // Grouping
        $this->db->group_by(['komoditas.komoditas', 'DAY(tanam.tgl_tanam)']);
    
        $query = $this->db->get();
        return $query->result();
    }
    
    public function saveBatch($data) {
        if (!empty($data)) {
            $this->db->insert_batch('tanam', $data);
        }
    }

    public function deleteByBatch($batch_id) {
        $this->db->where('batch_id', $batch_id);
        $this->db->delete('tanam');
    }

    public function getDataByBatch($batch_id) {
        return $this->db->get_where('tanam', ['batch_id' => $batch_id])->result();
    }
    
    // ================================== Dashboard =======================================
    public function getTotalTanamByDate($tanggal) {
        $this->db->select('komoditas_id, SUM(luas) as total_tanam');
        $this->db->from('tanam');
        $this->db->where('tgl_tanam',$tanggal);
        $this->db->group_by('komoditas_id');
        return $this->db->get()->result();
    }

    public function getTotalTanamByMonth($bulan, $tahun) {
        $this->db->select('komoditas_id, SUM(luas) as total_tanam');
        $this->db->from('tanam');
        $this->db->where('MONTH(tgl_tanam)', $bulan);
        $this->db->where('YEAR(tgl_tanam)', $tahun);
        $this->db->group_by('komoditas_id');
        return $this->db->get()->result();
    }

    public function getTotalTanamByYear($tahum) {
        $this->db->select('komoditas_id, SUM(luas) as total_tanam');
        $this->db->from('tanam');
        $this->db->where('YEAR(tgl_tanam)', $tahum);
        $this->db->group_by('komoditas_id');
        return $this->db->get()->result();
    }
}