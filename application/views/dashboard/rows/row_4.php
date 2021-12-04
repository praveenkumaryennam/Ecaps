<div class="row">
	<div class="col-md-4 col-sm-6 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon bg-green">
        <i class="fa fa-plane"></i>
      </span>
      <div class="info-box-content">
        <span class="info-box-text">Today Dispatch</span>
        <span class="info-box-number"><?= number_format(challans());?></span>
      </div>
    </div>
  </div>

  <div class="col-md-4 col-sm-6 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon bg-red">
        <i class="fa fa-question-circle "></i>
      </span>
      <div class="info-box-content">
        <span class="info-box-text">Total Pending Dispatch</span>
        <span class="info-box-number"><?= number_format(challans(true));?></span>
      </div>
    </div>
  </div>

  <div class="col-md-4 col-sm-6 col-xs-12">
    <div class="info-box">
      <span class="info-box-icon bg-success">
        <i class="fa fa-inr"></i>
      </span>
      <div class="info-box-content">
        <span class="info-box-text">Total Dispatch Sales Amount</span>
        <span class="info-box-number"><?= number_format(challans_amt(), 2);?></span>
      </div>
    </div>
  </div>
</div>