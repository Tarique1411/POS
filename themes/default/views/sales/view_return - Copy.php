<script type="text/javascript">
    $(document).ready(function () {    
        //javascript:window.print();
        
        $(document).on('click', '.sledit', function (e) {
            if (localStorage.getItem('slitems')) {
                e.preventDefault();
                var href = $(this).attr('href');
                bootbox.confirm("<?=lang('you_will_loss_sale_data')?>", function (result) {
                    if (result) {
                        window.location.href = href;
                    }
                });
            }
        });
    });
</script>

<style type="text/css" media="all">
            body {
                color: #000;
                font-size: 11px;
            }
            p{
                font-size: 11px;
            }
            .box-content{width:auto;}
            hr{
                margin: 0px;
            }
            .table{
                line-height:0.1em !important;
            }
            
            .stable{
                font-size:10px;
                padding:0px !important;
            }
            
            .space{margin-bottom: 5px;}

            #wrapper {
                max-width: 300px;
                min-width: 250px;
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
                    max-width: 300px;
                    width: 100%;
                    min-width: 250px;
                    margin: 0 auto;
                }
            }
/*            
            .declaration{
                font-size:9px;
                font-weight: normal;
            }*/
</style>
<div id="wrapper">
    <div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-file"></i><?= lang("return_sale_no") . '. ' . $inv->id; ?></h2>
        <?php if ($inv->attachment) { ?>
        <div class="box-icon">
            <ul class="btn-tasks">
                <li class="dropdown">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <i class="icon fa fa-tasks tip" data-placement="left" title="<?= lang("actions") ?>"></i>
                    </a>
                    <ul class="dropdown-menu pull-right" class="tasks-menus" role="menu" aria-labelledby="dLabel">
                        <li>
                            <a href="<?= site_url('welcome/download/' . $inv->attachment) ?>">
                                <i class="fa fa-chain"></i> <?= lang('attachment') ?>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        <?php } ?>
    </div>
    
    <div class="box-content">
        <div class="row" >
            <div class="col-lg-12">
                <div class="text-center">
                    <img src="<?= base_url() . 'assets/uploads/logos/' . $biller->logo; ?>" 
                         alt="<?= $biller->company; ?>" style="height:20px;">
                </div>
            </div>
            
            <div class="col-md-12 col-sm-12 text-center">
                <h5 style="font-weight:bold;"><?= lang('credit_note'); ?></h5>
            </div>
            
            <div class="col-md-12 col-sm-12 space">            
                <strong><?= lang("store_name"); ?></strong> : <?php echo $biller->company; ?>
            </div>
            <div class="col-md-12 col-sm-12 space">  
                    <strong><?= lang("store_address"); ?></strong> : <?php echo $biller->address.', TIN NO: '.$biller->tin_no; ?>
            </div>
            <div class="col-md-12 col-sm-12 space">  
                    <strong><?= lang("Return_no"); ?></strong> : <?php echo $inv->reference_no; ?>
            </div>
             <div class="col-md-12 col-sm-12 space">  
                    <strong><?= lang("return_date"); ?></strong> : <?php echo date($dateFormats['php_sdate'], strtotime($inv->date)); ?>
            </div>
            <div class="col-md-12 col-sm-12 space">  
                    <strong><?= lang("return_invoice_number"); ?></strong> : <?php echo $inv->sales_reference_no; ?>
            </div>          
            <div class="col-md-12 col-sm-12 space">  
                    <strong><?= lang("Invoice_date"); ?></strong> : <?php echo date($dateFormats['php_sdate'], strtotime($sale->date));; ?>
            </div>  
            <div class="col-md-12 col-sm-12 space">
                <strong><?= lang("customer_name"); ?></strong> : <?php echo $inv->customer; ?>
            </div>    
            <div class="col-md-12 col-sm-12 space">
                <strong><?= lang("customer_contact"); ?></strong> : <?php echo $customer->phone; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered table-condensed table-striped stable table-responsive">
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

                        if (!empty($rows)) {
                            foreach ($rows as $row):
                                $prod_tax_rate = $this->sma->formatMoney($row->tax);
                                $prod_price = $row->subtotal;
                                $total_order_tax +=($prod_price * $prod_tax_rate) / ((100) + ($prod_tax_rate));
                                if ($this->pos_settings->order_discount_type == 'percent') {
                                    $rdis = $row->discount."%";
                                }
                                else{
                                    $rdis = $this->sma->formatMoney($row->discount);
                                }
                                
                            ?>
                                <tr>
                                    <td style="vertical-align:middle;"><?= $row->product_code; ?>
                                    <td style="text-align:right; width:150px; padding-right:10px;">
                                        <!--<?= $this->sma->formatMoney($row->net_unit_price + ($row->item_tax / $row->quantity)); ?>-->
                                        <?=$row->hsn;?>
                                    </td>
                                    <td style="width: 150px; text-align:right; vertical-align:middle;">
                                                <?= ($row->item_discount != 0 ? '<small>(' . $rdis . ')</small>' : '') . ' ' . $this->sma->formatMoney($row->item_discount) ?></td>
                                    <td style="width: 150px; text-align:right; vertical-align:middle;">
                                        <?= ($row->item_tax != 0 ? '<span class="rupee">&#8377;</span>' . $this->sma->formatMoney($row->subtotal-$row->real_unit_price) . '' : '') . ' (' .$this->sma->formatMoney($row->tax).'%)' ?></td>
                                    <td style="text-align:right; width:120px; padding-right:10px;">
                                                <?= $this->sma->formatMoney($row->price); ?></td>
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
                            <td style="text-align:right; padding-right:10px;"><?= $this->sma->formatMoney($inv->total + $inv->product_tax); ?></td>
                        </tr>
                        
                        <tr>
                            <td colspan="<?=$col?>" style="text-align:left; padding-right:10px;;">
                                    <?=lang("discount") . ' (<span class="rupee">&#8377;</span>)'?></td>
                            <td style="text-align:right; padding-right:10px;">
                                    <?=$this->sma->formatMoney($inv->total_discount)?></td>
                        </tr>
                        
                        <tr>
                            <td colspan="<?=$col?>" style="text-align:left; padding-right:10px;;">
                                <?=lang("tax_amount") . ' (<span class="rupee">&#8377;</span>)'?></td>
                            <td style="text-align:right; padding-right:10px;">
                                    <?=$this->sma->formatMoney($total_order_tax)?></td>
                        </tr>
                        
                        <tr>
                            <td colspan="<?= $col; ?>"
                                style="text-align:left; padding-right:10px; font-weight:bold;"><?= lang("total_amount"); ?>
                                (<span class="rupee">&#8377;</span>)
                            </td>
                            <td style="text-align:right; padding-right:10px; font-weight:bold;">
                                <?= $this->sma->formatMoney(round($inv->grand_total)); ?></td>
                        </tr>
                              <tr>
                            <td colspan="<?= $col; ?>"
                                style="text-align:left; padding-right:10px; font-weight:bold;">
                            <?= lang("Balance Amount"); ?>
                                (<span class="rupee">&#8377;</span>)
                            </td>
                            <td style="text-align:right; padding-right:10px; font-weight:bold;">
                            <?= $this->sma->formatMoney($credit_note->balance); ?></td>
                        </tr>
                        <tr>
                            <td colspan="<?= $col; ?>"
                                style="text-align:left; padding-right:10px; font-weight:bold;">
                            <?= lang("Redeemed Amount"); ?>
                                (<span class="rupee">&#8377;</span>)
                            </td>
                            <td style="text-align:right; padding-right:10px; font-weight:bold;">
                            <?= $this->sma->formatMoney($credit_note->value-$credit_note->balance); ?></td>
                        </tr>
                        <tr>
                            <td colspan="2" class="text-left"><?= lang("credit_note_amount"); ?></td>
                            <td class="text-left" colspan="4">
                                <?= ucwords($this->pos_model->convert_numbers_to_words(round($inv->grand_total))) ?></td>
                        </tr>
                        <?php if(isset($credit_note)){ ?>
                        <tr>
                            <td colspan="2" class="text-left"><?= lang("credit_note_no"); ?></td>
                            <td class="text-left" colspan="4"><?= $credit_note->card; ?></td>
                        </tr>
                        <?php } ?>

                    </tfoot>
                </table>

            </div>
        </div>
        <div class="row">
            <?php if ($inv->note || $inv->note != "") { ?>
                <div class="col-xs-12">
                    <div class="well">
                        <p class="bold"><?= lang("note"); ?> : <?= $this->sma->decode_html($inv->note); ?></p>
                        
                    </div>
                </div>
            <?php } 
            //echo "<pre>";print_r($pos);
            ?>

            <div class="col-xs-12">
                <div class="well well-sm">
                    <?php 
                    if($pos->cv_expiry <= 0){
                        echo "<p class='text-center'><strong>Note: This Credit Note has been expired!!</strong></p>";
                    }
                    else{ ?>
                    <p>Note :This credit voucher can be redeemed within <?=$pos->cv_expiry;?> days, 
                        (<?= date($dateFormats['php_sdate'], strtotime($inv->date . "+".$inv->return_time." days")) ?>) from the date of issue 
                        and can NOT be redeemed for cash.</p>
                    <?php } ?>
                    <p class="text-center">*This is a computer generated invoice, hence does not require any signature.</p>
                </div>

                <div class="well well-sm" style="font-size:9px;">
                    <h6 class="text-center"><strong><?php echo $pos->cf_title3; ?></strong></h6>
                    <p class="text-center declaration"><strong>Registered Office : </strong><?php echo $pos->cf_value3; ?></p>
                    <p class="text-center declaration"><strong><?php echo $pos->cf_title4; ?> : </strong> <?php echo $pos->cf_value4; ?></p>
                    <p class="text-center declaration"><strong><?php echo $pos->cf_title5; ?> : </strong><?php echo $pos->cf_value5; ?></p>
                    <p class="text-center declaration"><strong><?php echo $pos->cf_title6; ?> : </strong><?php echo $pos->cf_value6; ?></p>
                </div>

            </div>
        </div>
        <div class="row">
             <?php if ($credit_note->balance > 0) { ?>
            <button type="button" class="btn btn-primary btn-block no-print" onClick="window.print();"><?= lang('print'); ?></button>
            <?php } ?>
        </div>
    </div>
</div>
</div>



