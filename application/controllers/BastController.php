<?php
defined('BASEPATH') or exit('No direct script access allowed');

class BastController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Bast_model');
        $this->load->model('Bast2_model');
    }

    public function saveBast1()
    {
        $data = array(
            'no_kontrak' => $this->input->post('no_kontrak'),
            'nama_pt' => $this->input->post('nama_pt'),
            'pekerjaan' => $this->input->post('pekerjaan'),
            'tgl_terima_bast1' => $this->input->post('tgl_terima_bast1'),
            // tambahkan semua field lainnya sesuai form bast1.php
        );

        if ($this->Bast_model->addBastData($data)) {
            // Data berhasil disimpan
            redirect('some_success_page');
        } else {
            // Data gagal disimpan
            redirect('some_error_page');
        }
    }

    public function saveBast2()
    {
        $data = array(
            'id_bast' => $this->input->post('id_bast'),
            'tgl_pom' => $this->input->post('tgl_pom'),
            'tgl_terima_bast2' => $this->input->post('tgl_terima_bast2'),
            'tgl_pusat2' => $this->input->post('tgl_pusat2'),
            'tgl_kontraktor2' => $this->input->post('tgl_kontraktor2'),
            'keterangan' => $this->input->post('keterangan'),
            'file_pdf_bast2' => $this->input->post('file_pdf_bast2'),
            // tambahkan semua field lainnya sesuai form bast2.php
        );

        if ($this->Bast2_model->addBast2Data($data)) {
            // Data berhasil disimpan
            redirect('some_success_page');
        } else {
            // Data gagal disimpan
            redirect('some_error_page');
        }
    }
}
