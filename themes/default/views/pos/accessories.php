<div class="modal-dialog" id="accessories_modal">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-2x">&times;</i>
            </button>
            <h4 class="modal-title" id="myModalLabel"><?php echo $emrs=='1'?lang('MRS'):lang('customer_service'); ?></h4>
        </div>
        <?php $attrib = array('role' => 'form', 'id' => 'add_accessories_sale', 'class' => 'form-horizontal', 'method' => 'POST');
        if($emrs=='1'){
             echo form_open_multipart("pos/add_emrs_sale", $attrib);
        }else{
            echo form_open_multipart("pos/add_accessories_sale", $attrib);
        }
        ?>
        <div class="modal-body">
            <p><?= lang('enter_info'); ?></p>
            <p id="error"></p>
            <div id="info"></div>
            <div class="form-group">
                <label class="control-label col-sm-4" for="product">Products *</label>
                <div class="col-sm-8">
                    <?php
                    /*
                      $prod = array();
                      foreach($products as $k=>$v){
                      $prod[$v->id] = $v->name;
                      }
                      echo form_dropdown('category_products',$prod,'class="form-control" id="category_products"');
                     */
                    ?>
                    <select class="form-control" id="category_products" name="category_products" required="required">
                        <option value="">Select Product</option>
                        <?php foreach ($products as $key => $val): ?>
                           <!--  <option value="<?= $val->id ?>"><?= $val->name ?> - <?=$val->code;?></option> -->
                            <?php $barcode = '<span style="color:white!important;">'.$val->barcode.'</span>'; ?>
                            <option value="<?= $val->code ?>"><?=$val->code;?> / <?=$barcode?></option>
                    <?php endforeach; ?>
                    </select>
                    <input type="hidden" name="product_name" id="product_name" value="" />
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4" for="pwd">Available Quantity *:</label>
                <div class="col-sm-8"> 
                    <input type="text" name="balance_quantity" class="form-control" id="balance_quantity" readonly="readonly" >
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-4" for="pwd">Quantity *:</label>
                <div class="col-sm-8"> 
                    <input type="text" name="quantity" class="form-control" id="quantity" required="required">
                </div>
            </div>
            <div class="form-group">
                
                <?php 
                if($emrs=='1'){
                ?>   
                <label class="control-label col-sm-4" for="pwd">Employee Name *:</label>
                <div class="col-sm-8">
                    <?php
                    /*
                      $prod = array();
                      foreach($products as $k=>$v){
                      $prod[$v->id] = $v->name;
                      }
                      echo form_dropdown('category_products',$prod,'class="form-control" id="category_products"');
                     */
                    ?>
                    <select class="form-control" id="customer_name" name="customer_name" required="required">
                        <option value="">Select Employee</option>
                        <?php foreach ($sales_exe as $key => $val): ?>
                           <!--  <option value="<?= $val->id ?>"><?= $val->name ?> - <?=$val->code;?></option> -->
                            <option value="<?= $val->id ?>"><?= $val->username ?></option>
                    <?php endforeach; ?>
                    </select>
                    
                </div>        
            <?php
                }else{
            ?>
                <label class="control-label col-sm-4" for="pwd">Customer Name *:</label>
                <div class="col-sm-8"> 
                    <input type="text" name="customer_name" class="form-control" id="customer_name" required="required">
                </div>
            
            <?php
                }
            ?>
            </div>
            <?php 
            if($emrs!='1'){
            ?>
            <div class="form-group">
                <label class="control-label col-sm-4" for="pwd">Customer Mobile No *:</label>
                <div class="col-sm-8"> 
                    <input type="text" name="mobile_no" class="form-control" id="mobile_no" maxlength="10" required="required">
                </div>
            </div>
            <?php
            }
            ?>
            <?php 
            if($emrs!='1'){
            ?>
            <div class="form-group ref">
                <label class="control-label col-sm-4" for="pwd">Remarks *:</label>
                <div class="col-sm-8"> 
                    <input type="text" name="reference" class="form-control" id="reference" required="required">
                </div>
            </div>
            <?php
            }
            ?>
            <input type="hidden" name="warehouse_id" class="form-control" id="warehouse_id" value="<?=$_SESSION['warehouse_id']?>">
            <input name="product_id" id="product_id" type="hidden" class="rid" value="">
            <input name="product_type" id="product_type" type="hidden" class="rtype" value="">
            <input name="product_code" id="product_code" type="hidden" class="rcode" value="">
            <input name="net_unit_cost" id="net_unit_cost" type="hidden" class="rnet_unit_cost" value="">
            <input name="item_tax" id="item_tax" type="hidden" class="item_tax" value="">
            <input name="item_name" id="item_name" type="hidden" class="item_name" value="">
            <input name="product_option" id="product_option" type="hidden" class="product_option" value="">
            <input name="real_unit_price" id="real_unit_price" type="hidden" class="real_unit_price" value="">
            <input name="unit_price" id="unit_price" type="hidden" class="r_unit_price" value="">
            <input name="product_serial" id="product_serial" type="hidden" class="rserial" value="">
            <input name="product_discount" id="product_discount" type="hidden" class="rdiscount" value="">
            <input name="product_discount_type" id="product_discount_type" type="hidden" class="rdiscount_type" value="">
            <input name="tax_rate_id" id="tax_rate_id" type="hidden" class="" value="">
            <input name="org_id" id="org_id" type="hidden" class="" value="">
            <input name="grp_id" id="grp_id" type="hidden" class="" value="">
        </div>
        <div class="modal-footer">
<?php echo form_submit('add_accessories_sale', lang('submit'), 'class="btn btn-primary"'); ?>
        </div>
    </div>
