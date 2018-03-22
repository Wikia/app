<?php

/**
 * Wrapper for {@see UserStatsService} to work around incompatibilities with SQLite
 */
class EditCountService {
	public function getEditCount( int $userId ): int {
		return ( new UserStatsService( $userId ) )->getEditCountWiki();
	}
}
