<script>
    $(document).ready(function () {
        
     $("#sdate").datetimepicker({
                changeMonth: true,
                autoclose:true,
                showSecond: false,
                minView: 4,
                //format: 'yyyy-mm-dd',
				// changed by vikas singh
		format: 'yyyy-mm-dd',
                startDate: 'today',
                endDate: new Date(),          
        });
        
     $("#edate").datetimepicker({
                changeMonth: true,
                autoclose:true,
                showSecond: false,
                minView: 4,
                //format: 'yyyy-mm-dd',
				// changed by vikas singh
		format: 'yyyy-mm-dd',
                endDate: new Date(),
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
        var id = '<?=$id?>';
       
        var sdate = $("#sdate").val();
        var edate = $("#edate").val();
        var oTable = $('#staffTable').dataTable({
            "bDestroy": true,
            "aaSorting": [[2, "asc"], [3, "asc"]],
            "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "<?= lang('all') ?>"]],
            "iDisplayLength": <?= $Settings->rows_per_page ?>,
            'bProcessing': true, 'bServerSide': true,
            'sAjaxSource': '<?= site_url('reports/getUserSessions') ?>',
            'fnServerData': function (sSource, aoData, fnCallback) {
                aoData.push({
//                    "name": "<?= $this->security->get_csrf_token_name() ?>",
//                    "value": "<?= $this->security->get_csrf_hash() ?>"
                      "name": "date",
                      "value": sdate + '|' + edate + '|' + id
                });
                $.ajax({'dataType': 'json', 'type': 'POST', 'url': sSource, 'data': aoData, 'success': fnCallback});
            },
            "aoColumns": [{
                    "bSortable": false,
                    "mRender": checkbox
                },null,null,null,null],
        });
    });
 });
</script>
<style>.table td:nth-child(6) {
        text-align: center;
    }</style>
<?php if ($Owner) {
    echo form_open('auth/user_actions', 'id="action-form"');
} ?>
<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-users"></i><?= lang('users'); ?></h2>
    </div>
    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">
                <p class="introtext"><?= lang('view_report_staff'); ?></p>
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
                    <table id="staffTable" cellpadding="0" cellspacing="0" border="0"
                           class="table table-bordered table-hover table-striped reports-table">
                        <thead>
                        <tr>
                            <th style="min-width:30px; width: 30px; text-align: center;">
                                <input class="checkbox checkft" type="checkbox" name="check"/>
                            </th>
                            <th><?php echo lang('User_id'); ?></th>
                            <th><?php echo lang('Login'); ?></th>
                            <th><?php echo lang('Login time'); ?></th>
                            <th><?php echo lang('Logout time'); ?></th>
                            
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td colspan="5" class="dataTables_empty"><?= lang('loading_data_from_server') ?></td>
                        </tr>
                        </tbody>
                        <tfoot>
                        <tr class="active">
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                           
                        </tr>
                        </tfoot>
                    </table>
                </div>

            </div>

        </div>
    </div>
</div>
<?php if ($Owner) { ?>
    <div style="display: none;">
        <input type="hidden" name="form_action" value="" id="form_action"/>
        <?= form_submit('performAction', 'performAction', 'id="action-form-submit"') ?>
    </div>
    <?= form_close() ?>

    <script language="javascript">
        $(document).ready(function () {
            $('#set_admin').click(function () {
                $('#usr-form-btn').trigger('click');
            });

        });
    </script>

<?php } ?>