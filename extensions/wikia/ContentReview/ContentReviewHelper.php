<?php

namespace Wikia\ContentReview;

use Wikia\Interfaces\IRequest;
use Wikia\ContentReview\Models\CurrentRevisionModel;
use Wikia\ContentReview\Models\ReviewModel;

class Helper extends \ContextSource {

	const CONTENT_REVIEW_TOOLBAR_TEMPLATE_PATH = 'extensions/wikia/ContentReview/templates/ContentReviewToolbar.mustache';
	const CONTENT_REVIEW_PARAM = 'contentreview';
	const CONTENT_REVIEW_MEMC_VER = '1.0';
	const CONTENT_REVIEW_REVIEWED_KEY = 'reviewed-js-pages';
	const CONTENT_REVIEW_CURRENT_KEY = 'current-js-pages';
	const JS_FILE_EXTENSION = '.js';

	const DEV_WIKI_ID = 7931;


	/**
	 * Returns data about all approved revisions (of JS pages) for current wiki
	 *
	 * @return bool|array
	 */
	public function getReviewedJsPages() {
		global $wgCityId;

		$currentRevisionModel = new Models\CurrentRevisionModel();
		$revisions = $currentRevisionModel->getLatestReviewedRevisionForWiki( $wgCityId );

		return $revisions;
	}

	/**
	 * Return data about all JS pages on current wiki
	 *
	 * @return bool|mixed
	 */
	public function getJsPages() {
		$db = wfGetDB( DB_SLAVE );

		$jsPages = ( new \WikiaSQL() )
			->SELECT( 'page_id', 'page_title', 'page_touched', 'page_latest' )
			->FROM( 'page' )
			->WHERE( 'page_namespace' )->EQUAL_TO( NS_MEDIAWIKI )
			->AND_( 'LOWER (page_title)' )->LIKE( '%' . self::JS_FILE_EXTENSION )
			->runLoop( $db, function ( &$jsPages, $row ) {
				$jsPages[$row->page_id] = get_object_vars( $row );
				$jsPages[$row->page_id]['ts'] = wfTimestamp( TS_UNIX, $row->page_touched );
			} );

		return $jsPages;

	}

	/**
	 * Returns timestamp of last approved revision
	 *
	 * @return int
	 */
	public function getReviewedJsPagesTimestamp() {
		$timestamp = \WikiaDataAccess::cache(
			$this->getMemcKey( self::CONTENT_REVIEW_REVIEWED_KEY ),
			\WikiaResponse::CACHE_STANDARD, // 60 * 60 * 24
			function() {
				$pages = $this->getReviewedJsPages();

				return $this->getMaxTimestamp( $pages );
			}
		);

		return $timestamp;
	}

	/**
	 * Returns timestamp of last edited JS page
	 *
	 * @return int
	 */
	public function getJsPagesTimestamp() {
		$timestamp = \WikiaDataAccess::cache(
			$this->getMemcKey( self::CONTENT_REVIEW_CURRENT_KEY ),
			\WikiaResponse::CACHE_STANDARD, // 60 * 60 * 24
			function() {
				$pages = $this->getJsPages();

				return $this->getMaxTimestamp( $pages );
			}
		);

		return $timestamp;
	}

	/**
	 * Returns max timestamp
	 *
	 * @param $pages
	 * @return int
	 */
	public function getMaxTimestamp( $pages ) {
		$maxTimestamp = 0;

		foreach ( $pages as $page ) {
			$maxTimestamp = max( $maxTimestamp, $page['ts'] );
		}

		if ( empty( $maxTimestamp ) ) {
			return 0;
		}

		return $maxTimestamp;
	}

	/**
	 * Returns approved revision id for given page.
	 * If there is no reviewed revision it returns 0.
	 *
	 * @param int $pageId
	 * @param int $wikiId
	 * @return int
	 */
	public function getReviewedRevisionId( $pageId, $wikiId = 0 ) {
		global $wgCityId;

		if ( empty( $wikiId ) ) {
			$wikiId = $wgCityId;
		}

		$currentRevisionModel = new Models\CurrentRevisionModel();
		$revision = $currentRevisionModel->getLatestReviewedRevision( $wikiId, $pageId );

		if ( is_null( $revision['revision_id'] ) ) {
			return 0;
		}

		return $revision['revision_id'];
	}

	/**
	 * Returns wiki ids on which user is in test mode
	 *
	 * @return array|mixed
	 */
	public function getContentReviewTestModeWikis() {
		$key = \ContentReviewApiController::CONTENT_REVIEW_TEST_MODE_KEY;
		$wikiIds = $this->getRequest()->getSessionData( $key );

		if ( !empty( $wikiIds ) ) {
			$wikiIds = unserialize( $wikiIds );
		} else {
			$wikiIds = [];
		}

		return $wikiIds;
	}

	/**
	 * Enable test mode on provided wiki
	 * @param int $wikiId
	 */
	public function setContentReviewTestMode( $wikiId ) {
		$wikiIds = $this->getContentReviewTestModeWikis();

		if ( !in_array( $wikiId, $wikiIds ) ) {
			$wikiIds[] = $wikiId;
			$this->getRequest()->setSessionData(
				\ContentReviewApiController::CONTENT_REVIEW_TEST_MODE_KEY,
				serialize( $wikiIds )
			);
		}
	}

