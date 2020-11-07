<script>
    $(document).ready(function () {
        var oTable = $('#POSData').dataTable({
            "aaSorting": [[0, "asc"], [1, "desc"]],
            "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "<?= lang('all') ?>"]],
            "iDisplayLength": <?= $Settings->rows_per_page ?>,
            'bProcessing': true, 'bServerSide': true, 'bDestroy': true,
            'sAjaxSource': '<?= site_url('pos/getSales' . ($warehouse_id ? '/' . $warehouse_id : '')) ?>',
            'fnServerData': function (sSource, aoData, fnCallback) {
                aoData.push({
                    "name": "<?= $this->security->get_csrf_token_name() ?>",
                    "value": "<?= $this->security->get_csrf_hash() ?>"
                });
                $.ajax({'dataType': 'json', 'type': 'POST', 'url': sSource, 'data': aoData, 'success': fnCallback});
                
            },
            'fnRowCallback': function (nRow, aData, iDisplayIndex) {
                var oSettings = oTable.fnSettings();
                nRow.id = aData[0];
                //nRow.className = "receipt_link";
                return nRow;
            },
            "aoColumns": [{
                    "bSortable": false,
                    "mRender": checkbox
                }, {"mRender": dateonly}, null, null, null, {"mRender": currencyFormat}, 
                        {"mRender": currencyFormat}, //{"mRender": currencyFormat}, 
                        {"mRender": row_status}, null, {"bSortable": false}],
            "fnFooterCallback": function (nRow, aaData, iStart, iEnd, aiDisplay) {
                //console.log(aaData);
                var gtotal = 0, paid = 0;// balance = 0;
                for (var i = 0; i < aaData.length; i++) {
                    gtotal += parseFloat(aaData[aiDisplay[i]][6]);
                    paid += parseFloat(aaData[aiDisplay[i]][6]);
                    //balance += parseFloat(aaData[aiDisplay[i]][7]);
                }
                var nCells = nRow.getElementsByTagName('th');
                nCells[5].innerHTML = currencyFormat(parseFloat(gtotal));
                nCells[6].innerHTML = currencyFormat(parseFloat(paid));
                //nCells[7].innerHTML = currencyFormat(parseFloat(balance));
            }
        }).fnSetFilteringDelay().dtFilter([
            {column_number: 1, filter_default_label: "[<?= lang('date'); ?> (yyyy-mm-dd)]", filter_type: "text", data: []},
            {column_number: 2, filter_default_label: "[<?= lang('ref'); ?>]", filter_type: "text", data: []},
            {column_number: 3, filter_default_label: "[<?= lang('Store'); ?>]", filter_type: "text", data: []},
            {column_number: 4, filter_default_label: "[<?= lang('customer'); ?>]", filter_type: "text"},
            {column_number: 7, filter_default_label: "[<?= lang('payment_status'); ?>]", filter_type: "text", data: []},
            {column_number: 8, filter_default_label: "[<?= lang('Status'); ?>]", filter_type: "text", data: []},
        ], "footer");

        $(document).on('click', '.ret_sal', function (e) {
            var ret_id = $(this).attr('data-id');
            var obj = $(this).attr('at');
            //console.log(obj);return false;
            e.preventDefault();
            if (ret_id != null) {
                $.ajax({
                    type: "post",
                    url: "<?= site_url('sales/check_ret_sale') ?>"+'/'+ret_id,
                    data: {id: ret_id},
                    dataType: "html",
                    success: function (data) {
                        if(data == 1){
                            window.location.href = site.base_url+obj;
                        }
                        else{
                            bootbox.alert("This invoice has been expired to return!");
                            return false;
                        }
                    },
                    error: function () {
                        bootbox.alert('<?= lang('ajax_request_failed'); ?>');
                        return false;
                    }
                });
            }
        });

        $(document).on('click', '.email_receipt', function (e) {
            var sid = $(this).attr('data-id');
            var ea = $(this).attr('data-email-address');
            e.preventDefault();
            /*
            var email = prompt("<?= lang("email_address"); ?>", ea);
            if (email != null) {
                $.ajax({
                    type: "post",
                    url: "<?= site_url('pos/email_receipt') ?>/" + sid,
                    data: {<?= $this->security->get_csrf_token_name(); ?>: "<?= $this->security->get_csrf_hash(); ?>", email: email, id: sid},
                    dataType: "json",
                    success: function (data) {
                        bootbox.alert(data.msg);
                    },
                    error: function () {
                        bootbox.alert('<?= lang('ajax_request_failed'); ?>');
                        return false;
                    }
                });
            }
            */

            bootbox.dialog({
                title: "Email Address",
                message: '<div class="row">  ' +
                        '<div class="col-md-12"> ' +
                        '<form class="form-horizontal" role="form" data-toggle="validator">' +
                        '<div class="form-group"> ' +
                        '<label class="col-md-2 control-label" for="email">Email</label> ' +
                        '<div class="col-md-10"> ' +
                        '<input id="email" name="email" type="text" value="' + ea + '" data-minlength="3" class="form-control input-md">' +
                        '</div></div> ' +
                        '</form> </div>  </div>',
                buttons: {
                    success: {
                        label: "Submit",
                        className: "btn-success",
                        callback: function () {
                            var email = $("#email").val();
                            $.ajax({
                                type: "post",
                                url: "<?= site_url('pos/email_receipt') ?>/" + sid,
                                data: {<?= $this->security->get_csrf_token_name(); ?>: "<?= $this->security->get_csrf_hash(); ?>", email: email, id: sid},
                                dataType: "json",
                                success: function (data) {                               
                                    bootbox.alert(data.msg);
                                },
                                error: function () {
                                    bootbox.alert('<?= lang('ajax_request_failed'); ?>');
                                    return false;
                                }
                            });
                        }
                    },
                    cancel: {
                        label: "Cancel",
                        className: "btn-success",
                        callback: function () {
                            bootbox.hideAll();
                        }
                    }
                }
            });
        });
    });

