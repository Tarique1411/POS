<style type="text/css" media="screen">
    #PRData td:nth-child(6), #PRData td:nth-child(7) {
        text-align: right;
    }
    <?php if($Owner || $Admin || $this->session->userdata('show_cost')) { ?>
    #PRData td:nth-child(8) {
        text-align: right;
    }
    <?php } ?>
</style>
<script type="text/javascript">
    
        function loadProduct($catid){
            var oTable;
            oTable = $('#PRData').dataTable({
                "aaSorting": [[2, "asc"], [3, "asc"]],
                "aLengthMenu": [[-1], ["<?= lang('all') ?>"]],
                //"iDisplayLength": <?= $Settings->rows_per_page ?>,
                "iDisplayLength" : -1,
                'bProcessing': true, 'bServerSide': false, 'bDestroy': true,
                'sAjaxSource': '<?= site_url('products/getProducts'.($warehouse_id ? '/'.$warehouse_id : '')) ?>',
                'fnServerData': function (sSource, aoData, fnCallback) {
                    aoData.push({
                        //"name": "<?= $this->security->get_csrf_token_name() ?>",
                        //"value": "<?= $this->security->get_csrf_hash() ?>"
                        "name":"category_id",
                        "value":$catid
                    });
                    $.ajax({'dataType': 'json', 'type': 'POST', 'url': sSource, 'data': aoData, 'success': fnCallback});
                },
                'fnRowCallback': function (nRow, aData, iDisplayIndex) {
                    var oSettings = oTable.fnSettings();
                    nRow.id = aData[0];
                   // nRow.className = "product_link";
                    //if(aData[7] > aData[9]){ nRow.className = "product_link warning"; } else { nRow.className = "product_link"; }
                    return nRow;
                },
                "aoColumns": [
                    {"bSortable": false, "mRender": checkbox}, {
                        "bSortable": true
                    }, null, null, 
                        <?php if($Owner || $Admin) 
                            { echo '{"mRender": currencyFormat}, {"mRender": currencyFormat},'; } 
                            else 
                            { 
                            if($this->session->userdata('show_cost')) 
                            { echo '{"mRender": currencyFormat},';  } 
                            if($this->session->userdata('show_price')) 
                                { echo '{"mRender": currencyFormat},';  }
                            } ?> 
                            {"mRender": convertToInteger}, 
                            //null, 
                            <?php if(!$warehouse_id) 
                                { echo '{"bVisible": false},'; } 
                                else 
                                    { echo '{"bSortable": true},'; } 
                            ?>
                            {"bSortable": false}
                ]
            }).fnSetFilteringDelay().dtFilter([
                {column_number: 2, filter_default_label: "[<?=lang('product_code');?>]", filter_type: "text", data: []},
                {column_number: 3, filter_default_label: "[<?=lang('product_name');?>]", filter_type: "text", data: []},
                {column_number: 4, filter_default_label: "[<?=lang('category');?>]", filter_type: "text", data: []},
                <?php $col = 4;
                if($Owner || $Admin) {
                    echo '{column_number : 5, filter_default_label: "['.lang('product_cost').']", filter_type: "text", data: [] },';
                    echo '{column_number : 6, filter_default_label: "['.lang('product_price').']", filter_type: "text", data: [] },';
                    $col += 2;
                } else {
                    if($this->session->userdata('show_cost')) { $col++; echo '{column_number : '.$col.', filter_default_label: "['.lang('product_cost').']", filter_type: "text", data: [] },'; }
                    if($this->session->userdata('show_price')) { $col++; echo '{column_number : '.$col.', filter_default_label: "['.lang('product_price').']", filter_type: "text, data: []" },'; }
                }
                ?>
                {column_number: <?php $col++; echo $col; ?>, filter_default_label: "[<?=lang('quantity');?>]", filter_type: "text", data: []},
    //            {column_number: <?php $col++; echo $col; ?>, filter_default_label: "[<?=lang('product_unit');?>]", filter_type: "text", data: []},
                <?php //if($warehouse_id && $Settings->racks) { $col++; echo '{column_number : '. $col.', filter_default_label: "['.lang('rack').']", filter_type: "text", data: [] },'; } ?>
                {column_number: <?php $col++; echo $col; ?>, filter_default_label: "[<?=lang('lot_no');?>]", filter_type: "text", data: []},
            ], "footer");
        }
   
