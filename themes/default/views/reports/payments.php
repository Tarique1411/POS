<?php
$v = "";
/* if($this->input->post('name')){
  $v .= "&name=".$this->input->post('name');
} */
//if ($this->input->post('payment_ref')) {
//    $v .= "&payment_ref=" . $this->input->post('payment_ref');
//}
//if ($this->input->post('sale_ref')) {
//    $v .= "&sale_ref=" . $this->input->post('sale_ref');
//}
//if ($this->input->post('purchase_ref')) {
//    $v .= "&purchase_ref=" . $this->input->post('purchase_ref');
//}
//if ($this->input->post('supplier')) {
//    $v .= "&supplier=" . $this->input->post('supplier');
//}
//if ($this->input->post('warehouse')) {
//    $v .= "&biller=" . $this->input->post('biller');
//}
//if ($this->input->post('customer')) {
//    $v .= "&customer=" . $this->input->post('customer');
//}
//if ($this->input->post('user')) {
//    $v .= "&user=" . $this->input->post('user');
//}
//if ($this->input->post('start_date')) {
//    $v .= "&start_date=" . $this->input->post('start_date');
//}
//if ($this->input->post('end_date')) {
//    $v .= "&end_date=" . $this->input->post('end_date');
//}
?>
<script type="text/javascript">
//    $(document).ready(function () {
//        $('#form').hide();
       <?php //if ($this->input->post('biller')) { ?>
//        $('#rbiller').select2({ allowClear: true });
        <?php// } ?>       <?php //if ($this->input->post('supplier')) { ?>
//        $('#rsupplier').val(<?//= $this->input->post('supplier') ?>).select2({
//            minimumInputLength: 1,
//            allowClear: true,
//            initSelection: function (element, callback) {
//                $.ajax({
//                    type: "get", async: false,
//                    url: "<?//= site_url('suppliers/getSupplier') ?>/" + $(element).val(),
//                    dataType: "json",
//                    success: function (data) {
//                        callback(data[0]);
//                    }
//                });
//            },
//            ajax: {
//                url: site.base_url + "suppliers/suggestions",
//                dataType: 'json',
//                quietMillis: 15,
//                data: function (term, page) {
//                    return {
//                        term: term,
//                        limit: 10
//                    };
//                },
//                results: function (data, page) {
//                    if (data.results != null) {
//                        return {results: data.results};
//                    } else {
//                        return {results: [{id: '', text: 'No Match Found'}]};
//                    }
//                }
//            }
//        });
//        $('#rsupplier').val(<?//= $this->input->post('supplier') ?>);
               <?php //} ?>
//        <?php //if ($this->input->post('customer')) { ?>
//        $('#rcustomer').val(<?//= $this->input->post('customer') ?>).select2({
//            minimumInputLength: 1,
//            allowClear: true,
//            initSelection: function (element, callback) {
//                $.ajax({
//                    type: "get", async: false,
//                    url: "<?//= site_url('customers/getCustomer') ?>/" + $(element).val(),
//                    dataType: "json",
//                    success: function (data) {
//                        callback(data[0]);
//                    }
//                });
//            },
//            ajax: {
//                url: site.base_url + "customers/suggestions",
//                dataType: 'json',
//                quietMillis: 15,
//                data: function (term, page) {
//                    return {
//                        term: term,
//                        limit: 10
//                    };
//                },
//                results: function (data, page) {
//                    if (data.results != null) {
//                        return {results: data.results};
//                    } else {
//                        return {results: [{id: '', text: 'No Match Found'}]};
//                    }
//                }
//            }
//        });
        <?php //} ?>
//        $('.toggle_down').click(function () {
//            $("#form").slideDown();
//            return false;
//        });
//        $('.toggle_up').click(function () {
//            $("#form").slideUp();
//            return false;
//        });
//    });
</script>

<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-money"></i><?= lang('payments_report'); ?> <?php
            //if ($this->input->post('start_date')) {
                //echo "From " . $this->input->post('start_date') . " to " . $this->input->post('end_date');
           // }
            ?></h2>

