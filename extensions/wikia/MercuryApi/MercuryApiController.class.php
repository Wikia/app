<?php

class MercuryApiController extends WikiaController {

	const PARAM_ARTICLE_ID = 'articleId';
	const PARAM_PAGE = 'page';
	const NUMBER_CONTRIBUTORS = 6;
	const DEFAULT_PAGE = 1;

	const ARTICLE_ID_PARAMETER_NAME = "id";
	const ARTICLE_TITLE_PARAMETER_NAME = "title";

	private $mercuryApi = null;

	public function __construct() {
		parent::__construct();
		$this->mercuryApi = new MercuryApi();
	}

	/**
	 * @desc Returns user ids for top contributors
	 *
	 * @param Title $title
	 *
	 * @return int[]
	 */
	private function getTopContributorsPerArticle( $title ) {
		$usersIds = $this->mercuryApi->topContributorsPerArticle( $title, self::NUMBER_CONTRIBUTORS );

		return $usersIds;
	}

	/**
	 * @desc returns article details
	 *
	 * @param int $articleId
	 * @return mixed
	 */
	private function getArticleDetails( $articleId ){
		return $this->sendRequest( 'ArticlesApi', 'getDetails', ['ids' => $articleId] )->getData()['items'][$articleId];
	}

	/**
	 * @desc returns an article in simplified json structure
	 *
	 * @param int $articleId
	 * @return array
	 */
	private function getArticleJson( $articleId ) {
		return $this->sendRequest( 'ArticlesApi', 'getAsJson', ['id' => $articleId] )->getData();
	}

	/**
	 * @desc returns top contributors user details
	 *
	 * @param int[] $ids
	 * @return mixed
	 */
	private function getTopContributorsDetails( $ids ) {
		return $this->sendRequest( 'UserApi', 'getDetails', ['ids' => implode(',', $ids)] )->getData()['items'];
	}

	/**
	 * @desc returns related pages
	 *
	 * @param int $articleId
	 * @param int $limit
	 * @return null
	 */
	private function getRelatedPages( $articleId, $limit = 6 ){
		return RelatedPages::getInstance()->get( $articleId, $limit );
	}

	/**
	 * @return Int
	 * @throws NotFoundApiException
	 * @throws BadRequestApiException
	 */
	private function getArticleIdFromRequest(){
		$articleId = $this->request->getInt(self::ARTICLE_ID_PARAMETER_NAME, NULL);
		$articleTitle = $this->request->getVal(self::ARTICLE_TITLE_PARAMETER_NAME, NULL);

		if ( !empty( $articleId ) && !empty( $articleTitle ) ) {
			throw new BadRequestApiException( 'Can\'t use id and title in the same request' );
		}

		if ( empty( $articleId ) && empty( $articleTitle ) ) {
			throw new BadRequestApiException( 'You need to pass title or id of an article' );
		}

		if ( empty( $articleId ) ) {
			$title = Title::newFromText( $articleTitle, NS_MAIN );
		} else {
			$title = Title::newFromId( $articleId, NS_MAIN );
		}

		if ( $title instanceof Title && $title->isKnown() ) {
			$articleId = $title->getArticleId();
		} else {
			$articleId = false;
		}

		if ( empty( $articleId ) ) {
			throw new NotFoundApiException( "Unable to find any article" );
		}

		return $articleId;
	}

