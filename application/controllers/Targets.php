
<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Targets extends CI_Controller {
	function __Construct(){
		parent::__Construct();
		$this->output->set_header('Last-Modified:' . gmdate('D, d M Y H:i:s') . 'GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
        $this->output->set_header('Cache-Control: post-check=0, pre-check=0', false);
        $this->output->set_header('Pragma: no-cache');
		if($this->session->userdata('username') == '')
			redirect('logout');

		$this->data['info'] = info(true);

		$this->data['header_content'] = (object)[
			'title' => 'Targets',
			'sub_title' => 'Masters',
			'path' => uri_string(),
		];

		$this->data['sidebar'] = (object)[
			'menu' => 'employee',
			'submenu' => 'targets'
		];

		$this->load->model(['client_m','targets_m']);
		$this->data['script'] = "targets";
		
		if(date('d') == 1){
			$this->init_target();
		}
	}

	/**
	* Check Targte Assigned To Employee, else on every month day one, function executes. 
	*/
	function init_target(){
		$year = (date('m') == 1)?(date('Y')-1):date('Y');
		$month = (date('m') == 1)?12:date('m');
		$check_target_assigned = $this->db->where(['year' => $year, 'month' => $month])->get('employee_target')->num_rows();

		if($check_target_assigned == 0){
			$data_set = $this->db->select('type, month, year, employee_code, is_type, demp, target, incentive, set_by')->where(['year' => $year, 'month' => date('m', strtotime('-months'))])->get('employee_target')->result_array();
			
			foreach ($data_set as $row) {
				$data = [
					'type' => $row['type'],
					'month' => $month,
					'year' => date('Y'),
					'employee_code' => $row['employee_code'],
					'is_type' => $row['is_type'],
					'demp' => $row['demp'],
					'target' => $row['target'],
					'incentive' => $row['incentive'],
					'datetime' => date('Y-m-d H:i:s'),
					'set_by' => $row['set_by'],
				];
				$this->db->insert('employee_target', $data);
				echo $data['employee_code'].' => Done <br/>';
			}
			redirect(base_url('view'));
		}
	}
	/**
	* Main page And List View
	*/
	function index(){
		$this->data['randerPage'] = "targets/index";
		$this->data['designation'] = $this->designation(['CTEC', 'TECH']);
		$this->load->view('_layout', $this->data);
	}

	/**
	* View Target Data By Month and designation Wise
	*/
	function view(){
		if($_POST){
			$mon = $this->input->post('month', true);
			$year = $this->input->post('year', true);
			$department = $this->input->post('department', true);
			$desig = $this->input->post('designation', true);
			
			$this->data = [
				'mon' => $mon,
				'year' => $year,
				'department' => $department,
				'desig' => $desig
			];

			$this->data['rows'] = $this->get_target_view_data($mon, $year, $desig, $department);

		}

		$this->data['randerPage'] = "targets/view";
		$this->data['designation'] = $this->designation(['CTEC', 'TECH']);
		$this->load->view('_layout', $this->data);
	}

	/**
	* Set Target
	*/
	function set_target(){
		$code = $this->input->post('code', true);
		$target = $this->input->post('target', true);
		$incentive = $this->input->post('incentive', true);
		$type = $this->input->post('type', true);
		$month = $this->input->post('month', true);
		$year = $this->input->post('year', true);
		$department = $this->input->post('department', true);


		$arr = [
			'employee_code' => $code,
			'target' => $target,
			'incentive' => $incentive,
			'is_type' => $type,
			'type' => 1,
			'month' => $month,
			'year' => $year,
			'demp' => $department,
			'set_by' => login_user(),
			'datetime' => date('Y-m-d H:i:s')
		];

		$target_id = $this->check_target_set($code, $month, $year, $department);
		$this->db->set('status', 1)->where(['month' => $month, 'year' => $year, 'employee_code' => $code, 'demp'=>$department, 'status' => 0])->update('employee_target');

		if($this->db->insert('employee_target', $arr)){
			echo json_encode(['sts' => 1, 'data'=>"Target Set, Successfully"]);
		}else{
			echo json_encode(['sts' => 0, 'data'=>"Try again.!"]);
		}
	}

	/**
	* Check is Seted target 
	*/
	private function check_target_set($code, $month, $department){
		$res = $this->db->select('id')->where(['employee_code' => $code, 'month' => $month, 'demp'=>$department, 'status' => 0])->get('employee_target');
		if($res->num_rows() > 0)
			return $res->row('id');
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

	/**
	* Get Employee By Designation
	*/
	function employees(){
		$code = $this->input->post('code');
		$month = $this->input->post('month');
		$year = $this->input->post('year');
		$department = $this->input->post('department');

		$res = $this->db->select('id, CONCAT(firstname, " ", lastname) as name, code')->where('lab_department', $department)->where('status', 0)->get('employee')->result();

		$data = [];
		foreach ($res as $key){
			$t = $this->targets_data($key->id, $month, $year, $department);

			$data[] = [
				'id' => $key->id,
				'name' => $key->name,
				'code' => $key->code,
				'month' => $t->month,
				'is_type' => $t->is_type,
				'dep' => $t->dep,
				'target' => $t->target,
				'incentive' => $t->incentive
			];
		}
		echo json_encode(['sts'=>1, 'data'=>$data]);
	}

	/**
	* Target Data by Month and employee ID
	*/
	private function targets_data($id, $month, $year, $department){
		return $this->db->select('demp, is_type, target, incentive, month, datetime')->where(['employee_code' => $id, 'month' => $month, 'year' => $year,  'demp' => $department, 'status' => 0])->get('employee_target')->row();
	}

	/**
	* Get all Employees target Data By Designation and month 
	*/
	private function get_target_view_data($month, $year, $desig, $department){
		$res = $this->db->select('id, CONCAT(firstname, " ", lastname) as name, code')->where('lab_department', $department)->get('employee')->result();
		$data = [];
		foreach ($res as $key){
			$t = $this->targets_data($key->id, $month, $year, $department);

			$data[] = [
				'id' => $key->id,
				'name' => $key->name,
				'code' => $key->code,
				'month' => $t->month,
				'dep' => $t->demp,
				'is_type' => strtoupper($t->is_type),
				'target' => $t->target,
				'incentive' => $t->incentive,
				'date' => $t->datetime,
			];
		}
		return $data;
	}

}
