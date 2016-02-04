<?php
/**
 * ContentReviewService
 *
 * This class should include all logic behind the ContentReview tool management. It should be a direct
 * controller of Models and actions performed on them.
 */

namespace Wikia\ContentReview;

use Wikia\ContentReview\Integrations\SlackIntegration,
	Wikia\ContentReview\Models\ReviewModel,
	Wikia\ContentReview\Models\ReviewLogModel,
	Wikia\ContentReview\Models\CurrentRevisionModel;

class ContentReviewService extends \WikiaService {

	use \Wikia\Logger\Loggable;

	/**
	 * This is a shortcut method for the users entitled to be reviewers. Instead of submitting a revision
	 * and manually approving it they are able to do so automatically.
	 *
	 * @param \User $user
	 * @param int $wikiId
	 * @param int $pageId
	 * @param int $revisionId
	 * @throws \PermissionsException
	 * @throws \FluentSql\Exception\SqlException
	 */
	public function automaticallyApproveRevision( \User $user, $wikiId, $pageId, $revisionId ) {
		if ( !$user->isAllowed( 'content-review' ) ) {
			throw new \PermissionsException( 'content-review' );
		}

		$submitUserId = $user->getId();

		$reviewModel = new ReviewModel();
		$reviewModel->submitPageForReview( $wikiId, $pageId, $revisionId, $submitUserId );
		$reviewModel->updateCompletedReview( $wikiId, $pageId, $revisionId, ReviewModel::CONTENT_REVIEW_STATUS_APPROVED );

		$currentRevisionModel = new CurrentRevisionModel();
		$currentRevisionModel->approveRevision( $wikiId, $pageId, $revisionId );

		( new Helper() )->purgeReviewedJsPagesTimestamp();
		ContentReviewStatusesService::purgeJsPagesCache();

		$reviewLogModel = new ReviewLogModel();
		$now = ( new \DateTime() )->format( 'Y-m-d H:i:s' );
		$logData = [
			'wiki_id' => $wikiId,
			'page_id' => $pageId,
			'revision_id' => $revisionId,
			'submit_user_id' => $submitUserId,
			'submit_time' => $now,
			'review_start' => $now,
		];
		$reviewLogModel->backupCompletedReview( $logData, ReviewModel::CONTENT_REVIEW_STATUS_AUTOAPPROVED, $submitUserId );
	}

	/**
	 * Removes all data on a given page from the Content Review database.
	 * USE ONLY FOR DELETED PAGES!
	 *
	 * @param $wikiId
	 * @param $pageId
	 */
	public function deletePageData( $wikiId, $pageId ) {
		$reviewModel = new ReviewModel();
		$currentRevisionModel = new CurrentRevisionModel();

		if ( !$reviewModel->deleteReviewsOfPage( $wikiId, $pageId ) ) {
			$this->error( 'ContentReview deletion failed', [
				'targetTable' => $reviewModel::CONTENT_REVIEW_STATUS_TABLE,
				'wikiId' => $wikiId,
				'pageId' => $pageId,
			] );
		}
		if ( !$currentRevisionModel->deleteCurrentRevisionOfPage( $wikiId, $pageId ) ) {
			$this->error( 'ContentReview deletion failed', [
				'targetTable' => $currentRevisionModel::CONTENT_REVIEW_CURRENT_REVISIONS_TABLE,
				'wikiId' => $wikiId,
				'pageId' => $pageId,
			] );
		}
	}

	public function escalateReview( $wikiId, $pageId, $diff, $oldid ) {
		$title = \GlobalTitle::newFromId( $pageId, $wikiId );
		if ( !$title instanceof \GlobalTitle ) {
			return false;
		}

		if ( $diff === 0 ) {
			$revisionId = $oldid;
		} else {
			$revisionId = $diff;
		}

		$reviewModel = new ReviewModel();
		$sqlStatus = $reviewModel->escalateReview( $wikiId, $pageId, $revisionId );

		if ( !$sqlStatus ) {
			return false;
		}

		$revisionURL = $title->getFullURL( [
			'diff' => $diff,
			'oldid' => $oldid,
			Helper::CONTENT_REVIEW_PARAM => 1,
		] );

		$wikiRow = \WikiFactory::getWikiByID( $wikiId );
		$slackIntegration = new SlackIntegration();
		$data = [
			'fallback' => 'A review was escalated. Please, visit Special:ContentReview to help with it.',
			'pretext' => "Attention <!here>! A JS change has just been escalated!\nTo review the revision follow <{$revisionURL}|this link>.",
			'color' => 'warning',
			'fields' => [
				[
					'title' => 'Wiki name',
					'value' => $wikiRow->city_title,
					'short' => true,
				],
				[
					'title' => 'Page title',
					'value' => "<{$title->getFullURL()}|{$title->getPrefixedText()}>",
					'short' => true,
				],
			],
		];
		$slackResponse = $slackIntegration->sendMessage( $data );

		return $slackResponse->getStatus() === 200;
	}
}
