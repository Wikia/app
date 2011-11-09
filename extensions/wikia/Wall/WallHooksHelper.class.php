<?php

class WallHooksHelper {
	const RC_WALL_COMMENTS_MAX_LEN = 50;
	
	public function onBlockIpCompleteWatch($name, $title ) {
		$app = F::App();  
		$watchTitle = Title::makeTitle( NS_USER_WALL, $name );
		$app->wg->User->addWatch( $watchTitle );
		return true;
	}

	public function onUserIsBlockedFrom($user, $title, &$blocked, &$allowUsertalk) {
	
		if ( !$user->mHideName && $allowUsertalk && $title->getNamespace() == NS_USER_WALL_MESSAGE ) {
			$wm =  F::build('WallMessage', array($title), 'newFromTitle');
			if($wm->getWallOwner()->getName() === $user->getName()){
				$blocked = false;
				wfDebug( __METHOD__ . ": self-user wall page, ignoring any blocks\n" );
			}
		}
		
		return true;
	}
	
	public function onArticleViewHeader(&$article, &$outputDone, &$useParserCache) {
		$app = F::App();
		$helper = F::build('WallHelper', array());
		$title = $article->getTitle();
		
		if( $title->getNamespace() === NS_USER_WALL 
			&& !$title->isSubpage() 
		) {
		//message wall index
			$outputDone = true;
			$app->wg->Out->addHTML($app->renderView('WallController', 'index', array( 'title' => $article->getTitle() ) ));
		}
		
		if( $title->getNamespace() === NS_USER_WALL_MESSAGE 
			&& intval($title->getText()) > 0
		) {
			//message wall index - brick page
			$outputDone = true;
			
			$mainTitle = Title::newFromId($title->getText());
			if(empty($mainTitle)) {
				$dbkey = $helper->getDbkeyFromArticleId_forDeleted($title->getText());
				$fromDeleted = true;
			} else {
				$dbkey = $mainTitle->getDBkey();
				$fromDeleted = false;
			}
			
			if(empty($dbkey) || !$helper->isDbkeyFromWall($dbkey) ) {
				// no dbkey or not from wall, redirect to wall
				$app->wg->Out->redirect($this->getWallTitle()->getFullUrl(), 301);
				return true;
			} else {
				// article exists or existed
				if($fromDeleted) {
					$app->wg->SuppressPageHeader = true;
					$app->wg->Out->addHTML($app->renderView('WallController', 'messageDeleted', array( 'title' =>wfMsg( 'wall-deleted-msg-pagetitle' ) ) ));
					$app->wg->Out->setPageTitle( wfMsg( 'wall-deleted-msg-pagetitle' ) );
					$app->wg->Out->setHTMLTitle( wfMsg( 'errorpagetitle' ) );
				} else {
					$messageTitle = Title::newFromText($dbkey, NS_USER_WALL_MESSAGE );
					$wallMessage = F::build('WallMessage', array($messageTitle), 'newFromTitle' ); 
					$app->wg->SuppressPageHeader = true;
					$app->wg->WallBrickHeader = $title->getText();
					$app->wg->Out->addHTML($app->renderView('WallController', 'index',  array('filterid' => $title->getText(),  'title' => $wallMessage->getWallTitle() )));
				}
			}
			
			return true;
		}
		
		if( $title->getNamespace() === NS_USER_TALK 
			&& !$title->isSubpage() 
		) {
		//user talk page -> redirect to message wall
			$outputDone = true;
			
			$app->wg->request->setVal('dontGetUserFromSession', true);
			$app->wg->Out->redirect($this->getWallTitle()->getFullUrl(), 301);
			return true;
		}
		
		$parts = explode('/', $title->getText());
		
		if( $title->getNamespace() === NS_USER_TALK 
			&& $title->isSubpage() 
			&& !empty($parts[0]) 
			&& !empty($parts[1]) 
		) {
		//user talk subpage -> redirects to message wall namespace subpage
			$outputDone = true;
			
			$title = F::build('Title', array($parts[0].'/'.$parts[1], NS_USER_WALL), 'newFromText');
			$app->wg->Out->redirect($title->getFullUrl(), 301);
			return true;
		}
		
		if( $title->getNamespace() === NS_USER_WALL 
			&& $title->isSubpage() 
			&& !empty($app->wg->EnableWallExt) 
			&& !empty($parts[1])
			&& mb_strtolower(str_replace(' ', '_', $parts[1])) === mb_strtolower($helper->getArchiveSubPageText())
		) {
		//user talk archive
			$outputDone = true;
			
			$app->wg->Out->addHTML($app->renderView('WallController', 'renderOldUserTalkPage', array('wallUrl' => $this->getWallTitle()->getFullUrl())));
		} else if( $title->getNamespace() === NS_USER_WALL && $title->isSubpage() ) {
		//message wall subpage (sometimes there are old user talk subpages)
			$outputDone = true;
			
			$app->wg->Out->addHTML($app->renderView('WallController', 'renderOldUserTalkSubpage', array('subpage' => $parts[1], 'wallUrl' => $this->getWallTitle()->getFullUrl()) ));
			return true;
		}
		
		return true;
	}
	
