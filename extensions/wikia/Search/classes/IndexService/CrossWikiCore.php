<?php
/**
 * Class definition for Wikia\Search\IndexService\CrossWikiCore
 */
namespace Wikia\Search\IndexService;

use Wikia\Search\Utilities, WikiFactory, WikiService, ApiService;

class CrossWikiCore extends AbstractWikiService
{
	protected $wikId;
	
	public function execute() {
		$service = $this->getService();
		$response = [];
		$this->wikiId = $service->getWikiId();
		$wiki = WikiFactory::getWikiById( $this->wikiId );
		$sitename = $service->getGlobal( 'Sitename' );
		$response['id'] = $this->wikiId;
		$response['sitename_txt'] = $sitename;
		$response[ Utilities::field( 'sitename' ) ] = $sitename;
		$response['lang_s'] = $service->getLanguageCode();
		$response['hub_s'] = $service->getHubForWikiId( $this->wikiId );
		$response['created_dt'] = $wiki->city_created;
		$response['touched_dt'] = $wiki->city_last_timestamp;
		$response['url'] = $wiki->city_url;
		$response['dbname_s'] = $wiki->city_dbname;
		$response['hostname_s'] = $service->getHostName();
		$response['hostname_txt'] = $response['hostname_s'];
		return array_merge(
				$response,
				$this->getWikiStats(),
				$this->getWikiViews(),
				$this->getWam(),
				$this->getCategories(),
				$this->getVisualizationInfo(),
				$this->getTopArticles()
				);
	}
	
	protected function getWikiViews() {
		$wvResponse = (new WikiViews)->getStubbedWikiResponse();
		return [ 'views_weekly_i' => $wvResponse['contents']['wikiviews_weekly'], 'views_monthly_i' => $wvResponse['contents']['wikiviews_monthly'] ];
	}
	
	protected function getWam() {
		$wamResp = (new Wam)->getStubbedWikiResponse();
		return $wamResp['contents'];
	}
	
	protected function getWikiStats() {
		$service = $this->getService();
		$data = $service->getApiStatsForWiki();
		$response = [];
		foreach ( $data['query']['statistics'] as $key => $val ) {
			$response[$key . '_i'] = $val;
		}
		$response['videos_i'] = (new WikiService)->getTotalVideos( $this->wikiId );
		return $response;
	}
	
	protected function getVisualizationInfo() {
		$response = [];
		$service = $this->getService();
		$vizInfo = $service->getVisualizationInfoForWikiId( $this->wikiId );
		if (! empty( $vizInfo ) ) {
			$response['image_s'] = $vizInfo['image'];
			if ( isset( $vizInfo['desc'] ) ) {
				$description = $vizInfo['desc'];
			} else {
				$description = $service->getSimpleMessage( 'wikiasearch2-crosswiki-description', array( $service->getGlobal( 'Sitename' ) ) );
			}
			$response['description_txt'] = $description;
			$response[ Utilities::field( 'description' ) ] = $description;
			foreach ( $vizInfo['flags'] as $flag => $bool ) {
				$response[$flag.'_b'] = $bool ? 'true' : 'false';
			}
			$response['headline_txt'] = $vizInfo['headline'];
		}
		return $response;
	}
	
	protected function getTopArticles() {
		$response = ['top_articles_txt' => []];
		$apiResponse = ApiService::call( [ 'controller' => 'ArticlesApiController', 'method' => 'getTop' ] );
		if ( $apiResponse ) {
			foreach ( $apiResponse['items'] as $item ) {
				$response['top_articles_txt'][] = $item['title'];
			}
		}
		$response[Utilities::field( 'top_articles' )] = $response['top_articles_txt'];
		return $response;
	}
	
	protected function getCategories() {
		$categories = [];
		$dbr = wfGetDB( DB_SLAVE );
		$sql = "SELECT cat_title FROM category WHERE cat_hidden = 0 ORDER BY cat_pages DESC";
		$query = $dbr->select(
				'category',
				'cat_title',
				'cat_hidden = 0',
				__METHOD__,
				[ 'ORDER BY' => 'cat_pages DESC' ]
				);
		while ( $result = $dbr->fetchObject( $query ) ) {
			$categories[] = str_replace( '_', ' ', $result->cat_title );
		}
		$topCategories = array_slice( $categories, 0, 20 );
		return array(
				Utilities::field( 'categories' ) => $categories,
				'categories_txt' => $categories,
				'top_categories_txt' => $topCategories,
				Utilities::field( 'top_categories' ) => $topCategories 
				);
	}
}