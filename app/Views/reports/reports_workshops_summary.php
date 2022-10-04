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
                    <td>WorkShop</td>
                    <td>Cars Count</td>
                    <td>Items Total</td>
                    <td>Wages Total</td>
                    <td>Totals</td>

                </tr>
            </thead>
            <tbody>
                <?php for ($i = 0; $i < count($getWorkShopsSummary); $i++) : ?>
                    <tr>
                        <td><?= $getWorkShopsSummary[$i]->Jcm2_WorkShop ?></td>
                        <td><?= $getWorkShopsSummary[$i]->CarCount ?></td>
                        <td><?= $getWorkShopsSummary[$i]->Jcm2_Item2Total ?></td>
                        <td><?= $getWorkShopsSummary[$i]->Jcm_Ch2Total ?></td>
                        <td><?= $getWorkShopsSummary[$i]->Jcm_Jc2Total ?></td>

                    </tr>


                <?php endfor; ?>

            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2" style="text-align: center;">Total</td>
                    <td><?= $Total[0]->ITotal ?></td>
                    <td><?= $Total[0]->WTotal ?></td>
                    <td><?= $Total[0]->JcTotal ?></td>
                </tr>
            </tfoot>
        </table>
    </div>




</body>

</html>