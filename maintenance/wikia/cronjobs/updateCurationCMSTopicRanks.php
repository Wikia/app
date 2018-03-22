<?php

use Swagger\Client\CurationCMS\Api\TopicsApi;
use Wikia\Factory\ServiceFactory;
use \Wikia\Logger\WikiaLogger;

ini_set('display_errors', 'stderr');
ini_set('error_reporting', E_ALL);

require_once(dirname(__FILE__) . '/../../Maintenance.php');

class updateCurationCMSTopicRanks extends Maintenance {

	const SERVICE_NAME = "curation-cms";
	const TIMEOUT = 60;

	const SUCCESS_MESSAGE = "Updated topic ranks in the Curation CMS";
	const EXCEPTION_MESSAGE = "An unknown error occurred while updating topic ranks";

	public function __construct() {
		parent::__construct();
		$this->mDescription = "Trigger the Curation CMS to update its Topic rankings";
	}

	public function execute() {
		$api = $this->getTopicsApi();
		try {
			$startTime = microtime( true );
			$api->updateRank();
			$this->logSuccess( $startTime );
		} catch ( Exception $e ) {
			$this->logException( $e );
		}
	}

	private function logSuccess( $startTime ) {
		WikiaLogger::instance()->info( self::SUCCESS_MESSAGE,
			[
				'elapsedTime' => microtime( true ) - $startTime
			]
		);
	}

	private function logException( Exception $e ) {
		WikiaLogger::instance()->error( self::EXCEPTION_MESSAGE,
			[
				'exception_message' => $e->getMessage(),
				'exception' => $e,
			]
		);
	}

	private function getTopicsApi(): TopicsApi {
		$apiProvider = ServiceFactory::instance()->providerFactory()->apiProvider();

		/** @var TopicsApi $api */
		$api = $apiProvider->getApi(self::SERVICE_NAME, TopicsApi::class);
		$api->getApiClient()->getConfig()->setCurlTimeout( self::TIMEOUT );

		return $api;
	}
}

$maintClass = "updateCurationCMSTopicRanks";
require_once(RUN_MAINTENANCE_IF_MAIN);
