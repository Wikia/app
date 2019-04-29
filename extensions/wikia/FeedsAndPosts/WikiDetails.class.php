<?php
namespace Wikia\FeedsAndPosts;

class WikiDetails {
	const TOP_EDITORS_COUNT = 6;
	const AVATAR_SIZE = 52;

	public function get(): array {
		global $wgCityId;

		$wikiDetailsService = new \WikiDetailsService();
		$topUserInfo = $wikiDetailsService->getTopEditors( $wgCityId, self::TOP_EDITORS_COUNT);

		$topUsers = [];

		foreach ( $topUsers as $userId => $edits ) {
			$user = \User::newFromId( $userId );

			$topUsers[] = [
				'id' => $userId,
				'name' => $user->getName(),
				'avatarUrl' => \AvatarService::getAvatarUrl( $user, static::AVATAR_SIZE ),
			];
		}

		$themeSettings = new \ThemeSettings();

		$topUsers = array_keys( $topUserInfo );
		$pageCount = \SiteStats::articles();
		$editCount = \SiteStats::edits();
		$wordmark = $themeSettings->getWordmarkUrl();
		$favicon = \Wikia::getFaviconFullUrl();

		return [
			'topUsers' => $topUsers,
			'pageCount' => $pageCount,
			'editCount' => $editCount,
			'wordmark' => $wordmark,
			'favicon' => $favicon,
		];
	}
}
