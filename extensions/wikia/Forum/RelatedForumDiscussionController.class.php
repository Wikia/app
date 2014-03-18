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

    /**
     * Purge the cache for articles related to a given thread
     * @param int $threadId
     */
    public static function purgeCache( $threadId ) {
		$rm = new WallRelatedPages();
		$ids = $rm->getMessagesRelatedArticleIds($threadId, 'order_index', DB_MASTER);

		foreach($ids as $id) {
			$key = wfMemcKey( __CLASS__, 'getData', $id );
			WikiaDataAccess::cachePurge($key);
            // VOLDEV-46: Update module by purging page, not via AJAX
            WikiPage::newFromID( $id )->doPurge();
		}
	}

    /**
     * Fetch Forum discussions related to an article from the cache
     * @param int $articleId MediaWiki article id
     * @return array: Cache data
     */
	public static function getData( $articleId ) {
		$key = wfMemcKey( __CLASS__, 'getData', $articleId );
		return WikiaDataAccess::cache( $key, 24*60*60, function() use ( $articleId ) {
			$wlp = new WallRelatedPages();
			$messages = $wlp->getArticlesRelatedMessgesSnippet( $articleId, 2, 2 );
			return $messages;
		});
	}
}
