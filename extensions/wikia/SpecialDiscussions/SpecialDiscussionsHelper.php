<?php

use Swagger\Client\ApiException;
use Swagger\Client\Discussion\Api\SitesApi;
use Wikia\DependencyInjection\Injector;
use Wikia\Service\Swagger\ApiProvider;

/**
 * Helper class for Special:Discussions and related functionality
 */
class SpecialDiscussionsHelper {

	const DISCUSSIONS_SERVICE_NAME = 'discussion';
	const CURL_TIMEOUT = 5;
	const DISCUSSIONS_SITE_NAME_MAX_LENGTH = 256;
	const DISCUSSIONS_LINK = '/d/f';

	static private function getDiscussionsSitesApi() {
		/** @var ApiProvider $apiProvider */
		$apiProvider = Injector::getInjector()->get( ApiProvider::class );
		/** @var SitesApi $api */
		$api = $apiProvider->getApi( self::DISCUSSIONS_SERVICE_NAME, SitesApi::class );
		$api->getApiClient()->getConfig()->setCurlTimeout( self::CURL_TIMEOUT );
		return $api;
	}

	/**
	 * Activates Discussions on the given site
	 * @param $siteId int
	 * @param $lang string The language code for the site
	 * @param $sitename string
	 * @return bool true if Discussions was successfully activated on the site
	 */
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
			$res = $e->getResponseObject();
			$title = $detail = '';
			if ( $res instanceof \Swagger\Client\Discussion\Models\HalProblem ) {
				$title = $res->getTitle();
				$detail = $res->getDetail();
			}
			Wikia\Logger\WikiaLogger::instance()->error(
				'Creating site caused an error',
				[
					'siteId' => $siteId,
					'error' => empty ( $title ) ? $e->getMessage() : $title . ': ' . $detail,
				]
			);
			return false;
		}
		return true;
	}

	/**
	 * Checks if Discussions is enabled on a given site
	 * @param $siteId int The site ID to check
	 * @return bool
	 */
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
}
