<?php

use Wikia\Util\GlobalStateWrapper;

class MercuryApiController extends WikiaController {

	const PARAM_ARTICLE_ID = 'id';
	const PARAM_PAGE = 'page';
	const PARAM_ARTICLE_TITLE = 'title';

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
	 * @desc Returns local navigation data for current wiki
	 *
	 * @return array
	 */
	private function getNavigation() {
		$navData = $this->sendRequest( 'NavigationApi', 'getData' )->getData();

		if ( !isset( $navData['navigation']['wiki'] ) ) {
			$localNavigation = [];
		} else {
			$localNavigation = $navData['navigation']['wiki'];
		}

		return $localNavigation;
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
		$this->response->setVal( 'pagesCount', $commentsData['pagesCount'] );
		$this->response->setVal( 'basePath', $this->wg->Server );
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
	}

	/**
	 * @desc Prepares wiki variables for the current wikia
	 */
	private function prepareWikiVariables() {
		$wikiVariables = $this->mercuryApi->getWikiVariables();
		$navigation = $this->getNavigation();

		if ( empty( $navigation ) ) {
			\Wikia\Logger\WikiaLogger::instance()->notice(
				'Fallback to empty navigation'
			);
		}

		$wikiVariables['localNav'] = $navigation;
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

		// get wiki image from Curated Main Pages (SUS-474)
		$communityData = ( new CommunityDataService( $this->wg->CityId ) )->getCommunityData();

		if ( !empty( $communityData['image_id'] ) ) {
			$url = CuratedContentHelper::getImageUrl( $communityData['image_id'], self::WIKI_IMAGE_SIZE );
			$wikiVariables['image'] = $url;
		}

		$wikiVariables['specialRobotPolicy'] = null;
		$robotPolicy = Wikia::getEnvironmentRobotPolicy( $this->getContext()->getRequest() );
		if ( !empty( $robotPolicy ) ) {
			$wikiVariables['specialRobotPolicy'] = $robotPolicy;
		}

		$htmlTitle = new WikiaHtmlTitle();
		$wikiVariables['htmlTitle'] = [
			'separator' => $htmlTitle->getSeparator(),
			'parts' => array_values( $htmlTitle->getAllParts() ),
		];

		return $wikiVariables;
	}

	/**
	 * @desc Returns wiki variables for the current wikia
	 *
	 */
	public function getWikiVariables() {
		(new CrossOriginResourceSharingHeaderHelper())
		  ->allowWhitelistedOrigins()
		  ->setAllowMethod( [ 'GET' ] )
		  ->setHeaders($this->response);

		$wikiVariables = $this->prepareWikiVariables();

		$this->response->setVal( 'data', $wikiVariables );
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );

