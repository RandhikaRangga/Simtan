<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kecamatan_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // View
    public function get_all_data() {
        return $this->db->get('kecamatan')->result();
    }

    // Tambah data
    public function insert_data($data) {
        return $this->db->insert('kecamatan', $data);
    }

    // Ambil data berdasarkan Id
    public function get_data_by_id($id) {
        return $this->db->get_where('kecamatan', ['id'=> $id])->row();
    }

    // Update data
    public function update_data($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('kecamatan', $data);
    }

    // Hapus data
    public function delete_data($id) {
        $this->db->where('id', $id);
        return $this->db->delete('kecamatan');
    }
}