<!--        <div class="box-icon">
            <ul class="btn-tasks">
                <li class="dropdown"><a href="#" class="toggle_up tip" title="<?//= lang('hide_form') ?>"><i
                            class="icon fa fa-toggle-up"></i></a></li>
                <li class="dropdown"><a href="#" class="toggle_down tip" title="<?//= lang('show_form') ?>"><i
                            class="icon fa fa-toggle-down"></i></a></li>
            </ul>
        </div>-->
        <div class="box-icon">
            <ul class="btn-tasks">
                <li class="dropdown"><a href="#" id="pdf" class="tip" title="<?= lang('download_pdf') ?>"><i
                            class="icon fa fa-file-pdf-o"></i></a></li>
                <li class="dropdown"><a href="#" id="xls" class="tip" title="<?= lang('download_xls') ?>"><i
                            class="icon fa fa-file-excel-o"></i></a></li>
                <li class="dropdown"><a href="#" id="image" class="tip" title="<?= lang('save_image') ?>"><i
                            class="icon fa fa-file-picture-o"></i></a></li>
            </ul>
        </div>
    </div>
    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">

                <p class="introtext"><?= lang('customize_report'); ?></p>

<!--                <div id="form">

                    <?php //echo form_open("reports/payments"); ?>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <?//= lang("payment_ref", "payment_ref"); ?>
                                <?php// echo form_input('payment_ref', (isset($_POST['payment_ref']) ? $_POST['payment_ref'] : ""), 'class="form-control tip" id="payment_ref"'); ?>

                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <?//= lang("sale_ref", "sale_ref"); ?>
                                <?php //echo form_input('sale_ref', (isset($_POST['sale_ref']) ? $_POST['sale_ref'] : ""), 'class="form-control tip" id="sale_ref"'); ?>

                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <?//= lang("purchase_ref", "purchase_ref"); ?>
                                <?php //echo form_input('purchase_ref', (isset($_POST['purchase_ref']) ? $_POST['purchase_ref'] : ""), 'class="form-control tip" id="purchase_ref"'); ?>

                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label" for="rcustomer"><?= lang("customer"); ?></label>
                                <?php //echo form_input('customer', (isset($_POST['customer']) ? $_POST['customer'] : ""), 'class="form-control" id="rcustomer" data-placeholder="' . $this->lang->line("select") . " " . $this->lang->line("customer") . '"'); ?>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label" for="rbiller"><?= lang("biller"); ?></label>
                                <?php
                                //$bl[''] = '';
//                                foreach ($billers as $biller) {
//                                    $bl[$biller->id] = $biller->company != '-' ? $biller->company : $biller->name;
//                                }
//                                echo form_dropdown('biller', $bl, (isset($_POST['biller']) ? $_POST['biller'] : ""), 'class="form-control" id="rbiller" data-placeholder="' . $this->lang->line("select") . " " . $this->lang->line("biller") . '"');
                                ?>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <?//= lang("supplier", "rsupplier"); ?>
                                <?php //echo form_input('supplier', (isset($_POST['supplier']) ? $_POST['supplier'] : ""), 'class="form-control" id="rsupplier" data-placeholder="' . $this->lang->line("select") . " " . $this->lang->line("supplier") . '"'); ?> </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label" for="user"><?= lang("created_by"); ?></label>
                                <?php
//                                $us[""] = "";
//                                foreach ($users as $user) {
//                                    $us[$user->id] = $user->first_name . " " . $user->last_name;
//                                }
//                                echo form_dropdown('user', $us, (isset($_POST['user']) ? $_POST['user'] : ""), 'class="form-control" id="user" data-placeholder="' . $this->lang->line("select") . " " . $this->lang->line("user") . '"');
                                ?>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <?//= lang("start_date", "start_date"); ?>
                                <?php// echo form_input('start_date', (isset($_POST['start_date']) ? $_POST['start_date'] : ""), 'class="form-control date" id="start_date"'); ?>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <?//= lang("end_date", "end_date"); ?>
                                <?php //echo form_input('end_date', (isset($_POST['end_date']) ? $_POST['end_date'] : ""), 'class="form-control date" id="end_date"'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div
                            class="controls"> <?php //echo form_submit('submit_report', $this->lang->line("submit"), 'class="btn btn-primary"'); ?> </div>
                    </div>
                    <?php //echo form_close(); ?>

                </div>-->
                <div class="clearfix"></div>
                
                <!-- Update by Ankit-->

