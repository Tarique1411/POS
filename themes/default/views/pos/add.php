<!DOCTYPE html>
<html>
    <head>   
        <meta charset="utf-8">
        <title><?= lang('pos_module') . '|'. $Settings->site_name; ?></title>
        <script type="text/javascript">if (parent.frames.length !== 0) {
                top.location = '<?=site_url('pos') ?>';
            }</script>
        <meta http-equiv="cache-control" content="max-age=0"/>
        <meta http-equiv="cache-control" content="no-cache"/>
        <meta http-equiv="expires" content="0"/>
        <meta http-equiv="pragma" content="no-cache"/>
        <link rel="shortcut icon" href="<?= $assets ?>images/icon.png"/>
        <link rel="stylesheet" href="<?= $assets ?>styles/theme.css" type="text/css"/>
        <link rel="stylesheet" href="<?= $assets ?>styles/style.css" type="text/css"/>
        <link rel="stylesheet" href="<?= $assets ?>styles/bootstrap-glyphicons.css" type="text/css"/>
        <link rel="stylesheet" href="<?= $assets ?>pos/css/posajax.css" type="text/css"/>
        <link rel="stylesheet" href="<?= $assets ?>pos/css/print.css" type="text/css" media="print"/>
        <style>
            form label.error {  
                display:inline-block;
                font:14px Tahoma,sans-serif;
                color:red;
                margin-left:5px 
            } 
            .ui-keyboard-preview{
                display: none;
                height: 0px !important;
                border:none !important;
            }    
            .ui-keyboard-preview-wrapper{
                height: 0px !important;
            }        
            .select2-container .select2-selection {
                height: 60px;
                overflow: hidden;
            } 
            .pos-logo-sm {
                width: 100% !important;
                font-size: 16px !important;
            }
        </style>

        
        <script type="text/javascript" src="<?= $assets ?>pos/js/keyboard/jquery-latest.min.js"></script>
        <script type="text/javascript" src="<?= $assets ?>pos/js/keyboard/jquery-migrate-3.0.0.min.js"></script>
        <script type="text/javascript" src="<?= $assets ?>js/jquery-ui.min.js"></script>      
        <!-- keyboard -->
        <script type="text/javascript" src="<?= $assets ?>js/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?= $assets ?>js/jquery.validate.js"></script>
        <script type="text/javascript" src="<?= $assets ?>js/perfect-scrollbar.min.js"></script>
        <script type="text/javascript" src="<?= $assets ?>js/select2.min.js"></script>
        <script type="text/javascript" src="<?= $assets ?>js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="<?= $assets ?>js/custom.js"></script>
        <script type="text/javascript" src="<?= $assets ?>js/jquery.calculator.min.js"></script>
<!--        <script type="text/javascript" src="<?= $assets ?>js/bootstrapValidator.min.js"></script>-->
        <script type="text/javascript" src="<?= $assets ?>pos/js/jquery.validate.min.js"></script>
        <script type="text/javascript" src="<?= $assets ?>js/additional-methods.min.js"></script>
        <script type="text/javascript" src="<?= $assets ?>js/validate_additional_methods.js"></script>
<!--        <script type="text/javascript" src="<?= $assets ?>pos/js/plugins.min.js"></script>-->
        <!--  <script type="text/javascript" src="<?= $assets ?>js/keyboard.js"></script> -->
        <script type="text/javascript" src="<?= $assets ?>pos/js/parse-track-data.js"></script>

    <!-- jQuery (required) & jQuery UI + theme (optional) -->
   
    <!-- still using jQuery v2.2.4 because Bootstrap doesn't support v3+ -->
    
    <!-- <script src="docs/js/jquery-migrate-3.0.0.min.js"></script> -->

    <!-- keyboard widget css & script (required) -->
    
    <script type="text/javascript" src="<?= $assets ?>pos/js/keyboard/jquery.keyboard.js"></script>
    <link href="<?= $assets ?>pos/js/keyboard/keyboard.css" rel="stylesheet">
    <!-- keyboard extensions (optional) -->
 
    <script type="text/javascript" src="<?= $assets ?>pos/js/keyboard/jquery.keyboard.extension-typing.js"></script>
    <script type="text/javascript" src="<?= $assets ?>pos/js/keyboard/jquery.keyboard.extension-autocomplete.js"></script>
    <script type="text/javascript" src="<?= $assets ?>pos/js/keyboard/jquery.keyboard.extension-caret.js"></script>


     
        <?php 
        
        if ($Settings->rtl) { ?>
            <link href="<?= $assets ?>styles/helpers/bootstrap-rtl.min.css" rel="stylesheet"/>
            <link href="<?= $assets ?>styles/style-rtl.css" rel="stylesheet"/>
            <script type="text/javascript">
                $(document).ready(function () {
                    
                    $('.pull-right, .pull-left').addClass('flip');                              
                });
            </script>
        <?php } ?>
    </head>
    <body>
        <noscript>
        <div class="global-site-notice noscript">
            <div class="notice-inner">
                <p><strong>JavaScript seems to be disabled in your browser.</strong><br>You must have JavaScript enabled in
                    your browser to utilize the functionality of this website.</p>
            </div>
        </div>
        </noscript>

        <div id="wrapper">
            <header id="header" class="navbar">
                <div class="container">
                    <?php if (!$Sales) { ?>
                        <a class="navbar-brand" href="<?= site_url() ?>"><span class="logo"><span class="pos-logo-lg"><?= $Settings->site_name ?></span><span class="pos-logo-sm"><?= lang('pos') ?></span></span></a>  <?php } else { ?>
                        <a class="navbar-brand" href="pos"><span class="logo"><span class="pos-logo-lg"><?= $Settings->site_name ?></span><span class="pos-logo-sm"><?= $Settings->site_name ?></span></span></a> <?php } ?>

                    <div class="header-nav">
                        <ul class="nav navbar-nav pull-right">
                            <li class="dropdown">
                            <!--Snow last login of user Add By Ankit according swatch update-->
                                <?php //echo " <span class='hidden-sm'>( " . lang('last_login_at') . ": " . date($dateFormats['php_ldate'], $this->session->userdata('old_last_login')) . " ) </span>" ?>                            
                                <a class="btn account dropdown-toggle" data-toggle="dropdown" href="#">
                                    <!--<img alt="" src="<?= $this->session->userdata('avatar') ? site_url() . 'assets/uploads/avatars/thumbs/' . $this->session->userdata('avatar') : $assets . 'images/' . $this->session->userdata('gender') . '.png'; ?>" class="mini_avatar img-rounded">-->
                                    <div class="user">
                                        <span><?= lang('welcome') ?>! <?= $this->session->userdata('username'); ?></span>
                                    </div>                                   
                                </a>
                                
                                <ul class="dropdown-menu pull-right">
                                    <li>
                                        <a href="<?= site_url('auth/profile/' . $this->session->userdata('user_id')); ?>">
                                            <i class="fa fa-user"></i> <?= lang('profile'); ?>
                                        </a>
                                    </li>
<!--                                    <li>
                                        <a href="<?= site_url('auth/profile/' . $this->session->userdata('user_id') . '/#cpassword'); ?>">
                                            <i class="fa fa-key"></i> <?= lang('change_password'); ?>
                                        </a>
                                    </li>-->
                                    <li class="divider"></li>
                                    <li>
                                        <a id="user_logout" href="<?= site_url('auth/logout'); ?>">
                                            <i class="fa fa-sign-out"></i> <?= lang('logout'); ?>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
            <!-- *****Permissions Modified By Anil 01-10-2016
                                            For Owners and Others Start***** -->            
                        <ul class="nav navbar-nav pull-right">
                            <?php if ($Owner) { ?>
                                <li class="dropdown">
                                    <a class="btn bblue pos-tip" title="<?= lang('dashboard') ?>" data-placement="left" href="<?= site_url('welcome') ?>">
                                        <i class="fa fa-dashboard"></i>
                                    </a> 
                                </li>
                                <li class="dropdown hidden-sm">
                                    <a class="btn pos-tip" title="<?= lang('settings') ?>" data-placement="left" href="<?= site_url('pos/settings') ?>">
                                        <i class="fa fa-cogs"></i>
                                    </a>
                                </li>
                                <li class="dropdown hidden-xs">
                                    <a class="btn pos-tip" title="<?= lang('calculator') ?>" data-placement="left" href="#" data-toggle="dropdown">
                                        <i class="fa fa-calculator"></i>
                                    </a>
                                    <ul class="dropdown-menu pull-right calc">
                                        <li class="dropdown-content">
                                            <span id="inlineCalc"></span>
                                        </li>
                                    </ul>
                                </li>
                                <!--li class="dropdown hidden-sm">
                                    <a class="btn pos-tip" title="<?= lang('shortcuts') ?>" data-placement="left" href="#" data-toggle="modal" data-target="#sckModal">
                                        <i class="fa fa-key"></i>
                                    </a>
                                </li-->
                                                            <!---
                                <li class="dropdown">
                                    <a class="btn pos-tip" title="<?= lang('view_bill_screen') ?>" data-placement="bottom" href="<?= site_url('pos/view_bill') ?>" target="_blank">
                                        <i class="fa fa-laptop"></i>
                                    </a>
                                </li>
                                                            ---->
                                <li class="dropdown">
                                    <a class="btn blightOrange pos-tip" id="opened_bills" title="<?= lang('suspended_sales') ?>" data-placement="bottom" data-html="true" href="<?= site_url('pos/opened_bills') ?>" data-toggle="ajax">
                                        <i class="fa fa-th"></i>
                                    </a>
                                </li>
                                <li class="dropdown">
                                    <a class="btn bdarkGreen pos-tip" id="register_details" title="<?= lang('register_details') ?>" data-placement="bottom" data-html="true" href="<?= site_url('pos/store_register_details') ?>" data-toggle="modal" data-target="#myModal">
                                        <i class="fa fa-check-circle"></i>
                                    </a>
                                </li>
                                <li class="dropdown">
                                    <a class="btn borange pos-tip" id="close_register" title="<?= lang('close_register') ?>" data-placement="bottom" data-html="true" href="<?= site_url('pos/close_register') ?>" data-toggle="modal" data-target="#myModal">
                                        <i class="fa fa-times-circle"></i>
                                    </a>
                                </li>                          
                                <li class="dropdown">
                                    <a class="btn borange pos-tip" id="add_expense" title="<?= lang('add_expense') ?>" data-placement="bottom" data-html="true" href="<?= site_url('purchases/add_expense') ?>" data-toggle="modal" data-target="#myModal">
                                        <i class="fa fa-dollar"></i>
                                    </a>
                                </li>
                                <li class="dropdown">
                                    <a class="btn bdarkGreen pos-tip" id="today_profit" title="<?= lang('today_profit') ?>" data-placement="bottom" data-html="true" href="<?= site_url('reports/profit') ?>" data-toggle="modal" data-target="#myModal">
                                        <i class="fa fa-hourglass-half"></i>
                                    </a>
                                </li>
                                <li class="dropdown">
                                    <a class="btn bdarkGreen pos-tip" id="today_sale" title="<?= lang('today_sale') ?>" data-placement="bottom" data-html="true" href="<?= site_url('pos/today_sale') ?>" data-toggle="modal" data-target="#myModal">
                                        <i class="fa fa-heart"></i>
                                    </a>
                                </li>
                                <li class="dropdown hidden-xs">
                                    <a class="btn bblue pos-tip" title="<?= lang('list_open_registers') ?>" data-placement="bottom" href="<?= site_url('pos/registers') ?>">
                                        <i class="fa fa-list"></i>
                                    </a>
                                </li>
                                <li class="dropdown hidden-xs">
                                    <a class="btn bred pos-tip" title="<?= lang('clear_ls') ?>" data-placement="bottom" id="clearLS" href="#">
                                        <i class="fa fa-eraser"></i>
                                    </a>
                                </li>
                                <li class="hidden-xs">
                                    <a class="btn bdarkGreen pos-tip" id="accessories" title="<?= lang('FoC') ?>" 
                                       data-placement="bottom" data-html="true" href="<?= site_url('pos/accessories') ?>" data-toggle="modal" data-target="#myModal">
                                        <i class="fa fa-object-group" aria-hidden="true"></i>
                                    </a>
                                </li>
                                <li class="hidden-xs">
                                    <a class="btn blightGrey pos-tip" id="accessories" title="<?= lang('MRS') ?>" 
                                       data-placement="bottom" data-html="true" href="<?= site_url('pos/accessories?emrs=1') ?>" data-toggle="modal" data-target="#myModal">
                                        <i class="fa fa-object-group" aria-hidden="true"></i>
                                    </a>
                                </li>
                            <?php  } else { ?>
                                <?php ?>
                                <li class="dropdown">
                                    <a class="btn bblue pos-tip" title="<?= lang('dashboard') ?>" data-placement="left" href="<?= site_url('welcome') ?>">
                                        <i class="fa fa-dashboard"></i>
                                    </a> 
                                </li>
                                <?php if($Admin) { ?>
                                <li class="dropdown hidden-sm">
                                    <a class="btn pos-tip" title="<?= lang('settings') ?>" data-placement="left" href="<?= site_url('pos/settings') ?>">
                                        <i class="fa fa-cogs"></i>
                                    </a>
                                </li>
                                <?php }
                                if($GP['pos-tip_calc']) { ?>
                                <li class="dropdown hidden-xs">
                                    <a class="btn pos-tip" title="<?= lang('calculator') ?>" data-placement="left" href="#" data-toggle="dropdown">
                                        <i class="fa fa-calculator"></i>
                                    </a>
                                    <ul class="dropdown-menu pull-right calc">
                                        <li class="dropdown-content">
                                            <span id="inlineCalc"></span>
                                        </li>
                                    </ul>
                                </li>
                                <?php } ?>
                                <!--li class="dropdown hidden-sm">
                                    <a class="btn pos-tip" title="<?= lang('shortcuts') ?>" data-placement="left" href="#" data-toggle="modal" data-target="#sckModal">
                                        <i class="fa fa-key"></i>
                                    </a>
                                </li-->
                                                            <!---
                                <li class="dropdown">
                                    <a class="btn pos-tip" title="<?= lang('view_bill_screen') ?>" data-placement="bottom" href="<?= site_url('pos/view_bill') ?>" target="_blank">
                                        <i class="fa fa-laptop"></i>
                                    </a>
                                </li>
                                                           ---->
                            <?php if($GP['pos-tip_holdsale']) { ?> 
                                <li class="dropdown">
                                    <a class="btn blightOrange pos-tip" id="opened_bills" title="<?= lang('suspended_sales') ?>" data-placement="bottom" data-html="true" href="<?= site_url('pos/opened_bills') ?>" data-toggle="ajax">
                                        <i class="fa fa-th"></i>
                                    </a>
                                </li>
                                <?php }
                                if($GP['pos-tip_registerdetails']) { ?> 
                                <li class="dropdown">
                                    <a class="btn bdarkGreen pos-tip" id="register_details" title="<?= lang('register_details') ?>" data-placement="bottom" data-html="true" href="<?= site_url('pos/store_register_details') ?>" data-toggle="modal" data-target="#myModal">
                                        <i class="fa fa-check-circle"></i>
                                    </a>
                                </li>

                                <?php }
                                if($GP['pos-tip_closeregister']) { ?> 
                                <li class="dropdown">
                                    <a class="btn borange pos-tip" id="close_register" title="<?= lang('close_register') ?>" data-placement="bottom" data-html="true" href="<?= site_url('pos/close_register') ?>" data-toggle="modal" data-target="#myModal">
                                        <i class="fa fa-times-circle"></i>
                                    </a>
                                </li>   
                                <?php }
                                if($GP['pos-tip_addexpense']) { ?> 
                                <li class="dropdown">
                                    <a class="btn borange pos-tip" id="add_expense" title="<?= lang('add_expense') ?>" data-placement="bottom" data-html="true" href="<?= site_url('purchases/add_expense') ?>" data-toggle="modal" data-target="#myModal">
                                        <i class="fa fa-rupee"></i>
                                    </a>
                                </li>
                                <?php }
                                if($GP['pos-tip_todayprofit']) { ?> 

                                <li class="dropdown">
                                    <a class="btn bdarkGreen pos-tip" id="today_profit" title="<?= lang('today_profit') ?>" data-placement="bottom" data-html="true" href="<?= site_url('reports/profit') ?>" data-toggle="modal" data-target="#myModal">
                                        <i class="fa fa-hourglass-half"></i>
                                    </a>
                                </li>
                                <?php }
                                if($GP['pos-tip_todaysale']) { ?> 
                                <li class="dropdown">
                                    <a class="btn bdarkGreen pos-tip" id="today_sale" title="<?= lang('today_sale') ?>" data-placement="bottom" data-html="true" href="<?= site_url('pos/today_sale') ?>" data-toggle="modal" data-target="#myModal">
                                        <i class="fa fa-heart"></i>
                                    </a>
                                </li>
                                <?php }
                                if($GP['pos-tip_openregister']) { ?>
                                <li class="dropdown hidden-xs">
                                    <a class="btn bblue pos-tip" title="<?= lang('list_open_registers') ?>" data-placement="bottom" href="<?= site_url('pos/registers') ?>">
                                        <i class="fa fa-list"></i>
                                    </a>
                                </li>

                                <?php }
                                if($GP['pos-tip_cleardata']) { ?>

                                <li class="dropdown hidden-xs">
                                    <a class="btn bred pos-tip" title="<?= lang('clear_ls') ?>" data-placement="bottom" id="clearLS" href="#">
                                        <i class="fa fa-eraser"></i>
                                    </a>
                                </li>

                                <?php }
                                if($GP['pos-tip_accessories']) { ?>
                                <li class="hidden-xs">
                                    <a class="btn bdarkGreen pos-tip" id="accessories" title="<?= lang('FoC') ?>" 
                                       data-placement="bottom" data-html="true" href="<?= site_url('pos/accessories') ?>" data-toggle="modal" data-target="#myModal">
                                        <i class="fa fa-object-group" aria-hidden="true"></i>
                                    </a>
                                </li>
                                  <li class="hidden-xs">
                                    <a class="btn blightOrange pos-tip" id="accessories" title="<?= lang('MRS') ?>" 
                                       data-placement="bottom" data-html="true" href="<?= site_url('pos/accessories?emrs=1') ?>" data-toggle="modal" data-target="#myModal">
                                        <i class="fa fa-object-group" aria-hidden="true"></i>
                                    </a>
                                </li>
                                <?php } ?>
                            <?php } ?>    
                        </ul>
                        <!-- *****Permissions Modified By Anil 01-10-2016
                                            For Owners and Others End ***** --> 
                        <ul class="nav navbar-nav pull-right">
                            <li class="dropdown">
                                <a class="btn bblack" style="cursor: default;"><span id="display_time"></span></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </header>
            
            <div id="content">
                <div class="c1">
                    <div class="pos">
                        <?php $cv_error = $this->session->flashdata('empty_credit_voucher'); 
                            if(!empty($cv_error)){
                                echo '<div class="alert alert-danger">
                                    <a href="#" class="close fa-2x" data-dismiss="alert" aria-label="close">&times;</a>
                                        '.$cv_error.'
                                </div>';                                
                            }
                            
                            $cc_error = $this->session->flashdata('empty_credit_card'); 
                            if(!empty($cc_error)){
                                echo '<div class="alert alert-danger">
                                    <a href="#" class="close fa-2x" data-dismiss="alert" aria-label="close">&times;</a>
                                        '.$cc_error.'
                                </div>';                                
                                                        }else if(!empty($this->session->flashdata('credit_card_length'))){
                                                            echo '<div class="alert alert-danger">
                                    <a href="#" class="close fa-2x" data-dismiss="alert" aria-label="close">&times;</a>
                                        '.$this->session->flashdata('credit_card_length').'
                                </div>';        
                                                        }
                            
                            $cc_app_error = $this->session->flashdata('empty_approval_number'); 
                            if(!empty($cc_app_error)){
                                echo '<div class="alert alert-danger">
                                    <a href="#" class="close fa-2x" data-dismiss="alert" aria-label="close">&times;</a>
                                        '.$cc_app_error.'
                                </div>';                                
                            }
                        
                            if ($error) {
                                echo "<div class=\"alert alert-danger\"><button type=\"button\" class=\"close fa-2x\" data-dismiss=\"alert\">&times;</button>" . $error . "</div>";
                            }
                        ?>
                        <?php
                        if ($message) {
                            echo "<div class=\"alert alert-success\"><button type=\"button\" class=\"close fa-2x\" data-dismiss=\"alert\">&times;</button>" . $message . "</div>";
                        }
                        ?>
                        <div id="pos">
                            <?php
                            $attrib = array('data-toggle' => 'validator', 'role' => 'form', 'id' => 'pos-sale-form');
                            echo form_open("pos", $attrib);
                            ?>
                            <div id="leftdiv">
                                <div id="printhead">
                                    <h4 style="text-transform:uppercase;"><?php echo $Settings->site_name; ?></h4>
                                    <?php
                                    echo "<h5 style=\"text-transform:uppercase;\">" . $this->lang->line('order_list') . "</h5>";
                                    echo $this->lang->line("date") . " " . $this->sma->hrld(date('Y-m-d H:i:s'));
                                    ?>
                                </div>
                                <div id="left-top">
                                    <div
                                        style="position: absolute; <?= $Settings->rtl ? 'right:-9999px;' : 'left:-9999px;'; ?>"><?php echo form_input('test', '', 'id="test" class="kb-pad"'); ?></div>
                                    <div class="form-group">
                                        <?php if ($Owner || $Admin || $GP['customers-add']) { ?><div class="input-group" style="width: 100%"><?php } ?>
                                        <?php
                                       $cust = !empty($_POST['customer']) ? $_POST['customer'] : $customer->name; 
                                     
                                        echo form_input('customer',$cust, 'id="poscustomer" data-placeholder="' . $this->lang->line("select") . ' ' . $this->lang->line("customer") . '" required="required" class="form-control pos-input-tip kb-text" style="width:100%;"');
                                        ?>
                                        <?php if ($Owner || $Admin || $GP['customers-add']) { ?>
                                            
                                                <div class="input-group-addon no-print" style="padding: 2px 5px;">
                                                    <a href="<?= site_url('customers/add'); ?>" id="add-customer" class="external" data-toggle="modal" data-target="#myModal">
                                                        <i class="fa fa-2x fa-plus-circle" id="addIcon"></i>
                                                    </a>
                                                </div>
                                            
                                            </div>
                                        <?php } ?>
                                        <div style="clear:both;"></div>
                                    </div>
                                    <div class="no-print">
                                        <?php if ($Owner || $Admin) { ?>
                                            <div class="form-group">
                                                <?php
                                                $wh[''] = '';
                                                foreach ($warehouses as $warehouse) {
                                                    $wh[$warehouse->id] = $warehouse->name;
                                                }
                                                echo form_dropdown('warehouse', $wh, (isset($_POST['warehouse']) ? $_POST['warehouse'] : $Settings->default_warehouse), 'id="poswarehouse" class="form-control pos-input-tip" data-placeholder="' . $this->lang->line("select") . ' ' . $this->lang->line("warehouse") . '" required="required" style="width:100%;" ');
                                                ?>
                                            </div>
                                            <?php
                                        } else {
                                            $warehouse_input = array(
                                                'type' => 'hidden',
                                                'name' => 'warehouse',
                                                'id' => 'poswarehouse',
                                                'value' => $this->session->userdata('warehouse_id'),
                                            );
                                            echo form_input($warehouse_input);
                                        }
                                        ?>
                                        <div class="form-group" id="ui">
                                            <?php if ($Owner || $Admin || $GP['products-add']) { ?><div class="input-group" style="width: 100%"><?php } ?>
                                            <?php  echo form_input('add_item', '', 'class="form-control pos-tip kb-text" id="add_item" data-placement="top" data-trigger="focus" placeholder="' . $this->lang->line("search_product_by_name_code") . '" title="' . $this->lang->line("au_pr_name_tip") . '"'); ?>

                                            
                                            <?php if ($Owner || $Admin || $GP['products-add']) { ?>
                                                    <div class="input-group-addon" style="padding: 2px 5px;">

                                                        <!-- removed product add -->
                                                        <!--  <a href="#" id="addManually">
                                                           <i class="fa fa-2x fa-plus-circle" id="addIcon"></i>
                                                       </a> -->
                                                    </div>
                                                </div>
                                            <?php } ?>
                                            <div style="clear:both;"></div>
                                        </div>
                                    </div>
                                </div>
                                <div id="print">
                                    <div id="left-middle">
                                        <div id="product-list">
                                            <table class="table items table-striped table-bordered table-condensed table-hover"
                                                   id="posTable" style="margin-bottom: 0;width:100%;">
                                                <thead>
                                                    <tr>
                                                        <th width="40%"><?= lang("reference_no"); ?></th>
                                                        <th width="10%"><?= lang("mrp"); ?>&nbsp;<span class="rupee">&#8377;</span></th>
                                                        <th width="10%"><?= lang("basic").' '.lang("price"); ?>&nbsp;<span class="rupee">&#8377;</span></th>
                                                        <th width="10%"><?= lang("qty"); ?></th>
                                                        <!-- <th width="15%"><?= lang("tax"); ?>&nbsp;</th> -->
                                                        <th width="15%"><?= lang("sgst"); ?>&nbsp;</th>
                                                        <th width="15%"><?= lang("cgst"); ?>&nbsp;</th>
                                                        <th width="10%"><?= lang("discount"); ?>&nbsp;</th>
                                                        <th width="15%"><?= lang("subtotal"); ?>&nbsp;<span class="rupee">&#8377;</span></th>
                                                        <th style="width: 10%; text-align: center;"><i class="fa fa-trash-o"
                                                                                                      style="opacity:0.5; filter:alpha(opacity=50);"></i>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                            <div style="clear:both;"></div>
                                        </div>
                                    </div>
                                    <div style="clear:both;"></div>
                                    <div id="left-bottom">
                                        <table id="totalTable"
                                               style="width:100%; float:right; padding:5px; color:#000; background: #FFF;">
                                            <tr>
                                                <td style="padding: 5px 10px;"><?= lang('items'); ?></td>
                                                <td class="text-right" style="padding: 5px 10px;font-size: 14px; font-weight:bold;">
                                                    <span id="titems">0</span>
                                                </td>
                                                <td style="padding: 5px 10px;"><?= lang('total'); ?>&nbsp;<span class="rupee">&#8377;</span></td>
                                                <td class="text-right" style="padding: 5px 10px;font-size: 14px; font-weight:bold;">
                                                    <span id="total">0.00</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding: 5px 10px;"><!--<?= lang('order_tax'); ?>
                                                    <a href="#" id="pptax2">
                                                        <i class="fa fa-edit"></i>
                                                    </a>-->
                                                </td>
                                                <td class="text-right" style="padding: 5px 10px;font-size: 14px; font-weight:bold;">
                                                    <!--<span id="ttax2"></span>-->
                                                </td>
                                                <td style="padding: 5px 10px;"><?= lang('discount'); ?>&nbsp;<span class="rupee">&#8377;</span>
                                                    <!--a href="#" id="ppdiscount">
                                                        <i class="fa fa-edit"></i>
                                                    </a-->
                                                </td>
                                                <td class="text-right" style="padding: 5px 10px;font-weight:bold;">
                                                    <span id="tds">0.00</span>
                                                </td>
                                            </tr>

                                            <tr>
