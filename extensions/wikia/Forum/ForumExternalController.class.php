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
		 
		$this->status = 'error';
		$this->errorfield = '';
		$this->errormsg = '';
		
		// Reject illegal characters.
		$rxTc = Title::getTitleInvalidRegex();
		if ( preg_match( $rxTc, $boardTitle ) ) {
			$this->errorfield = 'boardTitle';
			$this->errormsg = wfMsg('forum-board-title-validation-invalid');
			return true;
		}
		
		$titleLength = strlen( $boardTitle );
		if( $titleLength > 40 || $titleLength < 4 ) {
			$this->errorfield = 'boardTitle';
			$this->errormsg = wfMsg( 'forum-board-title-validation-length' );	
			return true;		
		}
		
		$descriptionLength = strlen( $boardDescription );
		
		if( $descriptionLength > 255 || $descriptionLength < 4 ) {
			$this->errorfield = 'boardDescription';
			$this->errormsg = wfMsg( 'forum-board-description-validation-length' );
			return true;			
		}

		$forum = new Forum();
		$forum->createBoard($boardTitle, $boardDescription);	

		$this->status = 'ok';;
		$this->errorfield = '';
		$this->errormsg = '';
	}

	protected function replyToMessageBuildResponse($context, $reply) {
		$context->response->setVal('message', $this->app->renderView( 'ForumController', 'threadReply', array( 'comment' => $reply, 'isreply' => true ) ));
	}
	
}