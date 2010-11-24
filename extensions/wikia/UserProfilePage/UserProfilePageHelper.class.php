<?php
class UserProfilePageHelper {
	
	/**
	 * SkinTemplateOutputPageBeforeExec hook
	 */
	static public function onSkinTemplateOutputPageBeforeExec( $skin, $template ) {
		global $wgRequest, $wgEnableUserProfilePagesExt, $wgOut, $wgJsMimeType, $wgExtensionsPath, $wgStyleVersion, $wgUser, $wgUserProfilePagesNamespaces;
		wfProfileIn(__METHOD__);
		
		//is the extension allowed to run for the current page?
		if ( !UserProfilePage::isAllowed( $skin->mTitle ) ) {
			$wgEnableUserProfilePagesExt = false;
			wfProfileOut(__METHOD__);
			return true;
		}
		
		//the extension is allowed, try to get an instance of the main UPP class
		$profilePage = UserProfilePage::getInstance( $skin->mTitle );
		$user = !empty( $profilePage ) ? $profilePage->getUser() : null;
		$isAnon = !empty( $user ) ? $user->isAnon() : true;
		$ns = $skin->mTitle->getNamespace();
		
		if( ( empty( $profilePage ) || $isAnon ) && ( $ns == NS_USER || $ns = NS_USER_TALK ) && !UserProfilePage::isAllowedSpecialPage( $skin->mTitle ) ) {
			//// fallback for non-existent users profile/talk pages
			$msg = null;
			$userName = $skin->mTitle->getText();
			$notExisting = !User::isIP( $userName );
			
			if ( !$notExisting && $ns != NS_USER_TALK ) {//anon profile page
				$msg = wfMsgExt( 'userprofilepage-user-anon', array('parse', 'content'), array( $userName ) );
			} elseif( $notExisting ) {//non-existing user
				$msg = wfMsgExt( 'userprofilepage-user-doesnt-exists', array('parse', 'content'), array( $userName ) );
			}
			
			if( $msg !== null) $template->data['bodytext'] = $msg;
		} else {
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

			if(
				$profilePage instanceof UserProfilePage &&
				!( $isUserSubpage || $isBlogPage || $ns == NS_SPECIAL || $ns == NS_USER_TALK )// don't replace page content for talk and blog page (RT: #98342, #88757) and special pages
			) {
				$article = Article::newFromID( $template->data['articleid'] );
				if( is_null( $article ) ) {
					if( $profilePage->userIsOwner() ) {
						$template->data['bodytext'] = $profilePage->get( wfMsgForContent( 'userprofilepage-empty-my-about-me-section', array( $skin->mTitle->getLocalUrl( 'action=edit' ) ) ) );
					}
					else {
						$template->data['bodytext'] = $profilePage->get( wfMsgForContent( 'userprofilepage-empty-somebodys-about-me-section', array( $profilePage->getUser()->getName(), $profilePage->getUser()->getTalkPage()->getLocalUrl( 'action=edit' ) ) ) );
					}
				}
				else {
					$template->data['bodytext'] = $profilePage->get( $template->data['bodytext'] );
				}
			}
		}
		
		// load extension css and js
		$wgOut->addStyle( wfGetSassUrl( "extensions/wikia/UserProfilePage/css/UserProfilePage.scss" ) );
		$wgOut->addScript( "<script type=\"{$wgJsMimeType}\" src=\"{$wgExtensionsPath}/wikia/UserProfilePage/js/UserProfilePage.js?{$wgStyleVersion}\" ></script>\n" );

		wfProfileOut(__METHOD__);
		return true;
	}

