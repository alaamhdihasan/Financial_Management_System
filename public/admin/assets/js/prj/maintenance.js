Maintenance_fetch();
Maintenance_filldata();


$(document).on('click', '.MaintenanceAdd', function() {
    var displaycard = document.getElementById("Maintenanceaction");
    if (displaycard.style.display == "none") {
        document.getElementById("card_Maintenancetitle").innerText = "اضافة سلفة";
        $.ajax({
            type: "GET",
            url: "maintenance-maxmaintenance",
            success: function(response) {
                $.each(response.getmaxma, function(indexInArray, valueOfElement) {
                    $('#Ma_Number').val(valueOfElement.MaxValue);
                });

                $('#Ma_State').val('Inactive');

            }
        });
        displaycard.style.display = "block";
        document.getElementById('card_Maintenancetitle').scrollIntoView();
    } else {

        displaycard.style.display = "none";
        document.getElementById("card_Maintenancetitle").innerText = "";
        Maintenance_cleardata();
        displaycard.style.display = "block";
        document.getElementById("card_Maintenancetitle").innerText = "اضافة سلفة جديدة";
        document.getElementById('card_Maintenancetitle').scrollIntoView();

    }
});
$(document).on('click', '.MaintenanceClose', function() {
    var displaycard = document.getElementById("Maintenanceaction");
    Maintenance_cleardata();
    document.getElementById("card_Maintenancetitle").innerText = "";
    $('.MaintenanceItem').prop('disabled', true);
    displaycard.style.display = "none";

    var displaycard2 = document.getElementById("Maintenance2action");
    Maintenance2_cleardata();
    document.getElementById("card_Maintenance2title").innerText = "";
    displaycard2.style.display = "none";

    var displaycard3 = document.getElementById("Maintenance2card");
    var tabldata = $('#Maintenance2_data').DataTable();
    tabldata.destroy();
    displaycard3.style.display = "none";




});

$(document).on('click', '.MaintenanceSave', function() {

    var Ma_ID = document.getElementById("Ma_ID").value;

    if (Ma_ID == '') {

        Maintenance_checkdata();

        if (error_Ma_Number != '' || error_Ma_Date != '' || error_Ma_State != '') {

            return false;
        } else {

            Maintenance_insertdata();
            Maintenance_cleardata();
        }
    } else {
        Maintenance_checkdata();
        if (error_Ma_Number != '' || error_Ma_Date != '' || error_Ma_State != '') {

            return false;
        } else {
            Maintenance_update();
            Maintenance_cleardata();
        }
    }

});

$(document).on('click', '.MaintenanceDelete', function() {
    var tabledata = $('#Maintenance_data').DataTable();
    var Maintenance = tabledata.row($(this).closest('tr')).data();
    var Maintenancevalue = Maintenance[Object.keys(Maintenance)[0]];
    $.ajax({
        type: "GET",
        url: "users-getPermissions",
        success: function(response) {

            $.each(response, function(indexInArray, valueOfElement) {
                if (valueOfElement.P_Delete) {
                    $.ajax({
                        type: "POST",
                        url: "maintenance-delete",
                        data: {
                            'getid': Maintenancevalue,
                        },

                        success: function(response) {
                            alertify.set('notifier', 'position', 'top-center');
                            alertify.success(response.status);
                            $('#Maintenance_data').DataTable().ajax.reload();
                        }
                    });
                } else {
                    $('.MaintenanceDelete').prop('disabled', true);
                }


            });

        }
    });





});

