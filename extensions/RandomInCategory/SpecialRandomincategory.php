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
	'path' => __FILE__,
	'name' => 'Random in category',
	'author' => 'VasilievVV',
	'url' => 'http://www.mediawiki.org/wiki/Extension:RandomInCategory',
	'description' => 'Special page to get a random page in category',
	'descriptionmsg' => 'randomincategory-desc',
);

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['RandomInCategory'] = $dir . 'SpecialRandomincategory.i18n.php';
$wgExtensionAliasesFiles['RandomInCategory'] = $dir . 'SpecialRandomincategory.alias.php';

$wgSpecialPages['RandomInCategory'] = 'RandomPageInCategory';
$wgAutoloadClasses['RandomPageInCategory'] = $dir . 'SpecialRandomincategory.body.php';

$wgSpecialPageGroups['Randomincategory'] = 'redirects';
