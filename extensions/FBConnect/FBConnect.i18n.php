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
 * Not a valid entry pointx, skip unless MEDIAWIKI is defined.
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

/** English */
$messages['en'] = array(
	// Extension name
	'fbconnect'   => 'Facebook Connect',
	'fbconnect-desc'     => 'Enables users to [[Special:Connect|Connect]] with their [http://www.facebook.com Facebook] accounts. Offers authentification based on Facebook groups and the use of FBML in wiki text.',
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
	// Personal toolbar
	'fbconnect-connect'  => 'Log in with Facebook Connect',
	'fbconnect-connect-simple'  => 'Connect',
	'fbconnect-convert'  => 'Connect this account with Facebook',
	'fbconnect-logout'   => 'Logout of Facebook',
	'fbconnect-link'     => 'Back to facebook.com',
	'fbconnect-or'       => 'OR',

// Special:Connect
	'fbconnect-title'    => 'Connect account with Facebook',
	'fbconnect-intro'    => 'This wiki is enabled with Facebook Connect, the next evolution of Facebook Platform. This means that when you are Connected, in addition to the normal [[Wikipedia:Help:Logging in#Why log in?|benefits]] you see when logging in, you will be able to take advantage of some extra features...',
	'fbconnect-click-to-login' => 'Click this button to login to this site via facebook',
	'fbconnect-click-to-connect-existing' => 'Click this button to connect your facebook account to $1',
	'fbconnect-conv'     => 'Convenience',
	'fbconnect-convdesc' => 'Connected users are automatically logged you in. If permission is given, then this wiki can even use Facebook as an email proxy so you can continue to receive important notifications without revealing your email address.',
	'fbconnect-fbml'     => 'Facebook Markup Language',
	'fbconnect-fbmldesc' => 'Facebook has provided a bunch of built-in tags that will render dynamic data. Many of these tags can be included in wiki text, and will be rendered differently depending on which Connected user they are being viewed by.',
	'fbconnect-comm'     => 'Communication',
	'fbconnect-commdesc' => 'Facebook Connect ushers in a whole new level of networking. See which of your friends are using the wiki, and optionally share your actions with your friends through the Facebook News Feed.',
	'fbconnect-welcome'  => 'Welcome, Facebook Connect user!',
	'fbconnect-loginbox' => "Or '''login''' with Facebook:\n\n$1",
	'fbconnect-merge'    => 'Merge your wiki account with your Facebook ID',
	'fbconnect-logoutbox'=> "$1\n\nThis will also log you out of Facebook and all Connected sites, including this wiki.",
	'fbconnect-listusers-header'
              => '$1 and $2 privileges are automatically transfered from the Officer and Admin titles of the Facebook group $3.\n\nFor more info, please contact the group creator $4.',
// Prefix to use for automatically-generated usernames
	'fbconnect-usernameprefix' => 'FacebookUser',
// Special:Connect
	'fbconnect-error' => 'Verification error',
	'fbconnect-errortext' => 'Yikes! It looks like that didn\'t work out. Please try again.',
	'fbconnect-cancel' => 'Action cancelled',
	'fbconnect-canceltext' => 'The previous action was cancelled by the user.',
	'fbconnect-invalid' => 'Invalid option',
	'fbconnect-invalidtext' => 'The selection made on the previous page was invalid.',
	'fbconnect-success' => 'Facebook verification succeeded',
	'fbconnect-successtext' => 'You have been successfully logged in with Facebook Connect.',
	'fbconnect-success-connecting-existing-account' => 'Your facebook account has been connected. To change which events get pushed to your facebook news feed, please visit your <a href="$1">preferences</a> page.',
#	'fbconnect-optional' => 'Optional',
#	'fbconnect-required' => 'Required',
	'fbconnect-nickname' => 'Nickname',
	'fbconnect-fullname' => 'Fullname',
	'fbconnect-email' => 'E-mail address',
	'fbconnect-language' => 'Language',
	'fbconnect-timecorrection' => 'Time zone correction (hours)',
	'fbconnect-chooselegend' => 'Username choice',
	'fbconnect-chooseinstructions' => 'All users need a nickname; you can choose one from the options below.',
	'fbconnect-invalidname' => 'The nickname you chose is already taken or not a valid nickname. Please chose a different one.',
	'fbconnect-choosenick' => 'Your Facebook profile name ($1)',
	'fbconnect-choosefirst' => 'Your first name ($1)',
	'fbconnect-choosefull' => 'Your full name ($1)',
	'fbconnect-chooseauto' => 'An auto-generated name ($1)',
	'fbconnect-choosemanual' => 'A name of your choice:',
	'fbconnect-chooseexisting' => 'An existing account on this wiki',
	'fbconnect-chooseusername' => 'Username:',
	'fbconnect-choosepassword' => 'Password:',
	'fbconnect-updateuserinfo' => 'Update the following personal information:',
	'fbconnect-alreadyloggedin-title' => 'Already connected',
	'fbconnect-alreadyloggedin' => "'''You are already logged in and facebook-connected, $1!'''",
	'fbconnect-logged-in-now-connect' => "You have been logged in to your account, please click the login button to connect it with Facebook.",
	'fbconnect-logged-in-now-connect-title' =>  "Almost done!",
	'fbconnect-modal-title' => 'Finish your account setup',
    'fbconnect-modal-headmsg' => 'Almost done!',

	'fbconnect-error-creating-user' => "Error creating the user in the local database.",
	'fbconnect-error-user-creation-hook-aborted' => "A hook (extension) aborted the account creation with the message: $1",

	'fbconnect-prefstext' => 'Facebook Connect',
	'fbconnect-link-to-profile' => 'Facebook profile',
	'fbconnect-prefsheader' => "By default, some events will push items to your Facebook feed. You can customise these now, or later at any time in your preferences.",
	'fbconnect-prefs-show' => "Show feed preferences >>",
    'fbconnect-prefs-hide' => "Hide feed preferences >>",
	'fbconnect-prefs-post' => 'Post to my Facebook News Feed when I:',
    'fbconnect-connect-msg' => "Congratulations! Your Wikia and Facebook accounts are now connected. <br/> Check your <a href='$1'>preferences</a> to control which events appear in Facebook feed.",
    'fbconnect-connect-error-msg' => "We're sorry, we couldn't complete your connection without permission to post to your Facebook account. After setup you have [[w:c:help:Help:Facebook_Connect#Sharing_with_your_Facebook_activity_feed|full control]] of what's posted to your news feed. Please try again.",

	'fbconnect-disconnect-link' => "You can also <a id='fbConnectDisconnect' href='#'> disconnect your Wikia account from Facebook.</a> You will able continue using your Wikia account as normal, with your history (edits, points, achievements ) intact.",
	'fbconnect-disconnect-done' => "Disconnecting <span id='fbConnectDisconnectDone'>... done! </span>",
	'fbconnect-disconnect-info' => "We have emailed a new password to use with your account - you can log in with the same username as before. Hooray!",
	'tog-fbconnect-push-allow-never' => "Never send anything to my news feed (overrides other options)",
	'fbconnect-reclamation-title' => 'Disconnecting from Facebook',
	'fbconnect-reclamation-body' => 'Your account is now disconnected from Facebook! <br/><br/>  We have emailed a new password to use with you account - you can log in with the same username as before. Hooray!
											<br/><br/> To login go to: $1',
    'fbconnect-reclamation-title-error' => 'Disconnecting from Facebook',
	'fbconnect-reclamation-body-error' => 'There was some error during disconnecting from Facebook or you account is already disconnected. 
											<br/><br/> To login go to: $1',
    'fbconnect-unknown-error' => 'Unknown error, try again or contact with us.',          
	'fbconnect-passwordremindertitle'      	=> 'Your Wikia account is now disconnected from Facebook!',
    'fbconnect-passwordremindertitle-exist' => 'Your Wikia account is now disconnected from Facebook!',
	'fbconnect-passwordremindertext'       => 'Hi,
It looks like you\'ve just disconnected your Wikia account from Facebook. We\'ve kept all of your history, edit points and achievements intact, so don\'t worry!

You can use the same username as before, and we\'ve generated a new password for you to use. Here are your details:

Username: $2
Password: $3

The replacement password has been sent only to you at this email address.

Thanks,

The Wikia Community Team',
	'fbconnect-passwordremindertext-exist'	=> 'Hi,
It looks like you\'ve just disconnected your Wikia account from Facebook. We\'ve kept all of your history, edit points and achievements intact, so don\'t worry!

You can use the same username and password as you did before you connected.

Thanks,

The Wikia Community Team',

	'fbconnect-msg-for-existing-users' => "<p>Already a Wikia user?</p><br/><br/>If you would like to connect this facebook account to an existing Wikia account, please <a class='loginAndConnect' href='$1'>login</a> first.",
	
	'fbconnect-invalid-email' => "Please provide a valid email address.",
	'fbconnect-wikia-login-w-facebook' => 'Log in / Sign Up with Facebook Connect',
	'fbconnect-wikia-login-or-create' => 'Log in / Create an account',
	'fbconnect-wikia-login-bullets' => '<ul><li>Sign up in just a few clicks</li><li>You have control of what goes to your feed</li></ul>',
	
	'fbconnect-fbid-is-already-connected-title' => 'Facebook account is already in use',
	'fbconnect-fbid-is-already-connected' => 'The Facebook account you are attempting to connect to your Wikia account is already connected to a different Wikia account. If you would like to connect your current Wikia account to that Facebook id, please disconnect the Facebook account from your other username first by visiting the "Facebook Connect" tab of your Preferences page.',
	'fbconnect-fbid-connected-to' => 'The Wikia username that is currently connected to this Facebook id is <strong>$1</strong>.',
    'fbconnect-connect-next' => 'Next >>' ,
);

