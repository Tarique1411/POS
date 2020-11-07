<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-2x">&times;</i>
            </button>
            <h4 class="modal-title" id="myModalLabel"><?php echo lang('add_expense').'('.date($dateFormats['php_ldate']).')'; ?></h4>
        </div>
        <?php $attrib = array('role' => 'form', 'id' => 'add_expense_sale', 'class' => 'form-horizontal', 'method' => 'POST');
        echo form_open_multipart("purchases/bankDeposit", $attrib);
        ?>
        <div class="modal-body">
            <p><?= lang('enter_info'); ?></p>
            <p id="error"></p>
            <div class="form-group">
                <label class="control-label col-sm-4" for="amount">Amount *:</label>
                <div class="col-sm-8"> 
                    <input type="text" name="amount" class="form-control" id="amount" maxlength="10" required="required">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4" for="slip_no">Slip no *:</label>
                <div class="col-sm-8"> 
                    <input type="text" name="slip_no" class="form-control" id="slip_no" required="required">
                </div>
            </div>
            
            <div class="form-group">
                <label class="control-label col-sm-4" for="bank"><?= lang("Bank","Bank");?>:</label>
                 <div class="col-sm-8"> 
                    <?php 
                        $list = array(''=>'SELECT BANK','deutsche'=>'Deutsche Bank','citi'=>'Citi Bank');
                        echo form_dropdown('bank', $list, 'class="form-control col-sm-6 kb-pad" id="bank"' ); 
                    ?>
                 </div>
            </div>
<!--            <div class="form-group">
                <label class="control-label col-sm-4" for="note"><?= lang("note", "note"); ?></label>
                <div class="col-sm-8"> 
                    <?php echo form_textarea('note', (isset($_POST['note']) ? $_POST['note'] : ""), 'class="form-control" id="note"'); ?>
                </div>
            </div>-->
        </div>
        <div class="modal-footer">
        <?php echo form_submit('add_expense', lang('submit'), 'class="btn btn-primary"'); ?>
        </div>
    </div>
<?php echo form_close(); ?>

</div>
<script type="text/javascript" src="<?= $assets ?>js/custom.js"></script>
<?= $modal_js ?>
<script type="text/javascript">
    $(document).ready(function () {
       
//        $('#category_products').on('change', function () {
//            $('#error').text('');
//            var product_id = $(this).val();
//            $.ajax({
//                url: '<?= site_url('pos/getBalanaceQtyAccessory') ?>',
//                type: 'POST',
//                datatype: 'json',
//                data: {'product_id': product_id},
//                success: function (response) {
//                    var data = $.parseJSON(response);
//                    $('#balance_quantity').val(parseInt(data.balance));
//                }
//
//            });
//        });
        
    $('#amount').keyboard({
        restrictInput: true,
        preventPaste: true,
        autoAccept: true,
        alwaysOpen: false,
        openOn: 'click',
        usePreview: false,
        layout : 'num',
      
        customLayout: {
            'default': [
                '1 2 3 {b}',
                '4 5 6 . {clear}',
                '7 8 9 0 %',
                '{accept} {cancel}'
            ]
        },
       
        accepted : function(e, keyboard, el){           
           keyboard.destroy();
           return false;
        },
        canceled : function(e, keyboard, el){
            keyboard.destroy();
            return false;
        },
    });

    $( '#amount' ).focus(function() {
        if(!$('.ui-keyboard').is(":visible")){

            $('#amount').keyboard({
                layout : 'num',
                restrictInput : true, // Prevent keys not in the displayed keyboard from being typed in
                preventPaste : true,  // prevent ctrl-v and right click
                autoAccept : false,
                usePreview : false,
               /* customLayout: {
                    'default': [
                        '1 2 3 {b}',
                        '4 5 6 . {clear}',
                        '7 8 9 0 %',
                        '{accept} {cancel}'
                    ]
                },*/
                accepted : function(e, keyboard, el){
                    keyboard.destroy();
                    return false;
                },
                canceled : function(e, keyboard, el){
                    keyboard.destroy();
                    return false;
                },
            });
        }
    });

    $( '#slip_no,#note' ).focus(function() {
        if(!$('.ui-keyboard').is(":visible")){
            $(this).keyboard({
                layout : 'custom',
                restrictInput : true, // Prevent keys not in the displayed keyboard from being typed in
                preventPaste : true,  // prevent ctrl-v and right click
                autoAccept : false,
                usePreview : false,
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
                keyboard.destroy();
                return false;
            },
            });
        }
    });
   
    $('#slip_no,#note').keyboard({
        autoAccept: true,
        alwaysOpen: false,
        openOn: 'focus',
        usePreview: false,
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
                keyboard.destroy();
                return false;
            },
        });
        $('#add_expense_sale').validate({
            rules: {
                
                amount: {
                    required: true,
                    digits: true
                },
                slip_no: {
                    required: true,
                    alphanumeric:true,
                    checkSlipNo:true
                },
                bank:{
                    required:true
                }
            },
            messages: {      
                amount: {required: "Please enter amount", digits: "Please enter digits only"},
                slip_no: {required: "Please enter slip no",alphanumeric:"Please enter alphanumeric data",checkSlipNo:"This Slip No is already used, try another"},
                bank: {required:"Please select bank"}
            },
            submitHandler: function (form) {
                    var bank = $('select[name="bank"] option:selected').val();
                    
                    if((bank == '') || (bank === undefined) || (bank === null)){
                        bootbox.alert("Please Select Bank");
                        return false;
                    }
                    $.ajax({
                        url: form.action,
                        type: form.method,
                        data: $(form).serialize(),
                        success: function(response) {
                            var data = $.parseJSON(response);
                            if(data.status === 'success'){
                                //$("#accessories_modal .close").trigger('click');
                                bootbox.alert("Bank Deposit successfully completed");
                                $('form#add_expense_sale').trigger('reset');
                            }
                        }            
                    });
                //form.submit();
            }
        });      
        
        $.validator.addMethod("checkSlipNo", 
            function(value, element) {
                var result = false;
                $.ajax({
                    type:"POST",
                    async: false,
                    url: "<?=  base_url('purchases/uniqueExpenseReference')?>", // script to validate in server side
                    data: {'slip_no': value},
                    success: function(data) {
                        //result = ((data == true) || (data === 1)) ? true : false;
                        console.log('data :' + data);
                        result = ((data == 1)) ? false : true;
                    }
                });
                // return true if username is exist in database
                
                return result; 
            }, 
            "This Slip no is already taken! Try another."
        );
    });
    

    
    $('#mobile_no').bind('keyup blur', function () {
        var node = $(this);
        node.val(node.val().replace(/[^0-9]+/i, ''));
    }
    );
</script>
