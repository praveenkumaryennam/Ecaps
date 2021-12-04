
<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Ordertransfer extends CI_Controller {
	function __Construct(){
		parent::__Construct();
		if($this->session->userdata('username') == '')
			redirect('logout');

		$this->data['info'] = info(true);

		$this->data['header_content'] = (object)[
			'title' => 'Order Transfer',//ucfirst($this->session->userdata['username']),
			'sub_title' => '',
			'path' => uri_string(),
		];

		$this->data['sidebar'] = (object)[
			'menu' => $this->uri->segment(1),
			'submenu' => $this->uri->segment(2)
		];
		$this->sdb = $this->load->database('sdb', TRUE);
	}

	function index(){
		$this->data['istrans'] = false;

		if($_POST){
			$id = $this->input->post('orderno');
			$result = $this->getmyorder($id);
			
			if(!empty($result)){
				if($this->insertdata($result)){
					$url = $this->getmyorderdelete($id);
					$_POST = [];
					$this->data['istrans'] = true;
					$this->data['randerPage'] = "bulk/order_trasfer";
					$this->load->view('_layout', $this->data);
				}
			}
		}

		$this->data['randerPage'] = "bulk/order_trasfer";
		$this->load->view('_layout', $this->data);
	}


	//Insert Data into table
	private function insertdata($result){
		$order = [
			'order_number' => $this->ordernumber(),
			'client_code' => $result['order']->client_code,
			'patiant_name' => $result['order']->patiant_name,
			'patient_age' => $result['order']->patient_age,
			'modal_no' => $result['order']->modal_no,
			'order_date' => $result['order']->order_date,
			'due_date' => $result['order']->due_date,
			'in_date' => $result['order']->in_date,
			'duetime' => $result['order']->duetime,
			'intime' => $result['order']->intime,
			'amount' => $result['order']->amount,
			'add_amount' => $result['order']->add_amount,
			'delivery_method' => $result['order']->delivery_method,
			'correction_tamp' => $result['order']->correction_tamp, 
			'order_status' => $result['order']->order_status,
			'order_priority' => $result['order']->order_priority,
			'note' => $result['order']->note,
			'pan_try' => $result['order']->pan_try,
			'assign' => $result['order']->assign,
			'manufacture' => $result['order']->manufacture,
			'department' => $result['order']->department,
			'work_type' => $result['order']->work_type,
			'enclosure' => $result['order']->enclosure,
			'doctor' => $result['order']->doctor,
			'location' => $result['order']->location,
			'shade_one' => $result['order']->shade_one,
			'shade_two' => $result['order']->shade_two,
			'shade_three' => $result['order']->shade_three,
			'shade_note' => $result['order']->shade_note,
			'articulary_tag' => $result['order']->articulary_tag,
			'added_at' => $result['order']->added_at,
			'added_by' => $result['order']->added_by,
		];

		if($this->db->insert('orders', $order)){
			$id = $this->db->insert_id();
			foreach($result['order_product'] as $r){
				$arr = [
					'order_id' => $id,
					'product_id' => $r->product_id,
					'product_type' => $r->product_type,
					'product_category' => $r->product_category,
					'teeth' => $r->teeth,
					'unit' => $r->unit,
					'unit_price' => $r->unit_price,
					'discount' => $r->discount,
					'total_amount' => $r->total_amount,
					'options' => $r->options,
				];
				$this->db->insert('order_products', $arr);
			}

			foreach($result['order_schadule'] as $a){
				$arr = [
					'order_id' => $id,
					'title' => $a->title,
					'sch_date' => null,//date('Y-m-d', strtotime(str_replace('/','-',$data['schedules'][$j]['date']))),
					'status' => null//$data['schedules'][$j]['sts'],
				];
				$this->db->insert('order_schadules', $arr);
			}
			return true;
		}else{
			return false;
		}
	}

	//Genrate Radom Order Number
	private function ordernumber(){
		$id = $this->db->select_max('id')->get('orders')->row()->id;
		$id+= 1;
		return 'O'.date('Ymd').$id;
	}

	//escaps
	function getmyorder($id){
		$data = $this->sdb->where('order_number', $id)->get('orders');
		if($data->num_rows() > 0){
			$data = $data->row();
			$op = $this->sdb->where('order_id', $data->id)->get('order_products')->result();
			$os = $this->sdb->where('order_id', $data->id)->get('order_schadules')->result();
		}
		return ['order' => $data, 'order_product' => $op, 'order_schadule' => $os];
	}

	function getmyorderdelete($id){
		$data = $this->sdb->where('order_number', $id)->get('orders');
		if($data->num_rows() > 0){
			$data = $data->row();
			$this->sdb->where('order_number', $id)->delete('orders');
			$op = $this->sdb->where('order_id', $data->id)->delete('order_products');
			$os = $this->sdb->where('order_id', $data->id)->delete('order_schadules');
			$this->sdb->where('order_id', $data->order_number)->delete('shipments');
		}
	}


}