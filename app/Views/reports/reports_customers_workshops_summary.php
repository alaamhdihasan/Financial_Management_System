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
                    <td>Customers</td>
                    <td>Oil_Liquid</td>
                    <td>Wheels</td>
                    <td>Maintenance</td>
                    <td>Dyeing</td>
                    <td>Electric</td>
                    <td>Refrigeration</td>
                    <td>Plumbing_Welding</td>
                    <td>Packaging</td>
                    <td>Mechanical</td>

                </tr>
            </thead>
            <tbody>
                <?php for ($i = 0; $i < count($getCustomersWorkShopsSummary); $i++) : ?>
                    <tr>
                        <td><?= $getCustomersWorkShopsSummary[$i]->Jcm_Customer ?></td>
                        <td><?= $getCustomersWorkShopsSummary[$i]->Oil_and_Liquid ?></td>
                        <td><?= $getCustomersWorkShopsSummary[$i]->Wheels ?></td>
                        <td><?= $getCustomersWorkShopsSummary[$i]->Maintenance ?></td>
                        <td><?= $getCustomersWorkShopsSummary[$i]->Dyeing ?></td>
                        <td><?= $getCustomersWorkShopsSummary[$i]->Electric ?></td>
                        <td><?= $getCustomersWorkShopsSummary[$i]->Refrigeration ?></td>
                        <td><?= $getCustomersWorkShopsSummary[$i]->Plumbing_welding ?></td>
                        <td><?= $getCustomersWorkShopsSummary[$i]->Packaging ?></td>
                        <td><?= $getCustomersWorkShopsSummary[$i]->Mechanical ?></td>

                    </tr>


                <?php endfor; ?>

            </tbody>
            <tfoot>
                <tr>
                    <td colspan="4" style="text-align: center;">
                    Report of WorkShops According to Customers...
                </td>
                    
                </tr>
            </tfoot>
        </table>
    </div>




</body>

</html>