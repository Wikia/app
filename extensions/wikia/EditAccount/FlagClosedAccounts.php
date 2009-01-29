<?php
/*
 * FlagClosedAccounts
 *
 * This code displays a clear indication that an account has been disabled
 * on it Special:Contributions page
 *
 * @author Łukasz Garczewski (TOR) <tor@wikia-inc.com>
 * @date 2008-01-29
 * @copyright Copyright (C) 2009 Łukasz Garczewski, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 */

if (!defined('MEDIAWIKI')) {
        echo "Not a valid entry point.\n";
        exit(1) ;
}

define('CLOSED_ACCOUNT_FLAG', 'Account Disabled');

$wgHooks['SpecialContributionsBeforeMainOutput'][] = 'weFlagClosedAccounts';

$wgExtensionMessagesFiles['EditAccount'] = dirname(__FILE__) . '/SpecialEditAccount.i18n.php';

function weFlagClosedAccounts( $id ) {
	global $wgOut;

	if ( User::whoIsReal( $id ) == CLOSED_ACCOUNT_FLAG ) {
		wfLoadExtensionMessages('EditAccount');
		$wgOut->addWikiText( wfMsg('edit-account-closed-flag') );
	}

	return true;
}