<!--                                                <td style="padding: 5px 10px;" id="tt_discount_label"><?= lang('discount_reason'); ?>

                                                </td>
                                                <td class="text-right" style="padding: 5px 10px;font-size: 14px; font-weight:bold;">
                                                    <span id="tt_discount_reason"></span>
                                                </td>-->

                                            </tr>

                                            <tr>
                                                <td style="padding: 5px 10px; border-top: 1px solid #666; font-weight:bold; background:#333; color:#FFF;" colspan="2">
                                                    <?= lang('total_payable'); ?>&nbsp;<span class="rupee">&#8377;</span>
                                                </td>
                                                <td class="text-right" style="padding:5px 10px 5px 10px; font-size: 14px;border-top: 1px solid #666; font-weight:bold; background:#333; color:#FFF;" colspan="2">
                                                    <span id="gtotal">0.00</span>
                                                </td>
                                            </tr>
                                        </table>

                                        <div class="clearfix"></div>
                                        <div id="botbuttons" style="text-align:center;">
                                            <input type="hidden" name="biller" id="biller"
                                                   value="<?= ($Owner || $Admin) ? $pos_settings->default_biller : $this->session->userdata('biller_id') ?>"/>
                                            <input type="hidden" name="sales_executives" id="sales_executives"
                                                   value="<?= ($Owner || $Admin) ? $pos_settings->default_biller : $this->session->userdata('user_id') ?>"/>
                                            <div class="btn-group btn-group-justified">
                                                <div class="btn-group">
                                                    <div class="btn-group btn-group-justified">
                                                        <div class="btn-group">
                                                            <button type="button" class="btn btn-danger"
                                                                    id="reset"><?= lang('discard'); ?></button>
                                                        </div>
                                                        <div class="btn-group">
                                                            <button type="button" class="btn btn-warning"
                                                                    id="suspend"><?= lang('hold'); ?></button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!--<div class="btn-group">
                                                    <div class="btn-group btn-group-justified">
                                                        <div class="btn-group">
                                                            <button type="button" class="btn btn-primary" id="print_order">
                                                                <i class="fa fa-print"></i> <?= lang('order'); ?>
                                                            </button>
                                                        </div>
                                                        <div class="btn-group">
                                                            <button type="button" class="btn btn-primary" id="print_bill">
                                                                <i class="fa fa-print"></i> <?= lang('bill'); ?>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>  -->
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-success" id="payment">
                                                        <i class="fa fa-money"></i> <?= lang('payment'); ?>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div style="clear:both; height:5px;"></div>
                                        <div id="num">
                                            <div id="icon"></div>
                                        </div>
                                        <span id="hidesuspend"></span>
                                        <input type="hidden" name="pos_note" value="" id="pos_note">
                                        <!--
                                        <input type="hidden" name="staff_note" value="" id="staff_note">
                                        -->

                                        <div id="payment-con">
                                            <?php for ($i = 1; $i <= 25; $i++) { ?>
                                                <input type="hidden" name="amount[]" id="amount_val_<?= $i ?>" value=""/>
                                                <input type="hidden" name="balance_amount[]" id="balance_amount_<?= $i ?>" value=""/>
                                                <input type="hidden" name="paid_by[]" id="paid_by_val_<?= $i ?>" value="cash"/>
                                                <input type="hidden" name="cc_no[]" id="cc_no_val_<?= $i ?>" value=""/>
                                                <input type="hidden" name="paying_gift_card_no[]" id="paying_gift_card_no_val_<?= $i ?>" value=""/>
                                                <input type="hidden" name="cc_nation[]" id="cc_nation_val_<?= $i ?>" value=""/>
                                                <input type="hidden" name="cc_edc[]" id="cc_edc_val_<?= $i ?>" value=""/>
                                                <input type="hidden" name="cc_holder[]" id="cc_holder_val_<?= $i ?>" value=""/>
                                                <input type="hidden" name="cheque_no[]" id="cheque_no_val_<?= $i ?>" value=""/>
                                                <input type="hidden" name="cc_month[]" id="cc_month_val_<?= $i ?>" value=""/>
                                                <input type="hidden" name="cc_year[]" id="cc_year_val_<?= $i ?>" value=""/>
                                                <input type="hidden" name="cc_type[]" id="cc_type_val_<?= $i ?>" value=""/>
                                                <input type="hidden" name="cc_card_type[]" id="cc_card_type_val_<?= $i ?>" value=""/>                     
                                                <input type="hidden" name="cc_cvv2[]" id="cc_cvv2_val_<?= $i ?>" value=""/>
                                                <input type="hidden" name="payment_note[]" id="payment_note_val_<?= $i ?>" value=""/>
                                                <input type="hidden" name="cn_balance[]" id="cn_balance_val_<?= $i ?>" value=""/>
                                            <?php } ?>
                                        </div>
                                        
                                        <input name="order_tax" type="hidden" value="<?= $suspend_sale ? $suspend_sale->order_tax_id : $Settings->default_tax_rate2; ?>" id="postax2">
                                        <input name="discount" type="hidden" value="" id="posdiscount">
                                        <input name="discount_per" type="hidden" value="" id="posdiscountper">
                                        <input name="discount_reason" type="hidden" value="" id="posdiscountreason">
                                        <input name="discount_percent" type="hidden" value="<?= !empty($user->show_discount)? $user->show_discount : 0 ?>" id="discout_percent">
                                        <input name="discount_type" type="hidden" value="<?=$pos_settings->discount_type ?>" id="pos_discount_type" />
                                        <input name="order_discount_type" type="hidden" value="<?= $pos_settings->order_discount_type ?>" id="pos_order_discount_type" />
                                        <input name="max_invoice_discount" type="hidden" value="<?= $max_discount ?>" id="max_invoice_discount">
                                        <input name="pan_number_hidden" type="hidden" value="" id="pan_number_hidden">
                                        <input name="max_pan_limit" type="hidden" value="<?= $pos_settings->max_pan_limit ?>" id="max_pan_limit">
                                        <input name="group_of_user" type="hidden" value="<?= $group_id ?>" id="group_of_user">
                                        <!--<input name="discount_percent" type="hidden" value="<?= $user->show_discount ? $user->show_discount : 0; ?>" id="discount_percent">-->
                                        <input type="hidden" name="rpaidby" id="rpaidby" value="cash" style="display: none;"/>
                                        <input type="hidden" name="total_items" id="total_items" value="0" style="display: none;"/>
                                        <input type="submit" id="submit_sale" value="Submit Sale" style="display: none;"/>
                                    </div>
                                </div>
                            </div>
                            <?php echo form_close(); ?>
                            
                            <div id="cp">
                                <div id="cpinner">
                                    <div class="quick-menu">
                                        <div id="proContainer">
                                            <div id="ajaxproducts">
                                                <div id="item-list">                                                   
                                                    <?php echo $products; ?>
                                                </div>
                                                <div class="btn-group btn-group-justified">
                                                    <div class="btn-group">
                                                        <button style="z-index:10002;" class="btn btn-primary pos-tip" title="<?= lang('previous') ?>" type="button" id="previous">
                                                            <i class="fa fa-chevron-left"></i>
                                                        </button>
                                                    </div>
                                                    <?php if ($Owner || $Admin || $GP['sales-add_gift_card']) { ?>
                                                        <!-- removed sell gift card option -->
                                                        <!-- <div class="btn-group">
                                                             <button style="z-index:10003;" class="btn btn-primary pos-tip" type="button" id="sellGiftCard" title="<?= lang('sell_gift_card') ?>">
                                                                 <i class="fa fa-credit-card" id="addIcon"></i> <?= lang('sell_gift_card') ?>
                                                             </button>
                                                         </div> -->
                                                    <?php } ?>
                                                    
                                                  <div class="btn-group">
                                                        <button style="z-index:10004;" class="btn btn-primary pos-tip" title="<?= lang('next') ?>" type="button" id="next">
                                                            <i class="fa fa-chevron-right"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div style="clear:both;"></div>
                                        </div>
                                    </div>
                                </div>
                                <div style="clear:both;"></div>
                            </div>
                        
                            <div style="clear:both;"></div>
                        </div>
                        <div style="clear:both;"></div>
                    </div>
                </div>
            </div>
        </div> 
        <div class="rotate btn-cat-con">
            <button type="button" id="open-subcategory" class="btn btn-warning open-subcategory">Subcategories</button>
            <button type="button" id="open-category" class="btn btn-primary open-category">Categories</button>
        </div>
        <div id="category-slider">
            <!--<button type="button" class="close open-category"><i class="fa fa-2x">&times;</i></button>-->
            <div id="category-list">
                <?php
                //for ($i = 1; $i <= 40; $i++) {
                foreach ($categories as $category) {
                    echo "<button id=\"category-" . $category->id . "\" type=\"button\" value='" . $category->id . "' class=\"btn-prni category\" ><img src=\"assets/uploads/thumbs/" . ($category->image ? $category->image : 'no_image.png') . "\" style='width:" . $this->Settings->twidth . "px;height:" . $this->Settings->theight . "px;' class='img-rounded img-thumbnail' /><span>" . $category->name . "</span></button>";
                }
                //}
                ?>
            </div>
        </div>
        <div id="subcategory-slider">
            <!--<button type="button" class="close open-category"><i class="fa fa-2x">&times;</i></button>-->
            <div id="subcategory-list">
                <?php
                if (!empty($subcategories)) {
                    foreach ($subcategories as $category) {
                        echo "<button id=\"subcategory-" . $category->id . "\" type=\"button\" value='" . $category->id . "' class=\"btn-prni subcategory\" ><img src=\"assets/uploads/thumbs/" . ($category->image ? $category->image : 'no_image.png') . "\" style='width:" . $this->Settings->twidth . "px;height:" . $this->Settings->theight . "px;' class='img-rounded img-thumbnail' /><span>" . $category->name . "</span></button>";
                    }
                }
                ?>
            </div>
        </div>
        
        
        
        <div class="modal fade in" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="payModalLabel"
             aria-hidden="true">
            <?php $attribs = array('role' => 'form', 'id' => 'pos-payment-form');
                    echo form_open("", $attribs);
                   ?>
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true"><i
                                    class="fa fa-2x">&times;</i></span><span class="sr-only"><?= lang('close'); ?></span></button>
                        <h4 class="modal-title" id="payModalLabel"><?= lang('finalize_sale'); ?></h4>
                    </div>
                    <div class="modal-body" id="payment_content">
                        <div class="row">
                            <div class="col-md-10 col-sm-9">
                                <div class="form-group">
                                    <?php if ($Owner || $Admin) { ?>                                    
                                        <?php
                                        foreach ($billers as $biller) {
                                            $bl[$biller->id] = $biller->company != '-' ? $biller->company : $biller->name;
                                        }
                                        echo form_dropdown('biller', $bl, (isset($_POST['biller']) ? $_POST['biller'] : $pos_settings->default_biller), 'class="form-control" id="posbiller" required="required"');
                                        ?>

                                        <?php
                                    } else {
                                        $biller_input = array(
                                            'type' => 'hidden',
                                            'name' => 'biller',
                                            'id' => 'posbiller',
                                            'value' => $this->session->userdata('biller_id'),
                                        );

                                        echo form_input($biller_input);
                                    }
                                    ?>
                                </div>
                                <?php if(!$Owner){ ?>
                                    <div class="form-group">
                                        <?php if (!empty($sales_executives)) { ?>

                                            <?= lang("sales_executives", "sales_executives"); ?>
                                            <?php
                                            $executives = array();
                                            //echo "<pre>";print_r($this->session->all_userdata()['user_id']);
                                            foreach ($sales_executives as $key => $val) {
                                                $executives[$val['id']] = $val['username'];
                                            }

                                            echo form_dropdown('sales_executives', $executives, (isset($_POST['sales_executives']) ? $_POST['sales_executives'] : $this->session->all_userdata()['user_id']), 'class="form-control" id="posexecutives" required="required"');
                                        }
                                        ?>

                                    </div>
                                <?php } ?>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <?= form_textarea('sale_note', '', 'id="sale_note" class="form-control kb-text skip" style="height: 100px;" placeholder="' . lang('sale_note') . '" maxlength="250"'); ?>
                                        </div>
                                        <!---
                                        <div class="col-sm-6">
                                        <?= form_textarea('staffnote', '', 'id="staffnote" class="form-control kb-text skip" style="height: 100px;" placeholder="' . lang('staff_note') . '" maxlength="250"'); ?>
                                        </div>
                                        ---->
                                    </div>
                                </div>
                                <div class="clearfir"></div>
                                    <div id="payments">
                                    <div class="well well-sm well_1">
                                        <div class="payment">
                                            <div class="row">
                                                <div class="col-sm-5">
                                                    <div class="form-group">
                                                        <?= lang("amount", "amount_1"); ?>&nbsp;<span class="rupee">&#8377;</span>
                                                        <input name="amountc[0]" type="text" id="amount_1"
                                                               class="pa form-control kb-pad amount" required="required"/>
                                                    </div>
                                                    
                                                </div>
                                                <div class="col-sm-5 col-sm-offset-1">
                                                    <div class="form-group">
                                                        <?= lang("paying_by", "paid_by_1"); ?>
                                                        <select name="paid_by[0]" id="paid_by_1" class="form-control paid_by">                              
                                                            <option value="ss"><?= lang("paid_placeholder"); ?></option>                            
                                                            <option value="cash"><?= lang("cash"); ?></option>                              
                                                            <option value="CC"><?= lang("cc"); ?></option>
                                                            <!---
                                                            <option value="Cheque"><?= lang("cheque"); ?></option>
                                                            ---->
                                                            <option value="credit_voucher"><?= lang("credit_voucher"); ?></option>
                                                            <?= $pos_settings->paypal_pro ? '<option value="ppp">' . lang("paypal_pro") . '</option>' : ''; ?>
                                                            <?= $pos_settings->stripe ? '<option value="stripe">' . lang("stripe") . '</option>' : ''; ?>
                                                           <!-- <option value="other"><?= lang("other"); ?></option> -->
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12">
<!--                                                    <div class="form-group gc_1">
                                                        <?= lang("Select Credit Note from list", "Select_Credit_Note_From_list"); ?>
                                                          <input name="multi_gc[0]" type="text kb-text" id="multi_gc_1"
                                                               class="form-control multi_gc"/>
                                                    </div>-->
                                                    <div class="form-group gc_1" style="display: none;">
                                                        <?= lang("Credit Note", "gift_card_no_1"); ?>
                                                        <input name="paying_gift_card_no[0]" type="text kb-text" id="gift_card_no_1"
                                                               class="pa form-control kb-text gift_card_no" required="required"/>

                                                        <div id="gc_details_1"></div>
                                                        <input type="hidden" name="cn_balance_1" id="cn_balance_1" value="">
                                                        <div style="color:red;display:none;" id="cv_error_msg_1"><p><?= lang('incorrect_gift_card') ?></p></div>
                                                        <div style="color:red;display:none;" id="cv_error_msg2_1"><p><?= lang('gift_card_not_for_customer') ?></p></div>
                                                    </div>
                                                   
                                                    <div class="pcc_1" style="display:none;">
                                                        <div class="form-group">
                                                            <input type="text" id="swipe_1" name="swipe[0]" class="form-control swipe"
                                                                   placeholder="<?= lang('swipe') ?>"/>
                                                        </div>
                        <div class="row">
                            <div class="col-md-5">
                                <div class="form-group">
                                    <input name="ccc_no[0]" type="text" id="pcc_no_1" class="form-control cc_number cardno kb-pad" 
                                                                           placeholder="<?= lang('cc_no') ?>" required="required"/>      
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <select name="ccard_type[0]" id="pcc_card_1" class="form-control">
                                        <option value=""><?= lang("credit_debit"); ?></option>
                                        <option value="CC"><?= lang("credit_card"); ?></option>
                                        <option value="DC"><?= lang("debit_card"); ?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <select name="ccard_nation[0]" id="pcc_nation_1" class="form-control">
                                        <option value=""><?= lang("card_nation"); ?></option>
                                        <option value="domestic"><?= lang("domestic"); ?></option>
                                        <option value="international"><?= lang("international"); ?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">

                                    <input name="ccc_holer[0]" type="text" id="pcc_holder_1"
                                           class="form-control kb-text" 
                                           placeholder="<?= lang('cc_holder') ?>"/>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <select name="ccc_type[0]" id="pcc_type_1"
                                            class="form-control pcc_type"
                                            placeholder="<?= lang('card_type') ?>">
                                        <option value=""><?= lang("select_card_type"); ?></option>
                                        <option value="Visa"><?= lang("Visa"); ?></option>
                                        <option value="MasterCard"><?= lang("MasterCard"); ?></option>    
                                        <option value="Maestro"><?= lang("Maestro"); ?></option>
                                        <option value="Rupay"><?= lang("Rupay"); ?></option>
                                        <option value="Amex"><?= lang("Amex"); ?></option>
                                        <option value="Diners"><?= lang("Diners"); ?></option>
                                    </select>
