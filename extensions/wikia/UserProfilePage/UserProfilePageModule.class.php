<?php
class UserProfilePageModule extends Module {

	public $data = null;

	public function executeMasthead( $data ) {
		wfProfileIn(__METHOD__);
		// render bigger avatar (200x200) when UserProfilePage extension is enabled
		$this->avatar = AvatarService::renderAvatar($data['userName'], 200, true);

		$userProfilePage = UserProfilePage::getInstance();

		if( !empty( $userProfilePage ) ) {
			$this->lastActionData = $userProfilePage->getUserLastAction();

			if( !empty( $this->lastActionData ) ) {
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

			$this->userRights = array_intersect( $userProfilePage->getUser()->getRights(), array(
				'sysop',
				'bot',
				'staff',
				'helper',
				'bureaucrat',
				'vstf'
			));

			//#108811, get correct username from User namespace subpages
			$data['title'] = $userProfilePage->getUser()->getName();
		}

		$this->data = $data;
		wfProfileOut(__METHOD__);
	}
}
