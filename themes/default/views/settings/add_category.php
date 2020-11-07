<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-2x">&times;</i>
            </button>
            <h4 class="modal-title" id="myModalLabel"><?php echo lang('add_category'); ?></h4>
        </div>
        <?php $attrib = array('data-toggle' => 'validator', 'role' => 'form','id'=>'add_category');
        echo form_open_multipart("system_settings/add_category", $attrib); ?>
        <div class="modal-body">
            <p><?= lang('enter_info'); ?></p>

            <div class="form-group">
                <?php echo lang('category_code', 'code'); ?>
                <div class="controls">
                    <?php echo form_input($code); ?>
                </div>
            </div>

            <div class="form-group">
                <?php echo lang('category_name', 'name'); ?>
                <div class="controls">
                    <?php echo form_input($name); ?>
                </div>
            </div>
            <div class="form-group">
                <?= lang("category_image", "image") ?>
                <input id="image" type="file" name="userfile" data-show-upload="false" data-show-preview="false"
                       class="form-control file">
            </div>
			<div class="form-group">
				<label for="tax_rate">Select tax rate:</label>				
					<?php 
					$options[] = "--Select one option--";
					foreach($tax_rates as $key => $val){
							$options[$val->id] = $val->name;
					}?>				
				<?php echo form_dropdown('tax_rate', $options, $this->input->post('tax_rate'),'class="form-control",required,id="tax_rate",data-bv-notempty="true"
data-bv-notempty-message="The tax rate is required and select at least one"'); ?>
				<div class="help-block with-errors"></div>
			</div>
			<?php //echo "<pre>";print_r($tax_rates); ?>
        </div>
        <div class="modal-footer">
            <?php echo form_submit('add_category', lang('add_category'), 'class="btn btn-primary"'); ?>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>
<script type="text/javascript" src="<?= $assets ?>js/custom.js"></script>

<?= $modal_js ?>