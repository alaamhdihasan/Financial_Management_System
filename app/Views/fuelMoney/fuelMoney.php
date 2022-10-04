<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="row border g-0 rounded shadow-sm ">
    <div class="col p-4">
        <!-- JobCard Mainly -->
        <div class="col-md-12 mt-2">
            <div class="card ">
                <div class="card-header text-white" style="background-color: #343A40;">

                    <button class="btn btn-primary btn-sm m-1 float-end fuelMoneyAdd">اضافة سلفة وقود
                    </button>

                    <h4 style="color: white;"><?= $title ?> </h4>


                </div>
                <div class="card-body">
                    <div class="ms-12 row pt-1 pb-3">
                        <label for="" class="col-sm-auto col-form-label">تصفية :
                        </label>
                        <div class="col-sm-3">
                            <select name="Fm_Filter" id="Fm_Filter" class="col-sm-11 col-form-label form-select Fm_Filter">
                                <option value="Inactive">Inactive</option>
                                <option value="Active">Active</option>
                            </select>
                        </div>

                    </div>
                    <!-- <script>
                    console.log($('#Fm_Filter option:selected').text());
                </script> -->

                    <table id="fuelMoney_data" class="table table-bordered table-striped fuelMoney_data" cellspacing="0" width="100%">
                        <thead class="dataheader_fuelMoney table-dark">
                            <tr>
                                <td>ت </td>
                                <td>رقم السلفة</td>
                                <td>تاريخ</td>
                                <td>الحالة</td>
                                <td>الحدث</td>
                            </tr>
                        </thead>
                        <tbody class="databody_fuelMoney">

                        </tbody>
                    </table>
                    <div class="col-md-12" id="buttonHolder"></div>
                </div>
            </div>
        </div>
        <div class="col-md-12 mt-5">
            <div class="card fuelMoneyaction" id="fuelMoneyaction">
                <div class="card-header text-white" style="background-color: #343A40;">
                    <button class="btn btn-danger btn-sm m-1 mb-3 float-end fuelMoneyClose">close
                    </button>
                    <h4 style="color: white;" id="card_fuelMoneytitle" class="card_fuelMoneytitle"> </h4>

                </div>
                <div class="card-body ">
                    <div class="row ">

                        <div class="col-md-12 ">
                            <div class="form-group ">
                                <div class="ms-12 row pt-3">
                                    <div class="col-sm-auto">
                                        <input type="text" name="Fm_ID" id="Fm_ID" class="form-control Fm_ID" hidden>

                                    </div>
                                </div>

                                <div class="ms-12 row pt-3">
                                    <label for="" class="col-sm-1 col-form-label">رقم السلفة :
                                    </label>
                                    <div class="col-sm-2">
                                        <input type="text" name="Fm_Number" id="Fm_Number" class="form-control Fm_Number" autocomplete="off" disabled style="border:gainsboro 1px solid;">
                                        <span id="error_Fm_Number" class="text-danger"></span>
                                    </div>

                                    <label for="" class="col-sm-1 col-form-label">تاريخ السلفة :
                                    </label>
                                    <div class="col-sm-2">
                                        <input type="date" name="Fm_Date" id="Fm_Date" class="form-control Fm_Date" autocomplete="off">
                                        <span id="error_Fm_Date" class="text-danger"></span>
                                    </div>

                                    <label for="" class="col-sm-1 col-form-label"> الحالة :
                                    </label>
                                    <div class="col-sm-2">
                                        <select name="Fm_State" id="Fm_State" class="col-sm-11 col-form-label form-select Fm_State">

                                        </select>
                                        <span id="error_Fm_State" class="text-danger"></span>
                                    </div>


                                </div>
                                <hr>

                                <div class="ms-12 row pt-6">
                                    <div class="col-sm-1">
                                        <button class="btn btn-primary form-control fuelMoneySave">حفظ البيانات</button>

                                    </div>
                                    <div class="col-sm-2">
                                        <button class="btn text-white form-control fuelMoneyItem" style="background-color: #343A40;" disabled> وصولات</button>

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
            <div class="card fuelMoney2card" id="fuelMoney2card">
                <div class="card-header " style="background-color: #343A40;">

                    <button class="btn btn-primary btn-sm m-1 float-end fuelMoney2Add">اضافة وصل
                    </button>
                    <h4 style="color: white;"><?= $title ?> </h4>

                </div>
                <div class="card-body">

                    <table id="fuelMoney2_data" class="table table-bordered table-striped fuelMoney2_data" cellspacing="0" width="100%">
                        <thead class="dataheader_fuelMoney2 table-dark">
                            <tr>
                                <td>ت</td>
                                <td>تاريخ</td>
                                <td>المبلغ</td>
                                <td>رقم العجلة</td>
                                <td>نوع العجلة</td>
                                <td>العداد</td>
                                <td>الحدث</td>
                            </tr>
                        </thead>
                        <tbody class="databody_fuelMoney2">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-12 mt-5">
            <div class="card fuelMoney2action" id="fuelMoney2action">
                <div class="card-header" style="background-color: #343A40;">
                    <button class="btn btn-danger btn-sm m-1 mb-3 float-end fuelMoney2Close">close
                    </button>
                    <h4 style="color: white;" id="card_fuelMoney2title" class="card_fuelMoney2title"> </h4>

                </div>
                <div class="card-body ">
                    <div class="row ">

                        <div class="col-md-12 ">
                            <div class="form-group ">
                                <div class="ms-12 row pt-3">
                                    <div class="col-sm-auto">
                                        <input type="text" name="Fm1_ID" id="Fm1_ID" class="form-control Fm1_ID" hidden>
                                        <input type="text" name="Fm1_FK_Fm" id="Fm1_FK_Fm" class="form-control Fm1_FK_Fm" hidden>

                                    </div>
                                </div>

                                <div class="ms-12 row pt-3">

                                    <label for="" class="col-sm-2 col-form-label"> التاريخ :
                                    </label>
                                    <div class="col-sm-auto">
                                        <input type="date" name="Fm1_Date" id="Fm1_Date" class="form-control Fm1_Date" autocomplete="off">
                                        <span id="error_Fm1_Date" class="text-danger"></span>
                                    </div>
                                </div>

                                <div class="ms-12 row pt-3">

                                    <label for="" class="col-sm-2 col-form-label"> نوع الوقود :
                                    </label>
                                    <div class="col-sm-auto">
                                        <select name="Fm1_FuelType" id="Fm1_FuelType" class=" form-select Fm1_FuelType">

                                        </select>
                                        <span id="error_Fm1_FuelType" class="text-danger"></span>
                                    </div>
                                </div>
                                <div class="ms-12 row pt-3">

                                    <label for="" class="col-sm-2 col-form-label"> السعر :
                                    </label>
                                    <div class="col-sm-auto">
                                        <input type="text" name="Fm1_Price" id="Fm1_Price" class="form-control Fm1_Price" autocomplete="off">
                                        <span id="error_Fm1_Price" class="text-danger"></span>
                                    </div>

                                </div>
                                <div class="ms-12 row pt-3">

                                    <label for="" class="col-sm-2 col-form-label"> لتر :
                                    </label>
                                    <div class="col-sm-auto">
                                        <input type="text" name="Fm1_Quantity" id="Fm1_Quantity" class="form-control Fm1_Quantity" autocomplete="off">
                                        <span id="error_Fm1_Quantity" class="text-danger"></span>
                                    </div>

                                </div>

                                <div class="ms-12 row pt-3">

                                    <label for="" class="col-sm-2 col-form-label"> المبلغ :
                                    </label>
                                    <div class="col-sm-auto">
                                        <input type="text" name="Fm1_Money" id="Fm1_Money" class="form-control Fm1_Money" autocomplete="off">
                                        <span id="error_Fm1_Money" class="text-danger"></span>
                                    </div>

                                </div>

                                <div class="ms-12 row pt-3">

                                    <label for="" class="col-sm-2 col-form-label"> رقم العجلة :
                                    </label>
                                    <div class="col-sm-auto">
                                        <input list="Fm1_CarNoBrowser" class="form-control Fm1_CarNo" id="Fm1_CarNo" placeholder="Type to search...">
                                        <datalist id="Fm1_CarNoBrowser">

                                        </datalist>
                                        <span id="error_Fm1_CarNo" class="text-danger"></span>
                                    </div>


                                </div>
                                <div class="ms-12 row pt-3">

                                    <label for="" class="col-sm-2 col-form-label"> نوع العجلة :
                                    </label>
                                    <div class="col-sm-auto">
                                        <input list="Fm1_CarTypeBrowser" class="form-control Fm1_CarType" id="Fm1_CarType" placeholder="Type to search...">
                                        <datalist id="Fm1_CarTypeBrowser">

                                        </datalist>
                                        <span id="error_Fm1_CarType" class="text-danger"></span>
                                    </div>


                                </div>

                                <div class="ms-12 row pt-3">

                                    <label for="" class="col-sm-2 col-form-label"> اسم السائق :
                                    </label>
                                    <div class="col-sm-auto">
                                        <input list="Fm1_DriverNameBrowser" class="form-control Fm1_DriverName" id="Fm1_DriverName" placeholder="Type to search...">
                                        <datalist id="Fm1_DriverNameBrowser">

                                        </datalist>
                                        <span id="error_Fm1_DriverName" class="text-danger"></span>
                                    </div>


                                </div>

                                <div class="ms-12 row pt-3">
                                    <label for="" class="col-sm-2 col-form-label"> عداد العجلة :
                                    </label>
                                    <div class="col-sm-auto">

                                        <input type="text" name="Fm1_Meter" id="Fm1_Meter" class="form-control Fm1_Meter" autocomplete="off">
                                        <span id="error_Fm1_Meter" class="text-danger"></span>
                                    </div>

                                </div>


                            </div>

                            <hr>

                            <div class="ms-12 row pt-6">
                                <div class="col-sm-1">
                                    <button class="btn btn-primary form-control fuelMoney2Save">حفظ البيانات</button>

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
    $(document).ready(function() {
        $(".numbers").each(function() {
            $(this).format({
                format: "#,###",
                locale: "us"
            });
        });
    });
</script>
<script>
    $("#fuelMoneyaction").hide();
    $("#fuelMoney2action").hide();
    $("#fuelMoney2card").hide();
</script>


<?= $this->endSection() ?>