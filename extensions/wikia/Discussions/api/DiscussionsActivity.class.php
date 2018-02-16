<?php

use Swagger\Client\Discussion\Api\ContributionApi;
use Wikia\Factory\ServiceFactory;

class DiscussionsActivity {

	public static function fetchDiscussionPostCountAndDate( $username, $siteId ) {
		$wg = F::app()->wg;

		$targetUser = User::newFromName( $username );
		if ( self::discussionsIsActive( $siteId ) ) {
			try {
				$posts = self::getDiscussionContributionApi()->getPosts( $siteId, $targetUser->getId() );
			} catch ( Exception $e ) {
				Wikia\Logger\WikiaLogger::instance()->warning( "Getting discussion info failed", [
						"exception" => $e
				] );
				return [ "count" => "?", "date" => "?" ];
			}

			$count = $posts->getPostCount();

			return [
					"count" => $wg->ContLang->formatNum( $count ),
					"date" => ( $count > 0 ) ? $wg->Lang->timeanddate( $posts->getEmbedded()->getDocposts()[0]->getCreationDate()->getEpochSecond(), true ) : ""
			];
		} else {
			return [ "count" => "N/A", "date" => "" ];
		}
	}

	/**
	 * @return ContributionApi
	 */
	private static function getDiscussionContributionApi() {
		$apiProvider = ServiceFactory::instance()->providerFactory()->apiProvider();
		$api = $apiProvider->getApi( 'discussion', ContributionApi::class );

		$api->getApiClient()->getConfig()->setCurlTimeout( 5 );
		return $api;
	}

	/**
	 * @param $siteId
	 * @return boolean
	 */
	public static function discussionsIsActive( $siteId ) {
		return WikiFactory::getVarValueByName( 'wgEnableDiscussions', $siteId );
	}
}
