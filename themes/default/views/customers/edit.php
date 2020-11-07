<?php //echo "<pre>"; print_r($arr_cust_edit);die; ?>
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-2x">&times;</i>
            </button>
            <h4 class="modal-title" id="myModalLabel"><?php echo lang('edit_customer'); ?></h4>
        </div>
        <?php $attrib = array('role' => 'form','id'=>'edit-customer-form');
        echo form_open_multipart("customers/edit/" . $customer->id, $attrib); ?>
        <div class="modal-body">
            <p><?= lang('enter_info'); ?></p>

            <div class="form-group">
                <label class="control-label"
                       for="customer_group"><?php echo $this->lang->line("default_customer_group"); ?></label>
               <script type="text/javascript">$('.general1').prop('disabled',true);</script>
<!--                <div class="controls"> <?php
                    foreach ($customer_groups as $customer_group) {
                        if($customer_group->id == 1){
                            $cgs[$customer_group->id] = $customer_group->name;
                        }
                    }
                    echo form_dropdown('customer_group', $cgs, $customer->customer_group_id, 'class="form-control tip select general1" id="customer_group" style="width:100%;" required="required" readonly');
                    ?>
                </div>-->
            </div>

            <div class="row">
                <div class="col-md-6">
					<!---
                    <div class="form-group company">
                        <?= lang("company", "company"); ?>
                        <?php //echo form_input('company', $customer->company, 'class="form-control tip" id="company" required="required"'); ?>
                    </div>
					---->

                    <div class="form-group required">
                       <?= lang("Gender", "Gender"); ?>
                        <select name="gender" id="gender" required="required">
                       <option value="">--Select--</option>
		     <?php $arr = array('M'=>'Male','F'=>'Female'); 
			foreach($arr as $key=>$val){                
                       	   echo ($key == $customer->gender) ? '<option value='.$key.' selected="selected">'.$val.'</option>' : '<option value='.$key.'>'.$val.'</option>';
			}
		     ?>
                     
                    </select>
                   </div>
                    <div class="form-group person required">
                       <?= lang("First name", "First name"); ?>
                        <?php echo form_input('name', $customer->name, 'class="form-control kb-text tip" id="name" required="required"'); ?>
                    </div>
                    <div class="form-group ">
                        <?= lang("email_address", "email_address"); ?>
                        <input type="email" name="email" class="form-control kb-text" id="email_address"
                               value="<?= $customer->email ?>"/>
                    </div>
                <!-- *** Country Added By Anil Start *** -->    
                     <div class="form-group required">
                        <div class="controls">
                            <?= lang("country", "country"); ?>
                            <?php
                          $selected = ($customer->country_id) ? $customer->country_id : '99';  

                            echo '<div id="countrycombox">'. form_dropdown('country', $country, $selected,'class="form-control" id="country" style="width:100%;" required="required"').'</div>'; ?>
                        </div>                          
                    </div>
                <!-- *** Country Added By Anil End *** -->    
                
                    <!--<div class="form-group">
                        <?= lang("vat_no", "vat_no"); ?>
                        <?php echo form_input('vat_no', $customer->vat_no, 'class="form-control" id="vat_no"'); ?>
                    </div> -->
                    <!--<div class="form-group company">
                    <?= lang("contact_person", "contact_person"); ?>
                    <?php //echo form_input('contact_person', $customer->contact_person, 'class="form-control" id="contact_person" required="required"'); ?>
                </div> -->
                    
                    
                </div>
                
                <div class="col-md-6">
                     <div class="form-group required">
                       <?= lang("Salutation", "Salutation"); ?>
			<?php if($customer->gender == 'M'){ 
			      	$sal = array('1'=>'Mr','2'=>'Dr');
			      }else if($customer->gender == 'F'){
				$sal = array('1'=>'Miss','2'=>'Mrs','3'=>'Dr');
			      }

			?>
			
                         <select name='salutation' id='salutation' required="required">
                            <option value="">--Select--</option>
                       		<?php foreach($sal as $key=>$val){ 
				  echo ($key == $customer->salutation) ? '<option value='.$key.' selected="selected">'.$val.'</option>' : '<option value='.$key.'>'.$val.'</option>';
				}
				?>                
                     	</select>
                     </div>
                     <div class="form-group person">
                       <?= lang("Last name", "Last name"); ?>
                        <?php echo form_input('lname', $customer->lname, 'class="form-control kb-text tip" id="lname"'); ?>
                    </div>
                    <div class="form-group required">
                        <?= lang("phone", "phone"); ?>
                        <input type="text" name="phone" class="form-control kb-pad" 
                               required="required" id="phone" maxlength="10" value="<?= $customer->phone ?>"/>
                    </div>
                <!-- *** Country Added By Anil Start *** -->                 
                    <div class="form-group required" id="statelist">
                        <?= lang("state", "state"); 
                                   $selected = ($customer->state_id) ? $customer->state_id : '1483'; 
                                    ?>                        
                        <?php echo form_dropdown('state',array_filter($arrStates),$selected,'class="form-control" style="width:100%;" required="required"'); ?>
                    </div>                                                                          
                <!-- *** Country Added By Anil End *** -->   
                    
					<!-- <div class="form-group">
                        <?= lang("address", "address"); ?>
                        <?php echo form_input('address', $customer->address, 'class="form-control" id="address" required="required"'); ?>
                    </div>
                    <div class="form-group">
                        <?= lang("city", "city"); ?>
                        <?php echo form_input('city', $customer->city, 'class="form-control" id="city" required="required"'); ?>
                    </div>
                    <div class="form-group">
                        <?= lang("state", "state"); ?>
                        <?php echo form_input('state', $customer->state, 'class="form-control" id="state"'); ?>
                    </div>

                    <div class="form-group">
                        <?= lang("postal_code", "postal_code"); ?>
                        <?php echo form_input('postal_code', $customer->postal_code, 'class="form-control" id="postal_code"'); ?>
                    </div>
                    <div class="form-group">
                        <?= lang("country", "country"); ?>
                        <?php echo form_input('country', $customer->country, 'class="form-control" id="country"'); ?>
                    </div> -->
					<!---
                    <div class="form-group">
                        <?= lang("ccf1", "cf1"); ?>
                        <?php echo form_input('cf1', $customer->cf1, 'class="form-control" id="cf1"'); ?>
                    </div>
                    <div class="form-group">
                        <?= lang("ccf2", "cf2"); ?>
                        <?php echo form_input('cf2', $customer->cf2, 'class="form-control" id="cf2"'); ?>

                    </div>
                    <div class="form-group">
                        <?= lang("ccf3", "cf3"); ?>
                        <?php echo form_input('cf3', $customer->cf3, 'class="form-control" id="cf3"'); ?>
                    </div>
                    <div class="form-group">
                        <?= lang("ccf4", "cf4"); ?>
                        <?php echo form_input('cf4', $customer->cf4, 'class="form-control" id="cf4"'); ?>

                    </div>
                    <div class="form-group">
                        <?= lang("ccf5", "cf5"); ?>
                        <?php echo form_input('cf5', $customer->cf5, 'class="form-control" id="cf5"'); ?>

                    </div>
                    <div class="form-group">
                        <?= lang("ccf6", "cf6"); ?>
                        <?php echo form_input('cf6', $customer->cf6, 'class="form-control" id="cf6"'); ?>
                    </div>
					----->
                </div>
            </div>
			<!---
            <div class="form-group">
                <?= lang('award_points', 'award_points'); ?>
                <?= form_input('award_points', set_value('award_points', $customer->award_points), 'class="form-control tip" id="award_points"  required="required"'); ?>
            </div>
			-------->
        </div>
        <div class="modal-footer">
            <?php echo form_submit('edit_customer', lang('edit_customer'), 'class="btn btn-primary"'); ?>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>
