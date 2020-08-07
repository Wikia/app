<?php

use Wikia\PageHeader\Button;

class ArticleCommentsHooks {
	/**
	 * @param Title $title
	 * @param array $buttons
	 *
	 * @return bool
	 */
	public static function onAfterPageHeaderButtons( \Title $title, array &$buttons ): bool {
		if ( WikiaPageType::isActionPage() ) {
			return true;
		}

		$service = new PageStatsService( $title );
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
}
