<?php
/*
	The RefHelper extension is free software: you can redistribute it
	and/or modify it under the terms of the GNU General Public License
	as published by the Free Software Foundation, either version 3 of
	the License, or (at your option) any later version.

	This program is distributed WITHOUT ANY WARRANTY. See
	http://www.gnu.org/licenses/#GPL for more details.
*/

if ( !defined( 'MEDIAWIKI' ) ) {
        echo <<<EOT
To install my extension, put the following line in LocalSettings.php:
require_once( "\$IP/extensions/RefHelper/RefHelper.php" );
EOT;
        exit( 1 );
}

$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'RefHelper',
	'author' => 'Jonathan Williford',
	'url' => 'https://www.mediawiki.org/wiki/Extension:RefHelper',
	'descriptionmsg' => 'refhelper-desc',
	'version' => '0.0.2',
);

// user configurable parameters
/** $wfRefHelperCiteTemplate specifies the template that is used to create
	the citation page (the page in the $wgRefHelperCiteNS namespace). Prefix
	with subst if you want a substitution performed.
*/
$wgRefHelperCiteTemplate = "subst:Template:RefHelperCite";
/** $wfRefHelperPageTemplate specifies the template that is used to create
	the normal page (the page in MAIN_NS). */
$wgRefHelperPageTemplate = "subst:Template:RefHelperPage";
/**	The name of the namespace used for the citations.  */
$wgRefHelperCiteNS = "Cite";
/** The http path to the extension, used to find the javascript file */
$wgRefHelperExtensionPath = "/w/extensions/RefHelper/";

global $wgHooks;

$wgHooks['SkinTemplateToolboxEnd'][] = 'RefHelperHooks::addRefHelperLink';
$wgHooks['BeforePageDisplay'][] = 'RefHelperHooks::addRefHelperJavascript';
$wgHooks['AlternateEdit'][] = 'RefSearch::newArticleHook';


$dir = dirname( __FILE__ ) . '/';

$wgAutoloadClasses['RefHelperHooks'] = $dir . 'RefHelper.hooks.php';
$wgAutoloadClasses['RefHelper'] = $dir . 'RefHelper.create.php';
$wgAutoloadClasses['RefSearch'] = $dir . 'RefHelper.search.php';
$wgExtensionMessagesFiles['RefHelper'] = $dir . 'RefHelper.i18n.php';
$wgExtensionMessagesFiles['RefHelperAlias'] = $dir . 'RefHelper.alias.php';
$wgSpecialPages['RefHelper'] = 'RefHelper';
$wgSpecialPages['RefSearch'] = 'RefSearch';
$wgSpecialPageGroups['RefHelper'] = 'other';
$wgSpecialPageGroups['RefSearch'] = 'other';
