<?php

$dir = dirname( __FILE__ ) . '/';

$wgAutoloadClasses[ 'PortabilityDashboardModel' ] = $dir . 'PortabilityDashboardModel.class.php';
$wgAutoloadClasses[ 'SpecialPortabilityDashboardController' ] = $dir . 'SpecialPortabilityDashboardController.php';

$wgSpecialPages[ 'PortabilityDashboard' ] = 'SpecialPortabilityDashboardController';
$wgSpecialPageGroups[ 'PortabilityDashboard' ] = 'wikia';
