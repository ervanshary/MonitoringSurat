<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Closing_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function syncClosingData()
    {
        $this->db->trans_start();

        // Ambil data dari tabel user_final_account dan user_bast
        $query = $this->db->query("
            SELECT 
                uf.no_kontrak, 
                uf.nama_pt, 
                uf.pekerjaan, 
                ub.tgl_terima_bast
            FROM 
                user_final_account uf
            JOIN 
                user_bast ub ON uf.no_kontrak = ub.no_kontrak
        ");

        $data = $query->result_array();

        // Log hasil query untuk debug
        log_message('debug', 'Hasil Query Sinkronisasi: ' . print_r($data, TRUE));

        if (!empty($data)) {
            foreach ($data as $row) {
                // Cek jika data sudah ada, update jika ada, insert jika tidak ada
                $this->db->where('no_kontrak', $row['no_kontrak']);
                $query = $this->db->get('user_closing');

                if ($query->num_rows() > 0) {
                    // Update data
                    $this->db->where('no_kontrak', $row['no_kontrak']);
                    $this->db->update('user_closing', [
                        'nama_pt' => $row['nama_pt'],
                        'pekerjaan' => $row['pekerjaan'],
                        'tgl_terima_bast' => $row['tgl_terima_bast']
                    ]);
                } else {
                    // Insert data baru
                    $this->db->insert('user_closing', [
                        'no_kontrak' => $row['no_kontrak'],
                        'nama_pt' => $row['nama_pt'],
                        'pekerjaan' => $row['pekerjaan'],
                        'tgl_terima_bast' => $row['tgl_terima_bast'],
                        'tgl_closing' => null, // Set default atau null jika belum ada
                        'scan_fa' => null, // Set default atau null jika belum ada
                        'keterangan_fa' => null, // Set default atau null jika belum ada
                        'is_active' => 1
                    ]);
                }
            }
        }

        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {
            log_message('error', 'Gagal sinkronisasi data closing');
        } else {
            log_message('debug', 'Sinkronisasi data closing berhasil');
        }
    }


    public function get_all_partials()
    {
        $query = $this->db->get('user_parsial'); // Ganti 'partials' dengan nama tabel Anda jika berbeda
        return $query->result_array();
    }


    // Mendapatkan semua data closing
    public function get_all_closing()
    {
        $query = $this->db->get('user_closing');
        if ($query === FALSE) {
            log_message('error', 'Query gagal di Closing_model::get_all_closing. Error: ' . $this->db->last_query());
            return [];
        }
        return $query->result_array();
    }


    // Menyimpan data closing
    public function save_closing_data($data)
    {
        return $this->db->insert('user_closing', $data);
    }

    // Mengupdate data closing
    public function update_closing($id_closing, $data)
    {
        $this->db->where('id_closing', $id_closing);
        return $this->db->update('user_closing', $data);
    }

    // Menghapus data closing
    public function delete_closing($id_closing)
    {
        $this->db->where('id_closing', $id_closing);
        return $this->db->delete('user_closing');
    }
}
