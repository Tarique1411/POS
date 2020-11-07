<script>
    $(document).ready(function () {
        var oTable = $('#PExData').dataTable({
            "aaSorting": [[1, "desc"]],
            "aLengthMenu": [[10, 30, 20, 100, -1], [10, 30, 20, 100, "<?= lang('all') ?>"]],
            "iDisplayLength": <?= $Settings->rows_per_page ?>,
            'bProcessing': true, 'bServerSide': false, 'bDestroy': true,
            'sAjaxSource': '<?= site_url('reports/getBankReports') ?>',
            'fnServerData': function (sSource, aoData, fnCallback) {
                aoData.push({
                    "name": "<?= $this->security->get_csrf_token_name() ?>",
                    "value": "<?= $this->security->get_csrf_hash() ?>"
                });
                $.ajax({'dataType': 'json', 'type': 'POST', 'url': sSource, 'data': aoData, 'success': fnCallback});
            },
            "aoColumns": [{"bSortable": false, "mRender": checkbox}, {"mRender": dateonly}, null, {"mRender": currencyFormat}, null, null],
            'fnRowCallback': function (nRow, aData, iDisplayIndex) {
                var oSettings = oTable.fnSettings();
                nRow.id = aData[0];
                //nRow.className = "";
                return nRow;
            }
        });
    });
</script>

<div class="box">
    <div class="box-header">
        <h2 class="blue"><i
                class="fa-fw fa fa-calendar-o"></i><?= lang('bank_report'); //. ' (' . ($warehouse_id ? $warehouse->name : lang('all_warehouses')) . ')'; ?>
        </h2>

        <!--div class="box-icon">
            <ul class="btn-tasks">
                <?php if (!empty($warehouses) && ($Owner || $Admin)) { ?>
                    <li class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <i class="icon fa fa-building-o tip" data-placement="left" title="<?= lang("warehouses") ?>"></i>
                        </a>
                        <ul class="dropdown-menu pull-right" class="tasks-menus" role="menu" aria-labelledby="dLabel">
                            <li>
                                <a href="<?= site_url('reports/foc') ?>">
                                    <i class="fa fa-building-o"></i> <?= lang('all_warehouses') ?>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <?php
                            foreach ($warehouses as $warehouse) {
                                echo '<li ' . ($warehouse_id && $warehouse_id == $warehouse->id ? 'class="active"' : '') . '><a href="' . site_url('reports/expiry_alerts/' . $warehouse->id) . '"><i class="fa fa-building"></i>' . $warehouse->name . '</a></li>';
                            }
                            ?>
                        </ul>
                    </li>
                <?php } ?>
            </ul>
        </div-->
    </div>
    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">

                <p class="introtext"><?= lang('list_results'); ?></p>

                <div class="table-responsive">
                    <table id="PExData" cellpadding="0" cellspacing="0" border="0"
                           class="table table-bordered table-condensed table-hover table-striped dfTable reports-table">
                        <thead>
                            <tr class="active">
                                <th style="min-width:30px; width: 30px; text-align: center;">
                                    <input class="checkbox checkft" type="checkbox" name="check"/>
                                </th>
                                <th width="30%" ><?php echo $this->lang->line("date"); ?></th>
                                <th width="15%" ><?php echo $this->lang->line("bank"); ?></th>                            
                                <th width="15%" ><?php echo $this->lang->line("amount"); ?></th>
                                <th width="20%" ><?php echo $this->lang->line("created_by"); ?></th>                            
                                <th width="20%"><?php echo $this->lang->line("Remarks"); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="6" class="dataTables_empty"><?= lang('loading_data_from_server'); ?></td>
                            </tr>
                        </tbody>
                        <tfoot class="dtFilter">
                            <tr class="active">
                                <th style="min-width:30px; width: 30px; text-align: center;">
                                    <input class="checkbox checkft" type="checkbox" name="check"/>
                                </th>
                                <th width="30%" ><?php echo $this->lang->line("date"); ?></th>
                                <th width="15%" ><?php echo $this->lang->line("bank"); ?></th>                            
                                <th width="15%" ><?php echo $this->lang->line("amount"); ?></th>
                                <th width="20%" ><?php echo $this->lang->line("created_by"); ?></th>                            
                                <th width="20%"><?php echo $this->lang->line("Remarks"); ?></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
