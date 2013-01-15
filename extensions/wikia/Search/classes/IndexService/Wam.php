<?php
/**
 * Class definition for \Wikia\Search\IndexService\Wam
 * @author relwell
 */
namespace Wikia\Search\IndexService;
/**
 * Reponsible for retrieving WAM score for a given wiki
 * @author relwell
 */
class Wam extends AbstractService
{
	/**
	 * Allows us to cache within a request
	 * @var array
	 */
	protected $result;
	
    /**
	 * Provides Wam score in an array keyed with 'wam'
	 * @return array
	 */
	public function execute() {
		wfProfileIn(__METHOD__);
		if ( $this->result === null ) {
			$datamart = new \DataMartService();
			$wam = $datamart->getCurrentWamScoreForWiki( $this->wg->CityId );
			$wam = $wam > 0 ? ceil( $wam ) : 1; //mapped here for computational cheapness
			$this->result = array( 'wam' => $wam );
		}
		wfProfileOut(__METHOD__);
		return $this->result;
	}
}