<?php
if ( ! defined( 'MEDIAWIKI' ) )
	die();

/**#@+
 * Provides a way to block an IP Address over multiple wikis sharing a database.
 * Requires
 * @addtogroup Extensions
 *
 * @link http://www.mediawiki.org/wiki/Extension:GlobalBlocking Documentation
 *
 *
 * @author Andrew Garrett <andrew@epstone.net>
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */
$dir = dirname(__FILE__);
$wgExtensionCredits['other'][] = array(
	'name'           => 'GlobalBlocking',
	'author'         => 'Andrew Garrett',
	'svn-date' => '$LastChangedDate: 2008-07-09 18:40:42 +0000 (Wed, 09 Jul 2008) $',
	'svn-revision' => '$LastChangedRevision: 37426 $',
	'description'    => 'Allows IP addresses to be blocked across multiple wikis',
	'descriptionmsg' => 'globalblocking-desc',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:GlobalBlocking',
);

$wgExtensionMessagesFiles['GlobalBlocking'] =  "$dir/GlobalBlocking.i18n.php";
$wgExtensionAliasesFiles['GlobalBlocking'] = "$dir/GlobalBlocking.alias.php";
$wgHooks['getUserPermissionsErrorsExpensive'][] = 'GlobalBlocking::getUserPermissionsErrors';

$wgAutoloadClasses['SpecialGlobalBlock'] = "$dir/SpecialGlobalBlock.php";
$wgSpecialPages['GlobalBlock'] = 'SpecialGlobalBlock';
$wgAutoloadClasses['SpecialGlobalBlockList'] = "$dir/SpecialGlobalBlockList.php";
$wgSpecialPages['GlobalBlockList'] = 'SpecialGlobalBlockList';

## Add global block log
$wgLogTypes[] = 'gblblock';
$wgLogNames['gblblock'] = 'globalblocking-logpage';
$wgLogHeaders['gblblock'] = 'globalblocking-logpagetext';
$wgLogActions['gblblock/gblock'] = 'globalblocking-block-logentry';
$wgLogActions['gblblock/gunblock'] = 'globalblocking-unblock-logentry';
$wgLogActions['gblblock/whitelist'] = 'globalblocking-whitelist-logentry';
$wgLogActions['gblblock/dewhitelist'] = 'globalblocking-dewhitelist-logentry';

## Permissions
$wgGroupPermissions['steward']['globalblock'] = true;
$wgGroupPermissions['steward']['globalunblock'] = true;
$wgGroupPermissions['sysop']['globalblock-whitelist'] = true;
$wgAvailableRights[] = 'globalblock';
$wgAvailableRights[] = 'globalunblock';
$wgAvailableRights[] = 'globalblock-whitelist';

## CONFIGURATION
/**
 * Database name you keep global blocking data in.
 *
 * If this is not on the primary database connection, don't forget
 * to also set up $wgDBservers to have an entry with a groupLoads
 * setting for the 'GlobalBlocking' group.
 */
$wgGlobalBlockingDatabase = 'globalblocking';

/**
 * Whether to respect global blocks on this wiki. This is used so that
 * global blocks can be set one one wiki, but not actually applied there
 * (i.e. so people can contest them on that wiki.
 */
$wgApplyGlobalBlocks = true;

