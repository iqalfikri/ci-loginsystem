<?php

function is_logged_in()
{
    //ambil function ci dengan get_instance untuk mengantikan fungsi "$this"
    $ci = get_instance();

    //cek dia sudah login atau belum dan cek role dia apa
    if (!$ci->session->userdata('email')) {
        redirect('auth');
    } else {
        //ambil role id nya dari session
        $role_id = $ci->session->userdata('role_id');

        //untuk mengetahui sedang di controller mana ambil dari url
        $menu = $ci->uri->segment(1);

        //query tabel menu untuk mendapatkan menu_id
        $queryMenu = $ci->db->get_where('user_menu', ['menu' => $menu])->row_array();

        //ambil id
        $menu_id = $queryMenu['id'];

        //query user_accsess nya
        $user_Access = $ci->db->get_where('user_access_menu', [
            'role_id' => $role_id,
            'menu_id' => $menu_id
        ]);

        if ($user_Access->num_rows() <  1) {
            redirect('auth/blocked');
        }
    }
}

function check_access($role_id, $menu_id)
{
    //ambil function ci dengan get_instance untuk mengantikan fungsi "$this"
    $ci = get_instance();

    //query ke table user_access_menu sesuai role_id dan menu_id
    $result = $ci->db->get_where('user_access_menu', ['role_id' => $role_id, 'menu_id' => $menu_id]);

    //cek jika results ada barisnya
    if ($result->num_rows() > 0) {
        //kalau ada tinggal di ceklis
        return "checked='checked'";
    }
}
