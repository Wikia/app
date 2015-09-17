<?php

$dir = __DIR__ . "/../../../../";
require_once( $dir . 'maintenance/Maintenance.php' );

use Wikia\ContentReview\Models\ReviewModel;

class ContentReviewStatus extends Maintenance {

	private $webhook,
			$sla = 24000;

	public function __construct() {
		parent::__construct();
	}

	public function execute() {
		global $wgContentReviewSlackWebhook;

		if ( empty( $wgContentReviewSlackWebhook ) ) {
			$this->output( 'Webhook URL was not found.' );
			return false;
		}
		$this->webhook = $wgContentReviewSlackWebhook;

		$uncompleted = $this->getCountOfUncompletedReviews();
		$data = $this->prepareData( $uncompleted );
		$result = $this->sendDataAsJson( $data );

		if ( $result !== 'ok' ) {
			$logger = Wikia\Logger\WikiaLogger::instance();
			$logger->error( 'Updating JavaScript reviews status failed' );
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

		return $data;
	}

	private function sendDataAsJson( array $data ) {
		$options = [
			'http' => [
				'method' => 'POST',
				'content' => json_encode( $data ),
				'header' => 'Content-Type: application/json\r\n' .
							'Accept: application/json\r\n',
			],
		];

		$context = stream_context_create( $options );
		$result = file_get_contents( $this->webhook, false, $context );

		return $result;
	}
}

$maintClass = 'ContentReviewStatus';
require_once( RUN_MAINTENANCE_IF_MAIN );
