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
                    <td>DepartMents</td>
                    <td>Items Total</td>
                    <td>Wages Total</td>
                    <td>Totals</td>

                </tr>
            </thead>
            <tbody>
                <?php for ($i = 0; $i < count($getCustomersSummary); $i++) : ?>
                    <tr>
                        <td><?= $getCustomersSummary[$i]->Jcm_Customer ?></td>
                        <td><?= $getCustomersSummary[$i]->Jcm_ItemTotal ?></td>
                        <td><?= $getCustomersSummary[$i]->Jcm_ChTotal ?></td>
                        <td><?= $getCustomersSummary[$i]->Jcm_JcTotal ?></td>

                    </tr>


                <?php endfor; ?>
               
            </tbody>
            <tfoot>
            <tr >
                    <td >Total</td>
                    <td><?= $Total[0]->ITotal ?></td>
                    <td><?= $Total[0]->WTotal ?></td>
                    <td><?= $Total[0]->JcTotal ?></td>
                </tr>
            </tfoot>
        </table>
    </div>




</body>

</html>