<?php

if ( ! defined( 'MEDIAWIKI' ) )
	die();
/**#@+
 *
 * A bot interface extension that adds edit assertions, to help bots ensure
 * they stay logged in, and are working with the right wiki.
 *
 * @package MediaWiki
 * @subpackage Extensions
 *
 * @link http://www.mediawiki.org/wiki/Extension:Assert_Edit
 *
 * @author Steve Sanbeg
 * @copyright Copyright © 2006-2007, Steve Sanbeg
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

$wgExtensionCredits['other'][] = array(
	'name' => 'AssertEdit',
	'svn-date' => '$LastChangedDate: 2008-07-23 21:33:28 +0200 (śro, 23 lip 2008) $',
	'svn-revision' => '$LastChangedRevision: 37971 $',
	'author' => 'Steve Sanbeg',
	'description' => 'Adds edit assertions for use by bots',
	'descriptionmsg' => 'assert_edit_desc',
	'url' => 'http://www.mediawiki.org/wiki/Extension:Assert_Edit',
);

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['AssertEdit'] = $dir . 'AssertEdit.i18n.php';
$wgAutoloadClasses['AssertEdit'] = $dir . 'AssertEdit_body.php';
$wgHooks['AlternateEdit'][] = 'efAssertEditHook';
$wgHooks['APIEditBeforeSave'][] = 'efAssertApiEditHook';

function efAssertEditHook( &$editpage ) {
	global $wgOut, $wgRequest;

	$assertName = $wgRequest->getVal( 'assert' );
	$pass = true;

	if ( $assertName != '' ) {
		$pass = AssertEdit::callAssert( $assertName, false );
	}

	//check for negative assert
	if ( $pass ) {
		$assertName = $wgRequest->getVal( 'nassert' );
		if ( $assertName != '' ) {
			$pass = AssertEdit::callAssert( $assertName, true );
		}
	}

	if ( $pass ) {
		return true;
	} else {
		wfLoadExtensionMessages( 'AssertEdit' );

		//slightly modified from showErrorPage(), to return back here.
		$wgOut->setPageTitle( wfMsg( 'assert_edit_title' ) );
		$wgOut->setHTMLTitle( wfMsg( 'errorpagetitle' ) );
		$wgOut->setRobotPolicy( 'noindex,nofollow' );
		$wgOut->setArticleRelated( false );
		$wgOut->enableClientCache( false );
		$wgOut->mRedirect = '';

		$wgOut->mBodytext = '';
		$wgOut->addWikiText( wfMsg( 'assert_edit_message', $assertName ) );

		$wgOut->returnToMain( false, $editpage->mTitle );
		return false;
	}
}
function efAssertApiEditHook( &$editPage, $textBox, &$result ) {
	global $wgOut, $wgRequest;

	$assertName = $wgRequest->getVal( 'assert' );
	$pass = true;

	if ( $assertName != '' ) {
		$pass = AssertEdit::callAssert( $assertName, false );
		if ( !$pass ) 
			$result['assert'] = $assertName;
	}

	//check for negative assert
	if ( $pass ) {
		$assertName = $wgRequest->getVal( 'nassert' );
		if ( $assertName != '' ) {
			$pass = AssertEdit::callAssert( $assertName, true );
		}
		if ( !$pass )
			$result['nassert'] = $assertName;
	}
	
	return $pass == true;
}
