<?php
/* Modified By Anil 23-09-216 */
$attrib = array('data-toggle' => 'validator', 'role' => 'form', 'class' => 'form-horizontal','id'=>'add_till');
echo form_open('till/addTill', $attrib);
?>

<div class="form-group">
    <label class="control-label col-sm-2" for="till_name"><?= lang("Till_Name", "Till Name"); ?></label>
    <div class="col-sm-6">
        <input type="text" name="till_name" value="<?=set_value('till_name')?>" class="form-control kb-text" id="till_name" placeholder="Enter Till name">
    </div>
</div>
<div class="form-group">
    <label class="control-label col-sm-2" for="till_ip"><?= lang("Till_Ip", "Till IP"); ?></label>
    <div class="col-sm-6">
        <input type="text" class="form-control kb-text" value="<?=set_value('till_ip')?>" name="till_ip" id="till_ip" placeholder="Enter Till IP">
    </div>
</div>
<div class="form-group">
    <div class="col-sm-offset-2 col-sm-6">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</div>
<?php echo form_close(); ?>
<script type="text/javascript">
$(document).ready(function(){
	$('#add_till').bootstrapValidator({
        feedbackIcons: {
            valid: 'fa fa-check',
            invalid: 'fa fa-times',
            validating: 'fa fa-refresh'
        },
        fields: {
            till_name: {
                validators: {
                    notEmpty: {
                        message: 'The till name is required and cannot be empty'
                    }
                }
            },
            till_ip: {
                validators: {
                    notEmpty: {
                        message: 'The till ip address is required and cannot be empty'
                    },
					regexp: {
                        regexp: /^(25[0-5]|2[0-4][0-9]|[0-1][0-9]{2}|[0-9]{2}|[0-9])(\.(25[0-5]|2[0-4][0-9]|[0-1][0-9]{2}|[0-9]{2}|[0-9])){3}$/,
                        message: 'Please enter valid ip address'
                    }	
                }
            }          
        }
    });
});

    $(document).bind('click', '.form-control', function () { 
	display_keyboards();
        $('.form-control').addClass('kb-text');				
    });
    
</script>