<?php

/**
 * EditAccount
 *
 * This extension is used by Wikia Staff to manage essential user account information
 * in the case of a lost password and/or invalid e-mail submitted during registration.
 *
 * @author Łukasz Garczewski (TOR) <tor@wikia-inc.com>
 * @date 2008-09-17
 * @copyright Copyright (C) 2008 Łukasz Garczewski, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 * @subpackage SpecialPage
 */

if (!defined('MEDIAWIKI')) {
        echo "This is MediaWiki extension named EditAccount.\n";
        exit(1) ;
}

$wgExtensionCredits['specialpage'][] = array(
        'name' => 'EditAccount',
        'author' => "[http://www.wikia.com/wiki/User:TOR Lucas 'TOR' Garczewski]",
        'description' => 'Enables Wikia Staff members to manage user account information.'
);

$wgExtensionMessagesFiles['EditAccount'] = dirname(__FILE__) . '/SpecialEditAccount.i18n.php';

$wgSpecialPageGroups['EditAccount'] = 'users';

//Allow group STAFF to use this extension.
$wgAvailableRights[] = 'editaccount';
$wgGroupPermissions['*']['editaccount'] = false;
$wgGroupPermissions['staff']['editaccount'] = true;

//Log deffinition
$wgLogTypes[] = 'editaccnt';
$wgLogNames['editaccnt'] = 'editaccount-log';
$wgLogHeaders['editaccnt'] = 'editaccount-log-header';
$wgLogActions['editaccnt/mailchange'] = 'editaccount-log-entry-email';
$wgLogActions['editaccnt/passchange'] = 'editaccount-log-entry-pass';

//Register special page
if (!function_exists('extAddSpecialPage')) {
        require("$IP/extensions/ExtensionFunctions.php");
}
extAddSpecialPage(dirname(__FILE__) . '/SpecialEditAccount_body.php', 'EditAccount', 'EditAccount');
