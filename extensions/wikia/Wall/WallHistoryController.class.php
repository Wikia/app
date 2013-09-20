<?php 
class WallHistoryController extends WallController {
	private $isThreadLevel = false;
	
	public function __construct() {
		parent::__construct();
	}
	
	public function index() {
		JSMessages::enqueuePackage('Wall', JSMessages::EXTERNAL);
		$title = $this->app->wg->Title;
		
		$this->isThreadLevel = $this->request->getVal('threadLevelHistory', false);
		
		$path = array();
		
		if( $this->isThreadLevel ) {
			$threadId = intval($title->getDBkey());
			$title = Title::newFromId($threadId);
		}
		
		$this->historyPreExecute();
		$page = $this->request->getVal('page', 1);
		$page = ( ($page = intval($page)) === 0) ? 1 : $page;
		
		$this->response->setVal('sortingOptions', $this->getSortingOptions());
		$this->response->setVal('sortingSelected', $this->getSortingSelectedText());
		$this->response->setVal('wallHistoryMsg', $this->getHistoryMessagesArray());
		$this->response->setVal('currentPage', $page);
		$this->response->setVal('isThreadLevelHistory', $this->isThreadLevel);
		
		
		if( !($title instanceof Title) || 
			($this->isThreadLevel && 
			!in_array(MWNamespace::getSubject($title->getNamespace() ), $this->app->wg->WallNS)) 
		) {
		//paranoia -- why the message is not in DB
			$this->response->setVal('wallmessageNotFound', true);
			return;
		}
		
		if( $this->isThreadLevel ) {
			$wallMessage = new WallMessage($title);
			$wallMessage->load();
			$wallOwnerUser = $wallMessage->getWallOwner();
			
			$perPage = 50;
			$wallHistory = new WallHistory();
			$wallHistory->setPage($page, $perPage);
			$count = $wallHistory->getCount(null, $threadId);
			$sort = $this->getSortingSelected();
			$history = $wallHistory->get(null, $sort, $threadId);
			$this->response->setVal('wallHistory', $this->getFormatedHistoryData($history, $threadId));
			
			$path[] = array(
				'title' =>  $wallMessage->getMetatitle(),
				'url' => $wallMessage->getMessagePageUrl() 
			); 			
			
			$wallUrl =  $wallMessage->getArticleTitle()->getFullUrl();
			$wallOwnerName =  $wallMessage->getArticleTitle()->getText();
						
			$this->response->setVal('wallHistoryUrl', $wallMessage->getMessagePageUrl(true).'?action=history&sort='.$sort);
		} else {			
			$perPage = 100;
			$wallHistory = (new WallHistory);
			$wallHistory->setPage($page, $perPage);
			$sort = $this->getSortingSelected();
			if( $title->exists() ) {
				$count = $wallHistory->getCount($title->getArticleId(), null, false);
				$history = $wallHistory->get($title->getArticleId(), $sort, null, false);					
			} else {
				$count = 0;
				$history = array();
			}
						
			$wallUrl = $title->getFullUrl();
			$wallOwnerName = $title->getText();
			
			$this->response->setVal('wallHistory', $this->getFormatedHistoryData($history));
			$this->response->setVal('wallHistoryUrl', $title->getFullURL(array('action' => 'history', 'sort' => $sort)));
		}
			
		$path = array_merge(array(array(
			'title' => wfMsg('wall-message-elseswall', array($wallOwnerName)),
			'url' => $wallUrl 
		)), $path); 
		
		$this->response->setVal('wallOwnerName', $wallOwnerName);

		if( $this->isThreadLevel ) {
			$this->response->setVal( 'pageTitle' , wfMsg('wall-thread-history-title'));
			wfRunHooks('WallHistoryThreadHeader', array($title, $wallMessage, &$path, &$this->response, &$this->request));
		} else {
			$this->response->setVal( 'pageTitle' , wfMsg('wall-history-title'));
			wfRunHooks('WallHistoryHeader', array($title, &$path, &$this->response, &$this->request));
		}
		
		$this->response->setVal('path', $path);
		$this->response->setVal('totalItems', $count);
		$this->response->setVal('itemsPerPage', $perPage);
		$this->response->setVal('showPager', ($count > $perPage));
	}
	
	public function threadHistory() {
		//this method is only to load other template
		//all template variables and logic can be found
		//in method above -- WallHistoryController::index()
	}
	
	private function historyPreExecute() {
		$this->response->addAsset('wall_history_js');
		$this->response->addAsset('extensions/wikia/Wall/css/WallHistory.scss');
		
		if( $this->isThreadLevel ) {
			$this->wg->Out->setPageTitle( wfMsg('wall-thread-history-title') );
			$this->app->wg->SuppressPageHeader = true;
		} else {
			$this->wg->Out->setPageTitle( wfMsg('wall-history-title') );
		}
		
		$this->wg->Out->setPageTitleActionText( wfMsg('history_short') );
		$this->wg->Out->setArticleFlag(false);
		$this->wg->Out->setArticleRelated(true);
		$this->wg->Out->setRobotPolicy('noindex,nofollow');
		$this->wg->Out->setSyndicated(true);
		$this->wg->Out->setFeedAppendQuery('action=history');
		
		$this->sortingType = 'history';
	}
	
