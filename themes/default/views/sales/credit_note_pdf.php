<style>
        .stable{
                font-size:11px;
                padding:0px !important;
        }
</style>
<div class="container">         
        <?php if ($gift_card->expiry && $gift_card->expiry < date('Y-m-d')) { ?>
                <div class="alert alert-danger">
                    <?= lang('card_expired') ?>
                </div>
            <?php } else if ($gift_card->balance > 0) { ?>
                <div class="alert alert-info">
                    <?= lang('balance').': '.$Settings->default_currency.' '.$this->sma->formatMoney($gift_card->balance); ?>
                </div>
            <?php } else { ?>
                <div class="alert alert-danger">
                    <?= lang('card_is_used'); ?>
                </div>
            <?php } ?>
        <div class="row" >
            <div class="col-md-12">
                <div class="text-center">
                    <img src="<?= base_url() . 'assets/uploads/logos/' . $biller->logo; ?>" 
                         alt="<?= $biller->company; ?>" style="height:20px;">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 text-center">
                <h5 style="font-weight:bold;"><?= lang('credit_note'); ?></h5>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-responsive table-striped stable">
                    <tr>
                        <td>
                            <p><strong><?= lang("TIN"); ?></strong> : <?php echo $biller->tin_no; ?></p>
                            <p><strong><?= lang("store_name"); ?></strong> : <?php echo $biller->company; ?></p>
                            <p><strong><?= lang("store_address"); ?></strong> : <?php echo $biller->address; ?></p>
                        </td>
                        <td>
                            <?php
                                //echo "<pre>";print_r($sale);
                                /* Updates done by Chitra to modify the receipt format */
                                echo "<p><strong>" . lang("ref") . "</strong> : " . $inv->reference_no . "</p>";
                                echo "<p><strong>" . lang("return_invoice_number") . "</strong> : " 
                                . $inv->sales_reference_no . "</p>";
                                echo "<p><strong>" . lang("return_date") . "</strong> : " 
                                . date("d-M-y", strtotime($inv->date)) . "</p>";
                                echo "<p><strong>" . lang("Invoice Date") . "</strong> : " 
                                . date("d-M-y", strtotime($sale->date)) . "</p>";
                            ?> 
                            
                        </td>
                    </tr>
                    <tr>
                        <td><p><strong><?= lang("customer_name"); ?></strong> : <?php echo $inv->customer; ?></p></td>
                        <td><p><strong><?= lang("customer_contact"); ?></strong> : <?php echo $customer->phone; ?></p></td>
                    </tr>
                </table>  
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered table-responsive table-hover table-striped order-table" style="font-size:10px !important;">
                    <thead>
                        <tr>
                            <th><?= lang("item_code_s"); ?></th>
                            <th><?= lang("price"); ?></th>
                            <th><?= lang("discount") ?></th>
                            <th><?= lang("tax"); ?></th>
                            <th style="padding-right:20px;"><?= lang("subtotal"); ?></th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                        $r = 1;
                       
                        $total_price=0;
                        $total_order_tax=0;
                        $prod_price=0;
                        $prod_tax_rate=0;
                        $pr_tax=0;
                        if (!empty($rows)) {
                            foreach ($rows as $row):
                                $prod_tax_rate = $this->sma->formatMoney($row->tax);
                                $prod_price = $row->subtotal;
                                $total_price+=$row->subtotal;
                                $total_pr_ds+=$row->item_discount;
                                $pr_tax = ($prod_price * $prod_tax_rate) / ((100) + ($prod_tax_rate));
                                $total_order_tax +=($prod_price * $prod_tax_rate) / ((100) + ($prod_tax_rate));
                                if($this->pos_settings->order_discount_type == 'percent'){
                                    $rdis = $row->discount.' %';
                                }
                                else{
                                    $rdis = $this->sma->formatMoney($row->discount);
                                }
                            ?>
                                <tr>
                                    <td style="vertical-align:middle;"><?= $row->product_code; ?>
                                    <td style="text-align:right; width:150px; padding-right:10px;">
                                        <?= $this->sma->formatMoney($row->real_unit_price); ?></td>
                                    <td style="width: 150px; text-align:right; vertical-align:middle;">
                                        <?= ($row->item_discount != 0 ? '<small>(' . $rdis . ')</small>' : '') 
                                        . ' ' . $this->sma->formatMoney($row->item_discount) ?></td>
                                    <td style="width: 150px; text-align:right; vertical-align:middle;">
                                        <?= ($row->item_tax != 0 ? '<small>(' . $this->sma->formatMoney($row->tax) . '%)</small>' : '') 
                                        . ' ' . $this->sma->formatMoney($pr_tax) ?></td>
                                    <td style="text-align:right; width:120px; padding-right:10px;">
                                        <?= $this->sma->formatMoney($row->subtotal); ?></td>
                                </tr>
                                <?php
                                $r++;
                            endforeach;
                        }
                        ?>

                    </tbody>
                    <tfoot>
                        <?php
                        $col = 4;
                        ?>
                        <tr>
                            <td colspan="<?= $col; ?>"
                                style="text-align:right; padding-right:10px;"><?= lang("total"); ?>
                                (<?= $default_currency->code; ?>)
                            </td>
                            <td style="text-align:right; padding-right:10px;">
                                <?= $this->sma->formatMoney($total_price); ?></td>
                        </tr>
                        <?php if($total_pr_ds > 0){ ?>
                        <tr>
                            <td colspan="<?=$col?>" style="text-align:right; padding-right:10px;">
                                <?=lang("discount") . ' (' . $default_currency->code . ')'?></td>
                            <td style="text-align:right; padding-right:10px;">
                                <?=$this->sma->formatMoney($total_pr_ds)?></td>
                        </tr>
                        <?php }
                        else if($inv->order_discount > 0){ ?>
                        <tr>
                            <td colspan="<?=$col?>" style="text-align:right; padding-right:10px;">
                                <?=lang("discount") . ' (' . $default_currency->code . ')'?></td>
                            <td style="text-align:right; padding-right:10px;">
                                <?=$this->sma->formatMoney($inv->order_discount)?></td>
                        </tr>
                        <?php }?>
                        
                        <tr>
                            <td colspan="<?=$col?>" style="text-align:right; padding-right:10px;">
                                <?=lang("order_tax") . ' (' . $default_currency->code . ')'?></td>
                            <td style="text-align:right; padding-right:10px;">
                                    <?=$this->sma->formatMoney($total_order_tax)?></td>
                        </tr>
                        
                        <tr>
                            <td colspan="<?= $col; ?>"
                                style="text-align:right; padding-right:10px; font-weight:bold;">
                            <?= lang("total_amount"); ?>
                                (<?= $default_currency->code; ?>)
                            </td>
                            <td style="text-align:right; padding-right:10px; font-weight:bold;">
                            <?= $this->sma->formatMoney($total_price); ?></td>
                        </tr>
                        <tr>
                            <td colspan="<?= $col; ?>"
                                style="text-align:right; padding-right:10px; font-weight:bold;">
                            <?= lang("Balance Amount"); ?>
                                (<?= $default_currency->code; ?>)
                            </td>
                            <td style="text-align:right; padding-right:10px; font-weight:bold;">
                            <?= $this->sma->formatMoney($credit_note_val->balance); ?></td>
                        </tr>
                        <tr>
                            <td colspan="<?= $col; ?>"
                                style="text-align:right; padding-right:10px; font-weight:bold;">
                            <?= lang("Redeemed Amount"); ?>
                                (<?= $default_currency->code; ?>)
                            </td>
                            <td style="text-align:right; padding-right:10px; font-weight:bold;">
                            <?= $this->sma->formatMoney($credit_note_val->value-$credit_note_val->balance); ?></td>
                        </tr>
                        <tr>
                            <td colspan="2" class="text-left"><?= lang("amount_chargeable_words"); ?></td>
                            <td class="text-left" colspan="4">
                            <?= $this->pos_model->convert_numbers_to_words($total_price) ?></td>
                        </tr>
                        <?php 
                        //echo "<pre>";print_r($credit_note_val);
                        if(isset($credit_note_val)){ ?>
                        <tr>
                            <td colspan="2" class="text-left"><?= lang("credit_note_no"); ?></td>
                            <td class="text-left" colspan="4"><?= $credit_note_val->biller_id.'/'.$credit_note_val->year.'/CN/'.$credit_note_val->card_no; ?></td>
                        </tr>
                        <?php } ?>

                    </tfoot>
                </table>

            </div>
        </div>
        <div class="row" style="font-size:9px;">
            <?php if ($inv->note || $inv->note != "") { ?>
                <div class="col-xs-12">
                    <div class="well well-sm">
                        <p class="bold"><?= lang("note"); ?>:</p>
                        <div><?= $this->sma->decode_html($inv->note); ?></div>
                    </div>
                </div>
            <?php } ?>

            <div class="col-xs-12">
                <div class="well well-sm" style="font-size:9px;">
                    <?php 
                    if($pos->cv_expiry <= 0){
                        echo "<p class='text-center'><strong>Note: This Credit Note has been expired!!</strong></p>";
                    }
                    else { ?>
                    <p>Note :This credit voucher can be redeemed within <?=$pos->cv_expiry;?> days, 
                        (<?= date('d-M-y', strtotime($inv->date . "+".$pos->cv_expiry." days")) ?>) from the date of issue 

                        and can NOT be redeemed for cash.</p>
                    <?php } ?>
                    <p class="text-center">*This is a computer generated invoice, hence does not require any signature.</p>
                </div>

                <div class="well well-sm" style="font-size:9px;">
                    <h6 class="text-center"><strong><?php echo $pos_settings->cf_title3; ?></strong></h6>
                    <p class="text-center declaration"><strong>Registered Office : </strong><?php echo $pos_settings->cf_value3; ?></p>
                    <p class="text-center declaration"><strong><?php echo $pos_settings->cf_title4; ?> : </strong> <?php echo $pos_settings->cf_value4; ?></p>
                    <p class="text-center declaration"><strong><?php echo $pos_settings->cf_title5; ?> : </strong><?php echo $pos_settings->cf_value5; ?></p>
                    <p class="text-center declaration"><strong><?php echo $pos_settings->cf_title6; ?> : </strong><?php echo $pos_settings->cf_value6; ?></p>
                </div>

            </div>
        </div>

   </div>