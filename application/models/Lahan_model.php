<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lahan_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    //  Ambil id Kecamatan
    public function get_kecamatan() {
        return $this->db->get('kecamatan')->result();
    }

    // Ambil id Desa
    public function get_desa() {
        return $this->db->get('desa')->result();
    }

    // View
    public function get_viewData() {
        $this->db->select('lahan.*, kecamatan.kecamatan, desa.desa');
        $this->db->from('lahan');
        $this->db->join('kecamatan', 'lahan.kecamatan_id = kecamatan.id', 'left');
        $this->db->join('desa', 'lahan.desa_id = desa.id', 'left');
        return $this->db->get()->result();
    }

    // Ambil ID untuk Modal
    public function getDataModal($id) {
        $this->db->select('l.*, kec.kecamatan AS nama_kecamatan, des.desa AS nama_desa');
        $this->db->from('lahan l');
        $this->db->join('kecamatan kec', 'kec.id = l.kecamatan_id', 'left');
        $this->db->join('desa des', 'des.id = l.desa_id', 'left');
        $this->db->where('l.id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }

    // Tambah data
    public function insert_data($data) {
        return $this->db->insert('lahan', $data);
    }

    // Ambil data berdasarkan Id
    public function get_data_by_id($id) {
        $this->db->select('lahan.*, kecamatan.kecamatan, desa.desa');
        $this->db->from('lahan');
        $this->db->join('kecamatan', 'lahan.kecamatan_id = kecamatan.id', 'left');
        $this->db->join('desa', 'lahan.desa_id = desa.id', 'left');
        $this->db->where('lahan.id', $id);
        return $this->db->get()->row();
    }

    // Update data
    public function update_data($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('lahan', $data);
    }

    // Hapus data
    public function delete_data($id) {
        $this->db->where('id', $id);
        return $this->db->delete('lahan');
    }
}