<?php

/**
 * @package MediaWiki
 * @addtopackage maintenance
 */

#
# note! this table has to be created on archive storage, not wikicities table
#
# CREATE TABLE  IF NOT EXISTS `wikia_tasks` (
#  `task_id` int(11) NOT NULL auto_increment,
#  `task_user_id` int(5) unsigned NOT NULL default '0',
#  `task_type` varchar(255) NOT NULL default '',
#  `task_priority` tinyint(4) NOT NULL default '0',
#  `task_status` tinyint(4) NOT NULL default '0',
#  `task_started` char(14) NOT NULL,
#  `task_finished` char(14) NOT NULL,
#  `task_arguments` text,
#  `task_log` mediumblob,
#  `task_added` char(14) NOT NULL,
#  PRIMARY KEY  (`task_id`),
#  KEY `task_added_idx` (`task_added`)
#) ENGINE=InnoDB;
#


ini_set( "include_path", dirname(__FILE__)."/../../../../maintenance/" );
require_once( "commandLine.inc" );

/**
 * archive rows in dataware/archive database
 */
class TaskManagerArchive {

	const CUTOFFDAYS = 60;
	const LIMIT      = 1000;

	private $mData;

	/**
	 * main entry point
	 *
	 * @access public
	 */
	public function execute() {

		$this->getRows();
		$this->moveRows();
		$this->removeRows();

	}

	/**
	 * get rows for archivization
	 *
	 * @access private
	 */
	private function getRows() {

		wfProfileIn( __METHOD__ );

		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select(
			array( WikiFactory::table( "wikia_tasks" ) ),
			array(
				"task_id",
				"task_user_id",
				"task_type",
				"task_priority",
				"task_status",
				"task_started",
				"task_finished",
				"task_arguments",
				"task_log",
				"task_added"
			),
			array( "task_added < " . $dbr->addQuotes(  $dbr->timestamp( time() - 24 * 60 * 60 * self::CUTOFFDAYS ) ) ),
			__METHOD__,
			array( "ORDER BY" => "task_added", "LIMIT" => self::LIMIT )
		);

		while( $row = $dbr->fetchObject( $res ) ) {
			$this->mData[] = $row;
		}
		$dbr->freeResult( $res );

		Wikia::log( __METHOD__, "", sprintf("Got %d rows for archiving", count( $this->mData ) ) );

		foreach( $this->mData as $num => $task ) {
			Wikia::log( __METHOD__, "", sprintf( "Getting logs for task %d", $task->task_id ) );
			$res = $dbr->select(
				array( WikiFactory::table( "wikia_tasks_log" ) ),
				array( "*" ),
				array( "task_id" => $task->task_id ),
				__METHOD__
			);
			$logs = array();
			while( $row = $dbr->fetchRow( $res ) ) {
				$logs[] = $row;
			}
			$dbr->freeResult( $res );
			$this->mData[ $num ]->task_log = $logs;
		}

		wfProfileOut( __METHOD__ );

		return true;
	}

	/**
	 * store rows in archive database
	 *
	 * @access private
	 */
	private function moveRows() {

		wfProfileIn( __METHOD__ );

		$dbw = wfGetDBExt( DB_MASTER );
		$dbw->selectDb( "archive" );
		$dbw->begin();
		foreach( $this->mData as $num => $task ) {
			$values = array(
				"task_id"        => $task->task_id,
				"task_user_id"   => $task->task_user_id,
				"task_type"      => $task->task_type,
				"task_priority"  => $task->task_priority,
				"task_status"    => $task->task_status,
				"task_started"   => $task->task_started,
				"task_finished"  => $task->task_finished,
				"task_arguments" => $task->task_arguments,
				"task_log"       => serialize( $task->task_log ),
				"task_added"     => $task->task_added
			);
			$dbw->insert(
				"wikia_tasks",
				$values,
				__method__
			);
			Wikia::log( __METHOD__, "", sprintf("Task %d moved.", $task->task_id ) );
			$this->mData[ $num ]->moved = true;
		}
		$dbw->commit();
		wfProfileOut( __METHOD__ );

		return true;
	}

	/**
	 * remove rows stored in archive database
	 *
	 * @access private
	 */
	private function removeRows() {

		wfProfileIn( __METHOD__ );

		$dbw = wfGetDB( DB_MASTER );

		foreach( $this->mData as $num => $task ) {
			if( !empty( $task->moved ) ) {
				$dbw->delete(
					WikiFactory::table( "wikia_tasks" ),
					array( "task_id" => $task->task_id ),
					__method__
				);
				Wikia::log( __METHOD__, "", sprintf("Task %d removed.", $task->task_id ) );
			}
		}

		wfProfileOut( __METHOD__ );

		return true;
	}
}


$taskArchive = new TaskManagerArchive();
$taskArchive->execute();
