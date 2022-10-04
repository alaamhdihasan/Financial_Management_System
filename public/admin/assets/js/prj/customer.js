customer_fetch();
customer_filldata();

$(document).on('click', '.customerAdd', function() {
    var displaycard = document.getElementById("customeraction");
    if (displaycard.style.display == "none") {
        document.getElementById("card_customertitle").innerText = "اضافة زبون";
        displaycard.style.display = "block";
    } else {

        displaycard.style.display = "none";
        document.getElementById("card_customertitle").innerText = "";
        customer_cleardata();
        displaycard.style.display = "block";
        document.getElementById("card_customertitle").innerText = "اضافة زبون";

    }
});
$(document).on('click', '.customerClose', function() {
    var displaycard = document.getElementById("customeraction");
    customer_cleardata();
    document.getElementById("card_customertitle").innerText = "";
    displaycard.style.display = "none";


});

$(document).on('click', '.customerSave', function() {

    var cu_id = document.getElementById("cu_id").value;

    if (cu_id == '') {

        customer_checkdata();

        if (error_cu_name != '' || error_cu_state != '') {
            return false;
        } else {

            customer_insertdata();
            customer_cleardata();
        }
    } else {
        customer_update();
        customer_cleardata();
    }

});

$(document).on('click', '.customerDelete', function() {
    var tabledata = $('#customer_data').DataTable();
    var customer = tabledata.row($(this).closest('tr')).data();
    var customervalue = customer[Object.keys(customer)[0]];
    alert(customervalue);
    $.ajax({
        type: "POST",
        url: "customer-delete",
        data: {
            'getid': customervalue,
        },

        success: function(response) {
            alertify.set('notifier', 'position', 'top-center');
            alertify.success(response.status);
            $('#customer_data').DataTable().ajax.reload();
        }
    });
});

$(document).on('click', '.customerEdit', function() {
    var tabledata = $('#customer_data').DataTable();
    var customer = tabledata.row($(this).closest('tr')).data();
    var customervalue = customer[Object.keys(customer)[0]];
    $.ajax({
        type: "GET",
        url: "customer-edit",
        data: {
            'getid': customervalue,
        },

        success: function(response) {

            $.each(response, function(key, value) {

                $('#cu_id').val(value['Cu_ID']);
                $('#cu_name').val(value['Cu_Name']);
                $('#cu_state').val(value['Cu_State']);


                var displaycard = document.getElementById("customeraction");
                if (displaycard.style.display == "none") {
                    document.getElementById("card_customertitle").innerText = "تعديل بيانات الزبون";
                    displaycard.style.display = "block";
                } else {
                    displaycard.style.display = "none";
                    document.getElementById('card_customertitle').innerText = "";
                    document.getElementById('card_customertitle').innerText = "تعديل بيانات الزبون";
                    displaycard.style.display = "block";

                }

            });

        }
    });
});




function customer_cleardata() {
    $('#cu_id').val('');
    $('#cu_name').val('');
    $('#cu_state').val('');





}

function customer_checkdata() {
    if ($.trim($('.cu_name').val()).length == 0) {
        error_cu_name = "الحقل مطلوب";
        $('#error_cu_name').text(error_cu_name);
    } else {
        error_cu_name = "";
        $('#error_cu_name').text(error_cu_name);
    }
    if ($.trim($('.cu_state').val()).length == 0) {
        error_cu_state = "الحقل مطلوب";
        $('#error_cu_state').text(error_cu_state);
    } else {
        error_cu_state = "";
        $('#error_cu_state').text(error_cu_state);
    }


}

function customer_insertdata() {
    var data = {
        'cu_name': $('.cu_name').val(),
        'cu_state': $('.cu_state').val(),
    };

    $.ajax({
        method: "POST",
        url: "customer-store",
        data: data,
        success: function(response) {
            alertify.set('notifier', 'position', 'top-center');
            alertify.success(response.status);

            var tabldata = $('#customer_data').DataTable();
            tabldata.ajax.reload();


        }
    });
}

function customer_filldata() {
    $(document).ready(function() {
        $.ajax({
            type: "GET",
            url: "customer-filldata",
            success: function(response) {

                $('#cu_state').append('<option selected>' + "Select State" + '</option>');
                $.each(response.getstate, function(indexInArray, valueOfElement) {
                    $('#cu_state').append('<option value="' + valueOfElement.St_Name + '">' + valueOfElement.St_Name + '</option>');
                });


            }
        });

    });
}

function customer_fetch() {

    $(document).ready(function() {

        var tabledata = $('#customer_data').DataTable({

            "responsive": true,
            "processing": true,
            "serverSide": true,

            "order": [],
            "ajax": {
                type: "GET",
                url: "customer-fetch",


            },

            "columns": [{
                    "data": "Cu_ID"
                },
                {
                    "data": "Cu_Name"
                },
                {
                    "data": "Cu_State"
                },

                {
                    "data": null,
                    render: function(data, type) {
                        return type === 'display' ?
                            '<button  class="btn btn-success btn-sm m-1 customerEdit"><i class="bi bi-pen"></i> تعديل </button>' +
                            '<button  class="btn btn-danger btn-sm m-1 customerDelete"><i class="bi bi-trash"></i> حذف </button>' +
                            '<button  class="btn btn-secondary btn-sm m-1 customerDisplay"><i class="bi bi-info"></i></button>' : data;
                    }
                }



            ],
            "columnDefs": [{
                "targets": [0],
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

function customer_update() {
    var data = {
        'cu_id': $('.cu_id').val(),
        'cu_name': $('.cu_name').val(),
        'cu_state': $('.cu_state').val(),
    };
    $.ajax({
        method: "POST",
        url: "customer-update",
        data: data,
        success: function(response) {
            alertify.set('notifier', 'position', 'top-center');
            alertify.success(response.status);
            var tabldata = $('#customer_data').DataTable();
            tabldata.ajax.reload();


        }
    });
}