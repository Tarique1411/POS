<script type="text/javascript" src="<?= $assets ?>pos/js/pos.ajax.js"></script>
<div class="modal-dialog modal-lg" id="myModal">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-2x">&times;</i>
            </button>
            <h4 class="modal-title" id="myModalLabel"><?php echo lang('add_customer'); ?></h4>
        </div>
        <?php $attrib = array('role' => 'form', 'id' => 'add-customer-form');
        echo form_open_multipart("customers/add", $attrib); ?>
        <div class="modal-body">
            <p><?= lang('enter_info'); ?></p>
<!--            <div class="form-group">
                <label class="control-label"
                       for="customer_group"><?php echo $this->lang->line("default_customer_group"); ?></label>
                       <script type="text/javascript">$('.general1').prop('disabled',true);</script>
                <div class="controls"> <?php
                    foreach ($customer_groups as $customer_group) {
                        if($customer_group->id == 1){
                            $cgs[$customer_group->id] = $customer_group->name;
                        }
                    }
                    echo form_dropdown('customer_group', $cgs, $this->Settings->customer_group, 'class="form-control tip select general1" id="customer_group" style="width:100%;" required="required" ');
                    ?>
                </div>
            </div>-->

            <div class="row">
                <div class="col-md-6">
                   <!-- <div class="form-group company">
                        <?= lang("company", "company"); ?>
                        <?php echo form_input('company', '', 'class="form-control tip" id="company" data-bv-notempty="true"'); ?>
                    </div> -->
                    <div class="form-group required">
                       <?= lang("Gender", "Gender"); ?>
                        <select name="gender" id="gender" required="required">
                        <option value="">--Select--</option>
                        <option value="M">Male</option>
                        <option value="F">Female</option>
                     </select>
                   </div>
                    <div class="form-group person required">
                        <?= lang("First name", "First name"); ?>
                        <?php echo form_input('name', '', 'class="form-control tip input-type" id="name" data-bv-notempty="true"'); ?>
                    </div>
                     
                   
                    <!--<div class="form-group company">
                    <?= lang("contact_person", "contact_person"); ?>
                    <?php echo form_input('contact_person', '', 'class="form-control" id="contact_person" data-bv-notempty="true"'); ?>
                </div>-->
                    
                    <div class="form-group required">
                        <?= lang("phone", "phone"); ?>
                        <input type="text" name="phone" class="form-control close_register_input" required="required" id="phone" maxlength="10"/>
                    </div>
                <!-- *** Country Added by Anil Start *** -->    
                    <div class="controls required">
                        <?= lang("country", "country"); ?>
                        <?php
                        echo '<div id="countrycombox">'. form_dropdown('country', $country, $this->settings,'class="form-control tip" id="country" style="width:100%;" required="required"').'</div>'; ?>
                    </div>
                <!-- *** Country Added by Anil End ***  -->   
                    
                    <!--<div class="form-group">
                        <?= lang("address", "address"); ?>
                        <?php echo form_input('address', '', 'class="form-control" id="address" required="required"'); ?>
                    </div>
                      <div class="form-group">
                        <?= lang("Pan no", "Pan no"); ?>
                        <?php echo form_input('vat_no', '', 'class="form-control" id="vat_no"'); ?>
                    </div>
                                       
                    <div class="form-group">
                        <?= lang("state", "state"); ?>
                        <?php echo form_input('state', '', 'class="form-control" id="state"'); ?>
                    </div> -->

                </div>
                <div class="col-md-6">
                    <div class="form-group required">
                       <?= lang("Salutation", "Salutation"); ?>
                        <select name='salutation' id='salutation'>
                            <option value="">--Select--</option>
                        </select>
                   </div>
                       <div class="form-group person">
                        <?= lang("Last name", "Last name"); ?>
                        <?php echo form_input('lname', '', 'class="form-control tip input-type" id="lname"'); ?>
                    </div>
                    <div class="form-group">
                        <?= lang("email_address", "email_address"); ?>
                        <input type="text" name="email" class="form-control input-type" id="email_address" />
                    </div>
                <!-- *** State Added by Anil Start *** -->    
                    <div class="form-group required">
                        <?= lang("state", "state"); 
                        foreach ($state_default as $value){
                        $arrStates[$value->state_id] = $value->state_name;
                           }
                        ?>
                        <?php echo form_dropdown('state',array_filter($arrStates),$this->settings,'class="form-control" id="statelist" style="width:100%;" required="required"'); ?>
                    </div> 
                <!-- *** State Added by Anil End ***  -->   
                    <!--<div class="form-group">
                        <?= lang("city", "city"); ?>
                        <?php echo form_input('city', '', 'class="form-control" id="city" required="required"'); ?>
                    </div>
                    <div class="form-group">
                        <?= lang("postal_code", "postal_code"); ?>
                        <?php echo form_input('postal_code', '', 'class="form-control kb-pad" id="postal_code"'); ?>
                    </div>
                    <div class="form-group">
                        <?= lang("country", "country"); ?>
                        <?php echo form_input('country', '', 'class="form-control" id="country"'); ?>
                    </div> -->
                  <!--  <div class="form-group">
                        <?= lang("ccf1", "cf1"); ?>
                        <?php echo form_input('cf1', '', 'class="form-control" id="cf1"'); ?>
                    </div>
                    <div class="form-group">
                        <?= lang("ccf2", "cf2"); ?>
                        <?php echo form_input('cf2', '', 'class="form-control" id="cf2"'); ?>

                    </div>
                    <div class="form-group">
                        <?= lang("ccf3", "cf3"); ?>
                        <?php echo form_input('cf3', '', 'class="form-control" id="cf3"'); ?>
                    </div>
                    <div class="form-group">
                        <?= lang("ccf4", "cf4"); ?>
                        <?php echo form_input('cf4', '', 'class="form-control" id="cf4"'); ?>

                    </div>
                    <div class="form-group">
                        <?= lang("ccf5", "cf5"); ?>
                        <?php echo form_input('cf5', '', 'class="form-control" id="cf5"'); ?>

                    </div>
                    <div class="form-group">
                        <?= lang("ccf6", "cf6"); ?>
                        <?php echo form_input('cf6', '', 'class="form-control" id="cf6"'); ?>
                    </div> -->
                </div>
            </div>


        </div>
        <div class="modal-footer">
            <?php echo form_submit('add_customer', lang('add_customer'), 'class="btn btn-primary"'); ?>
        </div>
    </div>
    <?php echo form_close(); ?>
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

    $('#name').bind('keyup blur',function(){ 
            var node = $(this);
            node.val(node.val().replace(/[^A-Z0-9]+/i, '') ); 
    });
    
    $('#lname').bind('keyup blur',function(){ 
            var node = $(this);
            node.val(node.val().replace(/[^A-Z0-9]+/i, '') ); 
    });		
