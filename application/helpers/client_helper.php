<?php  defined('BASEPATH') OR exit('No direct script access allowed');
	
	/***
	* Client Name by id (Primary Key)
		-- rpd_clients
		output -> "name" as string
	*/
	function get_clientname($id){
		$ci = &get_instance();
		return $ci->db->where('id', $id)->or_where('code', $id)->get('clients')->row()->clientname;
	}

	function get_client_remark($id){
		$ci = &get_instance();
		return $ci->db->where('id', $id)->get('clients')->row()->remark1;
	}

	function get_client_category($id){
		$ci = &get_instance();
		$code = $ci->db->where('id', $id)->get('clients')->row()->customercateory;
		return $ci->db->where('code', $code)->get('client_category')->row()->title;
	}

	/***
	* Client Basic Information by id (Primary Key) OR Code
		-- rpd_clients
	*/
	function get_clientdata($id){
		$ci = &get_instance();
		return $ci->db->select('c.id, c.clientname as name, co.country, s.state, ci.city, c.address, c.landmark, c.area, c.mobile, c.email, c.pincode, c.creditdays')
		->from('clients as c')
		->join('country as co','co.id = c.country','inner')
		->join('states as s','s.id = c.state','inner')
		->join('cities as ci','ci.id = c.city','inner')
		->where('c.id', $id)
		->or_where('c.code', $id)
		->get()->row();
	}

	/***
	* Product Assign to Client List by id (Primary Key)
		-- rpd_client_products
			-- $cat = fasle, if TRUE(Get Product By Category)
			-- $id  = client id (Primary Key)

	*/
	function client_product($id, $cat = false){
		$ci = &get_instance();
		if($cat){
			return $ci->db->query('SELECT p.*, c.title as category FROM rpd_product as p INNER JOIN rpd_productcategory as c ON c.code = p.category WHERE p.category = '.$cat.' AND p.code NOT IN (SELECT product_id FROM rpd_client_products WHERE client_id = '.$id.')')->result();
		}
		return $ci->db->query('SELECT p.*, c.title as category FROM rpd_product as p INNER JOIN rpd_productcategory as c ON c.code = p.category WHERE p.code NOT IN (SELECT product_id FROM rpd_client_products WHERE client_id = '.$id.')')->result();
	}

	/**
	* Get Number of times clients bolck
	*/
	function block_count($id){
		$ci = &get_instance();
		return $ci->db->where('client_id', $id)->get('client_block')->num_rows();
	}

	/**
	* Get Last Block Date and Time
	*/
	function block_date($id){
		$ci = &get_instance();
		return $ci->db->select('from_datetime as date')->where('client_id', $id)->order_by('id', 'desc')->get('client_block')->row('date');
	}

	/**
	* Get Target Data
	*/
	function get_target_data($id, $m, $year){
		$ci = &get_instance();
		return $ci->db->select('demp,target, incentive')->where(['employee_code' => $id, 'month' => $m, 'year' => $year])->get('employee_target')->row();
	}

	function getoffers($type = false){
		$ci = &get_instance();
		$ci->db->select('id, title');
		if($type){
			$ci->db->where('offeringtype', 'pro');
		}else{
			$ci->db->where('offeringtype !=', 'pro');
		}
		$res = $ci->db->get('offer')->result();
		return $res;
	}

	function get_client_offer($clientId, $amt, $pid = false){
		$ci = &get_instance();
		$res = $ci->db->where('client_id', $clientId)->get('offer_meta');
		// $offer = '';
		if($res->num_rows() > 0){
			$res = $res->row();
			switch($res->offer_type){
				case '1':
					$res = $ci->db->where('product_id', $pid)->get('offer_products')->row();
					$offer = $ci->db->where(['id' => $res->offer_id, 'status' => 0, 'minimum_order <=' => $amt])->get('offer');
					break;
				case '2':
					$offer = $ci->db->where(['minimum_order <= ' => $amt, 'status' => 0, 'offeringtype !=' => 'pro'])->order_by('id', 'desc')->get('offer');
					break;
			}
			return $offer->row();
		}
	}

		function order_form_encloser(){
		return '<tr>
                    <td><input type="checkbox" name="type" data-value="Abutments" data-id="1" ></td>
                    <td>Abutments</td>
                    <td><input type="text" id="en1" /></td>
                  </tr>

                  <tr>
                    <td><input type="checkbox" name="type" data-value="Bite" data-id="2"></td>
                    <td>Bite</td>
                    <td><input type="text" id="en2" /></td>
                  </tr>

                  <tr>
                    <td><input type="checkbox" name="type" data-value="CAD CAM Files" data-id="3"></td>
                    <td>CAD CAM Files</td>
                    <td><input type="text" id="en3" /></td>
                  </tr>

                  <tr>
                    <td><input type="checkbox" name="type" data-value="Facebow Articulator" data-id="4"></td>
                    <td>Facebow Articulator</td>
                    <td><input type="text" id="en4" /></td>
                  </tr>

                  <tr>
                    <td><input type="checkbox" name="type" data-value="Imp Post" data-id="5"></td>
                    <td>Imp Post</td>
                    <td><input type="text" id="en5" /></td>
                  </tr>

                  <tr>
                    <td><input type="checkbox" name="type" data-value="Impression Lower" data-id="6"></td>
                    <td>Impression Lower</td>
                    <td><input type="text" id="en6" /></td>
                  </tr>

                  <tr>
                    <td><input type="checkbox" name="type" data-value="Impression Upper" data-id="7"></td>
                    <td>Impression Upper</td>
                    <td><input type="text" id="en7" /></td>
                  </tr>

                  <tr>
                    <td><input type="checkbox" name="type" data-value="Lab Analogue" data-id="8"></td>
                    <td>Lab Analogue</td>
                    <td><input type="text" id="en8" /></td>
                  </tr>

                  <tr>
                    <td><input type="checkbox" name="type" data-value="Model Upper" data-id="9"></td>
                    <td>Model Lower</td>
                    <td><input type="text" id="en9" /></td>
                  </tr>

                  <tr>
                    <td><input type="checkbox" name="type" data-value="Model Upper" data-id="10"></td>
                    <td>Model Upper</td>
                    <td><input type="text" id="en10" /></td>
                  </tr>

                  <tr>
                    <td><input type="checkbox" name="type" data-value="Photos" data-id="11"></td>
                    <td>Photos</td>
                    <td><input type="text" id="en11" /></td>
                  </tr>

                  <tr>
                    <td><input type="checkbox" name="type" data-value="Crown Received" data-id="12"></td>
                    <td>Crown Received</td>
                    <td><input type="text" id="en12" /></td>
                  </tr>';
	}