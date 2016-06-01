<?php

class MercuryApi {

	const MERCURY_SKIN_NAME = 'mercury';
	const CACHE_TIME_TOP_CONTRIBUTORS = 2592000; // 30 days
	const SITENAME_MSG_KEY = 'pagetitle-view-mainpage';

	/**
	 * Aggregated list of comments users
	 *
	 * @var array
	 */
	private $users = [ ];

	/**
	 * @desc Fetch Article comments count
	 *
	 * @param Title $title - Article title
	 * @return integer
	 */
	public function articleCommentsCount( Title $title ) {
		$articleCommentList = new ArticleCommentList();
		$articleCommentList->setTitle( $title );
		return $articleCommentList->getCountAll();
	}

	public static function getTopContributorsKey( $articleId, $limit ) {
		return wfMemcKey( __CLASS__, __METHOD__, $articleId, $limit );
	}

	/**
	 * @desc Fetch all time top contributors for article
	 *
	 * @param int $articleId - Article id
	 * @param $limit - maximum number of contributors to fetch
	 * @return array
	 */
	public function topContributorsPerArticle( $articleId, $limit ) {
		$key = self::getTopContributorsKey( $articleId, $limit );
		$method = __METHOD__;
		$contributions = WikiaDataAccess::cache( $key, self::CACHE_TIME_TOP_CONTRIBUTORS,
			function () use ( $articleId, $limit, $method ) {
				// Log DB hit
				Wikia::log( $method, false, sprintf( 'Cache for articleId: %d was empty', $articleId ) );
				$db = wfGetDB( DB_SLAVE );
				$res = $db->select(
					'revision',
					[
						'rev_user',
						'count(1) AS cntr'
					],
					[
						'rev_page = ' . $articleId,
						'rev_deleted = 0',
						'rev_user != 0'
					],
					$method,
					[
						'GROUP BY' => 'rev_user',
						'ORDER BY' => 'count(1) DESC',
						'LIMIT' => $limit
					]
				);
				$result = [ ];
				while ( $row = $db->fetchObject( $res ) ) {
					$result[ (int)$row->rev_user ] = (int)$row->cntr;
				}
				return $result;
			}
		);
		// Cached results may contain more than the $limit results
		$contributions = array_slice( $contributions, 0, $limit, true );
		return array_keys( $contributions );
	}

	/**
	 * @desc Get number of user's contributions for article
	 *
	 * @param $articleId
	 * @param $userId
	 * @return mixed
	 */
	public function getNumberOfUserContribForArticle( $articleId, $userId ) {
		$db = wfGetDB( DB_SLAVE );
		$row = $db->selectRow(
			'revision',
			[
				'count(*) AS cntr'
			],
			[
				'rev_page' => $articleId,
				'rev_user' => $userId,
				'rev_deleted' => 0
			],
			__METHOD__
		);
		return $row->cntr;
	}

	/**
	 * @desc Get Current wiki settings
	 *
	 * @return mixed
	 */
	public function getWikiVariables() {
		global $wgAnalyticsDriverIVW3Countries, $wgCacheBuster, $wgCityId, $wgContLang, $wgContentNamespaces, $wgDBname,
			$wgDefaultSkin, $wgDisableAnonymousEditing, $wgDisableAnonymousUploadForMercury,
			$wgDisableMobileSectionEditor, $wgEnableCommunityData, $wgEnableDiscussions, $wgEnableNewAuth,
			$wgLanguageCode, $wgSitename, $wgWikiDirectedAtChildrenByFounder, $wgWikiDirectedAtChildrenByStaff;

		return [
			'cacheBuster' => (int)$wgCacheBuster,
			'contentNamespaces' => array_values($wgContentNamespaces),
			'dbName' => $wgDBname,
			'defaultSkin' => $wgDefaultSkin,
			'disableAnonymousEditing' => $wgDisableAnonymousEditing,
			'disableAnonymousUploadForMercury' => $wgDisableAnonymousUploadForMercury,
			'disableMobileSectionEditor' => $wgDisableMobileSectionEditor,
			'enableCommunityData' => $wgEnableCommunityData,
			'enableDiscussions' => $wgEnableDiscussions,
			'enableGlobalNav2016' => true,
			'enableNewAuth' => $wgEnableNewAuth,
			'favicon' => Wikia::getFaviconFullUrl(),
			'homepage' => $this->getHomepageUrl(),
			'id' => (int)$wgCityId,
			'isCoppaWiki' => ( $wgWikiDirectedAtChildrenByFounder || $wgWikiDirectedAtChildrenByStaff ),
			'isDarkTheme' => SassUtil::isThemeDark(),
			'language' => [
				'content' => $wgLanguageCode,
				'contentDir' => $wgContLang->getDir()
			],
			'mainPageTitle' => Title::newMainPage()->getPrefixedDBkey(),
			'namespaces' => $wgContLang->getNamespaces(),
			'siteMessage' => $this->getSiteMessage(),
			'siteName' => $wgSitename,
			'theme' => SassUtil::normalizeThemeColors( SassUtil::getOasisSettings() ),
			'tracking' => [
				'vertical' => HubService::getVerticalNameForComscore( $wgCityId ),
				'ivw3' => [
					'countries' => $wgAnalyticsDriverIVW3Countries,
					'cmKey' => AnalyticsProviderIVW3::getCMKey()
				],
				'nielsen' => [
					'enabled' => AnalyticsProviderNielsen::isEnabled(),
					'apid' => AnalyticsProviderNielsen::getApid()
				]
			],
			'wikiCategories' => WikiFactoryHub::getInstance()->getWikiCategoryNames( $wgCityId ),
		];
	}