<script> 
  
    $(document).ready(function (e) { 
        //display_keyboards();
        //$('#phone').attr('readonly',true);
    }); 
//on change event of gender load salutation
$(document).on('change','#gender' ,function(event){
        $('#salutation').html(''); 
        if($(this).val() == 'M'){
            var list= "<option value='1'>Mr</option>";
            list+="<option value='2'>Dr</option>";
//     var list="<option value=''>--Select--</option>";
//         list+="<option value='1'>Mr</option>";
//         list+="<option value='2'>Dr</option>";
     }else if($(this).val() == 'F'){
         var list= "<option value='1'>Miss</option>";
      list+="<option value='2'>Mrs</option>";
      list+="<option value='3'>Dr</option>";
//        var list="<option value=''>--Select--</option>";
//         list+="<option value='3'>Miss</option>";
//         list+="<option value='4'>Mrs</option>";
//          list+="<option value='5'>Dr</option>";
     }else if($(this).val() == ''){
              var list= "<option value=''>--Select--</option>";
          }
        $('#salutation').append(list);
    }); 
  
    

</script>
<script>
    
    
    $('input[type="text"]').keyup(function(evt){
    var txt = $(this).val();
    $(this).val(txt.replace(/^(.)|\s(.)/g, function($1){ return $1.toUpperCase( ); }));
});

