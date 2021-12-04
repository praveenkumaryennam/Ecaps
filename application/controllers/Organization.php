<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Organization extends CI_Controller {
	function __Construct(){
		parent::__Construct();
		if($this->session->userdata('username') == '')
			redirect('logout');
		$this->data['info'] = info(true);
		$this->data['header_content'] = (object)[
			'title' => 'Organization',
			'sub_title' => 'Masters',
			'path' => uri_string(),
		];
		$this->data['sidebar'] = (object)[
			'menu' => $this->uri->segment(1),
			'submenu' => $this->uri->segment(2)
		];
		$this->load->model('organigation_m');
		$this->data['script'] = 'organigation';
	}

	/***
	* Dashboard
	*/
	function index(){
		$this->data['randerPage'] = "Dashboard/index";
		$this->load->view('_layout', $this->data);
	}

	/***
	* Add New Company or Get Company Details
	*/
	function company(){
		$this->data['script'] = 'company';
		$this->data['randerPage'] = "organigation/company";
		if($_POST){
			echo $this->organigation_m->companyadd();
			return;
		}
        $this->data['rows'] = $this->organigation_m->companys();
		$this->load->view('_layout', $this->data);
	}

	/***
	* Update Company
	*/
	function updatecompany(){
		$arr = [
			"title" => $this->input->post('name', true),
			"mobile" => $this->input->post('mobile', true),
			"tel" => $this->input->post('tel', true),
			"email" => $this->input->post('email', true),
			"fax" => $this->input->post('fax', true),
			"pan" => $this->input->post('pan', true),
			"gst" => $this->input->post('gst', true),
			"cin" => $this->input->post('cin', true),
			"website" => $this->input->post('website', true),
			"address" => $this->input->post('address', true),
		];
		$this->db->set($arr)->where('id', $this->input->post('eid', true))->update('company');
		if($this->db->affected_rows() > 0)
			echo true;
	}

	/***
	* Add Locations Or Get All Locations
	*/
	function locations(){
		$this->data['randerPage'] = "organigation/location";
		if($_POST){
			echo $this->organigation_m->add('location');
			return;
		}
		$this->data['rows'] = $this->organigation_m->allrows('location');
		$this->load->view('_layout', $this->data);
	}

	/***
	* Add Department Or Get All departments
	*/
	function departments(){
		$this->data['randerPage'] = "organigation/department";
		if($_POST){
			echo $this->organigation_m->add('department');
			return;
		}
		$this->data['rows'] = $this->organigation_m->allrows('department');
		$this->load->view('_layout', $this->data);
	}

	/***
	* Add Department Or Get All departments
	*/
	function refer_by(){
		$this->data['randerPage'] = "clients/referby";
		if($_POST){
			// echo $this->organigation_m->add('department');
			$arr = [
				'title' => $this->input->post('title')
			];
			$this->db->insert('refer_by', $arr);
			return;
		}
		$this->data['rows'] = $this->organigation_m->allrows('refer_by');
		$this->load->view('_layout', $this->data);
	}

	/***
	* Add Designation Or Get All Designation
	*/
	function designations(){
		$this->data['randerPage'] = "organigation/designation";
		if($_POST){
			echo $this->organigation_m->add('designation');
			return;
		}
		$this->data['rows'] = $this->organigation_m->allrows('designation');
		$this->load->view('_layout', $this->data);
	}

	/***
	* Add Role Or Get All Roles
	*/
	function roles(){
		$this->data['randerPage'] = "organigation/role";
		if($_POST){
			echo $this->organigation_m->add('role');
			$_POST = [];
			return;
		}
		$this->data['rows'] = $this->organigation_m->allrows('role');
		$this->load->view('_layout', $this->data);
	}

	/***
	* Add Currection Tamplates Or Get All Currection Tamplates
	*/
	function correctiontemplate(){
		$this->data['randerPage'] = "organigation/correctiontemplate";
		if($_POST){
			echo $this->organigation_m->correction_template_add('correction_template');
			$_POST = [];
			return;
		}
		$this->data['rows'] = $this->organigation_m->allrows('correction_template');
		$this->load->view('_layout', $this->data);
	}

	/***
	* Add Source Or Get All Source
	*/
	function source(){
		$this->data['randerPage'] = "organigation/source";
		if($_POST){
			$arr = [
				"title" => $this->input->post('title', true),
			];
			echo $this->db->insert('source', $arr);
		}
		$this->data['rows'] = $this->organigation_m->allrows('source');
		$this->load->view('_layout', $this->data);
	}

	/***
	* Add Lab Department Or Get All Lab Department
	*/
	function labdepartments(){
		$this->data['randerPage'] = "organigation/labdepartment";
		if($_POST){
			echo $this->organigation_m->add('labdepartment');
			$add = [
				'department' => $this->input->post('code'),
				'password' => '123456',
			];
			$this->db->insert('department_login', $add);
			return;
		}
		$this->data['rows'] = $this->organigation_m->allrows('labdepartment');
		$this->load->view('_layout', $this->data);
	}

	/***
	* Add Country Or Get All Country
	*/
	function countries(){
		$this->data['randerPage'] = "organigation/country";
		if($_POST){
			echo $this->organigation_m->country();
			return;
		}
		$this->data['rows'] = $this->organigation_m->country(true);
		$this->load->view('_layout', $this->data);
	}

	/***
	* Add State Or Get All States
	*/
	function states(){
		$this->data['randerPage'] = "organigation/state";
		if($_POST){
			echo $this->organigation_m->state();
			return;
		}
		$this->data['rows'] = $this->organigation_m->state(true);
		$this->load->view('_layout', $this->data);
	}

	/***
	* Add City Or Get All Cities
	*/
	function cities(){
		$this->data['randerPage'] = "organigation/city";
		if($_POST){
			echo $this->organigation_m->city();
			return;
		}
		$this->data['rows'] = $this->organigation_m->city(true);
		$this->load->view('_layout', $this->data);
	}

	/***
	* Add Station Or Get All Station
	*/
	function Stations(){
		$this->data['randerPage'] = "organigation/station";
		if($_POST){
			echo $this->organigation_m->stations();
			return;
		}
		$this->data['rows'] = $this->organigation_m->stations(true);
		$this->load->view('_layout', $this->data);
	}

	/***
	* Add Qualification Or Get All Qualification
	*/
	function qualifications(){
		$this->data['randerPage'] = "organigation/qualification";
		if($_POST){
			echo $this->organigation_m->add('qualification');
			return;
		}
		$this->data['rows'] = $this->organigation_m->allrows('qualification');	
		$this->load->view('_layout', $this->data);
	}

	/***
	* Get All CountriesOptions
	*/
	function countriesopt(){
		$arr = [
			'sts' => 1,
			'data' => $this->organigation_m->country(true),
		];
		echo json_encode($arr);
	}

	/***
	* Get All StateOptions
	*/
	function statesopt($id){
		$arr = [
			'sts' => 1,
			'data' => $this->organigation_m->state(true, $id),
		];
		echo json_encode($arr);
	}

	/***
	* Get All CityOptions
	*/
	function citiesopt($id){
		$arr = [
			'sts' => 1,
			'data' => $this->organigation_m->city(true, $id),
		];
		echo json_encode($arr);
	}

	/***
	* Update Masters
	*/
	function update(int $id){
		$tbl = $this->input->post('master', true);
		$res = $this->db->where('id', $id)->get($tbl);
		if($res->num_rows() > 0)
			$res = ['sts'=>true, 'data'=>$res->row_array()];
		else
			$res = ['sts'=>false];
		echo json_encode($res);
	}

	/***
	* Update Data
		-- $tbl - Table Name
	*/
	function makechnages(){
		$title = $this->input->post('title');
		$code = $this->input->post('code');
		$id = $this->input->post('eid');
		$tbl = $this->input->post('master');
	
		if(isset($id) && isset($tbl)){
			if($code != "")
				$this->db->set('title', $title)->where(['id'=>$id, 'code'=>$code])->update($tbl);
			else
				$this->db->set('title', $title)->where(['id'=>$id])->update($tbl);

			if($this->db->affected_rows() > 0)
				echo true;
		}
	}

	function delete(){
		$id = $this->input->post('eid');
		$sts = $this->input->post('sts');
		$tbl = $this->input->post('master');
	
		if(isset($id) && isset($tbl)){
			$this->db->set('status', $sts)->where(['id'=>$id])->update($tbl);

			if($this->db->affected_rows() > 0)
				echo true;
		}
	}

	/**
	* Add and getZone List
	*/
	function zones(){
		if($_POST){
			$arr = [
				'zone' => $this->input->post('zone'),
				'stations' => json_encode($this->input->post('stations'))
			];
			if($this->db->insert('zones', $arr)){
				echo true;
				$this->zones_temp();
			}
		}
		$this->data['rows'] = $this->db->get('zones')->result_array();
		$this->data['randerPage'] = "organigation/zones";
		$this->load->view('_layout', $this->data);
	}

	/**
	* Get Zone Wise Stations
	*/
	function zone_stations($id){
		$zone = $this->db->where('id', $id)->get('zones')->row();
		$array = [];
		foreach(json_decode($zone->stations) as $d){
			$array[] = $this->db->where('id', $d)->get('stations')->row('station');
		}
		echo json_encode(['sts'=>true, 'data'=>$array]);
		return;
	}

	function station_validate(){
		$a = $this->input->post('st');
		$res = $this->db->where("id", $a)->get('stations')->num_rows();
		
		if($res > 0){
			echo true;
		}
	}

	function update_zone(){
		$act = $this->input->post('act');
		$a = $this->input->post('st');
		$zone = $this->input->post('zone');

		if($act == 2){
			$s = $this->db->where('id', $zone)->get('zones')->row('stations');
			$arr = json_decode($s);
			$new_arr = [];
			foreach ($arr as $k) {
				if($k != $a){
					$new_arr[] = $k;
				}
			}
			$this->db->set('stations', json_encode($new_arr))->where('id', $zone)->update('zones');
			$this->zones_temp();
		}

		if($act == 1){
			$s = $this->db->where('id', $zone)->get('zones')->row('stations');
			$arr = json_decode($s);
			$arr[] = $a;
			$this->db->set('stations', json_encode($arr))->where('id', $zone)->update('zones');
			$this->zones_temp();
		}
		echo 1;
	}

	/**
	* Zone Info In Excel Import
	*/
	function zone_info($id){
		$zone_data = $this->get_zone_info($id);
		$data['rows'] = $zone_data['data'];
		$data['zone'] = $zone_data['zone'];
		
		$adata = $this->load->view('organigation/zone_info', $data, true);

		header('Content-Type: application/vnd.ms-excel');  
		header('Content-disposition: attachment; filename='.str_replace('-', '_', $data['zone']).'_zone_Information_'.date('Ymd').'.xls');  
		echo $adata;
	}

	private function get_zone_info($id){
		$zone = $this->db->select('stations, zone')->where('id', $id)->get('zones')->row();
		$array = [];
		foreach(json_decode($zone->stations) as $d){
			$array[] = $this->db
			->select('s.station, c.city, s2.state, con.country')
			->from('stations as s')
			->join('cities as c', 'c.id = s.city', 'inner')
			->join('states as s2', 's2.id = s.state', 'inner')
			->join('country as con', 'con.id = s.country', 'inner')
			->where('s.id', $d)->get()->row();
		}
		return ['zone'=>$zone->zone, 'data'=>$array];
	}

	function zones_temp(){
		$this->db->truncate('zone_temp');
		$res = $this->db->get('zones')->result();
		foreach ($res as $z) {
			$id = $z->id;
			$zone = $z->zone;
			foreach (json_decode($z->stations) as $key => $s) {
				$arr = [
					'zone_id' => $id,
					'zone' => $zone,
					'station' => $s
				];
				$this->db->insert('zone_temp', $arr);
			}
		}
	}

	function addIpAddress($ip){
		$data['ip_address'] = $ip;
		if($this->db->insert('iptable', $data)){
			redirect('login');
		}
	}

}
