<?php
class UserProfilePageHelper {
	public static $allowedNamespaces = array( NS_USER, NS_USER_TALK );
	
	/**
	 * SkinTemplateOutputPageBeforeExec hook
	 */
	static public function onSkinTemplateOutputPageBeforeExec( $skin, $template ) {
		global $wgRequest, $wgEnableUserProfilePagesExt, $wgOut, $wgJsMimeType, $wgExtensionsPath, $wgStyleVersion, $wgUser;
		wfProfileIn(__METHOD__);

		$ns = $skin->mTitle->getNamespace();

		if( defined( 'NS_BLOG_ARTICLE' ) ) {
			self::$allowedNamespaces[] = NS_BLOG_ARTICLE;
			if( $ns == NS_BLOG_ARTICLE ) {
				$isBlogPage = true;
			}
			else {
				$isBlogPage = false;
			}
		}
		else {
			$isBlogPage = false;
		}
		
		// Return without any changes if this isn't in the user namespace OR
		// if the user is doing something besides viewing or purging this page
		$action = $wgRequest->getVal('action', 'view');
		if ( ( !in_array( $ns, self::$allowedNamespaces ) && $ns != NS_SPECIAL ) || ($action != 'view' && $action != 'purge') || ( $ns != NS_SPECIAL && $skin->mTitle->isSubpage() ) ) {
			$wgEnableUserProfilePagesExt = false;
			return true;
		}
		
		
		$user = self::getUserFromTitle( $skin->mTitle );
		$userName = null;
		
		// sanity check
		if ( is_object( $user ) ) {
			$user->load();
			$userName = $user->getName();
		}

		// fallback for non-existent users
		if( !is_object( $user ) || $user->getId() == 0 ) {
			$template->data['bodytext'] = wfMsg( 'userprofilepage-user-doesnt-exists', array( $userName ) );
			$wgEnableUserProfilePagesExt = false;
			return true;
		}

		// load extension css and js
		$wgOut->addStyle( wfGetSassUrl( "extensions/wikia/UserProfilePage/css/UserProfilePage.scss" ) );
		$wgOut->addScript( "<script type=\"{$wgJsMimeType}\" src=\"{$wgExtensionsPath}/wikia/UserProfilePage/js/UserProfilePage.js?{$wgStyleVersion}\" ></script>\n" );

		if( $ns == NS_USER_TALK || $ns == NS_SPECIAL || $isBlogPage ) {
			// don't replace page content for talk and blog pege (RT: #98342, #88757)
			wfProfileOut(__METHOD__);
			return true;
		}
		else {
			// NS_USER namespace
			$profilePage = UserProfilePage::getInstance( $user );
			$article = Article::newFromID( $template->data['articleid'] );
			if( is_null( $article ) ) {
				if( $profilePage->userIsOwner() ) {
					$template->data['bodytext'] = $profilePage->get( wfMsg( 'userprofilepage-empty-my-about-me-section', array( $skin->mTitle->getLocalUrl( 'action=edit' ) ) ) );
				}
				else {
					$template->data['bodytext'] = $profilePage->get( wfMsg( 'userprofilepage-empty-somebodys-about-me-section', array( $profilePage->getUser()->getName(), $profilePage->getUser()->getTalkPage()->getLocalUrl( 'action=edit' ) ) ) );
				}
			}
			else {
				$template->data['bodytext'] = $profilePage->get( $template->data['bodytext'] );
			}
		}

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
			$profilePage = UserProfilePage::getInstance( $wgUser );
			$result['type'] = $type;
			$result['html'] = $profilePage->doAction( $name, $type, $value );
		}

		$json = Wikia::json_encode( $result );
		$response = new AjaxResponse( $json );
		$response->setContentType( 'application/json; charset=utf-8' );

		return $response;
	}

	public static function getUserFromTitle( Title $title ) {
		if( $title->isSpecial( 'Following' ) ) {
			global $wgUser;
			return $wgUser;
		} else {
			return User::newFromName( UserPagesHeaderModule::getUserName($title, self::$allowedNamespaces , false ) );
		}
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

	public static function onAlternateEdit( &$oEditPage ) {
		global $wgOut, $wgUser;
		$title = $oEditPage->mTitle;
		if( $title->getNamespace() == NS_USER ) {
			$user = self::getUserFromTitle( $title );
			if( !empty( $user ) && strcmp( $user->getName(), $wgUser->getName() ) != 0 ) {
				$wgOut->clearHTML();
				$wgOut->showErrorPage( 'userprofilepage-edit-permision-denied', 'userprofilepage-edit-permision-denied-info' );
				return false;
			}
		}
		return true;
	}

}