<!--                                     <input type="text" id="pcc_type_1" class="form-control pcc_type" placeholder="<?= lang('card_type') ?>" />-->
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <select name="ccc_edc[0]" id="pcc_edc_1"
                                            class="form-control pcc_edc"
                                            placeholder="<?= lang('card_edc') ?>">
                                        <option value=""><?= lang("select_edc"); ?></option>
                                        <option value="deutsche"><?= lang("DEUTSCHE"); ?></option>
                                        <option value="yes"><?= lang("YES"); ?></option>     
                                       
                                    </select>                                   
                                </div>
                            </div>
                            
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                            <input name="ccc_month[0]" type="text" id="pcc_month_1"
                                                                   class="form-control kb-pad"
                                                                   placeholder="<?= lang('month') ?>"/>
                                                        </div>
                                                        <label id="pcc_month_1-error" for="pcc_month_1"></label>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">

                                                            <input name="ccc_year[0]" type="text" id="pcc_year_1"
                                                                   class="form-control kb-pad"
                                                                   placeholder="<?= lang('year') ?>"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">

                                                            <input name="ccc_cvv2[0]" type="text" id="pcc_cvv2_1"
                                                                   class="form-control kb-pad"
                                                                 
                                                                   placeholder="<?= lang('cvv2') ?>"/>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="pcheque_1" style="display:none;">
                                                <div class="form-group"><?= lang("cheque_no", "cheque_no_1"); ?>
                                                    <input name="cheque_no[0]" type="text" id="cheque_no_1"
                                                           class="form-control cheque_no"/>
                                                </div>
                                            </div>
                                            <div class="form-group note">
                                                <?= lang('payment_note', 'payment_note'); ?>
                                                <textarea name="payment_note[0]" id="payment_note_1"
                                                          class="pa form-control kb-text payment_note"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="multi-payment"></div>
                        <button type="button" class="btn btn-primary col-md-12 addButton"><i
                                class="fa fa-plus"></i> <?= lang('add_more_payments') ?></button>
                        <div style="clear:both; height:15px;"></div>
                        <div class="font16">
                            <table class="table table-bordered table-condensed table-striped" style="margin-bottom: 0;">
                                <tbody>
                                    <tr>
                                        <td width="25%"><?= lang("total_items"); ?></td>
                                        <td width="25%" class="text-right"><span id="item_count">0.00</span></td>
                                        <td width="25%"><?= lang("total_payable"); ?>&nbsp;<span class="rupee">&#8377;</span></td>
                                        <td width="25%" class="text-right"><span id="twt">0.00</span></td>
                                    </tr>
                                    <tr>
                                        <td><?= lang("total_paying"); ?>&nbsp;<span class="rupee">&#8377;</span></td>
                                        <td class="text-right"><span id="total_paying">0.00</span></td>
                                        <td><?= lang("balance"); ?>&nbsp;<span class="rupee">&#8377;</span></td>
                                        <td class="text-right"><span id="balance">0.00</span></td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                            <div class="col-md-2 col-sm-3 text-center">
                                <span style="font-size: 1.2em; font-weight: bold;"><?= lang('quick_cash'); ?>&nbsp;<span class="rupee">&#8377;</span></span>

                                <div class="btn-group btn-group-vertical">
                                    <button type="button" class="btn btn-lg btn-info quick-cash" id="quick-payable">0.00
                                    </button>
                                    <?php
                                    foreach (lang('quick_cash_notes') as $cash_note_amount) {
                                        echo '<button type="button" class="btn btn-lg btn-warning quick-cash">' . $cash_note_amount . '</button>';
                                    }
                                    ?>
                                    <button type="button" class="btn btn-lg btn-danger"
                                            id="clear-cash-notes"><?= lang('clear'); ?></button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-block btn-lg btn-primary" type="submit" name="submit-sale" id="submit-sale"><?= lang('submit'); ?></button>
                    </div>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>

        <div class="modal" id="prModal" tabindex="-1" role="dialog" aria-labelledby="prModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true"><i
                                    class="fa fa-2x">&times;</i></span><span class="sr-only"><?= lang('close'); ?></span></button>
                        <h4 class="modal-title" id="prModalLabel"></h4>
                    </div>
                    <div class="modal-body" id="pr_popover_content">
<!--            <p class="noticeText"><?= lang('discount_%_or_flat'); ?></p>-->
                        <form class="form-horizontal" role="form">
                        <!-- Added by Chitra to add lot details from ajax request on load items.-->
                        <div class="col-sm-12 form-group" id="mlot"></div>
                         
                         <!--Added by Chitra to count real time quantity
                         <div class="col-sm-12 form-group" id="count_pr">
                            <input type = "text" name ="pr_count" id="pr_count" value=""/>
                         </div> -->
                            <?php if ($Settings->tax1) { ?>
                                <div class="form-group">
                                    <label class="col-sm-4 control-label"><?= lang('product_tax') ?>(%)</label>
                                    <div class="col-sm-8">
                                        <?php
                                        $tr[""] = "";
                                       /* foreach ($tax_rates as $tax) {
                                            $tr[$tax->id] = $tax->name;
                                        }

                                        if ($Owner || $Admin) {
                                            echo form_dropdown('ptax', $tr, "", 'id="ptax" class="form-control pos-input-tip" style="width:100%;" disabled="disabled"');
                                        } else {
                                            echo form_dropdown('ptax', $tr, "", 'id="ptax" class="form-control pos-input-tip" style="width:100%;" disabled="disabled"');
                                        }*/
                                        ?>
<input type="text" class="form-control" name="ptax" id="ptax" value="" />
                                    </div>
                                </div>
                            <?php } ?>
                            <?php // if ($Settings->product_serial) { ?>
<!--                                <div class="form-group">
                                    <label for="pserial" class="col-sm-4 control-label"><?= lang('serial_no') ?></label>

                                    <div class="col-sm-8">
                                        <input type="text" class="form-control kb-text" id="pserial">
                                    </div>
                                </div>-->
                            <?php // } ?>

                            <div class="form-group">
                                <label for="pquantity" class="col-sm-4 control-label"><?= lang('qtys') ?></label>

