<?php
namespace Wikia\FeedsAndPosts;

use Wikia\Factory\ServiceFactory;

class WikiDetails {
	const TOP_EDITORS_COUNT = 6;
	const AVATAR_SIZE = 52;

	public function get(): array {
		global $wgCityId;

		$wikiDetailsService = new \WikiDetailsService();
		$topUserInfo = $wikiDetailsService->getTopEditors( $wgCityId, self::TOP_EDITORS_COUNT );
		$usersWithAttributes = $this->fetchUserAttributes( array_keys( $topUserInfo ) );

		$topUsers = [];

		foreach ( $topUserInfo as $userId => $edits ) {
			$topUsers[] = [
				'id' => $userId,
				'name' => $usersWithAttributes[$userId]['username'],
				'avatarUrl' => $usersWithAttributes[$userId]['avatar'],
			];
		}

		$themeSettings = new \ThemeSettings();

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

	private function fetchUserAttributes( array $userIds ) {
		$userAttributeGateway = ServiceFactory::instance()->attributesFactory()->userAttributeGateway();

		return $userAttributeGateway->getAllAttributesForMultipleUsers( $userIds )['users'] ?? [];
	}
}
