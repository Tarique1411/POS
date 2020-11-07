<style>
    .form-group {
        margin-bottom: 5px;
    }
</style>
<script type="text/javascript" src="<?= $assets ?>pos/js/pos.ajax.js"></script>
<link href="<?= $assets ?>pos/js/keyboard/keyboard.css" rel="stylesheet">

<div class="modal-dialog modal-lg" id="close_register">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-2x">&times;</i>
            </button>
            <h4 class="modal-title" id="myModalLabel"><?= lang('close_register') . ' (' . $this->sma->hrld($register_open_time ? $register_open_time : $this->session->userdata('register_open_time')) . ' - ' . $this->sma->hrld(date('Y-m-d H:i:s')) . ')'; ?></h4>
        </div>
        <?php
//          $attrib = array('data-toggle' => 'validator', 'role' => 'form', 'id' => 'formfield', 'name' => 'close_register');
            $attrib = array('role' => 'form', 'id' => 'formfield', 'name' => 'close_register');
            echo form_open_multipart("pos/close_register/" . $user_id.'/'.$warehouse, $attrib);
        ?>
        <div class="modal-body">
            <div id="alerts"></div>
            <div class="row">                    
                    <div class="col-md-1">
                        <label for="two_thousand">2000</label>
                    </div>
                    <div class="col-md-1">                        
                        <span>&#10005;</span>                       
                    </div>
                    <?php echo form_error('two_thousand'); ?>
                    <div class="col-md-2"> 
                        <div class="form-group">
                            <input id="two_thousand" type="text"  name="two_thousand" maxlength="10" rel="2000" class=" form-control input-sm close_register_input" value="<?php echo set_value('two_thousand'); ?>"  />
                        </div>
                        
                    </div>
                    <div class="col-md-1 text-center">                        
                        <p>&#61;</p>                     
                    </div>
                    <div class="col-md-2"> 
                        <div class="form-group">
                           <input id="total_two_thousand" type="text" name="total_two_thousand" class="form-control input-sm" readonly="readonly" maxlength="10"  readonly="readonly" value="<?php echo set_value('total_two_thousand'); ?>"  /> 
                        </div>
                        
                    </div>
                
            </div>
            <div class="row">                      
                    <div class="col-md-1">
                        <label for="thousand">1000</label>
                    </div>
                    <div class="col-md-1">                        
                        <span>&#10005;</span>                       
                    </div>
                    <?php echo form_error('thousand'); ?>
                    <div class="col-md-2">
                        <div class="form-group">
                            <input id="thousand" type="text"  name="thousand" maxlength="10" rel="1000" class="form-control close_register_input input-sm" value="<?php echo set_value('thousand'); ?>"  />
                        </div>
                        
                    </div>
                    <div class="col-md-1 text-center">                        
                        <p>&#61;</p>                       
                    </div>
                    <div class="col-md-2">  
                        <div class="form-group">
                            <input id="total_thousand" type="text" name="total_thousand" readonly="readonly" class="form-control input-sm" maxlength="10" data-fv-numeric="true" readonly="readonly" value="<?php echo set_value('total_thousand'); ?>"  />                
                        </div>
                    </div>
                
            </div>
            <div class="row">
                                   
                    <div class="col-md-1">
                        <label for="five_hundred">500</label>
                    </div>
                    <div class="col-md-1">                        
                        <span>&#10005;</span>                       
                    </div>
                    <div class="col-md-2">
                        <div class="form-group"> 
                        <?php echo form_error('five_hundred'); ?>
                            <input id="five_hundred" type="text" class="form-control close_register_input input-sm" rel="500" name="five_hundred" maxlength="10" value="<?php echo set_value('five_hundred'); ?>"  />
                        </div>
                    </div>
                    <div class="col-md-1 text-center">                        
                        <p>&#61;</p>                       
                    </div>
                    <div class="col-md-2">  
                        <div class="form-group"> 
                            <input id="total_five_hundred" type="text" name="total_five_hundred" class="form-control input-sm" readonly="readonly" maxlength="10" value="<?php echo set_value('total_five_hundred'); ?>"  />
                        </div>
                    </div>
            </div>
            <div class="row">    
                    <div class="col-md-1">
                        <label for="hundred">100</label>
                    </div>
                    <div class="col-md-1">                        
                        <span>&#10005;</span>                       
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                        <?php echo form_error('hundred'); ?>
                            <input id="hundred" type="text" name="hundred" rel="100" class="form-control close_register_input input-sm" maxlength="10" value="<?php echo set_value('hundred'); ?>"  />
                        </div>
                    </div>
                    <div class="col-md-1 text-center">                        
                        <p>&#61;</p>                       
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <input id="total_hundred" type="text" name="total_hundred" class="form-control input-sm" readonly="readonly" maxlength="10" value="<?php echo set_value('total_hundred'); ?>"  />
                        </div>                
                    </div>
            </div>
            <div class="row">
                
                    <div class="col-md-1">
                        <label for="fifty">50 </label>
                    </div>
                    <?php echo form_error('fifty'); ?>
                    <div class="col-md-1">                        
                        <span>&#10005;</span>                       
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <input id="fifty" type="text" name="fifty" rel="50" class="form-control close_register_input input-sm" maxlength="10" value="<?php echo set_value('fifty'); ?>"  />
                        </div>
                    </div>
                    <div class="col-md-1 text-center">                        
                        <p>&#61;</p>                       
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                             <input id="total_fifty" type="text" name="total_fifty" readonly="readonly" class="form-control input-sm"  maxlength="10" value="<?php echo set_value('total_fifty'); ?>"  />
                        </div>
                    </div>
                
            </div>
            <div class="row">           
                    <div class="col-md-1">
                        <label for="twenty">20</label>
                    </div>
                    <div class="col-md-1">                        
                        <span>&#10005;</span>                       
                    </div>
                    <?php echo form_error('twenty'); ?>
                    <div class="col-md-2">
                        <div class="form-group">
                            <input id="twenty" type="text" name="twenty" rel="20" class="form-control close_register_input input-sm" maxlength="10" value="<?php echo set_value('twenty'); ?>"  />
                        </div>
                        
                    </div>
                    <div class="col-md-1 text-center">                        
                        <p>&#61;</p>                       
                    </div>
                    <div class="col-md-2">   
                        <div class="form-group">
                            <input id="total_twenty" type="text" name="total_twenty" readonly="readonly" class="form-control input-sm" maxlength="10" value="<?php echo set_value('total_twenty'); ?>"  />
                        </div>
                        
                    </div>
            </div>
            <div class="row">
                    <div class="col-md-1">
                        <label for="ten">10</label>
                    </div>
                    <?php echo form_error('ten'); ?>
                    <div class="col-md-1">                        
                        <span>&#10005;</span>                       
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                             <input id="ten" type="text" name="ten" rel="10" class="form-control close_register_input input-sm" maxlength="10" value="<?php echo set_value('ten'); ?>"  />
                        </div>
                       
                    </div>
                    <div class="col-md-1 text-center">                        
                        <p>&#61;</p>                       
                    </div>
                    <div class="col-md-2">   
                        <div class="form-group">
                            <input id="total_ten" type="text" name="total_ten" class="form-control input-sm" readonly="readonly" maxlength="10" value="<?php echo set_value('total_ten'); ?>"  />
                        </div>
                    </div>
            </div>    
            <!--Code add by Ankit--> 
            <div class="row">
                    <div class="col-md-1">
                        <label for="five">5</label>
                    </div>
                    <?php echo form_error('five'); ?>
                    <div class="col-md-1">                        
                        <span>&#10005;</span>                       
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <input id="five" type="text" name="five" rel="5" class="form-control close_register_input input-sm" maxlength="10" value="<?php echo set_value('five'); ?>"  />
                        </div>
                    </div>
                    <div class="col-md-1 text-center">                        
                        <p>&#61;</p>                       
                    </div>
                    <div class="col-md-2">  
                        <div class="form-group">
                            <input id="total_five" type="text" name="total_five" class="form-control input-sm" readonly="readonly" maxlength="10" value="<?php echo set_value('total_five'); ?>"  />
                        </div>
                        
                    </div>
            </div>
            
            <div class="row">
            
                    <div class="col-md-1">
                        <label for="two">2</label>
                    </div>
                    <?php echo form_error('two'); ?>
                    <div class="col-md-1">                        
                        <span>&#10005;</span>                       
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                             <input id="two" type="text"  name="two" rel="2" class="form-control close_register_input input-sm" maxlength="10" value="<?php echo set_value('two'); ?>"  />
                        </div>
                       
                    </div>
                    <div class="col-md-1 text-center">                        
                        <p>&#61;</p>                       
                    </div>
                    <div class="col-md-2">  
                        <div class="form-group">
                             <input id="total_two" type="text" name="total_two" class="form-control input-sm" readonly="readonly" maxlength="10" value="<?php echo set_value('total_two'); ?>"  />
                        </div>    
                    </div>
                    
            </div>
            
            <div class="row">
                
                    <div class="col-md-1">
                        <label for="one">1</label>
                    </div>
                    <?php echo form_error('one'); ?>
                    <div class="col-md-1">                        
                        <span>&#10005;</span>                       
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <input id="one" type="text" name="one" rel="1" class="form-control close_register_input input-sm" maxlength="10" value="<?php echo set_value('one'); ?>"  />
                        </div>
                    </div>
                    <div class="col-md-1 text-center">                        
                        <p>&#61;</p>                       
                    </div>
                    <div class="col-md-2"> 
                        <div class="form-group">
                            <input id="total_one" type="text"  name="total_one" class="form-control input-sm" readonly="readonly" maxlength="10" value="<?php echo set_value('total_one'); ?>"  />
                        </div>
                        
                    </div>
            </div>    
         <!--End code add by Ankit-->       
                    <div class="row">    
                        <div class="col-sm-2" ><?= lang("cash_deposited", "total_cash_submitted"); ?></div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <?php $total_cash = ($cashsales->paid ? $cashsales->paid + ($cash_in_hand ? $cash_in_hand : $this->session->userdata('cash_in_hand')) - $expense - ($cashrefunds->returned ? $cashrefunds->returned : 0) : (($cash_in_hand ? $cash_in_hand : $this->session->userdata('cash_in_hand')) - $expense)); ?>
                                <?= form_hidden('total_cash', $total_cash, 'id="total_cash"'); ?>
                                <?= form_input('total_cash_submitted', '', 'class="form-control input-tip input-sm" readonly="readonly" id="total_cash_submitted" required="required"'); ?>
                            </div>
                        </div>
                            <?php if($ccAmount==''){$ccAmount=0;}
                                    if($dcAmount==''){$dcAmount=0;}
                                    if($cvAmount==''){$cvAmount=0;}
                                    $tt = round(($ccAmount + $dcAmount + $cvAmount),2); 
                            ?>
                        <div class="col-sm-2" ><?= lang("CN_Amount", "cn_amount"); ?></div>
                        <div class="col-sm-2">
                            <div class="form-group">
                               <?= form_input('total_credit_voucher_submitted', (isset($cvAmount) ? $cvAmount : '0'), 'class="form-control input-tip input-sm" id="total_credit_voucher_amount_submitted" required="required" readonly="readonly"'); ?>
                            </div>
                        </div>
                        <div class="col-sm-2"><?= lang("amount", "total_amount_submitted"); ?></div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <?= form_input('total_amount_submitted', (isset($tt) ? $tt : '0'), 'class="form-control input-tip input-sm" id="total_amount_submitted" required="required" readonly="readonly"'); ?>
                            </div>
                        </div>
                       
                    
                    </div>
                    <div class="row">    
                        <div class="col-sm-2" ><?= lang("DC_Amount", "dc_amount"); ?></div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                 <?= form_input('total_debit_card_amount', (isset($dcAmount) ? $dcAmount : '0'), 'class="form-control input-tip input-sm" id="total_debit_card_amount_submitted" required="required" readonly="readonly"'); ?>
                  
                            </div>
                        </div>
                           
                        <div class="col-sm-2"><?= lang("DC_Slips", "dc_slips"); ?></div>
                        <div class="col-sm-2">
                            <div class="form-group">   
                                <?= form_hidden('total_dc_slips', $dcsales->total_dc_slips); ?>
                                <?= form_input('total_dc_slips_submitted', (isset($_POST['total_dc_slips_submitted']) ? $_POST['total_dc_slips_submitted'] : $dcsales->total_dc_slips), 'class="form-control input-tip input-sm" id="total_cc_slips_submitted" required="required" readonly="readonly"'); ?>
                            </div>
                        </div>
                        <div class="col-sm-2"><?= lang("Bank_Deposit", "bank_deposits"); ?></div>
                        <div class="col-sm-2">
                            <div class="form-group">
                               <?php 					
                                    $expense = !empty($expenses->total) ? $this->sma->formatNumber($expenses->total,2) : 0;
                                    echo form_input('expenses', $expense, 'class="form-control input-tip input-sm" id="expenses" required="required" readonly="readonly"'); 
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">    
                        <div class="col-sm-2" > <?= lang("CC_Amount", "cc_amount"); ?></div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <?= form_input('total_credit_card_amount', (isset($ccAmount) ? $ccAmount : '0'), 'class="form-control input-tip input-sm" id="total_credit_card_amount_submitted" required="required" readonly="readonly"'); ?>
                            </div>
                        </div>
                        <div class="col-sm-2"><?= lang("CC_Slips", "cc_slips"); ?></div>
                        <div class="col-sm-2">
                            <div class="form-group">
                               <?= form_hidden('total_cc_slips', $ccsales->total_cc_slips); ?>
                                <?= form_input('total_cc_slips_submitted', (isset($_POST['total_cc_slips_submitted']) ? $_POST['total_cc_slips_submitted'] : $ccsales->total_cc_slips), 'class="form-control input-sm" id="total_cc_slips_submitted" required="required" readonly="readonly"'); ?>
                            </div>
                        </div>
                        <div class="col-sm-2" ><?= lang("Footfall", "footfall"); ?></div>
                        <div class="col-sm-2">
                            <div class="form-group">
                                <?php echo form_input('footfall',0,'class="form-control input-tip close_register_input input-sm" id="footfall" required="required"');?>
                            </div>
                        </div>
                         <?= form_hidden('register_opening_balance', $cashdrawer->cash_in_hand); ?>
                    </div>                
            </div>
        
            <div class="modal-footer no-print">
                <?= form_submit('close_register', lang('close_register'), 'class="btn btn-primary close_register_submit btn-sm"'); ?>
            </div>
        </div>
        <?= form_close(); ?>
    </div>
    
    


