<?php

/**
 * Quickie special page to search the external-links table.
 * Currently only 'http' links are supported; LinkFilter needs to be
 * changed to allow other pretties.
 */

$wgExtensionCredits['specialpage'][] = array(
	'name'           => 'Link Search',
	'author'         => 'Brion Vibber',
	'description'    => 'Find pages with external links matching specific patterns',
	'descriptionmsg' => 'linksearch-desc',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:LinkSearch',
	'version'        => '1.4',
);

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['LinkSearch'] = $dir . 'LinkSearch.i18n.php';
$wgExtensionAliasesFiles['LinkSearch'] = $dir . 'LinkSearch.alias.php';

$wgSpecialPages['LinkSearch'] = 'LinkSearchSpecialPage';
$wgSpecialPageGroups['LinkSearch'] = 'redirects';
$wgAutoloadClasses['LinkSearchPage'] = $dir . 'LinkSearchPage.php';
$wgAutoloadClasses['LinkSearchSpecialPage'] = $dir . 'LinkSearch_body.php';
