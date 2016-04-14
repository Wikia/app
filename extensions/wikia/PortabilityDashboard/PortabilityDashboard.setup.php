<?php

$dir = dirname( __FILE__ ) . '/';

$wgAutoloadClasses[ 'SpecialPortabilityDashboardController' ] = $dir . 'SpecialPortabilityDashboardController.php';

$wgSpecialPages[ 'PortabilityDashboard' ] = 'SpecialPortabilityDashboardController';
$wgSpecialPageGroups[ 'PortabilityDashboard' ] = 'wikia';
