<?php
$app = F::app();
$dir = dirname(__FILE__) . '/';

/**
 * classes
 */
$app->registerClass('StructuredDataAPIClient', $dir . 'StructuredDataAPIClient.class.php');
$app->registerClass('StructuredData', $dir . 'StructuredData.class.php');
$app->registerClass('SDObject', $dir . 'SDObject.class.php');
$app->registerClass('SDElement', $dir . 'SDElement.class.php');
$app->registerClass('SDElementProperty', $dir . 'SDElementProperty.class.php');
$app->registerClass('SDElementRendererFactory', $dir . 'SDElementRendererFactory.class.php');
$app->registerClass('SDContext', $dir . 'SDContext.class.php');

require_once( $dir . '../../../lib/HTTP/Request.php');

/**
 * hooks
 */
$app->registerHook('ParserFirstCallInit', 'StructuredData', 'onParserFirstCallInit');

/**
 * controllers
 */
$app->registerClass('StructuredDataController', $dir . 'StructuredDataController.class.php');

/**
 * special pages
 */
$app->registerSpecialPage('StructuredData', 'StructuredDataController');

$wgStructuredDataConfig = array(
	//'baseUrl' => 'http://data.wikia.net/',
	'baseUrl' => 'http://data-stage.wikia.net/',
	'apiPath' => 'api/v0.1/',
	'schemaPath' => 'callofduty',
	'renderersPath' => $dir . 'templates/renderers/',
	'renderers' => array(
		'schema:ImageObject' => 'ImageObject',
		'xsd:anyURI' => 'anyURI',
		'@set' => 'container',
		'@list' => 'container'
	)
);

define('SD_CONTEXT_DEFAULT', 0);
define('SD_CONTEXT_SPECIAL', 1);

F::addClassConstructor( 'StructuredDataAPIClient', array( 'baseUrl' => $wgStructuredDataConfig['baseUrl'], 'apiPath' => $wgStructuredDataConfig['apiPath'], 'schemaPath' => $wgStructuredDataConfig['schemaPath'] ) );
F::addClassConstructor( 'StructuredData', array( 'apiClient' => F::build( 'StructuredDataAPIClient' )));
F::addClassConstructor( 'SDElementRendererFactory', array( 'config' => $wgStructuredDataConfig ) );

/**
 * message files
 */
//$app->registerExtensionMessageFile('StructuredData', $dir . 'StructuredData.i18n.php');
