<?php

use Wikia\Logger\WikiaLogger;

class MercuryApiController extends WikiaController {

	const PARAM_ARTICLE_ID = 'id';
	const PARAM_PAGE = 'page';
	const PARAM_ARTICLE_TITLE = 'title';

	const NUMBER_CONTRIBUTORS = 5;
	const DEFAULT_PAGE = 1;

	const WIKI_VARIABLES_CACHE_TTL = 60;
	const WIKI_IMAGE_SIZE = 500;

	private $mercuryApi = null;

	public function __construct() {
		parent::__construct();
		$this->mercuryApi = new MercuryApi();
	}

	/**
	 * @desc Gets smart banner config from WF and cleans it up
	 */
	private function getSmartBannerConfig() {
		if ( !empty( $this->wg->EnableWikiaMobileSmartBanner ) && !empty( $this->wg->WikiaMobileSmartBannerConfig ) ) {
			$smartBannerConfig = $this->wg->WikiaMobileSmartBannerConfig;

			unset( $smartBannerConfig['author'] );

			if ( !empty( $smartBannerConfig['icon'] ) &&
				!isset( parse_url( $smartBannerConfig['icon'] )['scheme'] ) // it differs per wiki
			) {
				$smartBannerConfig['icon'] = $this->wg->extensionsPath . $smartBannerConfig['icon'];
			}

			$meta = $smartBannerConfig['meta'];
			unset( $smartBannerConfig['meta'] );
			$smartBannerConfig['appId'] = [
				'ios' => str_replace( 'app-id=', '', $meta['apple-itunes-app'] ),
				'android' => str_replace( 'app-id=', '', $meta['google-play-app'] ),
			];

			$smartBannerConfig['appScheme'] = [
				'ios' => $meta['ios-scheme'],
				'android' => $meta['android-scheme']
			];

			return $smartBannerConfig;
		}

		return null;
	}

	/**
	 * @desc Returns user ids for top contributors
	 *
	 * @param int $articleId
	 *
	 * @return int[]
	 */
	private function getTopContributorsPerArticle( $articleId ) {
		$usersIds = $this->mercuryApi->topContributorsPerArticle( $articleId, self::NUMBER_CONTRIBUTORS );

		return $usersIds;
	}

	/**
	 * @desc returns article details
	 *
	 * @param Article $article
	 *
	 * @return mixed
	 */
	private function getArticleDetails( Article $article ) {
		$articleId = $article->getID();
		$articleDetails =
			$this->sendRequest( 'ArticlesApi', 'getDetails', [ 'ids' => $articleId ] )->getData()['items'][$articleId];

		$description = $this->getArticleDescription( $article );

		$articleDetails['abstract'] = htmlspecialchars( $articleDetails['abstract'] );
		$articleDetails['description'] = htmlspecialchars( $description );

		return $articleDetails;
	}

	/**
	 * @desc Returns description for the article's meta tag.
	 *
	 * This is mostly copied from the ArticleMetaDescription extension.
	 *
	 * @param Article $article
	 * @param int $descLength
	 *
	 * @return string
	 * @throws NotFoundApiException
	 */
	private function getArticleDescription( Article $article, $descLength = 100 ) {
		$title = $article->getTitle();
		$sMessage = null;

		if ( $title->isMainPage() ) {
			// we're on Main Page, check MediaWiki:Description message
			$sMessage = wfMessage( 'Description' )->text();
		}

		if ( ( $sMessage == null ) || wfEmptyMsg( 'Description', $sMessage ) ) {
			$articleService = new ArticleService( $article );
			$description = $articleService->getTextSnippet( $descLength );
		} else {
			// MediaWiki:Description message found, use it
			$description = $sMessage;
		}

		return $description;
	}

	/**
	 * @desc returns an article in simplified json structure
	 *
	 * @param int $articleId
	 * @param Title $title
	 * @param string $sections List of section numbers or 'all'
	 *
	 * @return array
	 */
	private function getArticleJson( $articleId, Title $title, $sections = '' ) {
		$redirect = $this->request->getVal( 'redirect' );

		$articleAsJson = $this->sendRequest(
			'ArticlesApi',
			'getAsJson',
			[
				'id' => $articleId,
				'redirect' => $redirect,
				'sections' => $sections
			]
		)->getData();

		$articleType = WikiaPageType::getArticleType( $title );

		if ( !empty( $articleType ) ) {
			$articleAsJson['type'] = $articleType;
		}

		return $articleAsJson;
	}


