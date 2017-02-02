<?php

usleep( mt_rand( 10000, 200000 ) );
print $_REQUEST['id'] . ' : ' . basename(__FILE__ ) . "\n";