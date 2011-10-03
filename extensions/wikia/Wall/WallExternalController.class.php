<?php

/**
 * A class which represents a user wall. A Wall is a replacement for the main part of the User_talk page.
 * A Wall consists of "Bricks" which are each a single topic/thread/conversation.
 * In typical use, a Wall will only load a subset of Bricks because there will be a TON of bricks as time goes on.
 */
class WallExternalController extends WikiaController {
	var $helper;
	public function __construct() {
		$this->app = F::app();
	}
	
	public function init() {
		$this->helper = F::build('WallHelper', array());
	}
	
	public function getCommentsPage() {
		//workaround to prevent index data expose
		$title = F::build('Title', array($this->request->getVal('username'), NS_USER_WALL ), 'newFromText');
		$this->response->setVal( 'html', $this->app->renderView( 'WallController', 'index', array('title' => $title, 'page' => $this->request->getVal('page', 1) ) ));
	}

	public function switchWatch() {
		$this->response->setVal('status', false);
		$isWatched = $this->request->getVal('isWatched');
		$title = F::build('Title', array( $this->request->getVal('commentId') ), 'newFromId');
		$wallMessage = F::build('WallMessage', array($title), 'newFromTitle');
		
		if($this->wg->User->getId() > 0  && !$wallMessage->isWallOwner($this->wg->User) ) {
			if($isWatched) {
				$wallMessage->removeWatch($this->wg->User);	
			} else {
				$wallMessage->addWatch($this->wg->User);
			}
			
			$this->response->setVal('status', true);	
		}	
	}

	public function postNewMessage() {
		$this->app->wf->ProfileIn(__METHOD__);
		
		$this->response->setVal('status', true);
		
		$userPageTitle = F::build('Title', array($this->request->getVal('username'), NS_USER_WALL), 'newFromText');
		
		$title = trim($this->request->getVal('title', null));
		$body = $this->request->getVal('body', null);
		
		if( empty($title) ) {
			$name = $this->wg->User->getRealName();
			if (empty($name)) $name = $this->wg->User->getName();
			$title = $this->wf->msg('wall-default-title') . ' ' . $name;
		}
		
		if( empty($body) || empty($userPageTitle) ) {
			$this->response->setVal('status', false);
			$this->app->wf->ProfileOut(__METHOD__);
			return true;
		}
		
		$helper = F::build('WallHelper', array());
		$acStatus = F::build('ArticleComment', array($body, $this->wg->User, $userPageTitle, false, array('title' => $title) ), 'doPost');
		
		if($acStatus === false) {
			$this->response->setVal('status', false);
			$this->app->wf->ProfileOut(__METHOD__);
			return true;
		}
		
		$ac = ArticleComment::newFromId($acStatus[1]->getId());
		$ac->load(true);
		$this->response->setVal('message', $this->app->renderView( 'WallController', 'message', array( 'new' => true, 'comment' => $ac ) ));
		$this->app->wf->ProfileOut(__METHOD__);
	}
	
	public function removeMessage() {
		//TODO: remember to delete all replies in a thread when msg id deleted
		$title = F::build('Title', array( $this->request->getVal('msgid') ), 'newFromId');
		$ac =  F::build('WallMessage', array($title), 'newFromTitle');
		$ac->load(true);
		$result = !empty($ac) && $ac->canDelete($this->wg->User) && $ac->doDeleteComment(wfMsgForContent('wall-delete-reason'), false, true);
		
		F::build('NotificationsModule', array(), 'clearConfirmation');
		
		$this->response->setVal('status', $result);
		return true;
	}

	public function editMessage() {
		$msgid = $this->request->getVal('msgid');
		
		$ac = ArticleComment::newFromId($msgid);
		$ac->load();
		$data = $ac->getData();
		$this->response->setVal('wikitext', $data['rawtext']  );
		$this->response->setVal('status', true);
		return true;
	}

	public function editMessageSave() {
		$msgid = $this->request->getVal('msgid');
		$newtitle = trim($this->request->getVal('newtitle'));
		$newbody = $this->request->getVal('newbody');
		
		if( empty($newtitle) ) {
			$name = $this->wg->User->getRealName();
			if (empty($name)) $name = $this->wg->User->getName();
			$newtitle = $this->wf->msg('wall-default-title') . ' ' . $name;
		}
		
		$ac = ArticleComment::newFromId($msgid);
		$ac->load();
		//TODO: validate title ???
		$ac->setMetaData( 'title', $newtitle);
		$ac->doSaveComment( $newbody, $this->wg->User );
		
		$this->response->setVal('status', true  );
		$this->response->setVal('title', $newtitle);
		$this->response->setVal('body', $ac->parseText( $newbody ));
		return true;
	}
		
	//TODO: fix this c&p
	public function replyToMessage() {
		$this->response->setVal('status', true);
		
		$title = F::build('Title', array($this->request->getVal('username'), NS_USER_WALL), 'newFromText');
		
		if(empty($title)) {
			$this->response->setVal('status', false);
			return true;
		}
		
		$helper = F::build('WallHelper', array());
		$acStatus = F::build('ArticleComment', array($this->request->getVal('body'), $this->wg->User, $title, $this->request->getVal('parent') ), 'doPost');
		
		if($acStatus === false) {
			$this->response->setVal('status', false);
			return true;	
		}
		
		$ac = ArticleComment::newFromId($acStatus[1]->getId());
		$this->response->setVal('message', $this->app->renderView( 'WallController', 'message', array( 'comment' => $ac, 'isreply' => true ) ));
	}
} // end class Wall