	/**
	 * @desc returns top contributors user details
	 *
	 * @param array $ids
	 * @return mixed
	 */
	private function getTopContributorsDetails( Array $ids ) {
		if ( empty( $ids ) ) {
			return [ ];
		}
		try {
			return $this->sendRequest( 'UserApi', 'getDetails', [ 'ids' => implode( ',', $ids ) ] )->getData()['items'];
		} catch ( NotFoundApiException $e ) {
			// getDetails throws NotFoundApiException when no contributors are found
			// and we want the article even if we don't have the contributors
			return [ ];
		}
	}

	/**
	 * @desc Returns local navigation data for current wiki
	 *
	 * @return array
	 */
	private function getNavigation() {
		$navData = $this->sendRequest( 'NavigationApi', 'getData' )->getData();
		if ( isset( $navData['navigation']['wiki'] ) ) {
			return $navData['navigation']['wiki'];
		}
		return [ ];
	}

	/**
	 * @desc Returns related pages
	 *
	 * @param int $articleId
	 * @param int $limit
	 *
	 * @return mixed
	 */
	private function getRelatedPages( $articleId, $limit = 6 ) {
		if ( class_exists( 'RelatedPages' ) ) {
			return RelatedPages::getInstance()->get( $articleId, $limit );
		} else {
			return false;
		}
	}

	/**
	 * @return Title Article Title
	 * @throws NotFoundApiException
	 * @throws BadRequestApiException
	 */
	private function getTitleFromRequest() {
		$articleId = $this->request->getInt( self::PARAM_ARTICLE_ID, null );
		$articleTitle = $this->request->getVal( self::PARAM_ARTICLE_TITLE, null );
		$articleTitleValidator = new WikiaValidatorString( [ 'min' => 1, 'required' => true ] );

		if ( !empty( $articleId ) && $articleTitleValidator->isValid( $articleTitle ) ) {
			throw new BadRequestApiException( 'Can\'t use id and title in the same request' );
		}

		if ( empty( $articleId ) && !$articleTitleValidator->isValid( $articleTitle ) ) {
			throw new BadRequestApiException( 'You need to pass title or id of an article' );
		}

		if ( empty( $articleId ) ) {
			$title = Title::newFromText( $articleTitle );
		} else {
			$title = Title::newFromId( $articleId );
		}

		if ( !$title instanceof Title || !$title->isKnown() || !$title->isContentPage() ) {
			$title = false;
		}

		if ( empty( $title ) ) {
			throw new NotFoundApiException( 'Unable to find any article' );
		}

		return $title;
	}

	/**
	 * @desc Returns article comments in JSON format
	 *
	 * @throws NotFoundApiException
	 * @throws BadRequestApiException
	 * @throws InvalidParameterApiException
	 */
	public function getArticleComments() {
		$title = $this->getTitleFromRequest();
		$articleId = $title->getArticleId();

		$page = $this->request->getInt( self::PARAM_PAGE, self::DEFAULT_PAGE );

		$commentsResponse = $this->app->sendRequest(
			'ArticleComments',
			'WikiaMobileCommentsPage',
			[
				'articleID' => $articleId,
				'page' => $page,
				'format' => WikiaResponse::FORMAT_JSON
			]
		);

		if ( empty( $commentsResponse ) ) {
			throw new BadRequestApiException();
		}

		$commentsData = $commentsResponse->getData();
		$comments = $this->mercuryApi->processArticleComments( $commentsData );

		$this->response->setVal( 'payload', $comments );
		$this->response->setVal( 'pagesCount', $commentsData['pagesCount'] );
		$this->response->setVal( 'basePath', $this->wg->Server );
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
	}

