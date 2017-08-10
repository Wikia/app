<?php

use Wikia\Search\TopWikiArticles;

class RecirculationController extends WikiaController {
	const DEFAULT_TEMPLATE_ENGINE = WikiaResponse::TEMPLATE_ENGINE_MUSTACHE;
	const ALLOWED_TYPES = ['popular', 'shares', 'recent_popular'];
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
		$cityId = $this->request->getVal( 'cityId', null );

		if ( !empty( $cityId ) && !is_numeric( $cityId ) ) {
			throw new InvalidParameterApiException( 'cityId' );
		}

		if ( RecirculationHooks::canShowDiscussions( $cityId ) ) {
			$discussionsDataService = new DiscussionsDataService( $cityId );
			$posts = $discussionsDataService->getData( 'posts' )['posts'];

			if ( count( $posts ) > 0 ) {
				$discussionsUrl = "$discussionsDataService->server/d/f";

				$postObjects = [];

				foreach ( $posts as $post ) {
					$postObjects[] = $post->jsonSerialize();
				}

				$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_PHP );
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
		global $wgSitename;

		$themeSettings = new ThemeSettings();
		$this->response->setVal( 'communityHeaderBackground',
			$themeSettings->getCommunityHeaderBackgroundUrl() );
		$this->response->setVal( 'sitename', $wgSitename );
		$this->response->setVal( 'topWikiArticles', $this->getTopWikiArticles() );
		// TODO if topWikiArticles is empty show one more N&S article card instead of More from wiki card
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
			$index++;
		}

		return $topWikiArticles;
	}

	public function container( $params ) {
		$containerId = $this->request->getVal( 'containerId' );
		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_PHP );
		$this->response->setVal( 'containerId', $containerId );
	}
}
