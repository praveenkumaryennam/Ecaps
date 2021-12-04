<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Shipment extends CI_Controller {
	function __Construct(){
		parent::__Construct();
		if($this->session->userdata('username') == '')
			redirect('logout');

		$this->data['info'] = info(true);

		$this->data['header_content'] = (object)[
			'title' => 'Shipment',
			'sub_title' => 'Master',
			'path' => uri_string(),
		];

		$this->data['sidebar'] = (object)[
			'menu' => $this->uri->segment(1),
			'submenu' => $this->uri->segment(2)
		];

		$this->load->model(['client_m','order_m', 'shipment_m']);
		$this->data['script'] = "shipments";
		$this->load->library('excel');
		$this->load->library('m_pdf');
	}

	//Genrate Shipment Notes
	function note(){
		$this->data['randerPage'] = "shipment/note";
		$this->data['rows'] = $this->order_m->get_shipment_orders();
		$this->load->view('_layout', $this->data);
	}

	//Job Card 
	function jobcard($id){
		$this->data['od'] = $this->shipment_m->orderdata($id);
		$this->data['randerPage'] = "shipment/jobcard";
		$this->load->view('shipment/jobcard', $this->data);
	}

	//Get Bulk Orders by Client
	function bulkchallan(){
		$this->data['header_content'] = (object)[
			'title' => 'Bulk Challan',
			'sub_title' => 'Master',
			'path' => uri_string(),
		];

		$this->data['sidebar'] = (object)[
			'menu' => 'bulk',
			'submenu' => ''
		];
		$this->data['client'] = '';
		if($_POST){
			$client = $this->input->post('client');
			$this->data['client'] = $client;
			$this->data['rows'] = $this->order_m->get_bulk_client_shipment_orders($client);
		}
		$this->data['clients'] = $this->get_new_order_clients();
		$this->data['randerPage'] = "bulk/bulkchallan";
		$this->load->view('_layout', $this->data);
	}

	private function get_new_order_clients(){
		return $this->db->select('o.client_code as id, c.clientname')->from('orders as o')->join('clients as c', 'c.id = o.client_code', 'inner')->where('o.is_challan', 0)->where('o.order_number NOT IN (select order_id from rpd_shipments)',NULL,FALSE)->group_by('o.client_code')->get()->result();
	}

	//Genrate Challan
	function bulkchallangenrate(){
		$orders = $this->input->post('bulkorders');
		$this->data['client'] = $this->input->post('client');

		$sdate = $this->input->post('shipmentdate');
		$note = $this->input->post('note');
		$deliverymode = $this->input->post('delivery');
		$order = $this->input->post('bulkorders');
		$cno = $this->get_challan_number();
		$isc = false;
		foreach ($order as $o){
			$arr = [
				'shipment_date' => date('Y-m-d', strtotime($sdate)),
				'shipment_note' => $note,
				'delivery_mode' => $deliverymode,
				'order_id' => $o,
				'challan_number' => $cno,
				'bulk' => 1,
				'added_at' => date('Y-m-d H:i:s'),
				'added_by' => login_user(),
			];
			if($this->db->insert('shipments', $arr)){
				$this->db->set('is_challan', 1)->where('order_number', $o)->update('orders');
				$isc = true;
			}
		}

		if($isc){
			log_data(['text'=>'Challan Genrated', 'data'=> 'Client - '.$this->data['client'], 'data'=>null]);
			echo json_encode(['sts'=>true, 'data'=>base_url().'shipment/viewchallan/'.$cno]);
		}
		else
			echo json_encode(['sts'=>false]);
	}

	//print multiOrder Challan
	function viewchallan($cno){
		$orders = $this->challansorders($cno);
		$this->data['challan'] = $orders;

		foreach($orders as $o){
			$or = $this->db->where('order_number', $o->order_id)->get('orders')->row();
			$this->data['order'][] = [
				'order' => $or,
				'pros' => $this->db->where('order_id', $or->id)->get('order_products')->result_array(),
			];
		}

		$html = $this->load->view("bulk/viewchallan", $this->data, true);
		
		$this->m_pdf->pdf($html, $cno.'_challan_'.time().'.pdf');
	}

	private function challansorders($cno){
		return $this->db->where('challan_number', $cno)->get('shipments')->result();
	}

	function createchallan($id){
		if($this->is_genrated($id) > 0){
			redirect(base_url('shipment/challans'));
		}
		$this->data['randerPage'] = "shipment/challancreate";
		$this->data['rows'] = $this->order_m->get_shipment_orders($id);
		$this->load->view('_layout', $this->data);
	}

	private function is_genrated($oid){
		return $this->db->where('order_id', $oid)->get('shipments')->num_rows();
	}

	//Viee Genrated Challans
	function challans(){
		$this->data['randerPage'] = "shipment/shipmentnotes";
		$this->load->view('_layout', $this->data);
	}

	function getshipmentsnotes(){
		$start = $this->input->post('start');
		$length = $this->input->post('length');
		$search = $this->input->post('search');
		
		$rows = $this->shipment_m->getshipmentsnotes(null, ['start' => $start, 'length' => $length, 'search' => $search]);
		$data = [];
		$i=1;
		foreach ($rows['data'] as $k) {
			if($k->bulk == 1)
				$btn = '<a href="'.base_url('shipment/viewchallan/'.$k->challan_number).'" target="_blank" class="btn btn-flat btn-primary add" style="margin-left: 5px;"><i class="fa fa-print"></i></a>';
			else
				$btn = '<a href="'.base_url('shipment/viewchallan/'.$k->challan_number).'" target="_blank" class="btn btn-flat btn-primary add" style="margin-left: 5px;"><i class="fa fa-print"></i></a>';

			$data[] = [
				$i++,
				$k->order_number,
				date('d-m-Y', strtotime($k->date)),
                date('d-m-Y', strtotime($k->due_date)),
                date('h:i A', strtotime($k->duetime)),
                date('d-m-Y', strtotime($k->shipment_date)),
                $k->challan_number,
                ucfirst($k->clientname),
                $k->patiant_name,
                get_order_product($k->id),
                $k->modal_no,
                strtoupper(get_order_type($k->id)),
                get_order_total($k->id),
                $btn
			];
		}

		$output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => get_count('orders', 3),
            "recordsFiltered" => ($rows['filtered'] > 0)?$rows['filtered']:get_count('orders', 3),
            "data" => $data,
        );
        
        // Output to JSON format
        echo json_encode($output);		
	}


	//Viee Genrated Challans
	function shipingtoday(){
		$arr = [
			'fromdate' => date('Y-m-d'),
			'todate' => date('Y-m-d'),
		];

		$this->data['randerPage'] = "shipment/shipmentnotes";
		$this->data['rows'] = $this->shipment_m->getshipmentsnotes_arr($arr);
		$this->load->view('_layout', $this->data);
	}

	//Viee Genrated Challans
	function shipingreport(){

		if($_POST){
			$arr = [
				'fromdate' => date('Y-m-d', strtotime($this->input->post('fromdate'))),
				'todate' => date('Y-m-d', strtotime($this->input->post('todate'))),
			];
			$this->data['rows']  = $this->shipment_m->getshipmentsnotes_arr($arr);
		}else{
			$arr = [
				'fromdate' => date('Y-m-d'),
				'todate' => date('Y-m-d'),
			];
			$this->data['rows'] = $this->shipment_m->getshipmentsnotes_arr($arr);
		}

		$this->data['arr'] = $arr;
		$this->data['randerPage'] = "shipment/shipingreport";
		$this->load->view('_layout', $this->data);
	}



	//Print Challan
	function printchallan($id){
		$this->data['order'] = $this->db->where('order_number', $id)->get('orders')->row_array();
		$this->data['shipment'] = $this->db->where('order_id', $id)->get('shipments')->row_array();
		$this->data['pros'] = $this->db->where('order_id', $this->data['order']['id'])->get('order_products')->result_array();
		$this->load->view('shipment/challan', $this->data);
	}

	//Single Challan Create
	function addnote(){
		$sdate = $this->input->post('shipmentdate');
		$note = $this->input->post('note');
		$deliverymode = $this->input->post('mode');
		$order = $this->input->post('order');
		$cno = $this->get_challan_number();

		$arr = [
			'shipment_date' => date('Y-m-d', strtotime($sdate)),
			'shipment_note' => $note,
			'delivery_mode' => $deliverymode,
			'order_id' => $order,
			'challan_number' => $cno,
			'added_at' => date('Y-m-d H:i:s'),
			'added_by' => login_user(),
		];


		if($this->db->insert('shipments', $arr)){
			$this->db->set('is_challan', 1)->where('order_number', $order)->update('orders');
			$isc = true;
		}

		if($isc){
			log_data(['text'=>'Challan Genrated for Order : '.$order, 'data'=>null]);
			echo json_encode(['sts'=>true, 'data'=>base_url().'shipment/viewchallan/'.$cno]);
		}
		else
			echo json_encode(['sts'=>false]);
	}

	//Genrate Random Shipments
	private function get_challan_number(){
		$res = $this->db->select('MAX(id) as no')->get('shipments')->row()->no;
		return $res+1;
	}

	/**
	* Print Lab Slip
	*/
	function labslip($order_number){
		
		$res = $this->db->where('order_number', $order_number)->get('labslips');

		if($res->num_rows() > 0){
			$this->view_labslip($res->row());
		}else{
			$arr = [
				'order_number' => $order_number,
				'datetime' => date('Y-m-d H:i:s'),
				'added_at' => date('Y-m-d H:i:s'),
				'added_by' => login_user(),
			];

			if($this->db->insert('labslips', $arr)){
				$this->view_labslip($order_number);
			}else{
				redirect('500');
			}
		}
	}

	private function view_labslip($data){
		$pdf = new \Mpdf\Mpdf(['setAutoTopMargin' => 'stretch']);
		
		$this->data['order'] = $this->db->where('order_number', $data->order_number)->get('orders')->row();
		$this->data['info'] = $data;
		$html = $this->load->view('orders/lab_slip', $this->data, true);
		$pdf->WriteHTML($html);
		$pdf->SetVisibility('screenonly');
		$pdf->Output('invoice_'.time().'.pdf', 'I');
	}
}
