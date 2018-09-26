<?php

require_once( __DIR__ . '/../../../../maintenance/Maintenance.php' );

use Wikia\ContentReview\Models\ReviewModel;

/**
 * Publishes JS review statistics on a Slack channel
 *
 * @see https://wikia.slack.com/messages/C0A0ZUT9Q
 */
class ContentReviewStatus extends Maintenance {

	private
		$webhook,
		$sla = 24;

	public function execute() {
		global $wgContentReviewSlackWebhook;

		if ( empty( $wgContentReviewSlackWebhook ) ) {
			$this->output( 'Webhook URL was not found.' );
		}
		$this->webhook = $wgContentReviewSlackWebhook;

		$uncompleted = $this->getCountOfUncompletedReviews();
		$data = $this->prepareData( $uncompleted );
		$response = $this->sendPostRequest( $data );

		if ( $response->getStatus() !== 200 ) {
			$logger = Wikia\Logger\WikiaLogger::instance();
			$logger->error( 'Updating JavaScript reviews status failed', [
				'rspnsHdrs' => $response->getResponseHeaders(),
			] );
		}
		else {
			$this->output('Slack message sent.');
		}
	}

	private function getCountOfUncompletedReviews() {
		$uncompleted = [
			ReviewModel::CONTENT_REVIEW_STATUS_UNREVIEWED => 0,
			ReviewModel::CONTENT_REVIEW_STATUS_IN_REVIEW => 0,
			'overdue' => 0,
		];
		$now = ( new DateTime() )->getTimestamp();

		$reviewModel = new ReviewModel();
		$notCompletedReviews = $reviewModel->getContentToReviewFromDatabase();

		foreach ( $notCompletedReviews as $review ) {
			$submitTime = ( new DateTime( $review['submit_time'] ) )->getTimestamp();
			$diff = ( $now - $submitTime ) / 60 / 60;

			if ( (int)$diff >= $this->sla ) {
				$uncompleted['overdue']++;
			}

			$uncompleted[(int)$review['status']]++;
		}

		return $uncompleted;
	}

	private function prepareData( array $uncompleted ) {
		if ( array_sum( $uncompleted ) === 0 ) {
			$color = 'good';
			$text = 'Great! The queue is clear.';
		}
		elseif ( $uncompleted['overdue'] === 0 ) {
			$color = 'warning';
			$text = 'There are changes that are waiting for your review. How about going to <http://dev.wikia.com/Special:ContentReview|Special:ContentReview> now?';
		} else {
			$color = 'danger';
			$text = "There are issues submitted more than {$this->sla} hours ago! Go to <http://dev.wikia.com/Special:ContentReview|Special:ContentReview>";
		}

		$fields = [
			[
				'title' => 'Overdue',
				'value' => $uncompleted['overdue'],
			],
			[
				'title' => 'Unreviewed',
				'value' => $uncompleted[ReviewModel::CONTENT_REVIEW_STATUS_UNREVIEWED],
			],
			[
				'title' => 'In review',
				'value' => $uncompleted[ReviewModel::CONTENT_REVIEW_STATUS_IN_REVIEW],
			],
		];

		$data = [
			'text' => $text,
			'color' => $color,
			'fields' => $fields,
		];

		$this->output( sprintf( "Will send the following message: %s\n", $text ) );

		return $data;
	}

	/**
	 * @param array $data
	 * @return MWHttpRequest
	 */
	private function sendPostRequest( array $data ) {
		$options = [
			'postData' => json_encode( $data ),
			'headers' => [
				'Content-Type' => 'application/json',
				'Accept' => 'application/json',
			],
			'returnInstance' => true,
		];

		$response = Http::post( $this->webhook, $options );

		return $response;
	}
}

$maintClass = 'ContentReviewStatus';
require_once( RUN_MAINTENANCE_IF_MAIN );
