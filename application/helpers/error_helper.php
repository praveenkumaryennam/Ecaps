<?php 
	$arr = [
		1051 => "code exits",
	];

	function error($error){
		return $arr[$error];
	}

	function log_data($data){
		$ci = &get_instance();
		$data = ['log' => json_encode([
			'username' => $ci->session->userdata('username'),
			'userid' => $ci->session->userdata('userid'),
			'role' => $ci->session->userdata('role'),
			'log' => $data['text'],
			'work' => $data['data'],
			'added_at' => date('Y-m-d H:i:s')
		])];
		$ci->db->insert('logs', $data);
	}