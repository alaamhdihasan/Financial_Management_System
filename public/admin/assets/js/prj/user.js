fetchdata_users();
users_filldata();
$(document).on('click', '.usersAdd', function() {
    var displaycard = document.getElementById("usersaction");
    if (displaycard.style.display == "none") {
        document.getElementById("card_userstitle").innerText = "اضافة مستخدم جديد";
        displaycard.style.display = "block";
    } else {

        displaycard.style.display = "none";
        document.getElementById("card_userstitle").innerText = "";
        cleardata_users();
        displaycard.style.display = "block";
        document.getElementById("card_userstitle").innerText = "اضافة مستخدم جديد";

    }
});

$(document).on('click', '.usersSave', function() {

    var u_id = document.getElementById("u_id").value;

    if (u_id == '') {

        checkdata_users();
        if (error_u_username != '' || error_u_password != '' || error_u_state != '' || error_u_permission != '') {
            return false;
        } else {
            insertdata_users();
            cleardata_users();
        }
    } else {
        updatedata_users();
        cleardata_users();
    }

});

$(document).on('click', '.usersDelete', function() {
    var tabledata = $('#users_data').DataTable();
    var userid = tabledata.row($(this).closest('tr')).data();
    var useridvalue = userid[Object.keys(userid)[0]];

    $.ajax({
        type: "POST",
        url: "users-delete",
        data: {
            'getid': useridvalue,
        },

        success: function(response) {
            alertify.set('notifier', 'position', 'top-center');
            alertify.success(response.status);
            $('#users_data').DataTable().ajax.reload();
        }
    });
});

$(document).on('click', '.usersClose', function() {
    var displaycard = document.getElementById("usersaction");
    cleardata_users();
    document.getElementById("card_userstitle").innerText = "";
    displaycard.style.display = "none";


});

// Edit Button in DataTable...
$(document).on('click', '.usersEdit', function() {
    var tabledata = $('#users_data').DataTable();
    var userid = tabledata.row($(this).closest('tr')).data();
    var useridvalue = userid[Object.keys(userid)[0]];
    $.ajax({
        type: "GET",
        url: "users-edit",
        data: {
            'getid': useridvalue,
        },

        success: function(response) {

            $.each(response, function(key, value) {

                $('#u_id').val(value['U_ID']);
                $('#u_username').val(value['U_UserName']);
                $('#u_password').val(value['U_Password']);
                $('#u_state').val(value['U_State']);
                $('#u_permission').val(value['U_Permission']);
                $('#U_WorkPlace').val(value['U_WorkPlace']);


                var displaycard = document.getElementById("usersaction");
                if (displaycard.style.display == "none") {
                    document.getElementById("card_userstitle").innerText = "تعديل بيانات المستخدم";
                    displaycard.style.display = "block";
                } else {
                    displaycard.style.display = "none";
                    document.getElementById('card_userstitle').innerText = "";
                    document.getElementById('card_userstitle').innerText = "تعديل بيانات المستخدم";
                    displaycard.style.display = "block";

                }

            });

        }
    });
});

$(document).on('click', '.usersEdit2', function() {
    var tabledata = $('#users_data').DataTable();
    var userid = tabledata.row($(this).closest('tr')).data();
    var useridvalue = userid[Object.keys(userid)[0]];
    
    var data = {
        'getid': useridvalue,
    };


    $.ajax({
        type: 'get',
        url: "userprofile-fetch",
        data: data,
        success: function(response) {
            var pageName = "userprofile-fetch2";
            window.location.href = pageName;

        }
    });
});


function cleardata_users() {
    $('#u_id').val('');
    $('#u_username').val('');
    $('#u_password').val('');
    $('#u_state').val('');
    $('#u_permission').val('');



}

