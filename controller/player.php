<?php
function player_list(){
	global $db;
	$players = $db->query('SELECT p.id id,p.name `name`
							, MAX(IF(e.target_id < 9 AND e.action = \'deployed an\', e.target_id, 0)) `level`
							, LOWER(p.fraction) `fraction` , COUNT(*) `ap`
							FROM `events` e LEFT JOIN player p ON e.user_id = p.id
							GROUP BY e.user_id ORDER BY `level` DESC, `ap` DESC
					');
	template('player/list', array(
		'players' => $players
	));
}
function player_regionListAjax(){
	$HLat = getRequestFloat('HLat');
	$RLon = getRequestFloat('RLon');
	$LLat = getRequestFloat('LLat');
	$LLon = getRequestFloat('LLon');
	global $db;
	header('Content-Type: application/json');
	$sql = "SELECT p.id id,p.name `name`
				, MAX(IF(e.target_id < 9 AND e.action = 'deployed an', e.target_id, 0)) `level`
				, LOWER(p.fraction) `fraction` , COUNT(*) `ap`
				FROM `events` e
				LEFT JOIN player p ON e.user_id = p.id
				LEFT JOIN place pl ON pl.id = IF(e.target_id < 9, e.place_id, e.target_id)
				WHERE pl.lat BETWEEN $LLat AND $HLat AND pl.lon BETWEEN $LLon AND $RLon
					AND e.timestamp > (UNIX_TIMESTAMP()-24*60*60*14)
				GROUP BY e.user_id ORDER BY `level` DESC, `ap` DESC";
	// $db->query($sql);
	$players = $db->query($sql);
	template('player/listResult', array('players'=>$players));
}
