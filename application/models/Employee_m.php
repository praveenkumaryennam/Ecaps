<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Employee_m extends CI_Model {
	function __constuct(){
		parent::__constuct();
	}

	function get(){
		return $this->db->distinct()->select('e.id, e.firstname, e.middlename, e.code, e.lastname, e.email, e.mobile, e.gender, l.title as location, d.title as designation, e.status')
		->from('employee as e')
		->join('location as l', 'l.code = e.location', 'left')
		->join('designation as d', 'd.code = e.designation', 'left')
		->order_by('e.code', 'asc')
		->get()->result();
	}

	function add($data){
		if($this->db->insert('employee', $data['emp'])){
			$id = $this->db->insert_id();
			$this->add_family($id, $data['family']);
			if($this->createlogin($id)) return true;
		}
		return false;
	}

	function update($data, $id){
		if($this->db->set($data['emp'])->where('id', $id)->update('employee')){
			$this->update_family($id, $data['family']);
			return true;
		}
		return false;
	}

	function getemployee($id){
		return $this->db->where('id', $id)->order_by('id', 'desc')->get('employee')->row();
	}

	function getempfamily($id){
		return $this->db->where('emp_id', $id)->get('employee_family')->result();
	}

	private function add_family($empid, $data){
		for($i=0; $i< sizeof($data['name']);$i++){
			$arr = [
				'emp_id' => $empid,
				'name' => $data['name'][$i],
				'dob' => date('Y-m-d', strtotime($data['dob'][$i])),
				'gender' => $data['gender'][$i],
				'relation' => $data['relation'][$i],
			];
			$this->db->insert('employee_family', $arr);
		}
	}

	private function update_family($empid, $data){
		for($i=0; $i< sizeof($data['name']);$i++){
			$arr = [
				'name' => $data['name'][$i],
				'dob' => date('Y-m-d', strtotime(str_replace('/', '-', $data['dob'][$i]))),
				'gender' => $data['gender'][$i],
				'relation' => $data['relation'][$i],
			];

			if(!empty($data['lid'][$i])){
				$this->db->set($arr)->where('emp_id',$empid)->where('id', $data['lid'][$i])->update('employee_family');
			}else{
				$arr['emp_id'] = $empid;
				$this->db->insert('employee_family', $arr);
			}

		}
	}

	private function createlogin($id){
		$res = $this->db->where('id',$id)->get('employee')->row();
		$arr = [
			'username' => $res->firstname,
			'password' => $res->code,
			'empid' => $res->code,
			'role' => $res->role,
		];
		return $this->db->insert('users', $arr);
	}
}
