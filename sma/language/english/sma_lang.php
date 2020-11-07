<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
 * Module: General Language File for common lang keys
 * Language: English
 *
 * Last edited:
 * 30th April 2015
 *
 * Package:
 * Stock Manage Advance v3.0
 *
 * You can translate this file to your language.
 * For instruction on new language setup, please visit the documentations.
 * You also can share your language files by emailing to saleem@tecdiary.com
 * Thank you
 */

/* --------------------- CUSTOM FIELDS ------------------------ */
/*
* Below are custome field labels
* Please only change the part after = and make sure you change the the words in between "";
* $lang['bcf1']                         = "Biller Custom Field 1";
* Don't change this                     = "You can change this part";
* For support email contact@tecdiary.com Thank you!
*/

$lang['bcf1']                           = "Biller Custom Field 1";
$lang['bcf2']                           = "Biller Custom Field 2";
$lang['bcf3']                           = "Biller Custom Field 3";
$lang['bcf4']                           = "Biller Custom Field 4";
$lang['bcf5']                           = "Biller Custom Field 5";
$lang['bcf6']                           = "Biller Custom Field 6";
$lang['pcf1']                           = "Product Custom Field 1";
$lang['pcf2']                           = "Product Custom Field 2";
$lang['pcf3']                           = "Product Custom Field 3";
$lang['pcf4']                           = "Product Custom Field 4";
$lang['pcf5']                           = "Product Custom Field 5";
$lang['pcf6']                           = "Product Custom Field 6";
$lang['ccf1']                           = "Customer Custom Field 1";
$lang['ccf2']                           = "Customer Custom Field 2";
$lang['ccf3']                           = "Customer Custom Field 3";
$lang['ccf4']                           = "Customer Custom Field 4";
$lang['ccf5']                           = "Customer Custom Field 5";
$lang['ccf6']                           = "Customer Custom Field 6";
$lang['scf1']                           = "Supplier Custom Field 1";
$lang['scf2']                           = "Supplier Custom Field 2";
$lang['scf3']                           = "Supplier Custom Field 3";
$lang['scf4']                           = "Supplier Custom Field 4";
$lang['scf5']                           = "Supplier Custom Field 5";
$lang['scf6']                           = "Supplier Custom Field 6";

/* ----------------- DATATABLES LANGUAGE ---------------------- */
/*
* Below are datatables language entries
* Please only change the part after = and make sure you change the the words in between "";
* 'sEmptyTable'                     => "No data available in table",
* Don't change this                 => "You can change this part but not the word between and ending with _ like _START_;
* For support email support@tecdiary.com Thank you!
*/

$lang['datatables_lang']        = array(
    'sEmptyTable'                   => "No data available in table",
    'sInfo'                         => "Showing _START_ to _END_ of _TOTAL_ entries",
    'sInfoEmpty'                    => "Showing 0 to 0 of 0 entries",
    'sInfoFiltered'                 => "(filtered from _MAX_ total entries)",
    'sInfoPostFix'                  => "",
    'sInfoThousands'                => ",",
    'sLengthMenu'                   => "Show _MENU_ ",
    'sLoadingRecords'               => "Loading...",
    'sProcessing'                   => "Processing...",
    'sSearch'                       => "Search",
    'sZeroRecords'                  => "No matching records found",
    'oAria'                                     => array(
      'sSortAscending'                => ": activate to sort column ascending",
      'sSortDescending'               => ": activate to sort column descending"
      ),
    'oPaginate'                                 => array(
      'sFirst'                        => "<< First",
      'sLast'                         => "Last >>",
      'sNext'                         => "Next >",
      'sPrevious'                     => "< Previous",
      )
    );

/* ----------------- Select2 LANGUAGE ---------------------- */
/*
* Below are select2 lib language entries
* Please only change the part after = and make sure you change the the words in between "";
* 's2_errorLoading'                 => "The results could not be loaded",
* Don't change this                 => "You can change this part but not the word between {} like {t};
* For support email support@tecdiary.com Thank you!
*/

$lang['select2_lang']               = array(
    'formatMatches_s'               => "One result is available, press enter to select it.",
    'formatMatches_p'               => "results are available, use up and down arrow keys to navigate.",
    'formatNoMatches'               => "No matches found",
    'formatInputTooShort'           => "Please type {n} or more characters",
    'formatInputTooLong_s'          => "Please delete {n} character",
    'formatInputTooLong_p'          => "Please delete {n} characters",
    'formatSelectionTooBig_s'       => "You can only select {n} item",
    'formatSelectionTooBig_p'       => "You can only select {n} items",
    'formatLoadMore'                => "Loading more results...",
    'formatAjaxError'               => "Ajax request failed",
    'formatSearching'               => "Searching..."
    );


