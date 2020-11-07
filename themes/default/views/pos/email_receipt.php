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

        #wrapper {
            max-width: 480px;
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
                max-width: 480px;
                width: 100%;
                min-width: 250px;
                margin: 0 auto;
            }
        }
    </style>

</head>

<body>
<div id="wrapper">
    <div id="receiptData">

            <div class="text-center">
            <!-- <img src="<?= base_url() . 'assets/uploads/logos/' . $biller->logo; ?>" alt="<?= $biller->company; ?>"> -->
            <h3 style="text-transform:uppercase;"><?php echo $biller->company != '-' ? $biller->company : $biller->name; ?></h3>
            <?php
            //echo "<p>" . $biller->address . " " . $biller->city . " " . $biller->postal_code . " " . $biller->state . " " . $biller->country ."<br>" . lang("tel") . ": " . $biller->phone . "<br>";
                
            ?>
            <?php
           
            echo '</p></div>';
			echo '<div class="pull-left">';
			 if ($pos_settings->cf_title1 != "" && $pos_settings->cf_value1 != "") {
                echo $pos_settings->cf_title1 . ": " . $pos_settings->cf_value1 . "<br>";
            }
            if ($pos_settings->cf_title2 != "" && $pos_settings->cf_value2 != "") {
                echo $pos_settings->cf_title2 . ": " . $pos_settings->cf_value2 . "<br>";
            }
			echo '<div>';
            ?>
            <div style="clear:both;"></div>
			<?php if ($pos_settings->invoice_view == 1) { ?>
				<div class="row">
					<div class="col-sm-12 text-center">
						<h4 style="font-weight:bold;"><?= lang('tax_invoice'); ?></h4>
					</div>
				</div>
			<?php }?>
			<div class="row">
				<div class="col-md-6">
					<h5><strong><?=lang("store_name");?></strong> : <?php echo $biller->company; ?></h5>
					<p><strong><?=lang("store_address");?></strong> : <?php echo $biller->address; ?></p>
				</div>
				<div class="col-md-6">
					<?php
						echo "<strong>".lang("date") . "</strong> : " . $this->sma->hrld($inv->date)."<br/>";
						echo "<strong>" . lang("invoice_number") . "</strong> : " . $inv->id."<br/>";
						echo "<strong>" . lang("sales_exe_id") . "</strong> : " . $inv->sales_executive_id;
					?>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6">
					<p><strong><?=lang("customer_name");?></strong> : <?php echo $inv->customer; ?></p>
				</div>
				<div class="col-md-6">
					<p><strong><?=lang("customer_contact");?></strong> : <?php echo $customer->phone; ?></p>
				</div>
			</div>
        <div style="clear:both;"></div>
        <table class="table table-striped table-bordered table-condensed table-responsive">
				<thead>
		
					<tr>
						<th>Reference</th>
						<th>Description</th>
						<th>MRP</th>
						<th>Discount</th>
						<th>Tax%</th>
						<th>Tax Amt</th>
						<th>Qty</th>
						<th>Amount(INR)</th>
					</tr>
				</thead>
                <tbody>
					<?php
					
					$r = 1;
					$tax_summary = array();
					
					foreach ($rows as $row) {
						$total_discounted_amount += ($row->quantity * $row->net_unit_price);
						$total_net_amt += ($row->quantity * $row->net_unit_price) + $row->item_discount;
						$total_amt += $row->unit_price;
						$total_items +=	$row->quantity;
						$total_discount += $row->item_discount;
						$total_tax += $row->item_tax;
						if (isset($tax_summary[$row->tax_code])) {					
							$tax_summary[$row->tax_code]['items'] += $row->quantity;
							$tax_summary[$row->tax_code]['tax'] += $row->item_tax;
							$tax_summary[$row->tax_code]['amt'] += ($row->quantity * $row->net_unit_price) - $row->item_discount;
						} else {
							$tax_summary[$row->tax_code]['items'] = $row->quantity;
							$tax_summary[$row->tax_code]['tax'] = $row->item_tax;
							$tax_summary[$row->tax_code]['amt'] = ($row->quantity * $row->net_unit_price) - $row->item_discount;
							
							$tax_summary[$row->tax_code]['name'] = $row->tax_name;
							$tax_summary[$row->tax_code]['code'] = $row->tax_code;
							$tax_summary[$row->tax_code]['rate'] = $row->tax_rate;
							
						}
						
						$booking_status = !empty($row->advance_booking) ? '(Advance Booking)' : '';
						echo '<tr><td>#' . $r . ': </td><td>' . $row->product_name . ($row->variant ? ' (' . $row->variant . ')' : '').$booking_status.'</td>';
						echo '<td>' . $this->sma->formatMoney($row->unit_price + $row->item_discount) . '';
						/*
						if ($row->item_discount != 0) {
							echo '<del>' . $this->sma->formatMoney($row->net_unit_price + ($row->item_discount / $row->quantity) + ($row->item_tax / $row->quantity)) . '</del> ';
						}
						*/

						echo '</td><td>'.$this->sma->formatMoney($row->item_discount).'</td><td>'.$this->sma->formatMoney($row->tax).'</td><td>'.$this->sma->formatMoney($row->item_tax).'</td><td>'.intval($row->quantity).'</td><td class="text-left">' . $this->sma->formatMoney($row->unit_price + $row->item_discount) . '</td></tr>';
						$r++;
					}
					
					
					?>
				</tbody>
				<tfoot>
					                <tr>
                    <th colspan="6" class="text-right"><?= lang("total"); ?></th>
					<th><?=intval($total_items)?></th>
					<th><?=$this->sma->formatMoney($total_amt)?></th>
					<!---
                    <th class="text-right"><?=$this->sma->formatMoney($inv->total + $inv->product_tax)?></th>
					---->
                </tr>
				<tr>
					<th colspan="7" class="text-right"><?= lang("discount")?></th>			
					<th><?=$this->sma->formatMoney($total_discount)?></th>
				</tr>
				<tr>
					<th colspan="7" class="text-right"><?= lang("basic")?></th>
					<th><?=$this->sma->formatMoney($total_net_amt)?></th>
				</tr>
				<tr>
					<th colspan="7" class="text-right"><?= lang("tax")?></th>
					<th><?=$this->sma->formatMoney($total_tax)?></th>
				</tr>
                <?php
                if ($inv->order_tax != 0) {
                    echo '<tr><th colspan="7" class="text-right">' . lang("order_tax") . '</th><th class="text-right">' . $this->sma->formatMoney($inv->order_tax) . '</th></tr>';
                }
                if ($inv->order_discount != 0) {
                    echo '<tr><th colspan="7" class="text-right">' . lang("order_discount") . '</th><th class="text-right">'.$this->sma->formatMoney($inv->order_discount) . '</th></tr>';
                }
                
                if ($pos_settings->rounding) { 
                    $round_total = $this->sma->roundNumber($inv->grand_total, $pos_settings->rounding);
                    $rounding = $this->sma->formatMoney($round_total - $inv->grand_total);
                ?>
                    <tr>
                        <th colspan="4"><?= lang("rounding"); ?></th>
                        <th class="text-left"><?= $rounding; ?></th>
                    </tr>
                    <tr>
                        <th colspan="7" class="text-right"><?= lang("net_amount"); ?></th>
                        <th class="text-left"><?= $this->sma->formatMoney($inv->grand_total + $rounding); ?></th>
                    </tr>
					 <tr>
                        <th colspan="4" class="text-right"><?= lang("amount_chargeable_words"); ?></th>
                        <th class="text-left"><?=$this->sma->formatMoney($inv->grand_total + $rounding)?></th>
                    </tr>
                <?php } else { ?>
                    <tr>
                        <th colspan="7" class="text-right"><?= lang("net_amount"); ?></th>		
                        <th class="text-left"><?= $this->sma->formatMoney($inv->grand_total); ?></th>
                    </tr>
					<tr>
                        <th colspan="3" class="text-right"><?= lang("amount_chargeable_words"); ?></th>
                        <th class="text-left" colspan="6"><?=$this->sma->formatMoney($inv->grand_total + $rounding)?></th>
                    </tr>
					<tr>
						<th colspan="9">
							  <?php $this->sma->qrcode('link', urlencode(site_url('pos/view/' . $inv->id)), 2); ?>
							<div class="text-center"><img
									src="<?= base_url() ?>assets/uploads/qrcode<?= $this->session->userdata('user_id') ?>.png"
									alt="<?= $inv->reference_no ?>"/>
							</div>
							<?php $br = $this->sma->save_barcode($inv->reference_no, 'code39'); ?>
							<div class="text-center"><img	src="<?= base_url() ?>assets/uploads/barcode<?= $this->session->userdata('user_id') ?>.png"	alt="<?= $inv->reference_no ?>"/>
							</div>
						</th>
					</tr>
					<tr>
                        <th colspan="9">
							<h5>Declarartion<h5>
							<p class="declaration">1. We declare that this invoice shows the actual price of the goods described and that all particulars are true and correct.</p>
							<p class="declaration">2. We hereby certify that our registration certificate under the Maharastra Value Added Tax Act,2002 is in force on the date on which the sale of the goods specified in this tax invoice is made by us and that the transaction of sale covered by this tax invoice has been effected by us and it shall be accounted for in the turnover of sales while filing of return and the due tax, if any, payable on the sale has been paid or shall be paid.</p>
							<p class="declaration"><strong>3. No refunds, watches can be exchanged within 30 days from the date of purchase.</strong></p>
						</th>
                    </tr>
					<tr>
                        <th colspan="9" class="text-center">
							<p>* This is a computer generated invoice, hence does not require any signature</p>
						</th>
                    </tr>
                <?php }
                if ($inv->paid < $inv->grand_total) { ?>
                    <tr>
                        <th colspan="7"><?= lang("paid_amount"); ?></th>					
                        <th class="text-left" ><?= $this->sma->formatMoney($inv->paid); ?></th>
                    </tr>
                    <tr>
                        <th colspan="7"><?= lang("due_amount"); ?></th>
                        <th class="text-left"><?= $this->sma->formatMoney($inv->grand_total - $inv->paid); ?></th>
                    </tr>
                <?php } ?>
				</tfoot>
		</table>
           
        <?php
		//echo "<pre>";print_r($rows);print_r($tax_summary);die;
        if ($payments) {
            echo '<table class="table table-striped table-condensed"><tbody>';
            foreach ($payments as $payment) {
                echo '<tr>';
                if ($payment->paid_by == 'cash' && $payment->paid) {
                    echo '<td>' . lang("amount") . ': ' . $payment->amount . '</td>';
                    echo '<td>' . lang("change") . ': ' . $this->sma->formatMoney($payment->paid - $inv->total) . '</td>';
                }
                if (($payment->paid_by == 'CC' || $payment->paid_by == 'ppp' || $payment->paid_by == 'stripe') && $payment->cc_no) {
                    echo '<td>' . lang("amount") . ': ' . $payment->amount . '</td>';
                    echo '<td>' . lang("no") . ': ' . 'xxxx xxxx xxxx ' . substr($payment->cc_no, -4) . '</td>';
                    echo '<td>' . lang("name") . ': ' . $payment->cc_holder . '</td>';
                }
                if ($payment->paid_by == 'Cheque' && $payment->cheque_no) {
                    echo '<td>' . lang("amount") . ': ' . $payment->amount . '</td>';
                    echo '<td>' . lang("cheque_no") . ': ' . $payment->cheque_no . '</td>';
                }
                echo '</tr>';
            }
            echo '</tbody></table>';
        }
        ?>

        <p class="text-center">
            <?= $this->sma->decode_html($biller->invoice_footer); ?>
        </p>
        <?php $this->sma->qrcode('link', urlencode(site_url('pos/view/' . $inv->id)), 2); ?>
        <div class="text-center"><img
                src="<?= base_url() ?>assets/uploads/qrcode<?= $this->session->userdata('user_id') ?>.png"
                alt="<?= $inv->reference_no ?>"/></div>
        <?php $br = $this->sma->save_barcode($inv->reference_no, 'code39'); ?>
        <div class="text-center"><img
                src="<?= base_url() ?>assets/uploads/barcode<?= $this->session->userdata('user_id') ?>.png"
                alt="<?= $inv->reference_no ?>"/></div>
        <div style="clear:both;"></div>
    </div>

</div>
</body>
</html>
