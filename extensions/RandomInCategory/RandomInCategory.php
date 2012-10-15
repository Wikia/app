<?php

/**
 * Special page to direct the user to a random page in specified category
 *
 * @file
 * @ingroup Extensions
 * @author VasilievVV <vasilvv@gmail.com>, based on SpecialRandompage.php code
 * @license GNU General Public Licence 2.0 or later
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	exit(1);
}

$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'Random in category',
	'author' => array( 'VasilievVV', 'Sam Reed' ),
	'version' => '2.0',
	'url' => 'https://www.mediawiki.org/wiki/Extension:RandomInCategory',
	'descriptionmsg' => 'randomincategory-desc',
);

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['RandomInCategory'] = $dir . 'RandomInCategory.i18n.php';
$wgExtensionMessagesFiles['RandomInCategoryAlias'] = $dir . 'RandomInCategory.alias.php';

$wgSpecialPages['RandomInCategory'] = 'RandomPageInCategory';
$wgAutoloadClasses['RandomPageInCategory'] = $dir . 'RandomInCategory.body.php';
