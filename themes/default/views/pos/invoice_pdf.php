<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title><?= $page_title . " " . lang("no") . " " . $inv->id; ?></title>
        <base href="<?= base_url() ?>"/>
        <meta http-equiv="cache-control" content="max-age=0"/>
        <meta http-equiv="cache-control" content="no-cache"/>
        <meta http-equiv="expires" content="0"/>
        <meta http-equiv="pragma" content="no-cache"/>
        <link rel="shortcut icon" href="<?= $assets ?>images/icon.png"/>
        <link rel="stylesheet" href="<?= $assets ?>styles/theme.css" type="text/css"/>

        <style type="text/css" media="all">
            body {
                color: #000;
            }

            .rupee{
                font-family: Arial;
                margin-right: 5px;
            }
            p{
                font-size: 11px;
            }
            .right-space{margin:0 10px;}
            .border-cover{
                border-right:1px solid #DDDDDD;
                font-size: 10px;border-bottom:1px solid #DDDDDD;
            }
            hr {
                -moz-border-bottom-colors: none;
                -moz-border-image: none;
                -moz-border-left-colors: none;
                -moz-border-right-colors: none;
                -moz-border-top-colors: none;
                border-color: #EEEEEE -moz-use-text-color #FFFFFF;
                border-style: solid none;
                border-width: 1px 0;
                margin: 5px 0;
            }        
            .stable{
                font-size:11px;
                padding:0px !important;
            }
            #wrapper {
                max-width: 700px;
                margin: 0 auto;
                padding-top: 20px;
            }

            .font-weight-bold{
                font-weight: bold;
            }

            .btn {
                border-radius: 0;
                margin-bottom: 5px;
            }

            h3 {
                margin: 5px 0;
            }

            img.center {
                display: block;
                margin: 0 auto;
            }

            @media print {
                .no-print {
                    display: none;
                }

                #wrapper {
                    max-width: 700px;
                    width: 100%;
                    min-width: 700px;
                    margin: 0 auto;
                }
            }
            .declaration{
                font-size:11px;
            }
            .text-righta{
                text-align:right;
                padding-left:40px
            }
        </style>
    </head>

    <body>
        <?php //} ?>
        <div id="wrapper">
            <div id="receiptData">
                <div class="no-print">
                    <?php if ($message) { ?>
                        <div class="alert alert-success">
                            <button data-dismiss="alert" class="close" type="button">×</button>
                            <?= is_array($message) ? print_r($message, true) : $message; ?>
                        </div>
                    <?php } ?>
                </div>
                <div id="receipt-data">
                    <div class="text-center" style="height:30px;">
                        <img src="<?= base_url() . 'assets/uploads/logos/' . $biller->logo; ?>" 
                             alt="<?= $biller->company; ?>" style="height:20px;">
                    </div>
                    <div class="text-right">
                        <?php
                        //echo "<pre>";print_r($biller);
                        if ($pos_settings->cf_title1 != "" && $pos_settings->cf_value1 != "") {
                            echo $pos_settings->cf_title1 . ": " . $pos_settings->cf_value1 . "<br>";
                        }
                        if ($pos_settings->cf_title2 != "" && $pos_settings->cf_value2 != "") {
                            echo $pos_settings->cf_title2 . ": " . $pos_settings->cf_value2 . "<br>";
                        }
                        ?>
                    </div>

                    <div style="clear:both;"></div>
                    <!--  <div class="row" style="width:auto !important;margin:0px;">
                          <div class="col-sm-12 text-center">
                              <h5 style="font-weight:bold;"><?= lang('tax_invoice'); ?></h5>
                          </div>
                      </div> -->

                    <div class="row" style="width:auto !important;margin:0px;">
                        <table width="100%" >
                            <tr class="border-bottom">
                                <td colspan="2" align="center" style="border:1px solid #DDDDDD;" height="40"><h5 style="font-weight:bold;"><?= $rows[0]->sale_status == 'foc' ? lang('delivery_challan') : lang('tax_invoice'); ?></h5></td>

                            </tr>
                            <tr>
                                <td height="100" style="font-size: 10px;border-bottom:1px solid #DDDDDD;border-left:1px solid #DDDDDD;padding:5px;" width="50%">
                                    <div style="padding:10px 10px 10px 10px"> 
                                        <p><strong style="font-weight: bold;!important"><?= lang("store_name") . ':'; ?></strong>    <?php echo $biller->company; ?>&nbsp;.</p>
                                        <p style="text-transform: capitalize"><strong style="font-weight: bold;!important"><?= lang("store_address") . ':'; ?></strong>    <?php echo $biller->address . "&nbsp;" . strtolower($biller->city) . "-&nbsp;" . $biller->postal_code . ",&nbsp;" . strtolower($biller->state) ?></p>

                                        <p><strong style="font-weight: bold;!important"><?= lang("pan_no") . ':'; ?></strong>    <?php echo $biller->tin_no ?></p>
                                        <p><strong style="font-weight: bold;!important"><?= lang("gstin_no") . ':'; ?></strong>    <?php echo $biller->vat_no ?></p>

                                    </div>
                                </td>
                                <td valign="top" style="font-size: 10px;border-bottom:1px solid #DDDDDD;padding:5px;border-right:1px solid #DDDDDD;border-left:1px solid #DDDDDD;"> 
                                    <div style="padding:10px 10px 10px 10px;padding-top:0px;"> 
                                        <?php
                                        echo "<p><strong style='font-weight: bold;!important'>" . lang("date") . ":</strong> " . date('d-m-Y', strtotime($inv->date)) . "</p>";
                                        echo "<p><strong style='font-weight: bold;!important'>" . lang("invoice_number") . ":</strong> " . $inv->reference_no . "</p>";

                                        echo "<p><strong style='font-weight: bold;!important'>" . lang("sales_exe") . ":</strong> " . ucwords($inv->username) . "</p>";
                                        ?>
                                        <p><strong style='font-weight: bold;!important'><?= lang("supply_place") . ':'; ?></strong>    <?php echo ucwords(strtolower($biller->state)) ?></p>
                                        <p><strong style='font-weight: bold;!important'><?= lang("state_code") . ':'; ?></strong>    <?php echo $biller->state_id ?></p>
                                    </div>
                                </td>
                            </tr>
                            <tr >
                                <td colspan="2" style="padding: 10px 10px 10px 10px;border-left:1px solid #DDDDDD;border-bottom: 1px solid #DDDDDD!important;border-right:1px solid #DDDDDD;">
                                    <table width="100%">

                                        <tr>
                                            <td width="10%"> &nbsp;</td>
                                            <td valign="top"  width="45%">
                                                <div style="float: left;font-size: 10px;"><strong style='font-weight: bold;!important'><?= lang("customer_name"); ?></strong> : <?php echo $inv->customer; ?></div>
                                            </td>
                                            <td style="" width="45%">   
                                                <div style="font-size: 10px;float:right"><strong style='font-weight: bold;!important'><?= lang("customer_contact"); ?></strong> : <?php echo ($inv->sale_status === 'foc') ? $foc_details->mobile : $customer->phone; ?></div>
                                            </td>

                                        </tr>
                                    </table></td>

                            </tr>

                            <tr>
                                <td colspan="2" >
                                    <table class="table table-condensed table-responsive" style="font-size:9px !important;">
                                        <thead>
                                            <tr>
                                                <th rowspan="2" class='text-left' style="padding-left: 3px!important;border-left: 1px solid #DDDDDD;border-right: 1px solid #DDDDDD;border-bottom: 1px solid #DDDDDD; width:2%;">No.</th>
                                                <th rowspan="2" class='text-left' style="padding-left: 3px!important;border-right: 1px solid #DDDDDD;border-bottom: 1px solid #DDDDDD; width:10%;">Reference</th>
                                                <th rowspan="2" rowspan="2" class='text-left' style="padding-left: 3px!important;border-right: 1px solid #DDDDDD;border-bottom: 1px solid #DDDDDD;width:23%;">Description</th>
                                                <th rowspan="2" class='text-left' style="padding-left: 3px!important;border-right: 1px solid #DDDDDD;border-bottom: 1px solid #DDDDDD;width:5%;">HSN Code</th>
                                                <th rowspan="2" class='text-left' style="padding-left: 3px!important;border-right: 1px solid #DDDDDD;border-bottom: 1px solid #DDDDDD; width:10%;"><?= lang("mrp"); ?><span class="rupee">&#8377;</span></th>
                                                <?php if ($rows[0]->sale_status != 'foc') {
                                                    ?>
                                                    <th rowspan="2" class='text-left' style="padding-left: 3px!important;border-right: 1px solid #DDDDDD;border-bottom: 1px solid #DDDDDD;" width="5%">Discount&#8377;</th>
                                                    <?php
                                                }
                                                ?>
                                                <th rowspan="2" class='text-left' style="padding-left: 3px!important; border-right: 1px solid #DDDDDD;border-bottom: 1px solid #DDDDDD;width:3%;"><?= lang("qty"); ?></th>
                                                <th rowspan="2" class='text-left' style="padding-left: 3px!important;border-right: 1px solid #DDDDDD;border-bottom: 1px solid #DDDDDD; width:5%;"><?= lang("price") . '&#8377;'; ?></th>
                                                <th class='text-left'  style="padding-left: 3px!important;border-right: 1px solid #DDDDDD;border-bottom: 1px solid #DDDDDD;height:20px; width:15%" ><?= lang("cgst"); ?></th>
                                                <th class='text-left' style="padding-left: 3px!important;border-right: 1px solid #DDDDDD;border-bottom: 1px solid #DDDDDD;height:20px; width:15%" ><?= lang("sgst"); ?></th>
                                                <th rowspan="2" class='text-left' style="padding-left: 3px!important;border-bottom: 1px solid #DDDDDD;border-right: 1px solid #DDDDDD; width:8%; text-align: center;"><?= lang("total") . '&#8377;'; ?></th>
                                            </tr>
                                            <tr >
                                                <td style="border-right: 1px solid #DDDDDD;border-bottom: 1px solid #DDDDDD;padding: 0px !important">
                                                    <table width="100%" style="height: 34px;" >
                                                        <tr>
                                                            <td style="border-right: 1px solid #DDDDDD;white-space: nowrap !important;height:20px;padding: 0px 1px 0px 1px;" width="30px">
                                                                <div style="padding:9px;"><?= lang("rate") . '%'; ?> </div>
                                                                <!--div style="padding:9px;"><?php echo "%"; ?></div-->
                                                            </td>
                                                            <!--<td> --> 
                                                            <td style="height:20px;padding-left: 3px!important;" width="70%">
                                                                <div style="padding:9px;"><?= lang("amt") . '&#8377;'; ?></div>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td style="border-right: 1px solid #DDDDDD;border-bottom: 1px solid #DDDDDD;padding: 0px !important">
                                                    <table width="100%" style="height: 34px;" >
                                                        <tr>
                                                            <td style="border-right: 1px solid #DDDDDD;white-space: nowrap !important;height:20px;padding: 0px 1px 0px 1px;" width="30px">
                                                                <div style="padding:9px;"><?= lang("rate") . '%'; ?> </div>
                                                                  <!--div style="padding:9px;"><?php echo "%"; ?></div-->
                                                            </td>
                                                            <!--<td> -->
                                                            <td style="height:20px;padding-left: 3px!important;" width="70%">
                                                                <div style="padding:9px;"><?= lang("amt") . '&#8377;'; ?></div>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>

                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php
                                            //echo "<pre>";print_r($rows);exit;
                                            $r = 1;
                                            $tax_summary = array();
                                            $total_discounted_amount = 0;
                                            $total_net_amt = 0;
                                            $total_amt = 0;
                                            $total_items = 0;
                                            $total_discount = 0;
                                            $total_tax = 0;
                                            $total_order_tax = 0;
                                            $prod_total_amount = 0;
                                            $total_mrp = 0;
                                            $tax_array = array();
                                            foreach ($rows as $row) {
                                                /*    echo "<pre>";
                                                  print_r($row);
                                                  exit; */
                                                $tax_value[$row->tax_rate] += $row->item_tax / 2;
                                                // if(in_array($row->tax_rate, $tax_array)){
                                                // }else{
                                                //     array_push($tax_array,$row->tax_rate);
                                                // }
                                                $total_discounted_amount += ($row->quantity * $row->net_unit_price);
                                                if ($row->pdiscount_type === 'foc') {
                                                    $total_net_amt += ($row->unit_price * 0) - $row->item_discount;
                                                } else {
                                                    $total_net_amt += ($row->quantity * $row->net_unit_price) - $row->item_discount;
                                                }

                                                $total_amt += $row->net_unit_price;
                                                $total_items +=$row->quantity;
                                                $total_discount+= $row->item_discount;
                                                $total_tax += $row->item_tax;
                                                $total_mrp += $row->subtotal;

                                                $tax_summary[$row->tax_code]['items'] = $row->quantity;
                                                $tax_summary[$row->tax_code]['tax'] = $row->item_tax;
                                                $tax_summary[$row->tax_code]['amt'] = ($row->quantity * $row->net_unit_price) - $row->item_discount;
                                                $tax_summary[$row->tax_code]['name'] = $row->tax_name;

                                                $tax_summary[$row->tax_code]['code'] = $row->tax_code;
                                                $tax_summary[$row->tax_code]['rate'] = $row->tax_rate;

                                                /* Updated By Chitra to calculate total tax of the inline items added. */
                                                //echo "<pre>";print_r($tax_summary);
                                                if ($pos->order_discount_type == 'percent') {
                                                    if ($row->pdiscount_type === 'foc') {
                                                        $disc = $row->unit_price;
                                                    } else {
                                                        $disc = ($row->real_unit_price * $row->discount) / 100;
                                                    }
                                                } else {
                                                    $disc = $row->item_discount;
                                                }

                                                if ($row->pdiscount_type === 'foc') {
                                                    $prod_amount = $this->sma->formatMoney($row->unit_price);
                                                } else {
                                                    $prod_amount = $this->sma->formatMoney($row->net_unit_cost + $row->item_tax);
                                                }

                                                if ($row->pdiscount_type === 'foc') {
                                                    $prod_total_amount+= $row->unit_price;
                                                } else {
                                                    $prod_total_amount+= $row->net_unit_cost + $row->item_tax;
                                                }
                                                $prod_tax_rate = $this->sma->formatMoney($tax_summary[$row->tax_code]['rate']);
                                                $prod_price = $tax_summary[$row->tax_code]['amt'];
                                                $total_order_tax +=($tax_summary[$row->tax_code]['tax']);
                                                $prod_tax = ($prod_price * $prod_tax_rate) / ((100) + ($prod_tax_rate));
                                                $booking_status = !empty($row->advance_booking) ? '(Advance Booking)' : '';
                                                $row->product_hsn = ($row->product_hsn === null) || ($row->product_hsn === 'undefined') ? '' : $row->product_hsn;
                                                $total_basic_price += $row->pdiscount_type == 'foc' ? 0 : $row->net_unit_cost;
                                                $total_item_tax += ($row->item_tax / 2);

                                                if ($row->return_id != 0) {
                                                    echo '<tr>'
                                                    . '<td class="text-left border-right" style="padding-left: 3px!important; padding-top: 3px!important; padding-bottom: 3px!important;border-left: 1px solid #DDDDDD;border-right: 1px solid #DDDDDD;border-bottom: 1px solid #DDDDDD;">' . $r . '</td>'
                                                    . '<td class="text-left border-right" style="padding-left: 3px!important; padding-top: 3px!important; padding-bottom: 3px!important;border-right: 1px solid #DDDDDD;border-bottom: 1px solid #DDDDDD;">' . ($row->product_code) . ($row->variant ? ' (' . $row->variant . ')' : '') . '</td>'
                                                    . '<td class="text-left border-right" style="padding-left: 3px!important; padding-top: 3px!important; padding-bottom: 3px!important;border-right: 1px solid #DDDDDD;border-bottom: 1px solid #DDDDDD;">' . $row->product_name . '</td>'
                                                    . '<td class="text-left border-right"  style="padding-left: 3px!important; padding-top: 3px!important; padding-bottom: 3px!important;border-right: 1px solid #DDDDDD;border-bottom: 1px solid #DDDDDD;">' . $row->hsn_code . '</td>'
                                                    . '<td class="text-left border-right"  style="padding-left: 3px!important; padding-top: 3px!important; padding-bottom: 3px!important;border-right: 1px solid #DDDDDD;border-bottom: 1px solid #DDDDDD;">' . $this->sma->formatMoney($row->real_unit_price) . '</td>';
                                                    if ($row->sale_status != 'foc') {
                                                        echo
                                                        '<td class="text-left border-right"  style="padding-left: 3px!important; padding-top: 3px!important; padding-bottom: 3px!important;border-right: 1px solid #DDDDDD;border-bottom: 1px solid #DDDDDD;">' . $this->sma->formatMoney($disc) . '</td>';
                                                    }
                                                    echo '<td class="text-left border-right"  style="padding-left: 3px!important; padding-top: 3px!important; padding-bottom: 3px!important;border-right: 1px solid #DDDDDD;border-bottom: 1px solid #DDDDDD;">' . round($row->quantity) . '</td>'
                                                    . '<td class="text-left"  style="padding-left: 3px!important; padding-top: 3px!important; padding-bottom: 3px!important;border-right: 1px solid #DDDDDD;border-bottom: 1px solid #DDDDDD;">' . ($row->sale_status != 'foc' ? $this->sma->formatMoney($row->net_unit_cost) : 0) . '</td>'
                                                    . '<td class="text-left border-right" style="padding-left: 3px!important; padding-top: 3px!important; padding-bottom: 3px!important;padding:0px !important;border-right: 1px solid #DDDDDD;border-bottom: 1px solid #DDDDDD;">
<table width="100%" height="52px">
    <tr>
    <td nowrap valign="top" class="border-right" width="30px" style="text-align:left; border-right: 1px solid #DDDDDD; padding-left:6px!important;">' . ($row->tax_rate / 2) . ''
    . '</td>'
    . '<td nowrap valign="top" width="100px" class="text-left" style="text-align:left;padding-left:6px!important; ">' . $this->sma->formatMoney($row->item_tax / 2) . '</td></tr>
</table>
                                            </td>'
                                                    . '<td class="text-left border-right" style="padding:0px !important;border-right: 1px solid #DDDDDD;border-bottom: 1px solid #DDDDDD;">
<table width="100%" height="52px">
    <tr>
    <td valign="" class="border-right" width="30px" style="text-align:left; border-right: 1px solid #DDDDDD;padding-left:6px;white-space:nowrap !important">' . ($row->tax_rate / 2) . '</td>'
                                                    . '<td valign="" class="text-left" style="text-align:left;padding-left:6px; white-space:nowrap !important">' . $this->sma->formatMoney($row->item_tax / 2) . '</td></tr>
</table>
                                                    </td>'

                                                    //                        . '<td class="text-left">' . $prod_amount . '</td>'
                                                    . '<td class="" style="padding-left: 3px!important; padding-top: 3px!important; padding-bottom: 3px!important;text-align:left;border-right: 1px solid #DDDDDD;border-bottom: 1px solid #DDDDDD;text-align:right; padding-right:20px;">' . $this->sma->formatMoney($row->pdiscount_type == 'foc' ? 0 : $row->real_unit_price - $row->item_discount) . '</td>'
                                                    . '</tr>';
                                                } else {
                                                    echo '<tr>'
                                                    . '<td class="text-left border-right" style="padding-left: 3px!important; padding-top: 3px!important; padding-bottom: 3px!important;border-left: 1px solid #DDDDDD;border-right: 1px solid #DDDDDD;border-bottom: 1px solid #DDDDDD;" >' . $r . '</td>'
                                                    . '<td class="text-left border-right" style="padding-left: 3px!important; padding-top: 3px!important; padding-bottom: 3px!important;border-right: 1px solid #DDDDDD;border-bottom: 1px solid #DDDDDD;">' . ($row->product_code) . ($row->variant ? ' (' . $row->variant . ')' : '') . '</td>'
                                                    . '<td class="text-left border-right" style="padding-left: 3px!important; padding-top: 3px!important; padding-bottom: 3px!important;border-right: 1px solid #DDDDDD;border-bottom: 1px solid #DDDDDD;">' . $row->product_name . '</td>'
                                                    . '<td class="text-left border-right" style="padding-left: 3px!important; padding-top: 3px!important; padding-bottom: 3px!important;border-right: 1px solid #DDDDDD;border-bottom: 1px solid #DDDDDD;">' . $row->hsn_code . '</td>'
                                                    . '<td class="text-left border-right"  style="padding-left: 3px!important; padding-top: 3px!important; padding-bottom: 3px!important;border-right: 1px solid #DDDDDD;border-bottom: 1px solid #DDDDDD;">' . $this->sma->formatMoney($row->real_unit_price) . '</td>';
                                                    if ($row->sale_status != 'foc') {
                                                        echo '<td class="text-left border-right" style="padding-left: 3px!important; padding-top: 3px!important; padding-bottom: 3px!important;border-right: 1px solid #DDDDDD;border-bottom: 1px solid #DDDDDD;">' . $this->sma->formatMoney($disc) . '</td>';
                                                    }
                                                    echo '<td class="text-left border-right" style="padding-left: 3px!important; padding-top: 3px!important; padding-bottom: 3px!important;border-right: 1px solid #DDDDDD;border-bottom: 1px solid #DDDDDD;">' . round($row->quantity) . '</td>'
                                                    . '<td class="text-left border-right" style="padding-left: 3px!important; padding-top: 3px!important; padding-bottom: 3px!important;border-right: 1px solid #DDDDDD;border-bottom: 1px solid #DDDDDD;">' . ($row->sale_status != 'foc' ? $this->sma->formatMoney($row->net_unit_cost) : 0) . '</td>'
                                                    . '<td class="text-left border-right" style="padding-left: 3px!important; padding-top: 3px!important; padding-bottom: 3px!important;padding:0px !important; margin:0px !important; border-right: 1px solid #DDDDDD;border-bottom: 1px solid #DDDDDD; ">
<table width="100%" height="" style="margin:0px; padding:0px; border:1px;">
    <tr>
    <td nowrap valign="top" class="border-right" width="30px" style="text-align:left; border-right: 1px solid #DDDDDD;padding-left:6px;">' . ($row->tax_rate / 2) . '</td>'
                                                    . '<td nowrap valign="top" class="text-left" style="text-align:left;padding-left:6px;">' . $this->sma->formatMoney($row->item_tax / 2) . '</td></tr>
</table>
                                                    </td>'
                                                    . '<td  class="" style="padding:0px !important; margin:0px !important;border-right: 1px solid #DDDDDD;border-bottom: 1px solid #DDDDDD;">
<table width="100%" height="" style="margin:0px; padding:0px; border:1px;" >
        <tr>
        <td valign="top" class="border-right" width="30px" style="text-align:left; border-right: 1px solid #DDDDDD;padding-left:6px; white-space:nowrap !important">' . ($row->tax_rate / 2) . '</td>'
                                                    . '<td valign="top" class="text-left" style="text-align:left;padding-left:6px; white-space:nowrap !important;">' . $this->sma->formatMoney($row->item_tax / 2) . '</td></tr>
</table>
                                            </td>'

                                                    //                        . '<td class="text-left">' . $prod_amount . '</td>'
                                                    . '<td valign="" class="" style="padding-left: 3px!important; padding-top: 3px!important; padding-bottom: 3px!important;text-align:left;border-right: 1px solid #DDDDDD;border-bottom: 1px solid #DDDDDD; text-align:right; padding-right:10px;">' . $this->sma->formatMoney($row->pdiscount_type == 'foc' ? 0 : $row->real_unit_price - $row->item_discount) . '</td>'
                                                    . '</tr>';
                                                }
                                                //echo '</td><td>'.$this->sma->formatMoney($row->item_discount).'</td><td>'.$this->sma->formatMoney($row->tax).'</td><td>'.$this->sma->formatMoney($row->item_tax).'</td><td>'.intval($row->quantity).'</td><td class="text-left">' . $this->sma->formatMoney($row->unit_price + $row->item_discount) . '</td></tr>';

                                                $r++;
                                            }
                                            ?>
                                            <tr>
                                                <td colspan="11" height="50px;" style="border:1px solid #DDDDDD">&nbsp;</td></tr>
                                            <tr >
                                                <td colspan="4" class="text-left" style="border-left:1px solid #DDDDDD" ></td>
                                                <td class="text-left" height="30px"  style="padding-left:6px!important;"><?= lang("total") . '<b>&#8377;</b>'; ?>&nbsp;<!-- <span class="rupee">&#8377;</span> --></td>
                                                <?php if ($rows[0]->sale_status != 'foc'): ?>
                                                    <td colspan="" class="text-left" style="padding-left:6px!important;"><?= $this->sma->formatMoney($total_discount) ?></td>
                                                <?php endif; ?>   
                                                <td  style="padding-left:6px!important;"><?php echo intval($total_items) ?></td>
                                                <td class='text-left ' style="padding-left:6px!important;" ><?= $row->sale_status != 'foc' ? $this->sma->formatMoney($total_basic_price) : 0; ?></td>

                                                <td>
                                                    <table  width="100%">
                                                        <tr>
                                                            <td width="30%">&nbsp;</td>
                                                            <td class="text-left" style="padding-left:6px!important;"><?= $this->sma->formatMoney($total_item_tax) ?>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>

                                                <td><table width="100%">
                                                        <tr>
                                                            <td width="30%">&nbsp;</td>
                                                            <td class="text-left" style="padding-left:6px!important;"><?= $this->sma->formatMoney($total_item_tax) ?>
                                                            </td>
                                                        </tr>
                                                    </table></td>
                                                <td class='text-left border-right' style="padding-left:6px!important;border-right:1px solid #DDDDDD; text-align: right; padding-right: 10px;"><?php echo $this->sma->formatMoney(round($total_mrp)) ?></td>
                                                <!--<th class="text-right"><?= $this->sma->formatMoney($inv->total + $inv->product_tax) ?></th>-->
                                            </tr>
                                             <tr>
                                                <td colspan="11" height="1px;" style="border-left:1px solid #DDDDDD; border-right:1px solid #DDDDDD">&nbsp;</td></tr>
                                            <tr>
                                                <td colspan="11">
                                                    <table width="100%"  >
                                                        <tr>
                                                            <td width="50%"  style="border-left:1px solid #DDDDDD;border-right:1px solid #DDDDDD;border-top:1px solid #DDDDDD;border-bottom:1px solid #DDDDDD; padding-top: 6px!important;">

                                                                <?php
