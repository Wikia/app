<?php

class PermanentArticleDelete {

	/**
	 * Permanently delete an article. Revision text and related log entries are also deleted.
	 *
	 * This process is not reversible.
	 *
	 * @param Title $title
	 * @throws DBUnexpectedError
	 * @throws FatalError
	 * @throws MWException
	 */
	public static function deletePage( Title $title ) {
		$dbr = wfGetDB( DB_SLAVE );
		$articleId = $title->getArticleID();

		$revisions = $dbr->select(
			[ 'revision', 'text' ],
			Revision::selectTextFields(),
			[ 'rev_page' => $articleId ],
			__METHOD__,
			[],
			[ 'text' => [ 'INNER JOIN', 'rev_text_id = old_id' ] ]
		);

		$lbFactory = wfGetLBFactory();
		/** @var DatabaseBase[] $blobsClusters */
		$blobsClusters = [];

		// remove revision text from blobs cluster if needed
		foreach ( $revisions as $row ) {
			$flags = str_getcsv( $row->old_flags );

			if ( in_array( 'external', $flags ) ) {
				list( , $parts ) = explode( '://', $row->old_text, 2 );
				list( $cluster, $id ) = explode( '/', $parts );

				if ( !isset( $blobsClusters[$cluster] ) ) {
					$blobsClusters[$cluster] = $lbFactory->getExternalLB( $cluster )->getConnection( DB_MASTER );
				}

				$blobsClusters[$cluster]->delete( 'blobs', [ 'blob_id' => $id ] );
			}
		}

		$namespace = $title->getNamespace();
		$text = $title->getText();

		// do a standard MediaWiki delete - it will clean up links tables, notify extensions, and shift revision data to archive
		$err = [];
		$bot = User::newFromName( Wikia::BOT_USER );
		$page = WikiPage::factory( $title );
		$page->doDeleteArticle( 'test', false, $articleId, true, $err, $bot );

		// ... then remove log entries and archive entries
		$dbw = wfGetDB( DB_MASTER );

		$dbw->deleteJoin(
			'text',
			'archive',
			'old_id',
			'ar_text_id',
			[ 'ar_namespace' => $namespace, 'ar_title' => $text ],
			__METHOD__
		);

		$dbw->delete( 'archive', [ 'ar_namespace' => $namespace, 'ar_title' => $text ], __METHOD__ );
		$dbw->delete( 'logging', [ 'log_page' => $articleId ] );

		Hooks::run( 'ArticlePermanentDelete', [ $dbw, $title ] );
	}
}
