<?php
class WallHooksHelper {
	const RC_WALL_COMMENTS_MAX_LEN = 50;
	
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
		
		$parts = explode( '/', $title->getText() );
		
		if( $title->getNamespace() == NS_USER_WALL_MESSAGE && !empty($parts[1]) ) {
			// thread / message link in form of @comment-username-number
			// needs converting to articleId
			$articleId = $title->getArticleId();
			if($articleId == 0) {
				$articleId = $helper->getDeletedArticleId($title->getText());
			}
			$title = F::build('Title', array($parts[0].'/'.$articleId, NS_USER_WALL), 'newFromText');
			$app->wg->Out->redirect($title->getFullUrl(), 301);
			$app->wg->Out->enableRedirects(false);
			return true;
			
		}
		
		if( $title->getNamespace() == NS_USER_WALL_MESSAGE && !$title->isSubpage() ) {
			// is someone trying to use this namespace as talk page?
			
			$this->doSelfRedirect();
			return true;
		}
		
		if( $title->getNamespace() === NS_USER_WALL 
			&& $title->isSubpage() 
			&& !empty($parts[1]) 
			&& intval($parts[1]) > 0
		) {
		//message wall index - brick page
			$outputDone = true;
			
			// ugly hack to check if article comment still exists
			$ac = ArticleComment::newFromId($parts[1]);
			//$title = F::build('Title', array($parts[0], NS_USER_WALL), 'newFromText' );
			if(!empty($ac) ) {
				$app->wg->SuppressPageHeader = true;
				$app->wg->WallBrickHeader = $parts[1];
				$app->wg->Out->addHTML($app->renderView('WallController', 'index',  array('filterid' => $parts[1],  'title' => $title)));
			} else {
				$app->wg->SuppressPageHeader = true;
				$app->wg->Out->addHTML($app->renderView('WallController', 'messageDeleted', array( 'title' =>wfMsg( 'wall-deleted-msg-pagetitle' ) ) ));
				$app->wg->Out->setPageTitle( wfMsg( 'wall-deleted-msg-pagetitle' ) );
				$app->wg->Out->setHTMLTitle( wfMsg( 'errorpagetitle' ) );
				//$app->wg->Out->showErrorPage( 'wall-deleted-msg-pagetitle', 'wall-deleted-msg-text', array( '$1'=>'<a href="/Message_Wall:USERNAME">USERNAME\'s Wall</a>') );
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
				
				$contentActions = array();
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
	 * @brief Changes "My talk" to "Message wall" in Monobook
	 * 
	 * @return true
	 * 
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	public function onPersonalUrls($personalUrls, $title) {
		$app = F::App();
		
		F::build('JSMessages')->enqueuePackage('Wall', JSMessages::EXTERNAL);
		
		$personalUrls['mytalk']['text'] = $app->wf->Msg('wall-message-wall');
		
		$userWallTitle = $this->getWallTitle();
		
		if( $userWallTitle instanceof Title ) {
			$personalUrls['mytalk']['href'] = $userWallTitle->getLocalUrl();
		}
		
		if($app->wg->User->isLoggedIn()) {
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
			}
			$app->wg->Out->addScript("<script type=\"{$app->wg->JsMimeType}\" src=\"{$app->wg->ExtensionsPath}/wikia/Wall/js/WallNotifications.js?{$app->wg->StyleVersion}\"></script>\n");
		}
		
		return true;
	}
	
	/**
	 * @brief Changes "My talk" to "Message wall" in Oasis
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
			$wnEntity = F::build('WallNotificationEntity', array($rc->getAttribute('rc_id'), $app->wg->CityId), 'getByWikiAndRCId');
			
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
			
			$wnEntity = F::build('WallNotificationEntity', array($rc->getAttribute('rc_id'), $app->wg->CityId), 'getByWikiAndRCId');
			$messageWallPage = F::build('Title', array(NS_USER_WALL, $wnEntity->data->parent_username), 'makeTitle');
			
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
			$wnEntity = F::build('WallNotificationEntity', array($rc->getAttribute('rc_id'), $app->wg->CityId), 'getByWikiAndRCId');
			
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
	 * @desc This method creates comment about deleted messages from message wall
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
		if( $rc->getAttribute('rc_type') == RC_LOG && $rc->getAttribute('rc_namespace') == NS_USER_WALL_MESSAGE ) {
			$app = F::app();
			$helper = F::build('WallHelper', array());
			$userText = $rc->getAttribute('rc_user_text');
			
			$articleId = $helper->getDeletedArticleId($rc->getTitle()->getText());
			$articleTitleObj = F::build('Title', array($userText.'/'.$articleId, NS_USER_WALL), 'newFromText');
			
			$wallTitleObj = F::build('Title', array(NS_USER_WALL, $userText), 'newFromText');
			$wallUrl = ($wallTitleObj instanceof Title) ? $wallTitleObj->getLocalUrl() : '#';
			$articleUrl = ($articleTitleObj instanceof Title) ? $articleTitleObj->getLocalUrl() : '#';
			
			$actionText = $app->wf->Msg('wall-recentchanges-delete', array(
				$articleUrl,
				$articleTitleTxt,
				$wallUrl,
				$userText,
			));
		}
		
		return true;
	}
	
}
?>