<div class="row" style="margin-bottom: 15px;">
    <div class="col-md-12">
        
            
            <div class="box-content">
                <div class="row">
                    <div class="col-md-12">

                        <ul id="dbTab" class="nav nav-tabs">
                            <?php if ($Owner || $Admin || $GP['today-index'] || $Manager) { ?>
                            <li class="active"><a href="#today"><?= lang('today') ?></a></li>
                            <?php } if ($Owner || $Admin || $GP['month-index'] || $Manager) { ?>
                            <li class=""><a href="#month"><?= lang('current_month') ?></a></li>
                            <?php } if ($Owner || $Admin || $GP['period_set-index'] || $Manager) { ?>
                            <li class=""><a href="#period_set"><?= lang('period_set') ?></a></li>
                            <?php } if ($Owner || $Admin || $GP['ytd_payments-index'] || $Manager) { ?>
                            <li class=""><a href="#ytd_payments"><?= lang('ytd_payments') ?></a></li>
                            <?php } ?>
                        </ul>

                        <div class="tab-content">
                        <?php if ($Owner || $Admin || $GP['today-index'] || $Manager) { ?>

                            <div id="today" class="tab-pane fade in active">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="table-responsive">
                                            <table id="today-tbl" cellpadding="0" cellspacing="0" border="0"
                                                   class="table table-bordered table-hover table-striped"
                                                   style="margin-bottom: 0;">
                                                
                                                <thead>
                                                    <tr>
                                                        <th><?= lang("date"); ?></th>
                                                        <th><?= lang("payment_ref"); ?></th>
                                                        <th><?= lang("sale_ref"); ?></th>
                                                        <th><?= lang("purchase_ref"); ?></th>
                                                        <th><?= lang("paid_by"); ?></th>
                                                        <th><?= lang("amount"); ?></th>
                                                        <th><?= lang("type"); ?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td colspan="7" class="dataTables_empty"><?= lang('loading_data_from_server') ?></td>
                                                </tr>
                                                </tbody>
                                                 </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php } if ($Owner || $Admin || $GP['month-index'] || $Manager) { ?>
                                 
                            <div id="month" class="tab-pane fade in">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="table-responsive">
                                            <table id="month-tbl" cellpadding="0" cellspacing="0" border="0"
                                                   class="table table-bordered table-hover table-striped"
                                                   style="margin-bottom: 0;">
                                                <thead>
                                                    <tr>
                                                        <th><?= lang("date"); ?></th>
                                                        <th><?= lang("payment_ref"); ?></th>
                                                        <th><?= lang("sale_ref"); ?></th>
                                                        <th><?= lang("purchase_ref"); ?></th>
                                                        <th><?= lang("paid_by"); ?></th>
                                                        <th><?= lang("amount"); ?></th>
                                                        <th><?= lang("type"); ?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td colspan="7" class="dataTables_empty"><?= lang('loading_data_from_server') ?></td>
                                                </tr>
                                                </tbody>
                                                 </table>
                                              <p><?php echo $links; ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php } if ($Owner || $Admin || $GP['period_set-index'] || $Manager) { ?>
                                 
                            <div id="period_set" class="tab-pane fade in">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="row">
                                            <div class="col-sm-12"> 
                                                
                                              <?php echo form_open(""); ?>  
                                               <div class="div-title">
                                                    <h3 class="text-primary"><?= lang('select_period') ?></h3>
                                                </div>
                                                   <div class="row"> 
                                                       <div class="col-sm-4" style="float: left">
                                                                                                                      
                                                       <?php echo form_input('date', (isset($_POST['date']) ? $_POST['date'] : ""), 'class="form-control input-tip date" id="sdate" placeholder="Start Date" required="required" readonly="true"'); ?> 
                                                       </div>
                                                       
                                                     <div class="col-sm-4" style="float: left">  
                                                    
                                                         <?php echo form_input('date', (isset($_POST['date']) ? $_POST['date'] : ""), 'class="form-control input-tip date" id="edate" placeholder="End Date" required="required" readonly="true"'); ?>
                                                    
                                                     </div> 
                                                       <div class="col-sm-4" style="float: left"> 
                                                           <button type="submit" id="b1" class="btn btn-success" ><?= lang('get_record') ?> &nbsp; <i
                                                      class="fa fa-sign-in"></i></button> 
                                                       </div><br/><br/><br/>
                                                     <?php echo form_close(); ?>
                                                
                                                </div>
                                                
                                            </div>
                                        </div>    
                                        <div class="table-responsive">
                                            <table id="period_set-tbl" cellpadding="0" cellspacing="0" border="0"
                                                   class="table table-bordered table-hover table-striped"
                                                   style="margin-bottom: 0;">
                                                <thead>
                                                    <tr>
                                                        <th><?= lang("date"); ?></th>
                                                        <th><?= lang("payment_ref"); ?></th>
                                                        <th><?= lang("sale_ref"); ?></th>
                                                        <th><?= lang("purchase_ref"); ?></th>
                                                        <th><?= lang("paid_by"); ?></th>
                                                        <th><?= lang("amount"); ?></th>
                                                        <th><?= lang("type"); ?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td colspan="7" class="dataTables_empty"><?= lang('loading_data_from_server') ?></td>
                                                </tr>
                                                </tbody>
                                              </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php } if ($Owner || $Admin || $GP['ytd_payments-index'] || $Manager) { ?>
                                 
                            <div id="ytd_payments" class="tab-pane fade in">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="row">
                                            <div class="col-sm-12"> 
                                                
                                              <?php echo form_open(""); ?>  
                                               <div class="div-title">
                                                    <h3 class="text-primary"><?= lang('ytd_payments_year') ?></h3>
                                                </div>
                                                   <div class="row"> 
                                                       <div class="col-sm-4" style="float: left">
                                                                                                                      
                                                       <?php echo form_input('date', (isset($_POST['date']) ? $_POST['date'] : ""), 'class="form-control input-tip date" id="ydate" readonly="true" placeholder="Select Year " required="required"'); ?> 
                                                       </div>
                                                       
                                                       <div class="col-sm-4" style="float: left"> 
                                                           <button type="submit" id="b2" class="btn btn-success" ><?= lang('get_record') ?> &nbsp; <i
                                                      class="fa fa-sign-in"></i></button> 
                                                       </div><br/><br/><br/>
                                                     <?php echo form_close(); ?>
                                                
                                                </div>
                                                
                                            </div>
                                        </div>    
                                        <div class="table-responsive">
                                            <table id="ytd_sale-tbl" cellpadding="0" cellspacing="0" border="0"
                                                   class="table table-bordered table-hover table-striped"
                                                   style="margin-bottom: 0;">
                                                <thead>
                                                    <tr>
                                                        <th><?= lang("date"); ?></th>
                                                        <th><?= lang("payment_ref"); ?></th>
                                                        <th><?= lang("sale_ref"); ?></th>
                                                        <th><?= lang("purchase_ref"); ?></th>
                                                        <th><?= lang("paid_by"); ?></th>
                                                        <th><?= lang("amount"); ?></th>
                                                        <th><?= lang("type"); ?></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td colspan="7" class="dataTables_empty"><?= lang('loading_data_from_server') ?></td>
                                                </tr>
                                                </tbody>
                                                </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <?php } ?>

                        </div>


                    </div>

                </div>

            </div>
        
    </div>

