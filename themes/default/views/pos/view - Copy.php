<?php	
function product_name($name)
{
    return character_limiter($name, (isset($pos_settings->char_per_line) ? ($pos_settings->char_per_line-8) : 35));
}

if ($modal) {
    echo '<div class="modal-dialog no-modal-header">'
            . '<div class="modal-content">'
            . '<div class="modal-body">'
            . '<button type="button" class="close" data-dismiss="modal" aria-hidden="true">'
            . '<i class="fa fa-2x">&times;</i></button>';
} else { ?>
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
                font-size: 11px;
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
                margin: 10px 0;
            }
            .right-space{margin-right: 5px;}
            p{
                font-size: 11px;
            }
            hr{
                margin: 0px;
            }
            .table{
                width:250px !important;
                line-height:0.1em !important;
            }

            #wrapper {
                max-width: 255px;
                margin: 0 auto;
                padding-top: 20px;
            }

            .btn {
                border-radius: 0;
                margin-bottom: 5px;
            }

            h3 {
                margin: 5px 0;
            }

            @media print {
                .no-print {
                    display: none;
                }

                #wrapper {
                    max-width: 255px;
                    width: 100%;
                    min-width: 255px;
                    margin: 0 auto;
                }
            }
/*            
            .declaration{
                font-size:9px;
                font-weight: normal;
            }*/
        </style>
        <script type="text/javascript">
            window.location.hash="no-back-button";
            window.location.hash="Again-No-back-button";//again because google chrome don't insert first hash into history
            window.onhashchange=function(){window.location.hash="no-back-button";}
            function preventBack(){window.history.forward();}
            setTimeout("preventBack()", 0);
            window.onunload=function(){null};
        </script> 
    </head>

    <body onload="disable_browser_back_button();" >

