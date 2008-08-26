<?php
if (!defined('MEDIAWIKI')) die();
/**
 * A Special Page extension to rename users, runnable by users with renameuser
 * righs
 *
 * @addtogroup Extensions
 *
 * @author Ævar Arnfjörð Bjarmason <avarab@gmail.com>
 * @copyright Copyright © 2005, Ævar Arnfjörð Bjarmason
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

$wgAvailableRights[] = 'renameuser';
$wgGroupPermissions['bureaucrat']['renameuser'] = true;

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Renameuser',
	'author' => 'Ævar Arnfjörð Bjarmason, Aaron Schulz',
	'url' => 'http://www.mediawiki.org/wiki/Extension:Renameuser',
	'description' => 'Rename a user (need \'\'renameuser\'\' right)',
	'descriptionmsg' => 'renameuser-desc',
	'svn-date' => '$LastChangedDate: 2008-07-09 16:42:18 +0000 (Wed, 09 Jul 2008) $',
	'svn-revision' => '$Rev: 37407 $',
);

# Internationalisation file
$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['Renameuser'] = $dir . 'SpecialRenameuser.i18n.php';
$wgExtensionAliasesFiles['Renameuser'] = $dir . 'SpecialRenameuser.alias.php';

/**
 * The maximum number of edits a user can have and still be allowed renaming,
 * set it to 0 to disable the limit.
 */
define( 'RENAMEUSER_CONTRIBLIMIT', 2000000 );
define( 'RENAMEUSER_CONTRIBJOB', 10000 );

# Add a new log type
global $wgLogTypes, $wgLogNames, $wgLogHeaders, $wgLogActions;
$wgLogTypes[]                          = 'renameuser';
$wgLogNames['renameuser']              = 'renameuserlogpage';
$wgLogHeaders['renameuser']            = 'renameuserlogpagetext';
$wgLogActions['renameuser/renameuser'] = 'renameuserlogentry';

$wgAutoloadClasses['SpecialRenameuser'] = dirname( __FILE__ ) . '/SpecialRenameuser_body.php';
$wgAutoloadClasses['RenameUserJob'] = dirname(__FILE__) . '/RenameUserJob.php';
$wgSpecialPages['Renameuser'] = 'SpecialRenameuser';
$wgSpecialPageGroups['Renameuser'] = 'users';
$wgJobClasses['renameUser'] = 'RenameUserJob';
