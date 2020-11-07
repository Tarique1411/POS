<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-users"></i><?= lang('create_user'); ?></h2>
    </div>
    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">
			
                <p class="introtext"><?php echo lang('create_user'); ?></p>

                <?php $attrib = array('class' => 'form-horizontal', 'data-toggle' => 'validator', 'role' => 'form');
                echo form_open("auth/create_user", $attrib);
                ?>
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-5">
                            <div class="form-group">
                                <?php echo lang('first_name', 'first_name'); ?>
                                <div class="controls">
                                    <?php 
					$first_name = !empty($this->input->post('first_name')) ? $this->input->post('first_name') : '';
					echo form_input('first_name', $first_name, 'class="form-control" id="first_name" required="required" pattern=".{2,10}"'); 
                                    ?>
									
                                </div>
                            </div>

                            <div class="form-group">
                                <?php echo lang('last_name', 'last_name'); ?>
                                <div class="controls">
                                    <?php 
										$last_name = !empty($this->input->post('last_name')) ? $this->input->post('first_name') : '';
										echo form_input('last_name', $last_name, 'class="form-control" id="last_name" required="required"'); 
									?>
									
                                </div>
                            </div>
                            <div class="form-group">
                                <?= lang('gender', 'gender'); ?>
                                <?php
                                $ge[''] = array('male' => lang('male'), 'female' => lang('female'));
                                echo form_dropdown('gender', $ge, (isset($_POST['gender']) ? $_POST['gender'] : ''), 'class="tip form-control" id="gender" data-placeholder="' . lang("select") . ' ' . lang("gender") . '" required="required"');
								
                                ?>
                            </div>

                            <div class="form-group">
                                <?php echo lang('company', 'company'); ?>
                                <div class="controls">
                                    <?php 
										$company = !empty($this->input->post('company')) ? $this->input->post('company') : '';
										echo form_input('company', $company, 'class="form-control" id="company" required="required"'); 
										
									?>
                                </div>
                            </div>

                            <div class="form-group">
                                <?php echo lang('phone', 'phone'); ?>
                                <div class="controls">
                                    <?php 
										
										$attr = array('name'=>'phone','class'=>'form-control','id'=>'phone','value'=>set_value('phone'),'type'=>'text','maxlength'=>'10' ,'required'=>'required');
										echo form_input($attr); 
										
									?>
                                </div>
                            </div>

                            <div class="form-group">
                                <?php echo lang('email', 'email'); ?>
                                <div class="controls">
                                    <input type="email" id="email" value="<?=set_value('email')?>" name="email" class="form-control"
                                           required="required"/>
                                    <?php /* echo form_input('email', '', 'class="form-control" id="email" required="required"'); */ ?>
                                </div>
                            </div>
                            <div class="form-group">
                                <?php echo lang('username', 'username'); ?>
                                <div class="controls">
                                    <input type="text" id="username" name="username" maxlength="20" value="<?=set_value('username')?>" class="form-control"
                                           required="required" pattern=".{3,20}"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <?php echo lang('password', 'password'); ?>
                                <div class="controls">
                                    <?php echo form_password('password', '', 'class="form-control tip" id="password" required="required" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"'); ?>
                                    <span class="help-block"><?= lang('pasword_hint') ?></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <?php echo lang('confirm_password', 'confirm_password'); ?>
                                <div class="controls">
                                    <?php echo form_password('confirm_password', '', 'class="form-control" id="confirm_password" required="required" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" data-bv-identical="true" data-bv-identical-field="password" data-bv-identical-message="' . lang('pw_not_came') . '"'); ?>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-5 col-md-offset-1">

                            <div class="form-group">
                                <?= lang('status', 'status'); ?>
                                <?php
                                $opt = array('' => '', 1 => lang('active'), 0 => lang('inactive'));
                                echo form_dropdown('status', $opt, (isset($_POST['status']) ? $_POST['status'] : ''), 'id="status" data-placeholder="' . lang("select") . ' ' . lang("status") . '" required="required" class="form-control input-tip select" style="width:100%;"');
								
                                ?>
                            </div>
                            <div class="form-group">
                                <?= lang("group", "group"); ?>
                                <?php
                                $gp[""] = "--Select at least one--";
                                foreach ($groups as $group) {                                    
                                /* *** Added By Anil 22-09-2016 Start *** */ 
                                    if($this->Owner){
                                        if ($group['name'] != 'owner' && $group['name'] != 'supplier' && $group['name'] != 'customer') {
                                            $gp[$group['id']] = ucfirst($group['name']);
                                        }
                                    } 
                                    else if($this->Admin) {
                                        
                                        if ($group['name'] != 'owner' && $group['name'] != 'admin' && $group['name'] != 'supplier' && $group['name'] != 'customer') {
                                               $gp[$group['id']] = ucfirst($group['name']);
                                        }
                                    }
                                    elseif ($group['name'] != 'owner' && $group['name'] != 'admin' && $group['name'] != 'manager' && $group['name'] != 'supplier' && $group['name'] != 'customer') {
                                        $gp[$group['id']] = ucfirst($group['name']);    
                                        }
                                    } 
                                    /* *** Added By Anil 22-09-2016 End *** */ 
                                echo form_dropdown('group', $gp, (isset($_POST['group']) ? $_POST['group'] : ''), 'id="group" data-placeholder="' . lang("select") . ' ' . lang("group") . '" required="required" class="form-control input-tip select" style="width:100%;"');
								
                                ?>
                            </div>

                            <div class="clearfix"></div>
                            <div class="no">
                                <div class="form-group">
                                    <?= lang("biller", "biller"); ?>
                                    <?php
                                    $bl[""] = "";
                                    foreach ($billers as $biller) {
                                        $bl[$biller->id] = $biller->company != '-' ? $biller->company : $biller->name;
                                    }
                                   
                                /* ** Users Modified By Anil Start ** */  
                                    if($Owner || $Admin){
                                        echo form_dropdown('biller', $bl, (isset($_POST['biller']) ? $_POST['biller'] : $Settings->default_biller), 'id="biller" data-placeholder="' . lang("select") . ' ' . lang("biller") . '" required="required" class="form-control input-tip select" style="width:100%;"');
                                    } else {   
                                        echo form_dropdown('biller', $bl, (isset($_POST['biller']) ? $_POST['biller'] : $this->session->userdata('biller_id')), 'id="biller" data-placeholder="' . lang("select") . ' ' . lang("biller") . '"disabled = disabled"' .'class="form-control input-tip select" style="width:100%;"');
                                        echo form_hidden('biller', $this->session->userdata('biller_id'));
                                    }    
                                    ?>
                                </div>

                                <div class="form-group">
                                    <?= lang("warehouse", "warehouse"); ?>
                                    <?php
                                    $wh[''] = '';
                                    foreach ($warehouses as $warehouse) {
                                        $wh[$warehouse->id] = $warehouse->name;
                                    }
                                /* ** Users Modified By Anil Start ** */  
                                    if($Owner || $Admin){
                                        echo form_dropdown('warehouse', $wh, (isset($_POST['warehouse']) ? $_POST['warehouse'] : ''), 'id="warehouse" class="form-control input-tip select" data-placeholder="' . lang("select") . ' ' . lang("warehouse") . '" required="required" style="width:100%;" ');
                                    } else {                                      
                                        echo form_dropdown('warehouse', $wh, (isset($_POST['warehouse']) ? $_POST['warehouse'] : $this->session->userdata('warehouse_id')), 'id="warehouse" class="form-control input-tip select" data-placeholder="' . lang("select") . ' ' . lang("warehouse") .'"disabled = disabled"' . 'style="width:100%;" ');
                                        echo form_hidden('warehouse', $this->session->userdata('warehouse_id'));
                                    }
                                  /* ** Users Modified By Anil End ** */     
                                    ?>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-8"><label class="checkbox" for="notify"><input type="checkbox"
                                                                                                  name="notify"
                                                                                                  value="1" id="notify"
                                                                                                  checked="checked"/> <?= lang('notify_user_by_email') ?>
                                    </label>
                                </div>
                                <div class="clearfix"></div>
                            </div>

                        </div>
                    </div>
                </div>

                <p><?php echo form_submit('add_user', lang('add_user'), 'class="btn btn-primary"'); ?></p>

                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>
