<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Gudang_model extends CI_Model
{
    // Mengambil semua data barang di gudang
    public function get_all_items()
    {
        $query = $this->db->get('user_barangmasuk');
        if (!$query) {
            log_message('error', 'Database error: ' . $this->db->last_query());
        }
        return $query ? $query->result_array() : [];
    }



    // Menambahkan data barang ke dalam tabel user_barangmasuk
    public function insert_item($data)
    {
        return $this->db->insert('user_barangmasuk', $data);
    }

    // Memperbarui data barang berdasarkan ID
    public function update_item($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('user_barangmasuk', $data);
    }

    // Menghapus data barang berdasarkan ID
    public function delete_item($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('user_barangmasuk');
    }

    public function delete_all_items()
    {
        $this->db->empty_table('user_barangmasuk'); // Ganti 'nama_tabel' dengan nama tabel Anda
    }

    public function getBarangKeluarById($id)
    {
        return $this->db->get_where('user_barangkeluar', ['id' => $id])->row_array();
    }
}
