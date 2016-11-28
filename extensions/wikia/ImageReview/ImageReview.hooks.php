<?php

class ImageReviewHooks {

	public static function setupHooks() {
		$oImageReviewHooks = new self();
		\Hooks::register( 'WikiFactoryPublicStatusChange', [ $oImageReviewHooks, 'onWikiFactoryPublicStatusChange' ] );
	}

	public function onWikiFactoryPublicStatusChange( $city_public, $city_id, $reason ) {
		if ( $city_public == 0 || $city_public == -1 ) {
			// the wiki was disabled, mark all unreviewed images as deleted

			$newState = ImageReviewStates::WIKI_DISABLED;
			$statesToUpdate = [
				ImageReviewStates::UNREVIEWED,
				ImageReviewStates::REJECTED,
				ImageReviewStates::QUESTIONABLE,
				ImageReviewStates::QUESTIONABLE_IN_REVIEW,
				ImageReviewStates::REJECTED_IN_REVIEW,
				ImageReviewStates::IN_REVIEW,
			];
		} elseif ( $city_public == 1 ) {
			// the wiki was re-enabled, put all images back into the queue as unreviewed

			$newState = ImageReviewStates::UNREVIEWED;
			$statesToUpdate = [ ImageReviewStates::WIKI_DISABLED ];
		} else {
			// the state change doesn't affect images, we don't need to do anything here
			return true;
		}

		/**
		 * Update batch of images
		 */
		$aValues = [ 'state' => $newState ];
		$aWhere = [
			'wiki_id' => $city_id,
			'state' => $statesToUpdate,
		];

		$oDB = $this->getDatabaseHelper();
		$oDB->updateBatchImages( $aValues, $aWhere );

		return true;
	}

	private function getDatabaseHelper() {
		return new ImageReviewDatabaseHelper();
	}
}
