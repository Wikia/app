<?php

$wgAutoloadClasses[ 'PortabilityDashboardModel' ] = __DIR__ . '/PortabilityDashboardModel.class.php';
$wgAutoloadClasses[ 'PortabilityDashboardHooks' ] = __DIR__ . '/PortabilityDashboardHooks.class.php';

$wgHooks[ 'UnconvertedInfoboxesQueryRecached' ][] = 'PortabilityDashboardHooks::updateUnconvertedInfoboxes';
$wgHooks[ 'TemplatesWithoutTypeQueryRecached' ][] = 'PortabilityDashboardHooks::updateNotClassifiedTemplates';
