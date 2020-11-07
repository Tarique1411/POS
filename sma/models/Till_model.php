<?php defined('BASEPATH') OR exit('No direct script access allowed');

	class Till_model extends CI_Model
	{
		
		public function __construct()
		{
			parent::__construct();
		}
		
	/*
     * added by ajay
     * on 26-05-2016
     * to add till 
     */

    public function addTill($data){	

        if(!empty($data)){
            if ($this->db->insert('till', $data)) {
                return true;
            }
        }
        return false;
    }
	
	/*
	* added by ajay
	* on 27-05-2016
	* get all tills in batch
	*/
	
	public function getAllTills(){
		$q = $this->db->get('till');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
	}
	
	/*
	* added by ajay
	* on 27-05-2016
	* update tills in batch
	*/
	
	public function updateTills($data){
		$c = 1;
		$assigned_tills = array();
		$i = 0;
		foreach($data as $val){
			$is_user_assigned_till = $this->isUserAssignedToTill($val);
		
			if(!$is_user_assigned_till){
				$this->db->where('id',$val['id']);
				$this->db->update('till',array('user_id'=>$val['user_id'],'store_id'=>$val['store_id'])); 
				if($this->db->affected_rows() > 0){
					$c += $this->db->affected_rows();
				}
			}else{
				$assigned_tills[$i]['id'] = $val['id'];
				$assigned_tills[$i]['user_id'] = $val['user_id'];
				$assigned_tills[$i]['store_id'] = $val['store_id'];
			}		
			$i++;
		}
		return array($c,$assigned_tills);
	}
	
	/*
	* added by ajay
	* on 27-05-2016
	* update Single till
	*/
	
	public function updateSingleTill($data){		
			$this->db->where('id',$data['id']);
			if(!empty($_SESSION['warehouse_id'])){
				$store_id = $_SESSION['warehouse_id'];
			}else{
				$store_id = 0;
			}
			$this->db->update('till',array('user_id'=>$data['user_id'],'store_id'=>$store_id)); 
			if($this->db->affected_rows() > 0){
				$c = $this->db->affected_rows();
			}
			return $c;
	}
	
	/*
	* added by ajay
	* on 27-05-2016
	* check if user assigned to till
	*/
	
	public function isUserAssignedToTill($data){
		$this->db->select('id');
		if(!empty($_SESSION['warehouse_id'])){
				$store_id = $_SESSION['warehouse_id'];
		}else{
				$store_id = 0;
		}
		$this->db->where(array('user_id'=>$data['user_id'],'store_id'=>$store_id));
		$query = $this->db->get('till');
		if($query->num_rows() > 0){
			return true;
		}else{
			return false;
		}
	}
        //Added by Vikas Singh 23-08-2016  
        public function deleteTill($id)
        {
            if ($this->db->delete("sma_till", array('id' => $id))) {
                return true;
            }
            else{
            return FALSE;

            }
        }
    //end
	}

?>