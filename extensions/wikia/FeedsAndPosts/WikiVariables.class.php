<?php

namespace Wikia\FeedsAndPosts;

use CommunityDataService;
use Title;
use WikiaDataAccess;

class WikiVariables {
	public function get() {
		global $wgServer, $wgDBname, $wgScriptPath, $wgCityId, $wgLanguageCode, $wgEnableDiscussions, $wgSitename;

		$wikiVariables = [
			'wikiId' => $wgCityId,
			'basePath' => (wfHttpsAllowedForURL($wgServer) ? wfHttpToHttps($wgServer) : $wgServer) . $wgScriptPath,
			'dbName' => $wgDBname,
			'name' => $wgSitename,
			'getStartedUrl' =>  $this->getStartedUrl(),
			'wikiDescription' => ( new CommunityDataService( $wgCityId ) )->getCommunityDescription(),
			'openGraphImageUrl' => \OpenGraphImageHelper::getUrl(),
			'language' => [
				'content' => $wgLanguageCode,
			],
			'enableDiscussions' => $wgEnableDiscussions,
			'gamepediaRedirectUrl' => $this->getGamepediaRedirect(),
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

	private function getGamepediaRedirect(): string {
		$msg = wfMessage( 'Custom-GamepediaNotice' )->inLanguage( 'en' );

		return $msg->exists() ? "https://{$msg->escaped()}.gamepedia.com/?utm_source=Fandom&utm_medium=banner&utm_campaign={$msg->escaped()}" : '';
	}
}
