<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="row border g-0 rounded shadow-sm">
    <div class="col p-1">
        <div class="col-md-12 mt-2">
            <div class="card usersprofilecard" id="usersprofilecard">
                <div class="card-header bg-dark">
                    <a href="<?php echo base_url('users') ?>" class="btn btn-danger btn-sm m-1 mb-3 float-end usersClose">رجوع
                    </a>
                    <h4 style="color: white;" id="card_usersprofile" class="card_usersprofile"> </h4>

                </div>
                <div class="card-body ">
                    <div class="row ">
                        <section style="background-color: #eee;">
                            <div class="container py-4">
                                <div class="row">
                                    <?php for ($i = 0; $i < count($userprofileinfo); $i++) : ?>
                                        <div class="col-lg-4">
                                            <div class="card mb-4">
                                                <div class="card-body text-center">
                                                    <img src="admin/assets/img/avatar.png" alt="avatar" class="rounded-circle img-fluid" style="width: 150px;">


                                                    <h5><?= $userprofileinfo[$i]->U_UserName ?></h5>

                                                    <p class="text-muted mb-1"><?= $userprofileinfo[$i]->U_Permission ?></p>
                                                    <p class="text-muted mb-4"><?= $userprofileinfo[$i]->U_State ?></p>
                                                    <p class="text-muted mb-4"><?= $userprofileinfo[$i]->U_WorkPlace ?></p>

                                                    <div class="d-flex justify-content-center mb-2">
                                                        <input type="file" class="form-control u_image" id="u_image" name="u_image"></input>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card mb-4 mb-lg-0">
                                                <div class="card-body p-0">
                                                    <ul class="list-group list-group-flush rounded-3">
                                                        <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                                            <i class="fas fa-globe fa-lg text-warning"></i>
                                                            <p class="mb-0">https://mdbootstrap.com</p>
                                                        </li>
                                                        <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                                            <i class="fab fa-github fa-lg" style="color: #333333;"></i>
                                                            <p class="mb-0">mdbootstrap</p>
                                                        </li>
                                                        <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                                            <i class="fab fa-twitter fa-lg" style="color: #55acee;"></i>
                                                            <p class="mb-0">@mdbootstrap</p>
                                                        </li>
                                                        <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                                            <i class="fab fa-instagram fa-lg" style="color: #ac2bac;"></i>
                                                            <p class="mb-0">mdbootstrap</p>
                                                        </li>
                                                        <li class="list-group-item d-flex justify-content-between align-items-center p-3">
                                                            <i class="fab fa-facebook-f fa-lg" style="color: #3b5998;"></i>
                                                            <p class="mb-0">mdbootstrap</p>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-8">
                                            <div class="card mb-4">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-sm-3">
                                                            <p class="mb-0">اسم المستخدم:</p>
                                                        </div>
                                                        <div class="col-sm-9">
                                                            <input type="text" name="u_username" id="u_username" class="form-control u_username" autocomplete="off">
                                                            <span id="error_u_username" class="text-danger"></span>
                                                            <input type="text" name="u_id" id="u_id" class="form-control u_id" autocomplete="off" value="<?= $userprofileinfo[$i]->U_ID ?>" hidden>
                                                        </div>
                                                    </div>

                                                    <div class="row mt-2">
                                                        <div class="col-sm-3">
                                                            <p class="mb-0">كلمة المرور:</p>
                                                        </div>
                                                        <div class="col-sm-9">
                                                            <input type="password" name="u_password" id="u_password" class="form-control u_password" autocomplete="off">
                                                            <span id="error_u_password" class="text-danger"></span>
                                                        </div>
                                                    </div>

                                                    <div class="row mt-2">
                                                        <div class="col-sm-3">
                                                            <p class="mb-0">حالةالمستخدم:</p>
                                                        </div>
                                                        <div class="col-sm-9">
                                                            <select name="u_state" id="u_state" class="col-sm-11 col-form-label form-select u_state">

                                                            </select>
                                                            <span id="error_u_state" class="text-danger"></span>
                                                        </div>
                                                    </div>

                                                    <div class="row mt-2">
                                                        <div class="col-sm-3">
                                                            <p class="mb-0">الصلاحية:</p>
                                                        </div>
                                                        <div class="col-sm-9">
                                                            <select name="u_permission" id="u_permission" class="col-sm-11 col-form-label form-select u_permission">

                                                            </select>
                                                            <span id="error_u_permission" class="text-danger"></span>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-2">
                                                        <div class="col-sm-3">
                                                            <p class="mb-0">مكان العمل:</p>
                                                        </div>
                                                        <div class="col-sm-9">
                                                            <select name="U_WorkPlace" id="U_WorkPlace" class="col-sm-11 col-form-label form-select U_WorkPlace">

                                                            </select>
                                                            <span id="error_U_WorkPlace" class="text-danger"></span>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="col-sm-3">
                                                        <p class="mb-0">صلاحية الحدث</p>
                                                    </div>
                                                    <div class="row mt-2">
                                                        <div class="col-sm-3">
                                                            <p class="mb-0">انشاء :</p>
                                                        </div>
                                                        <div class="col-sm-9">
                                                            <input type="text" name="p_id" id="p_id" class="form-control" hidden>
                                                            <input type="text" name="p_fk" id="p_fk" class="form-control" hidden>
                                                            <input type="checkbox" name="p_create" id="p_create" class="form-check-input" autocomplete="off">
                                                            <span id="error_p_create" class="text-danger"></span>

                                                        </div>
                                                    </div>
                                                    <div class="row mt-2">
                                                        <div class="col-sm-3">
                                                            <p class="mb-0">تحديث :</p>
                                                        </div>
                                                        <div class="col-sm-9">
                                                            <input type="checkbox" name="p_update" id="p_update" class="form-check-input" autocomplete="off">
                                                            <span id="error_p_update" class="text-danger"></span>
                                                        </div>
                                                    </div>
                                                    <div class="row mt-2">
                                                        <div class="col-sm-3">
                                                            <p class="mb-0">حذف :</p>
                                                        </div>
                                                        <div class="col-sm-9">
                                                            <input type="checkbox" name="p_delete" id="p_delete" class="form-check-input" autocomplete="off">
                                                            <span id="error_p_delete" class="text-danger"></span>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="col-sm-3">
                                                        <p class="mb-0">نطاق العمل</p>
                                                    </div>
                                                    <div class="ms-12 row">
                                                        <div class="col-sm-2">
                                                            <p class="mb-0">الداشبورد:</p>
                                                        </div>
                                                        <div class="col-sm-auto">
                                                            <input type="checkbox" name="P_Dashboard" id="P_Dashboard" class="form-check-input" autocomplete="off">
                                                        </div>

                                                        <div class="col-sm-2">
                                                            <p class="mb-0">المستخدمون :</p>
                                                        </div>
                                                        <div class="col-sm-auto">
                                                            <input type="checkbox" name="P_Users" id="P_Users" class="form-check-input" autocomplete="off">
                                                        </div>

                                                        


                                                    </div>
                                                    <div class="ms-12 row mt-2">
                                                        <div class="col-sm-2">
                                                            <p class="mb-0">التقارير:</p>
                                                        </div>
                                                        <div class="col-sm-auto">
                                                            <input type="checkbox" name="P_Reports" id="P_Reports" class="form-check-input" autocomplete="off">
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <p class="mb-0">الحالة:</p>
                                                        </div>
                                                        <div class="col-sm-auto">
                                                            <input type="checkbox" name="P_State" id="P_State" class="form-check-input" autocomplete="off">
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <p class="mb-0">نوع الوقود:</p>
                                                        </div>
                                                        <div class="col-sm-auto">
                                                            <input type="checkbox" name="P_FuelType" id="P_FuelType" class="form-check-input" autocomplete="off">
                                                        </div>
                                                       

                                                    </div>
                                                    <div class="ms-12 row mt-2">
                                                        <div class="col-sm-2">
                                                            <p class="mb-0">الصلاحية:</p>
                                                        </div>
                                                        <div class="col-sm-auto">
                                                            <input type="checkbox" name="P_Permission" id="P_Permission" class="form-check-input" autocomplete="off">
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <p class="mb-0">نوع العجلات:</p>
                                                        </div>
                                                        <div class="col-sm-auto">
                                                            <input type="checkbox" name="P_CarType" id="P_CarType" class="form-check-input" autocomplete="off">
                                                        </div>
                                                        

                                                    </div>
                                                    <div class="ms-12 row mt-2">
                                                        
                                                        <div class="col-sm-2">
                                                            <p class="mb-0" style="font-size:14px;">سلف الوقود:</p>
                                                        </div>
                                                        <div class="col-sm-auto">
                                                            <input type="checkbox" name="P_FuelMoney" id="P_FuelMoney" class="form-check-input" autocomplete="off">
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <p class="mb-0" style="font-size:14px;">سلف الصيانة:</p>
                                                        </div>
                                                        <div class="col-sm-auto">
                                                            <input type="checkbox" name="P_Maintenance" id="P_Maintenance" class="form-check-input" autocomplete="off">
                                                        </div>

                                                    </div>
                                                    <div class="ms-12 row mt-2">
                                                        
                                                        <div class="col-sm-2">
                                                            <p class="mb-0">مكان العمل:</p>
                                                        </div>
                                                        <div class="col-sm-auto" >
                                                            <input type="checkbox" name="P_WorkShopPlace" id="P_WorkShopPlace" class="form-check-input" autocomplete="off">
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <p class="mb-0">الفنيين:</p>
                                                        </div>
                                                        <div class="col-sm-auto">
                                                            <input type="checkbox" name="P_Workers" id="P_Workers" class="form-check-input" autocomplete="off">
                                                        </div>

                                                    </div>
                                                    <div class="ms-12 row mt-2">
                                                       
                                                        <div class="col-sm-2">
                                                            <p class="mb-0">الحسابات</p>
                                                        </div>
                                                        <div class="col-sm-auto">
                                                            <input type="checkbox" name="P_Accounts" id="P_Accounts" class="form-check-input" autocomplete="off">
                                                        </div>
                                                        <div class="col-sm-2">
                                                            <p class="mb-0">الزبائن:</p>
                                                        </div>
                                                        <div class="col-sm-auto">
                                                            <input type="checkbox" name="P_Customers" id="P_Customers" class="form-check-input" autocomplete="off">
                                                        </div>

                                                    </div>


                                                    <hr>
                                                    <button class="btn btn-success btn-sm m-1 userprofileSave">حفظ</button>

                                                </div>
                                            </div>

                                        </div>
                                    <?php endfor; ?>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>


<?= $this->endSection() ?>

<?= $this->section('scripts') ?>

<script>
   
</script>
<?= $this->endSection() ?>