	/**
	 * @desc Gets a wikia site message
	 * When message doesn't exist - return false
	 *
	 * @return Boolean|String
	 */
	public function getSiteMessage() {
		$msg = wfMessage( static::SITENAME_MSG_KEY )->inContentLanguage();
		if ( !$msg->isDisabled() ) {
			$msgText = $msg->text();
		}

		return !empty( $msgText ) ? htmlspecialchars( $msgText ) : false;
	}

	/**
	 * Process comments and return two level comments
	 *
	 * @param array $commentsData
	 * @return array
	 */
	public function processArticleComments( Array $commentsData ) {
		$this->clearUsers();
		$comments = [ ];
		foreach ( $commentsData[ 'commentListRaw' ] as $pageId => $commentData ) {
			$item = null;
			foreach ( $commentData as $level => $commentBody ) {
				if ( $level === 'level1' ) {
					$comment = $this->getComment( $pageId );
					if ( $comment ) {
						$item = $comment;
					}
				}
				if ( $level === 'level2' && !empty( $item ) ) {
					$item[ 'comments' ] = [ ];
					foreach ( array_keys( $commentBody ) as $articleId ) {
						$comment = $this->getComment( $articleId );
						if ( $comment ) {
							$item[ 'comments' ][] = $comment;
						}
					}
				}
			}
			$comments[] = $item;
		}
		return [
			'comments' => $comments,
			'users' => $this->getUsers(),
		];
	}

	/**
	 * Generate comment item object from comment article id
	 *
	 * @param integer $articleId
	 * @return null|mixed
	 */
	private function getComment( $articleId ) {
		$articleComment = ArticleComment::newFromId( $articleId );
		if ( !( $articleComment instanceof ArticleComment ) ) {
			return null;
		}
		$commentData = $articleComment->getData();
		// According to `extensions/wikia/ArticleComments/classes/ArticleComment.class.php:179`
		// no revision data means that the comment should be ignored
		if ( $commentData === false ) {
			return null;
		}
		return [
			'id' => $commentData[ 'id' ],
			'text' => $commentData[ 'text' ],
			'created' => (int)wfTimestamp( TS_UNIX, $commentData[ 'rawmwtimestamp' ] ),
			'userName' => $this->addUser( $commentData ),
		];
	}

	/**
	 * Add user to aggregated user array
	 *
	 * @param array $commentData - ArticleComment Data
	 * @return string userName
	 */
	private function addUser( Array $commentData ) {
		$userName = trim( $commentData[ 'author' ]->mName );
		if ( !isset( $this->users[ $userName ] ) ) {
			$this->users[ $userName ] = [
				'id' => (int)$commentData[ 'author' ]->mId,
				'avatar' => AvatarService::getAvatarUrl(
					$commentData[ 'author' ]->mName, AvatarService::AVATAR_SIZE_MEDIUM
				),
				'url' => $commentData[ 'userurl' ]
			];
		}
		return $userName;
	}

	/**
	 * Get list of aggregated users
	 *
	 * @return array
	 */
	private function getUsers() {
		return $this->users;
	}

	/**
	 * Clear list of aggregated users
	 */
	private function clearUsers() {
		$this->users = [ ];
	}

	/**
	 * Get homepage URL for given language.
	 *
	 * @return string homepage URL. Default is US homepage.
	 */
	private function getHomepageUrl() {
		if ( class_exists( 'WikiaLogoHelper' ) ) {
			return ( new WikiaLogoHelper() )->getMainCorpPageURL();
		}
		return 'http://www.wikia.com'; // default homepage url
	}


	/**
	 * Get ads context for Title. Return null if Ad Engine extension is not enabled
	 *
	 * @param Title $title Title object
	 * @return array|null Article Ad context
	 */
	public function getAdsContext( Title $title ) {
		$adContext = new AdEngine2ContextService();
		return $adContext->getContext( $title, self::MERCURY_SKIN_NAME );
	}

