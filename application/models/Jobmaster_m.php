<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Jobmaster_m extends CI_Model {
	function __constuct(){
		parent::__constuct();
	}

	//ShadeGuide
	function shadeguide(){
		$array = [
			'title' => $this->input->post('title'),
			'code' => $this->input->post('code'),
		];
		if(!$this->check_code($this->input->post('code'), 'shadeguide')){
			return $this->db->insert('shadeguide', $array);
		}else{
			return 1051;
		}
	}

	function get_shadeguide($_is = false){
		if($_is)
			return $this->db->select('title,code')->where('status', 0)->get('shadeguide')->result();
		return $this->db->get('shadeguide')->result();
	}

	//Shades
	function shade(){
		$array = [
			'shadeguide' => $this->input->post('shadeguide'),
			'title' => $this->input->post('title'),
			'code' => $this->input->post('code'),
		];
		return $this->db->insert('shade', $array);
	}

	function get_shades($_is = false){
		return $this->db->select('s.*, sg.title as shadeguide')->where('s.shadeguide = sg.code')->get('shadeguide as sg, shade as s')->result();
	}


	private function check_code($code, $tbl){
		return $this->db->where('code', $code)->get($tbl)->num_rows();
	}
}
