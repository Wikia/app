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
	var $userRegistrationDate;
	var $currentWikiId;
	private $maxTopPages = 6;
	private $maxTopWikis = 5;

	public function executeTopWikis() {
		global $wgCityId;
		wfProfileIn( __METHOD__ );

		$userProfilePage = UserProfilePage::getInstance();
		$user = $userProfilePage->getUser();
		$this->topWikis = $userProfilePage->getTopWikis( $this->maxTopWikis );
		$this->hiddenTopWikis = $this->populateHiddenTopWikis( $userProfilePage->getHiddenTopWikis() );
		$this->userIsOwner = $userProfilePage->userIsOwner();
		$this->userName =  $user->getName();
		$thos->userPageUrl = $user->getUserPage()->getLocalUrl();
		$this->maxEdits = 0;
		$this->currentWikiId = $wgCityId;

		foreach ( $this->topWikis as $wikiId => $wikiData ) {
			if ( $wikiData[ 'editCount' ] > $this->maxEdits ) {
				$this->maxEdits = $wikiData[ 'editCount' ];
			}
		}

		wfProfileOut( __METHOD__ );
	}

	public function executeTopPages() {
		wfProfileIn( __METHOD__ );
		global $wgCityId;

		$userTopPages = UserProfilePage::getInstance();
		$this->topPages = $userTopPages->getTopPages( $this->maxTopPages );
		$this->hiddenTopPages = $this->populateHiddenTopPages( $userTopPages->getHiddenTopPages() );
		$this->userName = $userTopPages->getUser()->getName();
		$this->userIsOwner = $userTopPages->userIsOwner();
		$this->wikiName = WikiFactory::getVarValueByName( 'wgSitename', $wgCityId );

		$specialPageTitle = Title::newFromText( 'Random', NS_SPECIAL );
		$this->specialRandomLink = $specialPageTitle->getFullUrl();

		if( class_exists('imageServing') ) {
			// ImageServing extension enabled, get images
			$imageServing = new imageServing( array_keys( $this->topPages ), 70, array( 'w' => 2, 'h' => 3 ) );//80px x 120px
			$this->topPageImages = $imageServing->getImages(1); // get just one image per article
		}

		wfProfileOut( __METHOD__ );
	}

	private function populateHiddenTopPages( $hiddenPages ) {
		// create title objects for hidden pages, so we can get a valid urls
		$pages = array();

		foreach($hiddenPages as $pageId) {
				$title = Title::newFromID( $pageId );
				if( ( $title instanceof Title ) && ( $title->getArticleID() != 0 ) ) {
					$pages[ $pageId ] = array( 'id' => $pageId, 'url' => $title->getFullUrl(), 'title' => $title->getText(), 'imgUrl' => null, 'editCount' => 0 );
				}
				else {
					unset( $pages[ $pageId ] );
				}
			}

		return $pages;
	}

	private function populateHiddenTopWikis( $hiddenWikis ) {
		$wikis = array();

		foreach( $hiddenWikis as $wikiId ) {
			$wikiName = WikiFactory::getVarValueByName( 'wgSitename', $wikiId );
			$wikiUrl = WikiFactory::getVarValueByName( 'wgServer', $wikiId );
			//$wikiLogo = WikiFactory::getVarValueByName( "wgLogo", $wikiId );
			$themeSettings = WikiFactory::getVarValueByName( 'wgOasisThemeSettings', $wikiId);
			if( isset($themeSettings['wordmark-image-url']) ) {
				$wikiLogo = $themeSettings['wordmark-image-url'];
				$wordmarkText = '';
			}
			elseif( isset($themeSettings['wordmark-text']) ) {
				$wikiLogo = '';
				$wordmarkText = '<span style="color: ' . $themeSettings['color-header'] . '">' .$themeSettings['wordmark-text'] . '</span>';
			}
			else {
				$wikiLogo = '';
				$wordmarkText = $wikiName;
			}

			$wikis[$wikiId] = array( 'wikiName' => $wikiName, 'wikiUrl' => $wikiUrl, 'wikiLogo' => $wikiLogo, 'editCount' => 0);
		}

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