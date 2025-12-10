<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Bast2_model extends CI_Model
{
    public function getJoinedBastData()
    {
        $query = $this->db->query("
            SELECT 
                user_final_account.no_kontrak, 
                user_final_account.nama_pt, 
                user_final_account.pekerjaan, 
                user_asbuiltdrawing.tgl_terima AS tanggal_terima_asbuilt,
                user_asbuiltdrawing.status AS status_asbuilt,
                user_bast.keterangan AS keterangan_bast,
                user_bast.tgl_terima_bast,
                user_bast.opsi_retensi,
                user_bast.tgl_pusat,
                user_bast.tgl_kontraktor,
                user_bast.file_pdf,
                user_bast2.id_bast2,
                user_bast2.tgl_pom,
                user_bast2.kembali_pom,
                user_bast2.tgl_terima_bast2,
                user_bast2.tgl_pusat2,
                user_bast2.tgl_kontraktor2,
                user_bast2.file_pdf_bast2,
                user_bast2.keterangan2
            FROM 
                user_final_account
            INNER JOIN 
                user_asbuiltdrawing ON user_final_account.no_kontrak = user_asbuiltdrawing.no_kontrak
            INNER JOIN 
                user_bast ON user_asbuiltdrawing.id_asbuilt = user_bast.id_asbuilt
            LEFT JOIN 
                user_bast2 ON user_bast.id_bast = user_bast2.id_bast;
        ");

        return $query->result_array();
    }

    public function getIdData()
    {
        $this->db->select('no_kontrak');
        $query = $this->db->get('user_asbuiltdrawing');
        return $query->result_array();
    }

    public function getAllAsbuiltData()
    {
        $query = $this->db->query("
            SELECT * FROM user_asbuiltdrawing
        ");

        return $query->result_array();
    }

    public function getUserFinalAccounts()
    {
        $query = $this->db->query("
            SELECT * FROM user_final_account
        ");

        return $query->result_array();
    }

    public function addBast2Data($data)
    {
        $this->db->insert('user_bast2', $data);

        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function updateBast2Data($id_bast2, $data)
    {
        $this->db->where('id_bast2', $id_bast2);
        $this->db->update('user_bast2', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    var $table = 'bast2';
    var $column_order = array(null, 'id', 'no_kontrak', 'nama_pt', 'pekerjaan'); // Kolom yang bisa diurutkan
    var $column_search = array('id', 'no_kontrak', 'nama_pt', 'pekerjaan'); // Kolom yang bisa dicari
    var $order = array('id' => 'asc'); // Default order

    private function _get_datatables_query()
    {
        $this->db->from($this->table);
        $i = 0;
        foreach ($this->column_search as $item) {
            if ($_POST['search']['value']) {
                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if (count($this->column_search) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }
        if (isset($_POST['order'])) {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables()
    {
        $this->_get_datatables_query();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }
}
