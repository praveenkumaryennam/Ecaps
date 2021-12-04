<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Clientproduct extends CI_Controller {
	function index(){

		$docs = $this->db->where('id >', 1017)->get('clients')->result();
		$pros = $this->db->select('code')->get('product')->result();
		$i = 1;
		foreach($docs as $d){
			$is_check = $this->db->where('client_id', $d->id)->get('client_products')->num_rows();
			if($is_check > 0 ){
				echo $d->code.'<br>';
				continue;
			}else{
				foreach($pros as $p){
					$arr = [
						'client_id' => $d->id,
						'product_id' => $p->code,
						'discount' => 0,
					];
					if($this->db->insert('client_products', $arr))
						echo $i++;
				}
			}
		}

	}
}