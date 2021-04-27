<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //cek ada session atau tidak
        is_logged_in();

        $this->load->model('Menu_model', 'menu');
    }

    public function index()
    {
        //title
        $data['title'] = 'Menu Management';
        //ambil data user berdasarkan email di session
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        //Query data menu
        $data['menu'] = $this->db->get('user_menu')->result_array();

        //form validation
        $this->form_validation->set_rules('menu', '<strong>menu</strong>', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('menu/index', $data);
            $this->load->view('templates/footer');
        } else {
            $this->db->insert('user_menu', ['menu' => $this->input->post('menu')]);
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show col-sm-10 ml-3" role="alert">New Menu added!<button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button></div>');
            redirect('menu');
        }
    }

    public function delete($id)
    {
        $this->menu->deleteMenu($id);
        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show col-sm-10 ml-3" role="alert">Success <strong>Deleted</strong> Menu<button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button></div>');
        redirect('menu');
    }

    public function edit($id)
    {
        //title
        $data['title'] = 'Edit Menu Management';

        //ambil data user berdasarkan email di session
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        //Query data menu by id
        $data['menu'] = $this->menu->getEditMenuById($id);

        //form validation
        $this->form_validation->set_rules('menu', '<strong>edit menu</strong>', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('menu/edit', $data);
            $this->load->view('templates/footer');
        } else {
            $this->menu->editMenu();
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show col-sm-10 ml-3" role="alert">Menu successfully edited!<button type="button" class="close" data-dismiss="alert" aria-label="Close">
             <span aria-hidden="true">&times;</span></button></div>');
            redirect('menu');
        }
    }

    public function submenu()
    {
        //title
        $data['title'] = 'Sub-Menu Management';
        //ambil data user berdasarkan email di session
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        //Query data submenu
        $data['subMenu'] = $this->menu->getSubMenu();
        //Query data menu
        $data['menu'] = $this->db->get('user_menu')->result_array();

        //form validation
        $this->form_validation->set_rules('title', '<strong>title</strong>', 'required');
        $this->form_validation->set_rules('menu_id', '<strong>menu</strong>', 'required');
        $this->form_validation->set_rules('url', '<strong>URL</strong>', 'required');
        $this->form_validation->set_rules('icon', '<strong>icon</strong>', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('templates/header', $data);
            $this->load->view('templates/sidebar', $data);
            $this->load->view('templates/topbar', $data);
            $this->load->view('menu/submenu', $data);
            $this->load->view('templates/footer');
        } else {
            $this->menu->addSubMenu();
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show col-sm-10 ml-3" role="alert">New Sub-Menu added!<button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button></div>');
            redirect('menu/submenu');
        }
    }

    public function deleteSubMenu($id)
    {
        $this->menu->delSubMenu($id);
        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show col-sm-10 ml-3" role="alert">Success Deleted Sub-Menu<button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button></div>');
        redirect('menu/submenu');
    }

    public function editSubMenu($id)
    {
        $this->menu->saveSubMenu($id);

        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show col-sm-10 ml-3" role="alert">Success Edited Sub-Menu<button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span></button></div>');
        redirect('menu/submenu');
    }
}
