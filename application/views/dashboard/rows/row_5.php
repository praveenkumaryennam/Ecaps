<?php
  $a = challans();
  $b = challans(true);
  $total = ($a+$b);

  if($a > 0 || $b > 0){
    $d = ($a/$total);
    $p = (100-($b/$total));
  }else{
    $d = $p = 0;
  }
?>

<div class="row">
  <div class="col-md-4 col-sm-6 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon bg-green">
        <i class="fa fa-plane"></i>
      </span>
      <div class="info-box-content">
        <span class="info-box-text">Today Dispatch (%)</span>
        <span class="info-box-number"><?= number_format($d, 2) .' / 100';?></span>
      </div>
    </div>
  </div>

  <div class="col-md-4 col-sm-6 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon bg-red">
        <i class="fa fa-question-circle "></i>
      </span>
      <div class="info-box-content">
        <span class="info-box-text">Total Pending Dispatch (%)</span>
        <span class="info-box-number"><?= number_format($p, 2) .' / 100';?></span>
      </div>
    </div>
  </div>
</div>