<?php

use Wikia\Logger\WikiaLogger;
use Wikia\Util\GlobalStateWrapper;

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

			unset( $smartBannerConfig[ 'author' ] );

			if ( !empty( $smartBannerConfig[ 'icon' ] ) &&
				 !isset( parse_url( $smartBannerConfig[ 'icon' ] )[ 'scheme' ] ) // it differs per wiki
			) {
				$smartBannerConfig[ 'icon' ] = $this->wg->extensionsPath . $smartBannerConfig[ 'icon' ];
			}

			$meta = $smartBannerConfig[ 'meta' ];
			unset( $smartBannerConfig[ 'meta' ] );
			$smartBannerConfig[ 'appId' ] = [
				'ios' => str_replace( 'app-id=', '', $meta[ 'apple-itunes-app' ] ),
				'android' => str_replace( 'app-id=', '', $meta[ 'google-play-app' ] ),
			];

			$smartBannerConfig[ 'appScheme' ] = [
				'ios' => $meta[ 'ios-scheme' ],
				'android' => $meta[ 'android-scheme' ]
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
			$this->sendRequest( 'ArticlesApi', 'getDetails', [ 'ids' => $articleId ] )->getData()[ 'items' ][ $articleId ];

		$description = $this->getArticleDescription( $article );

		$articleDetails[ 'abstract' ] = htmlspecialchars( $articleDetails[ 'abstract' ] );
		$articleDetails[ 'description' ] = htmlspecialchars( $description );

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
	 * @param string $sections List of section numbers or 'all'
	 *
	 * @return array
	 */
	private function getArticleJson( $articleId, $sections = '' ) {
		$redirect = $this->request->getVal( 'redirect' );

		return $this->sendRequest(
				'ArticlesApi',
				'getAsJson',
				[
					'id' => $articleId,
					'redirect' => $redirect,
					'sections' => $sections
				]
			)->getData();
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
			return $this->sendRequest( 'UserApi', 'getDetails', [ 'ids' => implode( ',', $ids ) ] )->getData()[ 'items' ];
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
		global $wgLang;

		$navData = $this->sendRequest( 'NavigationApi', 'getData' )->getData();

		if ( !isset( $navData[ 'navigation' ][ 'wiki' ] ) ) {
			$localNavigation = [ ];
		} else {
			$localNavigation = $navData[ 'navigation' ][ 'wiki' ];
		}

		$navigationNodes = ( new GlobalNavigationHelper() )->getMenuNodes();

		// Add link to explore wikia only for EN language
		if ( $wgLang->getCode() === WikiaLogoHelper::FANDOM_LANG ) {
			$navigationNodes[ 'exploreDropdown' ][] = [
				'text' => wfMessage( 'global-navigation-explore-wikia-mercury-link-label' )->plain(),
				'textEscaped' => wfMessage( 'global-navigation-explore-wikia-mercury-link-label' )->escaped(),
				'href' => wfMessage( 'global-navigation-explore-wikia-link' )->plain(),
				'trackingLabel' => 'explore-wikia'
			];
		}

		return [
			'hubsLinks' => $navigationNodes[ 'hubs' ],
			'exploreWikia' => $navigationNodes[ 'exploreWikia' ],
			'exploreWikiaMenu' => $navigationNodes[ 'exploreDropdown' ],
			'localNav' => $localNavigation,
			'fandomLabel' => wfMessage( 'global-navigation-home-of-fandom' )->escaped()
		];
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

		if ( !$title instanceof Title ) {
			throw new NotFoundApiException( 'An error occured while getting the title.' );
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
		$this->response->setVal( 'pagesCount', $commentsData[ 'pagesCount' ] );
		$this->response->setVal( 'basePath', $this->wg->Server );
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
	}

	/**
	 * @desc Prepares wiki variables for the current wikia
	 */
	private function prepareWikiVariables() {
		$wikiVariables = $this->mercuryApi->getWikiVariables();
		$navigation = $this->getNavigation();
		if ( empty( $navData ) ) {
			\Wikia\Logger\WikiaLogger::instance()->error(
				'Fallback to empty navigation'
			);
		}

		$wikiVariables[ 'navigation2016' ] = $navigation;
		$wikiVariables[ 'vertical' ] = WikiFactoryHub::getInstance()->getWikiVertical( $this->wg->CityId )[ 'short' ];
		$wikiVariables[ 'basePath' ] = $this->wg->Server;

		// Used to determine GA tracking
		if ( !empty( $this->wg->IsGASpecialWiki ) ) {
			$wikiVariables[ 'isGASpecialWiki' ] = true;
		}

		if ( !empty( $this->wg->ArticlePath ) ) {
			$wikiVariables[ 'articlePath' ] = str_replace( '$1', '', $this->wg->ArticlePath );
		} else {
			$wikiVariables[ 'articlePath' ] = '/wiki/';
		}

		$smartBannerConfig = $this->getSmartBannerConfig();
		if ( !is_null( $smartBannerConfig ) ) {
			$wikiVariables[ 'smartBanner' ] = $smartBannerConfig;
		}

		$wikiImages = ( new WikiService() )->getWikiImages( [ $this->wg->CityId ], self::WIKI_IMAGE_SIZE );
		if ( !empty( $wikiImages[ $this->wg->CityId ] ) ) {
			$wikiVariables[ 'image' ] = $wikiImages[ $this->wg->CityId ];
		}

		$wikiVariables[ 'specialRobotPolicy' ] = null;
		$robotPolicy = Wikia::getEnvironmentRobotPolicy( $this->getContext()->getRequest() );
		if ( !empty( $robotPolicy ) ) {
			$wikiVariables[ 'specialRobotPolicy' ] = $robotPolicy;
		}

		// template for non-main pages (use $1 for article name)
		$wikiVariables['htmlTitleTemplate'] = ( new WikiaHtmlTitle() )->setParts( ['$1'] )->getTitle();
		return $wikiVariables;
	}

	/**
	 * @desc Returns wiki variables for the current wikia
	 *
	 */
	public function getWikiVariables() {
		$wikiVariables = $this->prepareWikiVariables();

		$this->response->setVal( 'data', $wikiVariables );
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );

		// cache wikiVariables for 1 minute
		$this->response->setCacheValidity( self:: WIKI_VARIABLES_CACHE_TTL );
	}

	/**
	 * @desc for classic or CK editor markup return
	 * wikitext ready to process and display in Mercury skin
	 *
	 * @throws \BadRequestApiException
	 * @throws \MWException
	 */
	public function getArticleFromMarkup() {
		global $wgUser, $wgRequest;

		if ( !$wgRequest->wasPosted() ) {
			throw new BadRequestApiException();
		}

		// set mobile skin explicitly as we want to get parser output for Mercury
		RequestContext::getMain()->setSkin( Skin::newFromKey( 'wikiamobile' ) );

		$wikitext = $this->getVal( 'wikitext' );
		$titleText = !empty( $this->getVal( 'title' ) ) ? $this->getVal( 'title' ) : '';
		$title = Title::newFromText( $titleText );
		$parserOptions = new ParserOptions( $wgUser );
		$wrapper = new GlobalStateWrapper( ['wgArticleAsJson' => true] );

		if ( !empty( $this->getVal( 'CKmarkup' ) ) ) {
			$wikitext = RTE::HtmlToWikitext( $this->getVal( 'CKmarkup' ) );
		}

		if ( $title ) {
			$wrapper->wrap( function () use ( &$articleAsJson, $wikitext, $title, $parserOptions ) {
				// explicit revisionId of -1 passed to ensure proper behavior on ArticleAsJson end
				$articleAsJson = json_decode( ParserPool::create()->parse( $wikitext, $title, $parserOptions, true, true, -1 )->getText() );
			} );
		} else {
			$this->response->setVal( 'data', ['content' => 'Invalid title'] );
			return;
		}

		$data['article'] = [
			'content' => $articleAsJson->content,
			'media' => $articleAsJson->media
		];

		$wikiVariables = $this->prepareWikiVariables();

		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
		$this->response->setCacheValidity( WikiaResponse::CACHE_STANDARD );
		$this->response->setVal( 'data', $data );
		$this->response->setVal( 'wikiVariables', $wikiVariables );
	}

	/**
	 * @return void
	 */
	public function getPage() {
		try {
			$title = $this->getTitleFromRequest();
			$data = [ ];

			// getPage is cached (see the bottom of the method body) so there is no need for additional caching here
			$article = Article::newFromID( $title->getArticleId() );

			if ( $article instanceof Article && $title->isRedirect() ) {
				list( $title, $article, $data ) =
					$this->handleRedirect( $title, $article, $data );
			}

			$isMainPage = $title->isMainPage();
			$data['isMainPage'] = $isMainPage;

			$otherLanguages = $this->getOtherLanguages( $title );

			if ( !empty( $otherLanguages ) ) {
				$data['otherLanguages'] = $otherLanguages;
			}

			$titleBuilder = new WikiaHtmlTitle();

			if ( $this->shouldGetMainPageData( $isMainPage ) ) {
				$data['mainPageData'] = $this->getMainPageData();
				if ( $article instanceof Article ) {
					$data['details'] = $this->getArticleDetails( $article );
				} else {
					$data['details'] = $this->getMainPageMockedDetails( $title );
				}
			} elseif ( $title->isContentPage() && $title->isKnown() ) {
				$data = array_merge( $data, $this->getArticleData( $article ) );

				if ( !$isMainPage ) {
					$titleBuilder->setParts( [ $data['article']['displayTitle'] ] );
				}
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

		$data['ns'] = $title->getNamespace();
		$data['articleType'] = WikiaPageType::getArticleType( $title );
		$data['adsContext'] = $this->mercuryApi->getAdsContext( $title );

		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
		$this->response->setCacheValidity( WikiaResponse::CACHE_STANDARD );

		$this->response->setVal( 'data', $data );
	}

	public function getArticle() {
		$this->getPage();
	}

	/**
	 * @param Title $title
	 * @param Article $article
	 * @param array $data
	 *
	 * @return array [Title, Article, array]
	 */
	private function handleRedirect( Title $title, Article $article, $data ) {
		// It should never be null because we check if $title is a redirect before calling this method
		/* @var Title $redirectTargetTitle */
		$redirectTargetTitle = $article->getRedirectTarget();
		$redirectTargetID = $redirectTargetTitle->getArticleID();
		$data['redirected'] = true;

		if ( !empty( $redirectTargetID ) ) {
			$title = $redirectTargetTitle;
			$article = Article::newFromID( $redirectTargetID );
		} else {
			$data['redirectEmptyTarget'] = true;
		}

		return [ $title, $article, $data ];
	}

	private function shouldGetMainPageData( $isMainPage ) {
		global $wgEnableMainPageDataMercuryApi, $wgCityId;

		return $isMainPage &&
			!empty( $wgEnableMainPageDataMercuryApi ) &&
			( new CommunityDataService( $wgCityId ) )->hasData();
	}

	/**
	 * @param $article
	 * @return array
	 * @throws NotFoundApiException
	 */
	private function getArticleData( $article ) {
		if ( !$article instanceof Article ) {
			\Wikia\Logger\WikiaLogger::instance()->error(
				'$article should be an instance of an Article',
				['article' => $article]
			);

			throw new NotFoundApiException( 'Article is empty' );
		}

		$articleId = $article->getID();
		$sections = $this->getVal( 'sections' );

		$data['details'] = $this->getArticleDetails( $article );
		$data['article'] = $this->getArticleJson( $articleId, $sections );
		$data['topContributors'] = $this->getTopContributorsDetails(
			$this->getTopContributorsPerArticle( $articleId )
		);
		$relatedPages = $this->getRelatedPages( $articleId );

		if ( !empty( $relatedPages ) ) {
			$data['relatedPages'] = $relatedPages;
		}

		return $data;
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

		if ( !empty( $curatedContent[ 'items' ] ) ) {
			$mainPageData[ 'curatedContent' ] = $curatedContent[ 'items' ];
		}

		if ( !empty( $curatedContent[ 'featured' ] ) ) {
			$mainPageData[ 'featuredContent' ] = $curatedContent[ 'featured' ];
		}

		if ( !empty( $trendingArticles ) ) {
			$mainPageData[ 'trendingArticles' ] = $trendingArticles;
		}

		if ( !empty( $trendingVideos ) ) {
			$mainPageData[ 'trendingVideos' ] = $trendingVideos;
		}

		if ( !empty( $wikiaStats ) ) {
			$mainPageData[ 'wikiaStats' ] = $wikiaStats;
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

		$this->response->setVal( 'items', $data[ 'items' ] );
	}

	public function getMainPageDetailsAndAdsContext() {
		$mainPageTitle = Title::newMainPage();
		$mainPageArticleID = $mainPageTitle->getArticleID();
		$article = Article::newFromID( $mainPageArticleID );
		$data = [ ];

		$data[ 'details' ] = $this->getArticleDetails( $article );
		$data[ 'adsContext' ] = $this->mercuryApi->getAdsContext( $mainPageTitle );

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

		return $wikiDetails[ 'stats' ];
	}

	private function getOtherLanguages( Title $title ) {
		global $wgEnableLillyExt;

		if ( empty( $wgEnableLillyExt ) ) {
			return null;
		}

		$url = $title->getFullURL();
		// $url = str_replace( '.rychu.wikia-dev.com', '.wikia.com', $url );

		$lilly = new Lilly();
		$links = $lilly->getCluster( $url );
		if ( !count( $links ) ) {
			return null;
		}

		// Remove link to self
		$langCode = $title->getPageLanguage()->getCode();
		unset( $links[ $langCode ] );

		// Construct the structure for Mercury
		$langMap = array_map( function ( $langCode, $url ) {
			$urlPath = parse_url( $url, PHP_URL_PATH );
			$articleTitle = preg_replace( '|^/(wiki/)?|', '', rawurldecode( $urlPath ) );
			return [
				'languageCode' => $langCode,
				'languageName' => Language::getLanguageName( $langCode ),
				'articleTitle' => str_replace( '_', ' ', $articleTitle ),
				'url' => $url,
			];
		} , array_keys( $links ), array_values( $links ) );

		// Sort by localized language name
		$c = Collator::create( 'en_US.UTF-8' );
		usort( $langMap, function ( $lang1, $lang2 ) use ( $c ) {
			return $c->compare( $lang1[ 'languageName' ], $lang2[ 'languageName' ] );
		} );

		return $langMap;
	}

	/**
	 * @TODO XW-1174 - this method should be moved to MainPageHandler.
	 * We need to define which details we should send and from where we should fetch it when article doesn't exist
	 *
	 * @param Title $title
	 * @return array
	 */
	private function getMainPageMockedDetails( Title $title ) {
		return [
			'ns' => 0,
			'title' => $title->getText(),
			'revision' => []
		];
	}
}
