<?php

namespace Wikia\IndexingPipeline;

class PipelineEventProducer {
	const ARTICLE_MESSAGE_PREFIX = 'article';
	const NS_CONTENT = 'content';
	const ROUTE_ACTION_KEY = '_action';
	const ROUTE_NAMESPACE_KEY = '_namespace';
	const ROUTE_CONTENT_KEY = '_content';
	const ACTION_CREATE = 'create';
	const ACTION_UPDATE = 'update';
	const ACTION_DELETE = 'delete';

	const PRODUCER_NAME = 'MWEventsProducer';
	protected static $pipe;

	/**
	 * @desc Send event to pipeline in old format (message with params inside).
	 *
	 * @param $pageId
	 * @param null $revisionId
	 * @param null $eventName
	 * @param array $params
	 */
	public static function send( $eventName, $pageId, $revisionId, $params = [ ] ) {
		self::getPipeline()->publish(
			implode( '.', [ self::ARTICLE_MESSAGE_PREFIX, $eventName ] ),
			self::prepareMessage( $pageId, $revisionId, $params )
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
	 * @param array $data
	 */
	public static function sendFlaggedSyntax( $action, $pageId, $revisionId, $ns = self::NS_CONTENT, $data = [ ] ) {
		self::getPipeline()->publish(
			self::prepareRoute( $action, $ns, $data ),
			self::prepareMessage( $pageId, $revisionId, $data )
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
	 * @return bool
	 */
	public static function onNewRevisionFromEditComplete( $article, \Revision $rev, $baseID, \User $user ) {
		$ns = self::preparePageNamespaceName( $article->getTitle() );
		$action = $rev->getPrevious() === null ? self::ACTION_CREATE : self::ACTION_UPDATE;
		$pageId = $article->getId();
		$revisionId = $rev->getId();

		self::send( 'onNewRevisionFromEditComplete', $pageId, $revisionId );
		self::sendFlaggedSyntax( $action, $pageId, $revisionId, $ns );

		return true;
	}

	/**
	 * @desc Fires on:
	 *  - article delete
	 * @return bool
	 */
	public static function onArticleDeleteComplete( &$oPage, &$oUser, $reason, $pageId ) {
		$ns = self::preparePageNamespaceName( $oPage->getTitle() );
		$revisionId = $oPage->getTitle()->getLatestRevID();

		self::send( 'onArticleDeleteComplete', $pageId, $revisionId );
		self::sendFlaggedSyntax( self::ACTION_DELETE, $pageId, $revisionId, $ns );

		return true;
	}

	/**
	 * @desc Fires on:
	 *  - article restore
	 * Send ACTION_CREATE as an article with new ID is created
	 * @return bool
	 */
	public static function onArticleUndelete( \Title &$oTitle, $isNew = false ) {
		$ns = self::preparePageNamespaceName( $oTitle );
		$revisionId = $oTitle->getLatestRevID();

		self::send( 'onArticleUndelete', $oTitle->getArticleId(), $revisionId );
		self::sendFlaggedSyntax( self::ACTION_CREATE, $oTitle->getArticleId(), $revisionId, $ns );

		return true;
	}

	/**
	 * @desc Fires on:
	 *  - article rename
	 * Send ACTION_UPDATE as the ID of article remains the same only title changes
	 * @return bool
	 */
	public static function onTitleMoveComplete( &$oOldTitle, &$oNewTitle, &$oUser, $pageId, $redirectId = 0 ) {
		$ns = self::preparePageNamespaceName( $oNewTitle );
		$revisionId = $oNewTitle->getLatestRevID();

		self::send( 'onTitleMoveComplete', $pageId, $revisionId );
		self::sendFlaggedSyntax( self::ACTION_UPDATE, $pageId, $revisionId, $ns );

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
	 * @return bool
	 */
	public static function onTemplateClassified ( $pageId, \Title $title, $templateType ) {
		$ns = self::preparePageNamespaceName( $title );
		$revisionId = $title->getLatestRevID();

		// there is purposedly no legacy (unflagged) event sent here
		self::sendFlaggedSyntax( self::ACTION_UPDATE, $pageId, $revisionId, $ns );

		return true;
	}

	/*
	 * Helper methods
	 */

	/**
	 * @desc create message with cityId and pageId fields
	 *
	 * @param $pageId
	 * @param $revisionId
	 *
	 * @param $params
	 * @return \stdClass
	 */
	protected static function prepareMessage( $pageId, $revisionId, $params ) {
		global $wgCityId;
		$msg = new \stdClass();
		$msg->cityId = $wgCityId;
		$msg->pageId = $pageId;
		$msg->revisionId = $revisionId;

		foreach ( $params as $param => $value ) {
			$msg->{$param} = $value;
		}

		return $msg;
	}

	/**
	 * @desc create message route
	 *
	 * @param $action
	 * @param $ns
	 * @param $data
	 *
	 * @return string message route in format:
	 * PRODUCER_NAME.ROUTE_ACTION_KEY:{action}.ROUTE_NAMESPACE_KEY:{namespace}.ROUTE_CONTENT_KEY:{items}
	 */
	public static function prepareRoute( $action, $ns, $data = [ ] ) {
		$contentData = [ ];

		//prepare info about what data can be found in the message content
		if ( !empty( array_keys( $data ) ) ) {
			$contentData = array_map( function ( $item ) {
				return self::ROUTE_CONTENT_KEY . ':' . $item;
			}, array_keys( $data ) );
		}

		$routeData = array_merge(
			[ self::PRODUCER_NAME, self::ROUTE_ACTION_KEY . ':' . $action, self::ROUTE_NAMESPACE_KEY . ':' . $ns ],
			$contentData
		);

		$route = implode( '.', $routeData );

		return $route;
	}

	/** @return ConnectionBase */
	protected static function getPipeline() {
		global $wgIndexingPipeline;

		if ( !isset( self::$pipe ) ) {
			self::$pipe = new ConnectionBase( $wgIndexingPipeline );
		}

		return self::$pipe;
	}

	/**
	 * @desc For given page title returns it's lowerased namespace in english.
	 * Namespace CONTENT means that page is in 0 or one of the custom content namespaces.
	 *
	 * @param $title
	 *
	 * @return string lowerased english namespace
	 */
	public static function preparePageNamespaceName( $title ) {
		global $wgContentNamespaces;
		$namespaceID = $title->getNamespace();

		if ( in_array( $namespaceID, $wgContentNamespaces ) ) {
			$pageNamespace = self::NS_CONTENT;
		} else {
			$pageNamespace = strtolower( \MWNamespace::getCanonicalName( $namespaceID ) );
		}

		return $pageNamespace;
	}
}