	/**
	 * CuratedContent API returns data in a different format than we need.
	 * Let's clean it up!
	 *
	 * @param $rawData
	 * @return array|null
	 */
	public function processCuratedContent( $rawData ) {
		if ( empty( $rawData ) ) {
			return null;
		}

		$data = [ ];
		$sections = $this->getCuratedContentSections( $rawData );
		$items = $this->getCuratedContentItems( $rawData[ 'items' ] );
		$featured = $this->getCuratedContentItems( $rawData[ 'featured' ] );

		if ( !empty( $sections ) || !empty( $items ) ) {
			$data[ 'items' ] = [ ];
		}

		if ( !empty( $sections ) ) {
			$data[ 'items' ] = array_merge( $data[ 'items' ], $sections );
		}

		if ( !empty( $items ) ) {
			$data[ 'items' ] = array_merge( $data[ 'items' ], $items );
		}

		if ( !empty( $featured ) ) {
			$data[ 'featured' ] = $featured;
		}

		return $data;
	}

	/**
	 * Add `section` type to all sections from CuratedContent data
	 *
	 * @param array $data
	 * @return array
	 */
	public function getCuratedContentSections( Array $data ) {
		$sections = [ ];
		if ( !empty( $data[ 'sections' ] ) ) {
			foreach ( $data[ 'sections' ] as $section ) {
				$section[ 'type' ] = 'section';
				$sections[] = $section;
			}
		}
		return $sections;
	}

	/**
	 * Process CuratedContent items and sanitize when the item is an article
	 *
	 * @param $items
	 * @return array
	 */
	public function getCuratedContentItems( $items ) {
		$data = [ ];
		if ( !empty( $items ) ) {
			foreach ( $items as $item ) {
				$processedItem = $this->processCuratedContentItem( $item );
				if ( !empty( $processedItem ) ) {
					$data[] = $processedItem;
				}
			}
		}
		return $data;
	}

	/**
	 * @desc Mercury can't open article using ID - we need to create a local link.
	 * If article doesn't exist (Title is null) return null.
	 * In other case return item with updated article_local_url.
	 * TODO Implement cache for release version.
	 * Platform Team is OK with hitting DB for MVP (10-15 wikis)
	 *
	 * @param $item
	 * @return mixed
	 */
	public function processCuratedContentItem( $item ) {
		if ( !empty( $item[ 'article_id' ] ) ) {
			$title = Title::newFromID( $item[ 'article_id' ] );

			if ( !empty( $title ) ) {
				$item[ 'article_local_url' ] = $title->getLocalURL();
				return $item;
			}
		} else {
			if ( $item[ 'article_id' ] === 0 ) {
				// Categories which don't have content have wgArticleID set to 0
				// In order to generate link for them
				// we can simply replace $1 inside /wiki/$1 to category title (Category:%name%)
				global $wgArticlePath;
				$item[ 'article_local_url' ] = str_replace( "$1", $item[ 'title' ], $wgArticlePath );
				return $item;
			}
		}
		return null;
	}

	public function processTrendingArticlesData( $data ) {
		$data = $data[ 'items' ];

		if ( !isset( $data ) || !is_array( $data ) ) {
			return null;
		}

		$items = [ ];

		foreach ( $data as $item ) {
			$processedItem = $this->processTrendingArticlesItem( $item );

			if ( !empty( $processedItem ) ) {
				$items[] = $processedItem;
			}
		}

		return $items;
	}

	/**
	 * @desc To save some bandwidth, the unnecessary params are stripped
	 *
	 * @param array $item
	 * @return array
	 */
	public function processTrendingArticlesItem( $item ) {
		$paramsToInclude = [ 'title', 'thumbnail', 'url' ];

		$processedItem = [ ];

		if ( !empty( $item ) && is_array( $item ) ) {
			foreach ( $paramsToInclude as $param ) {
				if ( !empty( $item[ $param ] ) ) {
					$processedItem[ $param ] = $item[ $param ];
				}
			}
		}

		return $processedItem;
	}

	public function processTrendingVideoData( $data ) {
		$videosData = $data[ 'videos' ];

		if ( !isset( $videosData ) || !is_array( $videosData ) ) {
			return null;
		}

		$items = [ ];

		foreach ( $videosData as $item ) {
			$items[] = ArticleAsJson::createMediaObject(
				WikiaFileHelper::getMediaDetail(
					Title::newFromText( $item[ 'title' ], NS_FILE ),
					[
						'imageMaxWidth' => false
					]
				),
				$item[ 'title' ]
			);
		}

		return $items;
	}
}
