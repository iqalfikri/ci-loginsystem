<?php

class Auth_model extends CI_Model
{
    public function addDataRegister()
    {
        //siapkan data user
        $data = [
            'name' => htmlspecialchars($this->input->post('name', true)),
            'email' => htmlspecialchars($this->input->post('email', true)),
            'image' => 'default.jpg',
            'password' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
            'role_id' => 2,
            'is_active' => 0,
            'date_created' => time()
        ];

        //insert ke table user
        $this->db->insert('user', $data);
    }

    public function getUserByEmail()
    {
    }
}
