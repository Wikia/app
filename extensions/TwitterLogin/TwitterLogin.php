<?php
/**
 * TwitterLogin.php
 * Written by David Raison, based on the guideline published by Dave Challis at http://blogs.ecs.soton.ac.uk/webteam/2010/04/13/254/
 * @license: LGPL (GNU Lesser General Public License) http://www.gnu.org/licenses/lgpl.html
 *
 * @file TwitterLogin.php
 * @ingroup TwitterLogin
 *
 * @author David Raison
 *
 * Uses the twitter oauth library by Abraham Williams from https://github.com/abraham/twitteroauth
 *
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'This is a MediaWiki extension, and must be run from within MediaWiki.' );
}

$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'TwitterLogin',
	'version' => '0.02',
	'author' => array( 'Dave Challis', '[http://www.mediawiki.org/wiki/User:Clausekwis David Raison]' ), 
	'url' => 'https://www.mediawiki.org/wiki/Extension:TwitterLogin',
	'descriptionmsg' => 'twitterlogin-desc'
);

// Create a twiter group
$wgGroupPermissions['twitter'] = $wgGroupPermissions['user'];

$wgAutoloadClasses['SpecialTwitterLogin'] = dirname(__FILE__) . '/SpecialTwitterLogin.php';
$wgAutoloadClasses['TwitterOAuth'] = dirname(__FILE__) . '/twitteroauth/twitteroauth.php';
$wgAutoloadClasses['MwTwitterOAuth'] = dirname(__FILE__) . '/TwitterLogin.twitteroauth.php';
$wgAutoloadClasses['TwitterSigninUI'] = dirname(__FILE__) . '/TwitterLogin.body.php';

$wgExtensionMessagesFiles['TwitterLogin'] = dirname(__FILE__) .'/TwitterLogin.i18n.php';
$wgExtensionAliasFiles['TwitterLogin'] = dirname(__FILE__) .'/TwitterLogin.alias.php';

$wgSpecialPages['TwitterLogin'] = 'SpecialTwitterLogin';
$wgSpecialPageGroups['TwitterLogin'] = 'login';

$wgHooks['LoadExtensionSchemaUpdates'][] = 'efSetupTwitterLoginSchema';

$tsu = new TwitterSigninUI;
$wgHooks['BeforePageDisplay'][] = array( $tsu, 'efAddSigninButton' );

$stl = new SpecialTwitterLogin;
$wgHooks['UserLoadFromSession'][] = array($stl,'efTwitterAuth');
$wgHooks['UserLogoutComplete'][] = array($stl,'efTwitterLogout');

function efSetupTwitterLoginSchema( $updater ) {
	$updater->addExtensionUpdate( array( 'addTable', 'twitter_user',
		dirname(__FILE__) . '/schema/twitter_user.sql', true ) );
	$updater->addExtensionUpdate( array( 'modifyField', 'twitter_user','user_id',
		dirname(__FILE__) . '/schema/twitter_user.patch.user_id.sql', true ) );
	$updater->addExtensionUpdate( array( 'modifyField', 'twitter_user','twitter_id',
		dirname(__FILE__) . '/schema/twitter_user.patch.twitter_id.sql', true ) );
	return true;
}