class GlobalBlocking {
	static function getUserPermissionsErrors( &$title, &$user, &$action, &$result ) {
		global $wgApplyGlobalBlocks;
		if ($action == 'read' || !$wgApplyGlobalBlocks) {
			return true;
		}
		
		global $wgUser;
		$dbr = GlobalBlocking::getGlobalBlockingSlave();
		$ip = wfGetIp();
		
		$hex_ip = IP::toHex( $ip );
		
		$ip_pattern = substr( $hex_ip, 0, 4 ) . '%'; // Don't bother checking blocks out of this /16.
	
		$conds = array( 'gb_range_end>='.$dbr->addQuotes($hex_ip), // This block in the given range.
				'gb_range_start<='.$dbr->addQuotes($hex_ip),
				'gb_range_start like ' . $dbr->addQuotes( $ip_pattern ),
				'gb_expiry>'.$dbr->addQuotes($dbr->timestamp(wfTimestampNow())) );
	
		if (!$wgUser->isAnon())
			$conds['gb_anon_only'] = 0;
	
		// Get the block
		if ($block = $dbr->selectRow( 'globalblocks', '*', $conds, __METHOD__ )) {
		
			// Check for local whitelisting
			if (GlobalBlocking::getWhitelistInfo( $block->gb_id ) ) {
				// Block has been whitelisted.
				return true;
			}

			$expiry = Block::formatExpiry( $block->gb_expiry );
	
			wfLoadExtensionMessages( 'GlobalBlocking' );
			
			$display_wiki = self::getWikiName( $block->gb_by_wiki );
			$user_display = self::maybeLinkUserpage( $block->gb_by_wiki, $block->gb_by );
			
			$result[] = array('globalblocking-blocked', $user_display, $display_wiki, $block->gb_reason, $expirystr);
			return false;
		}
	
		return true;
	}
	
	static function getGlobalBlockingMaster() {
		global $wgGlobalBlockingDatabase;
		return wfGetDB( DB_MASTER, 'globalblocking', $wgGlobalBlockingDatabase );
	}
	
	static function getGlobalBlockingSlave() {
		global $wgGlobalBlockingDatabase;
		return wfGetDB( DB_SLAVE, 'globalblocking', $wgGlobalBlockingDatabase );
	}
	
	static function getGlobalBlockId( $ip ) {
		$dbr = GlobalBlocking::getGlobalBlockingSlave();
	
		if (!($row = $dbr->selectRow( 'globalblocks', 'gb_id', array( 'gb_address' => $ip ), __METHOD__ )))
			return 0;
	
		return $row->gb_id;
	}
	
	static function purgeExpired() {
		// This is expensive. It involves opening a connection to a new master,
		// and doing a write query. We should only do it when a connection to the master
		// is already open (currently, when a global block is made).
		$dbw = GlobalBlocking::getGlobalBlockingMaster();
		
		// Stand-alone transaction.
		$dbw->begin();
		$dbw->delete( 'globalblocks', array('gb_expiry<'.$dbw->addQuotes($dbw->timestamp())), __METHOD__ );
		$dbw->commit();
		
		// Purge the global_block_whitelist table.
		// We can't be perfect about this without an expensive check on the master
		// for every single global block. However, we can be clever about it and store
		// the expiry of global blocks in the global_block_whitelist table.
		// That way, most blocks will fall out of the table naturally when they expire.
		$dbw = wfGetDB( DB_MASTER );
		$dbw->begin();
		$dbw->delete( 'global_block_whitelist', array( 'gbw_expiry<'.$dbw->addQuotes($dbw->timestamp())), __METHOD__ );
		$dbw->commit();
	}
	
	static function getWhitelistInfo( $block_id = null, $block_ip = null ) {
		$conds = array();
		if ($block_id != null) {
			$conds = array( 'gbw_id' => $block_id );
		} elseif ($block_ip != null) {
			$block_id = GlobalBlocking::getGlobalBlockId( $block_ip );
			$conds = array( 'gbw_id' => $block_id );
		} else {
			//WTF?
			return false;
		}
		
		$dbr = wfGetDB( DB_SLAVE );
		$row = $dbr->selectRow( 'global_block_whitelist', array( 'gbw_by', 'gbw_reason' ), $conds, __METHOD__ );
		
		if ($row == false) {
			// Not whitelisted.
			return false;
		} else {
			// Block has been whitelisted
			return array( 'user' => $row->gbw_by, 'reason' => $row->gbw_reason );
		}
	}
	
	static function getWikiName( $wiki_id ) {
		if (class_exists('WikiMap')) {
			// We can give more info than just the wiki id!
			$wiki = WikiMap::getWiki( $wiki_id );
			
			return $wiki->getDisplayName();
		}
		
		return $wiki_id;
	}
	
	static function maybeLinkUserpage( $wiki_id, $user ) {
		if (class_exists( 'WikiMap')) {
			$wiki = WikiMap::getWiki( $wiki_id );
			
			return "[".$wiki->getUrl( "User:$user" )." $user]";
		}
		return $user;
	}
}
