<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="row border g-0 rounded shadow-sm ">
    <div class="col p-4">
        <div class="col-md-12 mt-2">
            <div class="card ">
                <div class="card-header bg-dark">

                    <button class="btn btn-primary btn-sm m-1 float-end fueltypeAdd">اضافة نوع وقود
                    </button>

                    <h4 style="color: white;"><?= $title ?> </h4>

                </div>
                <div class="card-body">

                    <table id="fueltype_data" class="table table-bordered table-striped fueltype_data" cellspacing="0" width="100%">
                        <thead class="dataheader_fueltype table-dark">
                            <tr>
                                <td>ت</td>
                                <td>نوع الوقود </td>
                                <td> سعر اللتر</td>
                                <td>الحالة </td>
                                <td>الحدث</td>
                            </tr>
                        </thead>
                        <tbody class="databody_fueltype">

                        </tbody>
                    </table>

                </div>
            </div>
        </div>
        <div class="col-md-12 mt-5">
            <div class="card fueltypeaction" id="fueltypeaction">
                <div class="card-header bg-dark">
                    <button class="btn btn-danger btn-sm m-1 mb-3 float-end fueltypeClose">خروج
                    </button>
                    <h4 style="color: white;" id="card_fueltypetitle" class="card_fueltypetitle"> </h4>

                </div>
                <div class="card-body ">
                    <div class="row ">
                        <!-- <form> -->

                        <div class="col-md-12 ">
                            <div class="form-group ">
                                <div class="ms-12 row pt-3">
                                    <div class="col-sm-auto">
                                        <input type="text" name="Ft_id" id="Ft_id" class="form-control Ft_id" hidden>

                                    </div>
                                </div>

                                <div class="ms-12 row pt-3">
                                    <label for="" class="col-sm-2 col-form-label">نوع الوقود :
                                    </label>
                                    <div class="col-sm-3">
                                        <input type="text" name="Ft_Name" id="Ft_Name" class="form-control Ft_Name" autocomplete="off">
                                        <span id="error_Ft_Name" class="text-danger"></span>
                                    </div>

                                </div>
                                <div class="ms-12 row pt-3">
                                    <label for="" class="col-sm-2 col-form-label">سعر  :
                                    </label>
                                    <div class="col-sm-3">
                                        <input type="text" name="Ft_Price" id="Ft_Price" class="form-control Ft_Price" autocomplete="off">
                                        <span id="error_Ft_Price" class="text-danger"></span>
                                    </div>

                                </div>
                                <div class="ms-12 row pt-3">
                                    <label for="" class="col-sm-2 col-form-label"> الحالة  :
                                    </label>
                                    <div class="col-sm-3">
                                        <select name="Ft_State" id="Ft_State" class="col-sm-11 col-form-label form-select Ft_State">

                                        </select>
                                        <span id="error_Ft_State" class="text-danger"></span>
                                    </div>

                                </div>
                               <hr>
                                <div class="ms-12 row pt-3">
                                    <label for="" class="col-sm-2 col-form-label"> </label>
                                    <div class="col-sm-2">
                                        <button class="btn btn-primary form-control fueltypeSave">حفظ </button>
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
    $("#fueltypeaction").hide();
</script>


<?= $this->endSection() ?>