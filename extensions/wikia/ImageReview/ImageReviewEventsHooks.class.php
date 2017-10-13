<?php

use Wikia\Logger\WikiaLogger;
use Wikia\Rabbit\ConnectionBase;

class ImageReviewEventsHooks {
	const ROUTING_KEY = 'image-review.mw-context.on-upload';

	public static function onUploadComplete( UploadBase $form ) {
		// $form->getTitle() returns Title object with not updated latestRevisionId when uploading new revision
		// of the file
		$title = Title::newFromID( $form->getTitle()->getArticleID() );

		self::actionCreate( $title ?? $form->getTitle() );

		return true;
	}

	/**
	 * Report all uploads
	 *
	 * @see https://www.mediawiki.org/wiki/Manual:Hooks/FileUpload
	 * @see SUS-2988
	 *
	 * @param LocalFile $file
	 * @return bool
	 */
	public static function onFileUpload( LocalFile $file ) {
		// SUS-2988 | log uploads and image review pushes
		WikiaLogger::instance()->info(
			__METHOD__,
			[
				'file_name' => $file->getTitle()->getPrefixedDBkey()
			]
		);

		return true;
	}

	/**
	 * This method is bound to custom hooks in Wikia features
	 *
	 * @see SUS-2988
	 *
	 * @param Title $title
	 */
	public static function addTitleToTheQueue( Title $title ) {
		static::actionCreate( $title );
	}

	public static function onFileRevertComplete( Page $page ) {
		// $page->getTitle() returns Title object created before revert, so latestRevisionId is not updated there
		$title = Title::newFromID( $page->getTitle()->getArticleID() );
		self::actionCreate( $title );

		return true;
	}

	public static function onArticleUndelete( Title $title, $created, $comment ) {
		if ( static::isFileForReview( $title ) ) {
			self::actionCreate( $title );
		}

		return true;
	}

	public static function onArticleDeleteComplete( Page $page, User $user, $reason, $articleId ) {
		$title = $page->getTitle();

		if ( static::isFileForReview( $title ) ) {
			self::actionDelete( $articleId );
		}

		return true;
	}

	public static function onOldFileDeleteComplete( Title $title, $oi_timestamp ) {
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

	public static function onCloseWikiPurgeSharedData( $wikiId ) {
		self::actionPurge( $wikiId );
		return true;
	}

	/**
	 * Push given image upload to the queue. This method is used by the re-queueing script.
	 *
	 * @see SUS-2988
	 *
	 * @param Title $title Title object of an image to be pushed to the queue
	 * @param int $revisionId
	 * @param int $userId
	 */
	public static function requeueImageUpload( Title $title, int $revisionId, int $userId ) {
		self::actionCreate( $title, $revisionId, 'created', $userId );
	}

	/**
	 * @param Title $title
	 * @return bool
	 */
	public static function isFileForReview( Title $title ) : bool {
		if ( $title->inNamespace( NS_FILE ) ) {
			$localFile = wfLocalFile( $title );

			return ( $localFile instanceof File ) && strpos( $localFile->getMimeType(), 'image' ) !== false;
		}

		return false;
	}

	/**
	 * @param Title $title
	 * @param int $revisionId
	 * @param string $action
	 * @param int $userId allow user ID that makes an upload to be forced (instead of taken from the RequestContext)
	 */
	private static function actionCreate( Title $title, $revisionId = null, $action = 'created', $userId = null ) {
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
				'userId' => $userId ?? RequestContext::getMain()->getUser()->getId(),
				'wikiId' => $wgCityId,
				'pageId' => $articleId,
				'revisionId' => $revisionId,
				'contextUrl' => $title->getFullURL(),
				'top200' => !empty( $wamRank ) && $wamRank <= 200,
				'action' => $action
			];

			$rabbitConnection->publish( self::ROUTING_KEY, $data );

			// SUS-2988 | log uploads and image review pushes
			WikiaLogger::instance()->info(
				__METHOD__,
				[
					'file_name' => $title->getPrefixedDBkey()
				]
			);
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

	private static function actionPurge( $wikiId, $action = 'purged' ) {
		global $wgImageReview;

		$rabbitConnection =  new ConnectionBase( $wgImageReview );
		$data = [
			'wikiId' => $wikiId,
			'action' => $action
		];
		$rabbitConnection->publish( self::ROUTING_KEY, $data );
	}

	private static function actionShow( Title $title, $revisionId ) {
		self::actionCreate( $title, $revisionId, 'showed' );
	}

	private static function actionHide( $pageId, $revisionId ) {
		self::actionDelete( $pageId, $revisionId, 'hidden' );
	}
}
