<?php

    echo '<table id="punchcardTable">';
    for ($day = 1; $day<=15; $day++){
        $dayFormated = str_pad($day, 2, "0", STR_PAD_LEFT);

        echo '<tr>';
        echo'<th id="day' . $dayFormated . '">' . $dayFormated . '</th>';
        for ($hour = 0; $hour<=23; $hour++){
            //$dayFormated = ($day, 2, "0", STR_PAD_LEFT);
            echo '<td><span class="circle" id=day' . str_pad($day, 2, "0", STR_PAD_LEFT) . 'hour' . str_pad($hour, 2, "0", STR_PAD_LEFT) . '>';
          //  str_pad($input, 10)
            echo '</span></td>';

        }
        echo '</tr>';
    }
    echo '<tr>';
    echo '<th></th>';
    for ($hour = 0; $hour<=23; $hour++){
        echo '<th>'. $hour . ':00</th>';
    }
    echo '</tr>';
    echo '</table>';

?>