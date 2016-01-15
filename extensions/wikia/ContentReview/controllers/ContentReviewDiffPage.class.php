<?php

namespace Wikia\ContentReview;

use Wikia\ContentReview\Models\ReviewModel;

class ContentReviewDiffPage extends \ContextSource {

	const CONTENT_REVIEW_TOOLBAR_TEMPLATE_PATH = 'extensions/wikia/ContentReview/templates/ContentReviewToolbar.mustache';

	private
		$escalated,
		$pageId,
		$revisionId,
		$status,
		$title,
		$toolbarHtml,
		$wikiId;

	public function __construct( \Title $title ) {
		global $wgCityId;

		$this->wikiId = $wgCityId;
		$this->title = $title;
		$this->pageId = $title->getArticleID();
		$this->revisionId = $this->getCurrentlyReviewedRevisionId();
	}

	/**
	 * Tries to initiate and render the toolbar. Triggers checks if for conditions
	 * for displaying the toolbar being fulfilled. If not - it returns false.
	 * Sets toolbarHtml, prepares assets and returns true otherwise.
	 * @return bool
	 */
	public function initReviewerToolbar() {
		if ( $this->shouldDisplayToolbar() ) {
			$this->toolbarHtml = $this->renderToolbar();
			$this->prepareAssets();
			return true;
		}
		return false;
	}

	/**
	 * Prepends a rendered toolbar to a given output.
	 * @param \OutputPage $outputPage
	 */
	public function addToolbarToOutput( \OutputPage $outputPage ) {
		if ( isset( $this->toolbarHtml ) ) {
			$outputPage->prependHTML( $this->toolbarHtml );
		}
	}

	/**
	 * Returns an ID of a revision that is currently being reviewed. It is either a value of
	 * `diff` URL parameter or `oldid` if `diff` is not present.
	 * @return null|int
	 */
	private function getCurrentlyReviewedRevisionId() {
		$request = $this->getRequest();
		$revisionId = $request->getInt( 'diff' );
		if ( $revisionId === 0 ) {
			$revisionId = $request->getInt( 'oldid' );
		}
		return $revisionId;
	}

	/**
	 * Runs all conditions to check if a reviewer's toolbar should be displayed for the context page.
	 * @return bool
	 */
	private function shouldDisplayToolbar() {
		if ( $this->revisionId !== 0
			&& $this->getRequest()->getBool( Helper::CONTENT_REVIEW_PARAM )
			&& $this->title->inNamespace( NS_MEDIAWIKI )
			&& $this->title->isJsPage()
			&& $this->title->userCan( 'content-review' )
		) {
			$diffRevisionInfo = $this->getReviewModel()->getRevisionInfo(
				$this->wikiId,
				$this->pageId,
				$this->revisionId
			);
			$this->status = $diffRevisionInfo['status'];
			$this->escalated = $diffRevisionInfo['escalated'];

			// Always make sure it's in review if this is a content review request
			if ( $this->status === ReviewModel::CONTENT_REVIEW_STATUS_UNREVIEWED ) {
				$reviewerId = $this->getUser()->getId();
				try {
					$this->getReviewModel()->updateRevisionStatus(
						$this->wikiId,
						$this->pageId,
						$this->status,
						ReviewModel::CONTENT_REVIEW_STATUS_IN_REVIEW,
						$reviewerId
					);
				} catch ( \FluentSql\Exception\SqlException $e ) {
					// Master-slave replication has not finished, ignore
				}

				return true;
			}

			return $this->status === ReviewModel::CONTENT_REVIEW_STATUS_IN_REVIEW;
		}

		return false;
	}

	/**
	 * Returns an HTML with a toolbar displayed to reviewers.
	 * @return string
	 * @throws \Exception
	 */
	private function renderToolbar() {
		$params = [
			'toolbarTitle' => wfMessage( 'content-review-diff-toolbar-title' )->plain(),
			'wikiId' => $this->wikiId,
			'pageId' => $this->pageId,
			'approveStatus' => ReviewModel::CONTENT_REVIEW_STATUS_APPROVED,
			'buttonApproveText' => wfMessage( 'content-review-diff-approve' )->plain(),
			'rejectStatus' => ReviewModel::CONTENT_REVIEW_STATUS_REJECTED,
			'buttonRejectText' => wfMessage( 'content-review-diff-reject' )->plain(),
			'talkpageUrl' => $this->prepareProvideFeedbackLink( $this->title, $this->revisionId ),
			'talkpageLinkText' => wfMessage( 'content-review-diff-toolbar-talkpage' )->plain(),
			'guidelinesUrl' => wfMessage( 'content-review-diff-toolbar-guidelines-url' )->useDatabase( false )->plain(),
			'guidelinesLinkText' => wfMessage( 'content-review-diff-toolbar-guidelines' )->plain(),
		];

		if ( $this->escalated ) {
			$params['escalatedTitle'] = wfMessage( 'content-review-diff-revision-escalated' )->plain();
		} else {
			$params['buttonEscalateText'] = wfMessage( 'content-review-diff-escalate' )->plain();
		}

		return \MustacheService::getInstance()->render( self::CONTENT_REVIEW_TOOLBAR_TEMPLATE_PATH, $params );
	}

	/**
	 * Link for adding new section on script talk page. Prefilled with standard explanation of rejection.
	 * @return string full link to edit page
	 */
	public function prepareProvideFeedbackLink() {
		$params = [
			'action' => 'edit',
			'section' => 'new',
			'useMessage' => 'content-review-rejection-explanation',
		];

		$params['messageParams'] = [
			1 => wfMessage( 'content-review-rejection-explanation-title' )->params( $this->revisionId )->escaped(),
			2 => $this->title->getFullURL( "oldid={$this->revisionId}" ),
			3 => $this->revisionId,
		];

		return $this->title->getTalkPage()->getFullURL( $params );
	}

	/**
	 * Prepare styles, scripts and messages required for the diff page view.
	 */
	private function prepareAssets() {
		\Wikia::addAssetsToOutput( 'content_review_diff_page_js' );
		\Wikia::addAssetsToOutput( 'content_review_diff_page_scss' );
		\JSMessages::enqueuePackage( 'ContentReviewDiffPage', \JSMessages::EXTERNAL );
	}

	/**
	 * @return ReviewModel
	 */
	private function getReviewModel() {
		if ( !isset( $this->reviewModel ) ) {
			$this->reviewModel = new ReviewModel();
		}
		return $this->reviewModel;
	}
}
