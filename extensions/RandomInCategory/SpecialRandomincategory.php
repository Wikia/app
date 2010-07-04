<?php

/**
 * Special page to direct the user to a random page in specified category
 *
 * @addtogroup SpecialPage
 * @author VasilievVV <vasilvv@gmail.com>, based on SpecialRandompage.php code
 * @license GNU General Public Licence 2.0 or later
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	exit(1);
}

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Random in category',
	'svn-date' => '$LastChangedDate: 2009-01-07 11:49:46 +0000 (Wed, 07 Jan 2009) $',
	'svn-revision' => '$LastChangedRevision: 45494 $',
	'author' => 'VasilievVV',
	'url' => 'http://www.mediawiki.org/wiki/Extension:RandomInCategory',
	'description' => 'Special page to get a random page in category',
	'descriptionmsg' => 'randomincategory-desc',
);

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['RandomInCategory'] = $dir . 'SpecialRandomincategory.i18n.php';
$wgExtensionAliasesFiles['RandomInCategory'] = $dir . 'SpecialRandomincategory.alias.php';

$wgSpecialPages['Randomincategory'] = 'RandomPageInCategory';
$wgAutoloadClasses['RandomPageInCategory'] = $dir . 'SpecialRandomincategory.body.php';

$wgSpecialPageGroups['Randomincategory'] = 'redirects';
