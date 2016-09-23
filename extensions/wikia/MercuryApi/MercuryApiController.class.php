<?php

use Wikia\Logger\WikiaLogger;
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
				'ios' => $meta[ 'ios-scheme' ] ?? null,
				'android' => $meta[ 'android-scheme' ] ?? null,
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

		if ( empty( $navigation ) ) {
			\Wikia\Logger\WikiaLogger::instance()->notice(
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

		$htmlTitle = new WikiaHtmlTitle();
		$wikiVariables[ 'htmlTitle' ] = [
			'separator' => $htmlTitle->getSeparator(),
			'parts' => $htmlTitle->getAllParts(),
		];

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
	 * @desc Returns UA dimensions
	 */
	public function getTrackingDimensions() {
		global $wgDBname, $wgUser, $wgCityId, $wgLanguageCode;

		$dimensions = [];

		// Exception is thrown when empty title is send
		// In that case we don't want to set dimensions which depend on title
		// Title parameter is empty for URLs like /main/edit, /d etc. (all pages outside /wiki/ space)
		try {
			$title = $this->getTitleFromRequest();

			$article = Article::newFromID( $title->getArticleId() );

			if ( $article instanceof Article && $title->isRedirect() ) {
				$title = $this->handleRedirect( $title, $article, [] )[0];
			}

			$adContext = ( new AdEngine2ContextService() )->getContext( $title, 'mercury' );
			$dimensions[3] = $adContext['targeting']['wikiVertical'];
			$dimensions[14] = $adContext['opts']['showAds'] ? 'Yes' : 'No';
			$dimensions[19] = WikiaPageType::getArticleType( $title );
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
		$dimensions[9] = $wgCityId;
		$dimensions[13] = AdTargeting::getEsrbRating();
		$dimensions[15] = WikiaPageType::isCorporatePage() ? 'yes' : 'no';
		$dimensions[17] = WikiFactoryHub::getInstance()->getWikiVertical( $wgCityId )['short'];
		$dimensions[18] = $wikiCategoryNames;
		$dimensions[23] = in_array( 'poweruser_lifetime', $powerUserTypes ) ? 'yes' : 'no';
		$dimensions[24] = in_array( 'poweruser_frequent', $powerUserTypes ) ? 'yes' : 'no';

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
			$articleExists = $article instanceof Article;

			if ( $articleExists && $title->isRedirect() ) {
				list( $title, $article, $data ) = $this->handleRedirect( $title, $article, $data );
			}

			$isMainPage = $title->isMainPage();
			$data['isMainPage'] = $isMainPage;
			$data['ns'] = $title->getNamespace();

			if ( MercuryApiMainPageHandler::shouldGetMainPageData( $isMainPage ) ) {
				$data['mainPageData'] = MercuryApiMainPageHandler::getMainPageData( $this->mercuryApi );

				if ( $article instanceof Article ) {
					$data['details'] = MercuryApiArticleHandler::getArticleDetails( $article );
				} else {
					$data['details'] = MercuryApiMainPageHandler::getMainPageMockedDetails( $title );
				}
			} else {
				switch ( $data['ns'] ) {
					// Handling namespaces other than content ones
					case NS_CATEGORY:
						$data['nsSpecificContent'] = MercuryApiCategoryHandler::getCategoryContent( $title );

						if ( MercuryApiCategoryHandler::hasArticle( $this->request, $article ) ) {
							$data['details'] = MercuryApiArticleHandler::getArticleDetails( $article );
							$data['article'] = MercuryApiArticleHandler::getArticleJson( $this->request, $article );

							// Remove namespace prefix from displayTitle, so it can be consistent with title
							// Prefix shows only if page doesn't have {{DISPLAYTITLE:title} in it's markup
							$data['article']['displayTitle'] = Title::newFromText($data['article']['displayTitle'])->getText();
						} elseif ( !empty( $data['nsSpecificContent']['members']['sections'] ) ) {
							$data['details'] = MercuryApiCategoryHandler::getCategoryMockedDetails( $title );
						} else {
							throw new NotFoundApiException( 'Article is empty and category has no members' );
						}

						break;
					default:
						if ( $title->isContentPage() ) {
							if ( $title->isKnown() && $articleExists ) {
								$data = array_merge(
									$data,
									MercuryApiArticleHandler::getArticleData( $this->request, $this->mercuryApi, $article )
								);
							} else {
								\Wikia\Logger\WikiaLogger::instance()->error(
									'$article should be an instance of an Article',
									['article' => $article]
								);

								throw new NotFoundApiException( 'Article is empty' );
							}
						}
				}
			}
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

		$data['articleType'] = WikiaPageType::getArticleType( $title );
		$data['adsContext'] = $this->mercuryApi->getAdsContext( $title );
		$otherLanguages = $this->getOtherLanguages( $title );

		if ( !empty( $otherLanguages ) ) {
			$data['otherLanguages'] = $otherLanguages;
		}

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

	public function getCuratedContentSection() {
		$section = $this->getVal( 'section' );
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
		$this->response->setCacheValidity( WikiaResponse::CACHE_STANDARD );

		if ( empty( $section ) ) {
			throw new NotFoundApiException( 'Section is not set' );
		}

		$data = MercuryApiMainPageHandler::getCuratedContentData( $this->mercuryApi, $section );

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

		$data[ 'details' ] = MercuryApiArticleHandler::getArticleDetails( $article );
		$data[ 'adsContext' ] = $this->mercuryApi->getAdsContext( $mainPageTitle );

		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
		$this->response->setCacheValidity( WikiaResponse::CACHE_STANDARD );
		$this->response->setVal( 'data', $data );
	}

	/**
	 * @param null|String $section
	 * @return array|Mixed|null
	 */
	public function getCuratedContentData( $section = null ) {
		return MercuryApiMainPageHandler::getCuratedContentData( $this->mercuryApi, $section );
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
}
