cartype_fetch();

$(document).on('click', '.cartypeAdd', function() {
    var displaycard = document.getElementById("cartypeaction");
    if (displaycard.style.display == "none") {
        document.getElementById("card_cartypetitle").innerText = "اضافة نوع جديد";
        displaycard.style.display = "block";
    } else {

        displaycard.style.display = "none";
        document.getElementById("card_cartypetitle").innerText = "";
        cartype_cleardata();
        displaycard.style.display = "block";
        document.getElementById("card_cartypetitle").innerText = "اضافة نوع جديد";

    }
});
$(document).on('click', '.cartypeClose', function() {
    var displaycard = document.getElementById("cartypeaction");
    cartype_cleardata();
    document.getElementById("card_cartypetitle").innerText = "";
    displaycard.style.display = "none";


});

$(document).on('click', '.cartypeSave', function() {

    var ct_id = document.getElementById("ct_id").value;

    if (ct_id == '') {

        cartype_chechdata();
        if (error_ct_name != '') {
            return false;
        } else {
            cartype_insert();
            cartype_cleardata();
        }
    } else {
        cartype_update();
        cartype_cleardata();
    }

});

$(document).on('click', '.cartypeDelete', function() {
    var tabledata = $('#cartype_data').DataTable();
    var cartype = tabledata.row($(this).closest('tr')).data();
    var cartypevalue = cartype[Object.keys(cartype)[0]];

    $.ajax({
        type: "POST",
        url: "'cartype-delete",
        data: {
            'getid': cartypevalue,
        },

        success: function(response) {
            alertify.set('notifier', 'position', 'top-center');
            alertify.success(response.status);
            $('#cartype_data').DataTable().ajax.reload();
        }
    });
});

$(document).on('click', '.cartypeEdit', function() {
    var tabledata = $('#cartype_data').DataTable();
    var cartype = tabledata.row($(this).closest('tr')).data();
    var cartypevalue = cartype[Object.keys(cartype)[0]];
    $.ajax({
        type: "GET",
        url: "cartype-edit",
        data: {
            'getid': cartypevalue,
        },

        success: function(response) {

            $.each(response, function(key, value) {

                $('#ct_id').val(value['Ct_ID']);
                $('#ct_name').val(value['Ct_Name']);
                $('#ct_price').val(value['Ct_Price']);


                var displaycard = document.getElementById("cartypeaction");
                if (displaycard.style.display == "none") {
                    document.getElementById("card_cartypetitle").innerText = "تعديل بيانات النوع";
                    displaycard.style.display = "block";
                } else {
                    displaycard.style.display = "none";
                    document.getElementById('card_cartypetitle').innerText = "";
                    document.getElementById('card_cartypetitle').innerText = "تعديل بيانات النوع";
                    displaycard.style.display = "block";

                }

            });

        }
    });
});




function cartype_cleardata() {
    $('#ct_id').val('');
    $('#ct_name').val('');
    $('#ct_price').val('');

}

function cartype_chechdata() {
    if ($.trim($('.ct_name').val()).length == 0) {
        error_ct_name = "اسم النوع مطلوب";
        $('#error_ct_name').text(error_ct_name);
    } else {
        error_ct_name = "";
        $('#error_ct_name').text(error_ct_name);
    }
    if ($.trim($('.ct_price').val()).length == 0) {
        error_ct_price = "مطلوب";
        $('#error_ct_price').text(error_ct_price);
    } else {
        error_ct_price = "";
        $('#error_ct_price').text(error_ct_price);
    }



}

function cartype_insert() {
    var data = {
        'ct_name': $('.ct_name').val(),
        'ct_price': $('.ct_price').val(),
    };
    $.ajax({
        method: "POST",
        url: "cartype-store",
        data: data,
        success: function(response) {
            alertify.set('notifier', 'position', 'top-center');
            alertify.success(response.status);
            var tabldata = $('#cartype_data').DataTable();
            tabldata.ajax.reload();


        }
    });
}


function cartype_fetch() {

    $(document).ready(function() {

        var tabledata = $('#cartype_data').DataTable({

            "responsive": true,
            "processing": true,
            "serverSide": true,

            "order": [],
            "ajax": {
                type: "GET",
                url: "cartype-fetch",


            },

            "columns": [{
                    "data": "Ct_ID"
                },
                {
                    "data": "Ct_Name"
                },
                {
                    "data": "Ct_Price"
                },
                {
                    "data": null,
                    render: function(data, type) {
                        return type === 'display' ?
                            '<button  class="btn btn-success btn-sm m-1 cartypeEdit"><i class="bi bi-pen"></i> تعديل </button>' +
                            '<button  class="btn btn-danger btn-sm m-1 cartypeDelete"><i class="bi bi-trash"></i> حذف </button>' +
                            '<button  class="btn btn-secondary btn-sm m-1 cartypeDisplay"><i class="bi bi-info"></i></button>' : data;
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

function cartype_update() {
    var data = {
        'ct_id': $('.ct_id').val(),
        'ct_name': $('.ct_name').val(),
        'ct_price': $('.ct_price').val(),


    };
    $.ajax({
        method: "POST",
        url: "cartype-update",
        data: data,
        success: function(response) {
            alertify.set('notifier', 'position', 'top-center');
            alertify.success(response.status);
            var tabldata = $('#cartype_data').DataTable();
            tabldata.ajax.reload();


        }
    });
}