//echo "<pre>";print_r($payments);exit;
                                                                if ($payments) {
                                                                    echo '<table class="table table-condensed" style="border:none !important;width:100%"><tbody>';
                                                                    echo '<tr>'
                                                                    . '<td style="border:none !important;padding-left:6px!important; font-weight:bold; width:80%">Payment Mode</td>'
                                                                    . '<td style="border:none !important; font-weight:bold; width:20%; ">Amount <span class="rupee">&#8377;</span></td>'
                                                                    . '</tr>';
                                                                    foreach ($payments as $payment) {
                                                                        if ($payment->pos_paid > 0) {
                                                                            echo '<tr>';
                                                                            if ($payment->paid_by == 'cash' && $payment->pos_paid) {
                                                                                //  echo '<td style="display:none;"></td>';
                                                                                echo '<td colspan="1" style="border:none !important;padding-left:6px!important;">' . lang($payment->paid_by) . '</td>';
                                                                                echo '<td style="border:none !important;padding-left:6px!important;">' . $this->sma->formatMoney($payment->pos_paid == 0 ? $payment->amount : $payment->pos_paid) . ($payment->return_id ? ' (' . lang('returned') . ')' : '') . '</td>';
                                                                                //echo '<td>' . lang("change") . ': ' . ($payment->pos_balance > 0 ? $this->sma->formatMoney($payment->pos_balance) : 0) . '</td>';
                                                                            }
                                                                            if (($payment->paid_by == 'CC' || $payment->paid_by == 'ppp' || $payment->paid_by == 'stripe') && $payment->cc_no) {
                                                                                /*  echo '<td style="display:none;"></td>'; */
                                                                                echo '<td style="border:none !important;padding-left:6px!important;">';
                                                                                echo '<span class="right-space">' . $payment->cc_type . '&nbsp;&nbsp;&nbsp;' . lang($payment->card_type) . ' &nbsp;&nbsp;&nbsp;' . substr($payment->cc_no, 0, 4) . '-XXXX-XXXX-' . substr($payment->cc_no, -4) . '</span></td>';
                                                                                echo '<td style="border:none !important;padding-left:6px!important;"><span class="right-space rupee">' . $this->sma->formatMoney($payment->pos_paid) . ($payment->return_id ? ' (' . lang('returned') . ')' : '') . '</span></td>';
                                                                                /*  echo '<td colspan="2"><span class="right-space">' . lang("no") . ': ' .substr($payment->cc_no, 0, 4). '-xx-' . substr($payment->cc_no, -4) .'</span></td>';
                                                                                  echo '<td><span class="right-space">' . lang("expiry") . ': ' .$payment->cc_month.'/'.$payment->cc_year.'</span></td>'; */
                                                                                //echo '<td>' . lang("name") . ': ' . $payment->cc_holder . '</td>';
                                                                            }
                                                                            if ($payment->paid_by == 'Cheque' && $payment->cheque_no) {
                                                                                //echo '<td style="display:none;"></td>';
                                                                                echo '<td style="border:none !important;padding-left:6px!important;" >' . lang($payment->paid_by) . '&nbsp;&nbsp;&nbsp; ' . $payment->cheque_no . '</td>';
                                                                                echo '<td style="border:none !important;padding-left:6px!important;">' . $this->sma->formatMoney($payment->pos_paid) . ($payment->return_id ? ' (' . lang('returned') . ')' : '') . '</td>';
                                                                                //echo '<td>' . lang("cheque_no") . ': ' . $payment->cheque_no . '</td>';
                                                                            }
                                                                            if ($payment->paid_by == 'credit_voucher' && $payment->pos_paid) {
                                                                                //echo "<pre>";print_r($payment);die;
                                                                                // echo '<td style="display:none;"></td>';
                                                                                echo '<td style="border:none !important;padding-left:6px!important;">' . lang($payment->paid_by) . '&nbsp;&nbsp;&nbsp; ' . $payment->cc_no . '</td>';
                                                                                //echo '<td style="border:none !important;" ></td>';
                                                                                echo '<td style="padding-left:6px!important;">' . /* lang("amount") . ': <span class="rupee">&#8377;</span> ' . */ $this->sma->formatMoney($payment->pos_paid) . ($payment->return_id ? ' (' . lang('returned') . ')' : '') . '</td>';
                                                                                /* echo '<td>' . lang("credit_note_balance") . ': ' . ($payment->cn_balance > 0 ? $this->sma->formatMoney($payment->cn_balance) : 0) . '</td>'; */
                                                                            }
                                                                            if ($payment->paid_by == 'other' && $payment->amount) {
                                                                                //  echo '<td style="display:none;"></td>';
                                                                                echo '<td style="border:none !important;padding-left:6px!important;" >' . lang($payment->paid_by) . '&nbsp;&nbsp;&nbsp; ' . $payment->note . '</td>';
                                                                                echo '<td style="padding-left:6px!important;">' . $this->sma->formatMoney($payment->pos_paid == 0 ? $payment->amount : $payment->pos_paid) . ($payment->return_id ? ' (' . lang('returned') . ')' : '') . '</td>';
                                                                                // echo $payment->note ? '</tr><td colspan="2">' . lang("payment_note") . ': ' . $payment->note . '</td>' : '';
                                                                            }
                                                                            echo '</tr>';
                                                                        }
                                                                    }
                                                                    echo '</tbody></table>';
                                                                }
                                                                ?>
                                                            </td>

                                                            <td width="20%"  colspan="2" style="padding-left: 10px!important;border-top:1px solid #DDDDDD;border-bottom:1px solid #DDDDDD;padding-top: 6px!important;padding-bottom: 6px!important; vertical-align: top; text-align: right;">
                                                                <?= lang("taxable_amount") . '<b>&#8377;</b>'; ?><br/>
                                                                <?= lang("sgst"); ?>@<?php echo round(key($tax_value) / 2) ?> %<br/>
                                                                <?= lang("cgst"); ?>@<?php echo round(key($tax_value) / 2) ?> %<br/>
                                                                <?= lang("total_amount") . '<b>&#8377;</b>'; ?>
                                                            </td>

                                                            <td width="20%"  style="padding-right: 10px!important;border-right:1px solid #DDDDDD;border-top:1px solid #DDDDDD;border-bottom:1px solid #DDDDDD;padding-top: 6px!important;padding-bottom: 6px!important; text-align: right; vertical-align: top; ">
                                                                <?= $this->sma->formatMoney($total_basic_price) ?><br/>
                                                                <?= $this->sma->formatMoney($tax_value[key($tax_value)]) ?><br/>
                                                                <?= $this->sma->formatMoney($tax_value[key($tax_value)]) ?><br/>
                                                                <?php echo $this->sma->formatMoney(round($total_mrp)) ?>
                                                            </td>
                                                            <!--td colspan="5" style="border-left:1px solid #DDDDDD;border-right:1px solid #DDDDDD;" >
                                                                <div style="width:100% !important; float:left;">
                                                                    <div style="width:50% !important; float:left; min-height: 50px;">&nbsp;</div>
                                                                    <div style="width:50%!important; float:left;">  
                                                                       
                                                                        <div style="height:15px; width: 100%; float: left;"><span style="width:50%; float: left;"><?= lang("taxable_amount") . '<b>&#8377;</b>'; ?></span>  <span style="width:50%; float: left; text-align: right; padding-right: 10px;"><?= $this->sma->formatMoney($total_basic_price) ?></span></div>
                                                            <?php foreach ($tax_value as $keys => $rows) {
                                                                ?>
                                                                                <div style="height:15px; width: 100%; float: left;"><span style="width:50%; float: left;"><?= lang("sgst"); ?>@ <?php echo round($keys / 2) ?> %</span> <span style="width:50%; float: left; text-align: right; padding-right: 10px;"><?php echo $this->sma->formatMoney($rows) ?></span></div>
                                                                                <div style="height:15px; width: 100%; float: left;"><span style="width:50%; float: left;"><?= lang("cgst"); ?>@ <?php echo round($keys / 2) ?> % </span> <span style="width:50%; float: left; text-align: right; padding-right: 10px;"><?php echo $this->sma->formatMoney($rows) ?></span></div>
                
                                                                <?php
                                                            }
                                                            ?>
                                                                    <div style="height:10px;">
                                                                        <span style="width:50%; float: left;"><?= lang("total_amount") . '<b>&#8377;</b>'; ?></span> <span style="width:50%; float: left; text-align: right; padding-right: 20px;"><?php echo $this->sma->formatMoney(round($total_mrp)) ?></span></div>
                                                                    <div>&nbsp;</div>
            
                                                               
                                                               </div>
                                                                        
                                                                </div-->
                                                              <!--  <table style="width: 1400px;border:2px solid #000000;">
                                                                    <tbody>
                                                                    <tr>
                                                                        <td><span><?= lang("taxable_amount"); ?></span></td><td><?= $this->sma->formatMoney($total_basic_price) ?></td>
                                                                    </tr>
                                                            <?php foreach ($tax_value as $keys => $rows) {
                                                                ?>
                                                                                        <tr>
                                                                                            <td><?= lang("sgst"); ?>@ <?php echo round($keys / 2) ?> %</td><td><?php echo $this->sma->formatMoney($rows) ?></td>
                                                                                        </tr>
                                                                                        <tr>
                                                                                            <td><?= lang("cgst"); ?>@ <?php echo round($keys / 2) ?> % </td><td><?php echo $this->sma->formatMoney($rows) ?></td>
                                                                                        </tr>
                                                                <?php
                                                            }
                                                            ?>
                                                                    <tr>
                                                                        <td><?= lang("total_amount"); ?></td><td><?php echo $this->sma->formatMoney(round($total_mrp)) ?></td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table> -->
                                                            <!--/td-->
                                                        </tr>
                                                    </table>


                                                </td>
                                            </tr>
                                            <?php
