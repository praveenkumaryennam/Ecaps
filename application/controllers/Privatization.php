<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Privatization extends CI_Controller {
	function __Construct(){	
		parent::__Construct();
		if($this->session->userdata('username') == '')
			redirect('logout');
		
		$this->data['info'] = info(true);
		$this->data['header_content'] = (object)[
			'title' => 'Control',
			'sub_title' => 'Masters',
			'path' => uri_string(),
		];
		$this->data['sidebar'] = (object)[
			'menu' => $this->uri->segment(1),
			'submenu' => $this->uri->segment(2)
		];
	}

	/**
	* Add Role
	*/
	function role(){
		if($_POST){
			$arr = [
				'title' => $this->input->post('role'),
				'code' => $this->input->post('code'),
			];
			$this->add_role($arr);
			$_POST = [];
		}
		$this->data['rows'] = $this->db->get('role')->result();
		$this->data['randerPage'] = "control/role";
		$this->load->view('_layout', $this->data);
	}


	/**
	* Control Managment
	*/
	function controle(){
		$this->data['opt'] = $this->db->get('role')->result();
		$this->data['randerPage'] = "control/checklist";
		$this->load->view('_layout', $this->data);
	}

	function get_controllers(){
		$opt = $this->input->post('opt');
		$this->data['res'] = $this->db->select('previlize')->where('code', $opt)->get('role')->row()->previlize;
		$opt = $this->db->get('privileges')->result();
		$menus = [];
		foreach ($opt as $k) {
			if($k->parent == 0)
			$menus[$k->id]['menu'] = [$k->label, $k->id];
			else 
			$menus[$k->parent]['child'][] = [$k->label, $k->id];
		}
		
		$this->data['opt'] = $menus;
		echo json_encode($this->load->view('control/checklist_opt', $this->data, true));
	}

	function update_role(){
		$role = $this->input->post('role');
		$menu = $this->input->post('menu');

		$res = $this->db->select('previlize')->where('code', $role)->get('role')->row()->previlize;
		
		$temp = [];

		if(!empty($res)){
			$res = json_decode($res, true);

			if(in_array($menu, $res)){
				$res = $this->array_remove_by_value($res, $menu);
			}else{
				array_push($res, $menu);
			}
		}else{
			$res[] = $menu;
		}
		$this->db->set('previlize', json_encode($res))->where('code', $role)->update('role');
	}

	private function array_remove_by_value($array, $value) {
	    return array_values(array_diff($array, array($value)));
	}

	private function add_role($arr){
		if(!$this->check_role_code($arr['code'])){
			if($this->db->insert('role', $arr))
				$this->session->set_flashdata('msg', 'Role Added.');
		}
	}

	private function check_role_code($code){
		$res = $this->db->where('code', $code)->get('role')->num_rows();
		if($res > 0)
			return true;
	}

}