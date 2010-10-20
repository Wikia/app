<?php
class UserProfileRailModule extends Module {
	var $hiddenTopWikis;
	var $topWikis;
	var $userIsOwner;
	var $userPageUrl;
	var $activityFeed;
	var $specialContribsLink;
	
	public function executeTopWikis() {
		wfProfileIn( __METHOD__ );
		
		$user = UserProfilePage::getInstance()->getUser();
		$this->topWikis = $this->getTopWikis();
		$this->hiddenTopWikis = $this->getHiddenTopWikis();
		$this->userIsOwner = UserProfilePage::getInstance()->userIsOwner();
		$this->userName =  $user->getName();
		$thos->userPageUrl = $user->getUserPage()->getLocalUrl();
		
		foreach ( $this->topWikis as $wikiId => $wikiData ) {
			if( in_array( $wikiId, $this->hiddenTopWikis ) ) {
				unset( $this->topWikis[ $wikiId ] );
			}
		}

		wfProfileOut( __METHOD__ );
	}

	public function executeRecentActivity() {
		wfProfileIn( __METHOD__ );
		global $wgCityId;

		$userContribsProvider = new UserContribsProviderService;
		$user = UserProfilePage::getInstance()->getUser();
		$specialPageTitle = Title::newFromText( 'Contributions', NS_SPECIAL );

		$this->userName =  $user->getName();
		$this->wikiName = WikiFactory::getVarValueByName( 'wgSitename', $wgCityId );
		$this->activityFeed = $userContribsProvider->get( 6, $user );
		$this->specialContribsLink = $specialPageTitle->getFullUrl() . '/' . $this->userName;

		wfProfileOut( __METHOD__ );
	}

	public function executeTopPages() {
		wfProfileIn( __METHOD__ );
		
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
			$wikis = array( 4832 => 72, 3613 => 60, 4036 => 35, 177 => 12 ); // test data

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
		global $wgExternalSharedDB;
		
		$dbs = wfGetDB( DB_SLAVE, array(), $wgExternalSharedDB);
		$wikis = UserProfilePage::getInstance()->getHiddenFromDb( $dbs );

		wfProfileOut( __METHOD__ );
		return $wikis;
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