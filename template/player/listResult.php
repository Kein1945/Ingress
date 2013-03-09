<div id="players_activity">
	<?php
	if($players->num_rows){
		?><table class="table table-hover"><thead><tr><th>Name</th><th>AP</th><th>Level</th></tr></thead><tbody><?php
			while($r = $players->fetch_assoc()){
				echo "<tr>
						<td><a href='?action=player&id=$r[id]' >$r[name]</td>
						<td>$r[ap]</td>
						<td class='$r[fraction]'>$r[level]</td>
					</tr>";
			}
			?>
		</tbody></table>
		<?php
	} else {
		?>
		No players activity found
		<?php
	}
	?></div>