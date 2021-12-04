<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Process extends CI_Controller {
	function __Construct(){
		parent::__Construct();
		if($this->session->userdata('username') == '')
			redirect('logout');

		$this->data['info'] = info(true);

		$this->data['header_content'] = (object)[
			'title' => 'Procee',
			'sub_title' => 'Masters',
			'path' => uri_string(),
		];

		$this->data['sidebar'] = (object)[
			'menu' => $this->uri->segment(1),
			'submenu' => $this->uri->segment(2)
		];
	}

	function index(){
		if($_POST){
			$arr = [
				'fromdate' => date('Y-m-d', strtotime($this->input->post('fromdate'))),
				'todate' => date('Y-m-d', strtotime($this->input->post('todate'))),
				'dep' => $this->input->post('dep'),
			];
			$this->data['logs'] = $this->getalltrys($arr);
		}else{
			$arr = [
				'fromdate' => date('Y-m-d'),
				'todate' => date('Y-m-d'),
				'dep' => null,
			];
		}
		$this->data['arr'] = $arr;
		$this->data['randerPage'] = "process/index";
		$this->load->view('_layout', $this->data);
	}


	function trylog($tryno){
		$this->data['logdata'] = $this->trylogdata($tryno);
		$this->data['randerPage'] = "process/trylog";
		$this->load->view('_layout', $this->data);
	}

	private function getalltrys($arr){
		if($arr['fromdate'])
			$this->db->where('DATE(in_datetime)', date('Y-m-d', strtotime($arr['fromdate'])));
		if($arr['todate'])
			$this->db->where('DATE(in_datetime)', date('Y-m-d', strtotime($arr['todate'])));
		if($arr['dep'])
			$this->db->where('department', $arr['dep']);
		
		return $this->db->order_by('id', 'asc')->group_by('tryno')->get('process')->result();
	}

	private function trylogdata($tryno){
		return $this->db->where('tryno', $tryno)->order_by('id', 'asc')->get('process')->result();
	}
}
