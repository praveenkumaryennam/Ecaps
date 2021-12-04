<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Organigation_m extends CI_Model {
	function __constuct(){
		parent::__constuct();
	}

	function companyadd(){
		$arr = [
			'image' => $this->do_upload(),
			"title" => $this->input->post('name', true),
			"mobile" => $this->input->post('mobile', true),
			"tel" => $this->input->post('tel', true),
			"email" => $this->input->post('email', true),
			"fax" => $this->input->post('fax', true),	
			"pan" => $this->input->post('pan', true),	
			"gst" => $this->input->post('gst', true),	
			"cin" => $this->input->post('cin', true),	
			"website" => $this->input->post('website', true),	
			"address" => $this->input->post('address', true),	
			"image" => $this->do_upload(),
			"added_by" => date('Y-m-d H:i:s'),
		];
		return $arr;
		return $this->db->insert('company', $arr);
	}

	function companys(){
		return $this->db->get('company')->result();
	}

	function allrows($tbl){
		return $this->db->get($tbl)->result();
	}

	function add($tbl){
		$arr = [
			"title" => $this->input->post('title', true),
			"code" => $this->input->post('code', true),
		];
		return $this->db->insert($tbl, $arr);
	}

	function correction_template_add($tbl){
		$arr = [
			"title" => $this->input->post('title', true)
		];
		return $this->db->insert($tbl, $arr);
	}

	function country($_is = false){
		if($_is)
			return $this->db->get('country')->result();
		$arr = [
			"country" => $this->input->post('title', true),
		];
		return $this->db->insert("country", $arr);	
	}

	function state($_is = false, $con = false){
		if($_is){
			if($con){
				return $this->db->select('s.*, c.country')->where('c.id = s.country')->where('s.country',$con)->get('states as s, country as c')->result();
			}else{
				return $this->db->select('s.*, c.country')->where('c.id = s.country')->get('states as s, country as c')->result();
			}
		}
		$arr = [
			"state" => $this->input->post('state', true),
			"country" => $this->input->post('country', true),
		];
		return $this->db->insert("states", $arr);	
	}

	function city($_is = false, $state = false){
		if($_is){
			$this->db->select('ci.*, s.state, c.country')->from('cities as ci')->join('states as s', 's.id = ci.state', 'inner')->join('country as c', 'c.id = ci.country', 'inner');
			if($state)
				$this->db->where('ci.state', $state);

			return $this->db->get()->result();
		}
		
		$arr = [
			"city" => $this->input->post('city', true),
			"state" => $this->input->post('state', true),
			"country" => $this->input->post('country', true),
		];
		return $this->db->insert("cities", $arr);	
	}

	function stations($_is = false, $city = false){
		if($_is){
			$this->db->select('st.*, s.state, c.country, ci.city')->from('stations as st')->join('states as s', 's.id = st.state', 'inner')->join('country as c', 'c.id = st.country', 'inner')->join('cities as ci', 'ci.id = st.city', 'inner');
			if($city){
				$this->db->where('st.city', $city);
			}
			return $this->db->get()->result();
		}
		
		$arr = [
			"station" => $this->input->post('station', true),
			"city" => $this->input->post('city', true),
			"state" => $this->input->post('state', true),
			"country" => $this->input->post('country', true),
		];
		return $this->db->insert("stations", $arr);
	}

	public function do_upload(){
        $config['upload_path']          = './uploads/companys/';
        $config['allowed_types']        = 'gif|jpg|png';
        $config['max_size']             = 0;
        $config['max_width']            = 0;
        $config['max_height']           = 0;
        $config['encrypt_name']         = true;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('image')){
            $error = array('error' => $this->upload->display_errors());
        }else{
            $res = $this->upload->data();
        	return base_url('uploads/companys/').$res['file_name'];
        }
    }
}
