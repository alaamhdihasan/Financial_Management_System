<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="row border g-0 rounded shadow-sm ">
    <div class="col p-4">
        <div class="col-md-12 mt-2">
            <div class="card ">
                <div class="card-header bg-dark">

                    <button class="btn btn-primary btn-sm m-1 float-end customerAdd">اضافة زبون
                    </button>

                    <h4 style="color: white;"><?= $title ?> </h4>

                </div>
                <div class="card-body">

                    <table id="customer_data" class="table table-bordered table-striped customer_data" cellspacing="0" width="100%">
                        <thead class="dataheader_customer table-dark">
                            <tr>
                                <td>ت</td>
                                <td>اسم الزبون</td>
                                <td>الحالة</td>
                                <td>الحدث</td>
                            </tr>
                        </thead>
                        <tbody class="databody_customer">

                        </tbody>
                    </table>

                </div>
            </div>
        </div>
        <div class="col-md-12 mt-5">
            <div class="card customeraction" id="customeraction">
                <div class="card-header bg-dark">
                    <button class="btn btn-danger btn-sm m-1 mb-3 float-end customerClose">خروج
                    </button>
                    <h4 style="color: white;" id="card_customertitle" class="card_customertitle"> </h4>

                </div>
                <div class="card-body ">
                    <div class="row ">
                        <!-- <form> -->

                        <div class="col-md-12 ">
                            <div class="form-group ">
                                <div class="ms-12 row pt-3">
                                    <div class="col-sm-auto">
                                        <input type="text" name="cu_id" id="cu_id" class="form-control cu_id" hidden>

                                    </div>
                                </div>

                                <div class="ms-12 row pt-3">
                                    <label for="" class="col-sm-2 col-form-label"> اسم الزبون :
                                    </label>
                                    <div class="col-sm-3">
                                        <input type="text" name="cu_name" id="cu_name" class="form-control cu_name" autocomplete="off">
                                        <span id="error_cu_name" class="text-danger"></span>
                                    </div>

                                </div>
                               
                                <div class="ms-12 row pt-3">
                                    <label for="" class="col-sm-2 col-form-label"> الحالة :
                                    </label>
                                    <div class="col-sm-3">
                                        <select name="cu_state" id="cu_state" class="col-sm-11 col-form-label form-select cu_state">

                                        </select>
                                        <span id="error_cu_state" class="text-danger"></span>
                                    </div>

                                </div>
                                


                                <div>
                                    <?php echo '----------------------------------------------------------------------------------------' ?>
                                </div>

                                <div class="ms-12 row pt-3">
                                    <label for="" class="col-sm-2 col-form-label"> </label>
                                    <div class="col-sm-2">
                                        <button class="btn btn-primary form-control customerSave">حفظ البيانات</button>
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

    $("#customeraction").hide();
   
</script>


<?= $this->endSection() ?>