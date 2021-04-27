<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    <div class="row">
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 mb-3">
                    <b>Profile User</b>
                </div>
                <div class=" card-body">
                    <!-- <div class="card mb-3" style="max-width: 540px;"> -->
                    <div class="row no-gutters">
                        <div class="col-md-4 offset-md-1 mb-2">
                            <img src="<?= base_url('assets/img/profile/') . $user['image']; ?>" class="card-img">
                        </div>
                        <div class="col-md-6 offset-md-1 mt-4">
                            <div class="card-body">
                                <h5 class="card-title"><b><?= $user['name']; ?></b></h5>
                                <p class="card-text"><?= $user['email']; ?></p>
                                <p class="card-text"><small class="text-muted">Member since
                                        <?= date('d F Y', $user['date_created']); ?></small></p>
                            </div>
                        </div>
                    </div>
                    <!-- </div> -->
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-5">
            <?= $this->session->flashdata('message'); ?>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

</div>
<!-- End of Main Content -->
