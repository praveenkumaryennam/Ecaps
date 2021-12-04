<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Login_m extends CI_Model {
	function __construct()
	{
		parent::__construct();
	}

	function validate($username, $password, $tbl = false){
		if($tbl)
			$res = $this->db->where(['username' => $username, 'password' =>  $password, 'status' => 0])->get('master');
		else
			$res = $this->db->where(['username' => $username, 'password' =>  $password, 'status' => 0])->get('users');

		if($res->num_rows() > 0)
			return $res->row();
	}
}
