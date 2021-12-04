<?php  defined('BASEPATH') OR exit('No direct script access allowed');
	
	/***
	* Teeth Side i.e: upper and lower (l ,r)
	*/
	function get_teeth_sides($order_id, $product = false){
		$p1 = $p2 = $p3 = $p4 = array();
        $a = [
          11 =>  1,
          12 =>  2,
          13 =>  3,
          14 =>  4,
          15 =>  5,
          16 =>  6,
          17 =>  7,
          18 =>  8,
          21 =>  1,
          22 =>  2,
          23 =>  3,
          24 =>  4,
          25 =>  5,
          26 =>  6,
          27 =>  7,
          28 =>  8,
          31 =>  1,
          32 =>  2,
          33 =>  3,
          34 =>  4,
          35 =>  5,
          36 =>  6,
          37 =>  7,
          38 =>  8,
          41 =>  1,
          42 =>  2,
          43 =>  3,
          44 =>  4,
          45 =>  5,
          46 =>  6,
          47 =>  7,
          48 =>  8,
        ];
        
        if($order_id != null && $product != null)
        	$th = explode(',', get_teeth($order_id, $product));
        else
        	$th = explode(',', $order_id);

        asort($th);
        foreach ($th as $te){
          if($te >= 11 && $te <= 18){
            $p1[] = $a[$te];
          }

          if($te >= 21 && $te <= 28){
            $p2[] = $a[$te];
          }

          if($te >= 41 && $te <= 48){
            $p3[] = $a[$te];
          }

          if($te >= 31 && $te <= 38){
            $p4[] = $a[$te];
          }
        }
        rsort($p1);
        rsort($p3);
        return ['p1'=>$p1, 'p2'=>$p2, 'p3'=>$p3, 'p4'=>$p4];
	}

	/***
	* Get Teeth by Order and Product id (Primary Key)
	*/
	function get_teeth($order_id, $product){
		$ci = &get_instance();
		return $ci->db->select('teeth')->where(['order_id' => $order_id, 'product_id' => $product])->get('order_products')->row('teeth');
	}