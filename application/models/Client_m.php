<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Client_m extends CI_Model {
	function __constuct(){
		parent::__constuct();
	}

	//Parent Add and Get Rows
	function parent($_is = false){
		if($_is)
			return $this->db->order_by('id', 'desc')->get('parent_client')->result();

		$arr = [
			'title' => $this->input->post('title'),
			'code' => $this->input->post('code'),
		];
		return $this->db->insert('parent_client', $arr);
	}

	//Category Add and Get Rows
	function category($_is = false){
		if($_is)
			return $this->db->order_by('id', 'desc')->get('client_category')->result();

		$arr = [
			'title' => $this->input->post('title'),
			'code' => $this->input->post('code'),
		];
		return $this->db->insert('client_category', $arr);
	}

	//Get Single Client Detail
	function getclient($id){
		return $this->db->where('id', $id)->get('clients')->row();
	}

	function getclient_billing_address($id){
		return $this->db->where('client', $id)->get('client_billing')->row();
	}

	//Get Clienta Details
	function getclients($_is = false){
		$this->db->select('c.id, c.clientname, c.code, c.email, c.mobile, ci.city, c.parent, c.status, c.is_gst, s.station, s.id as station_id, st.state')->from('clients as c')->join('cities as ci', 'ci.id = c.city', 'left')->join('stations as s', 's.id = c.station', 'left')->join('states as st', 'st.id = c.state', 'left');
		if($_is == true)
			$this->db->where('c.status', 1);
		return $this->db->order_by('c.id', 'asc')->get()->result();
	}

	//Capping Docs
	function get_capping_clients($_is = false){
		return $this->db->select('id, clientname, code, mobile, whatsappno, capping_value, capping_limit')->from('clients as c')->where('capping_value != "" OR capping_value > 0')->order_by('c.id', 'asc')->get()->result();
	}

	function addclient($data){
		if($this->db->insert('clients', $data['client'])){
			$id = $this->db->insert_id();
			$this->add_billing($id, $data['billing']);
			$this->add_subdoc($id, $data['subdoc']);
			
			$pros = $this->db->select('code')->get('product')->result();
			foreach($pros as $pro){
				$arr = [
					'client_id' => $id,
					'product_id' => $pro->code,
					'discount' => 0
				];
				$this->db->insert('client_products', $arr);
			}
			return true;
		}
		return false;
	}

	//Update Client
	function updateclient($data, $id){
		if($this->db->set($data['client'])->where('id', $id)->update('clients')){
			$this->update_billing($id, $data['billing']);
			return true;
		}
		return false;
	}

	function clientproducts($id = false){
		if($id)
			return $this->db->select('p.*, cp.discount, c.title as category, cp.id as cpid')->where('client_id', $id)->from('client_products as cp')->join('product as p', 'p.code = cp.product_id', 'inner')->join('productcategory as c', 'c.code = p.category', 'inner')->order_by('cp.id', 'desc')->get()->result();
		return $this->db->select('p.*, c.title as category')->from('product as p')->join('product as p', 'p.code = cp.product_id', 'inner')->join('productcategory as c', 'c.code = p.category', 'inner')->order_by('p.id', 'desc')->get()->result();
	}

	//Client Product Add
	function addclientproducts($id, $data){
		for($i = 0; $i < sizeof($data['check']); $i++){
			$arr = [
				'client_id' => $id,
				'product_id' => $data['check'][$i],
				'discount' => $data['discount'][$i]
			];
			$this->db->insert('client_products', $arr);
		}
		return true;
	}

	private function add_billing($id, $data){
		$data = [
			'client' => $id,
			'company'=> $data['company'],
		    'email'=> $data['email'],
		    'contactno'=> $data['contactno'],
		    'gstno'=> $data['gstno'],
		    'panno'=> $data['panno'],
		    'cinno'=> $data['cinno'],
		    'address'=> $data['address'],
		];
		return $this->db->insert('client_billing', $data);
	}

	private function add_subdoc($id, $data){
		$data['client_id'] = $id;
		return $this->db->insert('subdoctors', $data);
	}

	private function update_billing($id, $data){
		$data = [
			'company'=> $data['company'],
		    'email'=> $data['email'],
		    'contactno'=> $data['contactno'],
		    'gstno'=> $data['gstno'],
		    'panno'=> $data['panno'],
		    'cinno'=> $data['cinno'],
		    'address'=> $data['address'],
		];
		return $this->db->set($data)->where('id', $id)->update('client_billing');
	}
} 
