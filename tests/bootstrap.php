<?php
$wgRunningUnitTests = true; // don't include DevBoxSettings when running unit tests
$wgDevelEnvironment = true;
require_once __DIR__ . '/../maintenance/commandLine.inc';

require_once 'Zend/Exception.php';
require_once 'Zend/Config.php';
require_once 'Zend/Config/Exception.php';
require_once 'Zend/Config/Xml.php';

$config = new Zend_Config_Xml(dirname(__FILE__) . '/config.xml', 'ci');
