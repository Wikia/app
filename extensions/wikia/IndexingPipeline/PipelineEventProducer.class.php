<?php

namespace Wikia\IndexingPipeline;

class PipelineEventProducer {
	const ARTICLE_MESSAGE_PREFIX = 'article';
	const PRODUCER_NAME = 'MWEventsProducer';
	protected static $pipe;

	/**
	 * @desc Send event to pipeline in old format (message with params inside).
	 *
	 * @param $pageId
	 * @param null $revisionId
	 * @param null $eventName
	 */
	public static function send( $eventName, $pageId, $revisionId ) {
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
	public static function sendFlaggedSyntax( $action, $pageId, $revisionId, $ns = PipelineRoutingBuilder::NS_CONTENT ) {
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
	 * @return bool
	 */
	public static function onArticleDeleteComplete( &$oPage, &$oUser, $reason, $pageId ) {
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
	 * @return bool
	 */
	public static function onArticleUndelete( \Title &$oTitle, $isNew = false ) {
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
	 * @return bool
	 */
	public static function onTitleMoveComplete( &$oOldTitle, &$oNewTitle, &$oUser, $pageId, $redirectId = 0 ) {
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

	/*
	 * Helper methods
	 */
	/** @return ConnectionBase */
	protected static function getPipeline() {
		global $wgIndexingPipeline;

		if ( !isset( self::$pipe ) ) {
			self::$pipe = new ConnectionBase( $wgIndexingPipeline );
		}

		return self::$pipe;
	}
}