<!--                                <div class="col-sm-8">
                                    <input type="text" class="form-control kb-pad" id="pquantity" readonly="readonly" >
                                </div>-->
                               <div class="col-sm-8">
                                    <input type="text" class="form-control kb-pad" id="qty" readonly="readonly" value="1" >
                                </div>

                            </div>
                            <!---
                            <div class="form-group">
                                <label for="poption" class="col-sm-4 control-label"><?= lang('product_option') ?></label>

                                <div class="col-sm-8">
                                    <div id="poptions-div"></div>
                                </div>
                            </div>
                                                        -->
                            <?php if ($Settings->product_discount) { ?>
                                
                            <div class="form-group">    
                                <label class="col-sm-4 control-label"><?= lang('Discount_Type') ?></label>
                                <div class="col-sm-8">  
                                    <select class="form-control pos-input-tip pdiscount_type" data-item-id="" style="width:100%;" name="pdiscount_type" id="pdiscount_type">
                                        <option value="">--Select Discount--</option>
                                        <option value="product" selected>Product Discount</option>
                                        <option value="replacement" >Replacement Discount</option>
                                        <option value="promotions" >Promotions Discount</option>
<!--                                        <option value="employee" >Employee Discount</option>-->
                                    </select>
                                </div>
                            </div>
                            
                            <div class="form-group" id = "dsct_rsn">    
                                <label class="col-sm-4 control-label"><?= lang('Discount_Reason') ?></label>
                                <div class="col-sm-8">  
                                    <select class="form-control pos-input-tip" data-item-id="" style="width:100%;" name="pdiscount_reason" id="pdiscount_reason">
                               
                                    </select>
                                </div>
                            </div>
                                                        
                            <div class="form-group">
                                <label for="pdiscount" class="col-sm-4 control-label"><?= lang('discount_percent') ?></label>
                                <div class="col-sm-8">                                       
                                    <input type="text" class="form-control close_register_input product_discount" data-item-id="" name="pdiscount" id="pdiscount" maxlength="9" value="0%">
                                </div>
                            </div>
                            <?php } ?>
                            <div class="form-group">
                                <label for="pprice" class="col-sm-4 control-label"><?= lang('unit_price') ?></label>

                                <div class="col-sm-8">
                                    <input type="text" class="form-control kb-pad" id="pprice" readonly="readonly">
                                </div>

                                <input type="hidden" name="pcost" id="pcost" value="" />

                            </div>
                            <table class="table table-bordered table-striped">
                                <tr>
                                    <th style="width:25%;"><?= lang('basic_price'); ?></th>
                                    <th style="width:25%;"><span id="net_price"></span><input type="hidden" id="net_unit_price" value=''/></th>
                                    <th style="width:25%;"><?= lang('product_tax'); ?></th>
                                    <th style="width:25%;"><span id="pro_tax"></span></th>
                                </tr>
                            </table>
                            <input type="hidden" id="logged_in_discount" value="<?= !empty($logged_in_discount->show_discount) ? $logged_in_discount->show_discount: 0 ?>" name="logged_in_discount"/>
                            <input type="hidden" id="punit_max_discount" value=""/>
                            <input type="hidden" id="lot_no" value=""/>
                            <input type="hidden" id="lot_price" value=""/>
                            <input type="hidden" id="punit_price" value=""/>
                            <input type="hidden" id="old_tax" value=""/>
                            <input type="hidden" id="old_qty" value=""/>
                            <input type="hidden" id="old_price" value=""/>
                            <input type="hidden" id="row_id" value=""/>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="editItem"><?= lang('submit') ?></button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade in" id="gcModal" tabindex="-1" role="dialog" aria-labelledby="mModalLabel" aria-hidden="true">
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
                                <?php echo form_input('gccard_no', '', 'class="form-control" id="gccard_no"'); ?>
                                <div class="input-group-addon" style="padding-left: 10px; padding-right: 10px;">
                                    <a href="#" id="genNo"><i class="fa fa-cogs"></i></a>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="gcname" value="<?= lang('credit_voucher') ?>" id="gcname"/>

                        <div class="form-group">
                            <?= lang("value", "gcvalue"); ?> *
                            <?php echo form_input('gcvalue', '', 'class="form-control" id="gcvalue"'); ?>
                        </div>
                        <div class="form-group">
                            <?= lang("price", "gcprice"); ?> *
                            <?php echo form_input('gcprice', '', 'class="form-control" id="gcprice"'); ?>
                        </div>
                        <div class="form-group">
                            <?= lang("customer", "gccustomer"); ?>
                            <?php echo form_input('gccustomer', '', 'class="form-control" id="gccustomer"'); ?>
                        </div>
                        <div class="form-group">
                            <?= lang("expiry_date", "gcexpiry"); ?>
                            <?php echo form_input('gcexpiry', '', 'class="form-control date" id="gcexpiry"'); ?>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" id="addGiftCard" class="btn btn-primary"><?= lang('sell_gift_card') ?></button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade in" id="mModal" tabindex="-1" role="dialog" aria-labelledby="mModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true"><i
                                    class="fa fa-2x">&times;</i></span><span class="sr-only"><?= lang('close'); ?></span></button>
                        <h4 class="modal-title" id="mModalLabel"><?= lang('add_product_manually') ?></h4>
                    </div>
                    <div class="modal-body" id="pr_popover_content">
                        <form class="form-horizontal" role="form">
                            <div class="form-group">
                                <label for="mcode" class="col-sm-4 control-label"><?= lang('product_code') ?> *</label>

                                <div class="col-sm-8">
                                    <input type="text" class="form-control kb-text" id="mcode">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="mname" class="col-sm-4 control-label"><?= lang('product_name') ?> *</label>

                                <div class="col-sm-8">
                                    <input type="text" class="form-control kb-text" id="mname">
                                </div>
                            </div>
                            <?php if ($Settings->tax1) { ?>
                                <div class="form-group">
                                    <label for="mtax" class="col-sm-4 control-label"><?= lang('product_tax') ?> *</label>

                                    <div class="col-sm-8">
                                        <?php
                                        $tr[""] = "";
                                        foreach ($tax_rates as $tax) {
                                            $tr[$tax->id] = $tax->name;
                                        }
                                        echo form_dropdown('mtax', $tr, "", 'id="mtax" class="form-control pos-input-tip" style="width:100%;"');
                                        ?>
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="form-group">
                                <label for="mquantity" class="col-sm-4 control-label"><?= lang('quantity') ?> *</label>

                                <div class="col-sm-8">
                                    <input type="text" class="form-control kb-pad" id="mquantity">
                                </div>
                            </div>
                            <?php if ($Settings->product_discount) { ?>
                                <div class="form-group">
                                    <label for="mdiscount"
                                           class="col-sm-4 control-label"><?= lang('product_discount') ?></label>

                                    <div class="col-sm-8">
                                        <input type="text" class="form-control kb-pad" id="mdiscount">
                                    </div>
                                </div>
                            <?php } ?>
                            <div class="form-group">
                                <label for="mprice" class="col-sm-4 control-label"><?= lang('unit_price') ?> *</label>

                                <div class="col-sm-8">
                                    <input type="text" class="form-control kb-pad" id="mprice">
                                </div>
                            </div>
                            <table class="table table-bordered table-striped">
                                <tr>
                                    <th style="width:25%;"><?= lang('net_unit_price'); ?></th>
                                    <th style="width:25%;"><span id="mnet_price"></span></th>
                                    <th style="width:25%;"><?= lang('product_tax'); ?></th>
                                    <th style="width:25%;"><span id="mpro_tax"></span></th>
                                </tr>
                            </table>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" id="addItemManually"><?= lang('submit') ?></button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade in" id="sckModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true"><i
                                    class="fa fa-2x">&times;</i></span><span class="sr-only"><?= lang('close'); ?></span></button>
                        <h4 class="modal-title" id="mModalLabel"><?= lang('shortcut_keys') ?></h4>
                    </div>
                    <div class="modal-body" id="pr_popover_content">
                        <table class="table table-bordered table-striped table-condensed table-hover"
                               style="margin-bottom: 0px;">
                            <thead>
                                <tr>
                                    <th><?= lang('shortcut_keys') ?></th>
                                    <th><?= lang('actions') ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?= $pos_settings->focus_add_item ?></td>
                                    <td><?= lang('focus_add_item') ?></td>
                                </tr>
                                <tr>
                                    <td><?= $pos_settings->add_manual_product ?></td>
                                    <td><?= lang('add_manual_product') ?></td>
                                </tr>
                                <tr>
                                    <td><?= $pos_settings->customer_selection ?></td>
                                    <td><?= lang('customer_selection') ?></td>
                                </tr>
                                <tr>
                                    <td><?= $pos_settings->add_customer ?></td>
                                    <td><?= lang('add_customer') ?></td>
                                </tr>
                                <tr>
                                    <td><?= $pos_settings->toggle_category_slider ?></td>
                                    <td><?= lang('toggle_category_slider') ?></td>
                                </tr>
                                <tr>
                                    <td><?= $pos_settings->toggle_subcategory_slider ?></td>
                                    <td><?= lang('toggle_subcategory_slider') ?></td>
                                </tr>
                                <tr>
                                    <td><?= $pos_settings->cancel_sale ?></td>
                                    <td><?= lang('cancel_sale') ?></td>
                                </tr>
                                <tr>
                                    <td><?= $pos_settings->suspend_sale ?></td>
                                    <td><?= lang('suspend_sale') ?></td>
                                </tr>
                                <tr>
                                    <td><?= $pos_settings->print_items_list ?></td>
                                    <td><?= lang('print_items_list') ?></td>
                                </tr>
                                <tr>
                                    <td><?= $pos_settings->finalize_sale ?></td>
                                    <td><?= lang('finalize_sale') ?></td>
                                </tr>
                                <tr>
                                    <td><?= $pos_settings->today_sale ?></td>
                                    <td><?= lang('today_sale') ?></td>
                                </tr>
                                <tr>
                                    <td><?= $pos_settings->open_hold_bills ?></td>
                                    <td><?= lang('open_hold_bills') ?></td>
                                </tr>
                                <tr>
                                    <td><?= $pos_settings->close_register ?></td>
                                    <td><?= lang('close_register') ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade in" id="dsModal" tabindex="-1" role="dialog" aria-labelledby="dsModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i
                                class="fa fa-2x">&times;</i></button>
                        <h4 class="modal-title" id="dsModalLabel"><?= lang('edit_order_discount'); ?></h4>
                    </div>
                    <div class="modal-body">
                        <?php if($pos_settings->order_discount_type == 'percent'){ ?>
                            <p class="noticeText"><?= lang('order_discount_percent_notice'); ?></p>
                        <?php }else{?>
                            <p class="noticeText"><?= lang('order_discount_flat_notice'); ?></p>
                        <?php } ?>
                        <div class="form-group">
                        <?= lang("discount_type", "discount_type"); ?>
                            <select class="form-control" name="discount_type" id="discount_type">
                                <option value="order" selected>Order Discount</option>
                                <!--<option value="replacement" >Replacement Discount</option>-->
                                <option value="promotions" >Promotions Discount</option>
                                <option value="employee" >Employee Discount</option>
                            </select>
                        </div>    
                            
                        <div class="form-group">
                            <?= lang("order_discount", "order_discount_input"); ?>
                            <?php echo form_input('order_discount_input', '', 'class="form-control close_register_input" id="order_discount_input"'); ?>
                        </div>
                        <div class="form-group">
                            <?= lang("discount_reason", "discount_reason_input"); ?>
                            <?php
                            $data = array(
                                'name' => 'discout_reason_input',
                                'id' => 'discout_reason_input',
                                'class' => 'form-control kb-text',
                                'rows' => '3',
                                'cols' => '10',
                                'style'=> 'resize:none'
                            );

                            echo form_textarea($data);
                            ?>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="updateOrderDiscount" class="btn btn-primary"><?= lang('update') ?></button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade in" id="txModal" tabindex="-1" role="dialog" aria-labelledby="txModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i
                                class="fa fa-2x">&times;</i></button>
                        <h4 class="modal-title" id="txModalLabel"><?= lang('edit_order_tax'); ?></h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <?= lang("order_tax", "order_tax_input"); ?>
                            <?php
                            $tr[""] = "";
                            foreach ($tax_rates as $tax) {
                                $tr[$tax->id] = $tax->name;
                            }
                            echo form_dropdown('order_tax_input', $tr, "", 'id="order_tax_input" class="form-control pos-input-tip" style="width:100%;"');
                            ?>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" id="updateOrderTax" class="btn btn-primary"><?= lang('update') ?></button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade in" id="susModal" tabindex="-1" role="dialog" aria-labelledby="susModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i
                                class="fa fa-2x">&times;</i></button>
                        <h4 class="modal-title" id="susModalLabel"><?= lang('suspend_sale'); ?></h4>
                    </div>
                    <div class="modal-body">
                        <p><?= lang('type_reference_note'); ?></p>

                        <div class="form-group">
                            <?= lang("reference_note", "reference_note"); ?>
                            <?php echo form_input('reference_note', $reference_note, 'class="form-control kb-text" id="reference_note"'); ?>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" id="suspend_sale" class="btn btn-primary"><?= lang('submit') ?></button>
                    </div>
                </div>
            </div>
        </div>
        <div id="order_tbl"><span id="order_span"></span>
            <table id="order-table" class="prT table table-striped" style="margin-bottom:0;" width="100%"></table>
        </div>
        <div id="bill_tbl"><span id="bill_span"></span>
            <table id="bill-table" width="100%" class="prT table table-striped" style="margin-bottom:0;"></table>
            <table id="bill-total-table" class="prT table" style="margin-bottom:0;" width="100%"></table>
        </div>
        <div class="modal fade in" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
             aria-hidden="true"></div>
        <div class="modal fade in" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2"
             aria-hidden="true"></div>
        <div id="modal-loading" style="display: none;">
            <div class="blackbg"></div>
            <div class="loader"></div>
        </div>
        <?php unset($Settings->setting_id, $Settings->smtp_user, $Settings->smtp_pass, $Settings->smtp_port, $Settings->update, $Settings->reg_ver, $Settings->allow_reg, $Settings->default_email, $Settings->mmode, $Settings->timezone, $Settings->restrict_calendar, $Settings->restrict_user, $Settings->auto_reg, $Settings->reg_notification, $Settings->protocol, $Settings->mailpath, $Settings->smtp_crypto, $Settings->corn, $Settings->customer_group, $Settings->envato_username, $Settings->purchase_code); ?>
        <script type="text/javascript">
            var site = <?= json_encode(array('base_url' => base_url(), 'settings' => $Settings, 'dateFormats' => $dateFormats)) ?>, pos_settings = <?= json_encode($pos_settings); ?>;
            var lang = {unexpected_value: '<?= lang('unexpected_value'); ?>', select_above: '<?= lang('select_above'); ?>', r_u_sure: '<?= lang('r_u_sure'); ?>'};

            
        </script>

        <script type="text/javascript">
         var round_total = 0;
            var product_variant = 0, shipping = 0, p_page = 0, per_page = 0, tcp = "<?= $tcp ?>",
                    cat_id = "<?= $pos_settings->default_category ?>", ocat_id = "<?= $pos_settings->default_category ?>", sub_cat_id = 0, osub_cat_id,
                    count = 1, an = 1, DT = <?= $Settings->default_tax_rate ?>,
                    product_tax = 0, invoice_tax = 0, total_discount = 0, total = 0, total_paid = 0, grand_total = 0,
                    KB = <?= $pos_settings->keyboard ?>, tax_rates = <?php echo json_encode($tax_rates); ?>;
            var protect_delete = <?php
            if (!$Owner && !$Admin) {
                echo $pos_settings->pin_code ? '1' : '0';
            } else {
                echo '0';
            }
        ?>;
            //var audio_success = new Audio('<?= $assets ?>sounds/sound2.mp3');
            //var audio_error = new Audio('<?= $assets ?>sounds/sound3.mp3');
            var lang_total = '<?= lang('total'); ?>', lang_items = '<?= lang('items'); ?>', lang_discount = '<?= lang('discount'); ?>', lang_tax2 = '<?= lang('order_tax'); ?>', lang_total_payable = '<?= lang('total_payable'); ?>';
            var java_applet = <?= $pos_settings->java_applet ?>, order_data = '', bill_data = '';
            function widthFunctions(e) {
                var wh = $(window).height(),
                lth = $('#left-top').height(),
                lbh = $('#left-bottom').height();
                $('#item-list').css("height", wh - 140);
                $('#item-list').css("min-height", 515);
                $('#left-middle').css("height", wh - lth - lbh - 100);
                $('#left-middle').css("min-height", 325);
                $('#product-list').css("height", wh - lth - lbh - 105);
                $('#product-list').css("min-height", 320);
            }
            $(window).bind("resize", widthFunctions);
            $(document).ready(function () {
   
            $("#pcc_card_1").select2().select2("val", '');
<?php if ($sid) {    ?>

    localStorage.setItem('positems', JSON.stringify(<?= $items; ?>));
<?php } ?>
<?php if ($this->session->userdata('remove_posls')) { ?>
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
                    if (localStorage.getItem('poswarehouse')) {
                        localStorage.removeItem('poswarehouse');
                    }
                    if (localStorage.getItem('posnote')) {
                        localStorage.removeItem('posnote');
                    }
                    if (localStorage.getItem('poscustomer')) {
                        localStorage.removeItem('poscustomer');
                    }
                    if (localStorage.getItem('posbiller')) {
                        localStorage.removeItem('posbiller');
                    }
                    if (localStorage.getItem('poscurrency')) {
                        localStorage.removeItem('poscurrency');
                    }
                    if (localStorage.getItem('posnote')) {
                        localStorage.removeItem('posnote');
                    }
                    if (localStorage.getItem('staffnote')) {
                        localStorage.removeItem('staffnote');
                    }
    <?php
    $this->sma->unset_data('remove_posls');
}
?>
                widthFunctions();
<?php if ($suspend_sale) { ?>    
                    //localStorage.setItem('postax2', <?= isset($suspend_sale->order_tax_id)? $suspend_sale->order_tax_id :0; ?>);
                    localStorage.setItem('postax2', '<?= $suspend_sale->order_tax_id; ?>');
                    localStorage.setItem('posdiscount', '<?= $suspend_sale->order_discount_id; ?>');
                    localStorage.setItem('poswarehouse', '<?= $suspend_sale->warehouse_id; ?>');
                    localStorage.setItem('poscustomer', '<?= $suspend_sale->customer_id; ?>');                   
                    localStorage.setItem('posbiller', '<?= $suspend_sale->biller_id; ?>');
                    localStorage.setItem('orderdisc', '<?= $suspend_sale->order_discount_id; ?>');
                  //  alert("====>"+localStorage.getItem('orderdisc'));
<?php } ?>
<?php if ($this->input->get('customer')) { ?>
                    if((jQuery.isEmptyObject({}) === true) || (localStorage.getItem('positems') === undefined) || (localStorage.getItem('positems') === null))
                    {
                        localStorage.setItem('poscustomer', <?= $this->input->get('customer'); ?>);
                    } else if (!localStorage.getItem('poscustomer')) {
                        localStorage.setItem('poscustomer', <?= $customer->id; ?>);
                    }
<?php } else { ?>
                
                    if (!localStorage.getItem('poscustomer')) {
                        localStorage.setItem('poscustomer', <?= $customer->id; ?>);
                    }
<?php } ?>
                if (!localStorage.getItem('postax2')) {
                    localStorage.setItem('postax2', <?= $Settings->default_tax_rate2; ?>);
                }
                $('.select').select2({minimumResultsForSearch: 6});
                var cutomers = [{
                        id: <?= $customer->id; ?>,
                        text: '<?= empty($customer->company) ? $customer->name : $customer->company; ?>'
                    }];
                    
                var poscust = ((localStorage.getItem('poscustomer') == null) || (localStorage.getItem('poscustomer') == undefined)) ? '<?=$pos_settings->default_customer?>' : localStorage.getItem('poscustomer');
                
                $('#poscustomer').val(poscust).select2({
                    minimumInputLength:1,
                    maximumInputLength: 20,
                    minimumResultsForSearch:2,
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
                        quietMillis: 500,
                        delay: 1000,
                        data: function (term, page) {
                            return {
                                term: term,
                                limit: 10
                            };
                        },
                        results: function (data, page) { 
                            if (data.results != null) {
                                console.log('keypress result');
                                return {results: data.results};
                            } else {
                                console.log('keypress not found result');
                                return {results: [{id: '', text: 'No Match Found'}]};
                            }
                        }
                    }
                });
                
                
            if (KB) {
               // display_keyboards();
                var result = false;
                
                $('#poscustomer').on('select2-opening', function () {
                 //   console.log('select2-opening');
                   // display_keyboards();                     
                    $('.select2-input').keyboard({
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
                                                //console.log(JSON.stringify(el.value));
                                                //console.log('accepted');
                                                // alert('The content "' + el.value + '" was accepted!'); 
                                                $('.select2-input').addClass('select2-active');
                                                el.value = trim(el.value);
                                                if (el && el.value !== undefined && el.value !== " " && el.value !== null && el.value.length > 0){
                                                    setTimeout(function() {
                                                        $.ajax({
                                                            type: "get",
                                                            async: false,
                                                            url: "<?= site_url('customers/suggestions') ?>/" + el.value,
                                                            dataType: "json",
                                                            success: function (res) {
                                                                if (res.results != null) {
                                                                   $('#poscustomer').select2({data: res}).select2('open');
                                                                    $('.select2-input').removeClass('select2-active');
                                                                    result = true;
                                                                } else {
                                                                    result = false;
                                                                }

                                                                if (!result) {
                                                                    bootbox.alert('No Match found Please try again.');
                                                                    $('#poscustomer').select2('close');
                                                                    $('#test').click();
                                    o                            }
                                                            }
                                                        });
                                                    },1000);
                                                }
                                            }
                   });
                });
                              
                    $('#poscustomer').on('select2-close', function () {
                        console.log('select2-close');
                        //$('.select2-input').addClass('kb-text');
                     
                    });
                
                  
            }
            
            function trim(str) {
                if(typeof str !== 'string') {
                    throw new Error('only string parameter supported!');
                }
                return str.replace(/^\s+|\s+$/g,'');
            }
                
            $(document).bind('click', '#amount_2', function () {
              display_keyboards();
                $('#amount_2').addClass('kb-text');             
            });

            
            $(document).bind('click', '#amount_3', function () {
                display_keyboards();
                $('#amount_3').addClass('kb-text');         
            });
            
            $(document).bind('click', '#amount_4', function () {
                 display_keyboards();
                $('#amount_4').addClass('kb-text');
            });
                    
                    $(document).bind('click', '#amount_5', function () {
                     display_keyboards();
                        $('#amount_5').addClass('kb-text');             
                    });                 

                    $(document).on('change', '#posbiller', function () {
                        $('#biller').val($(this).val());
                });
                  
                    

        <?php 
        for ($i = 1; $i <= 50; $i++) { ?>
               
                    $('#paymentModal').on('change', '#amount_<?= $i ?>', function (e) {
                        $('#amount_val_<?= $i ?>').val($(this).val());                  
                    });
                    $('#paymentModal').on('blur', '#amount_<?= $i ?>', function (e) {
                        $('#amount_val_<?= $i ?>').val($(this).val());
                    });
                    $('#paymentModal').on('change', '#paid_by_<?= $i ?>', function (e) {
                        //alert($(this).val());
                        $('#paid_by_val_<?= $i ?>').val($(this).val());
                    });
                    
                    $('#paymentModal').on('change', '#pcc_no_<?= $i ?>', function (e) {    
                        $('#cc_no_val_<?= $i ?>').val($(this).val());
                    });
                    
                    $('#paymentModal').on('change', '#pcc_holder_<?= $i ?>', function (e) {
                        $('#cc_holder_val_<?= $i ?>').val($(this).val());
                    });
                    
                    $('#paymentModal').on('change', '#pcc_nation_<?= $i ?>', function (e) {
                        $('#cc_nation_val_<?= $i ?>').val($(this).val());
                    });
                    
                    $('#paymentModal').on('change', '#pcc_edc_<?= $i ?>', function (e) {
                        $('#cc_edc_val_<?= $i ?>').val($(this).val());
                    });
                    
                    $('#paymentModal').on('change', '#gift_card_no_<?= $i ?>', function (e) {
                        $('#paying_gift_card_no_val_<?= $i ?>').val($(this).val());
                    });
                    $('#paymentModal').on('change', '#pcc_month_<?= $i ?>', function (e) {
                        $('#cc_month_val_<?= $i ?>').val($(this).val());
                    });
                    $('#paymentModal').on('change', '#pcc_year_<?= $i ?>', function (e) {
                        $('#cc_year_val_<?= $i ?>').val($(this).val());
                    });
                    $('#paymentModal').on('change', '#pcc_type_<?= $i ?>', function (e) {
                        $('#cc_type_val_<?= $i ?>').val($(this).val());
                    });
                    
                    $('#paymentModal').on('change', '#pcc_card_<?= $i ?>', function (e) {
                        $('#cc_card_type_val_<?= $i ?>').val($(this).val());
                    });
                    
                    $('#paymentModal').on('change', '#pcc_cvv2_<?= $i ?>', function (e) {
                        $('#cc_cvv2_val_<?= $i ?>').val($(this).val());
                    });
                            
                    $('#paymentModal').on('change', '#cheque_no_<?= $i ?>', function (e) {
                        $('#cheque_no_val_<?= $i ?>').val($(this).val());
                    });
                    $('#paymentModal').on('change', '#payment_note_<?= $i ?>', function (e) {
                        $('#payment_note_val_<?= $i ?>').val($(this).val());
                    });
        <?php } ?>
                            
            $('#payment').click(function () {
             
                /******updated by ajay on 04-01-2016****************/
                $('.payment').children().find('input,select,textarea').each(function(){
                    $(this).val('');
                });
                var na = parseFloat(count) - 1;
                if(na <= 0){
                    bootbox.alert('No Product Added to list');
                    return false;
                }
                
                $('#payments').closest('form').find("input[type=text], textarea").val("");
                $('#paid_by_1').select2('val','ss');
                setPaymentOptions('ss',1);
                
                /**************************************************/
                if (count < 1) {
                    bootbox.alert('<?= lang('x_suspend'); ?>');
                    return false;
                }
            $('#add_item').focusout();
            localStorage.removeItem('pay');
            <?php if ($sid) { ?>
                        suspend = $('<span></span>');
                        suspend.html('<input type="hidden" name="delete_id" value="<?php echo $sid; ?>" />');
                        suspend.appendTo("#hidesuspend");
            <?php } ?>
                    var twt = formatDecimal(Math.round((total + invoice_tax) - order_discount));
                   // no need to round off product price //added by mridula
//                   var twt = formatDecimal((total + invoice_tax) - order_discount);

                    if (count == 1) {
                        bootbox.alert('<?= lang('x_total'); ?>');
                        return false;
                    }
                    gtotal = formatDecimal(twt);
                    
                    
                    <?php if ($pos_settings->rounding) { ?>
                        if (typeof gtotal !== 'undefined') {
                            //round_total = roundNumber(gtotal, <?= $pos_settings->rounding ?>);
                            round_total = gtotal;

                            var rounding = formatDecimal(0 - (gtotal - round_total));
                            $('#twt').text(formatMoney(round_total) + ' (' + formatMoney(rounding) + ')');
                            $('#quick-payable').text(round_total);
                        }
                    <?php } else { ?>
                       // alert(2+"g total"+gtotal)
                        $('#twt').text(formatMoney(Math.round(gtotal)));
                         // no need to round off product price //added by mridula
//                        $('#twt').text(formatMoney(gtotal));                        
                        $('#quick-payable').text(Math.round(gtotal));
                      // no need to round off product price //added by mridula

//                      $('#quick-payable').text(gtotal);
                    <?php } ?>
                    $('#item_count').text(count - 1);
                    $('#paymentModal').appendTo("body").modal('show');
                    $('#amount_1').focus();
                });

                $('#paymentModal').on('shown.bs.modal', function (e) {
                    $('#amount_1').focus();
                });
                
                var pi = 'amount_1', pa = 2;
                $(document).on('click', '.quick-cash', function () {
                    var $quick_cash = $(this);
                    var amt = $quick_cash.contents().filter(function () {
                        return this.nodeType == 3;
                    }).text();
                    var th = site.settings.thousands_sep == 0 ? '' : site.settings.thousands_sep;
                    var $pi = $('#' + pi);
                    amt = formatDecimal(amt.split(th).join("")) * 1 + $pi.val() * 1;
                    $pi.val(formatDecimal(amt)).focus();
                    var note_count = $quick_cash.find('span');
                    if (note_count.length == 0) {
                        $quick_cash.append('<span class="badge">1</span>');
                    } else {
                        note_count.text(parseInt(note_count.text()) + 1);
                    }
                   // calculateTotals();
                });

                $(document).on('click', '#clear-cash-notes', function () {
                    $('.quick-cash').find('.badge').remove();
                    $('#' + pi).val('0').focus();
                });

                c = 0;
                $(document).on('change', '.gift_card_no', function (e) { //alert ("count"+c);
                //if(c > 1) { c = 0;}
                    e.preventDefault(); 
                    var customer;
                    var amount_id = $(this).attr('id').split('_').pop();
                    var am = $('#amount_'+amount_id).val();
                    var cust = $('#poscustomer').val();
                    //alert(am);
                    $('#cv_error_msg_1').hide();
                    $('#cv_error_msg2_1').hide();
                    var cn = $(this).val() ? $(this).val() : '';
                    var payid = $(this).attr('id'),
                    id = payid.substr(payid.length - 1);
                    
                    self = $(this);
                    var choosen = $(this).val(); 
                    $('.gift_card_no').not(self).each(function(){
                        if($(this).val() === choosen){                             
                            if(self.attr('id') === 'gift_card_no_1'){
                                if($(this).val() !== ''){
                                    bootbox.alert('credit note is already selected');
                                    $('#gc_details_' + id).hide();
                                    $('#gift_card_no_1').empty().select2('val','').trigger('change');
                                    $('.select2-input.gift_card_no').addClass('required');
                                    //$('#gift_card_no_1').select2("val","");
                                }
                            }else{
                                if($(this).val() !== ''){
                                        bootbox.alert('credit note is already selected');
                                        $('#gc_details_' + id).hide();
                                        $('#'+self.attr('id')).val('').trigger('change.select2');
                                        $('#gift_card_no_'+id).empty().select2('val','').trigger('change');
                                        $('.select2-input.gift_card_no').addClass('required');
                                }
                            }
                        }
                    });              
                    
                    $('#cn_balance_' + id).val(0);
                    $('#cn_balance_val_' + id).val(0);
                    if (cn != '') {
                        $.ajax({
                            type: "post", async: false,
                            url: site.base_url + "sales/validate_gift_card",
                            data:{'cn':cn,'amount':am,'customer_id':cust},
                            dataType: "json",
                            success: function (data) { 
                                console.log(JSON.stringify(data));
                                localStorage.removeItem('gc_status');
                                if (data === false) {                   
                                    $('#gift_card_no_' + id).parent('.form-group').addClass('error');
                                    if($('#gift_card_no_' + id).parent('.form-group').hasClass('error')){
                                        $('#submit-sale').prop('disabled',true);
                                        $('#gc_details_' + id).hide(); // add by ankit
                                        $('#cv_error_msg_'+ id).find('p').text('<?= lang('incorrect_gift_card') ?>');
                                        $('#cv_error_msg_'+ id).show();
                                    }
                                    //localStorage.setItem('gc_status', 'invalid');                                   
                                }else if(data.error == 'expired'){
                                    $('#gift_card_no_' + id).parent('.form-group').addClass('error');
                                    if($('#gift_card_no_' + id).parent('.form-group').hasClass('error')){
                                        $('#submit-sale').prop('disabled',true);
                                        $('#gc_details_' + id).hide(); // add by ankit
                                        $('#cv_error_msg_'+ id).find('p').text('<?= lang('incorrect_gift_card') ?>');
                                        $('#cv_error_msg_'+ id).show();
                                    }
                                }else if(data.error == 'less_balance'){   
                                    $('#cv_error_msg_'+ id).hide();
                                    $('#gift_card_no_' + id).parent('.form-group').addClass('error');
                                    //localStorage.setItem('gc_status', 'invalid');
                                    
                                    if($('#gift_card_no_' + id).parent('.form-group').hasClass('error')){
                                        $('#submit-sale').prop('disabled',true);
                                        $('#cv_error_msg_'+ id).find('p').text('Credit Note balance is less than amount');
                                        $('#cv_error_msg_'+ id).show();
                                        $('#gc_details_' + id).hide();
                                    }       
                                }else if (data.error == 'other_customer') {
                                        $('#cv_error_msg_'+ id).hide();
                                        $('#gift_card_no_' + id).parent('.form-group').addClass('error');
                                        //localStorage.setItem('gc_status', 'invalid');
                                    //bootbox.alert('<?= lang('gift_card_not_for_customer') ?>');
                               if($('#gift_card_no_' + id).parent('.form-group').hasClass('error')){
                                        $('#submit-sale').prop('disabled',true);
                                        $('#cv_error_msg_'+ id).find('p').text('<?= lang('gift_card_not_for_customer') ?>');
                                        $('#cv_error_msg_'+ id).show();
                                        $('#gc_details_' + id).hide();
                                   }
                                } else if(data.error == 'noerror') {
                                        $('#cv_error_msg_'+ id).hide();
                                        $('#cn_balance_'+id).val(parseFloat(data.balance));
                                        $('#cn_balance_val_' + id).val(parseFloat(data.balance-am));
                                        $('#gc_details_' + id).html('<small>Value: ' + data.value + ' - Balance: ' + parseFloat(data.balance-am) + '</small>');
                                        $('#gift_card_no_' + id).parent('.form-group').removeClass('error');
                                        $('#gc_details_' + id).show(); // add by ankit
                                        localStorage.setItem('gc_status', 'valid');
                                        $('#submit-sale').prop('disabled',false);
                                }
                            }
                        });
                    } //c = c+1;
                });
                

                // added by vikas singh

                 $(document).on('change', '.amount', function (e) { //alert ("count"+c);
                //if(c > 1) { c = 0;}
                    e.preventDefault(); 
                    var customer;
                    var amount_id = $(this).attr('id').split('_').pop();
                    var payment_type = $('#paid_by_'+amount_id+' :selected').val();
                   if(payment_type === 'credit_voucher'){

                    var am = $('#amount_'+amount_id).val();
                    var cust = $('#poscustomer').val();
                    
                    $('#cv_error_msg_1').hide();
                    $('#cv_error_msg2_1').hide();
                    var cn = $('#gift_card_no_'+amount_id).val();
                    var payid = $(this).attr('id'),
                    id = payid.substr(payid.length - 1);

                    $('#cn_balance_' + id).val(0);
                    $('#cn_balance_val_' + id).val(0);
                    if (cn != '') {
                        $.ajax({
                            type: "post", async: false,
                            url: site.base_url + "sales/validate_gift_card",
                            data:{'cn':cn,'amount':am,'customer_id':cust},
                            dataType: "json",
                            success: function (data) { 
                                localStorage.removeItem('gc_status');
                                if (data === false) {                   
                                    $('#gift_card_no_' + id).parent('.form-group').addClass('error');
                                    if($('#gift_card_no_' + id).parent('.form-group').hasClass('error')){
                                        $('#submit-sale').prop('disabled',true);
                                        $('#gc_details_' + id).hide(); // add by ankit
                                        $('#cv_error_msg_'+ id).find('p').text('<?= lang('incorrect_gift_card') ?>');
                                        $('#cv_error_msg_'+ id).show();
                                    }
                                    //localStorage.setItem('gc_status', 'invalid');                                   
                                }else if(data.error == 'expired'){
                                    $('#gift_card_no_' + id).parent('.form-group').addClass('error');
                                    if($('#gift_card_no_' + id).parent('.form-group').hasClass('error')){
                                        $('#submit-sale').prop('disabled',true);
                                        $('#gc_details_' + id).hide(); // add by ankit
                                        $('#cv_error_msg_'+ id).find('p').text('<?= lang('incorrect_gift_card') ?>');
                                        $('#cv_error_msg_'+ id).show();
                                    }
                                }else if(data.error == 'less_balance'){   
                                    $('#cv_error_msg_'+ id).hide();
                                    $('#gift_card_no_' + id).parent('.form-group').addClass('error');
                                    //localStorage.setItem('gc_status', 'invalid');
                                    
                                    if($('#gift_card_no_' + id).parent('.form-group').hasClass('error')){
                                        $('#submit-sale').prop('disabled',true);
                                        $('#cv_error_msg_'+ id).find('p').text('Credit Note balance is less than amount');
                                        $('#cv_error_msg_'+ id).show();
                                        $('#gc_details_' + id).hide();
                                    }       
                                }else if (data.error == 'other_customer') {
                                        $('#cv_error_msg_'+ id).hide();
                                        $('#gift_card_no_' + id).parent('.form-group').addClass('error');
                                        //localStorage.setItem('gc_status', 'invalid');
                                    //bootbox.alert('<?= lang('gift_card_not_for_customer') ?>');
                               if($('#gift_card_no_' + id).parent('.form-group').hasClass('error')){
                                        $('#submit-sale').prop('disabled',true);
                                        $('#cv_error_msg_'+ id).find('p').text('<?= lang('gift_card_not_for_customer') ?>');
                                        $('#cv_error_msg_'+ id).show();
                                        $('#gc_details_' + id).hide();
                                   }
                                } else if(data.error == 'noerror') {
                                 $('#cv_error_msg_'+ id).hide();
                                        $('#cn_balance_'+id).val(parseFloat(data.balance));
                                        $('#cn_balance_val_'+id).val(parseFloat(data.balance-am));
                                        $('#gc_details_' + id).html('<small>Card No: ' + data.card_no + '<br>Value: ' + data.value + ' - Balance: ' + parseFloat(data.balance-am) + '</small>');
                                        $('#gift_card_no_' + id).parent('.form-group').removeClass('error');
                                        $('#gc_details_' + id).show(); // add by ankit
                                        localStorage.setItem('gc_status', 'valid');
                                        $('#submit-sale').prop('disabled',false);
                                }
                            }
                        });
                    } 
                    }
                    else{
                        return true;
                    }
                    //c = c+1;
                });

                $("select[name='discount_type']").on('change', function() {
                    $('#order_discount_input').val('');
                    if(this.value=='replacement'){
                        $('#order_discount_input').val('35');
                        $('#order_discount_input').attr('readonly', true);
                    }
                    else if(this.value == 'employee'){
                        $('#order_discount_input').val('40');
                        $('#order_discount_input').attr('readonly', true);
                    }
                    else{
                        $('#order_discount_input').val('0');
                        $('#order_discount_input').attr('readonly', false);
                    }
                });
                
                $("select[name='pdiscount_type']").select2().on('change', function() {                
                    $("#pdiscount").val(0);                              
                    //var row = $(this).closest('tr');
                    var item_id = $(this).attr('data-item-id');
                    
                    var sel = $("#pdiscount_reason");
                    sel.select2().empty();
                    if($(this).val() === 'product'){
                        $("#pdiscount").val(0);
                        var cdata = [{id: 0, text: "--Select Discount Reason--"},{id: 1, text: "Bulk Order"}, {id: 2, text: "B2B Order"},{id: 3, text: "Goodwill"}];
                        //$("select[name='pdiscount_reason'][data-item-id="+item_id+"]").show();
                        $('#dsct_rsn').css('display','block');
                        
                        $(cdata).each(function(k, o) {
                                sel.append($("<option></option>").attr("value", o.id).html(o.text)).select2();
                        });          
                        sel.select2('val',0); 
                    }else if($(this).val() === 'promotions'){
                        var data = [{id: 0, text: "--Select Discount Reason--"},{id: 4, text: "HIT and HOT"}];
                        //$("select[name='pdiscount_reason'][data-item-id="+item_id+"]").show();
                        $('#dsct_rsn').css('display','block');
                        $(data).each(function(k, o) {
                                sel.append($("<option></option>").attr("value", o.id).html(o.text));
                        });    
                        sel.select2('val',0);
                    } else if($(this).val() === 'replacement'){
                        var data = [{id: 0, text: ""},];
                        //$("select[name='pdiscount_reason'][data-item-id="+item_id+"]").hide();
                        $('#dsct_rsn').css('display','block');
                         $(data).each(function(k, o) {
                                sel.append($("<option></option>").attr("value", o.id).html(o.text));
                        });    
                        sel.change();
                    }else{
                        var data = [{id: 0, text: "--Select Discount Reason--"},];
                        //$("select[name='pdiscount_reason'][data-item-id="+item_id+"]").hide();
                        $('#dsct_rsn').css('display','block');
                        $(data).each(function(k, o) {
                                sel.append($("<option></option>").attr("value", o.id).html(o.text));
                        });    
                        sel.select2('val',0);
                    }
                    
//                    if($(this).val() === 'replacement'){
//                        var select = $("#pdiscount_reason");
//                            select.select2().empty();
//                            select.change();
//                    }else{
//                        var select = $("#pdiscount_reason");
//                            select.select2().empty();
//                            $(data).each(function(k, o) {
//                                select.append($("<option></option>").attr("value", o.id).html(o.text));
//                            });    
//                            //select.val([1, 2]);// An array of ids to select in data, remove if you dont need it
//                            select.change();
//                    }

                    if(this.value=='replacement'){
                        $('#pdiscount').val('35%');
                        $('#pdiscount').attr('readonly', true);
                    }
                    else if(this.value == 'employee'){
                        $('#pdiscount').val('40%');
                        $('#pdiscount').attr('readonly', true);
                    }
                    else{
                        $('#pdiscount').val('');
                        $('#pdiscount').attr('readonly', false);
                    }
                });
                
                $(document).on('change',"select[name='sales_executives']",function() {
                    var pos_exe_id =  this.value ;
                    $("#sales_executives").val(pos_exe_id);
                });
                
              
            // Added By Anil Aprl 28-17 Start
                $('select.pdiscount_type').change(function(){
                    var selecteddtype = $('.pdiscount_type option:selected').val();
                    if(selecteddtype === 'replacement'){
                        $('#dsct_rsn').css('display','none');                    
                    } else{
                        $('#dsct_rsn').css('display','block');
                        $('#dsct_rsn').val(0);
                    }      
                });
            // Added By Anil Aprl 28-17 End
               
                // added by vikas singh 24-10-16
   
    var maxField = 6; //Input fields increment limitation
    var addButton = $(".addButton"); //Add button selector
    var wrapper = $('#payments'); //Input field wrapper
    
    var x = 2, fieldcount = 2; //Initial field counter is 1
    
    $(addButton).click(function(){ //Once add button is clicked
        var b = $('.payment').length+1;
        if(b < maxField){ //Check maximum number of input fields
           
           
            var fieldHTML = "";
           // alert("x"+x+"max"+maxField)
          
            fieldHTML += '<div id="payments_'+x+'">';
            fieldHTML += '<div class="well well-sm well_1">';
            fieldHTML += '<a href="javascript:void(0);" class="remove_button" id="cl_row_' + x + '"  title="Remove field" style="position: absolute; margin-left: 90%;"><i class="fa fa-2x">×</i></a>';
            fieldHTML += '<div class="payment">';
            fieldHTML += '<div class="row">';
            fieldHTML += '<div class="col-sm-5">';
            fieldHTML += '<div class="form-group">';
            fieldHTML += '<?= lang("amount", "amount_'+x+'"); ?>';
            fieldHTML += '<input name="amountc['+x+']" type="text" id="amount_'+x+'" class="pa form-control kb-pad amount addmorePay"/>';
            fieldHTML += '</div>';   
            fieldHTML += '</div>';                         
            fieldHTML += '<div class="col-sm-5 col-sm-offset-1">';                                
            fieldHTML += '<div class="form-group">';                                     
            fieldHTML += '<?= lang("paying_by", "paid_by_'+x+'"); ?>';                                        
            fieldHTML += '<select name="paid_by_['+x+']" id="paid_by_'+x+'" class="form-control paid_by addmorePay">';                                             
            fieldHTML += '<option value="ss">Select an option</option>';                                                
            fieldHTML += '<option value="cash"><?= lang("cash"); ?></option>';
            fieldHTML += '<option value="CC"><?= lang("cc"); ?></option>';                                                
            fieldHTML += '<option value="credit_voucher"><?= lang("credit_voucher"); ?></option>';
            fieldHTML += '</select>'; 
            fieldHTML += '</div>';                                       
            fieldHTML += '</div>';                                         
            fieldHTML += '</div>';                                             
            fieldHTML += '<div class="row">';                                               
            fieldHTML += '<div class="col-sm-12">';                                                 
            fieldHTML += '<div class="form-group gc_'+x+'" style="display:none;">'; 
            fieldHTML += '<?= lang("gift_card_no", "gift_card_no_'+x+'"); ?>';                                                 
            fieldHTML += '<input name="cpaying_gift_card_no['+x+']" type="text" id="gift_card_no_'+x+'"class="pa form-control kb-text gift_card_no addmorePay" />';                                            
            fieldHTML += '<div id="gc_details_'+x+'"></div>';
            fieldHTML += '<input type="hidden" name="cn_balance_'+x+'" value="" id="cn_balance_'+x+'">';
            fieldHTML += '<div style="color:red;display:none;" id="cv_error_msg_' + x +'"><p></p></div>';
            //fieldHTML += '<div style="color:red;display:none;" id="cv_error_msg2_' + x +'"><p><?= lang('gift_card_not_for_customer') ?></p></div>';
            fieldHTML += '</div>';                                  
            fieldHTML += '<div class="form-group cv_'+x+'" style="display: none;">';                                   
            fieldHTML += '<?= lang("credit_voucher_no", "credit_voucher_no_'+x+'"); ?>';                                        
            fieldHTML += '<input name="cpaying_credit_voucher_no['+x+']" type="text" id="credit_voucher_no_'+x+'" class="pa form-control kb-pad credit_voucher_no addmorePay"/>';                                           
            fieldHTML += '<div id="cv_details_'+x+'"></div>';                                                                                           
            fieldHTML += '</div>'; 
            fieldHTML += '<div class="pcc_'+x+'" style="display:none;">';                                                
            fieldHTML += '<div class="form-group">';  
            fieldHTML += '<input type="text" id="swipe_'+x+'" name="swipe[' + x +']" class="form-control swipe" placeholder="<?= lang('swipe') ?>"/>'; 
            fieldHTML += '</div>';                                                 
            fieldHTML += '<div class="row">';                                             
            fieldHTML += '<div class="col-md-5">';                                          
            fieldHTML += '<div class="form-group">';
            fieldHTML += '<input name="ccc_no['+x+']" type="text" id="pcc_no_'+x+'" class="form-control addmorePay cardno kb-pad" maxlength="20" placeholder="<?= lang('cc_no') ?>"/>';                     
            fieldHTML += '</div>';                                                
            fieldHTML += '</div>';
            fieldHTML += '<div class="col-md-2">';
            fieldHTML += '<div class="form-group">';                                                  
            fieldHTML += '<select name="ccard_type['+x+']" id="pcc_card_'+x+'"class="form-control pcc_type addmorePay" placeholder="<?= lang('card_type') ?>">';   
            fieldHTML += '<option value=""><?= lang("credit_debit"); ?></option>';
            fieldHTML += '<option value="CC"><?= lang("credit_card"); ?></option>';                                                         
            fieldHTML += '<option value="DC"><?= lang("debit_card"); ?></option>';                                                                     
            fieldHTML += '</select>'; 
            fieldHTML += '</div>';
            fieldHTML += '</div>';
            
            fieldHTML += '<div class="col-md-2">';
            fieldHTML += '<div class="form-group">';                                                  
            fieldHTML += '<select name="ccard_nation['+x+']" id="pcc_nation_'+x+'"class="form-control pcc_nation addmorePay" placeholder="<?= lang('card_nation') ?>">'; 
            fieldHTML += '<option value=""><?= lang("credit_nation"); ?></option>';
            fieldHTML += '<option value="domestic"><?= lang("domestic"); ?></option>';                                                         
            fieldHTML += '<option value="international"><?= lang("international"); ?></option>';                                                                     
            fieldHTML += '</select>'; 
            fieldHTML += '</div>';
            fieldHTML += '</div>';
            
            fieldHTML += '<div class="col-md-3">'; 
            fieldHTML += '<div class="form-group">';
            fieldHTML += '<input name="ccc_holer['+x+']" type="text" id="pcc_holder_'+x+'"class="form-control addmorePay kb-text"  placeholder="<?= lang('cc_holder') ?>"/>';                                                        
            fieldHTML += '</div>'; 
            fieldHTML += '</div></div>';
            fieldHTML += '<div class="row">';  
            fieldHTML += '<div class="col-md-3">';
            fieldHTML += '<div class="form-group">';  
//             fieldHTML += '<input name="ccc_type['+x+']" id="pcc_type_'+x+'" class="form-control pcc_type addmorePay" placeholder="<?= lang('card_type') ?>"/>';
            fieldHTML += '<select name="ccc_type['+x+']" id="pcc_type_'+x+'"class="form-control pcc_type addmorePay" placeholder="<?= lang('card_type') ?>">'; 
            fieldHTML += '<option value=""><?= lang("select_card_type"); ?></option>'; 
            fieldHTML += '<option value="Visa"><?= lang("Visa"); ?></option>';                                                         
            fieldHTML += '<option value="MasterCard"><?= lang("MasterCard"); ?></option>'; 
            fieldHTML += '<option value="Maestro"><?= lang("Maestro"); ?></option>'; 
            fieldHTML += '<option value="Amex"><?= lang("Amex"); ?></option>';                                                             
            fieldHTML += '<option value="Rupay"><?= lang("Rupay"); ?></option>'; 
            fieldHTML += '<option value="Diners"><?= lang("Diners"); ?></option>';
            
            fieldHTML += '</select>';  
            fieldHTML += '</div>';                                                
            fieldHTML += '</div>';
            
            fieldHTML += '<div class="col-md-2">';
            fieldHTML += '<div class="form-group">';
            fieldHTML += '<select name="ccc_edc['+x+']" id="pcc_edc_'+x+'" class="form-control pcc_edc" placeholder="<?= lang('card_edc') ?>">';
            fieldHTML += '<option value=""><?= lang("select_edc"); ?></option>';
            fieldHTML +=  '<option value="deutsche"><?= lang("DEUTSCHE"); ?></option>';
            fieldHTML +=  '<option value="yes"><?= lang("YES"); ?></option>';                                      
            fieldHTML += '</select>';                                  
            fieldHTML += '</div>';
            fieldHTML += '</div>'
            
            fieldHTML += '<div class="col-md-2">';                                                                
            fieldHTML += '<div class="form-group">';                                                      
            fieldHTML += '<input name="ccc_month['+x+']" type="text" id="pcc_month_'+x+'"  class="form-control pcc_type cmonth addmorePay kb-pad" placeholder="<?= lang('month') ?>">';    
            fieldHTML += '</div>'; 
            fieldHTML += '<label id="pcc_month_'+x+'-error" for="pcc_month_'+x+'"></label>';                                               
            fieldHTML += '</div>';                                                             
            fieldHTML += '<div class="col-md-2">';                                                                  
            fieldHTML += '<div class="form-group">';                                                                  
            fieldHTML += '<input type="text" name="ccc_year['+x+']" id="pcc_year_'+x+'"class="form-control pcc_type cyear addmorePay kb-pad" placeholder="<?= lang('year') ?>">'; 
            fieldHTML += '</div>';                                                           
            fieldHTML += '</div>';
            fieldHTML += '<div class="col-md-3">';     
            fieldHTML += '<div class="form-group">';                                                            
            fieldHTML += '<input name="ccc_cvv2['+x+']" type="text" id="pcc_cvv2_'+x+'"class="form-control addmorePay kb-pad" placeholder="<?= lang('cvv2') ?>"/>'; 
            fieldHTML += '</div>';                                                           
            fieldHTML += '</div>';
            fieldHTML += '</div>';                                                           
            fieldHTML += '</div>';
            fieldHTML += '<div class="pcheque_'+x+'" style="display:none;">';
            fieldHTML += '<div class="form-group"><?= lang("cheque_no", "cheque_no_'+x+'"); ?>';                                                            
            fieldHTML += '<input name="ccheque_no['+x+']" type="text" id="cheque_no_'+x+'"class="form-control cheque_no addmorePay kb-text" maxlength="6"/>';                                            
            fieldHTML += '</div>';
            fieldHTML += '</div>';                                                 
            fieldHTML += '<div class="form-group note">';  
            fieldHTML += '<?= lang('payment_note', 'payment_note'); ?>';                                                    
            fieldHTML += '<textarea name="payment_note['+x+']" id="payment_note_'+x+'"class="pa form-control kb-text payment_note"></textarea>'; 
            fieldHTML += '</div>';                                                           
            fieldHTML += '</div>';
            fieldHTML += '</div>';                                                           
            fieldHTML += '</div>';                                               
            fieldHTML += '</div>';                                                           
            // Add field html
            // add year list using jquery
            
            var first_amount = parseInt($('#amount_1').val());  
            //alert('first_amount :' + first_amount);
            var gtotal = parseInt($('#gtotal').text().replace(/,/g, ''));
            var remaining_total;
            if(x == 2){
           remaining_total = parseInt(gtotal - first_amount);
                //alert('remaining_total :'+remaining_total);
            }else{
                var total_amount_added = 0;
                for(i=1; i<=x-1; i++){  
                            var amtt = $('#amount_'+i).val();
                            if(typeof amtt === "undefined")
                            {
                                var amtt = '0';   
                            }
                            else{ 
                                
                            }
                            total_amount_added = parseInt(total_amount_added) + parseInt(amtt);  
                            remaining_total = gtotal - total_amount_added;  
                            
                }
            }
            
                            
            if(remaining_total <= 0){
                bootbox.alert("Total amount is added for payment, so no more payment method allowed");
                  return false;
            }
            
            
            $(wrapper).append(fieldHTML);
            
            if(remaining_total > 0){
                //alert(x);
        $('#amount_'+x).val(remaining_total);
                $('#amount_'+x).focus();
            }          
           $('#paymentModal').css('overflow-y', 'scroll');
           
        $('.addmorePay').each(function () {
    
//           $(document).bind('click', '#amount_+x+', function () {
//        display_keyboards();
//              $('#amount_+x+').addClass('kb-text');
//                      
//           });
           ignore: ".ignore",
           $('.cardno').bind('keyup blur',function(){ 
            var node = $(this);
            node.val(node.val().replace(/[^0-9]+/i, '') ); }
           );
   
           $(this).rules("add", {
           required: true
           });
        $('input[name="amountc['+x+']"]').rules("add", {
           required:true               
          
           });
           
        $('input[name="ccc_no['+x+']"]').rules("add", {
           required:true,              
           creditcard: true,
           //Is16DigitNumeric:true
           messages:{
               required:"Please enter card number",
               creditcard:"Please enter valid card no"
           }
        });
        
        
        $('input[name="ccc_holer['+x+']"]').rules("add", {
           required:true,              
           namecharcheck:true,
           messages:{
               required:"Holder name can't be left empty",
               namecharcheck:"Please enter valid name"
           }
        });
        
        $('input[name="ccc_edc['+x+']"]').rules("add", {
           required:true,                 
           messages:{
               required:"Please Select EDC",
           }
        });
        
        $('input[name="ccc_cvv2['+x+']"]').rules("add", {
           required:true,              
           digits:true,
           checkApprovalNumber:true,
           messages:{
               required:"Approval number can't be left empty",
               digits:"Please enter digits only"
           }
        });
           
            $('input[name="ccc_month['+x+']"]').rules("add", {
                required:true,            
                cc_month:true ,
                cc_valid_month:true,
                messages:{
                     required: "expiration month can't be left empty",
                     cc_month:"CC expiry month should be between 01 and 12"
                }   
            });
          
            $('input[name="ccc_year['+x+']"]').rules("add", {
                required:true,             
                checkYear:true,
                cc_valid_year:true,
                messages:{
                     required: "expiration year can't be left empty",
                     checkYear:"CC expiry year >= current year "
                }
            });
         

            $('input[name="cpaying_gift_card_no['+x+']"]').rules("add", {
                required:true,             
                messages:{
                     required: "Please enter credit note number",
                }
            });
        });

           
            
        x++; //Increment field counter
            fieldcount++;      
        }
         else{
              bootbox.alert('<?= lang('max_reached') ?>');
                return false;
        }
    });

    
    $(wrapper).on('click', '.remove_button', function(e){ //Once remove button is clicked
        e.preventDefault();
        //var total_paying = calculateTotalPaying(); 
        
        total_paying = $('#total_paying').text().replace(',','');
        var id = $(this).attr('id').split('_')[2];
        var focusid = parseInt(id - 1);
        var balance_amount = 
            total_paying -= $('#amount_'+id).val();
            $('#total_paying').text(formatMoney(total_paying));
            $('#balance').text(formatMoney(grand_total - total_paying));
            
            $('#amount_'+id).val('');
            $('#amount_val_'+id).val('');
            $('#paid_by_val_'+id).val('');
            var payment_method = $('#paid_by_'+id).find(":selected").val();
                if(payment_method == "credit_voucher"){
                    //localStorage.setItem('gc_status','valid');
                    if($('#gift_card_no_'+id).parent('.form-group').hasClass('error')){
                        $('#gift_card_no_'+id).parent('.form-group').removeClass('error');
                        $('#submit-sale').prop('disabled', false);
                    }
                }
            $(this).parent('div').remove(); //Remove field html
            $('#amount_'+focusid).focus();
            //sx--; //Decrement field counter
            
            fieldcount--;
    });
    
//  end by vikas singh 





//              $(document).on('click', '.addButton', function () {                 
//                      var pay = [];                               
//                      if (pa <= 5) {
//                          if(pa == 2){
//                              payment_method = $('#paid_by_1, #pcc_type_1').select2("val");
//                          }else{
//                              payment_method = $('#paid_by_' + parseInt(pa-1) +', #pcc_type_' + parseInt(pa-1)).select2("val");
//                          }
//                          $("#pcc_card_" + pa).select2().select2("val", 'CC')                                                 
//                          $('#paid_by_1, #pcc_type_1').select2('destroy');
//                          $('#pcc_card_1').select2('destroy');    
//                          $('#pcc_card_1').addClass('form-control');
//                          if(localStorage.getItem("pay") === null){
//                              pay.push(payment_method);
//                          }else{
//                              pay = JSON.parse(localStorage.getItem("pay"));
//                              pay.push(payment_method);
//                          }
//                                              
//                          localStorage.setItem("pay", JSON.stringify(pay));
//                                                        
//                                                        $('input[name="ccc_no"]').rules('add',{required:true});
//                          //$('pcc_no_'+pa).messages('add',{required:'credit card number enter kar'});
//                          var first_amount = parseInt($('#amount_1').val());
//                          
//                          var gtotal = parseInt($('#gtotal').text().replace(/,/g, ''));
//                                                        alert('gtotal :' +gtotal);
//                          var remaining_total;
//                          if(pa == 2){
//                                                                
//                              remaining_total = parseInt(gtotal - first_amount);
//                                                                alert('remaining_total 2:' + remaining_total);
//                          }else{
//                              var total_amount_added = 0;
//                              for(i=1;i<=pa-1;i++){                                   
//                                  total_amount_added = parseInt(total_amount_added + parseInt($('#amount_'+i).val()));
//                                  remaining_total = parseInt(gtotal - total_amount_added);
//                                  
//                              }
//                          }
//                           
//                          if(remaining_total <= 0){
//                              return;
//                          }
//                          var phtml = $('#payments').html(),
//                                  update_html = phtml.replace(/_1/g, '_' + pa);
//                                  
//                          pi = 'amount_' + pa;
//                          $('#multi-payment').append('<button type="button" class="close close-payment" id="cl_row_' + pa + '" style="margin: -10px 0px 0 0;"><i class="fa fa-2x">&times;</i></button>' + update_html);
//                          $('#paid_by_1, #pcc_type_1, #paid_by_' + pa).select2({minimumResultsForSearch: 6});
//                          //$('#paid_by_' + pa + ', #pcc_type_' + pa).select2('val','ss');
//                          alert('remaining_total ' + remaining_total);
//                          if(remaining_total > 0){
//                                                                alert('pa:'+pa);
//                                                                alert('remaining_total ' + remaining_total);
//                              $('#amount_'+pa).val(remaining_total)
//                          }
//                          $('#'+pi).focus();                          
//                          read_card();
//                          /*
//                          var pay2 = localStorage.getItem("pay"); 
//                          var pay3 = JSON.parse(pay2);
//                          var options = [];
//                          if(remaining_total > 0){
//                              var j;
//                              $.each(pay3,function(index,val){
//                                  var select = document.getElementById("paid_by_"+pa);
//                                  for(i=0;i<select.length;i++){
//                                      if(val != 'CC'){
//                                          if (select.options[i].value== val) {
//                                              select.remove(i);
//                                          }else{      
//                                              //$('#paid_by_' + pa + ', #pcc_type_' + pa).select2('val',select.options[i].value);
//                                              //setPaymentOptions(select.options[i].value,pa);
//                                          }
//                                      }
//                                      
//                                  }f
//                                  
//                                  if((val == 'CC') && (index == 0)){
//                                          setPaymentOptions("cash",pa);
//                                  }
//                                  
//                              }); 
//                          }
//                          */
//                          pa++;
//                      } else {
//                            bootbox.alert('<?= lang('max_reached') ?>');
//                            return false;
//                      }
//                      $('#paymentModal').css('overflow-y', 'scroll');
//              
//                });

                
                function setPaymentOptions(val,id){
                            var p_val = val,
                           // id = $(this).attr('id'),
                                                        pa_no = id;
                            $('#rpaidby').val(p_val);
                            if (p_val == 'cash' || p_val == 'other') {
                                $('.pcheque_' + pa_no).hide();
                                $('.pcc_' + pa_no).hide();
                                $('.pcash_' + pa_no).show();
                                //$('#payment_note_' + pa_no).focus();
                                $('#payment_note_' + pa_no).closest('.note').hide();
                                
                            } else if (p_val == 'CC' || p_val == 'stripe' || p_val == 'ppp') {
                                $('.pcheque_' + pa_no).hide();
                                $('.pcash_' + pa_no).hide();
                                $('.pcc_' + pa_no).show();
                                $('#swipe_' + pa_no).focus();
                                $('#payment_note_' + pa_no).closest('.note').show();
                                
                            } else if (p_val == 'Cheque') {
                                $('.pcc_' + pa_no).hide();
                                $('.pcash_' + pa_no).hide();
                                $('.pcheque_' + pa_no).show();
                                $('#cheque_no_' + pa_no).focus();
                            } else {
                                $('.pcheque_' + pa_no).hide();
                                $('.pcc_' + pa_no).hide();
                                $('.pcash_' + pa_no).hide();
                                
                            }
                            if (p_val == 'credit_voucher') {
                                $('.gc_' + pa_no).show();
                                $('.ngc_' + pa_no).hide();
                                $('#gift_card_no_' + pa_no).focus();
                                $('#payment_note_' + pa_no).closest('.note').show();
                                
                            } else {
                                $('.ngc_' + pa_no).show();
                                $('.gc_' + pa_no).hide();
                                $('#gc_details_' + pa_no).html('');
                                
                            }
                        
                }

                $(document).on('click', '.close-payment', function () {             
                    var id = $(this).attr('id').split('_')[2];
                     //total_paying = $('#total_paying').text().replace(',','');
                    var balance_amount = 
                    total_paying -= $('#amount_'+id).val();
                    $('#total_paying').text(formatMoney(total_paying));
                    $('#balance').text(formatMoney(grand_total - total_paying));
                    $('#amount_'+id).val('');
                    $('#amount_val_'+id).val('');
                    $('#paid_by_val_'+id).val('');
                    var payment_method = $('#paid_by_'+id).find(":selected").val();
                                        
                    if(payment_method == "credit_voucher"){
                                            var classes = $('.gc_' + id).prop("classList");
                                            classes.remove("error");
                                            $('#submit-sale').prop('disabled', false);
                    }
                    var pay = $.parseJSON(localStorage.getItem('pay'));                 
                    var pay = $.grep(pay, function(value) {
                            return value != payment_method;
                    });
                    localStorage.setItem('pay',JSON.stringify(pay));    
                    $(this).next().remove();
                    $(this).remove();
                                        pa--;
                });
                
                /****************added by ajay on 19-08-2016******************/
                $(document).on('focus', '.amount', function () {
                    pi = $(this).attr('id');
                    calculateTotals();
               //      $('.quick-cash').find('.badge').remove();
                }).on('blur', '.amount', function () {
                    // $('.quick-cash').find('.badge').remove();
                    calculateTotals();
                });
                
                
                /*************************************************************/


    function calculateTotals() {  
        var total_paying = 0;
        var i;
        var ia = $(".amount");
        $(".amount").each(function (i) {
            var  val = $(this).val();   
            if(val==''){
                val = 0;
            }
            if($(this).attr('id') !== undefined){
                total_paying += parseFloat(val); 
            }        
        });             

        $('#total_paying').text(formatMoney(total_paying));
            <?php if ($pos_settings->rounding) { ?>
                round_total = roundNumber(gtotal, <?= $pos_settings->rounding ?>);
                var rounding = formatDecimal(0 - (gtotal - round_total));
                $('#balance').text(formatMoney(total_paying - round_total));
                $('#balance_' + pi).val(formatDecimal(total_paying - round_total));
            if(!isNaN(total_paying)){
                    total_paid = total_paying;
            }
        grand_total = round_total;
        <?php } else { ?>
            //console.log('total_paying :' + total_paying + 'gtotal :'+gtotal);
            $('#balance').text(formatMoney(total_paying - gtotal));
            $('#balance_' + pi).val(formatDecimal(total_paying - gtotal));
            total_paid = total_paying;
            grand_total = gtotal;
        <?php } ?>
    }           
                                    


  /*
    $('#add_item').bind('keypress keyup keydown', function (e) {
       // alert("keyboard"+e.keyCode)
        if (e.keyCode == 8) {
            alert("backspave")
            e.preventDefault();
            $(this).autocomplete("search");
        }
    });*/

   
    <?php
    if ($pos_settings->tooltips) {
        echo '$(".pos-tip").tooltip();';
    }
    ?>
    $(document).ready(function () {                 
      /*$(document).on('change', '#add_item', function () {
        //alert("clcik")
        //setAutoComplete();
    });*/
        

    $("#myModal").on("hidden.bs.modal", function () {
        $('#add_item').removeClass('ui-autocomplete-loading');
    });
    $('#payment_note_1').closest('.note').hide();
        //localStorage.removeItem('positems');
        //localStorage.removeItem('gc_status');
        $('#add_item').focus(); 
    });
    $('#product-list, #category-list, #subcategory-list').perfectScrollbar({suppressScrollX: true});
    $('select, .select').select2({minimumResultsForSearch: 6});

    $(document).on('click', '.product', function (e) {                    
        $('#modal-loading').show();
        code = $(this).val(),                     
                wh = $('#poswarehouse').val(),
                cu = $('#poscustomer').val(),  
                // *** Walk_customer added By Anil ***
                walk_customer = $('#enable_walkcustomer').val();                         
                    //alert(cu);

                $.ajax({
                    type: "get",
                    url: "<?= site_url('pos/getProductDataByCode') ?>",
                    data: {code: code, warehouse_id: wh, customer_id: cu},
                    dataType: "json",
                    success: function (data) {
                        e.preventDefault();
                        if (data !== null) { //bootbox.alert(JSON.stringify(data));
                            //walk_customer added by Anil
                            if (walk_customer == '1' && data.customer_id == '1') {
                                bootbox.dialog({
                                    title: "Please Fill Customer Name and Mobile Number",
                                    message: '<div class="row">  ' +
                                            '<div class="col-md-12"> ' +
                                            '<form class="form-horizontal" role="form" data-toggle="validator">' +
                                            '<div class="form-group"> ' +
                                            '<label class="col-md-2 control-label" for="users">Name</label> ' +
                                            '<div class="col-md-10"> ' +
                                            '<input id="name" name="name" type="text" data-minlength="3" onkeypress="return alphanumeric_only(event)" placeholder="Your Name" class="form-control input-md" required="required">' +
                                            '</div></div> ' +
                                            '<div class="form-group"> ' +
                                            '<label class="col-md-2 control-label" for="psw">Mobile</label> ' +
                                            '<div class="col-md-10">' +
                                            '<input id="mobile" name="mobile" type="text" maxlength="10"  onkeypress="return isNumber(event)" placeholder="Your Mobile" class="form-control input-md" required="required">  ' +
                                            '</div> </div>' +
                                            '</form> </div>  </div>',
                                    buttons: {
                                        success: {
                                            label: "Submit",
                                            className: "btn-success",
                                            callback: function () {
                                                var name = $("#name").val();
                                                
                                                var mobile = $('#mobile').val();
                                                if ((name == null) || (name == undefined) || (name == '')) {
                                                    bootbox.alert("Name Required..");
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
                                                if(name.charAt(0)==9 || name.charAt(0)==8 || name.charAt(0)==7 || name.charAt(0)==6 || name.charAt(0)==5 || name.charAt(0)==4 || name.charAt(0)==3 || name.charAt(0)==2 || name.charAt(0)==1 || name.charAt(0)==0)
                                                {
                                                    bootbox.alert("In Name First Character Never be Numeric..");
                                                    return false;
                                                }
                                                if ((mobile == null) || (mobile == undefined) || (mobile == '')) {
                                                    bootbox.alert("Mobile Number Required..");
                                                    return false;
                                                }
                                                if (!/^\d{10}$/.test(mobile)) {
                                                    bootbox.alert("Invalid Mobile Number..");
                                                    return false;

                                                }

                                                if(mobile.charAt(0)==0 || mobile.charAt(0)==1 || mobile.charAt(0)==2 || mobile.charAt(0)==3 || mobile.charAt(0)==4 || mobile.charAt(0)==5 || mobile.charAt(0)==6)

                                                {
                                                    bootbox.alert("Mobile Number First Digit Should be Start form 9,8,7");
                                                    return false;
                                                }
                                                
                                                                                                    
                    $('#poscustomer').val(name);
                     var p1= $("#name").val(name);
                                                
                    $.ajax({
                        type: "POST",
                        url: site.base_url + 'pos/addCustomerDetails',
                        data: {"name": name, "mobile": mobile},
                        datatype: "json",
                        success: function (cdata) {
                            //console.log(cdata);
                            var pdata = jQuery.parseJSON(cdata);
                            if (pdata !== null) {
                                                        
                                 $('#poscustomer').val(name);
                                add_invoice_item(data);
                                $('#modal-loading').hide();

                            } else {

                                return;
                            }
                        }
                    });

                }
            }
        }
    });
        $('#modal-loading').hide();
    }else {                     
        add_invoice_item(data);
        $('#modal-loading').hide();
    }
}
else {

    bootbox.alert('<?= lang('no_match_found') ?>');
    $('#modal-loading').hide();
}
    }
    });
    });

                $(document).on('click', '.category', function () {
                    if (cat_id != $(this).val()) {
                        $('#open-category').click();
                        $('#modal-loading').show();
                        cat_id = $(this).val();
                        $.ajax({
                            type: "get",
                            url: "<?= site_url('pos/ajaxcategorydata'); ?>",
                            data: {category_id: cat_id},
                            dataType: "json",
                            success: function (data) {
                                $('#item-list').empty();
                                var newPrs = $('<div></div>');
                                newPrs.html(data.products);
                                newPrs.appendTo("#item-list");
                                $('#subcategory-list').empty();
                                var newScs = $('<div></div>');
                                newScs.html(data.subcategories);
                                newScs.appendTo("#subcategory-list");
                                tcp = data.tcp;
                            }
                        }).done(function () {
                            p_page = 'n';
                            $('#category-' + cat_id).addClass('active');
                            $('#category-' + ocat_id).removeClass('active');
                            ocat_id = cat_id;
                            $('#modal-loading').hide();
                        });
                    }
                });
                $('#category-' + cat_id).addClass('active');

                $(document).on('click', '.subcategory', function () {
                    if (sub_cat_id != $(this).val()) {
                        $('#open-subcategory').click();
                        $('#modal-loading').show();
                        sub_cat_id = $(this).val();
                        $.ajax({
                            type: "get",
                            url: "<?= site_url('pos/ajaxproducts'); ?>",
                            data: {category_id: cat_id, subcategory_id: sub_cat_id, per_page: p_page},
                            dataType: "html",
                            success: function (data) {
                                $('#item-list').empty();
                                var newPrs = $('<div></div>');
                                newPrs.html(data);
                                newPrs.appendTo("#item-list");
                            }
                        }).done(function () {
                            p_page = 'n';
                            $('#subcategory-' + sub_cat_id).addClass('active');
                            $('#subcategory-' + osub_cat_id).removeClass('active');
                            $('#modal-loading').hide();
                        });
                    }
                });

                $('#next').click(function () {
                    if (p_page == 'n') {
                        p_page = 0
                    }
                    p_page = p_page + <?php echo $pos_settings->pro_limit; ?>;
                    if (tcp >= <?php echo $pos_settings->pro_limit; ?> && p_page < tcp) {
                        $('#modal-loading').show();
                        $.ajax({
                            type: "get",
                            url: "<?= site_url('pos/ajaxproducts'); ?>",
                            data: {category_id: cat_id, subcategory_id: sub_cat_id, per_page: p_page},
                            dataType: "html",
                            success: function (data) {
                                $('#item-list').empty();
                                var newPrs = $('<div></div>');
                                newPrs.html(data);
                                newPrs.appendTo("#item-list");
                            }
                        }).done(function () {
                            $('#modal-loading').hide();
                        });
                    } else {
                        p_page = p_page - <?php echo $pos_settings->pro_limit; ?>;
                    }
                });

                $('#previous').click(function () {
                    if (p_page == 'n') {
                        p_page = 0;
                    }
                    if (p_page != 0) {
                        $('#modal-loading').show();
                        p_page = p_page - <?php echo $pos_settings->pro_limit; ?>;
                        if (p_page == 0) {
                            p_page = 'n'
                        }
                        $.ajax({
                            type: "get",
                            url: "<?= site_url('pos/ajaxproducts'); ?>",
                            data: {category_id: cat_id, subcategory_id: sub_cat_id, per_page: p_page},
                            dataType: "html",
                            success: function (data) {
                                $('#item-list').empty();
                                var newPrs = $('<div></div>');
                                newPrs.html(data);
                                newPrs.appendTo("#item-list");
                            }

                        }).done(function () {
                            $('#modal-loading').hide();
                        });
                    }
                });
                
//        $(document).on('input paste change','.cardno',function(){
//                
//                var re = {
//                    electron: /^(4026|417500|4405|4508|4844|4913|4917)\d+$/,
//                    maestro: /^(5018|5020|5038|5612|5893|6304|6759|6761|6762|6763|0604|6390)\d+$/,
//                    dankort: /^(5019)\d+$/,
//                    interpayment: /^(636)\d+$/,
//                    unionpay: /^(62|88)\d+$/,
//                    visa: /^4[0-9]{12}(?:[0-9]{3})?$/,
//                    mastercard: /^5[1-5][0-9]{14}$/,
//                    amex: /^3[47][0-9]{13}$/,
//                    diners: /^3(?:0[0-5]|[68][0-9])[0-9]{11}$/,
//                    //discover: /^6(?:011|5[0-9]{2})[0-9]{12}$/,
//                    rupay:/(508[5-9][0-9]{12})|(6069[8-9][0-9]{11})|(607[0-8][0-9]{12})|(6079[0-8][0-9]{11})|(608[0-5][0-9]{12})|(6521[5-9][0-9]{11})|(652[2-9][0-9]{12})|(6530[0-9]{12})|(6531[0-4][0-9]{11})/,
//                    jcb: /^(?:2131|1800|35\d{3})\d{11}$/
//                }
//
//                for(var key in re) {
//                    if(re[key].test($(this).val())) {
//                        var id = $(this).attr('id').split('_').pop();
//                        //$('#pcc_type_'+id).select2('data', {text:key.charAt(0).toUpperCase() + key.slice(1)});
//                        $('#pcc_type_'+id).val(key.charAt(0).toUpperCase() + key.slice(1));
//                        $('#pcc_type_'+id).attr('readonly',true);
//                    }
//                }
//        });

                $(document).on('change', '.paid_by', function () {       
                    
                    /*************Added by ajay***********/
                    self = $(this);
                    var choosen = $(this).val(); 
                    var parts1 = $(this).attr('id').split('_');
                    var paid_parts = parts1[parts1.length - 1];
                    var payment_type = $('#paid_by_'+paid_parts+' :selected').val();
                   if(payment_type === 'credit_voucher'){
                       $("#gift_card_no_"+paid_parts).val("");
                       $("#paying_gift_card_no_val_"+paid_parts).val("");
                   }
                   if(payment_type === 'CC'){
                        $("#cc_no_val_"+paid_parts).val("");
                        $("#cc_holder_val_"+paid_parts).val("");
                        $("#cc_month_val_"+paid_parts).val("");
                        $("#cc_year_val_"+paid_parts).val("");
                        $("#cc_type_val_"+paid_parts).val("");
                        $("#cc_card_type_val_"+paid_parts).val("");
                        $("#cc_cvv2_val_"+paid_parts).val("");
                        $("#payment_note_val_"+paid_parts).val("");
                   }
                   
                    $('#submit-sale').prop('disabled', false);       
                    $('select.paid_by').not(self).each(function(){
                        //if(($(this).val() !== 'CC')){
                        if($.inArray($(this).val(),['CC','credit_voucher']) == -1){
                            if($(this).val() === choosen){                             
                                if(self.attr('id') === 'paid_by_1'){
                                    if($(this).val() !== 'ss'){
                                        bootbox.alert('Payment method is already selected');
                                        $('#paid_by_1').select2("val","ss");
                                    }
                                }else{
                                    if($(this).val() !== 'ss'){
                                        bootbox.alert('Payment method is already selected');
                                        $('#'+self.attr('id')).val('ss').trigger('change.select2');
                                    }
                                }
                            }
                        }
                    });              
                    /************************************************/
                    var p_val = $(this).val(),
                            id = $(this).attr('id'),
                            pa_no = id.substr(id.length - 1);
                            $('#'+self.attr('id')).val(p_val).trigger('change.select2');
                         
                    if(pa_no == 1){
                        if($(this).parent('form-group').hasClass('error')){
                            $(this).parent('form-group').removeClass('error');
                        }
                    }
                    
                    var classes = $('.gc_' + pa_no).prop("classList");
                    if($.inArray('error',classes) > -1){
                        classes.remove("error");
                        $('#submit-sale').prop('disabled', false);
                    }
                    
                    $('#rpaidby').val(p_val);
                    
                    if (p_val == 'cash' || p_val == 'other') {
                        $('.pcheque_' + pa_no).hide();
                        $('.pcc_' + pa_no).hide();
                        $('.pcash_' + pa_no).show();
                        $('#payment_note_' + pa_no).closest('.note').hide();
                        
                    } else if (p_val == 'CC' || p_val == 'stripe' || p_val == 'ppp') {
                        $('.pcheque_' + pa_no).hide();
                        $('.pcash_' + pa_no).hide();
                        $('.pcc_' + pa_no).show();
                        $('#swipe_' + pa_no).focus();
                        $('#payment_note_' + pa_no).closest('.note').show();
                         
                    } else if (p_val == 'Cheque') {
                        $('.pcc_' + pa_no).hide();
                        $('.pcash_' + pa_no).hide();
                        $('.pcheque_' + pa_no).show();
                        $('#cheque_no_' + pa_no).focus();
                        
                    } else {
                        $('.pcheque_' + pa_no).hide();
                        $('.pcc_' + pa_no).hide();
                        $('.pcash_' + pa_no).hide();
                    }
                    
                    if (p_val == 'credit_voucher') {
                       
                        var cust_id = $('#poscustomer').val();
                        $.ajax({
                            url:'<?php echo base_url('pos/customerCreditNotes'); ?>',
                            type:"POST",
                            data:{'customer_id':cust_id},
                            success:function(data){
                                var res = $.parseJSON(data);
                                var cndata = [];
                                var obj;
                                console.log(JSON.stringify(res));
                                $.each(res,function(i,v){
                                    obj = {'id':v.biller_id + '/CN/'+v.card_no,'text':v.biller_id + '/CN/'+v.card_no+' Balance : '+v.balance+' Expiry : '+v.expiry};
                                    cndata.push(obj);
                                });
                                $('#gift_card_no_'+pa_no).select2('destroy').empty().select2({placeholder: 'Select Credit Note',data: cndata}).trigger("change");
                            }
                        });
                        
                        $('.gc_' + pa_no).show();
                        $('.ngc_' + pa_no).hide();
                        $('#gift_card_no_' + pa_no).focus();
                        $('#payment_note_' + pa_no).closest('.note').show();
                         
                    } else {
                        $('.ngc_' + pa_no).show();
                        $('.gc_' + pa_no).hide();
                        $('#gc_details_' + pa_no).html('');
                       
                    }
                    
                    //$('#'+self.attr('id')).val(p_val).trigger('change.select2');
                });
                
                 
    $('#suspend').click(function () {
        if (count <= 1) {
            bootbox.alert('<?= lang('x_suspend'); ?>');
            return false;
        } else {
            $('#susModal').modal();
        }
    });
    $('#suspend_sale').click(function () {        

        ref = $('#reference_note').val();
        if (!ref || ref == '') {
            bootbox.alert('<?= lang('type_reference_note'); ?>');
            return false;
        } else {
            suspend = $('<span></span>');
        <?php if ($sid) { ?>
                suspend.html('<input type="hidden" name="delete_id" value="<?php echo $sid; ?>" /><input type="hidden" name="suspend" value="yes" /><input type="hidden" name="suspend_customer" value="<?=$customer->name?>" /><input type="hidden" name="suspend_note" value="' + ref + '" />');
        <?php } else { ?>
                suspend.html('<input type="hidden" name="suspend" value="yes" /><input type="hidden" name="suspend_note" value="' + ref + '" />');
        <?php } ?>
            suspend.appendTo("#hidesuspend");
            $(this).attr('disabled', true);
            $('#total_items').val(count - 1);
            $('#pos-sale-form').submit();

        }
    });
});
<?php if ($pos_settings->java_applet) { ?>
                $(document).ready(function () {
                    $('#print_order').click(function () {
                        printBill(order_data);
                    });
                    $('#print_bill').click(function () {
                        printBill(bill_data);
                    });
                });
<?php } else { ?>
                $(document).ready(function () {
                    $('#print_order').click(function () {
                        Popup($('#order_tbl').html());
                    });
                    $('#print_bill').click(function () {
                        Popup($('#bill_tbl').html());
                    });
                });
<?php } ?>
            $(function () {
                $(".alert").effect("shake");
                setTimeout(function () {
                    $(".alert").hide('blind', {}, 500)
                }, 8000);
<?php if ($pos_settings->display_time) { ?>
                    var now = new moment();
                    $('#display_time').text(now.format((site.dateFormats.js_sdate).toUpperCase() + " HH:mm"));
                    setInterval(function () {
                        var now = new moment();
                        $('#display_time').text(now.format((site.dateFormats.js_sdate).toUpperCase() + " HH:mm"));
                    }, 1000);
<?php } ?>
            });
