<?php
/**
 * Class definition for \Wikia\Search\IndexService\Wam
 *
 * @author relwell
 */
namespace Wikia\Search\IndexService;

use \WAMService;

/**
 * Responsible for retrieving WAM score for a given wiki
 *
 * @author relwell
 * @package Search
 * @subpackage IndexService
 */
class Wam extends AbstractWikiService {
	/**
	 * Allows us to cache within a request
	 *
	 * @var array
	 */
	protected $result = [];

	/**
	 * Provides Wam score in an array keyed with 'wam'
	 *
	 * @return array
	 */
	public function execute() {
		if ( empty( $this->result ) && $this->getService()->isOnDbCluster() ) {
			$wamService = new WAMService();
			$wam = $wamService->getCurrentWamScoreForWiki( $this->service->getWikiId() );
			$wam = $wam > 0 ? ceil( $wam ) : 1; //mapped here for computational cheapness
			$this->result = [ 'wam' => $wam ];
		}

		return $this->result;
	}
}
