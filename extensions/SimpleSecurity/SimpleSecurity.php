<?php
/**
 * SimpleSecurity extension
 * - Extends the MediaWiki article protection to allow restricting viewing of article content
 * - Also adds #ifusercan and #ifgroup parser functions for rendering restriction-based content
 *
 * See http://www.mediawiki.org/Extension:SimpleSecurity for installation and usage details
 * See http://www.organicdesign.co.nz/Extension_talk:SimpleSecurity.php for development notes and disucssion
 *
 * Version 4.0 started Oct 2007 - new version for modern MediaWiki's using DatabaseFetchHook
 * Version 4.1 started Jun 2008 - development funded for a slimmed down functional version
 * Version 4.2 started Aug 2008 - fattened up a bit again - $wgPageRestrictions and security info added in again
 * Version 4.3 started Mar 2009 - bug fixes and split out to separate class and i18n files
 *
 * @package MediaWiki
 * @subpackage Extensions
 * @author Aran Dunkley [http://www.organicdesign.co.nz/nad User:Nad]
 * @copyright © 2007 Aran Dunkley
 * @license GNU General Public Licence 2.0 or later
 */

if ( !defined( 'MEDIAWIKI' ) )                     die( 'Not an entry point.' );
if ( version_compare( $wgVersion, '1.12.0' ) < 0 ) die( 'Sorry, this extension requires at least MediaWiki version 1.12.0' );

define( 'SIMPLESECURITY_VERSION', '4.4.0, 2010-02-13' );

# Load the SimpleSecurity class and messages
$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['SimpleSecurity'] = $dir . 'SimpleSecurity.i18n.php';
$wgAutoloadClasses['SimpleSecurity'] = $dir . 'SimpleSecurity_body.php';

# Global security settings
# TODO: Localize magic words
$wgSecurityMagicIf              = "ifusercan";                  # the name for doing a permission-based conditional
$wgSecurityMagicGroup           = "ifgroup";                    # the name for doing a group-based conditional
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


# Put SimpleSecurity's setup function before all others
array_unshift( $wgExtensionFunctions, 'wfSetupSimpleSecurity' );

$wgHooks['LanguageGetMagic'][] = 'wfSimpleSecurityLanguageGetMagic';
$wgExtensionCredits['parserhook'][] = array(
	'path'        => __FILE__,
	'name'        => "SimpleSecurity",
	'author'      => "[http://www.organicdesign.co.nz/User:Nad User:Nad]",
	'description' => "Extends the MediaWiki article protection to allow restricting viewing of article content",
	'url'         => "http://www.mediawiki.org/wiki/Extension:SimpleSecurity",
	'version'     => SIMPLESECURITY_VERSION,
	'descmsg'     => 'security-desc',

);

# SearchEngine is based on $wgDBtype so must be set before it gets changed to DatabaseSimpleSecurity
# - this may be paranoid now since $wgDBtype is changed back after LoadBalancer has initialised
SimpleSecurity::fixSearchType();

# If the database class already exists, add the DB hook now, otherwise wait until extension setup
if ( !isset( $wgSecurityUseDBHook ) ) $wgSecurityUseDBHook = false;
if ( $wgSecurityUseDBHook && class_exists( 'Database' ) ) wfSimpleSecurityDBHook();

/**
 * Hook into Database::query and Database::fetchObject of database instances
 * - this can't be executed from within a method because PHP doesn't like nested class definitions
 * - it needs an eval because the class statement isn't allowed to contain strings
 * - the hooks aren't called if $wgSimpleSecurity doesn't exist yet
 * - hooks are added in a sub-class of the database type specified in $wgDBtype called DatabaseSimpleSecurity
 * - $wgDBtype is changed so that new DB instances are based on the sub-class
 * - query method is overriden to ensure that old_id field is returned for all queries which read old_text field
 * - only SELECT statements are ever patched
 * - fetchObject method is overridden to validate row content based on old_id
 */
function wfSimpleSecurityDBHook() {
	global $wgDBtype, $wgSecurityUseDBHook, $wgOldDBtype;
	$wgOldDBtype = $wgDBtype;
	$oldClass = ucfirst( $wgDBtype );
	$wgDBtype = 'SimpleSecurity';
	eval( "class Database{$wgDBtype} extends Database{$oldClass}" . ' {
		public function query($sql, $fname = "", $tempIgnore = false) {
			global $wgSimpleSecurity;
			$count = false;
			if (is_object($wgSimpleSecurity))
				$patched = preg_replace_callback("/(?<=SELECT ).+?(?= FROM)/", array("SimpleSecurity", "patchSQL"), $sql, 1, $count);
			return parent::query($count ? $patched : $sql, $fname, $tempIgnore);
		}
		function fetchObject($res) {
			global $wgSimpleSecurity;
			$row = parent::fetchObject($res);
			if (is_object($wgSimpleSecurity) && isset($row->old_text)) $wgSimpleSecurity->validateRow($row);
			return $row;
		}
	}' );
	$wgSecurityUseDBHook = false;
}

/**
 * Register magic words
 */
function wfSimpleSecurityLanguageGetMagic( &$magicWords, $langCode = 0 ) {
	global $wgSecurityMagicIf, $wgSecurityMagicGroup;
	$magicWords[$wgSecurityMagicIf]    = array( $langCode, $wgSecurityMagicIf );
	$magicWords[$wgSecurityMagicGroup] = array( $langCode, $wgSecurityMagicGroup );
	return true;
}

/**
 * Called from $wgExtensionFunctions array when initialising extensions
 */
function wfSetupSimpleSecurity() {
	global $wgSimpleSecurity, $wgLanguageCode, $wgMessageCache, $wgSecurityUseDBHook,  $wgLoadBalancer, $wgDBtype, $wgOldDBtype;

	# Instantiate the SimpleSecurity singleton now that the environment is prepared
	$wgSimpleSecurity = new SimpleSecurity();

	# If the DB hook couldn't be set up early, do it now
	# - but now the LoadBalancer exists and must have its DB types changed
	if ( $wgSecurityUseDBHook ) {
		wfSimpleSecurityDBHook();
		if ( function_exists( 'wfGetLBFactory' ) ) wfGetLBFactory()->forEachLB( array( 'SimpleSecurity', 'updateLB' ) );
		elseif ( is_object( $wgLoadBalancer ) ) SimpleSecurity::updateLB( $wgLoadBalancer );
		else die( "Can't hook in to Database class!" );
	}

	# Request a DB connection to ensure the LoadBalancer is initialised,
	# then change back to old DBtype since it won't be used for making connections again but can affect other operations
	# such as $wgContLang->stripForSearch which is called by SearchMySQL::parseQuery
	wfGetDB( DB_MASTER );
	$wgDBtype = $wgOldDBtype;
}

