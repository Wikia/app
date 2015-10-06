<?php

namespace Wikia\ContentReview;

use Wikia\ContentReview\Models\ReviewModel;

class ContentReviewStatusesService extends \WikiaService {

	const 	STATUS_NONE = 'none',
			STATUS_LIVE = 'live',
			STATUS_AWAITING = 'awaiting',
			STATUS_REJECTED = 'rejected',
			STATUS_APPROVED = 'approved',
			STATUS_UNSUBMITTED = 'unsubmitted';

	const	CONTENT_REVIEW_STATUSES_MEMC_KEY = 'content-review-statuses',
			CONTENT_REVIEW_STATUSES_MEMV_VERSION = '1.02';

	/**
	 * Gets revisions statuses for all JS pages on given wiki
	 *
	 * @param int $wikiId
	 * @return bool|array
	 */
	public function getJsPagesStatuses( $wikiId ) {
		$jsPages = \WikiaDataAccess::cache(
			$this->getJsPagesMemcKey(),
			259200, // 3 * 24 * 60 * 60
			function() use( $wikiId ) {
				$helper = new Helper();
				$jsPages = $helper->getJsPages();

				$reviewModel = new Models\ReviewModel();
				$statuses = $reviewModel->getPagesStatuses( $wikiId );

				$jsPages = $this->prepareData( $jsPages, $statuses );

				return $jsPages;
			}
		);

		return $jsPages;
	}

	/**
	 * Gets revision statuses for given JS page
	 *
	 * @param int $wikiId
	 * @param int $pageId
	 * @return array
	 */
	public function getJsPageStatus( $wikiId, $pageId ) {
		$jsPage = [];

		$jsPages = $this->getJsPagesStatuses( $wikiId );

		if ( isset( $jsPages[$pageId] ) ) {
			$jsPage = $jsPages[$pageId];
		}

		return $jsPage;
	}

	/**
	 * Prepares data about revision statuses
	 *
	 * @param array $jsPages contains basic information about page like id, title, last revision and last touched
	 * @param array $statuses contains data about all js pages revisions on which any of review action
	 *				was taken (submit to review, start review, reject or approve).
	 *				[IMPORTANT] Revisions are grouped by page id and ordered from latest action to oldest.
	 *				ie. [
	 * 					...
	 * 					pageId => [
	 * 						[submited to review] => revision #112 -> latest
	 *						[rejected] => revision #109
	 *						[approved] => revision #100 - oldest
	 * 					],
	 * 					...
	 *				]
	 * @return array
	 */
	public function prepareData( $jsPages, $statuses ) {
		foreach ( $jsPages as $pageId => &$page ) {
			$page = $this->preparePageStatuses( $pageId, $page, $statuses );
		}

		return $jsPages;
	}

	/**
	 * Compares and prepare information about statuses for each of revisions for given page
	 * @see prepareData
	 *
	 * @param int $pageId
	 * @param array $page
	 * @param array $statuses
	 * @return array
	 * @throws \MWException (Title::newFromText)
	 */
	public function preparePageStatuses( $pageId, $page, $statuses ) {
		$liveRevisionId = 0;
		$title = \Title::newFromText( $page['page_title'], NS_MEDIAWIKI );

		$page += $this->initPageData( $title );

		if ( isset( $statuses[$pageId] ) ) {
			$liveRevisionId = $this->getLiveRevision( $statuses[$pageId] );

			foreach( $statuses[$pageId] as $status => $revisionId ) {
				// Check revisions which are waiting for review or in review process
				// In these states revision can be only in "latest revision" section
				if ( Helper::isStatusAwaiting( $status ) && empty( $page['latestRevision']['revisionId'] ) ) {
					$page['latestRevision'] = $this->prepareRevisionData(
						$title,
						self::STATUS_AWAITING,
						$revisionId,
						$liveRevisionId
					);
					// Check revisions for which review process is completed
				} elseif ( Helper::isStatusCompleted( $status ) ) {
					$statusKey = $this->getStatusKey( $status );

					// Prepare data for last reviewed revision (can be approved or rejected)
					if ( empty( $page['latestReviewed']['revisionId'] ) ) {
						$page['latestReviewed'] = $this->prepareRevisionData(
							$title,
							$statusKey,
							$revisionId,
							$liveRevisionId
						);
					}

					// If revision is approved it means it's live
					if ( $statusKey === self::STATUS_APPROVED ) {
						$statusKey = self::STATUS_LIVE;

						// Prepare data for live revision
						$page['liveRevision'] = $this->prepareRevisionData(
							$title,
							$statusKey,
							$revisionId,
							$liveRevisionId
						);
					}

					// Prepare data for latest revision section
					if ( empty( $page['latestRevision']['revisionId'] ) ) {
						$page['latestRevision'] =  $this->prepareRevisionData(
							$title,
							$statusKey,
							$revisionId,
							$liveRevisionId
						);
					}
				}
			}
		}

		$latestRevisionId = isset( $page['latestRevision']['revisionId'] ) ? $page['latestRevision']['revisionId'] : 0;

		// If latest revision is not equal last touched revision it means that must be submited for review
		if ( $page['page_latest'] != $latestRevisionId ) {
			$page['latestRevision'] = $this->prepareRevisionData(
				$title,
				self::STATUS_UNSUBMITTED,
				$page['page_latest'],
				$liveRevisionId
			);

			if ( $title->userCan( 'edit' ) ) {
				$page['submit'] = true;
			}
		}

		return $page;
	}

