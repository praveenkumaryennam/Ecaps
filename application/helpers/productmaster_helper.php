<?php
	function loadoptions($tbl){
		$ci = &get_instance();
		if($tbl == 'warranty'){
			return $ci->db->where('status', 0)->get($tbl)->result();
		}
		return $ci->db->where('status', 0)->get('product'.$tbl)->result();
	}

	function get_products(){
		$ci = &get_instance();
		return $ci->db->select('code, title, unit_price')->get('product')->result();
	}

	function client_report($id){
		$ci = &get_instance();
		$aa = [];
		for($a=1;$a<=12;$a++){
			$res = $ci->db->where('month', $a)->where('client_id', $id)->get('client_report')->result();
			$aa[$a] = $res;
		}
		return $aa;
	}

	function getinvoicedate($in){
		$ci = &get_instance();
		return $ci->db->where('invoice_number', $in)->get('invoice')->row()->invoice_date;
	}

	function client_order_report($id){
		$ci = &get_instance();
		$aa = [];
		for($a=1;$a<=12;$a++){
			$res = $ci->db->where('month', $a)->where('client_code', $id)->get('client_order_report')->result();
			$aa[$a] = $res;
		}
		return $aa;
	}

	function get_v($data, $_is = false){
	    if($_is){
	      return $data->volume;
	    }else{
	      return $data->units;
	    }
	  }

	function loadrxoptions(){
		return  [
			[
				'id' => 1,
				'label' => 'Restoration Type',
				'options' => [
					[
						'id' => 1,
						'option' => 'Separate Crown', 
					],
					[
						'id' => 2,
						'option' => 'Joint Crown', 
					],
					[
						'id' => 3,
						'option' => 'Bridge', 
					],
				],
			],
			[
				'id' => 2,
				'label' => 'Margins',
				'options' => [
					['id'=>1,'option'=>'NA'],
					['id'=>2,'option'=>'Porcelain Margin'],
					['id'=>3,'option'=>'Metal Margin'],
					['id'=>4,'option'=>'Gingival Margin'],
					['id'=>5,'option'=>'Disappearing Margin'],
					['id'=>6,'option'=>'Shoulder Margin'],
				],
			],
			[
				'id' => 3,
				'label' => 'Occlusal Staining',
				'options' => [
					['id'=>1, "option" => 'None'],
					['id'=>2, "option" => 'Light'],
					['id'=>3, "option" => 'Medium'],
					['id'=>4, "option" => 'Heavy'],
				],
			],
			[
				'id' => 4,
				'label' => 'Transclucency',
				'options' => [
					['id' => 1, 'option' => 'NA'],
					['id' => 2, 'option' => 'Light'],
					['id' => 3, 'option' => 'Medium'],
					['id' => 4, 'option' => 'Nuetral'],
					['id' => 5, 'option' => 'Gray'],
					['id' => 6, 'option' => 'Heavy'],
					['id' => 7, 'option' => 'Dark'],
					['id' => 8, 'option' => 'Blue']
				],
			],[
				'id' => 5,
				'label' => 'Non Occlusal clearance',
				'options' => [
					['id'=>"1", 'option'=>'Reduce and mark Prep'],
					['id'=>"2", 'option'=>'Reduce and mark Opposing'],
					['id'=>"3", 'option'=>'Reduction Coping'],
					['id'=>"4", 'option'=>'Call Doctor'],
				],
			],[
				'id' => 6,
				'label' => 'Pontic Design',
				'options' => [
					['id'=>"1",'option'=>'Full Ridge Lap'],
					['id'=>"2",'option'=>'Modified Ridge Lap'],
					['id'=>"3",'option'=>'Oviate'],
					['id'=>"4",'option'=>'No Contact Sanitary'],
				],
			],[
			    'id' => 7,
			    'label' => 'Collar and Metal Design',
			    'options' => [
			        ['id'=>1, 'option'=>'No Collar'],
			        ['id'=>2, 'option'=>'Lingual Collar'],
			        ['id'=>3, 'option'=>'360 collar'],
			    ],
			],[
			    'id' => 8,
			    'label' => 'Margin For Implant Direct Impression',
			    'options' => [
			        ['id'=>1, 'option'=>'Abutment Finish Line'],
			        ['id'=>2, 'option'=>'Gingival finish Line'],
			    ],
			],[
			    'id' => 9,
			    'label' => 'Margin For Implant Indirect Impression',
			    'options' => [
			        ['id'=>1, 'option'=>'Supragingival'],
			        ['id'=>2, 'option'=>'Equigingival'],
			        ['id'=>3, 'option'=>'0.5 mm subgingival'],
			        ['id'=>4, 'option'=>'1 mm sub gingival'],
			    ],
			],[
			    'id' => 10,
			    'label' => 'Occlusal Platform',
			    'options' => [
			        ['id'=>1, 'option'=>'Light'],
			        ['id'=>2, 'option'=>'Ideal'],
			        ['id'=>3, 'option'=>'Infra'],
			    ],
			],[
			    'id' => 11,
			    'label' => 'Embrasures',
			    'options' => [
			        ['id'=>1, 'option'=>'Closed'],
			        ['id'=>2, 'option'=>'Open'],
			    ],
			],[
			    'id' => 12,
			    'label' => 'Proximal contacts',
			    'options' => [
			        ['id'=>1, 'option'=>'Point'],
			        ['id'=>2, 'option'=>'normal'],
			        ['id'=>3, 'option'=>'Heavy and Broad'],
			    ],
			],[
			    'id' => 13,
			    'label' => 'Anterior Margin',
			    'options' => [
			        ['id'=>1, 'option'=>'HairLine'],
			        ['id'=>2, 'option'=>'PorceLain'],
			        ['id'=>3, 'option'=>'PorceLain butt'],
			    ],
			],[
			    'id' => 14,
			    'label' => 'Posterior Margin',
			    'options' => [
			        ['id'=>1, 'option'=>'Metal'],
			        ['id'=>2, 'option'=>'Porcelain'],
			    ],
			],[
			    'id' => 15,
			    'label' => 'Buccal Margin',
			    'options' => [
			        ['id'=>1, 'option'=>'HairLine'],
			        ['id'=>2, 'option'=>'PorceLain'],
			        ['id'=>3, 'option'=>'PorceLain butt'],
			    ],
			],[
			    'id' => 16,
			    'label' => 'Gingival warming',
			    'options' => [
			        ['id'=>1, 'option'=>'None'],
			        ['id'=>2, 'option'=>'Light'],
			        ['id'=>3, 'option'=>'Medium'],
			        ['id'=>4, 'option'=>'Heavy'],
			    ],
			],
		];
	}