<script> 
    $('#phone').bind('keyup blur',function(){ 
            var node = $(this);
            node.val(node.val().replace(/[^0-9]+/i, '') ); }
        );

</script>
<script>
    
    
    $('input[type="text"]').keyup(function(evt){
    var txt = $(this).val();
    $(this).val(txt.replace(/^(.)|\s(.)/g, function($1){ return $1.toUpperCase( ); }));
});

$('#username').bind('keyup blur',function(){ 
            var node = $(this);
            node.val(node.val().replace(/[^A-Z0-9]+/i, '') ); }
        );
</script>
<script type="text/javascript" charset="utf-8">
    $(document).ready(function () {
        $('#group').change(function (event) {
            var group = $(this).val();
            if (group == 1 || group == 2) {
                $('.no').slideUp();
                $('form[data-toggle="validator"]').bootstrapValidator('removeField', 'biller');
                $('form[data-toggle="validator"]').bootstrapValidator('removeField', 'warehouse');
            } else {
                $('.no').slideDown();
                $('form[data-toggle="validator"]').bootstrapValidator('addField', 'biller');
                $('form[data-toggle="validator"]').bootstrapValidator('addField', 'warehouse');
            }
        });
		
            $('form[data-toggle="validator"]').bootstrapValidator({
                feedbackIcons: {
                    valid: 'fa fa-check',
                    invalid: 'fa fa-times',
                    validating: 'fa fa-refresh'
                }, 
			fields:{
				phone:{
					validators:{
						notEmpty:{message:'mobile number is required and cannot be left empty'},
						digits: {message: 'Only digits are allowed in mobile number.'},
						regexp: {
									regexp: /^[9 8 7]\d{9}$/,
									message: 'Mobile number should be of 10 digits only and starts with 7,8,9.'
						}
					}
				}
			}
		 });
		
    });
</script>