<?php

class ForumExternalController extends WallExternalController {
	public function __construct() {
		$this->app = F::app();
	}
	
	public function getCommentsPage() {
		//workaround to prevent index data expose
		$title = F::build('Title', array($this->request->getVal('pagetitle'), $this->request->getVal('pagenamespace') ), 'newFromText');
		$this->response->setVal( 'html', $this->app->renderView( 'ForumController', 'board', array('title' => $title, 'page' => $this->request->getVal('page', 1) ) )); 
	}
	
	/**
     * Create new board ajax call
     * @request boardTitle - title of the board
     * @request boardDescription - description of the board (optional)
     * @response status - [ok|error|accessdenied]
     * @response errorfield - optional error field.  nullable
     * @response errormsg - optional error message.  nullable
     */
	public function createNewBoard() {
		if(!$this->wg->User->isAllowed('forumadmin')) {
			$this->status = 'accessdenied';
			return;
		}
		
		$boardTitle = $this->getVal('boardTitle', '');
		$boardDescription = $this->getVal('boardDescription', '');
		
		$status = 'error';
		$errorfield = '';
		$errormsg = '';
		
		/* backend magic happens here */
		
		/* mock data, remove after backend magic */
		$status = 'ok';
		$errorfield = 'boardTitle';
		$errormsg = 'Wow title broke';
		
		$this->status = $status;
		$this->errorfield = $errorfield;
		$this->errormsg = $errormsg;
	}

	protected function replyToMessageBuildResponse($context, $reply) {
		$context->response->setVal('message', $this->app->renderView( 'ForumController', 'threadReply', array( 'comment' => $reply, 'isreply' => true ) ));
	}
	
}