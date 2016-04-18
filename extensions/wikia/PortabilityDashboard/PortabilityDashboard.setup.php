<?php

$wgAutoloadClasses[ 'PortabilityDashboardModel' ] = __DIR__ . '/PortabilityDashboardModel.class.php';
$wgAutoloadClasses[ 'SpecialPortabilityDashboardController' ] = __DIR__ . '/SpecialPortabilityDashboardController.php';

$wgSpecialPages[ 'PortabilityDashboard' ] = 'SpecialPortabilityDashboardController';
$wgSpecialPageGroups[ 'PortabilityDashboard' ] = 'wikia';

$wgExtensionMessagesFiles[ 'PortabilityDashboard' ] = __DIR__ . '/PortabilityDashboard.i18n.php';
