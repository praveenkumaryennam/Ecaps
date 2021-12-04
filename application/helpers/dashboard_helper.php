<?php  defined('BASEPATH') OR exit('No direct script access allowed');

	/***
	* get  all total count using table name 
		-- $tbl - veriable
	*/
	function get_count($tbl, $_for = false){
		$ci = &get_instance();

		if($tbl == 'employee'){
			return $ci->db->get($tbl)->num_rows();
		}

		if($tbl == 'clients'){
			switch($_for){
				case 1:
					$ci->db->where('added_at', date('Y-m-d'));
					break;
				case 2:
					$ci->db->where('added_at >= ', date('Y-m-01'));
					$ci->db->where('added_at <= ', date('Y-m-t'));
					break;
				case 3:
					$ci->db->where('added_at >= ', date('Y-01-01'));
					$ci->db->where('added_at <= ', date('Y-12-31'));
					break;
			}
			return $ci->db->get($tbl)->num_rows();
		}

		if($tbl == 'product'){
			switch($_for){
				case 1:
					$ci->db->where('DATE(added_at)', date('Y-m-d'));
					break;
				case 2:
					$ci->db->where('DATE(added_at) >= ', date('Y-m-01'));
					$ci->db->where('DATE(added_at) <= ', date('Y-m-t'));
					break;
				case 3:
					$ci->db->where('DATE(added_at) >= ', date('Y-01-01'));
					$ci->db->where('DATE(added_at) <= ', date('Y-12-31'));
					break;
			}
			return $ci->db->get($tbl)->num_rows();
		}

		if($tbl == 'orders'){
			switch($_for){
				case 1:
					$ci->db->where('DATE(order_date)', date('Y-m-d'));
					break;
				case 2:
					$ci->db->where('DATE(order_date) >= ', date('Y-m-01'));
					$ci->db->where('DATE(order_date) <= ', date('Y-m-t'));
					break;
				case 3:
					$ci->db->where('DATE(order_date) >= ', date('Y-01-01'))->where('is_invoice', 1);
					$ci->db->where('DATE(order_date) <= ', date('Y-12-31'))->where('is_invoice', 1);
					break;
			}
			return $ci->db->get($tbl)->num_rows();
		}

		if($tbl == 'process'){
			switch($_for){
				case 1:
					$ci->db->where('DATE(in_datetime)', date('Y-m-d'));
					break;
				case 2:
					$ci->db->where('DATE(in_datetime) >= ', date('Y-m-01'));
					$ci->db->where('DATE(in_datetime) <= ', date('Y-m-t'));
					break;
				default:
					$ci->db->where('DATE(in_datetime) >= ', date('Y-01-01'));
					$ci->db->where('DATE(in_datetime) <= ', date('Y-12-31'));
					break;
			}
			return $ci->db->get($tbl)->num_rows();
		}
	}

	/***
	* get total orders by there status
		--$sts for status
	*/
	function get_order_count($sts, $_for){
		$ci = &get_instance();
		switch($_for){
			case 1:
				$ci->db->where('DATE(order_date)', date('Y-m-d'));
				break;
			case 2:
				$ci->db->where('DATE(order_date) >= ', date('Y-m-01'));
				$ci->db->where('DATE(order_date) <= ', date('Y-m-t'));
				break;
			case 3:
				$ci->db->where('DATE(order_date) >= ', date('Y-01-01'));
				$ci->db->where('DATE(order_date) <= ', date('Y-12-31'));
				break;
		}
		return $ci->db->where('work_type', $sts)->where('status', 0)->get('orders')->num_rows();
	}


	/***
	* Total Invoice
	*/
	function total_invoices($_for){
		$ci = &get_instance();
		switch($_for){
			case 1:
				$ci->db->where('DATE(invoice_date)', date('Y-m-d'));
				break;
			case 2:
				$ci->db->where('DATE(invoice_date) >= ', date('Y-m-01'));
				$ci->db->where('DATE(invoice_date) <= ', date('Y-m-t'));
				break;
			case 3:
				$ci->db->where('DATE(invoice_date) >= ', date('Y-01-01'));
				$ci->db->where('DATE(invoice_date) <= ', date('Y-12-31'));
				break;
		}
		return $ci->db->group_by('invoice_number')->get('invoice')->num_rows();
	}

	/***
	* get total Challans 
		-- rpd_shipments
	*/
	function total_challans($_for){
		$ci = &get_instance();
		switch($_for){
			case 1:
				$ci->db->where('DATE(shipment_date)', date('Y-m-d'));
				break;
			case 2:
				$ci->db->where('DATE(shipment_date) >= ', date('Y-m-01'));
				$ci->db->where('DATE(shipment_date) <= ', date('Y-m-t'));
				break;
			case 3:
				$ci->db->where('DATE(shipment_date) >= ', date('Y-01-01'));
				$ci->db->where('DATE(shipment_date) <= ', date('Y-12-31'));
				break;
		}
		return $ci->db->get('shipments')->num_rows();
	}

	/***
	* Total Invoice Amount
	*/
	function total_invoice_amount($_for){
		$ci = &get_instance();
		switch($_for){
			case 1:
				$ci->db->where('DATE(invoice_date)', date('Y-m-d'));
				break;
			case 2:
				$ci->db->where('DATE(invoice_date) >= ', date('Y-m-01'));
				$ci->db->where('DATE(invoice_date) <= ', date('Y-m-t'));
				break;
			case 3:
				$ci->db->where('DATE(invoice_date) >= ', date('Y-01-01'));
				$ci->db->where('DATE(invoice_date) <= ', date('Y-12-31'));
				break;
		}
		$v = $ci->db->select('invoice_total')->group_by('invoice_number')->get('invoice')->result();
		$to = 0;
		foreach ($v as $a){
			$to += $a->invoice_total;
		}
		return $to;
	}


	/***
	* get all total count of Orders Inner joing Clients Table 
		-- rpd_orders
		-- rpd_clients
	*/
	function get_order_count_c(){
		$ci = &get_instance();
		return $ci->db->from('orders as r')->join('clients as c', 'c.id = r.client_code or c.code = r.client_code', 'inner')->where('r.order_status', 1)->where('r.status', 0)->get()->num_rows();
	}
	
	/***
	* get total Value of genrated invoices  
		-- rpd_invoce
	*/
	function get_total_collection($id){
		$ci = &get_instance();
		// return $ci->db->select('SUM(invoice_total) as total')->where('client_id', $id)->get('invoice')->row()->total;
		$data = $ci->db->select('invoice_total')->where('client_id', $id)->group_by('invoice_number')->get('invoice')->result();
        $t = 0;
        foreach ($data as $d) {
        	$t += $d->invoice_total;
        }
        return $t;
	}

	/***
	* get total Value of genrated invoices  
		-- rpd_orders
	*/
	function get_total_orders($id){
		$ci = &get_instance();
		return $ci->db->select('COUNT(*) as total')->where('client_code', $id)->get('orders')->row()->total;
	}

	/***
	* get total units saled from genrated invoices  
		-- rpd_invoce
	*/
	function get_total_sales($id){
		$ci = &get_instance();
		return $ci->db->select('SUM(units) as total')->where('client_id', $id)->get('invoice')->row()->total;
	}

	/***
	* get total challans genrated today  
		-- rpd_shipments
		-- $_is is true - get pedding today challans
	*/
	function challans($_is = false){
		$ci = &get_instance();
		if($_is)
			return $ci->db->from('orders as o')->where('DATE(o.due_date)', date('Y-m-d'))->where('o.order_number NOT IN (select order_id from rpd_shipments)',NULL,FALSE)->get()->num_rows();
		else
			return $ci->db->from('orders as o')->where('DATE(o.due_date)', date('Y-m-d'))->where('o.order_number IN (select order_id from rpd_shipments)',NULL,FALSE)->get()->num_rows();
	}

	/***
	* get total value of today challans
		-- rpd_shipments
	*/
	function challans_amt(){
		$ci = &get_instance();
		return $ci->db->select('SUM(op.total_amount) as total')->from('orders as o')->where('DATE(o.due_date)', date('Y-m-d'))->join('order_products as op', 'op.order_id = o.id', 'inner')->get()->row()->total;
	}
