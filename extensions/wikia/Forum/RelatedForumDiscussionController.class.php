<?php
class RelatedForumDiscussionController extends WikiaController {

	public function init() {

	}

	public function index() {

		$this->messages = $this->getVal( 'messages' );

		// loading assets in Monobook that would normally load in oasis
		if($this->app->checkSkin('monobook')) {
			$this->response->addAsset( 'skins/oasis/css/core/sprite.scss' );
			$this->response->addAsset( 'extensions/wikia/Forum/css/RelatedForumDiscussion.scss' );
			$this->response->addAsset( 'extensions/wikia/Forum/js/RelatedForumDiscussion.js' );
		}

		$title = $this->getContext()->getTitle();
		$topicTitle = Title::newFromText( $title->getPrefixedText(), NS_WIKIA_FORUM_TOPIC_BOARD );

		// common data
		$this->sectionHeading = wfMessage( 'forum-related-discussion-heading', $title->getText() )->escaped();
		$this->newPostButton = wfMessage( 'forum-related-discussion-new-post-button' )->escaped();
		$this->newPostUrl = $topicTitle->getFullUrl('openEditor=1');
		$this->newPostTooltip = wfMessage( 'forum-related-discussion-new-post-tooltip', $title->getText() )->escaped();
		$this->blankImgUrl = wfBlankImgUrl();

		$this->seeMoreUrl = $topicTitle->getFullUrl();
		$this->seeMoreText = wfMessage( 'forum-related-discussion-see-more' )->escaped();
	}

	public function checkData() {
		$articleId = $this->getVal('articleId');
		$title = Title::newFromId($articleId);
		if(empty($articleId) || empty($title)) {
			$this->replace = false;
			$this->articleId = 	$articleId;
			return;
		}

		$messages = $this->app->sendRequest( 'RelatedForumDiscussion', 'getData', array( 'articleId' => $articleId ) )->getData()['data'];

		$timediff = time() - $messages['lastupdate'];

		$this->lastupdate = $messages['lastupdate'];
		$this->timediff = $timediff;

		unset($messages['lastupdate']);

		if($timediff < 24*60*60) {
			$this->replace = true;
			$this->html = $this->app->renderView( "RelatedForumDiscussion", "index", array( 'messages' => $messages ) );
		} else {
			$this->replace = false;
			$this->html = '';
		}

		$this->response->setCacheValidity( 6*60*60, WikiaResponse::CACHE_DISABLED /* no caching in browser */ );
	}

	public function purgeCache() {
		$threadId = $this->getVal('threadId');

		$rm = new WallRelatedPages();
		$ids = $rm->getMessagesRelatedArticleIds($threadId, 'order_index', DB_MASTER);
		$requestsParams = array();

		foreach($ids as $id) {
			$key = wfMemcKey( __CLASS__, 'getData', $id );
			WikiaDataAccess::cachePurge($key);
			$requestsParams[] = array('articleId' => $id);
		}

		RelatedForumDiscussionController::purgeMethodVariants('checkData', $requestsParams);
	}

	public function getData() {
		$articleId = $this->getVal( 'articleId' );
		$key = wfMemcKey( __CLASS__, 'getData', $articleId );
		$this->data = WikiaDataAccess::cache( $key, 24*60*60, function() use ( $articleId ) {
			$wlp = new WallRelatedPages();
			$messages = $wlp->getArticlesRelatedMessgesSnippet( $articleId, 2, 2 );
			return $messages;
		});
	}

}
