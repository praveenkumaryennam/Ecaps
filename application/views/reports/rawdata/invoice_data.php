<table class="table table-bordered datatable_btn" border="1">
  <thead>
    <tr>
      <th>#</th>
      <th>Invoice Date</th>
      <th>Invoice No</th>
      <th>Units</th>
      <th>Amount</th>
      <th>Client Name</th>
      <th>Client Code</th>
      <th>Country</th>
      <th>State</th>
      <th>City</th>
      <th>Station</th>
      <th>Zone</th>
    </tr>
  </thead>
  <tbody>
    <?php
      if(!empty($rows)){
        $i = 1;
        foreach ($rows as $r) {
          echo '<tr>
            <td>'.$i++.'</td>
            <td>'.$r->invoice_date.'</td>
            <td>'.$r->invoice_number.'</td>
            <td>'.$r->units.'</td>
            <td>'.number_format($r->invoice_total, 2).'</td>
            <td>'.$r->clientname.'</td>
            <td>'.$r->code.'</td>
            <td>'.$r->country.'</td>
            <td>'.$r->state.'</td>
            <td>'.$r->city.'</td>
            <td>'.$r->station.'</td>
            <td>'.$r->zone.'</td>
          </tr>';
        }
      }
    ?>
  </tbody>
</table>