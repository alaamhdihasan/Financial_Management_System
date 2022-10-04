userprofile_fetchdata();

function userprofile_fetchdata() {
    $(document).ready(function() {
        var uid = $('#u_id').val();
        console.log(uid);
        var data = {
            'getid': uid,
        };
        $.ajax({
            type: "GET",
            url: "userprofile-fetch3",
            data: data,
            success: function(response) {
                console.log(response);
                $.each(response.userinfo, function(index, value) {
                    // console.log(userinfo);
                    $('#u_username').val(value.U_UserName);
                    $('#u_password').val(value.U_Password);
                    $('#p_id').val(value.P_ID);
                    $('#p_fk').val(value.P_FK);
                    $('#p_create').prop('checked', value.P_Create);
                    $('#p_update').prop('checked', value.P_Update);
                    $('#p_delete').prop('checked', value.P_Delete);
                    $('#P_Dashboard').prop('checked', value.P_Dashboard);
                    $('#P_Users').prop('checked', value.P_Users);
                    $('#P_Reports').prop('checked', value.P_Reports);
                    $('#P_State').prop('checked', value.P_State);
                    $('#P_Permission').prop('checked', value.P_Permission);
                    $('#P_CarType').prop('checked', value.P_CarType);
                    $('#P_Workers').prop('checked', value.P_Workers);
                    $('#P_Accounts').prop('checked', value.P_Accounts);
                    $('#P_FuelType').prop('checked', value.P_FuelType);
                    $('#P_FuelMoney').prop('checked', value.P_FuelMoney);
                    $('#P_Maintenance').prop('checked', value.P_Maintenance);
                    $('#P_WorkShopPlace').prop('checked', value.P_WorkShopPlace);
                    $('#P_Customers').prop('checked', value.P_Customers);

                    $('#u_state').append('<option selected>' + value.U_State + '</option>');
                    $.each(response.getstate, function(ind, val) {
                        $('#u_state').append('<option value="' + val.St_Name + '">' + val.St_Name + '</option>');

                    });
                    $('#u_permission').append('<option selected>' + value.U_Permission + '</option>');
                    $.each(response.getpermission, function(ind, val) {
                        $('#u_permission').append('<option value="' + val.Pe_Name + '">' + val.Pe_Name + '</option>');

                    });
                    $('#U_WorkPlace').append('<option selected>' + value.U_WorkPlace + '</option>');
                    $.each(response.getworkplace, function(ind, val) {
                        $('#U_WorkPlace').append('<option value="' + val.Wsp_Name + '">' + val.Wsp_Name + '</option>');

                    });

                });

            }
        });
    });
}

$(document).on('click', '.userprofileSave', function() {

    userprofile_checkdata();
    if (error_u_username != '' || error_u_password != '' || error_u_state != '' ||
        error_u_permission != '' || error_U_WorkPlace != '') {
        return false;

    } else {
        userprofile_update();

    }





});


