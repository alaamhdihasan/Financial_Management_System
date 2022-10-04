<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="row border g-0 rounded shadow-sm ">
    <div class="col p-4">
        <!-- JobCard Mainly -->
        <div class="col-md-12 mt-2">
            <div class="card ">
                <div class="card-header text-white" style="background-color: #343A40;">

                    <button class="btn btn-primary btn-sm m-1 float-end MaintenanceAdd">اضافة سلفة صيانة
                    </button>

                    <h4 style="color: white;"><?= $title ?> </h4>


                </div>
                <div class="card-body">
                    <div class="ms-12 row pt-1 pb-3">
                        <label for="" class="col-sm-auto col-form-label">تصفية :
                        </label>
                        <div class="col-sm-3">
                            <select name="Ma_Filter" id="Ma_Filter" class="col-sm-11 col-form-label form-select Ma_Filter">
                                <option value="Inactive">Inactive</option>
                                <option value="Active">Active</option>
                            </select>
                        </div>

                    </div>
                    <!-- <script>
                    console.log($('#Ma_Filter option:selected').text());
                </script> -->

                    <table id="Maintenance_data" class="table table-bordered table-striped Maintenance_data" cellspacing="0" width="100%">
                        <thead class="dataheader_Maintenance table-dark">
                            <tr>
                                <td>ت </td>
                                <td>رقم السلفة</td>
                                <td>تاريخ</td>
                                <td>الحالة</td>
                                <td>الحدث</td>
                            </tr>
                        </thead>
                        <tbody class="databody_Maintenance">

                        </tbody>
                    </table>
                    <div class="col-md-12" id="buttonHolder"></div>
                </div>
            </div>
        </div>
        <div class="col-md-12 mt-5">
            <div class="card Maintenanceaction" id="Maintenanceaction">
                <div class="card-header text-white" style="background-color: #343A40;">
                    <button class="btn btn-danger btn-sm m-1 mb-3 float-end MaintenanceClose">close
                    </button>
                    <h4 style="color: white;" id="card_Maintenancetitle" class="card_Maintenancetitle"> </h4>

                </div>
                <div class="card-body ">
                    <div class="row ">

                        <div class="col-md-12 ">
                            <div class="form-group ">
                                <div class="ms-12 row pt-3">
                                    <div class="col-sm-auto">
                                        <input type="text" name="Ma_ID" id="Ma_ID" class="form-control Ma_ID" hidden>

                                    </div>
                                </div>

                                <div class="ms-12 row pt-3">
                                    <label for="" class="col-sm-1 col-form-label">رقم السلفة :
                                    </label>
                                    <div class="col-sm-2">
                                        <input type="text" name="Ma_Number" id="Ma_Number" class="form-control Ma_Number" autocomplete="off" disabled style="border:gainsboro 1px solid;">
                                        <span id="error_Ma_Number" class="text-danger"></span>
                                    </div>

                                    <label for="" class="col-sm-1 col-form-label">تاريخ السلفة :
                                    </label>
                                    <div class="col-sm-2">
                                        <input type="date" name="Ma_Date" id="Ma_Date" class="form-control Ma_Date" autocomplete="off">
                                        <span id="error_Ma_Date" class="text-danger"></span>
                                    </div>

                                    <label for="" class="col-sm-1 col-form-label"> الحالة :
                                    </label>
                                    <div class="col-sm-2">
                                        <select name="Ma_State" id="Ma_State" class="col-sm-11 col-form-label form-select Ma_State">

                                        </select>
                                        <span id="error_Ma_State" class="text-danger"></span>
                                    </div>


                                </div>
                                <hr>

                                <div class="ms-12 row pt-6">
                                    <div class="col-sm-1">
                                        <button class="btn btn-primary form-control MaintenanceSave">حفظ </button>

                                    </div>
                                    <div class="col-sm-2">
                                        <button class="btn text-white form-control MaintenanceItem" style="background-color: #343A40;" disabled> وصولات</button>

                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- JobCard Secondary.... -->
        <div class="col-md-12 mt-2">
            <div class="card Maintenance2card" id="Maintenance2card">
                <div class="card-header " style="background-color: #343A40;">

                    <button class="btn btn-primary btn-sm m-1 float-end Maintenance2Add">اضافة وصل
                    </button>
                    <h4 style="color: white;"><?= $title ?> </h4>

                </div>
                <div class="card-body">

                    <table id="Maintenance2_data" class="table table-bordered table-striped Maintenance2_data" cellspacing="0" width="100%">
                        <thead class="dataheader_Maintenance2 table-dark">
                            <tr>
                                <td>ت</td>
                                <td>تاريخ</td>
                                <td>المبلغ</td>
                                <td>رقم العجلة</td>
                                <td>نوع العجلة</td>
                                <td>تفاصيل</td>
                                <td>الحدث</td>
                            </tr>
                        </thead>
                        <tbody class="databody_Maintenance2">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-12 mt-5">
            <div class="card Maintenance2action" id="Maintenance2action">
                <div class="card-header" style="background-color: #343A40;">
                    <button class="btn btn-danger btn-sm m-1 mb-3 float-end Maintenance2Close">close
                    </button>
                    <h4 style="color: white;" id="card_Maintenance2title" class="card_Maintenance2title"> </h4>

                </div>
                <div class="card-body ">
                    <div class="row ">

                        <div class="col-md-12 ">
                            <div class="form-group ">
                                <div class="ms-12 row pt-3">
                                    <div class="col-sm-auto">
                                        <input type="text" name="Ma2_ID" id="Ma2_ID" class="form-control Ma2_ID" hidden>
                                        <input type="text" name="Ma2_FK_Ma" id="Ma2_FK_Ma" class="form-control Ma2_FK_Ma" hidden>

                                    </div>
                                </div>

                                <div class="ms-12 row pt-3">

                                    <label for="" class="col-sm-2 col-form-label"> التاريخ :
                                    </label>
                                    <div class="col-sm-auto">
                                        <input type="date" name="Ma2_Date" id="Ma2_Date" class="form-control Ma2_Date" autocomplete="off">
                                        <span id="error_Ma2_Date" class="text-danger"></span>
                                    </div>
                                </div>
                                <div class="ms-12 row pt-3">

                                    <label for="" class="col-sm-2 col-form-label"> المبلغ :
                                    </label>
                                    <div class="col-sm-auto">
                                        <input type="text" name="Ma2_Money" id="Ma2_Money" class="form-control Ma2_Money" autocomplete="off">
                                        <span id="error_Ma2_Money" class="text-danger"></span>
                                    </div>

                                </div>

                                <div class="ms-12 row pt-3">

                                    <label for="" class="col-sm-2 col-form-label"> رقم العجلة :
                                    </label>
                                    <div class="col-sm-auto">
                                        <input list="Ma2_CarNoBrowser" class="form-control Ma2_CarNo" id="Ma2_CarNo" placeholder="Type to search...">
                                        <datalist id="Ma2_CarNoBrowser">

                                        </datalist>
                                        <span id="error_Ma2_CarNo" class="text-danger"></span>
                                    </div>


                                </div>
                                <div class="ms-12 row pt-3">

                                    <label for="" class="col-sm-2 col-form-label"> نوع العجلة :
                                    </label>
                                    <div class="col-sm-auto">
                                        <input list="Ma2_CarTypeBrowser" class="form-control Ma2_CarType" id="Ma2_CarType" placeholder="Type to search...">
                                        <datalist id="Ma2_CarTypeBrowser">

                                        </datalist>
                                        <span id="error_Ma2_CarType" class="text-danger"></span>
                                    </div>


                                </div>

                                <div class="ms-12 row pt-3">
                                    <label for="" class="col-sm-2 col-form-label"> تفاصيل :
                                    </label>

                                    <div class="col-sm-9">
                                        <textarea class="form-control rounded-1 Ma2_Notes" id="Ma2_Notes" name="Ma2_Notes" rows="3"></textarea>
                                        <span id="error_Ma2_Notes" class="text-danger"></span>
                                    </div>


                                </div>


                            </div>

                            <hr>

                            <div class="ms-12 row pt-6">
                                <div class="col-sm-1">
                                    <button class="btn btn-primary form-control Maintenance2Save">حفظ </button>

                                </div>

                            </div>



                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>



</div>

</div>





<?= $this->endSection() ?>

<?= $this->section('scripts') ?>

<script>
    $("#Maintenanceaction").hide();
    $("#Maintenance2action").hide();
    $("#Maintenance2card").hide();
</script>


<?= $this->endSection() ?>