$('#name').bind('keyup blur',function(){ 
            var node = $(this);
            node.val(node.val().replace(/[^A-Z0-9]+/i, '') ); }
        );
$('#lname').bind('keyup blur',function(){ 
            var node = $(this);
            node.val(node.val().replace(/[^A-Z0-9]+/i, '') ); }
        );		
</script>
<!-- Added By Anil 12-09-2016 Start -->
<script type="text/javascript">
    $(document).ready(function () {
        
        $('#edit-customer-form').validate({
                rules:{
                    name:{required:true,namecharcheck:true},
                    lname:{namecharcheck:true},
                    email:{
                        email:true,
                    },
                    phone:{
                            mobchecktest:true,
                            checkMobileNumber:true
                    },
                },
                messages:{
                    name:{required:"Please enter name",namecharcheck:"Enter name in alphanumeric format only"},
                    lname:{namecharcheck:"Enter name in alphanumeric format only"},
                    email:{ email:"Please enter valid email address"},
                    phone:{mobchecktest:"Please enter 10 digit mobile number starting with 7,8,9",checkMobileNumber:"This Mobile Number and Name is already taken! Try another."}
                },
                submitHandler:function(form){
                    form.submit();
                }
        });
        
        $.validator.addMethod("emailTest",
                     function(value, element) {
                        return /^\w+([-+.'][^\s]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/.test(value);
        }); 
        
       

        $('#countrycombox select').change(function () {
            var selCountry = $(this).val();
            $.ajax({   
                url: "customers/ajax_call_country", 
                async: false,
                type: "POST", 
                data: "country_id="+selCountry, 
                dataType: "json", 
                success: function(data) {                       
                    $('#statelist').html(data);
                }
            })
        }); 
        var country = $('#countrycombox select option:selected').val();
        $.ajax({   
                url: "customers/ajax_call_country", 
                async: false,
                type: "POST", 
                data: "country_id="+country, 
                dataType: "json", 
                success: function(data) {                       
                    $('#statelist').html(data);
                }
            })
    });
    
    $.validator.addMethod("mobchecktest",
            function(value, element) {
                return /^[9 8 7]\d{9}$/.test(value);
        });
        

    
        $.validator.addMethod("checkEmailAddress", 
            function(value, element) {
                var result = false;
                $.ajax({
                    type:"POST",
                    async: false,
                    url: "<?=  base_url('customers/getEmailAvaibility')?>", // script to validate in server side
                    data: {email: value},
                    success: function(data) {
                        result = ((data == true) || (data === 1)) ? true : false;
                    }
                });
                // return true if username is exist in database
                return result; 
            }, 
            "This Email Address is already taken! Try another."
        );
    
     $.validator.addMethod("checkMobileNumber", 
            function(value, element) { 
                var name = $('#name').val();
                var cust_id = '<?=$customer->id?>';
                $.ajax({
                    type:"POST",
                    async: false,
                    url: '<?=  base_url("customers/getMobileAvaibilityForEdit")?>', // script to validate in server side
                    data: {phone: value,name:name,cust_id : cust_id},
                    success: function(data) {
                        //console.log('data :' + data);
                        result = ((data == 1)) ? false : true;
                    }
                });
                // return true if username is exist in database
                //console.log('result :' + result);
                return result; 
            }, 
            "This Name and Mobile Number combination is already taken! Try another."
        );

</script>
<!-- Added By Anil 12-09-2016 End -->
 
