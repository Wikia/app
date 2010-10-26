<?php
class UserProfileRailModule extends Module {
	var $hiddenTopWikis;
	var $topWikis;
	var $userIsOwner;
	var $userPageUrl;
	var $activityFeed;
	var $specialContribsLink;
	var $topPages;
	var $hiddenTopPages;
	var $topPageImages;
	var $specialRandomLink;
	var $maxEdits;

	public function executeTopWikis() {
		wfProfileIn( __METHOD__ );

		$user = UserProfilePage::getInstance()->getUser();
		$this->topWikis = $this->getTopWikis();
		$this->hiddenTopWikis = $this->getHiddenTopWikis();
		$this->userIsOwner = UserProfilePage::getInstance()->userIsOwner();
		$this->userName =  $user->getName();
		$thos->userPageUrl = $user->getUserPage()->getLocalUrl();
		$this->maxEdits = 0;

		foreach ( $this->topWikis as $wikiId => $wikiData ) {
			if( in_array( $wikiId, $this->hiddenTopWikis ) ) {
				unset( $this->topWikis[ $wikiId ] );
			} elseif ( $wikiData[ 'editCount' ] > $this->maxEdits ) {
				$this->maxEdits = $wikiData[ 'editCount' ];
			}
		}

		wfProfileOut( __METHOD__ );
	}

	public function executeRecentActivity() {
		wfProfileIn( __METHOD__ );
		global $wgCityId;

		wfLoadExtensionMessages('MyHome');

		$user = UserProfilePage::getInstance()->getUser();
		$specialPageTitle = Title::newFromText( 'Contributions', NS_SPECIAL );

		$this->userName =  $user->getName();
		$this->wikiName = WikiFactory::getVarValueByName( 'wgSitename', $wgCityId );

		foreach ( $this->getActivityFeed() as $change ) {
			$item = array();
			$item['time_ago'] = wfTimeFormatAgoOnlyRecent($change['timestamp']);
			$item['user_name'] = $this->userName;
			//$item['avatar_url'] = AvatarService::getAvatarUrl($item['user_name'], 20);
			$item['user_href'] = AvatarService::renderLink($item['user_name']);
			$item['page_title'] = $change['title'];
			$item['changetype'] = $change['type'];
			$title = Title::newFromText( $change['title'], $change['namespace'] );
			if ( is_object($title) ) {
				$item['page_href'] = Xml::element('a', array('href' => $title->getLocalUrl()), $item['page_title']);
			}
			switch ($change['type']) {
				case 'new':
					$item['changemessage'] = wfMsg("userprofilepage-activity-new", $item['page_href']);
					$item['changeicon'] = 'new';
					break;
				case 'edit':
					$item['changemessage'] = wfMsg("userprofilepage-activity-edit", $item['page_href']);
					$item['changeicon'] = 'edit';
					break;
				case 'delete':
					$item['changemessage'] = wfMsg("userprofilepage-activity-delete", $item['page_href']);
					$item['changeicon'] = 'delete';
					break;
				case 'upload':
					$item['changemessage'] = wfMsg("userprofilepage-activity-image", $item['page_href']);
					$item['changeicon'] = 'upload';
					break;
				default:
					$item['changemessage'] = '';
					break;
			}
			$this->activityFeed[] = $item;
		}

		$this->specialContribsLink = $specialPageTitle->getFullUrl() . '/' . $this->userName;

		wfProfileOut( __METHOD__ );
	}

	public function executeTopPages() {
		wfProfileIn( __METHOD__ );
		global $wgCityId;

		$this->topPages = $this->getTopPages();
		$this->hiddenTopPages = $this->getHiddenTopPages();
		$this->userName =  UserProfilePage::getInstance()->getUser()->getName();
		$this->userIsOwner = UserProfilePage::getInstance()->userIsOwner();
		$this->wikiName = WikiFactory::getVarValueByName( 'wgSitename', $wgCityId );

		$specialPageTitle = Title::newFromText( 'Random', NS_SPECIAL );
		$this->specialRandomLink = $specialPageTitle->getFullUrl();

		foreach ( $this->topPages as $pageId => $pageData ) {
			if( in_array( $pageData[ 'title' ], $this->hiddenTopPages ) ) {
				unset( $this->topPages[ $pageId ] );
			}
		}

		if( class_exists('imageServing') ) {
			// ImageServing extension enabled, get images
			$imageServing = new imageServing( array_keys( $this->topPages ), 70, array( 'w' => 2, 'h' => 3 ) );//80px x 120px
			$this->topPageImages = $imageServing->getImages(1); // get just one image per article
		}

		wfProfileOut( __METHOD__ );
	}