</div>

<!--End the code of update by Ankit ----->
                

                <div class="clearfix"></div><br><br> 
                

            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?= $assets ?>js/html2canvas.min.js"></script>
<!--Add By Ankit for download PDF and XML file of payment list @ 15/06/2016-->
<script>
//$(document).ready(function () {
//    $('.nav-tabs').on('shown.bs.tab', function(e){
//        var pp= $(e.target).text();
//        alert(pp);
//    });
//});
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#pdf').click(function (event) {
            event.preventDefault();
            window.location.href = "<?=site_url('reports/getTodayPayments/pdf/?v=1'.$v)?>"; 
               return false;
        
    });
    $('#xls').click(function (event) {
            event.preventDefault();
            window.location.href = "<?=site_url('reports/getTodayPayments/0/xls/?v=1'.$v)?>";
            return false;
       });
         $('.nav-tabs').on('shown.bs.tab', function(e){
        var pp= $(e.target).text();
        $('#pdf').click(function (event) {
            event.preventDefault();
            //alert(pp);
            if(pp=='Today'){
            window.location.href = "<?=site_url('reports/getTodayPayments/pdf/?v=1'.$v)?>";
            return false;
            }
            if(pp=='Current Month'){
            window.location.href = "<?=site_url('reports/getCurrentMonthPayments/pdf/?v=1'.$v)?>";
            return false;
            }
            if(pp=='Period Set'){
                var sdate = $("#sdate").val();
                var edate = $("#edate").val();
              window.location.href = "<?=site_url('reports/getPeriod/pdf')?>"+'?sdate='+sdate+'&edate='+edate;
            return false;
            }
            if(pp=='YDT Payments'){
            var ydate = $("#ydate").val();
            window.location.href = "<?=site_url('reports/getytd/pdf')?>"+'?ydate='+ydate;
            return false;
            }
            else{
               window.location.href = "<?=site_url('reports/getTodayPayments/pdf/?v=1'.$v)?>"; 
               return false;
           }
            
        }); 
        $('#xls').click(function (event) {
            event.preventDefault();
            if(pp=='Today'){
            window.location.href = "<?=site_url('reports/getTodayPayments/0/xls/?v=1'.$v)?>";
            return false;
            }
            if(pp=='Current Month'){
            window.location.href = "<?=site_url('reports/getCurrentMonthPayments/0/xls/?v=1'.$v)?>";
            return false;
            }
            if(pp=='Period Set'){
                var sdate = $("#sdate").val();
                var edate = $("#edate").val();
              window.location.href = "<?=site_url('reports/getPeriod/0/xls')?>"+'?sdate='+sdate+'&edate='+edate;
            return false;
            }
            if(pp=='YDT Payments'){
            var ydate = $("#ydate").val();
            window.location.href = "<?=site_url('reports/getytd/0/xls')?>"+'?ydate='+ydate;
            return false;
            }
            else{
               window.location.href = "<?=site_url('reports/getTodayPayments/0/xls/?v=1'.$v)?>"; 
               return false;
            }
//            window.location.href = "<?//=site_url('reports/getPaymentsReport/0/xls/?v=1'.$v)?>";
//            return false;
        }); });
        $('#image').click(function (event) {
            event.preventDefault();
            html2canvas($('.box'), {
                onrendered: function (canvas) {
                    var img = canvas.toDataURL()
                    window.open(img);
                }
            });
            return false;
        });
     });
