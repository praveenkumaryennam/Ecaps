<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Checksession {
    
	function is_valid_session(){
		$this->config();
		if($this->ci->session->userdata('is_login') == true){
			$this->ci->session->set_userdata('session_login_key', rand(999999999999999999, 111111111111111111));
		}else{
			$this->ci->session->set_userdata('is_login', false);
			// redirect(base_url());
		}
	}
	
	//Check Ip Address is Allow or Not
	function is_valid_ip(){
	    $url = $_SERVER['REQUEST_URI'];
        $blockedIps = array('183.87.104.125', '103.100.16.211', '115.96.221.196');
        $currentUserIp = $_SERVER['REMOTE_ADDR'];
        if($url != '/validate/warrantycard'){
            if(!in_array($currentUserIp, $blockedIps)){
                header("Location: page-not-found");
                die(); 
            } 
        }
	}
	
	//Load Session Library
	private function config(){
		$this->ci = &get_instance();
        if (!isset($this->ci->session)){
            $this->ci->load->library('session');
        }
	}
}