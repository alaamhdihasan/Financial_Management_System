<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href=" <?php echo base_url('admin/assets/css/bootstrap.min.css'); ?> ">
    <link rel="stylesheet" type="text/css" href=" <?php echo base_url('admin/assets/css/dataTables.bootstrap5.min.css'); ?> ">
    <link rel="stylesheet" type="text/css" href=" <?php echo base_url('admin/assets/css/style.css'); ?> ">
    <link rel="stylesheet" type="text/css" href=" <?php echo base_url('admin/assets/css/bootstrap-icons.css'); ?>" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href=" <?php echo base_url('admin/assets/css/style2.css'); ?> ">
    
    <title>تسجيل الدخول</title>
</head>

<body dir="rtl">
    <div class="container justify-content-center" style="margin-top: 150px">
        <div class="row justify-content-center">
            <div class=" col-md-4 ">
                <?php if (session()->getFlashdata('status')) : ?>
                    <div class="alert alert-danger"><?= session()->getFlashdata('status'); ?></div>

                <?php endif ?>
                <div class="card">
                    <div class="card-header" style="text-align: center;">
                        <h4>تسجيل الدخول</h4>
                    </div>
                    <div class="card-body">
                        <form action="<?= base_url('Auth/check') ?>" method="POST">
                            <?= csrf_field(); ?>
                            <div class="form-group">
                                <label for="">اسم المستخدم :</label>
                                <input type="text" class="form-control" name="u_username" placeholder="ادخل اسم المستخدم " autocomplete="off" value="<?= set_value('u_username'); ?>">
                                <span class="text-danger"><?= isset($validation) ? display_error($validation, 'u_username') : '' ?></span>
                            </div>
                            <div class="form-group">
                                <label for="">كلمة المرور:</label>
                                <input type="password" class="form-control" placeholder="ادخل كلمة المرور" name="u_password" autocomplete="off" value="<?= set_value('u_password'); ?>">
                                <span class="text-danger"><?= isset($validation) ? display_error($validation, 'u_password') : '' ?></span>
                            </div>
                            <div class="ms-12 row pt-3">
                                <label for="" class="col-sm-3 col-form-label"> </label>
                                <div class="col-sm-6">
                                    <input class="btn btn-primary form-control" type="submit" value="دخول ">
                                </div>
                            </div>

                            <!-- <div class="form-group p-3">
                                <div class="row" style="text-align: center;">
                                    <a href="<?= base_url('auth/registers') ?>">انشاء حساب جديد</a>
                                </div>
                            </div> -->
                        </form>
                    </div>
                </div>




            </div>


        </div>

        <!-- <script src="<?php echo base_url('admin/assets/js/bootstrap.bundle.min.js'); ?>"></script>
    <script src="<?php echo base_url('admin/assets/js/dataTables.bootstrap5.min.js'); ?>"></script>
    <script src="<?php echo base_url('admin/assets/js/jquery-3.5.1.js'); ?>"></script>
    <script src="<?php echo base_url('admin/assets/js/script.js'); ?>"></script>
    <script src="<?php echo base_url('admin/assets/js/jquery.dataTable.min.js'); ?>"></script>
    <script src="<?php echo base_url('admin/assets/js/chart.min.js'); ?>"></script>
    <script src="<?php echo base_url('admin/assets/js/popper.min.js'); ?>"></script> -->






</body>

</html>