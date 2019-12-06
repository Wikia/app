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
		global $wgExternalSharedDB, $wgDWStatsDB;
		$this->sharedDb = wfGetDB( DB_SLAVE, [], $wgExternalSharedDB );
		$this->warehouseDb = wfGetDB( DB_SLAVE, [], $wgDWStatsDB );
		$this->hubService = new HubService();
	}

	public function getAll( int $userId ): UserStatistics {
		return new UserStatistics(
			$this->getSummary( $userId ),
			$this->getWikiPageViews( $userId ),
			$this->getArticlePageViews( $userId )
		);
	}

	private function getArticlePageViews( int $userId ): ArticlePageViewsList {
		$result = $this->warehouseDb->select(
			'user_article_aggregates',
			[ '*' ],
			[ 'user_id' => $userId ]
		);

		$list = [];

		foreach ( $result as $row ) {
			$list[] = new ArticlePageViews( $row->article_id, $row->wiki_id, $row->sum_pv );
		}

		return new ArticlePageViewsList( $list );
	}

	private function getWikiPageViews( int $userId ): WikiPageViewsList {
		$result = $this->warehouseDb->select(
			'user_community_aggregates',
			[ '*' ],
			[ 'user_id' => $userId ]
		);

		$list = [];

		foreach ( $result as $row ) {
			$list[] = new WikiPageViews( $row->wiki_id, $row->sum_pv );
		}

		return new WikiPageViewsList( $list );
	}

	private function getSummary( int $userId ): UserSummary {
		$result = $this->warehouseDb->select(
			'user_aggregates',
			[ '*' ],
			[ 'user_id' => $userId ]
		)->fetchRow();

		if (!$result) {
			return UserSummary::missing();
		}

		return new UserSummary(
			$result['total_pv'],
			$result['days'],
			$result['dist_wikis'],
			$result['edits'],
			$result['creates'],
			$result['posts']
		);
	}
}
