<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Productmaster extends CI_Controller {
	function __Construct(){
		parent::__Construct();
		if($this->session->userdata('username') == '')
			redirect('logout');

		$this->data['info'] = info(true);

		$this->data['header_content'] = (object)[
			'title' => 'Product',
			'sub_title' => 'Masters',
			'path' => uri_string(),
		];

		$this->data['sidebar'] = (object)[
			'menu' => $this->uri->segment(1),
			'submenu' => $this->uri->segment(2)
		];

		$this->load->model('productmaster_m');
		$this->data['script'] = 'productmaster';
		$this->load->library('excel');
		$this->load->library('m_pdf');
	}

	//Add Category
	function category(){
		$this->data['randerPage'] = "productmaster/category";
		$this->data['rows'] = $this->productmaster_m->allrows('productcategory');
		if($_POST){
			$arr = [
				"title" => $this->input->post('title', true),
				"code" => $this->input->post('code', true),
			];
			echo $this->productmaster_m->add('productcategory', $arr);
		}
		$this->load->view('_layout', $this->data);
	}
	
	function updateproduct(){
		$arr = [
			"title" => $this->input->post('title', true),
			"code" => $this->input->post('code', true),
			"legancy_code" => $this->input->post('legancy_code', true),
			"desc" => $this->input->post('desc', true),
			"group" => $this->input->post('group', true),
			"brand" => $this->input->post('brand', true),
			"warranty" => $this->input->post('warranty', true),
			"category" => $this->input->post('category', true),
			"type" => $this->input->post('type', true),
			"unit_price" => $this->input->post('price', true),
		];
		echo $this->productmaster_m->updateproduct($arr, $this->input->post('eproduct_id'));
	}

	//Add Category
	function warranty(){
		$this->data['randerPage'] = "productmaster/warranty";
		$this->data['rows'] = $this->productmaster_m->allrows('warranty');
		if($_POST){
			$arr = [
				"warranty" => $this->input->post('title', true)
			];
			echo $this->productmaster_m->add('warranty', $arr);
		}
		$this->load->view('_layout', $this->data);
	}

	//Product Brand
	function brand(){
		$this->data['randerPage'] = "productmaster/brand";
		$this->data['rows'] = $this->productmaster_m->allrows('productbrand');
		if($_POST){
			$arr = [
				"brand" => $this->input->post('title', true),
				"warranty" => $this->input->post('warranty', true),
				"code" => $this->input->post('code', true),
			];
			echo $this->productmaster_m->add('productbrand', $arr);
		}
		$this->load->view('_layout', $this->data);
	}

	function group(){
		$this->data['randerPage'] = "productmaster/group";
		$this->data['rows'] = $this->productmaster_m->allrows('productgroup');
		if($_POST){
			$arr = [
				"group" => $this->input->post('title', true),
				"code" => $this->input->post('code', true),
			];
			echo $this->productmaster_m->add('productgroup', $arr);
		}
		$this->load->view('_layout', $this->data);
	}

	function type(){
		$this->data['randerPage'] = "productmaster/types";
		if($_POST){
			$rx = $_POST['rxselabel'];
			$arr = [
				"title" => $this->input->post('type', true),
				"product_category" => $this->input->post('category', true),
				"code" => get_code('producttype', 'PT'),
			];
			echo $this->productmaster_m->add('producttype', $arr, $rx);
		}
		$this->data['rows'] = $this->productmaster_m->allproducttypes();
		$this->load->view('_layout', $this->data);
	}

	function typeupdate(){
		if($_POST){
			$rx = $_POST['rxselabel'];
			$arr = [
				"title" => $this->input->post('type', true),
				"product_category" => $this->input->post('category', true),
			];
			echo $this->productmaster_m->updatetype($arr, $rx, $this->input->post('id', true), $this->input->post('code', true));
		}
	}

	function product(){
		$this->data['randerPage'] = "productmaster/products";
		if($_POST){
			$arr = [
				"title" => $this->input->post('title', true),
				"code" => $this->input->post('code', true),
				"legancy_code" => $this->input->post('legancy_code', true),
				"desc" => $this->input->post('desc', true),
				"group" => $this->input->post('group', true),
				"brand" => $this->input->post('brand', true),
				"warranty" => $this->input->post('warranty', true),
				"category" => $this->input->post('category', true),
				"type" => $this->input->post('type', true),
				"unit_price" => $this->input->post('price', true),
				"added_at" => date('Y-m-d H:i:s')
			];
			if($this->productmaster_m->add('product', $arr)){
				$this->assign_product($arr['code']);
				echo true;
			}
		}
		$this->data['rows'] = $this->productmaster_m->allproducts();
		$this->load->view('_layout', $this->data);
	}

	private function assign_product($pid){
		$clients = $this->db->select('id')->get('clients')->result();
		foreach($clients as $c){
			$arr = [
				'client_id' => $c->id,
				'product_id' => $pid,
				'discount' => 0
			];
			$this->db->insert('client_products', $arr);
		}
	}

	function import($master){
		if(isset($_FILES["file"]["name"])){
			$path = $_FILES["file"]["tmp_name"];
   			$object = PHPExcel_IOFactory::load($path);
   			
   			foreach($object->getWorksheetIterator() as $worksheet){
			    $highestRow = $worksheet->getHighestRow();
			    $highestColumn = $worksheet->getHighestColumn();
				
				for($row = 2; $row <= $highestRow; $row++){
					$customer_name = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
					$address = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
					$city = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
					$postal_code = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
					$country = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
					
					$data[] = array(
						'CustomerName' => $customer_name,
						'Address' => $address,
						'City' => $city,
						'PostalCode' => $postal_code,
						'Country' => $country
					);
    			}
   			}
			$this->excel_import_model->insert($data);
			echo 'Data Imported successfully';
		} 
	}

	function typesopt($cat){
		echo json_encode(['sts' => 1, 'data' => $this->productmaster_m->typesopt($cat)]);
	}

	function producttypeupdate($id){
		$type = $this->db->where('id', $id)->get('producttype')->row();
		$rxopt = $this->db->where('producttype', $type->code)->get('rxoptions')->row();
		echo json_encode(['type'=>$type, 'rx'=>$rxopt]);
	}

	function rxs($id){
		echo json_encode(['sts' => 1, 'data' => $this->productmaster_m->rxs($id)]);
	}

	function productsopt($type, $client){
		echo json_encode(['sts' => 1, 'data' => $this->productmaster_m->productsopt($type, $client)]);
	}

	function is_status($id, $sts){
		$this->db->set('status', $sts)->where('id', $id)->update('product');
		if($this->db->affected_rows() > 0){
			echo true;
		}else{
			echo false;
		}
	}


	function warrantycards(){
		$this->data['header_content'] = (object)[
			'title' => 'New Warranty Cards',
			'sub_title' => '',
			'path' => uri_string(),
		];
		$this->data['sidebar'] = (object)[
			'menu' => 'warrenty',
			'submenu' => 'cardlist'
		];

		if($_POST){
			$card_no = $this->input->post('card_no', true);

			$arr = [
				'card_no' => $card_no,
				'added_by' => login_user(),
				'added_at' => date('Y-m-d H:i:s')
			];

			if($this->db->insert('warranty_cards', $arr)){
				echo json_encode(['sts' => 1]);
				return;
			}
		}

		$arr = [];
		$temp = $this->db->select('card_no')->get('warranty_cards')->result();
		foreach($temp as $t){
			$r = $this->db->select('case_number, date, time, clientname')->where('warrenty_code', $t->card_no)->get('warrenty_card')->row();
			$arr[] = [
				'card_no' => $t->card_no,
				'client_name' => $r->clientname,
				'case_number' => $r->case_number,
				'date' => $r->date,
				'time' => $r->time
			];
		}
		
		$this->data['rows'] = $arr;
		$this->data['randerPage'] = "productmaster/cardlist";
		$this->load->view('_layout', $this->data);
	}

	function wc($wc){
		$res = $this->db->where('card_no', $wc)->get('warranty_cards')->num_rows();
		if($res > 0){
			$r = $this->db->where('warrenty_code', $wc)->get('warrenty_card')->num_rows();
			if($r > 0)
				echo 0;
			else
				echo 1;
		}else{
			echo 0;
		}

	}

	function warranty_card(){
		$this->data['header_content'] = (object)[
			'title' => 'Product Warranty Cards',
			'sub_title' => '',
			'path' => uri_string(),
		];
		$this->data['sidebar'] = (object)[
			'menu' => 'warranty',
			'submenu' => 'warranty_card'
		];
		if($_POST){
			$arr  = [
				'warrenty_code' => $this->input->post('warrenty_code', true),
				'verification_code' => $this->input->post('verification_code', true),
				'date' => date('Y-m-d', strtotime($this->input->post('date', true))),
				'time' => $this->input->post('time', true),
				'frame_bar_code' => $this->input->post('frame_bar_code', true),
				'case_number' => $this->input->post('case_number', true),
				'product_type' => $this->input->post('product_type', true),
				'product' => $this->input->post('product_name', true),
				'units' => $this->input->post('units', true),
				'case_desc' => $this->input->post('case_desc', true),
				'shade_1' => $this->input->post('s1', true),
				'shade_2' => $this->input->post('s2', true),
				'shade_3' => $this->input->post('s3', true),
				'clientname' => $this->input->post('dentist_name', true),
				'cmobile' => $this->input->post('cmobile', true),
				'cemail' => $this->input->post('cemail', true),
				'clocation' => $this->input->post('clocation', true),
				'patiantname' => $this->input->post('patient_name', true),
				'pmobile' => $this->input->post('pmobile', true),
				'pemail' => $this->input->post('pemail', true),
				'plocation' => $this->input->post('plocation', true),
				'pstatus' => $this->input->post('status', true),
				'added_at' => date('Y-m-d'),
				'added_by' => login_user(),
			];
			$this->db->insert('warrenty_card', $arr);
		}

		$this->data['rows'] = $this->db->get('warrenty_card')->result();
		$this->data['randerPage'] = "productmaster/warrenty_card";
		$this->load->view('_layout', $this->data);
	}

	function case_details($case, $product_type = false, $product = false){
		if($product){
			$res = $this->db->select('p.title, op.product_id')->from('orders as o')
			->join('order_products as op', 'op.order_id = o.id', 'inner')
			->join('product as p', 'p.code = op.product_id', 'inner')->where('o.modal_no', $case)->where('op.product_type', $product_type)->group_by('op.product_id')->get()->result();
		}else{
			$res = $this->db->select('pt.title, op.product_type')->from('orders as o')
			->join('order_products as op', 'op.order_id = o.id', 'inner')
			->join('producttype as pt', 'pt.code = op.product_type', 'inner')->where('o.modal_no', $case)->group_by('op.product_type')->get()->result();
		}
		echo json_encode($res);
	}

	function case_info($case, $product_type, $product){
		$res = $this->db
		->select('op.unit, o.note, o.shade_one, o.shade_two, o.shade_three, c.clientname, o.patiant_name, c.email, c.mobile, c.address as location')
		->from('orders as o')
		->join('order_products as op', 'op.order_id = o.id', 'inner')
		->join('clients as c', 'c.id = o.client_code', 'inner')
		->join('product as p', 'p.code = op.product_id', 'inner')
		->join('stations as s', 's.id = c.station', 'inner')
		->where('op.product_id', $product)
		->where('op.product_type', $product_type)
		->where('o.modal_no', $case)
		->group_by('op.product_id')
		->get()->row();
		echo json_encode($res);
	}

	function warrentycard($id  = false){
		$this->data['card_data'] = $this->db->where('id', $id)->or_where('warrenty_code', $id)->get('warrenty_card')->row();
        $html = $this->load->view('productmaster/warrenty_card_print', $this->data, true);
        $this->m_pdf->pdf($html, $id.'_invoice_'.time().'.pdf');
	}

	function shade_info($s){
		echo $this->db->select('title')->where('code', $s)->get('shade')->row('title');
	}

	function change_wc_status(){
		$sts = $this->input->post('ps');
		$id = $this->input->post('id');
	
		$this->db->set('pstatus', $sts)->where('id', $id)->update('warrenty_card');
		if($this->db->affected_rows() > 0)
			echo 1;
		else
			echo 0;
	}
}