<?php echo form_close(); ?>

</div>
<script type="text/javascript" src="<?= $assets ?>js/custom.js"></script>
<?= $modal_js ?>
<script type="text/javascript">
    $(document).ready(function () {
        $('#error').text('');
        $('#error').css('color', 'red');
        $('#quantity').parent('.form-group').removeClass('has-error');

        $('#category_products').select2({
            placeholder: '--Select a Product--',
//            formatResult: format,
//            formatSelection: format,
//            escapeMarkup: function (text) { return text; },
//            tokenSeparators: [',', '']
        });
            function format (item) {
                data = item.element[0].innerHTML;
                pdt_code = data.split("/")[0];
                pdt_barcode = data.split("/")[1];
                item.element[0].innerHTML = pdt_code+'<span style="color:white;">'+pdt_barcode+'</span>';
                console.log(item.element[0].innerHTML)
                return $(item.element).html();
              }

         $( '#reference,#customer_name' ).click(function() {
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
   
    $('#reference,#customer_name').keyboard({
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

        $('#category_products').on('change', function () {
            $('#error').text('');
            var product_id = $(this).val();
            var product_name = $('select[name="category_products"] option:selected').text();   
            $('#product_name').val(product_name.split('-')[0].trim());
           
            $.ajax({
                url: '<?= site_url('sales/focSuggestions'); ?>',
                type: 'get',
                datatype: 'json',
                data: {
                        term: product_id,
                        warehouse_id: $("#poswarehouse").val(),
                        customer_id: $("#poscustomer").val(),                            
                },
                success: function (response) {
                    var item = $.parseJSON(response)[0];
                    if(item.id > 0){
                        $('#balance_quantity').val(parseInt(item.row.balance));
                        $('#quantity').val(1);
                        $('#quantity').attr('readonly',true);
                        $('#product_id').val(item.row.id);
                        $('#product_type').val(item.row.type);
                        $('#product_code').val(item.row.code);
                        $('#net_unit_cost').val(item.row.net_unit_cost);
                        $('#item_tax').val(item.row.item_tax);
                        $('#item_name').val(item.row.name);
                        $('#product_option').val(item.row.option);
                        $('#real_unit_price').val(item.row.real_unit_price);
                        $('#unit_price').val(item.row.price);
                        $('#product_serial').val(item.row.serial);
                        $('#product_discount').val(item.row.discount);
                        $('#product_discount_type').val(item.row.discount_type);
                        $('#tax_rate_id').val(item.tax_rate.id);
                        $('#org_id').val(item.tax_rate.org_id);
                        $('#grp_id').val(item.tax_rate.grp_id);
                       
                    }else{
                        bootbox.alert('No matching result found! Product might be out of stock in the selected Store.');
                        return false;
                    }
                    //console.log(JSON.stringify(data));
                    //loadProduct(data[0]);
                    //return true;
                }
            });
        });

        $('#quantity,#mobile_no').keyboard({
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

        $( '#quantity,#mobile_no' ).click(function() {
        if(!$('.ui-keyboard').is(":visible")){
            $(this).keyboard({
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


        $('#add_accessories_sale').validate({
            rules: {
                quantity: {required: true, digits: true},
                balance_quantity:{required: true, digits: true},
                customer_name: {required: true,namecharcheck:true},
                mobile_no: {
                    required: true,
                    mobchecktest: true,
                },
                reference: {
                    required: true
                }
            },
            messages: {
                quantity: {required: "Please enter quantity", digits: "Please enter digits only"},
                balance_quantity: {required: "Please select product", digits: "Please enter digits only"},
                customer_name: {required: "Please enter customer name", namecharcheck: "Please enter valid name"},
                mobile_no: {required: "Please enter mobile no", mobchecktest: "Please enter 10 digit mobile number starting with 7,8,9 "},
                reference: {required: "Please enter remarks"}
            },
            submitHandler: function (form) {
                var qty = $('#quantity').val();
                var balance_qty = $('#balance_quantity').val();
                if (parseInt(qty) > 1) {
                    $('#quantity').parent('.form-group').addClass('has-error');
                    $('#error').text('you can enter only 1 quantity');
                    return false;
                } else if (qty == 0) {
                    $('#quantity').parent('.form-group').addClass('has-error');
                    $('#error').text('Please enter quantity greater than zero');
                    return false;
                } else {
                    $('#error').text('');
                    
//                    $.ajax({
//                        url: form.action,
//                        type: form.method,
//                        data: $(form).serialize(),
//                        success: function(response) {
//                            var data = $.parseJSON(response);
//                            if(data.status === 'success'){
//                                //$("#accessories_modal .close").trigger('click');
//                                bootbox.alert("FOC Sale successfully completed");
//                                $('form#add_accessories_sale').trigger('reset');
//                                $('#category_products').select2('val','');
//                                window.location.href = "<?=base_url('pos/view/')?>" + data.sale_id;
//                            }else{
//                                bootbox.alert("FOC Sale not completed");
//                                return false;
//                            }
//                        }            
//                    });
                    form.submit();
                }
            }
        });   
            
    });
       
    $('#quantity').bind('keyup blur', function () {
        var node = $(this);
        node.val(node.val().replace(/[^0-9]+/i, ''));
    }
    );
    $('#mobile_no').bind('keyup blur', function () {
        var node = $(this);
        node.val(node.val().replace(/[^0-9]+/i, ''));
    }
    );
    $('#add_accessories_sale').on('submit',function(){
    $(this).find('input[type=submit]').attr('disabled', 'disabled');
});
</script>
