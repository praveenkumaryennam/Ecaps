<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Inventory extends CI_Controller {
	function __Construct(){
		parent::__Construct();
	}

	function index(){
		$str = "email=accounts@rtpl.com&pwd=admin@123";
		$enc = base64_encode($str);
		redirect("https://accounts.ecapscrm.com/auth/login?_k=".urlencode($enc));
	}
}