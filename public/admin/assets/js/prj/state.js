state_fetch();
$(document).on('click', '.stateAdd', function() {
    var displaycard = document.getElementById("stateaction");
    if (displaycard.style.display == "none") {
        document.getElementById("card_statetitle").innerText = "اضافة حالة جديدة";
        displaycard.style.display = "block";
    } else {

        displaycard.style.display = "none";
        document.getElementById("card_statetitle").innerText = "";
        state_cleardata();
        displaycard.style.display = "block";
        document.getElementById("card_statetitle").innerText = "اضافة حالة جديدة";

    }
});
$(document).on('click', '.stateClose', function() {
    var displaycard = document.getElementById("stateaction");
    state_cleardata();
    document.getElementById("card_statetitle").innerText = "";
    displaycard.style.display = "none";


});

$(document).on('click', '.stateSave', function() {

    var st_id = document.getElementById("st_id").value;

    if (st_id == '') {

        state_chechdata();
        if (error_st_name != '') {
            return false;
        } else {
            state_insert();
            state_cleardata();
        }
    } else {
        state_update();
        state_cleardata();
    }

});

$(document).on('click', '.stateDelete', function() {
    var tabledata = $('#state_data').DataTable();
    var state = tabledata.row($(this).closest('tr')).data();
    var statevalue = state[Object.keys(state)[0]];

    $.ajax({
        type: "POST",
        url: "state-delete",
        data: {
            'getid': statevalue,
        },

        success: function(response) {
            alertify.set('notifier', 'position', 'top-center');
            alertify.success(response.status);
            $('#state_data').DataTable().ajax.reload();
        }
    });
});

$(document).on('click', '.stateEdit', function() {
    var tabledata = $('#state_data').DataTable();
    var state = tabledata.row($(this).closest('tr')).data();
    var statevalue = state[Object.keys(state)[0]];
    $.ajax({
        type: "GET",
        url: "state-edit",
        data: {
            'getid': statevalue,
        },

        success: function(response) {

            $.each(response, function(key, value) {

                $('#st_id').val(value['St_ID']);
                $('#st_name').val(value['St_Name']);


                var displaycard = document.getElementById("stateaction");
                if (displaycard.style.display == "none") {
                    document.getElementById("card_statetitle").innerText = "تعديل بيانات الحالة";
                    displaycard.style.display = "block";
                } else {
                    displaycard.style.display = "none";
                    document.getElementById('card_statetitle').innerText = "";
                    document.getElementById('card_statetitle').innerText = "تعديل بيانات الحالة";
                    displaycard.style.display = "block";

                }

            });

        }
    });
});




function state_cleardata() {
    $('#st_id').val('');
    $('#st_name').val('');

}

function state_chechdata() {
    if ($.trim($('.st_name').val()).length == 0) {
        error_st_name = "نوع الحالة مطلوب";
        $('#error_st_name').text(error_st_name);
    } else {
        error_st_name = "";
        $('#error_st_name').text(error_st_name);
    }



}

function state_insert() {
    var data = {
        'st_name': $('.st_name').val(),
    };
    $.ajax({
        method: "POST",
        url: "state-store",
        data: data,
        success: function(response) {
            alertify.set('notifier', 'position', 'top-center');
            alertify.success(response.status);
            var tabldata = $('#state_data').DataTable();
            tabldata.ajax.reload();


        }
    });
}


function state_fetch() {

    $(document).ready(function() {

        var tabledata = $('#state_data').DataTable({

            "responsive": true,
            "processing": true,
            "serverSide": true,

            "order": [],
            "ajax": {
                type: "GET",
                url: "state-fetch",


            },

            "columns": [{
                    "data": "St_ID"
                },
                {
                    "data": "St_Name"
                },

                {
                    "data": null,
                    render: function(data, type) {
                        return type === 'display' ?
                            '<button  class="btn btn-success btn-sm m-1 stateEdit"><i class="bi bi-pen"></i> تعديل </button>' +
                            '<button  class="btn btn-danger btn-sm m-1 stateDelete"><i class="bi bi-trash"></i> حذف </button>' +
                            '<button  class="btn btn-secondary btn-sm m-1 stateDisplay"><i class="bi bi-info"></i></button>' : data;
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

function state_update() {
    var data = {
        'st_id': $('.st_id').val(),
        'st_name': $('.st_name').val(),


    };
    $.ajax({
        method: "POST",
        url: "state-update",
        data: data,
        success: function(response) {
            alertify.set('notifier', 'position', 'top-center');
            alertify.success(response.status);
            var tabldata = $('#state_data').DataTable();
            tabldata.ajax.reload();


        }
    });
}