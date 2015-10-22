<?php

class PipelineEventProducer {
	const WG_CONTENT_NAMESPACES_KEY = 'wgContentNamespaces';
	const ARTICLE_MESSAGE_PREFIX = 'article';
	const PRODUCER_NAME = 'MWEventsProducer';
	const CONTENT = 'content';
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
		$msg = self::prepareMessage( $pageId );
		$msg->args = new stdClass();
		foreach ( $params as $param => $value ) {
			$msg->args->{$param} = $value;
		}
		self::publish( implode( '.', [ self::ARTICLE_MESSAGE_PREFIX, $eventName ] ), $msg );
	}

	/**
	 * @desc Send event to pipeline in new format (with flags, see function prepareRoute).
	 * @param $action
	 * @param $id
	 * @param string $ns
	 * @param array $data
	 * @param array $flags
	 */
	public static function nSend( $action, $id, $ns = self::CONTENT, $data = [ ], $flags = [ ] ) {
		$route = self::prepareRoute( $action, $ns, $flags, $data);
		$msg = self::prepareMessage( $id );
		foreach ( $data as $key => $value ) {
			$msg->{$key} = $value;
		}

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
		$ns = self::getArticleNamespace( $article->getTitle() );
		$action = $rev->getPrevious() === null ? self::ACTION_CREATE : self::ACTION_UPDATE;

		self::send( 'onNewRevisionFromEditComplete', $article->getId() );
		self::nSend( $action, $article->getId(), $ns );

		return true;
	}

	/**
	 * @desc Fires on:
	 *  - article delete
	 * @return bool
	 */
	public static function onArticleDeleteComplete( &$oPage, &$oUser, $reason, $pageId ) {
		$ns = self::getArticleNamespace( $oPage->getTitle() );

		self::send( 'onArticleDeleteComplete', $pageId );
		self::nSend( self::ACTION_DELETE, $pageId, $ns );

		return true;
	}

	/**
	 * @desc Fires on:
	 *  - article restore
	 * Send ACTION_CREATE as an article with new ID is created
	 * @return bool
	 */
	public static function onArticleUndelete( Title &$oTitle, $isNew = false ) {
		$ns = self::getArticleNamespace( $oTitle );

		self::send( 'onArticleUndelete', $oTitle->getArticleId(), [ 'isNew' => $isNew ] );
		self::nSend( self::ACTION_CREATE, $oTitle->getArticleId(), $ns, [ 'isNew' => $isNew ] );

		return true;
	}

	/**
	 * @desc Fires on:
	 *  - article rename
	 * Send ACTION_UPDATE as the ID of article remains the same only title changes
	 * @return bool
	 */
	public static function onTitleMoveComplete( &$oOldTitle, &$oNewTitle, &$oUser, $pageId, $redirectId = 0 ) {
		$ns = self::getArticleNamespace( $oNewTitle );

		self::send( 'onTitleMoveComplete', $pageId, [ 'redirectId' => $redirectId ] );
		self::nSend( self::ACTION_UPDATE, $pageId, $ns, [ 'redirectId' => $redirectId ] );

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
	protected static function prepareMessage( $pageId ) {
		global $wgCityId;
		$msg = new stdClass();
		$msg->cityId = $wgCityId;
		$msg->pageId = $pageId;

		return $msg;
	}

	/**
	 * @desc create message route
	 * @param $action
	 * @param $ns
	 * @param $flags
	 * @param $data
	 * @return string message route in format:
	 * PRODUCER_NAME.ROUTE_ACTION_KEY:{action}.ROUTE_NAMESPACE_KEY:{namespace}.ROUTE_CONTENT_KEY:{items}
	 */
	protected static function prepareRoute( $action, $ns, $flags, $data ) {
		$ns = strtolower($ns);
		$route = implode( '.', array_merge( [ self::PRODUCER_NAME, self::ROUTE_ACTION_KEY . $action,  self::ROUTE_NAMESPACE_KEY . $ns ], $flags,
				// adds info about the message content
				array_map( function ( $item ) {
					return self::ROUTE_CONTENT_KEY . $item;
				}, array_keys( $data ) ) )
		);

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

	protected static function getArticleNamespace( $title ) {
		global $wgCityId;

		$pageNamespace = $title->getNamespace();
		$contentNamespaces = WikiFactory::getVarValueByName( self::WG_CONTENT_NAMESPACES_KEY, $wgCityId );
		if ( in_array($pageNamespace, $contentNamespaces) ) {
			$pageNamespace =  self::CONTENT;
		} else {
			$pageNamespace = $title->getNsText();
		}

		return $pageNamespace;
	}
}
