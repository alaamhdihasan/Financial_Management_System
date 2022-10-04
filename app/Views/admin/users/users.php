<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>
<?= $table ?>
<div class="row border g-0 rounded shadow-sm ">
    <div class="col p-4">
        <div class="col-md-12 mt-2">
            <div class="card ">
                <div class="card-header bg-dark">

                    <button class="btn btn-primary btn-sm m-1 float-end usersAdd">اضافة مستخدم
                    </button>

                    <h4 style="color: white;"> المستخدمون </h4>

                </div>
                <div class="card-body">

                    <table id="users_data" class="table table-bordered table-striped users_data" cellspacing="0" width="100%">
                        <thead class="dataheader_users table-dark">
                            <tr>
                                <td>تسلسل</td>
                                <td>اسم المستخدم</td>
                                <td>حالة المستخدم</td>
                                <td> الصلاحية</td>
                                <td>الحدث</td>
                            </tr>
                        </thead>
                        <tbody class="databody_users">

                        </tbody>
                    </table>

                </div>
            </div>
        </div>
        <div class="col-md-12 mt-5">
            <div class="card usersaction" id="usersaction">
                <div class="card-header bg-dark">
                    <button class="btn btn-danger btn-sm m-1 mb-3 float-end usersClose">خروج
                    </button>
                    <h4 style="color: white;" id="card_userstitle" class="card_userstitle"> </h4>

                </div>
                <div class="card-body ">
                    <div class="row ">
                        <!-- <form> -->

                        <div class="col-md-12 ">
                            <div class="form-group ">
                                <div class="ms-12 row pt-3">
                                    <div class="col-sm-auto">
                                        <input type="text" name="u_id" id="u_id" class="form-control u_id" >

                                    </div>
                                </div>

                                <div class="ms-12 row pt-3">
                                    <label for="" class="col-sm-2 col-form-label"> اسم المستخدم :
                                    </label>
                                    <div class="col-sm-3">
                                        <input type="text" name="u_username" id="u_username" class="form-control u_username" autocomplete="off">
                                        <span id="error_u_username" class="text-danger"></span>
                                    </div>

                                </div>
                                <div class="ms-12 row pt-3">
                                    <label for="" class="col-sm-2 col-form-label"> كلمة المرور :
                                    </label>
                                    <div class="col-sm-3">
                                        <input type="password" name="u_password" id="u_password" class="form-control u_password" autocomplete="off">
                                        <span id="error_u_password" class="text-danger"></span>
                                    </div>

                                </div>


                                <div class="ms-12 row pt-3">

                                    <label for="" class="col-sm-2 col-form-label"> الحالة :
                                    </label>
                                    <div class="col-sm-3">
                                        <select name="u_state" id="u_state" class="col-sm-11 col-form-label form-select u_state">
                                            
                                        </select>
                                        <span id="error_u_state" class="text-danger"></span>
                                    </div>
                                </div>

                                <div class="ms-12 row pt-3">

                                    <label for="" class="col-sm-2 col-form-label"> الصلاحية :
                                    </label>
                                    <div class="col-sm-3">
                                        <select name="u_permission" id="u_permission" class="col-sm-11 col-form-label form-select u_permission">
                                            
                                        </select>
                                        <span id="error_u_permission" class="text-danger"></span>
                                    </div>
                                </div>
                                <div class="ms-12 row pt-3">

                                    <label for="" class="col-sm-2 col-form-label"> مكان العمل :
                                    </label>
                                    <div class="col-sm-3">
                                        <select name="U_WorkPlace" id="U_WorkPlace" class="col-sm-11 col-form-label form-select U_WorkPlace">
                                            
                                        </select>
                                        <span id="error_U_WorkPlace" class="text-danger"></span>
                                    </div>
                                </div>




                                <div>
                                    <?php echo '----------------------------------------------------------------------------------------' ?>
                                </div>

                                <div class="ms-12 row pt-3">
                                    <label for="" class="col-sm-2 col-form-label"> </label>
                                    <div class="col-sm-2">
                                        <button class="btn btn-primary form-control usersSave">حفظ</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- </form> -->
                    </div>
                </div>
            </div>
        </div>



    </div>

</div>



<?= $this->endSection() ?>

<?= $this->section('scripts') ?>

<script>
 $("#usersaction").hide();
</script>


<?= $this->endSection() ?>