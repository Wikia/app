<?php

$dir = __DIR__ . "/../../../../";
require_once( $dir . 'maintenance/Maintenance.php' );

class ReviewedBeforeDateRevision extends Maintenance {

	private $contentReviewService,
			$currentRevisionModel,
			$reviewModel,
			$wikiaUser;

	/**
	 * Set script options
	 */
	public function __construct() {
		parent::__construct();

		$this->addOption( 'beforeDate', 'Approve all revisions edited before this date.' );
	}

	public function execute() {
		global $wgCityId, $wgUseSiteJs, $wgEnableContentReviewExt;

		if ( !empty( $wgUseSiteJs ) && !empty( $wgEnableContentReviewExt ) ) {
			$this->output( "Processing wiki id: {$wgCityId}\n" );

			$helper = new \Wikia\ContentReview\Helper();
			$jsPages = $helper->getJsPages();

			$currentRevisions = $this->getCurrentRevisionModel()->getLatestReviewedRevisionForWiki( $wgCityId );

			$beforeDate = $this->getOption( 'beforeDate', null );

			if ( !is_null( $beforeDate ) ) {
				$beforeDate = strtotime( $beforeDate );
			} else {
				exit('Date is not set.');
			}

			foreach ( $jsPages as $jsPage ) {
				if ( !empty( $jsPage['page_id'] ) && !empty( $jsPage['page_latest'] ) ) {
					$lastApprovedRevisionId = isset( $currentRevisions[$jsPage['page_id']] )
						? $currentRevisions[$jsPage['page_id']]['revision_id']
						: 0;

					if ( $jsPage['page_latest'] != $lastApprovedRevisionId ) {
						$revision = Revision::newFromId( $jsPage['page_latest'] );
						$title = $revision->getTitle();
						$approved = false;

						while ( !$approved && !is_null( $revision ) && $revision->getId() != $lastApprovedRevisionId ) {
							$userId = $revision->getUser();
							$user = User::newFromId( $userId );

							if ( strtotime( $revision->getTimestamp() ) <= $beforeDate && $title->userCan( 'editinterfacetrusted', $user ) ) {
								try {
									$this->getContentReviewService()->automaticallyApproveRevision(
										$this->getWikiaUser(),
										$wgCityId,
										$jsPage['page_id'],
										$revision->getId()
									);
									$this->output( "Added revision id for page {$jsPage['page_title']} (ID: {$jsPage['page_id']})\n" );
								} catch( FluentSql\Exception\SqlException $e ) {
									$this->output( $e->getMessage() . "\n" );
								}

								$approved = true;
							} else {
								$revision = $revision->getPrevious();
							}

						}
					} elseif ( !empty( $lastApprovedRevisionId ) ) {
						try {
							$reviewModel = $this->getReviewModel();
							$reviewModel->submitPageForReview(
								$wgCityId,
								$jsPage['page_id'],
								$lastApprovedRevisionId,
								$this->getWikiaUser()->getId()
							);
							$reviewModel->updateCompletedReview(
								$wgCityId,
								$jsPage['page_id'],
								$lastApprovedRevisionId, Wikia\ContentReview\Models\ReviewModel::CONTENT_REVIEW_STATUS_APPROVED );
							$this->output( "Moved revision id for page {$jsPage['page_title']} (ID: {$jsPage['page_id']})\n" );
						} catch( FluentSql\Exception\SqlException $e ) {
							$this->output( $e->getMessage() . "\n" );
						}
					}
				}
			}

			$helper->purgeReviewedJsPagesTimestamp();
			\Wikia\ContentReview\ContentReviewStatusesService::purgeJsPagesCache();
		} else {
			$this->output( "Wiki (Id: {$wgCityId}) has disabled custom scripts or JSRT.\n" );
		}

	}

	private function getWikiaUser() {
		if ( empty( $this->wikiaUser ) ) {
			$this->wikiaUser = User::newFromName( 'Wikia' );
		}

		return $this->wikiaUser;
	}

	private function getCurrentRevisionModel() {
		if ( empty( $this->currentRevisionModel ) ) {
			$this->currentRevisionModel = new Wikia\ContentReview\Models\CurrentRevisionModel();
		}

		return $this->currentRevisionModel;
	}

	private function getReviewModel() {
		if ( empty( $this->reviewModel ) ) {
			$this->reviewModel = new Wikia\ContentReview\Models\ReviewModel();
		}

		return $this->reviewModel;
	}

	private function getContentReviewService() {
		if ( empty( $this->contentReviewService ) ) {
			$this->contentReviewService = new Wikia\ContentReview\ContentReviewService();
		}

		return $this->contentReviewService;
	}
}

$maintClass = 'ReviewedBeforeDateRevision';
require_once( RUN_MAINTENANCE_IF_MAIN );
