<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="row border g-0 rounded shadow-sm ">
    <div class="col p-4">
        <div class="col-md-12 mt-2">
            <div class="card ">
                <div class="card-header bg-info">

                    <button class="btn btn-primary btn-sm m-1 float-end workshopsAdd">Add workshop
                    </button>

                    <h4 style="color: black;"><?= $title ?> </h4>

                </div>
                <div class="card-body">

                    <table id="workshops_data" class="table table-bordered table-striped workshops_data" cellspacing="0" width="100%">
                        <thead class="dataheader_workshops table-dark">
                            <tr>
                                <td>ID</td>
                                <td>Workshop Name</td>
                                <td>State</td>
                                <td>Event</td>
                            </tr>
                        </thead>
                        <tbody class="databody_workshops">

                        </tbody>
                    </table>

                </div>
            </div>
        </div>
        <div class="col-md-12 mt-5">
            <div class="card workshopsaction" id="workshopsaction">
                <div class="card-header bg-info">
                    <button class="btn btn-danger btn-sm m-1 mb-3 float-end workshopsClose">close
                    </button>
                    <h4 style="color: black;" id="card_workshopstitle" class="card_workshopstitle"> </h4>

                </div>
                <div class="card-body ">
                    <div class="row ">
                        <!-- <form> -->

                        <div class="col-md-12 ">
                            <div class="form-group ">
                                <div class="ms-12 row pt-3">
                                    <div class="col-sm-auto">
                                        <input type="text" name="Ws_ID" id="Ws_ID" class="form-control Ws_ID" hidden>

                                    </div>
                                </div>

                                <div class="ms-12 row pt-3">
                                    <label for="" class="col-sm-2 col-form-label"> WrokShop Name :
                                    </label>
                                    <div class="col-sm-3">
                                        <input type="text" name="Ws_Name" id="Ws_Name" class="form-control Ws_Name" autocomplete="off">
                                        <span id="error_Ws_Name" class="text-danger"></span>
                                    </div>

                                </div>
                                <div class="ms-12 row pt-3">
                                    <label for="" class="col-sm-2 col-form-label"> State :
                                    </label>
                                    <div class="col-sm-3">
                                        <select name="Ws_State" id="Ws_State" class="col-sm-11 col-form-label form-select Ws_State">

                                        </select>
                                        <span id="error_Ws_State" class="text-danger"></span>
                                    </div>

                                </div>
                               
                                <div>
                                    <?php echo '----------------------------------------------------------------------------------------' ?>        
                                <div class="ms-12 row pt-3">
                                    <label for="" class="col-sm-2 col-form-label"> </label>
                                    <div class="col-sm-2">
                                        <button class="btn btn-primary form-control workshopsSave">Save Data</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- </form> -->
                    </div>
                </div>
            </div>
        </div>



    </div>

</div>



<?= $this->endSection() ?>

<?= $this->section('scripts') ?>


