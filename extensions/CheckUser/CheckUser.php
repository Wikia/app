<?php
/**
 * CheckUser extension - grants users with the appropriate permission the
 * ability to check user's IP addresses and other information.
 *
 * @file
 * @ingroup Extensions
 * @version 2.3
 * @author Tim Starling
 * @author Aaron Schulz
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @link http://www.mediawiki.org/wiki/Extension:CheckUser Documentation
 */

# Not a valid entry point, skip unless MEDIAWIKI is defined
if ( !defined( 'MEDIAWIKI' ) ) {
	echo "CheckUser extension";
	exit( 1 );
}

# Internationalisation files
$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['CheckUser'] = $dir . 'CheckUser.i18n.php';
$wgExtensionMessagesFiles['CheckUserAliases'] = $dir . 'CheckUser.alias.php';

// Extension credits that will show up on Special:Version
$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'author' => array( 'Tim Starling', 'Aaron Schulz' ),
	'name' => 'CheckUser',
	'version' => '2.3',
	'url' => 'https://www.mediawiki.org/wiki/Extension:CheckUser',
	'descriptionmsg' => 'checkuser-desc',
);

// Legacy variable, no longer used. Used to point to a file in the server where
// CheckUser would log all queries done through Special:CheckUser.
// If this file exists, the installer will try to import data from this file to
// the 'cu_log' table in the database.
$wgCheckUserLog = '/home/wikipedia/logs/checkuser.log';

# How long to keep CU data?
$wgCUDMaxAge = 3 * 30 * 24 * 3600; // 3 months

# Mass block limits
$wgCheckUserMaxBlocks = 200;

// Set this to true if you want to force checkusers into giving a reason for
// each check they do through Special:CheckUser.
$wgCheckUserForceSummary = false;

# Recent changes data hook
$wgHooks['RecentChange_save'][] = 'CheckUserHooks::updateCheckUserData';
$wgHooks['EmailUser'][] = 'CheckUserHooks::updateCUEmailData';
$wgHooks['User::mailPasswordInternal'][] = 'CheckUserHooks::updateCUPasswordResetData';
$wgHooks['AuthPluginAutoCreate'][] = 'CheckUserHooks::onAuthPluginAutoCreate';
$wgHooks['AddNewAccount'][] = 'CheckUserHooks::onAddNewAccount';
$wgHooks['LoggableUserIPData'][] = 'CheckUserHooks::onLoggableUserIPData';

# Occasional pruning of CU data
$wgHooks['ArticleEditUpdatesDeleteFromRecentchanges'][] = 'CheckUserHooks::maybePruneIPData';

$wgHooks['ParserTestTables'][] = 'CheckUserHooks::checkUserParserTestTables';
$wgHooks['LoadExtensionSchemaUpdates'][] = 'CheckUserHooks::checkUserSchemaUpdates';
$wgHooks['ContributionsToolLinks'][] = 'CheckUserHooks::loadCheckUserLink';

# Take over autoblocking
$wgHooks['PerformRetroactiveAutoblock'][] = 'CheckUserHooks::doRetroactiveAutoblock';

# Register tables that need to be updated when a user is renamed
$wgHooks['UserRename::Local'][] = 'CheckUserHooks::onUserRenameLocal';

$wgResourceModules['ext.checkUser'] = array(
	'scripts'       => 'checkuser.js',
	'dependencies' 	=> array( 'mediawiki.util' ), // IP stuff
	'localBasePath' => dirname( __FILE__ ),
	'remoteExtPath' => 'CheckUser',
);

// Set up the new special page
$wgSpecialPages['CheckUser'] = 'CheckUser';
$wgSpecialPageGroups['CheckUser'] = 'users';
$wgSpecialPages['CheckUserLog'] = 'SpecialCheckUserLog';
$wgSpecialPageGroups['CheckUserLog'] = 'changes';

$wgAutoloadClasses['CheckUser'] = $dir . '/CheckUser_body.php';
$wgAutoloadClasses['CheckUserHooks'] = $dir . '/CheckUser.hooks.php';
$wgAutoloadClasses['CheckUserLogPager'] = $dir . '/CheckUserLogPager.php';
$wgAutoloadClasses['SpecialCheckUserLog'] = $dir . '/SpecialCheckUserLog.php';

// API modules
$wgAutoloadClasses['ApiQueryCheckUser'] = "$dir/api/ApiQueryCheckUser.php";
$wgAPIListModules['checkuser'] = 'ApiQueryCheckUser';
$wgAutoloadClasses['ApiQueryCheckUserLog'] = "$dir/api/ApiQueryCheckUserLog.php";
$wgAPIListModules['checkuserlog'] = 'ApiQueryCheckUserLog';
