$(document).ready(function () {
    $(".open-category").click(function () {
        $('#category-slider').toggle('slide', {direction: 'right'}, 700);
    });
    $(".open-subcategory").click(function () {
        $('#subcategory-slider').toggle('slide', {direction: 'right'}, 700);
    });
    $(document).on('click', function (e) {
        if (!$(e.target).is(".open-category, .cat-child") && !$(e.target).parents("#category-slider").size() && $('#category-slider').is(':visible')) {
            $('#category-slider').toggle('slide', {direction: 'right'}, 700);
        }
        if (!$(e.target).is(".open-subcategory, .cat-child") && !$(e.target).parents("#subcategory-slider").size() && $('#subcategory-slider').is(':visible')) {
            $('#subcategory-slider').toggle('slide', {direction: 'right'}, 700);
        }
    })
    $('.po').popover({html: true, placement: 'right', trigger: 'click'}).popover();
    $('#inlineCalc').calculator({layout: ['_%+-CABS', '_7_8_9_/', '_4_5_6_*', '_1_2_3_-', '_0_._=_+'], showFormula: true});
    $('.calc').click(function (e) {
        e.stopPropagation();
    });

    $(document).on('click', '[data-toggle="ajax"]', function (e) {
        e.preventDefault();
        var href = $(this).attr('href');
        $.get(href, function (data) {
            $("#myModal").html(data).modal();
        });
    });
});

