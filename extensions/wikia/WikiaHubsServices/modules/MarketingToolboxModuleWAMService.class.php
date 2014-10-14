<?php

class MarketingToolboxModuleWAMService extends MarketingToolboxModuleNonEditableService {
	const WAM_SCORE_CHANGE_UP = 1;
	const WAM_SCORE_NO_CHANGE = 0;
	const WAM_SCORE_CHANGE_DOWN = -1;
	const WAM_SCORE_DECIMALS = 2;
	
	/**
	 * @var MarketingToolboxWAMModel
	 */
	protected $model;
	
	const MODULE_ID = 10;

	/**
	 * @param Array $params
	 * @return array
	 */
	protected function prepareParameters($params) {
		$params['limit'] = $this->getModel()->getWamLimitForHubPage();

		if( !empty($params['ts']) && $params['ts'] >= strtotime(date('d-m-Y'))) {
			$params['ts'] = null;
		}

		if( empty($params['image_height']) ) {
			$params['image_height'] = $this->getModel()->getImageHeight();
		}

		if( empty($params['image_width']) ) {
			$params['image_width'] = $this->getModel()->getImageWidth();
		}

		if( empty($this->verticalId) ) {
			$this->verticalId = WikiFactoryHub::getInstance()->getCategoryId($this->cityId);
		}

		if( empty($this->langCode) ) {
			$this->langCode = $this->app->wg->ContLang->getCode();
		}

		return parent::prepareParameters([
			'wam_day' => $params['ts'],
			'vertical_id' => HubService::getCanonicalCategoryId($this->verticalId),
			'wiki_lang' => $this->langCode,
			'exclude_blacklist' => true,
			'fetch_admins' => true,
			'fetch_wiki_images' => true,
			'limit' => $params['limit'],
			'sort_column' => 'wam_index',
			'sort_direction' => 'DESC',
			'wiki_image_height' => $params['image_height'],
			'wiki_image_width' => $params['image_width'],
		]);
	}

