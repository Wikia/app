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
}