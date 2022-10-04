fuelMoney_fetch();
fuelMoney_filldata();


$(document).on('click', '.fuelMoneyAdd', function() {
    var displaycard = document.getElementById("fuelMoneyaction");
    if (displaycard.style.display == "none") {
        document.getElementById("card_fuelMoneytitle").innerText = "اضافة سلفة";
        $.ajax({
            type: "GET",
            url: "fuelMoney-maxfuel",
            success: function(response) {
                $.each(response.getmaxFm, function(indexInArray, valueOfElement) {
                    $('#Fm_Number').val(valueOfElement.MaxValue);
                });

                $('#Fm_State').val('Inactive');

            }
        });
        displaycard.style.display = "block";
        document.getElementById('card_fuelMoneytitle').scrollIntoView();
    } else {

        displaycard.style.display = "none";
        document.getElementById("card_fuelMoneytitle").innerText = "";
        fuelMoney_cleardata();
        displaycard.style.display = "block";
        document.getElementById("card_fuelMoneytitle").innerText = "اضافة سلفة جديدة";
        document.getElementById('card_fuelMoneytitle').scrollIntoView();

    }
});
$(document).on('click', '.fuelMoneyClose', function() {
    var displaycard = document.getElementById("fuelMoneyaction");
    fuelMoney_cleardata();
    document.getElementById("card_fuelMoneytitle").innerText = "";
    $('.fuelMoneyItem').prop('disabled', true);
    displaycard.style.display = "none";

    var displaycard2 = document.getElementById("fuelMoney2action");
    fuelMoney2_cleardata();
    document.getElementById("card_fuelMoney2title").innerText = "";
    displaycard2.style.display = "none";

    var displaycard3 = document.getElementById("fuelMoney2card");
    var tabldata = $('#fuelMoney2_data').DataTable();
    tabldata.destroy();
    displaycard3.style.display = "none";




});

$(document).on('click', '.fuelMoneySave', function() {

    var Fm_ID = document.getElementById("Fm_ID").value;

    if (Fm_ID == '') {

        fuelMoney_checkdata();

        if (error_Fm_Number != '' || error_Fm_Date != '' || error_Fm_State != '') {

            return false;
        } else {

            fuelMoney_insertdata();
            fuelMoney_cleardata();
        }
    } else {
        fuelMoney_checkdata();
        if (error_Fm_Number != '' || error_Fm_Date != '' || error_Fm_State != '') {

            return false;
        } else {
            fuelMoney_update();
            fuelMoney_cleardata();
        }
    }

});

$(document).on('click', '.fuelMoneyDelete', function() {
    var tabledata = $('#fuelMoney_data').DataTable();
    var fuelMoney = tabledata.row($(this).closest('tr')).data();
    var fuelMoneyvalue = fuelMoney[Object.keys(fuelMoney)[0]];
    $.ajax({
        type: "GET",
        url: "users-getPermissions",
        success: function(response) {

            $.each(response, function(indexInArray, valueOfElement) {
                if (valueOfElement.P_Delete) {
                    $.ajax({
                        type: "POST",
                        url: "fuelMoney-delete",
                        data: {
                            'getid': fuelMoneyvalue,
                        },

                        success: function(response) {
                            alertify.set('notifier', 'position', 'top-center');
                            alertify.success(response.status);
                            $('#fuelMoney_data').DataTable().ajax.reload();
                        }
                    });
                } else {
                    $('.fuelMoneyDelete').prop('disabled', true);
                }


            });

        }
    });





});

