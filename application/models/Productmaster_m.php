<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Productmaster_m extends CI_Model {
	function __constuct(){
		parent::__constuct();
	}

	function allrows($tbl){
		return $this->db->order_by('id', 'desc')->get($tbl)->result();
	}

	function add($tbl, $data, $rx = false){
		if(!empty($rx)){
			if($this->db->insert($tbl, $data)){
				$id = $data['code'];
				$arr = [
					'producttype' => $id,
					'options' => $rx
				];
				return $this->db->insert('rxoptions', $arr);
			}
		}
		return $this->db->insert($tbl, $data);
	}

	function updatetype($data, $rx, $id, $code){
		if($this->db->set($data)->where('id', $id)->update('producttype')){
			$ide = $this->db->where('producttype', $code)->get('rxoptions')->num_rows();
			if($ide > 0){
				$arr = [
					'options' => $rx
				];
				return $this->db->set($arr)->where('producttype', $code)->update('rxoptions'); 
			}else{
				$arr = [
					'producttype' => $code,
					'options' => $rx
				];
				return $this->db->insert('rxoptions', $arr);
			}
		}
	}
	
    function updateproduct($arr, $id){
		$this->db->set($arr)->where('id', $id)->update('product');
		if($this->db->affected_rows() > 0)
			return true;
	}

	function allproducts(){
		$res = $this->db->select('p.*, b.brand as abrand, c.title as acategory, g.group as agroup, t.title as atype, w.warranty as awarranty')->from('product as p')
		->join('productbrand as b', 'b.id = p.brand', 'left')
		->join('productgroup as g', 'g.id = p.group', 'left')
		->join('productcategory as c', 'c.code = p.category', 'left')
		->join('producttype as t', 't.code = p.type', 'left')
		->join('warranty as w', 'w.id = p.warranty', 'left')
		->get()->result();
		return $res;
	}

	function typesopt($cat){
		return $this->db->select('code, title')->from('producttype')->where('product_category', $cat)->get()->result();
	}

	function rxs($id){
		return $this->db->select('options as rxs')->from('rxoptions')->where('producttype', $id)->get()->row()->rxs;
	}

	function productsopt($type, $client_id){
		return $this->db->select('p.code, p.title, p.unit_price as price, cp.discount')->from('product as p')->join('client_products as cp', 'cp.product_id = p.code', 'inner')->where('p.type', $type)->where(['cp.client_id' => $client_id, 'p.status' => 0])->get()->result();
	}

	function allproducttypes(){
		$res = $this->db->select('p.*,c.title as product_category')->from('producttype as p')->join('productcategory as c', 'c.code = p.product_category', 'left')->order_by('p.id', 'desc')->get()->result();
		return $res;
	}

}