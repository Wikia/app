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
		$service = PageStatsService::newFromTitle( $title );
		$comments = $service->getCommentsCount();

		if ( $comments && ArticleCommentInit::ArticleCommentCheckTitle( $title ) ) {
			$label = wfMessage( 'article-comments-comments' )
					->params( CommentsLikesController::formatCount( $comments ) )
					->escaped();

			array_unshift(
				$buttons,
				new Button(
					$label, '', ArticleCommentInit::getCommentsLink( $title ), 'wds-is-secondary', ''
				)
			);
		}

		return true;
	}
}
