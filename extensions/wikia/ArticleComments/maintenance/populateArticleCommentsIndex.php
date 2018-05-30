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
		
		// get all talk pages
		// TODO: full list of supported namespaces
		$comments = $db->select( 'page', ['page_id', 'page_title'], ['page_namespace' => NS_TALK], __METHOD__ );
		$totalCount = $comments->numRows();

		$this->output( $dbName . ': Selected ' .  $totalCount . " comments\n" );

		$count = 0;
		foreach ( $comments as $c ) {
			$titleParts = explode( '/', $c->page_title );
			$articleId = $this->getPageId( $titleParts[0], NS_MAIN );
			$parentCommentId = 0;
			if ( count( $titleParts ) === 3 ) {
				$parentTitle = $titleParts[0] . '/' . $titleParts[1];
				$parentCommentId = $this->getPageId( $parentTitle, NS_TALK );
			}
			$this->addCommentMapping( $c->page_id, $articleId, $parentCommentId);

			if ( ++$count % 1000 === 0 ) {
				$this->output( $dbName . ': ' . $count . ' out of ' . $totalCount . " processed\n" );
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


}

$maintClass = PopulateArticleCommentsIndex::class;
require_once( RUN_MAINTENANCE_IF_MAIN );
