<?php

declare( strict_types=1 );

final class YearAtFandomDataProvider {
	/** @var DatabaseType */
	private $sharedDb;
	/** @var DatabaseType */
	private $warehouseDb;

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
			$title = GlobalTitle::newFromId( (int) $row->article_id, (int) $row->wiki_id );
			$list[] = new ArticlePageViews(
				(int) $row->article_id,
				(int) $row->wiki_id,
				(int) $row->sum_pv,
				$title->getText(),
				$title->getFullURL()
			);
		}

		return new ArticlePageViewsList( $list );
	}

	private function getWikiPageViews( int $userId ): WikiActivityList {
		$result = $this->warehouseDb->select(
			'user_community_aggregates',
			[ '*' ],
			[ 'user_id' => $userId ]
		);

		$list = [];

		foreach ( $result as $row ) {
			$wikiId = (int)$row->wiki_id;
			$categoryInfo = HubService::getCategoryInfoForCity( $wikiId );
			$wikicity = WikiFactory::getWikiByID( $wikiId );
			$thumbnail = $this->getWikiThumbnail( $wikiId );

			$list[] = new WikiActivity(
				$wikiId,
				(int) $row->sum_pv,
				$categoryInfo->cat_id,
				$categoryInfo->cat_name,
				$wikicity->city_title,
				$wikicity->city_url,
				$thumbnail
			);
		}

		return new WikiActivityList( $list );
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
			(int) $result['total_pv'],
			(int) $result['days'],
			(int) $result['dist_wikis'],
			(int) $result['edits'],
			(int) $result['creates'],
			(int) $result['posts']
		);
	}

	private function getWikiThumbnail( int $wikiId ): ?string {
		$service = new CommunityDataService( $wikiId );
		if ( empty( $service->getCommunityImageId() ) ) {
			return null;
		}
		$imageServing =
			new ImageServing( [ $service->getCommunityImageId() ], 1080, [ 'w' => 3, 'h' => 2 ] );
		$images = $imageServing->getImages( 1 );

		return $images[$service->getCommunityImageId()][0]['url'] ?? null;
	}
}
