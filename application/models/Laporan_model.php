<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function getGroupedData(){
        $this->db->select('batch_id, MAX(tgl_tanam) as tgl_tanam, MAX(kecamatan.kecamatan) as nama_kecamatan, MAX(desa.desa) as nama_desa, MAX(user.nama) as penyuluh', false);
        $this->db->from('tanam');
        $this->db->join('kecamatan', 'kecamatan.id = tanam.kecamatan_id', 'left');
        $this->db->join('desa', 'desa.id = tanam.desa_id', 'left');
        $this->db->join('user', 'user.id = tanam.user_id', 'left');
        $this->db->group_by('batch_id');
        $this->db->order_by('tgl_tanam', 'DESC');

        $query = $this->db->get();
        return $query->result();
    }

    // Untuk Penyuluh
    public function getGroupedDataP(){
        $user_id = $this->session->userdata('user_id');

        $this->db->select('batch_id, MAX(tgl_tanam) as tgl_tanam, MAX(kecamatan.kecamatan) as nama_kecamatan, MAX(desa.desa) as nama_desa, MAX(user.nama) as penyuluh', false);
        $this->db->from('tanam');
        $this->db->join('kecamatan', 'kecamatan.id = tanam.kecamatan_id', 'left');
        $this->db->join('desa', 'desa.id = tanam.desa_id', 'left');
        $this->db->join('user', 'user.id = tanam.user_id', 'left');
        $this->db->where('user_id', $user_id);
        $this->db->group_by('batch_id');
        $this->db->order_by('tgl_tanam', 'DESC');

        $query = $this->db->get();
        return $query->result();
    }

    // Untuk modal
    public function getDetailByBatch($batch_id) {
        $this->db->select('
            k.id AS komoditas_id, k.komoditas,
            t.luas AS luas_tanam, p.luas AS luas_panen, pr.berat AS berat_produksi
        ');
        $this->db->from('komoditas k');
        $this->db->join('tanam t', 't.komoditas_id = k.id AND t.batch_id = ' . $batch_id, 'left');
        $this->db->join('panen p', 'p.komoditas_id = k.id AND p.batch_id = ' . $batch_id, 'left');
        $this->db->join('produksi pr', 'pr.komoditas_id = k.id AND pr.batch_id = ' . $batch_id, 'left');
        $this->db->order_by('k.id', 'ASC'); // Urutkan berdasarkan nama komoditas
        $query = $this->db->get();
        return $query->result();
    }
    
    public function getBatchInfo($batch_id) {
        $this->db->select('t.tgl_tanam, kec.kecamatan AS nama_kecamatan, desa.desa AS nama_desa, user.nama AS penyuluh');
        $this->db->from('tanam t');
        $this->db->join('kecamatan kec', 'kec.id = t.kecamatan_id', 'left');
        $this->db->join('desa desa', 'desa.id = t.desa_id', 'left');
        $this->db->join('user user', 'user.id = t.user_id', 'left');
        $this->db->where('t.batch_id', $batch_id);
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->row();
    }
    

    public function get_tanam_by_batch($batch_id) {
        return $this->db->get_where('tanam', ['batch_id' => $batch_id])->result();
    }

    public function get_panen_by_batch($batch_id) {
        return $this->db->get_where('panen', ['batch_id' => $batch_id])->result();
    }

    public function get_produksi_by_batch($batch_id) {
        return $this->db->get_where('produksi', ['batch_id' => $batch_id])->result();
    }

    public function hapus_batch($batch_id) {
        if (!$batch_id) return false;

        // Mulai transaksi
        $this->db->trans_start();

        // Hapus data dari tiga tabel
        $this->db->where('batch_id', $batch_id)->delete('tanam');
        $this->db->where('batch_id', $batch_id)->delete('panen');
        $this->db->where('batch_id', $batch_id)->delete('produksi');

        // Selesaikan transaksi
        $this->db->trans_complete();

        // Periksa apakah transaksi berhasil
        return $this->db->trans_status();
    }
}