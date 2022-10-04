<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href=" <?php echo base_url('assets/css/bootstrap.min.css'); ?> ">
    <link rel="stylesheet" type="text/css" href=" <?php echo base_url('assets/css/dataTables.bootstrap5.min.css'); ?> ">
    <link rel="stylesheet" type="text/css" href=" <?php echo base_url('assets/css/style.css'); ?> ">
    <link rel="stylesheet" type="text/css" href=" <?php echo base_url('assets/css/bootstrap-icons.css'); ?>" />
    <link rel="stylesheet" type="text/css"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href=" <?php echo base_url('assets/css/style2.css'); ?> ">

    <title> انشاء حساب</title>
</head>

<body dir="rtl">
    <div class="container justify-content-center" style="margin-top: 100px">
        <div class="row justify-content-center">
            <div class=" col-md-7 ">

                <?php if (session()->getFlashdata('status')) : ?>
                <div class="alert alert-success"><?= session()->getFlashdata('status'); ?></div>

                <?php endif ?>
                <div class="card">
                    <div class="card-header" style="text-align: center;">
                        <h4>انشاء حساب جديد </h4>
                    </div>
                    <div class="card-body">
                        <form action="<?= base_url('auth/save') ?>" method="POST">
                            <?= csrf_field(); ?>


                            <div class="ms-12 row pt-3">
                                <label for="" class="col-sm-3 col-form-label">اسم المستخدم : </label>
                                <div class="col-sm-8">
                                    <input type="text" name="name" id="name" class="form-control" autocomplete="off"
                                        value="<?= set_value('name'); ?>">
                                    <span
                                        class="text-danger"><?= isset($validation) ? display_error($validation, 'name') : '' ?>
                                    </span>
                                </div>
                            </div>
                            <div class="ms-12 row pt-3">
                                <label for="" class="col-sm-3 col-form-label">البريد الالكتروني : </label>
                                <div class="col-sm-8">
                                    <input type="text" name="email" id="email" class="form-control" autocomplete="off"
                                        value="<?= set_value('email'); ?>">
                                    <span
                                        class="text-danger"><?= isset($validation) ? display_error($validation, 'email') : '' ?>
                                    </span>
                                </div>
                            </div>
                            <div class="ms-12 row pt-3">
                                <label for="" class="col-sm-3 col-form-label">الباسورد : </label>
                                <div class="col-sm-8">
                                    <input type="password" name="password" id="password" class="form-control"
                                        autocomplete="off" value="<?= set_value('password'); ?>">
                                    <span
                                        class="text-danger"><?= isset($validation) ? display_error($validation, 'password') : '' ?>
                                    </span>
                                </div>
                            </div>

                            <div class="ms-12 row pt-3">
                                <label for="" class="col-sm-3 col-form-label">تأكيد الباسورد : </label>
                                <div class="col-sm-8">
                                    <input type="password" name="cpassword" id="cpassword" class="form-control"
                                        autocomplete="off" value="<?= set_value('cpassword'); ?>">
                                    <span
                                        class="text-danger"><?= isset($validation) ? display_error($validation, 'cpassword') : '' ?>
                                    </span>
                                </div>
                            </div>

                            
                            <div class="ms-12 row pt-3">
                                <label for="" class="col-sm-3 col-form-label"> </label>
                                <div class="col-sm-6">
                                    <input class="btn btn-primary form-control" type="submit" value="تسجيل الحساب ">
                                </div>
                            </div>
                            <div class="form-group p-3">
                                <div class="row" style="text-align: center;">
                                    <a href="<?= base_url('auth') ?>">تسجيل الدخول </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>




            </div>


        </div>





        <script src="<?php echo base_url('assets/js/bootstrap.bundle.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/dataTables.bootstrap5.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery-3.5.1.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/script.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery.dataTable.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/chart.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/popper.min.js'); ?>"></script>

</body>

</html>