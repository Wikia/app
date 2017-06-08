<?php

use Wikia\PageHeader\Button;

class ArticleCommentsHooks {
	public static function onAfterPageHeaderButtons( &$buttons ) {
		$title = RequestContext::getMain()->getTitle();
		$service = PageStatsService::newFromTitle( $title );
		$comments = $service->getCommentsCount();

		if ( $comments && ArticleCommentInit::ArticleCommentCheckTitle( $title ) ) {
			$label =
				wfMessage( 'article-comments-comments' )
					->params( CommentsLikesController::formatCount( $comments ) )
					->parse();
			array_unshift( $buttons,
				new Button( $label, '', ArticleCommentInit::getCommentsLink( $title ),
					'wds-is-secondary', '' ) );
		}

		return true;
	}
}
