<?php
/**
 * @package MediaWiki
 * @subpackage SpecialPage
 * @author Bartek Lapinski <bartek@wikia.com>, Piotr Molski <moli@wikia.com> for Wikia.com
 * @copyright (C) 2008, Wikia Inc.
 * @licence GNU General Public Licence 2.0 or later
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "This is MediaWiki extension named MultipleLookup.\n";
	exit( 1 ) ;
}

$wgExtensionCredits['specialpage'][] = [
	'name' => 'Multiple Lookup',
	'description' => 'Provides user lookup on multiple wikis',
	'descriptionmsg' => 'specialmultiplelookup-desc',
	'author' => [ 'Bartek Lapinski', 'Piotr Molski' ],
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/SpecialMultipleLookup',
];

$wgAutoloadClasses['MultiLookupPager'] = __DIR__ . '/MultiLookupPager.php';
$wgAutoloadClasses['MultiLookupRowFormatter'] = __DIR__ . '/MultiLookupRowFormatter.php';
$wgAutoloadClasses['SpecialMultiLookup'] = __DIR__ . '/SpecialMultiLookup.php';

$wgSpecialPages['MultiLookup'] = 'SpecialMultiLookup';
$wgSpecialPageGroups['MultiLookup'] = 'users';

$wgResourceModules['ext.wikia.multiLookup'] = [
	'scripts' => [],
	'styles' => [ 'css/SpecialMultiLookup.css' ],
	'dependencies' => [],

	'localBasePath' => __DIR__,
	'remoteExtPath' => 'wikia/SpecialMultipleLookup',
];
