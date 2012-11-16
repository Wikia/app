<?php
class RelatedForumDiscussionController extends WikiaController {
	
	public function init() {
		
	}
	
	public function index() {
	
		$messages = $this->getData($this->app->wg->Title->getArticleId());
		
		unset($messages['lastupdate']);
	
		// resources
		// load assets related to this if there is a discussions section
		$this->response->addAsset( 'extensions/wikia/Forum/css/RelatedForumDiscussion.scss' );
		
		$content = '';
		
		// don't render anything if there are no discussions for this article
		if(empty($messages)) {
			$content = $this->app->renderView( "RelatedForumDiscussion", "zeroState" );
		} else {
			$content = $this->app->renderView( "RelatedForumDiscussion", "relatedForumDiscussion", array('messages' => $messages) );
		}
		
		$this->content = $content;
		// common data
		$this->sectionHeading = $this->wf->Msg('forum-related-discussion-heading', $this->wg->Title->getText());
		$this->newPostButton = $this->wf->Msg('forum-related-discussion-new-post-button');
		$this->newPostUrl = '#';
		$this->newPostTooltip = $this->wf->Msg('forum-related-discussion-new-post-tooltip', $this->wg->Title->getText());
		$this->blankImgUrl = $this->wf->BlankImgUrl();
	}
	
	public function relatedForumDiscussion() {
		$this->messages = $this->getVal('messages');

		// set template data
		$this->seeMoreUrl = "#";
		$this->seeMoreText = "See more";
	}
	
	public function zeroState() {
		$this->creative = $this->wf->MsgExt('forum-related-discussion-zero-state-creative', 'parseinline');
	}
	
	public function checkData() {
		$articleId = $this->getVal('articleId');
		$title = Title::newFromId($articleId);
		if(empty($articleId) || empty($title)) {
			$this->replace = false;
			$this->articleId = 	$articleId;
			return;
		}
		
		$messages = $this->getData($articleId);
		
		$timediff = time() - $messages['lastupdate'];
		
		$this->lastupdate = $messages['lastupdate'];
		$this->timediff = $timediff;
		
		unset($messages['lastupdate']);

		if($timediff < 24*60*60) {
			$this->replace = true;
			$this->html = $this->app->renderView( "RelatedForumDiscussion", "relatedForumDiscussion", array('messages' => $messages) );			
		} else {
			$this->replace = false;
			$this->html = '';
		}
		
		$this->response->setCacheValidity( 0, 0, array(WikiaResponse::CACHE_TARGET_BROWSER) );
		$this->response->setCacheValidity( 6*60*60, 6*60*60, array(WikiaResponse::CACHE_TARGET_VARNISH) );
	}

	private function getData($id) {
		return WikiaDataAccess::cache( wfMemcKey( __CLASS__, __METHOD__, $id ), 24*60*60, function($id) use $id {
			$wlp = new WallRelatedPages(); 
			$messages = $wlp->getArticlesRelatedMessgesSnippet($id, 2, 2 );			
		});
	}
	
}