	/**
	 * Disable test mode on provided wiki
	 * @param int $wikiId
	 */
	public function disableContentReviewTestMode( $wikiId ) {;
		$wikiIds = $this->getContentReviewTestModeWikis();
		$wikiKey = array_search( $wikiId, $wikiIds );

		if ( $wikiKey !== false ) {
			unset( $wikiIds[$wikiKey] );
			$this->getRequest()->setSessionData(
				\ContentReviewApiController::CONTENT_REVIEW_TEST_MODE_KEY,
				serialize( $wikiIds )
			);
		}
	}

	/**
	 * Checks if test mode is enabled on current or given wiki
	 *
	 * @param int $wikiId
	 * @return bool
	 */
	public function isContentReviewTestModeEnabled( $wikiId = 0 ) {
		global $wgCityId;

		if ( empty( $wikiId ) ) {
			$wikiId = $wgCityId;
		}

		$wikisIds = $this->getContentReviewTestModeWikis();
		return ( !empty( $wikisIds ) && in_array( $wikiId, $wikisIds ) );
	}

	public static function isStatusAwaiting( $status ) {
		return in_array( (int)$status, [
				ReviewModel::CONTENT_REVIEW_STATUS_UNREVIEWED,
				ReviewModel::CONTENT_REVIEW_STATUS_IN_REVIEW,
			]
		);
	}

	public static function isStatusCompleted( $status ) {
		return in_array( (int)$status, [
				ReviewModel::CONTENT_REVIEW_STATUS_APPROVED,
				ReviewModel::CONTENT_REVIEW_STATUS_REJECTED,
			]
		);
	}

	public function isDiffPageInReviewProcess( \WikiaRequest $request, ReviewModel $reviewModel, $wikiId, $pageId, $diff ) {
		/**
		 * Do not hit database if there is a URL parameter that indicates that a user
		 * came directly from Special:ContentReview.
		 */
		if ( $request->getInt( self::CONTENT_REVIEW_PARAM ) === 1 ) {
			return true;
		}

		$reviewData = $reviewModel->getReviewOfPageByStatus( $wikiId, $pageId, ReviewModel::CONTENT_REVIEW_STATUS_IN_REVIEW );
		return ( !empty( $reviewData ) && (int)$reviewData['revision_id'] === $diff );
	}

	public function hasPageApprovedId( CurrentRevisionModel $model, $wikiId, $pageId, $oldid ) {
		$currentData = $model->getLatestReviewedRevision( $wikiId, $pageId );
		return ( !empty( $currentData ) && (int)$currentData['revision_id'] === $oldid );
	}

	public function shouldDisplayReviewerToolbar() {
		global $wgCityId;

		$title = $this->getTitle();
		$contentReviewRequest = $this->getRequest()->getBool( self::CONTENT_REVIEW_PARAM );

		if ( $title->inNamespace( NS_MEDIAWIKI )
			&& $contentReviewRequest
			&& $title->isJsPage()
			&& $title->userCan( 'content-review' )
		) {
			$reviewModel = new ReviewModel();

			$diffRevisionId = $this->getRequest()->getInt( 'diff' );
			$articleId = $title->getArticleID();
			$diffRevisionInfo = $reviewModel->getRevisionInfo(
				$wgCityId,
				$articleId,
				$diffRevisionId
			);

			$status = (int)$diffRevisionInfo['status'];

			// Always make sure it's in review if this is a content review request
			if ( $status === ReviewModel::CONTENT_REVIEW_STATUS_UNREVIEWED ) {
				$reviewerId = $this->getUser()->getId();
				try {
					$reviewModel->updateRevisionStatus( $wgCityId, $articleId, $status,
						ReviewModel::CONTENT_REVIEW_STATUS_IN_REVIEW, $reviewerId );
				} catch ( \FluentSql\Exception\SqlException $e ) {
					// Master-slave replication has not finished, ignore
				}

				return true;
			}

			return ( $status === ReviewModel::CONTENT_REVIEW_STATUS_IN_REVIEW );
		}

		return false;
	}

	/**
	 * Returns an HTML with a toolbar displayed to reviewers.
	 * @param int $revisionId An ID of the revision that is currently being reviewed
	 * @return string
	 * @throws \Exception
	 */
	public function getToolbarTemplate( $revisionId ) {
		global $wgCityId;

		return \MustacheService::getInstance()->render(
			self::CONTENT_REVIEW_TOOLBAR_TEMPLATE_PATH,
			[
				'toolbarTitle' => wfMessage( 'content-review-diff-toolbar-title' )->plain(),
				'wikiId' => $wgCityId,
				'pageId' => $this->getTitle()->getArticleID(),
				'approveStatus' => ReviewModel::CONTENT_REVIEW_STATUS_APPROVED,
				'buttonApproveText' => wfMessage( 'content-review-diff-approve' )->plain(),
				'rejectStatus' => ReviewModel::CONTENT_REVIEW_STATUS_REJECTED,
				'buttonRejectText' => wfMessage( 'content-review-diff-reject' )->plain(),
				'talkpageUrl' => $this->prepareProvideFeedbackLink( $this->getTitle(), $revisionId ),
				'talkpageLinkText' => wfMessage( 'content-review-diff-toolbar-talkpage' )->plain(),
				'guidelinesUrl' => wfMessage( 'content-review-diff-toolbar-guidelines-url' )->useDatabase( false )->plain(),
				'guidelinesLinkText' => wfMessage( 'content-review-diff-toolbar-guidelines' )->plain(),
			]
		);
	}

