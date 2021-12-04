<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Payment extends CI_Controller {
	function __Construct(){
		parent::__Construct();
		if($this->session->userdata('username') == '')
			redirect('logout');

		$this->data['info'] = info(true);
 
		$this->data['header_content'] = (object)[
			'title' => 'Payment',
			'sub_title' => '',
			'path' => uri_string(),
		];

		$this->data['sidebar'] = (object)[
			'menu' => $this->uri->segment(1),
			'submenu' => $this->uri->segment(2)
		];

		$this->load->model(['client_m','order_m']);
		$this->data['script'] = "payments";
		$this->load->library('excel');
		$this->load->library('m_pdf');
	}

	function ledger(){
		$this->data['header_content'] = (object)[
			'title' => 'Account',
			'sub_title' => '',
			'path' => uri_string(),
		];
		if($_POST){
			$dates = explode('-', $this->input->post('dates'));
			$arr = [
				'fromdate' => date('Y-m-d', strtotime($this->input->post('fromdate'))),
				'todate' => date('Y-m-d', strtotime($this->input->post('todate'))),
				'client' => $this->input->post('client'),
			];
			$payment = $this->db->select('invoice_number, paid_amount, payment_mode, reference_no, check_no, id, payment_date')->where(['client_code' => $arr['client'], 'payment_date >= ' => $arr['fromdate'],'payment_date <=' => $arr['todate']])->order_by('payment_date')->get('payments')->result();
			$invoice = $this->db->select('invoice_number, invoice_date, invoice_total, order_number')->where(['client_id' => $arr['client'], 'invoice_date >= ' => $arr['fromdate'],'invoice_date <=' => $arr['todate']])->order_by('invoice_date')->get('invoice')->result();


			$dates = $this->dateRange($arr['fromdate'],$arr['todate']);

			$ledger = [];
			foreach($dates as $d){
				foreach($invoice as $i){
					if($i->invoice_date == $d){
						$ledger[$d]['DR'][] = $i;
					}
				}
				foreach($payment as $p){
					if(date('Y-m-d', strtotime($p->payment_date)) == $d){
						$ledger[$d]['CR'][] = $p;
					}
				}
			}

			$this->data['ledger'] = $ledger;
		}else{
			$arr = [
				'fromdate' => date('Y-m-d'),
				'todate' => date('Y-m-d'),
				'client' => null,
			];
		}
		$this->data['arr'] = $arr;
		$this->data['randerPage'] = "payment/ledger";
		$this->load->view('_layout', $this->data);
	}

	function index(){
		$this->data['randerPage'] = "bulk/bulkpayment";
		log_data(['text'=>'Payment Form', 'data'=>null]);
		$this->load->view('_layout', $this->data);
	}

	private function dateRange( $first, $last, $step = '+1 day', $format = 'Y-m-d' ) {
		$dates = array();
		$current = strtotime( $first );
		$last = strtotime( $last );
		while( $current <= $last ) {
			$dates[] = date( $format, $current );
			$current = strtotime( $step, $current );
		}
		return $dates;
	}

	//Single Invice Payment form
	function paynow($invoice_number){
		$this->data['randerPage'] = "payment/index";
		$this->data['in']  = $this->get_invoice($invoice_number);
		$this->data['paid_total'] = $this->paid_total($invoice_number);
		$this->data['payment_rows'] = $this->get_payment_rows($invoice_number);
		log_data(['text'=>'Invoice Payemnt Form', 'data'=>null]);
		$this->load->view('_layout', $this->data);
	}

	//add Payments For Bulk Invoices Only
	function bulkpayment(){
		$id = $this->input->get('client');

		if($_POST){
			$client = $this->input->post('client');
			$amount = $this->input->post('amount');
			$tinvoices = $this->input->post('invoices');
			
			$pending_amount = 0;

			for($z=0; $z < count($tinvoices); $z++) {
				$i = $this->db->select('i.invoice_number, i.invoice_date, i.invoice_total, i.id, i.order_number, (select sum(paid_amount) from rpd_payments where invoice_number = i.invoice_number) as paid')->where('i.invoice_number', $tinvoices[$z][0])->where('client_id', $client)->group_by('i.invoice_number')->order_by('i.invoice_number', 'Desc')->get('invoice as i')->row();
				$is_c = $this->db->where('invoice_number', $i->invoice_number)->get('duplicate_invoice');

				if($is_c->num_rows() > 0) {
					$i->invoice_total = $is_c->row()->invoice_total;
				}else{
					$pending_amount += ($i->invoice_total - $i->paid);
				}

				$blc = ($i->invoice_total - $i->paid);
				if($amount > 0 && $blc > 0){
					$pay = 0;
					if($amount > 0){
						if($amount > $blc){
							$temp = $blc - $amount;
							$amount = abs($temp);
							$pay = $blc;
						}else{
							$temp = $blc - $amount;
							$pay = $blc - $temp;
							$amount -= $pay;
						}
					}

					$arr = [
						"client_code" => $client,
						"invoice_number" => $i->invoice_number,
						"order_id" => $i->order_number,
						"total_amount" => $i->invoice_total,
						"paid_amount" => $pay,
						"blc_amount" => $blc-$pay,
						"payment_mode" => $this->input->post('payment_mode'),
						"reference_no" => $this->input->post('reference_no'),
						"check_no" => $this->input->post('check_no'),
						"bankname" => $this->input->post('bankname'),
						"ifsc_code" => $this->input->post('ifsc_code'),
						"check_date" => $this->input->post('check_date'),
						"payment_date" => date('Y-m-d', strtotime($this->input->post('paydate'))),
						"note" => $this->input->post('note'),
					];

					if($this->db->insert('payments', $arr)){
						$this->db->set('paid', $arr['paid_amount'])->where('invoice_number', $arr['invoice_number'])->update('invoice');
						log_data(['text'=>'Multiple Invoice Payment', 'data'=> $pay.' for invoice '.$i->invoice_number]);
					}
				}

				if($amount > 0)
					$this->db->insert('client_credit', ['client_id' => $client, 'creadit_date' => date('Y-m-d H:i:s') , 'amount' => $amount]);
						log_data(['text'=>'Balance Amount', 'data'=> 'Client - '.$client.' Balance Amount is '.$amount, 'data'=>null]);
			}
		}

		$all_invoices = $this->db->select('i.invoice_number, i.invoice_date, i.invoice_total, i.id, (select sum(paid_amount) from rpd_payments where invoice_number = i.invoice_number) as paid')->where('client_id', $id)->group_by('i.invoice_number')->order_by('i.invoice_number', 'asc')->get('invoice as i')->result();

		foreach ($all_invoices as $mi) {
			$is_c = $this->db->where('invoice_number', $mi->invoice_number)->get('duplicate_invoice');

			if($is_c->num_rows() > 0){
				$mi->invoice_total = $is_c->row()->invoice_total;
			}
			$this->data['invoices'][] = $mi;
		}
		$this->data['client'] = $id;
		$this->data['payment_rows'] = $this->get_payment_rows_by_client($id);
		$this->data['randerPage'] = "payment/partial_payment";
		$this->load->view('_layout', $this->data);
	}

	//Single Invoice Payment
	function payamount($inn){
		$amt = $this->input->post('pamount');
		$in  = $this->get_invoice($inn);
		$paid_total = $this->paid_total($inn);

		$arr = [
			"client_code" => $in->client_id,
			"invoice_number" => $in->invoice_number,
			"order_id" => $in->order_number,
			"total_amount" => $in->invoice_total,
			"paid_amount" => $amt,
			"blc_amount" => ($in->invoice_total - ($paid_total + $amt)),
			"payment_mode" => $this->input->post('payment_mode'),
			"reference_no" => $this->input->post('reference_no'),
			"check_no" => $this->input->post('check_no'),
			"bankname" => $this->input->post('bankname'),
			"ifsc_code" => $this->input->post('ifsc_code'),
			"check_date" => $this->input->post('check_date'),
			"note" => $this->input->post('note'),
			"payment_date" => date('Y-m-d')
		];

		if($this->db->insert('payments', $arr)){
			log_data(['text'=>'Balance Amount', 'data'=> 'Client - '.$in->client_id.' Balance Amount is '.$amt, 'data'=>null]);
			echo true;
		}
	}

	private function paid_total($in){
		$t = $this->db->select('SUM(paid_amount) as total')->where('invoice_number', $in)->get('payments')->row()->total;
		if($t > 0)
			return $t;
		else
			return 0;
	}

	private function get_invoice($in){
		return $this->db->where('invoice_number', $in)->get('invoice')->row();
	}

	private function get_payment_rows($in){
		return $this->db->where('invoice_number', $in)->order_by('id', 'desc')->get('payments')->result();
	}

	private function get_payment_rows_by_client($in){
		return $this->db->where('client_code', $in)->order_by('id', 'desc')->get('payments')->result();
	}







	/***
	* Cradit Note
		-- $id - is invoice Number
	*/
	function creditnote(){
		$this->data['sidebar'] = (object)[
			'menu' => 'orders',
			'submenu' => ''
		];

		$this->data['rows'] = $this->get_duplicate_invoices();
		$this->data['randerPage'] = "payment/create_cradit";
		log_data(['text'=>'Payment Form', 'data'=>null]);
		$this->load->view('_layout', $this->data);
	}

	function get_duplicate_invoices(){
		return $this->db->select('di.*, i.invoice_date, i.client_id, c.*')->where('i.invoice_number = di.invoice_number')->where('i.invoice_number = c.invoice_number')->group_by('i.invoice_number')->order_by('c.id', 'desc')->get('duplicate_invoice as di, invoice as i, cradit_invoice as c')->result();
	}

	function makecreditnote(){
		$id = $this->input->get_post('invoice');
		if($id){
			$is_exits = $this->db->where('invoice_number', $id)->get('duplicate_invoice');
			if($is_exits->num_rows() > 0){
				redirect(base_url().'payment/creditnote');
				return ;
			}else{
				if(check_invoice_valid($id) > 0){
					$invoice = $this->db->where('invoice_number', $id)->get('invoice')->result();
					$pro = $this->db->where('invoice_number', $id)->get('invoice_product')->result();
					log_data(['text'=>'Cradit Note - '.$id, 'data' => null]);
					$this->data['randerPage'] = 'payment/cradit_note_form';
					$this->load->view('payment/cradit_note_form', ['invoice'=>$invoice, 'pros'=>$pro]);
				}else{
					redirect(base_url().'payment/creditnote');
				}
			}
		}else{
			$this->load->view('404');
		}
	}

	function genratecreditnote(){

		$size = sizeof($_POST['order_id']);
		
		$cdate = $this->input->post('cdate');
		$cno = $this->input->post('cno');

		$units = $this->input->post('tunits');
		$subtotal = $this->input->post('subtotal');

		$igst = $this->input->post('igst');
		$cgst = $this->input->post('cgst');
		$sgst = $this->input->post('sgst');
		$igst_amt = (($subtotal * $igst)/100);
		$cgst_amt = (($subtotal * $cgst)/100);
		$sgst_amt = (($subtotal * $sgst)/100);

		$total_gst = $igst + $cgst + $sgst;
		$invoice_gst_amt = ($igst_amt + $cgst_amt + $sgst_amt);

		$arr = [
			'invoice_number' => $this->input->post('invoice'),
			'units' => $this->input->post('tunits'),
			'invoice_subtotal' => $this->input->post('subtotal'),
			'invoice_gst_amt' => $invoice_gst_amt,
			'invoice_gst' => $total_gst,
			'igst' => $igst,
			'cgst' => $cgst,
			'sgst' => $sgst,
			'invoice_total' => $this->input->post('total'),
		];

		if($this->db->insert('duplicate_invoice', $arr)){
			for($i =0; $i<$size; $i++){
				$bprice = $this->input->post('bprice['.$i.']');
				$price = $this->input->post('price['.$i.']');
				$unit = $this->input->post('unit['.$i.']');

				$p = [
					'invoice_product_id' => $this->input->post('product_id['.$i.']'),
					'invoice_number' => $this->input->post('invoice'),
					'order_id' => $this->input->post('order_id['.$i.']'),
					'unit' => $unit,
					'base_price' => $bprice,
					'unit_price' => $price,
					'discount' => 0,
					'subtotal' => $price * $unit,	
					'total' => $price * $unit,
				];
				$this->db->insert('duplicate_invoice_products', $p);
			}
			if($this->insert_cradit_products($size))
				redirect(base_url().'payment/creditnote');
		}
	}

	private function insert_cradit_products($size){		
		$tunit = 0;
		$isprice = 0;
		for($i =0; $i<$size; $i++){
			$price = $this->input->post('price['.$i.']');
			$oldprice = $this->input->post('old_unitprice['.$i.']');
			$unit = $this->input->post('unit['.$i.']');

			if($oldprice != $price){
				$tunit++;
				$isprice += (($oldprice - $price)*$unit);
			}
		}

		$igst = $this->input->post('igst');
		$cgst = $this->input->post('cgst');
		$sgst = $this->input->post('sgst');
		$igst_amt = (($isprice * $igst)/100);
		$cgst_amt = (($isprice * $cgst)/100);
		$sgst_amt = (($isprice * $sgst)/100);

		$total_gst = $igst + $cgst + $sgst;
		$invoice_gst_amt = ($igst_amt + $cgst_amt + $sgst_amt);

		$arr = [
			'invoice_number' => $this->input->post('invoice'),
			'units' => $tunit,
			'invoice_subtotal' => $isprice,
			'invoice_gst_amt' => $invoice_gst_amt,
			'invoice_gst' => $total_gst,
			'igst' => $igst,
			'cgst' => $cgst,
			'sgst' => $sgst,
			'invoice_total' => ($isprice + $invoice_gst_amt),
			'remark' => $this->input->post('remark', true),
			// 'cradit_no' => rand(99999, 00000),
			'cradit_date' => date('Y-m-d', strtotime($this->input->post('cdate'))),
			'cradit_no' => $this->input->post('cno'),
		];

		if($this->db->insert('cradit_invoice', $arr)){
			for($i =0; $i<$size; $i++){
				$bprice = $this->input->post('bprice['.$i.']');
				$price = $this->input->post('price['.$i.']');
				$oldprice = $this->input->post('old_unitprice['.$i.']');

				if($oldprice != $price){
					$unit = $this->input->post('unit['.$i.']');
					$p = [
						'invoice_product_id' => $this->input->post('product_id['.$i.']'),
						'invoice_number' => $this->input->post('invoice'),
						'order_id' => $this->input->post('order_id['.$i.']'),
						'unit' => $unit,
						'base_price' => $bprice,
						'unit_price' => $price,
						'discount' => 0,
						'subtotal' => ($bprice * $unit)-($price * $unit),
						'cradit_amt' => ($bprice - $price),
						'total' => ($bprice * $unit)-($price * $unit),
					];

					$this->db->insert('cradit_invoice_products', $p);
				}
			}
		}
		return true;
	}



	/***
	* Print Invoice
	*/
	function printinvoice($invoice_number){
		$invoice = $this->db->select('i.client_id, i.invoice_number, i.invoice_date, i.order_id, i.order_number, , i.order_date, i.patiant, di.invoice_total, di.units, di.invoice_subtotal, di.invoice_gst_amt as invoice_gst_amount, di.invoice_gst, di.igst, di.cgst, di.sgst')->where('di.invoice_number = i.invoice_number')->where('i.invoice_number', $invoice_number)->get('duplicate_invoice as di, invoice as i')->result();

		$pro = $this->db->select('ip.order_id, ip.product, dip.unit, dip.unit_price as unitprice, dip.base_price, dip.subtotal')->where('ip.id = dip.invoice_product_id')->where('ip.invoice_number', $invoice_number)->get('invoice_product as ip, duplicate_invoice_products as dip')->result();
		$html = $this->load->view('payment/print_invoice', ['invoice'=>$invoice, 'pros'=>$pro], true);
		$this->m_pdf->pdf($html, 'invoice_'.$invoice_number.'_'.time().'.pdf');
	}

	/***
	* Print Cradit Note
	*/
	function printcreaditnot($invoice_number){
		$invoice = $this->db->select('di.cradit_no, di.remark, di.cradit_date, i.client_id, i.invoice_number, i.invoice_date, i.order_id, i.order_number, , i.order_date, i.patiant, di.invoice_total, di.units, di.invoice_subtotal, di.invoice_gst_amt as invoice_gst_amount, di.invoice_gst, di.igst, di.cgst, di.sgst')->where('di.invoice_number = i.invoice_number')->where('i.invoice_number', $invoice_number)->get('cradit_invoice as di, invoice as i')->result();

		$pro = $this->db->select('ip.order_id, ip.product, dip.unit, dip.unit_price as unitprice, dip.base_price, dip.subtotal, dip.cradit_amt')->where('ip.id = dip.invoice_product_id')->where('ip.invoice_number', $invoice_number)->get('invoice_product as ip, cradit_invoice_products as dip')->result();
		$html = $this->load->view('payment/cradit_not_print', ['invoice'=>$invoice, 'pros'=>$pro], true);
		
		$this->m_pdf->pdf($html, 'invoice_'.$invoice_number.'_'.time().'.pdf');
	}


}
