<?php

// Autoload
$wgAutoloadClasses['Wikia\RobotsTxt\RobotsTxt'] =  __DIR__ . '/classes/RobotsTxt.class.php';
$wgAutoloadClasses['Wikia\RobotsTxt\PathBuilder'] =  __DIR__ . '/classes/PathBuilder.class.php';
$wgAutoloadClasses['Wikia\RobotsTxt\WikiaRobots'] =  __DIR__ . '/classes/WikiaRobots.class.php';

// for unit tests
$wgAutoloadClasses['RobotsTxtMock'] =  __DIR__ . '/tests/RobotsTxtMock.php';
