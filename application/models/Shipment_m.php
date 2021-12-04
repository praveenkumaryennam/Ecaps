<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Shipment_m extends CI_Model {
	function __constuct(){
		parent::__constuct();
	}

	/**
	* All Orders List
	*/
	function getshipmentsnotes($id = false, $datatable = false, $column_search = false, $_is = false){
		$c = $this->get_shipments_rows(false, $datatable, $column_search, $_is);
		$d = $this->get_shipments_rows(true, $datatable, $column_search, $_is);
		return [
			'filtered' => $c->num_rows(),
			'data' => $d->result(),
		];
	}

	private function get_shipments_rows($is_len = false, $datatable=false, $column_search=false, $_is=false){
		$this->db->select('s.shipment_date, s.delivery_mode, s.challan_number, s.shipment_note, o.client_code, o.order_number, o.id, o.order_date as date, o.note, c.clientname, c.code as ccode, o.patiant_name, o.order_status, o.modal_no, o.units, o.order_value, o.work_type, o.order_priority, o.due_date, o.duetime, s.bulk, s.shipment_date, o.duetime, o.intime, s.added_at')->from('shipments as s')->join('orders as o', 'o.order_number = s.order_id', 'inner')->join('clients as c', 'c.id = o.client_code', 'inner');
		
		if(!empty($datatable['search']['value'])){
			if($is_len){
		    	$this->db->limit($datatable['length'], $datatable['start']);
			}

		    $this->db->like('o.patiant_name', $datatable['search']['value']);
		    $this->db->or_like('o.modal_no', $datatable['search']['value']);
		    $this->db->or_like('o.order_number', $datatable['search']['value']);
		    $this->db->or_like('c.clientname', $datatable['search']['value']);

			return $this->db->order_by('o.id', 'desc')->get();
		}else{
			if($is_len){
		    	$this->db->limit($datatable['length'], $datatable['start']);
			}
			return $this->db->order_by('o.id', 'desc')->get();
		}
	}

	private function get_orders($is_len = false, $datatable=false, $column_search=false, $_is=false){
		$this->db->select('o.client_code, o.order_number, o.id, o.order_date as date, o.note, c.clientname, c.code as ccode, o.patiant_name, o.order_status, o.work_type, o.modal_no, o.due_date, o.added_by');
		$this->db->from('orders as o');
		$this->db->join('clients as c', 'c.id = o.client_code', 'left');
		$this->db->where(['o.status' => 0]);

		if(!empty($datatable['search']['value'])){
			if($is_len){
		    	$this->db->limit($datatable['length'], $datatable['start']);
			}

		    $this->db->like('o.patiant_name', $datatable['search']['value']);
		    $this->db->or_like('o.modal_no', $datatable['search']['value']);
		    $this->db->or_like('o.order_number', $datatable['search']['value']);
		    $this->db->or_like('c.clientname', $datatable['search']['value']);

			return $this->db->order_by('o.id', 'desc')->get();
		}else{
			if($is_len){
		    	$this->db->limit($datatable['length'], $datatable['start']);
			}
			return $this->db->order_by('o.id', 'desc')->get();
		}
	}


	//View Job Card
	function orderdata($id){
		$od = $this->db->where('order_number', $id)->get('orders')->row();
		$odp = $this->db->where('order_id', $od->id)->get('order_products')->result();
		barcode($od->modal_no);
		$arr = [
			'jabcard_no' => $od->modal_no,
			'order_number' => $od->order_number,
			'added_by' => login_user(),
			'added_at' => date('Y-m-d H:i:s')
		];
		if($this->db->insert('rpd_njobcard', $arr)){
			return ['od' => $od, 'odp' => $odp];
		}
	}

	//Get All Genrated Shipments
	function getshipmentsnotes_arr($arr = false){
		if($arr)
			$date = '"'.date('Y-m-d', strtotime($arr['fromdate']))."\" AND \"".date('Y-m-d', strtotime($arr['todate'])).'"';

		$this->db->select('s.shipment_date, s.delivery_mode, s.challan_number, s.shipment_note, o.client_code, o.order_number, o.id, o.order_date as date, o.note, c.clientname, c.code as ccode, o.patiant_name, o.order_status, o.modal_no, o.units, o.order_value, o.work_type, o.order_priority, o.due_date, o.duetime, s.bulk, s.shipment_date, o.duetime, o.intime, s.added_at')->from('shipments as s')->join('orders as o', 'o.order_number = s.order_id', 'inner')->join('clients as c', 'c.id = o.client_code', 'inner');

		if($arr)
			$this->db->where('s.shipment_date BETWEEN '.$date);

		return $this->db->order_by('id', 'desc')->get()->result();
	}
}
