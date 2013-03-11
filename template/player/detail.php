<?php
global $db;
template('head');
template('map');
 if($events->num_rows){
            $player = $db->query("SELECT name FROM player WHERE id = $id")->fetch_assoc();
            echo "<h3>$player[name]</h3>";
            ?>

        <script src="/js/player.js"></script>
            <?php
            echo '<input type="hidden" id="player" value="'.$id.'"/> <table class="table table-hover"><thead><tr><th>Time</th></th><th>Point</th><th>Action</th><th>Target</th></tr></thead><tbody>';
            while($r = $events->fetch_assoc()){
                echo "<tr>
                    <td>".date('d-M H:i:s', $r['time'])."</td>
                    <td>$r[point] ($r[lat], $r[lon]] </td>
                    <td>$r[action]</td>
                    <td>".(($r['resonator']>9)?$r['target_point']:$r['resonator'])."</td>
                </tr>";
            }
            echo '</tbody></table>';
        }

