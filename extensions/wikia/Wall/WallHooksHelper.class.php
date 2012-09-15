<?php

class WallHooksHelper {
	const RC_WALL_COMMENTS_MAX_LEN = 50;
	const RC_WALL_SECURENAME_PREFIX = 'WallMessage_';
	private $rcWallActionTypes = array('wall_remove', 'wall_restore', 'wall_admindelete', 'wall_archive', 'wall_reopen');

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
		wfProfileIn(__METHOD__);

		$app = F::App();
		$helper = F::build('WallHelper', array());
		$title = $article->getTitle();

		if( $title->getNamespace() === NS_USER_WALL
				&& !$title->isSubpage()
		) {
			//message wall index
			$outputDone = true;
			$action = $app->wg->request->getVal('action');
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

			if(empty($dbkey)) {
				// try master
				$mainTitle = Title::newFromId($title->getText(), Title::GAID_FOR_UPDATE);
				if(!empty($mainTitle)) {
					$dbkey = $mainTitle->getDBkey();
					$fromDeleted = false;
				}
			}

			if(empty($dbkey) || !$helper->isDbkeyFromWall($dbkey) ) {
				// no dbkey or not from wall, redirect to wall
				$app->wg->Out->redirect($this->getWallTitle()->getFullUrl(), 301);

				wfProfileOut(__METHOD__);
				return true;
			} else {
				// article exists or existed
				if($fromDeleted) {
					$app->wg->SuppressPageHeader = true;
					$app->wg->Out->addHTML($app->renderView('WallController', 'messageDeleted', array( 'title' =>wfMsg( 'wall-deleted-msg-pagetitle' ) ) ));
					$app->wg->Out->setPageTitle( wfMsg( 'wall-deleted-msg-pagetitle' ) );
					$app->wg->Out->setHTMLTitle( wfMsg( 'errorpagetitle' ) );
				} else {
					$wallMessage = F::build('WallMessage', array($mainTitle), 'newFromTitle' );
					$app->wg->SuppressPageHeader = true;
					$app->wg->WallBrickHeader = $title->getText();
					if( $wallMessage->isVisible($app->wg->User) ||
							($wallMessage->canViewDeletedMessage($app->wg->User) && $app->wg->Request->getVal('show') == '1')
					) {
						if(wfRunHooks('WallBeforeRenderThread', array($mainTitle, $wallMessage))) {
							$app->wg->Out->addHTML($app->renderView('WallController', 'index',  array('filterid' => $title->getText(),  'title' => $wallMessage->getWallTitle() )));
						}
					} else {
						$app->wg->Out->addHTML($app->renderView('WallController', 'messageDeleted', array( 'title' =>wfMsg( 'wall-deleted-msg-pagetitle' ) ) ));
					}
				}
			}

			wfProfileOut(__METHOD__);
			return true;
		}

		if( $title->getNamespace() === NS_USER_TALK
				&& !$title->isSubpage()
		) {
			$title = $this->getWallTitle();
			if ( empty($title) ) {
				wfProfileOut(__METHOD__);
				return true;
			}
			//user talk page -> redirect to message wall
			$outputDone = true;
			$app->wg->Out->redirect($title->getFullUrl(), 301);

			wfProfileOut(__METHOD__);
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

			wfProfileOut(__METHOD__);
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

			wfProfileOut(__METHOD__);
			return true;
		}

