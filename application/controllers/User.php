<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    //contructor untuk access control
    public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model', 'user');
        //cek ada session atau tidak
        is_logged_in();
    }

    public function index()
    {
        //ambil data user berdasarkan email di session
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        //title
        $data['title'] = 'My Profile';
        $this->load->view('templates/header', $data);
        $this->load->view('templates/sidebar', $data);
        $this->load->view('templates/topbar', $data);
        $this->load->view('user/index', $data);
        $this->load->view('templates/footer');
    }

    public function edit()
    {
        //ambil data user berdasarkan email di session
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        //title
        $data['title'] = 'Edit Profile';

        //rules
        $this->form_validation->set_rules('name', 'Full Name', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/edit', $data);
            $this->load->view('templates/footer');
        } else {
            $this->user->editUser();
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show col-sm-10 ml-3" role="alert">Your profile has been updated<button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button></div>');
            redirect('user');
        }
    }

    public function changePassword()
    {
        //ambil data user berdasarkan email di session
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        //title
        $data['title'] = 'Change Password';

        //rules
        $this->form_validation->set_rules('current_password', 'Current Password', 'required|trim');
        $this->form_validation->set_rules('new_password1', 'New Password', 'required|trim|min_length[6]|matches[new_password2]', ['matches' => 'password dont match!', 'min_length' => 'password too short!']);
        $this->form_validation->set_rules('new_password2', 'Confirm New Password', 'required|trim|matches[new_password1]');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('user/changepassword', $data);
            $this->load->view('templates/footer');
        } else {
            $this->user->updatePasswordUser();
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show col-sm-10 ml-3" role="alert">Your <strong>password</strong> has been updated!<button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button></div>');
            redirect('user/changepassword');
        }
    }
}
