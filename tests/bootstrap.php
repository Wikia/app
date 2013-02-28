<?php
$wgRunningUnitTests = true; // don't include DevBoxSettings when running unit tests
$wgDevelEnvironment = true;
require_once __DIR__ . '/../maintenance/commandLine.inc';

require_once 'Zend/Exception.php';
require_once 'Zend/Config.php';
require_once 'Zend/Config/Exception.php';
