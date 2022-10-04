<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <?php

        use Mpdf\Tag\Section;

        $request = service('request');
        ?>
        <li class="nav-item" id="Login_Dashboard">
            <a href="<?= base_url('admins') ?>" class="nav-link <?= !$request->uri->getSegment(1) ? 'active' : null; ?>">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>الداشبورد</p>
            </a>
        </li>
        <li class="nav-item" id="Login_Users">
            <a href="<?= base_url('users') ?>" class="nav-link <?= $request->uri->getSegment(1) == 'users' ? 'active' : null; ?>">
                <i class="nav-icon fas fa-users"></i>
                <p>المستخدمون</p>
            </a>
        </li>

        <li class="nav-item has-treeview menu-close">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-edit"></i>
                <p>
                    ادخالات ثابتة
                    <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item" id="Login_CarType">
                    <a href="<?= base_url('cartype') ?>" class="nav-link <?= $request->uri->getSegment(1) == 'cartype' ? 'active' : null; ?>">
                    &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;<i class="nav-icon fas fa-car-alt"></i>
                        <p>نوع العجلات</p>
                    </a>
                </li>
                <li class="nav-item" id="Login_State">
                    <a href="<?= base_url('state') ?>" class="nav-link <?= $request->uri->getSegment(1) == 'state' ? 'active' : null; ?>">
                    &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;<i class="nav-icon fas fa-book"></i>
                        <p>الحالة</p>
                    </a>
                </li>
                <li class="nav-item" id="Login_WorkShopPlace">
                    <a href="<?= base_url('workshopplace') ?>" class="nav-link <?= $request->uri->getSegment(1) == 'workshopplace' ? 'active' : null; ?>">
                    &nbsp;&nbsp; &nbsp;&nbsp;&nbsp; <i class="nav-icon fas fa-box"></i>
                        <p>مكان العمل</p>
                    </a>
                </li>
                <li class="nav-item" id="Login_FuelType">
                    <a href="<?= base_url('fueltype') ?>" class="nav-link <?= $request->uri->getSegment(1) == 'fueltype' ? 'active' : null; ?>">
                    &nbsp;&nbsp; &nbsp;&nbsp;&nbsp; <i class="nav-icon fas fa-box"></i>
                        <p>نوع الوقود </p>
                    </a>
                </li>


                <li class="nav-item" id="Login_Customers">
                    <a href="<?= base_url('customer') ?>" class="nav-link <?= $request->uri->getSegment(1) == 'customer' ? 'active' : null; ?>">
                    &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;<i class="nav-icon fas fa-bank"></i>
                        <p>الزبائن</p>
                    </a>
                </li>


                <li class="nav-item" id="Login_Permission">
                    <a href="<?= base_url('permission') ?>" class="nav-link <?= $request->uri->getSegment(1) == 'permission' ? 'active' : null; ?>">
                    &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;<i class="nav-icon fas fa-bank"></i>
                        <p>الصلاحيات</p>
                    </a>
                </li>

                <li class="nav-item" id="Login_Account">
                    <a href="<?= base_url('account') ?>" class="nav-link <?= $request->uri->getSegment(1) == 'account' ? 'active' : null; ?>">
                    &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;<i class="nav-icon fas fa-bank"></i>
                        <p>الحساب</p>
                    </a>
                </li>
                <li class="nav-item" id="Login_Workers">
                    <a href="<?= base_url('workers') ?>" class="nav-link <?= $request->uri->getSegment(1) == 'workers' ? 'active' : null; ?>">
                    &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;<i class="nav-icon fas fa-bank"></i>
                        <p>الفنيين</p>
                    </a>
                </li>


            </ul>
        </li>


        <li class="nav-item has-treeview menu-close">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-money-bill"></i>
                <p>
                    السلف
                   <i class="right fas fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item" id="Login_FuelMoney">
                    <a href="<?= base_url('fuelMoney') ?>" class="nav-link <?= $request->uri->getSegment(1) == 'fuelMoney' ? 'active' : null; ?>">
                    &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;<i class="nav-icon fas fa-gas-pump"></i>
                        <p>سلف الوقود</p>
                    </a>
                </li>
                <li class="nav-item" id="Login_Maintenance">
                    <a href="<?= base_url('maintenance') ?>" class="nav-link <?= $request->uri->getSegment(1) == 'maintenance' ? 'active' : null; ?>">
                    &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;<i class="nav-icon fas fa-object-group"></i>
                        <p>سلف الصيانة</p>
                    </a>
                </li>


            </ul>
        </li>





    </ul>
</nav>


<?= $this->Section('scripts') ?>
<script>
    $(document).ready(function() {


        $.ajax({
            type: "GET",
            url: "<?php echo base_url('users-getPermissions') ?>",
            success: function(response) {
                // console.log(response);
                $.each(response, function(indexInArray, valueOfElement) {
                    if (!valueOfElement.P_Dashboard) {
                        $("#Login_Dashboard a").click(function(e) {
                            e.preventDefault();

                        });
                    }
                    if (!valueOfElement.P_Users) {
                        $("#Login_Users a").click(function(e) {
                            e.preventDefault();

                        });
                    }
                    if (!valueOfElement.P_CarType) {
                        $("#Login_CarType a").click(function(e) {
                            e.preventDefault();

                        });
                    }
                    if (!valueOfElement.P_WorkShopPlace) {
                        $("#Login_WorkShopPlace a").click(function(e) {
                            e.preventDefault();

                        });
                    }
                    if (!valueOfElement.P_State) {
                        $("#Login_State a").click(function(e) {
                            e.preventDefault();

                        });
                    }
                    if (!valueOfElement.P_Permission) {
                        $("#Login_Permission a").click(function(e) {
                            e.preventDefault();

                        });
                    }
                    if (!valueOfElement.P_FuelType) {
                        $("#Login_FuelType a").click(function(e) {
                            e.preventDefault();

                        });
                    }
                    if (!valueOfElement.P_Customers) {
                        $("#Login_Customers a").click(function(e) {
                            e.preventDefault();

                        });
                    }
                    if (!valueOfElement.P_Accounts) {
                        $("#Login_Account a").click(function(e) {
                            e.preventDefault();

                        });
                    }
                    if (!valueOfElement.P_FuelMoney) {
                        $("#Login_FuelMoney a").click(function(e) {
                            e.preventDefault();

                        });
                    }
                    if (!valueOfElement.P_Maintenance) {
                        $("#Login_Maintenance a").click(function(e) {
                            e.preventDefault();

                        });
                    }

                });

            }
        });


    });
</script>

<?= $this->endSection() ?>