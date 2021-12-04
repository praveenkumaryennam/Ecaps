<?php  defined('BASEPATH') OR exit('No direct script access allowed');

	/***
	* Company Profile Details
	*/
	function profile($col){
		$ci = &get_instance();
		return $ci->db->select($col)->get('company')->row()->$col;
	}

	function get_gst($id, $col = 'gstno'){
		$ci = &get_instance();
		return $ci->db->select($col)->where('client', $id)->get('client_billing')->row()->$col;
	}
	
	//Get Title By Code
	function get_title($code, $tbl){
		$ci = &get_instance();
		return $ci->db->where('code', $code)->or_where('id', $code)->get($tbl)->row('title');
	}

	//Get Title By ID
	function get_title_id($code, $tbl){
		$ci = &get_instance();
		return $ci->db->select('title')->where('id', $code)->get($tbl)->row('title');
	}

	//Get correction_tamplate
	function correction_tamp($id = false){
		$ci = &get_instance();
		if($id)
			return $ci->db->select('title')->where('id', $id)->get('correction_template')->row('title');
		else
			return $ci->db->select('id as code, title')->where('status', 0)->get('correction_template')->result();
	}

	function get_invoice_number($id){
		$ci = &get_instance();
		$res = $ci->db->where('order_id', $id)->get('invoice');
		if($res->num_rows() > 0){
			return $res->row()->invoice_number;
		}
	}

	function get_parent_doc($id){
		$ci = &get_instance();
		return $ci->db->where('code', $id)->get('parent_client')->row()->title;
	}

	function get_primary_doc($id, $_is = false){
		$ci = &get_instance();
		if($_is)
			return $ci->db->select('is_primary, name, id')->where(['client_id' => $id, 'is_primary' => 1])->get('subdoctors')->row();

		return $ci->db->select('is_primary, name, id')->where(['client_id' => $id])->get('subdoctors')->result();
	}

	function get_emp_name($code, $tbl){
		$ci = &get_instance();
		if($code == 'admin' || $code == 'vinod')
			return ucfirst($code);
		return $ci->db->select('CONCAT(firstname, " ", lastname) as name')->where('code', $code)->get($tbl)->row('name');
	}

	//Get Order Products By OrderID
	function get_order_products($id){
		$ci = &get_instance();
		return $ci->db->where('order_id', $id)->get('order_products')->result();
	}

	//Get Order Products By OrderID
	function get_order_product($id){
		$ci = &get_instance();
		$res = $ci->db->select('p.title, o.unit')->from('order_products as o')->join('product as p', 'p.code = o.product_id', 'inner')->where('o.order_id', $id)->get()->result();
		
		$html = '';
		$len = sizeof($res);
		$i=1;
		foreach ($res as $r){
			if($len == $i++)
				$html .= $r->title.' - '.$r->unit;
			else
				$html .= $r->title.' - '.$r->unit.',';
		}
		return $html;
	}

	function get_order_total($id){
		$ci = &get_instance();
		return $ci->db->select('order_value as amount')->where('id', $id)->get('orders')->row()->amount;
		// return $ci->db->select('SUM(total_amount) as amount')->where('order_id', $id)->get('order_products')->row()->amount;
	}

	function get_order_type($id){
		$ci = &get_instance();
		return $ci->db->select('work_type as type')->where('id', $id)->get('orders')->row()->type;
		// return $ci->db->select('SUM(total_amount) as amount')->where('order_id', $id)->get('order_products')->row()->amount;
	}

	//Get Order Shedules By OrderID
	function get_order_shadules($id){
		$ci = &get_instance();
		return $ci->db->where('order_id', $id)->get('order_schadules')->result();
	}

	/***
	* Capping Amount By Client ID
	*/
	function get_cap_amt($id){
		$ci = &get_instance();
		$res = $ci->db->select('capping_value, capping_limit')->where('id', $id)->get('clients')->row();
		return ($res->capping_value - $res->capping_limit);
	}
	
	function get_cap_value($id){
		$ci = &get_instance();
		$res = $ci->db->select('capping_value')->where('id', $id)->get('clients')->row();
		return $res->capping_value;
	}

	/***
	* Check Is Invoice is valid or not
	*/
	function check_invoice_valid($id){
		$ci = &get_instance();
		return $ci->db->where('invoice_number', $id)->get('invoice')->num_rows();
	}

	/***
	* Genrate uinque case no
	*/
	function case_no(){
	    $ci = &get_instance();
		$no = $ci->db->select('id')->order_by('id', 'desc')->get('orders')->row('id');
		return date('ym').($no+1);
	}
	
	/***
	* check case no
	*/
	function check_modal_no($case_no){
	    $ci = &get_instance();
	    $res = $ci->db->where('modal_no', $case_no)->get('orders')->num_rows();
	    if($res > 0){
	        $no = $ci->db->select('id')->order_by('id', 'desc')->get('orders')->row('id');
		    return date('ym').($no+1);   
	    }else{
	        return $case_no;
	    }
	}
	
