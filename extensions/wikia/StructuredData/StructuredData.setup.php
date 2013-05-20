<?php
/**
 * Structured Data
 *
 * extension for manipulating with SDS objects
 *
 * @author Adrian 'ADi' Wieczorek <adi@wikia-inc.com>
 * @author Jacek Jursza <jacek@wikia-inc.com>
 * @author Jacek 'mech' Woźniak <mech@wikia-inc.com>
 * @author Rafał Leszczyński <rafal@wikia-inc.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 *
 */

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Structured Data',
	'author' => array( 'Adrian \'ADi\' Wieczorek', 'Jacek Jursza', 'Jacek \'mech\' Woźniak', 'Rafał Leszczyński' ),
	'url' => 'http://callofduty.wikia.com/wiki/Special:StructuredData',
	'descriptionmsg' => 'structureddata-desc',
);

$app = F::app();
$dir = dirname(__FILE__) . '/';

/**
 * classes
 */
$app->registerClass('StructuredDataAPIClient', $dir . 'StructuredDataAPIClient.class.php');
$app->registerClass('StructuredData', $dir . 'StructuredData.class.php');
$app->registerClass('SDRenderableObject', $dir . 'SDRenderableObject.class.php');
$app->registerClass('SDElement', $dir . 'SDElement.class.php');
$app->registerClass('SDElementProperty', $dir . 'SDElementProperty.class.php');
$app->registerClass('SDElementPropertyValue', $dir . 'SDElementPropertyValue.class.php');
$app->registerClass('SDElementPropertyType', $dir . 'SDElementPropertyType.class.php');
$app->registerClass('SDElementPropertyTypeRange', $dir . 'SDElementPropertyTypeRange.class.php');
$app->registerClass('SDElementRendererFactory', $dir . 'SDElementRendererFactory.class.php');
$app->registerClass('SDContext', $dir . 'SDContext.class.php');
$app->registerClass('SDParser', $dir . 'parser/SDParser.class.php');
$app->registerClass('SDParserTag', $dir . 'parser/SDParserTag.class.php');
$app->registerClass('SDParserTagProperty', $dir . 'parser/SDParserTagProperty.class.php');
$app->registerClass('SDParserTagPropertyPath', $dir . 'parser/SDParserTagPropertyPath.class.php');

$app->registerClass('SDTypeHandler', $dir . 'typehandlers/SDTypeHandler.class.php');
$app->registerClass('SDTypeImageObject', $dir . 'typehandlers/SDTypeImageObject.php');
$app->registerClass('SDTypeWikiText', $dir . 'typehandlers/SDTypeWikiText.php');
$app->registerClass('SDTypeHandlerAnyType', $dir . 'typehandlers/SDTypeHandlerAnyType.php');


require_once( $IP . '/lib/vendor/HTTP/Request.php');

/**
 * hooks
 */
//$app->registerHook('ParserBeforeInternalParse', 'SDParser', 'onBeforeInternalParse');
$app->registerHook('ParserFirstCallInit', 'SDParser', 'onParserFirstCallInit');
$app->registerHook('ParserFirstCallInit', 'SDParser', 'onParserFirstCallInitParserFunctionHook');

/**
 * controllers
 */
$app->registerClass('StructuredDataController', $dir . 'StructuredDataController.class.php');

/**
 * special pages
 */
$app->registerSpecialPage('StructuredData', 'StructuredDataController');

$wgStructuredDataConfig = array(
	'debug' => false, //!empty( $wgDevelEnvironment ),
	'baseUrl' => ( !empty( $wgDevelEnvironment ) ) ? 'http://data-stage.wikia.net/' : $wgStructuredDataServer,
	'apiPath' => 'api/v0.1/',
	'schemaPath' => 'callofduty',
	'renderersPath' => $dir . 'templates/renderers/',
	'renderers' => array(
		'sdelement_schema:ImageObject' => 'sdelement_ImageObject',
		'value_xsd:anyURI' => 'value_anyURI',
		'wikia:wikiText' => 'wikiText',
		'value_xsd:boolean' => 'value_boolean',
		'@set' => 'container',
		'@list' => 'container',
		'value_default' => 'value_default',
		'sdelement_default' => 'sdelement_default',
		'value_enum' => 'value_enum'
	),
	'typeHandlers' => array(
		'wikia:WikiText' => 'SDTypeWikiText',
		'schema:ImageObject' => 'SDTypeImageObject'
	),
	'ImageObjectThumbnailMaxWidth' => 600,
);


/**
 * access rights
 */
$wgAvailableRights[] = 'sdsediting';
$wgGroupPermissions['*']['sdsediting'] = false;
$wgGroupPermissions['staff']['sdsediting'] = true;
$wgGroupPermissions['sysop']['sdsediting'] = true;
$wgAvailableRights[] = 'sdsdeleting';
$wgGroupPermissions['*']['sdsdeleting'] = false;
$wgGroupPermissions['staff']['sdsdeleting'] = true;
$wgGroupPermissions['sysop']['sdsdeleting'] = true;

define('SD_CONTEXT_DEFAULT', 0);
define('SD_CONTEXT_SPECIAL', 1);
define('SD_CONTEXT_EDITING', 2);

/**
 * DI setup
 */
F::addClassConstructor( 'StructuredDataAPIClient', array( 'baseUrl' => $wgStructuredDataConfig['baseUrl'], 'apiPath' => $wgStructuredDataConfig['apiPath'], 'schemaPath' => $wgStructuredDataConfig['schemaPath'] ) );
F::addClassConstructor( 'StructuredData', array( 'apiClient' => F::build( 'StructuredDataAPIClient' )));
F::addClassConstructor( 'SDElementRendererFactory', array( 'config' => $wgStructuredDataConfig ) );
F::addClassConstructor( 'SDParser', array( 'structuredData' => F::build( 'StructuredData' ) ) );

/**
 * message files
 */
$app->registerExtensionMessageFile('StructuredData', $dir . 'StructuredData.i18n.php' );

F::build('JSMessages')->registerPackage('StructuredData', array('structureddata-*'));
F::build('JSMessages')->enqueuePackage('StructuredData', JSMessages::EXTERNAL);
