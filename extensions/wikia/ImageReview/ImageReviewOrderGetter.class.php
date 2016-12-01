<?php

class ImageReviewOrderGetter {

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
		if ( $user->isAllowed( 'imagereviewcontrols' ) ) {
			return self::CODE_TO_SQL[$requestedOrder] ?? self::PRIORITY_LATEST_SQL;
		}
		return self::PRIORITY_LATEST_SQL;
	}
}
