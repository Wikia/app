<?php
require_once dirname(__FILE__) . '/../maintenance/commandLine.inc';
ini_set( 'include_path', get_include_path() . PATH_SEPARATOR . /*$_SERVER['PHP_PEAR_INSTALL_DIR']*/ 'C:\php\pear' );
require_once 'Zend/Exception.php';
require_once 'Zend/Config.php';
require_once 'Zend/Config/Exception.php';
require_once 'Zend/Config/Xml.php';

$config = new Zend_Config_Xml(dirname(__FILE__) . '/config.xml', 'ci');