	/**
	 * Returns status key based on status
	 *
	 * @param int $status
	 * @return string
	 */
	public function getStatusKey( $status = 0 ) {
		switch ( $status ) {
			case 1:
			case 2:
				$statusKey = self::STATUS_AWAITING;
				break;
			case 3:
			case 5:
				$statusKey = self::STATUS_APPROVED;
				break;
			case 4:
				$statusKey = self::STATUS_REJECTED;
				break;
			default:
				$statusKey = self::STATUS_NONE;
		}

		return $statusKey;
	}

	/**
	 * Gets live revision id
	 *
	 * Live revision is revision which was last approved or auto approved
	 * Returns 0 if there is no live revision
	 *
	 * @param array $pageStatuses
	 * @return int
	 */
	public function getLiveRevision( $pageStatuses ) {
		if ( isset( $pageStatuses[ReviewModel::CONTENT_REVIEW_STATUS_APPROVED] ) ) {
			return $pageStatuses[ReviewModel::CONTENT_REVIEW_STATUS_APPROVED];
		}

		if ( isset( $pageStatuses[ReviewModel::CONTENT_REVIEW_STATUS_AUTOAPPROVED] ) ) {
			return $pageStatuses[ReviewModel::CONTENT_REVIEW_STATUS_AUTOAPPROVED];
		}

		return 0;
	}

	/**
	 * Prepares params for diff revision link
	 *
	 * @param int $revisionId
	 * @param int $liveRevisionId
	 * @return array
	 */
	public function prepareRevisionLinkParams( $revisionId, $liveRevisionId = 0 ) {
		$params = [];

		if ( !empty( $liveRevisionId ) ) {
			$params['oldid'] = $liveRevisionId;

			if ( $revisionId !== $liveRevisionId ) {
				$params['diff'] = $revisionId;
			}
		} else {
			$params['oldid'] = $revisionId;
		}

		return $params;
	}

	public static function purgeJsPagesCache() {
		\WikiaDataAccess::cachePurge( self::getJsPagesMemcKey() );
	}

	protected function initPageData( \Title $title ) {
		$statusNoneMsg = $this->getStatusMessage();

		return [
			'pageLink' => $this->createPageLink( $title ),
			'pageName' => $title->getFullText(),
			'latestRevision' => [
				'statusKey' => self::STATUS_NONE,
				'message' => $statusNoneMsg
			],
			'latestReviewed' => [
				'statusKey' => self::STATUS_NONE,
				'message' => $statusNoneMsg
			],
			'liveRevision' => [
				'statusKey' => self::STATUS_NONE,
				'message' => $statusNoneMsg
			]
		];
	}

	/**
	 * Prepares data for given revision
	 *
	 * @param \Title $title
	 * @param string $statusKey
	 * @param int $revisionId
	 * @param int $liveRevisionId
	 * @return array
	 */
	private function prepareRevisionData( \Title $title, $statusKey, $revisionId, $liveRevisionId = 0 ) {
		$data = [
			'revisionId' => $revisionId,
			'statusKey' => $statusKey,
			'message' => $this->getStatusMessage( $statusKey ),
			'diffLink' => '',
			'reasonLink' => ''
		];

		if ( !empty( $revisionId ) ) {
			$data['diffLink'] = $this->createRevisionLink( $title, $revisionId, $liveRevisionId );
			if ( $statusKey === self::STATUS_REJECTED ) {
				$data['reasonLink'] = $this->createRevisionTalkpageLink( $title );
			}
		} elseif ( !empty( $liveRevisionId ) ) {
			$data['diffLink'] = $this->createRevisionLink( $title, $liveRevisionId );
		}

		return $data;
	}

	public function createPageLink( \Title $title ) {
		return \Html::element( 'a', [ 'href' => $title->getFullURL() ], $title->getText() );
	}

	private function createRevisionLink( \Title $title, $revisionId, $liveRevisionId = 0 ) {
		$params = $this->prepareRevisionLinkParams( $revisionId, $liveRevisionId );

		return \Html::element( 'a', [ 'href' => $title->getFullURL( $params ) ], "#{$revisionId}" );
	}

	private function createRevisionTalkpageLink( \Title $title ) {
		return \Html::element(
			'a',
			[ 'href' => $title->getTalkPage() ],
			wfMessage( 'content-review-rejection-reason-link' )->escaped()
		);
	}

	private function getStatusMessage( $statusKey = self::STATUS_NONE ) {
		return wfMessage( "content-review-module-status-{$statusKey}" )->escaped();
	}

	private static function getJsPagesMemcKey() {
		return wfMemcKey(
			self::CONTENT_REVIEW_STATUSES_MEMC_KEY,
			self::CONTENT_REVIEW_STATUSES_MEMV_VERSION
		);
	}
}