	private function getAdsContext( $articleId ) {
		$title = Title::newFromID( $articleId );
		$this->wg->title = $title;

		$adEngineVariables = AdEngine2Service::getTopJsVariables();
		$requestContext = RequestContext::newExtraneousContext( $title );

		return [
			'opts' => [
				'adsInHead' => $adEngineVariables[ 'wgLoadAdsInHead' ],
				'disableLateQueue' => $adEngineVariables[ 'wgAdEngineDisableLateQueue' ],
				'lateAdsAfterPageLoad' => $adEngineVariables[ 'wgLoadLateAdsAfterPageLoad' ],
				'pageType' => $adEngineVariables[ 'adEnginePageType' ],
				'showAds' => $adEngineVariables[ 'wgShowAds' ],
				'usePostScribe' => $adEngineVariables[ 'wgUsePostScribe' ],
				'trackSlotState' => $adEngineVariables[ 'wgAdDriverTrackState' ],
			],
			'targeting' => [
				'enableKruxTargeting' => $adEngineVariables[ 'wgEnableKruxTargeting' ],
				'kruxCategoryId' => isset( $adEngineVariables[ 'wgKruxCategoryId' ] ) ?
						$adEngineVariables['wgKruxCategoryId'] :
						0,
				'pageArticleId' => $title->getArticleId(),
				'pageCategories' => $adEngineVariables[ 'wgAdDriverUseCatParam' ] ?
						$requestContext->getOutput()->getCategories() : // FIXME
						[],
				'pageIsArticle' => $requestContext->getOutput()->isArticle(), // FIXME
				'pageIsHub' => $adEngineVariables[ 'wikiaPageIsHub' ],
				'pageName' => $title->getPrefixedDBKey(),
				'pageType' => $adEngineVariables[ 'wikiaPageType' ],
				'sevenOneMediaSub2Site' => $adEngineVariables[ 'wgAdDriverSevenOneMediaOverrideSub2Site' ],
				'skin' => $requestContext->getOutput()->getSkin()->getSkinName(),
				'wikiCategory' => $adEngineVariables[ 'cityShort' ],
				'wikiCustomKeyValues' => $adEngineVariables[ 'wgDartCustomKeyValues' ], // FIXME
				'wikiDbName' => $this->wg->DBname,
				'wikiDirectedAtChildren' => $adEngineVariables[ 'wgWikiDirectedAtChildren' ],
				'wikiLanguage' => $title->getPageLanguage()->getCode(),
				'wikiVertical' => $adEngineVariables[ 'cscoreCat' ],
			],
			'providers' => [
				'ebay' => $adEngineVariables[ 'wgAdDriverUseEbay' ],
				'sevenOneMedia' => $adEngineVariables[ 'wgAdDriverUseSevenOneMedia' ],
				'sevenOneMediaCombinedUrl' => isset( $adEngineVariables[ 'wgAdDriverSevenOneMediaCombinedUrl' ] ) ?
						$adEngineVariables[ 'wgAdDriverSevenOneMediaCombinedUrl' ] :
						null,
				'remnantGptMobile' => $this->wg->AdDriverEnableRemnantGptMobile,
			],
			'slots' => [
				'bottomLeaderboardImpressionCapping' => isset(
							$adEngineVariables[ 'wgAdDriverBottomLeaderboardImpressionCapping ']
						) ?
						$adEngineVariables[ 'wgAdDriverBottomLeaderboardImpressionCapping '] :
						null
			],
			'forceProviders' => [
				'directGpt' => $adEngineVariables[ 'wgAdDriverForceDirectGptAd' ],
				'liftium' => $adEngineVariables[ 'wgAdDriverForceLiftiumAd' ],
			]
		];
	}

	/**
	 * @desc Returns article comments in JSON format
	 *
	 * @throws NotFoundApiException
	 * @throws BadRequestApiException
	 * @throws InvalidParameterApiException
	 */
	public function getArticleComments() {
		$articleId = $this->getArticleIdFromRequest();

		$page = $this->request->getInt( self::PARAM_PAGE, self::DEFAULT_PAGE );

		$commentsResponse = $this->app->sendRequest( 'ArticleComments', 'WikiaMobileCommentsPage', [
			'articleID' => $articleId,
			'page' => $page,
			'format' => WikiaResponse::FORMAT_JSON
		] );

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
		$this->response->setVal( 'data', $wikiVariables );
		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
	}

	/**
	 * @throws NotFoundApiException
	 * @throws BadRequestApiException
	 */
	public function getArticle(){
		$articleId = $this->getArticleIdFromRequest();

		$this->response->setFormat( WikiaResponse::FORMAT_JSON );

		$this->response->setVal( 'data', [
			'details' => $this->getArticleDetails( $articleId ),
			'topContributors' => $this->getTopContributorsDetails(
					$this->getTopContributorsPerArticle( $articleId )
				),
			'article' => $this->getArticleJson( $articleId ),
			'relatedPages' => $this->getRelatedPages( $articleId ),
			'adsContext' => $this->getAdsContext( $articleId ),
			'basePath' => $this->wg->Server
		]);
	}
}
