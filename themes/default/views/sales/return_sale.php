<?php //echo "<pre>";print_r($inv->order_discount);?>
<script type="text/javascript">
    var count = 1, an = 1, DT = <?= $Settings->default_tax_rate ?>,
        product_tax = 0, invoice_tax = 0, total_discount = 0, total = 0, /*surcharge = 0,*/
        tax_rates = <?php echo json_encode($tax_rates); ?>;
        possettings = <?=json_encode($possettings);?>;
        

    $(document).ready(function () {
	<?php if ($inv) { ?>
        //localStorage.setItem('redate', '<?= $this->sma->hrld($inv->date) ?>');
        localStorage.setItem('reref', '<?= $reference ?>');
        localStorage.setItem('renote', '<?= $this->sma->decode_html($inv->note); ?>');
        localStorage.setItem('reitems', JSON.stringify(<?= $inv_items; ?>));
        localStorage.setItem('rediscount', '<?= $inv->total_discount; ?>');
        localStorage.setItem('reorderdiscount', '<?= $inv->order_discount; ?>');
        localStorage.setItem('rediscountper', '<?=$inv->order_discount?($inv->order_discount*100)/($inv->total+$inv->product_tax):0 ?>');
        localStorage.setItem('retax2', '<?= $inv->order_tax_id ?>');
        //localStorage.setItem('net_unit_cost', '<?= $sales->net_unit_cost ?>');
        //localStorage.setItem('return_surcharge', '0'); x = dis*100/total
        //console.log();
        <?php } ?>
        <?php if ($Owner || $Admin) { ?>
        if (!localStorage.getItem('redate')) {
            $("#redate").datetimepicker({
                format: site.dateFormats.js_ldate,
                fontAwesome: true,
                language: 'sma',
                weekStart: 1,
                todayBtn: 1,
                autoclose: 1,
                todayHighlight: 1,
                startView: 2,
                forceParse: 0
            }).datetimepicker('update', new Date());
        }
        $(document).on('change', '#redate', function (e) {
            localStorage.setItem('redate', $(this).val());
        });
        if (redate = localStorage.getItem('redate')) {
            $('#redate').val(redate);
        }
        <?php } ?>
        if (reref = localStorage.getItem('reref')) {
            $('#reref').val(reref);
        }
        if (rediscount = localStorage.getItem('rediscount')) {
            $('#rediscount').val(rediscount);
        }
        if (reorderdiscount = localStorage.getItem('reorderdiscount')) {
            $('#order_disc').val(reorderdiscount);
        }
        if (retax2 = localStorage.getItem('retax2')) {
            $('#retax2').val(retax2);
        }
//        if (return_surcharge = localStorage.getItem('return_surcharge')) {
//            $('#return_surcharge').val(return_surcharge);
//        }
        /*$(window).bind('beforeunload', function (e) {
         //localStorage.setItem('remove_resl', true);
         if (count > 1) {
         var message = "You will loss data!";
         return message;
         }
         });
         $('#add_return').click(function () {
         $(window).unbind('beforeunload');
         $('form.edit-resl-form').submit();
         });*/
        if (localStorage.getItem('reitems')) {
            loadItems();
        }
        $(document).on('change', '.paid_by', function () {
            var p_val = $(this).val();
            //localStorage.setItem('paid_by', p_val);
           
            $('#rpaidby').val(p_val);
            if (p_val == 'cash') {
                $('.pcheque_1').hide();
                $('.pcc_1').hide();
                $('.pcash_1').show();
                //$('#amount_1').focus();
            } else if (p_val == 'CC') {
                $('.pcheque_1').hide();
                $('.pcash_1').hide();
                $('.pcc_1').show();
                $('#pcc_no_1').focus();
            } else if (p_val == 'Cheque') {
                $('.pcc_1').hide();
                $('.pcash_1').hide();
                $('.pcheque_1').show();
                $('#cheque_no_1').focus();
            } else {
                $('.pcheque_1').hide();
                $('.pcc_1').hide();
                $('.pcash_1').hide();
            }
			
            if (p_val == 'credit_voucher') {
                $('.gc').show();
                $('.ngc').hide();
                $('#gift_card_no').focus();
            } else {
                $('.ngc').show();
                $('.gc').hide();
                $('#gc_details').html('');
            }
        });
        /* ------------------------------
         * Sell Gift Card modal
         ------------------------------- */

        $(document).on('click', '#sellGiftCard', function (e) {
            var biller;
            <?php if ($Owner || $Admin) { ?>
                   biller = <?php echo $this->session->userdata('default_biller');?>;
            <?php }else{?>
                   biller = <?php echo $this->session->userdata('biller_id');?>;
            <?php }?>
            $('#gcvalue').val($('#amount_1').val());
            
            //$('#gccard_no').val(generateCardNo(8,biller));
            //$('#gccard_no').val(generateCardNo(8,biller));
            $('#gccustomer').val($('#customer_name').val());
            $('#gcModal').appendTo("body").modal('show');
            return false;
        });
		
		/*
        $('#gccustomer').val(<?=$inv->customer_id?>).select2({
            minimumInputLength: 1,
            data: [],
            initSelection: function (element, callback) {
                $.ajax({
                    type: "get", async: false,
                    url: "<?= site_url('customers/getCustomer') ?>/" + $(element).val(),
                    dataType: "json",
                    success: function (data) {
                        callback(data[0]);
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
        });
		*/

        

        $('#genNo2').click(function () {
            var no = generateCardNo(8,<?php echo $this->session->userdata('biller_id');?>);
            $(this).parent().parent('.input-group').children('input').val(no);
            return false;
        });

        $(document).on('click', '#addGiftCard', function (e) {
            var mid = (new Date).getTime(),
            gccode = $('#gccard_no').val(),
            gcname = $('#gcname').val(),
            gcvalue = $('#gcvalue').val(),
            gccustomer = $('#customer_id').val(),
            gcexpiry = $('#gcexpiry').val() ? $('#gcexpiry').val() : '',
            gcprice = parseFloat($('#gcprice').val());
				
            if (gccode == '' || gcvalue == '' || gcprice == '' || gcvalue == 0 || gcprice == 0) {
                $('#gcerror').text('Please fill the required fields');
                $('.gcerror-con').show();
                return false;
            }

            var gc_data = new Array();
            gc_data[0] = gccode;
            gc_data[1] = gcvalue;
            gc_data[2] = gccustomer;
            gc_data[3] = gcexpiry;
            gc_data[4] = $("input[name=invoice_no]").val();
            if (typeof slitems === "undefined") {
                var slitems = {};
            }
            console.log("card data",gc_data);
            $("#gift_card_data").val(gc_data);
           
            $('#gift_card_no').val(gccode);
            $('#gc_details').text('<?=lang('gift_card_added')?>');
            $('#gcModal').modal('hide');
            /*$.ajax({
                type: 'post',
                url: site.base_url + 'sales/sell_gift_card',
                dataType: "json",
                data: {gcdata: gc_data},
                success: function (data) {
                    if (data.result === 'success') {						
                        $('#gift_card_no').val(gccode);
                        $('#gc_details').text('<?=lang('gift_card_added')?>');
                        $('#gcModal').modal('hide');
                    } else {
                        $('#gcerror').text(data.message);
                        $('.gcerror-con').show();
                    }
                }
            });
            return false;*/
        });
        var old_row_qty;
        $(document).on("focus", '.rquantity', function () {
            old_row_qty = $(this).val();
        }).on("change", '.rquantity', function () 
        {
            var row = $(this).closest('tr');
            var new_qty = parseFloat($(this).val()),
                item_id = row.attr('data-item-id');
            if (!is_numeric(new_qty) || (new_qty > reitems[item_id].row.oqty)) {
                $(this).val(old_row_qty);
                bootbox.alert('<?= lang('unexpected_value'); ?>');
                return false;
            }
            if(new_qty > reitems[item_id].row.oqty) {
                bootbox.alert('<?= lang('unexpected_value'); ?>');
                $(this).val(old_row_qty);
                return false;
            }
            reitems[item_id].row.qty = new_qty;
            localStorage.setItem('reitems', JSON.stringify(reitems));
            loadItems();
        });
//        var old_surcharge;
//        $(document).on("focus", '#return_surcharge', function () {
//            old_surcharge = $(this).val() ? $(this).val() : '0';
//        }).on("change", '#return_surcharge', function () {
//            var new_surcharge = $(this).val() ? $(this).val() : '0';
//            if (!is_valid_discount(new_surcharge)) {
//                $(this).val(new_surcharge);
//                bootbox.alert('<?= lang('unexpected_value'); ?>');
//                return;
//            }
//            localStorage.setItem('return_surcharge', JSON.stringify(new_surcharge));
//            loadItems();
//        });
        $(document).on('click', '.redel', function () {
            var row = $(this).closest('tr');
            var item_id = row.attr('data-item-id');

            delete reitems[item_id];
            $('#gift_card_data').val('');
            $("#gift_card_no").val('');
            $("#gc_details").text("");
            row.remove();
            if(reitems.hasOwnProperty(item_id)) { } else {
                localStorage.setItem('reitems', JSON.stringify(reitems));
                loadItems();
                return;
            }
        });
    });
    //localStorage.clear();
    function isEmpty(value) {
        return typeof value == 'string' && !value.trim() || typeof value == 'undefined' || value === null;
    }
    
    function loadItems() {

        if (localStorage.getItem('reitems')) {
            total = 0;
            count = 1;
            an = 1;
            product_tax = 0;
            pr_item_tax = 0;
            unit_total = 0;
            invoice_tax = 0;
            product_discount = 0;
            order_discount = 0;
            total_discount = 0;
            //surcharge = 0;

            $("#reTable tbody").empty();
            reitems = JSON.parse(localStorage.getItem('reitems'));
            //console.log("reitems",reitems);
            //return false;
            $.each(reitems, function () {
                var item = this;
                var item_id = site.settings.item_addition == 1 ? item.item_id : item.id;
                reitems[item_id] = item;

                var item_type = item.row.type, 
                product_id = item.row.id, 
                combo_items = item.combo_items, 
                sale_item_id = item.row.sale_item_id,
                sale_item_ids = item.row.sale_item_ids, 
                item_option = item.row.option, 
                item_price = item.row.price,
                item_unit_price = item.row.net_unit_price;
                item_pi_tax = item.row.item_tax;
                item_qty = item.row.qty, 
                item_aqty = item.row.quantity, 
                item_tax_method = item.row.tax_method, 
                item_ds = item.row.discount, 
                item_discount = 0, 
                item_option = item.row.option, 
                item_code = item.row.code, 
                item_serial = item.row.serial, 
                item_name = item.row.name.replace(/"/g, "&#034;").replace(/'/g, "&#039;");
                
                var unit_price = item.row.real_unit_price;
                var ds = item_ds ? item_ds : '0';
                /*if (ds.indexOf("%") !== -1) {
                    var pds = ds.split("%");
                    if (!isNaN(pds[0])) {
                        //item_discount = formatDecimal(parseFloat(((item_price) * parseFloat(pds[0])) / 100));
                        item_discount = formatDecimal(parseFloat(((unit_price) * parseFloat(pds[0])) / 100));
                    } else {
                        //item_discount = formatDecimal(ds);
                        item_discount = formatDecimal(ds);
                    }
                } else {
                     item_discount = parseFloat(ds);
                }*/
                ds = ds.replace('%','');
                if(!isNaN(ds)){
                    if(possettings.order_discount_type == 'percent'){
                        item_discount = formatDecimal(parseFloat(((unit_price) * parseFloat(ds)) / 100));
                    }
                    else if(possettings.order_discount_type == 'flat'){
                       item_discount = parseFloat(ds); 
                    }
                }
                
                /*if (possettings.order_discount_type == 'percent') {
                    var item_discount = parseFloat(((item_price) * parseFloat(ds)) / 100);
                    //(dval / dtotal) * 100;
                    //item_discount = isNaN(item_discount) ? 0 : item_discount;
                } else if (possettings.order_discount_type == 'flat') {
                    var item_discount = formatDecimal(ds);
                    //item_discount = isNaN(item_discount) ? 0 : item_discount;
                }*/
                //console.log(item_discount);
                
                product_discount += parseFloat(item_discount * item_qty);

                unit_price = formatDecimal(unit_price);
               // var pr_tax = item.tax_rate;
                var pr_tax = item.row.tax_percentage;
                var pr_tax_val = 0, pr_tax_rate = 0;
                
                ///if (site.settings.tax1 == 1) {

                    if (pr_tax !== false) {

                        /*if (pr_tax.type == 0) {

                            if (item_tax_method == '0') {*/
                                pr_tax_val = formatDecimal(((unit_price) * parseFloat(item.row.tax_percentage)) / (100 + parseFloat(item.row.tax_percentage)));
                               // pr_tax_rate = formatDecimal(item.row.tax_percentage) + '%';
                                pr_tax_rate = item.row.tax_percentage;
                            /*} else {
                                pr_tax_val = formatDecimal(((unit_price) * parseFloat(pr_tax.rate)) / 100);
                                pr_tax_rate = formatDecimal(pr_tax.rate) + '%';
                            }*/

                        /*} else if (pr_tax.type == 1) {

                            pr_tax_val = parseFloat(pr_tax.rate);
                            pr_tax_rate = pr_tax.rate;

                        }else{

                        }*/
                        product_tax += pr_tax_val * item_qty;
                        pr_item_tax += (item_pi_tax * item_qty);
                    }
               // }

                item_price = item_tax_method == 0 ? formatDecimal(unit_price-pr_tax_val) : formatDecimal(unit_price);
                
                unit_price = formatDecimal(unit_price - item_discount);//formatDecimal(unit_price + item_discount);
                var sel_opt = '';
                $.each(item.options, function () {
                    if(this.id == item_option) {
                        sel_opt = this.name;
                    }
                });
                //alert('sale_item_id ' + sale_item_id);
                //'+(item_option != 0 ? ' - '+item.option.name : '')+'
                var row_no = (new Date).getTime();
                var newTr = $('<tr id="row_' + row_no + '" class="row_' + item_id + '" data-item-id="' + item_id + '"></tr>');
                tr_html = '<td><input name="sale_item_ids[]" type="hidden" class="rsiid" value="' + sale_item_ids + '"><input name="sale_item_id[]" type="hidden" class="rsiid" value="' + sale_item_id + '"><input name="product_id[]" type="hidden" class="rid" value="' + product_id + '"><input name="product_type[]" type="hidden" class="rtype" value="' + item_type + '"><input name="product_code[]" type="hidden" class="rcode" value="' + item_code + '"><input name="product_option[]" type="hidden" class="roption" value="' + item_option + '"><input name="product_name[]" type="hidden" class="rname" value="' + item_name + '"><span class="sname" id="name_' + row_no + '">' + item_name + ' (' + item_code + ')'+(sel_opt != '' ? ' ('+sel_opt+')' : '')+'</span></td>';
                tr_html += '<input class="form-control input-sm text-right rprice" name="net_price[]" type="hidden" id="price_' + row_no + '" value="' + item_price + '"><input class="ruprice" name="unit_price[]" type="hidden" value="' + unit_price + '">\n\
            <input class="realuprice" name="real_unit_price[]" type="hidden" value="' + item.row.unit_price + '">';
                tr_html += '<td><input class="form-control text-center rquantity" readonly="readonly" name="quantity[]" type="text" value="' + formatDecimal(item_qty) + '" data-id="' + row_no + '" data-item="' + item_id + '" id="quantity_' + row_no + '" onClick="this.select();"></td>';
                
                if (site.settings.product_serial == 1) {
                    if(item_serial == 'undefined'){item_serial = "";}
                    tr_html += '<td class="text-right"><input class="form-control input-sm rserial" readonly="readonly" name="serial[]" type="text" id="serial_' + row_no + '" value="' + item_serial + '"></td>';
                }
                if (site.settings.product_discount == 1) {
                    tr_html += '<input class="form-control input-sm rdiscount" name="product_discount[]" type="hidden" id="discount_' + row_no + '" value="' + item_ds + '">';
                }
                /*if (site.settings.product_discount == 1) {
                    tr_html += '<td class="text-right"><input class="form-control input-sm rdiscount" name="product_discount[]" type="hidden" id="discount_' + row_no + '" value="' + item_ds + '"><span class="text-right sdiscount text-danger" id="sdiscount_' + row_no + '">' + formatMoney((item_discount * item_qty)) + '</span></td>';
                }*/
                if(possettings.order_discount_type == 'percent'){
                    if(isEmpty(item.row.discount)){
                        item.row.discount = 0;
                        tr_html += '<td class="text-right"><span class="text-right sdiscount text-danger" id="sdiscount_' + row_no + '">' + item.row.discount + '%</span></td>';
                    }else{
                        tr_html += '<td class="text-right"><span class="text-right sdiscount" id="sdiscount_' + row_no + '">' + item.row.discount + '%</span></td>';
                    }
                }
                else{
                    tr_html += '<td class="text-right"><span class="text-right quantity" id="unit_' + row_no + '">' + formatMoney(item.row.discount) + '</span></td>';
                }
                if (site.settings.tax1 == 1) {
                    tr_html += '<td class="text-right">';
                    tr_html += '<input class="form-control input-sm text-right rproduct_tax" name="product_tax[]" type="hidden" id="product_tax_' + row_no + '" value="' + pr_tax_rate + '">';
                    tr_html += '<input class="u_item_tax" name="u_item_tax[]" type="hidden" value="' + pr_tax_rate + '">';
                    tr_html += '<input class="u_item_tax_value" name="u_item_tax_value[]" type="hidden" value="' + formatMoney(pr_tax_val * item_qty) + '">';
                    tr_html += '<input class="realucost" name="ru_unit_cost[]" type="hidden" value="' + item.row.price + '">';
                   /* tr_html += '<span class="text-right sproduct_tax rupee" id="sproduct_tax_' + row_no + '">&#8377;' + formatMoney(item_pi_tax * item_qty) + '' + (pr_tax_rate ? '(' + pr_tax_rate + ')' : '') + ' </span></td>';*/
                   tr_html += '<span class="text-right sproduct_tax rupee" id="sproduct_tax_' + row_no + '">&#8377;' + formatMoney((item_pi_tax * item_qty)/2) + '' + (pr_tax_rate ? '(' + formatDecimal(pr_tax_rate/2) + '%' + ')' : '') + ' </span></td>';
                   tr_html += '<td><span class="text-right sproduct_tax rupee" id="sproduct_tax_' + row_no + '">&#8377;' + formatMoney((item_pi_tax * item_qty)/2) + '' + (pr_tax_rate ? '(' + formatDecimal(pr_tax_rate/2) + '%' + ')' : '') + ' </span></td>';

                }
                
                tr_html += '<td class="text-right"><span class="text-right ssubtotal" id="subtotal_' + row_no + '">' + formatMoney(item.row.unit_price) + '</span></td>';
                tr_html += '<td class="text-center"><i class="fa fa-times tip pointer redel" id="' + row_no + '" title="Remove" style="cursor:pointer;"></i></td>';
                newTr.html(tr_html);
                newTr.prependTo("#reTable");
                total += parseFloat(item_price * item_qty);
                unit_total += parseFloat(item_unit_price * item_qty);
                count += parseFloat(item_qty);
                an++;

            });
            // Order level discount calculations
            //console.log('Per --- '+localStorage.getItem('rediscountper'));
            var posreperc = localStorage.getItem('rediscountper');
            if(posreperc === null){
                posreperc = 0;
            }
            if (rediscount = localStorage.getItem('rediscount')) {
                var ds = rediscount;
                var order_discount = parseFloat(ds);
               
                /*if (ds.indexOf("%") !== -1) {
                    var pds = ds.split("%");
                    if (!isNaN(pds[0])) {
                        order_discount = parseFloat(((total + product_tax) * parseFloat(pds[0])) / 100);
                    } else {
                        order_discount = parseFloat(ds);
                    }
                } else {
                    order_discount = parseFloat(ds);
                }*/
                //var order_discount=0;
                if (possettings.order_discount_type == 'percent') {
                    order_discount = formatDecimal(((total + product_tax) * parseFloat(posreperc)) / 100);
                    //discount_percent = isNaN(item_discount) ? 0 : item_discount;
                } else if (possettings.order_discount_type == 'flat') {
                    order_discount = parseFloat(ds);
                }
                //console.log(order_discount);

                total_discount += parseFloat(order_discount);
                //console.log(total_discount);
            }

            // Order level tax calculations
            if (site.settings.tax2 != 0) {
                if (retax2 = localStorage.getItem('retax2')) {
                    $.each(tax_rates, function () {
                        if (this.id == retax2) {
                            if (this.type == 2) {
                                invoice_tax = parseFloat(this.rate);
                            }
                            if (this.type == 1) {
                                invoice_tax = parseFloat(((total + product_tax - total_discount) * this.rate) / 100);
                            }
                        }
                    });
                }
            }
            total_discount = parseFloat(order_discount + product_discount);
            //console.log(total_discount);

            // Totals calculations after item addition
            var gtotal = roundNumber(parseFloat(((total + product_tax + invoice_tax) - total_discount)),0);

            $('#total').text(formatMoney(unit_total));
            //$('#titems').text((an - 1) + ' (' + (parseFloat(count) - 1) + ')');
            $('#titems').text((an - 1));
            $('#total_items').val((parseFloat(count) - 1));
            $('#disc').text(formatMoney(total_discount));
            $('#rediscount').val(formatDecimal(total_discount));
            $('#order_disc').val(formatDecimal(order_discount));
            //$('#trs').text(formatMoney(surcharge));
           // if (site.settings.tax1) {
                $('#ttax1').text(formatMoney(pr_item_tax/2));
                $('#ttax2').text(formatMoney(pr_item_tax/2));
           // }
            if (site.settings.tax2 != 0) {
                $('#ttax2').text(formatMoney(invoice_tax));
            }
            $('#gtotal').text(formatMoney(gtotal));
            <?php if($inv->payment_status == 'paid') { 
                echo "$('#amount_1').val(formatDecimal(gtotal));";
            } ?>
            $('#amount_1').val(formatDecimal(gtotal));
            if (an > site.settings.bc_fix && site.settings.bc_fix != 0) {
                $("html, body").animate({scrollTop: $('#reTable').offset().top - 150}, 500);
                $(window).scrollTop($(window).scrollTop() + 1);
            }
            if (count > 1) {
                $('#add_item').removeAttr('required');
                $('form[data-toggle="validator"]').bootstrapValidator('removeField', 'add_item');
            }
            //audio_success.play();
        }
    }
</script>

<?php //echo "<pre>";print_r($_SESSION); ?>
<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-minus-circle"></i><?= lang('return_sale'); ?></h2>
    </div>
    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">

                <p class="introtext"><?php echo lang('enter_info'); ?></p>
                <?php
                $attrib = array('data-toggle' => 'validator', 'role' => 'form', 'class' => 'edit-resl-form');
                echo form_open_multipart("sales/return_sale/" . $inv->id, $attrib)
                ?>

                <div class="row">
                    <div class="col-lg-12">
                        <?php if ($Owner || $Admin) { ?>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <?= lang("date", "redate"); ?>
                                    <?php echo form_input('date', (isset($_POST['date']) ? $_POST['date'] : ""), 'class="form-control input-tip datetime" id="redate" required="required"'); ?>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="col-md-4">
                            <div class="form-group">
                                <?= lang("reference_no", "reref"); ?>
                                <?php echo form_input('reference_no', (isset($_POST['reference_no']) ? $_POST['reference_no'] : ''), 'class="form-control input-tip" id="reref" readonly="readonly"'); ?>
                            </div>
                        </div>
<!--                        <div class="col-md-4">
                            <div class="form-group">
                                <?= lang("return_surcharge", "return_surcharge"); ?>
                                <?php echo form_input('return_surcharge', (isset($_POST['return_surcharge']) ? $_POST['return_surcharge'] : ''), 'class="form-control input-tip" id="return_surcharge" required="required" '); ?>
                            </div>
                        </div>-->

                        <div class="col-md-4">
                            <div class="form-group">
                                <?= lang("document", "document") ?>
                                <input id="document" type="file" name="document" data-show-upload="false"
                                       data-show-preview="false" class="form-control file"> 
                                <small style='color:red;'>(Upload .jpg, .png, or image type files only)</small>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="control-group table-group">
                                <label class="table-label"><?= lang("order_items"); ?> *</label>

                                <div class="controls table-controls">
                                    <table id="reTable"
                                           class="table items table-striped table-bordered table-condensed table-hover">
                                        <thead>
                                        <tr>
                                            <th class="col-md-4"><?= lang("product_name") . " (" . $this->lang->line("product_code") . ")"; ?></th>
<!--                                            <th class="col-md-1"><?= lang("mrp"); ?></th>-->
                                            <th class="col-md-1"><?= lang("quantity"); ?></th>
                                            <?php
                                            if ($Settings->product_serial) {
                                                echo '<th class="col-md-2">' . $this->lang->line("serial_no") . '</th>';
                                            }
                                            ?>
                                            <?php
                                            if ($Settings->product_discount) {
                                                echo '<th class="col-md-1">' . $this->lang->line("discount") . '</th>';
                                            }
                                            ?>
                                            <?php
                                            /*if ($Settings->tax1) {
                                                echo '<th class="col-md-1">' . $this->lang->line("tax") . '</th>';
                                            }*/
                                            echo '<th class="col-md-1">' . $this->lang->line("cgst") . '</th>';
                                            echo '<th class="col-md-1">' . $this->lang->line("sgst") . '</th>';
                                            ?>
                                            <th><?= lang("mrp"); ?> (<span
                                                    class="currency"><span class="rupee">&#8377;</span></span>)
                                            </th>
                                            <th style="width: 30px !important; text-align: center;"><i
                                                    class="fa fa-trash-o"
                                                    style="opacity:0.5; filter:alpha(opacity=50);"></i></th>
                                        </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>
                                </div>
                            </div>
                            <div id="bottom-total" class="well well-sm" style="margin-bottom: 0;">
                                <table class="table table-bordered table-condensed totals" width="100%" style="margin-bottom:0;">
                                    <tr class="warning">
                                        <td style="width:10%;"><?= lang('items') ?> 
                                            <span class="totals_val pull-right" id="titems">0</span>
                                        </td>
                                        <td style="width:20%;"><?= lang('total') ?>
                                            <span class="rupee">&#8377;</span><span class="totals_val pull-right" id="total">0.00</span>
                                        </td>
                                        <?php /*if ($Settings->tax1) { ?>
                                            <td><?= lang('tax_amount') ?> 
                                                <span class="rupee">&#8377;</span><span class="totals_val pull-right" id="ttax1">0.00</span>
                                            </td>
                                        <?php }*/ ?>
                                        <td style="width:15%;"><?= lang('cgst') ?> 
                                                <span class="rupee">&#8377;</span><span class="totals_val pull-right" id="ttax1">0.00</span>
                                            </td>
                                        <td style="width:15%;"><?= lang('sgst') ?> 
                                            <span class="rupee">&#8377;</span><span class="totals_val pull-right" id="ttax2">0.00</span>
                                        </td>
                                        <td style="width:15%;"><?= lang('discount') ?>
                                            <span class="rupee">&#8377;</span><span class="totals_val pull-right" id="disc">0.00</span>
                                        </td>
                                        <!-- <?php if ($Settings->tax2) { ?>
                                            <td><?= lang('order_tax') ?> <span class="totals_val pull-right" id="ttax2">0.00</span>
                                            </td>
                                        <?php } ?> -->
                                        <td style="width:25%;"><?= lang('return_amount') ?> 
                                            <span class="rupee">&#8377;</span><span class="totals_val pull-right" id="gtotal">0.00</span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <div style="height:15px; clear: both;"></div>
<!--                        <div class="col-md-12">
                            <?php
                            //echo "<pre>";print_r($inv);
                            if($inv->return_flg == 2){
                                $pay_status = 'Partial';
                            }
                            if($inv->return_flg == '2'){
                                echo '<div class="alert alert-warning">' . lang('payment_status_part_paid').' ' 
                                        . lang('payment_status') . ': <strong>' . ucwords($inv->payment_status) . '</strong> & ' 
                                        . lang('paid_amount') . ' <strong> ' . $this->sma->formatMoney($inv->paid) . '</strong></div>';
                            }
                            else{
                            if ($inv->payment_status == 'paid') {
                                echo '<div class="alert alert-success">' . lang('payment_status') 
                                        . ': ' . ucwords($inv->payment_status) . '</strong> & ' 
                                        . lang('paid_amount') . ' <span class="rupee">&#8377;</span><strong>' . $this->sma->formatMoney($inv->paid) . '</strong></div>';
                            } else {
                                echo '<div class="alert alert-warning">' . lang('payment_status_not_paid') . ' ' . lang('payment_status') . ': <strong>' . $inv->payment_status . '</strong> & ' . lang('paid_amount') . ' <strong>' . $this->sma->formatMoney($inv->paid) . '</strong></div>';
                            }
                            }
                            ?>
                        </div>-->
                        <div id="payments">
                            <div class="col-md-12">
                                <div class="well well-sm well_1">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <?= lang("payment_reference_no", "payment_reference_no"); ?>
                                                    <?= form_input('payment_reference_no', (isset($_POST['payment_reference_no']) ? $_POST['payment_reference_no'] : $payment_ref), 'class="form-control tip" id="payment_reference_no" required="required" readonly="readonly"'); ?>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="payment">
                                                    <div class="form-group">
                                                        <?= lang("amount", "amount_1"); ?>
                                                        <input name="amount-paid" type="text" id="amount_1"
                                                               class="pa form-control kb-pad amount"  readonly="readonly"/>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <?= lang("paying_by", "paid_by_1"); ?>
                                                    <select name="paid_by" id="paid_by_1" class="form-control paid_by">
                                                        <option value="credit_voucher"><?= lang("gift_card"); ?></option>
                                                        <!---
                                                        <option value="cash"><?= lang("cash"); ?></option>
                                                        <option value="Cheque"><?= lang("cheque"); ?></option>
                                                        <option value="other"><?= lang("other"); ?></option>---->
                                                    </select>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="pcc_1" style="display:none;">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <input name="pcc_no" type="text" id="pcc_no_1"
                                                               class="form-control" placeholder="<?= lang('cc_no') ?>"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">

                                                        <input name="pcc_holder" type="text" id="pcc_holder_1"
                                                               class="form-control"
                                                               placeholder="<?= lang('cc_holder') ?>"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <select name="pcc_type" id="pcc_type_1"
                                                                class="form-control pcc_type"
                                                                placeholder="<?= lang('card_type') ?>">
                                                            <option value="Visa"><?= lang("Visa"); ?></option>
                                                            <option
                                                                value="MasterCard"><?= lang("MasterCard"); ?></option>
                                                            <option value="Amex"><?= lang("Amex"); ?></option>
                                                            <option value="Discover"><?= lang("Discover"); ?></option>
                                                        </select>
                                                        <!-- <input type="text" id="pcc_type_1" class="form-control" placeholder="<?= lang('card_type') ?>" />-->
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <input name="pcc_month" type="text" id="pcc_month_1"
                                                               class="form-control" placeholder="<?= lang('month') ?>"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">

                                                        <input name="pcc_year" type="text" id="pcc_year_1"
                                                               class="form-control" placeholder="<?= lang('year') ?>"/>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">

                                                        <input name="pcc_ccv" type="text" id="pcc_cvv2_1"
                                                               class="form-control" placeholder="<?= lang('cvv2') ?>"/>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="pcheque_1" style="display:none;">
                                            <div class="form-group"><?= lang("cheque_no", "cheque_no_1"); ?>
                                                <input name="cheque_no" type="text" id="cheque_no_1"
                                                       class="form-control cheque_no"/>
                                            </div>
                                        </div>
<!--                                        <div class="gc" style="display: none;">-->				
                                            <div class="form-group">
                                                <?= lang("gift_card_no", "gift_card_no"); ?>
                                                <div class="input-group">

                                                    <input name="gift_card_no" type="text" id="gift_card_no"
                                                           class="pa form-control kb-pad gift_card_no"/>
                                                     <input name="gift_card_data" type="hidden" id="gift_card_data"
                                                           class="pa form-control kb-pad gift_card_no"/>
                                                    <div class="input-group-addon"
                                                         style="padding-left: 10px; padding-right: 10px; height:25px;">
                                                        <a href="#" id="sellGiftCard" class="tip"
                                                           title="<?= lang('sell_gift_card') ?>"><i
                                                                class="fa fa-credit-card"></i></a></div>
                                                </div>
                                            </div>
                                            <div id="gc_details"></div>
<!--                                        </div>-->
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>


                        <input type="hidden" name="total_items" value="" id="total_items" required="required"/>
                        <input type="hidden" name="order_tax" value="" id="retax2" required="required"/>
                        <input type='hidden' name='order_disc' value='' id='order_disc' required="required"/>
                        <input type="hidden" name="discount" value="" id="rediscount" required="required"/>
                        <input type="hidden" name="cv_balance" value="" id="cv_balance" required="required"/>
                        <input type="hidden" name="cv_value" value="" id="cv_value" required="required"/>
                        <input type="hidden" name="biller_id" value="<?php echo $this->session->all_userdata()['default_biller'];?>" id="biller_id" required="required"/>
                        <input type="hidden" name="customer_id" value="<?=$inv->customer_id?>" id="customer_id" required="required"/>
                        <input type="hidden" name="customer_name" value="<?=$inv->customer?>" id="customer_name" required="required"/>
                        <!---<input type="hidden" name="customer" value="<?=$inv->customer?>" id="customer" required="required"/>-->
                        <div class="row" id="bt">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="col-md-2">
                                            <?= lang("Return_note :", "renote"); ?>
                                    </div>
                                    <div class="col-md-6">
                                        <?php //echo form_textarea('note', (isset($_POST['note']) ? $_POST['note'] : ""), 'class="form-control" id="renote" style="margin-top: 10px; height: 100px;"');
                                                $reasons = array();
                                                $reasons[''] = "--Select Return Reason--";
                                                    foreach($return_reasons as $key=>$val){
                                                            $reasons[$val->id] = $val->reason;
                                                    }
                                                    echo form_dropdown('return_reason',$reasons,'class="form-control" id="return_reason"');
                                            ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div 
                                class="fprom-group"><?php echo form_submit('add_return', $this->lang->line("submit"), 'id="add_return" class="btn btn-primary" style="padding: 6px 15px; margin:15px 0;"'); ?></div>
                        </div>
                    </div>
                </div>


                <?php echo form_close(); ?>

            </div>

        </div>
    </div>
</div>

<div class="modal" id="gcModal" tabindex="-1" role="dialog" aria-labelledby="mModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i
                        class="fa fa-2x">&times;</i></button>
                <h4 class="modal-title" id="myModalLabel"><?= lang('sell_gift_card'); ?></h4>
            </div>
            <div class="modal-body">
                <p><?= lang('enter_info'); ?></p>

                <div class="alert alert-danger gcerror-con" style="display: none;">
                    <button data-dismiss="alert" class="close" type="button">×</button>
                    <span id="gcerror"></span>
                </div>
                <div class="form-group">
                    <?= lang("card_no", "gccard_no"); ?> *
                    <div class="input-group">
                        <?php echo form_input('gccard_no', '', 'class="form-control" readonly = "readonly" id="gccard_no" onClick="this.select();"'); ?>
<!--                        <div class="input-group-addon" style="padding-left: 10px; padding-right: 10px;"><a href="#"
                                                                                                           id="genNo2"><i
                                    class="fa fa-cogs"></i></a></div>-->
                    </div>
                </div>
                <input type="hidden" name="gcname" value="<?= lang('gift_card') ?>" id="gcname"/>

                <div class="form-group">
                    <?= lang("value", "gcvalue"); ?> *
                    <?php echo form_input('gcvalue', '', 'class="form-control" readonly = "readonly" id="gcvalue"'); ?>
                </div>
                <div class="form-group">
                    <?= lang("customer", "gccustomer"); ?>
                    <div class="form-group">
                        <?php echo form_input('gccustomer', '', 'class="form-control" readonly = "readonly" id="gccustomer"'); ?>
                        <!--<div class="input-group-addon" style="padding-left: 10px; padding-right: 10px;"><a href="#"
                                                                                                           id="noCus"
                                                                                                           class="tip"
                                                                                                           title="<?= lang('unselect_customer') ?>"><i
                                    class="fa fa-times"></i></a></div>-->
                    </div>
                </div>
                <div class="form-group">
                    <?= lang("expiry_date", "gcexpiry"); ?>
                    <?php 
						
						$time = time() + 3600 * 24 * $settings->cv_expiry;
						$expiry_time = date('Y-m-d', $time);
                                                //$expire = date($dateFormats['php_sdate'],$time);
						echo form_input('gcexpiry', $expiry_time, 'class="form-control" id="gcexpiry"'); 
						
						echo form_hidden('invoice_no',$reference,'id="invoice_no"');
					?>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" id="addGiftCard" class="btn btn-primary"><?= lang('sell_gift_card') ?></button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
//$('#return_surcharge').bind('keyup blur',function(){ 
//           var node = $(this);
//            node.val(node.val().replace(/[^0-9]+/i, '') ); }
//        );

                $('#gcexpiry').attr('readonly',true);
                $('#gift_card_no').attr('readonly',true);
		c = 0;
                $(document).on('change', '.gift_card_no', function (e) { //alert ("count"+c);
				if(c > 1) { c = 0;}
					e.preventDefault();				
                    var cn = $(this).val() ? $(this).val() : '';
					var customer_id = $('#customer_id').val();
                    var payid = $(this).attr('id'),
                    id = payid.substr(payid.length - 1);
                    if (cn != '' && c == 0) {
                        $.ajax({
                            type: "post", async: false,
                            url: site.base_url + "sales/validate_gift_card",
							data:{'cn':cn},
                            dataType: "json",
                            success: function (data) {
								//console.log(data);
                                localStorage.removeItem('gc_status');
								
                                if (data === false) {
                                    $('#gift_card_no').parent('.input-group').addClass('has-error');
									$('input#add_return').attr('disabled','disabled');
                                    localStorage.setItem('gc_status', 'invalid');
                                    bootbox.alert('<?= lang('incorrect_gift_card') ?>');

                                } else if (data.customer_id !== null && data.customer_id !== $('#customer_id').val()){
                                    $('#gift_card_no').parent('.input-group').addClass('has-error');
                                    localStorage.setItem('gc_status', 'invalid');
                                    bootbox.alert('<?= lang('gift_card_not_for_customer') ?>');
                                }else {
                                    $('#gc_details').html('<small>Card No: ' + data.card_no + '<br>Value: ' + data.value + ' - Balance: ' + data.balance + '</small>');
									$('#cv_balance').val(data.balance);
									$('#cv_value').val(data.value);
                                    $('#gift_card_no').parent('.input-group').removeClass('has-error');
									$('input#add_return').removeAttr('disabled');
                                    localStorage.setItem('gc_status', 'valid');
                                }
                            }
                        });
                    } c = c+1;
                });
                
                $('#gcModal').on('shown.bs.modal', function(e) {
                    e.preventDefault();
                    $.ajax({
                        url:'<?=base_url('sales/checkLatestCNForDate')?>',
                        type:"Post",
                        success:function(data){
                            console.log(data);
                            if((data != null) || (data != undefined)){    
                                var cdata = jQuery.parseJSON(data);
                                $('#gccard_no').val(cdata);
                                console.log(JSON.stringify(cdata));
                            }
                        }
                    });
                });
</script>
<?php //echo "<pre>";print_r($inv_items);?>