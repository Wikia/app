<?php
use Wikia\ContentReview\Models\ReviewModel;
use Wikia\ContentReview\Models\ReviewLogModel;
use Wikia\ContentReview\Helper;

class ContentReviewSpecialController extends WikiaSpecialPageController {

	public static $statusMessageKeys = [
		ReviewModel::CONTENT_REVIEW_STATUS_UNREVIEWED => 'content-review-status-unreviewed',
		ReviewModel::CONTENT_REVIEW_STATUS_IN_REVIEW => 'content-review-status-in-review',
		ReviewModel::CONTENT_REVIEW_STATUS_APPROVED => 'content-review-status-approved',
		ReviewModel::CONTENT_REVIEW_STATUS_REJECTED => 'content-review-status-rejected'
	];

	function __construct() {
		parent::__construct( 'ContentReview', 'content-review', true );
	}

	public function init() {
		$this->specialPage->setHeaders();

		\Wikia::addAssetsToOutput( 'content_review_special_page_js' );
		\JSMessages::enqueuePackage( 'ContentReviewSpecialPage', \JSMessages::EXTERNAL );
	}

	protected function checkAccess() {
		if( !$this->wg->User->isLoggedIn() || !$this->wg->User->isAllowed( 'content-review' ) ) {
			return false;
		}
		return true;
	}

	public function index() {
		$this->specialPage->setHeaders();

		if( !$this->checkAccess() ) {
			$this->displayRestrictionError();
			return false;
		}

		$this->getOutput()->setPageTitle( wfMessage( 'content-review-special-title' )->plain() );

		$wikiId = $this->getPar();

		if ( !empty( $wikiId ) ) {
			$model = new ReviewLogModel();
			$reviews = $model->getArchivedReviewForWiki( $wikiId );
			$this->reviews = $this->prepareArchivedReviewData( $reviews );
			$this->overrideTemplate('archive');
		} else {
			$model = new ReviewModel();
			$reviews = $model->getContentToReviewFromDatabase();
			$this->reviews = $this->prepareReviewData( $reviews );
		}
	}

	private function prepareReviewData( $reviewsRaw ) {
		$reviews = [];

		foreach ( $reviewsRaw as $review ) {
			$title = GlobalTitle::newFromID( $review['page_id'], $review['wiki_id'] );
			$wiki = WikiFactory::getWikiByID( $review['wiki_id'] );

			$review['url'] = $title->getFullURL();
			$review['title'] = $title->getBaseText();
			$review['wiki'] = $wiki->city_title;
			$review['user'] = User::newFromId( $review['submit_user_id'] )->getName();
			$review['diff'] = $title->getFullURL( [
				'diff' => $review['revision_id'],
				'oldid' => $review['reviewed_id'],
				Helper::CONTENT_REVIEW_PARAM => 1,
			] );
			$review['diffText'] = $review['status'] == ReviewModel::CONTENT_REVIEW_STATUS_UNREVIEWED
				? wfMessage( 'content-review-special-start-review' )->escaped()
				: wfMessage( 'content-review-special-continue-review' )->escaped();

			if ( !empty( $review['review_user_id'] ) ) {
				$review['review_user_name'] = User::newFromId( $review['review_user_id'] )->getName();
			}

			$reviewKey = implode( ':', [
				$review['wiki_id'],
				$review['page_id'],
				ReviewModel::CONTENT_REVIEW_STATUS_IN_REVIEW
			] );
			if ( $review['status'] == ReviewModel::CONTENT_REVIEW_STATUS_UNREVIEWED
				&& isset( $reviewsRaw[$reviewKey] )
			) {
				$review['hide'] = true;
			}

			$reviews[$review['wiki_id']][] = $review;
		}

		return $reviews;
	}

	private function prepareArchivedReviewData( $reviewsRaw ) {
		$reviews = [];

		foreach ( $reviewsRaw as $review ) {
			$title = GlobalTitle::newFromID( $review['page_id'], $review['wiki_id'] );
			$wiki = WikiFactory::getWikiByID( $review['wiki_id'] );

			$review['url'] = $title->getFullURL();
			$review['title'] = $title->getBaseText();
			$review['wiki'] = $wiki->city_title;

			$review['diff'] = $title->getFullURL( [
				'oldid' => $review['revision_id']
			] );

			if ( !empty( $review['review_user_id'] ) ) {
				$review['review_user_name'] = User::newFromId( $review['review_user_id'] )->getName();
			}

			if ( $review['status'] == ReviewModel::CONTENT_REVIEW_STATUS_APPROVED ) {
				$review['revert'] = true;
			}



			$reviews[$review['wiki_id']][] = $review;
		}

		return $reviews;
	}
}
