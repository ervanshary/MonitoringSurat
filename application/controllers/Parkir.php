<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

require_once APPPATH . '../vendor/autoload.php'; // Sesuaikan dengan struktur direktori proyek Anda

class Parkir extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('Parkir_model', 'parkir');
        $this->load->model('Parkir_model');
        $this->load->library('session');
        $this->load->dbutil();
        $this->load->helper('file');
        $this->load->helper('download');
    }

    public function index()
    {
        $data['title'] = 'Parkir';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['parkirs'] = $this->parkir->get_all_parkir();
        $data['partials'] = $this->parkir->get_all_partials(); // Pastikan model dan tabelnya benar

        $data['current_date'] = date('Y-m-d');
        $data['reminder_dates'] = $this->get_reminder_dates($data['parkirs']) ?? [];
        $data['parkir_reminders'] = $this->Parkir_model->get_parkir_reminder();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/parkir', $data);
        $this->load->view('templates/footer');
    }

    private function get_reminder_dates($parkirs)
    {
        // Implementasikan logika untuk reminder dates jika diperlukan
    }

    public function add()
    {
        // Simpan data utama ke tabel parkir
        $data = [
            'perusahaan' => $this->input->post('perusahaan'),
            'nama_member' => $this->input->post('nama_member'),
            'no_kendaraan' => $this->input->post('no_kendaraan'),
            'no_kartu' => $this->input->post('no_kartu'),
            'jenis_kendaraan' => $this->input->post('jenis_kendaraan'),
            'tgl_pembuatan' => $this->input->post('tgl_pembuatan'),
            'tgl_berakhir' => $this->input->post('tgl_berakhir'),
            'keterangan' => $this->input->post('keterangan')
        ];

        // Insert data parkir and get the inserted ID
        $insert_id = $this->parkir->insertParkir($data);

        if ($insert_id) {
            // Proses upload file scan_dokumen_jpg
            if (!empty($_FILES['scan_dokumen_jpg']['name'][0])) {
                $this->load->library('upload');
                $files = $_FILES['scan_dokumen_jpg'];

                for ($i = 0; $i < count($files['name']); $i++) {
                    $_FILES['file']['name'] = $files['name'][$i];
                    $_FILES['file']['type'] = $files['type'][$i];
                    $_FILES['file']['tmp_name'] = $files['tmp_name'][$i];
                    $_FILES['file']['error'] = $files['error'][$i];
                    $_FILES['file']['size'] = $files['size'][$i];

                    // Set upload configuration
                    $config['upload_path'] = './assets/upload/parkir/';
                    $config['allowed_types'] = 'jpg|jpeg|png';
                    $config['max_size'] = 2048; // 2MB
                    $this->upload->initialize($config);

                    if ($this->upload->do_upload('file')) {
                        $uploaded_file = $this->upload->data('file_name');

                        // Simpan nama file ke tabel parkir_image
                        $image_data = [
                            'id_parkir' => $insert_id,
                            'scan_dokumen_jpg' => $uploaded_file
                        ];
                        $this->db->insert('parkir_image', $image_data);
                    } else {
                        echo $this->upload->display_errors();
                    }
                }
            }

            redirect('user/parkir');
        } else {
            echo "Failed to insert data.";
        }
    }


    public function update()
    {
        $id_parkir = $this->input->post('id_parkir');
        $status = $this->input->post('status');
        $data = array(
            'perusahaan' => $this->input->post('perusahaan'),
            'nama_member' => $this->input->post('nama_member'),
            'no_kendaraan' => $this->input->post('no_kendaraan'),
            'no_kartu' => $this->input->post('no_kartu'),
            'jenis_kendaraan' => $this->input->post('jenis_kendaraan'),
            'tgl_pembuatan' => $this->input->post('tgl_pembuatan'),
            'tgl_berakhir' => $this->input->post('tgl_berakhir'),
            'keterangan' => $this->input->post('keterangan'),
            'status' => $status ? '1' : '0' // Set status ke '1' jika dicentang, '0' jika tidak
        );

        if (!empty($_FILES['scan_dokumen']['name'])) {
            $config['upload_path']   = './assets/upload/parkir/';
            $config['allowed_types'] = 'pdf|jpg|jpeg|png';
            $config['max_size']      = 2048; // 2MB
            $this->load->library('upload', $config);

            if ($this->upload->do_upload('scan_dokumen')) {
                $uploaded_file = $this->upload->data('file_name');
                $data['scan_dokumen'] = $uploaded_file;
            } else {
                echo $this->upload->display_errors();
            }
        }

        if ($this->parkir->updateParkir($id_parkir, $data)) {
            redirect('user/parkir');
        } else {
            echo "Failed to update data.";
        }
    }

    public function import_parkir()
    {
        // Load the PHPSpreadsheet library
        require 'vendor/autoload.php';

        if (!empty($_FILES['file_parkir']['name'])) {
            $file = $_FILES['file_parkir'];
            $extension = pathinfo($file['name'], PATHINFO_EXTENSION);

            // Check file extension
            if ($extension == 'xlsx' || $extension == 'xls') {
                $file_tmp_name = $file['tmp_name'];

                // Load PHPSpreadsheet library
                $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
                $spreadsheet = $reader->load($file_tmp_name);

                // Get data from the first sheet
                $sheet = $spreadsheet->getActiveSheet();
                $highestRow = $sheet->getHighestRow();
                $highestColumn = $sheet->getHighestColumn();

                // Delete old data before saving new data
                $this->Parkir_model->delete_all();

                // Start from the second row (first row is usually header)
                for ($row = 2; $row <= $highestRow; $row++) {
                    // Get data from each column
                    $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);

                    // Save data to array
                    $data = array(
                        'perusahaan' => $rowData[0][0],
                        'nama_member' => $rowData[0][1],
                        'no_kendaraan' => $rowData[0][2],
                        'no_kartu' => $rowData[0][3],
                        'jenis_kendaraan' => $rowData[0][4],
                        'tgl_pembuatan' => $this->formatDate($rowData[0][5]),
                        'tgl_berakhir' => $this->formatDate($rowData[0][6]),
                        'keterangan' => $rowData[0][7],
                        'scan_dokumen' => $rowData[0][8], // Sesuaikan dengan kolom scan_dokumen
                    );


                    // Save data to database using model
                    $this->Parkir_model->save_parkir($data);
                }

                log_message('debug', 'Import parkir function called.');

                if (!empty($_FILES['file_parkir']['name'])) {
                    $file = $_FILES['file_parkir'];
                    log_message('debug', 'File uploaded: ' . $file['name']);
                    // ... rest of your code
                } else {
                    log_message('debug', 'No file uploaded.');
                }

                // Show success message or redirect to a specific page
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Import Data berhasil!</div>');
                redirect('user/parkir');
            } else {
                // Invalid file extension
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Import Data Gagal! File harus berupa file Excel dengan ekstensi .xlsx atau .xls.</div>');
                redirect('user/parkir');
            }
        } else {
            // No file uploaded
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Import Data Gagal! Harap pilih file Excel yang akan diimpor.</div>');
            redirect('user/parkir');
        }
    }

    // Tambahkan fungsi formatDate ke dalam kelas
    public function formatDate($date)
    {
        if (is_null($date) || trim($date) === '') {
            return null; // Atau string kosong jika diinginkan
        }

        if ($date instanceof \PhpOffice\PhpSpreadsheet\RichText\RichText) {
            $date = $date->getPlainText();
        }

        if (is_numeric($date)) {
            $date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($date);
            return $date->format('Y-m-d');
        } else {
            return null; // Atau kembalikan nilai default lainnya
        }
    }


    public function export_parkir()
    {
        $search = $this->input->get('search');
        $parkirs = !empty($search) ? $this->parkir->get_parkirs($search) : $this->parkir->get_parkirs();

        if (empty($parkirs)) {
            echo 'No data found';
            exit;
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'DATA USER PARKIR');
        $sheet->mergeCells('A1:I1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);

        $sheet->setCellValue('A2', 'Perusahaan');
        $sheet->setCellValue('B2', 'Nama Member');
        $sheet->setCellValue('C2', 'No Kendaraan');
        $sheet->setCellValue('D2', 'No Kartu');
        $sheet->setCellValue('E2', 'Jenis Kendaraan');
        $sheet->setCellValue('F2', 'Tgl Pembuatan');
        $sheet->setCellValue('G2', 'Tgl Berakhir');
        $sheet->setCellValue('H2', 'Keterangan');
        $sheet->setCellValue('I2', 'Scan Dokumen');

        $styleHeader = [
            'font' => ['bold' => true],
            'fill' => ['fillType' => PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'CCCCCC']],
            'borders' => ['outline' => ['borderStyle' => PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]],
            'alignment' => ['horizontal' => PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
        ];
        $sheet->getStyle('A2:I2')->applyFromArray($styleHeader);

        $row = 3;
        foreach ($parkirs as $parkir) {
            $sheet->setCellValue('A' . $row, $parkir['perusahaan']);
            $sheet->setCellValue('B' . $row, $parkir['nama_member']);
            $sheet->setCellValue('C' . $row, $parkir['no_kendaraan']);
            $sheet->setCellValue('D' . $row, $parkir['no_kartu']);
            $sheet->setCellValue('E' . $row, $parkir['jenis_kendaraan']);
            $sheet->setCellValue('F' . $row, $parkir['tgl_pembuatan']);
            $sheet->getStyle('F' . $row)->getNumberFormat()->setFormatCode('DD-MM-YYYY');
            $sheet->setCellValue('G' . $row, $parkir['tgl_berakhir']);
            $sheet->getStyle('G' . $row)->getNumberFormat()->setFormatCode('DD-MM-YYYY');
            $sheet->setCellValue('H' . $row, $parkir['keterangan']);
            $sheet->setCellValue('I' . $row, $parkir['scan_dokumen']);
            $row++;
        }

        foreach (range('A', 'I') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        ob_start();
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        $xlsData = ob_get_contents();
        ob_end_clean();

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Data_User_Parkir_' . date("Y-m-d_H-i-s") . '.xlsx"');
        header('Cache-Control: max-age=0');

        echo $xlsData;
        exit;
    }

    // PARKIR NON AKTIF/////

    // Fungsi untuk menampilkan data parkir non-aktif
    public function non_active()
    {
        $data['title'] = 'Parkir Non Active';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['non_active_parkir'] = $this->db->get('user_non_active')->result_array();
        $data['parkirs'] = $this->parkir->get_all_parkir();
        $data['partials'] = $this->parkir->get_all_partials(); // Pastikan model dan tabelnya benar

        $data['current_date'] = date('Y-m-d');
        $data['reminder_dates'] = $this->get_reminder_dates($data['parkirs']) ?? [];
        $data['parkir_reminders'] = $this->Parkir_model->get_parkir_reminder();

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/non_active', $data);
        $this->load->view('templates/footer');
    }

    public function move_to_non_active()
    {
        $id_parkir = $this->input->post('id_parkir');
        log_message('debug', 'Received ID: ' . $id_parkir); // Log ID

        if ($id_parkir) {
            $this->db->where('id_parkir', $id_parkir);
            $parkir_data = $this->db->get('user_parkir')->row_array();

            log_message('debug', 'Parkir Data: ' . print_r($parkir_data, true)); // Log data

            if ($parkir_data) {
                $this->db->insert('user_non_active', $parkir_data);

                if ($this->db->affected_rows() > 0) {
                    log_message('debug', 'Data inserted into user_non_active successfully.');
                } else {
                    log_message('debug', 'Failed to insert data into user_non_active.');
                }

                $this->db->where('id_parkir', $id_parkir);
                $this->db->delete('user_parkir');

                if ($this->db->affected_rows() > 0) {
                    log_message('debug', 'Data deleted from user_parkir successfully.');
                } else {
                    log_message('debug', 'Failed to delete data from user_parkir.');
                }

                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Data not found']);
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid ID']);
        }
    }
}
