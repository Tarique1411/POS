<?php //echo "<pre>";print_r($gift_card);die; ?>
<script type="text/javascript" src="<?= $assets ?>js/custom.js"></script>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-2x">&times;</i>
            </button>
            <h4 class="modal-title" id="myModalLabel"><?= lang('edit_gift_card'); ?></h4>
        </div>
        <?php $attrib = array('data-toggle' => 'validator', 'role' => 'form');
        echo form_open("sales/edit_gift_card/" . $gift_card->id, $attrib); ?>
        <div class="modal-body">
            <p><?= lang('enter_info'); ?></p>

            <div class="form-group">
                <?= lang("card_no", "card_no"); ?>
                <div class="input-group">
                    <?php 
						$card = $gift_card->biller_id.'/'.$gift_card->year.'/'.$gift_card->card_no;
						echo form_input('card_no', $card, 'class="form-control" id="card_no" type="number" min=1 step=1 required="required" readonly="readonly"'); 
					?>
                    <div class="input-group-addon" style="padding-left: 10px; padding-right: 10px;"><a href="#"
                                                                                                       id="genNo"><i
                                class="fa fa-cogs"></i></a></div>
                </div>
            </div>
            <div class="form-group">
                <?= lang("value", "value"); ?>
                <?php 
					$attr = array('name'=>'value','type'=>'text','class'=>'form-control','id'=>'value','min'=>1,'step'=>1,'data-bind' => "value:replyNumber",'value'=>$this->sma->formatDecimal($gift_card->value));
					echo form_input($attr); 
				?>
            </div>
            <div class="form-group">
                <?= lang("customer", "customer"); ?>
                <?php 
					echo form_input('customer', $gift_card->customer, 'class="form-control" id="customer"'); 
				?>
            </div>
            <div class="form-group">
                <?= lang("expiry_date", "expiry"); ?>
                <?php echo form_input('expiry', $gift_card->expiry, 'class="form-control" id="expiry"'); ?>
            </div>

        </div>
        <div class="modal-footer">
            <?php echo form_submit('edit_gift_card', lang('edit_gift_card'), 'class="btn btn-primary"'); ?>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>
<?= $modal_js ?>
<script type="text/javascript">
    $(document).ready(function () {
		$('#expiry').attr('readonly',true);
		var today = new Date();
        $.fn.datetimepicker.dates['sma'] = <?=$dp_lang?>;
		//$('#expiry').datetimepicker('setStartDate', today);
		
        $('#customer').val('<?=$gift_card->customer?>').select2({
            minimumInputLength: 1,
            data: [{id:<?=$gift_card->customer_id?>,text:<?=$gift_card->customer?>}],
            initSelection: function (element, callback) {
                $.ajax({
                    type: "get", async: false,
                    url: "<?= site_url('customers/getCustomer') ?>/" + $(element).val(),
                    dataType: "json",
                    success: function (data) {
                        if (data != null) {
                            callback(data[0]);
                        }
                    }
                });
            },
            ajax: {
                url: site.base_url + "customers/suggestions",
                dataType: 'json',
                quietMillis: 15,
                data: function (term, page) {
                    return {
                        term: term,
                        limit: 10
                    };
                },
                results: function (data, page) {
                    if (data.results != null) {
                        return {results: data.results};
                    } else {
                        return {results: [{id: '', text: 'No Match Found'}]};
                    }
                }
            }
        });//.select2("val", "<?=$gift_card->customer_id?>");
        $('#genNo').click(function () {
            var no = generateCardNo(16,<?php echo $this->session->all_userdata()['default_biller'];?>);
            $(this).parent().parent('.input-group').children('input').val(no);
            return false;
        });
    });

</script>    