	/**
	 * @brief Hook to change tabs on user wall page
	 * 
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	public function onSkinTemplateTabs($template, &$contentActions) {
		$app = F::App();
		
		$app->wg->request->setVal('dontGetUserFromSession', true);
		
		if( !empty($app->wg->EnableWallExt) ) {
			$helper = F::build('WallHelper', array());
			$title = $app->wg->Title;
			
			if( $title->getNamespace() === NS_USER ) {
				if( !empty($contentActions['talk']) ) {
					$contentActions['talk']['text'] = $app->wf->Msg('wall-message-wall');
					
					$userWallTitle = $this->getWallTitle();
					
					if( $userWallTitle instanceof Title ) {
						$contentActions['talk']['href'] = $userWallTitle->getLocalUrl();
					}
				}
			}
			
			if( $title->getNamespace() === NS_USER_WALL ) {
				$userPageTitle = $helper->getTitle(NS_USER);
				$contentActionsOld = $contentActions;
		
				$contentActions = array();
				
				if($app->wg->User->getName() != $title->getBaseText() && !$title->isSubpage()){
					if(isset($contentActionsOld['watch'])){
						$contentActions['watch'] = $contentActionsOld['watch'];
					}
					
					if(isset($contentActionsOld['unwatch'])){
						$contentActions['unwatch'] = $contentActionsOld['unwatch'];
					}
				}
				
				if( $userPageTitle instanceof Title ) {
					$contentActions['user-profile'] = array(
						'class' => false,
						'href' => $userPageTitle->getLocalUrl(),
						'text' => $app->wf->Msg('user-page'), 
					);
				}
				
				$contentActions['message-wall'] = array(
					'class' => 'selected',
					'href' => $title->getLocalUrl(),
					'text' => $app->wf->Msg('wall-message-wall'),
				);
			}
			
			if( $title->getNamespace() === NS_USER_WALL && $title->isSubpage() ) {
				$userTalkPageTitle = $helper->getTitle(NS_USER_TALK);
				
				$contentActions['view-source'] = array(
					'class' => false,
					'href' => $userTalkPageTitle->getLocalUrl(array('action' => 'edit')),
					'text' => $app->wf->Msg('user-action-menu-view-source'), 
				);
				
				$contentActions['history'] = array(
					'class' => false,
					'href' => $userTalkPageTitle->getLocalUrl(array('action' => 'history')),
					'text' => $app->wf->Msg('user-action-menu-history'),
				);
			}
		}
		
		return true;
	}
	
	/**
	 * @brief Redirects any attempts of editing anything in NS_USER_WALL namespace
	 * 
	 * @return true
	 * 
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	public function onAlternateEdit($editPage) {
		$this->doSelfRedirect();
		
		return true;
	}
	
	/**
	 * @brief Redirects any attempts of viewing history of any page in NS_USER_WALL namespace
	 * 
	 * @return true
	 * 
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	public function onBeforePageHistory($article) {
		$this->doSelfRedirect();
		
		return true;
	}
	
	/**
	 * @brief Redirects any attempts of protecting any page in NS_USER_WALL namespace
	 * 
	 * @return true
	 * 
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	public function onBeforePageProtect($article) {
		$this->doSelfRedirect();
		
		return true;
	}
	
	/**
	 * @brief Redirects any attempts of unprotecting any page in NS_USER_WALL namespace
	 * 
	 * @return true
	 * 
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	public function onBeforePageUnprotect($article) {
		$this->doSelfRedirect();
		
		return true;
	}
	
	/**
	 * @brief Redirects any attempts of deleting any page in NS_USER_WALL namespace
	 * 
	 * @return true
	 * 
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	public function onBeforePageDelete($article) {
		$this->doSelfRedirect();
		
		return true;
	}
	
	/**
	 * @brief Changes "My talk" to "Message wall" in the user links.
	 * 
	 * @return true
	 * 
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	public function onPersonalUrls($personalUrls, $title) {
		$app = F::App();
		
		F::build('JSMessages')->enqueuePackage('Wall', JSMessages::EXTERNAL);
		
		//if( !empty($personalUrls['mytalk']) ) {
		//	unset($personalUrls['mytalk']);
		//}
		
		
		if($app->wg->User->isLoggedIn()) {
			$userWallTitle = $this->getWallTitle();	
			if( $userWallTitle instanceof Title ) {
				$personalUrls['mytalk']['href'] = $userWallTitle->getLocalUrl();
			}
			$personalUrls['mytalk']['text'] = $app->wf->Msg('wall-message-wall');
			if($app->wg->User->getSkin()->getSkinName() == 'monobook') {
				$personalUrls['wall-notifications'] = array(
					'text'=>$app->wf->Msg('wall-notifications'),
					//'text'=>print_r($app->wg->User->getSkin(),1),
					'href'=>'#',
					'class'=>'wall-notifications-monobook',
					'active'=>false
				);
				$app->wg->Out->addScript("<script type=\"{$app->wg->JsMimeType}\" src=\"/skins/common/jquery/jquery.timeago.js?{$app->wg->StyleVersion}\"></script>\n");
				$app->wg->Out->addScript("<link rel=\"stylesheet\" type=\"text/css\" href=\"{$app->wg->ExtensionsPath}/wikia/Wall/css/WallNotificationsMonobook.css?{$app->wg->StyleVersion}\" />\n");
				$app->wg->Out->addScript("<script type=\"{$app->wg->JsMimeType}\" src=\"{$app->wg->ExtensionsPath}/wikia/Wall/js/WallNotifications.js?{$app->wg->StyleVersion}\"></script>\n");
			}
		}
		
		return true;
	}
	
	/**
	 * @brief Changes "My talk" to "Message wall" in Oasis (in the tabs on the User page).
	 * 
	 * @return true
	 * 
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	public function onUserPagesHeaderModuleAfterGetTabs($tabs, $namespace, $userName) {
		$app = F::App();
		
		$app->wg->request->setVal('dontGetUserFromSession', true);
		
		foreach($tabs as $key => $tab) {
			if( !empty($tab['data-id']) && $tab['data-id'] === 'talk' ) {
				$userWallTitle = $this->getWallTitle();
				
				if( $userWallTitle instanceof Title ) {
					$tabs[$key]['link'] = '<a href="'.$userWallTitle->getLocalUrl().'" title="'.$app->wf->Msg('wall-tab-wall-title').$userName.'">'.$app->wf->Msg('wall-message-wall').'</a>';
					$tabs[$key]['data-id'] = 'wall';
					
					if( $namespace === NS_USER_WALL ) {
						$tabs[$key]['selected'] = true;
					}
				}
				
				break;
			}
		}
		
		return true;
	}
	
	/**
	 * @brief Remove Message Wall:: from back link
	 * 
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	public function onSkinSubPageSubtitleAfterTitle($title, &$ptext, &$cssClass) {
		if( !empty($title) && $title->getNamespace() == NS_USER_WALL) {
			$ptext = $title->getText();
			$cssClass = 'back-user-wall';
		}
		
		return true;
	}
	
	/**
	 * @brief Adds an action button on user talk archive page
	 * 
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	public function onPageHeaderIndexAfterActionButtonPrepared($action, $dropdown, $ns, $skin) {
		$app = F::App();
		$helper = F::build('WallHelper', array());
		
		if( !empty($app->wg->EnableWallExt) ) {
			$title = $app->wg->Title;
			$parts = explode( '/', $title->getText() );
			
			if( $title->getNamespace() === NS_USER_WALL 
				&& $title->isSubpage() 
				&& !empty($parts[1]) 
				&& mb_strtolower(str_replace(' ', '_', $parts[1])) === mb_strtolower($helper->getArchiveSubPageText()) 
			) {
			//user talk archive
				$userTalkPageTitle = $helper->getTitle(NS_USER_TALK);
				
				$action = array(
					'class' => '',
					'text' => $app->wf->Msg('viewsource'),
					'href' => $userTalkPageTitle->getLocalUrl(array('action' => 'edit')), 
				);
				
				$dropdown = array(
					'history' => array(
						'href' => $userTalkPageTitle->getLocalUrl(array('action' => 'history')),
						'text' => $app->wf->Msg('history_short'),
					),
				);
			}
			
			if( $title->getNamespace() === NS_USER_WALL 
				&& $title->isSubpage() 
				&& !empty($parts[1]) 
				&& mb_strtolower(str_replace(' ', '_', $parts[1])) !== mb_strtolower($helper->getArchiveSubPageText()) 
			) {
			//subpage
				$userTalkPageTitle = $helper->getTitle(NS_USER_TALK, $parts[1]);
				
				$action = array(
					'class' => '',
					'text' => $app->wf->Msg('viewsource'),
					'href' => $userTalkPageTitle->getLocalUrl(array('action' => 'edit')), 
				);
				
				$dropdown = array(
					'history' => array(
						'href' => $userTalkPageTitle->getLocalUrl(array('action' => 'history')),
						'text' => $app->wf->Msg('history_short'),
					),
				);
			}
			
			$canEdit = $app->wg->User->isAllowed('editwallarchivedpages');
			
			if( $canEdit ) {
				$action['text'] = $app->wf->Msg('edit');
				$action['id'] = 'talkArchiveEditButton';
			}
		}
		
		return true;
	}
	
	/**
	 * @brief Redirects to current title if it is in NS_USER_WALL namespace
	 * 
	 * @return void
	 * 
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	protected function doSelfRedirect() {
		$app = F::App();
		$title = $app->wg->Title;
		
		if($app->wg->Request->getVal('action') == 'history' || $app->wg->Request->getVal('action') == 'historysubmit') {
			return true;
		}
		
		if( $title->getNamespace() === NS_USER_WALL ) {
			$app->wg->Out->redirect($title->getLocalUrl(), 301);
			$app->wg->Out->enableRedirects(false);
		}
		
		if( $title->getNamespace() === NS_USER_WALL_MESSAGE ) {
			$parts = explode( '/', $title->getText() );
		
			$title = F::build('Title', array($parts[0], NS_USER_WALL), 'newFromText');
			$app->wg->Out->redirect($title->getFullUrl(), 301);
			$app->wg->Out->enableRedirects(false);
		}
	}
	
	/**
	 * @brief Returns message wall title if any
	 * 
	 * @author Andrzej 'nAndy' Łukaszewski
	 * 
	 * @return Title | null
	 */
	protected function getWallTitle() {
		$helper = F::build('WallHelper', array());
		$app = F::app();
		
		$userFromSession = !$app->wg->request->getVal('dontGetUserFromSession', false);
		
		if( $userFromSession ) {
			return $helper->getTitle(NS_USER_WALL, null, $app->wg->User);
		} else {
			return $helper->getTitle(NS_USER_WALL);
		}
	}
	
