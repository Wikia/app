<?php
/**
 * ConfirmEmailPrompt
 *
 * Displays a warning/error message if user has unconfirmed e-mail
 *
 * @file
 * @ingroup Extensions
 * @author Lucas Garczewski (TOR) <tor@wikia-inc.com>
 * @date 2011-08-19
 * @copyright Copyright © 011 Lucas Garczewski, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

if ( !defined( 'MEDIAWIKI' ) ) {
        echo "This is a MediaWiki extension named ConfirmEmailPrompt.\n";
        exit( 1 );
}

// Extension credits that will show up on Special:Version
$wgExtensionCredits['other'][] = array(
        'name' => 'ConfirmEmailPrompt',
        'author' => "[http://community.wikia.com/wiki/User:TOR Lucas 'TOR' Garczewski]",
        'descriptionmsg' => 'confirmemailprompt-desc',
		'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/ConfirmEmailPrompt',
);

$wgHooks['UserLoginComplete'][] = 'efConfirmEmailPrompt';

$dir = dirname( __FILE__ );
$wgExtensionMessagesFiles['ConfirmEmailPrompt'] = $dir . '/ConfirmEmailPrompt.i18n.php';

function efConfirmEmailPrompt( &$msg ) {
	global $wgUser;

	if ( !( F::app()->checkSkin( 'oasis' ) ) ) {
		return true;
	}

	if ( $wgUser->isEmailConfirmed() ) {
		return true;
	}

	if ( $wgUser->getEmail() == '' ) {
		return true;
	}

	$message = wfMsgExt(
		'confirmemailprompt-error',
		array( 'parseinline' ),
		array(
			$wgUser->getEmail(),
			SpecialPage::getTitleFor( 'ConfirmEmail' )->getPrefixedText(),
			SpecialPage::getTitleFor( 'Preferences' )->getPrefixedText()
		)
	);

	BannerNotificationsController::addConfirmation( $message, BannerNotificationsController::CONFIRMATION_ERROR );

	return true;
}
