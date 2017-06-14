<?php

use Wikia\DependencyInjection\Injector;
use Wikia\Service\Swagger\ApiProvider;

class DiscussionsActivity {

	public static function fetchDiscussionPostCountAndDate( $username, $siteId ) {
		$wg = F::app()->wg;

		$targetUser = User::newFromName( $username );
		if ( self::discussionsIsActive( $siteId ) ) {
			$posts = self::getDiscussionContributionApi()->getPosts( $siteId, $targetUser->getId() );
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
		$apiProvider = Injector::getInjector()->get( ApiProvider::class );
		$api = $apiProvider->getApi( 'discussion', ContributionApi::class );

		$api->getApiClient()->getConfig()->setCurlTimeout( 5 );
		return $api;
	}

	/**
	 * @param $siteId
	 * @return boolean
	 */
	public static function discussionsIsActive( $siteId )
	{
		return WikiFactory::getVarValueByName( 'wgEnableDiscussions', $siteId );
	}
}
