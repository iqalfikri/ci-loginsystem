<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-sidebar sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-code-branch"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Productly Admin</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider">


    <!-- QUERY MENU -->
    <!-- join table -->
    <?php

    //ambil data role_id dari data session
    $role_id = $this->session->userdata('role_id');

    //join table user_menu AND user_access_menu
    $queryMenu = "SELECT `user_menu`.`id`, `menu`
                                        FROM `user_menu` JOIN `user_access_menu` 
                                        ON `user_menu`.`id` = `user_access_menu`.`menu_id`
                                    WHERE `user_access_menu`.`role_id` = $role_id
                                ORDER BY `user_access_menu`.`menu_id` ASC
                                ";

    $menu = $this->db->query($queryMenu)->result_array();
    ?>



    <!-- LOOPING MENU -->
    <?php foreach ($menu as $m) : ?>

    <div class="sidebar-heading">
        <?= $m['menu']; ?>
    </div>

    <!-- SIAPKAN SUB-MENU SESUAI MENU -->
    <?php
        $menuId = $m['id'];
        $querySubMenu = "SELECT * FROM `user_sub_menu`
                                                WHERE `menu_id` = $menuId
                                                    AND `is_active` = 1
                                            ";
        $subMenu = $this->db->query($querySubMenu)->result_array();
        ?>

    <?php foreach ($subMenu as $sm) : ?>

    <!-- jika judul sama dengan judul submenu maka tambahkan "active" -->
    <?php if ($title == $sm['title']) : ?>
    <li class="nav-item active">
        <?php else : ?>
    <li class="nav-item">
        <?php endif; ?>
        <a class="nav-link pb-0" href="<?= base_url($sm['url']); ?>">
            <i class="<?= $sm['icon']; ?>"></i>
            <span><?= $sm['title']; ?></span></a>
    </li>
    <?php endforeach; ?>

    <!-- Divider -->
    <hr class="sidebar-divider mt-3">

    <?php endforeach; ?>

    <!-- Nav Item - System Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true"
            aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog"></i>
            <span>System</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Action :</h6>
                <a class="collapse-item" href="<?= base_url('auth/logout'); ?>" data-toggle="modal"
                    data-target="#logoutModal"><i class="fas fa-fw fa-sign-out-alt"></i>
                    <span>Logout</span></a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->
