<?php
/**
 * Header Tabs extension
 *
 * @file
 * @ingroup Extensions
 *
 * @author Sergey Chernyshev
 * @author Yaron Koren
 * @author Olivier Finlay Beaton
 */

$htScriptPath = $wgScriptPath . '/extensions/HeaderTabs';

$dir = dirname( __FILE__ );

// the file loaded depends on whether the ResourceLoader exists, which in
// turn depends on what version of MediaWiki this is - for MW 1.17+,
// HeaderTabs_body.jq.php will get loaded
$useJQuery = is_callable( array( 'OutputPage', 'addModules' ) );

$wgExtensionCredits['parserhook'][] = array(
	'path' => __FILE__,
	'name' => 'Header Tabs',
	'descriptionmsg' => 'headertabs-desc',
	'version' => '0.9.2',
	'author' => array( '[http://www.sergeychernyshev.com Sergey Chernyshev]', 'Yaron Koren', '[http://olivierbeaton.com Olivier Finlay Beaton]' ),
	'url' => 'https://www.mediawiki.org/wiki/Extension:Header_Tabs'
);

// Translations
$wgExtensionMessagesFiles['HeaderTabs'] = $dir . '/HeaderTabs.i18n.php';
//! @todo implement in tab parsing code instead... but problems like nowiki (2011-12-12, ofb)
// if you make them here, it will be article wide instead of tab-wide
// __NOTABTOC__, __TABTOC__, __NOEDITTAB__
// and one day with a special page: __NEWTABLINK__, __NONEWTABLINK__
// and one day if we can force toc generation: __FORCETABTOC__
$wgExtensionMessagesFiles['HeaderTabsMagic'] = $dir . '/HeaderTabs.i18n.magic.php';

// Config
$htUseHistory = true;
$htRenderSingleTab = false;
$htAutomaticNamespaces = array();
$htDefaultFirstTab = false;
$htDisableDefaultToc = true;
$htGenerateTabTocs = false;
$htStyle = 'jquery-large';
$htEditTabLink = true;

// Other variables
$htTabIndexes = array();

// Extension:Configure
if ( isset( $wgConfigureAdditionalExtensions ) && is_array( $wgConfigureAdditionalExtensions ) ) {

	/**
	 * attempt to tell Extension:Configure how to web configure our extension
	 * @since 2011-09-22, 0.2
	 */
	$wgConfigureAdditionalExtensions[] = array(
			'name' => 'HeaderTabs',
			'settings' => array(
					'htUseHistory' => 'bool',
					'htRenderSingleTab' => 'bool',
					'htAutomaticNamespaces' => 'array',
					'htDefaultFirstTab' => 'string',
					'htDisableDefaultToc' => 'bool',
					'htGenerateTabTocs' => 'bool',
					'htStyle' => 'string',
					'htEditTabLink' => 'bool',
				),
			'array' => array(
					'htAutomaticNamespaces' => 'simple',
				),
			'schema' => false,
			'url' => 'https://www.mediawiki.org/wiki/Extension:Header_Tabs',
		);

} // $wgConfigureAdditionalExtensions exists

// used by both jQuery and YUI
$wgHooks['ParserFirstCallInit'][] = 'headerTabsParserFunctions';
$wgHooks['BeforePageDisplay'][] = 'HeaderTabs::addHTMLHeader';
$wgHooks['ParserAfterTidy'][] = 'HeaderTabs::replaceFirstLevelHeaders';

if ( $useJQuery ) {
	$wgAutoloadClasses['HeaderTabs'] = "$dir/HeaderTabs_body.jq.php";

	$wgHooks['ResourceLoaderGetConfigVars'][] = 'HeaderTabs::addConfigVarsToJS';

	$wgResourceModules['ext.headertabs'] = array(
		// JavaScript and CSS styles. To combine multiple file, just list them as an array.
		'scripts' => 'skins-jquery/ext.headertabs.core.js',
		// 'styles' => // the style is added in HeaderTabs::addHTMLHeader

		// If your scripts need code from other modules, list their identifiers as dependencies
		// and ResourceLoader will make sure they're loaded before you.
		// You don't need to manually list 'mediawiki' or 'jquery', which are always loaded.
		'dependencies' => array( 'jquery.ui.tabs' ),

		// ResourceLoader needs to know where your files are; specify your
		// subdir relative to "/extensions" (or $wgExtensionAssetsPath)
		'localBasePath' => dirname( __FILE__ ),
		'remoteExtPath' => 'HeaderTabs',
	);
	$wgHooks['MakeGlobalVariablesScript'][] = 'HeaderTabs::setGlobalJSVariables';
} else { // if ! $useJQuery
	$wgAutoloadClasses['HeaderTabs'] = "$dir/HeaderTabs_body.yui.php";
}

# Parser function to insert a link changing a tab:
function headerTabsParserFunctions( $parser ) {
	$parser->setHook( 'headertabs', array( 'HeaderTabs', 'tag' ) );
	$parser->setFunctionHook( 'switchtablink', array( 'HeaderTabs', 'renderSwitchTabLink' ) );
	return true;
}
