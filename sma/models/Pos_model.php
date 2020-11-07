<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Pos_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    function getSetting()
    {
        $q = $this->db->get('pos_settings');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function updateSetting($data)
    {		//echo "<pre>";print_r($data);die;
        $this->db->where('pos_id', '1');
        if ($this->db->update('pos_settings', $data)) {
            return true;
        }
        return false;
    }

    public function products_count($category_id, $subcategory_id = NULL)
    {
        $this->db->where('category_id', $category_id)->from('products');
        if ($subcategory_id) {
            $this->db->where('subcategory_id', $subcategory_id);
        }
        return $this->db->count_all_results();
    }

    public function fetch_products($category_id, $limit, $start, $subcategory_id = NULL)
    {
        $this->db->limit($limit, $start);
        $this->db->where('category_id', $category_id);
		//$this->db->where('track_quantity >', 0);
        if ($subcategory_id) {
            $this->db->where('subcategory_id', $subcategory_id);
        }
        $this->db->order_by("name", "asc");
        $query = $this->db->get("products");

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function registerData($user_id,$warehouse_id)
    {
        
        if (!$user_id) {
            $user_id = $this->session->userdata('user_id');
        }
        if (!$warehouse_id) {
            $warehouse_id = $this->session->userdata('warehouse_id');
        }
        //$sql = "SELECT * FROM `sma_pos_register` WHERE `status` = 'open' AND CAST(date AS DATE) = '".date('Y-m-d')."' AND `warehouse_id` = '".$warehouse_id."'";
        //$q = $this->db->query($sql);
        $q = $this->db->where(array('status'=>'open',
                'user_id'=>$user_id,
            //'CAST(date AS DATE)'=>date('Y-m-d'),
            'warehouse_id'=>$warehouse_id))->get('pos_register');
	//echo "<pre>";print_r($q->result_array());die;
        if ($q->num_rows() > 0) {	
            return $q->row();
        }
        return FALSE;
    }

    public function openRegister($data)
    {
        if ($this->db->insert('pos_register', $data)) {
            return true;
        }
        return FALSE;
    }

	/*
	*Altered by Ajay
	* on 19-04-2016
	* return all fields
	*/
	
    public function getOpenRegisters()
    {
//        $this->db->select('*');
//        $this->db->select("pos_register.id,CONCAT(" . $this->db->dbprefix('users') . 
//                ".first_name, ' ', " . $this->db->dbprefix('users') . 
//                ".last_name, ' - ', " . $this->db->dbprefix('users') . 
//                ".email) as user", FALSE)
//            ->join('users', 'users.id=pos_register.user_id', 'left');
        
       
        //$q = $this->db->get_where('pos_register', array('status' => 'open'));
//        if ($q->num_rows() > 0) {
//            foreach ($q->result() as $row) {
//                $data[] = $row;
//            }
//            return $data;
//        }
         $w = "select a.username,b.* from sma_pos_register b inner join sma_users a on (a.id = b.user_id) where b.status='open'";
         $q = $this->db->query($w);
         if($q->num_rows() > 0)
         {
            foreach ($q->result() as $row) {
                $data[] = $row;
            }
            return $data;
         }
            return FALSE;

    }
    /* Added By Chitra to force close register by User 
     * Start */
     public function getUserOpenRegisters($user_id_reg,$warehouse_id)
    {
        $this->db->select('*');
        $this->db->select("pos_register.id,CONCAT(" . $this->db->dbprefix('users') . 
                ".first_name, ' ', " . $this->db->dbprefix('users') . 
                ".last_name, ' - ', " . $this->db->dbprefix('users') . 
                ".email) as user", FALSE)
            ->join('users', 'users.id=pos_register.user_id', 'left');
        $q = $this->db->get_where('pos_register', 
                array('status' => 'open', 
                    'user_id' => $user_id_reg,
                    'pos_register.warehouse_id'=>$warehouse_id,
                    'date < ' => date("Y-m-d",strtotime("now"))
                    ));
        //echo "<pre>";print_r($q->result());die;
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;

    }
    /* End*/
    
    
    /*
	*Altered by Ankit
	* on 6-05-2016
	* find out total credit voucher amount sale at time of register closed
	*/
       public function totalCreditVoucherAmount($register_open_time, $user_id)
       {  
           $t=0;
           $this->db->select('sale_id,amount');
           $q = $this->db->get_where('payments', array('created_by' => $user_id,'paid_by'=>'credit_voucher','register_id'=> $_SESSION['register_id']));
          if ($q->num_rows() > 0) {
            foreach ($q->result() as $row) {
                $data[] = $row;
             }
            
             foreach($data as $k)
             {
                $t= $t+$k->amount;
             }
             return $t;
        }
        return FALSE;
           
       }
       
       /*
	*Altered by Ankit
	* on 6-05-2016
	* find out total credit voucher amount sale at time of register closed
	*/
       public function totalCreditCardAmount($registerid, $user_id)
       {
           $t=0;
           $this->db->select('sale_id,amount');
         //  $q = $this->db->get_where('payments', array('created_by' => $user_id, 'date(date)>='=> date('Y-m-d', strtotime($register_open_time)),'paid_by'=>'CC'));
           $q = $this->db->get_where('payments', array('created_by' => $user_id, 'register_id'=> $registerid ,'paid_by'=>'CC','card_type'=>'DC'));
          if ($q->num_rows() > 0) {
            foreach ($q->result() as $row) {
                $data[] = $row;
             }
            
             foreach($data as $k)
             {
                $t= $t+$k->amount;
             }
             return $t;
        }
        return FALSE;
           
       }
       
        public function totalCreditCardAmount1($registerid, $user_id)
        {
            $t=0;
            $this->db->select('sale_id,amount');
         //  $q = $this->db->get_where('payments', array('created_by' => $user_id, 'date(date)>='=> date('Y-m-d', strtotime($register_open_time)),'paid_by'=>'CC'));
            $q = $this->db->get_where('payments', array('created_by' => $user_id, 'register_id'=> $registerid ,'paid_by'=>'CC','card_type'=>'CC'));
          if ($q->num_rows() > 0) {
            foreach ($q->result() as $row) {
                $data[] = $row;
             }
            
             foreach($data as $k)
             {
                $t= $t+$k->amount;
             }
             return $t;
        }
        return FALSE;
           
       }   

    public function closeRegister($rid, $user_id,$wid,$data)
    {
        
        if (!$rid) {
            $rid = $this->session->userdata('register_id');
        }
        if (!$user_id) {
            $user_id = $this->session->userdata('user_id');
        }
        
        if (!$wid) {
            $warehouse_id = $this->session->userdata('warehouse_id');
        }else{
            $warehouse_id = $wid;
        }
        if ($data['transfer_opened_bills'] == -1) {
            $this->db->delete('suspended_bills', array('created_by' => $user_id));
        } elseif ($data['transfer_opened_bills'] != 0) {
            $this->db->update('suspended_bills', array('created_by' => $data['transfer_opened_bills']), array('created_by' => $user_id));
        }
	
        if ($this->db->update('pos_register', $data, array('id' => $rid, 'warehouse_id' => $warehouse_id))) {
			
            return true;
        }
        return FALSE;
    }

    public function getUsers()
    {
        $q = $this->db->get_where('users', array('company_id' => NULL));
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

    public function getProductsByCode($code)
    {
        $this->db->like('code', $code, 'both')->order_by("code");
        $q = $this->db->get('products');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
    }

    public function getWHProduct($code, $warehouse_id)
    {
        $this->db->select('products.id, code, name, type, warehouses_products.quantity,'
                . 'warehouses_products.warehouse_id,warehouses_products.id as product_warehouse_id,'
                . 'price,max_discount,tax_rate, cost, tax_method, unit')
            ->join('warehouses_products', 'warehouses_products.product_id=products.id', 'left')
            ->group_by(array('products.code','products.price'))->order_by("id", "asc");
          //  ->where(array('code' => $code, "products.quantity > ",0));
        $q = $this->db->get("products");
        if ($q->num_rows() > 0) {
            return $q->row();
        }

        return FALSE;
    }

    public function getProductOptions($product_id, $warehouse_id)
    {
        $this->db->select('product_variants.id as id, product_variants.name as name, product_variants.price as price, product_variants.quantity as total_quantity, warehouses_products_variants.quantity as quantity')
            ->join('warehouses_products_variants', 'warehouses_products_variants.option_id=product_variants.id', 'left')
            //->join('warehouses', 'warehouses.id=product_variants.warehouse_id', 'left')
            ->where('product_variants.product_id', $product_id)
            ->where('warehouses_products_variants.warehouse_id', $warehouse_id)
            ->group_by('product_variants.id');
            if(! $this->Settings->overselling) {
                $this->db->where('warehouses_products_variants.quantity >', 0);
            }
        $q = $this->db->get('product_variants');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }
	// add by Ajay @ 10 may
	
	
	public function discountType(){
		
		$this->db->select('discount_type');
		$q = $this->db->get_where('pos_settings', array('pos_id'=>'1'),1);
		if($q->num_rows()>0){
			foreach($q->result() as $row){
				$data[] = $row;
			}
			return $data;
		}
		return false;
	}

    public function getProductComboItems($pid, $warehouse_id)
    {
        $this->db->select('products.id as id, combo_items.item_code as code, combo_items.quantity as qty, products.name as name, products.type as type, warehouses_products.quantity as quantity')
            ->join('products', 'products.code=combo_items.item_code', 'left')
            ->join('warehouses_products', 'warehouses_products.product_id=products.id', 'left')
            ->where('warehouses_products.warehouse_id', $warehouse_id)
            ->group_by('combo_items.id');
        $q = $this->db->get_where('combo_items', array('combo_items.product_id' => $pid));
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }

            return $data;
        }
        return FALSE;
    }

    public function updateOptionQuantity($option_id, $quantity)
    {
        if ($option = $this->getProductOptionByID($option_id)) {
            $nq = $option->quantity - $quantity;
            if ($this->db->update('product_variants', array('quantity' => $nq), array('id' => $option_id))) {
                return TRUE;
            }
        }
        return FALSE;
    }

    public function addOptionQuantity($option_id, $quantity)
    {
        if ($option = $this->getProductOptionByID($option_id)) {
            $nq = $option->quantity + $quantity;
            if ($this->db->update('product_variants', array('quantity' => $nq), array('id' => $option_id))) {
                return TRUE;
            }
        }
        return FALSE;
    }

    public function getProductOptionByID($id)
    {
        $q = $this->db->get_where('product_variants', array('id' => $id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function getPurchasedItems($product_id, $warehouse_id, $option_id = NULL)
    {
        $orderby = ($this->Settings->accounting_method == 1) ? 'asc' : 'desc';
        $this->db->select('id, quantity, quantity_balance, net_unit_cost, item_tax');
        $this->db->where('product_id', $product_id)->where('warehouse_id', $warehouse_id)->where('quantity_balance >', 0);
        if ($option_id) {
            $this->db->where('option_id', $option_id);
        }
        $this->db->group_by('id');
        $this->db->order_by('date', $orderby);
        $this->db->order_by('purchase_id', $orderby);
        $q = $this->db->get('purchase_items');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
			
            return $data;
        }
        return FALSE;
    }

    public function getProductWarehouseOptionQty($option_id, $warehouse_id)
    {
        $q = $this->db->get_where('warehouses_products_variants', array('option_id' => $option_id, 'warehouse_id' => $warehouse_id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function updateProductOptionQuantity($option_id, $warehouse_id, $quantity, $product_id)
    {
        if ($option = $this->getProductWarehouseOptionQty($option_id, $warehouse_id)) {
            $nq = $option->quantity - $quantity;
            if ($this->db->update('warehouses_products_variants', array('quantity' => $nq), array('option_id' => $option_id, 'warehouse_id' => $warehouse_id))) {
                $this->site->syncVariantQty($option_id, $warehouse_id);
                return TRUE;
            }
        } else {
            $nq = 0 - $quantity;
            if ($this->db->insert('warehouses_products_variants', array('option_id' => $option_id, 'product_id' => $product_id, 'warehouse_id' => $warehouse_id, 'quantity' => $nq))) {
                $this->site->syncVariantQty($option_id, $warehouse_id);
                return TRUE;
            }
        }
        return FALSE;
    }

    public function addSale($data = array(), $items = array(), $payments = array(), $sid = NULL)
    {
        $this->db->trans_start();
        $cost = $this->site->costing($items);       

        if ($this->db->insert('sales', $data)) {
            $sale_id = $this->db->insert_id();
            $this->site->updateReference('pos');
            $balance = array();
            foreach ($items as $item) {
                // $balance[$item['product_id']] = $this->site->getBalanceQuantityOfProduct($item['product_id'],$item['warehouse_id']);
                // $balance[$item['product_id']] = $balance[$item['product_id']] - 1;

                // if($balance[$item['product_id']] <= 0){
                //         $item['advance_booking'] = true;
                // }else{
                //         $item['advance_booking'] = false;
                // }
                
                // $balance[$item['product_id']] = $balance[$item['product_id']] - 1;				
                $item['sale_id'] = $sale_id;
                $this->db->insert('sale_items', $item);
                //$update_balance = $this->site->updateBalanceQuantity($item['product_id'],$item['warehouse_id'],$balance);
				
                $sale_item_id = $this->db->insert_id();
                if ($data['sale_status'] == 'completed' && $this->site->getProductByID($item['product_id'])) {
					
                    $item_costs = $this->site->item_costing($item);
                   
                    foreach ($item_costs as $item_cost) {
                        $item_cost['sale_item_id'] = $sale_item_id;
                        $item_cost['sale_id'] = $sale_id;
                        if(! isset($item_cost['pi_overselling'])) {
                            $this->db->insert('costing', $item_cost);
                        }
                    }

                }
				
            }
				
            if ($data['sale_status'] == 'completed') {
                $this->site->syncPurchaseItems($cost);
            }

            $msg = array();
            if (!empty($payments)) {
                $paid = 0;
                foreach ($payments as $payment) { 
                    if (!empty($payment) && isset($payment['amount']) && $payment['amount'] != 0) {
                        $payment['sale_id'] = $sale_id;
                        if ($payment['paid_by'] == 'ppp') {
                            $card_info = array("number" => $payment['cc_no'], "exp_month" => $payment['cc_month'], "exp_year" => $payment['cc_year'], "cvc" => $payment['cc_cvv2'],'card_type'=>$payment['card_type'], 'type' => $payment['cc_type']);
                            $result = $this->paypal($payment['amount'], $card_info);
                            if (!isset($result['error'])) {
                                $payment['transaction_id'] = $result['transaction_id'];
                                $payment['date'] = $this->sma->fld($result['created_at']);
                                $payment['amount'] = $result['amount'];
                                $payment['currency'] = $result['currency'];
                                unset($payment['cc_cvv2']);
                                $this->db->insert('payments', $payment);
                                $this->site->updateReference('pay');
                                $paid += $payment['amount'];
                            } else {
                                $msg[] = lang('payment_failed');
                                if (!empty($result['message'])) {
                                    foreach ($result['message'] as $m) {
                                        $msg[] = '<p class="text-danger">' . $m['L_ERRORCODE'] . ': ' . $m['L_LONGMESSAGE'] . '</p>';
                                    }
                                } else {
                                    $msg[] = lang('paypal_empty_error');
                                }
                            }
                        } elseif ($payment['paid_by'] == 'stripe') {
                            $card_info = array("number" => $payment['cc_no'], "exp_month" => $payment['cc_month'], "exp_year" => $payment['cc_year'], "cvc" => $payment['cc_cvv2'], 'type' => $payment['cc_type']);
                            $result = $this->stripe($payment['amount'], $card_info);
                            if (!isset($result['error'])) {
                                $payment['transaction_id'] = $result['transaction_id'];
                                $payment['date'] = $this->sma->fld($result['created_at']);
                                $payment['amount'] = $result['amount'];
                                $payment['currency'] = $result['currency'];
                                unset($payment['cc_cvv2']);
                                $this->db->insert('payments', $payment);
                                $this->site->updateReference('pay');
                                $paid += $payment['amount'];
                            } else {
                                $msg[] = lang('payment_failed');
                                $msg[] = '<p class="text-danger">' . $result['code'] . ': ' . $result['message'] . '</p>';
                            }
                        } else {
                            if ($payment['paid_by'] == 'credit_voucher') {
                                $card_details = explode('/',$payment['cc_no']);
                                $q = $this->db->where(array('card_no'=>$card_details[2],'biller_id'=>$card_details[0]))->get('gift_cards');
                                $balance = $q->row()->balance - $payment['pos_paid'];
                                $this->db->update('gift_cards', array('balance' => $balance,'upd_flg'=>'1'), array('card_no' => $card_details[2]));
                            }
                            unset($payment['cc_cvv2']);
                            $this->db->insert('payments', $payment);
                            $this->site->updateReference('pay');
                            $paid += $payment['amount'];
                        }
                    }
                }
                $this->site->syncSalePayments($sale_id);
            }

            $this->site->syncQuantity($sale_id);
            if ($sid) {
                $this->deleteBill($sid);
            }
            $this->sma->update_award_points($data['grand_total'], $data['customer_id'], $data['created_by']);

            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE)
            {
                $this->db->trans_rollback();
                $this->session->set_flashdata('error','Error in saving data. Please try again!!' );
                redirect('pos/add');
            }
            else
            {
                $this->db->trans_commit();
                return array('sale_id' => $sale_id, 'message' => $msg);
            }


          //  return array('sale_id' => $sale_id, 'message' => $msg);

        }else{
            $this->session->set_flashdata('error',lang("sale_fail") );
            redirect('pos/add');
            echo $this->db->_error_message();
	    }

        return false;
    }

    public function getProductByCode($code)
    {
        $q = $this->db->get_where('products', array('code' => $code), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function getProductByName($name)
    {
        $q = $this->db->get_where('products', array('name' => $name), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }

        return FALSE;
    }

    public function getAllBillerCompanies()
    {
        $q = $this->db->get_where('companies', array('group_name' => 'biller'));
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }

            return $data;
        }
    }

    public function getAllCustomerCompanies()
    {
        $q = $this->db->get_where('companies', array('group_name' => 'customer'));
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }

            return $data;
        }
    }

    public function getCompanyByID($id)
    {
        $q = $this->db->get_where('companies', array('id' => $id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function getAllProducts()
    {
        $q = $this->db->query('SELECT * FROM products ORDER BY id');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }

            return $data;
        }
    }

    public function getProductByID($id)
    {

        $q = $this->db->get_where('products', array('id' => $id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }

        return FALSE;
    }

    public function getAllTaxRates()
    {
        $q = $this->db->get('tax_rates');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }

            return $data;
        }
    }

    public function getTaxRateByID($id)
    {

        $q = $this->db->get_where('tax_rates', array('id' => $id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }

        return FALSE;
    }

    public function updateProductQuantity($product_id, $warehouse_id, $quantity)
    {

        if ($this->addQuantity($product_id, $warehouse_id, $quantity)) {
            return true;
        }

        return false;
    }

    public function addQuantity($product_id, $warehouse_id, $quantity)
    {
        if ($warehouse_quantity = $this->getProductQuantity($product_id, $warehouse_id)) {
            $new_quantity = $warehouse_quantity['quantity'] - $quantity;
            if ($this->updateQuantity($product_id, $warehouse_id, $new_quantity)) {
                $this->site->syncProductQty($product_id, $warehouse_id);
                return TRUE;
            }
        } else {
            if ($this->insertQuantity($product_id, $warehouse_id, -$quantity)) {
                $this->site->syncProductQty($product_id, $warehouse_id);
                return TRUE;
            }
        }
        return FALSE;
    }

    public function insertQuantity($product_id, $warehouse_id, $quantity)
    {
        if ($this->db->insert('warehouses_products', array('product_id' => $product_id, 'warehouse_id' => $warehouse_id, 'quantity' => $quantity))) {
            return true;
        }
        return false;
    }

    public function updateQuantity($product_id, $warehouse_id, $quantity)
    {
        if ($this->db->update('warehouses_products', array('quantity' => $quantity), array('product_id' => $product_id, 'warehouse_id' => $warehouse_id))) {
            return true;
        }
        return false;
    }

    public function getProductQuantity($product_id, $warehouse)
    {
        $q = $this->db->get_where('warehouses_products', array('product_id' => $product_id, 'warehouse_id' => $warehouse), 1);
        if ($q->num_rows() > 0) {
            return $q->row_array(); //$q->row();
        }
        return FALSE;
    }

    public function getItemByID($id)
    {
        $q = $this->db->get_where('sale_items', array('id' => $id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function getAllSales()
    {
        $q = $this->db->get('sales');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

    public function sales_count()
    {
        return $this->db->count_all("sales");
    }

    public function fetch_sales($limit, $start)
    {
        $this->db->limit($limit, $start);
        $this->db->order_by("id", "desc");
        $query = $this->db->get("sales");

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function getAllInvoiceItems($sale_id)
    {
        $this->db->select('sale_items.*,sales.sale_status, products.tax_percentage as tax_rate, product_variants.name as variant,products.hsn as hsn_code')
            //->join('tax_rates', 'tax_rates.id=sale_items.tax_rate_id', 'left')
            ->join('products', 'sale_items.product_id=products.id', 'inner')
            ->join('sales', 'sales.id=sale_items.sale_id', 'inner')
            ->join('product_variants', 'product_variants.id=sale_items.option_id', 'left')
            ->group_by('sale_items.id')
            ->order_by('id', 'asc');
        $q = $this->db->get_where('sale_items', array('sale_id' => $sale_id));
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

    public function getSuspendedSaleItems($id)
    {
        $q = $this->db->get_where('suspended_items', array('suspend_id' => $id));
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }

            return $data;
        }
    }

    public function getSuspendedSales($user_id = NULL)
    {
        if (!$user_id) {
            $user_id = $this->session->userdata('user_id');
        }
        $q = $this->db->get_where('suspended_bills', array('created_by' => $user_id));
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }

            return $data;
        }
    }


    public function getOpenBillByID($id)
    {
        $q = $this->db->get_where('suspended_bills', array('id' => $id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }
    

    public function getInvoiceByID($id)
    {
        $this->db->select('sales.*, users.first_name, users.last_name, users.username')
            ->join('users','sales.sales_executive_id = users.id');
        $q = $this->db->get_where('sales', array('sales.id' => $id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function bills_count()
    {
        if (!$this->Owner && !$this->Admin) {
            $this->db->where('created_by', $this->session->userdata('user_id'));
        }
        return $this->db->count_all_results("suspended_bills");
    }

    public function fetch_bills($limit, $start)
    {
        
        if (!$this->Owner && !$this->Admin) {
            //commented by ajay to avoid user wise hold sales
//            $this->db->where('created_by', $this->session->userdata('user_id'));
              $this->db->where('warehouse_id',$this->session->userdata('warehouse_id'));
        }
        
        $this->db->limit($limit, $start);
        $this->db->order_by("id", "asc");
        $query = $this->db->get("suspended_bills");

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;
    }

    public function getTodaySales()
    {
        $date = date('Y-m-d 00:00:00');
        $this->db->select('SUM( COALESCE( grand_total, 0 ) ) AS total, SUM( COALESCE( amount, 0 ) ) AS paid', FALSE)
            ->join('sales', 'sales.id=payments.sale_id', 'left')
            ->where('type', 'received')->where('payments.date >', $date);

        $q = $this->db->get('payments');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function getCosting()
    {
        $date = date('Y-m-d');
        $this->db->select('SUM( COALESCE( purchase_unit_cost, 0 ) * quantity ) AS cost, SUM( COALESCE( sale_unit_price, 0 ) * quantity ) AS sales, SUM( COALESCE( purchase_net_unit_cost, 0 ) * quantity ) AS net_cost, SUM( COALESCE( sale_net_unit_price, 0 ) * quantity ) AS net_sales', FALSE)
            ->where('date', $date);

        $q = $this->db->get('costing');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function getTodayCCSales()
    {
        $date = date('Y-m-d 00:00:00');
        $this->db->select('COUNT(' . $this->db->dbprefix('payments') . '.id) as total_cc_slips, SUM( COALESCE( grand_total, 0 ) ) AS total, SUM( COALESCE( amount, 0 ) ) AS paid', FALSE)
            ->join('sales', 'sales.id=payments.sale_id', 'left')
            ->where('type', 'received')->where('payments.date >', $date)->where('paid_by', 'CC')->where('card_type','CC');

        $q = $this->db->get('payments');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }
    
    /*
     * Added By Ajay
     * on 21-01-2017
     * To get debit card sales
     */
    
    public function getTodayDCSales()
    {
        $date = date('Y-m-d 00:00:00');
        $this->db->select('COUNT(' . $this->db->dbprefix('payments') . '.id) as total_cc_slips, SUM( COALESCE( grand_total, 0 ) ) AS total, SUM( COALESCE( amount, 0 ) ) AS paid', FALSE)
            ->join('sales', 'sales.id=payments.sale_id', 'left')
            ->where('type', 'received')->where('payments.date >', $date)->where('paid_by', 'CC')->where('card_type','DC');

        $q = $this->db->get('payments');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }
    
    /*
     * Added By Ajay
     * on 21-01-2017
     * To get sales by cedit note
     */
    
    public function getTodayCreditNoteSales()
    {
        $date = date('Y-m-d 00:00:00');
        $this->db->select('COUNT(' . $this->db->dbprefix('payments') . '.id) as total_cc_slips, SUM( COALESCE( grand_total, 0 ) ) AS total, SUM( COALESCE( amount, 0 ) ) AS paid', FALSE)
            ->join('sales', 'sales.id=payments.sale_id', 'left')
            ->where('type', 'received')->where('payments.date >', $date)->where('paid_by', 'credit_voucher');

        $q = $this->db->get('payments');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function getTodayCashSales()
    {
        $date = date('Y-m-d 00:00:00');
        $this->db->select('SUM( COALESCE( grand_total, 0 ) ) AS total, SUM( COALESCE( amount, 0 ) ) AS paid', FALSE)
            ->join('sales', 'sales.id=payments.sale_id', 'left')
            ->where('type', 'received')->where('payments.date >', $date)->where('payments.paid_by', 'cash');

        $q = $this->db->get('payments');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function getTodayRefunds()
    {
        $date = date('Y-m-d 00:00:00');
        $this->db->select('SUM( COALESCE( grand_total, 0 ) ) AS total, SUM( COALESCE( amount, 0 ) ) AS returned', FALSE)
            ->join('return_sales', 'return_sales.id=payments.return_id', 'left')
            ->where('type', 'returned')->where('payments.date >', $date);

        $q = $this->db->get('payments');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function getTodayExpenses()
    {
        $date = date('Y-m-d 00:00:00');
        $this->db->select('SUM( COALESCE( amount, 0 ) ) AS total', FALSE)
            ->where('date >', $date);

        $q = $this->db->get('expenses');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function getTodayCashRefunds()
    {
        $date = date('Y-m-d 00:00:00');
        $this->db->select('SUM( COALESCE( grand_total, 0 ) ) AS total, SUM( COALESCE( amount, 0 ) ) AS returned', FALSE)
            ->join('return_sales', 'return_sales.id=payments.return_id', 'left')
            ->where('type', 'returned')->where('payments.date >', $date)->where('paid_by', 'cash');

        $q = $this->db->get('payments');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function getTodayChSales()
    {
        $date = date('Y-m-d 00:00:00');
        $this->db->select('COUNT(' . $this->db->dbprefix('payments') . '.id) as total_cheques, SUM( COALESCE( grand_total, 0 ) ) AS total, SUM( COALESCE( amount, 0 ) ) AS paid', FALSE)
            ->join('sales', 'sales.id=payments.sale_id', 'left')
            ->where('type', 'received')->where('payments.date >', $date)->where('paid_by', 'Cheque');

        $q = $this->db->get('payments');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function getTodayPPPSales()
    {
        $date = date('Y-m-d 00:00:00');
        $this->db->select('COUNT(' . $this->db->dbprefix('payments') . '.id) as total_cheques, SUM( COALESCE( grand_total, 0 ) ) AS total, SUM( COALESCE( amount, 0 ) ) AS paid', FALSE)
            ->join('sales', 'sales.id=payments.sale_id', 'left')
            ->where('type', 'received')->where('payments.date >', $date)->where('paid_by', 'ppp');

        $q = $this->db->get('payments');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function getTodayStripeSales()
    {
        $date = date('Y-m-d 00:00:00');
        $this->db->select('COUNT(' . $this->db->dbprefix('payments') . '.id) as total_cheques, SUM( COALESCE( grand_total, 0 ) ) AS total, SUM( COALESCE( amount, 0 ) ) AS paid', FALSE)
            ->join('sales', 'sales.id=payments.sale_id', 'left')
            ->where('type', 'received')->where('payments.date >', $date)->where('paid_by', 'stripe');

        $q = $this->db->get('payments');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function getRegisterSales($date, $user_id = NULL)
    {
        if (!$date) {
            $date = $this->session->userdata('register_open_time');
        }
        if (!$user_id) {
            $user_id = $this->session->userdata('user_id');
        }
        $this->db->select('SUM( COALESCE( grand_total, 0 ) ) AS total, SUM( COALESCE( amount, 0 ) ) AS paid', FALSE)
            ->join('sales', 'sales.id=payments.sale_id', 'left')
            ->where('type', 'received')->where('payments.date >', $date);
        $this->db->where('payments.created_by', $user_id);

        $q = $this->db->get('payments');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }


    public function getRegisterCCSales($date, $user_id = NULL)
    {
        if (!$date) {
            $date = $this->session->userdata('register_open_time');
        }
        if (!$user_id) {
            $user_id = $this->session->userdata('user_id');
        }
        //echo "date ".$date."<br>hiiiii...";
        $this->db->select('COUNT(' . $this->db->dbprefix('payments') . '.id) as total_cc_slips, '
            . 'SUM( COALESCE( grand_total, 0 ) ) AS total, SUM( COALESCE( amount, 0 ) ) AS paid', FALSE)
            ->join('sales', 'sales.id=payments.sale_id', 'left')
            ->where('type', 'received')->where('payments.date >', $date)
            ->where('paid_by', 'CC')->where('card_type', 'CC');
        $this->db->where('payments.created_by', $user_id);
		
        $q = $this->db->get('payments');
        //echo "<pre>";print_r($q->row());die;
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }
    // Add By Ankit for credit card slip count
    
    
    public function getRegisterCCSales1($date, $user_id = NULL)
    {
        if (!$date) {
            $date = $this->session->userdata('register_open_time');
        }
        if (!$user_id) {
            $user_id = $this->session->userdata('user_id');
        }
        $this->db->select('COUNT(' . $this->db->dbprefix('payments') . '.id) as total_cc_slips, SUM( COALESCE( grand_total, 0 ) ) AS total, SUM( COALESCE( amount, 0 ) ) AS paid', FALSE)
            ->join('sales', 'sales.id=payments.sale_id', 'left')
            ->where('type', 'received')->where('payments.date >', $date)->where('paid_by', 'CC')->where('card_type', 'CC');
        $this->db->where('payments.created_by', $user_id);

        $q = $this->db->get('payments');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }
    
    
    
    
    

    public function getRegisterCashSales($date, $user_id = NULL)
    {
        if (!$date) {
            $date = $this->session->userdata('register_open_time');
        }
        if (!$user_id) {
            $user_id = $this->session->userdata('user_id');
        }
        
        $this->db->select('SUM( COALESCE( grand_total, 0 ) ) AS total, SUM( COALESCE( amount, 0 ) ) AS paid', FALSE)
            ->join('sales', 'sales.id=payments.sale_id', 'left')
            ->where('type', 'received')->where('payments.date >', $date)->where('paid_by', 'cash');
        $this->db->where('payments.created_by', $user_id);

        $q = $this->db->get('payments');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function getRegisterRefunds($date, $user_id = NULL)
    {
        if (!$date) {
            $date = $this->session->userdata('register_open_time');
        }
        if (!$user_id) {
            $user_id = $this->session->userdata('user_id');
        }
        $this->db->select('SUM( COALESCE( grand_total, 0 ) ) AS total, SUM( COALESCE( amount, 0 ) ) AS returned', FALSE)
            ->join('return_sales', 'return_sales.id=payments.return_id', 'left')
            ->where('type', 'returned')->where('payments.date >', $date);
        $this->db->where('payments.created_by', $user_id);

        $q = $this->db->get('payments');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function getRegisterCashRefunds($date, $user_id = NULL)
    {
        if (!$date) {
            $date = $this->session->userdata('register_open_time');
        }
        if (!$user_id) {
            $user_id = $this->session->userdata('user_id');
        }
        $this->db->select('SUM( COALESCE( grand_total, 0 ) ) AS total, SUM( COALESCE( amount, 0 ) ) AS returned', FALSE)
            ->join('return_sales', 'return_sales.id=payments.return_id', 'left')
            ->where('type', 'returned')->where('payments.date >', $date)->where('paid_by', 'cash');
        $this->db->where('payments.created_by', $user_id);

        $q = $this->db->get('payments');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function getRegisterExpenses($date, $user_id = NULL)
    {
       if (!$date) {
            $date = $this->session->userdata('register_open_time');
        }
        if (!$user_id) {
            $user_id = $this->session->userdata('user_id');
        }
        $this->db->select('SUM( COALESCE( amount, 0 ) ) AS total', FALSE)
            ->where('register_id ' , $_SESSION['register_id']);
        $this->db->where('created_by', $user_id);

        $q = $this->db->get('expenses');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }
	
    // added by vikas singh
  
    
    public function UpdateACQty($data,$emrs=0){

        $this->db->select("id,quantity,lot_no");
        $this->db->from("sma_products");
        $this->db->where('code' ,$data['product_code']);
        $this->db->where('id' ,$data['product_id']);
        //$this->db->order_by('lot_no' ,asc);
        $query = $this->db->get();
        $q = $query->row();
        // print_r($q) ;print_r($data);die;
        //$totalqty =  number_format($data['quantity'], 6);
        $totalqty = intval($data['quantity']);

        if(($q->id == $data['product_id'])) {
             
 
             $fquanity = $q->quantity;
             $fid = $q->id;
             $lot_no = $q->lot_no;
                
           

             if($fquanity >= $totalqty)
             {  
            
               $fquanity1 = $fquanity-$totalqty;
                
               $this->db->query("UPDATE sma_products SET quantity ='".$fquanity1."' where id =$fid ");
               $this->db->query("UPDATE sma_purchase_items SET quantity_balance ='".$fquanity1."' where product_id =$fid ");
               $this->db->query("UPDATE  sma_warehouses_products SET quantity ='".$fquanity1."' where product_id =$fid");
               //return true;
             }
             else
             {  
                     
                $fquanity1 = $totalqty-$fquanity;
                if($fquanity1 >= 0)
                {

                 $this->db->query("UPDATE sma_products SET quantity ='0' where id = $fid ");
                 $this->db->query("UPDATE sma_purchase_items SET quantity_balance ='0' where product_id =$fid ");
                 $this->db->query("UPDATE sma_warehouses_products SET quantity ='0' where product_id =$fid ");
                 $totalqty = $totalqty-$fquanity;
                }
             }
         }
        if($emrs==0){
            $res = $this->updateCustomerService($data);  
        }
             
        return $res;
    }
        
        public function updateCustomerService($data){        
            if($data['quantity']){
               
            $this->db->insert('customer_service',$data);
		      return $this->db->insert_id();
            }
            return false;
        }
	
    public function getRegisterTotalExpense($date, $user_id = NULL)
    {
        if (!$date) {
            $date = $this->session->userdata('register_open_time');
        }
        if (!$user_id) {
            $user_id = $this->session->userdata('user_id');
        }
        $this->db->select('SUM( COALESCE( amount, 0 ) ) AS total',FALSE)->where('date>', $date)->where('created_by', $user_id);	
		$q = $this->db->get('expenses');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }
    public function getRegisterChSales($date, $user_id = NULL)
    {
        if (!$date) {
            $date = $this->session->userdata('register_open_time');
        }
        if (!$user_id) {
            $user_id = $this->session->userdata('user_id');
        }
        $this->db->select('COUNT(' . $this->db->dbprefix('payments') . '.id) as total_cheques, SUM( COALESCE( grand_total, 0 ) ) AS total, SUM( COALESCE( amount, 0 ) ) AS paid', FALSE)
            ->join('sales', 'sales.id=payments.sale_id', 'left')
            ->where('type', 'received')->where('payments.date >', $date)->where('paid_by', 'Cheque');
        $this->db->where('payments.created_by', $user_id);

        $q = $this->db->get('payments');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function getRegisterPPPSales($date, $user_id = NULL)
    {
        if (!$date) {
            $date = $this->session->userdata('register_open_time');
        }
        if (!$user_id) {
            $user_id = $this->session->userdata('user_id');
        }
        $this->db->select('COUNT(' . $this->db->dbprefix('payments') . '.id) as total_cheques, SUM( COALESCE( grand_total, 0 ) ) AS total, SUM( COALESCE( amount, 0 ) ) AS paid', FALSE)
            ->join('sales', 'sales.id=payments.sale_id', 'left')
            ->where('type', 'received')->where('payments.date >', $date)->where('paid_by', 'ppp');
        $this->db->where('payments.created_by', $user_id);

        $q = $this->db->get('payments');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function getRegisterStripeSales($date, $user_id = NULL)
    {
        if (!$date) {
            $date = $this->session->userdata('register_open_time');
        }
        if (!$user_id) {
            $user_id = $this->session->userdata('user_id');
        }
        $this->db->select('COUNT(' . $this->db->dbprefix('payments') . '.id) as total_cheques, SUM( COALESCE( grand_total, 0 ) ) AS total, SUM( COALESCE( amount, 0 ) ) AS paid', FALSE)
            ->join('sales', 'sales.id=payments.sale_id', 'left')
            ->where('type', 'received')->where('payments.date >', $date)->where('paid_by', 'stripe');
        $this->db->where('payments.created_by', $user_id);

        $q = $this->db->get('payments');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function getDailySales($year, $month)
    {

        $myQuery = "SELECT DATE_FORMAT( date,  '%e' ) AS date, SUM( COALESCE( total, 0 ) ) AS total
        FROM " . $this->db->dbprefix('sales') . "
        WHERE DATE_FORMAT( date,  '%Y-%m' ) =  '{$year}-{$month}'
        GROUP BY DATE_FORMAT( date,  '%e' )";
        $q = $this->db->query($myQuery, false);
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }

            return $data;
        }
    }

    public function getMonthlySales($year)
    {

        $myQuery = "SELECT DATE_FORMAT( date,  '%c' ) AS date, SUM( COALESCE( total, 0 ) ) AS total
        FROM " . $this->db->dbprefix('sales') . "
        WHERE DATE_FORMAT( date,  '%Y' ) =  '{$year}'
        GROUP BY date_format( date, '%c' ) ORDER BY date_format( date, '%c' ) ASC";
        $q = $this->db->query($myQuery, false);
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }

            return $data;
        }
    }

    public function suspendSale($data = array(), $items = array(), $did = NULL)
    {
        $sData = array(
            'count' => $data['total_items'],
            'biller_id' => $data['biller_id'],
            'customer_id' => $data['customer_id'],
            'warehouse_id' => $data['warehouse_id'],
            'customer' => $data['customer'],
            'date' => $data['date'],
            'suspend_note' => $data['suspend_note'],
            'total' => $data['grand_total'],
            'order_tax_id' => $data['order_tax_id'],
            'order_discount_id' => $data['order_discount_id'],
            'created_by' => $this->session->userdata('user_id'),
        );

        if ($did) {
            if ($this->db->update('suspended_bills', $sData, array('id' => $did)) && $this->db->delete('suspended_items', array('suspend_id' => $did))) {
                $addOn = array('suspend_id' => $did);
                end($addOn);
                foreach ($items as &$var) {
                    $var = array_merge($addOn, $var);
                }
                if ($this->db->insert_batch('suspended_items', $items)) {
                    return TRUE;
                }
            }
        } else {
            if ($this->db->insert('suspended_bills', $sData)) {
                $suspend_id = $this->db->insert_id();
                $addOn = array('suspend_id' => $suspend_id);
                end($addOn);
                foreach ($items as &$var) {
                    $var = array_merge($addOn, $var);
                }
                if ($this->db->insert_batch('suspended_items', $items)) {
                    return TRUE;
                }
            }
        }
        return FALSE;
    }

    public function deleteBill($id)
    {

        if ($this->db->delete('suspended_items', array('suspend_id' => $id)) && $this->db->delete('suspended_bills', array('id' => $id))) {
            return true;
        }

        return FALSE;
    }

    public function getSubCategoriesByCategoryID($category_id)
    {
        $this->db->order_by('name');
        $q = $this->db->get_where("subcategories", array('category_id' => $category_id));
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }

            return $data;
        }

        return FALSE;
    }

    public function getInvoicePayments($sale_id)
    {
        $q = $this->db->get_where("payments", array('sale_id' => $sale_id));
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }

            return $data;
        }

        return FALSE;
    }

    function stripe($amount = 0, $card_info = array(), $desc = '')
    {
        $this->load->model('stripe_payments');
        //$card_info = array( "number" => "4242424242424242", "exp_month" => 1, "exp_year" => 2016, "cvc" => "314" );
        //$amount = $amount ? $amount*100 : 3000;
        $amount = $amount * 100;
        if ($amount && !empty($card_info)) {
            $token_info = $this->stripe_payments->create_card_token($card_info);
            if (!isset($token_info['error'])) {
                $token = $token_info->id;
                $data = $this->stripe_payments->insert($token, $desc, $amount, $this->default_currency->code);
                if (!isset($data['error'])) {
                    $result = array('transaction_id' => $data->id,
                        'created_at' => date($this->dateFormats['php_ldate'], $data->created),
                        'amount' => ($data->amount / 100),
                        'currency' => strtoupper($data->currency)
                    );
                    return $result;
                } else {
                    return $data;
                }
            } else {
                return $token_info;
            }
        }
        return false;
    }

    function paypal($amount = NULL, $card_info = array(), $desc = '')
    {
        $this->load->model('paypal_payments');
        //$card_info = array( "number" => "5522340006063638", "exp_month" => 2, "exp_year" => 2016, "cvc" => "456", 'type' => 'MasterCard' );
        //$amount = $amount ? $amount : 30.00;
        if ($amount && !empty($card_info)) {
            $data = $this->paypal_payments->Do_direct_payment($amount, $this->default_currency->code, $card_info, $desc);
            if (!isset($data['error'])) {
                $result = array('transaction_id' => $data['TRANSACTIONID'],
                    'created_at' => date($this->dateFormats['php_ldate'], strtotime($data['TIMESTAMP'])),
                    'amount' => $data['AMT'],
                    'currency' => strtoupper($data['CURRENCYCODE'])
                );
                return $result;
            } else {
                return $data;
            }
        }
        return false;
    }

    public function addPayment($payment = array())
    {
        if (isset($payment['sale_id']) && isset($payment['paid_by']) && isset($payment['amount'])) {
            $payment['pos_paid'] = $payment['amount'];
            $inv = $this->getInvoiceByID($payment['sale_id']);
            $paid = $inv->paid + $payment['amount'];
            if ($payment['paid_by'] == 'ppp') {
                $card_info = array("number" => $payment['cc_no'], "exp_month" => $payment['cc_month'], "exp_year" => $payment['cc_year'], "cvc" => $payment['cc_cvv2'], 'type' => $payment['cc_type']);
                $result = $this->paypal($payment['amount'], $card_info);
                if (!isset($result['error'])) {
                    $payment['transaction_id'] = $result['transaction_id'];
                    $payment['date'] = $this->sma->fld($result['created_at']);
                    $payment['amount'] = $result['amount'];
                    $payment['currency'] = $result['currency'];
                    unset($payment['cc_cvv2']);
                    $this->db->insert('payments', $payment);
                    $paid += $payment['amount'];
                } else {
                    $msg[] = lang('payment_failed');
                    if (!empty($result['message'])) {
                        foreach ($result['message'] as $m) {
                            $msg[] = '<p class="text-danger">' . $m['L_ERRORCODE'] . ': ' . $m['L_LONGMESSAGE'] . '</p>';
                        }
                    } else {
                        $msg[] = lang('paypal_empty_error');
                    }
                }
            } elseif ($payment['paid_by'] == 'stripe') {
                $card_info = array("number" => $payment['cc_no'], "exp_month" => $payment['cc_month'], "exp_year" => $payment['cc_year'], "cvc" => $payment['cc_cvv2'], 'type' => $payment['cc_type']);
                $result = $this->stripe($payment['amount'], $card_info);
                if (!isset($result['error'])) {
                    $payment['transaction_id'] = $result['transaction_id'];
                    $payment['date'] = $this->sma->fld($result['created_at']);
                    $payment['amount'] = $result['amount'];
                    $payment['currency'] = $result['currency'];
                    unset($payment['cc_cvv2']);
                    $this->db->insert('payments', $payment);
                    $paid += $payment['amount'];
                } else {
                    $msg[] = lang('payment_failed');
                    $msg[] = '<p class="text-danger">' . $result['code'] . ': ' . $result['message'] . '</p>';
                }
            } else {
                if ($payment['paid_by'] == 'gift_card') {
                    $gc = $this->site->getGiftCardByNO($payment['cc_no']);
                    $this->db->update('gift_cards', array('balance' => ($gc->balance - $payment['amount'])), array('card_no' => $payment['cc_no']));
                }
                unset($payment['cc_cvv2']);
                $this->db->insert('payments', $payment);
                $paid += $payment['amount'];
            }
            if (!isset($msg)) {
                if ($this->site->getReference('pay') == $data['reference_no']) {
                    $this->site->updateReference('pay');
                }
                $this->site->syncSalePayments($payment['sale_id']);
                return array('status' => 1, 'msg' => '');
            }
            return array('status' => 0, 'msg' => $msg);

        }
        return false;
    }
    
     /**
     * Added by Ajay
     * on 29-03-2016 
     */
    public function insertIntoPosCashDrawer($data) {
        if ($this->db->insert('pos_cash_drawer', $data)) {
            return true;
        }
        return FALSE;
    }

    /**
     * Added by Ajay
     * on 29-03-2016 
     */
    public function closePosCashDrawer($data) {
      
        if ($this->db->insert('sma_pos_cash_drawer', $data)) {
            return true;
        }
        return FALSE;
    }

    /**
     * Added by Ajay
     * on 29-03-2016 
     */
    public function openNewRegister($data) {
    
        if ($this->db->insert('pos_register', $data)) {
            $lastid = $this->db->insert_id();
            return array('status' => true, 'insertid' => $lastid);
        }
        return array('status' => FALSE, 'insertid' => null);
    }

    /**
     * Added by Ajay
     * on 30-03-2016
     */
    public function getCashDrawerDetails($date, $rid, $user_id = NULL) {
        if (!$date) {
            $date = $this->session->userdata('register_open_time');
        }
        if (!$user_id) {
            $user_id = $this->session->userdata('user_id');
        }


        $q = $this->db->get_where('pos_cash_drawer', array('user_id' => $user_id, 'pos_register_id' => $rid, 'date >' => $date));
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

	/*
     * Added by ajay 
     * on 12-04-2016
     * for discount authentication
     */
    public function getDiscountAuthentication($username,$password,$user_discount){
        $this->load->model('auth_model');
        $q = $this->db->get_where('users', array('username' => $this->db->escape_str($username), "warehouse_id"=>$_SESSION['warehouse_id']));
        if ($q->num_rows() == 1) {
            $user = $q->row();
            $password = $this->auth_model->hash_password_db($user->id, $password);
            if($password){
                return array($user,$password);
            }
            else{
                return false;
            }
        }
        return "false";
        
    }

	/*
     * Added by ajay 
     * on 13-04-2016
     * for discount authentication for logged in user
     */
   public function getLoggedInUserForDiscount($email){
	   $q = $this->db->select('show_discount')->where('email',$email)->get('users');
	   return $q->row()->show_discount;
   }
   
   /*
     * Added by ajay 
     * on 13-04-2016
     * for discount authentication for logged in user
     */
   public function getMaxDiscountOnInvoice(){
	   $q = $this->db->select('order_discount')->get('users');
	   return $q->row()->show_discount;
   }

	 /* Added by Ajay
     * on 20-04-2016
     * get all users
     */
    public function getAllUsers() {
        $this->db->select('users.id,username,email,show_discount');
        $this->db->from('users');
        $this->db->join('groups','users.group_id = groups.id','INNER');
        /* Updated by Chitra as group id 6 for manager, table locking updated in Db*/
        $this->db->where(array('users.warehouse_id'=>$_SESSION['warehouse_id'],'users.group_id'=>'6'));
        $q = $this->db->get()->result_array();
        return $q;
    }

    public function getAuthUsers($whId) {
        $q = $this->db->select('id,username,email')->where(array('warehouse_id'=>$whId,'group_id'=>6))->get('users');
        return $q->result_array();
    }

	
	 /* Added by Ajay
     * on 23-04-2016
     * update balance quantity
     */
	public function decreaseWarehouseProductQuantity($product_warehouse_id,$quantity){
		$sql = "UPDATE ".$this->db->dbprefix."warehouses_products SET quantity =".$quantity." WHERE id=".$product_warehouse_id;
		return $sql;
		/*
		$this->db->query($sql);
		$afftectedRows = $this->db->affected_rows();
		return $afftectedRows;
		*/
	}
	
	public function getAllBillers()
    {
        $q = $this->db->get_where('companies', array('group_name' => 'biller'));
        if ($q->num_rows() > 0) {
            return $q->result();
        }
        return FALSE;
    }
	/* Added by Ajay
     * on 17-05-2016
     * to get all of sma_settings
     */
	 
	 public function getAllSettings(){
		 $q = $this->db->get('settings');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
	 }
    /* Added by Ankit
     * on 23-06-2016
     * To convert invoice net payble amount to words
     */     
    public function convertWords($number){
	   $no = floor($number);
	   $point = round($number - $no, 2) * 100;
		if($point < 0){
		   $point = 100 + $point;
	   }
	   $hundred = null;
	   $digits_1 = strlen($no);
	   $i = 0;
	   $str = array();
	   $words = array('0' => 'Zero', '1' => 'One', '2' => 'Two',
		'3' => 'Three', '4' => 'Four', '5' => 'Five', '6' => 'Six',
		'7' => 'Seven', '8' => 'Eight', '9' => 'Nine',
		'10' => 'Ten', '11' => 'Eleven', '12' => 'Twelve',
		'13' => 'Thirteen', '14' => 'Fourteen',
		'15' => 'Fifteen', '16' => 'Sixteen', '17' => 'Seventeen',
		'18' => 'Eighteen', '19' =>'Nineteen', '20' => 'Twenty',
		'30' => 'Thirty', '40' => 'Forty', '50' => 'Fifty',
		'60' => 'Sixty', '70' => 'Seventy',
		'80' => 'Eighty', '90' => 'Ninety');
	   $digits = array('', 'Hundred', 'Thousand', 'Lakh', 'Crore');
	   while ($i < $digits_1) {
		 $divider = ($i == 2) ? 10 : 100;
		 $number = floor($no % $divider);
		 $no = floor($no / $divider);
		 $i += ($divider == 10) ? 1 : 2;
		 if ($number) {
			$plural = (($counter = count($str)) && $number > 9) ? 's' : null;
			$hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
			$str [] = ($number < 21) ? $words[$number] .
				" " . $digits[$counter] . $plural . " " . $hundred
				:
				$words[floor($number / 10) * 10]
				. " " . $words[$number % 10] . " "
				. $digits[$counter] . $plural . " " . $hundred;
		 } else $str[] = null;
	  }
	  $str = array_reverse($str);
	  $result = implode('', $str);
	  $points = ($point) ?
		"and " . $words[$point / 10] . " " . 
			  $words[$point = $point % 10] : '';
	  if($points!=null){
	  
	  echo $result . "" . $points . " Paise";}
	  else {
		  echo $result . "";
	  }
				 
    }
    
    
    public function convert_numbers_to_words($number){
	$no = round($number);
        $point = round($number - $no, 2) * 100;
        $hundred = null;
        $digits_1 = strlen($no);
        $i = 0;
        $str = array();
        $words = array('0' => '', '1' => 'one', '2' => 'two',
         '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
         '7' => 'seven', '8' => 'eight', '9' => 'nine',
         '10' => 'ten', '11' => 'eleven', '12' => 'twelve',
         '13' => 'thirteen', '14' => 'fourteen',
         '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
         '18' => 'eighteen', '19' =>'nineteen', '20' => 'twenty',
         '30' => 'thirty', '40' => 'forty', '50' => 'fifty',
         '60' => 'sixty', '70' => 'seventy',
         '80' => 'eighty', '90' => 'ninety');
        $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
        while ($i < $digits_1) {
          $divider = ($i == 2) ? 10 : 100;
          $number = floor($no % $divider);
          $no = floor($no / $divider);
          $i += ($divider == 10) ? 1 : 2;
          if ($number) {
             $plural = (($counter = count($str)) && $number > 9) ? '' : null;
             $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
             $str [] = ($number < 21) ? $words[$number] .
                 " " . $digits[$counter] . $plural . " " . $hundred
                 :
                 $words[floor($number / 10) * 10]
                 . " " . $words[$number % 10] . " "
                 . $digits[$counter] . $plural . " " . $hundred;
          } else $str[] = null;
       }
       $str = array_reverse($str);
       $result = implode('', $str);

        $points = ($point > 0) ?
         "." . $words[$point / 10] . " " . 
               $words[$point = $point % 10] : '';

            if(!empty($points)){
                return $result." only";
            }else if($result === ''){
                return "zero only";
            }
            else{
                return "Rs ".$result." only";
            }
    }
    /* Added by Ankit
     * on 24-06-2016
     * To get last opning amount
     */ 
    
    function lastOpen($id){
        $w = "SELECT cash_in_hand FROM sma_pos_cash_drawer WHERE user_id=$id AND status='open' ORDER BY date DESC LIMIT 1";
        $q = $this->db->query($w);      
        if ($q->result() > 0) {
            foreach (($q->result()) as $row) {
                  $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    
    /* Added by Ankit
     * on 24-06-2016
     * To get last closed amount
     */ 
    
    function lastClosed($id){
        $w="SELECT cash_in_hand FROM sma_pos_cash_drawer WHERE user_id=$id AND status='closed' ORDER BY date DESC LIMIT 1";
        $q = $this->db->query($w);      
        if ($q->result() > 0) {
            foreach (($q->result()) as $row) {
                  $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    
       /* Added by Ankit
     * on 15-12-2016
     * To get last closed amount by warehouse id
     */ 
    
    function lastClosedByWarehouse($id){
        $w = "SELECT cash_in_hand FROM sma_pos_cash_drawer WHERE warehouse_id=".$id." AND status='closed' ORDER BY date DESC LIMIT 1";
        //echo $w;
        $q = $this->db->query($w);      
        if ($q->result() > 0) {
            foreach (($q->result()) as $row) {
                  $data[] = $row;
            }
            return $data;
        }
        return false;
    }
    
    /*
     * Added by Ajay
     * on 15-12-2016
     * To get register data 
     */
    
     public function registerDataByWarehouse($warehouse_id)
    {
         if (!$warehouse_id) {
            $warehouse_id = $this->session->userdata('warehouse_id');
        }
        $this->db->order_by("date","desc")->limit(1);
        $q = $this->db->where(array('status'=>'open',
            'warehouse_id'=>$warehouse_id))->get('pos_register');
        if ($q->num_rows() > 0) {	
            return $q->row();
        }
        
        return FALSE;
    }
    
    /*
     * Added by Ajay
     * on 13-12-2016
     * To get all open registers of warehouse 
     */
    
    public function getWarehouseOpenRegisters($warehouse_id){
        /*$this->db->select('*');
        $this->db->select("pos_register.id,CONCAT(" . $this->db->dbprefix('users') . 
                ".first_name, ' ', " . $this->db->dbprefix('users') . 
                ".last_name, ' - ', " . $this->db->dbprefix('users') . 
                ".email) as user", FALSE)
            ->join('users', 'users.id=pos_register.user_id', 'left');
        $q = $this->db->get_where('pos_register', 
                array('status' => 'open', 
                    //'user_id' => $user_id_reg,
                    'pos_register.warehouse_id'=>$warehouse_id,
                    'date < ' => date("Y-m-d",strtotime("now"))
                    ));*/
//        $w = "select a.username,b.* from sma_pos_register b inner join sma_users a on (a.warehouse_id = b.warehouse_id) "
//                . "where b.status='open' AND b.warehouse_id = ".$warehouse_id." "
//                . "AND DATE(b.date) <= '".date("Y-m-d",strtotime("now"))."'";
        if($this->Sales || $this->Manager){
            $w = "select b.username,a.date,a.cash_in_hand,a.id,a.user_id,a.warehouse_id from sma_pos_register a inner join sma_users b on a.user_id = b.id  where status='open' AND a.warehouse_id = ".$warehouse_id." AND DATE(a.date) <= '".date('Y-m-d')."'";
        }else{
            $w = "select b.username,a.date,a.cash_in_hand,a.id,a.user_id,a.warehouse_id from sma_pos_register a inner join sma_users b on a.user_id = b.id where status='open' AND DATE(a.date) <= '".date('Y-m-d')."' ";
        }
        
        $q = $this->db->query($w);
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;

    }
    
    public function getRegisterDate($warehouse_id){
        $w = "select id, date, status from sma_pos_register where status='open' AND warehouse_id = ".$warehouse_id." ";
        $q = $this->db->query($w);
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $row) {
                $data = $row;
            }
            return $data;
        }
        return FALSE;
    }
    
    /*
     * Added by Ajay 
     * 13-12-2016
     * To get storewise cc sales
     */
    
     public function getStoreRegisterCCSales($date,$register_id)
     {
        if (!$date) {
            $date = $this->session->userdata('register_open_time');
        }
        
        $this->db->select('COUNT(' . $this->db->dbprefix('payments') . '.id) as total_cc_slips, SUM( COALESCE( grand_total, 0 ) ) AS total, SUM( COALESCE( amount, 0 ) ) AS paid', FALSE)
            ->join('sales', 'sales.id=payments.sale_id', 'left')
            ->where('type', 'received')->where('payments.date >', $date)->where('paid_by', 'CC')->where('card_type', 'CC');
        $this->db->where('payments.register_id', $register_id);

        $q = $this->db->get('payments');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }
    
    /*
     * Added  by Ajay on 14-12-2016
     * To get storewise DC sales
     */
    
     public function getStoreRegisterDCSales($date, $register_id)
     {
        if (!$date) {
            $date = $this->session->userdata('register_open_time');
        }
        
        $this->db->select('COUNT(' . $this->db->dbprefix('payments') . '.id) as total_dc_slips, SUM( COALESCE( grand_total, 0 ) ) AS total, SUM( COALESCE( amount, 0 ) ) AS paid', FALSE)
            ->join('sales', 'sales.id=payments.sale_id', 'left')
            ->where('type', 'received')->where('payments.date >', $date)->where('paid_by', 'CC')->where('card_type', 'DC');
        $this->db->where('payments.register_id', $register_id);

        $q = $this->db->get('payments');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }
    
    /*
     * Added by Ajay
     * 13-12-2016
     * To get cash sales storewise
     */
    
    public function getStoreRegisterCashSales($date, $register_id = NULL)
    {
        if (!$date) {
            $date = $this->session->userdata('register_open_time');
        }
        if (!$register_id) {
            $register_id = $this->session->userdata('register_id');
        }
        $this->db->select('SUM( COALESCE( grand_total, 0 ) ) AS total, SUM( COALESCE( amount, 0 ) ) AS paid', FALSE)
            ->join('sales', 'sales.id=payments.sale_id', 'left')
            ->where('type', 'received')->where('payments.date >', $date)->where('paid_by', 'cash');
        $this->db->where('payments.register_id', $register_id);

        $q = $this->db->get('payments');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }
    
     /*
     * Added by Ajay
     * 13-12-2016
     * To get credit note sales storewise
     */
    
    public function getStoreRegisterCreditNoteSales($date, $register_id = NULL)
    {
        if (!$date) {
            $date = $this->session->userdata('register_open_time');
        }
        if (!$register_id) {
            $register_id = $this->session->userdata('register_id');
        }
        $this->db->select('SUM( COALESCE( grand_total, 0 ) ) AS total, SUM( COALESCE( amount, 0 ) ) AS paid', FALSE)
            ->join('sales', 'sales.id=payments.sale_id', 'left')
            ->where('type', 'received')->where('payments.date >', $date)->where('paid_by', 'credit_voucher');
        $this->db->where('payments.register_id', $register_id);

        $q = $this->db->get('payments');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }
    
    /*
     * Added by Ajay 
     * on 13-12-2016
     * To get Ch sales storewise
     */
    
    public function getStoreRegisterChSales($date, $register_id = NULL)
    {
        if (!$date) {
            $date = $this->session->userdata('register_open_time');
        }
        if (!$register_id) {
            $user_id = $this->session->userdata('register_id');
        }
        $this->db->select('COUNT(' . $this->db->dbprefix('payments') . '.id) as total_cheques, SUM( COALESCE( grand_total, 0 ) ) AS total, SUM( COALESCE( amount, 0 ) ) AS paid', FALSE)
            ->join('sales', 'sales.id=payments.sale_id', 'left')
            ->where('type', 'received')->where('payments.date >', $date)->where('paid_by', 'Cheque');
        $this->db->where('payments.register_id', $register_id);

        $q = $this->db->get('payments');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }
    
    /*
     * Added by Ajay
     * on 13-12-2016
     * To get cash drawer details storewise
     */
    
     public function getStoreCashDrawerDetails($date, $rid) {
        if (!$date) {
            $date = $this->session->userdata('register_open_time');
        }
        if (!$rid) {
            $rid = $this->session->userdata('register_id');
        }


        $q = $this->db->get_where('pos_cash_drawer', array('pos_register_id' => $rid,'status'=>'open'));
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }
    
    /*
     * Added by Ajay 
     * on 13-12-12016
     */
    
     public function getStoreRegisterPPPSales($date, $register_id = NULL)
    {
        if (!$date) {
            $date = $this->session->userdata('register_open_time');
        }
        if (!$register_id) {
            $register_id = $this->session->userdata('register_id');
        }
        $this->db->select('COUNT(' . $this->db->dbprefix('payments') . '.id) as total_cheques, SUM( COALESCE( grand_total, 0 ) ) AS total, SUM( COALESCE( amount, 0 ) ) AS paid', FALSE)
            ->join('sales', 'sales.id=payments.sale_id', 'left')
            ->where('type', 'received')->where('payments.date >', $date)->where('paid_by', 'ppp');
        $this->db->where('payments.register_id', $register_id);

        $q = $this->db->get('payments');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }
    
    /*
     * Added by Ajay
     * on 13-12-2016
     */
	
     public function getStoreRegisterStripeSales($date, $register_id = NULL)
    {
        if (!$date) {
            $date = $this->session->userdata('register_open_time');
        }
        if (!$register_id) {
            $register_id = $this->session->userdata('register_id');
        }
        $this->db->select('COUNT(' . $this->db->dbprefix('payments') . '.id) as total_cheques, SUM( COALESCE( grand_total, 0 ) ) AS total, SUM( COALESCE( amount, 0 ) ) AS paid', FALSE)
            ->join('sales', 'sales.id=payments.sale_id', 'left')
            ->where('type', 'received')->where('payments.date >', $date)->where('paid_by', 'stripe');
        $this->db->where('payments.register_id', $register_id);

        $q = $this->db->get('payments');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }
    
    /*
     * Added by Ajay
     * on 13-12-2016
     */
    
    public function getStoreRegisterSales($date, $register_id = NULL)
    {
        if (!$date) {
            $date = $this->session->userdata('register_open_time');
        }
        if (!$register_id) {
            $register_id = $this->session->userdata('register_id');
        }
        $this->db->select('SUM( COALESCE( grand_total, 0 ) ) AS total, SUM( COALESCE( amount, 0 ) ) AS paid', FALSE)
            ->join('sales', 'sales.id=payments.sale_id', 'left')
            ->where('type', 'received')->where('payments.date >', $date);
        $this->db->where('payments.register_id', $register_id);

        $q = $this->db->get('payments');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }
    
    /*
     * Added by Ajay
     * on 13-12-2016
     */
    
    public function getStoreRegisterRefunds($date, $register_id = NULL)
    {
        if (!$date) {
            $date = $this->session->userdata('register_open_time');
        }
        if (!$register_id) {
            $register_id = $this->session->userdata('register_id');
        }
        $this->db->select('SUM( COALESCE( grand_total, 0 ) ) AS total, SUM( COALESCE( amount, 0 ) ) AS returned', FALSE)
            ->join('return_sales', 'return_sales.id=payments.return_id', 'left')
            ->where('type', 'returned')->where('payments.date >', $date);
        $this->db->where('payments.register_id', $register_id);

        $q = $this->db->get('payments');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }
    
    /*
     * Added by Ajay
     * on 13-12-2016
     */
    
     public function getStoreRegisterCashRefunds($date, $register_id = NULL)
    {
        if (!$date) {
            $date = $this->session->userdata('register_open_time');
        }
        if (!$register_id) {
            $register_id = $this->session->userdata('register_id');
        }
        $this->db->select('SUM( COALESCE( grand_total, 0 ) ) AS total, SUM( COALESCE( amount, 0 ) ) AS returned', FALSE)
            ->join('return_sales', 'return_sales.id=payments.return_id', 'left')
            ->where('type', 'returned')->where('payments.date >', $date)->where('paid_by', 'cash');
        $this->db->where('payments.register_id', $register_id);

        $q = $this->db->get('payments');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }
    
    /*
     * Added By Ajay 
     * on 13-12-2016
     */
    
    
    public function getStoreRegisterExpenses($date, $register_id = NULL)
    {
       if (!$date) {
            $date = $this->session->userdata('register_open_time');
        }
        if (!$register_id) {
            $register_id = $this->session->userdata('register_id');
        }
        $this->db->select('SUM( COALESCE( amount, 0 ) ) AS total', FALSE)
            ->where('register_id ' , $register_id);
        //$this->db->where('created_by', $user_id);

        $q = $this->db->get('expenses');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    } 
    
    /*
     * Added by Ajay
     * on 13-12-2016
     */
    
    public function getStoreSuspendedSales($register_open_time,$warehouse_id = NULL)
    {
        if (!$warehouse_id) {
            $warehouse_id = $this->session->userdata('warehouse_id');
        }
        $q = $this->db->get_where('suspended_bills', array('warehouse_id' => $warehouse_id,'date >'=>$register_open_time));
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }

            return $data;
        }
    }
    
    /*
     * Added By Ajay
     * on 13-12-2016
     * 
     */
    
       public function totalStoreCreditVoucherAmount($register_open_time, $rid)
       {  
           $t=0;
           $this->db->select('sale_id,amount');
           $q = $this->db->get_where('payments', array('register_id' => $rid,'paid_by'=>'credit_voucher','date >'=>$register_open_time,'return_id'=>NULL));
          if ($q->num_rows() > 0) {
            foreach ($q->result() as $row) {
                $data[] = $row;
             }
            
             foreach($data as $k)
             {
                $t= $t+$k->amount;
             }
             return $t;
        }
        return FALSE;
           
       }
       
       /*
        * Added by Ajay
        * on 13-12-2016
        */
    
       public function totalStoreCreditCardAmount($register_open_time,$registerid)
       {
            $t=0;
            $this->db->select('sale_id,amount');
         //  $q = $this->db->get_where('payments', array('created_by' => $user_id, 'date(date)>='=> date('Y-m-d', strtotime($register_open_time)),'paid_by'=>'CC'));
            $q = $this->db->get_where('payments', array('date >' => $register_open_time, 'register_id'=> $registerid ,'paid_by'=>'CC','card_type'=>'CC'));
          if ($q->num_rows() > 0) {
            foreach ($q->result() as $row) {
                $data[] = $row;
             }
            
             foreach($data as $k)
             {
                $t= $t+$k->amount;
             }
             return $t;
        }
        return FALSE;
           
       }
       
       
        public function totalStoreDebitCardAmount($register_open_time,$registerid)
        {
            $t=0;
            $this->db->select('sale_id,amount');
         //  $q = $this->db->get_where('payments', array('created_by' => $user_id, 'date(date)>='=> date('Y-m-d', strtotime($register_open_time)),'paid_by'=>'CC'));
            $q = $this->db->get_where('payments', array('date >=' => $register_open_time, 'register_id'=> $registerid ,'paid_by'=>'CC','card_type'=>'DC'));
          if ($q->num_rows() > 0) {
            foreach ($q->result() as $row) {
                $data[] = $row;
             }
            
             foreach($data as $k)
             {
                $t= $t+$k->amount;
             }
             return $t;
        }
        return FALSE;
           
       }   
       
        public function getTodayOpeningBalance(){
            $this->db->select('cash_in_hand');
            $this->db->where(array('warehouse_id'=>$_SESSION['warehouse_id'],'date(date)>='=>date('Y-m-d')));
            $this->db->order_by('date');
            $q = $this->db->get('pos_register');
            if($q->num_rows() > 0){
                return $q->result();
            }
            return FALSE;
        }
        
    public function deleteBillByWarehouse($id)
    {
        
        if ($this->db->delete('suspended_items', array('warehouse_id' => $id)) && $this->db->delete('suspended_bills', array('warehouse_id' => $id))) {
            return true;
        }

        return FALSE;
    }
    
    public function uniqueExpenseReference($slip){
        $q = "Select reference from sma_expenses where reference = '".$slip."'";
        $a= $this->db->query($q);
        if(!empty($a->result()))
        {
            return 1;
        }
        return 0;       
    }
    
    /*
     * Added by Ajay
     * on 02-03-2017
     * uniqueness of approval number
     */
    
    public function getApprovalNumberForUniqueness($approval_no){
       
       $q= "select approval_no from sma_payments where approval_no = '".$approval_no."' AND paid_by='CC'";
       $a=$this->db->query($q);
       if(!empty($a->result()))
       {
           return 1;
       }
        return 0;
    }
    
    
    public function getCustomerServiceById($id){
        $this->db->where(array('id' => $id));
        $res = $this->db->get('customer_service');
        if($res->num_rows() > 0){
            return $res->result();
        }
        return false;
    }
    
    /*
     * Added by Ajay on 21-04-2016
     * to customer service details by sale id
     */
    
    public function getCustomerServiceBySaleId($id){
        $this->db->where(array('sale_id' => $id));
        $res = $this->db->get('customer_service');
        if($res->num_rows() > 0){
            return $res->row();
        }
        return false;
    }
    
    /*
     * Added by Ajay on 16-05-2017
     * To get all credit notes of a customer which are not expired
     */
    
    public function getCustomerCreditNotes($id){
        //$d1 = date('Y-m-d',strtotime("today"));
        $d = date('Y-m-d');
        $sql = "SELECT * FROM sma_gift_cards WHERE customer_id = ".$id." AND balance > 0 AND expiry >= ".$d." ";
        //echo $w;
        $q = $this->db->query($sql);
        if($q->num_rows() > 0){
            return $q->result();
        }
        
        return false;
    }

}
