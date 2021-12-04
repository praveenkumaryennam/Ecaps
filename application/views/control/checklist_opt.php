<table class="table">
	<?php
		$sel = json_decode($res, true);
		foreach ($opt as $o) {
			$chk = (in_array($o['menu'][1], $sel))?"checked":"";
			echo '<tr>';
			if($o['menu']) echo '<th><input type="checkbox" onclick="roleupdate('.$o['menu'][1].')" id="menu_'.$o['menu'][1].'" '.$chk.'/> '.$o['menu'][0].'</th>';
			if($o['child']){
				echo '<td><table>';
					foreach ($o['child'] as $c) {
						$chk = (in_array($c[1], $sel))?"checked":"";
						echo '<tr><td><input type="checkbox" onclick="roleupdate('.$c[1].')" id="child_'.$c[1].'" '.$chk.'/> '.$c[0].'</td></tr>';
					}
				echo '</table></td>';
			} 
			echo '</tr>';
		}
	?>
</table>