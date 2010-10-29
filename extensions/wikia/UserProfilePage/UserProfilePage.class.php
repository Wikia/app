<?php

class UserProfilePage {
	/**
	 * @var User
	 */
	private $user;
	private $hiddenPages = null;
	private $hiddenWikis = null;
	private $templateEngine = null;
	private static $mInstance = null;

	static public function getInstance( User $user = null ) {
		global $wgTitle;
		if ( empty( self::$mInstance ) ) {
			if (! ($user instanceof User) ) {
				$user = UserProfilePageHelper::getUserFromTitle( $wgTitle );
			}
			self::$mInstance = new self( $user );
		}

		return self::$mInstance;
	}

	private function __construct( User $user ) {
		global $wgSitename;

		$this->user = $user;
		$this->templateEngine = new EasyTemplate( dirname(__FILE__) . "/templates/" );

		// set "global" template variables
		$this->templateEngine->set( 'isOwner', $this->userIsOwner() );
		$this->templateEngine->set( 'userPageUrl', $this->user->getUserPage()->getLocalUrl() );
		$this->templateEngine->set( 'wikiName', $wgSitename );
	}

	public function get( $pageBody ) {
		global $wgOut, $wgJsMimeType, $wgExtensionsPath, $wgStyleVersion;

		//$wgOut->addScript( "<script type=\"{$wgJsMimeType}\" src=\"{$wgExtensionsPath}/wikia/UserProfilePage/js/UserProfilePage.js?{$wgStyleVersion}\" ></script>\n" );

		$userContribsProvider = new UserContribsProviderService;

		$this->templateEngine->set_vars(
			array(
				'userName'         => $this->user->getName(),
				'aboutSection'     => $this->populateAboutSectionVars(),
				'pageBody'         => $pageBody,
			));
		return $this->templateEngine->render( 'user-profile-page' );
	}

	/**
	 * render user's top (pages or wikis) section
	 * @param string $sectionName
	 * @param array $topData
	 * @param array $topDataHidden
	 * @return string
	 */
	private function renderTopSection( $sectionName, Array $topData, Array $topDataHidden ) {
		wfProfileIn(__METHOD__);

		$this->templateEngine->set_vars(
			array(
				'topData' => $topData,
				'topDataHidden' => $topDataHidden
			)
		);

		wfProfileOut(__METHOD__);
		return $this->templateEngine->render( $sectionName );
	}

	private function populateHiddenTopPagesVars( $hiddenPages ) {
		// create title objects for hidden pages, so we can get a valid urls
		$vars = array();
		foreach( $hiddenPages as $pageTitleText ) {
			$title = Title::newFromText( $pageTitleText );
			if( $title instanceof Title ) {
				$vars[] = array( 'title' => $title->getText(), 'url' => $title->getFullUrl() );
			}
		}
		return $vars;
	}

	private function populateHiddenTopWikisVars( $hiddenWikis ) {
		$vars = array();
		foreach( $hiddenWikis as $wikiId ) {
			$wikiName = WikiFactory::getVarValueByName( 'wgSitename', $wikiId );
			$wikiUrl = WikiFactory::getVarValueByName( 'wgServer', $wikiId );

			$vars[$wikiId] = array( 'wikiName' => $wikiName, 'wikiUrl' => $wikiUrl );
		}
		return $vars;
	}

	private function populateAboutSectionVars() {
		global $wgOut;
		$sTitle = $this->user->getUserPage()->getText() . '/' . wfMsg( 'userprofilepage-about-article-title' );
		$oTitle = Title::newFromText( $sTitle, NS_USER );
		$oArticle = new Article($oTitle, 0);

		$oSpecialPageTitle = Title::newFromText( 'CreateFromTemplate', NS_SPECIAL );

		if( $oTitle->exists() ) {
			$sArticleBody = $wgOut->parse( $oArticle->getContent() );
			$sArticleEditUrl = $oTitle->getLocalURL( 'action=edit' );
		}
		else {
			$sArticleBody = wfMsg( 'userprofilepage-about-empty-section' );
			$sArticleEditUrl = $oSpecialPageTitle->getLocalURL( 'type=aboutuser&wpTitle=' . $oTitle->getPrefixedURL() . '&returnto=' . $this->user->getUserPage()->getFullUrl( 'action=purge' ) );
		}

		return array( 'body' => $sArticleBody, 'articleEditUrl' => $sArticleEditUrl );
	}

	/**
	 * perform action (hide/unhide page or wiki)
	 *
	 * @author ADi
	 * @param string $actionName
	 * @param string $type
	 * @param string $value
	 */
	public function doAction( $actionName, $type, $value) {
		wfProfileIn( __METHOD__ );
		$methodName = strtolower( $actionName ) . ucfirst( $type );

		if( method_exists( $this, $methodName ) ) {
			return call_user_func_array( array( $this, $methodName ), array( $value ) );
		}
		wfProfileOut( __METHOD__ );
	}

	private function hidePage( $pageTitleText ) {
		wfProfileIn( __METHOD__ );
		if( !$this->isTopPageHidden( $pageTitleText ) ) {
			$this->hiddenPages[] = $pageTitleText;
			$this->updateHiddenInDb( wfGetDB( DB_MASTER ), $this->hiddenPages );
		}
		return $this->renderTopSection( 'user-top-pages', $this->getTopPages(), $this->populateHiddenTopPagesVars( $this->getHiddenTopPages() ) );
		wfProfileOut( __METHOD__ );
	}

