<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kontrak_model extends CI_Model
{
    protected $table = 'tbl_kontrak_milenial'; // gunakan tabel yang ada

    public function get_all()
    {
        return $this->db->order_by('updated_at', 'DESC')->get($this->table)->result_array();
    }

    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, ['id' => $id])->row_array();
    }

    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function update($id, $data)
    {
        return $this->db->where('id', $id)->update($this->table, $data);
    }

    public function delete($id)
    {
        return $this->db->where('id', $id)->delete($this->table);
    }
}
