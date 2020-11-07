<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Till extends MY_Controller
{

    function __construct()
    {
        parent::__construct();
        if (!$this->loggedIn) {
            $this->session->set_userdata('requested_page', $this->uri->uri_string());
            redirect('login');
        }
		
        $this->lang->load('purchases', $this->Settings->language);
        $this->load->library('form_validation');
        $this->load->model('till_model');
    }
	
		/*
     * Added by ajay on 25-05-2015
     * code for add till
     */

    public function addTill() {
        //$this->sma->checkPermissions();
        $this->form_validation->set_rules('till_name','Till Name','trim|required');
        $this->form_validation->set_rules('till_ip','Till IP','trim|required|is_unique[till.till_ip]');   
        if($this->form_validation->run() == TRUE){
            $status = $this->till_model->addTill($this->input->post());
            if($status == TRUE){
                redirect('till/manageTill');
            }
           
        }else{    
            $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
            $this->data['action'] = $action;
            $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => '#', 'page' => lang('till')));
            $meta = array('page_title' => lang('till'), 'bc' => $bc);
            $this->page_construct('till/add', $meta, $this->data);
        }
    }
	
	/*
     * Added by ajay on 27-05-2015
     * code for manage till
     */

    
    public function manageTill(){
		$this->load->model('site');
		//$this->sma->checkPermissions();
        // *** Added By Anil Checks for Groups Start ***  
                
         $this->data['executives'] = $this->site->getSalesExecutivesByBiller($this->session->userdata('biller_id'),5);    
        
         // *** Added By Anil Checks for Groups End ***  
        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        $this->data['action'] = $action;
		$this->data['tills'] = $this->till_model->getAllTills();
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => '#', 'page' => lang('manage_till')));
        $meta = array('page_title' => lang('manage_till'), 'bc' => $bc);
        $this->page_construct('till/manage_till', $meta, $this->data);
    }
    
    //Added by Vikas Singh 23-08-2016 
    public function deleteTill()
    {
      $id =  $this->input->post('id');
      $delete = $this->till_model->deleteTill($id);
      $status = "false";
        if ($this->db->affected_rows() > 0) {
            $status = "true";
        }

        echo $status;

    }
//end
	
	public function getTills(){
            $this->sma->checkPermissions();
			
	}
	
	/*
     * Added by ajay on 27-05-2015
     * code for assign user to till through ajax
     */

	public function assignTillExecutive(){
		$data = $this->input->post();
		$is_user_assigned_till = $this->till_model->isUserAssignedToTill($data);
	
		if(!$is_user_assigned_till) {
			$status = $this->till_model->updateSingleTill($data);
			if($status > 0){
				echo json_encode(array('msg'=>'success','user_id'=>$data['user_id'],'id'=>$data['id']));
			}else{
				echo json_encode(array('msg'=>'failed','user_id'=>$data['user_id'],'id'=>$data['id']));
			}
		} else {
				echo json_encode(array('msg'=>'till_assigned_to_user','user_id'=>$data['user_id'],'id'=>$data['id']));
		}
	
	
	}

    public function callback_alpha_dash_space($str)
    {
        return (! preg_match("/^([-a-z_ ])+$/i", $str)) ? FALSE : TRUE;
    } 
    
    public function callback_valid_ip($str)
    {
        return ($this->input->valid_ip($ip)) ? TRUE : FALSE;
    } 
	
	/*
     * Added by ajay on 27-05-2015
     * code for assigning users to till in bulk
     */

	public function till_actions(){
		//$this->sma->checkPermissions();
		if($this->input->post()){
			$data = $this->input->post();
			$tills = array();
			$salespersons = array();
			foreach($data['till_id'] as $val){
				$tills[] = $val;
			}
			foreach($data['user_id'] as $val){
				$salespersons[] = $val;
			}		
			$edata = array_combine($tills,$salespersons);
			$updateData = array();
			$i = 0;
			foreach($edata as $key=>$val){
				$updateData[$i]['id'] = $key;
				$updateData[$i]['user_id'] = $val;
				$updateData[$i]['store_id'] = $this->session->all_userdata()['warehouse_id'];
				$i++;
			}	
			$updated_rows = $this->till_model->updateTills($updateData);
			
			if($updated_rows[0] > 0){
				$this->session->set_flashdata('update_success', 'Update batch successfull');
				redirect('purchases/manageTill');
			}else{
				$this->session->set_flashdata('update_error', 'Update batch not successfull');
			}	
		}
	}
}

?>