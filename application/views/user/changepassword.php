<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    <div class="row">
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 mb-2">
                    <b>Change Password User</b>
                </div>
                <div class=" card-body">
                    <form action="<?= base_url('user/changepassword'); ?>" method="POST">
                        <div class="form-group">
                            <label for="current_password">Current Password</label>
                            <input type="password" class="form-control" id="current_password" name="current_password">
                            <?= form_error('current_password', '<small class="text-danger pl-2">', '</small>'); ?>
                        </div>
                        <div class="form-group">
                            <label for="new_password1">New Password</label>
                            <input type="password" class="form-control" id="new_password1" name="new_password1">
                            <?= form_error('new_password1', '<small class="text-danger pl-2">', '</small>'); ?>
                        </div>
                        <div class="form-group">
                            <label for="new_password2">Repeat Password</label>
                            <input type="password" class="form-control" id="new_password2" name="new_password2">
                            <?= form_error('new_password2', '<small class="text-danger pl-2">', '</small>'); ?>
                        </div>
                </div>
                <div class="card-footer">
                    <div class="col-md-4 offset-md-9">
                        <button type="submit" class="btn btn-login">Change Password</button>
                    </div>
                </div>
            </div>
            </form>
        </div>
        <div class="col-xl-4 col-lg-5">
            <?= $this->session->flashdata('message'); ?>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
