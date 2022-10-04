<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="row border g-0 rounded shadow-sm ">
    <div class="col p-4">
        <div class="col-md-12 mt-2">
            <div class="card ">
                <div class="card-header bg-dark">

                    <button class="btn btn-primary btn-sm m-1 float-right specializationAdd">اضافة اختصاص
                    </button>

                    <h4 style="color: white;"><?= $title ?> </h4>

                </div>
                <div class="card-body">

                    <table id="specialization_data" class="table table-bordered table-striped specialization_data" cellspacing="0" width="100%">
                        <thead class="dataheader_specialization table-dark">
                            <tr>
                                <td>ت</td>
                                <td>اسم الاختصاص</td>
                                <td>الحدث</td>
                            </tr>
                        </thead>
                        <tbody class="databody_specialization">

                        </tbody>
                    </table>

                </div>
            </div>
        </div>
        <div class="col-md-12 mt-5">
            <div class="card specializationaction" id="specializationaction">
                <div class="card-header bg-dark">
                    <button class="btn btn-danger btn-sm m-1 mb-3 float-right specializationClose">خروج
                    </button>
                    <h4 style="color: white;" id="card_specializationtitle" class="card_specializationtitle"> </h4>

                </div>
                <div class="card-body ">
                    <div class="row ">
                        <!-- <form> -->

                        <div class="col-md-12 ">
                            <div class="form-group ">
                                <div class="ms-12 row pt-3">
                                    <div class="col-sm-auto">
                                        <input type="text" name="sp_id" id="sp_id" class="form-control sp_id" hidden>

                                    </div>
                                </div>

                                <div class="ms-12 row pt-3">
                                    <label for="" class="col-sm-2 col-form-label"> اسم الاختصاص :
                                    </label>
                                    <div class="col-sm-3">
                                        <input type="text" name="sp_name" id="sp_name" class="form-control sp_name" autocomplete="off">
                                        <span id="error_sp_name" class="text-danger"></span>
                                    </div>

                                </div>




                                <div>
                                    <?php echo '----------------------------------------------------------------------------------------' ?>

                                    <div class="ms-12 row pt-3">
                                        <label for="" class="col-sm-2 col-form-label"> </label>
                                        <div class="col-sm-2">
                                            <button class="btn btn-primary form-control specializationSave">حفظ البيانات</button>
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
        specialization_fetch();
        $("#specializationaction").hide();
        $(document).on('click', '.specializationAdd', function() {
            var displaycard = document.getElementById("specializationaction");
            if (displaycard.style.display == "none") {
                document.getElementById("card_specializationtitle").innerText = "اضافة اختصاص جديد";
                displaycard.style.display = "block";
            } else {

                displaycard.style.display = "none";
                document.getElementById("card_specializationtitle").innerText = "";
                specialization_cleardata();
                displaycard.style.display = "block";
                document.getElementById("card_specializationtitle").innerText = "اضافة اختصاص جديد";

            }
        });
        $(document).on('click', '.specializationClose', function() {
            var displaycard = document.getElementById("specializationaction");
            specialization_cleardata();
            document.getElementById("card_specializationtitle").innerText = "";
            displaycard.style.display = "none";


        });

        $(document).on('click', '.specializationSave', function() {

            var sp_id = document.getElementById("sp_id").value;

            if (sp_id == '') {

                specialization_chechdata();
                if (error_sp_name != '') {
                    return false;
                } else {
                    specialization_insert();
                    specialization_cleardata();
                }
            } else {
                specialization_update();
                specialization_cleardata();
            }

        });

        $(document).on('click', '.specializationDelete', function() {
            var tabledata = $('#specialization_data').DataTable();
            var specialization = tabledata.row($(this).closest('tr')).data();
            var specializationvalue = specialization[Object.keys(specialization)[0]];

            $.ajax({
                type: "POST",
                url: "<?= base_url('specialization-delete') ?>",
                data: {
                    'getid': specializationvalue,
                },

                success: function(response) {
                    alertify.set('notifier', 'position', 'top-center');
                    alertify.success(response.status);
                    $('#specialization_data').DataTable().ajax.reload();
                }
            });
        });

        $(document).on('click', '.specializationEdit', function() {
            var tabledata = $('#specialization_data').DataTable();
            var specialization = tabledata.row($(this).closest('tr')).data();
            var specializationvalue = specialization[Object.keys(specialization)[0]];
            $.ajax({
                type: "GET",
                url: "<?= base_url('specialization-edit') ?>",
                data: {
                    'getid': specializationvalue,
                },

                success: function(response) {

                    $.each(response, function(key, value) {

                        $('#sp_id').val(value['Sp_ID']);
                        $('#sp_name').val(value['Sp_Name']);


                        var displaycard = document.getElementById("specializationaction");
                        if (displaycard.style.display == "none") {
                            document.getElementById("card_specializationtitle").innerText = "تعديل بيانات الاختصاص";
                            displaycard.style.display = "block";
                        } else {
                            displaycard.style.display = "none";
                            document.getElementById('card_specializationtitle').innerText = "";
                            document.getElementById('card_specializationtitle').innerText = "تعديل بيانات الاختصاص";
                            displaycard.style.display = "block";

                        }

                    });

                }
            });
        });




        function specialization_cleardata() {
            $('#sp_id').val('');
            $('#sp_name').val('');

        }

        function specialization_chechdata() {
            if ($.trim($('.sp_name').val()).length == 0) {
                error_sp_name = "plz, input the specialization";
                $('#error_sp_name').text(error_sp_name);
            } else {
                error_sp_name = "";
                $('#error_sp_name').text(error_sp_name);
            }



        }

        function specialization_insert() {
            var data = {
                'sp_name': $('.sp_name').val(),
            };
            $.ajax({
                method: "POST",
                url: "<?php echo base_url('specialization-store') ?>",
                data: data,
                success: function(response) {
                    alertify.set('notifier', 'position', 'top-center');
                    alertify.success(response.status);
                    var tabldata = $('#specialization_data').DataTable();
                    tabldata.ajax.reload();


                }
            });
        }


        function specialization_fetch() {

            $(document).ready(function() {

                var tabledata = $('#specialization_data').DataTable({

                    "responsive": true,
                    "processing": true,
                    "serverSide": true,

                    "order": [],
                    "ajax": {
                        type: "GET",
                        url: "<?php echo base_url('specialization-fetch') ?>",


                    },

                    "columns": [{
                            "data": "Sp_ID"
                        },
                        {
                            "data": "Sp_Name"
                        },

                        {
                            "data": null,
                            render: function(data, type) {
                                return type === 'display' ?
                                    '<button  class="btn btn-success btn-sm m-1 specializationEdit"><i class="bi bi-pen"></i> تعديل </button>' +
                                    '<button  class="btn btn-danger btn-sm m-1 specializationDelete"><i class="bi bi-trash"></i> حذف </button>' +
                                    '<button  class="btn btn-secondary btn-sm m-1 specializationDisplay"><i class="bi bi-info"></i></button>' : data;
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

        function specialization_update() {
            var data = {
                'sp_id': $('.sp_id').val(),
                'sp_name': $('.sp_name').val(),


            };
            $.ajax({
                method: "POST",
                url: "<?php echo base_url('specialization-update') ?>",
                data: data,
                success: function(response) {
                    alertify.set('notifier', 'position', 'top-center');
                    alertify.success(response.status);
                    var tabldata = $('#specialization_data').DataTable();
                    tabldata.ajax.reload();


                }
            });
        }
    </script>


    <?= $this->endSection() ?>