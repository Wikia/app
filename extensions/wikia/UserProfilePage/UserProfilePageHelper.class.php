<?php
class UserProfilePageHelper {

	/**
	 * SkinTemplateOutputPageBeforeExec hook
	 */
	static public function onSkinTemplateOutputPageBeforeExec( $skin, $template ) {
		global $wgRequest;
		wfProfileIn(__METHOD__);

		// Return without any changes if this isn't in the user namespace OR
		// if the user is doing something besides viewing or purging this page
		$action = $wgRequest->getVal('action', 'view');
		if ($skin->mTitle->getNamespace() != NS_USER || ($action != 'view' && $action != 'purge')) {
			return true;
		}

		$user = self::getUserFromTitle( $skin->mTitle );

		// sanity check
		if ( !is_object( $user ) ) {
			return true;
		}
		$user->load();

		$profilePage = UserProfilePage::getInstance( $user );
		$template->data['bodytext'] = $profilePage->get( $template->data['bodytext'] );

		wfProfileOut(__METHOD__);
		return true;
	}

	public static function doAction() {
		global $wgUser, $wgRequest;

		$result = array(
			'result' => true
		);

		$name = $wgRequest->getVal( 'name' );
		$type = $wgRequest->getVal( 'type' );
		$value = $wgRequest->getVal( 'value' );

		if( is_object( $wgUser ) && $wgUser->getId() && !empty( $name ) && !empty( $type ) && !empty( $value ) ) {
			$profilePage = new UserProfilePage( $wgUser );
			$result['type'] = $type;
			$result['html'] = $profilePage->doAction( $name, $type, $value );
		}

		$json = Wikia::json_encode( $result );
		$response = new AjaxResponse( $json );
		$response->setContentType( 'application/json; charset=utf-8' );

		return $response;
	}

	public static function getUserFromTitle( Title $title) {
		$userName = '';

		if( $title->isSubpage() ) {
			$userName = $title->getBaseText();
		} else {
			$userName = $title->getText();
		}
		return User::newFromName( $userName );
	}

	/**
	 * same as getUserFromTitle() but return false when user account doesn't exists
	 * @param Title $title page title
	 */
	public static function getExistingUserFromTitle( Title $title ) {
		$user = self::getUserFromTitle( $title );
		if($user instanceof User) {
			$userId = $user->idForName();
			if( !empty( $userId ) ) {
				return $user;
			}
		}
		return false;
	}

	public static function formatLastActionMessage( $actionData ) {
		if( count($actionData) ) {
			return wfMsg( 'userprofilepage-user-last-action-' . $actionData['type'], array( wfTimeFormatAgoOnlyRecent($actionData['timestamp']), $actionData['url'], $actionData['title'] ) );
		}
		else {
			return '';
		}
	}
}