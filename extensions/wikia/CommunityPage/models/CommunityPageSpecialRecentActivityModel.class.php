<?php

class CommunityPageSpecialRecentActivityModel {

	/**
	 * @return array
	 * @throws MWException
	 */
	public function getData() {
		$recentActivityData = F::app()->sendRequest( 'LatestActivityController', 'executeIndex' )->getData();

		$recentActivity = [];
		foreach ( $recentActivityData['changeList'] as $activity ) {
			$changeTypeString = $this->getChangeTypeMessage( $activity['changetype'] );
			$userProfileLink = $this->getUserProfileLink( $activity['user_name'], $activity['user_profile_url'] );
			$pageLink = $this->getPageLink( $activity['page_title'], $activity['page_url'] );

			$changeMessage = wfMessage( 'communitypage-activity',
				$userProfileLink, $changeTypeString, $pageLink )->plain();

			$recentActivity[] = [
				'timeAgo' => $activity['time_ago'],
				'profilePage' => $activity['user_profile_url'],
				'userAvatar' => AvatarService::renderAvatar(
					$activity['user_name'],
					AvatarService::AVATAR_SIZE_SMALL_PLUS ),
				'changeMessage' => $changeMessage,
			];
		}

		$title = SpecialPage::getTitleFor( 'WikiActivity' );

		return [
			'activityHeading' => $recentActivityData['moduleHeader'],
			'moreActivityText' => wfMessage( 'communitypage-recent-activity' )->plain(),
			'moreActivityLink' => $title->getCanonicalURL(),
			'activity' => $recentActivity,
		];
	}

	/**
	 * Returns a modified string specifying a type of activity done (create, delete, edit)
	 * ready to be used in the whole change message.
	 * @param string $changeType
	 * @return mixed
	 */
	public function getChangeTypeMessage( $changeType ) {
		switch ( $changeType ) {
			case 'new':
				return $changeTypeString = wfMessage( 'communitypage-created' )->plain();
			case 'delete':
				return wfMessage( 'communitypage-deleted' )->plain();
			default:
				return wfMessage( 'communitypage-edited' )->plain();
		}
	}

	/**
	 * @param string $userName
	 * @param string $userProfileUrl
	 * @return string
	 */
	public function getUserProfileLink( $userName, $userProfileUrl ) {
		return Html::element(
			'a',
			[
				'data-tracking' => 'user-profile-link',
				'href' => $userProfileUrl,
			],
			$userName
		);
	}

	/**
	 * @param $pageTitle
	 * @param $pageUrl
	 * @return string
	 */
	public function getPageLink( $pageTitle, $pageUrl ) {
		return Html::element(
			'a',
			[
				'data-tracking' => 'page-link',
				'href' => $pageUrl,
			],
			$pageTitle
		);
	}
}
