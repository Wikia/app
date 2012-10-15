<?php
/*
 * To install:
 *    1.  Copy this file to config.php (remove the .sample part).
 *    2.  Follow the instructions below to make the extension work.
 */


### FBCONNECT CONFIGURATION VARIABLES ###

/**
 * To use Facebook Connect you will first need to create a Facebook application:
 *    1.  Visit the "Create an Application" setup wizard:
 *        http://developers.facebook.com/setup/
 *    2.  Enter a descriptive name for your wiki in the Site Name field.
 *        This will be seen by users when they sign up for your site.
 *    3.  Enter the Site URL and Locale, then click "Create application".
 *    4.  Copy the displayed App ID and Secret into this config file.
 * 
 * Optionally, you may customize your application:
 *    A.  Click "developer dashboard" link on the previous screen or visit:
 *        http://www.facebook.com/developers/apps.php
 *    B.  Select your application and click "Edit Settings".
 *    C.  Upload icon and logo images. The icon appears in Stream stories.
 *    D.  In the "Connect" section, set your Connect Logo and base domain
 *        (which should also be copied into this config file).
 */
$fbAppId          = 'YOUR_APP_ID';    # Change this!
$fbSecret         = 'YOUR_SECRET';    # Change this!
#$fbDomain         = 'BASE_DOMAIN';    # Optional

/**
 * Disables the creation of new accounts and prevents old accounts from being
 * used to log in if they aren't associated with a Facebook Connect account.
 */
$fbConnectOnly = false;

/**
 * Allow the use of XFBML in wiki text.
 * For more info, see http://wiki.developers.facebook.com/index.php/XFBML.
 */
$fbUseMarkup = true;

/**
 * If XFBML is enabled, then <fb:photo> maybe be used as a replacement for
 * $wgAllowExternalImages with the added benefit that all photos are screened
 * against Facebook's Code of Conduct <http://www.facebook.com/codeofconduct.php>
 * and subject to dynamic privacy. To disable just <fb:photo> tags, set this to false.
 * 
 * Disabled until the JavaScript SDK supports <fb:photo> tags.
 */
#$fbAllowFacebookImages = true;

/**
 * For easier wiki rights management, create a group on Facebook and place the
 * group ID here. Three new implicit groups will be created:
 * 
 *     fb-groupie    A member of the specified group
 *     fb-officer    A group member with an officer title
 *     fb-admin      An administrator of the Facebook group
 * 
 * By default, they map to User, Bureaucrat and Sysop privileges, respectively.
 * Users will automatically be promoted or demoted when their membership, title
 * or admin status is modified from the group page within Facebook.
 */
$fbUserRightsFromGroup = false;  # Or a group ID

// Not used (yet...)
#$fbRestrictToGroup = true;
#$fbRestrictToNotReplied = false;

/**
 * Options regarding the personal toolbar (in the upper right).
 * 
 * == Key ==              == Effect ==
 * hide_connect_button    Hides the "Log in with Facebook Connect" button.
 * hide_convert_button    Hides "Connect this account with Facebook" for non-
 *                        Connected users.
 * hide_logout_of_fb      Hides the "logout of facebook" button and leaves only
 *                        the button to log out of the current MediaWiki.
 * link_back_to_facebook  Shows a handy "Back to facebook.com" link for Connected
 *                        users. This helps enforce the idea that this wiki is
 *                        "in front" of Facebook.
 * remove_user_talk_link  Remove link to user's talk page
 * use_real_name_from_fb  Show the real name for all Connected users
 * 
 * Additionally, use $wgShowIPinHeader to hide the IP and its talk link.
 * For more information, see <http://www.mediawiki.org/wiki/Manual:$wgShowIPinHeader>.
 */
$fbPersonalUrls = array(
	'hide_connect_button'   => false,
	'hide_convert_button'   => false,
	'hide_logout_of_fb'     => false,
	'link_back_to_facebook' => true,
	'remove_user_talk_link' => false,
	'use_real_name_from_fb' => false,
);
#$wgShowIPinHeader = false;

/**
 * The Facebook icon. You can copy this image to your server if you want, or
 * set to false to disable.
 */
$fbLogo = 'http://static.ak.fbcdn.net/images/icons/favicon.gif';

/**
 * URL of the Facebook Connect JavaScript SDK. Because this library is currently
 * a beta release, changes to the APIs may be made on a regular basis. If you
 * use FBConnect on your production website, you may wish to insulate yourself
 * from these changes by downloading and hosting your own copy of the library.
 * 
 * For more info, see <http://developers.facebook.com/docs/reference/javascript/>
 */
