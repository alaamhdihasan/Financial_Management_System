<!DOCTYPE html>
<html lang="en">

<head>

    <link rel="stylesheet" type="text/css" href=" <?php echo base_url('admin/assets/css/stylereports_001.css'); ?> " />

    <title>Customers Summary</title>
</head>

<body>


    <div style="padding-top: 100px;"></div>


    <div class="styletable">
        <table class="table cs_table borderd">
            <thead>
                <tr>
                    <td>Item Name</td>
                    <td>Part Number</td>
                    <td>Quantity</td>
                    <td>Price Total</td>
                    <td>Wages Total</td>
                    <td>Totals</td>

                </tr>
            </thead>
            <tbody>
                <?php for ($i = 0; $i < count($getItemsSummary); $i++) : ?>


                    <tr>
                        <td><?= $getItemsSummary[$i]->Jcm2_ItemName ?></td>
                        <td><?= $getItemsSummary[$i]->Jcm2_PartNumber ?></td>
                        <td><?= $getItemsSummary[$i]->Jcm2_Quantity ?></td>
                        <td><?= $getItemsSummary[$i]->Jcm2_MoneyTotal ?></td>
                        <td><?= $getItemsSummary[$i]->Jcm2_ChTotal ?></td>
                        <td><?= $getItemsSummary[$i]->Jcm2_Total ?></td>
                    </tr>


                <?php endfor; ?>

            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" style="text-align: center;">Total</td>
                    <td><?= $Total[0]->ITotal ?></td>
                    <td><?= $Total[0]->WTotal ?></td>
                    <td><?= $Total[0]->JcTotal ?></td>
                </tr>
            </tfoot>
        </table>
    </div>




</body>

</html>