/* ----------------- SMA GENERAL LANGUAGE KEYS -------------------- */

$lang['home']                               = "Home";
$lang['dashboard']                          = "Dashboard";
$lang['username']                           = "Username";
$lang['password']                           = "Password";
$lang['first_name']                         = "First Name";
$lang['last_name']                          = "Last Name";
$lang['confirm_password']                   = "Confirm Password";
$lang['email']                              = "Email";
$lang['phone']                              = "Mobile";
$lang['company']                            = "Company";
$lang['product_code']                       = "Product Code";
$lang['product_name']                       = "Product Name";
$lang['cname']                              = "Customer Name";
$lang['barcode_symbology']                  = "Barcode Symbology";
$lang['product_unit']                       = "Product Unit";
$lang['product_price']                      = "Product Price";
$lang['contact_person']                     = "Contact Person";
$lang['email_address']                      = "Email Address";
$lang['address']                            = "Address";
$lang['city']                               = "City";
$lang['today']                              = "Today";
$lang['welcome']                            = "Welcome";
$lang['profile']                            = "Profile";
$lang['change_password']                    = "Change Password";
$lang['logout']                             = "Logout";
$lang['notifications']                      = "Notifications";
$lang['calendar']                           = "Calendar";
$lang['messages']                           = "Messages";
$lang['styles']                             = "Styles";
$lang['language']                           = "Language";
$lang['alerts']                             = "Alerts";
$lang['list_products']                      = "List Products";
$lang['add_product']                        = "Add Product";
$lang['print_barcodes']                     = "Print Barcodes";
$lang['print_labels']                       = "Print Labels";
$lang['import_products']                    = "Import Products";
$lang['update_price']                       = "Update Price";
$lang['damage_products']                    = "Damage Product";
$lang['sales']                              = "Sales";
$lang['list_sales']                         = "List Sales";
$lang['add_sale']                           = "Add Sale";
$lang['deliveries']                         = "Deliveries";
$lang['credit_voucher']                     = "Credit Note";
$lang['quotes']                             = "Quotations";
$lang['list_quotes']                        = "List Quotation";
$lang['add_quote']                          = "Add Quotation";
$lang['purchases']                          = "Purchases";
$lang['list_purchases']                     = "List Purchases";
$lang['add_purchase']                       = "Add Purchase";
$lang['add_purchase_by_csv']                = "Add Purchase by CSV";
$lang['transfers']                          = "Transfers";
$lang['list_transfers']                     = "List Transfers";
$lang['add_transfer']                       = "Add Transfer";
$lang['add_transfer_by_csv']                = "Add Transfer by CSV";
$lang['people']                             = "People";
$lang['list_users']                         = "List Users";
$lang['new_user']                           = "Add User";
$lang['list_billers']                       = "List Billers";
$lang['add_biller']                         = "Add Biller";
$lang['list_customers']                     = "List Customers";
$lang['add_customer']                       = "Add Customer";
$lang['list_suppliers']                     = "List Suppliers";
$lang['add_supplier']                       = "Add Supplier";
$lang['settings']                           = "Settings";
$lang['system_settings']                    = "System Settings";
$lang['change_logo']                        = "Change Logo";
$lang['currencies']                         = "Currencies";
$lang['attributes']                         = "Product Variants";
$lang['customer_groups']                    = "Customer Groups";
$lang['categories']                         = "Categories";
$lang['subcategories']                      = "Sub Categories";
$lang['tax_rates']                          = "Tax Rates";
$lang['warehouses']                         = "Stores";
$lang['email_templates']                    = "Email Templates";
$lang['group_permissions']                  = "Group Permissions";
$lang['backup_database']                    = "Backup Database";
$lang['reports']                            = "Reports";
$lang['overview_chart']                     = "Overview Chart";
//$lang['warehouse_stock']                    = "Warehouse Stock Chart";
$lang['warehouse_stock']                    = "Store Stock Chart";
$lang['product_quantity_alerts']            = "Product Quantity Alerts";
$lang['product_expiry_alerts']              = "Product Expiry Alerts";
$lang['products_report']                    = "Products Report";
$lang['daily_sales']                        = "Daily Sales";
$lang['monthly_sales']                      = "Monthly Sales";
$lang['sales_report']                       = "Sales Report";
$lang['payments_report']                    = "Payments Report";
$lang['profit_and_loss']                    = "Profit and/or Loss";
$lang['purchases_report']                   = "Purchases Report";
$lang['customers_report']                   = "Customers Report";
$lang['suppliers_report']                   = "Suppliers Report";
$lang['staff_report']                       = "Staff Report";
$lang['your_ip']                            = "Your IP Address";
$lang['last_login_at']                      = "Last login at";
$lang['notification_post_at']               = "Notification posted at";
$lang['quick_links']                        = "Quick Links";
$lang['date']                               = "Date";
$lang['reference_no']                       = "Invoice No";//"Reference No";
$lang['products']                           = "Products";
$lang['customers']                          = "Customers";
$lang['suppliers']                          = "Suppliers";
$lang['users']                              = "Users";
$lang['latest_five']                        = "Latest Five";
$lang['total']                              = "Total";
$lang['payment_status']                     = "Payment Status";
$lang['paid']                               = "Paid";
$lang['customer']                           = "Customer";
$lang['status']                             = "Status";
$lang['amount']                             = "Amount";
$lang['supplier']                           = "Supplier";
$lang['from']                               = "From";
$lang['to']                                 = "To";
$lang['name']                               = "Name";
$lang['create_user']                        = "Add User";
$lang['gender']                             = "Gender";
$lang['biller']                             = "Biller";
$lang['select']                             = "Select";
//$lang['warehouse']                          = "Warehouse";
$lang['warehouse']                          = "Store";
$lang['active']                             = "Active";
$lang['inactive']                           = "Inactive";
$lang['all']                                = "All";
$lang['list_results']                       = "Please use the table below to navigate or filter the results. You can download the table as excel and pdf.";
$lang['actions']                            = "Actions";
$lang['pos']                                = "POS";
$lang['access_denied']                      = "Access Denied! You don't have right to access the requested page. If you think, it's by mistake, please contact administrator.";
$lang['add']                                = "Add";
$lang['edit']                               = "Edit";
$lang['delete']                             = "Delete";
$lang['view']                               = "View";
$lang['update']                             = "Update";
$lang['save']                               = "Save";
$lang['login']                              = "Login";
$lang['submit']                             = "Submit";
$lang['no']                                 = "No";
$lang['yes']                                = "Yes";
$lang['disable']                            = "Disable";
$lang['enable']                             = "Enable";
$lang['enter_info']                         = "Please fill in the information below. The field labels marked with * are required input fields.";
$lang['update_info']                        = "Please update the information below. The field labels marked with * are required input fields.";
$lang['no_suggestions']                     = "Unable to get data for suggestions, Please check your input";
$lang['i_m_sure']                           = 'Yes I\'m sure';
$lang['r_u_sure']                           = 'Are you sure?';
$lang['export_to_excel']                    = "Export to Excel file";
$lang['export_to_pdf']                      = "Export to PDF file";
$lang['image']                              = "Image";
$lang['sale']                               = "Sale";
$lang['quote']                              = "Quotation";
$lang['purchase']                           = "Purchase";
$lang['transfer']                           = "Transfer";
$lang['payment']                            = "Payment";
$lang['payments']                           = "Payments";
$lang['orders']                             = "Orders";
$lang['pdf']                                = "PDF";
$lang['vat_no']                             = "VAT Number";
$lang['country']                            = "Country";
$lang['add_user']                           = "Add User";
$lang['type']                               = "Type";
$lang['person']                             = "Person";
$lang['state']                              = "State";
$lang['postal_code']                        = "Postal Code";
$lang['id']                                 = "ID";
$lang['close']                              = "Close";
$lang['male']                               = "Male";
$lang['female']                             = "Female";
$lang['notify_user']                        = "Notify User";
$lang['notify_user_by_email']               = "Notify User by Email";
$lang['billers']                            = "Billers";
//$lang['all_warehouses']                     = "All Warehouses";
$lang['all_warehouses']                     = "All Stores";
$lang['category']                           = "Category";
$lang['product_cost']                       = "Product Cost";
$lang['quantity']                           = "Quantity";

