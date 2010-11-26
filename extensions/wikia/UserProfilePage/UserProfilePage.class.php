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
	private $commentToEditRatio = 0.3;

	/**
	 * @param User $user
	 * @return UserProfilePage
	 */
	static public function getInstance( $user = null ) {
		global $wgTitle;
		wfProfileIn( __METHOD__ );
		
		if ( self::$mInstance === null ) {
			if( $user instanceof Title ) {
				$user = UserProfilePageHelper::getUserFromTitle( $user );
			}
			
			if ( !( $user instanceof User ) ) {
				$user = UserProfilePageHelper::getUserFromTitle( $wgTitle );
			}
			
			self::$mInstance =  ( $user instanceof User ) ? new self( $user ) : false;
		}
		
		wfProfileOut( __METHOD__ );
		return self::$mInstance;
	}
	
	/**
	 * @author Federico "Lox" Lucignano
	 * 
	 * @param Title $title
	 * @return bool 
	 */
	static public function isAllowedSpecialPage( Title $title = null ) {
		global $wgTitle;
		wfProfileIn( __METHOD__ );
		
		if( empty( $title ) ) $title = $wgTitle;
		
		$isAllowedSpecialPage = ( $title->isSpecial( 'Following' ) || $title->isSpecial( 'Contributions' ) );
		
		wfProfileOut( __METHOD__ );
		return $isAllowedSpecialPage;
	}
	
	/**
	 * @author Federico "Lox" Lucignano
	 * 
	 * @param Title $title
	 * @return bool 
	 */
	static public function isAllowed( Title $title = null ) {
		global $wgUserProfilePagesNamespaces, $wgRequest, $wgTitle;
		wfProfileIn( __METHOD__ );
		
		if( empty( $title ) ) $title = $wgTitle;
		
		$isAllowedPage = ( in_array( $title->getNamespace(), $wgUserProfilePagesNamespaces ) || self::isAllowedSpecialPage( $title ) );
		
		$isBlogPost = ( defined('NS_BLOG_ARTICLE') && $title->getNamespace() == NS_BLOG_ARTICLE && $title->isSubpage() );
		
		$action = $wgRequest->getVal('action', 'view');
		$isAllowedAction = ( $action == 'view' || $action == 'purge' );
		
		wfProfileOut( __METHOD__ );
		return $isAllowedPage && !$isBlogPost && $isAllowedAction;
	}

	private function __construct( User $user ) {
		$this->user = $user;
	}
	
	private function initTemplate() {
		global $wgSitename;
		wfProfileIn( __METHOD__ );
		
		$this->templateEngine = new EasyTemplate( dirname(__FILE__) . "/templates/" );

		// set "global" template variables
		$this->templateEngine->set( 'isOwner', $this->userIsOwner() );
		$this->templateEngine->set( 'userPageUrl', $this->user->getUserPage()->getLocalUrl() );
		$this->templateEngine->set( 'wikiName', $wgSitename );
		
		wfProfileOut( __METHOD__ );
	}

	public function get( $pageBody ) {
		global $wgOut, $wgJsMimeType, $wgExtensionsPath, $wgStyleVersion, $wgUserProfilePagesHideInterviewSection;
		wfProfileIn( __METHOD__ );
		
		$userContribsProvider = new UserContribsProviderService;
		
		$this->initTemplate();
		$this->templateEngine->set_vars(
			array(
				'userName'         => $this->user->getName(),
				'aboutSection'     => ( !$wgUserProfilePagesHideInterviewSection ) ? $this->populateAboutSectionVars() : null,
				'hideAboutSection' => $wgUserProfilePagesHideInterviewSection,
				'pageBody'         => $pageBody,
				'extensionsPath'   => $wgExtensionsPath
			)
		);
		
		$out = $this->templateEngine->render( 'user-profile-page' );
		
		wfProfileOut( __METHOD__ );
		return $out;
	}

	/**
	 * render user's top (pages or wikis) section
	 * @param string $sectionName
	 * @param array $topData
	 * @param array $topDataHidden
	 * @return string
	 */
	private function renderTopSection( $sectionName ) {
		return wfRenderModule( 'UserProfileRail', $sectionName );
	}

	private function populateAboutSectionVars() {
		global $wgOut;
		wfProfileIn( __METHOD__ );
		$result = false;
		
		if ( !$this->getUser()->isAnon() ) {
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

			$result = array( 'body' => $sArticleBody, 'articleEditUrl' => $sArticleEditUrl );
		}
		
		wfProfileOut( __METHOD__ );
		return $result;
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
		$methodName = strtolower( $actionName ) . ucfirst( $type );

		if( method_exists( $this, $methodName ) ) {
			return call_user_func_array( array( $this, $methodName ), array( $value ) );
		}
	}

	private function hidePage( $pageId ) {
		wfProfileIn( __METHOD__ );
		
		if( !$this->isTopPageHidden( $pageId) ) {
			$this->hiddenPages[] = $pageId;
			$this->updateHiddenInDb( wfGetDB( DB_MASTER ), $this->hiddenPages );
		}
		
		$out = $this->renderTopSection( 'TopPages' );
		
		wfProfileOut( __METHOD__ );
		return $out;
	}

	private function unhidePage( $pageId ) {
		wfProfileIn( __METHOD__ );
		
		if( $this->isTopPageHidden( $pageId ) ) {
			for( $i = 0; $i < count( $this->hiddenPages ); $i++ ) {
				if( $this->hiddenPages[ $i ] == $pageId ) {
					unset( $this->hiddenPages[ $i ] );
					$this->hiddenPages = array_values( $this->hiddenPages );
				}
			}
			
			$this->updateHiddenInDb( wfGetDB( DB_MASTER ), $this->hiddenPages );
		}
		
		$out = $this->renderTopSection( 'TopPages' );
		
		wfProfileOut( __METHOD__ );
		return $out;
		
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

	public function isTopPageHidden( $pageId) {
		wfProfileIn( __METHOD__ );
		
		$out = ( in_array( $pageId, $this->getHiddenTopPages() ) ? true : false );
		
		wfProfileOut( __METHOD__ );
		return $out;
	}

	public function isTopWikiHidden( $wikiId ) {
		wfProfileIn( __METHOD__ );
		
		$out = ( in_array( $wikiId, $this->getHiddenTopWikis() ) ? true : false );
		
		wfProfileOut( __METHOD__ );
		return $out;
	}

	private function hideWiki( $wikiId) {
		wfProfileIn( __METHOD__ );
		global $wgExternalSharedDB;

		if( !$this->isTopWikiHidden( $wikiId ) ) {
			$this->hiddenWikis[] = $wikiId;
			$this->updateHiddenInDb( wfGetDB( DB_MASTER, array(), $wgExternalSharedDB ), $this->hiddenWikis );
		}
		
		$out = $this->renderTopSection( 'TopWikis' );
		
		wfProfileOut( __METHOD__ );
		return $out;
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
		
		wfProfileOut( __METHOD__ );
		return $this->renderTopSection( 'TopWikis' );
	}

	/**
	 * auxiliary method for getting hidden pages/wikis from db
	 * @author ADi
	 */
	private function getHiddenFromDb( $dbHandler ) {
		wfProfileIn( __METHOD__ );
		$result = false;
		
		if ( !$this->getUser()->isAnon() ) {
		
			$row = $dbHandler->selectRow(
				array( 'page_wikia_props' ),
				array( 'props' ),
				array( 'page_id' => $this->getUser()->getId() , 'propname' => 10 ),
				__METHOD__,
				array()
			);

			if( !empty($row) ) {
				$result = unserialize( $row->props );
			}
			
			$result = empty($result) ? array() : $result;
		}
		
		wfProfileOut( __METHOD__ );
		return $result;
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
		
		wfProfileIn( __METHOD__ );
		//prevent from API calls for non-existent accounts
		$userId = $this->getUser()->idForName();

		if( empty( $userId ) ) {
			wfProfileOut( __METHOD__ );
			return false;
		}
		
		$mKey = $this->getUserLastActionCacheKey();
		$cachedData = $wgMemc->get($mKey);
		
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

			if( empty( $cachedData ) ) {
				$cachedData = array();
			}
			
			$this->setUserLastActionToCache( $cachedData );
		}
		
		wfProfileOut( __METHOD__ );
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
	
	public function getTopWikis( $limit = 5 ) {
		wfProfileIn( __METHOD__ );
		global $wgStatsDB, $wgDevelEnvironment, $wgCityId;
		$wikis = false;
		
		if ( !$this->getUser()->isAnon() ) {
			$where = array( 'user_id' => $this->getUser()->getId() );
			$hiddenTopWikis = $this->getHiddenTopWikis();
			
			if ( count( $hiddenTopWikis ) ) {
				$where[] = 'wiki_id NOT IN (' . join( ',', $hiddenTopWikis ) . ')';
			}

			$dbs = wfGetDB(DB_SLAVE, array(), $wgStatsDB);
			$res = $dbs->select(
				array( 'specials.events_local_users' ),
				array( 'wiki_id', 'edits' ),
				$where,
				__METHOD__,
				array(
					'ORDER BY' => 'edits DESC',
					'LIMIT' => $limit
				)
			);

			$wikis = array();

			if ( $wgDevelEnvironment ) {//DevBox test
				$wikis = array(
					4832 => 72,
					831 => 60,
					4036 => 35,
					177 => 12,
					1890 => 5
				); // test data

				foreach ( $wikis as $wikiId => $editCount ) {
					if( !$this->isTopWikiHidden( $wikiId ) || ( $wikiId == $wgCityId ) ) {
						$wikiName = WikiFactory::getVarValueByName( 'wgSitename', $wikiId );
						$wikiUrl = WikiFactory::getVarValueByName( 'wgServer', $wikiId );
						//$wikiLogo = WikiFactory::getVarValueByName( "wgLogo", $wikiId );
						$themeSettings = WikiFactory::getVarValueByName( 'wgOasisThemeSettings', $wikiId);
						
						if ( isset( $themeSettings[ 'wordmark-image-url' ] ) ) {
							$wikiLogo = $themeSettings['wordmark-image-url'];
							$wordmarkText = '';
						}
						elseif( isset( $themeSettings[ 'wordmark-text' ] ) ) {
							$wikiLogo = '';
							$wordmarkText = '<span style="color: ' . $themeSettings['color-header'] . '">' .$themeSettings[ 'wordmark-text' ] . '</span>';
						}
						else {
							$wikiLogo = '';
							$wordmarkText = $wikiName;
						}
						$wikis[ $wikiId ] = array( 'wikiName' => $wikiName, 'wikiUrl' => $wikiUrl, 'wikiLogo' => $wikiLogo, 'wikiWordmarkText' => $wordmarkText, 'editCount' => $editCount );
					} else {
						unset( $wikis[ $wikiId ] );
					}
				}

			} else {
				while ( $row = $dbs->fetchObject( $res ) ) {
					$wikiId = $row->wiki_id;
					$editCount = $row->edits;
					$wikiName = WikiFactory::getVarValueByName( 'wgSitename', $wikiId );
					$wikiUrl = WikiFactory::getVarValueByName( 'wgServer', $wikiId );
					//$wikiLogo = WikiFactory::getVarValueByName( "wgLogo", $wikiId );
					$themeSettings = WikiFactory::getVarValueByName( 'wgOasisThemeSettings', $wikiId);
					
					if ( isset( $themeSettings[ 'wordmark-image-url' ] ) ) {
						$wikiLogo = $themeSettings[ 'wordmark-image-url' ];
						$wordmarkText = '';
					} elseif( isset( $themeSettings[ 'wordmark-text' ] ) ) {
						$wikiLogo = '';
						$wordmarkText = '<span style="color: ' . $themeSettings['color-header'] . '">' .$themeSettings['wordmark-text'] . '</span>';
					} else {
						$wikiLogo = '';
						$wordmarkText = $wikiName;
					}

					$wikis[ $wikiId ] = array( 'wikiName' => $wikiName, 'wikiUrl' => $wikiUrl, 'wikiLogo' => $wikiLogo, 'wikiWordmarkText' => $wordmarkText, 'editCount' => $editCount );
				}
			}
		}
		
		wfProfileOut( __METHOD__ );
		return $wikis;
	}

	public function getHiddenTopWikis() {
		wfProfileIn( __METHOD__ );
		global $wgExternalSharedDB, $wgDevelEnvironment;

		if( empty($this->hiddenWikis) ) {
			$dbs = wfGetDB( DB_SLAVE, array(), $wgExternalSharedDB);
			$this->hiddenWikis = $this->getHiddenFromDb( $dbs );
		}

		wfProfileOut( __METHOD__ );
		return $this->hiddenWikis;
	}

	/**
	 * get list of user's top pages (most edited)
	 *
	 * @author ADi
	 * @return array
	 */
	public function getTopPages( $limit = 6 ) {
		global $wgMemc, $wgStatsDB, $wgCityId, $wgContentNamespaces, $wgDevelEnvironment;
		wfProfileIn(__METHOD__);
		$pages = false;
		
		if ( !$this->getUser()->isAnon() ) {
			//select page_id, count(page_id) from stats.events where wiki_id = N and user_id = N and event_type in (1,2) group by 1 order by 2 desc limit 10;
			$where = array(
				'wiki_id' => $wgCityId,
				'user_id' => $this->getUser()->getId(),
				'event_type IN (1,2)',
				'page_ns IN (' . join( ',', $wgContentNamespaces ) . ')'
			);

			$hiddenTopPages = $this->getHiddenTopPages();
			
			if(count($hiddenTopPages)) {
				$where[] = 'page_id NOT IN (' . join( ',', $hiddenTopPages ) . ')';
			}

			$dbs = wfGetDB( DB_SLAVE, array(), $wgStatsDB );
			$res = $dbs->select(
				array( $wgStatsDB . '.events' ),
				array( 'page_id', 'count(page_id) AS count' ),
				$where,
				__METHOD__,
				array(
					'GROUP BY' => 'page_id',
					'ORDER BY' => 'count DESC',
					'LIMIT' => $limit
				)
			);
			
			$pages = array();
			
			//if( $wgDevelEnvironment ) { //DevBox test
			//	$pages = array( 4 => 28, 1883 => 16, 1122 => 14, 31374 => 11, 2335 => 8, 78622 => 3 ); // test data
			//} else {
				while( $row = $dbs->fetchObject($res) ) {
					$pages[ $row->page_id ] = $row->count;
				}
			//}

			// get top commented pages and merge
			foreach( $this->getTopCommentedPages() as $pageId => $commentCount ) {
				$commentPoints = round( $commentCount * $this->commentToEditRatio );
				if( isset( $pages[ $pageId ] ) ) {
					$pages[ $pageId ] += $commentPoints;
				}
				else {
					$pages[ $pageId ] = $commentPoints;
				}
			}
			
			$titles = array();
			
			foreach ( $pages as $pageId => $editCount ) {
				$title = Title::newFromID( $pageId );
				
				if( ( $title instanceof Title ) && $title->exists() ) {
					$titles[ $pageId ] = $title;
				}
				else {
					unset( $pages[ $pageId ] );
				}
			}
			
			arsort( $pages );
			
			if ( count( $pages ) > $limit ) {
				$pages = array_slice( $pages, 0, $limit, true );
			}
			
			if( count( $pages ) ) {
				$articleService = new ArticleService();
				
				foreach( $pages as $pageId => $editCount ) {
					$title = $titles[ $pageId ];
					$articleService->setArticleById( $title->getArticleID() );
					$snippet = $articleService->getTextSnippet( 100 );
					$pages[ $pageId ] = array( 'id' => $pageId, 'url' => $title->getFullUrl(), 'title' => $title->getText(), 'imgUrl' => null, 'editCount' => $editCount, 'textSnippet' => $snippet );
				}
			}
		}
		
		wfProfileOut(__METHOD__);
		return $pages;
	}

	public function getTopCommentedPages() {
		global $wgMemc, $wgArticleCommentsNamespaces, $wgEnableArticleCommentsExt;
		wfProfileIn(__METHOD__);
		$pages = false;
		
		if ( !$this->getUser()->isAnon() ) {
			$talkNamespaces = array();
			
			if( is_array($wgArticleCommentsNamespaces) ) {
				foreach( $wgArticleCommentsNamespaces as $ns ) {
					$talkNamespaces[] = MWNamespace::getTalk( $ns );
				}
			}

			if( count($talkNamespaces) == 0 || empty($wgEnableArticleCommentsExt) ) {
				wfProfileOut(__METHOD__);
				return array();
			}

			$where = array(
					'page_id=rev_page',
					'rev_user' => $this->getUser()->getId(),
					'page_namespace IN (' . join( ',', $talkNamespaces ) . ')',
			);
			
			$hiddenTopPages = $this->getHiddenTopPages();
			
			if(count($hiddenTopPages)) {
				$where[] = 'page_id NOT IN (' . join( ',', $hiddenTopPages ) . ')';
			}

			$dbr = wfGetDB( DB_SLAVE );
			$res = $dbr->select(
				array( 'page', 'revision' ),
				array( 'page_title', 'page_namespace' ),
				$where,
				__METHOD__,
				array()
			);

			$pages = array();
			
			while($row = $dbr->fetchObject($res)) {
				if( strpos( $row->page_title, '@comment') !== false ) {
					$commentData = ArticleComment::explode( $row->page_title );
					if( !empty( $commentData ) ) {
						$title = Title::newFromText( $commentData['title'], MWNamespace::getSubject( $row->page_namespace )   );
						if( isset( $pages[$title->getArticleId()] ) ) {
							$pages[$title->getArticleId()]++;
						}
						else {
							$pages[$title->getArticleId()] = 1;
						}
					}
				}
			}
			
			arsort(  $pages );
		}
		
		wfProfileOut(__METHOD__);
		return $pages;
	}

	public function getHiddenTopPages() {
		global $wgDevelEnvironment;
		wfProfileIn( __METHOD__ );

		if( empty($this->hiddenPages) ) {
			$dbs = wfGetDB( DB_SLAVE );
			$this->hiddenPages = $this->getHiddenFromDb( $dbs );
		}

		wfProfileOut( __METHOD__ );
		return $this->hiddenPages;
	}

}