</script>
<?php if ($Owner || $Admin || $Manager || $Sales) {
    echo form_open('products/product_actions'.($warehouse_id ? '/'.$warehouse_id : ''), 'id="action-form"');
} ?>
<div class="box">
    <div class="box-header">
        <h2 class="blue"><i
                class="fa-fw fa fa-barcode"></i><!--?= lang('products') . ' (' . ($warehouse_id ? $warehouse->name : lang('all_warehouses')) . ')'; ?-->
                <?= lang('products'). ($warehouse_id ? ' ('.$warehouse->name.')' :'' ); ?>
        </h2>

        <div class="box-icon">
            <ul class="btn-tasks">
                <!--Added By Anil for action permission Start-->  
                <?php if ($Owner) { ?>    
                    <li class="dropdown">                         
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#"><i class="icon fa fa-tasks tip" data-placement="left" title="<?= lang("actions") ?>"></i></a>
                        <ul class="dropdown-menu pull-right" class="tasks-menus" role="menu" aria-labelledby="dLabel">
                            <li><a href="<?= site_url('products/add') ?>"><i class="fa fa-plus-circle"></i> <?= lang('add_product') ?></a></li>
                            <li><a href="#" id="barcodeProducts" data-action="barcodes"><i class="fa fa-print"></i> <?= lang('print_barcodes') ?></a></li>
                            <li><a href="#" id="labelProducts" data-action="labels"><i class="fa fa-print"></i> <?= lang('print_labels') ?></a></li>
                            <li><a href="#" id="sync_quantity" data-action="sync_quantity"><i class="fa fa-arrows-v"></i> <?= lang('sync_quantity') ?></a></li>
                            <li><a href="#" id="excel" data-action="export_excel"><i class="fa fa-file-excel-o"></i> <?= lang('export_to_excel') ?></a></li>
                            <li><a href="#" id="pdf" data-action="export_pdf"><i class="fa fa-file-pdf-o"></i> <?= lang('export_to_pdf') ?></a></li>
                            <li class="divider"></li>
                            <li><a href="#" class="bpo" title="<b><?= $this->lang->line("delete_products") ?></b>"
                                   data-content="<p><?= lang('r_u_sure') ?></p><button type='button' class='btn btn-danger' id='delete' data-action='delete'><?= lang('i_m_sure') ?></a> <button class='btn bpo-close'><?= lang('no') ?></button>" data-html="true" data-placement="left"><i class="fa fa-trash-o"></i> <?= lang('delete_products') ?></a></li>
                        </ul>                         
                    </li> 
                <?php } else { ?>
                <li class="dropdown">                         
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#"><i class="icon fa fa-tasks tip" data-placement="left" title="<?= lang("actions") ?>"></i></a>
                        <ul class="dropdown-menu pull-right" class="tasks-menus" role="menu" aria-labelledby="dLabel">
                        <?php if($GP['products-add']==1) { ?>      
                            <li><a href="<?= site_url('products/add') ?>"><i class="fa fa-plus-circle"></i> <?= lang('add_product') ?></a></li>
                        <?php } 
                         if($GP['products-print_barcodes'] == 1) { ?>    
                            <li><a href="#" id="barcodeProducts" data-action="barcodes"><i class="fa fa-print"></i> <?= lang('print_barcodes') ?></a></li>
                        <?php } 
                         if($GP['products-print_labels'] == 1) { ?>      
                            <li><a href="#" id="labelProducts" data-action="labels"><i class="fa fa-print"></i> <?= lang('print_labels') ?></a></li>
                        <?php } 
                         if($GP['products-sync_quantity'] == 1) { ?>    
                            <li><a href="#" id="sync_quantity" data-action="sync_quantity"><i class="fa fa-arrows-v"></i> <?= lang('sync_quantity') ?></a></li>
                        <?php } 
                         if($GP['products-export_excel'] == 1) { ?>
                            <li><a href="#" id="excel" data-action="export_excel"><i class="fa fa-file-excel-o"></i> <?= lang('export_to_excel') ?></a></li>
                        <?php } 
                         if($GP['products-export_pdf'] == 1) { ?>     
                            <li><a href="#" id="pdf" data-action="export_pdf"><i class="fa fa-file-pdf-o"></i> <?= lang('export_to_pdf') ?></a></li>
                            <li class="divider"></li>
                         <?php } 
                         if($GP['products-delete'] == 1) { ?>    
                            <li><a href="#" class="bpo" title="<b><?= $this->lang->line("delete_products") ?></b>"
                                   data-content="<p><?= lang('r_u_sure') ?></p><button type='button' class='btn btn-danger' id='delete' data-action='delete'><?= lang('i_m_sure') ?></a> <button class='btn bpo-close'><?= lang('no') ?></button>" data-html="true" data-placement="left"><i class="fa fa-trash-o"></i> <?= lang('delete_products') ?></a></li>
                        <?php } ?>           
                        </ul>                         
                    </li>                    
                <?php } ?> 
                <?php if (!empty($warehouses)) { ?>
                    <!--li class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#"><i class="icon fa fa-building-o tip" data-placement="left" title="<?= lang("warehouses") ?>"></i></a>
                        <ul class="dropdown-menu pull-right" class="tasks-menus" role="menu" aria-labelledby="dLabel">
                            <li><a href="<?= site_url('products') ?>"><i class="fa fa-building-o"></i> <?= lang('all_warehouses') ?></a></li>
                            <li class="divider"></li>
                            <?php
                            foreach ($warehouses as $warehouse) {
                                echo '<li><a href="' . site_url('products/' . $warehouse->id) . '"><i class="fa fa-building"></i>' . $warehouse->name . '</a></li>';
                            }
                            ?>
                        </ul>
                    </li-->
                <?php } ?>
            </ul>
        </div>
    </div>
    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">

                <p class="introtext"><?= lang('list_results'); ?></p>
                <?php //echo form_open(""); ?>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                            <?php
                                $cat = array();
                                $cat[''] = "--SELECT Category--";
                                $cat["all"] = "ALL";
                                foreach($categories as $key=>$val){
                                    $cat[$val->id] = $val->name;
                                }
                                
                                echo form_dropdown('category', $cat, "", 'class="form-control" id="category" data-placeholder="' . $this->lang->line("select") . " " . $this->lang->line("discount_type") . '"');
                            ?>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <button type="button" id="product_category" class="btn btn-success" >
                                    <?= lang('get_record') ?> &nbsp;<i class="fa fa-sign-in"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                <?php //echo form_close();?>
                <div class="table-responsive">
                    <table id="PRData" class="table table-bordered table-condensed table-hover table-striped">
                        <thead>
                        <tr class="primary">
                            <th class="col-xs-1">
                                <input class="checkbox checkth" type="checkbox" name="check"/>
                            </th>