	private function unhidePage( $pageTitleText ) {
		wfProfileIn( __METHOD__ );
		if( $this->isTopPageHidden( $pageTitleText ) ) {
			for( $i = 0; $i < count( $this->hiddenPages ); $i++ ) {
				if( $this->hiddenPages[ $i ] == $pageTitleText ) {
					unset( $this->hiddenPages[ $i ] );
					$this->hiddenPages = array_values( $this->hiddenPages );
				}
			}
			$this->updateHiddenInDb( wfGetDB( DB_MASTER ), $this->hiddenPages );
		}
		return $this->renderTopSection( 'user-top-pages', $this->getTopPages(), $this->populateHiddenTopPagesVars( $this->getHiddenTopPages() ) );
		wfProfileOut( __METHOD__ );
	}

	/**
	 * auxiliary method for updating hidden pages in db
	 * @author ADi
	 */
	private function updateHiddenInDb( $dbHandler, $data ) {
		wfProfileIn( __METHOD__ );

		$dbHandler->replace(
			'page_wikia_props',
			null,
			array( 'page_id' => $this->user->getId(), 'propname' => 10, 'props' => serialize( $data ) ),
			__METHOD__
		);
		$dbHandler->commit();

		wfProfileOut( __METHOD__ );
	}

	public function isTopPageHidden( $pageTitleText ) {
		return ( in_array( $pageTitleText, $this->getHiddenTopPages() ) ? true : false );
	}

	private function hideWiki( $wikiId) {
		wfProfileIn( __METHOD__ );
		global $wgExternalSharedDB;

		if( !$this->isTopWikiHidden( $wikiId ) ) {
			$this->hiddenWikis[] = $wikiId;
			$this->updateHiddenInDb( wfGetDB( DB_MASTER, array(), $wgExternalSharedDB ), $this->hiddenWikis );
		}

		return $this->renderTopSection( 'user-top-wikis', $this->getTopWikis(), $this->populateHiddenTopWikisVars( $this->getHiddenTopWikis() ) );
		wfProfileOut( __METHOD__ );
	}

	private function unhideWiki( $wikiId ) {
		wfProfileIn( __METHOD__ );
		global $wgExternalSharedDB;

		if( $this->isTopWikiHidden( $wikiId) ) {
			for( $i = 0; $i < count( $this->hiddenWikis ); $i++ ) {
				if( $this->hiddenWikis[ $i ] == $wikiId ) {
					unset( $this->hiddenWikis[ $i ] );
					$this->hiddenWikis = array_values( $this->hiddenWikis );
				}
			}
			$this->updateHiddenInDb( wfGetDB( DB_MASTER, array(), $wgExternalSharedDB ), $this->hiddenWikis );
		}

		return $this->renderTopSection( 'user-top-wikis', $this->getTopPages(), $this->populateHiddenTopWikisVars( $this->getHiddenTopWikis() ) );
		wfProfileOut( __METHOD__ );
	}

	/**
	 * auxiliary method for getting hidden pages/wikis from db
	 * @author ADi
	 */
	public function getHiddenFromDb( $dbHandler ) {
		$row = $dbHandler->selectRow(
			array( 'page_wikia_props' ),
			array( 'props' ),
			array( 'page_id' => $this->user->getId() , 'propname' => 10 ),
			__METHOD__,
			array()
		);

		return ( empty($row) ? array() : unserialize( $row->props ) );
	}

	public function getUser() {
		return $this->user;
	}

	public function userIsOwner() {
		global $wgUser;

		return $this->user->getId() == $wgUser->getId();
	}

	public function getUserLastActionCacheKey() {
		return wfMemcKey( __CLASS__, 'userLastAction', $this->getUser()->getName() );
	}

	/**
	 * return user's last activity on wiki (create/adit/delete article etc.)
	 * @author ADi
	 * @return array
	 */
	public function getUserLastAction() {
		global $wgMemc, $wgContentNamespaces, $wgLang;

		$mKey = $this->getUserLastActionCacheKey();
		//TODO: enable caching
		//$cachedData = $wgMemc->get($mKey);
		if (empty($cachedData)) {

			$maxElements = 1;
			$includeNamespaces = implode('|', $wgContentNamespaces);
			$parameters = array(
				'type' => 'widget',
				'maxElements' => $maxElements,
				'flags' => array('shortlist'),
				'uselang' => $wgLang->getCode(),
				'includeNamespaces' => $includeNamespaces
			);

			$feedProxy = new ActivityFeedAPIProxy($includeNamespaces, $this->getUser()->getName());
			$feedProvider = new DataFeedProvider($feedProxy, 1, $parameters);
			$feedData = $feedProvider->get($maxElements);

			if( isset($feedData['results']) ) {
				$cachedData = array_shift( $feedData['results'] );
			}
			else {
				$cachedData = array();
			}
			$this->setUserLastActionToCache( $cachedData );
		}

		return $cachedData;
	}

	/**
	 * (this is a separate function in case we want to call it from LatestActivityModule)
	 * @param array $actionData
	 */
	public function setUserLastActionToCache( Array $actionData ) {
		global $wgMemc;
		$wgMemc->set( $this->getUserLastActionCacheKey(), $actionData, 3600 );
	}

}
