<?php
class UserProfilePageModule extends Module {

	public $data = null;

	public function executeMasthead( $data ) {
		// render bigger avatar (200x200) when UserProfilePage extension is enabled
		$this->avatar = AvatarService::renderAvatar($data['userName'], 200, true);

		$userProfilePage = UserProfilePage::getInstance();

		$this->lastActionData = $userProfilePage->getUserLastAction();
		if( count($this->lastActionData) ) {
			$this->lastActionData['changemessage'] = UserProfilePageHelper::formatLastActionMessage( $this->lastActionData );
			$this->lastActionData['changeicon'] = $this->lastActionData['type'];
			if( empty( $this->lastActionData['intro'] ) ) {
				// try to get article text snippet if there's no intro section from rc_data
				$lastTitle = Title::newFromText( $this->lastActionData['title'], $this->lastActionData['ns'] );
				$articleId = $lastTitle->getArticleId();
				if( !empty( $articleId ) ) {
					$articleService = new ArticleService( $articleId );
					$this->lastActionData['intro'] = $articleService->getTextSnippet( 100 );
				}
				else {
					$this->lastActionData['intro'] = '';
				}
			}
		}

		$this->userRights = array_intersect( $userProfilePage->getUserRights(), array(
			'sysop',
			'bot',
			'staff',
			'helper',
			'bureaucrat',
			'vstf'
		));

		$this->data = $data;
	}
}
