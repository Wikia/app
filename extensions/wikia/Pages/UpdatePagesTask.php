<?php

use Wikia\Tasks\Tasks\BaseTask;

class UpdatePagesTask extends BaseTask {
	/**
	 * Delete the entry for this page from dataware.pages table.
	 *
	 * @param int $articleId
	 * @throws DBUnexpectedError
	 * @throws MWException
	 */
	public function deleteEntry( int $articleId ) {
		$whereCondition = [
			'page_wikia_id' => $this->getWikiId(),
			'page_id' => $articleId
		];

		$this->getDatawareMaster()
			->delete( 'pages', $whereCondition, __METHOD__ );
	}

	/**
	 * Insert a row for this article into dataware.pages table, or update the row if it already exists.
	 *
	 * @param int $articleId
	 * @param bool $isContentPage
	 * @throws Exception
	 */
	public function insertOrUpdateEntry( int $articleId, bool $isContentPage ) {
		$dbr = wfGetDB( DB_SLAVE );

		// We will need all information about this page plus the timestamp of the last edit made to it
		// Fetch that using the ID of the latest revision from page_latest
		$rowToInsert = (array) $dbr->selectRow(
			[ 'page', 'revision' ], [
				'page_id',
				'page_namespace',
				'page_title',
				'page_is_redirect',
				'page_latest',
				'rev_timestamp AS page_last_edited',
			],
			[ 'page_id' => $articleId ],
			__METHOD__,
			[],
			[ 'revision' => [ 'INNER JOIN', [ 'page_latest = rev_id' ] ] ]
		);

		if ( !array_filter( $rowToInsert ) ) {
			return;
		}

		$rowToInsert += [
			'page_is_content' => $isContentPage,
			'page_wikia_id' => $this->getWikiId()
		];

		$primaryKey = [ 'page_id','page_wikia_id' ];

		$fieldsToUpdate = array_diff_key( $rowToInsert, array_flip( $primaryKey ) );

		$this->getDatawareMaster()
			->upsert( 'pages', [ $rowToInsert ], [ $primaryKey ], $fieldsToUpdate, __METHOD__ );
	}

	private function getDatawareMaster(): DatabaseBase {
		global $wgExternalDatawareDB;

		return wfGetDB( DB_MASTER, [], $wgExternalDatawareDB );
	}

	/**
	 * Construct a new {@see UpdatePagesTask} instance that will be run in the context of the current wiki
	 * @return UpdatePagesTask
	 */
	public static function newLocalTask(): UpdatePagesTask {
		global $wgCityId;

		return ( new self() )->wikiId( $wgCityId );
	}
}
