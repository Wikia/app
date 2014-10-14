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
$wgAutoloadClasses['StructuredDataAPIClient'] =  $dir . 'StructuredDataAPIClient.class.php';
$wgAutoloadClasses['StructuredData'] =  $dir . 'StructuredData.class.php';
$wgAutoloadClasses['SDRenderableObject'] =  $dir . 'SDRenderableObject.class.php';
$wgAutoloadClasses['SDElement'] =  $dir . 'SDElement.class.php';
$wgAutoloadClasses['SDElementProperty'] =  $dir . 'SDElementProperty.class.php';
$wgAutoloadClasses['SDElementPropertyValue'] =  $dir . 'SDElementPropertyValue.class.php';
$wgAutoloadClasses['SDElementPropertyType'] =  $dir . 'SDElementPropertyType.class.php';
$wgAutoloadClasses['SDElementPropertyTypeRange'] =  $dir . 'SDElementPropertyTypeRange.class.php';
$wgAutoloadClasses['SDElementRendererFactory'] =  $dir . 'SDElementRendererFactory.class.php';
$wgAutoloadClasses['SDContext'] =  $dir . 'SDContext.class.php';
$wgAutoloadClasses['SDParser'] =  $dir . 'parser/SDParser.class.php';
$wgAutoloadClasses['SDParserTag'] =  $dir . 'parser/SDParserTag.class.php';
$wgAutoloadClasses['SDParserTagProperty'] =  $dir . 'parser/SDParserTagProperty.class.php';
$wgAutoloadClasses['SDParserTagPropertyPath'] =  $dir . 'parser/SDParserTagPropertyPath.class.php';

$wgAutoloadClasses['SDTypeHandler'] =  $dir . 'typehandlers/SDTypeHandler.class.php';
$wgAutoloadClasses['SDTypeImageObject'] =  $dir . 'typehandlers/SDTypeImageObject.php';
$wgAutoloadClasses['SDTypeWikiText'] =  $dir . 'typehandlers/SDTypeWikiText.php';
$wgAutoloadClasses['SDTypeHandlerAnyType'] =  $dir . 'typehandlers/SDTypeHandlerAnyType.php';


require_once( $IP . '/lib/vendor/HTTP/Request.php');

/**
 * hooks
 */
//$wgHooks['ParserBeforeInternalParse'][] = 'SDParser::onBeforeInternalParse';
$wgHooks['ParserFirstCallInit'][] = 'SDParser::onParserFirstCallInit';
$wgHooks['ParserFirstCallInit'][] = 'SDParser::onParserFirstCallInitParserFunctionHook';

/**
 * controllers
 */
$wgAutoloadClasses['StructuredDataController'] =  $dir . 'StructuredDataController.class.php';

/**
 * special pages
 */
$wgSpecialPages['StructuredData'] = 'StructuredDataController';

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
 * message files
 */
$wgExtensionMessagesFiles['StructuredData'] = $dir . 'StructuredData.i18n.php' ;

JSMessages::registerPackage('StructuredData', array('structureddata-*'));
JSMessages::enqueuePackage('StructuredData', JSMessages::EXTERNAL);