	public function onRecentChangeSave( $recentChange ){
		wfProfileIn( __METHOD__ );
		// notifications
		if( $recentChange->getAttribute('rc_type') == RC_NEW && $recentChange->getAttribute('rc_namespace') == NS_USER_WALL_MESSAGE) { 
			$wn = F::build('WallNotifications', array() );
			$wn->addNotification( $recentChange );
		}

		wfProfileOut( __METHOD__ );
		return true;
	}
	
	public function onArticleCommentBeforeWatchlistAdd($comment){
		if($comment->getTitle()->getNamespace() == NS_USER_WALL_MESSAGE ){
			$parentTitle = $comment->getTopParentObj();
			if(!empty($parentTitle)) {
				$comment->mUser->addWatch( $parentTitle->getTitle() );
			} else {
				$comment->mUser->addWatch( $comment->getTitle() );
			}
			return false;
		}
		return true;
	}
	
	/**
	 * @brief Allows to edit or not archived talk pages and its subpages
	 * 
	 * @author Andrzej 'nAndy' Łukaszewski
	 * 
	 * @return boolean true -- because it's a hook
	 */
	public function onAfterEditPermissionErrors($permErrors, $title, $removeArray) {
		$app = F::App();
		$canEdit = $app->wg->User->isAllowed('editwallarchivedpages');
		
		if( !empty($app->wg->EnableWallExt) 
			&& defined('NS_USER_TALK') 
			&& $title->getNamespace() == NS_USER_TALK 
			&& !$canEdit 
		) {
			$permErrors[] = array(
				0 => 'protectedpagetext',
				1 => 'archived'
			);
		}
		
		return true;
	}
	
