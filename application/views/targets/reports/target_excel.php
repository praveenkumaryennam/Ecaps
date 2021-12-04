<table class="table table-bordered table-striped datatable_btn" id="datatable_btn" border="1">
  <thead>
    <tr><th>#</th><th>Name</th><th>Code</th><th>Month</th><th>Department</th><th>Type</th><th>Archived Cases</th><th>New Archived Cases</th><th>Redo Archived Cases</th><th>Correction Archived Cases</th><th>Target</th><th>Incentive</th><th style="background-color: #99EE99;">Incentive Total</th></tr>
  </thead>
  <tbody>
    <?php 
      if(!empty($rows)){
        $i = 1;
        foreach ($rows as $r) {
          $m = $mon;
          if($r['month'])
            $m = $r['month'];


        foreach ($r['data'] as $a => $f){
          echo '<tr>
            <td>'.$i++.'</td>
            <td>'.$r['name'].'</td>
            <td>'.$r['code'].'</td>
            <td>'.date('F', strtotime('2020-'.$m.'-01')).'</td>';
              if($f['target'] == 'case'){
                $total = ($f['target']->incentive * $f['case_id']);
              }else{
                $total = ($f['target']->incentive * $f['units']);
              }

              echo '<td>'.lab_depaerment_title($a).'</td>
              <td>'.strtoupper($f['target']->is_type).'</td>
              <td>'.$f['case_id'].'</td>
              <td>'.$f['new']['units'].'</td>
              <td>'.$f['redo']['units'].'</td>
              <td>'.$f['correction']['units'].'</td>
              <td>'.$f['target']->target.'</td>
              <td>'.$f['target']->incentive.'</td>
              <td>'.$total.'</td>';
            echo '</tr>';
          }
        }
      }
    ?>
  </tbody>
</table>