<?php
/**
 * This file provides the access to the MediaWiki SQL database tables that are
 * used by the NotifyMe extension.
 *
 * @author ning
 *
 */
if ( !defined( 'MEDIAWIKI' ) ) die;
global $smwgNMIP;
require_once $smwgNMIP . '/includes/SMW_NMDBHelper.php';

/**
 * This class encapsulates all methods that care about the database tables of
 * the NotifyMe extension.
 *
 */
class NMStorageSQL {

	public function setup( $verbose ) {

		$db = wfGetDB( DB_MASTER );

		SNMDBHelper::reportProgress( "Setting up NotifyMe database ...\n", $verbose );

		extract( $db->tableNames( 'smw_nm_monitor', 'smw_nm_query', 'smw_nm_relations', 'smw_nm_rss' ) );

		// page_id, monitored page id
		SNMDBHelper::setupTable( $smw_nm_monitor, array(
			'notify_id' => 'INT(8) UNSIGNED NOT NULL',
			'page_id'   => 'INT(8) UNSIGNED NOT NULL' ), $db, $verbose );
		SNMDBHelper::setupIndex( $smw_nm_monitor, array( 'page_id' ), $db );
		SNMDBHelper::setupTable( $smw_nm_query, array(
			'notify_id' => 'INT(8) UNSIGNED NOT NULL KEY AUTO_INCREMENT',
			'user_id'   => 'INT(8) UNSIGNED NOT NULL',
			'delegate'  => 'BLOB',
			'name'      => 'VARCHAR(255) binary NOT NULL',
			'rep_all'   => 'TINYINT(1) NOT NULL default \'1\'',
			'show_all'  => 'TINYINT(1) NOT NULL default \'0\'',
			'query'     => 'BLOB NOT NULL',
			'nm_sql'    => 'BLOB',
			'nm_hierarchy' => 'BLOB',
			'enable'    => 'TINYINT(1) NOT NULL default \'0\'' ), $db, $verbose );
		SNMDBHelper::setupIndex( $smw_nm_query, array( 'user_id' ), $db );
		// page_id, related page / property id in notify query
		SNMDBHelper::setupTable( $smw_nm_relations, array(
			'notify_id'	=> 'INT(8) UNSIGNED NOT NULL',
			'smw_id'    => 'INT(8) UNSIGNED NOT NULL',
		// 0 category, 1 instance, 2 property
			'type'      => 'INT(8) UNSIGNED NOT NULL',
			'subquery'  => 'INT(8) UNSIGNED NOT NULL default \'0\'' ), $db, $verbose );
		SNMDBHelper::setupIndex( $smw_nm_relations, array( 'smw_id', 'notify_id' ), $db );
		SNMDBHelper::setupTable( $smw_nm_rss, array(
			'msg_id'    => 'INT(8) UNSIGNED NOT NULL KEY AUTO_INCREMENT',
			'mailed'    => 'TINYINT(1) NOT NULL default \'0\'',
			'user_id'   => 'INT(8) UNSIGNED',
			'notify_id' => 'INT(8) UNSIGNED',
			'title'     => 'VARCHAR(255) binary NOT NULL',
			'link'      => 'BLOB',
			'notify'    => 'BLOB NOT NULL',
			'timestamp' => 'VARCHAR(14) binary NOT NULL' ), $db, $verbose );
		SNMDBHelper::setupIndex( $smw_nm_rss, array( 'user_id' ), $db );

		SNMDBHelper::reportProgress( "... done!\n", $verbose );

	}

