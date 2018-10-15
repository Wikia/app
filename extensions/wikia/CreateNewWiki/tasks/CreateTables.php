<?php

namespace Wikia\CreateNewWiki\Tasks;

use Wikia\Logger\Loggable;

class CreateTables extends Task {

	use Loggable;

	private $sqlFiles;

	public function prepare() {
		global $IP;

		/* default tables */
		$this->sqlFiles = [
			"{$IP}/maintenance/tables.sql",
			"{$IP}/maintenance/interwiki.sql",
			"{$IP}/maintenance/wikia/city_interwiki_links.sql",
			"{$IP}/extensions/CheckUser/cu_changes.sql",
			"{$IP}/extensions/CheckUser/cu_log.sql",
			"{$IP}/maintenance/archives/wikia/patch-watchlist-improvements.sql",
			"{$IP}/maintenance/archives/wikia/patch-create-blog_listing_relation.sql",
			"{$IP}/maintenance/archives/wikia/patch-create-page_vote.sql",
			"{$IP}/maintenance/archives/wikia/patch-create-page_visited.sql",

			//article comments list use by wall/forum
			"{$IP}/extensions/wikia/Wall/sql/patch-create-comments_index.sql",

			//wall tables (SUS-1556)
			"{$IP}/extensions/wikia/Wall/sql/wall_history_local.sql",
			"{$IP}/extensions/wikia/Wall/sql/wall_related_pages.sql",

			"{$IP}/extensions/wikia/VideoHandlers/sql/video_info.sql",
			"{$IP}/maintenance/wikia/wikia_user_properties.sql",
		];

		$additionalTables = [
			"{$IP}/extensions/wikia/AjaxPoll/patch-create-poll_info.sql",
			"{$IP}/extensions/wikia/AjaxPoll/patch-create-poll_vote.sql",
			"{$IP}/extensions/wikia/ImageServing/sql/table.sql",
		];

		foreach ( $additionalTables as $file ) {
			if ( is_readable( $file ) ) {
				$this->sqlFiles[] = $file;
			}
		}

		return TaskResult::createForSuccess();
	}

	public function run() {
		$dbw = wfGetDB( DB_MASTER, [ ], $this->taskContext->getDBname() );
		$this->taskContext->setWikiDBW( $dbw );

		$dbw->multiQuery( $this->getSchemaSQL(), __METHOD__ );
		$dbw->commit( __METHOD__ );

		$this->waitUntilTableExistsOnSlave();

		return TaskResult::createForSuccess();
	}

	/**
	 * Create a concatenated SQL schema statement from the source files provided
	 * @return string SQL statements delimited by semicolon + newline
	 */
	private function getSchemaSQL(): string {
		$sql = '';

		foreach ( $this->sqlFiles as $file ) {
			$fp = fopen( $file, 'r' );

			while ( ( $line = fgets( $fp ) ) !== false ) {
				// Remove whitespace, exclude empty lines and SQL comments
				$line = trim( $line );
				if ( $line !== '' && substr( $line, 0, 2 ) !== '--' ) {
					$sql .= " $line\n";
				}
			}

			fclose( $fp );
		}

		return trim( $sql );
	}

	/**
	 * Wait until the interwiki table has replicated to the slave we are currently connected to.
	 */
	private function waitUntilTableExistsOnSlave() {
		$dbr = wfGetDB( DB_SLAVE,  [], $this->taskContext->getDBname() );

		$helper = new ReplicationWaitHelper( $dbr );
		$helper->setCaller( __METHOD__ );

		$helper->waitUntil( function ( \DatabaseBase $dbr ): bool {
			return $dbr->tableExists( 'interwiki', __METHOD__ );
		} );
	}
}
