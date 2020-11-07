<?php defined('BASEPATH') OR exit('No direct script access allowed');

/*
* Script: pos_lang.php
*   English translation file
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

// For quick cash buttons -  if you need to format the currency please do it according to you system settings
$lang['quick_cash_notes']               = array('1','2','5','10', '20', '50', '100', '500', '1000','2000');

$lang['pos_module']                     = "POS Module";
$lang['cat_limit']                      = "Display Categories";
$lang['pro_limit']                      = "Display Products";
$lang['default_category']               = "Default Category";
$lang['default_customer']               = "Default Customer";
$lang['default_biller']                 = "Default Biller";
$lang['pos_settings']                   = "POS Settings";
$lang['barcode_scanner']                = "Barcode Scanner";
$lang['x']                              = "X";
$lang['qty']                            = "Qty";
$lang['unit']                            = "Unit";
$lang['total_items']                    = "Total Items";
$lang['total_payable']                  = "Total Payable";
$lang['total_sales']                    = "Total Sales";
$lang['tax1']                           = "Tax 1";
$lang['total_x_tax']                    = "Total";
$lang['cancel']                         = "Cancel";
$lang['payment']                        = "Payment";
$lang['pos']                            = "POS";
$lang['p_o_s']                          = "Point of Sale";
$lang['today_sale']                     = "Today's Sale";
$lang['daily_sales']                    = "Daily Sales";
$lang['monthly_sales']                  = "Monthly Sales";
$lang['pos_settings']                   = "POS Settings";
$lang['loading']                        = "Loading...";
$lang['display_time']                   = "Display Time";
$lang['pos_setting_updated']            = "POS settings successfully updated";
$lang['pos_setting_updated_payment_failed'] = "POS settings successfully saved but payment gateways settings failed. Please try again";
$lang['tax_request_failed']             = "Request Failed, There is some problem with tax rate!";
$lang['pos_error']                      = "An error occurred in the calculation. Please add products again. Thank you!";
$lang['qty_limit']                      = "You have reached the quantity limit 999.";
$lang['max_pro_reached']                = "Max Allowed Reached! Please add payment for this and open new bill for all next items. Thank you!";
$lang['code_error']                     = "Request Failed, Please check your code and try again!";
$lang['x_total']                        = "Please add product before payment. Thank you!";
$lang['paid_l_t_payable']               = "Paid amount is less than the payable amount.you cannot submit the sale.";
$lang['paid_g_t_payable']               = "Paid amount is greater than the payable amount.you cannot submit the sale.";
$lang['suspended_sales']                = "Hold Sales";//"Suspended Sales";
$lang['sale_suspended']                 = "Sale Successfully Suspended.";
$lang['sale_suspend_failed']            = "Hold Sale Failed. Please try again!";
$lang['add_to_pos']                     = "Add this sale to pos screen";
$lang['delete_suspended_sale']          = "Delete this suspended sale";
$lang['save']                           = "Save";
$lang['discount_request_failed']        = "Request Failed, There is some problem with discount!";
$lang['saving']                         = "Saving...";
$lang['paid_by']                        = "Paid by";
$lang['paid']                           = "Paid";
$lang['ajax_error']                     = "Request Failed, Please try again!";
$lang['close']                          = "Close";
$lang['finalize_sale']                  = "Finalize Sale";
$lang['cash_sale']                      = "Cash Payment";
$lang['cc_sale']                        = "Credit Card Payment";
$lang['dc_sale']                        = "Dedit Card Payment";
$lang['cn_sale']                        = "Credit Note Payment";
$lang['ch_sale']                        = "Cheque Payment";
$lang['sure_to_suspend_sale']           = "Are you sure you want to suspend Sale?";
$lang['leave_alert']                    = "You will lose sale data. Press OK to leave and Cancel to Stay on this page.";
$lang['sure_to_cancel_sale']            = "Are you sure you want to Cancel Sale?";
$lang['sure_to_submit_sale']            = "Are you sure you want to Submit Sale?";
$lang['alert_x_sale']                   = "Are you sure you want to delete this suspended sale?";
$lang['suspended_sale_deleted']         = "Hold sale successfully deleted";
$lang['item_count_error']               = "An error occurred while counting the total items. Please try again!";
$lang['x_suspend']                      = "Please add product before suspending the sale. Thank you!";
$lang['x_cancel']                       = "There is no product. Thank you!";
$lang['yes']                            = "Yes";
$lang['no1']                            = "No";
$lang['suspend']                        = "Suspend";
$lang['order_list']                     = "Order List";
$lang['print']                          = "Print";
$lang['cf_display_on_bill']             = "Custom Field to display on pos receipt";
$lang['cf_title1']                      = "Custom Field 1 Title";
$lang['cf_value1']                      = "Custom Field 1 Value";
$lang['cf_title2']                      = "Custom Field 2 Title";
$lang['cf_value2']                      = "Custom Field 2 Value";
$lang['cf_title3']                      = "Custom Field 3 Title";
$lang['cf_value3']                      = "Custom Field 3 Value";
$lang['cf_title4']                      = "Custom Field 4 Title";
$lang['cf_value4']                      = "Custom Field 4 Value";
$lang['cf_title5']                      = "Custom Field 5 Title";
$lang['cf_value5']                      = "Custom Field 5 Value";
$lang['cf_title6']                      = "Custom Field 6 Title";
$lang['cf_value6']                      = "Custom Field 6 Value";
$lang['cash']                           = "Cash";
$lang['cc']                             = "Credit/Debit Card";
$lang['cheque']                         = "Cheque";
$lang['cc_no']                          = "Credit/Debit Card No";
$lang['cc_holder']                      = "Holder Name";
$lang['cheque_no']                      = "Cheque No";
$lang['email_sent']                     = "Email successfully sent!";
$lang['email_failed']                   = "Send email function failed!";
$lang['back_to_pos']                    = "Back to POS";
$lang['shortcuts']                      = "Shortcuts";
$lang['shortcut_key']                   = "Shortcut Key";
$lang['shortcut_keys']                  = "Shortcut Keys";
$lang['keyboard']                       = "Keyboard";
$lang['onscreen_keyboard']              = "On-Screen Keyboard";
$lang['focus_add_item']                 = "Focus Add Item Input";
$lang['add_manual_product']             = "Add Manual Item to Sale";
$lang['customer_selection']             = "Customer Input";
$lang['toggle_category_slider']         = "Toggle Categories Slider";
$lang['toggle_subcategory_slider']      = "Toggle Subcategories Slider";
$lang['cancel_sale']                    = "Cancel Sale";
$lang['suspend_sale']                   = "Hold Sale";
$lang['print_items_list']               = "Print items list";
$lang['finalize_sale']                  = "Finalize Sale";
$lang['open_hold_bills']                = "Open Suspended Sales";
$lang['search_product_by_name_code']    = "Scan/Search product by name/code";
$lang['receipt_printer']                = "Receipt Printer";
$lang['cash_drawer_codes']              = "Open Cash Drawer Code";
$lang['pos_list_printers']              = "POS List Printers (Separated by |)";
$lang['custom_fileds']                  = "Custom fields for receipt";
$lang['shortcut_heading']               = "Ctrl, Shift and Alt with any other letter (Ctrl+Shift+A). Function keys (F1 - F12) are supported too.";
$lang['product_button_color']           = "Product Button Color";
$lang['edit_order_tax']                 = "Edit Order Tax";
$lang['select_order_tax']               = "Select Order Tax";
$lang['paying_by']                      = "Paying by";
$lang['paypal_pro']                     = "Paypal Pro";
$lang['stripe']                         = "Stripe";
$lang['swipe']                          = "Swipe";
$lang['card_type']                      = "Card Type";
$lang['Visa']                           = "Visa";
$lang['MasterCard']                     = "MasterCard";
$lang['Amex']                           = "Amex";
$lang['Discover']                       = "Discover";
$lang['Rupay']                          = "Rupay";
$lang['Diners']                         = "Diners";
$lang['Electron']                       = "Electron";
$lang['Jcb']                            = "Jcb";
$lang['month']                          = "Month of Expire";
$lang['year']                           = "Year of Expire";
$lang['cvv2']                           = "Approval No";
$lang['sales_executives']               = "Sales Executives";
$lang['total_paying']                   = "To be Paid";
$lang['balance']                        = "Balance";
$lang['serial_no']                      = "Serial No";
$lang['product_discount']               = "Product Discount";
$lang['max_reached']                    = "Max allowed limit reached.";
$lang['add_more_payments']              = "Add More Payments";
$lang['sell_gift_card']                 = "Add Credit Note";
$lang['gift_card']                      = "Credit Note";
$lang['product_option']                 = "Product Option";
$lang['card_no']                        = "Card No";
$lang['value']                          = "Value";
$lang['paypal']                         = "Paypal";
$lang['sale_added']                     = "POS Sale successfully added";
$lang['invoice']                        = "Invoice";
$lang['vat']                            = "VAT";
$lang['web_print']                      = "Web Print";
$lang['ajax_request_failed']            = "Ajax request failed, pleas try again";
$lang['pos_config']                     = "POS Configuration";
$lang['default']                        = "Default";
$lang['primary']                        = "Primary";
$lang['info']                           = "Info";
$lang['warning']                        = "Warning";
$lang['danger']                         = "Danger";
$lang['enable_java_applet']             = "Enable Java Applet";
$lang['update_settings']                = "Update Settings";
$lang['open_register']                  = "Open Register";
$lang['close_register']                 = "Close Register";
$lang['cash_in_hand']                   = "Opening Balance";
$lang['total_cash']                     = "Total Cash";
$lang['quantity']                       = "Balance Quantity";
$lang['qtys']                           = "Quantity";
$lang['total_cash_submitted']           = "Total Cash";
$lang['total_cheques']                  = "Total Cheques";
$lang['total_cc_slips']                 = "Total Credit Card Slips";
$lang['CC']                             = "Credit Card";
$lang['register_closed']                = "Register successfully closed";
//$lang['register_not_open']              = "Register is not open, Please enter the cash in hand amount and click open register";
$lang['register_not_open']              = "Register is not open, Please click open register and may be enter cash in hand amount";
$lang['welcome_to_pos']                 = "Welcome to POS";
$lang['tooltips']                       = "Tool tips";
$lang['previous']                       = "Previous";
$lang['next']                           = "Next";
$lang['payment_gateways']               = "Payment Gateways";
$lang['stripe_secret_key']              = "Stripe Secret Key";
$lang['stripe_publishable_key']         = "Stripe Publishable Key";
$lang['APIUsername']                    = "Paypal Pro API Username";
$lang['APIPassword']                    = "Paypal Pro API Password";
$lang['APISignature']                   = "Paypal Pro API Signature";
$lang['view_bill']                      = "View Bill";
$lang['view_bill_screen']               = "View Bill Screen";
$lang['opened_bills']                   = "Opened Bills";
$lang['leave_opened']                   = "Leave Opened";
$lang['delete_bill']                    = "Delete Bill";
$lang['delete_all']                     = "Delete All";
$lang['transfer_opened_bills']          = "Transfer Opened Bills";
$lang['paypal_empty_error']             = "Paypal transaction failed (Empty error array returned)";
$lang['payment_failed']                 = "<strong>Payment Failed!</strong>";
$lang['pending_amount']                 = "Pending Amount";
$lang['available_amount']               = "Available Amount";
$lang['stripe_balance']                 = "Stripe Balance";
$lang['paypal_balance']                 = "Paypal Balance";
$lang['view_receipt']                   = "View Receipt";
$lang['rounding']                       = "Rounding";
$lang['ppp']                            = "Paypal Pro";
$lang['delete_sale']                    = "Delete Sale";
$lang['return_sale']                    = "Return Sale";
$lang['edit_sale']                      = "Edit Sale";
$lang['email_sale']                     = "Email Sale";
$lang['add_delivery']                   = "Add Delivery";
$lang['add_payment']                    = "Add Payment";
$lang['view_payments']                  = "View Payments";
$lang['no_meil_provided']               = "No email address provided";
$lang['payment_added']                  = "Payment successfully added";
$lang['suspend_sale']                   = "Hold Sale";
$lang['reference_note']                 = "Reference Note";
$lang['type_reference_note']            = "Please type reference note and submit to suspend this sale";
$lang['change']                         = "Change";
$lang['quick_cash']                     = "Quick Cash";
$lang['sales_person']                   = "Sales Associate";
$lang['no_opeded_bill']                 = "No opened bill found";
$lang['please_update_settings']         = "Please update the settings before using the POS";
$lang['order']                          = "Order";
$lang['bill']                           = "Bill";
$lang['due']                            = "Due";
$lang['paid_amount']                    = "Paid Amount";
$lang['due_amount']                     = "Due Amount";
$lang['edit_order_discount']            = "Edit Order Discount";
$lang['sale_note']                      = "Remarks";
$lang['staff_note']                     = "Staff Note";
$lang['list_open_registers']            = "List Open Registers";
$lang['open_registers']                 = "Open Registers";
$lang['opened_at']                      = "Opened at";
$lang['all_registers_are_closed']       = "All registers are closed";
$lang['review_opened_registers']        = "Please review all opened registers in table below";
$lang['suspended_sale_loaded']          = "Hold sale successfully loaded";
$lang['incorrect_gift_card']            = "Credit Note number is incorrect or expired.";
$lang['gift_card_not_for_customer']     = "Credit Note number is not for this customer.";
$lang['delete_sales']                   = "Delete Sales";
$lang['click_to_add']                   = "Please click the button below to open";
$lang['tax_summary']                    = "Tax Summary";
$lang['qty']                            = "Qty";
$lang['tax_excl']                       = "Tax Excl";
$lang['tax_amt']                        = "Tax Amt";
$lang['total_tax_amount']               = "Total Tax Amount";
$lang['tax_invoice']                    = "TAX INVOICE";
$lang['char_per_line']                  = "Characters per line";
$lang['delete_code']                    = "POS Pin Code";
$lang['quantity_out_of_stock_for_%s']   = "The quantity is out of stock for %s";
$lang['refunds']                        = "Refunds";
$lang['register_details']               = "Register Details";
$lang['payment_note']                   = "Payment Note";
$lang['to_nearest_005']                 = "To nearest 0.05";
$lang['to_nearest_050']                 = "To nearest 0.50";
$lang['to_nearest_number']              = "To nearest number (integer)";
$lang['to_next_number']                 = "To next number (integer)";
$lang['update_heading']                 = "This page will help you check and install the updates easily with single click. <strong>If there are more than 1 updates available, please update them one by one starting from the top (lowest version)</strong>.";
$lang['update_successful']              = "Item successfully updated";
$lang['using_latest_update']            = "You are using the latest version.";
$lang['order_discount']            	= "Order Discount";
$lang['discount_reason']		= "Invoice Discount Reason";
$lang['first_name']			= "First name is required";
$lang['max_pan_limit']			= "PAN limit price";
$lang['discount_g_t_total']		= "Discount value cannot be greater than grand total";
// Add by Ankit @ 4 May 2016
$lang['hold']				= "Hold";
$lang['store_id']				= "Store ID: ";
$lang['total_credit_card_amount']       = "Total Credit Card Amount"; 
$lang['total_credit_voucher_amount']    = "Total Credit Note Amount";
$lang['total_amount']                   = "Total Amount";

$lang['invoice_number']                 = "Invoice Number";
$lang['customer_service_detail']        = "Customer Service Detail";
// add by ajay
$lang['line_item_discount']             = "Line Item Discount";
$lang['invoice_discount']               = "Invoice Discount";
$lang['both_discount']                  = "Both Discount";
$lang['sales_exe_id']                   = "Sales Executive id";
$lang['sales_exe']                      = "Sales Executive";
$lang['invoice_discount_not_allowed']   = "Invoice discount not allowed";
$lang['order_discount_type']			= "Select order discount type";
$lang['reference_no']			        = "Reference No";
$lang['ref']			        = "Invoice No";
$lang['serial_no']			            = "Sr.No";
$lang['description']			        = "Description";
$lang['discount_l_t_total']				= "Discount value cannot be less than grand total";
$lang['store_name']                     = "Store Name";
$lang['store_address']                  = "Address";
$lang['customer_name']                  = "Customer Name";
$lang['customer_contact']               = "Contact No.";
$lang['discount']               	= "Discount";
$lang['basic']               		= "Basic";
$lang['tax']                            = "VAT Amount(%)";
$lang['tax_included']                   = "Tax Included";
$lang['net_amount']                     = "Net Amount";
$lang['net_amount_pdf']                 = "Net Amount";
$lang['order_tax']               	= "VAT Amount(%)";
$lang['amount_chargeable_words']        = "Amount (in words)";
$lang['save_as_pdf']        		= "Save as Pdf";
$lang['Maestro']        		= "Maestro";
$lang['cc_type']        		= "Card Type";
$lang['credit_card']        		= "Credit Card";
$lang['debit_card']        		= "Debit Card";
//changed by ajay on 02-09-2016
$lang['discount_%_or_flat']   = "If you want to enter Product discount in % , add % after numeric value";
$lang['DC']                             = "Debit Card";
$lang['customer_service']               = "FOC";
$lang['submit']				= "submit";
$lang['paid_placeholder']		= "Select an option";
$lang['print_receipt']                  = "Print Receipt";

//Added by Ajay on 02-09-2016
$lang['order_discount_percent_notice'] = "Order Discount will be calculated as % of grand total";
$lang['order_discount_flat_notice'] = "Entered Order Discount will be subtracted from grand total";
$lang['discount_percent']   = "Discount Percentage";
$lang['enable_walkcustomer']         = "Enable Walking Customer";
$lang['return_sales_perioed']        = "Return Sales Perioed ( In Days )";   
//on 19-12-2016

$lang['discard'] = "Discard";
$lang['credit_debit']                = "Select CC/DC";
$lang['select_card_type']            = "Select card type";
$lang['mrp']                         = "MRP";
$lang['print_invoice']               = "Print Invoice";
$lang['receipt_declaration']         = "Receipt Declarartion";
$lang['service_centers']             = "Service Centers";
$lang['Discount_Reason']             = "Discount Reason";
$lang['domestic']                    = "Domestic";
$lang['international']               = "International";
$lang['card_nation']                 = "Select Card Nationality";
$lang['credit_note_balance']         = "CN Balance";
$lang['cash_deposited']              = "Cash Deposited";
$lang['select_edc']                  = "Select EDC";
$lang['order_tax_val']               = "VAT Amount";
$lang['expiry']                      = "Expiry";
$lang['sale_fail']					 = "There is some problem in processing. Please try again!";
$lang['sgst']						 = "SGST";
$lang['cgst'] 						 = "CGST";
$lang['pan_no']						 = "PAN No.";
$lang['gstin_no']					 = "GSTIN No.";
$lang['state_code']					 = "State Code";
$lang['supply_place']				 = "Place of Supply";
$lang['rate']						 = "Rate";
$lang['amt']						 = "Amt";
$lang['taxable_amount']              = "Taxable Amount" ;
$lang['delivery_challan']			 = "DELIVERY CHALLAN";