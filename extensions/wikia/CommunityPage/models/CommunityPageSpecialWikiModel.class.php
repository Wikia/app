<?php

class CommunityPageSpecialWikiModel {
	private $wikiService;

	private function getWikiService() {
		return $this->wikiService;
	}

	public function __construct() {
		$this->wikiService = new WikiService();
	}

	/**
	 * Get page views of the current wiki in the last n days
	 *
	 * @param int $days
	 * @return int
	 */
	public function getWikiPageViews( $days = 14 ) {
		return 100;
	}

	/**
	 * Get all edits for a wiki optionally filtered by the most recent n days
	 *
	 * @param int|null $days
	 * @return int
	 */
	public function getWikiEdits( $days = null ) {
		return 100;
	}

	/**
	 * Get the number of editors of a wiki optionally filtered by most recent n days
	 *
	 * @param int|null $days
	 * @return int
	 */
	public function getWikiEditorCount( $days = null ) {
		return 100;
	}

	/**
	 * Get recent wiki activity
	 *
	 * @return array
	 */
	public function getRecentActivityData() {
		$app = F::app();
		$data = $app->sendRequest('LatestActivityController', executeIndex)->getData();
		$recentActivity = [];

		foreach ($data['changeList'] as $activity) {
			$recentActivity[] = [
				'timeAgo' => $activity['time_ago'],
				'userAvatar' => AvatarService::renderAvatar(
					$activity['user_name'],
					AvatarService::AVATAR_SIZE_SMALL_PLUS ),
				'changeMessage' => $activity['changemessage'],
				'editedPageTitle' => $activity['page_title'],
			];
		}

		return [
			'activityHeading' => $data['moduleHeader'],
			'moreActivityLink' => Wikia::specialPageLink( 'WikiActivity', 'oasis-more', 'more-activity' ),
			'activity' => $recentActivity,
		];
	}

}
