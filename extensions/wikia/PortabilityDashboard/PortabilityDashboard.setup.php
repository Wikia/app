<?php

$dir = dirname( __FILE__ ) . '/';

$wgAutoloadClasses[ 'PortabilityDashboardModel' ] = $dir . 'PortabilityDashboardModel.class.php';
$wgAutoloadClasses[ 'PortabilityDashboardHooks' ] = $dir . 'PortabilityDashboardHooks.class.php';
$wgAutoloadClasses[ 'SpecialPortabilityDashboardController' ] = $dir . 'SpecialPortabilityDashboardController.php';

$wgSpecialPages[ 'PortabilityDashboard' ] = 'SpecialPortabilityDashboardController';
$wgSpecialPageGroups[ 'PortabilityDashboard' ] = 'wikia';

$wgHooks[ 'UnconvertedInfoboxesQueryRecached' ][] = 'PortabilityDashboardHooks::updateUnconvertedInfoboxes';
$wgHooks[ 'TemplatesWithoutTypeQueryRecached' ][] = 'PortabilityDashboardHooks::updateNotClassifiedTemplates';