// 	get_jobs_count
// get_jobs_units
// get_total_sales
	
    /***
    * Get Orders Count By Client and Month
    * */
	function get_jobs_count($client, $month, $year = false){
		$year = (isset($year))?$year:date('Y');
        $ci = &get_instance();
        return $ci->db->select('COUNT(order_number) as total')->where(['client_id' => $client, 'MONTH(invoice_date)' => $month, 'YEAR(invoice_date)' => $year])->get('invoice')->row('total');
	}
	
		/***
    * Get Units Count By Client and Month
    * */
	function get_jobs_units($client, $month, $year = false){
		$year = (isset($year))?$year:date('Y');
        $ci = &get_instance();
        $data = $ci->db->select('units')->where(['client_id' => $client, 'MONTH(invoice_date)' => $month, 'YEAR(invoice_date)' => $year])->group_by('invoice_number')->get('invoice')->result();

        $t = 0;
        foreach ($data as $d) {
        	$t += $d->units;
        }
        return $t;
	}
	
	/***
    * Get Total Salses Amount By Client and Month
    * */
	function get_total_sales_by_month($client, $month, $year = false){
		$year = (isset($year))?$year:date('Y');
        $ci = &get_instance();
        $data = $ci->db->select('invoice_total')->where(['client_id' => $client, 'MONTH(invoice_date)' => $month, 'YEAR(invoice_date)' => $year])->group_by('invoice_number')->get('invoice')->result();
        $t = 0;
        foreach ($data as $d) {
        	$t += $d->invoice_total;
        }
        return $t;
	}

	/**
	* Zone wise sales by challan
	*/

		/**
	    * Get Orders Count By Client and Month
	    */
		function challan_get_jobs_count($client, $month, $year = false){
			$year = (isset($year))?$year:date('Y');
	        $ci = &get_instance();
	        return $ci->db->select('COUNT(order_number) as total')->where(['client_code' => $client, 'MONTH(order_date)' => $month])->get('orders')->row('total');
		}
		
		/**
	    * Get Units Count By Client and Month
	    * */
		function challan_get_jobs_units($client, $month, $year = false){
			$year = (isset($year))?$year:date('Y');
	        $ci = &get_instance();
	        $data = $ci->db->select('units')->where(['client_code' => $client, 'MONTH(order_date)' => $month])->group_by('order_number')->get('orders')->result();

	        $t = 0;
	        foreach ($data as $d) {
	        	$t += $d->units;
	        }
	        return $t;
		}
		
		/**
	    * Get Total Salses Amount By Client and Month
	    */
		function challan_get_total_sales_by_month($client, $month, $year = false){
			$year = (isset($year))?$year:date('Y');
	        $ci = &get_instance();
	        $data = $ci->db->select('order_value as invoice_total')->where(['client_code' => $client, 'MONTH(order_date)' => $month])->group_by('order_number')->get('orders')->result();
	        $t = 0;
	        foreach ($data as $d) {
	        	$t += $d->invoice_total;
	        }
	        return $t;
		}


		function challan_data($client, $month, $year = false){
			$year = (isset($year))?$year:date('Y');
	        $ci = &get_instance();

	        // $challans = $ci->db->where(['MONTH(shipment_date)' => $month, 'YEAR(shipment_date)' => $year])->get('shipments')->result();

	        $res = $ci->db->select('COUNT(o.order_number) as total, SUM(o.order_value) as invoice_total, SUM(o.units) as units')->where(['o.client_code' => $client, 'MONTH(o.order_date)' => $month, 'YEAR(o.order_date)' => $year])->where('o.order_number IN (select order_id from rpd_shipments)',NULL,FALSE)->get('orders as o')->row();
			
			// $res = $ci->db->select('COUNT(o.order_number) as total, SUM(o.order_value) as invoice_total, SUM(o.units) as units')->from('orders as o')->join('shipments as s', 's.order_id = o.order_number', 'inner')->where()->get()->row();


			return ['totle' => $res->total, 'amt' => $res->invoice_total, 'units' => $res->units];
		}

	/**
	* End FUncitons
	*/

	function trails_process($id = false){
		$data = [["id"=>1, "value" =>"Wax Trial"],
		["id"=>2, "value" =>"Metal Trial"],
		["id"=>3, "value" =>"Coping Trial"],
		["id"=>4, "value" =>"Bisque Trial"],
		["id"=>5, "value" =>"Jig Trial"],
		["id"=>6, "value" =>"Final"],
		["id"=>7, "value" =>"Setting Trial"],
		["id"=>8, "value" =>"Special Trial"],
		["id"=>9, "value" =>"Bite Trial"]];
		
		if($id){
			foreach ($data as $key) {
				if($key['id'] == $id)
					return $key['value'];
			}
		}else{
			return $data;
		}
	}

	function stages(){
		return [
			['id'=>1, 'value'=>'Model'],
			['id'=>2, 'value'=>'Waxup'],
			['id'=>3, 'value'=>'Metal'],
			['id'=>4, 'value'=>'Ceramic'],
			['id'=>5, 'value'=>'Cast Partial'],
			['id'=>6, 'value'=>'Denture'],
			['id'=>7, 'value'=>'Misc']
		];
	}
	

	function get_shade($code){
		$ci = &get_instance();
		return $ci->db->where('code', $code)->get('rpd_shade')->row('title');
	}
	
	function get_lab_slip_status($order_number){
		$ci = &get_instance();
		return $ci->db->where('order_number', $order_number)->get('labslips')->row('is_return');
	}