//echo "<pre>";print_r($inv);
                                            if ($inv->grand_total === 0.00) {
                                                $inv->grand_total = intval($inv->grand_total);
                                            }
                                            /* if ($inv->order_tax != 0) {
                                              echo '<tr><th colspan="4" class="text-left">' . lang("order_tax") . '</th>'
                                              . '<th class="text-right">' . $this->sma->formatMoney($inv->order_tax) . '</th></tr>';
                                              }
                                              if ($inv->order_discount != 0) {
                                              echo '<tr><th colspan="4" class="text-left">' . lang("order_discount") . '</th>'
                                              . '<th class="text-right">'.$this->sma->formatMoney($inv->order_discount) . '</th></tr>';
                                              } */

                                            if ($pos_settings->rounding) {
                                                $round_total = $this->sma->roundNumber($inv->grand_total, $pos_settings->rounding);
                                                $rounding = $this->sma->formatMoney($round_total - $inv->grand_total);
                                                ?>
                                                                <!-- <tr>
                                                                    <th colspan="4"><?= lang("rounding"); ?></th>
                                                                    <th class="text-right"><?= $rounding; ?></th>
                                                                </tr>
                                                                <tr>
                                                                    <th colspan="6" class="text-left"><?= lang("net_amount"); ?></th>
                                                                    <th colspan="5" class="text-left"><?php $this->sma->formatMoney($inv->grand_total + $rounding); ?></th>
                                                                </tr> -->

                                                <?php if ($inv->grand_total > 0) { ?>
                                                    <tr>
                                                        <th colspan="11" class="text-left"><?= lang("amount_chargeable_words"); ?></th>
                                                    </tr>
                                                    <tr>
                                                        <th colspan="11" class="text-left"><?php echo $this->pos_model->convert_numbers_to_words($inv->grand_total + $rounding) ?></th>
                                                    </tr>
                                                <?php } ?>
                                            <?php } else { ?>
                               <!--  <tr>
                                    <th colspan="11" class="text-left"><?= lang("net_amount"); ?>&nbsp;<span class="rupee">&#8377;</span></th>   
                                                <?php if ($inv->grand_total === 0) { ?>
                                                            <th colspan="11" class="text-left"></th>
                                                <?php } else { ?>
                                                                <th colspan="11" class="text-right"><?php echo $this->sma->formatMoney(round($inv->grand_total, 0)); ?></th>
                                                <?php } ?>

                                </tr> -->
                                                <?php if ($inv->grand_total > 0) { ?>
                                                    <tr style="">
                                                        <th colspan="11" height="30px" class="text-left" style="font-size: 13px;border-left:1px solid #DDDDDD;border-right:1px solid #DDDDDD;border-bottom:1px solid #DDDDDD;padding-left: 3px!important;"><span><?= lang("amount_chargeable_words") . ':'; ?> </span>  
                                                            <?php
                                                            if ($inv->grand_total > 0) {
                                                                echo ucwords($this->pos_model->convert_numbers_to_words($inv->grand_total));
                                                            } else {
                                                                echo "";
                                                            }
                                                            ?>
                                                        </th>
                                                    </tr>
                                                <?php } ?>
    <!--                        <th class="text-left" colspan="11"><?= $this->sma->formatMoney($inv->grand_total + $rounding) ?></th>-->
                                <!-- <tr>
                                    <th class="text-left" colspan="11">
                                                <?php
                                                if ($inv->grand_total > 0) {
                                                    echo ucwords($this->pos_model->convert_numbers_to_words($inv->grand_total));
                                                } else {
                                                    echo "";
                                                }
                                                ?>
                                    </th>
                                </tr> -->
                                                <?php if ($inv->paid < round($inv->grand_total)) { ?>
                                                    <tr style="width:100%;">
                                                        <td colspan="11" style="border-left:1px solid #DDDDDD; border-right:1px solid #DDDDDD; border-bottom:1px solid #DDDDDD;padding-left: 3px!important; padding-top: 3px!important; padding-bottom: 3px!important;">
                                                            <table style="width:100%">
                                                                <tr>
                                                                    <th style="width:70%"><?= lang("paid_amount"); ?></th>                    
                                                                    <th class=""  style="width:30%; text-align: right; padding-right: 10px;"><?= $this->sma->formatMoney($inv->paid); ?></th>
                                                                </tr>
                                                                <tr>
                                                                    <th  style="width:70%"><?= lang("due_amount"); ?></th>
                                                                    <th class="text-left" style="width:30%; text-align: right; padding-right: 10px;"><?= $this->sma->formatMoney($inv->grand_total - $inv->paid); ?></th>
                                                                </tr>

                                                            </table>
                                                        </td>
                                                    </tr>

                                                <?php } ?>

                                            <?php }
                                            ?>
                                        </tbody>
                                        <tfoot>                               
                                            

                                            <tr>
                                                <th colspan="11" style="border-right:1px solid #DDDDDD;border-bottom:1px solid #DDDDDD;border-left:1px solid #DDDDDD;padding-left: 3px!important;">
                                        <p>&nbsp;</p>

                                        <h5 class="" style="font-size: 9px;">Declaration: </h5>
                                        <p class="declaration" style="font-size: 9px;font-weight:normal;">1. We declare that this <?= $inv->sale_status == 'foc' ? 'delivery challan' : 'invoice' ?> shows the actual price of the goods described and that all particulars are true and correct.</p>
                                        <p class="declaration" style="font-size: 9px;font-weight:normal">2. No refund, watches can be exchanged within 30 days from the date of purchase.</p>
                                        <?php if ($inv->sale_status != 'foc') {
                                            ?>
                                            <p class="declaration text-justifysd" style="font-size: 9px;font-weight:normal;">3. Unless otherwise stated, tax on this invoice is not payable under reverse charge.</p>
                                            <?php
                                        }
                                        ?>

                                        <div style="height:30px;width:900px;text-align:right">
                                            <div style="color:white">---------------------------------------------------------------------------------------------------------------------------------------------------------------------- </div>
                                            <img height="50" width="100" align="right" src="<?= base_url() . 'assets/images/Pavan Sign_001.jpg' ?>" />

                                            <div style="color:white">---------------------------------------------------------------------------------------------------------------------------------------------------------------------- <span style="color:#000000">(Authorised Signatory)

                                                </span>


                                            </div>

                                            <div style="color:white">-------------------------------------------------------------------------------------------------------------------------------------------------------------- <span style="color:#000000">Swatch Group (India) Retail Pvt. Ltd. 
                                                </span>

                                                <p>&nbsp;</p>
                                            </div>
                                        </div>
                                        </th>
                            </tr>

                            </tfoot>
                        </table>

                        </td>

                        </tr>
                        </table>          
                    </div>



                   <div class="/*well well-sm*/" style="font-size:9px !important;border: 1px solid #ddd; /*background-color: #f6f6f6;*/">
                        <?php if($inv->note || $inv->staff_note):?>
                       <div style="text-align:left; padding: 5px 10px 5px 10px; border-bottom: solid 1px #dddddd; background: #f6f6f6;"> <?= $inv->note ? '<p class="" >' . $this->sma->decode_html($inv->note) . '</p>' : ''; ?>
                    <?= $inv->staff_note ? '<p class="no-print"><strong>' . lang('staff_note') . ':</strong> ' . $this->sma->decode_html($inv->staff_note) . '</p>' : ''; ?>
                       </div>
                       <?php endif; ?>
                       <h6 class="text-center"><strong><?= $pos_settings->cf_title3 ?></strong></h6>
                        <p class="text-center declaration"><strong>Registered Office: </strong> <?= $pos_settings->cf_value3 ?></p>
                        <p class="text-center declaration"><strong><?= $pos_settings->cf_title4 ?>: </strong><?= $pos_settings->cf_value4 ?></p>
                        <p class="text-center declaration"><strong><?= $pos_settings->cf_title5 ?>: </strong><?= $pos_settings->cf_value5 ?></p>
                        <p class="text-center declaration"><strong><?= $pos_settings->cf_title6 ?>: </strong><?= $pos_settings->cf_value6 ?></p>
                    </div>
                </div>
                <div style="clear:both;"></div>
            </div>
            <?php if ($message) { ?>
                <div class="row">
                    <div class="col-md-12">

                        <div class="alert alert-success">
                            <button data-dismiss="alert" class="close" type="button">×</button>
                            <?= is_array($message) ? print_r($message, true) : $message; ?>
                        </div>

                    </div>
                </div>
            <?php } ?>

            <?php
            if ($modal) {
                echo '</div></div></div></div>';
            } else {
                ?>
                <div id="buttons" style="padding-top:10px; text-transform:uppercase;" class="no-print">
                    <?php if ($pos_settings->java_applet) { ?>
                        <span class="col-xs-12"><a class="btn btn-block btn-primary" onClick="printReceipt()"><?= lang("print"); ?></a></span>
                        <span class="col-xs-12"><a class="btn btn-block btn-info" type="button" onClick="openCashDrawer()">Open Cash
                                Drawer</a></span>
                        <div style="clear:both;"></div>
                    <?php } else { ?>
                        <span class="pull-right col-xs-12">
                            <a href="javascript:window.print()" id="web_print" class="btn btn-block btn-primary"
                               onClick="window.print();
                                               return false;"><?= lang("web_print"); ?></a>
                        </span>
                    <?php } ?>
                    <span class="pull-left col-xs-12"><a class="btn btn-block btn-success" href="<?= site_url('pos/save_invoice_pdf/' . $sid); ?>" ><?= lang("save_as_pdf"); ?></a></span>

                    <span class="col-xs-12">
                        <!--Add logout functionality after payment @ ankit-->
                        <?php if ($pos_settings->logout_after_payment == '1') { ?>
                            <a class="btn btn-block btn-warning" href="<?= site_url('auth/logout'); ?>"><?= lang("back_to_pos"); ?></a>
                        <?php } else { ?>
                            <a id="back_to_pos" class="btn btn-block btn-warning" href="<?= site_url('pos'); ?>"><?= lang("back_to_pos"); ?></a>
                        <?php } ?>
                    </span>
                    <?php if (!$pos_settings->java_applet) { ?>
                        <div style="clear:both;"></div>
                        <div class="col-xs-12" style="background:#F5F5F5; padding:10px;">
                            <p style="font-weight:bold;">Please don't forget to disable the header and footer in browser print
                                settings.</p>

                            <p style="text-transform: capitalize;"><strong>FF:</strong> File &gt; Print Setup &gt; Margin &amp;
                                Header/Footer Make all --blank--</p>

                            <p style="text-transform: capitalize;"><strong>chrome:</strong> Menu &gt; Print &gt; Disable Header/Footer
                                in Option &amp; Set Margins to None</p></div>
                    <?php } ?>
                    <div style="clear:both;"></div>

                </div>

            </div>
            <canvas id="hidden_screenshot" style="display:none;">

            </canvas>
            <div class="canvas_con" style="display:none;"></div>
            <script type="text/javascript" src="<?= $assets ?>pos/js/jquery-1.7.2.min.js"></script>
            <?php
            if ($pos_settings->java_applet) {

                function drawLine() {
                    $size = $pos_settings->char_per_line;
                    $new = '';
                    for ($i = 1; $i < $size; $i++) {
                        $new .= '-';
                    }
                    $new .= ' ';
                    return $new;
                }

                function printLine($str, $sep = ":", $space = NULL) {
                    $size = $space ? $space : $pos_settings->char_per_line;
                    $lenght = strlen($str);
                    list($first, $second) = explode(":", $str, 2);
                    $new = $first . ($sep == ":" ? $sep : '');
                    for ($i = 1; $i < ($size - $lenght); $i++) {
                        $new .= ' ';
                    }
                    $new .= ($sep != ":" ? $sep : '') . $second;
                    return $new;
                }

                function printText($text) {
                    $size = $pos_settings->char_per_line;
                    $new = wordwrap($text, $size, "\\n");
                    return $new;
                }

                function taxLine($name, $code, $qty, $amt, $tax) {
                    return printLine(printLine(printLine(printLine($name . ':' . $code, '', 18) . ':' . $qty, '', 25) . ':' . $amt, '', 35) . ':' . $tax, ' ');
                }
                ?>

                <script type="text/javascript" src="<?= $assets ?>pos/qz/js/deployJava.js"></script>
                <script type="text/javascript" src="<?= $assets ?>pos/qz/qz-functions.js"></script>
                <script type="text/javascript">
                                   deployQZ('themes/<?= $Settings->theme ?>/assets/pos/qz/qz-print.jar', '<?= $assets ?>pos/qz/qz-print_jnlp.jnlp');
                                   usePrinter("<?= $pos_settings->receipt_printer; ?>");
        <?php /* $image = $this->sma->save_barcode($inv->reference_no); */ ?>
                                   function printReceipt() {
                                       //var barcode = 'data:image/png;base64,<?php /* echo $image; */ ?>';
                                       receipt = "";
                                       receipt += chr(27) + chr(69) + "\r" + chr(27) + "\x61" + "\x31\r";
                                       receipt += "<?= $biller->company; ?>" + "\n";
                                       receipt += " \x1B\x45\x0A\r ";
                                       receipt += "<?= $biller->address . " " . $biller->city . " " . $biller->country; ?>" + "\n";
                                       receipt += "<?= $biller->phone; ?>" + "\n";
                                       receipt += "<?php
        if ($pos_settings->cf_title1 != "" && $pos_settings->cf_value1 != "") {
            echo printLine($pos_settings->cf_title1 . ": " . $pos_settings->cf_value1);
        }
        ?>" + "\n";
                                       receipt += "<?php
        if ($pos_settings->cf_title2 != "" && $pos_settings->cf_value2 != "") {
            echo printLine($pos_settings->cf_title2 . ": " . $pos_settings->cf_value2);
        }
        ?>" + "\n";
                                       receipt += "<?= drawLine(); ?>\r\n";
                                       receipt += "<?php
        if ($Settings->invoice_view == 1) {
            echo lang('tax_invoice');
        }
        ?>\r\n";
                                       receipt += "<?php
        if ($Settings->invoice_view == 1) {
            echo drawLine();
        }
        ?>\r\n";
                                       receipt += "\x1B\x61\x30";
                                       receipt += "<?= printLine(lang("reference_no") . ": " . $inv->reference_no) ?>" + "\n";
                                       receipt += "<?= printLine(lang("sales_person") . ": " . $biller->name); ?>" + "\n";
                                       receipt += "<?= printLine(lang("customer") . ": " . $inv->customer); ?>" + "\n";
                                       receipt += "<?= printLine(lang("date") . ": " . date($dateFormats['php_ldate'], strtotime($inv->date))) ?>" + "\n\n";
                                       receipt += "<?php
        $r = 1;
        foreach ($rows as $row):
            ?>";
                                           receipt += "<?= "#" . $r . " "; ?>";
                                           receipt += "<?= printLine(product_name(addslashes($row->product_name)) . ($row->variant ? ' (' . $row->variant . ')' : '') . ":" . $row->tax_code, '*'); ?>" + "\n";
                                           receipt += "<?= printLine($this->sma->formatQuantity($row->quantity) . "x" . $this->sma->formatMoney($row->net_unit_price + ($row->item_tax / $row->quantity)) . ":  " . $this->sma->formatMoney($row->subtotal), ' ') . ""; ?>" + "\n";
                                           receipt += "<?php
            $r++;
        endforeach;
        ?>";
                                       receipt += "\x1B\x61\x31";
                                       receipt += "<?= drawLine(); ?>\r\n";
                                       receipt += "\x1B\x61\x30";
                                       receipt += "<?= printLine(lang("total") . ": " . $this->sma->formatMoney($inv->total + $inv->product_tax)); ?>" + "\n";
        <?php if ($inv->order_tax != 0) { ?>
                                           receipt += "<?= printLine(lang("tax") . ": " . $this->sma->formatMoney($inv->order_tax)); ?>" + "\n";
        <?php } ?>
        <?php if ($inv->total_discount != 0) { ?>
                                           receipt += "<?= printLine(lang("discount") . ": (" . $this->sma->formatMoney($inv->product_discount) . ") " . $this->sma->formatMoney($inv->order_discount)); ?>" + "\n";
        <?php } ?>
        <?php if ($pos_settings->rounding) { ?>
                                           receipt += "<?= printLine(lang("rounding") . ": " . $rounding); ?>" + "\n";
                                           receipt += "<?= printLine(lang("grand_total") . ": " . $this->sma->formatMoney($this->sma->roundMoney($inv->grand_total + $rounding))); ?>" + "\n";
        <?php } else { ?>
                                           receipt += "<?= printLine(lang("grand_total") . ": " . $this->sma->formatMoney($inv->grand_total)); ?>" + "\n";
        <?php } ?>
        <?php if ($inv->paid < $inv->grand_total) { ?>
                                           receipt += "<?= printLine(lang("paid_amount") . ": " . $this->sma->formatMoney($inv->paid)); ?>" + "\n";
                                           receipt += "<?= printLine(lang("due_amount") . ": " . $this->sma->formatMoney($inv->grand_total - $inv->paid)); ?>" + "\n\n";
        <?php } ?>
        <?php
        if ($payments) {
            foreach ($payments as $payment) {
                if ($payment->paid_by == 'cash' && $payment->pos_paid) {
                    ?>
                                                   receipt += "<?= printLine(lang("paid_by") . ": " . lang($payment->paid_by)); ?>" + "\n";
                                                   receipt += "<?= printLine(lang("amount") . ": " . $this->sma->formatMoney($payment->pos_paid)); ?>" + "\n";
                                                   receipt += "<?= printLine(lang("change") . ": " . ($payment->pos_balance > 0 ? $this->sma->formatMoney($payment->pos_balance) : 0)); ?>" + "\n";
                <?php } if (($payment->paid_by == 'CC' || $payment->paid_by == 'ppp' || $payment->paid_by == 'stripe') && $payment->cc_no) { ?>
                                                   receipt += "<?= printLine(lang("paid_by") . ": " . lang($payment->paid_by)); ?>" + "\n";
                                                   receipt += "<?= printLine(lang("amount") . ": " . $this->sma->formatMoney($payment->pos_paid)); ?>" + "\n";
                                                   receipt += "<?= printLine(lang("card_no") . ": xxxx xxxx xxxx " . substr($payment->cc_no, -4)); ?>" + "\n";
                <?php } if ($payment->paid_by == 'Cheque' && $payment->cheque_no) { ?>
                                                   receipt += "<?= printLine(lang("paid_by") . ": " . lang($payment->paid_by)); ?>" + "\n";
                                                   receipt += "<?= printLine(lang("amount") . ": " . $this->sma->formatMoney($payment->pos_paid)); ?>" + "\n";
                                                   receipt += "<?= printLine(lang("cheque_no") . ": " . $payment->cheque_no); ?>" + "\n";
                    <?php if ($payment->paid_by == 'other' && $payment->amount) { ?>
                                                       receipt += "<?= printLine(lang("paid_by") . ": " . lang($payment->paid_by)); ?>" + "\n";
                                                       receipt += "<?= printLine(lang("amount") . ": " . $this->sma->formatMoney($payment->amount)); ?>" + "\n";
                                                       receipt += "<?= printText(lang("payment_note") . ": " . $payment->note); ?>" + "\n";
                        <?php
                    }
                }
            }
        }

        if ($Settings->invoice_view == 1) {
            if (!empty($tax_summary)) {
                ?>
                                               receipt += "\n" + "<?= lang('tax_summary'); ?>" + "\n";
                                               receipt += "<?= taxLine(lang('name'), lang('code'), lang('qty'), lang('tax_excl'), lang('tax_amt')); ?>" + "\n";
                                               receipt += "<?php foreach ($tax_summary as $summary): ?>";
                                                   receipt += "<?= taxLine($summary['name'], $summary['code'], $this->sma->formatQuantity($summary['items']), $this->sma->formatMoney($summary['amt']), $this->sma->formatMoney($summary['tax'])); ?>" + "\n";
                                                   receipt += "<?php endforeach; ?>";
                                               receipt += "<?= printLine(lang("total_tax_amount") . ":" . $this->sma->formatMoney($inv->product_tax)); ?>" + "\n";
                <?php
            }
        }
        ?>
                                       receipt += "\x1B\x61\x31";
                                       receipt += "\n" + "<?= $biller->invoice_footer ? printText(str_replace(array('\n', '\r'), ' ', $this->sma->decode_html($biller->invoice_footer))) : '' ?>" + "\n";
                                       receipt += "\x1B\x61\x30";
        <?php if (isset($pos_settings->cash_drawer_cose)) { ?>
                                           print(receipt, '', '<?= $pos_settings->cash_drawer_cose; ?>');
        <?php } else { ?>
                                           print(receipt, '', '');
        <?php } ?>

                                   }

                </script>
            <?php } ?>
            <script type="text/javascript">
                $(document).ready(function () {
                    localStorage.removeItem('poscustomer');
                    localStorage.removeItem('positems');
                    $('#back_to_pos').click(function () {
                        localStorage.removeItem('positems');
                        localStorage.removeItem('poscustomer');
                    });
                    $('button.close').on('click', function () {
                        $(this).parent().hide();
                    });
                    $('#email').click(function () {
                        var email = prompt("<?= lang("email_address"); ?>", "<?= $customer->email; ?>");
                        if (email != null) {
                            $.ajax({
                                type: "post",
                                url: "<?= site_url('pos/email_receipt') ?>",
                                data: {<?= $this->security->get_csrf_token_name(); ?>: "<?= $this->security->get_csrf_hash(); ?>", email: email, id: <?= $inv->id; ?>},
                                dataType: "json",
                                success: function (data) {
                                    alert(data.msg);
                                },
                                error: function () {
                                    alert('<?= lang('ajax_request_failed'); ?>');
                                    return false;
                                }
                            });
                        }
                        return false;
                    });
                });

                $(document).on("keydown", function (e) {
                    if (e.which === 8 && !$(e.target).is("input, textarea")) {
                        e.preventDefault();
                    }
                });
    <?php if (!$pos_settings->java_applet) { ?>
                    /*$(window).load(function () {
                     window.print();
                     });*/
    <?php } ?>
            </script>
        </body>
    </html>
<?php } ?>
