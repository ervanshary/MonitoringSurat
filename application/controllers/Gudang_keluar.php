<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

require_once APPPATH . '../vendor/autoload.php'; // Sesuaikan dengan struktur direktori proyek Anda

class Gudang_keluar extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('Keluar_model', 'gudang'); // Model sesuai nama tabel
        $this->load->library('session');
        $this->load->dbutil();
        $this->load->helper('file');
        $this->load->helper('download');
    }

    public function index()
    {
        $data['title'] = 'Data keluar';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['items'] = $this->gudang->get_all_items(); // Mengambil semua data dari tabel 'gudang'

        // Tambahkan variabel reminder_dates (contoh data kosong atau data nyata dari database)
        $data['reminder_dates'] = []; // Atau ambil data yang sesuai dari model/database
        // Tambahkan variabel yang hilang
        $data['current_date'] = date('Y-m-d'); // Tanggal sekarang
        $data['partials'] = []; // Jika partials adalah array, pastikan didefinisikan

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/barangkeluar', $data);
        $this->load->view('templates/footer');
    }

    public function add()
    {
        $data = [
            'jenis_barang' => $this->input->post('jenis_barang'),
            'nama_barang' => $this->input->post('nama_barang'),
            'lokasi' => $this->input->post('lokasi'),
            'jumlah_awal' => $this->input->post('jumlah_awal'),
            'satuan' => $this->input->post('satuan'),
            'tanggal_masuk' => $this->input->post('tanggal_masuk'),
            'pengirim' => $this->input->post('pengirim'),
            'penerima' => $this->input->post('penerima'),
            'keterangan' => $this->input->post('keterangan')
        ];

        $this->gudang->insert_item($data);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data berhasil ditambahkan!</div>');
        redirect('user/barangkeluar');
    }

    public function update_keluar()
    {
        $id = $this->input->post('id');
        $this->load->library('upload');


        // Pastikan folder upload ada
        $foto_path = './assets/upload/foto/';
        $tanda_terima_path = './assets/upload/tanda_terima/';

        if (!is_dir($foto_path)) {
            mkdir($foto_path, 0755, true);
        }
        if (!is_dir($tanda_terima_path)) {
            mkdir($tanda_terima_path, 0755, true);
        }

        // Ambil data lama jika tidak ada upload baru
        $foto = $this->input->post('old_foto');
        $tanda_terima = $this->input->post('old_tanda_terima');

        // Konfigurasi Upload Foto
        if (!empty($_FILES['foto']['name'])) {
            $config_foto = [
                'upload_path'   => $foto_path,
                'allowed_types' => 'jpg|jpeg|png',
                'file_name'     => 'foto_' . time(),
                'max_size'      => 5120, // 5MB
            ];

            $this->upload->initialize($config_foto);
            if ($this->upload->do_upload('foto')) {
                $upload_data = $this->upload->data();
                $foto = $upload_data['file_name']; // Simpan nama file yang benar
            } else {
                echo "Gagal upload foto: " . $this->upload->display_errors(); // Debugging error
                exit();
            }
        }

        // Konfigurasi Upload Tanda Terima
        if (!empty($_FILES['tanda_terima']['name'])) {
            $config_pdf = [
                'upload_path'   => $tanda_terima_path,
                'allowed_types' => 'pdf',
                'file_name'     => 'tanda_terima_' . time(),
                'max_size'      => 10240, // 10MB
            ];

            $this->upload->initialize($config_pdf);
            if ($this->upload->do_upload('tanda_terima')) {
                $upload_data = $this->upload->data();
                $tanda_terima = $upload_data['file_name'];
            } else {
                echo "Gagal upload tanda terima: " . $this->upload->display_errors();
                exit();
            }
        }

        // Data untuk update ke database
        $data = [
            'jenis_barang'   => $this->input->post('jenis_barang'),
            'nama_barang'    => $this->input->post('nama_barang'),
            'lokasi'         => $this->input->post('lokasi'),
            'jumlah_awal'  => $this->input->post('jumlah_awal'),
            'satuan'         => $this->input->post('satuan'),
            'tanggal_keluar' => $this->input->post('tanggal_keluar'),
            'pengirim'       => $this->input->post('pengirim'),
            'penerima'       => $this->input->post('penerima'),
            'keterangan'     => $this->input->post('keterangan'),
            'foto'           => $foto,
            'tanda_terima'   => $tanda_terima,
        ];


        // Update ke database
        $this->gudang->update_item($id, $data);

        if (!$this->gudang) {
            die("Model Keluar_model gagal dimuat!"); // Jika model gagal dipanggil
        }

        // Pesan sukses
        $this->session->set_flashdata('message', '<div class="alert alert-success">Data berhasil diperbarui!</div>');
        redirect('user/barangkeluar');
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
        $sheet->setCellValue('E2', 'jumlah_awal');
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
            $sheet->setCellValue('E' . $row, $item['jumlah_awal']);
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
                            'jumlah_awal' => $rowData[0][4],
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
            redirect('user/barangkeluar');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Import Data Gagal! Harap pilih file Excel yang akan diimpor.</div>');
            redirect('user/barangkeluar');
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

    public function cetak_tanda_terima($id)
    {
        $this->load->library('pdf'); // gunakan library DomPDF jika belum
        $this->load->model('Gudang_model');

        $data['barang'] = $this->Gudang_model->getById($id);

        if (!$data['barang']) {
            show_404();
        }

        $html = $this->load->view('gudang_keluar/tanda_terima_pdf', $data, true);

        $this->pdf->loadHtml($html);
        $this->pdf->setPaper('A4', 'portrait');
        $this->pdf->render();
        $this->pdf->stream("tanda_terima_{$id}.pdf", array("Attachment" => false));
    }

    public function generate_pdf($id)
    {
        $this->load->library('pdf');

        // Ambil data item dari database berdasarkan ID
        $data['item'] = $this->db->get_where('tb_barang_keluar', ['id' => $id])->row_array();

        if (!$data['item']) {
            show_404(); // Jika data tidak ditemukan
        }

        // Load view sebagai HTML
        $html = $this->load->view('tanda_terima_pdf', $data, true);

        // Buat nama file
        $filename = 'tanda_terima_' . $id . '.pdf';

        // Load dompdf
        $this->pdf->loadHtml($html);
        $this->pdf->setPaper('A4', 'portrait');
        $this->pdf->render();
        $this->pdf->stream($filename, ['Attachment' => false]); // true jika mau langsung download
    }
}
