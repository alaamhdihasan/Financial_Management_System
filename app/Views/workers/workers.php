<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="row border g-0 rounded shadow-sm ">
    <div class="col p-4">
        <div class="col-md-12 mt-2">
            <div class="card ">
                <div class="card-header bg-dark">

                    <button class="btn btn-primary btn-sm m-1 float-end workersAdd">اضافة
                    </button>

                    <h4 style="color: white;"><?= $title ?> </h4>

                </div>
                <div class="card-body">

                    <table id="workers_data" class="table table-bordered table-striped workers_data" cellspacing="0" width="100%">
                        <thead class="dataheader_workers table-dark">
                            <tr>
                                <td>ID</td>
                                <td>Worker Name</td>
                                <td>State</td>
                                <td>Event</td>
                            </tr>
                        </thead>
                        <tbody class="databody_workers">

                        </tbody>
                    </table>

                </div>
            </div>
        </div>
        <div class="col-md-12 mt-5">
            <div class="card workersaction" id="workersaction">
                <div class="card-header bg-dark">
                    <button class="btn btn-danger btn-sm m-1 mb-3 float-end workersClose">خروج
                    </button>
                    <h4 style="color: white;" id="card_workerstitle" class="card_workerstitle"> </h4>

                </div>
                <div class="card-body ">
                    <div class="row ">
                        <!-- <form> -->

                        <div class="col-md-12 ">
                            <div class="form-group ">
                                <div class="ms-12 row pt-3">
                                    <div class="col-sm-auto">
                                        <input type="text" name="wo_id" id="wo_id" class="form-control wo_id" hidden>

                                    </div>
                                </div>

                                <div class="ms-12 row pt-3">
                                    <label for="" class="col-sm-2 col-form-label"> اسم العامل :
                                    </label>
                                    <div class="col-sm-3">
                                        <input type="text" name="wo_name" id="wo_name" class="form-control wo_name" autocomplete="off">
                                        <span id="error_wo_name" class="text-danger"></span>
                                    </div>

                                </div>

                                <div class="ms-12 row pt-3">
                                    <label for="" class="col-sm-2 col-form-label"> الحالة :
                                    </label>
                                    <div class="col-sm-3">
                                        <select name="wo_state" id="wo_state" class="col-sm-11 col-form-label form-select wo_state">

                                        </select>
                                        <span id="error_wo_state" class="text-danger"></span>
                                    </div>

                                </div>



                                <div>
                                    <?php echo '----------------------------------------------------------------------------------------' ?>

                                    <div class="ms-12 row pt-3">
                                        <label for="" class="col-sm-2 col-form-label"> </label>
                                        <div class="col-sm-2">
                                            <button class="btn btn-primary form-control workersSave">حفظ البيانات</button>
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
        $("#workersaction").hide();
    </script>


    <?= $this->endSection() ?>