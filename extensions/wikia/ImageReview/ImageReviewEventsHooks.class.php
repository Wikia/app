<?php

use \Wikia\Logger\WikiaLogger;
use \Wikia\Tasks\Tasks\ImageReviewTask;

class ImageReviewEventsHooks {
	public static function onUploadComplete( UploadBase $form ) {
		static::createAddTask( $form->getTitle() );

		return true;
	}

	public static function onFileRevertComplete( Page $page ) {
		static::createAddTask( $page->getTitle() );

		return true;
	}

	public static function onArticleUndelete( Title $title, $created, $comment ) {
		if ( static::isFileForReview( $title ) ) {
			static::createAddTask( $title );
		}

		return true;
	}

	public static function onArticleDeleteComplete( Page $page, User $user, $reason, $articleId ) {
		global $wgCityId;

		$title = $page->getTitle();

		if ( static::isFileForReview( $title ) ) {
			WikiaLogger::instance()->debug(
				'Image Review - Adding delete task',
				[
					'method' => __METHOD__,
					'title' => $title->getPrefixedText(),
				]
			);

			$task = new ImageReviewTask();
			$task->call( 'deleteFromQueue', [ [
				'wiki_id' => $wgCityId,
				'page_id' => $articleId,
			] ] );
			$task->prioritize();
			$task->queue();
		}
		return true;
	}

	private static function isFileForReview( $title ) {
		if ( $title->inNamespace( NS_FILE ) ) {
			$localFile = wfLocalFile( $title );
			return ( $localFile instanceof File );
		}

		return false;
	}

	private static function createAddTask( Title $title ) {
		global $wgCityId;

		if ( !preg_match( '/.(png|bmp|gif|jpg|ico|svg|jpeg)$/', $title->getPrefixedText() ) ) {
			return;
		}

		WikiaLogger::instance()->debug(
			'Image Review - Adding task',
			[
				'method' => __METHOD__,
				'title' => $title->getPrefixedText(),
			]
		);

		$task = new ImageReviewTask();
		$task->call( 'addToQueue' );
		$task->wikiId( $wgCityId );
		$task->title( $title );
		$task->prioritize();
		$task->queue();
	}
}
