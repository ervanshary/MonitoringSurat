<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kontrak extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Kontrak_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data['kontrak'] = $this->Kontrak_model->getAllKontrak();
        $this->load->view('proyek/milenial/kontrak', $data);
    }

    public function tambah()
    {
        $data = [
            'no_kontrak' => $this->input->post('no_kontrak', true),
            'nama_pt'    => $this->input->post('nama_pt', true),
            'pekerjaan'  => $this->input->post('pekerjaan', true),
            'status'     => $this->input->post('status', true),
            'is_active'  => '1',
            'updated_by' => $this->session->userdata('email') ?? 'System',
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $this->Kontrak_model->insertKontrak($data);
        echo json_encode(['status' => 'success']);
    }

    public function hapus($id)
    {
        $this->Kontrak_model->deleteKontrak($id);
        echo json_encode(['status' => 'deleted']);
    }
}
