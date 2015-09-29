<?php

namespace Wikia\ContentReview;

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

		$currentRevision = new Models\CurrentRevisionModel();
		$lastReviewed = $currentRevision->getLatestReviewedRevisionForWiki( $wikiId );

		$jsPages = $this->prepareData( $jsPages, $statuses, $lastReviewed );

		return $jsPages;
	}

	private function prepareData( $jsPages, $statuses, $lastReviewed ) {
		if ( !empty( $statuses ) || !empty( $lastReviewed ) ) {
			foreach ( $jsPages as $pageId => &$page ) {
				$page += $this->initPageData();

				$title = \Title::newFromText( $page['page_title'], NS_MEDIAWIKI );

				$page['pageLink'] = $this->createPageLink( $title );

				if ( isset( $statuses[$pageId] ) ) {
					foreach( $statuses[$pageId] as $status => $revId ) {
						if ( Helper::isStatusAwaiting( $status ) && empty( $page['latestRevision'] ) ) {
							$page['latestRevision'] = $this->prepareRevisionData( $title, $revId, self::STATUS_AWAITING );
						} elseif ( Helper::isStatusCompleted( $status ) ) {
							$statusCode = $this->getStatusCode( $status );

							if ( empty( $page['latestReviewed'] ) ) {
								$page['latestReviewed'] = $this->prepareRevisionData( $title, $revId, $statusCode );
							}

							if ( empty( $page['latestRevision'] ) ) {
								if ( $statusCode === self::STATUS_APPROVED ) {
									$statusCode = self::STATUS_LIVE;
								}
								$page['latestRevision'] =  $this->prepareRevisionData( $title, $revId, $statusCode );
							}
						}
					}
				}

				if ( isset( $lastReviewed[$pageId]['revision_id'] ) ) {
					if ( empty( $page['latestReviewed'] ) ) {
						$page['latestReviewed'] = $this->prepareRevisionData(
							$title,
							$lastReviewed[$pageId]['revision_id'],
							self::STATUS_LIVE
						);
					}

					$page['liveRevision'] = $this->prepareRevisionData(
						$title,
						$lastReviewed[$pageId]['revision_id'],
						self::STATUS_LIVE
					);
				}

				if ( $page['page_latest'] != $page['latestRevision']['revId'] ) {
					$page['latestRevision'] = $this->prepareRevisionData(
						$title,
						$page['page_latest'],
						self::STATUS_UNSUBMITTED
					);
				}
			}
		}

		return $jsPages;
	}

	private function prepareRevisionData( \Title $title, $revisionId = null, $statusCode = self::STATUS_NONE ) {
		$data = [
			'revId' => $revisionId,
			'status' => $statusCode,
			'statusMsg' => $this->getStatusMessage( $statusCode )
		];

		if ( !is_null( $revisionId ) ) {
			$data['diffLink'] = $this->createRevisionLink( $title, $revisionId );
			if ( $statusCode === self::STATUS_REJECTED ) {
				$data['reasonLink'] = $this->createRevisionTalkpageLink( $title );
			}
		}

		return $data;
	}

	private function createPageLink( \Title $title ) {
		return \Linker::linkKnown( $title, $title->getText() );
	}


	private function createRevisionLink( \Title $title, $revisionId ) {
		return \Linker::linkKnown(
			$title,
			"#{$revisionId}",
			[],
			[
				'diff' => $revisionId,
			]
		);
	}

	private function createRevisionTalkpageLink( \Title $title ) {
		return \Linker::linkKnown(
			$title,
			wfMessage( 'content-review-rejection-reason-link' )->escaped()
		);
	}

	private function getStatusMessage( $statusMsg = self::STATUS_NONE ) {
		return wfMessage( "content-review-module-status-{$statusMsg}" )->escaped();
	}

	private function getStatusCode( $status = 0 ) {
		switch ( $status ) {
			case 1:
			case 2: $code = self::STATUS_AWAITING; break;
			case 3:
			case 5: $code = self::STATUS_APPROVED; break;
			case 4: $code = self::STATUS_REJECTED; break;
			default: $code = self::STATUS_NONE;
		}

		return $code;
	}

	private function initPageData() {
		return [
			'latestRevision' => [],
			'latestReviewed' => [],
			'liveRevision' => null
		];
	}
}
