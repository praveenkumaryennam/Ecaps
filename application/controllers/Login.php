<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->model('login_m');
	}

	function index(){
		$this->output->cache(1);
		if($_SERVER['REQUEST_METHOD'] === "POST"){
			$this->validateUser();
			return;
		}
		if($this->session->userdata('is_login') == true){
            redirect('/dashboard');
        }else{
            $this->load->view('_login_layout');
        }
	}

	function validateUser(){
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		if(!empty($username) && !empty($password)){
			if($username == 'admin'){
				$this->session->set_userdata('is_master', true);
				$res = $this->login_m->validate($username, $password, 'master');
			}else{			
				$this->session->set_userdata('is_master', false);
				$res = $this->login_m->validate($username, $password);
			}
			

			if($res){
				if($username == 'admin'){
					$array = [
						'username' => $username,
						'userid' => 'admin',
						'role' => 'master',
						'is_login' => true
					];

					$this->session->set_userdata($array);
					if($this->is_changed_pwd($username) == 1){
						redirect('/newpassword');
					}else{
						redirect('/dashboard');
					}
				}else{





					if($res->role == 'dec'){



						$array = [
							'username' => $res->empid,
							'userid' => $res->empid,
							'role' => strtolower($res->role),
							'previlize' => $res->previlize,
							'is_login' => true
						];
					}else{
						$array = [
							'username' => $res->empid,
							'userid' => $res->empid,
							'role' => strtolower($res->role),
							'previlize' => $res->previlize,
							'is_login' => true
						];
					}



					$this->session->set_userdata($array);

					if ($this->is_changed_pwd($username) == 0) {
						redirect('/newpassword');
					} else {
						redirect('/dashboard');
					}
				}
			}else{
				echo "invalid user";
			}
		}
		$this->logout();
	}

	function changepassword($is_change = false){
		if ($this->session->userdata('username') == '')
			redirect('logout');

		if($this->is_changed_pwd($this->session->userdata('username')) == 1 && $is_change == false){
			redirect('/dashboard');
		}
		
		if($_POST){
			$this->db
			->set(['is_changed' => 1, 'password' => $_POST['password']])
			->where('username', $this->session->userdata('username'))
			->or_where('empid', $this->session->userdata('username'))
			->update('users');
			if($this->db->affected_rows() > 0){
				redirect('/logout');
			}
			return;
		}
		$this->load->view('_changepassword');
	}

	private function is_changed_pwd($user){
		return $this->db->where('username', $user)->where('is_changed', 1)->get('users')->num_rows();
	}

	function logout(){
        $this->session->sess_destroy();
        redirect('/');
	}
}
