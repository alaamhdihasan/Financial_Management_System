<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="row border g-0 rounded shadow-sm ">
    <div class="col p-4">
        <div class="col-md-12 mt-2">
            <div class="card ">
                <div class="card-header bg-dark">

                    <button class="btn btn-primary btn-sm m-1 float-right accountsAdd">اضافة حساب
                    </button>

                    <h4 style="color: white;"><?= $title ?> </h4>

                </div>
                <div class="card-body">

                    <table id="accounts_data" class="table table-bordered table-striped accounts_data" cellspacing="0" width="100%">
                        <thead class="dataheader_accounts table-dark">
                            <tr>
                                <td>ت</td>
                                <td>اسم الحساب</td>
                                <td>الحالة</td>
                                <td>المجموعة</td>
                                <td>الحدث</td>
                            </tr>
                        </thead>
                        <tbody class="databody_accounts">

                        </tbody>
                    </table>

                </div>
            </div>
        </div>
        <div class="col-md-12 mt-5">
            <div class="card accountsaction" id="accountsaction">
                <div class="card-header bg-dark">
                    <button class="btn btn-danger btn-sm m-1 mb-3 float-right accountsClose">خروج
                    </button>
                    <h4 style="color: white;" id="card_accountstitle" class="card_accountstitle"> </h4>

                </div>
                <div class="card-body ">
                    <div class="row ">
                        <!-- <form> -->

                        <div class="col-md-12 ">
                            <div class="form-group ">
                                <div class="ms-12 row pt-3">
                                    <div class="col-sm-auto">
                                        <input type="text" name="ac_id" id="ac_id" class="form-control ac_id" hidden>

                                    </div>
                                </div>

                                <div class="ms-12 row pt-3">
                                    <label for="" class="col-sm-2 col-form-label"> الحساب :
                                    </label>
                                    <div class="col-sm-3">
                                        <input type="text" name="ac_name" id="ac_name" class="form-control ac_name" autocomplete="off">
                                        <span id="error_ac_name" class="text-danger"></span>
                                    </div>

                                </div>
                                <div class="ms-12 row pt-3">
                                    <label for="" class="col-sm-2 col-form-label"> الحالة :
                                    </label>
                                    <div class="col-sm-3">
                                        <select name="ac_state" id="ac_state" class="col-sm-11 col-form-label form-select ac_state">

                                        </select>
                                        <span id="error_ac_state" class="text-danger"></span>
                                    </div>

                                </div>
                                <div class="ms-12 row pt-3">
                                    <label for="" class="col-sm-2 col-form-label"> المجموعة :
                                    </label>
                                    <div class="col-sm-3">
                                        <select name="ac_group_sales" id="ac_group_sales" class="col-sm-11 col-form-label form-select ac_group_sales">

                                        </select>
                                        <span id="error_ac_group_sales" class="text-danger"></span>
                                    </div>

                                </div>

                                <div>
                                    <?php echo '----------------------------------------------------------------------------------------' ?>
                                </div>
                                <div class="ms-12 row pt-3">
                                    <label for="" class="col-sm-2 col-form-label">الملاحظات :</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control rounded-1 ac_notes" id="ac_notes" name="ac_notes" rows="3"></textarea>

                                    </div>
                                </div>

                                <div class="ms-12 row pt-3">
                                    <label for="" class="col-sm-2 col-form-label"> </label>
                                    <div class="col-sm-2">
                                        <button class="btn btn-primary form-control accountsSave">حفظ البيانات</button>
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
    accounts_fetch();
    accounts_filldata();
    $("#accountsaction").hide();
    $(document).on('click', '.accountsAdd', function() {
        var displaycard = document.getElementById("accountsaction");
        if (displaycard.style.display == "none") {
            document.getElementById("card_accountstitle").innerText = "اضافة حساب جديد";
            displaycard.style.display = "block";
        } else {

            displaycard.style.display = "none";
            document.getElementById("card_accountstitle").innerText = "";
            accounts_cleardata();
            displaycard.style.display = "block";
            document.getElementById("card_accountstitle").innerText = "اضافة حساب جديد";

        }
    });
    $(document).on('click', '.accountsClose', function() {
        var displaycard = document.getElementById("accountsaction");
        accounts_cleardata();
        document.getElementById("card_accountstitle").innerText = "";
        displaycard.style.display = "none";


    });

    $(document).on('click', '.accountsSave', function() {

        var ac_id = document.getElementById("ac_id").value;

        if (ac_id == '') {

            accounts_checkdata();
            if (error_ac_name != '' || error_ac_state != '' || error_ac_group_sales != '') {
                return false;
            } else {
                accounts_insertdata();
                accounts_cleardata();
            }
        } else {
            accounts_update();
            accounts_cleardata();
        }

    });

    $(document).on('click', '.accountsDelete', function() {
        var tabledata = $('#accounts_data').DataTable();
        var accounts = tabledata.row($(this).closest('tr')).data();
        var accountsvalue = accounts[Object.keys(accounts)[0]];

        $.ajax({
            type: "POST",
            url: "<?= base_url('accounts-delete') ?>",
            data: {
                'getid': accountsvalue,
            },

            success: function(response) {
                alertify.set('notifier', 'position', 'top-center');
                alertify.success(response.status);
                $('#accounts_data').DataTable().ajax.reload();
            }
        });
    });

    $(document).on('click', '.accountsEdit', function() {
        var tabledata = $('#accounts_data').DataTable();
        var accounts = tabledata.row($(this).closest('tr')).data();
        var accountsvalue = accounts[Object.keys(accounts)[0]];
        $.ajax({
            type: "GET",
            url: "<?= base_url('accounts-edit') ?>",
            data: {
                'getid': accountsvalue,
            },

            success: function(response) {

                $.each(response, function(key, value) {

                    $('#ac_id').val(value['Ac_ID']);
                    $('#ac_name').val(value['Ac_Name']);
                    $('#ac_state').val(value['Ac_State']);
                    $('#ac_group_sales').val(value['Ac_Group_Sales']);
                    $('#ac_notes').val(value['Ac_Notes']);


                    var displaycard = document.getElementById("accountsaction");
                    if (displaycard.style.display == "none") {
                        document.getElementById("card_accountstitle").innerText = "تعديل بيانات الحساب";
                        displaycard.style.display = "block";
                    } else {
                        displaycard.style.display = "none";
                        document.getElementById('card_accountstitle').innerText = "";
                        document.getElementById('card_accountstitle').innerText = "تعديل بيانات الحساب";
                        displaycard.style.display = "block";

                    }

                });

            }
        });
    });




    function accounts_cleardata() {
        $('#ac_id').val('');
        $('#ac_name').val('');
        $('#ac_state').val('');
        $('#ac_group_sales').val('');
        $('#ac_notes').val('');




    }

    function accounts_checkdata() {
        if ($.trim($('.ac_name').val()).length == 0) {
            error_ac_name = "الحقل مطلوب";
            $('#error_ac_name').text(error_ac_name);
        } else {
            error_ac_name = "";
            $('#error_ac_name').text(error_ac_name);
        }
        if ($.trim($('.ac_state').val()).length == 0) {
            error_ac_state = "الحقل مطلوب";
            $('#error_ac_state').text(error_ac_state);
        } else {
            error_ac_state = "";
            $('#error_ac_state').text(error_ac_state);
        }
        if ($.trim($('.ac_group_sales').val()).length == 0) {
            error_ac_group_sales = "الحقل مطلوب";
            $('#error_ac_group_sales').text(error_ac_group_sales);
        } else {
            error_ac_group_sales = "";
            $('#error_ac_group_sales').text(error_ac_group_sales);
        }


    }

    function accounts_insertdata() {
        var data = {
            'ac_name': $('.ac_name').val(),
            'ac_state': $('.ac_state').val(),
            'ac_group_sales': $('.ac_group_sales').val(),
            'ac_notes': $('.ac_notes').val(),



        };
        $.ajax({
            method: "POST",
            url: "<?php echo base_url('accounts-store') ?>",
            data: data,
            success: function(response) {
                alertify.set('notifier', 'position', 'top-center');
                alertify.success(response.status);
                var tabldata = $('#accounts_data').DataTable();
                tabldata.ajax.reload();


            }
        });
    }

    function accounts_filldata() {
        $(document).ready(function() {
            $.ajax({
                type: "GET",
                url: "<?php echo base_url('accounts-filldata') ?>",
                success: function(response) {

                    $('#ac_state').append('<option selected>' + "Select State" + '</option>');
                    $.each(response.getstate, function(indexInArray, valueOfElement) {
                        $('#ac_state').append('<option value="' + valueOfElement.St_Name + '">' + valueOfElement.St_Name + '</option>');
                    });
                    $('#ac_group_sales').append('<option selected>' + "Select Group" + '</option>');
                    $.each(response.getgroupsales, function(indexInArray, valueOfElement) {
                        $('#ac_group_sales').append('<option value="' + valueOfElement.Gs_Name + '">' + valueOfElement.Gs_Name + '</option>');
                    });

                }
            });

        });
    }

    function accounts_fetch() {

        $(document).ready(function() {

            var tabledata = $('#accounts_data').DataTable({

                "responsive": true,
                "processing": true,
                "serverSide": true,

                "order": [],
                "ajax": {
                    type: "GET",
                    url: "<?php echo base_url('accounts-fetch') ?>",


                },

                "columns": [{
                        "data": "Ac_ID"
                    },
                    {
                        "data": "Ac_Name"
                    },
                    {
                        "data": "Ac_State"
                    },
                    {
                        "data": "Ac_Group_Sales"
                    },

                    {
                        "data": null,
                        render: function(data, type) {
                            return type === 'display' ?
                                '<button  class="btn btn-success btn-sm m-1 accountsEdit"><i class="bi bi-pen"></i> تعديل </button>' +
                                '<button  class="btn btn-danger btn-sm m-1 accountsDelete"><i class="bi bi-trash"></i> حذف </button>' +
                                '<button  class="btn btn-secondary btn-sm m-1 accountsDisplay"><i class="bi bi-info"></i></button>' : data;
                        }
                    }



                ],
                "columnDefs": [{
                    "targets": [0, 4],
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

    function accounts_update() {
        var data = {
            'ac_id': $('.ac_id').val(),
            'ac_name': $('.ac_name').val(),
            'ac_state': $('.ac_state').val(),
            'ac_group_sales': $('.ac_group_sales').val(),
            'ac_notes': $('.ac_notes').val(),


        };
        $.ajax({
            method: "POST",
            url: "<?php echo base_url('accounts-update') ?>",
            data: data,
            success: function(response) {
                alertify.set('notifier', 'position', 'top-center');
                alertify.success(response.status);
                var tabldata = $('#accounts_data').DataTable();
                tabldata.ajax.reload();


            }
        });
    }
</script>


<?= $this->endSection() ?>