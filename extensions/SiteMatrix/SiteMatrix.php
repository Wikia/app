<?php

/**
 * Make an HTML table showing all the wikis on the site
 */

# Not a valid entry point, skip unless MEDIAWIKI is defined
if (!defined('MEDIAWIKI')) {
	echo "This file is part of MediaWiki, it is not a valid entry point.\n";
	exit(1);
}

$wgExtensionCredits['specialpage'][] = array(
	'name'           => 'SiteMatrix',
	'svn-date' => '$LastChangedDate: 2008-07-21 20:14:27 +0000 (Mon, 21 Jul 2008) $',
	'svn-revision' => '$LastChangedRevision: 37888 $',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:SiteMatrix',
	'description'    => 'Displays a list of Wikimedia wikis',
	'descriptionmsg' => 'sitematrix-desc',
);

$wgSiteMatrixFile = '/home/wikipedia/common/langlist';
$wgSiteMatrixSites = array(
	'wiki' => array(
		'name' => 'Wikipedia',
		'host' => 'www.wikipedia.org',
		'prefix' => 'w',
	),
	'wiktionary' => array(
		'name' => 'Wiktionary',
		'host' => 'www.wiktionary.org',
		'prefix' => 'wikt',
	),
	'wikibooks' => array(
		'name' => 'Wikibooks',
		'host' => 'www.wikibooks.org',
		'prefix' => 'b',
	),
	'wikinews' => array(
		'name' => 'Wikinews',
		'host' => 'www.wikinews.org',
		'prefix' => 'n',
	),
	'wikiquote' => array(
		'name' => 'Wikiquote',
		'host' => 'www.wikiquote.org',
		'prefix' => 'q',
	),
	'wikisource' => array(
		'name' => 'Wikisource',
		'host' => 'www.wikisource.org',
		'prefix' => 's',
	),
	'wikiversity' => array(
		'name' => 'Wikiversity',
		'host' => 'www.wikiversity.org',
		'prefix' => 'v',
	)
);

$dir = dirname(__FILE__) . '/';

$wgExtensionMessagesFiles['SiteMatrix'] = $dir . 'SiteMatrix.i18n.php';
$wgExtensionAliasesFiles['SiteMatrix'] = $dir . 'SiteMatrix.alias.php';

$wgAutoloadClasses['SiteMatrixPage'] = $dir . 'SiteMatrix_body.php';
$wgSpecialPages['SiteMatrix'] = 'SiteMatrixPage';

$wgAutoloadClasses['ApiQuerySiteMatrix'] = $dir . 'SiteMatrix_body.php';
$wgAPIModules['sitematrix'] = 'ApiQuerySiteMatrix';
