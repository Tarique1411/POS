<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends MY_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper("url");
        $this->load->model("Sales_model");
        $this->load->library("pagination");
        $this->load->model("msync_model");
        //added by vikas singh
        $this->load->model("site");
        //$this->load->library("multipledb");


        if (!$this->loggedIn) {
            $this->session->set_userdata('requested_page', $this->uri->uri_string());
            redirect('login');
        }
        $this->load->library('form_validation');
        $this->load->model('db_model');
        //$this->session->set_userdata('last_activity', now());
    }

    public function index() {
        //$a = $this->msync_model->Reverse_sync_status(); die;

        if ($this->Settings->version == '2.3') {
            $this->session->set_flashdata('warning', 'Please complete your update by synchronizing your database.');
            redirect('sync');
        }
        $this->data['pos_settings'] = $this->site->get_pos_setting();
        $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
        $this->data['sales'] = $this->db_model->getLatestSales();
        $this->data['return_reasons'] = $this->db_model->getSalesReturnReasons();
        $this->data['quotes'] = $this->db_model->getLastestQuotes();
        $this->data['purchases'] = $this->db_model->getLatestPurchases();
        $this->data['transfers'] = $this->db_model->getLatestTransfers();
        $this->data['customers'] = $this->db_model->getLatestCustomers();
        $this->data['suppliers'] = $this->db_model->getLatestSuppliers();
        $this->data['chatData'] = $this->db_model->getChartData();
        $this->data['stock'] = $this->db_model->getStockValue();
        $this->data['bs'] = $this->db_model->getBestSeller();
        $lmsdate = date('Y-m-d', strtotime('first day of last month')) . ' 00:00:00';
        $lmedate = date('Y-m-d', strtotime('last day of last month')) . ' 23:59:59';
        $this->data['lmbs'] = $this->db_model->getBestSeller($lmsdate, $lmedate);
        $bc = array(array('link' => '#', 'page' => lang('dashboard')));
        $meta = array('page_title' => lang('dashboard'), 'bc' => $bc);
        // print_r($this->data); die;
//        $warehouse_id = $this->session->all_userdata()['warehouse_id'];
//        $biller_id = $this->session->all_userdata()['biller_id'];
//        echo $warehouse_id."<br>".$biller_id; die();
        $this->page_construct('dashboard', $meta, $this->data);
    }

    function promotions() {
        $this->load->view($this->theme . 'promotions', $this->data);
    }

    function image_upload() {
        if (DEMO) {
            $error = array('error' => $this->lang->line('disabled_in_demo'));
            echo json_encode($error);
            exit;
        }
        $this->security->csrf_verify();
        if (isset($_FILES['file'])) {
            $this->load->library('upload');
            $config['upload_path'] = 'assets/uploads/';
            $config['allowed_types'] = 'gif|jpg|png|jpeg';
            $config['max_size'] = '500';
            $config['max_width'] = $this->Settings->iwidth;
            $config['max_height'] = $this->Settings->iheight;
            $config['encrypt_name'] = TRUE;
            $config['overwrite'] = FALSE;
            $config['max_filename'] = 25;
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('file')) {
                $error = $this->upload->display_errors();
                $error = array('error' => $error);
                echo json_encode($error);
                exit;
            }
            $photo = $this->upload->file_name;
            $array = array(
                'filelink' => base_url() . 'assets/uploads/images/' . $photo
            );
            echo stripslashes(json_encode($array));
            exit;
        } else {
            $error = array('error' => 'No file selected to upload!');
            echo json_encode($error);
            exit;
        }
    }

    function set_data($ud, $value) {
        $this->session->set_userdata($ud, $value);
        echo true;
    }

    function hideNotification($id = NULL) {
        $this->session->set_userdata('hidden' . $id, 1);
        echo true;
    }

    function language($lang = false) {
        if ($this->input->get('lang')) {
            $lang = $this->input->get('lang');
        }
        //$this->load->helper('cookie');
        $folder = 'sma/language/';
        $languagefiles = scandir($folder);
        if (in_array($lang, $languagefiles)) {
            $cookie = array(
                'name' => 'language',
                'value' => $lang,
                'expire' => '31536000',
                'prefix' => 'sma_',
                'secure' => false
            );

            $this->input->set_cookie($cookie);
        }
        redirect($_SERVER["HTTP_REFERER"]);
    }

    function download($file) {
        $this->load->helper('download');
        force_download('./files/' . $file, NULL);
        exit();
    }

    /**
     * Author  Ankit
     * Detail : For find out today sales
     * Date 22-04-2016
     */
    function todaysales() {
        $biller_id = $this->session->all_userdata()['biller_id'];
        //$warehouse_id = $this->session->all_userdata()['warehouse_id'];

        $user = $this->site->getUser();
        $warehouse_id = $user->warehouse_id;
        //$d=mktime(11, 10, 54, 3, 14, 2016);
        //$dt= date("Y-m-d", $d);
        $dt1 = date("Y-m-d");
        $this->load->library('datatables');

        if ($this->input->post('payment_type')) {
            $payment_type = $this->input->post('payment_type');
        } else {
            $payment_type = NULL;
        }
        // $payment_type;

        $this->datatables
                ->select($this->db->dbprefix('sales') . ".id as id, DATE_FORMAT("
                        . "" . $this->db->dbprefix('sales') . ".date,'%d-%m-%Y') as date, "
                        . "" . $this->db->dbprefix('sales') . ".reference_no, "
//                        . "(" . $this->db->dbprefix('sales') . ".grand_total + " . $this->db->dbprefix('sales') . ".total_discount) as 'mrp', "
                        . "mrp, "
                        . " GROUP_CONCAT( DISTINCT "
                        // . " CASE WHEN ".$this->db->dbprefix('payments') .".paid_by = 'credit_voucher' THEN 'Credit Note'"
                        . " CASE WHEN " . $this->db->dbprefix('payments') . ".paid_by = 'credit_voucher' and " . $this->db->dbprefix('payments') . ".return_id IS NOT NULL THEN NULL "
                        . "WHEN " . $this->db->dbprefix('payments') . ".paid_by = 'credit_voucher' and " . $this->db->dbprefix('payments') . ".return_id IS NULL THEN 'Credit Note' "
                        . " WHEN " . $this->db->dbprefix('payments') . ".paid_by = 'CC' THEN 'Credit/Debit Card' "
                        . " WHEN " . $this->db->dbprefix('payments') . ".paid_by = 'cash' THEN 'Cash'  "
                        . " ELSE " . $this->db->dbprefix('payments') . ".paid_by END) as paid_by, "
                        . " CASE WHEN " . $this->db->dbprefix('sales') . ".return_flg = '0' THEN 'Paid'"
                        . " WHEN " . $this->db->dbprefix('sales') . ".return_flg = '1' THEN 'Returned' "
                        . " WHEN " . $this->db->dbprefix('sales') . ".return_flg = '2' THEN 'Partial Return'  "
                        . " WHEN " . $this->db->dbprefix('sales') . ".return_flg = '5' THEN 'FOC'  "
                        . " ELSE " . $this->db->dbprefix('sales') . ".return_flg END as return_flg, "
                        . " product_discount as dis , "
                        . "total as 'basic', (total_tax/2) as cgst,(total_tax/2) as sgst, paid")
                ->from("sales")
                ->join('sale_items', 'sale_items.sale_id=sales.id', 'left')
                ->join('payments', 'payments.sale_id=sales.id', 'left')
                ->join('(SELECT sma_sale_items.sale_id as sid, SUM(sma_sale_items.real_unit_price) as mrp FROM `sma_sale_items` GROUP by sale_id) as a ', 'sid=sales.id', 'inner')
                ->where('DATE(' . $this->db->dbprefix('sales') . '.date)', $dt1)
//                ->where('DATE(' . $this->db->dbprefix('sales') . '.date)', $dt1)
                //->where('sales.return_flg', 0)
                //->where($this->db->dbprefix('sales') .'.warehouse_id', $warehouse_id)
                ->group_by('sales.id');

        if ($biller_id != NULL) {
            $this->db->where('sales.biller_id', $biller_id);
        }
        if ($payment_type) {
            //$this->db->where('payments.paid_by', $payment_type);
            // added by vikas singh
            if ($payment_type == 'cash') {
                $payment_type = 'Cash';
            }
            if ($payment_type == 'CC') {
                $payment_type = 'Credit/Debit Card';
            }
            if ($payment_type == 'credit_voucher') {
                $payment_type = 'Credit Note';
            }

            if ($payment_type != 'All') {
                $where = "paid_by like '%" . $payment_type . "%'";
                $this->db->having($where);
            }
        }
        echo $this->datatables->generate();
    }

    /**
     * Author  Ankit
     * Detail : For find out current month sales
     * Date 22-04-2016
     */
    function currentmonth() {
        //$user = $this->site->getUser();
        //$warehouse_id = $user->warehouse_id;
        $warehouse_id = $this->session->all_userdata()['warehouse_id'];
        $biller_id = $this->session->all_userdata()['biller_id'];
        $m = date("m");
        $y = date("Y");
        $this->load->library('datatables');

        if ($this->input->post('payment_type')) {
            $payment_type = $this->input->post('payment_type');
        } else {
            $payment_type = NULL;
        }
        //echo $payment_type;die;

        $this->datatables
                ->select($this->db->dbprefix('sales') . ".id as id, DATE_FORMAT(" . $this->db->dbprefix('sales') . ".date,'%d-%m-%Y') as date, "
                        . $this->db->dbprefix('sales') . ".reference_no, "
                        //. "(" . $this->db->dbprefix('sales') . ".total + " . $this->db->dbprefix('sales') . ".total_discount) as 'mrp', "
                        . "mrp, "
                        . " GROUP_CONCAT( DISTINCT "
                        . " CASE WHEN " . $this->db->dbprefix('payments') . ".paid_by = 'credit_voucher' and " . $this->db->dbprefix('payments') . ".return_id IS NOT NULL THEN NULL "
                        . "WHEN " . $this->db->dbprefix('payments') . ".paid_by = 'credit_voucher' and " . $this->db->dbprefix('payments') . ".return_id IS NULL THEN 'Credit Note' "
                        . " WHEN " . $this->db->dbprefix('payments') . ".paid_by = 'CC' THEN 'Credit/Debit Card' "
                        . " WHEN " . $this->db->dbprefix('payments') . ".paid_by = 'cash' THEN 'Cash'  "
                        . " ELSE " . $this->db->dbprefix('payments') . ".paid_by END) as paid_by, "
                        . " CASE WHEN " . $this->db->dbprefix('sales') . ".return_flg = '0' THEN 'Paid'"
                        . " WHEN " . $this->db->dbprefix('sales') . ".return_flg = '1' THEN 'Returned' "
                        . " WHEN " . $this->db->dbprefix('sales') . ".return_flg = '2' THEN 'Partial Return'"
                        . " WHEN " . $this->db->dbprefix('sales') . ".return_flg = '5' THEN 'FOC'"
                        . " ELSE " . $this->db->dbprefix('sales') . ".return_flg END as return_flg, "
                        . " product_discount as dis , "
                        . $this->db->dbprefix('sales') . ".total as 'basic', 
                        (total_tax/2) as cgst,
                        (total_tax/2) as sgst,"
                        . $this->db->dbprefix('sales') . ".paid")
                ->from("sales")
                ->join('sale_items', 'sale_items.sale_id=sales.id', 'left')
                ->join('payments', 'payments.sale_id=sales.id', 'left')
                ->join('(SELECT sma_sale_items.sale_id as sid, SUM(sma_sale_items.real_unit_price) as mrp FROM `sma_sale_items` GROUP by sale_id) as a ', 'sid=sales.id', 'inner')
                //->where($this->db->dbprefix('sales') .'.warehouse_id', $warehouse_id)
                ->where('MONTH(' . $this->db->dbprefix('sales') . '.date)', $m)
                ->where('YEAR(' . $this->db->dbprefix('sales') . '.date)', $y);
        //->where('sales.return_flg', 0);
        //$this->db->group_by('payments.paid_by');
        $this->db->group_by('sales.id');

        if ($biller_id != NULL) {
            $this->db->where('sales.biller_id', $biller_id);
        }
        if ($payment_type) {
            // $this->db->where("payments.paid_by",$payment_type);
            // added by vikas singh
            if ($payment_type == 'cash') {
                $payment_type = 'Cash';
            }
            if ($payment_type == 'CC') {
                $payment_type = 'Credit/Debit Card';
            }
            if ($payment_type == 'credit_voucher') {
                $payment_type = 'Credit Note';
            }

            if ($payment_type != 'All') {
                $where = "paid_by like '%" . $payment_type . "%'";
                $this->db->having($where);
            }
        }
        echo $this->datatables->generate();
    }

    /**
     * Author  Ankit
     * Detail : For find out last month sales
     * Date 22-04-2016
     */
    function lastmonth() {

        $biller_id = $this->session->all_userdata()['biller_id'];
        $warehouse_id = $this->session->all_userdata()['warehouse_id'];
        //$user = $this->site->getUser();
        //$warehouse_id = $user->warehouse_id;
        $m2 = date("Y-m-d", strtotime("first day of last month"));
        $d = new DateTime('first day of this month');
        $m1 = $d->format('Y-m-d');
        $this->load->library('datatables');

        if ($this->input->post('payment_type')) {
            $payment_type = $this->input->post('payment_type');
        } else {
            $payment_type = NULL;
        }

        $this->datatables
                ->select($this->db->dbprefix('sales') . ".id as id, DATE_FORMAT(" . $this->db->dbprefix('sales') . ".date,'%d-%m-%Y') as date, "
                        . $this->db->dbprefix('sales') . ".reference_no, "
                        . "(" . $this->db->dbprefix('sales') . ".grand_total + " . $this->db->dbprefix('sales') . ".total_discount) as 'mrp', "
                        . " GROUP_CONCAT( DISTINCT "
                        // . " CASE WHEN ".$this->db->dbprefix('payments') .".paid_by = 'credit_voucher' THEN 'Credit Note'"
                        . " CASE WHEN " . $this->db->dbprefix('payments') . ".paid_by = 'credit_voucher' and " . $this->db->dbprefix('payments') . ".return_id IS NOT NULL THEN NULL "
                        . "WHEN " . $this->db->dbprefix('payments') . ".paid_by = 'credit_voucher' and " . $this->db->dbprefix('payments') . ".return_id IS NULL THEN 'Credit Note'"
                        . " WHEN " . $this->db->dbprefix('payments') . ".paid_by = 'CC' THEN 'Credit/Debit Card' "
                        . " WHEN " . $this->db->dbprefix('payments') . ".paid_by = 'cash' THEN 'Cash'  "
                        . " ELSE " . $this->db->dbprefix('payments') . ".paid_by END) as paid_by, "
                        . " CASE WHEN " . $this->db->dbprefix('sales') . ".return_flg = '0' THEN 'Paid'"
                        . " WHEN " . $this->db->dbprefix('sales') . ".return_flg = '1' THEN 'Returned' "
                        . " WHEN " . $this->db->dbprefix('sales') . ".return_flg = '2' THEN 'Partial Return'  "
                        . " WHEN " . $this->db->dbprefix('sales') . ".return_flg = '5' THEN 'FOC'"
                        . " ELSE " . $this->db->dbprefix('sales') . ".return_flg END as pay_status, "
                        . " product_discount as dis , "
                        . "total as 'basic', 
                        (total_tax/2) as cgst,
                        (total_tax/2) as sgst,
                         paid")
                ->from("sales")
                ->join('sale_items', 'sale_items.sale_id=sales.id', 'left')
                ->join('payments', 'payments.sale_id=sales.id', 'left')
                //->where($this->db->dbprefix('sales').'.warehouse_id', $warehouse_id)
                ->where($this->db->dbprefix('sales') . '.date BETWEEN "' . date('Y-m-d', strtotime($m2)) . '" '
                        . 'and "' . date('Y-m-d', strtotime($m1)) . '"')
                //->where('sales.return_flg', 0)
                ->group_by('sales.id');

        if ($biller_id != NULL) {
            $this->db->where('sales.biller_id', $biller_id);
        }
        if ($payment_type) {
            //$this->db->where("payments.paid_by", $payment_type);
            // added by vikas singh
            if ($payment_type == 'cash') {
                $payment_type = 'Cash';
            }
            if ($payment_type == 'CC') {
                $payment_type = 'Credit/Debit Card';
            }
            if ($payment_type == 'credit_voucher') {
                $payment_type = 'Credit Note';
            }

            if ($payment_type != 'All') {
                $where = "paid_by like '%" . $payment_type . "%'";
                $this->db->having($where);
            }
        }

        echo $this->datatables->generate();
    }

    /**
     * Author  Ankit
     * Detail : For find out the period sale between two date input by user
     * Date 22-04-2016
     */
    function getPeriodSales() {

        $ar = array();
        //echo $this->session->all_userdata()['warehouse_id']; die;
        $warehouse_id = $this->session->all_userdata()['warehouse_id'];
        $biller_id = $this->session->all_userdata()['biller_id'];
        $user = $this->site->getUser();
        //$warehouse_id = $user->warehouse_id;
        $str = $this->input->post('date');
        $ar = explode("|", $str);

        $s = $ar[0];
        $e = $ar[1];
        // $date = str_replace('/', '-', $s);
        $s1 = date('Y-m-d', strtotime($s));
        //       $date1 = str_replace('/', '-', $e);
        $e1 = date('Y-m-d', strtotime($e));

        if ($ar[2] != '') {
            $payment_type = $ar[2];
        } else {
            $payment_type = null;
        }
        $this->load->library('datatables');

        $this->datatables
                ->select($this->db->dbprefix('sales') . ".id as id, DATE_FORMAT("
                        . $this->db->dbprefix('sales') . ".date,'%d-%m-%Y') as date, " . $this->db->dbprefix('sales') . ".reference_no, "
                        //. "(" . $this->db->dbprefix('sales') . ".grand_total + " . $this->db->dbprefix('sales') . ".total_discount) as 'mrp', "
                        . "mrp, "
                        . " GROUP_CONCAT( DISTINCT "

                        // . " CASE WHEN ".$this->db->dbprefix('payments') .".paid_by = 'credit_voucher' THEN 'Credit Note'"
                        . " CASE WHEN " . $this->db->dbprefix('payments') . ".paid_by = 'credit_voucher' and " . $this->db->dbprefix('payments') . ".return_id IS NOT NULL THEN NULL "
                        . "WHEN " . $this->db->dbprefix('payments') . ".paid_by = 'credit_voucher' and " . $this->db->dbprefix('payments') . ".return_id IS NULL THEN 'Credit Note'"
                        . " WHEN " . $this->db->dbprefix('payments') . ".paid_by = 'CC' THEN 'Credit/Debit Card' "
                        . " WHEN " . $this->db->dbprefix('payments') . ".paid_by = 'cash' THEN 'Cash'  "
                        . " ELSE " . $this->db->dbprefix('payments') . ".paid_by END) as paid_by, "
                        . " CASE WHEN " . $this->db->dbprefix('sales') . ".return_flg = '0' THEN 'Paid'"
                        . " WHEN " . $this->db->dbprefix('sales') . ".return_flg = '1' THEN 'Returned' "
                        . " WHEN " . $this->db->dbprefix('sales') . ".return_flg = '2' THEN 'Partial Return'  "
                        . " WHEN " . $this->db->dbprefix('sales') . ".return_flg = '5' THEN 'FOC'"
                        . " ELSE " . $this->db->dbprefix('sales') . ".return_flg END as return_flg, "
                        . " product_discount as dis , "
                        . " total as 'basic', 
                     (total_tax/2) as cgst,
                    (total_tax/2) as sgst,
                     paid")
                ->from("sales")
                ->join('sale_items', 'sale_items.sale_id=sales.id', 'left')
                ->join('payments', 'payments.sale_id=sales.id', 'left')
                ->join('(SELECT sma_sale_items.sale_id as sid, SUM(sma_sale_items.real_unit_price) as mrp FROM `sma_sale_items` GROUP by sale_id) as a ', 'sid=sales.id', 'inner')

                // ->where('sales.warehouse_id', $warehouse_id)
                //->where($this->db->dbprefix('sales') . '.date BETWEEN "'. date('Y-m-d', strtotime($s1)). '" '
                //            . 'and "'. date('Y-m-d', strtotime($e1)).'"')
                // ->where('date BETWEEN "'. date('Y-m-d', strtotime($s1)). '" and "'. date('Y-m-d', strtotime($e1)).'"')
                // added by vikas singh
                //->where($this->db->dbprefix('sales') . '.date BETWEEN "'. $s. '" '. 'and "'. $e.'"')
                ->where('CAST(sma_sales.date AS Date) >="' . $s . '" AND CAST(sma_sales.date AS Date) <="' . $e . '" ')
                //->where('sales.return_flg', '0')    
                ->group_by('sales.id');

        if ($biller_id != NULL) {
            $this->db->where('biller_id', $biller_id);
        }
        if ($payment_type != NULL) {
            //$this->db->where('payments.paid_by', $payment_type);
            // added by vikas singh
            if ($payment_type == 'cash') {
                $payment_type = 'Cash';
            }
            if ($payment_type == 'CC') {
                $payment_type = 'Credit/Debit Card';
            }
            if ($payment_type == 'credit_voucher') {
                $payment_type = 'Credit Note';
            }

            if ($payment_type != 'All') {
                $where = "paid_by like '%" . $payment_type . "%'";
                $this->db->having($where);
            }
        }

        echo $this->datatables->generate();
    }

    /**
     * Author  Ankit
     * Detail : For find out YTD sale (calender year) take input from user
     * Date 25-04-2016
     */
    function getytdSales() {

        $biller_id = $this->session->all_userdata()['biller_id'];
        $warehouse_id = $this->session->all_userdata()['warehouse_id'];
        //$user = $this->site->getUser();
        $str = $this->input->post('year');

        $this->load->library('datatables');

        $this->datatables
                ->select($this->db->dbprefix('sales') . ".id as id,
                     DATE_FORMAT(" . $this->db->dbprefix('sales') . ".date,'%d-%m-%Y') as date, 
                     " . $this->db->dbprefix('sales') . ".reference_no, 
                     " //. "(" . $this->db->dbprefix('sales') . ".grand_total + " . $this->db->dbprefix('sales') . ".total_discount) as 'mrp', "
                        //. " GROUP_CONCAT( DISTINCT "
                        . "mrp, "
                        . " CASE WHEN " . $this->db->dbprefix('sales') . ".return_flg = '0' THEN 'Paid'"
                        . " WHEN " . $this->db->dbprefix('sales') . ".return_flg = '1' THEN 'Returned' "
                        . " WHEN " . $this->db->dbprefix('sales') . ".return_flg = '2' THEN 'Partial Return' "
                        . " WHEN " . $this->db->dbprefix('sales') . ".return_flg = '5' THEN 'FOC'"
                        . " ELSE " . $this->db->dbprefix('sales') . ".return_flg END as sales_return, "
                        . " product_discount as dis , "
                        . " total as 'basic', 
                    (total_tax/2) as cgst,
                    (total_tax/2) as sgst,
                     paid")
                ->from("sales")
                ->join('sale_items', 'sale_items.sale_id=sales.id', 'left')
                ->join('payments', 'payments.sale_id=sales.id', 'left')
                ->join('(SELECT sma_sale_items.sale_id as sid, SUM(sma_sale_items.real_unit_price) as mrp FROM `sma_sale_items` GROUP by sale_id) as a ', 'sid=sales.id', 'inner')
                ->where('YEAR(' . $this->db->dbprefix('sales') . '.date)', $str)
                //->where('sales.return_flg', 0)
                ->group_by('sales.id');

        if ($biller_id != NULL) {
            $this->db->where('sales.biller_id', $biller_id);
        }
        echo $this->datatables->generate();
    }

    /**
     * Author  Ankit
     * Detail : For find out return sales
     * Date 25-04-2016
     */
    function getSaleRreturn() {
        //print_r($_POST); 
        $ar = array();
        $biller_id = $this->session->all_userdata()['biller_id'];
        $warehouse_id = $this->session->all_userdata()['warehouse_id'];
        $user = $this->site->getUser();
        //$warehouse_id = $user->warehouse_id;
        $str = $this->input->post('date');
        $ar = explode("|", $str);
        //echo "<pre>";print_r($ar);die;
        $s = $ar[0];
        $e = $ar[1];
        //$date = str_replace('/', '-', $s);
        if ($ar[2] != '') {
            $payment_type = $ar[2];
        } else {
            $payment_type = null;
        }
        $s1 = date('Y-m-d', strtotime($s));
        $e1 = date('Y-m-d', strtotime($e));
        $this->load->library('datatables');

        $this->datatables
                ->select($this->db->dbprefix('return_sales') . ".id as id, DATE_FORMAT("
                        . $this->db->dbprefix('return_sales') . ".date, '%d-%m-%Y') as date, "
                        . $this->db->dbprefix('return_sales') . ".sales_reference_no, "
//                        . "(" . $this->db->dbprefix('sales') . ".grand_total + " . $this->db->dbprefix('sales') . ".total_discount) as 'mrp',"
                        . "mrp, "
                        . " CASE WHEN sma_sales.return_flg = 1 THEN 'Returned' "
                        . " WHEN sma_sales.return_flg = 2 THEN 'Partial Return' "
                        . " WHEN " . $this->db->dbprefix('sales') . ".return_flg = '5' THEN 'FOC'"
                        . " ELSE sma_sales.return_flg END as ab, "
                        . $this->db->dbprefix('sales') . ".product_discount as dis , "
                        . $this->db->dbprefix('return_sales') . ".total as 'basic',
                         (sma_return_sales.total_tax)/2 as cgst,
                         (sma_return_sales.total_tax)/2 as sgst,ROUND("
                        . $this->db->dbprefix('return_sales') . ".grand_total)")
                ->from("return_sales")
                ->join('sales', 'sales.id=return_sales.sale_id', 'inner')
                ->join('return_items', 'return_items.return_id=return_sales.id', 'inner')
                ->join('payments', 'payments.sale_id=return_sales.sale_id', 'inner')
                ->join('(SELECT sma_sale_items.sale_id as sid, SUM(sma_sale_items.real_unit_price) as mrp FROM `sma_sale_items` GROUP by sale_id) as a ', 'sid=sales.id', 'inner')
                ->where('sma_sales.return_flg !=', 0)
                ->where('CAST(sma_return_sales.date AS Date) >="' . $s1 . '" AND CAST(sma_return_sales.date AS Date) <="' . $e1 . '" ');
        if (($ar[3] != '') || ($ar[3] != NULL)) {
            $this->db->where('return_sales.return_reason', $ar[3]);
        }
        $this->db->group_by('return_sales.id');


//        if($biller_id!=NULL){urn
//            $this->db->where('return_sales.biller_id', $biller_id);
//        }
//        if($payment_type!=NULL){
//            $this->db->where('payments.paid_by', $payment_type);
//        }

        echo $this->datatables->generate();
    }

    /**
     * Author  Ankit
     * Detail : For find out sales discount
     * Date 26-04-2016
     */
    function getSaleDiscount() {
        //$user = $this->site->getUser();
        //$warehouse_id = $user->warehouse_id;
        $warehouse_id = $this->session->all_userdata()['warehouse_id'];
        $biller_id = $this->session->all_userdata()['biller_id'];
        $this->load->library('datatables');

        if ($this->input->post('discount_type')) {
            $discount_type = $this->input->post('discount_type');
            $data = explode('|', $discount_type);
        } else {
            $discount_type = NULL;
        }
        //echo "<pre>";print_r($data);
        $s4 = date('Y-m-d', strtotime($data[0]));
        //$date1 = str_replace('/', '-', $e);
        $e4 = date('Y-m-d', strtotime($data[1]));

        $this->datatables
                ->select($this->db->dbprefix('sales') . ".id as id, DATE_FORMAT(" . $this->db->dbprefix('sales') . ".date,'%d-%m-%Y') as date, "
                        . $this->db->dbprefix('sales') . ".reference_no, "
                        . "(" . $this->db->dbprefix('sales') . ".grand_total + " . $this->db->dbprefix('sales') . ".total_discount) as 'mrp', "
                        . " GROUP_CONCAT( DISTINCT "
                        // . " CASE WHEN ".$this->db->dbprefix('payments') .".paid_by = 'credit_voucher' THEN 'Credit Note'"
                        . " CASE WHEN " . $this->db->dbprefix('payments') . ".paid_by = 'credit_voucher' and " . $this->db->dbprefix('payments') . ".return_id IS NOT NULL THEN NULL "
                        . "WHEN " . $this->db->dbprefix('payments') . ".paid_by = 'credit_voucher' and " . $this->db->dbprefix('payments') . ".return_id IS NULL THEN 'Credit Note'"
                        . " WHEN " . $this->db->dbprefix('payments') . ".paid_by = 'CC' THEN 'Credit/Debit Card' "
                        . " WHEN " . $this->db->dbprefix('payments') . ".paid_by = 'cash' THEN 'Cash'  "
                        . " ELSE " . $this->db->dbprefix('payments') . ".paid_by END) as paid_by, "
                        . " product_discount as dis , "
                        . " total as 'basic', 
                    (total_tax)/2 as cgst,
                    (total_tax)/2 as sgst,
                     paid")
                ->from("sales")
                ->join('sale_items', 'sale_items.sale_id=sales.id', 'left')
                ->join('payments', 'payments.sale_id=sales.id', 'left');
        /* ->select($this->db->dbprefix('sales') . " !=id as id, date, reference_no, sum(real_unit_price) as 'mrp', total_discount , (total_discount/unit_price)*100 as dis , total as 'basic', total_tax, grand_total")
          ->from("sales")
          ->join('sale_items', 'sale_items.sale_id=sales.id', 'left') */
        if (($data[2] != 'all')) {

            $this->db->where(array('total_discount >' => '0', 'sale_items.pdiscount_type' => $data[2], 'sale_items.discount >' => 0));
        } else {

            $this->db->where(array('total_discount >' => '0', 'sale_items.discount >' => 0, 'sale_status !=' => 'foc'));
        }
        $this->db->where('CAST(sma_sales.date as Date) >="' . $s4 . '" AND CAST(sma_sales.date as Date) <="' . $e4 . '" ');
        //->where('sales.return_flg', 0)
        $this->db->group_by('sales.id', 'sale_items.sale_id');

        if ($biller_id != NULL) {
            $this->db->where('sales.biller_id', $biller_id);
        }

        echo $this->datatables->generate();
    }

    // Add By Ankit For sync Data at inter store -----------------------
//    function POSImport()
//    {
//        if($this->msync_model->syncToPos())
//        {  
//            $this->session->set_flashdata('message', "Data Sync Intermediate to POS DB Successfully");
//            redirect('welcome');
//        }
//        
//       
// 
//    }
//    function intrmExport()
//    {
//        if($this->msync_model->syncToIntermediate())
//        {
//            $this->session->set_flashdata('message', "Data Sync POS DB To Intermediate Successfully");
//            redirect('welcome');
//        }
//       
// 
//    }
//    // Add By Ankit for empty pos DB
//    function emptyPOS()
//    {
//         if($this->msync_model->emptyPOS())
//         {
//             $this->session->set_flashdata('message', "POS Data Base Empty Successfully");
//             redirect('welcome');
//         }
//         $this->session->set_flashdata('error', "POS Data Base Not Empty, please contact administrator.");
//         redirect('welcome');
//        
//       
// 
//    }
//    
//    
// Add By Ankit For sync Data at inter store -----------------------

    function POSImport() {
        $getorg = $this->input->get('org_id');
        $sgetorg = $this->input->get('sorg_id');
        $org = base64_decode($sgetorg);
        if ($org != '?') {
            if (empty($sgetorg)) {
                $this->db->query("update sma_pos_settings SET default_org ='" . $org . "' WHERE default_org IS NULL OR default_org = '' ");
            }
            if ($this->msync_model->syncToPos($org)) {
                $this->session->set_flashdata('message', "Data Sync Intermediate to POS DB Successfully");
                redirect('welcome');
            }
        } else {

            $this->session->set_flashdata('message', "Choose Warehouse Location first");
            redirect('welcome');
        }
    }

    function intrmExport() {
        $getorg = $this->input->get('org_id');
        $sgetorg = $this->input->get('sorg_id');
        $org = base64_decode($getorg);

        if ($org != '?') {
            if (empty($sgetorg)) {
                $this->db->query("update sma_pos_settings SET default_org ='" . $org . "' WHERE default_org IS NULL OR default_org ='' ");
            }
            //$org = $this->input->post('org_id'); 
            //echo "hi...."die;
            if ($this->msync_model->syncToIntermediate($org)) {
                $this->session->set_flashdata('message', "Data Sync POS DB To Intermediate Successfully");
                redirect('welcome');
            } else {
                $this->session->set_flashdata('message', "Please Wait Currently Another Location Sync Data At Intermediate.. ");
                redirect('welcome');
            }
        } else {

            $this->session->set_flashdata('message', "Choose Warehouse Location first");
            redirect('welcome');
        }
    }

    // Add By Ankit for empty pos DB
    function emptyPOS() {
        //$org = $this->input->get('org_id');
        if ($this->msync_model->emptyPOS()) {
            $this->session->set_flashdata('message', "POS Data Base Empty Successfully");
            redirect('welcome');
        }
        $this->session->set_flashdata('error', "POS Data Base Not Empty, please contact administrator.");
        redirect('welcome');
    }

    function syncposorg() {
        //$org = $this->input->get('org_id');
        //die;
        $warehouselist = $this->msync_model->getwarehouselist();
        $this->data['warehouselist'] = $warehouselist;
        $this->page_construct('syscorg', '', $this->data);
        //$this->load->view($this->theme . 'syscorg', $this->data);
        /* foreach ($arrStates as $states) {
          $arrstates[$states->state_id] = $states->state_name;
          }

          echo json_encode(form_dropdown('state',array_filter($arrstates),'','class="form-control tip" id="state" style="width:100%;" required="required"'));
          exit;
         */
    }

}
