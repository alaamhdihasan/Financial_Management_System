<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="row border g-0 rounded shadow-sm ">
    <div class="col p-4">
        <div class="col-md-12 mt-2">
            <div class="card ">
                <div class="card-header bg-dark">

                    <button class="btn btn-primary btn-sm m-1 float-end permissionAdd">اضافة صلاحية
                    </button>

                    <h4 style="color: white;"><?= $title ?> </h4>

                </div>
                <div class="card-body">

                    <table id="permission_data" class="table table-bordered table-striped permission_data" cellspacing="0" width="100%">
                        <thead class="dataheader_permission table-dark">
                            <tr>
                                <td>ت</td>
                                <td>اسم الصلاحية</td>
                                <td>الحدث</td>
                            </tr>
                        </thead>
                        <tbody class="databody_permission">

                        </tbody>
                    </table>

                </div>
            </div>
        </div>
        <div class="col-md-12 mt-5">
            <div class="card permissionaction" id="permissionaction">
                <div class="card-header bg-dark">
                    <button class="btn btn-danger btn-sm m-1 mb-3 float-end permissionClose">اغلاق
                    </button>
                    <h4 style="color: white;" id="card_permissiontitle" class="card_permissiontitle"> </h4>

                </div>
                <div class="card-body ">
                    <div class="row ">
                        <!-- <form> -->

                        <div class="col-md-12 ">
                            <div class="form-group ">
                                <div class="ms-12 row pt-3">
                                    <div class="col-sm-auto">
                                        <input type="text" name="pe_id" id="pe_id" class="form-control pe_id" hidden>

                                    </div>
                                </div>

                                <div class="ms-12 row pt-3">
                                    <label for="" class="col-sm-2 col-form-label"> اسم الصلاحية :
                                    </label>
                                    <div class="col-sm-3">
                                        <input type="text" name="pe_name" id="pe_name" class="form-control pe_name" autocomplete="off">
                                        <span id="error_pe_name" class="text-danger"></span>
                                    </div>

                                </div>




                                <div>
                                    <?php echo '----------------------------------------------------------------------------------------' ?>

                                    <div class="ms-12 row pt-3">
                                        <label for="" class="col-sm-2 col-form-label"> </label>
                                        <div class="col-sm-2">
                                            <button class="btn btn-primary form-control permissionSave">حفظ البيانات</button>
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
        $("#permissionaction").hide();    
    </script>


    <?= $this->endSection() ?>