function userprofile_update() {

    //    // var fileimage = $('.u_image')[0].files[0];
    //     var username = $('#u_username').val();
    //     var userpassword = $('#u_password').val();
    //     var userstate = $('#u_state').val();
    //     var userpermisson = $('#u_permisson').val();
    //     var pcreate = $('#p_create').val();
    //     var pupdate = $('#p_update').val();
    //     var pdelete = $('#p_delete').val();
    //     var userid = $('#u_id').val();
    //     var profileid = $('#p_id').val();
    //     var pfk = $('#p_fk').val();

    //     var fd = new FormData();
    //    // fd.append("u_image", fileimage);
    //     fd.append("userid", userid);
    //     fd.append("username", username);
    //     fd.append("password", userpassword);
    //     fd.append("state", userstate);
    //     fd.append("permission", userpermisson);
    //     fd.append("profileid", profileid);
    //     fd.append("profilefk", pfk);
    //     fd.append("create", pcreate);
    //     fd.append("update", pupdate);
    //     fd.append("delete", pdelete);

    var data = {
        'userid': $('#u_id').val(),
        'username': $('#u_username').val(),
        'password': $('#u_password').val(),
        'state': $('#u_state').val(),
        'permission': $('#u_permission').val(),
        'workPlace': $('#U_WorkPlace').val(),
        'profileid': $('#p_id').val(),
        'profilefk': $('#p_fk').val(),
        'create': (function() {
            if ($("#p_create").is(":checked")) {
                return 1;

            } else return 0;
        })(),

        'update': (function() {
            if ($("#p_update").is(":checked")) {
                return 1;

            } else return 0;
        })(),
        'delete': (function() {
            if ($("#p_delete").is(":checked")) {
                return 1;

            } else return 0;
        })(),
        'dashboard': (function() {
            if ($("#P_Dashboard").is(":checked")) {
                return 1;

            } else return 0;
        })(),
        'users': (function() {
            if ($("#P_Users").is(":checked")) {
                return 1;

            } else return 0;
        })(),
        'reports': (function() {
            if ($("#P_Reports").is(":checked")) {
                return 1;

            } else return 0;
        })(),
        'statevision': (function() {
            if ($("#P_State").is(":checked")) {
                return 1;

            } else return 0;
        })(),
        'permissionvision': (function() {
            if ($("#P_Permission").is(":checked")) {
                return 1;

            } else return 0;
        })(),
        'cartype': (function() {
            if ($("#P_CarType").is(":checked")) {
                return 1;

            } else return 0;
        })(),

        'workshopplace': (function() {
            if ($("#P_WorkShopPlace").is(":checked")) {
                return 1;

            } else return 0;
        })(),
        'workers': (function() {
            if ($("#P_Workers").is(":checked")) {
                return 1;

            } else return 0;
        })(),

        'accounts': (function() {
            if ($("#P_Accounts").is(":checked")) {
                return 1;

            } else return 0;
        })(),
        'customers': (function() {
            if ($("#P_Customers").is(":checked")) {
                return 1;

            } else return 0;
        })(),
        'fueltype': (function() {
            if ($("#P_FuelType").is(":checked")) {
                return 1;

            } else return 0;
        })(),
        'fuelmoney': (function() {
            if ($("#P_FuelMoney").is(":checked")) {
                return 1;

            } else return 0;
        })(),
        'maintenance': (function() {
            if ($("#P_Maintenance").is(":checked")) {
                return 1;

            } else return 0;
        })(),

    };
    $.ajax({
        type: "POST",
        url: "userprofile-update",
        data: data,
        success: function(response) {

            alertify.set('notifier', 'position', 'top-center');
            alertify.success(response.status);
            userprofile_checkdata();
        }
    });
}

function userprofile_checkdata() {
    if ($.trim($('.u_username').val()).length == 0) {
        error_u_username = "يجب ادخال اسم المستخدم";
        $('#error_u_username').text(error_u_username);
    } else {
        error_u_username = "";
        $('#error_u_username').text(error_u_username);
    }
    if ($.trim($('.u_password').val()).length == 0) {
        error_u_password = " يجب ادخال الباسورد";
        $('#error_u_password').text(error_u_password);
    } else {
        error_u_password = "";
        $('#error_u_password').text(error_u_password);
    }
    if ($.trim($('.u_state').val()).length == 0) {
        error_u_state = "يجب ادخال حالة المستخدم";
        $('#error_u_state').text(error_u_state);
    } else {
        error_u_state = "";
        $('#error_u_state').text(error_u_state);
    }
    if ($.trim($('.u_permission').val()).length == 0) {
        error_u_permission = "يجب ادخال صلاحية المستخدم";
        $('#error_u_permission').text(error_u_permission);
    } else {
        error_u_permission = "";
        $('#error_u_permission').text(error_u_permission);
    }
    if ($.trim($('.U_WorkPlace').val()).length == 0) {
        error_U_WorkPlace = "يجب ادخال مكان عمل المستخدم";
        $('#error_U_WorkPlace').text(error_U_WorkPlace);
    } else {
        error_U_WorkPlace = "";
        $('#error_U_WorkPlace').text(error_U_WorkPlace);
    }

}