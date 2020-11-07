<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Companies_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }

    public function getAllBillerCompanies() {
        $q = $this->db->get_where('companies', array('group_name' => 'biller'));
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

    public function getAllCustomerCompanies() {
        $q = $this->db->get_where('companies', array('group_name' => 'customer'));
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

    public function getAllSupplierCompanies() {
        $q = $this->db->get_where('companies', array('group_name' => 'supplier'));
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

    public function getAllCustomerGroups() {
        $q = $this->db->get('customer_groups');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

    public function getCompanyUsers($company_id) {
        $q = $this->db->get_where('users', array('company_id' => $company_id));
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

    public function getCompanyByID($id) {
        $q = $this->db->get_where('companies', array('id' => $id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function getEmailCount($email) {
        $q = $this->db->get_where('companies', array('email' => $email));
        // if ($q->num_rows() > 0) {
        return $q->num_rows();
        // }
        return FALSE;
    }

    public function getCompanyByEmail($email) {
        $q = $this->db->get_where('companies', array('email' => $email), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function addCompany($data = array()) {
        $cus = $this->db->insert('companies', $data);
        if (!empty($cus)) {
            $cid = $this->db->insert_id();
            return $cid;
        }
        return false;
    }

    public function updateCompany($id, $data = array()) {
        //echo "<pre>";echo $id; print_r($data);die;
        if ($this->db->where(array('id' => $id))->update('companies', $data)) {
            return true;
        }
        return false;
    }

    public function addCompanies($data = array()) {
        if ($this->db->insert_batch('companies', $data)) {
            return true;
        }
        return false;
    }

    public function deleteCustomer($id) {
        if ($this->getCustomerSales($id)) {
            return false;
        }
        if ($this->db->delete('companies', array('id' => $id, 'group_name' => 'customer')) && $this->db->delete('users', array('company_id' => $id))) {
            return true;
        }
        return FALSE;
    }

    public function deleteSupplier($id) {
        if ($this->getSupplierPurchases($id)) {
            return false;
        }
        if ($this->db->delete('companies', array('id' => $id, 'group_name' => 'supplier')) && $this->db->delete('users', array('company_id' => $id))) {
            return true;
        }
        return FALSE;
    }

    public function deleteBiller($id) {
        if ($this->getBillerSales($id)) {
            return false;
        }
        if ($this->db->delete('companies', array('id' => $id, 'group_name' => 'biller'))) {
            return true;
        }
        return FALSE;
    }

    public function getBillerSuggestions($term, $limit = 10) {
        $this->db->select("id, company as text");
        $this->db->where(" (id LIKE '%" . $term . "%' OR name LIKE '%" . $term . "%' OR company LIKE '%" . $term . "%') ");
        $q = $this->db->get_where('companies', array('group_name' => 'biller'), $limit);
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }

            return $data;
        }
    }

    public function getCustomerSuggestions($term, $limit = 10) {
        //$this->db->select("id, CONCAT(company, ' (', name,phone')') as text", FALSE);
        $this->db->select("id,CONCAT((name),(' '), (lname),(' '),('('),(phone),(')')) as text");
        $this->db->where(" (name LIKE '%" . $term . "%' OR phone LIKE '%" . $term . "%') ");
        //$q = $this->db->get_where('companies', array('group_name' => 'customer'), $limit);
        $q = $this->db->where(array('group_name' => 'customer', 'type' => 0, 'org_id' => $_SESSION['org_id']))->order_by("name", "asc")->get('companies');

        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }

            return $data;
        }
    }

    public function getSupplierSuggestions($term, $limit = 10) {
        $this->db->select("id, CONCAT(company, ' (', name, ')') as text", FALSE);
        $this->db->where(" (id LIKE '%" . $term . "%' OR name LIKE '%" . $term . "%' OR company LIKE '%" . $term . "%' OR email LIKE '%" . $term . "%' OR phone LIKE '%" . $term . "%') ");
        $q = $this->db->get_where('companies', array('group_name' => 'supplier'), $limit);
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }

            return $data;
        }
    }

    public function getCustomerSales($id) {
        $this->db->where('customer_id', $id)->from('sales');
        return $this->db->count_all_results();
    }

    public function getBillerSales($id) {
        $this->db->where('biller_id', $id)->from('sales');
        return $this->db->count_all_results();
    }

    public function getSupplierPurchases($id) {
        $this->db->where('supplier_id', $id)->from('purchases');
        return $this->db->count_all_results();
    }

    /* Added by Ankit
     * on 23-06-2016
     * To check Mobile Number Validation at time of add customer
     */

    public function getCompanyByPhone($phone) {
        $this->db->select('phone,type');
        $this->db->where('phone', $phone);
        $this->db->where('type', '0');
        $q = $this->db->get('companies');
        if ($q->num_rows() > 0) {
            return TRUE;
        }
        return FALSE;
    }

    /* Added by Ankit
     * on 23-06-2016
     * To check Mobile Number Validation at time of add customer
     */

    public function getCompanyByPhoneForEdit($phone, $id) {
        $this->db->select('phone,type');
        $this->db->where('phone', $phone);
        $this->db->where('type', '0');
        $this->db->where('id!=', $id);
        $q = $this->db->get('companies');
        if ($q->num_rows() > 0) {
            $a = 1;
            return $a;
        }
        return FALSE;
    }

//***** Added By Anil 12-09-2016 Start ******   
    public function getCountryList() {
        $this->db->select('*');
        $this->db->order_by("country_default", "DESC");
        $q = $this->db->get('country');

        return $q->result();
    }

    function getStateList_Default() {
        $this->db->select('*');
        $this->db->where('country_id', '99');
        $this->db->order_by("default", "DESC");
        $q = $this->db->get('state');
        return $q->result();
    }

    function getStateList($country_id) {
        $this->db->select('*');
        $this->db->where('country_id', $country_id);

        $q = $this->db->get('state');
        return $q->result();
    }

//***** Added By Anil 12-09-2016 End ******     
    /* Added by Ajay
     * on 01-12-2016
     * To check Email Address Validation at time of add customer
     */
    public function getCompanyByEmailForUniqueness($email) {
//       $this->db->select('email');
//       $this->db->where('email', $email);
//       //$this->db->where('type', '0');
//       $q = $this->db->get('companies');
//       if ($q->num_rows() > 0) {
//            return FALSE;
//        }
        $q = "Select email from sma_companies where email = '" . $email . "'";
        $a = $this->db->query($q);
        if (!empty($a->result())) {
            return 1;
        }
        return 0;
    }

    public function getCompanyByPhoneForUniqueness($phone, $name = NULL) {
        //$this->db->select('phone');
        //$this->db->where('phone', $phone);
        //$this->db->where('type', '0');
        //$q = $this->db->get('companies');
        $q = "select phone from sma_companies where phone = '" . $phone . "' AND name = '" . $name . "'";
        $a = $this->db->query($q);
        if (!empty($a->result())) {
            return 1;
        }
//       if ($q->num_rows() > 0) {
//            return TRUE;
//        }
        return 0;
    }

    /* Added by Ajay
     * on 01-12-2016
     * To check Mobile Number Validation at time of add customer
     *
      public function getCompanyByPhoneForUniqueness($phone)
      {
      $this->db->select('phone,type');
      $this->db->where('phone', $phone);
      $this->db->where('type', '0');
      $q = $this->db->get('companies');
      if($q->num_rows() > 0) {
      return 1;
      }
      else{
      return 0;
      }

      } */

    //Added by Chitra to validate phone and email on edit customer
    function check_all_phones($phone, $name, $cust_id) {
        if ($cust_id == NULL) {
            $this->db->where('phone', $phone);
            $this->db->where('name', $name);
            $query = $this->db->get('companies');
            if ($query->num_rows() > 0) {
                return 1;
            } else {
                return 0;
            }
        } else {
            $this->db->where('name', $name);
            $this->db->where('phone', $phone);
            $this->db->where(array('id !=' => $cust_id));
            $query = $this->db->get('companies');
            if ($query->num_rows() > 0) {
                return 1;
            } else {
                return 0;
            }
        }
    }

    /* Added by Ajay
     * on 
     */

    function check_all_emails($email, $cust_id) {
        if ($cust_id == '') {
            $this->db->where('email', $email);
            $query = $this->db->get('companies');
            if ($query->num_rows() > 0) {
                return TRUE;
            } else {
                return FALSE;
            }
        } else {
            $this->db->where('email', $email);
            $this->db->where(array('id !=' => $cust_id));

            $query = $this->db->get('companies');
            if ($query->num_rows() > 0) {
                return TRUE;
            } else {
                return FALSE;
            }
        }
    }

}
