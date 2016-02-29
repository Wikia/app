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
		$oHelper = new ExactTargetWikiTaskHelper();

		Assert::true( !empty( $iCityId ), 'City ID missing' );

		$client = $this->getClient();

		/* Update or create Wiki in external service */
		$client->updateWiki( $iCityId, $oHelper->getWikiDataArray( $iCityId ) );

		return self::STATUS_OK;
	}

	protected function getClient() {
		if ( !isset( $this->client ) ) {
			$this->client = new ExactTargetClient();
		}
		return $this->client;
	}
}
