<?php
/**
 * ContentReviewService
 *
 * This class should include all logic behind the ContentReview tool management. It should be a direct
 * controller of Models and actions performed on them.
 */

namespace Wikia\ContentReview;

use Wikia\ContentReview\Models\ReviewModel,
	Wikia\ContentReview\Models\ReviewLogModel,
	Wikia\ContentReview\Models\CurrentRevisionModel;

class ContentReviewService extends \WikiaService {

	/**
	 * This is a shortcut method for the users entitled to be reviewers. Instead of submitting a revision
	 * and manually approving it they are able to do so automatically.
	 * zoma
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
}
