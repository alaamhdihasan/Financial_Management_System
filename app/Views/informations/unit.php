<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="row border g-0 rounded shadow-sm ">
    <div class="col p-4">
        <div class="col-md-12 mt-2">
            <div class="card ">
                <div class="card-header bg-info">

                    <button class="btn btn-primary btn-sm m-1 float-end unitAdd">Add unit
                    </button>

                    <h4 style="color: black;"><?= $title ?> </h4>

                </div>
                <div class="card-body">

                    <table id="unit_data" class="table table-bordered table-striped unit_data" cellspacing="0" width="100%">
                        <thead class="dataheader_unit table-dark">
                            <tr>
                                <td>ID</td>
                                <td>unit Name</td>
                                <td>Event</td>
                            </tr>
                        </thead>
                        <tbody class="databody_unit">

                        </tbody>
                    </table>

                </div>
            </div>
        </div>
        <div class="col-md-12 mt-5">
            <div class="card unitaction" id="unitaction">
                <div class="card-header bg-info">
                    <button class="btn btn-danger btn-sm m-1 mb-3 float-end unitClose">close
                    </button>
                    <h4 style="color: black;" id="card_unittitle" class="card_unittitle"> </h4>

                </div>
                <div class="card-body ">
                    <div class="row ">
                        <!-- <form> -->

                        <div class="col-md-12 ">
                            <div class="form-group ">
                                <div class="ms-12 row pt-3">
                                    <div class="col-sm-auto">
                                        <input type="text" name="ui_id" id="ui_id" class="form-control ui_id" hidden>

                                    </div>
                                </div>

                                <div class="ms-12 row pt-3">
                                    <label for="" class="col-sm-2 col-form-label"> Unit Name :
                                    </label>
                                    <div class="col-sm-3">
                                        <input type="text" name="ui_name" id="ui_name" class="form-control ui_name" autocomplete="off">
                                        <span id="error_ui_name" class="text-danger"></span>
                                    </div>

                                </div>




                                <div>
                                    <?php echo '----------------------------------------------------------------------------------------' ?>

                                    <div class="ms-12 row pt-3">
                                        <label for="" class="col-sm-2 col-form-label"> </label>
                                        <div class="col-sm-2">
                                            <button class="btn btn-primary form-control unitSave">Save Data</button>
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
        unit_fetch();
        $("#unitaction").hide();
        $(document).on('click', '.unitAdd', function() {
            var displaycard = document.getElementById("unitaction");
            if (displaycard.style.display == "none") {
                document.getElementById("card_unittitle").innerText = "Add New unit";
                displaycard.style.display = "block";
            } else {

                displaycard.style.display = "none";
                document.getElementById("card_unittitle").innerText = "";
                unit_cleardata();
                displaycard.style.display = "block";
                document.getElementById("card_unittitle").innerText = "Add New workers";

            }
        });
        $(document).on('click', '.unitClose', function() {
            var displaycard = document.getElementById("unitaction");
            unit_cleardata();
            document.getElementById("card_unittitle").innerText = "";
            displaycard.style.display = "none";


        });

        $(document).on('click', '.unitSave', function() {

            var ui_id = document.getElementById("ui_id").value;

            if (ui_id == '') {

                unit_chechdata();
                if (error_ui_name != '') {
                    return false;
                } else {
                    unit_insert();
                    unit_cleardata();
                }
            } else {
                unit_update();
                unit_cleardata();
            }

        });

        $(document).on('click', '.unitDelete', function() {
            var tabledata = $('#unit_data').DataTable();
            var unit = tabledata.row($(this).closest('tr')).data();
            var unitvalue = unit[Object.keys(unit)[0]];

            $.ajax({
                type: "POST",
                url: "<?= base_url('unit-delete') ?>",
                data: {
                    'getid': unitvalue,
                },

                success: function(response) {
                    alertify.set('notifier', 'position', 'top-right');
                    alertify.success(response.status);
                    $('#unit_data').DataTable().ajax.reload();
                }
            });
        });

        $(document).on('click', '.unitEdit', function() {
            var tabledata = $('#unit_data').DataTable();
            var unit = tabledata.row($(this).closest('tr')).data();
            var unitvalue = unit[Object.keys(unit)[0]];
            $.ajax({
                type: "GET",
                url: "<?= base_url('unit-edit') ?>",
                data: {
                    'getid': unitvalue,
                },

                success: function(response) {

                    $.each(response, function(key, value) {

                        $('#ui_id').val(value['Ui_ID']);
                        $('#ui_name').val(value['Ui_Name']);


                        var displaycard = document.getElementById("unitaction");
                        if (displaycard.style.display == "none") {
                            document.getElementById("card_unittitle").innerText = "unit Data Edit";
                            displaycard.style.display = "block";
                        } else {
                            displaycard.style.display = "none";
                            document.getElementById('card_unittitle').innerText = "";
                            document.getElementById('card_unittitle').innerText = "unit Data Edit";
                            displaycard.style.display = "block";

                        }

                    });

                }
            });
        });




        function unit_cleardata() {
            $('#ui_id').val('');
            $('#ui_name').val('');

        }

        function unit_chechdata() {
            if ($.trim($('.ui_name').val()).length == 0) {
                error_ui_name = "plz, input the unit";
                $('#error_ui_name').text(error_ui_name);
            } else {
                error_ui_name = "";
                $('#error_ui_name').text(error_ui_name);
            }
           


        }

        function unit_insert() {
            var data = {
                'ui_name': $('.ui_name').val(),
            };
            $.ajax({
                method: "POST",
                url: "<?php echo base_url('unit-store') ?>",
                data: data,
                success: function(response) {
                    alertify.set('notifier', 'position', 'top-right');
                    alertify.success(response.status);
                    var tabldata = $('#unit_data').DataTable();
                    tabldata.ajax.reload();


                }
            });
        }

      
        function unit_fetch() {

            $(document).ready(function() {

                var tabledata = $('#unit_data').DataTable({

                    "responsive": true,
                    "processing": true,
                    "serverSide": true,

                    "order": [],
                    "ajax": {
                        type: "GET",
                        url: "<?php echo base_url('unit-fetch') ?>",


                    },

                    "columns": [{
                            "data": "Ui_ID"
                        },
                        {
                            "data": "Ui_Name"
                        },
                        
                        {
                            "data": null,
                            render: function(data, type) {
                                return type === 'display' ?
                                    '<button  class="btn btn-success btn-sm m-1 unitEdit"><i class="bi bi-pen"></i> Edit </button>' +
                                    '<button  class="btn btn-danger btn-sm m-1 unitDelete"><i class="bi bi-trash"></i> Del </button>' +
                                    '<button  class="btn btn-secondary btn-sm m-1 unitDisplay"><i class="bi bi-info"></i></button>' : data;
                            }
                        }



                    ],
                    "columnDefs": [{
                        "targets": [0, 2],
                        "orderable": false,
                    }],
                    "lengthMenu": [
                        [5, 10, 15, 20, 25, 100],
                        [5, 10, 15, 20, 25, 100]
                    ]


                });




            });

        }

        function unit_update() {
            var data = {
                'ui_id': $('.ui_id').val(),
                'ui_name': $('.ui_name').val(),


            };
            $.ajax({
                method: "POST",
                url: "<?php echo base_url('unit-update') ?>",
                data: data,
                success: function(response) {
                    alertify.set('notifier', 'position', 'top-right');
                    alertify.success(response.status);
                    var tabldata = $('#unit_data').DataTable();
                    tabldata.ajax.reload();


                }
            });
        }
    </script>


    <?= $this->endSection() ?>