	/**
	 * @brief Just adjusting links and removing history from brick pages (My Tools bar)
	 * 
	 * @param array $contentActions passed by reference array with anchors elements
	 * 
	 * @return true because this is a hook
	 */
	public function onSkinTemplateContentActions($contentActions) {
		$app = F::app();
		
		if( !empty($app->wg->EnableWallExt) && $app->wg->Title instanceof Title ) {
			$title = $app->wg->Title;
			$parts = explode( '/', $title->getText() );
			$helper = F::build('WallHelper', array());
		}
		
		if( $title instanceof Title
			&& $title->getNamespace() == NS_USER_WALL
			&& $title->isSubpage() === true
			&& mb_strtolower(str_replace(' ', '_', $parts[1])) !== mb_strtolower($helper->getArchiveSubPageText()) 
		) {
		//remove "History" and "View source" tabs in Monobook & don't show history in "My Tools" in Oasis
		//because it leads to Message Wall (redirected) and a user could get confused
			if( isset($contentActions['history']['href']) ) {
				//$contentActions['history']['href'] = $this->getWallTitle()->getLocalUrl('action=history');
				unset($contentActions['history']);
			}
				
			if( isset($contentActions['view-source']['href']) ) {
				//$contentActions['view-source']['href'] = $this->getWallTitle()->getLocalUrl('action=edit');
				unset($contentActions['view-source']);
			}
		}
		
		return true;
	}
	
