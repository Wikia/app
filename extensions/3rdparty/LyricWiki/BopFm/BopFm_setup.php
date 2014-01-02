<?php
/**
 * Bop.fm integration for LyricWiki.
 *
 * Adds Bop.fm to the side-rail.
 *
 * @author Sean Colombo <sean.colombo@gmail.com>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 */

$wgExtensionCredits['other'][] = array(
	'name' => 'bop.fm',
	'author' => array( 'Sean Colombo' ),
	'url' => 'http://bop.fm',
	'descriptionmsg' => 'bopfm-desc',
);

$dir = dirname(__FILE__);

// autoloaded classes
$wgAutoloadClasses['BopFmRailController'] = "$dir/BopFmRailController.class.php";

// i18n
$wgExtensionMessagesFiles['BopFm'] = $dir.'/BopFm.i18n.php';

// hooks
$wgHooks[ 'GetRailModuleList' ][] = 'BopFmRailController::onGetRailModuleList';
