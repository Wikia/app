<?php

use Wikia\Logger\WikiaLogger;
use Wikia\Rabbit\ConnectionBase;
use Swagger\Client\ImageReview\Models\ImageHistoryEntry;

class ImageReviewEventsHooks {
	const ROUTING_KEY = 'image-review.mw-context.on-upload';

	public static function onImagePageAfterImageLinks( ImagePage $imagePage, &$html ) {
		global $wgCityId;

		$context = $imagePage->getContext();

		if ( !$context->getUser()->isAllowed( 'imagereviewstats' ) ) {
			return true;
		}

		if ( !$imagePage->getTitle()->exists() ) {
			return true;
		}

		$html .= Xml::element( 'h2', [], $context->msg( 'imagereview-imagepage-header' )->escaped() );

		$headers = [
			$context->msg( 'imagereview-imagepage-table-header-reviewer' )->text(),
			$context->msg( 'imagereview-imagepage-table-header-state' )->text(),
			$context->msg( 'imagereview-imagepage-table-header-time' )->text(),
		];

		$reviews = self::fetchReviewHistory( $wgCityId, $imagePage->getTitle() );

		if ( empty( $reviews ) ) {
			// image is in the queue but not reviewed yet
			$html .= $context->msg( 'imagereview-state-0' )->escaped();
		} else {
			$html .= Xml::buildTable(
				$reviews,
				[
					'class' => 'wikitable filehistory sortable',
					'style' => 'width: 60%',
				],
				$headers
			);
		}

		return true;
	}

	/**
	 * Push all uploads to image review queue.
	 *
	 * This binds to FileUpload hook and handles all uploads instead of custom hooks introduced on-per feature basis.
	 *
	 * self::actionCreate is still going to perform a check if uploaded file is an image that should pass the review.
	 *
	 * @see https://www.mediawiki.org/wiki/Manual:Hooks/FileUpload
	 * @see SUS-2988
	 * @see SUS-3045
	 *
	 * @param LocalFile $file
	 * @return bool
	 */
	public static function onFileUpload( LocalFile $file ) {
		// SUS-2988 | log uploads and image review pushes
		WikiaLogger::instance()->info(
			__METHOD__,
			[
				'file_name' => $file->getTitle()->getPrefixedDBkey(),
				'caller' => wfGetCallerClassMethod( [ __CLASS__, UploadBase::class, LocalFile::class, Hooks::class ] ),
				'file_class' => get_class( $file ),
			]
		);

		self::actionCreate( $file->getTitle() );

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


	public static function fetchReviewHistory( $cityId, Title $title ) {
		$db = wfGetDB( DB_SLAVE );
		$timestamp = wfLocalFile( $title )->getTimestamp();

		// latest revision of image is needed so we can not
		// use $title->getLatestRevisionId() as it would return
		// revision id for image description
		$revisionId = $db->selectField(
			['revision'],
			'rev_id',
			[
				'rev_page' => $title->getArticleID(),
				'rev_timestamp' => $timestamp
			]
		);

		$key = wfForeignMemcKey( $cityId, 'image-review', $title->getArticleID(), $revisionId );

		return WikiaDataAccess::cache( $key, WikiaResponse::CACHE_STANDARD, function() use( $cityId, $title, $revisionId ) {
			$statusMessages = [
				'UNREVIEWED' => wfMessage( 'imagereview-state-0' )->escaped(),
				'ACCEPTED' => wfMessage( 'imagereview-state-2' )->escaped(),
				'QUESTIONABLE' => wfMessage( 'imagereview-state-5' )->escaped(),
				'REJECTED' => wfMessage( 'imagereview-state-4' )->escaped(),
				'REMOVED' => wfMessage( 'imagereview-state-3' )->escaped()
			];

			$reviewHistory = ( new ImageReviewService() )->getImageHistory(
				$cityId,
				$title->getArticleID(),
				$revisionId,
				RequestContext::getMain()->getUser()
			);

			return array_map(
				function ( ImageHistoryEntry $item ) use ( $statusMessages ) {
					return [
						$item->getUser(),
						$statusMessages[$item->getStatus()],
						$item->getDate()
					];
				},
				array_filter(
					$reviewHistory,
					function ( ImageHistoryEntry $item ) {
						// Filter out entry with status 'UNREVIEWED' as it does
						// make sense to display entry about unreviewed status
						// with user that uploaded the file
						return $item->getStatus() != 'UNREVIEWED';
					}
				)
			);
		} );
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
			global $wgCityId;

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

			self::getRabbitConnection()->publish( self::ROUTING_KEY, $data );

			// SUS-2988 | log uploads and image review pushes
			WikiaLogger::instance()->info(
				__METHOD__,
				[
					'file_name' => $title->getPrefixedDBkey(),
					'caller' => wfGetCallerClassMethod( [ __CLASS__, UploadBase::class, LocalFile::class, Hooks::class ] )
				]
			);
		}
	}

	private static function actionDelete( $pageId, $revisionId = null, $action = 'deleted' ) {
		global $wgCityId;

		$data = [
			'wikiId' => $wgCityId,
			'pageId' => $pageId,
			'action' => $action
		];

		if ( !empty( $revisionId ) ) {
			$data['revisionId'] = $revisionId;
		}

		self::getRabbitConnection()->publish( self::ROUTING_KEY, $data );
	}

	private static function actionPurge( $wikiId, $action = 'purged' ) {
		$data = [
			'wikiId' => $wikiId,
			'action' => $action
		];
		self::getRabbitConnection()->publish( self::ROUTING_KEY, $data );
	}

	private static function actionShow( Title $title, $revisionId ) {
		self::actionCreate( $title, $revisionId, 'showed' );
	}

	private static function actionHide( $pageId, $revisionId ) {
		self::actionDelete( $pageId, $revisionId, 'hidden' );
	}

	private static $rabbitConnection = null;

	/**
	 * Cache the connection to RabbitMQ
	 *
	 * @return ConnectionBase
	 */
	private static function getRabbitConnection() : ConnectionBase {
		global $wgImageReview;

		if ( is_null( self::$rabbitConnection ) ) {
			self::$rabbitConnection = new ConnectionBase($wgImageReview);
		}

		return self::$rabbitConnection;
	}
}
