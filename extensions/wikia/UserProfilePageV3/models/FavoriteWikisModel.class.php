<?php

/**
 * Class FavoriteWikisModel
 */
class FavoriteWikisModel extends WikiaModel {
	/** @var User|null */
	private $user;

	/**
	 * @desc Maximum number of wikis returned at once
	 * @var Integer
	 */
	const MAX_FAV_WIKIS = 4;

	// 3600 == 60 * 60 == 1 hr
	const SAVED_WIKIS_TTL = 3600;

	/**
	 * Used in User Profile Page extension;
	 * It's a kind of category of rows stored in page_wikia_props table
	 * -- it's a value of propname column;
	 * If a data row from this table has this field set to 10 it means that
	 * in props value you should get an unserialized array of wikis' ids.
	 *
	 * @var integer
	 */
	const PAGE_WIKIA_PROPS_PROPNAME = 10;

	/** @var UserIdCacheKeys */
	private $cacheKeys;

	public function __construct( User $user ) {
		parent::__construct();
		$this->user = $user;
		$this->cacheKeys = new UserIdCacheKeys( $user->getId() );
	}

	/**
	 * Gets top wikis from stats DB based on number of edits
	 *
	 * @param Integer|null $limit
	 *
	 * @return array
	 */
	private function getTopWikisFromDb( $limit = self::MAX_FAV_WIKIS ) {
		global $wgDWStatsDB;

		$dbr = wfGetDB(DB_SLAVE, [], $wgDWStatsDB );
		$where = [
			'period_id' => DataMartService::PERIOD_ID_MONTHLY,
			'time_id >= NOW() - INTERVAL 90 DAY', // process only recent 90 days
			'user_id' => $this->user->getId(),
		];

		$hiddenTopWikis = $this->getHiddenTopWikis();
		if ( count( $hiddenTopWikis ) ) {
			$hiddenTopWikis = array_map(
				function( $city_id ) { return intval( $city_id); },
				$hiddenTopWikis
			);

			$where[] = sprintf( 'wiki_id NOT IN (%s)', join(',', $hiddenTopWikis) );
		}

		$res = $dbr->select(
			'rollup_wiki_user_events',
			[
				'wiki_id',
				'SUM(edits) AS edits',
			],
			$where,
			__METHOD__,
			[
				'LIMIT' => $limit,
				'ORDER BY' => 'edits DESC',
				'GROUP BY' => 'wiki_id'
			]
		);

		$wikis = [];

		foreach($res as $row) {
			$entry = $this->getTopWikiDataFromRow( $row );

			if ($entry !== false) {
				$wikis[] = $entry;
			}
		}

		return $wikis;
	}

	/**
	 * @param object $row
	 * @return array|false
	 */
	private function getTopWikiDataFromRow( $row ) {
		$wikiId = (int) $row->wiki_id;
		$wikiTitle = GlobalTitle::newFromText( $this->user->getName(), NS_USER_TALK, $wikiId );
		$wikiName = WikiFactory::getVarValueByName( 'wgSitename', $wikiId );

		if ( empty( $wikiTitle ) || empty ($wikiName ) ) {
			return false;
		}

		$editCount = (int) $row->edits;
		$wikiUrl = $wikiTitle->getFullUrl();

		return [
			'id' => $wikiId,
			'wikiName' => $wikiName,
			'wikiUrl' => $wikiUrl,
			'edits' => $editCount
		];
	}

	/**
	 * Gets top wikis filters them, sorts and returns
	 *
	 * @param Boolean $refreshHidden
	 *
	 * @return array
	 */
	public function getTopWikis( $refreshHidden = false ) {
		if ( $refreshHidden ) {
			$this->clearHiddenTopWikis();
		}

		$savedWikis = WikiaDataAccess::cache(
			$this->cacheKeys->forFavoriteWikis(),
			self::SAVED_WIKIS_TTL,
			function () {
				return $this->getTopWikisFromDb();
			}
		);

		$wikis = array_merge( $savedWikis, $this->getEditsWikis() );

		$filter = new UserWikisFilterPrivateDecorator(
			new UserWikisFilterRestrictedDecorator(
				new UserWikisFilterUniqueDecorator(
					new HiddenWikisFilter( $wikis, $this->getHiddenTopWikis() )
				)
			)
		);
		$wikis = $filter->getFiltered();

		return $this->sortTopWikis( $wikis );
	}

	/**
	 * Sorts top (fav) wikis by edits and cuts if there are more than default amount of top wikis
	 *
	 * @param array $topWikis
	 *
	 * @return array
	 */
	private function sortTopWikis( $topWikis ) {
		if ( !empty( $topWikis ) ) {
			$editcounts = [];

			foreach ( $topWikis as $key => $row ) {
				if ( isset( $row['edits'] ) ) {
					$editcounts[$key] = $row['edits'];
				} else {
					unset( $topWikis[$key] );
				}
			}

			if ( !empty( $editcounts ) ) {
				array_multisort( $editcounts, SORT_DESC, $topWikis );
			}

						return array_slice( $topWikis, 0, self::MAX_FAV_WIKIS, true );
		}

		return $topWikis;
	}

