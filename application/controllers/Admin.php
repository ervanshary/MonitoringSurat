<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{


    // fungsi helper
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('User_model'); // Load model User_model
    }
    public function index()
    {
        $data['title'] = 'Dashboard Admin';
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();

        $this->load->model('Fa_model');
        $data['kontrak_summary'] = $this->Fa_model->get_kontrak_summary();
        $data['kontrak_stats'] = $this->Fa_model->get_kontrak_stats();
        $data['summary_counts'] = $this->Fa_model->get_summary_counts();

        $this->load->model('Partial_model');
        $reminder_dates = $this->Partial_model->get_reminder_dates();
        $data['reminder_dates'] = $reminder_dates ?? [];
        $data['current_date'] = date('Y-m-d');

        // Tentukan isi konten yang akan dimuat di main.php
        $data['page'] = 'admin/index';

        // Panggil wrapper utama
        $this->load->view('templates/main', $data);
    }



    public function role()

    {
        $data['title'] = 'Role';
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();

        $data['role'] = $this->db->get('user_role')->result_array();

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
        $this->load->view('admin/role', $data);
        $this->load->view('templates/footer');
    }

    public function roleAccess($role_id)

    {
        $data['title'] = 'Role Access';
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();

        $data['role'] = $this->db->get_where('user_role', ['id' => $role_id])->row_array();
        $this->db->where('id !=', 1);
        $data['menu'] = $this->db->get('user_menu')->result_array();

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
        $this->load->view('admin/role-access', $data);
        $this->load->view('templates/footer');
    }

    public function changeaccess()
    {
        $menu_id = $this->input->post('menuId');
        $role_id = $this->input->post('roleId');

        $data = [
            'role_id' => $role_id,
            'menu_id' => $menu_id
        ];
        $result = $this->db->get_where('user_access_menu', $data);

        if ($result->num_rows() < 1) {
            $this->db->insert('user_access_menu', $data);
        } else {
            $this->db->delete('user_access_menu', $data);
        }

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
Access berhasil dirubah!
</div>');
    }


    public function add_role()
    {
        $this->form_validation->set_rules('role', 'Role', 'required');


        if ($this->form_validation->run() == false) {
            // Jika validasi gagal, tampilkan kembali halaman dengan error
            $this->role();
        } else {
            // Jika validasi sukses, ambil data dari form
            $role = $this->input->post('role');

            // Masukkan data ke dalam database
            $data = array(
                'role' => $role
            );
            $this->db->insert('user_role', $data);

            // Set flash message untuk memberitahu user bahwa peran berhasil ditambahkan
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
                Peran berhasil ditambahkan!
            </div>');

            // Redirect kembali ke halaman role untuk melihat perubahan
            redirect('admin/role');
        }
    }


    /////////////////////////USER MANAGEMENT/////////////////////////////////////

    public function usermanagement()
    {
        $data['title'] = 'User Management';
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();
        $data['users'] = $this->User_model->get_users(); // Ambil data pengguna dari model

        // Get reminder dates
        $this->load->model('Partial_model');
        $reminder_dates = $this->Partial_model->get_reminder_dates();

        if (!$reminder_dates) {
            $reminder_dates = []; // Set to empty array if no data
        }

        $data['reminder_dates'] = $reminder_dates;
        $data['current_date'] = date('Y-m-d');


        // Load view admin/usermanagement.php dengan data yang sudah diambil
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('admin/usermanagement', $data);
        $this->load->view('templates/footer');
    }


    public function update_user($user_id)
    {
        // Ambil data dari form
        $data = array(
            'name' => $this->input->post('edit_name' . $user_id),
            'email' => $this->input->post('edit_email' . $user_id),
            'role_id' => $this->input->post('edit_role' . $user_id),
            // Tambahkan kolom lain sesuai kebutuhan
        );

        // Validasi data
        // Misalnya, Anda bisa menggunakan library Form Validation CodeIgniter
        // $this->form_validation->set_rules('edit_name' . $user_id, 'Name', 'required');
        // $this->form_validation->set_rules('edit_email' . $user_id, 'Email', 'required|valid_email');
        // $this->form_validation->set_rules('edit_role' . $user_id, 'Role ID', 'required|integer');

        // Lakukan validasi
        // if ($this->form_validation->run() == FALSE) {
        //     // Jika validasi gagal, tampilkan kembali form dengan pesan error
        //     // Contoh: $this->load->view('admin/usermanagement', $data);
        // } else {
        // Update data pengguna ke dalam database
        $this->User_model->update_user($user_id, $data);

        // Set flashdata untuk memberi pesan bahwa update berhasil
        $this->session->set_flashdata('message', 'Data pengguna berhasil diperbarui.');

        // Redirect kembali ke halaman user management atau halaman lain yang sesuai
        redirect('admin/usermanagement');
        // }
    }

    public function delete_user($user_id)
    {
        // Hapus data pengguna dari database
        $this->User_model->delete_user($user_id);

        // Set flashdata untuk memberi pesan bahwa pengguna berhasil dihapus
        $this->session->set_flashdata('message', 'Data pengguna berhasil dihapus.');

        // Redirect kembali ke halaman user management atau halaman lain yang sesuai
        redirect('admin/usermanagement');
    }
}
