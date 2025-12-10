<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Partial_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_all_partial()
    {
        $query = $this->db->get('user_parsial');
        if (!$query) {
            // Debugging error
            $error = $this->db->error();
            echo "Error: " . $error['message'];
            die();
        }
        return $query->result_array();
    }

    public function insertPartial($data)
    {
        $this->db->insert('user_parsial', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        }
        return false;
    }

    public function updatePartial($id_parsial, $data)
    {
        $this->db->where('id_parsial', $id_parsial);
        return $this->db->update('user_parsial', $data);
    }

    public function getPartialById($id_parsial)
    {
        return $this->db->get_where('user_parsial', ['id_parsial' => $id_parsial])->row_array();
    }


    public function get_partial_by_id($id)
    {
        $this->db->where('id_parsial', $id);
        $query = $this->db->get('user_parsial');
        return $query->row_array();
    }


    public function update_partial($id, $data)
    {
        $this->db->where('id_parsial', $id);
        $this->db->update('user_parsial', $data);
    }

    public function get_reminder_dates()
    {
        $this->db->select('id_parsial, tgl_kirim_pom, tgl_kembali_pom, DATE_ADD(tgl_kirim_pom, INTERVAL 10 DAY) as reminder_date');
        $this->db->from('user_parsial');

        $query = $this->db->get();

        // Pastikan tidak ada output langsung dari query
        if ($query === false) {
            log_message('error', 'Database query failed: ' . $this->db->last_query());
            return [];
        }

        return $query->result_array();
    }

    public function get_partials($search = '')
    {
        $this->db->select('*');
        $this->db->from('user_parsial');
        if (!empty($search)) {
            $this->db->like('lokasi', $search);
            $this->db->or_like('area', $search);
            $this->db->or_like('pekerjaan', $search);
            $this->db->or_like('nama_kontraktor', $search);
            $this->db->or_like('no_dokumen', $search);
        }
        $query = $this->db->get();

        // Debugging: Log the query and results
        log_message('debug', 'SQL Query: ' . $this->db->last_query());
        log_message('debug', 'Query Results: ' . print_r($query->result_array(), true));

        return $query->result_array();
    }

    // Fungsi untuk menghapus semua data lama
    public function delete_all()
    {
        $this->db->empty_table('user_parsial'); // Ganti 'partial_table' dengan nama tabel yang sesuai
    }

    // Fungsi untuk menyimpan data baru
    public function save_partial($data)
    {
        return $this->db->insert('user_parsial', $data); // Ganti 'partial_table' dengan nama tabel yang sesuai
    }

    public function formatDate($date)
    {
        if (is_null($date) || trim($date) === '') {
            return null; // Atau string kosong jika diinginkan
        }

        if ($date instanceof \PhpOffice\PhpSpreadsheet\RichText\RichText) {
            $date = $date->getPlainText();
        }

        // Cek jika $date adalah integer atau float sebelum mengkonversinya
        if (is_numeric($date)) {
            $date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($date);
            return $date->format('Y-m-d');
        } else {
            // Jika $date bukan tanggal, kembalikan nilai default atau log kesalahan
            return null; // Atau kembalikan nilai default lainnya
        }
    }
}