	private function getHistoryMessagesArray() {
		if( $this->isThreadLevel ) {
			return array(
				'thread-'.WH_NEW => 'wall-thread-history-thread-created',
				'reply-'.WH_NEW => 'wall-thread-history-reply-created',
				'thread-'.WH_REMOVE => 'wall-thread-history-thread-removed',
				'reply-'.WH_REMOVE => 'wall-thread-history-reply-removed',
				'thread-'.WH_RESTORE => 'wall-thread-history-thread-restored',
				'reply-'.WH_RESTORE => 'wall-thread-history-reply-restored',
				'thread-'.WH_DELETE => 'wall-thread-history-thread-deleted',
				'reply-'.WH_DELETE => 'wall-thread-history-reply-deleted',
				'thread-'.WH_EDIT => 'wall-thread-history-thread-edited',
				'reply-'.WH_EDIT => 'wall-thread-history-reply-edited',
				'thread-'.WH_ARCHIVE => 'wall-thread-history-thread-closed',
				'thread-'.WH_REOPEN => 'wall-thread-history-thread-reopened',
			);
		} else {
			return array(
				WH_NEW => 'wall-history-thread-created', 
				WH_REMOVE => 'wall-history-thread-removed', 
				WH_RESTORE => 'wall-history-thread-restored',
				WH_DELETE => 'wall-history-thread-admin-deleted',
			);
		}
	}
	
	private function getFormatedHistoryData($history, $threadId = 0) {
		foreach($history as $key => $value) {
			$type = intval($value['action']);
			
			if( !$this->isThreadLevel && !in_array($type, array(WH_NEW, WH_REMOVE, WH_RESTORE, WH_DELETE)) ) {
				unset($history[$key]);
				continue;
			}
			
			$title = $value['title'];
			$wm = new WallMessage($title);
			$user = $value['user'];
			$username = $user->getName();

			$url = Title::newFromText( $username, $this->wg->EnableWallExt ? NS_USER_WALL : NS_USER_TALK )->getFullUrl();
			
			if( $user->isAnon() ) {
				$name = wfMsg('oasis-anon-user');
				$history[$key]['displayname'] = wfMsg( 'wall-history-username-full', array('$1' => $name, '$2' => $username, '$3' => $url ));
			} else {
				$history[$key]['displayname'] = wfMsg( 'wall-history-username-short', array('$1' => $username, '$2' => $url ));
			}
			
			$history[$key]['authorurl'] = $url;
			$history[$key]['username'] = $user->getName();
			$history[$key]['userpage'] = $url;
			$history[$key]['type'] = $type;
			$history[$key]['usertimeago'] = $this->wg->Lang->timeanddate($value['event_mw']);
			$history[$key]['reason'] = $value['reason'];
			$history[$key]['actions'] = array();
			
			if( $this->isThreadLevel ) {
				$history[$key]['isreply'] = $isReply = $value['is_reply'];
				$history[$key]['prefix'] = ($isReply === '1') ? 'reply-' : 'thread-';
				
				if( intval($value['page_id']) === $threadId ) {
				//if the entry is about change in top message
				//hardcode the order number to 1
					$history[$key]['msgid'] = 1;
				} else {
					$history[$key]['msgid'] = $wm->getOrderId();
				}
				
				$wm->load();
				$messagePageUrl = $wm->getMessagePageUrl();
				$history[$key]['msgurl'] = $messagePageUrl;
				
				$msgUser = $wm->getUser();
				$history[$key]['msguserurl'] = Title::newFromText( $msgUser->getName(), NS_USER_WALL )->getFullUrl();
				$history[$key]['msgusername'] = $msgUser->getName();
			
				
				if( $type == WH_EDIT ) {
					$rev = Revision::newFromTitle($title);
					// mech: fixing 20617 - revision_id is available only for new entries
					$query = array(
						'diff' => 'prev',
						'oldid' => ( $history[$key]['revision_id'] ) ? $history[$key]['revision_id'] : $title->getLatestRevID(),
					);
					
					$history[$key]['actions'][] = array(
						'href' => $rev->getTitle()->getLocalUrl($query),
						'msg' => wfMsg('diff'),
					);
				}
			} else {
				$msgUrl = $wm->getMessagePageUrl(true);
				$history[$key]['msgurl'] = $msgUrl;
				$history[$key]['historyLink'] = Xml::element('a', array('href' => $msgUrl.'?action=history'), wfMsg('wall-history-action-thread-history'));
			}
			
			if( ($type == WH_REMOVE && !$wm->isAdminDelete()) || ($type == WH_DELETE && $wm->isAdminDelete()) ) {
				if( $wm->canRestore($this->app->wg->User) ) {
					if( $this->isThreadLevel ) {
						$restoreActionMsg = ($isReply === '1') ? wfMsg('wall-history-action-restore-reply') : wfMsg('wall-history-action-restore-thread');
					} else {
						$restoreActionMsg = wfMsg('wall-history-action-restore');
					}
					
					$history[$key]['actions'][] = array(
						'class' => 'message-restore', //TODO: ?
						'data-id' => $value['page_id'],
						'data-mode' => 'restore'.($wm->canFastrestore($this->app->wg->User) ? '-fast' : ''),
						'href' => '#',
						'msg' => $restoreActionMsg
					);
				}
			}
			
			$userid = $user->getId();
			if( $user->isAnon() ) WallRailController::addAnon($userid, $user);
			else WallRailController::addUser($userid, $user);
		}
		
		return $history;
	}
	
}