	public function loadData($model, $params) {
		$hubParams = $this->getHubsParams();
		$lastTimestamp = $model->getLastPublishedTimestamp(
									$hubParams,
									$params['ts']
						);

		$params = $this->prepareParameters($params);
		
		if( !empty($this->app->wg->DevelEnvironment) ) {
			$apiResponse = ['vertical_id' => 2, 'wam_index' => [
					304 => [ //mocket data - need for testing WAM on devbox
						'wiki_id' => '304',
						'wam'=> '99.9554',
						'wam_rank' => '1',
						'peak_wam_rank' => '1',
						'peak_hub_wam_rank' => '1',
						'top_1k_days' => '431',
						'top_1k_weeks' => '62',
						'first_peak' => '2012-01-03',
						'last_peak' => '2013-03-06',
						'title' => 'RuneScape Wiki',
						'url' => 'runescape.wikia.com',
						'hub_id' => '2',
						'wam_change' => '0.0045',
						'admins' => [],
						'wiki_image' => ImagesService::overrideThumbnailFormat('http://images1.wikia.nocookie.net/__cb20121004184329/wikiaglobal/images/thumb/8/8b/Wikia-Visualization-Main%2Crunescape.png/150px-Wikia-Visualization-Main%2Crunescape.png', ImagesService::EXT_JPG),
					],
					14764 => [
						'wiki_id' => '14764',
						'wam'=> '99.8767',
						'wam_rank' => '2',
						'hub_wam_rank' => '2',
						'peak_wam_rank' => '1',
						'peak_hub_wam_rank' => '1',
						'top_1k_days' => '431',
						'top_1k_weeks' => '62',
						'first_peak' => '2012-04-21',
						'last_peak' => '2013-02-18',
						'title' => 'League of Legends Wiki',
						'url' => 'leagueoflegends.wikia.com',
						'hub_id' => '2',
						'wam_change' => '0.0039',
						'admins' => [],
						'wiki_image' => ImagesService::overrideThumbnailFormat('http://images4.wikia.nocookie.net/__cb20120828154214/wikiaglobal/images/thumb/e/ea/Wikia-Visualization-Main%2Cleagueoflegends.png/150px-Wikia-Visualization-Main%2Cleagueoflegends.png.jpeg', ImagesService::EXT_JPG),
					],
					1706 => [
						'wiki_id' => '1706',
						'wam'=> '99.7942',
						'wam_rank' => '4',
						'hub_wam_rank' => '3',
						'peak_wam_rank' => '1',
						'peak_hub_wam_rank' => '1',
						'top_1k_days' => '431',
						'top_1k_weeks' => '62',
						'first_peak' => '2012-01-01',
						'last_peak' => '2013-02-13',
						'title' => 'Elder Scrolls',
						'url' => 'elderscrolls.wikia.com',
						'hub_id' => '2',
						'wam_change' => '-0.0016',
						'admins' => [],
						'wiki_image' => ImagesService::overrideThumbnailFormat('http://images1.wikia.nocookie.net/__cb20121214183339/wikiaglobal/images/thumb/d/d4/Wikia-Visualization-Main%2Celderscrolls.png/150px-Wikia-Visualization-Main%2Celderscrolls.png', ImagesService::EXT_JPG),
					],
					3035 => [
						'wiki_id' => '3035',
						'wam'=> '99.6520',
						'wam_rank' => '9',
						'hub_wam_rank' => '4',
						'peak_wam_rank' => '4',
						'peak_hub_wam_rank' => '3',
						'top_1k_days' => '431',
						'top_1k_weeks' => '62',
						'first_peak' => '2012-01-02',
						'last_peak' => '2013-09-11',
						'title' => 'Fallout Wiki',
						'url' => 'fallout.wikia.com',
						'hub_id' => '2',
						'wam_change' => '0.0091',
						'admins' => [],
						'wiki_image' => null,
					],
				113 => [
						'wiki_id' => '113',
						'wam'=> '99.5000',
						'wam_rank' => '17',
						'hub_wam_rank' => '5',
						'peak_wam_rank' => '2',
						'peak_hub_wam_rank' => '2',
						'top_1k_days' => '431',
						'top_1k_weeks' => '62',
						'first_peak' => '2012-05-04',
						'last_peak' => '2013-05-07',
						'title' => 'Memmory Alpha Wiki',
						'url' => 'en.memory-alpha.org',
						'hub_id' => '2',
						'wam_change' => '-0.1000',
						'admins' => [],
						'wiki_image' => null,
					],
			]];

			$data = [
				'vertical_id' => $this->verticalId,
				'api_response' => $apiResponse,
			];

			$structuredData = $this->getStructuredData($data);

		} else {
			$structuredData = WikiaDataAccess::cache(
				$this->getMemcacheKey(
					$lastTimestamp,
					$this->skinName
				),
				6 * 60 * 60,
				function () use( $model, $params ) {
					return $this->loadStructuredData($model, $params);
				}
			);
		}

		if ( $this->getShouldFilterCommercialData() ) {
			$structuredData = $this->filterCommercialData( $structuredData );
		}

		return $structuredData;
	}

	protected function loadStructuredData($model, $params) {
		try {

			$apiResponse = $this->app->sendRequest('WAMApi', 'getWAMIndex', $params)->getData();

		} catch (WikiaHttpException $e) {

			$logMsg = 'Message: ' . $e->getLogMessage() . ' Details: ' . $e->getDetails();
			Wikia::log(__METHOD__, false, $logMsg );
			Wikia::logBacktrace(__METHOD__);

		}

		$data = [
			'vertical_id' => $params['vertical_id'],
			'api_response' => $apiResponse,
		];

		return $this->getStructuredData($data);
	}

