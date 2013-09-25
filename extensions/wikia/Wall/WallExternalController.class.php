<?php

/**
 * A class which represents a user wall. A Wall is a replacement for the main part of the User_talk page.
 * A Wall consists of "Bricks" which are each a single topic/thread/conversation.
 * In typical use, a Wall will only load a subset of Bricks because there will be a TON of bricks as time goes on.
 */

class WallExternalController extends WikiaController {
	/**
	 * @var $helper WallHelper
	 */
	var $helper;
	public function __construct() {
		$this->app = F::app();
	}

	public function init() {
		$this->helper = new WallHelper();
	}
	/*
	 *
	 * Use for external testing of mail template
	 *  http://www.communitycarenc.org/elements/media/images/under-construction.jpg ;)
	 */
	public function mail() {

	}

	/**
	 * Move thread (TODO: Should this be in Forums?)
	 */
	public function moveModal() {

		$id = $this->getVal('id');
		$wm = WallMessage::newFromId($id);

		if(empty($wm)) {
			return true;
		}

		/** @var $mainWall WallMessage */
		$mainWall = $wm->getWall();

		if ( !$this->wg->User->isAllowed( 'wallmessagemove' ) ) {
			$this->displayRestrictionError();
			return false;
			// skip rendering
		}

		$forum = new Forum();

		$list = $forum->getListTitles(DB_SLAVE, NS_WIKIA_FORUM_BOARD);

		$this->destinationBoards = array( array( 'value' => '', 'content' => wfMsg( 'forum-board-destination-empty' ) ) );
		/** @var $title Title */
		foreach ( $list as $title ) {
			$value = $title->getArticleID();
			if($mainWall->getId() != $value) {
				$wall = Wall::newFromTitle($title);
				$this->destinationBoards[$value] = array( 'value' => $value, 'content' => htmlspecialchars( $wall->getTitle()->getText() ) );
			}
		}
	}

	/**
	 * Moves thread
	 * @request destinationBoardId - id of destination board
	 * @request rootMessageId - thread id
	 */
	public function moveThread() {
		// permission check needed here
		if ( !$this->wg->User->isAllowed( 'wallmessagemove' ) ) {
			$this->displayRestrictionError();
			return false;
			// skip rendering
		}

		$this->status = 'error';

		$destinationId = $this->getVal('destinationBoardId', '');
		$threadId = $this->getVal('rootMessageId', '');

		if(empty($destinationId)) {
			$this->errormsg = wfMsg('wall-action-move-validation-select-wall');
			return true;
		}

		$wall = Wall::newFromId( $destinationId );
		$thread = WallThread::newFromId( $threadId );

		if(empty($wall)) {
			$this->errormsg = 'unknown';
		}


		$thread->move($wall, $this->wg->User);
		$this->status = 'ok';
	}

	public function votersModal() {
		/**
		 * @var $mw WallMessage
		 */
		$mw =  WallMessage::newFromId($this->request->getVal('id'));

		$this->response->setVal('list',
			$this->app->renderView( 'WallExternalController', 'votersListItems',
				array( 'from' => 0, 'mw' => $mw, 'id' => $this->request->getVal('id') )
		));

		$this->response->setVal('count', $mw->getVoteCount());
	}

	public function votersListItems() {
		//TODO: imaplmant load more button

		/**
		 * @var $mw WallMessage
		 */
		$mw = $this->request->getVal('mw');
		if(empty($mw)) {
			$mw =  WallMessage::newFromId($this->request->getVal('id'));
		}

		$from = (int) $this->request->getVal( 'from', 0 );

		$list = $mw->getVotersList($from, 1000);

		if(count($list) == 26) {
			$this->response->setVal( 'hasmore', true );
		} else {
			$this->response->setVal( 'hasmore', false );
		}

		$out = array();
		for( $i = 0; $i < min(count($list),24); $i++ ) {
			$user = User::newFromId( $list[$i] );
			if(!empty($user)) {
				$out[] = array(
					'profilepage' =>  $user->getUserPage()->getFullUrl(),
					'name' => $user->getName(),
					'avatar' => AvatarService::getAvatarUrl($user->getName(), 50)
				);
			}
		}

		$this->response->setVal( 'hasmore', false );
		$this->response->setVal( 'last', $from );
		$this->response->setVal( 'list', $out );
	}