$fbScript = 'http://connect.facebook.net/en_US/all.js';

/**
 * If this is set to true, and the user's language is anything other than fbScriptLangCode, then
 * the fbScriptByLocale URL will be used to load the correspondingly-localized version of the
 * Facebook JS SDK.
 */
$fbScriptEnableLocales = true;

/**
 * The MEDIAWIKI language code which corresponds to the file in $fbScript.  If the user
 * is in a language other than fbScriptLangCode, then the fbScriptByLocale will be used
 * if fbScriptEnableLocales is set to true.
 */
$fbScriptLangCode = 'en';

/**
 * If fbScriptEnableLocales is true and the user's language is anything except for the
 * fbScriptLangCode, we assume that instead of using the file in fbScript (which is quite likely a
 * locally-cached version of the JS SDK), that we should instead take the risk and use the
 * Facebook-hosted version for the corresponding language.
 *
 * NOTE: URL should include "%LOCALE%" which will be replaced with the correct Facebook Locale based
 * on the user's configured language.
 *
 * WARNING: It is highly-unlikely that you'll need to change this fallback-URL. If you're not sure that
 * you need to change it, it's best to leave it alone.
 */
$fbScriptByLocale = 'http://connect.facebook.net/%LOCALE%/all.js';

/**
 * Path to the extension's client-side JavaScript
 */
global $wgScriptPath;
#$fbExtensionScript = "$wgScriptPath/extensions/FBConnect/fbconnect.js"; // for development
$fbExtensionScript = "$wgScriptPath/extensions/FBConnect/fbconnect.min.js";

/**
 * Whether to include jQuery. This option is for backwards compatibility and is
 * ignored in version 1.16. Otherwise, if you already have jQuery included on
 * your site, you can safely set this to false.
 */
$fbIncludeJquery = true;

/**
 * Optionally override the default javascript handling which occurs when a user logs in.
 *
 * This will generally not be needed unless you are doing heavy customization of this extension.
 *
 * NOTE: This will be put inside of double-quotes, so any single-quotes should be used inside
 * of any JS in this variable.
 */
//$fbOnLoginJsOverride = "sendToConnectOnLogin();";

/**
 * Optionally turn off the inclusion of the PreferencesExtension.  Since this
 * is an extension that you may already have installed in your instance of
 * MediaWiki, there is the option to turn off FBConnect's inclusion of it (which
 * will require you to already have PreferencesExtension enabled elsewhere).
 *
 * When running on MediaWiki v1.16 and above, the extension won't be included anyway.
 */
$fbIncludePreferencesExtension = true;

/**
 * An array of extended permissions to request from the user while they are
 * signing up.
 *
 * NOTE: If fbEnablePushToFacebook is true, then publish_stream will automatically be
 * added to this array.
 *
 * For more details see: http://developers.facebook.com/docs/authentication/permissions
 */
$fbExtendedPermissions = array(
	//'publish_stream',
	//'read_stream',
	//'email',
	//'read_mailbox',
	//'offline_access',
	//'create_event',
	//'rsvp_event',
	//'sms',
	//'xmpp_login',
);

/**
 * PUSH EVENTS
 *
 * This section allows controlling of whether push events are enabled, and which
 * of the push events to use.
 */
$fbEnablePushToFacebook = false;
if(!empty($fbEnablePushToFacebook)){
	$fbPushDir = dirname(__FILE__) . '/pushEvents/';
	
	// Convenience loop for push event classes in the fbPushDir directory
	// whose file-name corresponds to the class-name.  To add a push event
	// which does not meet these criteria, just explicitly add it below.
	$pushEventClassNames = array(
		'FBPush_OnAddImage',
		'FBPush_OnLargeEdit',
		'FBPush_OnWatchArticle',
	);
	foreach($pushEventClassNames as $pClassName){
		$fbPushEventClasses[] = $pClassName;
		$wgAutoloadClasses[$pClassName] = $fbPushDir . "$pClassName.php";
	}

	// Example of explicitly adding a push event which doesn't meet the criteria above.
	// $fbPushEventClasses[] = 'FBPush_OnEXAMPLE_CLASS';
	// $wgAutoloadClasses['FBPush_OnEXAMPLE_CLASS'] = $fbPushDir . 'FBPush_OnEXAMPLE_version_1.php';
}
