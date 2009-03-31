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
	'svn-date' => '$LastChangedDate: 2008-09-05 14:09:21 +0000 (Fri, 05 Sep 2008) $',
	'svn-revision' => '$LastChangedRevision: 40488 $',
	'author' => 'VasilievVV',
	'description' => 'Special page to get a random page in category',
	'descriptionmsg' => 'randomincategory-desc',
);

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['RandomInCategory'] = $dir . 'SpecialRandomincategory.i18n.php';
$wgExtensionAliasesFiles['RandomInCategory'] = $dir . 'SpecialRandomincategory.alias.php';

$wgSpecialPages['Randomincategory'] = 'RandomPageInCategory';
$wgAutoloadClasses['RandomPageInCategory'] = $dir . 'SpecialRandomincategory.body.php';
