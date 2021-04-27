<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row">
        <div class="col-lg">
            <div class="card shadow mb-4">
                <div class="card-header py-3 mb-3">
                    <b>Menu Settings</b>
                </div>
                <?php if (validation_errors()) : ?>
                <div class="alert alert-danger alert-dismissible fade show col-sm-10 ml-3" role="alert">
                    <?= validation_errors(); ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                </div>
                <?php endif; ?>
                <?= form_error('menu', '<div class="alert alert-danger alert-dismissible fade show col-sm-10 ml-3" role="alert">', '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>'); ?>
                <?= $this->session->flashdata('message'); ?>
                <div class="col-sm-4 ml-2">
                    <a href="" class="btn btn-login btn-sm" data-toggle="modal" data-target="#newSubMenuModal">Add New
                        Sub-Menu</a>
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Title</th>
                                <th scope="col">Menu</th>
                                <th scope="col">Url</th>
                                <th scope="col">Icon</th>
                                <th scope="col">Active</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <?php foreach ($subMenu as $sm) : ?>
                            <tr>
                                <th scope="row"><?= $i ?></th>
                                <td><?= $sm['title'] ?></td>
                                <td><?= $sm['menu'] ?></td>
                                <td><?= $sm['url'] ?></td>
                                <td><?= $sm['icon'] ?></td>
                                <td><?= $sm['is_active'] ?></td>
                                <td>
                                    <a href="" data-toggle="modal" data-target="#eeditSubMenuModal<?= $sm['id'] ?>"
                                        class="badge badge-success">edit</a>
                                    <a href="<?= base_url(); ?>menu/deletesubmenu/<?= $sm['id']; ?>"
                                        class="badge badge-danger delete-menu">delete</a>
                                </td>
                            </tr>
                            <?php $i++ ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<!-- Modal Add New Sub Menu -->
<div class="modal fade" id="newSubMenuModal" tabindex="-1" role="dialog" aria-labelledby="newSubMenuModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newSubMenuModalLabel">Add New Sub-Menu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('menu/submenu'); ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" id="title" name="title" placeholder="Sub-menu title">
                    </div>
                    <div class="form-group">
                        <select name="menu_id" id="menu_id" class="form-control">
                            <option value="">Select Menu</option>
                            <?php foreach ($menu as $m) : ?>
                            <option value="<?= $m['id'] ?>"><?= $m['menu'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="url" name="url" placeholder="Sub-menu url">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="icon" name="icon" placeholder="Sub-menu icon">
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" name="is_active" id="is_active"
                                checked>
                            <label class="form-check-label" for="is_active">
                                Active?
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-login">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Modal -->
<?php foreach ($subMenu as $esm) : ?>
<div class="modal fade" id="eeditSubMenuModal<?= $esm['id'] ?>" tabindex="-1" role="dialog"
    aria-labelledby="eeditSubMenuModal<?= $esm['id'] ?>Label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eeditSubMenuModal<?= $esm['id'] ?>Label"> Edit Sub Menu</h5>
                <buttond type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </buttond>
            </div>
            <form action="<?= base_url('menu/editSubmenu/' . $esm['id']); ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" value="<?= $esm['title'] ?>" id="title" name="title"
                            placeholder="Submenu title">
                    </div>
                    <div class="form-group">
                        <select name="menu_id" id="menu_id" class="form-control">
                            <option>Select Menu</option>
                            <?php foreach ($menu as $mm) : ?>
                            <?php if ($esm['menu_id'] == $mm['id']) : ?>
                            <option value="<?= $mm['id']; ?>" selected> <?= $mm['menu']; ?> </option>
                            <?php else : ?>
                            <option value="<?= $mm['id']; ?>"> <?= $mm['menu']; ?> </option>
                            <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" value="<?= $esm['url'] ?>" id="url" name="url"
                            placeholder="Submenu url">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" value="<?= $esm['icon'] ?>" id="icon" name="icon"
                            placeholder="Submenu icon">
                    </div>
                    <div class="form-group">
                        <div class="form-check">
                            <?php if ($esm['is_active'] == 1) : ?>
                            <input class="form-check-input" type="checkbox" value="1" name="is_active"
                                id="is_active<?= $esm['id'] ?>" checked>
                            <?php else : ?>
                            <input class="form-check-input" type="checkbox" value="1" name="is_active"
                                id="is_active<?= $esm['id'] ?>">
                            <?php endif; ?>
                            <label class="form-check-label" for="is_active<?= $esm['id'] ?>">
                                Active?
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-login">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endforeach; ?>
<!-- End Edit Modal -->
