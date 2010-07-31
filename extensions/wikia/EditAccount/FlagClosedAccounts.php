<?php
/*
 * FlagClosedAccounts
 *
 * This code displays a clear indication that an account has been disabled
 * on that user's Special:Contributions page
 *
 * @file
 * @ingroup Extensions
 * @author Łukasz Garczewski (TOR) <tor@wikia-inc.com>
 * @date 2008-01-29
 * @copyright Copyright © 2009 Łukasz Garczewski, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "Not a valid entry point.\n";
	exit( 1 );
}

define( 'CLOSED_ACCOUNT_FLAG', 'Account Disabled' );

$wgHooks['SpecialContributionsBeforeMainOutput'][] = 'efFlagClosedAccounts';

$wgExtensionMessagesFiles['EditAccount'] = dirname( __FILE__ ) . '/SpecialEditAccount.i18n.php';

function efFlagClosedAccounts( $id ) {
	global $wgOut;

	if ( User::whoIsReal( $id ) == CLOSED_ACCOUNT_FLAG ) {
		wfLoadExtensionMessages( 'EditAccount' );
		$wgOut->addWikiMsg( 'edit-account-closed-flag' );
	}

	return true;
}
