<?php
/**
 * Class definition for \Wikia\Search\IndexService\Wam
 * @author relwell
 */
namespace Wikia\Search\IndexService;
use \DataMartService;
/**
 * Reponsible for retrieving WAM score for a given wiki
 * @author relwell
 */
class Wam extends AbstractWikiService
{
	/**
	 * Allows us to cache within a request
	 * @var array
	 */
	protected $result = array();
	
    /**
	 * Provides Wam score in an array keyed with 'wam'
	 * @return array
	 */
	public function execute() {
		wfProfileIn(__METHOD__);
		// note that we don't need the interface for this because it uses the data mart service, which is our own thing.
		$sharedDb = $this->interface->getGlobal( 'ExternalSharedDB' );
		if ( empty( $this->result ) && !empty( $sharedDb ) ) {
			$wamService = new WAMService();
			$wam = $wamService->getCurrentWamScoreForWiki( $this->interface->getWikiId() );
			$wam = $wam > 0 ? ceil( $wam ) : 1; //mapped here for computational cheapness
			$this->result = array( 'wam' => $wam );
		}
		wfProfileOut(__METHOD__);
		return $this->result;
	}
}