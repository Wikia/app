<?php

class PipelineEventProducer {
	const ARTICLE_MESSAGE_PREFIX = 'article';
	const PRODUCER_NAME = 'MWEventsProducer';
	const CONTENT = 'content';
	/** @var PipelineConnectionBase */
	protected static $pipe;

	/**
	 * @desc Send event to pipeline if old format.
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

	public static function nSend( $action, $id, $ns = self::CONTENT, $data = [ ], $flags = [ ] ) {
		$route = implode( '.', array_merge( [ self::PRODUCER_NAME, "_action:{$action}", "_namespace:{$ns}" ], $flags,
				// adds info about the message content
				array_map( function ( $item ) {
					return "_content:{$item}";
				}, array_keys( $data ) ) )
		);

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
		wfDebug( "IndexingPipeline:onArticleSaveComplete\n" );
		$rev = isset( $oRevision ) ? $oRevision->getId() : $oRevision;
		self::send( 'onArticleSaveComplete', $oPage->getId(),
			[ 'prevRevision' => $baseRevId, 'revision' => $rev ] );

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
		wfDebug( "IndexingPipeline:onNewRevisionFromEditComplete\n" );
		self::send( 'onNewRevisionFromEditComplete', $article->getId(),
			[ 'prevRevision' => $baseID, 'revision' => $rev->getId() ] );

		return true;
	}

	/**
	 * @desc Fires on:
	 *  - article delete
	 * @return bool
	 */
	static public function onArticleDeleteComplete( &$oPage, &$oUser, $reason, $pageId ) {
		wfDebug( "IndexingPipeline:onArticleDeleteComplete\n" );
		self::send( 'onArticleDeleteComplete', $pageId );

		return true;
	}

	/**
	 * @desc Fires on:
	 *  - article restore
	 * @return bool
	 */
	static public function onArticleUndelete( Title &$oTitle, $isNew = false ) {
		wfDebug( "IndexingPipeline:onArticleUndelete\n" );
		self::send( 'onArticleUndelete', $oTitle->getArticleId(), [ 'isNew' => $isNew ] );

		return true;
	}

	/**
	 * @desc Fires on:
	 *  - article rename
	 * @return bool
	 */
	static public function onTitleMoveComplete( &$oOldTitle, &$oNewTitle, &$oUser, $pageId, $redirectId = 0 ) {
		wfDebug( "IndexingPipeline:onTitleMoveComplete\n" );
		self::send( 'onTitleMoveComplete', $pageId, [ 'redirectId' => $redirectId ] );

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
}
