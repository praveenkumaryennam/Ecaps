<!DOCTYPE html>
<html>
<head>
	<title><?= $this->config->item('page_title');?> | Zone Inforation</title>
</head>
<body>
	<table border="1">
  <thead>
    <tr>
      <th colspan="4">Station List of - <?= $zone;?></th>
    </tr>
    <tr>
      <th>Station</th>
      <th>City</th>
      <th>State</th>
      <th>Country</th>
    </tr>
  </thead>
	<tbody>
      <?php 
        if(!empty($rows)){
          foreach ($rows as $r) {
            echo '<tr>
              <td>'.$r->station.'</td>
              <td>'.$r->city.'</td>
              <td>'.$r->state.'</td>
              <td>'.$r->country.'</td>
            </tr>';
          }
        }
      ?>
    </tbody>
	</table>
</body>
</html>