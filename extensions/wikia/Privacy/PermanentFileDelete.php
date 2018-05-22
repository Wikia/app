<?php

use Wikia\Logger\WikiaLogger;

class PermanentFileDelete {

	/**
	 * Permanently delete a file.
	 * The file description page is permanently deleted, all file revisions are removed from disk and all related DB rows are removed.
	 *
	 * This process is not reversible.
	 *
	 * @param string $title
	 * @return Status
	 * @throws DBUnexpectedError
	 * @throws MWException
	 */
	public static function deleteFiles( string $title ): Status {
		$dbr = wfGetDB( DB_SLAVE );

		$archived = $dbr->select(
			'oldimage',
			[ 'oi_name', 'oi_archive_name', 'oi_sha1', 'oi_timestamp' ],
			[ 'oi_name' => $title ],
			__METHOD__
		);

		$status = static::removeFilesFromBackend( $title, $archived );

		if ( $status->isOK() ) {
			// delete the file description page
			$pageTitle = Title::makeTitle( NS_FILE, $title );
			PermanentArticleDelete::deletePage( $pageTitle );

			$dbw = wfGetDB( DB_MASTER );

			$dbw->delete( 'image', [ 'img_name' => $title ], __METHOD__ );
			$dbw->delete( 'oldimage', [ 'oi_name' => $title ], __METHOD__ );
			$dbw->delete( 'filearchive', [ 'fa_name' => $title ], __METHOD__ );

			$page = WikiPage::factory( $pageTitle );
			$page->doPurge();
		} else {
			WikiaLogger::instance()->error( 'Error while deleting files', [
				'status' => $status
			] );
		}

		return $status;
	}

	private static function removeFilesFromBackend( string $title, $archived ): Status {
		$repo = RepoGroup::singleton()->getLocalRepo();

		$localFile = LocalFile::newFromTitle( $title, $repo );

		$paths = [ $localFile->getRel() ];

		foreach ( $archived as $row ) {
			$oldLocalFile = OldLocalFile::newFromRow( $row, $repo );
			$paths[] = $oldLocalFile->getRel();

			$oldLocalFile->purgeThumbnails( $oldLocalFile->getArchiveName() );
		}

		$operations = [];

		foreach ( $paths as $srcPath ) {
			$operations[] = [
				'op' => 'delete',
				'src' => $srcPath,
				'ignoreMissingSource' => true
			];
		}

		$status = $repo->getBackend()->doOperations( $operations );

		$localFile->purgeEverything();

		return $status;
	}
}
