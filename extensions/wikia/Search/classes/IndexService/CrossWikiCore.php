<?php
/**
 * Class definition for Wikia\Search\IndexService\CrossWikiCore
 */
namespace Wikia\Search\IndexService;

use Wikia\Search\Utilities, WikiFactory, WikiService;
/**
 * This monolithic class is responsible for creating a cross-wiki document.
 * We could split this up into different services, but there isn't really a good reason to do that yet, 
 * since we're already reusing numerous services within this service.
 * @author relwell
 */
class CrossWikiCore extends AbstractWikiService
{
	/**
	 * Reusing the current wiki ID
	 * @var int
	 */
	protected $wikiId;
	
	/**
	 * Returns the field values for this wiki document
	 * (non-PHPdoc)
	 * @see \Wikia\Search\IndexService\AbstractService::execute()
	 */
	public function execute() {
		
		return array_merge(
				$this->getWikiBasics(),
				$this->getWikiStats(),
				$this->getWikiViews(),
				$this->getWam(),
				$this->getCategories(),
				$this->getVisualizationInfo(),
				$this->getTopArticles(),
				$this->getLicenseInformation()
				);
	}
	
	/**
	 * Retrieves basic metadata about the wiki, largely from wf
	 * @return array
	 */
	protected function getWikiBasics() {
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
		$response['domains_txt'] = $service->getDomainsForWikiId( $this->wikiId );
		return $response;
	}
	
	/**
	 * Retrieves the views on a weekly and monthly basis for this wiki
	 * @return array
	 */
	protected function getWikiViews() {
		$result = [];
		if ( $wvResponse = (new WikiViews)->getStubbedWikiResponse() ) {
			$result = [ 'views_weekly_i' => $wvResponse['contents']['wikiviews_weekly']['set'], 'views_monthly_i' => $wvResponse['contents']['wikiviews_monthly']['set'] ];
		}
		return $result;
	}
	
	/**
	 * Retrieves WAM score for this wiki
	 * @return array
	 */
	protected function getWam() {
		$response = [];
		if ( $wamResp = (new Wam)->getStubbedWikiResponse() ) {
			$response['wam_i'] = $wamResp['contents']['wam']['set'];
		}
		return $response;
	}
	
	/**
	 * Retrieves stats like number of videos, number of images, number of articles, etc.
	 * @return array
	 */
	protected function getWikiStats() {
		$service = $this->getService();
		$data = $service->getApiStatsForWiki();
		$response = [];
		if ( (! empty( $data['query'] ) ) && ( isset( $data['query']['statistics'] ) ) ) {
			foreach ( $data['query']['statistics'] as $key => $val ) {
				$response[$key . '_i'] = $val;
			}
		}
		$response['videos_i'] = (new WikiService)->getTotalVideos( $this->getWikiId() );
		return $response;
	}
	
	/**
	 * Retrieves description, headline, etc.
	 * @return array
	 */
	protected function getVisualizationInfo() {
		$response = [];
		$service = $this->getService();

		$message = $service->getSimpleMessage( 'wikiasearch2-crosswiki-description', array( $service->getGlobal( 'Sitename' ) ) );
		$ds = Utilities::field( 'description' );
		$ds = $ds == 'description' ? 'description_txt' : $ds;
		$response[$ds] = $message;
		$response['description_txt'] = $message;
		$vizInfo = $service->getVisualizationInfoForWikiId( $this->getWikiId() );
		if (! empty( $vizInfo ) ) {
			$response['image_s'] = $vizInfo['image'];
			if ( isset( $vizInfo['desc'] ) ) {
				$response[$ds] = $vizInfo['desc'];
				$response['description_txt'] = $vizInfo['desc'];
			}
			foreach ( $vizInfo['flags'] as $flag => $bool ) {
				$response[$flag.'_b'] = $bool ? 'true' : 'false';
			}
			$response['headline_txt'] = $vizInfo['headline'];
		}
		return $response;
	}
	
	/**
	 * Accesses the ArticlesApiController to store the top articles for this wiki
	 * @return array
	 */
	protected function getTopArticles() {
		$response = ['top_articles_txt' => []];
		try {
			$apiResponse = \F::app()->sendRequest( 'ArticlesApiController', 'getTop' )->getData();
			if ( $apiResponse ) {
				foreach ( $apiResponse['items'] as $item ) {
					$response['top_articles_txt'][] = $item['title'];
				}
			}
		} catch ( \Exception $e ) {}
		$ta = Utilities::field( 'top_articles' );
		$ta = $ta == 'top_articles' ? 'top_articles_txt' : $ta;
		$response[$ta] = $response['top_articles_txt'];
		return $response;
	}
	
	/**
	 * Retrieves all categories and top categories.
	 * @return array
	 */
	protected function getCategories() {
		$categories = [];
		$dbr = wfGetDB( DB_SLAVE );
		$sql = "SELECT cat_title FROM category WHERE cat_hidden = 0 ORDER BY cat_pages DESC";
		$query = $dbr->select(
				'category',
				'cat_title',
				'cat_hidden = 0',
				__METHOD__,
				[ 'LIMIT' => 50, 'ORDER BY' => 'cat_pages DESC' ]
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


	/**
	 * @return \LicensedWikisService
	 */
	protected function getLicensedWikisService(){

		return  new \LicensedWikisService();
	}

	/**
	 * Get license info this wiki
	 * @return array
	 */
	protected function getLicenseInformation( ) {

		$licensedWikiService = $this->getLicensedWikisService();
		return [
			"commercial_use_allowed_b" =>  $licensedWikiService->isCommercialUseAllowedById( $this->getWikiId() ) === true
		];
	}
	
	/**
	 * Lazy-loads wikiId
	 * @return number
	 */
	protected function getWikiId() {
		if ( $this->wikiId === null ) {
			$this->wikiId = $this->getService()->getWikiId();
		}
		return $this->wikiId;
	}
}
