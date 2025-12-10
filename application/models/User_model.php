<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{

    public function getJoinedAsBuiltData()
    {
        $query = $this->db->query("
            SELECT 
                user_final_account.id, 
                user_final_account.no_kontrak, 
                user_final_account.nama_pt, 
                user_final_account.pekerjaan, 
                user_asbuiltdrawing.id_asbuilt, 
                user_asbuiltdrawing.keterangan, 
                user_asbuiltdrawing.tgl_terima,
                user_asbuiltdrawing.status,
                user_asbuiltdrawing.no_kontrak
            FROM 
                user_final_account 
            JOIN 
                user_asbuiltdrawing 
            ON 
                user_final_account.no_kontrak = user_asbuiltdrawing.no_kontrak
        ");

        return $query->result_array();
    }

    public function addAsBuiltData($no_kontrak, $data)
    {
        // Insert data ke dalam tabel user_asbuiltdrawing
        $this->db->insert('user_asbuiltdrawing', $data);
    }

    public function getUserFinalAccounts()
    {
        $query = $this->db->get('user_final_account');
        return $query->result_array();
    }

    public function getNoKontrak()
    {
        // Ambil data no kontrak dari tabel 'user_final_account'
        $query = $this->db->get('user_final_account');
        // Kembalikan hasil query dalam bentuk array
        return $query->result_array();
    }


    ///////////////////////////USER MANAGEMENT/////////////////

    public function get_users()
    {
        // Ambil data pengguna dari tabel 'user'
        return $this->db->get('user')->result_array();
    }


    public function update_user($user_id, $data)
    {
        // Lakukan update data pengguna berdasarkan $user_id
        $this->db->where('id', $user_id);
        $this->db->update('user', $data);
    }

    public function delete_user($user_id)
    {
        // Hapus data pengguna berdasarkan $user_id
        $this->db->where('id', $user_id);
        $this->db->delete('user');
    }
}
