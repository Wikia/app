<?php

use Wikia\Logger\WikiaLogger;

class PermanentFileDelete {

	/**
	 * Permanently delete all files uploaded by a given user.
	 * File description pages are permanently deleted, files are removed from disk and all related DB rows are removed.
	 *
	 * This process is not reversible.
	 *
	 * @param int $userId
	 * @return Status
	 * @throws DBUnexpectedError
	 * @throws MWException
	 */
	public static function deleteFiles( int $userId ): Status {
		$dbr = wfGetDB( DB_SLAVE );

		$files = $dbr->select(
			[ 'image' ],
			[ 'img_name', 'img_sha1', 'img_timestamp' ],
			[ 'img_user' => $userId ],
			__METHOD__
		);

		$archived = $dbr->select(
			'oldimage',
			[ 'oi_name', 'oi_archive_name', 'oi_sha1', 'oi_timestamp' ],
			[ 'oi_user' => $userId ],
			__METHOD__
		);

		$status = static::removeFilesFromBackend( $files, $archived );

		if ( $status->isOK() ) {
			// delete the file description pages
			foreach ( $files as $row ) {
				$title = Title::makeTitle( NS_FILE, $row->img_name );
				PermanentArticleDelete::deletePage( $title );

				$page = WikiPage::factory( $title );
				$page->doPurge();
			}

			$dbw = wfGetDB( DB_MASTER );

			$dbw->delete( 'image', [ 'img_user' => $userId ], __METHOD__ );
			$dbw->delete( 'oldimage', [ 'oi_user' => $userId ], __METHOD__ );
			$dbw->delete( 'filearchive', [ 'fa_user' => $userId ], __METHOD__ );
		} else {
			WikiaLogger::instance()->error( 'Error while deleting files', [
				'status' => $status
			] );
		}

		return $status;
	}

	private static function removeFilesFromBackend( $files, $archived ): Status {
		$repo = RepoGroup::singleton()->getLocalRepo();
		$paths = [];

		foreach ( $files as $row ) {
			$localFile = LocalFile::newFromRow( $row, $repo );
			$paths[] = $localFile->getRel();

			$localFile->purgeEverything();
		}

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

		return $repo->getBackend()->doOperations( $operations );
	}
}
