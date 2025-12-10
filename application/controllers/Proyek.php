<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Proyek extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Kontrak_model', 'kontrak');
        $this->load->library('session');
        $this->load->helper('url');
    }

    // halaman view (dipakai saat diakses langsung; AJAX load juga memanggil method ini dari route)
    public function milenial_kontrak()
    {
        $data['kontrak'] = $this->kontrak->get_all();
        $this->load->view('proyek/milenial/kontrak', $data);
    }

    // API: tambah
    public function tambah_kontrak()
    {
        $payload = [
            'no_kontrak' => $this->input->post('no_kontrak'),
            'nama_pt'    => $this->input->post('nama_pt'),
            'pekerjaan'  => $this->input->post('pekerjaan'),
            'status'     => $this->input->post('status'),
            'is_active'  => '1',
            'updated_by' => $this->session->userdata('email') ?? 'system',
            'updated_at' => date('Y-m-d H:i:s')
        ];
        $this->kontrak->insert($payload);
        echo json_encode(['status' => 'success']);
    }

    // API: ambil data satu (JSON)
    public function get_kontrak_data($id = null)
    {
        $row = $this->kontrak->get_by_id($id);
        if ($row) {
            echo json_encode(['status' => 'success', 'data' => $row]);
        } else {
            echo json_encode(['status' => 'error']);
        }
    }

    // API: update
    public function update_kontrak()
    {
        $id = $this->input->post('id');
        $payload = [
            'no_kontrak' => $this->input->post('no_kontrak'),
            'nama_pt'    => $this->input->post('nama_pt'),
            'pekerjaan'  => $this->input->post('pekerjaan'),
            'status'     => $this->input->post('status'),
            'updated_by' => $this->session->userdata('email') ?? 'system',
            'updated_at' => date('Y-m-d H:i:s')
        ];
        $this->kontrak->update($id, $payload);
        echo json_encode(['status' => 'success']);
    }

    // API: delete
    public function delete_kontrak($id = null)
    {
        $this->kontrak->delete($id);
        echo json_encode(['status' => 'deleted']);
    }
}
