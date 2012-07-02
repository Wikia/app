<?php
/**
 * This extension provides Special:ProtectSite, which makes it possible for
 * users with protectsite permissions to quickly lock down and restore various
 * privileges for anonymous and registered users on a wiki.
 *
 * Knobs:
 * 'protectsite' - Group permission to use the special page.
 * $wgProtectSiteLimit - Maximum time allowed for protection of the site.
 * $wgProtectSiteDefaultTimeout - Default protection time.
 * $wgProtectSiteExempt - Array of non-sysop usergroups to be not effected by rights changes
 *
 * @file
 * @ingroup Extensions
 * @version 0.3.4
 * @author Eric Johnston <e.wolfie@gmail.com>
 * @author Chris Stafford <c.stafford@gmail.com>
 * @author Jack Phoenix <jack@countervandalism.net>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

/**
 * Protect against register_globals vulnerabilities.
 * This line must be present before any global variable is referenced.
 */
if ( !defined( 'MEDIAWIKI' ) ) {
	die( "This is not a valid entry point.\n" );
}

/* Extension Credits. Splarka wants me to be so UN:VAIN! Haet haet hat! */
$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'Protect Site',
	'version' => '0.3.4',
	'author' => array( '[http://uncyclopedia.org/wiki/User:Dawg Eric Johnston]', 'Chris Stafford', 'Jack Phoenix' ),
	'descriptionmsg' => 'protectsite-desc',
	'url' => 'https://www.mediawiki.org/wiki/Extension:ProtectSite',
);

# Configuration settings
// Array of non-sysop user groups to be not effected by rights changes
$wgProtectSiteExempt = array();

/* Set the default timeout. */
$wgProtectsiteDefaultTimeout = '1 hour';

// Maximum time allowed for protection of the site
$wgProtectSiteLimit = '1 week';

/* Register the new user rights level */
$wgAvailableRights[] = 'protectsite';

/* Set the group access permissions */
$wgGroupPermissions['bureaucrat']['protectsite'] = true;

/* Add this special page to the special page listing array */
$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['ProtectSite'] = $dir . 'ProtectSite.i18n.php';
$wgExtensionMessagesFiles['ProtectSiteAliases'] = $dir . 'ProtectSite.alias.php';
$wgAutoloadClasses['ProtectSite'] = $dir . 'ProtectSite.body.php';
$wgSpecialPages['ProtectSite'] = 'ProtectSite';

/* Register initialization function */
$wgExtensionFunctions[] = 'wfSetupProtectsite';

/**
 * Persistent data is unserialized from a record in the objectcache table
 * which is set in the Special page. It will change the permissions for
 * various functions for anonymous and registered users based on the data
 * in the array. The data expires after the set amount of time, just like
 * a block.
 */
function wfSetupProtectsite() {
	/* Globals */
	global $wgGroupPermissions, $wgMemc, $wgProtectSiteExempt, $wgCommandLineMode;

	// macbre: don't run code below when running in command line mode (memcache starts to act strange)
	if ( !empty( $wgCommandLineMode ) ) {
		return;
	}

	/* Initialize Object */
	$persist_data = new SqlBagOStuff( array() );

	/* Get data into the prot hash */
	$prot = $wgMemc->get( wfMemcKey( 'protectsite' ) );
	if( !$prot ) {
		$prot = $persist_data->get( 'protectsite' );
		if( !$prot ) {
			$wgMemc->set( wfMemcKey( 'protectsite' ), 'disabled' );
		}
	}

	/* Logic to disable the selected user rights */
	if( is_array( $prot ) ) {
		/* MW doesn't timeout correctly, this handles it */
		if( time() >= $prot['until'] ) {
			$persist_data->delete( 'protectsite' );
		}

		/* Protection-related code for MediaWiki 1.8+ */
		$wgGroupPermissions['*']['createaccount'] = !( $prot['createaccount'] >= 1 );
		$wgGroupPermissions['user']['createaccount'] = !( $prot['createaccount'] == 2 );

		$wgGroupPermissions['*']['createpage'] = !( $prot['createpage'] >= 1 );
		$wgGroupPermissions['*']['createtalk'] = !( $prot['createpage'] >= 1 );
		$wgGroupPermissions['user']['createpage'] = !( $prot['createpage'] == 2 );
		$wgGroupPermissions['user']['createtalk'] = !( $prot['createpage'] == 2 );

		$wgGroupPermissions['*']['edit'] = !( $prot['edit'] >= 1 );
		$wgGroupPermissions['user']['edit'] = !( $prot['edit'] == 2 );
		$wgGroupPermissions['sysop']['edit'] = true;

		$wgGroupPermissions['user']['move'] = !( $prot['move'] == 1 );
		$wgGroupPermissions['user']['upload'] = !( $prot['upload'] == 1 );
		$wgGroupPermissions['user']['reupload'] = !( $prot['upload'] == 1 );
		$wgGroupPermissions['user']['reupload-shared'] = !( $prot['upload'] == 1 );

		// are there any groups that should not get affected by ProtectSite's lockdown?
		if( !empty( $wgProtectSiteExempt ) && is_array( $wgProtectSiteExempt ) ) {
			// there are, so loop over them, and force these rights to be true
			// will resolve any problems from inheriting rights from 'user' or 'sysop'
			foreach( $wgProtectSiteExempt as $exemptGroup ) {
				$wgGroupPermissions[$exemptGroup]['edit'] = 1;
				$wgGroupPermissions[$exemptGroup]['createpage'] = 1;
				$wgGroupPermissions[$exemptGroup]['createtalk'] = 1;
				$wgGroupPermissions[$exemptGroup]['move'] = 1;
				$wgGroupPermissions[$exemptGroup]['upload'] = 1;
				$wgGroupPermissions[$exemptGroup]['reupload'] = 1;
				$wgGroupPermissions[$exemptGroup]['reupload-shared'] = 1;
			}
		}
	}
}
