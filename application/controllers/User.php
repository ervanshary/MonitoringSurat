<?php
defined('BASEPATH') or exit('No direct script access allowed');
// Load Composer autoload


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

require_once APPPATH . '../vendor/autoload.php'; // Sesuaikan dengan struktur direktori proyek Anda


class User extends CI_Controller
{


    // fungsi helper
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('User_model');
        $this->load->model('Bast_model');
        $this->load->model('Bast2_model');
        $this->load->model('Closing_model');
        $this->load->model('Laporan_model');
        $this->load->model('Partial_model', 'partial');
        $this->load->model('Partial_model');
        $this->load->model('Fa_model');
        $this->load->model('Gudang_model'); // <--- ini yang penting
        $this->load->library('pdf'); // kalau belum ditambahkan juga
        $this->load->dbutil();
        $this->load->helper('file');
        $this->load->helper('download');
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
        header("Access-Control-Allow-Headers: Content-Type, Content-Length, Accept-Encoding");
    }

    public function index()

    {
        $data['title'] = 'My Profile';
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();
        $data['kontrak_summary'] = $this->Fa_model->get_kontrak_summary();
        $data['kontrak_stats'] = $this->Fa_model->get_kontrak_stats();
        $data['summary_counts'] = $this->Fa_model->get_summary_counts();

        // Get reminder dates
        $this->load->model('Partial_model');
        $reminder_dates = $this->Partial_model->get_reminder_dates();

        if (!$reminder_dates) {
            $reminder_dates = []; // Set to empty array if no data
        }

        $data['reminder_dates'] = $reminder_dates;
        $data['current_date'] = date('Y-m-d');


        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/index', $data);
        $this->load->view('templates/footer');
    }

    public function edit()

    {
        $data['title'] = 'Edit Profile';
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();

        $this->form_validation->set_rules('name', 'Full Name', 'required|trim');
        // Get reminder dates
        $this->load->model('Partial_model');
        $reminder_dates = $this->Partial_model->get_reminder_dates();

        if (!$reminder_dates) {
            $reminder_dates = []; // Set to empty array if no data
        }

        $data['reminder_dates'] = $reminder_dates;
        $data['current_date'] = date('Y-m-d');


        if ($this->form_validation->run() == false) {

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/edit', $data);
            $this->load->view('templates/footer');
        } else {
            $name = $this->input->post('name');
            $email = $this->input->post('email');


            //cek jika ada gambar yang akan di upload
            $upload_image = $_FILES['image']['name'];


            if ($upload_image) {
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size']      = '2048';
                $config['upload_path'] = './assets/img/profile/';

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('image')) {

                    $old_image = $data['user']['image'];
                    if ($old_image != 'default.jpg') {
                        unlink(FCPATH . 'assets/img/profile/' . $old_image);
                    }


                    $new_image = $this->upload->data('file_name');
                    $this->db->set('image', $new_image);
                } else {

                    echo $this->upload->display_errors();
                }
            }

            $this->db->set('name', $name);
            $this->db->where('email', $email);
            $this->db->update('user');

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Profile Berhasil di Update!
          </div>');
            redirect('user');
        }
    }

    public function changepassword()

    {
        $data['title'] = 'Change Password';
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();

        $this->form_validation->set_rules('current_password', 'Current Password', 'required|trim');
        $this->form_validation->set_rules('new_password1', 'New Password', 'required|trim|min_length[6]|matches[new_password2]');
        $this->form_validation->set_rules('new_password2', 'Confirm New Password', 'required|trim|min_length[6]|matches[new_password1]');

        // Get reminder dates
        $this->load->model('Partial_model');
        $reminder_dates = $this->Partial_model->get_reminder_dates();

        if (!$reminder_dates) {
            $reminder_dates = []; // Set to empty array if no data
        }

        $data['reminder_dates'] = $reminder_dates;
        $data['current_date'] = date('Y-m-d');


        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/changepassword', $data);
            $this->load->view('templates/footer');
        } else {

            $current_password = $this->input->post('current_password');
            $new_password = $this->input->post('new_password1');
            if (!password_verify($current_password, $data['user']['password'])) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
    Password Lama Salah!
    </div>');
                redirect('user/changepassword');
            } else {

                if ($current_password == $new_password) {

                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                    Password Baru Tidak Boleh Sama dengan Passwor Lama!
                    </div>');
                    redirect('user/changepassword');
                } else {
                    //password OK
                    $password_hash = password_hash($new_password, PASSWORD_DEFAULT);


                    $this->db->set('password', $password_hash);
                    $this->db->where('email', $this->session->userdata('email'));
                    $this->db->update('user');

                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                    Password Berhasil diubah!
                    </div>');
                    redirect('user/changepassword');
                }
            }
        }
    }

    /**
     * Helper function untuk memastikan kolom created_by ada di tabel user_final_account
     */
    private function ensure_created_by_column()
    {
        if (!$this->db->field_exists('created_by', 'user_final_account')) {
            $this->db->query("ALTER TABLE user_final_account ADD COLUMN created_by VARCHAR(100) NULL DEFAULT NULL AFTER id");
        }
    }

    public function finalaccount()
    {
        // Pastikan kolom created_by ada
        $this->ensure_created_by_column();

        $data['title'] = 'Kontrak';
        $data['user'] = $this->db->get_where('user', [
            'email' => $this->session->userdata('email')
        ])->row_array();

        $data['finalAccount'] = $this->db->get('user_final_account')->result_array();

        $this->form_validation->set_rules('no_kontrak', 'No Kontrak', 'required');
        $this->form_validation->set_rules('nama_pt', 'Nama PT', 'required');
        $this->form_validation->set_rules('pekerjaan', 'Pekerjaan', 'required');
        $this->form_validation->set_rules('status', 'Status', 'required');

        // Load reminder date model
        $this->load->model('Partial_model');
        $reminder_dates = $this->Partial_model->get_reminder_dates() ?? [];

        $data['reminder_dates'] = $reminder_dates;
        $data['current_date'] = date('Y-m-d');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/finalaccount', $data);
            $this->load->view('templates/footer');
        } else {
            // Cek apakah no_kontrak sudah ada
            $no_kontrak = $this->input->post('no_kontrak');
            $existing = $this->db->get_where('user_final_account', ['no_kontrak' => $no_kontrak])->row_array();

            if ($existing) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">
                Data dengan No Kontrak tersebut sudah ada!
            </div>');
                redirect('user/finalaccount');
            }

            // Data baru
            $insertData = [
                'no_kontrak' => $this->input->post('no_kontrak'),
                'nama_pt' => $this->input->post('nama_pt'),
                'pekerjaan' => $this->input->post('pekerjaan'),
                'status' => $this->input->post('status'),
                'is_active' => $this->input->post('is_active') ?? 1,
                'updated_by' => $data['user']['name'], // ambil nama user login
                'updated_at' => date('Y-m-d H:i:s')
            ];

            // Cek apakah kolom created_by ada di database
            $fields = $this->db->list_fields('user_final_account');
            if (in_array('created_by', $fields)) {
                $insertData['created_by'] = $data['user']['name'];
            }

            $this->db->insert('user_final_account', $insertData);

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Data Berhasil Ditambah!
        </div>');
            redirect('user/finalaccount');
        }
    }



    public function export()
    {
        // Load library PHPExcel
        require 'vendor/autoload.php';

        // Ambil data dari tabel user_final_account
        $data = $this->db->get('user_final_account')->result_array();

        // Buat objek Spreadsheet
        $spreadsheet = new PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Tambahkan tulisan di baris pertama
        $sheet->setCellValue('A1', 'MONITORING KONTRAK KERJA PROYEK TOKYO RIVERSIDE');
        $sheet->mergeCells('A1:D1'); // Merge cells dari A1 ke D1
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14); // Beri style pada tulisan

        // Isi header kolom pada spreadsheet
        $sheet->setCellValue('A2', 'No Kontrak');
        $sheet->setCellValue('B2', 'Nama PT');
        $sheet->setCellValue('C2', 'Pekerjaan');
        $sheet->setCellValue('D2', 'Status');

        // Beri style pada header kolom
        $styleHeader = [
            'font' => ['bold' => true],
            'fill' => ['fillType' => PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'CCCCCC']],
            'borders' => ['outline' => ['borderStyle' => PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]],
            'alignment' => ['horizontal' => PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
        ];
        $sheet->getStyle('A2:D2')->applyFromArray($styleHeader);

        // Isi data dari tabel user_final_account ke dalam spreadsheet
        $row = 3;
        foreach ($data as $row_data) {
            $sheet->setCellValue('A' . $row, $row_data['no_kontrak']);
            $sheet->setCellValue('B' . $row, $row_data['nama_pt']);
            $sheet->setCellValue('C' . $row, $row_data['pekerjaan']);
            $sheet->setCellValue('D' . $row, $row_data['status']);
            $row++;
        }

        // Beri style pada data
        $styleData = [
            'borders' => ['outline' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]],
        ];
        $lastRow = $row - 1;
        $sheet->getStyle('A3:D' . $lastRow)->applyFromArray($styleData);

        $sheet->getStyle('A2:D2')->getFont()->setBold(true);

        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ];

        $sheet->getStyle('A1:D' . $lastRow)->applyFromArray($styleArray);

        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);

        // Simpan dan Ekspor ke File Excel
        $file = "Final Account.xlsx";
        $writer = new PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save($file);

        // Set header dan kirim file ke browser
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $file . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }


    public function import()
    {
        // Load the PHPSpreadsheet library
        require 'vendor/autoload.php';
        $this->load->model('Fa_model');

        // Memeriksa apakah ada file yang diunggah
        if (!empty($_FILES['file_fa']['name'])) {
            $file = $_FILES['file_fa'];
            $extension = pathinfo($file['name'], PATHINFO_EXTENSION);

            // Memeriksa ekstensi file yang diunggah
            if ($extension == 'xlsx' || $extension == 'xls') {
                // Mendapatkan lokasi sementara file yang diunggah
                $file_tmp_name = $file['tmp_name'];

                // Load library PHPSpreadsheet
                $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
                $spreadsheet = $reader->load($file_tmp_name);

                // Mendapatkan data dari sheet pertama
                $sheet = $spreadsheet->getActiveSheet();
                $highestRow = $sheet->getHighestRow();
                $highestColumn = $sheet->getHighestColumn();

                // Hapus semua data lama sebelum menyimpan data baru
                $this->Fa_model->delete_all();

                // Mulai dari baris kedua (baris pertama biasanya header)
                for ($row = 2; $row <= $highestRow; $row++) {
                    // Mendapatkan data pada setiap kolom
                    $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);

                    // Menyimpan data ke dalam array
                    $data = array(
                        'no_kontrak' => $rowData[0][0],
                        'nama_pt' => $rowData[0][1],
                        'pekerjaan' => $rowData[0][2],
                        'status' => $rowData[0][3]
                    );

                    // Simpan data ke database menggunakan model
                    $this->Fa_model->save_final_account($data);
                }

                // Tampilkan pesan sukses atau lakukan redirect ke halaman tertentu
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Import Data berhasil!</div>');
                redirect('user/finalaccount');
            } else {
                // Ekstensi file tidak diizinkan
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Import Data Gagal! File harus berupa file Excel dengan ekstensi .xlsx atau .xls.</div>');
                redirect('user/finalaccount');
            }
        } else {
            // Tidak ada file yang diunggah
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Import Data Gagal! Harap pilih file Excel yang akan diimpor.</div>');
            redirect('user/finalaccount');
        }
    }


    public function get_finalaccount_data($id = null)
    {
        if (!$id) {
            echo json_encode(['status' => 'error', 'message' => 'ID tidak diberikan']);
            return;
        }

        $finalAccount = $this->db->get_where('user_final_account', ['id' => $id])->row_array();

        if ($finalAccount) {
            echo json_encode(['status' => 'success', 'data' => $finalAccount]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Data tidak ditemukan']);
        }
    }


    public function get_finalaccounts()
    {
        $list = $this->FinalAccountModel->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $finalAccount) {
            $no++;
            $row = array();
            $row[] = $finalAccount->id;
            $row[] = $finalAccount->no_kontrak;
            $row[] = $finalAccount->nama_pt;
            $row[] = $finalAccount->pekerjaan;
            $row[] = $finalAccount->status;
            $row[] = '<button class="editBtn btn btn-primary" data-id="' . $finalAccount->id . '">Edit</button>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->FinalAccountModel->count_all(),
            "recordsFiltered" => $this->FinalAccountModel->count_filtered(),
            "data" => $data,
        );
        // Output JSON
        echo json_encode($output);
    }


    public function finalaccount_update()
    {
        $id = $this->input->post('editId');

        $updateData = [
            'no_kontrak' => $this->input->post('no_kontrak'),
            'nama_pt' => $this->input->post('nama_pt'),
            'pekerjaan' => $this->input->post('pekerjaan'),
            'status' => $this->input->post('status'),
            'updated_by' => $this->session->userdata('name'),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $this->db->where('id', $id);
        $this->db->update('user_final_account', $updateData);

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
        Data berhasil diupdate!
    </div>');
        redirect('user/finalaccount');
    }


    public function finalaccount_delete()
    {
        // Ambil ID yang akan dihapus dari permintaan POST
        $id = $this->input->post('id');

        // Hapus data final account dari database berdasarkan ID
        $this->db->where('id', $id);
        $this->db->delete('user_final_account');

        // // Set pesan sukses
        // $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Data Berhasil dihapus!</div>');
        // redirect('user/finalaccount');
    }


    public function insert_finalaccount()
    {
        $no_kontrak = $this->input->post('no_kontrak');
        $nama_pt = $this->input->post('nama_pt');
        $pekerjaan = $this->input->post('pekerjaan');
        $id = $this->input->post('id');

        $data = [
            'no_kontrak' => $no_kontrak,
            'nama_pt' => $nama_pt,
            'pekerjaan' => $pekerjaan,
            'id' => $id
        ];


        $data['updated_by'] = $this->session->userdata('email');
        $data['updated_at'] = date('Y-m-d H:i:s');

        $this->db->insert('user_insert', $data);

        echo json_encode(['status' => 'success']);
    }

    // ////////////////Backup database////////////////////


    public function backup_database()
    {
        $prefs = array(
            'format' => 'zip',
            'filename' => 'my_db_backup.sql'
        );

        // Backup database
        $backup = $this->dbutil->backup($prefs);

        // Nama file backup
        $db_name = 'backup-on-' . date("Y-m-d-H-i-s") . '.zip';
        $save = FCPATH . './assets/backup/' . $db_name;  // Ganti path ini dengan path penyimpanan yang sesuai

        // Simpan file backup
        write_file($save, $backup);

        // Download file backup
        force_download($db_name, $backup);
    }


    // asbuiltdrawing

    // UserController.php

    // application/controllers/User.php

    public function asbuiltdrawing()
    {
        $data['title'] = 'Asbuild Drawing';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        // Dapatkan data final account
        $data['finalAccount'] = $this->User_model->getUserFinalAccounts();

        // Dapatkan data no kontrak
        $data['no_kontrak'] = $this->User_model->getNoKontrak();

        // Dapatkan data asbuilt yang digabungkan
        $data['asBuiltData'] = $this->User_model->getJoinedAsBuiltData();

        // Get reminder dates
        $this->load->model('Partial_model');
        $reminder_dates = $this->Partial_model->get_reminder_dates();

        if (!$reminder_dates) {
            $reminder_dates = []; // Set to empty array if no data
        }

        $data['reminder_dates'] = $reminder_dates;
        $data['current_date'] = date('Y-m-d');

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/asbuiltdrawing', $data);
        $this->load->view('templates/footer');
    }

    public function add_asbuilt_data()
    {
        // Ambil data dari form
        $no_kontrak = $this->input->post('no_kontrak');
        $tgl_terima = $this->input->post('tgl_terima');
        $status = $this->input->post('status');
        $keterangan = $this->input->post('keterangan');

        // Simpan data input di session flashdata
        $this->session->set_flashdata('no_kontrak', $no_kontrak);
        $this->session->set_flashdata('tgl_terima', $tgl_terima);
        $this->session->set_flashdata('status', $status);
        $this->session->set_flashdata('keterangan', $keterangan);

        // Panggil method check_duplicate_asbuilt dari AsBuiltDrawing_model untuk memeriksa duplikat
        $this->load->model('AsBuiltDrawing_model');
        if ($this->AsBuiltDrawing_model->check_duplicate_asbuilt($no_kontrak)) {
            // Set flashdata untuk menampilkan pesan kesalahan
            $this->session->set_flashdata('error', 'Data dengan no_kontrak yang sama sudah ada.');
            // Redirect kembali ke halaman tambah data
            redirect('user/asbuiltdrawing');
        } else {
            // Simpan data ke dalam array
            $data = array(
                'no_kontrak' => $no_kontrak,
                'tgl_terima' => $tgl_terima,
                'status' => $status,
                'keterangan' => $keterangan
            );

            // Panggil method addAsBuiltData dari User_model untuk menyimpan data
            $this->User_model->addAsBuiltData($no_kontrak, $data);

            // Set flashdata untuk menampilkan pesan sukses
            $this->session->set_flashdata('success', 'Data berhasil ditambahkan.');
            // Redirect kembali ke halaman utama
            redirect('user/asbuiltdrawing');
        }
    }

    /**
     * Update Asbuilt Data via AJAX
     */
    public function update_asbuilt_data()
    {
        header('Content-Type: application/json');
        $id_asbuilt = $this->input->post('id_asbuilt');
        $tgl_terima = $this->input->post('tgl_terima');
        $status = $this->input->post('status');
        $keterangan = $this->input->post('keterangan');

        if (empty($id_asbuilt)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'ID tidak valid'
            ]);
            return;
        }

        $data = [
            'tgl_terima' => $tgl_terima,
            'status' => $status,
            'keterangan' => $keterangan
        ];

        $this->db->where('id_asbuilt', $id_asbuilt);
        $updated = $this->db->update('user_asbuiltdrawing', $data);

        if ($updated) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Data berhasil diperbarui'
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Gagal memperbarui data'
            ]);
        }
    }

    public function update_asbuilt_drawing()
    {
        // Load library PHPExcel
        require 'vendor/autoload.php';

        // Ambil data dari tabel user_final_account dan tabel lainnya jika diperlukan
        $data_final_account = $this->db->get('user_final_account')->result_array();

        foreach ($data_final_account as $row_data) {
            $no_kontrak = $row_data['no_kontrak'];

            // Cek apakah data dengan no_kontrak yang sama sudah ada di tabel user_asbuilt_drawing
            $this->db->where('no_kontrak', $no_kontrak);
            $query = $this->db->get('user_asbuilt_drawing');

            if ($query->num_rows() > 0) {
                // Jika data dengan no_kontrak yang sama sudah ada, lakukan update

                $data['updated_by'] = $this->session->userdata('email'); // Atau ID user
                $data['updated_at'] = date('Y-m-d H:i:s');
                $this->db->where('no_kontrak', $no_kontrak);
                $this->db->update('user_asbuilt_drawing', [
                    'nama_pt' => $row_data['nama_pt'],
                    'pekerjaan' => $row_data['pekerjaan']
                    // Tambahkan field lain yang perlu di-update
                ]);
            } else {
                // Jika data dengan no_kontrak yang sama belum ada, lakukan insert
                $data['updated_by'] = $this->session->userdata('email');
                $data['updated_at'] = date('Y-m-d H:i:s');

                $this->db->insert('user_asbuilt_drawing', $row_data);
            }
        }

        echo "Data berhasil diperbarui";
    }

    // User.php (Controller)
    public function getKontrakByNamaPT()
    {
        header('Content-Type: application/json');
        $nama_pt = $this->input->post('nama_pt');
        $this->db->select('no_kontrak');
        $this->db->where('nama_pt', $nama_pt);
        $result = $this->db->get('user_final_account')->result_array();
        echo json_encode($result);
    }
    // User.php (Controller)
    public function getPekerjaanByNoKontrak()
    {
        header('Content-Type: application/json');
        $no_kontrak = $this->input->post('no_kontrak');
        $this->db->select('pekerjaan, status');
        $this->db->where('no_kontrak', $no_kontrak);
        $result = $this->db->get('user_final_account')->row_array();
        
        if ($result) {
            echo json_encode(['success' => true, 'data' => $result]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Data tidak ditemukan']);
        }
    }
    // User.php (Controller)
    public function getStatusByPekerjaan()
    {
        header('Content-Type: application/json');
        $pekerjaan = $this->input->post('pekerjaan');
        $this->db->select('status');
        $this->db->where('pekerjaan', $pekerjaan);
        $result = $this->db->get('user_final_account')->row_array();
        
        if ($result) {
            echo json_encode(['success' => true, 'data' => $result]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Data tidak ditemukan']);
        }
    }


    // controler BAST

    public function getBAST()
    {
        // Pastikan kolom created_by ada
        $this->ensure_created_by_column_bast();

        $data['title'] = 'BAST 1';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        // Dapatkan data asbuilt yang digabungkan
        $data['bastData'] = $this->Bast_model->getJoinedBastData();

        // Debug: cek data yang diterima dari model
        log_message('debug', 'Data BAST from model: ' . print_r($data['bastData'], true));

        $data['id_asbuilts'] = $this->Bast_model->getAllAsbuiltData();
        $data['no_kontrak'] = $this->Bast_model->getIdData();
        $data['user_insert_data'] = $this->Bast_model->get_user_insert_data();

        // Tambahkan data untuk modal edit
        $data['bast'] = !empty($data['bastData']) ? $data['bastData'][0] : array(); // Misal ambil data pertama


        // Get reminder dates
        $this->load->model('Partial_model');
        $reminder_dates = $this->Partial_model->get_reminder_dates();

        if (!$reminder_dates) {
            $reminder_dates = []; // Set to empty array if no data
        }

        $data['reminder_dates'] = $reminder_dates;
        $data['current_date'] = date('Y-m-d');

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/bast1', $data);
        $this->load->view('templates/footer');
    }


    public function get_id_asbuilt_by_no_kontrak()
    {
        $no_kontrak = $this->input->post('no_kontrak');
        $id_asbuilt = $this->Bast_model->getIdAsbuiltByNoKontrak($no_kontrak);
        echo json_encode($id_asbuilt);
    }

    public function add_bast_data()
    {
        log_message('debug', '=== add_bast_data method accessed ===');
        log_message('debug', 'Is AJAX: ' . ($this->input->is_ajax_request() ? 'YES' : 'NO'));
        log_message('debug', 'Post data: ' . print_r($this->input->post(), true));

        $is_ajax = $this->input->is_ajax_request();

        // Add form validation rules here if not already set in the constructor
        $this->form_validation->set_rules('no_kontrak', 'No Kontrak', 'required');
        $this->form_validation->set_rules('id_asbuilt', 'ID Asbuilt', 'required');
        $this->form_validation->set_rules('tgl_terima_bast', 'Tanggal Terima BAST', 'required');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'required');
        $this->form_validation->set_rules('opsi_retensi', 'Opsi Retensi', 'required');

        if ($this->form_validation->run() == FALSE) {
            $error = validation_errors();
            log_message('error', 'Form validation failed: ' . $error);
            
            if ($is_ajax) {
                echo json_encode(['status' => 'error', 'message' => $error]);
                return;
            }
            
            $this->session->set_flashdata('error', $error);
            redirect('user/getBAST');
            return;
        }

        log_message('debug', 'Form validation passed');

        // Prepare data for insertion
        $data = array(
            'no_kontrak' => $this->input->post('no_kontrak'),
            'id_asbuilt' => $this->input->post('id_asbuilt'),
            'tgl_terima_bast' => $this->input->post('tgl_terima_bast'),
            'keterangan' => $this->input->post('keterangan'),
            'opsi_retensi' => $this->input->post('opsi_retensi')
        );

        $data['tgl_pusat'] = !empty($this->input->post('tgl_pusat')) ? $this->input->post('tgl_pusat') : NULL;
        $data['tgl_kontraktor'] = !empty($this->input->post('tgl_kontraktor')) ? $this->input->post('tgl_kontraktor') : NULL;

        if (!empty($_FILES['file_pdf']['name'])) {
            $upload_result = $this->uploadFile();

            if (!$upload_result['success']) {
                log_message('error', 'File upload failed: ' . $upload_result['error']);
                
                if ($is_ajax) {
                    echo json_encode(['status' => 'error', 'message' => 'File upload failed: ' . $upload_result['error']]);
                    return;
                }
                
                $this->session->set_flashdata('error', 'File upload failed: ' . $upload_result['error']);
                redirect('user/getBAST');
                return;
            }

            $data['file_pdf'] = $upload_result['file_name'];
        }

        log_message('debug', 'Data to be inserted into user_bast: ' . print_r($data, true));

        // Add created_by if column exists
        if ($this->db->field_exists('created_by', 'user_bast')) {
            $user_info = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
            $data['created_by'] = $user_info['name'];
        }

        // Check if no_kontrak already exists
        $existing = $this->db->where('no_kontrak', $data['no_kontrak'])->get('user_bast')->row();
        if ($existing) {
            $error_msg = 'Data dengan No Kontrak "' . $data['no_kontrak'] . '" sudah ada di database!';
            log_message('error', 'Duplicate no_kontrak: ' . $error_msg);
            if ($is_ajax) {
                echo json_encode(['status' => 'error', 'message' => $error_msg]);
                return;
            }
            $this->session->set_flashdata('error', $error_msg);
            redirect('user/getBAST');
            return;
        }

        // Insert data into user_bast table
        if ($this->Bast_model->addBastData($data)) {
            $id_bast = $this->db->insert_id();
            $bast2_data = [
                'id_bast' => $id_bast,
                'no_kontrak' => $this->input->post('no_kontrak')
            ];

            log_message('debug', 'Data to be inserted into user_bast2: ' . print_r($bast2_data, true));

            // Try to insert into bast2 but don't fail if it fails (optional)
            if (!$this->Bast_model->addBast2Data($bast2_data)) {
                log_message('error', 'Failed to insert data into user_bast2: ' . $this->db->last_query());
            } else {
                log_message('debug', 'Data successfully inserted into user_bast2');
            }

            // Try to insert into user_closing but don't fail if it fails (optional)
            $closing_data = [
                'no_kontrak' => $data['no_kontrak'],
                'nama_pt' => $this->input->post('nama_pt'),
                'pekerjaan' => $this->input->post('pekerjaan'),
                'tgl_terima_bast' => $data['tgl_terima_bast'],
                'file_pdf' => isset($data['file_pdf']) ? $data['file_pdf'] : '-'
            ];

            if (!$this->Closing_model->addClosingData($closing_data)) {
                log_message('error', 'Failed to insert data into user_closing');
            } else {
                log_message('debug', 'Data successfully inserted into user_closing');
            }

            // Main success response - data sudah tersimpan ke user_bast
            if ($is_ajax) {
                echo json_encode(['status' => 'success', 'message' => 'Data berhasil disimpan ke user_bast']);
                return;
            }
            $this->session->set_flashdata('message', 'Data berhasil disimpan.');
            redirect('user/getBAST');
        } else {
            log_message('error', 'Failed to insert data into user_bast: ' . $this->db->last_query());
            if ($is_ajax) {
                echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan data ke user_bast']);
                return;
            }
            $this->session->set_flashdata('error', 'Gagal menyimpan data ke user_bast.');
            redirect('user/getBAST');
        }
    }

    private function uploadFile()
    {
        $config['upload_path'] = './assets/upload/bast1';
        $config['allowed_types'] = 'pdf';
        $config['max_size'] = 50048; // 50MB

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('file_pdf')) {
            return array('success' => true, 'file_name' => $this->upload->data('file_name'));
        } else {
            return array('success' => false, 'error' => $this->upload->display_errors());
        }
    }




    public function export_bast()
    {
        // Load library PHPExcel
        require 'vendor/autoload.php';

        // Ambil data dari tabel user_bast
        $data_bast = $this->db->get('user_bast')->result_array();
        // Ambil data dari tabel user_final_account
        $data_final_account = $this->db->get('user_final_account')->result_array();

        // Buat array untuk menampung data yang digabungkan
        $merged_data = [];

        // Gabungkan data berdasarkan 'no_kontrak'
        foreach ($data_bast as $bast) {
            $no_kontrak = $bast['no_kontrak'];
            $merged_data[$no_kontrak] = [
                'no_kontrak' => $no_kontrak,
                'nama_pt' => '',
                'pekerjaan' => '',
                'keterangan' => $bast['keterangan'],
                'tgl_terima_bast' => $bast['tgl_terima_bast'],
                'tgl_pusat' => $bast['tgl_pusat'],
                'tgl_kontraktor' => $bast['tgl_kontraktor'],
            ];
        }

        // Tambahkan data dari user_final_account ke array yang sudah digabungkan
        foreach ($data_final_account as $final) {
            $no_kontrak = $final['no_kontrak'];
            if (isset($merged_data[$no_kontrak])) {
                $merged_data[$no_kontrak]['nama_pt'] = $final['nama_pt'];
                $merged_data[$no_kontrak]['pekerjaan'] = $final['pekerjaan'];
            } else {
                $merged_data[$no_kontrak] = [
                    'no_kontrak' => $no_kontrak,
                    'nama_pt' => $final['nama_pt'],
                    'pekerjaan' => $final['pekerjaan'],
                    'keterangan' => '',
                    'tgl_terima_bast' => '',
                    'tgl_pusat' => '',
                    'tgl_kontraktor' => '',
                ];
            }
        }

        // Buat objek Spreadsheet
        $spreadsheet = new PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Tambahkan tulisan di baris pertama
        $sheet->setCellValue('A1', 'MONITORING BAST PROYEK TOKYO RIVERSIDE');
        $sheet->mergeCells('A1:H1'); // Merge cells dari A1 ke H1
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14); // Beri style pada tulisan

        // Isi header kolom pada spreadsheet
        $sheet->setCellValue('A2', 'No Kontrak');
        $sheet->setCellValue('B2', 'Nama PT');
        $sheet->setCellValue('C2', 'Pekerjaan');
        $sheet->setCellValue('D2', 'Keterangan');
        $sheet->setCellValue('E2', 'Tgl Terima BAST');
        $sheet->setCellValue('F2', 'Tgl Pusat');
        $sheet->setCellValue('G2', 'Tgl Kontraktor');

        // Beri style pada header kolom
        $styleHeader = [
            'font' => ['bold' => true],
            'fill' => ['fillType' => PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'CCCCCC']],
            'borders' => ['outline' => ['borderStyle' => PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]],
            'alignment' => ['horizontal' => PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
        ];
        $sheet->getStyle('A2:G2')->applyFromArray($styleHeader);

        // Isi data yang digabungkan ke dalam spreadsheet
        $row = 3;
        foreach ($merged_data as $row_data) {
            // Helper function to format date from YYYY-MM-DD to DD-MM-YYYY
            $formatDate = function ($date_value) {
                if (empty($date_value) || $date_value == '0000-00-00') {
                    return '';
                }
                $date = new DateTime($date_value);
                return $date->format('d-m-Y');
            };

            $sheet->setCellValue('A' . $row, $row_data['no_kontrak']);
            $sheet->setCellValue('B' . $row, $row_data['nama_pt']);
            $sheet->setCellValue('C' . $row, $row_data['pekerjaan']);
            $sheet->setCellValue('D' . $row, $row_data['keterangan']);
            $sheet->setCellValue('E' . $row, $formatDate($row_data['tgl_terima_bast']));
            $sheet->setCellValue('F' . $row, $formatDate($row_data['tgl_pusat']));
            $sheet->setCellValue('G' . $row, $formatDate($row_data['tgl_kontraktor']));
            $row++;
        }

        // Beri style pada data
        $styleData = [
            'borders' => ['outline' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]],
        ];
        $lastRow = $row - 1;
        $sheet->getStyle('A3:G' . $lastRow)->applyFromArray($styleData);

        $sheet->getStyle('A2:G2')->getFont()->setBold(true);

        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ];

        $sheet->getStyle('A1:G' . $lastRow)->applyFromArray($styleArray);

        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        $sheet->getColumnDimension('G')->setAutoSize(true);

        // Bersihkan output buffer
        if (ob_get_contents()) {
            ob_end_clean();
        }

        // Simpan dan Ekspor ke File Excel
        $file = "MONITORING_BAST.xlsx";
        $writer = new PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

        // Set header dan kirim file ke browser
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $file . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
        exit;
    }


    public function get_bast_detail()
    {
        $id = $this->input->post('id');
        $data = $this->Bast_model->get_data_by_id($id);
        $data['bastData'] = $this->Bast_model->getBastData(); // Ambil data dari model Anda
        $this->load->view('user/bast1', $data);

        echo json_encode($data);
    }


    public function displayBast1()
    {
        $data['title'] = 'BAST 1';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        // Ambil data BAST dari model
        $bastData = $this->Bast_model->get_all_bast_data();

        if ($bastData === false) {
            $this->session->set_flashdata('error', 'Gagal mengambil data. Silakan coba lagi.');
            redirect('user/some_error_page');
        }

        // Debug output
        log_message('debug', 'Data BAST: ' . print_r($bastData, true));

        // Kirim data ke view
        $data['bastData'] = $bastData;

        // Load view
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/bast1', $data); // Buat view untuk edit BAST 1
        $this->load->view('templates/footer');
    }
    public function some_error_page()
    {
        redirect('user/displayBast1');
    }

    ////////////////////////EDIT/////////////////////////////

    public function updatebast1()
    {
        log_message('debug', 'updatebast1 method accessed');
        log_message('debug', 'Post data: ' . print_r($this->input->post(), true));

        $this->form_validation->set_rules('id_bast', 'ID BAST', 'required');
        $this->form_validation->set_rules('id_asbuilt', 'ID Asbuilt', 'required');
        $this->form_validation->set_rules('tgl_terima_asbuilt', 'Tanggal Terima Asbuilt');
        $this->form_validation->set_rules('tgl_terima_bast', 'Tanggal Terima BAST', 'required');
        
        // Optional fields - tidak perlu required saat edit
        // $this->form_validation->set_rules('no_kontrak', 'No Kontrak', 'required');
        // $this->form_validation->set_rules('nama_pt', 'Nama PT', 'required');
        // $this->form_validation->set_rules('pekerjaan', 'Pekerjaan', 'required');
        // $this->form_validation->set_rules('status_asbuilt', 'Status Asbuilt', 'required');
        // $this->form_validation->set_rules('keterangan', 'Keterangan', 'required');
        // $this->form_validation->set_rules('opsi_retensi', 'Opsi Retensi', 'required');

        if ($this->form_validation->run() == FALSE) {
            log_message('error', 'Form validation failed: ' . validation_errors());
            $this->session->set_flashdata('error', validation_errors());
            redirect('user/getBAST');
            return;
        }

        log_message('debug', 'Form validation passed');

        $bast_data = array(
            'tgl_terima_bast' => $this->input->post('tgl_terima_bast'),
            'tgl_pusat' => !empty($this->input->post('tgl_pusat')) ? $this->input->post('tgl_pusat') : NULL,
            'tgl_kontraktor' => !empty($this->input->post('tgl_kontraktor')) ? $this->input->post('tgl_kontraktor') : NULL,
            'keterangan' => $this->input->post('keterangan'),
            'opsi_retensi' => $this->input->post('opsi_retensi')
        );

        $asbuilt_data = [
    'tgl_terima' => $this->input->post('tgl_terima_asbuilt'), // Map dari form ke kolom database
    'status'     => $this->input->post('status_asbuilt'),     // Kolom yang ada di user_asbuiltdrawing
];



        if (!empty($_FILES['file_pdf']['name'])) {
            $upload_result = $this->uploadFile();

            if (!$upload_result['success']) {
                log_message('error', 'File upload failed: ' . $upload_result['error']);
                $this->session->set_flashdata('error', 'File upload failed: ' . $upload_result['error']);
                redirect('user/getBAST');
                return;
            }

            $bast_data['file_pdf'] = $upload_result['file_name'];
        }

        log_message('debug', 'Data to be updated in user_bast: ' . print_r($bast_data, true));
        log_message('debug', 'Data to be updated in user_asbuiltdrawing: ' . print_r($asbuilt_data, true));

        // Add updated_by if column exists
        if ($this->db->field_exists('updated_by', 'user_bast')) {
            $user_info = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
            $bast_data['updated_by'] = $user_info['name'];
        }

        $id_bast = $this->input->post('id_bast');
        $id_asbuilt = $this->input->post('id_asbuilt');

if (empty($id_bast) || empty($id_asbuilt)) {
    log_message('error', 'ID kosong: id_bast / id_asbuilt');
    $this->session->set_flashdata('error', 'ID data tidak valid');
    redirect('user/getBAST');
    return;
}


        $bast_update_success = $this->Bast_model->updateBastData($id_bast, $bast_data);
        $asbuilt_update_success = $this->Bast_model->updateAsbuiltData($id_asbuilt, $asbuilt_data);

        log_message('debug', 'BAST Update Success: ' . $bast_update_success);
        log_message('debug', 'Asbuilt Update Success: ' . $asbuilt_update_success);
        log_message('debug', 'ID BAST: ' . $id_bast);

        if ($bast_update_success && $asbuilt_update_success) {
            $this->session->set_flashdata('message', 'Data berhasil diperbarui.');
        } else {
            if (!$bast_update_success) {
                log_message('error', 'Failed to update data in user_bast: ' . $this->db->last_query());
            }
        }

        redirect('user/getBAST');
    }

    // Method untuk upload file
    private function uploadFile1()
    {
        // Konfigurasi upload
        $config['upload_path'] = './assets/upload/';
        $config['allowed_types'] = 'pdf';
        $config['max_size'] = 2048; // 2MB

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('file_pdf')) {
            return array('success' => FALSE, 'error' => $this->upload->display_errors());
        } else {
            return array('success' => TRUE, 'file_name' => $this->upload->data('file_name'));
        }
    }


    ////////////////////INSERT BAST1//////////////////////////////////////
    // Metode untuk menampilkan halaman dengan modal form
    public function add_insert_data()
    {
        // Mengambil data dari model
        $data['user_insert_data'] = $this->Bast_model->get_user_insert_data();

        // Load view dan kirim data
        $this->load->view('templates/header');
        $this->load->view('templates/sidebar');
        $this->load->view('templates/topbar');
        $this->load->view('user/bast1', $data); // Mengirim data ke view 'bast1'
        $this->load->view('templates/footer');
    }

    // Metode untuk insert data ke database
    public function insert_data()
    {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('no_kontrak', 'No Kontrak', 'required');
        $this->form_validation->set_rules('tgl_terima_bast', 'Tanggal Terima BAST', 'required');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('user/getBAST');
        } else {
            $data = array(
                'no_kontrak' => $this->input->post('no_kontrak'),
                'tgl_terima_bast' => $this->input->post('tgl_terima_bast'),
                'keterangan' => $this->input->post('keterangan'),
                'opsi_retensi' => $this->input->post('opsi_retensi'),
                'tgl_pusat' => $this->input->post('tgl_pusat'),
                'tgl_kontraktor' => $this->input->post('tgl_kontraktor')
            );

            log_message('debug', 'Data to be inserted: ' . print_r($data, true));

            $this->load->model('Bast_model');
            $result = $this->Bast_model->insert_data($data);

            if ($result) {
                log_message('debug', 'Data successfully inserted.');
                $this->session->set_flashdata('message', 'Data berhasil disimpan.');
            } else {
                log_message('error', 'Data insertion failed.');
                $this->session->set_flashdata('error', 'Gagal menyimpan data.');
            }
            redirect('user/getBAST');
        }
    }

    /**
     * Helper function untuk memastikan kolom created_by ada di tabel user_bast
     */
    private function ensure_created_by_column_bast()
    {
        if (!$this->db->field_exists('created_by', 'user_bast')) {
            $this->db->query("ALTER TABLE user_bast ADD COLUMN created_by VARCHAR(100) NULL DEFAULT NULL AFTER id_bast");
        }
    }

    /**
     * Helper function untuk memastikan kolom created_by ada di tabel user_bast2
     */
    private function ensure_created_by_column_bast2()
    {
        if (!$this->db->field_exists('created_by', 'user_bast2')) {
            $this->db->query("ALTER TABLE user_bast2 ADD COLUMN created_by VARCHAR(100) NULL DEFAULT NULL AFTER id_bast2");
        }
    }

    // CONTROLLER BAST 2

    public function getBAST2()
    {
        // Pastikan kolom created_by ada
        $this->ensure_created_by_column_bast2();

        $data['title'] = 'BAST 2';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data['bastData'] = $this->Bast2_model->getJoinedBastData();
        $data['id_asbuilts'] = $this->Bast2_model->getAllAsbuiltData();
        $data['no_kontrak'] = $this->Bast2_model->getIdData();


        // Get reminder dates
        $this->load->model('Partial_model');
        $reminder_dates = $this->Partial_model->get_reminder_dates();

        if (!$reminder_dates) {
            $reminder_dates = []; // Set to empty array if no data
        }

        $data['reminder_dates'] = $reminder_dates;
        $data['current_date'] = date('Y-m-d');
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/bast2', $data);
        $this->load->view('templates/footer');
    }

    public function addBAST2()
    {
        $user = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $data = array(
            'id_bast' => $this->input->post('id_bast'),
            'tgl_pom' => $this->input->post('tgl_pom'),
            'keterangan' => $this->input->post('keterangan'),
            'tgl_terima_bast2' => $this->input->post('tgl_terima_bast2'),
            'tgl_pusat2' => $this->input->post('tgl_pusat2'),
            'tgl_kontraktor2' => $this->input->post('tgl_kontraktor2')
        );

        // Cek apakah kolom created_by ada di database
        $fields = $this->db->list_fields('user_bast2');
        if (in_array('created_by', $fields)) {
            $data['created_by'] = $user['name'];
        }

        if ($this->Bast2_model->addBast2Data($data)) {
            redirect('User/getBAST2');
        } else {
            $this->session->set_flashdata('error', 'Gagal menyimpan data.');
            redirect('User/getBAST2');
        }
    }

    public function update_bast2_data()
    {
        $id_bast2 = $this->input->post('id_bast2');

        $data = array(
            'tgl_terima_bast2' => $this->input->post('tgl_terima_bast2'),
            'tgl_pom' => $this->input->post('tgl_pom'),
            'kembali_pom' => $this->input->post('kembali_pom'),
            'tgl_pusat2' => $this->input->post('tgl_pusat2'),
            'tgl_kontraktor2' => $this->input->post('tgl_kontraktor2'),
            'keterangan2' => $this->input->post('keterangan2')
        );

        // Periksa apakah file dipilih untuk diunggah
        if (!empty($_FILES['file_pdf_bast2']['name'])) {
            $uploadResult = $this->uploadFile2();
            if ($uploadResult['success']) {
                $data['file_pdf_bast2'] = $uploadResult['file_name'];
            } else {
                $this->session->set_flashdata('error', $uploadResult['error']);
                redirect('User/getBAST2');
                return;
            }
        }

        log_message('debug', 'ID BAST2: ' . $id_bast2);
        log_message('debug', 'Data to update: ' . print_r($data, true));

        if ($this->Bast2_model->updateBast2Data($id_bast2, $data)) {
            log_message('debug', 'Update successful for ID BAST2: ' . $id_bast2);
            $this->session->set_flashdata('message', 'Data berhasil diupdate!');
            redirect('User/getBAST2');
        } else {
            log_message('error', 'Update failed for ID BAST2: ' . $id_bast2);
            $this->session->set_flashdata('error', 'Gagal mengupdate data.');
            redirect('User/getBAST2');
        }
    }




    public function get_bast2_data()
    {
        $id = $this->input->post('id_bast2');
        $bast2 = $this->Bast2_model->get_bast2_by_id($id);
        echo json_encode($bast2);
    }

    public function get_bast2()
    {
        $list = $this->Bast2_model->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $bast2) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $bast2->id;
            $row[] = $bast2->no_kontrak;
            $row[] = $bast2->nama_pt;
            $row[] = $bast2->pekerjaan;
            $row[] = '<button class="edit-btn btn btn-primary" data-id_bast2="' . $bast2->id . '">Edit</button>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Bast2_model->count_all(),
            "recordsFiltered" => $this->Bast2_model->count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
    }

    private function uploadFile2()
    {
        $config['upload_path'] = './assets/upload/bast2';
        $config['allowed_types'] = 'pdf';
        $config['max_size'] = 50048; // 50MB

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('file_pdf_bast2')) {
            return array('success' => true, 'file_name' => $this->upload->data('file_name'));
        } else {
            log_message('error', $this->upload->display_errors());
            return array('success' => false, 'error' => $this->upload->display_errors());
        }
    }

    //////////////////////////////////////
    // MENU CLOSING STATMENT/FINALACCOUNT///
    ///////////////////////////////////////

    // Menampilkan halaman closing
    public function closing()
    {
        $data['title'] = 'Final Account';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        // Sinkronisasi data dari user_finalaccount dan user_bast ke user_closing
        $this->Closing_model->syncClosingData();

        // Ambil semua data dari user_closing
        $data['closing'] = $this->Closing_model->get_all_closing();
        $data['partials'] = $this->Closing_model->get_all_partials(); // Pastikan model dan tabelnya benar

        // Get reminder dates
        $reminder_dates = $this->Partial_model->get_reminder_dates();
        $data['reminder_dates'] = $reminder_dates ?: [];
        $data['current_date'] = date('Y-m-d');

        // Load view dengan data yang sudah disinkronisasi
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/closing', $data);
        $this->load->view('templates/footer');
    }


    // Mendapatkan data closing berdasarkan ID
    public function get_closing_data()
    {
        $id = $this->input->post('id');
        $data = $this->db->get_where('user_closing', ['id_closing' => $id])->row_array();
        echo json_encode($data);
    }

    // Menghapus data closing
    public function closing_delete()
    {
        $id = $this->input->post('id');
        if ($this->Closing_model->delete_closing($id)) {
            echo json_encode(['status' => 'success']);
        } else {
            echo json_encode(['status' => 'error']);
        }
    }

    // Menyimpan data closing
    public function closing_statment()
    {
        $data = json_decode(file_get_contents('php://input'), true);

        $closing_data = [
            'no_kontrak' => $data['no_kontrak'],
            'nama_pt' => $data['nama_pt'],
            'pekerjaan' => $data['pekerjaan'],
            'tgl_terima_bast' => $data['tgl_terima_bast'],
            'file_pdf' => $data['file_pdf'],
            'tgl_closing' => $data['tgl_closing'],
            'scan_fa' => $data['scan_fa'],
            'keterangan_fa' => $data['keterangan_fa'],
            'is_active' => 1 // Default active
        ];

        if ($this->Closing_model->save_closing_data($closing_data)) {
            echo json_encode(['status' => 'success', 'message' => 'Data berhasil disimpan.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Data gagal disimpan.']);
        }
    }

    // Mengupdate data closing
    public function closing_update()
    {
        $id_closing = $this->input->post('id_closing');
        $data = [
            'no_kontrak' => $this->input->post('no_kontrak'),
            'nama_pt' => $this->input->post('nama_pt'),
            'pekerjaan' => $this->input->post('pekerjaan'),
            'tgl_terima_bast' => $this->input->post('tgl_terima_bast'),
            'tgl_closing' => $this->input->post('tgl_closing'),
            'keterangan_fa' => $this->input->post('keterangan_fa')
        ];

        if (!empty($_FILES['ScanFA']['name'])) {
            $config['upload_path'] = './assets/upload/';
            $config['allowed_types'] = 'pdf';
            $config['max_size'] = 2048;
            $this->load->library('upload', $config);

            if ($this->upload->do_upload('ScanFA')) {
                $data['scan_fa'] = $this->upload->data('file_name');
            } else {
                echo $this->upload->display_errors();
                return;
            }
        }

        if ($this->Closing_model->update_closing($id_closing, $data)) {
            $this->session->set_flashdata('success', 'Data berhasil diupdate!');
        } else {
            $this->session->set_flashdata('error', 'Gagal mengupdate data!');
        }

        redirect('user/closing');
    }

    // Validasi dan update
    public function update()
    {
        $this->form_validation->set_rules('no_kontrak', 'No Kontrak', 'required');
        $this->form_validation->set_rules('nama_pt', 'Nama PT', 'required');
        $this->form_validation->set_rules('pekerjaan', 'Pekerjaan', 'required');
        // $this->form_validation->set_rules('tgl_terima_bast', 'Tanggal Terima BAST', 'required');
        // $this->form_validation->set_rules('tgl_closing', 'Tanggal Closing', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('user/closing');
        } else {
            $data = [
                'no_kontrak' => $this->input->post('no_kontrak'),
                'nama_pt' => $this->input->post('nama_pt'),
                'pekerjaan' => $this->input->post('pekerjaan'),
                'tgl_terima_bast' => $this->input->post('tgl_terima_bast'),
                'tgl_closing' => $this->input->post('tgl_closing'),
                'keterangan_fa' => $this->input->post('keterangan_fa')
            ];

            $id = $this->input->post('id_closing');

            log_message('debug', 'Data yang akan diupdate: ' . print_r($data, TRUE));
            log_message('debug', 'ID record: ' . $id);

            if ($this->Closing_model->update_closing($id, $data)) {
                $this->session->set_flashdata('success', 'Data berhasil diupdate!');
            } else {
                $this->session->set_flashdata('error', 'Gagal mengupdate data!');
            }

            redirect('user/closing');
        }
    }


    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // MENU PENGADAAN

    public function finalaccount_pengadaan()
    {

        $data['title'] = 'Final Account';
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();
        // $this->load->model('Menu_model', 'menu');
        // $data['finalAccount'] = $this->menu->getSubmenu();
        $data['finalAccount_pengadaan'] = $this->db->get('user_final_account')->result_array();

        $this->form_validation->set_rules('no_kontrak', 'No Kontrak', 'required');
        $this->form_validation->set_rules('nama_pt', 'Nama PT', 'required');
        $this->form_validation->set_rules('pekerjaan', 'Pekerjaan', 'required');
        $this->form_validation->set_rules('status', 'Status', 'required');


        if ($this->form_validation->run() == false) {

            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/finalaccount_pengadaan', $data);
            $this->load->view('templates/footer');
        } else {

            $data = [
                'no_kontrak' => $this->input->post('no_kontrak'),
                'nama_pt' => $this->input->post('nama_pt'),
                'pekerjaan' => $this->input->post('pekerjaan'),
                'status' => $this->input->post('status'),
                'is_active' => $this->input->post('is_active')
            ];

            $data['updated_by'] = $this->session->userdata('email');
            $data['updated_at'] = date('Y-m-d H:i:s');

            $this->db->insert('user_final_account', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
    Data Berhasil Ditambah!
</div>');
            redirect('user/finalaccount');
        }
    }

    ///////////////////////////Report////////////////////

    // application/controllers/User.php

    public function laporan()
    {
        $data['title'] = 'Laporan';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['laporan'] = $this->Laporan_model->getLaporanData();

        // Get reminder dates
        $this->load->model('Partial_model');
        $reminder_dates = $this->Partial_model->get_reminder_dates();

        if (!$reminder_dates) {
            $reminder_dates = []; // Set to empty array if no data
        }

        $data['reminder_dates'] = $reminder_dates;
        $data['current_date'] = date('Y-m-d');

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/report', $data);
        $this->load->view('templates/footer');
    }

    public function export_report()
    {
        // Load Composer autoloader
        require_once FCPATH . 'vendor/autoload.php';

        // Ambil parameter pencarian dari request
        $search = $this->input->get('search');

        // Ambil data dari model Laporan_model dengan parameter pencarian
        if (!empty($search)) {
            $laporan = $this->Laporan_model->getFilteredLaporanData($search);
        } else {
            $laporan = $this->Laporan_model->getLaporanData();
        }

        // =========================================================================
        // 1. HITUNG KETERANGAN DAN RINGKASAN (SUMMARY)
        // =========================================================================
        $summary = [];
        // Loop untuk menghitung keterangan dan mengisi array summary
        foreach ($laporan as &$item) {
            // Panggil fungsi logika keterangan yang sudah Anda definisikan
            $keterangan = $this->generateKeterangan($item);
            $item['keterangan'] = $keterangan;

            // Hitung jumlah untuk ringkasan
            $summary[$keterangan] = ($summary[$keterangan] ?? 0) + 1;
        }
        unset($item); // Bersihkan referensi

        if (empty($laporan)) {
            echo 'No data found'; // Menampilkan pesan jika tidak ada data ditemukan
            exit;
        }


        // Buat objek Spreadsheet
        $spreadsheet = new PhpOffice\PhpSpreadsheet\Spreadsheet();

        // =========================================================================
        // STYLE DEFINITION (Pindahkan ke atas agar bisa digunakan di semua sheet)
        // =========================================================================
        $styleHeader = [
            'font' => ['bold' => true],
            'fill' => ['fillType' => PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'CCCCCC']],
            'borders' => ['outline' => ['borderStyle' => PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]],
            'alignment' => ['horizontal' => PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
        ];


        // =========================================================================
        // Helper function to write headers and common columns
        // =========================================================================
        $writeHeaders = function ($sheet) use ($styleHeader) {
            // Isi header kolom pada spreadsheet
            $sheet->setCellValue('A2', 'No Kontrak');
            $sheet->setCellValue('B2', 'Nama PT');
            $sheet->setCellValue('C2', 'Pekerjaan');
            $sheet->setCellValue('D2', 'Tanggal Terima Asbuilt');
            $sheet->setCellValue('E2', 'Tanggal Terima BAST');
            $sheet->setCellValue('F2', 'Tanggal Final Account');
            $sheet->setCellValue('G2', 'Tanggal Terima BAST 2');

            // KOLOM TTD BAST 2
            $sheet->setCellValue('H2', 'Tanggal Kirim POM');
            $sheet->setCellValue('I2', 'Tanggal Kirim Kepusat'); // tgl_pusat2
            $sheet->setCellValue('J2', 'Tanggal Kembali Kontraktor'); // tgl_kontraktor2

            $sheet->setCellValue('K2', 'Retensi');
            $sheet->setCellValue('L2', 'Keterangan');
            $sheet->setCellValue('M2', 'User Terakhir Update'); // Indeks kolom terakhir M

            // Beri style pada header kolom (Rentang M2)
            $sheet->getStyle('A2:M2')->applyFromArray($styleHeader);

            // Mengatur lebar kolom otomatis berdasarkan konten
            foreach (range('A', 'M') as $columnID) {
                $sheet->getColumnDimension($columnID)->setAutoSize(true);
            }
        };

        // =========================================================================
        // Helper function to write common data rows
        // =========================================================================
        $writeData = function ($sheet, $data, $startRow = 3) {
            // Helper function to format date from YYYY-MM-DD to DD-MM-YYYY
            $formatDate = function ($date_value) {
                if (empty($date_value) || $date_value == '0000-00-00') {
                    return '';
                }
                $date = new DateTime($date_value);
                return $date->format('d-m-Y');
            };

            $row = $startRow;
            foreach ($data as $item) {
                $sheet->setCellValue('A' . $row, $item['no_kontrak']);
                $sheet->setCellValue('B' . $row, $item['nama_pt']);
                $sheet->setCellValue('C' . $row, $item['pekerjaan']);
                $sheet->setCellValue('D' . $row, $formatDate($item['tgl_terima_asbuilt']));

// ================= KOMENTAR EXCEL ASBUILT =================
// Ambil komentar dari field keterangan tabel user_asbuiltdrawing
if (!empty($item['keterangan_asbuilt'])) {
    $comment = $sheet->getComment('D' . $row);
    $comment->setAuthor('Aplikasi Monitoring');
    $comment->setWidth('180pt');
    $comment->setHeight('80pt');
    $comment->getText()->createTextRun($item['keterangan_asbuilt']);
}
// ==========================================================


                $sheet->setCellValue('E' . $row, $formatDate($item['tgl_terima_bast']));
                $sheet->setCellValue('F' . $row, $formatDate($item['tgl_closing']));
                $sheet->setCellValue('G' . $row, $formatDate($item['tgl_terima_bast2']));

                // PENGISIAN DATA KOLOM TTD BAST 2
                $sheet->setCellValue('H' . $row, $formatDate($item['tgl_pom']));

                // MENAMBAHKAN KOMENTAR KETERANGAN2 KE KOLOM H (tgl_pom)
                // Pastikan data 'keterangan2' ada dan tidak kosong sebelum ditambahkan
                if (!empty($item['keterangan2'])) {
                    $comment = $sheet->getComment('H' . $row);
                    // Tambahkan author untuk kejelasan
                    $comment->setAuthor('Aplikasi Monitoring');
                    // Menetapkan dimensi agar komentar terlihat lebih besar secara default
                    $comment->setWidth('150pt');
                    $comment->setHeight('60pt');
                    $comment->getText()->createTextRun($item['keterangan2']);
                }
                // END COMMENT ADDITION

                $sheet->setCellValue('I' . $row, $formatDate($item['tgl_pusat2']));
                $sheet->setCellValue('J' . $row, $formatDate($item['tgl_kontraktor2']));

                // Kolom K sampai M
                $sheet->setCellValue('K' . $row, $item['opsi_retensi']);
                $sheet->setCellValue('L' . $row, $item['keterangan']);
                $sheet->setCellValue(
                    'M' . $row,
                    $item['updated_by_bast2'] ??
                        $item['updated_by_closing'] ??
                        $item['updated_by_bast'] ??
                        $item['updated_by_asbuilt'] ??
                        'Belum ada update'
                );

                $row++;
            }
            return $row; // Return next available row
        };

        // =========================================================================
        // 2. SHEET KESELURUHAN (OVERALL) - Sheet Index 0
        // =========================================================================
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Keseluruhan');

        // Tambahkan judul pada baris pertama
        $sheet->setCellValue('A1', 'MONITORING BERITA ACARA SERAH TERIMA PROYEK TOKYO RIVERSIDE');
        $sheet->mergeCells('A1:M1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);

        $writeHeaders($sheet);

        // Isi data keseluruhan
        $nextRow = $writeData($sheet, $laporan, 3);

        // MENULIS RINGKASAN STATUS KONTRAK (Untuk Sheet Keseluruhan Saja)
        $summaryRow = $nextRow + 2;
        $sheet->setCellValue('A' . $summaryRow, 'RINGKASAN STATUS KONTRAK');
        $sheet->mergeCells('A' . $summaryRow . ':B' . $summaryRow);
        $sheet->getStyle('A' . $summaryRow)->getFont()->setBold(true)->setSize(12);

        $summaryRow++;
        // Header Ringkasan
        $sheet->setCellValue('A' . $summaryRow, 'Status Keterangan');
        $sheet->setCellValue('B' . $summaryRow, 'Jumlah Kontrak');
        // Menggunakan style header yang disederhanakan
        $sheet->getStyle('A' . $summaryRow . ':B' . $summaryRow)->applyFromArray([
            'font' => ['bold' => true],
            'fill' => ['fillType' => PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'D9E3F0']],
            'borders' => ['outline' => ['borderStyle' => PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]],
        ]);

        $summaryRow++;
        // Isi data ringkasan
        foreach ($summary as $status => $count) {
            $sheet->setCellValue('A' . $summaryRow, $status);
            $sheet->setCellValue('B' . $summaryRow, $count);
            $summaryRow++;
        }


        // =========================================================================
        // 3. SHEET PER-KETERANGAN (PER STATUS)
        // =========================================================================

        $sheetIndex = 1;
        foreach ($summary as $status => $count) {
            // Membuat sheet baru
            $spreadsheet->createSheet();
            $sheet = $spreadsheet->setActiveSheetIndex($sheetIndex);

            // PHPSpreadsheet sheet title max 31 characters. Hapus karakter ilegal.
            $safeTitle = substr(str_replace(['/', '\\', '?', '*', '[', ']', ':', ' '], '_', $status), 0, 31);
            $sheet->setTitle($safeTitle);

            // Filter data untuk status saat ini
            $filteredData = array_filter($laporan, function ($item) use ($status) {
                return $item['keterangan'] === $status;
            });

            // Tulis Judul (Baris 1)
            $sheet->setCellValue('A1', 'MONITORING KONTRAK - STATUS: ' . $status);
            $sheet->mergeCells('A1:M1');
            $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);

            // Tulis Header (Baris 2)
            $writeHeaders($sheet);

            // Tulis Data (Mulai Baris 3)
            $writeData($sheet, $filteredData, 3);

            $sheetIndex++;
        }

        // Set active sheet kembali ke "Keseluruhan" sebelum save
        $spreadsheet->setActiveSheetIndex(0);

        // =========================================================================
        // 4. OUTPUT FILE EXCEL
        // =========================================================================

        // Menggunakan output buffer untuk mengunduh file
        ob_start();
        $writer = new PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
        $xlsData = ob_get_contents();
        ob_end_clean();

        // Set header untuk force download file
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Monitoring_BAST_' . date("Y-m-d_H-i-s") . '.xlsx"');
        header('Cache-Control: max-age=0');

        // Output file Excel ke browser
        echo $xlsData;
        exit;
    }

    /**
     * Menghitung status keterangan kontrak berdasarkan tanggal-tanggal BAST dan TTD.
     *
     * @param array $row Data kontrak tunggal.
     * @return string Status keterangan kontrak.
     */
    private function generateKeterangan($row)
    {
        // Fungsi bantuan untuk memeriksa apakah tanggal terisi (mengabaikan '0000-00-00' atau kosong)
        $is_date_filled = function ($date_value) {
            // Menggunakan null coalescing untuk keamanan jika key tidak ada
            $date = $date_value ?? null;
            return !empty($date) && $date != '0000-00-00';
        };

        // Ambil status tanggal-tanggal penting
        $tgl_kontraktor2 = $is_date_filled($row['tgl_kontraktor2'] ?? null);
        $tgl_pom         = $is_date_filled($row['tgl_pom'] ?? null);
        $tgl_pusat       = $is_date_filled($row['tgl_pusat2'] ?? null);
        $tgl_bast2       = $is_date_filled($row['tgl_terima_bast2'] ?? null);

        // =========================================================================
        // LOGIKA TTD BAST 2 (DIUTAMAKAN JIKA tgl_terima_bast2 SUDAH ADA)
        // =========================================================================

        // Logika 1 & 5: Status DONE Final (Jika Kontraktor sudah tanda tangan, terlepas dari POM/Pusat)
        if ($tgl_kontraktor2) {
            return 'DONE';
        }

        // Logika 2 & 4: Status Proses TTD di Pusat (Jika Pusat sudah tanda tangan, terlepas dari POM)
        if ($tgl_pusat) {
            return 'BAST 2 Proses TTD di Pusat';
        }

        // Logika 3: Proses TTD POM (Jika POM sudah tanda tangan)
        if ($tgl_pom) {
            return 'Proses TTD POM';
        }

        // Logika 4 (Asli): Proses TTD CM atau PM (Jika BAST 2 diterima, tapi TTD belum dimulai)
        if ($tgl_bast2) {
            return 'Proses TTD CM atau PM';
        }

        // =========================================================================
        // LOGIKA LAMA (BAST 1, Retensi, dan Final Account)
        // =========================================================================

        if (empty($row['tgl_terima_asbuilt'])) {
            return 'Belum BAST 1 / asbuilt belum diajukan';
        } elseif (!empty($row['tgl_terima_asbuilt']) && empty($row['tgl_terima_bast'])) {
            return 'Segera ajukan BAST 1';
        } elseif (!empty($row['tgl_terima_bast']) && empty($row['tgl_closing'])) {
            // Jika retensi 0, langsung DONE di tahap ini
            if (isset($row['opsi_retensi']) && $row['opsi_retensi'] == 0) {
                return 'DONE';
            }
            return 'Ajukan Final Account terlebih dahulu';
        } elseif (!empty($row['tgl_terima_bast']) && !empty($row['tgl_closing'])) {

            // Pengecekan Masa Retensi
            if (isset($row['opsi_retensi']) && $row['opsi_retensi'] == 0) {
                return 'DONE';
            }

            $tgl_terima_bast = strtotime($row['tgl_terima_bast']);
            $tgl_terima_bast_plus_retensi = strtotime("+" . $row['opsi_retensi'] . " days", $tgl_terima_bast);

            // Jika masa retensi habis dan tgl_bast2 belum diisi (karena sudah di cek di atas)
            if (time() >= $tgl_terima_bast_plus_retensi) {
                return 'Masa retensi habis, segera ajukan BAST 2';
            } else {
                return 'BAST 2 belum diajukan / masih dalam masa retensi';
            }
        } else {
            return '';
        }
    }




    /**
     * Export data BAST 2 ke Excel dengan format tanggal DD-MM-YYYY
     */
    public function export_bast2()
    {
        // Load Composer autoloader
        require_once FCPATH . 'vendor/autoload.php';

        // Ambil parameter pencarian dari request
        $search = $this->input->get('search');

        // Ambil data dari model Bast2_model dengan parameter pencarian
        if (!empty($search)) {
            // Filter berdasarkan no_kontrak, nama_pt, atau pekerjaan
            $bast2_data = $this->Bast2_model->getJoinedBastData();
            $filtered_data = [];
            foreach ($bast2_data as $item) {
                if (stripos($item['no_kontrak'], $search) !== false || 
                    stripos($item['nama_pt'], $search) !== false || 
                    stripos($item['pekerjaan'], $search) !== false) {
                    $filtered_data[] = $item;
                }
            }
            $bast2_data = $filtered_data;
        } else {
            $bast2_data = $this->Bast2_model->getJoinedBastData();
        }

        if (empty($bast2_data)) {
            echo 'No data found';
            exit;
        }

        // Buat objek Spreadsheet
        $spreadsheet = new PhpOffice\PhpSpreadsheet\Spreadsheet();

        // STYLE DEFINITION
        $styleHeader = [
            'font' => ['bold' => true],
            'fill' => ['fillType' => PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'CCCCCC']],
            'borders' => ['outline' => ['borderStyle' => PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]],
            'alignment' => ['horizontal' => PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
        ];

        // Set active sheet
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('BAST 2 Data');

        // Tambahkan judul pada baris pertama
        $sheet->setCellValue('A1', 'MONITORING BAST 2 (TANDA TANGAN PROSES) - PROYEK TOKYO RIVERSIDE');
        $sheet->mergeCells('A1:L1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);

        // Isi header kolom pada spreadsheet (Baris 2)
        $sheet->setCellValue('A2', 'No Kontrak');
        $sheet->setCellValue('B2', 'Nama PT');
        $sheet->setCellValue('C2', 'Pekerjaan');
        $sheet->setCellValue('D2', 'Tgl Terima BAST 1');
        $sheet->setCellValue('E2', 'Retensi');
        $sheet->setCellValue('F2', 'Tgl Terima BAST 2');
        $sheet->setCellValue('G2', 'Tgl Kirim POM');
        $sheet->setCellValue('H2', 'Tgl Kembali POM');
        $sheet->setCellValue('I2', 'Tgl Kirim Kepusat');
        $sheet->setCellValue('J2', 'Tgl Kembali Kontraktor');
        $sheet->setCellValue('K2', 'Keterangan');
        $sheet->setCellValue('L2', 'User Terakhir Update');

        // Beri style pada header kolom
        $sheet->getStyle('A2:L2')->applyFromArray($styleHeader);

        // Mengatur lebar kolom otomatis berdasarkan konten
        foreach (range('A', 'L') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        // Helper function to format date from YYYY-MM-DD to DD-MM-YYYY
        $formatDate = function ($date_value) {
            if (empty($date_value) || $date_value == '0000-00-00') {
                return '';
            }
            $date = new DateTime($date_value);
            return $date->format('d-m-Y');
        };

        // Isi data ke dalam spreadsheet (Mulai Baris 3)
        $row = 3;
        foreach ($bast2_data as $item) {
            $sheet->setCellValue('A' . $row, $item['no_kontrak']);
            $sheet->setCellValue('B' . $row, $item['nama_pt']);
            $sheet->setCellValue('C' . $row, $item['pekerjaan']);
            $sheet->setCellValue('D' . $row, $formatDate($item['tgl_terima_bast']));
            $sheet->setCellValue('E' . $row, $item['opsi_retensi']);
            $sheet->setCellValue('F' . $row, $formatDate($item['tgl_terima_bast2']));
            $sheet->setCellValue('G' . $row, $formatDate($item['tgl_pom']));
            $sheet->setCellValue('H' . $row, $formatDate($item['kembali_pom']));
            $sheet->setCellValue('I' . $row, $formatDate($item['tgl_pusat2']));
            $sheet->setCellValue('J' . $row, $formatDate($item['tgl_kontraktor2']));
            $sheet->setCellValue('K' . $row, $item['keterangan2']);
            $sheet->setCellValue(
                'L' . $row,
                $item['updated_by_bast2'] ?? 'Belum ada update'
            );

            $row++;
        }

        // Menggunakan output buffer untuk mengunduh file
        ob_start();
        $writer = new PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
        $xlsData = ob_get_contents();
        ob_end_clean();

        // Set header untuk force download file
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Monitoring_BAST2_' . date("Y-m-d_H-i-s") . '.xlsx"');
        header('Cache-Control: max-age=0');

        // Output file Excel ke browser
        echo $xlsData;
        exit;
    }




    public function exportFilteredDataToExcel()
    {
        // Load Composer autoloader
        require_once FCPATH . 'vendor/autoload.php';

        // Ambil parameter pencarian dari request
        $search = $this->input->post('search');

        // Buat query berdasarkan pencarian
        $this->db->select('*');
        $this->db->from('laporan');
        if (!empty($search)) {
            $this->db->like('field', $search); // Sesuaikan dengan kolom yang ingin Anda cari
        }
        $query = $this->db->get();

        // Inisialisasi spreadsheet dan penulisan data
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Tulis header kolom
        $sheet->setCellValue('A1', 'No Kontrak');
        $sheet->setCellValue('B1', 'Nama PT');
        $sheet->setCellValue('C1', 'Pekerjaan');
        // Tulis data laporan
        $row = 2;
        foreach ($query->result_array() as $data) {
            $sheet->setCellValue('A' . $row, $data['no_kontrak']);
            $sheet->setCellValue('B' . $row, $data['nama_pt']);
            $sheet->setCellValue('C' . $row, $data['pekerjaan']);
            // Tulis kolom lainnya sesuai kebutuhan
            $row++;
        }

        // Setup nama file untuk di-download
        $filename = 'filtered_data_' . date('Y-m-d_H-i-s') . '.xlsx';

        // Save Excel 2007 file
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('downloads/' . $filename); // Simpan file di folder downloads

        // Set header untuk force download file
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        // Output file Excel ke browser
        $writer->save('php://output');
        exit;
    }


    public function simpan_semua_ke_laporan()
    {
        $laporan = $this->Laporan_model->getLaporanData();

        foreach ($laporan as $item) {
            $data = [
                'no_kontrak' => $item['no_kontrak'],
                'nama_pt' => $item['nama_pt'],
                'pekerjaan' => $item['pekerjaan'],
                'tgl_terima_asbuilt' => $item['tgl_terima_asbuilt'],
                'tgl_terima_bast' => $item['tgl_terima_bast'],
                'tgl_closing' => $item['tgl_closing'],
                'tgl_terima_bast2' => $item['tgl_terima_bast2'],
                'tgl_pom' => $item['tgl_pom'],
                'kembali_pom' => $item['kembali_pom'],
                'tgl_pusat2' => $item['tgl_pusat2'],
                'tgl_kontraktor2' => $item['tgl_kontraktor2'],
                'opsi_retensi' => $item['opsi_retensi'],
                'keterangan' => $item['keterangan'],
            ];

            // Cek dulu, hindari duplikasi no_kontrak
            $existing = $this->db->get_where('laporan', ['no_kontrak' => $item['no_kontrak']])->row_array();
            if (!$existing) {
                $this->Laporan_model->simpanKeLaporanTable($data);
            }
        }

        $this->session->set_flashdata('message', '<div class="alert alert-success">Semua laporan berhasil disimpan ke database.</div>');
        redirect('user/laporan');
    }


    // CONTROLER PARTIAL///////



    public function partial()
    {
        $data['title'] = 'Berita Acara Partial';
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        $data['partials'] = $this->partial->get_all_partial();

        // Kirim data tanggal untuk pop-up
        $data['current_date'] = date('Y-m-d'); // tanggal sekarang
        $data['reminder_dates'] = $this->get_reminder_dates($data['partials']); // logika untuk mendapatkan tanggal reminder

        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/partial', $data);
        $this->load->view('templates/footer');
    }

    private function get_reminder_dates($partials)
    {
        $reminder_dates = [];
        foreach ($partials as $partial) {
            $tgl_kirim_pom = $partial['tgl_kirim_pom'];
            if (!empty($tgl_kirim_pom) && $tgl_kirim_pom != '0000-00-00') {
                $reminder_date = date('Y-m-d', strtotime($tgl_kirim_pom . ' +10 days'));
                $reminder_dates[] = [
                    'id_parsial' => $partial['id_parsial'],
                    'reminder_date' => $reminder_date,
                    'tgl_kirim_pom' => $tgl_kirim_pom,
                    'tgl_kembali_pom' => $partial['tgl_kembali_pom']
                ];
            }
        }
        return $reminder_dates;
    }

    public function add()
    {
        $data = [
            'lokasi' => $this->input->post('lokasi'),
            'area' => $this->input->post('area'),
            'pekerjaan' => $this->input->post('pekerjaan'),
            'nama_kontraktor' => $this->input->post('nama_kontraktor'),
            'no_dokumen' => $this->input->post('no_dokumen'),
            'tgl_kirim_pom' => $this->input->post('tgl_kirim_pom'),
            'tgl_kembali_pom' => $this->input->post('tgl_kembali_pom'),
            'tgl_kembali_kontraktor' => $this->input->post('tgl_kembali_kontraktor'),
            'keterangan' => $this->input->post('keterangan'),
            'scan_pdf' => $this->input->post('scan_pdf')
        ];

        if ($this->partial->insertPartial($data)) {
            redirect('user/partial');
        } else {
            echo "Failed to insert data.";
        }
    }

    public function update_partial()
    {
        $id_parsial = $this->input->post('id_parsial');

        // Load library upload
        $this->load->library('upload');

        // Set configuration for file upload
        $config['upload_path'] = './assets/upload/partial'; // Ganti dengan path folder yang sesuai
        $config['allowed_types'] = 'pdf'; // Jenis file yang diperbolehkan
        $config['max_size'] = 20048; // Ukuran maksimal file dalam KB
        $config['encrypt_name'] = TRUE; // Enkripsi nama file

        $this->upload->initialize($config);

        $scan_pdf = '';
        if ($_FILES['scan_pdf']['name']) {
            if ($this->upload->do_upload('scan_pdf')) {
                $uploadData = $this->upload->data();
                $scan_pdf = $uploadData['file_name'];
            } else {
                // Handle upload errors here
                $error = $this->upload->display_errors();
                $this->session->set_flashdata('error', $error);
                redirect('user/partial');
                return;
            }
        }

        $data = [
            'lokasi' => $this->input->post('lokasi'),
            'area' => $this->input->post('area'),
            'pekerjaan' => $this->input->post('pekerjaan'),
            'nama_kontraktor' => $this->input->post('nama_kontraktor'),
            'no_dokumen' => $this->input->post('no_dokumen'),
            'tgl_kirim_pom' => $this->input->post('tgl_kirim_pom'),
            'tgl_kembali_pom' => $this->input->post('tgl_kembali_pom'),
            'tgl_kembali_kontraktor' => $this->input->post('tgl_kembali_kontraktor'),
            'keterangan' => $this->input->post('keterangan'),
            'scan_pdf' => $scan_pdf ? $scan_pdf : $this->input->post('current_scan_pdf') // Menyimpan nama file baru atau nama file lama
        ];

        $this->partial->updatePartial($id_parsial, $data);
        $this->session->set_flashdata('message', 'Data updated successfully.');
        redirect('user/partial');
    }

    // export partila/////

    public function export_partial()
    {
        // Load Composer autoloader
        require_once FCPATH . 'vendor/autoload.php';

        // Ambil parameter pencarian dari request
        $search = $this->input->get('search');

        // Ambil data dari model Partial_model dengan parameter pencarian
        $partials = !empty($search) ? $this->Partial_model->get_partials($search) : $this->Partial_model->get_partials();

        if (empty($partials)) {
            echo 'No data found'; // Menampilkan pesan jika tidak ada data ditemukan
            exit;
        }

        // Buat objek Spreadsheet
        $spreadsheet = new PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Tambahkan judul pada baris pertama
        $sheet->setCellValue('A1', 'DATA USER PARTIAL');
        $sheet->mergeCells('A1:L1');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);

        // Isi header kolom pada spreadsheet
        $sheet->setCellValue('A2', 'Lokasi');
        $sheet->setCellValue('B2', 'Area');
        $sheet->setCellValue('C2', 'Pekerjaan');
        $sheet->setCellValue('D2', 'Nama Kontraktor');
        $sheet->setCellValue('E2', 'No Dokumen');
        $sheet->setCellValue('F2', 'Tgl Kirim POM');
        $sheet->setCellValue('G2', 'Tgl Kembali POM');
        $sheet->setCellValue('H2', 'Tgl Kembali Kontraktor');
        $sheet->setCellValue('I2', 'Keterangan');
        $sheet->setCellValue('J2', 'Scan PDF');

        // Beri style pada header kolom
        $styleHeader = [
            'font' => ['bold' => true],
            'fill' => ['fillType' => PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'CCCCCC']],
            'borders' => ['outline' => ['borderStyle' => PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]],
            'alignment' => ['horizontal' => PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
        ];
        $sheet->getStyle('A2:J2')->applyFromArray($styleHeader);

        // Isi data dari model Partial_model ke dalam spreadsheet
        $row = 3;
        foreach ($partials as $partial) {

            $sheet->setCellValue('A' . $row, $partial['lokasi']);
            $sheet->setCellValue('B' . $row, $partial['area']);
            $sheet->setCellValue('C' . $row, $partial['pekerjaan']);
            $sheet->setCellValue('D' . $row, $partial['nama_kontraktor']);
            $sheet->setCellValue('E' . $row, $partial['no_dokumen']);

            // Format tanggal
            $sheet->setCellValue('F' . $row, $partial['tgl_kirim_pom']);
            $sheet->getStyle('F' . $row)->getNumberFormat()->setFormatCode('DD-MM-YYYY');

            $sheet->setCellValue('G' . $row, $partial['tgl_kembali_pom']);
            $sheet->getStyle('G' . $row)->getNumberFormat()->setFormatCode('DD-MM-YYYY');

            $sheet->setCellValue('H' . $row, $partial['tgl_kembali_kontraktor']);
            $sheet->getStyle('H' . $row)->getNumberFormat()->setFormatCode('DD-MM-YYYY');

            $sheet->setCellValue('I' . $row, $partial['keterangan']);
            $sheet->setCellValue('J' . $row, $partial['scan_pdf']);
            $row++;
        }

        // Mengatur lebar kolom otomatis berdasarkan konten
        foreach (range('A', 'J') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        // Menggunakan output buffer untuk mengunduh file
        ob_start();
        $writer = new PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
        $xlsData = ob_get_contents();
        ob_end_clean();

        // Set header untuk force download file
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Data_User_Partial_' . date("Y-m-d_H-i-s") . '.xlsx"');
        header('Cache-Control: max-age=0');

        // Output file Excel ke browser
        echo $xlsData;
        exit;
    }

    public function import_partial()
    {
        // Load the PHPSpreadsheet library
        require 'vendor/autoload.php';

        if (!empty($_FILES['file_partial']['name'])) {
            $file = $_FILES['file_partial'];
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
                $this->Partial_model->delete_all();

                // Start from the second row (first row is usually header)
                for ($row = 2; $row <= $highestRow; $row++) {
                    // Get data from each column
                    $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);

                    // Save data to array
                    $data = array(
                        'lokasi' => $rowData[0][0],
                        'area' => $rowData[0][1],
                        'pekerjaan' => $rowData[0][2],
                        'nama_kontraktor' => $rowData[0][3],
                        'no_dokumen' => $rowData[0][4],
                        'tgl_kirim_pom' => $this->formatDate($rowData[0][5]),
                        'tgl_kembali_pom' => $this->formatDate($rowData[0][6]),
                        'tgl_kembali_kontraktor' => $this->formatDate($rowData[0][7]),
                        'keterangan' => $rowData[0][8],
                        'scan_pdf' => $rowData[0][9]
                    );

                    // Save data to database using model
                    $this->Partial_model->save_partial($data);
                }

                // Show success message or redirect to a specific page
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Import Data berhasil!</div>');
                redirect('user/partial');
            } else {
                // Invalid file extension
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Import Data Gagal! File harus berupa file Excel dengan ekstensi .xlsx atau .xls.</div>');
                redirect('user/partial');
            }
        } else {
            // No file uploaded
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Import Data Gagal! Harap pilih file Excel yang akan diimpor.</div>');
            redirect('user/partial');
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

    public function barangkeluar_pdf($id)
    {
        $this->load->library('pdf');

        // Pastikan model dan method ini benar
        $item = $this->Gudang_model->getBarangKeluarById($id); // ambil data berdasarkan ID

        if (!$item) {
            show_404(); // Kalau data tidak ditemukan
        }

        $data['item'] = $item;

        $html = $this->load->view('tanda_terima_pdf', $data, true);

        $this->pdf->loadHtml($html);
        $this->pdf->setPaper('A4', 'portrait');
        $this->pdf->render();

        // Inline PDF di browser
        $this->pdf->stream("Tanda_Terima_Barang_{$id}.pdf", array("Attachment" => false));
    }


    public function finalaccount_table()
    {
        $data['finalAccount'] = $this->Fa_model->getAll(); // sesuaikan dengan model kamu
        $this->load->view('user/finalaccount_table', $data);
    }

    public function finalaccount_milenial_table()
    {
        $this->load->model('Kontrak_model', 'kontrak');
        $data['milenialAccount'] = $this->kontrak->get_all();
        $this->load->view('user/finalaccount_milenial_table', $data);
    }

    /**
     * Fungsi untuk mengisi created_by semua tabel dengan user "Admin"
     */
    public function fill_created_by_all() {
        // Cek permission - hanya admin
        if ($this->session->userdata('role') !== 'admin') {
            echo json_encode([
                'status' => 'error',
                'message' => 'Hanya admin yang bisa melakukan aksi ini!'
            ]);
            return;
        }

        $tables = $this->input->post('tables');
        
        if (empty($tables)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Pilih minimal satu tabel!'
            ]);
            return;
        }

        $totalAffected = 0;
        $successTables = [];

        // Update untuk setiap tabel
        foreach ($tables as $table) {
            // Validasi nama tabel (whitelist)
            $allowedTables = ['user_bast', 'user_bast2', 'user_final_account', 'user_final_account_milenial'];
            
            if (!in_array($table, $allowedTables)) {
                continue;
            }

            // Cek apakah kolom created_by ada
            $fields = $this->db->list_fields($table);
            if (!in_array('created_by', $fields)) {
                // Jika belum ada, buat kolom terlebih dahulu
                $this->db->query("ALTER TABLE $table ADD COLUMN created_by VARCHAR(100) AFTER id");
            }

            // Update data
            $this->db->update($table, 
                ['created_by' => 'Admin'], 
                "(created_by IS NULL OR created_by = '')");

            $affected = $this->db->affected_rows();
            $totalAffected += $affected;
            
            $successTables[] = $table . " (" . $affected . " data)";
        }

        echo json_encode([
            'status' => 'success',
            'message' => '<strong>Berhasil mengisi created_by!</strong><br>' . 
                         'Total data yang diupdate: <strong>' . $totalAffected . ' data</strong><br>' .
                         'Tabel: ' . implode(', ', $successTables)
        ]);
    }
}