</script>
<!------------ ADD By Ankit------------------>
<script>
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
                format: 'yyyy-mm-dd',
                startDate: 'today',
                endDate: new Date(),
                
                
        });
        
      jQuery("#edate").datetimepicker({
                changeMonth: true,
                autoclose:true,
                showSecond: false,
                minView: 2,
                format: 'yyyy-mm-dd',
                endDate: new Date(),
         });  
        
  jQuery('#edate').change(function() {
            var diff = dateDiff($('#sdate').datetimepicker({ dateFormat: 'yyyy-mm-dd' }).val(),
                    $('#edate').datetimepicker({ dateFormat: 'yyyy-mm-dd' }).val());
         });
 
 
   jQuery('#sdate').change(function() {
            var diff = dateDiff($('#sdate').datetimepicker({ dateFormat: 'yyyy-mm-dd' }).val(),
                    $('#edate').datetimepicker({ dateFormat: 'yyyy-mm-dd' }).val());
         }); 
 });


</script>
<script>
 
function dateDiff(startDate, endDate) {
      
      var startDate = new Date(startDate);
     var endDate = new Date(endDate);

if(Date.parse(endDate) < Date.parse(startDate)){
   alert("Invalid Date Range, Total Days cannot be less than 0");
   jQuery('#edate').val('');
   return false;      
}
   
}
                               
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
     var pb = ['<?=lang('cash')?>', '<?=lang('CC')?>', '<?=lang('Cheque')?>', '<?=lang('paypal_pro')?>', '<?=lang('stripe')?>', '<?=lang('gift_card')?>'];

        function paid_by(x) {
            if (x == 'cash') {
                return pb[0];
            } else if (x == 'CC') {
                return pb[1];
            } else if (x == 'Cheque') {
                return pb[2];
            } else if (x == 'ppp') {
                return pb[3];
            } else if (x == 'stripe') {
                return pb[4];
            } else if (x == 'gift_card') {
                return pb[5];
            } else {
                return x;
            }
        }

        function ref(x) {
            return (x != null) ? x : ' ';
        }
    
    var oTable = $('#period_set-tbl').dataTable({
        
        "aaSorting": [[0, "desc"]],
            "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "<?= lang('all') ?>"]],
            "iDisplayLength": <?= $Settings->rows_per_page ?>,
            'bProcessing': false, 'bServerSide': false,'bDestroy': true,
            'sAjaxSource': '<?= site_url('reports/getPeriodPayments/?v=1' . $v) ?>', //reports/getPeriodPayments/?v=1
            'fnServerData': function (sSource, aoData, fnCallback) {
                aoData.push({
                    "name": "<?= $this->security->get_csrf_token_name() ?>",
                    "value": "<?= $this->security->get_csrf_hash() ?>",
                    "name": "date",
                    "value": sdate+'|'+edate 
                });
                $.ajax({'dataType': 'json', 'type': 'POST', 'url': sSource, 'data': aoData, 'success': fnCallback});
            },
            "aoColumns": [{"mRender": fld}, null, {"mRender": ref}, {"mRender": ref}, {"mRender": paid_by}, {"mRender": currencyFormat}, {"mRender": row_status}],
            'fnRowCallback': function (nRow, aData, iDisplayIndex) {
                var oSettings = oTable.fnSettings();
            return nRow;
            },
        });
            
   
});