$(document).on('click', '.MaintenanceEdit', function() {
    var tabledata = $('#Maintenance_data').DataTable();
    var Maintenance = tabledata.row($(this).closest('tr')).data();
    var Maintenancevalue = Maintenance[Object.keys(Maintenance)[0]];
    $.ajax({
        type: "GET",
        url: "maintenance-edit",
        data: {
            'getid': Maintenancevalue,
        },

        success: function(response) {

            $.each(response, function(key, value) {

                $('#Ma_ID').val(value['Ma_ID']);
                $('#Ma_Number').val(value['Ma_Number']);
                $('#Ma_Date').val(value['Ma_Date']);
                $('#Ma_State').val(value['Ma_State']);



                var displaycard = document.getElementById("Maintenanceaction");
                if (displaycard.style.display == "none") {
                    document.getElementById("card_Maintenancetitle").innerText = "تعديل البيانات";
                    displaycard.style.display = "block";
                    document.getElementById('card_Maintenancetitle').scrollIntoView();
                } else {
                    displaycard.style.display = "none";
                    document.getElementById('card_Maintenancetitle').innerText = "";
                    document.getElementById('card_Maintenancetitle').innerText = "تعديل البيانات";
                    displaycard.style.display = "block";
                    document.getElementById('card_Maintenancetitle').scrollIntoView();

                }
                $('#Ma2_FK_Ma').val(value['Ma_ID']);
                $('.MaintenanceItem').prop('disabled', false);

                if ($('#Ma_State').val() == 'Active') {
                    $('.MaintenanceSave').prop('disabled', true);
                    $('.Maintenance2Add').prop('disabled', true);
                    $('.Maintenance2Save').prop('disabled', true);
                }

            });

        }
    });

    var displaycard = document.getElementById("Maintenance2card");
    if (displaycard.style.display == "block") {
        var tabldata = $('#Maintenance2_data').DataTable();
        tabldata.destroy();
        displaycard.style.display = "none";
    }

    var displaycard2 = document.getElementById("Maintenance2action");
    if (displaycard2.style.display == "block") {
        var tabldata = $('#Maintenance2_data').DataTable();
        tabldata.destroy();
        displaycard2.style.display = "none";
    }



});

$(document).on('change', '.Ma_Filter', function() {

    var tablerefresh = $('#Maintenance_data').DataTable();
    tablerefresh.destroy();
    Maintenance_fetch();



});

$(document).on('click', '.MaintenancePrint', function() {

    var tabledata = $('#Maintenance_data').DataTable();
    var Maintenance = tabledata.row($(this).closest('tr')).data();
    var Maintenancevalue = Maintenance[Object.keys(Maintenance)[0]];

    var data = {
        'getMaintenanceNumber': Maintenancevalue,
        'TitleReport': 'سلفة الصيانة',
    };

    $.ajax({
        type: "GET",
        url: "datamaintenance",
        data: data,
        success: function(response) {

            var a = document.createElement('a');
            a.href = "printMaintenance";
            window.open(a.href, '_blank');

        }

    });
});



function Maintenance_cleardata() {
    $('#Ma_ID').val('');
    $('#Ma_Number').val('');
    $('#Ma_Date').val('');
    $('#Ma_State').val('');

}

function Maintenance_checkdata() {
    if ($.trim($('.Ma_Number').val()).length == 0) {
        error_Ma_Number = "مطلوب";
        $('#error_Ma_Number').text(error_Ma_Number);
    } else {
        error_Ma_Number = "";
        $('#error_Ma_Number').text(error_Ma_Number);
    }
    if ($.trim($('.Ma_Date').val()).length == 0) {
        error_Ma_Date = "مطلوب";
        $('#error_Ma_Date').text(error_Ma_Date);
    } else {
        error_Ma_Date = "";
        $('#error_Ma_Date').text(error_Ma_Date);
    }
    if ($.trim($('.Ma_State').val()).length == 0) {
        error_Ma_State = "مطلوب";
        $('#error_Ma_State').text(error_Ma_State);
    } else {
        error_Ma_State = "";
        $('#error_Ma_State').text(error_Ma_State);
    }

}