<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel3" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                 <h3 id="myModalLabel3">Confirmation Heading</h3>

            </div>
            <div class="modal-body">
                <p>Are You Sure You want To submit The Form</p>
            </div>
            <div class="modal-footer">
                <button class="btn" data-dismiss="modal" aria-hidden="true">Close This Modal</button>
                <button class="btn-primary btn" id="SubForm">Confirm and Submit The Form</button>
            </div>
        </div>
    </div>
</div>
<?= $modal_js ?>
<script type="text/javascript">
    $(document).ready(function () {
        $('#footfall').bind('keyup blur',function(){ 
            var node = $(this);
            node.val(node.val().replace(/[^0-9]+/i, '') ); }
        );
        $(document).on('click', '.po', function (e) {
            e.preventDefault();
            $('.po').popover({
                html: true,
                placement: 'left',
                trigger: 'manual'
            }).popover('show').not(this).popover('hide');
            return false;
        });
        $(document).on('click', '.po-close', function () {
            $('.po').popover('hide');
            return false;
        });
        $(document).on('click', '.po-delete', function (e) {
            var row = $(this).closest('tr');
            e.preventDefault();
            $('.po').popover('hide');
            var link = $(this).attr('href');
            $.ajax({
                type: "get", url: link,
                success: function (data) {
                    row.remove();
                    addAlert(data, 'success');
                },
                error: function (data) {
                    addAlert('Failed', 'danger');
                }
            });
            return false;
        });
    });
    
    function addAlert(message, type) {
        $('#alerts').empty().append(
                '<div class="alert alert-' + type + '">' +
                '<button type="button" class="close" data-dismiss="alert">' +
                '&times;</button>' + message + '</div>');
    }
    
    function roundNumber(number,decimal_points) {
	if(!decimal_points) return Math.round(number);
	if(number == 0) {
		var decimals = "";
		for(var i=0;i<decimal_points;i++) decimals += "0";
		return "0."+decimals;
	}

	var exponent = Math.pow(10,decimal_points);
	var num = Math.round((number * exponent)).toString();
	return num.slice(0,-1*decimal_points) + "." + num.slice(-1*decimal_points)
    }
    
    $(document).ready(function () {
       
        $('#total_cash_submitted').val(0);

        $('.close_register_input').on('input change propertychange paste', function () {
            //display_keyboards();
                        var currency = parseInt($(this).attr("rel"));
			var number = $(this).val();
			if((number != null) && (number != undefined)){
				var amount = currency * parseInt(number);
				
				if(!isNaN(amount)){
					$('#total_' + $(this).attr('name')).val(amount);
				}else{
					var amount = 0;
					$('#total_' + $(this).attr('name')).val(amount);
				}                                
                            var t_two_thousand = isNaN(parseInt($('#total_two_thousand').val())) ? 0 : parseInt($('#total_two_thousand').val());
                            var t_thousand = isNaN(parseInt($('#total_thousand').val())) ? 0 : parseInt($('#total_thousand').val());
                            var t_five_hundred = isNaN(parseInt($('#total_five_hundred').val())) ? 0 : parseInt($('#total_five_hundred').val());
                            var t_hundred = isNaN(parseInt($('#total_hundred').val())) ? 0 : parseInt($('#total_hundred').val());
                            var t_fifty = isNaN(parseInt($('#total_fifty').val())) ? 0 : parseInt($('#total_fifty').val());
                            var t_twenty = isNaN(parseInt($('#total_twenty').val())) ? 0 : parseInt($('#total_twenty').val());
                            var t_ten = isNaN(parseInt($('#total_ten').val())) ? 0 : parseInt($('#total_ten').val());

                            var t_five = isNaN(parseInt($('#total_five').val())) ? 0 : parseInt($('#total_five').val());
                            var t_two = isNaN(parseInt($('#total_two').val())) ? 0 : parseInt($('#total_two').val());
                            var t_one = isNaN(parseInt($('#total_one').val())) ? 0 : parseInt($('#total_one').val());

                            var total = t_two_thousand + t_thousand + t_five_hundred + t_hundred + t_fifty + t_twenty + t_ten + t_five + t_two + t_one;
                            $('#total_cash_submitted').val(total);
                            var sum = total + parseFloat($("#total_credit_voucher_amount_submitted").val()) + parseFloat($("#total_credit_card_amount_submitted").val()) + parseFloat($("#total_debit_card_amount_submitted").val());
                            $("#total_amount_submitted").val(sum);
			}
        });

	

        $('#formfield').submit(function (event) {
            var currentForm = this;
            //var total_cash = Math.round(<?= $total_cash ?>);
            var total_cash_submitted = $('#total_cash_submitted').val();
          
            <?php $total_cash = (($cashsales->paid - $expenses->total) + $cash_in_hand);?>
            //var expense = '<?=$expense?>';
            var total_cash = <?=round($total_cash,0)?>;
            
            //var total_cash = Math.round(<?=$total_cash?>);
            //var total_cash_submitted = parseFloat($('#total_cash_submitted').val()) + parseFloat(expense) + parseFloat($("#total_credit_voucher_amount_submitted").val()) + parseFloat($("#total_credit_card_amount_submitted").val()) + parseFloat($("#total_debit_card_amount_submitted").val());
            var diff = (total_cash - total_cash_submitted);
            var register_open_time = '<?=strtotime($register_open_time)?>';
            var current_time = '<?=strtotime(date('Y-m-d H:i:s'))?>';
            //alert('register_open_time :'+register_open_time+'current_time :'+current_time);
            if(current_time < register_open_time){
                bootbox.alert("register closing date time is less than opening time");
                return false;
            }
            event.preventDefault();
                    if (total_cash_submitted) {
				if(diff > 0){
                                    bootbox.confirm({
                                            message: "You have submitted less amount: " + formatMoney(Math.abs(diff),0) + " , Do you still want to save ",
                                            buttons: {
                                                confirm: {
                                                    label: 'Yes',
                                                    className: 'btn-success'
                                                },
                                                cancel: {
                                                    label: 'No',
                                                    className: 'btn-danger'
                                                }
                                            },
                                            callback: function (result) {
                                                if (result) {
                                                    currentForm.submit();
                                                    return false;
						}
                                                
                                                bootbox.hideAll();
                                                $(".modal-body").css({ "max-height" : $(window).height(), "overflow-y" : "auto" });
                                            }
                                    });
//					
				}else if(diff < 0){
                                            bootbox.confirm({
                                            message: "You have submitted excess amount: " + formatMoney(Math.abs(diff),0) + " , Do you still want to save ",
                                            buttons: {
                                                confirm: {
                                                    label: 'Yes',
                                                    className: 'btn-success'
                                                },
                                                cancel: {
                                                    label: 'No',
                                                    className: 'btn-danger'
                                                }
                                            },
                                            callback: function (result) {
                                                if (result) {
							currentForm.submit();
							return false;
						}
                                                
                                                bootbox.hideAll();
                                                $(".modal-body").css({ "max-height" : $(window).height(), "overflow-y" : "auto" });
                                            }
                                    });
                                }else{
					currentForm.submit();
				}
			}
        });
    });
    
    $('input[type=text]').bind('keyup blur',function(){ 
        var node = $(this);
        node.val(node.val().replace(/[^0-9]+/i, '') ); }
    );
    $(document).ready(function(){
        $("#formfield").on('submit', function(){
            $(".close_register_submit").attr('disabled',true);
        });
        $("#formfield").on('click', function(){
            $(".close_register_submit").attr('disabled',false);
        });
    });
</script>