	public function switchWatch() {
		$this->response->setVal('status', false);
		$isWatched = $this->request->getVal('isWatched');
		/**
		 * @var $title Title
		 * @var $wallMessage WallMessage
		 */
		$title = Title::newFromId( $this->request->getVal('commentId') );
		$wallMessage = WallMessage::newFromTitle($title);

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
		wfProfileIn(__METHOD__);
		$relatedTopics = $this->request->getVal('relatedTopics', array());

		$this->response->setVal('status', true);

		/**
		 * BugId:68629 XSS vulnerable. We DO NOT want to have
		 * any HTML here. Hence the strip_tags call.
		 */
		$titleMeta = strip_tags( $this->request->getVal( 'messagetitle', null ) );
		$titleMeta = substr($titleMeta, 0, 200);

		$body = $this->getConvertedContent($this->request->getVal('body'));

		/**
		 * @var $helper WallHelper
		 */
		$helper = new WallHelper();

		if( empty($titleMeta) ) {
			$titleMeta = $helper->getDefaultTitle();
		}

		if( empty($body) ) {
			$this->response->setVal('status', false);
			wfProfileOut(__METHOD__);
			return true;
		}

		$ns = $this->request->getVal( 'pagenamespace' );
		$notifyEveryone = false;
		if ( $helper->isAllowedNotifyEveryone( $ns, $this->wg->User ) ) {
			$notifyEveryone = $this->request->getVal( 'notifyeveryone', false ) == 1;
		}

		$title = Title::newFromText( $this->request->getVal('pagetitle'), $ns );
		$wallMessage = WallMessage::buildNewMessageAndPost($body, $title, $this->wg->User, $titleMeta, false, $relatedTopics, true, $notifyEveryone);

		if( $wallMessage === false ) {
			error_log('WALL_NOAC_ON_POST');
			$this->response->setVal('status', false);
			wfProfileOut(__METHOD__);
			return true;
		}

		$wallMessage->load(true);
		$this->response->setVal('message', $this->app->renderView( 'WallController', 'message', array( 'new' => true, 'comment' => $wallMessage ) ));
		wfProfileOut(__METHOD__);
	}

	public function deleteMessage() {
		$result = false;
		/**
		 * @var $mw WallMessage
		 */
		$mw =  WallMessage::newFromId($this->request->getVal('msgid'));
		if( empty($mw) ) {
			$this->response->setVal('status', false);
			return true;
		}

		$formassoc = $this->processModalForm($this->request);

		$reason = isset($formassoc['reason']) ? $formassoc['reason'] : '';
		$notify = isset($formassoc['notify-admin']) ? true : false;

		if( empty($reason) && !$this->request->getVal('mode') == 'rev' ) {
			$this->response->setVal('status', false);
			return true;
		}

		$isDeleteOrRemove = true;

		switch( $this->request->getVal('mode') ) {
			case 'rev':
				if($mw->canDelete($this->wg->User)) {
					$result = $mw->delete(wfMsgForContent('wall-delete-reason'), true);
					$this->response->setVal('status', $result);
					return true;
				} else {
					$this->response->setVal('error', wfMsg('wall-message-no-permission'));
				}
			break;

			case 'admin':
				if($mw->canAdminDelete($this->wg->User)) {
					$result = $mw->adminDelete($this->wg->User, $reason, $notify);
					$this->response->setVal('status', $result);
					$isDeleteOrRemove = true;
				} else {
					$this->response->setVal('error', wfMsg('wall-message-no-permission'));
				}
			break;

			case 'fastadmin':
				if($mw->canFastAdminDelete($this->wg->User)) {
					$result = $mw->fastAdminDelete($this->wg->User, $reason, $notify);
					$this->response->setVal('status', $result);
					$isDeleteOrRemove = true;
				} else {
					$this->response->setVal('error', wfMsg('wall-message-no-permission'));
				}
			break;

			case 'remove':
				if( $mw->canRemove($this->wg->User) ) {
					$this->response->setVal('status', $result);
					$result = $mw->remove($this->wg->User, $reason, $notify);

					$this->response->setVal('status', $result);
					// TODO: log/save data
					$isDeleteOrRemove = true;
				} else {
					$this->response->setVal('error', wfMsg('wall-message-no-permission'));
				}
			break;
		}

		if($isDeleteOrRemove) {
			$this->response->setVal('html', $this->app->renderView( 'WallController', 'messageRemoved', array('showundo' => true , 'comment' => $mw)));
			$mw->getLastActionReason();
			$this->response->setVal('deleteInfoBox', 'INFO BOX');
		}

		$this->response->setVal('status', $result);
		return true;
	}