		// cache wikiVariables for 1 minute
		$this->response->setCacheValidity( self:: WIKI_VARIABLES_CACHE_TTL );
	}

	/**
	 * @desc Returns UA dimensions
	 */
	public function getTrackingDimensions() {
		global $wgDBname, $wgUser, $wgCityId, $wgLanguageCode;

		$dimensions = [ ];

		// Exception is thrown when empty title is send
		// In that case we don't want to set dimensions which depend on title
		// Title parameter is empty for URLs like /main/edit, /d etc. (all pages outside /wiki/ space)
		try {
			$title = $this->getTitleFromRequest();
			$articleId = $title->getArticleId();

			$article = Article::newFromID( $articleId );

			if ( $article instanceof Article && $title->isRedirect() ) {
				$title = $this->handleRedirect( $title, $article, [ ] )[0];
			}

			$adContext = ( new AdEngine2ContextService() )->getContext( $title, 'mercury' );
			$dimensions[3] = $adContext['targeting']['wikiVertical'];
			$dimensions[14] = !empty( $adContext['opts']['showAds'] ) ? 'Yes' : 'No';
			$dimensions[19] = WikiaPageType::getArticleType( $title );
			$dimensions[21] = (string)$articleId;
			$dimensions[25] = strval( $title->getNamespace() );
		} catch ( Exception $ex ) {
			// In case of exception - don't set the dimensions
		}

		$wikiCategoryNames = WikiFactoryHub::getInstance()->getWikiCategoryNames( $wgCityId );
		$wikiCategoryNames = join( ',', $wikiCategoryNames );

		$powerUserTypes = ( new \Wikia\PowerUser\PowerUser( $wgUser ) )->getTypesForUser();

		$dimensions[1] = $wgDBname;
		$dimensions[2] = $wgLanguageCode;
		$dimensions[4] = 'mercury';
		$dimensions[5] = $wgUser->isAnon() ? 'anon' : 'user';
		$dimensions[8] = WikiaPageType::getPageType();
		$dimensions[9] = $wgCityId;
		$dimensions[13] = AdTargeting::getEsrbRating();
		$dimensions[15] = WikiaPageType::isCorporatePage() ? 'yes' : 'no';
		$dimensions[17] = WikiFactoryHub::getInstance()->getWikiVertical( $wgCityId )['short'];
		$dimensions[18] = $wikiCategoryNames;
		$dimensions[23] = in_array( 'poweruser_lifetime', $powerUserTypes ) ? 'yes' : 'no';
		$dimensions[24] = in_array( 'poweruser_frequent', $powerUserTypes ) ? 'yes' : 'no';
		$dimensions[28] = !empty( $adContext['targeting']['hasPortableInfobox'] ) ? 'yes' : 'no';
		$dimensions[29] = !empty( $adContext['targeting']['hasFeaturedVideo'] ) ? 'yes' : 'no';

		if ( !empty( $this->request->getBool( 'isanon' ) ) ) {
			$this->response->setCacheValidity( WikiaResponse::CACHE_STANDARD );
		}

		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
		$this->response->setVal( 'dimensions', $dimensions );
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
		$wrapper = new GlobalStateWrapper( [ 'wgArticleAsJson' => true ] );

		if ( !empty( $this->getVal( 'CKmarkup' ) ) ) {
			$wikitext = RTE::HtmlToWikitext( $this->getVal( 'CKmarkup' ) );
		}

		if ( $title ) {
			$wrapper->wrap(
				function () use ( &$articleAsJson, $wikitext, $title, $parserOptions ) {
					// explicit revisionId of -1 passed to ensure proper behavior on ArticleAsJson end
					$articleAsJson = json_decode(
						ParserPool::create()->parse( $wikitext, $title, $parserOptions, true, true, -1 )->getText()
					);
				}
			);
		} else {
			$this->response->setVal( 'data', [ 'content' => 'Invalid title' ] );
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
		$cacheValidity = WikiaResponse::CACHE_STANDARD;

		try {
			$title = $this->getTitleFromRequest();
			$data = [
				'ns' => $title->getNamespace()
			];

			// handle cases like starwars.wikia.com/wiki/w:c:clashroyale:Tesla (interwiki links)
			$interWikiUrl = InterwikiDispatcher::getInterWikiaURL( $title );

			if ( empty( $interWikiUrl ) && $this->isSupportedByMercury( $title ) ) {
				// Empty category pages are not known but contain article list;
				if ( !$title->isKnown() && $title->getNamespace() !== NS_CATEGORY ) {
					throw new NotFoundApiException( 'Page doesn\'t exist' );
				}

				// InterwikiDispatcher::getInterWikiaURL does not support other prefixes than InterwikiDispatcher::SUPPORTED_IW_PREFIXES
				// but other prefixes may be defined in `interwiki` table for given wiki - in such case $title->isKnown()
				// returns true in previous `if` statement
				if ( !empty( $title->mInterwiki ) && !InterwikiDispatcher::isSupportedPrefix( $title->mInterwiki ) ) {
					throw new InvalidParameterApiException( 'title' );
				}

				// getPage is cached (see the bottom of the method body) so there is no need for additional caching here
				$article = Article::newFromID( $title->getArticleId() );
				$displayTitle = null;

				if ( $title->isRedirect() ) {
					list( $title, $article, $data ) = $this->handleRedirect( $title, $article, $data );
				}

				$isMainPage = $title->isMainPage();
				$data['isMainPage'] = $isMainPage;

				if ( $article instanceof Article) {
					$articleData = MercuryApiArticleHandler::getArticleJson( $this->request, $article );
					$data['categories'] = $articleData['categories'];
					$data['details'] = MercuryApiArticleHandler::getArticleDetails( $article );
				} else {
					$data['categories'] = [];
					/*
					 * Categories with empty article doesn't allow us to get details.
					 * In this case we return mocked data that allows mercury to operate correctly. HTML title etc.
					 */
					$data['details'] = MercuryApiCategoryHandler::getCategoryMockedDetails( $title );
				}

				$data['articleType'] = WikiaPageType::getArticleType( $title );
				$data['adsContext'] = $this->mercuryApi->getAdsContext( $title );
				// Set it before we remove the namespace from $displayTitle
				$data['htmlTitle'] = $this->mercuryApi->getHtmlTitleForPage( $title, $displayTitle );

				if ( MercuryApiMainPageHandler::shouldGetMainPageData( $isMainPage ) ) {
					$data['curatedMainPageData'] = MercuryApiMainPageHandler::getMainPageData( $this->mercuryApi );
				} else {
					if ( !empty( $articleData['content'] ) ) {
						$data['article'] = $articleData;
						$data['article']['hasPortableInfobox'] = !empty( \Wikia::getProps( $title->getArticleID(), PortableInfoboxDataService::INFOBOXES_PROPERTY_NAME ) );

						$featuredVideo = MercuryApiArticleHandler::getFeaturedVideoDetails( $title );
						if ( !empty( $featuredVideo ) ) {
							$data['article']['featuredVideo'] = $featuredVideo;
						}

						if ( !$title->isContentPage() ) {
							// Remove the namespace prefix from display title
							$displayTitle = Title::newFromText( $displayTitle )->getText();
							$data['article']['displayTitle'] = $displayTitle;
						}
					}

					switch ( $data['ns'] ) {
						// Handling namespaces other than content ones
						case NS_CATEGORY:
							$categoryMembersPage = MercuryApiCategoryHandler::getCategoryMembersPageFromRequest(
								$this->request
							);
							$data['nsSpecificContent'] = MercuryApiCategoryHandler::getCategoryPageData(
								$title,
								$categoryMembersPage,
								$this->mercuryApi
							);

							// We don't cache subsequent pages, because there is no good way to purge them
							// TODO remove this when icache supports surrogate keys (OPS-10115)
							if ( $categoryMembersPage > 1 ) {
								$cacheValidity = WikiaResponse::CACHE_DISABLED;
							}

							break;
						case NS_FILE:
							$data['nsSpecificContent'] = MercuryApiFilePageHandler::getFileContent( $title );
							break;
						default:
							$data = array_merge(
								$data,
								MercuryApiArticleHandler::getArticleData( $this->mercuryApi, $article )
							);
					}
				}
			}

			\Hooks::run( 'MercuryPageData', [ $title, &$data ] );
		} catch ( WikiaHttpException $exception ) {
			$this->response->setCode( $exception->getCode() );

			$data = [];

			$this->response->setVal(
				'exception',
				[
					'message' => $exception->getMessage(),
					'code' => $exception->getCode(),
					'details' => $exception->getDetails()
				]
			);
		}

		// if $interwikiUrl is not empty it means that we should redirect to other wiki (follow interwiki link)
		if ( !empty( $interWikiUrl ) ) {
			$data = [
				'redirectTo' => $interWikiUrl,
			];
		}

		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
		$this->response->setCacheValidity( $cacheValidity );
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

			// When title is a redirect we need to override namespace with it's target value
			$data['ns'] = $title->getNamespace();
		} else {
			$data['redirectEmptyTarget'] = true;
		}

		return [ $title, $article, $data ];
	}

	public function getCategoryMembers() {
		try {
			$title = $this->getTitleFromRequest();

			if ( $title->isRedirect() ) {
				$article = new Article( $title );
				$redirectTargetTitle = $article->getRedirectTarget();

				if ( !is_null( $redirectTargetTitle ) && ( $redirectTargetTitle->getNamespace() === NS_CATEGORY ) ) {
					$title = $redirectTargetTitle;
				}
			}

			$page = MercuryApiCategoryHandler::getCategoryMembersPageFromRequest( $this->request );
			$data = MercuryApiCategoryHandler::getCategoryMembers( $title, $page );
		} catch ( WikiaHttpException $exception ) {
			$this->response->setCode( $exception->getCode() );

			$data = [];

			$this->response->setVal(
				'exception',
				[
					'message' => $exception->getMessage(),
					'code' => $exception->getCode(),
					'details' => $exception->getDetails()
				]
			);
		}

		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
		// We don't cache it, because there is no easy way to purge all pages
		// TODO start caching when icache supports surrogate keys (OPS-10115)
		$this->response->setCacheValidity( WikiaResponse::CACHE_DISABLED );
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

	private function isSupportedByMercury( Title $title ) {
		$nsList = [ NS_FILE, NS_CATEGORY ];

		if ( defined( 'NS_BLOG_ARTICLE' ) ) {
			$nsList[] = NS_BLOG_ARTICLE;
		}

		return MercuryApiMainPageHandler::shouldGetMainPageData( $title->isMainPage() ) ||
			$title->isContentPage() ||
			in_array( $title->getNamespace(), $nsList );
	}
}
