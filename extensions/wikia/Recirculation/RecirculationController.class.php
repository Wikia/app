<?php

use Wikia\Search\TopWikiArticles;

class RecirculationController extends WikiaController {
	const DEFAULT_TEMPLATE_ENGINE = WikiaResponse::TEMPLATE_ENGINE_MUSTACHE;
	const ALLOWED_TYPES = [ 'popular', 'shares', 'recent_popular' ];
	const DEFAULT_TYPE = 'popular';

	public function init() {
		$type = $this->getVal( 'type' );
		if ( in_array( $type, self::ALLOWED_TYPES ) ) {
			$this->type = $type;
		} else {
			$this->type = self::DEFAULT_TYPE;
		}
	}

	public function discussionsAuthor() {
		$this->setVal( 'post', $this->getVal( 'post' ) );
		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_PHP );
	}

	public function discussions() {
		$showZeroState = false;
		$cityId = $this->request->getVal( 'cityId', null );
		$limit = $this->request->getVal( 'limit', 5 );
		$ignoreWgEnableRecirculationDiscussions =
			$this->request->getVal( 'ignoreWgEnableRecirculationDiscussions', false );
		$sortKey =
			$this->request->getVal( 'latest', false )
				? DiscussionsDataService::DISCUSSIONS_API_SORT_KEY_LATEST
				: DiscussionsDataService::DISCUSSIONS_API_SORT_KEY_TRENDING;

		if ( !empty( $cityId ) && !is_numeric( $cityId ) ) {
			throw new InvalidParameterApiException( 'cityId' );
		}

		if ( RecirculationHooks::canShowDiscussions( $cityId, $ignoreWgEnableRecirculationDiscussions ) ) {
			$discussionsDataService = new DiscussionsDataService( $cityId, $limit );
			$posts = $discussionsDataService->getData( 'posts', $sortKey )['posts'];

			$discussionsUrl = "$discussionsDataService->server/d/f";

			$postObjects = [];

			if (empty($posts)) {
				$showZeroState = true;
			}

			foreach ( $posts as $post ) {
				$postObjects[] = $post->jsonSerialize();
			}

			$this->response->setCachePolicy(WikiaResponse::CACHE_PUBLIC);
			$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_PHP );
			$this->response->setCacheValidity( WikiaResponse::CACHE_VERY_SHORT );
			$this->response->setData( [
				'title' => wfMessage( 'recirculation-discussion-title' )
					->inContentLanguage()
					->plain(),
				'linkText' => wfMessage( 'recirculation-discussion-link-text' )
					->inContentLanguage()
					->plain(),
				'discussionsUrl' => $discussionsUrl,
				'posts' => $postObjects,
				'showZeroState' => $showZeroState,
			] );

			return true;
		}

		return false;
	}

	public function footer() {
		global $wgSitename, $wgCityId, $wgLanguageCode;

		// Language code check is temporary to supress MCF for old discussions on non-en wikis;
		if ( !RecirculationHooks::isCorrectPageType() ) {
			$this->skipRendering();

			return;
		}

		$themeSettings = new ThemeSettings();
		$canShowDiscussions = RecirculationHooks::canShowDiscussions( $wgCityId, true );
		$topWikiArticles = $this->getTopWikiArticles();
		$numberOfWikiArticles = 8;
		$numberOfNSArticles = 9;
		// we do not show n&s articles on non-english wikis
		if ( $wgLanguageCode !== 'en' ) {
			$numberOfWikiArticles = 11;
			$numberOfNSArticles = 0;
		}

		if ( !$canShowDiscussions ) {
			$numberOfWikiArticles ++;
			if ( $wgLanguageCode === 'en' ) {
				$numberOfNSArticles ++;
			} else {
				$numberOfWikiArticles ++;
			}
		}
		if ( empty( $topWikiArticles ) ) {
			if ( $wgLanguageCode === 'en' ) {
				$numberOfNSArticles ++;
			} else {
				$numberOfWikiArticles ++;
			}
		}

		$this->response->setVal( 'communityHeaderBackground',
			$themeSettings->getCommunityHeaderBackgroundUrl() );
		$this->response->setVal( 'sitename', $wgSitename );
		$this->response->setVal( 'topWikiArticles', $topWikiArticles );
		$this->response->setVal( 'wikiRecommendations',
			WikiRecommendations::getRecommendations( $wgLanguageCode ) );
		$this->response->setVal( 'canShowDiscussions', $canShowDiscussions );
		$this->response->setVal( 'numberOfWikiArticles', $numberOfWikiArticles );
		$this->response->setVal( 'numberOfNSArticles', $numberOfNSArticles );

		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_PHP );
		if ( $wgLanguageCode !== 'en' ) {
			$this->response->getView()->setTemplatePath( __DIR__ .
			                                             '/templates/RecirculationController_FooterInternaltional.php' );
		}
	}

	private function getTopWikiArticles() {
		global $wgCityId;

		$topWikiArticles = TopWikiArticles::getArticlesWithCache( $wgCityId, false );
		// do not show itself
		$topWikiArticles = array_filter( $topWikiArticles, function ( $item ) {
			return $item['id'] !== RequestContext::getMain()->getTitle()->getArticleID();
		} );
		// show max 3 elements
		$topWikiArticles = array_slice( $topWikiArticles, 0, 3 );
		// add index to items to render it by mustache template
		$index = 1;
		foreach ( $topWikiArticles as &$wikiArticle ) {
			$wikiArticle['index'] = $index;
			$index ++;
		}

		return $topWikiArticles;
	}

	public function container( $params ) {
		$containerId = $this->request->getVal( 'containerId' );
		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_PHP );
		$this->response->setVal( 'containerId', $containerId );
	}
}
