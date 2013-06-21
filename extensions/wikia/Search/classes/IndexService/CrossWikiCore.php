<?php
/**
 * Class definition for Wikia\Search\IndexService\CrossWikiCore
 */
namespace Wikia\Search\IndexService;

use Wikia\Search\Utilities, WikiFactory, WikiService;

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
		$sn = Utilities::field( 'sitename' );
		$langSn = $sn == 'sitename' ? 'sitename_txt' : $sn;
		$response['lang_s'] = $service->getLanguageCode();
		$response['hub_s'] = $service->getHubForWikiId( $this->wikiId );
		$response['created_dt'] = str_replace( ' ', 'T', $wiki->city_created ) . 'Z';
		$response['touched_dt'] = str_replace( ' ', 'T', $wiki->city_last_timestamp ) . 'Z';
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
	  $result = [];
	  if ( $wvResponse = (new WikiViews)->getStubbedWikiResponse() ) {
		$result = [ 'views_weekly_i' => $wvResponse['contents']['wikiviews_weekly']['set'], 'views_monthly_i' => $wvResponse['contents']['wikiviews_monthly']['set'] ];
	  }
	  return $result;
	}
	
	protected function getWam() {
	  $response = [];
	  if ( $wamResp = (new Wam)->getStubbedWikiResponse() ) {
	    $response['wam_i'] = $wamResp['contents']['wam']['set'];
	  }
	  return $response;
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
			$ds = Utilities::field( 'description' );
			$ds = $ds == 'description' ? 'description_txt' : $ds;
			$response[$ds] = $description;
			foreach ( $vizInfo['flags'] as $flag => $bool ) {
				$response[$flag.'_b'] = $bool ? 'true' : 'false';
			}
			$response['headline_txt'] = $vizInfo['headline'];
		}
		return $response;
	}
	
	protected function getTopArticles() {
		$response = ['top_articles_txt' => []];
		$apiResponse = \F::app()->sendRequest( 'ArticlesApiController', 'getTop' )->getData();
		if ( $apiResponse ) {
			foreach ( $apiResponse['items'] as $item ) {
				$response['top_articles_txt'][] = $item['title'];
			}
		}
		$ta = Utilities::field( 'top_articles' );
		$ta = $ta == 'top_articles' ? 'top_articles_txt' : $ta;
		$response[$ta] = $response['top_articles_txt'];
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
		$cats = Utilities::field( 'categories' );
		$cats = $cats == 'categories' ? 'categories_txt' : $cats;
		$topsCats = Utilities::field( 'top_categories' );
		$topsCats = $topsCats == 'top_categories' ? 'top_categories_txt' : $topsCats;
		return array(
				 $cats => $categories,
				'categories_txt' => $categories,
				'top_categories_txt' => $topCategories,
				 $topsCats => $topCategories 
				);
	}
}