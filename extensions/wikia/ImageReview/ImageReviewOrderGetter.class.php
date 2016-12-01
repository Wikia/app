<?php

class ImageReviewOrderGetter {

	const ORDER_PREFERENCE = 'imageReviewSort';

	const LATEST = 0;
	const PRIORITY_LATEST = 1;
	const OLDEST = 2;

	const LATEST_SQL = 'last_edited desc';
	const PRIORITY_LATEST_SQL = 'priority desc, last_edited desc';
	const OLDEST_SQL = 'last_edited asc';

	const CODE_TO_SQL = [
		self::LATEST => self::LATEST_SQL,
		self::PRIORITY_LATEST => self::PRIORITY_LATEST_SQL,
		self::OLDEST =>  self::OLDEST_SQL
	];

	public function getOrder( User $user, int $requestedOrder ) : string {
		// Only certain user's can change their ordering, all others use default
		if ( !$user->isAllowed( 'imagereviewcontrols' ) ) {
			return self::PRIORITY_LATEST_SQL;
		}

		$preferredOrder = $this->getPreferredOrder( $user ) ?? $requestedOrder;
		if ( $requestedOrder != $preferredOrder && $this->isValidOrderVal( $requestedOrder ) ) {
			$this->setPreferredOrder( $user, $requestedOrder );
		}

		return self::CODE_TO_SQL[$requestedOrder] ?? self::PRIORITY_LATEST_SQL;
	}
	
	private function getPreferredOrder( User $user ) {
		return $user->getGlobalPreference( self::ORDER_PREFERENCE );
	}

	private function setPreferredOrder( User $user, int $newOrder ) {
		$user->setGlobalPreference( self::ORDER_PREFERENCE, $newOrder );
		$user->saveSettings();
	}

	private function isValidOrderVal($order ) {
		return $order == self::LATEST || $order == self::PRIORITY_LATEST || $order == self::OLDEST;
	}
}
