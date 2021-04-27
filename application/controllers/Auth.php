<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Auth_model', 'auth');
        $this->load->library('form_validation');
    }

    public function index()
    {
        //cek session jika sudah login
        if ($this->session->userdata('email')) {
            redirect('user');
        }
        //rules
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'trim|required');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Login Page';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/login');
            $this->load->view('templates/auth_footer');
        } else {
            // validation success
            $this->_login(); //membuat function private agar tidak bisa diakses dari url
        }
    }

    private function _login()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        //query to db for check user
        $user = $this->db->get_where('user', ['email' => $email])->row_array();

        if ($user != NULL) {
            //cek active
            if ($user['is_active'] == 1) {
                //cek password
                if (password_verify($password, $user['password'])) {
                    #siapkan data
                    $data = [
                        'email' => $user['email'],
                        'role_id' => $user['role_id']
                    ];
                    #simpan ke session
                    $this->session->set_userdata($data);
                    // cek role_id
                    if ($user['role_id'] == 1) {
                        #arahkan ke controller admin
                        redirect('admin');
                    } else {
                        #arahkan ke controller user
                        redirect('user');
                    }
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">Wrong <strong>password!</strong>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button></div>');
                    redirect('auth');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">This <strong>Email</strong> has not been activated!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span></button></div>');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert"><strong>Email</strong> is not registered!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button></div>');
            redirect('auth');
        }
    }

    public function logout()
    {
        //bersihkan session
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('role_id');

        //redirect ke login
        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">You have been <strong>logged out!</strong> 
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span></button></div>');
        redirect('auth');
    }

    public function blocked()
    {
        $this->load->view('auth/blocked');
    }


    //REGISTRATION
    public function registration()
    {
        //cek session jika sudah login
        if ($this->session->userdata('email')) {
            redirect('user');
        }
        //rules (trim agar spasi tidak masuk ke db)
        $this->form_validation->set_rules('name', 'Full Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]', ['is_unique' => 'This email has already registered!']);
        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[6]|matches[password2]', ['matches' => 'password dont match!', 'min_length' => 'password too short!']);
        $this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'User Registration';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/registration');
            $this->load->view('templates/auth_footer');
        } else {
            $this->auth->addDataRegister();

            //siapkan token dengan random
            $token = base64_encode(random_bytes(32));
            $user_token = [
                'email' => $this->input->post('email', true),
                'token' => $token,
                'date_created' => time()
            ];
            //insert ke table token
            $this->db->insert('user_token', $user_token);

            //kirim email untuk aktivasi
            $this->_sendEmail($token, 'verify');
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Congratulation!</strong> your account has been created. Please activate your account
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span></button></div>');
            redirect('auth');
        }
    }

    private function _sendEmail($token, $type)
    {
        $config = [
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_user' => 'developer.iqal@gmail.com',
            'smtp_pass' => 'whoami2002',
            'smtp_port' => 465,
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'newline' => "\r\n"
        ];
        //load library
        $this->load->library('email', $config);
        $this->email->initialize($config);
        $this->email->from('developer.iqal@gmail.com', 'Developer Iqal');
        $this->email->to($this->input->post('email'));

        if ($type == 'verify') {
            $this->email->subject('Account Verification');
            $this->email->message('Click this link to verify your account : <a href="' . base_url() . 'auth/verify?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '">Activate</a>');
        } else if ($type == 'forgot') {
            $this->email->subject('Reset Password');
            $this->email->message('Click this link to reset your password : <a href="' . base_url() . 'auth/resetpassword?email=' . $this->input->post('email') . '&token=' . urlencode($token) . '">Reset Password</a>');
        }

        if ($this->email->send()) {
            return true;
        } else {
            show_error($this->email->print_debugger());
            die;
        }
    }

    public function verify()
    {
        //ambil email dan token dari url
        $email = $this->input->get('email');
        $token = $this->input->get('token');

        //cek email nya ada atau tidak
        $user = $this->db->get_where('user', ['email' => $email])->row_array();
        if ($user) {

            //cek token nya query ke table user_token
            $user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();
            if ($user_token) {

                //cek waktu
                if (time() - $user_token['date_created'] < (60 * 60 * 24)) {

                    //update table user
                    $this->db->set('is_active', 1);
                    $this->db->where('email', $email);
                    $this->db->update('user');

                    //delete user_tokennya
                    $this->db->delete('user_token', ['email' => $email]);
                    $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>' . $email . '</strong> has been activated! Please login.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button></div>');
                    redirect('auth');
                } else {

                    //hapus user dan token nya
                    $this->db->delete('user', ['email' => $email]);
                    $this->db->delete('user_token', ['email' => $email]);
                    $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">Account activation <strong>failed</strong>, Token expired. 
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button></div>');
                    redirect('auth');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">Account activation <strong>failed</strong>, Token invalid. 
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span></button></div>');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">Account activation <strong>failed</strong>, Wrong email. 
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button></div>');
            redirect('auth');
        }
    }

    public function forgotPassword()
    {
        //rules
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Forgot Password';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/forgot-password');
            $this->load->view('templates/auth_footer');
        } else {
            //ambil email dari form
            $email = $this->input->post('email');
            //cek email ada atau tidak
            $user = $this->db->get_where('user', ['email' => $email, 'is_active' => 1])->row_array();

            if ($user) {
                //create token
                $token = base64_encode(random_bytes(32));
                $user_token = [
                    'email' => $email,
                    'token' => $token,
                    'date_created' => time()
                ];
                //masukkan ke db
                $this->db->insert('user_token', $user_token);
                $this->_sendEmail($token, 'forgot');

                //kasih pesan
                $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert">Please check your <strong>Email</strong> to reset your password!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span></button></div>');
                redirect('auth/forgotpassword');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">This <strong>Email</strong> is not registered or activated!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span></button></div>');
                redirect('auth/forgotpassword');
            }
        }
    }

    public function resetPassword()
    {
        //ambil email dan token
        $email = $this->input->get('email');
        $token = $this->input->get('token');
        //cek ke db
        $user = $this->db->get_where('user', ['email' => $email])->row_array();

        if ($user) {
            //cek token
            $user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();
            if ($user_token) {
                # buat session agar halaman reset password hanya diakses ketika ada session
                $this->session->set_userdata('reset_email', $email);
                //panggil halaman nya
                $this->changePassword();
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">Reset password failed! Wrong <strong>token</strong>!
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span></button></div>');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible fade show" role="alert">Reset password failed! Wrong <strong>email</strong>!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button></div>');
            redirect('auth');
        }
    }

    public function changePassword()
    {
        //cek sessionnya
        if (!$this->session->userdata('reset_email')) {
            redirect('auth');
        }

        //rules
        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[6]|matches[password2]', ['matches' => 'password dont match!', 'min_length' => 'password too short!']);
        $this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Change Password';
            $this->load->view('templates/auth_header', $data);
            $this->load->view('auth/change-password');
            $this->load->view('templates/auth_footer');
        } else {
            //encrypt password
            $password = password_hash($this->input->post('password1'), PASSWORD_DEFAULT);
            $email = $this->session->userdata('reset_email');

            //edit table user
            $this->db->set('password', $password);
            $this->db->where('email', $email);
            $this->db->update('user');
            //hapus session
            $this->session->unset_userdata('reset_email');
            //redirect
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible fade show" role="alert"><strong>Password</strong> has been changed! Please login.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button></div>');
            redirect('auth');
        }
    }
}
