<?php
namespace Wikia\ExactTarget;

use Wikia\ExactTarget\ResourceEnum as Enum;
use Wikia\Tasks\Tasks\BaseTask;
use Wikia\Util\Assert;

class ExactTargetWikiTask extends BaseTask {

	private $client;

	const STATUS_OK = 'OK';

	public function __construct( $client = null ) {
		$this->client = $client;
	}

	/**
	 * Update wiki or create if doesn't exist
	 * @param array $cityData
	 * @return string
	 * @throws \Wikia\Util\AssertionException
	 */
	public function updateWiki( array $cityData ) {
		$iCityId = $cityData[ Enum::WIKI_CITY_ID ];

		Assert::true( !empty( $iCityId ), 'City ID missing' );

		$client = $this->getClient();

		/* Update or create Wiki in external service */
		$client->updateWiki( $iCityId, $this->getWikiData( $iCityId ) );

		return self::STATUS_OK;
	}

	public function updateWikiCatMapping( $iCityId ) {
		Assert::true( !empty( $iCityId ), 'City ID missing' );

		$client = $this->getClient();
		$oWikiFactoryHub = new \WikiFactoryHub();
		$aCategories = $oWikiFactoryHub->getWikiCategories( $iCityId );

		/* Update or create Wiki in external service */
		$client->updateWikiCatMapping( $iCityId, $aCategories );

		return self::STATUS_OK;
	}

	protected function getClient() {
		if ( !isset( $this->client ) ) {
			$this->client = new ExactTargetClient();
		}
		return $this->client;
	}

	private function getWikiData( $cityId ) {
		/* Get wikidata from master */
		$oWiki = \WikiFactory::getWikiById( $cityId, true );

		return [
			'city_path' => $oWiki->city_path,
			'city_dbname' => $oWiki->city_dbname,
			'city_sitename' => $oWiki->city_sitename,
			'city_url' => $oWiki->city_url,
			'city_created' => $oWiki->city_created,
			'city_founding_user' => $oWiki->city_founding_user,
			'city_adult' => $oWiki->city_adult,
			'city_public' => $oWiki->city_public,
			'city_title' => $oWiki->city_title,
			'city_founding_email' => $oWiki->city_founding_email,
			'city_lang' => $oWiki->city_lang,
			'city_special' => $oWiki->city_special,
			'city_umbrella' => $oWiki->city_umbrella,
			'city_ip' => $oWiki->city_ip,
			'city_google_analytics' => $oWiki->city_google_analytics,
			'city_google_search' => $oWiki->city_google_search,
			'city_google_maps' => $oWiki->city_google_maps,
			'city_indexed_rev' => $oWiki->city_indexed_rev,
			'city_lastdump_timestamp' => $oWiki->city_lastdump_timestamp,
			'city_factory_timestamp' => $oWiki->city_factory_timestamp,
			'city_useshared' => $oWiki->city_useshared,
			'ad_cat' => $oWiki->ad_cat,
			'city_flags' => $oWiki->city_flags,
			'city_cluster' => $oWiki->city_cluster,
			'city_last_timestamp' => $oWiki->city_last_timestamp,
			'city_founding_ip' => $oWiki->city_founding_ip,
			'city_vertical' => $oWiki->city_vertical,
		];
	}
}
