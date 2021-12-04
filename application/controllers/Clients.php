
<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Clients extends CI_Controller {
	function __Construct(){
		parent::__Construct();
		$this->output->set_header('Last-Modified:' . gmdate('D, d M Y H:i:s') . 'GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
        $this->output->set_header('Cache-Control: post-check=0, pre-check=0', false);
        $this->output->set_header('Pragma: no-cache');
		if($this->session->userdata('username') == '')
			redirect('logout');

		$this->data['info'] = info(true);

		$this->data['header_content'] = (object)[
			'title' => 'Client',
			'sub_title' => 'Masters',
			'path' => uri_string(),
		];

		$this->data['sidebar'] = (object)[
			'menu' => $this->uri->segment(1),
			'submenu' => $this->uri->segment(2)
		];

		$this->load->model(['client_m','organigation_m']);
		$this->data['script'] = "clients";
		$this->load->library('excel');
	}

	function index(){
		$this->data['randerPage'] = "clients/client";
		$this->data['rows'] = $this->client_m->getclients();
		$this->load->view('_layout', $this->data);
	}

	function edit($id){
		$this->data['randerPage'] = "clients/edit";
		$this->data['data'] = $this->client_m->getclient($id);
		$this->data['badd'] = $this->client_m->getclient_billing_address($id);
		$this->load->view('_layout', $this->data);
	}

	//Parent
	function parent(){
		$this->data['randerPage'] = "clients/parent";
		if($_POST){
			echo $this->client_m->parent();
			$_POST = [];
		}
		$this->data['rows'] = $this->client_m->parent(true);
		$this->load->view('_layout', $this->data);
	}

	//Parent
	function category(){
		$this->data['randerPage'] = "clients/clientcategory";
		if($_POST){
			echo $this->client_m->category();
			$_POST = [];
		}
		$this->data['rows'] = $this->client_m->category(true);
		$this->load->view('_layout', $this->data);
	}

	function add_subdoctor(){
		$data = [
			"client_id" =>$this->input->post('client_id'),
			"name" =>$this->input->post('name'),
			"mobile" =>$this->input->post('mobile'),
			"design_preferences" =>$this->input->post('dp'),
		];
		if($this->db->insert('subdoctors', $data))
			echo true;
	}

	function add(){
		$this->data['randerPage'] = "clients/add";
		$this->load->view('_layout', $this->data);
	}

	//Client Blocking
	function block_client($id, $_is = 0){
		$arr = [
			'client_id' => $id,
			'from_datetime' => date('Y-m-d H:i:s')
		];

		if($_is == 0){
			$res = $this->db->where(['client_id' => $id, 'to_datetime' => null])->get('client_block');

			if($res->num_rows() > 0){
				$this->db->set('to_datetime', date('Y-m-d H:i:s'))->where('client_id', $id)->update('client_block');			
				$this->db->set('status', $_is)->where('id', $id)->update('clients');
				echo 1;
			}else{
				$this->db->set('status', $_is)->where('id', $id)->update('clients');
				echo $this->db->insert('client_block', $arr);
			}
		}else{
			$this->db->set('status', $_is)->where('id', $id)->update('clients');
			echo $this->db->insert('client_block', $arr);
		}
	}

	function doctor_capping(){
		$this->data['rows'] = $this->client_m->get_capping_clients();
		$this->data['randerPage'] = "clients/doc_capping";
		$this->load->view('_layout', $this->data);		
	}

	function blocked_list(){
		$this->data['randerPage'] = "clients/blockedclient";
		$this->data['rows'] = $this->client_m->getclients(true);
		$this->load->view('_layout', $this->data);
	}

	//priceband_report
	function priceband_report($id){
		$this->data['id'] = $id;
		$this->data['rows'] = $this->client_m->clientproducts($id);
		// $this->load->view('clients/clientproductview_pdf', $this->data);

		$html = $this->load->view('clients/clientproductview_pdf', $this->data, true);
        $pdfFilePath = get_clientname($id)."-pricelist-".time().".pdf";

		$this->load->library('m_pdf');
		$this->m_pdf->pdf($html, $pdfFilePath);
	}

	function addclients(){
		$data['client'] =[
			'image' => $this->do_upload(),
		    'clientname' => $this->input->post('clientname', true),
		    'code' => $this->input->post('code', true),
		    'legencycode' => $this->input->post('legencycode', true),
		    'parent' => $this->input->post('parentname', true),
		    'source' => $this->input->post('source', true),
		    'referby' => $this->input->post('referby', true),
		    'customercateory' => $this->input->post('customercateory', true),
		    'language' => $this->input->post('language', true),
		    'qualification' => $this->input->post('qualification', true),
		    'currency' => $this->input->post('currency', true),
		    'mobile' => $this->input->post('mobile', true),
		    'whatsappno' => $this->input->post('whatsappno', true),
		    'landlineno' => $this->input->post('landlineno', true),
		    'assistantno' => $this->input->post('assistantno', true),
		    'email' => $this->input->post('email', true),
		    'dob' => date('Y-m-d', strtotime($this->input->post('dob', true))),
		    'anniversarydate' => date('Y-m-d', strtotime($this->input->post('anniversarydate', true))),
		    'practicingyear' => $this->input->post('practicingyear', true),
		    'creditdays' => $this->input->post('creditdays', true),
		    'address' => $this->input->post('address', true),
		    'country' => $this->input->post('country', true),
		    'state' => $this->input->post('state', true),
		    'city' => $this->input->post('city', true),
		    'area' => $this->input->post('area', true),
		    'pincode' => $this->input->post('pincode', true),
		    'landmark' => $this->input->post('landmark', true),
		    'station' => $this->input->post('station', true),
		    'remark1' => $this->input->post('remark1', true),
		    'added_at' => date('Y-m-d')
		];

		$data['billing'] = [
		    'company' => $this->input->post('bcompany', true),
		    'email' => $this->input->post('bemail', true),
		    'contactno' => $this->input->post('bcontactno', true),
		    'gstno' => $this->input->post('bgstno', true),
		    'panno' => $this->input->post('bpanno', true),
		    'cinno' => $this->input->post('bcinno', true),
		    'address' => $this->input->post('baddress', true),
		];

		$data['subdoc'] = [
			'name' =>  $this->input->post('clientname', true),
			'mobile' => $this->input->post('mobile', true),
			'design_preferences' => $this->input->post('qualification', true),
			'is_primary' => 1,
			'added_by' => null,
			'added_at' => date('Y-m-d H:i:s')
		];

		if($this->client_m->addclient($data)){
			redirect(base_url('clients'));
		}
	}

	//Update Client
	function update(){
		$data['client'] =[
			'image' => $this->do_upload(),
		    'clientname' => $this->input->post('clientname', true),
		    'code' => $this->input->post('code', true),
		    'legencycode' => $this->input->post('legencycode', true),
		    'parent' => $this->input->post('parentname', true),
		    'source' => $this->input->post('source', true),
		    'referby' => $this->input->post('referby', true),
		    'customercateory' => $this->input->post('customercateory', true),
		    'language' => $this->input->post('language', true),
		    'qualification' => $this->input->post('qualification', true),
		    'currency' => $this->input->post('currency', true),
		    'mobile' => $this->input->post('mobile', true),
		    'whatsappno' => $this->input->post('whatsappno', true),
		    'landlineno' => $this->input->post('landlineno', true),
		    'assistantno' => $this->input->post('assistantno', true),
		    'email' => $this->input->post('email', true),
			'dob' => date('Y-m-d', strtotime($this->input->post('dob', true))),
		    'anniversarydate' => date('Y-m-d', strtotime($this->input->post('anniversarydate', true))),
		    'practicingyear' => $this->input->post('practicingyear', true),
		    'creditdays' => $this->input->post('creditdays', true),
		    'country' => $this->input->post('country', true),
		    'state' => $this->input->post('state', true),
		    'city' => $this->input->post('city', true),
		    'area' => $this->input->post('area', true),
		    'landmark' => $this->input->post('landmark', true),
		    'pincode' => $this->input->post('pincode', true),
		    'station' => $this->input->post('station', true),
		    'address' => $this->input->post('address', true),
		    'remark1' => $this->input->post('remark1', true),
		    'added_at' => date('Y-m-d')
		];

		$data['billing'] = [
		    'company' => $this->input->post('bcompany', true),
		    'email' => $this->input->post('bemail', true),
		    'contactno' => $this->input->post('bcontactno', true),
		    'gstno' => $this->input->post('bgstno', true),
		    'panno' => $this->input->post('bpanno', true),
		    'cinno' => $this->input->post('bcinno', true),
		    'address' => $this->input->post('baddress', true),
		];

		if($this->client_m->updateclient($data, $this->input->post('clientid', true))){
			redirect(base_url('clients'));
		}
	}

	//Get Client Product
	function clientproducts($id){
		$this->data['id'] = $id;
		$this->data['rows'] = $this->client_m->clientproducts($id);
		$this->data['randerPage'] = "clients/clientproductview";
		$this->load->view('_layout', $this->data);
	}

	//Client Product Add
	function addclientproducts($id = false){
		if($_POST){
			$arr = [
				'check' => $this->input->post('check'),
				'discount' => $this->input->post('discount')
			];
			if($this->client_m->addclientproducts($id, $arr))
				redirect(base_url('clients/clientproducts/'.$id));
		}

		$this->data['id'] = $id;
		$this->data['randerPage'] = "clients/clientproduct";
		$this->load->view('_layout', $this->data);
	}

	function statesopt($id){
		$arr = [
			'sts' => 1,
			'data' => $this->organigation_m->state(true, $id),
		];
		echo json_encode($arr);
	}

	function citiesopt($id){
		$arr = [
			'sts' => 1,
			'data' => $this->organigation_m->city(true, $id),
		];
		echo json_encode($arr);
	}

	function stationsopt($id){
		$arr = [
			'sts' => 1,
			'data' => $this->organigation_m->stations(true, $id),
		];
		echo json_encode($arr);
	}

	public function do_upload(){
            $config['upload_path']          = './uploads/clients/';
            $config['allowed_types']        = 'gif|jpg|png';
            $config['max_size']             = 0;
            $config['max_width']            = 0;
            $config['max_height']           = 0;
            $config['encrypt_name']           = true;

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('image')){
            	return base_url().'assets/dist/img/rpdlogo.png';
                $error = array('error' => $this->upload->display_errors());
            }else{
                $res = $this->upload->data();
            	return base_url('uploads/clients/').$res['file_name'];
            }
    }
    
    //Import File
    function import(){
    	if(isset($_FILES["importfile"]["name"])){
			$path = $_FILES["importfile"]["tmp_name"];
   			$object = PHPExcel_IOFactory::load($path);
   			
   			$arr = [];
   			foreach($object->getWorksheetIterator() as $worksheet){
			    $highestRow = $worksheet->getHighestRow();
			    $highestColumn = $worksheet->getHighestColumn();
				
				for($row = 2; $row <= $highestRow; $row++){
					if($worksheet->getCellByColumnAndRow(0, $row)->getValue() != ""){
						$data['client'] = [
							'image' => base_url('assets/dist/img/rpdlogo.png'),
							'clientname' => $worksheet->getCellByColumnAndRow(0, $row)->getValue(),
							'code' => $worksheet->getCellByColumnAndRow(1, $row)->getValue(),
							'legencycode' => $worksheet->getCellByColumnAndRow(2, $row)->getValue(),
							'parent' => clientmasertcode($worksheet->getCellByColumnAndRow(3, $row)->getValue(), 'parent_client', 'code'),
							'source' => clientmasertcode($worksheet->getCellByColumnAndRow(4, $row)->getValue(), 'source', 'id'),
							'referby' => $worksheet->getCellByColumnAndRow(5, $row)->getValue(),
							'customercateory' => clientmasertcode($worksheet->getCellByColumnAndRow(6, $row)->getValue(), 'client_category', 'code'),
							'language' => clientmasertcode($worksheet->getCellByColumnAndRow(7, $row)->getValue(), 'language', 'id'),
							'qualification' => clientmasertcode($worksheet->getCellByColumnAndRow(8, $row)->getValue(), 'qualification', 'code'),
							'currency' => getcurrency($worksheet->getCellByColumnAndRow(9, $row)->getValue(), 'currency'),
							'mobile' => $worksheet->getCellByColumnAndRow(10, $row)->getValue(),
							'whatsappno' => $worksheet->getCellByColumnAndRow(11, $row)->getValue(),
							'landlineno' => $worksheet->getCellByColumnAndRow(12, $row)->getValue(),
							'assistantno' => $worksheet->getCellByColumnAndRow(13, $row)->getValue(),
							'email' => 	$worksheet->getCellByColumnAndRow(14, $row)->getValue(),
							'dob' => $worksheet->getCellByColumnAndRow(15, $row)->getValue(),
							'anniversarydate' => $worksheet->getCellByColumnAndRow(16, $row)->getValue(),
							'practicingyear' => $worksheet->getCellByColumnAndRow(17, $row)->getValue(),
							'creditdays' => $worksheet->getCellByColumnAndRow(18, $row)->getValue(),
							'country' => getcountry($worksheet->getCellByColumnAndRow(19, $row)->getValue(), 'country', 'id'),
							'state' => 	getstate($worksheet->getCellByColumnAndRow(20, $row)->getValue(), 'states', 'id'),
							'city' => getcity($worksheet->getCellByColumnAndRow(21, $row)->getValue(), 'cities'),
							'area' => $worksheet->getCellByColumnAndRow(22, $row)->getValue(),
							'landmark' => $worksheet->getCellByColumnAndRow(23, $row)->getValue(),
							'pincode' => $worksheet->getCellByColumnAndRow(24, $row)->getValue(),
							'station' => getstation($worksheet->getCellByColumnAndRow(25, $row)->getValue(), 'stations', 'id'),
							'address' => $worksheet->getCellByColumnAndRow(26, $row)->getValue(),
							'remark1' => $worksheet->getCellByColumnAndRow(27, $row)->getValue(),
							'added_at' => date('Y-m-d H:i:s'),
							// 'added_by' => 'admin',
						];

						$data['billing'] = [
						    'company' => $worksheet->getCellByColumnAndRow(28, $row)->getValue(),
						    'email' => $worksheet->getCellByColumnAndRow(29, $row)->getValue(),
						    'contactno' => $worksheet->getCellByColumnAndRow(30, $row)->getValue(),
						    'gstno' => $worksheet->getCellByColumnAndRow(31, $row)->getValue(),
						    'panno' => $worksheet->getCellByColumnAndRow(32, $row)->getValue(),
						    'cinno' => $worksheet->getCellByColumnAndRow(33, $row)->getValue(),
						    'address' => $worksheet->getCellByColumnAndRow(34, $row)->getValue(),
						];

						$data['subdoc'] = [
							'name' => $worksheet->getCellByColumnAndRow(0, $row)->getValue(),
							'mobile' => $worksheet->getCellByColumnAndRow(10, $row)->getValue(),
							'design_preferences' => null,
							'is_primary' => 1,
							'added_by' => null,
							'added_at' => date('Y-m-d H:i:s')
						];

						$this->client_m->addclient($data);
						}
					}
    			}
		}
		redirect(base_url('clients'));
    }

    function changediscount($id){
    	$this->db->set('discount', $this->input->post('dis'))->where('id', $id)->update('client_products');
    	if($this->db->affected_rows() > 0)
    		echo true;
    }

    function removeProduct($id){
    	$this->db->where('id', $id)->delete('client_products');
    	if($this->db->affected_rows() > 0)
    		echo true;
    }

    //Client Dashboard
    function dashboard($id = false){
    	$this->data['header_content'] = (object)[
			'title' => 'Client',
			'sub_title' => 'Dashboard',
			'path' => uri_string(),
		];

		$this->data['sidebar'] = (object)[
			'menu' => 'cleintdashboard',
			'submenu' => 'cleintdashboard'
		];

    	$this->data['randerPage'] = "clients/clienslist";
    	$this->data['rows'] = $this->client_m->getclients();
    	if($id){
	    	$this->data['randerPage'] = "clients/dashboard";
	    	$this->data['clientid'] = $id;
    	}
		$this->load->view('_layout', $this->data);
    }

    function capping(){
    	$client = $this->input->post('client');
    	$value = $this->input->post('capping');
    	
    	$this->db->set('capping_value', $value)->where('id', $client)->update('clients');
    	if($this->db->affected_rows() > 0)
    		echo 1;
    }

    function is_gst($id, $sts){
    	$this->db->set('is_gst', $sts)->where('id', $id)->update('clients');
    	if($this->db->affected_rows() > 0){
    		echo true;
    	}else{
    		echo false;
    	}
    }

    /**
    * Zone Stations by Zone
    */
    function zone_stations_opt($id){
    	$zone = $this->db->select('stations')->where('id', $id)->get('zones')->row('stations');
    	if(!empty($zone)){
    		$arr = [];
    		foreach (json_decode($zone) as $z) {
    			$arr[] = $this->db->select('id, station')->where('id', $z)->get('stations')->row();

    		}

    		$res = [
				'sts' => 1,
				'data' => $arr,
			];
			echo json_encode($res);
    	}
    }


}
