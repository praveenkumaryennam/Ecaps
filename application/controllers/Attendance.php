<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Attendance extends CI_Controller {
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
			'title' => 'Attendance',
			'sub_title' => 'Masters',
			'path' => uri_string(),
		];
		$this->data['sidebar'] = (object)[
			'menu' => $this->uri->segment(1),
			'submenu' => $this->uri->segment(2)
		];

		$this->load->library('excel');
		$this->load->model(['client_m','order_m', 'reports_m']);
	}


	function index(){
		$this->data['rows'] = $this->get_atttendance();
		$this->data['randerPage'] = "attandance/index";
		$this->load->view('_layout', $this->data);
	}

	function salaryslip($id){
		$this->data['data'] = $this->genrate($id);
		$this->data['randerPage'] = "attandance/payslip";
		$this->load->view('attandance/payslip', $this->data);
	}

	private function genrate($id){
		$data = $this->get_atttendance($id);
			
		$total_earning = 0;
		$total_earning_ytd = 0;
		$total_deduct = 0;
		$total_deduct_ytd = 0;
		$net_pay = 0;

		$ccr= 0;
		$cdr= 0;

		$dr = '';
		$cr = '';
			

		foreach ($data['payscale'] as $key) {
    		$earning = 0;
    		$earning_ytd = 0;
    		$deduct = 0;
    		$deduct_ytd = 0;

    		if($key->salary_type == 'basic_salary')
    			$basic_salary = $key->amount;

			if($key->type == 'cr'){
				$ccr++;

				$f = ($key->amount/$data['attandance']->total);
				$f = ($f*$data['attandance']->paid_days);

				$earning += $f;
				$total_earning += $earning;
				$earning_ytd += ($key->amount * 12);
				$total_earning_ytd += $earning_ytd;

				$cr .= '<tr>
				<td><b>'.strtoupper(str_replace('_', ' ', $key->salary_type)).'</b></td>
				<td>'.number_format(($key->amount * 12), 2).'</td>
				<td>'.number_format(($earning), 2).'</td>
				</tr>';
			}

			if($key->type == 'dr'){
				$cdr++;

				if($key->is_type == '%')
					$f = (($basic_salary * $key->amount)/100);
				else
					$f = ($key->amount);

				$deduct += $f;
				$total_deduct += $deduct;
				$deduct_ytd += ($key->amount * 12);
				$total_deduct_ytd += $deduct_ytd;
				
				$dr .= '<tr>
				<td><b>'.strtoupper(str_replace('_', ' ', $key->salary_type)).'</b></td>
				<td>'.number_format(($key->amount * 12), 2).'</td>
				<td>'.number_format(($f), 2).'</td>
				</tr>';
			}
		}

		if($ccr > $cdr){
			$dr .= '<tr><td>---</td><td>---</td><td>---</td></tr>';
		}else{
			$cr .= '<tr><td>---</td><td>---</td><td>---</td></tr>';
		}
		$ins_data = [
			'emp_id' => $data['attandance']->emp_id,
			'payslip_no' => rand(9999, 1111),
			'payment_date' => date('Y-m-d'),
			'total_earning' => $total_earning,
			'total_deduction' => $total_deduct, 
			'net_pay' => ($total_earning - $total_deduct),
			'added_at' => date('Y-m-d H:i:s'),
			'added_by' => login_user(),
		];

		if($this->check_payslip($ins_data['payment_date'], $ins_data['emp_id']) == true){
			if($this->db->insert('payslips', $ins_data)){
				foreach ($data['payscale'] as $key) {
					$temp = [
						'payslip_id' => $ins_data['payslip_no'],
						'payment_for' => $key->salary_type,
						'type' => $key->type,	
						'amount' => $key->amount,	
					];

					$this->db->insert('payslip_details', $temp);
				}

			}
		}
		return [
			'dr' => $dr,
			'cr' => $cr, 
			'pay_date' => date('M-Y', strtotime($ins_data['payment_date'])), 
			'total_earning_ytd' => $total_earning_ytd,
			'total_earning' => $total_earning,
			'total_deduct_ytd' => $total_deduct_ytd,
			'total_deduct' => $total_deduct,
			'rows' => $data
		];
	}

	private function check_payslip($_date, $emp_id){
		$res = $this->db->where('MONTH(payment_date)', date('m', strtotime($_date)))->where('emp_id', $emp_id)->get('payslips');
		
		if($res->num_rows() > 0)
			return false;
		return true;
	}

	private function get_atttendance($id = false){
		if($id){
			$data['attandance'] = $this->db->select('*')->from('attandance')->where('emp_id', $id)->get()->row();
			$data['payscale'] = $this->db->select('*')->from('salary')->where('emp_id', $id)->get()->result();
			$data['employee'] = $this->db->select('*')->from('employee')->where('code', $id)->get()->row();
			$data['ac'] = $this->db->select('*')->from('employee_ac')->where('emp_id', $id)->get()->row();
			return $data;
		}
		return $this->db->get('attandance')->result();
	}

	function import(){

		if(!empty($_FILES["importdata"]["name"])){
			$path = $_FILES["importdata"]["tmp_name"];
   			$object = PHPExcel_IOFactory::load($path);
   			$arr = [];
   			foreach($object->getWorksheetIterator() as $worksheet){
			    $highestRow = $worksheet->getHighestRow();
			   	$highestColumn = $worksheet->getHighestColumn();
				
				$r = [];
				$month = date('m', strtotime(str_replace('Print Date:', '', str_replace('/', '-', $worksheet->getCellByColumnAndRow(2, 3)->getValue()))));
				for($row=5; $row < $highestRow; $row++){
					for($i=1; $i <11 ; $i++) { 
						$r[$row][] = $worksheet->getCellByColumnAndRow($i, $row)->getValue();
					}
    			}
    			foreach ($r as $d) {
	    			$arr = [
	    				"_month" => $month,
	    				"emp_id" => $d[0],
	    				"present" => $d[2],
	    				"absent" => $d[3],
	    				"week_off" => $d[4],
	    				"holiday" => $d[5],
	    				"LWP" => $d[6],
	    				"total_leave" => $d[7], 
	    				"paid_days" => $d[8],
	    				"total" => $d[9],
	    			];
    				
    				$this->db->insert('attandance', $arr);
    			}
   			}
		}
		redirect(base_url('attendance'));
	}



}
