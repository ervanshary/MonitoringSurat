<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Fa_model extends CI_Model
{
    private $table = 'user_final_account'; // Tambahkan nama tabel utama
    private $column_order = ['id', 'no_kontrak', 'nama_pt', 'pekerjaan', 'status', 'is_active'];
    private $column_search = ['no_kontrak', 'nama_pt', 'pekerjaan', 'status'];
    private $order = ['id' => 'DESC'];

    // ==========================
    // === FUNGSI UTAMA CRUD ====
    // ==========================

    public function getAll()
    {
        return $this->db->get($this->table)->result_array();
    }

    public function get_finalaccount_by_id($id)
    {
        return $this->db->get_where($this->table, ['id' => $id])->row_array();
    }

    public function save_final_account($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update_final_account($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }

    public function delete_final_account($id)
    {
        return $this->db->delete($this->table, ['id' => $id]);
    }

    public function delete_all()
    {
        $this->db->empty_table($this->table);
    }

    // ==========================
    // ==== DATATABLES LOGIC ====
    // ==========================

    private function _get_datatables_query()
    {
        $this->db->from($this->table);
        $i = 0;
        foreach ($this->column_search as $item) {
            if (!empty($_POST['search']['value'])) {
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
            $this->db->order_by(
                $this->column_order[$_POST['order']['0']['column']],
                $_POST['order']['0']['dir']
            );
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function get_datatables()
    {
        $this->_get_datatables_query();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function count_all()
    {
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // ==========================
    // ==== LAPORAN & STATS =====
    // ==========================

    public function get_kontrak_summary()
    {
        $this->db->select('nama_pt, COUNT(no_kontrak) AS total_kontrak');
        $this->db->from($this->table);
        $this->db->group_by('nama_pt');
        return $this->db->get()->result_array();
    }

    public function get_kontrak_stats()
    {
        $this->db->select('COUNT(DISTINCT no_kontrak) AS total_kontrak, COUNT(DISTINCT nama_pt) AS total_perusahaan');
        $this->db->from($this->table);
        return $this->db->get()->row_array();
    }

    public function get_summary_counts()
    {
        return [
            'total_bast1' => $this->db->count_all('user_bast'),
            'total_bast2' => $this->db->count_all('user_bast2'),
            'total_final_account' => $this->db->count_all('user_closing')
        ];
    }
}
