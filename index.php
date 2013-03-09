<?php
include 'init.php';

call_user_func($http_call);
exit();
switch ($action) {
    case 'players':
            $res = $db->query('SELECT p.id id,p.name `name`
, MAX(IF(e.target_id < 9 AND e.action = \'deployed an\', e.target_id, 0)) `level`
, LOWER(p.fraction) `fraction` , COUNT(*) `ap`
FROM `events` e LEFT JOIN player p ON e.user_id = p.id
GROUP BY e.user_id ORDER BY `level` DESC, `ap` DESC
');
            echo '<table class="table table-hover"><thead><tr><th>Name</th><th>AP</th><th>Level</th></tr></thead><tbody>';
            while($r = $res->fetch_assoc()){
                echo "<tr>
                    <td><a href='?action=player&id=$r[id]' >$r[name]</td>
                    <td>$r[ap]</td>
                    <td class='$r[fraction]'>$r[level]</td>
                </tr>";
            }
            echo '</tbody></table>';
        break;
    case 'player':
        $id = (isset($_GET['id']) && is_numeric($_GET['id']))?(int)$_GET['id']:0;
        $res = $db->query("SELECT
	e.timestamp `time`
	, pl.name `point`
	, pl.lat /1000000 `lat`, pl.lon/1000000 `lon`
	, e.target_id 'resonator'
	, pt.name `target_point`
	, action
FROM `events` e
LEFT JOIN player p ON p.id = e.user_id
LEFT JOIN place pl ON pl.id = e.place_id
LEFT JOIN place pt ON pt.id = e.target_id AND e.target_id > 9
WHERE p.id = $id
ORDER BY `timestamp` DESC LIMIT 250");
        if($res->num_rows){
            $player = $db->query("SELECT name FROM player WHERE id = $id")->fetch_assoc();
            echo "<h3>$player[name]</h3>";
            ?>

        <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&key=AIzaSyAIsb__PLA3ysZhNYAxtRTWUiPpe4oXXg0"></script>
        <script src="/js/player.js"></script>
        <div id="map_canvas" class="container"></div>
            <?php
            echo '<input type="hidden" id="player" value="'.$id.'"/> <table class="table table-hover"><thead><tr><th>Time</th></th><th>Point</th><th>Action</th><th>Target</th></tr></thead><tbody>';
            while($r = $res->fetch_assoc()){
                echo "<tr>
                    <td>".date('d-M H:i:s', $r['time'])."</td>
                    <td>$r[point] ($r[lat], $r[lon]] </td>
                    <td>$r[action]</td>
                    <td>".(($r['resonator']>9)?$r['target_point']:$r['resonator'])."</td>
                </tr>";
            }
            echo '</tbody></table>';
            break;
        }
    default :
?>

    <!-- Jumbotron -->
    <div class="jumbotron">
        <h1>Marketing stuff!</h1>
        <p class="lead">Cras justo odio, dapibus ac facilisis in, egestas eget quam. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
        <a class="btn btn-large btn-success" href="#">Get started today</a>
    </div>

    <hr>

    <!-- Example row of columns -->
    <div class="row-fluid">
        <div class="span4">
            <h2>Heading</h2>
            <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
            <p><a class="btn" href="#">View details &raquo;</a></p>
        </div>
        <div class="span4">
            <h2>Heading</h2>
            <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
            <p><a class="btn" href="#">View details &raquo;</a></p>
        </div>
        <div class="span4">
            <h2>Heading</h2>
            <p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa.</p>
            <p><a class="btn" href="#">View details &raquo;</a></p>
        </div>
    </div>

    <hr>

<?php
}
include 'template/footer.php';
