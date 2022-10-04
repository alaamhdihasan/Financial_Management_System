fueltype_fetch();
fueltype_filldata();

$(document).on('click', '.fueltypeAdd', function() {
    var displaycard = document.getElementById("fueltypeaction");
    if (displaycard.style.display == "none") {
        document.getElementById("card_fueltypetitle").innerText = "اضافة نوع جديد";
        displaycard.style.display = "block";
    } else {

        displaycard.style.display = "none";
        document.getElementById("card_fueltypetitle").innerText = "";
        fueltype_cleardata();
        displaycard.style.display = "block";
        document.getElementById("card_fueltypetitle").innerText = "اضافة نوع جديد";

    }
});
$(document).on('click', '.fueltypeClose', function() {
    var displaycard = document.getElementById("fueltypeaction");
    fueltype_cleardata();
    document.getElementById("card_fueltypetitle").innerText = "";
    displaycard.style.display = "none";


});

$(document).on('click', '.fueltypeSave', function() {

    var Ft_id = document.getElementById("Ft_id").value;

    if (Ft_id == '') {

        fueltype_checkdata();
        if (error_Ft_Name != '' || error_Ft_Price != '' || error_Ft_State != '' ) {
            return false;
        } else {
            fueltype_insertdata();
            fueltype_cleardata();
        }
    } else {
        fueltype_update();
        fueltype_cleardata();
    }

});

$(document).on('click', '.fueltypeDelete', function() {
    var tabledata = $('#fueltype_data').DataTable();
    var fueltype = tabledata.row($(this).closest('tr')).data();
    var fueltypevalue = fueltype[Object.keys(fueltype)[0]];

    $.ajax({
        type: "POST",
        url: "fueltype-delete",
        data: {
            'getid': fueltypevalue,
        },

        success: function(response) {
            alertify.set('notifier', 'position', 'top-center');
            alertify.success(response.status);
            $('#fueltype_data').DataTable().ajax.reload();
        }
    });
});

$(document).on('click', '.fueltypeEdit', function() {
    var tabledata = $('#fueltype_data').DataTable();
    var fueltype = tabledata.row($(this).closest('tr')).data();
    var fueltypevalue = fueltype[Object.keys(fueltype)[0]];
    $.ajax({
        type: "GET",
        url: "fueltype-edit",
        data: {
            'getid': fueltypevalue,
        },

        success: function(response) {

            $.each(response, function(key, value) {

                $('#Ft_id').val(value['Ft_ID']);
                $('#Ft_Name').val(value['Ft_Name']);
                $('#Ft_Price').val(value['Ft_Price']);
                $('#Ft_State').val(value['Ft_State']);

                var displaycard = document.getElementById("fueltypeaction");
                if (displaycard.style.display == "none") {
                    document.getElementById("card_fueltypetitle").innerText = "تعديل البيانات ";
                    displaycard.style.display = "block";
                } else {
                    displaycard.style.display = "none";
                    document.getElementById('card_fueltypetitle').innerText = "";
                    document.getElementById('card_fueltypetitle').innerText = "تعديل البيانات ";
                    displaycard.style.display = "block";

                }

            });

        }
    });
});




function fueltype_cleardata() {
    $('#Ft_id').val('');
    $('#Ft_Name').val('');
    $('#Ft_Price').val('');
    $('#Ft_State').val('');

}

function fueltype_checkdata() {
    if ($.trim($('.Ft_Name').val()).length == 0) {
        error_Ft_Name = " مطلوب";
        $('#error_Ft_Name').text(error_Ft_Name);
    } else {
        error_Ft_Name = "";
        $('#error_Ft_Name').text(error_Ft_Name);
    }
    if ($.trim($('.Ft_State').val()).length == 0) {
        error_Ft_State = "مطلوب";
        $('#error_Ft_State').text(error_Ft_State);
    } else {
        error_Ft_State = "";
        $('#error_Ft_State').text(error_Ft_State);
    }
    if ($.trim($('.Ft_Price').val()).length == 0) {
        error_Ft_Price = "مطلوب ";
        $('#error_Ft_Price').text(error_Ft_Price);
    } else {
        error_Ft_Price = "";
        $('#error_Ft_Price').text(error_Ft_Price);
    }
    
}

function fueltype_insertdata() {
    var data = {
        'Ft_Name': $('.Ft_Name').val(),
        'Ft_Price': $('.Ft_Price').val(),
        'Ft_State': $('.Ft_State').val(),

    };
    $.ajax({
        method: "POST",
        url: "fueltype-store",
        data: data,
        success: function(response) {
            alertify.set('notifier', 'position', 'top-center');
            alertify.success(response.status);
            var tabldata = $('#fueltype_data').DataTable();
            tabldata.ajax.reload();


        }
    });
}

function fueltype_filldata() {
    $(document).ready(function() {
        $.ajax({
            type: "GET",
            url: "fueltype-filldata",
            success: function(response) {

                $('#Ft_State').append('<option selected>' + "Select State" + '</option>');
                $.each(response.getstate, function(indexInArray, valueOfElement) {
                    $('#Ft_State').append('<option value="' + valueOfElement.St_Name + '">' + valueOfElement.St_Name + '</option>');
                });

            }
        });

    });
}

function fueltype_fetch() {

    $(document).ready(function() {

        var tabledata = $('#fueltype_data').DataTable({

            "responsive": true,
            "processing": true,
            "serverSide": true,

            "order": [],
            "ajax": {
                type: "GET",
                url: "fueltype-fetch",


            },

            "columns": [{
                    "data": "Ft_ID"
                },
                {
                    "data": "Ft_Name"
                },
                {
                    "data": "Ft_Price"
                },
                {
                    "data": "Ft_State"
                },  
                {
                    "data": null,
                    render: function(data, type) {
                        return type === 'display' ?
                            '<button  class="btn btn-success btn-sm m-1 fueltypeEdit"><i class="bi bi-pen"></i> تعديل </button>' +
                            '<button  class="btn btn-danger btn-sm m-1 fueltypeDelete"><i class="bi bi-trash"></i> حذف </button>' +
                            '<button  class="btn btn-secondary btn-sm m-1 fueltypeDisplay"><i class="bi bi-info"></i></button>' : data;
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

function fueltype_update() {
    var data = {
        'Ft_id': $('.Ft_id').val(),
        'Ft_Name': $('.Ft_Name').val(),
        'Ft_Price': $('.Ft_Price').val(),
        'Ft_State': $('.Ft_State').val(),



    };
    $.ajax({
        method: "POST",
        url: "fueltype-update",
        data: data,
        success: function(response) {
            alertify.set('notifier', 'position', 'top-center');
            alertify.success(response.status);
            var tabldata = $('#fueltype_data').DataTable();
            tabldata.ajax.reload();


        }
    });
}