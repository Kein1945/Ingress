<?php
function place_regionAjax(){
	$HLat = getRequestFloat('HLat');
	$RLon = getRequestFloat('RLon');
	$LLat = getRequestFloat('LLat');
	$LLon = getRequestFloat('LLon');
	global $db;
	header('Content-Type: application/json');
	$sql = "SELECT pl.id
, GROUP_CONCAT(DISTINCT p.name) `player`
, GROUP_CONCAT(DISTINCT FROM_UNIXTIME(e.timestamp, '%d.%m')) `date`
, COUNT(*) `ap`
, pl.name `name`
, pl.lat/1000000 `lat`	, pl.lon/1000000 `lon`
, GROUP_CONCAT(DISTINCT p.fraction) `fraction`
FROM place pl
LEFT JOIN `events` e ON pl.id = IF(e.target_id < 9, e.place_id, e.target_id)
LEFT JOIN player p ON e.user_id = p.id
		WHERE pl.lat BETWEEN $LLat AND $HLat AND pl.lon BETWEEN $LLon AND $RLon
AND e.timestamp > (UNIX_TIMESTAMP()-24*60*60*14)
GROUP BY pl.id
ORDER BY e.timestamp DESC";
	$res = $db->query($sql);
	$data = array();
	while($r = $res->fetch_assoc()){ $data[] = $r; }
	echo json_encode($data);

}