<?php } ?>
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
        <div class="text-center">
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
	<div class="row" style="width:auto !important;margin:0px;">
                <div class="col-sm-12 text-center">
                    <h5 style="font-weight:bold;"><?= lang('tax_invoice'); ?></h5>
                </div>
            </div>
        
        <div class="row" style="width:auto !important;margin:0px;">
            <div class="col-md-12 text-left" style="font-size:9px !important;padding:0px !important;">
                <p><strong><?= lang("store_name"); ?></strong> : <?php echo $biller->company; ?>&nbsp;.</p>
                <p><strong><?= lang("store_address"); ?></strong> : <?php echo $biller->address.' '.'TIN : '.$biller->tin_no; ?></p>
                <hr></hr>
                <?php
                /* Updates done by Chitra to modify the receipt format */
                echo "<p><strong>" . lang("date") . "</strong> : " . $this->sma->hrld($inv->date) . "</p>";
                echo "<p><strong>" . lang("invoice_number") . "</strong> : " . $inv->reference_no . "</p>";
                //echo "<p><strong>" . lang("sales_exe_id") . "</strong> : " . ucwords($inv->first_name)." ". ucwords($inv->last_name) ." (".$inv->sales_executive_id.")</p>";
                echo "<p><strong>" . lang("sales_exe") . "</strong> : " . ucwords($inv->username)."</p>";
                ?>
                <hr>
                <p><strong><?= lang("customer_name"); ?></strong> : <?php echo $inv->customer;?></p>
                <p><strong><?= lang("customer_contact"); ?></strong> : <?php echo ($inv->sale_status === 'foc') ? $foc_details->mobile:$customer->phone; ?></p>
                <hr>
            </div>
        </div>
        
        <table class="table table-condensed table-responsive" 
               style="font-size:9px !important;width:auto;">
            <thead>
                <tr>
                    <th class='col-xs-3 text-left'>Item Code</th>
                    <th class='col-xs-3 text-left'>HSN Code</th>
                    <th class='col-xs-3 text-left'>Dis <span class="rupee">&#8377;</span></th>
                    <th class='col-xs-3 text-left'><?= lang("cgst"); ?></th>
                    <th class='col-xs-3 text-left'><?= lang("gst"); ?></th>
                    <th class='col-xs-3 text-right'><?= lang("mrp"); ?><span class="rupee">&#8377;</span></th>
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
               
                foreach ($rows as $row) {

                    $total_discounted_amount += ($row->quantity * $row->net_unit_price);
                    if($row->pdiscount_type === 'foc'){
                        $total_net_amt += ($row->unit_price*0) - $row->item_discount;
                    }else{
                        $total_net_amt += ($row->quantity * $row->net_unit_price) - $row->item_discount;
                    }
                    
                    $total_amt += $row->net_unit_price;
                    $total_items +=$row->quantity;
                    $total_discount+= $row->item_discount;
                    $total_tax += $row->item_tax;
                    $total_mrp += $row->real_unit_price;
                    
                    $tax_summary[$row->tax_code]['items'] = $row->quantity;
                    $tax_summary[$row->tax_code]['tax'] = $row->item_tax;
                    $tax_summary[$row->tax_code]['amt'] = ($row->quantity * $row->net_unit_price) - $row->item_discount;
                    $tax_summary[$row->tax_code]['name'] = $row->tax_name;
             
                        $tax_summary[$row->tax_code]['code'] = $row->tax_code;
                        $tax_summary[$row->tax_code]['rate'] = $row->tax_rate;
                    
                    /*Updated By Chitra to calculate total tax of the inline items added. */
                    //echo "<pre>";print_r($tax_summary);
                    if($pos->order_discount_type == 'percent'){
                        if($row->pdiscount_type === 'foc'){
                            $disc = $row->unit_price;
                        }else{
                            $disc = ($row->real_unit_price * $row->discount)/100;
                        }
                    }
                    else{
                        $disc = $row->item_discount;
                    }
                    
                    if($row->pdiscount_type === 'foc'){
                            $prod_amount = $this->sma->formatMoney($row->unit_price);
                    }else{
                            $prod_amount = $this->sma->formatMoney($row->net_unit_cost+$row->item_tax);
                    }
                    
                    if($row->pdiscount_type === 'foc'){
                        $prod_total_amount+= $row->unit_price;
                    }else{
                        $prod_total_amount+= $row->net_unit_cost+$row->item_tax;
                    }
                    $prod_tax_rate = $this->sma->formatMoney($tax_summary[$row->tax_code]['rate']);
                    $prod_price = $tax_summary[$row->tax_code]['amt']; 
                    $total_order_tax +=($tax_summary[$row->tax_code]['tax']);
                    $prod_tax = ($prod_price*$prod_tax_rate)/((100)+($prod_tax_rate));
                    $booking_status = !empty($row->advance_booking) ? '(Advance Booking)' : ''; 
                    $row->product_hsn = ($row->product_hsn === null) || ($row->product_hsn === 'undefined') ? '' : $row->product_hsn;

                    if($row->return_id != 0){
                        echo '<tr>'
                        . '<td class="text-left">' .($row->product_code). ($row->variant ? ' (' . $row->variant . ')' : '').'</td>'
                        . '<td class="text-left">'.$row->hsn_code.'</td>'
                        . '<td class="text-left">' .$this->sma->formatMoney($disc). '</td>'
                        . '<td class="text-left"><span class="rupee">&#8377;</span> '.$this->sma->formatMoney($row->item_tax/2).' '
                        . '('.$this->sma->formatMoney($row->tax_rate/2).'% )</td>'
                         . '<td class="text-left"><span class="rupee">&#8377;</span> '.$this->sma->formatMoney($row->item_tax/2).' '
                        . '('.$this->sma->formatMoney($row->tax_rate/2).'% )</td>'
//                        . '<td class="text-left">' . $prod_amount . '</td>'
                          .'<td class="text-right">'.$this->sma->formatMoney($row->real_unit_price).'</td>'
                        . '</tr>';
                    }
                    else{
                        echo '<tr>'
                        . '<td class="text-left">' . ($row->product_code). ($row->variant ? ' (' . $row->variant . ')' : '').'</td>'
                        . '<td class="text-left" style="width:20%">'.$row->hsn_code.'</td>'
                        . '<td class="text-left">' .$this->sma->formatMoney($disc). '</td>'
                        
                         . '<td class="text-left"><span class="rupee">&#8377;</span> '.$this->sma->formatMoney($row->item_tax/2).' '
                        . '('.$this->sma->formatMoney($row->tax_rate/2).'% )</td>'
                         . '<td class="text-left"><span class="rupee">&#8377;</span> '.$this->sma->formatMoney($row->item_tax/2).' '
                        . '('.$this->sma->formatMoney($row->tax_rate/2).'% )</td>'
                       
//                        . '<td class="text-left">' . $prod_amount . '</td>'
                        .'<td class="text-right">'.$this->sma->formatMoney($row->real_unit_price).'</td>'
                        . '</tr>';
                    }
                    //echo '</td><td>'.$this->sma->formatMoney($row->item_discount).'</td><td>'.$this->sma->formatMoney($row->tax).'</td><td>'.$this->sma->formatMoney($row->item_tax).'</td><td>'.intval($row->quantity).'</td><td class="text-left">' . $this->sma->formatMoney($row->unit_price + $row->item_discount) . '</td></tr>';
                    
                    $r++;
                }                                   
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="4" class="text-left"><?= lang("total"); ?>&nbsp;<span class="rupee">&#8377;</span></th>
                    <th><?=intval($total_items)?></th>
                    <th class='text-right'><?=$this->sma->formatMoney($total_mrp)?></th>
                    <!--<th class="text-right"><?=$this->sma->formatMoney($inv->total + $inv->product_tax)?></th>-->
                </tr>
                    <tr>
                        <th colspan="5" class="text-left"><?= lang("discount")?>&nbsp;<span class="rupee">&#8377;</span></th>
                        <th class='text-right'><?=$this->sma->formatMoney($total_discount)?></th>
                    </tr>
                    <tr>
                        <th colspan="5" class="text-left"><?= lang("basic")?>&nbsp;<span class="rupee">&#8377;</span></th>
                        <th class='text-right'><?=$this->sma->formatMoney($total_net_amt+$total_discount)?></th>
                    </tr>
                    <!-- <tr>
                        <th colspan="5" class="text-left"><?= lang("order_tax_val")?>&nbsp;<span class="rupee">&#8377;</span></th>
                        <th class='text-right'><?=$this->sma->formatMoney($inv->total_tax)?></th>
                    </tr> -->
                    <tr>
                        <th colspan="5" class="text-left"><?= lang("cgst")?>&nbsp;<span class="rupee">&#8377;</span></th>
                        <th class='text-right'><?=$this->sma->formatMoney($inv->total_tax/2)?></th>
                    </tr>
                    <tr>
                        <th colspan="5" class="text-left"><?= lang("sgst")?>&nbsp;<span class="rupee">&#8377;</span></th>
                        <th class='text-right'><?=$this->sma->formatMoney($inv->total_tax/2)?></th>
                    </tr>
                <?php
                //echo "<pre>";print_r($inv);
                if($inv->grand_total === 0.00){
                    $inv->grand_total = intval($inv->grand_total);
                }
                if ($inv->order_tax != 0) {
                    echo '<tr><th colspan="4" class="text-left">' . lang("order_tax") . '</th>'
                            . '<th class="text-right">' . $this->sma->formatMoney($inv->order_tax) . '</th></tr>';
                }
                if ($inv->order_discount != 0) {
                    echo '<tr><th colspan="4" class="text-left">' . lang("order_discount") . '</th>'
                            . '<th class="text-right">'.$this->sma->formatMoney($inv->order_discount) . '</th></tr>';
                }
                
                if ($pos_settings->rounding) {                    
                    $round_total = $this->sma->roundNumber($inv->grand_total, $pos_settings->rounding);
                    $rounding = $this->sma->formatMoney($round_total - $inv->grand_total);
                ?>
                    <tr>
                        <th colspan="4"><?= lang("rounding"); ?></th>
                        <th class="text-right"><?= $rounding; ?></th>
                    </tr>
                    <tr>
                        <th colspan="4" class="text-left"><?= lang("net_amount"); ?></th>
                        <th colspan="4" class="text-left"><?= $this->sma->formatMoney($inv->grand_total + $rounding); ?></th>
                    </tr>
                   
                    <?php if($inv->grand_total > 0){?>
                     <tr>
                        <th colspan="6" class="text-left"><?= lang("amount_chargeable_words"); ?></th>
                    </tr>
                    <tr>
                        <th colspan="6" class="text-left"><?=$this->pos_model->convert_numbers_to_words($inv->grand_total + $rounding)?></th>
                    </tr>
                    <?php }?>
                <?php } else { ?>
                    <tr>
                        <th colspan="4" class="text-left"><?= lang("net_amount"); ?>&nbsp;<span class="rupee">&#8377;</span></th>	
                        <?php if($inv->grand_total === 0){?>
                            <th colspan="4" class="text-left"></th>
                        <?php }else{?>
                                <th colspan="4" class="text-right"><?= $this->sma->formatMoney(round($inv->grand_total,0)); ?></th>
                        <?php }?>

                    </tr>
            <tr><td colspan="6">

            <?php 
            //echo "<pre>";print_r($payments);
            if ($payments) {
               echo '<table class="table table-condensed"><tbody>';
                foreach ($payments as $payment) {
                    if($payment->pos_paid > 0){
                    echo '<tr>';
                    if ($payment->paid_by == 'cash' && $payment->pos_paid) {
                        echo '<td style="display:none;"></td>';
                        echo '<td colspan="2">' . lang("paid_by") . ': ' . lang($payment->paid_by) . '</td>';
                        echo '<td>' . lang("amount") . ':  <span class="rupee">&#8377;</span> ' . $this->sma->formatMoney($payment->pos_paid == 0 ? $payment->amount : $payment->pos_paid) . ($payment->return_id ? ' (' . lang('returned') . ')' : '') . '</td>';
                        //echo '<td>' . lang("change") . ': ' . ($payment->pos_balance > 0 ? $this->sma->formatMoney($payment->pos_balance) : 0) . '</td>';
                        echo '<td></td>';
                    }
                    if (($payment->paid_by == 'CC' || $payment->paid_by == 'ppp' || $payment->paid_by == 'stripe') && $payment->cc_no) {
                        echo '<td style="display:none;"></td>';
                        echo '<td colspan="1">';
                        echo '<span class="right-space">' . lang("paid_by") . ': ' . lang($payment->card_type) . '</span><td>';
                        echo '<td colspan="2"><span class="right-space rupee">' . lang("amount") . ': &#8377;' . $this->sma->formatMoney($payment->pos_paid) . ($payment->return_id ? ' (' . lang('returned') . ')' : '') . '</span></td>';
                        echo '<td colspan="2"><span class="right-space">' . lang("no") . ': ' .substr($payment->cc_no, 0, 4). '-xx-' . substr($payment->cc_no, -4) .'</span></td>';
                        echo '<td><span class="right-space">' . lang("expiry") . ': ' .$payment->cc_month.'/'.$payment->cc_year.'</span></td>';
                        //echo '<td>' . lang("name") . ': ' . $payment->cc_holder . '</td>';
                    }
                    if ($payment->paid_by == 'Cheque' && $payment->cheque_no) {
                        echo '<td style="display:none;"></td>';
                        echo '<td colspan="2">' . lang("paid_by") . ': ' . lang($payment->paid_by) . '</td>';
                        echo '<td>' . lang("amount") . ': <span class="rupee">&#8377;</span> ' . $this->sma->formatMoney($payment->pos_paid) . ($payment->return_id ? ' (' . lang('returned') . ')' : '') . '</td>';
                        echo '<td>' . lang("cheque_no") . ': ' . $payment->cheque_no . '</td>';
                    }
                    if ($payment->paid_by == 'credit_voucher' && $payment->pos_paid) {
                        //echo "<pre>";print_r($payment);die;
                        echo '<td style="display:none;"></td>';
                        echo '<td>' . lang("paid_by") . ': ' . lang($payment->paid_by) . '</td>';
                        echo '<td colspan="2">' . lang("no") . ': ' . $payment->cc_no . '</td>';
                        echo '<td>' . lang("amount") . ': <span class="rupee">&#8377;</span> ' . $this->sma->formatMoney($payment->pos_paid) . ($payment->return_id ? ' (' . lang('returned') . ')' : '') . '</td>';
                        echo '<td>' . lang("credit_note_balance") . ': ' . ($payment->cn_balance > 0 ? $this->sma->formatMoney($payment->cn_balance) : 0) . '</td>';
                    }
                    if ($payment->paid_by == 'other' && $payment->amount) {
                        echo '<td style="display:none;"></td>';
                        echo '<td colspan="2">' . lang("paid_by") . ': ' . lang($payment->paid_by) . '</td>';
                        echo '<td>' . lang("amount") . ': <span class="rupee">&#8377;</span> ' . $this->sma->formatMoney($payment->pos_paid == 0 ? $payment->amount : $payment->pos_paid) . ($payment->return_id ? ' (' . lang('returned') . ')' : '') . '</td>';
                        echo $payment->note ? '</tr><td colspan="2">' . lang("payment_note") . ': ' . $payment->note . '</td>' : '';
                    }
                    echo '</tr>';
                    }
                }
                echo '</tbody></table>';
            }

            /*if ($Settings->invoice_view == 1) {
                if (!empty($tax_summary)) {
                    echo '<h4 style="font-weight:bold;">' . lang('tax_summary') . '</h4>';
                    echo '<table class="table table-condensed"><thead><tr><th>' . lang('name') . '</th><th>' . lang('code') . '</th><th>' . lang('qty') . '</th><th>' . lang('tax_excl') . '</th><th>' . lang('tax_amt') . '</th></tr></td><tbody>';
                    foreach ($tax_summary as $summary) {
                        echo '<tr><td>' . $summary['name'] . '</td><td class="text-center">' . $summary['code'] . '</td><td class="text-center">' . $this->sma->formatQuantity($summary['items']) . '</td><td class="text-right">' . $this->sma->formatMoney($summary['amt']) . '</td><td class="text-right">' . $this->sma->formatMoney($summary['tax']) . '</td></tr>';
                    }
                    echo '</tbody></tfoot>';
                    echo '<tr><th colspan="4" class="text-right">' . lang('total_tax_amount') . '</th><th class="text-right">' . $this->sma->formatMoney($inv->product_tax) . '</th></tr>';
                    echo '</tfoot></table>';
                }
            }*/
            ?>
                        </td></tr>
                <?php  if($inv->grand_total > 0){ ?>
                    <tr>
                        <th colspan="7" class="text-left"><?= lang("amount_chargeable_words"); ?></th>
                    </tr>
                <?php }?>
<!--                        <th class="text-left" colspan="6"><?=$this->sma->formatMoney($inv->grand_total + $rounding)?></th>-->
                    <tr>
                        <th class="text-left" colspan="7">
                                <?php 
                                    if($inv->grand_total > 0){
                                        echo ucwords($this->pos_model->convert_numbers_to_words($inv->grand_total));
                                    }else{
                                        echo "";
                                    }                            
                                ?>
                        </th>
                    </tr>
                   
                <?php }
                if ($inv->paid < $inv->grand_total) { ?>
                    <tr>
                        <th colspan="6"><?= lang("paid_amount"); ?></th>					
                        <th class="text-left" ><?= $this->sma->formatMoney($inv->paid); ?></th>
                    </tr>
                    <tr>
                        <th colspan="6"><?= lang("due_amount"); ?></th>
                        <th class="text-left"><?= $this->sma->formatMoney($inv->grand_total - $inv->paid); ?></th>
                    </tr>
                <?php } ?>
                </tfoot>
        </table>
        <table class="table">
            <thead>
                <tr>
                    <th style="font-weight:normal !important; font-size:9px;">
                          <h5 class="text-center">Declaration </h5>
						<?php if(($biller->cf1 != NULL) || ($biller->cf1 != '')){?>
                        <p class="declaration text-justify">1. <?=$biller->cf1?></p>
						<?php }?>
						<?php if(($biller->cf2 != NULL) || ($biller->cf2 != '')){?>
                        <p class="declaration text-justify">2. <?=$biller->cf2?></p>
						<?php }?>
						<?php if(($biller->cf2 == NULL) || ($biller->cf2 == '')){?>
                        <p class="declaration text-justify">2. No returns, products can be exchanged within 
                        <?=$inv->return_time;?> days from the date of purchase.</p>
						<?php }else{?>
						  <p class="declaration text-justify">3. No returns, Products can be exchanged within 
                        <?=$inv->return_time;?> days from the date of purchase.</p>
						<?php }?>
                    </th>
                </tr>
                <tr>
                   <th class="text-center">* This is a computer generated invoice, hence does not require any signature</th>
               </tr>
            </thead>
        </table>               
        <?= $inv->note ? '<p class="text-center">' . $this->sma->decode_html($inv->note) . '</p>' : ''; ?>
        <?= $inv->staff_note ? '<p class="no-print"><strong>' . lang('staff_note') . ':</strong> ' . $this->sma->decode_html($inv->staff_note) . '</p>' : ''; ?>
        <div class="well well-sm" style="font-size:9px !important;">
            <h6 class="text-center"><strong><?=$pos_settings->cf_title3?></strong></h6>
            <p class="text-center declaration"><strong>Registered Office: </strong> <?=$pos_settings->cf_value3?></p>
            <p class="text-center declaration"><strong><?=$pos_settings->cf_title4?>: </strong><?=$pos_settings->cf_value4?></p>
            <p class="text-center declaration"><strong><?=$pos_settings->cf_title5?>: </strong><?=$pos_settings->cf_value5?></p>
            <p class="text-center declaration"><strong><?=$pos_settings->cf_title6?>: </strong><?=$pos_settings->cf_value6?></p>
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
	