</script>
<?php
if ($Owner || $Admin || $Manager || $Sales) {
    echo form_open('sales/sale_actions', 'id="action-form"');
}
?>
<div class="box">
    <div class="box-header">
        <h2 class="blue"><i
                class="fa-fw fa fa-barcode"></i><?= lang('pos_sales') . ' (' . ($warehouse_id ? $warehouse->name : lang('all_warehouses')) . ')'; ?>
        </h2>
        

        <div class="box-icon">
            <ul class="btn-tasks">
               <li class="dropdown">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#"><i class="icon fa fa-tasks tip"  data-placement="left" title="<?= lang("actions") ?>"></i></a>
                    
                    <!-- Permissions Added By Anil 21-09-2016 Start -->    
                    <?php if($Owner) { ?> 
                    <ul class="dropdown-menu pull-right" class="tasks-menus" role="menu" aria-labelledby="dLabel">
                        <li><a href="<?= site_url('pos') ?>"><i class="fa fa-plus-circle"></i> <?= lang('add_sale') ?></a></li>
                        <li><a href="#" id="excel" data-action="export_excel"><i class="fa fa-file-excel-o"></i> <?= lang('export_to_excel') ?></a></li>
                        <li><a href="#" id="pdf" data-action="export_pdf"><i class="fa fa-file-pdf-o"></i> <?= lang('export_to_pdf') ?></a></li>
                        <li class="divider"></li>
                        <li><a href="#" class="bpo" title="<b><?= $this->lang->line("delete_sales") ?></b>" data-content="<p><?= lang('r_u_sure') ?></p><button type='button' class='btn btn-danger' id='delete' data-action='delete'><?= lang('i_m_sure') ?></a> <button class='btn bpo-close'><?= lang('no') ?></button>" data-html="true" data-placement="left"><i class="fa fa-trash-o"></i> <?= lang('delete_sales') ?></a></li>
                    </ul>
                    <?php } else { ?>
                    <ul class="dropdown-menu pull-right" class="tasks-menus" role="menu" aria-labelledby="dLabel">
                         <?php if($GP['pos-sale_add']) { ?> 
                            <li><a href="<?= site_url('pos') ?>"><i class="fa fa-plus-circle"></i> <?= lang('add_sale') ?></a></li>
                         <?php } if($GP['pos-sales_excel']) { ?>    
                            <li><a href="#" id="excel" data-action="export_excel"><i class="fa fa-file-excel-o"></i> <?= lang('export_to_excel') ?></a></li>
                         <?php } if($GP['pos-sales_pdf']) { ?>      
                            <li><a href="#" id="pdf" data-action="export_pdf"><i class="fa fa-file-pdf-o"></i> <?= lang('export_to_pdf') ?></a></li>
                            <li class="divider"></li>
                         <?php } if($GP['pos-sales_delete']) { ?>    
                            <li><a href="#" class="bpo" title="<b><?= $this->lang->line("delete_sales") ?></b>" data-content="<p><?= lang('r_u_sure') ?></p><button type='button' class='btn btn-danger' id='delete' data-action='delete'><?= lang('i_m_sure') ?></a> <button class='btn bpo-close'><?= lang('no') ?></button>" data-html="true" data-placement="left"><i class="fa fa-trash-o"></i> <?= lang('delete_sales') ?></a></li>
                         <?php } ?>   
                    </ul>
                    <?php } ?>
                    <!-- Permissions Added By Anil 21-09-2016 End -->  
                </li>
