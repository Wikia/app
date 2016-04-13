<?php

class CommunityPageExperimentHelper {
	private $wikiService;

	const HEADER_IMAGE_NAME = 'Community-Page-Header.jpg';
	const DEFAULT_NUM_ADMINS = 2;

	public function getPageList() {
		global $wgCommunityPageExperimentPages;

		$pages = [];

		if ( empty( $wgCommunityPageExperimentPages ) ) {
			return $pages;
		}

		foreach ( $wgCommunityPageExperimentPages as $page ) {
			$title = Title::newFromText( $page );
			if ( !( $title instanceof Title ) ) {
				continue;
			}

			$editActionParam = ( EditorPreference::isVisualEditorPrimary() ? 'veaction' : 'action' );

			$pages[] = [
				'titleText' => $title->getPrefixedText(),
				'titleUrl' => $title->getLocalURL(),
				'editUrl' => $title->getLocalURL( [ $editActionParam => 'edit' ] ),
			];
		}

		return $pages;
	}

	public function getHeaderImage() {
		$title = Title::newFromText( self::HEADER_IMAGE_NAME, NS_FILE );
		$file = wfFindFile( $title );
		if ( $file instanceof File ) {
			return $file->getUrl();
		}

		return false;
	}

	public function getRandomAdmins( $num = self::DEFAULT_NUM_ADMINS ) {
		global $wgCityId;
		$adminIds = $this->getWikiService()->getWikiAdminIds( $wgCityId, /* $useMaster = */ false, /* $excludeBots = */ true );
		if ( empty( $adminIds ) ) {
			return [];
		}

		// Filter out blocked and anon admins
		$adminIds = array_filter( $adminIds, function ( $adminId ) {
			$admin = User::newFromId( $adminId );
			return !$admin->isBlocked() && !$admin->isAnon();
		} );

		$numAdmins = count( $adminIds );
		if ( $numAdmins < $num ) {
			$num = $numAdmins;
		}

		if ( $num == 0 ) {
			return [];
		}

		$randomAdminIds = array_rand( $adminIds, $num );
		if ( !is_array( $randomAdminIds ) ) {
			$randomAdminIds = [ $randomAdminIds ];
		}

		$admins = [];
		foreach ( $randomAdminIds as $adminId ) {
			$admins[] = $this->getAdminData( $adminIds[$adminId] );
		}

		return $admins;
	}

	public function getTopContributors() {
		global $wgCityId;
		$topEditors = $this->getWikiService()->getTopEditors( $wgCityId, /* $limit = */ WikiService::TOPUSER_LIMIT, /* $excludeBots = */ true );
		$limit = 5;
		$limitedTopEditors = array_slice( $topEditors, 0, $limit, true );
		$numOtherEditors = count( $topEditors ) - $limit;

		$topEditorList = [];
		foreach ( $limitedTopEditors as $userId => $edits ) {
			$user = User::newFromId( $userId );
			$userName = $user->getName();
			$avatar = AvatarService::renderAvatar( $userName, AvatarService::AVATAR_SIZE_SMALL_PLUS - 2 );

			$topEditorList[] = [
				'username' => $userName,
				'userpage' => $user->getUserPage()->getLocalURL(),
				'avatar' => $avatar,
				'edits' => $edits,
			];
		}
		return [ 'list' => $topEditorList, 'numextra' => $numOtherEditors ];
	}

	private function getAdminData( $userId ) {
		$adminUser = User::newFromId( $userId );
		$adminUserName = $adminUser->getName();
		$adminAvatar = '';
		$extraAvatarClasses = 'logged-avatar-placeholder';

		if ( !AvatarService::isEmptyOrFirstDefault( $adminUserName ) ) {
			$extraAvatarClasses = 'logged-avatar';
			$adminAvatar = AvatarService::renderAvatar( $adminUser->getName(), AvatarService::AVATAR_SIZE_MEDIUM - 2 );
		}

		return [
			'adminUserName' => $adminUserName,
			'adminUserUrl' => $adminUser->getUserPage()->getLocalURL(),
			'extraAvatarClasses' => $extraAvatarClasses,
			'adminAvatar' => $adminAvatar,
		];
	}

	private function getWikiService() {
		if ( $this->wikiService === null ) {
			$this->wikiService = new WikiService();
		}

		return $this->wikiService;
	}
}
