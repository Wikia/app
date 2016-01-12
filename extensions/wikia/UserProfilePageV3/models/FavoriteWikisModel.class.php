<?php
class FavoriteWikisModel extends WikiaModel {
	/**
	 * @var User|null
	 */
	private $user;

	/**
	 * @desc Maximum number of wikis returned at once
	 * @var Integer
	 */
	const MAX_FAV_WIKIS = 4;
	const CACHE_VERSION = '1.00';

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

	/**
	 * @param User $user
	 */
	public function __construct( User $user ) {
		parent::__construct();

		$this->user = $user;
	}

	/**
	 * Gets top wikis from DB for devboxes from method UserIdentityBox::getTestData()
	 *
	 * @param Integer|null $limit
	 *
	 * @return array
	 */
	private function getTopWikisFromDb( $limit = null ) {
		global $wgCityId, $wgDevelEnvironment, $wgSpecialsDB;

		if ( is_null( $limit ) ) {
			$limit = self::MAX_FAV_WIKIS;
		}

		if ( empty( $wgCityId ) ) {
			// staff/internal does not have stats db
			$wikis = [];
		} else if ( $wgDevelEnvironment ) {
			// devboxes uses the same database as production
			// to avoid strange behavior we set test data on devboxes
			$wikis = $this->getTestData( $limit );
		} else {
			$where = [ 'user_id' => $this->user->getId() ];
			$where[] = 'edits > 0';

			$hiddenTopWikis = $this->getHiddenTopWikis();
			if ( count( $hiddenTopWikis ) ) {
				$where[] = 'wiki_id NOT IN (' . join( ',', $hiddenTopWikis ) . ')';
			}

			$dbs = wfGetDB( DB_SLAVE, [], $wgSpecialsDB );
			$res = $dbs->select(
				[ 'events_local_users' ],
				[ 'wiki_id', 'edits' ],
				$where,
				__METHOD__,
				[
					'ORDER BY' => 'edits DESC',
					'LIMIT' => $limit
				]
			);

			$wikis = [];
			while ( $row = $dbs->fetchObject( $res ) ) {
				$wikiId = $row->wiki_id;
				$editCount = $row->edits;
				$wikiName = WikiFactory::getVarValueByName( 'wgSitename', $wikiId );
				$wikiTitle = GlobalTitle::newFromText( $this->user->getName(), NS_USER_TALK, $wikiId );

				if ( $wikiTitle ) {
					$wikiUrl = $wikiTitle->getFullUrl();
					$wikis[$wikiId] = [
						'id' => $wikiId,
						'wikiName' => $wikiName,
						'wikiUrl' => $wikiUrl,
						'edits' => $editCount
					];
				}
			}
		}

		return $wikis;
	}

	/**
	 * Gets top wikis filters them, sorts and returns
	 *
	 * @param Boolean $refreshHidden
	 *
	 * @return array
	 */
	public function getTopWikis( $refreshHidden = false ) {

		if ( $refreshHidden === true ) {
			$this->clearHiddenTopWikis();
		}

		$wikis = array_merge( $this->getTopWikisFromDb(), $this->getEditsWikis() );

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
				'edits' => $userStats['edits'] + 1
			];
			$this->storeEditsWikis( $wikiId, $wiki );
		}

	}

	private function storeEditsWikis( $wikiId, $wiki ) {
		global $wgMemc;

		// getting array of masthead edits wikis
		$mastheadEditsWikis = $wgMemc->get( $this->getMemcMastheadEditsWikisKey() );
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

		$wgMemc->set( $this->getMemcMastheadEditsWikisKey(), $mastheadEditsWikis );

		return $mastheadEditsWikis;
	}

	private function getEditsWikis() {
		global $wgMemc;

		$mastheadEditsWikis = $wgMemc->get( $this->getMemcMastheadEditsWikisKey() );
		$mastheadEditsWikis = is_array( $mastheadEditsWikis ) ? $mastheadEditsWikis : [];

		return $mastheadEditsWikis;
	}

	/**
	 * Gets memcache id for hidden wikis
	 *
	 * @return array
	 */
	private function getMemcHiddenWikisId() {
		return wfSharedMemcKey( 'user-identity-box-data-top-hidden-wikis', $this->user->getId(), self::CACHE_VERSION );
	}

	/**
	 * Clears hidden wikis: the field of this class, DB and memcached data
	 */
	private function clearHiddenTopWikis() {
		global $wgExternalSharedDB, $wgMemc;

		$hiddenWikis = [];
		$this->updateHiddenInDb( wfGetDB( DB_MASTER, [], $wgExternalSharedDB ), $hiddenWikis );
		$wgMemc->set( $this->getMemcHiddenWikisId(), $hiddenWikis );
	}

	/**
	 * @param Integer $limit
	 *
	 * @return array
	 */
	private function getTestData( $limit ) {
		global $wgCityId;

		$wikis = [
			1890 => 5,
			4036 => 35,
			177 => 12,
			831 => 60,
			5687 => 3,
			509 => 20,
			717284 => 2, // corp.wikia.com (hidden wikia; wikia with read right only for staff)
		]; // test data

		foreach ( $wikis as $wikiId => $editCount ) {
			if ( !$this->isTopWikiHidden( $wikiId ) && ( $wikiId != $wgCityId ) ) {
				$wikiName = WikiFactory::getVarValueByName( 'wgSitename', $wikiId );
				$wikiTitle = GlobalTitle::newFromText( $this->user->getName(), NS_USER_TALK, $wikiId );

				if ( $wikiTitle ) {
					$wikiUrl = $wikiTitle->getFullUrl();
					$wikis[$wikiId] = [
						'id' => $wikiId,
						'wikiName' => $wikiName,
						'wikiUrl' => $wikiUrl,
						'edits' => $editCount
					];
				} else {
					unset( $wikis[$wikiId] );
				}
			} else {
				unset( $wikis[$wikiId] );
			}
		}

		return array_slice( $wikis, 0, $limit, true );
	}

	/**
	 * Gets hidden top wikis
	 *
	 * @return array
	 */
	private function getHiddenTopWikis() {
		global $wgMemc, $wgExternalSharedDB;

		$hiddenWikis = $wgMemc->get( $this->getMemcHiddenWikisId() );

		if ( empty( $hiddenWikis ) && !is_array( $hiddenWikis ) ) {
			$dbs = wfGetDB( DB_SLAVE, [], $wgExternalSharedDB );
			$hiddenWikis = $this->getHiddenFromDb( $dbs );
			$wgMemc->set( $this->getMemcHiddenWikisId(), $hiddenWikis );
		}

		return $hiddenWikis;
	}

	/**
	 * Adds hidden top wiki; code from UPP2
	 *
	 * @param Integer $wikiId
	 *
	 * @return array
	 */
	public function hideWiki( $wikiId ) {
		global $wgExternalSharedDB, $wgMemc;

		if ( !$this->isTopWikiHidden( $wikiId ) ) {
			$hiddenWikis = $this->getHiddenTopWikis();
			$hiddenWikis[] = $wikiId;
			$this->updateHiddenInDb( wfGetDB( DB_MASTER, [], $wgExternalSharedDB ), $hiddenWikis );
			$wgMemc->set( $this->getMemcHiddenWikisId(), $hiddenWikis );
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

	/**
	 * Returns shared key in memcached
	 *
	 * @return string
	 */
	private function getMemcMastheadEditsWikisKey() {
		return wfSharedMemcKey( 'user-identity-box-data-masthead-edits0', $this->user->getId(), self::CACHE_VERSION );
	}
}
