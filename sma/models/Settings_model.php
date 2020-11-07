<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Settings_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function updateLogo($photo)
    {
        $logo = array('logo' => $photo);
        if ($this->db->update('settings', $logo)) {
            return true;
        }
        return false;
    }

    public function updateLoginLogo($photo)
    {
        $logo = array('logo2' => $photo);
        if ($this->db->update('settings', $logo)) {
            return true;
        }
        return false;
    }

    public function getSettings()
    {
        $q = $this->db->get('settings');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function getDateFormats()
    {
        $q = $this->db->get('date_format');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

    public function updateSetting($data)
    {
        $this->db->where('setting_id', '1');
        if ($this->db->update('settings', $data)) {
            return true;
        }
        return false;
    }

    public function addTaxRate($data)
    {
        if ($this->db->insert('tax_rates', $data)) {
            return true;
        }
        return false;
    }

    public function updateTaxRate($id, $data = array())
    {
        $this->db->where('id', $id);
        if ($this->db->update('tax_rates', $data)) {
            return true;
        }
        return false;
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
        return FALSE;
    }

    public function getTaxRateByID($id)
    {
        $q = $this->db->get_where('tax_rates', array('id' => $id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function addWarehouse($data)
    {
        if ($this->db->insert('warehouses', $data)) {
            return true;
        }
        return false;
    }

    public function updateWarehouse($id, $data = array())
    {
        $this->db->where('id', $id);
        if ($this->db->update('warehouses', $data)) {
            return true;
        }
        return false;
    }

    public function getAllWarehouses()
    {
        $q = $this->db->get('warehouses');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

    public function getWarehouseByID($id)
    {
        $q = $this->db->get_where('warehouses', array('id' => $id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function deleteTaxRate($id)
    {
        if ($this->db->delete('tax_rates', array('id' => $id))) {
            return true;
        }
        return FALSE;
    }

    public function deleteInvoiceType($id)
    {
        if ($this->db->delete('invoice_types', array('id' => $id))) {
            return true;
        }
        return FALSE;
    }

    public function deleteWarehouse($id)
    {
        if ($this->db->delete('warehouses', array('id' => $id)) && $this->db->delete('warehouses_products', array('warehouse_id' => $id))) {
            return true;
        }
        return FALSE;
    }

    public function addCustomerGroup($data)
    {
        if ($this->db->insert('customer_groups', $data)) {
            return true;
        }
        return false;
    }

    public function updateCustomerGroup($id, $data = array())
    {
        $this->db->where('id', $id);
        if ($this->db->update('customer_groups', $data)) {
            return true;
        }
        return false;
    }

    public function getAllCustomerGroups()
    {
        $q = $this->db->get('customer_groups');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

    public function getCustomerGroupByID($id)
    {
        $q = $this->db->get_where('customer_groups', array('id' => $id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function deleteCustomerGroup($id)
    {
        if ($this->db->delete('customer_groups', array('id' => $id))) {
            return true;
        }
        return FALSE;
    }
    
    // Functions Modified By Anil 21-09-2016
    public function getGroups()
    { 
        $this->db->where('name =','admin');
        $this->db->or_where('name=','administrator');
        $this->db->or_where('name=','Admin');
        $this->db->or_where('name=','Administrator');
        $q = $this->db->get('groups');
        
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }
    public function getGroupsManager(){
        $this->db->where('id !=',1);
        $this->db->where('id !=',$this->session->userdata('group_id'));
        $this->db->where('name !=','admin');
        $q = $this->db->get('groups'); 
        
        if($q->num_rows() > 0){
            foreach ($q->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }
    // Function Added  By Anil 20-09-2016 
    public function getGroupsAdmin()
    {      
        $this->db->where('id !=',1);
        $this->db->where('id !=',$this->session->userdata('group_id'));
        $q = $this->db->get('groups');
        if($q->num_rows() > 0){
            foreach (($q->result()) as $row ) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    } 
    // End    

    public function getGroupByID($id)
    {
        $q = $this->db->get_where('groups', array('id' => $id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function getGroupPermissions($id)
    {
        $q = $this->db->get_where('permissions', array('group_id' => $id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function GroupPermissions($id)
    {
        $q = $this->db->get_where('permissions', array('group_id' => $id), 1);
        if ($q->num_rows() > 0) {
            return $q->result_array();
        }
        return FALSE;
    }

    public function updatePermissions($id, $data = array())
    {
        if ($this->db->update('permissions', $data, array('group_id' => $id)) && $this->db->update('users', array('show_price' => $data['products-price'], 'show_cost' => $data['products-cost']), array('group_id' => $id))) {
            return true;
        }
        return false;
    }

    public function addGroup($data, $copy)
    {
        // print_r($data); echo "<br>coppy:=><br>"; print_r($copy);die;
        $id= $copy['copyGP'];
        //echo $id; die();
        if ($this->db->insert("groups", $data)) {
                $gid = $this->db->insert_id();
                //echo $gid; die();
            if($id=='0'){
                
                $this->db->insert('permissions', array('group_id' => $gid));
                return $gid;
            }
            else{
                
                $this->db->insert('permissions', array('group_id' => $gid));
                $pid = $this->db->insert_id();
               // echo $pid; die;
                $ar= $this->CopyPermissions($id, $gid, $pid);
                //print_r($ar); die;
                $this->db->update('permissions', $ar, array('id' => $pid));
                return $gid;
                }
               
        }
        return false;
    }


    public function updateGroup($id, $data = array())
    {
        $this->db->where('id', $id);
        if ($this->db->update("groups", $data)) {
            return true;
        }
        return false;
    }


    public function getAllCurrencies()
    {
        $q = $this->db->get('currencies');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

    public function getCurrencyByID($id)
    {
        $q = $this->db->get_where('currencies', array('id' => $id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function addCurrency($data)
    {
        if ($this->db->insert("currencies", $data)) {
            return true;
        }
        return false;
    }

    public function updateCurrency($id, $data = array())
    {
        $this->db->where('id', $id);
        if ($this->db->update("currencies", $data)) {
            return true;
        }
        return false;
    }

    public function deleteCurrency($id)
    {
        if ($this->db->delete("currencies", array('id' => $id))) {
            return true;
        }
        return FALSE;
    }

    public function getAllCategories()
    {
        $q = $this->db->get("categories");
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

    public function getAllSubCategories()
    {
        $q = $this->db->get("subcategories");
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

    public function getSubcategoryDetails($id)
    {
        $this->db->select("subcategories.code as code, subcategories.name as name, categories.name as parent")
            ->join('categories', 'categories.id = subcategories.category_id', 'left')
            ->group_by('subcategories.id');
        $q = $this->db->get_where("subcategories", array('subcategories.id' => $id));
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function getSubCategoriesByCategoryID($category_id)
    {
        $q = $this->db->get_where("subcategories", array('category_id' => $category_id));
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

    public function getCategoryByID($id)
    {
        $q = $this->db->get_where("categories", array('id' => $id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function getSubCategoryByID($id)
    {
        $q = $this->db->get_where("subcategories", array('id' => $id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function addCategory($name, $code, $photo,$tax_rate)
    {
        if ($this->db->insert("categories", array('code' => $code, 'name' => $name, 'image' => $photo,'tax_rate_id'=>$tax_rate))) {
            return true;
        }
        return false;
    }

    public function addSubCategory($category, $name, $code, $photo)
    {
        if ($this->db->insert("subcategories", array('category_id' => $category, 'code' => $code, 'name' => $name, 'image' => $photo))) {
            return true;
        }
        return false;
    }

    public function updateCategory($id, $data = array(), $photo)
    {
        $categoryData = array('code' => $data['code'], 'name' => $data['name'],'tax_rate_id'=>$data['tax_rate_id']);
        if ($photo) {
            $categoryData['image'] = $photo;
        }
        $this->db->where('id', $id);
        if ($this->db->update("categories", $categoryData)) {
            return true;
        }
        return false;
    }

    public function updateSubCategory($id, $data = array(), $photo)
    {
        $categoryData = array(
            'category_id' => $data['category'],
            'code' => $data['code'],
            'name' => $data['name'],
        );
        if ($photo) {
            $categoryData['image'] = $photo;
        }
        $this->db->where('id', $id);
        if ($this->db->update("subcategories", $categoryData)) {
            return true;
        }
        return false;
    }

    public function deleteCategory($id)
    {
        if ($this->db->delete("categories", array('id' => $id))) {
            return true;
        }
        return FALSE;
    }

    public function deleteSubCategory($id)
    {
        if ($this->db->delete("subcategories", array('id' => $id))) {
            return true;
        }
        return FALSE;
    }

    public function getPaypalSettings()
    {
        $q = $this->db->get('paypal');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function updatePaypal($data)
    {
        $this->db->where('id', '1');
        if ($this->db->update('paypal', $data)) {
            return true;
        }
        return FALSE;
    }

    public function getSkrillSettings()
    {
        $q = $this->db->get('skrill');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function updateSkrill($data)
    {
        $this->db->where('id', '1');
        if ($this->db->update('skrill', $data)) {
            return true;
        }
        return FALSE;
    }

    public function checkGroupUsers($id)
    {
        $q = $this->db->get_where("users", array('group_id' => $id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function deleteGroup($id)
    {
        if ($this->db->delete('groups', array('id' => $id))) {
            return true;
        }
        return FALSE;
    }

    public function addVariant($data)
    {
        if ($this->db->insert('variants', $data)) {
            return true;
        }
        return false;
    }

    public function updateVariant($id, $data = array())
    {
        $this->db->where('id', $id);
        if ($this->db->update('variants', $data)) {
            return true;
        }
        return false;
    }

    public function getAllVariants()
    {
        $q = $this->db->get('variants');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

    public function getVariantByID($id)
    {
        $q = $this->db->get_where('variants', array('id' => $id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function deleteVariant($id)
    {
        if ($this->db->delete('variants', array('id' => $id))) {
            return true;
        }
        return FALSE;
    }
    
    /*
     * added by ajay
     * on 12-05-2016
     * to update product expiry on sma_settings
     */

    public function updateProductExpirySetting($val){
        $data = array('product_expiry'=>$val);
        $this->db->where('setting_id', 1);
        if ($this->db->update('settings', $data)) {
            return true;
        }
        return false;
    }
    
     /*
     * added by ajay
     * on 26-05-2016
     * to add till 
     */
/* All Till Functionality Comments By Anil 23-09-2016 For This Models */
    
//    public function addTill($data){	
//        if(!empty($data)){
//            if ($this->db->insert('till', $data)) {
//                return true;
//            }
//        }
//        return false;
//    }
	
	/*
	* added by ajay
	* on 27-05-2016
	* get all tills in batch
	*/
	
//	public function getAllTills(){
//		$q = $this->db->get('till');
//        if ($q->num_rows() > 0) {
//            foreach (($q->result()) as $row) {
//                $data[] = $row;
//            }
//            return $data;
//        }
//        return FALSE;
//	}
	
	/*
	* added by ajay
	* on 27-05-2016
	* update tills in batch
	*/
	
//	public function updateTills($data){
//		$c = 1;
//		$assigned_tills = array();
//		$i = 0;
//		foreach($data as $val){
//			$is_user_assigned_till = $this->isUserAssignedToTill($val);
//		
//			if(!$is_user_assigned_till){
//				$this->db->where('id',$val['id']);
//				$this->db->update('till',array('user_id'=>$val['user_id'],'store_id'=>$val['store_id'])); 
//				if($this->db->affected_rows() > 0){
//					$c += $this->db->affected_rows();
//				}
//			}else{
//				$assigned_tills[$i]['id'] = $val['id'];
//				$assigned_tills[$i]['user_id'] = $val['user_id'];
//				$assigned_tills[$i]['store_id'] = $val['store_id'];
//			}		
//			$i++;
//		}
//		return array($c,$assigned_tills);
//	}
	
	/*
	* added by ajay
	* on 27-05-2016
	* update Single till
	*/
	
//	public function updateSingleTill($data){		
//			$this->db->where('id',$data['id']);
//			if(!empty($this->session->all_userdata()['warehouse_id'])){
//				$store_id = $this->session->all_userdata()['warehouse_id'];
//			}else{
//				$store_id = 0;
//			}
//			$this->db->update('till',array('user_id'=>$data['user_id'],'store_id'=>$store_id)); 
//			if($this->db->affected_rows() > 0){
//				$c = $this->db->affected_rows();
//			}
//			return $c;
//	}
	
	/*
	* added by ajay
	* on 27-05-2016
	* check if user assigned to till
	*/
	
//	public function isUserAssignedToTill($data){
//		$this->db->select('id');
//		if(!empty($this->session->all_userdata()['warehouse_id'])){
//				$store_id = $this->session->all_userdata()['warehouse_id'];
//		}else{
//				$store_id = 0;
//		}
//		$this->db->where(array('user_id'=>$data['user_id'],'store_id'=>$store_id));
//		$query = $this->db->get('till');
//		if($query->num_rows() > 0){
//			return true;
//		}else{
//			return false;
//		}
//	}
        
        // Add By Ankit
    public function getGroup(){
        $w= "SELECT id,name FROM `sma_groups` WHERE name!='owner' AND name!='admin'";
        $q = $this->db->query($w);
        if ($q->result() > 0) {
            $data[] = $q->result();
           }
        foreach($data[0] as $key => $value)
         {
         $data[$key] = (array) $value;
         }   
    
        
        return $data;
                
    }
 
 
 
/*
     * added by Ankit
     * on 10-05-2016
     * to copy group permissions
     */
    
    function CopyPermissions($id, $gid, $pid) {
        //echo "id=>".$id."==gid=>".$gid."==pid=>".$pid."<br>";
        $q = $this->db->get_where('permissions', array('group_id' => $id), 1);
             if ($q->num_rows() > 0) {
                 $ar[]= $q->row();
        }
        //print_r($ar);die;
        if($ar){
        foreach($ar as $k){
            $k->id=$pid;
            $k->group_id=$gid;
        }
        return $k;
        }
        return FALSE;
     }
 
}
