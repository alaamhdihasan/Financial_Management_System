workshopplace_fetch();
workshopplace_filldata();

$(document).on('click', '.workshopplaceAdd', function() {
    var displaycard = document.getElementById("workshopplaceaction");
    if (displaycard.style.display == "none") {
        document.getElementById("card_workshopplacetitle").innerText = "اضافة موقع جديد";
        displaycard.style.display = "block";
    } else {

        displaycard.style.display = "none";
        document.getElementById("card_workshopplacetitle").innerText = "";
        workshopplace_cleardata();
        displaycard.style.display = "block";
        document.getElementById("card_workshopplacetitle").innerText = "اضافة موقع جديد";

    }
});
$(document).on('click', '.workshopplaceClose', function() {
    var displaycard = document.getElementById("workshopplaceaction");
    workshopplace_cleardata();
    document.getElementById("card_workshopplacetitle").innerText = "";
    displaycard.style.display = "none";


});

$(document).on('click', '.workshopplaceSave', function() {

    var ug_id = document.getElementById("ug_id").value;

    if (ug_id == '') {

        workshopplace_checkdata();
        if (error_ug_name != '' || error_ug_state != '' || error_ug_mobile != '' || error_ug_phone != '' ||
            error_ug_manager != '' || error_ug_techniciancount != '') {
            return false;
        } else {
            workshopplace_insertdata();
            workshopplace_cleardata();
        }
    } else {
        workshopplace_update();
        workshopplace_cleardata();
    }

});

$(document).on('click', '.workshopplaceDelete', function() {
    var tabledata = $('#workshopplace_data').DataTable();
    var workshopplace = tabledata.row($(this).closest('tr')).data();
    var workshopplacevalue = workshopplace[Object.keys(workshopplace)[0]];

    $.ajax({
        type: "POST",
        url: "workshopplace-delete",
        data: {
            'getid': workshopplacevalue,
        },

        success: function(response) {
            alertify.set('notifier', 'position', 'top-center');
            alertify.success(response.status);
            $('#workshopplace_data').DataTable().ajax.reload();
        }
    });
});

$(document).on('click', '.workshopplaceEdit', function() {
    var tabledata = $('#workshopplace_data').DataTable();
    var workshopplace = tabledata.row($(this).closest('tr')).data();
    var workshopplacevalue = workshopplace[Object.keys(workshopplace)[0]];
    $.ajax({
        type: "GET",
        url: "workshopplace-edit",
        data: {
            'getid': workshopplacevalue,
        },

        success: function(response) {

            $.each(response, function(key, value) {

                $('#ug_id').val(value['Wsp_ID']);
                $('#ug_name').val(value['Wsp_Name']);
                $('#ug_state').val(value['Wsp_State']);
                $('#ug_mobile').val(value['Wsp_Mobile']);
                $('#ug_phone').val(value['Wsp_Phone']);
                $('#ug_manager').val(value['Wsp_Manager']);
                $('#ug_techniciancount').val(value['Wsp_TechnicianCount']);
                $('#ug_description').val(value['Wsp_Description']);


                var displaycard = document.getElementById("workshopplaceaction");
                if (displaycard.style.display == "none") {
                    document.getElementById("card_workshopplacetitle").innerText = "تعديل بيانات الموقع";
                    displaycard.style.display = "block";
                } else {
                    displaycard.style.display = "none";
                    document.getElementById('card_workshopplacetitle').innerText = "";
                    document.getElementById('card_workshopplacetitle').innerText = "تعديل بيانات الموقع";
                    displaycard.style.display = "block";

                }

            });

        }
    });
});




function workshopplace_cleardata() {
    $('#ug_id').val('');
    $('#ug_name').val('');
    $('#ug_state').val('');
    $('#ug_mobile').val('');
    $('#ug_phone').val('');
    $('#ug_manager').val('');
    $('#ug_techniciancount').val('');
    $('#ug_description').val('');




}

