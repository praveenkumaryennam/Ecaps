<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Sales extends CI_Controller {
	function __Construct(){
		parent::__Construct();
		if($this->session->userdata('username') == '')
			redirect('logout');

		$this->data['info'] = info(true);

		$this->data['header_content'] = (object)[
			'title' => 'Sales',
			'sub_title' => 'Master',
			'path' => uri_string(),
		];

		$this->data['sidebar'] = (object)[
			'menu' => $this->uri->segment(1),
			'submenu' => $this->uri->segment(2)
		];

		$this->load->model(['client_m','order_m']);
		$this->data['script'] = "orders";
		$this->load->library('excel');
	}

	function index(){
		$this->data['randerPage'] = "sales/index";
		$this->data['rows']  = $this->order_m->getorders();
		$this->load->view('_layout', $this->data);
	}
}