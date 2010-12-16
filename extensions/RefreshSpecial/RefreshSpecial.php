<?php
/**
 * A special page providing means to manually refresh special pages
 *
 * @file
 * @ingroup Extensions
 * @version 1.2.1
 * @author Bartek Łapiński <bartek@wikia-inc.com>
 * @author Jack Phoenix <jack@countervandalism.net>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @link http://www.mediawiki.org/wiki/Extension:RefreshSpecial Documentation
 */

if( !defined( 'MEDIAWIKI' ) ){
	die( "This is not a valid entry point.\n" );
}

// Extension credits that will be shown on Special:Version
$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'Refresh Special',
	'author' => array( 'Bartek Łapiński', 'Jack Phoenix' ),
	'version' => '1.2.1',
	'url' => 'http://www.mediawiki.org/wiki/Extension:RefreshSpecial',
	'description' => 'Allows manual special page refresh of special pages',
	'descriptionmsg' => 'refreshspecial-desc',
);

// New user right, required to use Special:RefreshSpecial
$wgAvailableRights[] = 'refreshspecial';
$wgGroupPermissions['bureaucrat']['refreshspecial'] = true;

// Set up the new special page
$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['RefreshSpecial'] = $dir . 'RefreshSpecial.i18n.php';
$wgExtensionAliasesFiles['RefreshSpecial'] = $dir . 'RefreshSpecial.alias.php';
$wgAutoloadClasses['RefreshSpecial'] = $dir. 'RefreshSpecial.body.php';
$wgSpecialPages['RefreshSpecial'] = 'RefreshSpecial';
$wgSpecialPageGroups['RefreshSpecial'] = 'wiki';

/* limits the number of refreshed rows */
define('REFRESHSPECIAL_ROW_LIMIT', 1000);
/* interval between reconnects */
define('REFRESHSPECIAL_RECONNECTION_SLEEP', 10);
/* amount of acceptable slave lag  */
define('REFRESHSPECIAL_SLAVE_LAG_LIMIT', 600);
/* interval when slave is lagged */
define('REFRESHSPECIAL_SLAVE_LAG_SLEEP', 30);