	public function getWamPageUrl () {
		if ( $this->getHubsVersion() == MarketingToolboxV3Model::VERSION ) {
			try {
				$wikiId = (new WikiaCorporateModel())->getCorporateWikiIdByLang( $this->langCode );
			} catch ( Exception $e ) {
				$wikiId = WikiService::WIKIAGLOBAL_CITY_ID;
			}

			$wamPageConfig = WikiFactory::getVarByName( 'wgWAMPageConfig', $wikiId )->cv_value;
			$pageName = ( !empty( $wamPageConfig['pageName'] ) ) ? $wamPageConfig['pageName'] : 'WAM';

			$url = GlobalTitle::newFromText( $pageName, NS_MAIN, $wikiId )->getFullURL();
		} else {
			$devboxUrl = ( $this->app->wg->DevelEnvironment == true ) ? '/wiki' : '';
			$url = !empty( $this->app->wg->WAMPageConfig['pageName'] ) ? $devboxUrl.'/'.$this->app->wg->WAMPageConfig['pageName'] : '#';
		}

		return $url;
	}

	public function getStructuredData($data) {
		$hubModel = $this->getWikiaHubsModel();

		$realVerticalId = HubService::getCanonicalCategoryId($data['vertical_id']);
		$structuredData = [
			'wamPageUrl' => $this->getWamPageUrl(),
			'verticalName' => $hubModel->getVerticalName($realVerticalId),
			'canonicalVerticalName' => str_replace(' ', '', $hubModel->getCanonicalVerticalName($realVerticalId)),
			'ranking' => []
		];

		$rank = 1;
		$wamIndex = $data['api_response']['wam_index'];
		foreach($wamIndex as $wiki) {
			$wamScore = $wiki['wam'];
			$wamChange = $wiki['wam_change'];
			$wamPrevScore = $wamScore - $wamChange;

			$structuredData['ranking'][] = [
				'rank' => $rank,
				'wamScore' => round($wamScore, self::WAM_SCORE_DECIMALS),
				'imageUrl' => $wiki['wiki_image'],
				'wikiName' => $wiki['title'],
				'wikiUrl' => $this->addProtocolToLink($wiki['url']),
				'change' => $this->getWamWikiChange($wamScore, $wamPrevScore),
			];
			$rank++;
		}

		return $structuredData;
	}

	protected function getWamWikiChange($wamScore, $wamPrevScore) {
		$result = self::WAM_SCORE_NO_CHANGE;
		$wamScore = round($wamScore, self::WAM_SCORE_DECIMALS);
		$wamPrevScore = round($wamPrevScore, self::WAM_SCORE_DECIMALS);
		$wamChange = $wamScore - $wamPrevScore;

		if( $wamChange > 0 ) {
			$result = self::WAM_SCORE_CHANGE_UP;
		} else if( $wamChange < 0 ) {
			$result = self::WAM_SCORE_CHANGE_DOWN;
		}

		return $result;
	}

	public function getWikiaHubsModel() {
		return new WikiaHubsModel();
	}

	public function render($data) {
		$data['imagesHeight'] = $this->getModel()->getImageHeight();
		$data['imagesWidth'] = $this->getModel()->getImageWidth();
		$data['scoreChangeMap'] = [self::WAM_SCORE_CHANGE_DOWN => 'down', self::WAM_SCORE_NO_CHANGE => 'nochange', self::WAM_SCORE_CHANGE_UP => 'up'];

		return parent::render($data);
	}
	
	public function getModel() {
		if( !$this->model ) {
			$this->model = new MarketingToolboxWAMModel();
		}
		
		return $this->model;
	}

	/**
	 * Remove non-commercial wikis.
	 * @param $data
	 * @return mixed
	 */
	protected function filterCommercialData( $data ) {
		$service = $this->getLicensedWikisService();
		$data['ranking'] = array_values( array_filter( $data['ranking'], function( $element ) use($service) {
			return $service->isCommercialUseAllowedByUrl($element['wikiUrl']);
		} ) );
		return $data;
	}
}
