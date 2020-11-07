<script type="text/javascript" src="<?= $assets ?>js/custom.js"></script>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-2x">&times;</i>
            </button>
            <h4 class="modal-title" id="myModalLabel"><?= lang('credit_voucher_setting'); ?></h4>
        </div>
        <?php $attrib = array('data-toggle' => 'validator', 'role' => 'form', 'id'=>'update_credit_voucher');
        echo form_open("sales/credit_voucher_setting", $attrib); ?>
        <div class="modal-body">
            <p><?= lang('enter_info'); ?></p>
            <div class="form-group">
                <?= lang("Expiry_days", "expiry"); ?>
                <?php echo form_input('expiry', $settings->cv_expiry, 'class="form-control credit_note" id="expiry" required="required"'); ?>
            </div>
            <div class="form-group">
                <?= lang("Grace_Period", "grace_period"); ?>
                <?php echo form_input('grace_period', $settings->cv_grace_period, 'class="form-control credit_note" id="grace_period" required="required"'); ?>
            </div>
        </div>
        <div class="modal-footer">
            <?php echo form_submit('credit_voucher_setting', lang('credit_voucher_setting'), 'class="btn btn-primary"'); ?>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>
<script type="text/javascript">
    $('#update_credit_voucher').validate({
        rules:{
            expiry:{required:true},
            grace_period:{required:true}
        },
        messages:{
            expiry:{required:"Please enter credit note expiry days"},
            grace_period:{required:"Please enter grace period in days"}
        },
        errorPlacement: function(error, element) {    
            var placement = $(element).data('error');
            if (placement) {
                $(placement).append(error)
            } else {
                error.insertAfter(element);
            }
        }
    });
    
    $(document).on('keyup blur','.credit_note',function(){        
        var node = $(this);
        node.val(node.val().replace(/[^0-9]+/i, '') ); }
    );
 </script>
   