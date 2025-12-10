<?php
defined('BASEPATH') or exit('No direct script access allowed');

// application/models/AsBuiltDrawing_model.php

class AsBuiltDrawing_model extends CI_Model
{

    public function getAsBuiltData()
    {
        // Inner join antara user_final_account dan user_asbuiltdrawing
        $this->db->select('user_final_account.*, user_asbuiltdrawing.keterangan, user_asbuiltdrawing.tgl_terima');
        $this->db->from('user_final_account');
        $this->db->join('user_asbuiltdrawing', 'user_final_account.id = user_asbuiltdrawing.id');
        $query = $this->db->get();
        return $query->result_array();
    }


    public function check_duplicate_asbuilt($no_kontrak)
    {
        $this->db->from('user_asbuiltdrawing');
        $this->db->where('no_kontrak', $no_kontrak);
        $query = $this->db->get();
        return $query->num_rows() > 0;
    }
}
