<?php
/**
 * CreateInCategory
 *
 * This extension is used by Wikia Staff to manage essential user account information
 * in the case of a lost password and/or invalid e-mail submitted during registration.
 *
 * @file
 * @ingroup Extensions
 * @author Łukasz Garczewski (TOR) <tor@wikia-inc.com>
 * @date 2008-09-17
 * @copyright Copyright © 2008 Łukasz Garczewski, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

if( !defined( 'MEDIAWIKI' ) ) {
	echo "This is a MediaWiki extension named CreateInCategory.\n";
	exit( 1 );
}

// Extension credits that will show up on Special:Version
$wgExtensionCredits['specialpage'][] = array(
	'name' => 'CreateInCategory',
	'author' => "[http://www.wikia.com/wiki/User:TOR Łukasz 'TOR' Garczewski]",
	'description' => 'Enables Wikia Staff members to manage user account information.'
);

// Set up the new special page
$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['CreateInCategory'] = $dir . 'CreateInCategory.i18n.php';
$wgAutoloadClasses['CreateInCategory'] = $dir. 'SpecialCreateInCategory_body.php';
$wgSpecialPages['CreateInCategory'] = 'CreateInCategory';
// Special page group for MW 1.13+
$wgSpecialPageGroups['CreateInCategory'] = 'users';

$wgHooks['CategoryPageView'][] = 'efCreateInCategoryForm';

function efCreateInCategoryForm( $catpage ) {
	global $wgOut;

	wfLoadExtensionMessages( 'CreateInCategory' );

	$url = 'http://techteam-qa3.wikia.com/wiki/Special:CreateInCategory';

	$form = Xml::openElement( 'div', array( 'style' => 'float: right; padding: 1em; width: 33%', 'class' => 'toc' ) );
	$form .= Xml::element( 'div', array(), wfMsg( 'createincategory-prompt' ) );
	$form .= Xml::openElement( 'form', array( 'method' => 'post', 'action' => $url ) );
	$form .= Xml::input( 'wpTitle' );
	$form .= Xml::hidden( 'wpCategory', $catpage->mTitle->getText() );
	$form .= Xml::submitButton( wfMsg( 'createincategory-submit' ) );
	$form .= Xml::closeElement( 'form' );
	$form .= Xml::closeElement( 'div' );

	$wgOut->addHtml( $form );

	return true;
}
