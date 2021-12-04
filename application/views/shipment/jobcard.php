<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?= $this->config->item('page_title');?> | Job Card</title>
  
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="<?= base_url('assets/');?>dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?= base_url('assets/');?>dist/css/font-awesome.min.css">
  <link rel="stylesheet" href="<?= base_url('assets/');?>dist/css/ionicons.min.css">
  <link rel="stylesheet" href="<?= base_url('assets/');?>dist/css/AdminLTE.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

  <style>
    .n-bordered{
      width: 50%;
      border: 1px solid #000;
    }

    .bordered td, .n-bordered td{
      border: 1px solid black;
      padding: 2px;
    }

    .n-bordered tr:first-child td{
      border-top: none;
    }

    .n-bordered tr:last-child td{
      border-bottom: none;
    }

    .n-bordered tr td:first-child{
      border-left: none;
    }

    .n-bordered tr td:last-child{
      border-right: none;
    }
    @page {
      size: 3.9in 2.3in;
    }
  </style>
</head>
<body onload="window.print();" style="width: 377.952756px; height: 226.771654px; overflow:hidden;">
  <div class="row">
    <div class="col-xs-12">
          <table border="1" width="100%">
            <tr>
              <td>
                <b>&nbsp;<?= $this->config->item('job_card');?></b> ( <?= get_zone_by_client($od['od']->client_code);?> ) <br>
                <b>&nbsp;Dr.Name :</b>&nbsp;&nbsp;<?= strtoupper(getclientname($od['od']->client_code));?> <br>
                <?php 
                  if(get_client_category($od['od']->client_code)){
                ?>
                  <b>&nbsp;Category : ( <?= strtoupper(get_client_category($od['od']->client_code));?> )</b>
                <?php
                  }
                ?>
              </td>
              <td>
                <img src="<?= base_url('assets/barcodes/'.$od['od']->modal_no.'.png');?>" style="padding: 5px; width:100%;">
                JT : <?= (!is_numeric($od['od']->delivery_method))?$od['od']->delivery_method:''; ?>
              </td>
            </tr>
          </table>

          <table border="1" width="100%">
            <tr>
              <td><b>&nbsp;OD :</b>&nbsp;&nbsp;<?= date('d-m-Y h:i A', strtotime($od['od']->order_date));?></td>
              <td><b>&nbsp;DD :</b>&nbsp;&nbsp;<?= date('d-m-Y', strtotime($od['od']->due_date)).'('.date('h:i A', strtotime($od['od']->duetime)).')';?></td>
            </tr>
          </table>

          <table border="1" width="100%">
            <tr>
              <td><b>&nbsp;Patiant Name :</b> &nbsp;<?= strtoupper($od['od']->patiant_name);?></td>
              <td><b>&nbsp;<?= strtoupper($od['od']->work_type);?></b></td>
            </tr>
          </table>

          <table border="1" width="100%">
            <tr>
              <td width="40%"><b>&nbsp;Shade :</b>&nbsp;&nbsp;<?= strtoupper(shade_title($od['od']->shade_one)).', '.strtoupper(shade_title($od['od']->shade_two)).', '.strtoupper(shade_title($od['od']->shade_three));?></td>

              <td><b class="pull-left">&nbsp;Teeth :&nbsp;</b> 
                <?php
                $p1 = [];
                $p2 = [];
                $p3 = [];
                $p4 = [];
                foreach ($od['odp'] as $p){
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

                  $th = explode(',', $p->teeth);
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
                }

                $curr_tmp = '';
                if(!empty($od['od']->correction_tamp))
                  $curr_tmp = correction_tamp($od['od']->correction_tamp);

                rsort($p1);
                sort($p2);
                rsort($p3);
                sort($p4);

                ?>
                <table class="n-bordered pull-left">
                  <tr>
                    <td><?= implode(',',$p1);?></td>
                    <td><?= implode(',',$p2)?></td>
                  </tr>
                  <tr>
                    <td><?= implode(',',$p3)?></td>
                    <td><?= implode(',',$p4)?></td>
                  </tr>
                </table>
              </td>
            </tr>
          </table>
            
          <table border="1" width="100%">
            <tr>
              <td>&nbsp; 
                <?php
                  foreach ($od['odp'] as $p){
                    echo get_title($p->product_id, 'product').'[ '.$p->teeth.' ]<br />';
                  }
                ?>
              </td>
            </tr>
          </table>

          <table border="1" width="100%">
            <tr><td>
              <?php
                $a = [];
                $ids = order_schadules($od['od']->id);
                foreach ($ids as $id) {
                  foreach (trails_process() as $k) {
                    if($id->title == $k['id']){
                      $a[] = $k['value'];  
                    }
                  }
                }
                $List = implode(', ', $a); 
                print_r($List);
              ?>
            </td>
            <td>
              <b>OR</b> : <?= get_orders_percentage($od['od']->client_code, "REDO");?>, 
              <b>OC</b> : <?= get_orders_percentage($od['od']->client_code, "CORRECTION");?>
            </td>
            </tr>
            <tr><td colspan="2"><b>&nbsp;Enclosure :</b>&nbsp;&nbsp;<?= implode(', ', json_decode($od['od']->enclosure));?></td></tr>
            <tr><td colspan="2"><b>&nbsp;Remark :</b>&nbsp;&nbsp;<?= $od['od']->note;?></td></tr>
            <tr><td colspan="2"><b>&nbsp;Standing INT :</b>&nbsp;&nbsp;<?= get_client_remark($od['od']->client_code);?></td></tr>
            <tr><td colspan="2"><b>&nbsp;Correction Temp :</b>&nbsp;&nbsp;<?= $curr_tmp;?></td></tr>
          </table>
    </div>
  </div>
</body>
</html>