		wfProfileOut(__METHOD__);
		return true;
	}

	/**
	 * @brief Hook to change tabs on user wall page
	 *
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	public function onSkinTemplateTabs($template, &$contentActions) {
		$app = F::App();

		if( !empty($app->wg->EnableWallExt) ) {
			$helper = F::build('WallHelper', array());
			$title = $app->wg->Title;

			if( $title->getNamespace() === NS_USER ) {
				if( !empty($contentActions['namespaces']) && !empty($contentActions['namespaces']['user_talk']) ) {

					$contentActions['namespaces']['user_talk']['text'] = $app->wf->Msg('wall-message-wall');

					$userWallTitle = $this->getWallTitle();

					if( $userWallTitle instanceof Title ) {
						$contentActions['namespaces']['user_talk']['href'] = $userWallTitle->getLocalUrl();
					}

					// BugId:23000 Remove the class="new" to prevent the link from being displayed as a redlink in monobook.
					if ( $app->wg->User->getSkin() instanceof SkinMonoBook ) {
						unset( $contentActions['namespaces']['user_talk']['class'] );
					}
				}
			}

			if( $title->getNamespace() === NS_USER_WALL || $title->getNamespace() === NS_USER_WALL_MESSAGE ) {
				$userPageTitle = $helper->getTitle(NS_USER);

				if( $title->getNamespace() === NS_USER_WALL_MESSAGE ) {
					$text = $title->getText();
					$id = intval($text);

					if( $id > 0 ) {
						$wm = F::build('WallMessage', array($id), 'newFromId');
					} else {
						//sometimes (I found it on a revision diff page) $id here isn't a number from (in example) Thread:1234 link
						//it's a text similar to this: AndLuk/@comment-38.127.199.123-20120111182821
						//then we need to use WallMessage constructor method
						$wm = F::build('WallMessage', array($title));
					}

					if( empty($wm) ) {
						//FB#19394

						return true;
					}

					/* @var $wm WallMessage */
					$wall = $wm->getWall();
					$user = $wall->getUser();
				} else {
					$wall = F::build( 'Wall', array($title), 'newFromTitle');
					$user = $wall->getUser();
				}

				$contentActions['namespaces'] = array();

				if( $user instanceof User ) {
					$contentActions['namespaces']['user-profile'] = array(
							'class' => false,
							'href' => $user->getUserPage()->getFullUrl(),
							'text' => $app->wf->Msg('nstab-user'),
					);
				}

				$contentActions['namespaces']['message-wall'] = array(
						'class' => 'selected',
						'href' => $wall->getUrl(),
						'text' => $app->wf->Msg('wall-message-wall'),
				);
			}

			if( $title->getNamespace() === NS_USER_WALL && $title->isSubpage() ) {
				$userTalkPageTitle = $helper->getTitle(NS_USER_TALK);
				$contentActions = array();
				$contentActions['namespaces'] = array();

				$contentActions['namespaces']['view-source'] = array(
						'class' => false,
						'href' => $userTalkPageTitle->getLocalUrl(array('action' => 'edit')),
						'text' => $app->wf->Msg('user-action-menu-view-source'),
				);

				$contentActions['namespaces']['history'] = array(
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

	public function onBeforePageHistory( &$article ) {
		$title = $article->getTitle();
		$app = F::App();
		$page = $app->wg->Request->getVal('page', 1);

		if( !empty( $title ) ) {
			if( $title->getNamespace() === NS_USER_WALL  && !$title->isSubpage() ) {
				$app->wg->Out->addHTML( $app->renderView( 'WallHistoryController', 'index', array( 'title' => $title, 'page' => $page) ) );
				return false;
			}

			if( $title->getNamespace() === NS_USER_WALL_MESSAGE ) {
				$app->wg->Out->addHTML( $app->renderView( 'WallHistoryController', 'index', array( 'title' => $title, 'page' => $page, 'threadLevelHistory' => true ) ) );
				return false;
			}
		}

		$this->doSelfRedirect();
		return true;
	}

	/**
	 * @brief Overrides descrpiton of history page
	 *
	 * @return true
	 *
	 * @author Jakub Olek
	 */

	public function onGetHistoryDescription( &$description ){
		$app = F::app();

		if( $app->wg->Title->getNamespace() === NS_USER_WALL || $app->wg->Title->getNamespace() === NS_USER_WALL_MESSAGE) {
			$description = '';
		}

		return true;
	}

	/**
	 * @brief add history to wall toolbar
	 **/
	function onBeforeToolbarMenu(&$items) {
		$app = F::app();
		$title = $app->wg->Title;
		$action = $app->wg->Request->getText('action');

		if ($title instanceof Title && $title->getNamespace() === NS_USER_WALL_MESSAGE) {
			if ( is_array($items) ) {
				foreach($items as $k=>$value) {
					if( $value['type'] == 'follow' ) {
						unset($items[$k]);
						break;
					}
				}

			}
		}

		if( $title instanceof Title && $title->getNamespace() === NS_USER_WALL_MESSAGE || $title->getNamespace() === NS_USER_WALL  && !$title->isSubpage() && empty($action) ) {
			$item = array(
					'type' => 'html',
					'html' => XML::element('a', array('href' => $title->getFullUrl('action=history')), wfMsg('wall-toolbar-history') )
			);

			if( is_array($items) ) {
				$inserted = false;
				$itemsout = array();

				foreach($items as $value) {
					$itemsout[] = $value;

					if( $value['type'] == 'follow' ) {
						$itemsout[] = $item;
						$inserted = true;
					}
				}

				if( !$inserted ) {
					array_unshift($items, $item);
				} else {
					$items = $itemsout;
				}
			} else {
				$items = array($item);
			}
		}

		return true;
	}



	/**
	 * @brief Redirects any attempts of protecting any page in NS_USER_WALL namespace
	 *
	 * @return true
	 *
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	public function onBeforePageProtect(&$article) {
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
	public function onBeforePageUnprotect(&$article) {
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
	public function onBeforePageDelete(&$article) {
		$this->doSelfRedirect();

		return true;
	}

	/**
	 * @brief Changes "My talk" to "Message wall" in the user links.
	 *
	 * @return true
	 *
	 * @author Andrzej 'nAndy' Łukaszewski
	 * @author Piotrek Bablok
	 */
	public function onPersonalUrls(&$personalUrls, &$title) {
		$app = F::App();

		$user = $app->wg->User;
		F::build('JSMessages')->enqueuePackage('Wall', JSMessages::EXTERNAL);

		if( $user instanceof User && $user->isLoggedIn() ) {
			$userWallTitle = $this->getWallTitle(null, $user);
			if( $userWallTitle instanceof Title ) {
				$personalUrls['mytalk']['href'] = $userWallTitle->getLocalUrl();
			}
			$personalUrls['mytalk']['text'] = $app->wf->Msg('wall-message-wall');

			if(!empty($personalUrls['mytalk']['class'])){
				unset($personalUrls['mytalk']['class']);
			}

			if($app->wg->User->getSkin()->getSkinName() == 'monobook') {
				$personalUrls['wall-notifications'] = array(
						'text'=>$app->wf->Msg('wall-notifications'),
						//'text'=>print_r($app->wg->User->getSkin(),1),
						'href'=>'#',
						'class'=>'wall-notifications-monobook',
						'active'=>false
				);
				$app->wg->Out->addStyle("{$app->wg->ExtensionsPath}/wikia/Wall/css/WallNotificationsMonobook.css");
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
	public function onUserPagesHeaderModuleAfterGetTabs(&$tabs, $namespace, $userName) {
		$app = F::App();

		foreach($tabs as $key => $tab) {
			if( !empty($tab['data-id']) && $tab['data-id'] === 'talk' ) {
				$userWallTitle = $this->getWallTitle();

				if( $userWallTitle instanceof Title ) {
					$tabs[$key]['link'] = '<a href="'.$userWallTitle->getLocalUrl().'" title="'. $userWallTitle->getPrefixedText() .'">'.$app->wf->Msg('wall-message-wall').'</a>';
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
	public function onPageHeaderIndexAfterActionButtonPrepared($response, $ns, $skin) {
		$app = F::App();
		$helper = F::build('WallHelper', array());

		if( !empty($app->wg->EnableWallExt) ) {
			$title = $app->wg->Title;
			$parts = explode( '/', $title->getText() );
			$action = $response->getVal('action');
			$dropdown = $response->getVal('dropdown');
			$canEdit = $app->wg->User->isAllowed('editwallarchivedpages');

			if( $ns === NS_USER_WALL
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

				if( $canEdit ) {
					$action['text'] = $app->wf->Msg('edit');
					$action['id'] = 'talkArchiveEditButton';
				}

				$response->setVal('action', $action);
				$response->setVal('dropdown', $dropdown);
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

				if( $canEdit ) {
					$action['text'] = $app->wf->Msg('edit');
					$action['id'] = 'talkArchiveEditButton';
				}

				$response->setVal('action', $action);
				$response->setVal('dropdown', $dropdown);
			}
			// update the response object with any changes
			$response->setVal('action', $action);
			$response->setVal('dropdown', $dropdown);
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
	protected function getWallTitle($subpage = null, $user = null) {
		$helper = F::build('WallHelper', array());
		$app = F::app();

		return $helper->getTitle(NS_USER_WALL, $subpage, $user);
	}

	/**
	 *  clean history after delete
	 *
	 **/

	public function onArticleDeleteComplete( &$self, &$user, $reason, $id) {
		$title = $self->getTitle();
		$app = F::app();
		if($title instanceof Title && $title->getNamespace() == NS_USER_WALL_MESSAGE) {
			$wh = F::build('WallHistory', array($app->wg->CityId));
			$wh->remove( $id );
		}
		return true;
	}

	public function onArticleDelete( $article, &$user, &$reason, &$error ){
		$title = $article->getTitle();
		$app = F::app();
		if($title instanceof Title && $title->getNamespace() == NS_USER_WALL_MESSAGE) {
			$wallMessage = F::build('WallMessage', array($title), 'newFromTitle' );
			return $wallMessage->canDelete($user);
		}
		return true;
	}

	public function onRecentChangeSave( $recentChange ){
		wfProfileIn( __METHOD__ );
		// notifications
		$app = F::app();

		if(  MWNamespace::isTalk( $recentChange->getAttribute('rc_namespace') ) && in_array( MWNamespace::getSubject($recentChange->getAttribute('rc_namespace')), $app->wg->WallNS ) ) {
			$rcType = $recentChange->getAttribute('rc_type');

			//FIXME: WallMessage::remove() creates a new RC but somehow there is no rc_this_oldid
			$revOldId = $recentChange->getAttribute('rc_this_oldid');
			if( $rcType == RC_EDIT && !empty($revOldId) ) {
				$helper = F::build('WallHelper', array());
				$helper->sendNotification($revOldId, $rcType);
			}
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	public function onArticleCommentBeforeWatchlistAdd($comment) {
		$commentTitle = $comment->getTitle();
		$app = F::app();
		if ($commentTitle instanceof Title &&
			in_array(MWNamespace::getSubject( $commentTitle->getNamespace() ), $app->wg->WallNS) ) {
			$parentTitle = $comment->getTopParentObj();

			if (!($comment->mUser instanceof User)) {
				// force load from cache
				$comment->load(true);
			}

			if (!($comment->mUser instanceof User)) {
				// comment in master has no valid User
				// log error
				$logmessage = 'WallHooksHelper.class.php, ' . __METHOD__ . ' ';
				$logmessage .= 'ArticleId: ' . $commentTitle->getArticleID();

				Wikia::log(__METHOD__, false, $logmessage);

				// parse following hooks
				return true;
			}

			if (!empty($parentTitle)) {
				$comment->mUser->addWatch($parentTitle->getTitle());
			} else {
				$comment->mUser->addWatch($comment->getTitle());
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
	public function onAfterEditPermissionErrors(&$permErrors, $title, $removeArray) {
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
	public function onSkinTemplateContentActions(&$contentActions) {
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
	public function onChangesListInsertFlags($list, &$flags, $rc) {
		if( $rc->getAttribute('rc_type') == RC_NEW && $rc->getAttribute('rc_namespace') == NS_USER_WALL_MESSAGE ) {
			//we don't need flags if this is a reply on a message wall
			$app = F::app();

			$rcTitle = $rc->getTitle();

			if( !($rcTitle instanceof Title) ) {
				//it can be media wiki deletion of an article -- we ignore them
				Wikia::log(__METHOD__, false, "WALL_NOTITLE_FROM_RC " . print_r($rc, true));
				return true;
			}

			$wm = F::build('WallMessage', array($rcTitle));
			$wm->load();

			if( !$wm->isMain() ) {
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
	public function onChangesListInsertArticleLink($list, &$articleLink, &$s, $rc, $unpatrolled, $watched) {
		$rcType = $rc->getAttribute('rc_type');
		$app = F::app();
		if( in_array($rcType, array(RC_NEW, RC_EDIT, RC_LOG)) && in_array(MWNamespace::getSubject($rc->getAttribute('rc_namespace')), $app->wg->WallNS) ) {

			if( in_array($rc->getAttribute('rc_log_action'), $this->rcWallActionTypes) ) {
				$articleLink = '';

				return true;
			} else {
				$rcTitle = $rc->getTitle();

				if( !($rcTitle instanceof Title) ) {
					//it can be media wiki deletion of an article -- we ignore them
					Wikia::log(__METHOD__, false, "WALL_NOTITLE_FROM_RC " . print_r($rc, true));
					return true;
				}

				$wm = F::build('WallMessage', array($rcTitle));
				$wm->load();

				if( !$wm->isMain() ) {
					$wm = $wm->getTopParentObj();

					if( is_null($wm) ) {
						Wikia::log(__METHOD__, false, "WALL_NO_PARENT_MSG_OBJECT " . print_r($rc, true));
						return true;
					} else {
						$wm->load();
					}
				}

				$link = $wm->getMessagePageUrl();
				$title = $wm->getMetaTitle();
				$wallUrl = $wm->getWallPageUrl();
				$wallOwner = $wm->getWallOwnerName();
				$class = '';

				$articleLink = ' <a href="'.$link.'" class="'.$class.'" >'.$title.'</a> '.$app->wf->Msg($this->getMessagePrefix($rc->getAttribute('rc_namespace')) . '-new-message', array($wallUrl, $wallOwner));
				# Bolden pages watched by this user
				if( $watched ) {
					$articleLink = '<strong class="mw-watched">'.$articleLink.'</strong>';
				}
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
	public function onChangesListInsertDiffHist($list, &$diffLink, &$historyLink, &$s, $rc, $unpatrolled) {
		wfProfileIn(__METHOD__);

		$app = F::app();
		if( in_array(MWNamespace::getSubject(intval($rc->getAttribute('rc_namespace'))), $app->wg->WallNS) ) {
			$rcTitle = $rc->getTitle();

			if( !($rcTitle instanceof Title) ) {
				//it can be media wiki deletion of an article -- we ignore them
				Wikia::log(__METHOD__, false, "WALL_NOTITLE_FOR_DIFF_HIST " . print_r(array($rc), true));
				return true;
			}

			if( in_array($rc->getAttribute('rc_log_action'), $this->rcWallActionTypes) ) {
				//delete, remove, restore
				$parts = explode('/@', $rcTitle->getText());
				$isThread = ( count($parts) === 2 ) ? true : false;

				if( $isThread ) {
					$wallTitleObj = F::build('Title', array($parts[0], NS_USER_WALL), 'newFromText');
					$historyLink = ( !empty($parts[0]) && $wallTitleObj instanceof Title) ? $wallTitleObj->getFullURL(array('action' => 'history')) : '#';
					$historyLink = Xml::element('a', array('href' => $historyLink), $app->wf->Msg($this->getMessagePrefix($rc->getAttribute('rc_namespace')) . '-history-link'));
				} else {
					$wallMessage = F::build('WallMessage', array($rcTitle));
					$historyLink = $wallMessage->getMessagePageUrl(true).'?action=history';
					$historyLink = Xml::element('a', array('href' => $historyLink), $app->wf->Msg($this->getMessagePrefix($rc->getAttribute('rc_namespace')) . '-thread-history-link'));
				}

				$s = '(' . $historyLink . ')';
			} else {
				//new, edit
				if( $rc->mAttribs['rc_type'] == RC_NEW || $rc->mAttribs['rc_type'] == RC_LOG ) {
					$diffLink = $app->wf->Msg('diff');
				} else if( !ChangesList::userCan($rc, Revision::DELETED_TEXT) ) {
					$diffLink = $app->wf->Msg('diff');
				} else {
					$query = array(
							'curid' => $rc->mAttribs['rc_cur_id'],
							'diff'  => $rc->mAttribs['rc_this_oldid'],
							'oldid' => $rc->mAttribs['rc_last_oldid']
					);

					if( $unpatrolled ) {
						$query['rcid'] = $rc->mAttribs['rc_id'];
					}

					$diffLink = Xml::element('a', array(
							'href' => $rcTitle->getLocalUrl($query),
							'tabindex' => $rc->counter,
							'class' => 'known noclasses',
					), $app->wf->Msg('diff'));
				}

				$wallMessage = F::build('WallMessage', array($rcTitle));
				$historyLink = $wallMessage->getMessagePageUrl(true).'?action=history';
				$historyLink = Xml::element('a', array('href' => $historyLink), $app->wf->Msg('hist'));
				$s = '('. $diffLink . $app->wf->Msg('pipe-separator') . $historyLink . ') . . ';
			}

		}

		wfProfileOut(__METHOD__);
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
	public function onChangesListInsertRollback($list, &$s, &$rollbackLink, $rc) {
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
	public function onChangesListInsertComment($list, $rc, &$comment) {
		$rcType = $rc->getAttribute('rc_type');
		$app = F::app();
		if( in_array($rcType, array(RC_NEW, RC_EDIT, RC_LOG)) && in_array(MWNamespace::getSubject($rc->getAttribute('rc_namespace')), $app->wg->WallNS) ) {

			if( $rcType == RC_EDIT ) {
				$comment = ' ';
				$comment .= Xml::element('span', array('class' => 'comment'), $app->wf->Msg($this->getMessagePrefix($rc->getAttribute('rc_namespace')).'-edit'));
			} else if( $rcType == RC_LOG && in_array($rc->getAttribute('rc_log_action'), $this->rcWallActionTypes) ) {
				//this will be deletion/removal/restore summary
				$text = $rc->getAttribute('rc_comment');

				if( !empty($text) ) $comment = Xml::element('span', array('class' => 'comment'), ' ('.$text.')');
				else $comment = '';
			} else {
				$comment = '';
			}
		}

		return true;
	}

	/**
	 * @brief Adjusting recent changes for Wall
	 *
	 * @desc This method creates comment about revision deletion of a message on message wall
	 *
	 * @param ChangesList $list
	 * @param RecentChange $rc
	 * @param String $s
	 * @param Formatter $formatter
	 * @param string $mark
	 *
	 * @return true because this is a hook
	 *
	 * @author Andrzej 'nAndy' Lukaszewski
	 */
	public function onChangesListInsertLogEntry($list, $rc, &$s, $formatter, &$mark) {
		$app = F::app();
		if( $rc->getAttribute('rc_type') == RC_LOG
				&& in_array(MWNamespace::getSubject($rc->getAttribute('rc_namespace')), $app->wg->WallNS)
				&& in_array($rc->getAttribute('rc_log_action'), $this->rcWallActionTypes) ) {

			$actionText = '';
			$wfMsgOptsBase = $this->getMessageOptions($rc);

			$wfMsgOpts = array(
				$wfMsgOptsBase['articleUrl'],
				$wfMsgOptsBase['articleTitleTxt'],
				$wfMsgOptsBase['wallPageUrl'],
				$wfMsgOptsBase['wallPageName'],
				$wfMsgOptsBase['actionUser']);



			$msgType = ($wfMsgOptsBase['isThread']) ? 'thread' : 'reply';

			//created in WallHooksHelper::getMessageOptions()
			//and there is not needed to be passed to wfMsg()
			unset($wfMsgOpts['isThread'], $wfMsgOpts['isNew']);

			switch($rc->getAttribute('rc_log_action')) {
				case 'wall_remove':
					$actionText = wfMsgExt($this->getMessagePrefix($rc->getAttribute('rc_namespace')) . '-removed-'.$msgType, array('parseinline'), $wfMsgOpts);
					break;
				case 'wall_restore':
					$actionText = wfMsgExt($this->getMessagePrefix($rc->getAttribute('rc_namespace')) . '-restored-'.$msgType, array('parseinline'), $wfMsgOpts);
					break;
				case 'wall_admindelete':
					$actionText = wfMsgExt($this->getMessagePrefix($rc->getAttribute('rc_namespace')) . '-deleted-'.$msgType, array('parseinline'), $wfMsgOpts);
					break;
				case 'wall_archive':
					$actionText = wfMsgExt($this->getMessagePrefix($rc->getAttribute('rc_namespace')) . '-closed-thread', array('parseinline'), $wfMsgOpts);
					break;
				case 'wall_reopen':
					$actionText = wfMsgExt($this->getMessagePrefix($rc->getAttribute('rc_namespace')) . '-reopened-thread', array('parseinline'), $wfMsgOpts);
					break;
				default:
					$actionText = wfMsg($this->getMessagePrefix($rc->getAttribute('rc_namespace')) . '-unrecognized-log-action', $wfMsgOpts);
					break;
			}

			$s = '';
			$list->insertUserRelatedLinks($s, $rc);
			$s .= ' '.$actionText.' '.$list->insertComment($rc);
		}

		return true;
	}

	/**
	 * @brief Adjusting recent changes for Wall
	 *
	 * @desc This method clears or leaves as it was the text which is being send as a content of <li /> elements in RC page
	 *
	 * @param ChangesList $list
	 * @param string $s
	 * @param RecentChange $rc
	 *
	 * @return true because this is a hook
	 *
	 * @author Andrzej 'nAndy' Lukaszewski
	 */
	public function onOldChangesListRecentChangesLine($changelist, &$s, $rc) {
		if( $rc->getAttribute('rc_namespace') == NS_USER_WALL_MESSAGE ) {
			wfProfileIn( __METHOD__ );
			$app = F::app();
			$rcTitle = $rc->getTitle();

			if( !($rcTitle instanceof Title) ) {
				//it can be media wiki deletion of an article -- we ignore them
				Wikia::log(__METHOD__, false, "WALL_NOTITLE_FROM_RC " . print_r($rc, true));
				wfProfileOut( __METHOD__ );
				return true;
			}

			$wm = F::build('WallMessage', array($rcTitle));
			$wm->load();
			if( !$wm->isMain() ) {
				$wm = $wm->getTopParentObj();

				if( is_null($wm) ) {
					Wikia::log(__METHOD__, false, "WALL_NO_PARENT_MSG_OBJECT " . print_r($rc, true));
					wfProfileOut( __METHOD__ );
					return true;
				} else {
					$wm->load();
				}
			}

			if( $wm->isAdminDelete() && $rc->getAttribute('rc_log_action') != 'wall_admindelete' ) {
				wfProfileOut( __METHOD__ );
				return false;
			}
		}

		return true;
	}

	/**
	 * @brief Getting the title of a message
	 *
	 * @desc Callback method used in WallHooksHelper::onChangesListInsertLogEntry() hook if deleted message was a reply
	 *
	 * @param string $title
	 *
	 * @return string
	 *
	 * @author Andrzej 'nAndy' Lukaszewski
	 */
	private function getParentTitleTxt($title) {
		wfProfileIn(__METHOD__);

		$app = F::app();

		if( $title instanceof Title ) {
			$helper = F::build('WallHelper', array());

			$wm = F::build('WallMessage', array($title));

			$titleText = $title->getText();
			$parentTitleTxt = $wm->getTopParentText($titleText);
			if( is_null($parentTitleTxt) ) {
				$parts = explode('/@', $titleText);
				if( count($parts) > 1 ) {
					$parentTitleTxt = $parts[0] . '/@' . $parts[1];
				}
			}

			$articleData = array('text_id' => '');
			$articleId = $helper->getArticleId_forDeleted($parentTitleTxt, $articleData);
			if( !empty($articleId) ) {
				//parent article was deleted as well
				$articleTitleTxt = $helper->getTitleTxtFromMetadata($helper->getDeletedArticleTitleTxt($articleData['text_id']));
			} else {
				$title = F::build('Title', array($parentTitleTxt, MWNamespace::getTalk($title->getNamespace())), 'newFromText');

				if( $title instanceof Title ) {
					$parentWallMsg = F::build('WallMessage', array($title));
					$parentWallMsg->load(true);
					$articleTitleTxt = $parentWallMsg->getMetaTitle();
				} else {
					$articleTitleTxt = null;
				}
			}

			wfProfileOut(__METHOD__);
			return $articleTitleTxt;
		}

		wfProfileOut(__METHOD__);
		return null;
	}

	/**
	 * @brief Adjusting recent changes for Wall
	 *
	 * @desc This method decides rather put a log information about deletion or not
	 *
	 * @param WikiPage $wikipage a referance to WikiPage instance
	 * @param string $logType a referance to string with type of log
	 * @param Title $title
	 * @param string $reason
	 * @param boolean $hookAddedLogEntry set it to true if you don't want Article::doDeleteArticle() to add a log entry
	 *
	 * @return true because this is a hook
	 *
	 * @author Andrzej 'nAndy' Lukaszewski
	 */
	public function onArticleDoDeleteArticleBeforeLogEntry(&$wikipage, &$logType, $title, $reason, &$hookAddedLogEntry) {
		if( $title instanceof Title && $title->getNamespace() == NS_USER_WALL_MESSAGE ) {
			$app = F::app();
			$wm = F::build('WallMessage', array($title));
			$parentObj = $wm->getTopParentObj();
			$reason = ''; //we don't want any comment
			$log = new LogPage( $logType );

			if( empty($parentObj) ) {
				//thread message
				$log->addEntry( 'delete', $title, $reason, array() );
			} else {
				//reply
				$result = $parentObj->load(true);

				if( $result ) {
					//if its parent still exists only this reply is being deleted, so log about it
					$log->addEntry( 'delete', $title, $reason, array() );
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
	public function onPageArchiveUndeleteBeforeLogEntry(&$pageArchive, &$logPage, &$title, $reason, &$hookAddedLogEntry) {
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
				$result = $parentObj->load(true);

				if( $result ) {
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
	public function onXmlNamespaceSelectorAfterGetFormattedNamespaces( &$namespaces ) {
		if( defined('NS_USER_WALL') && defined('NS_USER_WALL_MESSAGE') ) {
			if( isset($namespaces[NS_USER_WALL]) && isset($namespaces[NS_USER_WALL_MESSAGE]) ) {
				unset($namespaces[NS_USER_WALL], $namespaces[NS_USER_WALL_MESSAGE]);
				$namespaces[NS_USER_WALL_MESSAGE] = F::app()->wf->Msg($this->getMessagePrefix(NS_USER_WALL) . '-namespace-selector-message-wall');
			}
		}

		return true;
	}

	/**
	 * @brief Adjusting title of a block group on RecentChanges page
	 *
	 * @param ChangesList $oChangeList
	 * @param string $r
	 * @param array $oRCCacheEntryArray an array of RCCacheEntry instances
	 * @param boolean $changeRecentChangesHeader a flag saying Wikia's hook if we want to change header or not
	 * @param string $headerTitle string which will be put as a header for RecentChanges block
	 *
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	public function onWikiaRecentChangesBlockHandlerChangeHeaderBlockGroup($oChangeList, $r, $oRCCacheEntryArray, &$changeRecentChangesHeader, $oTitle, &$headerTitle) {
		wfProfileIn(__METHOD__);

		if( in_array(MWNamespace::getSubject($oTitle->getNamespace()), F::app()->wg->WallNS) ) {
			$changeRecentChangesHeader = true;

			$wm = F::build('WallMessage', array($oTitle));
			$wallMsgUrl = $wm->getMessagePageUrl();
			$wallUrl = $wm->getWallUrl();
			$wallOwnerName = $wm->getWallOwnerName();
			$parent = $wm->getTopParentObj();
			$isMain = is_null($parent);

			if( !$isMain ) {
				$wm = $parent;
				unset($parent);
			}

			$wm->load();
			$wallMsgTitle = $wm->getMetaTitle();
			$oTitle = $wm->getTitle();
			$headerTitle = wfMsg('wall-recentchanges-thread-group', array(Xml::element('a', array('href' => $wallMsgUrl), $wallMsgTitle), $wallUrl, $wallOwnerName));
		}

		wfProfileOut(__METHOD__);
		return true;
	}

	/**
	 * @brief get prefixed message name for recent changes, helpful for using wall on others namesapces
	 *
	 *
	 * @param int $namespace
	 * @param string $message
	 *
	 */

	protected function getMessagePrefix($namespace) {
		$namespace = MWNamespace::getSubject($namespace);
		$prefix = '';
		if(!wfRunHooks('WallRecentchangesMessagePrefix', array($namespace, &$prefix))) {
			return $prefix;
		}

		return 'wall-recentchanges';

	}

	/**
	 * @brief Adjusting blocks on Enhanced Recent Changes page
	 *
	 * @desc Changes $secureName which is an array key in RC cache by which blocks on enchance RC page are displayed
	 *
	 * @param ChangesList $changesList
	 * @param string $secureName
	 * @param RecentChange $rc
	 *
	 * @author Andrzej 'nAndy' Łukaszewski
	 */
	public function onChangesListMakeSecureName($changesList, &$secureName, $rc) {
		if( intval($rc->getAttribute('rc_namespace')) === NS_USER_WALL_MESSAGE ) {
			$oTitle = $rc->getTitle();

			if( $oTitle instanceof Title ) {
				$wm = F::build('WallMessage', array($oTitle));
				$parent = $wm->getTopParentObj();
				$isMain = is_null($parent);

				if( !$isMain ) {
					$wm = $parent;
					unset($parent);
				}

				$secureName = self::RC_WALL_SECURENAME_PREFIX.$wm->getArticleId();
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
	public function onLinkBegin($skin, $target, &$text, &$customAttribs, &$query, &$options, &$ret) {
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

			if( $user->isAllowed('walledit') || $user->getName() == $username ) {
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

	public function onArticleSaveComplete(&$article, &$user, $text, $summary, $minoredit, $watchthis, $sectionanchor, &$flags, $revision, &$status, $baseRevId) {
		$app = F::app();
		$title = $article->getTitle();

		if( !empty($app->wg->EnableWallExt)
				&& $title instanceof Title
				&& $title->getNamespace() === NS_USER_TALK
				&& !$title->isSubpage() )
		{
			//user talk page was edited -> redirect to user talk archive
			$helper = F::build('WallHelper', array());

			$app->wg->Out->redirect($this->getWallTitle()->getFullUrl().'/'.$helper->getArchiveSubPageText(), 301);
			$app->wg->Out->enableRedirects(false);
		}

		return true;
	}

	public function onAllowNotifyOnPageChange( $editor, $title ) {
		$app = F::app();
		if( in_array(MWNamespace::getSubject( $title->getNamespace() ), $app->wg->WallNS) || $title->getNamespace() == NS_USER_WALL_MESSAGE_GREETING){
			return false;
		}
		return true;
	}

	public function onWatchArticle(&$user, &$article) {
		$app = F::app();
		$title = $article->getTitle();

		if( !empty($app->wg->EnableWallExt) && $this->isWallMainPage($title) ) {
			$this->processActionOnWatchlist($user, $title->getText(), 'add');
		}

		return true;
	}

	public function onUnwatchArticle(&$user, &$article) {
		$app = F::app();
		$title = $article->getTitle();

		if( !empty($app->wg->EnableWallExt) && $this->isWallMainPage($title) ) {
			$this->processActionOnWatchlist($user, $title->getText(), 'remove');
		}

		return true;
	}

	private function isWallMainPage($title) {
		if( $title->getNamespace() == NS_USER_WALL && strpos($title->getText(), '/') === false ) {
			return true;
		}

		return false;
	}

	private function processActionOnWatchlist($user, $followedUserName, $action) {
		wfProfileIn(__METHOD__);

		$watchTitle = Title::newFromText($followedUserName, NS_USER);

		if( $watchTitle instanceof Title ) {
			$wl = new WatchedItem;
			$wl->mTitle = $watchTitle;
			$wl->id = $user->getId();
			$wl->ns = $watchTitle->getNamespace();
			$wl->ti = $watchTitle->getDBkey();

			if( $action === 'add' ) {
				$wl->addWatch();
			} elseif( $action === 'remove' ) {
				$wl->removeWatch();
			}
		} else {
			//just-in-case -- it shouldn't happen but if it does we want to know about it
			Wikia::log( __METHOD__, false, 'WALL_HOOK_ERROR: No title instance while syncing follows. User name: '.$followedUserName);
		}

		wfProfileOut(__METHOD__);
	}

	public function onGetPreferences( $user, &$preferences ) {
		$app = F::app();

		if( $user->isLoggedIn() ) {
			if ($app->wg->EnableUserPreferencesV2Ext) {
				$message = 'wallshowsource-toggle-v2';
				$section = 'under-the-hood/advanced-displayv2';
			}
			else {
				$message = 'wallshowsource-toggle';
				$section = 'misc/wall';
			}
			$preferences['wallshowsource'] = array(
					'type' => 'toggle',
					'label-message' => $message, // a system message
					'section' => $section
			);

			if($user->isAllowed('walldelete')) {
				$preferences['walldelete'] = array(
						'type' => 'toggle',
						'label-message' => 'walldelete-toggle', // a system message
						'section' => $section
				);
			}
		}

		return true;
	}


	/**
	 * @brief Adjusting Special:Contributions
	 *
	 * @param ContribsPager $contribsPager
	 * @param String $ret string passed to wgOutput
	 * @param Object $row Std Object with values from database table
	 *
	 * @return true
	 */
	public function onContributionsLineEnding(&$contribsPager, &$ret, $row) {
		wfProfileIn(__METHOD__);

		$app = F::app();

		if( isset($row->page_namespace) && in_array(MWNamespace::getSubject($row->page_namespace), $app->wg->WallNS)) {
			$topmarktext = '';

			$rev = new Revision($row);
			$page = $rev->getTitle();
			$page->resetArticleId($row->rev_page);
			$skin = $app->wg->User->getSkin();

			$wfMsgOptsBase = $this->getMessageOptions(null, $row, true);


			$isThread = $wfMsgOptsBase['isThread'];
			$isNew = $wfMsgOptsBase['isNew'];

			$wfMsgOptsBase['createdAt'] = Xml::element('a', array('href' => $wfMsgOptsBase['articleUrl']), $app->wg->Lang->timeanddate( $app->wf->Timestamp(TS_MW, $row->rev_timestamp), true) );

			if( $isNew ) {
				$wfMsgOptsBase['DiffLink'] = $app->wf->Msg('diff');
			} else {
				$query = array(
						'diff' => 'prev',
						'oldid' => $row->rev_id,
				);

				$wfMsgOptsBase['DiffLink'] = Xml::element('a', array(
						'href' => $rev->getTitle()->getLocalUrl($query),
				), $app->wf->Msg('diff'));
			}

			$wallMessage = F::build('WallMessage', array($page));
			$historyLink = $wallMessage->getMessagePageUrl(true).'?action=history';
			$wfMsgOptsBase['historyLink'] = Xml::element('a', array('href' => $historyLink), $app->wf->Msg('hist'));

			// Don't show useless link to people who cannot hide revisions
			$canHide = $app->wg->User->isAllowed('deleterevision');
			if( $canHide || ($rev->getVisibility() && $app->wg->User->isAllowed('deletedhistory')) ) {
				if( !$rev->userCan(Revision::DELETED_RESTRICTED) ) {
					$del = $skin->revDeleteLinkDisabled($canHide); // revision was hidden from sysops
				} else {
					$query = array(
							'type'		=> 'revision',
							'target'	=> $page->getPrefixedDbkey(),
							'ids'		=> $rev->getId()
					);
					$del = $skin->revDeleteLink($query, $rev->isDeleted(Revision::DELETED_RESTRICTED), $canHide);
				}
				$del .= ' ';
			} else {
				$del = '';
			}

			$ret = $del;
			if(wfRunHooks('WallContributionsLine', array(MWNamespace::getSubject($row->page_namespace), $wallMessage, $wfMsgOptsBase, &$ret) )) {
				$wfMsgOpts = array(
					$wfMsgOptsBase['articleUrl'],
					$wfMsgOptsBase['articleTitleTxt'],
					$wfMsgOptsBase['wallPageUrl'],
					$wfMsgOptsBase['wallPageName'],
					$wfMsgOptsBase['createdAt'],
					$wfMsgOptsBase['DiffLink'],
					$wfMsgOptsBase['historyLink']
				);

				if( $isThread && $isNew ) {
					$wfMsgOpts[7] = Xml::element('strong', array(), wfMsg('newpageletter').' ');
				} else {
					$wfMsgOpts[7] = '';
				}

				$ret .= $app->wf->Msg('wall-contributions-wall-line', $wfMsgOpts);

				if( !$isNew ) {
					$ret .= ' ' . Xml::openElement('span', array('class' => 'comment')) . $app->wf->Msg($this->getMessagePrefix($row->page_namespace) . '-edit') . Xml::closeElement('span');
				}
			}

		}

		wfProfileOut(__METHOD__);
		return true;
	}

	/**
	 * @brief Collects data basing on RC object or std object
	 * @desc Those lines of code were used a lot in this class. Better keep them in one place.
	 *
	 * @param RecentChanges $rc
	 * @param Object $row
	 * @param Title $objTitle
	 *
	 * @return Array
	 */
	private function getMessageOptions($rc = null, $row = null, $fullUrls = false) {
		wfProfileIn(__METHOD__);

		if( !is_null($rc) ) {
			$actionUser = $rc->getAttribute('rc_user_text');
		} else {
			$actionUser = '';
		}

		if( is_object($row) ) {
			$objTitle = F::build('Title', array($row->page_title, $row->page_namespace), 'newFromText');
			$userText = !empty($row->rev_user_text) ? $row->rev_user_text : '';

			$isNew = (!empty($row->page_is_new) && $row->page_is_new === '1') ? true : false;

			if( !$isNew ) {
				$isNew = (isset($row->rev_parent_id) && $row->rev_parent_id === '0') ? true : false;
			}

		} else {
			$objTitle = $rc->getTitle();
			$userText = $rc->getAttribute('rc_user_text');
			$isNew = false; //it doesn't metter for rc -- we've got there rc_log_action
		}

		$wallTitleObj = F::build('Title', array($userText, NS_USER_WALL), 'newFromText');
		$wallUrl = ($wallTitleObj instanceof Title) ? $wallTitleObj->getLocalUrl() : '#';

		if( !($objTitle instanceof Title) ) {
			//it can be media wiki deletion of an article -- we ignore them
			Wikia::log(__METHOD__, false, "WALL_NOTITLE_FOR_MSG_OPTS " . print_r(array($rc, $row), true));
			return true;
		}

		$parts = explode('/@', $objTitle->getText());
		$isThread = ( count($parts) === 2 ) ? true : false;
		$app = F::app();
		$articleTitleTxt = $this->getParentTitleTxt($objTitle);
		$wm = F::build('WallMessage', array($objTitle));
		$articleId = $wm->getId();
		$wallMsgNamespace = $app->wg->Lang->getNsText(NS_USER_WALL_MESSAGE);
		$articleUrl = !empty($articleId) ? $wallMsgNamespace.':'.$articleId : '#';
		$wallOwnerName = $wm->getWallOwnerName();
		$userText = empty($wallOwnerName) ? $userText : $wallOwnerName;
		$wallNamespace = $app->wg->Lang->getNsText(MWNamespace::getSubject($objTitle->getNamespace()));
		$wallUrl = $wallNamespace.':'.$userText;

		if( $fullUrls === true ) {
		//by default it's Thread:xxx and Message_wall:XXX for messages of recent changes
		//i.e. 'wall-recentchanges-wall-removed-thread'
		//but here we need the entire links
			$articleUrl = $wm->getMessagePageUrl();
			$wallUrl = $wm->getWallUrl();
		}

		wfProfileOut(__METHOD__);
		return array(
			'articleUrl' => $articleUrl,
			'articleTitleVal' => $articleTitleTxt,
			'articleTitleTxt' => empty($articleTitleTxt) ? $app->wf->Msg('wall-recentchanges-deleted-reply-title'):$articleTitleTxt,
			'wallPageUrl' => $wallUrl,
			'wallPageName' => $userText,
			'actionUser' => $actionUser,
			'isThread' => $isThread,
			'isNew' => $isNew,
		);
	}

	/**
	 * @brief Adjusting Special:Whatlinkshere
	 *
	 * @param Object $row
	 * @param Integer $level
	 * @param Boolean $defaultRendering
	 *
	 * @return Boolean
	 */
	public function onRenderWhatLinksHereRow(&$row, &$level, &$defaultRendering) {
		wfProfileIn(__METHOD__);

		if( isset($row->page_namespace) && intval($row->page_namespace) === NS_USER_WALL_MESSAGE ) {
			$defaultRendering = false;
			$title = F::build('Title', array($row->page_title, $row->page_namespace), 'newFromText');

			$app = F::app();
			$wlhTitle = SpecialPage::getTitleFor( 'Whatlinkshere' );
			$wfMsgOptsBase = $this->getMessageOptions(null, $row, true);

			$wfMsgOpts = array(
				$wfMsgOptsBase['articleUrl'],
				$wfMsgOptsBase['articleTitleTxt'],
				$wfMsgOptsBase['wallPageUrl'],
				$wfMsgOptsBase['wallPageName'],
				$wfMsgOptsBase['actionUser'],
				$wfMsgOptsBase['isThread'],
				$wfMsgOptsBase['isNew']
			);

			$app->wg->Out->addHtml(
					Xml::openElement('li') .
					$app->wf->Msg('wall-whatlinkshere-wall-line', $wfMsgOpts) .
					' (' .
					Xml::element('a', array(
							'href' => $wlhTitle->getFullUrl(array('target' => $title->getPrefixedText())),
					), $app->wf->Msg('whatlinkshere-links') ) .
					')' .
					Xml::closeElement('li')
			);
		}

		wfProfileOut(__METHOD__);
		return true;
	}

	/**
	 * @desc Changes fields in a DifferenceEngine instance to display correct content in <title /> tag
	 *
	 * @param DifferenceEngine $differenceEngine
	 * @param Revivion $oldRev
	 * @param Revivion $newRev
	 *
	 * @return true
	 */
	public function onDiffViewHeader($differenceEngine, $oldRev, $newRev) {
		wfProfileIn(__METHOD__);

		$app = F::App();
		$diff = $app->wg->request->getVal('diff', false);
		$oldId = $app->wg->request->getVal('oldid', false);

		if( $app->wg->Title instanceof Title && $app->wg->Title->getNamespace() === NS_USER_WALL_MESSAGE ) {
			$metaTitle = $this->getMetatitleFromTitleObject($app->wg->Title);
			$differenceEngine->mOldPage->mPrefixedText = $metaTitle;
			$differenceEngine->mNewPage->mPrefixedText = $metaTitle;
		}

		wfProfileOut(__METHOD__);
		return true;
	}

	/**
	 * @desc Changes fields in a PageHeaderModule instance to display correct content in <h1 /> and <h2 /> tags
	 *
	 * @param PageHeaderModule $pageHeaderModule
	 * @param int $ns
	 * @param Boolean $isPreview
	 * @param Boolean $isShowChanges
	 * @param Boolean $isDiff
	 * @param Boolean $isEdit
	 * @param Boolean $isHistory
	 *
	 * @return true
	 */
	public function onPageHeaderEditPage($pageHeaderModule, $ns, $isPreview, $isShowChanges, $isDiff, $isEdit, $isHistory) {
		if( $ns === NS_USER_WALL_MESSAGE && $isDiff ) {
			$app = F::App();
			$wmRef = '';
			$pageHeaderModule->title = $this->getMetatitleFromTitleObject($app->wg->Title, $wmRef);
			$pageHeaderModule->subtitle = Xml::element('a', array('href' => $wmRef->getMessagePageUrl()), $app->wf->Msg('oasis-page-header-back-to-article'));
		}

		return true;
	}

	/**
	 * @desc Helper method which gets meta title from an WallMessage instance; used in WallHooksHelper::onDiffViewHeader() and WallHooksHelper::onPageHeaderEditPage()
	 * @param Title $title
	 * @param mixed $wmRef a variable which value will be created WallMessage instance
	 *
	 * @return String
	 */
	private function getMetatitleFromTitleObject($title, &$wmRef = null) {
		wfProfileIn(__METHOD__);

		$wm = F::build('WallMessage', array($title));

		if( $wm instanceof WallMessage ) {
			$wm->load();
			$metaTitle = $wm->getMetaTitle();
			if( empty($metaTitle) ) {
			//if wall message is a reply
				$wmParent = $wm->getTopParentObj();
				if( $wmParent instanceof WallMessage ) {
					$wmParent->load();
					if( !is_null($wmRef) ) {
						$wmRef = $wmParent;
					}

					wfProfileOut(__METHOD__);
					return $wmParent->getMetaTitle();
				}
			}

			if( !is_null($wmRef) ) {
				$wmRef = $wm;
			}

			wfProfileOut(__METHOD__);
			return $metaTitle;
		}

		wfProfileOut(__METHOD__);
		return '';
	}

	/**
	 * @desc Changes link from User_talk: page to Message_wall: page of the user
	 *
	 * @param int $id id of user who's contributions page is displayed
	 * @param Title $nt instance of Title object of the page
	 * @param Array $tools a reference to an array with links in the header of Special:Contributions page
	 *
	 * @return true
	 */
	public function onContributionsToolLinks($id, $nt, &$tools) {
		wfProfileIn(__METHOD__);

		$app = F::app();

		if( !empty($app->wg->EnableWallExt) && !empty($tools[0]) && $nt instanceof Title ) {
			//tools[0] is the first link in subheading of Special:Contributions which is "User talk" page
			$wallTitle = F::build('Title', array($nt->getText(), NS_USER_WALL), 'newFromText');

			if( $wallTitle instanceof Title ) {
				$tools[0] = Xml::element('a', array(
						'href' => $wallTitle->getFullUrl(),
						'title' => $wallTitle->getPrefixedText(),
				), $app->wf->Msg('wall-message-wall-shorten'));
			}
		}

		wfProfileOut(__METHOD__);
		return true;
	}

	/**
	 * @desc Changes user talk page link to user's message wall link added during MW1.19 migration
	 *
	 * @param integer $userId
	 * @param string $userText
	 * @param $userTalkLink
	 *
	 * @return true
	 */
	public function onLinkerUserTalkLinkAfter($userId, $userText, &$userTalkLink) {
		wfProfileIn(__METHOD__);

		$app = F::app();

		if( !empty($app->wg->EnableWallExt) ) {
			$messageWallPage = Title::makeTitle(NS_USER_WALL, $userText);
			$userTalkLink = Linker::link(
				$messageWallPage,
				wfMsgHtml('wall-message-wall-shorten'),
				array(),
				array(),
				array('known', 'noclasses')
			);
		}

		wfProfileOut(__METHOD__);
		return true;
	}


	public function onArticleBeforeVote(&$user_id, &$page, $vote) {
		$app = F::app();
		$title = Title::newFromId($page);

		if(in_array(MWNamespace::getSubject( $title->getNamespace()  ), $app->wg->WallNS) ) {
			return false;
		}

		return true;
	}

	public static function onBlockIpComplete( $block, $user ) {
		$blockTarget = $block->getTarget();
		if ( $blockTarget instanceof User && $blockTarget->isLoggedIn() ) {
			$vote = new VoteHelper($block->getTarget(), null);
			$vote->invalidateUser();
		}
		return true;
	}

	public function onBeforeCategoryData( &$extraConds ) {
		$app = F::App();

		$excludedNS = $app->wg->WallNS;
		foreach($app->wg->WallNS as $ns) {
			$excludedNS[] = MWNamespace::getTalk( $ns );
		}

		$extraConds[] = 'page_namespace not in('.implode(',', $excludedNS).')';
		return true;
	}

}

