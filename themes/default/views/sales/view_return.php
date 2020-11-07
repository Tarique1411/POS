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
                max-width: 800px;
                min-width: 700px;
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
                    max-width: 800px;
                    width: 100%;
                    min-width: 700px;
                    margin: 0 auto;
                }
            }
            
            .table>thead>tr>th {
                vertical-align: bottom;
                border-bottom: 0px solid #ddd !important;
            }

            .table>thead>tr>th{
                background-color: white !important;
                
                border-color :#DDDDDD !important;
                color: #333 !important;

            }
            thead { display:table-header-group }
            tfoot { display:table-footer-group }
            
            
/*            
            .declaration{
                font-size:9px;
                font-weight: normal;
            }*/
</style>
<?php $credit_note = isset($credit_note_val)?$credit_note_val:$credit_note; ?>
<div id="wrapper">
    <div class="box">
    <div class="box-header">
        <?php
            if($controller=='1'){
        ?>
         <h2 class="blue"><i class="fa-fw fa fa-file"></i><?= lang("view_credit_note")?></h2>
       
        <?php
            }else{
        ?>
        <h2 class="blue"><i class="fa-fw fa fa-file"></i><?= lang("return_sale_no") . '. ' . $inv->id; ?></h2>
        <?php }
        if ($inv->attachment) { ?>
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
       <!-- <div class="row" >
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
        </div> -->
        <div class="row">
            <div class="col-md-12">
                <table width="100%" style="page-break-before: auto; page-break-after: auto;">
                <tr style="border-bottom: 1px solid #DDDDDD; border-left: 1px solid #DDDDDD; border-top: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD;">
                    <td colspan="2" align="center"><h5 style="font-weight:bold;"><?= lang('credit_note'); ?></h5></td>

                </tr>
                <tr style="border-bottom: 1px solid #DDDDDD; border-left: 1px solid #DDDDDD; border-top: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD;">
                    <td style="font-size: 10px;border-bottom:1px solid #DDDDDD;border-right:1px solid #DDDDDD !important;" width="50%">
                        <div style="padding:10px 10px 10px 10px"> 
                            <p><strong><?= lang("store_name").':'; ?></strong>    <?php echo $biller->company; ?></p>
                            <p style="text-transform: capitalize"><strong><?= lang("store_address").':'; ?></strong>    <?php echo $biller->address."&nbsp;".strtolower($biller->city)."-&nbsp;".$biller->postal_code.",&nbsp;".strtolower($biller->state)?></p>
                            <p style="text-transform: uppercase;"><strong><?= lang("pan_no").':'; ?></strong>    <?php echo $biller->tin_no ?></p>
                            <p style="text-transform: uppercase;"><strong><?= lang("gstin_no").':'; ?></strong>    <?php echo $biller->vat_no?></p>
                            <p><strong><?= lang("supply_place").':'; ?></strong>    <?php echo ucwords(strtolower($biller->state)) ?></p>

                        </div>
                    </td>
                    <td style="font-size: 10px;border-bottom:1px solid #DDDDDD;" valign="top"> 
                        <div style="padding:10px 10px 10px 10px;"> 
                            
                            <p><strong><?= lang("Return_no").':'; ?></strong>    <?php echo $inv->reference_no; ?></p>
                            <p><strong><?= lang("return_date").':'; ?></strong>    <?php echo date($dateFormats['php_sdate'], strtotime($inv->date)); ?></p>
                            <p><strong><?= lang("return_invoice_number").':'; ?></strong>    <?php echo $inv->sales_reference_no; ?></p>  
                            <p><strong><?= lang("Invoice_date").':'; ?></strong>     <?php echo date('d-M-Y  ', strtotime($sale->date)); ?></p>    
                            <p><strong><?= lang("state_code").':'; ?></strong>    <?php echo $biller->state_id ?></p>
                            
                        </div>
                    </td>
                </tr>
                <tr style=" border-left: 1px solid #DDDDDD; border-top: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD;" >
                    <td colspan="" style="padding: 10px 10px 10px 10px;">
                        <div style="float: left;font-size: 10px;width:50%">
                             <p><strong><?= lang("customer_name").':'; ?></strong>   <?php echo $inv->customer;?></p> 
                       </div>
                    </td>
                    <td>
                        <div style="font-size: 10px;padding: 10px 10px 10px 10px;">
                            <p><strong><?= lang("customer_contact").':'; ?></strong>    <?php echo ($inv->sale_status === 'foc') ? $foc_details->mobile:$customer->phone; ?></p> 
                           
                        </div>
                    </td>
                </tr>
                

                <tr style="page-break-before: auto;page-break-after: auto; page-break-inside: auto;" >
                <td colspan="2" >


                    <table class="table table-condensed stable table-responsive " >
                            <thead style="background-color: white !important;border:none !important;page-break-before: auto !important;page-break-after: auto !important; page-break-inside: auto !important;">
                                <tr>
                                    <th rowspan="2" class='text-left' style="border-left: 1px solid #DDDDDD;border-right: 1px solid #DDDDDD; border-bottom: 0px !important;" width="5%">No.</th>
                                    <th rowspan="2" class='text-left' style="border-right: 1px solid #DDDDDD; border-bottom: 0px !important;" width="10%">Reference</th>
                                    <th rowspan="2" rowspan="2" class='text-left' style="border-right: 1px solid #DDDDDD;border-bottom: 0px !important; word-wrap: break-word;" width="5%">Description</th>
                                    <th rowspan="2" class='text-left' style="border-right: 1px solid #DDDDDD;border-bottom: 0px !important;" width="5%">HSN Code</th>
                                    <th rowspan="2" class='text-left' style="border-right: 1px solid #DDDDDD;border-bottom: 0px !important;" width="10%"><?= lang("mrp"); ?><span class="rupee">&#8377;</span></th>
                                    <th rowspan="2" class='text-left' style="border-right: 1px solid #DDDDDD;border-bottom: 0px !important;" width="10%"><?= lang('discount').'&#8377;';?></th> 
                                    <th rowspan="2" class='text-left' style="border-right: 1px solid #DDDDDD;border-bottom: 0px !important;" width="5%"><?= lang("qty"); ?></th>
                                    <th rowspan="2" class='text-left' style="border-right: 1px solid #DDDDDD;border-bottom: 0px !important;" width="10%"><?= lang("price").'&#8377;'; ?></th>
                                    <th class='text-left' style="border-bottom: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD; "  ><?= lang("cgst"); ?></th>
                                    <th class='text-left' style="border-bottom: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD; " width="15%"><?= lang("sgst"); ?></th>
                                    <th rowspan="2" class='text-left' style="border-right: 1px solid #DDDDDD;border-bottom: 1px solid #ffffff" width="15%"><?= lang("total").'&#8377;'; ?></th>
                                    </tr>
                                    <tr >
                                    <td style="padding: 0px !important; border-bottom:1px solid #DDDDDD !important; border-right:1px solid #DDDDDD !important;" >
                                        <table width="100%" style="height: 34px; border:1px solid #ffffff !important;" >
                                            <tr>
                                                <td class='text-left'  style="white-space: nowrap !important; border:solid 0px #ffffff; border-right:1px solid #DDDDDD;" width="50%">
                                                    <div style="padding:6px;"><?= lang("Rate"); ?> %</div>
                                                </td>
                                                <td class='text-left' style=" "> 
                                                    <div style="padding:9px;"><?= lang("Amt").'<b>&#8377;</b>'; ?></div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                     <td style="padding: 0px !important; border-right:1px solid #DDDDDD !important;border-bottom:1px solid #DDDDDD !important;">
                                        <table width="100%" style="height: 34px; border:1px solid #ffffff !important;" >
                                            <tr>
                                                <td style=" white-space: nowrap !important; border-right:1px solid #DDDDDD;" width="50%">
                                                    <div style="padding:6px;"><?= lang("Rate"); ?> %</div>
                                                </td>
                                                <td> 
                                                    <div style="padding:9px;"><?= lang("Amt").'<b>&#8377;</b>'; ?></div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    </tr>
                                    
                                </tr>
                               <!--  <tr>
                                    <th class="text-left"><?= lang("item_code_s"); ?></th>
                                    <th class="text-left"><?= lang("Product_hsn"); ?></th>
                                    <th class="text-left"><?= lang("discount") ?> <span class="rupee">&#8377;</span></th>
                                    <th class="text-left"><?= lang("tax"); ?></th>
                                    <th class="text-right"><?= lang("mrp"); ?> <span class="rupee">&#8377;</span></th>
                                </tr> -->
                            </thead>
                            <tbody>

                                <?php
                                $r = 1;

                                if (!empty($rows)) {
                                    foreach ($rows as $row):
                                        $disc = $row->item_discount;
                                        $prod_tax_rate = $this->sma->formatMoney($row->tax);
                                        $prod_price = $row->subtotal;
                                        $total_order_tax =($prod_price * $prod_tax_rate) / ((100) + ($prod_tax_rate));
                                        if ($this->pos_settings->order_discount_type == 'percent') {
                                            $rdis = $row->discount."%";
                                        }
                                        else{
                                            $rdis = $this->sma->formatMoney($row->discount);
                                        }
                                        $total_items +=$row->quantity;
                                        $total_item_tax += ($total_order_tax/2);
                                        $tax_value[$row->tax] += $total_order_tax/2;
                                        $total_basic_price += $row->net_unit_price;
                                        $total_mrp += $row->subtotal;
                                        $total_disc += $row->item_discount;
                                      /*  echo "<pre>";
                                        print_r($total_order_tax);
                                        //exit;*/
                                        echo '<tr>'
                                        . '<td class="text-left border-right" style="border-left: 1px solid #DDDDDD; border-right: 1px solid #DDDDDD !important; border-bottom: 1px solid #DDDDDD;">' .$r.'</td>'
                                        . '<td class="text-left border-right" style="border-right: 1px solid #DDDDDD !important; border-bottom: 1px solid #DDDDDD;">' .($row->product_code). ($row->variant ? ' (' . $row->variant . ')' : '').'</td>'
                                        . '<td class="text-left border-right" style="width:20%; border-right: 1px solid #DDDDDD !important; border-bottom: 1px solid #DDDDDD; word-break: break-all;">'.$row->product_name.'</td>'
                                        . '<td class="text-left border-right"  style="width:20%; border-right: 1px solid #DDDDDD !important; border-bottom: 1px solid #DDDDDD;">'.$row->hsn.'</td>'
                                        .'<td class="text-left border-right"  style="width:20%; border-right: 1px solid #DDDDDD !important;border-bottom: 1px solid #DDDDDD;">'.$this->sma->formatMoney($row->price).'</td>'
                                        . '<td class="text-left border-right"  style="width:20%; border-right: 1px solid #DDDDDD !important;border-bottom: 1px solid #DDDDDD;">' .$this->sma->formatMoney($disc). '</td>';
                                         echo '<td class="text-left border-right"  style="width:20%; border-right: 1px solid #DDDDDD !important; border-bottom: 1px solid #DDDDDD;">' .round($row->quantity). '</td>'
                                        .'<td class="text-left"  style="border-right: 1px solid #DDDDDD;border-bottom: 1px solid #DDDDDD;">'.$this->sma->formatMoney($row->net_unit_price).'</td>'
                                        . '<td class="" style="border-right: 1px solid #DDDDDD; padding:0px !important;">
            <table width="100%" style="height: 51px; border:0px !important;">
                <tr> 
                    <td class="" width="50%" style=" border-right: 1px solid #DDDDDD;padding-left:6px!important;">'.round($row->item_tax/2).'</td>'
                . '<td class="" style="border-left:0px !important; border-top:0px !important; border-bottom:0px !important;padding-left:6px!important;">'.$this->sma->formatMoney($total_order_tax/2).'</td>
                </tr>
            </table>
                                            </td>'
                                       . '<td class="" style="padding:0px !important;  border-bottom:1px solid #DDDDDD; border-right:1px solid #DDDDDD;">
            <table width="100%" style="height: 51px; border:0px !important;">
                <tr>
                <td class="" width="50%" style=" border-right:1px solid #DDDDDD;padding-left:6px!important; ">'.round($row->item_tax/2).'</td>'
            . '<td class="" style="padding-left:6px!important; ">'.$this->sma->formatMoney($total_order_tax/2).'</td>
                </tr>
            </table>
                                            </td>'
                                       
                //                        . '<td class="text-left">' . $prod_amount . '</td>'
                                        .'<td class="" style="text-align:left;border-right: 1px solid #DDDDDD !important;border-bottom: 1px solid #DDDDDD;">'.$this->sma->formatMoney($row->price-$row->item_discount).'</td>'
                                        . '</tr>';

                                    ?>
                                     


                                        <!-- <tr>
                                            <td style="vertical-align:middle;"><?= $row->product_code; ?>
                                            <td style="text-align:right; width:150px; padding-right:10px;">
                                               
                                                <?=$row->hsn;?>
                                            </td>
                                            <td style="width: 150px; text-align:right; vertical-align:middle;">
                                                        <?= ($row->item_discount != 0 ? '<small>(' . $rdis . ')</small>' : '') . ' ' . $this->sma->formatMoney($row->item_discount) ?></td>
                                            <td style="width: 150px; text-align:right; vertical-align:middle;">
                                                <?= ($row->item_tax != 0 ? '<span class="rupee">&#8377;</span>' . $this->sma->formatMoney($row->subtotal-$row->real_unit_price) . '' : '') . ' (' .$this->sma->formatMoney($row->tax).'%)' ?></td>
                                            <td style="text-align:right; width:120px; padding-right:10px;">
                                                        <?= $this->sma->formatMoney($row->price); ?></td>
                                        </tr> -->
                                        <?php
                                        $r++;
                                    endforeach;
                                }
                                ?>
                                <tr ><td colspan="11" height="20px;" style="border-right: 1px solid #DDDDDD !important;border-left: 1px solid #DDDDDD!important;">&nbsp;</td></tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="3" style="border-left: 1px solid #DDDDDD; border-right:0px !important;border-bottom: 1px solid #DDDDDD;  " class="text-left"></th>
                                    <th colspan="" class="text-left" style="border-bottom: 1px solid #DDDDDD;"><?= lang("total").'&#8377;'; ?>&nbsp;<!-- <span class="rupee">&#8377;</span> --></th>
                                    <th class='text-left' style="border-bottom: 1px solid #DDDDDD;"><?=$this->sma->formatMoney($inv->grand_total + $inv->total_discount)?></th>
                                    <th colspan="" class="text-left" style="border-bottom: 1px solid #DDDDDD;"><?= $this->sma->formatMoney($total_disc)?></th> 
                                    <!--th style="border:0px !important;"></th-->
                                    <!--th style="border:none"><?= $inv->product_discount;?></th-->
                                    
                                    <th style="border-bottom: 1px solid #DDDDDD;"><?php echo intval($total_items)?></th>
                                    <th style="border-bottom: 1px solid #DDDDDD;"><?=$this->sma->formatMoney($total_basic_price)?></th>
                                    <th style="border-bottom: 1px solid #DDDDDD;">
                                        <table  width="100%" style="border:none">
                                            <tr>
                                                <td style="border:0px !important;border-right: 1px solid #DDDDDD;" width="50%">&nbsp;</td>
                                                <td style="border:0px !important;border-right: 1px solid #DDDDDD;padding-left:6px!important;" class="text-left"><?=$this->sma->formatMoney($total_item_tax)?>
                                                </td>
                                            </tr>
                                        </table>
                                    </th>
                                    
                                    <th style="border-bottom: 1px solid #DDDDDD;"><table width="100%" style="border:none">
                                            <tr>
                                                <td style="border:0px !important;border-right: 1px solid #DDDDDD;" width="50%">&nbsp;</td>
                                                <td style="border:0px !important;border-right: 1px solid #DDDDDD;padding-left:6px!important;" class="text-left"><?=$this->sma->formatMoney($total_item_tax)?>
                                                </td>
                                            </tr>
                                        </table></th>
                                    <th class='text-left border-right' style="border-right: 1px solid #DDDDDD !important; border-left:0px !important;border-bottom: 1px solid #DDDDDD;"><?php echo $this->sma->formatMoney(round($inv->grand_total))?></th>
                                    <!--<th class="text-right"><?=$this->sma->formatMoney($inv->total + $inv->product_tax)?></th>-->
                                </tr>

                                <?php
                                $col = 4;
                                ?>
                                <!-- <tr>
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
                                </tr> -->
                                
                                <td colspan="11" align="center" style="border:none;border-right: 1px solid #DDDDDD !important;border-left: 1px solid #DDDDDD!important;">
                                    <table width="35%" align="center" style="float:right" border="0">
                                        <tr>
                                            <td width="60%" style="border:0px !important;"><span><?= lang("taxable_amount").'<b>&#8377;</b>'; ?></span></td> <td  align="right" style="border:0px !important;"><?=$this->sma->formatMoney($total_basic_price)?> </td>
                                        </tr>
                                        <?php foreach($tax_value as $keys=>$rows){
                                        ?>
                                        <tr>
                                            <td style="border:0px !important;"><?= lang("sgst"); ?>@ <?php echo round($keys/2)?> %</td><td  align="right" style="border:0px !important;"><?php echo $this->sma->formatMoney($rows)?></td>
                                        </tr>
                                        <tr>
                                            <td style="border:0px !important;"><?= lang("cgst"); ?>@ <?php echo round($keys/2)?> % </td><td style="border:0px !important;"  align="right"><?php echo $this->sma->formatMoney($rows)?></td>
                                        </tr>
                                        <?php 
                                        }
                                        ?>
                                        <tr>
                                            <td style="border:0px !important;"><?= lang("total_amount").'<b>&#8377;</b>'; ?> </td><td style="border:0px !important;"  align="right"><?php echo $this->sma->formatMoney(round($total_mrp))?></td>
                                        </tr>
                                        <!-- <tr>
                                            <td><?= lang("redeemed_amt"); ?></td><td><?php echo $this->sma->formatMoney($credit_note->value-$credit_note->balance); ?></td>
                                        </tr>
                                        <tr>
                                            <td><?= lang("balance_amount"); ?></td><td><?php echo $this->sma->formatMoney($credit_note->balance)?></td>
                                        </tr> -->
                                         <!-- <?php if(isset($credit_note)){ ?>
                                        <tr>
                                            <td colspan="2" class="text-left"><?= lang("credit_note_no"); ?></td>
                                            <td class="text-left" colspan="4"><?= $credit_note->card; ?></td>
                                        </tr>
                                        <?php } ?> -->
                                        
                                    </table>
                                    


                                </td>
                            </tr>
                              <tr style="border-bottom:1px solid #DDDDDD;border-top:1px solid #DDDDDD">
                                <th colspan="11" class="text-left" style="font-size: 13px;border-right: 1px solid #DDDDDD !important;border-left: 1px solid #DDDDDD!important;"><span><?= lang("amount_chargeable_words").':'; ?> </span>  
                                    <?php  echo ucwords($this->pos_model->convert_numbers_to_words($total_mrp));?>
                                </th>
                            </tr>

                               <!--  <tr>
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
                                </tr> -->
                               <?php if ($inv->note || $inv->note != "") { ?>
                                <tr>
                                    <th colspan="11" style="border-bottom: none !important;">
                                        
                                            <div class="col-xs-12">
                                                <div class="well">
                                                    <p class="bold"><?= lang("note"); ?> : <?= $this->sma->decode_html($inv->note); ?></p>
                                                    
                                                </div>
                                            </div>
                                       
                                    </th>
                                </tr>
                                 <?php } 
                                        //echo "<pre>";print_r($pos);
                                        ?>
                                <?php if(!empty($redemption_details)):?>
                                <tr>
                                    <th colspan="11" style="border-right: 1px solid #DDDDDD !important;border-left: 1px solid #DDDDDD!important;">
                                        Redemption Details:<br/>
                                        <?php foreach ($redemption_details as $redemption_detail):?>
                                            Invoice No.: <?= $redemption_detail->reference_no ?> &nbsp;&nbsp;&nbsp;&nbsp; Amount: <?= $redemption_detail->paid ?> <br/>
                                        <?php endforeach;?>
                                    </th>
                                </tr>
                                <?php endif; ?>
                                 <tr>
                                     
                                    <th colspan="5" style="border-right: 1px solid #DDDDDD !important;border-left: 1px solid #DDDDDD!important;"><?= lang("redeemed_amt").':'; ?> <?php echo $this->sma->formatMoney($credit_note->value-$credit_note->balance); ?>
                                    </th>
                                     <th colspan="6" style="border-right: 1px solid #DDDDDD !important;border-left: 1px solid #DDDDDD!important;"><?= lang("balance_amount").':'; ?>  <?php echo $this->sma->formatMoney($credit_note->balance)?></th>
                                </tr>
                                <tr>
                                    <th colspan="11" style="border-right: 1px solid #DDDDDD !important;border-left: 1px solid #DDDDDD!important;">
                                       <!--   <div class="well well-sm"> -->
                                            <?php 
                                            if($pos->cv_expiry <= 0){
                                                echo "<p class='text-center'><strong>Note: This Credit Note has been expired!!</strong></p>";
                                            }
                                            else{ ?>
                                            <p>Note: This credit voucher can be redeemed latest by  <?= date('d-M-Y', strtotime($inv->date . "+".$inv->return_time." days")) ?>.</p>
                                            <?php } ?>
                                            
                                            <p style="text-align: right;padding-right:30px;">
                                                      <img height="50" width="100" src="<?= base_url() . 'assets/images/Pavan Sign_001.jpg'?>" />
                                                    </p>
                                            <p style="text-align: right;padding-right:30px;">
                                             (Authorised Signatory)
                                            </p>
                                            <p style="text-align:right;">Swatch Group (India) Retail Pvt. Ltd. </p>
                                            
                                        <!-- </div> -->

                                    </th>
                                </tr>
                                <tr style="border:0px !important; border-left:#ffffff solid 1px !important; border-right:#ffffff solid 1px !important;">
                                    <td colspan="11" style=" border-left:0px !important; border-right:0px !important;"> &nbsp;</td>
                                </tr>
                                <tr style="height:100%; border-right: 1px solid #DDDDDD !important;border-left: 1px solid #DDDDDD!important; border-bottom: 1px solid #DDDDDD!important;" >
                                    <th colspan="11" >
<!--                                    <div class="well well-sm" style="font-size:9px !important;">-->
            <div >
            <h6 class="text-center"><strong><?=$pos_settings->cf_title3?></strong></h6>
            <p class="text-center declaration"><strong>Registered Office: </strong> <?=$pos_settings->cf_value3?></p>
            <p class="text-center declaration"><strong><?=$pos_settings->cf_title4?>: </strong><?=$pos_settings->cf_value4?></p>
            <p class="text-center declaration"><strong><?=$pos_settings->cf_title5?>: </strong><?=$pos_settings->cf_value5?></p>
            <p class="text-center declaration"><strong><?=$pos_settings->cf_title6?>: </strong><?=$pos_settings->cf_value6?></p>
        </div>
                    </th>
                                </tr>
                            </tfoot>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>

            </div>
        </div>
       
       
<!--         <div class="well well-sm" style="font-size:9px !important;">
            <h6 class="text-center"><strong><?=$pos_settings->cf_title3?></strong></h6>
            <p class="text-center declaration"><strong>Registered Office: </strong> <?=$pos_settings->cf_value3?></p>
            <p class="text-center declaration"><strong><?=$pos_settings->cf_title4?>: </strong><?=$pos_settings->cf_value4?></p>
            <p class="text-center declaration"><strong><?=$pos_settings->cf_title5?>: </strong><?=$pos_settings->cf_value5?></p>
            <p class="text-center declaration"><strong><?=$pos_settings->cf_title6?>: </strong><?=$pos_settings->cf_value6?></p>
        </div>-->

         <div class="row">
             <?php if ($credit_note->balance > 0) { ?>
            <button type="button" class="btn btn-primary btn-block no-print" onClick="window.print();"><?= lang('print'); ?></button>
            <?php } ?>
        </div>
    </div>
</div>
</div>



