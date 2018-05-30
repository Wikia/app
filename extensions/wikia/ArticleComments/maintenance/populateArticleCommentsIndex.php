<?php

require_once( __DIR__ . '/../../../../maintenance/Maintenance.php' );

class PopulateArticleCommentsIndex extends Maintenance {

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
			__METHOD__);
		$totalCount = $comments->numRows();

		$this->output( $dbName . ': Selected ' .  $totalCount . " comments\n" );

		$count = 0;
		foreach ( $comments as $c ) {
			$commentNs = $c->page_namespace;
			if ( MWNamespace::isSubject( $commentNs ) ) {
				// this should be a talk page
				continue;
			}

			$titleParts = explode( '/', $c->page_title );
			$articleId = Title::newFromDBkey( $titleParts[0] )->getArticleID();
			if ( empty( $articleId ) ) {
				// if the parent article doesn't exist, we don't care about the comment
				continue;
			}

			$parentCommentId = 0;
			if ( count( $titleParts ) === 3 ) {
				$parentTitle = $titleParts[0] . '/' . $titleParts[1];
				$parentCommentId = Title::newFromDBkey( $parentTitle )->getArticleID();
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

}

$maintClass = PopulateArticleCommentsIndex::class;
require_once( RUN_MAINTENANCE_IF_MAIN );
