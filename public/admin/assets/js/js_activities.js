function fetchdata_activities() {
    var data = {
        getidteacher: $("#empid_activity").val(),
    };
    $.ajax({
        type: "GET",
        url: "<?php echo base_url('activity-fetch2') ?>",
        data: data,
        success: function(response) {
            $(".dataheader_activities").html("");
            $(".dataheader_activities").append(
                "<tr><td>  ت </td><td> الفعالية </td>" +
                "<td>  اسم الندوة </td><td> تاريخ انعقادها </td>" +
                "<td>الحدث </td></tr>"
            );
            $(".databody_activities").html("");
            $.each(response.getactivitybyidteacher, function(key, value) {
                $(".databody_activities").append(
                    '<tr ><td class="activityid">' +
                    value["A_id"] +
                    "</td><td>" +
                    value["Activity"] +
                    "</td><td>" +
                    value["Aname"] +
                    "</td><td>" +
                    value["ActDate"] +
                    "</td><td>" +
                    "<a " +
                    '" class="btn btn-success btn-sm m-1 edit_btn_activity"><i class="bi bi-pen"></i>  تعديل </a>' +
                    "<a " +
                    '" class="btn btn-danger btn-sm m-1 delete_btn_activity">حذف</a>' +
                    "</td></tr>"
                );
            });
        },
    });
};