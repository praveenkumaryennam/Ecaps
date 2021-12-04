<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Order_m extends CI_Model {
	private $column_search;

	function __constuct(){
		parent::__constuct();
		$this->column_search = ['order_number,order_date,patiant_name'];
	}
    /**
	* All Orders List
	*/
	function getorders($id = false, $datatable = false, $column_search = false, $_is = false){
		if($id){
			return $this->db->select('o.*, o.id as oid, c.*')->from('orders as o')->join('clients as c', 'c.id = o.client_code', 'inner')->where('o.order_status', 1)->where('o.status', 0)->where('o.id', $id)->order_by('o.id', 'desc')->get()->row();
		}else{
			$c = $this->get_orders(false, $datatable, $column_search, $_is);
			$d = $this->get_orders(true, $datatable, $column_search, $_is);
			return [
				'filtered' => $c->num_rows(),
				'data' => $d->result()
			];
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

	/**
	*
	*/
	function get_shipment_orders($id = false){
		if($id)
			return $this->db->select('o.client_code, o.order_number, o.id, o.order_date as date, o.note, c.clientname, c.code as ccode, o.patiant_name, o.order_status, o.modal_no, o.due_date, o.duetime, o.intime')->from('orders as o')->join('clients as c', 'c.id = o.client_code', 'inner')->where('o.order_status', 1)->where('o.status', 0)->where('o.order_number NOT IN (select order_id from rpd_shipments)',NULL,FALSE)->where('o.order_number', $id)->get()->row();

		return $this->db->select('o.client_code, o.order_number, o.id, o.order_date as date, o.note, c.clientname, c.code as ccode, o.patiant_name, o.order_status, o.modal_no, o.due_date, o.duetime, o.intime')->from('orders as o')->join('clients as c', 'c.id = o.client_code', 'inner')->where('o.order_status', 1)->where('o.status', 0)->where('o.order_number NOT IN (select order_id from rpd_shipments)',NULL,FALSE)->order_by('o.id', 'desc')->get()->result();
	}

	function get_bulk_client_shipment_orders($client, $id = false){
		if($id)
			return $this->db->select('o.client_code, o.order_number, o.id, o.order_date as date, o.note, c.clientname, c.code as ccode, o.patiant_name, o.order_status, o.modal_no, o.due_date, o.work_type')->from('orders as o')->join('clients as c', 'c.id = o.client_code', 'inner')->where('o.order_status', 1)->where('o.status', 0)->where('o.order_number NOT IN (select order_id from rpd_shipments)',NULL,FALSE)->where('o.client_code', $client)->where('o.order_number', $id)->get()->row();

		return $this->db->select('o.client_code, o.order_number, o.id, o.order_date as date, o.note, c.clientname, c.code as ccode, o.patiant_name, o.order_status, o.modal_no, o.due_date, o.work_type')->from('orders as o')->join('clients as c', 'c.id = o.client_code', 'inner')->where('o.is_challan', 0)->where('o.status', 0)->where('o.order_number NOT IN (select order_id from rpd_shipments)',NULL,FALSE)->order_by('o.id', 'desc')->where('o.client_code', $client)->get()->result();
	}

	function placeorder($data){
		if($this->db->insert('orders', $data['order'])){
			$id = $this->db->insert_id();
			$total_units = 0;
			$total_amount = 0;
			for($i=0; $i<sizeof($data['products']); $i++){
				$arr = [
					'order_id' => $id,
					'product_id' => $data['products'][$i]['product']['id'],
					'product_type' => $data['products'][$i]['producttype']['id'],
					'product_category' => $data['products'][$i]['productcategory']['id'],
					'teeth' => $data['products'][$i]['teethcount'],
					'unit' => $data['products'][$i]['unit'],
					'unit_price' => $data['products'][$i]['unitrate'],
					'discount' => $data['products'][$i]['cdiscount'],
					'total_amount' => $data['products'][$i]['total'],	
					'options' => json_encode($data['products'][$i]['rx']),
				];
				if($this->db->insert('order_products', $arr)){
					$total_amount += $data['products'][$i]['total'];
					$total_units += $data['products'][$i]['unit'];
				}
			}

			for($j=0; $j<sizeof($data['schedules']); $j++){
				$arr = [
					'order_id' => $id,
					'title' => $data['schedules'][$j]['id'],
					'sch_date' => date('Y-m-d', strtotime(str_replace('/','-',$data['schedules'][$j]['date']))),
					'status' => $data['schedules'][$j]['sts'],
				];
				$this->db->insert('order_schadules', $arr);
			}
			return ['sts'=>true, 'order_id'=> $id, 'units'=>$total_units, 'amount'=>$total_amount];
		}
	}
        
	function get_order($id, $number){
		return $this->db->where(['id' => $id, 'order_number' => $number])->order_by('id', 'desc')->get('orders')->row();
	}

	function get_order_products($id){
		return $this->db->select('op.*, pc.title as category, p.title as product, p.unit_price as baseprice, pt.title as type')->from('order_products as op')
		->join('productcategory as pc', 'pc.code = op.product_category', 'inner')
		->join('producttype as pt', 'pt.code = op.product_type', 'inner')
		->join('product as p', 'p.code = op.product_id', 'inner')
		->where('op.order_id', $id)
		->where('op.status', 0)
		->get()->result();
	}

	/**
	* All Invoice List
	*/
	function invloiceslist($id = false, $datatable = false, $column_search = false, $_is = false){
			$c = $this->get_invoices(false, $datatable, $column_search, $_is);
			$d = $this->get_invoices(true, $datatable, $column_search, $_is);
			return [
				'filtered' => $c->num_rows(),
				'data' => $d->result()
			];
	}

	private function get_invoices($is_len = false, $datatable=false, $column_search=false, $_is=false){
		$this->db->select('i.*,c.code, c.clientname');
		$this->db->from('invoice as i');
		$this->db->join('clients as c', 'c.id = i.client_id', 'inner');
		$this->db->where(['i.status' => 0]);

		if(!empty($datatable['search']['value'])){
			if($is_len){
		    	$this->db->limit($datatable['length'], $datatable['start']);
			}

		    $this->db->like('i.invoice_number', $datatable['search']['value']);
		    $this->db->or_like('i.order_number', $datatable['search']['value']);
		    $this->db->or_like('c.clientname', $datatable['search']['value']);

			return $this->db->group_by('i.invoice_number')->order_by('i.invoice_number', 'desc')->get();
		}else{
			if($is_len){
		    	$this->db->limit($datatable['length'], $datatable['start']);
			}
			return $this->db->group_by('i.invoice_number')->order_by('i.invoice_number', 'desc')->get();
		}
	}

}
