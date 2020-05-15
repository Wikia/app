<?php

use Wikia\Logger\WikiaLogger;

class MercuryApi {

	const MERCURY_SKIN_NAME = 'mercury';
	const CACHE_TIME_TOP_CONTRIBUTORS = 2592000; // 30 days
	const CACHE_TIME_TRENDING_ARTICLES = 60 * 60 * 24;
	const SITENAME_MSG_KEY = 'pagetitle-view-mainpage';
	const WIKI_IMAGE_SIZE = 500;

	/**
	 * Aggregated list of comments users
	 *
	 * @var array
	 */
	private $users = [];

	public static function getTopContributorsKey( $articleId, $limit ) {
		return wfMemcKey( __CLASS__, __METHOD__, $articleId, $limit );
	}

	/**
	 * @desc Fetch all time top contributors for article
	 *
	 * @param int $articleId - Article id
	 * @param $limit - maximum number of contributors to fetch
	 *
	 * @return array
	 */
	public function topContributorsPerArticle( $articleId, $limit ) {
		$key = self::getTopContributorsKey( $articleId, $limit );
		$method = __METHOD__;
		$contributions = WikiaDataAccess::cache(
			$key,
			self::CACHE_TIME_TOP_CONTRIBUTORS,
			function () use ( $articleId, $limit, $method ) {
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
				$result = [];
				while ( $row = $db->fetchObject( $res ) ) {
					$result[(int) $row->rev_user] = (int) $row->cntr;
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
	 *
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

	private function getCommonVariables() {
		global $wgDBname, $wgCityId, $wgLanguageCode, $wgContLang, $wgSitename, $wgServer, $wgArticlePath,
			   $wgScriptPath;

		$robotPolicy = Wikia::getEnvironmentRobotPolicy( RequestContext::getMain()->getRequest() );

		$htmlTitle = new WikiaHtmlTitle();

		if ( !empty( $wgArticlePath ) ) {
			$articlePath = str_replace( '$1', '', $wgArticlePath );
		} else {
			$articlePath = '/wiki/';
		}

		return [
			'vertical' => WikiFactoryHub::getInstance()->getWikiVertical( $wgCityId )['short'],
			'appleTouchIcon' => Wikia::getWikiLogoMetadata(),
			'articlePath' => $articlePath,
			'basePath' =>  wfHttpsAllowedForURL( $wgServer ) ? wfHttpToHttps( $wgServer ) : $wgServer,
			'dbName' => $wgDBname,
			'favicon' => Wikia::getFaviconFullUrl(),
			'id' => (int) $wgCityId,
			'isClosed' => !WikiFactory::isPublic( $wgCityId ),
			'htmlTitle' => [
				'separator' => $htmlTitle->getSeparator(),
				'parts' => array_values( $htmlTitle->getAllParts() ),
			],
			'language' => [
				'content' => $wgLanguageCode,
				'contentDir' => $wgContLang->getDir()
			],
			'scriptPath' => $wgScriptPath,
			'siteName' => $wgSitename,
			'specialRobotPolicy' => !empty( $robotPolicy ) ? $robotPolicy : null,
			'surrogateKey' => Wikia::wikiSurrogateKey( $wgCityId ),
			'tracking' => [
				'vertical' => HubService::getVerticalNameForComscore( $wgCityId ),
				'comscore' => [
					'c7Value' => AnalyticsProviderComscore::getC7Value(),
				],
				'quantcast' => [
					'labels' => AnalyticsProviderQuantServe::getQuantcastLabels()
				]
			],
		];
	}

	private function getSmartBannerAdConfig() {
		global $wgSmartBannerAdConfiguration;

		$smartBannerCustomConfig = $wgSmartBannerAdConfiguration;
		if ( !empty( $smartBannerCustomConfig ) && !empty( $smartBannerCustomConfig['imageUrl'] ) ) {
			try {
				$smartBannerCustomConfig['imageUrl'] = VignetteRequest::fromUrl( $smartBannerCustomConfig['imageUrl'] )
					->thumbnailDown()
					->width( 64 )
					->height( 64 )
					->url();
			} catch ( Exception $e ) {
				WikiaLogger::instance()->warning(
					"error while processing image url in wgSmartBannerAdConfiguration, check if image url is valid vignette url"
				);
				$smartBannerCustomConfig = [];
			}
		}

		return $smartBannerCustomConfig;
	}

	public function getMobileWikiVariables() {
		global $wgCityId, $wgStyleVersion, $wgContLang, $wgContentNamespaces, $wgDefaultSkin, $wgCdnRootUrl,
		       $wgRecommendedVideoABTestPlaylist, $wgFandomAppSmartBannerText, $wgTwitterAccount,
		       $wgEnableFeedsAndPostsExt, $wgEnableEmbeddedFeeds, $wgDevelEnvironment, $wgQualarooDevUrl, $wgQualarooUrl,
		       $wgRightsText, $wgRightsUrl, $wgEnableDiscussions, $wgIsTestWiki;

		$enableFAsmartBannerCommunity = WikiFactory::getVarValueByName( 'wgEnableFandomAppSmartBanner', WikiFactory::COMMUNITY_CENTRAL );

		$wikiVariables = array_merge(
			$this->getCommonVariables(),
			[
				'cacheBuster' => (int) $wgStyleVersion,
				'cdnRootUrl' => $wgCdnRootUrl,
				'contentNamespaces' => array_values( $wgContentNamespaces ),
				'defaultSkin' => $wgDefaultSkin,
				'enableFandomAppSmartBanner' => !empty( $enableFAsmartBannerCommunity ),
				'enableDiscussions' => $wgEnableDiscussions,
				'enableEmbeddedFeedsModule' => $wgEnableFeedsAndPostsExt && $wgEnableEmbeddedFeeds,
				'enableFilePageRedirectsForAnons' => true,
				'fandomAppSmartBannerText' => $wgFandomAppSmartBannerText,
				'mainPageTitle' => Title::newMainPage()->getPrefixedDBkey(),
				'namespaces' => $wgContLang->getNamespaces(),
				'qualarooUrl' => $wgDevelEnvironment ? $wgQualarooDevUrl : $wgQualarooUrl,
				'recommendedVideoPlaylist' => $wgRecommendedVideoABTestPlaylist,
				'recommendedVideoRelatedMediaId' => ArticleVideoContext::getRelatedMediaIdForRecommendedVideo(),
				'siteMessage' => $this->getSiteMessage(),
				'smartBannerAdConfiguration' => $this->getSmartBannerAdConfig(),
				'twitterAccount' => $wgTwitterAccount,
				'licenseText' => $wgRightsText,
				'licenseUrl' => $wgRightsUrl,
				'isTestWiki' => $wgIsTestWiki,
				'videoBridgeCountries' => WikiFactory::getVarValueByName(
					'wgVideoBridgeCountries',
					WikiFactory::COMMUNITY_CENTRAL
				),
			]
		);

		// get wiki image from Curated Main Pages (SUS-474)
		$communityData = ( new CommunityDataService( $wgCityId ) )->getCommunityData();

		if ( !empty( $communityData['image_id'] ) ) {
			$url = CuratedContentHelper::getImageUrl( $communityData['image_id'], self::WIKI_IMAGE_SIZE );
			$wikiVariables['image'] = $url;
		}

		\Hooks::run( 'MercuryWikiVariables', [ &$wikiVariables ] );

		return $wikiVariables;
	}

	public function getDiscussionsWikiVariables() {
		global $wgDefaultSkin, $wgEnableDiscussions, $wgEnableDiscussionsImageUpload, $wgDiscussionColorOverride,
			   $wgEnableLightweightContributions, $wgEnableFeedsAndPostsExt, $wgEnableEmbeddedFeeds,
			   $wgFandomCreatorCommunityId;

		$wikiVariables = array_merge(
			$this->getCommonVariables(),
			[
				'defaultSkin' => $wgDefaultSkin,
				'discussionColorOverride' => SassUtil::sanitizeColor( $wgDiscussionColorOverride ),
				'enableDiscussions' => $wgEnableDiscussions,
				'enableDiscussionsImageUpload' => $wgEnableDiscussionsImageUpload,
				'enableEmbeddedFeedsModule' => $wgEnableFeedsAndPostsExt && $wgEnableEmbeddedFeeds,
				'enableLightweightContributions' => $wgEnableLightweightContributions,
				'siteMessage' => $this->getSiteMessage(),
				'theme' => SassUtil::normalizeThemeColors( SassUtil::getOasisSettings() ),
				'openGraphImageUrl' => OpenGraphImageHelper::getUrl(),
				'fandomCreatorCommunityId' => !empty( $wgFandomCreatorCommunityId ) ? $wgFandomCreatorCommunityId : null
			]
		);

		\Hooks::run( 'MercuryWikiVariables', [ &$wikiVariables ] );

		return $wikiVariables;
	}

	public function getAnnouncementsVariables() {
		$wikiVariables = array_merge(
			$this->getCommonVariables(),
			[
				'theme' => SassUtil::normalizeThemeColors( SassUtil::getOasisSettings() )
			]
		);

		\Hooks::run( 'MercuryWikiVariables', [ &$wikiVariables ] );

		return $wikiVariables;
	}

	/**
	 * @desc Get Current wiki settings
	 *
	 * @return mixed
	 */
	public function getWikiVariables() {
		global $wgStyleVersion, $wgCityId, $wgContLang, $wgContentNamespaces, $wgDefaultSkin,
		       $wgDisableAnonymousEditing, $wgDisableAnonymousUploadForMercury, $wgDisableMobileSectionEditor,
		       $wgEnableCommunityData, $wgEnableDiscussions, $wgEnableDiscussionsImageUpload,
		       $wgDiscussionColorOverride, $wgEnableNewAuth, $wgWikiDirectedAtChildrenByFounder,
		       $wgWikiDirectedAtChildrenByStaff, $wgCdnRootUrl,
		       $wgEnableLightweightContributions, $wgRecommendedVideoABTestPlaylist, $wgFandomAppSmartBannerText,
		       $wgTwitterAccount, $wgIsGASpecialWiki,
		       $wgDevelEnvironment, $wgQualarooDevUrl, $wgQualarooUrl, $wgArticlePath, $wgFandomCreatorCommunityId;

		$enableFAsmartBannerCommunity = WikiFactory::getVarValueByName( 'wgEnableFandomAppSmartBanner', WikiFactory::COMMUNITY_CENTRAL );

		$navigation = $this->getNavigation();
		if ( empty( $navigation ) ) {
			\Wikia\Logger\WikiaLogger::instance()->notice(
				'Fallback to empty navigation'
			);
		}

		$wikiVariables = array_merge(
			$this->getCommonVariables(),
			[
				'cacheBuster' => (int) $wgStyleVersion,
				'cdnRootUrl' => $wgCdnRootUrl,
				'contentNamespaces' => array_values( $wgContentNamespaces ),
				'defaultSkin' => $wgDefaultSkin,
				'disableAnonymousEditing' => $wgDisableAnonymousEditing,
				'disableAnonymousUploadForMercury' => $wgDisableAnonymousUploadForMercury,
				'disableMobileSectionEditor' => $wgDisableMobileSectionEditor,
				'discussionColorOverride' => SassUtil::sanitizeColor( $wgDiscussionColorOverride ),
				'enableCommunityData' => $wgEnableCommunityData,
				'enableDiscussions' => $wgEnableDiscussions,
				'enableDiscussionsImageUpload' => $wgEnableDiscussionsImageUpload,
				'enableFandomAppSmartBanner' => !empty( $enableFAsmartBannerCommunity ),
				'enableLightweightContributions' => $wgEnableLightweightContributions,
				'enableNewAuth' => $wgEnableNewAuth,
				'fandomAppSmartBannerText' => $wgFandomAppSmartBannerText,
				'homepage' => $this->getHomepageUrl(),
				'isCoppaWiki' => ( $wgWikiDirectedAtChildrenByFounder || $wgWikiDirectedAtChildrenByStaff ),
				'isDarkTheme' => SassUtil::isThemeDark(),
				'localNav' => $navigation,
				'mainPageTitle' => Title::newMainPage()->getPrefixedDBkey(),
				'namespaces' => $wgContLang->getNamespaces(),
				'qualarooUrl' => ( $wgDevelEnvironment ) ? $wgQualarooDevUrl : $wgQualarooUrl,
				'recommendedVideoPlaylist' => $wgRecommendedVideoABTestPlaylist,
				'recommendedVideoRelatedMediaId' => ArticleVideoContext::getRelatedMediaIdForRecommendedVideo(),
				'siteMessage' => $this->getSiteMessage(),
				'theme' => SassUtil::normalizeThemeColors( SassUtil::getOasisSettings() ),
				'twitterAccount' => $wgTwitterAccount,
				'wikiCategories' => WikiFactoryHub::getInstance()->getWikiCategoryNames( $wgCityId ),
				'vertical' => WikiFactoryHub::getInstance()->getWikiVertical( $wgCityId)['short'],
			]
		);

		if ( !empty( $wgFandomCreatorCommunityId ) ) {
			$wikiVariables['fandomCreatorCommunityId'] = $wgFandomCreatorCommunityId;
		}

		// Used to determine GA tracking
		if ( !empty( $wgIsGASpecialWiki ) ) {
			$wikiVariables['isGASpecialWiki'] = true;
		}

		if ( !empty( $wgArticlePath ) ) {
			$wikiVariables['articlePath'] = str_replace( '$1', '', $wgArticlePath );
		} else {
			$wikiVariables['articlePath'] = '/wiki/';
		}

		$smartBannerConfig = $this->getSmartBannerConfig();
		if ( !is_null( $smartBannerConfig ) ) {
			$wikiVariables['smartBanner'] = $smartBannerConfig;
		}

		// get wiki image from Curated Main Pages (SUS-474)
		$communityData = ( new CommunityDataService( $wgCityId ) )->getCommunityData();
		if ( !empty( $communityData['image_id'] ) ) {
			$url = CuratedContentHelper::getImageUrl( $communityData['image_id'], self::WIKI_IMAGE_SIZE );
			$wikiVariables['image'] = $url;
		}

		\Hooks::run( 'MercuryWikiVariables', [ &$wikiVariables ] );

		return $wikiVariables;
	}

	/**
	 * @desc Returns local navigation data for current wiki
	 *
	 * @return array
	 */
	private function getNavigation() {
		$navData = F::app()->sendRequest( 'NavigationApi', 'getData' )->getData();

		if ( !isset( $navData['navigation']['wiki'] ) ) {
			$localNavigation = [];
		} else {
			$localNavigation = $navData['navigation']['wiki'];
		}

		return $localNavigation;
	}

	/**
	 * @desc Gets smart banner config from WF and cleans it up
	 */
	private function getSmartBannerConfig() {
		if ( !empty( $this->wg->EnableWikiaMobileSmartBanner ) && !empty( $this->wg->WikiaMobileSmartBannerConfig ) ) {
			$smartBannerConfig = $this->wg->WikiaMobileSmartBannerConfig;

			unset( $smartBannerConfig['author'] );
			$meta = $smartBannerConfig['meta'];
			unset( $smartBannerConfig['meta'] );
			$smartBannerConfig['appId'] = [
				'ios' => str_replace( 'app-id=', '', $meta['apple-itunes-app'] ),
				'android' => str_replace( 'app-id=', '', $meta['google-play-app'] ),
			];

			$smartBannerConfig['appScheme'] = [
				'ios' => $meta['ios-scheme'] ?? null,
				'android' => $meta['android-scheme'] ?? null,
			];

			return $smartBannerConfig;
		}

		return null;
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
	 *
	 * @return array
	 */
	public function processArticleComments( Array $commentsData ) {
		$this->clearUsers();
		$comments = [];
		foreach ( $commentsData as $pageId => $commentData ) {
			$item = null;

			if ( isset( $commentData['level1'] ) && $this->isValidComment( $commentData['level1'] ) ) {
				$comment = $this->getComment( $commentData['level1'] );
				if ( $comment ) {
					$item = $comment;
				}
			}

			if ( $item && !empty( $commentData['level2'] ) ) {
				$item['comments'] = [];
				foreach ( $commentData['level2'] as $articleId => $articleCommentReply ) {
					if ( $this->isValidComment( $articleCommentReply ) ) {
						$comment = $this->getComment( $articleCommentReply );
						if ( $comment ) {
							$item['comments'][] = $comment;
						}
					}
				}
			}

			if ( $item ) {
				$comments[] = $item;
			}
		}

		return [
			'comments' => $comments,
			'users' => $this->getUsers(),
		];
	}

	/**
	 * Generate comment item object from raw article comment
	 *
	 * @param ArticleComment $articleComment
	 * @return null|mixed
	 * @throws MWException
	 */
	private function getComment( ArticleComment $articleComment ) {
		$success = $articleComment->load();

		if ( !$success ) {
			return null;
		}

		return [
			'id' => $articleComment->getTitle()->getArticleID(),
			'text' => $articleComment->getText(),
			'created' => (int) wfTimestamp( TS_UNIX, $articleComment->mFirstRevision->getTimestamp() ),
			'userName' => $this->addUser( $articleComment->mUser ),
		];
	}

	/**
	 * @param $what
	 * @return bool
	 */
	private function isValidComment( $what ): bool {
		return is_object( $what ) && $what instanceof ArticleComment;
	}

	/**
	 * Add user to aggregated user array
	 *
	 * @param User $user
	 * @return string userName
	 */
	private function addUser( User $user  ) {
		$userName = trim( $user->getName() );
		if ( !isset( $this->users[$userName] ) ) {
			if (AvatarService::isEmptyOrFirstDefault( $userName )) {
				$avatarUrl = null;
			} else {
				$avatarUrl = AvatarService::getAvatarUrl(
					$userName,
					AvatarService::AVATAR_SIZE_SMALL_PLUS);
			}

			$this->users[$userName] = [
				'id' => (int) $user->getId(),
				'avatar' => $avatarUrl,
				'url' => AvatarService::getUrl( $userName ),
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
		$this->users = [];
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

		global $wgWikiaBaseDomain;

		return "http://www.{$wgWikiaBaseDomain}"; // default homepage url
	}


	/**
	 * Get ads context for Title. Return null if Ad Engine extension is not enabled
	 *
	 * @param Title $title Title object
	 *
	 * @return array|null Article Ad context
	 */
	public function getAdsContext( Title $title ) {
		$adContext = new AdEngine3();

		return $adContext->getContext( $title, self::MERCURY_SKIN_NAME );
	}

	/**
	 * @param Title $title
	 * @param string|null $displayTitle
	 *
	 * @return string
	 */
	public function getHtmlTitleForPage( Title $title, $displayTitle ) {
		if ( $title->isMainPage() ) {
			return '';
		}

		$htmlTitle = $displayTitle;

		if ( class_exists( 'SEOTweaksHooksHelper' ) && $title->inNamespace( NS_FILE ) ) {
			/*
			 * Only run this code if SEOTweaks extension is enabled.
			 * We don't use $wg variable because there are multiple switches enabling this extension
			 */
			$file = WikiaFileHelper::getFileFromTitle( $title );

			if ( !empty( $file ) ) {
				$htmlTitle = SEOTweaksHooksHelper::getTitleForFilePage( $title, $file );
			}
		}

		if ( empty( $htmlTitle ) ) {
			$htmlTitle = $title->getPrefixedText();
		}

		return $htmlTitle;
	}

	/**
	 * CuratedContent API returns data in a different format than we need.
	 * Let's clean it up!
	 *
	 * @param $rawData
	 *
	 * @return array|null
	 */
	public function processCuratedContent( $rawData ) {
		if ( empty( $rawData ) ) {
			return null;
		}

		$data = [];
		$sections = $this->getCuratedContentSections( $rawData );
		$items = $this->getCuratedContentItems( $rawData['items'] );
		$featured =
			isset( $rawData['featured'] ) ? $this->getCuratedContentItems( $rawData['featured'] ) : [];

		if ( !empty( $sections ) || !empty( $items ) ) {
			$data['items'] = [];
		}

		if ( !empty( $sections ) ) {
			$data['items'] = array_merge( $data['items'], $sections );
		}

		if ( !empty( $items ) ) {
			$data['items'] = array_merge( $data['items'], $items );
		}

		if ( !empty( $featured ) ) {
			$data['featured'] = $featured;
		}

		return $data;
	}

	/**
	 * Add `section` type to all sections from CuratedContent data
	 *
	 * @param array $data
	 *
	 * @return array
	 */
	public function getCuratedContentSections( Array $data ) {
		$sections = [];

		if ( !empty( $data['sections'] ) ) {
			foreach ( $data['sections'] as $dataItem ) {
				$section = [];
				$section['label'] = $dataItem['title'];
				$section['imageUrl'] = $dataItem['image_url'];
				$section['type'] = 'section';
				$section['items'] = $this->getSectionContent( $dataItem['title'] );
				$section['imageCrop'] = isset( $dataItem['image_crop'] ) ? $dataItem['image_crop'] : null;

				if ( !empty( $section['items'] ) ) {
					$sections[] = $section;
				}
			}
		}

		return $sections;
	}

	protected function getSectionContent( $sectionTitle ) {
		$content = MercuryApiMainPageHandler::getCuratedContentData( $this, $sectionTitle );

		return isset( $content['items'] ) ? $content['items'] : [];
	}

	/**
	 * Process CuratedContent items and sanitize when the item is an article
	 *
	 * @param $items
	 *
	 * @return array
	 */
	public function getCuratedContentItems( $items ) {
		$data = [];
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

	public function getTrendingPagesData( int $limit, $category, bool $withImagesOnly	) {
		global $wgContentNamespaces;

		$params = [
			'abstract' => false,
			'expand' => true,
			'limit' => $limit,
			'namespaces' => implode( ',', $wgContentNamespaces )
		];

		if ( $category instanceof Title ) {
			$params['category'] = $category->getText();
		}

		$data = [];

		try {
			$rawData = F::app()->sendRequest( 'ArticlesApi', 'getTop', $params )->getData();
			$data = self::processTrendingPagesData( $rawData, $withImagesOnly );
		} catch ( NotFoundException $ex ) {
			WikiaLogger::instance()->info( 'Trending articles data is empty' );
		}

		return $data;
	}

	/**
	 * @desc Mercury can't open article using ID - we need to create a local link.
	 * If article doesn't exist (Title is null) return null.
	 * In other case return item with updated url.
	 * TODO Implement cache for release version.
	 * Platform Team is OK with hitting DB for MVP (10-15 wikis)
	 *
	 * @param $item
	 *
	 * @return mixed
	 */
	public function processCuratedContentItem( $item ) {
		if ( !empty( $item['article_id'] ) ) {
			$title = Title::newFromID( $item['article_id'] );

			if ( !empty( $title ) ) {
				return $this->getCuratedContentItemResult( $title, $item );
			}
		} elseif ( isset( $item['article_id'] ) && $item['article_id'] === 0 ) {
			$title =  Title::newFromText( $item['title'] );

			$category = empty( $title ) ? null : Category::newFromTitle( $title );

			if ( !empty( $category ) && $category->getPageCount() ) {
				return $this->getCuratedContentItemResult( $title, $item );
			}
		}

		return null;
	}

	private function getCuratedContentItemResult( Title $title, array $item ): array {
		return [
			'label' => empty( $item['label'] ) ? $item['title'] : $item['label'],
			'imageUrl' => $item['image_url'],
			'imageCrop' => isset( $item['image_crop'] ) ? $item['image_crop'] : null,
			'type' => $item['type'],
			'url' => $title->getLocalURL(),
		];
	}

	public function processTrendingPagesData( $data, bool $withImagesOnly = false ) {
		if ( !isset( $data['items'] ) || !is_array( $data['items'] ) ) {
			return null;
		}

		$items = [];

		foreach ( $data['items'] as $item ) {
			$processedItem = $this->processTrendingPagesItem( $item, $withImagesOnly );

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
	 * @param bool $withImagesOnly - if true, skip items without thumbnail
	 * @return array
	 */
	public function processTrendingPagesItem( $item, bool $withImagesOnly ) {
		$paramsToInclude = [ 'title', 'thumbnail', 'url' ];

		$processedItem = [];

		if ( !empty( $item ) && is_array( $item ) ) {
			if ( $withImagesOnly && empty( $item['thumbnail'] ) ) {
				return null;
			}

			foreach ( $paramsToInclude as $param ) {
				if ( !empty( $item[$param] ) ) {
					$processedItem[$param] = $item[$param];
				}
			}
		}

		return $processedItem;
	}

	public function processTrendingVideoData( $data ) {
		if ( !isset( $data['videos'] ) || !is_array( $data['videos'] ) ) {
			return null;
		}

		$items = [];

		foreach ( $data['videos'] as $item ) {
			$items[] = ArticleAsJson::createMediaObject(
				WikiaFileHelper::getMediaDetail(
					Title::newFromText( $item['title'], NS_FILE ),
					[
						'imageMaxWidth' => false
					]
				),
				$item['title']
			);
		}

		return $items;
	}
}