<!--                            <th class="col-xs-1"><?php echo $this->lang->line("image"); ?></th>-->
                            <th class="col-xs-2"><?= lang("product_code") ?></th>
                            <th class="col-xs-2"><?= lang("product_name") ?></th>
                            <th class="col-xs-2"><?= lang("category_name") ?></th>
                            <?php
                            if ($Owner || $Admin) {
                                echo '<th class="col-xs-2">' . lang("product_cost") . '&nbsp;<span class="rupee">&#8377;</span></th>';
                                echo '<th class="col-xs-2">' . lang("product_price") . '&nbsp;<span class="rupee">&#8377;</span></th>';
                            } else {
                                if ($this->session->userdata('show_cost')) {
                                    echo '<th class="col-xs-2">' . lang("product_cost") . '&nbsp;<span class="rupee">&#8377;</span></th>';
                                }
                                if ($this->session->userdata('show_price')) {
                                    echo '<th class="col-xs-2">' . lang("product_price") . '&nbsp;<span class="rupee">&#8377;</span></th>';
                                }
                            }
                            ?>
                            <th class="col-xs-2"><?= lang("quantity") ?></th>
<!--                            <th class="col-xs-2"><?= lang("product_unit") ?></th>-->
                            <!--<th><?= lang("rack") ?></th>-->
                            <th class="col-xs-2"><?= lang("lot_no") ?></th>
                            <th class="col-xs-2"><?= lang("actions") ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td colspan="8" class="dataTables_empty"><?= lang('loading_data_from_server'); ?></td>
                        </tr>
                        </tbody>

                        <tfoot class="dtFilter">
                        <tr class="active">
                            <th style="min-width:30px; width: 30px; text-align: center;">
                                <input class="checkbox checkft" type="checkbox" name="check"/>
                            </th>
                            <th style="min-width:40px; width: 40px; text-align: center;">
                                    <?php //echo $this->lang->line("image"); ?>
                            </th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <?php
                            if ($Owner || $Admin) {
                                echo '<th></th>';
                                echo '<th></th>';
                            } else {
                                if ($this->session->userdata('show_cost')) {
                                    echo '<th></th>';
                                }
                                if ($this->session->userdata('show_price')) {
                                    echo '<th></th>';
                                }
                            }
                            ?>
                            <th></th>

                            <!--<th></th>-->
                            <th style="width:65px; text-align:center;"><?= lang("actions") ?></th>
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
        loadProduct('');
        $("#product_category").on('click', function(event){
            event.preventDefault();
            var category = $("#category option:selected").val();
            if(category != ''){ 
                loadProduct(category);
            }
            else{
                bootbox.alert("Please select a product category!");
                return false;
            }
        });
    });
</script>
