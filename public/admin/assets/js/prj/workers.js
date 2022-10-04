workers_fetch();
workers_filldata();
$(document).on('click', '.workersAdd', function() {
    var displaycard = document.getElementById("workersaction");
    if (displaycard.style.display == "none") {
        document.getElementById("card_workerstitle").innerText = "اضافة عامل جديد";
        displaycard.style.display = "block";
    } else {

        displaycard.style.display = "none";
        document.getElementById("card_workerstitle").innerText = "";
        workers_cleardata();
        displaycard.style.display = "block";
        document.getElementById("card_workerstitle").innerText = "اضافة عامل جديد";

    }
});
$(document).on('click', '.workersClose', function() {
    var displaycard = document.getElementById("workersaction");
    workers_cleardata();
    document.getElementById("card_workerstitle").innerText = "";
    displaycard.style.display = "none";


});

$(document).on('click', '.workersSave', function() {

    var wo_id = document.getElementById("wo_id").value;

    if (wo_id == '') {

        workers_chechdata();
        if (error_wo_name != '' || error_wo_state != '') {
            return false;
        } else {
            workers_insert();
            workers_cleardata();
        }
    } else {
        workers_update();
        workers_cleardata();
    }

});

$(document).on('click', '.workersDelete', function() {
    var tabledata = $('#workers_data').DataTable();
    var workers = tabledata.row($(this).closest('tr')).data();
    var workersvalue = workers[Object.keys(workers)[0]];

    $.ajax({
        type: "POST",
        url: "workers-delete",
        data: {
            'getid': workersvalue,
        },

        success: function(response) {
            alertify.set('notifier', 'position', 'top-center');
            alertify.success(response.status);
            $('#workers_data').DataTable().ajax.reload();
        }
    });
});

$(document).on('click', '.workersEdit', function() {
    var tabledata = $('#workers_data').DataTable();
    var workers = tabledata.row($(this).closest('tr')).data();
    var workersvalue = workers[Object.keys(workers)[0]];
    $.ajax({
        type: "GET",
        url: "workers-edit",
        data: {
            'getid': workersvalue,
        },

        success: function(response) {

            $.each(response, function(key, value) {

                $('#wo_id').val(value['Wo_ID']);
                $('#wo_name').val(value['Wo_Name']);
                $('#wo_state').val(value['Wo_State']);


                var displaycard = document.getElementById("workersaction");
                if (displaycard.style.display == "none") {
                    document.getElementById("card_workerstitle").innerText = "تعديل البيانات";
                    displaycard.style.display = "block";
                } else {
                    displaycard.style.display = "none";
                    document.getElementById('card_workerstitle').innerText = "";
                    document.getElementById('card_workerstitle').innerText = "تعديل البيانات";
                    displaycard.style.display = "block";

                }

            });

        }
    });
});




function workers_cleardata() {
    $('#wo_id').val('');
    $('#wo_name').val('');
    $('#wo_state').val('');

}

function workers_chechdata() {
    if ($.trim($('.wo_name').val()).length == 0) {
        error_wo_name = "plz, input the Name";
        $('#error_wo_name').text(error_wo_name);
    } else {
        error_wo_name = "";
        $('#error_wo_name').text(error_wo_name);
    }
    if ($.trim($('.wo_state').val()).length == 0 || $.trim($('.wo_state').val()) == 'Select State') {
        error_wo_state = "plz, select the state";
        $('#error_wo_state').text(error_wo_state);
    } else {
        error_wo_state = "";
        $('#error_wo_state').text(error_wo_state);
    }


}

function workers_insert() {
    var data = {
        'wo_name': $('.wo_name').val(),
        'wo_state': $('.wo_state').val(),
    };
    $.ajax({
        method: "POST",
        url: "workers-store",
        data: data,
        success: function(response) {
            alertify.set('notifier', 'position', 'top-center');
            alertify.success(response.status);
            var tabldata = $('#workers_data').DataTable();
            tabldata.ajax.reload();


        }
    });
}

function workers_filldata() {
    $(document).ready(function() {
        $.ajax({
            type: "GET",
            url: "workers-filldata",
            success: function(response) {

                $('#wo_state').append('<option selected>' + "Select State" + '</option>');
                $.each(response.getstate, function(indexInArray, valueOfElement) {
                    $('#wo_state').append('<option value="' + valueOfElement.St_Name + '">' + valueOfElement.St_Name + '</option>');
                });

            }
        });

    });
}

function workers_fetch() {

    $(document).ready(function() {

        var tabledata = $('#workers_data').DataTable({

            "responsive": true,
            "processing": true,
            "serverSide": true,

            "order": [],
            "ajax": {
                type: "GET",
                url: "workers-fetch",


            },

            "columns": [{
                    "data": "Wo_ID"
                },
                {
                    "data": "Wo_Name"
                },
                {
                    "data": "Wo_State"
                },

                {
                    "data": null,
                    render: function(data, type) {
                        return type === 'display' ?
                            '<button  class="btn btn-success btn-sm m-1 workersEdit"><i class="bi bi-pen"></i> تعديل </button>' +
                            '<button  class="btn btn-danger btn-sm m-1 workersDelete"><i class="bi bi-trash"></i> حذف </button>' +
                            '<button  class="btn btn-secondary btn-sm m-1 workersDisplay"><i class="bi bi-info"></i></button>' : data;
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

function workers_update() {
    var data = {
        'wo_id': $('.wo_id').val(),
        'wo_name': $('.wo_name').val(),
        'wo_state': $('.wo_state').val(),

    };
    $.ajax({
        method: "POST",
        url: "workers-update",
        data: data,
        success: function(response) {
            alertify.set('notifier', 'position', 'top-center');
            alertify.success(response.status);
            var tabldata = $('#workers_data').DataTable();
            tabldata.ajax.reload();


        }
    });
}