<div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

        <div class="col-xl-10 col-lg-12 col-md-9 mt-3">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-6 d-none d-lg-block bg-login-image">
                            <!-- <img width="450" height="550" src="<?= base_url('assets/'); ?>img/login.jpg"> -->
                        </div>
                        <div class="col-lg-6 mt-2">
                            <div class="p-5">
                                <div class="text-center mb-4">
                                    <!-- <h1 class="h4 text-gray-900 mb-4">Silahkan Login</h1> -->
                                    <img width="240" src="<?= base_url('assets/'); ?>img/logo.png">
                                    <p>Welcome back, please login into your account !</p>
                                </div>
                                <?= $this->session->flashdata('message'); ?>
                                <form class="user" method="post" action="<?= base_url('auth'); ?>">
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-user" id="email"
                                            name="email" placeholder="Enter Email Address..."
                                            value="<?= set_value('email'); ?>" autocomplete="off">
                                        <?= form_error('email', '<small class="text-danger pl-3">', '</small>'); ?>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user" id="password"
                                            name="password" placeholder="Password" autocomplete="off">
                                        <?= form_error('password', '<small class="text-danger pl-3">', '</small>'); ?>
                                    </div>
                                    <button type="submit" class="btn btn-login btn-user btn-block">
                                        Login
                                    </button>
                                    <hr>
                                    <a href="<?= base_url(); ?>auth/registration"
                                        class="btn btn-danger btn-user btn-block">
                                        Sign Up +
                                    </a>
                                </form>
                                <hr>
                                <div class="text-center">
                                    <a class="small" href="<?= base_url('auth/forgotpassword'); ?>">Forgot
                                        Password?</a>
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
