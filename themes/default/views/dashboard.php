<?php

function row_status($x) {
    if ($x == null) {
        return '';
    } elseif ($x == 'pending') {
        return '<div class="text-center"><span class="label label-warning">' . lang($x) . '</span></div>';
    } elseif ($x == 'completed' || $x == 'paid' || $x == 'sent' || $x == 'received') {
        return '<div class="text-center"><span class="label label-success">' . lang($x) . '</span></div>';
    } elseif ($x == 'partial' || $x == 'transferring') {
        return '<div class="text-center"><span class="label label-info">' . lang($x) . '</span></div>';
    } elseif ($x == 'due') {
        return '<div class="text-center"><span class="label label-danger">' . lang($x) . '</span></div>';
    } else {
        return '<div class="text-center"><span class="label label-default">' . lang($x) . '</span></div>';
    }
}

$search_term = "";
if ($this->input->post('payment_type')) {
    $search_term .= "&payment_type=" . $this->input->post('payment_type');
}

//$ptype = array("" => "Payment Type", "CC" => "Credit/Debit Card", "cash" => "Cash", "credit_voucher" => "Credit Note");
// added by vikas singh
$ptype = array("" => "Payment Type", "CC" => "Credit/Debit Card", "cash" => "Cash", "credit_voucher" => "Credit Note", "All" => "All Payment");
$dtype = array("all" => "ALL", 'product' => 'Product', 'replacement' => 'Replacement', 'promotions' => 'Promotions');
?>
<?php
if (($Owner || $Admin) && $chatData) {
    foreach ($chatData as $month_sale) {
        $months[] = date('M-Y', strtotime($month_sale->month));
        $msales[] = $month_sale->sales;
        $mtax1[] = $month_sale->tax1;
        $mtax2[] = $month_sale->tax2;
        $mpurchases[] = $month_sale->purchases;
        $mtax3[] = $month_sale->ptax;
    }
    ?>
    <div class="box" style="margin-bottom: 15px;">
        <div class="box-header">
            <h2 class="blue"><i class="fa-fw fa fa-bar-chart-o"></i><?= lang('overview_chart'); ?></h2>
        </div>
        <div class="box-content">
            <div class="row">
                <div class="col-md-12">
                    <p class="introtext"><?php echo lang('overview_chart_heading'); ?></p>

                    <div id="ov-chart" style="width:100%; height:450px;"></div>
                    <p class="text-center"><?= lang("chart_lable_toggle"); ?></p>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<!-- added by vikas singh-->
<style type="text/css">
    .table {
        width: 100% !important;
    }
</style>
<!-- end -->

<div class="row" style="margin-bottom: 15px;">
    <div class="col-lg-12">
        <div class="box">
            <div class="box-header">
                <h2 class="blue"><i class="fa fa-th"></i><span class="break"></span><?= lang('quick_links') ?></h2>
            </div>
            <!-- **** Quick_links Modified By Anil Start **** --> 
            <div class="row">
                <div class="col-lg-12">
                    <!-- added by vikas singh -->
                    <?php
                    $default_org = $pos_settings->default_org;
                    $sync = $pos_settings->syncing_status;
                    if (empty($default_org) OR $default_org == 'NULL') {
                        if ($sync == 'sync_out') {
                            ?>
                            <div class="col-lg-1 col-md-2 col-xs-6">
                                <form name="sync_out_org" method="get" id="sync_out_org" action="<?php echo base_url('welcome/syncposorg'); ?>">
                                    <input type="hidden" name="type" id="sync_out" value="sync_out">
                                    <button type="submit" name="submit" class="btn btn-danger">Sync Out</button>
                                </form>
                            </div>
                        <?php } else { ?>

                            <div class="col-lg-1 col-md-2 col-xs-6">
                                <form name="sync_in_org" method="get" id="sync_in_org" action="<?php echo base_url('welcome/syncposorg'); ?>">

                                    <input type="hidden" name="type" id="sync_in" value="sync_in">
                                    <button type="submit" name="submit" class="btn btn-success">Sync In</button>
                                </form>
                            </div>


                        <?php
                        }
                    } else {
                        //echo "hello2222";
                        if ($sync == 'sync_out') {
                            ?>


                            <div class="col-lg-1 col-md-2 col-xs-6">
                                <form name="sync_out_org" method="get" id="sync_out_org" action="<?php echo base_url('welcome/intrmExport'); ?>">
                                    <input type="hidden" name="sorg_id" id="sorg_id" value="<?php echo ($pos_settings->default_org); ?>">
                                    <button type="submit" name="submit" оnclick ="mloading1()" id="load2" class="btn btn-danger">Sync Out</button>
                                </form>
                            </div>
                        <?php } else { ?>
                            <div class="col-lg-1 col-md-2 col-xs-6">
                                <form name="sync_in_org" method="get" id="sync_in_org" action="<?php echo base_url('welcome/POSImport'); ?>">
                                    <input type="hidden" name="sorg_id" id="sorg_id" value="<?php echo base64_encode($pos_settings->default_org); ?>">
                                    <button type="submit" name="submit" оnclick ="mloading()" id="load1" class="btn btn-success">Sync In</button>
                                </form>
                            </div>

                        <?php
                        }
                    }
                    ?>

                </div>


            </div>

            <?php if ($Owner) { ?>    
                <div class="box-content dashboardicon">

                    <div class="col-lg-1 col-md-2 col-xs-6">                  
                        <a class="bblue white quick-button small" href="<?= site_url('products') ?>">
                            <i class="fa fa-barcode"></i>

                            <p><?= lang('products') ?></p>
                        </a>
                    </div>
                    <div class="col-lg-1 col-md-2 col-xs-6">
                        <a class="bdarkGreen white quick-button small" href="<?= site_url('sales') ?>">
                            <i class="fa fa-heart"></i>

                            <p><?= lang('sales') ?></p>
                        </a>
                    </div>
                    <div class="col-lg-1 col-md-2 col-xs-6">
                        <a class="blightOrange white quick-button small" href="<?= site_url('quotes') ?>">
                            <i class="fa fa-heart-o"></i>

                            <p><?= lang('quotes') ?></p>
                        </a>
                    </div>

                    <div class="col-lg-1 col-md-2 col-xs-6">
                        <a class="bred white quick-button small" href="<?= site_url('purchases') ?>">
                            <i class="fa fa-star"></i>

                            <p><?= lang('purchases') ?></p>
                        </a>
                    </div>

                    <div class="col-lg-1 col-md-2 col-xs-6">
                        <a class="bpink white quick-button small" href="<?= site_url('transfers') ?>">
                            <i class="fa fa-star-o"></i>

                            <p><?= lang('transfers') ?></p>
                        </a>
                    </div>

                    <div class="col-lg-1 col-md-2 col-xs-6">
                        <a class="bgrey white quick-button small" href="<?= site_url('customers') ?>">
                            <i class="fa fa-users"></i>

                            <p><?= lang('customers') ?></p>
                        </a>
                    </div>

                    <div class="col-lg-1 col-md-2 col-xs-6">
                        <a class="bgrey white quick-button small" href="<?= site_url('suppliers') ?>">
                            <i class="fa fa-users"></i>

                            <p><?= lang('suppliers') ?></p>
                        </a>
                    </div>

                    <div class="col-lg-1 col-md-2 col-xs-6">
                        <a class="blightBlue white quick-button small" href="<?= site_url('notifications') ?>">
                            <i class="fa fa-comments"></i>

                            <p><?= lang('notifications') ?></p>
                            <!--<span class="notification green">4</span>-->
                        </a>
                    </div>

                    <div class="col-lg-1 col-md-2  col-xs-6">
                        <a class="bblue white quick-button small" href="<?= site_url('auth/users') ?>">
                            <i class="fa fa-group"></i>
                            <p><?= lang('users') ?></p>
                        </a>
                    </div>

                    <div class="col-lg-1 col-md-2 col-xs-6">
                        <a class="bblue white quick-button small" href="<?= site_url('system_settings') ?>">
                            <i class="fa fa-cogs"></i>

                            <p><?= lang('settings') ?></p>
                        </a>
                    </div>
                    <div class="clearfix"></div>
                </div>
            <?php } else { ?>

                <div class="box-content dashboardicon">
                    <?php if ($GP['products-list']) { ?> 
                        <div class="col-lg-1 col-md-2 col-xs-6"> 
                            <a class="bblue white quick-button small" href="<?= site_url('products') ?>">
                                <i class="fa fa-barcode"></i>

                                <p><?= lang('products') ?></p>
                            </a>                   
                        </div>
                    <?php }
                    if ($GP['sales-list']) {
                        ?>

                        <div class="col-lg-1 col-md-2 col-xs-6">
                            <a class="bdarkGreen white quick-button small" href="<?= site_url('sales') ?>">
                                <i class="fa fa-heart"></i>

                                <p><?= lang('sales') ?></p>
                            </a>
                        </div>
                    <?php }
                    if ($GP['quotes-list']) {
                        ?>
                        <div class="col-lg-1 col-md-2 col-xs-6">
                            <a class="blightOrange white quick-button small" href="<?= site_url('quotes') ?>">
                                <i class="fa fa-heart-o"></i>

                                <p><?= lang('quotes') ?></p>
                            </a>
                        </div>
                    <?php }
                    if ($GP['purchases-list']) {
                        ?>
                        <div class="col-lg-1 col-md-2 col-xs-6">
                            <a class="bred white quick-button small" href="<?= site_url('purchases') ?>">
                                <i class="fa fa-star"></i>

                                <p><?= lang('purchases') ?></p>
                            </a>
                        </div>
    <?php }
    if ($GP['transfers-list']) {
        ?>

                        <div class="col-lg-1 col-md-2 col-xs-6">
                            <a class="bpink white quick-button small" href="<?= site_url('transfers') ?>">
                                <i class="fa fa-star-o"></i>

                                <p><?= lang('transfers') ?></p>
                            </a>
                        </div>
    <?php }
    if ($GP['customers-index']) {
        ?>

                        <div class="col-lg-1 col-md-2 col-xs-6">
                            <a class="bgrey white quick-button small" href="<?= site_url('customers') ?>">
                                <i class="fa fa-users"></i>

                                <p><?= lang('customers') ?></p>
                            </a>
                        </div>
    <?php }
    if ($GP['suppliers-index']) {
        ?>
                        <div class="col-lg-1 col-md-2 col-xs-6">
                            <a class="bgrey white quick-button small" href="<?= site_url('suppliers') ?>">
                                <i class="fa fa-users"></i>

                                <p><?= lang('suppliers') ?></p>
                            </a>
                        </div>
    <?php }
    if ($GP['notifications']) {
        ?>
                        <div class="col-lg-1 col-md-2 col-xs-6">
                            <a class="blightBlue white quick-button small" href="<?= site_url('notifications') ?>">
                                <i class="fa fa-comments"></i>

                                <p><?= lang('notifications') ?></p>
                                <!--<span class="notification green">4</span>-->
                            </a>
                        </div>
    <?php }
    if ($GP['users_list']) {
        ?>
                        <div class="col-lg-1 col-md-2  col-xs-6">
                            <a class="bblue white quick-button small" href="<?= site_url('auth/users') ?>">
                                <i class="fa fa-group"></i>
                                <p><?= lang('users') ?></p>
                            </a>
                        </div>
    <?php }
    if ($GP['system_settings']) {
        ?>
                        <div class="col-lg-1 col-md-2 col-xs-6">
                            <a class="bblue white quick-button small" href="<?= site_url('system_settings') ?>">
                                <i class="fa fa-cogs"></i>

                                <p><?= lang('settings') ?></p>
                            </a>
                        </div>
    <?php } ?>    
                    <div class="clearfix"></div>
                </div>
<?php } ?>
            <!--**** Quick_links Modified By Anil End ****--> 
        </div>
    </div>
</div>
<?php if ($Owner || $Admin) { ?>
    <div class="row" style="margin-bottom: 15px;">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header">
                    <h2 class="blue"><i class="fa-fw fa fa-tasks"></i> <?= lang('latest_five') ?></h2>
                </div>
                <div class="box-content">
                    <div class="row">
                        <div class="col-md-12">
                            <ul id="dbTab" class="nav nav-tabs">
                                <?php if ($Owner || $Admin || $GP['sales-index']) { ?>
                                    <li class=""><a href="#sales"><?= lang('sales') ?></a></li>
                                <?php } // if ($Owner || $Admin || $GP['quotes-index']) {  ?>
                                <!--<li class=""><a href="#quotes"><?= lang('quotes') ?></a></li>-->
                                <?php // }  ?>   <!--According swatch this option is disable By Ankit-->
                                <?php if ($Owner || $Admin || $GP['purchases-index']) { ?>
                                    <li class=""><a href="#purchases"><?= lang('purchases') ?></a></li>
                                <?php } if ($Owner || $Admin || $GP['transfers-index']) { ?>
                                    <li class=""><a href="#transfers"><?= lang('transfers') ?></a></li>
                                <?php } if ($Owner || $Admin || $GP['customers-index']) { ?>
                                    <li class=""><a href="#customers"><?= lang('customers') ?></a></li>
    <?php } //if ($Owner || $Admin || $GP['suppliers-index']) {  ?>
                                <!--<li class=""><a href="#suppliers"><?= lang('suppliers') ?></a></li>-->
    <?php // }  ?> <!--According swatch this option is disable By Ankit-->
                            </ul>

                            <div class="tab-content">
    <?php if ($Owner || 4 || $GP['sales-index']) { ?>

                                    <div id="sales" class="tab-pane fade in">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="table-responsive">
                                                    <table id="sales-tbl" cellpadding="0" cellspacing="0" border="0"
                                                           class="table table-bordered table-hover table-striped"
                                                           style="margin-bottom: 0;">
                                                        <thead>
                                                            <tr>
                                                                <th style="width:30px !important;">#</th>
                                                                <th><?= $this->lang->line("date"); ?></th>
                                                                <th><?= $this->lang->line("reference_no"); ?></th>
                                                                <th><?= $this->lang->line("customer"); ?></th>
                                                                <th><?= $this->lang->line("status"); ?></th>
                                                                <th><?= $this->lang->line("total"); ?>&nbsp;<span class="rupee">&#8377;</span></th>
                                                                <th><?= $this->lang->line("payment_status"); ?></th>
                                                                <th><?= $this->lang->line("Status"); ?></th>
                                                                <th><?= $this->lang->line("paid"); ?>&nbsp;<span class="rupee">&#8377;</span></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            if (!empty($sales)) {
                                                                $r = 1;
                                                                //print_r($sales); die;
                                                                foreach ($sales as $order) {
                                                                    if ($order->return_flg == 0) {
                                                                        $status = "Sold";
                                                                    }
                                                                    if ($order->return_flg == 1) {
                                                                        $status = "Returned";
                                                                    }
                                                                    if ($order->return_flg == 2) {
                                                                        $status = "Partial Return";
                                                                    }
                                                                    echo '<tr id="' . $order->id . '" class="' . ($order->pos ? "receipt_link" : "invoice_link") . '"><td>' . $r . '</td>
                                                            <td>' . $this->sma->hrld($order->date) . '</td>
                                                            <td>' . $order->reference_no . '</td>
                                                            <td>' . $order->customer . '</td>
                                                            <td>' . row_status($order->sale_status) . '</td>
                                                            <td class="text-right">' . $this->sma->formatMoney($order->grand_total) . '</td>
                                                            <td>' . row_status($order->payment_status) . '</td>
                                                            <td>' . row_status($status) . '</td>
                                                            <td class="text-right">' . $this->sma->formatMoney($order->paid) . '</td>
                                                        </tr>';
                                                                    $r++;
                                                                }
                                                            } else {
                                                                ?>
                                                                <tr>
                                                                    <td colspan="7"
                                                                        class="dataTables_empty"><?= lang('no_data_available') ?></td>
                                                                </tr>
                                    <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

    <?php } //if ($Owner || $Admin || $GP['quotes-index']) {  ?>

                                <!--                            <div id="quotes" class="tab-pane fade">
                                                                <div class="row">
                                                                    <div class="col-sm-12">
                                                                        <div class="table-responsive">
                                                                            <table id="quotes-tbl" cellpadding="0" cellspacing="0" border="0"
                                                                                   class="table table-bordered table-hover table-striped"
                                                                                   style="margin-bottom: 0;">
                                                                                <thead>
                                                                                <tr>
                                                                                    <th style="width:30px !important;">#</th>
                                                                                    <th><?= $this->lang->line("date"); ?></th>
                                                                                    <th><?= $this->lang->line("reference_no"); ?></th>
                                                                                    <th><?= $this->lang->line("customer"); ?></th>
                                                                                    <th><?= $this->lang->line("status"); ?></th>
                                                                                    <th><?= $this->lang->line("amount"); ?></th>
                                                                                </tr>
                                                                                </thead>
                                                                                <tbody>
                                <?php
                                if (!empty($quotes)) {
                                    $r = 1;
                                    foreach ($quotes as $quote) {
                                        echo '<tr id="' . $quote->id . '" class="quote_link"><td>' . $r . '</td>
                                                        <td>' . $this->sma->hrld($quote->date) . '</td>
                                                        <td>' . $quote->reference_no . '</td>
                                                        <td>' . $quote->customer . '</td>
                                                        <td>' . row_status($quote->status) . '</td>
                                                        <td class="text-right">' . $this->sma->formatMoney($quote->grand_total) . '</td>
                                                    </tr>';
                                        $r++;
                                    }
                                } else {
                                    ?>
                                                                                        <tr>
                                                                                            <td colspan="6"
                                                                                                class="dataTables_empty"><?= lang('no_data_available') ?></td>
                                                                                        </tr>
                                <?php } ?>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>-->

    <?php // }  ?>
    <?php if ($Owner || $Admin || $GP['purchases-index']) { ?>

                                    <div id="purchases" class="tab-pane fade in">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="table-responsive">
                                                    <table id="purchases-tbl" cellpadding="0" cellspacing="0" border="0"
                                                           class="table table-bordered table-hover table-striped"
                                                           style="margin-bottom: 0;">
                                                        <thead>
                                                            <tr>
                                                                <th style="width:30px !important;">#</th>
                                                                <th><?= $this->lang->line("date"); ?></th>
                                                                <th><?= $this->lang->line("reference_no"); ?></th>
                                                                <th><?= $this->lang->line("supplier"); ?></th>
                                                                <th><?= $this->lang->line("status"); ?></th>
                                                                <th><?= $this->lang->line("amount"); ?></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            if (!empty($purchases)) {
                                                                $r = 1;
                                                                foreach ($purchases as $purchase) {
                                                                    echo '<tr id="' . $purchase->id . '" class="purchase_link"><td>' . $r . '</td>
                                                    <td>' . $this->sma->hrld($purchase->date) . '</td>
                                                    <td>' . $purchase->reference_no . '</td>
                                                    <td>' . $purchase->supplier . '</td>
                                                    <td>' . row_status($purchase->status) . '</td>
                                                    <td class="text-right">' . $this->sma->formatMoney($purchase->grand_total) . '</td>
                                                </tr>';
                                                                    $r++;
                                                                }
                                                            } else {
                                                                ?>
                                                                <tr>
                                                                    <td colspan="6"
                                                                        class="dataTables_empty"><?= lang('no_data_available') ?></td>
                                                                </tr>
        <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

    <?php } if ($Owner || $Admin || $GP['transfers-index']) { ?>

                                    <div id="transfers" class="tab-pane fade">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="table-responsive">
                                                    <table id="transfers-tbl" cellpadding="0" cellspacing="0" border="0"
                                                           class="table table-bordered table-hover table-striped"
                                                           style="margin-bottom: 0;">
                                                        <thead>
                                                            <tr>
                                                                <th style="width:30px !important;">#</th>
                                                                <th><?= $this->lang->line("date"); ?></th>
                                                                <th><?= $this->lang->line("reference_no"); ?></th>
                                                                <th><?= $this->lang->line("from"); ?></th>
                                                                <th><?= $this->lang->line("to"); ?></th>
                                                                <th><?= $this->lang->line("status"); ?></th>
                                                                <th><?= $this->lang->line("amount"); ?></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            if (!empty($transfers)) {
                                                                $r = 1;
                                                                foreach ($transfers as $transfer) {
                                                                    echo '<tr id="' . $transfer->id . '" class="transfer_link"><td>' . $r . '</td>
                                                <td>' . $this->sma->hrld($transfer->date) . '</td>
                                                <td>' . $transfer->transfer_no . '</td>
                                                <td>' . $transfer->from_warehouse_name . '</td>
                                                <td>' . $transfer->to_warehouse_name . '</td>
                                                <td>' . row_status($transfer->status) . '</td>
                                                <td class="text-right">' . $this->sma->formatMoney($transfer->grand_total) . '</td>
                                            </tr>';
                                                                    $r++;
                                                                }
                                                            } else {
                                                                ?>
                                                                <tr>
                                                                    <td colspan="7"
                                                                        class="dataTables_empty"><?= lang('no_data_available') ?></td>
                                                                </tr>
        <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

    <?php } if ($Owner || $Admin || $GP['customers-index']) { ?>

                                    <div id="customers" class="tab-pane fade in">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="table-responsive">
                                                    <table id="customers-tbl" cellpadding="0" cellspacing="0" border="0"
                                                           class="table table-bordered table-hover table-striped"
                                                           style="margin-bottom: 0;">
                                                        <thead>
                                                            <tr>
                                                                <th style="width:30px !important;">#</th>
                                                                <th><?= $this->lang->line("name"); ?></th>
                                                                <th><?= $this->lang->line("email"); ?></th>
                                                                <th><?= $this->lang->line("phone"); ?></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
        <?php
        if (!empty($customers)) {
            $r = 1;
            foreach ($customers as $customer) {
                echo '<tr id="' . $customer->id . '" class="customer_link pointer"><td>' . $r . '</td>
                                            <td>' . $customer->name . '</td>
                                            <td>' . $customer->email . '</td>
                                            <td>' . $customer->phone . '</td>
                                        </tr>';
                $r++;
            }
        } else {
            ?>
                                                                <tr>
                                                                    <td colspan="6"
                                                                        class="dataTables_empty"><?= lang('no_data_available') ?></td>
                                                                </tr>
        <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

    <?php } //if ($Owner || $Admin || $GP['suppliers-index']) {  ?>

                                <!--                            <div id="suppliers" class="tab-pane fade">
                                                                <div class="row">
                                                                    <div class="col-sm-12">
                                                                        <div class="table-responsive">
                                                                            <table id="suppliers-tbl" cellpadding="0" cellspacing="0" border="0"
                                                                                   class="table table-bordered table-hover table-striped"
                                                                                   style="margin-bottom: 0;">
                                                                                <thead>
                                                                                <tr>
                                                                                    <th style="width:30px !important;">#</th>
                                                                                    <th><?= $this->lang->line("company"); ?></th>
                                                                                    <th><?= $this->lang->line("name"); ?></th>
                                                                                    <th><?= $this->lang->line("email"); ?></th>
                                                                                    <th><?= $this->lang->line("phone"); ?></th>
                                                                                    <th><?= $this->lang->line("address"); ?></th>
                                                                                </tr>
                                                                                </thead>
                                                                                <tbody>
    <?php
    if (!empty($suppliers)) {
        $r = 1;
        foreach ($suppliers as $supplier) {
            echo '<tr id="' . $supplier->id . '" class="supplier_link pointer"><td>' . $r . '</td>
                                        <td>' . $supplier->company . '</td>
                                        <td>' . $supplier->name . '</td>
                                        <td>' . $supplier->email . '</td>
                                        <td>' . $supplier->phone . '</td>
                                        <td>' . $supplier->address . '</td>
                                    </tr>';
            $r++;
        }
    } else {
        ?>
                                                                                        <tr>
                                                                                            <td colspan="6"
                                                                                                class="dataTables_empty"><?= lang('no_data_available') ?></td>
                                                                                        </tr>
    <?php } ?>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>-->

    <?php // }  ?>

                            </div>


                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
                            <?php } ?>

<!-- Update by Ankit-->

<div class="row" style="margin-bottom: 15px;">
    <div class="col-md-12">
        <div class="box">
            <div class="box-header">
                <h2 class="blue"><i class="fa fa-th"></i> <?= lang('sale_details') ?></h2>
            </div>
            <div class="box-content">
                <div class="row">
                    <div class="col-md-12">

                        <ul id="dbTab" class="nav nav-tabs">
                            <?php if ($Owner || $Admin || $GP['today-index'] || $Manager || $Sales) { ?>
                                <li class="active"><a href="#today"><?= lang('today') ?></a></li>
<?php } if ($Owner || $Admin || $GP['month-index'] || $Manager || $Sales) { ?>
                                <li class=""><a href="#month"><?= lang('current_month') ?></a></li>
<?php } if ($Owner || $Admin || $GP['last_month-index'] || $Manager || $Sales) { ?>
                                <li class=""><a href="#last_month"><?= lang('last_month') ?></a></li>
                                            <?php } if ($Owner || $Admin || $GP['period_set-index'] || $Manager) { ?>
                                <li class=""><a href="#period_set"><?= lang('period_set') ?></a></li>
<?php } if ($Owner || $Admin || $GP['ytd_sale-index'] || $Manager || $Sales) { ?>
                                <li class=""><a href="#ytd_sale"><?= lang('ytd_sale') ?></a></li>
                                                        <?php } if ($Owner || $Admin || $GP['sales_return-index'] || $Manager || ($Sales && $GP['sales-return_sales'])) { ?>
                                <li class=""><a href="#sales_return"><?= lang('sales_return') ?></a></li>
                                                        <?php } if ($Owner || $Admin || $GP['sales_discount-index'] || $Manager || $Sales) { ?>
                                <li class=""><a href="#sales_discount"><?= lang('sales_discount') ?></a></li>
<?php } ?>
                        </ul>

                        <div class="tab-content">
<?php if ($Owner || $Admin || $GP['today-index'] || $Manager || $Sales) { ?>

                                <div id="today" class="tab-pane fade in active">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div id="form">
                                                <?php echo form_open(""); ?>
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
    <?php
    echo form_dropdown('payment_type', $ptype, (isset($_POST['payment_type']) ? $_POST['payment_type'] : ""), 'class="form-control" id="today_pay_type" data-placeholder="' . $this->lang->line("select") . " " . $this->lang->line("payment_type") . '"');
    ?>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <button type="submit" id="today_pay" class="btn btn-success" >
    <?= lang('get_record') ?> &nbsp;<i class="fa fa-sign-in"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
    <?php echo form_close(); ?>
                                            </div>

                                            <div class="table-responsive">
                                                <table id="today-tbl" cellpadding="0" cellspacing="0" border="0"
                                                       class="table table-bordered table-hover table-striped"
                                                       style="margin-bottom: 0;">
                                                    <thead>
                                                        <tr>
                                                            <th></th>
                                                            <th class="col-xs-2"><?= $this->lang->line("date"); ?></th>
                                                            <th class="col-xs-2"><?= $this->lang->line("reference_no"); ?></th>
                                                            <th class="col-xs-1"><?= $this->lang->line("mrp"); ?> <span class="rupee">&#8377;</span></th>
                                                            <th class="col-xs-2"><?= $this->lang->line("paid_by"); ?></th>
                                                            <th class="col-xs-2"><?= $this->lang->line("pay_status"); ?></th>
                                                            <th class="col-xs-1"><?= $this->lang->line("discount"); ?> <span class="rupee">&#8377;</span></th>
                                                            <th class="col-xs-1"><?= $this->lang->line("basic_price"); ?> <span class="rupee">&#8377;</span></th>
                                                           <!--  <th class="col-xs-1"><?= $this->lang->line("tax_amount"); ?> <span class="rupee">&#8377;</span></th> -->
                                                            <th class="col-xs-1"><?= $this->lang->line("cgst"); ?> <span class="rupee">&#8377;</span></th>
                                                            <th class="col-xs-1"><?= $this->lang->line("sgst"); ?> <span class="rupee">&#8377;</span></th>

                                                            <th class="col-xs-1"><?= $this->lang->line("paid_invoice"); ?> <span class="rupee">&#8377;</span></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td colspan="11" class="dataTables_empty"><?= lang('loading_data_from_server') ?></td>
                                                        </tr>
                                                    </tbody>
                                                    <tfoot class="dtFilter">
                                                        <tr class="active">
                                                            <th style="min-width:30px; width: 30px; text-align: center;">
                                                                <input class="checkbox checkft" type="checkbox" name="check"/>
                                                            </th>
                                                            <th></th>
                                                            <th></th>
                                                            <th></th>
                                                            <th></th>
                                                            <th></th>
                                                            <th></th>
                                                            <th></th>
                                                            <!--<th><?= lang("balance"); ?></th>-->
                                                            <th class="defaul-color"></th>
                                                            <th></th>
                                                            <th style="width:80px; text-align:center;"><?= lang("actions"); ?></th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                                        <?php } if ($Owner || $Admin || $GP['month-index'] || $Manager || $Sales) { ?>

                                <div id="month" class="tab-pane fade in">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div id="form">
    <?php echo form_open(""); ?>
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
    <?php
    echo form_dropdown('payment_type', $ptype, (isset($_POST['payment_type']) ? $_POST['payment_type'] : ""), 'class="form-control" id="month_pay_type" data-placeholder="' . $this->lang->line("select") . " " . $this->lang->line("payment_type") . '"');
    ?>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <button type="submit" id="month_pay" class="btn btn-success" >
    <?= lang('get_record') ?> &nbsp;<i class="fa fa-sign-in"></i>
                                                        </button>
                                                    </div>
                                                </div>
    <?php echo form_close(); ?>
                                            </div>
                                            <div class="table-responsive">
                                                <table id="month-tbl" cellpadding="0" cellspacing="0" border="0"
                                                       class="table table-bordered table-hover table-striped"
                                                       style="margin-bottom: 0;">
                                                    <thead>
                                                        <tr>
                                                            <th></th>
                                                            <th class="col-xs-2"><?= $this->lang->line("date"); ?></th>
                                                            <th class="col-xs-2"><?= $this->lang->line("reference_no"); ?></th>
                                                            <th class="col-xs-1"><?= $this->lang->line("mrp"); ?> <span class="rupee">&#8377;</span></th>
                                                            <th class="col-xs-2"><?= $this->lang->line("paid_by"); ?></th>
                                                            <th class="col-xs-2"><?= $this->lang->line("pay_status"); ?></th>
                                                            <th class="col-xs-1"><?= $this->lang->line("discount"); ?> <span class="rupee">&#8377;</span></th>
                                                            <th class="col-xs-1"><?= $this->lang->line("basic_price"); ?> <span class="rupee">&#8377;</span></th>
                                                           <!--  <th class="col-xs-1"><?= $this->lang->line("tax_amount"); ?> <span class="rupee">&#8377;</span></th> -->
                                                            <th class="col-xs-1"><?= $this->lang->line("cgst"); ?> <span class="rupee">&#8377;</span></th>
                                                            <th class="col-xs-1"><?= $this->lang->line("sgst"); ?> <span class="rupee">&#8377;</span></th>
                                                            <th class="col-xs-1"><?= $this->lang->line("paid_invoice"); ?> <span class="rupee">&#8377;</span></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td colspan="11" class="dataTables_empty"><?= lang('loading_data_from_server') ?></td>
                                                        </tr>
                                                    </tbody>
                                                    <tfoot class="dtFilter">
                                                        <tr class="active">
                                                            <th style="min-width:30px; width: 30px; text-align: center;">
                                                                <input class="checkbox checkft" type="checkbox" name="check"/>
                                                            </th>
                                                            <th></th>
                                                            <th></th>
                                                            <th></th>
                                                            <th></th>
                                                            <th></th>
                                                            <th></th>
                                                            <th></th>
                                                            <!--<th><?= lang("balance"); ?></th>-->
                                                            <th class="defaul-color"></th>
                                                            <th></th>
                                                            <th style="width:80px; text-align:center;"><?= lang("actions"); ?></th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                                <p><?php echo $links; ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

<?php } if ($Owner || $Admin || $GP['last_month-index'] || $Manager || $Sales) { ?>

                                <div id="last_month" class="tab-pane fade in">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div id="form">
                                                <?php echo form_open(""); ?>
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <div class="form-group">
    <?php
    echo form_dropdown('payment_type', $ptype, (isset($_POST['payment_type']) ? $_POST['payment_type'] : ""), 'class="form-control" id="last_month_pay_type" data-placeholder="' . $this->lang->line("select") . " " . $this->lang->line("payment_type") . '"');
    ?>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <button type="submit" id="last_month_pay" class="btn btn-success" >
    <?= lang('get_record') ?> &nbsp;<i class="fa fa-sign-in"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
    <?php echo form_close(); ?>
                                            </div>

                                            <div class="table-responsive">
                                                <table id="last_month-tbl" cellpadding="0" cellspacing="0" border="0"
                                                       class="table table-bordered table-hover table-striped"
                                                       style="margin-bottom: 0;">
                                                    <thead>
                                                        <tr>
                                                            <th></th>
                                                            <th class="col-xs-2"><?= $this->lang->line("date"); ?></th>
                                                            <th class="col-xs-2"><?= $this->lang->line("reference_no"); ?></th>
                                                            <th class="col-xs-1"><?= $this->lang->line("mrp"); ?> <span class="rupee">&#8377;</span></th>
                                                            <th class="col-xs-2"><?= $this->lang->line("paid_by"); ?></th>
                                                            <th class="col-xs-2"><?= $this->lang->line("pay_status"); ?></th>
                                                            <th class="col-xs-1"><?= $this->lang->line("discount"); ?> <span class="rupee">&#8377;</span></th>
                                                            <th class="col-xs-1"><?= $this->lang->line("basic_price"); ?> <span class="rupee">&#8377;</span></th>
                                                           <!--  <th class="col-xs-1"><?= $this->lang->line("tax_amount"); ?> <span class="rupee">&#8377;</span> </th> -->
                                                            <th class="col-xs-1"><?= $this->lang->line("cgst"); ?> <span class="rupee">&#8377;</span> </th> 
                                                            <th class="col-xs-1"><?= $this->lang->line("sgst"); ?> <span class="rupee">&#8377;</span> </th> 
                                                            <th class="col-xs-1"><?= $this->lang->line("paid_invoice"); ?> <span class="rupee">&#8377;</span></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td colspan="11" class="dataTables_empty"><?= lang('loading_data_from_server') ?></td>
                                                        </tr>
                                                    </tbody>
                                                    <tfoot class="dtFilter">
                                                        <tr class="active">
                                                            <th style="min-width:30px; width: 30px; text-align: center;">
                                                                <input class="checkbox checkft" type="checkbox" name="check"/>
                                                            </th>
                                                            <th></th>
                                                            <th></th>
                                                            <th></th>
                                                            <th></th>
                                                            <th></th>
                                                            <th></th>
                                                            <th></th>
                                                            <!--<th><?= lang("balance"); ?></th>-->
                                                            <th class="defaul-color"></th>
                                                            <th></th>
                                                            <th style="width:80px; text-align:center;"><?= lang("actions"); ?></th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

<?php } if ($Owner || $Admin || $GP['period_set-index'] || $Manager || $Sales) { ?>

                                <div id="period_set" class="tab-pane fade in">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-12"> 
    <?php echo form_open(""); ?> 
                                                    <div class="div-title">
                                                        <h3 class="text-primary"><?= lang('select_period') ?></h3>
                                                    </div>

                                                    <div class="row"> 
                                                        <div class="col-sm-3" style="float: left">
                                                            <div class="form-group">
    <?php echo form_input('date', (isset($_POST['date']) ? $_POST['date'] : ""), 'class="form-control input-tip date" id="sdate" placeholder="Start Date" required="required" readonly="true"'); ?> 
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-3" style="float: left">
                                                            <div class="form-group">
                                                        <?php echo form_input('date', (isset($_POST['date']) ? $_POST['date'] : ""), 'class="form-control input-tip date" id="edate" placeholder="End Date" required="required" readonly="true"'); ?>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-3">
                                                            <div class="form-group">
    <?php
    echo form_dropdown('payment_type', $ptype, (isset($_POST['payment_type']) ? $_POST['payment_type'] : ""), 'class="form-control" id="period_pay_type" data-placeholder="' . $this->lang->line("select") . " " . $this->lang->line("payment_type") . '"');
    ?>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-3" style="float: left">
                                                            <button type="submit" id="b1" class="btn btn-success" >
    <?= lang('get_record') ?> &nbsp; <i class="fa fa-sign-in"></i>
                                                            </button>
                                                        </div>
    <?php echo form_close(); ?>

                                                    </div>

                                                </div>
                                            </div>    
                                            <div class="table-responsive">
                                                <table id="period_set-tbl" cellpadding="0" cellspacing="0" border="0"
                                                       class="table table-bordered table-hover table-striped"
                                                       style="margin-bottom: 0;">
                                                    <thead>
                                                        <tr>
                                                        <!--<th></th>
                                                            <th><?= $this->lang->line("date"); ?></th>
                                                            <th><?= $this->lang->line("reference_no"); ?></th>
                                                            <th><?= $this->lang->line("mrp"); ?></th>
                                                            <th><?= $this->lang->line("paid_by"); ?></th>
                                                            <th><?= $this->lang->line("discount_rs"); ?></th>
                                                            <th><?= $this->lang->line("basic_price"); ?></th>
                                                            <th><?= $this->lang->line("tax_amount"); ?></th>
                                                            <th><?= $this->lang->line("paid_invoice"); ?></th>-->
                                                            <th></th>
                                                            <th class="col-xs-2"><?= $this->lang->line("date"); ?></th>
                                                            <th class="col-xs-2"><?= $this->lang->line("reference_no"); ?></th>
                                                            <th class="col-xs-1"><?= $this->lang->line("mrp"); ?> <span class="rupee">&#8377;</span></th>
                                                            <th class="col-xs-2"><?= $this->lang->line("paid_by"); ?></th>
                                                            <th class="col-xs-2"><?= $this->lang->line("pay_status"); ?></th>
                                                            <th class="col-xs-1"><?= $this->lang->line("discount"); ?> <span class="rupee">&#8377;</span></th>
                                                            <th class="col-xs-1"><?= $this->lang->line("basic_price"); ?> <span class="rupee">&#8377;</span></th>
                                                            <!-- <th class="col-xs-1"><?= $this->lang->line("tax_amount"); ?> <span class="rupee">&#8377;</span></th> -->
                                                            <th class="col-xs-1"><?= $this->lang->line("cgst"); ?> <span class="rupee">&#8377;</span></th>
                                                            <th class="col-xs-1"><?= $this->lang->line("sgst"); ?> <span class="rupee">&#8377;</span></th>
                                                            <th class="col-xs-1"><?= $this->lang->line("paid_invoice"); ?> <span class="rupee">&#8377;</span></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td colspan="11" class="dataTables_empty"><?= lang('loading_data_from_server') ?></td>
                                                        </tr>
                                                    </tbody>
                                                    <tfoot class="dtFilter">
                                                        <tr class="active">
                                                            <th style="min-width:30px; width: 30px; text-align: center;">
                                                                <input class="checkbox checkft" type="checkbox" name="check"/>
                                                            </th>
                                                            <th></th>
                                                            <th></th>
                                                            <th></th>
                                                            <th></th>
                                                            <th></th>
                                                            <th></th>
                                                            <th></th>
                                                            <!--<th><?= lang("balance"); ?></th>-->
                                                            <th class="defaul-color"></th>
                                                            <th></th>
                                                            <th style="width:80px; text-align:center;"><?= lang("actions"); ?></th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

<?php } if ($Owner || $Admin || $GP['ytd_sale-index'] || $Manager || $Sales) { ?>

                                <div id="ytd_sale" class="tab-pane fade in">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-12"> 

    <?php echo form_open(""); ?>  
                                                    <div class="div-title">
                                                        <h3 class="text-primary"><?= lang('ytd_sale_year') ?></h3>
                                                    </div>
                                                    <div class="row"> 
                                                        <div class="col-sm-3" style="float: left">

    <?php echo form_input('date', (isset($_POST['date']) ? $_POST['date'] : ""), 'class="form-control input-tip date" id="ydate" readonly="true" placeholder="Select Year " required="required"'); ?> 
                                                        </div>

                                                        <div class="col-sm-3" style="float: left"> 
                                                            <button type="submit" id="b2" class="btn btn-success" ><?= lang('get_record') ?> &nbsp; <i
                                                                    class="fa fa-sign-in"></i></button>
                                                        </div> <br> <br> <br>
    <?php echo form_close(); ?>

                                                    </div>

                                                </div>
                                            </div>    
                                            <div class="table-responsive">
                                                <table id="ytd_sale-tbl" cellpadding="0" cellspacing="0" border="0"
                                                       class="table table-bordered table-hover table-striped"
                                                       style="margin-bottom: 0;">
                                                    <thead>
                                                        <tr>
                                                            <!--<th style="width:30px !important;">#</th>-->
                                                            <th></th>
                                                            <th class="col-xs-2"><?= $this->lang->line("date"); ?></th>
                                                            <th class="col-xs-2"><?= $this->lang->line("reference_no"); ?></th>
                                                            <th class="col-xs-1"><?= $this->lang->line("mrp"); ?> <span class="rupee">&#8377;</span></th>
                                                            <th class="col-xs-2"><?= $this->lang->line("pay_status"); ?></th>
                                                            <th class="col-xs-1"><?= $this->lang->line("discount"); ?> <span class="rupee">&#8377;</span></th>
                                                            <th class="col-xs-1"><?= $this->lang->line("basic_price"); ?> <span class="rupee">&#8377;</span></th>
                                                            <!-- <th class="col-xs-1"><?= $this->lang->line("tax_amount"); ?> <span class="rupee">&#8377;</span></th> -->
                                                            <th class="col-xs-1"><?= $this->lang->line("cgst"); ?> <span class="rupee">&#8377;</span></th>
                                                            <th class="col-xs-1"><?= $this->lang->line("sgst"); ?> <span class="rupee">&#8377;</span></th>
                                                            <th class="col-xs-1"><?= $this->lang->line("paid_invoice"); ?> <span class="rupee">&#8377;</span></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td colspan="10" class="dataTables_empty"><?= lang('loading_data_from_server') ?></td>
                                                        </tr>

                                                    </tbody>
                                                    <tfoot class="dtFilter">
                                                        <tr class="active">
                                                            <th style="min-width:30px; width: 30px; text-align: center;">
                                                                <input class="checkbox checkft" type="checkbox" name="check"/>
                                                            </th>
                                                            <th></th>
                                                            <th></th>
                                                            <th></th>
                                                            <th></th>
                                                            <th></th>
                                                            <th></th>
                                                            <th></th>
                                                            <!--<th><?= lang("balance"); ?></th>-->
                                                            <th class="defaul-color"></th>

                                                            <th style="width:80px; text-align:center;"><?= lang("actions"); ?></th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

<?php } if ($Owner || $Admin || $GP['sales_return-index'] || $Manager || ($Sales && $GP['sales-return_sales']) ) { ?>

                                <div id="sales_return" class="tab-pane fade in">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="row">
                                                <div class="col-sm-12"> 

    <?php echo form_open(""); ?>  
                                                    <div class="div-title">
                                                        <h3 class="text-primary"><?= lang('select_period') ?></h3>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-3" style="float: left">
                                                            <div class="form-group">
                                                                <?php echo form_input('date', (isset($_POST['date']) ? $_POST['date'] : ""), 'class="form-control input-tip date" id="s3date" placeholder="Start Date" required="required" readonly="true"'); ?> 
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-3" style="float: left">
                                                            <div class="form-group">
                                                                <?php echo form_input('date', (isset($_POST['date']) ? $_POST['date'] : ""), 'class="form-control input-tip date" id="e3date" placeholder="End Date" required="required" readonly="true"'); ?>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-3">
                                                            <div class="form-group">
                                                                <!--<label class="control-label" for="payment_type"><?= lang("payment_type"); ?></label>-->
                                                                <?php
                                                                //echo form_dropdown('payment_type', $ptype, (isset($_POST['payment_type']) ? $_POST['payment_type'] : ""), 'class="form-control" id="payment_type" data-placeholder="' . $this->lang->line("select") . " " . $this->lang->line("payment_type") . '"');
                                                                echo form_dropdown('payment_type', 'Credit Note', (isset($_POST['payment_type']) ? $_POST['payment_type'] : ""), 'class="form-control"  id="payment_type" data-placeholder="' . $this->lang->line("select") . " " . $this->lang->line("payment_type") . '"');
                                                                ?>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-3">
                                                            <div class="form-group">
                                                                <!--<label class="control-label" for="payment_type"><?= lang("payment_type"); ?></label>-->
    <?php
    $reasons = array();
    foreach ($return_reasons as $k => $v) {
        $reasons[$v->id] = $v->reason;
    }
    $reasons[''] = "ALL";
    //echo form_dropdown('payment_type', $ptype, (isset($_POST['payment_type']) ? $_POST['payment_type'] : ""), 'class="form-control" id="payment_type" data-placeholder="' . $this->lang->line("select") . " " . $this->lang->line("payment_type") . '"');
    echo form_dropdown('return_reason', $reasons, (isset($_POST['return_reason']) ? $_POST['return_reason'] : ""), 'class="form-control"  id="return_reason" data-placeholder="' . $this->lang->line("select") . " " . $this->lang->line("return_reason") . '"');
    ?>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-3" style="float: left">
                                                            <button type="submit" id="b3" class="btn btn-success" >
    <?= lang('get_record') ?> &nbsp; <i class="fa fa-sign-in"></i>
                                                            </button> 
                                                        </div>
    <?php echo form_close(); ?>

                                                    </div>

                                                </div>
                                            </div>
                                            <div class="table-responsive">
                                                <table id="sales_return-tbl" cellpadding="0" cellspacing="0" border="0"
                                                       class="table table-bordered table-hover table-striped"
                                                       style="margin-bottom: 0;">
                                                    <thead>
                                                        <tr>
                                                            <th></th>
                                                            <th class="col-xs-2"><?= $this->lang->line("date"); ?></th>
                                                            <th class="col-xs-2"><?= $this->lang->line("reference_no"); ?></th>
                                                            <th class="col-xs-1"><?= $this->lang->line("mrp"); ?> <span class="rupee">&#8377;</span></th>
                                                            <th class="col-xs-2"><?= $this->lang->line("pay_status"); ?></th>
                                                            <th class="col-xs-1"><?= $this->lang->line("discount"); ?> <span class="rupee">&#8377;</span></th>
                                                            <th class="col-xs-1"><?= $this->lang->line("basic_price"); ?> <span class="rupee">&#8377;</span></th>
                                                            <!-- <th class="col-xs-1"><?= $this->lang->line("tax_amount"); ?> <span class="rupee">&#8377;</span></th> -->
                                                            <th class="col-xs-1"><?= $this->lang->line("cgst"); ?> <span class="rupee">&#8377;</span></th>
                                                            <th class="col-xs-1"><?= $this->lang->line("sgst"); ?> <span class="rupee">&#8377;</span></th>
                                                            <th class="col-xs-1"><?= $this->lang->line("paid_invoice"); ?> <span class="rupee">&#8377;</span></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td colspan="10" class="dataTables_empty"><?= lang('loading_data_from_server') ?></td>
                                                        </tr>

                                                    </tbody>
                                                    <tfoot class="dtFilter">
                                                        <tr class="active">
                                                            <th style="min-width:30px; width: 30px; text-align: center;">
                                                                <input class="checkbox checkft" type="checkbox" name="check"/>
                                                            </th>
                                                            <th></th>
                                                            <th></th>
                                                            <th></th>
                                                            <th></th>
                                                            <th></th>
                                                            <th></th>
                                                            <th></th>
                                                            <!--<th><?= lang("balance"); ?></th>-->
                                                            <th class="defaul-color"></th>

                                                            <th style="width:80px; text-align:center;"><?= lang("actions"); ?></th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                                        <?php } if ($Owner || $Admin || $GP['sales_discount-index'] || $Manager || $Sales) { ?>

                                <div id="sales_discount" class="tab-pane fade in">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div id="form">
                                                            <?php echo form_open(""); ?>
                                                <div class="row">
                                                    <div class="col-sm-3" style="float: left">
                                                        <div class="form-group">
    <?php echo form_input('s4date', (isset($_POST['date']) ? $_POST['date'] : ""), 'class="form-control input-tip date" id="s4date" placeholder="Start Date" required="required" readonly="true"'); ?> 
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3" style="float: left">
                                                        <div class="form-group">
                                                                <?php echo form_input('e4date', (isset($_POST['date']) ? $_POST['date'] : ""), 'class="form-control input-tip date" id="e4date" placeholder="End Date" required="required" readonly="true"'); ?>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <div class="form-group">
    <?php
    echo form_dropdown('discount_type', $dtype, (isset($_POST['discount_type']) ? $_POST['discount_type'] : ""), 'class="form-control" id="discount_type" data-placeholder="' . $this->lang->line("select") . " " . $this->lang->line("discount_type") . '"');
    ?>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-4">
                                                        <div class="form-group">
                                                            <button type="submit" id="today_discount_type" class="btn btn-success" >
    <?= lang('get_record') ?> &nbsp;<i class="fa fa-sign-in"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
    <?php echo form_close(); ?>
                                            </div>
                                            <div class="table-responsive">
                                                <table id="sales_discount-tbl" cellpadding="0" cellspacing="0" border="0"
                                                       class="table table-bordered table-hover table-striped"
                                                       style="margin-bottom: 0;">
                                                    <thead>
                                                        <tr>
                                                            <th></th>
                                                            <th class="col-xs-2"><?= $this->lang->line("date"); ?></th>
                                                            <th class="col-xs-2"><?= $this->lang->line("reference_no"); ?></th>
                                                            <th class="col-xs-1"><?= $this->lang->line("mrp"); ?> <span class="rupee">&#8377;</span></th>
                                                            <th class="col-xs-2"><?= $this->lang->line("paid_by"); ?></th>
                                                            <th class="col-xs-1"><?= $this->lang->line("discount"); ?> <span class="rupee">&#8377;</span></th>
                                                            <th class="col-xs-1"><?= $this->lang->line("basic_price"); ?> <span class="rupee">&#8377;</span></th>
                                                           <!--  <th class="col-xs-1"><?= $this->lang->line("tax_amount"); ?> <span class="rupee">&#8377;</span></th> -->
                                                            <th class="col-xs-1"><?= $this->lang->line("cgst"); ?> <span class="rupee">&#8377;</span></th>
                                                            <th class="col-xs-1"><?= $this->lang->line("sgst"); ?> <span class="rupee">&#8377;</span></th>
                                                            <th class="col-xs-1"><?= $this->lang->line("paid_invoice"); ?> <span class="rupee">&#8377;</span></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td colspan="10" class="dataTables_empty"><?= lang('loading_data_from_server') ?></td>
                                                        </tr>

                                                    </tbody>
                                                    <tfoot class="dtFilter">
                                                        <tr class="active">
                                                            <th style="min-width:30px; width: 30px; text-align: center;">
                                                                <input class="checkbox checkft" type="checkbox" name="check"/>
                                                            </th>
                                                            <th></th>
                                                            <th></th>
                                                            <th></th>
                                                            <th></th>
                                                            <th></th>
                                                            <th></th>
                                                            <th></th>
                                                            <!--<th><?= lang("balance"); ?></th>-->
                                                            <th class="defaul-color"></th>

                                                            <th style="width:80px; text-align:center;"><?= lang("actions"); ?></th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

<?php } ?>

                        </div>


                    </div>

                </div>

            </div>
        </div>
    </div>

</div>

<!--End the code of update by Ankit ----->



<script type="text/javascript">
    $(document).ready(function () {
        $('.order').click(function () {
            window.location.href = '<?= site_url() ?>orders/view/' + $(this).attr('id') + '#comments';
        });
        $('.invoice').click(function () {
            window.location.href = '<?= site_url() ?>orders/view/' + $(this).attr('id');
        });
        $('.quote').click(function () {
            window.location.href = '<?= site_url() ?>quotes/view/' + $(this).attr('id');
        });
    });
</script>

<?php if (($Owner || $Admin) && $chatData) { ?>
    <style type="text/css" media="screen">
        .tooltip-inner {
            max-width: 500px;
        }
    </style>
    <script src="<?= $assets; ?>js/hc/highcharts.js"></script>
    <script type="text/javascript">
    $(function () {
        Highcharts.getOptions().colors = Highcharts.map(Highcharts.getOptions().colors, function (color) {
            return {
                radialGradient: {cx: 0.5, cy: 0.3, r: 0.7},
                stops: [[0, color], [1, Highcharts.Color(color).brighten(-0.3).get('rgb')]]
            };
        });
        $('#ov-chart').highcharts({
            chart: {},
            credits: {enabled: false},
            title: {text: ''},
            xAxis: {categories: <?= json_encode($months); ?>},
            yAxis: {min: 0, title: ""},
            tooltip: {
                shared: true,
                followPointer: true,
                formatter: function () {
                    if (this.key) {
                        return '<div class="tooltip-inner hc-tip" style="margin-bottom:0;">' + this.key + '<br><strong>' + currencyFormat(this.y) + '</strong> (' + formatNumber(this.percentage) + '%)';
                    } else {
                        var s = '<div class="well well-sm hc-tip" style="margin-bottom:0;"><h2 style="margin-top:0;">' + this.x + '</h2><table class="table table-striped"  style="margin-bottom:0;">';
                        $.each(this.points, function () {
                            s += '<tr><td style="color:{series.color};padding:0">' + this.series.name + ': </td><td style="color:{series.color};padding:0;text-align:right;"> <b>' +
                                    currencyFormat(this.y) + '</b></td></tr>';
                        });
                        s += '</table></div>';
                        return s;
                    }
                },
                useHTML: true, borderWidth: 0, shadow: false, valueDecimals: site.settings.decimals,
                style: {fontSize: '14px', padding: '0', color: '#000000'}
            },
            series: [{
                    type: 'column',
                    name: '<?= lang("sp_tax"); ?>',
                    data: [<?php
    echo implode(', ', $mtax1);
    ?>]
                },
                {
                    type: 'column',
                    name: '<?= lang("order_tax"); ?>',
                    data: [<?php
    echo implode(', ', $mtax2);
    ?>]
                },
                {
                    type: 'column',
                    name: '<?= lang("sales"); ?>',
                    data: [<?php
    echo implode(', ', $msales);
    ?>]
                }, {
                    type: 'spline',
                    name: '<?= lang("purchases"); ?>',
                    data: [<?php
    echo implode(', ', $mpurchases);
    ?>],
                    marker: {
                        lineWidth: 2,
                        states: {
                            hover: {
                                lineWidth: 4
                            }
                        },
                        lineColor: Highcharts.getOptions().colors[3],
                        fillColor: 'white'
                    }
                }, {
                    type: 'spline',
                    name: '<?= lang("pp_tax"); ?>',
                    data: [<?php
    echo implode(', ', $mtax3);
    ?>],
                    marker: {
                        lineWidth: 2,
                        states: {
                            hover: {
                                lineWidth: 4
                            }
                        },
                        lineColor: Highcharts.getOptions().colors[3],
                        fillColor: 'white'
                    }
                }, {
                    type: 'pie',
                    name: '<?= lang("stock_value"); ?>',
                    data: [
                        ['', 0],
                        ['', 0],
                        ['<?= lang("stock_value_by_price"); ?>', <?php echo $stock->stock_by_price; ?>],
                        ['<?= lang("stock_value_by_cost"); ?>', <?php echo $stock->stock_by_cost; ?>],
                    ],
                    center: [80, 42],
                    size: 80,
                    showInLegend: false,
                    dataLabels: {
                        enabled: false
                    }
                }]
        });
    });
    </script>

    <script type="text/javascript">
        $(function () {
            $('#lmbschart').highcharts({
                chart: {type: 'column'},
                title: {text: ''},
                credits: {enabled: false},
                xAxis: {type: 'category', labels: {rotation: -60, style: {fontSize: '13px'}}},
                yAxis: {min: 0, title: {text: ''}},
                legend: {enabled: false},
                series: [{
                        name: '<?= lang('sold'); ?>',
                        data: [<?php
    foreach ($lmbs as $r) {
        if ($r->SoldQty > 0) {
            echo "['" . $r->name . "', " . $r->SoldQty . "],";
        }
    }
    ?>],
                        dataLabels: {
                            enabled: true,
                            rotation: -90,
                            color: '#000',
                            align: 'right',
                            y: -25,
                            style: {fontSize: '12px'}
                        }
                    }]
            });
            $('#bschart').highcharts({
                chart: {type: 'column'},
                title: {text: ''},
                credits: {enabled: false},
                xAxis: {type: 'category', labels: {rotation: -60, style: {fontSize: '13px'}}},
                yAxis: {min: 0, title: {text: ''}},
                legend: {enabled: false},
                series: [{
                        name: '<?= lang('sold'); ?>',
                        data: [<?php
    foreach ($bs as $r) {
        if ($r->SoldQty > 0) {
            echo "['" . $r->name . "', " . $r->SoldQty . "],";
        }
    }
    ?>],
                        dataLabels: {
                            enabled: true,
                            rotation: -90,
                            color: '#000',
                            align: 'right',
                            y: -25,
                            style: {fontSize: '12px'}
                        }
                    }]
            });

        });
    </script>
    <div class="row" style="margin-bottom: 15px;">
        <div class="col-sm-6">
            <div class="box">
                <div class="box-header">
                    <h2 class="blue"><i
                            class="fa-fw fa fa-bar-chart-o"></i><?= lang('best_seller'), ' (' . date('M-Y', time()) . ')'; ?>
                    </h2>
                </div>
                <div class="box-content">
                    <div class="row">
                        <div class="col-md-12">
                            <div id="bschart" style="width:100%; height:450px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="box">
                <div class="box-header">
                    <h2 class="blue"><i
                            class="fa-fw fa fa-bar-chart-o"></i><?= lang('best_seller') . ' (' . date('M-Y', strtotime('-1 month')) . ')'; ?>
                    </h2>
                </div>
                <div class="box-content">
                    <div class="row">
                        <div class="col-md-12">
                            <div id="lmbschart" style="width:100%; height:450px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<!------------ ADD By Ankit------------------>
<script>
    jQuery(document).ready(function () {
        jQuery("#payment_type").prop('readonly', true);
        jQuery("#ydate").datetimepicker({
            changeMonth: false,
            daysDisabled: [0, 1, 2, 3, 4, 5, 6],
            minView: 4,
            changeYear: true,
            autoclose: true,
            showSecond: false,
            startView: 4,
            format: 'yyyy',
            endDate: new Date(),
        });
    });


    jQuery(document).ready(function () {
        jQuery("#sdate").datetimepicker({
            changeMonth: true,
            autoclose: true,
            showSecond: false,
            minView: 4,
            //format: 'yyyy-mm-dd',
            // changed by vikas singh
            format: 'yyyy-mm-dd',
            startDate: 'today',
            endDate: new Date(),
        });

        jQuery("#edate").datetimepicker({
            changeMonth: true,
            autoclose: true,
            showSecond: false,
            minView: 4,
            //format: 'yyyy-mm-dd',
            // changed by vikas singh
            format: 'yyyy-mm-dd',
            endDate: new Date(),
        });

        jQuery('#edate').change(function () {
            var diff = dateDiff($('#sdate').datetimepicker({dateFormat: 'yyyy-mm-dd'}).val(),
                    $('#edate').datetimepicker({dateFormat: 'yyyy-mm-dd'}).val());
        });


        jQuery('#sdate').change(function () {
            var diff = dateDiff($('#sdate').datetimepicker({dateFormat: 'yyyy-mm-dd'}).val(),
                    $('#edate').datetimepicker({dateFormat: 'yyyy-mm-dd'}).val());
        });
    });


    jQuery(document).ready(function () {
        jQuery("#s3date").datetimepicker({
            // changeMonth: true,
            // autoclose:true,
            // showSecond: false,
            // minView: 2,
            // format: 'yyyy-mm-dd',
            // startDate: 'today',
            // endDate: new Date(),

            changeMonth: true,
            autoclose: true,
            showSecond: false,
            minView: 4,
            //format: 'yyyy-mm-dd',
            // changed by vikas singh
            format: 'yyyy-mm-dd',
            startDate: 'today',
            endDate: new Date(),
        });

        jQuery("#e3date").datetimepicker({
            // changeMonth: true,
            // autoclose:true,
            // showSecond: false,
            // minView: 2,
            // format: 'yyyy-mm-dd',
            // endDate: new Date(),
            changeMonth: true,
            autoclose: true,
            showSecond: false,
            minView: 4,
            //format: 'yyyy-mm-dd',
            // changed by vikas singh
            format: 'yyyy-mm-dd',
            endDate: new Date(),
        });

        jQuery('#e3date').change(function () {
            var diff = dateDiff1($('#s3date').datetimepicker({dateFormat: 'yyyy-mm-dd'}).val(),
                    $('#e3date').datetimepicker({dateFormat: 'yyyy-mm-dd'}).val());
        });


        jQuery('#s3date').change(function () {
            var diff = dateDiff1($('#s3date').datetimepicker({dateFormat: 'yyyy-mm-dd'}).val(),
                    $('#e3date').datetimepicker({dateFormat: 'yyyy-mm-dd'}).val());
        });
        jQuery("#s4date").datetimepicker({
            changeMonth: true,
            autoclose: true,
            showSecond: false,
            minView: 4,
            format: 'yyyy-mm-dd',
            startDate: 'today',
            endDate: new Date(),
        });

        jQuery("#e4date").datetimepicker({
            changeMonth: true,
            autoclose: true,
            showSecond: false,
            minView: 4,
            format: 'yyyy-mm-dd',
            endDate: new Date(),
        });

        jQuery('#e4date').change(function () {
            var diff = dateDiff1($('#s4date').datetimepicker({dateFormat: 'yyyy-mm-dd'}).val(),
                    $('#e4date').datetimepicker({dateFormat: 'yyyy-mm-dd'}).val());
        });


        jQuery('#s4date').change(function () {
            var diff = dateDiff1($('#s4date').datetimepicker({dateFormat: 'yyyy-mm-dd'}).val(),
                    $('#e4date').datetimepicker({dateFormat: 'yyyy-mm-dd'}).val());
        });
    });
</script>
<script>

    function dateDiff(startDate, endDate) {

        var startDate = new Date(startDate);
        var endDate = new Date(endDate);

        if (Date.parse(endDate) < Date.parse(startDate)) {
            alert("Invalid Date Range, Total Days cannot be less than 0");
            jQuery('#edate').val('');
            return false;
        }

    }
    function dateDiff1(startDate, endDate) {

        var startDate = new Date(startDate);
        var endDate = new Date(endDate);

        if (Date.parse(endDate) < Date.parse(startDate)) {
            alert("Invalid Date Range, Total Days cannot be less than 0");
            jQuery('#e3date').val('');
            return false;
        }

    }


    $('#b1').on('click', function (event) {
        event.preventDefault();
        if (jQuery("#sdate").val() == '') {
            alert('Please select start date');
            $('#sdate').focus();
            return false;
        }
        if (jQuery("#edate").val() == '') {
            alert('Please select end date');
            $('#edate').focus();
            return false;
        }
        // added by vikas singh
        if (jQuery("#period_pay_type").val() == '') {
            alert('Please select Payment Type');
            $('#period_pay_type').focus();
            return false;
        }
        var sdate = $("#sdate").val();
        var edate = $("#edate").val();
        var pay_type = $("#period_pay_type").val();

        var oTable = $('#period_set-tbl').dataTable({
            "aaSorting": [[1, "desc"]],
            "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "<?= lang('all') ?>"]],
            "iDisplayLength": <?= $Settings->rows_per_page ?>,
            'bProcessing': true, 'bServerSide': false, 'bDestroy': true,
            'sAjaxSource': '<?= site_url('welcome/getPeriodSales') ?>',
            'fnServerData': function (sSource, aoData, fnCallback) {
                aoData.push({
                    "name": "<?= $this->security->get_csrf_token_name() ?>",
                    "value": "<?= $this->security->get_csrf_hash() ?>",
                    "name": "date",
                            "value": sdate + '|' + edate + '|' + pay_type/*,
                             "name": "payment_type",
                             "value": pay_type*/

                });
                $.ajax({'dataType': 'json', 'type': 'POST', 'url': sSource, 'data': aoData, 'success': fnCallback});
                //console.log(aoData);
            },
            'fnRowCallback': function (nRow, aData, iDisplayIndex) {
                var oSettings = oTable.fnSettings();
                nRow.id = aData[0];
                nRow.className = "receipt_link";
                return nRow;
            },
            "aoColumns": [{
                    "bSortable": false, "bVisible": false, "mRender": function () {
                        return '<span class="receipt_link">view</span>';
                    }
                },
                {"mRender": dateonly}, null,
                {"mRender": currencyFormat},
                null, null,
                {"mRender": currencyFormat},
                {"mRender": currencyFormat},
                {"mRender": currencyFormat},
                {"mRender": currencyFormat},
                {"mRender": currencyFormat}],
            "fnFooterCallback": function (nRow, aaData, iStart, iEnd, aiDisplay) {
                console.log(aaData);
                var total_tax = 0, total_mrp = 0, total = 0, total_discount = 0, total_basic_price = 0;// balance = 0;
                for (var i = 0; i < aaData.length; i++) {
                    if(aiDisplay[i] == 0 || aiDisplay[i]) {
                        total_discount += parseFloat(aaData[aiDisplay[i]][6]);
                        total_basic_price += parseFloat(aaData[aiDisplay[i]][7]);
                        total += parseFloat(aaData[aiDisplay[i]][10]);
                        total_tax += parseFloat(aaData[aiDisplay[i]][8]);
                        total_mrp += parseFloat(aaData[aiDisplay[i]][3]);
                    }
                }
                var nCells = nRow.getElementsByTagName('th');
                console.log(nCells);
                nCells[1].innerHTML = '';
                nCells[2].innerHTML = currencyFormat(parseFloat(total_mrp));
                nCells[3].innerHTML = '';
                nCells[4].innerHTML = '';
                nCells[5].innerHTML = currencyFormat(parseFloat(total_discount));
                nCells[6].innerHTML = currencyFormat(parseFloat(total_basic_price));
                nCells[7].innerHTML = currencyFormat(parseFloat(total_tax));
                nCells[8].innerHTML = currencyFormat(parseFloat(total_tax));
                nCells[9].innerHTML = currencyFormat(parseFloat(total));
//                //nCells[7].innerHTML = currencyFormat(parseFloat(balance));
            }
        });
    });

    $('#b3').on('click', function (event) {
        event.preventDefault();
        if (jQuery("#s3date").val() == '') {
            alert('Please select start date');
            $('#s3date').focus();
            return false;
        }
        if (jQuery("#e3date").val() == '') {
            alert('Please select end date');
            $('#e3date').focus();
            return false;
        }
        var sdate = $("#s3date").val();
        var edate = $("#e3date").val();
        var pay_type = $("#payment_type").val();
        var return_reason = $('#return_reason option:selected').val();
        //console.log(sdate);console.log(edate);
        //alert(pay_type);

        var oTable = $('#sales_return-tbl').dataTable({
            "aaSorting": [[1, "desc"]],
            "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "<?= lang('all') ?>"]],
            "iDisplayLength": <?= $Settings->rows_per_page ?>,
            'bProcessing': true, 'bServerSide': false, 'bDestroy': true,
            'sAjaxSource': '<?= site_url('welcome/getSaleRreturn') ?>',
            'fnServerData': function (sSource, aoData, fnCallback) {
                aoData.push({
                    "name": "<?= $this->security->get_csrf_token_name() ?>",
                    "value": "<?= $this->security->get_csrf_hash() ?>",
                    "name": "date",
                            //"value": sdate+'|'+edate+'|'+pay_type
                            "value": sdate + '|' + edate + '|' + pay_type + '|' + return_reason
                });
                $.ajax({'dataType': 'json', 'type': 'POST', 'url': sSource, 'data': aoData, 'success': fnCallback});
                //console.log(aoData);
            },
            'fnRowCallback': function (nRow, aData, iDisplayIndex) {
                var oSettings = oTable.fnSettings();
                nRow.id = aData[0];
                nRow.className = "return_link";
                return nRow;
            },
            "aoColumns": [{"bSortable": false, "bVisible": false,
                    "mRender": function () {
                        return '<span class="receipt_link">view</span>';
                    }
                },
                {"mRender": dateonly}, null,
                //{"mRender": currencyFormat}, 
                {"mRender": currencyFormat},
                null,
                {"mRender": currencyFormat},
                {"mRender": currencyFormat},
                {"mRender": currencyFormat},
                {"mRender": currencyFormat},
                {"mRender": currencyFormat}],
            "fnFooterCallback": function (nRow, aaData, iStart, iEnd, aiDisplay) {
                console.log(aaData);
                var total_tax = 0, total_mrp = 0, total = 0, total_discount = 0, total_basic_price = 0;// balance = 0;
                for (var i = 0; i < aaData.length; i++) {
                    //aiDisplay[i] != '' ? aiDisplay[i] : 0;
                    //console.log("length"+aiDisplay.length);
                    if(aiDisplay[i] == 0 || aiDisplay[i]) {
                        total_discount += parseFloat(aaData[aiDisplay[i]][5]);
                        total_basic_price += parseFloat(aaData[aiDisplay[i]][6]);
                        total += parseFloat(aaData[aiDisplay[i]][9]);
                        total_tax += parseFloat(aaData[aiDisplay[i]][7]);
                        total_mrp += parseFloat(aaData[aiDisplay[i]][3]);
                    }
                }
                var nCells = nRow.getElementsByTagName('th');
                nCells[1].innerHTML = '';
                nCells[2].innerHTML = currencyFormat(parseFloat(total_mrp));
                nCells[4].innerHTML = currencyFormat(parseFloat(total_discount));
                nCells[5].innerHTML = currencyFormat(parseFloat(total_basic_price));
                nCells[6].innerHTML = currencyFormat(parseFloat(total_tax));
                nCells[7].innerHTML = currencyFormat(parseFloat(total_tax));
                nCells[8].innerHTML = currencyFormat(parseFloat(total));
//              nCells[2].innerHTML = currencyFormat(parseFloat(total_mrp));
                nCells[3].innerHTML = '';
//                //nCells[7].innerHTML = currencyFormat(parseFloat(balance));
            }
        });
    });

    $(document).ready(function () {
        //load_discount('all','sales_discount-tbl','getSaleDiscount');
        load_month('', 'today-tbl', 'todaysales');
        load_month('', 'month-tbl', 'currentmonth');
        load_month('', 'last_month-tbl', 'lastmonth');
        //load_month('','period_set-tbl','getPeriodSales');
    });
    function load_discount(pay_type, div_id, func, sdate, edate) {
        var oTable = $('#' + div_id).dataTable({
            "aaSorting": [[1, "desc"]],
            "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "<?= lang('all') ?>"]],
            "iDisplayLength": <?= $Settings->rows_per_page ?>,
            'bProcessing': true, 'bServerSide': false, 'bDestroy': true,
            'sAjaxSource': site.base_url + "welcome/" + func,
            'fnServerData': function (sSource, aoData, fnCallback) {
                aoData.push({
//                    "name": "<?= $this->security->get_csrf_token_name() ?>",
//                    "value": "<?= $this->security->get_csrf_hash() ?>"
                    "name": "discount_type",
                    "value": sdate + '|' + edate + '|' + pay_type
                });
                $.ajax({'dataType': 'json', 'type': 'POST', 'url': sSource, 'data': aoData, 'success': fnCallback});
                //console.log(aoData);
            },
            'fnRowCallback': function (nRow, aData, iDisplayIndex) {
                var oSettings = oTable.fnSettings();
                nRow.id = aData[0];
                nRow.className = "receipt_link";
                if (aData[4] == 'credit_voucher')
                {
                    aData[4] == 'Credit Note';
                }
                if (aData[4] == 'CC')
                {
                    aData[4] == 'Credit/Debit Card';
                }
                if (aData[4] == 'cash')
                {
                    aData[4] == 'Cash';
                }
                return nRow;
            },
            "aoColumns": [{
                    "bSortable": false,
                    "bVisible": false,
                    "mRender": function () {
                        return '<span class="receipt_link">view</span>';
                    }

                },
                {"mRender": dateonly}, null, {"mRender": currencyFormat}, null, {"mRender": currencyFormat}, {"mRender": currencyFormat}, {"mRender": currencyFormat}, {"mRender": currencyFormat}, {"mRender": currencyFormat}],
            "fnFooterCallback": function (nRow, aaData, iStart, iEnd, aiDisplay) {
                console.log(aaData);
                var total_tax = 0, total_mrp = 0, total = 0, total_discount = 0, total_basic_price = 0;// balance = 0;
                for (var i = 0; i < aaData.length; i++) {
                    if(aiDisplay[i] == 0 || aiDisplay[i]) {
                        total_discount += parseFloat(aaData[aiDisplay[i]][5]);
                        total_basic_price += parseFloat(aaData[aiDisplay[i]][6]);
                        total += parseFloat(aaData[aiDisplay[i]][9]);
                        total_tax += parseFloat(aaData[aiDisplay[i]][7]);
                        total_mrp += parseFloat(aaData[aiDisplay[i]][3]);
                    }
                }
                var nCells = nRow.getElementsByTagName('th');
                console.log(nCells);
                nCells[1].innerHTML = '';
                nCells[2].innerHTML = currencyFormat(parseFloat(total_mrp));
                nCells[3].innerHTML = '';
                nCells[4].innerHTML = currencyFormat(parseFloat(total_discount));
                nCells[5].innerHTML = currencyFormat(parseFloat(total_basic_price));
                nCells[6].innerHTML = currencyFormat(parseFloat(total_tax));
                nCells[7].innerHTML = currencyFormat(parseFloat(total_tax));
                nCells[8].innerHTML = currencyFormat(parseFloat(total));

//                //nCells[7].innerHTML = currencyFormat(parseFloat(balance));
            }
        });
    }
    function load_month(pay_type, div_id, func)
    {
        var oTable = $('#' + div_id).dataTable({
            "aaSorting": [[1, "desc"]],
            "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "<?= lang('all') ?>"]],
            "iDisplayLength": <?= $Settings->rows_per_page ?>,
            'bProcessing': true, 'bServerSide': false, 'bDestroy': true,
            'sAjaxSource': site.base_url + "welcome/" + func,
            'fnServerData': function (sSource, aoData, fnCallback) {
                aoData.push({
                    //"name": "<?= $this->security->get_csrf_token_name() ?>",
                    //"value": "<?= $this->security->get_csrf_hash() ?>",
                    "name": "payment_type",
                    "value": pay_type
                });
                $.ajax({'dataType': 'json', 'type': 'POST', 'url': sSource, 'data': aoData, 'success': fnCallback});
                //console.log(aoData);
            },
            'fnRowCallback': function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
                // console.log(aData);
                var oSettings = oTable.fnSettings();
                nRow.id = aData[0];
                if (aData[4] == 'credit_voucher')
                {
                    aData[4] == 'Credit Note';
                }
                if (aData[4] == 'CC')
                {
                    aData[4] == 'Credit/Debit Card';
                }
                if (aData[4] == 'cash')
                {
                    aData[4] == 'Cash';
                }
                nRow.className = "receipt_link";
                return nRow;
            },
            "aoColumns": [{"bSortable": false, "bVisible": false, "bSearching": true, "mRender": function () {
                        return '<span class="receipt_link">view</span>';
                    }
                },
                {"mRender": dateonly},
                null,
                //{"mRender": currencyFormat}, 
                {"mRender": currencyFormat},
                null,
                null,
                {"mRender": currencyFormat},
                {"mRender": currencyFormat},
                {"mRender": currencyFormat},
                {"mRender": currencyFormat},
                {"mRender": currencyFormat}],
            "fnFooterCallback": function (nRow, aaData, iStart, iEnd, aiDisplay) {
                // console.log(aaData);
                // return false;
                var total_tax = 0, total_mrp = 0, total = 0, total_discount = 0, total_basic_price = 0;
                cgst = 0;
                sgst = 0// balance = 0;
                for (var i = 0; i < aaData.length; i++) {
                    if(aiDisplay[i] == 0 || aiDisplay[i]) {
                        total_discount += parseFloat(aaData[aiDisplay[i]][6]);
                        total_basic_price += parseFloat(aaData[aiDisplay[i]][7]);
                        total += parseFloat(aaData[aiDisplay[i]][10]);
                        //total_tax += parseFloat(aaData[aiDisplay[i]][8]);
                        cgst += parseFloat(aaData[aiDisplay[i]][8]);
                        sgst += parseFloat(aaData[aiDisplay[i]][9]);
                        total_mrp += parseFloat(aaData[aiDisplay[i]][3]);
                    }
                }

                var nCells = nRow.getElementsByTagName('th');
                // console.log("length==================>",nCells.length);
                nCells[1].innerHTML = '';
                nCells[2].innerHTML = currencyFormat(parseFloat(total_mrp));
                nCells[3].innerHTML = '';
                nCells[4].innerHTML = '';
                nCells[5].innerHTML = currencyFormat(parseFloat(total_discount));
                nCells[6].innerHTML = currencyFormat(parseFloat(total_basic_price));
                //nCells[7].innerHTML = currencyFormat(parseFloat(total_tax));
                nCells[7].innerHTML = currencyFormat(parseFloat(cgst));
                nCells[8].innerHTML = currencyFormat(parseFloat(sgst));
                nCells[9].innerHTML = currencyFormat(parseFloat(total));

//                //nCells[7].innerHTML = currencyFormat(parseFloat(balance));
            }
        });
    }

    $("#today_pay").on('click', function (event) {
        event.preventDefault();
        var pay_type = $("#today_pay_type").val();
        if (pay_type != '') {
            load_month(pay_type, 'today-tbl', 'todaysales');
        }
        else {
            bootbox.alert("Please select a payment mode!");
            return false;
        }
    });

    $("#today_discount_type").on('click', function (event) {
        event.preventDefault();
        if (jQuery("#s4date").val() == '') {
            alert('Please select start date');
            $('#s4date').focus();
            return false;
        }
        if (jQuery("#e4date").val() == '') {
            alert('Please select end date');
            $('#e4date').focus();
            return false;
        }
        var sdate = $("#s4date").val();
        var edate = $("#e4date").val();
        var discount_type = $("#discount_type").val();
        if (discount_type != '') {
            load_discount(discount_type, 'sales_discount-tbl', 'getSaleDiscount', sdate, edate);
        }
        else if (discount_type === 'all') {
            load_discount(discount_type, 'sales_discount-tbl', 'getSaleDiscount', sdate, edate);

        } else {
            bootbox.alert("Please select a payment mode!");
            return false;
        }
    });


    $("#month_pay").on('click', function (event) {
        event.preventDefault();
        var pay_type = $("#month_pay_type").val();
        if (pay_type != '') {
            load_month(pay_type, 'month-tbl', 'currentmonth');
        }
        else {
            bootbox.alert("Please select a payment mode!");
            return false;
        }
    });

    $("#last_month_pay").on('click', function (event) {
        event.preventDefault();
        var pay_type = $("#last_month_pay_type").val();
        if (pay_type != '') {
            load_month(pay_type, 'last_month-tbl', 'lastmonth');
        }
        else {
            bootbox.alert("Please select a payment mode!");
            return false;
        }
    });

    $('#b2').on('click', function (event) {
        event.preventDefault();
        if (jQuery("#ydate").val() == '') {
            alert('Please select year');
            $('#ydate').focus();
            return false;
        }

        var ydate = $("#ydate").val();
        var oTable = $('#ytd_sale-tbl').dataTable({
            "aaSorting": [[1, "desc"]],
            "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "<?= lang('all') ?>"]],
            "iDisplayLength": <?= $Settings->rows_per_page ?>,
            'bProcessing': true, 'bServerSide': false, 'bDestroy': true,
            'sAjaxSource': '<?= site_url('welcome/getytdSales') ?>',
            'fnServerData': function (sSource, aoData, fnCallback) {
                aoData.push({
                    "name": "<?= $this->security->get_csrf_token_name() ?>",
                    "value": "<?= $this->security->get_csrf_hash() ?>",
                    "name": "year",
                            "value": ydate

                });
                $.ajax({'dataType': 'json', 'type': 'POST', 'url': sSource, 'data': aoData, 'success': fnCallback});
                //console.log(aoData);
            },
            'fnRowCallback': function (nRow, aData, iDisplayIndex) {
                var oSettings = oTable.fnSettings();
                nRow.id = aData[0];
                nRow.className = "receipt_link";
                if (aData[4] == 'credit_voucher')
                {
                    aData[4] == 'Credit Note';
                }
                if (aData[4] == 'CC')
                {
                    aData[4] == 'Credit/Debit Card';
                }
                if (aData[4] == 'cash')
                {
                    aData[4] == 'Cash';
                }
                return nRow;
            },
            "aoColumns": [{
                    "bSortable": false,
                    "bVisible": false,
                    "mRender": function () {
                        return '<span class="receipt_link">view</span>';
                    }
                },
                {"mRender": dateonly}, null, //null,
                //{"mRender": currencyFormat}, 
                {"mRender": currencyFormat},
                null,
                //{"mRender": currencyFormat}, 
                {"mRender": currencyFormat},
                {"mRender": currencyFormat},
                {"mRender": currencyFormat},
                {"mRender": currencyFormat},
                {"mRender": currencyFormat}],
            "fnFooterCallback": function (nRow, aaData, iStart, iEnd, aiDisplay) {
                console.log(aaData);
                var total_tax = 0, total_mrp = 0, total = 0, total_discount = 0, total_basic_price = 0;// balance = 0;
                for (var i = 0; i < aaData.length; i++) {
                    if(aiDisplay[i] == 0 || aiDisplay[i]) {
                        total_discount += parseFloat(aaData[aiDisplay[i]][5]);
                        total_basic_price += parseFloat(aaData[aiDisplay[i]][6]);
                        total += parseFloat(aaData[aiDisplay[i]][9]);
                        total_tax += parseFloat(aaData[aiDisplay[i]][7]);
                        total_mrp += parseFloat(aaData[aiDisplay[i]][3]);
                    }
                }
                var nCells = nRow.getElementsByTagName('th');
                // console.log(nCells);
                nCells[4].innerHTML = currencyFormat(parseFloat(total_discount));
                nCells[5].innerHTML = currencyFormat(parseFloat(total_basic_price));
                nCells[8].innerHTML = currencyFormat(parseFloat(total));
                nCells[6].innerHTML = currencyFormat(parseFloat(total_tax));
                nCells[7].innerHTML = currencyFormat(parseFloat(total_tax));
                nCells[2].innerHTML = currencyFormat(parseFloat(total_mrp));
//                //nCells[7].innerHTML = currencyFormat(parseFloat(balance));
            }
        });
    });
</script>     
<!-- Add By Ankit for  Syncing -->
<script type="text/javascript">
    $('#export').click(function (event) {
        event.preventDefault();
        var r = confirm("Are you sure you want to Sync POS DB Data To Intermediate?");
        if (r == true) {
            window.location = $(this).attr('href');
        }

    });
    $('#import').click(function (event) {
        event.preventDefault();
        var r = confirm("Are you sure you want to Sync Intermediate DB To POS?");
        if (r == true) {
            window.location = $(this).attr('href');
        }

    });
// Add by ankit for empty POS DB
    $('#emptypos').click(function (event) {
        event.preventDefault();
        var r = confirm("Are you sure you want to Empty POS Data Base?");
        if (r == true) {
            window.location = $(this).attr('href');
        }

    });
</script>
<!-- End Add By Ankit for  Syncing -->

