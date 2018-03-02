<?php

/**
 * @package MediaWiki
 * @subpackage SpecialPage
 * @author Krzysztof Krzyżaniak <eloy@wikia.com> for Wikia.com
 * @copyright (C) 2007, Wikia Inc.
 * @licence GNU General Public Licence 2.0 or later
 * @version: $Id: SpecialWikiFactory.php 11926 2008-04-23 13:58:29Z eloy $
 */

if ( !defined( 'MEDIAWIKI' ) ) {
    echo "This is MediaWiki extension named WikiFactory.\n";
    exit( 1 ) ;
}

$wgExtensionCredits['specialpage'][] = array(
    "name" => "WikiFactory",
    "descriptionmsg" => "wikifactory-desc",
	"version" => preg_replace( '/^.* (\d\d\d\d-\d\d-\d\d).*$/', '\1', '$Id: SpecialWikiFactory.php 11926 2008-04-23 13:58:29Z eloy $' ),
    "author" => "[http://www.wikia.com/wiki/User:Eloy.wikia Krzysztof Krzyżaniak (eloy)]",
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/WikiFactory'
);

$dir = dirname( __FILE__ );
/**
 * messages file
 */
$wgExtensionMessagesFiles["WikiFactory"] =  $dir . '/SpecialWikiFactory.i18n.php';

/**
 * helper file
 */
require_once( $dir . '/SpecialWikiFactory_ajax.php' );

/**
 * tags
 */
require_once( $dir . '/Tags/WikiFactoryTags.php' );
require_once( $dir . '/Tags/WikiFactoryTagsQuery.php' );

extAddSpecialPage( dirname(__FILE__) . '/SpecialWikiFactory_body.php', 'WikiFactory', 'WikiFactoryPage' );
$wgSpecialPageGroups['WikiFactory'] = 'wikia';

$wgAutoloadClasses[ "CloseWikiPage" ] = $dir. "/Close/SpecialCloseWiki_body.php";
$wgSpecialPages[ "CloseWiki" ] = "CloseWikiPage";
$wgSpecialPageGroups[ "CloseWiki" ] = 'wikia';

$wgAutoloadClasses['WikiFactoryVariableParser'] = __DIR__ . '/WikiFactoryVariableParser.php';
$wgAutoloadClasses['WikiFactoryVariableParseException'] = __DIR__ . '/WikiFactoryVariableParseException.php';
$wgAutoloadClasses['ApiWikiFactorySaveVariable'] = __DIR__ . '/api/ApiWikiFactorySaveVariable.php';
$wgAutoloadClasses['ApiWikiFactoryRemoveVariable'] = __DIR__ . '/api/ApiWikiFactoryRemoveVariable.php';
$wgAPIModules['wfsavevariable'] = 'ApiWikiFactorySaveVariable';
$wgAPIModules['wfremovevariable'] = 'ApiWikiFactoryRemoveVariable';

$wgResourceModules['ext.wikia.wikiFactory'] = [
	'scripts' => [
		'js/ext.wikia.wikiFactory.requestManager.js',
		'js/ext.wikia.wikiFactory.variableService.js',
		'js/ext.wikia.wikiFactory.variableManager.js',
	],

	'localBasePath' => __DIR__,
	'remoteExtPath' => 'wikia/WikiFactory',
];
