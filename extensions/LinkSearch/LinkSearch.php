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
	'version'        => '1.3',
);

$wgExtensionMessagesFiles['LinkSearch'] = dirname(__FILE__) . '/LinkSearch.i18n.php';
$wgExtensionAliasesFiles['LinkSearch'] = dirname(__FILE__) . '/LinkSearch.alias.php';

$wgSpecialPages['Linksearch'] = array( /*class*/ 'LinkSearchSpecialPage',
	/*name*/ 'Linksearch', /* permission */'', /*listed*/ true,
	/*function*/ false, /*file*/ false );
$wgAutoloadClasses['LinkSearchPage'] = dirname(__FILE__) . '/LinkSearch_body.php';
$wgAutoloadClasses['LinkSearchSpecialPage'] = dirname(__FILE__) . '/LinkSearch_body.php';
