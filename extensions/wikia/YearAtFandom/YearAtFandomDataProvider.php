<?php

declare( strict_types=1 );

final class YearAtFandomDataProvider {
	/** @var DatabaseType */
	private $sharedDb;
	/** @var DatabaseType */
	private $warehouseDb;
	/** @var HubService */
	private $hubService;

	public function __construct() {
		global $wgExternalSharedDB, $wgExternalDatawareDB;
		$this->sharedDb = wfGetDB( DB_SLAVE, [], $wgExternalSharedDB );
		$this->warehouseDb = wfGetDB( DB_SLAVE, [], $wgExternalDatawareDB );
		$this->hubService = new HubService();
	}

	public function getAll( int $userId ): UserStatistics {
		return new UserStatistics(
			$this->getSummary( $userId ),
			$this->getPageViews( $userId )
		);
	}

	private function getPageViews( int $userId ): WikiPageViewsList {
		$result = $this->warehouseDb->select(
			'blabla',
			[ '*' ],
			[ 'user_id' => $userId ]
		);

		$list = [];

		foreach ( $result as $row ) {
			$list[] = new WikiPageViews( $row->wiki_id, $row->page_views );
		}

		return new WikiPageViewsList( $list );
	}

	private function getSummary( int $userId ): UserSummary {
		$result = $this->warehouseDb->select(
			'user_aggregated',
			[ '*' ],
			[ 'user_id' => $userId ]
		)->fetchRow();

		return new UserSummary(
			$result['page_views'],
			$result['days_spent'],
			$result['distinct_wikis'],
			$result['edits'],
			$result['creates'],
			$result['posts']
		);
	}
}
