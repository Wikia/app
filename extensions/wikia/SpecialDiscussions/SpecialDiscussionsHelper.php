<?php

use Swagger\Client\ApiException;
use Swagger\Client\Discussion\Api\SitesApi;
use Wikia\DependencyInjection\Injector;
use Wikia\Service\Swagger\ApiProvider;

class SpecialDiscussionsHelper {

	const DISCUSSIONS_SERVICE_NAME = 'discussion';
	const CURL_TIMEOUT = 5;
	const DISCUSSIONS_SITE_NAME_MAX_LENGTH = 256;

	static private function getDiscussionsSitesApi() {
		/** @var ApiProvider $apiProvider */
		$apiProvider = Injector::getInjector()->get( ApiProvider::class );
		/** @var SitesApi $api */
		$api = $apiProvider->getApi( self::DISCUSSIONS_SERVICE_NAME, SitesApi::class );
		$api->getApiClient()->getConfig()->setCurlTimeout( self::CURL_TIMEOUT );
		return $api;
	}

	static public function activateDiscussions( $siteId, $lang, $sitename ) {
		$siteInput = new \Swagger\Client\Discussion\Models\SiteInput(
			[
				'id' => $siteId,
				'language_code' => $lang,
				'name' => substr( $sitename, 0, self::DISCUSSIONS_SITE_NAME_MAX_LENGTH ),
			]
		);
		try {
			self::getDiscussionsSitesApi()->createSite( $siteInput, F::app()->wg->TheSchwartzSecretToken );
			WikiFactory::setVarByName( "wgEnableDiscussions", $siteId, true );
		} catch ( ApiException $e ) {
			Wikia\Logger\WikiaLogger::instance()->error(
				'Creating site caused an error',
				[
					'siteId' => $siteId,
					'error' => $e->getMessage(),
				]
			);
			return false;
		}
		return true;
	}

	static public function isDiscussionsActive( $siteId ) {
		try {
			self::getDiscussionsSitesApi()->getSite( $siteId );
			return true;
		} catch ( ApiException $e ) {
			Wikia\Logger\WikiaLogger::instance()->error(
				'Getting site caused an error',
				[
					'siteId' => $siteId,
					'error' => $e->getMessage(),
				]
			);
		}
		return false;
	}

	static public function getDiscussionsLink() {
		return '/d/f';
	}
}