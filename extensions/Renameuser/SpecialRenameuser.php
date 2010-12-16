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
	'path' => __FILE__,
	'name' => 'Renameuser',
	'author'         => array( 'Ævar Arnfjörð Bjarmason', 'Aaron Schulz' ),
	'url'            => 'http://www.mediawiki.org/wiki/Extension:Renameuser',
	'description'    => 'Rename a user (need \'\'renameuser\'\' right)',
	'descriptionmsg' => 'renameuser-desc',
);

# Internationalisation file
$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['Renameuser'] = $dir . 'SpecialRenameuser.i18n.php';
$wgExtensionAliasesFiles['Renameuser'] = $dir . 'SpecialRenameuser.alias.php';

/**
 * The maximum number of edits a user can have and still be allowed renaming,
 * set it to 0 to disable the limit.
 */
define( 'RENAMEUSER_CONTRIBLIMIT', 1000000 );
define( 'RENAMEUSER_CONTRIBJOB', 5000 );

# Add a new log type
global $wgLogTypes, $wgLogNames, $wgLogHeaders, $wgLogActions;
$wgLogTypes[]                          = 'renameuser';
$wgLogNames['renameuser']              = 'renameuserlogpage';
$wgLogHeaders['renameuser']            = 'renameuserlogpagetext';
#$wgLogActions['renameuser/renameuser'] = 'renameuserlogentry';
$wgLogActionsHandlers['renameuser/renameuser'] = 'wfRenameUserLogActionText'; // deal with old breakage

function wfRenameUserLogActionText( $type, $action, $title = null, $skin = null, $params = array(), $filterWikilinks=false ) {
	if( !$title || $title->getNamespace() !== NS_USER ) {
		$rv = ''; // handled in comment, the old way
	} else {
		$titleLink = $skin ?
			$skin->makeLinkObj( $title, htmlspecialchars( $title->getPrefixedText() ) ) : $title->getText();
		# Add title to params
		array_unshift( $params, $titleLink );
		$rv = wfMsgReal( 'renameuserlogentry', $params );
	}
	return $rv;
}

$wgAutoloadClasses['SpecialRenameuser'] = dirname( __FILE__ ) . '/SpecialRenameuser_body.php';
$wgAutoloadClasses['RenameUserJob'] = dirname(__FILE__) . '/RenameUserJob.php';
$wgSpecialPages['Renameuser'] = 'SpecialRenameuser';
$wgSpecialPageGroups['Renameuser'] = 'users';
$wgJobClasses['renameUser'] = 'RenameUserJob';

$wgHooks['ShowMissingArticle'][] = 'wfRenameUserShowLog';

function wfRenameUserShowLog( $article ) {
	global $wgOut;
	$title = $article->getTitle();
	if ( $title->getNamespace() == NS_USER || $title->getNamespace() == NS_USER_TALK ) {
		// Get the title for the base userpage
		$page = Title::makeTitle( NS_USER, str_replace( ' ', '_', $title->getBaseText() ) )->getPrefixedDBkey();
		LogEventsList::showLogExtract( $wgOut, 'renameuser', $page, '', array( 'lim' => 10, 'showIfEmpty' => false, 
			'msgKey' => array( 'renameuser-renamed-notice', $title->getBaseText() ) ) );
	}
	return true;
}