	/**
	 * @brief Adjusting recent changes for Wall 
	 * 
	 * @desc This method doesn't let display flags for message wall replies (they are displayed only for messages from message wall)
	 * 
	 * @param ChangesList $list
	 * @param string $flags
	 * @param RecentChange $rc
	 * 
	 * @return true because this is a hook
	 * 
	 * @author Andrzej 'nAndy' Lukaszewski
	 */
	public function onChangesListInsertFlags($list, $flags, $rc) {
		if( $rc->getAttribute('rc_type') == RC_NEW && $rc->getAttribute('rc_namespace') == NS_USER_WALL_MESSAGE ) {
			$app = F::app();
			$wnEntity = F::build('WallNotificationEntity', array($rc->getAttribute('rev_id'), $app->wg->CityId), 'getByWikiAndRevId');
			
			if( !empty($wnEntity->data->parent_id) ) {
			//we don't need flags if this is a reply on a message wall
				$flags = '';
			}
		}
		
		return true;
	}
	
	/**
	 * @brief Adjusting recent changes for Wall 
	 * 
	 * @desc This method shows link to message wall thread page
	 * 
	 * @param ChangesList $list
	 * @param string $articleLink
	 * @param string $s
	 * @param RecentChange $rc
	 * @param boolean $unpatrolled
	 * @param boolean $watched
	 * 
	 * @return true because this is a hook
	 * 
	 * @author Andrzej 'nAndy' Lukaszewski
	 */
	public function onChangesListInsertArticleLink($list, $articleLink, $s, $rc, $unpatrolled, $watched) {
		if(($rc->getAttribute('rc_type') == RC_NEW || $rc->getAttribute('rc_type') == RC_EDIT) && $rc->getAttribute('rc_namespace') == NS_USER_WALL_MESSAGE ) {
			$app = F::app();
			
			$wnEntity = F::build('WallNotificationEntity', array($rc->getAttribute('rc_this_oldid'), $app->wg->CityId), 'getByWikiAndRevId');
			$messageWallPage = F::build('Title', array(NS_USER_WALL, $wnEntity->data->wall_username), 'makeTitle');
			
			$link = $wnEntity->data->url;
			$title = $wnEntity->data->thread_title;
			$class = '';
			
			$articleLink = '<a href="'.$link.'" class="'.$class.'" >'.$title.'</a> '.$app->wf->Msg('wall-recentchanges-article-link-new-message', array($messageWallPage->getFullUrl(), $messageWallPage->getText()));
			# Bolden pages watched by this user
			if( $watched ) {
				$articleLink = '<strong class="mw-watched">'.$articleLink.'</strong>';
			}
			
			# RTL/LTR marker
			$articleLink .= $app->wg->ContLang->getDirMark();
		}
		
		return true;
	}
	
	/**
	 * @brief Adjusting recent changes for Wall 
	 * 
	 * @desc This method doesn't let display diff history links
	 * 
	 * @param ChangesList $list
	 * @param string $articleLink
	 * @param string $s
	 * @param RecentChange $rc
	 * @param boolean $unpatrolled
	 * 
	 * @return true because this is a hook
	 * 
	 * @author Andrzej 'nAndy' Lukaszewski
	 */
	public function onChangesListInsertDiffHist($list, $articleLink, $s, $rc, $unpatrolled) {
		if( !empty($rc->mAttribs['rc_namespace']) && $rc->mAttribs['rc_namespace'] == NS_USER_WALL_MESSAGE ) {
			$s = '';
		}
		
		return true;
	}
	
	/**
	 * @brief Adjusting recent changes for Wall 
	 * 
	 * @desc This method doesn't let display rollback link for message wall inputs
	 * 
	 * @param ChangesList $list
	 * @param string $s
	 * @param string $rollbackLink
	 * @param RecentChange $rc
	 * 
	 * @return true because this is a hook
	 * 
	 * @author Andrzej 'nAndy' Lukaszewski
	 */
	public function onChangesListInsertRollback($list, $s, $rollbackLink, $rc) {
		if( !empty($rc->mAttribs['rc_namespace']) && $rc->mAttribs['rc_namespace'] == NS_USER_WALL_MESSAGE ) {
			$rollbackLink = '';
		}
		
		return true;
	}
	
