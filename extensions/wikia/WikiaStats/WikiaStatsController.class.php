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
		wfProfileIn(__METHOD__);

		$statsFromWF = $this->getWikiaStatsFromWF();
		$stats = WikiaDataAccess::cache(
			$this->getStatsMemcacheKey(),
			self::WIKIA_STATS_CACHE_VALIDITY,
			function() use ($statsFromWF) {
				$wikiaStatsModel = new WikiaStatsModel();
				return $wikiaStatsModel->getWikiaStatsIncludingFallbacks($statsFromWF);
			}
		);

		foreach ($stats as $key => $value) {
			$this->$key = $value;
		}

		wfProfileOut(__METHOD__);
	}

	public function getWikiaStatsFromWF() {
		return WikiFactory::getVarValueByName('wgCorpMainPageStats', Wikia::COMMUNITY_WIKI_ID);
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
