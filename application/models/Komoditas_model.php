<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Komoditas_model extends CI_Model {
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // View
    public function get_all_data() {
        return $this->db->get('komoditas')->result();
    }

    // Tambah data
    public function insert_data($data) {
        return $this->db->insert('komoditas', $data);
    }

    // Ambil data berdasarkan Id
    public function get_data_by_id($id) {
        return $this->db->get_where('komoditas', ['id'=> $id])->row();
    }

    // Update data
    public function update_data($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('komoditas', $data);
    }

    // Hapus data
    public function delete_data($id) {
        $this->db->where('id', $id);
        return $this->db->delete('komoditas');
    }
}