<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Msync_model extends CI_Model
{
   
    public function __construct()
    {
     
      parent::__construct();
      $this->load->model("auth_model");
      $this->load->database();
     
    }
    public function intrDbName()
    {
        $CI = &get_instance();
        $this->db2 = $CI->load->database('db2', TRUE);
        $intrDB = $this->db2->database;        
        return $intrDB;
 
    }
    public function posDbName()
    {
        $posDB = $this->db->database;
        return $posDB;
 
    }
    // added by vikas singh for cetrailized intermediate DB to POS intermediate DB
    public function intrtointrDbName()
    {
        $CI = &get_instance();
        $this->db3 = $CI->load->database('db3', TRUE);
        $intrintrDB = $this->db3->database;        
        return $intrintrDB;
 
    }
   

    
   public function currencyMaster_final()
    {
         //$this->currencyUPD_final();
         $intrDB = $this->intrDbName();
         $intrintrDB = $this->intrtointrDbName();
         $n = '$';
         $this->db->trans_begin();
         $this->db2->truncate($intrDB.".intrm".$n."curr");
        
         $q = $this->db3
               -> select('*')
               -> get($intrintrDB.".intrm".$n."curr");

         $result =$q->result();
         if($result)
         {
             $aa =  $this->db2->insert_batch($intrDB.".intrm".$n."curr",json_decode(json_encode($result), True));
             if($aa)
             {  
                if($this->currencyMaster())
                {        

                  if ($this->db->trans_status() === FALSE)
                    {
                         $this->db->trans_rollback();
                    }
                  else
                    {    $this->db->trans_commit();
                         $msg = "Currency Records save successfully...";
                         return $msg;
                    }
                }

             } 
          else {

                    $msg = $this->db->error();
                    return $msg['message'];
            }
            
         }
         
    }    

      


    // S.No.-01 (Intermediate -> POS)
   
    public function currencyMaster()
    {


        //$ar = $this->currencyUPD();
        $posDB = $this->posDbName();
        $intrDB = $this->intrDbName();
        $n = '$';
        $this->db->truncate("sma_currencies");
        $w  = "INSERT INTO ".$posDB.".sma_currencies(code,name,rate,curr_id) SELECT a.CURR_NOTATION,a.CURR_NM,'1',a.CURR_ID FROM ".$intrDB.".intrm".$n."curr a WHERE  a.POS_CURR_ID = '00'";
        if ($this->db->query($w)) {
         
            $w1 = "UPDATE ".$intrDB.".intrm".$n."curr a INNER JOIN ".$posDB.".sma_currencies b ON a.CURR_ID = b.curr_id SET a.POS_CURR_ID = b.id,a.CREATE_FLG = '1' WHERE a.CURR_ID = b.curr_id";
            $this->db->query($w1);
           
                 
                  // $msg = "Currency Records save successfully...";
                  // return $msg;
                  return true;
              }
 
       else {

            $msg = $this->db->error();
            return $msg['message'];
        }
    }
   
    // public function currencyUPD()
    // {
    //     $posDB = $this->posDbName();
    //     $intrDB = $this->intrDbName();
    //     $n = '$';
       
    //     $w = "UPDATE ".$posDB.".sma_currencies a INNER JOIN ".$intrDB.".intrm".$n."curr b ON (a.curr_id = b.CURR_ID AND a.id = b.POS_CURR_ID) SET a.code = b.CURR_NOTATION,a.name = b.CURR_NM WHERE b.UPD_FLG= '1'";
    //     if ($this->db->query($w)) {
    //         $w1 = "UPDATE ".$intrDB.".intrm".$n."curr a INNER JOIN ".$posDB.".sma_currencies b ON (a.CURR_ID = b.curr_id AND b.id = a.POS_CURR_ID) SET a.UPD_FLG = '' WHERE (a.CURR_ID = b.curr_id AND b.id = a.POS_CURR_ID) AND a.UPD_FLG= '1'";
    //         $this->db->query($w1);

    //               return true;
            
           

    //     } else {
    //         $msg = $this->db->error();
    //         return $msg['message'];
    //     }
    // }
   
   
    // S.NO-02 (Intermediate -> POS)
 
    public function warehouseMaster_final()
    {
      
        $posDB = $this->posDbName();
        $intrDB = $this->intrDbName();
        $intrintrDB = $this->intrtointrDbName();
        $n = '$'; 
        $this->db2->truncate($intrDB.".intrm".$n."org");
        $q = $this-> db3
               ->select('*')
               ->get($intrintrDB.".intrm".$n."org");

         $result =$q->result();
         //print_r($result); die;
         if($result)
         {
             $aa =  $this->db2->insert_batch($intrDB.".intrm".$n."org",json_decode(json_encode($result), True));
             if($aa)
             {  
                if($this->warehouseMaster())
                {        
                  // $q1 = $this->db2
                  //            ->select('*')
                  //            ->where('CREATE_FLG',1)
                  //            //->where('ORG_ID',$org)
                  //            ->get($intrDB.".intrm".$n."org");
   
                  // $result1 =$q1->result();
                  // $this->db2->update_batch($intrDB.".intrm".$n."org", json_decode(json_encode($result1)), 'USR_ID'); 
                  // if ($this->db->trans_status() === FALSE)
                  //   {
                  //        $this->db->trans_rollback();
                  //   }
                  // else
                  //   {    $this->db->trans_commit();
                    //echo "done"; die;
                         $msg = "Warehouse Records save successfully...";
                         return $msg;
                    //}
                }

             } 
          else {

                    $msg = $this->db->error();
                    return $msg['message'];
            }
            
         }

    }
   
    public function warehouseMaster()
    {
       
        $posDB = $this->posDbName();
        $intrDB = $this->intrDbName();
        $n = '$'; //echo "POS Database => ".$this->db->database."<br/> Intermediate Database => ".$this->db2->database; die;
        // added by vikas singh for transaction implementation
        
        //$this->db->truncate("sma_warehouses");
        $a="select org_id from ".$posDB.".sma_warehouses";
        $ar = $this->db->query($a);
        $result = $ar->result();
        //print_r($result); die;
        $arr = array();
        //print_r($result); die;
        if(!empty($result))
        {
            foreach ($result as $key => $value) {
                //echo $key."<br>";
                //print_r($value);
                foreach ($value as $key1 => $value1) {
                     $arr[] = $value1;
                }
            }
        }
       if(!empty($arr)){
        $arr = implode(',' , $arr);
        
        $w = "INSERT INTO ".$posDB.".sma_warehouses(code,name,address,city,state,org_id,org_alias,tin_no) SELECT a.ORG_ID,a.ORG_DESC,b.CNTRY_DESC,a.ORG_CITY,a.ORG_STATE,a.ORG_ID,a.ORG_ALIAS,a.ORG_TIN_NO FROM ".$intrDB.".intrm".$n."org a INNER JOIN ".$intrDB.".intrm".$n."cntry b ON (a.ORG_COUNTRY_ID = b.CNTRY_ID) WHERE a.ORG_ID NOT IN(".$arr.")";
        if ($this->db->query($w)) { 
            $w1 = "INSERT INTO ".$posDB.".sma_companies(group_name,NAME,company,phone,country,address,city,state,postal_code,org_id,tin_no) SELECT 'biller',a.ORG_DESC,a.ORG_DESC,'0123456789',b.CNTRY_DESC,a.ORG_ADD,a.ORG_CITY,a.ORG_STATE,a.ORG_PIN,a.ORG_ID,a.ORG_TIN_NO FROM ".$intrDB.".intrm".$n."org a INNER JOIN ".$intrDB.".intrm".$n."cntry b ON(a.ORG_COUNTRY_ID = b.CNTRY_ID) WHERE (a.ORG_ID NOT IN(".$arr.")) AND a.ORG_ID != '01'";
            if ($this->db->query($w1)) {
                $msg = "warehouse Records save successfully...";
                $w2  = "UPDATE ".$intrDB.".intrm".$n."org a INNER JOIN ".$posDB.".sma_warehouses b ON(a.ORG_ID = b.org_id) SET a.POS_ORG_ID = b.id WHERE a.ORG_ID = b.org_id";
                $this->db->query($w2);

                   
                      return true;
                 
               
            } else {
               
                $msg = $this->db->error();
                return $msg['message'];
            }
        }

      }
      else{

        $w = "INSERT INTO ".$posDB.".sma_warehouses(code,name,address,city,state,org_id,org_alias,tin_no) SELECT a.ORG_ID,a.ORG_DESC,b.CNTRY_DESC,a.ORG_CITY,a.ORG_STATE,a.ORG_ID,a.ORG_ALIAS,a.ORG_TIN_NO FROM ".$intrDB.".intrm".$n."org a INNER JOIN ".$intrDB.".intrm".$n."cntry b ON (a.ORG_COUNTRY_ID = b.CNTRY_ID) WHERE a.POS_ORG_ID = '00'"; 
        if ($this->db->query($w)) {
            $w1 = "INSERT INTO ".$posDB.".sma_companies(group_name,NAME,company,phone,country,address,city,state,postal_code,org_id,tin_no) SELECT 'biller',a.ORG_DESC,a.ORG_DESC,'0123456789',b.CNTRY_DESC,a.ORG_ADD,a.ORG_CITY,a.ORG_STATE,a.ORG_PIN,a.ORG_ID,a.ORG_TIN_NO FROM ".$intrDB.".intrm".$n."org a INNER JOIN ".$intrDB.".intrm".$n."cntry b ON(a.ORG_COUNTRY_ID = b.CNTRY_ID) WHERE (a.POS_ORG_ID ='00') AND a.ORG_ID != '01'";
            if ($this->db->query($w1)) {
                $msg = "warehouse Records save successfully...";
                $w2  = "UPDATE ".$intrDB.".intrm".$n."org a INNER JOIN ".$posDB.".sma_warehouses b ON(a.ORG_ID = b.org_id) SET a.POS_ORG_ID = b.id WHERE a.ORG_ID = b.org_id";
                $this->db->query($w2);

                   
                      return true;
                 
               
            } else {
               
                $msg = $this->db->error();
                return $msg['message'];
            }
        }

      }
       
    }
   
    // S.NO.-03 (Intermediate -> POS)  


   public function userMaster_final($org)
    {   
       

       // $this->db->trans_begin();
       // $this->userUPD_final($org);
        $posDB = $this->posDbName();
        $intrDB = $this->intrDbName();
        $intrintrDB = $this->intrtointrDbName();
        $n = '$'; 
        //$this->db2->truncate($intrDB.".intrm".$n."org");
        ////uu
         //uu
        $where = "ORG_ID='".$org."' AND POS_USR_ID='00'";

        $this->db3 
               ->select('*')
               ->where($where);
              // ->or_where('POS_USR_ID=',NULL);
         // $this->db3->where('ORG_ID',$org);
        $q =$this->db3->get($intrintrDB.".intrm".$n."usr");
         $result = $q->result();
     
         if($result)
         {
             $aa =  $this->db2->insert_batch($intrDB.".intrm".$n."usr",json_decode(json_encode($result), True));
             //$first_id = $this->db2->insert_id();
           
             if($aa)
             {  
                if($this->userMaster($org))
                {        
                  //   $this->db2
                  //            ->select('POS_USR_ID,CREATE_FLG,USR_ID')
                  //            ->where('CREATE_FLG',1)
                  //            ->where('POS_USR_ID !=',NULL);
                  //           $this->db2->where('ORG_ID',$org);       
                  //   $q1=$this->db2->get($intrDB.".intrm".$n."usr");
                  //  //die;
                  // $result1 =$q1->result();

                  $where1 = "ORG_ID='".$org."' AND CREATE_FLG ='1' AND POS_USR_ID !='00'";
                  $this->db2
                             ->select('POS_USR_ID,CREATE_FLG,ORG_ID,USR_ID')
                             ->where($where1);
                        $q4 = $this->db2->get($intrDB.".intrm".$n."usr");
                        $result4 =$q4->result();

                        $this->db2
                             ->select('POS_USR_ID,CREATE_FLG')
                             ->where($where1);
                        $q8 = $this->db2->get($intrDB.".intrm".$n."usr");
                          $result8 = $q8->result();
                        $i=0;
                       foreach ($result4 as $k ) {
                        $this->db3->where('ORG_ID',$org);
                        $this->db3->where('USR_ID',$k->USR_ID);
                        $this->db3->update($intrintrDB.".intrm".$n."usr",json_decode(json_encode($result8[$i]), True));
                        $i++;
                           # code...
                       }

                  // $this->db3->update_batch($intrintrDB.".intrm".$n."usr", json_decode(json_encode($result1), True), 'USR_ID'); 

                    $crflag = array(
                       'CREATE_FLG' => '2'
                    );
                    $this->db2->where($where1);
                    $this->db2->update($intrDB.".intrm".$n."usr", $crflag); 
                   
                  // if ($this->db->trans_status() === FALSE)
                  //   {
                  //        $this->db->trans_rollback();
                  //   }
                  // else
                  //   {    $this->db->trans_commit();
                         $msg = "User Records save successfully...";
                         return $msg;
                    //}
                }

             } 
          else {

                    $msg = $this->db->error();
                    return $msg['message'];
            }
           
         }

    }  

  public function userUPD_final($org)
    {
        $posDB = $this->posDbName();
        $intrDB = $this->intrDbName();
        $intrintrDB = $this->intrtointrDbName();
        $n = '$'; 
        //uu

         $this->db3
               ->select('*')
               ->where('UPD_FLG','1');
         $this->db3->where('ORG_ID',$org);
         $q= $this->db3->get($intrintrDB.".intrm".$n."usr");
         $result =$q->result();
         //print_r($result); die;
         if($result)
         {  
            $aa =  $this->db2->update_batch($intrDB.".intrm".$n."usr", json_decode(json_encode($result), True), 'USR_ID'); 

             // if($aa)
             // {  
                if($this->userUPD($org))
                {  
                    $crflag1 = array(
                       'UPD_FLG' => NULL
                    );
                   $where = "ORG_ID='".$org."' AND UPD_FLG ='1' AND POS_USR_ID !='00'";
                    $this->db3->where($where);
                   
                    $res= $this->db3->update($intrintrDB.".intrm".$n."usr", $crflag1);
                    // if($res){
                            $crflag2 = array(
                               'UPD_FLG' => NULL
                            );
                            $where1 = "ORG_ID='".$org."' AND UPD_FLG ='2' AND POS_USR_ID !='00'";
                            $this->db2->where($where1);
                            $this->db2->update($intrDB.".intrm".$n."usr", $crflag2); 
                    //}
                     return true;
                  // if ($this->db->trans_status() === FALSE)
                  //   {
                  //        $this->db->trans_rollback();
                  //   }
                  // else
                  //   {    $this->db->trans_commit();
                  //        $msg = "User Records save successfully...";
                  //        return $msg;
                  //   }
                }

             //} 
          else {

                    $msg = $this->db->error();
                    return $msg['message'];
            }
           
         }
    }

    public function userMaster($org)
    {
        //$this->userUPD($org);
        //echo "hello"; die;
        //uu
        $posDB = $this->posDbName();
        $intrDB = $this->intrDbName();
        $n = '$';
        $w = "INSERT INTO ".$posDB.".sma_users(usr_id,username,password,salt,email,first_name,last_name,active,avatar,gender,phone,created_on,company,group_id,warehouse_id,show_discount,biller_id,org_id) SELECT a.USR_ID,a.USR_NAME,sha1(a.USR_PWD),'Null','Null',a.USR_FST_NAME,a.USR_LST_NAME, CASE WHEN a.USR_ACTV = 'Y' THEN '1' ELSE '0' END AS Activ,a.USR_IMG,a.USR_GNDR,a.USR_CONTACT_NO,a.USR_ID_CREATE_DT,b.name,'5',b.id,a.USR_DISC,c.id,a.ORG_ID FROM ".$intrDB.".intrm".$n."usr a INNER JOIN ".$posDB.".sma_warehouses b ON (a.ORG_ID = b.org_id) INNER JOIN ".$posDB.".sma_companies c ON (a.ORG_ID = c.org_id) WHERE (a.POS_USR_ID = '00') AND b.org_id='".$org."'"; //NULL OR a.POS_USR_ID = '' AND b.org_id='02'"; 
        if ($this->db->query($w)) {
            $msg = "User Records save successfully...";
             $w1  = "UPDATE ".$intrDB.".intrm".$n."usr a INNER JOIN ".$posDB.".sma_users b ON (a.USR_ID = b.usr_id AND a.ORG_ID = b.org_id) SET a.POS_USR_ID= b.id, a.CREATE_FLG='1' WHERE (a.USR_ID = b.usr_id AND a.ORG_ID = b.org_id)";
             $this->db->query($w1);
             
                      return true;
                  
            //return $msg;
        } else {
            $msg = $this->db->error();
            return $msg['message'];
        }
       
    }
    public function userUPD($org)
    {
        //uu
        $posDB = $this->posDbName();
        $intrDB = $this->intrDbName();
        $n = '$';
        
        // $w = "UPDATE ".$posDB.".sma_users a INNER JOIN ".$intrDB.".intrm".$n."usr b ON( a.id = b.POS_USR_ID AND a.usr_id = b.USR_ID ) INNER JOIN ".$posDB.".sma_warehouses c ON(a.org_id = c.org_id) INNER JOIN ".$posDB.".sma_companies d ON(a.org_id = d.org_id) SET a.usr_id = b.USR_ID, a.username = b.USR_NAME, a.password = SHA1(b.USR_PWD), a.salt = 'NULL', a.email = 'NULL', a.first_name = b.USR_FST_NAME, a.last_name = b.USR_LST_NAME, a.active = CASE WHEN b.USR_ACTV = 'Y' THEN '1' ELSE '0' END, a.avatar = b.USR_IMG, a.gender = b.USR_GNDR, a.phone = b.USR_CONTACT_NO, a.created_on = b.USR_ID_CREATE_DT, a.company = c.name, a.group_id = '5', a.warehouse_id = c.id, a.biller_id = d.id, a.show_discount = b.USR_DISC WHERE b.UPD_FLG = '1' AND b.org_id='".$org."'";

          $w = "UPDATE ".$posDB.".sma_users a INNER JOIN ".$intrDB.".intrm".$n."usr b ON( a.id = b.POS_USR_ID AND a.usr_id = b.USR_ID ) INNER JOIN ".$posDB.".sma_warehouses c ON(a.org_id = c.org_id) INNER JOIN ".$posDB.".sma_companies d ON(a.org_id = d.org_id) SET a.usr_id = b.USR_ID, a.username = b.USR_NAME, a.password = SHA1(b.USR_PWD), a.salt = 'NULL', a.email = 'NULL', a.first_name = b.USR_FST_NAME, a.last_name = b.USR_LST_NAME, a.active = CASE WHEN b.USR_ACTV = 'Y' THEN '1' ELSE '0' END, a.avatar = b.USR_IMG, a.gender = b.USR_GNDR, a.phone = b.USR_CONTACT_NO, a.created_on = b.USR_ID_CREATE_DT, a.company = c.name, a.group_id = '5', a.warehouse_id = c.id, a.biller_id = d.id, a.show_discount = b.USR_DISC WHERE b.UPD_FLG = '1' AND b.org_id='".$org."'"; 

        if ($this->db->query($w)) {
           
            $w1 = "UPDATE ".$intrDB.".intrm".$n."usr a INNER JOIN ".$posDB.".sma_users b ON (a.POS_USR_ID = b.id AND a.USR_ID= b.usr_id) SET a.UPD_FLG='' WHERE (a.POS_USR_ID = b.id AND a.USR_ID= b.usr_id) AND a.UPD_FLG='1'";
            $this->db->query($w1);
            // added by vikas singh for transactions

                  return true;
             
            //return true;
        }
       
        else {
            $msg = $this->db->error();
            return $msg['message'];
        }
       
    }
   
   
    // S.NO.-04 (Intermediate -> POS)

     public function taxMaster_final($org)
     {
        $arr = array();
        $result2 = array();
       // $this->db->trans_begin();
        $this->taxUPD_final($org);
        $posDB = $this->posDbName();
        $intrDB = $this->intrDbName();
        $intrintrDB = $this->intrtointrDbName();
        $n = '$'; 
        //$this->db2->truncate($intrDB.".intrm".$n."org");
        //uu
        $where = "ORG_ID='".$org."' AND POS_GRP_ID ='00'";
        $this->db3
               ->select('*')
               ->where($where);
              // ->or_where('POS_GRP_ID',NULL);
         //$this->db3->where('ORG_ID',$org);
        $q =$this->db3->get($intrintrDB.".intrm".$n."itm".$n."grp".$n."org");
        $result =$q->result(); 
        // echo "<pre>"; 
        // print_r($result);exit;
        $this->db3
               ->select('GRP_ID')
               ->where($where);
                //->where('POS_GRP_ID','')
               //->or_where('POS_GRP_ID',NULL);
         //$this->db3->where('ORG_ID',$org);          
         $q1= $this->db3->get($intrintrDB.".intrm".$n."itm".$n."grp".$n."org");       

         $result1 =$q1->result();
//         echo "<pre>";
//         print_r($result1);exit;
         if(!empty($result1)){
            foreach ($result1 as $key => $value) {
                foreach ($value as $key1 => $value1) {
                     $arr[] = $value1;
                }
            }

    
         $q2 = $this->db3
               ->select('*')
               ->where_in('GRP_ID',$arr)
               ->get($intrintrDB.".intrm".$n."itm".$n."grp");

         $result2 =$q2->result();      
        }

      
         if($result && $result2)
         {
             $aa =  $this->db2->insert_batch($intrDB.".intrm".$n."itm".$n."grp".$n."org",json_decode(json_encode($result), True));

             $aa1 =  $this->db2->insert_batch($intrDB.".intrm".$n."itm".$n."grp",json_decode(json_encode($result2), True));

             // if($aa && $aa1)
             // {  
                if($this->taxMaster($org))
                {        
                   if($this->categoryMaster($org))
                     {
                        //$this->categoryMaster();

                       //  $this->db2
                       //       ->select('POS_GRP_ID,CREATE_FLG,GRP_ID');
                                
                       // $this->db2->where('ORG_ID',$org);
                                  
                       // $this->db2->where('POS_GRP_ID !=','');
                       // $this->db2->or_where('POS_GRP_ID !=',NULL)
                       //      ->where('CREATE_FLG',1);
                       // $q3 = $this->db2->get($intrDB.".intrm".$n."itm".$n."grp".$n."org");

                       // $result3 =$q3->result();
                       // //$this->db3->where('ORG_ID',$org);
                       // $this->db3->update_batch($intrintrDB.".intrm".$n."itm".$n."grp".$n."org", json_decode(json_encode($result3), True), 'GRP_ID'); 
                        $where1 = "ORG_ID='".$org."' AND CREATE_FLG ='1' AND POS_GRP_ID !='00'";
                        $this->db2
                             ->select('POS_GRP_ID,CREATE_FLG,ORG_ID,GRP_ID')
                             ->where($where1);
                        $q4 = $this->db2->get($intrDB.".intrm".$n."itm".$n."grp".$n."org");
                        $result4 =$q4->result();

                        $this->db2
                             ->select('POS_GRP_ID,CREATE_FLG')
                             ->where($where1);

                        $q8 = $this->db2->get($intrDB.".intrm".$n."itm".$n."grp".$n."org");
                          $result8 = $q8->result();

                        $i=0;
                       foreach ($result4 as $k ) {
                        $this->db3->where('ORG_ID',$org);
                        $this->db3->where('GRP_ID',$k->GRP_ID);
                        $this->db3->update($intrintrDB.".intrm".$n."itm".$n."grp".$n."org",json_decode(json_encode($result8[$i]), True));
                        $i++;
                           # code...
                       }


                        $crflag = array(
                            'CREATE_FLG' => '2'
                        );
                       
                        $this->db2->where($where1);
                        
                        $this->db2->update($intrDB.".intrm".$n."itm".$n."grp".$n."org", $crflag);

                        // if ($this->db->trans_status() === FALSE)
                        //   {
                        //        $this->db->trans_rollback();
                        //   }
                        // else
                        //   {    //$this->db->trans_commit();
                               $msg = "Tax Records save successfully...";
                               return $msg;
                               //return true;
                          //}
                     }
             
                 //} 
               }
          else {

                    $msg = $this->db->error();
                    return $msg['message'];
            }
           
         }
     }
   
    public function taxUPD_final($org)
    {
        $result2 =array();
        $posDB = $this->posDbName();
        $intrDB = $this->intrDbName();
        $intrintrDB = $this->intrtointrDbName();
        $n = '$'; 
        //uu
        $this->db3
               ->select('*')
               ->where('UPD_FLG','1');
         $this->db3->where('ORG_ID',$org);
        $q =$this->db3->get($intrintrDB.".intrm".$n."itm".$n."grp".$n."org");
        $result =$q->result();  

        $this->db3
               ->select('GRP_ID')
               ->where('UPD_FLG','1');
         $this->db3->where('ORG_ID',$org);
         $q1= $this->db3->get($intrintrDB.".intrm".$n."itm".$n."grp".$n."org");       

         $result1 =$q1->result();
         if(!empty($result1)){
         $q2 = $this->db3
               ->select('*')
               ->where_in('GRP_ID',$result1->GRP_ID)
               ->get($intrintrDB.".intrm".$n."itm".$n."grp");

         $result2 =$q2->result(); 
        }
        // print_r($result2);
        //   die;
         if($result && $result2)
         {   
            //$this->db->where('ORG_ID',$org);
             $aa =  $this->db2->update_batch($intrDB.".intrm".$n."itm".$n."grp".$n."org", json_decode(json_encode($result)), 'GRP_ID'); 
             $aa1 = $this->db2->update_batch($intrDB.".intrm".$n."itm".$n."grp", json_decode(json_encode($result2)), 'GRP_ID'); 


             // if($aa && $aa1)
             // {  
                if($this->taxUPD($org))
                {        
                  
                   if($this->categoryUPD($org))
                   {

                    $crflag1 = array(
                       'UPD_FLG' => NULL
                    );
                      $where2 = "ORG_ID='".$org."' AND UPD_FLG ='1' AND POS_GRP_ID !='00'";

                    $this->db3->where($where2);
                ;
                    $res= $this->db3->update($intrintrDB.".intrm".$n."itm".$n."grp".$n."org", $crflag1);
               
                            $crflag2 = array(
                               'UPD_FLG' => NULL
                            );
                              $where3 = "ORG_ID='".$org."' AND UPD_FLG ='2' AND POS_GRP_ID !='00'";

                            $this->db2->where($where3);
                            $this->db2->update($intrDB.".intrm".$n."itm".$n."grp".$n."org", $crflag2); 
             

                          // if ($this->db->trans_status() === FALSE)
                          //   {
                          //        $this->db->trans_rollback();
                          //   }
                          // else
                          //   {    $this->db->trans_commit();
                                // echo "Done";
                                 return true;
                           // }
                      }

           
                  }

           //} 
          else {

                    $msg = $this->db->error();
                    return $msg['message'];
            }
           
         }

    }

    public function taxMaster($org)
    {
        //$ar = $this->taxUPD();
        $posDB = $this->posDbName();
        $intrDB = $this->intrDbName();
        $n = '$';
        $w  = "INSERT INTO ".$posDB.".sma_tax_rates(name,rate,type,org_id,grp_id) SELECT CONCAT(a.TAX_VAL,'% TAX'),a.TAX_VAL,'0',a.ORG_ID,a.GRP_ID FROM ".$intrDB.".intrm".$n."itm".$n."grp".$n."org a WHERE a.POS_GRP_ID = '00'";
        //echo $w; die;
        if ($this->db->query($w)) {

                  // $msg = "Tax Records save successfully...";
                  // return $msg;
            return true;
             
        }
        else {
            $msg = $this->db->error();
            return $msg['message'];
        }
    }
   
    public function taxUPD($org)
    {
        $posDB = $this->posDbName();
        $intrDB = $this->intrDbName();
        $n = '$';
        $w = "UPDATE ".$posDB.".sma_tax_rates a INNER JOIN ".$intrDB.".intrm".$n."itm".$n."grp".$n."org b ON (a.org_id = b.ORG_ID AND a.grp_id = b.GRP_ID) SET a.name = CONCAT(b.TAX_VAL,'% TAX'),a.rate = b.TAX_VAL WHERE b.UPD_FLG='1'";
        if ($this->db->query($w)) {

              return true;
             
        } else {
            $msg = $this->db->error();
            return $msg['message'];
        }
       
    }
   
    // S.NO.-05 (Intermediate -> POS)
   
    public function categoryMaster($org)
    {
        //$ar = $this->categoryUPD();
        $posDB = $this->posDbName();
        $intrDB = $this->intrDbName();
        $n = '$';
        
        $w  = "INSERT INTO ".$posDB.".sma_categories(code,name,tax_rate_id) SELECT a.GRP_ID,a.GRP_NM,'0' FROM ".$intrDB.".intrm".$n."itm".$n."grp a WHERE (a.POS_GRP_ID = '00')";
        if ($this->db->query($w)) {
            $w1 = "UPDATE ".$intrDB.".intrm".$n."itm".$n."grp a INNER JOIN ".$posDB.".sma_categories b ON a.GRP_ID = b.code SET a.POS_GRP_ID = b.id WHERE a.GRP_ID = b.code";
            if ($this->db->query($w1)) {
            $w2 = "UPDATE ".$intrDB.".intrm".$n."itm".$n."grp".$n."org a INNER JOIN ".$posDB.".sma_categories b ON a.GRP_ID = b.code SET a.POS_GRP_ID = b.id, a.CREATE_FLG = '1' WHERE a.GRP_ID = b.code";
            if ($this->db->query($w2)) {

                       // $msg = "category Records save successfully...";
                       // return $msg;
                    return true;
                 } else {
                    $msg = $this->db->error();
                   return $msg['message'];
                   }
             } else {
                   $msg = $this->db->error();
                   return $msg['message'];
             }
             // end------------------
            //$msg = "category Records save successfully...";
            //return $msg;
           
        } else {
            $msg = $this->db->error();
            return $msg['message'];
        }
       
    }
    public function categoryUPD($org)
    {

        $posDB = $this->posDbName();
        $intrDB = $this->intrDbName();
        //uu
        $n = '$';
        $w = "UPDATE ".$posDB.".sma_categories a INNER JOIN ".$intrDB.".intrm".$n."itm".$n."grp b ON (b.GRP_ID = a.code) INNER JOIN ".$intrDB.".intrm".$n."itm".$n."grp".$n."org c ON (c.GRP_ID = b.GRP_ID) SET a.code = b.GRP_ID,a.name = b.GRP_NM WHERE c.UPD_FLG='1'";
      

        if ($this->db->query($w)) {

            $w1 = "UPDATE ".$intrDB.".intrm".$n."itm".$n."grp".$n."org a INNER JOIN ".$posDB.".sma_categories b ON (a.GRP_ID = b.code AND a.POS_GRP_ID = b.id) SET a.UPD_FLG = '2' WHERE (a.GRP_ID = b.code AND a.POS_GRP_ID = b.id)";
            $this->db->query($w1);

                  return true;
             
        } else {
            $msg = $this->db->error();
            return $msg['message'];
        }
       
       
    }
   
   public function customerMaster_final_test($org)
    {

     $result2 = array();
        $result7 = array();
        $arr1 =array();
        $posDB = $this->posDbName();
        $intrDB = $this->intrDbName();
        $intrintrDB = $this->intrtointrDbName();
        $n = '$'; 
     $where1 = "ORG_ID='".$org."' AND EO_TYPE ='C' AND CREATE_FLG ='1' AND POS_EO_ID !='00' AND (EO_ID!='NULL' AND EO_ID!='' AND EO_ID IS NOT NULL)";

                  $this->db2
                             ->select('SN')
                              ->where($where1);
                        $q11 = $this->db2->get($intrDB.".intrm".$n."eo".$n."org");
                        $result11 =$q11->result();

                     // print_r($result11); die;

                        $this->db2
                             ->select('POS_EO_ID,CREATE_FLG')
                             ->where($where1);
                        $q12 = $this->db2->get($intrDB.".intrm".$n."eo".$n."org");
                          $result12 = $q12->result();

                        // $where23 = "ORG_ID='".$org."' AND EO_TYPE ='C' AND POS_EO_ID !='00' AND (EO_ID!='NULL' AND EO_ID!='' AND EO_ID IS NOT NULL)";  
                        // $i=0;
                         
                        //  echo "<pre>";
                        // print_r(json_decode(json_encode($result12['0']), True)); die;
                         $i=0;
                       foreach ($result11 as $k ) {
                        $this->db3->where('SN',$k->SN);
                        $this->db3->update($intrintrDB.".intrm".$n."eo".$n."org",json_decode(json_encode($result12[$i]), True));
                        $i++;
                           # code...
                       }
                     $msg = "Customer Records save successfully...";
                               return $msg;

    }


    public function customerMaster_final($org)
    {
      //echo "org id".$org; exit;
        //$this->db->trans_begin();
        $this->customerUPD_final($org);
        $result2 = array();
        $result7 = array();
        $arr1 =array();
        $posDB = $this->posDbName();
        $intrDB = $this->intrDbName();
        $intrintrDB = $this->intrtointrDbName();
        $n = '$'; 
        //$this->db2->truncate($intrDB.".intrm".$n."org");
        //uu
        $where = "ORG_ID='".$org."' AND (EO_ID!='NULL' AND EO_ID!='') AND (EO_TYPE ='C' AND POS_EO_ID='00')";
        // for eo & eo_org
        $this->db3
               ->select('*')
               ->where($where);
              // ->or_where('POS_EO_ID',NULL);
        // $this->db3->where('ORG_ID',$org);
        $q =$this->db3->get($intrintrDB.".intrm".$n."eo".$n."org");
        $result =$q->result();  
        
        $this->db3
               ->select('EO_ID')
               ->where($where);
            //   ->or_where('POS_EO_ID',NULL);
          //$this->db3->where('ORG_ID',$org);
         $q1= $this->db3->get($intrintrDB.".intrm".$n."eo".$n."org");       
         $result1 =$q1->result();
      
       if(!empty($result1)){
            foreach ($result1 as $key => $value) {
                foreach ($value as $key1 => $value1) {
                     $arr1[] = $value1;
                }
            }

           $this->db3
             ->select('*');
            $this->db3->where_in('EO_ID',$arr1);
            $this->db3->where('EO_TYPE','C');
            $this->db3->where('EO_ID !=','');
             $this->db3->where('EO_ID !=','NULL');
            $q2 = $this->db3->get($intrintrDB.".intrm".$n."eo");

         $result2 =$q2->result();  
          }
           

         // for eo_add & eo_add_org 

         $this->db3
               ->select('*')
               ->where($where);
               //->or_where('POS_EO_ID',NULL);
         //$this->db3->where('ORG_ID',$org);
        $q5 =$this->db3->get($intrintrDB.".intrm".$n."eo".$n."add".$n."org");
        $result5 =$q5->result();  
        
       
        $this->db3
               ->select('EO_ID')
               ->where($where);
               //->or_where('POS_EO_ID',NULL);
         //$this->db3->where('ORG_ID',$org);
         $q6= $this->db3->get($intrintrDB.".intrm".$n."eo".$n."add".$n."org");       

         $result6 =$q6->result();
         
        if(!empty($result6)){
         $q7 = $this->db3
               ->select('*')
               ->where_in('EO_ID',$result6->EO_ID)
               ->where('EO_TYPE','C')
               ->where('EO_ID !=','')
               ->where('EO_ID !=','NULL')
               ->get($intrintrDB.".intrm".$n."eo".$n."add");

         $result7 =$q7->result();  
         }

           //echo "<pre>";
           //print_r($result2); die;

         if($result && $result2 && $result5 && $result7)
         {
             
             $aa =  $this->db2->insert_batch($intrDB.".intrm".$n."eo".$n."org",json_decode(json_encode($result), True));
             
             $aa1 =  $this->db2->insert_batch($intrDB.".intrm".$n."eo",json_decode(json_encode($result2), True));

             $aa3 =  $this->db2->insert_batch($intrDB.".intrm".$n."eo".$n."add".$n."org",json_decode(json_encode($result5), True));

             $aa4 =  $this->db2->insert_batch($intrDB.".intrm".$n."eo".$n."add",json_decode(json_encode($result7), True));


             if($aa && $aa1 && $aa3 && $aa4)
             {  
                
                if($this->customerMaster($org))
                {        
                    
                 $where1 = "ORG_ID='".$org."' AND EO_TYPE ='C' AND CREATE_FLG ='1' AND POS_EO_ID !='00' AND (EO_ID!='NULL' AND EO_ID!='' AND EO_ID IS NOT NULL)";

                  $this->db2
                             ->select('SN')
                             ->where($where1);
                        $q11 = $this->db2->get($intrDB.".intrm".$n."eo".$n."org");
                        $result11 =$q11->result();

                     // print_r($result11); die;

                        $this->db2
                             ->select('POS_EO_ID,CREATE_FLG')
                             ->where($where1);
                        $q12 = $this->db2->get($intrDB.".intrm".$n."eo".$n."org");
                          $result12 = $q12->result();
 
                      $i=0;
                       foreach ($result11 as $k ) {
                        $this->db3->where('SN',$k->SN);
                        $this->db3->update($intrintrDB.".intrm".$n."eo".$n."org",json_decode(json_encode($result12[$i]), True));
                        $i++;
                           # code...
                       }
                    

                      $this->db2
                             ->select('SN')
                             ->where($where1);
                        $q9 = $this->db2->get($intrDB.".intrm".$n."eo".$n."add".$n."org");
                        $result9 =$q9->result();

                        $this->db2
                             ->select('POS_EO_ID,CREATE_FLG')
                             ->where($where1);
                        $q10 = $this->db2->get($intrDB.".intrm".$n."eo".$n."add".$n."org");
                        $result10 = $q10->result();

                     
                         $i1=0;
                       foreach ($result9 as $k1 ) {
                        $this->db3->where('SN',$k1->SN);
                        $this->db3->update($intrintrDB.".intrm".$n."eo".$n."add".$n."org",json_decode(json_encode($result10[$i1]), True));
                        $i++;
                           # code...
                       }
                    
                        
                        $crflag = array(
                            'CREATE_FLG' => '2'
                        );
                         $this->db2->where($where1);     
                        $this->db2->update($intrDB.".intrm".$n."eo".$n."org", $crflag);

                        $this->db2->where($where1);
                        $this->db2->update($intrDB.".intrm".$n."eo".$n."add".$n."org", $crflag);

                        // if ($this->db->trans_status() === FALSE)
                        //   {
                        //        $this->db->trans_rollback();
                        //   }
                        // else
                        //   {    //$this->db->trans_commit();
                               $msg = "Customer Records save successfully...";
                               return $msg;
                               //return true;
                          //}
                     
             
                 } 
               }
          else {

                    $msg = $this->db->error();
                    return $msg['message'];
            }
           
         }
    }

    public function customerUPD_final($org)
    { 

        $result2 = array();
        $result7 = array();
        $arr = array();
        $arr1 = array();
        $posDB = $this->posDbName();
        $intrDB = $this->intrDbName();
        $intrintrDB = $this->intrtointrDbName();
        $n = '$'; 
        //uu

         // for eo & eo_org 
        $this->db3
               ->select('*')
               ->where('UPD_FLG','1')
               ->where('EO_TYPE','C')
               ->where('ORG_ID',$org);
        $q =$this->db3->get($intrintrDB.".intrm".$n."eo".$n."org");
        $result =$q->result();
        // echo "<pre>";  
        //print_r($result); die;

        $this->db3
               ->select('EO_ID')
               ->where('UPD_FLG','1')
               ->where('EO_TYPE','C')
               ->where('ORG_ID',$org);
         $q1= $this->db3->get($intrintrDB.".intrm".$n."eo".$n."org");       

         $result1 =$q1->result();// print_r($result1); die;
        if(!empty($result1)){
         //echo $result1[1]->EO_ID; die;
            foreach ($result1 as $key => $value) {
                foreach ($value as $key1 => $value1) {
                     $arr[] = $value1;
                }
            }
        // $arr = implode(',' , $arr); 
       // print_r($arr); die;  
         $this->db3
               ->select('*')
               ->where_in('EO_ID',$arr);
          $q2 =  $this->db3->get($intrintrDB.".intrm".$n."eo");
         $result2 =$q2->result();  
        }
          // for eo_add & eo_add_org 

        $this->db3
               ->select('*')
               ->where('UPD_FLG','1')
               ->where('EO_TYPE','C')
               ->where('ORG_ID',$org);
               //->where('POS_EO_ID !=','')
               //->or_where('POS_EO_ID !=',NULL);
        $q5 =$this->db3->get($intrintrDB.".intrm".$n."eo".$n."add".$n."org");
        $result5 =$q5->result();  
            
        $this->db3
               ->select('EO_ID')
               ->where('UPD_FLG','1')
               //->where('POS_EO_ID !=','')
               //->or_where('POS_EO_ID !=',NULL);
               ->where('EO_TYPE','C')
             ->where('ORG_ID',$org);
         $q6= $this->db3->get($intrintrDB.".intrm".$n."eo".$n."add".$n."org");       

         $result6 =$q6->result(); //print_r($result6); die;
         if(!empty($result6)){
            foreach ($result6 as $key => $value) {
                foreach ($value as $key1 => $value1) {
                     $arr1[] = $value1;
                }
            }
            //print_r($arr1); die;
         $q7 = $this->db3
               ->select('*')
               ->where_in('EO_ID',$arr1)
               ->get($intrintrDB.".intrm".$n."eo".$n."add");

         $result7 =$q7->result();  
         }
        // print_r($result7);
//echo "hi..."; die;
         if($result && $result2 && $result5 && $result7)
         {   
            //$this->db->where('ORG_ID',$org);
             $aa =  $this->db2->update_batch($intrDB.".intrm".$n."eo".$n."org", json_decode(json_encode($result)), 'EO_ID'); 
             $aa1 = $this->db2->update_batch($intrDB.".intrm".$n."eo", json_decode(json_encode($result2)), 'EO_ID'); 

             $aa3 =  $this->db2->update_batch($intrDB.".intrm".$n."eo".$n."add".$n."org", json_decode(json_encode($result5)), 'EO_ID'); 
             $aa4 = $this->db2->update_batch($intrDB.".intrm".$n."eo".$n."add", json_decode(json_encode($result7)), 'EO_ID'); 
             // echo "hi..."; die;
              // die; 
             // if($aa && $aa1 && $aa3 && $aa4)
             // {  
                if($this->customerUPD($org))
                {        
                    //echo "hi11..."; die;
                    $crflag = array(
                       'UPD_FLG' => NULL
                    );
                    $where1 = "ORG_ID='".$org."' AND EO_TYPE ='C' AND UPD_FLG ='1' AND POS_EO_ID !='00'";

                    $this->db3->where($where1);
                  
                    $res= $this->db3->update($intrintrDB.".intrm".$n."eo".$n."org", $crflag);

                    $this->db3->where($where1);
                    $res1= $this->db3->update($intrintrDB.".intrm".$n."eo".$n."add".$n."org", $crflag);
                    
                    //if($res && $res1){
                        $where2 = "ORG_ID='".$org."' AND EO_TYPE ='C' AND UPD_FLG ='2' AND POS_EO_ID='00'";
                        $this->db2->where($where2);
                        $this->db2->update($intrDB.".intrm".$n."eo".$n."org", $crflag); 

                        $this->db2->where($where2);
                        $this->db2->update($intrDB.".intrm".$n."eo".$n."add".$n."org", $crflag);
                   // }

                          // if ($this->db->trans_status() === FALSE)
                          //   {
                          //        $this->db->trans_rollback();
                          //   }
                          // else
                          //   {    $this->db->trans_commit();
                                 
                                 return true;
                           // }
                      

           
                  }

           } 
          else {

                    $msg = $this->db->error();
                    return $msg['message'];
            }
           
         //}
    }   

    // S.NO.-06 (Intermediate -> POS)
   
    public function customerMaster($org)
    {
      //echo "org".$org;exit;
        //$ar = $this->customerUPD();
        $posDB = $this->posDbName();
        $intrDB = $this->intrDbName();
        $n = '$';
        //$this->db->trans_begin();
        $w  = "INSERT INTO ".$posDB.".sma_companies(group_id,group_name,customer_group_id,customer_group_name,name,phone,email,vat_no,address,country,eo_type,eo_id,org_id,sync_flg) SELECT '3','customer','1','General',a.EO_NM,a.EO_PHONE,'Not Available',a.VAT_NO,b.ADDRESS,c.CNTRY_DESC,a.EO_TYPE,a.EO_ID,'".$org."','1' FROM ".$intrDB.".intrm".$n."eo a INNER JOIN ".$intrDB.".intrm".$n."eo".$n."add b ON (b.EO_ID = a.EO_ID AND b.EO_TYPE = a.EO_TYPE) LEFT JOIN ".$intrDB.".intrm".$n."cntry c ON c.CNTRY_ID = a.EO_CNTRY_ID WHERE a.EO_TYPE='C' AND (a.POS_EO_ID = '00')";
        if ($this->db->query($w)) {
            $msg = "customer Records save successfully...";
            //$w1  = "UPDATE ".$intrDB.".intrm".$n."eo a INNER JOIN ".$posDB.".sma_companies z ON (z.eo_id = a.EO_ID AND z.eo_type = a.EO_TYPE) LEFT JOIN ".$intrDB.".intrm".$n."eo".$n."add b ON (b.EO_ID = z.eo_id AND z.eo_type = b.EO_TYPE) RIGHT JOIN ".$intrDB.".intrm".$n."eo".$n."add".$n."org c ON (c.EO_ID = z.eo_id AND z.eo_type = c.EO_TYPE) RIGHT JOIN ".$intrDB.".intrm".$n."eo".$n."org d ON (d.EO_ID = z.eo_id AND z.eo_type = d.EO_TYPE) SET a.POS_EO_ID = z.id, b.POS_EO_ID = z.id, c.POS_EO_ID = z.id, c.CREATE_FLG = '1', d.POS_EO_ID = z.id, d.CREATE_FLG = '1' WHERE z.eo_id = a.EO_ID AND z.eo_type = a.EO_TYPE";
            $w1  = "UPDATE ".$intrDB.".intrm".$n."eo a INNER JOIN ".$posDB.".sma_companies z ON (z.eo_id = a.EO_ID AND z.eo_type = a.EO_TYPE) SET a.POS_EO_ID = z.id WHERE (z.eo_id = a.EO_ID AND z.eo_type = a.EO_TYPE)";
            $this->db->query($w1);

            $w12  = "UPDATE ".$intrDB.".intrm".$n."eo".$n."add a INNER JOIN ".$posDB.".sma_companies z ON (z.eo_id = a.EO_ID AND z.eo_type = a.EO_TYPE) SET a.POS_EO_ID = z.id WHERE (z.eo_id = a.EO_ID AND z.eo_type = a.EO_TYPE)";
            $this->db->query($w12);

            $w123  = "UPDATE ".$intrDB.".intrm".$n."eo".$n."add".$n."org a INNER JOIN ".$posDB.".sma_companies z ON (z.eo_id = a.EO_ID AND z.eo_type = a.EO_TYPE) SET a.POS_EO_ID = z.id, a.CREATE_FLG = '1' WHERE (z.eo_id = a.EO_ID AND z.eo_type = a.EO_TYPE)";
            $this->db->query($w123);

            $w1234  = "UPDATE ".$intrDB.".intrm".$n."eo".$n."org a INNER JOIN ".$posDB.".sma_companies z ON (z.eo_id = a.EO_ID AND z.eo_type = a.EO_TYPE) SET a.POS_EO_ID = z.id, a.CREATE_FLG = '1' WHERE (z.eo_id = a.EO_ID AND z.eo_type = a.EO_TYPE)";
            $this->db->query($w1234);
            //echo "update<br>";
            //echo $w1;
            //exit;
            

            // added by vikas singh for transactions

            //  if ($this->db->trans_status() === FALSE)
            //   {
            //        $this->db->trans_rollback();
            //   }
            // else
            //   {
                  //$this->db->trans_commit();
                 // return $msg;
                return true;
              //}
             // end------------------
            //return $msg;
        } else {
            $msg = $this->db->error();
            return $msg['message'];
        }
    }
   
    public function customerUPD($org)
    {
        $posDB = $this->posDbName();
        $intrDB = $this->intrDbName();
        $n = '$';
       // echo "upddd";die;
        //$this->db->trans_begin();
        $w = "UPDATE ".$posDB.".sma_companies z INNER JOIN ".$intrDB.".intrm".$n."eo a ON (a.EO_ID = z.eo_id) INNER JOIN ".$intrDB.".intrm".$n."eo".$n."add b ON (b.EO_ID = a.EO_ID) LEFT JOIN ".$intrDB.".intrm".$n."cntry c ON c.CNTRY_ID = a.EO_CNTRY_ID LEFT JOIN ".$intrDB.".intrm".$n."eo".$n."org d ON (d.EO_ID = a.EO_ID) SET z.name = a.EO_NM, z.vat_no = a.VAT_NO, z.phone = a.EO_PHONE, z.email = 'Not Available', z.address = b.ADDRESS, z.country = c.CNTRY_DESC, z.sync_flg='1' WHERE a.EO_TYPE='C' AND d.UPD_FLG= '1'";
        
  //$this->db->query($w); echo "done.."; die;
        if ($this->db->query($w)) {
            $w1 = "UPDATE ".$intrDB.".intrm".$n."eo".$n."org a INNER JOIN ".$posDB.".sma_companies b ON a.POS_EO_ID = b.id SET a.UPD_FLG='2' WHERE a.POS_EO_ID = b.id";
            $this->db->query($w1);

            // added by vikas singh for transactions

            //  if ($this->db->trans_status() === FALSE)
            //   {
            //        $this->db->trans_rollback();
            //   }
            // else
            //   {
            //       $this->db->trans_commit();
                  return true;
              //}
             // end------------------

            //return true;
        }
       
        else {
            $msg = $this->db->error();
            return $msg['message'];
        }
    }
   
    // S.NO.-07 (Intermediate -> POS)

    public function productMaster_final($org)
    {
        //$this->db->trans_begin();
        //$this->productUPD_final($org);
        $arr = array();
        $result2 = array();
        $result3 = array();
        $posDB = $this->posDbName();
        $intrDB = $this->intrDbName();
        $intrintrDB = $this->intrtointrDbName();
        $n = '$'; 
        //uu
        $where = "ORG_ID='".$org."' AND POS_ITM_ID='00'";
        $this->db3
               ->select('*')
               ->where($where);
              // ->or_where('POS_ITM_ID',NULL)
               //->where('ORG_ID',$org);    
        $q =$this->db3->get($intrintrDB.".intrm".$n."prod".$n."org");
        $result =$q->result();  
       // print_r($result); die;  
        $this->db3
               ->select('ITM_ID')
               ->where($where);
               //->or_where('POS_ITM_ID',NULL) 
               //->where('ORG_ID',$org);
         $q1= $this->db3->get($intrintrDB.".intrm".$n."prod".$n."org");       

         $result1 =$q1->result();
        // echo "<pre>";
       // print_r($result1); die; 
         if(!empty($result1)){
            foreach ($result1 as $key => $value) {
                foreach ($value as $key1 => $value1) {
                     $arr[] = $value1;
                }
            }
        //print_r($arr); die;
         $q2 = $this->db3
               ->select('*')
               ->where_in('ITM_ID',$arr)
               ->get($intrintrDB.".intrm".$n."prod");

        $result2 =$q2->result();
        
        $this->db3
               ->select('*')
               ->where('ORG_ID',$org)
               ->where_in('ITM_ID',$arr);
        $q3 =$this->db3->get($intrintrDB.".intrm".$n."itm".$n."stock".$n."dtl");
        $result3 =$q3->result(); 
        }
              
     //print_r($result3); die;
         if($result && $result2 && $result3)
         {
            $aa =  $this->db2->insert_batch($intrDB.".intrm".$n."prod".$n."org",json_decode(json_encode($result), True));

            $aa1 =  $this->db2->insert_batch($intrDB.".intrm".$n."prod",json_decode(json_encode($result2), True));

            $aa2 =  $this->db2->insert_batch($intrDB.".intrm".$n."itm".$n."stock".$n."dtl",json_decode(json_encode($result3), True));
             //die;
             if($aa && $aa1 && $aa2)
             {  
                //echo "done..."; die;
                if($this->productMaster($org))
                {        
                   if($this->productWarehouseMaster($org))
                     {
                        $where1 = "CREATE_FLG='1' AND ORG_ID='".$org."' AND POS_ITM_ID !='00'";
                        $this->db2
                             ->select('POS_ITM_ID,CREATE_FLG,ORG_ID,ITM_ID')
                             ->where($where1);
                             //->or_where('POS_ITM_ID !=',NULL)
                             //->where('ORG_ID',$org)
                             //->where('CREATE_FLG',1);
                        $q4 = $this->db2->get($intrDB.".intrm".$n."prod".$n."org");
                        $result4 =$q4->result();

                        $this->db2
                             ->select('POS_ITM_ID,CREATE_FLG')
                             ->where($where1);
                             //->or_where('POS_ITM_ID !=',NULL)
                             //->where('ORG_ID',$org)
                             //->where('CREATE_FLG',1);
                        $q8 = $this->db2->get($intrDB.".intrm".$n."prod".$n."org");
                          $result8 = $q8->result();
                        $i=0;
                       foreach ($result4 as $k ) {
                        $this->db3->where('ORG_ID',$org);
                        $this->db3->where('ITM_ID',$k->ITM_ID);
                        $this->db3->update($intrintrDB.".intrm".$n."prod".$n."org",json_decode(json_encode($result8[$i]), True));
                        $i++;
                           # code...
                       }

                       $crflag = array(
                            'CREATE_FLG' => '2'
                        );

                    

                        $this->db2->where($where1);
                        // $this->db2->or_where('POS_ITM_ID !=',NULL);
                        // $this->db2->where('ORG_ID',$org);
                        // $this->db2->where('CREATE_FLG',1);
                        $this->db2->update($intrDB.".intrm".$n."prod".$n."org", $crflag);

                        // $this->db2->where('POS_GRP_ID !=','');
                        // $this->db2->or_where('POS_GRP_ID !=',NULL);
                        // $this->db2->where('ORG_ID',$org);
                        // $this->db2->where('SYNC_FLG',1);
                        // $this->db2->update($intrDB.".intrm".$n."itm".$n."stock".$n."dtl", $crflag1);

                        // if ($this->db->trans_status() === FALSE)
                        //   {
                        //        $this->db->trans_rollback();
                        //   }
                        // else
                        //   {    //$this->db->trans_commit();
                               $msg = "Product Records save successfully...";
                               return $msg;
                               //return true;
                          //}
                     }
             
                 } 
               }
          else {

                    $msg = $this->db->error();
                    return $msg['message'];
            }
           
         }
    }   
   public function productUPD_final($org)
    {
        $arr = array();
        $result2 = array();
        $result3 = array();
        $posDB = $this->posDbName();
        $intrDB = $this->intrDbName();
        $intrintrDB = $this->intrtointrDbName();
        $n = '$'; 
        //uu
        $this->db3
               ->select('*')
               ->where('UPD_FLG','1')
               ->where('ORG_ID',$org);
        $q =$this->db3->get($intrintrDB.".intrm".$n."prod".$n."org");
        $result =$q->result();  
            
        $this->db3
               ->select('ITM_ID')
               ->where('UPD_FLG','1')
               ->where('ORG_ID',$org);
        $q1= $this->db3->get($intrintrDB.".intrm".$n."prod".$n."org");       
        $result1 =$q1->result();
         
         if(!empty($result1)){
            foreach ($result1 as $key => $value) {
                foreach ($value as $key1 => $value1) {
                     $arr[] = $value1;
                }
            }
         $q2 = $this->db3
               ->select('*')
               ->where_in('ITM_ID',$arr)
               ->get($intrintrDB.".intrm".$n."prod");
            $result2 =$q2->result(); 
          

         $this->db3
               ->select('*')
               ->where('ORG_ID',$org)
               ->where_in('ITM_ID',$arr);
            $q3 =$this->db3->get($intrintrDB.".intrm".$n."itm".$n."stock".$n."dtl");
            $result3 =$q3->result();   
         } 
// print_r($result3);
// die;
         if($result && $result2 || $result3)
         {   
            //$this->db->where('ORG_ID',$org);
             $aa =  $this->db2->update_batch($intrDB.".intrm".$n."prod".$n."org", json_decode(json_encode($result)), 'ITM_ID'); 
             $aa1 = $this->db2->update_batch($intrDB.".intrm".$n."prod", json_decode(json_encode($result2)), 'ITM_ID'); 
             if(!empty($result3))
             {
             $aa2 = $this->db2->update_batch($intrDB.".intrm".$n."itm".$n."stock".$n."dtl", json_decode(json_encode($result3)), 'ITM_ID'); 
             }
             
             // if($aa && $aa1 && $aa2)
             // {  
                if($this->productUPD($org))
                {        
                 
                   if($this->productWarehouseUPD($org))
                   {
                     
                    $crflag1 = array(
                       'UPD_FLG' => NULL
                    );
                     $where1 = "UPD_FLG='1' AND ORG_ID='".$org."' AND POS_ITM_ID !='00'";
                    $this->db3->where($where1);
                    $res= $this->db3->update($intrintrDB.".intrm".$n."prod".$n."org", $crflag1);

                    // $this->db3>where('ORG_ID',$org);
                    // $this->db3->where('UPD_FLG','1');
                    // $this->db3->where('POS_ITM_ID !=','');
                    // $res2= $this->db3->update($intrintrDB.".intrm".$n."itm".$n."stock".$n."dtl", $crflag1);

                    // if($res && $res2){
                            $crflag2 = array(
                               'UPD_FLG' => NULL
                            );

                            $where1 = "UPD_FLG='2' AND ORG_ID='".$org."' AND POS_ITM_ID !='00'";
                            $this->db2->where($where1);
                            $finalres1 =$this->db2->update($intrDB.".intrm".$n."prod".$n."org", $crflag2); 
                            
                            // $this->db3->where('POS_ITM_ID !=','');
                            // $this->db3->or_where('POS_ITM_ID !=',NULL);
                            // $this->db2->where('ORG_ID',$org);
                            // $this->db2->where('UPD_FLG',2);
                            // $finalres2 =$this->db2->update($intrDB.".intrm".$n."itm".$n."stock".$n."dtl", $crflag2); 

                          //if($finalres1 && $finalres2)
                          //{


                          // if ($this->db->trans_status() === FALSE)
                          //   {
                          //        $this->db->trans_rollback();
                          //   }
                          // else
                          //   {    $this->db->trans_commit();
                                // echo "done...."; die;
                                 return true;
                           // }
                       // }      
                    //}

                          
                      //}

           
                  }

           } 
          else {

                    $msg = $this->db->error();
                    return $msg['message'];
            }
           
         }

    }    
    public function productMaster($org)
    {
       // $ar = $this->productUPD();
        $posDB = $this->posDbName();
        $intrDB = $this->intrDbName();
        $flag = 0; $flag1 = 0;
        $n = '$';
       // $this->db->trans_begin();
        //a.ITM_ID
       // $this->db->trans_begin();
        // $w  = "INSERT INTO ".$posDB.".sma_products(code,name,unit,cost,price,category_id,subcategory_id,quantity,tax_rate,details,warehouse,barcode_symbology,product_details,serialized,lot_no,sr_no,org_id,grp_id) SELECT b.ITM_LEGACY_CODE,CONCAT(b.ITM_DESC,'-',a.ITM_ID),b.UOM_BASIC,c.UOM_BASIC,c.PRICE_SLS,f.id,b.UOM_BASIC,c.AVAIL_QTY,g.id,b.ITM_LONG_DESC,e.id,'code128',b.ITM_LONG_DESC,b.SERIALIZED_FLG,c.LOT_NO,c.SR_NO,a.ORG_ID,b.GRP_ID FROM ".$intrDB.".intrm".$n."prod".$n."org a INNER JOIN ".$intrDB.".intrm".$n."prod b ON b.ITM_ID = a.ITM_ID INNER JOIN ".$posDB.".sma_warehouses e ON e.org_id = a.ORG_ID INNER JOIN ".$posDB.".sma_categories f ON f.code = b.GRP_ID LEFT JOIN   ".$intrDB.".intrm".$n."itm".$n."stock".$n."dtl c ON (c.ITM_ID = a.ITM_ID AND c.ORG_ID = a.ORG_ID) LEFT JOIN ".$posDB.".sma_tax_rates g ON (g.org_id = a.ORG_ID AND g.grp_id = b.GRP_ID) WHERE a.POS_ITM_ID = '00'";

         $w  = "INSERT INTO ".$posDB.".sma_products(code,name,unit,cost,price,category_id,subcategory_id,quantity,tax_rate,details,warehouse,barcode,barcode_symbology,product_details,serialized,lot_no,sr_no,org_id,grp_id) SELECT a.ITM_ID,b.ITM_DESC,b.UOM_BASIC,c.UOM_BASIC,c.PRICE_SLS,f.id,b.UOM_BASIC,c.AVAIL_QTY,g.id,b.ITM_LONG_DESC,e.id,b.ITM_LEGACY_CODE,'code128',b.ITM_LONG_DESC,b.SERIALIZED_FLG,c.LOT_NO,c.SR_NO,a.ORG_ID,b.GRP_ID FROM ".$intrDB.".intrm".$n."prod".$n."org a INNER JOIN ".$intrDB.".intrm".$n."prod b ON b.ITM_ID = a.ITM_ID INNER JOIN ".$posDB.".sma_warehouses e ON e.org_id = a.ORG_ID INNER JOIN ".$posDB.".sma_categories f ON f.code = b.GRP_ID LEFT JOIN   ".$intrDB.".intrm".$n."itm".$n."stock".$n."dtl c ON (c.ITM_ID = a.ITM_ID AND c.ORG_ID = a.ORG_ID) LEFT JOIN ".$posDB.".sma_tax_rates g ON (g.org_id = a.ORG_ID AND g.grp_id = b.GRP_ID) WHERE a.POS_ITM_ID = '00'";
         
           //$this->db->query($w); 
           //echo "hello"; die;
        if ($this->db->query($w)) {
            $msg = "Product Records save successfully...";
            $w1  = "UPDATE ".$intrDB.".intrm".$n."prod".$n."org a INNER JOIN ".$posDB.".sma_products b ON (a.ITM_ID = b.code AND a.ORG_ID = b.org_id) SET a.POS_ITM_ID= b.id, a.CREATE_FLG='1' WHERE a.ITM_ID = b.code AND a.ORG_ID = b.org_id";
            $this->db->query($w1);
           
           // added by vikas singh for transactions

            //  if ($this->db->trans_status() === FALSE)
            //   {
            //        $this->db->trans_rollback();
            //   }
            // else
            //   {
                  //$this->db->trans_commit();
                  //return $msg;

                return true;
             // }
             // end------------------

            //return $msg;
        } else {
            $msg = $this->db->error();
            return $msg['message'];
        }
 
        // $this->db->query($w);
 
        //    // if($this->db->affected_rows()>0){
        //    //      $flag = 1;
        //    //  }
        //    //  if (($flag==0) || ($this->db->trans_status() === FALSE))
        //    //    {
        //    //      //   $this->db->trans_rollback();
        //    //         $msg = $this->db->error();
        //    //         return $msg['message'];
        //    //    }
 
        //    $w1  = "UPDATE ".$intrDB.".intrm".$n."prod".$n."org a INNER JOIN ".$posDB.".sma_products b ON (a.ITM_ID = b.code AND a.ORG_ID = b.org_id) SET a.POS_ITM_ID= 555, a.CREATE_FLG='1' WHERE a.ITM_ID = b.code AND a.ORG_ID = b.org_id";
        //    //$w3= "UPDATE ".$intrDB.".intrm".$n."prod".$n."org a SET a.POS_ITM_ID=111 WHERE 1";
        //    //$this->db->query($w3);
        //     $this->db->query($w1);
            //echo $w1."<br>";die;
            // if($this->db->affected_rows()>0){
            //     echo "hiii";
            //     $flag1 = 1;
            // }
 
            // if ($flag1==0)
            //   {
            //     echo "1";
            //     //exit;
            //        $this->db->trans_rollback();
            //        $msg = $this->db->error();
            //        return $msg['message'];
            //   }
            // else
            //   {
            //     echo 2;
            //     //exit;
            //       $this->db->trans_commit();
            //       $msg = "Product Records save successfully...";
            //       return $msg;
            //   }
           
           
       
    }
   
    public function productUPD($org)
    {
        $posDB = $this->posDbName();
        $intrDB = $this->intrDbName();
        $n = '$';
        //$this->db->trans_begin();
        $w = "UPDATE ".$posDB.".sma_products q INNER JOIN ".$intrDB.".intrm".$n."prod".$n."org a ON q.id= a.POS_ITM_ID INNER JOIN ".$intrDB.".intrm".$n."prod b ON b.ITM_ID = a.ITM_ID INNER JOIN ".$posDB.".sma_warehouses e ON e.org_id = a.ORG_ID INNER JOIN ".$posDB.".sma_categories f ON f.code = b.GRP_ID LEFT JOIN ".$intrDB.".intrm".$n."itm".$n."stock".$n."dtl c ON (c.ITM_ID = a.ITM_ID AND c.ORG_ID = a.ORG_ID) LEFT JOIN ".$posDB.".sma_tax_rates g ON (g.org_id = a.ORG_ID AND g.grp_id = b.GRP_ID) SET q.code= a.ITM_ID,q.name= b.ITM_DESC,q.cost= c.UOM_BASIC,q.price= c.PRICE_SLS,q.category_id= f.id,q.quantity=c.AVAIL_QTY,q.tax_rate= g.id,q.details= b.ITM_LONG_DESC,q.warehouse= e.id,q.barcode= b.ITM_LEGACY_CODE,q.product_details= b.ITM_LONG_DESC,q.serialized= b.SERIALIZED_FLG,q.lot_no= c.LOT_NO,q.sr_no= c.SR_NO,q.org_id= a.ORG_ID,q.grp_id=b.GRP_ID, q.tupd_flg='1' WHERE a.UPD_FLG='1'";
        if ($this->db->query($w)) {
           
            $w1 = "UPDATE ".$intrDB.".intrm".$n."prod".$n."org a INNER JOIN ".$posDB.".sma_products b ON a.POS_ITM_ID = b.id SET a.UPD_FLG='' WHERE a.POS_ITM_ID = b.id";
            $this->db->query($w1);

            // added by vikas singh for transactions

            //  if ($this->db->trans_status() === FALSE)
            //   {
            //        $this->db->trans_rollback();
            //   }
            // else
            //   {
                 // $this->db->trans_commit();
                  return true;
              //}

             // end------------------
            //return true;
        }
       
        else {
            $msg = $this->db->error();
            return $msg['message'];
        }
    }
   
    // S.NO.-08 (Intermediate -> POS)
   
    public function productWarehouseMaster($org)
    {
        //$ar = $this->productWarehouseUPD();
        $posDB = $this->posDbName();
        $intrDB = $this->intrDbName();
       // $this->db->trans_begin();
        $w  = "INSERT INTO ".$posDB.".sma_warehouses_products(product_id,warehouse_id,lot_no,quantity,org_id,grp_id) SELECT a.id,a.warehouse,a.lot_no,a.quantity,a.org_id,a.grp_id FROM ".$posDB.".sma_products a WHERE a.trsfr_flg IS NULL OR a.trsfr_flg = ''";
        if ($this->db->query($w)) {
            $this->purchaseItemMaster($org);
            $msg = "Product Records save in warehouse successfully...";
            $w1  = "UPDATE ".$posDB.".sma_products a INNER JOIN ".$posDB.".sma_warehouses_products b ON a.id = b.product_id SET a.trsfr_flg= '1' WHERE a.id = b.product_id";
            $this->db->query($w1);

            // added by vikas singh for transactions

            //  if ($this->db->trans_status() === FALSE)
            //   {
            //        $this->db->trans_rollback();
            //   }
            // else
            //   {
                 // $this->db->trans_commit();
                 //return $msg;
                  return true;
             // }

             // end------------------
           // return $msg;
        } else {
            $msg = $this->db->error();
            return $msg['message'];
        }
    }
   
    public function productWarehouseUPD($org)
    {
        $posDB = $this->posDbName();
        $intrDB = $this->intrDbName();

        //$this->db->trans_begin();

        $w = "UPDATE ".$posDB.".sma_warehouses_products z INNER JOIN ".$posDB.".sma_products a SET z.product_id = a.id,z.warehouse_id = a.warehouse,z.lot_no = a.lot_no,z.quantity = a.quantity,z.org_id = a.org_id,z.grp_id = a.grp_id WHERE a.tupd_flg= '1'";
        if ($this->db->query($w)) {
            $this->purchaseItemUPD($org);
            $w1 = "UPDATE ".$posDB.".sma_products a INNER JOIN ".$posDB.".sma_warehouses_products b ON a.id = b.product_id SET a.tupd_flg='' WHERE a.id = b.product_id";
            $this->db->query($w1);

            // added by vikas singh for transactions

            //  if ($this->db->trans_status() === FALSE)
            //   {
            //        $this->db->trans_rollback();
            //   }
            // else
            //   {
                  //$this->db->trans_commit();
                  return true;
              //}

             // end------------------

            //return true;
        } else {
           
            $msg = $this->db->error();
            return $msg['message'];
        }
    }

    
    public function purchaseItemMaster($org)
    {
        $posDB = $this->posDbName();
        $intrDB = $this->intrDbName();
        $n = '$';
        //$this->db->trans_begin();
        $w = "INSERT INTO ".$posDB.".sma_purchase_items(product_id,product_code,product_name,net_unit_cost,quantity,warehouse_id,item_tax,tax_rate_id,tax,subtotal,quantity_balance,date,status,unit_cost,lot_no,sr_no,org_id,grp_id) SELECT a.id,a.code,a.name,(a.price -((a.price * b.rate) /(100 + b.rate))) AS unit_cost,a.quantity,a.warehouse,((a.price * b.rate) /(100 + b.rate)) AS item_tax,a.tax_rate,b.rate,a.price,a.quantity,curdate(),'received',a.price,a.lot_no,a.sr_no,a.org_id,a.grp_id FROM ".$posDB.".sma_products a INNER JOIN ".$posDB.".sma_tax_rates b ON(b.id = a.tax_rate AND b.org_id = a.org_id AND b.grp_id = a.grp_id) WHERE a.trsfr_flg IS NULL OR a.trsfr_flg = ''";
        if ($this->db->query($w)) {

            // added by vikas singh for transactions

            //  if ($this->db->trans_status() === FALSE)
            //   {
            //        $this->db->trans_rollback();
            //   }
            // else
            //   {
                 // $this->db->trans_commit();
                  $msg = "Purchase Item Master Records save successfully...";
                  return $msg;
             // }

             // end------------------
            //return true;
        } else {
            $msg = $this->db->error();
            return $msg['message'];
        }
       
    }
    public function purchaseItemUPD($org)
    {
        $posDB = $this->posDbName();
        $intrDB = $this->intrDbName();
        $n = '$';
       // $this->db->trans_begin();

        $w = "UPDATE ".$posDB.".sma_purchase_items z INNER JOIN ".$posDB.".sma_products a ON a.id= z.product_id INNER JOIN ".$posDB.".sma_tax_rates b ON(b.id = a.tax_rate AND b.org_id = a.org_id AND b.grp_id = a.grp_id) SET z.product_code = a.code, z.product_name = a.name,z.net_unit_cost = (a.price -((a.price * b.rate) /(100 + b.rate))), z.quantity = a.quantity, z.item_tax =  ((a.price * b.rate) /(100 + b.rate)), z.tax_rate_id = a.tax_rate, z.tax = b.rate, z.subtotal = a.price, z.quantity_balance = a.quantity, z.lot_no = a.lot_no, z.sr_no = a.sr_no, z.org_id = a.org_id, z.grp_id = a.grp_id WHERE a.tupd_flg= '1'";
        if ($this->db->query($w)) {

            // added by vikas singh for transactions

            //  if ($this->db->trans_status() === FALSE)
            //   {
            //        $this->db->trans_rollback();
            //   }
            // else
            //   {
                  //$this->db->trans_commit();
                  return true;
             // }

             // end------------------
            //return true;
        } else {
            $msg = $this->db->error();
            return $msg['message'];
        }
    }
 
    // S.NO.-09 (Intermediate -> POS) For inter Store Sale return
 
    public function interCVMaster($org)
    {
        $posDB = $this->posDbName();
        $intrDB = $this->intrDbName();
        $n = '$';
        $this->db->trans_begin();
        $w = "INSERT INTO ".$intrDB.".intrm".$n."credit".$n."voucher".$n."dtl(CLD_ID,SLOC_ID,HO_ORG_ID,POS_CV_ID,DATE,CARD_NO,    VALUE,EO_ID,EO_NAME,BALANCE,EXPIRY_DT,CREATE_BY,BILLER_ID,YEAR,ORG_ID,INVOICE_NO) SELECT '0000','1','N',a.id,DATE_FORMAT(a.date,'%Y-%m-%d'),a.card_no,a.value,b.eo_id,a.customer,a.balance,a.expiry,c.usr_id,c.biller_id,c.year,c.org_id,a.invoice_no FROM ".$posDB.".sma_gift_cards a INNER JOIN ".$posDB.".sma_companies b ON(a.customer_id = b.id) INNER JOIN ".$posDB.".sma_users c ON(a.created_by = c.id) WHERE a.flg IS NULL OR a.flg = ''";
  if ($this->db->query($w)) {
    $w1= "UPDATE ".$posDB.".sma_gift_cards a INNER JOIN ".$intrDB.".intrm".$n."credit".$n."voucher".$n."dtl b ON (a.id = b.POS_CV_ID) SET a.flg = '1',b.SYNC_FLG='1' WHERE a.id = b.POS_CV_ID";
    $q= $this->db->query($w1);
    $this->updCreditVoucherMaster();
    $msg = "Creadit Voucher Details Sync Successfully....";

    // added by vikas singh for transactions

             if ($this->db->trans_status() === FALSE)
              {
                   $this->db->trans_rollback();
              }
            else
              {
                  $this->db->trans_commit();
                  return $msg;
              }

             // end------------------
    //return $msg;
  } else {
       $msg = $this->db->error();
       return $msg['message'];
  }
 
    }
   
    // I.T.-01 (Pos -> intermediate) Customer
   //----------------122222222222222----------------
    public function eoMaster($org)
    {
       //$this->eoMasterUPD();
        $posDB = $this->posDbName();
        $intrDB = $this->intrDbName();
        //uu
        $n = '$';
        $this->db->trans_begin();
        $w = "INSERT INTO ".$intrDB.".intrm".$n."eo(CLD_ID,SLOC_ID,HO_ORG_ID,EO_TYPE,POS_EO_ID,EO_CATG_ID,EO_NM,EO_PHONE,VAT_NO,USR_ID_CREATE,USR_ID_CREATE_DT,USR_ID_MOD,USR_ID_MOD_DT,SYNC_FLG) SELECT '0000','1','N','C',a.id,'T002',a.name,a.phone,a.vat_no,'1',curdate(),'1',curdate(),'1' FROM ".$posDB.".sma_companies a WHERE a.id!= '1' AND a.group_name!='biller' AND (a.sync_flg IS NULL OR a.sync_flg= '')";
    if ($this->db->query($w)) {
          $w1= "INSERT INTO ".$intrDB.".intrm".$n."eo".$n."add(CLD_ID,SLOC_ID,HO_ORG_ID,EO_TYPE,POS_EO_ID,USR_ID_CREATE,USR_ID_CREATE_DT,USR_ID_MOD,USR_ID_MOD_DT,SYNC_FLG) SELECT '0000','1','N','C',a.id,'1',curdate(),'1',curdate(),'1' FROM ".$posDB.".sma_companies a WHERE a.id!= '1' AND a.group_name!='biller' AND (a.sync_flg IS NULL OR a.sync_flg= '')";
          $w2= "INSERT INTO ".$intrDB.".intrm".$n."eo".$n."add".$n."org(CLD_ID,SLOC_ID,HO_ORG_ID,ORG_ID,EO_TYPE,POS_EO_ID,CREATE_FLG,USR_ID_CREATE,USR_ID_CREATE_DT,USR_ID_MOD,USR_ID_MOD_DT) SELECT '0000','1','N',b.org_id,'C',CASE WHEN b.org_id = '".$org."' THEN a.id ELSE NULL END,'1','1',curdate(),'1',curdate() FROM ".$posDB.".sma_companies a CROSS JOIN ".$posDB.".sma_warehouses b WHERE a.id != '1' AND a.group_name != 'biller' AND(a.sync_flg IS NULL OR a.sync_flg = '')";
          $w3= "INSERT INTO ".$intrDB.".intrm".$n."eo".$n."org(CLD_ID,SLOC_ID,HO_ORG_ID,ORG_ID,EO_TYPE,POS_EO_ID,CREATE_FLG,USR_ID_CREATE,USR_ID_CREATE_DT,USR_ID_MOD,USR_ID_MOD_DT) SELECT '0000','1','N',b.org_id,'C',CASE WHEN b.org_id = '".$org."' THEN a.id ELSE NULL END,'1','1',curdate(),'1',curdate() FROM ".$posDB.".sma_companies a CROSS JOIN ".$posDB.".sma_warehouses b WHERE a.id != '1' AND a.group_name != 'biller' AND(a.sync_flg IS NULL OR a.sync_flg = '')";
          $this->db->query($w1);
          $this->db->query($w2);
          if ($this->db->query($w3)) {
             $w4 = "UPDATE ".$posDB.".sma_companies a INNER JOIN ".$intrDB.".intrm".$n."eo b ON a.id = b.POS_EO_ID SET a.sync_flg='1' WHERE a.id != '1' AND a.group_name != 'biller' AND(a.sync_flg IS NULL OR a.sync_flg = '')";
            $this->db->query($w4);

            // added by vikas singh for transactions

             if ($this->db->trans_status() === FALSE)
              {
                   $this->db->trans_rollback();
              }
            else
              {
                  $this->db->trans_commit();
                   return true;
              }

             // end------------------
            //return true;
 
          }  else {
                   $msg = $this->db->error();
                   return $msg['message'];
          }   
      } else {
            $msg = $this->db->error();
            return $msg['message'];
      }
    }

 
    public function eoMaster_final($org)
    {

      //$this->eoMasterUPD_final($org);

      if($this->eoMaster($org))
        {
            $result1 =array();
            $result3 =array();
            $posDB = $this->posDbName();
            $intrDB = $this->intrDbName();
            $intrintrDB = $this->intrtointrDbName();
            $n = '$'; 
            //uu
            // $where = "CREATE_FLG = '1'";
            // $this->db2
            //       ->select('*')
            //       ->where($where);
            //     $q = $this->db2->get($intrDB.".intrm".$n."eo".$n."org");
             
            //  $result = $q->result();
            // $where1 = "SYNC_FLG='1'";
            //  if($result)
            //  {
                 
            //      $this->db2
            //           ->select('*')
            //          ->where($where1);
            //      $q1 = $this->db2->get($intrDB.".intrm".$n."eo");
            //      $result1 = $q1->result();
            //  }

            //  $this->db2
            //       ->select('*')
            //       ->where($where);
            //     $q2 = $this->db2->get($intrDB.".intrm".$n."eo".$n."add".$n."org");
             
            // $result2 = $q2->result();

            $where = "CREATE_FLG = '1'";
            $this->db2
                  ->select('CLD_ID, SLOC_ID,HO_ORG_ID,ORG_ID,EO_ID,LOYALITY_EO_ID,POS_EO_ID,LOYALITY_POS_EO_ID, CREATE_FLG,UPD_FLG,DEL_FLG, USR_ID_CREATE,USR_ID_CREATE_DT, USR_ID_MOD,USR_ID_MOD_DT')
                  ->where($where);
                $q = $this->db2->get($intrDB.".intrm".$n."eo".$n."org");
             
             $result = $q->result();
            $where1 = "SYNC_FLG='1'";
             if($result)
             {
                 
                 $this->db2
                      ->select('*')
                     ->where($where1);
                 $q1 = $this->db2->get($intrDB.".intrm".$n."eo");
                 $result1 = $q1->result();
             }

             $this->db2
                  ->select('CLD_ID,SLOC_ID,HO_ORG_ID,ORG_ID,EO_ID,EO_TYPE,POS_EO_ID,ADDRESS_ID,POS_ADDRESS_ID,CREATE_FLG,UPD_FLG,DEL_FLG,USR_ID_CREATE,USR_ID_CREATE_DT,USR_ID_MOD,USR_ID_MOD_DT')
                  ->where($where);
                $q2 = $this->db2->get($intrDB.".intrm".$n."eo".$n."add".$n."org");
             
            $result2 = $q2->result();

            if($result2)
            {
             $this->db2
                  ->select('*')
                  ->where($where1);
                $q3 = $this->db2->get($intrDB.".intrm".$n."eo".$n."add");
             
             $result3 = $q3->result();
            }  

             if($result && $result1 && $result2 && $result3)
             {

             $aa =  $this->db3->insert_batch($intrintrDB.".intrm".$n."eo".$n."org",json_decode(json_encode($result), True));
             $aa1 =  $this->db3->insert_batch($intrintrDB.".intrm".$n."eo",json_decode(json_encode($result1), True));

             $aa2 =  $this->db3->insert_batch($intrintrDB.".intrm".$n."eo".$n."add".$n."org",json_decode(json_encode($result2), True));

            $aa3 =  $this->db3->insert_batch($intrintrDB.".intrm".$n."eo".$n."add",json_decode(json_encode($result3), True));


                 if($aa && $aa1 && $aa2 && $aa3)
                 {  
                      
                       $where11 = "ORG_ID != '".$org."'";
                       $this->db2->where($where11);
                       $this->db2->delete($intrDB.".intrm".$n."eo".$n."org");

                       $this->db2->where($where11);
                       $this->db2->delete($intrDB.".intrm".$n."eo".$n."add".$n."org"); 

                        $crflag = array(
                             'CREATE_FLG' => '2'
                        );
                        $crflag1 = array(
                             'SYNC_FLG' => '2'
                        );

                        $this->db2->where('CREATE_FLG','1');
                        $finalres1 =$this->db2->update($intrDB.".intrm".$n."eo".$n."org", $crflag);
                        $this->db2->where('SYNC_FLG','1');
                        $finalres2 =$this->db2->update($intrDB.".intrm".$n."eo", $crflag1); 
                        $this->db2->where('CREATE_FLG','1');
                        $finalres3 =$this->db2->update($intrDB.".intrm".$n."eo".$n."add".$n."org", $crflag); 
                        $this->db2->where('SYNC_FLG','1');
                        $finalres4 =$this->db2->update($intrDB.".intrm".$n."eo".$n."add", $crflag1); 
                        $this->db2->where('CREATE_FLG','1');
                        if($finalres1 && $finalres2 && $finalres3 && $finalres4)
                        {
                           $msg = "Customer Details Sync Successfully....";
                           return $msg;
                        } 
                        else {
           
                            $msg = $this->db->error();
                            return $msg['message'];
                        }
                 } 
             }
        }
        else {
           
            $msg = $this->db->error();
            return $msg['message'];
        }

    }

    public function eoMasterUPD($org)
    {
        $posDB = $this->posDbName();
        $intrDB = $this->intrDbName();
        //uu
        $n = '$';
        $this->db->trans_begin();
        $w= "UPDATE ".$intrDB.".intrm".$n."eo a INNER JOIN ".$posDB.".sma_companies b ON b.id = a.POS_EO_ID SET a.EO_NM = b.name,a.EO_PHONE = b.phone,a.VAT_NO = b.vat_no WHERE b.id!= '1' AND b.group_name!='biller' AND (b.upd_flg= '1')";
        if ($this->db->query($w)) {
            $w1= "UPDATE ".$posDB.".sma_companies a SET a.sync_flg = '0' WHERE a.id != '1' AND a.group_name != 'biller' AND (a.upd_flg= '1')";
            $this->db->query($w1);

            // added by vikas singh for transactions

             if ($this->db->trans_status() === FALSE)
              {
                   $this->db->trans_rollback();
              }
            else
              {
                  $this->db->trans_commit();
                   return true;
              }

             // end------------------
            //return true;
 
        } else {
            $msg = $this->db->error();
            return $msg['message'];
        }
    }
    // I.T.-02 (Pos -> intermediate) sale

     
     public function eoMasterUPD_final($org)
     {
        
        if($this->eoMasterUPD($org))
        {   
            $arr =array();
            $result2 =array();
            $posDB = $this->posDbName();
            $intrDB = $this->intrDbName();
            $intrintrDB = $this->intrtointrDbName();
            $n = '$'; 
            //uu

            $this->db2
                  ->select('*')
                  ->where('UPD_FLG','1');
                $q = $this->db2->get($intrDB.".intrm".$n."eo".$n."org");
             $result = $q->result();
            
             $this->db2
                  ->select('POS_EO_ID')
                  ->where('UPD_FLG','1');
                $q1 = $this->db2->get($intrDB.".intrm".$n."eo".$n."org");
             
             $result1 = $q1->result();

             if(!empty($result1)){
            foreach ($result1 as $key => $value) {
                foreach ($value as $key1 => $value1) {
                     $arr[] = $value1;
                }
            }


            $this->db2
                  ->select('*')
                  ->where_in('POS_EO_ID',$arr);
                 // ->where('UPD_FLG',1);
                $q2 = $this->db2->get($intrDB.".intrm".$n."eo");
             
             $result2 = $q2->result();
            }
             $this->db2
                  ->select('*')
                  ->where('UPD_FLG','1');
            $q3 = $this->db2->get($intrDB.".intrm".$n."eo".$n."add".$n."org");
             
             $result3 = $q3->result();


            $this->db2
                  ->select('POS_EO_ID')
                  ->where('UPD_FLG','1');
                $q4 = $this->db2->get($intrDB.".intrm".$n."eo".$n."add".$n."org");
             
            $result4 = $q4->result();

            if(!empty($result4)){
            foreach ($result4 as $key => $value5) {
                foreach ($value5 as $key2 => $value6) {
                     $arr1[] = $value6;
                }
            }
           }
            $this->db2
                  ->select('*')
                  ->where_in('POS_EO_ID',$arr1);
                  //->where('UPD_FLG','1');
                $q5 = $this->db2->get($intrDB.".intrm".$n."eo".$n."add");
             
             $result5 = $q5->result();


             if($result && $result2 && $result3 && $result5)
             {
              
             $aa =  $this->db3->update_batch($intrintrDB.".intrm".$n."eo".$n."org", json_decode(json_encode($result), True), 'EO_ID');
             $aa1 =  $this->db3->update_batch($intrintrDB.".intrm".$n."eo", json_decode(json_encode($result2), True), 'EO_ID');
             $aa2 =  $this->db3->update_batch($intrintrDB.".intrm".$n."eo".$n."add".$n."org", json_decode(json_encode($result3), True), 'EO_ID');
             $aa3 =  $this->db3->update_batch($intrintrDB.".intrm".$n."eo".$n."add", json_decode(json_encode($result5), True), 'EO_ID');


                 if($aa && $aa1 && $aa2 && $aa3)
                 {  
                        $crflag = array(
                             'UPD_FLG' => ''
                        );

                        $this->db2->where('UPD_FLG','1');
                        $finalres1 =$this->db2->update($intrDB.".intrm".$n."eo".$n."org", $crflag); 
                        //$this->db2->where('UPD_FLG','1');
                        //$finalres2 =$this->db2->update($intrDB.".intrm".$n."eo", $crflag); 
                        $this->db2->where('UPD_FLG','1');
                        $finalres3 =$this->db2->update($intrDB.".intrm".$n."eo".$n."add".$n."org", $crflag); 
                        //$this->db2->where('UPD_FLG','1');
                       // $finalres4 =$this->db2->update($intrDB.".intrm".$n."eo".$n."add", $crflag); 
                        if($finalres1 && $finalres3)
                        {
                           $msg = "Customer Details Sync Successfully....";
                           return $msg;
                        } 
                        else {
           
                            $msg = $this->db->error();
                            return $msg['message'];
                        }
                 } 
             }
        }
        else {
           
            $msg = $this->db->error();
            return $msg['message'];
        }

 

     }
 
    public function slsInvMaster($org)
    {
        $posDB = $this->posDbName();
        $intrDB = $this->intrDbName();
        $n = '$';
        $this->db->trans_begin();
       $w = "INSERT INTO ".$intrDB.".intrm".$n."sls".$n."inv(CLD_ID,SLOC_ID,HO_ORG_ID,ORG_ID,POS_DOC_ID,DOC_ID,DOC_DT,EO_ID,POS_EO_ID,SLS_REP_ID,POS_SLS_REP_ID,TAX_BASIS,TAX_ID,TAX_VAL,DISC_BASIS,DISC_TYPE,POS_INV_TOTAL,DISC_VAL,DISC_TOTAL_VAL,SYNC_FLG) SELECT '0000','1','N',b.org_id,a.id,a.reference_no,DATE_FORMAT(a.date,'%Y-%m-%d'),c.eo_id,a.customer_id,d.usr_id,a.sales_executive_id,'NULL',a.order_tax_id,a.total_tax,'NULL','NULL',a.grand_total,a.total_discount,a.total_discount,'1' FROM ".$posDB.".sma_sales a INNER JOIN ".$posDB.".sma_warehouses b ON (a.warehouse_id = b.id) INNER JOIN ".$posDB.".sma_companies c ON (a.customer_id = c.id) INNER JOIN ".$posDB.".sma_users d ON (a.sales_executive_id = d.id) WHERE a.sync_flg IS NULL OR a.sync_flg = ''";
        if ($this->db->query($w)) {
            $count = $this->db->affected_rows();
            if($count>0){
            $w1  = "UPDATE ".$posDB.".sma_sales a INNER JOIN ".$intrDB.".intrm".$n."sls".$n."inv b ON a.id = b.POS_DOC_ID SET a.sync_flg = '1' WHERE a.id = b.POS_DOC_ID";
            $q   = $this->db->query($w1);
             }
            $msg = "Sales Details Sync Successfully....";

            // added by vikas singh for transactions

             if ($this->db->trans_status() === FALSE)
              {
                   $this->db->trans_rollback();
              }
            else
              {
                  $this->db->trans_commit();
                   return $msg;
              }

             // end------------------
           // return $msg;
        } else {
           
            $msg = $this->db->error();
            return $msg['message'];
        }
    }
   

   public function slsInvMaster_final($org)
    {

        if($this->slsInvMaster($org))
        {
            $posDB = $this->posDbName();
            $intrDB = $this->intrDbName();
            $intrintrDB = $this->intrtointrDbName();
            $n = '$'; 
            ////uu
            $this->db2
                   ->select('*')
                   ->where('SYNC_FLG','1');
                   $q =$this->db2->get($intrDB.".intrm".$n."sls".$n."inv");
             
             $result = $q->result();
             //print_r($result); die;
             if($result)
             {

             $aa =  $this->db3->insert_batch($intrintrDB.".intrm".$n."sls".$n."inv",json_decode(json_encode($result), True));

                 if($aa)
                 {  
                        $crflag = array(
                             'SYNC_FLG' => '2'
                        );

                        $this->db2->where('SYNC_FLG','1');
                        $finalres1 =$this->db2->update($intrDB.".intrm".$n."sls".$n."inv", $crflag); 
                        if($finalres1)
                        {
                           $msg = "Sales Details Sync Successfully....";
                           return $msg;
                        } 
                        else {
           
                            $msg = $this->db->error();
                            return $msg['message'];
                        }
                 } 
             }
        }
        else {
           
            $msg = $this->db->error();
            return $msg['message'];
        }
    }
   

   
    // I.T.-03 (Pos -> intermediate) sale Item
 
    public function slsInvItmMaster($org)
    {
        $posDB = $this->posDbName();
        $intrDB = $this->intrDbName();
        $n = '$';
        $this->db->trans_begin();
        $w = "INSERT INTO ".$intrDB.".intrm".$n."sls".$n."inv".$n."itm(CLD_ID,SLOC_ID,HO_ORG_ID,ORG_ID,POS_DOC_ID,DOC_ID,ITM_ID,POS_ITM_ID,SR_NO,LOT_NO,ITM_QTY,   POS_ITM_UOM_BS,SLS_PRICE,TAX_VAL,DISC_TOTAL_VAL,DISC_TYPE,DISC_VAL,ITM_TOTAL_VAL,SYNC_FLG) SELECT '0000','1','N',b.org_id,a.id,a.sale_id,a.product_code,a.product_id,c.sr_no,c.lot_no,a.quantity,a.net_unit_price,a.real_unit_price,a.item_tax,a.item_discount,
  'NULL',a.discount,a.subtotal,'1' FROM ".$posDB.".sma_sale_items a INNER JOIN ".$posDB.".sma_warehouses b ON (a.warehouse_id = b.id) INNER JOIN ".$posDB.".sma_products c ON (a.product_id = c.id) WHERE a.sync_flg IS NULL OR a.sync_flg = ''";
        if ($this->db->query($w)) {
            $count = $this->db->affected_rows();
            if($count>0){
            $w1  = "UPDATE ".$posDB.".sma_sale_items a INNER JOIN ".$intrDB.".intrm".$n."sls".$n."inv".$n."itm b ON a.id = b.POS_DOC_ID SET a.sync_flg='1' WHERE a.id = b.POS_DOC_ID";
            $q   = $this->db->query($w1);
        }
            // added by vikas singh for transactions

             if ($this->db->trans_status() === FALSE)
              {
                   $this->db->trans_rollback();
              }
            else
              {
                  $this->db->trans_commit();
                  $msg = "Sales Item Details Sync Successfully....";
                  return $msg;
              }

             // end------------------
            //$msg = "Sales Item Details Sync Successfully....";
            //return $msg;
        } else {
            $msg = $this->db->error();
            return $msg['message'];
        }
    }
   
   public function slsInvItmMaster_final($org)
    {
        if($this->slsInvItmMaster($org))
        {
            $posDB = $this->posDbName();
            $intrDB = $this->intrDbName();
            $intrintrDB = $this->intrtointrDbName();
            $n = '$'; 
            ////uu
            $this->db2
                   ->select('*')
                   ->where('SYNC_FLG','1');
                   $q =$this->db2->get($intrDB.".intrm".$n."sls".$n."inv".$n."itm");
             
             $result = $q->result();
             if($result)
             {

             $aa =  $this->db3->insert_batch($intrintrDB.".intrm".$n."sls".$n."inv".$n."itm",json_decode(json_encode($result), True));

                 if($aa)
                 {  
                        $crflag = array(
                            'SYNC_FLG' => '2'
                        );

                        $this->db2->where('SYNC_FLG','1');
                        $finalres1 =$this->db2->update($intrDB.".intrm".$n."sls".$n."inv".$n."itm", $crflag); 
                        if($finalres1)
                        {
                           $msg = "Sales Item Details Sync Successfully....";
                           return $msg;
                        } 
                        else {
           
                            $msg = $this->db->error();
                            return $msg['message'];
                        }
                 } 
             }
        }
        else {
           
            $msg = $this->db->error();
            return $msg['message'];
        }
    }

    // I.T.-04 (Pos -> intermediate) sale return
 
    public function slsRmaMaster($org)
    {
        $posDB = $this->posDbName();
        $intrDB = $this->intrDbName();
        $n = '$';
        $this->db->trans_begin();
        $w = "INSERT INTO ".$intrDB.".intrm".$n."sls".$n."rma(CLD_ID,SLOC_ID,HO_ORG_ID,ORG_ID,POS_DOC_ID,DOC_ID,DOC_DT,REF_INV_DOC_ID,EO_ID,POS_EO_ID,REF_VOUCHER_ID,SYNC_FLG) SELECT '0000','1','N',b.org_id,a.id,a.reference_no,DATE_FORMAT(a.date,'%Y-%m-%d'),a.sale_id,c.eo_id,a.customer_id,d.id,'1' FROM ".$posDB.".sma_return_sales a INNER JOIN ".$posDB.".sma_warehouses b ON (a.warehouse_id = b.id) INNER JOIN ".$posDB.".sma_companies c ON (a.customer_id = c.id) INNER JOIN ".$posDB.".sma_gift_cards d ON (a.sales_reference_no = d.invoice_no) WHERE a.sync_flg IS NULL OR a.sync_flg = ''";
        if ($this->db->query($w)) {
            $count = $this->db->affected_rows();
            if($count>0){
            $w1  = "UPDATE ".$posDB.".sma_return_sales a INNER JOIN ".$intrDB.".intrm".$n."sls".$n."rma b ON a.id = b.POS_DOC_ID SET a.sync_flg='1' WHERE a.id = b.POS_DOC_ID";
            $q   = $this->db->query($w1);
            }
            // added by vikas singh for transactions

             if ($this->db->trans_status() === FALSE)
              {
                   $this->db->trans_rollback();
              }
            else
              {
                  $this->db->trans_commit();
                   $msg = "Sales Return Details Sync Successfully....";
                   return $msg;
              }

             // end------------------
            //$msg = "Sales Return Details Sync Successfully....";
            //return $msg;
        } else {
            $msg = $this->db->error();
            return $msg['message'];
        }
    }
   

   public function slsRmaMaster_final($org)
    {
        if($this->slsRmaMaster($org))
        {
            $posDB = $this->posDbName();
            $intrDB = $this->intrDbName();
            $intrintrDB = $this->intrtointrDbName();
            $n = '$'; 
            ////uu
            $this->db2
                   ->select('*')
                   ->where('SYNC_FLG','1');
                   $q =$this->db2->get($intrDB.".intrm".$n."sls".$n."rma");
             
             $result = $q->result();
             if($result)
             {

             $aa =  $this->db3->insert_batch($intrintrDB.".intrm".$n."sls".$n."rma",json_decode(json_encode($result), True));

                 if($aa)
                 {  
                        $crflag = array(
                            'SYNC_FLG' => '2'
                        );

                        $this->db2->where('SYNC_FLG','1');
                        $finalres1 =$this->db2->update($intrDB.".intrm".$n."sls".$n."rma", $crflag); 
                        if($finalres1)
                        {
                           $msg = "Sales Return Details Sync Successfully....";
                           return $msg;
                        } 
                        else {
           
                            $msg = $this->db->error();
                            return $msg['message'];
                        }
                 } 
             }
        }
        else {
           
            $msg = $this->db->error();
            return $msg['message'];
        }
    }


    // I.T.-05 (Pos -> intermediate) Return sale Item
 
    public function slsRmaItmMaster($org)
    {
        $posDB = $this->posDbName();
        $intrDB = $this->intrDbName();
        $n = '$';
        $this->db->trans_begin();
        $w = "INSERT INTO ".$intrDB.".intrm".$n."sls".$n."rma".$n."itm(CLD_ID,SLOC_ID,HO_ORG_ID,ORG_ID,POS_DOC_ID,DOC_ID,ITM_ID,POS_ITM_ID,SR_NO,LOT_NO,ITM_QTY,POS_ITM_UOM_BS,SLS_PRICE,TAX_VAL,DISC_TOTAL_VAL,DISC_TYPE,DISC_VAL,ITM_TOTAL_VAL,SYNC_FLG) SELECT '0000','1','N',b.org_id,a.id,a.return_id,a.product_code,a.product_id,c.sr_no,c.lot_no,a.quantity,a.net_unit_price,a.real_unit_price,a.item_tax,a.item_discount,'NULL',a.discount,a.subtotal,'1' FROM ".$posDB.".sma_return_items a INNER JOIN ".$posDB.".sma_warehouses b ON (a.warehouse_id = b.id) INNER JOIN ".$posDB.".sma_products c ON (a.product_id = c.id) WHERE a.sync_flg IS NULL OR a.sync_flg = ''";
        if ($this->db->query($w)) {
            $count = $this->db->affected_rows();
            if($count>0){
            $w1  = "UPDATE ".$posDB.".sma_return_items a INNER JOIN ".$intrDB.".intrm".$n."sls".$n."rma".$n."itm b ON a.id = b.POS_DOC_ID SET a.sync_flg='1' WHERE a.id = b.POS_DOC_ID";
            $q   = $this->db->query($w1);
             }
            // added by vikas singh for transactions

             if ($this->db->trans_status() === FALSE)
              {
                   $this->db->trans_rollback();
              }
            else
              {
                  $this->db->trans_commit();
                   $msg = "Sales Return Item Details Sync Successfully....";
                   return $msg;
              }

             // end------------------
            //$msg = "Sales Return Item Details Sync Successfully....";
            //return $msg;
        } else {
            $msg = $this->db->error();
            return $msg['message'];
        }
    }
 


    public function slsRmaItmMaster_final($org)
    {
        if($this->slsRmaItmMaster($org))
        {
            $posDB = $this->posDbName();
            $intrDB = $this->intrDbName();
            $intrintrDB = $this->intrtointrDbName();
            $n = '$'; 
            ////uu
            $this->db2
                   ->select('*')
                   ->where('SYNC_FLG','1');
                   $q =$this->db2->get($intrDB.".intrm".$n."sls".$n."rma".$n."itm");
             
             $result = $q->result();
             if($result)
             {

             $aa =  $this->db3->insert_batch($intrintrDB.".intrm".$n."sls".$n."rma".$n."itm",json_decode(json_encode($result), True));

                 if($aa)
                 {  
                        $crflag = array(
                            'SYNC_FLG' => '2'
                        );

                        $this->db2->where('SYNC_FLG','1');
                        $finalres1 =$this->db2->update($intrDB.".intrm".$n."sls".$n."rma".$n."itm", $crflag); 
                        if($finalres1)
                        {
                           $msg = "Sales Return Item Details Sync Successfully....";
                           return $msg;
                        } 
                        else {
           
                            $msg = $this->db->error();
                            return $msg['message'];
                        }
                 } 
             }
        }
        else {
           
            $msg = $this->db->error();
            return $msg['message'];
        }
    }

 
    // I.T.-06 (Pos -> intermediate) Payment Details Sync
 
   
    public function PaymntMaster($org)
    {
        $posDB = $this->posDbName();
        $intrDB = $this->intrDbName();
        $n = '$';
        $this->db->trans_begin();
        $w = "INSERT INTO ".$intrDB.".intrm".$n."payment".$n."dtl(CLD_ID,SLOC_ID,HO_ORG_ID,ORG_ID,POS_PAYMNT_ID,POS_INV_NO,PAYMNT_DT,EO_ID,POS_EO_ID,PAID_BY,CARD_TYPE,CC_NM,CC_HOLDER,CC_MONTH,CC_YEAR,CC_TYPE,AMOUNT,APPROVAL_NO,SYNC_FLG,USR_ID_CREATE,USR_ID_CREATE_DT,USR_ID_MOD,USR_ID_MOD_DT) SELECT '0000','1','N',c.org_id,a.id,b.reference_no,
    DATE_FORMAT(a.date,'%Y-%m-%d'),d.eo_id,b.customer_id,a.paid_by,CASE WHEN a.paid_by = 'cash' OR a.paid_by = 'credit_voucher' THEN '' ELSE a.card_type END AS Card_Type,a.cc_no,a.cc_holder,a.cc_month,a.cc_year,CASE WHEN
    a.paid_by = 'cash' OR a.paid_by = 'credit_voucher' THEN '' ELSE a.cc_type END AS CC_Type,a.amount,a.approval_no,'1','1',curdate(),
    '1',curdate()  FROM ".$posDB.".sma_payments a INNER JOIN ".$posDB.".sma_sales b ON (a.sale_id = b.id) INNER JOIN ".$posDB.".sma_warehouses c ON (b.warehouse_id = c.id) INNER JOIN ".$posDB.".sma_companies d ON (b.customer_id = d.id) WHERE
  a.sync_flg IS NULL OR a.sync_flg= ''";
  //echo $w; die;
  if ($this->db->query($w)) {
    $count = $this->db->affected_rows();
    if($count>0){
    $w1= "UPDATE ".$posDB.".sma_payments a INNER JOIN ".$intrDB.".intrm".$n."payment".$n."dtl b ON (a.id = b.POS_PAYMNT_ID) SET a.sync_flg = '1' WHERE a.id = b.POS_PAYMNT_ID";
    $q= $this->db->query($w1);
    }
    // added by vikas singh for transactions

     if ($this->db->trans_status() === FALSE)
      {
           $this->db->trans_rollback();
      }
    else
      {
          $this->db->trans_commit();
           $msg = "Payment Details Sync Successfully....";
           return $msg;
      }

     // end------------------

    //$msg = "Payment Details Sync Successfully....";
    //return $msg;
  } else {
       $msg = $this->db->error();
       return $msg['message'];
  }
 
    }
 

  public function PaymntMaster_final($org)
    {
        if($this->PaymntMaster($org))
        {
            $posDB = $this->posDbName();
            $intrDB = $this->intrDbName();
            $intrintrDB = $this->intrtointrDbName();
            $n = '$'; 
            ////uu
            $this->db2
                   ->select('*')
                   ->where('SYNC_FLG','1');
                   $q =$this->db2->get($intrDB.".intrm".$n."payment".$n."dtl");
             
             $result = $q->result();

             if($result)
             {

             $aa =  $this->db3->insert_batch($intrintrDB.".intrm".$n."payment".$n."dtl",json_decode(json_encode($result), True));

                 if($aa)
                 {  
                        $crflag = array(
                            'SYNC_FLG' => '2'
                        );

                        $this->db2->where('SYNC_FLG','1');
                        $finalres1 =$this->db2->update($intrDB.".intrm".$n."payment".$n."dtl", $crflag); 
                        if($finalres1)
                        {
                           $msg = "Payment Details Sync Successfully....";
                           return $msg;
                        } 
                        else {
           
                            $msg = $this->db->error();
                            return $msg['message'];
                        }
                 } 
             }
        }
        else {
           
            $msg = $this->db->error();
            return $msg['message'];
        }
    }

 
    // I.T.-07 (Pos -> intermediate) Credit Voucher Details Sync
 
   
    public function creditVoucherMaster()
    {
        //$ar= $this->updCreditVoucherMaster();
        $posDB = $this->posDbName();
        $intrDB = $this->intrDbName();
        $n = '$';
        $this->db->trans_begin();
        $w = "INSERT INTO ".$intrDB.".intrm".$n."credit".$n."voucher".$n."dtl(CLD_ID,SLOC_ID,HO_ORG_ID,POS_CV_ID,DATE,CARD_NO,VALUE,EO_ID,EO_NAME,BALANCE,EXPIRY_DT,CREATE_BY,BILLER_ID,YEAR,ORG_ID,INVOICE_NO,COUNT_FLG,SYNC_FLG) SELECT '0000','1','N',a.id,DATE_FORMAT(a.date,'%Y-%m-%d'),a.card_no,a.value,b.eo_id,a.customer,a.balance,a.expiry,c.usr_id,a.biller_id,a.year,c.org_id,a.invoice_no,'1','1' FROM ".$posDB.".sma_gift_cards a INNER JOIN ".$posDB.".sma_companies b ON(a.customer_id = b.id) INNER JOIN ".$posDB.".sma_users c ON(a.created_by = c.id) WHERE (a.flg IS NULL OR a.flg = '' OR a.flg = 'NULL')";
  if ($this->db->query($w)) {
    $count = $this->db->affected_rows();
    if($count>0){
    $w1= "UPDATE ".$posDB.".sma_gift_cards a INNER JOIN ".$intrDB.".intrm".$n."credit".$n."voucher".$n."dtl b ON (a.id = b.POS_CV_ID) SET a.flg = '1' WHERE a.id = b.POS_CV_ID";
    $q= $this->db->query($w1);
    }
    
    //$this->updCreditVoucherMaster();

    //added by vikas singh for transactions

     if ($this->db->trans_status() === FALSE)
      {
           $this->db->trans_rollback();
      }
    else
      {
          $this->db->trans_commit();
           $msg = "Creadit Voucher Details Sync Successfully....";
           return $msg;
      }

     // end------------------

    //$msg = "Creadit Voucher Details Sync Successfully....";
    //return $msg;
  } else {
       $msg = $this->db->error();
       return $msg['message'];
  }
 
    }

  public function creditVoucherMaster_final($org)
    {

        $this->updCreditVoucherMaster_final($org);

        if($this->creditVoucherMaster())
        {
            $posDB = $this->posDbName();
            $intrDB = $this->intrDbName();
            $intrintrDB = $this->intrtointrDbName();
            $n = '$'; 
            ////uu
            $this->db2
                   ->select('*')
                   ->where('SYNC_FLG','1');
                   $q =$this->db2->get($intrDB.".intrm".$n."credit".$n."voucher".$n."dtl");
             
             $result = $q->result();
            
             if($result)
             {

             $aa =  $this->db3->insert_batch($intrintrDB.".intrm".$n."credit".$n."voucher".$n."dtl",json_decode(json_encode($result), True));

                 if($aa)
                 {  
                        $crflag = array(
                            'SYNC_FLG' => '2'
                        );

                        $this->db2->where('SYNC_FLG','1');
                        $finalres1 =$this->db2->update($intrDB.".intrm".$n."credit".$n."voucher".$n."dtl", $crflag); 
                        if($finalres1)
                        {
                           $msg = "Credit Voucher Details Sync Successfully....";
                           return $msg;
                        } 
                        else {
           
                            $msg = $this->db->error();
                            return $msg['message'];
                        }
                 } 
             }
        }
        else {
           
            $msg = $this->db->error();
            return $msg['message'];
        }

    }


 
  public function updCreditVoucherMaster($org)
    {
        $posDB = $this->posDbName();
        $intrDB = $this->intrDbName();
        $n = '$';
        $this->db->trans_begin();
        $w = "UPDATE ".$intrDB.".intrm".$n."credit".$n."voucher".$n."dtl a INNER JOIN ".$posDB.".sma_gift_cards b ON (b.id = a.POS_CV_ID) SET a.BALANCE = b.balance, a.UPD_FLG='1' WHERE b.upd_flg = '1' AND (b.id = a.POS_CV_ID) ";
  if ($this->db->query($w)) {
    $w1= "UPDATE ".$posDB.".sma_gift_cards a SET a.upd_flg = '' WHERE a.upd_flg= '1' ";
    $q= $this->db->query($w1);

    // added by vikas singh for transactions

     if ($this->db->trans_status() === FALSE)
      {
           $this->db->trans_rollback();
      }
    else
      {
          $this->db->trans_commit();
          $msg = "Creadit Voucher Update Details Sync Successfully....";
           return $msg;
      }

     // end------------------
    // $msg = "Creadit Voucher Update Details Sync Successfully....";
   //return $msg;
  } else {
       $msg = $this->db->error();
       return $msg['message'];
  }
 
}

 public function updCreditVoucherMaster_final($org)
    {

        if($this->updCreditVoucherMaster())
        {
            $posDB = $this->posDbName();
            $intrDB = $this->intrDbName();
            $intrintrDB = $this->intrtointrDbName();
            $n = '$'; 
            //uu
            $this->db2
                   ->select('BALANCE,INVOICE_NO');
                   //$this->db2->where('ORG_ID',$org);
                   $this->db2->where('UPD_FLG','1');
                   $q =$this->db2->get($intrDB.".intrm".$n."credit".$n."voucher".$n."dtl");
             
             $result = $q->result();

             if($result)
             {

             $aa = $this->db3->update_batch($intrintrDB.".intrm".$n."credit".$n."voucher".$n."dtl", json_decode(json_encode($result)), 'INVOICE_NO'); 

                 if($aa)
                 {  
                        $crflag = array(
                            'UPD_FLG' => ''
                        );
                        
                        $this->db2->where('UPD_FLG','1');

                        $finalres1 =$this->db2->update($intrDB.".intrm".$n."credit".$n."voucher".$n."dtl", $crflag); 
                        if($finalres1)
                        {
                            $msg = "Creadit Voucher Update Details Sync Successfully....";
                           return $msg;
                        } 
                        else {
           
                            $msg = $this->db->error();
                            return $msg['message'];
                        }
                 } 
             }
        }
        else {
           
            $msg = $this->db->error();
            return $msg['message'];
        }

    }
 
    // I.T.-009 (intermediate -> POS) Credit Voucher Details Sync
 
    public function cvMaster($invoice_no)
    {
        $posDB = $this->posDbName();
        $intrDB = $this->intrDbName();
        $n = '$';
        //$this->db->trans_begin();
        // $w = "INSERT INTO ".$posDB.".sma_gift_cards(date,card_no,value,customer_id,customer,balance,expiry,created_by,biller_id,year,invoice_no,wid,flg) SELECT DATE_FORMAT(a.DATE,'%Y-%m-%d'),a.CARD_NO,a.VALUE,b.POS_EO_ID,a.EO_NAME,a.BALANCE,a.EXPIRY_DT,c.POS_USR_ID,a.BILLER_ID,a.YEAR,a.INVOICE_NO,d.POS_ORG_ID,'1' FROM ".$intrDB.".intrm".$n."credit".$n."voucher".$n."dtl a INNER JOIN ".$intrDB.".intrm".$n."eo b ON (a.EO_ID = b.EO_ID) INNER JOIN ".$intrDB.".intrm".$n."usr c ON (a.CREATE_BY = c.USR_ID) INNER JOIN ".$intrDB.".intrm".$n."org d ON (a.ORG_ID = d.ORG_ID) WHERE a.INVOICE_NO = '".$invoice_no."' AND (b.EO_TYPE='C') AND (c.ORG_ID = a.ORG_ID) AND a.COUNT_FLG = '1'";
        $w = "INSERT INTO ".$posDB.".sma_gift_cards(date,card_no,value,customer_id,customer,balance,expiry,biller_id,year,invoice_no,wid,flg) SELECT DATE_FORMAT(a.DATE,'%Y-%m-%d'),a.CARD_NO,a.VALUE,b.POS_EO_ID,a.EO_NAME,a.BALANCE,a.EXPIRY_DT,a.BILLER_ID,a.YEAR,a.INVOICE_NO,d.POS_ORG_ID,'1' FROM ".$intrDB.".intrm".$n."credit".$n."voucher".$n."dtl a INNER JOIN ".$intrDB.".intrm".$n."eo b ON (a.EO_ID = b.EO_ID) INNER JOIN ".$intrDB.".intrm".$n."org d ON (a.ORG_ID = d.ORG_ID) WHERE a.INVOICE_NO = '".$invoice_no."' AND (b.EO_TYPE='C') AND a.COUNT_FLG = '1'";
  if ($this->db->query($w)) {
    $w1= "UPDATE ".$intrDB.".intrm".$n."credit".$n."voucher".$n."dtl a INNER JOIN ".$posDB.".sma_gift_cards b ON (b.id = a.POS_CV_ID) SET a.COUNT_FLG='2' WHERE (b.id = a.POS_CV_ID)";

    // added by vikas singh for transactions

    //  if ($this->db->trans_status() === FALSE)
    //   {
    //        $this->db->trans_rollback();
    //   }
    // else
    //   {
          $this->db->trans_commit();
          $msg = "Creadit Voucher Details Sync Successfully....";
           return $msg;
      //}

     // end------------------

    //$msg = "Creadit Voucher Details Sync Successfully....";
    //return $msg;
  } else {
       $msg = $this->db->error();
       return $msg['message'];
  }
 
    }
 
 public function cvMaster_final($invoice_no)
  {
            $posDB = $this->posDbName();
            $intrDB = $this->intrDbName();
            $intrintrDB = $this->intrtointrDbName();
            $n = '$'; 
            $where = "INVOICE_NO='".$invoice_no."' AND SYNC_FLG ='1' ";
            $this->db3
                   ->select('*')
                   ->where($where);
           $q =$this->db3->get($intrintrDB.".intrm".$n."credit".$n."voucher".$n."dtl");
           $result = $q->result();
           //print_r($result); die;
           if($result)
            {

            $aa =  $this->db2->insert_batch($intrDB.".intrm".$n."credit".$n."voucher".$n."dtl",json_decode(json_encode($result), True));

                if($aa)
                 {  
                    if($this->cvMaster($invoice_no))
                      { 

                          $crflag = array(
                              'SYNC_FLG' => '2'
                          );
                          //$where = "SYNC_FLG IS NULL OR SYNC_FLG ='NULL'";
                          $where1 = "INVOICE_NO='".$invoice_no."' AND SYNC_FLG ='1'";
                          $this->db3->where($where1);
                          $finalres1 =$this->db3->update($intrintrDB.".intrm".$n."credit".$n."voucher".$n."dtl", $crflag); 
                        if($finalres1)
                        {
                           $msg = "Credit Voucher Details Sync Successfully....";
                           return true;
                           //return $msg;
                        } 
                        else {
           
                            $msg = $this->db->error();
                            return $msg['message'];
                      }
                 } 
               }
          }
        else {
           
            $msg = $this->db->error();
            return $msg['message'];
        }

  }

 
    // I.T.-08 (Pos -> intermediate) Update Qty
 
 
    public function updQty()
    {
        $posDB = $this->posDbName();
        $intrDB = $this->intrDbName();
        $n = '$';
        $this->db->trans_begin();
        $w = "UPDATE ".$intrDB.".intrm".$n."itm".$n."stock".$n."dtl p INNER JOIN ".$posDB.".sma_products a ON (p.ITM_ID = a.code AND p.ORG_ID = a.org_id AND p.LOT_NO = a.lot_no) SET p.AVAIL_QTY = FLOOR(a.quantity) WHERE a.psale='1'";
        if ($this->db->query($w)) {
            $w1 = "UPDATE ".$posDB.".sma_products a SET a.psale='' WHERE a.psale='1'";
            $this->db->query($w1);
            // added by vikas singh for transactions

             if ($this->db->trans_status() === FALSE)
              {
                   $this->db->trans_rollback();
              }
            else
              {
                  $this->db->trans_commit();
                  $msg = "Product Qty Update Successfully....";
                  return $msg;
              }

             // end------------------
            //$msg = "Product Qty Update Successfully....";
            //return $msg;
        }
       
        else {
            $msg = $this->db->error();
            return $msg['message'];
        }
    }
    

    public function updQty_final()
    {
        if($this->updQty())
        {

            $posDB = $this->posDbName();
            $intrDB = $this->intrDbName();
            $intrintrDB = $this->intrtointrDbName();
            $n = '$'; 
            //uu
            $this->db2
                 ->select('*');
                // ->where('SYNC_FLG',1); 
                 if(isset($org))
                 {
                    $this->db2->where('ORG_ID',$org);
                 }

            $q = $this->db2->get($intrDB.".intrm".$n."itm".$n."stock".$n."dtl");
       
            $result = $q->result();
            if(!empty($result))
            {  
               
                $this->db2
                     ->select('AVAIL_QTY')
                     //->where('SYNC_FLG',1)
                     ->where_in('ITM_ID',$result->ITM_ID)
                     ->where_in('LOT_NO',$result->LOT_NO);
                if(isset($org))
                 {
                    $this->db2->where('ORG_ID',$org);
                 }

                $q2 = $this->db2->get($intrDB.".intrm".$n."itm".$n."stock".$n."dtl");
                $result2 =$q2->result();
            }

             if($result2)
             {
                  //print_r($result2); die;
                  $aa = $this->db3->update_batch($intrintrDB.".intrm".$n."itm".$n."stock".$n."dtl", json_decode(json_encode($result2),true), 'ORG_ID'); 

                 if($aa)
                 { 
                      $crflag = array(
                            'SYNC_FLG' => ''
                        );
                        
                        $this->db2->where('SYNC_FLG',1);
                        if(isset($org))
                        {
                            $this->db2->where('ORG_ID',$org);
                        }

                        $finalres1 =$this->db2->update($intrDB.".intrm".$n."itm".$n."stock".$n."dtl", $crflag); 
                        if($finalres1)
                        {
                           $msg = "Product Qty Update Successfully....";
                           return $msg;
                        } 
                        else {
           
                            $msg = $this->db->error();
                            return $msg['message'];
                        }
                 }   
            }
        }
          else {

                $msg = $this->db->error();
                return $msg['message'];
        } 
    }
   
   
    // Sync all intermediate table to POS data base
 
 
    public function syncToPos($org)
    {

         $this->currencyMaster_final();
         $this->warehouseMaster_final(); // Warehouse master should be run before userMaster
         $this->userMaster_final($org);
         $this->taxMaster_final($org); // Tax master should be run before categoryMaster
                                             //$this->categoryMaster($org);
         $this->customerMaster_final($org);
         $this->productMaster_final($org); // Product master should be run before productWarehouseMaster
                                            //$this->productWarehouseMaster();
        return true;
    }
 
   
    // Sync all pos data table to intermediate data base
 
    public function syncToIntermediate($org)
    {
          $this->eoMaster_final($org);
          $this->slsInvMaster_final($org);
          $this->slsInvItmMaster_final($org);
          $this->slsRmaMaster_final($org);
          $this->slsRmaItmMaster_final($org);
          $this->PaymntMaster_final($org);
          $this->creditVoucherMaster_final();
        return true;
    }

 // Empty POS DB
    public function emptyPOS()
    {  //echo "hi..."; die;
    //echo $org= $this->input->get('org'); die;
    /*if(!empty($org)){
      $q = "CALL emptyPOSdb()"; // Call procedure
             if($this->db->query($q))
           {
                 $ar = $this->intrmPOSIDempty(); // Call procedure
         if($ar)
         {
           $ar1 = $this->centralintrmPOSIDempty(); // Call procedure
           return TRUE;
         }
                  return false;
                }
            return false;
     }
      return false; */ 
    }
   
    // Empty Intermediate POS ID feild   
    public function intrmPOSIDempty()
    {
        $CI = &get_instance();
        $this->db2 = $CI->load->database('db2', TRUE);
        //$intrDB = $this->db2->database;
        $q = "CALL POSIDemptyIntrmDb()"; // Call procedure
        if($this->db2->query($q))
        {
            return TRUE;
        }
        return false;
    }   
  // Empty Central Intermediate POS ID feild   
    public function centralintrmPOSIDempty()
    {
        $CI = &get_instance();
        $this->db3 = $CI->load->database('db3', TRUE);
        $org= $this->input->get('org');
        $q = $this->db3->query("CALL emptyServerIntermdb('".$org."')"); // Call procedure
       if($this->db3->query($q))
        {
            return TRUE;
        }
        return false;
    }   

    public function getwarehouselist()
    {
      
       $posDB = $this->posDbName();
       $intrDB = $this->intrDbName();
       $intrintrDB = $this->intrtointrDbName();
       $n = '$'; 
       ////uu 
       $q = $this->db3
                   ->select('ORG_ID,ORG_CITY')
                   ->get($intrintrDB.".intrm".$n."org");
             $result =$q->result();
             //print_r($result); die;
             return $result;
      
  } 
}

?>