$lang['loading_data_from_server']           = "No Record Found";
$lang['excel']                              = "Excel";
$lang['print']                              = "Print";
$lang['ajax_error']                         = "Ajax error occurred, Please tray again.";
$lang['product_tax']                        = "Tax Amount";
$lang['order_tax']                          = "VAT Amount(%)";
$lang['upload_file']                        = "Upload File";
$lang['download_sample_file']               = "Download Sample File";
$lang['csv1']                               = "The first line in downloaded csv file should remain as it is. Please do not change the order of columns.";
$lang['csv2']                               = "The correct column order is";
$lang['csv3']                               = "&amp; you must follow this. If you are using any other language then English, please make sure the csv file is UTF-8 encoded and not saved with byte order mark (BOM)";
$lang['import']                             = "Import";
$lang['note']                               = "Note";
$lang['grand_total']                        = "Grand Total";
$lang['download_pdf']                       = "Download as PDF";
$lang['no_zero_required']                   = "The %s field is required";
$lang['no_product_found']                   = "No product found";
$lang['pending']                            = "Pending";
$lang['sent']                               = "Sent";
$lang['completed']                          = "Completed";
$lang['shipping']                           = "Shipping";
$lang['add_product_to_order']               = "Please add products to order list";
$lang['order_items']                        = "Order Items";
$lang['net_unit_cost']                      = "Net Unit Cost";
$lang['net_unit_price']                     = "Net Unit Price";
$lang['expiry_date']                        = "Expiry Date";
$lang['subtotal']                           = "Subtotal";
$lang['reset']                              = "Reset";
$lang['items']                              = "Items";
$lang['au_pr_name_tip']                     = "Please start typing code/name for suggestions or just scan barcode";
//$lang['no_match_found']                     = "No matching result found! Product might be out of stock in the selected warehouse.";
$lang['no_match_found']                     = "No matching result found! Product might be out of stock in the selected Store.";
$lang['csv_file']                           = "CSV File";
$lang['document']                           = "Attach Document";
$lang['product']                            = "Product";
$lang['user']                               = "User";
$lang['created_by']                         = "Created by";
$lang['loading_data']                       = "Loading table data from server";
$lang['tel']                                = "Tel";
$lang['ref']                                = "Reference";
$lang['description']                        = "Description";
$lang['code']                               = "Code";
$lang['tax']                                = "VAT Amount(%)";
$lang['unit_price']                         = "Unit Price";
$lang['discount']                           = "Discount";
$lang['order_discount']                     = "Order Discount";
$lang['total_amount']                       = "Total Amount";
$lang['download_excel']                     = "Download as Excel";
$lang['subject']                            = "Subject";
$lang['cc']                                 = "CC";
$lang['bcc']                                = "BCC";
$lang['message']                            = "Message";
$lang['show_bcc']                           = "Show/Hide BCC";
$lang['price']                              = "Price";
$lang['add_product_manually']               = "Add Product Manually";
$lang['currency']                           = "Currency";
$lang['product_discount']                   = "Product Discount";
$lang['email_sent']                         = "Email successfully sent";
$lang['add_event']                          = "Add Event";
$lang['add_modify_event']                   = "Add / Modify the Event";
$lang['adding']                             = "Adding...";
$lang['delete']                             = "Delete";
$lang['deleting']                           = "Deleting...";
$lang['calendar_line']                      = "Please click the date to add/modify the event.";
$lang['discount_label']                     = "Discount (5/5%)";
$lang['product_expiry']                     = "product_expiry";
$lang['unit']                               = "Unit";
$lang['cost']                               = "Cost";
$lang['tax_method']                         = "Tax Method";
$lang['inclusive']                          = "Inclusive";
$lang['exclusive']                          = "Exclusive";
$lang['expiry']                             = "Expiry";
$lang['customer_group']                     = "Customer Group";
$lang['is_required']                        = "is required";
$lang['form_action']                        = "Form Action";
$lang['return_sales']                       = "Return Sales";
$lang['list_return_sales']                  = "List Return Sales";
$lang['no_data_available']                  = "No data available";
$lang['disabled_in_demo']                   = "We are sorry but this feature is disabled in demo.";
$lang['payment_reference_no']               = "Payment Reference No";
$lang['gift_card_no']                       = "Credit Note No";
$lang['paying_by']                          = "Paying by";
$lang['cash']                               = "Cash";
$lang['gift_card']                          = "Credit Note";
$lang['CC']                                 = "Credit Card";
$lang['cheque']                             = "Cheque";
$lang['cc_no']                              = "Credit Card No";
$lang['cc_holder']                          = "Holder Name";
$lang['card_type']                          = "Card Type";
$lang['Visa']                               = "Visa";
$lang['MasterCard']                         = "MasterCard";
$lang['Amex']                               = "Amex";
$lang['Discover']                           = "Discover";
$lang['month']                              = "Month";
$lang['year']                               = "Year";
$lang['cvv2']                               = "CVV2";
$lang['cheque_no']                          = "Cheque No";
$lang['Visa']                               = "Visa";
$lang['MasterCard']                         = "MasterCard";
$lang['Amex']                               = "Amex";
$lang['Discover']                           = "Discover";
$lang['send_email']                         = "Send Email";
$lang['order_by']                           = "Ordered by";
$lang['updated_by']                         = "Updated by";
$lang['update_at']                          = "Updated at";
$lang['error_404']                          = "404 Page Not Found ";
$lang['default_customer_group']             = "Default Customer Group";
$lang['pos_settings']                       = "POS Settings";
$lang['pos_sales']                          = "POS Sales";
$lang['seller']                             = "Seller";
$lang['ip:']                                = "IP:";
$lang['sp_tax']                             = "Sold Product Tax";
$lang['pp_tax']                             = "Purchased Product Tax";
$lang['overview_chart_heading']             = "Stock Overview Chart including monthly sales with product tax and  order tax (columns), purchases (line) and current stock value by cost and price (pie). You can save the graph as jpg, png and pdf.";
$lang['stock_value']                        = "Stock Value";
$lang['stock_value_by_price']               = "Stock Value by Price";
$lang['stock_value_by_cost']                = "Stock Value by Cost";
$lang['sold']                               = "Sold";
$lang['purchased']                          = "Purchased";
$lang['chart_lable_toggle']                 = "You can change chart by clicking the chart legend. Click any legend above to show/hide it in chart.";
$lang['register_report']                    = "Register Report";
$lang['sEmptyTable']                        = "No data available in table";
$lang['upcoming_events']                    = "Upcoming Events";
$lang['clear_ls']                           = "Clear all locally saved data";
$lang['clear']                              = "Clear";
$lang['edit_order_discount']                = "Edit Order Discount";
$lang['product_variant']                    = "Product Variant";
$lang['product_variants']                   = "Product Variants";
$lang['prduct_not_found']                   = "Product not found";
$lang['list_open_registers']                = "List Open Registers";
$lang['delivery']                           = "Delivery";
$lang['serial_no']                          = "Serial Number";
$lang['logo']                               = "Logo";
$lang['attachment']                         = "Attachment";
$lang['balance']                            = "Balance";
$lang['nothing_found']                      = "No matching records found";
$lang['db_restored']                        = "Database successfully restored.";
$lang['backups']                            = "Backups";
$lang['best_seller']                        = "Best Seller";
$lang['chart']                              = "Chart";
$lang['received']                           = "Received";
$lang['returned']                           = "Returned";
$lang['award_points']                       = 'Award Points';
$lang['expenses']                           = "Bank Deposit";
$lang['add_expense']                        = "Bank Deposit";
$lang['other']                              = "Other";
$lang['none']                               = "None";
$lang['calculator']                         = "Calculator";
$lang['updates']                            = "Updates";
$lang['update_available']                   = "New update available, please update now.";
//$lang['please_select_customer_warehouse']   = "Please select customer/warehouse";
$lang['please_select_customer_warehouse']   = "Please select customer/Store";
$lang['user_warehouse']                     = "Warehouse";
$lang['variants']                           = "Variants";
$lang['add_sale_by_csv']                    = "Add Sale by CSV";
$lang['categories_report']                  = "Categories Report";
$lang['adjust_quantity']                    = "Adjust Quantity";
$lang['quantity_adjustments']               = "Quantity Adjustments";
$lang['partial']                            = "Partial";
$lang['unexpected_value']                   = "Unexpected value provided!";
$lang['select_above']                       = "Please select a valid customer";
$lang['no_user_selected']                   = "No user selected, please select at least one user";
$lang['due'] 								= "Due";
$lang['ordered'] 							= "Ordered";
$lang['profit'] 						    = "Profit";
$lang['unit_and_net_tip'] 				    = "Calculated on unit (with tax) and net (without tax) i.e <strong>unit(net)</strong> for all sales";
$lang['expiry_alerts'] 						= "Expiry Alerts";
$lang['quantity_alerts'] 					= "Quantity Alerts";
$lang['products_sale']                      = "Products' Revenue";
$lang['products_cost']                      = "Products' Cost";
$lang['day_profit']                         = "Day Profit and/or Loss";
$lang['get_day_profit']                     = "You can click the date to get day's profit and/or loss report.";

