<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class multipledb
{ 
    
    var $db = NULL;
   public function __construct()
    {
        $CI = &get_instance();
        $this->db2 = $CI->load->database('db2', TRUE);

      }
public function write_log() { //here overriding
        if ($this->_enabled === FALSE)
        {
        return FALSE;
        }

        $level = strtoupper($level);

        if ( ! isset($this->_levels[$level]) OR
        ($this->_levels[$level] > $this->_threshold))
        {
        return FALSE;
        }

        /* HERE YOUR LOG FILENAME YOU CAN CHANGE ITS NAME */
        $filepath = $this->_log_path.'log-'.date('Y-m-d').EXT;
        $message  = '';

        if ( ! file_exists($filepath))
        {
        $message .= "<"."?php  if ( ! defined('BASEPATH'))
        exit('No direct script access allowed'); ?".">\n\n";
        }

        if ( ! $fp = @fopen($filepath, FOPEN_WRITE_CREATE))
        {
        return FALSE;
        }

        $message .= $level.' '.(($level == 'INFO') ? ' -' : '-').' ';
        $message .= date($this->_date_fmt). ' --> '.$msg."\n";

        flock($fp, LOCK_EX);
        fwrite($fp, $message);
        flock($fp, LOCK_UN);
        fclose($fp);

        @chmod($filepath, FILE_WRITE_MODE);
        return TRUE;
    }    
public function getInfo($w)
  {
    $q = $this->db2->query($w);
    if ($q->result() > 0) {
            $data[] = $q->result();
            return $data;
           }
        return FALSE;
  }
 
public function import_user_info(){
     $n = '$';
     $w="SELECT * FROM intrm".$n."usr WHERE POS_USR_ID IS NULL OR POS_USR_ID = ''";
     $records = $this->getInfo($w);
    if($records){
        for($i=0;$i<count($records[0]);$i++) {
             $data[$i] = array(
                'usr_id' => $records[0][$i]->USR_ID, 
                'username' => $records[0][$i]->USR_NAME,  
                'password' => sha1($records[0][$i]->USR_PWD),
                'salt' => 'Null',
                'email'=> 'Null',
                'first_name' => $records[0][$i]->USR_FST_NAME,//substr($records[0][$i]->USR_NAME, 4),
                'last_name' => $records[0][$i]->USR_LST_NAME,
                'active' => $records[0][$i]->USR_ACTV,
                'avatar' => $records[0][$i]->USR_IMG,
                'gender' => $records[0][$i]->USR_GNDR,
                'phone' => $records[0][$i]->USR_CONTACT_NO,
                'created_on' => time($records[0][$i]->USR_ID_CREATE_DT),
                'company' => 'Swatch Group',
                'group_id'=> 5,
                'warehouse_id'=>1,
                'biller_id' =>4,
                'show_discount'=> $records[0][$i]->USR_DISC
             );

            $s = $records[0][$i]->USR_ACTV;
                 if($s =='Y'){
                    $p= '1';}
                 else{$p = '0';}  
                $data[$i]['active'] = $p;

    }
        
        return $data;
      }
        return false;
        }


public function get_userTableDelFLG(){
    $n = '$';
    $q = $this->db2->query("SELECT POS_USR_ID FROM intrm".$n."usr WHERE DEL_FLG= '1'");      
        if ($q->result() > 0) {
            foreach (($q->result()) as $row) {
                  $data[] = $row;
            }
            for($i=0;$i<count($data);$i++) {
            $ar[$i] = $data[$i]->POS_USR_ID;
             
           }
            return $ar;
        }
        return FALSE;
}
public function userTableUpdate(){
    $n = '$';
    $w= "SELECT * FROM intrm".$n."usr WHERE UPD_FLG= '1'";
    $records= $this->getInfo($w);
    if($records){
        for($i=0;$i<count($records[0]);$i++) {
            $data[$i] = array(
                'usr_id' => $records[0][$i]->USR_ID, 
                'username' => $records[0][$i]->USR_NAME,  
                'password' => sha1($records[0][$i]->USR_PWD),
                'salt' => 'Null',
                'email'=> 'Null',
                'first_name' => $records[0][$i]->USR_FST_NAME,//substr($records[0][$i]->USR_NAME, 4),
                'last_name' => $records[0][$i]->USR_LST_NAME,
                'active' => $records[0][$i]->USR_ACTV,
                'avatar' => $records[0][$i]->USR_IMG,
                'gender' => $records[0][$i]->USR_GNDR,
                'phone' => $records[0][$i]->USR_CONTACT_NO,
                'created_on' => time($records[0][$i]->USR_ID_CREATE_DT),
                'company' => 'Swatch Group',
                'group_id'=> 5,
                'warehouse_id'=>2,
                'biller_id' =>4,
                'show_discount'=> $records[0][$i]->USR_DISC,
                'id'=> $records[0][$i]->USR_ID
             );

            $s = $records[0][$i]->USR_ACTV;
                 if($s =='Y'){
                    $p= '1';}
                 else{$p = '0';}  
                $data[$i]['active'] = $p;
           }
        
        return $data;
      }
     return false; 
  }

 public function import_warehouse_categories_info(){
    $n = '$';
    $w= "SELECT GRP_ID, GRP_NM FROM intrm".$n."itm".$n."grp WHERE POS_GRP_ID IS NULL OR POS_GRP_ID = ''"; 
    $records = $this->getInfo($w);
    //print_r($records);die;
    if($records){
        for($i=0;$i<count($records[0]);$i++) {
            $data[$i] = array(
                'code' => $records[0][$i]->GRP_ID,
                'name'=>$records[0][$i]->GRP_NM,
                
                );
          }
            return $data;
      }
        return false;
        }

public function categoryTableUpdate(){
    $n = '$';
   // $w= "SELECT * FROM intrm".$n."itm".$n."grp".$n."org WHERE UPD_FLG= '1'";
    $w= "select a.GRP_ID, a.GRP_NM, a.POS_GRP_ID from intrm".$n."itm".$n."grp a JOIN intrm".$n."itm".$n."grp".$n."org b ON b.GRP_ID=a.GRP_ID WHERE b.UPD_FLG='1'";
    $records= $this->getInfo($w);
     if($records){
        for($i=0;$i<count($records[0]);$i++) {
            $data[$i] = array(
                'code' => $records[0][$i]->GRP_ID,
                'name'=>$records[0][$i]->GRP_NM,
                'id'=> $records[0][$i]->POS_GRP_ID
             );
        }
        return $data;
      }
     return false; 
  }

 public function import_tax_rate_info(){
    $n = '$';
    $w= "SELECT ORG_ID, GRP_ID, TAX_VAL FROM intrm".$n."itm".$n."grp".$n."org WHERE POS_GRP_ID IS NULL OR POS_GRP_ID = ''"; 
    $records = $this->getInfo($w);
    if($records){
        for($i=0;$i<count($records[0]);$i++) {
            $data[$i] = array(
                'name' => $records[0][$i]->TAX_VAL.'% TAX',
                'rate' => $records[0][$i]->TAX_VAL,
                'org_id' => $records[0][$i]->ORG_ID,
                'grp_id' => $records[0][$i]->GRP_ID,
                
                
                );
          }
            return $data;
      }
        return false;
        } 
public function import_tax_rate_UPD(){
    $n = '$';
    $w= "SELECT POS_GRP_ID, ORG_ID, GRP_ID, TAX_VAL FROM intrm".$n."itm".$n."grp".$n."org WHERE UPD_FLG='1'"; 
    $records = $this->getInfo($w);
    if($records){
        for($i=0;$i<count($records[0]);$i++) {
            $data[$i] = array(
                'name' => $records[0][$i]->TAX_VAL.'% TAX',
                'rate' => $records[0][$i]->TAX_VAL,
                'org_id' => $records[0][$i]->ORG_ID,
                'grp_id' => $records[0][$i]->GRP_ID,
                'id'=> $records[0][$i]->POS_GRP_ID,
                
                
                );
          }
            return $data;
      }
        return false;
        }                       
  
public function import_Currency_info(){
     $n = '$';
     $w= "SELECT * FROM intrm".$n."curr WHERE POS_CURR_ID IS NULL OR POS_CURR_ID = ''";
     $records = $this->getInfo($w);
     if($records){
        for($i=0;$i<count($records[0]);$i++) {
            $data[$i] = array(
                'code' => $records[0][$i]->CURR_NOTATION,
                'name' => $records[0][$i]->CURR_NM,
                'rate' => 1,
                'curr_id' => $records[0][$i]->CURR_ID
                );
             }
        return $data;
      }
        return false;
        }  
public function get_currencyTableDelFLG(){
    $n = '$';
    $q = $this->db2->query("SELECT POS_CURR_ID FROM intrm".$n."curr WHERE DEL_FLG= '1'");      
        if ($q->result() > 0) {
            foreach (($q->result()) as $row) {
                  $data[] = $row;
            }
            for($i=0;$i<count($data);$i++) {
            $ar[$i] = $data[$i]->POS_CURR_ID;
             
           }
            return $ar;
        }
        return FALSE;
}
public function currencyTableUpdate(){
    $n = '$';
    $w= "SELECT * FROM intrm".$n."curr WHERE UPD_FLG= '1'";
    $records= $this->getInfo($w);
     if($records){
        for($i=0;$i<count($records[0]);$i++) {
            $data[$i] = array(
                'code' => $records[0][$i]->CURR_NOTATION,
                'name' => $records[0][$i]->CURR_NM,
                'rate' => 1,
                'curr_id' => $records[0][$i]->CURR_ID,
                'id'=> $records[0][$i]->POS_CURR_ID
             );
        }
        return $data;
      }
     return false; 
  }


public function import_eo_catg_info(){
    $n = '$';
    $w= "SELECT * FROM intrm".$n."eo".$n."catg WHERE POS_EO_CATG_ID IS NULL OR POS_EO_CATG_ID = ''";
    $records = $this->getInfo($w);
    if($records){
        for($i=0;$i<count($records[0]);$i++) {
            $data[$i] = array(
                
                'name' => $records[0][$i]->CATG_NM,
                'description'=>$records[0][$i]->CATG_NM   //$records[$i]->EO_TYPE  
                );

            }
        
        return $data;
      }
        return false;
        }   
        
public function get_EOCatgTableDelFLG(){
    $n = '$';
    $q = $this->db2->query("SELECT POS_EO_CATG_ID FROM intrm".$n."eo".$n."catg WHERE DEL_FLG= '1'");      
        if ($q->result() > 0) {
            foreach (($q->result()) as $row) {
                  $data[] = $row;
            }
            for($i=0;$i<count($data);$i++) {
            $ar[$i] = $data[$i]->POS_EO_CATG_ID;
             
           }
            return $ar;
        }
        return FALSE;
} 
public function eoCatgTableUpdate(){
    $n = '$';
    $w= "SELECT * FROM intrm".$n."eo".$n."catg WHERE UPD_FLG= '1'";
    $records= $this->getInfo($w);
    if($records){
        for($i=0;$i<count($records[0]);$i++) {
            $data[$i] = array(
                'name' => $records[0][$i]->CATG_NM,
                'description'=> $records[0][$i]->CATG_NM,  //  $records[$i]->EO_TYPE,  
                'id'=> $records[0][$i]->POS_EO_CATG_ID
             );
        }
        return $data;
      }
     return false; 
  }
public function import_store_info(){
    $n = '$';
    $w= "SELECT ORG_ID,ORG_DESC, ORG_COUNTRY_ID FROM intrm".$n."org WHERE POS_ORG_ID IS NULL OR POS_ORG_ID = ''"; 
    $records = $this->getInfo($w);
    //print_r($records);die;
    if($records){
      for($i=0;$i<count($records[0]);$i++) {
            $data[$i] = array(
                
                'code' => $records[0][$i]->ORG_ID,
                'name' => $records[0][$i]->ORG_DESC,
                'address'=>$this->getCountryName($records[0][$i]->ORG_COUNTRY_ID),
                'org_id'=> $records[0][$i]->ORG_ID
                );
            }
            return $data;
         }
        return false;
        }  

public function import_biller_store_info(){
    $n = '$';
    $w= "SELECT ORG_ID,ORG_DESC, ORG_COUNTRY_ID FROM intrm".$n."org WHERE ORG_ID!='01' AND POS_ORG_ID IS NULL OR POS_ORG_ID = '' "; 
    $records = $this->getInfo($w);
    //print_r($records);die;
    if($records){
      for($i=0;$i<count($records[0]);$i++) {
            $data[$i] = array(
                
                 
                'group_name'=>'biller',//$this->getGroupsName($records[0][$i]->EO_CATG_ID),
                'name'=>$records[0][$i]->ORG_DESC,
                'company'=>$records[0][$i]->ORG_DESC,
                'phone'=> '0123456789',
                //'address'=>$this->getAddress($records[0][$i]->ORG_ID),
                'country'=>$this->getCountryName($records[0][$i]->ORG_COUNTRY_ID)
               );
            }
            return $data;
         }
        return false;
        } 

public function getCountryName($id){
    $n = '$';
    $q = $this->db2->query("SELECT CNTRY_DESC FROM intrm".$n."cntry WHERE CNTRY_ID='$id'");
        if ($q->result() > 0) {
            foreach (($q->result()) as $row) {
                  $data[] = $row;
            }
            return $data[0]->CNTRY_DESC;
        }
        return FALSE;
    
}
public function import_company_info(){
     $n = '$';
     $w= "SELECT * FROM intrm".$n."eo WHERE EO_TYPE='C' AND POS_EO_ID IS NULL OR POS_EO_ID = ''";
     $records = $this->getInfo($w);
     if($records){
        for($i=0;$i<count($records[0]);$i++) {
            $data[$i] = array(
                'group_id' => '3', //$records[0][$i]->EO_CATG_ID,
                'group_name'=>'customer',//$this->getGroupsName($records[0][$i]->EO_CATG_ID),
                'customer_group_id'=>1,
                'customer_group_name'=>'General',
                'name'=>$records[0][$i]->EO_NM,
                'company'=>'Swatch Group',
                'phone' => '9999999999',
                'email'=> 'Not Available',
                'vat_no'=>$records[0][$i]->VAT_NO,
                'address'=>$this->getAddress($records[0][$i]->EO_ID),
                'country'=>$this->getCountryName($records[0][$i]->EO_CNTRY_ID),
                'eo_type' => $records[0][$i]->EO_TYPE,
                'eo_id' => $records[0][$i]->EO_ID
                );
             }
        return $data;
      }
        return false;
        }  
public function get_CompanyTableDelFLG(){
    $n = '$';
    $q = $this->db2->query("SELECT POS_EO_ID FROM intrm".$n."eo".$n."add".$n."org WHERE DEL_FLG= '1'");      
        if ($q->result() > 0) {
            foreach (($q->result()) as $row) {
                  $data[] = $row;
            }
            for($i=0;$i<count($data);$i++) {
            $ar[$i] = $data[$i]->POS_EO_CATG_ID;
             
           }
            return $ar;
        }
        return FALSE;
} 
 
public function companyTableUpdate(){

    $n = '$';
   $w= "select a.EO_ID, a.EO_NM, a.VAT_NO, a.EO_TYPE, a.EO_CNTRY_ID from intrm".$n."eo a JOIN intrm".$n."eo".$n."org b ON b.EO_ID=a.EO_ID WHERE b.UPD_FLG='1'";
    $records= $this->getInfo($w);
    if($records){
        for($i=0;$i<count($records[0]);$i++) {
            $data[$i] = array(
                'group_id' => '3', //$records[0][$i]->EO_CATG_ID,
                'group_name'=>'customer',//$this->getGroupsName($records[0][$i]->EO_CATG_ID),
                'customer_group_id'=>1,
                'customer_group_name'=>'General',
                'name'=>$records[0][$i]->EO_NM,
                'company'=>'Swatch Group',
                'phone' => '9999999999',
                'email'=> 'Not Available',
                'vat_no'=>$records[0][$i]->VAT_NO,
                'address'=>$this->getAddress($records[0][$i]->EO_ID),
                'country'=>$this->getCountryName($records[0][$i]->EO_CNTRY_ID),
                'eo_type' => $records[0][$i]->EO_TYPE,
                'eo_id' => $records[0][$i]->EO_ID,
                'id'=> $records[0][$i]->EO_ID
             );

            }
        
        return $data;
      }
     return false; 


}        
        
function stdToArray($ar){
    
    foreach($ar as $key => $value)
    {
     $ar[$key] = (array) $value;
    }
  
    return $ar;
    
}

public function getGroupsName($id){
    $n = '$';
    $q = $this->db2->query("SELECT CATG_NM FROM intrm".$n."eo".$n."catg WHERE EO_CATG_ID='$id'");
        if ($q->result() > 0) {
            foreach (($q->result()) as $row) {
                  $data[] = $row;
            }
            return $data[0]->CATG_NM;
        }
        return FALSE;
    
}

 
public function getAddress($id){
    $n = '$';
    $q = $this->db2->query("SELECT ADDRESS FROM intrm".$n."eo".$n."add WHERE EO_ID='$id'");
        if ($q->result() > 0) {
            foreach (($q->result()) as $row) {
                  $data[] = $row;
            }
            return $data[0]->ADDRESS;
        }
        return FALSE;
    
}
public function getCountryId($str){
    $n = '$';
    $q = $this->db2->query("SELECT CNTRY_ID FROM intrm".$n."cntry WHERE CNTRY_DESC='$str'");
        if ($q->result() > 0) {
            foreach (($q->result()) as $row) {
                  $data[] = $row;
            }
            return $data[0]->CNTRY_ID;
        }
        return FALSE;
    
}
public function getQuantity($id){
    $n = '$';
    $q = $this->db2->query("SELECT UOM_SLS FROM intrm".$n."prod WHERE ITM_ID='$id'");
        if ($q->result() > 0) {
            foreach (($q->result()) as $row) {
                  $data[] = $row;
            }
            return $data[0]->UOM_SLS;
        }
        return FALSE;
    
}
public function getCategory($id){
    $n = '$';
    $q = $this->db2->query("SELECT GRP_NM FROM intrm".$n."itm".$n."grp WHERE GRP_ID='$id'");
        if ($q->result() > 0) {
            foreach (($q->result()) as $row) {
                  $data[] = $row;
            }
            return $data[0]->GRP_NM;
        }
        return FALSE;

}
public function getPrice($id, $org){ 
    $n = '$';
    $q = $this->db2->query("SELECT PRICE_SLS FROM intrm".$n."itm".$n."stock".$n."dtl WHERE ITM_ID='$id' AND ORG_ID='$org'");
        if ($q->result() > 0) {
            foreach (($q->result()) as $row) {
                  $data[] = $row;
            }
            return $data[0]->PRICE_SLS;
        }
        return FALSE;

}
public function getBasicPrice($id, $org){ 
    $n = '$';
    $q = $this->db2->query("SELECT UOM_BASIC FROM intrm".$n."itm".$n."stock".$n."dtl WHERE ITM_ID='$id' AND ORG_ID='$org'");
        if ($q->result() > 0) {
            foreach (($q->result()) as $row) {
                  $data[] = $row;
            }
            return $data[0]->UOM_BASIC;
        }
        return FALSE;

}
public function getQty($id, $org){ 
    $n = '$';
    $q = $this->db2->query("SELECT AVAIL_QTY FROM intrm".$n."itm".$n."stock".$n."dtl WHERE ITM_ID='$id' AND ORG_ID='$org'");
        if ($q->result() > 0) {
            foreach (($q->result()) as $row) {
                  $data[] = $row;
            }
            return $data[0]->AVAIL_QTY;
        }
        return FALSE;

}
public function getLOTNo($id, $org){ 
    $n = '$';
    $q = $this->db2->query("SELECT LOT_NO FROM intrm".$n."itm".$n."stock".$n."dtl WHERE ITM_ID='$id' AND ORG_ID='$org'");
        if ($q->result() > 0) {
            foreach (($q->result()) as $row) {
                  $data[] = $row;
            }
            return $data[0]->LOT_NO;
        }
        return FALSE;

}
public function getSR_No($id, $org){ 
    $n = '$';
    $q = $this->db2->query("SELECT SR_NO FROM intrm".$n."itm".$n."stock".$n."dtl WHERE ITM_ID='$id' AND ORG_ID='$org'");
        if ($q->result() > 0) {
            foreach (($q->result()) as $row) {
                  $data[] = $row;
            }
            return $data[0]->SR_NO;
        }
        return FALSE;

}
public function getCat($id){
      $q = $this->db->query("SELECT id FROM sma_categories WHERE code='$id'");
        if ($q->result() > 0) {
            foreach (($q->result()) as $row) {
                  $data[] = $row;
            }
            return $data[0]->id;
        }
        return FALSE;

}
public function getTax($gid, $org){ 
    $n = '$';
    $q = $this->db2->query("SELECT TAX_VAL FROM intrm".$n."itm".$n."grp".$n."org WHERE GRP_ID='$gid' AND ORG_ID='$org'");
        if ($q->result() > 0) {
            foreach (($q->result()) as $row) {
                  $data[] = $row;
            }
            return $data[0]->TAX_VAL;
        }
        return FALSE;

}
public function getORG(){ 
    $n = '$';
    $q = $this->db2->query("SELECT DISTINCT ORG_ID FROM intrm".$n."itm".$n."grp".$n."org ");
        if ($q->result() > 0) {
            foreach (($q->result()) as $row) {
                  $data[] = $row;
            }
            return $data;
        }
        return FALSE;

}

public function sync_into_intermediate_usertable($data){    
       $n='$'; 
       $as= 'intrm'.$n.'usr';
       if($this->db2->insert_batch($as, $data)){
            $m= "User Details Sync Successfully....";
            return $m;
        }
        else{
            $m= "User Details Not Sync....";
            return $m;
        }
}
public function sync_into_intermediate_eotable($data, $ar){    
       $n='$'; 
       static $s=0;
       $as= 'intrm'.$n.'eo';
       $eoAdd= 'intrm'.$n.'eo'.$n.'add';
       $eoAddOrg= 'intrm'.$n.'eo'.$n.'add'.$n.'org';
       $eoOrg= 'intrm'.$n.'eo'.$n.'org';
       if($this->db2->insert_batch($as, $data)){
            $this->db2->insert_batch($eoAdd, $ar);
     
             $a= $this->getORG();
             for($i=0; $i<count($ar);$i++){
                     
                  for($j=0; $j<count($a);$j++){
                   $data[$s] = array(

                      'ORG_ID'=> $a[$j]->ORG_ID,
                      'POS_EO_ID'=> $ar[$i]['POS_EO_ID'],
                      'EO_TYPE'=> 'C'
                    );
                   $s++;
               }
            }
           $this->db2->insert_batch($eoAddOrg, $data);
           $this->db2->insert_batch($eoOrg, $data);
           $r= "UPDATE swatch_final.sma_companies a SET sync_flg='1' WHERE a.id!= '1' AND a.group_name!='biller' AND sync_flg IS NULL OR sync_flg= ''";
            $this->db2->query($r);
            $m= "Customer Details Sync Successfully....";
            return $m;
        }
        else{
            $m= "Customer details sync already....";
            return $m;
        }
}
public function sync_upd_into_intermediate_usertable($upd){
    $n='$'; 
       $as= 'intrm'.$n.'usr';
       
       if($this->db2->insert_batch($as, $upd, 'POS_USR_ID')){
           $w = "UPDATE ebiz7.intrm".$n."usr a INNER JOIN swatch_final.sma_users b ON a.POS_USR_ID = b.id SET a.UPD_FLG='1' WHERE a.POS_USR_ID = b.id";
            $q = $this->db2->query($w);
            $m= "User Details Update Successfully....";
            return $m;
        }
        else{
            $m= "User Details Not Update....";
            return $m;
        }
    
}
public function sync_upd_into_intermediate_eotable($upd){
    $n='$'; 
       $as= 'intrm'.$n.'eo';
       
       if($this->db2->insert_batch($as, $upd, 'POS_EO_ID')){
            $w = "UPDATE ebiz7.intrm".$n."eo".$n."org a INNER JOIN swatch_final.sma_companies b ON a.POS_EO_ID = b.id SET a.UPD_FLG='1' WHERE a.POS_EO_ID = b.id";
            $q = $this->db2->query($w);
            $r= "UPDATE swatch_final.sma_companies a SET a.upd_flg='' WHERE a.upd_flg= '1' AND a.id!= '1' AND a.group_name!='biller'";
            $this->db2->query($r);
            $m= "Customer Details Update Successfully....";
            return $m;
        }
        else{
            $m= "Customer Details Not Update....";
            return $m;
        }
    
}

public function sync_into_intermediate_slsInv($data){
    $n='$'; 
       $as= 'intrm'.$n.'sls'.$n.'inv';
       
       if($this->db2->insert_batch($as, $data)){
            $w = "UPDATE swatch_final.sma_sales a INNER JOIN ebiz7.intrm".$n."sls".$n."inv b ON a.id = b.POS_DOC_ID SET a.sync_flg='1', b.SYNC_FLG='1' WHERE a.id = b.POS_DOC_ID";
            $q = $this->db2->query($w);
            $m= "Sales Details Sync Successfully....";
            return $m;
        }
        else{
            $m= "Sales Details already sync....";
            return $m;
        }
    
}
public function sync_into_intermediate_slsInvItem($data){
    $n='$'; 
       $as= 'intrm'.$n.'sls'.$n.'inv'.$n.'itm'; 
       
       if($this->db2->insert_batch($as, $data)){
            $w = "UPDATE swatch_final.sma_sale_items a INNER JOIN ebiz7.intrm".$n."sls".$n."inv".$n."itm b ON a.id = b.POS_DOC_ID SET a.sync_flg='1', b.SYNC_FLG='1' WHERE a.id = b.POS_DOC_ID";
            $q = $this->db2->query($w);
            $m= "Sales Item Details Sync Successfully....";
            return $m;
        }
        else{
            $m= "Sales Item Details already sync....";
            return $m;
        }
    
}

public function sync_into_intermediate_slsRma($data){
    $n='$'; 
       $as= 'intrm'.$n.'sls'.$n.'rma';
       
       if($this->db2->insert_batch($as, $data)){
            $w = "UPDATE swatch_final.sma_return_sales a INNER JOIN ebiz7.intrm".$n."sls".$n."rma b ON a.id = b.POS_DOC_ID SET a.sync_flg='1', b.SYNC_FLG='1' WHERE a.id = b.POS_DOC_ID";
            $q = $this->db2->query($w);
            $m= "Sales Return Details Sync Successfully....";
            return $m;
        }
        else{
            $m= "Sales Return Details already sync....";
            return $m;
        }
    
}
public function sync_into_intermediate_slsRmaItem($data){
    $n='$'; 
       $as= 'intrm'.$n.'sls'.$n.'rma'.$n.'itm'; 
       
       if($this->db2->insert_batch($as, $data)){
            $w = "UPDATE swatch_final.sma_return_items a INNER JOIN ebiz7.intrm".$n."sls".$n."rma".$n."itm b ON a.id = b.POS_DOC_ID SET a.sync_flg='1', b.SYNC_FLG='1' WHERE a.id = b.POS_DOC_ID";
            $q = $this->db2->query($w);
            $m= "Sales Return Item Details Sync Successfully....";
            return $m;
        }
        else{
            $m= "Sales Return Item Details already sync....";
            return $m;
        }
    
}

public function sync_into_intermediate_currtable($data){    
       $n='$'; 
       $as= 'intrm'.$n.'curr';
       if($this->db2->insert_batch($as, $data)){
            $m= "Currency Details Sync Successfully....";
            return $m;
        }
        else{
            $m= "Currency Details Not Sync....";
            return $m;
        }
}
public function sync_upd_into_intermediate_currtable($upd){
    $n='$'; 
       $as= 'intrm'.$n.'curr';
       
       if($this->db2->insert_batch($as, $upd, 'POS_CURR_ID')){
            $m= "Currency Details Update Successfully....";
            return $m;
        }
        else{
            $m= "Currency Details Not Update....";
            return $m;
        }
    
}
public function sync_into_intermediate_eocatgtable($data){    
       $n='$'; 
       $as= 'intrm'.$n.'eo'.$n.'catg';
       if($this->db2->insert_batch($as, $data)){
            $m= "Group Details Sync Successfully....";
            return $m;
        }
        else{
            $m= "Group Details Not Sync....";
            return $m;
        }
}
public function sync_upd_into_intermediate_eocatgtable($upd){
    $n='$'; 
       $as= 'intrm'.$n.'eo'.$n.'catg';
       
       if($this->db2->insert_batch($as, $upd, 'POS_EO_CATG_ID')){
            $m= "Group Details Update Successfully....";
            return $m;
        }
        else{
            $m= "Group Details Not Update....";
            return $m;
        }
    
}
public function sync_into_intermediate_orgtable($data){    
       $n='$'; 
       $as= 'intrm'.$n.'org';
       if($this->db2->insert_batch($as, $data)){
            $m= "Store Details Sync Successfully....";
            return $m;
        }
        else{
            $m= "Store Details Not Sync....";
            return $m;
        }
}
public function sync_upd_into_intermediate_orgtable($upd){
    $n='$'; 
       $as= 'intrm'.$n.'org';
       
       if($this->db2->insert_batch($as, $upd, 'POS_ORG_ID')){
            $m= "Store Details Update Successfully....";
            return $m;
        }
        else{
            $m= "Store Details Not Update....";
            return $m;
        }
    
}    
    
    
}
/* End of file Datatables.php */
/* Location: ./application/libraries/Datatables.php */