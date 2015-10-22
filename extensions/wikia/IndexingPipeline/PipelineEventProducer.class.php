<?php

class PipelineEventProducer {
	const WG_CONTENT_NAMESPACES_KEY = 'wgContentNamespaces';
	const ARTICLE_MESSAGE_PREFIX = 'article';
	const PRODUCER_NAME = 'MWEventsProducer';
	const CONTENT = 'content';
	const ACTION_CREATE = 'create';
	const ACTION_UPDATE = 'update';
	const ACTION_DELETE = 'delete';
	/** @var PipelineConnectionBase */
	protected static $pipe;

	/**
	 * @desc Send event to pipeline in old format.
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
	 * @desc Send event to pipeline in new format.
	 * @param $action
	 * @param $id
	 * @param string $ns
	 * @param array $data
	 * @param array $flags
	 */
	public static function nSend( $action, $id, $ns = self::CONTENT, $data = [ ], $flags = [ ] ) {
		$ns = strtolower($ns);
		$route = implode( '.', array_merge( [ self::PRODUCER_NAME, "_action:" . $action,  "_namespace:" . $ns ], $flags,
				// adds info about the message content
				array_map( function ( $item ) {
					return "_content:{$item}";
				}, array_keys( $data ) ) )
		);

		wfDebug($route);

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
	 * @return bool
	 */
	static public function onArticleSaveComplete( &$oPage, &$oUser, $text, $summary, $minor, $undef1, $undef2,
		&$flags, $oRevision, &$status, $baseRevId ) {
		wfDebug( __METHOD__ . "\n" );
		$ns = self::getArticleNamespace( $oPage->getTitle() );
		$action = $oRevision->getPrevious() === null ? self::ACTION_CREATE : self::ACTION_UPDATE;

		self::send( 'onArticleSaveComplete', $oPage->getId() );
		self::nSend( $action, $oPage->getId(), $ns );

		return true;
	}

	/**
	 * @desc Fires on:
	 *  - new article created
	 *  - article edit
	 *  - edition undo
	 *  - edition revert
	 *  - article rename
	 * @return bool
	 */
	static public function onNewRevisionFromEditComplete( $article, Revision $rev, $baseID, User $user ) {
		wfDebug( __METHOD__ . "\n" );
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
	static public function onArticleDeleteComplete( &$oPage, &$oUser, $reason, $pageId ) {
		wfDebug( __METHOD__ . "\n" );
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
	static public function onArticleUndelete( Title &$oTitle, $isNew = false ) {
		wfDebug( __METHOD__ . "\n" );
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
	static public function onTitleMoveComplete( &$oOldTitle, &$oNewTitle, &$oUser, $pageId, $redirectId = 0 ) {
		wfDebug( __METHOD__ . "\n" );
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
