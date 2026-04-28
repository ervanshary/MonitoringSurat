<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Bast_model extends CI_Model
{

   public function getJoinedBastData()
{
    return $this->db->select([
            'ufa.no_kontrak',
            'ufa.nama_pt',
            'ufa.pekerjaan',

            'uad.id_asbuilt',
            'uad.tgl_terima AS tanggal_terima_asbuilt',
            'uad.status AS status_asbuilt',

            'ub.id_bast',
            'ub.keterangan AS keterangan_bast',
            'ub.tgl_terima_bast',
            'ub.tgl_pusat',
            'ub.tgl_kontraktor',
            'ub.file_pdf',
            'ub.opsi_retensi',
            'ub.is_revisi',
            'ub.created_by',
            'ub.updated_by AS updated_by_bast'
        ])
        ->from('user_final_account ufa')
        ->join('user_asbuiltdrawing uad', 'ufa.no_kontrak = uad.no_kontrak', 'inner')
        ->join('user_bast ub', 'uad.id_asbuilt = ub.id_asbuilt', 'inner')
        ->get()
        ->result_array();
}


    public function getIdData()
    {
        $this->db->select('no_kontrak');
        $query = $this->db->get('user_asbuiltdrawing');
        return $query->result_array();
    }


    public function getAllAsbuiltData()
    {
        $this->db->select('user_final_account.no_kontrak, user_final_account.nama_pt, user_final_account.pekerjaan, user_asbuiltdrawing.id_asbuilt');
        $this->db->from('user_asbuiltdrawing');
        $this->db->join('user_final_account', 'user_asbuiltdrawing.no_kontrak = user_final_account.no_kontrak');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getUserFinalAccounts()
    {
        $query = $this->db->query("
            SELECT * FROM user_final_account
        ");

        return $query->result_array();
    }


    public function addBastData($data)
    {
        $this->db->insert('user_bast', $data);
        if ($this->db->affected_rows() > 0) {
            log_message('debug', 'Data successfully inserted into user_bast');
            return true;
        } else {
            $error = $this->db->error();
            log_message('error', 'Database insert failed - Error: ' . json_encode($error) . ' - Query: ' . $this->db->last_query());
            return false;
        }
    }

    public function addBast2Data($data)
    {
        $this->db->insert('user_bast2', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            log_message('error', 'Database insert failed: ' . $this->db->last_query());
            return false;
        }
    }


    public function getIdAsbuiltByNoKontrak($no_kontrak)
    {
        $this->db->select('id_asbuilt');
        $this->db->where('no_kontrak', $no_kontrak);
        $query = $this->db->get('user_asbuiltdrawing');
        return $query->row_array();
    }
    public function get_all_data()
    {
        // Assuming you have a table named 'bast_data'
        return $this->db->get('bast_data')->result_array();
    }

    public function get_data_by_id($id)
    {
        return $this->db->get_where('bast_data', ['id' => $id])->row_array();
    }

    public function getUserBastData()
    {
        $query = $this->db->select('tgl_terima_bast, file_pdf, nama_pt, pekerjaan, no_kontrak')
            ->get('user_bast');
        return $query->result_array();
    }

    public function getBastDataById($id)
    {
        $this->db->where('id_bast', $id);
        $query = $this->db->get('user_bast');
        return $query->row_array();
    }

    public function getDetailsByNoKontrak($no_kontrak)
    {
        $this->db->where('no_kontrak', $no_kontrak);
        $query = $this->db->get('user_final_account');
        return $query->row_array();
    }

    public function get_all_bast_data()
    {
        $this->db->select('user_bast.id_bast, user_bast.keterangan, user_bast.tgl_terima_bast, user_bast.tgl_pusat, user_bast.tgl_kontraktor, user_bast.file_pdf, user_bast.opsi_retensi, user_final_account.pekerjaan');
        $this->db->from('user_bast');
        // Menggunakan user_asbuiltdrawing untuk menghubungkan user_final_account dengan user_bast melalui no_kontrak
        $this->db->join('user_asbuiltdrawing', 'user_bast.id_asbuilt = user_asbuiltdrawing.id_asbuilt', 'left');
        $this->db->join('user_final_account', 'user_asbuiltdrawing.no_kontrak = user_final_account.no_kontrak', 'left');

        $query = $this->db->get();

        if ($query === false) {
            log_message('error', 'Query failed: ' . $this->db->last_query());
            return false;
        }

        if ($query->num_rows() > 0) {
            return $query->result_array();
        } else {
            return false;
        }
    }


    public function get_data_by_id_bast($id_bast)
    {
        $this->db->select('user_final_account.no_kontrak, user_final_account.nama_pt, user_final_account.pekerjaan, 
                   user_asbuiltdrawing.tgl_terima AS tanggal_terima_asbuilt, user_asbuiltdrawing.status AS status_asbuilt, 
                   user_bast.id_bast, user_bast.keterangan AS keterangan_bast, user_bast.tgl_terima_bast, user_bast.tgl_pusat, 
                   user_bast.tgl_kontraktor, user_bast.file_pdf, user_bast.opsi_retensi');
        $this->db->from('user_final_account');
        $this->db->join('user_asbuiltdrawing', 'user_final_account.no_kontrak = user_asbuiltdrawing.no_kontrak', 'left');
        $this->db->join('user_bast', 'user_asbuiltdrawing.id_asbuilt = user_bast.id_asbuilt', 'left');
        $this->db->where('user_bast.id_bast', $id_bast);

        $query = $this->db->get();

        if ($query === false) {
            log_message('error', 'Query failed: ' . $this->db->last_query());
            return false;
        }

        $result = $query->row_array();
        log_message('debug', 'Query result: ' . print_r($result, true)); // Debug output
        return $result;
    }


    public function getOpsiRetensi()
    {
        // Query untuk mengambil data opsi retensi dari database
        $query = $this->db->query("SELECT * FROM opsi_retensi");
        return $query->result_array();
    }

    // /////////////////////////////EDIT//////////////////////////////////////////////////////////////////////////
    // public function updateBastData($id_bast, $data)
    // {
    //     $this->db->where('id_bast', $id_bast);
    //     return $this->db->update('user_bast', $data);
    // }

    // public function updateAsbuiltData($id_asbuilt, $data)
    // {
    //     $this->db->where('id_asbuilt', $id_asbuilt);
    //     return $this->db->update('user_asbuiltdrawing', $data);
    // }
    public function getBastById($id)
    {
        $query = $this->db->get_where('user_bast', ['id' => $id]);
        return $query->row_array();
    }


    //////////////////////////insert////////////////////

    public function get_user_insert_data()
    {
        $query = $this->db->get('user_insert');
        return $query->result_array();
    }

    public function insert_data($data)
    {
        $result = $this->db->insert('user_bast', $data);
        log_message('debug', 'Insert data query: ' . $this->db->last_query());
        return $result;
    }


    public function check_duplicate_bast($no_kontrak)
    {
        $this->db->from('user_bast1');
        $this->db->where('no_kontrak', $no_kontrak);
        $query = $this->db->get();
        return $query->num_rows() > 0;
    }


    public function insertBastAndClosingData($data)
    {
        // Masukkan data baru ke dalam tabel user_bast1
        $this->db->insert('user_bast1', $data);

        // Periksa apakah operasi penambahan berhasil
        if ($this->db->affected_rows() > 0) {
            // Jika berhasil, tambahkan data ke tabel user_closing
            $this->db->insert('user_closing', [
                'no_kontrak' => $data['no_kontrak'],
                'nama_pt' => $data['nama_pt'],
                'pekerjaan' => $data['pekerjaan'],
                'tgl_terima_bast' => $data['tgl_terima_bast'],
                'file_pdf' => $data['file_pdf']
            ]);
            return true;
        } else {
            return false;
        }
    }


public function updateBastData($id_bast, $data)
{
    if (empty($id_bast)) {
        log_message('error', 'updateBastData: ID BAST kosong');
        return false;
    }

    $this->db->where('id_bast', $id_bast);
    $this->db->update('user_bast', $data);

    $query = $this->db->last_query();
    $error = $this->db->error();
    $affected = $this->db->affected_rows();

    log_message('debug', 'UPDATE BAST QUERY: ' . $query);
    log_message('debug', 'AFFECTED ROWS BAST: ' . $affected);
    
    if ($error['code'] != 0) {
        log_message('error', 'UPDATE BAST ERROR: ' . json_encode($error));
        return false;
    }

    return $affected;  // Return jumlah rows yang affected (bisa 0 jika nilai sama)
}


public function updateAsbuiltData($id_asbuilt, $data)
{
    if (empty($id_asbuilt)) {
        log_message('error', 'updateAsbuiltData: ID Asbuilt kosong');
        return false;
    }

    $this->db->where('id_asbuilt', $id_asbuilt);
    $this->db->update('user_asbuiltdrawing', $data);

    $query = $this->db->last_query();
    $error = $this->db->error();
    $affected = $this->db->affected_rows();

    log_message('debug', 'UPDATE ASBUILT QUERY: ' . $query);
    log_message('debug', 'AFFECTED ROWS ASBUILT: ' . $affected);
    
    if ($error['code'] != 0) {
        log_message('error', 'UPDATE ASBUILT ERROR: ' . json_encode($error));
        return false;
    }

    return $affected;  // Return jumlah rows yang affected (bisa 0 jika nilai sama)
}



}