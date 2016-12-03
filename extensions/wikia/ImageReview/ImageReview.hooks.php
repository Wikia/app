<?php

class ImageReviewHooks {

	public static function setupHooks() {
		$oImageReviewHooks = new self();
		\Hooks::register( 'WikiFactoryPublicStatusChange', [ $oImageReviewHooks, 'onWikiFactoryPublicStatusChange' ] );
	}

	public static function onWikiFactoryPublicStatusChange( $city_public, $city_id, $reason ) {
		if ( $city_public == 0 || $city_public == -1 ) {
			// the wiki was disabled, mark all unreviewed images as deleted

			$newState = ImageStates::WIKI_DISABLED;
			$statesToUpdate = [
				ImageStates::UNREVIEWED,
				ImageStates::REJECTED,
				ImageStates::QUESTIONABLE,
				ImageStates::QUESTIONABLE_IN_REVIEW,
				ImageStates::REJECTED_IN_REVIEW,
				ImageStates::IN_REVIEW,
			];
		} elseif ( $city_public == 1 ) {
			// the wiki was re-enabled, put all images back into the queue as unreviewed

			$newState = ImageStates::UNREVIEWED;
			$statesToUpdate = [ ImageStates::WIKI_DISABLED ];
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

		( new ImageStateUpdater() )->updateBatchImages( $aValues, $aWhere );

		return true;
	}
}
