<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Validate extends CI_Controller {
	function __Construct(){
		parent::__Construct();
		$this->load->library('m_pdf');
		$this->data['info'] = info(true);
	}

	function warrantycard(){
		if($_POST){
			$id = $this->input->post('wc', true);
			$this->data['card_data'] = $this->db->where('warrenty_code', $id)->get('warrenty_card')->row();
			if(!empty($this->data['card_data'])){
		        $html = $this->load->view('productmaster/warrenty_card_print', $this->data, true);
		        $this->m_pdf->pdf($html, $id.'_invoice_'.time().'.pdf');
			}else{
				echo 'Invalid Warranty Card';
			}
		}

		$this->load->view('wc');
	}
}