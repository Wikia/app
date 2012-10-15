<?php

    echo '<table id="punchcardTable">';
    for ($day = 1; $day <= 15; $day++){

        echo '<tr>';
        echo '<th class="days" id="day' . $day . '"></th>';
        for ($hour = 0; $hour <= 23; $hour++){
            echo '<td><span class="circle" id="day' . $day . 'hour' . $hour . '" style="background: ' . $color . ';">';
            echo '</span></td>';
        }
        echo '</tr>';
    }
    echo '<tr>';
    echo '<th style="border-bottom: none;"></th>';
    for ($hour = 0; $hour <= 23; $hour++){
        echo '<th id="hour' . $hour . '" style="border-bottom: none;">'. $hour . ':00</th>';
    }
    echo '</tr>';
    echo '</table>';

?>