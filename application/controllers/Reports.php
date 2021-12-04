<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends CI_Controller {
	function __Construct(){
		parent::__Construct();
		if($this->session->userdata('username') == '')
			redirect('logout');
		
		$this->data['info'] = info(true);

		$this->data['sidebar'] = (object)[
			'menu' => $this->uri->segment(1),
			'submenu' => $this->uri->segment(2)
		];
		
		$this->data['script'] = "reports";//$this->uri->segment(1);
		$this->load->library('m_pdf');
		$this->load->model(['client_m','order_m', 'reports_m']);
	}

	/***
	* Reports for Sales and Orders Date Wise
	*/
	function index(){
		$this->data['header_content'] = (object)[
			'title' => 'Sales and Orders',
			'sub_title' => 'Reports',
			'path' => uri_string(),
		];

		$reportsfor = $this->input->post('reportsfor');
		if(!empty($reportsfor)){
			$dates = explode('-', $this->input->post('dates'));
			$arr = [
				'fromdate' => date('Y-m-d', strtotime($this->input->post('fromdate'))),
				'todate' => date('Y-m-d', strtotime($this->input->post('todate'))),
				'client' => $this->input->post('client'),
				'pcat' => $this->input->post('pcat'),
				'ptype' => $this->input->post('ptype'),
				'product' => $this->input->post('product'),
			];

			if($reportsfor == 'orders')
				$this->data['rows']  = $this->reports_m->getorders($arr);
			
			if($reportsfor == 'sales')
				$this->data['rows']  = $this->reports_m->getinvoices($arr);
		}else{
		    $arr = [
				'fromdate' => date('Y-m-d'),
				'todate' => date('Y-m-d'),
				'client' => null,
				'pcat' => null,
				'ptype' => null,
				'product' => null,
				'reportsfor' => $this->input->post('reportsfor')
			];
		}

		$this->data['arr'] = $arr;
		$this->data['arr']['reportsfor'] = $this->input->post('reportsfor');
		
		$this->data['randerPage'] = "reports/index";

		if($reportsfor == 'orders')
			$this->data['tableview'] = "reports/orderstable";
		if($reportsfor == 'sales')
			$this->data['tableview'] = "reports/invoicetable";


		$this->load->view('_layout', $this->data);
	}

	/***
	* Reports for Paymets and Collection date and Client wise
	*/
	function payments(){
		
		$this->data['header_content'] = (object)[
			'title' => 'Payment',
			'sub_title' => 'Reports',
			'path' => uri_string(),
		];

		if($_POST){
			$arr = [
				'fromdate' => date('Y-m-d', strtotime($this->input->post('fromdate'))),
				'todate' => date('Y-m-d', strtotime($this->input->post('todate'))),
				'client' => $this->input->post('client'),
				'mode' => $this->input->post('payment_mode'),
				'order_number' => $this->input->post('order_number')
			];
			$this->data['rows']  = $this->reports_m->getpayments($arr);
		}else{
			$arr = [
				'fromdate' => date('Y-m-d'),
				'todate' => date('Y-m-d'),
				'client' => null,
				'mode' => null,
				'order_number' => null,
			];
			$this->data['rows']  = $this->reports_m->getpayments($arr);
		}

		$this->data['arr'] = $arr;
		$this->data['randerPage'] = "reports/payments";
		$this->load->view('_layout', $this->data);
	}

	/***
	* Invoice Summary By Client Wise
	*/
	function invoicesummary(){

		$this->data['header_content'] = (object)[
			'title' => 'Invoice',
			'sub_title' => 'Summary',
			'path' => uri_string(),
		];

		if($_POST){
			// $this->db->cache_on();
			$arr = [
				'fromdate' => date('Y-m-d', strtotime($this->input->post('fromdate'))),
				'todate' => date('Y-m-d', strtotime($this->input->post('todate'))),
				'client' => $this->input->post('client'),
			];
			$this->data['invoices'] = $this->db->where(['client_id' => $arr['client'], 'invoice_date >= ' => $arr['fromdate'], 'invoice_date <= ' => $arr['todate']])->get('invoice')->result();
			
			foreach ($this->data['invoices'] as $i){
				$this->data['product'][] = $this->db->where(['invoice_number' => $i->invoice_number, 'order_id' => $i->order_id])->get('invoice_product')->result();
			}

			$this->data['client'] = $arr['client'];
			$html = $this->load->view('bulk/invoicesummary_datewise', $this->data, true);

			$this->m_pdf->pdf($html, '_invoice_'.time().'.pdf');
			// $this->db->cache_off();
			return ;
		}else{
			$arr = [
				'fromdate' => date('Y-m-d'),
				'todate' => date('Y-m-d'),
				'client' => null,
			];
			$this->data['rows'] = null;
		}
		$this->data['arr'] = $arr;
		$this->data['randerPage'] = "bulk/invoice_report_datewise";
		$this->load->view('_layout', $this->data);
	}


	/***
	* Productivitydata By Employee
	*/
	function productivityreport($client = false){

		$this->data['header_content'] = (object)[
			'title' => 'Productivity',
			'sub_title' => 'Report',
			'path' => uri_string(),
		];

		if(!empty($client)){
			$this->data['client'] = urldecode($client);
			$this->data['rows'][urldecode($client)] = $this->reports_m->productivitylog(urldecode($client));
		}else{
			$this->data['rows'] = $this->reports_m->productivitylog();
			$this->data['client'] = null;
		}

		$this->data['users'] = $this->db->select('username')->get('users')->result();
		$this->data['randerPage'] = "reports/productivityreport";
		$this->load->view('_layout', $this->data);
	}

	/***
	* productivitydata
	*/
	function productivitydata(){
		$data['ftd'] = $this->tddata(date('Y/m/d'));
		$data['mtd'] = $this->tddata(date('Y/m/01'));
		$data['ytd'] = $this->tddata(date('Y/01/01'));
		$data['date'] = "(".date('d/m/Y h:i a').")";
		echo json_encode(['data'=>$data]);
	}

	/***
	* Country wise or area wise Client List Report
	*/
	function citywiseclients(){
		$this->data['header_content'] = (object)[
			'title' => 'CityWise Clients',
			'sub_title' => 'Report',
			'path' => uri_string(),
		];

		$this->data['randerPage'] = "reports/citywiseclients";
		$this->load->view('_layout', $this->data);
	}

	function json_citywiseclients($col, $id, $_exp = false){
		$data = [];
		$column_search = ['clientname', 'code', 'mobile'];

		$rows = $this->reports_m->citywiseclients($col, $id, ['start' => $this->input->post('start'), 'length' => $this->input->post('length'), 'search' => $this->input->post('search')], $column_search, false, $_exp);

		$rows_count = $this->reports_m->citywiseclients($col, $id, ['start' => $this->input->post('start'), 'length' => $this->input->post('length'), 'search' => $this->input->post('search')], $column_search, true);
		
		$i =1;
		foreach($rows as $row){
            $data[] = [
            	$i,
            	ucfirst($row->clientname),
            	strtoupper($row->code),
            	$row->mobile,
            	$row->address,
            	$row->station,
            ];
            $i++;
        }
        if($_exp)
        	return $data;
		else
    		$this->json_response($rows_count, $data, 'clients');
	}

	/***
	* Country wise or area wise Client List Report
	*/
	function zonewiseclients(){

		$this->data['header_content'] = (object)[
			'title' => 'ZoneWise Clients',
			'sub_title' => 'Report',
			'path' => uri_string(),
		];

		$this->data['zones'] = $this->db->get('zones')->result();
		$this->data['randerPage'] = "reports/zonewiseclients";
		$this->load->view('_layout', $this->data);
	}

	function json_zonewiseclients($zone, $_exp = false){
		$data = [];
		$rows = $this->reports_m->zonewiseclients($zone, ['start' => $this->input->post('start'), 'length' => $this->input->post('length'), 'search' => $this->input->post('search')], false, $_exp);

		$rows_count = $this->reports_m->zonewiseclients($zone, ['start' => $this->input->post('start'), 'length' => $this->input->post('length'), 'search' => $this->input->post('search')], true);
		
		$i =1;
		foreach($rows as $row){
            $data[] = [
            	$i,
            	ucfirst($row->clientname),
            	strtoupper($row->code),
            	$row->mobile,
            	$row->address,
            	get_station_title($row->station),
            	get_zone($row->station),
            ];
            $i++;
        }
	    if($_exp)
        	return $data;
		else
    		$this->json_response($rows_count, $data, 'clients');
	}


	/***
	* Day wise Challan Report
	*/
	function citywisebusnessreport(){

		$this->data['header_content'] = (object)[
			'title' => 'CityWise Client Bussess',
			'sub_title' => 'Report',
			'path' => uri_string(),
		];
		if($_POST){
			$date = $this->input->post('jobdate', true);
			$date = $this->input->post('city', true);
			$this->data['count_jobs'] = $this->reports_m->day_wise_reports(date('Y-m-d', strtotime($date)));
			$this->data['date'] = date('Y-m-d', strtotime($date));
		}else{
			$this->data['date'] = date('Y-m-d');
			$this->data['count_jobs'] = $this->reports_m->day_wise_reports(date('Y-m-d'));
		}

		$this->data['randerPage'] = "reports/citywisebusnessreport";
		$this->load->view('_layout', $this->data);
	}


	/***
	* Getting Productivity Data
	*/
	private function tddata($date){
		$ftd = $this->db->where('DATE(added_at) >=', date('Y-m-d', strtotime($date)))->where('DATE(added_at) <=', date('Y-m-d'))->get('orders')->num_rows();
		$mtd = $this->db->where('DATE(added_at) >=', date('Y-m-d', strtotime($date)))->where('DATE(added_at) <=', date('Y-m-d'))->group_by('challan_number')->get('shipments')->num_rows();
		$ytd = $this->db->where('DATE(added_at) >=', date('Y-m-d', strtotime($date)))->where('DATE(added_at) <=', date('Y-m-d'))->group_by('invoice_number')->get('invoice')->num_rows();
		return ['order' => $ftd, 'shipment' => $mtd, 'invoice' => $ytd];
	}

	/**
	* Daily Productivity Data
	*/
	function dailyproductivitydata($mon = false){

		$this->data['header_content'] = (object)[
			'title' => 'Daily Productivity',
			'sub_title' => 'Report',
			'path' => uri_string(),
		];

		if($mon > 0)
			$days = $this->productivitydata_grn($mon);
		else{
			$mon = date('m');
			$days = $this->productivitydata_grn($mon);
		}

		$this->data['rows'] = [];

		foreach($days['day'] as $key => $d){
			// $this->data['rows'][$d]['tech_emp'] = $this->get_alltechnicians($d, true);
			// $this->data['rows'][$d]['all_emp'] = $this->get_alltechnicians($d);

			$this->data['rows'][$d]['today_jobs'] = $this->get_today_cases($d);
			$this->data['rows'][$d]['today_units'] = $this->get_today_units($d);
			$this->data['rows'][$d]['tech_emp'] = $this->get_alltechnicians($d, true);
			$this->data['rows'][$d]['all_emp'] = $this->get_alltechnicians($d);
		}

		$this->data['mon'] = $mon;
		$this->data['randerPage'] = "reports/productivitydata";
		$this->load->view('_layout', $this->data);
	}
	
	/**
	* Redo Orders Reports
	*/
	function redoreports(){
		$this->data['header_content'] = (object)[
			'title' => 'Redo Orders',
			'sub_title' => 'Report',
			'path' => uri_string(),
		];

		if($_POST){
			$arr = [
				'fromdate' => date('Y-m-d', strtotime($this->input->post('fromdate'))),
				'todate' => date('Y-m-d', strtotime($this->input->post('todate'))),
				'client' => $this->input->post('client'),
				'pcat' => $this->input->post('pcat'),
				'ptype' => $this->input->post('ptype'),
				'product' => $this->input->post('product'),
			];

			$this->data['rows']  = $this->reports_m->getredoorders($arr);
		}else{
		    $arr = [
				'fromdate' => date('Y-m-d'),
				'todate' => date('Y-m-d'),
				'client' => null,
				'pcat' => null,
				'ptype' => null,
				'product' => null,
			];
			$this->data['rows']  = [];//$this->reports_m->getredoorders($arr);
		}
		$this->data['arr'] = $arr;
		$this->data['tableview'] = "reports/redoreportstable";
		$this->data['randerPage'] = "reports/redoreports";
		$this->load->view('_layout', $this->data);
	}

	/**
	* Cpurrection Orders Reports
	*/
	function correctionorders(){
		$this->data['header_content'] = (object)[
			'title' => 'Correction Orders',
			'sub_title' => 'Report',
			'path' => uri_string(),
		];

		if($_POST){
			$arr = [
				'fromdate' => date('Y-m-d', strtotime($this->input->post('fromdate'))),
				'todate' => date('Y-m-d', strtotime($this->input->post('todate'))),
				'client' => $this->input->post('client'),
				'pcat' => $this->input->post('pcat'),
				'ptype' => $this->input->post('ptype'),
				'product' => $this->input->post('product'),
			];

			$this->data['rows']  = $this->reports_m->getcurrectionorders($arr);
		}else{
		    $arr = [
				'fromdate' => date('Y-m-d'),
				'todate' => date('Y-m-d'),
				'client' => null,
				'pcat' => null,
				'ptype' => null,
				'product' => null,
			];
			$this->data['rows']  = [];//$this->reports_m->getcurrectionorders($arr);
		}
		$this->data['arr'] = $arr;
		$this->data['tableview'] = "reports/redoreportstable";
		$this->data['randerPage'] = "reports/currectionorders";
		$this->load->view('_layout', $this->data);
	}

	/**
	* Redo Orders Reports
	*/
	function labslipreport(){

		$this->data['header_content'] = (object)[
			'title' => 'LabSlip',
			'sub_title' => 'Report',
			'path' => uri_string(),
		];

		if($_POST){
			$arr = [
				'fromdate' => date('Y-m-d', strtotime($this->input->post('fromdate'))),
				'todate' => date('Y-m-d', strtotime($this->input->post('todate'))),
				'client' => $this->input->post('client')
			];

			$this->data['rows']  = $this->reports_m->getlabsliporders($arr);
		}else{
		    $arr = [
				'fromdate' => date('Y-m-d'),
				'todate' => date('Y-m-d'),
				'client' => null,
				'pcat' => null,
				'ptype' => null,
				'product' => null,
			];
			$this->data['rows']  = $this->reports_m->getlabsliporders($arr);
		}

		$this->data['arr'] = $arr;
		$this->data['tableview'] = "reports/lapslipreportstable";
		$this->data['randerPage'] = "reports/labslips";
		$this->load->view('_layout', $this->data);
	}

	/***
	* Get All Employees and Technitions
	*/
	private function get_alltechnicians($date, $_is = false){
		$this->db->from('employee as e')->join('attandance as a', 'a.emp = e.code', 'inner')->where('a._date', date('Y-m-d', strtotime($date)));
		if($_is === false)
			return $this->db->get()->num_rows();
		else
			return $this->db->where('e.lab_department IN (select code from rpd_labdepartment)', null, false)->get()->num_rows();
	}

	/***
	* Get Today Orders or Cases
	*/
	private function get_today_cases($date){
		return $this->db->where('DATE(order_date)', date('Y-m-d', strtotime($date)))->get('orders')->num_rows();
	}

	/***
	* 	Get Today All Units Orders Count 
	*/
	private function get_today_units($date){
		return $this->db->select('SUM(op.unit) as units')->from('orders as o')->join('order_products as op', 'op.order_id = o.id', 'inner')->where('DATE(order_date)', date('Y-m-d', strtotime($date)))->get()->row()->units;
	}

	/***
	* Genrate Days (Dates) By Month wise
	*/
	private function productivitydata_grn($mon){
		$cmdays = date('t', strtotime('Y-'.$mon.'-01'));
		$days = [];
		$i = 1;
		while ($i <= $cmdays){
			$days['day'][] = date('d-m-Y', strtotime($i.'-'.$mon.'-'.date('Y')));
			$i++;
		}
		return $days;
	}

	/***
	* Return all Json Data
	*/
	private function json_response($filtered, $data, $tbl){
		$output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => $this->db->get($tbl)->num_rows(),
            "recordsFiltered" => $filtered,
            "data" => $data,
        );
        
        echo json_encode($output);		
	}
	
	/***
	* Day wise Challan Report
	*/
	function citywisesalesreport(){	
		$this->data['header_content'] = (object)[
			'title' => 'CityWise Sales',
			'sub_title' => 'Report',
			'path' => uri_string(),
		];

		if($_POST){
			$this->data['month'] = $this->input->post('month', true);
			$this->data['year'] = $this->input->post('year', true);
			$city = $this->input->post('city', true);
			$data = $this->db->select('id, clientname, code')->where('city', $city)->get('clients')->result();
			$this->data['rows'] = $data;
		}else{
			$this->data['rows'] = '';
		    $this->data['month'] = false;
		    $this->data['year'] = false;
		}

		$this->data['randerPage'] = "reports/citywisesalesreport";
		$this->load->view('_layout', $this->data);
	}
	
	/***
	* Zone wise or area wise Client Sales Report
	*/
	function zonewisesalesreport(){
	    $this->data['header_content'] = (object)[
			'title' => 'ZoneWise Sales',
			'sub_title' => 'Report',
			'path' => uri_string(),
		];
	    if($_POST){
            $res = $this->db->where('id', $this->input->post('station', true))->get('zones')->row();
    		$this->db->distinct()->select('c.id, c.clientname, c.code, c.mobile, c.status, c.station')->from('clients as c');
    		
    		$j = 0;
    		$coun = count(json_decode($res->stations));
    		
    		foreach (json_decode($res->stations) as $s){
    			$this->db->or_where('c.station', $s);
    		}
    		
    	$data = $this->db->group_by('c.id')->order_by('c.id', 'desc')->get()->result();
	       $this->data['rows'] = $data;
	       $this->data['zone'] = $this->input->post('station', true);
	       $this->data['month'] = $this->input->post('month', true);
	       $this->data['year'] = $this->input->post('year', true);
	       $this->data['type'] = $this->input->post('type', true);
	    }else{
	       $this->data['rows'] = '';
	       $this->data['month'] = false;
	       $this->data['year'] = false;
	       $this->data['zone'] = false;
	       $this->data['type'] = false;
	    }
	    
		$this->data['zones'] = $this->db->get('zones')->result();
		$this->data['randerPage'] = "reports/zonewisesalesreport";
		$this->load->view('_layout', $this->data);
	}

	function processtree($case_no = false){
		$this->data['header_content'] = (object)[
			'title' => 'Process Tree',
			'sub_title' => 'Report',
			'path' => uri_string(),
		];

		if(!$case_no)
			$case_no = $this->input->post('case_no', true);

		if($case_no){
			$res = $this->db->where('tryno', $case_no)->order_by('id', 'asc')->get('process');
			if($res->num_rows() > 0)
				$this->data['logs'] = $res->result();
			
			$this->data['case_no'] = $case_no;
		}
		
		$this->data['randerPage'] = "reports/process/process_tree";
		$this->load->view('_layout', $this->data);
	}

	function processdata(){
		$this->data['header_content'] = (object)[
			'title' => 'Process Data',
			'sub_title' => 'Report',
			'path' => uri_string(),
		];
		$this->data['randerPage'] = "reports/process/process_table";
		$this->load->view('_layout', $this->data);
	}

	function json_processdata(){
		$start = 1;//$this->input->post('start');
		$length = 10;//$this->input->post('length');
		$search = $this->input->post('search');

		$c = $this->reports_m->json_processdata(false, ['start' => $start, 'length' => $length, 'search' => $search]);
		$filtered = $c->num_rows();

		$res = $this->reports_m->json_processdata(true, ['start' => $start, 'length' => $length, 'search' => $search]);
		if($res->num_rows() > 0){
			$case = $res->result();
			foreach ($case as $c) {
				$data = $this->db->where('tryno', $c->tryno)->get('process')->result();
				$cases[$c->tryno] = $data;
			}
		}

		//Start Table rander
			// $c = 0;
			// foreach ($rows as $key) {
			//     $temp = sizeof($key);
			//     if($temp > $c){
			//       $c = $temp;
			//     }
			// }

			// $html_table = '';
			// $i = 1;
			// foreach ($rows as $case => $value) {
			//     $t = 1;
			//     $html_table .= '<tr>
			//       <td>'.$i++.'</td>
			//       <td> <a href="'.base_url('reports/processtree/'.$case).'" target="_blank">'.$case.'</a></td>';
			//         foreach ($value as $l) {
			//           $t++;
			//           if($d->code == $l->department)
			//             $html_table .='<td>'.lab_depaerment_title($l->department).'</td>';
			//           else
			//             $html_table .= '<td>'.lab_depaerment_title($l->department).'</td>';
			//         }

			//         if($t < $c){
			//           for($a = $t; $a <= $c; $a++){
			//             $html_table .= '<td> --- </td>';
			//           }
			//         }

			//     $html_table .= '</tr>';
			// }

			// $html =	'<thead><tr><th>Sr.no</th><th>Case No</th>';
			// for($z=1; $z <= $c; $z++){
			// $html .= '<th> Stage '.$z.'</th>';
			// }
	  //      	$html .= '</tr></thead><tbody>';
			// $html .= $html_table;
	  //      	$html .= '</tbody>';
		//End Table rander

		$output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => get_count('process'),
            "recordsFiltered" => ($filtered > 0)?$filtered:get_count('process'),
            "data" => $cases,
            "columns" => [["data"=> "Name"],["data"=> "Name4"],["data"=> "Name3"],["data"=> "Name2"],["data"=> "Name1"]],
        );
        
        // Output to JSON format
        echo json_encode($output);
	}

	
	/**
	* CSV Export
	*/
	public function excel($data){
		$filename = $data.'_'.date('Ymd').'.csv'; 
		// $data = $this->input->post('data');

		$country = $this->input->post('country');
		$state = $this->input->post('state');
		$city = $this->input->post('city');
		$station1 = $this->input->post('station1');

		$data = 'json_'.$data;

		if($station1){
			$usersData = $this->$data('station', $station1, true);
		}else if($city){
			$usersData = $this->$data('city', $city, true);
		}else if($state){
			$usersData = $this->$data('state', $state, true);
		}else if($data == 'json_zonewiseclients'){
			$usersData = $this->$data($_POST['station1c'], true);
		}else{
			$usersData = $this->$data('country', $country, true);
		}

		header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$filename");
        header("Content-Type: application/csv; ");

		// // file creation 
		$file = fopen('php://output', 'w');

		// if($data == 'zonewiseclients')
		// else
		// 	$header = ['#','clientname','code','mobile', 'address','station'];
			$header = ['#','Client Name','Client Code','Contact No', 'Address','Station','Zone'];

		fputcsv($file, $header);

		foreach ($usersData as $key=>$line){ 
		 	fputcsv($file,$line); 
		}

		fclose($file); 
		exit; 
	}

	/**
	* Target Archive Single Month Report
	*/
	function target_arhive(){
		$this->data['header_content'] = (object)[
			'title' => 'Target Archive',
			'sub_title' => 'Report',
			'path' => uri_string(),
		];

		if($_POST){
			$month = $this->input->post('month', true);
			$designation = $this->input->post('designation', true);

			$data = $this->reports_m->get_archive_targets_analyse($designation, $month);

			$this->data['mon'] = $month;
			$this->data['desig'] = $designation;
			$this->data['rows'] = $data;
		}else{
			$this->data['mon'] = '';
			$this->data['desig'] = '';
		}
		
		$this->data['randerPage'] = "targets/reports/analyse";
		$this->data['designation'] = $this->designation(['CTEC', 'TECH']);
		$this->load->view('_layout', $this->data);
	}

	/**
	* Target Archive Single Month Report
	*/
	function target_analyse(){
		$this->data['header_content'] = (object)[
			'title' => 'Target Archive',
			'sub_title' => 'Report',
			'path' => uri_string(),
		];

		if($_POST){
			$month = $this->input->post('month', true);
			$year = $this->input->post('year', true);
			$designation = $this->input->post('designation', true);

			$data = $this->reports_m->get_archive_targets_analyse($designation, $month, $year);
				
			$this->data['mon'] = $month;
			$this->data['year'] = $year;
			$this->data['desig'] = $designation;
			$this->data['rows'] = $data;

			if($_POST['btn_get_dn'] == 'Excel'){
				$adata = $this->load->view('targets/reports/target_excel', $this->data, true);
				header('Content-Type: application/vnd.ms-excel');  
				header('Content-disposition: attachment; filename=target_arhive_'.date('F',  strtotime($year.'-'.$month.'-01')).'.xls');  
				echo $adata;
				exit();
			}
		}else{
			$this->data['mon'] = '';
			$this->data['year'] = '';
			$this->data['desig'] = '';
		}
		
		$this->data['randerPage'] = "targets/reports/analyse";
		$this->data['designation'] = $this->designation(['CTEC', 'TECH']);

		$this->load->view('_layout', $this->data);
	}

	/**
	* Target Archive Monthly Day wise Report
	*/
	function daywise_target_arhive(){
		$this->data['header_content'] = (object)[
			'title' => 'DayWise Target Archive',
			'sub_title' => 'Report',
			'path' => uri_string(),
		];
		if($_POST){
			$month = $this->input->post('month', true);
			$year = $this->input->post('year', true);
			$designation = $this->input->post('designation', true);

			$data = $this->reports_m->daywise_target_arhive($designation, $month, $year);
				
			$days = date('t', strtotime($year.'-'.$month.'-01'));
			for ($i=1; $i <= $days; $i++) {
				$dates[$year.'-'.sprintf("%02d", $month).'-'.sprintf("%02d", $i)] = 0;
			}

			foreach ($data as $k => $v) {
				$a = [];
				foreach ($v['data'] as $d){
					$a[$d->date] += $d->archived;
				}

				$a = array_replace($dates,$a);

				$data[$k]['data'] = $a;
			}

			$this->data['month_total_days'] = $days;
			$this->data['mon'] = $month;
			$this->data['year'] = $year;
			$this->data['desig'] = $designation;
			$this->data['rows'] = $data;
		}else{
			$this->data['year'] = '';
			$this->data['mon'] = '';
			$this->data['desig'] = '';
			$this->data['month_total_days'] = 0;
		}
		
		$this->data['randerPage'] = "targets/reports/daywise_target_archive";
		$this->data['designation'] = $this->designation(['CTEC', 'TECH']);
		$this->load->view('_layout', $this->data);
	}

	/**
	* Target Archive Monthly Day wise Report
	*/
	function monthly_target_arhive(){
		$this->data['header_content'] = (object)[
			'title' => 'Monthly Target Archive',
			'sub_title' => 'Report',
			'path' => uri_string(),
		];
		if($_POST){
			$year = $this->input->post('year', true);
			$designation = $this->input->post('designation', true);

			$data = $this->reports_m->monthly_target_arhive($designation, $year);
			$this->data['rows'] = $data;
			$this->data['year'] = $year;
			$this->data['desig'] = $designation;
		}else{
			$this->data['year'] = '';
			$this->data['desig'] = '';
		}
		
		$this->data['month_arr'] = ["January","February","March","April","May","June","July","August","September","October","November","December"];
		$this->data['designation'] = $this->designation(['CTEC', 'TECH']);
		$this->data['randerPage'] = "targets/reports/monthly_target_archive";
		$this->load->view('_layout', $this->data);
	}

	/**
	* Export monthly_target_arhive_export to Excel 
	*/
	function monthly_target_arhive_export(){
		$data['month_arr'] = ["January","February","March","April","May","June","July","August","September","October","November","December"];
		$designation = $this->input->post('designation_e', true);

		$data['rows'] = $this->reports_m->monthly_target_arhive($designation);
		$adata = $this->load->view('targets/reports/monthly_target_archive_table', $data, true);
		header('Content-Type: application/vnd.ms-excel');  
		header('Content-disposition: attachment; filename=monthly_target_arhive_'.date('Ymd').'.xls');  
		echo $adata;
	}


	function rawdata(){
		$this->data['header_content'] = (object)[
			'title' => 'RawData',
			'sub_title' => 'Report',
			'path' => uri_string(),
		];

		if($_POST){
		    $this->data['fillters'] = [
    			'fromdate'	=> $this->input->post('fromdate', true),
    			'todate'	=> $this->input->post('todate', true),
    			'type'	=> $this->input->post('type', true),
    		];
    		if($this->data['fillters']['type'] == 'invoice')
				$this->data['rows'] = $this->get_raw_invoicedata($this->data['fillters']);
			else
				$this->data['rows'] = $this->get_raw_orderdata($this->data['fillters']);
		}else{
		    $this->data['fillters'] = [
    			'fromdate'	=> date('Y-m-d'),
    			'todate'	=> date('Y-m-d'),
    			'type'	=> '',
    		];
		}

		$this->data['randerPage'] = "reports/rawdata/index";

    	if($this->data['fillters']['type'] == 'invoice')
			$this->data['_page'] = "invoice_data";
		else
			$this->data['_page'] = "order_data";

		$this->load->view('_layout', $this->data);
	}

	/**
	* Attandance Report
	*/
	function attendance(){
		$this->data['header_content'] = (object)[
			'title' => 'Reports',
			'sub_title' => 'Masters',
			'path' => uri_string(),
		];
		$this->data['sidebar'] = (object)[
			'menu' => $this->uri->segment(1),
			'submenu' => $this->uri->segment(2)
		];

		if($_POST){
			$m = $this->input->post('month');
			$this->data['rows'] = $this->get_atttendance(false, $m);
			$this->data['smonth'] = $m;
		}else{
			$this->data['rows'] = $this->get_atttendance(false, date('m'));
			$this->data['smonth'] = date('m');
		}

		$_POST = [];
		$this->data['randerPage'] = "reports/attandance_report";
		$this->load->view('_layout', $this->data);
	}

	/**
	* No Orders Clients
	**/
	function clientslastorders(){
		$this->data['header_content'] = (object)[
			'title' => 'Reports',
			'sub_title' => 'Masters',
			'path' => uri_string(),
		];
		$this->data['sidebar'] = (object)[
			'menu' => $this->uri->segment(1),
			'submenu' => $this->uri->segment(2)
		];

		if($_POST){
			$fromdate	= $this->input->post('fromdate', true);
			$todate	= $this->input->post('todate', true);
		}else{
			$fromdate = date('Y-m-d', strtotime('-7days'));
			$todate = date('Y-m-d');
		}

		$this->data['arr'] = [
			'fromdate' => $fromdate,
			'todate' => $todate
		];

		$this->data['rows'] = $this->get_last_orders_data($fromdate, $todate);

		$this->data['randerPage'] = "reports/no_orders_count";
		$this->load->view('_layout', $this->data);
	}

	private function get_last_orders_data($fromdate, $todate){
		return $this->db->select('c.id, c.clientname, c.code, c.email, c.mobile, ci.city, c.parent, c.status, c.is_gst, s.station, s.id as station_id, st.state')
		->from('clients as c')
		->join('cities as ci', 'ci.id = c.city', 'left')
		->join('stations as s', 's.id = c.station', 'left')
		->join('states as st', 'st.id = c.state', 'left')
		->where('c.id NOT IN (select client_code from rpd_orders WHERE order_date BETWEEN "'.date('Y-m-d', strtotime($fromdate)).'" and "'.date('Y-m-d', strtotime($todate)).'")',NULL,FALSE)->get()->result();
	}



	private function get_atttendance($id = false, $month){
		if($id){
			$data['attandance'] = $this->db->select('*')->from('attandance')->where('emp_id', $id)->get()->row();
			$data['payscale'] = $this->db->select('*')->from('salary')->where('emp_id', $id)->get()->result();
			$data['employee'] = $this->db->select('*')->from('employee')->where('code', $id)->get()->row();
			$data['ac'] = $this->db->select('*')->from('employee_ac')->where('emp_id', $id)->get()->row();
			return $data;
		}
		return $this->db->where('_month', $month)->get('attandance')->result();
	}
	/**
	* END Attandance Report
	*/



	private function get_raw_invoicedata($flts){
		$this->db->distinct('o.invoice_number')->select('o.invoice_date, o.invoice_number, o.units, o.invoice_total, c.country, s.state, city.city, st.station, ci.clientname, ci.code, z.zone');
		$this->db->from('invoice as o');
		$this->db->join('clients as ci', 'ci.id = o.client_id', 'inner');
		$this->db->join('country as c', 'c.id = ci.country', 'left');
		$this->db->join('states as s', 's.id = ci.state', 'left');
		$this->db->join('cities as city', 'city.id = ci.city', 'left');
		$this->db->join('stations as st', 'st.id = ci.station', 'left');
		$this->db->join('zone_temp as z', 'z.station = ci.station', 'left');
		$this->db->where('DATE(order_date) >= ', date('Y-m-d', strtotime($flts['fromdate'])));
		$this->db->where('DATE(order_date) <= ', date('Y-m-d', strtotime($flts['todate'])));
		$this->db->where('o.status', 0);

		return $this->db->get()->result();
	}

	private function get_raw_orderdata($flts){
		$this->db->select('o.patiant_name, o.delivery_method, o.due_date, p.title as product_id, pc.title as product_cat, pt.title as product_type, op.unit_price,  op.unit, op.discount, op.total_amount, o.order_date, o.work_type, o.order_priority, o.order_number, o.modal_no, o.units, o.order_value, c.country, s.state, city.city, st.station, ci.clientname, pclient.title as parent_client, ci.code, z.zone, ct.title as correction_tamp, cc.title as customercateory, ci.legencycode, so.title as source, ci.referby as refer_by, ci.dob');
		$this->db->from('orders as o');
		$this->db->join('order_products as op', 'op.order_id = o.id', 'inner');
		$this->db->join('product as p', 'p.code = op.product_id', 'inner');
		$this->db->join('productcategory as pc', 'pc.code = p.category', 'inner');
		$this->db->join('producttype as pt', 'pt.code = p.type', 'inner');
		$this->db->join('clients as ci', 'ci.id = o.client_code', 'left');
		$this->db->join('country as c', 'c.id = ci.country', 'left');
		$this->db->join('states as s', 's.id = ci.state', 'left');
		$this->db->join('cities as city', 'city.id = ci.city', 'left');
		$this->db->join('stations as st', 'st.id = ci.station', 'left');
		$this->db->join('zone_temp as z', 'z.station = ci.station', 'left');
		$this->db->join('client_category as cc', 'cc.code = ci.customercateory', 'left');
		$this->db->join('correction_template as ct', 'ct.id = o.correction_tamp', 'left');
		$this->db->join('source as so', 'so.id = ci.source', 'left');
		$this->db->join('parent_client as pclient', 'pclient.code = ci.parent', 'left');
		$this->db->where('DATE(order_date) >= ', date('Y-m-d', strtotime($flts['fromdate'])));
		$this->db->where('DATE(order_date) <= ', date('Y-m-d', strtotime($flts['todate'])));
		$this->db->where('o.status', 0);
		
		if($flts['type'] == 'challan')
			$this->db->where('o.order_number IN (select order_id from rpd_shipments)',NULL,FALSE);

		return $this->db->get()->result();
	}

	/**
	* Designation option query
	*/
	private function designation($code){
		$this->db->select('code, title');
		foreach ($code as $k => $v) {
			$this->db->or_where('code', $v);
		}
		return $this->db->get('designation')->result();
	}

	// ========================================================================================================================

		/**
		* Total Outstanding Amount
		**/
		function outstandingreport(){
			$this->data['header_content'] = (object)[
				'title' => 'Payment Outstanding',
				'sub_title' => 'Report',
				'path' => uri_string(),
			];

			$arr = [
				'fromdate' => $this->input->post('fromdate', true),
				'todate' => $this->input->post('todate', true),
				'client' => $this->input->post('client', true),
				'country' => $this->input->post('country', true),
				'state' => $this->input->post('state', true),
				'city' => $this->input->post('city', true),
				'station' => $this->input->post('station', true),
				'zone' => $this->input->post('zone', true),
				'zone_stations' => $this->input->post('zone_stations', true),
			];

			if($_POST){
				$data = [];
				$wqry = '';
				if(empty($arr['zone_stations'])){
					if($arr['zone']){
						$zone = $this->db->select('stations')->where('id', $arr['zone'])->get('zones')->row('stations');
						foreach (json_decode($zone) as $z){
							$wqry = $this->db->or_where('c.station', $z);
						}
					}
				}
				
				$this->db->select('c.id, c.code, c.clientname, c.station')->from('clients as c')->join('invoice as o', 'o.client_id = c.id', 'inner');
				
				if($arr['client'])
					$this->db->where('c.code', $arr['client']);

				if($arr['fromdate'] && $arr['todate'])
					$this->db->where('o.invoice_date BETWEEN "'.date('Y-m-d', strtotime($arr['fromdate'])).'" and "'.date('Y-m-d', strtotime($arr['todate'])).'"');

				if($arr['country'])
					$this->db->where('c.country', $arr['country']);

				if($arr['state'])
					$this->db->where('c.state', $arr['state']);

				if($arr['city'])
					$this->db->where('c.city', $arr['city']);

				if($arr['zone'])
					$wqry;
				
				if($arr['station'])
					$this->db->where('c.station', $arr['station']);

				if($arr['zone_stations'])
					$this->db->where('c.station', $arr['zone_stations']);

				$clients = $this->db->group_by('c.code')->get()->result();

				foreach ($clients as $client) {
					$invoices = $this->db->select('invoice_number, invoice_total, client_id, invoice_date')->where('client_id', $client->id)->group_by('invoice_number')->get('invoice')->result();

					$temp = [
						'name' => $client->clientname,
						'code' => $client->code,
						'station' => $client->station,
					];

					foreach ($invoices as $invoice) {
						$paid = $this->db->select('SUM(paid_amount) as paid')->where('invoice_number', $invoice->invoice_number)->get('payments')->row()->paid;
						$cr_amount = $this->db->select('invoice_total')->where('invoice_number', $invoice->invoice_number)->get('rpd_cradit_invoice')->row()->invoice_total;

						if(empty($cr_amount)){
							$cr_amount = 0;
						}

						$temp['total'] += $invoice->invoice_total;
						$temp['paid'] += $paid; 
						$temp['blc_amount'] +=  $invoice->invoice_total - ($paid + $cr_amount);
					}
					$data[] = $temp;
				}
				$_POST = [];
				$this->data['rows'] = $data;
			}else{
				$this->data['rows'] = '';
			}
			$this->data['arr'] = $arr;
			$this->data['randerPage'] = "reports/payment/total_outstading";
			$this->load->view('_layout', $this->data);
		}
		/**
		* END Total Outstanding Amount
		**/

		function monthlyoutstandingreport(){
			$this->data['header_content'] = (object)[
				'title' => 'RawData',
				'sub_title' => 'Report',
				'path' => uri_string(),
			];

			$arr = [
				'year' => $this->input->post('year', true),
				'client' => $this->input->post('client', true),
				'country' => $this->input->post('country', true),
				'state' => $this->input->post('state', true),
				'city' => $this->input->post('city', true),
				'station' => $this->input->post('station', true),
				'zone' => $this->input->post('zone', true),
				'zone_stations' => $this->input->post('zone_stations', true),
			];

			if($_POST){
				$data = [];
				$wqry = '';
				if(empty($arr['zone_stations'])){
					if($arr['zone']){
						$zone = $this->db->select('stations')->where('id', $arr['zone'])->get('zones')->row('stations');
						foreach (json_decode($zone) as $z){
							$wqry = $this->db->or_where('c.station', $z);
						}
					}
				}
				
				$this->db->select('c.id, c.code, c.clientname, c.station')->from('clients as c')->join('invoice as o', 'o.client_id = c.id', 'inner');
				
				if($arr['client'])
					$this->db->where('c.code', $arr['client']);

				if($arr['year'])
					$this->db->where('YEAR(o.invoice_date)', $arr['year']);

				if($arr['country'])
					$this->db->where('c.country', $arr['country']);

				if($arr['state'])
					$this->db->where('c.state', $arr['state']);

				if($arr['city'])
					$this->db->where('c.city', $arr['city']);

				if($arr['zone'])
					$wqry;
				
				if($arr['station'])
					$this->db->where('c.station', $arr['station']);

				if($arr['zone_stations'])
					$this->db->where('c.station', $arr['zone_stations']);

				$clients = $this->db->group_by('code')->get()->result();

				echo '<pre>';
				foreach ($clients as $client) {
					$temp = [
						'name' => $client->clientname,
						'code' => $client->code,
						'station' => $client->station,
					];

					for($i=1; $i<=12; $i++){
						$temp['months'][] = $client;
					}

					$data[] = $temp;
				}
				print_r($data);
				return;
				$_POST = [];
				$this->data['rows'] = $data;
			}else{
				$this->data['rows'] = '';
			}

			$this->data['arr'] = $arr;
			$this->data['randerPage'] = "reports/payment/yearly_payment_report";
			$this->load->view('_layout', $this->data);
		}


		function LMSD(){
			$this->data['header_content'] = (object)[
				'title' => 'LMSD',
				'sub_title' => 'Report',
				'path' => uri_string(),
			];

			$arr = [
				'last_month' => $this->input->post('old_month', true),
				'cur_month' => $this->input->post('new_month', true),
				'client' => $this->input->post('client', true),
				'country' => $this->input->post('country', true),
				'state' => $this->input->post('state', true),
				'city' => $this->input->post('city', true),
				'station' => $this->input->post('station', true),
				'zone' => $this->input->post('zone', true),
				'zone_stations' => $this->input->post('zone_stations', true),
			];

			if($_POST){
				$data = [];
				$wqry = '';
				if(empty($arr['zone_stations'])){
					if($arr['zone']){
						$zone = $this->db->select('stations')->where('id', $arr['zone'])->get('zones')->row('stations');
						foreach (json_decode($zone) as $z){
							$wqry = $this->db->or_where('c.station', $z);
						}
					}
				}
				
				$this->db->select('c.id, c.code, c.clientname, c.station')->from('clients as c')->join('invoice as o', 'o.client_id = c.id', 'inner');
				
				if($arr['client'])
					$this->db->where('c.code', $arr['client']);

				if($arr['country'])
					$this->db->where('c.country', $arr['country']);

				if($arr['state'])
					$this->db->where('c.state', $arr['state']);

				if($arr['city'])
					$this->db->where('c.city', $arr['city']);

				if($arr['zone'])
					$wqry;
				
				if($arr['station'])
					$this->db->where('c.station', $arr['station']);

				if($arr['zone_stations'])
					$this->db->where('c.station', $arr['zone_stations']);

				$clients = $this->db->group_by('code')->get()->result();

				$old_date = date('Y-m-01', strtotime($this->input->post('old_month').'-01'));
				$new_date = date('Y-m-01', strtotime($this->input->post('new_month').'-01'));
				
				$large_day = (date('t', strtotime($old_date)) > date('t', strtotime($new_date)))?date('t', strtotime($old_date)):date('t', strtotime($new_date));
				
				foreach ($clients as $client) {
					$temp = [
						'name' => $client->clientname,
						'code' => $client->code,
						'station' => $client->station,
					];

					$old = $this->db->select('count(id) as orders, DATE(order_date) as order_date')->where('client_code', $client->id)->where('DATE(order_date) BETWEEN "'.$old_date.'" and "'.date('Y-m-t', strtotime($old_date)).'"')->group_by('DATE(order_date)')->get('orders')->result();
					$new = $this->db->select('count(id) as orders, DATE(order_date) as order_date')->where('client_code', $client->id)->where('DATE(order_date) BETWEEN "'.$new_date.'" and "'.date('Y-m-t', strtotime($new_date)).'"')->group_by('DATE(order_date)')->get('orders')->result();

					$old_days = [];
					$new_days = [];
					for ($i=1; $i <= $large_day; $i++){
						$old_days[sprintf("%02d", $i)] = 0;		
						$new_days[sprintf("%02d", $i)] = 0;		
					}

					if(!empty($old)){
						foreach ($old as $lm) {
							$month = date('Y-m', strtotime($lm->order_date));
							$day = date('d', strtotime($lm->order_date));
							$temp['orders'][$month][$day] = $lm->orders;
						}

						foreach ($temp['orders'][date('Y-m', strtotime($old_date))] as $k => $v) {
							$old_days[$k] = $v;
						}
						$temp['orders'][date('Y-m', strtotime($old_date))] = $old_days;
					}else{
						$temp['orders'][date('Y-m', strtotime($old_date))] = $old_days;
					}


					if(!empty($new)){
						foreach ($new as $lm) {
							$month = date('Y-m', strtotime($lm->order_date));
							$day = date('d', strtotime($lm->order_date));
							$temp['orders'][$month][$day] = $lm->orders;
						}

						foreach ($temp['orders'][date('Y-m', strtotime($new_date))] as $k => $v) {
							$new_days[$k] = $v;
						}
						$temp['orders'][date('Y-m', strtotime($new_date))] = $new_days;
					}else{
						$temp['orders'][date('Y-m', strtotime($new_date))] = $new_days;
					}

					$data[] = $temp;
				}
				$_POST = [];
				$this->data['rows'] = $data;
			}else{
				$this->data['rows'] = '';
			}

			$this->data['arr'] = $arr;
			$this->data['arr']['days'] = $large_day;
			$this->data['randerPage'] = "reports/lmsd";
			$this->load->view('_layout', $this->data);
		}

		function orcp(){
			$this->data['header_content'] = (object)[
				'title' => 'ORCP',
				'sub_title' => 'Report',
				'path' => uri_string(),
			];
			$this->data['rows'] = $this->client_m->getclients();
			$this->data['randerPage'] = "reports/orcp";
			$this->load->view('_layout', $this->data);
		}

		/**
		* Product Redo and Currection Percentage
		*/
		function prcp(){
			$this->data['header_content'] = (object)[
				'title' => 'PRCP',
				'sub_title' => 'Report',
				'path' => uri_string(),
			];

			$products = $this->getproducts();


			$data = [];
			foreach ($products as $product) {

				$data[$product['id']]['data'] = $product;

				if($product['work_type'] == 'new')
					$data[$product['id']]['new'] = $product['total'];
				else if($product['work_type'] == 'redo')
					$data[$product['id']]['redo'] = $product['total'];
				else if($product['work_type'] == 'correction')
					$data[$product['id']]['correction'] = $product['total'];
			}
			$this->data['rows'] = $data;
			$this->data['randerPage'] = "reports/prcp";
			$this->load->view('_layout', $this->data);
		}

		private function getproducts(){
			$res = $this->db->select('p.product_id as id, count(o.id) as total, o.work_type')
			->from('order_products as p')
			->join('orders as o', 'o.id = p.order_id and DATE(order_date) >='.date('Y-m-d', strtotime('-90 days')), 'inner')
			->group_by('p.product_id, o.work_type')
			->get()->result_array();
			return $res;
		}

	function pendingchallans(){
		$this->data['header_content'] = (object)[
			'title' => 'Pending Challans',
			'sub_title' => 'Report',
			'path' => uri_string(),
		];

		if($_POST){
			$m = $this->input->post('month');
			$y = $this->input->post('year');
			if($m > 0 || $m != ''){
				$data = $this->db->where('is_challan', 0)->where('DATE(order_date) >= ', date($y.'-'.sprintf("%02d", $m).'-01'))->where('DATE(order_date) <=', date($y.'-'.sprintf("%02d", $m).'-t'))->get('orders')->result();
			}else{
				$data = $this->db->where('is_challan', 0)->where('DATE(order_date) >= ', date($y.'-01-01'))->where('DATE(order_date) <=', date($y.'-12-t'))->get('orders')->result();
			}
		}else{
			$data = $this->db->where('is_challan', 0)->where('DATE(order_date) >=', date('Y-m-d', strtotime('-90days')))->get('orders')->result();
		}

		$this->data['rows'] = $data;
		$this->data['randerPage'] = "reports/pending_challans";
		$this->load->view('_layout', $this->data);
	}

}