<script>
    workshops_fetch();
    workshops_filldata();
    $("#workshopsaction").hide();
    $(document).on('click', '.workshopsAdd', function() {
        var displaycard = document.getElementById("workshopsaction");
        if (displaycard.style.display == "none") {
            document.getElementById("card_workshopstitle").innerText = "Add New workshop";
            displaycard.style.display = "block";
        } else {

            displaycard.style.display = "none";
            document.getElementById("card_workshopstitle").innerText = "";
            workshops_cleardata();
            displaycard.style.display = "block";
            document.getElementById("card_workshopstitle").innerText = "Add New workshop";

        }
    });
    $(document).on('click', '.workshopsClose', function() {
        var displaycard = document.getElementById("workshopsaction");
        workshops_cleardata();
        document.getElementById("card_workshopstitle").innerText = "";
        displaycard.style.display = "none";


    });

    $(document).on('click', '.workshopsSave', function() {

        var Ws_ID = document.getElementById("Ws_ID").value;

        if (Ws_ID == '') {

            workshops_checkdata();
            if (error_Ws_Name != '' || error_Ws_State != '' ) {
                return false;
            } else {
                workshops_insertdata();
                workshops_cleardata();
            }
        } else {
            workshops_update();
            workshops_cleardata();
        }

    });

    $(document).on('click', '.workshopsDelete', function() {
        var tabledata = $('#workshops_data').DataTable();
        var workshops = tabledata.row($(this).closest('tr')).data();
        var workshopsvalue = workshops[Object.keys(workshops)[0]];

        $.ajax({
            type: "POST",
            url: "<?= base_url('workshop-delete') ?>",
            data: {
                'getid': workshopsvalue,
            },

            success: function(response) {
                alertify.set('notifier', 'position', 'top-right');
                alertify.success(response.status);
                $('#workshops_data').DataTable().ajax.reload();
            }
        });
    });

    $(document).on('click', '.workshopsEdit', function() {
        var tabledata = $('#workshops_data').DataTable();
        var workshops = tabledata.row($(this).closest('tr')).data();
        var workshopsvalue = workshops[Object.keys(workshops)[0]];
        $.ajax({
            type: "GET",
            url: "<?= base_url('workshop-edit') ?>",
            data: {
                'getid': workshopsvalue,
            },

            success: function(response) {

                $.each(response, function(key, value) {

                    $('#Ws_ID').val(value['Ws_ID']);
                    $('#Ws_Name').val(value['Ws_Name']);
                    $('#Ws_State').val(value['Ws_State']);


                    var displaycard = document.getElementById("workshopsaction");
                    if (displaycard.style.display == "none") {
                        document.getElementById("card_workshopstitle").innerText = "workshop Data Edit";
                        displaycard.style.display = "block";
                    } else {
                        displaycard.style.display = "none";
                        document.getElementById('card_workshopstitle').innerText = "";
                        document.getElementById('card_workshopstitle').innerText = "workshop Data Edit";
                        displaycard.style.display = "block";

                    }

                });

            }
        });
    });




    function workshops_cleardata() {
        $('#Ws_ID').val('');
        $('#Ws_Name').val('');
        $('#Ws_State').val('');

    }

    function workshops_checkdata() {
        if ($.trim($('.Ws_Name').val()).length == 0) {
            error_Ws_Name = "plz, input the Name";
            $('#error_Ws_Name').text(error_Ws_Name);
        } else {
            error_Ws_Name = "";
            $('#error_Ws_Name').text(error_Ws_Name);
        }
        if ($.trim($('.Ws_State').val()).length == 0 || $.trim($('.Ws_State').val())=='Select State' ) {
            error_Ws_State = "plz, input the State";
            $('#error_Ws_State').text(error_Ws_State);
        } else {
            error_Ws_State = "";
            $('#error_Ws_State').text(error_Ws_State);
        }
    

    }

    function workshops_insertdata() {
        var data = {
            'Ws_Name': $('.Ws_Name').val(),
            'Ws_State': $('.Ws_State').val(),
        };
        $.ajax({
            method: "POST",
            url: "<?php echo base_url('workshop-store') ?>",
            data: data,
            success: function(response) {
                alertify.set('notifier', 'position', 'top-right');
                alertify.success(response.status);
                var tabldata = $('#workshops_data').DataTable();
                tabldata.ajax.reload();


            }
        });
    }

    function workshops_filldata() {
        $(document).ready(function() {
            $.ajax({
                type: "GET",
                url: "<?php echo base_url('workshop-filldata') ?>",
                success: function(response) {

                    $('#Ws_State').append('<option selected>' + "Select State" + '</option>');
                    $.each(response.getstate, function(indexInArray, valueOfElement) {
                        $('#Ws_State').append('<option value="' + valueOfElement.St_Name + '">' + valueOfElement.St_Name + '</option>');
                    });

                }
            });

        });
    }

    function workshops_fetch() {

        $(document).ready(function() {

            var tabledata = $('#workshops_data').DataTable({

                "responsive": true,
                "processing": true,
                "serverSide": true,

                "order": [],
                "ajax": {
                    type: "GET",
                    url: "<?php echo base_url('workshop-fetch') ?>",


                },

                "columns": [{
                        "data": "Ws_ID"
                    },
                    {
                        "data": "Ws_Name"
                    },
                    {
                        "data": "Ws_State"
                    },        
                    {
                        "data": null,
                        render: function(data, type) {
                            return type === 'display' ?
                                '<button  class="btn btn-success btn-sm m-1 workshopsEdit"><i class="bi bi-pen"></i> Edit </button>' +
                                '<button  class="btn btn-danger btn-sm m-1 workshopsDelete"><i class="bi bi-trash"></i> Del </button>' +
                                '<button  class="btn btn-secondary btn-sm m-1 workshopsDisplay"><i class="bi bi-info"></i></button>' : data;
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
                ]


            });




        });

    }

    function workshops_update() {
        var data = {
            'Ws_ID': $('.Ws_ID').val(),
            'Ws_Name': $('.Ws_Name').val(),
            'Ws_State': $('.Ws_State').val(),
        };
        $.ajax({
            method: "POST",
            url: "<?php echo base_url('workshop-update') ?>",
            data: data,
            success: function(response) {
                alertify.set('notifier', 'position', 'top-right');
                alertify.success(response.status);
                var tabldata = $('#workshops_data').DataTable();
                tabldata.ajax.reload();


            }
        });
    }
</script>


<?= $this->endSection() ?>