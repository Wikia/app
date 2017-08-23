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

	public function discussions() {
		global $wgContentLanguage;
		$cityId = $this->request->getVal( 'cityId', null );
		$sortKey =
			$this->request->getVal( 'latest', false )
				? DiscussionsDataService::DISCUSSIONS_API_SORT_KEY_LATEST
				: DiscussionsDataService::DISCUSSIONS_API_SORT_KEY_TRENDING;

		if ( !empty( $cityId ) && !is_numeric( $cityId ) ) {
			throw new InvalidParameterApiException( 'cityId' );
		}

		if ( RecirculationHooks::canShowDiscussions( $cityId ) ) {
			$discussionsDataService = new DiscussionsDataService( $cityId );
			$posts = $discussionsDataService->getData( 'posts', $sortKey )['posts'];

			if ( count( $posts ) > 0 ) {
				$discussionsUrl = "$discussionsDataService->server/d/f";

				$postObjects = [];

				foreach ( $posts as $post ) {
					$postObjects[] = $post->jsonSerialize();
				}

				if ($wgContentLanguage === 'en') {
					//This is temporary to render new discusions card on en wikis (templates in php and mustache have the same name)
					$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_PHP );
				}
				$this->response->setCacheValidity( WikiaResponse::CACHE_VERY_SHORT );
				$this->response->setData( [
					'title' => wfMessage( 'recirculation-discussion-title' )->plain(),
					'linkText' => wfMessage( 'recirculation-discussion-link-text' )->plain(),
					'discussionsUrl' => $discussionsUrl,
					'posts' => $postObjects,
				] );

				return true;
			}
		}

		return false;
	}

	public function footer() {
		global $wgSitename, $wgCityId, $wgContentLanguage;

		if ($wgContentLanguage !== 'en') {
			//This is temporary to supress MCF for old discussions on non-en wikis;
			$this->response->setBody('');
		}
		$themeSettings = new ThemeSettings();
		$discussionsEnabled = WikiFactory::getVarValueByName( 'wgEnableDiscussions', $wgCityId );
		$topWikiArticles = $this->getTopWikiArticles();
		$numberOfWikiArticles = 8;
		$numberOfNSArticles = 9;
		if ( !$discussionsEnabled ) {
			$numberOfWikiArticles ++;
			$numberOfNSArticles ++;
		}
		if ( empty( $topWikiArticles ) ) {
			$numberOfNSArticles ++;
		}

		$this->response->setVal( 'communityHeaderBackground',
			$themeSettings->getCommunityHeaderBackgroundUrl() );
		$this->response->setVal( 'sitename', $wgSitename );
		$this->response->setVal( 'topWikiArticles', $topWikiArticles );
		$this->response->setVal( 'wikiRecommendations', $this->getWikiRecommendations() );
		$this->response->setVal( 'discussionsEnabled', $discussionsEnabled );
		$this->response->setVal( 'numberOfWikiArticles', $numberOfWikiArticles );
		$this->response->setVal( 'numberOfNSArticles', $numberOfNSArticles );

		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_PHP );
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

	private function getWikiRecommendations() {
		global $wgLanguageCode;

		return WikiRecommendations::getRecommendations( $wgLanguageCode );
	}

	public function container( $params ) {
		$containerId = $this->request->getVal( 'containerId' );
		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_PHP );
		$this->response->setVal( 'containerId', $containerId );
	}
}
