<?php

class ImageReviewHooks {

	public static function setupHooks() {
		$oImageReviewHooks = new self();
		\Hooks::register( 'WikiFactoryPublicStatusChange', [ $oImageReviewHooks, 'onWikiFactoryPublicStatusChange' ] );
	}

	public function onWikiFactoryPublicStatusChange( $city_public, $city_id, $reason ) {
		if ( $city_public == 0 || $city_public == -1 ) {
			// the wiki was disabled, mark all unreviewed images as deleted

			$newState = ImageReviewStatuses::STATE_WIKI_DISABLED;
			$statesToUpdate = [
				ImageReviewStatuses::STATE_UNREVIEWED,
				ImageReviewStatuses::STATE_REJECTED,
				ImageReviewStatuses::STATE_QUESTIONABLE,
				ImageReviewStatuses::STATE_QUESTIONABLE_IN_REVIEW,
				ImageReviewStatuses::STATE_REJECTED_IN_REVIEW,
				ImageReviewStatuses::STATE_IN_REVIEW,
			];
		} elseif ( $city_public == 1 ) {
			// the wiki was re-enabled, put all images back into the queue as unreviewed

			$newState = ImageReviewStatuses::STATE_UNREVIEWED;
			$statesToUpdate = [ ImageReviewStatuses::STATE_WIKI_DISABLED ];
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
