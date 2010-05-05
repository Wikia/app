<?php
/*
 * Copyright © 2008-2010 Garrett Brown <http://www.mediawiki.org/wiki/User:Gbruin>
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License along
 * with this program. If not, see <http://www.gnu.org/licenses/>.
 */


/*
 * Not a valid entry point, skip unless MEDIAWIKI is defined.
 */
if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'This file is a MediaWiki extension, it is not a valid entry point' );
}


/**
 * FBConnect.i18n.php
 * 
 * Internationalization file for FBConnect.
 */


$messages = array();

// Shorthand to make my life more sane
if (!defined( 'fb' )) {
	define( 'fb', 'fbconnect-' );
}

/** English */
$messages['en'] = array(
// Extension name
'fbconnect'   => 'Facebook Connect',
fb.'desc'     => 'Enables users to [[Special:Connect|Connect]] with their [http://www.facebook.com Facebook] ' .
                 'accounts. Offers authentification based on Facebook groups and the use of FBML in wiki text.',
// Group containing Facebook Connect users
'group-fb-user'           => 'Facebook Connect users',
'group-fb-user-member'    => 'Facebook Connect user',
'grouppage-fb-user'       => '{{ns:project}}:Facebook Connect users',
// Group for Facebook Connect users beloning to the group specified by $fbUserRightsFromGroup
'group-fb-groupie'        => 'Group members',
'group-fb-groupie-member' => 'Group member',
'grouppage-fb-groupie'    => '{{ns:project}}:Group members',
// Officers of the Facebook group
'group-fb-officer'        => 'Group officers',
'group-fb-officer-member' => 'Group officer',
'grouppage-fb-officer'    => '{{ns:project}}:Group officers',
// Admins of the Facebook group
'group-fb-admin'          => 'Group admins',
'group-fb-admin-member'   => 'Group administrator',
'grouppage-fb-admin'      => '{{ns:project}}:Group admins',
// Incredibly good looking people
'right-goodlooking'       => 'Really, really, ridiculously good looking',
// Personal toolbar
fb.'connect'  => 'Log in with Facebook Connect',
fb.'convert'  => 'Connect this account with Facebook',
fb.'logout'   => 'Logout of Facebook',
fb.'link'     => 'Back to facebook.com',

// Special:Connect
fb.'title'    => 'Connect account with Facebook',
fb.'intro'    => 'This wiki is enabled with Facebook Connect, the next evolution of Facebook Platform. This means ' .
                 'that when you are Connected, in addition to the normal [[Wikipedia:Help:Logging in#Why log in?' .
                 '|benefits]] you see when logging in, you will be able to take advantage of some extra features...',
fb.'click-to-login' => 'Click this button to login to this site via facebook',
fb.'click-to-connect-existing' => 'Click this button to connect your facebook account to $1',
fb.'conv'     => 'Convenience',
fb.'convdesc' => 'Connected users are automatically logged you in. If permission is given, then this wiki can even ' .
                 'use Facebook as an email proxy so you can continue to receive important notifications without ' .
                 'revealing your email address.',
fb.'fbml'     => 'Facebook Markup Language',
fb.'fbmldesc' => 'Facebook has provided a bunch of built-in tags that will render dynamic data. Many of these tags ' .
                 'can be included in wiki text, and will be rendered differently depending on which Connected user ' .
                 'they are being viewed by.',
fb.'comm'     => 'Communication',
fb.'commdesc' => 'Facebook Connect ushers in a whole new level of networking. See which of your friends are using ' .
                 'the wiki, and optionally share your actions with your friends through the Facebook News Feed.',
fb.'welcome'  => 'Welcome, Facebook Connect user!',
fb.'loginbox' => "Or '''login''' with Facebook:\n\n$1",
fb.'merge'    => 'Merge your wiki account with your Facebook ID',
fb.'mergebox' => 'This feature has not yet been implemented. Accounts can be merged manually with [[Special:' .
                 'Renameuser]] if it is installed. For more information, please visit [[MediaWikiWiki:Extension:' .
                 "Renameuser|Extension:Renameuser]].\n\n\n$1\n\n\nNote: This can be undone by a sysop.",
fb.'logoutbox'=> "$1\n\nThis will also log you out of Facebook and all Connected sites, including this wiki.",
fb.'listusers-header'
              => '$1 and $2 privileges are automatically transfered from the Officer and Admin titles of the ' .
                 "Facebook group $3.\n\nFor more info, please contact the group creator $4.",
// Prefix to use for automatically-generated usernames
fb.'usernameprefix' => 'FacebookUser',
// Special:Connect
fb.'error' => 'Verification error',
fb.'errortext' => 'An error occured during verification with Facebook Connect.',
fb.'cancel' => 'Action cancelled',
fb.'canceltext' => 'The previous action was cancelled by the user.',
fb.'invalid' => 'Invalid option',
fb.'invalidtext' => 'The selection made on the previous page was invalid.',
fb.'success' => 'Facebook verification succeeded',
fb.'successtext' => 'You have been successfully logged in with Facebook Connect.',
#fb.'optional' => 'Optional',
#fb.'required' => 'Required',
fb.'nickname' => 'Nickname',
fb.'fullname' => 'Fullname',
fb.'email' => 'E-mail address',
fb.'language' => 'Language',
fb.'timecorrection' => 'Time zone correction (hours)',
fb.'chooselegend' => 'Username choice',
fb.'chooseinstructions' => 'All users need a nickname; you can choose one from the options below.',
fb.'invalidname' => 'The nickname you chose is already taken or not a valid nickname. Please chose a different one.',
fb.'choosenick' => 'Your Facebook profile name ($1)',
fb.'choosefirst' => 'Your first name ($1)',
fb.'choosefull' => 'Your full name ($1)',
fb.'chooseauto' => 'An auto-generated name ($1)',
fb.'choosemanual' => 'A name of your choice:',
fb.'chooseexisting' => 'An existing account on this wiki',
fb.'chooseusername' => 'Username:',
fb.'choosepassword' => 'Password:',
fb.'updateuserinfo' => 'Update the following personal information:',
fb.'alreadyloggedin' => "'''You are already logged in, $1!'''\n\nIf you want to use Facebook " .
                        'Connect to log in in the future, you can [[Special:Connect/Convert|' .
                        'convert your account to use Facebook Connect]].',
/*
fb.'convertinstructions' => 'This form lets you change your user account to use an OpenID URL or add more OpenID URLs',
fb.'convertoraddmoreids' => 'Convert to OpenID or add another OpenID URL',
fb.'convertsuccess' => 'Successfully converted to OpenID',
fb.'convertsuccesstext' => 'You have successfully converted your OpenID to $1.',
fb.'convertyourstext' => 'That is already your OpenID.',
fb.'convertothertext' => 'That is someone else\'s OpenID.',
*/

	'fbconnect-prefstext' => 'Facebook Connect',
	'fbconnect-link-to-profile' => 'Facebook profile',
	'fbconnect-prefsheader' => "To control which events will push an item to your Facebook News Feed, 
		<a id='fbConnectPushEventBar_show' href='#'>show preferences</a>
		<a id='fbConnectPushEventBar_hide' href='#' style='display:none'>hide preferences</a>",
	'fbconnect-prefs-can-be-updated' => "You can update these any time by visiting the '$1' tab of your Preferences page.",
);

