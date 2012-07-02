<?php
if( !defined( 'MEDIAWIKI' ) ) die( 'Not an entry point.' );
if( version_compare( $wgVersion, '1.17.0' ) < 0 ) die( 'This version of SimpleSecurity is for MediaWiki 1.17 or greater, please install SimpleSecurity 4.x which can be found at http://svn.organicdesign.co.nz/listing.php?repname=extensions' );
/**
 * SimpleSecurity extension
 * - Extends the MediaWiki article protection to allow restricting viewing of article content
 * - Also adds #ifusercan and #ifgroup parser functions for rendering restriction-based content
 *
 * See http://www.mediawiki.org/Extension:SimpleSecurity for installation and usage details
 * See http://www.organicdesign.co.nz/Extension:SimpleSecurity.php for development notes and disucssion
 *
 * Version 4.0 - Oct 2007 - new version for MediaWiki 1.12+ using DatabaseFetchHook
 * Version 4.1 - Jun 2008 - development funded for a slimmed down functional version
 * Version 4.2 - Aug 2008 - fattened up a bit again - $wgPageRestrictions and security info added in again
 * Version 4.3 - Mar 2009 - bug fixes and split out to separate class and i18n files
 * Version 4.5 - Sep 2010 - File security started again - by Josh Adams
 * Version 5.0 - Jun 2011 - major changes to the DB hooking method to handle changes in MediaWiki 1.17
 *
 * @file
 * @ingroup Extensions
 * @author Aran Dunkley [http://www.organicdesign.co.nz/nad User:Nad]
 * @copyright © 2007-2011 Aran Dunkley
 * @license GNU General Public Licence 2.0 or later
 */
define( 'SIMPLESECURITY_VERSION', '5.1.0, 2012-01-19' );

# Load the SimpleSecurity class and messages
$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['SimpleSecurity'] = $dir . 'SimpleSecurity.i18n.php';
$wgExtensionMessagesFiles['SimpleSecurityMagic'] = $dir . 'SimpleSecurity.i18n.magic.php';
$wgAutoloadClasses['SimpleSecurity'] = $dir . 'SimpleSecurity_body.php';

# Global security settings
$wgSecurityLogActions           = array( 'edit', 'download' );  # Actions that should be logged
$wgSecurityAllowUser            = false;                        # Allow restrictions based on user not just group
$wgSecurityAllowUnreadableLinks = false;                        # Should links to unreadable pages be allowed? (MW1.7+)
$wgSecurityRenderInfo           = true;                         # Renders security information for proctected articles
$wgEnableParserCache            = false;                        # Currently the extension fails if caching enabled

# Extra actions to allow control over in protection form
$wgSecurityExtraActions  = array( 'read' => 'Read' );

# Extra groups available in protection form
$wgSecurityExtraGroups   = array();

# Alternatively, the extra groups can be defined in an article
$wgSecurityGroupsArticle = false;

# Extra group permissions rules
$wgPageRestrictions = array();

# Enable this if you use the RecordAdmin extension and want Record template's
# protection to apply to all instances of that record type
$wgSecurityProtectRecords = true;

# Don't use the DB hook by default since it's voodoo
if( !isset( $wgSecurityUseDBHook ) ) $wgSecurityUseDBHook = false;

$wgExtensionCredits['parserhook'][] = array(
	'path'        => __FILE__,
	'name'        => "SimpleSecurity",
	'author'      => "[http://www.organicdesign.co.nz/User:Nad User:Nad]",
	'url'         => "http://www.mediawiki.org/wiki/Extension:SimpleSecurity",
	'version'     => SIMPLESECURITY_VERSION,
	'descriptionmsg' => 'security-desc',
);
$wgHooks['MessagesPreLoad'][] = 'wfSimpleSecurityMessagesPreLoad';

# Instantiate the SimpleSecurity singleton now that the environment is prepared
$wgSimpleSecurity = new SimpleSecurity();

# If using the DBHook, apply it now (must be done from the root scope since it creates classes)
if( $wgSecurityUseDBHook ) SimpleSecurity::applyDatabaseHook();

function wfSimpleSecurityMessagesPreLoad( $title, &$text ) {
	global $wgSecurityExtraActions, $wgSecurityExtraGroups;

	if( substr( $title, 0, 12 ) == 'Restriction-' ) {
		$key = substr( $title, 12 );
		if( isset( $wgSecurityExtraActions[$key] ) ) {
			$text = empty( $wgSecurityExtraActions[$key] ) ? ucfirst( $key ) : $wgSecurityExtraActions[$key];
		}
		return true;
	} elseif( substr( $title, 0, 14 ) == 'Protect-level-' ) {
		$key = substr( $title, 14 );
		$type = 'level';
	} elseif( substr( $title, 0, 6 ) == 'Right-' ) {
		$key = substr( $title, 6 );
		$type = 'right';
	} else {
		return true;
	}

	if( isset( $wgSecurityExtraGroups[$key] ) ) {
		$name = empty( $wgSecurityExtraGroups[$key] ) ? ucfirst( $key ) : $wgSecurityExtraGroups[$key];	
	} else {
		$lower = array_map( 'strtolower', $wgSecurityExtraGroups );
		$nkey = array_search( strtolower( $key ), $lower, true );
		if( !is_numeric( $nkey ) ) {
			return true;
		}
		$name = ucfirst( $wgSecurityExtraGroups[$nkey] );
	}

	if( $type == 'level' ) {
		$text = $name;
	} else {
		$text = wfMsg( 'security-restricttogroup', $name );
	}

	return true;
}


