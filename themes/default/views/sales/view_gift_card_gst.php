<style>p {
    margin: 0 0 5px;
}</style>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header no-print">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-2x">&times;</i>
            </button>
            <h4 class="modal-title" id="myModalLabel"><?= lang('view_credit_note'); ?></h4>
        </div>
        <div class="modal-body">
            <div class="no-print">
                <?php if ($gift_card->expiry && $gift_card->expiry < date('Y-m-d')) { ?>
                    <div class="alert alert-danger">
                        <?= lang('card_expired') ?>
                    </div>
                <?php } else if ($gift_card->balance > 0) { ?>
                    <div class="alert alert-info">
                        <?= lang('balance').': <span class="rupee">&#8377;</span> '.$this->sma->formatMoney($gift_card->balance); ?>
                    </div>
                <?php } else { ?>
                    <div class="alert alert-danger">
                        <?= lang('card_is_used'); ?>
                    </div>
                <?php } ?>
            </div>
            <div class="row" >
                <div class="col-lg-12 col-md-12">
                    <div class="text-center">
                        <img src="<?= base_url() . 'assets/uploads/logos/' . $biller->logo; ?>" 
                             alt="<?= $biller->company; ?>" style="height:20px;">
                    </div>
                </div>

                <div class="col-md-12 col-sm-12 text-center">
                    <h5 style="font-weight:bold;"><?= lang('credit_note'); ?></h5>
                </div>
                <div class="col-md-12 col-sm-12 text-left" style="font-size:10px;">
                    <p><strong><?= lang("store_name"); ?></strong> : <?php echo $biller->company; ?></p>
                </div>
                <div class="col-md-12 col-sm-12 text-left" style="font-size:10px;">
                    <p><strong><?= lang("store_address"); ?></strong> : <?php echo $biller->address. ' TIN-NO '.$biller->tin_no;; ?></p>
                </div>
                <div class="col-md-12 col-sm-12 text-left" style="font-size:10px;">
                    <p><strong><?= lang("Return_no"); ?></strong> : <?php echo $inv->reference_no; ?></p>
                </div>
                <div class="col-md-12 col-sm-12 text-left" style="font-size:10px;">
                     <p><strong><?= lang("return_date"); ?></strong> : <?php echo date($dateFormats['php_sdate'], strtotime($inv->date)); ?></p>
                </div>
                 <div class="col-md-12 col-sm-12 text-left" style="font-size:10px;">
                     <p><strong><?= lang("return_invoice_number"); ?></strong> : <?php echo $inv->sales_reference_no; ?></p>
                </div>
                 
                 <div class="col-md-12 col-sm-12 text-left" style="font-size:10px;">
                     <p><strong><?= lang("Invoice Date"); ?></strong> : <?php echo date($dateFormats['php_sdate'], strtotime($sale->date)); ?></p>
                </div>
                <div class="col-md-12 col-sm-12 text-left" style="font-size:10px;">
                    <p><strong><?= lang("customer_name"); ?></strong> : <?php echo $inv->customer; ?></p>
                </div>
                <div class="col-md-6 col-sm-12 text-left" style="font-size:10px;">
                    <p><strong><?= lang("customer_contact"); ?></strong> : <?php echo $customer->phone; ?></p>
                </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered table-hover table-striped order-table" style="font-size:10px !important;">
                    <thead>
                        <tr>
                            <th class="text-left"><?= lang("item_code_s"); ?></th>
                            <th class="text-left"><?= lang("Product_hsn"); ?></th>
                            <th class="text-left"><?= lang("discount") ?> <span class="rupee">&#8377;</span></th>
                            <th class="text-left"><?= lang("tax"); ?></th>
                            <th class="text-right"><?= lang("mrp"); ?> <span class="rupee">&#8377;</span></th>
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
                                    <td style="text-align:left; width:150px; padding-right:10px;">
                                        <?= $row->hsn; ?></td>
                                    <td style="width: 150px; text-align:left; vertical-align:middle;">
                                        <?= ($row->item_discount != 0 ? '<small>(' . $rdis . ')</small>' : '') 
                                        . ' ' . $this->sma->formatMoney($row->item_discount) ?></td>
                                    <td style="width: 150px; text-align:left; vertical-align:middle;">
                                        <?= ($row->item_tax != 0 ? '<span class="rupee">&#8377;</span> ' . $this->sma->formatMoney($pr_tax) . '' : '') 
                                        . ' (' . $this->sma->formatMoney($row->tax).'%)' ?></td>
                                    <td style="text-align:right; width:120px; ">
                                        <?=$this->sma->formatMoney($row->price); ?></td>
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
                                style="text-align:left; padding-right:10px;"><?= lang("total"); ?>
                                (<span class="rupee">&#8377;</span>)
                            </td>
                            <td style="text-align:right; padding-right:10px;">
                                <?= $this->sma->formatMoney($total_price); ?></td>
                        </tr>
                        <?php if($total_pr_ds > 0){ ?>
                        <tr>
                            <td colspan="<?=$col?>" style="text-align:left; padding-right:10px;">
                                <?=lang("discount") . ' (<span class="rupee">&#8377;</span>)'?></td>
                            <td style="text-align:right; padding-right:10px;">
                               <?=$this->sma->formatMoney($total_pr_ds)?></td>
                        </tr>
                        <?php }
                        else if($inv->order_discount > 0){ ?>
                        <tr>
                            <td colspan="<?=$col?>" style="text-align:left; padding-right:10px;">
                                <?=lang("discount") . ' (<span class="rupee">&#8377;</span>)'?></td>
                            <td style="text-align:right; padding-right:10px;">
                                 <?=$this->sma->formatMoney($inv->order_discount)?></td>
                        </tr>
                        <?php }?>
                        
                        <tr>
                            <td colspan="<?=$col?>" style="text-align:left; padding-right:10px;">
                                <?=lang("tax_amount") . ' (<span class="rupee">&#8377;</span>)'?></td>
                            <td style="text-align:right; padding-right:10px;">
                                     <?=$this->sma->formatMoney($total_order_tax)?></td>
                        </tr>
                        
                        <tr>
                            <td colspan="<?= $col; ?>"
                                style="text-align:left; padding-right:10px; font-weight:bold;">
                            <?= lang("total_amount"); ?>
                                (<span class="rupee">&#8377;</span>)
                            </td>
                            <td style="text-align:right; padding-right:10px; font-weight:bold;">
                            <?= $this->sma->formatMoney(round($total_price,0)); ?></td>
                        </tr>
                        <tr>
                            <td colspan="<?= $col; ?>"
                                style="text-align:left; padding-right:10px; font-weight:bold;">
                            <?= lang("Balance Amount"); ?>
                                (<span class="rupee">&#8377;</span>)
                            </td>
                            <td style="text-align:right; padding-right:10px; font-weight:bold;">
                            <?= $this->sma->formatMoney($credit_note_val->balance); ?></td>
                        </tr>
                        <tr>
                            <td colspan="<?= $col; ?>"
                                style="text-align:left; padding-right:10px; font-weight:bold;">
                            <?= lang("Redeemed Amount"); ?>
                                (<span class="rupee">&#8377;</span>)
                            </td>
                            <td style="text-align:right; padding-right:10px; font-weight:bold;">
                            <?= $this->sma->formatMoney($credit_note_val->value-$credit_note_val->balance); ?></td>
                        </tr>
                        <tr>
                            <td colspan="2" class="text-left"><?= lang("credit_note_amount"); ?></td>
                            <td class="text-left" colspan="4">
                            <?= ucwords($this->pos_model->convert_numbers_to_words($total_price)) ?></td>
                        </tr>
                        <?php 
                        //echo "<pre>";print_r($credit_note_val);
                        if(isset($credit_note_val)){ ?>
                        <tr>
                            <td colspan="2" class="text-left"><?= lang("credit_note_no"); ?></td>
                            <td class="text-left" colspan="4"><?= $credit_note_val->biller_id.'/CN/'.$credit_note_val->card_no; ?></td>
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
                    <p>Note :This credit Note can be redeemed within <?=$pos->cv_expiry;?> days, 
                        (<?= date($dateFormats['php_sdate'], strtotime($inv->date . "+".$pos->cv_expiry." days")) ?>) from the date of issue 

                        and can NOT be redeemed for cash.</p>
                    <?php } ?>
                    <p class="text-center">*This is a computer generated invoice, hence does not require any signature.</p>
                </div>

                <div class="well well-sm" style="font-size:9px !important;">
                    <h6 class="text-center"><strong><?=$pos_settings->cf_title3?></strong></h6>
                    <p class="text-center declaration"><strong>Registered Office : </strong> <?=$pos_settings->cf_value3?></p>
                    <p class="text-center declaration"><strong><?=$pos_settings->cf_title4?> : </strong><?=$pos_settings->cf_value4?></p>
                    <p class="text-center declaration"><strong><?=$pos_settings->cf_title5?> : </strong><?=$pos_settings->cf_value5?></p>
                    <p class="text-center declaration"><strong><?=$pos_settings->cf_title6?> : </strong><?=$pos_settings->cf_value6?></p>
                </div>
                

            </div>
        </div>
            <div class="clearfix"></div>
            <?php if ($gift_card->balance > 0 && (!$gift_card->expiry || $gift_card->expiry > date('Y-m-d'))) { ?>
            <button type="button" class="btn btn-primary btn-block no-print" onClick="window.print();"><?= lang('print'); ?></button>
            <?php } ?>
        </div>
    </div>
</div>
