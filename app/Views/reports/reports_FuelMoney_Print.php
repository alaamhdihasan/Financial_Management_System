<!DOCTYPE html>
<html lang="en">

<head>

    <link rel="stylesheet" type="text/css" href=" <?php echo base_url('admin/assets/css/stylereports_001.css'); ?> " />  
    <title>طباعة سلفة</title>
</head>

<body dir="rtl">
    <header>
        <div class="columnheader1">
            جمهورية العراق <br> ديوان الوقف الشيعي <br> العتبة العباسية المقدسة
        </div>
        <div class="columnheader">
            قسم الاليــات <br> تقرير <br> <?= $ReportTitle ?>

        </div>
    </header>
    <hr>


    <?php ?>
    <div style="padding-bottom:10px ;" style="font-size:0.8rem ;">
        رقم السلفة : &nbsp; <?= $getFuelMoneyNumber[0]->Fm_Number ?> <br>

        تاريخ السلفة :&nbsp; <?= $getFuelMoneyNumber[0]->Fm_Date ?> <br>
        مبلغ السلفة : &nbsp; <?= $getTotal[0]->FuelMoneyTotal ?> &nbsp;&nbsp;&nbsp;<?= $getTotalWords ?>
        &nbsp;دينار لا غير
    </div>
    <?php ?>

    <table class="table cs_table borderd" id="fueltable">
        <thead>
            <tr>
                <td>ت</td>
                <td>تاريخ</td>
                <td>المبلغ</td>
                <td>رقم العجلة</td>
                <td>نوع العجلة</td>

            </tr>
        </thead>
        <tbody>
            <?php for ($i = 0; $i < count($getFuelMoneyNumber); $i++) : ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td><?= $getFuelMoneyNumber[$i]->Fm1_Date ?></td>
                    <td><?= $getFuelMoneyNumber[$i]->Fm1_Money ?></td>
                    <td><?= $getFuelMoneyNumber[$i]->Fm1_CarNo ?></td>
                    <td><?= $getFuelMoneyNumber[$i]->Fm1_CarType ?></td>


                </tr>


            <?php endfor; ?>

        </tbody>
        <tfoot>
            <tr>
                <td colspan="2" style="text-align: center;">اجمالي المبلغ</td>
                <td><?= $getTotal[0]->FuelMoneyTotal ?></td>
                <td colspan="2" style="text-align: center;"></td>

            </tr>
        </tfoot>
    </table>




   

</body>

</html>