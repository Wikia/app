<?php
/*
 * To install:
 *    1.  Copy this file to config.php (remove the .sample part).
 *    2.  Follow the instructions below to make the extension work.
 */

$currDir = dirname( __FILE__ ) . '/';
include $currDir.'wikia/fbconnect_customizations.php';

$wgExtensionFunctions[] = 'wikia_fbconnect_init';

// If the user is created or attached, apply their Facebook Profile Pic as their Wikia Avatar (unless they already have one).
$wgHooks['SpecialConnect::createUser::postProcessForm'][] = 'wikia_fbconnect_considerProfilePic';
$wgHooks['SpecialConnect::userAttached'][] = 'wikia_fbconnect_considerProfilePic';

### FBCONNECT CONFIGURATION VARIABLES ###

/**
 * To use Facebook Connect you will first need to get a Facebook API Key:
 *    1.  Visit the Facebook application creation page:
 *        http://www.facebook.com/developers/createapp.php
 *    2.  Enter a descriptive name for your wiki in the Application Name field.
 *        This will be seen by users when they sign up for your site.
 *    3.  Accept the Facebook Terms of Service.
 *    4.  Upload icon and logo images. The icon appears in News Feed stories and the
 *        logo appears in the Connect dialog when the user connects with your application.
 *    5.  Click Submit.
 *    6.  Copy the displayed API key and application secret into this config file.
 */
// NOTE: We will be using the fbApiKey and fbApiSecret inside of Wikia's CommonExtensions.php
//$fbApiKey         = 'YOUR_API_KEY';    # Change this!
//$fbApiSecret      = 'YOUR_SECRET';    # Change this!

/**
 * Disables the creation of new accounts and prevents old accounts from being
 * used to log in if they aren't associated with a Facebook Connect account.
 */
$fbConnectOnly = false;

/**
 * The prefix to be used for the auto-generated username suggestion when the
 * user connects for the first time. A number will be appended onto this prefix
 * to prevent duplicate usernames.
 */
$fbUserName = 'FacebookUser';

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
 * Disabled until the alpha JS SDK supports <fb:photo> tags.
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
 * use_real_name_from_fb  $fbUserName to show the real name for auto-usernames,
 *                        true to show the real name for all Connected users
 *
 * Additionally, use $wgShowIPinHeader to hide the IP and its talk link.
 * For more information, see <http://www.mediawiki.org/wiki/Manual:$wgShowIPinHeader>.
 */
$fbPersonalUrls = array(
	'hide_connect_button'   => false,
	'hide_convert_button'   => true,
	'hide_logout_of_fb'     => false,
	'link_back_to_facebook' => false,
	'remove_user_talk_link' => false,
	'use_real_name_from_fb' => false, # or true or false
);
#$wgShowIPinHeader = false;

/**
 * The Facebook icon. You can copy this image to your server if you want, or
 * set to false to disable.
 */
$fbLogo = 'http://static.ak.fbcdn.net/images/icons/favicon.gif';

/**
 * URL of the Facebook Connect JavaScript SDK. Because this library is currently
 * an alpha release, changes to the APIs may be made on a regular basis. If you
 * use FBConnect on your production website, you may wish to insulate yourself
 * from these changes to the alpha library by downloading and hosting your own
 * copy of the library.
 *
 * For more info, see <http://github.com/facebook/connect-js>.
 */
//$fbScript = 'http://static.ak.fbcdn.net/connect/en_US/core.js';
#global $wgCdnStylePath, $wgStyleVersion;
#$fbScript = "$wgCdnStylePath/extensions/FBConnect/fbsdk_core.js?$wgStyleVersion"; // insulate from changes by hosting locally.  Also, one less dns lookup.

// macbre: fetch FB SDK from facebook's servers
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
$fbScriptByLocale = 'http://connect.facebook.net/'.FBCONNECT_LOCALE.'/all.js';


/**
 * Path to the extension's client-side JavaScript
 */
//$fbExtensionScript = "$wgCdnStylePath/extensions/FBConnect/fbconnect.js"; // only recommended if you are changing this extension.
//$fbExtensionScript = "$wgCdnStylePath/extensions/FBConnect/fbconnect.min.js";
$fbExtensionScript = ''; // this file is in AssetsManager

/**
 * Whether to include jQuery.  If you already have jQuery included on your site, you can
 * safely set this to false.
 */
$fbIncludeJquery = false;

/**
 * Optionally override the default javascript handling which occurs when a user logs in.
 *
 * This will generally not be needed unless you are doing heavy customization of this extension.
 *
 * NOTE: This will be put inside of double-quotes, so any single-quotes should be used inside
 * of any JS in this variable.
 */
$fbOnLoginJsOverride = "sendToConnectOnLogin();";

/**
 * PUSH EVENTS
 *
 * This section allows controlling of whether push events are enabled, and which
 * of the push events to use.
 */
	$wgEnableFacebookConnectPushing = true; // TODO: REMEMBER TO MOVE INTO CommonSettings.php BEFORE RELEASE

global $wgEnableFacebookConnectPushing;
$fbEnablePushToFacebook = (!empty($wgEnableFacebookConnectPushing));
if(!empty($fbEnablePushToFacebook)){
	$fbPushDir = dirname(__FILE__) . '/pushEvents/';

	// Convenience loop for push event classes in the fbPushDir directory
	// whose file-name corresponds to the class-name.  To add a push event
	// which does not meet these criteria, just explicitly add it below.
	$pushEventClassNames = array(
		'FBPush_OnAddBlogPost',
		'FBPush_OnAddImage',
		'FBPush_OnAddVideo',
		'FBPush_OnArticleComment',
		'FBPush_OnBlogComment',
		'FBPush_OnLargeEdit',
		'FBPush_OnWatchArticle',
		'FBPush_OnAchBadge'
	);
	foreach($pushEventClassNames as $pClassName){
		$fbPushEventClasses[] = $pClassName;
		$wgAutoloadClasses[$pClassName] = $fbPushDir . "$pClassName.php";
	}

	// Example of explicitly adding a push event which doesn't meet the criteria above.
	// $fbPushEventClasses[] = 'FBPush_OnEXAMPLE_CLASS';
	// $wgAutoloadClasses['FBPush_OnEXAMPLE_CLASS'] = $fbPushDir . 'FBPush_OnEXAMPLE_version_1.php';
}