	public static function doAction() {
		wfProfileIn(__METHOD__);
		global $wgUser, $wgRequest;

		$result = array(
			'result' => true
		);

		$name = $wgRequest->getVal( 'name' );
		$type = $wgRequest->getVal( 'type' );
		$value = $wgRequest->getVal( 'value' );

		if( is_object( $wgUser ) && !$wgUser->isAnon() && !empty( $name ) && !empty( $type ) && !empty( $value ) ) {
			$profilePage = UserProfilePage::getInstance( $wgUser );
			$result['type'] = $type;
			$result['html'] = $profilePage->doAction( $name, $type, $value );
		}

		$json = Wikia::json_encode( $result );
		$response = new AjaxResponse( $json );
		$response->setContentType( 'application/json; charset=utf-8' );
		
		wfProfileOut(__METHOD__);
		return $response;
	}

	public static function getUserFromTitle( Title $title ) {
		wfProfileIn(__METHOD__);
		global $wgUserProfilePagesNamespaces, $wgUser;
		
		$fallbackOnGlobal = ( $title->isSpecial( 'Contributions' ) || $title->isSpecial( 'Following' ) );
		$userName = UserPagesHeaderModule::getUserName($title, $wgUserProfilePagesNamespaces , $fallbackOnGlobal );
		
		$out = ( !empty( $userName ) ) ? User::newFromName( $userName ) : false;
		
		wfProfileOut(__METHOD__);
		return $out;
	}	
	
	public static function formatLastActionMessage( $actionData ) {
		wfProfileIn(__METHOD__);
		$out = null;
		
		if( !empty( $actionData ) ) {
			$out = wfMsg( 'userprofilepage-user-last-action-' . $actionData['type'], array( wfTimeFormatAgoOnlyRecent($actionData['timestamp']), $actionData['url'], $actionData['title'] ) );
		}
		
		wfProfileOut(__METHOD__);
		return $out;
	}

	public static function onAlternateEdit( &$oEditPage ) {
		wfProfileIn(__METHOD__);
		global $wgOut, $wgUser;
		$title = $oEditPage->mTitle;
		$result = true;
		
		if( $title->getNamespace() == NS_USER ) {
			$user = self::getUserFromTitle( $title );
			
			if( !empty( $user ) && strcmp( $user->getName(), $wgUser->getName() ) != 0 ) {
				$wgOut->clearHTML();
				$wgOut->showErrorPage( 'userprofilepage-edit-permision-denied', 'userprofilepage-edit-permision-denied-info' );
				$result = false;
			}
		}
		
		wfProfileOut(__METHOD__);
		return $result;
	}
	
	static public function onGetRailModuleList(&$modules) {
		wfProfileIn(__METHOD__);
		global $wgTitle, $wgUser, $wgEnableAchievementsExt, $wgUserProfilePagesNamespaces,
			$wgEnableUserProfilePagesExt, $wgUser, $wgEnableSpotlightsV2_Rail;
		
		if ( !empty( $wgEnableUserProfilePagesExt ) && UserProfilePage::isAllowed() && !UserProfilePage::isAllowedSpecialPage()) {//no broken right rail in special pages
			foreach( $modules as $weight => $module ) {
				if( in_array( $module[0], array( 'LatestPhotos', 'LatestActivity', 'PagesOnWiki' ) ) ) {
					unset( $modules[ $weight ] );
				}
			}
			
			$userProfilePage = UserProfilePage::getInstance();
			$user = !empty( $userProfilePage ) ? $userProfilePage->getUser() : null;
			$isAnon = !empty( $user ) ? $user->isAnon() : true;
			
			if( !$isAnon ) {//no sidebar modules for anons and non-existing users
				$modules[1499] = array('UserProfileRail', 'TopWikis', null);
				$modules[1498] = array('LatestActivity', 'Index', null);
				$modules[1497] = array('UserProfileRail', 'TopPages', null);
				
				if( !$user->getOption('hidefollowedpages') ) {
					$railModuleList[1200] = array('FollowedPages', 'Index', null);
				}
				
				if($wgEnableAchievementsExt && !(($wgUser->idForName() == $user->idForName()) && $user->getOption('hidepersonalachievements'))){
					$modules[1350] = array('Achievements', 'UserProfilePagesModule', null);
				}
			}
		}
		
		wfProfileOut(__METHOD__);
		return true;
	}
}
