<?php

use Wikia\Logger\WikiaLogger;
use Wikia\PageHeader\Button;

class ArticleCommentsHooks {
	/**
	 * @param Title $title
	 * @param array $buttons
	 *
	 * @return bool
	 */
	public static function onAfterPageHeaderButtons( \Title $title, array &$buttons ): bool {
		$service = PageStatsService::newFromTitle( $title );
		$comments = $service->getCommentsCount();

		if ( ArticleCommentInit::ArticleCommentCheckTitle( $title ) ) {
			if ( $comments > 0 ) {
				$label = wfMessage( 'article-comments-comments' )
					->params( CommentsLikesController::formatCount( $comments ) )
					->escaped();
			} else {
				$label = wfMessage( 'article-comments-no-comments' )
					->escaped();
			}

			array_unshift(
				$buttons,
				new Button(
					$label, '', ArticleCommentInit::getCommentsLink( $title ), 'wds-is-secondary', ''
				)
			);
		}

		return true;
	}

	public static function onLoadExtensionSchemaUpdates( DatabaseUpdater $updater ) {
		$updater->addExtensionTable( 'article_comments', MWInit::getExtensionsDirectory() . '/wikia/ArticleComments/sql/article_comments.sql' );
	}

	public static function onCommentUndelete( Title $title, $user, $reason ) {
		if ( !ArticleComment::isMappedComment( $title ) ) {
			return;
		}
		$dbKey = $title->getDBkey();
		$commentId = $title->getArticleID();
		$parts = explode( '/', $dbKey );

		$articleId = Title::newFromDBkey( $parts[0] )->getArticleID();
		if ( $articleId === 0 ) {
			// the article should have been undeleted already
			WikiaLogger::instance()->warning(
				"Undelete hook triggered for comment with no article",
				['comment_id' => $commentId] );
			return;
		}

		$parentCommentId = 0;
		if ( count( $parts ) === 3 ) {
			$parentCommentId = Title::newFromDBkey( $parts[0] . '/' . $parts[1] )->getArticleID();
			if ( $parentCommentId === 0 ) {
				// the parent should have been undeleted already
				WikiaLogger::instance()->warning(
					"Undelete hook triggered for child comment with no parent comment",
					['comment_id' => $commentId] );
				return;
			}
		}
		
		ArticleComment::addCommentMapping( $commentId, $articleId , $parentCommentId );
	}
}
