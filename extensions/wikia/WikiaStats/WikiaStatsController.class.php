<?php
class WikiaStatsController extends WikiaController {

	const WIKIA_STATS_MEMC_VERSION = "0.1v";
	const WIKIA_STATS_CACHE_VALIDITY = 86400;

	/**
	 * get stats
	 * @responseParam integer visitors
	 * @responseParam integer mobilePercentage
	 * @responseParam integer editsDefault
	 * @responseParam integer totalPages
	 * @responseParam integer edits
	 * @responseParam integer communities
	 * @responseParam integer newCommunities
	 */

	public function getWikiaStats() {
		wfProfileIn(__METHOD__);

		$stats = WikiaDataAccess::cache(
			$this->getStatsMemcacheKey(),
			self::WIKIA_STATS_CACHE_VALIDITY,
			array(new WikiaStatsModel(), 'getWikiaStatsIncludingFallbacks')
		);

		foreach ($stats as $key => $value) {
			$this->$key = $value;
		}
		var_dump($this->wg->User->isAllowed('wikifactory'));
		wfProfileOut(__METHOD__);
	}

	public function saveWikiaStatsToWF($statsValues) {
		if ($this->wg->User->isAllowed('wikifactory')) {
			$wikiaStatsModel = new WikiaStatsModel();
			$wikiaStatsModel->setWikiaStatsInWF($this->getStatsMemcacheKey(), $statsValues);
		}
	}

	private function getStatsMemcacheKey() {
		$memKey = wfSharedMemcKey( 'wikiacorp', 'wikiastats', self::WIKIA_STATS_MEMC_VERSION);
		return $memKey;
	}
}
