<?php //
function product_name($name)
{
    return character_limiter($name, (isset($pos_settings->char_per_line) ? ($pos_settings->char_per_line-8) : 35));
}

 ?>
        <div class="modal-dialog no-modal-header" style="width:580px">
            <div class="modal-content" style="padding:7px;">
                <div class="modal-body">
                    <button class="close" type="button" data-dismiss="modal" aria-hidden="true">
                        <i class="fa fa-2x">×</i>
                    </button>
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
                                <div class="row" style="width:100%;height:90px;">
                                    <div class="text-left textleft"><img src="<?= base_url() . 'assets/uploads/logos/logo.png'; ?>" alt="<?= $biller->company; ?>" height="50px;"></div>
                                    <div class="text-center textcenter"></div>
                                    <div class="text-left textright"><h2><?= lang('z_report'); ?></h2></div>
                                </div>

                                <div class="row receipthead">
                                    <div class="text-center">
                                        <table class="table table-striped table-condensed no-bg" style="border:1px solid #dbdbdb;" cellspacing="0" cellpadding="0">
                                            <tbody>

                                                <?php
                                                $r = 1;
                                                foreach ($rows as $row) {
                                                    ?>
                                                    <tr>
                                                        <td class="text-left"><strong><?= lang("report_date"); ?></strong></td>
                                                        <td class="text-left"><?php echo date($dateFormats['php_sdate'], strtotime("now")); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left"><strong><?= lang("report_time"); ?></strong></td>
                                                        <td class="text-left"><?php echo date("H:i:s", strtotime("now")); ?></td>
                                                    </tr>
                                                    <tr><td colspan='2'><br></td></tr>
                                                    <tr>
                                                        <td class="text-left"><strong><?= lang("shift_no"); ?></strong></td>
                                                        <td class="text-left"><?php echo $row->id; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left"><strong><?= lang("shift_status"); ?></strong></td>
                                                        <td class="text-left"><?php echo ucwords($row->shift_status); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left"><strong><?= lang("shift_s_date"); ?></strong></td>
                                                        <td class='text-left'><?php echo date($dateFormats['php_sdate'], strtotime($row->s_date)); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left"><strong><?= lang("shift_s_time"); ?></strong></td>
                                                        <td class="text-left"><?php echo date("H:i:s", strtotime($row->s_date)); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left"><strong><?= lang("shift_c_date"); ?></strong></td>
                                                        <td class="text-left"><?php echo date($dateFormats['php_sdate'], strtotime($row->c_date)); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left"><strong><?= lang("shift_c_time"); ?></strong></td>
                                                        <td class="text-left"><?php echo date("H:i:s", strtotime($row->c_date)); ?></td>
                                                    </tr>
                                                    <tr><td colspan='2'><br></td></tr>
<!--                                                    <tr>
                                                        <td class="text-left"><strong><?= lang("open_bal"); ?></strong></td>
                                                        <td class="text-left"><?php echo $this->sma->formatMoney($row->open_bal); ?></td>
                                                    </tr>-->
                                                    <tr>
                                                        <td class="text-left"><strong><strong><?= lang("open_cash"); ?></strong></td> 
                                                        <td class="text-left"><?php echo $this->sma->formatMoney($row->open_cash); ?> (Open)</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left"><strong><?= lang("collection"); ?></strong></td>
                                                        <td class="text-left"><?php echo $this->sma->formatMoney($row->payment_amount); ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left"><strong><?= lang("return"); ?></strong></td> 
                                                        <td class="text-left"><?php echo $this->sma->formatMoney($refunds->returned); ?></td>
                                                    </tr>
                                                    
                                                    <!--tr>
                                                        <td class="text-left"><strong><?= lang("tax"); ?></strong></td>
                                                        <td class="text-left"><?php echo $this->sma->formatMoney($sales_tax); ?></td>
                                                    </tr-->
                                                    <tr>
                                                        <td class="text-left"><strong><?= lang("total"); ?></strong></td>
                                                        <td class="text-left">
                                                            <?php 
                                                                $total = ($row->payment_amount + $row->open_bal) - $refunds->returned;
                                                                echo $this->sma->formatMoney($total); 
                                                            ?>
                                                        </td> 
                                                    </tr>
                                                    <tr><td colspan='2'><br></td></tr>
                                                    <tr>
                                                        <td class="text-left"><strong><?= lang("close_total"); ?></strong></td>
                                                        <td class="text-left">
                                                            <?php 
                                                                $closing_total = (($row->close_cash) + ($bank_amount) + ($dcsales->debit_sales) + ($ccsales->credit_sales) + ($cnsales->credit_note_sales));
                                                                echo $this->sma->formatMoney($closing_total); 
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <tr><td colspan='2'><br></td></tr>
                                                    <tr>
                                                        <td class="text-left"><strong><?= lang("over_short"); ?></strong></td>
                                                        <td class="text-left">
                                                            <?php 
                                                                //$tt = $this->sma->formatMoney(($row->open_bal + $row->payment_amount) - ($row->today_sales)); 
                                                                $tt = ($row->open_bal + $cashPay - $bank_amount) - $row->close_cash;
                                                                echo $this->sma->formatMoney(($tt));  
                                                                if($tt>0){ echo " (Short)";} elseif($tt<0){ echo " (Excess)"; } else { echo "";} 
                                                            ?>
                                                        </td>
                                                    </tr>
                                                    <tr><td colspan='2'><br></td></tr>
                                                    <tr>
                                                        <td class="text-left"><strong><?= lang("open_cash"); ?></strong></td>
                                                        <td class="text-left"><?php echo $this->sma->formatMoney($row->open_cash); ?> (Open)</td>
                                                    </tr>
                                                    <tr><td colspan='2'><br></td></tr>
                                                    <tr>
                                                        <td class="text-left"><strong><?= lang("shift_cash");  ?></strong></td>
                                                        <td class="text-left"><?php echo $this->sma->formatMoney($cashPay); ?> <?=lang("shift");?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left"><strong><?= lang("debit_shift"); ?></strong></td>
                                                        <td class="text-left"><?php echo $this->sma->formatMoney($dcsales->debit_sales); ?> <?=lang("shift");?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left"><strong><?= lang("credit_shift"); ?></strong></td>
                                                        <td class="text-left"><?php echo $this->sma->formatMoney($ccsales->credit_sales); ?> <?=lang("shift");?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left"><strong><?= lang("credit_note"); ?></strong></td>
                                                        <td class="text-left"><?php echo $this->sma->formatMoney($cnsales->credit_note_sales); ?> <?=lang("shift");?></td>
                                                    </tr>
                                                    <tr><td colspan='2'><br></td></tr>
                                                    <tr>
                                                        <td class="text-left"><strong><?= lang("close_cash"); ?></strong></td>
                                                        <td class="text-left"><?php echo $this->sma->formatMoney($row->close_cash); ?> <?=lang("close");?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left"><strong><?= lang("debit_close"); ?></strong></td>
                                                        <td class="text-left"><?php echo $this->sma->formatMoney($dcsales->debit_sales); ?> <?=lang("close");?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left"><strong><?= lang("credit_close"); ?></strong></td>
                                                        <td class="text-left"><?php echo $this->sma->formatMoney($ccsales->credit_sales); ?> <?=lang("close");?></td>
                                                    </tr>
                                                     <tr>
                                                        <td class="text-left"><strong><?= lang("credit_note"); ?></strong></td>
                                                        <td class="text-left"><?php echo $this->sma->formatMoney($cnsales->credit_note_sales); ?> <?=lang("close");?></td>
                                                    </tr>
                                                    <tr>
                                                        <td class="text-left"><strong><?= lang("Amount Deposited In Bank"); ?></strong></td>
                                                        <td class="text-left"><?php echo $this->sma->formatMoney($bank_amount); ?> <?=lang("close");?></td>
                                                    </tr>
                                                    <?php
                                                    $r++;
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
<?php if ($modal) {
//    echo '</div></div></div></div>';
} else{ ?>
<!--    </body>
    </html> -->
<?php } ?>
