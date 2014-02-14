<?php

class WikiaMobileTrendingArticlesService extends WikiaService {
	const MAX_TRENDING_ARTICLES = 6;
	const IMG_HEIGHT = 72;
	const IMG_WIDTH = 136;

	public function index(){
		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );

		//fetch Trending Articles
		try {
			$trendingArticlesFromApi = F::app()->sendRequest( 'ArticlesApi', 'getTop' )->getData();
		}
		catch ( Exception $e ) {
			//ToDo -> get rid of mock and make it a blank array
			$trendingArticlesFromApi = new myJsonMock();
		}

		//load data from response to template
		$current = 0;
		$trendingArticles = [];
		while ( $current < self::MAX_TRENDING_ARTICLES && !empty( $trendingArticlesFromApi->items[$current] ) ) {
			$currentItem = $trendingArticlesFromApi->items[$current];

			$trendingArticles[$current] = [
				'url' => $currentItem->url,
				'title' => $currentItem->title,
				'imgUrl' => $currentItem->thumbnail,
				'imgWidth' => self::IMG_WIDTH,
				'imgHeight' => self::IMG_HEIGHT
			];

			$current++;
		}

		$this->response->setVal( 'trendingArticles', $trendingArticles );
		$this->response->setVal( 'blankImg', $this->wg->BlankImgUrl );
		$this->response->setVal( 'trendingArticlesHeading', wfMessage( 'wikiamobile-trending-articles-heading' )->plain() );
	}
}
