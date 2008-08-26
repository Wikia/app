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
	'svn-date' => '$LastChangedDate: 2008-05-06 11:59:58 +0000 (Tue, 06 May 2008) $',
	'svn-revision' => '$LastChangedRevision: 34306 $',
	'author' => 'VasilievVV',
	'description' => 'Special page to get a random page in category',
	'descriptionmsg' => 'randomincategory-desc',
);

$wgExtensionMessagesFiles['RandomInCategory'] = dirname(__FILE__) . '/SpecialRandomincategory.i18n.php';

$wgSpecialPages['Randomincategory'] = 'RandomPageInCategory';
$wgAutoloadClasses['RandomPageInCategory'] = dirname( __FILE__ ) . '/SpecialRandomincategory.body.php';