	/**
	 * @desc Returns wiki variables for the current wiki
	 *
	 */
	public function getWikiVariables() {

		$wikiVariables = $this->mercuryApi->getWikiVariables();

		$navigation = $this->getNavigation();
		if ( empty( $navData ) ) {
			\Wikia\Logger\WikiaLogger::instance()->error(
				'Fallback to empty navigation'
			);
		}

		$wikiVariables['navigation'] = $navigation;
		$wikiVariables['vertical'] = WikiFactoryHub::getInstance()->getWikiVertical( $this->wg->CityId )['short'];
		$wikiVariables['basePath'] = $this->wg->Server;

		// Used to determine GA tracking
		if ( !empty( $this->wg->IsGASpecialWiki ) ) {
			$wikiVariables['isGASpecialWiki'] = true;
		}

		if ( !empty( $this->wg->ArticlePath ) ) {
			$wikiVariables['articlePath'] = str_replace( '$1', '', $this->wg->ArticlePath );
		} else {
			$wikiVariables['articlePath'] = '/wiki/';
		}

		$smartBannerConfig = $this->getSmartBannerConfig();
		if ( !is_null( $smartBannerConfig ) ) {
			$wikiVariables['smartBanner'] = $smartBannerConfig;
		}

		$wikiImages = ( new WikiService() )->getWikiImages( [ $this->wg->CityId ], self::WIKI_IMAGE_SIZE );
		if ( !empty( $wikiImages[$this->wg->CityId] ) ) {
			$wikiVariables['image'] = $wikiImages[$this->wg->CityId];
		}

		$wikiVariables['specialRobotPolicy'] = null;
		$robotPolicy = Wikia::getEnvironmentRobotPolicy( $this->getContext()->getRequest() );
		if ( !empty( $robotPolicy ) ) {
			$wikiVariables['specialRobotPolicy'] = $robotPolicy;
		}

		// template for non-main pages (use $1 for article name)
		$wikiVariables['htmlTitleTemplate'] = ( new WikiaHtmlTitle() )->setParts( ['$1'] )->getTitle();

		$this->response->setVal( 'data', $wikiVariables );
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );

