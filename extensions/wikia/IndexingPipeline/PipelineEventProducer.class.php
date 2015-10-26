<?php

class PipelineEventProducer {
	const ARTICLE_MESSAGE_PREFIX = 'article';
	const PRODUCER_NAME = 'MWEventsProducer';
	const NS_CONTENT = 'content';
	const ROUTE_ACTION_KEY = '_action';
	const ROUTE_NAMESPACE_KEY = '_namespace';
	const ROUTE_CONTENT_KEY = '_content';
	const ACTION_CREATE = 'create';
	const ACTION_UPDATE = 'update';
	const ACTION_DELETE = 'delete';
	/** @var PipelineConnectionBase */
	protected static $pipe;

	/**
	 * @desc Send event to pipeline in old format (message with params inside).
	 * @param $eventName
	 * @param $pageId
	 * @param array $params
	 */
	public static function send( $eventName, $pageId, $params = [ ] ) {
		$msgBase = self::prepareMessageData( $pageId );
		$msgBase->args = new stdClass();
		$msg = self::prepareMessageBody( $params, $msgBase->args );

		self::publish( implode( '.', [ self::ARTICLE_MESSAGE_PREFIX, $eventName ] ), $msg );
	}

	/**
	 * @desc Send event to pipeline in new format,
	 * using new action names (see function prepareRoute).
	 * @param $action
	 * @param $id
	 * @param string $ns
	 * @param array $data
	 */
	public static function sendFlaggedSyntax( $action, $id, $ns = self::NS_CONTENT, $data = [] ) {
		$route = self::prepareRoute( $action, $ns, $data);
		$msgBase = self::prepareMessageData( $id );
		$msg = self::prepareMessageBody( $data, $msgBase );

		self::publish( $route, $msg );
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
	public static function onNewRevisionFromEditComplete( $article, Revision $rev, $baseID, User $user ) {
		$ns = self::preparePageNamespaceName( $article->getTitle() );
		$action = $rev->getPrevious() === null ? self::ACTION_CREATE : self::ACTION_UPDATE;
		$id = $article->getId();

		self::send( 'onNewRevisionFromEditComplete', $id );
		self::sendFlaggedSyntax( $action, $id, $ns );

		return true;
	}

	/**
	 * @desc Fires on:
	 *  - article delete
	 * @return bool
	 */
	public static function onArticleDeleteComplete( &$oPage, &$oUser, $reason, $pageId ) {
		$ns = self::preparePageNamespaceName( $oPage->getTitle() );

		self::send( 'onArticleDeleteComplete', $pageId );
		self::sendFlaggedSyntax( self::ACTION_DELETE, $pageId, $ns );

		return true;
	}

	/**
	 * @desc Fires on:
	 *  - article restore
	 * Send ACTION_CREATE as an article with new ID is created
	 * @return bool
	 */
	public static function onArticleUndelete( Title &$oTitle, $isNew = false ) {
		$ns = self::preparePageNamespaceName( $oTitle );
		$data = [ 'isNew' => $isNew ];

		self::send( 'onArticleUndelete', $oTitle->getArticleId(), $data );
		self::sendFlaggedSyntax( self::ACTION_CREATE, $oTitle->getArticleId(), $ns, $data );

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
		$data = [ 'redirectId' => $redirectId ];

		self::send( 'onTitleMoveComplete', $pageId, $data );
		self::sendFlaggedSyntax( self::ACTION_UPDATE, $pageId, $ns, $data );

		return true;
	}

	/*
	 * Helper methods
	 */

	/**
	 * @desc create message with cityId and pageId fields
	 * @param $pageId
	 * @return \stdClass
	 */
	protected static function prepareMessageData( $pageId ) {
		global $wgCityId;
		$msg = new stdClass();
		$msg->cityId = $wgCityId;
		$msg->pageId = $pageId;

		return $msg;
	}

	/**
	 * @desc iterate over passed params and add them to message body
	 * @param $params
	 * @param $msg
	 * @return mixed
	 */
	protected static function prepareMessageBody ( $params, $msg ) {
		foreach ( $params as $param => $value ) {
			$msg->{$param} = $value;
		}

		return $msg;
	}

	/**
	 * @desc create message route
	 * @param $action
	 * @param $ns
	 * @param $data
	 * @return string message route in format:
	 * PRODUCER_NAME.ROUTE_ACTION_KEY:{action}.ROUTE_NAMESPACE_KEY:{namespace}.ROUTE_CONTENT_KEY:{items}
	 */
	public static function prepareRoute( $action, $ns, $data = [] ) {
		$contentData = [];

		//prepare info about what data can be found in the message content
		if ( !empty( array_keys( $data ) ) ) {
			$contentData = array_map( function ( $item ) {
				return self::ROUTE_CONTENT_KEY . ':' . $item;
			}, array_keys( $data ) );
		}

		$routeData = array_merge(
			[ self::PRODUCER_NAME, self::ROUTE_ACTION_KEY . ':' . $action,  self::ROUTE_NAMESPACE_KEY . ':' . $ns ],
			$contentData
		);

		$route = implode( '.', $routeData);

		return $route;
	}

	/**
	 * @param $key
	 * @param $data
	 */
	protected static function publish( $key, $data ) {
		try {
			self::getPipeline()->publish( $key, $data );
		} catch ( Exception $e ) {
			\Wikia\Logger\WikiaLogger::instance()->error( $e->getMessage() );
		}
	}

	/** @return PipelineConnectionBase */
	protected static function getPipeline() {
		if ( !isset( self::$pipe ) ) {
			self::$pipe = new PipelineConnectionBase();
		}

		return self::$pipe;
	}

	/**
	 * @desc For given page title returns it's lowerased namespace in english.
	 * Namespace CONTENT means that page is in 0 or one of the custom content namespaces.
	 * @param $title
	 * @return string lowerased english namespace
	 */
	public static function preparePageNamespaceName( $title ) {
		global $wgContentNamespaces;
		$namespaceID = $title->getNamespace();

		if ( in_array($namespaceID, $wgContentNamespaces) ) {
			$pageNamespace =  self::NS_CONTENT;
		} else {
			$pageNamespace = strtolower( MWNamespace::getCanonicalName( $namespaceID ) );
		}

		return $pageNamespace;
	}
}
