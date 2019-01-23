<?php

namespace Wikia\FeedsAndPosts;

use CommunityDataService;
use Title;
use WikiaDataAccess;

class WikiVariables {
	public function get() {
		global $wgServer, $wgDBname, $wgCityId;

		$wikiVariables = [
			'basePath' => $wgServer,
			'dbName' => $wgDBname,
			'getStartedUrl' =>  $this->getStartedUrl(),
			'wikiDescription' => ( new CommunityDataService( $wgCityId ) )->getCommunityDescription(),
		];

		\Hooks::run( 'MercuryWikiVariables', [ &$wikiVariables ] );

		return $wikiVariables;
	}

	private function getStartedUrl(): string {
		return WikiaDataAccess::cache(
			wfMemcKey('feeds', 'get-started-url'),
			10800, // 3h
			function() {
				global $wgEnableCommunityPageExt;

				$getStartedUrl = !empty( $wgEnableCommunityPageExt )
					? Title::newFromText( 'Community', NS_SPECIAL )->getFullURL()
					: Title::newMainPage()->getFullURL();

				return wfProtocolUrlToRelative($getStartedUrl);
			}
		);
	}
}
