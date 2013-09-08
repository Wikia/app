<?php

class UserIdentityBox {
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
	const CACHE_VERSION = 2;

	/**
	 * Prefixes to memc keys etc.
	 */
	const USER_PROPERTIES_PREFIX = 'UserProfilePagesV3_';
	const USER_EDITED_MASTHEAD_PROPERTY = 'UserProfilePagesV3_mastheadEdited_';
	const USER_FIRST_MASTHEAD_EDIT_DATE_PROPERTY = 'UserProfilePagesV3_mastheadEditDate_';
	const USER_MASTHEAD_EDITS_WIKIS = 'UserProfilePagesV3_mastheadEditsWikis_';
	const USER_EVER_EDITED_MASTHEAD = 'UserProfilePagesV3_mastheadEditedEver';

	/**
	 * Char limits for user's input fields
	 */
	const USER_NAME_CHAR_LIMIT = 40;
	const USER_LOCATION_CHAR_LIMIT = 200;
	const USER_OCCUPATION_CHAR_LIMIT = 200;
	const USER_GENDER_CHAR_LIMIT = 200;

	private $user = null;
	private $app = null;
	private $title = null;
	private $topWikisLimit = 5;

	public $optionsArray = array(
		'location',
		'occupation',
		'birthday',
		'gender',
		'website',
		'avatar',
		'twitter',
		'fbPage',
		'name',
		'hideEditsWikis',
	);

	/**
	 * @param WikiaApp $app wikia appliacation object
	 * @param User $user core user object
	 * @param integer $topWikisLimit limit of top wikis
	 */
	public function __construct(WikiaApp $app, User $user, $topWikisLimit) {
		$this->app = $app;
		$this->user = $user;
		$this->topWikisLimit = $topWikisLimit;
		$this->title = $this->app->wg->Title;

		if (is_null($this->title)) {
			$this->title = $this->user->getUserPage();
		}
	}

