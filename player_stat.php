<?php

$action = isset($_GET['action'])?$_GET['action']:'';
include 'mysql.php';

switch ($action){
    case 'points':
        $id = (isset($_GET['id']) && is_numeric($_GET['id']))?(int)$_GET['id']:0;
        $res = $db->query("SELECT GROUP_CONCAT(DISTINCT FROM_UNIXTIME(e.timestamp, '%H')) `time`
,  GROUP_CONCAT(DISTINCT FROM_UNIXTIME(e.timestamp, '%d.%m')) `date`
	, COUNT(*) `ap`
	, pl.name `name`
	, pl.lat/1000000 `lat`	, pl.lon/1000000 `lon`
FROM `events` e
LEFT JOIN place pl ON pl.id = e.place_id
WHERE e.user_id = $id
GROUP BY place_id
ORDER BY `timestamp` DESC");
        header('Content-Type: application/json');
        $data = array();
        while($r = $res->fetch_assoc()){
            $data[] = $r;
        }
        echo json_encode($data);
        break;
    default:
}