	/**
	 * Link for adding new section on script talk page. Prefilled with standard explanation of rejection.
	 * @param \Title $title Title object of JS page
	 * @param int $revisionId
	 * @return string full link to edit page
	 */
	public function prepareProvideFeedbackLink( \Title $title, $revisionId = 0 ) {
		$params = [
			'action' => 'edit',
			'section' => 'new',
			'useMessage' => 'content-review-rejection-explanation',
		];

		if ( (int)$revisionId !== 0 ) {
			$params['messageParams'] = [
				1 => wfMessage( 'content-review-rejection-explanation-title' )->params( $revisionId )->escaped(),
				2 => $title->getFullURL( "oldid={$revisionId}" ),
				3 => $revisionId,
			];
		}

		return $title->getTalkPage()->getFullURL( $params );
	}

	/**
	 * Returns an ID of a revision that is currently being reviewed. It is either a value of
	 * `diff` URL parameter or `oldid` if `diff` is not present.
	 * @param IRequest $request An object of a class implementing the IRequest interface
	 * @return null|int
	 */
	public function getCurrentlyReviewedRevisionId( IRequest $request ) {
		$revisionId = $request->getVal( 'diff' );
		if ( $revisionId === null ) {
			$revisionId = $request->getVal( 'oldid' );
		}
		return $revisionId;
	}

	public function purgeReviewedJsPagesTimestamp() {
		\WikiaDataAccess::cachePurge( $this->getMemcKey( self::CONTENT_REVIEW_REVIEWED_KEY ) );
	}

	public function purgeCurrentJsPagesTimestamp() {
		\WikiaDataAccess::cachePurge( $this->getMemcKey( self::CONTENT_REVIEW_CURRENT_KEY ) );
	}

	public function getMemcKey( $params ) {
		return wfMemcKey( self::CONTENT_REVIEW_PARAM, self::CONTENT_REVIEW_MEMC_VER, $params );
	}

	protected function getRevisionById( $revId ) {
		return \Revision::newFromId( $revId );
	}

	protected function getCurrentRevisionModel() {
		return new CurrentRevisionModel();
	}

	/**
	 * Replaces $text with text from last approved revision
	 * Change is done only for JS pages.
	 * If there's no approved revision replaces with empty string
	 * @param \Title $title
	 * @param string $contentType
	 * @param string $text
	 * @return String
	 */
	public function replaceWithLastApproved( \Title $title, $contentType, $text ) {
		global $wgCityId;

		if ( $this->isPageReviewed( $title, $contentType ) ) {
			$pageId = $title->getArticleID();
			$latestRevId = $title->getLatestRevID();
			$latestReviewedRevData = $this->getCurrentRevisionModel()->getLatestReviewedRevision( $wgCityId, $pageId );

			if ( $latestReviewedRevData['revision_id'] !== $latestRevId
				&& !$this->isContentReviewTestModeEnabled()
			) {
				$revision = $this->getRevisionById( $latestReviewedRevData['revision_id'] );

				if ( $revision instanceof \Revision ) {
					return $revision->getRawText();
				}

				return '';
			}
		}

		return $text;
	}

	/**
	 * Checks if a user can edit a JS page in the MediaWiki namespace.
	 * @param \Title $title
	 * @param \User $user
	 * @return bool
	 */
	public function userCanEditJsPage( \Title $title, \User $user ) {
		return $title->isJsPage()
			&& $title->userCan( 'edit', $user );
	}

	/**
	 * Checks if a user is a reviewer entitled to an automatic approval and if he requested it.
	 *
	 * The wpApprove request param that appears here is a value of a checkbox which is part of
	 * the EditPageLayout for reviewers. It is displayed above the Publish button and allows a reviewer
	 * to make a decision of skipping the review process.
	 *
	 * @param \User $user
	 * @return bool
	 */
	public function userCanAutomaticallyApprove( \User $user ) {
		return $user->isAllowed( 'content-review' )
			&& $user->getRequest()->getBool( 'wpApprove' );
	}

	/**
	 * Checks if a page should be even consider for content replacement with an approved revision.
	 * @param \Title $title
	 * @param $contentType
	 * @return bool
	 */
	public function isPageReviewed( \Title $title, $contentType ) {
		global $wgJsMimeType;

		return $title->isJsPage()
			|| $title->inNamespace( NS_MEDIAWIKI ) && $contentType === $wgJsMimeType;
	}
}