function workshopplace_checkdata() {
    if ($.trim($('.ug_name').val()).length == 0) {
        error_ug_name = "اسم الموقع مطلوب";
        $('#error_ug_name').text(error_ug_name);
    } else {
        error_ug_name = "";
        $('#error_ug_name').text(error_ug_name);
    }
    if ($.trim($('.ug_state').val()).length == 0) {
        error_ug_state = "حالة الموقع مطلوبة";
        $('#error_ug_state').text(error_ug_state);
    } else {
        error_ug_state = "";
        $('#error_ug_state').text(error_ug_state);
    }
    if ($.trim($('.ug_mobile').val()).length == 0) {
        error_ug_mobile = "رقم الموبايل";
        $('#error_ug_mobile').text(error_ug_mobile);
    } else {
        error_ug_mobile = "";
        $('#error_ug_mobile').text(error_ug_mobile);
    }
    if ($.trim($('.ug_phone').val()).length == 0) {
        error_ug_phone = "رقم الهاتف";
        $('#error_ug_phone').text(error_ug_phone);
    } else {
        error_ug_phone = "";
        $('#error_ug_phone').text(error_ug_phone);
    }
    if ($.trim($('.ug_manager').val()).length == 0) {
        error_ug_manager = "اسم المدير مطلوب";
        $('#error_ug_manager').text(error_ug_manager);
    } else {
        error_ug_manager = "";
        $('#error_ug_manager').text(error_ug_manager);
    }
    if ($.trim($('.ug_techniciancount').val()).length == 0) {
        error_ug_techniciancount = "مطلوب";
        $('#error_ug_techniciancount').text(error_ug_techniciancount);
    } else {
        error_ug_techniciancount = "";
        $('#error_ug_techniciancount').text(error_ug_techniciancount);
    }

}

function workshopplace_insertdata() {
    var data = {
        'ug_name': $('.ug_name').val(),
        'ug_state': $('.ug_state').val(),
        'ug_mobile': $('.ug_mobile').val(),
        'ug_phone': $('.ug_phone').val(),
        'ug_manager': $('.ug_manager').val(),
        'ug_techniciancount': $('.ug_techniciancount').val(),
        'ug_description': $('.ug_description').val(),



    };
    $.ajax({
        method: "POST",
        url: "<?php echo base_url('workshopplace-store') ?>",
        data: data,
        success: function(response) {
            alertify.set('notifier', 'position', 'top-center');
            alertify.success(response.status);
            var tabldata = $('#workshopplace_data').DataTable();
            tabldata.ajax.reload();


        }
    });
}

function workshopplace_filldata() {
    $(document).ready(function() {
        $.ajax({
            type: "GET",
            url: "workshopplace-filldata",
            success: function(response) {

                $('#ug_state').append('<option selected>' + "Select State" + '</option>');
                $.each(response.getstate, function(indexInArray, valueOfElement) {
                    $('#ug_state').append('<option value="' + valueOfElement.St_Name + '">' + valueOfElement.St_Name + '</option>');
                });

            }
        });

    });
}

function workshopplace_fetch() {

    $(document).ready(function() {

        var tabledata = $('#workshopplace_data').DataTable({

            "responsive": true,
            "processing": true,
            "serverSide": true,

            "order": [],
            "ajax": {
                type: "GET",
                url: "workshopplace-fetch",


            },

            "columns": [{
                    "data": "Wsp_ID"
                },
                {
                    "data": "Wsp_Name"
                },
                {
                    "data": "Wsp_State"
                },
                {
                    "data": "Wsp_Mobile"
                },
                {
                    "data": "Wsp_Manager"
                },
                {
                    "data": "Wsp_TechnicianCount"
                },
                {
                    "data": null,
                    render: function(data, type) {
                        return type === 'display' ?
                            '<button  class="btn btn-success btn-sm m-1 workshopplaceEdit"><i class="bi bi-pen"></i> تعديل </button>' +
                            '<button  class="btn btn-danger btn-sm m-1 workshopplaceDelete"><i class="bi bi-trash"></i> حذف </button>' +
                            '<button  class="btn btn-secondary btn-sm m-1 workshopplaceDisplay"><i class="bi bi-info"></i></button>' : data;
                    }
                }



            ],
            "columnDefs": [{
                "targets": [0, 6],
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

function workshopplace_update() {
    var data = {
        'ug_id': $('.ug_id').val(),
        'ug_name': $('.ug_name').val(),
        'ug_state': $('.ug_state').val(),
        'ug_mobile': $('.ug_mobile').val(),
        'ug_phone': $('.ug_phone').val(),
        'ug_manager': $('.ug_manager').val(),
        'ug_techniciancount': $('.ug_techniciancount').val(),
        'ug_description': $('.ug_description').val(),


    };
    $.ajax({
        method: "POST",
        url: "workshopplace-update",
        data: data,
        success: function(response) {
            alertify.set('notifier', 'position', 'top-center');
            alertify.success(response.status);
            var tabldata = $('#workshopplace_data').DataTable();
            tabldata.ajax.reload();


        }
    });
}