	/**
	 * @brief Adjusting recent changes for Wall 
	 * 
	 * @desc This method creates comment to a recent change line
	 * 
	 * @param ChangesList $list
	 * @param string $comment
	 * @param string $s
	 * @param RecentChange $rc
	 * 
	 * @return true because this is a hook
	 * 
	 * @author Andrzej 'nAndy' Lukaszewski
	 */
	public function onChangesListInsertComment($list, $comment, $s, $rc) {
		if(($rc->getAttribute('rc_type') == RC_NEW || $rc->getAttribute('rc_type') == RC_EDIT) && $rc->getAttribute('rc_namespace') == NS_USER_WALL_MESSAGE ) {
			$app = F::app();
			$wnEntity = F::build('WallNotificationEntity', array($rc->getAttribute('rc_this_oldid'), $app->wg->CityId), 'getByWikiAndRevId');
			
			//this is innocent hack -- we didn't know where char(127) came from in rc_params
			//but it stopped us from unserializing rc_params if anyone knows where those chars 
			//comes from please fix all rc_params and remove trim() function from below
			$params = json_decode(trim($rc->getAttribute('rc_params'), chr(127)));
			if( empty($params->intro) ) {
				$content = '';
			} else {
				$wh = F::build('WallHelper', array());
				$content = $wh->shortenText($params->intro, self::RC_WALL_COMMENTS_MAX_LEN);
			}
			
			if( empty($wnEntity->data->parent_id) ) {
				$link = $wnEntity->data->url;
				$link = '<a href="'.$link.'">'.$app->wf->Msg('wall-user-wall-link-text', array($wnEntity->data->wall_username)).'</a>';
				
				$comment = ($rc->getAttribute('rc_type') == RC_NEW) ? $app->wf->Msg('wall-recentchanges-comment-new-message', array($content)) : $app->wf->Msg('wall-recentchanges-edit');
			} else {
				$comment = ($rc->getAttribute('rc_type') == RC_NEW) ? $app->wf->Msg('wall-recentchanges-new-reply', array($content)) : $app->wf->Msg('wall-recentchanges-edit');
			}
			
			$comment = ' <span class="comment">'.$comment.'</span>';
		}
		
		return true;
	}
	
	/**
	 * @brief Adjusting recent changes for Wall 
	 * 
	 * @desc This method creates comment about deleted/restored message from message wall
	 * 
	 * @param ChangesList $list
	 * @param string $actionText
	 * @param string $s
	 * @param RecentChange $rc
	 * 
	 * @return true because this is a hook
	 * 
	 * @author Andrzej 'nAndy' Lukaszewski
	 */
	public function onChangesListInsertAction($list, $actionText, $s, $rc) {
		if( $rc->getAttribute('rc_type') == RC_LOG 
		 && $rc->getAttribute('rc_namespace') == NS_USER_WALL_MESSAGE 
		 && ($rc->getAttribute('rc_log_action') == 'delete' || $rc->getAttribute('rc_log_action') == 'restore') ) {
		 	$app = F::app();
			$helper = F::build('WallHelper', array());
			$userText = $rc->getAttribute('rc_user_text');
			$wallTitleObj = F::build('Title', array($userText, NS_USER_WALL), 'newFromText');
			$wallUrl = ($wallTitleObj instanceof Title) ? $wallTitleObj->getLocalUrl() : '#';
			$rcTitle = $rc->getTitle();
			
			if( !($rcTitle instanceof Title) ) {
			//in theory it shouldn't happen but it did once on my devbox
			//and I couldn't reproduce it and trac why it had happened
				Wikia::log(__METHOD__, false, "WALL_NOTITLE_FROM_RC " . print_r($rc, true));
				return true;
			}
			
			$articleData = array('text_id' => '');
			$articleId = $helper->getDeletedArticleId($rcTitle->getText(), $articleData);
			
			if( !empty($articleId) ) {
			//the thread/reply was deleted
			//but in RC the entry can be about
			//its deletion or restoration
				$articleTitleObj = F::build('Title', array($userText.'/'.$articleId, NS_USER_WALL), 'newFromText');
				$articleTitleTxt = $helper->getTitleTxtFromMetadata($helper->getDeletedArticleTitleTxt($articleData['text_id']));
				
				if( empty($articleTitleTxt) ) {
				//reply
					$articleTitleTxt = $this->getParentTitleTxt($rcTitle);
					
					$wm = F::build('WallMessage', array($rcTitle));
					$wmParent = $wm->getTopParentObj();
					$articleUrl = $wmParent->getMessagePageUrl();
					$articleUrl = !empty($articleUrl) ? $articleUrl : '#';
					$isThread = false;
				} else {
				//thread
					$articleUrl = ($articleTitleObj instanceof Title) ? $articleTitleObj->getLocalUrl() : '#';
					$isThread = true;
				}
			} else {
			//the thread/reply was restored
			//but in RC the entry can be about
			//its deletion or restoration
				$parts = explode('/@', $rcTitle->getText());
				$isThread = ( count($parts) === 2 ) ? true : false;
				
				$articleTitleTxt = $this->getParentTitleTxt($rcTitle);
				$wm = F::build('WallMessage', array($rcTitle));
				$articleUrl = $wm->getMessagePageUrl();
				$articleUrl = !empty($articleUrl) ? $articleUrl : $rcTitle->getFullUrl();
			}
			
			$wfMsgOpts = array(
				$articleUrl,
				$articleTitleTxt,
				$wallUrl,
				$userText,
			);
			
			if( $isThread ) {
				if( $rc->getAttribute('rc_log_action') == 'delete' ) {
				//deleted thread page
					$actionText = $app->wf->Msg('wall-recentchanges-deleted-thread', $wfMsgOpts);
				}
				
				if( $rc->getAttribute('rc_log_action') == 'restore' ) {
				//restored thread page
					$actionText = $app->wf->Msg('wall-recentchanges-restored-thread', $wfMsgOpts);
				}
			} else {
				if( $rc->getAttribute('rc_log_action') == 'delete' ) {
				//deleted reply
					$actionText = $app->wf->Msg('wall-recentchanges-deleted-reply', $wfMsgOpts);
				}
				
				if( $rc->getAttribute('rc_log_action') == 'restore' ) {
				//restored reply
					$actionText = $app->wf->Msg('wall-recentchanges-restored-reply', $wfMsgOpts);
				}
			}
		}
		
		return true;
	}
	
