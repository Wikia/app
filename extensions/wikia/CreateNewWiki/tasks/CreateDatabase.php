<?php

namespace Wikia\CreateNewWiki\Tasks;

class CreateDatabase implements Task {

	use \Wikia\Logger\Loggable;

	/** @var  TaskContext */
	private $taskContext;

	public function __construct($taskContext) {
		$this->taskContext = $taskContext;
	}

	public function prepare() {
		$clusterDB = "wikicities_" . TaskContext::ACTIVE_CLUSTER;
		$dbw = wfGetDB( DB_MASTER, array(), $clusterDB );
		$this->taskContext->setClusterDB( $clusterDB );
		$this->taskContext->setWikiDBW( $dbw );
		$this->taskContext->setDbName( $this->prepareDatabaseName(
			$dbw, $this->taskContext->getWikiName(), $this->taskContext->getLanguage() ) );

		return TaskResult::createForSuccess();
	}

	public function check() {
		if ( wfReadOnly() ) {
			return TaskResult::createForError( 'DB is read only' );
		} else {
			return TaskResult::createForSuccess();
		}
	}

	public function run() {
		$this->taskContext->getWikiDBW()->query( sprintf( "CREATE DATABASE `%s`", $this->taskContext->getDBname() ) );

		return TaskResult::createForSuccess();
	}

	/**
	 * prepareDatabaseName
	 *
	 * check if database name is used, if it's used prepare another one
	 *
	 * @author Piotr Molski <moli@wikia-inc.com>
	 * @access private
	 *
	 * @param \DatabaseMysqli $dbw
	 * @param string	$dbname -- name of DB to check
	 * @param string	$lang   -- language for wiki
	 *
	 * @todo when second cluster will come this function has to changed
	 *
	 * @return string: fixed name of DB
	 */
	private function prepareDatabaseName( $dbw, $dbName, $lang ) {
		wfProfileIn( __METHOD__ );

		$dbwf = WikiFactory::db( DB_SLAVE );
		$wikiDbw  = $this->taskContext->getWikiDBW();

		if( $lang !== "en" ) {
			$dbName = $lang . $dbName;
		}

		$dbName = substr( str_replace( "-", "", $dbName ), 0 , 50 );

		/**
		 * check city_list
		 */
		$exists = 1;
		$suffix = "";
		while( $exists == 1 ) {
			$dbName = sprintf("%s%s", $dbName, $suffix);
			wfDebugLog( "createwiki", __METHOD__ . ": Checking if database {$dbName} already exists in city_list\n", true );
			$row = $dbwf->selectRow(
				array( "city_list" ),
				array( "count(*) as count" ),
				array( "city_dbname" => $dbName ),
				__METHOD__
			);
			$exists = 0;
			if( $row->count > 0 ) {
				wfDebugLog( "createwiki", __METHOD__ . ": Database {$dbName} exists in city_list!\n", true );
				$exists = 1;
			}
			else {
				wfDebugLog( "createwiki", __METHOD__ . ": Checking if database {$dbName} already exists in database", true );
				$sth = $wikiDbw->query( sprintf( "show databases like '%s'", $dbName) );
				if ( $wikiDbw->numRows( $sth ) > 0 ) {
					wfDebugLog( "createwiki", __METHOD__ . ": Database {$dbName} exists on cluster!", true );
					$exists = 1;
				}
			}
			# add suffix
			if( $exists == 1 ) {
				$suffix = rand( 1, 999 );
			}
		}
		wfProfileOut( __METHOD__ );

		return $dbName;
	}
}

