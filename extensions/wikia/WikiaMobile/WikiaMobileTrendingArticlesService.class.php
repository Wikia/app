<?php

/**
 * Class WikiaMobileTrendingArticlesService
 *
 * Responsible for displaying trending articles in a page
 */
class WikiaMobileTrendingArticlesService extends WikiaService {
	const MAX_TRENDING_ARTICLES = 6;
	const IMG_HEIGHT = 72;
	const IMG_WIDTH = 136;

	/**
	 * Gets data from ArticlesApi and renders it
	 */
	public function index(){
		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );

		//fetch Trending Articles
		try {
			$trendingArticlesData = $this->app->sendRequest( 'ArticlesApi', 'getTop' )->getData();
		}
		catch ( Exception $e ) {}

		if ( !empty( $trendingArticlesData ) ) {
			var_dump($trendingArticlesData->items);
			$items = array_slice( $trendingArticlesData->items, 0, self::MAX_TRENDING_ARTICLES );
			//load data from response to template
			$trendingArticles = [];
			var_dump($items);
			foreach( $items as $item ) {
				$img = $this->app->sendRequest( 'ImageServing', 'getImages', [
					'ids' => [ $item->id ],
					'height' => self::IMG_HEIGHT,
					'width' => self::IMG_WIDTH,
					'count' => 1
				] )->getVal( 'result' );
var_dump($item);
				$thumbnail = $img[$item->id][0]['url'];

				if ( empty( $thumbnail ) ) {
					$thumbnail = false;
				}

				$trendingArticles[] = [
					'url' => $item->url,
					'title' => $item->title,
					'imgUrl' => $thumbnail,
					'width' => self::IMG_WIDTH,
					'height' => self::IMG_HEIGHT
				];
			}
var_dump($trendingArticles);exit();
			$this->response->setVal( 'trendingArticles', $trendingArticles );
			$this->response->setVal( 'blankImg', $this->wg->BlankImgUrl );
			$this->response->setVal( 'trendingArticlesHeading', wfMessage( 'wikiamobile-trending-articles-heading' )->plain() );
		} else {
			$this->skipRendering();
		}
	}
}