	/**
	 * @brief Getting the title of a message
	 * 
	 * @desc Callback method used in WallHooksHelper::onChangesListInsertAction() hook if deleted message was a reply
	 * 
	 * @param string $title
	 * 
	 * @return string
	 * 
	 * @author Andrzej 'nAndy' Lukaszewski
	 */
	private function getParentTitleTxt($title) {
		if( $title instanceof Title ) {
			$app = F::app();
			$helper = F::build('WallHelper', array());

			$wm = F::build('WallMessage', array($title));
			$parentTitleTxt = $wm->getTopParentText($title->getText());
			
			$articleData = array('text_id' => '');
			$articleId = $helper->getDeletedArticleId($parentTitleTxt, $articleData);
			if( !empty($articleId) ) {
			//parent article was deleted as well
				$articleTitleTxt = $helper->getTitleTxtFromMetadata($helper->getDeletedArticleTitleTxt($articleData['text_id']));
			} else {
				$title = F::build('Title', array($parentTitleTxt, NS_USER_WALL_MESSAGE), 'newFromText');
				
				if( $title instanceof Title ) {
					$parentWallMsg = F::build('WallMessage', array($title));
					$parentWallMsg->load(true);
					$articleTitleTxt = $parentWallMsg->getMetaTitle();
				} else {
					$articleTitleTxt = $app->wf->Msg('wall-recentchanges-deleted-reply-title');
				}
			}
			$articleTitleTxt = empty($articleTitleTxt) ? $app->wf->Msg('wall-recentchanges-deleted-reply-title') : $articleTitleTxt;
			
			return $articleTitleTxt;
		}
		
		return $app->wf->Msg('wall-recentchanges-deleted-reply-title');
	}
	
	/**
	 * @brief Adjusting recent changes for Wall 
	 * 
	 * @desc This method decides rather put a log information about deletion or not
	 * 
	 * @param Article $article a referance to Article instance
	 * @param LogPage $logPage a referance to LogPage instance
	 * @param string $logType a referance to string with type of log
	 * @param Title $title
	 * @param string $reason
	 * @param boolean $hookAddedLogEntry set it to true if you don't want Article::doDeleteArticle() to add a log entry
	 * 
	 * @return true because this is a hook
	 * 
	 * @author Andrzej 'nAndy' Lukaszewski
	 */
	public function onArticleDoDeleteArticleBeforeLogEntry($article, $logPage, $logType, $title, $reason, $hookAddedLogEntry) {
		if( $title instanceof Title && $title->getNamespace() == NS_USER_WALL_MESSAGE ) {
			$app = F::app();
			$wm = F::build('WallMessage', array($title));
			$parentObj = $wm->getTopParentObj();
			$reason = ''; //we don't want any comment
			
			if( empty($parentObj) ) {
			//thread message
				$logPage->addEntry( 'delete', $title, $reason, array() );
			} else {
			//reply
				$parentObj->load(true);
				
				if( !$parentObj->getTitle()->isDeletedQuick() ) {
				//if its parent still exists only this reply is being deleted, so log about it
					$logPage->addEntry( 'delete', $title, $reason, array() );
				}
			}
			
			$hookAddedLogEntry = true;
		}
		
		return true;
	}
	