	public function changeThreadStatus() {
		$result = false;
		$newState = $this->request->getVal('newState', false);
		/**
		 * @var $mw WallMessage
		 */
		$mw =  WallMessage::newFromId($this->request->getVal('msgid'));

		if( empty($mw) || empty($newState) ) {
			$this->response->setVal('status', false);
			return true;
		}

		$formassoc = $this->processModalForm($this->request);
		$reason = isset($formassoc['reason']) ? $formassoc['reason'] : '';

		switch($newState) {
			case 'close':
				if($mw->canArchive($this->wg->User)) {
					$result = $mw->archive($this->wg->User, $reason);
				}
				break;
			case 'open':
				if($mw->canReopen($this->wg->User)) {
					$result = $mw->reopen($this->wg->User);
				}
				break;
			default:
				break;
		}

		$this->response->setVal('status', $result);
	}

	/**
	 * @param $request WebRequest
	 * @return array
	 */
	protected function processModalForm($request) {
		/**
		 * @var $formdata array
		 */
		$formdata = $request->getVal('formdata');

		$formassoc = array();
		if(!empty($formdata)) {
			foreach($formdata as $value) {
				$formassoc[ $value['name'] ] = $value['value'];
			}
		}
		return $formassoc;
	}

	public function undoAction() {
		/**
		 * @var $mw WallMessage
		 */
		$mw = WallMessage::newFromId($this->request->getVal('msgid'));
		if( empty($mw) ) {
			$this->response->setVal('status', false);
			return true;
		}

		if($mw->isAdminDelete() && $mw->isRemove() && $mw->canRestore($this->wg->User)) {
			$mw->undoAdminDelete($this->wg->User);
			$this->response->setVal('status', true);
			return true;
		}

		if(
			($mw->isRemove() && $mw->canRestore($this->wg->User)) ||
			($mw->isAdminDelete() || !$mw->isRemove() && $mw->canRestore($this->wg->User))

		){
			$mw->restore($this->wg->User);
			$this->response->setVal('status', true);
			return true;
		}
	}

	public function restoreMessage() {
		/**
		 * @var $mw WallMessage
		 */
		$mw =  WallMessage::newFromId($this->request->getVal('msgid'));
		if( empty($mw) ) {
			$this->response->setVal('status', false);
			return true;
		}

		if($mw->canRestore($this->wg->User)) {
			$formassoc = $this->processModalForm($this->request);

			$reason = isset($formassoc['reason']) ? $formassoc['reason'] : '';

			if( empty($reason) && !$mw->canFastrestore($this->wg->User) ) {
				$this->response->setVal('status', false);
				return true;
			}

			$mw->restore($this->wg->User, $reason);

			$this->response->setVal('buttons', $this->app->renderView( 'WallController', 'messageButtons', array('comment' => $mw)));
			$this->response->setVal('status', true);
		}
	}

	public function vote() {
		$id = $this->request->getVal('id');
		$dir  = $this->request->getVal('dir');

		/**
		 * @var $mw WallMessage
		 */
		$mw =  WallMessage::newFromId($id);

		if(!empty($mw)) {
			if($dir == 1) {
				$this->response->setVal('count', $mw->vote($this->wg->User));
			}

			if($dir == -1) {
				$this->response->setVal('count', $mw->removeVote($this->wg->User));
			}
		}

	}

	public function editMessage() {
		//TODO: remove call to ac !!!
		$msgid = $this->request->getVal('msgid');
		/**
		 * @var $mw WallMessage
		 */
		$mw =  WallMessage::newFromId($msgid);

		if(empty($mw)) {
			// most likely scenario - can't create AC, because message was already
			// deleted before we tried to edit it
			// client(javascript) should reload user's page

			$this->response->setVal('status', false);
			$this->response->setVal('forcereload', true);
			return true;
		}

		$text = $mw->getRawText();

		//WallMessage getRawText returns wikitext
		//so convert it to richtext only if needed as
		//RTE::HtmlToWikitext will fail if wikitext is passed as content
		//(BugId: 32591)
		$convertToFormat = $this->request->getVal('convertToFormat', '');
		if($convertToFormat == 'richtext'){
			$text = $this->getConvertedContent($text);
		}

		$this->response->setVal('htmlorwikitext', $text);
		$this->response->setVal('status', true);

		return true;
	}

