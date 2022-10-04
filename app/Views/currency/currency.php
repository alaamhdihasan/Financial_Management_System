<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="row border g-0 rounded shadow-sm ">
    <div class="col p-4">
        <div class="col-md-12 mt-2">
            <div class="card ">
                <div class="card-header bg-dark">

                    <button class="btn btn-primary btn-sm m-1 float-right currencyAdd">اضافة عملة
                    </button>

                    <h4 style="color: white;"><?= $title ?> </h4>

                </div>
                <div class="card-body">

                    <table id="currency_data" class="table table-bordered table-striped currency_data" cellspacing="0" width="100%">
                        <thead class="dataheader_currency table-dark">
                            <tr>
                                <td>ت</td>
                                <td>اسم العملة</td>
                                <td>الحالة</td>
                                <td>الحدث</td>
                            </tr>
                        </thead>
                        <tbody class="databody_currency">

                        </tbody>
                    </table>

                </div>
            </div>
        </div>
        <div class="col-md-12 mt-5">
            <div class="card currencyaction" id="currencyaction">
                <div class="card-header bg-dark">
                    <button class="btn btn-danger btn-sm m-1 mb-3 float-right currencyClose">خروج
                    </button>
                    <h4 style="color: white;" id="card_currencytitle" class="card_currencytitle"> </h4>

                </div>
                <div class="card-body ">
                    <div class="row ">
                        <!-- <form> -->

                        <div class="col-md-12 ">
                            <div class="form-group ">
                                <div class="ms-12 row pt-3">
                                    <div class="col-sm-auto">
                                        <input type="text" name="cur_id" id="cur_id" class="form-control cur_id" hidden>

                                    </div>
                                </div>

                                <div class="ms-12 row pt-3">
                                    <label for="" class="col-sm-2 col-form-label"> اسم العملة:
                                    </label>
                                    <div class="col-sm-3">
                                        <input type="text" name="cur_name" id="cur_name" class="form-control cur_name" autocomplete="off">
                                        <span id="error_cur_name" class="text-danger"></span>
                                    </div>

                                </div>
                                <div class="ms-12 row pt-3">
                                    <label for="" class="col-sm-2 col-form-label"> الحالة :
                                    </label>
                                    <div class="col-sm-3">
                                        <select name="cur_state" id="cur_state" class="col-sm-11 col-form-label form-select cur_state">

                                        </select>
                                        <span id="error_cur_state" class="text-danger"></span>
                                    </div>

                                </div>



                                <div>
                                    <?php echo '----------------------------------------------------------------------------------------' ?>

                                    <div class="ms-12 row pt-3">
                                        <label for="" class="col-sm-2 col-form-label"> </label>
                                        <div class="col-sm-2">
                                            <button class="btn btn-primary form-control currencySave">حفظ</button>
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
        currency_fetch();
        currency_filldata();
        $("#currencyaction").hide();
        $(document).on('click', '.currencyAdd', function() {
            var displaycard = document.getElementById("currencyaction");
            if (displaycard.style.display == "none") {
                document.getElementById("card_currencytitle").innerText = "اضافة عملة جديدة";
                displaycard.style.display = "block";
            } else {

                displaycard.style.display = "none";
                document.getElementById("card_currencytitle").innerText = "";
                currency_cleardata();
                displaycard.style.display = "block";
                document.getElementById("card_currencytitle").innerText = "اضافة عملة جديدة";

            }
        });
        $(document).on('click', '.currencyClose', function() {
            var displaycard = document.getElementById("currencyaction");
            currency_cleardata();
            document.getElementById("card_currencytitle").innerText = "";
            displaycard.style.display = "none";


        });

        $(document).on('click', '.currencySave', function() {

            var cur_id = document.getElementById("cur_id").value;

            if (cur_id == '') {

                currency_chechdata();
                if (error_cur_name != '' || error_cur_state != '') {
                    return false;
                } else {
                    currency_insert();
                    currency_cleardata();
                }
            } else {
                currency_update();
                currency_cleardata();
            }

        });

        $(document).on('click', '.currencyDelete', function() {
            var tabledata = $('#currency_data').DataTable();
            var currency = tabledata.row($(this).closest('tr')).data();
            var currencyvalue = currency[Object.keys(currency)[0]];

            $.ajax({
                type: "POST",
                url: "<?= base_url('currency-delete') ?>",
                data: {
                    'getid': currencyvalue,
                },

                success: function(response) {
                    alertify.set('notifier', 'position', 'top-center');
                    alertify.success(response.status);
                    $('#currency_data').DataTable().ajax.reload();
                }
            });
        });

        $(document).on('click', '.currencyEdit', function() {
            var tabledata = $('#currency_data').DataTable();
            var currency = tabledata.row($(this).closest('tr')).data();
            var currencyvalue = currency[Object.keys(currency)[0]];
            $.ajax({
                type: "GET",
                url: "<?= base_url('currency-edit') ?>",
                data: {
                    'getid': currencyvalue,
                },

                success: function(response) {

                    $.each(response, function(key, value) {

                        $('#cur_id').val(value['Cur_ID']);
                        $('#cur_name').val(value['Cur_Name']);
                        $('#cur_state').val(value['Cur_State']);


                        var displaycard = document.getElementById("currencyaction");
                        if (displaycard.style.display == "none") {
                            document.getElementById("card_currencytitle").innerText = "تعديل بيانات العملة";
                            displaycard.style.display = "block";
                        } else {
                            displaycard.style.display = "none";
                            document.getElementById('card_currencytitle').innerText = "";
                            document.getElementById('card_currencytitle').innerText = "تعديل بيانات العملة";
                            displaycard.style.display = "block";

                        }

                    });

                }
            });
        });




        function currency_cleardata() {
            $('#cur_id').val('');
            $('#cur_name').val('');
            $('#cur_state').val('');

        }

        function currency_chechdata() {
            if ($.trim($('.cur_name').val()).length == 0) {
                error_cur_name = "plz, input the Name";
                $('#error_cur_name').text(error_cur_name);
            } else {
                error_cur_name = "";
                $('#error_cur_name').text(error_cur_name);
            }
            if ($.trim($('.cur_state').val()).length == 0 || $.trim($('.cur_state').val()) == 'Select State') {
                error_cur_state = "plz, select the state";
                $('#error_cur_state').text(error_cur_state);
            } else {
                error_cur_state = "";
                $('#error_cur_state').text(error_cur_state);
            }


        }

        function currency_insert() {
            var data = {
                'cur_name': $('.cur_name').val(),
                'cur_state': $('.cur_state').val(),
            };
            $.ajax({
                method: "POST",
                url: "<?php echo base_url('currency-store') ?>",
                data: data,
                success: function(response) {
                    alertify.set('notifier', 'position', 'top-center');
                    alertify.success(response.status);
                    var tabldata = $('#currency_data').DataTable();
                    tabldata.ajax.reload();


                }
            });
        }

        function currency_filldata() {
            $(document).ready(function() {
                $.ajax({
                    type: "GET",
                    url: "<?php echo base_url('currency-filldata') ?>",
                    success: function(response) {

                        $('#cur_state').append('<option selected>' + "Select State" + '</option>');
                        $.each(response.getstate, function(indexInArray, valueOfElement) {
                            $('#cur_state').append('<option value="' + valueOfElement.St_Name + '">' + valueOfElement.St_Name + '</option>');
                        });

                    }
                });

            });
        }

        function currency_fetch() {

            $(document).ready(function() {

                var tabledata = $('#currency_data').DataTable({

                    "responsive": true,
                    "processing": true,
                    "serverSide": true,

                    "order": [],
                    "ajax": {
                        type: "GET",
                        url: "<?php echo base_url('currency-fetch') ?>",


                    },

                    "columns": [{
                            "data": "Cur_ID"
                        },
                        {
                            "data": "Cur_Name"
                        },
                        {
                            "data": "Cur_State"
                        },

                        {
                            "data": null,
                            render: function(data, type) {
                                return type === 'display' ?
                                    '<button  class="btn btn-success btn-sm m-1 currencyEdit"><i class="bi bi-pen"></i> تعديل </button>' +
                                    '<button  class="btn btn-danger btn-sm m-1 currencyDelete"><i class="bi bi-trash"></i> حذف </button>' +
                                    '<button  class="btn btn-secondary btn-sm m-1 currencyDisplay"><i class="bi bi-info"></i></button>' : data;
                            }
                        }



                    ],
                    "columnDefs": [{
                        "targets": [0, 3],
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

        function currency_update() {
            var data = {
                'cur_id': $('.cur_id').val(),
                'cur_name': $('.cur_name').val(),
                'cur_state': $('.cur_state').val(),

            };
            $.ajax({
                method: "POST",
                url: "<?php echo base_url('currency-update') ?>",
                data: data,
                success: function(response) {
                    alertify.set('notifier', 'position', 'top-center');
                    alertify.success(response.status);
                    var tabldata = $('#currency_data').DataTable();
                    tabldata.ajax.reload();


                }
            });
        }
    </script>


    <?= $this->endSection() ?>