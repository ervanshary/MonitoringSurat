<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

require_once APPPATH . '../vendor/autoload.php'; // Sesuaikan dengan struktur direktori proyek Anda

class Gudang extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('Gudang_model', 'gudang'); // Model sesuai nama tabel
        $this->load->library('session');
        $this->load->dbutil();
        $this->load->helper('file');
        $this->load->helper('download');
    }

    public function index()
    {
        $data['title'] = 'Data Gudang';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['items'] = $this->gudang->get_all_items(); // Mengambil semua data dari tabel 'gudang'

        // Tambahkan variabel reminder_dates (contoh data kosong atau data nyata dari database)
        $data['reminder_dates'] = []; // Atau ambil data yang sesuai dari model/database

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/barangmasuk', $data);
        $this->load->view('templates/footer');
    }

    public function add()
    {
        $data = [
            'jenis_barang' => $this->input->post('jenis_barang'),
            'nama_barang' => $this->input->post('nama_barang'),
            'lokasi' => $this->input->post('lokasi'),
            'jumlah' => $this->input->post('jumlah'),
            'satuan' => $this->input->post('satuan'),
            'tanggal_masuk' => $this->input->post('tanggal_masuk'),
            'pengirim' => $this->input->post('pengirim'),
            'perusahaan' => $this->input->post('perusahaan'),
            'penerima' => $this->input->post('penerima'),
            'keterangan' => $this->input->post('keterangan')
        ];

        $this->gudang->insert_item($data);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data berhasil ditambahkan!</div>');
        redirect('user/barangmasuk');
    }

    public function update()
    {
        $id = $this->input->post('id');

        // Konfigurasi untuk upload Foto (JPG/JPEG)
        $config_foto['upload_path'] = './assets/upload/foto/';
        $config_foto['allowed_types'] = 'jpg|jpeg';
        $config_foto['file_name'] = 'foto_' . time();
        $this->load->library('upload', $config_foto);

        $foto = $this->input->post('old_foto'); // Ambil foto lama jika tidak di-upload baru
        if (!empty($_FILES['foto']['name'])) {
            if ($this->upload->do_upload('foto')) {
                $foto = $this->upload->data('file_name');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Gagal mengupload foto: ' . $this->upload->display_errors() . '</div>');
                redirect('user/barangmasuk');
            }
        }

        // Konfigurasi untuk upload Tanda Terima (PDF)
        $config_pdf['upload_path'] = './assets/upload/tanda terima/';
        $config_pdf['allowed_types'] = 'pdf';
        $config_pdf['max_size']      = '2048';
        $config_pdf['file_name'] = 'tanda_terima_' . time();
        $this->upload->initialize($config_pdf);

        $tanda_terima = $this->input->post('old_tanda_terima'); // Ambil tanda terima lama jika tidak di-upload baru
        if (!empty($_FILES['tanda_terima']['name'])) {
            if ($this->upload->do_upload('tanda_terima')) {
                $tanda_terima = $this->upload->data('file_name');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Gagal mengupload tanda terima: ' . $this->upload->display_errors() . '</div>');
                redirect('user/barangmasuk');
            }
        }

        // Data untuk di-update ke database
        $data = [
            'jenis_barang' => $this->input->post('jenis_barang'),
            'nama_barang' => $this->input->post('nama_barang'),
            'lokasi' => $this->input->post('lokasi'),
            'jumlah' => $this->input->post('jumlah'),
            'satuan' => $this->input->post('satuan'),
            'tanggal_masuk' => $this->input->post('tanggal_masuk'),
            'pengirim' => $this->input->post('pengirim'),
            'perusahaan' => $this->input->post('perusahaan'),
            'penerima' => $this->input->post('penerima'),
            'keterangan' => $this->input->post('keterangan'),
            'foto' => $foto,
            'tanda_terima' => $tanda_terima,
        ];

        // Update data di database
        $this->gudang->update_item($id, $data);

        // Pesan sukses
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data berhasil diperbarui!</div>');
        redirect('user/barangmasuk');
    }


    public function export()
    {
        $items = $this->gudang->get_all_items();

        if (empty($items)) {
            echo 'No data found';
            exit;
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'Data Barang Gudang');
        $sheet->mergeCells('A1:K1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);

        $sheet->setCellValue('A2', 'ID');
        $sheet->setCellValue('B2', 'Jenis Barang');
        $sheet->setCellValue('C2', 'Nama Barang');
        $sheet->setCellValue('D2', 'Lokasi');
        $sheet->setCellValue('E2', 'Jumlah');
        $sheet->setCellValue('F2', 'Satuan');
        $sheet->setCellValue('G2', 'Tanggal Masuk');
        $sheet->setCellValue('H2', 'Pengirim');
        $sheet->setCellValue('I2', 'Penerima');
        $sheet->setCellValue('J2', 'Keterangan');

        $styleHeader = [
            'font' => ['bold' => true],
            'fill' => ['fillType' => PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'CCCCCC']],
            'borders' => ['outline' => ['borderStyle' => PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]],
            'alignment' => ['horizontal' => PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
        ];
        $sheet->getStyle('A2:J2')->applyFromArray($styleHeader);

        $row = 3;
        foreach ($items as $item) {
            $sheet->setCellValue('A' . $row, $item['id']);
            $sheet->setCellValue('B' . $row, $item['jenis_barang']);
            $sheet->setCellValue('C' . $row, $item['nama_barang']);
            $sheet->setCellValue('D' . $row, $item['lokasi']);
            $sheet->setCellValue('E' . $row, $item['jumlah']);
            $sheet->setCellValue('F' . $row, $item['satuan']);
            $sheet->setCellValue('G' . $row, $item['tanggal_masuk']);
            $sheet->setCellValue('H' . $row, $item['pengirim']);
            $sheet->setCellValue('I' . $row, $item['penerima']);
            $sheet->setCellValue('J' . $row, $item['keterangan']);
            $row++;
        }

        foreach (range('A', 'J') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Data_Barang_Gudang_' . date("Y-m-d_H-i-s") . '.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
        exit;
    }


    public function import()
    {
        // Load the PHPSpreadsheet library
        require 'vendor/autoload.php';

        if (!empty($_FILES['file']['name'])) {
            $file = $_FILES['file'];
            $extension = pathinfo($file['name'], PATHINFO_EXTENSION);

            if ($extension === 'xlsx' || $extension === 'xls') {
                try {
                    $file_tmp_name = $file['tmp_name'];
                    $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
                    $spreadsheet = $reader->load($file_tmp_name);

                    $sheet = $spreadsheet->getActiveSheet();
                    $highestRow = $sheet->getHighestRow();
                    $highestColumn = $sheet->getHighestColumn();

                    // Delete all data
                    $this->gudang->delete_all_items();

                    for ($row = 2; $row <= $highestRow; $row++) {
                        $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
                        $data = array(
                            'id' => $rowData[0][0],
                            'jenis_barang' => $rowData[0][1],
                            'nama_barang' => $rowData[0][2],
                            'lokasi' => $rowData[0][3],
                            'jumlah' => $rowData[0][4],
                            'satuan' => $rowData[0][5],
                            'tanggal_masuk' => $this->formatDate($rowData[0][6]),
                            'pengirim' => $rowData[0][7],
                            'penerima' => $rowData[0][8],
                            'keterangan' => $rowData[0][9]
                        );

                        $this->gudang->insert_item($data);
                    }




                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Import Data berhasil!</div>');
                } catch (\Exception $e) {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Import Data Gagal! ' . $e->getMessage() . '</div>');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Import Data Gagal! File harus berupa file Excel dengan ekstensi .xlsx atau .xls.</div>');
            }
            redirect('user/barangmasuk');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Import Data Gagal! Harap pilih file Excel yang akan diimpor.</div>');
            redirect('user/barangmasuk');
        }
    }

    // Fungsi untuk memformat tanggal
    public function formatDate($date)
    {
        if (is_null($date) || trim($date) === '') {
            return null; // Kembalikan NULL jika tanggal kosong
        }

        if ($date instanceof \PhpOffice\PhpSpreadsheet\RichText\RichText) {
            $date = $date->getPlainText(); // Ambil teks dari objek RichText
        }

        if (is_numeric($date)) {
            // Konversi dari format Excel (numeric) ke format PHP DateTime
            $date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($date);
            return $date->format('Y-m-d'); // Format YYYY-MM-DD
        } else {
            // Jika bukan angka, kembalikan null (atau format lain jika ada aturan tambahan)
            return null;
        }
    }

    public function pindahkan_barang()
    {
        $id = $this->input->post('id');
        $jumlah_keluar = $this->input->post('jumlah_keluar');

        // Ambil data barang masuk
        $barang = $this->db->get_where('user_barangmasuk', ['id' => $id])->row_array();
        if (!$barang) {
            $this->session->set_flashdata('error', 'Barang tidak ditemukan!');
            redirect('Gudang/barangmasuk');
            return;
        }

        // Pastikan stok cukup
        if ($barang['jumlah'] < $jumlah_keluar) {
            $this->session->set_flashdata('error', 'Stok tidak mencukupi!');
            redirect('Gudang/barangmasuk');
            return;
        }

        // Catat ke tabel user_barangkeluar
        $data_keluar = [
            'jenis_barang'   => $barang['jenis_barang'],
            'nama_barang'    => $barang['nama_barang'],
            'lokasi'         => $barang['lokasi'],
            'jumlah_awal'    => $jumlah_keluar, // kolomnya berbeda!
            'satuan'         => $barang['satuan'],
            'tanggal_keluar' => $this->input->post('tanggal_keluar'),
            'pengirim'       => $this->input->post('pengirim'),
            'penerima'       => $this->input->post('penerima'),
            'keterangan'     => $this->input->post('keterangan'),
            'foto'           => isset($barang['foto']) ? $barang['foto'] : null,
            'tanda_terima'   => isset($barang['tandaterima']) ? $barang['tandaterima'] : null,
            'created_at'     => date('Y-m-d H:i:s'),
            'updated_at'     => date('Y-m-d H:i:s')
        ];

        $this->db->insert('user_barangkeluar', $data_keluar);

        // Cek jika insert berhasil
        if ($this->db->affected_rows() <= 0) {
            $error = $this->db->error();
            $this->session->set_flashdata('error', 'Gagal menambah ke barang keluar: ' . $error['message']);
            redirect('Gudang/barangmasuk');
            return;
        }

        // Update stok di tabel barang masuk
        $this->db->set('jumlah', 'jumlah - ' . (int)$jumlah_keluar, FALSE);
        $this->db->where('id', $id);
        $this->db->update('user_barangmasuk');

        // Pesan sukses dan redirect
        $this->session->set_flashdata('message', 'Barang berhasil dipindahkan dan dicatat ke data keluar.');
        redirect('user/barangkeluar'); // langsung ke halaman keluar agar bisa dilihat hasilnya
    }
}
