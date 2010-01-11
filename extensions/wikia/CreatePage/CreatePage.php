<?php
/**
 * A special page to create a new article, using wysiwig editor
 *
 */

if(!defined('MEDIAWIKI')) {
	die();
}

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Create Page',
	'author' => 'Bartek Lapinski, Adrian Wieczorek',
	'url' => 'http://www.wikia.com' ,
	'description' => 'Allows to create a new page using wikia\'s Wysiwyg editor'
);

/**
 * messages file
 */
$wgExtensionMessagesFiles['CreatePage'] = dirname(__FILE__) . '/CreatePage.i18n.php';

/**
 * Special pages
 */
extAddSpecialPage(dirname(__FILE__) . '/SpecialCreatePage.php', 'CreatePage', 'CreatePage');

/**
 * setup functions
 */
$wgExtensionFunctions[] = 'wfCreatePageInit';

// initialize (new) create page extension
function wfCreatePageInit() {
	global $wgWikiaEnableNewCreatepageExt, $wgAjaxExportList, $wgOut, $wgScriptPath, $wgStyleVersion, $wgExtensionsPath;

	// load messages from file
	wfLoadExtensionMessages('CreatePage');

	if ( !empty($wgWikiaEnableNewCreatepageExt) ) {
		/**
		 * hooks
		 */
		$wgAjaxExportList[] = 'wfCreatePageAjaxGetDialog';

		$wgOut->addScript( '<script type="text/javascript" src="' . $wgScriptPath . '/extensions/wikia/CreatePage/js/CreatePage.js"><!-- CreatePage js --></script>');
		$wgOut->addExtensionStyle("{$wgExtensionsPath}/wikia/CreatePage/css/CreatePage.css?{$wgStyleVersion}");

	}
}

function wfCreatePageAjaxGetDialog() {
	$template = new EasyTemplate( dirname( __FILE__ )."/templates/" );
	//$template->set_vars( array() );

	$body = $template->execute( 'dialog' );
	$response = new AjaxResponse( $body );
	$response->setContentType('text/plain; charset=utf-8');

	return $response;
}


include( dirname( __FILE__ ) . "/SpecialEditPage.php");
include( dirname( __FILE__ ) . "/SpecialCreatePage.php");
