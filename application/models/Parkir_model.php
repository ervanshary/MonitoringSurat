<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Parkir_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_all_parkir()
    {
        // Query untuk mengambil semua data parkir
        $query = $this->db->get('user_parkir');
        return $query->result_array();
    }

    public function insertParkir($data)
    {
        $this->db->insert('user_parkir', $data);
        return $this->db->affected_rows() > 0;
    }

    public function updateParkir($id, $data)
    {
        $this->db->where('id_parkir', $id);
        return $this->db->update('user_parkir', $data);
    }

    public function delete_all()
    {
        $this->db->empty_table('user_parkir');
    }

    public function save_parkir($data)
    {
        $this->db->trans_start();
        $this->db->insert('user_parkir', $data);
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            log_message('error', 'Failed to insert data into parkir table');
            return false;
        }
        return true;
    }

    public function get_parkirs($search = '')
    {
        if (!empty($search)) {
            $this->db->like('perusahaan', $search);
            $this->db->or_like('nama_member', $search);
            $this->db->or_like('no_kendaraan', $search);
            $this->db->or_like('no_kartu', $search);
            $this->db->or_like('jenis_kendaraan', $search);
            $this->db->or_like('tgl_pembuatan', $search);
            $this->db->or_like('tgl_berakhir', $search);
            $this->db->or_like('keterangan', $search);
            $this->db->or_like('scan_dokumen', $search);
        }
        return $this->db->get('user_parkir')->result_array();
    }

    public function get_all_partials()
    {
        $query = $this->db->get('user_parsial'); // Ganti 'partials' dengan nama tabel Anda jika berbeda
        return $query->result_array();
    }

    public function get_parkir_reminder()
    {
        $this->db->select('*');
        $this->db->from('user_parkir');
        $this->db->where('DATEDIFF(tgl_berakhir, CURDATE()) <= 7');
        $this->db->where('DATEDIFF(tgl_berakhir, CURDATE()) >= 0');
        $query = $this->db->get();
        return $query->result_array();
    }


    // Update parkir status
    public function update_status($id_parkir, $status)
    {
        $this->db->where('id_parkir', $id_parkir);
        return $this->db->update('user_parkir', array('status' => $status));
    }

    // PARKIR NON AKTIF///

    // Fungsi untuk mendapatkan data parkir dengan status non-aktif
    // Ambil semua data dari user_non_active
    public function move_to_non_active($id_parkir)
    {
        $this->db->where('id_parkir', $id_parkir);
        return $this->db->update('parkir', ['status' => 'non_active']);
    }
}
