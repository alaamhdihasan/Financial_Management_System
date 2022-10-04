<!DOCTYPE html>
<html lang="en">

<head>

    <link rel="stylesheet" type="text/css" href=" <?php echo base_url('admin/assets/css/stylereports_001.css'); ?> " />

    <title>طباعة سلفة الصيانة</title>
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
        رقم السلفة : &nbsp; <?= $getMaintenanceNumber[0]->Ma_Number ?> <br>

        تاريخ السلفة :&nbsp; <?= $getMaintenanceNumber[0]->Ma_Date ?> <br>
        مبلغ السلفة : &nbsp; <?= $getTotal[0]->MaintenanceTotal ?> &nbsp;&nbsp;&nbsp;<?= $getTotalWords ?>
        &nbsp;دينار لا غير
    </div>
    <?php ?>

    <table class="table cs_table borderd">
        <thead>
            <tr>
                <td>ت</td>
                <td>تاريخ</td>
                <td>المبلغ</td>
                <td>رقم العجلة</td>
                <td>نوع العجلة</td>
                <td>التفاصيل </td>
            </tr>
        </thead>
        <tbody>
            <?php for ($i = 0; $i < count($getMaintenanceNumber); $i++) : ?>
                <tr>
                    <td><?= $i + 1 ?></td>
                    <td><?= $getMaintenanceNumber[$i]->Ma2_Date ?></td>
                    <td><?= $getMaintenanceNumber[$i]->Ma2_Money ?></td>
                    <td><?= $getMaintenanceNumber[$i]->Ma2_CarNo ?></td>
                    <td><?= $getMaintenanceNumber[$i]->Ma2_CarType ?></td>
                    <td><?= $getMaintenanceNumber[$i]->Ma2_Notes ?></td>

                </tr>


            <?php endfor; ?>

        </tbody>
        <tfoot>
            <tr>
                <td colspan="2" style="text-align: center;">اجمالي المبلغ</td>
                <td><?= $getTotal[0]->MaintenanceTotal ?></td>
                <td colspan="3" style="text-align: center;"></td>

            </tr>
        </tfoot>
    </table>





</body>

</html>