$(document).ready(function () {

    $('#pdiscount').bind('keyup blur', function () {
        var node = $(this);
        var value = node.val();
        //this.value = this.value.replace (/(\.\d\d)\d+|([\d.]*)[^\d.]/, '$1$2');
        node.val(value.replace(/(\.\d\d)\d+|([\d.]*)[^\d.]/, '$1$2'));
    }
    );

    $('#order_discount_input').bind('keyup blur', function () {
        var node = $(this);
        var value = node.val();
        node.val(value.replace(/(\.\d\d)\d+|([\d.]*)[^\d.]/, '$1$2'));
    }
    );

    $(document).on('focus', 'input[readonly]', function () {
        this.blur();
    });
    localStorage.removeItem('posdiscount');
// Order level shipping and discoutn localStorage
    if (posdiscount = localStorage.getItem('posdiscount')) {
        $('#posdiscount').val(posdiscount);
    }
    $(document).on('change', '#ppostax2', function () {
        localStorage.setItem('postax2', $(this).val());
        $('#postax2').val($(this).val());
    });

    if (postax2 = localStorage.getItem('postax2')) {
        $('#postax2').val(postax2);
    }

    $(document).on('blur', '#sale_note', function () {
        localStorage.setItem('posnote', $(this).val());
        $('#sale_note').val($(this).val());
    });

    if (posnote = localStorage.getItem('posnote')) {
        $('#sale_note').val(posnote);
    }

    $(document).on('blur', '#staffnote', function () {
        localStorage.setItem('staffnote', $(this).val());
        $('#staffnote').val($(this).val());
    });

    if (staffnote = localStorage.getItem('staffnote')) {
        $('#staffnote').val(staffnote);
    }


    /* ----------------------
     * Order Discount Handler
     * ---------------------- */

    $("#ppdiscount").click(function (e) {

        var na = parseFloat(count) - 1;

        if (na <= 0) {
            bootbox.alert('No Product Added to list');
            return false;
        }

        var dis = $('#tds').text();
        e.preventDefault();
        var discount_type = $('#pos_discount_type').val();
        var group_usr = $('#group_of_user').val();

        if ((pos_settings.discount_type === '2') || (pos_settings.discount_type === '3')) {
            var discnt = $('#posdiscount').val();
            formatMoney(total);
            formatMoney(discnt);
            formatMoney(invoice_tax);
            var diff = total - discnt;

            var invoicpercent = (invoice_tax / diff) * 100;
            var invoicevalue = (invoicpercent / 100) * total;

            var dtotal = invoicevalue + total;

            var twt = formatDecimal((total + invoice_tax));
            var gtotal = formatDecimal(Math.round(twt));

            var dval = $('#posdiscount').val() ? $('#posdiscount').val() : '0';

            if (discnt <= 0) {
                $('#order_discount_input').val(0);
                $('#discout_reason_input').val('');
            }
            if (total == 0) { //alert("remove posdicount");
                dval = 0;
                localStorage.removeItem('posdiscount');
                loadItems();
            }
            if (pos_settings.order_discount_type == 'percent') {
                var discount_percent = (dval / dtotal) * 100;
                discount_percent = isNaN(discount_percent) ? 0 : discount_percent;
            } else if (pos_settings.order_discount_type == 'flat') {
                var discount_percent = dval;
                discount_percent = isNaN(discount_percent) ? 0 : discount_percent;
            }

            if (dis == 0.00) {
                discount_percent = 0;
            }

            //updated by ajay on 29-11-2016
            var pdis_type = $("select[name='discount_type']").select2('val');
            if (pdis_type === 'employee') {
                $('#order_discount_input').val(formatDecimal('40'));
                $('#order_discount_input').attr('readonly', true);
            } else if (pdis_type === 'replacement') {
                $('#order_discount_input').val(formatDecimal('35'));
                $('#order_discount_input').attr('readonly', true);
            } else {
                $('#order_discount_input').val(formatDecimal(discount_percent));
            }
            /*******************************/
            //$('#order_discount_input').val(formatDecimal(discount_percent));

            $('#dsModal').modal();
        } else {
            bootbox.alert('Invoice discount not allowed');
            return;
        }
    });

    $('#dsModal').on('shown.bs.modal', function () {
        $(this).find('#order_discount_input').select().focus();
        $('#order_discount_input').bind('keypress', function (e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                var ds = $('#order_discount_input').val();
                if (is_valid_discount(ds)) {
                    $('#posdiscount').val(ds);
                    localStorage.removeItem('posdiscount');
                    localStorage.setItem('posdiscount', ds);
                    loadItems();
                } else {
                    bootbox.alert(lang.unexpected_value);
                }
                $('#dsModal').modal('hide');
            }
        });
    });

    $(document).on('click', '#updateOrderDiscount', function () {
        alert(1)
        var discount_type = $('#discount_type option:selected').val();

        var group_usr = $('#group_of_user').val();
        var users;
        var twt = formatDecimal((total + invoice_tax));
        var gtotal = formatDecimal(twt);

        var ds;
        ds = parseFloat($('#order_discount_input').val()) ? parseFloat($('#order_discount_input').val()) : 0;
        var max_allowed_discount;

        var ds_reason = $('#discout_reason_input').val() ? $('#discout_reason_input').val() : '';
        var order_discount_type = $('#pos_order_discount_type').val();
        if (order_discount_type == 'percent') {
            if (ds >= 100) {
                bootbox.alert('order discount percent cannot be greater than or equal to 100%');
                return false;
            }
            ds_value = ((gtotal * ds) / 100);
            max_allowed_discount = ((gtotal * pos_settings.order_discount) / 100);
        } else if (order_discount_type == 'flat') {
            ds_value = ds;
            max_allowed_discount = pos_settings.order_discount;
        }
        //console.log(max_allowed_discount);return false;
        if (group_usr !== '6') {
            $.post(site.base_url + 'pos/getAllUsers', function (data) {

                users = $.parseJSON(data);
                options = $("#users");
                $.each(users, function (index, val) {
                    options.append($("<option />").val(val.id).text(val.username));
                });

            });
        }
        //var logged_in_discount = $('#logged_in_discount').val();
        //alert(logged_in_discount);
        if (is_valid_discount(ds_value)) {
            //alert('ds_value :'+ds_value+' max allowed discount:'+max_allowed_discount)
            if (parseFloat(ds_value) > gtotal) {
                bootbox.alert("Discount value cannot be greater than grand total");
                return;
            }
            else if (discount_type == 'replacement') {
                if (gtotal > 0) {
                    bootbox.alert('Replacement discount applied!');
                    posDiscountUpdate(ds_value, ds_reason, gtotal);
                }
            }
            else if (discount_type == 'employee') {
                if (gtotal > 0) {
                    bootbox.alert('Employee discount applied!');
                    posDiscountUpdate(ds_value, ds_reason, gtotal);
                }
            } else if (discount_type == 'promotions') {
                var pr_discount = $(".rpromotion[data-item-id='" + item_id + "']").val();

                if (pr_discount == '1') {
                    if (gtotal > 0) {
                        bootbox.alert('Promotions discount applied!');
                        posDiscountUpdate(ds_value, ds_reason, gtotal);
                    }
                } else {
                    bootbox.alert('Promotions discount not allowed!');
                    return false;
                }

            } else if (parseFloat(ds_value) > parseInt(max_allowed_discount)) {

                if (group_usr !== '6') {
                    bootbox.dialog({
                        title: "Authenticate for Order Discount",
                        message: '<div class="row">  ' +
                                '<div class="col-md-12"> ' +
                                '<form class="form-horizontal" role="form" data-toggle="validator">' +
                                '<div class="form-group"> ' +
                                '<label class="col-md-4 control-label" for="users"> Enter Username</label> ' +
                                '<div class="col-md-8"> ' +
                                '<input type="text" class="form-control kb-text" placeholder="Your Username" id="users" required="required">' +
                                '</div></div> ' +
                                '<div class="form-group"> ' +
                                '<label class="col-md-4 control-label" for="psw">Password</label> ' +
                                '<div class="col-md-8">' +
                                '<input id="password" name="password" type="password" data-minlength="8" placeholder="Your password" class="form-control kb-text input-md" required="required">  ' +
                                ' <div class="help-block">Minimum of 8 characters</div>' +
                                '</div> </div>' +
                                '</form> </div>  </div>',
                        buttons: {
                            success: {
                                label: "Authenticate",
                                className: "btn-success",
                                callback: function () {
                                    //var user = $("#users option:selected").text();
                                    var user = $("#users").val();
                                    var pwd = $('#password').val();
                                    if ((user == null) || (user == undefined) || (user == '')) {
                                        bootbox.alert("Username required");
                                        return false;
                                    }
                                    if ((pwd == null) || (pwd == undefined) || (pwd == '')) {
                                        bootbox.alert("Password required");
                                        return false;
                                    }

                                    $.ajax({
                                        type: "POST",
                                        url: site.base_url + 'pos/authenticate_discount',
                                        data: {"username": user, "password": pwd, "discount": ds},
                                        datatype: "json",
                                        success: function (cdata) {
                                            var data = jQuery.parseJSON(cdata);
                                            if (data.status == 'success') {
                                                var user_max_discount = parseFloat(data.userdata.show_discount);
                                                var user_max_discount_value = parseFloat((gtotal * user_max_discount) / 100);
                                                //if (user_max_discount_value > parseInt(ds_value)) {
                                                if ((Number(user_max_discount_value) - Number(ds_value)) >= 0) {
                                                    posDiscountUpdate(ds_value, ds_reason, gtotal);
                                                } else {
                                                    bootbox.alert('You are not authorised to allow ' + ds_value + ' (' + data.userdata.show_discount + '%) discount');
                                                    return false;
                                                }
                                            }
                                            else {
                                                bootbox.alert('Please check your credentials or permissions to allow discount!');
                                            }
                                        }
                                    });

                                }
                            }
                        }
                    });
                }
                else {
                    bootbox.alert('You are not authorised to allow discount than maximum limit');
                    //$('#dsModal').modal('hide');
                    $('#order_discount_input').focus();
                    return;
                }
            } else {

                posDiscountUpdate(ds_value, ds_reason, gtotal);
            }
        } else {
            bootbox.alert(lang.unexpected_value);
        }
        $('#dsModal').modal('hide');
    });

    /* ----------------------
     * POS Discount update handler
     * ---------------------- */
    function posDiscountUpdate(ds_value, ds_reason, gtotal) { //alert("posDiscountUpdate "+ds_value);
        //alert(ds_value+"ds reason"+"gtotal"+gtotal);
        var ds_percent = parseFloat((ds_value / gtotal) * 100);
        $('#posdiscount').val(ds_value);
        $('#posdiscountreason').val(ds_reason);
        if (ds_value === 0) {
            $('#discout_reason_input').val('');
            $('span#tt_discount_reason').val('');
            $('#tt_discount_label').hide();
            localStorage.removeItem('posdiscountreason');
            localStorage.setItem('posdiscountreason', '');
        } else {
            $('#tt_discount_label').show();
            localStorage.removeItem('posdiscountreason');
            localStorage.setItem('posdiscountreason', ds_reason);
        }


        localStorage.removeItem('orderdisc');
        localStorage.removeItem('posdiscount');
        localStorage.removeItem('posdiscountpercent');
        localStorage.setItem('posdiscount', ds_value);
        //  alert(localStorage.getItem('posdiscount'));
        localStorage.setItem('posdiscountpercent', ds_percent);
        localStorage.setItem('positems', JSON.stringify(positems));
        $('#dsModal').modal('hide');

        $("#dsModal").removeClass("in");
        $(".modal-backdrop").remove();
        $("#dsModal").hide();
        loadItems();
        return;
    }


    /* ----------------------
     * Order Tax Handler
     * ---------------------- */

    $("#pptax2").click(function (e) { //alert("vivek");
        e.preventDefault();
        var postax2 = localStorage.getItem('postax2');
        //alert(postax2);
        $('#order_tax_input').select2('val', postax2);
        $("#order_tax_input").attr('disabled', 'disabled');
        $('#txModal').modal();
    });
    $('#txModal').on('shown.bs.modal', function () {
        $(this).find('#order_tax_input').select2('focus');
    });
    $('#txModal').on('hidden.bs.modal', function () {
        var ts = $('#order_tax_input').val();
        //alert(ts);
        $('#postax2').val(ts);
        localStorage.setItem('postax2', ts);
        loadItems();
    });
    $(document).on('click', '#updateOrderTax', function () {
        var ts = $('#order_tax_input').val();
        $('#postax2').val(ts);
        localStorage.setItem('postax2', ts);
        localStorage.setItem('positems', JSON.stringify(positems));
        loadItems();
        $('#txModal').modal('hide');
    });


    $(document).on('change', '.rserial', function () {
        var item_id = $(this).closest('tr').attr('data-item-id');
        positems[item_id].row.serial = $(this).val();
        localStorage.setItem('positems', JSON.stringify(positems));
    });

// If there is any item in localStorage
    if (localStorage.getItem('positems')) {
        loadItems();
    }

    // clear localStorage and reload
    $('#reset').click(function (e) {
        if (total == 0) {
            bootbox.alert("No products added to discard");

        } else {
            bootbox.confirm(lang.r_u_sure, function (result) {
                if (result) {
                    if (localStorage.getItem('positems')) {
                        localStorage.removeItem('positems');
                    }
                    if (localStorage.getItem('posdiscount')) {
                        localStorage.removeItem('posdiscount');
                    }
                    if (localStorage.getItem('postax2')) {
                        localStorage.removeItem('postax2');
                    }
                    if (localStorage.getItem('posshipping')) {
                        localStorage.removeItem('posshipping');
                    }
                    if (localStorage.getItem('posref')) {
                        localStorage.removeItem('posref');
                    }
                    if (localStorage.getItem('poswarehouse')) {
                        localStorage.removeItem('poswarehouse');
                    }
                    if (localStorage.getItem('posnote')) {
                        localStorage.removeItem('posnote');
                    }
                    if (localStorage.getItem('posinnote')) {
                        localStorage.removeItem('posinnote');
                    }
                    if (localStorage.getItem('poscustomer')) {
                        localStorage.removeItem('poscustomer');
                    }
                    if (localStorage.getItem('poscurrency')) {
                        localStorage.removeItem('poscurrency');
                    }
                    if (localStorage.getItem('posdate')) {
                        localStorage.removeItem('posdate');
                    }
                    if (localStorage.getItem('posstatus')) {
                        localStorage.removeItem('posstatus');
                    }
                    if (localStorage.getItem('posbiller')) {
                        localStorage.removeItem('posbiller');
                    }

                    $('#modal-loading').show();
                    //location.reload();
                    window.location.href = site.base_url + "pos";
                }
            });
        }
    });

// save and load the fields in and/or from localStorage

    $('#poswarehouse').change(function (e) {
        localStorage.setItem('poswarehouse', $(this).val());
    });
    if (poswarehouse = localStorage.getItem('poswarehouse')) {
        $('#poswarehouse').select2('val', poswarehouse);
    }

    //$(document).on('change', '#posnote', function (e) {
    $('#posnote').redactor('destroy');
    $('#posnote').redactor({
        buttons: ['formatting', '|', 'alignleft', 'aligncenter', 'alignright', 'justify', '|', 'bold', 'italic', 'underline', '|', 'unorderedlist', 'orderedlist', '|', 'link', '|', 'html'],
        formattingTags: ['p', 'pre', 'h3', 'h4'],
        minHeight: 100,
        changeCallback: function (e) {
            var v = this.get();
            localStorage.setItem('posnote', v);
        }
    });
    if (posnote = localStorage.getItem('posnote')) {
        $('#posnote').redactor('set', posnote);
    }

    $('#poscustomer').change(function (e) {
        localStorage.setItem('poscustomer', $(this).val());
    });


// prevent default action usln enter
    $('body').bind('keypress', function (e) {
        if (e.keyCode == 13) {
            e.preventDefault();
            return false;
        }
    });

// Order tax calculation
    if (site.settings.tax2 != 0) {
        $('#postax2').change(function () {
            localStorage.setItem('postax2', $(this).val());
            loadItems();
            return;
        });
    }

// Order discount calculation
    var old_posdiscount;
    $('#posdiscount').focus(function () {
        old_posdiscount = $(this).val();
    }).change(function () {
        var new_discount = $(this).val() ? $(this).val() : '0';
        if (is_valid_discount(new_discount)) {
            localStorage.removeItem('posdiscount');
            localStorage.setItem('posdiscount', new_discount);
            loadItems();
            return;
        } else {
            $(this).val(old_posdiscount);
            bootbox.alert(lang.unexpected_value);
            return;
        }

    });

    /* ----------------------
     * Delete Row Method
     * ---------------------- */
    var pwacc = false;

    $(document).on('click', '.posdel', function () {

        var countitm = $("#titems").text();
        $('input[name=add_item]').val('');
        var n = countitm.indexOf("1");

        if (n == 0) {
            localStorage.removeItem('posdiscount');
        }
        var row = $(this).closest('tr');
        var item_id = row.attr('data-item-id');
        //alert(JSON.stringify(positems));
        var item_id2 = positems[item_id].item_id;
        if (item_id2 > 0)
        {
            $.ajax({
                type: 'get',
                url: site.base_url + 'sales/updatecart_del',
                dataType: "json",
                data: {
                    item_id2: item_id2
                },
                success: function (data) {
                    return true;
                }
            });
        }


        if (protect_delete == 1) {

            var boxd = bootbox.dialog({
                title: "<i class='fa fa-key'></i> Pin Code",
                message: '<input id="pos_pin" name="pos_pin" type="password" placeholder="Pin Code" class="form-control"> ',
                buttons: {
                    success: {
                        label: "<i class='fa fa-tick'></i> OK",
                        className: "btn-success verify_pin",
                        callback: function () {
                            var pos_pin = md5($('#pos_pin').val());
                            if (pos_pin == pos_settings.pin_code) {
                                // alert(pos_pin);
                                delete positems[item_id];
                                row.remove();
                                if (positems.hasOwnProperty(item_id)) {
                                } else {
                                    localStorage.setItem('positems', JSON.stringify(positems));
                                    loadItems();
                                }
                            } else {
                                bootbox.alert('Wrong Pin Code');
                            }
                        }
                    }
                }
            });
            boxd.on("shown.bs.modal", function () {
                $("#pos_pin").focus().keypress(function (e) {
                    if (e.keyCode == 13) {
                        e.preventDefault();
                        $('.verify_pin').trigger('click');
                        return false;
                    }
                });
            });
        } else {
            /* var is_suspend = 0;
             
             // positems = JSON.parse(localStorage.getItem('positems'));
             $.each(positems, function () {
             var item = this;
             var item_id = site.settings.item_addition == 1 ? item.item_id : item.id;
             if(item.suspend){
             is_suspend = 1;
             }            
             
             }); 
             // alert("is suspend"+is_suspend+"item id"+item_id);
             // return false;
             if(is_suspend){
             $.ajax({
             type: 'get',
             url: getAbsolutePath()+'/pos/deletes',
             dataType: "json",
             data: {
             code: pr_code,
             term: pr_name,
             warehouse_id: $("#poswarehouse").val(),
             customer_id: $("#poscustomer").val(),
             id: row_id_lot
             },
             success: function (res1) {                 
             
             },
             error: function () {
             //$('#notification-bar').text('An error occurred');
             }
             });
             }*/
            delete positems[item_id];
            row.remove();

            if (positems.hasOwnProperty(item_id)) {
            } else {
                localStorage.setItem('positems', JSON.stringify(positems));
                loadItems();
            }
        }
        return false;
    });

    //base url function
    function getAbsolutePath() {
        var loc = window.location;
        var pathName = loc.pathname.substring(0, loc.pathname.lastIndexOf('/') + 1);
        return loc.href.substring(0, loc.href.length - ((loc.pathname + loc.search + loc.hash).length - pathName.length));
    }

    /* -----------------------
     * Edit Row Modal Hanlder
     ----------------------- */
    $(document).on('click', '.edit', function () {

        if ((pos_settings.discount_type === '1') || (pos_settings.discount_type === '3')) {
            //var discount_type = $('#pos_discount_type').val();
            var row = $(this).closest('tr');
            var pr_name = row.children().children('.rname').val();
            var pr_code = row.children().children('.rcode').val();

            //ajax call to fetch lot data. Updated by Chitra
            var row_id_lot = row.children().children('.rid').val();

            $.ajax({
                type: 'get',
                url: site.base_url + 'sales/productslot',
                dataType: "json",
                data: {
                    code: pr_code,
                    term: pr_name,
                    warehouse_id: $("#poswarehouse").val(),
                    customer_id: $("#poscustomer").val(),
                    id: row_id_lot
                },
                success: function (res) {

                    var i = 0;
                    var html_res = '';
                    //var res = res1;

                    if (res != null) {
                        var res_len = res.length;
                        html_res += '<label class="col-sm-4 control-label" >Lot Available</label> ' +
                                '<div class="col-sm-8"><div id="mlotradio" class="select2-container select2-container-disabled form-control pos-input-tip" style="width:100%;"> ';
                        html_res += '<select id="mlotid' + i + '" name = "mlotid" class="mlotid form-control pos-input-tip" style="width:100%;" disabled="disabled">';
                        var gst_taxes;
                        $(res).each(function (k, obj) {
                            gst_taxes = obj.tax;
                            html_res += '<option ';
                            if (res_len <= 1) {
                                html_res += 'selected="true" disabled="disabled"';
                            }
                            else {
                                if (row_id_lot == obj.id) {
                                    html_res += 'selected = "selected"';
                                }
                            }
                            html_res += 'value="' + obj.id + '_' + obj.price + '_' + obj.code + '_' + obj.lot_no + '_' + obj.quantity + '" ';
                            html_res += '> Lot No: ' + parseInt(obj.lot_no) + ', Qty: ' + parseInt(obj.quantity) + ', Price: ' + parseFloat(obj.price).toFixed(2);
                            html_res += '</option>';
                        });
                        html_res += '</select></div></div>';
                        $('#mlot').html(html_res);
                        $("#ptax").val(gst_taxes);
                        $("#ptax").val(gst_taxes)


                    }
                    else {
                        html_res = '';
                        $('#mlot').html(html_res);
                    }
                },
                error: function () {
                    //$('#notification-bar').text('An error occurred');
                }
            });

            var row_id = row.attr('id');
            var rowid = row_id.split('_').pop();
            var dis = $('#discount_' + rowid).val();
            var dis_type = $('#discount_type_' + rowid).val();

            item_id = row.attr('data-item-id');
            item = positems[item_id];

            //alert($("input[type='text'][name='pdiscount'][data-item-id="+item_id+"]").val());
            var qty = row.children().children('.rquantity').val(),
                    product_option = row.children().children('.roption').val(),
                    unit_price = formatDecimal(row.children().children('.realuprice').val()),
                    unit_cost = formatDecimal(row.children().children('.ctype').val()),
                    discount = row.children().children('.rdiscount').val();
            discount_type = row.children().children('.rdiscount_type').val();
            max_discount_percent = row.children().children('.ru_discount').val();
            if ((discount_type === 'employee') || (discount_type === 'replacement')) {
                discount = parseInt(discount);
                $('#pdiscount').attr('readonly', true);

            }

            var sel = $("#pdiscount_reason");
            sel.select2().empty();
            if (discount_type === 'product') {
                $("#pdiscount").val(0);
                $('#dsct_rsn').css('display', 'block');
                //$("select[name='pdiscount_reason'][data-item-id="+item_id+"]").show();
                var data = [{id: 0, text: "--Select Discount Reason--"}, {id: 1, text: "Bulk Order"}, {id: 2, text: "B2B Order"}, {id: 3, text: "Goodwill"}];
                $('#pdiscount_reason').prop('disabled', false);
                $(data).each(function (k, o) {
                    sel.append($("<option></option>").attr("value", o.id).html(o.text));
                });
                sel.select2('val', 0);
            } else if (discount_type === 'promotions') {
                $('#dsct_rsn').css('display', 'block');
                //$("select[name='pdiscount_reason'][data-item-id="+item_id+"]").show();
                $("input[type='text'][name='pdiscount'][data-item-id=" + item_id + "]").prop('disabled', true);
                //$("#pdiscount").val(0);
                var data = [{id: 0, text: "--Select Discount Reason--"}, {id: 4, text: "HIT and HOT"}];

                $(data).each(function (k, o) {
                    sel.append($("<option></option>").attr("value", o.id).html(o.text));
                });
                sel.select2('val', 0);
            } else if (discount_type === 'replacement') {
                var data = [{id: 0, text: ""}];
                $('#dsct_rsn').css('display', 'none');
                //$("select[name='pdiscount_reason'][data-item-id="+item_id+"]").select2();
                $(data).each(function (k, o) {
                    sel.append($("<option></option>").attr("value", o.id).html(o.text));
                });
                sel.select2('val', 0);
            } else {
                var data = [{id: 0, text: "--Select Discount Reason--"}, ];
                //$("select[name='pdiscount_reason'][data-item-id="+item_id+"]").hide();
                $(data).each(function (k, o) {
                    sel.append($("<option></option>").attr("value", o.id).html(o.text));
                });
                sel.select2('val', 0);
            }

            var net_price = unit_price;
            $('#prModalLabel').text(item.row.name + ' (' + item.row.code + ')');
            $('#prModal').attr('data-item-id', item_id);
            $('#pr_popover_content > form').attr('id', 'form_dis_' + item_id);
            // alert($("#form_dis_"+item_id+" input[name='pdiscount']").val());

            if (site.settings.tax1) {
                // $('#ptax').select2('val', item.row.tax_rate);
                // added for gst purpose
                // $('#old_tax').val(item.row.tax_rate);
                $('#ptax').select2('val', item.row.tax_percentage);
                $('#old_tax').val(item.row.tax_percentage);

                var item_discount = 0, ds = discount ? discount : '0';

                if (pos_settings.order_discount_type == 'percent') {
                    var item_discount = parseFloat(((net_price) * parseFloat(ds)) / 100);
                    //(dval / dtotal) * 100;
                    discount_percent = isNaN(item_discount) ? 0 : item_discount;
                } else if (pos_settings.order_discount_type == 'flat') {
                    var item_discount = net_price;
                    item_discount = isNaN(item_discount) ? 0 : item_discount;
                }

                if (ds == 0.00) {
                    item_discount = 0;
                }
                /*if (ds.indexOf("%") !== -1) {
                 var pds = ds.split("%");
                 if (!isNaN(pds[0])) {
                 item_discount = parseFloat(((net_price) * parseFloat(pds[0])) / 100);
                 } else {
                 item_discount = parseFloat(ds);
                 }
                 } else {
                 item_discount = parseFloat(ds);
                 }*/

                net_price -= item_discount;
                // var pr_tax = item.row.tax_rate, pr_tax_val = 0;
                var pr_tax = item.row.tax_percentage, pr_tax_val = 0;
                if (pr_tax !== null && pr_tax != 0) {
                    /*
                     $.each(tax_rates, function () {
                     
                     if (this.id == pr_tax) {
                     if (this.type == 1) { 
                     if (positems[item_id].row.tax_method == 0) {
                     pr_tax_val = formatDecimal(((net_price) * parseFloat(this.rate)) / (100 + parseFloat(this.rate)));
                     pr_tax_rate = formatDecimal(this.rate) + '%';
                     net_price -= pr_tax_val;
                     } else {
                     pr_tax_val = formatDecimal(((net_price) * parseFloat(this.rate)) / 100);
                     pr_tax_rate = formatDecimal(this.rate) + '%';
                     }
                     
                     } else if (this.type == 2) {
                     
                     pr_tax_val = parseFloat(this.rate);
                     pr_tax_rate = this.rate;
                     
                     }
                     }
                     });
                     */

                    var tax_r = pr_tax;
                    /* $.each(tax_rates, function () {
                     
                     if (this.id == pr_tax) {
                     tax_r = this.rate;
                     }
                     });
                     */
                    // alert("net price"+net_price+"tax_r"+tax_r);                           
                    if (positems[item_id].row.tax_method == 0) {
                        pr_tax_val = formatDecimal(((net_price) * parseFloat(tax_r)) / (100 + parseFloat(tax_r)));
                        pr_tax_rate = formatDecimal(tax_r) + '%';
                        net_price -= pr_tax_val;
                    } else {
                        pr_tax_val = formatDecimal(((net_price) * parseFloat(tax_r)) / 100);
                        pr_tax_rate = formatDecimal(tax_r) + '%';
                    }

                }
            }


            if (site.settings.product_serial !== 0) {
                $('#pserial').val(row.children().children('.rserial').val());
            }
            var opt = '<p style="margin: 12px 0 0 0;">n/a</p>';
            if (item.options !== false) {
                var o = 1;
                opt = $("<select id=\"poption\" name=\"poption\" class=\"form-control select\" />");
                $.each(item.options, function () {
                    if (o == 1) {
                        if (product_option == '') {
                            product_variant = this.id;
                        } else {
                            product_variant = product_option;
                        }
                    }
                    $("<option />", {value: this.id, text: this.name}).appendTo(opt);
                    o++;
                });
            }

            //updated by ajay on 29-11-2016
            //alert('dis :' + dis + 'dis_type :'+dis_type);
            $("#form_dis_" + item_id + " select[name='pdiscount_type']").attr('data-item-id', item_id);
            $("#form_dis_" + item_id + " select[name='pdiscount_reason']").attr('data-item-id', item_id);
            $("#form_dis_" + item_id + " input[name='pdiscount']").attr('data-item-id', item_id);

//                    $("select[data-item-id='" + item_id +"']").select2('val',dis_type);
//                    $("input#pdiscount[data-item-id='" + item_id +"']").val(dis);

            $("#form_dis_" + item_id + " select[name='pdiscount_type']").select2("val", discount_type);
            $("#form_dis_" + item_id + " input[name='pdiscount']").val(discount);


            if ((dis_type === 'product')) {
                //$("input#pdiscount[data-item-id='" + item_id +"']").attr('readonly',false);
                $("#form_dis_" + item_id + " input[name='pdiscount']").attr("readonly", false);
            }

            /*******************************/


            $('#poptions-div').html(opt);
            $('select.select').select2({minimumResultsForSearch: 6});
            $('#pquantity').val(qty);
            $('#old_qty').val(qty);
            $('#pprice').val(unit_price);
            $('#punit_price').val(formatDecimal(parseFloat(unit_price) + parseFloat(pr_tax_val)));
            $('#poption').select2('val', item.row.option);
            $('#old_price').val(unit_price);
            $('#row_id').val(row_id);
            $('#pcost').val(unit_cost);

            $('#punit_max_discount').val(max_discount_percent);
            $('#item_id').val(item_id);
            $('#pserial').val(row.children().children('.rserial').val());
            $('#net_price').text(formatMoney(net_price));
            $('#pro_tax').text(formatMoney(pr_tax_val));

            $('#prModal').appendTo("body").modal('show');
        } else {
            bootbox.alert("Line item discount not allowed");
            return false;
        }

    });

    $('#prModal').on('shown.bs.modal', function (e) {
        if ($('#poption').select2('val') != '') {
            $('#poption').select2('val', product_variant);
            product_variant = 0;
        }
    });

    //function to get value of lot on change of lot id. Updated by Chitra

    $(document).on('change', '.mlotid', function () {
        var data = $(this).val().split('_');
        var rowLot = $(this).closest('tr');

        var bid = this.id; // button ID 
        var trid = $("#product-list").closest('tr').attr('id');
        //console.log(bid+" >> "+trid);
        var price = data[1];
        price = Number(price.replace(/[^0-9\.]+/g, ""));
        $('#pprice').val(price);
        $('#net_price').html(price);
        $('#rcode').val(data[2]);
    });

    /*
     * Added by Ajay
     * To change order discount
     * on 2-01-2017
     */

    $(document).on('change', '#discount_type', function () {
        var value = $('#discount_type option:selected').val();
        var discount = $('#order_discount_input').val();

        if (discount === 0) {
            $('#discout_reason_input').attr('readonly', true);
        } else {
            $('#discout_reason_input').attr('readonly', false);
        }
    });

    function roundToTwo(value) {
        return(Math.round(value * 100) / 100);
    }

    $(document).on('change', '#pprice, #ptax, #pdiscount,#pdiscount_type', function () {

        var row = $('#' + $('#row_id').val());
        var item_id = $(this).attr('data-item-id');

        var unit_price = parseFloat($('#pprice').val());
        var item = positems[item_id];

        $(this).closest("select[name='pdiscount_type']").attr('data-item-id', item_id);
        var pdiscount_type = $("select[data-item-id='" + item_id + "']").select2('val');
        //alert(pdiscount_type);
        var item_discount = 0;
        var ds = $('#pdiscount').val() ? $('#pdiscount').val() : '0';
        ds = ds.replace('%', '');
        // alert("discoubt"+ds+"item_id"+item_id+"unit price"+unit_price+"row"+row);

        if (!isNaN(ds)) {
            if (pos_settings.order_discount_type == 'percent') {
                if (ds > 100) {
                    bootbox.alert("Discount % cannot be greater than 100%");
                    $('#pdiscount').val(0);
                    return false;
                }
                else if (pdiscount_type == 'replacement') {
                    item_discount = parseFloat(((unit_price) * parseFloat(ds)) / 100);
                    $('#pdiscount').val('35');

                }
                else if (pdiscount_type == 'employee') {
                    item_discount = parseFloat(((unit_price) * parseFloat(ds)) / 100);
                    $('#pdiscount').val('40');
                    $('#pdiscount').attr('readonly', true);
                } else if (pdiscount_type == 'promotions') {
                    var pr_discount = $(".rpromotion[data-item-id='" + item_id + "']").val();
                    if (pr_discount == '1') {
                        if (unit_price > 1999) {
                            var disc = roundToTwo((100 * (unit_price - 1999)) / unit_price);
                            item_discount = parseFloat(((unit_price) * parseFloat(disc)) / 100);
                            $('#pdiscount').val(disc);
                            $('#pdiscount').attr('readonly', true);
                        } else {
                            $('#pdiscount').attr('readonly', true);
                            bootbox.alert("Promotion discount is greater than unit price!");
                            return false;
                        }
                    } else {
                        $('#pdiscount').attr('readonly', true);
                        bootbox.alert("Promotion discount not allowed!");
                        return false;
                    }
                } else {
                    item_discount = parseFloat(((unit_price) * parseFloat(ds)) / 100);
                }
            }
            else
            {
                if (pos_settings.order_discount_type == 'flat')
                {
                    if (parseFloat(ds) > $('#pprice').val()) {
                        bootbox.alert("Discount price cannot be greater than unit price");
                        $('#pdiscount').val(0);
                        return false;
                    }
                    else if (discount_type == 'replacement') {
                        item_discount = parseFloat(ds);
                    }
                    else if (discount_type == 'employee') {
                        item_discount = parseFloat(ds);
                    }
                    item_discount = parseFloat(ds);
                }
            }
        }

        /*if (pos_settings.order_discount_type == 'percent') {
         var item_discount = parseFloat(((net_price) * parseFloat(ds)) / 100);
         //(dval / dtotal) * 100;
         discount_percent = isNaN(item_discount) ? 0 : item_discount;
         } else if (pos_settings.order_discount_type == 'flat') {
         var item_discount = net_price;
         item_discount = isNaN(item_discount) ? 0 : item_discount;
         }
         
         if (ds == 0.00) {
         item_discount = 0;
         }*/

        /*var pdiscount_type = $('#pdiscount_type option:selected').val();
         var ds = $('#pdiscount').val() ? $('#pdiscount').val() : '0';
         
         if (ds.indexOf("%") !== -1) {
         var pds = ds.split("%");
         if (!isNaN(pds[0])) {
         
         if(pds[0]>100){
         bootbox.alert("Discount % cannot be greater than 100%");
         $('#pdiscount').val(0);
         return false;
         }
         else if(pdiscount_type=='replacement'){
         item_discount = parseFloat(((unit_price) * parseFloat(pds[0])) / 100);
         }
         else if(pdiscount_type=='employee'){
         item_discount = parseFloat(((unit_price) * parseFloat(pds[0])) / 100);
         }else{
         item_discount = parseFloat(((unit_price) * parseFloat(pds[0])) / 100);
         }
         } else {
         item_discount = parseFloat(ds);
         }
         } else {
         if(parseFloat(ds) > $('#pprice').val()){
         bootbox.alert("Discount price cannot be greater than unit price");
         $('#pdiscount').val(0);
         return false;
         }
         else if(discount_type=='replacement'){
         item_discount = parseFloat(ds);
         }
         else if(discount_type=='employee'){
         item_discount = parseFloat(ds);
         }
         item_discount = parseFloat(ds);
         
         }*/


        var pr_tax = $('#ptax').val();

        var pr_tax_val = 0;
        if (pr_tax !== null && pr_tax != 0) {
            var tax_r;
            /* $.each(tax_rates, function () {                
             if (this.id == pr_tax) {
             tax_r = this.rate;
             
             }
             });*/
            tax_r = pr_tax;

            unit_price -= item_discount;
            if (positems[item_id].row.tax_method == 0) {
                pr_tax_val = formatDecimal(((unit_price) * parseFloat(tax_r)) / (100 + parseFloat(tax_r)));
                pr_tax_rate = formatDecimal(tax_r) + '%';
                unit_price -= pr_tax_val;
            } else {
                pr_tax_val = formatDecimal(((unit_price) * parseFloat(tax_r)) / 100);
                pr_tax_rate = formatDecimal(tax_r) + '%';
                unit_price -= pr_tax_val;
            }

        }

        $("select[data-item-id='" + item_id + "']").select2('val', pdiscount_type);
        $('#net_price').text(formatDecimal(unit_price));
        $('#pro_tax').text(formatDecimal(pr_tax_val));

    });

    /* -----------------------
     * Edit Row Method
     ----------------------- */
    $(document).on('click', '#editItem', function () {
        var row = $('#' + $('#row_id').val());
        var item_id = row.attr('data-item-id');
        var net_unit_price = $('#net_price').text();
        var net_tax_val = $('#pro_tax').text();
        //lot variables added to get lot data. Updated by Chitra
        var pdiscount_type = $('#pdiscount_type option:selected').val();

        if ($("#mlot").html()) {
            var lot_no = $(".mlotid option:selected").val().split('_');
            var lot_id = lot_no[0];
            var lot_bal_qty = lot_no[4];
        }
        else {
            var lot_id = row.children().children('.rid').val();
            var lot_bal_qty = row.children().children('.quantity').html();
        }
        //var lot_id = row.children().children('.rid').val();
        //var lot_bal_qty = row.children().children('.quantity').html();
        //var item_id = row.attr('data-item-id');
        new_pr_tax = $('#ptax').val(), new_pr_tax_rate = {};
        if (new_pr_tax) {
            $.each(tax_rates, function () {
                if (this.id == new_pr_tax) {
                    new_pr_tax_rate = this;
                }
            });
        } else {
            new_pr_tax_rate = false;
        }

        var cost = parseFloat($('#pcost').val());
        var price = parseFloat($('#pprice').val());

        var max_discount = parseFloat($('#discout_percent').val()) ? parseFloat($('#discout_percent').val()) : 0;
        //alert(max_discount);

        /*var ds = $('#pdiscount').val() ? $('#pdiscount').val() : '0';
         var ds_percent;
         if (ds.indexOf("%") !== -1) {
         var pds = ds.split("%");
         if (!isNaN(pds[0])) {
         item_discount = parseFloat(((price) * parseFloat(pds[0])) / 100);
         
         } else {
         item_discount = parseFloat(ds);
         }
         } else {
         item_discount = parseFloat(ds);
         }*/

        var item_discount = 0;
        var ds = $('#pdiscount').val() ? $('#pdiscount').val() : '0';
        var ds_percent;

        if (!isNaN(ds)) {
            if (pos_settings.order_discount_type == 'percent') {
                item_discount = parseFloat(((price) * parseFloat(ds)) / 100);
            }
            else
            {
                item_discount = parseFloat(ds);
            }
        }
        ds_percent = parseFloat((item_discount / price) * 100);
        price -= item_discount;

        var max_discount_value = parseFloat(($('#pprice').val() * max_discount) / 100);

        if (max_discount_value > price) {
            bootbox.alert("discount greater than price");
            return;
        }
        var max_discounted_price = parseFloat($('#pprice').val()) - parseFloat(max_discount_value);
        //var net_price = parseFloat($('#pprice').val()) - parseFloat($('#pdiscount').val());
        var net_price = price;

        //Upodates by Chitra
        //alert(net_price+" < "+max_discounted_price+", Max discount: "+max_discount_value);return false;

        if (pdiscount_type === "") {
            bootbox.alert('Please select discount type');
            return false;
        }
        if (pdiscount_type == 'replacement') {
            // alert(1)
            bootbox.alert('Replacement discount applied!');
            addRowToPOS(row, lot_id, lot_bal_qty, item_id, new_pr_tax, new_pr_tax_rate, net_unit_price, net_tax_val, pdiscount_type);
            return;
        }
        if (pdiscount_type == 'promotions') {
            var pr_discount = $(".rpromotion[data-item-id='" + item_id + "']").val();
            //alert('pr_discount :'+pr_discount+'type :'+typeof(pr_discount));
            if (pr_discount == '1') {
                bootbox.alert('Promotions discount applied!');
                addRowToPOS(row, lot_id, lot_bal_qty, item_id, new_pr_tax, new_pr_tax_rate, net_unit_price, net_tax_val, pdiscount_type);
            } else {
                bootbox.alert("Promotion discount not allowed");
                return false;
            }
        }
        else if (pdiscount_type == 'employee') {
            bootbox.alert('Employee discount applied!');
            addRowToPOS(row, lot_id, lot_bal_qty, item_id, new_pr_tax, new_pr_tax_rate, net_unit_price, net_tax_val, pdiscount_type);
        }
        else if (net_price < max_discounted_price) {
            var users;
            var logged_in
            //var logged_in_discount = $('#logged_in_discount').val();
            $.post(site.base_url + 'pos/getAllUsers', function (data, status) {
                users = jQuery.parseJSON(data);
                if (users.logged_in_user) {
                    logged_in = true;
                } else {
                    logged_in = false;
                }
//                        var options = $("#users1");
//                        $.each(users, function(index,val) {
//                            options.append($("<option />").val(val.id).text(val.username));
//                        });
                if (!logged_in) {
                    bootbox.dialog({
                        title: "Authenticate for Discount",
                        message: '<div class="row">  ' +
                                '<div class="col-md-12"> ' +
                                '<form class="form-horizontal" role="form" data-toggle="validator">' +
                                '<div class="form-group"> ' +
                                '<label class="col-md-4 control-label" for="users"> Enter Username</label> ' +
                                '<div class="col-md-8"> ' +
                                '<input type="text" class="form-control kb-text" placeholder="Your Username" id="users1" required="required">' +
                                '</div></div> ' +
                                '<div class="form-group"> ' +
                                '<label class="col-md-4 control-label" for="psw">Password</label> ' +
                                '<div class="col-md-8">' +
                                '<input id="password" name="password" type="password" data-minlength="8" placeholder="Your password" class="form-control kb-text input-md" required="required">  ' +
                                ' <div class="help-block">Minimum of 8 characters</div>' +
                                '</div> </div>' +
                                '</form> </div>  </div>',
                        buttons: {
                            success: {
                                label: "Authenticate",
                                className: "btn-success",
                                callback: function () {
                                    //var user = $("#users1 option:selected").text();
                                    var user = $("#users1").val();
                                    var pwd = $('#password').val();
                                    if ((user == null) || (user == undefined) || (user == '')) {
                                        bootbox.alert("username required");
                                        return false;
                                    }
                                    if ((pwd == null) || (pwd == undefined) || (pwd == '')) {
                                        bootbox.alert("password required");
                                        return false;
                                    }

                                    $.ajax({
                                        type: "POST",
                                        url: site.base_url + 'pos/authenticate_discount',
                                        data: {"username": user, "password": pwd, "discount": ds_percent},
                                        datatype: "json",
                                        success: function (cdata) {
                                            var data = jQuery.parseJSON(cdata);
                                            console.log(JSON.stringify(data));
                                            if (data.status === 'success') {
                                                var user_max_discount = parseFloat(data.userdata.show_discount);
                                                var pprice = parseFloat($("#pprice").val());
                                                //changes for replacement discount
                                                var user_max_discount_value = 0;
                                                if (user_max_discount > 0) {
                                                    user_max_discount_value = parseFloat((pprice * user_max_discount) / 100);
                                                } else {
                                                    user_max_discount_value = 0;
                                                }
                                                if ((Number(user_max_discount_value) - Number(item_discount)) >= 0) {
                                                    console.log("discount allowed");
                                                    addRowToPOS(row, lot_id, lot_bal_qty, item_id, new_pr_tax, new_pr_tax_rate, net_unit_price, net_tax_val, pdiscount_type);
                                                } else {
                                                    bootbox.alert('You are not authorised to apply more than ' + data.userdata.show_discount + '% (' + item_discount + ') discount');
                                                    return;
                                                }
                                            } else {
                                                bootbox.alert('Please check your credentials or permissions to allow discount!');
                                                return;
                                            }
                                        }
                                    });

                                }
                            }
                        }
                    });
                } else {

                    var pprice = parseFloat($("#pprice").val());
                    var logged_user_max_discount = $('#discount_percent').val();
                    var user_max_discount_value = 0;
                    if (logged_user_max_discount > 0) {
                        user_max_discount_value = parseFloat((pprice * logged_user_max_discount) / 100);
                    } else {
                        user_max_discount_value = 0;
                    }

                    if (user_max_discount_value >= item_discount) {
                        addRowToPOS(row, lot_id, lot_bal_qty, item_id, new_pr_tax, new_pr_tax_rate, net_unit_price, net_tax_val, pdiscount_type);
                    } else {
                        bootbox.alert('You are not authorised to apply more than ' + logged_user_max_discount + '% (' + user_max_discount_value + ') discount');
                        return;
                    }
                }
            });
        } else {

            //lot_id,lot_bal_qty variables added to function to get value of lot variables. Updated by Chitra
            addRowToPOS(row, lot_id, lot_bal_qty, item_id, new_pr_tax, new_pr_tax_rate, net_unit_price, net_tax_val, pdiscount_type);
            //bootbox.alert('You are not allowed for discount more than ' + max_discount + '%');
            //return;
        }
    });

    /*****************Added by ajay on 12-04-2016 to load row on POS add items*********************/

    function addRowToPOS(row, lot_id, lot_bal_qty, item_id, new_pr_tax, new_pr_tax_rate, net_unit_price, net_tax_val, pdiscount_type) {
        localStorage.removeItem('logged_in_user');
        //changes to find lot id, bal qty and proce for lot. Updated by Chitra
        var td = row.find("td").closest('tr');
        $(td).find(".rid").each(function () {
            rid = this.value;
            if (lot_id != '') {
                rid = lot_id;
            }
            else {
                rid = td.find(".rid").val();
            }
        });

        $(td).find(".balquantity").each(function () {
            //console.log("before "+this.value);
            bqty = this.html;
            if (lot_bal_qty != '') {
                bqty = lot_bal_qty;
            }
            else {
                bqty = td.find(".balquantity").html();
            }
        });

        var price = parseFloat($('#pprice').val());

        if (site.settings.product_discount == 1 && $('#pdiscount').val()) {
            if (!is_valid_discount($('#pdiscount').val()) || $('#pdiscount').val() > price) {
                bootbox.alert(lang.unexpected_value);
                return false;
            }
        }

        //alert('new tax:'+ new_pr_tax);
        var product_discount = $('#pdiscount').val();
        product_discount = product_discount.replace('%', '');
        //alert("Add ---- "+product_discount);

        var fpds = $('#pdiscount').val() ? $('#pdiscount').val() : '';

        //lot related variable updated by Chitra

        positems[item_id].row.qty = parseFloat($('#pquantity').val()),
                positems[item_id].row.real_unit_price = price,
                positems[item_id].row.net_unit_cost = net_unit_price;
        positems[item_id].row.item_tax = net_tax_val;
        positems[item_id].row.tax_rate = new_pr_tax,
                positems[item_id].tax_rate = new_pr_tax_rate,
                positems[item_id].row.discount = fpds.replace('%', ''),
                positems[item_id].row.discount_type = pdiscount_type;
        positems[item_id].row.option = $('#poption').val() ? $('#poption').val() : '',
                positems[item_id].row.id = rid,
                positems[item_id].item_id = rid,
                positems[item_id].row.price = $("#pprice").val(),
                //pprice
                positems[item_id].row.serial = $('#pserial').val();
        //bootbox.alert(JSON.stringify(positems));return false;

        localStorage.setItem('positems', JSON.stringify(positems));

        $('#prModal').modal('hide');

        $("#prModal").removeClass("in");
        $(".modal-backdrop").remove();
        $("#prModal").hide();
        loadItems();
        return;
    }




    /*******************************************************/


    /* -----------------------
     * Product option change
     ----------------------- */
    $(document).on('change', '#poption', function () {
        var row = $('#' + $('#row_id').val()), opt = $(this).val();
        var item_id = row.attr('data-item-id');
        var item = positems[item_id];
        if (item.options !== false) {
            $.each(item.options, function () {
                if (this.id == opt && this.price != 0) {
                    $('#pprice').val(this.price);
                }
            });
        }
    });

    /* ------------------------------
     * Sell Gift Card modal
     ------------------------------- */
    /*$(document).on('click', '#sellGiftCard', function (e) {
     if (count == 1) {
     positems = {};
     if ($('#poswarehouse').val() && $('#poscustomer').val()) {
     $('#poscustomer').select2("readonly", true);
     $('#poswarehouse').select2("readonly", true);
     } else {
     bootbox.alert(lang.select_above);
     item = null;
     return false;
     }
     }
     $('.gcerror-con').hide();
     $('#gcModal').appendTo("body").modal('show');
     return false;
     });*/

    $('#gccustomer').select2({
        minimumInputLength: 1,
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

    /*$('#genNo').click(function () {
     var no = generateCardNo();
     $(this).parent().parent('.input-group').children('input').val(no);
     return false;
     });*/

    $('.date').datetimepicker({format: site.dateFormats.js_sdate, fontAwesome: true, language: 'sma', todayBtn: 1, autoclose: 1, minView: 2});

    $(document).on('click', '#addGiftCard', function (e) {
        var mid = (new Date).getTime(),
                gccode = $('#gccard_no').val(),
                gcname = $('#gcname').val(),
                gcvalue = $('#gcvalue').val(),
                gccustomer = $('#gccustomer').val(),
                gcexpiry = $('#gcexpiry').val() ? $('#gcexpiry').val() : '',
                gcprice = formatMoney($('#gcprice').val());
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
        //if (typeof positems === "undefined") {
        //    var positems = {};
        //}

        $.ajax({
            type: 'get',
            url: site.base_url + 'sales/sell_gift_card',
            dataType: "json",
            data: {gcdata: gc_data},
            success: function (data) {
                if (data.result === 'success') {
                    positems[mid] = {"id": mid, "item_id": mid, "label": gcname + ' (' + gccode + ')', "row": {"id": mid, "code": gccode, "name": gcname, "quantity": 1, "price": gcprice, "real_unit_price": gcprice, "tax_rate": 0, "qty": 1, "type": "manual", "discount": "0", "serial": "", "option": ""}, "tax_rate": false, "options": false};
                    localStorage.setItem('positems', JSON.stringify(positems));
                    loadItems();
                    $('#gcModal').modal('hide');
                    $('#gccard_no').val('');
                    $('#gcvalue').val('');
                    $('#gcexpiry').val('');
                    $('#gcprice').val('');
                } else {
                    $('#gcerror').text(data.message);
                    $('.gcerror-con').show();
                }
            }
        });
        return false;
    });

    /* ------------------------------
     * Show manual item addition modal
     ------------------------------- */
    $(document).on('click', '#addManually', function (e) {
        if (count == 1) {
            positems = {};
            if ($('#poswarehouse').val() && $('#poscustomer').val()) {
                $('#poscustomer').select2("readonly", true);
                $('#poswarehouse').select2("readonly", true);
            } else {
                bootbox.alert(lang.select_above);
                item = null;
                return false;
            }
        }
        $('#mnet_price').text('0.00');
        $('#mpro_tax').text('0.00');
        $('#mModal').appendTo("body").modal('show');
        return false;
    });

    $(document).on('click', '#addItemManually', function (e) {
        var mid = (new Date).getTime(),
                mcode = $('#mcode').val(),
                mname = $('#mname').val(),
                mtax = parseInt($('#mtax').val()),
                mqty = parseFloat($('#mquantity').val()),
                mdiscount = $('#mdiscount').val() ? $('#mdiscount').val() : '0',
                unit_price = parseFloat($('#mprice').val()),
                mtax_rate = {};
        $.each(tax_rates, function () {
            if (this.id == mtax) {
                mtax_rate = this;
            }
        });

        positems[mid] = {"id": mid, "item_id": mid, "label": mname + ' (' + mcode + ')', "row": {"id": mid, "code": mcode, "name": mname, "quantity": mqty, "price": unit_price, "unit_price": unit_price, "real_unit_price": unit_price, "tax_rate": mtax, "tax_method": 0, "qty": mqty, "type": "manual", "discount": mdiscount, "serial": "", "option": ""}, "tax_rate": mtax_rate, "options": false};
        localStorage.setItem('positems', JSON.stringify(positems));
        loadItems();
        $('#mModal').modal('hide');
        $('#mcode').val('');
        $('#mname').val('');
        $('#mtax').val('');
        $('#mquantity').val('');
        $('#mdiscount').val('');
        $('#mprice').val('');
        return false;
    });

    $(document).on('change', '#mprice, #mtax, #mdiscount', function () {
        var unit_price = parseFloat($('#mprice').val());
        var ds = $('#mdiscount').val() ? $('#mdiscount').val() : '0';
        if (!isNaN(ds)) {
            if (pos_settings.order_disscount_type == 'percent') {
                item_discount = parseFloat(((unit_price) * parseFloat(ds)) / 100);
            }
            else {
                item_discount = parseFloat(ds);
            }
        }

        /*if (ds.indexOf("%") !== -1) {
         var pds = ds.split("%");
         if (!isNaN(pds[0])) {
         item_discount = parseFloat(((unit_price) * parseFloat(pds[0])) / 100);
         } else {
         item_discount = parseFloat(ds);
         }
         } else {
         item_discount = parseFloat(ds);
         }*/
        unit_price -= item_discount;
        var pr_tax = $('#mtax').val(), item_tax_method = 0;
        var pr_tax_val = 0, pr_tax_rate = 0;
        if (pr_tax !== null && pr_tax != 0) {
            $.each(tax_rates, function () {
                if (this.id == pr_tax) {
                    if (this.type == 1) {

                        if (item_tax_method == 0) {
                            pr_tax_val = formatDecimal(((unit_price) * parseFloat(this.rate)) / (100 + parseFloat(this.rate)));
                            pr_tax_rate = formatDecimal(this.rate) + '%';
                            unit_price -= pr_tax_val;
                        } else {
                            pr_tax_val = formatDecimal(((unit_price) * parseFloat(this.rate)) / 100);
                            pr_tax_rate = formatDecimal(this.rate) + '%';
                        }

                    } else if (this.type == 2) {

                        pr_tax_val = parseFloat(this.rate);
                        pr_tax_rate = this.rate;

                    }
                }
            });
        }

        $('#mnet_price').text(formatMoney(unit_price));
        $('#mpro_tax').text(formatMoney(pr_tax_val));
    });

    /* --------------------------
     * Edit Row Quantity Method
     -------------------------- */

    $(document).on("change", '.rquantity', function () {
        var row = $(this).closest('tr');
        if (!is_numeric($(this).val()) || $(this).val() == 0) {
            loadItems();
            bootbox.alert(lang.unexpected_value);
            return false;
        }
        var new_qty = parseFloat($(this).val()),
                item_id = row.attr('data-item-id');
        positems[item_id].row.qty = new_qty;
        localStorage.setItem('positems', JSON.stringify(positems));
        loadItems();
    });


// end ready function
});

/* -----------------------
 * Load all items
 ----------------------- */

//localStorage.clear();
/*
 * Altered by ajay
 * 07-04-2016
 */
function loadItems(items) {
    var order_disc = 0;
    var suspend_flag = 0;
    items = items || false;
    jQuery(window).bind("unload", function () {
        localStorage.removeItem('posdiscountreason');
    });

    if (localStorage.getItem('positems')) {  //alert ("get positems");
        total = 0;
        count = 1;
        an = 1;
        product_tax = 0;
        invoice_tax = 0;
        product_discount = 0;
        order_discount = 0;
        total_discount = 0;
        $("#posTable tbody").empty();
        if (java_applet == 1) {
            order_data = "";
            bill_data = "";
            bill_data += chr(27) + chr(69) + "\r" + chr(27) + "\x61" + "\x31\r";
            bill_data += site.settings.site_name + "\n\n";
            order_data = bill_data;
            bill_data += "Bill" + "\n";
            order_data += "Order" + "\n";
            bill_data += $('#select2-chosen-1').text() + "\n\n";
            bill_data += " \x1B\x45\x0A\r\n ";
            order_data += $('#select2-chosen-1').text() + "\n\n";
            order_data += " \x1B\x45\x0A\r\n ";
            bill_data += "\x1B\x61\x30";
            order_data += "\x1B\x61\x30";
        } else {
            $("#order_span").empty();
            $("#bill_span").empty();
            var pos_head1 = '<span style="text-align:center;"><h3>' + site.settings.site_name + '</h3><h4>'
            var pos_head2 = '</h4><h5>' + $('#select2-chosen-1').text() + '<br>' + Date() + '</h5></span>';
            $("#order_span").prepend(pos_head1 + ' Order ' + pos_head2);
            $("#bill_span").prepend(pos_head1 + ' Bill ' + pos_head2);
            $("#order-table").empty();
            $("#bill-table").empty();
        }
        positems = JSON.parse(localStorage.getItem('positems'));


        /********Added by ajay on 07-04-2016 to add balance quantity on POS screen***********/

        var itemid = items.item_id;
        var cont = 0;
        var poss = [];
        var i = 0;
        $.each(positems, function (k, v) {
            poss[i] = v;
            if (itemid == v.item_id) {
                cont = cont + 1;
            }
            i++;
        });


        /**********************************************************/
        //alert("possss"+JSON.stringify(positems));
        $.each(positems, function () {

            var item = this;
            var item_id = site.settings.item_addition == 1 ? item.item_id : item.id;
            /**Altered by ajay on 7-04-2016 to subtract quantity on balance quantity*****/
            if (itemid === item.row.id && item.row.quantity >= 0 && cont == 1) {
                //item.row.quantity = item.row.quantity - 1;
            }

            /**********************************/
            //console.log("order discount",item.order_discount);
            if (item.suspend) {
                suspend_flag++;
                // order_disc = item.orderdisc;
            }
            var product_id = item.row.id, item_type = item.row.type, combo_items = item.combo_items, item_price = item.row.price, item_qty = 1, item_aqty = item.row.quantity, item_tax_method = item.row.tax_method, item_ds = item.row.discount, item_discount = 0, item_option = item.row.option, item_code = item.row.code, item_serial = item.row.serial, item_name = item.row.name.replace(/"/g, "&#034;").replace(/'/g, "&#039;");
            var unit_price = item.row.real_unit_price;
            var unit = item.row.unit;
            var ds = item_ds ? item_ds : '0';
            ds = ds.replace('%', '');
            if (!isNaN(ds)) {
                if (pos_settings.order_discount_type == 'percent') {
                    item_discount = formatDecimal(parseFloat(((unit_price) * parseFloat(ds)) / 100));
                }
                else if (pos_settings.order_discount_type == 'flat') {
                    item_discount = parseFloat(ds);
                }
            }

            /*if (ds.indexOf("%") !== -1) {
             var pds = ds.split("%");
             if (!isNaN(pds[0])) {
             item_discount = formatDecimal(parseFloat(((unit_price) * parseFloat(pds[0])) / 100));
             } else {
             item_discount = formatDecimal(ds);
             }
             } else {
             item_discount = parseFloat(ds);
             }*/
            //console.log(item_discount);
            product_discount += parseFloat(item_discount * item_qty);
            //console.log("Pr ds --- "+product_discount);
            //console.log("Item ds ---- "+item_discount);
            unit_price = formatDecimal(unit_price - item_discount);
            var pr_tax = item.tax_rate;
            var pr_tax_val = 0, pr_tax_rate = 0;
            if (site.settings.tax1 == 1) {
                if (pr_tax !== false) {
                    if (pr_tax.type == 1) {

                        if (item_tax_method == '0') {
                            pr_tax_val = formatDecimal(((unit_price) * parseFloat(pr_tax.rate)) / (100 + parseFloat(pr_tax.rate)));
                            pr_tax_rate = formatDecimal(pr_tax.rate) + '%';
                        } else {
                            pr_tax_val = formatDecimal(((unit_price) * parseFloat(pr_tax.rate)) / 100);
                            pr_tax_rate = formatDecimal(pr_tax.rate) + '%';
                        }

                    } else if (pr_tax.type == 2) {

                        pr_tax_val = parseFloat(pr_tax.rate);
                        pr_tax_rate = pr_tax.rate;

                    }
                    product_tax += pr_tax_val * item_qty;

                }
            }

            item_price = item_tax_method == 0 ? formatDecimal(unit_price - pr_tax_val) : formatDecimal(unit_price);
            unit_price = formatDecimal(unit_price + item_discount);
            var sel_opt = '';
            $.each(item.options, function () {
                if (this.id == item_option) {
                    sel_opt = this.name;
                }
            });

            if (item.suspend) {
                var balance_quantity = (item.row.quantity < 0) ? 'OS' : item.row.quantity;
            } else {
                var balance_quantity = (item.row.quantity < 0) ? 'AB' : item.row.quantity;
            }

            //if(item.overselling){
            /*
             if(product_discount > 0){
             $('.tip pointer').removeClass('.edit');
             }else if(product_discount == 0){
             $('.tip pointer').addClass('.edit');
             }
             */

            //var row_no = (new Date).getTime();
            var row_no = item_id;
            var newTr = $('<tr id="row_' + row_no + '" class="row_' + item_id + '" data-item-id="' + item_id + '"></tr>');

            //console.log("111111111111111");
            console.log(pr_tax)
            tr_html = '<td><input name="product_id[]" type="hidden" class="rid" value="' + product_id + '">'
            tr_html += '<input name="product_type[]" type="hidden" class="rtype" value="' + item_type + '">';
            tr_html += '<input name="product_cost[]" type="hidden" class="ctype" value="' + item.row.cost + '">';
            tr_html += '<input name="product_code[]" type="hidden" class="rcode" value="' + item_code + '">';
            tr_html += '<input name="product_name[]" type="hidden" class="rname" value="' + item_name + '">';
            tr_html += '<input name="product_hsn[]" id="hsn_' + row_no + '" data-item-id="' + item_id + '" type="hidden" class="rhsn" value="' + item.row.hsn + '">';
            tr_html += '<input name="product_promotion[]" id="promotion_' + row_no + '" data-item-id="' + item_id + '" type="hidden" class="rpromotion" value="' + item.row.promotion + '">';
            tr_html += '<input name="product_option[]" type="hidden" class="roption" value="' + item_option + '">';
            tr_html += '<span class="sname" id="name_' + row_no + '">';
            //tr_html += item_name + ' (' + item_code + ')</span>';
            tr_html += '' + item_code + '</span>';
            tr_html += '<i class="pull-right fa fa-edit tip pointer edit" id="' + row_no + '" ';
            tr_html += 'data-item="' + item_id + '" title="Edit" style="cursor:pointer;"></i>';
            tr_html += '</td>';
            tr_html += '<td class="text-center"><span class="text-center" id="mrp_' + row_no + '">' + formatMoney(item.row.price) + '</span></td>';
            tr_html += '<td class="text-right">';
            //console.log("22222222222222");console.log(site.settings);
            if (site.settings.product_serial == 1) {
                tr_html += '<input class="form-control input-sm rserial" name="serial[]" type="hidden" id="serial_' + row_no + '" value="' + item_serial + '">';
            }
            if (site.settings.product_discount == 1) {
                //item.row.discount_type = "";
                tr_html += '<input class="form-control input-sm rdiscount" name="product_discount[]" type="hidden" id="discount_' + row_no + '" value="' + item_ds + '">';
                tr_html += '<input class="form-control input-sm rdiscount_type" name="product_discount_type[]" type="hidden" id="discount_type_' + row_no + '" value="' + item.row.discount_type + '">';
            }
            if (site.settings.tax1 == 1) {
                tr_html += '<input class="form-control input-sm text-right rproduct_tax" name="product_tax[]" type="hidden" id="product_tax_' + row_no + '" value="' + pr_tax.id + '"><input type="hidden" class="sproduct_tax" id="sproduct_tax_' + row_no + '" value="' + formatMoney(pr_tax_val * item_qty) + '">';
            }
            tr_html += '<input class="rprice" name="net_price[]" type="hidden" id="price_' + row_no + '" value="' + item_price + '">';
            tr_html += '<input class="ruprice" name="unit_price[]" type="hidden" value="' + unit_price + '">';
            tr_html += '<input class="ru_discount" name="ru_discount[]" type="hidden" value="' + item.row.max_discount + '">';
            tr_html += '<input class="realuprice" name="real_unit_price[]" type="hidden" value="' + item.row.real_unit_price + '">';
            tr_html += '<input class="realucost" name="ru_unit_cost[]" type="hidden" value="' + item.row.net_unit_cost + '">';
            tr_html += '<input class="u_item_tax" name="u_item_tax[]" type="hidden" value="' + item.row.item_tax + '">';

            tr_html += '<input class="u_item_discount" name="u_item_discount[]" type="hidden" value="' + item.row.discount + '">';
            //tr_html += '<span class="text-right sprice" id="sprice_' + row_no + '">' + formatMoney(parseFloat(item_price) + parseFloat(pr_tax_val)) + '</span></td>';
            tr_html += '<span class="text-right sprice" id="sprice_' + row_no + '">' + formatMoney(item.row.net_unit_cost) + '</span></td>';
//added readonly so that value cannot be updated more than 1 
            tr_html += '<td><input class="form-control kb-pad text-center rquantity" name="quantity[]" type="text" readonly value="' + formatDecimal(item_qty) + '" data-id="' + row_no + '" data-item="' + item_id + '" id="quantity_' + row_no + '" onClick="this.select();"></td>';
            /*tr_html += '<td class="text-right"><span class="text-right quantity" id="bquantity_' + row_no + '">' + formatMoney(item.row.item_tax) + ' ('+item.tax_rate.name+')</span></td>';*/
            // applying sgst and scgst

            var gst_amount = item.row.item_tax / 2;
            var gst_tax = item.row.tax_percentage / 2;
            tr_html += '<td class="text-right"><span class="text-right quantity" id="bquantity_' + row_no + '">' + formatMoney(gst_amount) + ' (' + gst_tax + '% TAX)</span></td>';
            tr_html += '<td class="text-right"><span class="text-right quantity" id="bquantity_' + row_no + '">' + formatMoney(gst_amount) + ' (' + gst_tax + '% TAX)</span></td>';

            if (pos_settings.order_discount_type == 'percent') {
                //alert(parseFloat(item.row.discount));
                if (isEmpty(item.row.discount)) {
                    item.row.discount = 0;
                }
                tr_html += '<td class="text-right"><span class="text-right quantity" id="unit_' + row_no + '">' + item.row.discount + '%</span></td>';

            }
            else {
                tr_html += '<td class="text-right"><span class="text-right quantity" id="unit_' + row_no + '">' + formatMoney(item.row.discount) + '</span></td>';
            }

            tr_html += '<td class="text-right"><span class="text-right ssubtotal" id="subtotal_' + row_no + '">' + formatMoney(((parseFloat(item_price) + parseFloat(pr_tax_val)) * parseFloat(item_qty))) + '</span></td>';
            tr_html += '<td class="text-center"><i class="fa fa-times tip pointer posdel" id="' + row_no + '" title="Remove" style="cursor:pointer;"></i></td>';
            newTr.html(tr_html);

            if (item.overselling == 0) {
                if (item.row.quantity < 0) {
                    //bootbox.alert('Out of stock');
                    newTr.prependTo('');
                    return false;
                }
            }

            newTr.prependTo("#posTable");
            $('#add_item').removeClass('ui-autocomplete-loading');
            //alert("item_qty"+item_qty);							
            total += formatDecimal(((parseFloat(item_price) + parseFloat(pr_tax_val)) * parseFloat(item_qty)));
            count += parseFloat(item_qty);//alert(count);
            an++;
            if (item_type == 'standard' && item.options !== false) {
                $.each(item.options, function () {
                    if (this.id == item_option && item_qty > this.quantity) {
                        if (item.row.out_of_stock) {
                            $('#row_' + row_no).addClass('danger');
                            $('span.sname#name_' + row_no).append('<i class="fa fa-cart-arrow-down out_of_stock" aria-hidden="true">last unit</i>');
                        }
                        //$('#row_' + row_no).addClass('fa fa-cart-arrow-down');
                    }
                });
            } else if (item_qty > item_aqty) {
                if (item.row.out_of_stock) {
                    $('#row_' + row_no).addClass('danger');
                    $('span.sname#name_' + row_no).append('<i class="fa fa-cart-arrow-down out_of_stock" aria-hidden="true">last unit</i>');
                }
            } else if (item_type == 'combo') {
                if (combo_items === false) {
                    if (item.row.out_of_stock) {
                        $('#row_' + row_no).addClass('danger');
                        $('span.sname#name_' + row_no).append('<i class="fa fa-cart-arrow-down out_of_stock" aria-hidden="true">last unit</i>');
                    }
                } else {
                    $.each(combo_items, function () {
                        if (parseFloat(this.quantity) < (parseFloat(this.qty) * item_qty) && this.type == 'standard') {
                            if (item.row.out_of_stock) {
                                $('#row_' + row_no).addClass('danger');
                                $('span.sname#name_' + row_no).append('<i class="fa fa-cart-arrow-down out_of_stock" aria-hidden="true">last unit</i>');
                            }
                        }
                    });
                }
            }
            if (java_applet == 1) {
                bill_data += "#" + (an - 1) + " " + item_name + " (" + item_code + ")" + "\n";
                bill_data += printLine(item_qty + " x " + formatMoney(parseFloat(item_price) + parseFloat(pr_tax_val)) + ": " + formatMoney(((parseFloat(item_price) + parseFloat(pr_tax_val)) * parseFloat(item_qty)))) + "\n";
                order_data += printLine("#" + (an - 1) + " " + item_name + " (" + item_code + "):" + formatDecimal(item_qty)) + "\n";
            } else {
                var bprTr = '<tr class="row_' + item_id + '" data-item-id="' + item_id + '"><td colspan="2">#' + (an - 1) + ' ' + item_name + ' (' + item_code + ')</td></tr>';
                bprTr += '<tr class="row_' + item_id + '" data-item-id="' + item_id + '"><td>(' + formatDecimal(item_qty) + ' x ' + (item_discount != 0 ? '<del>' + formatMoney(parseFloat(item_price) + parseFloat(pr_tax_val) + item_discount) + '</del>' : '') + formatMoney(parseFloat(item_price) + parseFloat(pr_tax_val)) + ')</td><td style="text-align:right;">' + formatMoney(((parseFloat(item_price) + parseFloat(pr_tax_val)) * parseFloat(item_qty))) + '</td></tr>';
                var oprTr = '<tr class="row_' + item_id + '" data-item-id="' + item_id + '"><td>#' + (an - 1) + ' ' + item_name + ' (' + item_code + ')</td><td>' + formatDecimal(item_qty) + '</td></tr>';
                $("#order-table").append(oprTr);
                $("#bill-table").append(bprTr);
            }
            //  console.log("iiiiiiiiiiiiiiiiiiiiii",item.row.suspend);
        });
        // Order level discount calculations
        var posdiscountpercent = localStorage.getItem('posdiscountpercent');
        if (posdiscountpercent === null) {
            posdiscountpercent = 0;
        }
        // alert("file"+localStorage.getItem('posdiscount'));

        if (pos_settings.order_discount_type === 'percent') {

            if (posdiscount = localStorage.getItem('posdiscount')) {
                order_discount = formatDecimal(((total + product_tax) * parseFloat(posdiscountpercent)) / 100);
                /*var ds = posdiscount;
                 if (ds.indexOf("%") !== -1) {
                 var pds = ds.split("%");
                 if (!isNaN(pds[0])) {
                 order_discount = formatDecimal(((total + product_tax) * parseFloat(pds[0])) / 100);
                 } else {
                 order_discount = formatDecimal(ds);
                 }
                 } else {
                 alert("hello world");
                 order_discount = formatDecimal(ds);
                 }:*/
            }

            //alert('posdiscountpercent :'+posdiscountpercent);

            //$('#posdiscount').val(order_discount);
        } else if (pos_settings.order_discount_type === 'flat') {
            posdiscount = localStorage.getItem('posdiscount')
            order_discount = (posdiscount);
        }

        if (suspend_flag > 0 && (localStorage.getItem('orderdisc'))) {

            order_discount = localStorage.getItem('orderdisc')

        }
        // console.log("===================>",item.row.order_discount);

        $('#posdiscount').val(order_discount);
        $('#posdiscountper').val(posdiscountpercent);

        if (pos_settings.discount_type === '3') {
            if (formatDecimal(product_discount) > 0) {
                $('#ppdiscount').hide();
                localStorage.removeItem('posdiscountreason');
            } else {
                $('#ppdiscount').show();
            }

            if (formatDecimal(order_discount) > 0) {
                $('.edit').hide();
            } else {
                $('.edit').show();
            }
        }

        // Order level tax calculations
        if (site.settings.tax2 != 0) {
            if (postax2 = localStorage.getItem('postax2')) {
                $.each(tax_rates, function () {
                    if (this.id == postax2) {
                        if (this.type == 2) {
                            invoice_tax = formatDecimal(this.rate);
                        }
                        if (this.type == 1) {
                            invoice_tax = formatDecimal(((total - order_discount) * this.rate) / 100);
                        }
                    }
                });
            }
        }

        total = formatDecimal(total);
        product_tax = formatDecimal(product_tax);
        total_discount = formatDecimal(order_discount + product_discount);
        //alert("Total --- "+total);alert("Tax ---- "+product_tax);alert("Disc ---- "+total_discount);
        // Totals calculations after item addition

        //alert('total :' + total +'invoice_tax :'+invoice_tax+'order_discount :'+order_discount+'shipping : '+shipping);
        var gtotal = Math.round(parseFloat(((total + invoice_tax) - order_discount) + shipping));
        // no need to round off product price // added by mridula
//        var gtotal = parseFloat(((total + invoice_tax) - order_discount) + shipping);

        //alert('gtotal :'+gtotal);
        if (gtotal <= 0) {
            localStorage.removeItem('posdiscountreason');
            localStorage.removeItem('posdiscountpercent');
            $('#discout_reason_input').val('');
            tt_discount_reason = '';
            invoice_tax = 0.00;
            product_discount = 0.00;
            order_discount = 0.00;
            gtotal = 0.00;
        }

        if (invoice_tax < 0) {
            titems = 0.00;
            invoice_tax = 0.00;
            product_discount = 0.00;
            order_discount = 0.00;
            gtotal = 0.00;
        }

//        $('#total').text(formatMoney(Math.round(total)));
        // no need to round of product total price
        $('#total').text(formatMoney(total));


        var tt_discount_reason = localStorage.getItem('posdiscountreason') != null ? localStorage.getItem('posdiscountreason') : '';
        $('#tt_discount_reason').text(tt_discount_reason);
        if (tt_discount_reason === '') {
            $('#tt_discount_label').hide();
        } else {
            $('#tt_discount_label').show();
        }
        //$('#titems').text((an - 1) + ' (' + (parseFloat(count) - 1) + ')');
        $('#titems').text((parseFloat(count) - 1));
        $('#total_items').val((parseFloat(count) - 1));
        //alert('product_discount :' + product_discount + 'product_discount_type:'+typeof(product_discount));
        //alert('order_discount :' + order_discount + 'order_discount_type:'+typeof(order_discount));
        //$('#tds').text('(' + formatMoney(product_discount) + ') ' + formatMoney(order_discount));
        if ((product_discount > 0) && (order_discount == 0)) {
            $('#tds').text(formatMoney(product_discount));
        } else if ((order_discount > 0) && (product_discount == 0)) {
            $('#tds').text(formatMoney(order_discount));
        } else if ((order_discount == 0) && (product_discount == 0)) {
            $('#tds').text(formatMoney(order_discount));
        }

        if (site.settings.tax2 != 0) {
            $('#ttax2').html(formatMoney(invoice_tax));
        }
        $('#gtotal').text(formatMoney(Math.round(gtotal)));
        // No need to round of subtotal // added by mridula
//        $('#gtotal').text(formatMoney(gtotal));

        if (java_applet == 1) {
            bill_data += "\n" + printLine(lang_total + ': ' + formatMoney(total)) + "\n";
            bill_data += printLine(lang_items + ': ' + (an - 1) + ' (' + (parseFloat(count) - 1) + ')') + "\n";
            if (total_discount > 0) {
                bill_data += printLine(lang_discount + ': (' + formatMoney(product_discount) + ') ' + formatMoney(order_discount)) + "\n";
            }
            if (site.settings.tax2 != 0 && invoice_tax != 0) {
                bill_data += printLine(lang_tax2 + ': ' + formatMoney(invoice_tax)) + "\n";
            }
            bill_data += printLine(lang_total_payable + ': ' + formatMoney(gtotal)) + "\n";
        } else {
            var bill_totals = '';
            bill_totals += '<tr><td>' + lang_total + '</td><td style="text-align:right;">' + formatMoney(total) + '</td></tr>';
            bill_totals += '<tr><td>' + lang_items + '</td><td style="text-align:right;">' + (an - 1) + ' (' + (parseFloat(count) - 1) + ')</td></tr>';
            if (order_discount > 0) {
                bill_totals += '<tr><td>' + lang_discount + '</td><td style="text-align:right;">' + formatMoney(order_discount) + '</td></tr>';
            }
            if (site.settings.tax2 != 0 && invoice_tax != 0) {
                bill_totals += '<tr><td>' + lang_tax2 + '</td><td style="text-align:right;">' + formatMoney(invoice_tax) + '</td></tr>';
            }
            bill_totals += '<tr><td>' + lang_total_payable + '</td><td style="text-align:right;">' + formatMoney(gtotal) + '</td></tr>';
            $('#bill-total-table').empty();
            $('#bill-total-table').append(bill_totals);
        }
        if (count > 1) {
            $('#poscustomer').select2("readonly", true);
            $('#add-customer').hide();
            // shortcut.remove("Ctrl+Shift+A");
        } else {
            $('#poscustomer').select2("readonly", false);
            $('#poswarehouse').select2("readonly", false);
            $('#add-customer').show();
            /*shortcut.add(pos_settings.add_customer, function () {
             $("#add-customer").trigger('click');
             }, {'type': 'keydown', 'propagate': false, 'target': document});*/
        }
        if (KB) {
            display_keyboards();
        }
        //audio_success.play();
        //$('#posTable > tbody > tr:first').children().children('.rquantity').focus(); // to auto focus quantity input of top item
        $('#add_item').focus();

    }
}

function isEmpty(value) {
    return typeof value == 'string' && !value.trim() || typeof value == 'undefined' || value === null;
}
function printLine(str) {
    var size = pos_settings.char_per_line;
    var len = str.length;
    var res = str.split(":");
    var newd = res[0];
    for (i = 1; i < (size - len); i++) {
        newd += " ";
    }
    newd += res[1];
    return newd;
}

/* -----------------------------
 * Add Purchase Iten Function
 * @param {json} item
 * @returns {Boolean}
 ---------------------------- 
 */
function add_invoice_item(item) {

    if (count == 1) {
        positems = {};
        if ($('#poswarehouse').val() && $('#poscustomer').val()) {
            $('#poscustomer').select2("readonly", true);
            $('#poswarehouse').select2("readonly", true);
        } else {
            bootbox.alert(lang.select_above);
            item = null;
            return;
        }
    }
    if (item == null) {
        return;
    }

    //var item_id = site.settings.item_addition == 1 ? item.item_id : item.id;
    var item_id = item.item_id;
    var id = item.id;
    var lot_no = item.row.lot_no;
    var quantity = item.row.quantity;
    var overselling = item.row.overselling;
    var cont = 0;
    $.each(positems, function (k, v) {

        if (item_id == v.item_id) {
            cont = cont + 1;
        }

    });



    if (cont > 0) {
        item.row.quantity = parseFloat(item.row.quantity) - (cont + 1);
        //  positems[item_id].row.quantity = parseFloat(positems[item_id].row.quantity) - 1 ;  
        if (item.row.quantity <= 0) {

            bootbox.alert('Product Quantity not available');
            item.row.out_of_stock = 1;
            $('#add_item').val('');
            return false;
        } else {
            item.row.out_of_stock = 0;
            positems[id] = item;
        }
    } else if (cont == 0) {
        item.row.quantity = parseFloat(item.row.quantity) - 1;
        if (item.row.quantity <= 0) {
            bootbox.alert('Product Quantity not available');
            item.row.out_of_stock = 1;
            $('#add_item').val('');
            return false;
        } else {
            item.row.out_of_stock = 0;
            positems[id] = item;
        }
    }

    //console.log(JSON.stringify(positems));
    //Add By Ankit 17-11-2016
    localStorage.setItem('positems', JSON.stringify(positems));
    if (item.row.quantity < 0)
    {
        bootbox.alert("Product Qty Not Available !!");
        return false;
    }
    loadItems(item);
    return true;
}


if (typeof (Storage) === "undefined") {
    $(window).bind('beforeunload', function (e) {
        if (count > 1) {
            var message = "You will loss data!";
            return message;
        }
    });
}

function display_keyboards() {

    $('.kb-text:not([readonly])').keyboard({
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
            ]}
//            accepted : function(e, keyboard, el){ 
//                            console.log(JSON.stringify(el.value));
//                            alert('The content "' + el.value + '" was accepted!');             
//                        }
    });

    $('.kb-pad:not([readonly])').keyboard({
        layout: 'num',
        restrictInput: true, // Prevent keys not in the displayed keyboard from being typed in
        preventPaste: true, // prevent ctrl-v and right click
        autoAccept: false,
        usePreview: false,
        accepted: function (e, keyboard, el) {
            keyboard.destroy();
            return false;
        },
        canceled: function (e, keyboard, el) {
            keyboard.destroy();
            return false;
        }
    });
}

