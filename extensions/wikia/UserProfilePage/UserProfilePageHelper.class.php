<?php
class UserProfilePageHelper {
	
	/**
	 * @author Federico "Lox" Lucignano
	 * 
	 * @param Title $title
	 * @return bool 
	 */
	static public function isAllowed( Title $title ) {
		global $wgUserProfilePagesNamespaces, $wgRequest;
		
		$isAllowedPage = (
			in_array( $title->getNamespace(), $wgUserProfilePagesNamespaces ) ||
			$title->isSpecial( 'Following' ) ||
			$title->isSpecial( 'Contributions' )
		);
		
		$isBlogPost = ( defined('NS_BLOG_ARTICLE') && $title->getNamespace() == NS_BLOG_ARTICLE && $title->isSubpage() );
		
		$action = $wgRequest->getVal('action', 'view');
		$isAllowedAction = ( $action == 'view' || $action == 'purge' );
		
		return $isAllowedPage && !$isBlogPost && $isAllowedAction;
	}
	
	/**
	 * SkinTemplateOutputPageBeforeExec hook
	 */
	static public function onSkinTemplateOutputPageBeforeExec( $skin, $template ) {
		global $wgRequest, $wgEnableUserProfilePagesExt, $wgOut, $wgJsMimeType, $wgExtensionsPath, $wgStyleVersion, $wgUser, $wgUserProfilePagesNamespaces;
		wfProfileIn(__METHOD__);
		
		if ( !self::isAllowed( $skin->mTitle ) ) {
			$wgEnableUserProfilePagesExt = false;
			return true;
		}
		
		$user = ( $skin->mTitle->isSpecial( 'Contributions' ) || $skin->mTitle->isSpecial( 'Following' ) ) ? $wgUser : self::getUserFromTitle( $skin->mTitle );
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
		
		$ns = $skin->mTitle->getNamespace();
		
		if( defined( 'NS_BLOG_ARTICLE' ) ) {
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
		
		$isUserSubpage = ( $ns == NS_USER && $skin->mTitle->isSubpage() );
		
		if( $isUserSubpage || $ns == NS_USER_TALK || $isBlogPage || $ns == NS_SPECIAL  ) {
			// don't replace page content for talk and blog page (RT: #98342, #88757) and special pages
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
		global $wgUserProfilePagesNamespaces, $wgUser;
		
		if( $title->isSpecial( 'Following' ) ) {
			return $wgUser;
		} else {
			return User::newFromName( UserPagesHeaderModule::getUserName($title, $wgUserProfilePagesNamespaces , false ) );
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
	
	static public function onGetRailModuleList(&$modules) {
		global $wgEnableAchievementsExt, $wgUserProfilePagesNamespaces, $wgTitle;
		
		if ( $wgTitle->getNamespace() != NS_SPECIAL && self::isAllowed( $wgTitle ) ) {//no right rail in special pages
			foreach( $modules as $weight => $module ) {
				if( $wgEnableAchievementsExt && $module[0] == 'Achievements' ) {
					$modules[ $weight ] = array('Achievements', 'UserProfilePagesModule', null);
					continue;
				}

				if( in_array( $module[0], array( 'LatestPhotos', 'LatestActivity', 'PagesOnWiki' ) ) ) {
					unset( $modules[ $weight ] );
				}
			}


			$modules[1499] = array('UserProfileRail', 'TopWikis', null);
			$modules[1498] = array('LatestActivity', 'Index', null);
			$modules[1497] = array('UserProfileRail', 'TopPages', null);
		}
		
		return true;
	}
}
