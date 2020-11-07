<style>
    .table td:first-child {
        font-weight: bold;
    }

    label {
        margin-right: 10px;
    }
</style>
<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-folder-open"></i><?= lang('group_permissions'); ?></h2>
    </div>
    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">

                <p class="introtext"><?= lang("set_permissions"); ?></p>

                <?php if (!empty($p)) {
                    if ($p->group_id != 1) {

                        echo form_open("system_settings/permissions/" . $id); ?>
                    <?php if($Owner) { ?>  <!--****Added By Anil 31-08-2016 for Owners only **** -->  
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped">

                                <thead>
                                <tr>
                                    <th colspan="6"
                                        class="text-center"><?php echo $group->description . ' ( ' . $group->name . ' ) ' . $this->lang->line("group_permissions"); ?></th>
                                </tr>
                                <tr>
                                    <th rowspan="2" class="text-center"><?= lang("module_name"); ?>
                                    </th>
                                    <th colspan="5" class="text-center"><?= lang("permissions"); ?></th>
                                </tr>
                                <tr>
                                    <th class="text-center"><?= lang("view"); ?></th>
                                    <th class="text-center"><?= lang("add"); ?></th>
                                    <th class="text-center"><?= lang("edit"); ?></th>
                                    <th class="text-center"><?= lang("delete"); ?></th>
                                    <th class="text-center"><?= lang("misc"); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td><?= lang("products"); ?></td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox"
                                               name="products-index" <?php echo $p->{'products-index'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox"
                                               name="products-add" <?php echo $p->{'products-add'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox"
                                               name="products-edit" <?php echo $p->{'products-edit'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox"
                                               name="products-delete" <?php echo $p->{'products-delete'} ? "checked" : ''; ?>>
                                    </td>
                                    <td>
                                        <input type="checkbox" value="1" id="products-print_barcodes" class="checkbox"
                                               name="products_print_barcodes" <?php echo $p->{'products-print_barcodes'} ? "checked" : ''; ?>><label
                                            for="products_print_barcodes" class="padding05"><?= lang('print_barcodes') ?></label>    
                                        <input type="checkbox" value="1" id="products-print_labels" class="checkbox"
                                               name="products_print_labels" <?php echo $p->{'products-print_labels'} ? "checked" : ''; ?>><label
                                            for="products-print_labels" class="padding05"><?= lang('print_labels') ?></label>  
                                        <input type="checkbox" value="1" id="products-sync_quantity" class="checkbox"
                                               name="products-sync_quantity" <?php echo $p->{'products-sync_quantity'} ? "checked" : ''; ?>><label
                                            for="products-sync_quantity" class="padding05"><?= lang('sync_quantity') ?></label>      
                                        <input type="checkbox" value="1" id="products-export_excel" class="checkbox"
                                               name="export_excel" <?php echo $p->{'products-export_excel'} ? "checked" : ''; ?>><label
                                            for="products-export_excel" class="padding05"><?= lang('excel') ?></label>
                                        <input type="checkbox" value="1" id="products-export_pdf" class="checkbox"
                                               name="export_pdf" <?php echo $p->{'products-export_pdf'} ? "checked" : ''; ?>><label
                                            for="products-export_pdf" class="padding05"><?= lang('pdf') ?></label><br> 
                                        <input type="checkbox" value="1" id="products-deatails" class="checkbox"
                                               name="products_details" <?php echo $p->{'products-details'} ? "checked" : ''; ?>><label
                                            for="products-details" class="padding05"><?= lang('products_details') ?></label> 
                                        <input type="checkbox" value="1" id="products-duplicate" class="checkbox"
                                               name="products_duplicate" <?php echo $p->{'products-duplicate'} ? "checked" : ''; ?>><label
                                            for="products-duplicate" class="padding05"><?= lang('duplicate_product') ?></label> 
                                        <input type="checkbox" value="1" id="products-image" class="checkbox"
                                               name="products_image" <?php echo $p->{'products-image'} ? "checked" : ''; ?>><label
                                            for="products_image" class="padding05"><?= lang('view_image') ?></label>
                                        <input type="checkbox" value="1" id="products-export_pdf" class="checkbox"
                                               name="adjust_quantity" <?php echo $p->{'products-adjust_quantity'} ? "checked" : ''; ?>><label
                                            for="products-adjust_quantity" class="padding05"><?= lang('adjust_quantity') ?></label>    
                                    </td>
                                </tr>
                    
                                <tr>
                                    <td><?= lang("sales"); ?></td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox"
                                               name="sales-index" <?php echo $p->{'sales-index'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <!--input type="checkbox" value="1" class="checkbox"
                                               name="sales-add" <?php echo $p->{'sales-add'} ? "checked" : ''; ?>-->
                                    </td>
                                    <td class="text-center">
                                        <!--input type="checkbox" value="1" class="checkbox"
                                               name="sales-edit" <?php echo $p->{'sales-edit'} ? "checked" : ''; ?>-->
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox"
                                               name="sales-delete" <?php echo $p->{'sales-delete'} ? "checked" : ''; ?>>
                                    </td>
                                    <td>
                                        <input type="checkbox" value="1" id="sales-email" class="checkbox"
                                               name="sales-email" <?php echo $p->{'sales-email'} ? "checked" : ''; ?>><label
                                            for="sales-email" class="padding05"><?= lang('email') ?></label>
                                        <input type="checkbox" value="1" id="sales-pdf" class="checkbox"
                                               name="sales-pdf" <?php echo $p->{'sales-pdf'} ? "checked" : ''; ?>><label
                                            for="sales-pdf" class="padding05"><?= lang('pdf') ?></label>
                                        <input type="checkbox" value="1" id="sales-excel" class="checkbox"
                                               name="sales-sales_excel" <?php echo $p->{'sales-excel'} ? "checked" : ''; ?>><label
                                            for="sales_excel" class="padding05"><?= lang('excel') ?></label>  
                                        <input type="checkbox" value="1" id="sales-payments" class="checkbox"
                                               name="sales-payments" <?php echo $p->{'sales-payments'} ? "checked" : ''; ?>><label
                                            for="sales-payments" class="padding05"><?= lang('payments') ?></label>                                       
                                        <input type="checkbox" value="1" id="sales-view_payments" class="checkbox"
                                               name="sales-view_payments" <?php echo $p->{'sales-view_payments'} ? "checked" : ''; ?>><label
                                            for="sales-view_payments" class="padding05"><?= lang('view_payments') ?></label>     
                                        <input type="checkbox" value="1" id="sales-sales_details" class="checkbox"
                                               name="sales-sales_details" <?php echo $p->{'sales-sales_details'} ? "checked" : ''; ?>><label
                                            for="sales-sales_details" class="padding05"><?= lang('sales_details') ?></label>     
                                    </td>
                                </tr>
                                <tr>
                                    <td><?= lang("pos"); ?></td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox"
                                               name="pos-index" <?php echo $p->{'pos-index'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox"
                                               name="pos-sale_add" <?php echo $p->{'pos-sale_add'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">                                       
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox"
                                               name="pos-sales_delete" <?php echo $p->{'pos-sales_delete'} ? "checked" : ''; ?>>
                                    </td>
                                    <td>
                                        <input type="checkbox" value="1" id="pos-sales_email" class="checkbox"
                                               name="pos-sales_email" <?php echo $p->{'pos-sales_email'} ? "checked" : ''; ?>><label
                                            for="sales-email" class="padding05"><?= lang('email') ?></label>
                                        <input type="checkbox" value="1" id="pos-sales_pdf" class="checkbox"
                                               name="pos-sales_pdf" <?php echo $p->{'pos-sales_pdf'} ? "checked" : ''; ?>><label
                                            for="sales_pdf" class="padding05"><?= lang('pdf') ?></label>         
                                        <input type="checkbox" value="1" id="pos-sale_excel" class="checkbox"
                                               name="pos-sales_excel" <?php echo $p->{'pos-sales_excel'} ? "checked" : ''; ?>><label
                                            for="sales-excel" class="padding05"><?= lang('excel') ?></label>    
                                        <input type="checkbox" value="1" id="pos-sales_payments" class="checkbox"
                                               name="pos-sales_payments" <?php echo $p->{'pos-sales_payments'} ? "checked" : ''; ?>><label
                                            for="pos-sales-payments" class="padding05"><?= lang('payments') ?></label>   
                                        <input type="checkbox" value="1" id="pos-view_payments" class="checkbox"
                                               name="pos-view_payments" <?php echo $p->{'pos-view_payments'} ? "checked" : ''; ?>><label
                                            for="pos-view_payments" class="padding05"><?= lang('view_payments') ?></label> 
                                        <input type="checkbox" value="1" id="pos-view_reciept" class="checkbox"
                                               name="pos-view_reciept" <?php echo $p->{'pos-view_reciept'} ? "checked" : ''; ?>><label
                                            for="pos-view_reciept" class="padding05"><?= lang('view_reciept') ?></label>  
                                    </td>
                                </tr>

                                <tr>
                                    <td><?= lang("deliveries"); ?></td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox"
                                               name="sales-deliveries" <?php echo $p->{'sales-deliveries'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox"
                                               name="sales-add_delivery" <?php echo $p->{'sales-add_delivery'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox"
                                               name="sales-edit_delivery" <?php echo $p->{'sales-edit_delivery'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox"
                                               name="sales-delete_delivery" <?php echo $p->{'sales-delete_delivery'} ? "checked" : ''; ?>>
                                    </td>
                                    <td>
                                        <!--<input type="checkbox" value="1" id="sales-email" class="checkbox" name="sales-email_delivery" <?php echo $p->{'sales-email_delivery'} ? "checked" : ''; ?>><label for="sales-email_delivery" class="padding05"><?= lang('email') ?></label>-->
                                        <input type="checkbox" value="1" id="sales-pdf" class="checkbox"
                                               name="sales-pdf_delivery" <?php echo $p->{'sales-pdf_delivery'} ? "checked" : ''; ?>><label
                                            for="sales-pdf_delivery" class="padding05"><?= lang('pdf') ?></label>
                                            
                                        <input type="checkbox" value="1" id="sales-excel_delivery" class="checkbox"
                                               name="sales-excel_delivery" <?php echo $p->{'sales-excel_delivery'} ? "checked" : ''; ?>><label
                                            for="sales-excel_delivery" class="padding05"><?= lang('excel') ?></label>
                                            
                                        <input type="checkbox" value="1" id="sales-details_delivery" class="checkbox"
                                             name="sales-details_delivery" <?php echo $p->{'sales-details_delivery'} ? "checked" : ''; ?>><label
                                          for="sales-details_delivery" class="padding05"><?= lang('details_delivery') ?></label>        
                                    </td>
                                </tr>
                                <tr>
                                    <td><?= lang("credit_voucher"); ?></td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox"
                                               name="sales-gift_cards" <?php echo $p->{'sales-gift_cards'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <!--input type="checkbox" value="1" class="checkbox"
                                               name="sales-add_gift_card" <?php echo $p->{'sales-add_gift_card'} ? "checked" : ''; ?>-->
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox"
                                               name="sales-edit_gift_card" <?php echo $p->{'sales-edit_gift_card'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox"
                                               name="sales-delete_gift_card" <?php echo $p->{'sales-delete_gift_card'} ? "checked" : ''; ?>>
                                    </td>
                                    <td>
                                        <input type="checkbox" value="1" id="sales-gift_pdf" class="checkbox"
                                             name="sales-gift_pdf" <?php echo $p->{'sales-gift_pdf'} ? "checked" : ''; ?>><label
                                             for="sales-gift_pdf" class="padding05"><?= lang('pdf') ?></label>    
                                    
                                        <input type="checkbox" value="1" id="sales-gift_excel" class="checkbox"
                                            name="sales-gift_excel" <?php echo $p->{'sales-gift_excel'} ? "checked" : ''; ?>><label
                                            for="sales-gift_excel" class="padding05"><?= lang('excel') ?></label>  
                                        <input type="checkbox" value="1" id="sales-credit_voucher_setting" class="checkbox"
                                            name="sales-credit_voucher_setting" <?php echo $p->{'sales-credit_voucher_setting'} ? "checked" : ''; ?>><label
                                            for="sales-credit_voucher_setting" class="padding05"><?= lang('credit_voucher_setting') ?></label>      
                                            
                                        <input type="checkbox" value="1" id="sales-credit_voucher_pdf" class="checkbox"
                                            name="sales-credit_voucher_pdf" <?php echo $p->{'sales-credit_voucher_pdf'} ? "checked" : ''; ?>><label
                                            for="sales-credit_voucher_pdf" class="padding05"><?= lang('credit_voucher_pdf') ?></label><br>
                                            
                                        <input type="checkbox" value="1" id="sales-credit_voucher_excel" class="checkbox"
                                            name="sales-credit_voucher_excel" <?php echo $p->{'sales-credit_voucher_excel'} ? "checked" : ''; ?>><label
                                            for="sales-credit_voucher_excel" class="padding05"><?= lang('credit_voucher_excel') ?></label>
                                        <input type="checkbox" value="1" id="sales-credit_voucher_add" class="checkbox"
                                          name="sales-credit_voucher_add" <?php echo $p->{'sales-credit_voucher_add'} ? "checked" : ''; ?>><label
                                          for="sales-credit_voucher_add" class="padding05"><?= lang('credit_voucher_add') ?></label> 
                                          
                                        <input type="checkbox" value="1" id="sales-credit_voucher_edit" class="checkbox"
                                          name="sales-credit_voucher_edit" <?php echo $p->{'sales-credit_voucher_edit'} ? "checked" : ''; ?>><label
                                          for="sales-credit_voucher_edit" class="padding05"><?= lang('credit_voucher_edit') ?></label><br> 
                                          
                                        <input type="checkbox" value="1" id="sales-credit_voucher_delete" class="checkbox"
                                          name="sales-credit_voucher_delete" <?php echo $p->{'sales-credit_voucher_delete'} ? "checked" : ''; ?>><label
                                          for="sales-credit_voucher_delete" class="padding05"><?= lang('credit_voucher_delete') ?></label> 
                                    </td>
                                </tr>

                                <tr>
                                    <td><?= lang("quotes"); ?></td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox"
                                               name="quotes-index" <?php echo $p->{'quotes-index'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox"
                                               name="quotes-add" <?php echo $p->{'quotes-add'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox"
                                               name="quotes-edit" <?php echo $p->{'quotes-edit'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox"
                                               name="quotes-delete" <?php echo $p->{'quotes-delete'} ? "checked" : ''; ?>>
                                    </td>
                                    <td>
                                        <input type="checkbox" value="1" id="quotes-email" class="checkbox"
                                               name="quotes-email" <?php echo $p->{'quotes-email'} ? "checked" : ''; ?>><label
                                            for="quotes-email" class="padding05"><?= lang('email') ?></label>
                                        <input type="checkbox" value="1" id="quotes-pdf" class="checkbox"
                                               name="quotes-pdf" <?php echo $p->{'quotes-pdf'} ? "checked" : ''; ?>><label
                                            for="quotes-pdf" class="padding05"><?= lang('pdf') ?></label>
                                        <input type="checkbox" value="1" id="quotes-excel" class="checkbox"
                                               name="quotes-excel" <?php echo $p->{'quotes-excel'} ? "checked" : ''; ?>><label
                                            for="quotes-excel" class="padding05"><?= lang('excel') ?></label> 
                                        <input type="checkbox" value="1" id="quotes-details" class="checkbox"
                                               name="quotes-details" <?php echo $p->{'quotes-details'} ? "checked" : ''; ?>><label
                                            for="quotes-details" class="padding05"><?= lang('quotes_details') ?></label>  
                                        <input type="checkbox" value="1" id="quotes-list" class="checkbox"
                                               name="quotes-list" <?php echo $p->{'quotes-list'} ? "checked" : ''; ?>><label
                                            for="quotes-list" class="padding05"><?= lang('list_quotations') ?></label>      
                                    </td>
                                </tr>

                                <tr>
                                    <td><?= lang("purchases"); ?></td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox"
                                               name="purchases-index" <?php echo $p->{'purchases-index'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox"
                                               name="purchases-add" <?php echo $p->{'purchases-add'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox"
                                               name="purchases-edit" <?php echo $p->{'purchases-edit'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox"
                                               name="purchases-delete" <?php echo $p->{'purchases-delete'} ? "checked" : ''; ?>>
                                    </td>
                                    <td>
                                        <input type="checkbox" value="1" id="purchases-email" class="checkbox"
                                               name="purchases-email" <?php echo $p->{'purchases-email'} ? "checked" : ''; ?>><label
                                            for="purchases-email" class="padding05"><?= lang('email') ?></label>
                                        <input type="checkbox" value="1" id="purchases-pdf" class="checkbox"
                                               name="purchases-pdf" <?php echo $p->{'purchases-pdf'} ? "checked" : ''; ?>><label
                                            for="purchases-pdf" class="padding05"><?= lang('pdf') ?></label>
                                        <input type="checkbox" value="1" id="purchases-excel" class="checkbox"
                                               name="purchases-excel" <?php echo $p->{'purchases-excel'} ? "checked" : ''; ?>><label
                                            for="purchases-excel" class="padding05"><?= lang('excel') ?></label>       
                                        <input type="checkbox" value="1" id="purchases-payments" class="checkbox"
                                               name="purchases-payments" <?php echo $p->{'purchases-payments'} ? "checked" : ''; ?>><label
                                            for="purchases-payments" class="padding05"><?= lang('payments') ?></label>                                                                            
                                        <input type="checkbox" value="1" id="purchases-details" class="checkbox"
                                               name="purchases-details" <?php echo $p->{'purchases-details'} ? "checked" : ''; ?>><label
                                               for="purchases-details" class="padding05"><?= lang('purchases_details') ?></label><br>                                        
                                        <input type="checkbox" value="1" id="purchases-view_payments" class="checkbox"
                                               name="purchases-view_payments" <?php echo $p->{'purchases-view_payments'} ? "checked" : ''; ?>><label
                                               for="purchases-view_payments" class="padding05"><?= lang('purchases-view_payments') ?></label>                                                 
                                    </td>
                                </tr>

                                <tr>
                                    <td><?= lang("transfers"); ?></td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox"
                                               name="transfers-index" <?php echo $p->{'transfers-index'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox"
                                               name="transfers-add" <?php echo $p->{'transfers-add'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox"
                                               name="transfers-edit" <?php echo $p->{'transfers-edit'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox"
                                               name="transfers-delete" <?php echo $p->{'transfers-delete'} ? "checked" : ''; ?>>
                                    </td>
                                    <td>
                                        <input type="checkbox" value="1" id="transfers-email" class="checkbox"
                                               name="transfers-email" <?php echo $p->{'transfers-email'} ? "checked" : ''; ?>><label
                                            for="transfers-email" class="padding05"><?= lang('email') ?></label>
                                        <input type="checkbox" value="1" id="transfers-pdf" class="checkbox"
                                               name="transfers-pdf" <?php echo $p->{'transfers-pdf'} ? "checked" : ''; ?>><label
                                            for="transfers-pdf" class="padding05"><?= lang('pdf') ?></label>
                                        <input type="checkbox" value="1" id="transfers-excel" class="checkbox"
                                               name="transfers-excel" <?php echo $p->{'transfers-excel'} ? "checked" : ''; ?>><label
                                            for="transfers-excel" class="padding05"><?= lang('excel') ?></label>  
                                        <input type="checkbox" value="1" id="transfers-details" class="checkbox"
                                               name="transfers-details" <?php echo $p->{'transfers-details'} ? "checked" : ''; ?>><label
                                            for="transfers-details" class="padding05"><?= lang('transfers-details') ?></label>        
                                    </td>
                                </tr>

                                <tr>
                                    <td><?= lang("customers"); ?></td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox"
                                               name="customers-index" <?php echo $p->{'customers-index'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox"
                                               name="customers-add" <?php echo $p->{'customers-add'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox"
                                               name="customers-edit" <?php echo $p->{'customers-edit'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox"
                                               name="customers-delete" <?php echo $p->{'customers-delete'} ? "checked" : ''; ?>>
                                    </td>
                                    <td>
                                        <input type="checkbox" value="1" id="customers-pdf" class="checkbox"
                                               name="customers-pdf" <?php echo $p->{'customers-pdf'} ? "checked" : ''; ?>><label
                                            for="customers-pdf" class="padding05"><?= lang('pdf') ?></label>    
                                            
                                        <input type="checkbox" value="1" id="customers-excel" class="checkbox"
                                               name="customers-excel" <?php echo $p->{'customers-excel'} ? "checked" : ''; ?>><label
                                            for="customers-excel" class="padding05"><?= lang('excel') ?></label>                                            
                                        <input type="checkbox" value="1" id="customers-add_by_csv" class="checkbox"
                                               name="customers-add_by_csv" <?php echo $p->{'customers-add_by_csv'} ? "checked" : ''; ?>><label
                                            for="customers-add_by_csv" class="padding05"><?= lang('customers-add_by_csv') ?></label>
                                        <input type="checkbox" value="1" id="users-delete_users" class="checkbox"
                                               name="users-delete_users" <?php echo $p->{'users-delete_users'} ? "checked" : ''; ?>><label
                                            for="users-delete_users" class="padding05"><?= lang('delete_users') ?></label>    
                                        <input type="checkbox" value="1" id="users-pdf" class="checkbox"
                                             name="users-pdf" <?php echo $p->{'users-pdf'} ? "checked" : ''; ?>><label
                                            for="users-pdf" class="padding05"><?= lang('users_pdf') ?></label><br>      
                                        <input type="checkbox" value="1" id="users-excel" class="checkbox"
                                             name="users-excel" <?php echo $p->{'users-excel'} ? "checked" : ''; ?>><label
                                            for="users-excel" class="padding05"><?= lang('users_excel') ?></label>     
                                    </td>
                                </tr>

                                <tr>
                                    <td><?= lang("suppliers"); ?></td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox"
                                               name="suppliers-index" <?php echo $p->{'suppliers-index'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox"
                                               name="suppliers-add" <?php echo $p->{'suppliers-add'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox"
                                               name="suppliers-edit" <?php echo $p->{'suppliers-edit'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox"
                                               name="suppliers-delete" <?php echo $p->{'suppliers-delete'} ? "checked" : ''; ?>>
                                    </td>
                                    <td>
                                        <input type="checkbox" value="1" id="suppliers-pdf" class="checkbox"
                                               name="suppliers-pdf" <?php echo $p->{'suppliers-pdf'} ? "checked" : ''; ?>><label
                                            for="suppliers-pdf" class="padding05"><?= lang('pdf') ?></label> 
                                            
                                        <input type="checkbox" value="1" id="suppliers-excel" class="checkbox"
                                               name="suppliers-excel" <?php echo $p->{'suppliers-excel'} ? "checked" : ''; ?>><label
                                            for="suppliers-excel" class="padding05"><?= lang('excel') ?></label> 
                                            
                                        <input type="checkbox" value="1" id="suppliers-add_by_csv" class="checkbox"
                                               name="suppliers-add_by_csv" <?php echo $p->{'suppliers-add_by_csv'} ? "checked" : ''; ?>><label
                                            for="suppliers-add_by_csv" class="padding05"><?= lang('suppliers-add_by_csv') ?></label>
                                        <input type="checkbox" value="1" id="billers-excel" class="checkbox"
                                               name="billers-excel" <?php echo $p->{'billers-excel'} ? "checked" : ''; ?>><label
                                            for="billers-excel" class="padding05"><?= lang('billers_excel') ?></label>  
                                        <input type="checkbox" value="1" id="billers-pdf" class="checkbox"
                                               name="billers-pdf" <?php echo $p->{'billers-pdf'} ? "checked" : ''; ?>><label
                                            for="billers-pdf" class="padding05"><?= lang('billers_pdf') ?></label><br>   
                                        <input type="checkbox" value="1" id="billers-delete" class="checkbox"
                                               name="billers-delete" <?php echo $p->{'billers-delete'} ? "checked" : ''; ?>><label
                                            for="billers-delete" class="padding05"><?= lang('billers_delete') ?></label>    
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    <!-- Menu Tabs Permissions for Owners By Anil -->
                        <div class="table-responsive">
                            <table cellpadding="0" cellspacing="0" border="0"
                                   class="table table-bordered table-hover table-striped" style="margin-bottom: 5px;">
                                <thead>
                                <tr>
                                    <th><?= lang("pos-tip"); ?>
                                    </th>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="checkbox" value="1" class="checkbox" id="pos-tip_calc"
                                               name="pos-pos_tip" <?php echo $p->{'pos-pos_tip'} ? "checked" : ''; ?>><label
                                            for="pos-pos_tip" class="padding05"><?= lang('pos') ?></label> 
                                        <input type="checkbox" value="1" class="checkbox" id="pos-tip_calc"
                                               name="pos-tip_calc" <?php echo $p->{'pos-tip_calc'} ? "checked" : ''; ?>><label
                                            for="pos-tip_calc" class="padding05"><?= lang('pos-tip_calc') ?></label> 
                                        <input type="checkbox" value="1" class="checkbox" id="pos-tip_holdsale"
                                               name="pos-tip_holdsale" <?php echo $p->{'pos-tip_holdsale'} ? "checked" : ''; ?>><label
                                            for="pos-tip_holdsale" class="padding05"><?= lang('pos-tip_holdsale') ?></label> 
                                        <input type="checkbox" value="1" class="checkbox" id="pos-tip_registerdetails"
                                               name="pos-tip_registerdetails" <?php echo $p->{'pos-tip_registerdetails'} ? "checked" : ''; ?>><label
                                            for="pos-tip_registerdetails" class="padding05"><?= lang('pos-tip_registerdetails') ?></label> 
                                        <input type="checkbox" value="1" class="checkbox" id="pos-tip_closeregister"
                                               name="pos-tip_closeregister" <?php echo $p->{'pos-tip_closeregister'} ? "checked" : ''; ?>><label
                                            for="pos-tip_closeregister" class="padding05"><?= lang('pos-tip_closeregister') ?></label> 
                                        <input type="checkbox" value="1" class="checkbox" id="pos-tip_addexpense"
                                               name="pos-tip_addexpense" <?php echo $p->{'pos-tip_addexpense'} ? "checked" : ''; ?>><label
                                            for="pos-tip_addexpense" class="padding05"><?= lang('pos-tip_addexpense') ?></label> 
                                        <input type="checkbox" value="1" class="checkbox" id="pos-tip_todayprofit"
                                               name="pos-tip_todayprofit" <?php echo $p->{'pos-tip_todayprofit'} ? "checked" : ''; ?>><label
                                            for="pos-tip_todayprofit" class="padding05"><?= lang('pos-tip_todayprofit') ?></label><br>
                                        <input type="checkbox" value="1" class="checkbox" id="pos-tip_todaysale"
                                               name="pos-tip_todaysale" <?php echo $p->{'pos-tip_todaysale'} ? "checked" : ''; ?>><label
                                            for="pos-tip_todaysale" class="padding05"><?= lang('pos-tip_todaysale') ?></label> 
                                        <input type="checkbox" value="1" class="checkbox" id="pos-tip_openregister"
                                               name="pos-tip_openregister" <?php echo $p->{'pos-tip_openregister'} ? "checked" : ''; ?>><label
                                            for="pos-tip_openregister" class="padding05"><?= lang('pos-tip_openregister') ?></label>     
                                        <input type="checkbox" value="1" class="checkbox" id="pos-tip_cleardata"
                                               name="pos-tip_cleardata" <?php echo $p->{'pos-tip_cleardata'} ? "checked" : ''; ?>><label
                                            for="pos-tip_cleardata" class="padding05"><?= lang('pos-tip_cleardata') ?></label>   
                                        <input type="checkbox" value="1" class="checkbox" id="pos-tip_accessories"
                                               name="pos-tip_accessories" <?php echo $p->{'pos-tip_accessories'} ? "checked" : ''; ?>><label
                                            for="pos-tip_accessories" class="padding05"><?= lang('pos-tip_accessories') ?></label>       
                                    </td>
                                    
                                </tr>
                                </thead>
                            </table>
                        </div>                      
                        <div class="table-responsive">
                            <table cellpadding="0" cellspacing="0" border="0"
                                   class="table table-bordered table-hover table-striped" style="margin-bottom: 5px;">

                                <thead>
                                <tr>
                                    <th><?= lang("manage_till"); ?>
                                    </th>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="checkbox" value="1" class="checkbox" id="till-index"
                                               name="till-index" <?php echo $p->{'till-index'} ? "checked" : ''; ?>><label
                                            for="till-index" class="padding05"><?= lang('till_view') ?></label>
                                        <input type="checkbox" value="1" class="checkbox" id="till-addTill"
                                               name="till-addTill" <?php echo $p->{'till-addTill'} ? "checked" : ''; ?>><label
                                            for="till-addTill" class="padding05"><?= lang('add_till') ?></label>
                                        <input type="checkbox" value="1" class="checkbox" id="till-manageTill"
                                               name="till-manageTill" <?php echo $p->{'till-manageTill'} ? "checked" : ''; ?>><label
                                            for="till-manageTill" class="padding05"><?= lang('manage_till') ?></label>
                                        <input type="checkbox" value="1" class="checkbox" id="till-deleteTill"
                                               name="till-deleteTill" <?php echo $p->{'till-deleteTill'} ? "checked" : ''; ?>><label
                                            for="till-deleteTill" class="padding05"><?= lang('delete') ?></label>    
                                                                                                                     
                                    </td>
                                </tr>
                                </thead>
                            </table>
                        </div>  
                        <div class="table-responsive">
                            <table cellpadding="0" cellspacing="0" border="0"
                                   class="table table-bordered table-hover table-striped" style="margin-bottom: 5px;">

                                <thead>
                                <tr>
                                    <th><?= lang("products"); ?>
                                    </th>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="checkbox" value="1" class="checkbox" id="products-list"
                                               name="products-list" <?php echo $p->{'products-list'} ? "checked" : ''; ?>><label
                                            for="list_products"
                                            class="padding05"><?= lang('list_products') ?></label>
                                        <input type="checkbox" value="1" class="checkbox" id="print_barcodes"
                                               name="print_barcodes" <?php echo $p->{'print_barcodes'} ? "checked" : ''; ?>><label
                                            for="print_barcodes" class="padding05"><?= lang('print_barcodes') ?></label>
                                        <input type="checkbox" value="1" class="checkbox" id="print_labels"
                                               name="print_labels" <?php echo $p->{'print_labels'} ? "checked" : ''; ?>><label
                                            for="print_labels" class="padding05"><?= lang('print_labels') ?></label>
                                        <input type="checkbox" value="1" class="checkbox" id="import_product"
                                               name="import_product" <?php echo $p->{'import_product'} ? "checked" : ''; ?>><label
                                            for="import_product" class="padding05"><?= lang('import_product') ?></label>
                                        <input type="checkbox" value="1" class="checkbox" id="update_price"
                                               name="update_price" <?php echo $p->{'update_price'} ? "checked" : ''; ?>><label
                                            for="update_price" class="padding05"><?= lang('update_price') ?></label> 
                                        <input type="checkbox" value="1" class="checkbox" id="products-quantity_adjustments"
                                           name="quantity_adjustments" <?php echo $p->{'products-quantity_adjustments'} ? "checked" : ''; ?>><label
                                        for="quantity_adjustments" class="padding05"><?= lang('quantity_adjustments') ?></label><br>   
                                        <input type="checkbox" value="1" class="checkbox" id="products-quantity_excel"
                                           name="products-quantity_excel" <?php echo $p->{'products-quantity_excel'} ? "checked" : ''; ?>><label
                                        for="products-quantity_excel" class="padding05"><?= lang('products-quantity_excel') ?></label>   
                                        <input type="checkbox" value="1" class="checkbox" id="products-quantity_pdf"
                                           name="products-quantity_pdf" <?php echo $p->{'products-quantity_pdf'} ? "checked" : ''; ?>><label
                                        for="products-quantity_pdf" class="padding05"><?= lang('products-quantity_pdf') ?></label> 
                                        <input type="checkbox" value="1" class="checkbox" id="products-quantity_pdf"
                                           name="products-quantity_delete" <?php echo $p->{'products-quantity_delete'} ? "checked" : ''; ?>><label
                                           for="products-quantity_delete" class="padding05"><?= lang('products-quantity_delete') ?></label>
                                    </td>
                                </tr>
                                </thead>
                            </table>
                        </div>                
                        <div class="table-responsive">
                            <table cellpadding="0" cellspacing="0" border="0"
                                   class="table table-bordered table-hover table-striped" style="margin-bottom: 5px;">

                                <thead>
                                <tr>
                                    <th><?= lang("sales"); ?>
                                    </th>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="checkbox" value="1" class="checkbox" id="sales-list"
                                               name="sales-list" <?php echo $p->{'sales-list'} ? "checked" : ''; ?>><label
                                            for="sales-list"
                                            class="padding05"><?= lang('list_sales') ?></label>                                     
                                        <input type="checkbox" value="1" class="checkbox" id="add_sale_by_csv"
                                               name="add_sale_by_csv" <?php echo $p->{'add_sale_by_csv'} ? "checked" : ''; ?>><label
                                            for="add_sale_by_csv" class="padding05"><?= lang('add_sale_by_csv') ?></label>
                                        <input type="checkbox" value="1" class="checkbox" id="credit_voucher"
                                               name="credit_voucher" <?php echo $p->{'credit_voucher'} ? "checked" : ''; ?>><label
                                            for="credit_voucher" class="padding05"><?= lang('credit_voucher') ?></label>
                                        <input type="checkbox" value="1" id="sales-return_sales" class="checkbox"
                                               name="sales-return_sales" <?php echo $p->{'sales-return_sales'} ? "checked" : ''; ?>><label
                                            for="sales-return_sales"
                                            class="padding05"><?= lang('return_sales') ?></label>
                                    </td>
                                </tr>
                                </thead>
                            </table>
                        </div>                       
                        <div class="table-responsive">
                            <table cellpadding="0" cellspacing="0" border="0"
                                   class="table table-bordered table-hover table-striped" style="margin-bottom: 5px;">
                                <thead>
                                <tr>
                                    <th><?= lang("purchases"); ?>
                                    </th>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="checkbox" value="1" class="checkbox" id="purchases-list"
                                               name="purchases-list" <?php echo $p->{'purchases-list'} ? "checked" : ''; ?>><label
                                            for="purchases-list"
                                            class="padding05"><?= lang('list_purchases') ?></label>
                                        <input type="checkbox" value="1" class="checkbox" id="purchase-add_by_csv"
                                               name="purchase-add_by_csv" <?php echo $p->{'purchase-add_by_csv'} ? "checked" : ''; ?>><label
                                            for="purchase-add_by_csv"
                                            class="padding05"><?= lang('add_purchase_by_csv') ?></label>
                                        <input type="checkbox" value="1" id="purchases-expenses" class="checkbox"
                                               name="purchases-expenses" <?php echo $p->{'purchases-expenses'} ? "checked" : ''; ?>><label
                                               for="purchases-expenses" class="padding05"><?= lang('expenses') ?></label>    
                                        <input type="checkbox" value="1" class="checkbox" id="purchase-expense_add"
                                               name="purchase-expense_add" <?php echo $p->{'purchase-expense_add'} ? "checked" : ''; ?>><label
                                            for="purchase-expense_add"
                                            class="padding05"><?= lang('add_expense') ?></label>    
                                    </td>
                                </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="table-responsive">
                            <table cellpadding="0" cellspacing="0" border="0"
                                   class="table table-bordered table-hover table-striped" style="margin-bottom: 5px;">
                                <thead>
                                <tr>
                                    <th><?= lang("transfers"); ?>
                                    </th>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="checkbox" value="1" class="checkbox" id="transfers-list"
                                               name="transfers-list" <?php echo $p->{'transfers-list'} ? "checked" : ''; ?>><label
                                            for="transfers-list"
                                            class="padding05"><?= lang('list_transfers') ?></label>
                                        <input type="checkbox" value="1" class="checkbox" id="transfers-add_by_csv"
                                               name="transfers-add_by_csv" <?php echo $p->{'transfers-add_by_csv'} ? "checked" : ''; ?>><label
                                            for="transfers-add_by_csv"
                                            class="padding05"><?= lang('add_transfer_by_csv') ?></label>
                                    </td>
                                </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="table-responsive">
                            <table cellpadding="0" cellspacing="0" border="0"
                                   class="table table-bordered table-hover table-striped" style="margin-bottom: 5px;">

                                <thead>
                                <tr>
                                    <th><?= lang("people"); ?>
                                    </th>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="checkbox" value="1" class="checkbox" id="users_list"
                                               name="users_list" <?php echo $p->{'users_list'} ? "checked" : ''; ?>><label
                                            for="users_list"
                                            class="padding05"><?= lang('list_users') ?></label>
                                        <input type="checkbox" value="1" class="checkbox" id="users-add"
                                               name="users-add" <?php echo $p->{'users-add'} ? "checked" : ''; ?>><label
                                            for="users-add"
                                            class="padding05"><?= lang('add_user') ?></label>
                                        <input type="checkbox" value="1" class="checkbox" id="billers-list"
                                               name="billers-list" <?php echo $p->{'billers-list'} ? "checked" : ''; ?>><label
                                            for="billers-list"
                                            class="padding05"><?= lang('list_billers') ?></label>
                                        <input type="checkbox" value="1" class="checkbox" id="billers-add"
                                               name="billers-add" <?php echo $p->{'billers-list'} ? "checked" : ''; ?>><label
                                            for="billers-list" class="padding05"><?= lang('add_biller') ?></label>
                                        <input type="checkbox" value="1" class="checkbox" id="notifications"
                                               name="notifications" <?php echo $p->{'notifications'} ? "checked" : ''; ?>><label
                                            for="notifications" class="padding05"><?= lang('notifications') ?></label>    
                                    </td>
                                </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="table-responsive">
                            <table cellpadding="0" cellspacing="0" border="0"
                                   class="table table-bordered table-hover table-striped" style="margin-bottom: 5px;">

                                <thead>
                                <tr>
                                    <th><?= lang("settings"); ?>
                                    </th>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="checkbox" value="1" class="checkbox" id="settings-index"
                                               name="settings-index" <?php echo $p->{'settings-index'} ? "checked" : ''; ?>><label
                                            for="settings-index"
                                            class="padding05"><?= lang('settings') ?></label>
                                        <input type="checkbox" value="1" class="checkbox" id="system_settings"
                                               name="system_settings" <?php echo $p->{'system_settings'} ? "checked" : ''; ?>><label
                                            for="system_settings"
                                            class="padding05"><?= lang('system_settings') ?></label>
                                        <input type="checkbox" value="1" class="checkbox" id="pos_settings"
                                               name="pos_settings" <?php echo $p->{'pos_settings'} ? "checked" : ''; ?>><label
                                            for="pos_settings"
                                            class="padding05"><?= lang('pos_settings') ?></label>
                                        <input type="checkbox" value="1" class="checkbox" id="change_logo"
                                               name="change_logo" <?php echo $p->{'change_logo'} ? "checked" : ''; ?>><label
                                            for="change_logo"
                                            class="padding05"><?= lang('change_logo') ?></label>
                                        <input type="checkbox" value="1" class="checkbox" id="currencies"
                                               name="currencies" <?php echo $p->{'currencies'} ? "checked" : ''; ?>><label
                                            for="currencies" class="padding05"><?= lang('currencies') ?></label>
                                        <input type="checkbox" value="1" class="checkbox" id="customer_groups"
                                               name="customer_groups" <?php echo $p->{'customer_groups'} ? "checked" : ''; ?>><label
                                            for="customer_groups" class="padding05"><?= lang('customer_groups') ?></label>
                                        <input type="checkbox" value="1" class="checkbox" id="categories"
                                               name="categories" <?php echo $p->{'categories'} ? "checked" : ''; ?>><label
                                            for="categories" class="padding05"><?= lang('categories') ?></label><br>
                                        <input type="checkbox" value="1" class="checkbox" id="variants"
                                               name="variants" <?php echo $p->{'variants'} ? "checked" : ''; ?>><label
                                               for="variants" class="padding05"><?= lang('variants') ?></label>
                                        <input type="checkbox" value="1" class="checkbox" id="tax_rates"
                                               name="tax_rates" <?php echo $p->{'tax_rates'} ? "checked" : ''; ?>><label
                                            for="tax_rates" class="padding05"><?= lang('tax_rates') ?></label>
                                        <input type="checkbox" value="1" class="checkbox" id="warehouses"
                                               name="warehouses" <?php echo $p->{'warehouses'} ? "checked" : ''; ?>><label
                                            for="warehouses" class="padding05"><?= lang('warehouses') ?></label>
                                        <input type="checkbox" value="1" class="checkbox" id="email_templates"
                                               name="email_templates" <?php echo $p->{'email_templates'} ? "checked" : ''; ?>><label
                                            for="email_templates" class="padding05"><?= lang('email_templates') ?></label>
                                        <input type="checkbox" value="1" class="checkbox" id="group_permissions"
                                               name="group_permissions" <?php echo $p->{'group_permissions'} ? "checked" : ''; ?>><label
                                            for="group_permissions" class="padding05"><?= lang('group_permissions') ?></label>
                                        <input type="checkbox" value="1" class="checkbox" id="backups"
                                               name="backups" <?php echo $p->{'backups'} ? "checked" : ''; ?>><label
                                            for="backups" class="padding05"><?= lang('backups') ?></label>
                                        <input type="checkbox" value="1" class="checkbox" id="update_version"
                                               name="update_version" <?php echo $p->{'update_version'} ? "checked" : ''; ?>><label
                                            for="update_version" class="padding05"><?= lang('update_version') ?></label>         
                                    </td>
                                </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="table-responsive">
                            <table cellpadding="0" cellspacing="0" border="0"
                                   class="table table-bordered table-hover table-striped" style="margin-bottom: 5px;">                                    
                                <thead>
                                <tr>
                                    <th><?= lang("reports"); ?>
                                    </th>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="checkbox" value="1" class="checkbox" id="overview_chart"
                                               name="reports-index" <?php echo $p->{'reports-index'} ? "checked" : ''; ?>><label
                                            for="reports-index"
                                            class="padding05"><?= lang('reports') ?></label>
                                        <input type="checkbox" value="1" class="checkbox" id="overview_chart"
                                               name="overview_chart" <?php echo $p->{'overview_chart'} ? "checked" : ''; ?>><label
                                            for="overview_chart"
                                            class="padding05"><?= lang('overview_chart') ?></label>
                                        <input type="checkbox" value="1" class="checkbox" id="reports-warehouse_stock"
                                               name="reports-warehouse_stock" <?php echo $p->{'reports-warehouse_stock'} ? "checked" : ''; ?>><label
                                            for="reports-warehouse_stock"
                                            class="padding05"><?= lang('warehouse_stock_chart') ?></label>
                                        <input type="checkbox" value="1" class="checkbox" id="register_report"
                                               name="register_report" <?php echo $p->{'register_report'} ? "checked" : ''; ?>><label
                                            for="register_report" class="padding05"><?= lang('register_report') ?></label>
                                        <input type="checkbox" value="1" class="checkbox" id="product_quantity_alerts"
                                               name="reports-quantity_alerts" <?php echo $p->{'reports-quantity_alerts'} ? "checked" : ''; ?>><label
                                            for="product_quantity_alerts"
                                            class="padding05"><?= lang('product_quantity_alerts') ?></label><br>
                                        <input type="checkbox" value="1" class="checkbox" id="Product_expiry_alerts"
                                               name="reports-expiry_alerts" <?php echo $p->{'reports-expiry_alerts'} ? "checked" : ''; ?>><label
                                            for="Product_expiry_alerts"
                                            class="padding05"><?= lang('product_expiry_alerts') ?></label>
                                        <input type="checkbox" value="1" class="checkbox" id="products"
                                               name="reports-products" <?php echo $p->{'reports-products'} ? "checked" : ''; ?>><label
                                            for="products" class="padding05"><?= lang('products') ?></label>
                                        <input type="checkbox" value="1" class="checkbox" id="categories_report"
                                               name="categories_report" <?php echo $p->{'categories_report'} ? "checked" : ''; ?>><label
                                            for="categories_report" class="padding05"><?= lang('categories_report') ?></label>    
                                        <input type="checkbox" value="1" class="checkbox" id="daily_sales"
                                               name="reports-daily_sales" <?php echo $p->{'reports-daily_sales'} ? "checked" : ''; ?>><label
                                            for="daily_sales" class="padding05"><?= lang('daily_sales') ?></label>
                                        <input type="checkbox" value="1" class="checkbox" id="monthly_sales"
                                               name="reports-monthly_sales" <?php echo $p->{'reports-monthly_sales'} ? "checked" : ''; ?>><label
                                            for="monthly_sales" class="padding05"><?= lang('monthly_sales') ?></label>
                                        <input type="checkbox" value="1" class="checkbox" id="reports-sales"
                                               name="reports-sales" <?php echo $p->{'reports-sales'} ? "checked" : ''; ?>><label
                                            for="reports-sales" class="padding05"><?= lang('sales_report') ?></label><br>
                                        <input type="checkbox" value="1" class="checkbox" id="payments"
                                               name="reports-payments" <?php echo $p->{'reports-payments'} ? "checked" : ''; ?>><label
                                            for="payments" class="padding05"><?= lang('payments') ?></label>
                                        <input type="checkbox" value="1" class="checkbox" id="reports-profit_loss"
                                               name="reports-profit_loss" <?php echo $p->{'reports-profit_loss'} ? "checked" : ''; ?>><label
                                            for="reports-profit_loss" class="padding05"><?= lang('profit_loss') ?></label>  
                                        <input type="checkbox" value="1" class="checkbox" id="purchases"
                                               name="reports-purchases" <?php echo $p->{'reports-purchases'} ? "checked" : ''; ?>><label
                                            for="purchases" class="padding05"><?= lang('purchases') ?></label>
                                        <input type="checkbox" value="1" class="checkbox" id="customers"
                                               name="reports-customers" <?php echo $p->{'reports-customers'} ? "checked" : ''; ?>><label
                                            for="customers" class="padding05"><?= lang('customers') ?></label>
                                        <input type="checkbox" value="1" class="checkbox" id="suppliers"
                                               name="reports-suppliers" <?php echo $p->{'reports-suppliers'} ? "checked" : ''; ?>><label
                                            for="suppliers" class="padding05"><?= lang('suppliers') ?></label>
                                        <input type="checkbox" value="1" class="checkbox" id="staff_report"
                                               name="staff_report" <?php echo $p->{'staff_report'} ? "checked" : ''; ?>><label
                                            for="staff_report" class="padding05"><?= lang('staff_report') ?></label>    
                                    </td>
                                </tr>
                                </thead>
                            </table>
                        </div>
                    <?php 
                    } else { ?> <!-- **** Add By Anil 19-09-2016 permissions if not Owners **** -->
                       
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped">

                                <thead>
                                <tr>
                                    <th colspan="6"
                                        class="text-center"><?php echo $group->description . ' ( ' . $group->name . ' ) ' . $this->lang->line("group_permissions"); ?></th>
                                </tr>
                                <tr>
                                    <th rowspan="2" class="text-center"><?= lang("module_name"); ?>
                                    </th>
                                    <th colspan="5" class="text-center"><?= lang("permissions"); ?></th>
                                </tr>
                                <tr>
                                    <th class="text-center"><?= lang("view"); ?></th>
                                    <th class="text-center"><?= lang("add"); ?></th>
                                    <th class="text-center"><?= lang("edit"); ?></th>
                                    <th class="text-center"><?= lang("delete"); ?></th>
                                    <th class="text-center"><?= lang("misc"); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td><?= lang("products"); ?></td>
                                    
                                    <td class="text-center">
                                        <?php if($GP['products-index'] == 1) { ?>
                                        <input type="checkbox" value="1" class="checkbox"
                                               name="products-index" <?php echo $p->{'products-index'} ? "checked" : ''; ?>> <?php } ?>
                                    </td>                                   
                                    <td class="text-center">
                                        <?php if($GP['products-add'] == 1) { ?>
                                        <input type="checkbox" value="1" class="checkbox"
                                        name="products-add" <?php echo $p->{'products-add'} ? "checked" : ''; ?>> <?php } ?> 
                                    </td>
                                    <td class="text-center">
                                        <?php if($GP['products-edit'] == 1) { ?>
                                        <input type="checkbox" value="1" class="checkbox"
                                        name="products-edit" <?php echo $p->{'products-edit'} ? "checked" : ''; ?>> <?php } ?> 
                                    </td>
                                    <td class="text-center">
                                         <?php if($GP['products-delete'] == 1) { ?>
                                        <input type="checkbox" value="1" class="checkbox"
                                         name="products-delete" <?php echo $p->{'products-delete'} ? "checked" : ''; ?>> <?php } ?> 
                                    </td>
                                    <td>
                                        <?php  
                                         if($GP['products-print_barcodes'] == 1) { ?> 
                                            <input type="checkbox" value="1" id="products-print_barcodes" class="checkbox"
                                               name="products_print_barcodes" <?php echo $p->{'products-print_barcodes'} ? "checked" : ''; ?>><label
                                                for="products_print_barcodes" class="padding05"><?= lang('print_barcodes') ?></label>
                                        <?php } 
                                        if($GP['products-print_labels'] == 1) { ?>    
                                            <input type="checkbox" value="1" id="products-print_labels" class="checkbox"
                                               name="products_print_labels" <?php echo $p->{'products-print_labels'} ? "checked" : ''; ?>><label
                                                accesskey=""for="products-print_labels" class="padding05"><?= lang('print_labels') ?></label>  
                                        <?php } 
                                          if($GP['products-sync_quantity'] == 1) { ?>      
                                            <input type="checkbox" value="1" id="products-sync_quantity" class="checkbox"
                                               name="products-sync_quantity" <?php echo $p->{'products-sync_quantity'} ? "checked" : ''; ?>><label
                                                for="products-sync_quantity" class="padding05"><?= lang('sync_quantity') ?></label> 
                                        <?php } 
                                          if($GP['products-export_excel'] == 1) { ?> 
                                            <input type="checkbox" value="1" id="products-export_excel" class="checkbox"
                                               name="export_excel" <?php echo $p->{'products-export_excel'} ? "checked" : ''; ?>><label
                                                for="products-export_excel" class="padding05"><?= lang('excel') ?></label>
                                        <?php } 
                                          if($GP['products-export_pdf'] == 1) { ?>         
                                            <input type="checkbox" value="1" id="products-export_pdf" class="checkbox"
                                               name="export_pdf" <?php echo $p->{'products-export_pdf'} ? "checked" : ''; ?>><label
                                                 for="products-export_pdf" class="padding05"><?= lang('pdf') ?></label><br>    
                                          <?php } 
                                          if($GP['products-details'] == 1) { ?> 
                                            <input type="checkbox" value="1" id="products-deatails" class="checkbox"
                                                   name="products_details" <?php echo $p->{'products-details'} ? "checked" : ''; ?>><label
                                                for="products_details" class="padding05"><?= lang('products_details') ?></label>
                                          <?php } 
                                          if($GP['products-duplicate'] == 1) { ?>       
                                            <input type="checkbox" value="1" id="products-duplicate" class="checkbox"
                                                   name="products-duplicate" <?php echo $p->{'products-duplicate'} ? "checked" : ''; ?>><label
                                                for="products_duplicate" class="padding05"><?= lang('duplicate_product') ?></label>
                                          <?php } 
                                          if($GP['products-image'] == 1) { ?>         
                                            <input type="checkbox" value="1" id="products-image" class="checkbox"
                                                   name="products-image" <?php echo $p->{'products-image'} ? "checked" : ''; ?>><label
                                                for="products_image" class="padding05"><?= lang('view_image') ?></label>
                                          <?php } 
                                          if($GP['products-adjust_quantity'] == 1) { ?>       
                                            <input type="checkbox" value="1" id="products-export_pdf" class="checkbox"
                                                   name="adjust_quantity" <?php echo $p->{'products-adjust_quantity'} ? "checked" : ''; ?>><label
                                                for="products_adjust_quantity" class="padding05"><?= lang('adjust_quantity') ?></label>  
                                          <?php } ?>     
                                    </td>
                                </tr>

                                <tr>
                                    <td><?= lang("sales"); ?></td>
                                    <td class="text-center">
                                        <?php if($GP['sales-index'] == 1) { ?>
                                        <input type="checkbox" value="1" class="checkbox"
                                        name="sales-index" <?php echo $p->{'sales-index'} ? "checked" : ''; ?>> <?php } ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if($GP['sales-add'] == 1) { ?>
                                        <!--input type="checkbox" value="1" class="checkbox"
                                               name="sales-add" <?php echo $p->{'sales-add'} ? "checked" : ''; ?>--> <?php } ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if($GP['sales-edit'] == 1) { ?>
                                        <!--input type="checkbox" value="1" class="checkbox"
                                               name="sales-edit" <?php echo $p->{'sales-edit'} ? "checked" : ''; ?>--> <?php } ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if($GP['sales-delete'] == 1) { ?>
                                        <input type="checkbox" value="1" class="checkbox"
                                               name="sales-delete" <?php echo $p->{'sales-delete'} ? "checked" : ''; ?>> <?php } ?>
                                    </td>
                                    <td> 
                                        <?php if($GP['sales-email'] == 1) { ?>
                                        <input type="checkbox" value="1" id="sales-email" class="checkbox"
                                               name="sales-email" <?php echo $p->{'sales-email'} ? "checked" : ''; ?>><label
                                        for="sales-email" class="padding05"><?= lang('email') ?></label> <?php } ?>
                                        <?php if($GP['sales-pdf'] == 1) { ?>
                                        <input type="checkbox" value="1" id="sales-pdf" class="checkbox"
                                               name="sales-pdf" <?php echo $p->{'sales-pdf'} ? "checked" : ''; ?>><label
                                        for="sales-pdf" class="padding05"><?= lang('pdf') ?></label> 
                                        <?php }                                       
                                        if($GP['sales-payments'] == 1) { ?>
                                        <input type="checkbox" value="1" id="sales-payments" class="checkbox"
                                               name="sales-payments" <?php echo $p->{'sales-payments'} ? "checked" : ''; ?>><label
                                        for="sales-payments" class="padding05"><?= lang('payments') ?></label> 
                                        <?php } 
                                        if($GP['sales-view_payments'] == 1) { ?>
                                        <input type="checkbox" value="1" id="sales-view_payments" class="checkbox"
                                               name="sales-view_payments" <?php echo $p->{'sales-view_payments'} ? "checked" : ''; ?>><label
                                            for="sales-view_payments" class="padding05"><?= lang('view_payments') ?></label>
                                        <?php } 
                                        if($GP['sales-sales_details'] == 1) { ?>    
                                        <input type="checkbox" value="1" id="sales-sales_details" class="checkbox"
                                               name="sales-sales_details" <?php echo $p->{'sales-sales_details'} ? "checked" : ''; ?>><label
                                            for="sales-sales_details" class="padding05"><?= lang('sales_details') ?></label>   
                                        <?php } ?>    
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td><?= lang("pos"); ?></td>
                                    <td class="text-center">
                                        <?php if($GP['pos-index'] == 1) { ?>
                                        <input type="checkbox" value="1" class="checkbox"
                                        name="pos-index" <?php echo $p->{'pos-index'} ? "checked" : ''; ?>> <?php } ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if($GP['pos-sales_add'] == 1) { ?>
                                        <input type="checkbox" value="1" class="checkbox"
                                               name="pos-sales_add" <?php echo $p->{'pos-sales_add'} ? "checked" : ''; ?>> <?php } ?>
                                    </td>
                                    <td class="text-center">
                                        
                                    </td>
                                    <td class="text-center">
                                        <?php if($GP['pos-sales_delete'] == 1) { ?>
                                        <input type="checkbox" value="1" class="checkbox"
                                               name="pos-sales_delete" <?php echo $p->{'pos-sales_delete'} ? "checked" : ''; ?>> <?php } ?>
                                    </td>
                                    <td> 
                                        <?php if($GP['pos-sales_email'] == 1) { ?>
                                        <input type="checkbox" value="1" id="pos-sales_email" class="checkbox"
                                               name="pos-sales_email" <?php echo $p->{'pos-sales_email'} ? "checked" : ''; ?>><label
                                            for="sales-email" class="padding05"><?= lang('email') ?></label>
                                        <?php } 
                                        if($GP['pos-sales_pdf'] == 1) { ?>
                                        <input type="checkbox" value="1" id="pos-sales_pdf" class="checkbox"
                                               name="pos-sales_pdf" <?php echo $p->{'pos-sales_pdf'} ? "checked" : ''; ?>><label
                                            for="sales_pdf" class="padding05"><?= lang('pdf') ?></label> 
                                        <?php } 
                                        if($GP['pos-sales_excel'] == 1) { ?>    
                                        <input type="checkbox" value="1" id="pos-sale_excel" class="checkbox"
                                               name="pos-sales_excel" <?php echo $p->{'pos-sales_excel'} ? "checked" : ''; ?>><label
                                            for="sales-excel" class="padding05"><?= lang('excel') ?></label>
                                        <?php } 
                                        if($GP['pos-sales_payments'] == 1) { ?>    
                                        <input type="checkbox" value="1" id="pos-sales_payments" class="checkbox"
                                               name="pos-sales_payments" <?php echo $p->{'pos-sales_payments'} ? "checked" : ''; ?>><label
                                            for="pos-sales-payments" class="padding05"><?= lang('payments') ?></label>  
                                        <?php } 
                                        if($GP['pos-view_payments'] == 1) { ?>     
                                        <input type="checkbox" value="1" id="pos-view_payments" class="checkbox"
                                               name="pos-view_payments" <?php echo $p->{'pos-view_payments'} ? "checked" : ''; ?>><label
                                            for="pos-view_payments" class="padding05"><?= lang('view_payments') ?></label>
                                        <?php } 
                                        if($GP['pos-view_reciept'] == 1) { ?>      
                                        <input type="checkbox" value="1" id="pos-view_reciept" class="checkbox"
                                               name="pos-view_reciept" <?php echo $p->{'pos-view_reciept'} ? "checked" : ''; ?>><label
                                            for="pos-view_reciept" class="padding05"><?= lang('view_reciept') ?></label>  
                                        <?php } ?>    
                                    </td>
                                </tr>

<!--                                <tr>
                                    <td><?= lang("deliveries"); ?></td>
                                    <td class="text-center">
                                        <?php if($GP['sales-deliveries'] == 1) { ?>
                                        <input type="checkbox" value="1" class="checkbox"
                                        name="sales-deliveries" <?php echo $p->{'sales-deliveries'} ? "checked" : ''; ?>> <?php } ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if($GP['sales-add_delivery'] == 1) { ?>
                                        <input type="checkbox" value="1" class="checkbox"
                                        name="sales-add_delivery" <?php echo $p->{'sales-add_delivery'} ? "checked" : ''; ?>> <?php } ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if($GP['sales-edit_delivery'] == 1) { ?>
                                        <input type="checkbox" value="1" class="checkbox"
                                        name="sales-edit_delivery" <?php echo $p->{'sales-edit_delivery'} ? "checked" : ''; ?>> <?php } ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if($GP['sales-delete_delivery'] == 1) { ?>
                                        <input type="checkbox" value="1" class="checkbox"
                                        name="sales-delete_delivery" <?php echo $p->{'sales-delete_delivery'} ? "checked" : ''; ?>> <?php } ?>
                                    </td>
                                    <td>
                                        <?php if($GP['sales-email_delivery'] == 1) { ?>
                                        <input type="checkbox" value="1" id="sales-email_delivery" class="checkbox"
                                               name="sales-email_delivery" <?php echo $p->{'sales-email_delivery'} ? "checked" : ''; ?>><label
                                            for="sales-email_delivery" class="padding05"><?= lang('email') ?></label>
                                        <?php }
                                        if($GP['sales-pdf_delivery'] == 1) { ?>
                                        <input type="checkbox" value="1" id="sales-pdf" class="checkbox"
                                               name="sales-pdf_delivery" <?php echo $p->{'sales-pdf_delivery'} ? "checked" : ''; ?>><label
                                            for="sales-pdf_delivery" class="padding05"><?= lang('pdf') ?></label> 
                                        <?php }
                                        if($GP['sales-excel_delivery'] == 1) { ?>                                              
                                        <input type="checkbox" value="1" id="sales-excel_delivery" class="checkbox"
                                               name="sales-excel_delivery" <?php echo $p->{'sales-excel_delivery'} ? "checked" : ''; ?>><label
                                            for="sales-excel_delivery" class="padding05"><?= lang('excel') ?></label>
                                        <?php }
                                        if($GP['sales-details_delivery'] == 1) { ?>     
                                        <input type="checkbox" value="1" id="sales-details_delivery" class="checkbox"
                                             name="sales-details_delivery" <?php echo $p->{'sales-details_delivery'} ? "checked" : ''; ?>><label
                                          for="sales-details_delivery" class="padding05"><?= lang('details_delivery') ?></label> 
                                        <?php } ?>  
                                    </td>
                                </tr>-->
                                <tr>
                                    <td><?= lang("credit_voucher"); ?></td>
                                    <td class="text-center">
                                        <?php if($GP['sales-gift_cards'] == 1) { ?>
                                        <input type="checkbox" value="1" class="checkbox"
                                        name="sales-gift_cards" <?php echo $p->{'sales-gift_cards'} ? "checked" : ''; ?>> <?php } ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if($GP['sales-add_gift_card'] == 1) { ?>
                                        <!--input type="checkbox" value="1" class="checkbox"
                                        name="sales-add_gift_card" <?php echo $p->{'sales-add_gift_card'} ? "checked" : ''; ?>--> <?php } ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if($GP['sales-edit_gift_card'] == 1) { ?>
                                        <input type="checkbox" value="1" class="checkbox"
                                        name="sales-edit_gift_card" <?php echo $p->{'sales-edit_gift_card'} ? "checked" : ''; ?>> <?php } ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if($GP['sales-delete_gift_card'] == 1) { ?>
                                        <input type="checkbox" value="1" class="checkbox"
                                        name="sales-delete_gift_card" <?php echo $p->{'sales-delete_gift_card'} ? "checked" : ''; ?>> <?php } ?>
                                    </td>
                                    <td>
                                        <?php if($GP['sales-gift_pdf'] == 1) { ?>
                                        <input type="checkbox" value="1" id="sales-gift_pdf" class="checkbox"
                                             name="sales-gift_pdf" <?php echo $p->{'sales-gift_pdf'} ? "checked" : ''; ?>><label
                                             for="sales-gift_pdf" class="padding05"><?= lang('pdf') ?></label>    
                                        <?php } 
                                        if($GP['sales-gift_excel'] == 1) { ?>     
                                        <input type="checkbox" value="1" id="sales-gift_excel" class="checkbox"
                                            name="sales-gift_excel" <?php echo $p->{'sales-gift_excel'} ? "checked" : ''; ?>><label
                                            for="sales-gift_excel" class="padding05"><?= lang('excel') ?></label>  
                                        <?php } 
                                        if($GP['sales-credit_voucher_setting']) { ?>
                                        <input type="checkbox" value="1" id="sales-credit_voucher_setting" class="checkbox"
                                            name="sales-credit_voucher_setting" <?php echo $p->{'sales-credit_voucher_setting'} ? "checked" : ''; ?>><label
                                            for="sales-credit_voucher_setting" class="padding05"><?= lang('credit_voucher_setting') ?></label> 
                                        <?php }
                                        if($GP['sales-credit_voucher_pdf'] == 1) { ?>      
                                        <input type="checkbox" value="1" id="sales-credit_voucher_pdf" class="checkbox"
                                            name="sales-credit_voucher_pdf" <?php echo $p->{'sales-credit_voucher_pdf'} ? "checked" : ''; ?>><label
                                            for="sales-credit_voucher_pdf" class="padding05"><?= lang('credit_voucher_pdf') ?></label>
                                        <?php } 
                                        if($GP['sales-credit_voucher_excel'] == 1) { ?>    
                                        <input type="checkbox" value="1" id="sales-credit_voucher_excel" class="checkbox"
                                            name="sales-credit_voucher_excel" <?php echo $p->{'sales-credit_voucher_excel'} ? "checked" : ''; ?>><label
                                            for="sales-credit_voucher_excel" class="padding05"><?= lang('credit_voucher_excel') ?></label>
                                        <?php } 
                                        if($GP['sales-credit_voucher_add'] == 1) { ?>     
                                        <input type="checkbox" value="1" id="sales-credit_voucher_add" class="checkbox"
                                          name="sales-credit_voucher_add" <?php echo $p->{'sales-credit_voucher_add'} ? "checked" : ''; ?>><label
                                          for="sales-credit_voucher_add" class="padding05"><?= lang('credit_voucher_add') ?></label> 
                                        <?php } 
                                        if($GP['sales-credit_voucher_edit'] == 1) { ?>   
                                        <input type="checkbox" value="1" id="sales-credit_voucher_edit" class="checkbox"
                                          name="sales-credit_voucher_edit" <?php echo $p->{'sales-credit_voucher_edit'} ? "checked" : ''; ?>><label
                                          for="sales-credit_voucher_edit" class="padding05"><?= lang('credit_voucher_edit') ?></label> 
                                        <?php } 
                                        if($GP['sales-credit_voucher_delete'] == 1) { ?>    
                                        <input type="checkbox" value="1" id="sales-credit_voucher_delete" class="checkbox"
                                          name="sales-credit_voucher_delete" <?php echo $p->{'sales-credit_voucher_delete'} ? "checked" : ''; ?>><label
                                          for="sales-credit_voucher_delete" class="padding05"><?= lang('credit_voucher_delete') ?></label> 
                                        <?php } ?>  
                                    </td>
                                </tr>

<!--                                <tr>
                                    <td><?= lang("quotes"); ?></td>
                                    <td class="text-center">
                                        <?php if($GP['quotes-index'] == 1) { ?>
                                        <input type="checkbox" value="1" class="checkbox"
                                        name="quotes-index" <?php echo $p->{'quotes-index'} ? "checked" : ''; ?>> <?php } ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if($GP['quotes-add'] == 1) { ?>
                                        <input type="checkbox" value="1" class="checkbox"
                                        name="quotes-add" <?php echo $p->{'quotes-add'} ? "checked" : ''; ?>> <?php } ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if($GP['quotes-edit'] == 1) { ?>
                                        <input type="checkbox" value="1" class="checkbox"
                                        name="quotes-edit" <?php echo $p->{'quotes-edit'} ? "checked" : ''; ?>> <?php } ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if($GP['quotes-delete'] == 1) { ?>
                                        <input type="checkbox" value="1" class="checkbox"
                                        name="quotes-delete" <?php echo $p->{'quotes-delete'} ? "checked" : ''; ?>> <?php } ?>
                                    </td>
                                    <td>
                                        <?php if($GP['quotes-email'] == 1) { ?>
                                        <input type="checkbox" value="1" id="quotes-email" class="checkbox"
                                               name="quotes-email" <?php echo $p->{'quotes-email'} ? "checked" : ''; ?>><label
                                            for="quotes-email" class="padding05"><?= lang('email') ?></label>
                                        <?php } 
                                        if($GP['quotes-pdf'] == 1) { ?>    
                                        <input type="checkbox" value="1" id="quotes-pdf" class="checkbox"
                                               name="quotes-pdf" <?php echo $p->{'quotes-pdf'} ? "checked" : ''; ?>><label
                                        for="quotes-pdf" class="padding05"><?= lang('pdf') ?></label>
                                        <?php }
                                        if($GP['quotes-excel'] == 1) { ?> 
                                        <input type="checkbox" value="1" id="quotes-excel" class="checkbox"
                                               name="quotes-excel" <?php echo $p->{'quotes-excel'} ? "checked" : ''; ?>><label
                                            for="quotes-excel" class="padding05"><?= lang('excel') ?></label>
                                        <?php }
                                        if($GP['quotes-details'] == 1) { ?>     
                                        <input type="checkbox" value="1" id="quotes-details" class="checkbox"
                                               name="quotes-details" <?php echo $p->{'quotes-details'} ? "checked" : ''; ?>><label
                                            for="quotes-details" class="padding05"><?= lang('quotes_details') ?></label>
                                        <?php } 
                                        if($GP['quotes-list'] == 1) { ?>     
                                        <input type="checkbox" value="1" id="quotes-list" class="checkbox"
                                             name="quotes-list" <?php echo $p->{'quotes-list'} ? "checked" : ''; ?>><label
                                          for="quotes-list" class="padding05"><?= lang('list_quotations') ?></label> 
                                        <?php } ?>  
                                    </td>
                                </tr>

                                <tr>
                                    <td><?= lang("purchases"); ?></td>
                                    <td class="text-center">
                                        <?php if($GP['purchases-index'] == 1) { ?> 
                                        <input type="checkbox" value="1" class="checkbox"
                                        name="purchases-index" <?php echo $p->{'purchases-index'} ? "checked" : ''; ?>> <?php } ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if($GP['purchases-add'] == 1) { ?> 
                                        <input type="checkbox" value="1" class="checkbox"
                                        name="purchases-add" <?php echo $p->{'purchases-add'} ? "checked" : ''; ?>> <?php } ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if($GP['purchases-edit'] == 1) { ?> 
                                        <input type="checkbox" value="1" class="checkbox"
                                        name="purchases-edit" <?php echo $p->{'purchases-edit'} ? "checked" : ''; ?>> <?php } ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if($GP['purchases-delete'] == 1) { ?> 
                                        <input type="checkbox" value="1" class="checkbox"
                                        name="purchases-delete" <?php echo $p->{'purchases-delete'} ? "checked" : ''; ?>> <?php } ?>
                                    </td>
                                    <td>
                                        <?php if($GP['purchases-email'] == 1) { ?> 
                                        <input type="checkbox" value="1" id="purchases-email" class="checkbox"
                                               name="purchases-email" <?php echo $p->{'purchases-email'} ? "checked" : ''; ?>><label
                                            for="purchases-email" class="padding05"><?= lang('email') ?></label>
                                        <?php }  
                                        if($GP['purchases-pdf'] == 1) { ?>    
                                        <input type="checkbox" value="1" id="purchases-pdf" class="checkbox"
                                               name="purchases-pdf" <?php echo $p->{'purchases-pdf'} ? "checked" : ''; ?>><label
                                            for="purchases-pdf" class="padding05"><?= lang('pdf') ?></label>
                                        <?php } 
                                        if($GP['purchases-excel'] == 1) { ?>  
                                        <input type="checkbox" value="1" id="purchases-excel" class="checkbox"
                                               name="purchases-excel" <?php echo $p->{'purchases-excel'} ? "checked" : ''; ?>><label
                                            for="purchases-excel" class="padding05"><?= lang('excel') ?></label>    
                                        <?php }                                        
                                        if($GP['purchases-payments'] == 1) { ?>    
                                        <input type="checkbox" value="1" id="purchases-payments" class="checkbox"
                                               name="purchases-payments" <?php echo $p->{'purchases-payments'} ? "checked" : ''; ?>><label
                                            for="purchases-payments" class="padding05"><?= lang('payments') ?></label>
                                        <?php } 
                                        if($GP['purchases-details'] == 1) { ?>
                                        <input type="checkbox" value="1" id="purchases-details" class="checkbox"
                                               name="purchases-details" <?php echo $p->{'purchases-details'} ? "checked" : ''; ?>><label
                                               for="purchases-details" class="padding05"><?= lang('purchases_details') ?></label>      
                                        <?php } 
                                        if($GP['purchases-view_payments'] == 1) { ?>       
                                        <input type="checkbox" value="1" id="purchases-view_payments" class="checkbox"
                                               name="purchases-view_payments" <?php echo $p->{'purchases-view_payments'} ? "checked" : ''; ?>><label
                                               for="purchases-view_payments" class="padding05"><?= lang('purchases-view_payments') ?></label>
                                        <?php } ?>
                                    </td>
                                </tr>

                                <tr>
                                    <td><?= lang("transfers"); ?></td>
                                    <td class="text-center">
                                        <?php if($GP['transfers-index'] == 1) { ?>  
                                        <input type="checkbox" value="1" class="checkbox"
                                        name="transfers-index" <?php echo $p->{'transfers-index'} ? "checked" : ''; ?>> <?php } ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if($GP['transfers-add'] == 1) { ?>
                                        <input type="checkbox" value="1" class="checkbox"
                                        name="transfers-add" <?php echo $p->{'transfers-add'} ? "checked" : ''; ?>> <?php } ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if($GP['transfers-edit'] == 1) { ?>
                                        <input type="checkbox" value="1" class="checkbox"
                                        name="transfers-edit" <?php echo $p->{'transfers-edit'} ? "checked" : ''; ?>> <?php } ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if($GP['transfers-delete'] == 1) { ?>
                                        <input type="checkbox" value="1" class="checkbox"
                                        name="transfers-delete" <?php echo $p->{'transfers-delete'} ? "checked" : ''; ?>> <?php } ?>
                                    </td>
                                    <td>
                                        <?php if($GP['transfers-email'] == 1) { ?>
                                        <input type="checkbox" value="1" id="transfers-email" class="checkbox"
                                               name="transfers-email" <?php echo $p->{'transfers-email'} ? "checked" : ''; ?>><label
                                        for="transfers-email" class="padding05"><?= lang('email') ?></label> 
                                        <?php } 
                                        if($GP['transfers-pdf'] == 1) { ?>
                                        <input type="checkbox" value="1" id="transfers-pdf" class="checkbox"
                                               name="transfers-pdf" <?php echo $p->{'transfers-pdf'} ? "checked" : ''; ?>><label
                                            for="transfers-pdf" class="padding05"><?= lang('pdf') ?></label>
                                        <?php } 
                                        if($GP['transfers-excel'] == 1) { ?>
                                        <input type="checkbox" value="1" id="transfers-excel" class="checkbox"
                                               name="transfers-excel" <?php echo $p->{'transfers-excel'} ? "checked" : ''; ?>><label
                                            for="transfers-excel" class="padding05"><?= lang('excel') ?></label>
                                        <?php }
                                        if($GP['transfers-details'] ==1) { ?>
                                        <input type="checkbox" value="1" id="transfers-details" class="checkbox"
                                               name="transfers-details" <?php echo $p->{'transfers-details'} ? "checked" : ''; ?>><label
                                            for="transfers-details" class="padding05"><?= lang('transfers-details') ?></label>
                                        <?php } ?>
                                    </td>
                                </tr>-->

                                <tr>
                                    <td><?= lang("customers"); ?></td>
                                    <td class="text-center">
                                        <?php if($GP['customers-index'] == 1) { ?>
                                        <input type="checkbox" value="1" class="checkbox"
                                        name="customers-index" <?php echo $p->{'customers-index'} ? "checked" : ''; ?>> <?php } ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if($GP['customers-add'] == 1) { ?>
                                        <input type="checkbox" value="1" class="checkbox"
                                         name="customers-add" <?php echo $p->{'customers-add'} ? "checked" : ''; ?>> <?php } ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if($GP['customers-edit'] == 1) { ?>
                                        <input type="checkbox" value="1" class="checkbox"
                                        name="customers-edit" <?php echo $p->{'customers-edit'} ? "checked" : ''; ?>> <?php } ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if($GP['customers-delete'] == 1) { ?>
                                        <input type="checkbox" value="1" class="checkbox"
                                        name="customers-delete" <?php echo $p->{'customers-delete'} ? "checked" : ''; ?>> 
                                        <?php } ?>
                                    </td>
                                    <td>
                                        <?php if($GP['customers-pdf'] == 1) { ?>
                                        <input type="checkbox" value="1" id="customers-pdf" class="checkbox"
                                               name="customers-pdf" <?php echo $p->{'customers-pdf'} ? "checked" : ''; ?>><label
                                            for="customers-pdf" class="padding05"><?= lang('pdf') ?></label>    
                                        <?php } 
                                        if($GP['customers-excel'] == 1) { ?>    
                                        <input type="checkbox" value="1" id="customers-excel" class="checkbox"
                                               name="customers-excel" <?php echo $p->{'customers-excel'} ? "checked" : ''; ?>><label
                                            for="customers-excel" class="padding05"><?= lang('excel') ?></label> 
                                        <?php } 
                                        if($GP['customers-add_by_csv'] == 1) { ?>    
                                        <input type="checkbox" value="1" id="customers-add_by_csv" class="checkbox"
                                               name="customers-add_by_csv" <?php echo $p->{'customers-add_by_csv'} ? "checked" : ''; ?>><label
                                            for="customers-add_by_csv" class="padding05"><?= lang('customers-add_by_csv') ?></label>
                                        <?php } 
                                        if($GP['users-delete_users'] == 1) { ?>     
                                        <input type="checkbox" value="1" id="users-delete_users" class="checkbox"
                                               name="users-delete_users" <?php echo $p->{'users-delete_users'} ? "checked" : ''; ?>><label
                                            for="users-delete_users" class="padding05"><?= lang('delete_users') ?></label>
                                        <?php } 
                                        if($GP['users-pdf'] == 1) { ?>     
                                        <input type="checkbox" value="1" id="users-pdf" class="checkbox"
                                             name="users-pdf" <?php echo $p->{'users-pdf'} ? "checked" : ''; ?>><label
                                            for="users-pdf" class="padding05"><?= lang('users_pdf') ?></label>
                                        <?php } 
                                        if($GP['users-excel'] == 1) { ?>     
                                        <input type="checkbox" value="1" id="users-excel" class="checkbox"
                                             name="users-excel" <?php echo $p->{'users-excel'} ? "checked" : ''; ?>><label
                                            for="users-excel" class="padding05"><?= lang('users_excel') ?></label>    
                                        <?php } ?>    
                                    </td>
                                </tr>

<!--                                <tr>
                                    <td><?= lang("suppliers"); ?></td>
                                    <td class="text-center">
                                        <?php if($GP['suppliers-index'] == 1) { ?>
                                        <input type="checkbox" value="1" class="checkbox"
                                        name="suppliers-index" <?php echo $p->{'suppliers-index'} ? "checked" : ''; ?>> <?php } ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if($GP['suppliers-add'] == 1) { ?>
                                        <input type="checkbox" value="1" class="checkbox"
                                        name="suppliers-add" <?php echo $p->{'suppliers-add'} ? "checked" : ''; ?>> <?php } ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if($GP['suppliers-edit'] == 1) { ?>
                                        <input type="checkbox" value="1" class="checkbox"
                                        name="suppliers-edit" <?php echo $p->{'suppliers-edit'} ? "checked" : ''; ?>> <?php } ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if($GP['suppliers-delete'] == 1) { ?>
                                        <input type="checkbox" value="1" class="checkbox"
                                        name="suppliers-delete" <?php echo $p->{'suppliers-delete'} ? "checked" : ''; ?>> <?php } ?>
                                    </td>
                                    <td>
                                        <?php if($GP['suppliers-pdf'] == 1) { ?>
                                        <input type="checkbox" value="1" id="suppliers-pdf" class="checkbox"
                                               name="suppliers-pdf" <?php echo $p->{'suppliers-pdf'} ? "checked" : ''; ?>><label
                                            for="suppliers-pdf" class="padding05"><?= lang('pdf') ?></label> 
                                        <?php }
                                        if($GP['suppliers-excel'] == 1) { ?>    
                                        <input type="checkbox" value="1" id="suppliers-excel" class="checkbox"
                                               name="suppliers-excel" <?php echo $p->{'suppliers-excel'} ? "checked" : ''; ?>><label
                                            for="suppliers-excel" class="padding05"><?= lang('excel') ?></label> 
                                        <?php }
                                        if($GP['suppliers-add_by_csv'] == 1) { ?>     
                                        <input type="checkbox" value="1" id="suppliers-add_by_csv" class="checkbox"
                                               name="suppliers-add_by_csv" <?php echo $p->{'suppliers-add_by_csv'} ? "checked" : ''; ?>><label
                                            for="suppliers-add_by_csv" class="padding05"><?= lang('suppliers-add_by_csv') ?></label> 
                                        <?php } 
                                        if($GP['billers-excel']) { ?>
                                        <input type="checkbox" value="1" id="billers-excel" class="checkbox"
                                               name="billers-excel" <?php echo $p->{'billers-excel'} ? "checked" : ''; ?>><label
                                            for="billers-excel" class="padding05"><?= lang('billers_excel') ?></label>  
                                        <?php } 
                                        if($GP['billers-pdf']) { ?>   
                                        <input type="checkbox" value="1" id="billers-pdf" class="checkbox"
                                               name="billers-pdf" <?php echo $p->{'billers-pdf'} ? "checked" : ''; ?>><label
                                            for="billers-pdf" class="padding05"><?= lang('billers_pdf') ?></label>
                                        <?php } 
                                        if($GP['billers-delete']) { ?>    
                                        <input type="checkbox" value="1" id="billers-delete" class="checkbox"
                                               name="billers-delete" <?php echo $p->{'billers-delete'} ? "checked" : ''; ?>><label
                                            for="billers-delete" class="padding05"><?= lang('billers_delete') ?></label>
                                        <?php } ?>
                                    </td>
                                </tr>-->

                                </tbody>
                            </table>
                        </div>
                        <div class="table-responsive">
                            <table cellpadding="0" cellspacing="0" border="0"
                                   class="table table-bordered table-hover table-striped" style="margin-bottom: 5px;">

                                <thead>
                                <tr>
                                    <th><?= lang("pos-tip"); ?>
                                    </th>
                                </tr>
                                <tr>
                                    <td>
                                        <?php 
                                        if($GP['pos-pos_tip']) { ?>
                                        <input type="checkbox" value="1" class="checkbox" id="pos-tip_calc"
                                               name="pos-pos_tip" <?php echo $p->{'pos-pos_tip'} ? "checked" : ''; ?>><label
                                            for="pos-pos_tip" class="padding05"><?= lang('pos') ?></label> 
                                        <?php }
                                        if($GP['pos-tip_calc']) { ?>    
                                        <input type="checkbox" value="1" class="checkbox" id="pos-tip_calc"
                                               name="pos-tip_calc" <?php echo $p->{'pos-tip_calc'} ? "checked" : ''; ?>><label
                                            for="pos-tip_calc" class="padding05"><?= lang('pos-tip_calc') ?></label>
                                        <?php } 
                                        if($GP['pos-tip_holdsale']) { ?>     
                                        <input type="checkbox" value="1" class="checkbox" id="pos-tip_holdsale"
                                               name="pos-tip_holdsale" <?php echo $p->{'pos-tip_holdsale'} ? "checked" : ''; ?>><label
                                            for="pos-tip_holdsale" class="padding05"><?= lang('pos-tip_holdsale') ?></label> 
                                        <?php } 
                                        if($GP['pos-tip_registerdetails']) { ?>    
                                        <input type="checkbox" value="1" class="checkbox" id="pos-tip_registerdetails"
                                               name="pos-tip_registerdetails" <?php echo $p->{'pos-tip_registerdetails'} ? "checked" : ''; ?>><label
                                            for="pos-tip_registerdetails" class="padding05"><?= lang('pos-tip_registerdetails') ?></label> 
                                        <?php } 
                                        if($GP['pos-tip_closeregister']) { ?>     
                                        <input type="checkbox" value="1" class="checkbox" id="pos-tip_closeregister"
                                               name="pos-tip_closeregister" <?php echo $p->{'pos-tip_closeregister'} ? "checked" : ''; ?>><label
                                            for="pos-tip_closeregister" class="padding05"><?= lang('pos-tip_closeregister') ?></label> 
                                        <?php } 
                                        if($GP['pos-tip_addexpense']) { ?>      
                                        <input type="checkbox" value="1" class="checkbox" id="pos-tip_addexpense"
                                               name="pos-tip_addexpense" <?php echo $p->{'pos-tip_addexpense'} ? "checked" : ''; ?>><label
                                            for="pos-tip_addexpense" class="padding05"><?= lang('pos-tip_addexpense') ?></label> 
                                        <?php } 
                                        if($GP['pos-tip_todayprofit']) { ?>       
                                        <input type="checkbox" value="1" class="checkbox" id="pos-tip_todayprofit"
                                               name="pos-tip_todayprofit" <?php echo $p->{'pos-tip_todayprofit'} ? "checked" : ''; ?>><label
                                            for="pos-tip_todayprofit" class="padding05"><?= lang('pos-tip_todayprofit') ?></label>
                                        <?php } 
                                        if($GP['pos-tip_todaysale']) { ?>     
                                        <input type="checkbox" value="1" class="checkbox" id="pos-tip_todaysale"
                                               name="pos-tip_todaysale" <?php echo $p->{'pos-tip_todaysale'} ? "checked" : ''; ?>><label
                                            for="pos-tip_todaysale" class="padding05"><?= lang('pos-tip_todaysale') ?></label>
                                        <?php } 
                                        if($GP['pos-tip_openregister']) { ?>     
                                        <input type="checkbox" value="1" class="checkbox" id="pos-tip_openregister"
                                               name="pos-tip_openregister" <?php echo $p->{'pos-tip_openregister'} ? "checked" : ''; ?>><label
                                            for="pos-tip_openregister" class="padding05"><?= lang('pos-tip_openregister') ?></label>
                                        <?php } 
                                        if($GP['pos-tip_cleardata']) { ?>     
                                        <input type="checkbox" value="1" class="checkbox" id="pos-tip_cleardata"
                                               name="pos-tip_cleardata" <?php echo $p->{'pos-tip_cleardata'} ? "checked" : ''; ?>><label
                                            for="pos-tip_cleardata" class="padding05"><?= lang('pos-tip_cleardata') ?></label>
                                        <?php } 
                                        if($GP['pos-tip_accessories']) { ?>      
                                        <input type="checkbox" value="1" class="checkbox" id="pos-tip_accessories"
                                               name="pos-tip_accessories" <?php echo $p->{'pos-tip_accessories'} ? "checked" : ''; ?>><label
                                            for="pos-tip_accessories" class="padding05"><?= lang('pos-tip_accessories') ?></label> 
                                         <?php } ?>    
                                    </td>
                                    
                                </tr>
                                </thead>
                            </table>
                        </div>
                         <div class="table-responsive">
                            <table cellpadding="0" cellspacing="0" border="0"
                                   class="table table-bordered table-hover table-striped" style="margin-bottom: 5px;">
                                <thead>
                                <tr>
                                    <th><?= lang("manage_till"); ?>
                                    </th>
                                </tr>
                                <tr>
                                    <td>
                                        <?php if($GP['till-index'] == 1) { ?>
                                        <input type="checkbox" value="1" class="checkbox" id="till-index"
                                               name="till-index" <?php echo $p->{'till-index'} ? "checked" : ''; ?>><label
                                            for="till-index" class="padding05"><?= lang('till_view') ?></label>
                                        <?php } 
                                        if($GP['till-addTill'] == 1) { ?>    
                                        <input type="checkbox" value="1" class="checkbox" id="till-addTill"
                                               name="till-addTill" <?php echo $p->{'till-addTill'} ? "checked" : ''; ?>><label
                                            for="till-addTill" class="padding05"><?= lang('add_till') ?></label>
                                        <?php } 
                                        if($GP['till-manageTill'] == 1) { ?>     
                                        <input type="checkbox" value="1" class="checkbox" id="till-manageTill"
                                               name="till-manageTill" <?php echo $p->{'till-manageTill'} ? "checked" : ''; ?>><label
                                        for="till-manageTill" class="padding05"><?= lang('manage_till') ?></label> 
                                        <?php }
                                        if($GP['till-deleteTill'] == 1) { ?>
                                        <input type="checkbox" value="1" class="checkbox" id="till-deleteTill"
                                               name="till-deleteTill" <?php echo $p->{'till-deleteTill'} ? "checked" : ''; ?>><label
                                            for="till-deleteTill" class="padding05"><?= lang('delete') ?></label>  
                                        <?php } ?>    
                                    </td>
                                </tr>
                                </thead>
                            </table>
                        </div> 
                        <div class="table-responsive">
                            <table cellpadding="0" cellspacing="0" border="0"
                                   class="table table-bordered table-hover table-striped" style="margin-bottom: 5px;">

                                <thead>
                                <tr>
                                    <th><?= lang("products"); ?>
                                    </th>
                                </tr>
                                <tr>
                                    <td>
                                        <?php if($GP['products-list'] == 1) { ?>
                                        <input type="checkbox" value="1" class="checkbox" id="products-list"
                                               name="products-list" <?php echo $p->{'products-list'} ? "checked" : ''; ?>><label
                                            for="list_products"
                                            class="padding05"><?= lang('list_products') ?></label>
                                        <?php }
                                        if($GP['print_barcodes'] == 1) { ?>    
                                        <input type="checkbox" value="1" class="checkbox" id="print_barcodes"
                                               name="print_barcodes" <?php echo $p->{'print_barcodes'} ? "checked" : ''; ?>><label
                                            for="print_barcodes" class="padding05"><?= lang('print_barcodes') ?></label>
                                        <?php } 
                                        if($GP['print_labels'] == 1) { ?>    
                                        <input type="checkbox" value="1" class="checkbox" id="print_labels"
                                               name="print_labels" <?php echo $p->{'print_labels'} ? "checked" : ''; ?>><label
                                            for="print_labels" class="padding05"><?= lang('print_labels') ?></label> 
                                        <?php }
                                        if($GP['import_product'] == 1) { ?>
                                        <input type="checkbox" value="1" class="checkbox" id="import_product"
                                               name="import_product" <?php echo $p->{'import_product'} ? "checked" : ''; ?>><label
                                            for="import_product" class="padding05"><?= lang('import_product') ?></label>
                                        <?php } 
                                        if($GP['update_price'] == 1) { ?>    
                                        <input type="checkbox" value="1" class="checkbox" id="update_price"
                                               name="update_price" <?php echo $p->{'update_price'} ? "checked" : ''; ?>><label
                                        for="update_price" class="padding05"><?= lang('update_price') ?></label>  
                                        <?php } 
                                        if($GP['products-quantity_adjustments'] == 1) { ?>    
                                        <input type="checkbox" value="1" class="checkbox" id="quantity_adjustments"
                                               name="products-quantity_adjustments" <?php echo $p->{'products-quantity_adjustments'} ? "checked" : ''; ?>><label
                                        for="quantity_adjustments" class="padding05"><?= lang('quantity_adjustments') ?></label>  
                                        <?php } 
                                        if($GP['products-quantity_excel']) { ?>
                                        <input type="checkbox" value="1" class="checkbox" id="products-quantity_excel"
                                           name="products-quantity_excel" <?php echo $p->{'products-quantity_excel'} ? "checked" : ''; ?>><label
                                        for="products-quantity_excel" class="padding05"><?= lang('products-quantity_excel') ?></label> 
                                        <?php } 
                                        if($GP['products-quantity_pdf']) { ?>
                                        <input type="checkbox" value="1" class="checkbox" id="products-quantity_pdf"
                                           name="products-quantity_pdf" <?php echo $p->{'products-quantity_pdf'} ? "checked" : ''; ?>><label
                                        for="products-quantity_pdf" class="padding05"><?= lang('products-quantity_pdf') ?></label> 
                                        <?php } 
                                        if($GP['products-quantity_delete']) { ?>
                                        <input type="checkbox" value="1" class="checkbox" id="products-quantity_pdf"
                                           name="products-quantity_delete" <?php echo $p->{'products-quantity_delete'} ? "checked" : ''; ?>><label
                                           for="products-quantity_delete" class="padding05"><?= lang('products-quantity_delete') ?></label>
                                        <?php } ?>                                                                              
                                    </td>
                                </tr>
                                </thead>
                            </table>
                        </div>                
                        <div class="table-responsive">
                            <table cellpadding="0" cellspacing="0" border="0"
                                   class="table table-bordered table-hover table-striped" style="margin-bottom: 5px;">

                                <thead>
                                <tr>
                                    <th><?= lang("sales"); ?>
                                    </th>
                                </tr>
                                <tr>
                                    <td>
                                        <?php if($GP['sales-list'] == 1) { ?> 
                                        <input type="checkbox" value="1" class="checkbox" id="sales-list"
                                               name="sales-list" <?php echo $p->{'sales-list'} ? "checked" : ''; ?>><label
                                            for="sales-list"
                                            class="padding05"><?= lang('list_sales') ?></label>
                                        <?php }
                                        if($GP['add_sale_by_csv'] == 1) { ?>  
                                        <input type="checkbox" value="1" class="checkbox" id="add_sale_by_csv"
                                               name="add_sale_by_csv" <?php echo $p->{'add_sale_by_csv'} ? "checked" : ''; ?>><label
                                            for="add_sale_by_csv" class="padding05"><?= lang('add_sale_by_csv') ?></label>
                                        <?php } 
                                        if($GP['credit_voucher'] == 1) { ?> 
                                        <input type="checkbox" value="1" class="checkbox" id="credit_voucher"
                                               name="credit_voucher" <?php echo $p->{'credit_voucher'} ? "checked" : ''; ?>><label
                                        for="credit_voucher" class="padding05"><?= lang('credit_voucher') ?></label> 
                                        <?php }
                                         if($GP['sales-return_sales'] == 1) { ?>
                                        <input type="checkbox" value="1" id="sales-return_sales" class="checkbox"
                                               name="sales-return_sales" <?php echo $p->{'sales-return_sales'} ? "checked" : ''; ?>><label
                                        for="sales-return_sales" class="padding05"><?= lang('return_sales') ?></label> <?php } ?>                                         
                                    </td>
                                </tr>
                                </thead>
                            </table>
                        </div>                       
                        <div class="table-responsive">
                            <table cellpadding="0" cellspacing="0" border="0"
                                   class="table table-bordered table-hover table-striped" style="margin-bottom: 5px;">
                                <thead>
                                <tr>
                                    <th><?= lang("purchases"); ?>
                                    </th>
                                </tr>
                                <tr>
                                    <td>
                                        <?php  if($GP['purchases-list'] == 1) { ?>  
                                        <input type="checkbox" value="1" class="checkbox" id="purchases-list"
                                               name="purchases-list" <?php echo $p->{'purchases-list'} ? "checked" : ''; ?>><label
                                            for="list_purchases"
                                        class="padding05"><?= lang('list_purchases') ?></label> 
                                        <?php } 
                                        if($GP['purchase-add_by_csv'] == 1) { ?> 
                                        <input type="checkbox" value="1" class="checkbox" id="purchase-add_by_csv"
                                               name="purchase-add_by_csv" <?php echo $p->{'purchase-add_by_csv'} ? "checked" : ''; ?>><label
                                            for="purchase-add_by_csv"
                                            class="padding05"><?= lang('add_purchase_by_csv') ?></label>
                                        <?php }
                                        if($GP['purchases-expenses'] == 1) { ?>    
                                        <input type="checkbox" value="1" id="purchases-expenses" class="checkbox"
                                               name="purchases-expenses" <?php echo $p->{'purchases-expenses'} ? "checked" : ''; ?>><label
                                        for="purchases-expenses" class="padding05"><?= lang('expenses') ?></label> 
                                        <?php }
                                        if($GP['purchase-expense_add'] == 1) { ?> 
                                        <input type="checkbox" value="1" class="checkbox" id="purchase-expense_add"
                                               name="purchase-expense_add" <?php echo $p->{'purchase-expense_add'} ? "checked" : ''; ?>><label
                                            for="purchase-expense_add"
                                        class="padding05"><?= lang('add_expense') ?></label> <?php } ?>   
                                    </td>
                                </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="table-responsive">
                            <table cellpadding="0" cellspacing="0" border="0"
                                   class="table table-bordered table-hover table-striped" style="margin-bottom: 5px;">
                                <thead>
                                <tr>
                                    <th><?= lang("transfers"); ?>
                                    </th>
                                </tr>
                                <tr>
                                    <td>
                                        <?php  if($GP['transfers-list'] == 1) { ?> 
                                        <input type="checkbox" value="1" class="checkbox" id="transfers-list"
                                               name="transfers-list" <?php echo $p->{'transfers-list'} ? "checked" : ''; ?>><label
                                            for="transfers-list"
                                            class="padding05"><?= lang('list_transfers') ?></label>
                                        <?php } 
                                        if($GP['transfers-add_by_csv'] == 1) { ?>
                                        <input type="checkbox" value="1" class="checkbox" id="transfers-add_by_csv"
                                               name="transfers-add_by_csv" <?php echo $p->{'transfers-add_by_csv'} ? "checked" : ''; ?>><label
                                            for="transfers-add_by_csv"
                                        class="padding05"><?= lang('add_transfer_by_csv') ?></label> <?php } ?>
                                    </td>
                                </tr>
                                </thead>
                            </table>
                        </div>
                        <div class="table-responsive">
                            <table cellpadding="0" cellspacing="0" border="0"
                                   class="table table-bordered table-hover table-striped" style="margin-bottom: 5px;">

                                <thead>
                                <tr>
                                    <th><?= lang("people"); ?>
                                    </th>
                                </tr>
                                <tr>
                                    <td>
                                        <?php  if($GP['users_list'] == 1) { ?> 
                                        <input type="checkbox" value="1" class="checkbox" id="users_list"
                                               name="users_list" <?php echo $p->{'users_list'} ? "checked" : ''; ?>><label
                                            for="users_list" class="padding05"><?= lang('list_users') ?></label>
                                        <?php }
                                        if($GP['users-add'] == 1) { ?> 
                                        <input type="checkbox" value="1" class="checkbox" id="users-add"
                                               name="users-add" <?php echo $p->{'users-add'} ? "checked" : ''; ?>><label
                                            for="users-add"  class="padding05"><?= lang('add_user') ?></label>
                                        <?php }
                                        if($GP['billers-list'] == 1) { ?> 
                                        <input type="checkbox" value="1" class="checkbox" id="billers-list"
                                               name="billers-list" <?php echo $p->{'billers-list'} ? "checked" : ''; ?>><label
                                            for="billers-list" class="padding05"><?= lang('list_billers') ?></label>
                                        <?php } 
                                        if($GP['billers-add'] == 1) { ?> 
                                        <input type="checkbox" value="1" class="checkbox" id="biller-add"
                                               name="billers-add" <?php echo $p->{'billers-add'} ? "checked" : ''; ?>><label
                                            for="biller-add" class="padding05"><?= lang('add_biller') ?></label> 
                                        <?php } 
                                        if($GP['notifications']) { ?>
                                        <input type="checkbox" value="1" class="checkbox" id="notifications"
                                               name="notifications" <?php echo $p->{'notifications'} ? "checked" : ''; ?>><label
                                            for="notifications" class="padding05"><?= lang('notifications') ?></label>
                                        <?php } ?>    
                                    </td>
                                </tr>
                                </thead>
                            </table>
                        </div>
                        <?php if(!$this->Manager && ! $this->Sales) { ?>
                        <div class="table-responsive">
                            <table cellpadding="0" cellspacing="0" border="0"
                                   class="table table-bordered table-hover table-striped" style="margin-bottom: 5px;">

                                <thead>
                                <tr>
                                    <th><?= lang("settings"); ?>
                                    </th>
                                </tr>
                                <tr>
                                    <td>
                                        <?php  if($GP['settings-index']) { ?> 
                                        <input type="checkbox" value="1" class="checkbox" id="settings-index"
                                               name="settings-index" <?php echo $p->{'settings-index'} ? "checked" : ''; ?>><label
                                            for="settings-index"
                                            class="padding05"><?= lang('settings') ?></label>
                                        <?php } 
                                        if($GP['system_settings']) { ?>    
                                        <input type="checkbox" value="1" class="checkbox" id="system_settings"
                                               name="system_settings" <?php echo $p->{'system_settings'} ? "checked" : ''; ?>><label
                                            for="system_settings"
                                            class="padding05"><?= lang('system_settings') ?></label>
                                        <?php } 
                                        if($GP['pos_settings']) { ?>    
                                        <input type="checkbox" value="1" class="checkbox" id="pos_settings"
                                               name="pos_settings" <?php echo $p->{'pos_settings'} ? "checked" : ''; ?>><label
                                            for="pos_settings"
                                            class="padding05"><?= lang('pos_settings') ?></label>
                                        <?php } 
                                        if($GP['change_logo']) { ?>     
                                        <input type="checkbox" value="1" class="checkbox" id="change_logo"
                                               name="change_logo" <?php echo $p->{'change_logo'} ? "checked" : ''; ?>><label
                                            for="change_logo"
                                            class="padding05"><?= lang('change_logo') ?></label>
                                        <?php } 
                                        if($GP['currencies']) { ?>       
                                        <input type="checkbox" value="1" class="checkbox" id="currencies"
                                               name="currencies" <?php echo $p->{'currencies'} ? "checked" : ''; ?>><label
                                            for="currencies" class="padding05"><?= lang('currencies') ?></label>
                                        <?php } 
                                        if($GP['customer_groups']) { ?>        
                                        <input type="checkbox" value="1" class="checkbox" id="customer_groups"
                                               name="customer_groups" <?php echo $p->{'customer_groups'} ? "checked" : ''; ?>><label
                                            for="customer_groups" class="padding05"><?= lang('customer_groups') ?></label>
                                        <?php } 
                                        if($GP['categories']) { ?>     
                                        <input type="checkbox" value="1" class="checkbox" id="categories"
                                               name="categories" <?php echo $p->{'categories'} ? "checked" : ''; ?>><label
                                            for="categories" class="padding05"><?= lang('categories') ?></label><br>
                                        <?php } 
                                        if($GP['variants']) { ?>      
                                        <input type="checkbox" value="1" class="checkbox" id="variants"
                                               name="variants" <?php echo $p->{'variants'} ? "checked" : ''; ?>><label
                                               for="variants" class="padding05"><?= lang('variants') ?></label>
                                        <?php } 
                                        if($GP['tax_rates']) { ?>        
                                        <input type="checkbox" value="1" class="checkbox" id="tax_rates"
                                               name="tax_rates" <?php echo $p->{'tax_rates'} ? "checked" : ''; ?>><label
                                            for="tax_rates" class="padding05"><?= lang('tax_rates') ?></label>
                                        <input type="checkbox" value="1" class="checkbox" id="warehouses"
                                               name="warehouses" <?php echo $p->{'warehouses'} ? "checked" : ''; ?>><label
                                            for="warehouses" class="padding05"><?= lang('warehouses') ?></label>
                                        <?php } 
                                        if($GP['email_templates']) { ?>     
                                        <input type="checkbox" value="1" class="checkbox" id="email_templates"
                                               name="email_templates" <?php echo $p->{'email_templates'} ? "checked" : ''; ?>><label
                                            for="email_templates" class="padding05"><?= lang('email_templates') ?></label>
                                        <?php } 
                                        if($GP['group_permissions']) { ?>    
                                        <input type="checkbox" value="1" class="checkbox" id="group_permissions"
                                               name="group_permissions" <?php echo $p->{'group_permissions'} ? "checked" : ''; ?>><label
                                            for="group_permissions" class="padding05"><?= lang('group_permissions') ?></label>
                                        <?php } 
                                        if($GP['backups']) { ?>     
                                        <input type="checkbox" value="1" class="checkbox" id="backups"
                                               name="backups" <?php echo $p->{'backups'} ? "checked" : ''; ?>><label
                                            for="backups" class="padding05"><?= lang('backups') ?></label>
                                        <?php } 
                                        if($GP['update_version']) { ?>     
                                        <input type="checkbox" value="1" class="checkbox" id="update_version"
                                               name="update_version" <?php echo $p->{'update_version'} ? "checked" : ''; ?>><label
                                            for="update_version" class="padding05"><?= lang('update_version') ?></label> 
                                        <?php } ?>     
                                    </td>
                                </tr>
                                </thead>
                            </table>
                        </div>  
                        <?php } ?>
                        <div class="table-responsive">
                            <table cellpadding="0" cellspacing="0" border="0"
                                   class="table table-bordered table-hover table-striped" style="margin-bottom: 5px;">

                                <thead>
                                <tr>
                                    <th><?= lang("reports"); ?>
                                    </th>
                                </tr>
                                <tr>
                                    <td>
                                        <?php if($GP['reports-index']==1) { ?>
                                         <input type="checkbox" value="1" class="checkbox" id="reports-index"
                                               name="reports-index" <?php echo $p->{'reports-index'} ? "checked" : ''; ?>><label
                                            for="reports-index"
                                            class="padding05"><?= lang('reports') ?></label>
                                        <?php } 
                                        if($GP['overview_chart']==1) { ?> 
                                        <input type="checkbox" value="1" class="checkbox" id="overview_chart"
                                               name="overview_chart" <?php echo $p->{'overview_chart'} ? "checked" : ''; ?>><label
                                            for="overview_chart"
                                            class="padding05"><?= lang('overview_chart') ?></label>
                                        <?php }
                                        if($GP['reports-warehouse_stock']==1) { ?> 
                                        <input type="checkbox" value="1" class="checkbox" id="reports-warehouse_stock"
                                               name="reports-warehouse_stock" <?php echo $p->{'reports-warehouse_stock'} ? "checked" : ''; ?>><label
                                            for="reports-warehouse_stock"
                                            class="padding05"><?= lang('warehouse_stock_chart') ?></label>
                                        <?php }
                                        if($GP['register_report']==1) { ?>     
                                        <input type="checkbox" value="1" class="checkbox" id="register_report"
                                               name="register_report" <?php echo $p->{'register_report'} ? "checked" : ''; ?>><label
                                            for="register_report" class="padding05"><?= lang('register_report') ?></label>
                                        <?php }
                                        if($GP['reports-quantity_alerts']==1) { ?>     
                                        <input type="checkbox" value="1" class="checkbox" id="product_quantity_alerts"
                                               name="reports-quantity_alerts" <?php echo $p->{'reports-quantity_alerts'} ? "checked" : ''; ?>><label
                                            for="product_quantity_alerts"
                                            class="padding05"><?= lang('product_quantity_alerts') ?></label><br>
                                        <?php }
                                        if($GP['reports-expiry_alerts']==1) { ?>     
                                        <input type="checkbox" value="1" class="checkbox" id="Product_expiry_alerts"
                                               name="reports-expiry_alerts" <?php echo $p->{'reports-expiry_alerts'} ? "checked" : ''; ?>><label
                                            for="Product_expiry_alerts"
                                            class="padding05"><?= lang('product_expiry_alerts') ?></label>
                                        <?php }
                                        if($GP['reports-products']==1) { ?>      
                                        <input type="checkbox" value="1" class="checkbox" id="products"
                                               name="reports-products" <?php echo $p->{'reports-products'} ? "checked" : ''; ?>><label
                                            for="products" class="padding05"><?= lang('products') ?></label>
                                        <?php }
                                        if($GP['categories_report']==1) { ?>     
                                        <input type="checkbox" value="1" class="checkbox" id="categories_report"
                                               name="categories_report" <?php echo $p->{'categories_report'} ? "checked" : ''; ?>><label
                                            for="categories_report" class="padding05"><?= lang('categories_report') ?></label>
                                        <?php }
                                        if($GP['reports-daily_sales']==1) { ?>  
                                        <input type="checkbox" value="1" class="checkbox" id="daily_sales"
                                               name="reports-daily_sales" <?php echo $p->{'reports-daily_sales'} ? "checked" : ''; ?>><label
                                            for="daily_sales" class="padding05"><?= lang('daily_sales') ?></label>
                                        <?php }
                                        if($GP['reports-monthly_sales']==1) { ?>    
                                        <input type="checkbox" value="1" class="checkbox" id="monthly_sales"
                                               name="reports-monthly_sales" <?php echo $p->{'reports-monthly_sales'} ? "checked" : ''; ?>><label
                                            for="monthly_sales" class="padding05"><?= lang('monthly_sales') ?></label>
                                        <?php }
                                        if($GP['reports-sales']==1) { ?>    
                                        <input type="checkbox" value="1" class="checkbox" id="reports-sales"
                                               name="reports-sales" <?php echo $p->{'reports-sales'} ? "checked" : ''; ?>><label
                                            for="reports-sales" class="padding05"><?= lang('sales_report') ?></label>
                                        <?php }
                                        if($GP['reports-payments']==1) { ?>      
                                        <input type="checkbox" value="1" class="checkbox" id="payments"
                                               name="reports-payments" <?php echo $p->{'reports-payments'} ? "checked" : ''; ?>><label
                                            for="payments" class="padding05"><?= lang('payments') ?></label>
                                        <?php }
                                        if($GP['reports-profit_loss']==1) { ?>    
                                        <input type="checkbox" value="1" class="checkbox" id="reports-profit_loss"
                                               name="reports-profit_loss" <?php echo $p->{'reports-profit_loss'} ? "checked" : ''; ?>><label
                                            for="reports-profit_loss" class="padding05"><?= lang('profit_loss') ?></label>   
                                        <?php }
                                        if($GP['reports-purchases']==1) { ?>     
                                        <input type="checkbox" value="1" class="checkbox" id="purchases"
                                               name="reports-purchases" <?php echo $p->{'reports-purchases'} ? "checked" : ''; ?>><label
                                            for="purchases" class="padding05"><?= lang('purchases') ?></label>
                                        <?php }
                                        if($GP['reports-customers']==1) { ?>    
                                        <input type="checkbox" value="1" class="checkbox" id="customers"
                                               name="reports-customers" <?php echo $p->{'reports-customers'} ? "checked" : ''; ?>><label
                                            for="customers" class="padding05"><?= lang('customers') ?></label>
                                        <?php }
                                        if($GP['reports-suppliers']==1) { ?>     
                                        <input type="checkbox" value="1" class="checkbox" id="suppliers"
                                               name="reports-suppliers" <?php echo $p->{'reports-suppliers'} ? "checked" : ''; ?>><label
                                            for="suppliers" class="padding05"><?= lang('suppliers') ?></label>
                                        <?php }
                                        if($GP['staff_report']==1) { ?>   
                                        <input type="checkbox" value="1" class="checkbox" id="staff_report"
                                               name="staff_report" <?php echo $p->{'staff_report'} ? "checked" : ''; ?>><label
                                        for="staff_report" class="padding05"><?= lang('staff_report') ?></label> <?php } ?>   
                                    </td>
                                </tr>
                                </thead>
                            </table>
                        </div>
                
                    <?php } ?>    
                    <!-- **** Added By Anil End ****-->    
               
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary"><?=lang('update')?></button>
                            <a class="tip btn btn-primary" href="<?php echo base_url('system_settings/groupPermissionsPdf/'.$id); ?>" title="" data-original-title="PDF">PDF</a>
                        </div>
                
                                
                           
                        <?php echo form_close();
                    } else {
						echo '<div class="alert alert-danger">
							<strong>Danger! </strong>'.$this->lang->line("group_not_allowed_show").' 
						</div>';
                    }
                } else {
                    echo '<div class="alert alert-danger">
							<strong>Danger! </strong>'.$this->lang->line("group_not_allowed_show").' 
						</div>';
                } ?>


            </div>
        </div>
    </div>
</div>