	public function notifyEveryoneSave() {
		$msgid = $this->request->getVal('msgid');
		$dir = $this->request->getVal('dir');
		/**
		 * @var $mw WallMessage
		 */
		$mw =  WallMessage::newFromId($msgid);

		if($dir == 1) {
			$mw->setNotifyeveryone(true, true);
			$this->response->setVal('newdir', 0);
			$this->response->setVal('newmsg', wfMsg('wall-message-unnotifyeveryone'));
		} else {
			$mw->setNotifyeveryone(false, true);
			$this->response->setVal('newdir', 1);
			$this->response->setVal('newmsg', wfMsg('wall-message-notifyeveryone'));
		}
	}

	public function editMessageSave() {
		/**
		 * @var $helper WallHelper
		 */
		$helper = new WallHelper();

		$msgid = $this->request->getVal('msgid');
		$newtitle = trim($this->request->getVal('newtitle'));

		$newbody = $this->getConvertedContent($this->request->getVal('newbody'));

		if( empty($newtitle) ) {
			$newtitle = $helper->getDefaultTitle();
		}

		$title = Title::newFromId( $msgid );

		if( empty( $title ) ){
			$this->response->setVal( 'status', false) ;
			$this->response->setVal( 'msgTitle', wfMsg(' wall-delete-error-title' ) );
			$this->response->setVal( 'msgContent', wfMsg( 'wall-deleted-msg-text' ) );
			return true;
		}
		/**
		 * @var $wallMessage WallMessage
		 */
		$wallMessage = WallMessage::newFromTitle( $title );

		$wallMessage->load();

		$wallMessage->setMetaTitle($newtitle);
		$text = $wallMessage->doSaveComment( $newbody, $this->wg->User, '', false, true );

		$this->response->setVal('isotime', wfTimestamp(TS_ISO_8601) );
		$this->response->setVal('fulltime', $this->wg->Lang->timeanddate( wfTimestamp(TS_MW) ) );

		$this->response->setVal('username', $this->wg->User->getName());

		$editorUrl = Title::newFromText( $this->wg->User->getName(), NS_USER)->getFullUrl();

		$this->response->setVal('userUrl', $editorUrl);

		$query = array(
			'diff' => 'prev',
			'oldid' => $wallMessage->getTitle()->getLatestRevID(Title::GAID_FOR_UPDATE),
		);

		$this->response->setVal( 'historyUrl', $wallMessage->getTitle()->getFullUrl($query) );

		$this->response->setVal('status', true);
		$this->response->setVal('msgTitle', Xml::element('a', array('href' => $wallMessage->getMessagePageUrl()), $newtitle));
		$this->response->setVal('body', $text );
		return true;
	}

	public function replyToMessage() {
		$this->response->setVal('status', true);

		$parentId = $this->request->getVal('parent');
		$parentTitle = Title::newFromId( $parentId );
		$debugParentDB = 'from slave';   // tracing bug 95249

		if(empty($parentTitle)) {
			// try again from master
			$parentTitle = Title::newFromId( $parentId, Title::GAID_FOR_UPDATE );
			$debugParentDB = 'from master';
		}

		if(empty($parentTitle)) {
			$this->response->setVal('status', false);
			return true;
		}

		Wikia::log( __METHOD__, false, 'Wall::replyToMessage for parent ' . $parentTitle->getFullUrl() . ' (parentId: ' . $parentId . ') ' . $debugParentDB, true );

		/**
		 * @var $wallMessage WallMessage
		 */
		$wallMessage = WallMessage::newFromTitle($parentTitle);
		$body = $this->getConvertedContent($this->request->getVal('body'));
		$reply = $wallMessage->addNewReply($body, $this->wg->User);

		if($reply === false) {
			$this->response->setVal('status', false);
			return true;
		}

		$quotedFrom = $this->request->getVal('quotedFrom');

		if(!empty($quotedFrom)) {
			$reply->setQuoteOf($quotedFrom);
		}

		$this->replyToMessageBuildResponse($this, $reply);

		// after successfully posting a reply
		// remove notification for this thread (if user is following it)
		/**
		 * @var $wn WallNotifications
		 */
		$wn = new WallNotifications();
		$wn->markRead( $this->wg->User->getId(), $this->wg->CityId, $this->request->getVal('parent'));

	}