</script>
<script type="text/javascript">
    $(document).ready(function (e) {
        $( ".input-type" ).focus(function() {
            if(!$('.ui-keyboard').is(":visible")){
                $('.input-type').keyboard({
                 //   layout : 'qwerty',
                    restrictInput : true, // Prevent keys not in the displayed keyboard from being typed in
                    preventPaste : true,  // prevent ctrl-v and right click
                    autoAccept : false,
                    usePreview : false,
                    layout: 'custom',
                            //layout: 'qwerty',
                            display: {
                                'bksp': "\u2190",
                                'accept': 'accept',
                                'default': 'ABC',
                                'meta1': '123',
                                'meta2': '#+='
                            },
                            customLayout: {
                                'default': [
                                    'q w e r t y u i o p {bksp}',
                                    'a s d f g h j k l {enter}',
                                    '{s} z x c v b n m , . {s}',
                                    '{meta1} {space} {cancel} {accept}'
                                ],
                                'shift': [
                                    'Q W E R T Y U I O P {bksp}',
                                    'A S D F G H J K L {enter}',
                                    '{s} Z X C V B N M / ? {s}',
                                    '{meta1} {space} {meta1} {accept}'
                                ],
                                'meta1': [
                                    '1 2 3 4 5 6 7 8 9 0 {bksp}',
                                    '- / : ; ( ) \u20ac & @ {enter}',
                                    '{meta2} . , ? ! \' " {meta2}',
                                    '{default} {space} {default} {accept}'
                                ],
                                'meta2': [
                                    '[ ] { } # % ^ * + = {bksp}',
                                    '_ \\ | &lt; &gt; $ \u00a3 \u00a5 {enter}',
                                    '{meta1} ~ . , ? ! \' " {meta1}',
                                    '{default} {space} {default} {accept}'
                                ]},
                    accepted : function(e, keyboard, el){
                        keyboard.destroy();
                        return false;
                    },
                    canceled : function(e, keyboard, el){
                         //keyboard.close();
                        //alert(1)
                        keyboard.destroy();
                        return false;
                    },
                });
            }
        });


         $('.input-type')
                .keyboard({
                    autoAccept: true,
                    alwaysOpen: false,
                    openOn: 'focus',
                    usePreview: false,
                   // layout: 'qwerty',
                    /*stayOpen: true,*/
                    //layout: 'qwerty',
                    layout: 'custom',
                            //layout: 'qwerty',
                            display: {
                                'bksp': "\u2190",
                                'accept': 'accept',
                                'default': 'ABC',
                                'meta1': '123',
                                'meta2': '#+='
                            },
                            customLayout: {
                                'default': [
                                    'q w e r t y u i o p {bksp}',
                                    'a s d f g h j k l {enter}',
                                    '{s} z x c v b n m , . {s}',
                                    '{meta1} {space} {cancel} {accept}'
                                ],
                                'shift': [
                                    'Q W E R T Y U I O P {bksp}',
                                    'A S D F G H J K L {enter}',
                                    '{s} Z X C V B N M / ? {s}',
                                    '{meta1} {space} {meta1} {accept}'
                                ],
                                'meta1': [
                                    '1 2 3 4 5 6 7 8 9 0 {bksp}',
                                    '- / : ; ( ) \u20ac & @ {enter}',
                                    '{meta2} . , ? ! \' " {meta2}',
                                    '{default} {space} {default} {accept}'
                                ],
                                'meta2': [
                                    '[ ] { } # % ^ * + = {bksp}',
                                    '_ \\ | &lt; &gt; $ \u00a3 \u00a5 {enter}',
                                    '{meta1} ~ . , ? ! \' " {meta1}',
                                    '{default} {space} {default} {accept}'
                                ]},
                    accepted : function(e, keyboard, el){
                     //   e.preventDefault();
                        //keyboard.destroy();                 
                       keyboard.destroy();
                       return false;
                    },
                    canceled : function(e, keyboard, el){
                         //keyboard.close();
                        //alert(1)
                        keyboard.destroy();
                        return false;
                    },
                    /*display: {
                        'bksp': "\u2190",
                        'accept': 'accept',
                        'default': 'ABC',
                        'meta1': '123',
                        'meta2': '#+='
                    },
                    customLayout: {
                        'default': [
                            'q w e r t y u i o p {bksp}',
                            'a s d f g h j k l {enter}',
                            '{s} z x c v b n m , . {s}',
                            '{meta1} {space} {cancel} {accept}'
                        ],
                        'shift': [
                            'Q W E R T Y U I O P {bksp}',
                            'A S D F G H J K L {enter}',
                            '{s} Z X C V B N M / ? {s}',
                            '{meta1} {space} {meta1} {accept}'
                        ],
                        'meta1': [
                            '1 2 3 4 5 6 7 8 9 0 {bksp}',
                            '- / : ; ( ) \u20ac & @ {enter}',
                            '{meta2} . , ? ! \' " {meta2}',
                            '{default} {space} {default} {accept}'
                        ],
                        'meta2': [
                            '[ ] { } # % ^ * + = {bksp}',
                            '_ \\ | &lt; &gt; $ \u00a3 \u00a5 {enter}',
                            '{meta1} ~ . , ? ! \' " {meta1}',
                            '{default} {space} {default} {accept}'
                        ]}*/
                });
     
     var rx = /INPUT|SELECT|TEXTAREA/i;
    $(document).bind("keydown keypress", function(e){
        if( e.which == 8 ){ // 8 == backspace
            if(!rx.test(e.target.tagName) || e.target.disabled || e.target.readOnly ){
                e.preventDefault();
            }
        }
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
		
        $('select.select').select2({minimumResultsForSearch: 6});
        $('#add-customer-form').validate({
            rules:{
                name:{
                    required:true
                }/*,
                lname:{
                    required:true
                }*/,
                phone:{
                    required:true,
                    mobchecktest:true,
                    checkMobileNumber:true
                },
                email:{
                    email:true
                    //checkEmailAddress:true    
                }
            },
            messages:{
                name:{
                    required:"Please enter first name"
                },/*
                lname:{
                    required:"Please enter last name"
                },*/
                phone:{
                    required:"Enter valid phone number",
                    mobchecktest:"Enter 10 digits mobile number starting with 7,8,9",
                    
                },
                email:{
                    required:"Please enter email"
                    //checkEmailAddress:"This Email Address is already taken! Try another."
                }
            }
        });  
        
    });
</script>
<!-- Added By Anil 12-09-2016 Start-->
<script type="text/javascript">

    $(document).ready(function () {         
        $(document).keydown(function(e) {  
            var browser = get_browser_info();
            if(browser.name === 'Chrome'){
                if(e.keyCode === 37) { // Run code
                    e.preventDefault();
                }
            }
        });
        $("#myModal").on("hidden.bs.modal", function () {
            $('#add_item').removeClass('ui-autocomplete-loading');
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
    
        $.validator.addMethod("mobchecktest",
            function(value, element) {
                return /^[9 8 7]\d{9}$/.test(value);
            },
            "Enter 10 digit mobile number starting with 7,8,9"
        );

        $.validator.addMethod("emailchecktest",
            function(value, element) {
                return /[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+(?:[A-Z]{2}|com|org|net|gov|mil|biz|info|mobi|name|aero|jobs|museum)\b/.test(value);
            },
            "Please enter valid email"
        );
        
        $.validator.addMethod("checkMobileNumber", 
            function(value, element) { 
                var name = $('#name').val();
                $.ajax({
                    type:"POST",
                    async: false,
                    url: '<?=  base_url("customers/getMobileAvaibility")?>', // script to validate in server side
                    data: {phone: value,name:name},
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
    
        $.validator.addMethod("checkEmailAddress", 
            function(value, element) {
                var result = false;
                
                $.ajax({
                    type:"POST",
                    async: false,
                    url: "<?=  base_url('customers/getEmailAvaibility')?>", // script to validate in server side
                    data: {email: value},
                    success: function(data) {
                        //console.log("email available :"+data);
                        //result = ((data == true) || (data === 1)) ? true : false;
                       // console.log('data :' + data);
                        result = ((data == 1)) ? false : true;
                    }
                });
                // return true if username is exist in database                
                return result; 
            }, 
            "This Email Address is already taken! Try another."
        );
});

</script>
<!-- Added By Anil 12-09-2016 End-->