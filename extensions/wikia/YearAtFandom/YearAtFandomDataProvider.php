<?php

declare( strict_types=1 );

final class YearAtFandomDataProvider {
	/** @var DatabaseType */
	private $sharedDb;
	/** @var DatabaseType */
	private $statsDB;

	public function __construct() {
		global $wgExternalSharedDB, $wgDWStatsDB;
		$this->sharedDb = wfGetDB( DB_SLAVE, [], $wgExternalSharedDB );
		$this->statsDB = wfGetDB( DB_SLAVE, [], $wgDWStatsDB );
		$this->hubService = new HubService();
	}

	public function getAll( int $userId ): UserStatistics {
		$wikiPageviews = $this->getWikiPageViews( $userId );

		return new UserStatistics(
			$this->getSummary( $userId ),
			$wikiPageviews,
			$this->getArticlePageViews( $userId ),
			$this->getUserContributionsPageviews( $userId, $wikiPageviews )
		);
	}

	private function getUserContributionsPageviews( int $userId, WikiActivityList $activityList ): ArticlePageViewsList {
		$articlePageViewsList = [];

		foreach ($activityList as $activity) {
			$articleIds = $this->getUserContributionsForWiki( $userId, $activity->wikiDBName() );

			if (empty($articleIds)) {
				continue;
			}

			$result = $this->statsDB->select(
				'rollup_wiki_article_pageviews',
				['article_id', 'wiki_id', 'SUM(pageviews) as totalPageviews'],
				[
					'article_id' => $articleIds
				],
				__METHOD__,
				[
					'GROUP BY wiki_id, article_id'
				]
			);

			foreach ($result as $row) {
				$title = GlobalTitle::newFromId( (int) $row->article_id, (int) $row->wiki_id );
				$articlePageViewsList[] = new ArticlePageViews(
					(int) $row->article_id,
					(int) $row->wiki_id,
					(int) $row->totalPageviews,
					$title->getText(),
					$title->getFullURL()
				);
			}
		}

		return new ArticlePageViewsList( $articlePageViewsList );
	}

	/**
	 * @return int[] article ids
	 */
	private function getUserContributionsForWiki( int $userId, string $wikiDBName ): array {
		$db = wfGetDB( DB_SLAVE, [], $wikiDBName );

		return $db->selectFieldValues( 'revision', 'rev_page', ['rev_user' => $userId] );
	}

	private function getArticlePageViews( int $userId ): ArticlePageViewsList {
		$result = $this->statsDB->select(
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
		$result = $this->statsDB->select(
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
				$wikicity->city_dbname,
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
		$result = $this->statsDB->select(
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
		$imageServing = new ImageServing( [ $service->getCommunityImageId() ], 1080, [ 'w' => 3, 'h' => 2 ] );
		$images = $imageServing->getImages( 1 );

		return $images[$service->getCommunityImageId()][0]['url'] ?? null;
	}
}