/**
 * Message documentation (Message documentation)
 * What is this used for? Answer: This is shown to translators to help them know what the string is for.
 * @author Garrett Brown
 */
$messages['qqq'] = array(
	'fbconnect-desc' => 'Short description of the FBConnect extension, shown in [[Special:Version]]. Do not translate or change links.',
	'fbconnect-listusers-header' => '$1 is the name of the Bureaucrat group, $2 is the name of the Sysop group.',
	'fbconnect-or' => 'This is just the word "OR" in English, used to separate the Facebook Connect login option from the normal Wikia login options on the ajaxed login dialog box.',
	'fbconnect-optional' => '{{Identical|Optional}}',
	'fbconnect-email' => '{{Identical|E-mail address}}',
	'fbconnect-language' => '{{Identical|Language}}',
	'fbconnect-timezone' => '{{Identical|Time zone}}',
	'fbconnect-choosepassword' => '{{Identical|Password}}',
	'fbconnect-alreadyloggedin' => '$1 is a user name.',
	'fbconnect-logged-in-now-connect' => 'This message is shown in a modal dialog along with an fbconnect button when the user is trying to login and connect. This is a workaround for popup blockers.',
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
	'fbconnect-msg-for-existing-users' => 'This is displayed next to the username field in the choose-name form.  If a user comes to the site and facebook connects,
										   the purpose of this message is to let them know how to procede if they are actually trying to connect their facebook account
										   to an existing account.',
	'fbconnect-connect-next' => 'This text appears on the button in the login-and-connect dialog.  After a user enters their username/password, this will slide them over to the next screen which is the Facebook Connect button.'
);
/**/

/*
	'fbconnect-convertinstructions' => 'This form lets you change your user account to use an OpenID URL or add more OpenID URLs',
	'fbconnect-convertoraddmoreids' => 'Convert to OpenID or add another OpenID URL',
	'fbconnect-convertsuccess' => 'Successfully converted to OpenID',
	'fbconnect-convertsuccesstext' => 'You have successfully converted your OpenID to $1.',
	'fbconnect-convertyourstext' => 'That is already your OpenID.',
	'fbconnect-convertothertext' => 'That is someone else\'s OpenID.',
*/
