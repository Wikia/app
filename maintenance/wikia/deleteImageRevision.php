<?php

require_once( __DIR__ . '/../Maintenance.php' );

class DeleteImageRevision extends Maintenance {

	const PAGE_ID_OPTION = 'pageId';
	const REVISION_ID_OPTION = 'revisionId';
	const REASON_OPTION = 'reason';

	private $db;

	public function __construct() {
		parent::__construct();
		$this->addOption( self::PAGE_ID_OPTION, "image page id", true );
		$this->addOption( self::REVISION_ID_OPTION, "revision id", true );
		$this->mDescription = "Remove given revision of given image file";
	}


	public function execute() {
		global $wgUser;

		// SUS-3222: Delete as official bot
		$wgUser = User::newFromName( Wikia::BOT_USER, false );

		$pageId = intval( $this->getOption( self::PAGE_ID_OPTION ) );
		$revisionId = intval( $this->getOption( self::REVISION_ID_OPTION ) );
		$reason = wfMessage( 'imagereview-reason' )->inContentLanguage()->plain();

		$title = Title::newFromID( $pageId );
		if ( empty( $title ) ) {
			\Wikia\Logger\WikiaLogger::instance()->error(
				"can not find a file with page_id ${pageId}"
			);

			return;
		}

		$this->db = wfGetDB( DB_SLAVE );

		$timestamp = $this->db->selectField(
			[ 'revision' ],
			'rev_timestamp',
			[
				'rev_page' => $title->getArticleID(),
				'rev_id' => $revisionId,
			],
			__METHOD__
		);

		if ( $this->isOldImageRevision( $timestamp, $title->getDBkey() ) ) {
			$this->removeOldRevision( $title, $timestamp, $revisionId, $pageId, $reason );
		} else {
			$this->removeLatestRevision( $title, $timestamp, $revisionId, $pageId, $reason );
		}
	}

	private function removeLatestRevision( Title $title, string $revisionTimestamp, int $revisionId, int $pageId, string $reason ) {
		$this->output(__METHOD__ . "\n");

		if ( !$this->hasOldRevisions( $title->getDBkey() ) ) {
			$file = wfLocalFile( $title );

			// intentionally left as false to enforce removal of whole File by FileDeleteForm::doDelete when there is only one revision
			$oldfile = false;
			if ( !FileDeleteForm::doDelete( $title, $file, $oldfile, $reason, false )->isOK() ) {
				\Wikia\Logger\WikiaLogger::instance()->error(
					"deleting file was not successful",
					[
						'page_id' => $pageId,
						'revision_id' => $revisionId
					]
				);
			}
		} else {
			$this->revertToPreviousRevision( $title, $reason );
			wfWaitForSlaves();
			$this->removeOldRevision( $title, $revisionTimestamp, $revisionId, $pageId, $reason );
		}
	}

	private function revertToPreviousRevision( Title $title, string $comment ) {
		$this->output(__METHOD__ . "\n");

		$archiveName = $this->db->selectField(
			['oldimage'],
			'oi_archive_name',
			[
				'oi_name' => $title->getDBkey()
			],
			__METHOD__,
			['ORDER BY' => 'oi_timestamp desc']
		);

		$oldLocalFile = OldLocalFile::newFromArchiveName( $title, RepoGroup::singleton()->getLocalRepo(), $archiveName );
		$source = $oldLocalFile->getArchiveVirtualUrl( $oldLocalFile->getArchiveName() );
		$status = wfLocalFile( $title )->upload( $source, $comment, $comment );

		Hooks::run( 'FileRevertComplete', [ new WikiPage( $title ) ] );

		if( !$status->isGood() ) {
			\Wikia\Logger\WikiaLogger::instance()->error("failed to revert file to previous revision" );
		}
	}

	private function hasOldRevisions( $fileName ):bool {
		$this->output(__METHOD__ . "\n");

		return !empty(
			$this->db->selectField(
				[ 'oldimage' ],
				'1 as has_old',
				[ 'oi_name' => $fileName ]
			)
		);
	}

	private function removeOldRevision( Title $title, string $revisionTimestamp, int $revisionId, int $pageId, string $reason ) {
		$this->output(__METHOD__ . "\n");

		$oldLocalFile = OldLocalFile::newFromTitle( $title, RepoGroup::singleton()->getLocalRepo(), $revisionTimestamp );
		$oldimage = $oldLocalFile->getArchiveName();

		// if $oldimage is empty, FileDeleteForm::doDelete would delete whole file instead of single revision
		if ( !empty( $oldimage ) ) {
			if ( !FileDeleteForm::doDelete( $title, $oldLocalFile, $oldimage, $reason, false )->isOK() ) {
				\Wikia\Logger\WikiaLogger::instance()->error(
					"deleting file revision was not successful",
					[
						'page_id' => $pageId,
						'revision_id' => $revisionId
					]
				);
			}
		} else {
			\Wikia\Logger\WikiaLogger::instance()->error(
				"trying to remove whole image page",
				[
					'page_id' => $pageId,
					'revision_id' => $revisionId
				]
			);
		}
	}

	private function isOldImageRevision( $revisionTimestamp, $fileName ): bool {
		$this->output(__METHOD__ . "\n");

		return !empty(
			$this->db->selectField(
				[ 'oldimage' ],
				'1 as latest',
				[
					'oi_name' => $fileName,
					'oi_timestamp' => $revisionTimestamp
				]
			)
		);
	}
}


$maintClass = "DeleteImageRevision";
require_once( RUN_MAINTENANCE_IF_MAIN );
