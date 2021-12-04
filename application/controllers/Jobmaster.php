<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Jobmaster extends CI_Controller {
	function __Construct(){
		parent::__Construct();
		if($this->session->userdata('username') == '')
			redirect('logout');
		$this->data['info'] = info(true);
		$this->data['header_content'] = (object)[
			'title' => 'Job',
			'sub_title' => 'Masters',
			'path' => uri_string(),
		];
		$this->data['sidebar'] = (object)[
			'menu' => $this->uri->segment(1),
			'submenu' => $this->uri->segment(2)
		];
		$this->load->model('jobmaster_m');
		$this->data['script'] = "jobmaster";
	}
	//Add ShadeGuide
	function shadeguide(){
		$this->data['randerPage'] = "jobmaster/shadeguide";
		$this->data['rows'] = $this->jobmaster_m->get_shadeguide();		
		if($_POST){
			if($this->jobmaster_m->shadeguide()){
				$this->responce(true, 'added', 200);
			}else{
				$this->responce(false, 'error', 404);
			}
			return;
		}
		$this->load->view('_layout', $this->data);
	}
	//Add Shades
	function shade(){
		$this->data['randerPage'] = "jobmaster/shade";
		$this->data['shadeguide'] = $this->jobmaster_m->get_shadeguide(true);		
		$this->data['rows'] = $this->jobmaster_m->get_shades();		
		if($_POST){
			$res = $this->jobmaster_m->shade();
			if($res == 1){
				$this->responce(true, 'added', 200);
			}else{
				$this->responce(false, error($res), 404);
			}
			return;
		}
		$this->load->view('_layout', $this->data);
	}
	private function responce($status, $msg, $responce){
		echo json_encode(['status'=>$status, 'msg'=>$msg, 'responce'=>$responce]);
		return;
	}
}