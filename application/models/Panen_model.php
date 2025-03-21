<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Panen_model extends CI_Model {
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

    public function get_desa_by_kecamatan($kecamatan_id) {
        $this->db->where('kecamatan_id', $kecamatan_id);
        return $this->db->get('desa')->result(); // Ambil data desa berdasarkan kecamatan
    }

    public function get_penyuluh() {
        return $this->db->get_where('user', ['role' => 'penyuluh'])->result();
    }

    public function get_data_panen($bulan, $tahun, $kecamatan = null, $desa = null, $penyuluh = null) {
        $this->db->select('komoditas.komoditas AS komoditas, DAY(panen.tgl_panen) AS tanggal, COALESCE(SUM(panen.luas), 0) AS luas_panen');
        $this->db->from('komoditas'); 
        $this->db->join('panen', 'panen.komoditas_id = komoditas.id', 'LEFT'); 
    
        // Pisahkan kondisi bulan dan tahun di bagian WHERE, bukan di JOIN
        $this->db->where('MONTH(panen.tgl_panen)', $bulan);
        $this->db->where('YEAR(panen.tgl_panen)', $tahun);
    
        // Filter kecamatan jika dipilih
        if ($kecamatan && $kecamatan != 'all') {
            $this->db->where('panen.kecamatan_id', $kecamatan);
        }
    
        // Filter desa jika dipilih
        if ($desa && $desa != 'all') {
            $this->db->where('panen.desa_id', $desa);
        }
    
        // Filter penyuluh jika dipilih
        if ($penyuluh && $penyuluh != 'all') {
            $this->db->where('panen.user_id', $penyuluh);
        }
    
        // Grouping
        $this->db->group_by(['komoditas.komoditas', 'DAY(panen.tgl_panen)']);
    
        $query = $this->db->get();
        return $query->result();
    }

    public function saveBatch($data) {
        if (!empty($data)) {
            $this->db->insert_batch('panen', $data);
        }
    }

    public function deleteByBatch($batch_id) {
        $this->db->where('batch_id', $batch_id);
        $this->db->delete('panen');
    }

    public function getDataByBatch($batch_id) {
        return $this->db->get_where('panen', ['batch_id' => $batch_id])->result();
    }

    public function getTotalPanenByDate($tanggal) {
        $this->db->select('komoditas_id, SUM(luas) as total_panen');
        $this->db->from('panen');
        $this->db->where('tgl_panen', $tanggal);
        $this->db->group_by('komoditas_id');
        return $this->db->get()->result();
    }
    
    public function getTotalPanenByMonth($bulan, $tahun) {
        $this->db->select('komoditas_id, SUM(luas) as total_panen');
        $this->db->from('panen');
        $this->db->where('MONTH(tgl_panen)', $bulan);
        $this->db->where('YEAR(tgl_panen)', $tahun);
        $this->db->group_by('komoditas_id');
        return $this->db->get()->result();
    }

    public function getTotalPanenByYear($tahun) {
        $this->db->select('komoditas_id, SUM(luas) as total_panen');
        $this->db->from('panen');
        $this->db->where('YEAR(tgl_panen)', $tahun);
        $this->db->group_by('komoditas_id');
        return $this->db->get()->result();
    }
}