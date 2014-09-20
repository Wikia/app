<?php
class SpotlightsABTestController extends WikiaController {
	const TYPE_TIPSY_MOCK = 1;
	const TYPE_OPENX_MOCK = 2;
	const TYPE_NLP_MOCK = 4;
	const TYPE_NLP_LDA_MOCK = 8;
	const TYPE_NLP_ALL_MOCK = 16;

	const MIN_SPOTLIGHTS_NUMBER = 3;

	const MEMCACHE_VER = '1.0';

	/**
	 * JSON response with recommended wikis
	 */
	public function getSpotlights() {
		$spotlights = [
			'status' => 0,
			'data' => []
		];
		$request = $this->wg->request;

		$cityId 	= $request->getInt( 'cityId', 0 );
		$vertical 	= $request->getVal( 'vertical', '' );

		if ( $cityId && !empty( $vertical ) ) {
			$type = $request->getVal( 'type', self::TYPE_TIPSY_MOCK );

			$spotlights = WikiaDataAccess::cache(
				$this->getMemcKey( $type, $vertical, $cityId ),
				86400 /* 24 hours */,
				function() use( $type, $vertical, $cityId ) {
					$spotlights = [
						'status' => 0,
						'data' => []
					];
					$spotlightsModel = new SpotlightsModel();

					switch( $type ) {
						case self::TYPE_OPENX_MOCK:
							$spotlights = $spotlightsModel->getOpenXSpotlights( $vertical );
							$spotlights['communityData'] = $spotlightsModel->getOpenXCommunityData();
							break;
						case self::TYPE_TIPSY_MOCK:
							$spotlights = $spotlightsModel->getTipsySpotlights( $cityId );
							break;
						case self::TYPE_NLP_MOCK:
							$spotlights = $spotlightsModel->getNLPTopicSpotlights();
							break;
						case self::TYPE_NLP_LDA_MOCK:
							$spotlights = $spotlightsModel->getNLPLDaSpotlights();
							break;
						case self::TYPE_NLP_ALL_MOCK:
							$spotlights['NLPTopic'] = $spotlightsModel->getNLPTopicSpotlights();
							$spotlights['NLPLDa'] = $spotlightsModel->getNLPLDaSpotlights();
							$spotlights['status'] = 1;
					}

					return $spotlights;
				}
			);
		}

		$this->setVal( 'spotlights', json_encode( $spotlights ) );
	}

	private function getMemcKey( $type, $vertical, $cityId ) {
		return wfSharedMemcKey(
			'spotlights',
			$type,
			$vertical,
			$cityId,
			self::MEMCACHE_VER
		);
	}

	static public function onWikiaSkinTopScripts( &$vars, &$scripts ) {
		global $wgNLPSpotlightIds, $wgNLPLDASpotlightIds, $wgCityId;
		$launchSpotlightABTest = false;

		if ( count( $wgNLPSpotlightIds) >= self::MIN_SPOTLIGHTS_NUMBER
			&& count( $wgNLPLDASpotlightIds) >= self::MIN_SPOTLIGHTS_NUMBER )
		{
			$launchSpotlightABTest = true;
		} else {
			$launchSpotlightABTest = false;
		}

		$vars['launchSpotlightABTest'] = $launchSpotlightABTest;

		return true;
	}
}
