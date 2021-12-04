<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	function __Construct(){
		parent::__Construct();
		if($this->session->userdata('username') == '')
			redirect('logout');

		$this->data['info'] = info(true);

		$this->data['header_content'] = (object)[
			'title' => ucfirst($this->session->userdata['username']),
			'sub_title' => 'Dashboard',
			'path' => uri_string(),
		];

		$this->data['sidebar'] = (object)[
			'menu' => $this->uri->segment(1),
			'submenu' => $this->uri->segment(2)
		];
	}

	/***
	* Load Default Dashboard View 
	*/
	function index(){
		if($this->session->userdata('role') == 'emp')
			$this->data['randerPage'] = "dashboard/employeeDashboard";
		else
			$this->data['randerPage'] = "dashboard/index";
		$this->load->view('_layout', $this->data);
	}

	function carddata($_for){
		if($_for > 0 && $_for <= 3){
			$arr =[
				'employee' => get_count('employee', 3),
				'clients' => get_count('clients', 3),
				'product' => get_count('product', 3),
				'orders' => get_count('orders', 3),
				'new_orders' => get_order_count('new', $_for),
				'redo_orders' => get_order_count('redo', $_for),
				'correction_order' => get_order_count('correction', $_for),
				'total_invoices' => total_invoices($_for),
				'total_challans' => total_challans($_for),
				'total_invoice_amount' => number_format(total_invoice_amount($_for), 2),
			];
			echo json_encode($arr);
		}
	}
}