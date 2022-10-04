account_fetch();
$(document).on('click', '.accountAdd', function() {
    var displaycard = document.getElementById("accountaction");
    if (displaycard.style.display == "none") {
        document.getElementById("card_accounttitle").innerText = "اضافة حالة جديدة";
        displaycard.style.display = "block";
    } else {

        displaycard.style.display = "none";
        document.getElementById("card_accounttitle").innerText = "";
        account_cleardata();
        displaycard.style.display = "block";
        document.getElementById("card_accounttitle").innerText = "اضافة حالة جديدة";

    }
});
$(document).on('click', '.accountClose', function() {
    var displaycard = document.getElementById("accountaction");
    account_cleardata();
    document.getElementById("card_accounttitle").innerText = "";
    displaycard.style.display = "none";


});

$(document).on('click', '.accountSave', function() {

    var Ac_id = document.getElementById("Ac_id").value;

    if (Ac_id == '') {

        account_chechdata();
        if (error_Ac_name != '') {
            return false;
        } else {
            account_insert();
            account_cleardata();
        }
    } else {
        account_update();
        account_cleardata();
    }

});

$(document).on('click', '.accountDelete', function() {
    var tabledata = $('#account_data').DataTable();
    var account = tabledata.row($(this).closest('tr')).data();
    var accountvalue = account[Object.keys(account)[0]];

    $.ajax({
        type: "POST",
        url: "account-delete",
        data: {
            'getid': accountvalue,
        },

        success: function(response) {
            alertify.set('notifier', 'position', 'top-center');
            alertify.success(response.status);
            $('#account_data').DataTable().ajax.reload();
        }
    });
});

$(document).on('click', '.accountEdit', function() {
    var tabledata = $('#account_data').DataTable();
    var account = tabledata.row($(this).closest('tr')).data();
    var accountvalue = account[Object.keys(account)[0]];
    $.ajax({
        type: "GET",
        url: "account-edit",
        data: {
            'getid': accountvalue,
        },

        success: function(response) {

            $.each(response, function(key, value) {

                $('#Ac_id').val(value['Ac_ID']);
                $('#Ac_name').val(value['Ac_Name']);


                var displaycard = document.getElementById("accountaction");
                if (displaycard.style.display == "none") {
                    document.getElementById("card_accounttitle").innerText = "تعديل بيانات الحالة";
                    displaycard.style.display = "block";
                } else {
                    displaycard.style.display = "none";
                    document.getElementById('card_accounttitle').innerText = "";
                    document.getElementById('card_accounttitle').innerText = "تعديل بيانات الحالة";
                    displaycard.style.display = "block";

                }

            });

        }
    });
});




function account_cleardata() {
    $('#Ac_id').val('');
    $('#Ac_name').val('');

}

function account_chechdata() {
    if ($.trim($('.Ac_name').val()).length == 0) {
        error_Ac_name = "نوع الحالة مطلوب";
        $('#error_Ac_name').text(error_Ac_name);
    } else {
        error_Ac_name = "";
        $('#error_Ac_name').text(error_Ac_name);
    }



}

function account_insert() {
    var data = {
        'Ac_name': $('.Ac_name').val(),
    };
    $.ajax({
        method: "POST",
        url: "account-store",
        data: data,
        success: function(response) {
            alertify.set('notifier', 'position', 'top-center');
            alertify.success(response.status);
            var tabldata = $('#account_data').DataTable();
            tabldata.ajax.reload();


        }
    });
}


function account_fetch() {

    $(document).ready(function() {

        var tabledata = $('#account_data').DataTable({

            "responsive": true,
            "processing": true,
            "serverSide": true,

            "order": [],
            "ajax": {
                type: "GET",
                url: "account-fetch",


            },

            "columns": [{
                    "data": "Ac_ID"
                },
                {
                    "data": "Ac_Name"
                },

                {
                    "data": null,
                    render: function(data, type) {
                        return type === 'display' ?
                            '<button  class="btn btn-success btn-sm m-1 accountEdit"><i class="bi bi-pen"></i> تعديل </button>' +
                            '<button  class="btn btn-danger btn-sm m-1 accountDelete"><i class="bi bi-trash"></i> حذف </button>' +
                            '<button  class="btn btn-secondary btn-sm m-1 accountDisplay"><i class="bi bi-info"></i></button>' : data;
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

function account_update() {
    var data = {
        'Ac_id': $('.Ac_id').val(),
        'Ac_name': $('.Ac_name').val(),


    };
    $.ajax({
        method: "POST",
        url: "account-update",
        data: data,
        success: function(response) {
            alertify.set('notifier', 'position', 'top-center');
            alertify.success(response.status);
            var tabldata = $('#account_data').DataTable();
            tabldata.ajax.reload();


        }
    });
}