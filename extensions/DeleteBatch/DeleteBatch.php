<?php
/**
 * DeleteBatch - a special page to delete a batch of pages
 *
 * @file
 * @ingroup Extensions
 * @author Bartek Łapiński <bartek@wikia-inc.com>
 * @version 1.1
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @link http://www.mediawiki.org/wiki/Extension:DeleteBatch Documentation
 */
if ( !defined( 'MEDIAWIKI' ) )
	die();

// Extension credits that will show up on Special:version
$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'Delete Batch',
	'version' => '1.3',
	'author' => 'Bartek Łapiński',
	'url' => 'http://www.mediawiki.org/wiki/Extension:DeleteBatch',
	'description' => 'Deletes a batch of pages',
	'descriptionmsg' => 'deletebatch-desc',
);

// New user right, required to use Special:DeleteBatch
$wgAvailableRights[] = 'deletebatch';
$wgGroupPermissions['bureaucrat']['deletebatch'] = true;

// Set up the new special page
$dir = dirname( __FILE__ ) . '/';
$wgExtensionMessagesFiles['DeleteBatch'] = $dir . 'DeleteBatch.i18n.php';
$wgExtensionAliasesFiles['DeleteBatch'] = $dir . 'DeleteBatch.alias.php';
$wgAutoloadClasses['DeleteBatch'] = $dir . 'DeleteBatch.body.php';
$wgSpecialPages['DeleteBatch'] = 'DeleteBatch';
// Special page group for MW 1.13+
$wgSpecialPageGroups['DeleteBatch'] = 'pagetools';
