<?php
    $v = "";
    if ($this->input->post('date')) {
        $v .= "&sdate=" . $this->input->post('date');
        echo $v;die;
    }
?>

<?php
if ($Owner || $Admin || $Manager || $Sales) {
    echo form_open('reports/z_actions', 'id="z_action-form" name="z_action-form"');
}
?>
<div class="box">
    <!--div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-bar-chart-o"></i><?= lang('z_report'); ?></h2>
        <div class="box-icon">
            <ul class="btn-tasks">
                <li class="dropdown">
                    <a href="#" id="z_pdf" class="tip" data-action="export_pdf" title="<?= lang('download_pdf') ?>">
                        <i class="icon fa fa-file-pdf-o"></i>
                    </a>
                </li>
                <li class="dropdown">
                    <a href="#" id="z_xls" class="tip" data-action="export_excel" title="<?= lang('download_xls') ?>">
                        <i class="icon fa fa-file-excel-o"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div-->
    
    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="row" style="margin-bottom: 15px;">                    
                    <div class="col-md-12">
                        <ul id="dbTab" class="nav nav-tabs">
                            <?php if ($Owner || $Admin || $GP['today_z-index'] || $Manager || $Sales) { ?>
                                <li class="active"><a href="#today"><?= lang('today') ?></a></li>
                            <?php } if ($Owner || $Admin || $GP['period_z-index'] || $Manager || $Sales) { ?>
                                <li class=""><a href="#date_set"><?= lang('date_wise') ?></a></li>
                            <?php } ?>
                        </ul>

                        <div class="tab-content">
                            <div id="today" class="tab-pane fade in active">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <?php echo form_input('zdate', (isset($_POST['zdate']) ? $_POST['zdate'] : date($dateFormats['php_sdate'],strtotime("now"))), 
                                                'style="visibility: hidden;" id="zdate" name="zdate" '); ?> 
                                        <div class="table-responsive">
                                            <table id="today-tbl" cellpadding="0" cellspacing="0" border="0"
                                                   class="table table-bordered table-hover table-striped"
                                                   style="margin-bottom: 0;">
                                                <thead>
                                                    <tr>
                                                        <th style="min-width:30px; width: 30px; text-align: center;">
                                                            <input class="checkbox checkft" type="checkbox" name="check"/>
                                                        </th>
<!--                                                    <th><?= lang("date"); ?></th>-->
                                                        <th><?= lang("shift_start_date"); ?></th>
                                                        <th><?= lang("shift_close_date"); ?></th>
                                                        <th><?= lang("closing_cash"); ?>&nbsp;<span class="rupee">&#8377;</span></th>
                                                        <th><?= lang("warehouse"); ?></th>
                                                        <th><?= lang("closed_by"); ?></th>
                                                        <th><?= lang("download_pdf"); ?></th>
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
                            
                            <div id="date_set" class="tab-pane fade in">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div id="form">
                                            <?php //echo form_open(""); ?>  
                                            <div class="div-title">
                                                <h3 class="text-primary"><?= lang('select_date') ?></h3>
                                            </div>
                                            <div class="row"> 
                                                <div class="col-sm-3" style="float: left">
                                                    <?php echo form_input('sdate', (isset($_POST['sdate']) ? $_POST['sdate'] : ""), 
                                                            'class="form-control input-tip date" id="sdate" name="sdate" '
                                                            . 'placeholder="Select Start Date" required="required" readonly="true"'); ?> 
                                                </div>
                                                <div class="col-sm-3" style="float: left">
                                                    <?php echo form_input('edate', (isset($_POST['edate']) ? $_POST['edate'] : ""), 
                                                            'class="form-control input-tip date" id="edate" name="edate" '
                                                            . 'placeholder="Select End Date" required="required" readonly="true"'); ?> 
                                                </div>
                                                <div class="col-sm-4" style="float: left"> 
                                                    <button type="submit" id="b1" class="btn btn-success" >
                                                        <?= lang('get_record') ?> &nbsp; 
                                                        <i class="fa fa-sign-in"></i></button> 
                                                </div><br/><br/><br/>
                                                <?php //echo form_close(); ?>
                                            </div>
                                        </div>

                                        <div class="table-responsive">
                                            <table id="period_set-tbl" cellpadding="0" cellspacing="0" border="0"
                                                   class="table table-bordered table-hover table-striped"
                                                   style="margin-bottom: 0;">
                                                <thead>
                                                    <tr>
                                                        <th style="min-width:30px; width: 30px; text-align: center;">
                                                            <input class="checkbox checkft" type="checkbox" name="check"/>
                                                        </th>
