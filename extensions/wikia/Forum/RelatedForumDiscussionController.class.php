<?php

use Wikia\Logger\WikiaLogger;

class RelatedForumDiscussionController extends WikiaController {

	/** Expiry time to use in cache requests */
	const CACHE_EXPIRY = 86400; // 24*60*60

	public function init() {

	}

	public function index() {

		$this->messages = $this->getVal( 'messages' );

		// loading assets in Monobook that would normally load in oasis
		if ( $this->app->checkSkin( 'monobook' ) ) {
			$this->response->addAsset( 'skins/shared/styles/sprite.scss' );
			$this->response->addAsset( 'extensions/wikia/Forum/css/monobook/RelatedForumMonobook.scss' );
		}

		$title = $this->getContext()->getTitle();
		$topicTitle = Title::newFromText( $title->getPrefixedText(), NS_WIKIA_FORUM_TOPIC_BOARD );

		// common data
		$this->sectionHeading = wfMessage( 'forum-related-discussion-heading', $title->getText() )->escaped();
		$this->newPostButton = wfMessage( 'forum-related-discussion-new-post-button' )->escaped();
		$this->newPostUrl = $topicTitle->getFullUrl( 'openEditor=1' );
		$this->newPostTooltip = wfMessage( 'forum-related-discussion-new-post-tooltip', $title->getText() )->escaped();
		$this->blankImgUrl = wfBlankImgUrl();

		$this->seeMoreUrl = $topicTitle->getFullUrl();
		$this->seeMoreText = wfMessage( 'forum-related-discussion-see-more' )->escaped();

		// TODO: move classes to template when Venus will be live on all wikis
		$this->venusBtnClasses = '';
		if ( $this->app->checkSkin( 'venus' ) ) {
			$this->venusBtnClasses = 'wikia-button secondary';
			Wikia::addAssetsToOutput( 'related_forum_discussion_css' );
		}
	}

	/**
	 * @deprecated legacy entry point for cached JS requests
	 */
	public function checkData() {
		$articleId = $this->getVal( 'articleId' );
		$title = Title::newFromId( $articleId );
		if ( empty( $articleId ) || empty( $title ) ) {
			$this->replace = false;
			$this->articleId = $articleId;
			return;
		}

		$messages = RelatedForumDiscussionController::getData( $articleId );

		$timediff = time() - $messages['lastupdate'];

		$this->lastupdate = $messages['lastupdate'];
		$this->timediff = $timediff;

		unset( $messages['lastupdate'] );

		if ( $timediff < 24 * 60 * 60 ) {
			$this->replace = true;
			$this->html = $this->app->renderView( "RelatedForumDiscussion", "relatedForumDiscussion", array( 'messages' => $messages ) );
		} else {
			$this->replace = false;
			$this->html = '';
		}

		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
		$this->response->setCacheValidity( 6 * 60 * 60, WikiaResponse::CACHE_DISABLED /* no caching in browser */ );
	}

	/**
	 * Purge the cache for articles related to a given thread
	 * @param int $threadId
	 */
	public static function purgeCache( $threadId ) {
		$relatedPages = new WallRelatedPages();
		$ids = $relatedPages->getMessagesRelatedArticleIds( $threadId, 'order_index', DB_MASTER );

		foreach ( $ids as $id ) {
			$key = wfMemcKey( __CLASS__, 'getData', $id );
			WikiaDataAccess::cachePurge( $key );
			// VOLDEV-46: Update module by purging page, not via AJAX
			$wikiaPage = WikiPage::newFromID( $id );
			if ( $wikiaPage ) {
				$wikiaPage->doPurge();
			} else {
				self::logError( "Found a null related wikipage on thread purge", [ "articleID" => $id, "threadID" => $threadId ] );
			}
		}
	}

	/**
	 * Fetch Forum discussions related to an article from the cache
	 * @param int $articleId MediaWiki article id
	 * @return array: Cache data
	 */
	public static function getData( $articleId ) {
		$key = wfMemcKey( __CLASS__, 'getData', $articleId );
		return WikiaDataAccess::cache( $key, self::CACHE_EXPIRY, function() use ( $articleId ) {
			$wlp = new WallRelatedPages();
			$messages = $wlp->getArticlesRelatedMessgesSnippet( $articleId, 2, 2 );
			return $messages;
		} );
	}

	private static function logError( $message, array $param = [] ) {
		WikiaLogger::instance()->error( 'RelatedForumDiscussionController: ' . $message, $param );
	}
}