<?php if ($modal) {
    echo '</div></div></div></div>';
} else { ?>
<div id="buttons" style="padding-top:10px; text-transform:uppercase;" class="no-print">
    <?php if ($pos_settings->java_applet) { ?>
        <span class="col-xs-12"><a class="btn btn-block btn-primary" onClick="printReceipt()"><?= lang("print"); ?></a></span>
        <span class="col-xs-12"><a class="btn btn-block btn-info" type="button" onClick="openCashDrawer()">Open Cash
                Drawer</a></span>
        <div style="clear:both;"></div>
    <?php } else { ?>
        <span class="pull-right col-xs-12">
        <a href="javascript:window.print()" id="web_print" class="btn btn-block btn-primary"
           onClick="window.print();return false;"><?= lang("web_print"); ?></a>
    </span>
    <?php } ?>
    <span class="pull-left col-xs-12"><a class="btn btn-block btn-success" href="<?= site_url('pos/save_invoice_pdf/'.$sid); ?>" ><?= lang("save_as_pdf"); ?></a></span>

    <span class="col-xs-12">
        <!--Add logout functionality after payment @ ankit-->
        <?php if($pos_settings->logout_after_payment=='1'){   ?>
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
<?php if ($pos_settings->java_applet) {
        function drawLine()
        {
            $size = $pos_settings->char_per_line;
            $new = '';
            for ($i = 1; $i < $size; $i++) {
                $new .= '-';
            }
            $new .= ' ';
            return $new;
        }

        function printLine($str, $sep = ":", $space = NULL)
        {
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

        function printText($text)
        {
            $size = $pos_settings->char_per_line;
            $new = wordwrap($text, $size, "\\n");
            return $new;
        }

        function taxLine($name, $code, $qty, $amt, $tax)
        {
            return printLine(printLine(printLine(printLine($name . ':' . $code, '', 18) . ':' . $qty, '', 25) . ':' . $amt, '', 35) . ':' . $tax, ' ');
        }

        ?>

        <script type="text/javascript" src="<?= $assets ?>pos/qz/js/deployJava.js"></script>
        <script type="text/javascript" src="<?= $assets ?>pos/qz/qz-functions.js"></script>
        <script type="text/javascript">
            deployQZ('themes/<?=$Settings->theme?>/assets/pos/qz/qz-print.jar', '<?= $assets ?>pos/qz/qz-print_jnlp.jnlp');
            usePrinter("<?= $pos_settings->receipt_printer; ?>");
            <?php /*$image = $this->sma->save_barcode($inv->reference_no);*/ ?>
            function printReceipt() {
                //var barcode = 'data:image/png;base64,<?php /*echo $image;*/ ?>';
                receipt = "";
                receipt += chr(27) + chr(69) + "\r" + chr(27) + "\x61" + "\x31\r";
                receipt += "<?= $biller->company; ?>" + "\n";
                receipt += " \x1B\x45\x0A\r ";
                receipt += "<?= $biller->address . " " . $biller->city . " " . $biller->country; ?>" + "\n";
                receipt += "<?= $biller->phone; ?>" + "\n";
                receipt += "<?php if ($pos_settings->cf_title1 != "" && $pos_settings->cf_value1 != "") { echo printLine($pos_settings->cf_title1 . ": " . $pos_settings->cf_value1); } ?>" + "\n";
                receipt += "<?php if ($pos_settings->cf_title2 != "" && $pos_settings->cf_value2 != "") { echo printLine($pos_settings->cf_title2 . ": " . $pos_settings->cf_value2); } ?>" + "\n";
                receipt += "<?=drawLine();?>\r\n";
                receipt += "<?php if($Settings->invoice_view == 1) { echo lang('tax_invoice'); } ?>\r\n";
                receipt += "<?php if($Settings->invoice_view == 1) { echo drawLine(); } ?>\r\n";
                receipt += "\x1B\x61\x30";
                receipt += "<?= printLine(lang("reference_no") . ": " . $inv->reference_no) ?>" + "\n";
                receipt += "<?= printLine(lang("sales_person") . ": " . $biller->name); ?>" + "\n";
                receipt += "<?= printLine(lang("customer") . ": " . $inv->customer); ?>" + "\n";
                receipt += "<?= printLine(lang("date") . ": " . date($dateFormats['php_ldate'], strtotime($inv->date))) ?>" + "\n\n";
                receipt += "<?php $r = 1;
            foreach ($rows as $row): ?>";
                receipt += "<?= "#" . $r ." "; ?>";
                receipt += "<?= printLine(product_name(addslashes($row->product_name)).($row->variant ? ' ('.$row->variant.')' : '').":".$row->tax_code, '*'); ?>" + "\n";
                receipt += "<?= printLine($this->sma->formatQuantity($row->quantity)."x".$this->sma->formatMoney($row->net_unit_price+($row->item_tax/$row->quantity)) . ":  ". $this->sma->formatMoney($row->subtotal), ' ') . ""; ?>" + "\n";
                receipt += "<?php $r++;
            endforeach; ?>";
                receipt += "\x1B\x61\x31";
                receipt += "<?=drawLine();?>\r\n";
                receipt += "\x1B\x61\x30";
                receipt += "<?= printLine(lang("total") . ": " . $this->sma->formatMoney($inv->total+$inv->product_tax)); ?>" + "\n";
                <?php if ($inv->order_tax != 0) { ?>
                receipt += "<?= printLine(lang("tax") . ": " . $this->sma->formatMoney($inv->order_tax)); ?>" + "\n";
                <?php } ?>
                <?php if ($inv->total_discount != 0) { ?>
                receipt += "<?= printLine(lang("discount") . ": (" . $this->sma->formatMoney($inv->product_discount).") ".$this->sma->formatMoney($inv->order_discount)); ?>" + "\n";
                <?php } ?>
                <?php if($pos_settings->rounding) { ?>
                receipt += "<?= printLine(lang("rounding") . ": " . $rounding); ?>" + "\n";
                receipt += "<?= printLine(lang("grand_total") . ": " . $this->sma->formatMoney($this->sma->roundMoney($inv->grand_total+$rounding))); ?>" + "\n";
                <?php } else { ?>
                receipt += "<?= printLine(lang("grand_total") . ": " . $this->sma->formatMoney($inv->grand_total)); ?>" + "\n";
                <?php } ?>
                <?php if($inv->paid < $inv->grand_total) { ?>
                receipt += "<?= printLine(lang("paid_amount") . ": " . $this->sma->formatMoney($inv->paid)); ?>" + "\n";
                receipt += "<?= printLine(lang("due_amount") . ": " . $this->sma->formatMoney($inv->grand_total-$inv->paid)); ?>" + "\n\n";
                <?php } ?>
                <?php
                if($payments) {
                    foreach($payments as $payment) {
                        if ($payment->paid_by == 'cash' && $payment->pos_paid) { ?>
                receipt += "<?= printLine(lang("paid_by") . ": " . lang($payment->paid_by)); ?>" + "\n";
                receipt += "<?= printLine(lang("amount") . ": " . $this->sma->formatMoney($payment->pos_paid)); ?>" + "\n";
                receipt += "<?= printLine(lang("change") . ": " . ($payment->pos_balance > 0 ? $this->sma->formatMoney($payment->pos_balance) : 0)); ?>" + "\n";
                <?php  } if (($payment->paid_by == 'CC' || $payment->paid_by == 'ppp' || $payment->paid_by == 'stripe') && $payment->cc_no) { ?>
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
                <?php }
            }

        }
    }

    if($Settings->invoice_view == 1) {
        if(!empty($tax_summary)) {
    ?>
                receipt += "\n" + "<?= lang('tax_summary'); ?>" + "\n";
                receipt += "<?= taxLine(lang('name'),lang('code'),lang('qty'),lang('tax_excl'),lang('tax_amt')); ?>" + "\n";
                receipt += "<?php foreach ($tax_summary as $summary): ?>";
                receipt += "<?= taxLine($summary['name'],$summary['code'],$this->sma->formatQuantity($summary['items']),$this->sma->formatMoney($summary['amt']),$this->sma->formatMoney($summary['tax'])); ?>" + "\n";
                receipt += "<?php endforeach; ?>";
                receipt += "<?= printLine(lang("total_tax_amount") . ":" . $this->sma->formatMoney($inv->product_tax)); ?>" + "\n";
                <?php
                    }
                }
                ?>
                receipt += "\x1B\x61\x31";
                receipt += "\n" + "<?= $biller->invoice_footer ? printText(str_replace(array('\n', '\r'), ' ', $this->sma->decode_html($biller->invoice_footer))) : '' ?>" + "\n";
                receipt += "\x1B\x61\x30";
                <?php if(isset($pos_settings->cash_drawer_cose)) { ?>
                print(receipt, '', '<?=$pos_settings->cash_drawer_cose;?>');
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
                    $('#back_to_pos').click(function(){
                        localStorage.removeItem('positems');
                        localStorage.removeItem('poscustomer');
                    });
                    $('button.close').on('click',function(){
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
        $(window).load(function () {
            window.print();
        });
    <?php } ?>
            </script>
</body>
</html>
<?php } ?>
