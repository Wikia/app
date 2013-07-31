<?php

class WikiaHubsServicesHelper
{
	const HUBSV2_IMAGES_MEMC_KEY_VER = '1.03';
	const HUBSV2_IMAGES_MEMC_KEY_PREFIX = 'hubv2images';

	private $corporateModel = null;

	/**
	 * Get memcache key for hub images on WikiaHomepage
	 *
	 * @param $lang
	 *
	 * @return string
	 */
	static public function getWikiaHomepageHubsMemcacheKey($lang) {
		return wfSharedMemcKey(
			'wikiahomepage',
			self::HUBSV2_IMAGES_MEMC_KEY_PREFIX,
			$lang,
			self::HUBSV2_IMAGES_MEMC_KEY_VER
		);
	}

	/**
	 * Purge corporate main page varnish
	 *
	 * @param $lang
	 *
	 * @throws Exception
	 */
	public function purgeHomePageVarnish($lang) {
		$wikiId = $this->getCorporateModel()->getCorporateWikiIdByLang($lang);

		$mainPageName = static::getMainPageNameByWikiId($wikiId);
		$mainPageTitle = static::getGlobalTitleFromText($mainPageName, $wikiId);
		$mainPageTitle->purgeSquid();
	}

	/**
	 * Purge Hub varnish
	 *
	 * @param $lang
	 * @param $verticalId
	 */
	public function purgeHubVarnish($lang, $verticalId) {
		$wikiId = $this->getCorporateModel()->getCorporateWikiIdByLang($lang);

		$hubTitle = static::getGlobalTitleFromText(static::getHubName($wikiId, $verticalId), $wikiId);
		$hubTitle->purgeSquid();
	}

	protected function getCorporateModel() {
		if(empty($this->corporateModel)) {
			$this->corporateModel = new WikiaCorporateModel();
		}

		return $this->corporateModel;
	}

	/**
	 * Get hub name
	 *
	 * @param $wikiId
	 * @param $verticalId
	 *
	 * @return mixed
	 *
	 * @throws Exception
	 */
	public static function getHubName($wikiId, $verticalId) {
		$hubsV2Pages = static::getHubsV2Pages($wikiId);
		if (!isset($hubsV2Pages[$verticalId])) {
			throw new Exception('There is no hub page for selected wikiId and vertical');
		}
		return $hubsV2Pages[$verticalId];
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

	/**
	 * Get mainPage name by wikiId
	 *
	 * @param $wikiId
	 *
	 * @return string
	 *
	 * @throws Exception
	 */
	protected static function getMainPageNameByWikiId($wikiId) {
		$dbname = WikiFactory::IDtoDB($wikiId);

		$param = array(
			'action'      => 'query',
			'meta'        => 'allmessages',
			'ammessages'  => 'mainpage',
		);

		$response = ApiService::foreignCall($dbname, $param);
		if (!isset($response['query']['allmessages'][0]['*'])) {
			throw new Exception('There is a problem with getting translation for corporate mainPage name');
		}
		$mainPageName = $response['query']['allmessages'][0]['*'];

		return $mainPageName;
	}

	/**
	 * get hubsV2Pages for selected wiki
	 *
	 * @param $wikiId
	 *
	 * @return mixed
	 */
	protected static function getHubsV2Pages($wikiId) {
		return WikiFactory::getVarValueByName('wgWikiaHubsV2Pages', $wikiId);
	}

	/**
	 * get hubs v2 wikis
	 * @return array $wikis
	 */
	public static function getHubsV2Wikis() {
		$wikis = array();
		$var = WikiFactory::getVarByName( 'wgEnableWikiaHubsV2Ext', F::app()->wg->CityId );
		if ( !empty( $var ) ) {
			$wikis = WikiFactory::getListOfWikisWithVar( $var->cv_id, 'bool', '=' , true, true );
		}

		return $wikis;
	}

	/**
	 * add video to hubs v2 wikis
	 * @param MarketingToolboxModuleService $module
	 * @param array $data
	 * @return array|false $result
	 */
	public static function addVideoToHubsV2Wikis( $module, $data ) {
		$result = false;

		// get list of videos
		$videoData = $module->getVideoData( $data );

		// add video to hub v2 wikis
		foreach( $videoData as $videoUrl ) {
			if ( !empty($videoUrl) ) {
				$hubsV2Wikis = self::getHubsV2Wikis();

				$videoService = new VideoService();
				$result = $videoService->addVideoAcrossWikis( $videoUrl, $hubsV2Wikis );
			}
		}

		return $result;
	}
}
