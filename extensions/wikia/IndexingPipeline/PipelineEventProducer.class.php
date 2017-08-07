<?php

namespace Wikia\IndexingPipeline;

use Title;
use User;
use Wikia\Logger\WikiaLogger;
use Wikia\Rabbit\ConnectionBase;

class PipelineEventProducer {
	const ARTICLE_MESSAGE_PREFIX = 'article';
	const PRODUCER_NAME = 'MWEventsProducer';
	protected static $pipe;

	const ARTICLECOMMENT_PREFIX = '@comment-'; // as defined in ArticleComments_setup.php

	/**
	 * Check if a given title should be indexed in solr
	 *
	 * Do not index Wall messages, Forum posts and article comments (but keep the rest of NS_TALK articles)
	 *
	 * @see SUS-1446
	 * @param \Title $title
	 * @return bool
	 */
	public static function canIndex( \Title $title ) {
		// do not index article comments, but keep talk pages
		if ( $title->inNamespace( NS_TALK ) ) {
			return strpos( $title->getText(), self::ARTICLECOMMENT_PREFIX ) === false;
		}

		return !in_array( $title->getNamespace(), self::getExcludedNamespaces() );
	}

	/**
	 * Get a list of article descendant namespaces which are not allowed to be indexed for searching:
	 *
	 * @see SUS-1446
	 * @return array
	 */
	private static function getExcludedNamespaces() {
		return [
			1201, // Message Wall
			2001, // Forum
		];
	}

	/**
	 * @desc Send event to pipeline in old format (message with params inside).
	 *
	 * @param $pageId
	 * @param null $revisionId
	 * @param null $eventName
	 */
	private static function send( $eventName, $pageId, $revisionId ) {
		WikiaLogger::instance()->info( __METHOD__, [
			'eventName' => $eventName,
			'pageId' => (string)$pageId
		] );

		self::getPipeline()->publish(
			implode( '.', [ self::ARTICLE_MESSAGE_PREFIX, $eventName ] ),
			PipelineMessageBuilder::create()
				->addWikiId()
				->addPageId( $pageId )
				->addRevisionId( $revisionId )
				->build()
		);
	}

	/**
	 * @desc Send event to pipeline in new format,
	 * using new action names (see function prepareRoute).
	 *
	 * @param $action
	 * @param $pageId
	 * @param $revisionId
	 * @param string $ns
	 */
	private static function sendFlaggedSyntax( $action, $pageId, $revisionId, $ns = PipelineRoutingBuilder::NS_CONTENT ) {
		WikiaLogger::instance()->info( __METHOD__, [
			'action' => $action,
			'pageId' => (string)$pageId
		] );

		self::getPipeline()->publish(
			PipelineRoutingBuilder::create()
				->addName( static::PRODUCER_NAME )
				->addAction( $action )
				->addNamespace( $ns )
				->build(),
			PipelineMessageBuilder::create()
				->addWikiId()
				->addPageId( $pageId )
				->addRevisionId( $revisionId )
				->build()
		);
	}

	/*
	 * Hooks handlers
	 */

	/**
	 * @desc Fires on:
	 *  - new article created
	 *  - article edit
	 *  - edition undo
	 *  - edition revert
	 *  - article rename
	 *
	 * @param \Article $article
	 * @param \Revision $rev
	 * @param $baseID
	 * @param \User $user
	 *
	 * @return bool
	 */
	public static function onNewRevisionFromEditComplete( $article, \Revision $rev, $baseID, \User $user ) {
		if ( !self::canIndex( $article->getTitle() ) ) {
			return true;
		}

		$action = $rev->getPrevious() === null ? PipelineRoutingBuilder::ACTION_CREATE
			: PipelineRoutingBuilder::ACTION_UPDATE;
		$pageId = $article->getId();
		$revisionId = $rev->getId();

		self::send( 'onNewRevisionFromEditComplete', $pageId, $revisionId );
		self::sendFlaggedSyntax( $action, $pageId, $revisionId, $article->getTitle()->getNamespace() );

		return true;
	}

