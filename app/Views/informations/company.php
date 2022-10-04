<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="row border g-0 rounded shadow-sm ">
    <div class="col p-4">
        <div class="col-md-12 mt-2">
            <div class="card ">
                <div class="card-header bg-dark">

                    <button class="btn btn-primary btn-sm m-1 float-right companyAdd">اضافة شركة
                    </button>

                    <h4 style="color: white;"><?= $title ?> </h4>

                </div>
                <div class="card-body">

                    <table id="company_data" class="table table-bordered table-striped company_data" cellspacing="0" width="100%">
                        <thead class="dataheader_company table-dark">
                            <tr>
                                <td>ت</td>
                                <td>اسم الشركة</td>
                                <td>الحدث</td>
                            </tr>
                        </thead>
                        <tbody class="databody_company">

                        </tbody>
                    </table>

                </div>
            </div>
        </div>
        <div class="col-md-12 mt-5">
            <div class="card companyaction" id="companyaction">
                <div class="card-header bg-dark">
                    <button class="btn btn-danger btn-sm m-1 mb-3 float-right companyClose">خروج
                    </button>
                    <h4 style="color: white;" id="card_companytitle" class="card_companytitle"> </h4>

                </div>
                <div class="card-body ">
                    <div class="row ">
                        <!-- <form> -->

                        <div class="col-md-12 ">
                            <div class="form-group ">
                                <div class="ms-12 row pt-3">
                                    <div class="col-sm-auto">
                                        <input type="text" name="co_id" id="co_id" class="form-control co_id" hidden>

                                    </div>
                                </div>

                                <div class="ms-12 row pt-3">
                                    <label for="" class="col-sm-2 col-form-label"> اسم الشركة :
                                    </label>
                                    <div class="col-sm-3">
                                        <input type="text" name="co_name" id="co_name" class="form-control co_name" autocomplete="off">
                                        <span id="error_co_name" class="text-danger"></span>
                                    </div>

                                </div>




                                <div>
                                    <?php echo '----------------------------------------------------------------------------------------' ?>

                                    <div class="ms-12 row pt-3">
                                        <label for="" class="col-sm-2 col-form-label"> </label>
                                        <div class="col-sm-2">
                                            <button class="btn btn-primary form-control companySave">حفظ البيانات</button>
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
        company_fetch();
        $("#companyaction").hide();
        $(document).on('click', '.companyAdd', function() {
            var displaycard = document.getElementById("companyaction");
            if (displaycard.style.display == "none") {
                document.getElementById("card_companytitle").innerText = "اضافة شركة جديدة";
                displaycard.style.display = "block";
            } else {

                displaycard.style.display = "none";
                document.getElementById("card_companytitle").innerText = "";
                company_cleardata();
                displaycard.style.display = "block";
                document.getElementById("card_companytitle").innerText = "اضافة شركة جديدة";

            }
        });
        $(document).on('click', '.companyClose', function() {
            var displaycard = document.getElementById("companyaction");
            company_cleardata();
            document.getElementById("card_companytitle").innerText = "";
            displaycard.style.display = "none";


        });

        $(document).on('click', '.companySave', function() {

            var co_id = document.getElementById("co_id").value;

            if (co_id == '') {

                company_chechdata();
                if (error_co_name != '') {
                    return false;
                } else {
                    company_insert();
                    company_cleardata();
                }
            } else {
                company_update();
                company_cleardata();
            }

        });

        $(document).on('click', '.companyDelete', function() {
            var tabledata = $('#company_data').DataTable();
            var company = tabledata.row($(this).closest('tr')).data();
            var companyvalue = company[Object.keys(company)[0]];

            $.ajax({
                type: "POST",
                url: "<?= base_url('company-delete') ?>",
                data: {
                    'getid': companyvalue,
                },

                success: function(response) {
                    alertify.set('notifier', 'position', 'top-center');
                    alertify.success(response.status);
                    $('#company_data').DataTable().ajax.reload();
                }
            });
        });

        $(document).on('click', '.companyEdit', function() {
            var tabledata = $('#company_data').DataTable();
            var company = tabledata.row($(this).closest('tr')).data();
            var companyvalue = company[Object.keys(company)[0]];
            $.ajax({
                type: "GET",
                url: "<?= base_url('company-edit') ?>",
                data: {
                    'getid': companyvalue,
                },

                success: function(response) {

                    $.each(response, function(key, value) {

                        $('#co_id').val(value['Co_ID']);
                        $('#co_name').val(value['Co_Name']);


                        var displaycard = document.getElementById("companyaction");
                        if (displaycard.style.display == "none") {
                            document.getElementById("card_companytitle").innerText = "تعديل البيانات";
                            displaycard.style.display = "block";
                        } else {
                            displaycard.style.display = "none";
                            document.getElementById('card_companytitle').innerText = "";
                            document.getElementById('card_companytitle').innerText = "تعديل البيانات";
                            displaycard.style.display = "block";

                        }

                    });

                }
            });
        });




        function company_cleardata() {
            $('#co_id').val('');
            $('#co_name').val('');

        }

        function company_chechdata() {
            if ($.trim($('.co_name').val()).length == 0) {
                error_co_name = "الحقل مطلوب";
                $('#error_co_name').text(error_co_name);
            } else {
                error_co_name = "";
                $('#error_co_name').text(error_co_name);
            }



        }

        function company_insert() {
            var data = {
                'co_name': $('.co_name').val(),
            };
            $.ajax({
                method: "POST",
                url: "<?php echo base_url('company-store') ?>",
                data: data,
                success: function(response) {
                    alertify.set('notifier', 'position', 'top-center');
                    alertify.success(response.status);
                    var tabldata = $('#company_data').DataTable();
                    tabldata.ajax.reload();


                }
            });
        }


        function company_fetch() {

            $(document).ready(function() {

                var tabledata = $('#company_data').DataTable({

                    "responsive": true,
                    "processing": true,
                    "serverSide": true,

                    "order": [],
                    "ajax": {
                        type: "GET",
                        url: "<?php echo base_url('company-fetch') ?>",


                    },

                    "columns": [{
                            "data": "Co_ID"
                        },
                        {
                            "data": "Co_Name"
                        },

                        {
                            "data": null,
                            render: function(data, type) {
                                return type === 'display' ?
                                    '<button  class="btn btn-success btn-sm m-1 companyEdit"><i class="bi bi-pen"></i> تعديل </button>' +
                                    '<button  class="btn btn-danger btn-sm m-1 companyDelete"><i class="bi bi-trash"></i> حذف </button>' +
                                    '<button  class="btn btn-secondary btn-sm m-1 companyDisplay"><i class="bi bi-info"></i></button>' : data;
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

        function company_update() {
            var data = {
                'co_id': $('.co_id').val(),
                'co_name': $('.co_name').val(),


            };
            $.ajax({
                method: "POST",
                url: "<?php echo base_url('company-update') ?>",
                data: data,
                success: function(response) {
                    alertify.set('notifier', 'position', 'top-center');
                    alertify.success(response.status);
                    var tabldata = $('#company_data').DataTable();
                    tabldata.ajax.reload();


                }
            });
        }
    </script>


    <?= $this->endSection() ?>