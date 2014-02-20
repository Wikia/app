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
		$this->user = $user;
	}

	/**
	 * @brief Gets top wikis from DB for devboxes from method UserIdentityBox::getTestData()
	 *
	 * @param Integer|null $limit
	 *
	 * @return array
	 */
	private function getTopWikisFromDb( $limit = null ) {
		global $wgCityId, $wgDevelEnvironment, $wgStatsDB;
		wfProfileIn(__METHOD__);

		if (is_null($limit)) {
			$limit = self::MAX_FAV_WIKIS;
		}

		if ( empty( $wgCityId ) ) {
			// staff/internal does not have stats db
			$wikis = array();
		} else if ( $wgDevelEnvironment ) {
			//devboxes uses the same database as production
			//to avoid strange behavior we set test data on devboxes
			$wikis = $this->getTestData($limit);
		} else {
			$where = array('user_id' => $this->user->getId());
			$where[] = 'edits > 0';

			$hiddenTopWikis = $this->getHiddenTopWikis();
			if (count($hiddenTopWikis)) {
				$where[] = 'wiki_id NOT IN (' . join(',', $hiddenTopWikis) . ')';
			}

			$dbs = wfGetDB( DB_SLAVE, array(), $wgStatsDB );
			$res = $dbs->select(
				array('specials.events_local_users'),
				array('wiki_id', 'edits'),
				$where,
				__METHOD__,
				array(
					'ORDER BY' => 'edits DESC',
					'LIMIT' => $limit
				)
			);

			$wikis = array();
			while ($row = $dbs->fetchObject($res)) {
				$wikiId = $row->wiki_id;
				$editCount = $row->edits;
				$wikiName = WikiFactory::getVarValueByName('wgSitename', $wikiId);
				$wikiTitle = GlobalTitle::newFromText($this->user->getName(), NS_USER_TALK, $wikiId);

				if ($wikiTitle) {
					$wikiUrl = $wikiTitle->getFullUrl();
					$wikis[$wikiId] = array('id' => $wikiId, 'wikiName' => $wikiName, 'wikiUrl' => $wikiUrl, 'edits' => $editCount);
				}
			}
		}

		wfProfileOut(__METHOD__);
		return $wikis;
	}

	/**
	 * @brief Gets top wikis filters them, sorts and returns
	 *
	 * @param Boolean $refreshHidden
	 *
	 * @return array
	 */
	public function getTopWikis( $refreshHidden = false ) {
		wfProfileIn( __METHOD__ );

		if ( $refreshHidden === true ) {
			$this->clearHiddenTopWikis();
		}

		$wikis = array_merge( $this->getTopWikisFromDb(), $this->getEditsWikis() );

		$filter = new UserWikisFilterRestrictedDecorator(
			new UserWikisFilterUniqueDecorator(
				new HiddenWikisFilter( $wikis, $this->getHiddenTopWikis() )
			)
		);
		$wikis = $filter->getFiltered();

		wfProfileOut( __METHOD__ );
		return $this->sortTopWikis( $wikis );
	}

	/**
	 * @brief Sorts top (fav) wikis by edits and cuts if there are more than default amount of top wikis
	 *
	 * @param array $topWikis
	 *
	 * @return array
	 */
	private function sortTopWikis($topWikis) {
		wfProfileIn(__METHOD__);

		if (!empty($topWikis)) {
			$editcounts = array();

			foreach ($topWikis as $key => $row) {
				if (isset($row['edits'])) {
					$editcounts[$key] = $row['edits'];
				} else {
					unset($topWikis[$key]);
				}
			}

			if (!empty($editcounts)) {
				array_multisort($editcounts, SORT_DESC, $topWikis);
			}

			wfProfileOut(__METHOD__);
			return array_slice($topWikis, 0, self::MAX_FAV_WIKIS, true);
		}

		wfProfileOut(__METHOD__);
		return $topWikis;
	}

	/**
	 * @brief Adds to memchached top wikis new wiki
	 *
	 * @param integer $wikiId wiki id
	 *
	 * @return void
	 */
	public function addTopWiki( $wikiId ) {
		global $wgUser;
		wfProfileIn(__METHOD__);

		$wikiName = WikiFactory::getVarValueByName('wgSitename', $wikiId);
		$wikiTitle = GlobalTitle::newFromText($this->user->getName(), NS_USER_TALK, $wikiId);

		if ($wikiTitle instanceof Title) {
			$wikiUrl = $wikiTitle->getFullUrl();

			/** @var $userStatsService UserStatsService */
			$userStatsService = new UserStatsService( $wgUser->getId() );
			$userStats = $userStatsService->getStats();

			//adding new wiki to topWikis in cache
			$wiki = array('id' => $wikiId, 'wikiName' => $wikiName, 'wikiUrl' => $wikiUrl, 'edits' => $userStats['edits'] + 1);
			$this->storeEditsWikis($wikiId, $wiki);
		}

		wfProfileOut(__METHOD__);
	}

	private function storeEditsWikis($wikiId, $wiki) {
		global $wgMemc;
		wfProfileIn(__METHOD__);

		//getting array of masthead edits wikis
		$mastheadEditsWikis = $wgMemc->get( $this->getMemcMastheadEditsWikisKey(), [] );
		if (!is_array($mastheadEditsWikis)) {
			$mastheadEditsWikis = array();
		}

		if (count($mastheadEditsWikis) < 20) {
			$mastheadEditsWikis[$wikiId] = $wiki;
		} else {
			if (array_key_exists($wikiId, $mastheadEditsWikis)) {
				// mech: BugId 21198 - even if the array is full, it is still nice if we update existing entries
				$mastheadEditsWikis[$wikiId] = $wiki;
			}
		}

		$wgMemc->set( $this->getMemcMastheadEditsWikisKey(), $mastheadEditsWikis );

		wfProfileOut(__METHOD__);
		return $mastheadEditsWikis;
	}

	private function getEditsWikis() {
		global $wgMemc;
		wfProfileIn( __METHOD__ );

		$mastheadEditsWikis = $wgMemc->get( $this->getMemcMastheadEditsWikisKey(), null );
		$mastheadEditsWikis = is_array( $mastheadEditsWikis ) ? $mastheadEditsWikis : [];

		wfProfileOut( __METHOD__ );
		return $mastheadEditsWikis;
	}

	/**
	 * @brief Gets memcache id for hidden wikis
	 *
	 * @return array
	 */
	private function getMemcHiddenWikisId() {
		return wfSharedMemcKey( 'user-identity-box-data-top-hidden-wikis', $this->user->getId(), self::CACHE_VERSION );
	}

	/**
	 * @brief Clears hidden wikis: the field of this class, DB and memcached data
	 */
	private function clearHiddenTopWikis() {
		global $wgExternalSharedDB, $wgMemc;
		wfProfileIn(__METHOD__);

		$hiddenWikis = array();
		$this->updateHiddenInDb( wfGetDB( DB_MASTER, [], $wgExternalSharedDB ), $hiddenWikis );
		$wgMemc->set($this->getMemcHiddenWikisId(), $hiddenWikis);

		wfProfileOut(__METHOD__);
	}

	/**
	 * @param Integer $limit
	 *
	 * @return array
	 */
	private function getTestData($limit) {
		global $wgCityId;
		wfProfileIn(__METHOD__);

		$wikis = [
			1890 => 5,
			4036 => 35,
			177 => 12,
			831 => 60,
			5687 => 3,
			509 => 20,
			717284 => 2, // corp.wikia.com (hidden wikia; wikia with read right only for staff)
		]; //test data

		foreach ($wikis as $wikiId => $editCount) {
			if ( !$this->isTopWikiHidden( $wikiId ) && ( $wikiId != $wgCityId ) ) {
				$wikiName = WikiFactory::getVarValueByName('wgSitename', $wikiId);
				$wikiTitle = GlobalTitle::newFromText($this->user->getName(), NS_USER_TALK, $wikiId);

				if ($wikiTitle) {
					$wikiUrl = $wikiTitle->getFullUrl();
					$wikis[$wikiId] = array('id' => $wikiId, 'wikiName' => $wikiName, 'wikiUrl' => $wikiUrl, 'edits' => $editCount);
				} else {
					unset($wikis[$wikiId]);
				}
			} else {
				unset($wikis[$wikiId]);
			}
		}

		wfProfileOut(__METHOD__);
		return array_slice($wikis, 0, $limit, true);
	}

	/**
	 * @brief Gets hidden top wikis
	 *
	 * @return array
	 *
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	private function getHiddenTopWikis() {
		global $wgMemc, $wgExternalSharedDB;
		wfProfileIn(__METHOD__);

		$hiddenWikis = $wgMemc->get( $this->getMemcHiddenWikisId() );

		if ( empty( $hiddenWikis ) && !is_array( $hiddenWikis ) ) {
			$dbs = wfGetDB( DB_SLAVE, [], $wgExternalSharedDB );
			$hiddenWikis = $this->getHiddenFromDb( $dbs );
			$wgMemc->set( $this->getMemcHiddenWikisId(), $hiddenWikis );
		}

		wfProfileOut(__METHOD__);
		return $hiddenWikis;
	}

	/**
	 * @brief adds hidden top wiki; code from UPP2
	 *
	 * @param Integer $wikiId
	 * @return array
	 *
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	public function hideWiki( $wikiId ) {
		global $wgExternalSharedDB, $wgMemc;
		wfProfileIn( __METHOD__ );

		if( !$this->isTopWikiHidden( $wikiId ) ) {
			$hiddenWikis = $this->getHiddenTopWikis();
			$hiddenWikis[] = $wikiId;
			$this->updateHiddenInDb( wfGetDB( DB_MASTER, [], $wgExternalSharedDB ), $hiddenWikis );
			$wgMemc->set( $this->getMemcHiddenWikisId(), $hiddenWikis );
		}

		wfProfileOut( __METHOD__ );
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
	private function getHiddenFromDb($dbHandler) {
		wfProfileIn(__METHOD__);
		$result = false;

		if (!$this->user->isAnon()) {
			$row = $dbHandler->selectRow(
				array('page_wikia_props'),
				array('props'),
				array('page_id' => $this->user->getId(), 'propname' => self::PAGE_WIKIA_PROPS_PROPNAME),
				__METHOD__,
				array()
			);

			if (!empty($row)) {
				$result = unserialize($row->props);
			}

			$result = empty($result) ? array() : $result;
		}

		wfProfileOut(__METHOD__);
		return $result;
	}

	/**
	 * auxiliary method for updating hidden pages in db
	 * @author ADi
	 */
	private function updateHiddenInDb($dbHandler, $data) {
		wfProfileIn(__METHOD__);

		$dbHandler->replace(
			'page_wikia_props',
			null,
			array('page_id' => $this->user->getId(), 'propname' => self::PAGE_WIKIA_PROPS_PROPNAME, 'props' => serialize($data)),
			__METHOD__
		);
		$dbHandler->commit();

		wfProfileOut(__METHOD__);
	}

	/**
	 * @brief Checks whenever wiki is in hidden wikis; code from UPP2
	 *
	 * @param integer $wikiId id of wiki which we want to be chacked
	 *
	 * @return boolean
	 */
	private function isTopWikiHidden( $wikiId ) {
		return in_array( $wikiId, $this->getHiddenTopWikis() );
	}

	/**
	 * @brief Returns shared key in memcached
	 *
	 * @return string
	 */
	private function getMemcMastheadEditsWikisKey() {
		return wfSharedMemcKey( 'user-identity-box-data-masthead-edits0', $this->user->getId(), self::CACHE_VERSION );
	}

}