	/**
	 * Adds to memchached top wikis new wiki
	 *
	 * @param Integer $wikiId wiki id
	 *
	 * @return void
	 */
	public function addTopWiki( $wikiId ) {
		global $wgUser;

		$wikiName = WikiFactory::getVarValueByName( 'wgSitename', $wikiId );
		$wikiTitle = GlobalTitle::newFromText( $this->user->getName(), NS_USER_TALK, $wikiId );

		if ( $wikiTitle instanceof Title ) {
			$wikiUrl = $wikiTitle->getFullUrl();

			/** @var $userStatsService UserStatsService */
			$userStatsService = new UserStatsService( $wgUser->getId() );
			$userStats = $userStatsService->getStats();

			// adding new wiki to topWikis in cache
			$wiki = [
				'id' => $wikiId,
				'wikiName' => $wikiName,
				'wikiUrl' => $wikiUrl,
				'edits' => $userStats['editcount'] + 1
			];
			$this->storeEditsWikis( $wikiId, $wiki );
		}
	}

	private function storeEditsWikis( $wikiId, $wiki ) {
		global $wgMemc;

		// getting array of masthead edits wikis
		$mastheadEditsWikis = $wgMemc->get( $this->cacheKeys->forMastheadEdits() );
		if ( !is_array( $mastheadEditsWikis ) ) {
			$mastheadEditsWikis = [];
		}

		if ( count( $mastheadEditsWikis ) < 20 ) {
			$mastheadEditsWikis[$wikiId] = $wiki;
		} else {
			if ( array_key_exists( $wikiId, $mastheadEditsWikis ) ) {
				// mech: BugId 21198 - even if the array is full, it is still nice if we update existing entries
				$mastheadEditsWikis[$wikiId] = $wiki;
			}
		}

		$wgMemc->set( $this->cacheKeys->forMastheadEdits(), $mastheadEditsWikis );

		return $mastheadEditsWikis;
	}

	/**
	 * @return array
	 */
	private function getEditsWikis() {
		global $wgMemc;

		$mastheadEditsWikis = $wgMemc->get( $this->cacheKeys->forMastheadEdits() );
		return is_array( $mastheadEditsWikis ) ? $mastheadEditsWikis : [];
	}

	/**
	 * Clears hidden wikis: the field of this class, DB and memcached data
	 */
	private function clearHiddenTopWikis() {
		global $wgExternalSharedDB, $wgMemc;

		$hiddenWikis = [];
		$this->updateHiddenInDb( wfGetDB( DB_MASTER, [], $wgExternalSharedDB ), $hiddenWikis );
		$wgMemc->set( $this->cacheKeys->forHiddenWikis(), $hiddenWikis );
	}

	/**
	 * Gets hidden top wikis
	 *
	 * @return array
	 */
	private function getHiddenTopWikis() {
		global $wgMemc, $wgExternalSharedDB;

		$hiddenWikis = $wgMemc->get( $this->cacheKeys->forHiddenWikis() );

		if ( empty( $hiddenWikis ) && !is_array( $hiddenWikis ) ) {
			$dbs = wfGetDB( DB_SLAVE, [], $wgExternalSharedDB );
			$hiddenWikis = $this->getHiddenFromDb( $dbs );
			$wgMemc->set( $this->cacheKeys->forHiddenWikis(), $hiddenWikis );
		}

		return $hiddenWikis;
	}

	/**
	 * Adds hidden top wiki; code from UPP2
	 *
	 * @param Integer $wikiId
	 *
	 * @return bool
	 */
	public function hideWiki( $wikiId ) {
		global $wgExternalSharedDB, $wgMemc;

		if ( !$this->isTopWikiHidden( $wikiId ) ) {
			$hiddenWikis = $this->getHiddenTopWikis();
			$hiddenWikis[] = $wikiId;
			$this->updateHiddenInDb( wfGetDB( DB_MASTER, [], $wgExternalSharedDB ), $hiddenWikis );
			$wgMemc->set( $this->cacheKeys->forHiddenWikis(), $hiddenWikis );
		}

		return true;
	}

	/**
	 * @brief auxiliary method for getting hidden pages/wikis from db
	 *
	 * @param DatabaseBase $dbHandler
	 *
	 * @author ADi
	 * @return array
	 */
	private function getHiddenFromDb( $dbHandler ) {
		$result = false;

		if ( !$this->user->isAnon() ) {
			$row = $dbHandler->selectRow(
				[ 'page_wikia_props' ],
				[ 'props' ],
				[
					'page_id' => $this->user->getId(),
					'propname' => self::PAGE_WIKIA_PROPS_PROPNAME
				],
				__METHOD__,
				[]
			);

			if ( !empty( $row ) ) {
				$result = unserialize( $row->props );
			}

			$result = empty( $result ) ? [] : $result;
		}

		return $result;
	}

	/**
	 * Auxiliary method for updating hidden pages in db
	 *
	 * @param DatabaseBase $dbHandler
	 * @param $data
	 */
	private function updateHiddenInDb( $dbHandler, $data ) {

		$dbHandler->replace(
			'page_wikia_props',
			null,
			[
				'page_id' => $this->user->getId(),
				'propname' => self::PAGE_WIKIA_PROPS_PROPNAME,
				'props' => serialize( $data )
			],
			__METHOD__
		);
		$dbHandler->commit();

	}

	/**
	 * Checks whenever wiki is in hidden wikis; code from UPP2
	 *
	 * @param integer $wikiId id of wiki which we want to be chacked
	 *
	 * @return boolean
	 */
	private function isTopWikiHidden( $wikiId ) {
		return in_array( $wikiId, $this->getHiddenTopWikis() );
	}
}
