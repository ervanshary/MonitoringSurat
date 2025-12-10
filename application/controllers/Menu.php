<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends CI_Controller
{

    // fungsi helper
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $data['title'] = 'Menu Management';
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();

        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->form_validation->set_rules('menu', 'Menu', 'required');

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
            $this->load->view('menu/index', $data);
            $this->load->view('templates/footer');
        } else {
            $this->db->insert('user_menu', ['menu' => $this->input->post('menu')]);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Menu Berhasil Ditambah!
          </div>');
            redirect('menu');
        }
    }

    public function submenu()
    {

        $data['title'] = 'Submenu Management';
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();
        $this->load->model('Menu_model', 'menu');
        $data['subMenu'] = $this->menu->getSubmenu();
        $data['menu'] = $this->db->get('user_menu')->result_array();

        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('menu_id', 'Menu', 'required');
        $this->form_validation->set_rules('url', 'URL', 'required');
        $this->form_validation->set_rules('icon', 'Icon', 'required');
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
            $this->load->view('menu/submenu', $data);
            $this->load->view('templates/footer');
        } else {

            $data = [
                'title' => $this->input->post('title'),
                'menu_id' => $this->input->post('menu_id'),
                'url' => $this->input->post('url'),
                'icon' => $this->input->post('icon'),
                'is_active' => $this->input->post('is_active')
            ];
            $this->db->insert('user_sub_menu', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">
            Sub Menu Berhasil Ditambah!
          </div>');
            redirect('menu/submenu');
        }
    }

    public function edit($id)
    {
        $data['title'] = 'Menu Management';
        $data['user'] = $this->db->get_where('user', ['email' =>
        $this->session->userdata('email')])->row_array();
        $this->load->model('Menu_model'); // Memuat model Menu_model
        $data['menu'] = $this->Menu_model->getMenuById($id); // Mengambil data menu berdasarkan ID


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
        $this->load->view('menu/edit_menu',);  // Memuat halaman edit menu dengan data menu yang dipilih
        $this->load->view('templates/footer');
    }
}
