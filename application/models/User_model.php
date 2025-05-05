<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    // Fungsi untuk mengambil data user berdasarkan username
    public function get_user($username) {
        $this->db->where('username', $username);
        return $this->db->get('user')->row();
    }

    // View
    public function get_all_data() {
        return $this->db->order_by('updated_at', 'DESC')->get('user')->result();
    }

    // Tambah data
    public function insert_data($data) {
        return $this->db->insert('user', $data);
    }

    // Ambil ID untuk Modal
    public function getDataModal($id) {
        $query = $this->db->get_where('user', ['id' => $id]);

        if ($query->num_rows() > 0) {
            return $query->row_array(); // Kembalikan sebagai array
        } else {
            return null;
        }
    }

    // Ambil data berdasarkan Id
    public function get_data_by_id($id) {
        return $this->db->get_where('user', ['id'=> $id])->row();
    }

    // Update data
    public function update_data($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('user', $data);
    }

    // Hapus data
    public function delete_data($id) {
        $this->db->where('id', $id);
        return $this->db->delete('user');
    }
}