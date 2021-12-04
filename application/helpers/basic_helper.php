<?php 
	function info($id){
		$ci = &get_instance();
		return $ci->db->get('profile')->row();
	}
	
	function get_user_details($username){
		$ci = &get_instance();
		$res = $ci->db->where('code', $username)->get('employee')->row();
		return $res->firstname. ' '. $res->lastname.' ( '.$res->code.' )';
	}
	
	function get_menu(){
		$ci = &get_instance();
		$r = $ci->db->where('code', $ci->session->userdata('role'))->get('role');
		if($r->num_rows() > 0){
			$res=[];
			foreach (json_decode($r->row()->previlize) as $key) {
				$d = $ci->db->where('id', $key)->get('privileges')->row_array();
				array_push($res, $d);
			}
		}else{
			$res = $ci->db->get('privileges')->result_array();
		}

		$items = [];
		foreach($res as $data) {
			if($data["link"] == $ci->uri->segment(1)){
				$items[$data['parent']]['is_active'] = 'active';
			}
			
			if($data['parent'] == 0) {
			   $items[$data['id']] = $data;
			} else {
			   $items[$data['parent']]['child'][$data['id']] = $data;
			}
		}
		return build_menu($items);
	}

	function build_menu($items, $is_child = false){
		$ci = &get_instance();
		$html = ($is_child == 'child')?"<ul class='treeview-menu'>":"";
		foreach($items as $key => $value) {
			$arrow = (array_key_exists('child',$value))?"<i class='fa fa-angle-left pull-right '".$value['color']."'></i>":"";

			$is_active = ($value["link"] == $ci->uri->segment(1))?"active":"";

			$html .= ($value['link'] == '#')?'<li class="treeview '.$value['is_active'].'"><a href="'.base_url().$value['link'].'"><i class="fa '.$value['icon'].' '.$value['color'].'"></i> <span>'.$value['label'].'</span>'.$arrow.'</a>':'<li class="'.$is_active.'"><a href="'.base_url().$value['link'].'"><i class="fa '.$value['icon'].' '.$value['color'].'"></i> <span>'.$value['label'].'</span></a>';

			if(array_key_exists('child',$value)){
			  $html .= build_menu($value['child'], 'child');
			}
			$html .= "</li>";
		}
		$html .= ($is_child == 'child')?"</ul>":"";
		return $html;
	}


	function get_role($id){
		if($id == 'admin')
			return 'admin';
		// $ci = &get_instance();
		// return $ci->db->where('id', $id)->get('role')->row()->title;
	}

	function get_city_title($id){
		$ci = &get_instance();
		return $ci->db->where('id', $id)->get('cities')->row('city');
	}

	function login_user(){
		$ci = &get_instance();
		return $ci->session->userdata('userid');
	}

	function get_parent_client($id){
		$ci = &get_instance();
		return $ci->db->select('title')->where('code', $id)->get('parent_client')->row()->title;
	}

	function getclientname($id){
		$ci = &get_instance();
		return $ci->db->where('id', $id)->get('clients')->row()->clientname;
	}

	function get_invoice_date($id){
		$ci = &get_instance();
		return $ci->db->where('order_number', $id)->get('invoice')->row();
	}

	function get_station_title($id){
		$ci = &get_instance();
		return $ci->db->where('id', $id)->get('stations')->row()->station;
	}

	function client_info($id, $col){
		$ci = &get_instance();
		return $ci->db->where('id', $id)->get('clients')->row()->$col;
	}

	function loadoption($tbl, $all = false){
		$ci = &get_instance();
		if($all == true)
			return $ci->db->get($tbl)->result();
		return $ci->db->where('status', 0)->get($tbl)->result();
	}
	function getlabdepartment($tbl){
		$ci = &get_instance();
		return $ci->db->where('status', 0)->get($tbl)->result();
	}
	function getshades($tbl){
		$ci = &get_instance();
		return $ci->db->where('status', 0)->get($tbl)->result();
	}
	function emplyeesopt($tbl){
		$ci = &get_instance();
		return $ci->db->select('id, code, CONCAT(firstname," ",lastname ) as name')->where('status', 0)->get($tbl)->result();
	}

	function get_code($tbl, $pri){
		$ci = &get_instance();
		$code = $ci->db->select_max('id')->get($tbl)->row()->id;
		return $pri.$code;
	}
	
	function masertcode($title, $tbl){ 
		$ci = &get_instance();
		$res = $ci->db->where('title', $title)->get($tbl)->row();
		if($res)
			return $res->code;
		else
			return '';
	}
	function clientmasertcode($title, $tbl, $sel){
		$ci = &get_instance();
		$res = $ci->db->where('title', $title)->get($tbl)->row();
		if($res)
			return $res->$sel;
		else
			return '';
	}
	function getcurrency($title, $tbl){
		$ci = &get_instance();
		$res = $ci->db->where('code', $title)->get($tbl)->row();
		if($res)
			return $res->code;
		else
			return '';
	}
	function getstate($title, $tbl, $sel){
		$ci = &get_instance();
		$res = $ci->db->where('state', $title)->get($tbl)->row();
		if($res)
			return $res->$sel;
		else
			return '';
	}
	function getcountry($title, $tbl, $sel){
		$ci = &get_instance();
		$res = $ci->db->where('country', $title)->get($tbl)->row();
		if($res)
			return $res->$sel;
		else
			return '';
	}
	function getcity($title, $tbl){
		$ci = &get_instance();
		$res = $ci->db->where('city', $title)->get($tbl)->row();
		if($res)
			return $res->id;
		else
			return '';
	}
	function getstation($title, $tbl, $sel){
		$ci = &get_instance();
		$res = $ci->db->where('station', $title)->get($tbl)->row();
		if($res)
			return $res->$sel;
		else
			return '';
	}

	function aemp_name($code){
		$ci = &get_instance();

		if($code == 'admin' || $code == 'vinod')
			return ucfirst($code);
		
		if(strpos($code, 'D') !== false)

			$name = $ci->db->select('clientname as name')->where('code', $code)->get('clients')->row()->name;
		else
			$name = $ci->db->select('CONCAT(firstname," ",lastname ) as name')->where('code', $code)->get('employee')->row()->name;

		return ucfirst($name);
	}

	function shade_title($id){
		$ci = &get_instance();
		if($id)
			return $ci->db->where('code', $id)->get('shade')->row()->title;
		else
			return ' --';
	}

	function barcode($code){
		$ci = &get_instance();
		//load library
		$ci->load->library('zend');
		//load in folder Zend
		$ci->zend->load('Zend/Barcode');
		//generate barcode
		$file = Zend_Barcode::draw('code128', 'image', array('text' => $code, 'stretchText' => true, 'withQuietZones' => FALSE, 'barHeight' => 20), array());
		$store_image = imagepng($file,'assets/barcodes/'.$code.".png");
		return $code.'.png';
	}


	/***
	* Client Edit Functions
	*/
	function loadopts($tbl, $col, $id){
		$ci = &get_instance();
		return $ci->db->where($col, $id)->get($tbl)->result();
	}

	/***
	* Get Zone by Station
	*/
	function get_zone_title_by_station($id){
		$ci = &get_instance();
		$res = $ci->db->get('zones')->result();

		foreach ($res as $z) {
			foreach (json_decode($z->stations) as $s) {
				if($s == $id){
					return $z->zone;
				}
			}
		}

	}

	function lab_depaerment_title($code){
		$ci = &get_instance();
		return $ci->db->select('title')->where('code', $code)->or_where('id', $code)->get('labdepartment')->row('title');
	}

	function time_diff($time2, $time1){
		// $time1 = explode(':',$time1);
		// $time2 = explode(':',$time2);
		// $hours1 = $time1[0];
		// $hours2 = $time2[0];
		// $mins1 = $time1[1];
		// $mins2 = $time2[1];

		// $sec1 = $time1[2];
		// $sec2 = $time2[2];

		// $hours = $hours2 - $hours1;
		// $mins = 0;

		// if($hours < 0){
		// 	$hours = 24 + $hours;
		// }

		// if($mins2 >= $mins1) {
		// 	$mins = $mins2 - $mins1;
		// }else {
		// 	$mins = ($mins2 + 60) - $mins1;
		// 	$hours--;
		// }

		// if($mins < 9){
		// 	$mins = str_pad($mins, 2, '0', STR_PAD_LEFT);
		// }
		// if($hours < 9){
		// 	$hours =str_pad($hours, 2, '0', STR_PAD_LEFT);
		// }

		// return $hours.':'.$mins;

		$datetime1 = new DateTime($time2);
		$datetime2 = new DateTime($time1);
		$interval = $datetime1->diff($datetime2);
		$elapsed = $interval->format('%h:%i:%s');
		$elapsed = explode(':', $elapsed);
		return 'Work Done In - '.sprintf("%02d", $elapsed[0]).":".sprintf("%02d", $elapsed[1]).":".sprintf("%02d", $elapsed[2]);
	}

	function order_schadules($id){
		$ci = &get_instance();
		return $ci->db->where('order_id', $id)->group_by('title')->get('order_schadules')->result();
	}

	function get_product_title($id, $tbl){
		$ci = &get_instance();
		return $ci->db->select('title')->where('code', $id)->get($tbl)->row('title');
	}

	function get_state_title($id){
		$ci = &get_instance();
		return $ci->db->select('state')->where('id', $id)->get('states')->row('state');
	}

	function get_credit_amount($invoice){
		$ci = &get_instance();
		return $ci->db->select('invoice_total')->where('invoice_number', $invoice)->get('cradit_invoice')->row('invoice_total');
	}

	function get_worktype($oid){
		$ci = &get_instance();
		return $ci->db->select('work_type')->where('order_number', $oid)->get('orders')->row('work_type');
	} 

	function get_zone($id){
		$ci = &get_instance();
		$res = $ci->db->get('zones')->result();
		foreach ($res as $s) {
			if(in_array($id, json_decode($s->stations))){
				return $s->zone;
			}
		}
	}

	function get_zone_by_client($id){
		$ci = &get_instance();
		$res = $ci->db->where('id', $id)->get('clients')->row()->station;
		return get_zone($res);
	}

	function get_client_by_case($cn){
		$ci = &get_instance();
		$client_code = $ci->db->where('modal_no', $cn)->get('orders')->row()->client_code;
		return get_clientname($client_code);
	}

	function get_last_order($id){
		$ci = &get_instance();
		$orderdate = $ci->db->select('order_date')->where('client_code', $id)->order_by('id', 'desc')->get('orders')->row()->order_date;
		return $orderdate;
	}

	function is_case_type($case){
		$ci = &get_instance();
		return $ci->db->select('work_type')->where('modal_no', $case)->get('orders')->row()->work_type;
	}

	function get_orders_percentage($client, $type){
		$ci = &get_instance();
		$res = $ci->db->select('count(id) as total')->where(['client_code' => $client, 'work_type' => $type, 'DATE(order_date) >=' => date('Y-m-d', strtotime('-90 days'))])->get('orders')->row()->total;
		$new = $ci->db->select('count(id) as new')->where(['client_code' => $client, 'work_type' => 'NEW', 'DATE(order_date) >=' => date('Y-m-d', strtotime('-90 days'))])->get('orders')->row()->new;
		if($new == 0)
			return '0 %';
		else
			return round(($res * 100)/$new, 2) .'%';
	}

	function get_orders_total($client, $type){
		$ci = &get_instance();
		$res = $ci->db->select('count(id) as total')->where(['client_code' => $client, 'work_type' => $type, 'DATE(order_date) >=' => date('Y-m-d', strtotime('-90 days'))])->get('orders')->row()->total;
		return $res;
	}
	
	function get_edit_limit($invoice, $count = false){
		$ci = &get_instance();
		$res = $ci->db->select('max(invoice_group) as agroup')->where('invoice_number', $invoice)->get('edit_invoice');

		if($res->num_rows() > 0){
			return ($ci->config->item('invoice_number') - $res->row()->agroup);
		}else{
			return 0;
		}
	}

	function ec_date_format($date, $format){
		return date($format, strtotime($date));
	}

	function get_product_id($pcode){
		$ci = &get_instance();
		return $ci->db->select('id')->where('code', $pcode)->get('product')->row()->id;
	}