	/**
	 * Creates an array with user's data without some properties
	 * @return array
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	public function getData() {
		wfProfileIn(__METHOD__);
		$data = $this->getUserData('getEmptyData');
		wfProfileOut(__METHOD__);
		return $data;

	}

	public function getFullData() {
		wfProfileIn(__METHOD__);
		$data = $this->getUserData('getDefaultData');
		wfProfileOut(__METHOD__);
		return $data;
	}

	protected function getUserData($dataType) {
		wfProfileIn(__METHOD__);

		$userName = $this->user->getName();
		$userId = $this->user->getId();

		//this data is always the same -- on each wiki
		$data = $this->getSharedUserData($userId, $userName);

		if ($this->user->isAnon()) {
			//if user doesn't exist
			$data = $this->populateAnonData($data, $userName);

			$this->getUserTags( $data );
		} else {
			$wikiId = $this->app->wg->CityId;

			if (empty($this->userStats)) {
				/** @var $userStatsService UserStatsService */
				$userStatsService = new UserStatsService($userId);
				$this->userStats = $userStatsService->getStats();
			}

			$iEdits = $this->userStats['edits'];
			$iEdits = $data['edits'] = is_null($iEdits) ? 0 : intval($iEdits);

			//data depends on which wiki it is displayed
			$data['registration'] = $this->userStats['date'];
			$data['userPage'] = $this->user->getUserPage()->getFullURL();

			$data = call_user_func(array($this, $dataType), $data);

			if(!( $iEdits || $this->shouldDisplayFullMasthead() )) {
				$data = $this->getEmptyData($data);
			}

			$data = $this->getInternationalizedRegistrationDate($wikiId, $data);
			if(!empty($data['edits'])) {
				$data['edits'] = $this->app->wg->Lang->formatNum($data['edits']);
			}

			//other data operations
			$this->getUserTags($data);
			$data = $this->extractBirthDate($data);
			$data['showZeroStates'] = $this->checkIfDisplayZeroStates($data);
		}

		wfProfileOut(__METHOD__);
		return $data;
	}

	protected function getInternationalizedRegistrationDate($wikiId, $data) {
		wfProfileIn(__METHOD__);
		$firstMastheadEditDate = $this->user->getOption(self::USER_FIRST_MASTHEAD_EDIT_DATE_PROPERTY . $wikiId);

		if (is_null($data['registration']) && !is_null($firstMastheadEditDate)) {
			//if user hasn't edited anything on this wiki before
			//we're getting the first edit masthead date
			$data['registration'] = $firstMastheadEditDate;
		} else {
			if (!is_null($data['registration']) && !is_null($firstMastheadEditDate)) {
				//if we've got both dates we're getting the lowest (the earliest)
				$data['registration'] = (intval($data['registration']) < intval($firstMastheadEditDate)) ? $data['registration'] : $firstMastheadEditDate;
			}
		}

		$data = $this->internationalizeRegistrationDate($data);
		wfProfileOut(__METHOD__);
		return $data;
	}

	protected function internationalizeRegistrationDate($data) {
		wfProfileIn(__METHOD__);
		if (!empty($data['registration'])) {
			$data['registration'] = $this->app->wg->Lang->date($data['registration']);
		}
		wfProfileOut(__METHOD__);
		return $data;
	}

	protected function extractBirthDate($data) {
		wfProfileIn(__METHOD__);
		$birthdate = isset($data['birthday']) && is_string($data['birthday']) ? $data['birthday'] : '';
		$birthdate = explode('-', $birthdate);
		if (!empty($birthdate[0]) && !empty($birthdate[1])) {
			$data['birthday'] = array('month' => $birthdate[0], 'day' => ltrim($birthdate[1], '0'));
		} else {
			$data['birthday'] = '';
		}
		wfProfileOut(__METHOD__);
		return $data;
	}

	protected function getSharedUserData($userId, $userName) {
		wfProfileIn(__METHOD__);
		$data = array();
		$data['id'] = $userId;
		$data['name'] = $userName;
		$data['avatar'] = AvatarService::getAvatarUrl($userName, 150);
		wfProfileOut(__METHOD__);
		return $data;
	}

	protected function populateAnonData($data, $userName) {
		wfProfileIn(__METHOD__);
		$this->getEmptyData($data);
		//-1 edits means it's an anon user/ip where we don't display editcount at all
		$data['edits'] = -1;
		$data['showZeroStates'] = $this->checkIfDisplayZeroStates($data);
		$data['name'] = $userName;
		$data['realName'] = wfMsg('user-identity-box-wikia-contributor');
		wfProfileOut(__METHOD__);
		return $data;
	}

	/**
	 * @brief Gets global data from table user_properties
	 * @param array $data array object
	 * @return array $data modified object
	 */
	private function getDefaultData($data) {
		$memcData = $this->app->wg->Memc->get($this->getMemcUserIdentityDataKey());

		if (empty($memcData)) {
			foreach (array('location', 'occupation', 'gender', 'birthday', 'website', 'twitter', 'fbPage', 'hideEditsWikis') as $key) {
				if (!in_array($key, array('gender', 'birthday'))) {
					$data[$key] = $this->user->getOption($key);
				} else {
					$data[$key] = $this->user->getOption(self::USER_PROPERTIES_PREFIX . $key);
				}
			}
		} else {
			$data = array_merge_recursive($data, $memcData);
		}

		$data['topWikis'] = $this->getTopWikis();

		//informations which aren't cached in UPPv3 (i.e. real name)
		//fb#19398
		$disabled = $this->user->getOption('disabled');
		if (empty($disabled)) {
			$data['realName'] = $this->user->getRealName();
		} else {
			$data['realName'] = '';
		}
		return $data;
	}

	/**
	 * @brief Returns string with key to memcached; requires $this->user field being instance of User
	 *
	 * @return string
	 */
	private function getMemcUserIdentityDataKey() {
		return wfSharedMemcKey('user-identity-box-data0', $this->user->getId(), self::CACHE_VERSION );
	}

	/**
	 * @brief Returns string with key to memcached; requires $this->user field being instance of User
	 *
	 * @return string
	 */

	private function getMemcMastheadEditsWikisKey() {
		return wfSharedMemcKey('user-identity-box-data-masthead-edits0', $this->user->getId(), self::CACHE_VERSION );
	}

	/**
	 * @brief Sets empty data for a particular wiki
	 * @param array $data array object
	 * @return array $data array object
	 */
	private function getEmptyData($data) {
		foreach (array('location', 'occupation', 'gender', 'birthday', 'website', 'twitter', 'fbPage', 'hideEditsWikis') as $key) {
			$data[$key] = "";
		}

		$data['realName'] = "";
		$data['topWikis'] = array();
		return $data;
	}

	/**
	 * @desc Informs if the use rhas ever edited masthead
	 * @return String
	 */
	private function hasUserEverEditedMasthead() {
		return $has = $this->user->getOption(self::USER_EVER_EDITED_MASTHEAD, false);
	}

	/**
	 * @param integer $wikiId
	 * @return String
	 */
	private function hasUserEditedMastheadBefore($wikiId) {
		return $this->user->getOption(self::USER_EDITED_MASTHEAD_PROPERTY . $wikiId, false);
	}

	/**
	 * Saves user data
	 *
	 * @param object $data an user data
	 *
	 * @return boolean
	 */
	public function saveUserData($data) {
		wfProfileIn(__METHOD__);

		$changed = false;
		if (is_object($data)) {
			foreach ($this->optionsArray as $option) {
				if (isset($data->$option)) {
					$data->$option = str_replace('*', '&asterix;', $data->$option);
					$data->$option = $this->app->wg->Parser->parse($data->$option, $this->user->getUserPage(), new ParserOptions($this->user))->getText();
					$data->$option = str_replace('&amp;asterix;', '*', $data->$option);
					$data->$option = trim(strip_tags($data->$option));

					//phalanx filtering; bugId:10233
					if ($option !== 'name') {
						//bugId:21358
						$data->$option = $this->doPhalanxFilter($data->$option);
					}

					//char limit added; bugId:15593
					if (in_array($option, array('location', 'occupation', 'gender'))) {
						switch ($option) {
							case 'location':
								$data->$option = mb_substr($data->$option, 0, self::USER_LOCATION_CHAR_LIMIT);
								break;
							case 'occupation':
								$data->$option = mb_substr($data->$option, 0, self::USER_OCCUPATION_CHAR_LIMIT);
								break;
							case 'gender':
								$data->$option = mb_substr($data->$option, 0, self::USER_GENDER_CHAR_LIMIT);
								break;
						}
					}

					if ($option === 'gender') {
						$this->user->setOption(self::USER_PROPERTIES_PREFIX . $option, $data->$option);
					} else {
						$this->user->setOption($option, $data->$option);
					}

					$changed = true;
				}
			}

			if ( isset($data->month) && isset($data->day) ) {
				if ( checkdate( intval( $data->month ), intval( $data->day ), 2000 ) ) {
					$this->user->setOption( self::USER_PROPERTIES_PREFIX . 'birthday', intval( $data->month ) . '-' . intval( $data->day ) );
					$changed = true;
				} elseif ( $data->month === '0' && $data->day === '0' ) {
					$this->user->setOption( self::USER_PROPERTIES_PREFIX . 'birthday', null );
					$changed = true;
				}
			}

			if (isset($data->name)) {
				//phalanx filtering; bugId:21358
				$data->name = $this->doPhalanxFilter($data->name, Phalanx::TYPE_USER);
				//char limit added; bugId:15593
				$data->name = mb_substr($data->name, 0, self::USER_NAME_CHAR_LIMIT);

				$this->user->setRealName($data->name);
				$changed = true;
			}
		}

		$wikiId = $this->app->wg->CityId;
		if (!$this->hasUserEditedMastheadBefore($wikiId)) {
			$this->user->setOption(self::USER_EDITED_MASTHEAD_PROPERTY . $wikiId, true);
			$this->user->setOption(self::USER_FIRST_MASTHEAD_EDIT_DATE_PROPERTY . $wikiId, date('YmdHis'));

			$this->addTopWiki($wikiId);
			$changed = true;
		}

		if (true === $changed) {
			$this->user->setOption(self::USER_EVER_EDITED_MASTHEAD, true);

			$this->user->saveSettings();
			$this->saveMemcUserIdentityData($data);

			wfProfileOut(__METHOD__);
			return true;
		}

		wfProfileOut(__METHOD__);
		return false;
	}

	/**
	 * @brief Uses Phalanx to filter spam texts
	 *
	 * @param string $text the text to be filtered
	 * @param string $type one of Phalanx static names consts: TYPE_CONTENT, TYPE_SUMMARY, TYPE_TITLE, TYPE_USER, TYPE_ANSWERS_QUESTION_TITLE, TYPE_ANSWERS_RECENT_QUESTIONS, TYPE_WIKI_CREATION, TYPE_COOKIE, TYPE_EMAIL; if $type is null it'll set to Phalanx::TYPE_CONTENT
	 *
	 * @return string empty string if text was blocked; given text otherwise
	 * @FIXME this needs to be MOVED to Phalanx and called using hooks
	 */
	private function doPhalanxFilter( $text, $type = Phalanx::TYPE_CONTENT ) {
		wfProfileIn(__METHOD__);

		$blockData = array();
		$res = wfRunHooks('SpamFilterCheck', array($text, $type, &$blockData));

		wfProfileOut(__METHOD__);
		return $res === true ? $text : '';
	}

	/**
	 * @brief Filters given parameter and saves in memcached new array which is returned
	 *
	 * @param object|array $data user identity box data
	 *
	 * @return array
	 */
	private function saveMemcUserIdentityData($data) {
		foreach (array('location', 'occupation', 'gender', 'birthday', 'website', 'twitter', 'fbPage', 'realName', 'topWikis', 'hideEditsWikis') as $property) {
			if (is_object($data) && isset($data->$property)) {
				$memcData[$property] = $data->$property;
			}

			if (is_array($data) && isset($data[$property])) {
				$memcData[$property] = $data[$property];
			}
		}

		if (is_object($data)) {
			if ( isset($data->month) && isset($data->day) && checkdate( intval( $data->month ), intval( $data->day ), 2000 ) ) {
				$memcData['birthday'] = $data->month . '-' . $data->day;
			}

			if (isset($data->birthday)) {
				$memcData['birthday'] = $data->birthday;
			}
		}

		if (is_array($data)) {
			if (isset($data['month']) && isset($data['day'])) {
				$memcData['birthday'] = $data['month'] . '-' . $data['day'];
			}

			if (isset($data['birthday'])) {
				$memcData['birthday'] = $data['birthday'];
			}
		}

		if (!isset($memcData['realName']) && is_object($data) && isset($data->name)) {
			$memcData['realName'] = $data->name;
		}

		//if any of properties isn't set then set it to null
		foreach (array('location', 'occupation', 'gender', 'birthday', 'website', 'twitter', 'fbPage', 'realName', 'hideEditsWikis') as $property) {
			if (!isset($memcData[$property])) {
				$memcData[$property] = null;
			}
		}

		$this->app->wg->Memc->set($this->getMemcUserIdentityDataKey(), $memcData);

		return $memcData;
	}

	/**
	 * Gets DB object
	 *
	 * @return array
	 *
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	private function getDb($type = DB_SLAVE) {
		return wfGetDB($type, array(), $this->app->wg->SharedDB);
	}

	/**
	 * Gets user group and additionaly sets other user's data (blocked, founder)
	 *
	 * @param array $data reference to user data array
	 *
	 * @author Andrzej 'nAndy' Łukaszewski
	 * @author tor
	 */
	protected function getUserTags(&$data) {
		wfProfileIn(__METHOD__);

		if( !empty($this->app->wg->EnableTwoTagsInMasthead) ) {
			/** @var $strategy UserTwoTagsStrategy */
			$strategy = new UserTwoTagsStrategy($this->user);
		} else {
			/** @var $strategy UserOneTagStrategy */
			$strategy = new UserOneTagStrategy($this->user);
		}
		$tags = $strategy->getUserTags();

		$data['tags'] = $tags;
		wfProfileOut(__METHOD__);
	}

	/**
	 * @brief Returns false if any of "important" fields is not empty -- then it means not to display zero states
	 *
	 * @param array $data reference to user data array
	 *
	 * @author Andrzej 'nAndy' Łukaszewski
	 *
	 * @return boolean
	 */
	public function checkIfDisplayZeroStates($data) {
		wfProfileIn(__METHOD__);

		$result = true;

		$fieldsToCheck = array('location', 'occupation', 'birthday', 'gender', 'website', 'twitter', 'topWikis');

		foreach ($data as $property => $value) {
			if (in_array($property, $fieldsToCheck) && !empty($value)) {
				$result = false;
				break;
			}
		}

		wfProfileOut(__METHOD__);
		return $result;
	}

	/**
	 * @brief Gets top wikis from DB for devboxes from method UserIdentityBox::getTestData()
	 *
	 * @return array
	 */
	public function getTopWikisFromDb($limit = null) {
		wfProfileIn(__METHOD__);

		if (is_null($limit)) {
			$limit = $this->topWikisLimit;
		}

		if ( empty($this->app->wg->CityId) ) {
			// staff/internal does not have stats db
			$wikis = array();
		} else if ($this->app->wg->DevelEnvironment) {
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

			$dbs = wfGetDB(DB_SLAVE, array(), $this->app->wg->StatsDB);
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
	 * @brief Gets top wiki from memc filters them and returns
	 *
	 * @return array
	 */
	public function getTopWikis($refreshHidden = false) {
		wfProfileIn(__METHOD__);

		if ($refreshHidden === true) {
			$this->clearHiddenTopWikis();
		}

		$wikis = array_merge($this->getTopWikisFromDb(), $this->getEditsWikis());

		$ids = array();
		foreach ($wikis as $key => $wiki) {
			if ($this->isTopWikiHidden($wiki['id']) || in_array((int)$wiki['id'], $ids)) {
				unset($wikis[$key]);
			}
			$ids[] = (int)$wiki['id'];
		}

		wfProfileOut(__METHOD__);

		return $this->sortTopWikis($wikis);
	}

	/**
	 * @brief Sorts top (fav) wikis by edits and cuts if there are more than default amount of top wikis
	 *
	 * @param array $topWikis
	 *
	 * @return array
	 */
	protected function sortTopWikis($topWikis) {
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
			return array_slice($topWikis, 0, $this->topWikisLimit, true);
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
	public function addTopWiki($wikiId) {
		wfProfileIn(__METHOD__);

		$wikiName = WikiFactory::getVarValueByName('wgSitename', $wikiId);
		$wikiTitle = GlobalTitle::newFromText($this->user->getName(), NS_USER_TALK, $wikiId);

		if ($wikiTitle instanceof Title) {
			$wikiUrl = $wikiTitle->getFullUrl();

			/** @var $userStatsService UserStatsService */
			$userStatsService = new UserStatsService($this->app->wg->User->getId());
			$userStats = $userStatsService->getStats();

			//adding new wiki to topWikis in cache
			$wiki = array('id' => $wikiId, 'wikiName' => $wikiName, 'wikiUrl' => $wikiUrl, 'edits' => $userStats['edits'] + 1);
			$this->storeEditsWikis($wikiId, $wiki);
		}

		wfProfileOut(__METHOD__);
	}

	private function storeEditsWikis($wikiId, $wiki) {
		wfProfileIn(__METHOD__);

		//getting array of masthead edits wikis
		$mastheadEditsWikis = $this->app->wg->Memc->get($this->getMemcMastheadEditsWikisKey(), array());
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

		$this->app->wg->Memc->set($this->getMemcMastheadEditsWikisKey(), $mastheadEditsWikis);

		wfProfileOut(__METHOD__);
		return $mastheadEditsWikis;
	}

	private function getEditsWikis() {
		wfProfileIn(__METHOD__);

		$mastheadEditsWikis = $this->app->wg->Memc->get($this->getMemcMastheadEditsWikisKey(), null);
		$mastheadEditsWikis = is_array($mastheadEditsWikis) ? $mastheadEditsWikis : array();

		wfProfileOut(__METHOD__);
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
		wfProfileIn(__METHOD__);

		$hiddenWikis = array();
		$this->updateHiddenInDb(wfGetDB(DB_MASTER, array(), $this->app->wg->ExternalSharedDB), $hiddenWikis);
		$this->app->wg->Memc->set($this->getMemcHiddenWikisId(), $hiddenWikis);

		wfProfileOut(__METHOD__);
	}

	/**
	 * @brief Gets test data for devboxes
	 *
	 * @return array
	 */
	private function getTestData($limit) {
		wfProfileIn(__METHOD__);

		$wikis = array(
			1890 => 5,
			4036 => 35,
			177 => 12,
			831 => 60,
			5687 => 3,
			509 => 20,
		); //test data

		foreach ($wikis as $wikiId => $editCount) {
			if (!$this->isTopWikiHidden($wikiId) && ($wikiId != $this->app->wg->CityId)) {
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
		wfProfileIn(__METHOD__);

		$hiddenWikis = $this->app->wg->Memc->get($this->getMemcHiddenWikisId());

		if (empty($hiddenWikis) && !is_array($hiddenWikis)) {
			$dbs = wfGetDB(DB_SLAVE, array(), $this->app->wg->ExternalSharedDB);
			$hiddenWikis = $this->getHiddenFromDb($dbs);
			$this->app->wg->Memc->set($this->getMemcHiddenWikisId(), $hiddenWikis);
		}

		wfProfileOut(__METHOD__);
		return $hiddenWikis;
	}

	/**
	 * @brief adds hidden top wiki; code from UPP2
	 *
	 * @return array
	 *
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	public function hideWiki($wikiId) {
		wfProfileIn(__METHOD__);

		if (!$this->isTopWikiHidden($wikiId)) {
			$hiddenWikis = $this->getHiddenTopWikis();
			$hiddenWikis[] = $wikiId;
			$this->updateHiddenInDb(wfGetDB(DB_MASTER, array(), $this->app->wg->ExternalSharedDB), $hiddenWikis);
			$this->app->wg->Memc->set($this->getMemcHiddenWikisId(), $hiddenWikis);

			$memcData = $this->app->wg->Memc->get($this->getMemcUserIdentityDataKey());
			$memcData['topWikis'] = empty($memcData['topWikis']) ? array() : $memcData['topWikis'];
			$this->saveMemcUserIdentityData($memcData);
		}

		wfProfileOut(__METHOD__);
		return true;
	}

	/**
	 * @brief auxiliary method for getting hidden pages/wikis from db
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
			array('page_id' => $this->user->getId(), 'propname' => 10, 'props' => serialize($data)),
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
	public function isTopWikiHidden($wikiId) {
		wfProfileIn(__METHOD__);

		$out = (in_array($wikiId, $this->getHiddenTopWikis()) ? true : false);

		wfProfileOut(__METHOD__);
		return $out;
	}

	/**
	 * @brief Returns true if full masthead should be displayed
	 * @return bool
	 */
	public function shouldDisplayFullMasthead() {
		$userId = $this->user->getId();
		if (empty($this->userStats)) {
			/** @var $userStatsService UserStatsService */
			$userStatsService = new UserStatsService($userId);
			$this->userStats = $userStatsService->getStats();
		}

		$iEdits = $this->userStats['edits'];
		$iEdits = is_null($iEdits) ? 0 : intval($iEdits);

		$wikiId = $this->app->wg->CityId;
		$hasUserEverEditedMastheadBefore = $this->hasUserEverEditedMasthead();
		$hasUserEditedMastheadBeforeOnThisWiki = $this->hasUserEditedMastheadBefore($wikiId);

		if ($hasUserEditedMastheadBeforeOnThisWiki || ($iEdits > 0 && $hasUserEverEditedMastheadBefore)) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Blanks user profile data
	 * @author grunny
	 */
	public function resetUserProfile() {
		foreach ( $this->optionsArray as $option ) {
			if ( $option === 'gender' || $option === 'birthday' ) {
				$option = self::USER_PROPERTIES_PREFIX . $option;
			}
			$this->user->setOption( $option, null );

			$this->user->saveSettings();
			$this->app->wg->Memc->delete( $this->getMemcUserIdentityDataKey() );
		}
	}

}
