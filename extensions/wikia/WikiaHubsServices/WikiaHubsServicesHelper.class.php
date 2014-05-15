<?php

class WikiaHubsServicesHelper
{
	private $corporateModel = null;

	/**
	 * Purge corporate main page varnish
	 *
	 * @param $lang
	 *
	 * @throws Exception
	 */
	public function purgeHomePageVarnish($lang) {
		$wikiId = $this->getCorporateModel()->getCorporateWikiIdByLang($lang);

		$mainPageTitle = $this->getGlobalMainPage($wikiId);
		$mainPageTitle->purgeSquid();
	}

	/**
	 * Get global title
	 *
	 * @param $mainPageName
	 * @param $wikiId
	 *
	 * @return GlobalTitle|null|Title
	 */
	protected static function getGlobalTitleFromText($mainPageName, $wikiId) {
			return GlobalTitle::newFromText($mainPageName, NS_MAIN, $wikiId);
	}

	protected function getGlobalMainPage($wikiId) {
		return GlobalTitle::newMainPage($wikiId);
	}

	public function purgeHubV3Varnish($wikiId) {
		$this->getGlobalMainPage($wikiId)->purgeSquid();
	}

	protected function getCorporateModel() {
		if(empty($this->corporateModel)) {
			$this->corporateModel = new WikiaCorporateModel();
		}

		return $this->corporateModel;
	}
}
