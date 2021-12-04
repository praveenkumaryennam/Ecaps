<table class="table table-bordered table-striped datatable_btn" id="datatable_btn" border="1">
  <thead>
    <tr>
      <th colspan="3"></th>
      <?php 
        for ($i=1; $i <= 12; $i++) { 
          echo '<th style="text-align: center">'.$month_arr[$i-1].'</th>';
          // echo '<th colspan=3 style="text-align: center">'.$month_arr[$i-1].'</th>';
        }
      ?>
      <th style="text-align: center">Total</th>
    </tr>
    <tr>
      <th>#</th>
      <th>Name</th>
      <th>Code</th>
      <?php 
        for ($i=1; $i <= 13; $i++) { 
          echo '<th>Archive</th>';
          // echo '<th>Target</th><th>Incentive Per Unit</th><th>Archive</th>';
        }
      ?>
    </tr>
  </thead>
  <tbody>
    <?php 
     if(!empty($rows)){
        $j = 1;

        foreach ($rows as $r) {
          $total = 0;
          echo '<tr>
            <td>'.$j++.'</td>
            <td>'.$r['name'].'</td>
            <td>'.$r['code'].'</td>';
            
            for ($k=1; $k <= 12; $k++) {
              echo '<td>'.$r['data'][$k].'</td>';
              $total += $r['data'][$k];
            }
            echo '<td>'.$total.'</td>';
          echo '</tr>';
        }
      }
    ?>
  </tbody>
</table>