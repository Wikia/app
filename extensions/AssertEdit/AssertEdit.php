<?php
if ( ! defined( 'MEDIAWIKI' ) )
	die();
/**#@+
 *
 * A bot interface extension that adds edit assertions, to help bots ensure
 * they stay logged in, and are working with the right wiki.
 *
 * @file
 * @ingroup Extensions
 *
 * @link http://www.mediawiki.org/wiki/Extension:Assert_Edit
 *
 * @author Steve Sanbeg
 * @copyright Copyright © 2006-2007, Steve Sanbeg
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'AssertEdit',
	'author' => 'Steve Sanbeg',
	'descriptionmsg' => 'assertedit-desc',
	'url' => 'https://www.mediawiki.org/wiki/Extension:Assert_Edit',
);

$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['AssertEdit'] = $dir . 'AssertEdit.i18n.php';
$wgAutoloadClasses['AssertEdit'] = $dir . 'AssertEdit_body.php';

$wgHooks['AlternateEdit'][] = 'efAssertEditHook';
$wgHooks['APIEditBeforeSave'][] = 'efAssertApiEditHook';
$wgHooks['APIGetAllowedParams'][] = 'efAssertApiEditGetAllowedParams';
$wgHooks['APIGetParamDescription'][] = 'efAssertApiEditGetParamDescription';

/**
 * @param $editpage EditPage
 * @return bool
 */
function efAssertEditHook( $editpage ) {
	global $wgOut, $wgRequest;

	$assertName = $wgRequest->getVal( 'assert' );
	$pass = true;

	if ( $assertName != '' ) {
		$pass = AssertEdit::callAssert( $editpage, $assertName, false );
	}

	// check for negative assert
	if ( $pass ) {
		$assertName = $wgRequest->getVal( 'nassert' );
		if ( $assertName != '' ) {
			$pass = AssertEdit::callAssert( $editpage, $assertName, true );
		}
	}

	if ( $pass ) {
		return true;
	} else {
		// slightly modified from showErrorPage(), to return back here.
		$wgOut->setPageTitle( wfMsg( 'assert_edit_title' ) );
		$wgOut->setHTMLTitle( wfMsg( 'errorpagetitle' ) );
		$wgOut->setRobotPolicy( 'noindex,nofollow' );
		$wgOut->setArticleRelated( false );
		$wgOut->enableClientCache( false );
		$wgOut->mRedirect = '';

		$wgOut->mBodytext = '';
		$wgOut->addWikiMsg( 'assert_edit_message', $assertName );

		$wgOut->returnToMain( false, $editpage->mTitle );
		return false;
	}
}

/**
 * @param $editPage EditPage
 * @param $textBox
 * @param $result array
 * @return bool|mixed
 */
function efAssertApiEditHook( $editPage, $textBox, &$result ) {
	global $wgRequest;

	$assertName = $wgRequest->getVal( 'assert' );
	$pass = true;

	if ( $assertName != '' ) {
		$pass = AssertEdit::callAssert( $editPage, $assertName, false );
		if ( !$pass ) {
			$result['assert'] = $assertName;
		}
	}

	// check for negative assert
	if ( $pass ) {
		$assertName = $wgRequest->getVal( 'nassert' );
		if ( $assertName != '' ) {
			$pass = AssertEdit::callAssert( $editPage, $assertName, true );
		}
		if ( !$pass ) {
			$result['nassert'] = $assertName;
		}
	}

	return $pass;
}

/**
 * @param $module ApiBase
 * @param $params array
 * @return bool
 */
function efAssertApiEditGetAllowedParams( &$module, &$params ) {
	if ( !$module instanceof ApiEditPage ) {
		return true;
	}

	$options = array_keys( AssertEdit::$msAssert );
	$params['assert'][ApiBase::PARAM_TYPE] = $options;
	$params['nassert'][ApiBase::PARAM_TYPE] = $options;

	return true;
}

/**
 * @param $module ApiBase
 * @param $desc array
 * @return bool
 */
function efAssertApiEditGetParamDescription( &$module, &$desc ) {
	if ( !$module instanceof ApiEditPage ) {
		return true;
	}

	$options = array(
		' true   - Always true; nassert=true will fail if the extension is installed.',
		' false  - Always false; assert=false will fail if the extension is installed.',
		' user   - Verify that bot is logged in, to prevent anonymous edits.',
		' bot    - Verify that bot is logged in and has a bot flag.',
		' exists - Verify that page exists. Could be useful from other extensions, i.e. adding nassert=exists to the inputbox extension.',
		' test   - Verify that this wiki allows random testing. Defaults to false, but can be overridden in LocalSettings.php.'
	);
	$desc['assert'] = array_merge( array( 'Allows bots to make assertions.' ), $options );
	$desc['nassert'] = array_merge( array( 'Allows bots to make negative assertions.' ), $options );

	return true;
}