function showKbtext(field) {
    $(field).keyboard({
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
            ]}
//            accepted : function(e, keyboard, el){ 
//                            console.log(JSON.stringify(el.value));
//                            alert('The content "' + el.value + '" was accepted!');             
//                        }
    });
}

function showKbpad(field) {
    $(field).keyboard({
        restrictInput: true,
        preventPaste: true,
        autoAccept: true,
        alwaysOpen: false,
        openOn: 'click',
        usePreview: false,
        layout: 'costom',
        display: {
            'b': '\u2190:Backspace',
        },
        customLayout: {
            'default': [
                '1 2 3 {b}',
                '4 5 6 . {clear}',
                '7 8 9 0 %',
                '{accept} {cancel}'
            ]
        }
    });
}
$('body').bind('keypress', function (e) {
    if (e.keyCode == 13) {
        e.preventDefault();
        return false;
    }
});



/*$(window).bind('beforeunload', function(e) {
 if(count > 1){
 var msg = 'You will loss the sale data.';
 (e || window.event).returnValue = msg;
 return msg;
 }
 });
 */
if (site.settings.auto_detect_barcode == 1) {
    $(document).ready(function () {
        var pressed = false;
        var chars = [];
        $(window).keypress(function (e) {
            if (e.key == '%') {
                pressed = true;
            }
            chars.push(String.fromCharCode(e.which));
            if (pressed == false) {
                setTimeout(function () {
                    if (chars.length >= 8) {
                        var barcode = chars.join("");
                        //$("#add_item").focus().autocomplete("search", barcode);

                        $("#add_item").focus().autocomplete();
                    }
                    chars = [];
                    pressed = false;
                }, 200);
            }
            pressed = true;
        });
    });
}
$(document).ready(function () {
    read_card();

    $(".close_register_input").click(function () {
        //alert(1)
        if (!$('.ui-keyboard').is(":visible")) {
            $('.close_register_input').keyboard({
                layout: 'num',
                restrictInput: true, // Prevent keys not in the displayed keyboard from being typed in
                preventPaste: true, // prevent ctrl-v and right click
                autoAccept: false,
                usePreview: false,
                accepted: function (e, keyboard, el) {
                    keyboard.destroy();
                    return false;
                },
                canceled: function (e, keyboard, el) {
                    //keyboard.close();
                    //alert(1)
                    keyboard.destroy();
                    return false;
                },
            });
        }
    });
    $('.close_register_input').keyboard({
        layout: 'num',
        restrictInput: true, // Prevent keys not in the displayed keyboard from being typed in
        preventPaste: true, // prevent ctrl-v and right click
        autoAccept: false,
        usePreview: false,
        accepted: function (e, keyboard, el) {
            keyboard.destroy();
            return false;
        },
        canceled: function (e, keyboard, el) {
            //keyboard.close();
            //alert(1)
            keyboard.destroy();
            return false;
        },
    });

    $(".keyboard-text").click(function () {

        if (!$('.ui-keyboard').is(":visible")) {
            $('.keyboard-text').keyboard({
                autoAccept: true,
                alwaysOpen: false,
                openOn: 'focus',
                usePreview: false,
                layout: 'custom',
                accepted: function (e, keyboard, el) {
                    keyboard.destroy();
                    return false;
                },
                canceled: function (e, keyboard, el) {
                    keyboard.destroy();
                    return false;
                },
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
                    ]}
            });
        }
    });

    $('.keyboard-text').keyboard({
        autoAccept: true,
        alwaysOpen: false,
        openOn: 'focus',
        usePreview: false,
        layout: 'custom',
        accepted: function (e, keyboard, el) {
            keyboard.destroy();
            return false;
        },
        canceled: function (e, keyboard, el) {
            //keyboard.close();
            //alert(1)
            keyboard.destroy();
            return false;
        },
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
            ]}
    });
});

