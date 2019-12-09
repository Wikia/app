<?php

declare( strict_types=1 );

final class YearAtFandomDataProvider {
	private const FALLBACK_THUMBNAIL = 'https://vignette.wikia.nocookie.net/ludwiktestwiki/images/c/c3/Background5.jpg/revision/latest';
	/** @var DatabaseType */
	private $statsDB;

	public function __construct() {
		global $wgDWStatsDB;
		$this->statsDB = wfGetDB( DB_SLAVE, [], $wgDWStatsDB );
	}

	public function getAll( int $userId ): UserStatistics {
		$userWikiPageviews = $this->getWikiPageViews( $userId );

		return new UserStatistics(
			$this->getSummary( $userId ),
			$userWikiPageviews,
			$this->getArticlePageViews( $userId ),
			$this->getUserContributionsPageviews( $userId, $userWikiPageviews ),
			$this->topWikiPageviews()
		);
	}

	private function getUserContributionsPageviews( int $userId, WikiActivityList $activityList ): ArticlePageViewsList {
		return ArticlePageViewsList::empty();
		$articlePageViewsList = [];

		foreach ($activityList as $activity) {
			$articleIds = $this->getUserContributionsForWiki( $userId, $activity->wikiDBName() );

			if (empty($articleIds)) {
				continue;
			}
			foreach ($articleIds as $id) {
				$result = $this->statsDB->select(
					'rollup_wiki_article_pageviews',
					['article_id', 'wiki_id', 'SUM(pageviews) as totalPageviews'],
					[
						'article_id' => $id,
						'YEAR(time_id) = 2019',
					],
					__METHOD__,
					[
						'GROUP BY' =>  ['wiki_id', 'article_id'],
						'ORDER BY' => 'totalPageviews DESC',
						'LIMIT' => 5
					]
				);

				if ($result->numRows() === 0 ) {
					continue;
				}

				foreach ($result as $row) {
					$title = GlobalTitle::newFromId( (int) $row->article_id, $activity->wikiId, $activity->wikiDBName() );

					if (!$title) {
						continue;
					}

					$articlePageViewsList[] = new ArticlePageViews(
						(int) $row->article_id,
						(int) $row->wiki_id,
						(int) $row->totalPageviews,
						$title->getText(),
						$title->getFullURL()
					);
				}
			}
		}

		return new ArticlePageViewsList( $articlePageViewsList );
	}

	/**
	 * @return int[] article ids
	 */
	private function getUserContributionsForWiki( int $userId, string $wikiDBName ): array {
		$db = wfGetDB( DB_SLAVE, [], $wikiDBName );

		return $db->selectFieldValues(
			'revision',
			'rev_page',
			['rev_user' => $userId],
			__FUNCTION__,
			[
				'DISTINCT'
			]
		);
	}

	private function getArticlePageViews( int $userId ): ArticlePageViewsList {
		$result = $this->statsDB->select(
			'user_article_aggregates',
			[ '*' ],
			[ 'user_id' => $userId ],
			__METHOD__,
			[
				'ORDER BY' => 'sum_pv DESC',
				'LIMIT' => 5
			]
		);

		$list = [];

		foreach ( $result as $row ) {
			$title = GlobalTitle::newFromId( (int) $row->article_id, (int) $row->wiki_id );

			if (!isset($title)) {
				continue;
			}

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
			[ 'user_id' => $userId ],
			__METHOD__,
			[
				'ORDER BY' => 'sum_pv DESC',
				'LIMIT' => 5
			]
		);

		$list = [];

		foreach ( $result as $row ) {
			$wikiId = (int)$row->wiki_id;
			$categoryInfo = HubService::getCategoryInfoForCity( $wikiId );
			$wikicity = WikiFactory::getWikiByID( $wikiId );
			$thumbnail = $this->getWikiThumbnail( $wikiId );

			if (!isset($wikicity->city_dbname)) {
				continue;
			}

			$list[] = new WikiActivity(
				$wikiId,
				$wikicity->city_dbname,
				(int) $row->sum_pv,
				(int) $categoryInfo->cat_id,
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
			return self::FALLBACK_THUMBNAIL;
		}
		$imageServing = new ImageServing( [ $service->getCommunityImageId() ], 1080, [ 'w' => 3, 'h' => 2 ] );
		$images = $imageServing->getImages( 1 );

		return $images[$service->getCommunityImageId()][0]['url'] ?? self::FALLBACK_THUMBNAIL;
	}

	private function topWikiPageviews(): WikiPageviewsList {
		$result = $this->statsDB->select(
			'top_wikis',
			[ '*' ],
			[],
			__METHOD__,
			[
				'LIMIT' => 25,
				'ORDER BY' => 'wiki_pos ASC'
			]
		);

		$list = [];

		foreach ( $result as $row ) {
			$list[] = new WikiPageviews( (int)$row->wiki_id, (int)$row->wiki_pos, $row->title, (int)$row->sum_pv );
		}

		return new WikiPageviewsList( $list );
	}
}
