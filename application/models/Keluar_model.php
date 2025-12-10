<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Keluar_model extends CI_Model
{
    // Mengambil semua data barang di gudang
    public function get_all_items()
    {
        $query = $this->db->get('user_barangkeluar');
        if (!$query) {
            log_message('error', 'Database error: ' . $this->db->last_query());
        }
        return $query ? $query->result_array() : [];
    }



    // Menambahkan data barang ke dalam tabel user_barangkeluar
    public function insert_item($data)
    {
        return $this->db->insert('user_barangkeluar', $data);
    }

    // Memperbarui data barang berdasarkan ID
    public function update_item($id, $data)
    {
        $this->db->where('id', $id);
        $result = $this->db->update('user_barangkeluar', $data);

        // echo "<pre>";
        // echo "QUERY YANG DIEKSEKUSI: " . $this->db->last_query() . "\n";

        // if (!$result) {
        //     echo "ERROR UPDATE: " . print_r($this->db->error(), true);
        // } else {
        //     echo "UPDATE BERHASIL!";
        // }
        // echo "</pre>";
        // die(); // Hentikan eksekusi untuk melihat hasilnya
    }


    // Menghapus data barang berdasarkan ID
    public function delete_item($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('user_barangkeluar');
    }

    public function delete_all_items()
    {
        $this->db->empty_table('user_barangkeluar'); // Ganti 'nama_tabel' dengan nama tabel Anda
    }
}