function generateCardNo(x, biller) {

    var year = new Date().getFullYear();
    if (!x) {
        x = 8;
    }
    chars = "1234567890";
    no = "";
    for (var i = 0; i < x; i++) {
        var rnum = Math.floor(Math.random() * chars.length);
        no += chars.substring(rnum, rnum + 1);
    }
    var d = new Date();
    var n = d.getTime();
    return biller + '/' + year + '/' + n;
}

function roundNumber(number, toref) {
    switch (toref) {
        case 1:
            var rn = formatDecimal(Math.round(number * 20) / 20);
            break;
        case 2:
            var rn = formatDecimal(Math.round(number * 2) / 2);
            break;
        case 3:
            var rn = formatDecimal(Math.round(number));
            break;
        case 4:
            var rn = formatDecimal(Math.ceil(number));
            break;
        default:
            var rn = number;
    }
    return rn;
}
function getNumber(x) {
    return accounting.unformat(x);
}
function formatQuantity(x) {
    return (x != null) ? '<div class="text-center">' + formatNumber(x, site.settings.qty_decimals) + '</div>' : '';
}
function formatNumber(x, d) {
    if (!d && d != 0) {
        d = site.settings.decimals;
    }
    if (site.settings.sac == 1) {
        return formatSA(parseFloat(x).toFixed(d));
    }
    return accounting.formatNumber(x, d, site.settings.thousands_sep == 0 ? ' ' : site.settings.thousands_sep, site.settings.decimals_sep);
}
function formatMoney(x, symbol) {
    if (!symbol) {
        symbol = "";
    }
    if (site.settings.sac == 1) {
        return symbol + '' + formatSA(parseFloat(x).toFixed(site.settings.decimals));
    }
    return accounting.formatMoney(x, symbol, site.settings.decimals, site.settings.thousands_sep == 0 ? ' ' : site.settings.thousands_sep, site.settings.decimals_sep, "%s%v");
}
function formatDecimal(x) {
    return parseFloat(parseFloat(x).toFixed(site.settings.decimals));
}
function is_valid_discount(mixed_var) {
    return (is_numeric(mixed_var) || (/([0-9]%)/i.test(mixed_var))) ? true : false;
}
function is_numeric(mixed_var) {
    var whitespace =
            " \n\r\t\f\x0b\xa0\u2000\u2001\u2002\u2003\u2004\u2005\u2006\u2007\u2008\u2009\u200a\u200b\u2028\u2029\u3000";
    return (typeof mixed_var === 'number' || (typeof mixed_var === 'string' && whitespace.indexOf(mixed_var.slice(-1)) === -
            1)) && mixed_var !== '' && !isNaN(mixed_var);
}
function is_float(mixed_var) {
    return +mixed_var === mixed_var && (!isFinite(mixed_var) || !!(mixed_var % 1));
}
function currencyFormat(x) {
    if (x != null) {
        return formatMoney(x);
    } else {
        return '0';
    }
}
function formatSA(x) {
    x = x.toString();
    var afterPoint = '';
    if (x.indexOf('.') > 0)
        afterPoint = x.substring(x.indexOf('.'), x.length);
    x = Math.floor(x);
    x = x.toString();
    var lastThree = x.substring(x.length - 3);
    var otherNumbers = x.substring(0, x.length - 3);
    if (otherNumbers != '')
        lastThree = ',' + lastThree;
    var res = otherNumbers.replace(/\B(?=(\d{2})+(?!\d))/g, ",") + lastThree + afterPoint;

    return res;
}