$(document).on('click', '.fuelMoneyEdit', function() {
    var tabledata = $('#fuelMoney_data').DataTable();
    var fuelMoney = tabledata.row($(this).closest('tr')).data();
    var fuelMoneyvalue = fuelMoney[Object.keys(fuelMoney)[0]];
    $.ajax({
        type: "GET",
        url: "fuelMoney-edit",
        data: {
            'getid': fuelMoneyvalue,
        },

        success: function(response) {

            $.each(response, function(key, value) {

                $('#Fm_ID').val(value['Fm_ID']);
                $('#Fm_Number').val(value['Fm_Number']);
                $('#Fm_Date').val(value['Fm_Date']);
                $('#Fm_State').val(value['Fm_State']);



                var displaycard = document.getElementById("fuelMoneyaction");
                if (displaycard.style.display == "none") {
                    document.getElementById("card_fuelMoneytitle").innerText = "تعديل البيانات";
                    displaycard.style.display = "block";
                    document.getElementById('card_fuelMoneytitle').scrollIntoView();
                } else {
                    displaycard.style.display = "none";
                    document.getElementById('card_fuelMoneytitle').innerText = "";
                    document.getElementById('card_fuelMoneytitle').innerText = "تعديل البيانات";
                    displaycard.style.display = "block";
                    document.getElementById('card_fuelMoneytitle').scrollIntoView();

                }
                $('#Fm1_FK_Fm').val(value['Fm_ID']);
                $('.fuelMoneyItem').prop('disabled', false);

                if ($('#Fm_State').val() == 'Active') {
                    $('.fuelMoneySave').prop('disabled', true);
                    $('.fuelMoney2Add').prop('disabled', true);
                    $('.fuelMoney2Save').prop('disabled', true);
                }

            });

        }
    });

    var displaycard = document.getElementById("fuelMoney2card");
    if (displaycard.style.display == "block") {
        var tabldata = $('#fuelMoney2_data').DataTable();
        tabldata.destroy();
        displaycard.style.display = "none";
    }

    var displaycard2 = document.getElementById("fuelMoney2action");
    if (displaycard2.style.display == "block") {
        var tabldata = $('#fuelMoney2_data').DataTable();
        tabldata.destroy();
        displaycard2.style.display = "none";
    }



});

$(document).on('change', '.Fm_Filter', function() {

    var tablerefresh = $('#fuelMoney_data').DataTable();
    tablerefresh.destroy();
    fuelMoney_fetch();



});

$(document).on('click', '.fuelMoneyPrint', function() {

    var tabledata = $('#fuelMoney_data').DataTable();
    var fuelMoney = tabledata.row($(this).closest('tr')).data();
    var fuelMoneyvalue = fuelMoney[Object.keys(fuelMoney)[0]];

    var data = {
        'getfuelmoneynumber': fuelMoneyvalue,
        'TitleReport': 'سلفة الوقود',
    };

    $.ajax({
        type: "GET",
        url: "datainfo",
        data: data,
        success: function(response) {

            var a = document.createElement('a');
            a.href = "printfuelmoney";
            window.open(a.href, '_blank');

        }

    });
});



function fuelMoney_cleardata() {
    $('#Fm_ID').val('');
    $('#Fm_Number').val('');
    $('#Fm_Date').val('');
    $('#Fm_State').val('');

}

function fuelMoney_checkdata() {
    if ($.trim($('.Fm_Number').val()).length == 0) {
        error_Fm_Number = "plz, input the JobCard Number";
        $('#error_Fm_Number').text(error_Fm_Number);
    } else {
        error_Fm_Number = "";
        $('#error_Fm_Number').text(error_Fm_Number);
    }
    if ($.trim($('.Fm_Date').val()).length == 0) {
        error_Fm_Date = "مطلوب";
        $('#error_Fm_Date').text(error_Fm_Date);
    } else {
        error_Fm_Date = "";
        $('#error_Fm_Date').text(error_Fm_Date);
    }
    if ($.trim($('.Fm_State').val()).length == 0) {
        error_Fm_State = "مطلوب";
        $('#error_Fm_State').text(error_Fm_State);
    } else {
        error_Fm_State = "";
        $('#error_Fm_State').text(error_Fm_State);
    }

}

function fuelMoney_insertdata() {
    var data = {
        'Fm_Number': $('.Fm_Number').val(),
        'Fm_Date': $('.Fm_Date').val(),
        'Fm_State': $('.Fm_State').val(),

    };

    $.ajax({
        method: "POST",
        url: "fuelMoney-store",
        data: data,

        success: function(response) {
            alertify.set('notifier', 'position', 'top-center');
            alertify.success(response.status);

            var tabldata = $('#fuelMoney_data').DataTable();
            tabldata.ajax.reload();


        }
    });
}

function fuelMoney_filldata() {
    $(document).ready(function() {
        $.ajax({
            type: "GET",
            url: "fuelMoney-filldata",
            success: function(response) {

                $('#Fm_State').append('<option selected>' + "Select State" + '</option>');
                $.each(response.getstate, function(indexInArray, valueOfElement) {
                    $('#Fm_State').append('<option value="' + valueOfElement.St_Name + '">' + valueOfElement.St_Name + '</option>');
                });

            }
        });

    });
}

