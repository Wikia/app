<?php
class WallHooksHelper {
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
		
		if( $title->getNamespace() === NS_USER_WALL 
			&& $title->isSubpage() 
			&& !empty($parts[1]) 
			&& intval($parts[1]) > 0 
		) {
		//message wall index - brick page
			$outputDone = true;
			
			$title = F::build('Title', array($parts[0], NS_USER_WALL), 'newFromText' );
			$app->wg->SuppressPageHeader = true;
			$app->wg->WallBrickHeader = $parts[1];
			$app->wg->Out->addHTML($app->renderView('WallController', 'index',  array('filterid' => $parts[1],  'title' => $title)));
			
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
			$personalUrls['wall-notifications'] = array(
				'text'=>$app->wf->Msg('wall-notifications'),
				'href'=>'#',
				'class'=>'wall-notifications-monobook',
				'active'=>false
			);
			$app->wg->Out->addScript("<script type=\"{$app->wg->JsMimeType}\" src=\"{$app->wg->ExtensionsPath}/wikia/Wall/js/WallNotifications.js?{$app->wg->StyleVersion}\"></script>\n");
			$app->wg->Out->addScript("<script type=\"{$app->wg->JsMimeType}\" src=\"/skins/common/jquery/jquery.timeago.js?{$app->wg->StyleVersion}\"></script>\n");
			$app->wg->Out->addScript("<link rel=\"stylesheet\" type=\"text/css\" href=\"{$app->wg->ExtensionsPath}/wikia/Wall/css/WallNotificationsMonobook.css?{$app->wg->StyleVersion}\" />\n");
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
	 * @brief Remove User:: from back link
	 * 
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	public function onSkinSubPageSubtitleAfterTitle($title, &$ptext) {
		if( !empty($title) && $title->getNamespace() == NS_USER_WALL) {
			$ptext = $title->getText();
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
}
?>