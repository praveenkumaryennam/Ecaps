<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?= $this->config->item('page_title');?> | Warranty Card</title>
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  
  <link rel="stylesheet" href="<?= base_url('assets/');?>dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="<?= base_url('assets/');?>dist/css/font-awesome.min.css">
  <link rel="stylesheet" href="<?= base_url('assets/');?>dist/css/ionicons.min.css">
  <link rel="stylesheet" href="<?= base_url('assets/');?>dist/css/AdminLTE.min.css">
  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <style>
    .n-bordered{
      border: none;
    }
    .bordered td, .n-bordered td{
      border: 1px solid black;
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
    td, th{
      padding: 5px;
    }
    @page {
      size: 8.5in 11in; /* <length>{1,2} | auto | portrait | landscape */
            /* 'em' 'ex' and % are not allowed; length values are width height */
      margin: 2%; /* <any of the usual CSS values for margins> */
                   /*(% of page-box width for LR, of height for TB) */
    }
    body{
      background: url('<?= base_url('assets/dist/img/rpdlogo.png');?>') no-repeat center;
    }
  </style>

</head>
  <body>
    <div class="wrapper">
      <section class="invoice" style="border: 1px solid #000; padding: 10px;">
        <div class="row">
          <div class="col-md-12" style="text-align: center; font-size: 10px;">
            <b style="font-weight: bold; font-size: 14px;">WARRANTY CARD</b>
          </div>
        </div>

        <div class="row">
          <div class="col-xs-12">
            <!-- <h3><?= get_product_title($card_data->product_type, 'producttype');?></h3> -->
            
            <table width="100%" border="1" style="margin-bottom: 10px;">
              <tr><th colspan="4">Case Details</th></tr>

              <tr>
                <th width="30%;">Warranty Code</th>
                <td><?= $card_data->warrenty_code;?></td>
                <th width="30%;">Verification Number</th>
                <td><?= $card_data->verification_code;?></td>
              </tr>
            </table>

            <table width="100%" border="1" style="margin-bottom: 10px;">
              <tr>
                <th width="30%;">Date</th>
                <td colspan="3"><?= date('d-m-Y',strtotime($card_data->date))?></td>
              </tr>
            </table>

            <table width="100%" border="1" style="margin-bottom: 10px;">
              <tr>
                <th width="30%;">Type Of Product</th>
                <td><?= get_product_title($card_data->product_type, 'producttype');?></td>
                <th width="30%;">Frame Bar Code</th>
                <td><?= $card_data->frame_bar_code?></td>
              </tr>
            </table>

            <table width="100%" border="1" style="margin-bottom: 10px;">
              <tr>
                <th width="30%;">Product Name</th>
                <td><?= get_product_title($card_data->product, 'product');?></td>
              </tr>

              <tr>
                <th>Number of Units</th>
                <td><?= $card_data->units?></td>
              </tr>

              <tr>
                <th>Scan/Ceram Lab Name</th>
                <td><?= $this->config->item('lab_name');?></td>
              </tr>

              <tr>
                <th>Lab Case Number</th>
                <td><?= $card_data->case_number;?></td>
              </tr>

              <tr>
                <th>Point of Supply</th>
                <td><?= $this->config->item('point_of_supply');?></td>
              </tr>

              <tr>
                <th>Case Description</th>
                <td><?= $card_data->case_desc;?></td>
              </tr>

              <tr>
                <th>Shade Description</th>
                <td>
                  <?php 
                    if(!empty($card_data->shade_1))
                      echo $card_data->shade_1.' | ';
                    if(!empty($card_data->shade_2))
                      echo $card_data->shade_2.' | ';
                    if(!empty($card_data->shade_3))
                      echo $card_data->shade_3;
                  ?>  
                </td>
              </tr>
            </table>

            <table width="100%" border="1" style="margin-bottom: 10px;">
              <tr>
                <th colspan="2">Dentist Info</th>
              </tr>
              <tr>
                <th width="30%;">Name</th>
                <td><?= $card_data->clientname;?></td>
              </tr>
            </table>
            <table width="100%" border="1">
              <tr>
                <th>Email-Id</th>
                <th>Mobile-no</th>
              </tr>
              <tr>
                <td><?= $card_data->cemail;?></td>
                <td><?= $card_data->cmobile;?></td>
              </tr>
              <tr>
                <td colspan="2"><b>Location :</b> <?= $card_data->clocation;?></td>
              </tr>
            </table>

            <table width="100%" border="1">
              <tr>
                <th colspan="2">Patient Info</th>
              </tr>
              <tr>
                <th width="30%;">Name</th>
                <td><?= $card_data->patiantname;?></td>
              </tr>
            </table>
            <table width="100%" border="1">
              <tr>
                <th>Email-Id</th>
                <th>Mobile-no</th>
              </tr>
              <tr>
                <td>
                  <?php 
                    if(!empty($card_data->pemail))
                      echo $card_data->pemail;
                    else echo '-';
                  ?>  
                </td>
                <td>
                  <?php 
                    if(!empty($card_data->pmobile))
                      echo $card_data->pmobile;
                    else echo '-';
                  ?>
                </td>
              </tr>
              <tr>
                <td colspan="2"><b>Location :</b> <?= $card_data->plocation;?></td>
              </tr>
            </table>
          </div>
        </div>
    </section>
  </div>
</body>
</html>
