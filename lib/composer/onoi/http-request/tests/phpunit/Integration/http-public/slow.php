<?php

usleep( mt_rand( 100000, 600000 ) );
print $_REQUEST['id'] . ' : ' . basename(__FILE__) . "\n";