	public function addNotifyQuery( $user_id, $querystring, $name, $rep_all, $show_all, $delegate ) {
		$fname = 'NotifyMe::addNotifyQuery';
		wfProfileIn( $fname );

		$dbw = wfGetDB( DB_MASTER );
		$notify_id = $dbw->nextSequenceValue( 'nmquery_notify_id_seq' );
		if ( $dbw->insert( 'smw_nm_query', array(
					'notify_id' => $notify_id,
					'user_id' => $user_id,
					'query' => $querystring,
					'name' => $name,
					'rep_all' => $rep_all,
					'show_all' => $show_all,
					'delegate' => $delegate ), $fname ) )
		{
			$notify_id = $dbw->insertId();
		} else {
			$notify_id = 0;
		}
		wfProfileOut( $fname );
		return $notify_id;
	}
	public function removeNotifyQuery( $notify_ids ) {
		$fname = 'NotifyMe::delNotify';
		wfProfileIn( $fname );
		$db = wfGetDB( DB_MASTER );
		$db->delete( $db->tableName( 'smw_nm_monitor' ), array( 'notify_id' => $notify_ids ), $fname );
		$db->delete( $db->tableName( 'smw_nm_relations' ), array( 'notify_id' => $notify_ids ), $fname );
		$db->delete( $db->tableName( 'smw_nm_query' ), array( 'notify_id' => $notify_ids ), $fname );
		wfProfileOut( $fname );
		return true;
	}
	public function addNotifyMonitor( $add_monitor ) {
		$fname = 'NotifyMe::addNotifyMonitor';
		wfProfileIn( $fname );

		$db = wfGetDB( DB_MASTER );
		$res = $db->insert( 'smw_nm_monitor', $add_monitor, $fname );
		wfProfileOut( $fname );
		return $res;
	}
	public function removeNotifyMonitor( $remove_monitored ) {
		$fname = 'NotifyMe::addNotifyMonitor';
		wfProfileIn( $fname );

		$db = wfGetDB( DB_MASTER );
		foreach ( $remove_monitored as $monitor ) {
			$db->delete( $db->tableName( 'smw_nm_monitor' ), array( 'notify_id' => $monitor['notify_id'], 'page_id' => $monitor['page_id'] ), $fname );
		}
		wfProfileOut( $fname );
		return $res;
	}
	public function addNotifyRelations( $notify_id, $rels, $subquery = 0 ) {
		$fname = 'NotifyMe::addNotifyRelations';
		wfProfileIn( $fname );

		foreach ( $rels as $i => $vi ) {
			foreach ( $rels as $j => $vj ) {
				if ( $i != $j && $vi['namespace'] == $vj['namespace'] && $vi['title'] == $vj['title'] ) {
					unset( $rels[$i] );
					break;
				}
			}
		}

		$dbw = wfGetDB( DB_MASTER );
		$relations = array();
		$new_rel = false;
		foreach ( $rels as $smw ) {
			$res = $dbw->select( $dbw->tableName( 'smw_ids' ),
					'smw_id',
			// array( 'smw_namespace' => $smw['namespace'], 'smw_title' => $smw['title']),
					'smw_namespace=' . $smw['namespace'] . ' AND smw_title=' . $dbw->addQuotes( $smw['title'] ),
					'NotifyMe::getRelatedSmwId' );
			$rel_smw_id = 0;
			if ( $dbw->numRows( $res ) > 0 ) {
				$rel_smw_id = $dbw->fetchObject( $res )->smw_id;
				$dbw->freeResult( $res );
			} else {
				$dbw->freeResult( $res );
				return false;
			}

			if ( $rel_smw_id > 0 ) {
				$new_rel = true;
				$relations[] = array(
					'notify_id' => $notify_id,
					'smw_id'	=> $rel_smw_id,
				// $type: 0 category, 1 instance, 2 property
					'type'	  => ( ( $smw['namespace'] == NS_CATEGORY ) ? 0:( ( $smw['namespace'] == SMW_NS_PROPERTY ) ? 2:1 ) ),
					'subquery'  => $subquery );
			}
		}
		if ( $new_rel ) {
			$dbw->insert( 'smw_nm_relations', $relations, $fname );
		}
		wfProfileOut( $fname );
		return true;
	}
	public function getNotifications( $user_id ) {
		$fname = 'NotifyMe::getNotifications';
		wfProfileIn( $fname );

		$result = array();

		$db = wfGetDB( DB_SLAVE );
		$res = $db->select( $db->tableName( 'smw_nm_query' ),
		array( 'notify_id', 'delegate', 'name', 'query', 'enable', 'rep_all', 'show_all' ),
		array( 'user_id' => $user_id ), $fname, array( 'ORDER BY' => 'notify_id' ) );
		if ( $db->numRows( $res ) > 0 ) {
			while ( $row = $db->fetchObject( $res ) ) {
				$result[] = array( 'notify_id' => $row->notify_id,
					'delegate' => $row->delegate,
					'name' => $row->name,
					'query' => $row->query,
					'enable' => $row->enable,
					'rep_all' => $row->rep_all,
					'show_all' => $row->show_all );
			}
		}
		$db->freeResult( $res );
		wfProfileOut( $fname );
		return $result;
	}
	public function getNotifyMe( $notify_ids ) {
		$fname = 'NotifyMe::getNotifyMe';
		wfProfileIn( $fname );

		$result = array();

		$db = wfGetDB( DB_SLAVE );
		$res = $db->select( $db->tableName( 'smw_nm_query' ),
		array( 'notify_id', 'name', 'query', 'show_all' ),
		array( 'notify_id' => $notify_ids ), $fname );
		if ( $db->numRows( $res ) > 0 ) {
			while ( $row = $db->fetchObject( $res ) ) {
				$result[$row->notify_id] = array( 'query' => $row->query,
					'name' => $row->name,
					'show_all' => $row->show_all );
			}
		}
		$db->freeResult( $res );
		wfProfileOut( $fname );
		return $result;
	}
	public function getAllNotifications() {
		$fname = 'NotifyMe::getAllNotifications';
		wfProfileIn( $fname );

		$result = array();

		$db = wfGetDB( DB_SLAVE );
		$res = $db->select( $db->tableName( 'smw_nm_query' ),
		array( 'notify_id', 'delegate', 'name', 'query', 'enable', 'rep_all', 'show_all' ), '',
		$fname, array( 'ORDER BY' => 'notify_id' ) );
		if ( $db->numRows( $res ) > 0 ) {
			while ( $row = $db->fetchObject( $res ) ) {
				$result[] = array( 'notify_id' => $row->notify_id,
					'delegate' => $row->delegate,
					'name' => $row->name,
					'query' => $row->query,
					'enable' => $row->enable,
					'rep_all' => $row->rep_all,
					'show_all' => $row->show_all );
			}
		}
		$db->freeResult( $res );
		wfProfileOut( $fname );
		return $result;
	}
	public function cleanUp() {
		$fname = 'NotifyMe::cleanUp';
		wfProfileIn( $fname );
		$db = wfGetDB( DB_MASTER );
		$db->delete( $db->tableName( 'smw_nm_monitor' ), '*', $fname );
		$db->delete( $db->tableName( 'smw_nm_relations' ), '*', $fname );
		wfProfileOut( $fname );
	}
	public function disableNotifyState( $notify_id ) {
		$fname = 'NotifyMe::disableState';
		wfProfileIn( $fname );
		$db = wfGetDB( DB_MASTER );
		$db->delete( $db->tableName( 'smw_nm_monitor' ), array( 'notify_id' => $notify_id ), $fname );
		$db->delete( $db->tableName( 'smw_nm_relations' ), array( 'notify_id' => $notify_id ), $fname );

		$this->updateNotifyState( $notify_id, 0 );
		wfProfileOut( $fname );
		return true;
	}
	public function updateNotifyState( $notify_id, $state ) {
		$fname = 'NotifyMe::updateNotifyState';
		wfProfileIn( $fname );

		$dbw = wfGetDB( DB_MASTER );
		$dbw->update( 'smw_nm_query', array( 'enable' => $state ), array( 'notify_id' => $notify_id ), $fname );
		wfProfileOut( $fname );
		return true;
	}
	public function updateDelegate( $notify_id, $delegate ) {
		$fname = 'NotifyMe::updateDelegate';
		wfProfileIn( $fname );
		$dbw = wfGetDB( DB_MASTER );
		$dbw->update( 'smw_nm_query', array( 'delegate' => $delegate ), array( 'notify_id' => $notify_id ), $fname );
		wfProfileOut( $fname );
		return true;
	}
	public function updateNotifyReportAll( $notify_id, $rep_all ) {
		$fname = 'NotifyMe::updateNotifyReportAll';
		wfProfileIn( $fname );

		$dbw = wfGetDB( DB_MASTER );
		$dbw->update( 'smw_nm_query', array( 'rep_all' => $rep_all ), array( 'notify_id' => $notify_id ), $fname );
		wfProfileOut( $fname );
		return true;
	}
	public function updateNotifyShowAll( $notify_id, $show_all ) {
		$fname = 'NotifyMe::updateNotifyShowAll';
		wfProfileIn( $fname );

		$dbw = wfGetDB( DB_MASTER );
		$dbw->update( 'smw_nm_query', array( 'show_all' => $show_all ), array( 'notify_id' => $notify_id ), $fname );
		wfProfileOut( $fname );
		return true;
	}