function checkdata_users() {
    if ($.trim($('.u_username').val()).length == 0) {
        error_u_username = "اسم المستخدم مطلوب";
        $('#error_u_username').text(error_u_username);
    } else {
        error_u_username = "";
        $('#error_u_username').text(error_u_username);
    }
    if ($.trim($('.u_password').val()).length == 0) {
        error_u_password = "كلمة المرور مطلوبة";
        $('#error_u_password').text(error_u_password);
    } else {
        error_u_password = "";
        $('#error_u_password').text(error_u_password);
    }
    if ($.trim($('.u_state').val()).length == 0) {
        error_u_state = "حالة المستخدم مطلوب";
        $('#error_u_state').text(error_u_state);
    } else {
        error_u_state = "";
        $('#error_u_state').text(error_u_state);
    }
    if ($.trim($('.u_permission').val()).length == 0) {
        error_u_permission = "الصلاحية مطلوبة";
        $('#error_u_permission').text(error_u_permission);
    } else {
        error_u_permission = "";
        $('#error_u_permission').text(error_u_permission);
    }

}

function insertdata_users() {
    var data = {
        'u_username': $('.u_username').val(),
        'u_password': $('.u_password').val(),
        'u_state': $('.u_state').val(),
        'u_permission': $('.u_permission').val(),
        'U_WorkPlace': $('.U_WorkPlace').val(),


    };
    $.ajax({
        method: "POST",
        url: "users-store",
        data: data,
        success: function(response) {
            alertify.set('notifier', 'position', 'top-right');
            alertify.success(response.status);
            var tabldata = $('#users_data').DataTable();
            tabldata.ajax.reload();


        }
    });
}

function users_filldata() {
    $(document).ready(function() {
        $.ajax({
            type: "GET",
            url: "users-filldata",
            success: function(response) {
                $('#u_state').empty();
                $.each(response.getstate, function(indexInArray, valueOfElement) {
                    $('#u_state').append('<option value="' + valueOfElement.St_Name + '">' + valueOfElement.St_Name + '</option>');
                });
                $('#u_permission').empty();
                $.each(response.getpermission, function(indexInArray, valueOfElement) {
                    $('#u_permission').append('<option value="' + valueOfElement.Pe_Name + '">' + valueOfElement.Pe_Name + '</option>');
                });
                $('#U_WorkPlace').empty();
                $.each(response.getworkplace, function(indexInArray, valueOfElement) {
                    $('#U_WorkPlace').append('<option value="' + valueOfElement.Wsp_Name + '">' + valueOfElement.Wsp_Name + '</option>');
                });

            }
        });

    });
}

function fetchdata_users() {

    $(document).ready(function() {

        var tabledata = $('#users_data').DataTable({

            "responsive": true,
            "processing": true,
            "serverSide": true,

            "order": [],
            "ajax": {
                type: "GET",
                url: "users-fetch",


            },

            "columns": [{
                    "data": "U_ID"
                },
                {
                    "data": "U_UserName"
                },
                {
                    "data": "U_State"
                },
                {
                    "data": "U_Permission"
                },
                {
                    "data": null,
                    render: function(data, type) {
                        return type === 'display' ?
                            '<button  class="btn btn-success btn-sm m-1 usersEdit2"><i class="bi bi-pen"></i> تعديل </button>' +
                            '<button  class="btn btn-danger btn-sm m-1 usersDelete"><i class="bi bi-trash"></i> حذف </button>' : data;
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
            // "dom": ' <"top"l><"search float-right p-2"f>rt<"bottom float-right"p><"clear">'


        });




    });

}

function updatedata_users() {
    var data = {
        'u_id': $('.u_id').val(),
        'u_username': $('.u_username').val(),
        'u_password': $('.u_password').val(),
        'u_state': $('.u_state').val(),
        'u_permission': $('.u_permission').val(),
        'U_WorkPlace': $('.U_WorkPlace').val(),


    };
    $.ajax({
        method: "POST",
        url: "users-update",
        data: data,
        success: function(response) {
            alertify.set('notifier', 'position', 'top-right');
            alertify.success(response.status);
            var tabldata = $('#users_data').DataTable();
            tabldata.ajax.reload();


        }
    });
}