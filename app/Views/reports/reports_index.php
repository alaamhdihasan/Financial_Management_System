<?= $this->extend('admin/layout/main') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 mt-5">
            <?php

            use Mpdf\Tag\Option;

            if (session()->getFlashdata('status')) {
                echo '<div class="alert alert-success" role="alert">' . session()->getFlashdata('status') . "</div>";
            }
            ?>
            <div class="card">
                <div class="card-header text-white" style="background-color: #242424;">

                    <div class="row">
                        <h4>JobCard Reports</h4>
                    </div>


                </div>
                <div class="card-body">

                    <div class="input-group m-2">
                        <label for="" class="col-sm-1 col-form-label m-2"> Report Period : </label>
                        <div class="col-sm-2 m-2">
                            <select name="R_ReportPeriod" id="R_ReportPeriod" class="col-sm-11 col-form-label form-select R_ReportPeriod">
                                <option selected>Select Report Period</option>
                                <option value='Daily'>Daily</option>
                                <option value='Monthly'>Monthly</option>
                                <option value='Yearly'>Yearly</option>

                            </select>
                        </div>
                        <label for="" id="DayLabel" class="col-sm-auto col-form-label m-2"> Day : </label>
                        <div class="col-sm-1 m-2">
                            <input name="R_DayInput" id="R_DayInput" class="col-sm-11 col-form-label form-control R_DayInput">
                            </input>
                        </div>
                        <label for="" id="MonthLabel" class="col-sm-auto col-form-label m-2"> Month : </label>
                        <div class="col-sm-1 m-2">
                            <input name="R_MonthInput" id="R_MonthInput" class="col-sm-11 col-form-label form-control R_MonthInput">
                            </input>
                        </div>
                        <label for="" id="YearLabel" class="col-sm-auto col-form-label m-2"> Year : </label>
                        <div class="col-sm-1 m-2">
                            <input name="R_YearInput" id="R_YearInput" class="col-sm-11 col-form-label form-control R_YearInput">
                            </input>
                        </div>



                    </div>
                    <div class="input-group m-2">
                        <label for="" class="col-sm-1 col-form-label m-2"> WorkShop Place : </label>
                        <div class="col-sm-2 m-2">
                            <select name="R_WorkShopPlace" id="R_WorkShopPlace" class="col-sm-11 col-form-label form-select R_ReportType">
                                <option selected>Select WorkShop Place</option>
                                <?php for ($i = 0; $i < count($WorkShopPlace); $i++) : ?>
                                    <option><?= $WorkShopPlace[$i]->Wsp_Name ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>

                    <div class="input-group m-2">
                        <label for="" class="col-sm-1 col-form-label m-2"> Report Type : </label>
                        <div class="col-sm-2 m-2">
                            <select name="R_ReportType" id="R_ReportType" class="col-sm-11 col-form-label form-select R_ReportType">
                                <option selected>Select Report Type</option>
                                <option value='Customer_Summary'>Customer Summary</option>
                                <option value='Cars_Summary'>Cars Summary</option>
                                <option value='Items_Summary'>Items Summary</option>
                                <option value='WorkShops_Summary'>WorkShops Summary</option>
                                <option value='Customers_WorkShops_Summary'>Customers WorkShops Summary</option>



                            </select>
                        </div>
                    </div>

                    <hr>
                    <button class="btn btn-primary btn-sm float-start reportprint">
                        Print Report</button>
                </div>

            </div>

        </div>






    </div>




</div>



<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    $(document).ready(function() {
        $('#R_DayInput').on('keypress', function(event) {
            var regex = new RegExp("^[.0-9]+$");
            var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
            if (!regex.test(key)) {
                event.preventDefault();
                return false;
            }
        });
        $('#R_MonthInput').on('keypress', function(event) {
            var regex = new RegExp("^[.0-9]+$");
            var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
            if (!regex.test(key)) {
                event.preventDefault();
                return false;
            }
        });
        $('#R_YearInput').on('keypress', function(event) {
            var regex = new RegExp("^[.0-9]+$");
            var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
            if (!regex.test(key)) {
                event.preventDefault();
                return false;
            }
        });
    });

    $(document).ready(function() {

        $('#R_DayInput').hide();
        $('#DayLabel').hide();
        $('#R_MonthInput').hide();
        $('#MonthLabel').hide();
        $('#R_YearInput').hide();
        $('#YearLabel').hide();

    });

    $(document).on('change', '.R_ReportPeriod', function() {
        var selectedtext = $('#R_ReportPeriod').val();
        switch (selectedtext) {
            case 'Daily':
                $('#R_DayInput').show();
                $('#DayLabel').show();
                $('#R_MonthInput').show();
                $('#MonthLabel').show();
                $('#R_YearInput').show();
                $('#YearLabel').show();
                break;
            case 'Monthly':
                $('#R_DayInput').hide();
                $('#DayLabel').hide();
                $('#R_MonthInput').show();
                $('#MonthLabel').show();
                $('#R_YearInput').show();
                $('#YearLabel').show();
                break;

            case 'Yearly':
                $('#R_DayInput').hide();
                $('#DayLabel').hide();
                $('#R_MonthInput').hide();
                $('#MonthLabel').hide();
                $('#R_YearInput').show();
                $('#YearLabel').show();
                break;

            default:
                $('#R_DayInput').hide();
                $('#DayLabel').hide();
                $('#R_MonthInput').hide();
                $('#MonthLabel').hide();
                $('#R_YearInput').hide();
                $('#YearLabel').hide();
                break;
        }
    });

    $(document).on('click', '.reportprint', function() {
        data = {
            'daily': $('#R_DayInput').val(),
            'monthly': $('#R_MonthInput').val(),
            'yearly': $('#R_YearInput').val(),
            'reportperiod': $('#R_ReportPeriod').val(),
            'workshopplace': $('#R_WorkShopPlace').val(),
            'reporttype': $('#R_ReportType').val(),

        };
        $.ajax({
            type: "GET",
            url: "<?php echo base_url('datainfo') ?>",
            data: data,
            success: function(response) {

                var a = document.createElement('a');
                a.href = "<?php echo base_url('reportprint') ?>";
                window.open(a.href, '_blank');

            }

        });
    });
</script>




<?= $this->endSection() ?>