<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Offer extends CI_Controller {
	function __Construct(){
		parent::__Construct();
		if($this->session->userdata('username') == '')
			redirect('logout');

		$this->data['info'] = info(true);

		$this->data['header_content'] = (object)[
			'title' => 'Offer Master',
			'sub_title' => '',
			'path' => uri_string(),
		];

		$this->data['sidebar'] = (object)[
			'menu' => $this->uri->segment(1),
			'submenu' => $this->uri->segment(2)
		];
	}

	function index(){
		if($_POST){
			$data = [
				'title' => $this->input->post('offer'), 
				'offer_type' => $this->input->post('offer_type'), 
				'minimum_order' => $this->input->post('min_order'), 
				'offering' => $this->input->post('offering'), 
				'offeringtype' => $this->input->post('offeringtype'), 
			];
			return $this->db->insert('offer', $data);
		}
		$this->data['rows'] = $this->get_offers();
		$this->data['randerPage'] = "offer/index";
		$this->load->view('_layout', $this->data);
	}

	function getoffer($id){
		$res = $this->db->where('client_id', $id)->get('offer_meta')->row();
		echo ($res)?json_encode($res):false;
	}

	private function get_offers(){
		return $this->db->get('offer')->result();
	}

	function apply_offer(){
		if($_POST){
			$data = [
				'client_id' => $this->input->post('client_id'), 
				'offer_id' => $this->input->post('offer'), 
				'offeringtype' => $this->input->post('offeringtype'), 
				'offer_type' => $this->input->post('offer_type'), 
				'start_date' => ec_date_format($this->input->post('start_date'), 'Y-m-d H:i:s'), 
				'end_date' => ec_date_format($this->input->post('end_date'), 'Y-m-d H:i:s'), 
			];

			if($this->input->post('offerId') == ""){
				unset($data['client_id']);
				echo ($this->db->insert('offer_meta', $data))?true:false;
			}else{
				$temp = $data['client_id'];
				unset($data['client_id']);
				$this->db->set($data)->where(['id'=>$this->input->post('offerId'), 'client_id'=>$temp])->update('offer_meta');
				if($this->db->affected_rows() > 0){
					echo true;
				}
			}
		}
	}

	/**
	* Get Product Offer 
	*/
	function getproductoffer($id){
		$res = $this->db->where('product_id', $id)->get('offer_products')->row();
		echo ($res)?json_encode($res):false;
	}

	/**
	* Get Product Offer 
	*/
	function product_offer(){
		if($_POST){
			$data = [
				'offerpid' => $this->input->post('offerpid'),
				'offer_id' => $this->input->post('offer'),
				'product_id' => $this->input->post('product_id'), 
			];

			if($this->input->post('offerpid') == ""){
				unset($data['offerpid']);
				echo ($this->db->insert('offer_products', $data))?true:false;
			}else{
				$this->db->set($data)->where(['id'=>$this->input->post('offerpid')])->update('offer_products');
				if($this->db->affected_rows() > 0){
					echo true;
				}
			}
		}
	}


}
