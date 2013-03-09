<?php
if($players->num_rows){
	$player = $db->query("SELECT name FROM player WHERE id = $id")->fetch_assoc();
	echo "<h3>$player[name]</h3>";
	?>

<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&key=AIzaSyAIsb__PLA3ysZhNYAxtRTWUiPpe4oXXg0"></script>
<script src="/js/player.js"></script>
<div id="map_canvas" class="container"></div>
<?php
	echo '<input type="hidden" id="player" value="'.$id.'"/>'; ?>
<table class="table table-hover">
	<thead><tr><th>Time</th></th><th>Point</th>
		<th>Action</th><th>Target</th></tr
			></thead>
	<tbody>
		<?php
		while($r = $players->fetch_assoc()){
			echo "<tr>
					<td>".date('d-M H:i:s', $r['time'])."</td>
					<td>$r[point] ($r[lat], $r[lon]] </td>
					<td>$r[action]</td>
					<td>".(($r['resonator']>9)?$r['target_point']:$r['resonator'])."</td>
				</tr>";
		}

		?></tbody></table>
<?php
} else {
	?>
No players activity found
<?php
}