<?php

use Wikia\CreateNewWiki\Tasks\TaskContext;

/**
 * Import a set of pages into the wiki database in a bulk operation
 */
class BulkRevisionImporter {
	/** @var TaskContext $taskContext */
	private $taskContext;

	/** @var Title $mainPage */
	private $mainPage;

	/** @var Title[] $titles */
	private $titles;

	/** @var WikiRevision[] $revisions */
	private $revisions;

	public function __construct( TaskContext $taskContext ) {
		$this->taskContext = $taskContext;
		$this->mainPage = Title::newMainPage();
	}

	public function addRevision( WikiRevision $revision ) {
		$this->revisions[] = $revision;
		$this->titles[$revision->getTitle()->getPrefixedDBkey()] = $revision->getTitle();
	}

	/**
	 * Actually import the provided revisions into the database
	 * @return int number of pages imported
	 * @throws DBQueryError
	 * @throws MWException
	 */
	public function doBulkImport(): int {
		$pageIds = $this->createPages();
		$this->createAndLinkRevisions( $pageIds );

		return count( $pageIds );
	}

	/**
	 * Create the pages for the revisions to be imported in a single operation
	 * @return int[] newly inserted page IDs
	 */
	private function createPages(): array {
		$dbw = wfGetDB( DB_MASTER );

		$pageIds = [];
		$rows = [];

		$now = $dbw->timestamp();
		$pageId = 1;

		foreach ( $this->titles as $title ) {
			$rows[] = [
				// The database is completely pristine at this stage
				// so we can pick our own article IDs without making assumptions
				// about MySQL's auto_increment
				'page_id' => ++$pageId,
				'page_namespace' => $title->getNamespace(),
				'page_title' => $title->getDBkey(),
				'page_restrictions' => '',
				'page_is_redirect' => 0,
				'page_is_new' => 1,
				'page_random' => wfRandom(),

				// Will be updated after revisions import
				'page_touched' => $now,
				'page_latest' => 0,
				'page_len' => 0,
			];

			$pageIds[$title->getPrefixedDBkey()] = $pageId;
		}

		$dbw->begin( __METHOD__ );
		$dbw->insert( 'page', $rows, __METHOD__ );
		$dbw->commit( __METHOD__ );

		return $pageIds;
	}

	/**
	 * Import revision data into the database and link them to the newly created pages
	 *
	 * @param int[] $pageIds
	 * @throws DBQueryError
	 * @throws MWException
	 */
	private function createAndLinkRevisions( array $pageIds ) {
		$dbw = wfGetDB( DB_MASTER );

		$robot = User::idFromName( Wikia::USER );

		$textId = 1;
		$flags = 'utf-8,gzip';

		$old = [];
		$rows = [];

		foreach ( $this->revisions as $revision ) {
			$text = $this->getRevisionText( $revision );

			// Insert the imported revision text into the local text table
			$old[] = [
				'old_id' => ++$textId,
				'old_text' => gzdeflate( $text ),
				'old_flags' => $flags
			];

			$rows[] = [
				'rev_page' => $pageIds[$revision->getTitle()->getPrefixedDBkey()],
				'rev_comment' => $revision->getComment(),
				'rev_user' => $robot,
				'rev_user_text' => '',
				'rev_text_id' => $textId,
				'rev_timestamp' => wfTimestampNow(),
				'rev_minor_edit' => $revision->getMinor(),
				'rev_len' => strlen( $text ),
				'rev_sha1' => Revision::base36Sha1( $text )
			];
		}

		$dbw->begin( __METHOD__ );

		$dbw->insert( 'text', $old, __METHOD__ );
		$dbw->insert( 'revision', $rows, __METHOD__ );

		// Now actually link the imported revisions and the page entries
		// Our page entries will have page_latest = 0 so we can use that + the rev_page relationship
		// to update all of them in a single statement
		$dbw->query( 'UPDATE page, revision SET page_latest=rev_id, page_touched=rev_timestamp, page_len=rev_len WHERE page_id=rev_page AND page_latest = 0' );

		$dbw->commit( __METHOD__ );
	}

	/**
	 * Get the revision text to be saved into the database and modify it accordingly for the main page.
	 *
	 * @param WikiRevision $revision
	 * @return string
	 */
	private function getRevisionText( WikiRevision $revision ): string {
		$text = $revision->getText();

		if ( $this->mainPage->equals( $revision->getTitle() ) ) {
			global $wgParser;

			$description = $this->taskContext->getDescription();
			$matches = [];

			if ( preg_match( '/={2,3}[^=]+={2,3}/', $text, $matches ) ) {
				$newSectionTitle = str_replace( 'Wiki', $this->taskContext->getSiteName(), $matches[ 0 ] );
				$description = "{$newSectionTitle}\n{$description}";
			}

			return $wgParser->replaceSection( $text, 1, $description );
		}

		return $text;
	}
}
