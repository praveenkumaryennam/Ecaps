<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Reports_m extends CI_Model {
	function __constuct(){
		parent::__constuct();
	}

	function getpayments($arr){
		$this->db->from('payments');
		
		if($arr['fromdate'] != "" && $arr['todate'] != ""){
			$this->db->where('payment_date >=', $arr['fromdate']);
			$this->db->where('payment_date <=', $arr['todate']);
		}
		if($arr['client'] != "")
			$this->db->where('client_code', $arr['client']);
		if($arr['mode'] != "")
			$this->db->where('payment_mode', $arr['mode']);
		if($arr['order_number'] != ""){
			if(strpos($arr['order_number'], 'IN') !== false)
				$this->db->where('invoice_number', $arr['order_number']);
			
			if(strpos($arr['order_number'], 'O') !== false)
				$this->db->where('order_id', $arr['order_number']);
		}
		return $this->db->get()->result();
	}

	/**
	* Get All Orders
	*/
	function getorders($arr){
        $this->db->select('o.client_code AS client_code,o.order_number AS order_number,o.modal_no AS modal_no,o.order_status AS order_status,o.patiant_name AS patiant_name,o.id AS id,o.order_date AS date, o.due_date AS duedate, o.duetime, o.note AS note,o.work_type AS work_type,c.parent, c.clientname AS clientname,o.order_value AS ototal,o.units AS ounits,o.is_invoice AS is_invoice,o.is_challan AS is_challan,c.code AS code,o.status AS status')->from('orders as o');
		$this->db->join('clients as c', 'c.id  = o.client_code', 'inner');
		
		if($arr['fromdate'] != "" && $arr['todate'] != ""){
			$this->db->where('DATE(o.order_date) >=', $arr['fromdate']);
			$this->db->where('DATE(o.order_date) <=', $arr['todate']);
		}
		if($arr['client'] != ""){
			$this->db->where('c.code', $arr['client']);
		}
		if($arr['pcat'] != "" || $arr['ptype'] != "" || $arr['product'] != ""){
			$this->db->join('order_products as op', 'op.order_id = o.id', 'inner');
		}
		if($arr['pcat'] != ""){
			$this->db->where('op.product_category', $arr['pcat']);
		}
		if($arr['ptype'] != ""){
			$this->db->where('op.product_type', $arr['pcat']);
		}
		if($arr['product'] != ""){
			$this->db->where('op.product_id', $arr['pcat']);
		}

		return $this->db->where('o.status', 0)->get()->result();
	}
	
	function get_order_query($arr){
	    $qry = "select `o`.`client_code` AS `client_code`,
        `o`.`order_number` AS `order_number`,
        `o`.`modal_no` AS `modal_no`,
        `o`.`order_status` AS `order_status`,
        `o`.`patiant_name` AS `patiant_name`,
        `o`.`id` AS `id`,
        `o`.`order_date` AS `date`,
        `o`.`note` AS `note`,
        `c`.`clientname` AS `clientname`,
        (select sum(`rpd_order_products`.`total_amount`) from `rpd_order_products` where `rpd_order_products`.`order_id` = `o`.`id`) AS `ototal`,
        (select sum(`rpd_order_products`.`unit`) from `rpd_order_products` where `rpd_order_products`.`order_id` = `o`.`id`) AS `ounits`,
        `o`.`is_invoice` AS `is_invoice`,
        `o`.`is_challan` AS `is_challan`,
        `c`.`code` AS `code`,
        `op`.`product_category` AS `product_category`,
        `op`.`product_type` AS `product_type`,
        `op`.`product_id` AS `product_id`,
        `o`.`status` AS `status` from ((`rpd_orders` `o` join `rpd_clients` `c` on(`c`.`id` = `o`.`client_code` or `c`.`code` = `o`.`client_code`)) join `rpd_order_products` `op` on(`op`.`order_id` = `o`.`id`))
        where `o`.`status` = 0 ";
        
        if($arr['fromdate'] != "" && $arr['todate'] != ""){
        	$qry .= "DATE(date) >= ".$arr['fromdate']; 
        	$qry .= "DATE(date) <= ".$arr['todate'];
        }
        
        if($arr['client'] != ""){
        	$qry .= 'code = '.$arr['client'];
        }
        
        if($arr['pcat'] != ""){
        	$qry .= 'product_category = '. $arr['pcat'];
        }
        
        if($arr['ptype'] != ""){
        	$qry .= 'product_type = '. $arr['pcat'];
        }
        
        if($arr['product'] != ""){
        	$qry .= 'product_id = '. $arr['pcat'];
        }
        
        $qry .= "group by `o`.`order_number`";
        return $qry;
	}
	
	/**
	* Get All Redo Orders
	*/
	function getredoorders($arr){
		if($arr['fromdate'] != "" && $arr['todate'] != ""){
			$this->db->where('DATE(date) >=', $arr['fromdate']);
			$this->db->where('DATE(date) <=', $arr['todate']);
		}
		if($arr['client'] != ""){
			$this->db->where('code', $arr['client']);
		}
		
		if($arr['pcat'] != ""){
			$this->db->where('product_category', $arr['pcat']);
		}
		if($arr['ptype'] != ""){
			$this->db->where('product_type', $arr['pcat']);
		}
		if($arr['product'] != ""){
			$this->db->where('product_id', $arr['pcat']);
		}
		return $this->db->where(['status' => 0, 'work_type' => 'redo'])->group_by('order_number')->get('order_report')->result();
	}

	/**
	* Get All Currection Orders
	*/
	function getcurrectionorders($arr){
		if($arr['fromdate'] != "" && $arr['todate'] != ""){
			$this->db->where('DATE(date) >=', $arr['fromdate']);
			$this->db->where('DATE(date) <=', $arr['todate']);
		}
		if($arr['client'] != ""){
			$this->db->where('code', $arr['client']);
		}
		
		if($arr['pcat'] != ""){
			$this->db->where('product_category', $arr['pcat']);
		}
		if($arr['ptype'] != ""){
			$this->db->where('product_type', $arr['pcat']);
		}
		if($arr['product'] != ""){
			$this->db->where('product_id', $arr['pcat']);
		}
		return $this->db->where(['status' => 0, 'work_type' => 'correction'])->group_by('order_number')->get('order_report')->result();
	}
    
    /**
    * Get All Invoices
    */
    function getinvoices($arr){
		$this->db->select('i.* , c.clientname, c.parent')
		->from('invoice as i')
		->join('clients as c', 'c.id = i.client_id', 'inner');

		if($arr['fromdate'] != "" && $arr['todate'] != ""){
			$this->db->where('DATE(i.invoice_date) >=', $arr['fromdate']);
			$this->db->where('DATE(i.invoice_date) <=', $arr['todate']);
		}
		if($arr['client'] != ""){
			$this->db->where('c.code',$arr['client'])->or_where('c.id',$arr['client']);
		}
		if($arr['pcat'] != "" || $arr['ptype'] != "" || $arr['product'] != ""){
			$this->db->join('invoice_product as op', 'op.order_id = i.order_id', 'inner');
			
			if($arr['pcat'] != ""){
				$this->db->where('op.productcategory', $arr['pcat']);
			}
			if($arr['ptype'] != ""){
				$this->db->where('op.producttype', $arr['pcat']);
			}
			if($arr['product'] != ""){
				$this->db->where('op.product', $arr['pcat']);
			}
		}


		return $this->db->where(['i.type' =>  'new', 'i.status' => 0])->group_by('i.invoice_number')->get()->result();
	}
	
	function productivitylog($id = false){
		if($id){
			$data = $this->getdata($id);	
		}else{
			$res = $this->db->select('username')->get('users')->result_array();
			array_push($res, ['username' => 'admin']);
			arsort($res);
			foreach($res as $u){
				$data[$u['username']] = $this->getdata($u['username']);	
			}
		}
		return $data;
	}

	//productivitydata By Individual
	private function getdata($id){
		$data['ftd']['orders'] = $this->db->where(['DATE(order_date)' => date('Y-m-d'), 'added_by' => $id])->get('orders')->num_rows();
		$data['ftd']['invoice'] = $this->db->where(['DATE(invoice_date)' => date('Y-m-d'), 'added_by' => $id])->get('invoice')->num_rows();
		$data['ftd']['challans'] = $this->db->where(['DATE(shipment_date)' => date('Y-m-d'), 'added_by' => $id])->get('shipments')->num_rows();
		$data['mtd']['orders'] = $this->db->where('DATE(order_date) >= ', date('Y-m-01'))->where('DATE(order_date) <= ', date('Y-m-d'))->where('added_by', $id)->get('orders')->num_rows();
		$data['mtd']['invoice'] = $this->db->where('DATE(invoice_date) >= ', date('Y-m-01'))->where('DATE(invoice_date) <= ', date('Y-m-d'))->where('added_by', $id)->get('invoice')->num_rows();
		$data['mtd']['challans'] = $this->db->where('DATE(shipment_date) >= ', date('Y-m-01'))->where('DATE(shipment_date) <= ', date('Y-m-d'))->where('added_by', $id)->get('shipments')->num_rows();
		$data['ytd']['orders'] = $this->db->where('DATE(order_date) >= ', date('Y-01-01'))->where('DATE(order_date) <= ', date('Y-m-d'))->where('added_by', $id)->get('orders')->num_rows();
		$data['ytd']['invoice'] = $this->db->where('DATE(invoice_date) >= ', date('Y-01-01'))->where('DATE(invoice_date) <= ', date('Y-m-d'))->where('added_by', $id)->get('invoice')->num_rows();
		$data['ytd']['challans'] = $this->db->where('DATE(shipment_date) >= ', date('Y-01-01'))->where('DATE(shipment_date) <= ', date('Y-m-d'))->where('added_by', $id)->get('shipments')->num_rows();
		return $data;
	}
	
	//monthlyproductivitydata
	function get_monthlyproductivitydata($m){
		$users = $this->db->select('empid as username')->where(['status' => 0, 'role' => 'emp'])->get('users')->result_array();
		array_push($users, ['username' => 'admin']);
		$data = [];
		foreach($users as $u){
			$days = cal_days_in_month(CAL_GREGORIAN,$m,date('Y'));
			for($i=1; $i<=$days;$i++){
				$date = date('Y-'.$m.'-'.$i);
				$res = $this->db->select("id")->from('orders as o')->where('Date(o.order_date)', $date)->where('o.added_by', $u['username'])->get()->result();
				$data[$u['username']][$date]['jobs'] = sizeof($res);
				$data[$u['username']][$date]['units'] = $this->get_units($res);
			}
		}
		return $data;
	}

	function get_units($data){
		$date = 0;
		foreach($data as $d){
			$res = $this->db->select('sum(unit) as unit')->where('order_id', $d->id)->get('order_products')->row();
			$date += $res->unit;
		}
		return $date;
	}

	/***
	* City Wise Data Report
	*/
	function citywiseclients($col = false, $id = false, $datatable = false, $column_search = false, $_is = false, $_exp = false){
		$this->db->select('c.*, s.station')->from('clients as c, stations as s')->where('c.station = s.id')->where('c.'.$col, $id);
	    if(!empty($datatable['search']['value'])){
			$i = 0;
			foreach($column_search as $item){
	            if($datatable['search']['value']){
	                if($i === 0){
	                    $this->db->group_start();
	                    $this->db->like('c.'.$item, $datatable['search']['value']);
	                }else{
	                    $this->db->or_like('c.'.$item, $datatable['search']['value']);
	                }
	                
	                if(count($column_search) - 1 == $i){
	                    $this->db->group_end();
	                }
	            }
	            $i++;
	        }
	        if($_is == false)
		        return $this->db->limit($datatable['length'], $datatable['start'])->order_by('c.id', 'desc')->get()->result();
		    return $this->db->get()->num_rows();
		}else{
			if($_is == false){
				if($_exp == true)
		        	return $this->db->order_by('c.id', 'desc')->get()->result();
				else	        
			        return $this->db->limit($datatable['length'], $datatable['start'])->order_by('c.id', 'desc')->get()->result();
			}
		    return $this->db->get()->num_rows();
		}
	}

	/***
	* Zone Wise Data Report
	*/
	function zonewiseclients($zone = false, $datatable = false, $_is = false, $_exp = false){
		if($zone == 'all'){
			$res = $this->db->get('zones')->result();
			$this->db->distinct()->select('c.*')->from('clients as c');
			$j = 0;

			$temp = [];
			foreach ($res as $r) {
				foreach (json_decode($r->stations) as $key => $value) {
					$temp[] = $value;
				}
			}

			$coun = count($temp);
			foreach ($temp as $a => $s){
				$this->db->or_where('c.station', $s);
			}
		}else{
			$res = $this->db->where('id', $zone)->get('zones')->row();
			$this->db->distinct()->select('c.*')->from('clients as c');
			$j = 0;
			$coun = count(json_decode($res->stations));
			foreach (json_decode($res->stations) as $s){
				$this->db->or_where('c.station', $s);
			}
		}

	    if(!empty($datatable['search']['value'])){
			$i = 0;
			foreach($column_search as $item){
	            if($datatable['search']['value']){
	                if($i === 0){
	                    $this->db->group_start();
	                    $this->db->like('c.'.$item, $datatable['search']['value']);
	                }else{
	                    $this->db->or_like('c.'.$item, $datatable['search']['value']);
	                }
	                
	                if(count($column_search) - 1 == $i){
	                    $this->db->group_end();
	                }
	            }
	            $i++;
	        }
	        if($_is == false)
		        return $this->db->limit($datatable['length'], $datatable['start'])->group_by('c.id')->order_by('c.id', 'desc')->get()->result();
		    return $this->db->group_by('c.id')->get()->num_rows();
		}else{
			if($_is == false){
				if($_exp == true)
			        return $this->db->group_by('c.id')->order_by('c.id', 'desc')->get()->result();
			    else
			        return $this->db->limit($datatable['length'], $datatable['start'])->group_by('c.id')->order_by('c.id', 'desc')->get()->result();
			}
		    return $this->db->group_by('c.id')->get()->num_rows();
		}
	}

	/***
	* Source By Clients
	*/
	function sourcewisereport($source = false, $dates = false){
		$this->db->select('s.clientname, s.code, s.mobile, s.email, s.dob, s.whatsappno, s.referby, c.title');
		$this->db->from('clients as s')->join('source as c', 'c.id = s.source', 'inner');
		if($source)
			$this->db->where('s.source', $source);
		if(!empty($dates))
			$this->db->where(['s.added_at >= ' => $dates[0], 's.added_at <= ' => $dates[1]]);
		return $this->db->get()->result();
	}
	
	/**
	* Daily Analyse F,M,Y TD Report
	*/
	function daily_analyse_report($arr){
		$wqry = '';
		if($arr['zone']){
			$zone = $this->db->select('stations')->where('id', $arr['zone'])->get('zones')->row('stations');
			foreach (json_decode($zone) as $z){
				$wqry = $this->db->or_where('c.station', $z);
			}
		}
		$this->db->select('c.id, c.code, c.clientname, c.station')->from('clients as c')->join('orders as o', 'o.client_code = c.id', 'inner');
		if($arr['client'])
			$this->db->where('c.code', $arr['client']);
		if($arr['country']){
			$this->db->where('c.country', $arr['country']);
		}
		if($arr['state']){
			$this->db->where('c.state', $arr['state']);
		}
		if($arr['city']){
			$this->db->where('c.city', $arr['city']);
		}
		if($arr['zone']){
			$wqry;
		}
		
		if($arr['station']){
			$this->db->where('c.station', $arr['station']);
		}
		$res  = $this->db->get()->result();
		
		$data = [];
		foreach ($res as $r) {
			$data[$r->id] = $this->daily_analyse_report_data($arr, $r);
		}
		return $data;
	}

	/**
	* Monthly Analyse M,Y TD Report
	*/
	function monthly_analyse_report($arr){
		$wqry = '';
		if(empty($arr['zone_stations'])){
			if($arr['zone']){
				$zone = $this->db->select('stations')->where('id', $arr['zone'])->get('zones')->row('stations');
				foreach (json_decode($zone) as $z){
					$wqry = $this->db->or_where('c.station', $z);
				}
			}
		}
		
		$this->db->select('c.id, c.code, c.clientname, c.station')->from('clients as c')->join('orders as o', 'o.client_code = c.id', 'inner');
		
		if($arr['client'])
			$this->db->where('c.code', $arr['client']);

		if($arr['country']){
			$this->db->where('c.country', $arr['country']);
		}
		if($arr['state']){
			$this->db->where('c.state', $arr['state']);
		}
		if($arr['city']){
			$this->db->where('c.city', $arr['city']);
		}

		if($arr['zone']){
			$wqry;
		}
		
		if($arr['station']){
			$this->db->where('c.station', $arr['station']);
		}

		if($arr['zone_stations']){
			$this->db->where('c.station', $arr['zone_stations']);
		}

		$res  = $this->db->get()->result();
		
		$data = [];
		foreach ($res as $r) {
			$data[$r->id] = $this->monthly_analyse_report_data($arr, $r);
		}
		
		return $data;
	}

	//productivitydata By Individual
	private function monthly_analyse_report_data($arr, $client){
		if($arr['rtype'] == 1){
			if($arr['worktype'])
				$filter['work_type'] = $arr['worktype'];

			$filter['client_code'] = $client->id;
		}
		if($arr['rtype'] == 2){
			if($arr['worktype'])
				$filter['type'] = $arr['worktype'];

			$filter['client_id'] = $client->id;
		}
		if($arr['rtype'] == 3){
			if($arr['worktype'])
				$filter['work_type'] = $arr['worktype'];
			$filter['client_code'] = $client->id;
		}

		
		$data['name'] = $client->clientname;
		$data['code'] = $client->code;
		$data['station'] = $client->station;
		$data['mtd'] = $this->final_query(2, $filter, $arr, true);
		$data['ytd'] = $this->final_query(3, $filter, $arr, true);
		return $data;
	}	

	/**
	* Staion Monthly Analyse
	*/
	function stations_analyse_report($arr){
		$wqry = '';
		if($arr['zone']){
			$zone = $this->db->select('stations')->where('id', $arr['zone'])->get('zones')->row('stations');
			foreach (json_decode($zone) as $z){
				$wqry = $this->db->or_where('c.station', $z);
			}
		}
		
		$this->db->select('c.id, s.id as station_id, c.station, s.city')
		->from('clients as c')
		->join('orders as o', 'o.client_code = c.id', 'inner')
		->join('stations as s', 's.id = c.station', 'inner');
		
		if($arr['client'])
			$this->db->where('c.code', $arr['client']);

		if($arr['country']){
			$this->db->where('s.country', $arr['country']);
		}
		if($arr['state']){
			$this->db->where('s.state', $arr['state']);
		}
		if($arr['city']){
			$this->db->where('s.city', $arr['city']);
		}

		if($arr['zone']){
			$wqry;
		}

		$res  = $this->db->order_by('c.station')->get()->result();

		$data = [];
		foreach ($res as $r) {
			$resa = $this->stations_analyse_report_data($arr, $r);
			$data[] = ['station' => $r->station_id, 'data' => $resa];
		}

		$temp = [];
		foreach ($data as $r) {
			$temp[$r['station']][$r['data']['client']] = $r['data'];
		}

		$final  = [];
		foreach ($temp as $f => $v) {
			$final[$f] = [];
			$final[$f]['mtd']['jobs'] = 0;
			$final[$f]['mtd']['units'] = 0;
			$final[$f]['mtd']['amount'] = 0;
			$final[$f]['ytd']['jobs'] = 0;
			$final[$f]['ytd']['units'] = 0;
			$final[$f]['ytd']['amount'] = 0;
			foreach ($v as $a) {
				$final[$f]['station'] = $a['station'];
				$final[$f]['city'] = $a['city'];
				$final[$f]['mtd']['jobs'] += $a['mtd']['jobs'];
				$final[$f]['mtd']['units'] += $a['mtd']['units'];
				$final[$f]['mtd']['amount'] += $a['mtd']['amount'];
				$final[$f]['ytd']['jobs'] += $a['ytd']['jobs'];
				$final[$f]['ytd']['units'] += $a['ytd']['units'];
				$final[$f]['ytd']['amount'] += $a['ytd']['amount'];
			}
		}
		return $final;
	}

	//productivitydata By Individual
	private function stations_analyse_report_data($arr, $client){

		if($arr['rtype'] == 1){
			if($arr['worktype'])
				$filter['work_type'] = $arr['worktype'];

			$filter['client_code'] = $client->id;
		}
		if($arr['rtype'] == 2){
			if($arr['worktype'])
				$filter['type'] = $arr['worktype'];

			$filter['client_id'] = $client->id;
		}
		if($arr['rtype'] == 3){
			if($arr['worktype'])
				$filter['work_type'] = $arr['worktype'];
			$filter['client_code'] = $client->id;
		}

		
		$data['client'] = $client->id;
		$data['station'] = $client->station;
		$data['city'] = $client->city;
		$data['station'] = $client->station;
		$data['mtd'] = (array)$this->final_query(2, $filter, $arr, true);
		$data['ytd'] = (array)$this->final_query(3, $filter, $arr, true);
		return $data;
	}

	/**
	* Product Analyze Report
	*/
	function product_analyse_report($arr){
		$wqry = '';
		if($arr['zone']){
			$zone = $this->db->select('stations')->where('id', $arr['zone'])->get('zones')->row('stations');
			foreach (json_decode($zone) as $z){
				$wqry = $this->db->or_where('c.station', $z);
			}
		}

		$this->db->select('p.id, p.code, p.title as product')->from('product as p')
		->join('order_products as op', 'op.product_id = p.code', 'inner')
		->join('orders as o', 'o.id = op.order_id', 'inner')
		->join('clients as c', 'o.client_code = c.id', 'inner')
		->join('states as s', 's.id = c.state', 'inner');
		
		if($arr['product'])
			$this->db->where('p.code', $arr['product']);
		
		if($arr['country']){
			$this->db->where('c.country', $arr['country']);
		}
		
		if($arr['state']){
			$this->db->where('c.state', $arr['state']);
		}
		
		if($arr['city']){
			$this->db->where('c.city', $arr['city']);
		}
		
		if($arr['zone']){
			$wqry;
		}
		
		if($arr['station']){
			$this->db->where('c.station', $arr['station']);
		}
		
		$res  = $this->db->get()->result();
		
		$data = [];
		foreach ($res as $r) {
			$data[$r->id] = $this->product_analyse_report_data($arr, $r);
		}
		return $data;	
	}

	//productivitydata By Individual
	private function product_analyse_report_data($arr, $product){
		
		if($arr['worktype']){
			$filter['work_type'] = $arr['worktype'];
		}
		
		$filter['p.id'] = $product->id;
		$data['product'] = $product->product;
		$data['code'] = $product->code;
		$data['ftd'] = $this->product_final_query(1, $filter, $arr['date']);
		$data['mtd'] = $this->product_final_query(2, $filter, $arr['date']);
		$data['ytd'] = $this->product_final_query(3, $filter, $arr['date']);
		return $data;
	}

	private function product_final_query($type, $qry, $date){
		switch ($type) {
			case 1:
				return $this->db->select('count(op.id) as jobs, sum(op.unit) as units, sum(op.total_amount) as amount')
				->from('orders as o')
				->join('order_products as op', 'op.order_id = o.id', 'inner')
				->join('product as p', 'p.code = op.product_id', 'inner')
				->where($qry)
				->where('DATE(o.order_date)', $date)
				->get()->row();
				break;
			case 2:
				return $this->db->select('count(op.id) as jobs, sum(op.unit) as units, sum(op.total_amount) as amount')
				->from('orders as o')
				->join('order_products as op', 'op.order_id = o.id', 'inner')
				->join('product as p', 'p.code = op.product_id', 'inner')
				->where($qry)
				->where('DATE(o.order_date) >= ', date('Y-m-01', strtotime($date)))->where('DATE(o.order_date) <= ', date('Y-m-d', strtotime($date)))->get()->row();
				break;
			case 3:
				return $this->db->select('count(op.id) as jobs, sum(op.unit) as units, sum(op.total_amount) as amount')
				->from('orders as o')
				->join('order_products as op', 'op.order_id = o.id', 'inner')
				->join('product as p', 'p.code = op.product_id', 'inner')
				->where($qry)
				->where('DATE(o.order_date) >= ', date('Y-01-01', strtotime($date)))->where('DATE(o.order_date) <= ', date('Y-m-d', strtotime($date)))
				->get()->row();
				break;
		}
	}

	/**
	* Ranking Report
	*/
	function ranking_analyse_report($arr){
		$wqry = '';
		if($arr['zone']){
			$zone = $this->db->select('stations')->where('id', $arr['zone'])->get('zones')->row('stations');
			foreach (json_decode($zone) as $z){
				$wqry = $this->db->or_where('c.station', $z);
			}
		}

		$this->db->select('c.id, c.code, c.clientname')->from('orders as o')
		->join('clients as c', 'o.client_code = c.id', 'inner');
		
		if($arr['client'])
			$this->db->where('p.code', $arr['client']);
		if($arr['country']){
			$this->db->where('c.country', $arr['country']);
		}
		if($arr['state']){
			$this->db->where('c.state', $arr['state']);
		}
		if($arr['city']){
			$this->db->where('c.city', $arr['city']);
		}
		if($arr['zone']){
			$wqry;
		}
		
		if($arr['station']){
			$this->db->where('c.station', $arr['station']);
		}
		$res  = $this->db->group_by('c.code')->get()->result();
		
		$data = [];
		foreach ($res as $r) {
			$data[] = $this->ranking_analyse_report_data($arr, $r);
		}
		return $data;		
	}

	function ranking_analyse_report_data($arr, $client){
		$filter['o.client_code'] = $client->id;
		$data['client'] = $client->clientname;
		$data['code'] = $client->code;

		$data['mtd'] = $this->ranking_final_query(2, $filter, $arr['date']);
		$data['ytd'] = $this->ranking_final_query(3, $filter, $arr['date']);
		return $data;
	}

	private function ranking_final_query($type, $qry, $date){
		switch ($type) {
			case 1:
				return $this->db->select('sum(o.order_value) as amount')
				->from('orders as o')
				->where($qry)
				->where('DATE(o.order_date)', $date)
				->get()->row();
				break;
			case 2:
				return $this->db->select('sum(o.order_value) as amount')
				->from('orders as o')
				->where($qry)
				->where('DATE(o.order_date) >= ', date('Y-m-01', strtotime($date)))->where('DATE(o.order_date) <= ', date('Y-m-d', strtotime($date)))->get()->row();
				break;
			case 3:
				return $this->db->select('sum(o.order_value) as amount')
				->from('orders as o')
				->where($qry)
				->where('DATE(o.order_date) >= ', date('Y-01-01', strtotime($date)))->where('DATE(o.order_date) <= ', date('Y-m-d', strtotime($date)))
				->get()->row();
				break;
		}
	}

	/**
	*Lap Slip
	*/
	function getlabsliporders($arr){
		$this->db->select('o.*')->from('order_report as o, labslips as l')->where(['i.order_number = o.order_number']);
		
		if($arr['fromdate'] != "" && $arr['todate'] != ""){
			$this->db->where('DATE(o.date) >=', $arr['fromdate']);
			$this->db->where('DATE(o.date) <=', $arr['todate']);
		}

		if($arr['client'] != ""){
			$this->db->where('o.code', $arr['client']);
		}

		return $this->db->where(['o.status' => 0])->group_by('o.order_number')->get()->result();
	}

	/**
	* get_archive_targets
	*/
	function get_archive_targets($designation, $month){
		$res = $this->db->select('id, CONCAT(firstname, " ", lastname) as name, code')->where('designation', $designation)->get('employee')->result();

		$data = [];
		foreach ($res as $key){
			$t = $this->targets_data($key->id, $month);
			$process_data = $this->all_units_process($key->code, $month);

			$data[] = [
				'id' => $key->id,
				'name' => $key->name,
				'code' => $key->code,
				'month' => $t->month,
				'utarget' => $t->target,
				'ctarget' => $t->casetarget,

				'uincentive' => $t->incentive,
				'cincentive' => $t->caseincentive,

				'cases' => $process_data['cases'],
				'units' => $process_data['units']
			];
		return $data;
		}
	}

	/**
	* get_archive_targets
	*/
	function get_archive_targets_analyse($designation, $month, $year){
		$res = $this->db->select('id, CONCAT(firstname, " ", lastname) as name, code')->where(['designation' => $designation, 'status' => 0])->get('employee')->result();

		$return_data_set = [];
		foreach ($res as $key){
			$data_set = $this->targets_analyse($key->code, $month, $year);
			
			$pd = [];
			$_is_type = 1;
			foreach ($data_set as $d) {
				$is_type = is_case_type($d->case_id);
				$pd[$d->dep_id][$d->target_id]['target'] = $this->targets_data($d->target_id);
				$pd[$d->dep_id][$d->target_id]['case_id'] += 1 ;

				if($is_type == 'new'){
					$pd[$d->dep_id][$d->target_id]['new']['units'] += $d->units;
				}
				if($is_type == 'correction'){
					$pd[$d->dep_id][$d->target_id]['correction']['units'] += $d->units;
				}
				if($is_type == 'redo'){
					$pd[$d->dep_id][$d->target_id]['redo']['units'] += $d->units;
				}
			}


			$final_data_set = [];
			foreach ($pd as $k => $value) {
				foreach ($value as $a => $b) {
					$final_data_set[$k] = $b;
				} 
			}

			$return_data_set[] = [
				'id' => $key->id,
				'name' => $key->name,
				'code' => $key->code,
				'month' => $month,
				'data' => $final_data_set
			];


		}
		return $return_data_set;
	}

	private function targets_analyse($emp_id, $month, $year){
		$res = $this->db->where(['MONTH(pdate)' => $month, 'YEAR(pdate)' => $year, 'emp_id' => $emp_id])->get('process_analyse')->result();
		return $res;

	}

	private function all_units_process($id, $month){
		$res =  $this->db->where('MONTH(in_datetime)', $month)->where('done_by', $id)->group_by('tryno')->get('process')->result();
		$units = 0;
		$cases = 0;
		foreach ($res as $r) {
			$case = $r->tryno;
			if($r->department == "LDEN"){
				$cases++;
			}else{
				if($r->department != "LDEN")
					$units += $this->db->where('modal_no', $case)->get('orders')->row('units');
			}
		}
		return ["units"=>$units, "cases" => $cases];
	}

	/**
	* Target Data by Month and employee ID
	*/
	private function targets_data($id, $dep = false){
		return $this->db->select('t.target, t.incentive, t.month, t.is_type')->from('employee_target as t')
		->where(['t.id' => $id])
		->get()->row();
	}

	/**
	* daywise_target_arhive
	*/
	function daywise_target_arhive($designation, $month, $year){
		$res = $this->db->select('id, CONCAT(firstname, " ", lastname) as name, code')->where(['designation' => $designation, 'status' => 0])->get('employee')->result();

		$data = [];
		foreach ($res as $key){
			$t = $this->daywise_targets_data($key->id, $month, $year);
			$data[] = [
				'id' => $key->id,
				'name' => $key->name,
				'code' => $key->code,
				'data' => $t
			];
		}
		return $data;
	}

	/**
	* Target Data by days and employee ID
	*/
	private function daywise_targets_data($id, $month, $year){
		return $this->db->select('t.month, a.archived, DATE(a.datetime) as date, demp as dep')->from('employee_target as t')
		->join('target_archive as a', 'a.target_id = t.id', 'right')
		->where(['t.employee_code' => $id, 't.status' => 0])
		->where("DATE(a.datetime) BETWEEN '".date($year.'-'.$month.'-01')."' and '".date($year.'-'.$month.'-t')."'")
		->get()->result();
	}

	/**
	* daywise_target_arhive
	*/
	function monthly_target_arhive($designation, $year){
		$res = $this->db->select('id, CONCAT(firstname, " ", lastname) as name, code')->where(['designation' => $designation, 'status' => 0])->get('employee')->result();

		$data = [];
		foreach ($res as $key){
			$t = $this->monthly_targets_data_new($key->code, $year);
			$data[] = [
				'id' => $key->id,
				'name' => $key->name,
				'code' => $key->code,
				'data' => $t
			];

		}
		return $data;
	}

	/**
	* Target Data by days and employee ID
	*/
	private function monthly_targets_data($id, $month){
		return $this->db->select('t.target, t.incentive, t.month, SUM(a.archived) as archived')->from('employee_target as t')
		->join('target_archive as a', 'a.target_id = t.id', 'left')
		->where(['t.employee_code' => $id, 't.status' => 0])
		->group_by('t.month')
		->get()->result();
	}

	/**
	* Target Data by days and employee ID
	*/
	private function monthly_targets_data_new($id, $year){
		$d = [];
		for($i=1;$i<=12;$i++){
			$data = $this->db->from('process')->where(['done_by' => $id, 'MONTH(out_datetime)' => $i, 'YEAR(out_datetime)' => $year])->get()->result();
			$count = 0;
			foreach ($data as $key) {
				$count += $this->get__units($key->tryno);
			}
			$d[$i] = $count;
		}
		return $d;
	}

	private function get__units($id){
		$a = $this->db->where('modal_no', $id)->get('orders')->row();
		if($a->work_type == 'new'){
			return $a->units;
		}else{
			return 0;
		}
	}

	function day_wise_reports($jobdate){
		$jobs_units = $this->db->select('sum(op.unit) as units, count(o.id) as jobs, sum(op.total_amount) as amt')->from('orders as o')->join('order_products as op', 'op.order_id = o.id', 'inner')->where('DATE(o.due_date)', $jobdate)->get()->row();
		$pending_jobs_units = $this->db->select('sum(op.unit) as units, count(o.id) as jobs, sum(op.total_amount) as amt')->from('orders as o')->join('order_products as op', 'op.order_id = o.id', 'inner')->where('DATE(o.due_date)', $jobdate)->where('o.order_number NOT IN (select order_id from rpd_shipments)',NULL,FALSE)->get()->row();


		$done_jobs_units = $this->db->select('sum(op.unit) as units, count(o.id) as jobs, sum(op.total_amount) as amt')
				->from('orders as o')
				->join('order_products as op', 'op.order_id = o.id', 'inner')
				->where('DATE(o.due_date)', $jobdate)
				->where('o.order_number IN (select order_id from rpd_shipments)',NULL,FALSE)
				->get()->row();
		
		$mtd_jobs_units = $this->db->select('sum(op.unit) as units, count(o.id) as jobs, sum(op.total_amount) as amt')
		->from('orders as o')
		->join('order_products as op', 'op.order_id = o.id', 'inner')
		->where('DATE(o.due_date) >=', date('Y-m-01', strtotime($jobdate)))
		->where('DATE(o.due_date) <=', date('Y-m-d', strtotime($jobdate)))
		->where('o.order_number NOT IN (select order_id from rpd_shipments)',NULL,FALSE)
		->get()->row();

		$ytd_jobs_units = $this->db->select('sum(op.unit) as units, count(o.id) as jobs, sum(op.total_amount) as amt')
		->from('orders as o')
		->join('order_products as op', 'op.order_id = o.id', 'inner')
		->where('DATE(o.due_date) >=', date('Y-01-01'))
		->where('DATE(o.due_date) <=', date('Y-m-d'))
		->where('o.order_number NOT IN (select order_id from rpd_shipments)',NULL,FALSE)
		->get()->row();

		return ['scadule'=>$jobs_units, 'pending' => $pending_jobs_units, 'done' => $done_jobs_units, 'mtd' => $mtd_jobs_units, 'ytd' => $ytd_jobs_units];
	}

	/**
	* Link Analyse F,M,Y TD Report
	*/
	function analyse_report($arr){
		$fdata = [];
		$states = $this->db->get('states')->result();
		foreach ($states as $s) {
			$wqry = '';
			$this->db->select('c.id, c.code, c.clientname, c.station')->from('clients as c')->join('orders as o', 'o.client_code = c.id', 'inner');
			
			if($arr['country'])
				$this->db->where('c.country', $arr['country']);
			
			$this->db->where('c.state', $s->id);
			$res  = $this->db->get()->result();
			
			$data = [];
			foreach ($res as $r) {
				$data[$r->id] = $this->daily_analyse_report_data($arr, $r);
			}
			$fdata[$s->id] = $data;
		}
		return $fdata;
	}

	/**
	* City Analyse F,M,Y TD Report
	*/
	function city_analyse_report($arr, $state){
		$fdata = [];
		$states = $this->db->where('state', $state)->get('cities')->result();
		foreach ($states as $s) {
			$wqry = '';
			$this->db->select('c.id, c.code, c.clientname, c.station')->from('clients as c')->join('orders as o', 'o.client_code = c.id', 'inner');
			
			if($arr['country'])
				$this->db->where('c.country', $arr['country']);
			
			$this->db->where('c.city', $s->id);
			$res  = $this->db->get()->result();
			
			$data = [];
			foreach ($res as $r) {
				$data[$r->id] = $this->daily_analyse_report_data($arr, $r);
			}
			$fdata[$s->id] = $data;
		}
		return $fdata;
	}

	/**
	* Station Analyse F,M,Y TD Report
	*/
	function station_analyse_report($arr, $city){
		$fdata = [];
		$states = $this->db->where('city', $city)->get('stations')->result();
		foreach ($states as $s) {
			$wqry = '';
			$this->db->select('c.id, c.code, c.clientname, c.station')->from('clients as c')->join('orders as o', 'o.client_code = c.id', 'inner');
			
			if($arr['country'])
				$this->db->where('c.country', $arr['country']);
			
			$this->db->where('c.station', $s->id);
			$res  = $this->db->get()->result();
			
			$data = [];
			foreach ($res as $r) {
				$data[$r->id] = $this->daily_analyse_report_data($arr, $r);
			}
			$fdata[$s->id] = $data;
		}
		return $fdata;
	}

	/**
	* Station Analyse F,M,Y TD Report
	*/
	function client_analyse_report($arr, $station){
		$wqry = '';
		$this->db->select('c.id, c.code, c.clientname, c.station, c.city, c.state')->from('clients as c')->join('orders as o', 'o.client_code = c.id', 'inner');
		
		if($arr['country'])
			$this->db->where('c.country', $arr['country']);
		
		$this->db->where('c.station', $station);
		$res  = $this->db->get()->result();
		
		$data = [];
		foreach ($res as $r) {
			$data[$r->id] = $this->daily_analyse_report_data($arr, $r);
		}
		return $data;
	}

	/**
	* Final Report
	*/
	private function final_query($type, $qry, $arr, $_is = fasle){
		$date = $arr['date'];
		
		if($_is === true){
			$m = date('m', strtotime($date));
			$date = date('Y-'.sprintf("%02d", $m).'-01');
			$to_date = date('Y-'.sprintf("%02d", $m).date('-t', strtotime($date)));
		}else{
			$to_date = date('Y-m-t');
			$arr['rtype'] = 1;
		}

		switch ($type) {
			case 1:
				return $this->db->select('count(id) as jobs, sum(units) as units, sum(order_value) as amount')->where($qry)->where('DATE(order_date)', $date)->get('orders')->row();
				break;
			case 2:
				if($arr['rtype'] == 1){
					return $this->db->select('count(id) as jobs, sum(units) as units, sum(order_value) as amount')->where($qry)->where('DATE(order_date) >= ', $date)->where('DATE(order_date) <= ', $to_date)->get('orders')->row();
				}
				if($arr['rtype'] == 2){
					$res = $this->db->where($qry)->group_by('invoice_number')->get('invoice');
					if($res->num_rows() > 1){
						$temp  = [];
						foreach ($res->result() as $r) {
							$temp[] = $this->db->select('count(id) as jobs, units as units, invoice_total as amount')
							->where('invoice_number', $r->invoice_number)
							->where('DATE(invoice_date) >= ', $date)
							->where('DATE(invoice_date) <= ', $to_date)
							->group_by('invoice_number')->get('invoice')->row_array();
						}
						
						$farr['units'] = 0;
						$farr['jobs'] = 0;
						$farr['amount'] = 0;
						foreach ($temp as $f) {
							if(isset($f['jobs'])){
								$farr['units'] += $f['units'];
								$farr['jobs'] += $f['jobs'];
								$farr['amount'] += $f['amount'];
							}
						}

						return (object)$farr;
					}else{
						return $this->db->select('count(id) as jobs, units as units, invoice_total as amount')
						->where($qry)
						->where('DATE(invoice_date) >= ', $date)
						->where('DATE(invoice_date) <= ', $to_date)
						->group_by('invoice_number')->get('invoice')->row();
					}
				}

				if($arr['rtype'] == 3){
					return $this->db->select('count(o.id) as jobs, sum(o.units) as units, sum(o.order_value) as amount')
					->from('shipments as s, orders as o')
					->where('o.order_number = s.order_id')
					->where($qry)
					->where('DATE(s.shipment_date) BETWEEN "'.$date.'" and "'.$to_date.'"')
					->get()->row();
				}
				break;
			case 3:
				if($arr['rtype'] == 1){
					return $this->db->select('count(id) as jobs, sum(units) as units, sum(order_value) as amount')->where($qry)->where('DATE(order_date) >= ', date('Y-01-01', strtotime($date)))->where('DATE(order_date) <= ', date('Y-12-t', strtotime($to_date)))->get('orders')->row();
				}
				if($arr['rtype'] == 2){
					$res = $this->db->where($qry)->group_by('invoice_number')->get('invoice');
					if($res->num_rows() > 1){
						$temp  = [];
						foreach ($res->result() as $r) {
							$temp[] = $this->db->select('count(id) as jobs, units as units, invoice_total as amount')
							->where('invoice_number', $r->invoice_number)
							->where('DATE(invoice_date) >= ', date('Y-01-01', strtotime($date)))->where('DATE(invoice_date) <= ', date('Y-12-t'))
							->group_by('invoice_number')->get('invoice')->row_array();
						}
						
						$farr['units'] = 0;
						$farr['jobs'] = 0;
						$farr['amount'] = 0;
						foreach ($temp as $f) {
							if(isset($f['jobs'])){
								$farr['units'] += $f['units'];
								$farr['jobs'] += $f['jobs'];
								$farr['amount'] += $f['amount'];
							}
						}

						return (object)$farr;
					}else{
						return $this->db->select('count(id) as jobs, units as units, invoice_total as amount')
						->where($qry)
						->where('DATE(invoice_date) >= ', date('Y-01-01', strtotime($date)))->where('DATE(invoice_date) <= ', date('Y-12-t'))
						->group_by('invoice_number')->get('invoice')->row();
					}
				}
				if($arr['rtype'] == 3){
					return $this->db->select('count(o.id) as jobs, sum(o.units) as units, sum(o.order_value) as amount')
					->from('shipments as s')
					->join('orders as o', 'o.order_number = s.order_id', 'inner')
					->where($qry)
					->where('DATE(s.shipment_date) BETWEEN "'.date('Y-01-01', strtotime($date)).'" and "'.date('Y-12-t', strtotime($to_date)).'"')
					->get()->row();
				}
				break;
		}
	}

	//productivitydata By Individual
	private function daily_analyse_report_data($arr, $client){	
	$filter['client_code'] = $client->id;

		$data['name'] = $client->clientname;
		$data['code'] = $client->code;
		$data['station'] = $client->station;
		$data['city'] = $client->city;
		$data['state'] = $client->state;
		$data['ftd'] = $this->final_query(1, $filter, $arr);
		$data['mtd'] = $this->final_query(2, $filter, $arr, true);
		$data['ytd'] = $this->final_query(3, $filter, $arr, true);
		return $data;
	}

	/**
	* Get Process Json Data
	*/
	function json_processdata($is_len = false, $datatable = false){
		$this->db->select('distinct(tryno)')->from('process');
		
		if(!empty($datatable['search']['value'])){
			if($is_len){
		    	$this->db->limit($datatable['length'], $datatable['start']);
			}

		    $this->db->like('tryno', $datatable['search']['value']);
			return $this->db->order_by('id', 'desc')->get();
		}else{
			if($is_len){
		    	$this->db->limit($datatable['length'], $datatable['start']);
			}
			return $this->db->order_by('id', 'desc')->get();
		}


	}
}