<!--                                                        <th><?= lang("date"); ?></th>-->
                                                        <th><?= lang("shift_start_date"); ?></th>
                                                        <th><?= lang("shift_close_date"); ?></th>
                                                        <th><?= lang("closing_total"); ?>&nbsp;<span class="rupee">&#8377;</span></th>
                                                        <th><?= lang("warehouse"); ?></th>
                                                        <th><?= lang("closed_by"); ?></th>
                                                        <th><?= lang("download_pdf"); ?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td colspan="8" class="dataTables_empty"><?= lang('loading_data_from_server') ?></td>
                                                    </tr>
                                                </tbody>
                                                
                                                <tfoot>
                                                    <tr>
                                                        <th style="min-width:30px; width: 30px; text-align: center;">
                                                            <input class="checkbox checkft" type="checkbox" name="check"/>
                                                        </th>
<!--                                                        <th><?= lang("date"); ?></th>-->
                                                        <th><?= lang("shift_start_date"); ?></th>
                                                        <th><?= lang("shift_close_date"); ?></th>
                                                        <th><?= lang("closing_total"); ?>&nbsp;<span class="rupee">&#8377;</span></th>
                                                        <th><?= lang("warehouse"); ?></th>
                                                        <th><?= lang("closed_by"); ?></th>
                                                        <th><?= lang("download_pdf"); ?></th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                            
                </div>
            </div>
        </div>
    </div>
</div>
<?php if ($Owner || $Admin || $Manager || $Sales) { ?>
    <div style="display: none;">
        <input type="hidden" name="z_form_action" value="" id="z_form_action"/>
    <?= form_submit('zperformAction', 'zperformAction', 'id="z-action-form-submit"') ?>
    </div>
    <?= form_close() ?>
<?php } ?>
<script type="text/javascript" src="<?= $assets ?>js/html2canvas.min.js"></script>

<script type="text/javascript">
    $(document).ready(function () {
    var oTable = $('#today-tbl').dataTable({
            "aaSorting": [[0, "desc"]],
            "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "<?= lang('all') ?>"]],
            "iDisplayLength": <?= $Settings->rows_per_page ?>,
            'bProcessing': false, 'bServerSide': false,'bDestroy': true,
            'sAjaxSource': '<?= site_url('reports/getTodayZReport/?v=1') ?>',
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
                }, {"mRender": fld}, {"mRender": fld}, {"mRender": currencyFormat}, null,null,null],
            'fnRowCallback': function (nRow, aData, iDisplayIndex) {
                var oSettings = oTable.fnSettings();
                nRow.id = aData[0];
                nRow.className = "z_report_link";
                return nRow;
            }            
        });
     });

 jQuery(document).ready(function() {
        jQuery("#ydate").datetimepicker({
                changeMonth: false,
                daysDisabled: [0,1,2,3,4,5,6],
                minView: 4,
                changeYear: true,
                autoclose:true,
                showSecond: false,
                startView: 4,
                format: 'yyyy',
                endDate: new Date(),
        });
    });     
                                
                                
 jQuery(document).ready(function() {
        
        jQuery("#sdate").datetimepicker({
                changeMonth: true,
                autoclose:true,
                showSecond: false,
                minView: 2,
                format: 'dd-mm-yyyy',
                startDate: 'today',
                endDate: new Date()
        });
        
        jQuery("#edate").datetimepicker({
                changeMonth: true,
                autoclose:true,
                showSecond: false,
                minView: 2,
                format: 'dd-mm-yyyy',
                startDate: 'today',
                endDate: new Date()
        });
        
});

$('#b1').on('click',function(event){
    event.preventDefault();
    if (jQuery("#sdate").val() == '') {
           alert('Please select start date'); 
           $('#sdate').focus();
           return false;
    }
    
    if (jQuery("#edate").val() == '') {
           alert('Please select end date'); 
           $('#edate').focus();
           return false;
    }
    var sdate = $("#sdate").val();
    var edate = $("#edate").val();
    var oTable = $('#period_set-tbl').dataTable({
        "aaSorting": [[0, "desc"]],
            "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "<?= lang('all') ?>"]],
            "iDisplayLength": <?= $Settings->rows_per_page ?>,
            'bProcessing': false, 'bServerSide': false,'bDestroy': true,
            'sAjaxSource': '<?= site_url('reports/getPeriodZReport/?v=1') ?>',
            'fnServerData': function (sSource, aoData, fnCallback) {
                aoData.push({
                    "name": "<?= $this->security->get_csrf_token_name() ?>",
                    "value": "<?= $this->security->get_csrf_hash() ?>",
                    "name": "date",
                    "value": sdate + '|' + edate
                });
                $.ajax({'dataType': 'json', 'type': 'POST', 'url': sSource, 'data': aoData, 'success': fnCallback});
            },
            "aoColumns": [{
                    "bSortable": false,
                    "mRender": checkbox
                },{"mRender": fld}, {"mRender": fld}, {"mRender": currencyFormat},null,null,null],
            'fnRowCallback': function (nRow, aData, iDisplayIndex) {
                var oSettings = oTable.fnSettings();
                nRow.id = aData[0];
                nRow.className = "z_report_link";
                return nRow;
            }       
        });  
});
</script>  