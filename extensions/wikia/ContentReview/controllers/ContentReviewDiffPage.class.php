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
		$wikiId;

	public function __construct( \Title $title ) {
		global $wgCityId;

		$this->wikiId = $wgCityId;
		$this->title = $title;
		$this->pageId = $title->getArticleID();
		$this->revisionId = $this->getCurrentlyReviewedRevisionId();
	}

	/**
	 * Prepends a rendered toolbar to a given output.
	 * @param \OutputPage $outputPage
	 */
	public function addToolbarToOutput( \OutputPage $outputPage ) {
		$this->prepareAssets();

		$toolbarHtml = $this->renderToolbar();
		$outputPage->prependHTML( $toolbarHtml );
	}

	/**
	 * Runs all conditions to check if a reviewer's toolbar should be displayed for the context page.
	 * @return bool
	 */
	public function shouldDisplayToolbar() {
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
	 * Returns an HTML with a toolbar displayed to reviewers.
	 * @return string
	 * @throws \Exception
	 */
	private function renderToolbar() {
		$params = [
			'toolbarTitle' => $this->msg( 'content-review-diff-toolbar-title' )->plain(),
			'wikiId' => $this->wikiId,
			'pageId' => $this->pageId,
			'approveStatus' => ReviewModel::CONTENT_REVIEW_STATUS_APPROVED,
			'buttonApproveText' => $this->msg( 'content-review-diff-approve' )->plain(),
			'rejectStatus' => ReviewModel::CONTENT_REVIEW_STATUS_REJECTED,
			'buttonRejectText' => $this->msg( 'content-review-diff-reject' )->plain(),
			'talkpageUrl' => ( new Helper() )->prepareProvideFeedbackLink( $this->title, $this->revisionId ),
			'talkpageLinkText' => $this->msg( 'content-review-diff-toolbar-talkpage' )->plain(),
			'guidelinesUrl' => $this->msg( 'content-review-diff-toolbar-guidelines-url' )->useDatabase( false )->plain(),
			'guidelinesLinkText' => $this->msg( 'content-review-diff-toolbar-guidelines' )->plain(),
		];

		if ( $this->escalated ) {
			$params['escalatedTitle'] = $this->msg( 'content-review-diff-revision-escalated' )->plain();
		} else {
			$params['buttonEscalateText'] = $this->msg( 'content-review-diff-escalate' )->plain();
		}

		return \MustacheService::getInstance()->render( self::CONTENT_REVIEW_TOOLBAR_TEMPLATE_PATH, $params );
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
