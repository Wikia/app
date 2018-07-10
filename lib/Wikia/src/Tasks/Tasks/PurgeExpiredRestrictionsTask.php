<?php
namespace Wikia\Tasks\Tasks;

/**
 * SUS-5481: Delete expired page_restrictions and protected_titles entries when we come across them
 * @package Wikia\Tasks\Tasks
 */
class PurgeExpiredRestrictionsTask extends BaseTask {

	public function purgeExpiredPageRestrictions( array $pageRestrictionsIds ) {
		$dbw = wfGetDB( DB_MASTER );

		$dbw->delete( 'page_restrictions', [ 'pr_id' => $pageRestrictionsIds ], __METHOD__ );
	}

	public function purgeExpiredProtectedTitles( int $namespace, string $title ) {
		$dbw = wfGetDB( DB_MASTER );

		$dbw->delete( 'protected_titles', [ 'pt_namespace' => $namespace, 'pt_title' => $title ], __METHOD__ );
	}
}
