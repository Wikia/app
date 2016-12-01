<?php

class AbandonedWorkResetter extends WikiaModel {
	/**
	 * reset state in abandoned work
	 * note: this is run via a cron script
	 */
	public function resetAbandonedWork() {
		wfProfileIn( __METHOD__ );

		$timeLimit = ( $this->wg->DevelEnvironment ) ? 1 : 3600; // 1 sec
		$from = wfTimestamp(TS_DB, time() - $timeLimit );

		// for STATE_UNREVIEWED
		$this->updateResetAbandoned( $from,
			ImageStates::UNREVIEWED,
			ImageStates::IN_REVIEW
		);

		// for STATE_QUESTIONABLE
		$this->updateResetAbandoned( $from,
			ImageStates::QUESTIONABLE,
			ImageStates::QUESTIONABLE_IN_REVIEW
		);

		// for STATE_REJECTED
		$this->updateResetAbandoned( $from,
			ImageStates::REJECTED,
			ImageStates::REJECTED_IN_REVIEW
		);

		wfProfileOut( __METHOD__ );
		return $from;
	}

	private function updateResetAbandoned( string $from, int $stateSet, int $stateWhere ) {
		$oDB = $this->getDatawareDB();

		$oDB->update(
			'image_review',
			[
				'reviewer_id' => null,
				'state' => $stateSet,
				'review_start' => '0000-00-00 00:00:00',
				'review_end' => '0000-00-00 00:00:00',
			],
			[
				"review_start < '{$from}'",
				'state' => $stateWhere,
			],
			__METHOD__
		);

		$oDB->commit();
	}
}
