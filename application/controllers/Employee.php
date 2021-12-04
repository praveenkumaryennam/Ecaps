<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Employee extends CI_Controller {
	function __Construct(){
		parent::__Construct();
		if($this->session->userdata('username') == '')
			redirect('logout');

		$this->data['info'] = info(true);

		$this->data['header_content'] = (object)[
			'title' => 'Employee',
			'sub_title' => 'Masters',
			'path' => uri_string(),
		];

		$this->data['sidebar'] = (object)[
			'menu' => $this->uri->segment(1),
			'submenu' => $this->uri->segment(2)
		];

		$this->load->model('employee_m');
		$this->data['script'] = "employee";
		$this->load->library('excel');
	}

	function index(){
		$this->data['randerPage'] = "employee/index";
		$this->data['rows'] = $this->employee_m->get();
		log_data(['text'=>'Employee List Opened', 'data'=>null]);
		$this->load->view('_layout', $this->data);
	}

	function add(){
		$this->data['randerPage'] = "employee/add";
		log_data(['text'=>'New Employee Form Opend', 'data'=>null]);
		$this->load->view('_layout', $this->data);
	}

	function edit($id){
		$this->data['data'] = $this->employee_m->getemployee($id);
		$this->data['emp'] = $this->employee_m->getempfamily($id);
		$this->data['randerPage'] = "employee/edit";
		log_data(['text'=>'Employee Edit Opened For Employee ID  - '. $id, 'data'=>null]);
		$this->load->view('_layout', $this->data);
	}


	function addemployee(){
		$data['emp'] =[
			'image' => $this->do_upload(),
			'firstname' => $this->input->post('name', true),
			'middlename' => $this->input->post('mname', true),
			'lastname' => $this->input->post('lname', true),
			'gender' => $this->input->post('gender', true),
			'mobile' => $this->input->post('mobile', true),
			'email' => $this->input->post('email', true),
			'dob' => date('Y-m-d', strtotime($this->input->post('dob', true))),
			'phone' => $this->input->post('phone', true),
			'role' => $this->input->post('role', true),
			'code' => $this->input->post('code', true),
			'doj' => date('Y-m-d', strtotime($this->input->post('doj', true))),
			'designation' => $this->input->post('designation', true),
			'department' => $this->input->post('department', true),
			'lab_department' => $this->input->post('lab_department', true),
			'location' => $this->input->post('location', true),
			'shiftgroup' => $this->input->post('shiftgroup', true),
			'pan' => $this->input->post('pan', true),
			'uid' => $this->input->post('uid', true),
			'address1' => $this->input->post('address1', true),
			'address2' => $this->input->post('address2', true),
			'added_at' => date('Y-m-d H:i:s'),
			'added_by' => login_user(),
		];

		$data['family'] = [
			'name' => $this->input->post('fname', true),
			'dob' => $this->input->post('fdob', true),
			'gender' => $this->input->post('fgender', true),
			'relation' => $this->input->post('relation', true),
		];

		if($this->employee_m->add($data)){
			log_data(['text'=>'New Employee Added', 'data'=>$data]);
			redirect(base_url('employee'));
		}
	}


	function updateemployee(){
		$data['emp'] =[
			'image' => $this->do_upload(),
			'firstname' => $this->input->post('name', true),
			'middlename' => $this->input->post('mname', true),
			'lastname' => $this->input->post('lname', true),
			'gender' => $this->input->post('gender', true),
			'mobile' => $this->input->post('mobile', true),
			'email' => $this->input->post('email', true),
			'dob' => date('Y-m-d', strtotime($this->input->post('dob', true))),
			'phone' => $this->input->post('phone', true),
			'role' => $this->input->post('role', true),
			'code' => $this->input->post('code', true),
			'doj' => date('Y-m-d', strtotime($this->input->post('doj', true))),
			'designation' => $this->input->post('designation', true),
			'department' => $this->input->post('department', true),
			'lab_department' => $this->input->post('lab_department', true),
			'location' => $this->input->post('location', true),
			'shiftgroup' => $this->input->post('shiftgroup', true),
			'pan' => $this->input->post('pan', true),
			'uid' => $this->input->post('uid', true),
			'address1' => $this->input->post('address1', true),
			'address2' => $this->input->post('address2', true),
			'added_at' => date('Y-m-d H:i:s'),
			'added_by' => login_user(),
		];

		$data['family'] = [
			'name' => $this->input->post('fname', true),
			'dob' => $this->input->post('fdob', true),
			'gender' => $this->input->post('fgender', true),
			'relation' => $this->input->post('relation', true),
			'lid' => $this->input->post('lid', true),
		];

		if($this->employee_m->update($data, $this->input->post('emplyeeid', true))){
			log_data(['text'=>'Employee Data Updated', 'data'=>$data]);
			redirect(base_url('employee'));
		}
	}

	public function do_upload(){
        $config['upload_path']          = './uploads/employees/';
        $config['allowed_types']        = 'gif|jpg|png';
        $config['max_size']             = 0;
        $config['max_width']            = 0;
        $config['max_height']           = 0;
        $config['encrypt_name']           = true;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('image')){
        	return base_url()."/assets/dist/img/rpdlogo.png";
            $error = array('error' => $this->upload->display_errors());
            // print_r($error);
        }else{
            $res = $this->upload->data();
        	return base_url('uploads/employees/').$res['file_name'];
        }
    }


    //Import File
    function import(){
    	if(isset($_FILES["importfile"]["name"])){
			$path = $_FILES["importfile"]["tmp_name"];
   			$object = PHPExcel_IOFactory::load($path);
   			
   			$arr = [];
   			foreach($object->getWorksheetIterator() as $worksheet){
			    $highestRow = $worksheet->getHighestRow();
			    $highestColumn = $worksheet->getHighestColumn();
				
				for($row = 2; $row <= $highestRow; $row++){
					if($worksheet->getCellByColumnAndRow(0, $row)->getValue() != ""){
						$data['emp'] = [
							'image' => base_url('assets/dist/img/rpdlogo.png'),
							'firstname' => $worksheet->getCellByColumnAndRow(0, $row)->getValue(),
							'middlename' => $worksheet->getCellByColumnAndRow(1, $row)->getValue(),
							'lastname' => $worksheet->getCellByColumnAndRow(2, $row)->getValue(),
							'gender' => $worksheet->getCellByColumnAndRow(3, $row)->getValue(),
							'mobile' => $worksheet->getCellByColumnAndRow(4, $row)->getValue(),
							'email' => $worksheet->getCellByColumnAndRow(5, $row)->getValue(),
							'dob' => $worksheet->getCellByColumnAndRow(6, $row)->getValue(),
							'phone' => $worksheet->getCellByColumnAndRow(7, $row)->getValue(),
							'role' => masertcode($worksheet->getCellByColumnAndRow(8, $row)->getValue(),'role'),
							'code' => $worksheet->getCellByColumnAndRow(9, $row)->getValue(),
							'doj' => $worksheet->getCellByColumnAndRow(10, $row)->getValue(),
							'designation' => masertcode($worksheet->getCellByColumnAndRow(11, $row)->getValue(),'designation'),
							'department' => masertcode($worksheet->getCellByColumnAndRow(12, $row)->getValue(),'department'),
							'lab_department' => masertcode($worksheet->getCellByColumnAndRow(13, $row)->getValue(),'labdepartment'),
							'location' => masertcode($worksheet->getCellByColumnAndRow(14, $row)->getValue(),'location'),
							'shiftgroup' => $worksheet->getCellByColumnAndRow(15, $row)->getValue(),
							'pan' => $worksheet->getCellByColumnAndRow(16, $row)->getValue(),
							'uid' => $worksheet->getCellByColumnAndRow(17, $row)->getValue(),
							'address1' => $worksheet->getCellByColumnAndRow(18, $row)->getValue(),
							'address2' => $worksheet->getCellByColumnAndRow(19, $row)->getValue(),
							'added_at' => date('Y-m-d H:i:s'),
							'added_by' => login_user(),
						];

						$name = [];
						$dob = [];
						$gender = [];
						$relationopt = ['father', 'mother', 'spouse', 'child', 'child'];
						$relation = [];
						for ($i=0;$i<5;$i++){
							$temp = $worksheet->getCellByColumnAndRow(22+$i, $row)->getValue();
							if($temp != ''){
								$temp = explode('-', $temp);
								$name[] = $temp[0];
								$dob[] = date('Y-m-d', strtotime($temp[1]));
								$gender[] = $temp[2];
								$relation[] = $relationopt[$i];
							}
						}

						$data['family'] = [
							'name' => $name,
							'dob' => $dob,
							'gender' => $gender,
							'relation' => $relation,
						];
						$data['login'] = [
							'role' => $data['emp']['role'],
							'username' => $worksheet->getCellByColumnAndRow(20, $row)->getValue(),
							'password' => $worksheet->getCellByColumnAndRow(21, $row)->getValue(),
						];
                        
                        if($this->employee_m->add($data))
							log_data(['text'=>'Employee excal Import', 'data'=>$data]);
					}
    			}
   			}
   			redirect(base_url('employee'));
		}
    }

    //Files Upload 
	public function fileupload() {
	    $file_path = "./uploads/employee/";

	    if (isset($_FILES['files'])) {
	        
	        if (!is_dir('uploads/employee/')) {
	            mkdir('./uploads/employee/', 0777, TRUE);
	        }

	        $files = $_FILES;
	        $cpt = count($_FILES ['files'] ['name']);
	        for ($i = 0; $i < $cpt; $i ++) {
	            $name = time().$files ['files'] ['name'] [$i];
	            $_FILES ['files'] ['name'] = $name;
	            $_FILES ['files'] ['type'] = $files ['files'] ['type'] [$i];
	            $_FILES ['files'] ['tmp_name'] = $files ['files'] ['tmp_name'] [$i];
	            $_FILES ['files'] ['error'] = $files ['files'] ['error'] [$i];
	            $_FILES ['files'] ['size'] = $files ['files'] ['size'] [$i];
				
				$this->load->library('upload');
	            $this->upload->initialize($this->set_upload_options($file_path));
	            if(!($this->upload->do_upload('files')) || $files ['files'] ['error'] [$i] !=0)
	            {
	                print_r($this->upload->display_errors());
	            }
	            else
	            {	
	            	$a = $this->upload->data();
	            	$data = [
	            		'empid' => $this->input->post('empid'),
	            		'filepath' => base_url().'uploads/employee/'.$a['file_name'],
	            	];
	            	if($this->db->insert('employeefiles', $data))
	            		log_data(['text'=>'Employee File Upload', 'data'=>$data]);
	            }
	        }
	    }
	    redirect(base_url('employee'));
	}

	public function set_upload_options($file_path) {
	    // upload an image options
	    $config = array();
	    $config ['upload_path'] = $file_path;
	    $config ['encrypt_name'] = true;
	    $config ['allowed_types'] = 'gif|jpg|png';
	    return $config;
	}

	function salarysetup(){
		$this->data['randerPage'] = "employee/salary";
		log_data(['text'=>'Employee List Opened', 'data'=>null]);
		$this->load->view('_layout', $this->data);
	}

	function salarygenrate(){
		$this->data['rows'] = $this->employee_m->get();
		$this->data['randerPage'] = "employee/salarygenrate";
		log_data(['text'=>'Employee List Opened', 'data'=>null]);
		$this->load->view('_layout', $this->data);
	}

	function dlt_status($id, $sts){
		$this->db->set('status', $sts)->where('id', $id)->update('employee');
		if($this->db->affected_rows() > 0) {
			echo true;
		}
	}
}
