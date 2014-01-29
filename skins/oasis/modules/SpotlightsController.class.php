<?php
class SpotlightsController extends WikiaController {
	const TYPE_TIPSY = 1;
	const TYPE_OPENX = 2;
	const MEMCACHE_VER = '1.0';

	public function index() {
	}

	/**
	 * JSON response with recommended wikis
	 */
	public function getSpotlights() {
		$spotlights = [];

		$cityId 	= $this->wg->request->getInt('cityId', 0);
		$vertical 	= $this->wg->request->getVal('vertical', '');
		$type		= $this->wg->request->getVal('type', self::TYPE_TIPSY);

		if ($cityId && !empty($vertical)) {
			$spotlights = WikiaDataAccess::cache(
				$this->getMemcKey($type, $vertical, $cityId),
				86400 /* 24 hours */,
				function() use($type, $vertical, $cityId) {
					$spotlights = [];
					$spotlightsModel = new SpotlightsModel();

					switch($type) {
						case self::TYPE_OPENX: $spotlights = $spotlightsModel->getOpenXSpotlights($vertical); break;
						case self::TYPE_TIPSY: $spotlights = $spotlightsModel->getTipsySpotlights($cityId); break;
					}

					return $spotlights;
				}
			);
		}

		$this->setVal('spotlights', json_encode($spotlights));
	}

	private function getMemcKey($type, $vertical, $cityId) {
		return wfSharedMemcKey(
			'spotlights',
			$type,
			$vertical,
			$cityId,
			self::MEMCACHE_VER
		);
	}
}