<?php if (!$pos_settings->java_applet) { ?>
                function Popup(data) {
                    var mywindow = window.open('', 'sma_pos_print', 'height=500,width=300');
                    mywindow.document.write('<html><head><title>Print</title>');
                    mywindow.document.write('<link rel="stylesheet" href="<?= $assets ?>styles/helpers/bootstrap.min.css" type="text/css" />');
                    mywindow.document.write('</head><body >');
                    mywindow.document.write(data);
                    mywindow.document.write('</body></html>');
                    mywindow.print();
                    mywindow.close();
                    return true;
                }
<?php } ?>

 
    $(document).on('keyup blur','.amount',function(){        
        var node = $(this);
        node.val(node.val().replace(/[^0-9\.]+/i, '') ); }
    );
    
    var initialLoad = true;
    $(document).ready(function() {
        $(".multi_gc").on("click", function () { $(this).select2("open"); });
        $('.payment').children().find('input,select,textarea').each(function(){
            $(this).val('');
        });
        $('#pos-payment-form').trigger('reset');
        $('#pos-sale-form').trigger("reset");

        <?php if(!$sid){ ?>
        //     positems = JSON.parse(localStorage.getItem('positems'));
        //     $.each(positems, function () {
        //     var item = this;
        //     var item_id3 = item.item_id;
        //        if(item_id3 >0)
        //        {
        //         $.ajax({    
        //         type: 'get',
        //         url: '<?= site_url('sales/updatecart_del'); ?>',
        //         dataType: "json",
        //         data: {
        //             item_id2: item_id3                  
        //         },
        //         success: function (data) { 
        //            return true;
        //         }
        //     });
        //   }
        // }); 
            //localStorage.removeItem('positems');
        <?php }?>
        //localStorage.removeItem('poscustomer');
        $('#order_discount_input').focusout(function(){
            if($(this).val() === '0'){
                $('#discout_reason_input').attr('readonly',true);
            }else{
                $('#discout_reason_input').attr('readonly',false);
            }
        });
        
        //$('.pcc_type').prop('disabled',true);
        $('.wrapper').perfectScrollbar();
        localStorage.removeItem('posdiscountreason');
        localStorage.removeItem('posdiscountpercent');
        $(window).bind("beforeunload", function() {  
            if(initialLoad){
                //localStorage.removeItem('positems');
                localStorage.removeItem('poscustomer');
                window.sessionStorage.clear();
            }
            localStorage.removeItem('posdiscountreason');
            localStorage.removeItem('posdiscountpercent');  
        });
       $('#user_logout').on('click',function(){
			 positems = JSON.parse(localStorage.getItem('positems'));
               $.each(positems, function () {
               var item = this;
               var item_id3 = item.item_id;
			  
                if(item_id3 >0)
                {
                 $.ajax({    
                 type: 'get',
                 url: '<?= site_url('sales/updatecart_del'); ?>',
                 dataType: "json",
                data: {
                     item_id2: item_id3                  
                 },
                 success: function (data) { 
                    return true;
                 }
             });
           }
         }); 
            localStorage.removeItem('positems');
            localStorage.removeItem('poscustomer');
            localStorage.removeItem('poswarehouse');
        });	
        //alert(localStorage.getItem('poscustomer'));
        
        $("#pos-payment-form").validate({
           
           rules:{
                     
              'paying_gift_card_no[0]':{
                            required:true
                            
                        },
               'cheque_no[0]':{
                            required:true
                            
                    },         
               'ccc_no[0]':{
                            required:true,
                            creditcard: true,
                            discover:true
                            //creditcardtypes: function(){ return $('#pcc_type_1').val(); }
                        },
                'ccc_holer[0]':{
                            required:true,
                            namecharcheck:true,
                },
                'ccc_month[0]':{
                            required:true,
                            cc_month:true,
                            cc_valid_month:true
                        },
                'ccc_year[0]':{
                            required:true,
                            cc_year:true,
                            checkYear:true,
                            cc_valid_year:true
                        },
                'ccc_cvv2[0]':{
                    required:true,
                    digits:true,
                    checkApprovalNumber:true
                },
                'paying_gift_card_no[0]':{
                    required:true
                }
                           
           },
           messages:{
                'paying_gift_card_no[0]':{
                            required:'Please enter credit note'
                            
                        },
               'cheque_no[0]':{
                            required:'Please enter cheque no.'
                            
                    },
               'ccc_no[0]':{required:'Please enter card number',
                creditcard:'Please enter valid card no'
                   //creditcardtypes:'Not valid credit card type'
               },
               'ccc_holer[0]':{required:"Card holder must not be empty",
                   namecharcheck:"Please enter valid name"
               },
               'ccc_month[0]':{
                            required:"Enter month of expire"
                        },
               'ccc_year[0]':{
                          required:"Enter year of expire"
               },
               'ccc_cvv2[0]':{
                    required:"Approval number can't be left empty",
                    digits:"Only digits are allowed",
                    
                },
                'paying_gift_card_no[0]':{
                    required:"Please enter credit note number"
                }
                
           },
            submitHandler:function(form){
                var cn_bal_error = [];
                var error = [];
                var total_paying = 0;
                var i;
                $(".amount").each(function (i) {
                    var id = $(this).attr('id');
                    var  val = parseFloat($(this).val());   
                    //alert('val :'+val+'type of val:'+typeof(val));
                    if(val==''){
                        val = 0;
                    }
                    if(id !== undefined){
                        total_paying += val; 
                        //alert('total_paying :'+total_paying+'typeof'+typeof(total_paying));
                    }
                    
                });       
                
                var cns = [];
                var ncn = [];
                var i = 0;
                $('.gift_card_no').each(function(){
                    var atr = $(this).attr('id');
                    var id = $(this).attr('id').split('_').pop();
                    var s2id = 's2id_gift_card_no_'+id;
                    if(atr != s2id){
                        //alert('attribute :'+atr);
                        var payment_method = $('#paid_by_'+id).val();
                        var card_no = $('#gift_card_no_'+id).val();    
                        if(card_no){
                            cns[i] = card_no;
                            i++;
                        }
                        //alert('payment_method :'+payment_method);
                        if((card_no == '') && (payment_method === 'credit_voucher')){
                            ncn.push(id);
                            i++;
                        }
                    }
                });
                //alert('ncn length '+ncn.length);
                if(ncn.length > 0){
                    bootbox.alert("credit note at payment method "+ncn.join(",")+" are left empty");
                    return;
                }
               
                
                $('#submit-sale').prop('disabled', false);
                /**********************credit voucher validation********************/

                // $('.gift_card_no').each(function(){
                //     if($(this).parent('.form-group').hasClass('error')){
                //        error.push($(this).attr('id'));
                //     }                
                //     var parts = $(this).attr('id').split('_');
                //     var id = parts[parts.length - 1];
                //     var cn_balance = parseFloat($('#cn_balance_'+id).val());
                //     var amount_balance = parseFloat($('#amount_'+id).val());
                //     if(cn_balance < amount_balance){
                //        cn_bal_error.push(id);
                //     }
                // });
                // if(error.length > 0){
                //     $('#submit-sale').prop('disabled', true);
                //     return false;     
                // }else{
                //     $('#submit-sale').prop('disabled', false);
                // }
                
                // if(cn_bal_error.length > 0){
                //     bootbox.alert("credit note balance is less than entered amount");
                //     $('#submit-sale').prop('disabled', true);
                //     return false;     
                // }else{
                //     $('#submit-sale').prop('disabled', false);
                // }
                
              
            /*****************************************************************************/
                var pa_methods = [];
                    
        $('select.paid_by').each(function(){
            pa_methods.push($(this).val());
        });
                    
        if(pa_methods.indexOf('ss') > -1){
            bootbox.alert("Please Select an Option");
            return false;
        }
    
 
        <?php for ($j = 1; $j <= 25; $j++) { ?>

                        if($('#paid_by_val_<?= $j ?>').val() != 'cash'){ 
                            
                            if (total_paying > grand_total) {
                                bootbox.alert("<?= lang('paid_g_t_payable'); ?>");
                                return false;
                            }
                        } 
                                                    
                        var ccno = $('#pcc_no_<?= $j ?>').val();
                                                   
        <?php } ?>
//                alert('total paying :' + parseFloat(total_paying) + 'grand total' + parseFloat(grand_total));  
//                return false;
                    
                    if (parseFloat(total_paying) < parseFloat(grand_total)) {                     
                        bootbox.alert("<?= lang('paid_l_t_payable'); ?>");

                        $('#pos_note').val(localStorage.getItem('posnote'));
                        $('#staff_note').val(localStorage.getItem('staffnote'));
                        //$('#submit-sale').text('<?= lang('loading'); ?>').attr('disabled', true);                 
                        return false;
                    }
                    
                    if (parseFloat(total_paying) > parseFloat(grand_total)) {
                        bootbox.alert("<?= lang('paid_g_t_payable'); ?>");

                        $('#pos_note').val(localStorage.getItem('posnote'));
                        $('#staff_note').val(localStorage.getItem('staffnote'));
                        //$('#submit-sale').text('<?= lang('loading'); ?>').attr('disabled', true);                 
                        return false;
                    }
                                
                    var gift_card = $('#gift_card_no_1').val();
                    var pan_max_total = parseInt($('#max_pan_limit').val());

                    if (grand_total > pan_max_total) {

                        bootbox.dialog({
                            title: "Please enter PAN number, grand total > " + pan_max_total,
                            message: '<div class="row">  ' +
                                    '<div class="col-md-12"> ' +
                                    '<form class="form-horizontal" id="form_pan" role="form" data-toggle="validator">' +
                                    '<div class="form-group"> ' +
                                    '<label class="col-md-4 control-label" for="pan_number">PAN NUMBER</label> ' +
                                    '<div class="col-md-8">' +
                                    '<input id="pan_number" name="pan_number" type="text" data-minlength="10" placeholder="PAN number" class="form-control input-md" required="required">  ' +
                                    ' <div class="help-block">Minimum of 10 characters</div>' +
                                    '</div> </div>' +
                                    '</form> </div>  </div>',
                            buttons: {
                                success: {
                                    label: "Submit",
                                    className: "btn-success",
                                    callback: function () {

                                        var pan_number = $('#pan_number').val().trim();
                                        var reg = /[A-Z]{5}\d{4}[A-Z]{1}/;
                                        if (!reg.test(pan_number)) {
                                            bootbox.alert('PAN number must be alphanumeric 10 length in form AAAAL1234D ');
                                            return false;
                                        }

                                        if (pan_number.length != 10) {
                                            bootbox.alert('PAN number must be 10 alphanumeric length');
                                            return false;
                                        }
                                        if ((pan_number == null) || (pan_number == undefined) || (pan_number == '')) {
                                            bootbox.alert("Please enter PAN number");
                                            return false;
                                        } else {
                                            $('#pan_number_hidden').val(pan_number);
                                            posFormSubmit();
                                        }

                                    }
                                }
                            }
                        });
                    } else {
                        if(!isNaN(total_paid)){
                            posFormSubmit();
                        }else{
                            bootbox.alert("<?= lang('paid_l_t_payable'); ?>");
                            $('#pos_note').val(localStorage.getItem('posnote'));
                            $('#staff_note').val(localStorage.getItem('staffnote'));
                            return false;
                        }
                    }
            }
        });
        
        function remove(arr, item) {
            for(var i = arr.length; i--;) {
                if(arr[i] === item) {
                    arr.splice(i, 1);
                }
            }
        }

        $('#add_item').keyboard({
            autoAccept: true,
            alwaysOpen: false,
          //  openOn: 'focus',
          //  usePreview: false,
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
        })
        .autocomplete({
             minLength : 1,
             source: function (request, response) {
                if (!$('#poscustomer').val()) {
                    $('#add_item').val('').removeClass('ui-autocomplete-loading');
                    bootbox.alert('<?= lang('select_above'); ?>');
                    //response('');
                    $('#add_item').focus();
                    $('input[name=add_item]').val('');
                    return false;
                }
              //  setTimeout(function() {
                    $.ajax({
                        type: 'get',
                        url: '<?= site_url('sales/suggestions'); ?>',
                        dataType: "json",
                        data: {
                            term: request.term,
                            warehouse_id: $("#poswarehouse").val(),
                            customer_id: $("#poscustomer").val(),                            
                        },
                        success: function (data) {   
			
                            if (data !== null) { 
                               if (pos_settings.enable_walkcustomer == 1 && $("#poscustomer").val() == '1') {
                                    <?php if($permissions[0]['customers-add']){ ?>
                                        $('#myModal').modal('show').load('<?= site_url('customers/add'); ?>');
                                    <?php }else{?>
                                        bootbox.alert('you are not authorised to add customer');
                                    <?php }?>
                                    $('#add_item').removeClass('ui-autocomplete-loading');
                                    $('#modal-loading').hide();
                                }else { 
                                    response(data);                           
                                 //   $('#add_item').removeClass('ui-autocomplete-loading');
                                    $('#modal-loading').hide();
                                }   
                            }else {
                                $('input[name=add_item]').val('');
                                //$('#add_item').val('');
                                bootbox.alert('<?= lang('no_match_found') ?>');
                                $('#add_item').removeClass('ui-autocomplete-loading');
                                $('#modal-loading').hide();
                            }
                        }
                    });
            },response: function (event, ui) {
                event.preventDefault();  
                //alert(JSON.stringify(ui.content[0]));
                if ($(this).val().length >= 16 && ui.content[0].id == 0) {
                    
                    $('input[name=add_item]').val('');
                    bootbox.alert('<?= lang('no_match_found') ?>', function () {
                        $('#add_item').focus();
                    });
                    
                }
                else if (ui.content.length == 1 && ui.content[0].id != 0) {
                    ui.item = ui.content[0];
                    $(this).data('ui-autocomplete')._trigger('select', 'autocompleteselect', ui);
                    $(this).autocomplete('close');
                }
                else if (ui.content.length == 1 && ui.content[0].id == 0) {
                    
                    $('input[name=add_item]').val('');
                    bootbox.alert('<?= lang('no_match_found') ?>', function () {
                        $('#add_item').focus();
                    });
                }
            },
            select: function (event, ui) {
                event.preventDefault();
		
                 $('input[name=add_item]').val('');
                var item_id1 = ui.item.item_id;
                var quantity1 = ui.item.row.quantity;
                var cart_count1 = ui.item.row.cart_count;
                var cart_qty1 = ui.item.row.cart_qty;
               if(cart_qty1 == 1) {

                $.ajax({    
                    type: 'get',
                    url: '<?= site_url('sales/updatecart'); ?>',
                    dataType: "json",
                    data: {
                        item_id1: item_id1, 
                        quantity1: quantity1,   
                        cart_count1: cart_count1               
                    },
                    success: function (data) { 

                       return true;
                    }
                });
               } 
                if (ui.item.id !== 0) {
                    var row = add_invoice_item(ui.item);
                    if (row)
                        $(this).val('');
                } else {
                    //audio_error.play();
                    bootbox.alert('<?= lang('no_match_found') ?>');
                }
            }
        })
        // position options added after v1.23.4
        .addAutocomplete({
            position : {
                 of: $(window),        // when null, element will default to kb.$keyboard
               /* my : 'left center', // 'center top', (position under keyboard)
                at : 'left center',  // 'center bottom',*/
                my: 'center center',
                at: 'center center',
                collision: 'none'
            }
        }).addTyping();
        
        jQuery.validator.addMethod("Is16DigitNumeric", function(value, element) {
                // allow any non-whitespace characters as the host part
                return this.optional( element ) || /(^|\s)(\d{16})(\s|$)/.test( value );
        }, 'Entered number is not 16 digit only');
        
        jQuery.validator.addMethod("cc_month", function(value, element) {
                // allow any non-whitespace characters as the host part
                return this.optional( element ) || /^(0[1-9]|1[012])$/.test( value );
        }, 'Entered month is not valid card expire month');
        
        jQuery.validator.addMethod("cc_valid_month", function(value, element) {
            var today = new Date();
            var thisYear = today.getFullYear();
            var month = (1 + today.getMonth()).toString();
            var thisMonth = month.length > 1 ? month : '0' + month;
            var id = element.id.split('_').pop();
            //var expMonth = $('#pcc_month_'+id).val();
            //var expYear = value;
            var expYear = $('#pcc_year_'+id).val();  
            var expMonth = value;

            if(expYear !='')
             {
                if(expYear < thisYear)
                {
                    return "Invalid Year";
                }
                else if(expYear == thisYear && expMonth >= thisMonth)
                {  
                    $('#submit-sale').prop('disabled', false);
                    $('#pcc_year_'+id+'-error').removeClass('error');
                    $('#pcc_year_'+id+'-error').text('');
                    //$('#pcc_year_'+id).valid();
                     return true;
                    //$('#pcc_month_'+id).valid();
                    
                }
                else if(expYear > thisYear)
                {
                    //$('#pcc_year_'+id).valid();
                    //$('#pcc_month_'+id).valid();
                     $('#submit-sale').prop('disabled', false);
                    return true;
                }
                else{
                 $('#submit-sale').prop('disabled', true);
                 return false;
             } 
                
             } 
             else{
                 $('#submit-sale').prop('disabled', false);
                 return true;
             }  

            // return (expMonth >= 1 
            //     && expMonth <= 12
            //     && (expYear >= thisYear && expYear < thisYear + 20)
            //     && (expYear == thisYear ? expMonth >= (today.getMonth() + 1) : true));
        }, 'Entered month is not valid');

        
        jQuery.validator.addMethod("cc_valid_year", function(value, element) {
           var today = new Date();
            var thisYear = today.getFullYear();
            var month = (1 + today.getMonth()).toString();
            var thisMonth = month.length > 1 ? month : '0' + month;
             var id = element.id.split('_').pop();
            var expMonth = $('#pcc_month_'+id).val();
            var expYear = $('#pcc_year_'+id).val();
            if(expMonth !='')
             {  
                if(expYear < thisYear)
                {
                    return "Invalid Year";

                }
                else if(expYear == thisYear && expMonth >= thisMonth)
                { 
                   
                    $('#pcc_month_'+id+'-error').removeClass('error');
                    $('#pcc_month_'+id+'-error').text('');
                     $('#submit-sale').prop('disabled', false);
                     return true;
                }
                else if(expYear > thisYear)
                {  
                    
                    $('#pcc_month_'+id+'-error').removeClass('error');
                    $('#pcc_month_'+id+'-error').text('');
                     $('#submit-sale').prop('disabled', false);
                    return true;
                }

                else {
                    
                      
                      $('#pcc_month_'+id+'-error').addClass('error');
                      $('#pcc_month_'+id+'-error').css('display','block');
                      $('#pcc_month_'+id+'-error').text('Entered month is not valid');
                      $('#submit-sale').prop('disabled', true); 
                       return false;
                      
                }
                
             } 
             else{             
                  $('#pcc_month_'+id+'-error').css('display','block');
                  $('#pcc_month_'+id+'-error').addClass('error');
                  $('#pcc_month_'+id+'-error').text('Entered month is not valid');
                   $('#submit-sale').prop('disabled', true);
                  return false;
             }      
        }, '');
        
        jQuery.validator.addMethod("cc_year", function(value, element) { 
                    return this.optional( element ) || /(^|\s)(\d{4})(\s|$)/.test( value );
        }, 'Entered year is not valid card expire year');

        jQuery.validator.addMethod("checkYear", function(value, element) {
            var year = $(element).val();
            return year >= (new Date()).getFullYear();
        }, "Your Card has already Expired");
               
        jQuery.validator.addMethod("discover", function(value, element) {
                if(/^6(?:011|5[0-9]{2})[0-9]{12}$/.test(value)){
                    return false;
                }else{
                    return true;
                }
                //return this.optional( element ) || /^6(?:011|5[0-9]{2})[0-9]{12}$/.test( value );
        }, 'Invalid Card type : Discover');
        
        jQuery.validator.addMethod("checkApprovalNumber", 
            function(value, element) {             
                $.ajax({
                    type:"POST",
                    async: false,
                    url: '<?=  base_url("pos/getApprovalNumberAvaibility")?>', // script to validate in server side
                    data: {approval_no : value},
                    success: function(data) {
                        result = ((data == 1)) ? false : true;
                    }
                });
                return result; 
            }, 
            "This Approval Number is already taken! Try another."
        );

        
        initialLoad = false;
    });
    
    $(document).on('select2-open','select',function(){
        $('.ui-keyboard').hide();
    });
    
    /**********************Added By Ajay To hide credit note details when amount is changed********************/
        // $(document).on('change','.amount',function(e){
        //     e.preventDefault();
        //     var id = $(this).attr('id').split('_').pop();
        //     var payment_type = $('#paid_by_'+id+' :selected').val();
        //     if(payment_type === 'credit_voucher'){
        //         $('#gc_details_' + id).hide();
        //         $('#cv_error_msg_'+ id).find('p').text('');
        //         $('#cv_error_msg_'+ id).hide();
        //         $('#submit-sale').attr('disabled',false);
        //     }
        // });
    
    /******************************************************/
    
     $(document).on('blur','.swipe', function (e) {
        e.preventDefault();
      //  console.log("hello world");
        $('#add_item').focusout();
        var payid = $(this).attr('id');
        id = payid.substr(payid.length - 1);
        var TrackData = $(this).val();
        e.preventDefault();
       
        var p = new SwipeParserObj(TrackData);
        //bootbox.alert($('#pcc_cvv2_1').val());
        //bootbox.alert(JSON.stringify(p));
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
            
            var card_date = $('#pcc_cvv2_'+id).val().trim();
            var s1 = card_date.split("^");
            var card_dt = p.input_trackdata_str.split("^");
            var c_num = card_dt[0].split("B");
            $('#pcc_no_' + id).val(c_num[1]).trigger('change');
            $('#cc_no_val_'+id).val(c_num[1]);
            $('#pcc_holder_' + id).val(card_dt[1].replace('/','')).trigger('change');
            $('#cc_holder_val_'+id).val(card_dt[1]);
            $('#pcc_month_'+id).val(p.exp_month).trigger('change');
            $('#cc_month_val_'+id).val(p.exp_month);
            $('#pcc_year_'+id).val(p.exp_year).trigger('change');
            $('#cc_year_val_'+id).val(p.exp_year);
            $('#pcc_cvv2_' + id).val('');
            //$('#pcc_type_' + id).val(CardType);
            $('#swipe_' + id).val('');
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
   
    </script>
    
        
        <?php
        $s2_lang_file = read_file('./assets/config_dumps/s2_lang.js');
        foreach (lang('select2_lang') as $s2_key => $s2_line) {
            $s2_data[$s2_key] = str_replace(array('{', '}'), array('"+', '+"'), $s2_line);
        }
        $s2_file_date = $this->parser->parse_string($s2_lang_file, $s2_data, true);
        ?>
       <!--<script type="text/javascript" src="<?= $assets ?>js/jquery-ui.min.js"></script>
     
        <script type="text/javascript" src="<?= $assets ?>js/bootstrap.min.js"></script>
        
       <script src="http://code.jquery.com/ui/1.9.0/jquery-ui.min.js"></script>
        <script type="text/javascript" src="<?= $assets ?>js/jquery.validate.js"></script>
        <script type="text/javascript" src="<?= $assets ?>js/perfect-scrollbar.min.js"></script>
        <script type="text/javascript" src="<?= $assets ?>js/select2.min.js"></script>
        <script type="text/javascript" src="<?= $assets ?>js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="<?= $assets ?>js/custom.js"></script>
        <script type="text/javascript" src="<?= $assets ?>js/jquery.calculator.min.js"></script>
        <script type="text/javascript" src="<?= $assets ?>js/bootstrapValidator.min.js"></script>
        <script type="text/javascript" src="<?= $assets ?>pos/js/jquery.validate.min.js"></script>
        <script type="text/javascript" src="<?= $assets ?>js/additional-methods.min.js"></script>
        <script type="text/javascript" src="<?= $assets ?>js/validate_additional_methods.js"></script>
         <script type="text/javascript" src="<?= $assets ?>pos/js/plugins.min.js"></script> 
         <script type="text/javascript" src="<?= $assets ?>js/keyboard.js"></script>

        <script type="text/javascript" src="<?= $assets ?>pos/js/parse-track-data.js"></script> -->
        <script type="text/javascript" src="<?= $assets ?>pos/js/pos.ajax.js"></script>


        <?php if ($pos_settings->java_applet) { ?>
            <script type="text/javascript" src="<?= $assets ?>pos/qz/js/deployJava.js"></script>
            <script type="text/javascript" src="<?= $assets ?>pos/qz/qz-functions.js"></script>
            <script type="text/javascript">
            deployQZ('themes/<?= $Settings->theme ?>/assets/pos/qz/qz-print.jar', '<?= $assets ?>pos/qz/qz-print_jnlp.jnlp');
            function printBill(bill) {
                usePrinter("<?= $pos_settings->receipt_printer; ?>");
                printData(bill);
            }
    <?php
    $printers = json_encode(explode('|', $pos_settings->pos_printers));
    echo $printers . ';';
    ?>
            function printOrder(order) {
                for (index = 0; index < printers.length; index++) {
                    usePrinter(printers[index]);
                    printData(order);
                }
            }
            </script>

        <?php } ?>
        <script type="text/javascript" charset="UTF-8"><?= $s2_file_date ?></script>
        <div id="ajaxCall"><i class="fa fa-spinner fa-pulse"></i></div>
    </body>
</html>
<!--Add by Ankit to validate mobile number validation-->
<script>
function alphanumeric_only(event)
{
    var keycode;
    keycode=event.keyCode?event.keyCode:event.which;


    if ((keycode == 32) || (keycode == 8) || (keycode >= 47 && keycode <= 57) || (keycode >= 65 && keycode <= 90) || (keycode >= 97 && keycode <= 122)) {
        return true;
    }else {
        return false;
    }
    return true;

}

function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}

function posFormSubmit() {
    var gc_status = localStorage.getItem('gc_status');      
    if ((gc_status != null) || (gc_status != undefined)) {
        if (gc_status == 'valid') {
            $('#pos_note').val(localStorage.getItem('posnote'));
            $('#staff_note').val(localStorage.getItem('staffnote'));

            //$('#submit-sale').text('<?= lang('loading'); ?>').attr('disabled', true);
            $('#pos-sale-form').submit();
        } else {
            return false;
        }
    } else {
        $('#pos_note').val(localStorage.getItem('posnote'));
        $('#staff_note').val(localStorage.getItem('staffnote'));

        //$(this).text('<?= lang('loading'); ?>').attr('disabled', true);
        $('#pos-sale-form').submit();
    }
}



$(document).ready(function() {
    $('#paymentModal').on('hide.bs.modal', function() {
            $("#paying_gift_card_no_val_1").val();
            $("#amount_val_1").val("");
            $("#paid_by_val_1").val("cash");
            $("#balance_amount_1").val("");
            $("#cc_no_val_1").val("");
            $("#gift_card_no_1").val("");
            $("#paying_gift_card_no_val_1").val("");
            $("#cc_holder_val_1").val("");
            $("#cheque_no_val_1").val("");
            $("#cc_month_val_1").val("");
            $("#cc_year_val_1").val("");
            $("#cc_type_val_1").val("");
            $("#cc_card_type_val_1").val("");
            $("#cc_cvv2_val_1").val("");
            $("#payment_note_val_1").val(""); 
            $("#cn_balance_1").val("");
            $("#cn_balance_val_1").val("");
            $(".gift_card_no").val("");

         for(i=2; i<=100; i++)
         {  $('#pos-payment-form')[0].reset();
            $("#paying_gift_card_no_val_"+i).val();
            $("#amount_val_"+i).val("");
            $("#gift_card_no_"+i).val("");
            $("#paid_by_val_"+i).val("cash");
            $("#balance_amount_"+i).val("");
            $("#cc_no_val_"+i).val("");
            $("#paying_gift_card_no_val_"+i).val("");
            $("#cc_holder_val_"+i).val("");
            $("#cheque_no_val_"+i).val("");
            $("#cc_month_val_"+i).val("");
            $("#cc_year_val_"+i).val("");
            $("#cc_type_val_"+i).val("");
            $("#cc_card_type_val_"+i).val("");
            $("#cc_cvv2_val_"+i).val("");
            $("#cn_balance_"+i).val("");
            $("#cn_balance_val_"+i).val("");
            $("#payment_note_val_"+i).val("");
            $("#payments_"+i).remove("");
         }  
         $('.quick-cash').find('.badge').remove();
         $('#submit-sale').prop('disabled', false);

           
    });

});
</script>


<!-- *** Added by Anil Start *** -->
<?php 
//echo form_input('enable_walkcustomer',$pos_settings->enable_walkcustomer, 'id="enable_walkcustomer"');
if($pos_settings->isfullWidth==0) { ?>
    <script>
        document.getElementById("leftdiv").setAttribute("style","width:38%; max-width:38%");
        document.getElementById("cpinner").setAttribute("style","display:block; max-width:60%");              
    </script>
    <style>
        .btn-cat-con { position: fixed; top: 200px; right: -136px; z-index: 6; width: 300px; height: 40px; display:inline}        
    </style>
<?php } ?>

<style type="text/css"> 
.ui-autocomplete {top: 133.5px !important;}
</style>
      
 <!--  <script type="text/javascript">
   var id=1;
     for (id =1; id <= 25; id++) {
        $("#pcc_year_"+id).on('input paste change keyup',function(){
            alert(id);
            var today = new Date();
            var thisYear = today.getFullYear();
            var month = (1 + today.getMonth()).toString();
            var thisMonth = month.length > 1 ? month : '0' + month;
            
            var expMonth = $('#pcc_month_'+id).val();
            var expYear = $('#pcc_year_'+id).val();
            if(expMonth !='')
             {  
                if(expYear < thisYear)
                {
                    //return "Invalid Year";

                }
                else if(expYear == thisYear && expMonth >= thisMonth)
                { 
                     $('#submit-sale').prop('disabled', false);
                     //return true;
                }
                else if(expYear > thisYear)
                {  
                    $('#pcc_year_'+id+'-error').removeClass('error');
                    $('#pcc_year_'+id+'-error').text('');
                     $('#submit-sale').prop('disabled', false);
                    //return true;
                }

                else {
                      $('#submit-sale').prop('disabled', true); 
                      $('#pcc_month_'+id+'-error').addClass('error');
                      $('#pcc_month_'+id+'-error').text('Entered month is not valid');
                       //return false;
                      
                }
                
             } 
             else{
                  $('#submit-sale').prop('disabled', true);
                  $('#pcc_month_'+id+'-error').addClass('error');
                  $('#pcc_month_'+id+'-error').text('Entered month is not valid');
                  ///return false;
             }  
        
      });
  }</script>
     -->
<!-- *** Added by Anil End *** -->    
