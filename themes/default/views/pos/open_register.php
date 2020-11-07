<link href="<?= $assets ?>pos/js/keyboard/keyboard.css" rel="stylesheet">
<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-briefcase"></i><?= lang("open_register"); ?></h2>
    </div>
    <div class="box-content">

        <div class="well well-sm">
            <?php
            $attrib = array('data-toggle' => 'validator','role' => 'form', 'id' => 'open-register-form');
            echo form_open_multipart("pos/open_register", $attrib);
            ?>
            <div class="row">
                <div class="form-group">                  
                    <div class="col-md-1">
                        <label for="two_thousand">2000</label>
                    </div>
                    <div class="col-md-1">                        
                        <span>&#10005;</span>                       
                    </div>
                    <?php echo form_error('two_thousand'); ?>

                    <div class="col-md-2" style="width:35%">                        
                        <input id="two_thousand" type="text"  name="two_thousand" maxlength="10" rel="2000" class="curr close_register_input" value="<?php echo set_value('two_thousand'); ?>"  />

                    </div>
                    <div class="col-md-1">                        
                        <p>&#61;</p>                       
                    </div>

                    <div class="col-md-2" style="width:35%">         
                        <input id="total_two_thousand" type="text" name="total_two_thousand" class="total_v" pattern="\d*" maxlength="10" readonly="readonly" value="<?php echo set_value('total_two_thousand'); ?>"  />

                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">                  
                    <div class="col-md-1">
                        <label for="thousand">1000</label>
                    </div>
                    <div class="col-md-1">                        
                        <span>&#10005;</span>                       
                    </div>
                    <?php echo form_error('thousand'); ?>

                    <div class="col-md-2" style="width:35%">                        
                        <input id="thousand" type="text"  name="thousand" maxlength="10" rel="1000" class="curr close_register_input" value="<?php echo set_value('thousand'); ?>"  />
                    </div>
                    <div class="col-md-1">                        
                        <p>&#61;</p>                       
                    </div>
                    <div class="col-md-2" style="width:35%">         
                        <input id="total_thousand" type="text" name="total_thousand" class="total_v" pattern="\d*" maxlength="10" readonly="readonly" value="<?php echo set_value('total_thousand'); ?>"  />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">                    
                    <div class="col-md-1">
                        <label for="five_hundred">500</label>
                    </div>
                    <div class="col-md-1">                        
                        <span>&#10005;</span>                       
                    </div>
                    <div class="col-md-2" style="width:35%">
                        <?php echo form_error('five_hundred'); ?>
                        <input id="five_hundred" type="text" pattern="\d*" class="curr close_register_input" rel="500" name="five_hundred" maxlength="10" value="<?php echo set_value('five_hundred'); ?>"  />
                    </div>
                    <div class="col-md-1">                        
                        <p>&#61;</p>                       
                    </div>
                    <div class="col-md-2" style="width:35%">         
                        <input id="total_five_hundred" type="text" name="total_five_hundred" class="total_v" pattern="\d*" maxlength="10" value="<?php echo set_value('total_five_hundred'); ?>"  />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <div class="col-md-1">
                        <label for="hundred">100</label>
                    </div>
                    <div class="col-md-1">                        
                        <span>&#10005;</span>                       
                    </div>
                    <div class="col-md-2" style="width:35%">
                        <?php echo form_error('hundred'); ?>
                        <input id="hundred" type="text" name="hundred" pattern="\d*" data-fv-numeric="true" rel="100" class="curr close_register_input" maxlength="10" value="<?php echo set_value('hundred'); ?>"  />
                    </div>
                    <div class="col-md-1">                        
                        <p>&#61;</p>                       
                    </div>
                    <div class="col-md-2" style="width:35%">         
                        <input id="total_hundred" type="text" name="total_hundred" maxlength="10" pattern="\d*" class="total_v" value="<?php echo set_value('total_hundred'); ?>"  />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <div class="col-md-1">
                        <label for="fifty">50 </label>
                    </div>
                    <?php echo form_error('fifty'); ?>
                    <div class="col-md-1">                        
                        <span>&#10005;</span>                       
                    </div>

                    <div class="col-md-2" style="width:35%">
                        <input id="fifty" type="text" name="fifty" rel="50" pattern="\d*"  class="curr close_register_input " maxlength="10" value="<?php echo set_value('fifty'); ?>"  />

                    </div>
                    <div class="col-md-1">                        
                        <p>&#61;</p>                       
                    </div>
                    <div class="col-md-2" style="width:35%">         
                        <input id="total_fifty" type="text" name="total_fifty" pattern="\d*" class="total_v"  maxlength="10" value="<?php echo set_value('total_fifty'); ?>"  />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <div class="col-md-1">
                        <label for="twenty">20</label>
                    </div>
                    <div class="col-md-1">                        
                        <span>&#10005;</span>                       
                    </div>
                    <?php echo form_error('twenty'); ?>

                    <div class="col-md-2" style="width:35%">
                        <input id="twenty" type="text" name="twenty" rel="20" pattern="\d*" class="curr close_register_input" maxlength="10" value="<?php echo set_value('twenty'); ?>"  />

                    </div>
                    <div class="col-md-1">                        
                        <p>&#61;</p>                       
                    </div>
                    <div class="col-md-2" style="width:35%">         
                        <input id="total_twenty" type="text" name="total_twenty" maxlength="10" pattern="\d*" class="total_v" value="<?php echo set_value('total_twenty'); ?>"  />
                    </div> 

                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <div class="col-md-1">
                        <label for="ten">10</label>
                    </div>
                    <?php echo form_error('ten'); ?>
                    <div class="col-md-1">                        
                        <span>&#10005;</span>                       
                    </div>
                    <div class="col-md-2" style="width:35%">
                        <input id="ten" type="text" name="ten" pattern="\d*" rel="10" class="curr close_register_input" maxlength="10" value="<?php echo set_value('ten'); ?>"  />
                    </div>
                    <div class="col-md-1">                        
                        <p>&#61;</p>                       
                    </div>
                    <div class="col-md-2" style="width:35%">         
                        <input id="total_ten" type="text" name="total_ten" maxlength="10" pattern="\d*" class="total_v" value="<?php echo set_value('total_ten'); ?>"  />
                    </div>
                </div>
            </div>
            
            
            <!--Code add by Ankit-->
            
            <div class="row">
                <div class="form-group">
                    <div class="col-md-1">
                        <label for="five">5</label>
                    </div>
                    <?php echo form_error('five'); ?>
                    <div class="col-md-1">                        
                        <span>&#10005;</span>                       
                    </div>
                    <div class="col-md-2" style="width:35%">
                        <input id="five" type="text" name="five" pattern="\d*" rel="5" class="curr close_register_input" maxlength="10" value="<?php echo set_value('five'); ?>"  />
                    </div>
                    <div class="col-md-1">                        
                        <p>&#61;</p>                       
                    </div>
                    <div class="col-md-2" style="width:35%">         
                        <input id="total_five" type="text" name="total_five" maxlength="10" pattern="\d*" class="total_v" value="<?php echo set_value('total_five'); ?>"  />
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="form-group">
                    <div class="col-md-1">
                        <label for="two">2</label>
                    </div>
                    <?php echo form_error('two'); ?>
                    <div class="col-md-1">                        
                        <span>&#10005;</span>                       
                    </div>

                    <div class="col-md-2" style="width:35%">
                        <input id="two" type="text" name="two" pattern="\d*" rel="2" class="curr close_register_input" maxlength="10" value="<?php echo set_value('two'); ?>"  />
                    </div>
                    <div class="col-md-1">                        
                        <p>&#61;</p>                       
                    </div>
                    <div class="col-md-2" style="width:35%">         
                        <input id="total_two" type="text" name="total_two" maxlength="10" class="total_v" pattern="\d*" value="<?php echo set_value('total_two'); ?>"  />

                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="form-group">
                    <div class="col-md-1">
                        <label for="one">1</label>
                    </div>
                    <?php echo form_error('one'); ?>
                    <div class="col-md-1">                        
                        <span>&#10005;</span>                       
                    </div>
                    <div class="col-md-2" style="width:35%">
                        <input id="one" type="text" name="one" pattern="\d*" rel="1" class="curr close_register_input" pattern="\d*" maxlength="10" value="<?php echo set_value('one'); ?>"  />

                    </div>
                    <div class="col-md-1">                        
                        <p>&#61;</p>                       
                    </div>
                    <div class="col-md-2" style="width:35%">         
                        <input id="total_one" type="text" name="total_one" maxlength="10" class="total_v" pattern="\d*" value="<?php echo set_value('total_one'); ?>"  />
                    </div>
                </div>
            </div>
            
           <!--End code add by Ankit-->

            <div class="row">
                <div class="form-group">

                    <div class="col-md-3 col-md-offset-2">
                        <label for="total">Total Cash in Hand</label>
                    </div>
                  
                    <div class="col-md-2" style="width:35%;  margin-left: 18.3%;">						 
                        <input id="cash_in_hand" type="text" name="cash_in_hand" maxlength="10" class="total_v" pattern="\d*" value="" />					
                    </div>
                </div>
            </div>
            <?php echo form_submit('open_register', lang('open_register'), 'class="btn btn-primary"'); ?>
            <?php echo form_close(); ?>
            <div class="clearfix"></div>
        </div>
    </div>
</div>


<script type="text/javascript">
    $('input[type=text]').bind('keyup blur',function(){ 
        var node = $(this);
        node.val(node.val().replace(/[^0-9]+/i, '') ); }
    );
   
$(document).ready(function () {
    
    $('.total_v').attr('readonly',true);
    $('#cash_in_hand').val(0);
    $('.curr').on('change input propertychange paste', function () {
		    var currency = parseInt($(this).attr("rel"));
			var number = $(this).val();
			
			if((number != null) && (number != undefined)){
				//bootbox.alert("number : "+number);
				var amount = currency * parseInt(number);
				//bootbox.alert("amount : "+amount);
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
				
				$('#cash_in_hand').val(total);
			}
    });	
    
    <?php if(isset($z_report_id)){ ?>
        //window.location.assign('<?php echo base_url("reports/zreportPdf/".$z_report_id); ?>');
        setTimeout(function () { document.location.href = '<?php echo base_url("reports/zreportPdf/".$z_report_id); ?>' }, 1000);
    <?php }?>
});

$("#open-register-form").submit(function(){
    $("input[type='submit']").attr("disabled", true);
});

</script>