	/**
	 * @brief Adjusting recent changes for Wall 
	 * 
	 * @desc This method decides rather put a log information about restored article or not
	 * 
	 * @param PageArchive $pageArchive a referance to Article instance
	 * @param LogPage $logPage a referance to LogPage instance
	 * @param Title $title a referance to Title instance
	 * @param string $reason
	 * @param boolean $hookAddedLogEntry set it to true if you don't want Article::doDeleteArticle() to add a log entry
	 * 
	 * @return true because this is a hook
	 * 
	 * @author Andrzej 'nAndy' Lukaszewski
	 */
	public function onPageArchiveUndeleteBeforeLogEntry($pageArchive, $logPage, $title, $reason, $hookAddedLogEntry) {
		if( $title instanceof Title && $title->getNamespace() == NS_USER_WALL_MESSAGE ) {
			$app = F::app();
			$wm = F::build('WallMessage', array($title));
			$parentObj = $wm->getTopParentObj();
			$reason = ''; //we don't want any comment
			
			if( empty($parentObj) ) {
			//thread message
				$logPage->addEntry( 'restore', $title, $reason, array() );
			} else {
			//reply
				$parentObj->load(true);
				
				if( !$parentObj->getTitle()->isDeletedQuick() ) {
				//if its parent still exists only this reply is being restored, so log about it
					$logPage->addEntry( 'restore', $title, $reason, array() );
				}
			}
			
			$hookAddedLogEntry = true;
		}
		
		return true;
	}
	
	/**
	 * @brief Adjusting select box with namespaces on RecentChanges page
	 * 
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	public function onXmlNamespaceSelectorAfterGetFormattedNamespaces($namespaces, $selected, $all, $element_name, $label) {
		if( defined('NS_USER_WALL') && defined('NS_USER_WALL_MESSAGE') ) {
			if( isset($namespaces[NS_USER_WALL]) && isset($namespaces[NS_USER_WALL_MESSAGE]) ) {
				unset($namespaces[NS_USER_WALL], $namespaces[NS_USER_WALL_MESSAGE]);
				$namespaces[NS_USER_WALL_MESSAGE] = F::app()->wf->Msg('wall-recentchanges-namespace-selector-message-wall');
			}
		}
		
		return true;
	}
	
	/**
	 * @brief Changing all links to Message Wall to blue links
	 * 
	 * @param Title $title
	 * @param boolean $result
	 * 
	 * @return true -- because it's a hook
	 * 
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	public function onLinkBegin($skin, $target, $text, $customAttribs, $query, $options, $ret) {
		// paranoia
		if( !($target instanceof Title) ) {
			return true;
		}
		
		$namespace = $target->getNamespace();
		if( !empty(F::app()->wg->EnableWallExt) && ($namespace == NS_USER_WALL || $namespace == NS_USER_WALL_MESSAGE) ) {
			// remove "broken" assumption/override
			$brokenKey = array_search('broken', $options);
			if ( $brokenKey !== false ) {
				unset($options[$brokenKey]);
			}
		
			// make the link "blue"
			$options[] = 'known';
		}
	
		return true;
	}
	
	/**
	 * getUserPermissionsErrors -  control access to articles in the namespace NS_USER_WALL_MESSAGE_GREETING
	 *
	 * @author Tomek Odrobny
	 *
	 * @access public
	 */
	public function onGetUserPermissionsErrors( &$title, &$user, $action, &$result ) {
		
		if( $title->getNamespace() == NS_USER_WALL_MESSAGE_GREETING ) {
			$result = array();
			
			$parts = explode('/', $title->getText());
			$username = empty($parts[0]) ? '':$parts[0]; 
			
			if( $user->isAllowed('walledit') || $user->getName() == $username   ) {
				$result = null;
				return true;
			} else {
				$result = array('badaccess-group0');
				return false;
			}
		}
		$result = null;
		return true;
	}
	
	
	public function onComposeCommonBodyMail($title, &$keys, &$body, $editor) {
		return true;
	} 
	
	public function onArticleSaveComplete($article, $user, $text, $summary, $minoredit, $watchthis, $sectionanchor, $flags, $revision, $status, $baseRevId) {
		$app = F::app();
		$title = $article->getTitle();
		
		if( !empty($app->wg->EnableWallExt) 
		 && $title instanceof Title 
		 && $title->getNamespace() === NS_USER_TALK 
		 && !$title->isSubpage() ) 
		{
		//user talk page was edited -> redirect to user talk archive
			$helper = F::build('WallHelper', array());
			
			$app->wg->request->setVal('dontGetUserFromSession', true);
			$app->wg->Out->redirect($this->getWallTitle()->getFullUrl().'/'.$helper->getArchiveSubPageText(), 301);
			$app->wg->Out->enableRedirects(false);
		}
		
		return true;
	}
	
}
?>