</script>
<script>
$(document).ready(function () {
   var pb = ['<?=lang('cash')?>', '<?=lang('CC')?>', '<?=lang('Cheque')?>', '<?=lang('paypal_pro')?>', '<?=lang('stripe')?>', '<?=lang('gift_card')?>'];

        function paid_by(x) {
            if (x == 'cash') {
                return pb[0];
            } else if (x == 'CC') {
                return pb[1];
            } else if (x == 'Cheque') {
                return pb[2];
            } else if (x == 'ppp') {
                return pb[3];
            } else if (x == 'stripe') {
                return pb[4];
            } else if (x == 'gift_card') {
                return pb[5];
            } else {
                return x;
            }
        }

        function ref(x) {
            return (x != null) ? x : ' ';
        }

        var oTable = $('#month-tbl').dataTable({
            "aaSorting": [[0, "desc"]],
            "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "<?= lang('all') ?>"]],
            "iDisplayLength": <?= $Settings->rows_per_page ?>,
            'bProcessing': false, 'bServerSide': false,'bDestroy': true,
            
            'sAjaxSource': '<?= site_url('reports/getCurrentMonthPayments/?v=1' . $v) ?>',
            'fnServerData': function (sSource, aoData, fnCallback) {
                aoData.push({
                    "name": "<?= $this->security->get_csrf_token_name() ?>",
                    "value": "<?= $this->security->get_csrf_hash() ?>"
                });
                $.ajax({'dataType': 'json', 'type': 'POST', 'url': sSource, 'data': aoData, 'success': fnCallback});
                //console.log(JSON.stringify(aoData));
            },
            
            'fnRowCallback': function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
            //console.log(aData);
                var oSettings = oTable.fnSettings();
                   return nRow;
            },
            "aoColumns": [{"mRender": fld}, null, {"mRender": ref}, {"mRender": ref}, {"mRender": paid_by}, {"mRender": currencyFormat}, {"mRender": row_status}],
            
            
        });

    });

</script>
<script>
  
