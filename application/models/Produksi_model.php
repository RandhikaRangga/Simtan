<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produksi_model extends CI_Model {
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

    public function get_data_produksi($bulan, $tahun, $kecamatan = null, $desa = null, $penyuluh = null) {
        $this->db->select('komoditas.komoditas AS komoditas, DAY(produksi.tgl_produksi) AS tanggal, COALESCE(SUM(produksi.berat), 0) AS berat_produksi');
        $this->db->from('komoditas'); 
        $this->db->join('produksi', 'produksi.komoditas_id = komoditas.id', 'LEFT'); 
    
        // Pisahkan kondisi bulan dan tahun di bagian WHERE, bukan di JOIN
        $this->db->where('MONTH(produksi.tgl_produksi)', $bulan);
        $this->db->where('YEAR(produksi.tgl_produksi)', $tahun);
    
        // Filter kecamatan jika dipilih
        if ($kecamatan && $kecamatan != 'all') {
            $this->db->where('produksi.kecamatan_id', $kecamatan);
        }
    
        // Filter desa jika dipilih
        if ($desa && $desa != 'all') {
            $this->db->where('produksi.desa_id', $desa);
        }
    
        // Filter penyuluh jika dipilih
        if ($penyuluh && $penyuluh != 'all') {
            $this->db->where('produksi.user_id', $penyuluh);
        }
    
        // Grouping
        $this->db->group_by(['komoditas.komoditas', 'DAY(produksi.tgl_produksi)']);
    
        $query = $this->db->get();
        return $query->result();
    }

    public function saveBatch($data) {
        if (!empty($data)) {
            $this->db->insert_batch('produksi', $data);
        }
    }

    public function deleteByBatch($batch_id) {
        $this->db->where('batch_id', $batch_id);
        $this->db->delete('produksi');
    }

    public function getDataByBatch($batch_id) {
        return $this->db->get_where('produksi', ['batch_id' => $batch_id])->result();
    }

    public function getTotalProduksiByDate($tanggal) {
        $this->db->select('komoditas_id, SUM(berat) as total_produksi');
        $this->db->from('produksi');
        $this->db->where('tgl_produksi', $tanggal);
        $this->db->group_by('komoditas_id');
        return $this->db->get()->result();
    }

    public function getTotalProduksiByMonth($bulan, $tahun) {
        $this->db->select('komoditas_id, SUM(berat) as total_produksi');
        $this->db->from('produksi');
        $this->db->where('MONTH(tgl_produksi)', $bulan);
        $this->db->where('YEAR(tgl_produksi)', $tahun);
        $this->db->group_by('komoditas_id');
        return $this->db->get()->result();
    }

    public function getTotalProduksiByYear($tahun) {
        $this->db->select('komoditas_id, SUM(berat) as total_produksi');
        $this->db->from('produksi');
        $this->db->where('YEAR(tgl_produksi)', $tahun);
        $this->db->group_by('komoditas_id');
        return $this->db->get()->result();
    }
    
}