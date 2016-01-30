<?php

namespace Wikia\ContentReview\Models;

use Wikia\Util\GlobalStateWrapper;

class ContentReviewBaseModel extends \WikiaModel {

	/**
	 * Names of tables used by the extension
	 */
	const CONTENT_REVIEW_STATUS_TABLE = 'content_review_status';
	const CONTENT_REVIEW_CURRENT_REVISIONS_TABLE = 'current_reviewed_revisions';
	const CONTENT_REVIEW_LOG_TABLE = 'reviewed_content_logs';

	/**
	 * Connects to a database with an intent of performing SELECT queries
	 * @return \DatabaseBase
	 */
	protected function getDatabaseForRead() {
		return $this->getDatabase( DB_SLAVE );
	}

	/**
	 * Connects to a database with an intent of performing INSERT, UPDATE and DELETE queries
	 * @return \DatabaseBase
	 */
	protected function getDatabaseForWrite() {
		return $this->getDatabase( DB_MASTER );
	}

	/**
	 * Get connection to content review database
	 *
	 * Content review database is encoded in utf-8, while in most cases MW communicate with
	 * databases using latin1, so sometimes we get strings in wrong encoding.
	 * The only way to force utf-8 communication (adding SET NAMES utf8) is setting
	 * global variable wgDBmysql5.
	 *
	 * @see https://github.com/Wikia/app/blob/dev/includes/db/DatabaseMysqlBase.php#L113
	 *
	 * @param int $dbType master or slave
	 * @return \DatabaseBase
	 */
	protected function getDatabase( $dbType ) {
		$wrapper = new GlobalStateWrapper( [
			'wgDBmysql5' => true
		] );

		$db = $wrapper->wrap( function () use ( $dbType ) {
			return wfGetDB( $dbType, [], $this->wg->ContentReviewDB );
		} );

		return $db;
	}
}
