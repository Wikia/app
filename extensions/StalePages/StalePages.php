<?php
/** \file
* \brief Contains setup code for the Stale Pages Extension.
*/

# Not a valid entry point, skip unless MEDIAWIKI is defined
if (!defined('MEDIAWIKI')) {
	echo "Stale pages extension";
	exit(1);
}

$wgExtensionCredits['specialpage'][] = array(
	'name'           => 'Stale pages',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:Stale_Pages',
	'author'         => 'Tim Laqua',
	'description'    => 'Generates a list of pages that have not been edited recently',
	'descriptionmsg' => 'stalepages-desc',
	'version'        => '0.8'
);

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['Stalepages'] = $dir . 'StalePages.i18n.php';
$wgExtensionAliasesFiles['Stalepages'] = $dir . 'Stalepages.alias.php';
$wgAutoloadClasses['Stalepages'] = $dir . 'StalePages_body.php';
$wgSpecialPages['Stalepages'] = 'Stalepages';