		// cache wikiVariables for 1 minute
		$this->response->setCacheValidity( self:: WIKI_VARIABLES_CACHE_TTL );
	}

	/**
	 * @throws NotFoundApiException
	 * @throws BadRequestApiException
	 */
	public function getArticle() {
		global $wgEnableMainPageDataMercuryApi, $wgWikiaCuratedContent;

		try {
			$title = $this->getTitleFromRequest();
			$articleId = $title->getArticleId();
			$sections = $this->getVal( 'sections' );

			// getArticle is cached (see the bottom of the method body) so there is no need for additional caching here
			$article = Article::newFromID( $articleId );

			if ( $title->isRedirect() ) {
				/* @var Title|null $redirectTargetTitle */
				$redirectTargetTitle = $article->getRedirectTarget();
				$data['redirected'] = true;
				if ( $redirectTargetTitle instanceof Title && !empty( $redirectTargetTitle->getArticleID() ) ) {
					$article = Article::newFromID( $redirectTargetTitle->getArticleID() );
					$title = $redirectTargetTitle;
				} else {
					$data['redirectEmptyTarget'] = true;
				}
			}

			if ( !$article instanceof Article ) {
				\Wikia\Logger\WikiaLogger::instance()->error(
					'$article should be an instance of an Article',
					[
						'$article' => $article,
						'$articleId' => $articleId,
						'$title' => $title
					]
				);

				throw new NotFoundApiException( 'Article is empty' );
			}

			$data['details'] = $this->getArticleDetails( $article );

			$isMainPage = $title->isMainPage();
			$data['isMainPage'] = $isMainPage;

			$titleBuilder = new WikiaHtmlTitle();

			if ( $isMainPage && !empty( $wgEnableMainPageDataMercuryApi ) && !empty( $wgWikiaCuratedContent ) ) {
				$data['mainPageData'] = $this->getMainPageData();
			} else {
				$articleAsJson = $this->getArticleJson( $articleId, $title, $sections );
				$data['article'] = $articleAsJson;
				$data['topContributors'] = $this->getTopContributorsDetails(
					$this->getTopContributorsPerArticle( $articleId )
				);
				$relatedPages = $this->getRelatedPages( $articleId );

				if ( !empty( $relatedPages ) ) {
					$data['relatedPages'] = $relatedPages;
				}
				$titleBuilder->setParts( [ $articleAsJson['displayTitle'] ] );
			}
			$data['htmlTitle'] = $titleBuilder->getTitle();

		} catch ( WikiaHttpException $exception ) {
			$this->response->setCode( $exception->getCode() );

			$data = [ ];

			$this->response->setVal(
				'exception',
				[
					'message' => $exception->getMessage(),
					'code' => $exception->getCode(),
					'details' => $exception->getDetails()
				]
			);

			$title = $this->wg->Title;
		}

		$data['adsContext'] = $this->mercuryApi->getAdsContext( $title );

		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
		$this->response->setCacheValidity( WikiaResponse::CACHE_STANDARD );

		$this->response->setVal( 'data', $data );
	}

	/**
	 * @desc HG-377: Returns search suggestions
	 *
	 * @throws NotFoundApiException
	 * @throws MissingParameterApiException
	 */
	public function getSearchSuggestions() {
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
		$this->response->setValues(
			$this->sendRequest( 'SearchSuggestionsApi', 'getList', $this->request->getParams() )->getData()
		);
	}

	private function getMainPageData() {
		$mainPageData = [ ];
		$curatedContent = $this->getCuratedContentData();
		$trendingArticles = $this->getTrendingArticlesData();
		$trendingVideos = $this->getTrendingVideosData();
		$wikiaStats = $this->getWikiaStatsData();

		if ( !empty( $curatedContent['items'] ) ) {
			$mainPageData['curatedContent'] = $curatedContent['items'];
		}

		if ( !empty( $curatedContent['featured'] ) ) {
			$mainPageData['featuredContent'] = $curatedContent['featured'];
		}

		if ( !empty( $trendingArticles ) ) {
			$mainPageData['trendingArticles'] = $trendingArticles;
		}

		if ( !empty( $trendingVideos ) ) {
			$mainPageData['trendingVideos'] = $trendingVideos;
		}

		if ( !empty( $wikiaStats ) ) {
			$mainPageData['wikiaStats'] = $wikiaStats;
		}

		return $mainPageData;
	}

	public function getCuratedContentSection() {
		$section = $this->getVal( 'section' );
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
		$this->response->setCacheValidity( WikiaResponse::CACHE_STANDARD );

		if ( empty( $section ) ) {
			throw new NotFoundApiException( 'Section is not set' );
		}

		$data = $this->getCuratedContentData( $section );

		if ( empty( $data ) ) {
			throw new NotFoundApiException( 'No members' );
		}

		$this->response->setVal( 'items', $data['items'] );
	}

	public function getMainPageDetailsAndAdsContext() {
		$mainPageTitle = Title::newMainPage();
		$mainPageArticleID = $mainPageTitle->getArticleID();
		$article = Article::newFromID( $mainPageArticleID );
		$data = [ ];

		$data['details'] = $this->getArticleDetails( $article );
		$data['adsContext'] = $this->mercuryApi->getAdsContext( $mainPageTitle );

		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
		$this->response->setCacheValidity( WikiaResponse::CACHE_STANDARD );
		$this->response->setVal( 'data', $data );
	}

	public static function curatedContentDataMemcKey( $section = null ) {
		return wfMemcKey( 'curated-content-section-data', $section );
	}

	public function getCuratedContentData( $section = null ) {
		$data = [ ];

		try {
			$data = WikiaDataAccess::cache(
				self::curatedContentDataMemcKey( $section ),
				WikiaResponse::CACHE_STANDARD,
				function () use ( $section ) {
					$rawData = $this->sendRequest(
						'CuratedContent',
						'getList',
						empty( $section ) ? [ ] : [ 'section' => $section ]
					)->getData();

					return $this->mercuryApi->processCuratedContent( $rawData );
				}
			);
		} catch ( NotFoundException $ex ) {
			WikiaLogger::instance()->info( 'Curated content and categories are empty' );
		}

		return $data;
	}

	private function getTrendingArticlesData() {
		global $wgContentNamespaces;

		$params = [
			'abstract' => false,
			'expand' => true,
			'limit' => 10,
			'namespaces' => implode( ',', $wgContentNamespaces )
		];
		$data = [ ];

		try {
			$rawData = $this->sendRequest( 'ArticlesApi', 'getTop', $params )->getData();
			$data = $this->mercuryApi->processTrendingArticlesData( $rawData );
		} catch ( NotFoundException $ex ) {
			WikiaLogger::instance()->info( 'Trending articles data is empty' );
		}

		return $data;
	}

	private function getTrendingVideosData() {
		$params = [
			'sort' => 'trend',
			'getThumbnail' => false,
			'format' => 'json',
		];
		$data = [ ];

		try {
			$rawData = $this->sendRequest( 'SpecialVideosSpecial', 'getVideos', $params )->getData();
			$data = $this->mercuryApi->processTrendingVideoData( $rawData );
		} catch ( NotFoundException $ex ) {
			WikiaLogger::instance()->info( 'Trending videos data is empty' );
		}

		return $data;
	}

	private function getWikiaStatsData() {
		global $wgCityId;

		$service = new WikiDetailsService();
		$wikiDetails = $service->getWikiDetails( $wgCityId );

		return $wikiDetails['stats'];
	}
}
