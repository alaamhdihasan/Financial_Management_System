<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="row border g-0 rounded shadow-sm ">
    <div class="col p-4">
        <div class="col-md-12 mt-2">
            <div class="card ">
                <div class="card-header bg-dark">

                    <button class="btn btn-primary btn-sm m-1 float-end cartypeAdd">اضافة نوع
                    </button>
                    <h4 style="color: white;"><?= $title ?> </h4>

                </div>
                <div class="card-body">

                    <table id="cartype_data" class="table table-bordered table-striped cartype_data" cellspacing="0" width="100%">
                        <thead class="dataheader_cartype table-dark">
                            <tr>
                                <td>ت</td>
                                <td>نوع العجلة</td>
                                <td>مبلغ الغسل </td>
                                <td>الحدث</td>
                            </tr>
                        </thead>
                        <tbody class="databody_cartype">

                        </tbody>
                    </table>

                </div>
            </div>
        </div>
        <div class="col-md-12 mt-5">
            <div class="card cartypeaction" id="cartypeaction">
                <div class="card-header bg-dark">
                    <button class="btn btn-danger btn-sm m-1 mb-3 float-end cartypeClose">خروج
                    </button>
                    <h4 style="color: white;" id="card_cartypetitle" class="card_cartypetitle"> </h4>

                </div>
                <div class="card-body ">
                    <div class="row ">
                        <!-- <form> -->

                        <div class="col-md-12 ">
                            <div class="form-group ">
                                <div class="ms-12 row pt-3">
                                    <div class="col-sm-auto">
                                        <input type="text" name="ct_id" id="ct_id" class="form-control ct_id" hidden>

                                    </div>
                                </div>

                                <div class="ms-12 row pt-3">
                                    <label for="" class="col-sm-2 col-form-label"> نوع العجلة :
                                    </label>
                                    <div class="col-sm-3">
                                        <input type="text" name="ct_name" id="ct_name" class="form-control ct_name" autocomplete="off">
                                        <span id="error_ct_name" class="text-danger"></span>
                                    </div>

                                </div>
                                <div class="ms-12 row pt-3">
                                    <label for="" class="col-sm-2 col-form-label"> مبلغ الغسل  :
                                    </label>
                                    <div class="col-sm-3">
                                        <input type="text" name="ct_price" id="ct_price" class="form-control ct_price" autocomplete="off">
                                        <span id="error_ct_price" class="text-danger"></span>
                                    </div>

                                </div>




                                <div>
                                    <?php echo '----------------------------------------------------------------------------------------' ?>

                                    <div class="ms-12 row pt-3">
                                        <label for="" class="col-sm-2 col-form-label"> </label>
                                        <div class="col-sm-2">
                                            <button class="btn btn-primary form-control cartypeSave">حفظ البيانات</button>
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
        $("#cartypeaction").hide();
    </script>


    <?= $this->endSection() ?>