	public function lookupSmwId( $namespace, $title ) {
		$fname = 'NotifyMe::lookupSmwId';
		wfProfileIn( $fname );

		$result = 0;
		$db = wfGetDB( DB_SLAVE );
		$res = $db->selectRow( 'smw_ids', 'smw_id', array( 'smw_namespace' => $namespace, 'smw_title' => $title ), $fname );

		if ( $res ) $result = $res->smw_id;
		wfProfileOut( $fname );
		return $result;
	}
	public function getMonitoredNotifications( $page_id ) {
		$fname = 'NotifyMe::getMonitoredNotifications';
		wfProfileIn( $fname );

		$result = array();

		$db = wfGetDB( DB_SLAVE );

		$res = $db->select( array( $db->tableName( 'smw_nm_query' ) . ' q', $db->tableName( 'smw_nm_monitor' ) . ' m' ),
		array( 'q.user_id', 'q.notify_id', 'q.delegate', 'q.name', 'q.rep_all' ),
				'm.page_id=' . $page_id . ' and m.notify_id=q.notify_id', $fname );
		if ( $db->numRows( $res ) > 0 ) {
			while ( $row = $db->fetchObject( $res ) ) {
				$ds = explode( ',', $row->delegate );
				$delegated = false;
				foreach ( $ds as $delegate ) {
					$u = User::newFromName( trim( $delegate ) );
					if ( $u == null ) continue;
					$id = $u->getId();
					if ( $id > 0 ) {
						$result[$id][$row->notify_id] = array( 'name' => $row->name, 'rep_all' => $row->rep_all );
						$delegated = true;
					}
				}
				if ( !$delegated ) {
					$result[$row->user_id][$row->notify_id] = array( 'name' => $row->name, 'rep_all' => $row->rep_all );
				}
			}
		}
		$db->freeResult( $res );

		wfProfileOut( $fname );
		return $result;
	}
	public function getMonitoredNotificationsDetail( $page_id ) {
		$fname = 'NotifyMe::getMonitoredNotificationsDetail';
		wfProfileIn( $fname );

		$result = array();

		$notifies = $this->getMonitoredNotifications( $page_id );

		$db = wfGetDB( DB_SLAVE );

		foreach ( $notifies as $user_id => $notify ) {
			foreach ( $notify as $notify_id => $notify_detail ) {
				if ( $notify_detail['rep_all'] == 1 ) {
					$result[$user_id]['rep_all'][$notify_id] = $notify_detail['name'];
				} else {
					$res = $db->select( $db->tableName( 'smw_nm_relations' ), array( 'smw_id', 'type' ), "notify_id=$notify_id AND subquery=0", $fname );
					if ( $db->numRows( $res ) > 0 ) {
						while ( $row = $db->fetchObject( $res ) ) {
							$result[$user_id]['semantic'][SMWNotifyProcessor::toInfoId( $row->type, 0, $row->smw_id )][$notify_id] = $notify_detail['name'];
						}
					}
					$db->freeResult( $res );
				}
			}
		}

		wfProfileOut( $fname );
		return $result;
	}
	public function getPossibleQuery( $info ) {
		$cnt = count( $info );
		if ( $cnt == 0 ) {
			return null;
		}
		$fname = 'NotifyMe::getPossibleQuery';
		wfProfileIn( $fname );

		$first = true;
		foreach ( $info as $key => $value ) {
			if ( $first ) {
				$first = false;
			} else {
				$cond .= "OR ";
			}
			$i = SMWNotifyProcessor::getInfoFromId( $key );
			$cond .= "(smw_id=$i[attr_id] AND type=$i[type]) ";
		}

		$db = wfGetDB( DB_SLAVE );
		$result = array( 0 => array(), 1 => array() );
		extract( $db->tableNames( 'smw_nm_query', 'smw_nm_relations' ) );
		$res = $db->query( "SELECT q.notify_id, q.name, q.user_id, q.delegate, q.nm_sql, q.nm_hierarchy, c1.subquery FROM (" .
			"SELECT count(*) cnt, notify_id, subquery FROM $smw_nm_relations " .
					"WHERE $cond GROUP BY notify_id, subquery" .
			") c1 INNER JOIN (" .
				"SELECT count(*) cnt, notify_id, subquery FROM $smw_nm_relations " .
					"WHERE type<>1 GROUP BY notify_id, subquery" .
			") c2 ON c1.notify_id=c2.notify_id AND c1.subquery=c2.subquery AND c1.cnt=c2.cnt " .
			"LEFT JOIN $smw_nm_query q ON q.notify_id = c1.notify_id WHERE c1.cnt<=$cnt", $fname );
		if ( $db->numRows( $res ) > 0 ) {
			while ( $row = $db->fetchObject( $res ) ) {
				$ds = explode( ',', $row->delegate );
				$uids = array();
				foreach ( $ds as $delegate ) {
					$u = User::newFromName( trim( $delegate ) );
					if ( $u == null ) continue;
					$id = $u->getId();
					if ( $id > 0 ) {
						$uids[] = $id;
					}
				}
				if ( count( $uids ) == 0 ) {
					$uids[] = $row->user_id;
				}
				$result[$row->subquery > 0 ? 1:0][$row->notify_id] = array( 'user_ids' => $uids, 'name' => $row->name, 'sql' => $row->nm_sql, 'hierarchy' => $row->nm_hierarchy );
			}
		}
		$db->freeResult( $res );
		wfProfileOut( $fname );
		return $result;
	}
	public function getMonitoredQuery( $page_id ) {
		$fname = 'NotifyMe::getMonitoredQuery';
		wfProfileIn( $fname );

		$result = array();
		$db = wfGetDB( DB_SLAVE );
		$res = $db->select( array( $db->tableName( 'smw_nm_monitor' ) . ' m', $db->tableName( 'smw_nm_query' ) . ' q' ),
		array( 'q.notify_id, q.delegate, q.name, q.user_id, q.nm_sql, q.nm_hierarchy' ),
			"m.notify_id=q.notify_id AND m.page_id=$page_id", $fname );
		if ( $db->numRows( $res ) > 0 ) {
			while ( $row = $db->fetchObject( $res ) ) {
				$ds = explode( ',', $row->delegate );
				$uids = array();
				foreach ( $ds as $delegate ) {
					$u = User::newFromName( trim( $delegate ) );
					if ( $u == null ) continue;
					$id = $u->getId();
					if ( $id > 0 ) {
						$uids[] = $id;
					}
				}
				if ( count( $uids ) == 0 ) {
					$uids[] = $row->user_id;
				}
				$result[$row->notify_id] = array( 'user_ids' => $uids, 'name' => $row->name, 'sql' => $row->nm_sql, 'hierarchy' => $row->nm_hierarchy );
			}
		}
		$db->freeResult( $res );
		wfProfileOut( $fname );
		return $result;
	}
	public function updateNMSql( $notify_id, $sql, $tmp_hierarchy ) {
		$fname = 'NotifyMe::updateNMSql';
		wfProfileIn( $fname );

		$dbw = wfGetDB( DB_MASTER );
		$dbw->update( 'smw_nm_query', array( 'nm_sql' => $sql, 'nm_hierarchy' => $tmp_hierarchy ), array( 'notify_id' => $notify_id ), $fname );
		wfProfileOut( $fname );
		return true;
	}
	public function getNotifyInMainQuery( $page_id, $notify_id, $sql, $hierarchy, &$match, &$monitoring ) {
		$fname = 'NotifyMe::getNotifyInMainQuery';
		wfProfileIn( $fname );

		$db = wfGetDB( DB_SLAVE );

		$tmp_tables = array();
		if ( $hierarchy != '' ) {
			$_hierarchies = array();
			foreach ( explode( ";", $hierarchy ) as $attrs ) {
				$part = explode( ":", $attrs, 3 );
				$tablename = $db->tableName( $part[0] );
				$depth = intval( $part[1] );
				$values = $part[2];

				$tmp_tables[] = $tablename;

				$db->query( "CREATE TEMPORARY TABLE $tablename ( id INT UNSIGNED NOT NULL KEY) TYPE=MEMORY", 'SMW::executeQueries' );
				if ( array_key_exists( $values, $_hierarchies ) ) { // just copy known result
					$db->query( "INSERT INTO $tablename (id) SELECT id FROM " . $_hierarchies[$values], 'SMW::executeQueries' );
				} else {
					$tmpnew = 'smw_new';
					$tmpres = 'smw_res';
					$db->query( "CREATE TEMPORARY TABLE $tmpnew ( id INT UNSIGNED ) TYPE=MEMORY", 'SMW::executeQueries' );
					$db->query( "CREATE TEMPORARY TABLE $tmpres ( id INT UNSIGNED ) TYPE=MEMORY", 'SMW::executeQueries' );
					$db->query( "INSERT IGNORE INTO $tablename (id) VALUES $values", 'SMW::executeQueries' );
					$db->query( "INSERT IGNORE INTO $tmpnew (id) VALUES $values", 'SMW::executeQueries' );
					$smw_subs2 = $db->tableName( 'smw_subs2' );
					for ( $i = 0; $i < $depth; $i++ ) {
						$db->query( "INSERT INTO $tmpres (id) SELECT s_id FROM $smw_subs2, $tmpnew WHERE o_id=id", 'SMW::executeQueries' );
						if ( $db->affectedRows() == 0 ) { // no change, exit loop
							break;
						}
						$db->query( "INSERT IGNORE INTO $tablename (id) SELECT $tmpres.id FROM $tmpres", 'SMW::executeQueries' );
						if ( $db->affectedRows() == 0 ) { // no change, exit loop
							break;
						}
						$db->query( 'TRUNCATE TABLE ' . $tmpnew, 'SMW::executeQueries' ); // empty "new" table
						$tmpname = $tmpnew;
						$tmpnew = $tmpres;
						$tmpres = $tmpname;
					}
					$_hierarchies[$values] = $tablename;
					$db->query( 'DROP TEMPORARY TABLE smw_new', 'SMW::executeQueries' );
					$db->query( 'DROP TEMPORARY TABLE smw_res', 'SMW::executeQueries' );
				}
			}
		}

		$sql = "SELECT p.page_id FROM " . $db->tableName( 'page' ) . " AS p INNER JOIN ($sql) AS s ON s.t=p.page_title AND s.ns=p.page_namespace WHERE p.page_id=$page_id";
		$res = $db->query( $sql, $fname );
		$match = ( $db->numRows( $res ) > 0 );
		$db->freeResult( $res );

		foreach ( $tmp_tables as $tablename ) {
			$db->query( "DROP TEMPORARY TABLE $tablename", 'SMW::getQueryResult' );
		}

		$monitoring = ( $db->selectRow( 'smw_nm_monitor', array( 'page_id' ),
		array( 'page_id' => $page_id, 'notify_id' => $notify_id ), $fname ) != false );

		wfProfileOut( $fname );
		return true;
	}
	public function getNotifyInSubquery( $notify_id, $sql, $hierarchy ) {
		$fname = 'NotifyMe::getNotifyInSubquery';
		wfProfileIn( $fname );

		$result = array( 'monitoring' => array(), 'match' => array() );

		$db = wfGetDB( DB_SLAVE );

		$tmp_tables = array();
		if ( $hierarchy != '' ) {
			$_hierarchies = array();
			foreach ( explode( ";", $hierarchy ) as $attrs ) {
				$part = explode( ":", $attrs, 3 );
				$tablename = $db->tableName( $part[0] );
				$depth = intval( $part[1] );
				$values = $part[2];

				$tmp_tables[] = $tablename;

				$db->query( "CREATE TEMPORARY TABLE $tablename ( id INT UNSIGNED NOT NULL KEY) TYPE=MEMORY", 'SMW::executeQueries' );
				if ( array_key_exists( $values, $_hierarchies ) ) { // just copy known result
					$db->query( "INSERT INTO $tablename (id) SELECT id FROM " . $_hierarchies[$values], 'SMW::executeQueries' );
				} else {
					$tmpnew = 'smw_new';
					$tmpres = 'smw_res';
					$db->query( "CREATE TEMPORARY TABLE $tmpnew ( id INT UNSIGNED ) TYPE=MEMORY", 'SMW::executeQueries' );
					$db->query( "CREATE TEMPORARY TABLE $tmpres ( id INT UNSIGNED ) TYPE=MEMORY", 'SMW::executeQueries' );
					$db->query( "INSERT IGNORE INTO $tablename (id) VALUES $values", 'SMW::executeQueries' );
					$db->query( "INSERT IGNORE INTO $tmpnew (id) VALUES $values", 'SMW::executeQueries' );
					$smw_subs2 = $db->tableName( 'smw_subs2' );
					for ( $i = 0; $i < $depth; $i++ ) {
						$db->query( "INSERT INTO $tmpres (id) SELECT s_id FROM $smw_subs2, $tmpnew WHERE o_id=id", 'SMW::executeQueries' );
						if ( $db->affectedRows() == 0 ) { // no change, exit loop
							break;
						}
						$db->query( "INSERT IGNORE INTO $tablename (id) SELECT $tmpres.id FROM $tmpres", 'SMW::executeQueries' );
						if ( $db->affectedRows() == 0 ) { // no change, exit loop
							break;
						}
						$db->query( 'TRUNCATE TABLE ' . $tmpnew, 'SMW::executeQueries' ); // empty "new" table
						$tmpname = $tmpnew;
						$tmpnew = $tmpres;
						$tmpres = $tmpname;
					}
					$_hierarchies[$values] = $tablename;
					$db->query( 'DROP TEMPORARY TABLE smw_new', 'SMW::executeQueries' );
					$db->query( 'DROP TEMPORARY TABLE smw_res', 'SMW::executeQueries' );
				}
			}
		}

		$res = $db->query( "SELECT p.page_id FROM " . $db->tableName( 'page' ) . " AS p INNER JOIN ($sql) AS s ON s.t=p.page_title AND s.ns=p.page_namespace", $fname );
		if ( $db->numRows( $res ) > 0 ) {
			while ( $row = $db->fetchObject( $res ) ) {
				$result['match'][] = $row->page_id;
			}
		}
		$db->freeResult( $res );

		foreach ( $tmp_tables as $tablename ) {
			$db->query( "DROP TEMPORARY TABLE $tablename", 'SMW::getQueryResult' );
		}

		$res = $db->select( $db->tableName( 'smw_nm_monitor' ), array( 'page_id' ), array( 'notify_id' => $notify_id ), $fname );
		if ( $db->numRows( $res ) > 0 ) {
			while ( $row = $db->fetchObject( $res ) ) {
				$result['monitoring'][] = $row->page_id;
			}
		}
		$db->freeResult( $res );

		wfProfileOut( $fname );
		return $result;
	}
	public function getUserInfo( $user_id ) {
		$fname = 'NotifyMe::getUserInfo';
		wfProfileIn( $fname );

		$db = wfGetDB( DB_SLAVE );
		$result = $db->selectRow( 'user', array( 'user_name', 'user_real_name', 'user_email' ), array( 'user_id' => $user_id ), $fname );

		wfProfileOut( $fname );
		return $result;
	}
	public function getPageTitle( $page_id ) {
		$db = wfGetDB( DB_SLAVE );
		return $db->selectRow( 'page', 'page_title', array( 'page_id' => $page_id ) );
	}
	public function addNotifyRSS( $type, $id, $title, $msg, $link = NULL ) {
		$fname = 'NotifyMe::addNotifyRSS';
		wfProfileIn( $fname );
		$db = wfGetDB( DB_MASTER );

		$rid = $db->nextSequenceValue( 'nmrss_msg_id_seq' );
		$values = array( 'msg_id' => $rid,
					'title' => $title,
					'notify' => $msg,
					'timestamp' => $db->timestamp() );
		if ( $type == "uid" ) {
			$values['user_id'] = $id;
		} else {
			$values['notify_id'] = $id;
		}
		if ( $link !== NULL ) {
			$values['link'] = $link;
		}

		$db->insert( 'smw_nm_rss', $values, $fname );
		$id = $db->insertId();

		wfProfileOut( $fname );
		return $id;
	}
	public function getNotifyRSS( $type, $id, $limit ) {
		$fname = 'NotifyMe::getNotifyRSS';
		wfProfileIn( $fname );
		$db = wfGetDB( DB_SLAVE );
		$result = array();
		if ( $type == "uid" ) {
			$ids = array( 'user_id' => $id );
		} else {
			$ids = array( 'notify_id' => $id );
		}
		$res = $db->select( $db->tableName( 'smw_nm_rss' ), array( 'title', 'link', 'notify', 'timestamp' ), $ids, $fname, array( 'ORDER BY' => 'timestamp DESC', 'LIMIT' => $limit ) );
		if ( $db->numRows( $res ) > 0 ) {
			while ( $row = $db->fetchObject( $res ) ) {
				$result[] = array( 'title' => $row->title, 'link' => $row->link, 'notify' => $row->notify, 'timestamp' => $row->timestamp );
			}
		}
		$db->freeResult( $res );
		wfProfileOut( $fname );
		return $result;
	}
	public function getUnmailedNMMessages() {
		$fname = 'NotifyMe::getUnmailedNMMessages';
		wfProfileIn( $fname );
		$db = wfGetDB( DB_MASTER );
		$smw_nm_rss = $db->tableName( 'smw_nm_rss' );
		$result = array();
		$res = $db->select( $smw_nm_rss,
		array( 'user_id', 'title', 'notify', 'timestamp' ),
		array( 'mailed' => '0' ), $fname );
		if ( $db->numRows( $res ) > 0 ) {
			while ( $row = $db->fetchObject( $res ) ) {
				$result[] = array( 'user_id' => $row->user_id, 'title' => $row->title, 'notify' => $row->notify, 'timestamp' => $row->timestamp );
			}
		}
		$db->freeResult( $res );
		$db->update( $smw_nm_rss, array( 'mailed' => '1' ), array( 'mailed' => '0' ), $fname );
		wfProfileOut( $fname );
		return $result;
	}