$lang['please_select_these_before_adding_product'] = "Please select these before adding any product";

/**
     * Author  Ankit
     * Detail : Key use in dashboard sales tab
     
*/

$lang['sale_details']                            = "Sales Details";
$lang['current_month']                           = "Current Month";
$lang['last_month']                              = "Last Month";
$lang['period_set']                              = "Period Set";
$lang['start_date']                              = "Start Date";
$lang['end_date']                                = "End Date";
$lang['payment_type']                            = "Payment Type";
$lang['select_period']                           = "Select Period to show record";
$lang['get_record']                              = "Get Record";
$lang['ytd_sale']                                = "YTD Sale";
$lang['ytd_sale_year']                           = "YTD Sale (Calendar Year)";
$lang['sales_return']                            = "Sale Return";
$lang['total_tax']                               = "Total Tax";
$lang['sales_discount']                          = "Sale Discount";
$lang['total_discount']                          = "Total Discount";
$lang['paid_by']                                 = "Paid By";
$lang['order_discount_rs']                       = "Discount (In Rs)";//"Order Discount (In Rs)";
$lang['order_discount_pr']                       = "Discount (In %)";//"Order Discount (In %)";
$lang['walk_in_customer']                        = "Please enter your name and mobile number before purchase item.";
$lang['order_tax']                               = "VAT Amount(%)";
$lang['line_item_discount_not_allowed']          = "Line Discount not allowed";
$lang['ytd_payments']              = "YTD Payments";
$lang['ytd_payments_year']              = "YTD Payments (Calendar Year)";
$lang['mrp']                      = "MRP";
$lang['basic_price']              = "Basic Price";
$lang['tax_amount']              = "TAX Amount";
$lang['paid_invoice']              = "Total";