	public function getTopWikis() {
		wfProfileIn( __METHOD__ );
		global $wgExternalDatawareDB, $wgDevelEnvironment;

		// SELECT lu_wikia_id, lu_rev_cnt FROM city_local_users WHERE lu_user_id=$userId ORDER BY lu_rev_cnt DESC LIMIT $limit;
		$dbs = wfGetDB(DB_SLAVE, array(), $wgExternalDatawareDB);
		$res = $dbs->select(
			array( 'city_local_users' ),
			array( 'lu_wikia_id', 'lu_rev_cnt' ),
			array( 'lu_user_id' => UserProfilePage::getInstance()->getUser()->getId() ),
			__METHOD__,
			array(
				'ORDER BY' => 'lu_rev_cnt DESC',
				'LIMIT' => 4
			)
		);

		$wikis = array();

		if( $wgDevelEnvironment ) {//DevBox test
			$wikis = array(
				4832 => 72,
				3613 => 60,
				4036 => 35,
				177 => 12
			); // test data

			foreach($wikis as $wikiId => $editCount) {
				$wikiName = WikiFactory::getVarValueByName( 'wgSitename', $wikiId );
				$wikiUrl = WikiFactory::getVarValueByName( 'wgServer', $wikiId );
				$wikiLogo = WikiFactory::getVarValueByName( "wgLogo", $wikiId );

				$wikis[$wikiId] = array( 'wikiName' => $wikiName, 'wikiUrl' => $wikiUrl, 'wikiLogo' => $wikiLogo, 'editCount' => $editCount );
			}

		} else {
			while ( $row = $dbs->fetchObject( $res ) ) {
				$wikiId = $row->lu_wikia_id;
				$editCount = $row->lu_rev_cnt;
				$wikiName = WikiFactory::getVarValueByName( 'wgSitename', $wikiId );
				$wikiUrl = WikiFactory::getVarValueByName( 'wgServer', $wikiId );
				$wikiLogo = WikiFactory::getVarValueByName( "wgLogo", $wikiId );

				$wikis[$wikiId] = array( 'wikiName' => $wikiName, 'wikiUrl' => $wikiUrl, 'wikiLogo' => $wikiLogo, 'editCount' => $editCount );
			}
		}

		wfProfileOut( __METHOD__ );
		return $wikis;
	}

	public function getHiddenTopWikis() {
		wfProfileIn( __METHOD__ );
		global $wgExternalSharedDB, $wgDevelEnvironment;

		$dbs = wfGetDB( DB_SLAVE, array(), $wgExternalSharedDB);
		$wikis = UserProfilePage::getInstance()->getHiddenFromDb( $dbs );

		if( $wgDevelEnvironment ) {//DevBox test
			$wikis = array(
				933 => 72,
				2677 => 60,
				899 => 35,
				1057 => 12
			); // test data

			foreach($wikis as $wikiId => $editCount) {
				$wikiName = WikiFactory::getVarValueByName( 'wgSitename', $wikiId );
				$wikiUrl = WikiFactory::getVarValueByName( 'wgServer', $wikiId );
				$wikiLogo = WikiFactory::getVarValueByName( "wgLogo", $wikiId );

				$wikis[$wikiId] = array( 'wikiName' => $wikiName, 'wikiUrl' => $wikiUrl, 'wikiLogo' => $wikiLogo, 'editCount' => $editCount );
			}

		}

		wfProfileOut( __METHOD__ );

		return $wikis;
	}

	public function getActivityFeed() {
		wfProfileIn( __METHOD__ );

		$userContribsProvider = new UserContribsProviderService;
		$user = UserProfilePage::getInstance()->getUser();

		wfProfileOut( __METHOD__ );
		return $userContribsProvider->get( 6, $user );
	}

