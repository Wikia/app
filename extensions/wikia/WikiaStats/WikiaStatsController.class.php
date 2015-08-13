<?php
class WikiaStatsController extends WikiaController {

	const WIKIA_STATS_MEMC_VERSION = "1";
	const WIKIA_STATS_CACHE_VALIDITY = 86400;

	/**
	 * get stats
	 * @responseParam integer visitors
	 * @responseParam integer mobilePercentage
	 * @responseParam integer totalPages
	 * @responseParam integer edits
	 * @responseParam integer communities
	 * @responseParam integer newCommunities
	 */
	public function getWikiaStats() {
		wfProfileIn( __METHOD__ );

		$statsFromWF = WikiaStatsModel::getWikiaStatsFromWF();
		$stats = WikiaDataAccess::cache(
			$this->getStatsMemcacheKey(),
			self::WIKIA_STATS_CACHE_VALIDITY,
			function() use ( $statsFromWF ) {
				$wikiaStatsModel = new WikiaStatsModel();
				return $wikiaStatsModel->getWikiaStatsIncludingFallbacks( $statsFromWF );
			}
		);

		foreach ( $stats as $key => $value ) {
			$this->$key = $value;
		}

		wfProfileOut( __METHOD__ );
	}

	/**
	 * Return number of communities
	 * and number of communities with curated content wg variable set to not falsy value.
	 *
	 * @responseParam integer totalCommunities
	 * @responseParam integer communitiesWithCuratedContent
	 */
	public function getCuratedContentStats() {
		$data = $this->sendSelfRequest( 'getWikiaStats' )->getData();
		$this->getResponse()->setFormat( WikiaResponse::FORMAT_JSON );
		$communitiesWithCuratedContent = WikiFactory::getCountOfWikisWithVar(
			CuratedContentController::CURATED_CONTENT_WG_VAR_ID_PROD, "full", "LIKE", null, "true"
		);

		$this->setVal( 'item', intval( $communitiesWithCuratedContent ) );
		$this->setVal( 'min', ['value' => 0] );
		$this->setVal( 'max', ['value' => $data['communities']] );
	}

	public function getWikiaStatsFromWF() {
		$statsFromWF = WikiaStatsModel::getWikiaStatsFromWF();
		foreach ( $statsFromWF as $key => $value ) {
			$this->$key = $value;
		}
	}

	public function saveWikiaStatsInWF() {
		$statsValues = $this->request->getVal( 'statsValues' );
		if ( $this->wg->User->isAllowed( 'wikifactory' ) ) {
			WikiaDataAccess::cachePurge( $this->getStatsMemcacheKey() );
			WikiaStatsModel::setWikiaStatsInWF( $statsValues );
		} else {
			throw new PermissionsException( 'wikifactory' );
		}
	}

	private function getStatsMemcacheKey() {
		return wfSharedMemcKey( 'wikiacorp', 'wikiastats', self::WIKIA_STATS_MEMC_VERSION );
	}
}
