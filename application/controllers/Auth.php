<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Load model, library, dan helper yang diperlukan
        $this->load->model('User_model');
        $this->load->library('form_validation');
        $this->load->library('session');
        $this->load->helper('url');
    }

    // Menampilkan form login
    public function index() {
        // Redirect ke dashboard jika user sudah login
        if ($this->session->userdata('logged_in')) {
            $role = $this->session->userdata('role'); // Ambil role dari session
            
            switch ($role) {
                case 'admin':
                    redirect('Admin');
                    break;
                case 'kantor':
                    redirect('kepala_kantor');
                    break;
                case 'penyuluh':
                    redirect('Penyuluh');
                    break;
                default:
                    redirect('auth'); // Default redirect jika role tidak dikenali
                    break;
            }
        }
        // Tampilkan view login
        $this->load->view('login');
    }

    // Proses login
    public function login() {
        // Set aturan validasi form
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        // Jalankan validasi
        if ($this->form_validation->run() == FALSE) {
            // Jika validasi gagal, tampilkan kembali form login
            $this->load->view('login');
        } else {
            // Ambil data dari form
            $username = $this->input->post('username');
            $password = $this->input->post('password');

            // Cari user berdasarkan username
            $user = $this->User_model->get_user($username);

            // Verifikasi password (tanpa hash)
            if ($user && $password === $user->password) {
                // Set session data
                $user_data = array(
                    'user_id' => $user->id,
                    'username' => $user->username,
                    'role' => $user->role,
                    'logged_in' => TRUE
                );
                $this->session->set_userdata($user_data);

                // Redirect berdasarkan role
                if ($user->role == 'admin') {
                    redirect('Admin');
                } else if ($user->role == 'penyuluh') {
                    redirect('Penyuluh');
                } else if ($user->role == 'kepala_kantor') {
                    redirect('kepalakantor');
                } else {
                    // Tampilkan pesan error jika username atau password salah
                    $this->session->set_flashdata('error', 'Username atau password salah');
                    redirect('auth');
                }  
            } else {
                $this->session->set_flashdata('error', 'Username atau password salah');
                redirect('auth');
            }              
        }
    }

    // Logout
    public function logout() {
        // Hancurkan session dan redirect ke halaman login
        $this->session->sess_destroy();
        redirect('auth');
    }
}