$(document).ready(function () {
      
      
        var pb = ['<?=lang('cash')?>', '<?=lang('CC')?>', '<?=lang('Cheque')?>', '<?=lang('paypal_pro')?>', '<?=lang('stripe')?>', '<?=lang('gift_card')?>'];

        function paid_by(x) {
            if (x == 'cash') {
                return pb[0];
            } else if (x == 'CC') {
                return pb[1];
            } else if (x == 'Cheque') {
                return pb[2];
            } else if (x == 'ppp') {
                return pb[3];
            } else if (x == 'stripe') {
                return pb[4];
            } else if (x == 'gift_card') {
                return pb[5];
            } else {
                return x;
            }
        }

        function ref(x) {
            return (x != null) ? x : ' ';
        }

        var oTable = $('#today-tbl').dataTable({
            "aaSorting": [[0, "desc"]],
            "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "<?= lang('all') ?>"]],
            "iDisplayLength": <?= $Settings->rows_per_page ?>,
            'bProcessing': false, 'bServerSide': false,'bDestroy': true,
            'sAjaxSource': '<?= site_url('reports/getTodayPayments/?v=1' . $v) ?>',
            'fnServerData': function (sSource, aoData, fnCallback) {
                aoData.push({
                    "name": "<?= $this->security->get_csrf_token_name() ?>",
                    "value": "<?= $this->security->get_csrf_hash() ?>"
                });
                $.ajax({'dataType': 'json', 'type': 'POST', 'url': sSource, 'data': aoData, 'success': fnCallback});
            },
            "aoColumns": [{"mRender": fld}, null, {"mRender": ref}, {"mRender": ref}, {"mRender": paid_by}, {"mRender": currencyFormat}, {"mRender": row_status}],
            'fnRowCallback': function (nRow, aData, iDisplayIndex) {
                var oSettings = oTable.fnSettings();
                
                return nRow;
            },
            
        });

    });

</script>
<script>
$('#b2').on('click',function(event){
    event.preventDefault();
    if (jQuery("#ydate").val() == '') {
           alert('Please select year'); 
           $('#ydate').focus();
           return false;
        }
     var ydate = $("#ydate").val(); 
                    
     var pb = ['<?=lang('cash')?>', '<?=lang('CC')?>', '<?=lang('Cheque')?>', '<?=lang('paypal_pro')?>', '<?=lang('stripe')?>', '<?=lang('gift_card')?>'];

        function paid_by(x) {
            if (x == 'cash') {
                return pb[0];
            } else if (x == 'CC') {
                return pb[1];
            } else if (x == 'Cheque') {
                return pb[2];
            } else if (x == 'ppp') {
                return pb[3];
            } else if (x == 'stripe') {
                return pb[4];
            } else if (x == 'gift_card') {
                return pb[5];
            } else {
                return x;
            }
        }

        function ref(x) {
            return (x != null) ? x : ' ';
        }
    
    var oTable = $('#ytd_sale-tbl').dataTable({
            "aaSorting": [[0, "desc"]],
            "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "<?= lang('all') ?>"]],
            "iDisplayLength": <?= $Settings->rows_per_page ?>,
            'bProcessing': false, 'bServerSide': false,'bDestroy': true,
            'sAjaxSource': '<?= site_url('reports/getytdPayments/' . $v) ?>', //reports/getPeriodPayments/?v=1
            'fnServerData': function (sSource, aoData, fnCallback) {
                aoData.push({
                    "name": "<?= $this->security->get_csrf_token_name() ?>",
                    "value": "<?= $this->security->get_csrf_hash() ?>",
                    "name": "year",
                    "value": ydate
                });
                $.ajax({'dataType': 'json', 'type': 'POST', 'url': sSource, 'data': aoData, 'success': fnCallback});
            },
            "aoColumns": [{"mRender": fld}, null, {"mRender": ref}, {"mRender": ref}, {"mRender": paid_by}, {"mRender": currencyFormat}, {"mRender": row_status}],
            'fnRowCallback': function (nRow, aData, iDisplayIndex) {
                var oSettings = oTable.fnSettings();
                
                return nRow;
            },
            
        });
   
});
</script>  