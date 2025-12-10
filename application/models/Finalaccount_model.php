<?php
// Finalaccount_model.php

class Finalaccount_model extends CI_Model
{
    public function get_final_account_by_id($id)
    {
        return $this->db->get_where('user_final_account', array('id' => $id))->row_array();
    }
}
