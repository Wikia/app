<?php

use Wikia\Logger\WikiaLogger;
use Wikia\Rabbit\ConnectionBase;
use Wikia\Tasks\Tasks\ImageReviewTask;

class ImageReviewEventsHooks {
	const ROUTING_KEY = 'image-review.mw-context.on-upload';

	public static function onUploadComplete( UploadBase $form ) {
		global $wgCityId, $wgImageReviewTestCommunities;

		if ( in_array( $wgCityId, $wgImageReviewTestCommunities ) ) {
			// $form->getTitle() returns Title object with not updated latestRevisionId when uploading new revision
			// of the file
			$title = Title::newFromID( $form->getTitle()->getArticleID() );

			self::actionCreate( $title );
		} else {
			static::createAddTask( $form->getTitle() );
		}

		return true;
	}

	public static function onFileRevertComplete( Page $page ) {
		global $wgCityId, $wgImageReviewTestCommunities;

		if ( in_array( $wgCityId, $wgImageReviewTestCommunities ) ) {
			// $page->getTitle() returns Title object created before revert, so latestRevisionId is not updated there
			$title = Title::newFromID( $page->getTitle()->getArticleID() );
			self::actionCreate( $title );
		} else {
			static::createAddTask( $page->getTitle() );
		}

		return true;
	}

	public static function onArticleUndelete( Title $title, $created, $comment ) {
		if ( static::isFileForReview( $title ) ) {
			global $wgCityId, $wgImageReviewTestCommunities;

			if ( in_array( $wgCityId, $wgImageReviewTestCommunities ) ) {
				self::actionCreate( $title );
			} else {
				static::createAddTask( $title );
			}
		}

		return true;
	}

	public static function onArticleDeleteComplete( Page $page, User $user, $reason, $articleId ) {
		$title = $page->getTitle();

		if ( static::isFileForReview( $title ) ) {
			global $wgCityId, $wgImageReviewTestCommunities;

			if ( in_array( $wgCityId, $wgImageReviewTestCommunities ) ) {
				self::actionDelete( $articleId );
			} else {
				WikiaLogger::instance()->debug(
					'Image Review - Adding delete task',
					[
						'method' => __METHOD__,
						'title' => $title->getPrefixedText(),
					]
				);

				$task = new ImageReviewTask();
				$task->call(
					'deleteFromQueue',
					[
						[
							'wiki_id' => $wgCityId,
							'page_id' => $articleId,
						]
					]
				);
				$task->prioritize();
				$task->queue();
			}
		}

		return true;
	}

	public static function onOldFileDeleteComplete( Title $title, $oi_timestamp ) {
		global $wgCityId, $wgImageReviewTestCommunities;

		if ( in_array( $wgCityId, $wgImageReviewTestCommunities ) ) {
			$revisionId = wfGetDB( DB_SLAVE )->selectField(
				[ 'revision' ],
				'rev_id',
				[
					'rev_page' => $title->getArticleID(),
					'rev_timestamp' => $oi_timestamp
				],
				__METHOD__
			);

			self::actionDelete( $title->getArticleID(), $revisionId );
		}

		return true;
	}

	public static function onOldImageRevisionVisibilityChange( Title $title, string $oiRevision, bool $imageHidden ) {
		$oldLocalFile = OldLocalFile::newFromArchiveName(
			$title,
			RepoGroup::singleton()->getLocalRepo(),
			$oiRevision . '!' . $title->getDBkey()
		);

		$oiTimestamp = $oldLocalFile->getTimestamp();

		$revisionId = wfGetDB( DB_SLAVE )->selectField(
			[ 'revision' ],
			'rev_id',
			[
				'rev_page' => $title->getArticleID(),
				'rev_timestamp' => $oiTimestamp
			],
			__METHOD__
		);

		if ( $imageHidden ) {
			self::actionHide( $title->getArticleID(), $revisionId );
		} else {
			self::actionShow( $title, $revisionId );
		}

		return true;
	}

	private static function isFileForReview( $title ) {
		if ( $title->inNamespace( NS_FILE ) ) {
			$localFile = wfLocalFile( $title );

			return ( $localFile instanceof File ) && strpos( $localFile->getMimeType(), 'image' ) !== false;
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

	private static function actionCreate( Title $title, $revisionId = null, $action = 'created' ) {
		if ( self::isFileForReview( $title ) ) {
			global $wgImageReview, $wgCityId;

			$rabbitConnection = new ConnectionBase( $wgImageReview );
			$wamRank = ( new WAMService() )->getCurrentWamRankForWiki( $wgCityId );
			$revisionId = $revisionId ?? $title->getLatestRevID();
			$articleId = $title->getArticleID();

			$data = [
				'url' => ImageServingController::getUrl(
					'getImageUrl',
					[
						'id' => $articleId,
						'revision' => $revisionId,
					]
				),
				'userId' => RequestContext::getMain()->getUser()->getId(),
				'wikiId' => $wgCityId,
				'pageId' => $articleId,
				'revisionId' => $revisionId,
				'contextUrl' => $title->getFullURL(),
				'top200' => !empty( $wamRank ) && $wamRank <= 200,
				'action' => $action
			];

			$rabbitConnection->publish( self::ROUTING_KEY, $data );
		}
	}

	private static function actionDelete( $pageId, $revisionId = null, $action = 'deleted' ) {
		global $wgImageReview, $wgCityId;

		$rabbitConnection = new ConnectionBase( $wgImageReview );
		$data = [
			'wikiId' => $wgCityId,
			'pageId' => $pageId,
			'action' => $action
		];

		if ( !empty( $revisionId ) ) {
			$data['revisionId'] = $revisionId;
		}

		$rabbitConnection->publish( self::ROUTING_KEY, $data );
	}

	private static function actionShow( Title $title, $revisionId ) {
		self::actionCreate( $title, $revisionId, 'showed' );
	}

	private static function actionHide( $pageId, $revisionId ) {
		self::actionDelete( $pageId, $revisionId, 'hidden' );
	}
}
