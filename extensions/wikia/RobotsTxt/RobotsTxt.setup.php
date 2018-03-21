<?php

// Autoload
$wgAutoloadClasses['Wikia\RobotsTxt\Robot'] =  __DIR__ . '/classes/Robot.class.php';
$wgAutoloadClasses['Wikia\RobotsTxt\RobotsTxt'] =  __DIR__ . '/classes/RobotsTxt.class.php';
$wgAutoloadClasses['Wikia\RobotsTxt\PathBuilder'] =  __DIR__ . '/classes/PathBuilder.class.php';
$wgAutoloadClasses['Wikia\RobotsTxt\WikiaRobots'] =  __DIR__ . '/classes/WikiaRobots.class.php';

// for unit tests
$wgAutoloadClasses['RobotMock'] =  __DIR__ . '/tests/RobotMock.php';
$wgAutoloadClasses['RobotsTxtMock'] =  __DIR__ . '/tests/RobotsTxtMock.php';