function read_card() {

    $('.swipe').on('change', function (e) {

        $('#add_item').focusout();
        e.preventDefault();

        var payid = $(this).attr('id');
        id = payid.substr(payid.length - 1);

        var TrackData = $(this).val();

        //if (e.keyCode == 13) {
        e.preventDefault();
        var p = new SwipeParserObj(TrackData);

        if (p.hasTrack1)
        {
            // Populate form fields using track 1 data
            var CardType = null;

            if (p.account == null) {
                CardType = 'Visa';

            }
            else {
                var ccn1 = p.account.charAt(0);
            }
            if (ccn1 == 4)
                CardType = 'Visa';
            else if (ccn1 == 5)
                CardType = 'MasterCard';
            else if (ccn1 == 3)
                CardType = 'Amex';
            else if (ccn1 == 6)
                CardType = 'Discover';
            else
                CardType = 'Visa';


            var card_dt = p.input_trackdata_str.split("^");
            var c_num = card_dt[0].split("B");
            //console.log(card_dt[0].split("B"));
            $('#pcc_no_' + id).val(c_num[1]).trigger('change');

            //$('#pcc_holder_' + id).val(p.account_name);
            $('#pcc_holder_' + id).val(card_dt[1]).trigger('change');
            $('#pcc_month_' + id).val(p.exp_month);
            $('#pcc_year_' + id).val(p.exp_year);
            $('#pcc_cvv2_' + id).val('');
            $('#pcc_type_' + id).val(CardType);

        }
        else
        {
            $('#pcc_no_' + id).val('');
            $('#pcc_holder_' + id).val('');
            $('#pcc_month_' + id).val('');
            $('#pcc_year_' + id).val('');
            $('#pcc_cvv2_' + id).val('');
            $('#pcc_type_' + id).val('');
        }

        //$('#pcc_cvv2_' + id).val($('#pcc_cvv2_' + id).val()+'-'+c_num[1]+'-'+card_dt[1]);
        $('#pcc_cvv2_' + id).focus();
        // }

    }).blur(function (e) {
        $(this).val('');
    }).focus(function (e) {
        $(this).val('');
    });
}



