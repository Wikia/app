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

	public function getJsPagesStatuses( $wikiId ) {
		$helper = new Helper();
		$jsPages = $helper->getJsPages();

		$reviewModel = new Models\ReviewModel();
		$statuses = $reviewModel->getPagesStatuses( $wikiId );

		$jsPages = $this->prepareData( $jsPages, $statuses );

		return $jsPages;
	}

	public function getJsPageStatus( $wikiId, $pageId ) {
		$jsPage = [];

		$jsPages = $this->getJsPagesStatuses( $wikiId );

		if ( isset( $jsPages[$pageId] ) ) {
			$jsPage = $jsPages[$pageId];
		}

		return $jsPage;
	}

	private function prepareData( $jsPages, $statuses ) {
		if ( !empty( $statuses ) ) {
			foreach ( $jsPages as $pageId => &$page ) {
				$page += $this->initPageData();

				$title = \Title::newFromText( $page['page_title'], NS_MEDIAWIKI );

				$page['pageLink'] = $this->createPageLink( $title );

				if ( isset( $statuses[$pageId] ) ) {
					$liveRevisionId = $this->getLiveRevision( $statuses[$pageId] );

					foreach( $statuses[$pageId] as $status => $revId ) {
						if ( Helper::isStatusAwaiting( $status ) && empty( $page['latestRevision']['revId'] ) ) {
							$page['latestRevision'] = $this->prepareRevisionData( $title, self::STATUS_AWAITING, $revId, $liveRevisionId );
						} elseif ( Helper::isStatusCompleted( $status ) ) {
							$statusKey = $this->getStatusKey( $status );

							if ( empty( $page['latestReviewed']['revId'] ) ) {
								$page['latestReviewed'] = $this->prepareRevisionData( $title, $statusKey, $revId, $liveRevisionId );
							}

							if ( $statusKey === self::STATUS_APPROVED ) {
								$statusKey = self::STATUS_LIVE;

								$page['liveRevision'] = $this->prepareRevisionData(	$title, $statusKey, $revId, $liveRevisionId	);
							}

							if ( empty( $page['latestRevision']['revId'] ) ) {
								$page['latestRevision'] =  $this->prepareRevisionData( $title, $statusKey, $revId, $liveRevisionId );
							}
						}
					}
				}

				if ( $page['page_latest'] != $page['latestRevision']['revId'] /* check if exists */ ) {
					$page['latestRevision'] = $this->prepareRevisionData(
						$title,
						self::STATUS_UNSUBMITTED,
						$page['page_latest'],
						$page['liveRevision']['revId'] // check if exists
					);
				}
			}
		}

		return $jsPages;
	}

	private function prepareRevisionData( \Title $title, $statusKey, $revisionId, $liveRevisionId = 0 ) {
		$data = [
			'revId' => $revisionId,
			'statusKey' => $statusKey,
			'message' => $this->getStatusMessage( $statusKey )
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

	private function getLiveRevision( $pageStatuses ) {
		if ( isset( $pageStatuses[ReviewModel::CONTENT_REVIEW_STATUS_APPROVED] ) ) {
			return $pageStatuses[ReviewModel::CONTENT_REVIEW_STATUS_APPROVED];
		}

		if ( isset( $pageStatuses[ReviewModel::CONTENT_REVIEW_STATUS_AUTOAPPROVED] ) ) {
			return $pageStatuses[ReviewModel::CONTENT_REVIEW_STATUS_AUTOAPPROVED];
		}

		return 0;
	}

	private function createPageLink( \Title $title ) {
		return \Linker::linkKnown( $title, $title->getText() );
	}

	protected function createRevisionLink( $title, $revisionId, $liveRevisionId = 0 ) {
		$params = [];

		if ( !empty( $liveRevisionId ) ) {
			$params['oldid'] = $liveRevisionId;

			if ( $revisionId !== $liveRevisionId ) {
				$params['diff'] = $revisionId;
			}
		} else {
			$params['oldid'] = $revisionId;
		}

		return \Linker::linkKnown(
			$title,
			"#{$revisionId}",
			[],
			$params
		);
	}

	private function createRevisionTalkpageLink( \Title $title ) {
		return \Linker::linkKnown(
			$title,
			wfMessage( 'content-review-rejection-reason-link' )->escaped()
		);
	}

	private function getStatusMessage( $statusKey = self::STATUS_NONE ) {
		return wfMessage( "content-review-module-status-{$statusKey}" )->escaped();
	}

	private function getStatusKey( $status = 0 ) {
		switch ( $status ) {
			case 1:
			case 2: $statusKey = self::STATUS_AWAITING; break;
			case 3:
			case 5: $statusKey = self::STATUS_APPROVED; break;
			case 4: $statusKey = self::STATUS_REJECTED; break;
			default: $statusKey = self::STATUS_NONE;
		}

		return $statusKey;
	}

	private function initPageData() {
		$statusNoneMsg = $this->getStatusMessage();

		return [
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
}
