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

    // All Data Lahan
    // public function get_lahan() {
    //     $this->db->select('lahan.*, kecamatan.kecamatan, desa.desa');
    //     $this->db->from('lahan');
    //     $this->db->join('kecamatan', 'lahan.kecamatan_id = kecamatan.id', 'left');
    //     $this->db->join('desa', 'lahan.desa_id = desa.id', 'left');
        
    //     $query = $this->db->get();
    //     $data = $query->result();

    //     foreach ($data as $row) {
    //         // Ubah string koordinat ke dalam array
    //         $coords = explode("\n", trim($row->koordinat)); // Pisahkan berdasarkan baris baru
    //         $geojsonCoords = [];

    //         foreach ($coords as $coord) {
    //             $latlng = explode(", ", trim($coord)); // Pisahkan berdasarkan koma
    //             if (count($latlng) == 2) {
    //                 $geojsonCoords[] = [(float)$latlng[1], (float)$latlng[0]]; // GeoJSON = [lng, lat]
    //             }
    //         }

    //         // Tutup poligon dengan titik awal jika belum tertutup
    //         if ($geojsonCoords[0] !== end($geojsonCoords)) {
    //             $geojsonCoords[] = $geojsonCoords[0];
    //         }

    //         // Buat format GeoJSON
    //         // $row->geojson = [
    //         //     "type" => "Polygon",
    //         //     "coordinates" => [$geojsonCoords]
    //         // ];
    //         $row->geojson = [
    //             "type" => "Feature",
    //             "geometry" => [
    //                 "type" => "Polygon",
    //                 "coordinates" => [$geojsonCoords]
    //             ],
    //             "properties" => [
    //                 "id" => $row->id,
    //                 "lahan" => $row->lahan,
    //                 "kecamatan" => $row->kecamatan,
    //                 "desa" => $row->desa,
    //                 "luas" => $row->luas,
    //                 "irigasi" => $row->irigasi,
    //                 "kondisi" => $row->kondisi,
    //                 "kecamatan_id" => $row->kecamatan_id
    //             ]
    //         ];            
    //     }

    //     return $data;
    // }
    public function get_lahan() {
        $this->db->select('lahan.*, kecamatan.kecamatan, desa.desa');
        $this->db->from('lahan');
        $this->db->join('kecamatan', 'lahan.kecamatan_id = kecamatan.id', 'left');
        $this->db->join('desa', 'lahan.desa_id = desa.id', 'left');
    
        $query = $this->db->get();
        $data = $query->result();
    
        $features = [];
    
        foreach ($data as $row) {
            $coords = explode("\n", trim($row->koordinat));
            $geojsonCoords = [];
    
            foreach ($coords as $coord) {
                $latlng = explode(", ", trim($coord));
                if (count($latlng) == 2) {
                    $geojsonCoords[] = [(float)$latlng[1], (float)$latlng[0]];
                }
            }
    
            if ($geojsonCoords[0] !== end($geojsonCoords)) {
                $geojsonCoords[] = $geojsonCoords[0];
            }
    
            $features[] = [
                "type" => "Feature",
                "geometry" => [
                    "type" => "Polygon",
                    "coordinates" => [$geojsonCoords]
                ],
                "properties" => [
                    "id" => $row->id,
                    "lahan" => $row->lahan,
                    "kecamatan" => $row->kecamatan,
                    "desa" => $row->desa,
                    "luas" => $row->luas,
                    "irigasi" => $row->irigasi,
                    "kondisi" => $row->kondisi,
                    "kecamatan_id" => $row->kecamatan_id
                ]
            ];
        }
    
        // Kembalikan sebagai FeatureCollection GeoJSON
        $geojson = [
            "type" => "FeatureCollection",
            "features" => $features
        ];
    
        // Output sebagai JSON langsung (jika endpoint)
        header('Content-Type: application/json');
        echo json_encode($geojson);
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

    // Total Produksi
    // public function getTotalProduksi($kecamatan_id){
    //     $bulan_ini = date('Y-m'); // Format YYYY-MM

    //     $query = $this->db->query("
    //         SELECT 
    //             COALESCE(SUM(t.luas), 0) AS total_tanam,
    //             COALESCE(SUM(p.luas), 0) AS total_panen,
    //             COALESCE(SUM(pr.berat), 0) AS total_produksi
    //         FROM kecamatan k
    //         LEFT JOIN tanam t ON t.kecamatan_id = k.id AND DATE_FORMAT(t.created_at, '%Y-%m') = '$bulan_ini'
    //         LEFT JOIN panen p ON p.kecamatan_id = k.id AND DATE_FORMAT(p.created_at, '%Y-%m') = '$bulan_ini'
    //         LEFT JOIN produksi pr ON pr.kecamatan_id = k.id AND DATE_FORMAT(pr.created_at, '%Y-%m') = '$bulan_ini'
    //         WHERE k.id = ?
    //     ", array($kecamatan_id)); // Pastikan kecamatan_id digunakan dengan parameter binding

    //     return $query->row();
    // }

    public function getTotalProduksi($kecamatan_id){
        $bulan_ini = date('Y-m'); // Format: 2025-04
    
        $query = $this->db->query("
            SELECT 
                (
                    SELECT COALESCE(SUM(t.luas), 0)
                    FROM tanam t
                    WHERE t.kecamatan_id = ? AND DATE_FORMAT(t.tgl_tanam, '%Y-%m') = ?
                ) AS total_tanam,
                (
                    SELECT COALESCE(SUM(p.luas), 0)
                    FROM panen p
                    WHERE p.kecamatan_id = ? AND DATE_FORMAT(p.tgl_panen, '%Y-%m') = ?
                ) AS total_panen,
                (
                    SELECT COALESCE(SUM(pr.berat), 0)
                    FROM produksi pr
                    WHERE pr.kecamatan_id = ? AND DATE_FORMAT(pr.tgl_produksi, '%Y-%m') = ?
                ) AS total_produksi
        ", array($kecamatan_id, $bulan_ini, $kecamatan_id, $bulan_ini, $kecamatan_id, $bulan_ini));
    
        return $query->row();
    }        
}