<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="row border g-0 rounded shadow-sm ">
    <div class="col p-4">
        <div class="col-md-12 mt-2">
            <div class="card ">
                <div class="card-header bg-dark">

                    <button class="btn btn-primary btn-sm m-1 float-end workshopplaceAdd">اضافة موقع عمل
                    </button>

                    <h4 style="color: white;"><?= $title ?> </h4>

                </div>
                <div class="card-body">

                    <table id="workshopplace_data" class="table table-bordered table-striped workshopplace_data" cellspacing="0" width="100%">
                        <thead class="dataheader_workshopplace table-dark">
                            <tr>
                                <td>ت</td>
                                <td>اسم موقع العمل</td>
                                <td>حالة الموقع</td>
                                <td>رقم الموبايل</td>
                                <td>مدير الموقع</td>
                                <td>عدد الفنيين</td>
                                <td>الحدث</td>
                            </tr>
                        </thead>
                        <tbody class="databody_workshopplace">

                        </tbody>
                    </table>

                </div>
            </div>
        </div>
        <div class="col-md-12 mt-5">
            <div class="card workshopplaceaction" id="workshopplaceaction">
                <div class="card-header bg-dark">
                    <button class="btn btn-danger btn-sm m-1 mb-3 float-end workshopplaceClose">خروج
                    </button>
                    <h4 style="color: white;" id="card_workshopplacetitle" class="card_workshopplacetitle"> </h4>

                </div>
                <div class="card-body ">
                    <div class="row ">
                        <!-- <form> -->

                        <div class="col-md-12 ">
                            <div class="form-group ">
                                <div class="ms-12 row pt-3">
                                    <div class="col-sm-auto">
                                        <input type="text" name="ug_id" id="ug_id" class="form-control ug_id" hidden>

                                    </div>
                                </div>

                                <div class="ms-12 row pt-3">
                                    <label for="" class="col-sm-2 col-form-label">اسم موقع العمل :
                                    </label>
                                    <div class="col-sm-3">
                                        <input type="text" name="ug_name" id="ug_name" class="form-control ug_name" autocomplete="off">
                                        <span id="error_ug_name" class="text-danger"></span>
                                    </div>

                                </div>
                                <div class="ms-12 row pt-3">
                                    <label for="" class="col-sm-2 col-form-label"> حالة الموقع :
                                    </label>
                                    <div class="col-sm-3">
                                        <select name="ug_state" id="ug_state" class="col-sm-11 col-form-label form-select ug_state">

                                        </select>
                                        <span id="error_ug_state" class="text-danger"></span>
                                    </div>

                                </div>
                                <div class="ms-12 row pt-3">
                                    <label for="" class="col-sm-2 col-form-label"> موبايل :
                                    </label>
                                    <div class="col-sm-3">
                                        <input type="text" name="ug_mobile" id="ug_mobile" class="form-control ug_mobile" autocomplete="off">
                                        <span id="error_ug_mobile" class="text-danger"></span>
                                    </div>

                                </div>
                                <div class="ms-12 row pt-3">
                                    <label for="" class="col-sm-2 col-form-label">هاتف :
                                    </label>
                                    <div class="col-sm-3">
                                        <input type="text" name="ug_phone" id="ug_phone" class="form-control ug_phone" autocomplete="off">
                                        <span id="error_ug_phone" class="text-danger"></span>
                                    </div>

                                </div>
                                <div class="ms-12 row pt-3">
                                    <label for="" class="col-sm-2 col-form-label"> مدير الموقع :
                                    </label>
                                    <div class="col-sm-3">
                                        <input type="text" name="ug_manager" id="ug_manager" class="form-control ug_manager" autocomplete="off">
                                        <span id="error_ug_manager" class="text-danger"></span>
                                    </div>

                                </div>
                                <div class="ms-12 row pt-3">
                                    <label for="" class="col-sm-2 col-form-label"> عدد الفنيين :
                                    </label>
                                    <div class="col-sm-3">
                                        <input type="number" name="ug_techniciancount" id="ug_techniciancount" class="form-control ug_techniciancount" autocomplete="off">
                                        <span id="error_ug_techniciancount" class="text-danger"></span>
                                    </div>

                                </div>



                                <div>
                                    <?php echo '----------------------------------------------------------------------------------------' ?>
                                </div>
                                <div class="ms-12 row pt-3">
                                    <label for="" class="col-sm-2 col-form-label">ملاحظات :</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control rounded-1 ug_description" id="ug_description" name="ug_description" rows="3"></textarea>

                                    </div>
                                </div>

                                <div class="ms-12 row pt-3">
                                    <label for="" class="col-sm-2 col-form-label"> </label>
                                    <div class="col-sm-2">
                                        <button class="btn btn-primary form-control workshopplaceSave">حفظ البيانات</button>
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
    $("#workshopplaceaction").hide();
</script>


<?= $this->endSection() ?>