	public function getGroupedUsers( $groups ) {
		$fname = 'NotifyMe::getGroupedUsers';
		wfProfileIn( $fname );
		$db = wfGetDB( DB_SLAVE );
		extract( $db->tableNames( 'user_groups', 'user' ) );
		$result = array();
		$res = $db->query( "SELECT u.user_name FROM $user u" .
			( $groups ? " LEFT JOIN $user_groups g ON u.user_id = g.ug_user
			WHERE g.ug_group IN ('" . join( "','", $groups ) . "')
			GROUP BY user_name":"" ), $fname );
		if ( $db->numRows( $res ) > 0 ) {
			while ( $row = $db->fetchObject( $res ) ) {
				$result[] = $row->user_name;
			}
		}
		$db->freeResult( $res );
		wfProfileOut( $fname );
		return $result;
	}

	function getNMQueryResult( SMWQuery $query ) {
		wfProfileIn( 'SMWSQLStore2::getNMQueryResult (SMW)' );
		global $smwgNMIP;
		if ( defined( 'SMW_VERSION' ) && strpos( SMW_VERSION, '1.5' ) == 0 ) {
			include_once( "$smwgNMIP/includes/storage/SMW_SQLStore2_QueriesNM.smw15.php" );
		} else {
			include_once( "$smwgNMIP/includes/storage/SMW_SQLStore2_QueriesNM.php" );
		}
		$qe = new SMWSQLStore2QueryEngineNM( smwfGetStore(), wfGetDB( DB_SLAVE ) );
		$result = $qe->getQueryResult( $query );
		wfProfileOut( 'SMWSQLStore2::getNMQueryResult (SMW)' );
		return $result;
	}

}
