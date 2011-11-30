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
	/*
	 * 
	 * Use for external testing of mail template
	 *  http://www.communitycarenc.org/elements/media/images/under-construction.jpg ;)
	 */
	public function mail() {
		
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

	public function previewMessage() {
		$this->app->wf->ProfileIn(__METHOD__);
		
		$this->response->setVal('status', true);
		
		$title = $this->helper->strip_wikitext($this->request->getVal('messagetitle', null));
		$body = $this->request->getVal('body', null);
		
		$helper = F::build('WallHelper', array());

		if( empty($title) ) {
			$title = $helper->getDefaultTitle();
		}
		
		$oTitle = F::build('Title', array($this->request->getVal('username'), NS_USER_WALL), 'newFromText');
		
		//$title = $helper->shortenText($title);
		$body = $helper->getParsedText($body, $oTitle);
		
		list( $displayname, $displayname2 ) = $this->getDisplayName();

		$this->response->setVal('displayname',$displayname);
		$this->response->setVal('displayname2',$displayname2);
		
		$this->response->setVal('title',$title);
		$this->response->setVal('body',$body);
		
		$this->app->wf->ProfileOut(__METHOD__);
	}

	public function postNewMessage() {
		$this->app->wf->ProfileIn(__METHOD__);
		
		$this->response->setVal('status', true);
		
		$titleMeta = $this->helper->strip_wikitext($this->request->getVal('messagetitle', null));
		$body = $this->request->getVal('body', null);
		
		$helper = F::build('WallHelper', array());
		
		if( empty($titleMeta) ) {
			$titleMeta = $helper->getDefaultTitle();
		}
		
		if( empty($body) ) {
			$this->response->setVal('status', false);
			$this->app->wf->ProfileOut(__METHOD__);
			return true;
		}
		
		$wallMessage = F::build('WallMessage', array($body, $this->request->getVal('username'), $this->wg->User, $titleMeta), 'buildNewMessageAndPost'); 
		
		if( $wallMessage === false ) {
			error_log('WALL_NOAC_ON_POST (acStatus)'.print_r($acStatus,1));
			$this->response->setVal('status', false);
			$this->app->wf->ProfileOut(__METHOD__);
			return true;
		}
		
		$wallMessage->load(true);
		$this->response->setVal('message', $this->app->renderView( 'WallController', 'message', array( 'new' => true, 'comment' => $wallMessage ) ));
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
		
		if(empty($ac)) {
			// most likely scenario - can't create AC, because message was already
			// deleted before we tried to edit it
			// client(javascript) should reload user's page
			
			$this->response->setVal('status', false);
			$this->response->setVal('forcereload', true);
			return true;			
		}
		
		$ac->load();
		$data = $ac->getData();
		$this->response->setVal('wikitext', $data['rawtext']  );
		$this->response->setVal('status', true);
		return true;
	}

	public function editMessageSave() {
		$helper = F::build('WallHelper', array());
		
		$msgid = $this->request->getVal('msgid');
		$newtitle = trim($this->request->getVal('newtitle'));
		$newbody = $this->request->getVal('newbody');
		
		if( empty($newtitle) ) {
			$newtitle = $helper->getDefaultTitle();
		}
		
		$title = F::build('Title', array( $msgid ), 'newFromId');
		$wallMessage = F::build('WallMessage', array($title), 'newFromTitle');
		
		$wallMessage->load();

		$wallMessage->setMetaTitle( $newtitle );
		$text = $wallMessage->doSaveComment( $newbody, $this->wg->User );
		 
		$this->response->setVal('isotime', wfTimestamp(TS_ISO_8601) );
		$this->response->setVal('fulltime', $this->wg->Lang->timeanddate( wfTimestamp(TS_MW) ) );
		
		$this->response->setVal('username', $this->wg->User->getName());
		
		$editorUrl = F::build('Title', array( $this->wg->User->getName(), NS_USER), 'newFromText' )->getFullUrl();
		
		$this->response->setVal('userUrl', $editorUrl);
		
		$this->response->setVal( 'historyUrl', $wallMessage->getTitle()->getFullUrl('action=history') );
		
		$this->response->setVal('status', true  );
		$this->response->setVal('title', $newtitle);
		$this->response->setVal('body', $text );
		return true;
	}
		
	public function replyToMessage() {
		$this->response->setVal('status', true);
		
		$parentTitle = F::build('Title', array( $this->request->getVal('parent') ), 'newFromId');
		
		if(empty($parentTitle)) {
			$this->response->setVal('status', false);
			return true;
		}
	
		$wallMessage = F::build('WallMessage', array($parentTitle), 'newFromTitle');
		$reply = $wallMessage->addNewReply($this->request->getVal('body'), $this->wg->User);
		
		if($reply === false) {
			$this->response->setVal('status', false);
			return true;	
		}
		
		$this->response->setVal('message', $this->app->renderView( 'WallController', 'message', array( 'comment' => $reply, 'isreply' => true ) ));
			
		// after successfully posting a reply		
		// remove notification for this thread (if user is following it)
		$wn = F::build('WallNotifications', array());
		$wn->markRead( $this->wg->User->getId(), $this->wg->CityId, $this->request->getVal('parent') );		
		
	}
	
	private function getDisplayName() {
		$displayname = $this->wg->User->getRealName();
		if(empty($displayname))  {
			$displayname  = $this->wg->User->getName();
			$displayname2 = '';
		} else {
			$displayname2 = $this->wg->User->getName();
		}
		return array( $displayname, $displayname2 );
		
	}
	
} // end class Wall
