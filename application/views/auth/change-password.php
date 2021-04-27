<div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

        <div class="col-lg-7 col-md-9 mt-4">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg m-2">
                            <div class="p-5">
                                <div class="text-center mb-2">
                                    <!-- <h1 class="h4 text-gray-900 mb-4">Silahkan Login</h1> -->
                                    <img class="mb-2" width="240" src="<?= base_url('assets/'); ?>img/logo.png">
                                    <p>Change your password for
                                        <br><strong><?= $this->session->userdata('reset_email'); ?></strong>
                                    </p>
                                </div>
                                <?= $this->session->flashdata('message'); ?>
                                <form class="user" method="post" action="<?= base_url('auth/changepassword'); ?>">
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user" id="password1"
                                            name="password1" placeholder="Enter New Password..." autocomplete="off">
                                        <?= form_error('password1', '<small class="text-danger pl-3">', '</small>'); ?>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user" id="password2"
                                            name="password2" placeholder="Repeat New Password..." autocomplete="off">
                                        <?= form_error('password2', '<small class="text-danger pl-3">', '</small>'); ?>
                                    </div>
                                    <hr>
                                    <button type="submit" class="btn btn-login btn-user btn-block">
                                        Change Password
                                    </button>
                                </form>
                                <hr>
                                <div class="text-center">
                                    <p class="small">Still have problem? <a href="#">Click Here</a></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>
