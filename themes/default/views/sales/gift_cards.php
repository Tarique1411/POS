<script>
    $(document).ready(function () {
        $('#GCData').dataTable({
            "aaSorting": [[1, "desc"]],
            "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "<?= lang('all') ?>"]],
            "iDisplayLength": <?= $Settings->rows_per_page ?>,
            'bProcessing': true, 'bServerSide': false,'bDestroye':true,
            'sAjaxSource': '<?= site_url('sales/getGiftCards') ?>',
            'fnServerData': function (sSource, aoData, fnCallback) {
                aoData.push({
                    "name": "<?= $this->security->get_csrf_token_name() ?>",
                    "value": "<?= $this->security->get_csrf_hash() ?>"
                });
                $.ajax({'dataType': 'json', 'type': 'POST', 'url': sSource, 'data': aoData, 'success': fnCallback});
            },
            "aoColumns": [{
                "bSortable": false,
                "mRender": checkbox
            }, null, {"mRender": currencyFormat}, {"mRender": currencyFormat}, null, /*null,*/ {"mRender": fsd,"bSortable": true}, {"bSortable": false}]
        });
    });
</script>
<?php if ($Owner || $Admin || $Manager || $Sales) { ?> 
<?= form_open('sales/gift_cards_actions', 'id="action-form"') ?>
<?php } ?>
<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-gift"></i><?= lang('credit_note') ?></h2>            
        <div class="box-icon">          
            <ul class="btn-tasks">
                <li class="dropdown">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#"><i class="icon fa fa-tasks tip"
                            data-placement="left" title="<?= lang("actions") ?>"></i></a>   
                <!-- Action Permissions Modified By Anil 26-09-2016n Start -->   
                <?php if($Owner) { ?>    
                    <ul class="dropdown-menu pull-right" class="tasks-menus" role="menu" aria-labelledby="dLabel">
                        <!--<li><a href="<?php echo site_url('sales/add_gift_card'); ?>" data-toggle="modal" id="add" 
                               data-target="#myModal"><i class="fa fa-plus"></i> <?= lang('add_gift_card') ?></a></li>-->
			<li><a href="<?php echo site_url('sales/credit_voucher_setting'); ?>" data-toggle="modal" id="credit_voucher_setting" 
                               data-target="#myModal"><i class="fa fa-cog"></i> <?= lang('credit_voucher_setting') ?></a></li>
                        <li><a href="#" id="excel" data-action="export_excel"><i
                                    class="fa fa-file-excel-o"></i> <?= lang('export_to_excel') ?></a></li>
                        <li><a href="#" id="pdf" data-action="export_pdf"><i
                                    class="fa fa-file-pdf-o"></i> <?= lang('export_to_pdf') ?></a></li>
                        <li class="divider"></li>                        
                    <!--    <li><a href="#" class="bpo" title="<b><?= $this->lang->line("delete_gift_cards") ?></b>"
                                   data-content="<p><?= lang('r_u_sure') ?></p><button type='button' class='btn btn-danger' id='delete' data-action='delete'><?= lang('i_m_sure') ?></a> <button class='btn bpo-close'><?= lang('no') ?></button>"
                                   data-html="true" data-placement="left"><i 
                                        class="fa fa-trash-o"></i> <?= lang('delete_gift_cards') ?></a></li>  -->
                        <li><a href="#" id="delete" data-action="delete"><i
                                    class="fa fa-trash-o"></i> <?= lang('delete_gift_cards') ?></a></li>
                    </ul>
                <?php } else { ?> 
                    <ul class="dropdown-menu pull-right" class="tasks-menus" role="menu" aria-labelledby="dLabel">
                        <?php /*if($GP['sales-add_gift_card'] == 1 ) { ?>
                        <li><a href="<?php echo site_url('sales/add_gift_card'); ?>" data-toggle="modal" id="add" 
                               data-target="#myModal"><i class="fa fa-plus"></i> <?= lang('add_gift_card') ?></a></li>
                        <?php }*/
                        if($GP['sales-credit_voucher_setting'] == 1 ) { ?>
			<li><a href="<?php echo site_url('sales/credit_voucher_setting'); ?>" data-toggle="modal" id="credit_voucher_setting" 
                               data-target="#myModal"><i class="fa fa-cog"></i> <?= lang('credit_voucher_setting') ?></a></li>
                        <?php }
                        if($GP['sales-gift_excel'] == 1 ) { ?>      
                        <li><a href="#" id="excel" data-action="export_excel"><i
                                    class="fa fa-file-excel-o"></i> <?= lang('export_to_excel') ?></a></li>
                        <?php } 
                        if($GP['sales-gift_pdf']) { ?>            
                        <li><a href="#" id="pdf" data-action="export_pdf"><i
                                    class="fa fa-file-pdf-o"></i> <?= lang('export_to_pdf') ?></a></li>
                        <li class="divider"></li>
                        <?php } 
                        if($GP['sales-delete_gift_card']) { ?>  
                        <li><a href="#" id="delete" data-action="delete"><i
                                    class="fa fa-trash-o"></i> <?= lang('delete_gift_cards') ?></a></li>
                        <?php } ?>            
                    </ul>
                <?php } ?>
                </li>
            </ul>
        </div>
    </div>
    
