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
	
	protected function replyToMessageBuildResponse($context, $reply) {
		$context->response->setVal('message', $this->app->renderView( 'ForumController', 'threadReply', array( 'comment' => $reply, 'isreply' => true ) ));
	}
	
	/**
     * Create new board ajax call
     * @request boardTitle - title of the board
     * @request boardDescriptiont - description of the board (optional)
     * @response status - [ok|error|accessdenied]
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
        $errormsg = '';
        
        /* backend magic happens here */
        
        /* mock data, remove after backend magic */
        $status = 'ok';
        
        $this->status = $status;
        $this->errormsg = $errormsg;
    }
}