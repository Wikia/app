<?php

namespace Wikia\FeedsAndPosts;

use CommunityDataService;
use Title;

class WikiInfo {
	public function get(): array {
		global $wgCityId, $wgEnableCommunityPageExt;

		$getStartedUrl = !empty($wgEnableCommunityPageExt)
			? Title::newFromText('Community', NS_SPECIAL)->getFullURL()
			: Title::newMainPage()->getFullURL();

		return [
			'getStartedUrl' =>  wfProtocolUrlToRelative($getStartedUrl),
			'wikiDescription' => ( new CommunityDataService( $wgCityId ) )->getCommunityDescription()
		];
	}
}