<?php //if (!empty($warehouses)) { ?>
<!--                    <li class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#"><i class="icon fa fa-building-o tip" data-placement="left" title="<?= lang("warehouses") ?>"></i></a>
                        <ul class="dropdown-menu pull-right" class="tasks-menus" role="menu" aria-labelledby="dLabel">
                            <li><a href="<?= site_url('pos/sales') ?>"><i class="fa fa-building-o"></i> <?= lang('all_warehouses') ?></a></li>
                            <li class="divider"></li>
                            <?php
                            foreach ($warehouses as $warehouse) {
                                echo '<li><a href="' . site_url('pos/sales/' . $warehouse->id) . '"><i class="fa fa-building"></i>' . $warehouse->name . '</a></li>';
                            }
                            ?>
                        </ul>
                    </li>-->
<?php// } ?>
            </ul>
        </div>
    </div>
    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">
                <p class="introtext"><?= lang('list_results'); ?></p>

                <div class="table-responsive">
                    <table id="POSData" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th class='col-xs-1'>
                                    <input class="checkbox checkft" type="checkbox" name="check"/>
                                </th>
                                <th class='col-xs-2'><?= lang("date"); ?></th>
                                <th class='col-xs-2'><?= lang("ref"); ?></th>
                                <th class='col-xs-2'><?= lang("Store"); ?></th>
                                <th class='col-xs-2'><?= lang("customer"); ?></th>
                                <th class='col-xs-2'><?= lang("grand_total"); ?>&nbsp;<span class="rupee">&#8377;</span></th>
                                <th class='col-xs-1'><?= lang("paid"); ?>&nbsp;<span class="rupee">&#8377;</span></th>
                                <!--<th><?= lang("balance"); ?></th>-->
                                <th class='col-xs-1'><?= lang("status"); ?></th>
                                <th class='col-xs-1'><?= lang("pay_status"); ?></th>
                                <th style="width:80px; text-align:center;"><?= lang("actions"); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="10" class="dataTables_empty"><?= lang("loading_data"); ?></td>
                            </tr>
                        </tbody>
                        <tfoot class="dtFilter">
                            <tr class="active">
                                <th style="min-width:30px; width: 30px; text-align: center;">
                                    <input class="checkbox checkft" type="checkbox" name="check"/>
                                </th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th><?= lang("grand_total"); ?>&nbsp;<span class="rupee">&#8377;</span></th>
                                <th><?= lang("paid"); ?>&nbsp;<span class="rupee">&#8377;</span></th>
                                <!--<th><?= lang("balance"); ?></th>-->
                                <th class="defaul-color"></th>
                                <th></th>
                                <th style="width:80px; text-align:center;"><?= lang("actions"); ?></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
    <?php if ($Owner || $Admin || $Manager || $Sales) { ?>
    <div style="display: none;">
        <input type="hidden" name="form_action" value="" id="form_action"/>
    <?= form_submit('performAction', 'performAction', 'id="action-form-submit"') ?>
    </div>
    <?= form_close() ?>
<?php } ?>
<script type="text/javascript">
    $(document).ready(function(){
        $('#print_receipt').on('click',function(event){
            event.preventDefault();
            alert($(this).attr('href'));
        });
    });
    function printPage(sURL) {
        alert(sURL);
        $("<iframe>")                             // create a new iframe element
        .hide()                               // make it invisible
        .attr("src", sURL) // point the iframe to the page you want to print
        .appendTo("body");                    // add iframe to the DOM to cause it to load the page
    }
</script>