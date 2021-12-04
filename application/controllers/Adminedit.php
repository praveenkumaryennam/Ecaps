<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Adminedit extends CI_Controller {
	function __Construct(){
		parent::__Construct();
	}

	function index(){
		$this->load->view('admin/index.php');
	}
	
	function orders(){
		$order_number = $this->input->post('order_number', true);
		$code = $this->input->post('code', true);
		$col = $this->input->post('col', true);

		$id = $this->db->select('id')->where('code', $code)->get('clients')->row('id');

		$this->db->set($col, $id)->where('order_number', $order_number)->update('orders');
		redirect(base_url('adminedit'));
	}

}
