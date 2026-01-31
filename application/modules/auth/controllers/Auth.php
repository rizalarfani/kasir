<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->login();
    }

    public function login()
    {
        if ($this->session->userdata('log_admin')) {
            redirect('.');
        } else {
            $this->load->view('login');
        }
    }
    public function proses()
    {
        $this->load->model('M_auth');

        $username    = addslashes(trim($this->input->post('username')));
        $password    = addslashes(trim($this->input->post('password')));
        $row        = $this->M_auth->validasi($username, $password);

        if ($row != null) {
            $this->session->set_userdata('log_admin', $row);
            redirect('.', 'refresh');
        } else {
            $this->session->set_flashdata("notifikasi", "Username atau password Anda salah");
            redirect('login', 'refresh');
        }
    }

    function logout()
    {
        $this->session->sess_destroy();
        redirect('login');
    }
}
