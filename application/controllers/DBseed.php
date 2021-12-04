<?php defined('BASEPATH') OR exit('No direct script access allowed');



class DBseed extends CI_Controller {
	function __construct(){
		parent::__construct();
		$this->load->dbforge();
	}


	function index(){
		if($this->dbforge->create_database('rpd')){
			echo 'Database created successfully...';
		}
	}
}