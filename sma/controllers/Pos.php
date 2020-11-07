<?php

defined('BASEPATH') OR exit('No direct script access allowed');
//error_reporting(-1);
class Pos extends MY_Controller {

    function __construct() {
        parent::__construct();
        if (!$this->loggedIn) {
            $this->session->set_userdata('requested_page', $this->uri->uri_string());
            redirect('login');
        }
        if ($this->Customer || $this->Supplier) {
            $this->session->set_flashdata('warning', lang('access_denied'));
            redirect($_SERVER["HTTP_REFERER"]);
        }

        $this->load->model('pos_model');
        $this->load->helper('text');
        $this->pos_settings = $this->pos_model->getSetting();
        $this->pos_settings->pin_code = $this->pos_settings->pin_code ? md5($this->pos_settings->pin_code) : NULL;
        $this->data['pos_settings'] = $this->pos_settings;
        $this->session->set_userdata('last_activity', now());
        $this->lang->load('pos', $this->Settings->language);
        $this->load->library('form_validation');
        $this->load->library('sma');
    }

    function sales($warehouse_id = NULL) {
        
        //***** Added By Anil 21-09-2016 start****        
            $arr_pos_sales = $this->site->checkPermissions();  
            if($arr_pos_sales[0]['pos-index'] == NULL && (! $this->Owner)){
                $this->session->set_flashdata('error', lang("access_denied"));
                redirect('welcome'); 
            }
        //***** Added By Anil 21-09-2016 End**** 
         /*************Added By Ajay*****************/
        $register = $this->pos_model->registerDataByWarehouse($warehouse_id);
        
        if((!$this->Owner && !$this->Admin)){
            if(!empty($register)){
                $register_date = date('Y-m-d',strtotime($register->date));
                if(strtotime(date('Y-m-d')) > strtotime($register_date)){
                    redirect('pos/registers');
                }
            }
            
            if(empty($register)){
                redirect('pos/open_register');
            }
        }
        
        /***********************************/
        $this->sma->checkPermissions('index');

        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        //if ($this->Owner || $this->Manager) { //added manager to view sales of his store
        if ($this->Owner || $this->Admin ) {
            $this->data['warehouses'] = $this->site->getAllWarehouses();
            //echo "<pre>";print_r($this->data);die;
            $this->data['warehouse_id'] = $warehouse_id;
            $this->data['warehouse'] = $warehouse_id ? $this->site->getWarehouseByID($warehouse_id) : NULL;
        } else {
            $user = $this->site->getUser();
            $this->data['warehouses'] = NULL;
            $this->data['warehouse_id'] = $this->session->userdata('warehouse_id');
            $this->data['warehouse'] = $this->session->userdata('warehouse_id') ? $this->site->getWarehouseByID($this->session->userdata('warehouse_id')) : NULL;
        }

        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => site_url('pos'), 'page' => lang('pos')), array('link' => '#', 'page' => lang('pos_sales')));
        $meta = array('page_title' => lang('pos_sales'), 'bc' => $bc);

        $this->page_construct('pos/sales', $meta, $this->data);
    }

    function getSales($warehouse_id = NULL) {
        $user_id = $this->session->userdata('user_id');
        //added by vivek to get the biller id of the store
        $biller = $this->site->getBillerId($user_id);
        $billerid = $biller->biller_id;
        $this->sma->checkPermissions('index');
        if ((!$this->Owner || !$this->Admin) && !$warehouse_id) {
            $user = $this->site->getUser();
            if(!empty($user->warehouse_id)){
                $warehouse_id = $user->warehouse_id;
            }else{
                $warehouse_id = $_SESSION['warehouse_id'];
            }
        }
        
        
        $detail_link = anchor('pos/view/$1', '<i class="fa fa-file-text-o"></i> ' . lang('view_receipt'), 'class="reciept_link"');
//        $detail_link = anchor('pos/view/$1/1', '<i class="fa fa-file-text-o"></i> ' . lang('view_receipt'), 'class="reciept_link" data-toggle="modal" data-target="#myModal"');
//          $pdf_link = anchor('pos/save_invoice_pdf/$1', '<i class="fa fa-file-text-o"></i> ' . lang('save_as_pdf'), 'class="reciept_link" ');
        $payments_link = anchor('sales/payments/$1', '<i class="fa fa-money"></i> ' . lang('view_payments'), 'data-toggle="modal" data-target="#myModal"');
        $add_payment_link = anchor('pos/add_payment/$1', '<i class="fa fa-money"></i> ' . lang('add_payment'), 'data-toggle="modal" data-target="#myModal"');
        $add_delivery_link = anchor('sales/add_delivery/$1', '<i class="fa fa-truck"></i> ' . lang('add_delivery'), 'data-toggle="modal" data-target="#myModal"');
        $email_link = anchor('#', '<i class="fa fa-envelope"></i> ' . lang('email_sale'), 'class="email_receipt" data-id="$1" data-email-address="$2"');
        $edit_link = anchor('pos/edit/$1', '<i class="fa fa-edit"></i> ' . lang('edit_sale'), 'class="sledit"');
        $return_link = anchor('sales/return_sale/$1', '<i class="fa fa-angle-double-left"></i> ' . lang('return_sale'),'class="ret_sal" id="ret_sal"  data-id="$1" at="sales/return_sale/$1"');
         $delete_link = "<a href='#' class='po' title='<b>" . lang("delete_sale") . "</b>' data-content=\"<p>"
            . lang('r_u_sure') . "</p><a class='btn btn-danger po-delete' href='" . site_url('sales/delete/$1') . "'>"
            . lang('i_m_sure') . "</a> <button class='btn po-close'>" . lang('no') . "</button>\"  rel='popover'><i class=\"fa fa-trash-o\"></i> "
            . lang('delete_sale') . "</a>";
         
        /* Permission for action added By Anil 21-09-2016 Start */
        
        if(!$this->Owner) {
            $arr_prmsn =  $this->site->checkPermissions(); 
                if($arr_prmsn[0]['pos-view_reciept'] != 1) {
                    $detail_link = '';
                }
                if($arr_prmsn[0]['pos-view_payments'] != 1) {
                    $payments_link = '';
                }              
                if($arr_prmsn[0]['pos-sales_payments'] != 1) {
                    $add_payment_link = '';
                }
                if($arr_prmsn[0]['sales-add_delivery'] != 1) {
                    $add_delivery_link = '';
                }
                if($arr_prmsn[0]['pos-sales_email'] != 1) {
                    $email_link = '';
                }
                if($arr_prmsn[0]['sales-return_sales'] != 1) {
                    $return_link = '';
                }
                if($arr_prmsn[0]['pos-sales_delete'] != 1) {
                    $delete_link = '';
                }
        }

        //$action = '<div class="text-center">' . $detail_link . ' ' . $edit_link . ' ' . $email_link . ' ' . $delete_link . '</div>';

        $this->load->library('datatables');
        $chek = $this->pos_settings->return_sales_all_stores;
        
        if ($this->Manager) {
            if ($warehouse_id && $chek == false) {
                
               $this->datatables
                        ->select($this->db->dbprefix('sales') . ".id as id, DATE_FORMAT("
                    . $this->db->dbprefix('sales') . ".date,'%d-%m-%Y %T') as date, reference_no, biller, "
                                . "customer, grand_total, paid, payment_status,CASE return_flg
                                  WHEN '0' THEN 'Paid'
                                  WHEN '1' THEN 'Returned'
                                  WHEN '2' THEN 'Partial Return'
								  WHEN '5' THEN 'Paid'
                                  ELSE 'Sold'
                                  END, companies.email as cemail")
                        ->from('sales')
                        ->join('companies', 'companies.id=sales.customer_id', 'left')
                        //->where(array('warehouse_id' => $warehouse_id,'biller_id' => $billerid))
                        ->group_by('sales.id');
            } else if ($chek == true && !$warehouse_id) {
                
                $this->datatables
                        ->select($this->db->dbprefix('sales') . ".id as id, DATE_FORMAT("
                    . $this->db->dbprefix('sales') . ".date,'%d-%m-%Y %T') as date, reference_no, biller, "
                                . "customer, grand_total, paid, payment_status, CASE return_flg
                                  WHEN '0' THEN 'Paid'
                                  WHEN '1' THEN 'Returned'
                                  WHEN '2' THEN 'Partial Return'
								  WHEN '5' THEN 'Paid'
                                  ELSE 'Sold'
                                  END, companies.email as cemail")
                        ->from('sales')
                        ->join('companies', 'companies.id=sales.customer_id', 'left')
                         //->where(array('sales.return_flg'=>0))
                        ->group_by('sales.id');
            } else {
               
                $this->datatables
                        ->select($this->db->dbprefix('sales') . ".id as id, DATE_FORMAT("
                    . $this->db->dbprefix('sales') . ".date,'%d-%m-%Y %T') as date, reference_no, biller, "
                                . "customer, grand_total, paid, payment_status,CASE return_flg
                                  WHEN '0' THEN 'Paid'
                                  WHEN '1' THEN 'Returned'
                                  WHEN '2' THEN 'Partial Return'
								  WHEN '5' THEN 'Paid'
                                  ELSE 'Sold'
                                  END, companies.email as cemail")
                        ->from('sales')
                        ->join('companies', 'companies.id=sales.customer_id', 'left')
                        //->where(array('sales.biller_id' => $billerid))
                        ->group_by('sales.id');
                
            }
        } else {

            if ($warehouse_id) {
                $this->datatables
                        ->select($this->db->dbprefix('sales') . ".id as id, DATE_FORMAT("
                    . $this->db->dbprefix('sales') . ".date,'%d-%m-%Y %T') as date, reference_no, biller, "
                                . "customer, grand_total, paid, payment_status,CASE return_flg
                                  WHEN '0' THEN 'Paid'
                                  WHEN '1' THEN 'Returned'
                                  WHEN '2' THEN 'Partial Return'
								  WHEN '5' THEN 'Paid'
                                  ELSE 'Sold'
                                  END, companies.email as cemail")
                        ->from('sales')
                        ->join('companies', 'companies.id=sales.customer_id', 'left')
                        ->where(array('warehouse_id' => $warehouse_id))
                        ->group_by('sales.id');
            } else {

                $this->datatables
                        ->select($this->db->dbprefix('sales') . ".id as id, DATE_FORMAT("
                    . $this->db->dbprefix('sales') . ".date,'%d-%m-%Y %T') as date, reference_no, biller, "
                                . "customer, grand_total, paid, payment_status, CASE return_flg
                                  WHEN '0' THEN 'Paid'
                                  WHEN '1' THEN 'Returned'
                                  WHEN '2' THEN 'Partial Return'
								  WHEN '5' THEN 'Paid'
                                  ELSE 'Sold'
                                  END, companies.email as cemail")
                        ->from('sales')
                        ->join('companies', 'companies.id=sales.customer_id', 'left')
                        //->where(array('sales.return_flg'=>0))
                        ->group_by('sales.id');
            }
        }
        
        $this->datatables->where('pos', 1);
//        if (!$this->Customer && !$this->Supplier && !$this->Owner && !$this->Admin && !$this->Manager) {//added manager to view sales of his store
//            $this->datatables->where('created_by', $this->session->userdata('user_id'));
//        } elseif ($this->Customer) {
        if ($this->Customer) {
            $this->datatables->where('customer_id', $this->session->userdata('user_id'));
        }
        
        /* Permission for action added By Anil 21-09-2016 End */
        
        if(!$this->Owner && !$this->Admin){
         
        $action = '<div class="text-center"><div class="btn-group text-left">'
                . '<button type="button" class="btn btn-default btn-xs btn-primary dropdown-toggle" data-toggle="dropdown">'
                . lang('actions') . ' <span class="caret"></span></button>
                <ul class="dropdown-menu pull-right" role="menu">
                    <li>' . $detail_link . '</li>
                    <li>' . $pdf_link.'<li>
                    <li>' . $return_link . '</li>
                </ul>
                </div></div>';
        }
        else{
            $action = '<div class="text-center"><div class="btn-group text-left">'
                . '<button type="button" class="btn btn-default btn-xs btn-primary dropdown-toggle" data-toggle="dropdown">'
                . lang('actions') . ' <span class="caret"></span></button>
                <ul class="dropdown-menu pull-right" role="menu">
                    <li>' . $detail_link . '</li>
                </ul>
                </div></div>';
        }
        $this->datatables->add_column("Actions", $action, "id, cemail")->unset_column('cemail');
        echo $this->datatables->generate();
    }


    /* ---------------------------------------------------------------------------------------------------- */
    /*
     * Altered by Ajay 
     * on 4.04.2016
     */

    public function index($sid = NULL) {
        //echo "<pre>";print_r($_SESSION);die;
        if(!empty($_SESSION['register_id'])){
            $registerid = $_SESSION['register_id'];
        }
        //echo $registerid;die;
        /* if($this->Owner || $this->Admin){
            $this->session->set_flashdata('error', lang("access_denied"));
            redirect('welcome'); 
        }
        $arr_daily_sales = $this->site->checkPermissions();

        if($arr_daily_sales[0]['pos-pos_tip'] == NULL){
            $this->session->set_flashdata('error', lang("access_denied"));
            redirect('welcome'); 

        }
        //echo "<pre>";print_r($this->pos_settings->return_sales_perioed);die;
        }*/
        //echo "<pre>";print_r($this->pos_settings);
        //echo $this->pos_settings->order_discount_type;die;
        //$this->sma->checkPermissions();  
        //echo "<pre>";print_r($_SESSION);die;
       
        if (!$this->pos_settings->default_biller || !$this->pos_settings->default_customer || !$this->pos_settings->default_category) {          
            $this->session->set_flashdata('warning', lang('please_update_settings'));
            redirect('pos/settings');
        }
        
        $permissions = $this->site->checkPermissions();  
        $userid = $this->session->userdata('user_id');
        $warehouse_id = $_SESSION['warehouse_id'];
        $register = $this->pos_model->registerDataByWarehouse($warehouse_id);
        if ($register) {
            $register_data = array('register_id' => $register->id, 
                'cash_in_hand' => $register->cash_in_hand,
                'register_warehouse_id'=> $register->warehouse_id,
                'register_open_time' => $register->date);
                $this->session->set_userdata($register_data);

                $cur_date = date("Y-m-d");
                $register_date = date("Y-m-d",strtotime($register->date));
                if((strtotime($cur_date) > strtotime($register_date)) && (strtotime($cur_date) !== strtotime($register_date)) && ($register->warehouse_id === $this->session->userdata('warehouse_id'))){
                    
                    $this->session->set_flashdata('error', lang('register_not_close'));
                    redirect('pos/registers');
                }
        } else {
            $this->session->set_flashdata('error', lang('register_not_open'));
            redirect('pos/open_register');
        }
        
        $cur_date = date("Y-m-d",strtotime("now"));
        $register_date = date("Y-m-d",strtotime($register->date));
        if(strtotime($cur_date) > strtotime($register_date) && strtotime($cur_date) != strtotime($register_date)){
            $this->session->set_flashdata('error', lang('register_not_close'));
            redirect('pos/registers');
        }

        $this->data['sid'] = $this->input->get('suspend_id') ? $this->input->get('suspend_id') : $sid;
        $did = $this->input->post('delete_id') ? $this->input->post('delete_id') : NULL;
        $suspend = $this->input->post('suspend') ? TRUE : FALSE;
        $count = $this->input->post('count') ? $this->input->post('count') : NULL;

        //validate form input
        $this->form_validation->set_rules('customer', $this->lang->line("customer"), 'trim|required');
        $this->form_validation->set_rules('warehouse', $this->lang->line("warehouse"), 'required');
        $this->form_validation->set_rules('biller', $this->lang->line("biller"), 'required');
         
        if ($this->form_validation->run() == TRUE) {
          /* echo "<pre>";
           print_r($this->input->post());
           exit;*/
            $paid_by = $this->input->post('paid_by');
            $matched_key = array_search('credit_voucher', $paid_by);

            //echo "<pre>";print_r($this->input->post());echo $matched_key;die;
            if ($matched_key !== FALSE) {
                $amount = $this->input->post('amount');
                $paying_gift_card_no = $this->input->post('paying_gift_card_no')[$matched_key];
                if ($amount[$matched_key] > 0) {
                    if (empty($paying_gift_card_no)) {
                        $this->session->set_flashdata('empty_credit_voucher', 'credit voucher number for payment method ' . $matched_key . ' cannot be left empty');
                        redirect('/pos');
                    }
                }
            } 
            else if (in_array('CC', $paid_by)) {   
                $amount = $this->input->post('amount');
                $keys = $this->get_keys_for_duplicate_values($paid_by, false);
                $credit_cards = $this->input->post('cc_no');
                $matched = array_search('CC', $paid_by);
                $approval_number = $this->input->post('cc_cvv2');

                foreach ($keys['CC'] as $ks => $vs) {
                    if ($amount[$matched] > 0) {
                        //echo $amount[$matched];echo empty($credit_cards[$vs]);die;
                        if (empty($credit_cards[$vs])) {
                            $this->session->set_flashdata('empty_credit_card', 'credit card number at payment method' . $vs+1 . ' cannot be left empty');
                            redirect('/pos');
                        }
                        
                        if(!empty($credit_cards[$vs])){    
                            $length = ceil(log10($credit_cards[$vs]));
                            //echo $credit_cards[$vs].'##'.$length;die;
                            $len = $vs+1;
                            if($length > 18){
                                $this->session->set_flashdata('credit_card_length', 'credit card number at payment method' . $len . ' cannot be greater than 18 digits');
                                redirect('/pos');
                            }
                        }

                        /*if (empty($approval_number[$vs])) {
                            $len = $vs+1;
                            $this->session->set_flashdata('empty_approval_number', 'approval number on payment' . $len . 'cannot be left empty');
                            redirect('/pos');
                        }*/
                    }
                }
            }
            $date = date('Y-m-d H:i:s');
            $warehouse_id = $this->input->post('warehouse');
            $customer_id = $this->input->post('customer');
            $biller_id = $this->input->post('biller');
            $sales_executive = $this->input->post('sales_executives');
            $total_items = $this->input->post('total_items');
            //$sale_status = $this->input->post('sale_status');			
            $sale_status = 'completed';
            $payment_status = 'paid';
            $payment_term = 0;
            $due_date = date('Y-m-d', strtotime('+' . $payment_term . ' days'));
            $shipping = $this->input->post('shipping') ? $this->input->post('shipping') : 0;
            $customer_details = $this->site->getCompanyByID($customer_id);
            //echo "<pre>";print_r($customer_details);echo $this->session->userdata('last_added_customer_id');die;
            if ($customer_details->company == Null) {
                if (!empty($this->session->userdata('last_added_customer_id'))) {
                    $customer_details = $this->site->getCompanyByID($this->session->userdata('last_added_customer_id'));
                    $customer_id = $this->session->userdata('last_added_customer_id');
                    $customer = !empty($customer_details->name) ? $customer_details->name.' '.$customer_details->lname : '';
                } else {
                    $customer_details = $this->site->getCompanyByID($customer_id);
                    $customer = !empty($customer_details->name) ? $customer_details->name.' '.$customer_details->lname : '';
                }
            } else {
                $customer = !empty($customer_details->name) ? $customer_details->name.' '.$customer_details->lname : '';
            }

            $biller_details = $this->site->getCompanyByID($biller_id);
            if(count($biller_details)>0){
                $biller = $biller_details->company != '-' ? $biller_details->company : $biller_details->name;
            }else{
                $this->session->set_flashdata('error', $this->lang->line("sale_fail"));
                redirect("pos");
            }

            $note = $this->sma->clear_tags($this->input->post('pos_note'));
            //$pos_note = $this->sma->clear_tags($this->input->post('pos_note'));
            $staff_note = $this->sma->clear_tags($this->input->post('staff_note'));
            $reference = $this->site->getReference('pos');

            $total = 0;
            $product_tax = 0;
            $order_tax = 0;
            $product_discount = 0;
            $order_discount = 0;
            $total_discount = 0;
            $stottal = 0;
            $basic_cost=0;
            //$percentage = '%';
            $i = isset($_POST['product_code']) ? sizeof($_POST['product_code']) : 0;
            //echo "<pre>"; print_r($_POST); exit;
            for ($r = 0; $r < $i; $r++) {
                $item_id = $_POST['product_id'][$r];
                $item_type = $_POST['product_type'][$r];
                $item_code = $_POST['product_code'][$r];
                $item_hsn = $_POST['product_hsn'][$r];
                $net_unit_cost = $_POST['ru_unit_cost'][$r];
                $ru_item_tax = $_POST['u_item_tax'][$r];
                $item_name = $_POST['product_name'][$r];
                $item_option = isset($_POST['product_option'][$r]) && $_POST['product_option'][$r] != 'false' ? $_POST['product_option'][$r] : NULL;
                //$option_details = $this->pos_model->getProductOptionByID($item_option);
                $real_unit_price = $this->sma->formatDecimal($_POST['real_unit_price'][$r]);
                $unit_price = $this->sma->formatDecimal($_POST['unit_price'][$r]);
                $item_quantity = $_POST['quantity'][$r];
                $item_serial = isset($_POST['serial'][$r]) ? $_POST['serial'][$r] : '';
                $item_tax_rate = isset($_POST['product_tax'][$r]) ? $_POST['product_tax'][$r] : NULL;
                $total_tax += isset($_POST['u_item_tax'][$r])?$_POST['u_item_tax'][$r]:0;
                $item_discount = $this->sma->formatMoney($_POST['product_discount'][$r]);// ? $_POST['product_discount'][$r] : NULL;
                //if($suspend){
                    $item_discount_type = $_POST['product_discount_type'][$r];
                //}
                if (isset($item_code) && isset($real_unit_price) && isset($unit_price) && isset($item_quantity)) {
                    $product_details = $item_type != 'manual' ? $this->pos_model->getProductByCode($item_code) : NULL;
                    $unit_price = $real_unit_price;
                    $pr_discount = 0;

                    if (isset($item_discount)) {
                        $discount = $item_discount;
                        //$dpos = strpos($discount, $percentage);
                        
                        if ($this->pos_settings->order_discount_type == 'percent') {
                            //$pds = $discount;
                            $pr_discount = (($this->sma->formatDecimal($unit_price)) * (Float) ($discount)) / 100;
                        } else {
                            $pr_discount = $this->sma->formatDecimal($discount);
                        }
                    }
                    
                    $unit_price = $this->sma->formatDecimal($unit_price - $pr_discount);
                    $item_net_price = $unit_price;
                    $pr_item_discount = $this->sma->formatDecimal($pr_discount * $item_quantity);
                    $product_discount += $pr_item_discount;
                    $pr_tax = 0;
                    $pr_item_tax = 0;
                    $item_tax = 0;
                    $tax = "";
                    
                    //------------------------------ code for new tax calculation @ Rana
                    if ($product_discount > 0) {
                        
                        $product_tax += $ru_item_tax;
                        $stottal += (($unit_price * $item_quantity));
                        $basic_cost +=$net_unit_cost;
                        
                    } else {
//                       
                        $product_tax += $ru_item_tax;
                        $stottal += (($unit_price * $item_quantity));
                        $basic_cost +=$net_unit_cost;
                        
                    }
                    //------------------------------ End code for new tax calculation @ Rana
                    //dd($product_discount);
                    //echo "<br>".$discount."<br>";
                    //echo "<br>".$pr_discount."<br>";

                    

                    /*if (isset($item_tax_rate) && $item_tax_rate != 0) {
                        $pr_tax = $item_tax_rate;
                        $tax_details = $this->site->getTaxRateByID($pr_tax);
                        //echo "Tax type---- ".$tax_details->type;
                        //print_r($tax_details);die;
                        if ($tax_details->type == 1 && $product_details->tax_percentage != 0) {

                            if ($product_details && $product_details->tax_method == 1) {
                                $item_tax = $this->sma->formatDecimal((($unit_price) * $product_details->tax_percentage) / 100);
                                $tax = $product_details->tax_percentage . "%";
                            } else {
                                $item_tax = $this->sma->formatDecimal((($unit_price) * $product_details->tax_percentage) / (100 + $product_details->tax_percentage));
                                $tax = $product_details->tax_percentage . "%";
                                $item_net_price = $unit_price - $item_tax;
                            }
                        } elseif ($tax_details->type == 2) {

                            if ($product_details && $product_details->tax_method == 1) {
                                $item_tax = $this->sma->formatDecimal((($unit_price) * $product_details->tax_percentage) / 100);
                                $tax = $product_details->tax_percentage . "%";
                            } else {
                                $item_tax = $this->sma->formatDecimal((($unit_price) * $product_details->tax_percentage) / (100 + $product_details->tax_percentage));
                                $tax = $product_details->tax_percentage . "%";
                                $item_net_price = $unit_price - $item_tax;
                            }

                            $item_tax = $this->sma->formatDecimal($product_details->tax_percentage);
                            $tax = $product_details->tax_percentage;
                        }
                        elseif ($tax_details->type == 0) {  

                            if ($product_details && $product_details->tax_method == 1) {
                                $item_tax = $this->sma->formatDecimal((($unit_price) * $product_details->tax_percentage) / 100);
                                $tax = $product_details->tax_percentage . "%";
                            } else {
                                $item_tax = $this->sma->formatDecimal((($unit_price) * $product_details->tax_percentage) / (100 + $product_details->tax_percentage));
                                $tax = $product_details->tax_percentage . "%";
                                $item_net_price = $unit_price - $item_tax;
                            }
                        }
                        $pr_item_tax = $this->sma->formatDecimal($item_tax * $item_quantity);
                    } */
                    
                    // ---------------------------- Tax rate redefine by Rana ------------------------------
                    
                    // ---------------------------- End Tax rate redefine by Rana ------------------------------
 
                    //$product_tax += $pr_item_tax;    
                    
                    $subtotal = (($item_net_price * $item_quantity) + $pr_item_tax);
                    if($suspend){
                        $products[] = array(
                            'product_id' => $item_id,
                            'product_code' => $item_code,
                            'product_name' => $item_name,
                            'product_type' => $item_type,
                            'product_hsn' => $product_details->hsn,
                            'option_id' => $item_option,
                            'net_unit_price' => $item_net_price,
                            'unit_price' => $this->sma->formatDecimal($item_net_price + $item_tax),
                            'quantity' => $item_quantity,
                            'warehouse_id' => $warehouse_id,
                            //'item_tax' => $pr_item_tax,
                            'tax_rate_id' => $pr_tax,
                            'tax' => $tax,
                            'discount' => $item_discount,
                            'item_discount' => $pr_item_discount,
                            'pdiscount_type' => $item_discount_type, 
                            'subtotal' => $this->sma->formatDecimal($subtotal),
                            'serial_no' => $item_serial,
                            'real_unit_price' => $real_unit_price,
                            'net_unit_cost' => $net_unit_cost,
                            'item_tax' => $ru_item_tax
                        );
                    }else{
                        $products[] = array(
                            'product_id' => $item_id,
                            'product_code' => $item_code,
                            'product_name' => $item_name,
                            'product_type' => $item_type,
                            'product_hsn' => $product_details->hsn,
                            'option_id' => $item_option,
                            'net_unit_price' => $item_net_price,
                            'unit_price' => $this->sma->formatDecimal($item_net_price + $item_tax),
                            'quantity' => $item_quantity,
                            'warehouse_id' => $warehouse_id,
                            //'item_tax' => $pr_item_tax,
                            'tax_rate_id' => $pr_tax,
                            'tax' => $tax,
                            'discount' => $item_discount,
                            'item_discount' => $pr_item_discount,
                            'pdiscount_type' => $item_discount_type, 
                            'subtotal' => $this->sma->formatDecimal($subtotal),
                            'serial_no' => $item_serial,
                            'real_unit_price' => $real_unit_price,
                            'net_unit_cost' => $net_unit_cost,
                            'item_tax' => $ru_item_tax
                        );
                    }
                    $total += $item_net_price * $item_quantity;
                }
            }
            //echo "<pre>";print_r($products);die;
            if (empty($products)) {
                $this->form_validation->set_rules('product', lang("order_items"), 'required');
            } else {
                krsort($products);
            }

            if ($this->input->post('discount')) {
                $order_discount_id = $this->input->post('discount');
                $disc_per = $this->input->post('discount_per');
                //$opos = strpos($order_discount_id, $percentage);
                /*if ($opos !== FALSE) {
                    $ods = explode("%", $order_discount_id);
                    $order_discount = $this->sma->formatDecimal((($total + $product_tax) * (Float) ($ods[0])) / 100);
                } else {
                    $order_discount = $this->sma->formatDecimal($order_discount_id);
                }*/
                //echo $total."<br>";
                
                if ($this->pos_settings->order_discount_type == 'percent') {
                    //$pds = $discount;
                    //$order_discount = $this->sma->formatDecimal($order_discount_id);
                    $order_discount = $this->sma->formatDecimal(($total + $product_tax) * (Float) ($disc_per)) / 100;
                } else {
                    $order_discount = $this->sma->formatDecimal($disc_per);
                }
            } else {
                $order_discount_id = NULL;
            }
            //echo "Tax ------ ".$product_tax."<br>";
            //echo "Ord ------ ".$order_discount."<br>";
            //echo "prod ------ ".$product_discount."<br>";
            $total_discount = $this->sma->formatDecimal($order_discount + $product_discount);
            

            if ($this->Settings->tax2) {
                $order_tax_id = $this->input->post('order_tax');
                if ($order_tax_details = $this->site->getTaxRateByID($order_tax_id)) {
                    if ($order_tax_details->type == 2) {
                        $order_tax = $this->sma->formatDecimal($order_tax_details->rate);
                    }
                    if ($order_tax_details->type == 1) {
                        $order_tax = $this->sma->formatDecimal((($total + $product_tax - $order_discount) * $order_tax_details->rate) / 100);
                    }
                }
            } else {
                $order_tax_id = NULL;
            }

//            $total_tax = $this->sma->formatDecimal($product_tax + $order_tax);
            $grand_total = $this->sma->formatDecimal($this->sma->formatDecimal($total) - $order_discount);
            $data = array('date' => $date,
                'reference_no' => $reference,
                'customer_id' => $customer_id,
                'customer' => $customer,
                'biller_id' => $biller_id,
                'biller' => $biller,
                'warehouse_id' => $warehouse_id,
                'note' => $note,
                'staff_note' => $staff_note,
                //'note' => $pos_note,
                //'total' => $this->sma->formatDecimal($total),
                'total' => $basic_cost,
                'product_discount' => $this->sma->formatDecimal($product_discount),
                'order_discount_id' => $order_discount_id,
                'order_discount' => $order_discount,
                'total_discount' => $total_discount,
                'product_tax' => $this->sma->formatDecimal($product_tax),
                'order_tax_id' => $order_tax_id,
                'order_tax' => $order_tax,
                'total_tax' => $total_tax,
                'shipping' => $this->sma->formatDecimal($shipping),
                'grand_total' => $grand_total,
                'total_items' => $total_items,
                'sale_status' => $sale_status,
                'payment_status' => $payment_status,
                'payment_term' => $payment_term,
                'pos' => 1,
                //'paid' => $this->input->post('amount-paid') ? $this->input->post('amount-paid') : 0,
                'paid' => $stottal,
                'created_by' => $this->session->userdata('user_id'),
                'sales_executive_id' => $sales_executive,
                'invoice_discount_reason' => $this->input->post('discount_reason'),
                'register_id' => $registerid,
                'pan_number' => !empty($this->input->post('pan_number_hidden')) ? $this->input->post('pan_number_hidden') : '',
                'return_time' => $this->pos_settings->return_sales_perioed
            );
            //echo "<pre>";print_r($data);die;
            if (!$suspend) {
                $p = isset($_POST['amount']) ? sizeof($_POST['amount']) : 0;
                for ($r = 0; $r < $p; $r++) {
                    if (isset($_POST['amount'][$r]) && !empty($_POST['amount'][$r]) && isset($_POST['paid_by'][$r]) && !empty($_POST['paid_by'][$r])) {
                        $amount = $this->sma->formatDecimal($_POST['balance_amount'][$r] > 0 ? $_POST['amount'][$r] - $_POST['balance_amount'][$r] : $_POST['amount'][$r]);
                        if(($_POST['paid_by'][$r] == 'cash') || ($_POST['paid_by'][$r] == 'credit_voucher')){
                            $_POST['cc_type'][$r] = '';
                        }else{
                                $_POST['cc_type'][$r] = (!empty($_POST['cc_type'][$r])) ? $_POST['cc_type'][$r] : 'VISA';
                        }
                        $payment[] = array(
                            'date' => $date,
                            'reference_no' => $this->site->getReference('pay'),
                            'amount' => $amount,
                            'paid_by' => $_POST['paid_by'][$r],
                            'cheque_no' => $_POST['cheque_no'][$r],
                            'cc_no' => ($_POST['paid_by'][$r] == 'credit_voucher' ? $_POST['paying_gift_card_no'][$r] : $_POST['cc_no'][$r]),
                            'cc_holder' => $_POST['cc_holder'][$r],
                            'cc_month' => $_POST['cc_month'][$r],
                            'cc_nation' => $_POST['cc_nation'][$r],
                            'cc_edc' => $_POST['cc_edc'][$r],
                            'cc_year' => $_POST['cc_year'][$r], 
                            'cc_type' => $_POST['cc_type'][$r],
                            'cc_cvv2' => $_POST['cc_cvv2'][$r],
                            'card_type' => ((!empty($_POST['cc_card_type'][$r])) && ($_POST['paid_by'][$r] == 'CC')) ? $_POST['cc_card_type'][$r] : 'CC',
                            'created_by' => $this->session->userdata('user_id'),
                            'type' => 'received',
                            'note' => $_POST['payment_note'][$r],
                            'pos_paid' => $_POST['amount'][$r],
                            'pos_balance' => $_POST['balance_amount'][$r],
                            'cn_balance' => $_POST['cn_balance'][$r],
                            'approval_no' => $_POST['cc_cvv2'][$r],
                            'register_id' => $registerid,
                        );
                        $pp[] = $amount;

                        $this->site->updateReference('pay');
                    }
                }
                if (!empty($pp)) {
                    $paid = array_sum($pp);
                } else {
                    $paid = 0;
                }
                if ($paid == 0) {
                    $payment_term = 'pending';
                } elseif ($grand_total <= $paid) {
                    $payment_term = 'paid';
                } elseif ($grand_total >= $paid) {
                    $payment_term = 'partial';
                }
            }
            if (!isset($payment) || empty($payment)) {
                $payment = array();
            }
        }
        
        //echo "<pre>";print_r($payment);die;
        /*echo "<pre>";print_r($suspend);
             print_r($this->input->post());
             exit;*/
        if ($this->form_validation->run() == TRUE && !empty($products) && !empty($data)) {
            
            if ($suspend) {               
                $data['suspend_note'] = $this->input->post('suspend_note');
                if ($this->pos_model->suspendSale($data, $products, $did)) {
                    $this->session->set_userdata('remove_posls', 1);
                    $this->session->set_flashdata('message', $this->lang->line("sale_suspended"));
                    redirect("pos");
                }
            } else {
//               echo "<pre>"; print_r($data); die; 
                if ($sale = $this->pos_model->addSale($data, $products, $payment, $did)) {
                    $this->session->set_userdata('remove_posls', 1);
                    $msg = $this->lang->line("sale_added");
                    if (!empty($sale['message'])) {
                        foreach ($sale['message'] as $m) {
                            $msg .= '<br>' . $m;
                        }
                    }
                    $this->session->set_flashdata('message', $msg);
                    redirect("pos/view/" . $sale['sale_id']);
                }
            }
            
        } 
        else {
            
            $this->data['suspend_sale'] = NULL;
            if ($sid) {
                if ($suspended_sale = $this->pos_model->getOpenBillByID($sid)) {
                    $inv_items = $this->pos_model->getSuspendedSaleItems($sid);
                 /*  echo "<pre>";
                    print_r($suspended_sale);
                    exit;*/
                    $c = rand(100000, 9999999);
                    $count = 1;
                    foreach ($inv_items as $item) {
                        $row = $this->site->getProductByID($item->product_id);
                        
                        if (!$row) {
                            $row = json_decode('{}');
                            $row->tax_method = 0;
                            $row->quantity = 0;
                        } else {
                            unset($row->details, $row->product_details, $row->cost, $row->supplier1price, $row->supplier2price, $row->supplier3price, $row->supplier4price, $row->supplier5price);
                        }
                        $pis = $this->pos_model->getPurchasedItems($item->product_id, $item->warehouse_id, $item->option_id);

                        if ($pis) {
                            foreach ($pis as $pi) {
                                $row->quantity = $pi->quantity_balance;
//                              $row->net_unit_cost = $pi->net_unit_cost;
//                              $row->item_tax = $pi->item_tax;
                            }
                        } else {
                            $row->quantity = 0;
                        }
                        $row->net_unit_cost = $item->net_unit_cost;
                        $row->item_tax = $item->item_tax;
                        $row->id = $item->product_id;
                        $row->code = $item->product_code;
                        $row->name = $item->product_name;
                        $row->type = $item->product_type;
                        $row->qty = $item->quantity;
                        $row->quantity -= $count;
                        $count = $count + 1;
                        if(($item->pdiscount_type == 'replacement') || ($item->pdiscount_type == 'employee')){
                            $row->discount = $item->discount ? $item->discount : '0';
                        }else{
                            $row->discount = $item->discount ? intval($item->discount) : '0';
                        }
                        $row->discount = $item->discount ? $item->discount : '0';
                        $row->discount_type = $item->pdiscount_type;
                        //$row->price = $this->sma->formatDecimal($item->net_unit_price + $this->sma->formatDecimal($item->item_discount / $item->quantity));
                        $row->price = $this->sma->formatDecimal($item->real_unit_price);
                        $row->unit_price = $row->tax_method ? $item->unit_price + $this->sma->formatDecimal($item->item_discount / $item->quantity) + $this->sma->formatDecimal($item->item_tax / $item->quantity) : $item->unit_price + ($item->item_discount / $item->quantity);
                        $row->real_unit_price = $item->real_unit_price;
                        $row->tax_rate = $item->tax_rate_id;
                        $row->serial = $item->serial_no;
                        $row->option = $item->option_id;
                        $options = $this->pos_model->getProductOptions($row->id, $item->warehouse_id);
                        
                        if ($options) {
                            $option_quantity = 0;
                            foreach ($options as $option) {
                                $pis = $this->pos_model->getPurchasedItems($row->id, $item->warehouse_id, $item->option_id);
                                if ($pis) {
                                    foreach ($pis as $pi) {
                                        $option_quantity += $pi->quantity_balance;
                                    }
                                }
                                if ($option->quantity > $option_quantity) {
                                    $option->quantity = $option_quantity;
                                }
                            }
                        }
                        
                        $ri = $this->Settings->item_addition ? $row->id : $c;
                      /*  echo "<pre>";
                        print_r($suspended_sale->order_discount_id);
                        exit;*/
                        if ($row->tax_rate) {
                            $tax_rate = $this->site->getTaxRateByID($row->tax_rate);
                            $pr[$ri] = array('id' => $c, 'item_id' => $row->id, 'label' => $row->name . " (" . $row->code . ")", 'row' => $row, 'tax_rate' => $tax_rate, 'suspend' => TRUE, 'options' => $options,'order_discount'=>$suspended_sale->order_discount_id);
                        } else {
                            $pr[$ri] = array('id' => $c, 'item_id' => $row->id, 'label' => $row->name . " (" . $row->code . ")", 'row' => $row, 'tax_rate' => FALSE, 'suspend' => TRUE, 'options' => $options,'order_discount'=>$suspended_sale->order_discount_id);
                        }

                        $c++;
                    }
                    // print_r($this->session->all_userdata());
                    //echo "<pre>";print_r($suspended_sale);die;     
                    //echo "<pre>";print_r($this->session->all_userdata());  ;die; 
                   
                    $this->data['items'] = json_encode($pr);
                    $this->data['sid'] = $sid;
                    $this->data['suspend_sale'] = $suspended_sale;
                    $this->data['message'] = lang('suspended_sale_loaded');
                    $this->data['customer'] = $this->pos_model->getCompanyByID($suspended_sale->customer_id);
                    $this->data['customer_mobile_no'] = $this->data['customer']->phone;
                    $this->data['reference_note'] = $suspended_sale->suspend_note;
                } else {
                    $this->session->set_flashdata('error', lang("bill_x_found"));
                    redirect("pos");
                }
            } else {
                $this->data['customer'] = $this->pos_model->getCompanyByID($this->pos_settings->default_customer);
                $this->data['reference_note'] = NULL;
            }
            $this->data['customer'] = $this->pos_model->getCompanyByID($this->pos_settings->default_customer);
            
            $max_discount = !empty($this->pos_settings->order_discount) ? $this->pos_settings->order_discount : 0;
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $this->data['message'] = isset($this->data['message']) ? $this->data['message'] : $this->session->flashdata('message');
            $this->data['logged_in_discount'] = $this->checkLoggedInUserForDiscount();
            $this->data['biller'] = $this->site->getCompanyByID($this->pos_settings->default_biller);
            $this->data['billers'] = $this->site->getAllCompanies('biller');
            $this->data['warehouses'] = $this->site->getAllWarehouses();
            $this->data['tax_rates'] = $this->site->getAllTaxRates();
            $this->data['user'] = $this->site->getUser();
            
            $this->data['max_discount'] = $max_discount;
            $biller_id = $this->session->userdata('biller_id');
            $group_id = $this->data['group_id'] = $this->session->all_userdata()['group_id'];
           // $this->data['group_of_user'] = $group_id;
            $this->data['sales_executives'] = $this->site->getSalesExecutivesByBiller($biller_id, $group_id);
            $this->data["tcp"] = $this->pos_model->products_count($this->pos_settings->default_category);
            $this->data['products'] = $this->ajaxproducts($this->pos_settings->default_category);
            $this->data['categories'] = $this->site->getAllCategories();
            $this->data['permissions'] = $permissions;
            $this->data['subcategories'] = $this->pos_model->getSubCategoriesByCategoryID($this->pos_settings->default_category);
            $this->data['pos_settings'] = $this->pos_settings;
            $this->load->view($this->theme . 'pos/add', $this->data);
        }
    }

    function view_bill() {
        $this->sma->checkPermissions('index');
        $this->data['tax_rates'] = $this->site->getAllTaxRates();
        $this->load->view($this->theme . 'pos/view_bill', $this->data);
    }

    function stripe_balance() {
        if (!$this->Owner) {
            return FALSE;
        }
        $this->load->model('stripe_payments');
        return $this->stripe_payments->get_balance();
    }

    function paypal_balance() {
        if (!$this->Owner) {
            return FALSE;
        }
        $this->load->model('paypal_payments');
        return $this->paypal_payments->get_balance();
    }

    function registers() {
        
        $arr_daily_sales = $this->site->checkPermissions();
        /*Warehouse Id added by Chitra to manage register store wise */
        $warehouse_id = $_SESSION['warehouse_id'];
        
        //if($this->Owner || $this->Admin){
  
        if($this->Sales || $this->Manager){
            if($arr_daily_sales[0]['pos-tip_openregister'] == NULL){
                $this->session->set_flashdata('error', lang("access_denied"));
                redirect($_SERVER["HTTP_REFERER"]); 
            }
            
            $reg_date = $this->pos_model->getRegisterDate($warehouse_id);
            
            $today_date = date("Y-m-d",strtotime("now"));
            $re_date = date("Y-m-d",strtotime($reg_date->date));
            if(isset($_SESSION['register_id']) && !empty($_SESSION['register_id'])){
                if($today_date < $re_date){
                    redirect('pos');
                }
                //redirect('pos');
            }
        }
                
        //$this->sma->checkPermissions();
        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        if($this->Owner || $this->Admin){
            $this->data['registers'] = $this->pos_model->getOpenRegisters();
            
        }
        else{
            $user_id_reg = $this->session->userdata('user_id');
            //$this->data['registers'] = $this->pos_model->getUserOpenRegisters($user_id_reg,$warehouse_id);
            $this->data['registers'] = $this->pos_model->getWarehouseOpenRegisters($warehouse_id);
        }
        
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => site_url('pos'), 'page' => lang('pos')), array('link' => '#', 'page' => lang('open_registers')));
        $meta = array('page_title' => lang('open_registers'), 'bc' => $bc);
        $this->page_construct('pos/registers', $meta, $this->data);
    }

    /**
     * Altered by Ajay
     * on 29-03-2016 
     * To change cash on data currency status on new table sma_pos_cash_drawer
     */
    public function open_register() {
        if($this->input->get('register_id')){
            $z_report_id = $this->input->get('register_id');
            $this->data['z_report_id'] = $z_report_id;
        }
        $arr_daily_sales = $this->site->checkPermissions();
        $warehouse_id = $_SESSION['warehouse_id'];
        if($this->Owner || $this->Admin){
            $this->session->set_flashdata('error', lang("access_denied"));
            redirect('welcome');
        }
        else{
            if($arr_daily_sales[0]['pos-tip_openregister'] == NULL){
                $this->session->set_flashdata('error', lang("access_denied"));
                redirect('welcome');
            }
            
            $reg_date = $this->pos_model->getRegisterDate($warehouse_id);
            $today_date = date("Y-m-d",strtotime("now"));
            $re_date = date("Y-m-d",strtotime($reg_date->date));//die;
            if(isset($_SESSION['register_id']) && !empty($_SESSION['register_id'])){
                if($today_date < $re_date){
                    redirect('pos');
                }
                //redirect('pos');
            }
        }
        
        /*if($arr_daily_sales[0]['pos-tip_openregister'] == NULL){
            $this->session->set_flashdata('error', lang("access_denied"));
            redirect('welcome'); 
        }
        if(isset($_SESSION['register_id']) && !empty($_SESSION['register_id'])){           
            redirect('pos');
        }*/
        $this->form_validation->set_rules('thousand', lang("numeric_only"), 'trim|numeric');
        $this->form_validation->set_rules('thousand', lang("numeric_only"), 'trim|numeric');
        $this->form_validation->set_rules('five_hundred', lang("numeric_only"), 'trim|numeric');
        $this->form_validation->set_rules('hundred', lang("numeric_only"), 'trim|numeric');
        $this->form_validation->set_rules('fifty', lang("numeric_only"), 'trim|numeric');
        $this->form_validation->set_rules('twenty', lang("numeric_only"), 'trim|numeric');
        $this->form_validation->set_rules('ten', lang("numeric_only"), 'trim|numeric');
        $this->form_validation->set_rules('five', lang("numeric_only"), 'trim|numeric');
        $this->form_validation->set_rules('two', lang("numeric_only"), 'trim|numeric');
        $this->form_validation->set_rules('one', lang("numeric_only"), 'trim|numeric');
        // comment this line because open resiter with 0 value 
        if ($this->form_validation->run() == TRUE) {
            $data = array('date' => date('Y-m-d H:i:s'),
                'cash_in_hand' => $this->input->post('cash_in_hand'),
                'user_id' => $this->session->userdata('user_id'),
                'status' => 'open',
                'warehouse_id'=> $_SESSION['warehouse_id']
            );
        }
        if ($this->input->post() && $this->form_validation->run() == TRUE) {
            $close_cash_bl = $this->pos_model->lastClosedByWarehouse($this->session->userdata('warehouse_id'));
            $ar = $close_cash_bl[0]->cash_in_hand;
            if ((isset($ar)) && ($ar!= $this->input->post('cash_in_hand'))){   
                $this->session->set_flashdata('error', 'Opening balance should be equal last closing balance');
                redirect("pos/open_register");
            }
           
            $insertData = $this->pos_model->openNewRegister($data);
        }
        if ($this->form_validation->run() == TRUE && $insertData['status']) {
            $cash_data = array(
                'user_id' => $this->session->userdata('user_id'),
                'warehouse_id' => $this->session->userdata('warehouse_id'), //added by ajay
                'cash_in_hand' => $this->input->post('cash_in_hand'),
                'pos_register_id' => $insertData['insertid'],
                'status' => 'open',
                'date' => date('Y-m-d H:i:s'),
                'two_thousand' => $this->input->post('two_thousand'),
                'thousand' => $this->input->post('thousand'),
                'five_hundred' => $this->input->post('five_hundred'),
                'hundred' => $this->input->post('hundred'),
                'fifty' => $this->input->post('fifty'),
                'twenty' => $this->input->post('twenty'),
                'ten' => $this->input->post('ten'),
                'five' => $this->input->post('five'),
                'two' => $this->input->post('two'),
                'one' => $this->input->post('one')
            );
//            $open_cash_bl= $this->pos_model->lastOpen($this->session->userdata('user_id'));
            $this->pos_model->insertIntoPosCashDrawer($cash_data);
            $this->session->set_flashdata('message', lang("welcome_to_pos"));
            redirect("pos");
        } else {
            $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
            
            $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => '#', 'page' => lang('open_register')));
            $meta = array('page_title' => lang('open_register'), 'bc' => $bc);
            $this->page_construct('pos/open_register', $meta, $this->data);
        }
    }

    /*
     *  altered by ajay
     * on 30-03-2016
     */

    public function close_register($userid = NULL,$warehouse_id = NULL) {
    
        $arr_daily_sales = $this->site->checkPermissions();
        if($this->Owner || $this->Admin){
            $this->session->set_flashdata('error', lang("access_denied"));
            redirect('welcome');
        }

        /*if($arr_daily_sales[0]['pos-tip_closeregister'] == NULL){
            $this->session->set_flashdata('error', lang("access_denied"));
            redirect('welcome'); 
        }*/
       
        $this->load->model('site');
        /* Warehouse Id updated by Chitra to manage register store wise  */
        $warehouse_id = !empty($warehouse_id) ? $warehouse_id : $_SESSION['warehouse_id'];
        $warehouse_register = !empty($warehouse_id) ? $this->pos_model->registerDataByWarehouse($warehouse_id) : NULL;
        $rid = !empty($warehouse_register) ? $warehouse_register->id : $this->session->userdata('register_id');
        $user_id = !empty($warehouse_register) ? $warehouse_register->user_id : (!empty($userid) ? $userid : $this->session->userdata('user_id'));
       // echo "rod".$rid;exit;
        $this->form_validation->set_rules('total_cash', lang("total_cash"), 'trim|required|numeric');
        //$this->form_validation->set_rules('total_cheques', lang("total_cheques"), 'trim|required|numeric');
        //$this->form_validation->set_rules('total_cc_slips', lang("total_cc_slips"), 'trim|required|numeric');
        $this->form_validation->set_rules('total_cash_submitted', lang("total_cash_submitted"), 'trim|required|numeric');

        if ($this->form_validation->run() == TRUE) {
          
//            if ($this->Owner || $this->Admin) {
//                $user_register = $user_id ? $this->pos_model->registerData($user_id) : NULL;
//                $rid = $user_register ? $user_register->id : $this->session->userdata('register_id');
//                $user_id = $user_register ? $user_register->user_id : $this->session->userdata('user_id');
//            } else {
//                $rid = $this->session->userdata('register_id');
//                $user_id = $this->session->userdata('user_id');
//            }
            
                       
            $data = array('closed_at' => date('Y-m-d H:i:s'),
                'total_cash' => $this->input->post('total_cash'),
                //'total_cheques' => $this->input->post('total_cheques'),
                'total_cc_slips' => $this->input->post('total_cc_slips'),
                // 'total_cash_submitted' => $this->input->post('total_cash_submitted'),
                'total_cash_submitted' => $this->input->post('total_cash_submitted'),
                'cash_in_hand' => $this->input->post('register_opening_balance'),
                //'total_cheques_submitted' => $this->input->post('total_cheques_submitted'),
                'total_cc_slips_submitted' => $this->input->post('total_cc_slips_submitted'),
                'note' => $this->input->post('note'),
                'status' => 'close',
                'transfer_opened_bills' => $this->input->post('transfer_opened_bills'),
                'closed_by' => $this->session->userdata('user_id'),
                'warehouse_id' => $warehouse_id,
                'footfall' => $this->input->post('footfall')
            );    
            //echo "<pre>";print_r($data);die;   
        } elseif ($this->input->post('close_register')) {
            $this->session->set_flashdata('error', (validation_errors() ? validation_errors() : $this->session->flashdata('error')));
            redirect("pos");
        }

        /*
          if($this->form_validation->run() == TRUE){
          if ($this->input->post('total_cash') != $this->input->post('total_cash_submitted')) {
          redirect('pos/compare_cash');
          }
          }
         */

        if ($this->form_validation->run() == TRUE && $this->pos_model->closeRegister($rid,$user_id,$warehouse_id,$data)) {
          
            //$p= $this->input->post('total_cash_submitted') - $this->input->post('expenses');
            $this->pos_model->deleteBillByWarehouse($this->session->userdata('warehouse_id'));
            $cash_data = array(
                'user_id' => $user_id,
                'pos_register_id' => $rid,
                'warehouse_id' => $warehouse_id,
                'cash_in_hand' => $this->input->post('total_cash_submitted'),
                'status' => 'closed',
                'date' => date('Y-m-d H:i:s'),
                'two_thousand' => $this->input->post('two_thousand'),
                'thousand' => $this->input->post('thousand'),
                'five_hundred' => $this->input->post('five_hundred'),
                'hundred' => $this->input->post('hundred'),
                'fifty' => $this->input->post('fifty'),
                'twenty' => $this->input->post('twenty'),
                'ten' => $this->input->post('ten'),
                'five' => $this->input->post('five'),
                'two' => $this->input->post('two'),
                'one' => $this->input->post('one')
            );
            
            $deleted_items = $this->site->deleteSuspendedBills();
            $this->pos_model->closePosCashDrawer($cash_data);
            $this->session->unset_userdata('register_id');
            $this->session->set_flashdata('message', lang("register_closed"));
            //$this->zreportPdf($rid);
            redirect("pos/open_register?register_id=".$rid);
        } else {
//            if ($this->Owner || $this->Admin || $this->Manager) {
//
//                $user_register = $user_id ? $this->pos_model->registerData($user_id) : NULL;
//                $register_open_time = $user_register ? $user_register->date : $this->session->userdata('register_open_time');
//                $this->data['cash_in_hand'] = $user_register ? $user_register->cash_in_hand : NULL;
//                $this->data['status'] = $user_register ? $user_register->status : NULL;
//                $this->data['register_open_time'] = $user_register ? $register_open_time : NULL;
//            } else {
//                $register_open_time = $this->session->userdata('register_open_time');
//                $rid = $this->session->userdata('register_id');
//                $user_id = $this->session->userdata('user_id');
//                $this->data['cash_in_hand'] = NULL;
//                $this->data['register_open_time'] = NULL;
//            }
            
            
            //$warehouse_register = !empty($warehouse_id) ? $this->pos_model->registerDataByWarehouse($warehouse_register) : NULL;
            $register_open_time = !empty($warehouse_register) ? $warehouse_register->date : $this->session->userdata('register_open_time');
            $this->data['cash_in_hand'] = $warehouse_register ? $warehouse_register->cash_in_hand : NULL;
            $this->data['status'] = $warehouse_register ? $warehouse_register->status : NULL;
            $this->data['register_open_time'] = $warehouse_register ? $register_open_time : NULL;
            $registerid = $warehouse_register ? $warehouse_register->id : NULL;
            //$registerid = $_SESSION['register_id'];
            //$register_open_time = $this->session->userdata('register_open_time');
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $this->data['ccsales'] = $this->pos_model->getStoreRegisterCCSales($register_open_time, $rid);
            $this->data['dcsales'] = $this->pos_model->getStoreRegisterDCSales($register_open_time,$rid);
            //print_r($this->data['ccsales']);print_r($this->data['dcsales']);die;
            $this->data['cashsales'] = $this->pos_model->getStoreRegisterCashSales($register_open_time, $rid);
            $this->data['chsales'] = $this->pos_model->getStoreRegisterChSales($register_open_time, $rid);
            $this->data['cashdrawer'] = $this->pos_model->getStoreCashDrawerDetails($register_open_time, $rid);    
            $this->data['pppsales'] = $this->pos_model->getStoreRegisterPPPSales($register_open_time, $rid);
            $this->data['stripesales'] = $this->pos_model->getStoreRegisterStripeSales($register_open_time, $rid);
            $this->data['totalsales'] = $this->pos_model->getStoreRegisterSales($register_open_time, $rid);
            $this->data['refunds'] = $this->pos_model->getStoreRegisterRefunds($register_open_time,$rid);
            $this->data['cashrefunds'] = $this->pos_model->getStoreRegisterCashRefunds($register_open_time,$rid);
            $this->data['expenses'] = $this->pos_model->getStoreRegisterExpenses($register_open_time,$rid);
            $this->data['users'] = $this->pos_model->getUsers($user_id);
            $this->data['suspended_bills'] = $this->pos_model->getStoreSuspendedsales($user_id,$warehouse_id);
            $this->data['cvAmount'] = $this->pos_model->totalStoreCreditVoucherAmount($register_open_time, $rid);
            $this->data['ccAmount'] = $this->pos_model->totalStoreCreditCardAmount($register_open_time,$rid);
            $this->data['dcAmount'] = $this->pos_model->totalStoreDebitCardAmount($register_open_time,$rid);
            $this->data['user_id'] = $user_id;
            $this->data['warehouse'] = $warehouse_id;
            $this->data['modal_js'] = $this->site->modal_js();
            $this->load->view($this->theme . 'pos/close_register', $this->data);
        }
    }

    function getProductDataByCode($code = NULL, $warehouse_id = NULL) {
        $this->sma->checkPermissions('index');
        if ($this->input->get('code')) {
            $code = $this->input->get('code', TRUE);
        }
        if ($this->input->get('warehouse_id')) {
            $warehouse_id = $this->input->get('warehouse_id', TRUE);
        }
        if ($this->input->get('customer_id')) {
            $customer_id = $this->input->get('customer_id', TRUE);
        }
        if (!$code) {
            echo NULL;
            die();
        }
        $pos_settings = $this->pos_model->getSetting();
        $settings = $this->pos_model->getAllSettings();

        $customer = $this->site->getCompanyByID($customer_id);
        $customer_group = $this->site->getCustomerGroupByID($customer->customer_group_id);
        $row = $this->pos_model->getWHProduct($code, $warehouse_id);


        $option = '';
        if ($row) {
            $combo_items = FALSE;
            $row->item_tax_method = $row->tax_method;
            $row->qty = 1;
            $row->discount = '0';
            $row->serial = '';
            $options = $this->pos_model->getProductOptions($row->id, $warehouse_id);
            if ($options) {
                $opt = current($options);
                if (!$option) {
                    $option = $opt->id;
                }
            } else {
                $opt = json_decode('{}');
                $opt->price = 0;
            }
            $row->option = $option;
            if ($opt->price != 0) {
                $row->price = $opt->price + (($opt->price * $customer_group->percent) / 100);
            } else {
                $row->price = $row->price + (($row->price * $customer_group->percent) / 100);
            }
            $row->quantity = 0;
            $pis = $this->pos_model->getPurchasedItems($row->id, $warehouse_id, $row->option);
            if ($pis) {
                foreach ($pis as $pi) {
                    $row->quantity += $pi->quantity_balance;
                }
            }
            if ($options) {
                $option_quantity = 0;
                foreach ($options as $option) {
                    $pis = $this->pos_model->getPurchasedItems($row->id, $warehouse_id, $row->option);
                    if ($pis) {
                        foreach ($pis as $pi) {
                            $option_quantity += $pi->quantity_balance;
                        }
                    }
                    if ($option->quantity > $option_quantity) {
                        $option->quantity = $option_quantity;
                    }
                }
            }
            $row->real_unit_price = $row->price;
            $combo_items = FALSE;
            if ($row->tax_rate) {
                $tax_rate = $this->site->getTaxRateByID($row->tax_rate);
                if ($row->type == 'combo') {
                    $combo_items = $this->pos_model->getProductComboItems($row->id, $warehouse_id);
                }
                $pr = array('id' => str_replace(".", "", microtime(true)), 'discount_type' => $pos_settings->discount_type, 'overselling' => $settings->overselling, 'item_id' => $row->id, 'label' => $row->name . " (" . $row->code . ")", 'row' => $row, 'combo_items' => $combo_items, 'tax_rate' => $tax_rate, 'options' => $options, 'customer_id' => $customer_id);
            } else {
                $pr = array('id' => str_replace(".", "", microtime(true)), 'discount_type' => $pos_settings->discount_type, 'overselling' => $settings->overselling, 'item_id' => $row->id, 'label' => $row->name . " (" . $row->code . ")", 'row' => $row, 'combo_items' => $combo_items, 'tax_rate' => false, 'options' => $options, 'customer_id' => $customer_id);
            }
            echo json_encode($pr);
        } else {
            echo NULL;
        }
    }

    function ajaxproducts() {
        $this->sma->checkPermissions('index');
        if ($this->input->get('category_id')) {
            $category_id = $this->input->get('category_id');
        } else {
            $category_id = $this->pos_settings->default_category;
        }
        if ($this->input->get('subcategory_id')) {
            $subcategory_id = $this->input->get('subcategory_id');
        } else {
            $subcategory_id = NULL;
        }
        if ($this->input->get('per_page') == 'n') {
            $page = 0;
        } else {
            $page = $this->input->get('per_page');
        }

        $this->load->library("pagination");

        $config = array();
        $config["base_url"] = base_url() . "pos/ajaxproducts";
        $config["total_rows"] = $subcategory_id ? $this->pos_model->products_count($category_id, $subcategory_id) : $this->pos_model->products_count($category_id);
        $config["per_page"] = $this->pos_settings->pro_limit;
        $config['prev_link'] = FALSE;
        $config['next_link'] = FALSE;
        $config['display_pages'] = FALSE;
        $config['first_link'] = FALSE;
        $config['last_link'] = FALSE;

        $this->pagination->initialize($config);

        $products = $subcategory_id ? $this->pos_model->fetch_products($category_id, $config["per_page"], $page, $subcategory_id) : $this->pos_model->fetch_products($category_id, $config["per_page"], $page);
        $pro = 1;
        $prods = '<div>';
        if (!empty($products)) {
            foreach ($products as $product) {
                $count = $product->id;
                if ($count < 10) {
                    $count = "0" . ($count / 100) * 100;
                }
                if ($category_id < 10) {
                    $category_id = "0" . ($category_id / 100) * 100;
                }

                $prods .= "<button id=\"product-" . $category_id . $count . "\" type=\"button\" value='" . $product->code . "' title=\"" . $product->name . "\" class=\"btn-prni btn-" . $this->pos_settings->product_button_color . " product pos-tip\" data-container=\"body\"><img src=\"" . base_url() . "assets/uploads/thumbs/" . $product->image . "\" alt=\"" . $product->name . "\" style='width:" . $this->Settings->twidth . "px;height:" . $this->Settings->theight . "px;' class='img-rounded' /><span>" . character_limiter($product->name, 40) . "</span></button>";
                $pro++;
            }
        }
        $prods .= "</div>";

        if ($this->input->get('per_page')) {
            echo $prods;
        } else {
            return $prods;
        }
    }

    function ajaxcategorydata($category_id = NULL) {
        $this->sma->checkPermissions('index');
        if ($this->input->get('category_id')) {
            $category_id = $this->input->get('category_id');
        } else {
            $category_id = $this->pos_settings->default_category;
        }

        $subcategories = $this->pos_model->getSubCategoriesByCategoryID($category_id);
        $scats = '';
        if ($subcategories) {
            foreach ($subcategories as $category) {
                $scats .= "<button id=\"subcategory-" . $category->id . "\" type=\"button\" value='" . $category->id . "' class=\"btn-prni subcategory\" ><img src=\"assets/uploads/thumbs/" . ($category->image ? $category->image : 'no_image.png') . "\" style='width:" . $this->Settings->twidth . "px;height:" . $this->Settings->theight . "px;' class='img-rounded img-thumbnail' /><span>" . $category->name . "</span></button>";
            }
        }

        $products = $this->ajaxproducts($category_id);

        if (!($tcp = $this->pos_model->products_count($category_id))) {
            $tcp = 0;
        }

        echo json_encode(array('products' => $products, 'subcategories' => $scats, 'tcp' => $tcp));
    }

    /* ------------------------------------------------------------------------------------ */

    function view($sale_id = NULL, $modal = NULL) {
        $this->load->model('sales_model');
        $this->sma->checkPermissions('index');
        if ($this->input->get('id')) {
            $sale_id = $this->input->get('id');
        }
        $this->load->helper('text');
        $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
        $this->data['message'] = $this->session->flashdata('message');
        $this->data['rows'] = $this->pos_model->getAllInvoiceItems($sale_id);
        foreach($this->data['rows'] as $k => $v){
            if($v->return_id != 0){
                $return_date = $this->sales_model->getReturnByID($v->return_id)->date;
                $this->data['rows'][$k]->return_date = $return_date;
            }
            
        }


        $inv = $this->pos_model->getInvoiceByID($sale_id);
        if($inv->sale_status === 'foc'){
            $this->data['foc_details'] = $this->pos_model->getCustomerServiceBySaleId($sale_id);
        }
        /*echo "<pre>";
        print_r($inv);
        exit;*/
        $biller_id = $inv->biller_id;
        $customer_id = $inv->customer_id;
        $this->data['allbillers'] = $this->pos_model->getAllBillers();
        $this->data['biller'] = $this->pos_model->getCompanyByID($biller_id);
        $this->data['customer'] = $this->pos_model->getCompanyByID($customer_id);
        $this->data['payments'] = $this->pos_model->getInvoicePayments($sale_id);
        foreach($this->data['payments'] as $p=>$payment){
            if ($payment->paid_by == 'credit_voucher' && $payment->pos_paid) {
                if($payment->cn_balance > 0){
                    $card_details = $this->site->getGiftCardByNO($payment->cc_no);
                    $this->data['payments'][$p]->credit_note_id = $card_details->id;
                    $this->data['payments'][$p]->balance = $card_details->balance;
                }            
            }
        }
        $this->data['pos'] = $this->pos_model->getSetting();
        $this->data['barcode'] = $this->barcode($inv->reference_no, 'code39', 30);
        $this->data['inv'] = $inv;
      
        $this->data['sid'] = $sale_id;
        $this->data['modal'] = $modal;
        $this->data['page_title'] = $this->lang->line("invoice");
        $this->data['discount_type'] = $this->pos_model->discountType();
        $this->load->view($this->theme . 'pos/view', $this->data);
    }

    function register_details() {
        $this->sma->checkPermissions('index');
        $register_open_time = $this->session->userdata('register_open_time');
        $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
        $this->data['ccsales'] = $this->pos_model->getRegisterCCSales($register_open_time);
        $this->data['dcsales'] = $this->pos_model->getRegisterCCSales1($register_open_time);
        $this->data['cashsales'] = $this->pos_model->getRegisterCashSales($register_open_time);
        //$this->data['chsales'] = $this->pos_model->getRegisterChSales($register_open_time);
        $this->data['pppsales'] = $this->pos_model->getRegisterPPPSales($register_open_time);
        $this->data['stripesales'] = $this->pos_model->getRegisterStripeSales($register_open_time);
        $this->data['totalsales'] = $this->pos_model->getRegisterSales($register_open_time);
        $this->data['refunds'] = $this->pos_model->getRegisterRefunds($register_open_time);
        $this->data['expenses'] = $this->pos_model->getRegisterExpenses($register_open_time);
        $this->load->view($this->theme . 'pos/register_details', $this->data);
    }
    
    function store_register_details(){
        $this->sma->checkPermissions('index');
        $register_open_time = $this->session->userdata('register_open_time');
        $register_id = $this->session->userdata('register_id');
        $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
        $this->data['ccsales'] = $this->pos_model->getStoreRegisterCCSales($register_open_time,$register_id);
        $this->data['dcsales'] = $this->pos_model->getStoreRegisterDCSales($register_open_time,$register_id);
        $this->data['cashsales'] = $this->pos_model->getStoreRegisterCashSales($register_open_time,$register_id);
        $this->data['cnsales'] = $this->pos_model->getStoreRegisterCreditNoteSales($register_open_time,$register_id);
        //$this->data['chsales'] = $this->pos_model->getRegisterChSales($register_open_time);
        $this->data['pppsales'] = $this->pos_model->getStoreRegisterPPPSales($register_open_time,$register_id);
        $this->data['stripesales'] = $this->pos_model->getStoreRegisterStripeSales($register_open_time,$register_id);
        $this->data['totalsales'] = $this->pos_model->getStoreRegisterSales($register_open_time,$register_id);
        $this->data['refunds'] = $this->pos_model->getStoreRegisterRefunds($register_open_time,$register_id);
        $this->data['expenses'] = $this->pos_model->getStoreRegisterExpenses($register_open_time,$register_id);
        $this->load->view($this->theme . 'pos/register_details', $this->data);
        
    }

    function today_sale() {
        if (!$this->Owner && !$this->Admin && !$this->Manager && !$this->Sales) {
            $this->session->set_flashdata('error', lang('access_denied'));
            $this->sma->md();
        }

        $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
        $this->data['opening_balance'] = $this->pos_model->getTodayOpeningBalance();
        $this->data['ccsales'] = $this->pos_model->getTodayCCSales();
        $this->data['dcsales'] = $this->pos_model->getTodayDCSales();
        $this->data['cnsales'] = $this->pos_model->getTodayCreditNoteSales();
        $this->data['cashsales'] = $this->pos_model->getTodayCashSales();
        $this->data['chsales'] = $this->pos_model->getTodayChSales();
        $this->data['pppsales'] = $this->pos_model->getTodayPPPSales();
        $this->data['stripesales'] = $this->pos_model->getTodayStripeSales();
        $this->data['totalsales'] = $this->pos_model->getTodaySales();
        $this->data['refunds'] = $this->pos_model->getTodayRefunds();
        $this->data['expenses'] = $this->pos_model->getTodayExpenses();
        $this->load->view($this->theme . 'pos/today_sale', $this->data);
    }

    function check_pin() {
        $pin = $this->input->post('pw', true);
        if ($pin == $this->pos_pin) {
            echo json_encode(array('res' => 1));
        }
        echo json_encode(array('res' => 0));
    }

    function barcode($text = NULL, $bcs = 'code39', $height = 50) {
        return site_url('products/gen_barcode/' . $text . '/' . $bcs . '/' . $height);
    }

    function settings() {
        
       //***** Added By Anil 16-08-2016 start****        
            $arr_possettings = $this->site->checkPermissions(); 
            if($arr_possettings[0]['pos_settings'] == NULL && $_SESSION['username'] != 'owner'){
                $this->session->set_flashdata('error', lang("access_denied"));
                redirect('welcome'); 
            }
        //***** Added By Anil 16-08-2016 End**** 
            
        if (!$this->Owner && !$this->Admin && !$this->Manager) { // *** Admin Added by Anil ***
            $this->session->set_flashdata('error', lang('access_denied'));
            redirect("welcome");
        }
        $this->form_validation->set_message('is_natural_no_zero', $this->lang->line('no_zero_required'));

        $this->form_validation->set_rules('pro_limit', $this->lang->line('pro_limit'), 'required|is_natural_no_zero');
        $this->form_validation->set_rules('pin_code', $this->lang->line('delete_code'), 'numeric');
        $this->form_validation->set_rules('category', $this->lang->line('default_category'), 'required|is_natural_no_zero');
        $this->form_validation->set_rules('customer', $this->lang->line('default_customer'), 'required|is_natural_no_zero');
        $this->form_validation->set_rules('biller', $this->lang->line('default_biller'), 'required|is_natural_no_zero');
        $this->form_validation->set_rules('order_discount_type', $this->lang->line('order_discount_type'), 'required');
        $this->form_validation->set_rules('max_pan_limit', $this->lang->line('max_pan_limit'), 'trim|required|alpha_numeric|max_length[10]');


        if ($this->form_validation->run() == true) {
            $data = array(
                'pro_limit' => $this->input->post('pro_limit'),
                'pin_code' => $this->input->post('pin_code') ? $this->input->post('pin_code') : NULL,
                'default_category' => $this->input->post('category'),
                'accessory_category' => $this->input->post('accessory_category'),
                'default_customer' => $this->input->post('customer'),
                'default_biller' => !empty($this->input->post('biller'))?$this->input->post('biller'):'NULL',
                'display_time' => $this->input->post('display_time'),
                'receipt_printer' => $this->input->post('receipt_printer'),
                'cash_drawer_codes' => $this->input->post('cash_drawer_codes'),
                'cf_title1' => $this->input->post('cf_title1'),
                'cf_title2' => $this->input->post('cf_title2'),
                'cf_value1' => $this->input->post('cf_value1'),
                'cf_value2' => $this->input->post('cf_value2'),
                'cf_title3' => $this->input->post('cf_title3'),
                'cf_title4' => $this->input->post('cf_title4'),
                'cf_value3' => $this->input->post('cf_value3'),
                'cf_value4' => $this->input->post('cf_value4'),
                
                'cf_title5' => $this->input->post('cf_title5'),
                'cf_title6' => $this->input->post('cf_title6'),
                'cf_value5' => $this->input->post('cf_value5'),
                'cf_value6' => $this->input->post('cf_value6'),
                
                'receipt_declaration'=>$this->input->post('receipt_declaration'),
                'service_centers'=>$this->input->post('service_centers'),
                'focus_add_item' => $this->input->post('focus_add_item'),
                'add_manual_product' => $this->input->post('add_manual_product'),
                'customer_selection' => $this->input->post('customer_selection'),
                'add_customer' => $this->input->post('add_customer'),
                'toggle_category_slider' => $this->input->post('toggle_category_slider'),
                'toggle_subcategory_slider' => $this->input->post('toggle_subcategory_slider'),
                'cancel_sale' => $this->input->post('cancel_sale'),
                'suspend_sale' => $this->input->post('suspend_sale'),
                'print_items_list' => $this->input->post('print_items_list'),
                'finalize_sale' => $this->input->post('finalize_sale'),
                'today_sale' => $this->input->post('today_sale'),
                'open_hold_bills' => $this->input->post('open_hold_bills'),
                'close_register' => $this->input->post('close_register'),
                'tooltips' => $this->input->post('tooltips'),
                'keyboard' => $this->input->post('keyboard'),
                'pos_printers' => $this->input->post('pos_printers'),
                'java_applet' => $this->input->post('enable_java_applet'),
                'isfullWidth' => $this->input->post('enable_full_width'), // Added By Anil 
                'enable_walkcustomer' => $this->input->post('enable_walkcustomer'), // Added By Anil
                'return_sales_perioed' => !empty($this->input->post('return_sales_perioed'))?$this->input->post('return_sales_perioed'):NULL, // Added by Anil
                'logout_after_payment' => $this->input->post('logout_after_payment'),
                'product_button_color' => !empty($this->input->post('product_button_color'))?$this->input->post('product_button_color'):NULL,
                'paypal_pro' => $this->input->post('paypal_pro'),
                'stripe' => $this->input->post('stripe'),
                'rounding' => $this->input->post('rounding'),
                'order_discount' => $this->input->post('order_discount'),
                'order_discount_type' => $this->input->post('order_discount_type'),
                'max_pan_limit' => $this->input->post('max_pan_limit'),
                'discount_type' => $this->input->post('discount_type'),
                'order_discount_type' => $this->input->post('order_discount_type'),
                'return_sales_all_stores' => $this->input->post('return_sales_all_stores')
            );
            $payment_config = array(
                'APIUsername' => $this->input->post('APIUsername'),
                'APIPassword' => $this->input->post('APIPassword'),
                'APISignature' => $this->input->post('APISignature'),
                'stripe_secret_key' => $this->input->post('stripe_secret_key'),
                'stripe_publishable_key' => $this->input->post('stripe_publishable_key'),
            );
        } elseif ($this->input->post('update_settings')) {
            $this->session->set_flashdata('error', validation_errors());
            redirect("pos/settings");
        }
        if ($this->form_validation->run() == true && $this->pos_model->updateSetting($data)) {
            if ($this->write_payments_config($payment_config)) {
                $this->session->set_flashdata('message', $this->lang->line('pos_setting_updated'));
                redirect("pos/settings");
            } else {
                $this->session->set_flashdata('error', $this->lang->line('pos_setting_updated_payment_failed'));
                redirect("pos/settings");
            }
        } else {

            $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');

            $this->data['pos'] = $this->pos_model->getSetting();           
            $this->data['categories'] = $this->site->getAllCategories();
            //$this->data['customer'] = $this->pos_model->getCompanyByID($this->pos_settings->default_customer);
            $this->data['billers'] = $this->pos_model->getAllBillerCompanies();
            $this->config->load('payment_gateways');
            $this->data['stripe_secret_key'] = $this->config->item('stripe_secret_key');
            $this->data['stripe_publishable_key'] = $this->config->item('stripe_publishable_key');
            $this->data['APIUsername'] = $this->config->item('APIUsername');
            $this->data['APIPassword'] = $this->config->item('APIPassword');
            $this->data['APISignature'] = $this->config->item('APISignature');
            $this->data['paypal_balance'] = $this->pos_settings->paypal_pro ? $this->paypal_balance() : NULL;
            $this->data['stripe_balance'] = $this->pos_settings->stripe ? $this->stripe_balance() : NULL;
            $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => '#', 'page' => lang('pos_settings')));
            $meta = array('page_title' => lang('pos_settings'), 'bc' => $bc);
            $this->page_construct('pos/settings', $meta, $this->data);
        }
    }

    public function write_payments_config($config) {
        if (!$this->Owner && !$this->Admin && !$this->Manager) {   // Admin & Manager Added By Anil
            $this->session->set_flashdata('error', lang('access_denied'));
            redirect("welcome");
        }
        $file_contents = file_get_contents('./assets/config_dumps/payment_gateways.php');
        $output_path = APPPATH . 'config/payment_gateways.php';
        $this->load->library('parser');
        $parse_data = array(
            'APIUsername' => $config['APIUsername'],
            'APIPassword' => $config['APIPassword'],
            'APISignature' => $config['APISignature'],
            'stripe_secret_key' => $config['stripe_secret_key'],
            'stripe_publishable_key' => $config['stripe_publishable_key'],
        );
        $new_config = $this->parser->parse_string($file_contents, $parse_data);

        $handle = fopen($output_path, 'w+');
        @chmod($output_path, 0777);

        if (is_writable($output_path)) {
            if (fwrite($handle, $new_config)) {
                @chmod($output_path, 0644);
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    function opened_bills($per_page = 0) {
        $this->load->library('pagination');

        //$this->table->set_heading('Id', 'The Title', 'The Content');
        if ($this->input->get('per_page')) {
            $per_page = $this->input->get('per_page');
        }

        $config['base_url'] = site_url('pos/opened_bills');
        $config['total_rows'] = $this->pos_model->bills_count();
        $config['per_page'] = 6;
        $config['num_links'] = 3;

        $config['full_tag_open'] = '<ul class="pagination pagination-sm">';
        $config['full_tag_close'] = '</ul>';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li>';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li>';
        $config['prev_tag_close'] = '</li>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a>';
        $config['cur_tag_close'] = '</a></li>';

        $this->pagination->initialize($config);
        $data['r'] = TRUE;
        $bills = $this->pos_model->fetch_bills($config['per_page'], $per_page);      
        if (!empty($bills)) {
            $html = "";
            $html .= '<ul class="ob">';
            foreach ($bills as $bill) {
                $date = DateTime::createFromFormat('Y-m-d H:i:s', $bill->date);

                $html .= '<li><button type="button" class="btn btn-info sus_sale" id="' . $bill->id . '"><p>' . $bill->suspend_note . '</p><strong>' . $bill->customer . '</strong><br>Date: ' . $date->format('d/m/Y H:i:s') . '<br>Items: ' . $bill->count . '<br>Total: ' . $this->sma->formatMoney($bill->total) . '</button></li>';
            }
            $html .= '</ul>';
        } else {
            $html = "<h3>" . lang('no_opeded_bill') . "</h3><p>&nbsp;</p>";
            $data['r'] = FALSE;
        }
        $data['html'] = $html;
        $data['page'] = $this->pagination->create_links();
        echo $this->load->view($this->theme . 'pos/opened', $data, TRUE);
    }

    function delete($id = NULL) {
        $this->sma->checkPermissions('index');
        if ($this->pos_model->deleteBill($id)) {
            echo lang("suspended_sale_deleted");
        }
    }

    function email_receipt($sale_id = NULL) {
        $this->load->library('Sma');
        $this->sma->checkPermissions('index');
        if ($this->input->post('id')) {
            $sale_id = $this->input->post('id');
        } else {
            die();
        }
        $this->load->helper('text');
        if ($this->input->post('email')) {
            $to = $this->input->post('email');
        }
        $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
        $this->data['message'] = $this->session->flashdata('message');

        $this->data['rows'] = $this->pos_model->getAllInvoiceItems($sale_id);
        $inv = $this->pos_model->getInvoiceByID($sale_id);
        $biller_id = $inv->biller_id;
        $customer_id = $inv->customer_id;
        $this->data['allbillers'] = $this->pos_model->getAllBillers();
        $this->data['biller'] = $this->pos_model->getCompanyByID($biller_id);
        $this->data['customer'] = $this->pos_model->getCompanyByID($customer_id);
        $this->data['payments'] = $this->pos_model->getInvoicePayments($sale_id);
        $this->data['pos'] = $this->pos_model->getSetting();
        $this->data['barcode'] = $this->barcode($inv->reference_no, 'code39', 30);
        $this->data['inv'] = $inv;
        $this->data['sid'] = $sale_id;
        $this->data['modal'] = $modal;
        $this->data['page_title'] = $this->lang->line("invoice");
        $this->data['discount_type'] = $this->pos_model->discountType();

        if (!$to) {
            $to = $this->data['customer']->email;
        }
        if (!$to) {
            echo json_encode(array('msg' => $this->lang->line("no_meil_provided")));
        }
        $receipt = $this->load->view($this->theme . 'pos/email_receipt', $this->data, TRUE);

        if ($this->sma->send_email($to, 'Receipt from ' . $this->data['biller']->company, $receipt)) {
            echo json_encode(array('msg' => $this->lang->line("email_sent")));
        } else {
            echo json_encode(array('msg' => $this->lang->line("email_failed")));
        }
    }

    public function active() {
        $this->session->set_userdata('last_activity', now());
        if ((now() - $this->session->userdata('last_activity')) <= 20) {
            die('Successfully updated the last activity.');
        } else {
            die('Failed to update last activity.');
        }
    }

    function add_payment($id = NULL) {
        $this->sma->checkPermissions('payments', true, 'sales');
        $this->load->helper('security');
        if ($this->input->get('id')) {
            $id = $this->input->get('id');
        }

        $this->form_validation->set_rules('reference_no', lang("reference_no"), 'required');
        $this->form_validation->set_rules('amount-paid', lang("amount"), 'required');
        $this->form_validation->set_rules('paid_by', lang("paid_by"), 'required');
        //$this->form_validation->set_rules('note', lang("note"), 'xss_clean');
        $this->form_validation->set_rules('userfile', lang("attachment"), 'xss_clean');
        if ($this->form_validation->run() == true) {
            if ($this->Owner || $this->Admin) {
                $date = $this->sma->fld(trim($this->input->post('date')));
            } else {
                $date = date('Y-m-d H:i:s');
            }
            $payment = array(
                'date' => $date,
                'sale_id' => $this->input->post('sale_id'),
                'reference_no' => $this->input->post('reference_no'),
                'amount' => $this->input->post('amount-paid'),
                'paid_by' => $this->input->post('paid_by'),
                'cheque_no' => $this->input->post('cheque_no'),
                'cc_no' => $this->input->post('paid_by') == 'credit_voucher' ? $this->input->post('gift_card_no') : $this->input->post('pcc_no'),
                'cc_holder' => $this->input->post('pcc_holder'),
                'cc_month' => $this->input->post('pcc_month'),
                'cc_year' => $this->input->post('pcc_year'),
                'cc_type' => $this->input->post('pcc_type'),
                'cc_cvv2' => $this->input->post('pcc_ccv'),
                'note' => $this->input->post('note'),
                'created_by' => $this->session->userdata('user_id'),
                'type' => 'received'
            );

            if ($_FILES['userfile']['size'] > 0) {
                $this->load->library('upload');
                $config['upload_path'] = $this->digital_upload_path;
                $config['allowed_types'] = $this->digital_file_types;
                $config['max_size'] = $this->allowed_file_size;
                $config['overwrite'] = FALSE;
                $config['encrypt_name'] = TRUE;
                $this->upload->initialize($config);
                if (!$this->upload->do_upload()) {
                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect($_SERVER["HTTP_REFERER"]);
                }
                $photo = $this->upload->file_name;
                $payment['attachment'] = $photo;
            }

            //$this->sma->print_arrays($payment);
        } elseif ($this->input->post('add_payment')) {
            $this->session->set_flashdata('error', validation_errors());
            redirect($_SERVER["HTTP_REFERER"]);
        }


        if ($this->form_validation->run() == true && $msg = $this->pos_model->addPayment($payment)) {
            if ($msg) {
                if ($msg['status'] == 0) {
                    $error = '';
                    foreach ($msg as $m) {
                        $error .= '<br>' . (is_array($m) ? print_r($m, true) : $m);
                    }
                    $this->session->set_flashdata('error', '<pre>' . $error . '</pre>');
                } else {
                    $this->session->set_flashdata('message', lang("payment_added"));
                }
            } else {
                $this->session->set_flashdata('error', lang("payment_failed"));
            }
            redirect("pos/sales");
        } else {

            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));

            $sale = $this->pos_model->getInvoiceByID($id);
            $this->data['inv'] = $sale;
            $this->data['payment_ref'] = $this->site->getReference('pay');
            $this->data['modal_js'] = $this->site->modal_js();

            $this->load->view($this->theme . 'pos/add_payment', $this->data);
        }
    }

    function updates() {
        if (DEMO) {
            $this->session->set_flashdata('warning', lang('disabled_in_demo'));
            redirect($_SERVER["HTTP_REFERER"]);
        }
        if (!$this->Owner) {
            $this->session->set_flashdata('error', lang('access_denied'));
            redirect("welcome");
        }
        $this->form_validation->set_rules('purchase_code', lang("purchase_code"), 'required');
        $this->form_validation->set_rules('envato_username', lang("envato_username"), 'required');
        if ($this->form_validation->run() == true) {
            $this->db->update('pos_settings', array('purchase_code' => $this->input->post('purchase_code', TRUE), 'envato_username' => $this->input->post('envato_username', TRUE)), array('pos_id' => 1));
            redirect('pos/updates');
        } else {
            $fields = array('version' => $this->pos_settings->version, 'code' => $this->pos_settings->purchase_code, 'username' => $this->pos_settings->envato_username, 'site' => base_url());
            $this->load->helper('update');
            $protocol = is_https() ? 'https://' : 'http://';
            $updates = get_remote_contents($protocol . 'tecdiary.com/api/v1/update/', $fields);
            $this->data['updates'] = json_decode($updates);
            $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => '#', 'page' => lang('updates')));
            $meta = array('page_title' => lang('updates'), 'bc' => $bc);
            $this->page_construct('pos/updates', $meta, $this->data);
        }
    }

    function install_update($file, $m_version, $version) {
        if (DEMO) {
            $this->session->set_flashdata('warning', lang('disabled_in_demo'));
            redirect($_SERVER["HTTP_REFERER"]);
        }
        if (!$this->Owner) {
            $this->session->set_flashdata('error', lang('access_denied'));
            redirect("welcome");
        }
        $this->load->helper('update');
        save_remote_file($file . '.zip');
        $this->sma->unzip('./files/updates/' . $file . '.zip');
        if ($m_version) {
            $this->load->library('migration');
            if (!$this->migration->latest()) {
                $this->session->set_flashdata('error', $this->migration->error_string());
                redirect("pos/updates");
            }
        }
        $this->db->update('pos_settings', array('version' => $version, 'update' => 0), array('pos_id' => 1));
        unlink('./files/updates/' . $file . '.zip');
        $this->session->set_flashdata('success', lang('update_done'));
        redirect("pos/updates");
    }

    /*
     * Added by Ajay 
     * on 1-04-2016
     */

    public function compare_registers($user_id = NULL) {
        $this->sma->checkPermissions('index');
        if (!$this->Owner && !$this->Admin) {
            $user_id = $this->session->userdata('user_id');
        }
        $this->form_validation->set_rules('total_cash', lang("total_cash"), 'trim|required|numeric');
        $this->form_validation->set_rules('total_cheques', lang("total_cheques"), 'trim|required|numeric');
        $this->form_validation->set_rules('total_cc_slips', lang("total_cc_slips"), 'trim|required|numeric');

        if ($this->form_validation->run() == TRUE) {
            if ($this->Owner || $this->Admin) {
                $user_register = $user_id ? $this->pos_model->registerData($user_id) : NULL;
                $rid = $user_register ? $user_register->id : $this->session->userdata('register_id');
                $user_id = $user_register ? $user_register->user_id : $this->session->userdata('user_id');
            } else {
                $rid = $this->session->userdata('register_id');
                $user_id = $this->session->userdata('user_id');
            }
            $data = array('closed_at' => date('Y-m-d H:i:s'),
                'total_cash' => $this->input->post('total_cash'),
                'total_cheques' => $this->input->post('total_cheques'),
                'total_cc_slips' => $this->input->post('total_cc_slips'),
                'total_cash_submitted' => $this->input->post('total_cash_submitted'),
                'total_cheques_submitted' => $this->input->post('total_cheques_submitted'),
                'total_cc_slips_submitted' => $this->input->post('total_cc_slips_submitted'),
                'note' => $this->input->post('note'),
                'status' => 'close',
                'transfer_opened_bills' => $this->input->post('transfer_opened_bills'),
                'closed_by' => $this->session->userdata('user_id'),
            );

            $cash_data = array(
                'user_id' => $user_id,
                'pos_register_id' => $rid,
                'cash_in_hand' => $this->input->post('total_cash_submitted'),
                'status' => 'closed',
                'date' => date('Y-m-d H:i:s'),
                'thousand' => $this->input->post('thousand'),
                'five_hundred' => $this->input->post('five_hundred'),
                'hundred' => $this->input->post('hundred'),
                'fifty' => $this->input->post('fifty'),
                'twenty' => $this->input->post('twenty'),
                'ten' => $this->input->post('ten')
            );

            $this->data['pos_register_data'] = $data;
            $this->data['pos_cash_drawer_data'] = $cash_data;
            $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => '#', 'page' => lang('compare_registers')));
            $meta = array('page_title' => lang('compare_registers'), 'bc' => $bc);
            $this->page_construct('pos/compare_registers', $meta, $this->data);
            //$this->load->view($this->theme . 'pos/compare_registers', $this->data);
        } elseif ($this->input->post('close_register')) {
            $this->session->set_flashdata('error', (validation_errors() ? validation_errors() : $this->session->flashdata('error')));
            redirect("pos");
        } else {
            if ($this->Owner || $this->Admin) {
                $user_register = $user_id ? $this->pos_model->registerData($user_id) : NULL;
                $register_open_time = $user_register ? $user_register->date : $this->session->userdata('register_open_time');
                $this->data['cash_in_hand'] = $user_register ? $user_register->cash_in_hand : NULL;
                $this->data['register_open_time'] = $user_register ? $register_open_time : NULL;
            } else {
                $register_open_time = $this->session->userdata('register_open_time');
                $this->data['cash_in_hand'] = NULL;
                $this->data['register_open_time'] = NULL;
            }
            $rid = $this->session->userdata('register_id');
            $user_id = $this->session->userdata('user_id');
            $register_open_time = $this->session->userdata('register_open_time');
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $this->data['ccsales'] = $this->pos_model->getRegisterCCSales($register_open_time, $user_id);
            $this->data['cashsales'] = $this->pos_model->getRegisterCashSales($register_open_time, $user_id);
            $this->data['chsales'] = $this->pos_model->getRegisterChSales($register_open_time, $user_id);
            $this->data['cashdrawer'] = $this->pos_model->getCashDrawerDetails($register_open_time, $rid, $user_id);
            $this->data['pppsales'] = $this->pos_model->getRegisterPPPSales($register_open_time, $user_id);
            $this->data['stripesales'] = $this->pos_model->getRegisterStripeSales($register_open_time, $user_id);
            $this->data['totalsales'] = $this->pos_model->getRegisterSales($register_open_time, $user_id);
            $this->data['refunds'] = $this->pos_model->getRegisterRefunds($register_open_time);
            $this->data['cashrefunds'] = $this->pos_model->getRegisterCashRefunds($register_open_time);
            $this->data['expenses'] = $this->pos_model->getRegisterExpenses($register_open_time);
            $this->data['users'] = $this->pos_model->getUsers($user_id);
            $this->data['suspended_bills'] = $this->pos_model->getSuspendedsales($user_id);
            $this->data['user_id'] = $user_id;
            $this->data['modal_js'] = $this->site->modal_js();

            $this->load->view($this->theme . 'pos/close_register', $this->data);
        }
    }

    /*
     * Added by Ajay 
     * on 1-04-2016
     */

    public function submit_close_register() {

        $data = unserialize($_REQUEST['register_data']);
        if (!empty($data)) {
            $this->pos_model->closeRegister($data[1]['pos_register_id'], $data[1]['user_id'], $data[0]);
            $this->pos_model->closePosCashDrawer($data[1]);
            $this->session->set_flashdata('message', lang("register_closed"));
            redirect("welcome");
        }
    }

    /*
     * Added by ajay
     * 11-04-2016
     * To authenticate sales for discount below minimun price
     */

    public function authenticate_discount() {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $user_discount = $_POST['discount'];

        $userData = $this->pos_model->getDiscountAuthentication($username, $password, $user_discount);
        //echo "<pre>";print_r($userData);
        if ($userData[1] == 1) {
            echo json_encode(array('userdata' => $userData[0],'status'=>'success'));
            //$userData = $this->pos_model->getDiscountAuthentication($username, $password);
        }else{   
            echo json_encode(array("data"=>$userData,'status' => 'failed'));
        }
    }

    /*
     * Added by Ajay
     * Check logged in user for discount
     * on 13-04-2016
     */

    public function checkLoggedInUserForDiscount() {
        $userdata = $this->session->all_userdata();
        $logged = $this->pos_model->getLoggedInUserForDiscount($userdata['email']);
        if ($logged == TRUE) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /*
     * 	Added by Ajay
     * 	check whether discount entered is gereater than max discount
     * 	on 16-04-2016
     */

    public function getMaxOrderDiscount() {
        $discount = $this->input->post('discount');
        if ($discount <= $this->pos_settings->order_discount) {
            echo json_encode(array('status' => true));
        } else {
            echo json_encode(array('status' => false));
        }
    }

    /*
     * 	Updated by Ajay
     * 	close registers at owner end and add warehouse id
     * 	on 13-12-2016
     */

    public function closeRegisterById($userid, $registerid,$warehouse_id) {
        $this->sma->checkPermissions('index');
//        if (!$this->Owner && !$this->Admin) {
//            $user_id = $this->session->userdata('user_id');
//            $wid = $warehouse_id;
//        } else {
//            $user_id = $userid;
//            $rid = $registerid;
//            $wid = $warehouse_id;
//        }
        /*Warehouse Id updated by Chitra to manage register store wise */
        //echo "userid :".$userid."register id :".$registerid."warehouse id :".$warehouse_id;
       
        $rid = !empty($registerid) ? $registerid : $this->session->userdata('register_id');
        $user_id = !empty($userid) ? $userid : $this->session->userdata('user_id');
        $wid = !empty($warehouse_id) ? $warehouse_id : $this->session->userdata('warehouse_id');
        //echo "userid :".$user_id."register id :".$rid."warehouse id :".$wid;die;
           
        $this->form_validation->set_rules('total_cash', lang("total_cash"), 'trim|required|numeric');
        $this->form_validation->set_rules('total_cheques', lang("total_cheques"), 'trim|required|numeric');
        $this->form_validation->set_rules('total_cc_slips', lang("total_cc_slips"), 'trim|required|numeric');
        $this->form_validation->set_rules('total_cash_submitted', lang("total_cash_submitted"), 'trim|required|numeric');

        if ($this->form_validation->run() == TRUE) {

            $data = array('closed_at' => date('Y-m-d H:i:s'),
                'total_cash' => $this->input->post('total_cash'),
                'total_cheques' => $this->input->post('total_cheques'),
                'total_cc_slips' => $this->input->post('total_cc_slips'),
                'total_cash_submitted' => $this->input->post('total_cash_submitted'),
                'total_cheques_submitted' => $this->input->post('total_cheques_submitted'),
                'total_cc_slips_submitted' => $this->input->post('total_cc_slips_submitted'),
                'note' => $this->input->post('note'),
                'status' => 'close',
                'transfer_opened_bills' => $this->input->post('transfer_opened_bills'),
                'closed_by' => $this->session->userdata('user_id'),
                'warehouse_id' => $wid
            );

           
        } elseif ($this->input->post('close_register')) {
            $this->session->set_flashdata('error', (validation_errors() ? validation_errors() : $this->session->flashdata('error')));
            redirect("pos");
        }

        /*
          if($this->form_validation->run() == TRUE){
          if ($this->input->post('total_cash') != $this->input->post('total_cash_submitted')) {
          redirect('pos/compare_cash');
          }
          }
         */
        
        if ($this->form_validation->run() == TRUE && $this->pos_model->closeRegister($rid, $user_id, $wid,$data)) {
            $this->pos_model->deleteBillByWarehouse($this->session->userdata('warehouse_id'));
            $cash_data = array(
                'user_id' => $user_id,
                'pos_register_id' => $rid,
                'cash_in_hand' => $this->input->post('total_cash_submitted'),
                'status' => 'closed',
                'date' => date('Y-m-d H:i:s'),
                'thousand' => $this->input->post('thousand'),
                'five_hundred' => $this->input->post('five_hundred'),
                'hundred' => $this->input->post('hundred'),
                'fifty' => $this->input->post('fifty'),
                'twenty' => $this->input->post('twenty'),
                'ten' => $this->input->post('ten')
            );

            $this->pos_model->closePosCashDrawer($cash_data);
            $this->session->set_flashdata('message', lang("register_closed"));
            redirect("pos?register_id=".$rid);
        } else {
//            if ($this->Owner || $this->Admin) {
//                
//                $user_register = $userid ? $this->pos_model->registerData($userid) : NULL;
//                $register_open_time = $user_register ? $user_register->date : $this->session->userdata('register_open_time');
//                $this->data['cash_in_hand'] = $user_register ? $user_register->cash_in_hand : NULL;
//                $this->data['register_open_time'] = $user_register ? $register_open_time : NULL;
//                //echo "1111111111111<br>"; print_r($user_register); echo "<br>000000000"; die;
//            } else {
//                $register_open_time = $this->session->userdata('register_open_time');
//                $rid = $this->session->userdata('register_id');
//                $user_id = $this->session->userdata('user_id');
//                $this->data['cash_in_hand'] = NULL;
//                $this->data['register_open_time'] = NULL;
//            }
                $warehouse_register = !empty($wid) ? $this->pos_model->registerDataByWarehouse($wid) : NULL;
                $register_open_time = $warehouse_register ? $warehouse_register->date : $this->session->userdata('register_open_time');
                $this->data['cash_in_hand'] = $warehouse_register ? $warehouse_register->cash_in_hand : NULL;
                $this->data['register_open_time'] = $warehouse_register ? $register_open_time : NULL;
            //$user_id = $userid;
            //$rid = $registerid;
            //echo "register open time : ".$register_open_time.'user id : '.$user_id.'rid : '.$rid;die;
            //echo "<pre>";
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $this->data['ccsales'] = $this->pos_model->getStoreRegisterCCSales($register_open_time, $rid);
            $this->data['dcsales'] = $this->pos_model->getStoreRegisterDCSales($register_open_time,$rid);
            //print_r($this->data['ccsales']);print_r($this->data['dcsales']);die;
            $this->data['cashsales'] = $this->pos_model->getStoreRegisterCashSales($register_open_time, $rid);
            $this->data['chsales'] = $this->pos_model->getStoreRegisterChSales($register_open_time, $rid);
            $this->data['cashdrawer'] = $this->pos_model->getStoreCashDrawerDetails($register_open_time, $rid);
            $this->data['pppsales'] = $this->pos_model->getStoreRegisterPPPSales($register_open_time, $rid);
            $this->data['stripesales'] = $this->pos_model->getStoreRegisterStripeSales($register_open_time, $rid);
            $this->data['totalsales'] = $this->pos_model->getStoreRegisterSales($register_open_time, $rid);
            $this->data['refunds'] = $this->pos_model->getStoreRegisterRefunds($register_open_time,$rid);
            $this->data['cashrefunds'] = $this->pos_model->getStoreRegisterCashRefunds($register_open_time,$rid);
            $this->data['expenses'] = $this->pos_model->getStoreRegisterExpenses($register_open_time,$rid);
            $this->data['users'] = $this->pos_model->getUsers($user_id);
            $this->data['suspended_bills'] = $this->pos_model->getStoreSuspendedsales($user_id,$wid);
            $this->data['cvAmount'] = $this->pos_model->totalStoreCreditVoucherAmount($register_open_time, $rid);
            $this->data['ccAmount'] = $this->pos_model->totalStoreCreditCardAmount($register_open_time,$rid);
            $this->data['dcAmount'] = $this->pos_model->totalStoreDebitCardAmount($register_open_time,$rid);
            $this->data['user_id'] = $user_id;
            $this->data['warehouse'] = $wid;
            // echo "Data: <pre>"; print_r($this->data['cashsales']);exit;
            $this->data['modal_js'] = $this->site->modal_js();
            $this->load->view($this->theme . 'pos/close_register', $this->data);
        }
    }

    /*
     * Added by Ajay
     * get all users from sma_users
     * on 20-04-2016
     */

    public function getAllUsers() {
        $users = $this->pos_model->getAllUsers();
        //$users[0]['user_id'] = $this->session->userdata('user_id');
        foreach($users as $key=>$val){
            if($val['id'] == $this->session->userdata('user_id')){
                $users['logged_in_user'] = true;
            }else{
                $users['logged_in_user'] = false;
            }
        }
        echo json_encode($users);
    }

    public function getAuthUsers() {
        $whId = $this->input->get('warehouse_id', true);
        $users = $this->pos_model->getAuthUsers($whId);
        echo json_encode($users);
    }
    /*
     * Added by Ajay
     * decrease balance quantity
     * on 22-04-2016
     */

    public function decreaseBalanceQuantity() {
        $product_warehouse_id = $this->input->post('product_warehouse_id');
        $quantity = $this->input->post('quantity');

        $res = $this->pos_model->decreaseWarehouseProductQuantity($product_warehouse_id, $quantity);
        echo json_encode($res);
    }

    /*
     * Author: Ankit
     * save customer Name & mobile 
     * on 09-05-2016
     */

    public function addCustomerDetails() {
        //echo "<pre>";print_r($this->session->all_userdata()['biller_id']);die;
        $biller = $this->session->all_userdata()['biller_id'];
        $w = $this->site->getCompanyName($biller);

        $data = array('name' => $this->input->post('name'),
            'group_id' => '3',
            'group_name' => 'customer',
            'customer_group_id' => '1',
            'customer_group_name' => 'General',
            'email' => 'N/A',
            'phone' => $this->input->post('mobile'),
            'company' => NULL,
            'type' => 1,
        );

        if ($this->db->insert('companies', $data)) {
            $cid = $this->db->insert_id();
            //added by ajay on 01-06-2016
            $this->session->set_userdata(array('last_added_customer_id' => $cid));
            echo json_encode($cid);
            die();
        }

        echo Null;
        die();
    }

    /*
     * Author: Ajay
     * get duplicate values keys in an array 
     * on 4-06-2016
     */

    public function get_keys_for_duplicate_values($my_arr, $clean = false) {
        if ($clean) {
            return array_unique($my_arr);
        }
        $dups = array();
        foreach ($my_arr as $key => $val) {
            if (!isset($new_arr[$val])) {
                $new_arr[$val] = $key;
                $dups[$val][] = $key;
            } else {
                if (isset($dups[$val])) {
                    $dups[$val][] = $key;
                } else {
                    $dups[$val] = array($key);
                }
            }
        }
        return $dups;
    }

    /*
     * Author: Ajay
     * save invoice as pdf
     * on 14-06-2016
     */

    public function save_invoice_pdf($id = NULL, $view = NULL) {

        $this->sma->checkPermissions('index');
        if ($this->input->get('id')) {
            $sale_id = $this->input->get('id');
        } else {
            $sale_id = $id;
        }

        $this->load->helper('text');
        $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
        $this->data['message'] = $this->session->flashdata('message');

        $this->data['rows'] = $this->pos_model->getAllInvoiceItems($sale_id);
        $inv = $this->pos_model->getInvoiceByID($sale_id);
        if($inv->sale_status === 'foc'){
            $this->data['foc_details'] = $this->pos_model->getCustomerServiceBySaleId($sale_id);
        }
        $biller_id = $inv->biller_id;
        $customer_id = $inv->customer_id;
        $this->data['allbillers'] = $this->pos_model->getAllBillers();
        $this->data['biller'] = $this->pos_model->getCompanyByID($biller_id);
        $this->data['customer'] = $this->pos_model->getCompanyByID($customer_id);
        $this->data['payments'] = $this->pos_model->getInvoicePayments($sale_id);
        foreach($this->data['payments'] as $p=>$payment){
            if ($payment->paid_by == 'credit_voucher' && $payment->pos_paid) {
                if($payment->cn_balance > 0){
                    $card_details = $this->site->getGiftCardByNO($payment->cc_no);
                    $this->data['payments'][$p]->credit_note_id = $card_details->id;
                    $this->data['payments'][$p]->balance = $card_details->balance;
                }            
            }
        }
        $this->data['pos'] = $this->pos_model->getSetting();
        $this->data['barcode'] = $this->barcode($inv->reference_no, 'code39', 30);
        $this->data['inv'] = $inv;
        $this->data['sid'] = $sale_id;
        //$this->data['modal'] = $modal;
        $this->data['page_title'] = $this->lang->line("invoice");
        $this->data['discount_type'] = $this->pos_model->discountType();

        $name = $inv->customer. '_' . $inv->id . '.pdf';
        //echo "<pre>";print_r($this->data);exit;
        if ($view) {
            $this->load->view($this->theme . 'pos/invoice_pdf', $this->data);//exit;
        } else {
            $html = $this->load->view($this->theme . 'pos/invoice_pdf', $this->data, TRUE);//exit;
//            echo $html; DIE;
            $this->sma->generate_pdf($html, $name);
        }
    }

    public function accessories() {

        $this->load->model('products_model');
        //$products = $this->products_model->getProductsByCategoryId($this->pos_settings->accessory_category);
       // $products = $this->products_model->getAllProducts();
        $products = $this->products_model->getAllProductsbyname();
        $salesExeList = $this->products_model->getSalesExeList();
        
        $this->data['products'] = $products;
        $this->data['modal_js'] = $this->site->modal_js();
        $this->data['sales_exe'] = $salesExeList;

        
        $this->data['emrs'] = $this->input->get('emrs')?'1':'';

        $this->load->view($this->theme . 'pos/accessories', $this->data);
    }

    public function add_accessories_sale() {    
                     
        $quantity = $this->input->post('quantity');
        $total = $this->input->post('real_unit_price') * $quantity;
        $total_discount = $this->input->post('real_unit_price') * $quantity;
        $biller_details = $this->site->getCompanyByID($this->session->userdata('biller_id'));
            
            $data = array('date' => date('Y-m-d H:i:s'),
                'reference_no' => $this->site->getReference('pos'),
                'customer_id' => '',
                'customer' => $this->input->post('customer_name'),
                'biller_id' => $this->session->userdata('biller_id'),
                'biller' => $biller_details->name,
                'warehouse_id' => $this->session->userdata('warehouse_id'),
                'note' => '',
                'staff_note' => '',
                //'note' => $pos_note,
                'total' => $this->sma->formatDecimal($total - $total_discount),
                'product_discount' => $this->input->post('real_unit_price'),
                'order_discount_id' => '',
                'order_discount' => '',
                'total_discount' => $this->input->post('real_unit_price')*$quantity,
                'product_tax' => $this->input->post('item_tax'),
                'order_tax_id' => '',
                'order_tax' => '',
                'total_tax' => $this->sma->formatDecimal($total - $total_discount),
                'shipping' => $this->sma->formatDecimal(0),
                'grand_total' => $this->sma->formatDecimal($total - $total_discount),
                'total_items' => $this->input->post('quantity'),
                'sale_status' => 'foc',
                'payment_status' => 'paid',
                'payment_term' => 0,
                'pos' => 1,
                'paid' => 0,
                'created_by' => $this->session->userdata('user_id'),
                'sales_executive_id' => $this->session->userdata('user_id'),
                'invoice_discount_reason' => '',
                'register_id' => $this->session->userdata('register_id'),
                'pan_number' => !empty($this->input->post('pan_number_hidden')) ? $this->input->post('pan_number_hidden') : '',
                'return_flg' => 5,
                'return_time' => $this->pos_settings->return_sales_perioed
            );
            
            $products = array(
                            'product_id' => $this->input->post('product_id'),
                            'product_code' => $this->input->post('product_code'),
                            'product_name' => $this->input->post('item_name'),
                            'product_type' => $this->input->post('product_type'),
                            'option_id' => $this->input->post('product_option'),
                            'net_unit_price' => $this->input->post('net_unit_cost')*$quantity,
                            'unit_price' => $this->input->post('unit_price'),
                            'quantity' => $this->input->post('quantity'),
                            'warehouse_id' => $this->session->userdata('warehouse_id'),
                            //'item_tax' => $pr_item_tax,
                            'tax_rate_id' => $this->input->post('tax_rate_id'),
                            'tax' => $this->sma->formatDecimal($total - $total_discount),
                            'discount' => $this->input->post('real_unit_price')*$quantity,
                            'item_discount' => $this->input->post('real_unit_price'),
                            'pdiscount_type' => 'foc', 
                            'subtotal' => $this->sma->formatDecimal(0),
                            'serial_no' => $this->input->post('product_serial'),
                            'real_unit_price' => $this->input->post('real_unit_price')*$quantity,
                            'net_unit_cost' => $this->input->post('net_unit_cost')*$quantity,
                            'item_tax' => $this->sma->formatDecimal($total - $total_discount)
                        );
            
            $payment = array(
                            'date' => date('Y-m-d H:i:s'),
                            'reference_no' => $this->site->getReference('pay'),
                            'amount' => 0,
                            'paid_by' => 'N/A',
                            'cheque_no' => '',
                            'cc_no' => '',
                            'cc_holder' => '',
                            'cc_month' => '',
                            'cc_year' => '',
                            'cc_type' => '',
                            
                            'card_type' => '',
                            'created_by' => $this->session->userdata('user_id'),
                            'type' => 'foc',
                            'note' => '',
                            'pos_paid' => '',
                            'pos_balance' => '',
                            'cn_balance' => '',
                            'approval_no' => '',
                            'register_id' => $this->session->userdata('register_id'),
                        );
            if ($this->db->insert('sales', $data)) {
                $sale_id = $this->db->insert_id();
                $this->site->updateReference('pos');
                
                $products['sale_id'] = $sale_id;
                $this->db->insert('sale_items', $products);
                
                $payment['sale_id'] = $sale_id;
                $this->db->insert('payments', $payment);
                $payment_id = $this->db->insert_id();
                $this->site->updateReference('pay');
                $cdata = array(
                    'sale_id' => $sale_id,
                    'datetime' => date('Y-m-d H:i:s'),                
                    'product_id' => $this->input->post('product_id'),
                    'product_code' => $this->input->post('product_code'),
                    'product_name' => $this->input->post('item_name'),
                    'warehouse_id' => $this->input->post('warehouse_id'),
                    'customer_name' => $this->input->post('customer_name'),
                    'mobile' => $this->input->post('mobile_no'),
                    'reference' => $this->input->post('reference'),
                    'quantity' => $this->input->post('quantity')                
                );
                $ar = $this->pos_model->UpdateACQty($cdata);
                
                if($payment_id > 0){
                    redirect("pos/view/".$sale_id);
                }
            }
                
            $ar = $this->pos_model->UpdateACQty($data);
//            if ($this->db->insert_id() > 0) {    
//                echo json_encode(array('status'=>'success','sale_id'=>$sale_id));die;
//            }else{
//                echo json_encode(array('status'=>'failed'));die;
//            }

    }

    public function getBalanaceQtyAccessory() {
        $pr_id = $this->input->post('product_id');
        $balance = $this->site->getBalanceQuantityOfProduct($pr_id);
        echo json_encode(array('balance' => $balance));
    }
   public function getBalanaceQtyAccessorybyname() {
        $pr_id = $this->input->post('product_id');
        $balance = $this->site->getBalanceQuantityOfProductbyname($pr_id);
        echo json_encode(array('balance' => $balance));
    }
    public function test(){
         $this->data['page_title'] = $this->lang->line("invoice");
        $this->load->view($this->theme . 'pos/test', $this->data);
    }
    
    /*
     * Added By Ajay
     * on 02-03-2017
     * for uniqueness of approval no
     */
    
    public function getApprovalNumberAvaibility(){
        $approval_no = $this->input->post('approval_no');
        $available = $this->pos_model->getApprovalNumberForUniqueness($approval_no);
        echo json_encode($available);
    }
    
    public function zreportPdf($report_id = NULL,$wh_id = NULL) {
        //$this->sma->checkPermissions('index');
        $this->load->model('pos_model');
        $this->load->model('reports_model');
        if ($this->input->get('id')) {
            $report_id = $this->input->get('id');
        }
        $this->load->library('datatables');
        $this->load->model('pos_model');
        $this->load->helper('text');
        //echo $report_id;
        if ($this->Owner || $this->Admin) {
            //$wh_id = $this->site->getAllWarehouses();
            $this->data['warehouses'] = $this->site->getAllWarehouses();
            $this->data['warehouse_id'] = $wh_id;
            $this->data['warehouse'] = $wh_id ? $this->site->getWarehouseByID($wh_id) : NULL;
        }
        else{
            $wh_id = $_SESSION['warehouse_id'];
        }
        
        $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
        $this->data['message'] = $this->session->flashdata('message');
        $register_date = $this->reports_model->getRegisterDate($report_id,$wh_id);
        //echo print_r($register_date);exit;
        $user_id = $this->session->userdata('user_id');
        $user_register = $user_id ? $this->reports_model->registerStatus($user_id,$wh_id,$register_date->date) : NULL;
        $register_open_time = $user_register ? $user_register->date : $this->session->userdata('register_open_time');
        
        $this->data['report_id'] =  $report_id;
        $this->data['dcsales'] = $this->reports_model->getRegisterDC($report_id);
        $this->data['ccsales'] = $this->reports_model->getRegisterCC($report_id);
        $this->data['refunds'] = $this->reports_model->getRegisterReturns($report_id);
        $this->data['cashPay'] = $this->reports_model->cashPay($report_id);
        $this->data['sales_tax'] = $this->reports_model->getRegisterTax($report_id);
        $this->data['bank_amount'] = $this->reports_model->getRegisterExpenses($report_id);
        $this->data['rows'] = $this->reports_model->z_report_id($report_id,$register_date->warehouse_id);
        $name = "z_report_".$report_id.".pdf";
        $html = $this->load->view($this->theme . 'reports/zreportPdf', $this->data, TRUE);
        $this->sma->generate_pdf($html, $name);
    }
    
    public function customerCreditNotes(){
        $cust_id = $this->input->post('customer_id');
        $data = $this->pos_model->getCustomerCreditNotes($cust_id);
        echo json_encode($data);
    }

    public function add_emrs_sale() {    
        if(isset($_POST['customer_name']) && ($_POST['product_id'])){          
            $quantity = $this->input->post('quantity');
            $total = $this->input->post('real_unit_price') * $quantity;
            $total_discount = $this->input->post('real_unit_price') * $quantity;
            $biller_details = $this->site->getCompanyByID($this->session->userdata('biller_id'));
            $maxId = $this->db->select("id")->from("emrs")->order_by("id",DESC)->get()->row();  

            $maxId = count($maxId)>0?($maxId->id+1):1;
            
            $data = array('date' => date('Y-m-d H:i:s'),
                'reference_no' => 'PUR/'.date('Y')."/".$maxId,
                'customer_id' => $this->input->post('customer_name'),
                'customer' => $this->input->post('customer_name'),
                'biller_id' => $this->session->userdata('biller_id'),
                'biller' => $biller_details->name,
                'warehouse_id' => $this->session->userdata('warehouse_id'),
                'note' => '',
                'staff_note' => '',
                //'note' => $pos_note,
                'total' => $this->sma->formatDecimal($total - $total_discount),
                'product_discount' => $this->input->post('real_unit_price'),
                'order_discount_id' => '',
                'order_discount' => '',
                'total_discount' => $this->input->post('real_unit_price')*$quantity,
                'product_tax' => $this->input->post('item_tax'),
                'order_tax_id' => '',
                'order_tax' => '',
                'total_tax' => $this->sma->formatDecimal($total - $total_discount),
                'shipping' => $this->sma->formatDecimal(0),
                'grand_total' => $this->sma->formatDecimal($total - $total_discount),
                'total_items' => $this->input->post('quantity'),
                'sale_status' => 'emrs',
                'payment_status' => 'paid',
                'payment_term' => 0,
                'pos' => 1,
                'paid' => 0,
                'created_by' => $this->session->userdata('user_id'),
                'sales_executive_id' => $this->session->userdata('user_id'),
                'invoice_discount_reason' => '',
                'register_id' => $this->session->userdata('register_id'),
                'pan_number' => !empty($this->input->post('pan_number_hidden')) ? $this->input->post('pan_number_hidden') : '',
                'return_flg' => 5,
                'return_time' => $this->pos_settings->return_sales_perioed
            );
                
            $products = array(
                'product_id' => $this->input->post('product_id'),
                'product_code' => $this->input->post('product_code'),
                'product_name' => $this->input->post('item_name'),
                'product_type' => $this->input->post('product_type'),
                'option_id' => $this->input->post('product_option'),
                'net_unit_price' => $this->input->post('net_unit_cost')*$quantity,
                'unit_price' => $this->input->post('unit_price'),
                'quantity' => $this->input->post('quantity'),
                'warehouse_id' => $this->session->userdata('warehouse_id'),
                //'item_tax' => $pr_item_tax,
                'tax_rate_id' => $this->input->post('tax_rate_id'),
                'tax' => $this->sma->formatDecimal($total - $total_discount),
                'discount' => $this->input->post('real_unit_price')*$quantity,
                'item_discount' => $this->input->post('real_unit_price'),
                'pdiscount_type' => 'emrs', 
                'subtotal' => $this->sma->formatDecimal(0),
                'serial_no' => $this->input->post('product_serial'),
                'real_unit_price' => $this->input->post('real_unit_price')*$quantity,
                'net_unit_cost' => $this->input->post('net_unit_cost')*$quantity,
                'item_tax' => $this->sma->formatDecimal($total - $total_discount)
            );
                
                /*$payment = array(
                    'date' => date('Y-m-d H:i:s'),
                    'reference_no' => $this->site->getReference('pay'),
                    'amount' => 0,
                    'paid_by' => 'N/A',
                    'cheque_no' => '',
                    'cc_no' => '',
                    'cc_holder' => '',
                    'cc_month' => '',
                    'cc_year' => '',
                    'cc_type' => '',
                    
                    'card_type' => '',
                    'created_by' => $this->session->userdata('user_id'),
                    'type' => 'foc',
                    'note' => '',
                    'pos_paid' => '',
                    'pos_balance' => '',
                    'cn_balance' => '',
                    'approval_no' => '',
                    'register_id' => $this->session->userdata('register_id'),
                );*/
                if ($this->db->insert('emrs', $data)) {

                    $sale_id = $this->db->insert_id();
                   // $this->site->updateReference('pos');
                    
                    $products['sale_id'] = $sale_id;
                    $this->db->insert('emrs_items', $products);
                    
                   /* $payment['sale_id'] = $sale_id;
                    $this->db->insert('payments', $payment);
                    $payment_id = $this->db->insert_id();*/
                  //  $this->site->updateReference('pay');
                    $cdata = array(
                        'sale_id' => $sale_id,
                        'datetime' => date('Y-m-d H:i:s'),                
                        'product_id' => $this->input->post('product_id'),
                        'product_code' => $this->input->post('product_code'),
                        'product_name' => $this->input->post('item_name'),
                        'warehouse_id' => $this->input->post('warehouse_id'),
                        'customer_name' => $this->input->post('customer_name'),
                        'mobile' => $this->input->post('mobile_no'),
                        'reference' => $this->input->post('reference'),
                        'quantity' => $this->input->post('quantity')                
                    );

                    $ar = $this->pos_model->UpdateACQty($cdata,2);
                    

                    if($sale_id > 0){
                        redirect("pos/index");
                    }
                }
                    
                $ar = $this->pos_model->UpdateACQty($data);
                //            if ($this->db->insert_id() > 0) {    
                //                echo json_encode(array('status'=>'success','sale_id'=>$sale_id));die;
                //            }else{
                //                echo json_encode(array('status'=>'failed'));die;
                //            }
            }else{

            }

    }
    
    function view_pdf($sale_id = NULL, $modal = NULL) {
        $this->load->model('sales_model');
        $this->sma->checkPermissions('index');
        if ($this->input->get('id')) {
            $sale_id = $this->input->get('id');
        }
        $this->load->helper('text');
        $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
        $this->data['message'] = $this->session->flashdata('message');
        $this->data['rows'] = $this->pos_model->getAllInvoiceItems($sale_id);
        foreach($this->data['rows'] as $k => $v){
            if($v->return_id != 0){
                $return_date = $this->sales_model->getReturnByID($v->return_id)->date;
                $this->data['rows'][$k]->return_date = $return_date;
            }
            
        }


        $inv = $this->pos_model->getInvoiceByID($sale_id);
        if($inv->sale_status === 'foc'){
            $this->data['foc_details'] = $this->pos_model->getCustomerServiceBySaleId($sale_id);
        }
        /*echo "<pre>";
        print_r($inv);
        exit;*/
        $biller_id = $inv->biller_id;
        $customer_id = $inv->customer_id;
        $this->data['allbillers'] = $this->pos_model->getAllBillers();
        $this->data['biller'] = $this->pos_model->getCompanyByID($biller_id);
        $this->data['customer'] = $this->pos_model->getCompanyByID($customer_id);
        $this->data['payments'] = $this->pos_model->getInvoicePayments($sale_id);
        foreach($this->data['payments'] as $p=>$payment){
            if ($payment->paid_by == 'credit_voucher' && $payment->pos_paid) {
                if($payment->cn_balance > 0){
                    $card_details = $this->site->getGiftCardByNO($payment->cc_no);
                    $this->data['payments'][$p]->credit_note_id = $card_details->id;
                    $this->data['payments'][$p]->balance = $card_details->balance;
                }            
            }
        }
        $this->data['pos'] = $this->pos_model->getSetting();
        $this->data['barcode'] = $this->barcode($inv->reference_no, 'code39', 30);
        $this->data['inv'] = $inv;
      
        $this->data['sid'] = $sale_id;
        $this->data['modal'] = $modal;
        $this->data['page_title'] = $this->lang->line("invoice");
        $this->data['discount_type'] = $this->pos_model->discountType();
        $this->load->view($this->theme . 'pos/view', $this->data);
    }
    
    function dummy_pdf() {
        ini_set('display_errors', 'On');
error_reporting(-1);
define('MP_DB_DEBUG', true);
        $html = $this->load->view($this->theme . 'pos/dummy_pdf', $this->data, TRUE);//exit;
        echo $html; die;
        $this->sma->generate_pdf($html, $name);
    }
}
