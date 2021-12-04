<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Backup extends CI_Controller {
	function __Construct(){
		parent::__Construct();
		$this->load->dbutil();
		$this->load->helper('download');
	}

	function index(){
		ini_set('memory_limit', '1024M');
		if($this->dbutil->database_exists($this->config->item('database'))){
			$bkp_prep = array(        
				'tables'        => array(),   // Array of tables to backup.
		        'ignore'        => array(),   // List of tables to omit from the backup
		        'format'        => 'zip',     // gzip, zip, txt
		        'filename'      => 'database_'.date('Ymd_Hi').'.sql', // File name - NEEDED ONLY WITH ZIP FILES
		        'add_drop'      => TRUE,  // Whether to add DROP TABLE statements to backup file
		        'add_insert'    => TRUE,  // Whether to add INSERT data to backup file
		        'newline'       => "\n"   // Newline character used in backup file
			);

			$backup = $this->dbutil->backup($bkp_prep);
			$db_name = 'backup-on-'. date("Y-m-d-H-i-s") .'.zip';
			$save = 'assets/database/'.$db_name;

			$this->load->helper('download');
			force_download($db_name, $backup);
		}
	}


	function cmd_bkp(){
		$filename='database_backup_'.date('G_a_m_d_y').'.sql';

		$result=exec('mysqldump classont_ecaps --password=ecaps@123# --user=classont_ecaps --single-transaction >assets/database/'.$filename,$output);

		if(empty($output))
			echo 'done';
		else
			echo 'error';
	}


}