$.extend($.keyboard.keyaction, {
    enter: function (base) {
        base.accept();
    }
});

$(document).ajaxStart(function () {
    $('#ajaxCall').show();
}).ajaxStop(function () {
    $('#ajaxCall').hide();
});

$(document).ready(function () {
    $('#myModal').on('hidden.bs.modal', function () {
        $(this).find('.modal-dialog').empty();
        $(this).removeData('bs.modal');
    });
    $('#myModal2').on('hidden.bs.modal', function () {
        $(this).find('.modal-dialog').empty();
        $(this).removeData('bs.modal');
        $('#myModal').css('zIndex', '1050');
        $('#myModal').css('overflow-y', 'scroll');
    });
    $('#myModal2').on('show.bs.modal', function () {
        $('#myModal').css('zIndex', '1040');
    });
    $('.modal').on('hidden.bs.modal', function () {
        $(this).removeData('bs.modal');
    });
    $('.modal').on('show.bs.modal', function () {
        $('#modal-loading').show();
        $('.blackbg').css('zIndex', '1041');
        $('.loader').css('zIndex', '1042');
    }).on('hide.bs.modal', function () {
        $('#modal-loading').hide();
        $('.blackbg').css('zIndex', '3');
        $('.loader').css('zIndex', '4');
    });
    $('#clearLS').click(function (event) {
        bootbox.confirm("Are you sure?", function (result) {
            if (result == true) {
                localStorage.clear();
                location.reload();
            }
        });
        return false;
    });
});

