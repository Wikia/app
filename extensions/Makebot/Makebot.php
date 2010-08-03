<?php

/**
 * Special page to allow local bureaucrats to grant/revoke the bot flag
 * for a particular user
 *
 * @addtogroup Extensions
 * @author Rob Church <robchur@gmail.com>
 * @copyright © 2006 Rob Church
 * @license GNU General Public Licence 2.0 or later
 */

if( defined( 'MEDIAWIKI' ) ) {

	define( 'MW_MAKEBOT_GRANT', 1 );
	define( 'MW_MAKEBOT_REVOKE', 2 );

	$wgAvailableRights[] = 'makebot';
	$wgExtensionCredits['specialpage'][] = array(
		'name'           => 'MakeBot',
		'author'         => 'Rob Church',
		'url'            => 'http://www.mediawiki.org/wiki/Extension:MakeBot',
		'description'    => 'Special page allows local bureaucrats to grant and revoke bot permissions',
		'descriptionmsg' => 'makebot-desc',
		'svn-date' => '$LastChangedDate: 2008-11-30 04:15:22 +0100 (ndz, 30 lis 2008) $',
		'svn-revision' => '$LastChangedRevision: 44056 $',
	 );

	/**
	 * Load internationalization file
	 */
	$dir = dirname(__FILE__) . '/';
	$wgExtensionMessagesFiles['Makebot'] = $dir . 'Makebot.i18n.php';	
	$wgExtensionAliasesFiles['Makebot'] = $dir . 'Makebot.alias.php';

	/**
	 * Determines who can use the extension; as a default, bureaucrats are permitted
	 */
	$wgGroupPermissions['bureaucrat']['makebot'] = true;

	/**
	 * Toggles whether or not a bot flag can be given to a user who is also a sysop or bureaucrat
	 */
	$wgMakeBotPrivileged = false;

	/**
	 * Register the special page
	 */
	$wgAutoloadClasses['Makebot'] = dirname( __FILE__ ) . '/Makebot.class.php';
	$wgSpecialPages['Makebot'] = 'Makebot';
	$wgSpecialPageGroups['Makebot'] = 'users';

	/**
	 * Set up the auditing
	 */
	$wgLogTypes[] = 'makebot';
	$wgLogNames['makebot'] = 'makebot-logpage';
	$wgLogHeaders['makebot'] = 'makebot-logpagetext';
	$wgLogActions['makebot/grant']  = 'makebot-logentrygrant';
	$wgLogActions['makebot/revoke'] = 'makebot-logentryrevoke';

} else {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
	exit( 1 );
}
