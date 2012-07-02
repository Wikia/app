<?php
if ( ! defined( 'MEDIAWIKI' ) )
{
	echo( "This file is an extension to the MediaWiki software. It cannot be used standalone.\n" );
	exit( 1 );
}
/**
 * Extension enforces a minimum username length
 * during account registration
 *
 * @file
 * @ingroup Extensions
 * @author Rob Church <robchur@gmail.com>
 */

/**
 * Minimum username length to enforce
 */
$wgMinimumUsernameLength = 10;

$wgExtensionCredits['other'][] = array(
	'name' => 'Minimum Username Length',
	'version' => '1.1',
	'author' => 'Rob Church',
	'descriptionmsg' => 'minnamelength-desc',
	'url' => 'https://www.mediawiki.org/wiki/Extension:Minimum_Name_Length',
);

$wgExtensionMessagesFiles['MinimumNameLength'] = dirname(__FILE__) . '/MinimumNameLength.i18n.php';
$wgHooks['AbortNewAccount'][] = 'efMinimumNameLength';

/**
 * Hooks account creation and checks the
 * username length, cancelling with an error
 * if the username is too short
 *
 * @param User $user User object being created
 * @param string $error Reference to error message to show
 * @return bool
 */
function efMinimumNameLength( $user, &$error ) {
	global $wgMinimumUsernameLength;

	if( mb_strlen( $user->getName() ) < $wgMinimumUsernameLength ) {
		
		$error = wfMsgHtml( 'minnamelength-error', $wgMinimumUsernameLength );
		return false;
	}

	return true;
}
