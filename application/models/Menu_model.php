<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu_model extends CI_Model
{
    //MENU
    public function deleteMenu($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('user_menu');
    }

    public function getEditMenuById($id)
    {
        $query = $this->db->get_where('user_menu', array('id' => $id));
        //result to array
        return $query->row_array();
    }

    public function editMenu()
    {
        $data = [
            "menu" => $this->input->post('menu', true)
        ];

        $this->db->where('id', $this->input->post('id'));
        $this->db->update('user_menu', $data);
    }

    //SUB-MENU
    public function addSubMenu()
    {
        $data = [
            'title ' => htmlspecialchars($this->input->post('title', true)),
            'menu_id' => htmlspecialchars($this->input->post('menu_id', true)),
            'url ' => htmlspecialchars($this->input->post('url', true)),
            'icon ' => htmlspecialchars($this->input->post('icon', true)),
            'is_active ' => htmlspecialchars($this->input->post('is_active', true))
        ];
        $this->db->insert('user_sub_menu', $data);
    }

    public function getSubMenu()
    {
        $query = "SELECT `user_sub_menu`.*, `user_menu`.`menu`
                            FROM `user_sub_menu`JOIN `user_menu`
                            ON `user_sub_menu`.`menu_id` = `user_menu`.`id`
                        ";
        //query
        return $this->db->query($query)->result_array();
    }

    public function delSubMenu($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('user_sub_menu');
    }

    public function saveSubMenu($id)
    {
        $data = array(
            'menu_id' => $this->input->post('menu_id'),
            'title' => $this->input->post('title'),
            'url' => $this->input->post('url'),
            'icon' => $this->input->post('icon'),
            'is_active' => $this->input->post('is_active')
        );
        $this->db->where('id', $id);
        $this->db->update('user_sub_menu', $data);
    }
}
