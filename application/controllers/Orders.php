<?php

defined('BASEPATH') OR exit('No direct script access allowed');
require_once APPPATH.'third_party/vendor/autoload.php';

class Orders extends CI_Controller {
	function __Construct(){
		parent::__Construct();
		$this->output->set_header('Last-Modified:' . gmdate('D, d M Y H:i:s') . 'GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
        $this->output->set_header('Cache-Control: post-check=0, pre-check=0', false);
        $this->output->set_header('Pragma: no-cache');
		if($this->session->userdata('username') == '')
			redirect('logout');

		$this->data['info'] = info(true);

		$this->data['header_content'] = (object)[
			'title' => 'Orders',
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
		$this->load->library('m_pdf');
	}

	function index(){
		$this->data['randerPage'] = "orders/index";
		log_data(['text'=>'Order list', 'data'=>null]);
		$this->load->view('_layout', $this->data);
	}

	function clients(){
		$this->data['randerPage'] = "orders/clients";
		$this->data['rows']  = $this->client_m->getclients();
		$this->load->view('_layout', $this->data);
	}

	//Load Orders rows
	function loaddata(){
		$start = $this->input->post('start');
		$length = $this->input->post('length');
		$search = $this->input->post('search');
		
		$rows = $this->order_m->getorders(null, ['start' => $start, 'length' => $length, 'search' => $search]);

		$data = [];
		$i =1;
		foreach($rows['data'] as $row){
			$ototal = get_order_total($row->id);
            $invoiceNumber = get_invoice_number($row->id);

            $sts = '';
            
            if($invoiceNumber){
              $furl = base_url('orders/viewinvoice/'.$invoiceNumber);
              $is_s = 'display:none';
              $is_s1 = '';
            }else{
              $furl = base_url('orders/invoice?_g='.$row->id.'&_qc='.$row->order_number);
              $is_s = '';
              $is_s1 = 'display:none';
            }

            if(login_user() == 'admin')
            	$remove_btn = '&nbsp;<a href="javascript:deleteorder(\''.$row->id.'\', \''.$row->order_number.'\')" class="btn btn-danger"><i class="fa fa-trash" title="Delete order"></i></a>';

            $data[] = [
            	$i,
            	$row->order_number,
            	date('d-m-Y', strtotime($row->date)),
            	ucfirst($row->clientname).' (<b>'.strtoupper($row->ccode).'</b>)',
            	$row->patiant_name,
            	$row->modal_no,
            	strtoupper($row->work_type),
            	'<a href="javascript:rxupload('.$row->id.')" class="btn btn-info add" title="RX Upload"><i class="fa fa-list"></i></a>',
            	'<span style="display:inline-flex; margin-bottom: 2px;">
	              <select class="form-control" id="urlid'.$i.'"style="width: 100px;" onchange="gotourl('.$i.')">
	                <option value=""> Action</option>
	                <option value="'.base_url('orders/view/'.$row->id).'">Order View</option>
	                <option value="'.base_url('orders/edit/'.$row->id).'">Order Edit</option>
	                <option value="'.base_url('orders/bulkinvoice/'.$invoiceNumber).'" style="'.$is_s1.'">Invoice View</option>
	              </select>
	              &nbsp;<a href="'.base_url('shipment/jobcard/'.$row->order_number).'" title="Job card" class="btn btn-success" target="_blank"><i class="fa fa-print"></i></a>
	              &nbsp;<a href="'.base_url('shipment/labslip/'.$row->order_number).'" title="Lab Slip" class="btn btn-info" target="_blank"><i class="fa fa-file-o"></i></a>'.$remove_btn.'
	              </span>',
            ];

            $i++;
        }

       $output = array(
            "draw" => $this->input->post('draw'),
            "recordsTotal" => get_count('orders', 3),
            "recordsFiltered" => ($rows['filtered'] > 0)?$rows['filtered']:get_count('orders', 3),
            "data" => $data,
        );
        echo json_encode($output);
	}

	function neworder(){
		$this->data['clientid'] = $this->input->get('client');
		$this->data['randerPage'] = "orders/orderform";
		$this->data['docs'] = get_primary_doc($this->data['clientid']);
		$this->data['pdoc'] = get_primary_doc($this->data['clientid'], 1);
		log_data(['text'=>'New Order', 'data'=>null]);
		$this->load->view('_layout', $this->data);
	}

	//View Single Order
	function view($id){
		$this->data['randerPage'] = "orders/view";
		$this->data['order']  = $this->order_m->getorders($id);
		log_data(['text'=>'Order View order-id : '.$id, 'data'=>'order id - '.$id]);
		$this->load->view('_layout', $this->data);
	}

	function getorders(){
		$this->data['header_content'] = (object)[
			'title' => 'Bulk Invoice',
			'sub_title' => 'Master',
			'path' => uri_string(),
		];

		$this->data['sidebar'] = (object)[
			'menu' => 'bulk',
			'submenu' => ''
		];
		$this->data['clients'] = $this->get_client_by_orders();

		if($_POST){
			$client = $this->input->post('client');
			$this->data['rows'] = $this->db->select('o.*, (SELECT sum(total_amount) FROM rpd_order_products where order_id = o.id) as ototal')->where('o.client_code', $client)->where('o.order_number NOT IN (select order_number from rpd_invoice)',NULL,FALSE)->where('is_challan', 1)->order_by('id','desc')->where('o.work_type', 'new')->get('orders as o')->result();
			$this->data['client'] = $client;
		}else{
			$this->data['client'] = null;
		}

		$this->data['randerPage'] = "bulk/bulkorders";
		log_data(['text'=>'Get Order list by Client For Bulk Invoice Genrate', 'data'=>null]);
		$this->load->view('_layout', $this->data);
	}

	/***
	* Bulk Invoice Genrate
		-- rpd_invoice
	*/
	function invoicegenrate(){
		$this->data['header_content'] = (object)[
			'title' => 'Bulk Invoice',
			'sub_title' => 'Master',
			'path' => uri_string(),
		];

		$this->data['sidebar'] = (object)[
			'menu' => 'bulk',
			'submenu' => ''
		];
		$orders = $this->input->post('bulkorders');
		$this->data['client'] = $this->input->post('client');
		// $this->data['type'] = $this->input->post('type');
		$this->data['date'] = date('Y-m-d', strtotime($this->input->post('date')));

		$i = 0;
		foreach($orders as $o){
			$this->data['orderdata'][$i]['order'] = $this->get_order($o);
			$this->data['orderdata'][$i]['product'][] = $this->order_m->get_order_products($o);
			$i++;
		}
		$this->data['randerPage'] = "bulk/invoiceforms/bulkinvoice";
		$this->data['invoicenumber'] = $this->invoicenumber($this->data['date']);
		$this->load->view('_layout', $this->data);
	}


	/***
	* Get Orders Where Challan is Genrated
		-- rpd_invoice
	*/
	private function get_order($id){
		return $this->db->select('o.*, o.id as oid, c.*')->from('orders as o')->join('clients as c', 'c.id = o.client_code', 'inner')->where('work_type', 'new')->where('o.is_challan', 1)->where('o.id', $id)->order_by('o.id', 'desc')->get()->row();
	}

	/***
	* Invocie Genrated is Genrated
		-- rpd_invoice
	*/
	function placeorder(){
		$order = [
			'order_number' => $this->ordernumber(),
			'client_code' => $this->input->post('orderdetails[client_id]'), 
			'patiant_name' => $this->input->post('orderdetails[patientname]'), 
			'patient_age' => $this->input->post('orderdetails[patientage]'), 
			'modal_no' => check_modal_no($this->input->post('orderdetails[modalno]')), 
			'order_date' => date('Y-m-d H:i:s', strtotime($this->input->post('orderdetails[orderdate]'))), 
			'due_date' => date('Y-m-d H:i:s', strtotime($this->input->post('orderdetails[duedate]'))), 
			'in_date' => date('Y-m-d H:i:s', strtotime($this->input->post('orderdetails[indate]'))), 
			'duetime' => $this->input->post('orderdetails[duetime]'), 
			'intime' => $this->input->post('orderdetails[intime]'), 
			'amount' => $this->input->post('orderdetails[additionalamount]'), 
			'add_amount' => $this->input->post('orderdetails[additionalamount]'), 
			'delivery_method' => $this->input->post('orderdetails[delivery]'), 
			'order_status' => $this->input->post('orderdetails[status]'), 
			'order_priority' => $this->input->post('orderdetails[priority]'),
			'note' => $this->input->post('orderdetails[anote]'), 
			'pan_try' => $this->input->post('orderdetails[pan_tray]'), 
			'assign' => $this->input->post('orderdetails[assignto]'), 
			'manufacture' => $this->input->post('orderdetails[manufacturer]'), 
			'department' => $this->input->post('orderdetails[dept]'), 
			'work_type' => $this->input->post('orderdetails[worktype]'),
			'enclosure' => $this->input->post('orderdetails[finalenclosure]'),
			'doctor' => $this->input->post('orderdetails[docname]'),
			'location' => $this->input->post('orderdetails[paddress]'),
			'correction_tamp' => $this->input->post('orderdetails[correction_tamp]'), 
			'shade_one' => $this->input->post('orderdetails[shade1]'), 
			'shade_two' => $this->input->post('orderdetails[shade2]'), 
			'shade_three' => $this->input->post('orderdetails[shade3]'), 
			'shade_note' => $this->input->post('orderdetails[shadenote]'), 
			'articulary_tag' => $this->input->post('orderdetails[articulatortag]'), 
			'added_at' => date('Y-m-d H:i:s'),
			'added_by' => login_user(),
		];
		$schedules = $this->input->post('orderdetails[schedules]');
		$products = $this->input->post('orderdetails[products]');
		$res = $this->order_m->placeorder(['order'=>$order, 'schedules'=>$schedules, 'products'=>$products]);
		if($res['sts'] == true){
			
			$this->db->set(
					[
						// 'capping_value' => $this->input->post('orderdetails[rem_cap_amt]'),
						'capping_limit' => $this->input->post('orderdetails[wave_cap_amt]'),
					]
				)->where('id', $order['client_code'])->update('clients');
			$this->db->set(['units' => $res['units'],
						'order_value' => $res['amount']])->where('id', $res['order_id'])->update('orders');

			log_data(['text'=>'New Order : '.$order['order_number'].' Added', 'data'=>null]);
			echo json_encode(['sts'=>1, 'data'=>'Order Placed successfully']);
		}
	}
	
	//Create Invoice
	function invoice(){
		$this->data['orderid'] = $this->input->get('_g');
		$this->data['ordernumber'] = $this->input->get('_qc');
		$this->data['orderdata'] = $this->order_m->get_order($this->data['orderid'], $this->data['ordernumber']);
		$this->data['orderproduct'] = $this->order_m->get_order_products($this->data['orderid']);
		$this->data['randerPage'] = "orders/invoice";
		$this->data['invoicenumber'] = $this->invoicenumber();
		log_data(['text'=>'Create Invoice : '.$this->data['orderid'].' & order number :'.$this->data['invoicenumber'], 'data'=>null]);
		$this->load->view('_layout', $this->data);
	}

	//View Invoice
	function viewinvoice($id){
		$invoice = $this->db->where('invoice_number', $id)->get('invoice')->row_array();
		$pro = $this->db->where('invoice_number', $id)->get('invoice_product')->result_array();
		$this->data['page'] = 'admission/payment_receipt';

        $html = $this->load->view('orders/view_invoice', ['invoice'=>$invoice, 'pros'=>$pro], true);
        $this->m_pdf->pdf($html, $id.'_invoice_'.time().'.pdf');
	}

	private function get_client_by_orders(){
		return $this->db->select('o.client_code as id, c.clientname')->from('orders as o')->join('clients as c', 'c.id = o.client_code', 'inner')->where('is_challan', 1)->where('o.order_number NOT IN (select order_number from rpd_invoice)',NULL,FALSE)->where('o.work_type', 'new')->group_by('o.client_code')->get()->result();
	}

	// finalize Invoice or Save
	function saveinvoice(){
		$invoice = [];
		$totalunits = 0;

		foreach ($this->input->post('units') as $u){
			$totalunits += $u;
		}

		$invoice_date = date('Y-m-d', strtotime($_POST['duedate']));
		$invoice_number = $this->validate_invoice_number($_POST['invoicenumber']);
		$isi = false;
		for($o=0; $o<sizeof($this->input->post('order_id')); $o++){
			$invoice = [
				'order_id' => $_POST['order_id'][$o],
				'order_number' => $_POST['order_number'][$o],
				'order_date' => $_POST['order_date'][$o],
				'client_id' => $_POST['client_id'],
				'invoice_date' => $invoice_date,
				'invoice_number' => $invoice_number,
				'patiant' => $_POST['patiant'][$o],
				'additionalamount' => $_POST['add_amount'],
				'billing_address' => null,
				'delivery_address' => $_POST['address'],
				'gst_number'=> "null",//$_POST['gst'][$o],
				'units' => $totalunits,
				'adjestmentAmount ' => null, 
				'scheme' => null,
				'invoice_total' => $_POST['txfinal_amount'],
				'invoice_gst_amount' => $_POST['txfinal_gst_amount'],
				'invoice_gst' => $_POST['txfinal_gst'],
				'invoice_subtotal'  => $_POST['txfinal_subtotal'],
				'igst'  => $_POST['igst'],
				'cgst'  => $_POST['cgst'],
				'sgst'  => $_POST['sgst'],
				'discount'  => (isset($_POST['adiscount'])?$_POST['adiscount']:0),
				'added_at' => date('Y-m-d'),
				'added_by' => login_user(),
				'type' => $_POST['type']
			];

			if($this->db->insert('invoice', $invoice)){
				log_data(['text'=>'Invoice Added Invoice-no : '.$invoice_number, 'data'=>'invoid no - '.$invoice_number]);
				$this->db->set('is_invoice', 1)->where('order_number', $invoice['order_number'])->update('orders');
				$isi = true;
			}
		}
		
		if($isi){
			$isc = false;
			for($g=0; $g <= sizeof($this->input->post('product'))-1; $g++){
				$pro = [
					'order_id' => $_POST['order'][$g],
					'client_id' => $_POST['client_id'],
					'invoice_number' => $invoice_number,
					'product' => $_POST['product'][$g],
					'producttype' => $_POST['producttype'][$g],
					'productcategory' => $_POST['productcategory'][$g],
					'unit' => $_POST['units'][$g],
					'base_price' => $_POST['base_price'][$g],
					'unitprice' => $_POST['unit_price'][$g],
					'discount' => $_POST['discount'][$g],
					'offer_id' => $_POST['offer_id'][$g],
					'subtotal' => $_POST['fsubtotal'][$g],
					'igst' => 0,
					'sgst' => 0,
					'cgst' => 0,
					'total' => $_POST['fsubtotal'][$g],
				];

				if($this->db->insert('invoice_product', $pro)){
					log_data(['text'=>'Invoice Product Added order-id : '.$invoice_number, 'data'=>'invoid id - '.$invoice_number]);
					$isc = true;
				}
			}

			if($isc){
				echo json_encode(['sts' => 1, 'data' => base_url('orders/bulkinvoice/'.$this->input->post('invoicenumber'))]);
			}
			else
				echo json_encode(['sts' => false]);
		}else{
			echo json_encode(['sts' => false]);
		}
	}

	private function validate_invoice_number($invoice_num){
		$res = $this->db->where('invoice_number', $invoice_num)->get('invoice')->num_rows();
		if($res > 0){
			$in_new = $this->db->select_max('invoice_number')->get('invoice')->row('invoice_number');
			$this->validate_invoice_number($in_new+1);
		}else{
			return $invoice_num;
		}
	}

	//View Invoice
	function bulkinvoice($id){
		$invoice = $this->db->where('invoice_number', $id)->get('invoice')->result();
		$pro = $this->db->where('invoice_number', $id)->get('invoice_product')->result();
		log_data(['text'=>'Opened Bulk Invoice View', 'data' => null]);
		$html = $this->load->view('bulk/viewbulk_invoice', ['invoice'=>$invoice, 'pros'=>$pro], true);

		$this->m_pdf->pdf($html, 'invoice_'.$id.'_'.time().'.pdf');
	}

	//Genrate Radom Invoice Number
	private function invoicenumber($date){
        
        if(!empty($date)){
			$d = date('m', strtotime($date));
			$y = date('y', strtotime($date));
        }else{
			$d = date('m');
			$y = date('y');
		}

		$id = $this->db->select_max('invoice_number')->like('invoice_number', $y.$d)->get('invoice')->row()->invoice_number;
		$id = $id + 1;

        if($d == substr($id,2,2)){
            if($id == 1){
                $n = $y.$d.'0000'.$id;
            }else{
                $n = $id;
            }
	    }else{
    	    $n = $y.$d.'00001';
	    }

	    if(!empty($date)){
	    	return $n;
	    }
	    else
	    	return $n;
	}

	//Genrate Radom Order Number
	function ordernumber(){
		$id = $this->db->select_max('id')->get('orders')->row()->id;
		$id+= 1;
		return 'O'.date('Ymd').$id;
	}
    
    //all invoice List
  function invoices(){
		$this->data['randerPage'] = "orders/invoice/invoices";
		$this->load->view('_layout', $this->data);
	}

	//import All invoice using excel
	function import(){
		if(isset($_FILES["importfile"]["name"])){
			$path = $_FILES["importfile"]["tmp_name"];
   			$object = PHPExcel_IOFactory::load($path);
   			
   			$arr = [];
   			foreach($object->getWorksheetIterator() as $worksheet){
			    $highestRow = $worksheet->getHighestRow();
			   	$highestColumn = $worksheet->getHighestColumn();
				for($row = 2; $row <= $highestRow; $row++){
					if($worksheet->getCellByColumnAndRow(0, $row)->getValue()){
						$client_id = $worksheet->getCellByColumnAndRow(2, $row)->getValue();

						$pro = [
							'order_id' => $worksheet->getCellByColumnAndRow(0, $row)->getValue(),
							'client_id' => $client_id,
							'invoice_number' => $worksheet->getCellByColumnAndRow(4, $row)->getValue(),
							'product' => $worksheet->getCellByColumnAndRow(12, $row)->getValue(), //('product'),
							'producttype' => $worksheet->getCellByColumnAndRow(13, $row)->getValue(), //('producttype'),
							'productcategory' => $worksheet->getCellByColumnAndRow(14, $row)->getValue(), //('productcategory'),
							'unit' => $worksheet->getCellByColumnAndRow(15, $row)->getValue(), //('units'),
							'base_price' => $worksheet->getCellByColumnAndRow(16, $row)->getValue(), //('base_price'),
							'unitprice' => $worksheet->getCellByColumnAndRow(17, $row)->getValue(), //('unit_price'),
							'discount' => $worksheet->getCellByColumnAndRow(18, $row)->getValue(), //('discount'),
							'igst' => $worksheet->getCellByColumnAndRow(19, $row)->getValue(), //('igst'),
							'sgst' => $worksheet->getCellByColumnAndRow(20, $row)->getValue(), //('sgst'),
							'cgst' => $worksheet->getCellByColumnAndRow(21, $row)->getValue(), //('cgst'),
						];

						$invoice_subtotal = $worksheet->getCellByColumnAndRow(17, $row)->getValue() * $worksheet->getCellByColumnAndRow(15, $row)->getValue();
						$invoice_gst = $pro['igst'] + $pro['sgst'] + $pro['cgst'];
						$invoice_gst_amount = (($invoice_subtotal * $invoice_gst)/100);
						$invoice_total = $worksheet->getCellByColumnAndRow(16, $row)->getValue() + $invoice_gst_amount;

						$pro['total'] = $invoice_total;
						$pro['subtotal'] = $invoice_subtotal;

						$invoice = [
							'order_id' => $worksheet->getCellByColumnAndRow(0, $row)->getValue(),
							'order_number' => $worksheet->getCellByColumnAndRow(0, $row)->getValue(),
							'order_date' => date('Y-m-d', strtotime($worksheet->getCellByColumnAndRow(1, $row)->getValue())),
							'client_id' => $client_id,
							'invoice_date' => date('Y-m-d', strtotime($worksheet->getCellByColumnAndRow(3, $row)->getValue())),
							'invoice_number' => $worksheet->getCellByColumnAndRow(4, $row)->getValue(),
							'patiant' => $worksheet->getCellByColumnAndRow(5, $row)->getValue(),
							'additionalamount' => $worksheet->getCellByColumnAndRow(6, $row)->getValue(),
							'billing_address' => null,//$worksheet->getCellByColumnAndRow(7, $row)->getValue(),
							'delivery_address' => $worksheet->getCellByColumnAndRow(7, $row)->getValue(),
							'gst_number' => $worksheet->getCellByColumnAndRow(8, $row)->getValue(),
							'units' => $worksheet->getCellByColumnAndRow(9, $row)->getValue(),
							'adjestmentAmount' => $worksheet->getCellByColumnAndRow(10, $row)->getValue(),
							'scheme' => $worksheet->getCellByColumnAndRow(11, $row)->getValue(),
							'invoice_subtotal' => $invoice_subtotal,
							'invoice_total' => $invoice_total,
							'invoice_gst_amount' => $invoice_gst_amount,
							'invoice_gst' => $invoice_gst,
							'added_at' => date('Y-m-d H:i:s'),
							'added_by' => login_user(),
						];

						if($this->db->insert('invoice', $invoice)){
							log_data(['text'=>'Import New Invoice', 'data'=> null]);
							$this->db->insert('invoice_product', $pro);
							log_data(['text'=>'Import Invoice Product', 'data'=> null]);
						}
					}
    			}
   			}
   			redirect(base_url('orders/invoices'));
		}
	}

	//Order Edit
	function edit($id){
		$this->data['randerPage'] = "orders/orderedit";
		$this->data['order'] = $this->order_m->getorders($id);
		$this->data['script'] = "editorder";
		log_data(['text'=>'Opened OrderEdit order-id : '.$id, 'data'=>'order id - '.$id]);
		$this->load->view('_layout', $this->data);
	}

	//Edit Order by ID
	function editorder(){
		$order_id = $this->input->post('orderdetails[orderid]');
		$order_number = $this->input->post('orderdetails[ordernumber]');
		
		$order = [
			'client_code' => $this->input->post('orderdetails[client_id]'), 
			'patiant_name' => $this->input->post('orderdetails[patientname]'), 
			'patient_age' => $this->input->post('orderdetails[patientage]'), 
			'modal_no' => $this->input->post('orderdetails[modalno]'), 
			'order_date' => date('Y-m-d H:i:s', strtotime($this->input->post('orderdetails[orderdate]'))), 
			'due_date' => date('Y-m-d H:i:s', strtotime($this->input->post('orderdetails[duedate]'))), 
			'in_date' => date('Y-m-d H:i:s', strtotime($this->input->post('orderdetails[indate]'))), 
			'duetime' => $this->input->post('orderdetails[duetime]'), 
			'intime' => $this->input->post('orderdetails[intime]'), 
			'amount' => $this->input->post('orderdetails[additionalamount]'), 
			'add_amount' => $this->input->post('orderdetails[additionalamount]'), 
			'delivery_method' => $this->input->post('orderdetails[delivery]'), 
			'order_status' => $this->input->post('orderdetails[status]'), 
			'order_priority' => $this->input->post('orderdetails[priority]'),
			'note' => $this->input->post('orderdetails[anote]'), 
			'pan_try' => $this->input->post('orderdetails[pan_tray]'), 
			'assign' => $this->input->post('orderdetails[assignto]'), 
			'manufacture' => $this->input->post('orderdetails[manufacturer]'), 
			'department' => $this->input->post('orderdetails[dept]'), 
			'work_type' => $this->input->post('orderdetails[worktype]'),
			'enclosure' => $this->input->post('orderdetails[finalenclosure]'),
			'doctor' => $this->input->post('orderdetails[docname]'),
			'location' => $this->input->post('orderdetails[paddress]'),
			'correction_tamp' => $this->input->post('orderdetails[correction_tamp]'),
			'shade_one' => $this->input->post('orderdetails[shade1]'), 
			'shade_two' => $this->input->post('orderdetails[shade2]'), 
			'shade_three' => $this->input->post('orderdetails[shade3]'), 
			'shade_note' => $this->input->post('orderdetails[shadenote]'), 
			'articulary_tag' => $this->input->post('orderdetails[articulatortag]'), 
			'updated_at' => date('Y-m-d H:i:s'),
			'updated_by' => login_user(),
		];

		$schedules = $this->input->post('orderdetails[schedules]');
		$products = $this->input->post('orderdetails[products]');

		$res = $this->db->where('order_id', $order_id)->get('order_products');
		if($res->num_rows() > 0){
			$this->db->where('order_id', $order_id)->delete('order_products');
		}

		$ures = $this->updateorder(['order'=>$order, 'schedules'=>$schedules, 'products'=>$products], $order_id);
		if($ures['sts'] == true){
			// $res = $res->row_array();
			$this->db->set(['units' => $ures['units'],'order_value' => $ures['amount']])->where('id', $ures['order_id'])->update('orders');
			log_data(['text'=>'Order Updated order-id : '.$order_id, 'data'=>'order id - '.$order_id]);
			echo json_encode(['sts'=>1, 'data'=>'Order Edited successfully']);
		}
	}

	//Update Function for Order
	private function updateorder($data, $id){
		$this->db->set($data['order'])->where('id', $id)->update('orders');
		if($this->db->affected_rows() > 0){
			for($j=0; $j<sizeof($data['schedules']); $j++){
				$arr = [
					'order_id' => $id,
					'title' => $data['schedules'][$j]['id'],
					'sch_date' => date('Y-m-d', strtotime(str_replace('/','-',$data['schedules'][$j]['date']))),
					'status' => $data['schedules'][$j]['sts'],
				];
				$this->db->set($arr)->where('order_id', $id)->update('order_schadules');
			}

			$total_units = 0;
			$total_amount = 0;
			for($i=0; $i<sizeof($data['products']); $i++){
				$arr = [
					'order_id' => $id,
					'product_id' => $data['products'][$i]['product']['id'],
					'product_type' => $data['products'][$i]['producttype']['id'],
					'product_category' => $data['products'][$i]['productcategory']['id'],
					'teeth' => $data['products'][$i]['teethcount'],
					'unit' => $data['products'][$i]['unit'],
					'unit_price' => $data['products'][$i]['unitrate'],
					'discount' => $data['products'][$i]['cdiscount'],
					'total_amount' => $data['products'][$i]['total'],	
					'options' => (isset($data['products'][$i]['rx']))?json_encode($data['products'][$i]['rx']):"",
				];
				
				if($this->db->insert('order_products', $arr)){
					$total_amount += $data['products'][$i]['total'];
					$total_units += $data['products'][$i]['unit'];
					log_data(['text'=>'Update OrderProducts order-id : '.$id, 'data'=>'order products for order id - '.$id]);
				}
			}
			// return true;
			return ['sts'=>true, 'order_id'=> $id, 'units'=>$total_units, 'amount'=>$total_amount];
		}
	}

	//Files Upload function
	public function rxupload() {
	    $file_path = "./assets/uploads/rx/";

	    if (isset($_FILES['rxfile'])) {
	        
	        if (!is_dir('assets/uploads/rx/')) {
	            mkdir('./assets/uploads/rx/', 0777, TRUE);
	        }

	        $files = $_FILES;
	        $cpt = count($_FILES ['rxfile'] ['name']);
	        for ($i = 0; $i < $cpt; $i ++) {
	            $name = time().$files ['rxfile'] ['name'] [$i];
	            $_FILES ['rxfile'] ['name'] = $name;
	            $_FILES ['rxfile'] ['type'] = $files ['rxfile'] ['type'] [$i];
	            $_FILES ['rxfile'] ['tmp_name'] = $files ['rxfile'] ['tmp_name'] [$i];
	            $_FILES ['rxfile'] ['error'] = $files ['rxfile'] ['error'] [$i];
	            $_FILES ['rxfile'] ['size'] = $files ['rxfile'] ['size'] [$i];
				
				$this->load->library('upload');
	            $this->upload->initialize($this->set_upload_options($file_path));
	            if(!($this->upload->do_upload('rxfile')) || $files ['rxfile'] ['error'] [$i] !=0)
	            {
	                print_r($this->upload->display_errors());
	            }
	            else
	            {	
	            	$a = $this->upload->data();
	            	$data = [
	            		'order_id' => $this->input->post('order_id'),
	            		'filepath' => base_url().'assets/uploads/rx/'.$a['file_name'],
	            	];
	            	if($this->db->insert('rxfiles', $data))
	            		log_data(['text'=>'Rx Uploaded For order-id : '.$id, 'data'=>'rx uploaded for order id - '.$id]);
	            }
	        }
	    }
	    redirect(base_url('orders'));
	}


	//Delete Order, Invoce Other Data 
	function deleteorder($id){
		$this->db->where('id', $id)->delete('orders');
		log_data(['text'=>'Order Delete order-id : '.$id, 'data'=>'order id - '.$id]);

		$this->db->where('order_id', $id)->delete('order_products');
		log_data(['text'=>'Order Product order-id : '.$id, 'data'=>'order id - '.$id]);

		$this->db->where('order_id', $id)->delete('invoice');
		log_data(['text'=>'Delete Invoice order-id : '.$id, 'data'=>'invoice id - '.$id]);

		$this->db->where('order_id', $id)->delete('invoice_product');
		log_data(['text'=>'Delete Invoice Porduct order-id : '.$id, 'data'=>'order id - '.$id]);

		$this->db->where('order_id', $this->get_order_no($id))->delete('shipments');
		log_data(['text'=>'Delete Challan order-id : '.$id, 'data'=>'order id - '.$id]);
	}

	private function get_order_no($id){
		return $this->db->select('order_number')->where('id', $id)->get('orders')->row()->order_number;
	}

	//Config File Updaload Function
	public function set_upload_options($file_path) {
	    // upload an image options
	    $config = array();
	    $config ['upload_path'] = $file_path;
	    $config ['encrypt_name'] = true;
	    $config ['allowed_types'] = 'gif|jpg|png';
	    return $config;
	}


	function rxfiles($id){
		$res = $this->db->where('order_id', $id)->get('rxfiles');
		if($res->num_rows() > 0){
			echo json_encode(['sts'=>1, 'data'=>$res->result_array()]);
		}else{
			echo json_encode(['sts'=>0,]);
		}
	}
	
	
	/***
	* Validate Case for Correction and Redo 
	*/
	function validate_case(){
		$res = $this->db->where('modal_no', $this->input->post('case_no', true))->get('orders')->num_rows();
		if($res > 0)
			echo true;
		else
			echo false;
	}

	/**
	* Redo Order Form
	*/
	function redo(){
		$id = $this->get_order_id($this->input->post('case_no', true));
		$this->data['randerPage'] = "orders/redo";
		$this->data['order'] = $this->order_m->getorders($id);
		$this->data['script'] = "redo_order";
		$this->data['wt'] = "redo";
		log_data(['text'=>'Redu Order Form order-id : '.$id, 'data'=>'order id - '.$id]);
		$this->load->view('_layout', $this->data);
	}

	/**
	* Currection Order Form
	*/
	function correction(){
		$id = $this->get_order_id($this->input->post('case_no', true));
		$this->data['randerPage'] = "orders/redo";
		$this->data['order'] = $this->order_m->getorders($id);
		$this->data['script'] = "redo_order";
		$this->data['wt'] = "correction";
		log_data(['text'=>'Redu Order Form order-id : '.$id, 'data'=>'order id - '.$id]);
		$this->load->view('_layout', $this->data);
	}

	/**
	* Get Order ID by case or Modal number
	*/
	private function get_order_id($case_no){
		return $this->db->select('id')->where('modal_no', $case_no)->order_by('id', 'desc')->get('orders')->row('id');
	}


	function reduorder(){
		$order = [
			// 'order_number' => $this->input->post('orderdetails[ordernumber]'),
			'order_number' => $this->ordernumber(),
			'client_code' => $this->input->post('orderdetails[client_id]'), 
			'patiant_name' => $this->input->post('orderdetails[patientname]'), 
			'patient_age' => $this->input->post('orderdetails[patientage]'), 
			'modal_no' => $this->input->post('orderdetails[modalno]'), 
			'order_date' => date('Y-m-d H:i:s', strtotime($this->input->post('orderdetails[orderdate]'))), 
			'due_date' => date('Y-m-d H:i:s', strtotime($this->input->post('orderdetails[duedate]'))), 
			'in_date' => date('Y-m-d H:i:s', strtotime($this->input->post('orderdetails[indate]'))), 
			'duetime' => $this->input->post('orderdetails[duetime]'), 
			'intime' => $this->input->post('orderdetails[intime]'), 
			'amount' => $this->input->post('orderdetails[additionalamount]'), 
			'add_amount' => $this->input->post('orderdetails[additionalamount]'), 
			'delivery_method' => $this->input->post('orderdetails[delivery]'), 
			'order_status' => $this->input->post('orderdetails[status]'), 
			'order_priority' => $this->input->post('orderdetails[priority]'),
			'note' => $this->input->post('orderdetails[anote]'), 
			'pan_try' => $this->input->post('orderdetails[pan_tray]'), 
			'assign' => $this->input->post('orderdetails[assignto]'), 
			'manufacture' => $this->input->post('orderdetails[manufacturer]'), 
			'department' => $this->input->post('orderdetails[dept]'), 
			'work_type' => $this->input->post('orderdetails[worktype]'),
			'enclosure' => $this->input->post('orderdetails[finalenclosure]'),
			'doctor' => $this->input->post('orderdetails[docname]'),
			'location' => $this->input->post('orderdetails[paddress]'),
			'correction_tamp' => $this->input->post('orderdetails[correction_tamp]'), 
			'shade_one' => $this->input->post('orderdetails[shade1]'), 
			'shade_two' => $this->input->post('orderdetails[shade2]'), 
			'shade_three' => $this->input->post('orderdetails[shade3]'), 
			'shade_note' => $this->input->post('orderdetails[shadenote]'), 
			'articulary_tag' => $this->input->post('orderdetails[articulatortag]'), 
			'added_at' => date('Y-m-d H:i:s'),
			'added_by' => login_user(),
		];
		$schedules = $this->input->post('orderdetails[schedules]');
		$products = $this->input->post('orderdetails[products]');

		$res = $this->order_m->placeorder(['order'=>$order, 'schedules'=>$schedules, 'products'=>$products]);
		if($res['sts'] == true){
			$this->db->set(['capping_value' => $this->input->post('orderdetails[rem_cap_amt]'),'capping_limit' => $this->input->post('orderdetails[wave_cap_amt]'),])->where('id', $order['client_code'])->update('clients');
			$this->db->set(['units' => $res['units'],'order_value' => $res['amount']])->where('id', $res['order_id'])->update('orders');
			log_data(['text'=>'New Order : '.$order['order_number'].' Added', 'data'=>null]);
			echo json_encode(['sts'=>1, 'data'=>'Order Placed successfully']);
		}
	}

	/***
	* Print Bulk invoice
	**/
	function printinvoices(){
		if($_POST){
			$arr = [
				'fromdate' => date('Y-m-d', strtotime($this->input->post('fromdate'))),
				'todate' => date('Y-m-d', strtotime($this->input->post('todate'))),
				'client' => $this->input->post('client'),
			];
			$this->data['rows'] = $this->printinvoices1($arr);
			$_POST = [];
		}else{
			$arr = [
				'fromdate' => date('Y-m-d'),
				'todate' => date('Y-m-d'),
				'client' => '',
			];
			$this->data['rows'] = null;
		}
		$this->data['arr'] = $arr;
		$this->data['randerPage'] = "bulk/print_invoice_multi";
		$this->data['script'] = "";
		$this->load->view('_layout', $this->data);
	}

	//View Invoice
	function print(){
		$invoices = $this->input->post('invoice', true);
		$html = '';

		$pdf = new \Mpdf\Mpdf();
		foreach ($invoices as $i) {
			$invoice = $this->db->where('invoice_number', $i)->get('invoice')->result();
			$pro = $this->db->where('invoice_number', $i)->get('invoice_product')->result();	
			$html = $this->load->view('bulk/print_mult', ['invoice'=>$invoice, 'pros'=>$pro], true);
			$pdf->WriteHTML($html);
			$pdf->AddPage();
		}
        $pdf->Output('invoice_'.time().'.pdf', 'I');
	}


	/**
	* Print Bulk Invoices
	*/
	private function printinvoices1($arr){
		$this->db->select('i.invoice_number, i.invoice_date, i.units,i.invoice_total, c.clientname');
		
		if($arr['client'] != '')
			$this->db->where('c.id', $arr['client']);

		$this->db->where('DATE(i.invoice_date) >=', $arr['fromdate']);
		$this->db->where('DATE(i.invoice_date) <=', $arr['todate']);
		$this->db->where('c.id = i.client_id')->group_by('i.invoice_number');

		$res = $this->db->get('invoice as i, clients as c');
		if($res->num_rows() > 0){
			return $res->result();
		}
	}

	/**
	* Edit Invoice
	*/
	function editinvoice($invoicenumber = false){
		if($_POST){
			$nvoice_number =  $_POST['invoicenumber'];
			if($this->oldinvoice_trasfer($nvoice_number)){
				$is_edited = get_edit_limit($nvoice_number);
				$invoice = [];
				$totalunits = 0;
				foreach ($this->input->post('units') as $u){
					$totalunits += $u;
				}
				$invoice_date = date('Y-m-d', strtotime($_POST['duedate']));
				$invoice_number = $_POST['invoicenumber'];
				$isi = false;
				for($o=0; $o<sizeof($this->input->post('order_id')); $o++){
					$invoice = [
						'order_id' => $_POST['order_id'][$o],
						'order_number' => $_POST['order_number'][$o],
						'order_date' => $_POST['order_date'][$o],
						'client_id' => $_POST['client_id'],
						'invoice_date' => $invoice_date,
						'invoice_number' => $invoice_number,
						'patiant' => $_POST['patiant'][$o],
						'additionalamount' => $_POST['add_amount'],
						'billing_address' => null,
						'delivery_address' => $_POST['address'],
						'gst_number'=> "null",
						'units' => $totalunits,
						'adjestmentAmount ' => null, 
						'scheme' => null,
						'invoice_total' => $_POST['txfinal_amount'],
						'invoice_gst_amount' => $_POST['txfinal_gst_amount'],
						'invoice_gst' => $_POST['txfinal_gst'],
						'invoice_subtotal'  => $_POST['txfinal_subtotal'],
						'igst'  => $_POST['igst'],
						'cgst'  => $_POST['cgst'],
						'sgst'  => $_POST['sgst'],
						'added_at' => date('Y-m-d'),
						'added_by' => login_user(),
						'type' => $_POST['type'],
						'is_edited' => $is_edited,
					];

					if($this->db->insert('invoice', $invoice)){
						$this->db->set('is_invoice', 1)->where('order_number', $invoice['order_number'])->update('orders');
						$isi = true;
					}
				}
				if($isi){
					$isc = false;
					for($g=0; $g <= sizeof($this->input->post('product'))-1; $g++){
						$pro = [
							'order_id' => $_POST['order'][$g],
							'client_id' => $_POST['client_id'],
							'invoice_number' => $invoice_number,
							'product' => $_POST['product'][$g],
							'producttype' => $_POST['producttype'][$g],
							'productcategory' => $_POST['productcategory'][$g],
							'unit' => $_POST['units'][$g],
							'base_price' => $_POST['base_price'][$g],
							'unitprice' => $_POST['unit_price'][$g],
							'discount' => $_POST['discount'][$g],
							'subtotal' => $_POST['fsubtotal'][$g],
							'igst' => 0,
							'sgst' => 0,
							'cgst' => 0,
							'total' => $_POST['fsubtotal'][$g],
						];

						if($this->db->insert('invoice_product', $pro)){
							$isc = true;
						}
					}

					if($isc){
						echo json_encode(['sts' => 1, 'data' => base_url('orders/bulkinvoice/'.$this->input->post('invoicenumber'))]);
						return;
					}
				}
			}
		}

		$this->data['rows']  = $this->get_invoice_data($invoicenumber);
		$this->data['randerPage'] = "orders/edit_invoice";
		$this->load->view('_layout', $this->data);
	}

	private function oldinvoice_trasfer($invoicenumber){
		$is_dup = $this->db->select('MAX(invoice_group) as invoice_group')->where('invoice_number', $invoicenumber)->get('edit_invoice')->row()->invoice_group;
		
		if($is_dup == 3){
			return false;
		}else{
			$group = ($is_dup <	 3)?$is_dup+1:false;
		}

		$invoice = $this->db->where('invoice_number', $invoicenumber)->get('invoice')->result_array();
		$invoice_product = $this->db->where('invoice_number', $invoicenumber)->get('invoice_product')->result_array();
		
		foreach ($invoice as $i) {
			$i['invoice_group'] = $group;
			if($this->db->insert('edit_invoice', $i)){
				$this->db->where('id', $i['id'])->delete('invoice');
			}
		}
		
		foreach ($invoice_product as $ip) {
			$ip['invoice_group'] = $group;
			if($this->db->insert('edit_invoice_product', $ip)){
				$this->db->where('id', $ip['id'])->delete('invoice_product');
			}
		}

		return true;
	}

	private function get_invoice_data($invoicenumber){
		$invoice =  $this->db->where('invoice_number', $invoicenumber)->get('invoice');
		$invoice_product = $this->db->where('invoice_number', $invoicenumber)->get('invoice_product');
		if($invoice->num_rows() > 0)
			return ['invoice'=>$invoice->result(), 'products' => $invoice_product->result()];

		return [];
	}


	/**
	* Load Invoices With Limited Data
	*/
	function loadinvoices(){
		log_data(['text'=>'Opened Invoice List', 'data' => null]);
		$start = $this->input->post('start');
		$length = $this->input->post('length');
		$search = $this->input->post('search');
		
		$rows = $this->order_m->invloiceslist(null, ['start' => $start, 'length' => $length, 'search' => $search]);

		$data = [];
		$i = 1;
		foreach($rows['data'] as $row){
			$p_btn = '<a href="'.base_url('orders/bulkinvoice/'.$row->invoice_number).'" target="_blank"><i class="fa fa-info btn btn-info"></i></a>';
			$_in = $row->invoice_total;

			$edit_btn = '';
			$rem_edits = get_edit_limit($row->invoice_number, true);



			if($rem_edits > 0 && ($row->is_edited >= 0 && $row->is_edited <= $this->config->item('invoice_number')) && $this->session->userdata('role') == 'master' && login_user() == 'admin'){
				$edit_btn = '<a href="'.base_url('orders/editinvoice/'.$row->invoice_number). '" title="Remining Edits - '.$rem_edits.'" ><i class="btn btn-warning edit_btn_">E</i></a>';
			}


		 $data[] = [
			$i,
			ucfirst(get_clientname($row->client_id)),
			$row->invoice_number,
			date('d/m/Y', strtotime($row->invoice_date)),
			$row->patiant,
			$row->order_number,
			number_format($_in, 2),
			$p_btn.' '.$edit_btn,
        ];
        $i++;
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




}

