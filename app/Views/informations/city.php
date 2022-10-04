<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="row border g-0 rounded shadow-sm ">
    <div class="col p-4">
        <div class="col-md-12 mt-2">
            <div class="card ">
                <div class="card-header bg-dark">

                    <button class="btn btn-primary btn-sm m-1 float-right cityAdd">اضافة مدينة
                    </button>

                    <h4 style="color: white;"><?= $title ?> </h4>

                </div>
                <div class="card-body">

                    <table id="city_data" class="table table-bordered table-striped city_data" cellspacing="0" width="100%">
                        <thead class="dataheader_city table-dark">
                            <tr>
                                <td>ت</td>
                                <td>اسم المدينة</td>
                                <td>الحدث</td>
                            </tr>
                        </thead>
                        <tbody class="databody_city">

                        </tbody>
                    </table>

                </div>
            </div>
        </div>
        <div class="col-md-12 mt-5">
            <div class="card cityaction" id="cityaction">
                <div class="card-header bg-dark">
                    <button class="btn btn-danger btn-sm m-1 mb-3 float-right cityClose">خروج
                    </button>
                    <h4 style="color: white;" id="card_citytitle" class="card_citytitle"> </h4>

                </div>
                <div class="card-body ">
                    <div class="row ">
                        <!-- <form> -->

                        <div class="col-md-12 ">
                            <div class="form-group ">
                                <div class="ms-12 row pt-3">
                                    <div class="col-sm-auto">
                                        <input type="text" name="ci_id" id="ci_id" class="form-control ci_id" hidden>

                                    </div>
                                </div>

                                <div class="ms-12 row pt-3">
                                    <label for="" class="col-sm-2 col-form-label"> اسم المدينة :
                                    </label>
                                    <div class="col-sm-3">
                                        <input type="text" name="ci_name" id="ci_name" class="form-control ci_name" autocomplete="off">
                                        <span id="error_ci_name" class="text-danger"></span>
                                    </div>

                                </div>




                                <div>
                                    <?php echo '----------------------------------------------------------------------------------------' ?>

                                    <div class="ms-12 row pt-3">
                                        <label for="" class="col-sm-2 col-form-label"> </label>
                                        <div class="col-sm-2">
                                            <button class="btn btn-primary form-control citySave">حفظ البيانات</button>
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
        city_fetch();
        $("#cityaction").hide();
        $(document).on('click', '.cityAdd', function() {
            var displaycard = document.getElementById("cityaction");
            if (displaycard.style.display == "none") {
                document.getElementById("card_citytitle").innerText = "اضافة مدينة جديدة";
                displaycard.style.display = "block";
            } else {

                displaycard.style.display = "none";
                document.getElementById("card_citytitle").innerText = "";
                city_cleardata();
                displaycard.style.display = "block";
                document.getElementById("card_citytitle").innerText = "اضافة مدينة جديدة";

            }
        });
        $(document).on('click', '.cityClose', function() {
            var displaycard = document.getElementById("cityaction");
            city_cleardata();
            document.getElementById("card_citytitle").innerText = "";
            displaycard.style.display = "none";


        });

        $(document).on('click', '.citySave', function() {

            var ci_id = document.getElementById("ci_id").value;

            if (ci_id == '') {

                city_chechdata();
                if (error_ci_name != '') {
                    return false;
                } else {
                    city_insert();
                    city_cleardata();
                }
            } else {
                city_update();
                city_cleardata();
            }

        });

        $(document).on('click', '.cityDelete', function() {
            var tabledata = $('#city_data').DataTable();
            var city = tabledata.row($(this).closest('tr')).data();
            var cityvalue = city[Object.keys(city)[0]];

            $.ajax({
                type: "POST",
                url: "<?= base_url('city-delete') ?>",
                data: {
                    'getid': cityvalue,
                },

                success: function(response) {
                    alertify.set('notifier', 'position', 'top-center');
                    alertify.success(response.status);
                    $('#city_data').DataTable().ajax.reload();
                }
            });
        });

        $(document).on('click', '.cityEdit', function() {
            var tabledata = $('#city_data').DataTable();
            var city = tabledata.row($(this).closest('tr')).data();
            var cityvalue = city[Object.keys(city)[0]];
            $.ajax({
                type: "GET",
                url: "<?= base_url('city-edit') ?>",
                data: {
                    'getid': cityvalue,
                },

                success: function(response) {

                    $.each(response, function(key, value) {

                        $('#ci_id').val(value['Ci_ID']);
                        $('#ci_name').val(value['Ci_Name']);


                        var displaycard = document.getElementById("cityaction");
                        if (displaycard.style.display == "none") {
                            document.getElementById("card_citytitle").innerText = "تعديل البيانات";
                            displaycard.style.display = "block";
                        } else {
                            displaycard.style.display = "none";
                            document.getElementById('card_citytitle').innerText = "";
                            document.getElementById('card_citytitle').innerText = "تعديل البيانات";
                            displaycard.style.display = "block";

                        }

                    });

                }
            });
        });




        function city_cleardata() {
            $('#ci_id').val('');
            $('#ci_name').val('');

        }

        function city_chechdata() {
            if ($.trim($('.ci_name').val()).length == 0) {
                error_ci_name = "الحقل مطلوب";
                $('#error_ci_name').text(error_ci_name);
            } else {
                error_ci_name = "";
                $('#error_ci_name').text(error_ci_name);
            }



        }

        function city_insert() {
            var data = {
                'ci_name': $('.ci_name').val(),
            };
            $.ajax({
                method: "POST",
                url: "<?php echo base_url('city-store') ?>",
                data: data,
                success: function(response) {
                    alertify.set('notifier', 'position', 'top-center');
                    alertify.success(response.status);
                    var tabldata = $('#city_data').DataTable();
                    tabldata.ajax.reload();


                }
            });
        }


        function city_fetch() {

            $(document).ready(function() {

                var tabledata = $('#city_data').DataTable({

                    "responsive": true,
                    "processing": true,
                    "serverSide": true,

                    "order": [],
                    "ajax": {
                        type: "GET",
                        url: "<?php echo base_url('city-fetch') ?>",


                    },

                    "columns": [{
                            "data": "Ci_ID"
                        },
                        {
                            "data": "Ci_Name"
                        },

                        {
                            "data": null,
                            render: function(data, type) {
                                return type === 'display' ?
                                    '<button  class="btn btn-success btn-sm m-1 cityEdit"><i class="bi bi-pen"></i> تعديل </button>' +
                                    '<button  class="btn btn-danger btn-sm m-1 cityDelete"><i class="bi bi-trash"></i> حذف </button>' +
                                    '<button  class="btn btn-secondary btn-sm m-1 cityDisplay"><i class="bi bi-info"></i></button>' : data;
                            }
                        }



                    ],
                    "columnDefs": [{
                        "targets": [0, 2],
                        "orderable": false,
                    }],
                    "lengthMenu": [
                        [5, 10, 15, 20, 25, 100],
                        [5, 10, 15, 20, 25, 100]
                    ],
                    "language": {
                        "decimal": "",
                        "emptyTable": "لا توجد بيانات",
                        "info": "عرض _START_ من _END_ من _TOTAL_ مدخلات",
                        "infoEmpty": "عرض 0 to 0 of 0 مدخلات",
                        "infoFiltered": "(filtered from _MAX_ total entries)",
                        "infoPostFix": "",
                        "thousands": ",",
                        "lengthMenu": "عرض _MENU_ مدخلات",
                        "loadingRecords": "Loading...",
                        "processing": "Processing...",
                        "search": "بحث:",
                        "zeroRecords": "لا توجد بيانات مطابقة لعملية البحث",
                        "paginate": {
                            "first": "الاول",
                            "last": "الاخير",
                            "next": "التالي",
                            "previous": "السابق"
                        },
                        "aria": {
                            "sortAscending": ": activate to sort column ascending",
                            "sortDescending": ": activate to sort column descending"
                        }
                    },


                });




            });

        }

        function city_update() {
            var data = {
                'ci_id': $('.ci_id').val(),
                'ci_name': $('.ci_name').val(),


            };
            $.ajax({
                method: "POST",
                url: "<?php echo base_url('city-update') ?>",
                data: data,
                success: function(response) {
                    alertify.set('notifier', 'position', 'top-center');
                    alertify.success(response.status);
                    var tabldata = $('#city_data').DataTable();
                    tabldata.ajax.reload();


                }
            });
        }
    </script>


    <?= $this->endSection() ?>