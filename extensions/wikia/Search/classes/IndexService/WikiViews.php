<?php
/**
 * Class definition for \Wikia\Search\IndexService\WikiViews 
 * @author relwell
 */
namespace Wikia\Search\IndexService;
/**
 * Retrieves wikiviews from the data mart
 * @author relwell
 * @package Search
 * @subpackage IndexService
 */
class WikiViews extends AbstractWikiService
{
	/**
	 * Time to cache the wikipages value, used in indexing, in seconds -- 7 days.
	 * @var int
	 */
	const WIKIPAGES_CACHE_TTL	= 604800;
	
	/**
	 * Cached during request
	 * @var array
	 */
	protected $result;
	
    /**
	 * Provided an Article, queries the database for weekly and monthly pageviews.
	 * @return array 
	 */
	public function execute() {
		wfProfileIn(__METHOD__);
		$service = $this->getService();
		if ( $this->result !== null || !$service->isOnDbCluster() ) {
			wfProfileOut(__METHOD__);
			return $this->result;
		}
		
		$stringKey = 'WikiaSearchPageViews';
		$result = $this->service->getCacheResultFromString( $stringKey );

		if ( ( $result !== false ) && ( $result->weekly > 0 || $result->monthly > 0 ) ) {
			wfProfileOut(__METHOD__);
			$this->result = array(
					'wikiviews_weekly' => (int) $result->weekly,
					'wikiviews_monthly' => (int) $result->monthly, 
			);
			return $this->result;
		}

		$row = new \stdClass();	
		$row->weekly = 0;
		$row->monthly = 0;
		$datamart = new \DataMartService();
		
		$startDate = date( 'Y-m-d', strtotime('-1 week') );
		$endDate = date( 'Y-m-01', strtotime('now') );	
		$pageviews_weekly = $datamart->getPageviewsWeekly( $startDate, $endDate, $this->service->getWikiId() );
		if (! empty( $pageviews_weekly ) ) {
			foreach ( $pageviews_weekly as $pview ) {
				$row->weekly += $pview;
			}
		}
			
		$startDate = date( 'Y-m-01', strtotime('-1 month') );
		$pageviews_monthly = $datamart->getPageviewsMonthly( $startDate, $endDate, $this->service->getWikiId() );
		if (! empty( $pageviews_monthly ) ) {
			foreach ( $pageviews_monthly as $pview ) {
				$row->monthly += $pview;
			}
		}

		$wrapper = new \Wikia\Util\GlobalStateWrapper(array('wgAllowMemcacheWrites' => true));
		$wrapper->wrap(function () use ($stringKey, $row) {
			$this->service->setCacheFromStringKey( $stringKey, $row, self::WIKIPAGES_CACHE_TTL );
		});

		$this->result = array(
				'wikiviews_weekly' => (int) $row->weekly,
				'wikiviews_monthly' => (int) $row->monthly, 
		);
		wfProfileOut(__METHOD__);
		return $this->result;
	}
}