	/**
	 * get list of user's top pages (most edited)
	 *
	 * @author ADi
	 * @return array
	 */
	public function getTopPages() {
		global $wgMemc, $wgStatsDB, $wgCityId, $wgContentNamespaces, $wgDevelEnvironment;
		wfProfileIn(__METHOD__);

		//select page_id, count(page_id) from stats.events where wiki_id = N and user_id = N and event_type in (1,2) group by 1 order by 2 desc limit 10;
		$dbs = wfGetDB( DB_SLAVE, array(), $wgStatsDB );
		$res = $dbs->select(
			array( 'stats.events' ),
			array( 'page_id', 'count(page_id) AS count' ),
			array(
				'wiki_id' => $wgCityId,
				'user_id' => UserProfilePage::getInstance()->getUser()->getId() ),
				'event_type IN (1,2)',
				'page_ns IN (' . join( ',', $wgContentNamespaces ) . ')',
			__METHOD__,
			array(
				'GROUP BY' => 'page_id',
				'ORDER BY' => 'count DESC',
				'LIMIT' => 6
			)
		);

		/* revision
		$dbs = wfGetDB( DB_SLAVE );
		$res = $dbs->select(
			array( 'revision' ),
			array( 'rev_page', 'count(*) AS count' ),
			array( 'rev_user' => $this->user->getId() ),
			__METHOD__,
			array(
				'GROUP BY' => 'rev_page',
				'ORDER BY' => 'count DESC',
				'LIMIT' => 6
			)
		);
		*/

		$pages = array();

		if( $wgDevelEnvironment ) {//DevBox test
			$pages = array( 4 => 289, 1883 => 164, 1122 => 140, 31374 => 112, 2335 => 83, 78622 => 82 ); // test data
			foreach($pages as $pageId => $editCount) {
				$title = Title::newFromID( $pageId );
				if( ( $title instanceof Title ) && ( $title->getArticleID() != 0 ) ) {
					$pages[ $pageId ] = array( 'id' => $pageId, 'url' => $title->getFullUrl(), 'title' => $title->getText(), 'imgUrl' => null, 'editCount' => $editCount );
				}
				else {
					unset( $pages[ $pageId ] );
				}
			}

		} else {
			while($row = $dbs->fetchObject($res)) {
				$pageId = $row->page_id;
				$title = Title::newFromID( $pageId );
				if( ( $title instanceof Title ) && ( $title->getArticleID() != 0 ) ) {
					$pages[ $pageId ] = array( 'id' => $pageId, 'url' => $title->getFullUrl(), 'title' => $title->getText(), 'imgUrl' => null, 'editCount' => $row->count );
				}
				else {
					unset( $pages[ $pageId ] );
				}
			}
		}

		wfProfileOut(__METHOD__);
		return $pages;
	}

	public function getHiddenTopPages() {
		global $wgDevelEnvironment;
		
		wfProfileIn( __METHOD__ );

		$dbs = wfGetDB( DB_SLAVE );
		$pages = UserProfilePage::getInstance()->getHiddenFromDb( $dbs );

		if( $wgDevelEnvironment ) {//DevBox test
			$pages = array( 8 => 289, 456 => 164, 2345 => 140, 12322 => 112, 66 => 83, 6767 => 82 ); // test data
			foreach($pages as $pageId => $editCount) {
				$title = Title::newFromID( $pageId );
				if( ( $title instanceof Title ) && ( $title->getArticleID() != 0 ) ) {
					$pages[ $pageId ] = array( 'id' => $pageId, 'url' => $title->getFullUrl(), 'title' => $title->getText(), 'imgUrl' => null, 'editCount' => $editCount );
				}
				else {
					unset( $pages[ $pageId ] );
				}
			}

		}
		
		wfProfileOut( __METHOD__ );
		return $pages;
	}

	/**
	 * adds the hook for own JavaScript variables in the document
	 */
	/*public function __construct() {
		global $wgHooks;
		$wgHooks['MakeGlobalVariablesScript'][] = 'UserProfileTopWikisModule::addAchievementsJSVariables';
	}*/


	/**
	 * adds JavaScript variables inside the page source, cl
	 *
	 * @param mixed $vars the main vars for the JavaScript printout
	 *
	 */
	/*static function addAchievementsJSVariables (&$vars) {
		$lang_view_all = wfMsg('achievements-viewall-oasis');
		$lang_view_less = wfMsg('achievements-viewless');
		$vars['wgAchievementsMoreButton'] = array($lang_view_all, $lang_view_less);
		return true;
	}*/
}