<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sales_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

      function super_unique($array,$key)

    {

       $temp_array = array();

       foreach ($array as &$v) {

           if (!isset($temp_array[$v[$key]]))

           $temp_array[$v[$key]] =& $v;

       }

       $array = array_values($temp_array);

       return $array;
    }
   


public function getProductNames($term, $warehouse_id, $limit = 10) {
        // $this->db->select('products.id, barcode, code, name,unit,type, warehouses_products.quantity,
        //         price,tax_rate, tax_method, purchase_items.item_tax, purchase_items.net_unit_cost, purchase_items.tax')
        //         ->join('warehouses_products', 'warehouses_products.product_id=products.id', 'left')
        //         ->join('purchase_items', 'purchase_items.product_id=products.id', 'left')
        //         ->group_by(array('products.barcode','products.price'));
        //         //->where(array('code' => $code, "products.quantity > ",0));
        // if ($this->Settings->overselling) {
        //     $this->db->where("(name LIKE '%" . $term . "%' OR code LIKE '%" . $term . "%' OR barcode LIKE '%" . $term . "%' "
        //             . "OR  concat(name, ' (', code, ')') LIKE '%" . $term . "%')");
        // } else {
        //     $this->db->where("(products.track_quantity > 0 OR warehouses_products.quantity > 0) "
        //             . "AND warehouses_products.warehouse_id = '" . $warehouse_id . "' "
        //             . "AND (name LIKE '%" . $term . "%' OR code LIKE '%" . $term . "%' OR barcode LIKE '%" . $term . "%' " 
        //             . "OR  concat(name, ' (', code, ')') LIKE '%" . $term . "%')");
        // }
        // //products.category_id!=5 AND 
        // $this->db->limit($limit);
        // $this->db->where('warehouses_products.quantity >', 0);
        // $q = $this->db->get('products');
    
        /*$sql = "select 
                    " . $this->db->dbprefix('products') . ".id," . $this->db->dbprefix('products') . ".code," . $this->db->dbprefix('products') . ".name,
                    ".$this->db->dbprefix('products').".barcode,
                    ".$this->db->dbprefix('products').".unit,
                    ".$this->db->dbprefix('products').".type,
                    ".$this->db->dbprefix('products').".price,
                    ".$this->db->dbprefix('products').".tax_rate,
                    ".$this->db->dbprefix('products').".tax_method,
                    ".$this->db->dbprefix('warehouses_products').".quantity,
                    ".$this->db->dbprefix('purchase_items').".net_unit_cost,
                    ".$this->db->dbprefix('purchase_items') . ".item_tax,
                    ".$this->db->dbprefix('purchase_items') . ".tax,
                    min(" . $this->db->dbprefix('products') . ".lot_no) as lot_no
                    from " . $this->db->dbprefix('products') . "
                    left join " . $this->db->dbprefix('purchase_items') . " on " . $this->db->dbprefix('products') . ".id = " . $this->db->dbprefix('purchase_items') . ".product_id
                    AND left join " . $this->db->dbprefix('warehouses_products') . " on " . $this->db->dbprefix('products') . ".id = " . $this->db->dbprefix('warehouses_products') . ".product_id
                    WHERE " . $this->db->dbprefix('purchase_items') . ".warehouse_id = ".$_SESSION['warehouse_id']." AND " . $this->db->dbprefix('products') . ".category_id = ".$id." AND 
                    " . $this->db->dbprefix('products') . ".track_quantity >0 AND " . $this->db->dbprefix('warehouses_products') . ".quantity > 0
                    AND ".$this->db->dbprefix('warehouses_products').".warehouse_id = '".$warehouse_id."'
                    AND (".$this->db->dbprefix('products').".name LIKE '%".$term."' OR ".$this->db->dbprefix('products').".code LIKE '%".$term."' OR ".$this->db->dbprefix('products').".barcode LIKE '%".$term."'
                    OR concat(".$this->db->dbprefix('products').".name,'(',".$this->db->dbprefix('products').".code,')') LIKE '%".$term."'
                    group by
                    " . $this->db->dbprefix('products') . ".code,
                    " . $this->db->dbprefix('products') . ".barcode,
                    " . $this->db->dbprefix('products') . ".price,                
                    HAVING count(" . $this->db->dbprefix('purchase_items') . ".quantity_balance) > 0
                    order by " . $this->db->dbprefix('products') . ".lot_no";
        echo $sql;die; 
        $q = $this->db->query($sql);*/
        $query = "SELECT
                sma_products.id,
                sma_products.barcode,
                sma_products.code,
                sma_products.unit,
                sma_products.type,
                sma_products.name,
                sma_products.price,
                sma_products.tax_rate,
                sma_products.tax_method,
                sma_purchase_items.item_tax,
                sma_purchase_items.net_unit_cost,
                sma_purchase_items.tax,
                sma_purchase_items.unit_cost,
                sma_purchase_items.quantity_balance AS balance,
                sma_products.lot_no,
                sma_products.cart_qty,
                sma_products.cart_count,
                sma_products.promotion,
                sma_products.tax_percentage
              FROM
                sma_products
              LEFT JOIN
                sma_purchase_items ON sma_products.id = sma_purchase_items.product_id
              LEFT JOIN
                sma_warehouses_products ON sma_products.id = sma_warehouses_products.product_id
              WHERE
                sma_warehouses_products.warehouse_id = " . $warehouse_id . " AND(
                  NAME LIKE '%" . $term . "%' OR CODE LIKE '%" . $term . "%' OR barcode LIKE '%" . $term . "%' OR CONCAT(NAME,
                  ' (',
                  CODE,
                  ')') LIKE '%" . $term . "%'
                ) AND sma_warehouses_products.quantity > 0 AND sma_products.cart_qty=1
              ORDER BY
                sma_products.lot_no ASC";

        $q = $this->db->query($query);
        if ($q->num_rows() > 0) {


            foreach (($q->result()) as $row) {

                $data[] = $row;

            }
    
      
  
   $data33 = json_decode(json_encode($this->super_unique(json_decode(json_encode($data),true),'code')));

  //print_r($data33);
    return $data33;
    
      }
    }

    public function getProductComboItems($pid, $warehouse_id = NULL) {
        $this->db->select('products.id as id, combo_items.item_code as code, combo_items.quantity as qty, products.name as name,products.type as type, warehouses_products.quantity as quantity')
                ->join('products', 'products.code=combo_items.item_code', 'left')
                ->join('warehouses_products', 'warehouses_products.product_id=products.id', 'left')
                ->group_by('combo_items.id');
        if ($warehouse_id) {
            $this->db->where('warehouses_products.warehouse_id', $warehouse_id);
        }
        $q = $this->db->get_where('combo_items', array('combo_items.product_id' => $pid));
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }

            return $data;
        }
        return FALSE;
    }

    public function getProductByCode($code) {
        $q = $this->db->get_where('products', array('code' => $code), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function syncQuantity($sale_id) {
        if ($sale_items = $this->getAllInvoiceItems($sale_id)) {
            foreach ($sale_items as $item) {
                $this->site->syncProductQty($item->product_id, $item->warehouse_id);
                if (isset($item->option_id) && !empty($item->option_id)) {
                    $this->site->syncVariantQty($item->option_id, $item->warehouse_id);
                }
            }
        }
    }

    public function getProductQuantity($product_id, $warehouse) {
        $q = $this->db->get_where('warehouses_products', array('product_id' => $product_id, 'warehouse_id' => $warehouse), 1);
        if ($q->num_rows() > 0) {
            return $q->row_array(); //$q->row();
        }
        return FALSE;
    }

    public function getProductOptions($product_id, $warehouse_id, $all = NULL) {
        $this->db->select('product_variants.id as id, product_variants.name as name, product_variants.price as price, product_variants.quantity as total_quantity, warehouses_products_variants.quantity as quantity')
                ->join('warehouses_products_variants', 'warehouses_products_variants.option_id=product_variants.id', 'left')
                //->join('warehouses', 'warehouses.id=product_variants.warehouse_id', 'left')
                ->where('product_variants.product_id', $product_id)
                ->where('warehouses_products_variants.warehouse_id', $warehouse_id)
                ->group_by('product_variants.id');
        if (!$this->Settings->overselling && !$all) {
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

    public function getProductVariants($product_id) {
        $q = $this->db->get_where('product_variants', array('product_id' => $product_id));
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

    public function getItemByID($id) {

        $q = $this->db->get_where('sale_items', array('id' => $id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }

        return FALSE;
    }

    //Add by Chitra on 07/09 for lot changes
    public function getProductsLot($id, $code, $warehouse_id) {
        $q = "select a.*, b.product_id,b.product_code,b.product_name,b.option_id,b.net_unit_cost,b.quantity as totalqty,b.warehouse_id,b.item_tax,b.tax_rate_id,b.tax,b.discount,b.item_discount,b.expiry,b.subtotal,b.quantity_balance,b.date,b.status,b.unit_cost,b.real_unit_cost,b.lot_no,b.sr_no,b.org_id,b.grp_id,b.psale from sma_products a JOIN sma_purchase_items b ON a.id = b.product_id "
                . "where a.id='$id' AND a.warehouse = '" . $warehouse_id . "' AND "
                . "a.code = '" . $code . "' "
                . "AND (a.quantity != 'null' OR a.quantity > 0) "
                . "AND (a.lot_no != 'null' OR a.lot_no != '') "
                . "group by a.price order by a.lot_no asc";
        //echo $q;exit;
        $query = $this->db->query($q);

        //echo $query->num_rows();die;
        if ($query->num_rows() > 0) {
            foreach (($query->result()) as $res) {
                $res->tax = round($res->tax,1);
                $lot[] = $res;
            }
            //array_push($lot,"1");
        }
        //print_r($lot);exit;
        return $lot;
    }

    public function getAllInvoiceItems($sale_id) {
        $this->db->select('sale_items.*, tax_rates.code as tax_code, tax_rates.name as tax_name, tax_rates.rate as tax_rate, products.unit, products.details as details, product_variants.name as variant')
                ->join('products', 'products.id=sale_items.product_id', 'left')
                ->join('product_variants', 'product_variants.id=sale_items.option_id', 'left')
                ->join('tax_rates', 'tax_rates.id=sale_items.tax_rate_id', 'left')
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

     public function getAllInvoiceItemsRemaining($sale_id) {
        $data = array();
        $this->db->select('sale_items.*, tax_rates.code as tax_code, '
                . 'tax_rates.name as tax_name, tax_rates.rate as tax_rate, '
                . 'products.unit, products.details as details, product_variants.name as variant')
                ->from('sale_items')
                ->join('products', 'products.id=sale_items.product_id', 'left')
                ->join('product_variants', 'product_variants.id=sale_items.option_id', 'left')
                ->join('tax_rates', 'tax_rates.id=sale_items.tax_rate_id', 'left')
                ->where('return_flg IS NULL', null, false)
                //->where('returnd_flg!=',1)   
                ->where('sale_id',$sale_id)     

                ->group_by('sale_items.id')
                ->order_by('id', 'asc');

        $q = $this->db->get()->result();

        if (count($q) > 0) {
            foreach ($q as $row) {
                array_push($data,$row);
               // $data[] = $row;
            }
           
        }
              return $data;   
       // return FALSE;
    }

    public function getAllReturnItems($return_id) {
        $this->db->select('return_items.*, products.details as details, product_variants.name as variant,products.hsn,products.price')
                ->join('products', 'products.id=return_items.product_id')
                ->join('product_variants', 'product_variants.id=return_items.option_id', 'left')
                ->group_by('return_items.id')
                ->order_by('id', 'asc');
        $q = $this->db->get_where('return_items', array('return_id' => $return_id));
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
    }

    public function getAllInvoiceItemsWithDetails($sale_id) {
        $this->db->select('sale_items.id, sale_items.product_name, sale_items.product_code, sale_items.quantity, sale_items.serial_no, sale_items.tax, sale_items.net_unit_price, sale_items.item_tax, sale_items.item_discount, sale_items.subtotal, products.details');
        $this->db->join('products', 'products.id=sale_items.product_id', 'left');
        $this->db->order_by('id', 'asc');
        $q = $this->db->get_where('sale_items', array('sale_id' => $sale_id));
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
    }

    public function getInvoiceByID($id) {
        $q = $this->db->get_where('sales', array('id' => $id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function getReturnByID($id) {
        $this->db->select("return_sales.*, sma_sale_return_reason.reason as note")
                ->join("sma_sale_return_reason", "sma_sale_return_reason.id = return_sales.note", "left")
                ->where('return_sales.id', $id);
        $q = $this->db->get('return_sales', 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function getSalesByID($id) {
        $this->db->select("return_sales.*, sma_sale_return_reason.reason as note")
                ->join("sma_sale_return_reason", "sma_sale_return_reason.id = return_sales.note", "left")
                ->where('return_sales.sales_reference_no', $id);
        $q = $this->db->get('return_sales', 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }
    
    public function getReturnSalesByID($id) {
        $this->db->select("return_sales.*, sma_sale_return_reason.reason as note")
                ->join("sma_sale_return_reason", "sma_sale_return_reason.id = return_sales.note", "left")
                ->where('return_sales.id', $id);
        $q = $this->db->get('return_sales', 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function getReturnBySID($sale_id) {
        $q = $this->db->get_where('return_sales', array('sale_id' => $sale_id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function getProductOptionByID($id) {
        $q = $this->db->get_where('product_variants', array('id' => $id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function getPurchasedItems($product_id, $warehouse_id, $option_id = NULL) {
        $orderby = ($this->Settings->accounting_method == 1) ? 'asc' : 'desc';
        $this->db->select('id, quantity, quantity_balance, net_unit_cost, item_tax');
        $this->db->where('product_id', $product_id)->where('warehouse_id', $warehouse_id)
                ->where('quantity_balance !=', 0);
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

    public function updateOptionQuantity($option_id, $quantity) {
        if ($option = $this->getProductOptionByID($option_id)) {
            $nq = $option->quantity - $quantity;
            if ($this->db->update('product_variants', array('quantity' => $nq), array('id' => $option_id))) {
                return TRUE;
            }
        }
        return FALSE;
    }

    public function addOptionQuantity($option_id, $quantity) {
        if ($option = $this->getProductOptionByID($option_id)) {
            $nq = $option->quantity + $quantity;
            if ($this->db->update('product_variants', array('quantity' => $nq), array('id' => $option_id))) {
                return TRUE;
            }
        }
        return FALSE;
    }

    public function getProductWarehouseOptionQty($option_id, $warehouse_id) {
        $q = $this->db->get_where('warehouses_products_variants', array('option_id' => $option_id, 'warehouse_id' => $warehouse_id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function updateProductOptionQuantity($option_id, $warehouse_id, $quantity, $product_id) {
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

    public function addSale($data = array(), $items = array(), $payment = array()) {

        $cost = $this->site->costing($items);
        // $this->sma->print_arrays($cost);

        if ($this->db->insert('sales', $data)) {
            $sale_id = $this->db->insert_id();
            if ($this->site->getReference('so') == $data['reference_no']) {
                $this->site->updateReference('so');
            }
            foreach ($items as $item) {

                $item['sale_id'] = $sale_id;
                $this->db->insert('sale_items', $item);
                $sale_item_id = $this->db->insert_id();
                if ($data['sale_status'] == 'completed' && $this->site->getProductByID($item['product_id'])) {

                    $item_costs = $this->site->item_costing($item);
                    foreach ($item_costs as $item_cost) {
                        $item_cost['sale_item_id'] = $sale_item_id;
                        $item_cost['sale_id'] = $sale_id;
                        if (!isset($item_cost['pi_overselling'])) {
                            $this->db->insert('costing', $item_cost);
                        }
                    }
                }
            }

            if ($data['sale_status'] == 'completed') {
                $this->site->syncPurchaseItems($cost);
            }

            if ($data['payment_status'] == 'partial' || $data['payment_status'] == 'paid' && !empty($payment)) {
                $payment['sale_id'] = $sale_id;
                if ($payment['paid_by'] == 'gift_card') {
                    $this->db->update('gift_cards', array('balance' => $payment['gc_balance']), array('card_no' => $payment['cc_no']));
                    unset($payment['gc_balance']);
                    $this->db->insert('payments', $payment);
                } else {
                    $this->db->insert('payments', $payment);
                }
                if ($this->site->getReference('pay') == $payment['reference_no']) {
                    $this->site->updateReference('pay');
                }
                $this->site->syncSalePayments($sale_id);
            }

            $this->site->syncQuantity($sale_id);
            $this->sma->update_award_points($data['grand_total'], $data['customer_id'], $data['created_by']);
            return true;
        }

        return false;
    }

    public function updateSale($id, $data, $items = array()) {
        $this->resetSaleActions($id);

        if ($data['sale_status'] == 'completed') {
            $cost = $this->site->costing($items);
        }

        if ($this->db->update('sales', $data, array('id' => $id)) && $this->db->delete('sale_items', array('sale_id' => $id))) {

            foreach ($items as $item) {

                $item['sale_id'] = $id;
                $this->db->insert('sale_items', $item);
                $sale_item_id = $this->db->insert_id();
                if ($data['sale_status'] == 'completed' && $this->site->getProductByID($item['product_id'])) {
                    $item_costs = $this->site->item_costing($item);
                    foreach ($item_costs as $item_cost) {
                        $item_cost['sale_item_id'] = $sale_item_id;
                        $item_cost['sale_id'] = $id;
                        if (!isset($item_cost['pi_overselling'])) {
                            $this->db->insert('costing', $item_cost);
                        }
                    }
                }
            }

            if ($data['sale_status'] == 'completed') {
                $this->site->syncPurchaseItems($cost);
            }

            $this->site->syncQuantity($id);
            $this->sma->update_award_points($data['grand_total'], $data['customer_id'], $data['created_by']);
            return true;
        }
        return false;
    }

    public function deleteSale($id) {
        $sale_items = $this->resetSaleActions($id);
        if ($this->db->delete('payments', array('sale_id' => $id)) &&
                $this->db->delete('sale_items', array('sale_id' => $id)) &&
                $this->db->delete('sales', array('id' => $id))) {
            if ($return = $this->getReturnBySID($id)) {
                $this->deleteReturn($return->id);
            }
            $this->site->syncQuantity(NULL, NULL, $sale_items);
            return true;
        }
        return FALSE;
    }

    public function resetSaleActions($id) {
        $sale = $this->getInvoiceByID($id);
        $items = $this->getAllInvoiceItems($id);
        foreach ($items as $item) {

            if ($sale->sale_status == 'completed') {
                if ($costings = $this->getCostingLines($item->id, $item->product_id)) {
                    $quantity = $item->quantity;
                    foreach ($costings as $cost) {
                        if ($cost->quantity >= $quantity) {
                            $qty = $cost->quantity - $quantity;
                            $bln = $cost->quantity_balance ? $cost->quantity_balance + $quantity : $quantity;
                            $this->db->update('costing', array('quantity' => $qty, 'quantity_balance' => $bln), array('id' => $cost->id));
                            $quantity = 0;
                        } elseif ($cost->quantity < $quantity) {
                            $qty = $quantity - $cost->quantity;
                            $this->db->delete('costing', array('id' => $cost->id));
                            $quantity -= $qty;
                        }
                        if ($quantity == 0) {
                            break;
                        }
                    }
                }
                if ($item->product_type == 'combo') {
                    $combo_items = $this->site->getProductComboItems($item->product_id, $item->warehouse_id);
                    foreach ($combo_items as $combo_item) {
                        if ($combo_item->type == 'standard') {
                            $qty = ($item->quantity * $combo_item->qty);
                            $this->updatePurchaseItem(NULL, $qty, NULL, $combo_item->id, $item->warehouse_id);
                        }
                    }
                } else {
                    $option_id = isset($item->option_id) && !empty($item->option_id) ? $item->option_id : NULL;
                    $this->updatePurchaseItem(NULL, $item->quantity, $item->id, $item->product_id, $item->warehouse_id, $option_id);
                }
            }
        }
        $this->sma->update_award_points($sale->grand_total, $sale->customer_id, $sale->created_by, TRUE);
        return $items;
    }

    public function deleteReturn($id) {
        if ($this->db->delete('return_items', array('return_id' => $id)) && $this->db->delete('return_sales', array('id' => $id))) {
            return true;
        }
        return FALSE;
    }

    public function updatePurchaseItem($id, $qty, $sale_item_id, $product_id = NULL, $warehouse_id = NULL, $option_id = NULL) {
        /*echo "Sale ID ---- ".$sale_item_id;
        echo "<br>ID ---- ".$id;
        echo "<br>Pr ID ---- ".$product_id;
        echo "<br>WH iD ---- ".$warehouse_id;
        echo "<br>Opt Id --- ".$option_id;
        //echo "Purchase --- <pre>";print_r($this->getPurchaseItemByID($id));
        echo "Sale ---- <pre>";print_r($this->getSaleItemByID($sale_item_id,$product_id));*/
        //die;
        //print_r();
        if ($id) {
            //echo "if";exit;
            if ($pi = $this->getPurchaseItemByID($id)) {
                $pr = $this->site->getProductByID($pi->product_id);
                if ($pr->type == 'combo') {
                    $combo_items = $this->site->getProductComboItems($pr->id, $pi->warehouse_id);
                    foreach ($combo_items as $combo_item) {
                        if ($combo_item->type == 'standard') {
                            $cpi = $this->site->getPurchasedItem(array('product_id' => $combo_item->id, 'warehouse_id' => $pi->warehouse_id, 'option_id' => NULL));
                            $bln = $pi->quantity_balance + ($qty * $combo_item->qty);
                            $this->db->update('purchase_items', array('quantity_balance' => $bln), array('id' => $combo_item->id));
                        }
                    }
                } 
                else {
                    $newQt = $pi->quantity_balance + $qty;
                    $bln = $this->sma->formatDecimal($newQt);
                    /*$this->db->update('products', array('quantity' => $bln), array('id' => $combo_item->id));
                    $this->db->update('warehouses_products', array('quantity_balance' => $bln), array('product_id' => $combo_item->id));
                    $this->db->update('purchase_items', array('quantity_balance' => $bln), array('id' =*/
                    $this->db->update('purchase_items', array('quantity_balance' => $bln), array('id' => $pi->id));
                    $bln1 = $this->sma->formatDecimal($newQt);
                    $this->db->update('warehouses_products', array('quantity' => $bln1), array('product_id' => $pi->product_id));
                    $bln2 = $this->sma->formatDecimal($newQt);
                    $this->db->update('products', array('quantity' => $bln2), array('id' => $pi->product_id));
                }
            }
        } else {
            //echo "else";//exit;
            if ($sale_item = $this->getSaleItemByID($sale_item_id,$product_id)) {
                //echo "Sales --- <pre>";print_r($sale_item);exit;
                $option_id = isset($sale_item->option_id) && !empty($sale_item->option_id) ? $sale_item->option_id : NULL;
                $clause = array('product_id' => $sale_item->product_id, 'warehouse_id' => $sale_item->warehouse_id, 'option_id' => $option_id);
                //echo "Pr id ---- ".$sale_item->product_id;
                //echo "Purchase ---- <pre>";print_r($this->site->getPurchasedItem($clause));exit;
                if ($pi = $this->site->getPurchasedItem($clause)) {
                    //echo "<pre>";print_r($pi);
                    $newQty = $pi->quantity_balance + $qty;
                    
                    $quantity_balance1 = $this->sma->formatDecimal($newQty);//exit;
                    $this->db->update('purchase_items', array('quantity_balance' => $quantity_balance1), array('id' => $pi->id));
                    
                    $quantity_balance2 = $this->sma->formatDecimal($newQty);
                    $this->db->update('warehouses_products', array('quantity' => $quantity_balance2), array('product_id' => $pi->product_id));
                    
                    $quantity_balance3 = $this->sma->formatDecimal($newQty);//exit;
                    $this->db->update('products', array('quantity' => $quantity_balance3), array('id' => $pi->product_id));
                } else {
                    $clause['purchase_id'] = NULL;
                    $clause['transfer_id'] = NULL;
                    $clause['quantity'] = 0;
                    $clause['quantity_balance'] = $qty;
                    $this->db->insert('purchase_items', $clause);
                }
            }
            //die;
            if (!$sale_item && $product_id) {
                $pr = $this->site->getProductByID($product_id);
                $clause = array('product_id' => $product_id, 'warehouse_id' => $warehouse_id, 'option_id' => $option_id);
                if ($pr->type == 'standard') {
                    if ($pi = $this->site->getPurchasedItem($clause)) {
                        $quantity_balance = $pi->quantity_balance + $qty;
                        $this->db->update('purchase_items', array('quantity_balance' => $quantity_balance), array('id' => $pi->id));
                        $this->db->update('warehouses_products', array('quantity' => $quantity_balance), array('product_id' => $pi->product_id));
                        $this->db->update('products', array('quantity' => $quantity_balance), array('id' => $pi->product_id));
                    } else {
                        $clause['purchase_id'] = NULL;
                        $clause['transfer_id'] = NULL;
                        $clause['quantity'] = 0;
                        $clause['quantity_balance'] = $qty;
                        $this->db->insert('purchase_items', $clause);
                    }
                } 
                elseif ($pr->type == 'combo') {
                    $combo_items = $this->site->getProductComboItems($pr->id, $warehouse_id);
                    foreach ($combo_items as $combo_item) {
                        $clause = array('product_id' => $combo_item->id, 'warehouse_id' => $warehouse_id, 'option_id' => NULL);
                        if ($combo_item->type == 'standard') {
                            if ($pi = $this->site->getPurchasedItem($clause)) {
                                $quantity_balance = $pi->quantity_balance + ($qty * $combo_item->qty);
                                $this->db->update('purchase_items', array('quantity_balance' => $quantity_balance), $clause);
                            } else {
                                $clause['transfer_id'] = NULL;
                                $clause['purchase_id'] = NULL;
                                $clause['quantity'] = 0;
                                $clause['quantity_balance'] = $qty;
                                $this->db->insert('purchase_items', $clause);
                            }
                        }
                    }
                }
            }
        }
    }

    public function getPurchaseItemByID($id) {
        $q = $this->db->get_where('purchase_items', array('id' => $id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function getReturnDate($id) {
        $q = $this->db->get_where('sales', array('id' => $id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function returnSale($data = array(), $items = array(), $payment = array(),$gc_data) {
        
        /*echo "<pre>";
        print_r($items);
        echo "============================<pre>";
        print_r($data);
        echo "============================<pre>";
        print_r($payment);
        echo $gc_data;
        die;*/
        foreach ($items as $item) {
            if ($item['product_type'] == 'combo') {
                $combo_items = $this->site->getProductComboItems($item['product_id'], $item['warehouse_id']);
                foreach ($combo_items as $combo_item) {
                    if ($costings = $this->getCostingLines($item['sale_item_id'], $combo_item->id)) {
                        $quantity = $item['quantity'] * $combo_item->qty;
                        foreach ($costings as $cost) {
                            if ($cost->quantity >= $quantity) {
                                $qty = $cost->quantity - $quantity;
                                $bln = $cost->quantity_balance && $cost->quantity_balance >= $quantity ? $cost->quantity_balance - $quantity : 0;
                                $this->db->update('costing', array('quantity' => $qty, 'quantity_balance' => $bln), array('id' => $cost->id));
                                $quantity = 0;
                            } elseif ($cost->quantity < $quantity) {
                                $qty = $quantity - $cost->quantity;
                                $this->db->delete('costing', array('id' => $cost->id));
                                $quantity = $qty;
                            }
                        }
                    }
                    $this->updatePurchaseItem(NULL, ($item['quantity'] * $combo_item->qty), NULL, $combo_item->id, $item['warehouse_id']);
                }
            } else {
              $costings = $this->getCostingLines($item['sale_item_ids'], $item['product_id']);
                if (count($costings)>0) {
                    foreach ($costings as $cost) {
                        if ($cost->quantity >= $quantity) {
                            $qty = $cost->quantity - $quantity;
                            $bln = $cost->quantity_balance && $cost->quantity_balance >= $quantity ? $cost->quantity_balance - $quantity : 0;
                            $this->db->update('costing', array('quantity' => $qty, 'quantity_balance' => $bln), array('id' => $cost->id));
                            $quantity = 0;
                        } elseif ($cost->quantity < $quantity) {
                            $qty = $quantity - $cost->quantity;
                            $this->db->delete('costing', array('id' => $cost->id));
                            $quantity = $qty;
                        }
                    }
                }
                $this->updatePurchaseItem(NULL, $item['quantity'], $item['sale_item_id'], $item['product_id'], $item['warehouse_id'], $item['option_id']);
            }
        }
        $sale_items = $this->site->getAllSaleItems($data['sale_id']);

        if ($this->db->insert('return_sales', $data)) {
            $return_id = $this->db->insert_id();
            if ($this->site->getReference('re') == $data['reference_no']) {
                $this->site->updateReference('re');
            }
                               
            foreach ($items as $item) {
                $sale_item_id = $item['sale_item_ids'];
                unset($item['sale_item_ids']);
                $item['return_id'] = $return_id;
                $this->db->insert('return_items', $item);

                if ($sale_item = $this->getSaleItemByID($item['sale_item_id'],$item['product_id'])) {
                    if($sale_item->quantity == $item['quantity']) {
                        //commented to avoid sync data issues in ERP sync
                       // echo "id=>" . $item['sale_item_id'];die;
                        
                        // add extra
                        // $upd_sale_item = ;
                        if($this->db->update('sale_items', array("return_flg" => "1","return_id" => $return_id), array('id' => $sale_item_id))){
                            $remaining_items = $this->getAllInvoiceItemsRemaining($item['sale_item_id']);
                         
                            if(count($remaining_items)==0)
                                $saleRtnFlag = 1;
                            else if(count($remaining_items)<count($sale_items))
                                $saleRtnFlag = 2;
                            $this->db->update('sales', array("return_flg" => $saleRtnFlag), array('id' => $item['sale_item_id']));

                        }                        

                        //$this->db->delete('sale_items', array('id' => $item['sale_item_id']));
                    } else {
                        $nqty = $sale_item->quantity - $item['quantity'];
                        $tax = $sale_item->unit_price - $sale_item->net_unit_price;
                        $discount = $sale_item->item_discount / $sale_item->quantity;
                        $item_tax = $tax * $nqty;
                        $item_discount = $discount * $nqty;
                        $subtotal = $sale_item->unit_price * $nqty;
                        $this->db->update('sale_items', array('quantity' => $nqty, 'item_tax' => $item_tax, 'item_discount' => $item_discount, 'subtotal' => $subtotal), array('id' => $item['sale_item_id']));
                    }
                }
            }
            $this->calculateSaleTotals($data['sale_id'], $return_id, $data['surcharge']);
            if (!empty($payment)) {
                $payment['sale_id'] = $data['sale_id'];
                $payment['return_id'] = $return_id;
                $payment['register_id'] = $this->session->userdata()['register_id'];
                $this->db->insert('payments', $payment);
//                if ($this->site->getReference('pay') == $data['reference_no']) {
//                    $this->site->updateReference('pay');
//                }
                $this->site->updateReference('pay');
             //   $this->site->syncSalePayments($data['sale_id']); // commented by mridula
                //added by Chitra to map return and sales id in gift card table
                $gcData = array(
                    'gcData'=> $gc_data,
                    'sales_id' => $data['sale_id'],
                    'return_id' => $return_id,
                    'return_time' => $data['return_time']
                );
                $this->sell_gift_card($gcData);
                
            }
            $this->site->syncQuantity(NULL, NULL, $sale_items);
            return $return_id;
        }
        return false;
    }

    public function getCostingLines($sale_item_id, $product_id) {
        //echo $sale_item_id.",". $product_id;exit;
        $this->db->order_by('id', 'asc');
        $q = $this->db->get_where('costing', array('sale_item_id' => $sale_item_id, 'product_id' => $product_id));
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }
     public function getCostingLinesUpdated($sale_item_id, $product_id) {
       //echo $sale_item_id.",". $product_id;exit;
        $this->db->order_by('id', 'asc');
        $q = $this->db->get_where('costing', array('sale_id' => $sale_item_id, 'product_id' => $product_id));
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
           
            return $data;
        }
        return FALSE;
    }

    public function getSaleItemByID($id,$prId) {
        $q = $this->db->get_where('sale_items', array('sale_id' => $id, 'product_id'=>$prId), 1);
        //echo "<pre>";print_r($q->row());exit;
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function calculateSaleTotals($id, $return_id, $surcharge) {
        $sale = $this->getInvoiceByID($id);
        $items = $this->getAllInvoiceItems($id);
        if (!empty($items)) {
            $this->sma->update_award_points($sale->grand_total, $sale->customer_id, $sale->created_by, TRUE);
            $total = 0;
            $product_tax = 0;
            $order_tax = 0;
            $product_discount = 0;
            $order_discount = 0;
            $total_items = 0;
            foreach ($items as $item) {
                $total_items += $item->quantity;
                $product_tax += $item->item_tax;
                $product_discount += $item->item_discount;
                $total += $item->net_unit_cost * $item->quantity;
            }
            if ($sale->order_discount_id) {
                $percentage = '%';
                $order_discount_id = $sale->order_discount_id;
                $opos = strpos($order_discount_id, $percentage);
                if ($opos !== false) {
                    $ods = explode("%", $order_discount_id);
                    $order_discount = (($total + $product_tax) * (Float) ($ods[0])) / 100;
                } else {
                    $order_discount = $order_discount_id;
                }
            }
            if ($sale->order_tax_id) {
                $order_tax_id = $sale->order_tax_id;
                if ($order_tax_details = $this->site->getTaxRateByID($order_tax_id)) {
                    if ($order_tax_details->type == 2) {
                        $order_tax = $order_tax_details->rate;
                    }
                    if ($order_tax_details->type == 1) {
                        $order_tax = (($total + $product_tax - $order_discount) * $order_tax_details->rate) / 100;
                    }
                }
            }
            $total_discount = $order_discount + $product_discount;
            $total_tax = $product_tax + $order_tax;
            $grand_total = $total + $total_tax + $sale->shipping - $order_discount + $surcharge;
            $data = array(
                'total' => $total,
                'product_discount' => $product_discount,
                'order_discount' => $order_discount,
                'total_discount' => $total_discount,
                'product_tax' => $product_tax,
                'order_tax' => $order_tax,
                'total_tax' => $total_tax,
                'grand_total' => $grand_total,
                'total_items' => $total_items,
              //  'return_id' => $return_id,
                'surcharge' => $surcharge
            );

            if ($this->db->update('sales', $data, array('id' => $id))) {
                $this->sma->update_award_points($data['grand_total'], $sale->customer_id, $sale->created_by);
                return true;
            }
        } else {
            /* commented due to sync issue in ERP data */
            // $this->db->update('sales', array("return_flg"=>"1"),array('id' => $id));
            //$this->db->delete('sales', array('id' => $id));
            //$this->db->delete('payments', array('sale_id' => $id, 'return_id !=' => $return_id));
        }
        return FALSE;
    }

    public function getProductByName($name) {
        $q = $this->db->get_where('products', array('name' => $name), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function addDelivery($data = array()) {
        if ($this->db->insert('deliveries', $data)) {
            if ($this->site->getReference('do') == $data['do_reference_no']) {
                $this->site->updateReference('do');
            }
            return true;
        }
        return false;
    }

    public function updateDelivery($id, $data = array()) {
        if ($this->db->update('deliveries', $data, array('id' => $id))) {
            return true;
        }
        return false;
    }

    public function getDeliveryByID($id) {
        $q = $this->db->get_where('deliveries', array('id' => $id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function deleteDelivery($id) {
        if ($this->db->delete('deliveries', array('id' => $id))) {
            return true;
        }
        return FALSE;
    }

    public function getInvoicePayments($sale_id) {
        $this->db->order_by('id', 'asc');
        $q = $this->db->get_where('payments', array('sale_id' => $sale_id));
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
    }

    public function getPaymentByID($id) {
        $q = $this->db->get_where('payments', array('id' => $id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function getPaymentsForSale($sale_id) {
        $this->db->select('payments.date, payments.paid_by, payments.amount, payments.cc_no, payments.cheque_no, payments.reference_no, users.first_name, users.last_name, type')
                ->join('users', 'users.id=payments.created_by', 'left');
        $q = $this->db->get_where('payments', array('sale_id' => $sale_id));
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

    public function addPayment($data = array()) {
        if ($this->db->insert('payments', $data)) {
            if ($this->site->getReference('pay') == $data['reference_no']) {
                $this->site->updateReference('pay');
            }
            $this->site->syncSalePayments($data['sale_id']);
            if ($data['paid_by'] == 'gift_card') {
                $gc = $this->site->getGiftCardByNO($data['cc_no']);
                $this->db->update('gift_cards', array('balance' => ($gc->balance - $data['amount'])), array('card_no' => $data['cc_no']));
            }
            return true;
        }
        return false;
    }

    public function updatePayment($id, $data = array()) {
        if ($this->db->update('payments', $data, array('id' => $id))) {
            $this->site->syncSalePayments($data['sale_id']);
            return true;
        }
        return false;
    }

    public function deletePayment($id) {
        $opay = $this->getPaymentByID($id);
        if ($this->db->delete('payments', array('id' => $id))) {
            $this->site->syncSalePayments($opay->sale_id);
            return true;
        }
        return FALSE;
    }

    public function getWarehouseProductQuantity($warehouse_id, $product_id) {
        $q = $this->db->get_where('warehouses_products', array('warehouse_id' => $warehouse_id, 'product_id' => $product_id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    /* ----------------- Gift Cards --------------------- */

    public function addGiftCard($data = array(), $ca_data = array(), $sa_data = array()) {
        //echo "<pre>";print_r($data);exit;
        if ($this->db->insert('gift_cards', $data)) {
            if (!empty($ca_data)) {
                $this->db->update('companies', array('award_points' => $ca_data['points']), array('id' => $ca_data['customer']));
            } elseif (!empty($sa_data)) {
                $this->db->update('users', array('award_points' => $sa_data['points']), array('id' => $sa_data['user']));
            }
            return true;
        }
        return false;
    }

    public function updateGiftCard($id, $data = array()) {
        $this->db->where('id', $id);
        if ($this->db->update('gift_cards', $data)) {
            return true;
        }
        return false;
    }

    public function updateGiftCardReturnSale($id, $data = array()) {
        $this->db->where('id', $id);
        if ($this->db->update('gift_cards', $data)) {
            return true;
        }
        return false;
    }

    public function deleteGiftCard($id) {
        if ($this->db->delete('gift_cards', array('id' => $id))) {
            return true;
        }
        return FALSE;
    }

    /* Added by Chitra */

    function getGiftCards($cus_id, $return_id, $sale_id) {
        //echo $return_id;
        $q = $this->db
                ->select($this->db->dbprefix('gift_cards') . ".id as id, " . $this->db->dbprefix('gift_cards') . ".invoice_no, "
                        . "CONCAT(" . $this->db->dbprefix('gift_cards') . ".biller_id,"
                        //. "'/'," . $this->db->dbprefix('gift_cards') . ".year,"
                        . "'/CN/'," . $this->db->dbprefix('gift_cards') . ".card_no) as card, "
                        . "value, balance, CONCAT(" . $this->db->dbprefix('users') . ".first_name, "
                        . "' ', " . $this->db->dbprefix('users') . ".last_name) as created_by, "
                        . "customer, expiry", FALSE)
                ->join('users', 'users.id=gift_cards.created_by', 'left')
                ->where($this->db->dbprefix('gift_cards') . ".customer_id", $cus_id)
                ->where($this->db->dbprefix('gift_cards') . ".return_id", $return_id);
                //->where($this->db->dbprefix('gift_cards') . ".sales_id", $sale_id);
        $q = $this->db->get("gift_cards");
        if ($q->num_rows() > 0) {
            return $q->row();
        }
    }

    public function getPaypalSettings() {
        $q = $this->db->get_where('paypal', array('id' => 1));
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function getSkrillSettings() {
        $q = $this->db->get_where('skrill', array('id' => 1));
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function getQuoteByID($id) {
        $q = $this->db->get_where('quotes', array('id' => $id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function getAllQuoteItems($quote_id) {
        $q = $this->db->get_where('quote_items', array('quote_id' => $quote_id));
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

    public function getStaff() {
        if (!$this->Owner) {
            $this->db->where('group_id !=', 1);
        }
        $this->db->where('group_id !=', 3)->where('group_id !=', 4);
        $q = $this->db->get('users');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

    public function getProductVariantByName($name, $product_id) {
        $q = $this->db->get_where('product_variants', array('name' => $name, 'product_id' => $product_id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function getTaxRateByName($name) {
        $q = $this->db->get_where('tax_rates', array('name' => $name), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    /*
     * Added by Ajay
     * on 20-05-2016
     * This updates balance of credit voucher on return sale
     */

    public function updateCVBalanceReturnSale($cv_no, $cv_balance, $cv_value, $total) {
        $bal = $total + $cv_balance;
        if ($bal > $cv_value) {
            $g_value = $bal;
            $g_balance = $bal;
        } else {
            $g_value = $cv_value;
            $g_balance = $bal;
        }
        $data = array('value' => $g_value, 'balance' => $g_balance);
        $card_details = explode('/', $cv_no);
        $this->db->where(array('card_no' => $card_details[2], 'biller_id' => $card_details[0],
            'year' => $card_details[1]));
        $this->db->update('gift_cards', $data);
        if ($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    /*
     * Added by Ajay
     * on 15-06-2016
     * get return sale reasons
     */

    public function getSalesReturnReasons() {
        $q = $this->db->get('sale_return_reason');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

    /*
     * Added by Ajay
     * on 16-06-2016
     * update credit voucher settings
     */

    public function updateCreditVoucherSetting($data) {
        $this->db->where('pos_id', 1);
        if ($this->db->update('pos_settings', $data)) {
            return true;
        }
        return false;
    }

    /*
     * Added by Ajay
     * on 16-06-2016
     * get credit voucher settings
     */

    public function getCVSetting() {
        $q = $this->db->select('cv_expiry,cv_grace_period')->get('pos_settings');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    function sell_gift_card($giftData)
    {
        //echo "<pre>";print_r($giftData);
        /*foreach($giftData as $gift_card){
            $gcData = explode(",",$gift_card->gcData);
        }*/
        $gcData = explode(",",$giftData['gcData']);

        $this->sma->checkPermissions('gift_cards', true);
        $error = NULL;
        if (empty($gcData[0])) {
            $error = lang("value") . " " . lang("is_required");
        }
        if (empty($gcData[1])) {
            $error = lang("card_no") . " " . lang("is_required");
        }
        $customer_details = (!empty($gcData[2])) ? $this->site->getCompanyByID($gcData[2]) : NULL;
        $customer = $customer_details ? $customer_details->name : NULL;
        $biller = !empty($this->session->all_userdata()['biller_id']) ? $this->session->all_userdata()['biller_id'] : $this->site->getDefaultBiller()->default_biller;
        $card_details = explode('/',$gcData[0]);
        $data = array('card_no' => $card_details[2],
            'value' => $gcData[1],
            'customer_id' => (!empty($gcData[2])) ? $gcData[2] : NULL,
            'customer' => $customer,
            'balance' => $gcData[1],
            'expiry' => (!empty($gcData[3])) ? $gcData[3] : NULL,
            'created_by' => $this->session->userdata('user_id'),
            'biller_id'  => $card_details[0],
            'year'       => date('Y'),
            'invoice_no' => $gcData[4],
            'sales_id' => $giftData['sales_id'],
            'return_id' => $giftData['return_id'],
            'wid' => $this->session->all_userdata()['warehouse_id'], //Updated by Ankit;
            'return_time' => $giftData['return_time']
        );
        if (!$error) {
            if ($this->addGiftCard($data)) {
                return true;
              //  echo json_encode(array('result' => 'success', 'message' => lang("gift_card_added")));
            }
        } else {
            return false;
            //echo json_encode(array('result' => 'failed', 'message' => $error));
        }

    }
    
    public function getFocProductNames($term, $warehouse_id, $limit = 10) {
        // $this->db->select('products.id, barcode, code, name,unit,type, warehouses_products.quantity,
        //         price,tax_rate, tax_method, purchase_items.item_tax, purchase_items.net_unit_cost, purchase_items.tax')
        //         ->join('warehouses_products', 'warehouses_products.product_id=products.id', 'left')
        //         ->join('purchase_items', 'purchase_items.product_id=products.id', 'left')
        //         ->group_by(array('products.barcode','products.price'));
        //         //->where(array('code' => $code, "products.quantity > ",0));
        // if ($this->Settings->overselling) {
        //     $this->db->where("(name LIKE '%" . $term . "%' OR code LIKE '%" . $term . "%' OR barcode LIKE '%" . $term . "%' "
        //             . "OR  concat(name, ' (', code, ')') LIKE '%" . $term . "%')");
        // } else {
        //     $this->db->where("(products.track_quantity > 0 OR warehouses_products.quantity > 0) "
        //             . "AND warehouses_products.warehouse_id = '" . $warehouse_id . "' "
        //             . "AND (name LIKE '%" . $term . "%' OR code LIKE '%" . $term . "%' OR barcode LIKE '%" . $term . "%' " 
        //             . "OR  concat(name, ' (', code, ')') LIKE '%" . $term . "%')");
        // }
        // //products.category_id!=5 AND 
        // $this->db->limit($limit);
        // $this->db->where('warehouses_products.quantity >', 0);
        // $q = $this->db->get('products');
    
        /*$sql = "select 
                    " . $this->db->dbprefix('products') . ".id," . $this->db->dbprefix('products') . ".code," . $this->db->dbprefix('products') . ".name,
                    ".$this->db->dbprefix('products').".barcode,
                    ".$this->db->dbprefix('products').".unit,
                    ".$this->db->dbprefix('products').".type,
                    ".$this->db->dbprefix('products').".price,
                    ".$this->db->dbprefix('products').".tax_rate,
                    ".$this->db->dbprefix('products').".tax_method,
                    ".$this->db->dbprefix('warehouses_products').".quantity,
                    ".$this->db->dbprefix('purchase_items').".net_unit_cost,
                    ".$this->db->dbprefix('purchase_items') . ".item_tax,
                    ".$this->db->dbprefix('purchase_items') . ".tax,
                    min(" . $this->db->dbprefix('products') . ".lot_no) as lot_no
                    from " . $this->db->dbprefix('products') . "
                    left join " . $this->db->dbprefix('purchase_items') . " on " . $this->db->dbprefix('products') . ".id = " . $this->db->dbprefix('purchase_items') . ".product_id
                    AND left join " . $this->db->dbprefix('warehouses_products') . " on " . $this->db->dbprefix('products') . ".id = " . $this->db->dbprefix('warehouses_products') . ".product_id
                    WHERE " . $this->db->dbprefix('purchase_items') . ".warehouse_id = ".$_SESSION['warehouse_id']." AND " . $this->db->dbprefix('products') . ".category_id = ".$id." AND 
                    " . $this->db->dbprefix('products') . ".track_quantity >0 AND " . $this->db->dbprefix('warehouses_products') . ".quantity > 0
                    AND ".$this->db->dbprefix('warehouses_products').".warehouse_id = '".$warehouse_id."'
                    AND (".$this->db->dbprefix('products').".name LIKE '%".$term."' OR ".$this->db->dbprefix('products').".code LIKE '%".$term."' OR ".$this->db->dbprefix('products').".barcode LIKE '%".$term."'
                    OR concat(".$this->db->dbprefix('products').".name,'(',".$this->db->dbprefix('products').".code,')') LIKE '%".$term."'
                    group by
                    " . $this->db->dbprefix('products') . ".code,
                    " . $this->db->dbprefix('products') . ".barcode,
                    " . $this->db->dbprefix('products') . ".price,                
                    HAVING count(" . $this->db->dbprefix('purchase_items') . ".quantity_balance) > 0
                    order by " . $this->db->dbprefix('products') . ".lot_no";
        echo $sql;die; 
        $q = $this->db->query($sql);*/
        $query = "SELECT
                sma_products.id,
                sma_products.barcode,
                sma_products.code,
                sma_products.unit,
                sma_products.type,
                sma_products.name,
                sma_products.price,
                sma_products.tax_rate,
                sma_products.tax_method,
                sma_purchase_items.item_tax,
                sma_purchase_items.net_unit_cost,
                sma_purchase_items.tax,
                sma_purchase_items.unit_cost,
                SUM(sma_purchase_items.quantity_balance) AS balance,
                sma_products.lot_no,
                sma_products.cart_qty,
                sma_products.cart_count,
                sma_products.hsn,
                sma_products.promotion
              FROM
                sma_products
              LEFT JOIN
                sma_purchase_items ON sma_products.id = sma_purchase_items.product_id
              LEFT JOIN
                sma_warehouses_products ON sma_products.id = sma_warehouses_products.product_id
              WHERE
                sma_warehouses_products.warehouse_id = " . $warehouse_id . " AND(
                  NAME LIKE '%" . $term . "%' OR CODE LIKE '%" . $term . "%' OR barcode LIKE '%" . $term . "%' OR CONCAT(NAME,
                  ' (',
                  CODE,
                  ')') LIKE '%" . $term . "%'
                ) AND sma_warehouses_products.quantity > 0 AND sma_products.cart_qty=1
              ORDER BY
                sma_products.lot_no ASC,sma_products.code ASC LIMIT 20";
        $q = $this->db->query($query);
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
        
            function super_unique($array,$key)
            {

                $temp_array = array();
                foreach ($array as &$v) {
                    if (!isset($temp_array[$v[$key]]))
                        $temp_array[$v[$key]] =& $v;

                    }

                $array = array_values($temp_array);
                return $array;
            }
            $data33 = json_decode(json_encode(super_unique(json_decode(json_encode($data),true),'code')));
        

            return $data33;
    
        }
    }

    public function checkLatestCNForDate(){
//        $sql = "SELECT * FROM sma_gift_cards WHERE DATE(date)='".date('Y-m-d')."' AND balance > 0 ORDER BY id DESC Limit 1";
        $sql = "SELECT * FROM sma_gift_cards WHERE DATE(date)<='".date('Y-m-d')."' ORDER BY id DESC Limit 1";//added by rana
        $res = $this->db->query($sql);    
        if($res->num_rows() > 0){
            return $res->row();
        }
        return false;
    }
    
    public function getRedemptionDetails($gift_card_no) {
        
        $this->db->select('sma_payments.sale_id,sma_sales.reference_no,sma_sales.paid', FALSE)
                ->from('sma_payments', FALSE)
                ->join('sma_sales', 'sma_payments.sale_id = sma_sales.id', 'innner', FALSE)
                ->where("sma_payments.cc_no = '$gift_card_no'");
        $redemption_details = $this->db->get()->result();
//        $sql = "SELECT sma_payments.sale_id,sma_sales.reference_no,sma_sales.paid FROM `sma_payments` INNER JOIN sma_sales on sma_payments.sale_id = sma_sales.id where sma_payments.cc_no LIKE '$gift_card_no'";//added by rana
//        $res = $this->db->query($sql);    
        if(!empty($redemption_details)){
            return $redemption_details;
        }
        return false;
    }

}
