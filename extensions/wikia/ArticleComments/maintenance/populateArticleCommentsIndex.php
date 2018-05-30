<?php

require_once( __DIR__ . '/../../../../maintenance/Maintenance.php' );

class PopulateArticleCommentsIndex extends Maintenance {

	private $pageCache = [];

	public function __construct() {
		parent::__construct();
		$this->mDescription = "Populates the article_comments table with the current article->comment mapping";
	}


	public function execute() {
		$db = $this->getDB( DB_SLAVE );
		$dbName = $db->getDBname();
		
		// get all comments
		$comments = $db->select(
			'page',
			['page_id', 'page_title', 'page_namespace'],
			['page_title ' . $db->buildLike( $db->anyString(), '@comment', $db->anyString() )],
			__METHOD__ );
		$totalCount = $comments->numRows();

		$this->output( $dbName . ': Selected ' .  $totalCount . " comments\n" );

		$count = 0;
		foreach ( $comments as $c ) {
			// this should be a talk page
			$commentNs = $c->page_namespace;
			if ( $this->isNotTalk( $commentNs ) ) {
				continue;
			}
			// talk pages have namespaces next to their parent pages (talk ns = parent ns + 1)
			$parentNs = $commentNs - 1;
			$titleParts = explode( '/', $c->page_title );
			$articleId = $this->getPageId( $titleParts[0], $parentNs );
			$parentCommentId = 0;
			if ( count( $titleParts ) === 3 ) {
				$parentTitle = $titleParts[0] . '/' . $titleParts[1];
				$parentCommentId = $this->getPageId( $parentTitle, $commentNs );
			}
			$this->addCommentMapping( $c->page_id, $articleId, $parentCommentId);

			if ( ++$count % 1000 === 0 ) {
				$this->output( $dbName . ': ' . $count . ' out of ' . $totalCount . " processed\n" );
				wfWaitForSlaves();
			}
		}

		$this->output( $dbName . ": Done!\n" );
	}

	private function addCommentMapping( $commentId, $articleId, $parentCommentId ) {
		$dbr = wfGetDB( DB_SLAVE );
		$dbw = wfGetDB( DB_MASTER );
		$existingMapping = $dbr->select( 'article_comments', '*', ['comment_id' => $commentId], __METHOD__ );
		if ( $existingMapping->numRows() === 0) {
			$dbw->insert(
				'article_comments',
				['comment_id' => $commentId, 'article_id' => $articleId, 'parent_comment_id' => $parentCommentId],
				__METHOD__);
		}
	}

	// $pageNamespace is needed to use the existing index for the select
	private function getPageId( $pageTitle, $pageNamespace ) {
		if ( empty( $this->pageCache[$pageTitle] ) ) {
			$db = $this->getDB( DB_SLAVE );
			$pageId = $db->selectField( 'page', 'page_id', ['page_title' => $pageTitle, 'page_namespace' => $pageNamespace], __METHOD__ );
			if ( empty( $pageId ) ) {
				$this->pageCache[$pageTitle] = 0;
			} else {
				$this->pageCache[$pageTitle] = $pageId;
			}
		}
		return $this->pageCache[$pageTitle];
	}

	private function isNotTalk( $namespace ) {
		return $namespace < 1 || ( $namespace % 2 === 0 );
	}


}

$maintClass = PopulateArticleCommentsIndex::class;
require_once( RUN_MAINTENANCE_IF_MAIN );
