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
	 * @param array $pagesEntryJson
	 * @throws Exception
	 */
	public function insertOrUpdateEntry( array $pagesEntryJson ) {
		$pagesEntry = PagesEntry::newFromJson( $pagesEntryJson );

		$rowToInsert = [
			'page_wikia_id' => $this->getWikiId(),
			'page_id' => $pagesEntry->getArticleId(),
			'page_namespace' => $pagesEntry->getNamespace(),
			'page_title' => $pagesEntry->getTitle(),
			'page_is_content' => $pagesEntry->isContentPage(),
			'page_is_redirect' => $pagesEntry->isRedirect(),
			'page_latest' => $pagesEntry->getLatestRevisionId(),
			'page_last_edited' => $pagesEntry->getLatestRevisionTimestamp(),
			'page_created_at' => $pagesEntry->getCreatedAtTimestamp()
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
}
