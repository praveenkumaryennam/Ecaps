<table class="table table-bordered datatable_btn" border="1">
  <thead>
    <tr>
      <th>#</th>
      <th>CAT</th>
      <th>Status</th>
      <th>Order Date</th>
      <th>Due Date</th>
      <th>Order Type</th>
      <th>Order no</th>
      <th>case no</th>
      <th>Patient</th>
      <th>Priority</th>
      <th>Jaw Type</th>
      <th>Correction Template</th>
      <th>Product</th>
      <th>Product Type</th>
      <th>Product Category</th>
      <th>Unit Price</th>
      <th>Discount</th>
      <th>Units</th>
      <th>Amount</th>
      <th>Client Name</th>
      <th>Client Code</th>
      <th>Parent Client</th>
      <th>Country</th>
      <th>State</th>
      <th>City</th>
      <th>Station</th>
      <th>Zone</th>
      <th>Source</th>
      <th>Refer By</th>
      <th>DOJ</th>
      <th>Month</th>
    </tr>
  </thead>
  <tbody>
    <?php
      if(!empty($rows)){
        $i = 1;
        foreach ($rows as $r) {
          echo '<tr>
            <td>'.$i++.'</td>
            <td>'.$r->customercateory.'</td>
            <td>'.ucfirst($r->legencycode).'</td>
            <td>'.date('d-m-Y', strtotime($r->order_date)).'</td>
            <td>'.date('d-m-Y', strtotime($r->due_date)).'</td>
            <td>'.ucfirst($r->work_type).'</td>
            <td>'.$r->order_number.'</td>
            <td>'.$r->modal_no.'</td>
            <td>'.$r->patiant_name.'</td>
            <td>'.get_title_priority($r->order_priority).'</td>
            <td>'.$r->delivery_method.'</td>
            <td>'.$r->correction_tamp.'</td>
            <td>'.$r->product_id.'</td>
            <td>'.$r->product_type.'</td>
            <td>'.$r->product_cat.'</td>
            <td>'.$r->unit_price.'</td>
            <td>'.$r->discount.'</td>
            <td>'.$r->unit.'</td>
            <td>'.number_format($r->total_amount, 2).'</td>
            <td>'.$r->clientname.'</td>
            <td>'.$r->code.'</td>
            <td>'.$r->parent_client.'</td>
            <td>'.$r->country.'</td>
            <td>'.$r->state.'</td>
            <td>'.$r->city.'</td>
            <td>'.$r->station.'</td>
            <td>'.$r->zone.'</td>
            <td>'.$r->source.'</td>
            <td>'.$r->refer_by.'</td>
            <td>'.date('d-m-Y', strtotime($r->dob)).'</td>
            <td>'.date('F', strtotime($r->dob)).'</td>
          </tr>';
        }
      }
    ?>
  </tbody>
</table>