permission_fetch();

$(document).on('click', '.permissionAdd', function() {
    var displaycard = document.getElementById("permissionaction");
    if (displaycard.style.display == "none") {
        document.getElementById("card_permissiontitle").innerText = "اضافة صلاحية";
        displaycard.style.display = "block";
    } else {

        displaycard.style.display = "none";
        document.getElementById("card_permissiontitle").innerText = "";
        permission_cleardata();
        displaycard.style.display = "block";
        document.getElementById("card_permissiontitle").innerText = "اضافة صلاحية";

    }
});
$(document).on('click', '.permissionClose', function() {
    var displaycard = document.getElementById("permissionaction");
    permission_cleardata();
    document.getElementById("card_permissiontitle").innerText = "";
    displaycard.style.display = "none";


});

$(document).on('click', '.permissionSave', function() {

    var pe_id = document.getElementById("pe_id").value;

    if (pe_id == '') {

        permission_chechdata();
        if (error_pe_name != '') {
            return false;
        } else {
            permission_insert();
            permission_cleardata();
        }
    } else {
        permission_update();
        permission_cleardata();
    }

});

$(document).on('click', '.permissionDelete', function() {
    var tabledata = $('#permission_data').DataTable();
    var permission = tabledata.row($(this).closest('tr')).data();
    var permissionvalue = permission[Object.keys(permission)[0]];

    $.ajax({
        type: "POST",
        url: "permission-delete",
        data: {
            'getid': permissionvalue,
        },

        success: function(response) {
            alertify.set('notifier', 'position', 'top-center');
            alertify.success(response.status);
            $('#permission_data').DataTable().ajax.reload();
        }
    });
});

$(document).on('click', '.permissionEdit', function() {
    var tabledata = $('#permission_data').DataTable();
    var permission = tabledata.row($(this).closest('tr')).data();
    var permissionvalue = permission[Object.keys(permission)[0]];
    $.ajax({
        type: "GET",
        url: "permission-edit",
        data: {
            'getid': permissionvalue,
        },

        success: function(response) {

            $.each(response, function(key, value) {

                $('#pe_id').val(value['Pe_ID']);
                $('#pe_name').val(value['Pe_Name']);


                var displaycard = document.getElementById("permissionaction");
                if (displaycard.style.display == "none") {
                    document.getElementById("card_permissiontitle").innerText = "تعديل البيانات";
                    displaycard.style.display = "block";
                } else {
                    displaycard.style.display = "none";
                    document.getElementById('card_permissiontitle').innerText = "";
                    document.getElementById('card_permissiontitle').innerText = "تعديل البيانات";
                    displaycard.style.display = "block";

                }

            });

        }
    });
});




function permission_cleardata() {
    $('#pe_id').val('');
    $('#pe_name').val('');

}

function permission_chechdata() {
    if ($.trim($('.pe_name').val()).length == 0) {
        error_pe_name = "plz, input the permission";
        $('#error_pe_name').text(error_pe_name);
    } else {
        error_pe_name = "";
        $('#error_pe_name').text(error_pe_name);
    }



}

function permission_insert() {
    var data = {
        'pe_name': $('.pe_name').val(),
    };
    $.ajax({
        method: "POST",
        url: "permission-store",
        data: data,
        success: function(response) {
            alertify.set('notifier', 'position', 'top-center');
            alertify.success(response.status);
            var tabldata = $('#permission_data').DataTable();
            tabldata.ajax.reload();


        }
    });
}


function permission_fetch() {

    $(document).ready(function() {

        var tabledata = $('#permission_data').DataTable({

            "responsive": true,
            "processing": true,
            "serverSide": true,

            "order": [],
            "ajax": {
                type: "GET",
                url: "permission-fetch",
            },

            "columns": [{
                    "data": "Pe_ID"
                },
                {
                    "data": "Pe_Name"
                },

                {
                    "data": null,
                    render: function(data, type) {
                        return type === 'display' ?
                            '<button  class="btn btn-success btn-sm m-1 permissionEdit"><i class="bi bi-pen"></i> تعديل </button>' +
                            '<button  class="btn btn-danger btn-sm m-1 permissionDelete"><i class="bi bi-trash"></i> حذف </button>' +
                            '<button  class="btn btn-secondary btn-sm m-1 permissionDisplay"><i class="bi bi-info"></i></button>' : data;
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

function permission_update() {
    var data = {
        'pe_id': $('.pe_id').val(),
        'pe_name': $('.pe_name').val(),


    };
    $.ajax({
        method: "POST",
        url: "permission-update",
        data: data,
        success: function(response) {
            alertify.set('notifier', 'position', 'top-right');
            alertify.success(response.status);
            var tabldata = $('#permission_data').DataTable();
            tabldata.ajax.reload();


        }
    });
}