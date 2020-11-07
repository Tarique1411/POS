<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Customers extends MY_Controller
{

    function __construct()
    {
        parent::__construct();

        if (!$this->loggedIn) {
            $this->session->set_userdata('requested_page', $this->uri->uri_string());
            redirect('login');
        }
        if ($this->Customer || $this->Supplier) {
            $this->session->set_flashdata('warning', lang('access_denied'));
            redirect($_SERVER["HTTP_REFERER"]);
        }
        $this->lang->load('customers', $this->Settings->language);
        $this->load->library('form_validation');
        $this->load->model('companies_model');
    }

    function index($action = NULL)
    {    
        //***** Added By Anil 16-08-2016 start****        
            $arr_customers = $this->site->checkPermissions();        
            if($arr_customers[0]['customers-index'] == NULL && (! $this->Owner)){
                $this->session->set_flashdata('error', lang("access_denied"));
                redirect('welcome'); 
            }
        //***** Added By Anil 16-08-2016 End**** 
        
        $this->sma->checkPermissions();
        
        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        $this->data['action'] = $action;
        
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => '#', 'page' => lang('customers')));
        $meta = array('page_title' => lang('customers'), 'bc' => $bc);
        
        $this->page_construct('customers/index', $meta, $this->data);
    }

    function getCustomers()
    {  
        $arr_customers = $this->site->checkPermissions();
        $this->sma->checkPermissions('index');
        $ar = $this->session->all_userdata();
        $this->load->library('datatables');
        if(($ar['user_id']=='1' && $ar['username']=='owner') ||$ar['username']=='admin'  ){
            $this->datatables
            ->select("id,name, lname, email, phone, customer_group_name")    
            //->select("id, name, email, phone, city, customer_group_name, vat_no")
            ->from("companies")
            ->where(array('group_name'=> 'customer','type'=>0))
            //->add_column("Actions", "<center><a class=\"tip\" title='" . $this->lang->line("edit_customer") . "' href='" . site_url('customers/edit/$1') . "' data-toggle='modal' data-target='#myModal'><i class=\"fa fa-edit\"></i></a> <a class=\"tip\" title='" . $this->lang->line("list_users") . "' href='" . site_url('customers/users/$1') . "' data-toggle='modal' data-target='#myModal'><i class=\"fa fa-users\"></i></a> <a class=\"tip\" title='" . $this->lang->line("add_user") . "' href='" . site_url('customers/add_user/$1') . "' data-toggle='modal' data-target='#myModal'><i class=\"fa fa-plus-circle\"></i></a> <a href='#' class='tip po' title='<b>" . $this->lang->line("delete_customer") . "</b>' data-content=\"<p>" . lang('r_u_sure') . "</p><a class='btn btn-danger po-delete' href='" . site_url('customers/delete/$1') . "'>" . lang('i_m_sure') . "</a> <button class='btn po-close'>" . lang('no') . "</button>\"  rel='popover'><i class=\"fa fa-trash-o\"></i></a></center>", "id");
            ->add_column("Actions", "<center><a class=\"tip\" title='" . $this->lang->line("edit_customer") . "' href='" . site_url('customers/edit/$1') . "' data-toggle='modal' data-target='#myModal'><i class=\"fa fa-edit\"></i></a></center>", "id");      
        }
        else{
            if($arr_customers[0]['customers-edit'] != NULL){
                $this->datatables
                ->select("id,name, lname, email, phone, customer_group_name")    
                //->select("id, name, email, phone, city, customer_group_name, vat_no, award_points")
                ->from("companies")
                ->where(array('group_name'=> 'customer','type'=>0,'org_id'=>$_SESSION['org_id']))

                //->add_column("Actions", "<center><a class=\"tip\" title='" . $this->lang->line("edit_customer") . "' href='" . site_url('customers/edit/$1') . "' data-toggle='modal' data-target='#myModal'><i class=\"fa fa-edit\"></i></a> <a class=\"tip\" title='" . $this->lang->line("list_users") . "' href='" . site_url('customers/users/$1') . "' data-toggle='modal' data-target='#myModal'><i class=\"fa fa-users\"></i></a> <a class=\"tip\" title='" . $this->lang->line("add_user") . "' href='" . site_url('customers/add_user/$1') . "' data-toggle='modal' data-target='#myModal'><i class=\"fa fa-plus-circle\"></i></a> <a href='#' class='tip po' title='<b>" . $this->lang->line("delete_customer") . "</b>' data-content=\"<p>" . lang('r_u_sure') . "</p><a class='btn btn-danger po-delete' href='" . site_url('customers/delete/$1') . "'>" . lang('i_m_sure') . "</a> <button class='btn po-close'>" . lang('no') . "</button>\"  rel='popover'><i class=\"fa fa-trash-o\"></i></a></center>", "id");
                //->add_column("Actions", "<center><a class=\"tip\" title='" . $this->lang->line("edit_customer") . "' href='" . site_url('customers/edit/$1') . "' data-toggle='modal' data-target='#myModal'><i class=\"fa fa-edit\"></i></a> <a href='#' class='tip po' title='<b>" . $this->lang->line("delete_customer") . "</b>' data-content=\"<p>" . lang('r_u_sure') . "</p><a class='btn btn-danger po-delete' href='" . site_url('customers/delete/$1') . "'>" . lang('i_m_sure') . "</a> <button class='btn po-close'>" . lang('no') . "</button>\"  rel='popover'><i class=\"fa fa-trash-o\"></i></a></center>", "id");
              ->add_column("Actions", "<center><a class=\"tip\" title='" . $this->lang->line("edit_customer") . "' href='" . site_url('customers/edit/$1') . "' data-toggle='modal' data-target='#myModal'><i class=\"fa fa-edit\"></i></a></center>", "id");
            }else{
                 $this->datatables
                ->select("id,name, lname, email, phone, customer_group_name")    
                //->select("id, name, email, phone, city, customer_group_name, vat_no, award_points")
                ->from("companies")
                ->where(array('group_name'=> 'customer','type'=>0,'org_id'=>$_SESSION['org_id']))

                //->add_column("Actions", "<center><a class=\"tip\" title='" . $this->lang->line("edit_customer") . "' href='" . site_url('customers/edit/$1') . "' data-toggle='modal' data-target='#myModal'><i class=\"fa fa-edit\"></i></a> <a class=\"tip\" title='" . $this->lang->line("list_users") . "' href='" . site_url('customers/users/$1') . "' data-toggle='modal' data-target='#myModal'><i class=\"fa fa-users\"></i></a> <a class=\"tip\" title='" . $this->lang->line("add_user") . "' href='" . site_url('customers/add_user/$1') . "' data-toggle='modal' data-target='#myModal'><i class=\"fa fa-plus-circle\"></i></a> <a href='#' class='tip po' title='<b>" . $this->lang->line("delete_customer") . "</b>' data-content=\"<p>" . lang('r_u_sure') . "</p><a class='btn btn-danger po-delete' href='" . site_url('customers/delete/$1') . "'>" . lang('i_m_sure') . "</a> <button class='btn po-close'>" . lang('no') . "</button>\"  rel='popover'><i class=\"fa fa-trash-o\"></i></a></center>", "id");
                //->add_column("Actions", "<center><a class=\"tip\" title='" . $this->lang->line("edit_customer") . "' href='" . site_url('customers/edit/$1') . "' data-toggle='modal' data-target='#myModal'><i class=\"fa fa-edit\"></i></a> <a href='#' class='tip po' title='<b>" . $this->lang->line("delete_customer") . "</b>' data-content=\"<p>" . lang('r_u_sure') . "</p><a class='btn btn-danger po-delete' href='" . site_url('customers/delete/$1') . "'>" . lang('i_m_sure') . "</a> <button class='btn po-close'>" . lang('no') . "</button>\"  rel='popover'><i class=\"fa fa-trash-o\"></i></a></center>", "id");
              ->add_column("Actions", "<center></center>", "id");
            }
            
        }
          //->unset_column('id');
        echo $this->datatables->generate();
    }

    function add()
    {     
        //***** Added By Anil 16-08-2016 start****        
            $arr_add = $this->site->checkPermissions();  
            if($arr_add[0]['customers-add'] == NULL && (! $this->Owner)){
                $this->session->set_flashdata('error', lang("access_denied"));
                redirect('welcome'); 
            }
            //echo "<pre>";print_r($_SESSION);die;
        // **** Added By Anil 12-09-2016 End ****

            $arrCountries = $this->companies_model->getCountryList();
            foreach ($arrCountries as $countries){           
                $arrcountries[$countries->country_id] = $countries->country_name;        
            }
            
            $this->data['country'] = $arrcountries;
            $arrStates = $this->companies_model->getStateList_Default();
            foreach ($arrStates as $key => $value){
                $arrStates[$value->state_id] = $value->state_name;
            }
            
            $this->data['state_default'] = $arrStates;              
        // **** Added By Anil 12-09-2016 End****
     
        //$this->form_validation->set_rules('email', $this->lang->line("email_address"), 'is_unique[companies.email]');
        $this->form_validation->set_rules('phone', $this->lang->line("phone"), 'required');
        if ($this->form_validation->run() == true) {
            $cg = $this->site->getCustomerGroupByID($this->input->post('customer_group'));
            $data = array('name' => $this->input->post('name'),
                'lname' => $this->input->post('lname'),
                'email' => $this->input->post('email'),
                'group_id' => '3',
                'group_name' => 'customer',
                //'customer_group_id' => $this->input->post('customer_group'),
                'customer_group_name' => $cg->name,
                'address' => $this->input->post('address'),
                'vat_no' => $this->input->post('vat_no'),
                'city' => $this->input->post('city'),
                'state_id' => $this->input->post('state'),
                'postal_code' => $this->input->post('postal_code'),
                'country_id' => $this->input->post('country'),
                'phone' => $this->input->post('phone'),
                'salutation' => $this->input->post('salutation'),
                'gender' => $this->input->post('gender'),
                'type' => 0,
                'org_id' => $_SESSION['org_id'],
                'biller_id' => $_SESSION['biller_id'],
                //'store_id' => $_SESSION['biller_id'],
                'cf4' => $this->input->post('cf4'),
                'cf5' => $this->input->post('cf5'),
                'cf6' => $this->input->post('cf6'),
            );
     
        } elseif ($this->input->post('add_customer')) {
            $this->session->set_flashdata('error', validation_errors());
			if ($this->Owner || $this->Manager) {
				redirect('customers');
			}else{
				redirect('pos');
			}
        }
//        if($this->companies_model->getCompanyByPhone($this->input->post('phone'))=='1'){
//            $this->session->set_flashdata('error', 'The Mobile field must contain a unique value.');
//			if ($this->Owner || $this->Manager) {
//				redirect('customers');
//			}else{
//				redirect('pos');
//			}
//        }
//        else {         
            /*Added By Chitra to avoid 500 Internal server error */
            if ($this->form_validation->run() == true) {
                $cid = $this->companies_model->addCompany($data);
                $this->session->set_flashdata('message', $this->lang->line("customer_added"));
                $ref = isset($_SERVER["HTTP_REFERER"]) ? explode('?', $_SERVER["HTTP_REFERER"]) : NULL;
                if(strpos($ref[0], 'pos') !== false ) {
                    redirect(base_url('pos') . '?customer=' . $cid);
                }else{
                    redirect($ref[0] . '?customer=' . $cid);
                }   
                
            } else {     
                $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
                $this->data['modal_js'] = $this->site->modal_js();
                $this->data['customer_groups'] = $this->companies_model->getAllCustomerGroups();
                $this->load->view($this->theme . 'customers/add', $this->data);
            }
     // }
    }
    
    /* Added By Anil 12-09-2016 Start */
    function ajax_call_country() {       
        if (isset($_POST) && isset($_POST['country_id'])) {
            $country_id = $_POST['country_id'];
	    $arrStates = $this->companies_model->getStateList($country_id);
            foreach ($arrStates as $states) {
                $arrstates[$states->state_id] = $states->state_name;
            }
            echo json_encode('<div class="form-group" id="statelist">'.lang("state", "state"). form_dropdown('state',array_filter($arrstates),'','class="form-control tip select"  style="width:100%;" required="required"').'</div>');
            exit;
        }
    }  
    /* Added By Anil 12-09-2016 End */

    function edit($id = NULL)
    { 
        //***** Added By Anil 21-09-2016 start****        
        $arr_cust_edit = $this->site->checkPermissions();  
        if((($arr_cust_edit[0]['customers-edit'] === NULL) || ($arr_cust_edit[0]['customers-edit'] === 0)) && (! $this->Owner)){
            $this->session->set_flashdata('error', lang("access_denied"));
            redirect('welcome'); 
        }
        //***** Added By Anil 21-09-2016 End**** 
        
        //$this->sma->checkPermissions(false, true);
        
        //***** Added By Anil 12-09-2016 start****
        $arrCountries = $this->companies_model->getCountryList();
        foreach ($arrCountries as $countries){
            $arrcountries[$countries->country_id] = $countries->country_name;
        }
        $this->data['country'] = $arrcountries;
         
        if ($this->input->get('id')) {
            $id = $this->input->get('id');
        }
        //echo $id; die;

        $company_details = $this->companies_model->getCompanyByID($id);
        $arrstates_1 =array();
        $arrStates = $this->companies_model->getStateList($company_details->country_id);
            foreach ($arrStates as $key=>$states) {
                $arrstates_1[$states->state_id] = $states->state_name;
            }
            $this->data['arrStates'] = $arrstates_1;
            //***** Added By Anil 12-09-2016 End****  
        
        if (($this->input->post('email') != $company_details->email) && ($this->input->post())) { 
            $emailcount = $this->companies_model->getEmailCount($this->input->post('email'));
            if($emailcount > 0){
		 $this->session->set_flashdata('message', $this->lang->line("customer_already_exist"));
            	redirect($_SERVER["HTTP_REFERER"]);
	    }
        }
	
        if ( $this->input->post('name')) {
            $cg = $this->site->getCustomerGroupByID($this->input->post('customer_group'));
            $data = array('name' => $this->input->post('name'),
                'lname' => $this->input->post('lname'),
                'email' => $this->input->post('email'),
                'state_id' => $this->input->post('state'),
                'country_id' => $this->input->post('country'),
                'group_id' => '3',
                'group_name' => 'customer',
                //'customer_group_id' => $this->input->post('customer_group'),
                'customer_group_name' => $cg->name,
		'gender' => $this->input->post('gender'),
                'salutation' => $this->input->post('salutation'),
                'upd_flg' => true,
                'phone' => $this->input->post('phone')
            );
        }
        elseif ($this->input->post('edit_customer'))
        {
            $this->session->set_flashdata('error', validation_errors());
            redirect($_SERVER["HTTP_REFERER"]);
        }
//        if($this->companies_model->getCompanyByPhoneForEdit($this->input->post('phone'),$id)=='1'){
//            $this->session->set_flashdata('error', 'The Mobile field must contain a unique value.');
//            redirect('customers');
//        }
//        else {
            //echo "here <pre>";print_r($data);//exit;
            if ($this->input->post('name') && $this->companies_model->updateCompany($id, $data))
            {
                $this->session->set_flashdata('message', $this->lang->line("customer_updated"));
                redirect($_SERVER["HTTP_REFERER"]);
            }
            else
            {
                $this->data['customer'] = $company_details;
                $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
                $this->data['modal_js'] = $this->site->modal_js();
                $this->data['customer_groups'] = $this->companies_model->getAllCustomerGroups();
                $this->load->view($this->theme . 'customers/edit', $this->data);
            }
//        }
    }
    

    function users($company_id = NULL)
    {
        $this->sma->checkPermissions(false, true);

        if ($this->input->get('id')) {
            $company_id = $this->input->get('id');
        }

        $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
        $this->data['modal_js'] = $this->site->modal_js();
        $this->data['company'] = $this->companies_model->getCompanyByID($company_id);
        $this->data['users'] = $this->companies_model->getCompanyUsers($company_id);
        $this->load->view($this->theme . 'customers/users', $this->data);

    }

    function add_user($company_id = NULL)
    {
        $this->sma->checkPermissions(false, true);

        if ($this->input->get('id')) {
            $company_id = $this->input->get('id');
        }
        $company = $this->companies_model->getCompanyByID($company_id);

        $this->form_validation->set_rules('email', $this->lang->line("email_address"), 'is_unique[users.email]');
        $this->form_validation->set_rules('password', $this->lang->line('password'), 'required|min_length[8]|max_length[20]|matches[password_confirm]');
        $this->form_validation->set_rules('password_confirm', $this->lang->line('confirm_password'), 'required');

        if ($this->form_validation->run('companies/add_user') == true) {
            $active = $this->input->post('status');
            $notify = $this->input->post('notify');
            list($username, $domain) = explode("@", $this->input->post('email'));
            $email = strtolower($this->input->post('email'));
            $password = $this->input->post('password');
            $additional_data = array(
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'phone' => $this->input->post('phone'),
                'gender' => $this->input->post('gender'),
                'company_id' => $company->id,
                'company' => $company->company,
                'group_id' => 3
            );
            $this->load->library('ion_auth');
        } elseif ($this->input->post('add_user')) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('customers');
        }

        if ($this->form_validation->run() == true && $this->ion_auth->register($username, $password, $email, $additional_data, $active, $notify)) {
            $this->session->set_flashdata('message', $this->lang->line("user_added"));
            redirect("customers");
        } else {
            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $this->data['modal_js'] = $this->site->modal_js();
            $this->data['company'] = $company;
            $this->load->view($this->theme . 'customers/add_user', $this->data);
        }
    }

    function import_csv()
    {
        $this->sma->checkPermissions();
        $this->load->helper('security');
        $this->form_validation->set_rules('csv_file', $this->lang->line("upload_file"), 'xss_clean');

        if ($this->form_validation->run() == true) {

            if (DEMO) {
                $this->session->set_flashdata('warning', $this->lang->line("disabled_in_demo"));
                redirect($_SERVER["HTTP_REFERER"]);
            }

            if (isset($_FILES["csv_file"])) /* if($_FILES['userfile']['size'] > 0) */ {

                $this->load->library('upload');

                $config['upload_path'] = 'assets/uploads/csv/';
                $config['allowed_types'] = 'csv';
                $config['max_size'] = '2000';
                $config['overwrite'] = TRUE;

                $this->upload->initialize($config);

                if (!$this->upload->do_upload('csv_file')) {

                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('error', $error);
                    redirect("customers");
                }

                $csv = $this->upload->file_name;

                $arrResult = array();
                $handle = fopen("assets/uploads/csv/" . $csv, "r");
                if ($handle) {
                    while (($row = fgetcsv($handle, 5001, ",")) !== FALSE) {
                        $arrResult[] = $row;
                    }
                    fclose($handle);
                }
                $titles = array_shift($arrResult);

                $keys = array('company', 'name', 'email', 'phone', 'address', 'city', 'state', 'postal_code', 'country', 'vat_no', 'cf1', 'cf2', 'cf3', 'cf4', 'cf5', 'cf6');

                $final = array();
                foreach ($arrResult as $key => $value) {
                    $final[] = array_combine($keys, $value);
                }
                $rw = 2;
                foreach ($final as $csv) {
                    if ($this->companies_model->getCompanyByEmail($csv['email'])) {
                        $this->session->set_flashdata('error', $this->lang->line("check_customer_email") . " (" . $csv['email'] . "). " . $this->lang->line("customer_already_exist") . " (" . $this->lang->line("line_no") . " " . $rw . ")");
                        redirect("customers");
                    }
                    $rw++;
                }
                foreach ($final as $record) {
                    $record['group_id'] = 3;
                    $record['group_name'] = 'customer';
                    $record['customer_group_id'] = 1;
                    $record['customer_group_name'] = 'General';
                    $data[] = $record;
                }
                //$this->sma->print_arrays($data);
            }

        } elseif ($this->input->post('import')) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('customers');
        }

        if ($this->form_validation->run() == true && !empty($data)) {
            if ($this->companies_model->addCompanies($data)) {
                $this->session->set_flashdata('message', $this->lang->line("customers_added"));
                redirect('customers');
            }
        } else {

            $this->data['error'] = (validation_errors() ? validation_errors() : $this->session->flashdata('error'));
            $this->data['modal_js'] = $this->site->modal_js();
            $this->load->view($this->theme . 'customers/import', $this->data);
        }
    }

    function delete($id = NULL)
    {
        $this->sma->checkPermissions(NULL, TRUE);

        if ($this->input->get('id')) {
            $id = $this->input->get('id');
        }

        if ($this->input->get('id') == 1) {
            $this->session->set_flashdata('error', lang('customer_x_deleted'));
            die("<script type='text/javascript'>setTimeout(function(){ window.top.location.href = '" . (isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : site_url('welcome')) . "'; }, 0);</script>");
        }

        if ($this->companies_model->deleteCustomer($id)) {
            echo $this->lang->line("customer_deleted");
        } else {
            $this->session->set_flashdata('warning', lang('customer_x_deleted_have_sales'));
            die("<script type='text/javascript'>setTimeout(function(){ window.top.location.href = '" . (isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : site_url('welcome')) . "'; }, 0);</script>");
        }
    }

    function suggestions($term = NULL, $limit = NULL)
    {
        // $this->sma->checkPermissions('index');
        if ($this->input->get('term')) {
            $term = $this->input->get('term', TRUE);
        }
        if (strlen($term) < 1) {
            return FALSE;
        }
        $limit = $this->input->get('limit', TRUE);
        $rows['results'] = $this->companies_model->getCustomerSuggestions($term, $limit);
        echo json_encode($rows);
    }

    function getCustomer($id = NULL)
    {
        // $this->sma->checkPermissions('index');
		$this->load->model('pos_model');
		$this->pos_settings = $this->pos_model->getSetting();
		if(empty($id) || ($id == NULL)){
			$id = $this->pos_settings->default_customer;
		}
         $row = $this->companies_model->getCompanyByID($id);
        //echo json_encode(array(array('id' => $row->id, 'text' => (!empty($row->company) ? $row->company : $row->name))));

	echo json_encode(array(array('id' => $row->id, 'text' => ((!empty($row->name) || !empty($row->lname) || (!empty($row->phone))) ? $row->name.' '.$row->lname.' ('.$row->phone.')' : ''))));
    }

    function get_award_points($id = NULL)
    {
        $this->sma->checkPermissions('index');
        $row = $this->companies_model->getCompanyByID($id);
        echo json_encode(array('ca_points' => $row->award_points));
    }

    function customer_actions()
    {
        if (!$this->Owner && !$this->Admin && !$this->Manager && !$this->Sales) {
            $this->session->set_flashdata('warning', lang('access_denied'));
            redirect($_SERVER["HTTP_REFERER"]);
        }

        $this->form_validation->set_rules('form_action', lang("form_action"), 'required');

        if ($this->form_validation->run() == true) {

            if (!empty($_POST['val'])) {
                if ($this->input->post('form_action') == 'delete') {
                    $error = false;
                    foreach ($_POST['val'] as $id) {
                        if (!$this->companies_model->deleteCustomer($id)) {
                            $error = true;
                        }
                    }
                    if ($error) {
                        $this->session->set_flashdata('warning', lang('customers_x_deleted_have_sales'));
                    } else {
                        $this->session->set_flashdata('message', $this->lang->line("customers_deleted"));
                    }
                    redirect($_SERVER["HTTP_REFERER"]);
                }

                if ($this->input->post('form_action') == 'export_excel' || $this->input->post('form_action') == 'export_pdf') {

                    $this->load->library('excel');
                    $this->excel->setActiveSheetIndex(0);
                    $this->excel->getActiveSheet()->setTitle(lang('customer'));
                    $this->excel->getActiveSheet()->SetCellValue('A1', lang('company'));
                    $this->excel->getActiveSheet()->SetCellValue('B1', lang('name'));
                    $this->excel->getActiveSheet()->SetCellValue('C1', lang('email'));
                    $this->excel->getActiveSheet()->SetCellValue('D1', lang('phone'));
                    $this->excel->getActiveSheet()->SetCellValue('E1', lang('address'));
                    $this->excel->getActiveSheet()->SetCellValue('F1', lang('city'));
                    $this->excel->getActiveSheet()->SetCellValue('G1', lang('state'));
                    $this->excel->getActiveSheet()->SetCellValue('H1', lang('postal_code'));
                    $this->excel->getActiveSheet()->SetCellValue('I1', lang('country'));
                    $this->excel->getActiveSheet()->SetCellValue('J1', lang('vat_no'));
                    $this->excel->getActiveSheet()->SetCellValue('K1', lang('ccf1'));
                    $this->excel->getActiveSheet()->SetCellValue('L1', lang('ccf2'));
                    $this->excel->getActiveSheet()->SetCellValue('M1', lang('ccf3'));
                    $this->excel->getActiveSheet()->SetCellValue('N1', lang('ccf4'));
                    $this->excel->getActiveSheet()->SetCellValue('O1', lang('ccf5'));
                    $this->excel->getActiveSheet()->SetCellValue('P1', lang('ccf6'));

                    $row = 2;
                    foreach ($_POST['val'] as $id) {
                        $customer = $this->site->getCompanyByID($id);
                        $this->excel->getActiveSheet()->SetCellValue('A' . $row, $customer->company);
                        $this->excel->getActiveSheet()->SetCellValue('B' . $row, $customer->name);
                        $this->excel->getActiveSheet()->SetCellValue('C' . $row, $customer->email);
                        $this->excel->getActiveSheet()->SetCellValue('D' . $row, $customer->phone);
                        $this->excel->getActiveSheet()->SetCellValue('E' . $row, $customer->address);
                        $this->excel->getActiveSheet()->SetCellValue('F' . $row, $customer->city);
                        $this->excel->getActiveSheet()->SetCellValue('G' . $row, $customer->state);
                        $this->excel->getActiveSheet()->SetCellValue('H' . $row, $customer->postal_code);
                        $this->excel->getActiveSheet()->SetCellValue('I' . $row, $customer->country);
                        $this->excel->getActiveSheet()->SetCellValue('J' . $row, $customer->vat_no);
                        $this->excel->getActiveSheet()->SetCellValue('K' . $row, $customer->cf1);
                        $this->excel->getActiveSheet()->SetCellValue('L' . $row, $customer->cf2);
                        $this->excel->getActiveSheet()->SetCellValue('M' . $row, $customer->cf3);
                        $this->excel->getActiveSheet()->SetCellValue('N' . $row, $customer->cf4);
                        $this->excel->getActiveSheet()->SetCellValue('O' . $row, $customer->cf5);
                        $this->excel->getActiveSheet()->SetCellValue('P' . $row, $customer->cf6);
                        $row++;
                    }

                    $this->excel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
                    $this->excel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
                    $this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
                    $this->excel->getDefaultStyle()->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    $filename = 'customers_' . date('Y_m_d_H_i_s');
                    if ($this->input->post('form_action') == 'export_pdf') {
                        $styleArray = array('borders' => array('allborders' => array('style' => PHPExcel_Style_Border::BORDER_THIN)));
                        $this->excel->getDefaultStyle()->applyFromArray($styleArray);
                        $this->excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
                        require_once(APPPATH . "third_party" . DIRECTORY_SEPARATOR . "MPDF" . DIRECTORY_SEPARATOR . "mpdf.php");
                        $rendererName = PHPExcel_Settings::PDF_RENDERER_MPDF;
                        $rendererLibrary = 'MPDF';
                        $rendererLibraryPath = APPPATH . 'third_party' . DIRECTORY_SEPARATOR . $rendererLibrary;
                        if (!PHPExcel_Settings::setPdfRenderer($rendererName, $rendererLibraryPath)) {
                            die('Please set the $rendererName: ' . $rendererName . ' and $rendererLibraryPath: ' . $rendererLibraryPath . ' values' .
                                PHP_EOL . ' as appropriate for your directory structure');
                        }

                        header('Content-Type: application/pdf');
                        header('Content-Disposition: attachment;filename="' . $filename . '.pdf"');
                        header('Cache-Control: max-age=0');

                        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'PDF');
                        return $objWriter->save('php://output');
                    }
                    if ($this->input->post('form_action') == 'export_excel') {
                        header('Content-Type: application/vnd.ms-excel');
                        header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
                        header('Cache-Control: max-age=0');

                        $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
                        return $objWriter->save('php://output');
                    }

                    redirect($_SERVER["HTTP_REFERER"]);
                }
            } else {
                $this->session->set_flashdata('error', $this->lang->line("no_customer_selected"));
                redirect($_SERVER["HTTP_REFERER"]);
            }
        } else {
            $this->session->set_flashdata('error', validation_errors());
            redirect($_SERVER["HTTP_REFERER"]);
        }
    }
    
    /*
     * Added by Ajay
     * Get mobile number avaibility on companies table
     * on 30-11-2016
     */
    
    public function getMobileAvaibility(){
        $phone = $this->input->post('phone');
        $name = $this->input->post('name');
        $available = $this->companies_model->getCompanyByPhoneForUniqueness($phone,$name);
        echo json_encode($available);
    }
    
     /*
     * Added by Ajay
     * Get email avaibility on companies table
     * on 1-12-2016
     */
    
    public function getEmailAvaibility(){
        $email = $this->input->post('email');
        if(($email != NULL) || ($email != '')){
            $available = $this->companies_model->getCompanyByEmailForUniqueness($email);
            echo $available;
        }
    }
    
    /*
     * Added by Ajay
     * Get email avaibility at the time of edit customer
     * on 28-12-2016
     */
    
    public function getEmailAvaibilityForEdit(){

        if ( $this->companies_model->check_all_emails($this->input->post('email'),$this->input->post('cust_id')) == TRUE ) {
                echo json_encode(FALSE);
        } else {
                echo json_encode(TRUE);
        }
    }
    
    /*
     * Added by Ajay
     * Get email avaibility at the time of edit customer
     * on 28-12-2016
     */
    
    public function getMobileAvaibilityForEdit(){
        $phone = $this->input->post('phone');
        $name = $this->input->post('name');
        $cust_id = $this->input->post('cust_id');
        if((($phone != NULL) || ($phone != '')) && (($name != NULL) || ($name != '')) && (($cust_id != NULL) || ($cust_id != ''))){
            $available = $this->companies_model->check_all_phones($phone, $name,$cust_id);
            echo $available;
        }

    }

}