function Maintenance_insertdata() {
    var data = {
        'Ma_Number': $('.Ma_Number').val(),
        'Ma_Date': $('.Ma_Date').val(),
        'Ma_State': $('.Ma_State').val(),

    };

    $.ajax({
        method: "POST",
        url: "maintenance-store",
        data: data,

        success: function(response) {
            alertify.set('notifier', 'position', 'top-center');
            alertify.success(response.status);

            var tabldata = $('#Maintenance_data').DataTable();
            tabldata.ajax.reload();


        }
    });
}

function Maintenance_filldata() {
    $(document).ready(function() {
        $.ajax({
            type: "GET",
            url: "maintenance-filldata",
            success: function(response) {

                $('#Ma_State').append('<option selected>' + "Select State" + '</option>');
                $.each(response.getstate, function(indexInArray, valueOfElement) {
                    $('#Ma_State').append('<option value="' + valueOfElement.St_Name + '">' + valueOfElement.St_Name + '</option>');
                });

            }
        });

    });
}

function Maintenance_fetch() {

    $(document).ready(function() {
        var MaintenanceState = $('#Ma_Filter').val();
        var data = {
            'maState': MaintenanceState,
        };
        var tabledata = $('#Maintenance_data').DataTable({

            "responsive": true,
            "processing": true,
            "serverSide": true,

            "order": [],
            "ajax": {
                type: "GET",
                data: data,
                url: "maintenance-fetch",
            },

            "columns": [{
                    "data": "Ma_ID"
                },
                {
                    "data": "Ma_Number"
                },
                {
                    "data": "Ma_Date"
                },
                {
                    "data": "Ma_State"
                },
                {
                    "data": null,
                    render: function(data, type) {
                        return type === 'display' ?
                            '<button  class="btn btn-success btn-sm m-1 MaintenanceEdit"><i class="bi bi-pen"></i> تعديل </button>' +
                            '<button  class="btn btn-danger btn-sm m-1 MaintenanceDelete"><i class="bi bi-trash"></i> حذف </button>' +
                            '<button  class="btn btn-secondary btn-sm m-1 MaintenancePrint"><i class="bi bi-printer"></i>  طباعة</button>' : data;
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
                "processing": "معالجة.....",
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

function Maintenance_update() {
    var data = {
        'Ma_ID': $('.Ma_ID').val(),
        'Ma_Number': $('.Ma_Number').val(),
        'Ma_Date': $('.Ma_Date').val(),
        'Ma_State': $('.Ma_State').val(),

    };

    $.ajax({
        method: "POST",
        url: "maintenance-update",
        data: data,
        success: function(response) {
            alertify.set('notifier', 'position', 'top-center');
            alertify.success(response.status);
            var tabldata = $('#Maintenance_data').DataTable();
            tabldata.ajax.reload();


        }
    });
}



function number_format(number, decimals, decPoint, thousandsSep) {
    decimals = decimals || 0;
    number = parseFloat(number);

    if (!decPoint || !thousandsSep) {
        decPoint = '.';
        thousandsSep = ',';
    }

    var roundedNumber = Math.round(Math.abs(number) * ('1e' + decimals)) + '';
    var numbersString = decimals ? roundedNumber.slice(0, decimals * -1) : roundedNumber;
    var decimalsString = decimals ? roundedNumber.slice(decimals * -1) : '';
    var formattedNumber = "";

    while (numbersString.length > 3) {
        formattedNumber += thousandsSep + numbersString.slice(-3)
        numbersString = numbersString.slice(0, -3);
    }

    return (number < 0 ? '-' : '') + numbersString + formattedNumber + (decimalsString ? (decPoint + decimalsString) : '');
}

//disabled buttons on datatable


// JobCard Secondary
$(document).on('click', '.MaintenanceItem', function() {
    var displaycard = document.getElementById("Maintenance2card");
    if (displaycard.style.display == "none") {
        Maintenance2_fetch();
        Maintenance2_filldata();
        displaycard.style.display = "block";
        document.getElementById('Maintenance2card').scrollIntoView();
    } else {
        var tabldata = $('#Maintenance2_data').DataTable();
        tabldata.destroy();
        displaycard.style.display = "none";
    }
    var displaycard2 = document.getElementById("Maintenance2action");
    if (displaycard2.style.display == "block") {
        tabldata.destroy();
        displaycard2.style.display = "none";
    }


});



$(document).on('click', '.Maintenance2Add', function() {
    var displaycard = document.getElementById("Maintenance2action");
    if (displaycard.style.display == "none") {
        document.getElementById("card_Maintenance2title").innerText = "اضافة مبلغ";
        displaycard.style.display = "block";
        document.getElementById('card_Maintenance2title').scrollIntoView();
    } else {

        displaycard.style.display = "none";
        document.getElementById("card_Maintenance2title").innerText = "";
        Maintenance2_cleardata();
        displaycard.style.display = "block";
        document.getElementById("card_Maintenance2title").innerText = "اضافة مبلغ";
        document.getElementById('card_Maintenance2title').scrollIntoView();

    }
});
$(document).on('click', '.Maintenance2Close', function() {
    var displaycard = document.getElementById("Maintenance2action");
    Maintenance2_cleardata();
    document.getElementById("card_Maintenance2title").innerText = "";
    displaycard.style.display = "none";


});

$(document).on('click', '.Maintenance2Save', function() {

    var Ma2_ID = document.getElementById("Ma2_ID").value;

    if (Ma2_ID == '') {

        Maintenance2_checkdata();

        if (error_Ma2_Date != '' || error_Ma2_Money != '' || error_Ma2_CarNo != '' || error_Ma2_CarType != '' ||
            error_Ma2_Notes != '') {
            return false;
        } else {

            Maintenance2_insertdata();
            Maintenance2_cleardata();
        }
    } else {
        Maintenance2_update();
        Maintenance2_cleardata();
    }

});

$(document).on('click', '.Maintenance2Delete', function() {

    var tabledata = $('#Maintenance2_data').DataTable();
    var Maintenance2 = tabledata.row($(this).closest('tr')).data();
    var Maintenance2value = Maintenance2[Object.keys(Maintenance2)[0]];

    $.ajax({
        type: "GET",
        url: "users-getPermissions",
        success: function(response) {

            $.each(response, function(indexInArray, valueOfElement) {

                if (valueOfElement.P_Delete) {

                    $.ajax({
                        type: "POST",
                        url: "maintenance2-delete",
                        data: {
                            'getid': Maintenance2value,
                        },

                        success: function(response) {
                            alertify.set('notifier', 'position', 'top-center');
                            alertify.success(response.status);
                            $('#Maintenance2_data').DataTable().ajax.reload();
                            // Maintenance2_total();
                            // var tabldata3 = $('#Maintenance_data').DataTable();
                            // tabldata3.ajax.reload();
                        }
                    });
                } else {
                    $('.Maintenance2Delete').prop('disabled', true);
                }


            });

        }
    });






});

$(document).on('click', '.Maintenance2Edit', function() {
    var tabledata = $('#Maintenance2_data').DataTable();
    var Maintenance2 = tabledata.row($(this).closest('tr')).data();
    var Maintenance2value = Maintenance2[Object.keys(Maintenance2)[0]];
    $.ajax({
        type: "GET",
        url: "maintenance2-edit",
        data: {
            'getid': Maintenance2value,
        },

        success: function(response) {

            $.each(response, function(key, value) {

                $('#Ma2_ID').val(value['Ma2_ID']);
                $('#Ma2_FK_Ma').val(value['Ma2_FK_Ma']);
                $('#Ma2_Date').val(value['Ma2_Date']);
                $('#Ma2_Money').val(value['Ma2_Money']);
                $('#Ma2_CarNo').val(value['Ma2_CarNo']);
                $('#Ma2_CarType').val(value['Ma2_CarType']);
                $('#Ma2_Notes').val(value['Ma2_Notes']);


                var displaycard = document.getElementById("Maintenance2action");
                if (displaycard.style.display == "none") {
                    document.getElementById("card_Maintenance2title").innerText = "تعديل البيانات";
                    displaycard.style.display = "block";
                    document.getElementById('card_Maintenance2title').scrollIntoView();
                } else {
                    displaycard.style.display = "none";
                    document.getElementById('card_Maintenance2title').innerText = "";
                    document.getElementById('card_Maintenance2title').innerText = "تعديل البيانات";
                    displaycard.style.display = "block";
                    document.getElementById('card_Maintenance2title').scrollIntoView();

                }

            });

        }
    });
});

// prevent write any char or special char in textbox
$(document).ready(function() {
    
    $('#Ma2_Money').on('keypress', function(event) {
        var regex = new RegExp("^[.0-9]+$");
        var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
        if (!regex.test(key)) {
            event.preventDefault();
            return false;
        }
    });



});

$(document).ready(function() {
    $('#Ma2_CarNo').on("keyup change", function(e) {
        var carno = $('#Ma2_CarNo').val();
        if (carno == '') {
            $('#Ma2_CarType').val('');
            
        } else {

            var data = {
                'getcarno': carno,
            };
            $.ajax({
                type: "GET",
                url: "maintenance2-getcarinformations",
                data: data,
                success: function(response) {
                    console.log(response);
                    $.each(response.getcarinformations, function(indexInArray, valueOfElement) {

                        $('#Ma2_CarType').val(valueOfElement.CarType);
                       
                    });

                }
            });
        }

    });
});





function Maintenance2_cleardata() {
    $('#Ma2_ID').val('');
    $('#Ma2_Date').val('');
    $('#Ma2_Money').val('');
    $('#Ma2_CarNo').val('');
    $('#Ma2_CarType').val('');
    $('#Ma2_Notes').val('');



}

function Maintenance2_checkdata() {
    if ($.trim($('.Ma2_Date').val()).length == 0) {
        error_Ma2_Date = "مطلوب";
        $('#error_Ma2_Date').text(error_Ma2_Date);
    } else {
        error_Ma2_Date = "";
        $('#error_Ma2_Date').text(error_Ma2_Date);
    }
    if ($.trim($('.Ma2_Money').val()).length == 0) {
        error_Ma2_Money = "مطلوب";
        $('#error_Ma2_Money').text(error_Ma2_Money);
    } else {
        error_Ma2_Money = "";
        $('#error_Ma2_Money').text(error_Ma2_Money);
    }
    if ($.trim($('.Ma2_CarNo').val()).length == 0) {
        error_Ma2_CarNo = "مطلوب";
        $('#error_Ma2_CarNo').text(error_Ma2_CarNo);
    } else {
        error_Ma2_CarNo = "";
        $('#error_Ma2_CarNo').text(error_Ma2_CarNo);
    }
    if ($.trim($('.Ma2_CarType').val()).length == 0) {
        error_Ma2_CarType = "مطلوب";
        $('#error_Ma2_CarType').text(error_Ma2_CarType);
    } else {
        error_Ma2_CarType = "";
        $('#error_Ma2_CarType').text(error_Ma2_CarType);
    }
    if ($.trim($('.Ma2_Notes').val()).length == 0) {
        error_Ma2_Notes = "مطلوب";
        $('#error_Ma2_Notes').text(error_Ma2_Notes);
    } else {
        error_Ma2_Notes = "";
        $('#error_Ma2_Notes').text(error_Ma2_Notes);
    }

}

function Maintenance2_insertdata() {
    var data = {
        'Ma2_FK_Ma': $('#Ma2_FK_Ma').val(),
        'Ma2_Date': $('#Ma2_Date').val(),
        'Ma2_Money': $('#Ma2_Money').val(),
        'Ma2_CarNo': $('#Ma2_CarNo').val(),
        'Ma2_CarType': $('#Ma2_CarType').val(),
        'Ma2_Notes': $('#Ma2_Notes').val(),
    };

    $.ajax({
        type: "POST",
        url: "maintenance2-store",
        data: data,
        success: function(response) {
            alertify.set('notifier', 'position', 'top-center');
            alertify.success(response.status);
            var tabldata2 = $('#Maintenance2_data').DataTable();
            tabldata2.ajax.reload();


        }
    });
}

function Maintenance2_filldata() {
    $(document).ready(function() {
        $.ajax({
            type: "GET",
            url: "maintenance2-filldata",
            success: function(response) {
                $('#Ma2_CarNoBrowser').empty();
                $.each(response.getcarno, function(indexInArray, valueOfElement) {
                    $('#Ma2_CarNoBrowser').append('<option value="' + valueOfElement.CarNO + '">');
                });

                $('#Ma2_CarTypeBrowser').empty();
                $.each(response.getcartype, function(indexInArray, valueOfElement) {
                    $('#Ma2_CarTypeBrowser').append('<option value="' + valueOfElement.CarType + '">');
                });



            }
        });

    });
}

function Maintenance2_fetch() {

    $(document).ready(function() {
        var i=1;
        var tabledata2 = $('#Maintenance2_data').DataTable({

            "responsive": true,
            "processing": true,
            "serverSide": true,

            "order": [],
            "ajax": {
                type: "GET",
                data: {
                    'getid': $('#Ma2_FK_Ma').val(),
                },
                url: "maintenance2-fetch",
            },

            "columns": [  
                  {
                    "data":"Ma2_ID"
                  },
                {
                    "data": "Ma2_Date"
                },
                {
                    "data": "Ma2_Money",
                    render: $.fn.dataTable.render.number( ',', '.', 0 )
                },
                {
                    "data": "Ma2_CarNo"
                },
                {
                    "data": "Ma2_CarType"
                },
                {
                    "data": "Ma2_Notes"
                },
                {
                    "data": null,
                    render: function(data, type) {
                        return type === 'display' ?
                            '<button  class="btn btn-success btn-sm m-1 Maintenance2Edit"><i class="bi bi-pen"></i> تعديل </button>' +
                            '<button  class="btn btn-danger btn-sm m-1 Maintenance2Delete"><i class="bi bi-trash"></i> حذف </button>' +
                            '<button  class="btn btn-secondary btn-sm m-1 Maintenance2Display"><i class="bi bi-info"></i></button>' : data;
                    }
                }



            ],
            "columnDefs": [
               
                {
                    "targets": [0, 5],
                    "orderable": false,
                },
               

            ],
            "lengthMenu": [
                [50, 100],
                [50, 100]
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
                "processing": "معالجة.....",
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
        tabledata2.on( 'draw.dt', function () {
            var PageInfo = $('#Maintenance2_data').DataTable().page.info();
                 tabledata2.column(0, { page: 'current' }).nodes().each( function (cell, i) {
                    cell.innerHTML = i + 1 + PageInfo.start;
                } );
            } );



    });


}

function Maintenance2_update() {
    var data = {
        'Ma2_ID': $('#Ma2_ID').val(),
        'Ma2_FK_Ma': $('#Ma2_FK_Ma').val(),
        'Ma2_Date': $('#Ma2_Date').val(),
        'Ma2_Money': $('#Ma2_Money').val(),
        'Ma2_CarNo': $('#Ma2_CarNo').val(),
        'Ma2_CarType': $('#Ma2_CarType').val(),
        'Ma2_Notes': $('#Ma2_Notes').val(),




    };
    $.ajax({
        type: "POST",
        url: "maintenance2-update",
        data: data,
        success: function(response) {
            alertify.set('notifier', 'position', 'top-center');
            alertify.success(response.status);
            var tabldata2 = $('#Maintenance2_data').DataTable();
            tabldata2.ajax.reload();
            Maintenance2_total();
            var tabldata3 = $('#Maintenance_data').DataTable();
            tabldata3.ajax.reload();

        }
    });
}



