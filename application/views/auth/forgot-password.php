<div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

        <div class="col-lg-7 col-md-9 mt-5">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg m-2">
                            <div class="p-5">
                                <div class="text-center mb-4">
                                    <!-- <h1 class="h4 text-gray-900 mb-4">Silahkan Login</h1> -->
                                    <img width="240" src="<?= base_url('assets/'); ?>img/logo.png">
                                    <p>Forgot your password?</p>
                                </div>
                                <?= $this->session->flashdata('message'); ?>
                                <form class="user" method="post" action="<?= base_url('auth/forgotpassword'); ?>">
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-user" id="email"
                                            name="email" placeholder="Enter Email Address..."
                                            value="<?= set_value('email'); ?>" autocomplete="off">
                                        <?= form_error('email', '<small class="text-danger pl-3">', '</small>'); ?>
                                    </div>
                                    <hr>
                                    <button type="submit" class="btn btn-danger btn-user btn-block">
                                        Reset Password
                                    </button>
                                    <!-- <a href="<?= base_url(); ?>auth" class="btn btn-success btn-user btn-block">
                                        Back
                                    </a> -->
                                </form>
                                <hr>
                                <div class="text-center">
                                    <a class="small" href="<?= base_url('auth'); ?>">Back to login</a>
                                </div>
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
