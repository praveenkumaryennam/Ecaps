<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Analysereports extends CI_Controller {
	function __Construct(){
		parent::__Construct();
		if($this->session->userdata('username') == '')
			redirect('logout');
		
		$this->data['info'] = info(true);

		$this->data['header_content'] = (object)[
			'title' => 'Analysereports',
			'sub_title' => 'Masters',
			'path' => uri_string(),
		];
		$this->data['sidebar'] = (object)[
			'menu' => $this->uri->segment(1),
			'submenu' => $this->uri->segment(2)
		];

		
		$this->data['script'] = $this->uri->segment(1);
		$this->load->library('m_pdf');
		$this->load->model(['client_m','order_m', 'reports_m', 'shipment_m']);
	}

	//Viee Genrated Challans
	function daywisedispachreports(){
		$this->data['randerPage'] = "reports/analyze/daywisedispathreport";
		
		$this->data['arr'] = [
			'fromdate' => date('Y-m-d'),
			'todate' => date('Y-m-d'),
			'client' => ""
		];

		$this->load->view('_layout', $this->data);
	}

	// Get Shipmanets
	function getshipmentsnotes(){
		$start = $this->input->post('start');
		$length = $this->input->post('length');
		$search = $this->input->post('search');
		$fromdate = date('Y-m-d', strtotime($this->input->post('fromdate')));
		$todate = date('Y-m-d', strtotime($this->input->post('todate')));
		$client = $this->input->post('client');

		$rows = $this->shipment_m->getshipmentsnotes(null, ['start' => $start, 'length' => $length, 'search' => $search, 'fromdate' => $fromdate,'todate' => $todate, 'client' => $client]);

		$data = [];
		$i=1;
		foreach ($rows['data'] as $k) {
			if($k->bulk == 1)
				$btn = '<a href="'.base_url('shipment/viewchallan/'.$k->challan_number).'" target="_blank" class="btn btn-flat btn-primary add" style="margin-left: 5px;"><i class="fa fa-print"></i></a>';
			else
				$btn = '<a href="'.base_url('shipment/viewchallan/'.$k->challan_number).'" target="_blank" class="btn btn-flat btn-primary add" style="margin-left: 5px;"><i class="fa fa-print"></i></a>';

			$data[] = [
				$i++,
				$k->order_number,
				date('d-m-Y', strtotime($k->date)),
                date('d-m-Y', strtotime($k->due_date)),
                ucfirst($k->clientname),
                $k->patiant_name,
                get_order_product($k->id),
                $k->modal_no,
                strtoupper(get_order_type($k->id)),
                date('d-m-Y', strtotime($k->due_date)),
                $k->duetime,
                get_order_total($k->id),
                $btn
			];
		}

		$output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => get_count('orders', 3),
            "recordsFiltered" => ($rows['filtered'] > 0)?$rows['filtered']:get_count('orders', 3),
            "data" => $data,
            'asd' => $this->db->last_query()
        );
        
        // Output to JSON format
        echo json_encode($output);		
	}

	/***
	* Day wise Challan Report
	*/
	function dispatchreport(){
		$this->data['header_content'] = (object)[
			'title' => 'DayWise Dispatch',
			'sub_title' => 'Report',
			'path' => uri_string(),
		];

		if($_POST){
			$date = $this->input->post('jobdate', true);
			$this->data['count_jobs'] = $this->reports_m->day_wise_reports(date('Y-m-d', strtotime($date)));
			$this->data['date'] = date('Y-m-d', strtotime($date));
		}else{
			$this->data['date'] = date('Y-m-d');
			$this->data['count_jobs'] = $this->reports_m->day_wise_reports(date('Y-m-d'));
		}


		$this->data['randerPage'] = "reports/day_wise_dispatch_report";
		$this->load->view('_layout', $this->data);
	}


	/***
	* f,m,y-TD Report with multiple filters
	*/
	function daily_analyse_report(){
		$this->data['header_content'] = (object)[
			'title' => 'Daily Analyse',
			'sub_title' => 'Report',
			'path' => uri_string(),
		];
		$arr = [
			'date' => date('Y-m-d', strtotime($this->input->post('date', true))),
			'client' => $this->input->post('client', true),
			'worktype' => $this->input->post('worktype', true),
			'zone' => $this->input->post('zone', true),
			'country' => $this->input->post('country', true),
			'state' => $this->input->post('state', true),
			'city' => $this->input->post('city', true),
			'station' => $this->input->post('station', true),
		];
		
		if($_POST){
			$this->data['rows'] = $this->reports_m->daily_analyse_report($arr);
			$_POST = [];
		}else{
			$this->data['rows'] = '';
		}

		$this->data['arr'] = $arr;

		$this->data['randerPage'] = "reports/daily_analyse_report";
		$this->load->view('_layout', $this->data);
	}


	/***
	* m,y-TD Report with multiple filters
	*/
	function monthly_analyse_report(){
		$this->data['header_content'] = (object)[
			'title' => 'Monthly Analyse',
			'sub_title' => 'Report',
			'path' => uri_string(),
		];
		$arr = [
			'rtype' => $this->input->post('rtype', true),
			'date' => $this->input->post('date', true),
			'client' => $this->input->post('client', true),
			'worktype' => $this->input->post('worktype', true),
			'country' => $this->input->post('country', true),
			'state' => $this->input->post('state', true),
			'city' => $this->input->post('city', true),
			'station' => $this->input->post('station', true),
			'zone' => $this->input->post('zone', true),
			'zone_stations' => $this->input->post('zone_stations', true),
		];
		
		if($_POST){
			$this->data['rows'] = $this->reports_m->monthly_analyse_report($arr);
			$_POST = [];
		}else{
			$this->data['rows'] = '';
		}

		$this->data['arr'] = $arr;

		$this->data['randerPage'] = "reports/monthly_analyse_report";
		$this->load->view('_layout', $this->data);
	}

		/***
	* m,y-TD Report with multiple filters
	*/
	function stations_analyse_report(){
		$this->data['header_content'] = (object)[
			'title' => 'Monthly Analyse',
			'sub_title' => 'Report',
			'path' => uri_string(),
		];
		$arr = [
			'rtype' => $this->input->post('rtype', true),
			'date' => $this->input->post('date', true),
			'client' => $this->input->post('client', true),
			'worktype' => $this->input->post('worktype', true),
			'country' => $this->input->post('country', true),
			'state' => $this->input->post('state', true),
			'city' => $this->input->post('city', true),
			'station' => $this->input->post('station', true),
			'zone' => $this->input->post('zone', true),
			'zone_stations' => $this->input->post('zone_stations', true),
		];
		
		if($_POST){
			$this->data['rows'] = $this->reports_m->stations_analyse_report($arr);

			$_POST = [];
		}else{
			$this->data['rows'] = '';
		}

		$this->data['arr'] = $arr;

		$this->data['randerPage'] = "reports/stations_analyse_report";
		$this->load->view('_layout', $this->data);
	}


	/***
	* Technition Productivity Data
	*/
	function technitialproductivitydata(){
		$this->data['header_content'] = (object)[
			'title' => 'Technition Productivity',
			'sub_title' => 'Report',
			'path' => uri_string(),
		];
		if(!empty($client)){
			$this->data['client'] = urldecode($client);
			$this->data['rows'][urldecode($client)] = $this->technicianproductivitylog(urldecode($client));
		}else{
			$this->data['rows'] = $this->technicianproductivitylog();
			$this->data['client'] = null;
		}

		$this->data['users'] = $this->db->select('username')->get('users')->result();
		$this->data['randerPage'] = "reports/technitialproductivitydata";
		$this->load->view('_layout', $this->data);
	}

	private function technicianproductivitylog(){
		
	}

	/***
	* Getting Monthly Productivity Data 
	*/
	function monthlyproductivitydata($m = false){
		$this->data['header_content'] = (object)[
			'title' => 'Monthly Productivity',
			'sub_title' => 'Report',
			'path' => uri_string(),
		];
		if($m){
			$this->data['rows'] = $this->reports_m->get_monthlyproductivitydata($m);
		}else{
			$m = date('m');
			$this->data['rows'] = $this->reports_m->get_monthlyproductivitydata($m);
		}

		$this->data['m'] = $m;
		$this->data['randerPage'] = "reports/mothly_productivity_data";
		$this->load->view('_layout', $this->data);
	}

	/**
	* Productivity Analyse Reports
	*/
	function productanalyzereport(){
		$this->data['header_content'] = (object)[
			'title' => 'Product Analyse',
			'sub_title' => 'Report',
			'path' => uri_string(),
		];
		$arr = [
			'date' => date('Y-m-d', strtotime($this->input->post('date', true))),
			'product' => $this->input->post('client', true),
			'worktype' => $this->input->post('worktype', true),
			'zone' => $this->input->post('zone', true),
			'country' => $this->input->post('country', true),
			'state' => $this->input->post('state', true),
			'city' => $this->input->post('city', true),
			'station' => $this->input->post('station', true),
		];
		
		if($_POST){
			$this->data['rows'] = $this->reports_m->product_analyse_report($arr);
			$_POST = [];
		}else{
			$this->data['rows'] = '';
		}

		$this->data['arr'] = $arr;

		$this->data['randerPage'] = "reports/analyze/product";
		$this->load->view('_layout', $this->data);
	}

	/**
	* Client Rocking Report
	*/
	function clientrankingreport(){
		$this->data['header_content'] = (object)[
			'title' => 'Doctor Raking',
			'sub_title' => 'Report',
			'path' => uri_string(),
		];
		$arr = [
			'date' => date('Y-m-d', strtotime($this->input->post('date', true))),
			'client' => $this->input->post('client', true),
			'worktype' => $this->input->post('worktype', true),
			'zone' => $this->input->post('zone', true),
			'country' => $this->input->post('country', true),
			'state' => $this->input->post('state', true),
			'city' => $this->input->post('city', true),
			'station' => $this->input->post('station', true),
		];
		
		if($_POST){
			$rows = $this->reports_m->ranking_analyse_report($arr);
			$_POST = [];
			$bmtd = $rows;
			$bytd = $rows;

			usort($bmtd, function($a, $b) {
			    return $a['mtd']->amount <=> $b['mtd']->amount;
			});

			usort($bytd, function($a, $b) {
			    return $a['ytd']->amount <=> $b['ytd']->amount;
			});

			$mtd = [];
			$ytd = [];
			$y = 0;
			$m = 0;

			krsort($bytd);
			foreach ($bytd as $ytd_data) {
				$ytd_data['rank'] = $y+1;		
				$ytd[$y++] = $ytd_data;		
			}

			krsort($bmtd);
			foreach ($bmtd as $mtd_data) {
				$mtd_data['rank'] = $m+1;		
				$mtd[$m++] = $mtd_data;				
			}

			$len = sizeof($rows);
			$fdata = [];
			for($x = 0; $x < $len; $x++){
				$fdata[$x]['mtd']['client'] = $mtd[$x]['client'];  
				$fdata[$x]['mtd']['code'] = $mtd[$x]['code'];
				$fdata[$x]['mtd']['amount'] = $mtd[$x]['mtd']->amount;
				$fdata[$x]['mtd']['rank'] = $mtd[$x]['rank'];

				$fdata[$x]['ytd']['client'] =  $ytd[$x]['client'];
				$fdata[$x]['ytd']['code'] = $ytd[$x]['code'];
				$fdata[$x]['ytd']['amount'] = $ytd[$x]['ytd']->amount;
				$fdata[$x]['ytd']['rank'] = $ytd[$x]['rank'];
			}

			$this->data['rows'] = $fdata;
		}else{
			$this->data['rows'] = '';
		}

		$this->data['arr'] = $arr;

		$this->data['randerPage'] = "reports/analyze/ranking";
		$this->load->view('_layout', $this->data);
	}

	/***
	* Source wise Client Report
	*/
	function sourcewisereport(){
		$this->data['header_content'] = (object)[
			'title' => 'Source Wise',
			'sub_title' => 'Report',
			'path' => uri_string(),
		];
		if($_POST){
			$arr = [
				'fromdate' => date('Y-m-d', strtotime($this->input->post('fromdate'))),
				'todate' => date('Y-m-d', strtotime($this->input->post('todate'))),
				'source' => $this->input->post('source'),
			];
			$this->data['rows'] = $this->reports_m->sourcewisereport($arr['source'], [$arr['fromdate'], $arr['todate']]);
		}else{
			$arr = [
				'fromdate' => date('Y-m-d'),
				'todate' => date('Y-m-d'),
				'client' => null,
			];
			$this->data['rows'] = null;
		}
		$this->data['arr'] = $arr;
		$this->data['randerPage'] = "reports/sourcewisereport";
		$this->load->view('_layout', $this->data);
	}


	/***
	* f,m,y-TD Link Report with multiple filters
	*/
	function index(){
		$this->data['header_content'] = (object)[
			'title' => 'Analyse',
			'sub_title' => 'Report',
			'path' => uri_string(),
		];

		$arr = [
			'date' => date('Y-m-d', strtotime($this->input->post('date', true))),
			'worktype' => $this->input->post('worktype', true),
			'country' => $this->input->post('country', true),
			'rtype' => 1,
		];
		$this->session->set_userdata($arr);
		
		$this->data['table_data'] = 'reports/analyze/link/link_report';
		if($_POST){
			$rows = $this->reports_m->analyse_report($arr);
			$fdata = [];
			foreach ($rows as $r => $v) {
				$temp_data = [];
				$ftd_jobs = 0;
				$ftd_value = 0;
				$ftd_amount = 0;
				$mtd_jobs = 0;
				$mtd_value = 0;
				$mtd_amount = 0;
				$ytd_jobs = 0;
				$ytd_value = 0;
				$ytd_amount = 0;
				$docs = 0;
				$tdocs = 0;
				foreach ($v as $a) {
					$tdocs += 1;
					if($a['ftd']->jobs > 0)
						$docs += 1;

					$ftd_jobs 		+= $a['ftd']->jobs;
					$ftd_value 		+= $a['ftd']->units;
					$ftd_amount 	+= $a['ftd']->amount;
					$mtd_jobs 		+= $a['mtd']->jobs;
					$mtd_value 		+= $a['mtd']->units;
					$mtd_amount 	+= $a['mtd']->amount;
					$ytd_jobs 		+= $a['ytd']->jobs;
					$ytd_value 		+= $a['ytd']->units;
					$ytd_amount 	+= $a['ytd']->amount; 		
				}

				$fdata[] = [
					'state_id' => $r,
					'state' => $this->state_name($r),
					'docs' => $docs, 
					'tdocs' => $tdocs,
					'ftd_jobs' => $ftd_jobs, 
					'ftd_units' => $ftd_value, 
					'ftd_amount' => $ftd_amount, 
					'mtd_jobs' => $mtd_jobs, 
					'mtd_units' => $mtd_value, 
					'mtd_amount' => $mtd_amount, 
					'ytd_jobs' => $ytd_jobs, 
					'ytd_units' => $ytd_value, 
					'ytd_amount' => $ytd_amount, 
				];
			}
			$this->data['rows'] = $fdata;
			$_POST = [];
		}else{
			$this->data['rows'] = '';
		}

		$this->data['arr'] = $arr;
		$this->data['randerPage'] = "reports/analyze/link/index";
		$this->load->view('_layout', $this->data);
	}

	/***
	* Analyse Reports City
	*/
	function city($state){
		$this->data['header_content'] = (object)[
			'title' => 'Analyse',
			'sub_title' => 'Report',
			'path' => uri_string(),
		];
		
		$arr = [
			'date' => $this->session->userdata('date'),
			'worktype' => $this->session->userdata('worktype'),
			'country' => $this->session->userdata('country'),
			'rtype' => $this->session->userdata('rtype'),
			'state' => $state,
		];
		$this->session->set_userdata('state', $state);

		$rows = $this->reports_m->city_analyse_report($arr, $state);

		$fdata = [];
		foreach ($rows as $r => $v) {
			$temp_data = [];
			$ftd_jobs = 0;
			$ftd_value = 0;
			$ftd_amount = 0;
			$mtd_jobs = 0;
			$mtd_value = 0;
			$mtd_amount = 0;
			$ytd_jobs = 0;
			$ytd_value = 0;
			$ytd_amount = 0;
			$docs = 0;
			$tdocs = 0;
			foreach ($v as $a) {
				$tdocs += 1;
				if($a['ftd']->jobs > 0)
					$docs += 1;

				$ftd_jobs 		+= $a['ftd']->jobs;
				$ftd_value 		+= $a['ftd']->units;
				$ftd_amount 	+= $a['ftd']->amount;
				$mtd_jobs 		+= $a['mtd']->jobs;
				$mtd_value 		+= $a['mtd']->units;
				$mtd_amount 	+= $a['mtd']->amount;
				$ytd_jobs 		+= $a['ytd']->jobs;
				$ytd_value 		+= $a['ytd']->units;
				$ytd_amount 	+= $a['ytd']->amount; 		
			}

			$fdata[] = [
				'city_id' => $r,
				'city' => $this->city_name($r),
				'state' => $this->state_name($state),
				'docs' => $docs, 
				'tdocs' => $tdocs,
				'ftd_jobs' => $ftd_jobs, 
				'ftd_units' => $ftd_value, 
				'ftd_amount' => $ftd_amount, 
				'mtd_jobs' => $mtd_jobs, 
				'mtd_units' => $mtd_value, 
				'mtd_amount' => $mtd_amount, 
				'ytd_jobs' => $ytd_jobs, 
				'ytd_units' => $ytd_value, 
				'ytd_amount' => $ytd_amount, 
			];
		}

		$this->data['rows'] = $fdata;
		$_POST = [];

		$this->data['arr'] = $arr;
		$this->data['randerPage'] = "reports/analyze/link/city_report";
		$this->load->view('_layout', $this->data);
	}

	/***
	* Analyse Reports City
	*/
	function stations($city){
		$this->data['header_content'] = (object)[
			'title' => 'Analyse',
			'sub_title' => 'Report',
			'path' => uri_string(),
		];
		
		$arr = [
			'date' => $this->session->userdata('date'),
			'worktype' => $this->session->userdata('worktype'),
			'country' => $this->session->userdata('country'),
			'rtype' => $this->session->userdata('rtype'),
			'state' => $this->session->userdata('state'),
			'city' => $city,
		];
		$this->session->set_userdata('city', $city);

		$rows = $this->reports_m->station_analyse_report($arr, $city);



		$fdata = [];
		foreach ($rows as $r => $v) {
			$temp_data = [];
			$ftd_jobs = 0;
			$ftd_value = 0;
			$ftd_amount = 0;
			$mtd_jobs = 0;
			$mtd_value = 0;
			$mtd_amount = 0;
			$ytd_jobs = 0;
			$ytd_value = 0;
			$ytd_amount = 0;
			$docs = 0;
			$tdocs = 0;
			foreach ($v as $a) {
				$tdocs += 1;
				if($a['ftd']->jobs > 0)
					$docs += 1;

				$ftd_jobs 		+= $a['ftd']->jobs;
				$ftd_value 		+= $a['ftd']->units;
				$ftd_amount 	+= $a['ftd']->amount;
				$mtd_jobs 		+= $a['mtd']->jobs;
				$mtd_value 		+= $a['mtd']->units;
				$mtd_amount 	+= $a['mtd']->amount;
				$ytd_jobs 		+= $a['ytd']->jobs;
				$ytd_value 		+= $a['ytd']->units;
				$ytd_amount 	+= $a['ytd']->amount; 		
			}

			$fdata[] = [
				'station_id' => $r,
				'station' => $this->station_name($r),
				'city' => $this->city_name($city),
				'state' => $this->state_name($arr['state']),
				'docs' => $docs, 
				'tdocs' => $tdocs,
				'ftd_jobs' => $ftd_jobs, 
				'ftd_units' => $ftd_value, 
				'ftd_amount' => $ftd_amount, 
				'mtd_jobs' => $mtd_jobs, 
				'mtd_units' => $mtd_value, 
				'mtd_amount' => $mtd_amount, 
				'ytd_jobs' => $ytd_jobs, 
				'ytd_units' => $ytd_value, 
				'ytd_amount' => $ytd_amount, 
			];
		}
		$this->data['rows'] = $fdata;
		$_POST = [];

		$this->data['arr'] = $arr;
		$this->data['randerPage'] = "reports/analyze/link/station_report";
		$this->load->view('_layout', $this->data);
	}

	/***
	* Analyse Reports City
	*/
	function clients($station){
		$this->data['header_content'] = (object)[
			'title' => 'Analyse',
			'sub_title' => 'Report',
			'path' => uri_string(),
		];
		
		$arr = [
			'date' => $this->session->userdata('date'),
			'worktype' => $this->session->userdata('worktype'),
			'country' => $this->session->userdata('country'),
			'rtype' => $this->session->userdata('rtype'),
			'state' => $this->session->userdata('state'),
			'city' => $this->session->userdata('city'),
			'station' => $station,
		];
		$this->session->set_userdata('station', $station);

		$this->data['rows'] = $this->reports_m->client_analyse_report($arr, $station);
		$_POST = [];

		$this->data['arr'] = $arr;
		$this->data['randerPage'] = "reports/analyze/link/client_report";
		$this->load->view('_layout', $this->data);
	}

	function station_name($station){
		return $this->db->select('station')->where(['id' => $station])->get('stations')->row('station');
	}

	function city_name($city){
		return $this->db->select('city')->where(['id' => $city])->get('cities')->row('city');
	}

	function state_name($id){
		return $this->db->select('state')->where('id', $id)->get('states')->row('state');
	}



	/**
	* bench Markreport
	*/
	function benchmarkreport(){
		$this->data['header_content'] = (object)[
			'title' => 'Reports',
			'sub_title' => 'Masters',
			'path' => uri_string(),
		];

		if($_POST){
			$zone	= $this->input->post('zone', true);
		}else{
			$zone = null;
		}

		$this->data['arr'] = [
			'zone' => $zone,
		];

		$this->data['rows'] = $this->get_benchmarkreport($zone);


		$this->data['randerPage'] = "reports/benchmarkreport";
		$this->load->view('_layout', $this->data);
	}


	private function get_benchmarkreport($zone = false){

		if(!empty($zone)){
			$tem_res = $this->db->where('id', $zone)->get('zones')->row();
			foreach (json_decode($tem_res->stations) as $s){
				$this->db->or_where('c.station', $s);
			}
		}


		$this->db->DISTINCT('i.invoice_number')->DISTINCT('i.invoice_total');
		$this->db->select('i.invoice_number, i.invoice_date, i.invoice_total, c.id, c.clientname, c.code, c.station');
		$this->db->from('clients as c');
		$this->db->join('invoice as i', 'i.client_id = c.id', 'inner');
		$this->db->where('i.invoice_date BETWEEN "'.date('Y-m-01', strtotime('-6 months')).'" and "'.date('Y-m-t').'"');
		$res = $this->db->order_by('invoice_date', 'desc')->get()->result();

		foreach ($res as $v => $k) {
			$arr[$k->id]['invoices'][date('m', strtotime($k->invoice_date))][] = $k->invoice_total;
			$arr[$k->id]['client_id'] = $k->code;
			$arr[$k->id]['id'] = $k->id;
			$arr[$k->id]['clientname'] = $k->clientname;
			$arr[$k->id]['station'] = $k->station;
		}

		foreach ($arr as $key => $value) {
			$total = 0;
			$last_month = 0;
			foreach ($value['invoices'] as $m => $amount) {
				foreach ($amount as $key) {
					$total += $key;
				}
			}

			$last_month = $value['invoices'][date('m', strtotime('-1 months'))];
			$last_month_amount = 0;
			foreach ($last_month as $key) {
				$last_month_amount += $key;
			}


			$current_month_amount = 0;
			$current_month_amount = $this->db->select('SUM(order_value) as amount')
			->where('DATE(order_date) BETWEEN "'.date('Y-m-01').'" and "'.date('Y-m-t').'"')
			->where('client_code', $value['id'])->get('orders')->row('amount');


			$avg = ($total/6);


			$a = ($current_month_amount * 100) / $avg;
			$b = (($current_month_amount * 100) / $last_month_amount);
			$b = (is_infinite($b))?100:$b;

			$days_avg = 100/date('t');
			$days_avg = $days_avg * date('d');

			$temp[] = [
				'client_id' => $value['client_id'],
				'clientname' => $value['clientname'],
				'station' => $value['station'],
				'invoices' => $value['invoices'],
				'six_months' => number_format($total, 2),
				'avg_six_months' => number_format(($total/6), 2), //avg benchmark
				'last_month' => number_format($last_month_amount, 2), //last month
				'current_month' => number_format($current_month_amount, 2), //current month
				'growth_avg_six_months' =>  round($a),
				'growth_avg_last_months' => round($b),
				'growth_avg_last_months2' => round($b-100),
				'cmaa' => round((($current_month_amount*100)/($total/6))),
				'lmsd' => round((($current_month_amount*100)/$last_month_amount)-100)
			];
		}
		return $temp;
	}


	/**
	* bench Markreport
	*/
	function lmsd(){
		$this->data['header_content'] = (object)[
			'title' => 'Reports',
			'sub_title' => 'Masters',
			'path' => uri_string(),
		];

		if($_POST){
			$zone	= $this->input->post('zone', true);
		}else{
			$zone = null;
		}
		
		$this->data['arr'] = [ 'zone' => $zone ];
		$this->data['rows'] = $this->get_lmsd($zone);
		$this->data['randerPage'] = "reports/benchmarkreportlmsd";
		$this->load->view('_layout', $this->data);
	}

	/**
	* lmsd Report
	*/
	private function get_lmsd($zone = false){
		if(!empty($zone)){
			$tem_res = $this->db->where('id', $zone)->get('zones')->row();
			foreach (json_decode($tem_res->stations) as $s){
				$this->db->or_where('c.station', $s);
			}
		}


		$this->db->DISTINCT('i.modal_no');
		$this->db->select('i.modal_no, DATE(i.order_date) as order_date, i.order_value, c.id, c.clientname, c.code, c.station');
		$this->db->from('clients as c');
		$this->db->join('orders as i', 'i.client_code = c.id', 'inner');
		$this->db->where('DATE(i.order_date) >= ', date('Y-m-01', strtotime('-1 months')));
		$this->db->where('DATE(i.order_date) <= ', date('Y-m-d', strtotime('-1 months')));
		$res = $this->db->order_by('order_date', 'desc')->get()->result();

		$arr = [];
		$temp = [];
		foreach ($res as $v => $k) {
			$arr[$k->id]['orders'][date('m', strtotime($k->order_date))][] = $k->order_value;
			$arr[$k->id]['client_id'] = $k->code;
			$arr[$k->id]['id'] = $k->id;
			$arr[$k->id]['clientname'] = $k->clientname;
			$arr[$k->id]['station'] = $k->station;
		}

		foreach ($arr as $key => $value) {
			$total = 0;
			$last_month = 0;
			$last_month_amount = 0;

			foreach ($value['orders'] as $m => $amount) {
				foreach ($amount as $key) {
					$total += $key;
					$last_month_amount += $key;
				}
			}


			$current_month_amount = 0;
			$current_month_amount = $this->db->select('SUM(order_value) as amount')
			->where('DATE(order_date) BETWEEN "'.date('Y-m-01').'" and "'.date('Y-m-d').'"')
			->where('client_code', $value['id'])->get('orders')->row('amount');

			$temp[] = [
				'id' => $value['id'],
				'client_id' => $value['client_id'],
				'clientname' => $value['clientname'],
				'station' => $value['station'],
				'last_month' => number_format($last_month_amount, 2), //last month
				'current_month' => number_format($current_month_amount, 2),
				'cmaa' => round((($current_month_amount*100)/($total/6))),
				'lmsd' => round((($current_month_amount*100)/$last_month_amount)-100)
			];
		}
		return $temp;
	}
}
