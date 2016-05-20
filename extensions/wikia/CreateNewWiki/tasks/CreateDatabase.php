<?php

namespace Wikia\CreateNewWiki\Tasks;

use Wikia\Logger\Loggable;

class CreateDatabase extends Task {

	use Loggable;

	/** @var  string */
	private $clusterDB;

	public function prepare() {
		global $wgCreateDatabaseActiveCluster;
		$this->taskContext->setSharedDBW( \WikiFactory::db( DB_MASTER ) );
		$this->clusterDB = "wikicities_" . $wgCreateDatabaseActiveCluster;
		$dbName = $this->prepareDatabaseName(
			$this->clusterDB, $this->taskContext->getWikiName(), $this->taskContext->getLanguage()
		);

		if ( !empty($dbName) ) {
			$this->taskContext->setDbName( $dbName );

			return TaskResult::createForSuccess();
		} else {
			return TaskResult::createForError( "Could not find a valid db name - all were taken" );
		}
	}

	public function check() {
		$dbw = wfGetDB( DB_MASTER, [ ], $this->clusterDB );

		if ( wfReadOnly() || $this->isClusterReadOnly( $dbw ) ) {
			return TaskResult::createForError( 'DB is read only' );
		} else {
			return TaskResult::createForSuccess();
		}
	}

	private function isClusterReadOnly( $dbw ) {
		// SUS-108: check read-only state of ACTIVE_CLUSTER before performing any DB-related actions
		return $dbw->getLBInfo( 'readOnlyReason' ) !== false;
	}

	public function run() {
		$dbw = wfGetDB( DB_MASTER, [ ], $this->clusterDB );
		$dbw->query( sprintf( "CREATE DATABASE `%s`", $this->taskContext->getDBname() ) );

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
	 * @param string $clusterDB
	 * @param $dbName
	 * @param string $lang -- language for wiki
	 * @return string : fixed name of DB
	 * @internal param string $dbname -- name of DB to check
	 */
	private function prepareDatabaseName( $clusterDB, $dbName, $lang ) {
		wfProfileIn( __METHOD__ );

		$dbwf = \WikiFactory::db( DB_SLAVE );
		$dbr = wfGetDB( DB_SLAVE, [ ], $clusterDB );

		if ( $lang !== "en" ) {
			$dbName = $lang . $dbName;
		}

		$dbName = substr( str_replace( "-", "", $dbName ), 0, 50 );
		$attemptNo = 0;

		while ( $this->doesDbExistInCityList( $dbwf, $dbName ) || $this->doesDbExistInCluster( $dbr, $dbName ) ) {
			$suffix = rand( 1, 999 );
			$dbName = sprintf( "%s%s", $dbName, $suffix );
			if ( ++$attemptNo > 100 ) {
				$dbName = null;
				break;
			}
		}
		wfProfileOut( __METHOD__ );

		return $dbName;
	}

	private function doesDbExistInCityList( $dbwf, $dbName ) {
		$this->debug( __METHOD__ . ": Checking if database " . $dbName . " already exists in city_list" );
		$row = $dbwf->selectRow(
			[
				"city_list",
				"count(*) as count",
				"city_dbname" => $dbName
			],
			__METHOD__
		);
		if ( $row->count > 0 ) {
			$this->debug( __METHOD__ . ": Database " . $dbName . " exists in city_list!" );
			return true;
		} else {
			return false;
		}
	}

	private function doesDbExistInCluster( $dbr, $dbName ) {
		$this->debug( __METHOD__ . ": Checking if database " . $dbName . " already exists in cluster" );
		$sth = $dbr->query( sprintf( "show databases like '%s'", $dbName ) );
		if ( $dbr->numRows( $sth ) > 0 ) {
			$this->debug( __METHOD__ . ": Database " . $dbName . " exists on cluster!" );
			return true;
		} else {
			return false;
		}
	}
}

