<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{
    public function editUser()
    {
        //ambil data profile yang lama.
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $name = $this->input->post('name');
        $email = $this->input->post('email');

        //cek jika ada gambar yang akan di upload
        //ketika kita klik upload variable global (_FILES) akan berisi image tersebut.
        $upload_image = $_FILES['image']['name'];
        //atur rule nya.
        if ($upload_image) {
            $config['allowed_types'] = 'jpg|png';
            $config['max_size']     = '2048';
            $config['upload_path'] = './assets/img/profile/';

            //jalankan library nya
            $this->load->library('upload', $config);

            //upload
            if ($this->upload->do_upload('image')) {
                //ambil old_img dari data session
                $old_image = $data['user']['image'];
                //cek gambar default atau tidak
                if ($old_image != 'default.jpg') {
                    //hapus gambar nya
                    unlink(FCPATH . 'assets/img/profile/' . $old_image);
                }
                //ambil dulu nama image nya
                $new_image = $this->upload->data('file_name'); //berisi data file, ambil namanya
                //update set nya
                $this->db->set('image', $new_image);
            } else {
                echo $this->upload->display_erorrs();
            }
        }

        $this->db->set('name', $name);
        $this->db->where('email', $email);
        $this->db->update('user');
    }

    public function updatePasswordUser()
    {
        //ambil data user yang lama.
        $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();
        //ambil password lama yang diinput
        $current_password = $this->input->post('current_password');
        //ambil new password
        $new_password = $this->input->post('new_password1');

        //cek apakah sama current password dan password lama di db
        if (!password_verify($current_password, $data['user']['password'])) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show col-sm-10 ml-3" role="alert">Wrong <strong>Current Password!</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button></div>');
            redirect('user/changepassword');
        } else {
            //cek password baru tidak boleh sama dengan password lama
            if ($current_password == $new_password) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show col-sm-10 ml-3" role="alert"><strong>New Password</strong> cannot be the same as <strong>Current Password</strong><button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span></button></div>');
                redirect('user/changepassword');
            } else {
                //password ok
                $password_hash = password_hash($new_password, PASSWORD_DEFAULT);

                //set password nya
                $this->db->set('password', $password_hash);
                //sesuai dengan user yang mau di update
                $this->db->where('email', $this->session->userdata('email'));
                //update db nya
                $this->db->update('user');
            }
        }
    }
}
