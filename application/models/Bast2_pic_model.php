<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Bast2_pic_model extends CI_Model
{
    /**
     * Get semua PIC untuk satu BAST2
     */
    public function getPicByBast2Id($id_bast2)
    {
        $this->db->where('id_bast2', $id_bast2);
        $query = $this->db->get('user_bast2_pic');
        return $query->result_array();
    }

    /**
     * Get PIC untuk stage tertentu (POM, PUSAT, PM)
     */
    public function getPicByStage($id_bast2, $stage)
    {
        $this->db->where('id_bast2', $id_bast2);
        $this->db->where('stage', $stage);
        $query = $this->db->get('user_bast2_pic');
        $result = $query->row_array();
        return $result ? $result['pic_names'] : '';
    }

    /**
     * Save/update PIC untuk satu BAST2 (untuk 3 stage: POM, PUSAT, PM)
     */
    public function savePic($id_bast2, $pic_data, $user_name = 'Admin')
    {
        if (empty($id_bast2)) {
            return false;
        }

        // Hapus PIC lama
        $this->db->where('id_bast2', $id_bast2);
        $this->db->delete('user_bast2_pic');

        // Insert PIC baru untuk setiap stage
        $stages = ['POM', 'PUSAT', 'PM'];
        foreach ($stages as $stage) {
            $pic_names = isset($pic_data[$stage]) ? trim($pic_data[$stage]) : '';
            
            if (!empty($pic_names)) {
                $data = [
                    'id_bast2' => $id_bast2,
                    'stage' => $stage,
                    'pic_names' => $pic_names,
                    'created_by' => $user_name,
                    'updated_by' => $user_name,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];
                $this->db->insert('user_bast2_pic', $data);
            }
        }

        return true;
    }

    /**
     * Get all PIC data dalam format array by stage
     */
    public function getPicData($id_bast2)
    {
        $result = ['POM' => '', 'PUSAT' => '', 'PM' => ''];
        $pics = $this->getPicByBast2Id($id_bast2);
        foreach ($pics as $pic) {
            $result[$pic['stage']] = $pic['pic_names'];
        }
        return $result;
    }

    /**
     * Delete semua PIC untuk satu BAST2
     */
    public function deletePic($id_bast2)
    {
        $this->db->where('id_bast2', $id_bast2);
        return $this->db->delete('user_bast2_pic');
    }
}