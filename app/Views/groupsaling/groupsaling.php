<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="row border g-0 rounded shadow-sm ">
    <div class="col p-4">
        <div class="col-md-12 mt-2">
            <div class="card ">
                <div class="card-header bg-dark">

                    <button class="btn btn-primary btn-sm m-1 float-right groupsalingAdd">اضافة مجموعة
                    </button>

                    <h4 style="color: white;"><?= $title ?> </h4>

                </div>
                <div class="card-body">

                    <table id="groupsaling_data" class="table table-bordered table-striped groupsaling_data" cellspacing="0" width="100%">
                        <thead class="dataheader_groupsaling table-dark">
                            <tr>
                                <td>ت</td>
                                <td>اسم المجموعة</td>
                                <td>الحالة</td>
                                <td>القيمة</td>
                                <td>الخصم</td>
                                <td>الحدث</td>
                            </tr>
                        </thead>
                        <tbody class="databody_groupsaling">

                        </tbody>
                    </table>

                </div>
            </div>
        </div>
        <div class="col-md-12 mt-5">
            <div class="card groupsalingaction" id="groupsalingaction">
                <div class="card-header bg-dark">
                    <button class="btn btn-danger btn-sm m-1 mb-3 float-right groupsalingClose">خروج
                    </button>
                    <h4 style="color: white;" id="card_groupsalingtitle" class="card_groupsalingtitle"> </h4>

                </div>
                <div class="card-body ">
                    <div class="row ">
                        <!-- <form> -->

                        <div class="col-md-12 ">
                            <div class="form-group ">
                                <div class="ms-12 row pt-3">
                                    <div class="col-sm-auto">
                                        <input type="text" name="gs_id" id="gs_id" class="form-control gs_id" hidden>

                                    </div>
                                </div>

                                <div class="ms-12 row pt-3">
                                    <label for="" class="col-sm-2 col-form-label"> اسم المجموعة :
                                    </label>
                                    <div class="col-sm-3">
                                        <input type="text" name="gs_name" id="gs_name" class="form-control gs_name" autocomplete="off">
                                        <span id="error_gs_name" class="text-danger"></span>
                                    </div>

                                </div>
                                <div class="ms-12 row pt-3">
                                    <label for="" class="col-sm-2 col-form-label"> الحالة :
                                    </label>
                                    <div class="col-sm-3">
                                        <select name="gs_state" id="gs_state" class="col-sm-11 col-form-label form-select gs_state">

                                        </select>
                                        <span id="error_gs_state" class="text-danger"></span>
                                    </div>

                                </div>
                                <div class="ms-12 row pt-3">
                                    <label for="" class="col-sm-2 col-form-label"> القيمة :
                                    </label>
                                    <div class="col-sm-3">
                                        <input type="number" name="gs_amount" id="gs_amount" class="form-control gs_amount" autocomplete="off">
                                        <span id="error_gs_amount" class="text-danger"></span>
                                    </div>

                                </div>
                                <div class="ms-12 row pt-3">
                                    <label for="" class="col-sm-2 col-form-label">الخصم :
                                    </label>
                                    <div class="col-sm-3">
                                        <input type="number" name="gs_discount" id="gs_discount" class="form-control gs_discount" autocomplete="off">
                                        <span id="error_gs_discount" class="text-danger"></span>
                                    </div>

                                </div>


                                <div>
                                    <?php echo '----------------------------------------------------------------------------------------' ?>
                                </div>
                                <div class="ms-12 row pt-3">
                                    <label for="" class="col-sm-2 col-form-label">الملاحظات :</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control rounded-1 gs_notes" id="gs_notes" name="gs_notes" rows="3"></textarea>

                                    </div>
                                </div>

                                <div class="ms-12 row pt-3">
                                    <label for="" class="col-sm-2 col-form-label"> </label>
                                    <div class="col-sm-2">
                                        <button class="btn btn-primary form-control groupsalingSave">حفظ البيانات</button>
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
    groupsaling_fetch();
    groupsaling_filldata();
    $("#groupsalingaction").hide();
    $(document).on('click', '.groupsalingAdd', function() {
        var displaycard = document.getElementById("groupsalingaction");
        if (displaycard.style.display == "none") {
            document.getElementById("card_groupsalingtitle").innerText = "اضافة بيانات جديدة";
            displaycard.style.display = "block";
        } else {

            displaycard.style.display = "none";
            document.getElementById("card_groupsalingtitle").innerText = "";
            groupsaling_cleardata();
            displaycard.style.display = "block";
            document.getElementById("card_groupsalingtitle").innerText = "اضافة بيانات جديدة";

        }
    });
    $(document).on('click', '.groupsalingClose', function() {
        var displaycard = document.getElementById("groupsalingaction");
        groupsaling_cleardata();
        document.getElementById("card_groupsalingtitle").innerText = "";
        displaycard.style.display = "none";


    });

    $(document).on('click', '.groupsalingSave', function() {

        var gs_id = document.getElementById("gs_id").value;

        if (gs_id == '') {

            groupsaling_checkdata();
            if (error_gs_name != '' || error_gs_state != '' || error_gs_amount != '' || error_gs_discount != '') {
                return false;
            } else {
                groupsaling_insertdata();
                groupsaling_cleardata();
            }
        } else {
            groupsaling_update();
            groupsaling_cleardata();
        }

    });

    $(document).on('click', '.groupsalingDelete', function() {
        var tabledata = $('#groupsaling_data').DataTable();
        var groupsaling = tabledata.row($(this).closest('tr')).data();
        var groupsalingvalue = groupsaling[Object.keys(groupsaling)[0]];

        $.ajax({
            type: "POST",
            url: "<?= base_url('groupsaling-delete') ?>",
            data: {
                'getid': groupsalingvalue,
            },

            success: function(response) {
                alertify.set('notifier', 'position', 'top-center');
                alertify.success(response.status);
                $('#groupsaling_data').DataTable().ajax.reload();
            }
        });
    });

    $(document).on('click', '.groupsalingEdit', function() {
        var tabledata = $('#groupsaling_data').DataTable();
        var groupsaling = tabledata.row($(this).closest('tr')).data();
        var groupsalingvalue = groupsaling[Object.keys(groupsaling)[0]];
        $.ajax({
            type: "GET",
            url: "<?= base_url('groupsaling-edit') ?>",
            data: {
                'getid': groupsalingvalue,
            },

            success: function(response) {

                $.each(response, function(key, value) {

                    $('#gs_id').val(value['Gs_ID']);
                    $('#gs_name').val(value['Gs_Name']);
                    $('#gs_state').val(value['Gs_State']);
                    $('#gs_amount').val(value['Gs_Amount']);
                    $('#gs_discount').val(value['Gs_Discount']);
                    $('#gs_notes').val(value['Gs_Notes']);


                    var displaycard = document.getElementById("groupsalingaction");
                    if (displaycard.style.display == "none") {
                        document.getElementById("card_groupsalingtitle").innerText = "تعديل بيانات المجموعة";
                        displaycard.style.display = "block";
                    } else {
                        displaycard.style.display = "none";
                        document.getElementById('card_groupsalingtitle').innerText = "";
                        document.getElementById('card_groupsalingtitle').innerText = "تعديل بيانات المجموعة";
                        displaycard.style.display = "block";

                    }

                });

            }
        });
    });




    function groupsaling_cleardata() {
        $('#gs_id').val('');
        $('#gs_name').val('');
        $('#gs_state').val('');
        $('#gs_amount').val('');
        $('#gs_discount').val('');
        $('#gs_notes').val('');




    }

    function groupsaling_checkdata() {
        if ($.trim($('.gs_name').val()).length == 0) {
            error_gs_name = "الحقل مطلوب";
            $('#error_gs_name').text(error_gs_name);
        } else {
            error_gs_name = "";
            $('#error_gs_name').text(error_gs_name);
        }
        if ($.trim($('.gs_state').val()).length == 0) {
            error_gs_state = "الحقل مطلوب";
            $('#error_gs_state').text(error_gs_state);
        } else {
            error_gs_state = "";
            $('#error_gs_state').text(error_gs_state);
        }
        if ($.trim($('.gs_amount').val()).length == 0) {
            error_gs_amount = "الحقل مطلوب";
            $('#error_gs_amount').text(error_gs_amount);
        } else {
            error_gs_amount = "";
            $('#error_gs_amount').text(error_gs_amount);
        }
        if ($.trim($('.gs_discount').val()).length == 0) {
            error_gs_discount = "الحقل مطلوب";
            $('#error_gs_discount').text(error_gs_discount);
        } else {
            error_gs_discount = "";
            $('#error_gs_discount').text(error_gs_discount);
        }


    }

    function groupsaling_insertdata() {
        var data = {
            'gs_name': $('.gs_name').val(),
            'gs_state': $('.gs_state').val(),
            'gs_amount': $('.gs_amount').val(),
            'gs_discount': $('.gs_discount').val(),
            'gs_notes': $('.gs_notes').val(),



        };
        $.ajax({
            method: "POST",
            url: "<?php echo base_url('groupsaling-store') ?>",
            data: data,
            success: function(response) {
                alertify.set('notifier', 'position', 'top-center');
                alertify.success(response.status);
                var tabldata = $('#groupsaling_data').DataTable();
                tabldata.ajax.reload();


            }
        });
    }

    function groupsaling_filldata() {
        $(document).ready(function() {
            $.ajax({
                type: "GET",
                url: "<?php echo base_url('groupsaling-filldata') ?>",
                success: function(response) {

                    $('#gs_state').append('<option selected>' + "Select State" + '</option>');
                    $.each(response.getstate, function(indexInArray, valueOfElement) {
                        $('#gs_state').append('<option value="' + valueOfElement.St_Name + '">' + valueOfElement.St_Name + '</option>');
                    });

                }
            });

        });
    }

    function groupsaling_fetch() {

        $(document).ready(function() {

            var tabledata = $('#groupsaling_data').DataTable({

                "responsive": true,
                "processing": true,
                "serverSide": true,

                "order": [],
                "ajax": {
                    type: "GET",
                    url: "<?php echo base_url('groupsaling-fetch') ?>",


                },

                "columns": [{
                        "data": "Gs_ID"
                    },
                    {
                        "data": "Gs_Name"
                    },
                    {
                        "data": "Gs_State"
                    },
                    {
                        "data": "Gs_Amount"
                    },
                    {
                        "data": "Gs_Discount"
                    },

                    {
                        "data": null,
                        render: function(data, type) {
                            return type === 'display' ?
                                '<button  class="btn btn-success btn-sm m-1 groupsalingEdit"><i class="bi bi-pen"></i> تعديل </button>' +
                                '<button  class="btn btn-danger btn-sm m-1 groupsalingDelete"><i class="bi bi-trash"></i> حذف </button>' +
                                '<button  class="btn btn-secondary btn-sm m-1 groupsalingDisplay"><i class="bi bi-info"></i></button>' : data;
                        }
                    }



                ],
                "columnDefs": [{
                    "targets": [0, 5],
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

    function groupsaling_update() {
        var data = {
            'gs_id': $('.gs_id').val(),
            'gs_name': $('.gs_name').val(),
            'gs_state': $('.gs_state').val(),
            'gs_amount': $('.gs_amount').val(),
            'gs_discount': $('.gs_discount').val(),
            'gs_notes': $('.gs_notes').val(),


        };
        $.ajax({
            method: "POST",
            url: "<?php echo base_url('groupsaling-update') ?>",
            data: data,
            success: function(response) {
                alertify.set('notifier', 'position', 'top-center');
                alertify.success(response.status);
                var tabldata = $('#groupsaling_data').DataTable();
                tabldata.ajax.reload();


            }
        });
    }
</script>


<?= $this->endSection() ?>