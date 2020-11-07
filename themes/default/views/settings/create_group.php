<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-2x">&times;</i>
            </button>
            <h4 class="modal-title" id="myModalLabel"><?php echo lang('create_group'); ?></h4>
        </div>
        <?php $attrib = array('data-toggle' => 'validator', 'role' => 'form');
        echo form_open("system_settings/create_group", $attrib); ?>
        <div class="modal-body">
            <p><?= lang('enter_info'); ?></p>

            <div class="form-group">
                <?= lang("group_name", "group_name"); ?></label>
                <?php //echo form_input('group_name', '', 'class="form-control" id="group_name" required="required" data-bv-notempty="true"'); ?>
                <input type="text" name="group_name" class="form-control" required="required" id="group_name"/>
            </div>

            <div class="form-group">
                <?= lang("description", "description"); ?></label>
                <?php // echo form_input('description', '', 'class="form-control" id="description" required="required" data-bv-notempty="true"'); ?>
            <input type="text" name="description" class="form-control" required="required" id="description"/>
            </div>
            <!-- Add By Ankit -->
            
            <div class="form-group">
                <?php //echo "<pre>"; print_r($groupInfo); ?>
                <?php $groups= array();
                $groups[0] = 'Not';
                foreach($groupInfo as $key=>$val){
                    $groups[$val['id']] = $val['name'];
                }
                ?>
                <label><?= lang("copy_group_permissions"); ?></label>
                <?php
                  echo form_dropdown('copyGP', $groups,$groups[0], 'class="tip form-control" id="copyGP" style="width:100%;"');
                ?> 
            
            </div>
            
                                   
            <!-- End code Add By Ankit -->
            
            

        </div>
        <div class="modal-footer">
            <?php echo form_submit('create_group', lang('create_group'), 'class="btn btn-primary"'); ?>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>
<?= $modal_js ?>