/**
 * Message documentation (Message documentation)
 * What is this used for? Answer: This is shown to translators to help them know what the string is for.
 * @author Garrett Brown
 */
$messages['qqq'] = array(
	'fbconnect-desc' => 'Short description of the FBConnect extension, shown in [[Special:Version]]. Do not translate or change links.',
	'fbconnect-trustinstructions' => '* $1 is a trust root. A trust root looks much like a normal URL, but is used to describe a set of URLs. Trust roots are used by OpenID to verify that a user has approved the OpenID enabled website.',
	'fbconnect-optional' => '{{Identical|Optional}}',
	'fbconnect-email' => '{{Identical|E-mail address}}',
	'fbconnect-language' => '{{Identical|Language}}',
	'fbconnect-timezone' => '{{Identical|Time zone}}',
	'fbconnect-choosepassword' => '{{Identical|Password}}',
	'fbconnect-alreadyloggedin' => '$1 is a user name.',
	'fbconnect-autosubmit' => '{{doc-important|"Continue" will never be localised. It is hardcoded in a PHP extension. Translations could be made like ""Continue" (translation)"}}',
	'fbconnect-delete-button' => '{{Identical|Confirm}}',
	'prefs-fbconnect' => '{{optional}}
OpenID preferences tab title',
	'fbconnect-prefstext' => 'FBConnect preferences tab text above the list of preferences',
	'fbconnect-pref-hide' => 'FBConnect preference label (Hide your FBConnect URL on your user page, if you log in with FBConnect)',
	'fbconnect-pref-update-userinfo-on-login' => 'FBConnect preference label for updating from Facebook account upon login',
	'fbconnect-urls-action' => '{{Identical|Action}}',
	'fbconnect-urls-delete' => '{{identical|Delete}}',
	'fbconnect-link-to-profile' => 'Appears next to the user\s name in their Preferences page and this text is made into link to the profile of that user if they are connected.',
);
/**/