function fuelMoney_fetch() {

    $(document).ready(function() {
        var fuelMoneyState = $('#Fm_Filter').val();
        var data = {
            'fmState': fuelMoneyState,
        };
        var tabledata = $('#fuelMoney_data').DataTable({

            "responsive": true,
            "processing": true,
            "serverSide": true,

            "order": [],
            "ajax": {
                type: "GET",
                data: data,
                url: "fuelMoney-fetch",
            },

            "columns": [{
                    "data": "Fm_ID"
                },
                {
                    "data": "Fm_Number"
                },
                {
                    "data": "Fm_Date"
                },
                {
                    "data": "Fm_State"
                },
                {
                    "data": null,
                    render: function(data, type) {
                        return type === 'display' ?
                            '<button  class="btn btn-success btn-sm m-1 fuelMoneyEdit"><i class="bi bi-pen"></i> تعديل </button>' +
                            '<button  class="btn btn-danger btn-sm m-1 fuelMoneyDelete"><i class="bi bi-trash"></i> حذف </button>' +
                            '<button  class="btn btn-secondary btn-sm m-1 fuelMoneyPrint"><i class="bi bi-printer"></i>  طباعة</button>' : data;
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

function fuelMoney_update() {
    var data = {
        'Fm_ID': $('.Fm_ID').val(),
        'Fm_Number': $('.Fm_Number').val(),
        'Fm_Date': $('.Fm_Date').val(),
        'Fm_State': $('.Fm_State').val(),

    };

    $.ajax({
        method: "POST",
        url: "fuelMoney-update",
        data: data,
        success: function(response) {
            alertify.set('notifier', 'position', 'top-center');
            alertify.success(response.status);
            var tabldata = $('#fuelMoney_data').DataTable();
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
$(document).on('click', '.fuelMoneyItem', function() {
    var displaycard = document.getElementById("fuelMoney2card");
    if (displaycard.style.display == "none") {
        fuelMoney2_fetch();
        fuelMoney2_filldata();
        displaycard.style.display = "block";
        document.getElementById('fuelMoney2card').scrollIntoView();
    } else {
        var tabldata = $('#fuelMoney2_data').DataTable();
        tabldata.destroy();
        displaycard.style.display = "none";
    }
    var displaycard2 = document.getElementById("fuelMoney2action");
    if (displaycard2.style.display == "block") {
        tabldata.destroy();
        displaycard2.style.display = "none";
    }


});



$(document).on('click', '.fuelMoney2Add', function() {
    var displaycard = document.getElementById("fuelMoney2action");
    if (displaycard.style.display == "none") {
        document.getElementById("card_fuelMoney2title").innerText = "اضافة مبلغ";
        displaycard.style.display = "block";
        document.getElementById('card_fuelMoney2title').scrollIntoView();
    } else {

        displaycard.style.display = "none";
        document.getElementById("card_fuelMoney2title").innerText = "";
        fuelMoney2_cleardata();
        displaycard.style.display = "block";
        document.getElementById("card_fuelMoney2title").innerText = "اضافة مبلغ";
        document.getElementById('card_fuelMoney2title').scrollIntoView();

    }
});
$(document).on('click', '.fuelMoney2Close', function() {
    var displaycard = document.getElementById("fuelMoney2action");
    fuelMoney2_cleardata();
    document.getElementById("card_fuelMoney2title").innerText = "";
    displaycard.style.display = "none";


});

$(document).on('click', '.fuelMoney2Save', function() {

    var Fm1_ID = document.getElementById("Fm1_ID").value;

    if (Fm1_ID == '') {

        fuelMoney2_checkdata();

        if (error_Fm1_Date != '' || error_Fm1_Money != '' || error_Fm1_CarNo != '' || error_Fm1_CarType != '' ||
            error_Fm1_Meter != '') {
            return false;
        } else {

            fuelMoney2_insertdata();
            fuelMoney2_cleardata();
        }
    } else {
        fuelMoney2_update();
        fuelMoney2_cleardata();
    }

});

$(document).on('click', '.fuelMoney2Delete', function() {

    var tabledata = $('#fuelMoney2_data').DataTable();
    var fuelMoney2 = tabledata.row($(this).closest('tr')).data();
    var fuelMoney2value = fuelMoney2[Object.keys(fuelMoney2)[0]];

    $.ajax({
        type: "GET",
        url: "users-getPermissions",
        success: function(response) {

            $.each(response, function(indexInArray, valueOfElement) {

                if (valueOfElement.P_Delete) {

                    $.ajax({
                        type: "POST",
                        url: "fm1-delete",
                        data: {
                            'getid': fuelMoney2value,
                        },

                        success: function(response) {
                            alertify.set('notifier', 'position', 'top-center');
                            alertify.success(response.status);
                            $('#fuelMoney2_data').DataTable().ajax.reload();
                            // fuelMoney2_total();
                            // var tabldata3 = $('#fuelMoney_data').DataTable();
                            // tabldata3.ajax.reload();
                        }
                    });
                } else {
                    $('.fuelMoney2Delete').prop('disabled', true);
                }


            });

        }
    });






});

$(document).on('click', '.fuelMoney2Edit', function() {
    var tabledata = $('#fuelMoney2_data').DataTable();
    var fuelMoney2 = tabledata.row($(this).closest('tr')).data();
    var fuelMoney2value = fuelMoney2[Object.keys(fuelMoney2)[0]];
    $.ajax({
        type: "GET",
        url: "fm1-edit",
        data: {
            'getid': fuelMoney2value,
        },

        success: function(response) {

            $.each(response, function(key, value) {

                $('#Fm1_ID').val(value['Fm1_ID']);
                $('#Fm1_FK_Fm').val(value['Fm1_FK_Fm']);
                $('#Fm1_Date').val(value['Fm1_Date']);
                $('#Fm1_Quantity').val(value['Fm1_Quantity']);
                $('#Fm1_Money').val(value['Fm1_Money']);
                $('#Fm1_CarNo').val(value['Fm1_CarNo']);
                $('#Fm1_CarType').val(value['Fm1_CarType']);
                $('#Fm1_Meter').val(value['Fm1_Meter']);
                $('#Fm1_DriverName').val(value['Fm1_DriverName']);

                var displaycard = document.getElementById("fuelMoney2action");
                if (displaycard.style.display == "none") {
                    document.getElementById("card_fuelMoney2title").innerText = "تعديل البيانات";
                    displaycard.style.display = "block";
                    document.getElementById('card_fuelMoney2title').scrollIntoView();
                } else {
                    displaycard.style.display = "none";
                    document.getElementById('card_fuelMoney2title').innerText = "";
                    document.getElementById('card_fuelMoney2title').innerText = "تعديل البيانات";
                    displaycard.style.display = "block";
                    document.getElementById('card_fuelMoney2title').scrollIntoView();

                }

            });

        }
    });
});

// prevent write any char or special char in textbox
$(document).ready(function() {
    $('#Fm1_Meter').on('keypress', function(event) {
        var regex = new RegExp("^[.0-9]+$");
        var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
        if (!regex.test(key)) {
            event.preventDefault();
            return false;
        }
    });
    $('#Fm1_Money').on('keypress', function(event) {
        var regex = new RegExp("^[.0-9]+$");
        var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
        if (!regex.test(key)) {
            event.preventDefault();
            return false;
        }
    });
    $('#Fm1_Quantity').on('keypress', function(event) {
        var regex = new RegExp("^[.0-9]+$");
        var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
        if (!regex.test(key)) {
            event.preventDefault();
            return false;
        }
    });

});

$(document).ready(function() {
    $('#Fm1_Quantity').keyup(function() {

        var total = 0;
        var x = Number($('#Fm1_Price').val());
        var y = Number($('#Fm1_Quantity').val());
        var total = x * y;
        $('#Fm1_Money').val(total);

    });
});

$(document).on('change','.Fm1_FuelType', function () {
   
        var fueltype = $('#Fm1_FuelType').val();
        if (fueltype == '' || fueltype=='اختر نوع الوقود') {
            $('#Fm1_Price').val('');
            
        } else {

            var data = {
                'getfueltype': fueltype,
            };
            $.ajax({
                type: "GET",
                url: "fueltype-getfuelprice",
                data: data,
                success: function(response) {
                    console.log(response);
                    $.each(response.getfuelprice, function(indexInArray, valueOfElement) {

                        $('#Fm1_Price').val(valueOfElement.Ft_Price);
                       
                    });

                }
            });
        }

    
});


$(document).ready(function() {
    $('#Fm1_CarNo').on("keyup change", function(e) {
        var carno = $('#Fm1_CarNo').val();
        if (carno == '') {
            $('#Fm1_CarType').val('');
            
        } else {

            var data = {
                'getcarno': carno,
            };
            $.ajax({
                type: "GET",
                url: "fm1-getcarinformations",
                data: data,
                success: function(response) {
                    console.log(response);
                    $.each(response.getcarinformations, function(indexInArray, valueOfElement) {

                        $('#Fm1_CarType').val(valueOfElement.CarType);
                       
                    });

                }
            });
        }

    });
});





function fuelMoney2_cleardata() {
    $('#Fm1_ID').val('');
    $('#Fm1_Date').val('');
    $('#Fm1_FuelType').val('');
    $('#Fm1_Quantity').val('');
    $('#Fm1_Money').val('');
    $('#Fm1_CarNo').val('');
    $('#Fm1_CarType').val('');
    $('#Fm1_Meter').val('');
    $('#Fm1_DriverName').val('');


}

function fuelMoney2_checkdata() {
    if ($.trim($('.Fm1_Date').val()).length == 0) {
        error_Fm1_Date = "مطلوب";
        $('#error_Fm1_Date').text(error_Fm1_Date);
    } else {
        error_Fm1_Date = "";
        $('#error_Fm1_Date').text(error_Fm1_Date);
    }
    if ($.trim($('.Fm1_Quantity').val()).length == 0) {
        error_Fm1_Quantity = "مطلوب";
        $('#error_Fm1_Quantity').text(error_Fm1_Quantity);
    } else {
        error_Fm1_Quantity = "";
        $('#error_Fm1_Quantity').text(error_Fm1_Quantity);
    }
    if ($.trim($('.Fm1_Money').val()).length == 0) {
        error_Fm1_Money = "مطلوب";
        $('#error_Fm1_Money').text(error_Fm1_Money);
    } else {
        error_Fm1_Money = "";
        $('#error_Fm1_Money').text(error_Fm1_Money);
    }
    if ($.trim($('.Fm1_CarNo').val()).length == 0) {
        error_Fm1_CarNo = "مطلوب";
        $('#error_Fm1_CarNo').text(error_Fm1_CarNo);
    } else {
        error_Fm1_CarNo = "";
        $('#error_Fm1_CarNo').text(error_Fm1_CarNo);
    }
    if ($.trim($('.Fm1_CarType').val()).length == 0) {
        error_Fm1_CarType = "مطلوب";
        $('#error_Fm1_CarType').text(error_Fm1_CarType);
    } else {
        error_Fm1_CarType = "";
        $('#error_Fm1_CarType').text(error_Fm1_CarType);
    }
    if ($.trim($('.Fm1_Meter').val()).length == 0) {
        error_Fm1_Meter = "مطلوب";
        $('#error_Fm1_Meter').text(error_Fm1_Meter);
    } else {
        error_Fm1_Meter = "";
        $('#error_Fm1_Meter').text(error_Fm1_Meter);
    }
    if ($.trim($('.Fm1_DirverName').val()).length == 0) {
        error_Fm1_DirverName = "مطلوب";
        $('#error_Fm1_DirverName').text(error_Fm1_DirverName);
    } else {
        error_Fm1_DirverName = "";
        $('#error_Fm1_DirverName').text(error_Fm1_DirverName);
    }

}

function fuelMoney2_insertdata() {
    var data = {
        'Fm1_FK_Fm': $('#Fm1_FK_Fm').val(),
        'Fm1_Date': $('#Fm1_Date').val(),
        'Fm1_Quantity': $('#Fm1_Quantity').val(),
        'Fm1_Money': $('#Fm1_Money').val(),
        'Fm1_CarNo': $('#Fm1_CarNo').val(),
        'Fm1_CarType': $('#Fm1_CarType').val(),
        'Fm1_Meter': $('#Fm1_Meter').val(),
        'Fm1_DriverName': $('#Fm1_DriverName').val()
    };

    $.ajax({
        type: "POST",
        url: "fm1-store",
        data: data,
        success: function(response) {
            alertify.set('notifier', 'position', 'top-center');
            alertify.success(response.status);
            var tabldata2 = $('#fuelMoney2_data').DataTable();
            tabldata2.ajax.reload();


        }
    });
}

function fuelMoney2_filldata() {
    $(document).ready(function() {
        $.ajax({
            type: "GET",
            url: "fm1-filldata",
            success: function(response) {

                $('#Fm1_FuelType').append('<option selected>' + "اختر نوع الوقود" + '</option>');
                $.each(response.getfueltype, function(indexInArray, valueOfElement) {
                    $('#Fm1_FuelType').append('<option value="' + valueOfElement.Ft_Name + '">' + valueOfElement.Ft_Name + '</option>');
                });

                $('#Fm1_CarNoBrowser').empty();
                $.each(response.getcarno, function(indexInArray, valueOfElement) {
                    $('#Fm1_CarNoBrowser').append('<option value="' + valueOfElement.CarNO + '">');
                });

                $('#Fm1_CarTypeBrowser').empty();
                $.each(response.getcartype, function(indexInArray, valueOfElement) {
                    $('#Fm1_CarTypeBrowser').append('<option value="' + valueOfElement.CarType + '">');
                });

                $('#Fm1_DriverNameBrowser').empty();
                $.each(response.getdrivername, function(indexInArray, valueOfElement) {
                    $('#Fm1_DriverNameBrowser').append('<option value="' + valueOfElement.Emp_EmployeeName + '">');
                });


            }
        });

    });
}

function fuelMoney2_fetch() {

    $(document).ready(function() {
        var i=1;
        var tabledata2 = $('#fuelMoney2_data').DataTable({

            "responsive": true,
            "processing": true,
            "serverSide": true,

            "order": [],
            "ajax": {
                type: "GET",
                data: {
                    'getid': $('#Fm1_FK_Fm').val(),
                },
                url: "fm1-fetch",
            },

            "columns": [  
                  {
                    "data":"Fm1_ID"
                  },
                {
                    "data": "Fm1_Date"
                },
                {
                    "data": "Fm1_Money",
                    render: $.fn.dataTable.render.number( ',', '.', 0 )
                },
                {
                    "data": "Fm1_CarNo"
                },
                {
                    "data": "Fm1_CarType"
                },
                {
                    "data": "Fm1_Meter"
                },
                {
                    "data": null,
                    render: function(data, type) {
                        return type === 'display' ?
                            '<button  class="btn btn-success btn-sm m-1 fuelMoney2Edit"><i class="bi bi-pen"></i> تعديل </button>' +
                            '<button  class="btn btn-danger btn-sm m-1 fuelMoney2Delete"><i class="bi bi-trash"></i> حذف </button>' +
                            '<button  class="btn btn-secondary btn-sm m-1 fuelMoney2Display"><i class="bi bi-info"></i></button>' : data;
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
            var PageInfo = $('#fuelMoney2_data').DataTable().page.info();
                 tabledata2.column(0, { page: 'current' }).nodes().each( function (cell, i) {
                    cell.innerHTML = i + 1 + PageInfo.start;
                } );
            } );



    });


}

function fuelMoney2_update() {
    var data = {
        'Fm1_ID': $('#Fm1_ID').val(),
        'Fm1_FK_Fm': $('#Fm1_FK_Fm').val(),
        'Fm1_Date': $('#Fm1_Date').val(),
        'Fm1_Quantity': $('#Fm1_Quantity').val(),
        'Fm1_Money': $('#Fm1_Money').val(),
        'Fm1_CarNo': $('#Fm1_CarNo').val(),
        'Fm1_CarType': $('#Fm1_CarType').val(),
        'Fm1_Meter': $('#Fm1_Meter').val(),
        'Fm1_DriverName': $('#Fm1_DriverName').val(),



    };
    $.ajax({
        type: "POST",
        url: "fm1-update",
        data: data,
        success: function(response) {
            alertify.set('notifier', 'position', 'top-center');
            alertify.success(response.status);
            var tabldata2 = $('#fuelMoney2_data').DataTable();
            tabldata2.ajax.reload();
            fuelMoney2_total();
            var tabldata3 = $('#fuelMoney_data').DataTable();
            tabldata3.ajax.reload();

        }
    });
}