//$.ajaxSetup ({ cache: false, headers: { "cache-control": "no-cache" } });
/*if (pos_settings.focus_add_item != '') {
 shortcut.add(pos_settings.focus_add_item, function () {
 $("#add_item").focus();
 }, {'type': 'keydown', 'propagate': false, 'target': document});
 }
 if (pos_settings.add_manual_product != '') {
 shortcut.add(pos_settings.add_manual_product, function () {
 $("#addManually").trigger('click');
 }, {'type': 'keydown', 'propagate': false, 'target': document});
 }
 if (pos_settings.customer_selection != '') {
 shortcut.add(pos_settings.customer_selection, function () {
 $("#customer").select2("open");
 }, {'type': 'keydown', 'propagate': false, 'target': document});
 }
 if (pos_settings.add_customer != '') {
 shortcut.add(pos_settings.add_customer, function () {
 $("#add-customer").trigger('click');
 }, {'type': 'keydown', 'propagate': false, 'target': document});
 }
 if (pos_settings.toggle_category_slider != '') {
 shortcut.add(pos_settings.toggle_category_slider, function () {
 $("#open-category").trigger('click');
 }, {'type': 'keydown', 'propagate': false, 'target': document});
 }
 if (pos_settings.toggle_subcategory_slider != '') {
 shortcut.add(pos_settings.toggle_subcategory_slider, function () {
 $("#open-subcategory").trigger('click');
 }, {'type': 'keydown', 'propagate': false, 'target': document});
 }
 if (pos_settings.cancel_sale != '') {
 shortcut.add(pos_settings.cancel_sale, function () {
 $("#reset").click();
 }, {'type': 'keydown', 'propagate': false, 'target': document});
 }
 if (pos_settings.suspend_sale != '') {
 shortcut.add(pos_settings.suspend_sale, function () {
 $("#suspend").trigger('click');
 }, {'type': 'keydown', 'propagate': false, 'target': document});
 }
 if (pos_settings.print_items_list != '') {
 shortcut.add(pos_settings.print_items_list, function () {
 $("#print_btn").click();
 }, {'type': 'keydown', 'propagate': false, 'target': document});
 }
 if (pos_settings.finalize_sale != '') {
 shortcut.add(pos_settings.finalize_sale, function () {
 $("#payment").trigger('click');
 }, {'type': 'keydown', 'propagate': false, 'target': document});
 }
 if (pos_settings.today_sale != '') {
 shortcut.add(pos_settings.today_sale, function () {
 $("#today_sale").click();
 }, {'type': 'keydown', 'propagate': false, 'target': document});
 }
 if (pos_settings.open_hold_bills != '') {
 shortcut.add(pos_settings.open_hold_bills, function () {
 $("#opened_bills").trigger('click');
 }, {'type': 'keydown', 'propagate': false, 'target': document});
 }
 if (pos_settings.close_register != '') {
 shortcut.add(pos_settings.close_register, function () {
 $("#close_register").click();
 }, {'type': 'keydown', 'propagate': false, 'target': document});
 }
 shortcut.add("ESC", function () {
 $("#cp").trigger('click');
 }, {'type': 'keydown', 'propagate': false, 'target': document});
 */
$(document).ready(function () {
    $('#add_item').focus();
});