	public function preview() {

		$body = $this->getConvertedContent( $this->request->getVal('body', ''));
		$service = new EditPageService($this->wg->Title);

		$out = $service->getPreview($body);

		$metatitle = $this->request->getVal('metatitle', '');

		if(!empty($metatitle)) {
			$metatitle = '<div class="msg-title"><span>'.htmlspecialchars($metatitle).'</span></div>';
		}

		$this->response->setVal('body', $metatitle.$out[0]);
	}

	protected function replyToMessageBuildResponse($context, $reply) {
		$context->response->setVal('message', $this->app->renderView( 'WallController', 'message', array( 'comment' => $reply, 'isreply' => true ) ));
	}

	private function getDisplayName() {
		$displayname  = $this->wg->User->getName();
		$displayname2 = '';

		return array( $displayname, $displayname2 );

	}

	/**
	 * Handles converting wikitext to richtext and vice versa.
	 *
	 * @param string $text - the text to convert
	 * @return string - the converted text
	 */
	private function getConvertedContent($content = '') {
		if ($this->wg->EnableMiniEditorExtForWall && !empty($content)) {
			$convertToFormat = $this->request->getVal('convertToFormat', '');

			if (!empty($convertToFormat)) {
				$content = MiniEditorHelper::convertContent($content, $convertToFormat, $this->response);
			}
		}

		return $content;
	}


	public function getCommentsPage() {
		//workaround to prevent index data expose
		$title = Title::newFromText($this->request->getVal('pagetitle'), $this->request->getVal('pagenamespace') );
		$this->response->setVal( 'html', $this->app->renderView( 'WallController', 'index', array('title' => $title, 'page' => $this->request->getVal('page', 1) ) ));
	}

	/**
	 * Returns formatted quote wiki text given message id
	 * @param string $messageId - numeric id
	 * @param string $convertToFormat - 'wikitext' or 'richtext'.  'wikitext' if unspecified
	 * @return string markup - formatted markup (escaped)
	 * @return string status - success/failure
	 */
	public function getFormattedQuoteText() {
		$messageId = $this->request->getVal('messageId', '');
		$markup = '';
		$status = 'failure';

		/**
		 * @var $mw WallMessage
		 */
		$mw = WallMessage::newFromId($messageId);
		$mw->load();

		if(!empty($mw)) {
			$username = $mw->getUser()->getName();

			$convertToFormat = $this->request->getVal('convertToFormat', '');

			if($convertToFormat == 'wikitext') {
				$markup = '<div class="quote">' . "\n" . wfMsgForContent('wall-quote-author', $username) . "\n" . $mw->getRawText() . "\n</div>\n";
			} else {
				$markup = $this->getConvertedContent('<div class="quote">' . wfMsgForContent('wall-quote-author', $username) . "<br>" . $mw->getRawText() . "\n</div><br>");
			}

			$status = 'success';
		}

		$this->response->setVal('markup', $markup);
		$this->response->setVal('status', $status);
	}

	/**
	 * Updates topics list to given message id.  It will completely override.
	 * @param string $messageId - numeric id
	 * @param array $relatedTopics - list of topics (article names)
	 * @return string status - success/failure
	 */
	public function updateTopics() {
		$messageId = $this->request->getVal('msgid', '');
		$relatedTopics = $this->request->getVal('relatedTopics', array());
			// place holder data, replace this with magic
		$status = 'success';
		$topics = array();

		if(!is_array($relatedTopics)) {
			$relatedTopics = array();
		}

		// cut more then 4
		$relatedTopics = array_slice( $relatedTopics , 0, 4 );

		// save
		/**
		 * @var $mw WallMessage
		 */
		$mw =  WallMessage::newFromId($messageId);

		if(!empty($mw)) {
			$mw->load();
			$mw->setRelatedTopics( $this->wg->User, $relatedTopics);
		}

		foreach($relatedTopics as $topic) {
			$topicTitle = Title::newFromURL($topic);
			$topics[] = array( 'topic' => $topic, 'url' => WallHelper::getTopicPageURL($topicTitle) );	// I have no idea what the url will be, just a placeholder for now
		}
		// end place holder

		$this->response->setVal('status', $status);
		$this->response->setVal('topics', $topics);
	}
}
