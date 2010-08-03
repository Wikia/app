<?php
/*
 * Copyright (C) 2008 Victor Vasiliev <vasilvv@gmail.com>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 * MA 02110-1301, USA.
 */

if ( !defined( 'MEDIAWIKI' ) )
	die();

$wgExtensionCredits['other'][] = array(
	'name'           => 'CloseWikis',
	'author'         => 'Victor Vasiliev',
	'svn-date'       => '$LastChangedDate: 2008-10-25 22:23:17 +0200 (sob, 25 paź 2008) $',
	'svn-revision'   => '$LastChangedRevision: 42571 $',
	'description'    => 'Allows to close wiki sites',
	'descriptionmsg' => 'closewikis-desc',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:CloseWikis',
);

$dir = dirname( __FILE__ );
$wgExtensionMessagesFiles['CloseWikis'] =  "$dir/CloseWikis.i18n.php";
$wgExtensionAliasesFiles['CloseWikis'] = "$dir/CloseWikis.alias.php";
$wgHooks['getUserPermissionsErrors'][] = "CloseWikisHooks::userCan";

$wgGroupPermissions['steward']['closewikis'] = true;
$wgAvailableRights[] = 'closewikis';
// To be promoted globally
$wgAvailableRights[] = 'editclosedwikis';

$wgAutoloadClasses['SpecialCloseWiki'] = "$dir/CloseWikis.page.php";
$wgAutoloadClasses['SpecialListClosedWikis'] = "$dir/CloseWikis.list.php";
$wgSpecialPages['CloseWiki'] = 'SpecialCloseWiki';
$wgSpecialPages['ListClosedWikis'] = 'SpecialListClosedWikis';

$wgCloseWikisDatabase = 'closedwikis';

$wgLogTypes[]                     = 'closewiki';
$wgLogNames['closewiki']          = 'closewikis-log';
$wgLogHeaders['closewiki']        = 'closewikis-log-header';
$wgLogActions['closewiki/close']  = 'closewikis-log-close';
$wgLogActions['closewiki/reopen'] = 'closewikis-log-reopen';

class CloseWikisRow {
	private $mRow;

	public function __construct( $row ) {
		$this->mRow = $row;
	}

	public function isClosed() {
		return (bool)$this->mRow;
	}

	public function getWiki() {
		return $this->mRow ? $this->mRow->cw_wiki : null;
	}

	public function getReason() {
		return $this->mRow ? $this->mRow->cw_reason : null;
	}

	public function getTimestamp() {
		return $this->mRow ? wfTimestamp( TS_MW, $this->mRow->cw_timestamp ) : null;
	}

	public function getBy() {
		return $this->mRow ? $this->mRow->cw_by : null;
	}
}

class CloseWikis {
	static $cachedList = null;

	static function getSlaveDB() {
		global $wgCloseWikisDatabase;
		return wfGetDB( DB_SLAVE, 'closewikis', $wgCloseWikisDatabase );
	}

	static function getMasterDB() {
		global $wgCloseWikisDatabase;
		return wfGetDB( DB_MASTER, 'closewikis', $wgCloseWikisDatabase );
	}

	/** Returns list of all closed wikis in form of CloseWikisRow array. Not cached */
	static function getAll() {
		$list = array();
		$dbr = self::getSlaveDB();
		$result = $dbr->select( 'closedwikis', '*', false, __METHOD__ );
		foreach( $result as $row ) {
			$list[] = new CloseWikisRow( $row );
		}
		$dbr->freeResult( $result );
		return $list;
	}

	/** Returns list of closed wikis in form of string array. Cached in CloseWikis::$cachedList */
	static function getList() {
		if( self::$cachedList )
			return self::$cachedList;
		$list = array();
		$dbr = self::getMasterDB();	// Used only on writes
		$result = $dbr->select( 'closedwikis', 'cw_wiki', false, __METHOD__ );
		foreach( $result as $row ) {
			$list[] = $row->cw_wiki;
		}
		$dbr->freeResult( $result );
		self::$cachedList = $list;
		return $list;
	}

	/** Returns list of unclosed wikis in form of string array. Based on getList() */
	static function getUnclosedList() {
		global $wgLocalDatabases;
		return array_diff( $wgLocalDatabases, self::getList() );
	}

	/** Returns a CloseWikisRow for specific wiki. Cached in $wgMemc */
	static function getClosedRow( $wiki ) {
		global $wgMemc;
		$memcKey = "closedwikis:{$wiki}";
		$cached = $wgMemc->get( $memcKey );
		if( is_object( $cached ) )
			return $cached;
		$dbr = self::getSlaveDB();
		$result = new CloseWikisRow( $dbr->selectRow( 'closedwikis', '*', array( 'cw_wiki' => $wiki ), __METHOD__ ) );
		$wgMemc->set( $memcKey, $result );
		return $result;
	}

	/** Closes a wiki */
	static function close( $wiki, $dispreason, $by ) {
		global $wgMemc;
		$dbw = CloseWikis::getMasterDB();
		$dbw->begin();
		$dbw->insert(
			'closedwikis',
			array(
				'cw_wiki' => $wiki,
				'cw_reason' => $dispreason,
				'cw_timestamp' => $dbw->timestamp( wfTimestampNow() ),
				'cw_by' => $by->getName(),
			),
			__METHOD__,
			array( 'IGNORE' )	// Better error handling
		);
		$result = (bool)$dbw->affectedRows();
		$dbw->commit();
		$wgMemc->delete( "closedwikis:{$wiki}" );
		self::$cachedList = null;
		return $result;
	}

	/** Reopens a wiki */
	static function reopen( $wiki ) {
		global $wgMemc;
		$dbw = self::getMasterDB();
		$dbw->begin();
		$dbw->delete(
			'closedwikis',
			array( 'cw_wiki' => $wiki ),
			__METHOD__
		);
		$result = (bool)$dbw->affectedRows();
		$dbw->commit();
		$wgMemc->delete( "closedwikis:{$wiki}" );
		self::$cachedList = null;
		return $result;
	}
}

class CloseWikisHooks {
	static function userCan( &$title, &$user, $action, &$result ) {
		static $closed = null;
		global $wgLang;
		if( $action == 'read' )
			return true;
		if( is_null( $closed ) )
			$closed = CloseWikis::getClosedRow( wfWikiID() );
		if( $closed->isClosed() && !$user->isAllowed( 'editclosedwikis' ) ) {
			wfLoadExtensionMessages( 'CloseWikis' );
			$reason = $closed->getReason();
			$ts = $closed->getTimestamp();	
			$by = $closed->getBy();
			$result[] =	array( 'closewikis-closed', $reason, $by,
				$wgLang->timeanddate( $ts ), $wgLang->time( $ts ), $wgLang->date( $ts ) );
			return false;
		}
		return true;
	}
}
