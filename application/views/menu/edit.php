<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row">
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 mb-3">
                    <b>Edit Menu Settings</b>
                </div>
                <div class="card-body">
                    <form action="" method="post">
                        <input type="hidden" name="id" value="<?= $menu['id']; ?>" id="id">
                        <div class="form-group">
                            <label for="nama">Edit Menu Management</label>
                            <input type="text" class="form-control" id="menu" name="menu" autocomplete="off"
                                value="<?= $menu['menu']; ?>">
                        </div>
                </div>
                <div class="card-footer">
                    <div class="col-md-4 offset-md-8">
                        <a href="<?= base_url(); ?>menu" class="btn btn-secondary">Close</a>
                        <button type="submit" name="edit" class="btn btn-login">Save Changes</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-5">
            <?= form_error('menu', '<div class="alert alert-danger alert-dismissible fade show col-sm-10 ml-3" role="alert">', '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>'); ?>
            <?= $this->session->flashdata('message'); ?>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