	/**
	 * @desc Fires on:
	 *  - article delete
	 * @param \WikiPage $oPage
	 * @param \User $oUser
	 * @param $reason
	 * @param $pageId
	 * @return bool
	 */
	public static function onArticleDeleteComplete( \WikiPage $oPage, \User $oUser, $reason, $pageId ): bool {
		if ( !self::canIndex( $oPage->getTitle() ) ) {
			return true;
		}

		$revisionId = $oPage->getTitle()->getLatestRevID();

		self::send( 'onArticleDeleteComplete', $pageId, $revisionId );
		self::sendFlaggedSyntax(
			PipelineRoutingBuilder::ACTION_DELETE, $pageId, $revisionId, $oPage->getTitle()->getNamespace() );

		return true;
	}

	/**
	 * @desc Fires on:
	 *  - article restore
	 * Send ACTION_CREATE as an article with new ID is created
	 * @param Title $oTitle
	 * @param bool $isNew
	 * @return bool
	 */
	public static function onArticleUndelete( \Title $oTitle, $isNew = false ): bool {
		if ( !self::canIndex( $oTitle ) ) {
			return true;
		}

		$revisionId = $oTitle->getLatestRevID();

		self::send( 'onArticleUndelete', $oTitle->getArticleId(), $revisionId );
		self::sendFlaggedSyntax(
			PipelineRoutingBuilder::ACTION_CREATE, $oTitle->getArticleId(), $revisionId, $oTitle->getNamespace() );

		return true;
	}

	/**
	 * @desc Fires on:
	 *  - article rename
	 * Send ACTION_UPDATE as the ID of article remains the same only title changes
	 * @param Title $oOldTitle
	 * @param Title $oNewTitle
	 * @param User $oUser
	 * @param $pageId
	 * @param int $redirectId
	 * @return bool
	 */
	public static function onTitleMoveComplete( Title $oOldTitle, Title $oNewTitle, User $oUser, $pageId, $redirectId = 0 ): bool {
		if ( !self::canIndex( $oNewTitle ) ) {
			return true;
		}

		$revisionId = $oNewTitle->getLatestRevID();

		self::send( 'onTitleMoveComplete', $pageId, $revisionId );
		self::sendFlaggedSyntax(
			PipelineRoutingBuilder::ACTION_UPDATE, $pageId, $revisionId, $oNewTitle->getNamespace() );

		return true;
	}

	/**
	 * @desc Fires on:
	 *  - successful save from TemplateClassificationApiController
	 *  - successful classification of parent template during draft creation
	 *
	 * @param integer $pageId The affected template's pageId
	 * @param \Title $title The affected template's Title object
	 * @param $templateType
	 *
	 * @return bool
	 */
	public static function onTemplateClassified( $pageId, \Title $title, $templateType ) {
		// there is purposedly no legacy (unflagged) event sent here
		self::sendFlaggedSyntax(
			PipelineRoutingBuilder::ACTION_UPDATE, $pageId, $title->getLatestRevID(), $title->getNamespace() );

		return true;
	}

	/**
	 * @desc Fires on:
	 *  - successful wiki creation
	 *
	 * @param integer $cityId new wiki id
	 * @param string $starter starter db name
	 *
	 * @return bool
	 */
	public static function onAfterWikiCreated( $cityId, $starter ) {
		static::getPipeline()->publish(
			PipelineRoutingBuilder::create()
				->addName( static::PRODUCER_NAME )
				->addType( PipelineRoutingBuilder::TYPE_WIKIA )
				->addAction( PipelineRoutingBuilder::ACTION_CREATE )
				->build(),
			PipelineMessageBuilder::create()
				->addWikiId( $cityId )
				->addParam( 'starterId', \WikiFactory::DBtoID( $starter ) )
				->build()
		);

		return true;
	}

	/**
	 * @desc run on maintanence script - reindex wiki
	 * @param Title $title
	 * @return void
	 */
	public static function reindexPage( Title $title ) {
		if ( !self::canIndex( $title ) ) {
			return;
		};
		$pageId = $title->getArticleID();

		WikiaLogger::instance()->info( __METHOD__, [
			'eventName' => "reindex",
			'pageId' => (string)$pageId
		] );

		global $wgCityId;
		self::getPipeline()->publish( 'reindex',
			PipelineMessageBuilder::create()
				->addParam("wiki_id", $wgCityId)
				->addParam("article_id", $pageId)
				->build()
		);
	}

	/*
	 * Helper methods
	 */
	/** @return \Wikia\Rabbit\ConnectionBase */
	protected static function getPipeline() {
		global $wgIndexingPipeline;

		if ( !isset( self::$pipe ) ) {
			self::$pipe = new ConnectionBase( $wgIndexingPipeline );
		}

		return self::$pipe;
	}
}
