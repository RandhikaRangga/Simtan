<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Desa_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    //  Ambil id Kecamatan
    public function get_kecamatan() {
        return $this->db->get('kecamatan')->result();
    }

    public function get_desa() {
        return $this->db->get('desa')->result();
    }

    // View
    public function get_all_data() {
        $this->db->select('desa.*, kecamatan.kecamatan');
        $this->db->from('desa');
        $this->db->join('kecamatan', 'desa.kecamatan_id = kecamatan.id', 'left');
        return $this->db->get()->result();
    }

    // Tambah data
    public function insert_data($data) {
        return $this->db->insert('desa', $data);
    }

    // Ambil data berdasarkan Id
    public function get_data_by_id($id) {
        $this->db->select('desa.*, kecamatan.kecamatan, kecamatan.id as kecamatan_id');
        $this->db->from('desa');
        $this->db->join('kecamatan', 'desa.kecamatan_id = kecamatan.id', 'left');
        $this->db->where('desa.id', $id);
        return $this->db->get()->row();
    }

    // Update data
    public function update_data($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('desa', $data);
    }

    // Hapus data
    public function delete_data($id) {
        $this->db->where('id', $id);
        return $this->db->delete('desa');
    }
}