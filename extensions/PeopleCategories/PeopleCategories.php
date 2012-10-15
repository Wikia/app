<?php

/**
 * PeopleCategories Extension
 *
 * Changes displayed page names from "Firstname Lastname" to "Lastname,
 * Firstname" on specified category pages.
 *
 * @file
 * @ingroup Extensions
 *
 * @link http://www.mediawiki.org/wiki/Extension:PeopleCategories
 *
 * @author Robert Leverington for whatleadership.com <robert@rhl.me.uk>
 * @copyright Copyright © 2010 Direction Group ApS <http://direction.dk/>.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

if( !defined( 'MEDIAWIKI' ) ) die( 'Invalid entry point.' );

// Register extension credits.
$wgExtensionCredits['other'][] = array(
	'path'            => __FILE__,
	'name'            => 'PeopleCategories',
	'version'         => '1.0.0',
	'author'          => 'Robert Leverington for whatleadership.com',
	'url'             => 'https://www.mediawiki.org/wiki/Extension:PeopleCategories',
	'descriptionmsg'  => 'peoplecategories-desc'
);

// Register internationalisation file.
$wgExtensionMessagesFiles['PeopleCategories'] = dirname( __FILE__ ) . '/PeopleCategories.i18n.php';

// Register required hooks.
$wgHooks['CategoryPageView'][] = 'efPeopleCategories';

// Register autoload classes.
$wgAutoloadClasses['PeopleCategoriesPage'] = dirname( __FILE__ ) . '/PeopleCategories.body.php';
$wgAutoloadClasses['PeopleCategoriesViewer'] = dirname( __FILE__ ) . '/PeopleCategories.body.php';

// Configuration variable.
$wgPeopleCategories = array();

function efPeopleCategories( &$categoryArticle ) {
	$n = new PeopleCategoriesPage( $categoryArticle->mTitle );
	foreach( $categoryArticle as $k=>$v ) {
		$n->$k = $v;
	}
	$n->view();
	return false;
}