/**
     * Author  Ajay
     * Detail : Key use in dashboard Till tab
     
*/

$lang['till']          = "Manage Till";
$lang['add_till'] = "Add Till";
$lang['manage_till'] = "Manage Till";
$lang['percent_greater_than_100'] = 'Discount % cannot be greater than 100%';
$lang['till_view']                          = "Manage Till View";      // added by Anil 1-09-2016

/*Added By Chitra for Z-report*/
$lang['z_report']           =   "Z-Report";
$lang['select_date']        =   "Select Date to show record";
$lang['date_wise']          =   "Date wise Report";
$lang['shift_no']           =   "Shift #";
$lang['shift_start_date']   =   "Start Date/Time";
$lang['shift_s_date']       =   "Start Date";
$lang['shift_s_time']       =   "Start Time";
$lang['shift_close_date']   =   "Close Date/Time";
$lang['shift_c_date']       =   "Close Date";
$lang['shift_c_time']       =   "Close Time";
$lang['closing_total']      =   "Closing Total";
$lang['closed_by']          =   "Closed By";
$lang['shift_status']       =   "Shift Status";
$lang['open_bal']           =   "Opening Total";
$lang['close_total']        =   "Closing Total";
$lang['over_short']         =   "Excess/Short";
$lang['open_cash']          =   "Cash";
$lang['shift_cash']         =   "Cash";
$lang['close_cash']         =   "Cash";
$lang['debit_shift']        =   "Debit Card";
$lang['credit_shift']       =   "Credit Card";
$lang['debit_close']        =   "Debit Card";
$lang['credit_close']       =   "Credit Card";
$lang['report_date']        =   "Report Date";
$lang['report_time']        =   "Report Time";
$lang['return']             =   "Return Sale";
$lang['shift']              =   "(Shift)";
$lang['close']              =   "(Close)";

/*Updated by Chitra */
$lang['item_name']          =   "Item Name";
$lang['qty']                =   "Qty";
$lang['action']             =   "Action";
$lang['credit_note']        =   "Credit Note";
$lang['credit_note_no']     =   "Credit Note No.";
$lang['warehouse_stock_chart']  =   "Warehouse Stock Chart";
$lang['foc_report']          =   "FoC Report";
$lang['foc']                =   "FoC Report";
$lang['customer_name']      =   "Customer Name";
$lang['mobile']             =   "Mobile";
$lang['all_item_returned']  =   "All Item has already been returned";
$lang['pay_status']       =   "Pay Status";
$lang['users_session_report'] = "Staff Report";
$lang['cgst'] = "CGST";
$lang['sgst'] = "SGST";
$lang['balance_amount'] = "Balance Amount";
/*updated by Rana*/
$lang['reference'] = "Reference";
$lang['cash_open'] = "Opening Cash";
$lang['bank_report'] = "Bank Report";
$lang['bank'] = "Bank";
$lang['created_by'] = "Created By";

