<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Cronjob extends CI_Controller {
	function init_target(){
		$year = (date('m') == 1)?(date('Y')-1):date('Y');
		$month = (date('m') == 1)?12:date('m');

		$chk = $this->db->where(['year' => date('Y'), 'month' => date('m')])->get('employee_target')->num_rows();
		if($chk == 0){
			$data_set = $this->db->select('type, month, year, employee_code, is_type, demp, target, incentive, set_by')->where(['year' => $year, 'month' => $month-1, 'status' => 0])->get('employee_target')->result_array();

			foreach ($data_set as $row) {
				$data = [
					'type' => $row['type'],
					'month' => date('m'),
					'year' => date('Y'),
					'employee_code' => $row['employee_code'],
					'is_type' => $row['is_type'],
					'demp' => $row['demp'],
					'target' => $row['target'],
					'incentive' => $row['incentive'],
					'datetime' => date('Y-m-d H:i:s'),
					'set_by' => $row['set_by'],
				];
				$this->db->insert('employee_target', $data);
			}
		}
	}
}
