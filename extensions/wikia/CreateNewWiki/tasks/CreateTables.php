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

		foreach ( $this->sqlFiles as $file ) {
			$this->debug( __METHOD__ . ": Populating database with {$file}" );

			$success = $this->taskContext->getWikiDBW()->sourceFile( $file );
			if ( $success !== true ) {
				return TaskResult::createForError( "Failed to run sql script " . $file );
			}
		}

		//Add stats entry
		$this->taskContext->getWikiDBW()->insert( "site_stats", [ "ss_row_id" => "1" ], __METHOD__ );

		// we need to wait for slaves to catch up
		TaskHelper::waitForSlaves( $this->taskContext, __METHOD__ );

		return TaskResult::createForSuccess();
	}
}
