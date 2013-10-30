<?php
class RelatedForumDiscussionController extends WikiaController {

	public function init() {

	}

	public function index() {

		$messages = $this->getData($this->app->wg->Title->getArticleId());

		unset($messages['lastupdate']);

		// loading assets in Monobook that would normally load in oasis
		if($this->app->checkSkin('monobook')) {
			$this->response->addAsset( 'skins/oasis/css/core/sprite.scss' );
			$this->response->addAsset( 'extensions/wikia/Forum/css/RelatedForumDiscussion.scss' );
			$this->response->addAsset( 'extensions/wikia/Forum/js/RelatedForumDiscussion.js' );
		}

		$content = '';

		// don't render anything if there are no discussions for this article
		if(empty($messages)) {
			$content = $this->app->renderView( "RelatedForumDiscussion", "zeroState" );
		} else {
			$content = $this->app->renderView( "RelatedForumDiscussion", "relatedForumDiscussion", array('messages' => $messages) );
		}

		$this->content = $content;
		// common data
		$this->sectionHeading = wfMessage( 'forum-related-discussion-heading', $this->wg->Title->getText() )->escaped();
		$this->newPostButton = wfMessage( 'forum-related-discussion-new-post-button' )->escaped();
		$topicTitle = Title::newFromText( $this->wg->Title->getPrefixedText(), NS_WIKIA_FORUM_TOPIC_BOARD );
		$this->newPostUrl = $topicTitle->getFullUrl('openEditor=1');
		$this->newPostTooltip = wfMessage( 'forum-related-discussion-new-post-tooltip', $this->wg->Title->getText() )->escaped();
		$this->blankImgUrl = wfBlankImgUrl();
	}

	public function relatedForumDiscussion() {
		$this->messages = $this->getVal('messages');

		// set template data
		$topicTitle = Title::newFromText( $this->wg->Title->getPrefixedText(), NS_WIKIA_FORUM_TOPIC_BOARD );
		$this->seeMoreUrl = $topicTitle->getFullUrl();
		$this->seeMoreText = wfMessage( 'forum-related-discussion-see-more' )->escaped();
	}

	public function zeroState() {
		$this->creative = wfMessage( 'forum-related-discussion-zero-state-creative' )->parse();
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

	private function getData($id) {
		$key = wfMemcKey( __CLASS__, 'getData', $id );
		return WikiaDataAccess::cache( $key, 24*60*60, function() use ($id) {
			$wlp = new WallRelatedPages();
			$messages = $wlp->getArticlesRelatedMessgesSnippet($id, 2, 2 );
			return $messages;
		});
	}

}