<!-- Add By Ankit For sync Creadit Voucher Data at inter store -->
        <hr></hr>                 
        <div class="row">
            <?php $sync = $pos_settings->cr_syncing_status; ?>
            <div class="col-lg-12" style="float: left">
                <?php if($sync == 'sync_out'){ ?>
                <a href="sales/POSCVdataSync" class="btn btn-primary" id="export">Sync Out
                <div class="fa fa-share-square"></div></a>
                <?php } else { // intermediateCVdataSync ?>
                <!-- <a href="sales/msg" class="btn btn-danger" id="import">Sync In -->
                <a href="sales/intermediateCVdataSync" class="btn btn-danger" id="import">Sync In
                <div class="fa fa-reply-all"></div></a>
                <?php } ?>
            </div>
        </div>
        <hr></hr>
    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">

                <p class="introtext"><?php echo $this->lang->line("list_results"); ?></p>

                <div class="table-responsive">
                    <table id="GCData" class="table table-bordered table-hover table-striped">
                        <thead>
                        <tr>
                            <th style="min-width:30px; width: 30px; text-align: center;">
                                <input class="checkbox checkth" type="checkbox" name="check"/>
                            </th>
                            <th><?php echo $this->lang->line("cv_no"); ?></th>
                            <th><?php echo $this->lang->line("value"); ?>&nbsp;<span class="rupee">&#8377;</span></th>
                            <th><?php echo $this->lang->line("balance"); ?>&nbsp;<span class="rupee">&#8377;</span></th>
                            <!-- <th><?php echo $this->lang->line("created_by"); ?></th> -->
                            <th><?php echo $this->lang->line("customer"); ?></th>
                            <th><?php echo $this->lang->line("expiry"); ?></th>
                            <th style="width:65px;"><?php echo $this->lang->line("actions"); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td colspan="8" class="dataTables_empty"><?= lang('loading_data_from_server') ?></td>
                        </tr>

                        </tbody>
                    </table>
                </div>

            </div>

        </div>
    </div>
</div>

<!--Add by Ankit -->
<?php if ($Owner || $Admin || $Manager || $Sales) { ?>
    <div style="display: none;">
        <input type="hidden" name="form_action" value="" id="form_action"/>
        <?= form_submit('performAction', 'performAction', 'id="action-form-submit"') ?> 
    </div>
    <?= form_close() ?>
<?php } ?>
<?php if ($action && $action == 'add') {
    echo '<script>$(document).ready(function(){$("#add").trigger("click");});</script>';
}
?>
<!-- Code end add by Ankit -->
<!--<div style="display: none;">
    <input type="hidden" name="form_action" value="" id="form_action"/>
    <?= form_submit('submit', 'submit', 'id="action-form-submit"') ?>
</div>
<?= form_close() ?>
<script language="javascript">
    $(document).ready(function () {

        $('#delete').click(function (e) {
            e.preventDefault();
            $('#form_action').val($(this).attr('data-action'));
            $('#action-form-submit').trigger('click');
        });

        $('#excel').click(function (e) {
            e.preventDefault();
            $('#form_action').val($(this).attr('data-action'));
            $('#action-form-submit').trigger('click');
        });

        $('#pdf').click(function (e) {
            e.preventDefault();
            $('#form_action').val($(this).attr('data-action'));
            $('#action-form-submit').trigger('click');
        });

    });
</script>-->

<!-- Add By Ankit for credit voucher interstore Syncing -->
<script type="text/javascript">
$('#export').click(function(event) {
    event.preventDefault();
    var r=confirm("Are you sure you want to Export Credit Voucher Data?");
    if (r==true){ 
       window.location = $(this).attr('href');
    }
 
});
$('#import').click(function(event) {
    event.preventDefault();
    var r=confirm("Are you sure you want to Import Credit Voucher Data?");
    if (r==true)   {
    bootbox.dialog({
                    title: "Please Fill Invoice Number",
                    message: '<div class="row">  ' +
                        '<div class="col-md-12"> ' +
                        '<form class="form-horizontal" role="form" data-toggle="validator">' +
                        '<div class="form-group"> ' +
                        '<label class="col-md-3 control-label" for="users">Invoice</label> ' +
                                                '<div class="col-md-9"> ' +
                                                '<input id="in_no" name="in_no" type="text" data-minlength="14" placeholder="Invoice No." class="form-control input-md" required="required">' +
                                                '</div></div> ' +
                                                '</form> </div></div>',
                                        buttons: {
                                            success: {
                                                label: "Submit",
                                                className: "btn-success",
                                                callback: function () {
                                                    var name = $('#in_no').val();
                                                    if ((name == null) || (name == undefined) || (name == '')) {
                                                        bootbox.alert("Invoice Number Required..");
                                                        return false;
                                                    }
                                                    if (name.replace(/\s/g, "") == "") {
                                                        bootbox.alert("Blank space not allow.. ");
                                                        $("#name").val('');
                                                        $("#name").val() = name.trimLeft();
                                                                return false;
                                                    }
                                                    if (name.substring(0, 1) == ' ')
                                                    {
                                                        $("#name").val('');
                                                        bootbox.alert("Blank space not allow.. ");
                                                        return false;
                                                    }
 
                                                    $.ajax({
                                                        type: "POST",
                                                        url: site.base_url + 'sales/intermediateCVdataSync',
                                                        data: {"name": name},
                                                        datatype: "json",
                                                        success: function (cdata) {
                                                            //console.log(cdata);
                                                            $('#ajaxCall').hide();
                                                            if(cdata.trim() == 'EO_ID')
                                                                bootbox.alert("EO ID has not yet been generated.Please contact swatch HQ to generate EO ID.");
                                                            else if(cdata.trim() == 'failed')
                                                                bootbox.alert("Invalid Invoice Number.");
                                                            var pdata = jQuery.parseJSON(cdata);
                                                            if (pdata !== null) {
                                                           
                                                                window.location = 'sales/msg';
 
                                                            } else {
 
                                                                return false;
                                                            }
                                                        }
                                                    });
 
 
 
                                                                      }
                                                     }
                                                 }
                                                   
                                    });
    }
 
});
</script>
<!-- End Add By Ankit for credit voucher interstore Syncing -->